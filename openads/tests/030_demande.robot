*** Settings ***
Documentation  Test les dépôts de demandes

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Keywords ***
Vérifier l'intégration de l'ajout d'une nouvelle demande / nouveau dossier avec l'utilisateur

    [Documentation]  'Guichet Unique > Nouvelle Demande > Nouveau Dossier'
    ...  - Vérification des éléments d'intégration
    ...  - Saisie de la demande et du pétitionnaire principal
    ...  - Vérification du messgae de validation :
    ...     * info sur le DA,
    ...     * info sur le DI,
    ...     * lien vers le récepissé
    ...  - Ouverture du récepissé
    ...  - Retour vers le tableau de bord

    [Arguments]  ${user}  ${password}

    # On se connecte à l'application
    Depuis la page d'accueil  ${user}  ${password}

    # On clique sur l'entrée de menu dédiée et on vérifie l'intégration
    # - ouverture du menu
    # - titre de la page
    # - titre de l'onglet
    Go To Submenu In Menu  guichet_unique  nouveau-dossier
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Nouveau Dossier
    First Tab Title Should Be  Demande

    # Informations à saisir
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=DURAND
    ...  particulier_prenom=MICKAEL
    ...  particulier_date_naissance=03/01/1956
    ...  particulier_commune_naissance=LILLE
    ...  particulier_departement_naissance=NORD
    ...  numero=12
    ...  voie=RUE DE LA LOI
    ...  complement=APPT 12
    ...  localite=MARSEILLE
    ...  code_postal=13012
    ...  telephone_fixe=0404040404
    ...  fax=0405040404
    # On remplit les champs de la demande
    Saisir la demande  ${args_demande}
    # On ajoute le pétitionnaire
    Ajouter le demandeur  petitionnaire_principal  ${args_petitionnaire}
    # On vérifie que le nom du pétitionnaire saisi est bien affiché dans le
    # formulaire de la demande
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#petitionnaire_principal_delegataire .synthese_demandeur  DURAND MICKAEL
    # On valide
    Click On Submit Button

    # Vérification du message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On vérifie l'intégration
    # - ouverture du menu
    # - titre de la page
    # - titre de l'onglet
    Submenu In Menu Should Be Selected  guichet_unique  nouveau-dossier
    Page Title Should Contain  Guichet Unique > Nouvelle Demande > Nouveau Dossier
    First Tab Title Should Be  Demande

    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message
    Valid Message Should Contain  Création du dossier d'autorisation n°
    Valid Message Should Contain  Création du dossier d'instruction n°

    # On télécharge le récépissé de la demande
    Click On Link  link_demande_recepisse
    # On vérifie le contenu du PDF
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  RECEPISSE DE DEPOT
    Page Should Contain  DURAND MICKAEL
    Close PDF

    # On clique sur le bouton retour
    Click On Back Button
    Page Title Should Be  Tableau De Bord


Vérifier l'intégration de la rubrique 'Guichet Unique' avec l'utilisateur

    [Documentation]  Ce test vise uniquement à vérifier que les écrans
    ...  correspondant à chaque entrée de menu de la rubrique 'Guichet Unique'
    ...  ne génère pas une erreur de base de données

    [Arguments]  ${user}  ${password}

    # On se connecte à l'application
    Depuis la page d'accueil  ${user}  ${password}

    # On vérifie le menu "Nouveau Dossier"
    Go To Submenu In Menu  guichet_unique  nouveau-dossier
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Nouveau Dossier
    First Tab Title Should Be  Demande
    La page ne doit pas contenir d'erreur
    # On vérifie le menu "Dossier En Cours"
    Go To Submenu In Menu  guichet_unique  dossier-existant
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Dossier En Cours
    First Tab Title Should Be  Demande
    La page ne doit pas contenir d'erreur
    # On vérifie le menu "Autre Dossier"
    Go To Submenu In Menu  guichet_unique  autre-dossier
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Autre Dossier
    First Tab Title Should Be  Demande
    La page ne doit pas contenir d'erreur
    # On vérifie le menu "Récépissé"
    Go To Submenu In Menu  guichet_unique  pdf
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Récépissé
    First Tab Title Should Be  Demande
    La page ne doit pas contenir d'erreur
    # On vérifie le menu "Pétitionnaire Fréquent"
    Go to Submenu In Menu  guichet_unique  petitionnaire_frequent
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Pétitionnaire Fréquent
    First Tab Title Should Be  Pétitionnaire Fréquent
    La page ne doit pas contenir d'erreur
    # On vérifie le menu "Registre"
    Go To Submenu In Menu  guichet_unique  affichage_reglementaire_registre
    Page Title Should Be  Guichet Unique > Affichage Réglementaire > Registre
    First Tab Title Should Be  Traitement Du Registre D'affichage Réglementaire
    La page ne doit pas contenir d'erreur
    # On vérifie le menu "Attestation"
    Go To Submenu In Menu  guichet_unique  affichage_reglementaire_attestation
    Page Title Should Be  Guichet Unique > Affichage Réglementaire > Attestation
    First Tab Title Should Be  Imprimer L'attestation D'affichage Réglementaire
    La page ne doit pas contenir d'erreur


Activer la saisie du numéro de dossier
    [Documentation]  Permet d'activer la saisie du numéro de dossier sur le formulaire
    ...  d'ajout d'une nouvelle demande

    # Le click element until new element fail parfois car il vérifie que le "New Element" n'est pas affiché
    # avant de commencer son traitement. Or, à l'ouverture du formulaire, les champs sont tous affichés
    # pendant un instant puis ceux voulus sont masqués.
    # Cette temporisation sert donc d'attendre que les champs masqués le soit avant de déclencher le traitement
    # et donc à éviter ce fail.
    Wait Until Element Is Not Visible  css=div.bloc_num_manu
    Click Element Until New Element  css=#num_doss_manuel  css=div.bloc_num_manu
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#num_doss_sequence


Désactiver la saisie du numéro de dossier
    [Documentation]  Permet de désactiver la saisie du numéro de dossier sur le formulaire
    ...  d'ajout d'une nouvelle demande
    Click Element Until New Element  css=#num_doss_manuel  css=#num_doss_manuel[value=""]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=#num_doss_type_da[readonly="readonly"]


*** Test Cases ***
Non accumulation de message d'erreur sous le champ saisie complète du numéro de dossier

    Depuis la page d'accueil  admin  admin
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    Depuis la page d'accueil  guichet  guichet

    Go To Submenu In Menu  guichet_unique  nouveau-dossier
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Nouveau Dossier

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Don
    ...  particulier_prenom=Pablo

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial

    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}

    Element Should Be Visible  css=#num_doss_manuel

    # activation de la saisie du numéro de dossier
    Click Element Until New Element  css=#num_doss_manuel  css=div.bloc_num_manu
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#num_doss_complet
    Element Should Be Visible  css=#num_doss_manuel[value="Oui"]

    Input Text  css=#num_doss_complet  TOTO
    Input Text  css=#terrain_adresse_voie_numero  0
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#complet_err_msg
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#complet_err_msg
    ${err_msg} =  Get Text  css=#complet_err_msg
    Should Be Equal  ${err_msg}
    ...  Le numéro saisie ne respecte pas le format imposé par le code de l'urbanisme, les vérifications imposées ne seront donc pas réalisées.

    Input Text  css=#num_doss_complet  TATA
    Input Text  css=#terrain_adresse_voie_numero  0
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#complet_err_msg
    ${err_msg} =  Get Text  css=#complet_err_msg
    Should Be Equal  ${err_msg}
    ...  Le numéro saisie ne respecte pas le format imposé par le code de l'urbanisme, les vérifications imposées ne seront donc pas réalisées.

    Input Text  css=#num_doss_complet  PC0130552200013
    Input Text  css=#terrain_adresse_voie_numero  0
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#complet_err_msg
    ${err_msg} =  Get Text  css=#complet_err_msg
    Should Be Equal  ${err_msg}
    ...  Le numéro saisie doit comporter un suffixe.

    Input Text  css=#num_doss_complet  ${EMPTY}
    Input Text  css=#terrain_adresse_voie_numero  0
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=#complet_err_msg
    Page Should Not Contain Element  css=#complet_err_msg

    Input Text  css=#num_doss_complet  PC0130552200013P0
    Input Text  css=#terrain_adresse_voie_numero  0
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=#complet_err_msg
    Page Should Not Contain Element  css=#complet_err_msg

    Depuis la page d'accueil  admin  admin
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}


Création du jeu de données
    [Documentation]  L'objet de ce 'Test Case' est de constituer le jeu de données

    Depuis la page d'accueil  admin  admin
    @{etats_autorises} =    Create List
    ...    delai majore
    ...    delai de notification envoye
    ...    dossier sans notification de delai

    &{args_demande_type} =  Create Dictionary
    ...    code=TESTDOC
    ...    libelle=TESTDOC
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCA (Permis de construire comprenant ou non des démolitions)
    ...    demande_nature=Nouveau dossier
    ...    etats_autorises=@{etats_autorises}
    ...    dossier_instruction_type=PCA - Initial
    ...    evenement=Notification de delai
    ...    document_obligatoire=Doc1

    Ajouter un nouveau type de demande depuis le menu    ${args_demande_type}


    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Guérette
    ...  particulier_prenom=Hedvige
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  789  AB  0023
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE
    ${libelle_di_cadastre} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${libelle_di_cadastre}  accepter un dossier sans réserve
    Set Suite Variable  ${libelle_di_cadastre}

    # Demande associée à un sous-dossier
    ${codeSsDossier} =  Set Variable  030SDND
    @{di_compatibles} =    Create List
    ...    DP - P - Déclaration préalable - Initiale
    &{args_type_di} =  Create Dictionary
    ...  code=${codeSsDossier}
    ...  libelle=Sous Dossier Nvl Demande
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    ...  maj_da_localisation=false
    ${idSsDossierTestAjout} =  Ajouter type de dossier d'instruction  ${args_type_di}

    &{args_demande_type} =  Create Dictionary
    ...    code=TEST${codeSsDossier}
    ...    libelle=Sous Dossier Nvl Demande
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=DP (Déclaration préalable)
    ...    demande_nature=Dossier existant
    ...    dossier_instruction_type=Sous Dossier Nvl Demande
    ...    evenement=Notification de delai
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}

Intégration 'Guichet Unique'

    [Documentation]  Intégration 'Guichet Unique'.

    # Profil GUICHET UNIQUE (mono)
    Vérifier l'intégration de la rubrique 'Guichet Unique' avec l'utilisateur  guichet  guichet
    # Profil ADMINISTRATEUR FONCTIONNEL (mono)
    Vérifier l'intégration de la rubrique 'Guichet Unique' avec l'utilisateur  adminfonct  adminfonct

Intégration 'Guichet Unique > Nouvelle Demande > Nouveau Dossier'

    [Documentation]  Intégration 'Guichet Unique > Nouvelle Demande > Nouveau Dossier'.

    # Profil GUICHET UNIQUE (mono)
    Vérifier l'intégration de l'ajout d'une nouvelle demande / nouveau dossier avec l'utilisateur  guichet  guichet
    # Profil ADMINISTRATEUR FONCTIONNEL (mono)
    Vérifier l'intégration de l'ajout d'une nouvelle demande / nouveau dossier avec l'utilisateur  adminfonct  adminfonct

    # Les demandes de création de sous-dossiers ne doivent pas être visible lorsque l'option
    # option_dossier_saisie_numero_complet est active
    Depuis La Page D'accueil  admin  admin
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo

    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}
    Go To Submenu In Menu  guichet_unique  nouveau-dossier
    Select From List By Label  dossier_autorisation_type_detaille  Déclaration préalable
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select list should not contain value  css=select#demande_type  Sous Dossier Nvl Demande

    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

Intégration 'Guichet Unique > Nouvelle Demande > Autre Dossier'

    [Documentation]  Intégration 'Guichet Unique > Nouvelle Demande > Autre Dossier'.
    ...  - Dépôt d'un modificatif (M01) sur un dossier initial accepté (P0)

    #
    # Constitution du jeu de données spécifique à ce TestCase
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Beauchamps
    ...  particulier_prenom=Jeanette
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  806  AB  0025  A  0030
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE
    ${libelle_di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${libelle_di_sans_espace} =  Sans espace  ${libelle_di}
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${libelle_di}  accepter un dossier sans réserve

    #
    # Ajout de la nouvelle demande
    #
    # On se connecte en tant que guichet unique
    Depuis la page d'accueil  guichet  guichet
    # On clique sur l'entrée de menu dédiée et on vérifie l'intégration
    # - ouverture du menu
    # - titre de la page
    # - titre de l'onglet
    Go To Submenu In Menu  guichet_unique  autre-dossier
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Autre Dossier
    First Tab Title Should Be  Demande

    # On fait une recherche sur le libellé du DI
    Input Text  recherche  ${libelle_di_sans_espace}
    # On valide
    Click On Search Button
    # On clique sur le bouton ajouter du dossier correspondant
    Click Element  css=#action-tab-demande_autre_dossier-left-consulter-${libelle_di_sans_espace}

    # Intégration
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Autre Dossier > ${libelle_di}
    Submenu In Menu Should Be Selected  guichet_unique  autre-dossier

    # Saisie des informations de la demande
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    # On remplit le formulaire
    Saisir la demande  ${args_demande}

    # On valide
    Click On Submit Button
    # Vérification du message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Création du dossier d'instruction n°
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur

    # On télécharge le récépissé de la demande
    Click On Link  link_demande_recepisse
    # On vérifie le contenu du PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le contenu
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  RECEPISSE DE DEPOT
    Page Should Contain  Beauchamps Jeanette
    Close PDF

    # On clique sur le bouton retour
    Click On Back Button
    Page Title Should Be  Tableau De Bord


Intégration 'Guichet Unique > Nouvelle Demande > Récépissé'

    [Documentation]  Intégration 'Guichet Unique > Nouvelle Demande > Récépissé'.
    ...  Vérification des éléments de l'interface et de l'enchainement des écrans
    ...  liés à l'entrée de menu en question permettant de rechercher parmi les
    ...  demandes existantes pour pouvoir éditer de nouveau le récépissé lié.

    #
    # Constitution du jeu de données spécifique à ce TestCase
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=MARTINEZ
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  810  A  0020  A  0025
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE
    ${libelle_di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${libelle_di_sans_espace} =  Sans espace  ${libelle_di}

    Depuis la page d'accueil  guichet  guichet

    # On clique sur l'entrée de menu dédiée et on vérifie l'intégration
    # - ouverture du menu
    # - titre de la page
    # - titre de l'onglet
    Go To Submenu In Menu  guichet_unique  pdf
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Récépissé
    First Tab Title Should Be  Demande

    # On fait une recherche sur le libellé du DI
    Input Text  recherche  ${libelle_di_sans_espace}
    Click On Search Button
    # On clique sur le libellé du dossier
    Click Link  ${libelle_di}

    # On vérifie l'intégration
    # - ouverture du menu
    # - titre de la page
    # - titre de l'onglet
    Submenu In Menu Should Be Selected  guichet_unique  pdf
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Récépissé > ${libelle_di}
    First Tab Title Should Be  Demande

    # Les informations sur la demande doivent être correcetes
    Element Text Should Be  css=#dossier_autorisation_type_detaille  ${args_demande.dossier_autorisation_type_detaille}
    Element Text Should Be  css=#demande_type  ${args_demande.demande_type}
    Element Should Contain  css=#petitionnaire_principal_delegataire .synthese_demandeur  ${args_petitionnaire.particulier_nom} ${args_petitionnaire.particulier_prenom}

    # On clique sur l'action dédiée 'Éditer le récepissé PDF'
    Click On Form Portlet Action  demande  pdfetat  new_window
    # On vérifie le contenu du PDF
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  RECEPISSE DE DEPOT
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${libelle_di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${args_petitionnaire.particulier_nom} ${args_petitionnaire.particulier_prenom}
    Close PDF

    # On clique sur "Retour"
    Click On Back Button
    # On vérifie l'intégration
    # - ouverture du menu
    # - titre de la page
    # - titre de l'onglet
    Submenu In Menu Should Be Selected  guichet_unique  pdf
    Page Title Should Be  Guichet Unique > Nouvelle Demande > Récépissé
    First Tab Title Should Be  Demande


Affichage de la date de dépôt par defaut
    [Documentation]  Permet de vérifier le bon fonctionnement de l'affichage de
    ...    la date de dépôt ou non

    Depuis la page d'accueil  admin  admin
    # On ouvre le menu nouveau dossier
    Depuis le contexte de nouvelle demande via le menu
    # On sélectionne le type de dossier d'autorisation détaillé
    Select From List By Label  dossier_autorisation_type_detaille  Permis de construire comprenant ou non des démolitions
    Wait Until Element Is Visible  css=select#demande_type
    Select From List By Label  demande_type  Dépôt Initial
    Wait Until Element Is Visible  css=input#date_demande
    Textfield Should Contain  date_demande  ${date_ddmmyyyy}

    &{param_values} =  Create Dictionary
    ...  libelle=option_date_depot_demande_defaut
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # On ouvre le menu nouveau dossier
    Depuis le contexte de nouvelle demande via le menu
    # On sélectionne le type de dossier d'autorisation détaillé
    Select From List By Label  dossier_autorisation_type_detaille  Permis de construire comprenant ou non des démolitions
    Select From List By Label  demande_type  Dépôt Initial
    Textfield Should Contain  date_demande  ${EMPTY}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_date_depot_demande_defaut
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}


Ajout demande avec documents obligatoires
    [Documentation]  L'objet de ce 'Test Case' est de vérifier l'ajout d'une demande
    ...    avec des documents obligatoire

    # En tant que guichetier
    Depuis la page d'accueil  guichet  guichet
    # On ouvre le menu nouveau dossier
    Depuis le contexte de nouvelle demande via le tableau de bord
    # On sélectionne le type de dossier d'autorisation détaillé
    Select From List By Label  dossier_autorisation_type_detaille  Permis de construire comprenant ou non des démolitions
    # On sélectionne le type de demande
    Wait Until Element Is Visible  css=select#demande_type
    Select From List By Label  demande_type  TESTDOC
    # Vérification du chargement du dialog
    Wait Until Keyword Succeeds    ${TIMEOUT}    ${RETRY_INTERVAL}    Element Should Contain    css=#ui-dialog-title-liste_doc    Liste des documents obligatoires
    # Validation du dialog et verification du message d'alerte
    Click Element Until Alert
    ...  css=.ui-dialog-buttonset button:nth-child(2) .ui-button-text
    ...  Tous les documents doivent être présents. Dans le cas contraire, rejeter la demande.
    # Fermeture du dialog et vérification de l'erreur
    Click Element Until Alert
    ...  css=.ui-dialog-titlebar-close
    ...  Tous les documents doivent être présents. Dans le cas contraire, rejeter la demande.
    # Rejet de la demande avec annulation
    Click Element Until Alert
    ...  xpath=//span[text()[contains(.,"Rejeter la demande")]]
    ...  Êtes vous sur de vouloir rejeter la demande ?
    ...  LEAVE
    Handle Alert  DISMISS
    # Rejet de la demande
    Click Element Until Alert
    ...  xpath=//span[text()[contains(.,"Rejeter la demande")]]
    ...  Êtes vous sur de vouloir rejeter la demande ?
    # Vérification du rechargement de la page
    Wait Until Page Contains Element    css=#dossier_autorisation_type_detaille
    Element Should Not Be Visible    css=#demande_type
    # On sélectionne le type de dossier d'autorisation détaillé
    Select From List By Label  dossier_autorisation_type_detaille  Permis de construire comprenant ou non des démolitions
    # On sélectionne le type de demande
    Wait Until Element Is Visible  css=select#demande_type
    Select From List By Label  demande_type  TESTDOC
    # Vérification du chargement du dialog
    Wait Until Element Contains    css=#ui-dialog-title-liste_doc    Liste des documents obligatoires
    # Vérifie que la case à cocher est bien présente
    Wait Until Page Contains Element    css=.ui-dialog input[type="checkbox"]
    # Coche la case et Vérifie qu'elle a bien été sélectionnée
    Select Checkbox    css=.ui-dialog input[type="checkbox"]
    Checkbox Should Be Selected  css=.ui-dialog input[type="checkbox"]
    # Validation du dialog
    Click Button    Valider
    # vérification de la fermeture du dialog
    Element Should Not Be Visible    css=#ui-dialog-title-liste_doc
    # Ajout d'un pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Cole
    ...  particulier_prenom=Sarah
    ...  frequent=true
    Ajouter le demandeur  petitionnaire_principal    ${args_petitionnaire}
    # On valide
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur


TNR Récupération de l'édition et logo
    [Documentation]  L'objet de ce 'Test Case' est de vérifier que la bonne édition
    ...  et le bon logo sont récupérés dans le récépissé de la demande

    # En tant qu'admin
    Depuis la page d'accueil    admingen    admingen

    # On crée une nouvelle demande via le tableau de bord
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Fistaul
    ...  particulier_prenom=Sarah
    ...  om_collectivite=ALLAUCH

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=ALLAUCH
    # On crée une nouvelle demande via le tableau de bord
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    # On ouvre le récépissé de la demande
    Click Element  css=#link_demande_recepisse
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie la localisation du terrain
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Commune : Allauch
    # On ferme le PDF
    Close PDF


TNR Récupération des paramètres de collectivité dans le récépissé de dépôt
    [Documentation]  L'objet de ce 'Test Case' est de vérifier que les paramètres
    ...    de la collectivité sont bien fusionné avec le récépissé de dépôt

    # En tant que guichet
    Depuis la page d'accueil    guichetsuivi    guichetsuivi
    # On crée une nouvelle demande via le tableau de bord
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Crosh
    ...  particulier_prenom=Sarah

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial

    # On crée une nouvelle demande via le tableau de bord
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    # On ouvre le récépissé de la demande
    Click Element  css=#link_demande_recepisse
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On va sur la seconde page
    Next Page PDF
    # On vérifie la localisation du terrain
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain   Marseille , le${SPACE}${SPACE}${date_ddmmyyyy}
    # On ferme le PDF
    Close PDF

Activation de l'option de numérisation
    [Documentation]  Activation de l'option de numérisation dans un test case
    ...  spécifique pour stabiliser le test suivant.
    Activer l'option de numérisation


Ajout d'une demande avec création de répertoire de numérisation

    [Documentation]  Permet de vérifier la création du répertoire de numérisation du
    ...  dossier d'instruction, ainsi que sa date de modification avant et après qu'une
    ...  demande sur existant soit ajoutée au dossier.

    Depuis la page d'accueil  instrpoly  instrpoly
    # On crée une nouvelle demande via le tableau de bord
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Fongemie
    ...  particulier_prenom=Christiane
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Vérification de la création du dossier et récupération du nom du répertoire contenant les pièces du dossier
    ${repertoire_numerisation_dossier} =  Vérifier création répertoire du dossier  ${di_libelle}
    # On récupère la date de dernière modification du répertoire
    ${create_time} =   Get Modified Time   ${EXECDIR}${/}..${/}var${/}digitalization${/}Todo${/}${repertoire_numerisation_dossier}
    # Ajout du sleep si non ca va trop vite et c'est la même heure entre create et modify
    Sleep  1
    &{args_demande} =  Create Dictionary
    ...  demande_type=Dépôt de pièces complémentaire
    ...  om_collectivite=MARSEILLE
    ...  dossier_instruction=${di_libelle}
    Ajouter la demande par WS  ${args_demande}
    # On vérifie la présence du lien
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#dossier_libelle  ${di_libelle}
    # Les dates de création et de modification du répertoire ne doivent pas être égales
    ${modify_time} =   Get Modified Time   ${EXECDIR}${/}..${/}var${/}digitalization${/}Todo${/}${repertoire_numerisation_dossier}
    Should Not Be Equal  ${create_time}  ${modify_time}


Désactivation de l'option de numérisation
    [Documentation]  Désactivation de l'option de numérisation dans un test case
    ...  spécifique pour stabiliser le test précédent.
    Désactiver l'option de numérisation


Affichage réglementaire

    [Documentation]  Test de la fonctionnalité 'Affichage réglementaire'

    # On se connecte à l'application
    Depuis la page d'accueil  guichet  guichet
    # On clique sur le menu "Attestation"
    Go To Submenu In Menu  guichet_unique  affichage_reglementaire_attestation
    # On vérifie le nom de l'onglet
    First Tab Title Should Be  Imprimer L'attestation D'affichage Réglementaire
    # On écrit "PC0130551200002P0" dans le champ dossier
    Input Text  css=#dossier  PC0130551200002P0
    # On clique sur "Valider"
    Click On Submit Button Until Message  Ce dossier n'a jamais été affiché
    # On vérifie que le texte est présent
    Error Message Should Contain  Ce dossier n'a jamais été affiché
    # # On clique sur le menu "Registre"
    Go To Submenu In Menu  guichet_unique  affichage_reglementaire_registre
    # On vérifie le nom de l'onglet
    First Tab Title Should Be  Traitement Du Registre D'affichage Réglementaire
    # On clique sur "Déclencher le traitement"
    Click Element  id=registre-form-submit
    # On vérifie que le traitement ne se déclenche pas
    Cliquer sur le bouton de la fenêtre modale  Annuler
    Page Should Not Contain Element  css=div#form-message div#message
    # On clique sur "Déclencher le traitement"
    Click Element  id=registre-form-submit
    # On valide le traitement
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    # On ouvre le PDF
    Wait Until Keyword Succeeds  1 min  0.1 sec  Valid Message Should Contain  Traitement terminé. Le registre a été généré.
    Click Element  id=registre-form-download
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le titre du PDF
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Registre des dossiers en cours
    # On ferme le PDF
    Close PDF
    # On vérifie que le texte est présent
    Valid Message Should Contain  Traitement terminé. Le registre a été généré.
    # On clique sur le menu "Attestation"
    Go To Submenu In Menu  guichet_unique  affichage_reglementaire_attestation
    # On vérifie le nom de l'onglet
    First Tab Title Should Be  Imprimer L'attestation D'affichage Réglementaire
    # On clique sur "Valider"
    Click On Submit Button Until Message  Veuiller saisir un N° de dossier.
    # On vérifie que le texte est présent
    Error Message Should Contain  Veuiller saisir un N° de dossier.
    # On écrit "123" dans le champ dossier
    Input Text  css=#dossier  123
    # On clique sur "Valider"
    Click On Submit Button Until Message  Ce dossier n'existe pas.
    # On vérifie que le texte est présent
    Error Message Should Contain  Ce dossier n'existe pas.
    # On écrit "PC0130551200002P0" dans le champ dossier
    Input Text  css=#dossier  PC0130551200002P0
    # On clique sur "Valider"
    Click On Submit Button Until Message  Cliquez sur le lien ci-dessous pour télécharger votre attestation d'affichage
    # On vérifie que le texte est présent
    Valid Message Should Contain  Cliquez sur le lien ci-dessous pour télécharger votre attestation d'affichage
    # On clique sur "Attestation d'affichage"
    Click Link  Attestation d'affichage
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le titre du PDF
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ATTESTATION D'AFFICHAGE REGLEMENTAIRE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  PC 013055 12 00002P0
    # On ferme le PDF
    Close PDF
    # Supprime le dernier message de succès en retournant dans la page de saisie du numéro de dossier
    Go To Submenu In Menu  guichet_unique  affichage_reglementaire_attestation
    # On écrit "PC 013055 12 00002P0" dans le champ dossier avec des espaces
    Input Text  css=#dossier  PC 013055 12 00002P0
    # On clique sur "Valider"
    Click On Submit Button Until Message  Cliquez sur le lien ci-dessous pour télécharger votre attestation d'affichage
    # On vérifie que le texte est présent
    Valid Message Should Contain  Cliquez sur le lien ci-dessous pour télécharger votre attestation d'affichage
    # On clique sur "Attestation d'affichage"
    Click Link  Attestation d'affichage
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le titre du PDF
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ATTESTATION D'AFFICHAGE REGLEMENTAIRE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  PC 013055 12 00002P0
    # On ferme le PDF
    Close PDF

    # On se connecte en tant qu'instructeur pour définaliser l'instruction
    # et vérifier le bon message lorsque le guichet tente de sortir l'attestation PDF
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet instruction du dossier d'instruction  PC 013055 12 00002P0
    Click Link  affichage_obligatoire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Be In SubForm  instruction  definaliser
    Click On SubForm Portlet Action  instruction  definaliser
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be In Subform  La définalisation du document s'est effectuée avec succès.
    Depuis la page d'accueil  guichet  guichet
    Go To Submenu In Menu  guichet_unique  affichage_reglementaire_attestation
    Input Text  css=#dossier  PC 013055 12 00002P0
    Click On Submit Button Until Message  L'attestation de ce dossier existe mais n'est pas finalisée.
    Error Message Should Contain  L'attestation de ce dossier existe mais n'est pas finalisée.


Ajout d'une demande sans récépissé de dépôt

    [Documentation]  Au dépôt d'une demande, un lien permettant de télécharger
    ...  le récépissé est affiché dans le message de validation même si
    ...  l'instruction initiale n'a pas de lettre type (pas de récépissé).
    ...  L'action permettant de régénérer ce même document ne doit pas être
    ...  disponible.

    # On supprime la lettre type de l'événement de dépôt des PCI mais avant on
    # récupère la valeur de ce champ pour le repositionner à la fin de ce test
    Depuis la page d'accueil  admin  admin
    # On récupère la valeur de la lettre type depuis le formulaire de
    # modification
    Depuis le contexte de l'événement  Notification du delai legal maison individuelle
    Click On Form Portlet Action  evenement  modifier
    ${label_lettretype} =  Get Text  css=.form-content select#lettretype option:checked
    # On modifie la valeur de la lettre type depuis le même formulaire de
    # modification pour ne pas perdre de temps
    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  lettretype=choisir Lettre type
    Saisir l'événement  ${args_evenement}
    Click On Submit Button
    La page ne doit pas contenir d'erreur
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On ajoute une nouvelle demande
    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bonenfant
    ...  particulier_prenom=Germain

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    # On vérifie que dans le message de validation il n'est pas possible de
    # télécharger le récépissé (qui n'existe pas)
    Element Should Not Contain  css=div.message.ui-state-valid p span.text  Télécharger le récépissé de la demande

    # On clique sur le lien du message de validation pour accéder au DI
    Click Link  css=#link_demande_dossier_instruction

    # On vérifie que l'action de régénérer le récépissé n'est pas disponible
    Element Should Not Contain  css=#portlet-actions  Télécharger le récépissé de la demande

    # On repositionne la lettre type de l'événement de dépôt des PCI
    Depuis la page d'accueil  admin  admin
    #
    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  lettretype=${label_lettretype}
    Modifier l'événement  ${args_evenement}


Affectation automatique

    [Documentation]  Ce test case a pour but de vérifier le fonctionnement de
    ...  l'affectation automatique des dossiers en fonction de leur type de dossier
    ...  d'autorisation détaillé, du type de dossier d'instruction et en fonction
    ...  du code quartier des références cadastrales.

    ## Cas d'utilisation n°1 : dossier affecté à l'instructeur agglo car aucun instructeur
    # mono ne correspond au type de dossier d'autorisation détaillé
    Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Morneau
    ...  particulier_prenom=Gérard
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    Click Element  css=a#link_demande_recepisse
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Dossier suivi par
    Page Should Contain  Poly Com Marseille
    Close PDF
    Click Element  link_demande_dossier_instruction
    Wait Until Element Is Visible  instructeur
    Element Text Should Be  instructeur  Poly Com Marseille (J)

    ## Cas d'utilisation n°2 : dossier PCI avec code quartier 806 -> affectation à Louis Laurent
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Morneau
    ...  particulier_prenom=Gérard
    @{ref_cad} =  Create List  806  AB  0025  A  0030
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    Click Element  css=a#link_demande_recepisse
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Dossier suivi par
    Page Should Contain  Louis Laurent
    Close PDF
    Click Element  link_demande_dossier_instruction
    Wait Until Element Is Visible  instructeur
    Element Text Should Be  instructeur  Louis Laurent (H)

    ## Cas d'utilisation n°3 : dossier PCI avec code quartier 801 -> affectation à Pierre Martin
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Morneau
    ...  particulier_prenom=Gérard
    @{ref_cad} =  Create List  801  AB  0025  A  0030
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle2} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    Click Element  css=a#link_demande_recepisse
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Dossier suivi par
    Page Should Contain  Pierre Martin
    Close PDF
    Click Element  link_demande_dossier_instruction
    Wait Until Element Is Visible  instructeur
    Element Text Should Be  instructeur  Pierre Martin (H)

    ## Cas d'utilisation n°4 : dossier PCI avec code quartier 801 et type DI initial -> affectation à Louis Laurent
    # et non pas à Pierre Martin
    Depuis la page d'accueil  admin  admin
    &{instr} =  Create Dictionary
    ...  nom=Andrea Galarneau
    ...  division=subdivision H
    ...  instructeur_qualite=instructeur
    Ajouter l'instructeur  ${instr}
    &{aff_auto} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  instructeur=${instr.nom} (H)
    ...  dossier_instruction_type=Permis de construire pour une maison individuelle et / ou ses annexes - Initial (P)
    ...  arrondissement=1
    ...  quartier=01 – BELSUNCE
    Ajouter l'affectation depuis le menu  ${aff_auto}
    # On crée une nouvelle demande via le tableau de bord
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Perrault
    ...  particulier_prenom=Sophie
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  801  AB  0025  A  0030
    &{args_demande} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Static Value Should Contain  css=#instructeur  ${instr.nom}

    #
    Supprimer l'affectation depuis le menu  ${aff_auto.instructeur}  ${aff_auto.dossier_instruction_type}


Affectation automatique améliorée

    [Documentation]  Ce test case a pour but de vérifier le fonctionnement de
    ...  l'affectation automatique des dossiers en fonction de l'affectation
    ...  manuellement sélectionnée.

    # Sans affectation manuelle définie le champs d'affectation automatique n'est pas montré
    # dans la nouvelle demande
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte de nouvelle demande via l'URL
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=select#affectation_automatique

    # Ajout du paramétrage d'affectation automatiques avec affectation manuelle
    Depuis la page d'accueil  admin  admin
    &{aff_auto_marseille_1} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  instructeur=Instr. Service Marseille (H)
    ...  affectation_manuelle=MARS - Instr. Service Marseille

    Ajouter l'affectation depuis le menu  ${aff_auto_marseille_1}

    &{aff_auto_marseille_2} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  instructeur=Pierre Martin (H)
    ...  affectation_manuelle=MARS - P. Martin

    Ajouter l'affectation depuis le menu  ${aff_auto_marseille_2}

    &{aff_auto_marseille_3} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  instructeur=Roland Richard (J)
    ...  affectation_manuelle=MARS - R. Richard

    Ajouter l'affectation depuis le menu  ${aff_auto_marseille_3}

    &{aff_auto_allauch} =  Create Dictionary
    ...  om_collectivite=ALLAUCH
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  instructeur=Martine Nadeau (H)
    ...  affectation_manuelle=ALLAUCH - M. Nadeau

    Ajouter l'affectation depuis le menu  ${aff_auto_allauch}

    # Avec une affectation manuelle définie, le champs d'affectation automatique est présent
    # dans la nouvelle demande
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label  css=select#dossier_autorisation_type_detaille  Permis de construire pour une maison individuelle et / ou ses annexes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=select#affectation_automatique
    ${aff_auto_mars_pcmi_list} =  Create List  choisir affectation automatique  MARS - Instr. Service Marseille  MARS - P. Martin
    ${aff_auto_list} =  Get List Items  css=select#affectation_automatique
    Lists Should Be Equal  ${aff_auto_list}  ${aff_auto_mars_pcmi_list}

    # Lorsqu'il y a plusieurs affectations automatiques, les affectations automatiques sont mises à jour
    # en fonction de la sélection du DAdt sélectionné
    Select From List By Label  css=select#dossier_autorisation_type_detaille  Permis de construire comprenant ou non des démolitions
    Wait Until Element Is Visible  css=select#demande_type
    Select From List By Label  css=select#demande_type  Dépôt Initial
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=select#affectation_automatique
    ${aff_auto_mars_pc_list} =  Create List  choisir affectation automatique  MARS - R. Richard
    ${aff_auto_list} =  Get List Items  css=select#affectation_automatique
    Lists Should Be Equal  ${aff_auto_list}  ${aff_auto_mars_pc_list}

    # Lorsqu'il y a plusieurs affectations automatiques, les affectations automatiques sont mises à jour
    # en fonction de la sélection de la collectivité sélectionnée
    Depuis la page d'accueil  instrpolycomm3  instrpolycomm3
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label  css=select#dossier_autorisation_type_detaille  Permis de construire pour une maison individuelle et / ou ses annexes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=select#affectation_automatique
    ${aff_auto_allauch_pcmi_list} =  Create List  choisir affectation automatique  ALLAUCH - M. Nadeau
    ${aff_auto_list} =  Get List Items  css=select#affectation_automatique
    Lists Should Be Equal  ${aff_auto_list}  ${aff_auto_allauch_pcmi_list}

    # Si aucune affectation manuelle n'est défini, l'affectation
    # du dossier doit être celle par défaut (tenant compte des autres affectation automatiques
    # non-manuelles)
    &{args_petitionnaire_1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=DEMANDEAFFAUTO1
    ...  particulier_prenom=TEST
    &{args_autres_demand_1} =  Create Dictionary
    ...  contrevenant_principal=${args_petitionnaire_1}

    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial

    Depuis la page d'accueil  juriste  juriste
    ${num_di_1} =  Ajouter la nouvelle demande  ${args_demande_1}  ${EMPTY}  ${args_autres_demand_1}  menu=contentieux
    ${instr_1} =  Obtenir l'instructeur du dossier d'instruction  ${num_di_1}  menu=infraction
    Should Be True  "${instr_1}" == "Juriste (H)"
    ${instr_sec_1} =  Obtenir l'instructeur secondaire du dossier d'instruction  ${num_di_1}  menu=infraction
    Should Be True  "${instr_sec_1}" == "Technicien (H)"

    # Si aucune valeur n'est sélectionnée pour l'affectation automatique, l'affectation
    # du dossier doit être celle par défaut (tenant compte des autres affectation automatiques
    # non-manuelles)
    &{args_petitionnaire_2} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=DEMANDEAFFAUTO2
    ...  particulier_prenom=TEST

    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial

    Depuis la page d'accueil  guichet  guichet
    ${num_di_2} =  Ajouter la nouvelle demande  ${args_demande_2}  ${args_petitionnaire_2}
    ${instr_2} =  Obtenir l'instructeur du dossier d'instruction  ${num_di_2}
    Should Be True  "${instr_2}" == "Louis Laurent (H)"

    # Si l'affectation automatique est sélectionnée manuellement, le dossier doit être affecté à
    # l'instructeur spécifié dans l'affectation automatique
    &{args_petitionnaire_3} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=DEMANDEAFFAUTO3
    ...  particulier_prenom=TEST

    &{args_demande_3} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  affectation_automatique=MARS - Instr. Service Marseille

    ${num_di_3} =  Ajouter la nouvelle demande  ${args_demande_3}  ${args_petitionnaire_3}
    ${instr_3} =  Obtenir l'instructeur du dossier d'instruction  ${num_di_3}
    Should Be True  "${instr_3}" == "Instr. Service Marseille (H)"

    # Suppression des affectations automatiques
    Depuis la page d'accueil  admin  admin
    Supprimer l'affectation manuelle depuis le menu  MARS - Instr. Service Marseille
    Supprimer l'affectation manuelle depuis le menu  MARS - P. Martin
    Supprimer l'affectation manuelle depuis le menu  MARS - R. Richard
    Supprimer l'affectation manuelle depuis le menu  ALLAUCH - M. Nadeau

TNR Test des codes insee des communes contenant des lettres pour l'affectation automatique

    [Documentation]  Ce test case a pour but de vérifier que les codes insee
    ...  contenant des lettres ne sont pas rejeté lors de la vérification

    Depuis la page d'accueil  admin  admin
    # Activation du paramètre permettant d'accéder au champ commune
    &{param_division} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # L'affectation doit fonctionner
    &{aff_auto_agglo_1} =  Create Dictionary
    ...  om_collectivite=agglo
    ...  communes=13014,2A004,74000
    ...  affectation_manuelle=agglo - test code insee 1
    Ajouter l'affectation depuis le menu  ${aff_auto_agglo_1}

    # Les codes insee non valide doivent être rejeté
    &{aff_auto_agglo_2} =  Create Dictionary
    ...  om_collectivite=agglo
    ...  communes=13#04
    &{aff_auto_agglo_3} =  Create Dictionary
    ...  om_collectivite=agglo
    ...  communes=13045,

    : FOR  ${index}  IN RANGE  2  3
    \  Depuis le tableau des affectations
    \  Click On Add Button
    \  Saisir l'affectation  ${aff_auto_agglo_${index}}
    \  Click On Submit Button
    \  Error Message Should Contain   Valeur de communes invalide (autorisés: chiffres et virgules, 1er et dernier caractères différent d'une virgule).

    # Réinitialisation des paramètres
    Supprimer l'affectation manuelle depuis le menu  agglo - test code insee 1

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_commune
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

Vérification des références cadastrales
    [Documentation]  Teste les messages d'erreur lors de la saisie des références
    ...  cadastrales dans le contexte d'une nouvelle demande et la présence
    ...  de ce champ pour une demande sur existant.


    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=DURAND
    ...  particulier_prenom=MICKAEL

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial

    @{ref_cad} =  Create List  806  DC  ''

    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte de nouvelle demande via l'URL
    Saisir la demande  ${args_demande}
    Ajouter le demandeur  petitionnaire_principal  ${args_petitionnaire}
    Saisir les références cadastrales  ${ref_cad}

    ${css_path_ref_cad_fields} =  Set Variable  .reference_cadastrale_custom_fields .reference_cadastrale_custom_field:nth-child

    # Pour les refcad 806 DC ''
    # Appel au trigger JS qui contrôle la valeur du champ de refcad
    Execute JavaScript  window.jQuery("${css_path_ref_cad_fields}(3)").trigger("change");
    ${alert} =  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Handle Alert
    Should Contain  ${alert}  Vous ne devez saisir que des nombres entiers

    # Pour les refcad 806 1 22
    # Lorsqu'on a un seul chiffre on rempli automatiquement de 0 à gauche
    Input Text  css=${css_path_ref_cad_fields}(3)  22
    Input Text  css=${css_path_ref_cad_fields}(2)  1
    Execute JavaScript  window.jQuery("${css_path_ref_cad_fields}(2)").trigger("change");

    # Pour les refcad 806 ; 22
    Input Text  css=${css_path_ref_cad_fields}(3)  22
    Input Text  css=${css_path_ref_cad_fields}(2)  ;
    Execute JavaScript  window.jQuery("${css_path_ref_cad_fields}(2)").trigger("change");
    ${alert} =  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Handle Alert
    Should Be Equal As Strings  ${alert}  Il ne s'agit pas d'une chaîne alphanumérique.

    # Pour les refcad 806 01 22 A on doit avoir un message 
    # d'erreur précisant que la réf est incorrecte
    Input Text  css=${css_path_ref_cad_fields}(2)  1
    Input Text  css=${css_path_ref_cad_fields}(3)  22
    Click Element  css=#moreFieldReferenceCadastrale0
    Input Text  css=${css_path_ref_cad_fields}(4)  A

    # Validation de création de la demande
    Click Element  css=#formulaire div.formControls input[type="submit"]
    ${alert} =  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Handle Alert
    Should Be Equal As Strings  ${alert}  Les références cadastrales saisies sont incorrectes. Veuillez les corriger.

    # Vérification de la présence de references cadastrales sur un dossier existant
    Depuis le contexte de demande sur existant via l'URL  ${libelle_di_cadastre}
    Select From List By Label  demande_type  Demande de modification
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=.reference_cadastrale_custom_fields


TNR Fonctionnement des champs custom de références cadastrale en cas de réaffichage
    [Documentation]  En cas d'erreur (e.g. oublie de pétitionnaire) ou de type
    ...  de demande. Les champs de refcad sont réaffichés et à cause d'un bug,
    ...  les valeurs étaient corrompues et certains boutons « ajouter d'autres
    ...  champs » étaient cassés.
    ...  Il s'agit donc de tester tout les endroits où il y a ces champs.
    ...  1 Nouvelle demande, changement du type, check bouton.
    ...  2 Suite ↑, saisie ref, erreur, check refcad et bouton.
    ...  3 Suite ↑, changement du type, check refcad et bouton.
    ...  4 Ajout d'une demande sur dossier existant. Il y a une vue des refcad.
    ...  5 Nouvelle demande, recours contentieux. Il y a un champ refcad.
    ...    Test après changement du type aussi.
    ...  6 Modif DI, ajout refs, erreur, check refcad et bouton

    # ## 1 ##
    Depuis la page d'accueil  admin  admin
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label  dossier_autorisation_type_detaille  Permis de démolir
    Select From List By Label  dossier_autorisation_type_detaille  Infraction
    Sleep  2  # obligation d'attendre car lors d'un changement de type de dossier il y a une temporisation JS d'une seconde
    Wait Until Element Is Visible  css=#moreFieldReferenceCadastrale0
    Click Element Until New Element  css=#moreFieldReferenceCadastrale0  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(5)
    # Deux nouvaux champs devraient avoir été ajoutés
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=5
    # changement de type pour reset le nombre de champs
    Select From List By Label  dossier_autorisation_type_detaille  Permis de démolir
    Sleep  2  # obligation d'attendre car lors d'un changement de type de dossier il y a une temporisation JS d'une seconde

    ## 2 ##
    Wait Until Element Is Visible  css=.reference_cadastrale_custom_fields
    # Saisie de 812BC8834A8856 878DE8898
    @{ref_cad} =  Create List  812  BC  8834  A  8856
    Saisir les références cadastrales  ${ref_cad}  # 1re ligne
    Click Element Until New Element  css=#morelineReferenceCadastrale  css=.reference_cadastrale_custom_fields > br:nth-child(7)
    # 1er champ, 2e ligne (dans le groupe de champs, parmis les noeuds suivants
    # frères du br, celui avec le placeholder "Quart.")
    Input Text  css=.reference_cadastrale_custom_fields br ~ input[placeholder="Quart."]
    ...  878
    # 2e champ, 2e ligne
    Input Text  css=.reference_cadastrale_custom_fields br ~ input[placeholder="Sect."]
    ...  DE
    # 3e champ, 2e ligne
    Input Text  css=.reference_cadastrale_custom_fields br ~ input[placeholder="Parc."]
    ...  8898

    # On s'assure que les assertions sur les champs marchent quand l'état est
    # propre. Avant de commencer à maltraiter le formulaire.
    # Check nombre et contenu des champs. Et que le JS peut bien les lire.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=8
    Execute Javascript  getDataFieldReferenceCadastrale();
    Textarea Value Should Be  css=#terrain_references_cadastrales
    ...  812BC8834A8856;878DE8898;

    # Déclenchement erreur (pas de collectivité ni pétionnaire)
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE
    # Check nombre et contenu des champs. Et que le JS peut bien les lire.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=8
    # Check fonctionnement des boutons
    Click Element Until New Element  css=#moreFieldReferenceCadastrale0  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(7)
    Click Element Until New Element  css=#moreFieldReferenceCadastrale1  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(14)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=12
    Execute Javascript  getDataFieldReferenceCadastrale();
    Textarea Value Should Be  css=#terrain_references_cadastrales
    ...  812BC8834A8856;878DE8898;


    ## 3 ##
    Select From List By Label  dossier_autorisation_type_detaille  Infraction
    Sleep  2  # obligation d'attendre car lors d'un changement de type de dossier il y a une temporisation JS d'une seconde
    Wait Until Element Is Visible  css=.reference_cadastrale_custom_fields
    # Check nombre et contenu des champs. Et que le JS peut bien les lire.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=8
    # Check fonctionnement des boutons
    Click Element Until New Element  css=#moreFieldReferenceCadastrale0  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(7)
    Click Element Until New Element  css=#moreFieldReferenceCadastrale1  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(14)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=12
    # Check valeur après nombre champs pour être sûr que l'ancienne valeur n'est plus là.
    # Car le nombre de champs change entre la partie d'avant et celle-ci donc
    # pas de risque que l'assert passe si ça va trop vite. Alors que la valeur ne
    # change pas donc ça pourrait faire un faux négatif.
    Execute Javascript  getDataFieldReferenceCadastrale();
    Textarea Value Should Be  css=#terrain_references_cadastrales
    ...  812BC8834A8856;878DE8898;


    ## 4 ##
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pavlovic
    ...  particulier_prenom=Patrik
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Click On Form Portlet Action  dossier_instruction  modifier
    Open Fieldset  dossier_instruction  localisation

    # Saisie de 812BC8834A8856 878DE8898
    @{ref_cad} =  Create List  812  BC  8834  A  8856
    Saisir les références cadastrales  ${ref_cad}  # 1re ligne
    Click Element  css=#morelineReferenceCadastrale
    # 1er champ, 2e ligne (dans le groupe de champs, parmis les noeuds suivants
    # frères du br, celui avec le placeholder "Quart.")
    Input Text  css=.reference_cadastrale_custom_fields br ~ input[placeholder="Quart."]
    ...  878
    # 2e champ, 2e ligne
    Input Text  css=.reference_cadastrale_custom_fields br ~ input[placeholder="Sect."]
    ...  DE
    # 3e champ, 2e ligne
    Input Text  css=.reference_cadastrale_custom_fields br ~ input[placeholder="Parc."]
    ...  8898

    Click On Submit Button
    Valid Message Should Be  Vos modifications ont bien été enregistrées.

    Ajouter une instruction au DI et la finaliser  ${di_libelle}
    ...  accepter un dossier sans réserve
    Depuis le contexte de demande sur existant via l'URL  ${di_libelle}
    Select From List By Label  demande_type  Demande de modification
    Wait Until Element Is Visible  css=.reference_cadastrale_custom_fields
    # Check nombre et contenu des champs. Et que le JS peut bien les lire.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=8
    Execute Javascript  getDataFieldReferenceCadastrale();
    ${refad_from_fields} =  Get Value  terrain_references_cadastrales
    Should Be Equal  812BC8834A8856;878DE8898;  ${refad_from_fields}

    # Changement de type pour réafficher les champs
    Select From List By Label  demande_type  Demande d'ouverture de chantier
    Wait Until Element Is Visible  css=.reference_cadastrale_custom_fields
    Wait Until All JavaScript Finished  # Si tout se passe trop vite, il y aura encore l'ancienne valeur
    # Check nombre et contenu des champs. Et que le JS peut bien les lire.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=8
    Execute Javascript  getDataFieldReferenceCadastrale();
    ${refad_from_fields} =  Get Value  terrain_references_cadastrales
    Should Be Equal  812BC8834A8856;878DE8898;  ${refad_from_fields}

    # Rechangement de type car les champs peuvent se casser de plus en plus avec
    # les réaffichages.
    Select From List By Label  demande_type  Demande de modification
    Wait Until Element Is Visible  css=.reference_cadastrale_custom_fields
    Wait Until All JavaScript Finished  # Si tout se passe trop vite, il y aura encore l'ancienne valeur
    # Check nombre et contenu des champs. Et que le JS peut bien les lire.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=8
    Execute Javascript  getDataFieldReferenceCadastrale();
    ${refad_from_fields} =  Get Value  terrain_references_cadastrales
    Should Be Equal  812BC8834A8856;878DE8898;  ${refad_from_fields}


    ## 5 ##
    Depuis le contexte de nouvelle demande via l'URL
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  autorisation_contestee=${di_libelle}
    Saisir la demande  ${args_demande}

    # Check nombre et contenu des champs. Et que le JS peut bien les lire.
    Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=8
    # Check fonctionnement des boutons
    Click Element Until New Element  css=#moreFieldReferenceCadastrale0  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(7)
    Click Element Until New Element  css=#moreFieldReferenceCadastrale1  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(14)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=12
    Execute Javascript  getDataFieldReferenceCadastrale();
    Textarea Value Should Be  css=#terrain_references_cadastrales
    ...  812BC8834A8856;878DE8898;

    # Changement de type pour réafficher les champs
    Select From List By Label  dossier_autorisation_type_detaille  Recours gracieux
    Sleep  2  # obligation d'attendre car lors d'un changement de type de dossier il y a une temporisation JS d'une seconde
    Wait Until Element Is Visible  css=.reference_cadastrale_custom_fields
    Wait Until All JavaScript Finished

    # Check nombre et contenu des champs. Et que le JS peut bien les lire.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=8
    # Check fonctionnement des boutons
    Click Element Until New Element  css=#moreFieldReferenceCadastrale0  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(7)
    Click Element Until New Element  css=#moreFieldReferenceCadastrale1  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(14)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=12
    Execute Javascript  getDataFieldReferenceCadastrale();
    Textarea Value Should Be  css=#terrain_references_cadastrales
    ...  812BC8834A8856;878DE8898;


    ## 6 ##
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Click On Form Portlet Action  dossier_instruction  modifier
    Open Fieldset  dossier_instruction  localisation
    Open Fieldset  dossier_instruction  demandeur
    # Suppression pétitionnnaire pour faire échouer la modification
    Click Element  css=[id^=petitionnaire_principal] .demandeur_del
    # Déclenchement erreur (plus de pétionnaire)
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE

    Open Fieldset  dossier_instruction  demandeur
    Open Fieldset  dossier_instruction  localisation
    # Check nombre et contenu des champs. Et que le JS peut bien les lire.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=8
    # Check fonctionnement des boutons
    Click Element Until New Element  css=#moreFieldReferenceCadastrale0  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(7)
    Click Element Until New Element  css=#moreFieldReferenceCadastrale1  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field:nth-child(14)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element
    ...  css=.reference_cadastrale_custom_fields > .reference_cadastrale_custom_field  limit=12
    Execute Javascript  getDataFieldReferenceCadastrale();
    Textarea Value Should Be  css=#terrain_references_cadastrales
    ...  812BC8834A8856;878DE8898;


Vérification de la modification de la date de dossier
    [Documentation]  Il s'agit de tester le changement de date d'un dossier
    ...  il faut d'abord tester les erreur possible: le changemet d'année ou
    ...  le changement de date aprés l'ajout d'une instruction


    ${odl_date} =  Set Variable  25/12/1994
    ${new_date} =  Set Variable  27/11/2013
    ${newer_date} =  Set Variable  25/12/2013

    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=VEILLEUX
    ...  particulier_prenom=MARCELLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=${new_date}


    Depuis la page d'accueil  guichet  guichet
    ${di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}


    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  modifier
    Input Text  date_depot  ${odl_date}
    Click On Submit Button Until Message  L'année de la date de dépôt n'est pas modifiable
    Error Message Should Contain  L'année de la date de dépôt n'est pas modifiable

    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  modifier
    Input Text  date_depot  ${newer_date}
    Click On Submit Button
    Valid Message Should Be  Vos modifications ont bien été enregistrées.

    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Contain  date_depot  ${newer_date}
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Element Should Contain  css=tbody .col-2  ${newer_date}

    Ajouter une instruction au DI et la finaliser  ${di}  Sursis a statuer
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  modifier
    ${input_text} =  Get Text  date_depot
    Should Be Equal  ${EMPTY}  ${input_text}


Ajout d'une nouvelle demande utilisant le type de formulaire 'DPC'
    [Documentation]  Vérifie que l'ajout d'une nouvelle demande d'un type de
    ...  dossier utilisant l'affichage 'DPC' est correcte. Le dossier doit être
    ...  identique à un 'ADS' excepté pour les demandeurs qui sont le
    ...  pétitionnaire principales, les pétitionnaires secondaires, le
    ...  mandataire, le bailleur principale et les bailleurs secondaires.

    Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=CinqMars
    ...  particulier_prenom=Manon
    ${bailleur_nom} =  Set Variable  Clavette
    ${bailleur_prenom} =  Set Variable  Roland
    &{args_bailleur} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=${bailleur_nom}
    ...  particulier_prenom=${bailleur_prenom}
    &{args_autres_demandeurs} =  Create Dictionary
    ...  bailleur_principal=${args_bailleur}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Fonds de commerce
    ${di_fc} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}  ${args_autres_demandeurs}

    # On vérifie que sur le formulaire du dossier, les demandeurs soient
    # correctement affichés
    Depuis la page d'accueil  instr  instr
    # Utilisation du keyword utilisant la recherche pour vérifier la présence
    # du dossier d'instruction dans le listing
    Depuis le contexte du dossier d'instruction par recherche  ${di_fc}
    Open Fieldset  dossier_instruction  demandeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div#liste_demandeur  Bailleur principal
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div#liste_demandeur  ${bailleur_nom}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div#liste_demandeur  ${bailleur_prenom}


Saisie du numéro de dossier sur le formulaire d'ajout d'une nouvelle demande
    [Documentation]  Vérifie le bon fonctionnement de la saisie manuelle
    ...  du numéro de dossier et de division, lors d'une nouvelle demande.

    # Isolation du contexte pour vérifier le fonctionnement de la numérotation
    # manuelle
    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=FREECITY030SMND
    ...  departement=013
    ...  commune=077
    ...  insee=13077
    ...  direction_code=Z
    ...  direction_libelle=Direction de FREECITY030SMND
    ...  direction_chef=Chef
    ...  division_code=Z
    ...  division_libelle=Division Z
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Alice Langlais
    ...  guichet_om_utilisateur_email=alicelanglais@openads-test.fr
    ...  guichet_om_utilisateur_login=alanglais
    ...  guichet_om_utilisateur_pwd=alanglais
    ...  instr_om_utilisateur_nom=Eliot Levasseur
    ...  instr_om_utilisateur_email=eliotlevasseur@openads-test.fr
    ...  instr_om_utilisateur_login=elevasseur
    ...  instr_om_utilisateur_pwd=elevasseur
    Isolation d'un contexte  ${isolation_values}
    # Ajout des affectations automatiques en plus
    Ajouter la division depuis le menu  R  Division R  null  ${isolation_values.division_chef}  null  null  ${isolation_values.direction_libelle}
    Ajouter l'utilisateur depuis le menu  Étienne Gamelin  etiennegamelin@openads-test.fr  egamelin  egamelin  INSTRUCTEUR POLYVALENT COMMUNE  ${isolation_values.om_collectivite_libelle}
    Ajouter l'instructeur depuis le menu  Étienne Gamelin  Division R  instructeur  ${isolation_values.instr_om_utilisateur_nom}
    Ajouter la division depuis le menu  W  Division W  null  ${isolation_values.division_chef}  null  null  ${isolation_values.direction_libelle}
    Ajouter l'utilisateur depuis le menu  Renée Pinette  renéepinette@openads-test.fr  rpinette  rpinette  INSTRUCTEUR POLYVALENT COMMUNE  ${isolation_values.om_collectivite_libelle}
    Ajouter l'instructeur depuis le menu  Renée Pinette  Division W  instructeur  ${isolation_values.instr_om_utilisateur_nom}
    &{arrondissement_values} =  Create Dictionary
    ...  libelle=77
    ...  code_postal=13077
    ...  code_impots=277
    Ajouter l'arrondissement  ${arrondissement_values}
    &{quartier_values} =  Create Dictionary
    ...  arrondissement=77
    ...  code_impots=977
    ...  libelle=Quartier de ${isolation_values.om_collectivite_libelle}
    Ajouter le quartier  ${quartier_values}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Étienne Gamelin (R)
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Renée Pinette (W)
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  arrondissement=${arrondissement_values.libelle}
    ...  quartier=${quartier_values.libelle}
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # Ajout d'un dossier pour vérifier la séquence de la numérotation forcée
    # plus loin dans le test
    &{args_demande_auto} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_petitionnaire_auto} =  Create Dictionary
    ...  particulier_nom=Garnier
    ...  particulier_prenom=Arlette
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${di_auto} =  Ajouter la demande par WS  ${args_demande_auto}  ${args_petitionnaire_auto}

    # date du jour
    ${date_jour} =  Date du jour au format dd/mm/yyyy
    ${date_annee_yyyy} =  Get Time  year
    ${date_annee_yy} =  Get Substring  ${date_annee_yyyy}  -2

    # Active l'option de numérotation forcée
    &{param_values} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}
    # Désactive l'option de saisie de la date de demande à la date courante
    # Permet de vérifier le contenu du champ de l'année composant la
    # numérotation du dossier
    &{param_values} =  Create Dictionary
    ...  libelle=option_date_depot_demande_defaut
    ...  valeur=false
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # On crée une nouvelle demande avec le profil de guichet unique
    Depuis la page d'accueil  alanglais  alanglais
    # Informations à saisir
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TOLIN
    ...  particulier_prenom=PATRICK
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    # On vérifie que le nom du pétitionnaire saisi est bien affiché dans le
    # formulaire de la demande
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  TOLIN PATRICK

    # Présence du bloc "Numéro dossier" après celui de "Date de la demande", et des différents
    # éléments: type DA, code DEP, code COM, année, division, dossier, checkbox
    # Par défaut la checkbox est décochée et tous les champs sont cachés
    Element Should Be Visible  css=#formulaire div#form-content div.bloc_numero_dossier
    Element Should Be Visible  css=#num_doss_manuel
    Element Should Not Be Visible  css=#num_doss_type_da[readonly="readonly"]
    Element Should Not Be Visible  css=#num_doss_code_depcom[readonly="readonly"]
    Element Should Not Be Visible  css=#num_doss_annee[readonly="readonly"]
    Element Should Not Be Visible  css=#num_doss_division
    Element Should Not Be Visible  css=#num_doss_sequence
    Element Should Not Be Visible  css=#num_doss_manuel[value="Oui"]
    # Activation de la numérotation forcée et vérification des valeurs par
    # defaut
    Activer la saisie du numéro de dossier
    Element Should Be Visible  css=#num_doss_type_da[readonly="readonly"]
    Element Should Be Visible  css=#num_doss_code_depcom[readonly="readonly"]
    Element Should Be Visible  css=#num_doss_annee[readonly="readonly"]
    Element Should Be Visible  css=#num_doss_division
    Element Should Be Visible  css=#num_doss_sequence
    Element Should Be Visible  css=#num_doss_manuel[value="Oui"]
    Wait Until Form Value Should Be  css=#num_doss_type_da  PC
    Wait Until Form Value Should Be  css=#num_doss_code_depcom  ${isolation_values.departement}${isolation_values.commune}
    # L'année ne peut pas être récupérée tant que la date de la demande n'est
    # pas saisie
    Wait Until Form Value Should Be  css=#num_doss_annee  ${EMPTY}
    # La division est récupéré directement de l'instructeur affecté
    # automatiquement si l'option option_instructeur_division_numero_dossier est
    # activée
    Wait Until Form Value Should Be  css=#num_doss_division  0
    # Le numéro de dossier proposé est la valeur suivante de la séquence
    # qui ne peut pas être récupérée sans la date
    Wait Until Form Value Should Be  css=#num_doss_sequence  ${EMPTY}

    # Réactivation de l'option de la date de demande par défaut à la date
    # courante
    # Activation de l'option de récupération de la division dans la numérotation
    # Vérification du comportement de chaque champs à la modification des champs
    # du formulaire de demande
    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_date_depot_demande_defaut
    ...  click_value=${isolation_values.om_collectivite_libelle}
    Supprimer le paramètre (surcharge)  ${param_args}
    &{param_values} =  Create Dictionary
    ...  libelle=option_instructeur_division_numero_dossier
    ...  valeur=true
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TOLIN
    ...  particulier_prenom=PATRICK
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  TOLIN PATRICK
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_annee  ${date_annee_yy}
    Wait Until Form Value Should Be  css=#num_doss_type_da  DP
    Wait Until Form Value Should Be  css=#num_doss_code_depcom  ${isolation_values.departement}${isolation_values.commune}
    Wait Until Form Value Should Be  css=#num_doss_division  R
    Wait Until Form Value Should Be  css=#num_doss_sequence  1
    Désactiver la saisie du numéro de dossier
    # Saisie de la référence cadastrales pour modifier la division
    Input text  css=div.reference_cadastrale_custom_fields input.champFormulaire:nth-child(1)  977
    Input text  css=div.reference_cadastrale_custom_fields input.champFormulaire:nth-child(2)  A
    Input text  css=div.reference_cadastrale_custom_fields input.champFormulaire:nth-child(3)  0001
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_division  W
    Wait Until Form Value Should Be  css=#num_doss_sequence  1
    # Vérification des événements JS (la division et la séquence ne doivent pas
    # être recalculées)
    # au changement du type détaillé de DA : type DA
    Select From List By Label  css=#dossier_autorisation_type_detaille  Permis de construire comprenant ou non des démolitions
    Sleep  2  # obligation d'attendre car lors d'un changement de type de dossier il y a une temporisation JS d'une seconde
    Wait Until Element Is Visible  css=#demande_type
    Select From List By Label  css=#demande_type  Dépôt Initial
    Wait Until Form Value Should Be  css=#num_doss_type_da  PC
    Select From List By Label  css=#dossier_autorisation_type_detaille  Permis de démolir
    Sleep  2  # obligation d'attendre car lors d'un changement de type de dossier il y a une temporisation JS d'une seconde
    Wait Until Form Value Should Be  css=#num_doss_type_da  PD
    # au changement de la date de demande : année
    Wait Until Element Is Visible  css=input#date_demande
    Input text  css=#date_demande  01/01/2018
    Simulate Event  css=#date_demande  change
    Wait Until Form Value Should Be  css=#num_doss_annee  18
    Input text  css=#date_demande  ${EMPTY}
    Simulate Event  css=#date_demande  change
    Wait Until Form Value Should Be  css=#num_doss_annee  ${EMPTY}
    # au changement de la collectivité : code depcom
    Select From List By Label  css=#om_collectivite  choisir Collectivité
    Wait Until Form Value Should Be  css=#num_doss_code_depcom  ${EMPTY}

    # Vide les valeurs pour vérifier les messages d'erreur
    Input text  css=#num_doss_sequence  ${EMPTY}
    Input text  css=#num_doss_division  0
    Click On Submit Button Until Message  Numéro de dossier : le numéro est obligatoire.
    Wait Until Form Value Should Be  css=#num_doss_sequence  ${EMPTY}
    Input text  css=#num_doss_sequence  99
    Input text  css=#num_doss_division  ${EMPTY}
    Click On Submit Button Until Message  Numéro de dossier : le caractère réservé au service instructeur (division) est obligatoire.
    # Vérifie que les valeurs postées ne sont pas recalculées au chargement de
    # la page
    Wait Until Form Value Should Be  css=#num_doss_division  ${EMPTY}
    Wait Until Form Value Should Be  css=#num_doss_sequence  99

    # Vérification des événements JS (avec activation/désactivation de la
    # numérotation forcée)
    # au changement du type détaillé de DA : type DA, division, séquence
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  TOLIN PATRICK
    Select From List By Label  css=#dossier_autorisation_type_detaille  Permis de construire comprenant ou non des démolitions
    Sleep  2  # obligation d'attendre car lors d'un changement de type de dossier il y a une temporisation JS d'une seconde
    Wait Until Element Is Visible  css=#demande_type
    Select From List By Label  css=#demande_type  Dépôt Initial
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_type_da  PC
    # Même numérotation mais pas même division car l'affectation auto ne concerne
    # que les PCI et non les PCA
    Wait Until Form Value Should Be  css=#num_doss_division  0
    Wait Until Form Value Should Be  css=#num_doss_sequence  2
    Désactiver la saisie du numéro de dossier
    Select From List By Label  css=#dossier_autorisation_type_detaille  Permis de construire pour une maison individuelle et / ou ses annexes
    Sleep  2  # obligation d'attendre car lors d'un changement de type de dossier il y a une temporisation JS d'une seconde
    Wait Until Element Is Visible  css=input#date_demande
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_type_da  PC
    Wait Until Form Value Should Be  css=#num_doss_division  ${isolation_values.division_code}
    Wait Until Form Value Should Be  css=#num_doss_sequence  2
    # au changement de la date de demande : année, séquence (ne change pas la
    # valeur s'il manque des données pour la calculer)
    Input text  css=#date_demande  01/01/2018
    Simulate Event  css=#date_demande  change
    Wait Until Form Value Should Be  css=#num_doss_annee  18
    Désactiver la saisie du numéro de dossier
    Sleep  1
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_sequence  1
    Input text  css=#date_demande  ${EMPTY}
    Simulate Event  css=#date_demande  change
    Wait Until Form Value Should Be  css=#num_doss_annee  ${EMPTY}
    Désactiver la saisie du numéro de dossier
    Sleep  1
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_annee  ${EMPTY}
    # au changement de la collectivité : code depcom (ne
    # change pas la valeur s'il manque des données pour la calculer)
    Désactiver la saisie du numéro de dossier
    Select From List By Label  css=#om_collectivite  choisir Collectivité
    Wait Until Element Is Visible  css=input#date_demande
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_code_depcom  ${EMPTY}
    Wait Until Form Value Should Be  css=#num_doss_division  ${EMPTY}
    Wait Until Form Value Should Be  css=#num_doss_sequence  ${EMPTY}

    # On saisi des valeurs valides pour ajouter le dossier
    Input text  css=#date_demande  ${date_jour}
    Select From List By Label  css=#dossier_autorisation_type_detaille  Permis de construire pour une maison individuelle et / ou ses annexes
    Sleep  2  # obligation d'attendre car lors d'un changement de type de dossier il y a une temporisation JS d'une seconde
    Select From List By Label  css=#om_collectivite  ${isolation_values.om_collectivite_libelle}
    Wait Until Element Is Visible  css=input#date_demande
    Wait Until Element Is Visible  css=#num_doss_division
    Input text    css=#num_doss_division  ${isolation_values.division_code}
    Wait Until Element Is Visible  css=#num_doss_sequence
    Sleep  5
    Input text  css=#num_doss_sequence  9999
    Click On Submit Button Until Message  Création du dossier d'instruction n
    La page ne doit pas contenir d'erreur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain
    ...  Vos modifications ont bien été enregistrées.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain
    ...  Attention vous avez atteint le dernier numéro de dossier possible pour ce type de dossier d'autorisation de cette collectivité pour l'année sélectionnée.
    # Vérifie le numero de dossier de la demande
    Element Should Contain  css=#new_da  PC ${isolation_values.departement}${isolation_values.commune} ${date_annee_yy} ${isolation_values.division_code}9999

    # Ajoute une demande automatique et vérifire le message d'erreur car la
    # numérotation maximale est dépassée
    Depuis la page d'accueil  alanglais  alanglais
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Aupry
    ...  particulier_prenom=Clothilde
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  Aupry Clothilde
    # La séquence de la numérotation forcée ne doit pas être renseigné
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_sequence  ${EMPTY}
    Désactiver la saisie du numéro de dossier
    Click On Submit Button Until Message  Vous ne pouvez pas saisir un dossier dont la numérotation dépasse 9999.
    # Vérification du changement de la séquence après un ajout d'un dossier par
    # numérotation forcée
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    &{args_demande_auto} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bonneville
    ...  particulier_prenom=Zacharie
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  Bonneville Zacharie
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_division  R
    Wait Until Form Value Should Be  css=#num_doss_sequence  1
    Input text  css=#num_doss_division  S
    Input text  css=#num_doss_sequence  777
    Click On Submit Button Until Message  Création du dossier d'instruction n
    La page ne doit pas contenir d'erreur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain
    ...  Vos modifications ont bien été enregistrées.
    Element Should Contain  css=#new_da  DP ${isolation_values.departement}${isolation_values.commune} ${date_annee_yy} S0777
    # Ajout du dossier avec numérotation auto
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Vaillancour
    ...  particulier_prenom=Yves
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${di_auto} =  Ajouter la demande par WS  ${args_demande_auto}  ${args_petitionnaire}
    Should Be Equal  ${di_auto}  DP ${isolation_values.departement}${isolation_values.commune} ${date_annee_yy} R0778P0

    # Vérification que l'ajout auto reste à la valeur la plus haute de la
    # séquence
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bonneville
    ...  particulier_prenom=Zacharie
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  Bonneville Zacharie
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_division  R
    Wait Until Form Value Should Be  css=#num_doss_sequence  779
    Input text  css=#num_doss_division  S
    Input text  css=#num_doss_sequence  555
    Click On Submit Button Until Message  Création du dossier d'instruction n
    La page ne doit pas contenir d'erreur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain
    ...  Vos modifications ont bien été enregistrées.
    Element Should Contain  css=#new_da  DP ${isolation_values.departement}${isolation_values.commune} ${date_annee_yy} S0555
    # Ajout du dossier avec numérotation auto
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Vaillancour
    ...  particulier_prenom=Yves
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${di_auto} =  Ajouter la demande par WS  ${args_demande_auto}  ${args_petitionnaire}
    Should Be Equal  ${di_auto}  DP ${isolation_values.departement}${isolation_values.commune} ${date_annee_yy} R0779P0

    # Active l'option de suppression des dossiers dont le comportement de la
    # fonctionnalité est modifié par la saisie de la numérotation.
    # Il n'y a plus la condition sur le dernier numéro de dossier d'autorisation
    # Ajout de deux DI, un ayant le numéro 888 et l'autre ayant le numéro 999,
    # les deux non instruits.
    # La suppression est possible sur les deux dossiers, en cas de suppression
    # du 999 alors le prohcian numéro automatique est le 889 (888+1).
    # Ajout d'un nouveau DI 7777 et suppression du 888, le prochain automatique
    # devrait rester le 7778.
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    Depuis la page d'accueil  alanglais  alanglais
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lacharité
    ...  particulier_prenom=Juliette
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  Lacharité Juliette
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_annee  ${date_annee_yy}
    Input text until text is correct  css=#num_doss_sequence  888
    Input text until text is correct  css=#num_doss_division  Z
    Click On Submit Button Until Message  Création du dossier d'instruction n
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pomeroy
    ...  particulier_prenom=Mathieu
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  Pomeroy Mathieu
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_annee  ${date_annee_yy}
    Input text until text is correct  css=#num_doss_sequence  999
    Input text until text is correct  css=#num_doss_division  Z
    Click On Submit Button Until Message  Création du dossier d'instruction n

    ${current_year} =  Get Current Date    result_format=%y

    Depuis la page d'accueil  egamelin  egamelin
    Depuis le contexte du dossier d'instruction  DP 013077 ${current_year} Z0888P0
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Depuis le contexte du dossier d'instruction  DP 013077 ${current_year} Z0999P0
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Supprimer le dossier d'instruction  DP 013077 ${current_year} Z0999P0
    Depuis la page d'accueil  alanglais  alanglais
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Chrétien
    ...  particulier_prenom=Arnaud
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  Chrétien Arnaud
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_annee  ${date_annee_yy}
    Wait Until Form Value Should Be  css=#num_doss_sequence  889
    Input text  css=#num_doss_sequence  7777
    Input text  css=#num_doss_division  Z
    Click On Submit Button Until Message  Création du dossier d'instruction n
    Depuis la page d'accueil  egamelin  egamelin
    Supprimer le dossier d'instruction  DP 013077 ${current_year} Z0888P0
    Depuis la page d'accueil  alanglais  alanglais
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  Chrétien Arnaud
    Activer la saisie du numéro de dossier
    Wait Until Form Value Should Be  css=#num_doss_annee  ${date_annee_yy}
    Wait Until Form Value Should Be  css=#num_doss_sequence  7778
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Désactivation de l'option de numérotation forcée et de la récupération de
    # la division dans la numérotation du dossier
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_saisie_numero
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_instructeur_division_numero_dossier
    ...  click_value=${isolation_values.om_collectivite_libelle}
    Supprimer le paramètre (surcharge)  ${param_args}


Gestion de la commune associée au dossier
    [Documentation]  Vérifie le bon fonctionnement de la gestion du
    ...  champ 'commune' associé au dossier.

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # isole le contexte du test (création d'une collectivité)
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM
    ...  departement=013
    ...  commune=095
    ...  insee=13095
    ...  direction_code=X
    ...  direction_libelle=Direction de LIBRECOM
    ...  direction_chef=Chef
    ...  division_code=X
    ...  division_libelle=Division X
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Alain Posteur
    ...  guichet_om_utilisateur_email=aposteur@openads-test.fr
    ...  guichet_om_utilisateur_login=aposteur
    ...  guichet_om_utilisateur_pwd=aposteur
    ...  instr_om_utilisateur_nom=Abdel Ledba
    ...  instr_om_utilisateur_email=aledba@openads-test.fr
    ...  instr_om_utilisateur_login=aledba
    ...  instr_om_utilisateur_pwd=aledba
    Isolation d'un contexte  ${isolation_values}
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=LOINCOM
    ...  departement=796
    ...  commune=095
    ...  insee=79695
    ...  direction_code=Y
    ...  direction_libelle=Direction de LOINCOM
    ...  direction_chef=Chef
    ...  division_code=Y
    ...  division_libelle=Division Y
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Olice Ecilo
    ...  guichet_om_utilisateur_email=olicelecilo@openads-test.fr
    ...  guichet_om_utilisateur_login=oecilo
    ...  guichet_om_utilisateur_pwd=oecilo
    ...  instr_om_utilisateur_nom=Oliot Toilo
    ...  instr_om_utilisateur_email=oliottoilo@openads-test.fr
    ...  instr_om_utilisateur_login=otoilo
    ...  instr_om_utilisateur_pwd=otoilo
    Isolation d'un contexte  ${isolation_values}


    #-- importer des communes via l'import spécifique
    Depuis l'import spécifique   commune
    ${import_communes_file} =  Set Variable  import_specific_communes_libre.csv
    Add File  fic1  ${import_communes_file}
    Click On Submit Button In Import CSV
    Résultat de l'import doit contenir  41 ligne(s) dans le fichier dont :
    Résultat de l'import doit contenir  - 1 ligne(s) d'entête
    Résultat de l'import doit contenir  - 39 ligne(s) insérée(s)
    Résultat de l'import doit contenir  - 0 ligne(s) rejetée(s)
    Résultat de l'import doit contenir  - 1 ligne(s) vide(s)

    # TODO tester les points suivants :
    #  - une commune importée qui existe déjà avec les mêmes paramètres et qui est toujours valide
    #    ne doit pas être ajoutée
    #  - une commune importée qui existe déjà avec les mêmes paramètres mais plus valide doit
    #    être ajoutée et l'existante archivée
    #  - import des régions
    #  - import des départements

    #-- ajouter manuellement une commune en saisissant une date de validité dans le passé
    &{expiredcom_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=45645
    ...  reg=45
    ...  dep=45
    ...  arr=645
    ...  tncc=0
    ...  ncc=EXPIREDCOM
    ...  nccenr=Expiredcom
    ...  libelle=Expiredcom
    ...  can=45
    ...  comparent=
    ...  om_validite_debut=01/01/2020
    ...  om_validite_fin=01/02/2020
    Ajouter commune avec dates validité  ${expiredcom_values}
    # ajouter manuellement une commune en saisissant une date de validité dans le futur
    ${yyyy} =  Get Time  year
    ${mm} =  Get Time  month
    ${dd} =  Get Time  day
    ${date_courante} =  Catenate  SEPARATOR=/  ${dd}  ${mm}  ${yyyy}
    ${yyyy_futur} =  Evaluate  ${yyyy}+1
    ${yyyy_past} =  Evaluate  ${yyyy}-1
    &{futurcom_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=46646
    ...  reg=46
    ...  dep=46
    ...  arr=646
    ...  tncc=0
    ...  ncc=FUTURCOM
    ...  nccenr=Futurcom
    ...  libelle=Futurcom
    ...  can=46
    ...  comparent=
    ...  om_validite_debut=01/01/${yyyy_futur}
    Ajouter commune avec dates validité  ${futurcom_values}

    # En tant que guichet unique de LIBRECOM
    Depuis la page d'accueil  aposteur  aposteur

    # à l'ajout d'un dossier
    # vérifier que le le champ 'commune' n'apparait pas (option désactivée)
    Depuis le contexte de nouvelle demande via l'URL
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Not Contain  css=#commune
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Not Contain  css=#autocomplete-commune-id

    # TODO vérifier que le champ 'commune' n'apparait pas dans les nouvelles demandes de contentieux

    # activer l'option dossier_commune
    Depuis la page d'accueil  admin  admin
    # pour l'utilisateur admin
    Ajouter le paramètre depuis le menu  option_dossier_commune  true  agglo
    # pour les autres utilisateurs
    Ajouter le paramètre depuis le menu  option_dossier_commune  true  LIBRECOM
    Ajouter le paramètre depuis le menu  option_dossier_commune  true  LOINCOM
    # limiter les communes associables à LIBRECOM
    Ajouter le paramètre depuis le menu  param_communes  13095,45645,13909,13904,13901  LIBRECOM

    # En tant que guichet unique de LIBRECOM
    Depuis la page d'accueil  aposteur  aposteur

    # à l'ajout d'un dossier
    # vérifier que les communes non valides ne soient pas sélectionnables
    Depuis le contexte de nouvelle demande via l'URL
    Wait Until Element Is Visible  css=#autocomplete-commune-search
    Input Text  css=#autocomplete-commune-search  Expiredcom
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=ul.ui-autocomplete li.ui-menu-item a  Aucun résultat
    Input Text  css=#autocomplete-commune-search  Futurcom
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=ul.ui-autocomplete li.ui-menu-item a  Aucun résultat
    Input Text  css=#autocomplete-commune-search  LibreCom 5e Arrondissement
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=ul.ui-autocomplete li.ui-menu-item a  Aucun résultat
    Input Text  css=#autocomplete-commune-search  ${EMPTY}

    # vérifier que les communes valides (à la date courante) le sont
    Input Text  css=#autocomplete-commune-search  13904
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=ul.ui-autocomplete li.ui-menu-item a  13904 - LibreCom 4e Arrondissement

    # mais que les communes anciennes soient sélectionnables si la date de demande correspond
    Select From List By Label  dossier_autorisation_type_detaille  Déclaration préalable
    Wait Until Element Is Visible  css=input#date_demande
    Input Text  css=input#date_demande  02/01/2020
    Simulate Event  css=input#date_demande  change
    Input Text  css=#autocomplete-commune-search  ${EMPTY}
    ${autocomplete_val} =  Get Value  css=#autocomplete-commune-search
    Should Be Equal  ${autocomplete_val}  ${EMPTY}
    Input Text  css=#autocomplete-commune-search  Expiredcom
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=ul.ui-autocomplete li.ui-menu-item a  45645 - Expiredcom

    # Vérification de la remise à zéro du champ 'commune'
    # Dans le cas où le changement de 'date demande' n'affecte pas la présence de la commune
    # sélectionnée dans la liste des communes disponibles, le champ 'commune' n'est pas
    # remis à zéro
    Depuis le contexte de nouvelle demande via l'URL
    Wait Until Element Is Visible  css=#autocomplete-commune-search
    Input Text  css=#autocomplete-commune-search  13904 - LibreCom 4e Arrondissement
    Wait Until Element Is Visible  css=ul.ui-autocomplete
    Click Element Until No More Element  css=ul.ui-autocomplete li.ui-menu-item a
    Wait Until Form Value Should Be  css=#autocomplete-commune-search  13904 - LibreCom 4e Arrondissement
    Select From List By Label  dossier_autorisation_type_detaille  Déclaration préalable
    Wait Until Element Is Visible  css=input#date_demande
    Input Text  css=input#date_demande  01/01/${yyyy_futur}
    Simulate Event  css=input#date_demande  change
    Wait Until Form Value Should Be  css=#autocomplete-commune-search  13904 - LibreCom 4e Arrondissement
    # Dans le cas où le changement de 'date demande' affecte la présence de la commune
    # sélectionnée dans la liste des communes disponibles, le champ 'commune' est
    # remis à zéro et un message est affiché à l'utilisateur
    Input Text  css=input#date_demande  01/01/${yyyy_past}
    Simulate Event  css=input#date_demande  change
    ${alert} =  Handle Alert
    Should Be Equal As Strings  ${alert}  Les données saisies ne permettent pas de rattacher la demande à la commune sélectionnée.
    Wait Until Form Value Should Be  css=#autocomplete-commune-search  ${EMPTY}

    # ajouter un dossier sans saisir de commune
    # vérifier l'échec
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lacharité
    ...  particulier_prenom=Juliette
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div.ui-state-error p span.text  La commune doit être définie.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div.ui-state-error p span.text  SAISIE NON ENREGISTRÉE
    La page ne doit pas contenir d'erreur

    # TODO ajouter un dossier avec une commune invalide et vérifier le message d'erreur

    # ajouter un premier dossier en saisissant une commune
    # vérifier le succès et l'association de la commune avec le DI et le DA
    Depuis la page d'accueil  aposteur  aposteur
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  commune=Librecom
    ${demande2_di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}
    Depuis le contexte du dossier d'instruction  ${demande2_di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#commune  LibreCom
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#dossier_libelle  013095
    ${demande2_da} =  Get Substring  ${demande2_di}  0  -2
    Depuis le contexte du dossier d'autorisation  ${demande2_da}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#commune  LibreCom

    # activer la numérotation manuelle des dossiers (pour l'admin/agglo)
    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  option_dossier_saisie_numero  true  agglo

    # à l'ajout d'un dossier
    Depuis le contexte de nouvelle demande via l'URL

    # après avoir sélectionné la collectivité, le DAtd, et activer la saisie manuelle du numéro
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LOINCOM
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lacharité
    ...  particulier_prenom=Juliette
    ...  om_collectivite=LOINCOM
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    Activer la saisie du numéro de dossier

    # vérifier que par défaut le code depcom est vide
    Wait Until Form Value Should Be  css=#num_doss_code_depcom  ${EMPTY}

    # vérifier que le changement de commune se répercute sur le numéro de dossier (code depcom)
    Wait Until Element Is Visible  css=#autocomplete-commune-search
    Input Text  css=#autocomplete-commune-search  LibreCom
    Wait Until Element Is Visible  css=ul.ui-autocomplete
    Click Element Until No More Element  css=ul.ui-autocomplete li.ui-menu-item a
    Wait Until Form Value Should Be  css=#num_doss_code_depcom  013095
    Input Text  css=#autocomplete-commune-search  LoinCom
    Wait Until Element Is Visible  css=ul.ui-autocomplete
    Click Element Until No More Element  css=ul.ui-autocomplete li.ui-menu-item a
    Wait Until Form Value Should Be  css=#num_doss_code_depcom  976095

    # ajouter le dossier avec les éléments par défaut (hormis division et séquence, à saisir)
    # vérifier le succès et le numéro de dossier obtenu (devant correspondre)
    Input text  css=#num_doss_division  Y
    Input text  css=#num_doss_sequence  1
    Click On Submit Button Until Message  Création du dossier d'instruction n
    ${demande3_di} =  Get Text  new_di

    # dans le listing des DI, faire une recherche sur le champ commune avec les deux codes communes
    # vérifier la présence des 2 dossiers dans les résultats
    Depuis le listing  dossier_instruction
    Input Text  commune  976,LibreCom
    Click On Search Button
    Element Should Be Visible  xpath=//div[@id = "tab-dossier_instruction"]/descendant::a[normalize-space(text()) = "${demande2_di}"]/ancestor::tr/td/a[normalize-space(text()) = "LibreCom"]
    Element Should Be Visible  xpath=//div[@id = "tab-dossier_instruction"]/descendant::a[normalize-space(text()) = "${demande3_di}"]/ancestor::tr/td/a[normalize-space(text()) = "LoinCom"]

    # TODO : vérifier les mêmes élements dans le listing des DA

    # ajouter les instructeurs pour pouvoir faire des affectations automatiques
    Ajouter la division depuis le menu  X1  Division X1  null  Chef  null  null  Direction de LIBRECOM
    Ajouter l'utilisateur depuis le menu  Atienne Gamelin  atiennegamelin@openads-test.fr  agamelin  agamelin  INSTRUCTEUR POLYVALENT COMMUNE  LIBRECOM
    Ajouter l'instructeur depuis le menu  Atienne Gamelin  Division X1  instructeur  Abdel Ledba
    Ajouter la division depuis le menu  Y1  Division Y1  null  Chef  null  null  Direction de LOINCOM
    Ajouter l'utilisateur depuis le menu  Nenée Pinette  nenéepinette@openads-test.fr  npinette  npinette  INSTRUCTEUR POLYVALENT COMMUNE  LOINCOM
    Ajouter l'instructeur depuis le menu  Nenée Pinette  Division Y1  instructeur  Oliot Toilo

    # ajouter une affectation automatique contenant le code INSEE d'une commune et un instructeur
    # qui n'est pas celui par défaut pour le type de DI/DA sélectionné
    Depuis la page d'accueil  admin  admin
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Atienne Gamelin (X1)
    ...  om_collectivite=LIBRECOM
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  communes=13095
    ...  affectation_manuelle=Atienne Gamelin (X1) pour LibreCom
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # ajouter un dossier correspondant au code commune et au type de DI/DA spécifiés précédemment
    # vérifier le succès et que c'est bien l'instructeur défini dans l'affectation automatique qui
    # est associé au dossier
    Depuis la page d'accueil  aposteur  aposteur
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  commune=13095 - LibreCom
    ...  affectation_automatique=Atienne Gamelin (X1) pour LibreCom
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lacharité
    ...  particulier_prenom=Juliette
    ${demande4_di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}
    ${demande4_instr} =  Obtenir l'instructeur du dossier d'instruction  ${demande4_di}
    Should Be True  "${demande4_instr}" == "Atienne Gamelin (X1)"

    # ajouter une affectation automatique contenant le code département d'une commune et un instructeur
    # qui n'est pas celui par défaut pour le type de DI/DA sélectionné
    Depuis la page d'accueil  admin  admin
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Nenée Pinette (Y1)
    ...  om_collectivite=LOINCOM
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  communes=976
    Ajouter l'affectation depuis le menu  ${args_affectation}

    Depuis la page d'accueil  oecilo  oecilo
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  commune=97695 - LoinCom
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lacharité
    ...  particulier_prenom=Juliette
    ${demande5_di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}
    ${demande5_instr} =  Obtenir l'instructeur du dossier d'instruction  ${demande5_di}
    Should Be True  "${demande5_instr}" == "Nenée Pinette (Y1)"

    # TODO : vérifier qu'avec une date demande dans le passé et une commune plus valide au jour
    #        courant, mais valide à la date de la demande, l'affectation automatique lié à cette
    #        commune apparait bien, et que l'ajout du dossier avec tous ces paramètres se passe bien

    # TODO : vérifier que lorsque l'option dossier_commune est désactivée le champ 'commune'
    #        n'apparait ni dans les dossiers, ni dans les recherches

    # désactiver l'option dossier_commune
    Depuis la page d'accueil  admin  admin
    # pour l'utilisateur admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_commune
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
    # pour les autres utilisateurs
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_commune
    ...  click_value=LIBRECOM
    Supprimer le paramètre (surcharge)  ${param_args}
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_commune
    ...  click_value=LOINCOM
    Supprimer le paramètre (surcharge)  ${param_args}

    # désactiver la numérotation manuelle des dossiers (pour l'admin/agglo)
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_saisie_numero
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}


Vérification du bon fonctionnement de la date de dépôt en mairie
    Depuis la page d'accueil  admin  admin

    # On active l'option option_date_depot_mairie
    &{param_values} =  Create Dictionary
    ...  libelle=option_date_depot_mairie
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # Ajout d'un dossier avec la date de dépôt en mairie à la date du jour
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_depot_mairie=${date_ddmmyyyy}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST030NOM
    ...  particulier_prenom=TEST030PRENOM
    ...  om_collectivite=MARSEILLE
    ${di_date_depot_mairie} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On vérifie que la date de dépot en mairie est modifiable à la main dans le dossier d'instruction
    Depuis le contexte du dossier d'instruction  ${di_date_depot_mairie}
    Wait Until Form Value Should Be  css=#date_depot_mairie  ${date_ddmmyyyy}

    # On vérifie que l'année ne peut pas être modifiée
    Click On Form Portlet Action  dossier_instruction  modifier
    Input Datepicker  date_depot_mairie  16/02/2015
    Click On Submit Button

    Error Message Should Contain  L'année de la date de dépôt en mairie n'est pas modifiable.
    Error Message Should Contain  SAISIE NON ENREGISTRÉE
    Click On Back Button

    ${date_annee_yyyy} =  Get Time  year
    ${date_depot_mairie} =  Create Dictionary
    ...  date_depot_mairie=16/02/${date_annee_yyyy}

    Modifier le dossier d'instruction  ${di_date_depot_mairie}  ${date_depot_mairie}

    Depuis le contexte du dossier d'instruction  ${di_date_depot_mairie}
    Wait Until Form Value Should Be  css=#date_depot_mairie  ${date_depot_mairie.date_depot_mairie}

    ${date_depot_mairie} =  Create Dictionary
    ...  date_depot_mairie=${date_ddmmyyyy}

    Modifier le dossier d'instruction  ${di_date_depot_mairie}  ${date_depot_mairie}

    ${date_depot_mairie_for_calc} =  Get Value  date_depot_mairie

    # On ajoute une instruction qui majore le délai d'instruction
    &{args_action} =  Create Dictionary
    ...  action=majore_delai_instruction
    ...  libelle=Majorer le délai d'instruction
    ...  regle_delai=archive_delai+delai
    ...  regle_accord_tacite=accord_tacite
    ...  regle_date_limite=date_depot_mairie+delai+archive_delai
    Ajouter l'action depuis le menu  ${args_action}
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=Majorer le délai d'instruction
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  delai=3 Mois
    ...  action=Majorer le délai d'instruction
    Ajouter l'événement depuis le menu  ${args_evenement}

    Ajouter une instruction au DI  ${di_date_depot_mairie}  Majorer le délai d'instruction

    # La date limite doit être à 5 mois de plus de celle calculé par défaut
    # calcul du jour identique 5 mois après (+5 mois)
    ${date_depot_mairie_for_calc_calculated} =  Ajouter ou supprimer des mois à une date  5  ${date_depot_mairie_for_calc}

    Depuis le contexte du dossier d'instruction  ${di_date_depot_mairie}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  date_limite  ${date_depot_mairie_for_calc_calculated}


    # On ajoute une instruction qui modifie le délai d'instruction
    &{args_action} =  Create Dictionary
    ...  action=modif_delai_instruction
    ...  libelle=Modifier le délai d'instruction
    ...  regle_delai=delai
    ...  regle_accord_tacite=accord_tacite
    ...  regle_date_limite=date_depot_mairie+delai
    Ajouter l'action depuis le menu  ${args_action}
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=Modifier le délai d'instruction
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  delai=1 Mois
    ...  action=Modifier le délai d'instruction
    Ajouter l'événement depuis le menu  ${args_evenement}

    Ajouter une instruction au DI  ${di_date_depot_mairie}  Modifier le délai d'instruction

    # La date limite doit être à 1 mois de moins de celle calculé par défaut
    # On utilise la date de dépôt en mairie afin de calculer la nouvelle date limite d'instruction
    ${date_depot_mairie_for_calc_calculated} =  Ajouter ou supprimer des mois à une date  1  ${date_depot_mairie_for_calc}

    Depuis le contexte du dossier d'instruction  ${di_date_depot_mairie}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  date_limite  ${date_depot_mairie_for_calc_calculated}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_date_depot_mairie
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

Vérification de la prise en compte de l'année de la date de dépôt en mairie lors de la numérotation manuelle

    Depuis la page d'accueil  admin  admin

    # Active l'option de numérotation forcée
    &{param_values} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # On active l'option option_date_depot_mairie
    &{param_values} =  Create Dictionary
    ...  libelle=option_date_depot_mairie
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # On vérifie que lorsque les deux options sont activées elles fonctionnent correctement entre elles
    Go To Submenu In Menu  guichet_unique  nouveau-dossier

    Select From List By Label  om_collectivite  MARSEILLE
    Select From List By Label  dossier_autorisation_type_detaille  DECLARATION PREALABLE SIMPLE

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  date_depot_mairie
    Activer la saisie du numéro de dossier

    ${date_annee_yyyy} =  Get Time  year
    ${date_annee_yy} =  Get Substring  ${date_annee_yyyy}  -2
    Wait Until Form Value Should Be  css=#num_doss_annee  ${date_annee_yy}

    Input Datepicker  date_depot_mairie  16/02/2015
    Input Datepicker  date_demande  ${date_ddmmyyyy}

    Wait Until Form Value Should Be  css=#num_doss_annee  15

    &{args_petitionnaire} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=DURAND
    Ajouter le demandeur  petitionnaire_principal  ${args_petitionnaire}

    Input Text  num_doss_division  A
    Click On Submit Button
    Valid Message Should Contain  DP 013055 15 A0001

    Click Element  link_demande_dossier_instruction
    Element Should Contain  dossier_libelle  DP 013055 15 A0001P0

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_date_depot_mairie
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_saisie_numero
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

TNR Vérification du numéro de siret

     # On se connecte à l'application
    Depuis la page d'accueil  admin  admin

    Go To Submenu In Menu  guichet_unique  nouveau-dossier

    # Informations à saisir
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire&Co
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Martin
    ...  personne_morale_prenom=Nicolas
    ...  personne_morale_siret=12345678912345
    ...  om_collectivite=MARSEILLE
    # On remplit les champs de la demande
    Saisir la demande  ${args_demande}
    # On ajoute le pétitionnaire
    Click Element Until New Element  add_petitionnaire_principal  css=.ui-widget-overlay

    # Contrôle du numéro siret
    Select From List By Label  css=#qualite  personne morale
    # On saisi un numéro siret qui n'a pas 14 caractères
    Input Text  css=#personne_morale_siret  123456789

    Click Element  css=#sousform-petitionnaire input[value=Ajouter]

    # Vérification du message d'erreur
    Error Message Should Contain  Le champ siret doit contenir 14 caractères.

    # On ferme l'overlay
    Click Element Until No More Element  css=#sousform-petitionnaire a.retour

    Ajouter le demandeur  petitionnaire_principal  ${args_petitionnaire}

    Click On Submit Button


TNR la date de dépôt ne doit pas être supérieur à la date du jour
    [Documentation]  Ce test vérifie que si dans le formualire de nouvelle demande
    ...  l'utilisateur à saisi une date de demande dans le futur un message d'erreur
    ...  s'affiche et ses modifications ne sont pas enregistrées

    Depuis la page d'accueil  guichet  guichet

    ${demain} =  Add Time To Date  ${date_ddmmyyyy}  1 days  %d/%m/%Y  True  %d/%m/%Y
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=${demain}
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire&Co
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Martin
    ...  personne_morale_prenom=Nicolas
    ...  personne_morale_siret=12345678912345
    # On remplit les champs de la demande
    Go To Submenu In Menu  guichet_unique  nouveau-dossier
    Saisir la demande  ${args_demande}
    Ajouter le demandeur  petitionnaire_principal  ${args_petitionnaire}
    Click On Submit Button
    Error Message Should Contain  La date de demande ne peut pas être superieure à la date du jour.

TNR vérification utilisation de département Corse (2A)
    [Documentation]  Permet la vérification de l'utilisation du département Corse (2A) et de son bon fonctionnement

    Depuis la page d'accueil  admin  admin

    # Activation du paramètre option dossier commune
    &{param_division} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # Activation de l'option dossier saisie numero
    &{param_values} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Ajouter commune Corse 2A
    &{corse_commune} =  Create Dictionary
    ...  typecom=COM
    ...  com=2A390
    ...  reg=12
    ...  dep=2A
    ...  arr=645
    ...  libelle=Corse
    Ajouter commune avec dates validité  ${corse_commune}

    # Ajouter une demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  commune=Corse
    ...  terrain_adresse_code_postal=2A390
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Dada
    ...  particulier_prenom=Amine
    ...  om_collectivite=MARSEILLE
    ${new_dossier} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}
    
    Depuis le listing  dossier_instruction

    Input Text  css=div#adv-search-adv-fields input#dossier  ${new_dossier}
    Click On Search Button

    # Vérification que le dossier à bien été enregistrer et que les numero de dossier et la localisation
    # correspondent bien aux données saisis précédemment
    Element Should Contain  css=#tab-dossier_instruction table.tab-tab tbody td.col-3  ${new_dossier}
    Click Element  css=#tab-dossier_instruction table.tab-tab tbody td.col-3

    ${get_num_dossier} =  Get Text  dossier_libelle

    Should Be Equal  ${new_dossier}  ${get_num_dossier}
    Wait Until Element Contains  css=.localisation-terrain-adresse  ${args_demande.terrain_adresse_code_postal}     

    # Désactivation du paramètre option dossier commune
    &{param_division} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # Désactivation de l'option dossier saisie numero
    &{param_values} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}


Les dossiers liés géograhiquement sont filtrés par commune
    [Documentation]  Ce test case a pour but de vérifier que les dossiers liés géographiquement
    ...  sont bien filtrés par commune, ainsi que par collectivité/service

    Depuis la page d'accueil  admin  admin
    # Activation du paramètre permettant d'accéder au champ commune
    &{param_values} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # communes
    &{com_mars_1_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=13001
    ...  reg=13
    ...  dep=13
    ...  arr=001
    ...  tncc=0
    ...  ncc=Mars1
    ...  nccenr=Mars1
    ...  libelle=Marseille 1er
    ...  can=1
    ...  comparent=
    Ajouter commune avec dates validité  ${com_mars_1_values}
    &{com_mars_2_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=13002
    ...  reg=13
    ...  dep=13
    ...  arr=002
    ...  tncc=0
    ...  ncc=Mars2
    ...  nccenr=Mars2
    ...  libelle=Marseille 2ème
    ...  can=1
    ...  comparent=
    Ajouter commune avec dates validité  ${com_mars_2_values}
    &{com_allauch_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=13190
    ...  reg=13
    ...  dep=13
    ...  arr=000
    ...  tncc=0
    ...  ncc=Allauch
    ...  nccenr=Allauch
    ...  libelle=Allauch
    ...  can=1
    ...  comparent=
    Ajouter commune avec dates validité  ${com_allauch_values}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Rick
    ...  particulier_prenom=Pat
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  000  0A  0001
    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE
    ...  commune=Marseille 1er
    ${libelle_di_1} =  Ajouter la nouvelle demande  ${args_demande_1}  ${args_petitionnaire}
    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE
    ...  commune=Marseille 1er
    ${libelle_di_2} =  Ajouter la nouvelle demande  ${args_demande_2}  ${args_petitionnaire}
    &{args_demande_3} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE
    ...  commune=Marseille 2ème
    ${libelle_di_3} =  Ajouter la nouvelle demande  ${args_demande_3}  ${args_petitionnaire}
    &{args_demande_4} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=ALLAUCH
    ...  commune=Marseille 1er
    ${libelle_di_4} =  Ajouter la nouvelle demande  ${args_demande_4}  ${args_petitionnaire}
    &{args_demande_5} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=ALLAUCH
    ...  commune=Allauch
    ${libelle_di_5} =  Ajouter la nouvelle demande  ${args_demande_5}  ${args_petitionnaire}

    ${libelle_di_1_noP0} =  Replace String Using Regexp  ${libelle_di_1}  P0$  ${EMPTY}
    ${libelle_di_2_noP0} =  Replace String Using Regexp  ${libelle_di_2}  P0$  ${EMPTY}
    ${libelle_di_3_noP0} =  Replace String Using Regexp  ${libelle_di_3}  P0$  ${EMPTY}
    ${libelle_di_4_noP0} =  Replace String Using Regexp  ${libelle_di_4}  P0$  ${EMPTY}
    ${libelle_di_5_noP0} =  Replace String Using Regexp  ${libelle_di_5}  P0$  ${EMPTY}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_1}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_2}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_3}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_4}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_5}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}

    # Vérification de la prise en compte de la ref cadastrale sur 8 caractères
    @{ref_cad} =  Create List  000  A  0001
    ${ref_cadastrale} =  Create Dictionary
    ...  terrain_references_cadastrales=${ref_cad}

    Modifier le dossier d'instruction  ${libelle_di_2}  ${ref_cadastrale}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_1}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_2}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_3}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_4}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_5}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_commune
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

    # On remet le 0
    @{ref_cad} =  Create List  000  0A  0001
    ${ref_cadastrale} =  Create Dictionary
    ...  terrain_references_cadastrales=${ref_cad}

    Modifier le dossier d'instruction  ${libelle_di_2}  ${ref_cadastrale}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_1}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_2}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_3}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_4}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_5}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}

    # Vérification de la prise en compte de la ref cadastrale sur 8 caractères
    @{ref_cad} =  Create List  000  A  0001
    ${ref_cadastrale} =  Create Dictionary
    ...  terrain_references_cadastrales=${ref_cad}

    Modifier le dossier d'instruction  ${libelle_di_2}  ${ref_cadastrale}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_1}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_2}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_3}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_4}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_5_noP0}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_5}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_1_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_2_noP0}
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_di_3_noP0}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_4_noP0}
