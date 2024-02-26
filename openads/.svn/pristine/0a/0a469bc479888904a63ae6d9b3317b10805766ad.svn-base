*** Settings ***
Documentation    CRUD de la table categorie_tiers_consulte
...    @author  generated
...    @package openADS
...    @version 08/02/2023 10:02

*** Keywords ***

Depuis le contexte catégorie de tiers
    [Documentation]  Accède au formulaire
    [Arguments]  ${categorie_tiers_consulte}

    # On accède au tableau
    Go To Tab  categorie_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  catégorie de tiers  ${categorie_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${categorie_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter catégorie de tiers
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  categorie_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir catégorie de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${categorie_tiers_consulte} =  Get Text  css=div.form-content span#categorie_tiers_consulte
    # On le retourne
    [Return]  ${categorie_tiers_consulte}

Modifier catégorie de tiers
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${categorie_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte catégorie de tiers  ${categorie_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  categorie_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir catégorie de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer catégorie de tiers
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${categorie_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte catégorie de tiers  ${categorie_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  categorie_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir catégorie de tiers
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire