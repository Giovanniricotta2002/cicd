*** Settings ***
Documentation    CRUD de la table consultation
...    @author  generated
...    @package openADS
...    @version 23/10/2018 13:10

*** Keywords ***

Depuis le contexte consultation
    [Documentation]  Accède au formulaire
    [Arguments]  ${consultation}

    # On accède au tableau
    Go To Tab  consultation
    # On recherche l'enregistrement
    Use Simple Search  consultation  ${consultation}
    # On clique sur le résultat
    Click On Link  ${consultation}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter consultation
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  consultation
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir consultation  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${consultation} =  Get Text  css=div.form-content span#consultation
    # On le retourne
    [Return]  ${consultation}

Modifier consultation
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${consultation}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte consultation  ${consultation}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  consultation  modifier
    # On saisit des valeurs
    Saisir consultation  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer consultation
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${consultation}

    # On accède à l'enregistrement
    Depuis le contexte consultation  ${consultation}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  consultation  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir consultation
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_envoi" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_retour" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_limite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "service" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "avis_consultation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_reception" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "motivation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "fichier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "code_barres" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_fichier_consultation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_final_consultation" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "marque" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "visible" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_fichier_consultation_dossier_final" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "fichier_dossier_final" existe dans "${values}" on execute "Set Checkbox" dans le formulaire