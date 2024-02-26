*** Settings ***
Documentation    CRUD de la table famille_travaux
...    @author  generated
...    @package openADS
...    @version 14/04/2023 17:04

*** Keywords ***

Depuis le contexte famille de travaux
    [Documentation]  Accède au formulaire
    [Arguments]  ${famille_travaux}

    # On accède au tableau
    Go To Tab  famille_travaux
    # On recherche l'enregistrement
    Use Simple Search  famille de travaux  ${famille_travaux}
    # On clique sur le résultat
    Click On Link  ${famille_travaux}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter famille de travaux
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  famille_travaux
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir famille de travaux  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${famille_travaux} =  Get Text  css=div.form-content span#famille_travaux
    # On le retourne
    [Return]  ${famille_travaux}

Modifier famille de travaux
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${famille_travaux}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte famille de travaux  ${famille_travaux}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  famille_travaux  modifier
    # On saisit des valeurs
    Saisir famille de travaux  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer famille de travaux
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${famille_travaux}

    # On accède à l'enregistrement
    Depuis le contexte famille de travaux  ${famille_travaux}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  famille_travaux  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir famille de travaux
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire