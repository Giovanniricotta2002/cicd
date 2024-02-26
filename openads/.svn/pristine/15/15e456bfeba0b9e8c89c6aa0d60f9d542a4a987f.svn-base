*** Settings ***
Documentation    CRUD de la table groupe
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte groupe
    [Documentation]  Accède au formulaire
    [Arguments]  ${groupe}

    # On accède au tableau
    Go To Tab  groupe
    # On recherche l'enregistrement
    Use Simple Search  groupe  ${groupe}
    # On clique sur le résultat
    Click On Link  ${groupe}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter groupe
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  groupe
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir groupe  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${groupe} =  Get Text  css=div.form-content span#groupe
    # On le retourne
    [Return]  ${groupe}

Modifier groupe
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${groupe}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte groupe  ${groupe}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  groupe  modifier
    # On saisit des valeurs
    Saisir groupe  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer groupe
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${groupe}

    # On accède à l'enregistrement
    Depuis le contexte groupe  ${groupe}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  groupe  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir groupe
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "genre" existe dans "${values}" on execute "Select From List By Label" dans le formulaire