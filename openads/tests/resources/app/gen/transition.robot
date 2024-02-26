*** Settings ***
Documentation    CRUD de la table transition
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte transition
    [Documentation]  Accède au formulaire
    [Arguments]  ${transition}

    # On accède au tableau
    Go To Tab  transition
    # On recherche l'enregistrement
    Use Simple Search  transition  ${transition}
    # On clique sur le résultat
    Click On Link  ${transition}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter transition
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  transition
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir transition  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${transition} =  Get Text  css=div.form-content span#transition
    # On le retourne
    [Return]  ${transition}

Modifier transition
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${transition}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte transition  ${transition}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  transition  modifier
    # On saisit des valeurs
    Saisir transition  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer transition
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${transition}

    # On accède à l'enregistrement
    Depuis le contexte transition  ${transition}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  transition  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir transition
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "etat" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "evenement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire