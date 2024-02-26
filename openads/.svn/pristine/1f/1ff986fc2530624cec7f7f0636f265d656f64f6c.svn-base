*** Settings ***
Documentation  Actions spécifiques aux catégories de pièce.

*** Keywords ***

Depuis le contexte de la catégorie de pièces
    [Documentation]  Accède au formulaire
    [Arguments]  ${document_numerise_type_categorie}

    # On accède au tableau
    Depuis le listing  document_numerise_type_categorie
    # On recherche l'enregistrement
    Use Simple Search  Tous  ${document_numerise_type_categorie}
    # On clique sur le résultat
    Click On Link  ${document_numerise_type_categorie}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter la catégorie de pièces
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  document_numerise_type_categorie
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir la catégorie de pièces  ${values}
    # On valide le formulaire
    Click On Submit Button

Modifier la catégorie de pièces
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${document_numerise_type_categorie}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte de la catégorie de pièces  ${document_numerise_type_categorie}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  document_numerise_type_categorie  modifier
    # On saisit des valeurs
    Saisir la catégorie de pièces  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer la catégorie de pièces
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${document_numerise_type_categorie}

    # On accède à l'enregistrement
    Depuis le contexte de la catégorie de pièces  ${document_numerise_type_categorie}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  document_numerise_type_categorie  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir la catégorie de pièces
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
