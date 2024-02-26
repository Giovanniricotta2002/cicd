*** Settings ***
Documentation    CRUD de la table direction
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte direction
    [Documentation]  Accède au formulaire
    [Arguments]  ${direction}

    # On accède au tableau
    Go To Tab  direction
    # On recherche l'enregistrement
    Use Simple Search  direction  ${direction}
    # On clique sur le résultat
    Click On Link  ${direction}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter direction
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  direction
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir direction  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${direction} =  Get Text  css=div.form-content span#direction
    # On le retourne
    [Return]  ${direction}

Modifier direction
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${direction}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte direction  ${direction}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  direction  modifier
    # On saisit des valeurs
    Saisir direction  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer direction
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${direction}

    # On accède à l'enregistrement
    Depuis le contexte direction  ${direction}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  direction  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir direction
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "chef" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire