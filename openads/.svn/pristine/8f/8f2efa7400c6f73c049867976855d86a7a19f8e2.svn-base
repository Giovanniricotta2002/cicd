*** Settings ***
Documentation    Test suite no data
...    L'objectif est de contrôler le comportement de l'application
...    dans son état initial, c'est à dire sans données métier.
...    Si un ajout est effectué alors le nouvel enregistrement est supprimé.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Génération complète
    [Documentation]    Le 'Framework' de l'application permet de générer
    ...    automatiquement certains scripts en fonction du modèle de données. Lors
    ...    du développement la règle est la suivante : toute modification du
    ...    modèle de données doit entrainer une regénération complète de tous les
    ...    scripts. Pour vérifier à chaque modification du code que la règle a bien
    ...    été respectée, ce 'Test Suite' permet de lancer une génération complète.
    ...    Si un fichier est généré alors le test doit échouer.

    Depuis la page d'accueil  admin  admin
    # Aucun fichier ne doit être regénéré lors du genfull
    Générer tout

TNR Erreur de base de données sur listing vide de DI
    [Documentation]  Teste sur une base de données sans DI qu'il n'y a pas
    ...  d'erreur de base de données

    Depuis la page d'accueil  guichet  guichet

    # On affiche le listing des dossiers d'instruction
    Go To Submenu In Menu  instruction  dossier_instruction_recherche

    ## Cas n°1 : l'affichage du listing vide provoquait une erreur de base de données
    # La page ne doit pas contenir d'erreurs
    La page ne doit pas contenir d'erreur

    ## Cas n°2 : la validation du formulaire de recherche avancée sur un listing vide
    ## provoquait une erreur de base de données
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  AZERTY
    # On valide le formulaire de recherche
    Click On Search Button
    # La page ne doit pas contenir d'erreurs
    La page ne doit pas contenir d'erreur

Ouverture des fieldsets
    [Documentation]  Teste l'ouverture d'un fieldset de formulaire et d'un fieldset
    ...  de sous-formulaire en cliquant sur le bouton d'ouverture du fieldset.

    Depuis la page d'accueil  admin  admin
    # Déplie le fieldset localisation d'un dossier déjà paramétré dans les
    # données de test. Utilise un dossier pré paramétré dans la base de données.
    Depuis le contexte du dossier d'instruction   AT 013055 12 00001P0
    # Déplie un fieldset des données techniques
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Open Fieldset In SubForm  donnees_techniques  terrain  manual




