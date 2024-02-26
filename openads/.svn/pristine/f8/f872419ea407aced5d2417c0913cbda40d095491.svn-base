*** Settings ***
Documentation    CRUD de la table lien_dossier_instruction_type_categorie_tiers
...    @author  generated
...    @package openADS
...    @version 13/02/2023 20:02

*** Keywords ***

Depuis le contexte lien entre le type de DI et une catégorie de tiers
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_dossier_instruction_type_categorie_tiers}

    # On accède au tableau
    Go To Tab  lien_dossier_instruction_type_categorie_tiers
    # On recherche l'enregistrement
    Use Simple Search  lien entre le type de DI et une catégorie de tiers  ${lien_dossier_instruction_type_categorie_tiers}
    # On clique sur le résultat
    Click On Link  ${lien_dossier_instruction_type_categorie_tiers}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien entre le type de DI et une catégorie de tiers
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_dossier_instruction_type_categorie_tiers
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien entre le type de DI et une catégorie de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_dossier_instruction_type_categorie_tiers} =  Get Text  css=div.form-content span#lien_dossier_instruction_type_categorie_tiers
    # On le retourne
    [Return]  ${lien_dossier_instruction_type_categorie_tiers}

Modifier lien entre le type de DI et une catégorie de tiers
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_dossier_instruction_type_categorie_tiers}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien entre le type de DI et une catégorie de tiers  ${lien_dossier_instruction_type_categorie_tiers}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_dossier_instruction_type_categorie_tiers  modifier
    # On saisit des valeurs
    Saisir lien entre le type de DI et une catégorie de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien entre le type de DI et une catégorie de tiers
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_dossier_instruction_type_categorie_tiers}

    # On accède à l'enregistrement
    Depuis le contexte lien entre le type de DI et une catégorie de tiers  ${lien_dossier_instruction_type_categorie_tiers}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_dossier_instruction_type_categorie_tiers  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien entre le type de DI et une catégorie de tiers
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "categorie_tiers" existe dans "${values}" on execute "Select From List By Label" dans le formulaire