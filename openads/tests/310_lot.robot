*** Settings ***
Documentation  Test des fonctionnalités des lots.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Constitution du jeu de données
    [Documentation]  Constitue un jeu de données cohérent pour les scénarios
    ...  fonctionnels qui suivent.

    # On ajout un dossier d'instruction
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Desaulniers
    ...  particulier_prenom=Mathilde
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Set Suite Variable  ${di}

Actions de base sur les lots dans un dossier d'instruction
    [Documentation]  Vérifie les actions de base (ajout, modification,
    ...  suppression) sur l'onglet "Lot(s)" dans le contexte d'un dossier
    ...  d'instruction.

    Depuis la page d'accueil  instr  instr
    # On ajoute un lot
    ${lot_libelle} =  Set Variable  lot1
    &{args_lot} =  Create Dictionary
    ...  libelle=${lot_libelle}
    Ajouter le lot  ${di}  ${args_lot}
    # On vérifie que le lot est correctement affiché dans le listing des lots
    # du dossier d'instruction
    Depuis l'onglet des lots dans le dossier d'instruction  ${di}
    Element Should Contain  css=div#sousform-lot table.tab-tab  ${lot_libelle}

    # On modifie le lot
    ${lot_modif_libelle} =  Set Variable  lot2
    &{args_lot} =  Create Dictionary
    ...  libelle=${lot_modif_libelle}
    Modifier le lot  ${di}  ${lot_libelle}  ${args_lot}
    # On vérifie que le lot est correctement affiché dans le listing des lots
    # du dossier d'instruction
    Depuis l'onglet des lots dans le dossier d'instruction  ${di}
    Wait Until Element Is Visible  css=div#sousform-lot table.tab-tab
    Element Should Contain  css=div#sousform-lot table.tab-tab  ${lot_modif_libelle}

    # Édition des données techniques
    Click On Link    ${lot_modif_libelle}
    # On clique sur le bouton modifier
    Click On Subform Portlet Action  lot  donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Subform Portlet Action  donnees_techniques  modifier
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie les erreurs
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click Element    css=#sousform-donnees_techniques .retour

    # On supprime le lot
    Supprimer le lot  ${di}  ${lot_modif_libelle}
    # On vérifie que le lot n'est plus affiché dans le listing des lots
    # du dossier d'instruction
    Depuis l'onglet des lots dans le dossier d'instruction  ${di}
    Element Should Not Contain  css=div#sousform-lot table.tab-tab  ${lot_modif_libelle}
