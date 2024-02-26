*** Settings ***
Documentation    CRUD de la table document_numerise_type_categorie
...    @author  generated
...    @package openADS
...    @version 17/04/2020 11:04

*** Keywords ***

Depuis le contexte Catégorie de pièces
    [Documentation]  Accède au formulaire
    [Arguments]  ${document_numerise_type_categorie}

    # On accède au tableau
    Go To Tab  document_numerise_type_categorie
    # On recherche l'enregistrement
    Use Simple Search  Catégorie de pièces  ${document_numerise_type_categorie}
    # On clique sur le résultat
    Click On Link  ${document_numerise_type_categorie}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Catégorie de pièces
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  document_numerise_type_categorie
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Catégorie de pièces  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${document_numerise_type_categorie} =  Get Text  css=div.form-content span#document_numerise_type_categorie
    # On le retourne
    [Return]  ${document_numerise_type_categorie}

Modifier Catégorie de pièces
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${document_numerise_type_categorie}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Catégorie de pièces  ${document_numerise_type_categorie}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  document_numerise_type_categorie  modifier
    # On saisit des valeurs
    Saisir Catégorie de pièces  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Catégorie de pièces
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${document_numerise_type_categorie}

    # On accède à l'enregistrement
    Depuis le contexte Catégorie de pièces  ${document_numerise_type_categorie}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  document_numerise_type_categorie  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Catégorie de pièces
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire