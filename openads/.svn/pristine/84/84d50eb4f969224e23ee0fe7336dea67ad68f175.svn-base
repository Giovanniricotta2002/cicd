*** Settings ***
Documentation    CRUD de la table arrondissement
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte arrondissement
    [Documentation]  Accède au formulaire
    [Arguments]  ${arrondissement}

    # On accède au tableau
    Go To Tab  arrondissement
    # On recherche l'enregistrement
    Use Simple Search  arrondissement  ${arrondissement}
    # On clique sur le résultat
    Click On Link  ${arrondissement}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter arrondissement
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  arrondissement
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir arrondissement  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${arrondissement} =  Get Text  css=div.form-content span#arrondissement
    # On le retourne
    [Return]  ${arrondissement}

Modifier arrondissement
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${arrondissement}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte arrondissement  ${arrondissement}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  arrondissement  modifier
    # On saisit des valeurs
    Saisir arrondissement  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer arrondissement
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${arrondissement}

    # On accède à l'enregistrement
    Depuis le contexte arrondissement  ${arrondissement}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  arrondissement  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir arrondissement
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code_postal" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code_impots" existe dans "${values}" on execute "Input Text" dans le formulaire