*** Settings ***
Documentation    CRUD de la table lien_om_utilisateur_groupe
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Lien utilisateur / groupe
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_om_utilisateur_groupe}

    # On accède au tableau
    Go To Tab  lien_om_utilisateur_groupe
    # On recherche l'enregistrement
    Use Simple Search  Lien utilisateur / groupe  ${lien_om_utilisateur_groupe}
    # On clique sur le résultat
    Click On Link  ${lien_om_utilisateur_groupe}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Lien utilisateur / groupe
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_om_utilisateur_groupe
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Lien utilisateur / groupe  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_om_utilisateur_groupe} =  Get Text  css=div.form-content span#lien_om_utilisateur_groupe
    # On le retourne
    [Return]  ${lien_om_utilisateur_groupe}

Modifier Lien utilisateur / groupe
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_om_utilisateur_groupe}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Lien utilisateur / groupe  ${lien_om_utilisateur_groupe}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_om_utilisateur_groupe  modifier
    # On saisit des valeurs
    Saisir Lien utilisateur / groupe  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Lien utilisateur / groupe
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_om_utilisateur_groupe}

    # On accède à l'enregistrement
    Depuis le contexte Lien utilisateur / groupe  ${lien_om_utilisateur_groupe}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_om_utilisateur_groupe  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Lien utilisateur / groupe
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "login" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "groupe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "confidentiel" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "enregistrement_demande" existe dans "${values}" on execute "Set Checkbox" dans le formulaire