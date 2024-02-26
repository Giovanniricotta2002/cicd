*** Settings ***
Documentation    CRUD de la table service_categorie
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte service catégorie
    [Documentation]  Accède au formulaire
    [Arguments]  ${service_categorie}

    # On accède au tableau
    Go To Tab  service_categorie
    # On recherche l'enregistrement
    Use Simple Search  service catégorie  ${service_categorie}
    # On clique sur le résultat
    Click On Link  ${service_categorie}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter service catégorie
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  service_categorie
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir service catégorie  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${service_categorie} =  Get Text  css=div.form-content span#service_categorie
    # On le retourne
    [Return]  ${service_categorie}

Modifier service catégorie
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${service_categorie}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte service catégorie  ${service_categorie}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  service_categorie  modifier
    # On saisit des valeurs
    Saisir service catégorie  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer service catégorie
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${service_categorie}

    # On accède à l'enregistrement
    Depuis le contexte service catégorie  ${service_categorie}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  service_categorie  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir service catégorie
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire