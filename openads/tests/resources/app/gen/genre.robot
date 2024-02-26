*** Settings ***
Documentation    CRUD de la table genre
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte genre
    [Documentation]  Accède au formulaire
    [Arguments]  ${genre}

    # On accède au tableau
    Go To Tab  genre
    # On recherche l'enregistrement
    Use Simple Search  genre  ${genre}
    # On clique sur le résultat
    Click On Link  ${genre}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter genre
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  genre
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir genre  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${genre} =  Get Text  css=div.form-content span#genre
    # On le retourne
    [Return]  ${genre}

Modifier genre
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${genre}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte genre  ${genre}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  genre  modifier
    # On saisit des valeurs
    Saisir genre  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer genre
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${genre}

    # On accède à l'enregistrement
    Depuis le contexte genre  ${genre}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  genre  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir genre
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire