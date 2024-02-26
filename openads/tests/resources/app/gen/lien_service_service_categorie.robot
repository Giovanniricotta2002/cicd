*** Settings ***
Documentation    CRUD de la table lien_service_service_categorie
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte lien service/service catégorie
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_service_service_categorie}

    # On accède au tableau
    Go To Tab  lien_service_service_categorie
    # On recherche l'enregistrement
    Use Simple Search  lien service/service catégorie  ${lien_service_service_categorie}
    # On clique sur le résultat
    Click On Link  ${lien_service_service_categorie}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien service/service catégorie
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_service_service_categorie
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien service/service catégorie  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_service_service_categorie} =  Get Text  css=div.form-content span#lien_service_service_categorie
    # On le retourne
    [Return]  ${lien_service_service_categorie}

Modifier lien service/service catégorie
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_service_service_categorie}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien service/service catégorie  ${lien_service_service_categorie}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_service_service_categorie  modifier
    # On saisit des valeurs
    Saisir lien service/service catégorie  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien service/service catégorie
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_service_service_categorie}

    # On accède à l'enregistrement
    Depuis le contexte lien service/service catégorie  ${lien_service_service_categorie}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_service_service_categorie  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien service/service catégorie
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "service_categorie" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "service" existe dans "${values}" on execute "Select From List By Label" dans le formulaire