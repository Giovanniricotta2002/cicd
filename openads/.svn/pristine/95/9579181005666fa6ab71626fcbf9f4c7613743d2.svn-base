*** Settings ***
Documentation    CRUD de la table num_bordereau
...    @author  generated
...    @package openADS
...    @version 20/03/2020 16:03

*** Keywords ***

Depuis le contexte Numéro du bordereau
    [Documentation]  Accède au formulaire
    [Arguments]  ${num_bordereau}

    # On accède au tableau
    Go To Tab  num_bordereau
    # On recherche l'enregistrement
    Use Simple Search  Numéro du bordereau  ${num_bordereau}
    # On clique sur le résultat
    Click On Link  ${num_bordereau}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Numéro du bordereau
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  num_bordereau
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Numéro du bordereau  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${num_bordereau} =  Get Text  css=div.form-content span#num_bordereau
    # On le retourne
    [Return]  ${num_bordereau}

Modifier Numéro du bordereau
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${num_bordereau}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Numéro du bordereau  ${num_bordereau}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  num_bordereau  modifier
    # On saisit des valeurs
    Saisir Numéro du bordereau  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Numéro du bordereau
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${num_bordereau}

    # On accède à l'enregistrement
    Depuis le contexte Numéro du bordereau  ${num_bordereau}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  num_bordereau  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Numéro du bordereau
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "envoi" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire