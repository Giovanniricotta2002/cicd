*** Settings ***
Documentation    CRUD de la table departement
...    @author  generated
...    @package openADS
...    @version 22/10/2020 18:10

*** Keywords ***

Depuis le contexte département
    [Documentation]  Accède au formulaire
    [Arguments]  ${departement}

    # On accède au tableau
    Depuis le listing  departement
    # On recherche l'enregistrement
    Use Simple Search  département  ${departement}
    # On clique sur le résultat
    Click On Link  ${departement}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter département
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  departement
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir département  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${departement} =  Get Text  css=div.form-content span#departement
    # On le retourne
    [Return]  ${departement}

Modifier département
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${departement}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte département  ${departement}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  departement  modifier
    # On saisit des valeurs
    Saisir département  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer département
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${departement}

    # On accède à l'enregistrement
    Depuis le contexte département  ${departement}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  departement  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir département
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dep" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cheflieu" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tncc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ncc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "nccenr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire