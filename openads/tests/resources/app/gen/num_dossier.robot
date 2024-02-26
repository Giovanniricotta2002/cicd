*** Settings ***
Documentation    CRUD de la table num_dossier
...    @author  generated
...    @package openADS
...    @version 17/03/2020 15:03

*** Keywords ***

Depuis le contexte Numéro dossier
    [Documentation]  Accède au formulaire
    [Arguments]  ${num_dossier}

    # On accède au tableau
    Go To Tab  num_dossier
    # On recherche l'enregistrement
    Use Simple Search  Numéro dossier  ${num_dossier}
    # On clique sur le résultat
    Click On Link  ${num_dossier}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Numéro dossier
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  num_dossier
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Numéro dossier  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${num_dossier} =  Get Text  css=div.form-content span#num_dossier
    # On le retourne
    [Return]  ${num_dossier}

Modifier Numéro dossier
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${num_dossier}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Numéro dossier  ${num_dossier}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  num_dossier  modifier
    # On saisit des valeurs
    Saisir Numéro dossier  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Numéro dossier
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${num_dossier}

    # On accède à l'enregistrement
    Depuis le contexte Numéro dossier  ${num_dossier}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  num_dossier  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Numéro dossier
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "ref" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "petition" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "total_pages" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pa3a4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pa0" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_depot" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "num_bordereau" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "datenum" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "num_commande" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire