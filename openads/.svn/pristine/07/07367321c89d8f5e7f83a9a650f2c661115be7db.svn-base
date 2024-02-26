*** Settings ***
Documentation    CRUD de la table phase
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte phase
    [Documentation]  Accède au formulaire
    [Arguments]  ${phase}

    # On accède au tableau
    Go To Tab  phase
    # On recherche l'enregistrement
    Use Simple Search  phase  ${phase}
    # On clique sur le résultat
    Click On Link  ${phase}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter phase
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  phase
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir phase  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${phase} =  Get Text  css=div.form-content span#phase
    # On le retourne
    [Return]  ${phase}

Modifier phase
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${phase}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte phase  ${phase}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  phase  modifier
    # On saisit des valeurs
    Saisir phase  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer phase
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${phase}

    # On accède à l'enregistrement
    Depuis le contexte phase  ${phase}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  phase  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir phase
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire