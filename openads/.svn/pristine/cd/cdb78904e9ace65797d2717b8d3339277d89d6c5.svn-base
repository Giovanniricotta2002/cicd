*** Settings ***
Documentation    CRUD de la table sig_couche
...    @author  generated
...    @package openADS
...    @version 14/06/2021 10:06

*** Keywords ***

Depuis le contexte couche
    [Documentation]  Accède au formulaire
    [Arguments]  ${sig_couche}

    # On accède au tableau
    Go To Tab  sig_couche
    # On recherche l'enregistrement
    Use Simple Search  couche  ${sig_couche}
    # On clique sur le résultat
    Click On Link  ${sig_couche}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter couche
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  sig_couche
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir couche  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${sig_couche} =  Get Text  css=div.form-content span#sig_couche
    # On le retourne
    [Return]  ${sig_couche}

Modifier couche
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${sig_couche}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte couche  ${sig_couche}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  sig_couche  modifier
    # On saisit des valeurs
    Saisir couche  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer couche
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${sig_couche}

    # On accède à l'enregistrement
    Depuis le contexte couche  ${sig_couche}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  sig_couche  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir couche
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "id_couche" existe dans "${values}" on execute "Input Text" dans le formulaire