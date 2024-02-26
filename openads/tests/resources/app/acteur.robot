*** Settings ***
Documentation    CRUD de la table lien_dossier_tiers

*** Keywords ***
Depuis le contexte de l'acteur du dossier
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier}  ${acteur_id}

    # On accède aux tableaux
    Depuis l'onglet acteur du dossier d'instruction  ${dossier}
    # Click sur le bouton de consultation
    Cliquer sur le bouton de consultation de l'acteur  ${acteur_id}

Cliquer sur le bouton de consultation de l'acteur
    [Documentation]  Clique sur l'action de suppression du tableau pour l'acteur voulu
    [Arguments]  ${acteur}

    # Click sur le bouton de suppression
    Click Link  xpath=//a[text()[contains(.,"${acteur}")]]/ancestor::tr/td/descendant::a[contains(@id, "action-soustab-lien_dossier_tiers-left-consulter")]
    # Vérification de l'absence d'erreur sur la page
    La page ne doit pas contenir d'erreur

Ajouter des acteurs d'une catégorie au dossier
    [Documentation]  Ajout d'un ou plusieurs acteur à un dossier pour une catégorie donnée.
    [Arguments]  ${dossier}  ${category}  ${acteurs}

    # On accède au formulaire
    Depuis le formulaire d'ajout des acteurs d'une catégorie au dossier  ${dossier}  ${category}
    # On saisit la liste des tiers à ajouter en tant qu'acteur du dossier
    Saisir des acteurs  ${acteurs}
    # On valide le formulaire
    Click On Submit Button

Depuis le formulaire d'ajout des acteurs d'une catégorie au dossier
    [Documentation]  Accède au formulaire d'ajout des acteurs d'une catégorie donnée
    [Arguments]  ${dossier}  ${category}

    # On accède aux tableaux
    Depuis l'onglet acteur du dossier d'instruction  ${dossier}
    # On clique sur le bouton ajouter
    Click Link  css=#sousform-acteur_category_${category} a#action-soustab-lien_dossier_tiers-corner-ajouter
    Wait Until Page Contains Element  css=div#tiers_chosen

Supprimer l'acteur du dossier
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier}  ${acteur_id}

    # On accède aux tableaux
    Depuis l'onglet acteur du dossier d'instruction  ${dossier}
    # Clique sur l'action de suppression de l'acteur
    Cliquer sur le bouton de suppression de l'acteur  ${acteur_id}

Cliquer sur le bouton de suppression de l'acteur
    [Documentation]  Clique sur l'action de suppression du tableau pour l'acteur voulu
    [Arguments]  ${acteur}

    # Click sur le bouton de suppression
    Click Link  xpath=//a[text()[contains(.,"${acteur}")]]/ancestor::tr/td/descendant::a[contains(@id, "action-soustab-lien_dossier_tiers-left-supprimer")]
    # Message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain In Subform  css=#sousform-message  La suppression a été correctement effectuée.
    # Vérification de l'absence d'erreur sur la page
    La page ne doit pas contenir d'erreur


Saisir des acteurs
    [Documentation]  Remplit le formulaire
    [Arguments]  ${tiers}

    Select From Multiple Chosen List  tiers  ${tiers}
