*** Settings ***
Documentation    CRUD de la table lien_om_profil_groupe
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Lien profil / groupe
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_om_profil_groupe}

    # On accède au tableau
    Go To Tab  lien_om_profil_groupe
    # On recherche l'enregistrement
    Use Simple Search  Lien profil / groupe  ${lien_om_profil_groupe}
    # On clique sur le résultat
    Click On Link  ${lien_om_profil_groupe}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Lien profil / groupe
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_om_profil_groupe
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Lien profil / groupe  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_om_profil_groupe} =  Get Text  css=div.form-content span#lien_om_profil_groupe
    # On le retourne
    [Return]  ${lien_om_profil_groupe}

Modifier Lien profil / groupe
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_om_profil_groupe}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Lien profil / groupe  ${lien_om_profil_groupe}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_om_profil_groupe  modifier
    # On saisit des valeurs
    Saisir Lien profil / groupe  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Lien profil / groupe
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_om_profil_groupe}

    # On accède à l'enregistrement
    Depuis le contexte Lien profil / groupe  ${lien_om_profil_groupe}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_om_profil_groupe  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Lien profil / groupe
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "om_profil" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "groupe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "confidentiel" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "enregistrement_demande" existe dans "${values}" on execute "Set Checkbox" dans le formulaire