*** Settings ***
Documentation    CRUD de la table lien_categorie_tiers_consulte_om_collectivite
...    @author  generated
...    @package openADS
...    @version 25/02/2022 15:02

*** Keywords ***

Depuis le contexte lien_categorie_tiers_consulte_om_collectivite
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_categorie_tiers_consulte_om_collectivite}

    # On accède au tableau
    Go To Tab  lien_categorie_tiers_consulte_om_collectivite
    # On recherche l'enregistrement
    Use Simple Search  lien_categorie_tiers_consulte_om_collectivite  ${lien_categorie_tiers_consulte_om_collectivite}
    # On clique sur le résultat
    Click On Link  ${lien_categorie_tiers_consulte_om_collectivite}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien_categorie_tiers_consulte_om_collectivite
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_categorie_tiers_consulte_om_collectivite
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien_categorie_tiers_consulte_om_collectivite  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_categorie_tiers_consulte_om_collectivite} =  Get Text  css=div.form-content span#lien_categorie_tiers_consulte_om_collectivite
    # On le retourne
    [Return]  ${lien_categorie_tiers_consulte_om_collectivite}

Modifier lien_categorie_tiers_consulte_om_collectivite
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_categorie_tiers_consulte_om_collectivite}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien_categorie_tiers_consulte_om_collectivite  ${lien_categorie_tiers_consulte_om_collectivite}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_categorie_tiers_consulte_om_collectivite  modifier
    # On saisit des valeurs
    Saisir lien_categorie_tiers_consulte_om_collectivite  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien_categorie_tiers_consulte_om_collectivite
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_categorie_tiers_consulte_om_collectivite}

    # On accède à l'enregistrement
    Depuis le contexte lien_categorie_tiers_consulte_om_collectivite  ${lien_categorie_tiers_consulte_om_collectivite}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_categorie_tiers_consulte_om_collectivite  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien_categorie_tiers_consulte_om_collectivite
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "categorie_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire