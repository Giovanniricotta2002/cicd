*** Settings ***
Documentation    CRUD de la table division
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte division
    [Documentation]  Accède au formulaire
    [Arguments]  ${division}

    # On accède au tableau
    Go To Tab  division
    # On recherche l'enregistrement
    Use Simple Search  division  ${division}
    # On clique sur le résultat
    Click On Link  ${division}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter division
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  division
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir division  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${division} =  Get Text  css=div.form-content span#division
    # On le retourne
    [Return]  ${division}

Modifier division
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${division}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte division  ${division}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  division  modifier
    # On saisit des valeurs
    Saisir division  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer division
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${division}

    # On accède à l'enregistrement
    Depuis le contexte division  ${division}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  division  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir division
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "chef" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "direction" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire