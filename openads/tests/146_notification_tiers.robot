*** Settings ***
Documentation     Notification des demandeurs

# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown

*** Keywords ***
Valider le formulaire de notification
    [Documentation]  Clique sur le bouton de validation du formulaire
    ...  de notification manuelle. Vérifie que la validation a bien été
    ...  enregistré et que la page ne contiens pas d'erreur.
    ...  Récupère et renvoie la date et l'heure de validation du formulaire.

    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Wait Until Page Contains  La notification a été générée.
    La page ne doit pas contenir d'erreur
    [Return]  ${CurrentDate}

*** Test Cases ***
Constitution du jeu de données
    [Documentation]  constitution d'un jeu de données servant à tester le bon fonctionnement
    ...  de la notification des demandeurs

    Depuis la page d'accueil  admin  admin
    # Enregistrement de la date pour la saisie des formulaire
    ${date_courante} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Set Suite Variable  ${date_courante}

    # CONTEXTE
    Set Suite Variable  ${acteur}  notifTiers
    Set Suite Variable  ${collectivite}  LIBRECOM_NOTIFTIERS
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=${collectivite}
    ...  departement=22
    ...  commune=002
    ...  insee=22002
    ...  direction_code=Notif
    ...  direction_libelle=Direction de ${collectivite}
    ...  direction_chef=Chef
    ...  division_code=NotifT
    ...  division_libelle=Division NotifT
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=NotificationTiers Guichet
    ...  guichet_om_utilisateur_email=ntguichet@openads-test.fr
    ...  guichet_om_utilisateur_login=ntguichet
    ...  guichet_om_utilisateur_pwd=ntguichet
    ...  instr_om_utilisateur_nom=NotificationTiers Instr
    ...  instr_om_utilisateur_email=ninstr@openads-test.fr
    ...  instr_om_utilisateur_login=ninstr
    ...  instr_om_utilisateur_pwd=ninstr
    ...  acteur=${acteur}
    Isolation d'un contexte  ${librecom_values}

    # PARAMETRAGE
    # Activation de l'option de paramétrage des tiers pour la collectivité LIBRECOM_NOTIFTIERS
    &{params} =  Create Dictionary
    ...  libelle=option_module_acteur
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${params}
    # Activation de l'option option_dossier_commune et de l'option option_mode_service_consulte
    &{om_param} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    Activer le mode service consulté
    # ajoute le paramètre 'acteur' à la collectivité/au service
    &{om_param} =  Create Dictionary
    ...  libelle=platau_acteur_service_consulte
    ...  valeur=${acteur}
    ...  om_collectivite=${collectivite}
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_PCI
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    # paramètrage du titre et du message de notification
    &{om_param} =  Create Dictionary
    ...  libelle=parametre_courriel_tiers_type_titre
    ...  valeur=[openADS] Notification pour les tiers concernant le dossier (avec un caractère accentué) (avec un caractère accentué) [DOSSIER]
    ...  om_collectivite=${collectivite}
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{om_param} =  Create Dictionary
    ...  libelle=parametre_courriel_tiers_type_message
    ...  valeur=Bonjour les tiers (avec un caractère accentué), veuillez prendre connaissance du(des) document(s) suivant(s) :<br> [LIEN_TELECHARGEMENT_DOCUMENT]<br>[LIEN_TELECHARGEMENT_ANNEXE]
    ...  om_collectivite=${collectivite}
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{om_param} =  Create Dictionary
    ...  libelle=parametre_notification_url_acces
    ...  valeur=http://localhost/openads/
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
   

    # PARAMÉTRAGE NOTIF AUTO
    # On ajoute 2 communes : 1 lié au dossier l'autre non
    Set Suite Variable  ${lib_commune}  NTC
    Set Suite Variable  ${code_commune}  ${librecom_values.commune}
    ${code_dept} =  Set Variable    ${librecom_values.departement}
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=${code_commune}
    ...  reg=20
    ...  dep=${code_dept}
    ...  arr=100
    ...  tncc=0
    ...  ncc=NOTIFATC
    ...  nccenr=NOTIFATC
    ...  libelle=${lib_commune}
    ...  can=20
    ...  om_validite_debut=23/11/2020
    Ajouter commune avec dates validité  ${com_values}
    ${lib_commune_2} =  Set Variable  NTC2
    ${code_commune_2} =  Set Variable  22003
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=${code_commune_2}
    ...  reg=20
    ...  dep=${code_dept}
    ...  arr=200
    ...  tncc=0
    ...  ncc=NOTIFFTC
    ...  nccenr=NOTIFFTC
    ...  libelle=${lib_commune_2}
    ...  can=20
    ...  om_validite_debut=${date_courante}
    Ajouter commune avec dates validité  ${com_values}

    # On ajoute 2 départements
    #  - 1 associé à la commune du dossier
    #  - 1 non associé au dossier
    ${lib_dept} =  Set Variable  Dept NTC
    &{dept_values} =  Create Dictionary
    ...  dep=${code_dept}
    ...  reg=20
    ...  cheflieu=20001
    ...  tncc=0
    ...  ncc=DEPT1
    ...  nccenr=DEPT1NOT
    ...  libelle=${lib_dept}
    ...  om_validite_debut=${date_courante}
    Ajouter département  ${dept_values}
    ${lib_dept_2} =  Set Variable  Dept NTC2
    ${code_dept_2} =  Set Variable  23
    &{dept_values} =  Create Dictionary
    ...  dep=${code_dept_2}
    ...  reg=23
    ...  cheflieu=23000
    ...  tncc=1
    ...  ncc=DEPT2
    ...  nccenr=DEPT2NOT
    ...  libelle=${lib_dept_2}
    ...  om_validite_debut=${date_courante}
    Ajouter département  ${dept_values}

    # CATEGORIES DE TIERS

    ${om_collectivite_tiers} =  Create List  ${librecom_values.om_collectivite_libelle}
    Set Suite Variable  ${cat_tiers}  Categorie test notif tiers
    &{categorie_tiers} =  Create Dictionary
    ...  code=CAT_TEST_NTC
    ...  libelle=${cat_tiers}
    ...  description=Categorie servant pour le test de la notification des tiers consultés.
    ...  om_collectivite=${om_collectivite_tiers}
    ${id_cat_tiers} =  Ajouter la categorie de tiers consulte  ${categorie_tiers}
    Set Suite Variable  ${id_cat_tiers}

    Set Suite Variable  ${cat_tiers_2}  Categorie test acteur
    &{categorie_tiers} =  Create Dictionary
    ...  code=CAT_TEST_ANTC
    ...  libelle=${cat_tiers_2}
    ...  description=Categorie servant pour le test de l'onglet acteur des DI.
    ...  om_collectivite=${om_collectivite_tiers}
    ${id_cat_tiers_2} =  Ajouter la categorie de tiers consulte  ${categorie_tiers}
    Set Suite Variable  ${id_cat_tiers_2}

    Set Suite Variable  ${cat_tiers_3}  Categorie test d'ajout auto acteur
    &{categorie_tiers} =  Create Dictionary
    ...  code=CAT_TEST_NTAM
    ...  libelle=${cat_tiers_3}
    ...  description=Categorie servant pour le test de la notification des tiers consultés.
    ...  om_collectivite=${om_collectivite_tiers}
    ${id_cat_tiers_3} =  Ajouter la categorie de tiers consulte  ${categorie_tiers}
    Set Suite Variable  ${id_cat_tiers_3}

    ${om_collectivite_autre} =  Create List  MARSEILLE
    Set Suite Variable  ${cat_tiers_autre_colle}  Categorie autre collectivite
    &{categorie_tiers} =  Create Dictionary
    ...  code=CAT_TEST_AAC
    ...  libelle=${cat_tiers_autre_colle}
    ...  description=Categorie servant pour le test de l'onglet acteur des DI.
    ...  om_collectivite=${om_collectivite_autre}
    ${id_cat_tiers_autre_colle} =  Ajouter la categorie de tiers consulte  ${categorie_tiers}
    Set Suite Variable  ${id_cat_tiers_autre_colle}

    # TYPES D'HABILITATION DE TIERS
    ${type_habilitation_ok} =  Set Variable  TYPE HAB NOTIFIABLE
    &{type_habilitation_tiers_consulte} =  Create Dictionary
    ...  code=457
    ...  libelle=${type_habilitation_ok}
    ...  om_validite_debut=${date_courante}
    Ajouter un type d'habilitation de tiers consulté  ${type_habilitation_tiers_consulte}
    ${type_habilitation_ko} =  Set Variable  TYPE HAB NON NOTIFIABLE
    &{type_habilitation_tiers_consulte} =  Create Dictionary
    ...  code=456
    ...  libelle=${type_habilitation_ko}
    ...  om_validite_debut=${date_courante}
    Ajouter un type d'habilitation de tiers consulté  ${type_habilitation_tiers_consulte}

    # AJOUT DES TIERS ET DE LEUR HABILITATION

    # 5 Tiers notifiable qui pourront être ajoutés au dossier
    # - 2 associé à une catégorie d'ajout non auto
    # - 1 associé à la commune du dossier
    # - 1 associé à la mauvaise commune mais au bon département
    # - 1 sans habilitation en cours de validité
    # - 1 non lié à une commune ou un département
    @{communes} =  Create List  ${code_commune} - ${lib_commune}
    @{depts} =  Create List  ${code_dept} - ${lib_dept}
    @{autre_communes} =  Create List  ${code_commune_2} - ${lib_commune_2}
    @{autre_depts} =  Create List  ${code_dept_2} - ${lib_dept_2}

    # Associé à une catégorie d'ajout non auto
    Set Suite Variable  ${tiers_autre_cat}  Tiers Autre Catégorie
    Set Suite Variable  ${mail_tiers_autre_cat}  tac@atreal.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers}
    ...  abrege=TAC
    ...  liste_diffusion=${mail_tiers_autre_cat}
    ...  libelle=${tiers_autre_cat}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiers_autre_cat}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  ${depts}  ${communes}

    # Associé à une catégorie d'ajout non auto
    Set Suite Variable  ${tiers_notif_man}  Tiers notifiable manuellement
    Set Suite Variable  ${mail_tiers_notif_man}  tnm@atreal.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_2}
    ...  abrege=TNM
    ...  liste_diffusion=${mail_tiers_notif_man}
    ...  libelle=${tiers_notif_man}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiers_notif_man}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  ${depts}  ${communes}

    # Associé à la commune du dossier
    Set Suite Variable  ${tiers_notif_com}  Tiers notifiable commune
    Set Suite Variable  ${mail_tiers_notif_com}  tnc@atreal.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TNC
    ...  adresse=8 avenue Bouvard
    ...  complement=complement
    ...  cp=74000
    ...  liste_diffusion=${mail_tiers_notif_com}
    ...  libelle=${tiers_notif_com}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    ...  uid_platau_acteur=plop
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiers_notif_com}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  NULL  ${communes}

    # Associé à la mauvaise commune mais au bon département
    Set Suite Variable  ${tiers_notif_dep}  Tiers notifiable departement
    Set Suite Variable  ${mail_tiers_notif_dep}  tnd@atreal.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TND
    ...  liste_diffusion=${mail_tiers_notif_dep}
    ...  libelle=${tiers_notif_dep}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiers_notif_dep}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  ${depts}  ${autre_communes}

    # Sans habilitation en cours de validité
    Set Suite Variable  ${tiers_sans_hab}  Tiers sans habilitation
    Set Suite Variable  ${mail_tiers_sans_hab}  tsh@atreal.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TSH
    ...  liste_diffusion=${mail_tiers_sans_hab}
    ...  libelle=${tiers_sans_hab}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${tc_values}

    # Non lié à une commune ou un département
    Set Suite Variable  ${tiers_sans_com_dep}  Tiers sans com/dep
    Set Suite Variable  ${mail_tiers_sans_com_dep}  tscd@atreal.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TSCD
    ...  liste_diffusion=${mail_tiers_sans_com_dep}
    ...  libelle=${tiers_sans_com_dep}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiers_sans_com_dep}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}

    # 6 Tiers non notifiable dont certain ne pourront pas être ajoutés au dossier
    # - 1 non notifiable
    # - 1 avec une liste de diffusion vide
    # - 1 ayant parmis ses uid celui de la consultation entrante
    # - 1 qui est associé à la mauvaise commune et au mauvais département
    # - 1 qui sera associé à l'autre type d'habilitation
    # - 1 lié à la commune, notifiable mais n'appartenant pas à la collectivité du dossier

    # Non notifiable
    Set Suite Variable  ${tiers_non_notifiable}  Tiers non notifiable
    Set Suite Variable  ${mail_tiers_non_notifiable}  tnn@ko.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TNN
    ...  liste_diffusion=${mail_tiers_non_notifiable}
    ...  libelle=${tiers_non_notifiable}
    ...  ville=${collectivite}
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiersNonNotifiable}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  ${depts}  ${communes}
    # Avec une liste de diffusion vide
    Set Suite Variable  ${tiers_sans_mail}  Tiers sans mail
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TSM
    ...  libelle=${tiers_sans_mail}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiers_sans_mail}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  ${depts}  ${communes}
    # Ayant parmis ses uid celui de la consultation entrante
    Set Suite Variable  ${tiers_consult_entrante}  Tiers Consultation Entrante
    Set Suite Variable  ${mail_tiers_consult_entrante}  tce@ko.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TCE
    ...  liste_diffusion=${mail_tiers_consult_entrante}
    ...  libelle=${tiers_consult_entrante}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    ...  uid_platau_acteur=plop\n${acteur}\nplop2
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiers_consult_entrante}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  ${depts}  ${communes}
    # Associé à la mauvaise commune et au mauvais département
    Set Suite Variable  ${tiers_autre_com_dep}  Tiers autre com / dep
    Set Suite Variable  ${mail_tiers_autre_com_dep}  tacd@ko.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TACD
    ...  liste_diffusion=${mail_tiers_autre_com_dep}
    ...  libelle=${tiers_autre_com_dep}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiers_autre_com_dep}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  ${autre_depts}  ${autre_communes}
    # Associé à l'autre type d'habilitation
    Set Suite Variable  ${tiers_autre_hab}  Tiers autre hab
    Set Suite Variable  ${mail_tiers_autre_hab}  tah@atreal.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TAH
    ...  liste_diffusion=${mail_tiers_autre_hab}
    ...  libelle=${tiers_autre_hab}
    ...  ville=${collectivite}
    ...  accepte_notification_email=false
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ko}
    ...  tiers_consulte=${tiers_autre_hab}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  ${depts}  ${communes}
    # Lié à la commune, notifiable mais n'appartenant pas à la collectivité du dossier
    Set Suite Variable  ${tiers_autre_coll}  Tiers autre coll
    Set Suite Variable  ${mail_tiers_autre_coll}  tac@atreal.fr
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_autre_colle}
    ...  abrege=TAC
    ...  liste_diffusion=${mail_tiers_autre_coll}
    ...  libelle=${tiers_autre_coll}
    ...  ville=${collectivite}
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${tc_values}
    &{habilitation_tiers_consulte_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_habilitation_ok}
    ...  tiers_consulte=${tiers_autre_coll}
    Ajouter une habilitation de tiers consulté  ${habilitation_tiers_consulte_values}  ${depts}  ${communes}

    # PARAMETRAGE EVENEMENTS
    &{args_lettretype} =  Create Dictionary
    ...  id=test_NOTIF_tiers
    ...  libelle=Test
    ...  sql=Aucune REQUÊTE
    ...  titre=&idx, &destinataire, aujourdhui&aujourdhui, datecourrier&datecourrier, &departement
    ...  corps=Ceci est un document
    ...  actif=true
    ...  collectivite=agglo
    Ajouter la lettre-type depuis le menu  &{args_lettretype}
    # On ajoute un événement avec notification automatique des tiers consulté
    # et on test l'affichage du champs de sélection des types d'habilitation
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    @{type_habilitation_tiers_consulte} =  Create List  ${type_habilitation_ok}
    Set Suite Variable  ${evenement_notif_auto_tc}  TEST_NOTIF_TC
    &{args_evenement} =  Create Dictionary
    ...  libelle=${evenement_notif_auto_tc}
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=${args_lettretype.id} ${args_lettretype.libelle}
    ...  notification_tiers=Notification automatique
    ...  type_habilitation_tiers_consulte=${type_habilitation_tiers_consulte}
    Ajouter l'événement depuis le menu  ${args_evenement}

    # Évenements dont les tiers consultés peuvent être notifiés
    &{args_evenement10} =  Create Dictionary
    ...  libelle=TEST_NOTIF_TC_SANS_LETTRETYPE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  notification_tiers=Notification manuelle
    Ajouter l'événement depuis le menu  ${args_evenement10}

    &{args_evenement11} =  Create Dictionary
    ...  libelle=TEST_NOTIF_TC_AVEC_LETTRETYPE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=${args_lettretype.id} ${args_lettretype.libelle}
    ...  notification_tiers=Notification manuelle
    Ajouter l'événement depuis le menu  ${args_evenement11}

    ${om_collectivite_tiers} =  Create List
    ...  LIBRECOM_NOTIFTIERS
    Set Suite Variable  ${om_collectivite_tiers}

    # Création d'une catégorie de tiers consulté (obligatoire pour pouvoir créer des tiers)
    ${current_date} =  Get Current Date  result_format=%d/%m/%Y
    ${nextDay} =  Add Time To Date  ${current_date}  1 days  %d/%m/%Y  True  %d/%m/%Y
    &{categorie_tiers} =  Create Dictionary
    ...  code=CAT_TEST
    ...  libelle=Categorie test notif tiers
    ...  description=Categorie servant pour le test de la notification des tiers consultés.
    ...  date_debut_validite=${current_date}
    ...  date_fin_validite=${nextDay}
    ...  om_collectivite=${om_collectivite_tiers}
    Ajouter la categorie de tiers consulte  ${categorie_tiers}

    # Création de deux tiers d'instruction notifiable et d'un non notifiable
    &{tiers} =  Create Dictionary
    ...  abrege=00.00
    ...  libelle=TiersNotifiable1
    ...  categorie_tiers_consulte=Categorie test notif tiers
    ...  accepte_notification_email=true
    ...  liste_diffusion=tnotifiable1@ok.fr
    Ajouter le tiers consulte depuis le listing  ${tiers}

    &{tiers} =  Create Dictionary
    ...  abrege=00.01
    ...  libelle=TiersNotifiable2
    ...  categorie_tiers_consulte=Categorie test notif tiers
    ...  accepte_notification_email=true
    ...  liste_diffusion=tnotifiable2@ok.fr\ntnotifiable3@ok.fr\ntnotifiable4@ok.fr
    Ajouter le tiers consulte depuis le listing  ${tiers}

    &{tiers} =  Create Dictionary
    ...  abrege=00.02
    ...  libelle=TiersNonNotifiable
    ...  categorie_tiers_consulte=Categorie test notif tiers
    ...  accepte_notification_email=false
    ...  liste_diffusion=nnotifiable@nope.fr
    Ajouter le tiers consulte depuis le listing  ${tiers}

    &{service} =  Create Dictionary
    ...  abrege=00.03
    ...  libelle=ServiceDocAnnexe
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=${collectivite}
    ...  service_type=openADS
    ...  generate_edition=true
    ...  accepte_notification_email=false
    ...  email=nnotifiable@nope.fr
    Ajouter le service depuis le listing  ${service}


Gestion de l'affichage en fonction de l'option "option_module_acteur"
    [Documentation]  Test de l'affichage des différents composants du module acteur selon son activation.
    ...  Les éléments testés sont :
    ...     - Depuis le menu "Type DI" : les champs "categories_tiers" et "categories_tiers_ajout_auto"
    ...         ne doivent être visible que si le module est actif.
    ...     - Depuis le menu "Evenement" : Le champs "notification_tiers" n'a la proposition *Notification automatique*
    ...         et le champs "type_habilitation_tiers_consulte" n'est visible que si le module est actif.
    ...     - Depuis le contexte d'un dossier : l'onglet acteur n'est visible que si le module est actif. 

    Depuis la page d'accueil  admin  admin
    # Ajout d'un administrateur général à la commune pour paramètrer la notification automatique
    Ajouter l'utilisateur depuis le menu  
    ...    Lucien Marcheciel
    ...    cmonpere@guerredesetoiles.galaxie
    ...    lulu 
    ...    lulu
    ...    ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    ...    LIBRECOM_NOTIFTIERS
    # SUppression de l'option au niveau de l'agglo
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_module_acteur
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
    # Activation de l'option de paramétrage des tiers pour la collectivité LIBRECOM_NOTIFTIERS
    # pour la suite des tests
    &{params} =  Create Dictionary
    ...  libelle=option_module_acteur
    ...  valeur=true
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    Ajouter ou modifier le paramètre depuis le menu  ${params}

    # Vérification que pour la collectivité LIBRECOM_NOTIFTIERS les champs de paramétrage de la
    # notification automatique des tiers et l'onglet acteur des DI sont visibles.
    Depuis la page d'accueil  lulu  lulu
    # Les champs de selection de Catégorie de tiers sont visible depuis le formulaire de paramétrage
    # des types de dossiers d'instruction
    Depuis le formulaire de modification d'un type de dossier d'instruction  PCI  P
    Element Should Be Visible  css=select#categories_tiers
    Element Should Be Visible  css=select#categories_tiers_ajout_auto
    # Le champs notification tiers dois contenir la valeur "notification automatique"
    Depuis le formulaire de modification de l'événement  ${evenement_notif_auto_tc}
    @{expected_select_value} =  Create List  Aucune  Notification manuelle  Notification automatique
    Select List Should Be  notification_tiers  ${expected_select_value}
    Select From List By Label  css=select#notification_tiers  Notification automatique
    Wait Until Page Contains Element  css=#type_habilitation_tiers_consulte
    # Accède à l'onglet acteur d'un dossier déjà existant. Si on y accède <=> l'onglet est visible
    # Récupère le payload de création DI
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=natc
    ...  particulier_prenom=natc
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  commune=${lib_commune}
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}
    Depuis l'onglet acteur du dossier d'instruction  ${di_libelle}


    # Vérification que pour les autres collectivités les champs de paramétrage de la
    # notification automatique des tiers et l'onglet acteur ne sont pas visible.
    Depuis la page d'accueil  admin  admin
    # Les champs de selection de Catégorie de tiers ne sont pas visible dans le formulaire de paramétrage
    # des types de dossiers d'instruction
    Depuis le formulaire de modification d'un type de dossier d'instruction  PCI  P
    Page Should Not Contain Element  css=select#categories_tiers
    Page Should Not Contain Element  css=select#categories_tiers_ajout_auto
    # Le champs notification tiers dois contenir la valeur "notification automatique"
    Depuis le formulaire de modification de l'événement  ${evenement_notif_auto_tc}
    @{expected_select_value} =  Create List  Aucune  Notification manuelle
    Select List Should Be  notification_tiers  ${expected_select_value}
    # Vérifie si l'onglet acteur d'un dossier est visible.
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Page Should Not Contain Element  css=a#lien_dossier_tiers

    # Suppression de l'option de paramétrage des tiers pour la collectivité LIBRECOM_NOTIFTIERS
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_module_acteur
    ...  click_value=LIBRECOM_NOTIFTIERS
    Supprimer le paramètre (surcharge)  ${param_args}
    # Reactivation de l'option de paramétrage des tiers sur l'agglo pour la suite des tests
    &{params} =  Create Dictionary
    ...  libelle=option_module_acteur
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${params}

Fonctionnement de l'onglet acteur du dossier
    [Documentation]  Test du fonctionnement de l'onglet acteur d'un dossier.
    ...  Vérifie 3 cas d'usage :
    ...    1- Aucune catégorie de tiers n'est lié au type de dossier du dossier en cours
    ...       -> pas de tableau affiché dans l'onglet acteur
    ...    2- Des catégories de tiers sont liées au type de dossier du dossier en cours
    ...       -> présence, dans l'onglet, d'un tableau par catégorie (auto et/ou manuelle) ayant la même
    ...          collectivité que celle du service en charge du dossier. Possibilité d'ajouter
    ...          consulter et supprimer des acteurs d'une catégorie depuis le tableau.
    ...          Si une catégorie est auto ET manuelle, elle n'a qu'un seul tableau.
    ...    3- Existance d'acteur dont la catégorie n'est plus liée au type de dossier du
    ...       dossier en cours
    ...       -> présence du tableau de cette catégorie avec son acteur. Possibilité d'ajouter
    ...          consulter et supprimer des acteurs de cette catégorie depuis le tableau.
    ...          Si tous les acteurs de ce tableau sont supprimés le tableau n'est plus affiché.

    # Création d'un dossier
    Depuis la page d'accueil  admin  admin
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=test onglet
    ...  particulier_prenom=acteur
    ...  particulier_prenom=acteur
    ...  om_collectivite=${collectivite}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  commune=${lib_commune}
    ...  om_collectivite=${collectivite}
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    # Cas 1 : Pas de catégorie de tiers ajoutable à un dossier
    # Création d'un dossier
    Depuis l'onglet acteur du dossier d'instruction  ${di_libelle}
    Page Should Contain  Aucun acteur à ajouter pour ce dossier.
    
    # Cas 2 : ajout de 4 catégories (3 auto et 3 manuelle avec 2 identique dont 1 qui ne sera pas affiché sur le DI) au PCI initial.
    # Un tableau doit être affiché pour chaque catégorie sans doublon,
    @{categorie_tiers_dossier} =  Create List  ${cat_tiers}  ${cat_tiers_3}  ${cat_tiers_autre_colle}
    @{categorie_tiers_dossier_auto} =  Create List  ${cat_tiers}  ${cat_tiers_2}  ${cat_tiers_autre_colle}
    &{val_PCI} =  Create Dictionary
    ...  categories_tiers=${categorie_tiers_dossier}
    ...  categories_tiers_ajout_auto=${categorie_tiers_dossier_auto}
    Modifier type de dossier d'instruction  PCI  P  ${val_PCI}

    # AFFICHAGE DU LISTING DES ACTEURS

    Depuis l'onglet acteur du dossier d'instruction  ${di_libelle}
    # Test l'affichage des tableaux des catégories et de leur barre de titre par ordre alphabétique.
    Element Should Not Contain  css=#sousform-lien_dossier_tiers #actor-category-title:nth-of-type(1)  Categorie Autre Collectivite
    Page Should Not Contain Element  css=#sousform-acteur_category_${id_cat_tiers_autre_colle}
    Element Should Contain  css=#sousform-lien_dossier_tiers #actor-category-title:nth-of-type(1)  Categorie test acteur
    Page Should Contain Element  css=#sousform-acteur_category_${id_cat_tiers_3}
    Element Should Contain  css=#sousform-lien_dossier_tiers #actor-category-title:nth-of-type(2)  Categorie test d'ajout auto acteur
    Page Should Contain Element  css=#sousform-acteur_category_${id_cat_tiers_2}
    Element Should Contain  css=#sousform-lien_dossier_tiers #actor-category-title:nth-of-type(3)  Categorie test notif tiers
    # Présence d'un seul tableau pour la catégorie de tiers commune au mode auto et manuel
    Page Should Contain Element  css=#sousform-acteur_category_${id_cat_tiers}  1

    # FONCTIONNEMENT DE L'AJOUT D'ACTEUR

    # L'action d'ajout est accessible pour les catégorie d'ajout manuelle et auto
    Page Should Contain Element  css=#sousform-acteur_category_${id_cat_tiers_2}  a#action-soustab-lien_dossier_tiers-corner-ajouter
    Page Should Contain Element  css=#sousform-acteur_category_${id_cat_tiers_3}  a#action-soustab-lien_dossier_tiers-corner-ajouter
    # Test du fonctionnement du formulaire d'ajout d'acteur
    Depuis le formulaire d'ajout des acteurs d'une catégorie au dossier  ${di_libelle}  ${id_cat_tiers_3}
    # Vérifie le remplissage du select des acteurs
    @{tiers_selectionnable} =  Create List  ${tiers_notif_com}  ${tiers_notif_dep}  ${tiers_sans_com_dep}  ${tiers_consult_entrante}  ${tiers_sans_hab}
    @{tiers_non_selectionnable} =  Create List  ${tiers_non_notifiable}  ${tiers_sans_mail}  ${tiers_autre_com_dep}  ${tiers_autre_hab}
    # Rend le select visible pour permettre de voir les options
    Chosen List Should Contain List      select#tiers  ${tiers_selectionnable}
    Chosen List Should Not Contain List  select#tiers  ${tiers_non_selectionnable}
    # La catégorie doit être visible dans le fil d'Ariane
    Element Should Contain  css=div.subtitle  ${cat_tiers_3}
    # Vérifie que le formulaire d'ajout des acteurs affiche bien une erreur si
    # aucun tiers n'est sélection
    Click On Submit Button Until Message  Le remplissage du champs tiers est obligatoire.\nSAISIE NON ENREGISTRÉE
    Element Should Contain  css=div.subtitle  ${cat_tiers_3}
    # Ajout de deux acteurs et vérification de l'affichage trier par ordre alphabétique
    # dans le tableau correspondant
    @{acteurs} =  Create List  ${tiers_notif_com}  ${tiers_notif_dep}
    Saisir des acteurs  ${acteurs}
    Click On Submit Button Until Message  L'acteurs ${tiers_notif_com} a été ajouté au dossier.
    Wait Until Element Contains  css=#sousform-acteur_category_${id_cat_tiers_3} table tr.tab-data:nth-of-type(2)  ${tiers_notif_dep}
    Element Should Contain  css=#sousform-acteur_category_${id_cat_tiers_3} table tr.tab-data:nth-of-type(1)  ${tiers_notif_com}

    # FONCTIONNEMENT DE LA CONSULTATION D'ACTEUR

    Cliquer sur le bouton de consultation de l'acteur  ${tiers_notif_com}
    Le portlet d'action ne doit pas être présent dans le sous-formulaire
    &{values_to_test} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tiers_3}
    ...  abrege=TNC
    ...  adresse=8 avenue Bouvard
    ...  complement=complement
    ...  cp=74000
    ...  liste_diffusion=${mail_tiers_notif_com}
    ...  tiers=${tiers_notif_com}
    ...  ville=${collectivite}
    ...  accepte_notification_email=Oui
    ...  uid_platau_acteur=plop
    ${values}=  Get Dictionary Items  ${values_to_test}
    :FOR  ${key}  ${value}  IN  @{values}
    \  Element Should Contain  css=#${key}  ${value}
    Click On Back Button In SubForm

    # FONCTIONNEMENT DE LA SUPPRESSION DE L'ACTEUR.

    Cliquer sur le bouton de suppression de l'acteur  ${tiers_notif_dep}
    Wait Until Element Does Not Contain  css=#sousform-acteur_category_${id_cat_tiers_3}  ${tiers_notif_dep}

    # Cas 3 : délie la catégorie 2 du type de dossier et vérifie qu'elle apparait toujours sur le dossier
    # jusqu'à ce que ses acteurs soient supprimé
    @{categorie_tiers_dossier} =  Create List  ${cat_tiers}
    &{val_PCI} =  Create Dictionary
    ...  categories_tiers=${categorie_tiers_dossier}
    Modifier type de dossier d'instruction  PCI  P  ${val_PCI}

    Depuis l'onglet acteur du dossier d'instruction  ${di_libelle}
    Page Should Contain Element  css=#sousform-acteur_category_${id_cat_tiers_3}
    @{acteurs} =  Create List  ${tiers_notif_dep}
    # Vérifie que l'ajout d'acteur est toujours possible pour cette catégorie
    Ajouter des acteurs d'une catégorie au dossier  ${di_libelle}  ${id_cat_tiers_3}  ${acteurs}
    # Vérifie que la suppression d'acteur est toujours possible pour cette catégorie
    Cliquer sur le bouton de suppression de l'acteur  ${tiers_notif_com}
    Wait Until Element Does Not Contain  css=#sousform-acteur_category_${id_cat_tiers_3}  ${tiers_notif_com}
    # Vérifie que la consultation d'acteur est toujours possible pour cette catégorie
    Cliquer sur le bouton de consultation de l'acteur  ${tiers_notif_dep}
    Element Should Contain  css=#tiers  ${tiers_notif_dep}
    Click On Back Button In SubForm
    # Suppression du dernier acteur de la catégorie. Le tableau de la catégorie doit disparaître
    Cliquer sur le bouton de suppression de l'acteur  ${tiers_notif_dep}
    Wait Until Page Does Not Contain  ${cat_tiers_3}

Ajout automatique des acteurs sur un dossier
    [Documentation]  Vérifie que la création d'un dossier déclenche bien la création de tous les
    ...  acteur le concernant.
    ...  Test 3 cas :
    ...    - Création d'un dossier avec des ajouts automatiques paramétrés. Vérifie que les tiers
    ...      répondant aux critères voulus sont ajoutés en tant qu'acteur et pas les autres.
    ...    - Création d'un dossier sans ajout auto paramétrés. Aucun acteurs ne doit être ajoutés.
    ...    - Création d'un dossir avec ajout auto paramétrés mais l'option module acteur n'est pas
    ...      active. Aucun acteur ne doit être ajoutés.

    # Paramétrage des catégories en ajout auto
    @{categorie_tiers_dossier} =  Create List  choisir categories_tiers
    @{categorie_tiers_dossier_auto} =  Create List  ${cat_tiers_3}  ${cat_tiers_autre_colle}
    &{val_PCI} =  Create Dictionary
    ...  categories_tiers=${categorie_tiers_dossier}
    ...  categories_tiers_ajout_auto=${categorie_tiers_dossier_auto}
    Modifier type de dossier d'instruction  PCI  P  ${val_PCI}

    # Création d'un dossier
    Depuis la page d'accueil  admin  admin
    # Cas 1 : Création d'un dossier avec ajout auto de tiers.
    # Les tiers ajoutés doivent respecter les contraintes suivante :
    #   - avoir une habilitation lié à la commune ou au departement du dossier
    #     OU avoir une habilitation non lié à une commune et à un département
    #     OU ne pas avoir d'habilitation
    #   - être relié à la collectivité du dossiers
    #   - être notifiable (accepte les notification)
    
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=test ajout auto
    ...  particulier_prenom=acteur
    ...  om_collectivite=${collectivite}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  commune=${lib_commune}
    ...  om_collectivite=${collectivite}
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    Depuis l'onglet acteur du dossier d'instruction  ${di_libelle}
    @{acteurs_ajoutés} =  Create List  ${tiers_notif_com}  ${tiers_notif_dep}  ${tiers_sans_com_dep}  ${tiers_sans_hab}  ${tiers_consult_entrante}
    :FOR  ${acteur}  IN  @{acteurs_ajoutés}
    \  Page Should Contain  ${acteur}

    @{acteurs_non_ajoutés} =  Create List  ${tiers_non_notifiable}  ${tiers_sans_mail}  ${tiers_autre_com_dep}  ${tiers_autre_hab}
    :FOR  ${acteur}  IN  @{acteurs_non_ajoutés}
    \  Page Should Not Contain  ${acteur}

    # Cas 2 : Création d'un dossier sans ajout auto paramétrés.
    # Aucun acteur ne sera ajouté.
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=test ajout auto
    ...  particulier_prenom=acteur 2
    ...  om_collectivite=${collectivite}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  commune=${lib_commune}
    ...  om_collectivite=${collectivite}
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    Depuis l'onglet acteur du dossier d'instruction  ${di_libelle}
    Page Should Contain  Aucun acteur à ajouter pour ce dossier.

    # Cas 3 : Création d'un dossier avec ajout auto paramétrés mais ou le module acteur est désactive.
    # Aucun acteur ne sera ajouté.

    # Désactivation de l'option de paramétrage des tiers pour la collectivité LIBRECOM_NOTIFTIERS
    &{params} =  Create Dictionary
    ...  libelle=option_module_acteur
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${params}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=test ajout auto
    ...  particulier_prenom=acteur 3
    ...  om_collectivite=${collectivite}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  commune=${lib_commune}
    ...  om_collectivite=${collectivite}
    ${di_libelle} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    # Re-Activation de l'option de paramétrage des tiers pour la collectivité LIBRECOM_NOTIFTIERS
    &{params} =  Create Dictionary
    ...  libelle=option_module_acteur
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${params}

    Depuis l'onglet acteur du dossier d'instruction  ${di_libelle}
    # Vérifie que le tableau des acteurs du dossier est vide
    Page Should Not Contain Element  css=#sousform-lien_dossier_tiers tbody td

    

Activation de la notification par mail
    [Documentation]  Active la notification par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    &{om_param} =  Create Dictionary
    ...  libelle=option_notification
    ...  valeur=mail
    ...  om_collectivite=${collectivite}
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    Démarrer maildump

Notification par mail des tiers consultés instruction sans lettretype et sans annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction dont les services peuvent être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Carrière
    ...  particulier_prenom=Élisabeth
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    ...  commune=${lib_commune}
    ${di_notif_SC1} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout de l'instruction a notifier au service qui n'a pas de lettretype
    Depuis la page d'accueil  ninstr  ninstr
    ${inst_notif_tc_ss_lt1} =  Ajouter une instruction au DI  ${di_notif_SC1}  TEST_NOTIF_TC_SANS_LETTRETYPE
    Click On Link  ${inst_notif_tc_ss_lt1}
    # L'action doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_tiers_consulte

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_tiers_consulte  modale
    Wait until page Contains  TiersNotifiable1
    Page Should Contain  TiersNotifiable2
    Element Should Not Contain  css=#sousform-instruction_notification_manuelle .formEntete #form-content:nth-child(1)   TiersNonNotifiable
    # Remplissage du formulaire et validation
    @{tiers_a_selectionner} =  Create List  TiersNotifiable1  TiersNotifiable2
    Select From Multiple Chosen List  tiers_consulte  ${tiers_a_selectionner}
    ${CurrentDate} =  Valider le formulaire de notification

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait until page contains element  css=#fieldset-sousform-instruction-suivi-notification-tiers
    # Test de l'affichage des informations dans le tableau de suivi
    Element Should Contain  css=td[data-column-id="émetteur"]      ninstr
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  TiersNotifiable1
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_TC_SANS_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    
    # Vérification de l'envoi du mail et de son contenu
    Verifier que le mail a bien été envoyé au destinataire  tnotifiable1@ok.fr
    Verifier que le mail a bien été envoyé au destinataire  tnotifiable2@ok.fr
    Verifier que le mail a bien été envoyé au destinataire  tnotifiable3@ok.fr
    Verifier que le mail a bien été envoyé au destinataire  tnotifiable4@ok.fr
    # le mail ne doit pas contenir de lien car il n'y a pas de pièce
    Vérifier que le contenu du mail ne contiens pas  tnotifiable1@ok.fr  /web/notification.php?key=
    # Vérifie que le message affiché est bien celui paramétré
    Page Should Contain  Bonjour les tiers (avec un caractère accentué), veuillez prendre connaissance du(des) document(s) suivant(s)
    Unselect frame
    Vérifier le sujet du mail  notifiable1@ok.fr  [openADS] Notification pour les tiers concernant le dossier (avec un caractère accentué)
    Vider la boite mail


Notification par mail des tiers consultés instruction avec lettretype et sans annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction dont les services peuvent être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Soucy
    ...  particulier_prenom=Galatee
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    ...  commune=${lib_commune}
    ${di_notif_SC2} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout de l'instruction a notifier au service qui n'a pas de lettretype
    Depuis la page d'accueil  ninstr  ninstr
    Ajouter une instruction au DI et la finaliser  ${di_notif_SC2}  TEST_NOTIF_TC_AVEC_LETTRETYPE
    # L'action doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_tiers_consulte

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_tiers_consulte  modale
    Wait until page Contains  TiersNotifiable1
    Page Should Contain  TiersNotifiable2
    Element Should Not Contain  css=#sousform-instruction_notification_manuelle .formEntete #form-content:nth-child(1)  TiersNonNotifiable
    # Remplissage du formulaire et validation
    @{tiers_a_selectionner} =  Create List  TiersNotifiable1
    Select From Multiple Chosen List  tiers_consulte  ${tiers_a_selectionner}
    ${CurrentDate} =  Valider le formulaire de notification

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait until page contains element  css=#fieldset-sousform-instruction-suivi-notification-tiers
    # Test de l'affichage des informations dans le tableau de suivi
    Element Should Contain  css=td[data-column-id="émetteur"]      ninstr
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  TiersNotifiable1
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_TC_AVEC_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    
    # Vérification de l'envoi du mail et de son contenu
    Verifier que le mail a bien été envoyé au destinataire  tnotifiable1@ok.fr
    Page Should Not Contain  tnotifiable2@ok.fr
    # Le mail doit contenir le lien vers le document de l'instruction
    Vérifier le contenu du mail  tnotifiable1@ok.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    # Vérifie que le message affiché est bien celui paramétré
    Page Should Contain  Bonjour les tiers (avec un caractère accentué), veuillez prendre connaissance du(des) document(s) suivant(s)
    Unselect frame
    Vérifier le sujet du mail  notifiable1@ok.fr  [openADS] Notification pour les tiers concernant le dossier (avec un caractère accentué)
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC2}  TEST_NOTIF_TC_AVEC_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}
    Vider la boite mail


Notification par mail des tiers consultés instruction sans lettretype et avec annexes
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction dont les services peuvent être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Desnoyers
    ...  particulier_prenom=Ogier
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    ...  commune=${lib_commune}
    ${di_notif_SC3} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction finalisée et signé qui servira d'annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC3}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout d'un retour d'avis
    Ajouter une consultation depuis un dossier  ${di_notif_SC3}  00.03 - ServiceDocAnnexe
    Depuis le contexte de la consultation  ${di_notif_SC3}  00.03 - ServiceDocAnnexe
    &{piece_values} =  Create Dictionary
    ...  fichier_upload=testImportManuel.pdf
    ...  date_demande=03/02/2016
    ...  avis_consultation=Tacite
    ${nom_piece} =  Ajouter une pièce à la consultation  ${piece_values}

    # Ajout de l'instruction a notifier au service qui n'a pas de lettretype
    Depuis la page d'accueil  ninstr  ninstr
    ${inst_notif_tc_ss_lt3} =  Ajouter une instruction au DI  ${di_notif_SC3}  TEST_NOTIF_TC_SANS_LETTRETYPE
    Click On Link  ${inst_notif_tc_ss_lt3}
    # L'action doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_tiers_consulte

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_tiers_consulte  modale
    Wait until page Contains  TiersNotifiable1
    Page Should Contain  TiersNotifiable2
    Element Should Not Contain  css=#sousform-instruction_notification_manuelle .formEntete .bloc:nth-child(1)  TiersNonNotifiable
    # Remplissage du formulaire et validation
    @{tiers_a_selectionner} =  Create List  TiersNotifiable1
    Select From Multiple Chosen List  tiers_consulte  ${tiers_a_selectionner}
    @{annexes_a_selectionner} =  Create List  Avis - ServiceDocAnnexe  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes  ${annexes_a_selectionner}
    ${CurrentDate}=  Valider le formulaire de notification

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait until page contains element  css=#fieldset-sousform-instruction-suivi-notification-tiers
    # Test de l'affichage des informations dans le tableau de suivi
    
    Element Should Contain  css=td[data-column-id="émetteur"]      ninstr
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  TiersNotifiable1
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_TC_SANS_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe\nAnnexe
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    
    # Vérification de l'envoi du mail et de son contenu
    Verifier que le mail a bien été envoyé au destinataire  tnotifiable1@ok.fr
    Page Should Not Contain  tnotifiable2@ok.fr
    # Le mail doit contenir le lien vers les annexes
    Vérifier le contenu du mail  tnotifiable1@ok.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    # Vérifie que le message affiché est bien celui paramétré
    Page Should Contain  Bonjour les tiers (avec un caractère accentué), veuillez prendre connaissance du(des) document(s) suivant(s)
    Unselect frame
    Vérifier le sujet du mail  notifiable1@ok.fr  [openADS] Notification pour les tiers concernant le dossier (avec un caractère accentué)
    ${annexe1}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${annexe1}  RECEPISSE DE DEPOT
    ${annexe2}=  Get From List  ${keys}  1
    Verifier que le lien de notification contiens  ${annexe2}  TEST IMPORT MANUEL 1

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC3}  TEST_NOTIF_TC_SANS_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}
    Vider la boite mail


Notification par mail des tiers consultés instruction avec lettretype et avec annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction dont les services peuvent être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Lanoie
    ...  particulier_prenom=Hortense
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    ...  commune=${lib_commune}
    ${di_notif_SC4} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction finalisée et signé qui servira d'annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC4}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout d'un retour d'avis
    Ajouter une consultation depuis un dossier  ${di_notif_SC4}  00.03 - ServiceDocAnnexe
    Depuis le contexte de la consultation  ${di_notif_SC4}  00.03 - ServiceDocAnnexe
    &{piece_values} =  Create Dictionary
    ...  fichier_upload=testImportManuel.pdf
    ...  date_demande=03/02/2016
    ...  avis_consultation=Tacite
    ${nom_piece} =  Ajouter une pièce à la consultation  ${piece_values}

    # Ajout de l'instruction a notifier au service qui n'a pas de lettretype
    Depuis la page d'accueil  ninstr  ninstr
    Ajouter une instruction au DI et la finaliser  ${di_notif_SC4}  TEST_NOTIF_TC_AVEC_LETTRETYPE
    # L'action doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_tiers_consulte

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_tiers_consulte  modale
    Wait until page Contains  TiersNotifiable1
    Page Should Contain  TiersNotifiable2
    Element Should Not Contain  css=#sousform-instruction_notification_manuelle .formEntete .bloc:nth-child(1)  TiersNonNotifiable
    # Remplissage du formulaire et validation
    @{tiers_a_selectionner} =  Create List  TiersNotifiable1
    Select From Multiple Chosen List  tiers_consulte  ${tiers_a_selectionner}
    @{annexes_a_selectionner} =  Create List  Avis - ServiceDocAnnexe  Notification du delai legal maison individuelle
    Select From Multiple Chosen List   annexes  ${annexes_a_selectionner}
    ${CurrentDate}=  Valider le formulaire de notification

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait until page contains element  css=#fieldset-sousform-instruction-suivi-notification-tiers
    # Test de l'affichage des informations dans le tableau de suivi
    
    Element Should Contain  css=td[data-column-id="émetteur"]      ninstr
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  TiersNotifiable1
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_TC_AVEC_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe\nAnnexe
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    
    # Vérification de l'envoi du mail et de son contenu
    Verifier que le mail a bien été envoyé au destinataire  tnotifiable1@ok.fr
    Page Should Not Contain  tnotifiable2@ok.fr
    # Le mail doit contenir le lien vers le document et les annexes
    Vérifier le contenu du mail  tnotifiable1@ok.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    # Vérifie que le message affiché est bien celui paramétré
    Page Should Contain  Bonjour les tiers (avec un caractère accentué), veuillez prendre connaissance du(des) document(s) suivant(s)
    Unselect frame
    Vérifier le sujet du mail  notifiable1@ok.fr  [openADS] Notification pour les tiers concernant le dossier (avec un caractère accentué)
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document
    ${annexe1}=  Get From List  ${keys}  1
    Verifier que le lien de notification contiens  ${annexe1}  RECEPISSE DE DEPOT
    ${annexe2}=  Get From List  ${keys}  2
    Verifier que le lien de notification contiens  ${annexe2}  TEST IMPORT MANUEL 1

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC4}  TEST_NOTIF_TC_AVEC_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}
    Vider la boite mail

Notification automatique des tiers consultés
    [Documentation]  Test de la notification automatique des tiers consultés.
    ...  Vérifie que seul les tiers ayant le type d'habilitation sélectionné
    ...  sont notifiés. Vérifie également que le service consulté en charge du
    ...  dossier n'est pas notifié et qu'uniquement les tiers associés à la
    ...  commune et au département du dossier le sont.

    # Connection en tant qu'instructeur polyvalent de la commune du dossier
    Depuis la page d'accueil  admin  admin
    # Enregistrement de la date pour la saisie des formulaire
    ${date_courante} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y

    # CRÉATION D'UN DOSSIER DEMAT

    # Paramétrage du type de DI pour que les acteurs soient ajoutés automatiquement au dossier
    @{categorie_tiers_auto} =  Create List  ${cat_tiers_3}  ${cat_tiers_autre_colle}
    @{categorie_tiers_man} =  Create List  ${cat_tiers_2}
    &{val_PCI} =  Create Dictionary
    ...  categories_tiers_ajout_auto=${categorie_tiers_auto}
    ...  categories_tiers=${categorie_tiers_man}
    Modifier type de dossier d'instruction  PCI  P  ${val_PCI}

    # Préparation de la consultation entrante du dossier
    # Change le type affichage du type de DA
    &{args_da_type} =  Create Dictionary
    ...  affichage_form=CONSULTATION ENTRANTE
    Modifier le type de dossier d'autorisation  Permis de construire  ${args_da_type}
    # Récupère le payload de création DI
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  000-AAA-00
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  AAA-000-00
    ${json_payload} =  Replace String  ${json_payload}  13055  ${code_commune}
    ${json_payload} =  Replace String  ${json_payload}  SDF-ZER-74R  ${acteur}
    ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${acteur}
    ${payload_dict} =  To Json  ${json_payload}
    # Préparation de la tâche de création du dossier
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # Ajout du dossier sur lequel on va déclencher la notification automatique
    # associé à la commune et à la consultation entrante voulu
    ${msg} =  Déclencher le traitement des tâches par WS
    # Récupération du numéro de dossier
    ${search_values} =  Create Dictionary
    ...  source_depot=Plat'AU
    ...  om_collectivite=${collectivite}
    Depuis le contexte du dossier d'instruction par la recherche avance  ${search_values}  ${collectivite}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#dossier_libelle
    ${di_notif_auto_tiers} =  Get Text  css=#dossier_libelle

    # CRÉATION D'UN DOSSIER DEPUIS L'APPLICATION

    # Récupère le payload de création DI
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=NATC2
    ...  particulier_prenom=NATC2
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  commune=${lib_commune}
    ...  om_collectivite=LIBRECOM_NOTIFTIERS
    ${di_notif_auto_tiers_papier} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}


    # Liste des mails permettant de vérifier le fonctionnement de la notification
    @{mail_recu} =  Create List  ${mail_tiers_notif_com}  ${mail_tiers_notif_dep}  ${mail_tiers_notif_man}  #${mail_tiers_sans_hab}  ${mail_tiers_sans_com_dep}
    @{mail_non_recu} =  Create List  ${mail_tiers_non_notifiable}  ${mail_tiers_autre_com_dep}  ${mail_tiers_autre_hab}  ${mail_tiers_autre_coll}

    # Test la notification automatique pour un dossier demat et un dossier papier
    @{di_to_test} =  Create List  ${di_notif_auto_tiers}  ${di_notif_auto_tiers_papier}
    :FOR  ${di}  IN  @{di_to_test}
    # Ajout des acteurs du dossier. Vérifie que les tiers sans mail, n'étant pas notifiable
    # ou qui ne sont rattaché ni à la commune ni au département du dossier ne sont pas sélectionnable
    \  @{acteurs} =  Create List  ${tiers_notif_man}
    \  Ajouter des acteurs d'une catégorie au dossier  ${di}  ${id_cat_tiers_2}  ${acteurs}
    # Ajout de l'instruction declenchant la notification et saisie de la date de retour
    # de signature pour déclencher la notification des tiers
    \  ${inst_notif_auto} =  Ajouter une instruction au DI et la finaliser  ${di}  ${evenement_notif_auto_tc}
    \  Click On SubForm Portlet Action  instruction  modifier_suivi
    \  Input Datepicker  date_retour_signature  ${date_courante}
    \  Click On Submit Button In Subform
    # Vérification de la présence des mails et vérification de l'affichage du suivi
    \  Wait until element contains  css=tr:nth-child(1) td[data-column-id="émetteur"]      admin (Administrateur) (automatique)
    \  Page Should Contain     ${tiers_notif_com} : ${mail_tiers_notif_com}
    \  Element Should Contain  css=tr:nth-child(1) td[data-column-id="instruction"]   TEST_NOTIF_TC
    \  Element Should Contain  css=tr:nth-child(1) td[data-column-id="statut"]        envoyé
    \  Element Should Contain  css=tr:nth-child(1) td[data-column-id="commentaire"]   Le mail de notification a été envoyé
    \  Element Should Contain  css=tr:nth-child(2) td[data-column-id="émetteur"]      admin (Administrateur) (automatique)
    \  Page Should Contain     ${tiers_notif_dep} : ${mail_tiers_notif_dep}
    \  Element Should Contain  css=tr:nth-child(2) td[data-column-id="instruction"]   TEST_NOTIF_TC
    \  Element Should Contain  css=tr:nth-child(2) td[data-column-id="statut"]        envoyé
    \  Element Should Contain  css=tr:nth-child(2) td[data-column-id="commentaire"]   Le mail de notification a été envoyé
    \  Element Should Contain  css=tr:nth-child(3) td[data-column-id="émetteur"]      admin (Administrateur) (automatique)
    \  Page Should Contain     ${tiers_notif_man} : ${mail_tiers_notif_man}
    \  Element Should Contain  css=tr:nth-child(3) td[data-column-id="instruction"]   TEST_NOTIF_TC
    \  Element Should Contain  css=tr:nth-child(3) td[data-column-id="statut"]        envoyé
    \  Element Should Contain  css=tr:nth-child(3) td[data-column-id="commentaire"]   Le mail de notification a été envoyé
    # Les tiers sans habilitation et sans division territoriale ne doivent pas être notifié
    \  Page Should Not Contain     ${tiers_sans_hab} : ${mail_tiers_sans_hab}
    \  Page Should Not Contain     ${tiers_sans_com_dep} : ${mail_tiers_sans_com_dep}
    # Vérification des mails reçus.
    # Seul les mails aux acteurs du dossier, lié à sa commune ou son département, dont l'adresse mail
    # est valide, acceptant les notification et n'étant pas le service consulté du dossier sont envoyés.
    \  Verifier que les mails ont bien été envoyés au destinataire  ${mail_recu}
    \  Verifier que les mails n'ont pas été envoyés au destinataire  ${mail_non_recu}
    # La consultation entrante n'existe que pour les dossiers demat. Pour le dossier demat le tiers ayant l'id du service
    # consulté ne dois pas être notifié.
    # Pour la consultation papier, il dois l'être car il n'y a pas de service consulte.
    \  Run Keyword If  "${di}" == "${di_notif_auto_tiers_papier}"
    \  ...  Verifier que le mail a bien été envoyé au destinataire  ${mail_tiers_consult_entrante}
    \  ...  ELSE  Page Should Not Contain  ${mail_tiers_consult_entrante}

    # Rétablissement du paramétrage

    # Rétablis le type affichage du type de DA
    &{args_da_type} =  Create Dictionary
    ...  affichage_form=ADS
    Modifier le type de dossier d'autorisation  Permis de construire  ${args_da_type}

    # Suppression des catégories de tiers du type de DI
    @{categorie_tiers_dossier} =  Create List  choisir categories_tiers
    &{val_PCI} =  Create Dictionary
    ...  categories_tiers=${categorie_tiers_dossier}
    Modifier type de dossier d'instruction  PCI  P  ${val_PCI}


TNR doublon notification tiers consulté
    [Documentation]  Test de la notification automatique des tiers consultés.
    ...  Vérifie que seul les tiers ayant le type d'habilitation sélectionné
    ...  sont notifiés. Vérifie également que le service consulté en charge du
    ...  dossier n'est pas notifié et qu'uniquement les tiers associés à la
    ...  commune et au département du dossier le sont.

    # Paramétrage des catégories dont les tiers pourront être sélectionné
    @{categorie_tiers_dossier} =  Create List  ${cat_tiers_2}
    @{categorie_tiers_dossier_auto} =  Create List  choisir categories_tiers_ajout_auto
    &{val_PCI} =  Create Dictionary
    ...  categories_tiers=${categorie_tiers_dossier}
    ...  categories_tiers_ajout_auto=${categorie_tiers_dossier_auto}
    Modifier type de dossier d'instruction  PCI  P  ${val_PCI}

    # Préparation de la consultation entrante du dossier
    # Change le type affichage du type de DA
    &{args_da_type} =  Create Dictionary
    ...  affichage_form=CONSULTATION ENTRANTE
    Modifier le type de dossier d'autorisation  Permis de construire  ${args_da_type}
    # Récupère le payload de création DI
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  000-AAA-00
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  AAA-000-00
    ${json_payload} =  Replace String  ${json_payload}  13055  ${code_commune}
    ${json_payload} =  Replace String  ${json_payload}  SDF-ZER-74R  ${acteur}
    ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${acteur}
    ${json_payload} =  Replace String  ${json_payload}  TEST300TASKPRENOM777  NATC_PRENOM
    ${json_payload} =  Replace String  ${json_payload}  TEST300TASKNOM0777  NATC_NOM
    ${payload_dict} =  To Json  ${json_payload}
    # Préparation de la tâche de création du dossier
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # Ajout du dossier sur lequel on va déclencher la notification automatique
    # associé à la commune et à la consultation entrante voulu
    ${msg} =  Déclencher le traitement des tâches par WS
    # Récupération du numéro de dossier
    ${search_values} =  Create Dictionary
    ...  source_depot=Plat'AU
    ...  om_collectivite=${collectivite}
    ...  particulier=NATC_NOM
    Depuis le contexte du dossier d'instruction par la recherche avance  ${search_values}  ${collectivite}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#dossier_libelle
    ${di_notif_auto_tiers} =  Get Text  css=#dossier_libelle

    # Ajout des acteurs à notifier
    @{acteurs} =  Create List  ${tiers_notif_man}
    Ajouter des acteurs d'une catégorie au dossier  ${di_notif_auto_tiers}  ${id_cat_tiers_2}  ${acteurs}

    # Ajout de l'instruction declenchant la notification et saisie de la date de retour
    # de signature pour déclencher la notification des tiers
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto_tiers}  ${evenement_notif_auto_tc}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_courante}
    Click On Submit Button In Subform

    Wait until element contains  css=tr:nth-child(1) td[data-column-id="émetteur"]      admin (Administrateur) (automatique)
    Page Should Contain Element  xpath=//tr/td[normalize-space(text()) = "${tiers_notif_man} : ${mail_tiers_notif_man}"]  None  INFO  1

    # Réinitialise le type affichage du type de DA
    &{args_da_type} =  Create Dictionary
    ...  affichage_form=ADS
    Modifier le type de dossier d'autorisation  Permis de construire  ${args_da_type}

Rétablissement des paramètres


    # Désactivation de l'option de paramétrage des tiers pour la collectivité LIBRECOM_NOTIFTIERS
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_module_acteur
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
    # Désactivation de l'option option_dossier_commune et de l'option option_mode_service_consulte
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_commune
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
    Désactiver le mode service consulté
    # supprime le paramètre 'acteur' de la collectivité/au service
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=platau_acteur_service_consulte
    ...  click_value=${collectivite}
    Supprimer le paramètre (surcharge)  ${param_args}
    # définir les paramètres de type de demande
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=platau_type_demande_initial_PCI
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
