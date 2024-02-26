*** Settings ***
Documentation    CRUD de la table instructeur
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte instructeur
    [Documentation]  Accède au formulaire
    [Arguments]  ${instructeur}

    # On accède au tableau
    Go To Tab  instructeur
    # On recherche l'enregistrement
    Use Simple Search  instructeur  ${instructeur}
    # On clique sur le résultat
    Click On Link  ${instructeur}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter instructeur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  instructeur
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir instructeur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${instructeur} =  Get Text  css=div.form-content span#instructeur
    # On le retourne
    [Return]  ${instructeur}

Modifier instructeur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${instructeur}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte instructeur  ${instructeur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  instructeur  modifier
    # On saisit des valeurs
    Saisir instructeur  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer instructeur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${instructeur}

    # On accède à l'enregistrement
    Depuis le contexte instructeur  ${instructeur}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  instructeur  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir instructeur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "telephone" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "division" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_utilisateur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "instructeur_qualite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire