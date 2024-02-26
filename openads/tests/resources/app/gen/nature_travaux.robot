*** Settings ***
Documentation    CRUD de la table nature_travaux
...    @author  generated
...    @package openADS
...    @version 18/04/2023 20:04

*** Keywords ***

Depuis le contexte nature des travaux
    [Documentation]  Accède au formulaire
    [Arguments]  ${nature_travaux}

    # On accède au tableau
    Go To Tab  nature_travaux
    # On recherche l'enregistrement
    Use Simple Search  nature des travaux  ${nature_travaux}
    # On clique sur le résultat
    Click On Link  ${nature_travaux}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter nature des travaux
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  nature_travaux
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir nature des travaux  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${nature_travaux} =  Get Text  css=div.form-content span#nature_travaux
    # On le retourne
    [Return]  ${nature_travaux}

Modifier nature des travaux
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${nature_travaux}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte nature des travaux  ${nature_travaux}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  nature_travaux  modifier
    # On saisit des valeurs
    Saisir nature des travaux  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer nature des travaux
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${nature_travaux}

    # On accède à l'enregistrement
    Depuis le contexte nature des travaux  ${nature_travaux}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  nature_travaux  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir nature des travaux
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "famille_travaux" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire