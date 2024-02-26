*** Settings ***
Documentation    CRUD de la table lien_om_utilisateur_groupe
...    @author  generated
...    @package openADS
...    @version 03/11/2016 12:11

*** Keywords ***

Depuis le contexte lien_om_utilisateur_groupe
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_om_utilisateur_groupe}

    # On accède au tableau
    Depuis le listing  lien_om_utilisateur_groupe
    # On recherche l'enregistrement
    Use Simple Search  lien_om_utilisateur_groupe  ${lien_om_utilisateur_groupe}
    # On clique sur le résultat
    Click On Link  ${lien_om_utilisateur_groupe}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter lien_om_utilisateur_groupe
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  lien_om_utilisateur_groupe
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien_om_utilisateur_groupe  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_om_utilisateur_groupe} =  Get Text  css=div.form-content span#lien_om_utilisateur_groupe
    # On le retourne
    [Return]  ${lien_om_utilisateur_groupe}

Modifier lien_om_utilisateur_groupe
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_om_utilisateur_groupe}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien_om_utilisateur_groupe  ${lien_om_utilisateur_groupe}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_om_utilisateur_groupe  modifier
    # On saisit des valeurs
    Saisir lien_om_utilisateur_groupe  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien_om_utilisateur_groupe
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_om_utilisateur_groupe}

    # On accède à l'enregistrement
    Depuis le contexte lien_om_utilisateur_groupe  ${lien_om_utilisateur_groupe}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_om_utilisateur_groupe  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien_om_utilisateur_groupe
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "login" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "groupe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "confidentiel" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "enregistrement_demande" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
