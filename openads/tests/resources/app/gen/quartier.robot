*** Settings ***
Documentation    CRUD de la table quartier
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte quartier
    [Documentation]  Accède au formulaire
    [Arguments]  ${quartier}

    # On accède au tableau
    Go To Tab  quartier
    # On recherche l'enregistrement
    Use Simple Search  quartier  ${quartier}
    # On clique sur le résultat
    Click On Link  ${quartier}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter quartier
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  quartier
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir quartier  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${quartier} =  Get Text  css=div.form-content span#quartier
    # On le retourne
    [Return]  ${quartier}

Modifier quartier
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${quartier}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte quartier  ${quartier}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  quartier  modifier
    # On saisit des valeurs
    Saisir quartier  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer quartier
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${quartier}

    # On accède à l'enregistrement
    Depuis le contexte quartier  ${quartier}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  quartier  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir quartier
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "arrondissement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "code_impots" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire