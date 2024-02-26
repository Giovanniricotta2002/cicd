*** Settings ***
Documentation    CRUD de la table blocnote
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte bloc-note
    [Documentation]  Accède au formulaire
    [Arguments]  ${blocnote}

    # On accède au tableau
    Go To Tab  blocnote
    # On recherche l'enregistrement
    Use Simple Search  bloc-note  ${blocnote}
    # On clique sur le résultat
    Click On Link  ${blocnote}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter bloc-note
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  blocnote
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir bloc-note  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${blocnote} =  Get Text  css=div.form-content span#blocnote
    # On le retourne
    [Return]  ${blocnote}

Modifier bloc-note
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${blocnote}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte bloc-note  ${blocnote}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  blocnote  modifier
    # On saisit des valeurs
    Saisir bloc-note  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer bloc-note
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${blocnote}

    # On accède à l'enregistrement
    Depuis le contexte bloc-note  ${blocnote}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  blocnote  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir bloc-note
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "categorie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "note" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire