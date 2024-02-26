*** Settings ***
Documentation    CRUD de la table dossier_autorisation_type
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte type de dossier d'autorisation
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_autorisation_type}

    # On accède au tableau
    Go To Tab  dossier_autorisation_type
    # On recherche l'enregistrement
    Use Simple Search  type de dossier d'autorisation  ${dossier_autorisation_type}
    # On clique sur le résultat
    Click On Link  ${dossier_autorisation_type}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter type de dossier d'autorisation
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_autorisation_type
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir type de dossier d'autorisation  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_autorisation_type} =  Get Text  css=div.form-content span#dossier_autorisation_type
    # On le retourne
    [Return]  ${dossier_autorisation_type}

Modifier type de dossier d'autorisation
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_autorisation_type}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte type de dossier d'autorisation  ${dossier_autorisation_type}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_autorisation_type  modifier
    # On saisit des valeurs
    Saisir type de dossier d'autorisation  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer type de dossier d'autorisation
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_autorisation_type}

    # On accède à l'enregistrement
    Depuis le contexte type de dossier d'autorisation  ${dossier_autorisation_type}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_autorisation_type  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir type de dossier d'autorisation
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "confidentiel" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "groupe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "affichage_form" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cacher_da" existe dans "${values}" on execute "Set Checkbox" dans le formulaire