*** Settings ***
Documentation    CRUD de la table lien_habilitation_tiers_consulte_commune
...    @author  generated
...    @package openADS
...    @version 08/02/2023 10:02

*** Keywords ***

Depuis le contexte commune(s) liées aux habilitations de tiers
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_habilitation_tiers_consulte_commune}

    # On accède au tableau
    Go To Tab  lien_habilitation_tiers_consulte_commune
    # On recherche l'enregistrement
    Use Simple Search  commune(s) liées aux habilitations de tiers  ${lien_habilitation_tiers_consulte_commune}
    # On clique sur le résultat
    Click On Link  ${lien_habilitation_tiers_consulte_commune}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter commune(s) liées aux habilitations de tiers
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_habilitation_tiers_consulte_commune
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir commune(s) liées aux habilitations de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_habilitation_tiers_consulte_commune} =  Get Text  css=div.form-content span#lien_habilitation_tiers_consulte_commune
    # On le retourne
    [Return]  ${lien_habilitation_tiers_consulte_commune}

Modifier commune(s) liées aux habilitations de tiers
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_habilitation_tiers_consulte_commune}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte commune(s) liées aux habilitations de tiers  ${lien_habilitation_tiers_consulte_commune}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_habilitation_tiers_consulte_commune  modifier
    # On saisit des valeurs
    Saisir commune(s) liées aux habilitations de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer commune(s) liées aux habilitations de tiers
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_habilitation_tiers_consulte_commune}

    # On accède à l'enregistrement
    Depuis le contexte commune(s) liées aux habilitations de tiers  ${lien_habilitation_tiers_consulte_commune}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_habilitation_tiers_consulte_commune  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir commune(s) liées aux habilitations de tiers
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "habilitation_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "commune" existe dans "${values}" on execute "Select From List By Label" dans le formulaire