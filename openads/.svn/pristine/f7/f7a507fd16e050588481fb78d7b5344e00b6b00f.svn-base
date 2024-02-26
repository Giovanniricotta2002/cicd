*** Settings ***
Documentation    CRUD de la table storage
...    @author  generated
...    @package openADS
...    @version 27/06/2019 10:06

*** Keywords ***

Depuis le contexte storage
    [Documentation]  Accède au formulaire
    [Arguments]  ${storage}

    # On accède au tableau
    Go To Tab  storage
    # On recherche l'enregistrement
    Use Simple Search  storage  ${storage}
    # On clique sur le résultat
    Click On Link  ${storage}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter storage
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  storage
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir storage  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${storage} =  Get Text  css=div.form-content span#storage
    # On le retourne
    [Return]  ${storage}

Modifier storage
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${storage}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte storage  ${storage}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  storage  modifier
    # On saisit des valeurs
    Saisir storage  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer storage
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${storage}

    # On accède à l'enregistrement
    Depuis le contexte storage  ${storage}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  storage  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir storage
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "creation_date" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "creation_time" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "uid" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "filename" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "size" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "mimetype" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "info" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire