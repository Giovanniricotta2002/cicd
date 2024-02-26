*** Settings ***
Documentation    CRUD de la table dossier_commission
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte dossier_commission
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_commission}

    # On accède au tableau
    Go To Tab  dossier_commission
    # On recherche l'enregistrement
    Use Simple Search  dossier_commission  ${dossier_commission}
    # On clique sur le résultat
    Click On Link  ${dossier_commission}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter dossier_commission
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_commission
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir dossier_commission  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_commission} =  Get Text  css=div.form-content span#dossier_commission
    # On le retourne
    [Return]  ${dossier_commission}

Modifier dossier_commission
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_commission}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte dossier_commission  ${dossier_commission}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_commission  modifier
    # On saisit des valeurs
    Saisir dossier_commission  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer dossier_commission
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_commission}

    # On accède à l'enregistrement
    Depuis le contexte dossier_commission  ${dossier_commission}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_commission  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir dossier_commission
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "commission_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_souhaitee" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "motivation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "commission" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "avis" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire