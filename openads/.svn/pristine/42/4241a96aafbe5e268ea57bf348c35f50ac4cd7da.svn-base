*** Settings ***
Documentation    CRUD de la table demande_nature
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte nature de la demande
    [Documentation]  Accède au formulaire
    [Arguments]  ${demande_nature}

    # On accède au tableau
    Go To Tab  demande_nature
    # On recherche l'enregistrement
    Use Simple Search  nature de la demande  ${demande_nature}
    # On clique sur le résultat
    Click On Link  ${demande_nature}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter nature de la demande
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  demande_nature
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir nature de la demande  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${demande_nature} =  Get Text  css=div.form-content span#demande_nature
    # On le retourne
    [Return]  ${demande_nature}

Modifier nature de la demande
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${demande_nature}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte nature de la demande  ${demande_nature}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  demande_nature  modifier
    # On saisit des valeurs
    Saisir nature de la demande  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer nature de la demande
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${demande_nature}

    # On accède à l'enregistrement
    Depuis le contexte nature de la demande  ${demande_nature}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  demande_nature  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir nature de la demande
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire