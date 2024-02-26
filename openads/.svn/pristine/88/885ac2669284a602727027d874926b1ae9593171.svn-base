*** Settings ***
Documentation    CRUD de la table dossier_autorisation_type_detaille
...    @author  generated
...    @package openADS
...    @version 22/12/2015 11:12

*** Keywords ***

Depuis le contexte type de dossier d'autorisation détaillé
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_autorisation_type_detaille}

    # On accède au tableau
    Depuis le listing  dossier_autorisation_type_detaille
    # On recherche l'enregistrement
    Use Simple Search  code  ${dossier_autorisation_type_detaille}
    # On clique sur le résultat
    Click On Link  ${dossier_autorisation_type_detaille}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter type de dossier d'autorisation détaillé
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  dossier_autorisation_type_detaille
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir type de dossier d'autorisation détaillé  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_autorisation_type_detaille} =  Get Text  css=div.form-content span#dossier_autorisation_type_detaille
    # On le retourne
    [Return]  ${dossier_autorisation_type_detaille}

Modifier type de dossier d'autorisation détaillé
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_autorisation_type_detaille}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte type de dossier d'autorisation détaillé  ${dossier_autorisation_type_detaille}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_autorisation_type_detaille  modifier
    # On saisit des valeurs
    Saisir type de dossier d'autorisation détaillé  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer type de dossier d'autorisation détaillé
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_autorisation_type_detaille}

    # On accède à l'enregistrement
    Depuis le contexte type de dossier d'autorisation détaillé  ${dossier_autorisation_type_detaille}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_autorisation_type_detaille  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir type de dossier d'autorisation détaillé
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_autorisation_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "cerfa" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "cerfa_lot" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "duree_validite_parametrage" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_platau" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "couleur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "secret_instruction" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
