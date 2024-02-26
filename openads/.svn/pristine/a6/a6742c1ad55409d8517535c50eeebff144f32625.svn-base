*** Settings ***
Documentation    CRUD de la table lien_om_utilisateur_tiers_consulte
...    @author  generated
...    @package openADS
...    @version 08/02/2023 10:02

*** Keywords ***

Depuis le contexte lien utilisateur / tiers
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_om_utilisateur_tiers_consulte}

    # On accède au tableau
    Go To Tab  lien_om_utilisateur_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  lien utilisateur / tiers  ${lien_om_utilisateur_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${lien_om_utilisateur_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien utilisateur / tiers
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_om_utilisateur_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien utilisateur / tiers  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_om_utilisateur_tiers_consulte} =  Get Text  css=div.form-content span#lien_om_utilisateur_tiers_consulte
    # On le retourne
    [Return]  ${lien_om_utilisateur_tiers_consulte}

Modifier lien utilisateur / tiers
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_om_utilisateur_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien utilisateur / tiers  ${lien_om_utilisateur_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_om_utilisateur_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir lien utilisateur / tiers  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien utilisateur / tiers
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_om_utilisateur_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte lien utilisateur / tiers  ${lien_om_utilisateur_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_om_utilisateur_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien utilisateur / tiers
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "om_utilisateur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire