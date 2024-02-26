*** Settings ***
Documentation    CRUD de la table lien_service_om_utilisateur
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte lien service/utilisateur
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_service_om_utilisateur}

    # On accède au tableau
    Go To Tab  lien_service_om_utilisateur
    # On recherche l'enregistrement
    Use Simple Search  lien service/utilisateur  ${lien_service_om_utilisateur}
    # On clique sur le résultat
    Click On Link  ${lien_service_om_utilisateur}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien service/utilisateur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_service_om_utilisateur
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien service/utilisateur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_service_om_utilisateur} =  Get Text  css=div.form-content span#lien_service_om_utilisateur
    # On le retourne
    [Return]  ${lien_service_om_utilisateur}

Modifier lien service/utilisateur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_service_om_utilisateur}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien service/utilisateur  ${lien_service_om_utilisateur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_service_om_utilisateur  modifier
    # On saisit des valeurs
    Saisir lien service/utilisateur  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien service/utilisateur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_service_om_utilisateur}

    # On accède à l'enregistrement
    Depuis le contexte lien service/utilisateur  ${lien_service_om_utilisateur}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_service_om_utilisateur  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien service/utilisateur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "om_utilisateur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "service" existe dans "${values}" on execute "Select From List By Label" dans le formulaire