*** Settings ***
Documentation  Test des événements d'instruction.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Variables ***
${json_instruction_finalisation}  {"module":"instruction"}


*** Test Cases ***
Création du jeu de données

    [Documentation]  Constitue le jeu de données.

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire&Co
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Martin
    ...  personne_morale_prenom=Nicolas
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_ok} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}


    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Odo
    ...  particulier_prenom=Laurent
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_bible_consultation} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Set Suite Variable  ${di_bible_consultation}

    Depuis la page d'accueil  admin  admin

    Ajouter une consultation depuis un dossier  ${di_bible_consultation}  59.01 - Direction de l'Eau et de l'Assainissement
    Ajouter une consultation depuis un dossier  ${di_bible_consultation}  59.01 - SERAM


    Depuis la page d'accueil  consu  consu
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  motivation=Test
    Rendre l'avis sur la consultation du dossier  ${di_bible_consultation}  ${args_avis_consultation}

    Depuis la page d'accueil  admin  admin

    # Liste des valeurs pour le tableau des surfaces des données techniques
    &{donnees_techniques_values} =  Create Dictionary
    ...  su_avt_shon1=10
    ...  su_avt_shon2=10
    ...  su_avt_shon3=10
    ...  su_avt_shon4=10
    ...  su_avt_shon5=10
    ...  su_avt_shon6=10
    ...  su_avt_shon7=10
    ...  su_avt_shon8=10
    ...  su_avt_shon9=10
    ...  su_cstr_shon1=10
    ...  su_cstr_shon2=10
    ...  su_cstr_shon3=10
    ...  su_cstr_shon4=10
    ...  su_cstr_shon5=10
    ...  su_cstr_shon6=10
    ...  su_cstr_shon7=10
    ...  su_cstr_shon8=10
    ...  su_cstr_shon9=10
    ...  su_chge_shon1=10
    ...  su_chge_shon2=10
    ...  su_chge_shon3=10
    ...  su_chge_shon4=10
    ...  su_chge_shon5=10
    ...  su_chge_shon6=10
    ...  su_chge_shon7=10
    ...  su_chge_shon8=10
    ...  su_chge_shon9=10
    ...  su_demo_shon1=10
    ...  su_demo_shon2=10
    ...  su_demo_shon3=10
    ...  su_demo_shon4=10
    ...  su_demo_shon5=10
    ...  su_demo_shon6=10
    ...  su_demo_shon7=10
    ...  su_demo_shon8=10
    ...  su_demo_shon9=10
    ...  su_sup_shon1=10
    ...  su_sup_shon2=10
    ...  su_sup_shon3=10
    ...  su_sup_shon4=10
    ...  su_sup_shon5=10
    ...  su_sup_shon6=10
    ...  su_sup_shon7=10
    ...  su_sup_shon8=10
    ...  su_sup_shon9=10
    Modifier les données techniques pour le calcul des surfaces  ${di_ok}  ${donnees_techniques_values}

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Smith
    ...  particulier_prenom=John
    ...  om_collectivite=MARSEILLE

    ${di_ko} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    #
    Ajouter une instruction au DI  ${di_ko}  Consultation ERP ET IGH
    # Liste des valeurs pour le tableau des surfaces des données techniques
    &{donnees_techniques_values} =  Create Dictionary
    ...  su_avt_shon1=10
    ...  su_avt_shon2=10
    ...  su_avt_shon3=10
    ...  su_avt_shon4=10
    ...  su_avt_shon5=10
    ...  su_avt_shon6=10
    ...  su_avt_shon7=10
    ...  su_avt_shon8=10
    ...  su_avt_shon9=10
    ...  su_cstr_shon1=10
    ...  su_cstr_shon2=10
    ...  su_cstr_shon3=10
    ...  su_cstr_shon4=10
    ...  su_cstr_shon5=10
    ...  su_cstr_shon6=10
    ...  su_cstr_shon7=10
    ...  su_cstr_shon8=10
    ...  su_cstr_shon9=10
    ...  su_chge_shon1=10
    ...  su_chge_shon2=10
    ...  su_chge_shon3=10
    ...  su_chge_shon4=10
    ...  su_chge_shon5=10
    ...  su_chge_shon6=10
    ...  su_chge_shon7=10
    ...  su_chge_shon8=10
    ...  su_chge_shon9=10
    ...  su_demo_shon1=10
    ...  su_demo_shon2=10
    ...  su_demo_shon3=10
    ...  su_demo_shon4=10
    ...  su_demo_shon5=10
    ...  su_demo_shon6=10
    ...  su_demo_shon7=10
    ...  su_demo_shon8=10
    ...  su_demo_shon9=10
    ...  su_sup_shon1=10
    ...  su_sup_shon2=10
    ...  su_sup_shon3=10
    ...  su_sup_shon4=10
    ...  su_sup_shon5=10
    ...  su_sup_shon6=10
    ...  su_sup_shon7=10
    ...  su_sup_shon8=10
    ...  su_sup_shon9=10
    Modifier les données techniques pour le calcul des surfaces  ${di_ko}  ${donnees_techniques_values}
    #
    Set Suite Variable  ${di_ok}
    Set Suite Variable  ${di_ko}


Verification du menu
    [Documentation]  Le but est de verifier si on a acces a toute les pages.

    Depuis la page d'accueil  instr  instr
    Go To Submenu In Menu  instruction  dossier_instruction_mes_encours
    Page Title Should Be  Instruction > Dossiers D'instruction
    Go To Submenu In Menu  instruction  dossier_instruction_tous_encours
    Page Title Should Be  Instruction > Dossiers D'instruction
    Go To Submenu In Menu  instruction  dossier_instruction_mes_clotures
    Page Title Should Be  Instruction > Dossiers D'instruction
    Go To Submenu In Menu  instruction  dossier_instruction_tous_clotures
    Page Title Should Be  Instruction > Dossiers D'instruction
    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    Page Title Should Be  Instruction > Dossiers D'instruction

    Go To Submenu In Menu  instruction  dossier_qualifier
    Page Title Should Be  Instruction > Qualification > Dossiers À Qualifier
    Go To Submenu In Menu  instruction  architecte_frequent
    Page Title Should Be  Instruction > Qualification > Architecte Fréquent

    Go To Submenu In Menu  instruction  consultation_mes_retours
    Page Title Should Be  Instruction > Consultations > Mes Retours
    Go To Submenu In Menu  instruction  consultation_tous_retours
    Page Title Should Be  Instruction > Consultations > Tous Les Retours

    Go To Submenu In Menu  instruction  messages_mes_retours
    Page Title Should Be  Instruction > Messages > Mes Messages
    Go To Submenu In Menu  instruction  messages_tous_retours
    Page Title Should Be  Instruction > Messages > Tous Les Messages


    Go To Submenu In Menu  instruction  commission_mes_retours
    Page Title Should Be  Instruction > Commissions > Mes Retours
    Go To Submenu In Menu  instruction  commission_tous_retours
    Page Title Should Be  Instruction > Commissions > Tous Les Retours


Visualisation de DI et DA
    [Documentation]  On vérifie que le les DI et DA sont consultable par
    ...  l'instructeur en charge

    Depuis la page d'accueil  instr  instr
    Go To Submenu In Menu  instruction  dossier_instruction_mes_encours
    Page Title Should Be  Instruction > Dossiers D'instruction
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  AZ 013055 12 00001P0
    Element Should Contain  dossier_libelle  AZ 013055 12 00001P0
    On clique sur l'onglet  instruction  Instruction
    On clique sur l'onglet  consultation  Consultation(s)
    On clique sur l'onglet  lot  Lot(s)
    On clique sur l'onglet  dossier_message  Message(s)
    On clique sur l'onglet  dossier_commission  Commission(s)
    On clique sur l'onglet  blocnote  Bloc-note
    On clique sur l'onglet  lien_dossier_dossier  Dossiers Liés
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  AZ 013055 12 00001
    Element Should Contain  css=.form-content>#dossier_autorisation_libelle  AZ 013055 12 00001
    On clique sur l'onglet  dossier_instruction  Dossiers D'instruction
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  AZ 013055 12 00001P0
    Element Should Contain  dossier_libelle  AZ 013055 12 00001P0


Verification de restriction d'instruction
    [Documentation]  Ajout d'instructions par l'instructeur,
    ...  modification des restriction un événement

    # ici on test la modification des restriction des evenements d'instruction

    ${evenement} =  Set Variable  CDEC majoration appel decision

    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  parametrage-dossier  evenement
    Use Simple Search  Tous  ${evenement}
    Click Element Until No More Element  xpath=//a[text()[contains(.,"${evenement}")]]
    Click On Form Portlet Action  evenement  modifier
    # On emule une erreur de champ non existant
    Input Text  css=#restriction  date_evenement >= champ_errone + 1
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div.ui-state-error p span.text  SAISIE NON ENREGISTRÉE
    # On remplace par une valeur qui marche
    Input Text  css=#restriction  date_evenement >= date_evenement + 1
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.


    # On vérifie que les restrictions fonctionne en essayant de créer une instruction

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet instruction du dossier d'instruction  ${di_ok}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Saisir instruction  ${evenement}
    Click On Submit Button In Subform Until Message  SAISIE NON ENREGISTRÉE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div.ui-state-error p span.text  SAISIE NON ENREGISTRÉE

    # On remet d'aplon l'événement

    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  parametrage-dossier  evenement
    Use Simple Search  Tous  ${evenement}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${evenement}
    Click On Form Portlet Action  evenement  modifier
    Input Text  css=#restriction  date_evenement <= date_evenement + 1
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di_ok}  ${evenement}
    Click On Back Button In Subform
    Click On Back Button In Subform
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${evenement}

    # On vérifie l'absence d'Element
    Wait Until Element Is Not Visible  css=#date_envoi_controle_legalite
    Wait Until Element Is Not Visible  css=#date_retour_controle_legalite


Suivi des dates

    [Documentation]  Cette action, directement disponible depuis la fiche d'un
    ...  événement d'instruction, permet d'éviter de passer par l'entrée menu.
    ...  L'objet de ce test case est de vérifier son comportement selon le contexte.

    # Jeu de données
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Clavet
    ...  particulier_prenom=Sandrine
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  Notification de pieces manquante
    Depuis l'instruction du dossier d'instruction  ${di}  Notification de pieces manquante
    Portlet Action Should Be In SubForm  instruction  supprimer
    Click On SubForm Portlet Action  instruction  finaliser
    # L'instruction doit être finalisée et l'instructeur ne peut pas suivre les dates
    Portlet Action Should Be In SubForm  instruction  edition
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Be In SubForm  instruction  definaliser
    Portlet Action Should Not Be In SubForm  instruction  modifier_suivi
    Portlet Action Should Not Be In SubForm  instruction  modifier
    # On clique sur l'action "Suivi des dates"
    Depuis la page d'accueil  admingen  admingen
    Depuis l'instruction du dossier d'instruction  ${di}  Notification de pieces manquante
    Click On SubForm Portlet Action  instruction  modifier_suivi
    # On saisit les dates
    Input Datepicker  date_finalisation_courrier  ${date_ddmmyyyy}
    Input Datepicker  date_envoi_signature  ${date_ddmmyyyy}
    Input Datepicker  date_envoi_rar  ${date_ddmmyyyy}
    Input Datepicker  date_envoi_controle_legalite  ${date_ddmmyyyy}
    Input Datepicker  date_retour_signature  ${date_ddmmyyyy}
    Input Datepicker  date_retour_rar  ${date_ddmmyyyy}
    Input Datepicker  date_retour_controle_legalite  ${date_ddmmyyyy}
    Click On Submit Button In Subform
    # On contrôle les dates saisies
    Element Text Should Be  date_finalisation_courrier  ${date_ddmmyyyy}
    Element Text Should Be  date_envoi_signature  ${date_ddmmyyyy}
    Element Text Should Be  date_envoi_rar  ${date_ddmmyyyy}
    Element Text Should Be  date_envoi_controle_legalite  ${date_ddmmyyyy}
    Element Text Should Be  date_retour_signature  ${date_ddmmyyyy}
    Element Text Should Be  date_retour_rar  ${date_ddmmyyyy}
    Element Text Should Be  date_retour_controle_legalite  ${date_ddmmyyyy}
    # On doit pouvoir modifier mais pas suivre les dates si l'on est instructeur
    # Cas 1/3 : INSTRUCTEUR
    Depuis la page d'accueil  instr  instr
    Depuis l'instruction du dossier d'instruction  ${di}  Notification de pieces manquante
    Portlet Action Should Not Be In SubForm  instruction  modifier_suivi
    Click On SubForm Portlet Action  instruction  definaliser
    Click On SubForm Portlet Action  instruction  modifier

    # Si le click du portlet ne fonctionne pas on essaie encore
    ${status} =  Run Keyword And Return Status  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  date_finalisation_courrier
    Run Keyword If  ${status} == False  Click On SubForm Portlet Action  instruction  modifier

    Element Should Not Be Visible  date_finalisation_courrier
    Element Should Not Be Visible  date_envoi_signature
    Element Should Not Be Visible  date_envoi_rar
    Element Should Not Be Visible  date_retour_signature
    Element Should Not Be Visible  date_retour_rar
    Click On Back Button In Subform
    Click On SubForm Portlet Action  instruction  finaliser
    Portlet Action Should Not Be In SubForm  instruction  modifier_suivi
    # Cas 2/3 : GUICHET SUIVI
    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    Depuis l'instruction du dossier d'instruction  ${di}  Notification de pieces manquante
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Element Should Be Visible  date_finalisation_courrier
    Element Should Be Visible  date_envoi_signature
    Element Should Be Visible  date_envoi_rar
    Element Should Be Visible  date_retour_signature
    Element Should Be Visible  date_retour_rar
    # Cas 3/3 : ADMIN
    Depuis la page d'accueil  admingen  admingen
    Depuis l'instruction du dossier d'instruction  ${di}  Notification de pieces manquante
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Element Should Be Visible  date_finalisation_courrier
    Element Should Be Visible  date_envoi_signature
    Element Should Be Visible  date_envoi_rar
    Element Should Be Visible  date_retour_signature
    Element Should Be Visible  date_retour_rar
    # L'instructeur polyvalent commune doit pouvoir suivre les dates d'un DI
    # dont l'instruction a été déléguée à la communauté.
    # Cas 1/2 : réaffectation
    Depuis la page d'accueil  admin  admin
    # Ajoute un instructeur polyvalent affecté à la collevtivité de niveau 2
    Ajouter l'utilisateur  LaGarde Armand  support@atreal.fr  instrpolyagglo  instrpolyagglo  INSTRUCTEUR POLYVALENT  agglo
    Ajouter la direction depuis le menu  ADS-AGGLO  Direction ADS-AGGLO  null  Chef ADS  null  null  agglo
    Ajouter la division depuis le menu  X  subdivision X-AGGLO  null  Chef X  null  null  Direction ADS-AGGLO
    Ajouter l'instructeur depuis le menu  LaGarde Armand  subdivision X-AGGLO  instructeur  LaGarde Armand
    # Permet le même comportement du test éxécuter seul ou avec tous les autres
    # tests
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  modifier
    Select From List By Label  instructeur  LaGarde Armand (X)
    Click On Submit Button
    #
    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    Depuis l'instruction du dossier d'instruction  ${di}  Notification de pieces manquante
    Portlet Action Should Be In SubForm  instruction  modifier_suivi
    # Cas 2/2 : affectation automatique
    Depuis la page d'accueil  admin  admin
    &{args_affectation} =  Create Dictionary
    ...  instructeur=LaGarde Armand (X)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=DECLARATION PREALABLE SIMPLE
    Ajouter l'affectation depuis le menu  ${args_affectation}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Torri
    ...  particulier_prenom=Renato
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=DECLARATION PREALABLE SIMPLE
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # Instructeur polyvalent commune de la même collectivité que celle du dossier
    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    Depuis l'instruction du dossier d'instruction  ${di}  Notification du delai legal maison individuelle
    Portlet Action Should Be In SubForm  instruction  modifier_suivi
    # On peut toujours modifier les dates de suivi quand le dossier est clôturé
    # avec la permission *instruction_modification_dates_cloture*
    Depuis la page d'accueil  instrpolyagglo  instrpolyagglo
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve
    Click On Back Button In Subform
    Click On SubForm Portlet Action  instruction  finaliser
    Depuis l'instruction du dossier d'instruction  ${di}  Notification du delai legal maison individuelle
    Portlet Action Should Be In SubForm  instruction  modifier_suivi
    # On ne peut pas modifier les dates si le dossier est clos et que l'utilisateur
    # ne possède pas la permission *instruction_modification_dates_cloture*
    Depuis la page d'accueil  admin  admin
    Supprimer le droit depuis le contexte du profil  instruction_modification_dates_cloture  INSTRUCTEUR POLYVALENT
    Depuis la page d'accueil  instrpolyagglo  instrpolyagglo
    Depuis l'instruction du dossier d'instruction  ${di}  Notification du delai legal maison individuelle
    Portlet Action Should Not Be In SubForm  instruction  modifier_suivi

    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_afficher_division
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
    Supprimer l'affectation depuis le menu  LaGarde Armand (X)  DECLARATION PREALABLE SIMPLE
    Ajouter le droit depuis le menu  instruction_modification_dates_cloture  INSTRUCTEUR POLYVALENT


Lien vers le di dans le message de validation de la demande

    [Documentation]  Vérifie si le lien dans le message de validation est
    ...  fonctionnel.

    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Geralt


    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial

    ${libelle_di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}
    # On clique sur le lien vers le DI du message de validation
    Click Element Until No More Element  css=#link_demande_dossier_instruction
    # On vérifie le fil d'Ariane
    Page Title Should Be    Instruction > Dossiers D'instruction > ${libelle_di} DUPONT GERALT

Finalisation
    [Documentation]  L'objet de ce 'Test Case' est de vérifier le log de
    ...    l'utilisateur qui a finalisé l'événement.

    # Constitution du jeu de données : deux utilisateurs dont un est instructeur
    # car si tel est le cas son nom d'instructeur surcharge son nom d'utilisateur.
    # En tant qu'administrateur
    Depuis la page d'accueil  admin  admin
    # Donnée 2/3 : instructeur
    Ajouter l'utilisateur  Marois Alain -UTIL-  support@atreal.fr  instrmars  instrmars  INSTRUCTEUR  MARSEILLE
    Ajouter la direction depuis le menu  MRS  Direction MRS  null  Chef MRS  null  null  MARSEILLE
    Ajouter la division depuis le menu  MRS  subdivision MRS  null  Chef MRS  null  null  Direction MRS
    Ajouter l'instructeur depuis le menu  Marois Alain -INSTR-  subdivision MRS  instructeur  Marois Alain -UTIL-
    # Donnée 3/3 : affectation automatique du nouvel instructeur
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Marois Alain -INSTR- (MRS)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # On crée une nouvelle demande via le tableau de bord
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Perrault
    ...  particulier_prenom=Sophie
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    # On crée une nouvelle demande via le tableau de bord
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # En tant qu'instructeur de Martigues
    Depuis la page d'accueil  instrmars  instrmars
    # On ouvre l'onglet instruction du nouveau DI
    Depuis l'onglet instruction du dossier d'instruction  ${di_libelle}
    # On accède à l'instruction
    Click On Link  Notification du delai legal maison individuelle
    # On vérifie qu'elle a été finalisée par le guichetier automatiquement
    # lors de la création
    Wait Until Element Is Visible  om_final_instruction_utilisateur
    Element Text Should Be  om_final_instruction_utilisateur  admin (Administrateur)
    # On reprend la rédaction
    Click On SubForm Portlet Action  instruction  definaliser
    # On vérifie qu'il n'y a pas le champ "finalisé par"
    Element Should Not Be Visible  om_final_instruction_utilisateur
    # On finalise
    Click On SubForm Portlet Action  instruction  finaliser
    # On vérifie le log
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Text Should Be  om_final_instruction_utilisateur  instrmars (Marois Alain -INSTR-)

    Depuis la page d'accueil  admin  admin
    Supprimer l'affectation depuis le menu  Marois Alain -INSTR- (MRS)  Permis de construire comprenant ou non des démolitions

Définalisation d'instruction

    [Documentation]  Permet de vérifier qu'un utilisateur hors division ne peut
    ...  définaliser un événement d'instruction.

    Depuis la page d'accueil  instr2  instr
    Depuis le contexte du dossier d'instruction  ${di_ko}
    # On clique sur le lien Instruction
    Click On Link  css=#instruction
    # On clique sur la 1ere instruction
    Click On Link  Notification du delai legal maison individuelle
    # Vérification que l'instructeur ne peut pas definaliser
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=#sousform-instruction div#portlet-actions  Reprendre la rédaction du document


Vérification du récapitulatif du dossier d'instruction

    [Documentation]  Vérifie l'affichage des champs de fusion sur un dossier
    ...  d'instruction.

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di_ko}
    # On clique sur l'action édition
    Click On Form Portlet Action  dossier_instruction  edition  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le pétitionnaire principal
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Monsieur Smith John
    # On vérifie le résultat total du tableau des surface
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Surface totale : 90
    # On ferme le PDF
    Close PDF


Vérification de l'édition de l'instruction

    [Documentation]  Vérifie l'affichage des champs de fusion sur une
    ...  instruction, et que le portail d'actions contextuelles contient les bonnes actions
    ...  de finalisation et de définalisation et modification dans les bons contextes.

    Depuis la page d'accueil  instr  instr
    Depuis l'instruction du dossier d'instruction  ${di_ok}  Notification du delai legal maison individuelle
    # On régénère le récépissé
    Click On SubForm Portlet Action  instruction  definaliser
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La définalisation du document s'est effectuée avec succès.
    Portlet Action Should Not Be In SubForm  instruction  definaliser
    Portlet Action Should Be In SubForm  instruction  modifier
    # On clique sur l'action édition
    Click On SubForm Portlet Action  instruction  edition  new_window
    # on verifie le premier nom de PDF
    Open PDF  ${OM_PDF_TITLE}
    Sleep  1
    # On ferme le PDF
    Close PDF

    Click On SubForm Portlet Action  instruction  finaliser
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La finalisation du document s'est effectuée avec succès.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Not Be In SubForm  instruction  finaliser
    Portlet Action Should Not Be In SubForm  instruction  modifier
    # On clique sur l'action édition
    Click On SubForm Portlet Action  instruction  edition  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le pétitionnaire principal
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Société Notaire&Co représenté(e) par Monsieur Martin Nicolas
    # On vérifie le résultat total du tableau des surface
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Surface totale : 90
    # On ferme le PDF
    Close PDF


Vérification de l'édition du rapport d'instruction

    [Documentation]  Vérifie l'affichage des champs de fusion sur un rapport
    ...  d'instruction. On vérifie ensuite qu'après que le rapport d'instruction soit
    ...  finalisé, la consultation de l'édition récupère le PDF directement en utilisant
    ...  le snippet file sans le regénérer à la volée.

    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis le contexte du rapport d'instruction  ${di_ok}
    # On valide le rapport d'instruction
    Capture Page Screenshot
    Click On Submit Button In Subform
    Capture Page Screenshot
    # On vérifie le message de validation
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Capture Page Screenshot
    # On clique sur le bouton retour
    Click On Back Button In Subform
    #
    Depuis le contexte du rapport d'instruction  ${di_ok}
    # On clique sur l'action de finaliser
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La finalisation du document s'est effectuée avec succès.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Not Be In SubForm  rapport_instruction  finalise
    Portlet Action Should Not Be In SubForm  rapport_instruction  modifier
    Click On SubForm Portlet Action  rapport_instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le pétitionnaire principal
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Société Notaire&Co représenté(e) par Monsieur Martin Nicolas
    # On vérifie le résultat total du tableau des surface
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Surface totale : 90
    Close PDF

    Click On SubForm Portlet Action  rapport_instruction  definalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La définalisation du document s'est effectuée avec succès.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Not Be In SubForm  rapport_instruction  definalise
    Portlet Action Should Be In SubForm  rapport_instruction  modifier
    Portlet Action Should Be In SubForm  rapport_instruction  finalise

    Click On SubForm Portlet Action  rapport_instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    Sleep  1
    Close PDF

    # On modifie le rapport d'instruction pour contrôler le comportement de
    # l'overlay
    &{args_rapport_instruction} =  Create Dictionary
    ...  description_projet_om_html=À vérifier pour les tests
    Modifier le rapport d'instruction  ${di_ok}  ${args_rapport_instruction}
    # On clic sur le bouton retour et on vérifie que l'overlay est fermé
    Click On Back Button In Subform
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=div#sousform-rapport_instruction
    Depuis le contexte du rapport d'instruction  ${di_ok}
    # On clique sur l'action de finaliser
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La finalisation du document s'est effectuée avec succès.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Not Be In SubForm  rapport_instruction  finalise
    Portlet Action Should Not Be In SubForm  rapport_instruction  modifier
    Click On SubForm Portlet Action  rapport_instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  À vérifier pour les tests
    Close PDF

Changement de décision par commune
    [Documentation]  L'objet de ce 'Test Case' est de vérifier le changement de
    ...  décision par un instructeur polyvalent commune

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # Création d'une direction (rattaché à l'agglo), d'une division et de deux instructeur
    # 1 instructeur non lié a un utilisateur et 1 autre avec un profil utilisateur associé
    Ajouter l'utilisateur  Audibert Rémy  support@atreal.fr  instrPolyAgglo  instrPolyAgglo  INSTRUCTEUR POLYVALENT  agglo
    Ajouter la direction depuis le menu  agglo  Direction Generale  null  Chef DG  null  null  agglo
    Ajouter la division depuis le menu  DG  DG  null  Chef DG  null  null  Direction Generale
    Ajouter l'instructeur depuis le menu  Gabriaux Alphonse  DG  instructeur  null
    Ajouter l'instructeur depuis le menu  Audibert Rémy  DG  instructeur  Audibert Rémy

    # Création de l'action de workflow "changement de décision"
    &{args_action} =  Create Dictionary
    ...  action=changer_decision
    ...  libelle=Changer la décision
    ...  regle_etat=etat

    Ajouter l'action depuis le menu  ${args_action}

    # Création d'un événement de workflow de changement de décision
    @{etat_source} =  Create List  dossier accepter  dossier accepté tacitement  dossier rejeter manque de pieces  delai de notification envoye
    @{type_di} =  Create List  PA - P - Initial  PCI - P - Initial

    &{args_evenement} =  Create Dictionary
    ...  libelle=Modification décision
    ...  type=changement de décision
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=Changer la décision
    ...  etat=delai de notification envoye

    Ajouter l'événement depuis le menu  ${args_evenement}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Halliwell
    ...  particulier_prenom=Geri
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_change_decision} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Affectation du dossier à l'instructeur polyvalent (communauté)
    # L'instructeur doit appartenir a une division rattaché à une collectivité de niveau 2
    # pour que le dossier puisse être éligible au changement de décision
    # TNR : l'instructeur n'a pas d'utilisateur pour vérifier si malgré cela le dossier
    # reste éligible au changement de décision par les instructeurs communes
    &{args_di} =  Create Dictionary
    ...  instructeur=Gabriaux Alphonse (DG)
    Modifier le dossier d'instruction  ${di_change_decision}  ${args_di}

    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    ${widget_content} =  Get Text  view_widget_dossiers_evenement_retour_finalise
    Should Not Contain  ${widget_content}  ${di_change_decision}

    # En tant qu'instructeur polyvalent (communauté)
    Depuis la page d'accueil  instrPolyAgglo  instrPolyAgglo

    # On vérifie que les valeurs onsubmit et data-href des éléments form et div sont correctement modifiés lors de l'ajout d'un évènement sans lettre type
    ${evenement} =  Set Variable  Changer l'autorité compétente 'commune état'

    Depuis l'onglet instruction du dossier d'instruction  ${di_change_decision}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Saisir instruction  ${evenement}

    ${form_attr_onsubmit_value} =  Get Element Attribute  css=div#sousform-container form  onsubmit
    ${div_attr_data_href_value} =  Get Element Attribute  css=div#sousform-href  data-href
    ${contains_onsubmit}=  Evaluate   "retour=tab" in """${form_attr_onsubmit_value}"""
    ${contains_data_href}=  Evaluate   "retour=tab" in """${div_attr_data_href_value}"""
    Should Be True  ${contains_onsubmit}
    Should Be True  ${contains_data_href}

    # Ajout au DI une décision que l'utilisateur instructeur polyvalent commune changera
    Ajouter une instruction au DI  ${di_change_decision}  ARRÊTÉ DE REFUS
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click On Link  ARRÊTÉ DE REFUS
    ${id_instruction_1} =  Get Value  css=.form-content input#instruction

    # L'instructeur de la commune ne doit pas pouvoir:
    #  - modifier
    #  - supprimer
    #  - finaliser
    # l'instruction réalisée par l'instructeur de la communauté
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    Depuis l'onglet instruction du dossier d'instruction  ${di_change_decision}
    Click On Link  ARRÊTÉ DE REFUS
    Element Should Not Be Visible  action-sousform-instruction-modifier
    Element Should Not Be Visible  action-sousform-instruction-supprimer
    Element Should Not Be Visible  action-sousform-instruction-finaliser

    # Finalise l'instruction
    Depuis la page d'accueil  instrPolyAgglo  instrPolyAgglo
    Depuis l'onglet instruction du dossier d'instruction  ${di_change_decision}
    Click On Link  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  finaliser

    # L'instructeur de la commune ne doit pas pouvoir:
    #  - modifier
    #  - supprimer
    #  - définaliser
    # l'instruction réalisée par l'instructeur de la communauté
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    Depuis l'onglet instruction du dossier d'instruction  ${di_change_decision}
    Click On Link  ARRÊTÉ DE REFUS
    Element Should Not Be Visible  action-sousform-instruction-modifier
    Element Should Not Be Visible  action-sousform-instruction-supprimer
    Element Should Not Be Visible  action-sousform-instruction-definaliser

    # En tant qu'instructeur polyvalent commune
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    ${widget_content} =  Get Text  view_widget_dossiers_evenement_retour_finalise
    Should Contain  ${widget_content}  ${di_change_decision}
    # On clic pour voir tous les dossiers
    Click On Link  Voir les dossiers auxquels on peut proposer une autre décision
    # On clic sur le DI
    Click On Link  ${di_change_decision}
    # Affiche les instructions
    On clique sur l'onglet  instruction  Instruction

    # Ajout de l'événement d'instruction de modification de décision
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    #
    Saisir instruction  Modification décision
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message de validation
    Page Should Contain  Vos modifications ont bien été enregistrées.

    # En tant qu'instructeur polyvalent commune 2
    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    # Changement de la décision
    Ajouter une instruction au DI  ${di_change_decision}  ARRÊTÉ DE REFUS 2

    # En tant qu'instructeur polyvalent commune
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    # On finalise avec un autre instructeur polyvalent commune
    Depuis l'onglet instruction du dossier d'instruction  ${di_change_decision}
    Click On Link  ARRÊTÉ DE REFUS 2
    ${id_instruction_2} =  Get Value  css=.form-content input#instruction

    # En tant qu'instructeur polyvalent (communauté)
    Depuis la page d'accueil  instrPolyAgglo  instrPolyAgglo

    # On en déduit le code-barres
    ${code_barres} =  STR_PAD_LEFT  ${id_instruction_2}  10  0
    ${code_barres} =  Catenate  11${code_barres}
    Go To Submenu In Menu    suivi    suivi_mise_a_jour_des_dates
    Select From List By Label  css=#type_mise_a_jour  date de notification du correspondant
    Input Text  date  ${date_ddmmyyyy}
    Input Text  code_barres  ${code_barres}
    # On valide le formulaire
    Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#formulaire div.formControls input[type="submit"]
    Click Element  css=#formulaire div.formControls input[type="submit"]

    # En tant qu'instructeur polyvalent commune
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    ${widget_content} =  Get Text  view_widget_dossiers_evenement_retour_finalise
    Should Not Contain  ${widget_content}  ${di_change_decision}

    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_afficher_division
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

TNR Bug instructeur commune modifier finaliser définaliser instruction

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Dupont
    ...  particulier_prenom=Marc
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=DECLARATION PREALABLE SIMPLE
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrpolycomm  instrpolycomm

    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Click On Link  Notification du delai legal maison individuelle
    Click On SubForm Portlet Action  instruction  definaliser
    Click On SubForm Portlet Action  instruction  modifier
    Click On Submit Button In Subform
    Click On SubForm Portlet Action  instruction  finaliser

TNR Bug instructeur commune ajout d'evenements autre que décision

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Dupont
    ...  particulier_prenom=Francis
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    Ajouter une instruction au DI  ${di}  Commission Communale de Sécurité


TNR Bug instructeur commune ajout d'evenements sur dossier cloturé

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Dupont
    ...  particulier_prenom=Albert
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrpoly  instrpoly
    Ajouter une instruction au DI  ${di}  accepter un dossier avec reserve
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click Element Until No More Element  xpath=//a[text()[contains(.,"accepter un dossier avec reserve")]]
    # On finalise
    Click On SubForm Portlet Action  instruction  finaliser

    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    ${widget_content} =  Get Text  view_widget_dossiers_evenement_retour_finalise
    Should Not Contain  ${widget_content}  ${di}

    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Should Not Contain  css=#sousform-instruction  action-soustab-instruction-corner-ajouter


Modification du type de dossier d'instruction

    Depuis La Page D'accueil  admin  admin

    #-- début - Récupération de l'ID du "type de dossier d'instruction"
    # qui sera le nouveau "type de dossier d'instruction" au dossier sur lequel
    # il sera appliqué (via l'action qui suit ci-dessous)

    # On accède au tableau
    Depuis le listing  dossier_instruction_type
    # On recherche l'enregistrement
    Use Simple Search  type de dossier d'instruction  PCA
    ${selector}=  Set Variable  //div[@id = 'tab-dossier_instruction_type']/descendant::table[contains(@class, 'tab-tab')]/descendant::td[contains(@class, 'col-2')]/a[text()[contains(., "Initial")]]/ancestor::tr/td[contains(@class, 'col-0')]/a
    Sleep  1
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  xpath=${selector}
    ${di_new_type_id} =  Get Text  xpath=${selector}
    Log  ${di_new_type_id}
    #-- fin - Récupération de l'ID du "type de dossier d'instruction"

    Depuis La Page D'accueil  admin  admin

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST05MODFITYPENOM
    ...  particulier_prenom=TEST05MODFITYPEPRENOM
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #Création du dossier
    ${di} =  Ajouter la nouvelle demande depuis le menu  ${args_demande}  ${args_petitionnaire}

    #Création de l'action de la modification du type de dossier
    &{args_action} =  Create Dictionary
    ...  action=modif
    ...  libelle=Modification du type de dossier d'instruction
    ...  regle_dossier_instruction_type=${di_new_type_id}
    ${action} =  Ajouter l'action depuis le menu  ${args_action}

    #Création de l'événement de modification du type de dossier
    @{type_di} =  Create List  PCI - P - Initial
    @{etat} =  Create List  delai de notification envoye
    &{args_evenement} =  Create Dictionary
    ...  libelle=Modifier le type de dossier d'instruction
    ...  action=Modification du type de dossier d'instruction
    ...  dossier_instruction_type=${type_di}
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat}
    ...  etat=delai de notification envoye
    ${evenement} =  Ajouter l'événement depuis le menu  ${args_evenement}

    #Modification du type de di
    Ajouter une instruction au DI  ${di}  Modifier le type de dossier d'instruction
    Depuis le listing  dossier_instruction
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${di}
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  ${libelle_sans_espace}
    # On valide le formulaire de recherche
    Click On Search Button
    Element Should Contain  css=.tab-data  Permis de construire comprenant ou non des démolitions
    ${dossier_autorisation} =  Get Substring  ${di}  0  -2
    #Vérification du changement de type de dossier
    Depuis le contexte du dossier d'autorisation par la recherche  ${dossier_autorisation}

    Element Should Contain  css=#type_detaille  Permis de construire comprenant ou non des démolitions

    Supprimer l'instruction  ${di}  Modifier le type de dossier d'instruction

    Depuis le listing  dossier_instruction
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${di}
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  ${libelle_sans_espace}
    # On valide le formulaire de recherche
    Click On Search Button
    Element Should Contain  css=.tab-data  Permis de construire pour une maison individuelle et / ou ses annexes
    ${dossier_autorisation} =  Get Substring  ${di}  0  -2
    #Vérification du changement de type de dossier
    Depuis le contexte du dossier d'autorisation par la recherche  ${dossier_autorisation}

    Element Should Contain  css=#type_detaille  Permis de construire pour une maison individuelle et / ou ses annexes


TNR Bug type de dossiers auxquels un instructeur commune peut changer la décision
    [Documentation]    Les types de demande DOC DAACT et PRO ne doivent pas
    ...    apparaître dans le widget des dossiers auxquels on peut changer la décision


    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Beckham
    ...  particulier_prenom=Victoria
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_change_decision} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrpoly  instrpoly
    # Ajout au DI une décision que l'utilisateur instructeur polyvalent commune changera
    Ajouter une instruction au DI  ${di_change_decision}  accepter un dossier sans réserve
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click On Link  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  finaliser

    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande d'ouverture de chantier
    ...  om_collectivite=MARSEILLE
    ${di_change_decision_2} =  Ajouter la demande sur existant depuis le menu    ${di_change_decision}    ${args_demande}

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}
    &{args_di} =  Create Dictionary
    ...  instructeur=Poly (H)
    Modifier le dossier d'instruction  ${di_change_decision_2}  ${args_di}

    # Ajout au DI une décision que l'utilisateur instructeur polyvalent commune changera
    Ajouter une instruction au DI  ${di_change_decision_2}  ARRÊTÉ DE REFUS
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click On Link  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  finaliser

    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    # Vérification widget
    ${widget_content} =  Get Text  view_widget_dossiers_evenement_retour_finalise
    Should Not Contain  ${widget_content}  ${di_change_decision_2}
    # Vérification tableau
    Depuis le listing  dossier_instruction&decision=true
    Page Should Not Contain  ${di_change_decision_2}

    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_afficher_division
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

TNR Nature des travaux dans la description du DI
    [Documentation]  Concernant les données techniques sur la nature des travaux,
    ...  lorsque les cases sont cochées alors la description du projet les affiche.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Hasselhoff
    ...  particulier_prenom=David
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrpoly  instrpoly
    # On coche les cases du CERFA sur la nature des travaux
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # Besoin de temporiser l'affichage de la modale des données techniques
    Sleep  2
    Click On SubForm Portlet Action  donnees_techniques  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Click Element  css=fieldset[id*='construire---amenager---modifier-un-erp'] > legend
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=fieldset[id*='construire---amenager---modifier-un-erp'] > div.fieldsetContent
    Select Checkbox  erp_cstr_neuve
    Select Checkbox  erp_trvx_acc
    Select Checkbox  erp_extension
    Select Checkbox  erp_rehab
    Select Checkbox  erp_trvx_am
    Select Checkbox  erp_vol_nouv_exist
    Click On Submit Button In Subform
    Click On Back Button In Subform
    # On contrôle la description du projet
    Reload Page
    Element Should Contain  description_projet  Construction neuve
    Element Should Contain  description_projet  Travaux de mise en conformité totale aux règles d’accessibilité
    Element Should Contain  description_projet  Extension
    Element Should Contain  description_projet  Réhabilitation
    Element Should Contain  description_projet  Travaux d’aménagement (remplacement de revêtements, rénovation électrique, création d’une rampe, par exemple)
    Element Should Contain  description_projet  Création de volumes nouveaux dans des volumes existants (modification du cloisonnement, par exemple)


Vérifie la restriction de modifier le DI et de régénérer le récépissé

    [Documentation]  Vérifie que l'instructeur peut toujours modifier le dossier
    ...  d'instruction, même si la restriction imposée pour le guichet unique
    ...  et pour l'instructeur commune n'est pas respectée. Ces deux profils ne
    ...  peuvent modifier le dossier d'instruction qu'a condition que sa seule
    ...  instruction soit son récépissé ou que les instructions qui suivent
    ...  soient du type "affichage".

    # On modifie l'affectation automatique pour ce test
    Depuis la page d'accueil  admin  admin
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Poly (H)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    Ajouter l'affectation depuis le menu  ${args_affectation}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Geralt
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${libelle_di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    # On vérifie pour le guichet et suivi que les actions modifier et régénérer
    # le récépissé sont disponibles
    Depuis le contexte du dossier d'instruction  ${libelle_di}
    # Vérifie l'action modifier pour le guichet et suivi
    Portlet Action Should Be In Form  dossier_instruction  modifier
    # Vérifie l'action de régénérer le récépissé pour le guichet et suivi
    Portlet Action Should Be In Form  dossier_instruction  recepisse

    # On vérifie aussi pour l'instructeur commune que les actions modifier et
    # régénérer le récépissé sont disponibles
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    Depuis le contexte du dossier d'instruction  ${libelle_di}
    # Vérifie l'action modifier pour le guichet et suivi
    Portlet Action Should Be In Form  dossier_instruction  modifier
    # Vérifie l'action de régénérer le récépissé pour le guichet et suivi
    Portlet Action Should Be In Form  dossier_instruction  recepisse

    # On ajoute une instruction de type affichage au dossier
    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis le contexte du dossier d'instruction de mes encours  ${libelle_di}
    # Vérifie les actions modifier et régénérer le récépissé pour l'instructeur
    # polyvalent
    Portlet Action Should Be In Form  dossier_instruction_mes_encours  modifier
    Ajouter une instruction au DI  ${libelle_di}  affichage_obligatoire
    Depuis le contexte du dossier d'instruction de mes encours  ${libelle_di}
    # Vérifie l'action modifier pour l'instructeur polyvalent
    Portlet Action Should Be In Form  dossier_instruction_mes_encours  modifier

    # On vérifie que les actions soient toujours visibles pour le guichet et
    # suivi
    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    Depuis le contexte du dossier d'instruction  ${libelle_di}
    # Vérifie l'action modifier pour le guichet et suivi
    Portlet Action Should Be In Form  dossier_instruction  modifier
    # Vérifie l'action de régénérer le récépissé pour le guichet et suivi
    Portlet Action Should Be In Form  dossier_instruction  recepisse

    # On vérifie aussi pour l'instructeur commune que les actions modifier et
    # régénérer le récépissé sont disponibles
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    Depuis le contexte du dossier d'instruction  ${libelle_di}
    # Vérifie l'action modifier pour le guichet et suivi
    Portlet Action Should Be In Form  dossier_instruction  modifier
    # Vérifie l'action de régénérer le récépissé pour le guichet et suivi
    Portlet Action Should Be In Form  dossier_instruction  recepisse

    # On ajoute une instruction qui doit bloquer les actions aux autres
    # utilisateurs
    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis le contexte du dossier d'instruction de mes encours  ${libelle_di}
    Ajouter une instruction au DI  ${libelle_di}  majoration_IGH
    Depuis le contexte du dossier d'instruction de mes encours  ${libelle_di}
    # Vérifie l'action modifier pour l'instructeur polyvalent
    Portlet Action Should Be In Form  dossier_instruction_mes_encours  modifier

    # On vérifie que les actions ne soient plus visibles pour le guichet et
    # suivi
    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    Depuis le contexte du dossier d'instruction  ${libelle_di}
    # Vérifie l'action modifier pour le guichet et suivi
    Portlet Action Should Not Be In Form  dossier_instruction  modifier
    # Vérifie l'action de régénérer le récépissé pour le guichet et suivi
    Portlet Action Should Not Be In Form  dossier_instruction  recepisse

    # On vérifie aussi pour l'instructeur commune que les actions modifier et
    # régénérer le récépissé soient indisponibles
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    Depuis le contexte du dossier d'instruction  ${libelle_di}
    # Vérifie l'action modifier pour le guichet et suivi
    Portlet Action Should Not Be In Form  dossier_instruction  modifier
    # Vérifie l'action de régénérer le récépissé pour le guichet et suivi
    Portlet Action Should Not Be In Form  dossier_instruction  recepisse

    #
    Depuis la page d'accueil  admin  admin
    #
    Supprimer l'affectation depuis le menu  Poly (H)


TNR Modification des paramètres de la variable de remplacement &contrainte

    [Documentation]  Vérifie que les 3 paramètres de &contrainte liste_groupe,
    ...  liste_ssgroupe, affichage_sans_arborescence modifient l'affichage des
    ...  contraintes sans erreurs.

    # Le contenu de la nouvelle lettre-type de test, avec &contraintes sans paramètres
    &{args_lettretype} =  Create Dictionary
    ...  id=test_contraintes
    ...  libelle=Test des nouveaux paramètres &CONTRAINTES
    ...  sql=Aucune REQUÊTE
    ...  titre=&contraintes
    ...  corps=&contraintes
    ...  actif=true
    ...  collectivite=MARSEILLE

    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  lettretype=test_contraintes Test des nouveaux paramètres &CONTRAINTES

    Depuis la page d'accueil  admin  admin
    Ajouter la lettre-type depuis le menu  &{args_lettretype}
    # On change la lettre-type de l'événement de création d'une nouvelle demande, en
    # définissant notre nouvelle lettre-type comme modèle
    Modifier l'événement  ${args_evenement}
    ${id_contrainte1} =  Ajouter la contrainte depuis le menu  Contrainte TNR instruction 1  PLU  MARSEILLE  TNR instr  sousgroupe  1ère contrainte instr
    ${id_contrainte2} =  Ajouter la contrainte depuis le menu  Contrainte TNR instruction 2  PLU  MARSEILLE  TNR instr  sousgroupe  2ème contrainte instr
    ${id_contrainte3} =  Ajouter la contrainte depuis le menu  Contrainte TNR instruction 3  PLU  MARSEILLE  TNR instr2  null  3ème contrainte instr2

    # Création d'une nouvelle demande pour notre test
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Saville
    ...  particulier_prenom=Lazure
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${libelle_di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout de contraintes à notre dossier de test
    Depuis la page d'accueil  instr  instr
    @{contraintes_a_selectionner} =  Create List  ${id_contrainte_1}  ${id_contrainte_2}  ${id_contrainte3}
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${libelle_di}  ${contraintes_a_selectionner}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TNR instruction 1
    Page Should Contain  TNR instruction 2
    Page Should Contain  TNR instruction 3

    # On régénère l'édition
    Depuis l'instruction du dossier d'instruction  ${libelle_di}  Notification du delai legal maison individuelle
    Click On SubForm Portlet Action  instruction  definaliser
    Click On SubForm Portlet Action  instruction  finaliser
    Click On SubForm Portlet Action  instruction  edition  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie que la lettre-type contient toutes les contraintes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TNR INSTR
    Page Should Contain  SOUSGROUPE
    Page Should Contain  1ère contrainte instr
    Page Should Contain  2ème contrainte instr
    Page Should Contain  TNR INSTR2
    Page Should Contain  3ème contrainte instr2
    Close PDF

    # On ajoute le paramètre liste_groupe à la variable &contraintes dans la lettre-type
    &{args_lettretype} =  Create Dictionary
    ...  id=test_contraintes
    ...  libelle=Test des nouveaux paramètres &CONTRAINTES
    ...  sql=Aucune REQUÊTE
    ...  titre=&contraintes(liste_groupe=TNR INSTR)
    ...  corps=&contraintes(liste_groupe=TNR INSTR)
    ...  actif=true
    ...  collectivite=MARSEILLE

    Depuis la page d'accueil  admin  admin
    # Redéfinit la lettre-type avec les arguments passés
    Modifier la lettre-type  &{args_lettretype}

    # On régénère l'édition
    Depuis l'instruction du dossier d'instruction  ${libelle_di}  Notification du delai legal maison individuelle
    Click On SubForm Portlet Action  instruction  definaliser
    Click On SubForm Portlet Action  instruction  finaliser
    Click On SubForm Portlet Action  instruction  edition  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On doit avoir seulement les contraintes du groupe Zones du PLU
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TNR INSTR
    Page Should Contain  1ère contrainte instr
    Page Should Contain  2ème contrainte instr
    Page Should Not Contain  TNR INSTR2
    Page Should Not Contain  3ème contrainte instr2
    Close PDF

    # On active l'affichage sans arborescence, avec les paramètres liste_groupe et
    # listess_groupe activés
    &{args_lettretype} =  Create Dictionary
    ...  id=test_contraintes
    ...  libelle=Test des nouveaux paramètres &CONTRAINTES
    ...  sql=Aucune REQUÊTE
    ...  titre=&contraintes(liste_groupe=TNR INSTR;liste_ssgroupe=sousgroupe;affichage_sans_arborescence=t)
    ...  corps=&contraintes(liste_groupe=TNR INSTR;liste_ssgroupe=sousgroupe;affichage_sans_arborescence=t)
    ...  actif=true
    ...  collectivite=MARSEILLE

    # Redéfinit la lettre-type avec les arguments passés
    Modifier la lettre-type  &{args_lettretype}

    # On régénère l'édition
    Depuis l'instruction du dossier d'instruction  ${libelle_di}  Notification du delai legal maison individuelle
    Click On SubForm Portlet Action  instruction  definaliser
    Click On SubForm Portlet Action  instruction  finaliser
    Click On SubForm Portlet Action  instruction  edition  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # Le PDF doit contenir les 2 contraintes "Zones du PLU", sans groupes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  1ère contrainte instr
    Page Should Contain  2ème contrainte instr
    Page Should Not Contain  TNR INSTR
    Page Should Not Contain  TNR INSTR2
    Page Should Not Contain  3ème contrainte instr2
    Close PDF

    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  lettretype=recepisse_1 RECEPISSE DE DEPOT

    # On remet la lettre-type de récépissé de dépôt initiale pour les tests suivants
    Modifier l'événement  ${args_evenement}


Les dossiers liés

    [Documentation]  Vérifie l'onglet "Dossiers liés" des dossiers
    ...  d'instruction. Celui-ci doit être composé de 4 tableaux, un pour le
    ...  dossier d'autorisation lié, le deuxième pour les dossiers d'instruction
    ...  liés manuellement ou implicitement, le 3ème listant les dossiers ayant
    ...  un lien pointant sur le dossier courant et le dernier pour les dossiers
    ...  d'autorisation liés géographiquement.

    &{args_petitionnaire_autre_commune} =  Create Dictionary
    ...  particulier_nom=Beauchamps
    ...  particulier_prenom=Maurissette
    ...  om_collectivite=ALLAUCH

    @{ref_cad_autre_commune} =  Create List  806  AB  0025

    &{args_demande_autre_commune} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad_autre_commune}
    ...  om_collectivite=ALLAUCH
    ${libelle_di_autre_commune} =  Ajouter la demande par WS  ${args_demande_autre_commune}  ${args_petitionnaire_autre_commune}

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
    ${libelle_di_spaceless} =  Sans espace  ${libelle_di}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Forest
    ...  particulier_prenom=David
    ...  om_collectivite=MARSEILLE

    @{ref_cad} =  Create List  806  AB  0001  A  0050

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE

    ${libelle_di2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    ${libelle_di2_spaceless} =  Sans espace  ${libelle_di2}
    ${libelle_da} =  Get Substring  ${libelle_di}  0  -2
    ${libelle_da_spaceless} =  Sans espace  ${libelle_da}
    ${libelle_da2} =  Get Substring  ${libelle_di2}  0  -2
    ${libelle_da_autre_commune} =  Get Substring  ${libelle_di_autre_commune}  0  -2
    ${libelle_di_autre_commune_spaceless} =  Sans espace  ${libelle_di_autre_commune}

    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${libelle_di}  accepter un dossier sans réserve

    # On vérifie que le signataire apparait bien dans la colonne du listing des dossiers d'instructions
    Click On Back Button In SubForm
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#formulaire table.tab-tab tbody  admin (Administrateur)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#formulaire table.tab-tab tbody  instr (Louis Laurent)

    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification

    Depuis la page d'accueil  guichet  guichet
    ${libelle_di_modification} =  Ajouter la demande sur existant depuis le tableau de bord  ${libelle_di}  ${args_demande}
    ${libelle_di_modification_spaceless} =  Sans espace  ${libelle_di_modification}


    Depuis la page d'accueil  admin  admin
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label    dossier_autorisation_type_detaille    Recours contentieux
    Select From List By Label    om_collectivite    MARSEILLE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    autorisation_contestee    ${libelle_di}
    Click Button    css=#autorisation_contestee_search_button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain    css=#petitionnaire_principal_delegataire    Beauchamps Jeanette
    Sleep  1
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    ${libelle_di_re} =  Get Text  id=new_di
    ${libelle_di_re_spaceless} =  Sans espace  ${libelle_di_re}

    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label    dossier_autorisation_type_detaille    Recours contentieux
    Select From List By Label    om_collectivite    MARSEILLE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    autorisation_contestee    ${libelle_di2}
    Click Button    css=#autorisation_contestee_search_button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain    css=#petitionnaire_principal_delegataire    Forest David
    Sleep  1
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    ${libelle_di_re2} =  Get Text  id=new_di
    ${libelle_di_re_2spaceless} =  Sans espace  ${libelle_di_re2}

    # Vérification de la notification sur l'autorisation contestée
    Depuis l'onglet des messages du dossier d'instruction  ${libelle_di}
    Click On Link  Autorisation contestée
    Element Text Should Be  contenu  Cette autorisation a été contestée par le recours ${libelle_di_re_spaceless}.

    ##
    ## Le dossier d'autorisation lié
    ##

    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di}

    Element Should Contain X Times  sousform-dossier_autorisation  ${libelle_da}  1

    ##
    ## Les dossiers d'instruction liés
    ##

    # En premier lieu on vérifie que le dossier courant n'apparaît pas dans la liste
    Element Should Not Contain  sousform-dossier_lies  ${libelle_di}

    #
    # Ajout de liens : vérification des cas de succès
    #
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_modification}
    # Si utilisateur multi on peut lier le DI d'une autre collectivité
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di_autre_commune}
    Click On Submit Button In SubForm
    Valid Message Should Contain In Subform  Le dossier ${libelle_di_autre_commune_spaceless} a été lié.
    # Vérification de la redirection vers le DI cible
    Click On Link  link_dossier_instruction_lie
    Page Title Should Be    Instruction > Dossiers D'instruction > ${libelle_di_autre_commune} BEAUCHAMPS MAURISSETTE
    # Vérification de la présence du nouveau lien si utilisateur multi
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_modification}
    Element Should Contain  sousform-dossier_lies  ${libelle_di_autre_commune}
    # Vérification de l'absence du nouveau lien si utilisateur mono
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_modification}
    Element Should Not Contain  sousform-dossier_lies  ${libelle_di_autre_commune}

    # Si utilisateur mono on peut lier le DI de la même collectivité
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di2}
    Click On Submit Button In SubForm
    Valid Message Should Contain In Subform  Le dossier ${libelle_di2_spaceless} a été lié.
    # Vérification de la redirection vers le DI cible
    Click On Link  link_dossier_instruction_lie
    Page Title Should Be    Instruction > Dossiers D'instruction > ${libelle_di2} FOREST DAVID
    # Vérification de l'absence de lien (pour rappel il est directionnel)
    On clique sur l'onglet  lien_dossier_dossier  Dossiers Liés
    Element Should Contain  sousform-dossier_lies  Aucun enregistrement.
    # Pour la même raison on peut ajouter le DI source sur le DI cible
    # ainsi les DI seront liés dans chacun des deux sens
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di_modification_spaceless}
    Click On Submit Button In SubForm
    Valid Message Should Contain In Subform  Le dossier ${libelle_di_modification_spaceless} a été lié.
    Click On Back Button In SubForm
    Element Should Contain  sousform-dossier_lies  ${libelle_di_modification}

    # Ajout d'une liaison manuelle vers le dossier recours qui conteste le dossier courant
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di2}
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di_re2}
    Click On Submit Button In SubForm
    Valid Message Should Contain In Subform  Le dossier ${libelle_di_re2_spaceless} a été lié.
    Click On Back Button In SubForm
    Element Should Contain  sousform-dossier_lies  ${libelle_di_re2}

    # On vérifie que les dossiers auxquels on n'a pas accès sont visibles mais
    # que leur consultation produit une erreur de droits insuffisants
    Depuis la page d'accueil  visudadi  visudadi
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di2}
    Element Should Contain  sousform-dossier_lies  ${libelle_di_modification}
    Element Should Contain  sousform-dossier_lies  ${libelle_di_re2}
    Click Link  ${libelle_di_re2}
    Error Message Should Contain  Droits insuffisants

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di2}
    Element Should Contain  sousform-dossier_lies_retour  ${libelle_di_modification}
    Element Should Contain  sousform-dossier_lies_retour  ${libelle_di_re2}
    Click Link  ${libelle_di_re2}
    Error Message Should Contain  Droits insuffisants

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di2}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_da}
    Element Should Contain  sousform-dossier_lies_geographiquement  ${libelle_di_re2}
    Click Link  ${libelle_di_re2}
    Error Message Should Contain  Droits insuffisants

    #
    # Ajout de liens : vérification des cas d'échec
    #

    # On ne peut pas ajouter de liaison si lien automatique existant
    Depuis la page d'accueil  juriste  juriste
    Depuis l'onglet Dossiers Liés du dossier recours  ${libelle_di_re}
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di}
    Click On Submit Button In Subform Until Message  Le dossier ${libelle_di_spaceless} est déjà lié au dossier courant (lien automatique).
    Error Message Should Be In Subform  Le dossier ${libelle_di_spaceless} est déjà lié au dossier courant (lien automatique).

    # Le dossier cible est un champ obligatoire
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_modification}
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Click On Submit Button In Subform Until Message  Le champ dossier cible est obligatoire
    Error Message Should Be In Subform  Le champ dossier cible est obligatoire
    # Le dossier cible peut ne pas exister tout court...
    ${ac_fail} =  Set Variable  '*#(('';;'
    ${ac_fail_escaped} =  Set Variable  ''*#(('''';;''
    Input Text  dossier_cible  ${ac_fail}
    Click On Submit Button In Subform Until Message  Il n'existe aucun dossier correspondant au numéro ${ac_fail_escaped}. Saisissez un nouveau numéro puis recommencez.
    Error Message Should Be In Subform  Il n'existe aucun dossier correspondant au numéro ${ac_fail_escaped}. Saisissez un nouveau numéro puis recommencez.
    # ... ou ne pas exister parce qu'il est d'une collectivité différente de l'utilisateur mno
    Click On Back Button In SubForm
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di_autre_commune}
    Click On Submit Button In Subform Until Message  Il n'existe aucun dossier correspondant au numéro ${libelle_di_autre_commune_spaceless}. Saisissez un nouveau numéro puis recommencez.
    Error Message Should Be In Subform  Il n'existe aucun dossier correspondant au numéro ${libelle_di_autre_commune_spaceless}. Saisissez un nouveau numéro puis recommencez.
    # On ne peut pas lier un DI à lui-même
    Input Text  dossier_cible  ${libelle_di_modification}
    Click On Submit Button In Subform Until Message  Vous ne pouvez pas lier un dossier à lui-même. Saisissez un nouveau numéro puis recommencez.
    Error Message Should Be In Subform  Vous ne pouvez pas lier un dossier à lui-même. Saisissez un nouveau numéro puis recommencez.
    # On ne peut pas ajouter de liaison si lien implicite par le DA
    Click On Back Button In SubForm
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di_spaceless}
    Click On Submit Button In Subform Until Message  Le dossier ${libelle_di_spaceless} est déjà lié au dossier courant (même dossier d'autorisation).    # On ne peut pas ajouter de liaison si lien manuel existant
    Error Message Should Be In Subform  Le dossier ${libelle_di_spaceless} est déjà lié au dossier courant (même dossier d'autorisation).    # On ne peut pas ajouter de liaison si lien manuel existant
    Click On Back Button In SubForm
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di2_spaceless}
    Click On Submit Button In Subform Until Message  Le dossier ${libelle_di2_spaceless} est déjà lié au dossier courant.
    Error Message Should Be In Subform  Le dossier ${libelle_di2_spaceless} est déjà lié au dossier courant.

    #
    # Suppression de liens : vérification des cas de succès
    #

    # On peut supprimer un lien créé manuellement
    Click On Back Button In SubForm
    Page Should Contain  ${libelle_di2}
    Click Element  action-soustab-dossier_lies-left-supprimer-${libelle_di2_spaceless}
    Valid Message Should Be In Subtab  Le dossier ${libelle_di2_spaceless} a été délié.
    Element Should Not Contain  sousform-dossier_lies  ${libelle_di2}

    #
    # Suppression de liens : vérification des cas d'échec
    #

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di}

    # On ne peut pas supprimer un lien implicite (même DA)
    Element Should Be Visible  action-soustab-dossier_lies-left-consulter-${libelle_da_spaceless}M01
    Element Should Not Be Visible  action-soustab-dossier_lies-left-supprimer-${libelle_da_spaceless}M01
    # On ne peut pas supprimer les liens automatiques si on n'est pas administrateur
    Depuis la page d'accueil  juriste  juriste
    Depuis l'onglet Dossiers Liés du dossier recours  ${libelle_di_re}
    Element Should Be Visible  action-soustab-dossier_lies-left-consulter-${libelle_di_spaceless}
    Element Should Not Be Visible  action-soustab-dossier_lies-left-supprimer-${libelle_di_spaceless}
    # On peut supprimer les liens automatiques si on est administrateur
    Depuis la page d'accueil  admin  admin
    Depuis l'onglet Dossiers Liés du dossier recours  ${libelle_di_re}
    Element Should Be Visible  action-soustab-dossier_lies-left-supprimer-${libelle_di_spaceless}

    ##
    ## Les dossiers d'autorisation liés géographiquement
    ##

    # Ajoute 2 nouvelles demandes avec une parcelle en commun,
    # puis affiche le tableau des dossiers liés géographiquement pour les 2
    # dossiers.
    # L'autre DA avec la même parcelle doit être présent, mais pas le DA lié
    # au DI courant.
    # On ajoute un troisième dossier avec les mêmes parcelles sur une autre
    # commune qui ne doit pas apparaitre dans la liste

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di}
    # Le tableau des dossiers liés géographiquement ne doit pas contenir le DA lié au DI courant
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_da}
    # Le 2ème dossier avec la même parcelle doit apparaître
    Element Should Contain X Times  sousform-dossier_lies_geographiquement  ${libelle_da2}  1

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di2}
    # Le tableau doit contenir une seule fois le DA qui a 2 DI avec une parcelle en commun
    Element Should Contain X Times  sousform-dossier_lies_geographiquement  ${libelle_da}  1
    # Le tableau des dossiers liés géographiquement ne doit pas contenir le DA lié au DI courant
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_da2}
    # Le tableau des dossiers liés géographiquement ne doit pas contenir le DI d'une autre commune
    Element Should Not Contain  sousform-dossier_lies_geographiquement  ${libelle_da_autre_commune}


Restriction d'événement
    [Documentation]  Teste une double condition dans la restriction :
    ...  date événement <= date limite de notification au pétitionnaire
    ...  date de dépôt == date de complétude

    ${date_valid} =  Set Variable  01/01/2015
    ${date_invalid} =  Set Variable  01/04/2016

    #
    # Cas 1 : opérateur logique || sur P0
    # La condition est satisfaite
    #

    # Création du DI sur lequel nous allons faire l'incomplétude
    &{case1_evenement} =  Create Dictionary
    ...  libelle=Notification de pieces manquante
    ...  restriction=date_evenement <= archive_date_notification_delai || archive_date_complet == date_depot
     &{case1_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Déziel
    ...  particulier_prenom=Audrey
    ...  om_collectivite=MARSEILLE
    &{case1_demande} =  Create Dictionary
    ...  date_demande=${date_valid}
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    Depuis la page d'accueil  admin  admin
    # On récupère la restriction avant de la modifier
    Depuis le contexte de l'événement  Notification de pieces manquante
    ${restriction_before} =  Get Text  css=#restriction
    #
    Modifier l'événement  ${case1_evenement}
    #
    ${case1_di} =  Ajouter la demande par WS
    ...  ${case1_demande}
    ...  ${case1_petitionnaire}
    # Vu le || la condition est satisfaite
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${case1_di}  Notification de pieces manquante  ${date_invalid}
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.

    #
    # Cas 2 : opérateur logique && sur DOC01
    # La condition n'est pas satisfaite
    #

    # Création du DI sur lequel nous allons faire l'incomplétude
    &{case2_evenement} =  Create Dictionary
    ...  libelle=Notification de pieces manquante
    ...  restriction=date_evenement <= archive_date_notification_delai && archive_date_complet == date_depot
    #
    &{case2_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Bourgeau
    ...  particulier_prenom=Corinne
    ...  om_collectivite=MARSEILLE
    &{case2_demande_temp} =  Create Dictionary
    ...  date_demande=${date_valid}
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{case2_demande} =  Create Dictionary
    ...  date_demande=${date_valid}
    ...  demande_type=Demande d'ouverture de chantier
    #
    Depuis la page d'accueil  admin  admin
    Modifier l'événement  ${case2_evenement}
    #
    ${case2_di_temp} =  Ajouter la demande par WS
    ...  ${case2_demande_temp}
    ...  ${case2_petitionnaire}
    #
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${case2_di_temp}  accepter un dossier sans réserve  ${date_valid}
    #
    Depuis la page d'accueil  guichet  guichet
    ${case2_di} =  Ajouter la demande sur existant
    ...  ${case2_di_temp}
    ...  ${case2_demande}
    # Vu le && la condition est non satisfaite
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet instruction du dossier d'instruction  ${case2_di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Saisir instruction  Notification de pieces manquante  ${date_invalid}
    Click On Submit Button In Subform Until Message  SAISIE NON ENREGISTRÉE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div.ui-state-error p span.text  SAISIE NON ENREGISTRÉE
    Element Should Contain  css=div.ui-state-error p span.text  date d'événement <= date limite de notification au pétitionnaire && date de complétude archivé == date de dépôt

    #
    # Restauration de la restriction
    #
    &{old_evenement} =  Create Dictionary
    ...  libelle=Notification de pieces manquante
    ...  restriction=${restriction_before}
    Depuis la page d'accueil  admin  admin
    Modifier l'événement  ${old_evenement}


TNR Vérifie que le fichier est supprimé à la suppression de l'instruction

    [Documentation]  Vérifie dans le filestorage si le fichier de l'édition de
    ...  l'instruction est correctement supprimé lors de la suppression de
    ...  l'instruction.


    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Batard
    ...  particulier_prenom=Laurene
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve
    #
    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    # On clique sur l'action de finalisation
    Click On SubForm Portlet Action  instruction  finaliser
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La finalisation du document s'est effectuée avec succès.
    # Récupération de l'UID
    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    ${uid} =  Get Value  om_fichier_instruction
    ${path_1} =  Get Substring  ${uid}  0  2
    ${path_2} =  Get Substring  ${uid}  0  4
    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}
    File Should Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info
    #
    Depuis la page d'accueil  admin  admin
    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    # On clique sur l'action de définalisation
    Click On SubForm Portlet Action  instruction  definaliser
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La définalisation du document s'est effectuée avec succès.
    #
    Supprimer l'instruction  ${di}  accepter un dossier sans réserve
    # Vérification dans le filestorage
    File Should Not Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}
    File Should Not Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info

Mail aux communes
    [Documentation]  Test de l'action sur l'instruction permettant à l'instructeur,
    ...  une fois son courrier finalisé, de déclencher l'envoi d'un mail aux communes.

    # Création du DI
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Gareau
    ...  particulier_prenom=Élisabeth
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Création de l'instruction finalisée
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  Notification de pieces manquante
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click On Link  Notification de pieces manquante
    Click On SubForm Portlet Action  instruction  finaliser
    # Saisie du paramétrage commune en sus du multi par fourni par défaut
    Depuis la page d'accueil  admingen  admingen
    Ajouter le paramètre depuis le menu  param_courriel_de_notification_commune  support@atreal.fr  MARSEILLE
    # Paramétrage de l'url pour les liens
    &{om_param} =  Create Dictionary
    ...  libelle=parametre_notification_url_acces
    ...  valeur=http://localhost/openads/
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    # Succès de la notification
    Depuis l'instruction du dossier d'instruction  ${di}  Notification de pieces manquante
    Click On SubForm Portlet Action  instruction  notifier_commune  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La commune a été notifiée.
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    # Suivi de notification
    Element Should Contain  css=td[data-column-id="émetteur"]      admingen
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  support@atreal.fr
    Element Should Contain  css=td[data-column-id="instruction"]   Notification de pieces manquante
    Element Should Contain  css=td[data-column-id="statut"]        envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]   Le mail de notification a été envoyé    
    #Verification si possibilité de suppression d'instruction
    Click On SubForm Portlet Action  instruction  definaliser
    Supprimer l'instruction  ${di}  Notification de pieces manquante
    Wait Until Element Is Visible  css=.message.ui-widget.ui-corner-all.ui-state-highlight.ui-state-valid
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${di}  Notification de pieces manquante
    # Échec de la notification si objet, modèle ou courriel indéfini
    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  param_courriel_de_notification_commune_objet_depuis_instruction  ${SPACE}
    Modifier le paramètre  param_courriel_de_notification_commune_modele_depuis_instruction  ${SPACE}
    Modifier le paramètre  param_courriel_de_notification_commune  ${SPACE}
    Depuis l'instruction du dossier d'instruction  ${di}  Notification de pieces manquante
    Click On SubForm Portlet Action  instruction  notifier_commune  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Error Message Should Contain In Subform  l'objet du courriel envoyé aux communes est vide
    Error Message Should Contain In Subform  le modèle du courriel envoyé aux communes est vide
    Error Message Should Contain In Subform  aucun courriel valide de destinataire de la commune

    # Réinitialisation du paramétrage
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=parametre_notification_url_acces
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${param_values}

Mail automatique de notification de dépôt de dossier dématérialisé
    [Documentation]  Test de l'envoi d'un mail de notification lors du dépôt de dossier via
    ...  plat'AU et ide'AU si l'option option_notification_depot_demat est active.

    # Paramétrage et activation de la notification
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=param_courriel_de_notification_depot_demat_titre
    ...  valeur=Notification de depot de dossier dematerialise : [DOSSIER]
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=param_courriel_de_notification_depot_demat_message
    ...  valeur=Un nouveau dossier viens d'etre depose. Pour y acceder cliquer sur ce lien : [URL_DOSSIER]
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=param_courriel_de_notification_commune
    ...  valeur=support@atreal.fr\nsupport2@atreal.fr
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=option_notification_depot_demat
    ...  valeur=true
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    &{om_param} =  Create Dictionary
    ...  libelle=parametre_notification_url_acces
    ...  valeur=http://localhost/openads/
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    # Simulation du dépôt d'une demande via plat'AU
    &{args_dossier} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_localite=TestNotifAdresseLocalite
    ...  depot_electronique=true
    ...  source_depot=platau
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TestNotifDepotDematNom
    ...  particulier_prenom=TestNotifDepotDematPrenom
    ...  localite=TestNotifLocalite
    ...  om_collectivite=MARSEILLE
    ${di_platau} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire}
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    # Vérification de la reception du mail
    Verifier que le mail a bien été envoyé au destinataire  support@atreal.fr
    Vérifier le contenu du mail  support@atreal.fr  Un nouveau dossier viens d'etre depose. Pour y acceder cliquer sur ce lien : 

    # Vérification du suivi
    Depuis la page d'accueil  instr  instr
    Depuis l'instruction du dossier d'instruction  ${di_platau}  Notification du delai legal maison individuelle
    Element Should Contain  css=td[data-column-id="émetteur"]      (automatique)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=div#suivi_notification_commune_jsontotab tbody  support2@atreal.fr
    Element Should Contain  css=div#suivi_notification_commune_jsontotab tbody  support@atreal.fr
    Element Should Contain  css=td[data-column-id="instruction"]   Notification du delai legal maison individuelle
    Element Should Contain  css=td[data-column-id="statut"]        envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]   Le mail de notification a été envoyé

    # Simulation du dépôt d'une demande via ide'AU
    &{args_dossier} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  source_depot=portal
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TestNotifDepotDematNom2
    ...  particulier_prenom=TestNotifDepotDematPrenom2
    ...  om_collectivite=MARSEILLE
    ${di_portal} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    # Vérification de la reception du mail
    Verifier que le mail a bien été envoyé au destinataire  support2@atreal.fr
    Vérifier le contenu du mail  support2@atreal.fr  Un nouveau dossier viens d'etre depose. Pour y acceder cliquer sur ce lien :

    # Vérification du suivi
    Depuis la page d'accueil  instr  instr
    Depuis l'instruction du dossier d'instruction  ${di_portal}  Notification du delai legal maison individuelle
    Element Should Contain  css=td[data-column-id="émetteur"]      (automatique)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=div#suivi_notification_commune_jsontotab tbody  support2@atreal.fr
    Element Should Contain  css=div#suivi_notification_commune_jsontotab tbody  support@atreal.fr
    Element Should Contain  css=td[data-column-id="instruction"]   Notification du delai legal maison individuelle
    Element Should Contain  css=td[data-column-id="statut"]        envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]   Le mail de notification a été envoyé

    # Test le suivi en cas d'erreur de notification
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=param_courriel_de_notification_commune
    ...  valeur=support.atreal.bug
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=MARSEILLE
    ...  depot_electronique=true
    ...  source_depot=portal
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TestNotifDepotDematNom2
    ...  particulier_prenom=TestNotifDepotDematPrenom2
    ...  localite=MARSEILLE
    ...  om_collectivite=MARSEILLE
    ${di_bug} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y

    Depuis la page d'accueil  instr  instr
    Depuis l'instruction du dossier d'instruction  ${di_bug}  Notification du delai legal maison individuelle
    Element Should Contain  css=td[data-column-id="émetteur"]      (automatique)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  support.atreal.bug
    Element Should Contain  css=td[data-column-id="instruction"]   Notification du delai legal maison individuelle
    Element Should Contain  css=td[data-column-id="statut"]        Echec
    Element Should Contain  css=td[data-column-id="commentaire"]   Mail non envoyé

    # Remise à l'état initial du paramétrage
    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=param_courriel_de_notification_depot_demat_titre
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${param_values}
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=param_courriel_de_notification_depot_demat_message
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${param_values}
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=param_courriel_de_notification_commune
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${param_values}
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification_depot_demat
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${param_values}
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=parametre_notification_url_acces
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${param_values}

Dossier sans suffixe

    [Documentation]  Teste le workflow des DI lorsque l'initial n'a pas le suffixe P0

    ${date_jour} =  Date du jour FR

    # Désactivation du suffixe pour les PCI initiaux
    Depuis la page d'accueil  admin  admin
    Depuis le listing  dossier_instruction_type
    Use Simple Search  type de dossier d'autorisation détaillé  PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    Click On Link  Initial
    Click On Form Portlet Action  dossier_instruction_type  modifier
    Unselect Checkbox  suffixe
    Click On Submit Button

    # Nouveau DI initial sans le suffixe P0
        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Netton
    ...  particulier_prenom=Valérie
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Should Not Contain  ${di}  P0

    # Nouveau dossier sur existant
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve  false  ${date_jour}
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di}
    ${di_M01} =  Ajouter la demande par WS  ${args_demande}
    Should Contain  ${di_M01}  M01

    # Nouvel événement d'instruction sans création de dossier
    Ajouter une instruction au DI et la finaliser  ${di_M01}  Notification de pieces manquante  false  ${date_jour}
    Depuis la page d'accueil  guichet  guichet
    &{args_demande} =  Create Dictionary
    ...  demande_type=Dépôt de pièces complémentaire
    ...  dossier_instruction=${di_M01}
    Ajouter la demande par WS  ${args_demande}

    # Ré-activation du suffixe pour les PCI initiaux
    Depuis la page d'accueil  admin  admin
    Depuis le listing  dossier_instruction_type
    Use Simple Search  type de dossier d'autorisation détaillé  PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    Click On Link  Initial
    Click On Form Portlet Action  dossier_instruction_type  modifier
    Select Checkbox  suffixe
    Click On Submit Button


Vérification de retour d'instruction
    [Documentation]  Controle des date de retour d'une instruction

    &{args_action} =  Create Dictionary
    ...  action=retour signature
    ...  libelle=retour signature
    ...  regle_etat=etat
    ...  regle_date_validite=date_retour_signature + duree_validite

    @{etat_evenment_dispo} =  Create List  dossier accepter
    @{type_di} =  Create List  PCI - P - Initial

    &{args_evenement_creation} =  Create Dictionary
    ...  libelle=retour signature
    ...  etats_depuis_lequel_l_evenement_est_disponible=@{etat_evenment_dispo}
    ...  retour=true
    ...  dossier_instruction_type=${type_di}
    ...  action=retour signature
    ...  lettretype=arrete ARRETE

    &{args_evenement_modification} =  Create Dictionary
    ...  libelle=accepter un dossier sans réserve
    ...  evenement_retour_signature=retour signature

    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  duree_validite_parametrage=12

    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
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
    ...  om_collectivite=agglo

    &{args_demande} =  Create Dictionary
    ...  om_collectivite=agglo
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial

    ${date_retour_signature} =  Date du jour FR
    ${date_retour_signature} =  Add Time To Date  ${date_retour_signature}  5 days  %d/%m/%Y  True  %d/%m/%Y
    ${dd} =  Convert Date  ${date_retour_signature}  %d  True  %d/%m/%Y
    ${mm} =  Convert Date  ${date_retour_signature}  %m  True  %d/%m/%Y
    ${yyyy} =  Convert Date  ${date_retour_signature}  %Y  True  %d/%m/%Y
    ${yyyy} =  Evaluate  ${yyyy}+1
    ${date_validite} =  Catenate  SEPARATOR=/  ${dd}  ${mm}  ${yyyy}
    # On créer une action et un evenement d'instruction retour de signature
    Depuis la page d'accueil  admin  admin
    Ajouter l'action depuis le menu  ${args_action}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Ajouter l'événement depuis le menu  ${args_evenement_creation}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Modifier l'événement  ${args_evenement_modification}
    Depuis le listing  dossier_autorisation_type_detaille
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On Créé un DI avec une instruction retour de signature
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${code_barres} =  Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve  false  null  null  Albert Dupont

    Go To Submenu In Menu  suivi  suivi_mise_a_jour_des_dates
    Select From List By Label  css=#type_mise_a_jour  date de retour de signature + Envoi contrôle légalite
    Input Text  date  ${date_retour_signature}
    Input Text  code_barres  ${code_barres}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#dossier_libelle  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#evenement  accepter un dossier sans réserve
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#suivi_mise_a_jour_des_dates_form div.formControls input.om-button

    Depuis le contexte du dossier d'instruction  ${di}
    Wait Until Element Contains  css=#date_validite  ${date_validite}
    On clique sur l'onglet  instruction  Instruction
    Click On Link  retour signature
    Wait Until Element Contains  css=#date_retour_signature  ${date_retour_signature}


Suppression evenement demande
    [Documentation]  Teste la suppression d'un événement d'instruction lié à une demande qui ne
    ...  crée pas de nouveau dossier d'instruction

    # Création du type de demande pour le DI
    @{etats_autorises} =  Create List  delai de notification envoye
    &{args_demande_type} =  Create Dictionary
    ...  code=test_09_suppression
    ...  libelle=test_09_suppression
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=${etats_autorises}
    ...  contraintes=Récupération des demandeurs avec modification et ajout
    ...  evenement=Defrichement soumis a enquete publique
    Depuis la page d'accueil  admin  admin
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}

    # Création du DI initial
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Cartier
    ...  particulier_prenom=Aurélie
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_spaceless} =  Sans espace  ${di}

    # Ajout de la demande sur le DI initial
    &{args_demande_modification} =  Create Dictionary
    ...  demande_type=test_09_suppression
    Depuis la page d'accueil  guichet  guichet
    Ajouter la demande sur dossier en cours sans création de dossier  ${di}  ${args_demande_modification}

    # Suppression de l'événement d'instruction issu de la demande
    Depuis la page d'accueil  admin  admin
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Click On Link  Defrichement soumis a enquete publique
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  instruction  definaliser
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  instruction  supprimer
    Click On Submit Button In Subform
    Valid Message Should Contain  La suppression a été correctement effectuée.


Copie des donnees DA vers nouveau DI
    [Documentation]  Ce test case vérifie que les données du dossier d'autorisation sont
    ...  recopiés dans les champs 'archive_' de l'événement d'instruction de la création
    ...  du nouveau dossier d'instruction.

    &{args_action} =  Create Dictionary
    ...  action=test_12_recopie_donnees
    ...  libelle=test_12_recopie_donnees
    ...  regle_date_validite=archive_date_validite+12

    @{etat_evenement_dispo} =  Create List  dossier accepter
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement_creation} =  Create Dictionary
    ...  libelle=test_12_recopie_donnees
    ...  etats_depuis_lequel_l_evenement_est_disponible=@{etat_evenement_dispo}
    ...  dossier_instruction_type=${type_di}
    ...  action=test_12_recopie_donnees

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=test recopie
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    &{args_type_instr} =  Create Dictionary
    ...  code=DT
    ...  libelle=test_12_recopie_donnees
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  suffixe=true

    @{etats_autorises} =  Create List  dossier accepter
    &{args_type} =  Create Dictionary
    ...  code=test_12_recopie_donnees
    ...  libelle=test_12_recopie_donnees
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=${etats_autorises}
    ...  dossier_instruction_type=PCI - test_12_recopie_donnees
    ...  evenement=test_12_recopie_donnees

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve
    Depuis le contexte du dossier d'instruction  ${di}
    Wait Until Element Contains  css=#avis_decision  Favorable

    Depuis la page d'accueil  admin  admin
    Ajouter l'action depuis le menu  ${args_action}
    Ajouter l'événement depuis le menu  ${args_evenement_creation}
    Ajouter type de dossier d'instruction  ${args_type_instr}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Ajouter un nouveau type de demande depuis le menu  ${args_type}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button

    &{args_demande_modification} =  Create Dictionary
    ...  demande_type=test_12_recopie_donnees

    Depuis la page d'accueil  guichet  guichet

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=test validité
    ${di} =  Ajouter la demande sur dossier en cours depuis le menu  ${di}  ${args_demande_modification}  ${args_petitionnaire}

    ${yyyy} =  Get Time  year
    ${mm} =  Get Time  month
    ${dd} =  Get Time  day
    ${yyyy} =  Evaluate  ${yyyy}+1
    ${date_validite} =  Catenate  SEPARATOR=/  ${dd}  ${mm}  ${yyyy}
    Depuis le contexte du dossier d'instruction  ${di}
    Wait Until Element Contains  css=#date_validite  ${date_validite}

Verification numerotation DI successif
    [Documentation]  Vérifie que la numérotation des DI est successive, et que l'option
    ...  suffixe fonctionne.

    &{args_type_instr} =  Create Dictionary
    ...  code=TN
    ...  libelle=Test numérotation
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  suffixe=true

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lafontaine
    ...  particulier_prenom=Isaac
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    @{etats_autorises} =  Create List  dossier accepter
    &{args_type} =  Create Dictionary
    ...  code=TN
    ...  libelle=Test numérotation
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=${etats_autorises}
    ...  dossier_instruction_type=PCI - ${args_type_instr.libelle}
    ...  evenement=Notification du delai legal maison individuelle

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve

    Depuis la page d'accueil  admin  admin
    Ajouter type de dossier d'instruction  ${args_type_instr}
    Valid Message Should Contain  Vos modifications ont bien été enregistrée
    Ajouter un nouveau type de demande depuis le menu  ${args_type}
    Depuis le contexte du type de demande avec libellé unique  ${args_type.libelle}


    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Test nouveau di

    &{args_demande} =  Create Dictionary
    ...  demande_type=${args_type.libelle}
    ...  dossier_instruction=${di}

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_se} =  Sans espace  ${di}
    Should Match Regexp  ${di_se}  (PC)[0-9 ]*(TN01)

