*** Settings ***
Documentation  Test d'ajout de valeurs dans les données techniques
...    Chaque 'Test Case' est indépendant.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Variables ***

${json_update_dossier_autorisation}    {"module":"update_dossier_autorisation"}

*** Test Cases ***
Vérification du fonctionnement des cerfa

    [Documentation]  Vérification du cerfa affecté aux données techniques.
    ...  Création d'un nouveau cerfa.
    ...  Vérification de la gestion du CERFA lors du dépôt d'un dossier d'instruction sur existant

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Affectation
    ...  particulier_prenom=Cerfa Initial
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_cerfa_initial} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  admin  admin

    &{args_cerfa} =  Create Dictionary
    ...  libelle=test cerfa 3
    ...  code=cerfa 3
    ...  om_validite_debut=01/04/2014
    ...  om_validite_fin=01/04/2033
    ...  terr_juri_titul=true
    ...  terr_juri_lot=true
    ...  terr_juri_zac=true
    ...  terr_juri_afu=true
    ...  terr_juri_pup=true
    ...  terr_juri_oin=true
    ...  terr_juri_desc=true

    Ajouter cerfa  ${args_cerfa}

    # Affectation du nouveau cerfa sur PCI
    &{args_datd} =  Create Dictionary
    ...  cerfa=test cerfa 3
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_datd}

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di_cerfa_initial}
    # On clique sur l'action données techniques du portlet
    Click On Form Portlet Action    dossier_instruction    donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#fieldset-sousform-donnees_techniques-amenager
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#fieldset-sousform-donnees_techniques-construire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#fieldset-sousform-donnees_techniques-demolir
    Click Element  css=.ui-dialog-titlebar-close


    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Affectation
    ...  particulier_prenom=Cerfa
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_cerfa} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di_cerfa}
    # On clique sur l'action données techniques du portlet
    Click On Form Portlet Action    dossier_instruction    donnees_techniques  modale
    Open Fieldset In Subform  donnees_techniques  terrain
    Sleep  0.5
    Element Should Not Be Visible  css=#fieldset-sousform-donnees_techniques-amenager
    Element Should Not Be Visible  css=#fieldset-sousform-donnees_techniques-construire
    Element Should Not Be Visible  css=#fieldset-sousform-donnees_techniques-demolir
    Click Element  css=.ui-dialog-titlebar-close

    # Lors du dépôt d'un dossier d'instruction sur existant, celui-ci doit
    # récupérer le CERFA en vigueur paramétré dans le type détaillé de dossier d'autorisation
    # et non plus utiliser le même CERFA que celui du dossier d'autorisation.
    Depuis la page d'accueil  admin  admin
    &{args_cerfa} =  Create Dictionary
    ...  libelle=test cerfa 4
    ...  code=cerfa 4
    ...  om_validite_debut=01/04/2014
    ...  om_validite_fin=01/04/2033
    ...  terr_juri_titul=true
    ...  terr_juri_lot=true
    ...  terr_juri_zac=true
    ...  terr_juri_afu=true
    ...  terr_juri_pup=true
    ...  terr_juri_oin=true
    ...  terr_juri_desc=true
    ...  am_lotiss=true
    Ajouter cerfa  ${args_cerfa}
    &{args_datd} =  Create Dictionary
    ...  cerfa=${args_cerfa.libelle}
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_datd}

    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${di_cerfa}  accepter un dossier sans réserve

    Depuis la page d'accueil  guichet  guichet
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di_cerfa}
    ${di_modif} =  Ajouter la demande par WS  ${args_demande}

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di_modif}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Open Fieldset In Subform  donnees_techniques  amenager
    Sleep  0.5
    Element Should Not Be Visible  css=#fieldset-sousform-donnees_techniques-construire
    Element Should Not Be Visible  css=#fieldset-sousform-donnees_techniques-demolir
    Click Element  css=.ui-dialog-titlebar-close

    # On réinitialise les données
    Depuis la page d'accueil  admin  admin
    &{args_datd} =  Create Dictionary
    ...  cerfa=cerfa de test
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_datd}

TNR Description du projet (champ et colonne)

    [Documentation]  Remplissage du cerfa n°2 et contrôle de "description du projet".

    ##
    ## Remplit les champs de donnes techniques suivants : ope_proj_desc, co_projet_desc,
    ## am_projet_desc, dm_projet_desc puis vérifie le bon affichage de ces 4 données dans
    ## la liste des DA, la fiche détaillée des demandes d'avis et DI.
    ## Vérifie que la colonne "nature du projet" a bien été renommée en "description du
    ## projet"
    ##


    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DESFORGES
    ...  particulier_prenom=Hugues
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${dossier_autorisation} =  Get Substring  ${di_libelle}  0  -2

    Depuis la page d'accueil  instr  instr

    Ajouter une consultation depuis un dossier  ${di_libelle}  59.07 - Service de l' Espace Public

    # On profite de cette vérification pour mettre des espace insécable dans le texte des description
    # ces espaces insécables ne doivent pas être pris en compte lors de l'ajout des données techniques
    # Robotframework ne fais pas la différence entre les deux type d'espace mais on peut vérifier l'interface
    # du DI à la main
    &{donnees_techniques_values} =  Create Dictionary
    ...  co_projet_desc=Type\xA0de\xA0projet\xA0co\xA0et\xA0je\xA0rajoute\xA0plein\xA0de\xA0caractère\xA0pour\xA0voir\xA0si\xA0l'affichage\xA0casse\xA0ou\xA0non\xA0et\xA0ainsi\xA0voir\xA0si\xA0la\xA0correction\xA0apportée\xA0gère\xA0bien\xA0les\xA0espaces\xA0non\xA0sécables
    ...  ope_proj_desc=Projet\xA0d'ope\xA0test
    ...  am_projet_desc=Projet\xA0d'aménagement\xA0and\xA0stuff
    ...  dm_projet_desc=détail\xA0sur\xA0le\xA0projet\xA0de\xA0démolition
    Saisir les données techniques du DI  ${di_libelle}  ${donnees_techniques_values}

    # On vérifie que le détail du DI contient bien les 4 champs des données techniques
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Element Should Contain  css=#description_projet  Type de projet co
    Element Should Contain  css=#description_projet  Projet d'ope test
    Element Should Contain  css=#description_projet  Projet d'aménagement and stuff
    Element Should Contain  css=#description_projet  détail sur le projet de démolition

    # On récupère le numéro du dossier d'autorisation depuis le numéro du DI
    # Puis on vérifie que le détail du DA contient bien les 4 champs des données techniques
    Depuis le contexte du dossier d'autorisation par la recherche  ${dossier_autorisation}
    Element Should Contain  css=#description_projet_0  Type de projet co
    Element Should Contain  css=#description_projet_0  Projet d'ope test
    Element Should Contain  css=#description_projet_0  Projet d'aménagement and stuff
    Element Should Contain  css=#description_projet_0  détail sur le projet de démolition

    # On affiche la liste des Demandes d'Avis, on vérifie que la colonne "nature du projet"
    # soit bien renommée en "description du projet", et que la colonne contienne les 4
    # champs des données techniques.
    Depuis la page d'accueil  consu  consu
    ${di_libelle_se} =  Sans espace  ${di_libelle}
    Input Text  css=input.champFormulaire[name='recherche']  ${di_libelle_se}
    Click Element  adv-search-submit
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-demande_avis_encours  description du projet
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-demande_avis_encours  Type de projet co
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-demande_avis_encours  Projet d'ope test
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-demande_avis_encours  Projet d'aménagement and stuff
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-demande_avis_encours  détail sur le projet de démolition

Edition de données techniques
    [Documentation]  On vérifie la modification et la création de
    ...  données technique, de création et modification de cerfa
    ...  et de changement de date de validité

    ${cerfa} =  Set Variable  cerfa de test

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Coppola
    ...  particulier_prenom=Francis Ford
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On vérifie que les données techniques sont toujours
    # disponibles même après un changement de date
    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  parametrage-dossier  cerfa
    Click On Link  ${cerfa}
    Click On Form Portlet Action  cerfa  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  css=#om_validite_fin  31/12/2013
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-donnees_techniques #form-content  Aménager
    Element Should Contain  css=#sousform-donnees_techniques #form-content  Construire
    Element Should Contain  css=#sousform-donnees_techniques #form-content  Démolir
    Click Element  css=.ui-dialog-titlebar-close

    # Ajout de données techniques
    Depuis la page d'accueil  admin  admin
    &{args_cerfa} =  Create Dictionary
    ...  libelle=test cerfa 3
    ...  code=cerfa 3
    ...  om_validite_debut=01/04/2014
    ...  om_validite_fin=01/04/2033
    ...  terr_juri_titul=true
    ...  terr_juri_lot=true
    ...  terr_juri_zac=true
    ...  terr_juri_afu=true
    ...  terr_juri_pup=true
    ...  terr_juri_oin=true
    ...  terr_juri_desc=true
    Ajouter cerfa  ${args_cerfa}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    &{args_DA_détaillé} =  Create Dictionary
    ...  cerfa=test cerfa 3
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_DA_détaillé}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button

    &{args_DA_détaillé} =  Create Dictionary
    Modifier type de dossier d'autorisation détaillé  AZ  ${args_DA_détaillé}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On vérifie que les données sont toujours disponibles
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-donnees_techniques #form-content  Aménager
    Element Should Contain  css=#sousform-donnees_techniques #form-content  Construire
    Element Should Contain  css=#sousform-donnees_techniques #form-content  Démolir

    # On instancie une nouvelle demande initial PCI
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Coppola
    ...  particulier_prenom=Francis Ford
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-donnees_techniques #form-content  Terrain
    Click Element  css=.ui-dialog-titlebar-close

    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  parametrage-dossier  cerfa
    Click On Link  Afficher les éléments expirés
    Click On Link  ${cerfa}
    Click On Form Portlet Action  cerfa  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  css=#om_validite_fin  31/12/2099
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On test la modification de cerfa
    &{args_DA_détaillé} =  Create Dictionary
    ...  cerfa=${cerfa}
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_DA_détaillé}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    &{args_DA_détaillé} =  Create Dictionary
    ...  cerfa=${cerfa}
    Modifier type de dossier d'autorisation détaillé  AZ  ${args_DA_détaillé}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

La popup des données techniques du DI ne créée pas d'erreur Javascript à postériori
    [Documentation]  Lors d'un scénario précis qui implique l'ouverture de la popup
    ...  des données techniques, cela bloque l'affichage du contenu des onglets
    ...  ce test vérifie ce comportement.

    # création d'une nouvelle demande
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Godin
    ...  particulier_prenom=Dingo
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_cerfa_initial} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # création d'un cerfa et affectation à ce type de dossier (PCI)
    Depuis la page d'accueil  admin  admin
    &{args_cerfa} =  Create Dictionary
    ...  libelle=test cerfa 3
    ...  code=cerfa 3
    ...  om_validite_debut=01/04/2014
    ...  om_validite_fin=01/04/2033
    ...  terr_juri_titul=true
    ...  terr_juri_lot=true
    ...  terr_juri_zac=true
    ...  terr_juri_afu=true
    ...  terr_juri_pup=true
    ...  terr_juri_oin=true
    ...  terr_juri_desc=true
    Ajouter cerfa  ${args_cerfa}
    &{args_datd} =  Create Dictionary
    ...  cerfa=test cerfa 3
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_datd}

    # ouvre la demande (sur l'onglet 'DI')
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di_cerfa_initial}

    # clique sur le portlet "Données techniques / CERFA"
    Click On Form Portlet Action    dossier_instruction    donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible
    ...  css=#fieldset-sousform-donnees_techniques-amenager

    # ferme la popup
    Click Element  css=.ui-dialog-titlebar-close

    # clique sur l'onglet "Contraintes" (jusqu'à ce que le contenu de l'onglet soit affiché)
    Click Element Until New Element  css=a#dossier_contrainte  css=div#ui-tabs-1
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible
    ...  css=div#sousform-dossier_contrainte div#sformulaire div#sousform-container div#sousform-dossier_contrainte

    # clique sur l'onglet "Instruction" (jusqu'à ce que le contenu de l'onglet soit affiché)
    Click Element Until New Element  css=a#instruction  css=div#ui-tabs-2

    # l'onglet doit contenir le sous-formulaire (et non être vide)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible
    ...  css=#sousform-instruction .soustab-container .tab-tab

    # restoration de l'affectation originale du CERFA pour ne pas polluer les autres tests
    Depuis la page d'accueil  admin  admin
    &{args_datd} =  Create Dictionary
    ...  cerfa=cerfa de test
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_datd}
