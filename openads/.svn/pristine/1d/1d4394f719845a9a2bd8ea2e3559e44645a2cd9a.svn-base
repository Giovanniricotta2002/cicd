*** Settings ***
Documentation    CRUD de la table motif_consultation
...    @author  generated
...    @package openADS
...    @version 18/03/2022 19:03

*** Keywords ***

Depuis le contexte motif de consultation
    [Documentation]  Accède au formulaire
    [Arguments]  ${motif_consultation}

    # On accède au tableau
    Go To Tab  motif_consultation
    # On recherche l'enregistrement
    Use Simple Search  motif de consultation  ${motif_consultation}
    # On clique sur le résultat
    Click On Link  ${motif_consultation}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter motif de consultation
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  motif_consultation
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir motif de consultation  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${motif_consultation} =  Get Text  css=div.form-content span#motif_consultation
    # On le retourne
    [Return]  ${motif_consultation}

Modifier motif de consultation
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${motif_consultation}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte motif de consultation  ${motif_consultation}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  motif_consultation  modifier
    # On saisit des valeurs
    Saisir motif de consultation  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer motif de consultation
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${motif_consultation}

    # On accède à l'enregistrement
    Depuis le contexte motif de consultation  ${motif_consultation}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  motif_consultation  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir motif de consultation
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "notification_email" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "delai_type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "delai" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "consultation_papier" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "type_consultation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_etat" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "service_type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "generate_edition" existe dans "${values}" on execute "Set Checkbox" dans le formulaire