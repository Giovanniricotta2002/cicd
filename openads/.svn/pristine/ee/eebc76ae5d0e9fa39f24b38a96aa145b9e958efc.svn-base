*** Settings ***
Documentation  Gestion des consultations.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Variables ***
${json_consultation}  {"module":"consultation"}


*** Test Cases ***
Les services proposés pour la consultation d'un dossier non transmissible à Plat'AU ne doivent pas être des services de type Plat'AU
    [Documentation]  Lors de l'instruction d'un dossier non-transmissible à Plat'AU, 
    ...  dans l'onglet Consultations, la selection de services disponibles 
    ...  après avoir appuyé sur + ne doit pas proposer de services de type Plat'AU.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=080SelectServiceNonPlatauNom
    ...  particulier_prenom=080SelectServiceNonPlatauPrenom
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    Depuis la page d'accueil  admin  admin
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On affiche le Statut Plat'AU du dossier d'autorisation détaillés utilisés : PCI qui n'est Jamais transmissible à Plat'AU
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    # On modifie le type de service choisi vers un type Plat'AU
    Depuis la page d'accueil  admin  admin
    &{args_service} =  Create Dictionary
    ...  service_type=Plat'AU
    Modifier le service  1ER  Maire 1er Secteur  ${args_service}

    # On vérifie que le 'select' des services disponibles à la consultation pour le dossier PCI utilisé, 
    # ne contient pas le service choisi (1ER - Mairie 1er Secteur)
    Ajouter une consultation depuis l'onglet du dossier d'instruction  ${di}
    Wait Until Element Is Visible  service
    @{select_service} =  Get List Items  service
    Should Not Contain Match  ${select_service}  1ER - Maire 1er Secteur

    # On retire l'affichage du Statut Plat'AU du dossier d'autorisation détaillés utilisés
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    # On remodifie le type de service choisi vers un type openADS
    Depuis la page d'accueil  admin  admin
    &{args_service} =  Create Dictionary
    ...  service_type=openADS
    Modifier le service  1ER  Maire 1er Secteur  ${args_service}

L'ajout de consultation à des tiers ne dois pas être possible si aucun tiers n'est paramétré
    [Documentation]  Dans le cas, où aucun tiers n'a été paramétré, le + bleu
    ...  servant à ajouter une consultation vers un tiers ne dois pas apparaître
    ...  dans l'onglet consultation.

    # Ajout d'un nouveau dossier et accès à l'onglet consultation
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=080btnbleuNom
    ...  particulier_prenom=080btnbleuPrenom
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # Comme il n'y a pas de tiers consulté l'icone d'ajout ne dois pas être affichée
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet consultation du dossier  ${di}
    Page Should Not Contain Element  css=a#action-soustab-consultation-corner-ajouter_consultation_tiers

    # Ajout de tiers consulté
    Depuis la page d'accueil  admin  admin
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  abrege=TNR_ACT
    ...  libelle=TNR ajout consultation tiers
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    # Comme il y a des tiers consulté l'icone d'ajout dois être affichée
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet consultation du dossier  ${di}
    Page Should Contain Element  css=a#action-soustab-consultation-corner-ajouter_consultation_tiers

TNR Routine de mise à jour des consultations tacites

    [Documentation]  Permet de vérifier l'état des consultations après le
    ...  traitement tacite.
    ...  Attention ! ce test est en premier car il utilise les données du init_data
    ...  il est nécessaire d'améilorer ce point

    # Isolation d'un contexte
    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=MIROUFCITY
    ...  departement=013
    ...  commune=188
    ...  insee=13018
    ...  direction_code=MIROUF
    ...  direction_libelle=Direction de MIROUFCITY
    ...  direction_chef=Chef
    ...  division_code=MIROUF
    ...  division_libelle=Division MIROUF
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Sylvain Mirouf
    ...  guichet_om_utilisateur_email=smirouf@openads-test.fr
    ...  guichet_om_utilisateur_login=smirouf
    ...  guichet_om_utilisateur_pwd=smirouf
    ...  instr_om_utilisateur_nom=Pom Pote
    ...  instr_om_utilisateur_email=pompote@openads-test.fr
    ...  instr_om_utilisateur_login=pompote
    ...  instr_om_utilisateur_pwd=pompote
    Isolation d'un contexte  ${isolation_values}
    
    Modifier l'utilisateur
    ...  ${isolation_values.instr_om_utilisateur_nom}
    ...  ${isolation_values.instr_om_utilisateur_email}
    ...  ${isolation_values.instr_om_utilisateur_login}
    ...  ${isolation_values.instr_om_utilisateur_pwd}
    ...  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL

    # Création de dossiers dans le profil isolé :
    Depuis la page d'accueil  pompote  pompote

    # Création d'un dossier et ajout d'un tiers consulté avec un délais pour tester le tacite
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TACITA
    ...  particulier_prenom=Louise
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=MARSEILLE
    ${di_tacite_tiers} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Création du tiers a consulter et d'un utilisateur lié
    Depuis la page d'accueil  admin  admin
    &{args_tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  abrege=TM1
    ...  libelle=1er tiers de Marseille
    ...  ville=MARSEILLE
    ...  adresse=1 rue plop
    ...  complement=complement plopeux
    ...  cp=13666
    ...  liste_diffusion=support@atreal.fr
    ...  accepte_notification_email=true
    ...  uid_platau_acteur=TST_FTC_TM1
    Ajouter le tiers consulte depuis le listing  ${args_tiers_1}
    # Conservation de la variable pour récupérer ses valeurs dans le test de l'export des tiers
    Set Suite Variable  ${args_tiers_1}
    &{lien_tiers_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Instr. Service Marseille
    ...  tiers_consulte=1er tiers de Marseille
    Ajouter lien utilisateur / tiers consulté  ${lien_tiers_om_utilisateur}

    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM1 - 1er tiers de Marseille
    ...  motif_consultation=Premier motif de consultation
    ...  date_envoi=12/04/2015
    Ajouter une consultation vers un tiers depuis un dossier  ${di_tacite_tiers}  ${tiers_1}

    # On exécute le WS de mise à jour des consultations
    Vérifier le code retour du web service et vérifier que son message est  Post  maintenance  ${json_consultation}  200  3 consultations mise(s) à jour.

    # On vérifie que la valeur de la consultation qui a été passée en tacite
    # est bien marquée comme 'non lu'
    # Définition de l'id du widget des retours de consultation du profil INSTRUCTEUR
    ${widget_id} =  Set Variable  widget_3
    # En tant que profil 'INSTRUCTEUR'
    Depuis la page d'accueil  instr  instr
    # On vérifie que les consultations apparaissent bien sur le tableau de bord de l'instructeur
    # Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  2
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # On accède au listing des restours de consultation
    Page Title Should Be  Instruction > Consultations > Mes Retours
    Page Should Contain  ${di_tacite_tiers}
    # On clique sur le dossier en question
    Click On Link  PC 013055 12 00002P0

    # On vérifie que les champs ont bien été mis à jour par le webservice
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#lu  Non
    Form Static Value Should Be  css=#avis_consultation  Tacite
    Form Static Value Should Be  css=#date_retour  01/02/2013

TNR les catégories tiers consultés correspondent au service utilisateur
    [Documentation]  Test lors de l'ajout de la consultation d'un tiers,
    ...  si les catégories de tiers consultés affichées sont uniquement
    ...  celles liées au même service (collectivité) que celui 
    ...  du dossier d'instruction en cours
    
    Depuis la page d'accueil  admin  admin

    # Création d'un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TESTCATETIERSNOM
    ...  particulier_prenom=TESTCATETIERSPRENOM
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
   
    # Création et ajout du tiers
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  abrege=TNR_CATEGORIES_TIERS
    ...  libelle=Test catégories tiers et collectivités
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    
    # Vérification de l'absence d'une catégorie non référente au dossier en cours (ALLAUCH)
    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_consultation_tiers
    Wait Until Page Contains Element  css=select#categorie_tiers_consulte
    ${value_unexpected} =  Set Variable  ALLAUCH
    @{list_value_unexpected} =  Create List  Catégorie ${value_unexpected}
    ${demande_omc_select} =  Set Variable  css=div#form-content select#categorie_tiers_consulte

    Select List Should Not Contain List  ${demande_omc_select}  ${list_value_unexpected}


Constitution du jeu de données

    [Documentation]  Constitue le jeu de données.

    # Création de 3 tiers consulté et liaison avec des utilisateurs
    Depuis la page d'accueil  admin  admin

    &{lien_tiers_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Service consulté
    ...  tiers_consulte=1er tiers de Marseille
    Ajouter lien utilisateur / tiers consulté  ${lien_tiers_om_utilisateur}

    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  abrege=TM2
    ...  libelle=2ème tiers de Marseille
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    &{lien_tiers_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Service consulté 1
    ...  tiers_consulte=2ème tiers de Marseille
    Ajouter lien utilisateur / tiers consulté  ${lien_tiers_om_utilisateur}

    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  abrege=TM3
    ...  libelle=3ème tiers de Marseille
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    &{lien_tiers_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Service consulté
    ...  tiers_consulte=3ème tiers de Marseille
    Ajouter lien utilisateur / tiers consulté  ${lien_tiers_om_utilisateur}

    # Modification des 2 motifs existant pour les associer à Marseille et à l'agglo
    @{service} =  Create List  MARSEILLE
    &{args_motif} =  Create Dictionary
    ...  om_collectivite=${service}
    Modifier motif de consultation  Premier motif de consultation  ${args_motif}
    @{service} =  Create List  agglo
    &{args_motif} =  Create Dictionary
    ...  om_collectivite=${service}
    Modifier motif de consultation  Deuxième motif de consultation  ${args_motif}

    #
    # Supposition : ces dossiers sont affectés à l'instructeur "Louis Laurent"
    # (instr) division "H" même division que "Martine Nadeau" (instr1)
    #

    #
    &{args_petitionnaire_1} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=MARSEILLE
    #
    ${di_1} =  Ajouter la demande par WS  ${args_demande_1}  ${args_petitionnaire_1}
    Set Suite Variable  ${di_1}

    #
    Depuis la page d'accueil  instr  instr
    Ajouter une consultation depuis un dossier  ${di_1}  59.01 - Direction de l'Eau et de l'Assainissement

    #
    &{args_avis_consultation_1} =  Create Dictionary
    ...  avis_consultation=Favorable

    Depuis la page d'accueil  consu  consu
    #
    Rendre l'avis sur la consultation du dossier  ${di_1}  ${args_avis_consultation_1}
    #
    &{args_petitionnaire_3} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_3} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=01/04/2016
    ...  om_collectivite=MARSEILLE
    #
    ${di_3} =  Ajouter la demande par WS  ${args_demande_3}  ${args_petitionnaire_3}
    Set Suite Variable  ${di_3}

    &{args_petitionnaire_2} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=MARSEILLE
    #
    ${di_2} =  Ajouter la demande par WS  ${args_demande_2}  ${args_petitionnaire_2}
    Set Suite Variable  ${di_2}


    Depuis la page d'accueil  instr  instr
    Ajouter une consultation depuis un dossier  ${di_2}  59.01 - Direction de l'Eau et de l'Assainissement

    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    Depuis la page d'accueil  consu  consu
    Rendre l'avis sur la consultation du dossier  ${di_2}  ${args_avis_consultation}

    # Création de trois autres dossier mais dédiée aux tests des consultations des tiers
    # Création d'un dossier et ajout d'une consultation sur ce dossier
    &{args_petitionnaire_4} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    &{args_demande_4} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=MARSEILLE
    ${di_4} =  Ajouter la demande par WS  ${args_demande_4}  ${args_petitionnaire_4}
    Set Suite Variable  ${di_4}
    # Ajout d'une consultation sur ce dossier
    Depuis la page d'accueil  instr  instr
    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM3 - 3ème tiers de Marseille
    ...  motif_consultation=Premier motif de consultation
    Ajouter une consultation vers un tiers depuis un dossier  ${di_4}  ${tiers_1}
    # Retour d'avis sur cette consultation
    Depuis la page d'accueil  consu  consu
    &{args_avis_consultation_4} =  Create Dictionary
    ...  avis_consultation=Favorable
    Rendre l'avis sur la consultation du dossier  ${di_4}  ${args_avis_consultation_4}

    # Création d'un dossier et ajout d'une consultation sur ce dossier
    &{args_petitionnaire_5} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    &{args_demande_5} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=MARSEILLE
    ${di_5} =  Ajouter la demande par WS  ${args_demande_5}  ${args_petitionnaire_5}
    Set Suite Variable  ${di_5}
    Depuis la page d'accueil  instr  instr
    Ajouter une consultation vers un tiers depuis un dossier  ${di_5}  ${tiers_1}
    # Rendu de l'avis sur la consultation par le "service consulte"
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    Depuis la page d'accueil  consu  consu
    Rendre l'avis sur la consultation du dossier  ${di_5}  ${args_avis_consultation}

    # Création d'un 3ème dossier sans ajout de consultation
    &{args_petitionnaire_6} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    &{args_demande_6} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=01/04/2016
    ...  om_collectivite=MARSEILLE
    ${di_6} =  Ajouter la demande par WS  ${args_demande_6}  ${args_petitionnaire_6}
    Set Suite Variable  ${di_6}


Filtre des motifs de consultation
    [Documentation]  Test qu'un utilisateur appartenant à la collectivité de niveau 2
    ...  a accès, à l'ajout d'une consultation de tiers, à tous les motifs de consultation.
    ...  Test également qu'un utilisateur, n'appartennant pas à la collectivité de niveau 2,
    ...  a accès aux motifs liés à sa collectivité ou à la collectivité de niveau 2.

    Depuis la page d'accueil  admin  admin
    # Ajout d'un motif pour Allauch et d'un motif sans service associé
    @{service} =  Create List  ALLAUCH
    &{args_motif} =  Create Dictionary
    ...  code=M3
    ...  libelle=Motif Allauch
    ...  om_collectivite=${service}
    Ajouter motif de consultation  ${args_motif}
    &{args_motif} =  Create Dictionary
    ...  code=M4
    ...  libelle=Motif sans service
    Ajouter motif de consultation  ${args_motif}

    # Accès au formulaire d'ajout de consultation en tant qu'admin (coll niveau 2)
    # et validation du contenu de la liste des motifs
    Depuis le formulaire d'ajout d'une consultation vers un tiers sur un dossier  ${di_1}
    @{motifs} =  Create List  Premier motif de consultation  Deuxième motif de consultation  Motif Allauch  Motif sans service
    Select List Should Contain List  css=#motif_consultation  ${motifs}

    # Accès au formulaire d'ajout de consultation en tant qu'instr
    # et validation du contenu de la liste des motifs
    Depuis la page d'accueil  instr  instr
    Depuis le formulaire d'ajout d'une consultation vers un tiers sur un dossier  ${di_1}
    @{motifs} =  Create List  Premier motif de consultation  Deuxième motif de consultation
    Select List Should Contain List  css=#motif_consultation  ${motifs}
    @{motifs} =  Create List  Motif Allauch  Motif sans service
    Select List Should Not Contain List  css=#motif_consultation  ${motifs}


Ajout d'une consultation simple

    [Documentation]

    ##
    ## Constitution du jeu de données
    ##
    # Données du demandeur
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=DAINEAU Ets
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=MICHEL
    ...  personne_morale_prenom=Alain
    ...  om_collectivite=MARSEILLE
    # Données de la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=03/05/2016
    ...  om_collectivite=MARSEILLE
    # Données techniques du dossiers pour le tableau des surfaces
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
    # Ajout de la nouvelle demande pour création du DI
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # Saisie des données techniques sur le DI
    Depuis la page d'accueil  instr  instr
    Modifier les données techniques pour le calcul des surfaces  ${di}  ${donnees_techniques_values}

    ##
    ## Cas d'usage n°1
    ##
    ## Le principe ici est de tester l'ajout d'une consultation simple par un
    ## profil qui n'a pas les permissions de sélectionner la date d'envoi, les
    ## points clés testés sont :
    ##  - l'ajout de consultation simple est disponible
    ##  - le champ date d'envoi n'est pas présent
    ##  - le champ service est obligatoire
    ##  - un mail est envoyé au service
    ##  - le champ date d'envoi est positionné à la date du jour à l'enregistrement
    ##  - l'édition PDF est accessible et contient :
    ##    * le demandeur
    ##    * le total du calcul des surfaces
    ##    On en profite pour vérifier que l'envoi à plusieurs addresses e-mail fonctionne
    ##

    # Il faut mettre deux adresses séparées par un saut de ligne
    Depuis la page d'accueil  admin  admin
    &{args_service} =  Create Dictionary
    ...  email=test1@atreal.fr\ntest2@atreal.fr
    Modifier le service   59.01   Direction de l'Eau et de l'Assainissement  ${args_service}

    # On se connecte en tant que "instr" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  instr  instr
    # Définition du service dans ce cas d'usage - notification email configurée sur ce service
    ${service_1} =  Set Variable  59.01 - Direction de l'Eau et de l'Assainissement
    # On accède à l'onglet "Consultation(s)" du DI
    Depuis l'onglet consultation du dossier  ${di}
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 0 enregistrement(s) sur 0
    # On clique sur le lien "Ajouter" dans le listing
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter
    # On attend que le formulaire soit chargé correctement
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#service
    # En tant que Profil 'INSTRUCTEUR', le champ date d'envoi doit être caché
    Element Should Not Be Visible  css=#sformulaire #date_envoi
    # On valide le formulaire sans sélectionner de service
    Click On Submit Button In Subform Until Message  SAISIE NON ENREGISTRÉE
    # On vérifie que la soumission du formulaire est rejetée
    Error Message Should Contain In Subform  SAISIE NON ENREGISTRÉE
    # Le service est obligatoire
    Error Message Should Contain In Subform  Le champ Service est obligatoire
    # En tant que Profil 'INSTRUCTEUR', le champ date d'envoi doit être caché
    Element Should Not Be Visible  css=#sformulaire #date_envoi
    # On sélectionne le service
    Select From List By Label  css=#sformulaire #service  ${service_1}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie que la soumission du formulaire est validée
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées
    # On vérifie que le courriel de notification a été envoyé
    Valid Message Should Contain In Subform  Envoi d'un mail de notification au service
    # On retourne au listing
    Click On Back Button In Subform
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 1 enregistrement(s) sur 1

    Verifier que le mail a bien été envoyé au destinataire  test1@atreal.fr
    Vérifier le contenu du mail  test1@atreal.fr  Vous pouvez y accéder et rendre votre avis à l'adresse
    Verifier que le mail a bien été envoyé au destinataire  test2@atreal.fr

    Depuis la page d'accueil  instr  instr
    # On accède à la fiche de visualisation de la consultation créée
    Depuis le contexte de la consultation  ${di}  ${service_1}
    Portlet Action Should Not Be In SubForm  consultation  finalise
    # On définalise pour voir l'action de suppression
    Click On SubForm Portlet Action  consultation  unfinalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La définalisation du document s'est effectuée avec succès.
    Portlet Action Should Not Be In SubForm  rapport_instruction  unfinalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Be In SubForm  consultation  supprimer
    Click On SubForm Portlet Action  consultation  finalise
    # Vérification que la date d'envoi de la consultation est bien la date du jour
    Element Text Should Be  css=#sformulaire #date_envoi  ${date_ddmmyyyy}
    # On clique sur l'action édition
    Click On SubForm Portlet Action  consultation  consulter_pdf  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le champ de fusion
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  DAINEAU Ets représenté(e) par Monsieur MICHEL Alain
    # On vérifie le résultat total du tableau des surface
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Surface totale : 90
    # On ferme le PDF
    Close PDF

    # On vérifie le cas ou un des emails est en erreur
    Depuis la page d'accueil  admin  admin
    &{args_service} =  Create Dictionary
    ...  email=support_correct@atreal.fr\nemailerror2.atreal.fr
    Modifier le service   59.01   Direction de l'Eau et de l'Assainissement  ${args_service}

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#service
    Select From List By Label  css=#sformulaire #service  ${service_1}
    Click On Submit Button In Subform
    # On vérifie que la soumission du formulaire est validée
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées
    # On doit obtenir ce message précisant que les notification n'ont pas été envoyées
    Valid Message Should Contain In Subform  Erreur lors de l'envoi du mail de notification à au moins un destinataire du service

    Verifier que le mail a bien été envoyé au destinataire  support_correct@atreal.fr

    Supprimer la consultation depuis le contexte du dossier d'instruction  ${di}  ${service_1}

    # On vérifie le cas ou les emails sont en erreurs
    Depuis la page d'accueil  admin  admin
    &{args_service} =  Create Dictionary
    ...  email=emailerror1atreal.fr\nemailerror2.atreal.fr
    Modifier le service   59.01   Direction de l'Eau et de l'Assainissement  ${args_service}

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#service
    Select From List By Label  css=#sformulaire #service  ${service_1}
    Click On Submit Button In Subform
    # On vérifie que la soumission du formulaire est validée
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées
    # On doit obtenir ce message précisant que les notification n'ont pas été envoyées
    Valid Message Should Contain In Subform  Erreur lors de l'envoi du mail de notification aux destinataires du service

    Supprimer la consultation depuis le contexte du dossier d'instruction  ${di}  ${service_1}

    # On remet le mail par défaut sur le service
    Depuis la page d'accueil  admin  admin
    &{args_service} =  Create Dictionary
    ...  email=support@atreal.fr
    Modifier le service   59.01   Direction de l'Eau et de l'Assainissement  ${args_service}


    ##
    ## Cas d'usage n°2
    ##
    ## Le principe ici est de tester l'ajout d'une consultation simple par un
    ## profil qui a les permissions de sélectionner la date d'envoi, les
    ## points clés testés sont :
    ##  - l'ajout de consultation simple est disponible
    ##  - le champ date d'envoi est présent
    ##  - YYY le champ date d'envoi du formulaire est positionné à la date du jour
    ##  - un mail n'est pas envoyé au service
    ##  - le champ date d'envoi n'est pas positionné à la date du jour à l'enregistrement
    ##  - le délai est calculé correctement
    ##
    # On se connecte en tant que "admingen" (Profil 'ADMINISTRATEUR GENERAL')
    Depuis la page d'accueil  admingen  admingen
    # Définition du service dans ce cas d'usage
    # - pas de notification email configurée sur ce service
    # - délai 1 mois
    ${service_2} =  Set Variable  59.02 - Atelier du Patrimoine
    # On accède à l'onglet "Consultation(s)" du DI
    Depuis l'onglet consultation du dossier  ${di}
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 1 enregistrement(s) sur 1
    # On clique sur le lien "Ajouter" dans le listing
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter
    # On attend que le formulaire soit chargé correctement
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#service
    # En tant que Profil 'ADMINISTRATEUR GENERAL', le champ date d'envoi doit être affiché
    Element Should Be Visible  css=#sformulaire #date_envoi
    # On vérifie que la date du jour est pré-remplie dans le champs "date d'envoi"
    Form Value Should Be  css=#sformulaire #date_envoi  ${date_ddmmyyyy}
    # On sélectionne le service
    Select From List By Label  css=#sformulaire #service  ${service_2}
    # On vide le champ de date d'envoi
    Input Text  date_envoi  ${EMPTY}
    # On valide le formulaire sans sélectionner de date d'envoi
    Click On Submit Button In Subform Until Message  SAISIE NON ENREGISTRÉE
    # On vérifie que la soumission du formulaire est rejetée
    Error Message Should Contain In Subform  SAISIE NON ENREGISTRÉE
    # Le service est obligatoire
    Error Message Should Contain In Subform  Le champ date d'envoi est obligatoire
    # On positionne une date d'envoi
    Input Text  date_envoi  01/04/2016
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie que la soumission du formulaire est validée
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées
    # On vérifie qu'il n'y a pas eu de notification email
    Page Should Not Contain  Envoi d'un mail de notification au service
    # On vérifie que le calcul du délai est correct
    Valid Message Should Contain In Subform  Délai Retour 1 Mois -> Retour 01/05/2016
    # On retourne au listing
    Click On Back Button In Subform
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 2 enregistrement(s) sur 2
    # On accède à la fiche de visualisation de la consultation créée
    Depuis le contexte de la consultation  ${di}  ${service_2}
    # Vérification que la date d'envoi de la consultation est bien la date saisie
    Element Text Should Be  css=#sformulaire #date_envoi  01/04/2016
    # Vérification que la date limite de la consultation est bien la date saisie + 1 mois
    Element Text Should Be  css=#sformulaire #date_limite  01/05/2016

Ajout d'une consultation simple d'un tiers
    [Documentation]  Test l'ajout de la consultation d'un tiers, l'envoi des mails de
    ...  consultation aux adresses renseignées dans la liste de diffusion, la génération
    ...  du pdf de la consultation
    ...  Le déroulement du test est le même que celui du précédent test sauf que ce sont des
    ...  tiers qui sont consulté et pas des services

    # Ajout de la nouvelle demande pour création du DI
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=DAINEAU Ets
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=MICHEL
    ...  personne_morale_prenom=Alain
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=03/05/2016
    ...  om_collectivite=MARSEILLE
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
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # Saisie des données techniques sur le DI
    Depuis la page d'accueil  instr  instr
    Modifier les données techniques pour le calcul des surfaces  ${di}  ${donnees_techniques_values}

    # Définition du nom tiers utilisé dans les cas d'usage
    ${tiers} =  Set Variable  1er tiers de Marseille
    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM1 - 1er tiers de Marseille
    ...  motif_consultation=Premier motif de consultation

    ##
    ## Cas d'usage n°1
    ##
    ## Le principe ici est de tester l'ajout d'une consultation simple par un
    ## profil qui n'a pas les permissions de sélectionner la date d'envoi, les
    ## points clés testés sont :
    ##  - l'ajout de consultation simple est disponible
    ##  - le champ date d'envoi n'est pas présent
    ##  - le champ service est obligatoire
    ##  - un mail est envoyé à chaque adresse de la liste de diffusion
    ##  - le champ date d'envoi est positionné à la date du jour à l'enregistrement
    ##  - l'édition PDF est accessible et contient :
    ##    * le demandeur
    ##    * le total du calcul des surfaces
    ##    On en profite pour vérifier que l'envoi à plusieurs addresses e-mail fonctionne
    ##

    # Il faut mettre deux adresses séparées par un saut de ligne pour pouvoir
    # tester l'envoi de mail à toutes les adresses enregistrées
    Depuis la page d'accueil  admin  admin
    ${args_tiers_1.liste_diffusion} =  Set Variable  test1@atreal.fr\ntest2@atreal.fr
    Modifier le tiers consulte  ${tiers}  ${args_tiers_1}

    # On se connecte en tant que "instr" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  instr  instr
    # On accède à l'onglet "Consultation(s)" du DI
    Depuis l'onglet consultation du dossier  ${di}
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 0 enregistrement(s) sur 0
    # On clique sur le lien "Ajouter consultation de tiers" dans le listing
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_consultation_tiers
    # On attend que le formulaire soit chargé correctement
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#tiers_consulte
    # En tant que Profil 'INSTRUCTEUR', le champ date d'envoi doit être caché
    Element Should Not Be Visible  css=#sformulaire #date_envoi
    # On valide le formulaire sans sélectionner de catégorie de tiers, de tiers et de motif de consultation
    Click On Submit Button In Subform Until Message  SAISIE NON ENREGISTRÉE
    # Le tiers, sa catégorie et le motif de consultation sont obligatoires
    Error Message Should Contain In Subform  Le champ catégorie du tiers consulté est obligatoire
    Error Message Should Contain In Subform  Le champ tiers consulté est obligatoire
    Error Message Should Contain In Subform  Le champ motif de la consultation est obligatoire
    # En tant que Profil 'INSTRUCTEUR', le champ date d'envoi doit être caché
    Element Should Not Be Visible  css=#sformulaire #date_envoi
    # On sélectionne le tiers
    Select From List By Label  css=#sformulaire #categorie_tiers_consulte  ${tiers_1.categorie_tiers_consulte}
    Select From List By Label  css=#sformulaire #tiers_consulte  ${tiers_1.tiers_consulte}
    Select From List By Label  css=#sformulaire #motif_consultation  ${tiers_1.motif_consultation}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie que la soumission du formulaire est validée
    Valid Message Should Contain  Vos modifications ont bien été enregistrées
    # On vérifie que le courriel de notification a été envoyé
    Valid Message Should Contain  Envoi d'un mail de notification au tiers consulte
    # On retourne au listing
    Click On Back Button In SubForm
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 1 enregistrement(s) sur 1

    # On vérifie que les mails ont bien été envoyés à chaque adresse de la liste de diffusion
    Verifier que le mail a bien été envoyé au destinataire  test1@atreal.fr
    Verifier que le mail a bien été envoyé au destinataire  test2@atreal.fr

    # On teste la finalisation / definalisation de l'édition de la consultation
    Depuis la page d'accueil  instr  instr
    # On accède à la fiche de visualisation de la consultation créée
    Depuis le contexte de la consultation  ${di}  ${tiers_1.tiers_consulte}
    Portlet Action Should Not Be In SubForm  consultation  finalise
    # On définalise pour voir l'action de suppression
    Click On SubForm Portlet Action  consultation  unfinalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La définalisation du document s'est effectuée avec succès.
    Portlet Action Should Not Be In SubForm  rapport_instruction  unfinalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Be In SubForm  consultation  supprimer
    Click On SubForm Portlet Action  consultation  finalise
    # Vérification que la date d'envoi de la consultation est bien la date du jour
    Element Text Should Be  css=#sformulaire #date_envoi  ${date_ddmmyyyy}
    # On clique sur l'action édition
    Click On SubForm Portlet Action  consultation  consulter_pdf  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le champ de fusion
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  DAINEAU Ets représenté(e) par Monsieur MICHEL Alain
    # On vérifie le résultat total du tableau des surface
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Surface totale : 90
    # On ferme le PDF
    Close PDF

    # On vérifie le cas ou un des emails est en erreur
    # Dans ce cas le mail ayant une adresse ok doit être correctement envoyé
    # et le message d'erreur doit indiquer qu'il y a une adresse mail erronnée
    ${tiers} =  Set Variable  3ème tiers de Marseille
    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM3 - 3ème tiers de Marseille
    ...  motif_consultation=Premier motif de consultation

    Depuis la page d'accueil  admin  admin
    &{args_tiers} =  Create Dictionary
    ...  liste_diffusion=support_correct@atreal.fr\nemailerror2.atreal.fr
    Modifier le tiers consulte  ${tiers}  ${args_tiers}

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_consultation_tiers
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#tiers_consulte
    Select From List By Label  css=#sformulaire #categorie_tiers_consulte  ${tiers_1.categorie_tiers_consulte}
    Select From List By Label  css=#sformulaire #tiers_consulte  ${tiers_1.tiers_consulte}
    Select From List By Label  css=#sformulaire #motif_consultation  ${tiers_1.motif_consultation}
    Click On Submit Button In SubForm
    Valid Message Should Contain  Vos modifications ont bien été enregistrées

    # On doit obtenir ce message précisant que les notification n'ont pas été envoyées
    Valid Message Should Contain  Erreur lors de l'envoi du mail de notification à au moins un destinataire du tiers consulte
    # L'adresse correct doit recevoir le mail
    Verifier que le mail a bien été envoyé au destinataire  support_correct@atreal.fr

    Supprimer la consultation depuis le contexte du dossier d'instruction  ${di}  ${tiers_1.tiers_consulte}

    # On vérifie le cas ou tous les emails sont en erreurs
    Depuis la page d'accueil  admin  admin
    &{args_tiers} =  Create Dictionary
    ...  liste_diffusion=emailerror1atreal.fr\nemailerror2.atreal.fr
    Modifier le tiers consulte  ${tiers}  ${args_tiers}

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_consultation_tiers
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#tiers_consulte
    Select From List By Label  css=#sformulaire #categorie_tiers_consulte  ${tiers_1.categorie_tiers_consulte}
    Select From List By Label  css=#sformulaire #tiers_consulte  ${tiers_1.tiers_consulte}
    Select From List By Label  css=#sformulaire #motif_consultation  ${tiers_1.motif_consultation}
    Click On Submit Button In SubForm
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées
    # On doit obtenir ce message précisant que les notification n'ont pas été envoyées
    Valid Message Should Contain In Subform  Erreur lors de l'envoi du mail de notification aux destinataires du tiers consulte

    Supprimer la consultation depuis le contexte du dossier d'instruction  ${di}  ${tiers_1.tiers_consulte}

    # On remet le mail par défaut sur le tiers
    Depuis la page d'accueil  admin  admin
    &{args_tiers} =  Create Dictionary
    ...  liste_diffusion=support@atreal.fr
    Modifier le tiers consulte  ${tiers}  ${args_tiers}

    ##
    ## Cas d'usage n°2
    ##
    ## Le principe ici est de tester l'ajout d'une consultation simple par un
    ## profil qui a les permissions de sélectionner la date d'envoi, les
    ## points clés testés sont :
    ##  - l'ajout de consultation simple est disponible
    ##  - le champ date d'envoi est présent
    ##  - YYY le champ date d'envoi du formulaire est positionné à la date du jour
    ##  - un mail n'est pas envoyé au tiers
    ##  - le champ date d'envoi n'est pas positionné à la date du jour à l'enregistrement
    ##  - le délai est calculé correctement
    ##
    # On se connecte en tant que "admingen" (Profil 'ADMINISTRATEUR GENERAL')
    Depuis la page d'accueil  admingen  admingen
    # Définition du tiers dans ce cas d'usage
    # - pas de notification email configurée sur ce tiers
    # - délai 1 mois
    ${tiers_2} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM2 - 2ème tiers de Marseille
    ...  motif_consultation=Deuxième motif de consultation
    # On accède à l'onglet "Consultation(s)" du DI
    Depuis l'onglet consultation du dossier  ${di}
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 1 enregistrement(s) sur 1
    # On clique sur le lien "Ajouter" dans le listing
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_consultation_tiers
    # On attend que le formulaire soit chargé correctement
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#tiers_consulte
    # En tant que Profil 'ADMINISTRATEUR GENERAL', le champ date d'envoi doit être affiché
    Element Should Be Visible  css=#sformulaire #date_envoi
    # On vérifie que la date du jour est pré-remplie dans le champs "date d'envoi"
    Form Value Should Be  css=#sformulaire #date_envoi  ${date_ddmmyyyy}
    # On sélectionne la catégorie, le tiers et le motif de consultation
    Select From List By Label  css=#sformulaire #categorie_tiers_consulte  ${tiers_2.categorie_tiers_consulte}
    Select From List By Label  css=#sformulaire #tiers_consulte  ${tiers_2.tiers_consulte}
    Select From List By Label  css=#sformulaire #motif_consultation  ${tiers_2.motif_consultation}
    # On vide le champ de date d'envoi
    Input Text  date_envoi  ${EMPTY}
    # On valide le formulaire sans sélectionner de date d'envoi
    Click On Submit Button In Subform Until Message  SAISIE NON ENREGISTRÉE
    # On vérifie que la soumission du formulaire est rejetée
    Error Message Should Contain In Subform  SAISIE NON ENREGISTRÉE
    # Le tiers, sa catégorie et le motif de consultation sont obligatoires
    Error Message Should Contain In Subform  Le champ date d'envoi est obligatoire
    # On positionne une date d'envoi
    Input Text  date_envoi  01/04/2016
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie que la soumission du formulaire est validée
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées
    # On vérifie qu'il n'y a pas eu de notification email
    Page Should Not Contain  Envoi d'un mail de notification au service
    # On vérifie que le calcul du délai est correct
    Valid Message Should Contain In Subform  Délai Retour 1 Mois -> Retour 01/05/2016
    # On retourne au listing
    Click On Back Button In Subform
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 2 enregistrement(s) sur 2
    # On accède à la fiche de visualisation de la consultation créée
    Depuis le contexte de la consultation  ${di}  ${tiers_2.tiers_consulte}
    # Vérification que la date d'envoi de la consultation est bien la date saisie
    Element Text Should Be  css=#sformulaire #date_envoi  01/04/2016
    # Vérification que la date limite de la consultation est bien la date saisie + 1 mois
    Element Text Should Be  css=#sformulaire #date_limite  01/05/2016



Ajout d'une consultation multiple

    [Documentation]

    ##
    ## Constitution du jeu de données
    ##
    # Données du demandeur
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bourgeau
    ...  particulier_prenom=Aurore
    ...  om_collectivite=MARSEILLE
    # Données de la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=08/04/2016
    ...  om_collectivite=MARSEILLE

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    ##
    ## Cas d'usage n°1
    ##
    ## Le principe ici est de tester l'ajout d'une consultation multiple par un
    ## profil qui n'a pas les permissions de sélectionner la date d'envoi, les
    ## points clés testés sont :
    ##  - l'ajout de consultation multiple est disponible
    ##  - le champ date d'envoi n'est pas présent
    ##  - il est obligatoire de sélectionner au moins un service
    ##  - l'interface de sélection/désélection de services fonctionne
    ##  - le champ date d'envoi est positionné à la date du jour à l'enregistrement
    ##  - l'option version papier génère un PDF multiple
    ##  - l'édition PDF est accessible et contient :
    ##    * une page par consultation
    ##    * le demandeur sur chaque page
    ##
    # On se connecte en tant que "instr" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  instr  instr
    # On accède à l'onglet "Consultation(s)" du DI
    Depuis l'onglet consultation du dossier  ${di}
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 0 enregistrement(s) sur 0
    # On clique sur le lien "Ajouter multiples" dans le tableau
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_multiple
    # On attend que le formulaire soit chargé correctement
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  button_val
    # En tant que Profil 'INSTRUCTEUR', le champ date d'envoi doit être caché
    Element Should Not Be Visible  css=#sformulaire #date_envoi
    # On clique sur le bouton "Ajouter" du formulaire sans sélectionner de service
    Click Element  button_val
    # On vérifie qu'une alerte javascript nous indique qu'il y a une erreur de saisie
    ${alert} =  Handle Alert
    Should Be Equal As Strings  ${alert}  Veuillez choisir au moins un service et une date d envoi
    # En tant que Profil 'INSTRUCTEUR', le champ date d'envoi doit être caché
    Element Should Not Be Visible  date_envoi
    # On sélectionne quatre services
    Click Element  t10_572_0_
    ${status} =  Run Keyword And Return Status  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#t10_572_0_.liste_gauche_service_selected
    Run Keyword If  ${status} == False  Click Element  t10_572_0_
    Click Element  t10_575_0_
    Click Element  t2_13_0_
    Click Element  t10_542_0_
    # On les ajoute à la sélection
    Click Element  add-ser-them
    # On sélectionne un des services sélectionnés
    Click Element  css=div[name="t10_542_0_"]
    # On l'enlève de la sélection
    Click Element  del-ser-them
    # On coche la case pour la consultation papier pour deux des services
    Select Checkbox  css=div.cell2 > div > input.t10_575_0_
    Select Checkbox  css=div.cell2 > div > input.t10_572_0_
    # On clique sur le bouton "Ajouter" du formulaire
    Click Element  button_val
    # On vérifie qu'il n'y a pas d'erreur sur l'élément affiché
    La page ne doit pas contenir d'erreur
    # Le PDF s'ouvre tout seul, on sélectionne la bonne fenêtre
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie que le PDF a bien deux pages
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  PDF Pages Number Should Be  2
    # Et que le nom du pétitionnaire est bien remplacé sur chaque page
    PDF Page Number Should Contain  1  Bourgeau Aurore
    PDF Page Number Should Contain  2  Bourgeau Aurore
    # On ferme le PDF
    Close PDF
    # On vérifie que le message de validation est présent avec le bon nombre de consultations
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  3 service(s) sélectionné(s) dont 2 consultation(s) papier.
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 3 enregistrement(s) sur 3
    # On accède à la fiche de visualisation de la consultation créée
    Depuis le contexte de la consultation  ${di}  59.88 - DAE - COMMERCE ARTISANAT
    # Vérification que la date d'envoi de la consultation est bien la date du jour
    Element Text Should Be  date_envoi  ${date_ddmmyyyy}

    ##
    ## Cas d'usage n°2
    ##
    ## Le principe ici est de tester l'ajout d'une consultation multiple par un
    ## profil qui a les permissions de sélectionner la date d'envoi, les
    ## points clés testés sont :
    ##  - l'ajout de consultation multiple est disponible
    ##  - le champ date d'envoi est présent
    ##  - le champ date d'envoi du formulaire est positionné à la date du jour
    ##  - le champ date d'envoi n'est pas positionné à la date du jour à l'enregistrement
    ##
    # On se connecte en tant que "admingen" (Profil 'ADMINISTRATEUR GENERAL')
    Depuis la page d'accueil  admingen  admingen
    # On accède à l'onglet "Consultation(s)" du DI
    Depuis l'onglet consultation du dossier  ${di}
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 3 enregistrement(s) sur 3
    # On clique sur le lien "Ajouter multiples" dans le tableau
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_multiple
    # On attend que le formulaire soit chargé correctement
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  button_val
    # En tant que Profil 'ADMINISTRATEUR GENERAL', le champ date d'envoi doit être affiché
    Element Should Be Visible  css=#sformulaire #date_envoi
    # On vérifie que la date du jour est pré-remplie dans le champs "date d'envoi"
    Form Value Should Be  css=#sformulaire #date_envoi  ${date_ddmmyyyy}
    # Service 59.12 - Direction de la Propreté Urbaine
    Click Element  t10_12_0_
    # Service 59.30 - Orange France
    Click Element  t10_15_0_
    # On les ajoute à la sélection
    Click Element  add-ser-them
    # Input de la date en JavaScript pour éviter l'appel au onChange sur ce
    # champ, qui appelle une fonction JS fonctionnant une fois sur deux dans
    # les tests
    Input Value With JS  date_envoi  01/04/2016
    # On clique sur le bouton "Ajouter" du formulaire
    Click Element  button_val
    # On vérifie qu'il n'y a pas d'erreur sur l'élément affiché
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  2 service(s) sélectionné(s) dont 0 consultation(s) papier.
    # On vérifie que nous avons bien le bon nombre de consultations affichées
    Element Should Contain  css=#sousform-consultation .pagination-text  1 - 5 enregistrement(s) sur 5
    # On accède à la fiche de visualisation de la consultation créée
    Depuis le contexte de la consultation  ${di}  59.12 - Direction de la Propreté Urbaine
    # Vérification que la date d'envoi de la consultation est bien la date saisie
    Element Text Should Be  date_envoi  01/04/2016


Gestion des retours de consultation depuis la rubrique 'Instruction'

    [Documentation]

    ##
    ## Constitution du jeu de données
    ##
    ## On cré trois deux nouvelles collectivités pour être sûr du nombre
    ## de retours de consultations à vérifier dans les widgets et tableaux
    ##
    #

    # On enregistre le nom du widget qui sera utilisé dans le tests
    ${om_widget} =  Set Variable  consultation_retours

    Depuis la page d'accueil  admin  admin
    # collectivité 01 'WORKINGTON' de niveau 1
    Ajouter la collectivité depuis le menu  WORKINGTON  mono

    Ajouter l'utilisateur  Carter SANCHEZ  nospam@openmairie.org  csanchez  csanchez  INSTRUCTEUR  WORKINGTON
    Ajouter la direction depuis le menu  WKT  Direction WKT  null  Chef WKT  null  null  WORKINGTON
    Ajouter la division depuis le menu  WTH  subdivision WTH  null  Chef WKT  null  null  Direction WKT
    Ajouter la division depuis le menu  WTJ  subdivision WTJ  null  Chef WKT  null  null  Direction WKT
    Ajouter l'instructeur depuis le menu  Carter SANCHEZ  subdivision WTH  instructeur  Carter SANCHEZ

    # Création d'un instructeur qui sera affecté comme instructeur secondaire des dossiers
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire_cr
    Ajouter l'utilisateur
    ...  ${instructeur_secondaire_login}
    ...  nospam@openmairie.org
    ...  ${instructeur_secondaire_login}
    ...  ${instructeur_secondaire_login}
    ...  INSTRUCTEUR
    ...  WORKINGTON
    Ajouter l'instructeur depuis le menu 
    ...  ${instructeur_secondaire_login}
    ...  subdivision WTH
    ...  instructeur
    ...  ${instructeur_secondaire_login}

    &{args_affectation} =  Create Dictionary
    ...  instructeur=Carter SANCHEZ (WTH)
    ...  instructeur_2=${instructeur_secondaire_login} (WTH)
    ...  om_collectivite=WORKINGTON
    Ajouter l'affectation depuis le menu  ${args_affectation}
    #
    Ajouter l'utilisateur  Selma SAUNDERS  nospam@openmairie.org  ssaunders  ssaunders  INSTRUCTEUR  WORKINGTON
    Ajouter l'instructeur depuis le menu  Selma SAUNDERS  subdivision WTH  instructeur  Selma SAUNDERS
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Selma SAUNDERS (WTH)
    ...  instructeur_2=${instructeur_secondaire_login} (WTH)
    ...  om_collectivite=WORKINGTON
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    Ajouter l'affectation depuis le menu  ${args_affectation}
    #
    Ajouter l'utilisateur  Harriet SANTIAGO  nospam@openmairie.org  hsantiago  hsantiago  INSTRUCTEUR  WORKINGTON
    Ajouter l'instructeur depuis le menu  Harriet SANTIAGO  subdivision WTJ  instructeur  Harriet SANTIAGO
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Harriet SANTIAGO (WTJ)
    ...  om_collectivite=WORKINGTON
    ...  dossier_autorisation_type_detaille=Permis de démolir
    Ajouter l'affectation depuis le menu  ${args_affectation}
    #
    Ajouter l'utilisateur  Alden SYKES  nospam@openmairie.org  asykes  asykes  SERVICE CONSULTÉ  WORKINGTON
    &{service} =  Create Dictionary
    ...  abrege=95A
    ...  libelle=Direction de la circulation de Workington
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=WORKINGTON
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    &{lien_service_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Alden SYKES
    ...  service=Direction de la circulation de Workington
    Ajouter lien service/utilisateur  ${lien_service_om_utilisateur}
    # collectivité 02 'LIDINGO' de niveau 1
    Ajouter la collectivité depuis le menu  LIDINGO  mono
    #
    Ajouter l'utilisateur  Mary JOYCE  nospam@openmairie.org  mjoyce  mjoyce  INSTRUCTEUR  LIDINGO
    Ajouter la direction depuis le menu  LDG  Direction LDG  null  Chef LDG  null  null  LIDINGO
    Ajouter la division depuis le menu  LDG  subdivision LDG  null  Chef LDG  null  null  Direction LDG
    Ajouter l'instructeur depuis le menu  Mary JOYCE  subdivision LDG  instructeur  Mary JOYCE
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Mary JOYCE (LDG)
    ...  om_collectivite=LIDINGO
    Ajouter l'affectation depuis le menu  ${args_affectation}

    #
    Ajouter l'utilisateur  Alexandra TERRELL  nospam@openmairie.org  aterrell  aterrell  SERVICE CONSULTÉ  LIDINGO
    &{service} =  Create Dictionary
    ...  abrege=96A
    ...  libelle=Direction de la circulation de Lidingo
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=LIDINGO
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    &{lien_service_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Alexandra TERRELL
    ...  service=Direction de la circulation de Lidingo
    Ajouter lien service/utilisateur  ${lien_service_om_utilisateur}
    #
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    # DI n°1 :
    # - Collectivité 'WORKINGTON' (niveau mono)
    # - Instructeur 'Harriet SANTIAGO' (hsantiago)
    # - Division 'J'
    #
    &{args_petitionnaire_01} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=WORKINGTON
    #
    &{args_demande_01} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=WORKINGTON
    #
    ${di_01} =  Ajouter la demande par WS  ${args_demande_01}  ${args_petitionnaire_01}
    # DI n°2 :
    # - Collectivité 'WORKINGTON' (niveau mono)
    # - Instructeur 'Carter SANCHEZ' (csanchez)
    # - Division 'H'
    #
    &{args_petitionnaire_02} =  Create Dictionary
    ...  particulier_nom=VACHIER
    ...  particulier_prenom=Arthur
    ...  om_collectivite=WORKINGTON
    #
    &{args_demande_02} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=WORKINGTON
    #
    ${di_02} =  Ajouter la demande par WS  ${args_demande_02}  ${args_petitionnaire_02}
    # DI n°3 :
    # - Collectivité 'WORKINGTON' (niveau mono)
    # - Instructeur 'Selma SAUNDERS' (ssaunders)
    # - Division 'H'
    #
    &{args_petitionnaire_03} =  Create Dictionary
    ...  particulier_nom=BRAY
    ...  particulier_prenom=Guy
    ...  om_collectivite=WORKINGTON
    #
    &{args_demande_03} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=WORKINGTON
    #
    ${di_03} =  Ajouter la demande par WS  ${args_demande_03}  ${args_petitionnaire_03}
    # DI n°4 :
    # - Collectivité 'LIDINGO' (niveau mono)
    # - Instructeur 'Mary JOYCE' (mjoyce)
    # - Division 'H'
    #
    &{args_petitionnaire_04} =  Create Dictionary
    ...  particulier_nom=BOULAGE
    ...  particulier_prenom=Damien
    ...  om_collectivite=LIDINGO
    #
    &{args_demande_04} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=LIDINGO
    #
    ${di_04} =  Ajouter la demande par WS  ${args_demande_04}  ${args_petitionnaire_04}
    #
    Ajouter une consultation depuis un dossier  ${di_01}  95A - Direction de la circulation de Workington
    Ajouter une consultation depuis un dossier  ${di_02}  95A - Direction de la circulation de Workington
    Ajouter une consultation depuis un dossier  ${di_03}  95A - Direction de la circulation de Workington
    Ajouter une consultation depuis un dossier  ${di_04}  96A - Direction de la circulation de Lidingo
    #
    Depuis la page d'accueil  asykes  asykes

    Rendre l'avis sur la consultation du dossier  ${di_01}  ${args_avis_consultation}
    Rendre l'avis sur la consultation du dossier  ${di_02}  ${args_avis_consultation}
    Rendre l'avis sur la consultation du dossier  ${di_03}  ${args_avis_consultation}
    #
    Depuis la page d'accueil  aterrell  aterrell
    Rendre l'avis sur la consultation du dossier  ${di_04}  ${args_avis_consultation}
    #

    ##
    ## Cas d'usage n°1
    ##
    ##
    ##
    #
    ${widget_id} =  Set Variable  widget_3

    # On se connecte en tant que utilisateur de niveau 2
    Depuis la page d'accueil  admin  admin
    # On vérifie qu'on a la collonne collectivité dans le listing tous les retours
    Go To Submenu In Menu  instruction  consultation_tous_retours
    Page Title Should Be  Instruction > Consultations > Tous Les Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans toutes les collectivités.
    Element Should Contain  css=#tab-consultation_tous_retours table thead  instructeur
    Element Should Contain  css=#tab-consultation_tous_retours table thead  division
    Element Should Contain  css=#tab-consultation_tous_retours table thead  collectivité
    # On va sur le listing 'Tous les retours'
    # Il doit contenir des retours des deux collectivités
    Element Should Contain  css=#tab-consultation_tous_retours table  WORKINGTON
    Element Should Contain  css=#tab-consultation_tous_retours table  LIDINGO

    # On se connecte en tant que "csanchez" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  csanchez  csanchez
    # On vérifie que les consultations apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  1
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Mes retours'
    # Il ne doit contenir qu'un seul retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Submenu In Menu Should Be Selected  instruction  consultation_mes_retours
    Page Title Should Be  Instruction > Consultations > Mes Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction dont je suis l'instructeur.
    Element Should Contain  css=#tab-consultation_mes_retours .pagination-text  1 - 1 enregistrement(s) sur 1
    # On va sur le listing 'Retours de ma division'
    # Il doit contenir deux retours
    Go To Submenu In Menu  instruction  consultation_retours_ma_division
    Page Title Should Be  Instruction > Consultations > Retours De Ma Division
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma division.
    Element Should Contain  css=#tab-consultation_retours_ma_division .pagination-text  1 - 2 enregistrement(s) sur 2
    Element Should Contain  css=#tab-consultation_retours_ma_division table  Selma SAUNDERS
    # On va sur le listing 'Tous les retours'
    # Il doit contenir trois retours
    Go To Submenu In Menu  instruction  consultation_tous_retours
    Page Title Should Be  Instruction > Consultations > Tous Les Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma collectivité.
    Element Should Contain  css=#tab-consultation_tous_retours .pagination-text  1 - 3 enregistrement(s) sur 3

    # Filtre sur la division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=division
    ...  ${om_widget}

    # On se connecte en tant que "csanchez" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  csanchez  csanchez
    # On vérifie que les consultations apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  2
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Retours de ma division'
    # Il doit contenir deux retours
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Submenu In Menu Should Be Selected  instruction  consultation_retours_ma_division
    Page Title Should Be  Instruction > Consultations > Retours De Ma Division
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma division.
    Element Should Contain  css=#tab-consultation_retours_ma_division .pagination-text  1 - 2 enregistrement(s) sur 2

    # Aucun filtre
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=aucun
    ...  ${om_widget}

    # On se connecte en tant que "csanchez" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  csanchez  csanchez
    # On vérifie que les consultations apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  3
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Tous les retours'
    # Il doit contenir trois retours
    Submenu In Menu Should Be Selected  instruction  consultation_tous_retours
    Page Title Should Be  Instruction > Consultations > Tous Les Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma collectivité.
    Element Should Contain  css=#tab-consultation_tous_retours .pagination-text  1 - 3 enregistrement(s) sur 3

    # Filtre sur l'instructeur secondaire
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur_secondaire
    ...  ${om_widget}

    # L'instructeur ne dois pas avoir de résultats sur son tableau de bord
    Depuis la page d'accueil  csanchez  csanchez
    Element Should Contain  css=#${widget_id} .widget-content-wrapper  Aucun retour de consultation non lu.

    # L'instructeur secondaire doit voir toutes les consultations des dossiers sur
    # lequel il est affecté
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  2
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Mes Retours'
    Submenu In Menu Should Be Selected  instruction  consultation_mes_retours
    Page Title Should Be  Instruction > Consultations > Mes Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction dont je suis l'instructeur secondaire.
    Element Should Contain  css=#tab-consultation_mes_retours .pagination-text  1 - 2 enregistrement(s) sur 2


    # Filtre sur l'instructeur
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur
    ...  ${om_widget}

    # On se connecte en tant que Profil 'INSTRUCTEUR'
    Depuis la page d'accueil  mjoyce  mjoyce
    # On vérifie que les consultations apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  1
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # On clique sur le lien "59.01 Direction de l'Eau et de l'Assainissement" dans le tableau
    Click Link  ${di_04}
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#sousform-consultation #service
    #
    Page Title Should Contain  ${di_04}
    Page Title Should Contain  BOULAGE DAMIEN

    #
    Portlet Action Should Be In SubForm  consultation  marquer_comme_lu
    #
    Click On SubForm Portlet Action  consultation  marquer_comme_lu
    #
    Valid Message Should Contain In Subform  La consultation a été marquée comme lu

    Portlet Action Should Not Be In SubForm  consultation  supprimer
    #
    Depuis la page d'accueil  mjoyce  mjoyce
    #
    # On vérifie que lorsqu'il n'y a aucune consultation, un message dans le widget 'Retours de consultation'
    # l'indique et que le lien Voir + n'est pas présent
    #
    Element Should Contain  css=#${widget_id} .widget-content-wrapper  Aucun retour de consultation non lu.
    Element Should Not Contain  css=#${widget_id}  Voir +

    #
    # On clique sur les trois listings liés pour vérifier qu'il n'y a aucun résultat
    #
    Go To Submenu In Menu  instruction  consultation_mes_retours
    Page Title Should Be  Instruction > Consultations > Mes Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction dont je suis l'instructeur.
    Element Should Contain  css=#tab-consultation_mes_retours .pagination-text  1 - 0 enregistrement(s) sur 0
    Element Should Not Contain  css=#tab-consultation_mes_retours table thead  instructeur
    Element Should Not Contain  css=#tab-consultation_mes_retours table thead  division
    Element Should Not Contain  css=#tab-consultation_mes_retours table thead  collectivité
    #
    Go To Submenu In Menu  instruction  consultation_retours_ma_division
    Page Title Should Be  Instruction > Consultations > Retours De Ma Division
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma division.
    Element Should Contain  css=#tab-consultation_retours_ma_division .pagination-text  1 - 0 enregistrement(s) sur 0
    Element Should Contain  css=#tab-consultation_retours_ma_division table thead  instructeur
    Element Should Not Contain  css=#tab-consultation_retours_ma_division table thead  division
    Element Should Not Contain  css=#tab-consultation_retours_ma_division table thead  collectivité
    #
    Go To Submenu In Menu  instruction  consultation_tous_retours
    Page Title Should Be  Instruction > Consultations > Tous Les Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma collectivité.
    Element Should Contain  css=#tab-consultation_tous_retours .pagination-text  1 - 0 enregistrement(s) sur 0
    Element Should Contain  css=#tab-consultation_tous_retours table thead  instructeur
    Element Should Contain  css=#tab-consultation_tous_retours table thead  division
    Element Should Not Contain  css=#tab-consultation_tous_retours table thead  collectivité

Gestion des retours de consultation de tiers depuis la rubrique 'Instruction'

    [Documentation]

    ##
    ## Constitution du jeu de données
    ##
    ## On créé deux nouvelles collectivités pour être sûr du nombre
    ## de retours de consultations à vérifier dans les widgets et tableaux
    ##
    #
    # On enregistre le nom du widget qui sera utilisé dans le tests
    ${om_widget} =  Set Variable  consultation_retours
    Depuis la page d'accueil  admin  admin
    # paramétrage de la collectivité 01 'WORKINGTON' de niveau 1
    Ajouter la collectivité depuis le menu  TIERSTON  mono
    Ajouter l'utilisateur  Gaspar DOUFFET  nospam@openmairie.org  gdouffet  gdouffet  INSTRUCTEUR  TIERSTON
    Ajouter la direction depuis le menu  TRT  Direction TRT  null  Chef TRT  null  null  TIERSTON
    Ajouter la division depuis le menu  TRTO  subdivision TRTO  null  Chef TRT  null  null  Direction TRT
    Ajouter la division depuis le menu  TRTP  subdivision TRTP  null  Chef TRT  null  null  Direction TRT
    Ajouter l'instructeur depuis le menu  Gaspar DOUFFET  subdivision TRTO  instructeur  Gaspar DOUFFET
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Gaspar DOUFFET (TRTO)
    ...  om_collectivite=TIERSTON
    Ajouter l'affectation depuis le menu  ${args_affectation}
    #
    Ajouter l'utilisateur  Calandre GRIGNON  nospam@openmairie.org  cgrignon  cgrignon  INSTRUCTEUR  TIERSTON
    Ajouter l'instructeur depuis le menu  Calandre GRIGNON  subdivision TRTO  instructeur  Calandre GRIGNON
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Calandre GRIGNON (TRTO)
    ...  om_collectivite=TIERSTON
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    Ajouter l'affectation depuis le menu  ${args_affectation}
    #
    Ajouter l'utilisateur  Amabella ROCHON  nospam@openmairie.org  arochon  arochon  INSTRUCTEUR  TIERSTON
    Ajouter l'instructeur depuis le menu  Amabella ROCHON  subdivision TRTP  instructeur  Amabella ROCHON
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Amabella ROCHON (TRTP)
    ...  om_collectivite=TIERSTON
    ...  dossier_autorisation_type_detaille=Permis de démolir
    Ajouter l'affectation depuis le menu  ${args_affectation}
    #
    Ajouter l'utilisateur  Thomas GARCEAU  nospam@openmairie.org  tgarceau  tgarceau  SERVICE CONSULTÉ  TIERSTON
    # Ajout d'un nouveau tiers consulté avec sa catégorie et un motif de consultation associé
    ${om_collectivite_tier} =  Create List
    ...  TIERSTON
    &{args_cat_tiers} =  Create Dictionary
    ...  code=CW
    ...  description=Tiers de TIERSTON
    ...  libelle=Catégorie de TIERSTON
    ...  om_collectivite=${om_collectivite_tier}
    Ajouter la categorie de tiers consulte  ${args_cat_tiers}
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie de TIERSTON
    ...  abrege=TW
    ...  libelle=Tiers de la circulation de TIERSTON
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    &{args_motif_consultation} =  Create Dictionary
    ...  code=MW
    ...  description=Motif de TIERSTON
    ...  abrege=Consultation - Demande d'avis
    ...  libelle=Motif de consultation de TIERSTON
    ...  om_etat=Consultation - Demande d'avis
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter motif de consultation  ${args_motif_consultation}

    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie de TIERSTON
    ...  tiers_consulte=TW - Tiers de la circulation de TIERSTON
    ...  motif_consultation=Motif de consultation de TIERSTON

    &{lien_tiers_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Thomas GARCEAU
    ...  tiers_consulte=Tiers de la circulation de TIERSTON
    Ajouter lien utilisateur / tiers consulté  ${lien_tiers_om_utilisateur}

    # paramétrage de la collectivité 02 'BELFORT' de niveau 1
    Ajouter la collectivité depuis le menu  BELFORT  mono
    #
    Ajouter l'utilisateur  Josephine PETIT  nospam@openmairie.org  jpetit  jpetit  INSTRUCTEUR  BELFORT
    Ajouter la direction depuis le menu  BLF  Direction BLF  null  Chef BLF  null  null  BELFORT
    Ajouter la division depuis le menu  BLF  subdivision BLF  null  Chef BLF  null  null  Direction BLF
    Ajouter l'instructeur depuis le menu  Josephine PETIT  subdivision BLF  instructeur  Josephine PETIT
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Josephine PETIT (BLF)
    ...  om_collectivite=BELFORT
    Ajouter l'affectation depuis le menu  ${args_affectation}

    #
    Ajouter l'utilisateur  France PITRE  nospam@openmairie.org  fpitre  fpitre  SERVICE CONSULTÉ  BELFORT
    ${om_collectivite_tier} =  Create List
    ...  BELFORT
    &{args_cat_tiers} =  Create Dictionary
    ...  code=CL
    ...  description=Tiers de BELFORT
    ...  libelle=Catégorie de BELFORT
    ...  om_collectivite=${om_collectivite_tier}
    Ajouter la categorie de tiers consulte  ${args_cat_tiers}
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie de BELFORT
    ...  abrege=TL
    ...  libelle=Tiers de la circulation de BELFORT
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    &{args_motif_consultation} =  Create Dictionary
    ...  code=MW
    ...  description=Motif de BELFORT
    ...  abrege=Consultation - Demande d'avis
    ...  libelle=Motif de consultation de BELFORT
    ...  om_etat=Consultation - Demande d'avis
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter motif de consultation  ${args_motif_consultation}

    ${tiers_2} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie de BELFORT
    ...  tiers_consulte=TL - Tiers de la circulation de BELFORT
    ...  motif_consultation=Motif de consultation de BELFORT

    &{lien_tiers_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=France PITRE
    ...  tiers_consulte=Tiers de la circulation de BELFORT
    Ajouter lien utilisateur / tiers consulté  ${lien_tiers_om_utilisateur}
    #
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    # DI n°1 :
    # - Collectivité 'TIERSTON' (niveau mono)
    # - Instructeur 'Amabella ROCHON' (arochon)
    # - Division 'J'
    #
    &{args_petitionnaire_01} =  Create Dictionary
    ...  particulier_nom=DUBE
    ...  particulier_prenom=Genevre
    ...  om_collectivite=TIERSTON
    &{args_demande_01} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=TIERSTON
    ${di_01} =  Ajouter la demande par WS  ${args_demande_01}  ${args_petitionnaire_01}

    # DI n°2 :
    # - Collectivité 'TIERSTON' (niveau mono)
    # - Instructeur 'Gaspar DOUFFET' (gdouffet)
    # - Division 'H'
    &{args_petitionnaire_02} =  Create Dictionary
    ...  particulier_nom=VACHIER
    ...  particulier_prenom=Arthur
    ...  om_collectivite=TIERSTON
    &{args_demande_02} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=TIERSTON
    ${di_02} =  Ajouter la demande par WS  ${args_demande_02}  ${args_petitionnaire_02}

    # DI n°3 :
    # - Collectivité 'TIERSTON' (niveau mono)
    # - Instructeur 'Calandre GRIGNON' (cgrignon)
    # - Division 'H'
    &{args_petitionnaire_03} =  Create Dictionary
    ...  particulier_nom=BRAY
    ...  particulier_prenom=Guy
    ...  om_collectivite=TIERSTON
    &{args_demande_03} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=TIERSTON
    ${di_03} =  Ajouter la demande par WS  ${args_demande_03}  ${args_petitionnaire_03}

    # DI n°4 :
    # - Collectivité 'BELFORT' (niveau mono)
    # - Instructeur 'Josephine PETIT' (jpetit)
    # - Division 'H'
    &{args_petitionnaire_04} =  Create Dictionary
    ...  particulier_nom=BOULAGE
    ...  particulier_prenom=Damien
    ...  om_collectivite=BELFORT
    &{args_demande_04} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=BELFORT
    ${di_04} =  Ajouter la demande par WS  ${args_demande_04}  ${args_petitionnaire_04}
    #
    Ajouter une consultation vers un tiers depuis un dossier  ${di_01}  ${tiers_1}
    Ajouter une consultation vers un tiers depuis un dossier  ${di_02}  ${tiers_1}
    Ajouter une consultation vers un tiers depuis un dossier  ${di_03}  ${tiers_1}
    Ajouter une consultation vers un tiers depuis un dossier  ${di_04}  ${tiers_2}

    Depuis la page d'accueil  tgarceau  tgarceau

    Rendre l'avis sur la consultation du dossier  ${di_01}  ${args_avis_consultation}
    Rendre l'avis sur la consultation du dossier  ${di_02}  ${args_avis_consultation}
    Rendre l'avis sur la consultation du dossier  ${di_03}  ${args_avis_consultation}

    Depuis la page d'accueil  fpitre  fpitre
    Rendre l'avis sur la consultation du dossier  ${di_04}  ${args_avis_consultation}

    ##
    ## Cas d'usage n°1
    ##
    ##
    ##
    #
    ${widget_id} =  Set Variable  widget_3

    # On se connecte en tant que utilisateur de niveau 2
    Depuis la page d'accueil  admin  admin
    # On vérifie qu'on a la collonne collectivité dans le listing tous les retours
    Go To Submenu In Menu  instruction  consultation_tous_retours
    Page Title Should Be  Instruction > Consultations > Tous Les Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans toutes les collectivités.
    Element Should Contain  css=#tab-consultation_tous_retours table thead  instructeur
    Element Should Contain  css=#tab-consultation_tous_retours table thead  division
    Element Should Contain  css=#tab-consultation_tous_retours table thead  collectivité
    # On va sur le listing 'Tous les retours'
    # Il doit contenir des retours des deux collectivités
    Element Should Contain  css=#tab-consultation_tous_retours table  TIERSTON
    Element Should Contain  css=#tab-consultation_tous_retours table  BELFORT

    # On se connecte en tant que "gdouffet" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  gdouffet  gdouffet
    # On vérifie que les consultations apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  1
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Mes retours'
    # Il ne doit contenir qu'un seul retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Submenu In Menu Should Be Selected  instruction  consultation_mes_retours
    Page Title Should Be  Instruction > Consultations > Mes Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction dont je suis l'instructeur.
    Element Should Contain  css=#tab-consultation_mes_retours .pagination-text  1 - 1 enregistrement(s) sur 1
    # On va sur le listing 'Retours de ma division'
    # Il doit contenir deux retours
    Go To Submenu In Menu  instruction  consultation_retours_ma_division
    Page Title Should Be  Instruction > Consultations > Retours De Ma Division
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma division.
    Element Should Contain  css=#tab-consultation_retours_ma_division .pagination-text  1 - 2 enregistrement(s) sur 2
    Element Should Contain  css=#tab-consultation_retours_ma_division table  Calandre GRIGNON
    # On va sur le listing 'Tous les retours'
    # Il doit contenir trois retours
    Go To Submenu In Menu  instruction  consultation_tous_retours
    Page Title Should Be  Instruction > Consultations > Tous Les Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma collectivité.
    Element Should Contain  css=#tab-consultation_tous_retours .pagination-text  1 - 3 enregistrement(s) sur 3

    # Filtre sur l'instructeur
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=division
    ...  ${om_widget}

    # On se connecte en tant que "gdouffet" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  gdouffet  gdouffet
    # On vérifie que les consultations apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  2
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Retours de ma division'
    # Il doit contenir deux retours
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Submenu In Menu Should Be Selected  instruction  consultation_retours_ma_division
    Page Title Should Be  Instruction > Consultations > Retours De Ma Division
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma division.
    Element Should Contain  css=#tab-consultation_retours_ma_division .pagination-text  1 - 2 enregistrement(s) sur 2

    # Filtre sur l'instructeur
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=aucun
    ...  ${om_widget}

    # On se connecte en tant que "gdouffet" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  gdouffet  gdouffet
    # On vérifie que les consultations apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  3
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Tous les retours'
    # Il doit contenir trois retours
    Submenu In Menu Should Be Selected  instruction  consultation_tous_retours
    Page Title Should Be  Instruction > Consultations > Tous Les Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma collectivité.
    Element Should Contain  css=#tab-consultation_tous_retours .pagination-text  1 - 3 enregistrement(s) sur 3

    # Filtre sur l'instructeur
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur
    ...  ${om_widget}

    # On se connecte en tant que Profil 'INSTRUCTEUR'
    Depuis la page d'accueil  jpetit  jpetit
    # On vérifie que les consultations apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  1
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # On clique sur le lien "TL - Tiers de la circulation de BELFORT" dans le tableau
    Click Link  ${di_04}

    Wait Until Page Contains Element  css=#sousform-consultation #tiers_consulte
    Page Title Should Contain  ${di_04}
    Page Title Should Contain  BOULAGE DAMIEN

    # Vérification de la présence et du fonctionnement de l'action marquer comme lu
    Portlet Action Should Be In SubForm  consultation  marquer_comme_lu
    Click On SubForm Portlet Action  consultation  marquer_comme_lu
    Valid Message Should Contain In Subform  La consultation a été marquée comme lu
    Portlet Action Should Not Be In SubForm  consultation  supprimer

    Depuis la page d'accueil  jpetit  jpetit
    #
    # On vérifie que lorsqu'il n'y a aucune consultation, un message dans le widget 'Retours de consultation'
    # l'indique et que le lien Voir + n'est pas présent
    #
    Element Should Contain  css=#${widget_id} .widget-content-wrapper  Aucun retour de consultation non lu.
    Element Should Not Contain  css=#${widget_id}  Voir +

    #
    # On clique sur les trois listings liés pour vérifier qu'il n'y a aucun résultat
    #
    Go To Submenu In Menu  instruction  consultation_mes_retours
    Page Title Should Be  Instruction > Consultations > Mes Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction dont je suis l'instructeur.
    Element Should Contain  css=#tab-consultation_mes_retours .pagination-text  1 - 0 enregistrement(s) sur 0
    Element Should Not Contain  css=#tab-consultation_mes_retours table thead  instructeur
    Element Should Not Contain  css=#tab-consultation_mes_retours table thead  division
    Element Should Not Contain  css=#tab-consultation_mes_retours table thead  collectivité
    #
    Go To Submenu In Menu  instruction  consultation_retours_ma_division
    Page Title Should Be  Instruction > Consultations > Retours De Ma Division
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma division.
    Element Should Contain  css=#tab-consultation_retours_ma_division .pagination-text  1 - 0 enregistrement(s) sur 0
    Element Should Contain  css=#tab-consultation_retours_ma_division table thead  instructeur
    Element Should Not Contain  css=#tab-consultation_retours_ma_division table thead  division
    Element Should Not Contain  css=#tab-consultation_retours_ma_division table thead  collectivité
    #
    Go To Submenu In Menu  instruction  consultation_tous_retours
    Page Title Should Be  Instruction > Consultations > Tous Les Retours
    First Tab Title Should Be  Consultation
    Page Should Contain  Les consultations marquées comme 'non lu' qui concernent des dossiers d'instruction situés dans ma collectivité.
    Element Should Contain  css=#tab-consultation_tous_retours .pagination-text  1 - 0 enregistrement(s) sur 0
    Element Should Contain  css=#tab-consultation_tous_retours table thead  instructeur
    Element Should Contain  css=#tab-consultation_tous_retours table thead  division
    Element Should Not Contain  css=#tab-consultation_tous_retours table thead  collectivité

Paramétrage d'un service et d'un tiers et de l'édition PDF de la consultation
    [Documentation]  L'objet de ce TestCase est de vérifier que l'édition
    ...  paramétrée sur un service est correctement répercutée lors de la
    ...  consultation d'un service après finalisation et avant définalisation
    ...  et après définalisation.

    # Utilise un fichier de configuration spécifique
    Move File  ..${/}dyn${/}config.inc.php  ..${/}dyn${/}config.inc.php.bak
    Copy File  ..${/}tests${/}binary_files${/}config_2.inc.php  ..${/}dyn${/}config.inc.php

    ##
    ## Étape 1
    ##
    # On ajoute deux états dont l'id commence par 'consultation_' : un qui
    # contient test_10_1 et l'autre test_10_2.
    # On ajoute un service en sélectionnant l'édition test_10_1.
    ##
    Depuis la page d'accueil  admin  admin
    Ajouter l'état depuis le menu  consultation_testconsultation10_1  testconsultation10_1  test_10_1  test_10_1  Récapitulatif consultation  true  agglo
    Ajouter l'état depuis le menu  consultation_testconsultation10_2  testconsultation10_2  test_10_2  test_10_2  Récapitulatif consultation  true  agglo
    &{service} =  Create Dictionary
    ...  abrege=ts10
    ...  libelle=test_service_10
    ...  edition=testconsultation10_1
    ...  om_collectivite=agglo
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}

    @{collectivite_motif} =  Create List  MARSEILLE 
    &{args_motif_consultation} =  Create Dictionary
    ...  code=10_1
    ...  description=testMotifConsultation10_1
    ...  abrege=Consultation - test10_1
    ...  libelle=testMotifConsultation10_1
    ...  om_etat=testconsultation10_1
    ...  service_type=openADS
    ...  generate_edition=true
    ...  om_collectivite=${collectivite_motif}
    ${motif_id} =  Ajouter motif de consultation  ${args_motif_consultation}

    ##
    ## Étape 2
    ##
    # On ajoute une consultation du service ajouté précédemment sur un dossier
    # et on vérifie que l'édition contient bien la chaine test_10_1 et ne
    # contient pas la chaine test_10_2.
    ##
    # consultation d'un service
    Depuis la page d'accueil  instr  instr
    Ajouter une consultation depuis un dossier  ${di_1}  ts10 - test_service_10
    Depuis le contexte de la consultation  ${di_1}  ts10 - test_service_10
    Click On SubForm Portlet Action  consultation  consulter_pdf  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  test_10_1
    Page Should Not Contain  test_10_2
    Close PDF

    # consultation d'un tiers
    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM1 - 1er tiers de Marseille
    ...  motif_consultation=testMotifConsultation10_1
    Ajouter une consultation vers un tiers depuis un dossier  ${di_4}  ${tiers_1}
    Depuis le contexte de la consultation  ${di_4}  ${tiers_1.tiers_consulte}
    Click On SubForm Portlet Action  consultation  consulter_pdf  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  test_10_1
    Page Should Not Contain  test_10_2
    Close PDF

    ##
    ## Étape 3
    ##
    # On modifie le paramétrage du service pour lui sélectionner l'édition
    # test_10_2.
    ##
    Depuis la page d'accueil  admin  admin
    &{service} =  Create Dictionary
    ...  edition=testconsultation10_2
    Modifier le service  ts10  test_service_10  ${service}

    Depuis la page d'accueil  admin  admin
    &{motif} =  Create Dictionary
    ...  om_etat=testconsultation10_2
    Modifier motif de consultation  ${motif_id}  ${motif}

    ##
    ## Étape 4.1
    ##
    # On retourne sur la consultation précédente, on vérifie que l'édition
    # contient toujours bien la chaine test_10_1 et ne contient pas la chaine
    # test_10_2.
    ##
    # Service
    Depuis la page d'accueil  instr  instr
    Depuis le contexte de la consultation  ${di_1}  ts10 - test_service_10
    Click On SubForm Portlet Action  consultation  consulter_pdf  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  test_10_1
    Page Should Not Contain  test_10_2
    Close PDF

    # tiers
    Depuis le contexte de la consultation  ${di_4}  ${tiers_1.tiers_consulte}
    Click On SubForm Portlet Action  consultation  consulter_pdf  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  test_10_1
    Page Should Not Contain  test_10_2
    Close PDF
    ##
    ## Étape 4.2
    ##
    # Ensuite on définalise l'édition et on vérifie que l'édition contient bien
    # la chaine test_10_2 et ne contient pas la chaine test_10_1.
    ##
    Depuis le contexte de la consultation  ${di_1}  ts10 - test_service_10
    Click On SubForm Portlet Action  consultation  unfinalise
    Valid Message Should Be In Subform  La définalisation du document s'est effectuée avec succès.
    Click On SubForm Portlet Action  consultation  consulter_pdf  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  test_10_2
    Page Should Not Contain  test_10_1
    Close PDF

    Depuis le contexte de la consultation  ${di_4}  ${tiers_1.tiers_consulte}
    Click On SubForm Portlet Action  consultation  unfinalise
    Valid Message Should Be In Subform  La définalisation du document s'est effectuée avec succès.
    Click On SubForm Portlet Action  consultation  consulter_pdf  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  test_10_2
    Page Should Not Contain  test_10_1
    Close PDF

    # Restaure le fichier de configuration sauvegardé
    Remove File  ..${/}dyn${/}config.inc.php
    Move File  ..${/}dyn${/}config.inc.php.bak  ..${/}dyn${/}config.inc.php


TNR Bug Recherche sur le critère "Instructeur" de la recherche avancée de "Instruction > Consultations > Tous les retours" ne fonctionne pas

    [Documentation]  La recherche portait sur l'identifiant de l'instructeur
    ...  au lieu de porter sur son nom

    #
    Depuis la page d'accueil  instr1  instr
    #
    Depuis le listing  dossier_autorisation
    Go To Submenu In Menu    instruction    consultation_tous_retours
    #
    Click Element  css=#toggle-advanced-display
    #
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#instructeur
    # On remplit
    Input Text  css=div#adv-search-adv-fields input#instructeur  Louis Laurent
    # On valide le formulaire de recherche
    Click On Search Button
    #
    Page Should Not Contain  Aucun enregistrement


TNR Bug Droits insuffisants sur l'onglet pièces sur la demande d'avis

    [Documentation]  L'accés à l'onglet pièce n'était pas possible

    # On se connecte en tant que "consu"
    Depuis la page d'accueil  consu  consu
    #
    Depuis la demande d'avis passée du dossier  ${di_1}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Page Should Not Contain    Droits insuffisants. Vous n'avez pas suffisamment de droits pour acceder à cette page.


TNR Bug demande de consultation par le profil guichetsuivi

    [Documentation]  Vérification du dépôt de consultation par le profil
    ...  guichetsuivi

    &{args_petitionnaire_1} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Maurice
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/09/2015
    ...  om_collectivite=MARSEILLE
    #
    ${di_1} =  Ajouter la demande par WS  ${args_demande_1}  ${args_petitionnaire_1}

    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    # Test l'ajout d'une consultation de service
    Ajouter une consultation depuis un dossier  ${di_1}  DAEWE - DAE - BUREAU ENTREPOT INDUSTRIE AGRICOLE
    # Test l'ajout d'une consultation de tiers
    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM1 - 1er tiers de Marseille
    ...  motif_consultation=Premier motif de consultation
    Ajouter une consultation vers un tiers depuis un dossier  ${di_1}  ${tiers_1}


TNR Bug suppression de la pièce jointe à la modification d'une consultation

    [Documentation]  Vérifie que la pièce jointe d'une consultation ne disparaît
    ...  pas quand on modifie la consultation en tant qu'instructeur polyvalent.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Roussel
    ...  particulier_prenom=Agnès
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=03/02/2016
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrpoly  instrpoly
    # On teste pour une consultation de service
    Ajouter une consultation depuis un dossier  ${di}  59.01 - Direction de l'Eau et de l'Assainissement
    # Définalise la consultation pour pouvoir la modifier
    Depuis le contexte de la consultation  ${di}  59.01 - Direction de l'Eau et de l'Assainissement
    Click On SubForm Portlet Action  consultation  unfinalise

    # Ajoute une pièce à la consultation
    &{piece_values} =  Create Dictionary
    ...  fichier_upload=testImportManuel.pdf
    ...  date_demande=03/02/2016
    ...  avis_consultation=Tacite
    ${nom_piece} =  Ajouter une pièce à la consultation  ${piece_values}

    # Vérifie que l'instructeur polyvalent peut modifier la pièce
    &{piece_values_2} =  Create Dictionary
    ...  fichier_upload=testImportManuel2.pdf
    ${nom_piece_2} =  Ajouter une pièce à la consultation  ${piece_values_2}

    # Nouvelles valeurs de la consultation
    &{saisie_values} =  Create Dictionary
    ...  avis_consultation=Favorable

    Modifier la consultation  ${saisie_values}
    # Vérifie que le fichier est toujours ajouté à la consultation
    # 21 caractères sont retirés afin de ne prendre en compte que le nom de la pièce attendue
    ${texte_raccourci}    Evaluate    "${nom_piece_2}"[:-21]
    Page Should Contain  ${texte_raccourci}

    # On teste pour une consultation de tiers
    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM1 - 1er tiers de Marseille
    ...  motif_consultation=Premier motif de consultation
    Ajouter une consultation vers un tiers depuis un dossier  ${di}  ${tiers_1}
    # Définalise la consultation pour pouvoir la modifier
    Depuis le contexte de la consultation  ${di}  ${tiers_1.tiers_consulte}
    Click On SubForm Portlet Action  consultation  unfinalise

    # Ajoute une pièce à la consultation
    &{piece_values} =  Create Dictionary
    ...  fichier_upload=testImportManuel.pdf
    ...  date_demande=03/02/2016
    ...  avis_consultation=Tacite
    ${nom_piece} =  Ajouter une pièce à la consultation  ${piece_values}

    # Vérifie que l'instructeur polyvalent peut modifier la pièce
    &{piece_values_2} =  Create Dictionary
    ...  fichier_upload=testImportManuel2.pdf
    ${nom_piece_2} =  Ajouter une pièce à la consultation  ${piece_values_2}

    # Nouvelles valeurs de la consultation
    &{saisie_values} =  Create Dictionary
    ...  avis_consultation=Favorable
    Modifier la consultation  ${saisie_values}
    # Vérifie que le fichier est toujours ajouté à la consultation
    # 21 caractères sont retirés afin de ne prendre en compte que le nom de la pièce attendue
    ${texte_raccourci}    Evaluate    "${nom_piece_2}"[:-21]
    Page Should Contain  ${texte_raccourci}

Ajout consultation et rendu d'avis par le profil instructeur service

    [Documentation]  Vérifie l'affichage de l'avis rendu, de la motivation et du
    ...  fichier
    ...  Vérifier que ce testcase n'est pas un doublon du "090.Réponse à une consultation par le service consulté" (CU n°4)
    
    Depuis la page d'accueil  instrserv  instrserv
    # Test pour les services
    Ajouter une consultation depuis un dossier  ${di_3}  59.01 - Direction de l'Eau et de l'Assainissement

    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  motivation=Pas de réserves
    ...  fichier_upload=testImportManuel.pdf

    Rendre l'avis sur la consultation du dossier  ${di_3}  ${args_avis_consultation}
    # On clique sur l'action édition
    Depuis la demande d'avis passée du dossier  ${di_3}

    Element Should Contain  avis_consultation  Favorable
    Element Should Contain  motivation  Pas de réserves
    Element Should Contain  fichier  consultation_avis


    # Test pour les consultations de tiers
    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM1 - 1er tiers de Marseille
    ...  motif_consultation=Premier motif de consultation
    Ajouter une consultation vers un tiers depuis un dossier  ${di_6}  ${tiers_1}
    Rendre l'avis sur la consultation du dossier  ${di_6}  ${args_avis_consultation}
    # On clique sur l'action édition
    Depuis la demande d'avis passée du dossier  ${di_6}
    Element Should Contain  avis_consultation  Favorable
    Element Should Contain  motivation  Pas de réserves
    Element Should Contain  fichier  consultation_avis



TNR Vérifie que le fichier est supprimé à la suppression de la consultation

    [Documentation]  Vérifie dans le filestorage si le fichier de l'édition de
    ...  la consultation est correctement supprimé lors de la suppression de la
    ...  consultation.

   Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Goguen
    ...  particulier_prenom=Diane
    #
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=29/04/2016
    #
    ${di} =  Ajouter la nouvelle demande depuis le tableau de bord  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instr  instr
    Ajouter une consultation depuis un dossier  ${di}  59.70 - AUTRE
    # Récupération de l'UID
    Depuis le contexte de la consultation  ${di}  59.70 - AUTRE
    ${uid} =  Get Value  om_fichier_consultation
    ${path_1} =  Get Substring  ${uid}  0  2
    ${path_2} =  Get Substring  ${uid}  0  4
    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}
    File Should Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info
    #
    Depuis le contexte de la consultation  ${di}  59.70 - AUTRE
    # On clique sur l'action de définalisation
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Click On SubForm Portlet Action  consultation  unfinalise
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Valid Message Should Be  La définalisation du document s'est effectuée avec succès.
    #
    Supprimer la consultation depuis le contexte du dossier d'instruction  ${di}  59.70 - AUTRE
    # Vérification dans le filestorage
    File Should Not Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}
    File Should Not Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info

    # On teste également pour une consultation de tiers consulté
    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM3 - 3ème tiers de Marseille
    ...  motif_consultation=Premier motif de consultation
    Ajouter une consultation vers un tiers depuis un dossier  ${di}  ${tiers_1}
    # Récupération de l'UID
    Depuis le contexte de la consultation  ${di}  ${tiers_1.tiers_consulte}
    ${uid} =  Get Value  om_fichier_consultation
    ${path_1} =  Get Substring  ${uid}  0  2
    ${path_2} =  Get Substring  ${uid}  0  4
    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}
    File Should Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info

    Depuis le contexte de la consultation  ${di}  ${tiers_1.tiers_consulte}
    # On clique sur l'action de définalisation
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Click On SubForm Portlet Action  consultation  unfinalise
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Valid Message Should Be  La définalisation du document s'est effectuée avec succès.

    Supprimer la consultation depuis le contexte du dossier d'instruction  ${di}  ${tiers_1.tiers_consulte}
    # Vérification dans le filestorage
    File Should Not Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}
    File Should Not Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info

Vérification de la visibilité des consultation dans l'édition
    [Documentation]  Test des actions direct de tableau et de formulaire
    ...  masquant/affichant les consultations dans les éditions.
    ...  Ce test permet de tester la visibilité des consultations de tiers et
    ...  de service

    Depuis la page d'accueil  admin  admin
    # Création du jeu de données
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Massé
    ...  particulier_prenom=Astrid
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=27/11/2015
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #Creation de la variable du text à chercher dans le dossier
    ${service_libelle} =  Set Variable  Service Prévention et Gestion des Risques ERP
    #Creation de la variable de nom de service pour la creation de consultation
    ${service} =  Set Variable  59.10 - Service Prévention et Gestion des Risques ERP

    # Création de la variable du texte à chercher dans le dossier pour le tiers
    ${tiers_libelle} =  Set Variable  Tiers Prévention et Gestion des Risques ERP
    # Creation de la variable contenant les infos du tiers pour la creation de consultation
    ${tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TPG - Tiers Prévention et Gestion des Risques ERP
    ...  motif_consultation=Premier motif de consultation
    # Création du tiers
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  abrege=TPG
    ...  libelle=Tiers Prévention et Gestion des Risques ERP
    Ajouter le tiers consulte depuis le listing  ${args_tiers}

    Depuis la page d'accueil  instr  instr

    # Cas 1 : On affiche/masque les consultations via leur formulaire
    # Masque le service dans les éditiosn
    Ajouter une consultation depuis un dossier  ${di}  ${service}
    Click On Back Button In Subform
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${service}
    Click On SubForm Portlet Action  consultation  masquer_dans_edition
    Valid Message Should Be In Subform  La consultation est masquée dans les éditions.
    # Vérification du changement de l'état de la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#visible  Non

    Ajouter une consultation vers un tiers depuis un dossier  ${di}  ${tiers}
    Click On Back Button In Subform
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${tiers.tiers_consulte}
    Click On SubForm Portlet Action  consultation  masquer_dans_edition
    Valid Message Should Be In Subform  La consultation est masquée dans les éditions.
    # Vérification du changement de l'état de la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#visible  Non

    Depuis le contexte du dossier d'instruction  ${di}
    # On click pour créer le PDF Récapitulatif
    Click On Form Portlet Action  dossier_instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Consultation
    # On vérifie l'abscence de la consultation
    Page Should Not Contain  ${service_libelle}
    Page Should Not Contain  ${tiers_libelle}
    Close PDF

    # Affichage de la saisie du rapport
    Depuis le contexte du rapport d'instruction  ${di}
    Click On Submit Button In Subform
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform

    Depuis le contexte du rapport d'instruction  ${di}
    # On clique sur l'action édition
    Click On SubForm Portlet Action  rapport_instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ADRESSE DU DEMANDEUR TITULAIRE
    # On vérifie que la valeur de test n'est pas présente
    Page Should Not Contain  ${service_libelle}
    Page Should Not Contain  ${tiers_libelle}
    Close PDF

    # Affichage du service dans les consultations
    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${service}
    # On clique sur l'action de masquer le document
    Click On SubForm Portlet Action  consultation  afficher_dans_edition
    Valid Message Should Be In Subform  La consultation est affichée dans les éditions.
    # Vérification du changement de l'état de la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#visible  Oui
    Click On Back Button In Subform

    # Affichage du tiers dans les consultations
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${tiers.tiers_consulte}
    # On clique sur l'action de masquer le document
    Click On SubForm Portlet Action  consultation  afficher_dans_edition
    Valid Message Should Be In Subform  La consultation est affichée dans les éditions.
    # Vérification du changement de l'état de la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#visible  Oui
    Click On Back Button In Subform

    # Cas 2 : On affiche/masque les consultations via leur listing

    # On vérifie que l'action du tableau fonctionne
    Element Should Not Be Visible  css=a[id*='afficher_dans_edition']
    # Masque le service dans les éditions
    Click Element  css=tr:nth-of-type(1) a[id*='masquer_dans_edition']
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La consultation est masquée dans les éditions.
    # Masque le tiers dans les éditions
    Click Element  css=tr:nth-of-type(2) a[id*='masquer_dans_edition']
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La consultation est masquée dans les éditions.

    # On ré-affiche le service dans les éditions mais pas le tiers
    Sleep  2
    Element Should Not Be Visible  css=a[id*='masquer_dans_edition']
    Click Element  css=tr:nth-of-type(1) a[id*='afficher_dans_edition']
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La consultation est affichée dans les éditions.

    Depuis le contexte du dossier d'instruction  ${di}
    # On click pour créer le PDF Récapitulatif
    Click On Form Portlet Action  dossier_instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie la presence de la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${service_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  ${tiers_libelle}
    Close PDF

    Depuis le contexte du rapport d'instruction  ${di}
    # On clique sur l'action édition
    Click On SubForm Portlet Action  rapport_instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie que la valeur de test est présente
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${service_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  ${tiers_libelle}
    Close PDF

    # Action de désaffichage depuis le listing pour les tiers
    Depuis l'onglet consultation du dossier  ${di}
    Click Element  css=tr:nth-of-type(2) a[id*='afficher_dans_edition']
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La consultation est affichée dans les éditions.

    # Cas 3 : On vérifie l’interaction des deux types d'action

    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${service}
    Click On SubForm Portlet Action  consultation  masquer_dans_edition
    Valid Message Should Be In Subform  La consultation est masquée dans les éditions.
    # Vérification du changement de l'état de la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#visible  Non
    Click On Back Button In Subform
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${tiers.tiers_consulte}
    Click On SubForm Portlet Action  consultation  masquer_dans_edition
    Valid Message Should Be In Subform  La consultation est masquée dans les éditions.
    # Vérification du changement de l'état de la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#visible  Non
    Click On Back Button In Subform

    # On vérifie que l'action du tableau fonctionne en croisent avec depuis la consultaion de la consultation
    Element Should Not Be Visible  css=a[id*='masquer_dans_edition']
    Click Element  css=tr:nth-of-type(1) a[id*='afficher_dans_edition']
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La consultation est affichée dans les éditions.
    Click Element  css=tr:nth-of-type(2) a[id*='afficher_dans_edition']
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La consultation est affichée dans les éditions.
    Element Should Not Be Visible  css=a[id*='afficher_dans_edition']
    Click Element  css=tr:nth-of-type(1) a[id*='masquer_dans_edition']
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La consultation est masquée dans les éditions.
    Click Element  css=tr:nth-of-type(2) a[id*='masquer_dans_edition']
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La consultation est masquée dans les éditions.

    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${service}
    # On clique sur l'action de masquer le document
    Click On SubForm Portlet Action  consultation  afficher_dans_edition
    Valid Message Should Be In Subform  La consultation est affichée dans les éditions.
    # Vérification du changement de l'état de la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#visible  Oui
    Click On Back Button In Subform

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${tiers.tiers_consulte}
    # On clique sur l'action de masquer le document
    Click On SubForm Portlet Action  consultation  afficher_dans_edition
    Valid Message Should Be In Subform  La consultation est affichée dans les éditions.
    # Vérification du changement de l'état de la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#visible  Oui
    Click On Back Button In Subform

    # On vérifie que l'action du tableau fonctionne en croisent avec depuis la consultaion
    Element Should Be Visible  css=a[id*='masquer_dans_edition']

    # Dans le cas où le dossier d'instruction est clôturé et que l'utilisateur
    # est un instructeur de même division n'ayant pas de permission bypass, on
    # vérifie que les actions ne sont plus disponible sur le listing et sur le
    # formulaire
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve
    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Page Contains  ${service}
    Element Should Not Be Visible  css=a[id*='afficher_dans_edition']
    Element Should Not Be Visible  css=a[id*='masquer_dans_edition']
    Click On Link  ${service}
    Portlet Action Should Not Be In SubForm  consultation  afficher_dans_edition
    Portlet Action Should Not Be In SubForm  consultation  masquer_dans_edition
    Click On Back Button In Subform
    Wait Until Page Contains  ${tiers.tiers_consulte}
    Element Should Not Be Visible  css=a[id*='afficher_dans_edition']
    Element Should Not Be Visible  css=a[id*='masquer_dans_edition']
    Click On Link  ${tiers.tiers_consulte}
    Portlet Action Should Not Be In SubForm  consultation  afficher_dans_edition
    Portlet Action Should Not Be In SubForm  consultation  masquer_dans_edition

TNR Vérification du fonctionnement de la redirection
    [Documentation]  Le but de ce test case est de vérifier si la redirection
    ...  entre la liste des consultations de mes retours et une consultation
    ...  fonctionne. On va donc créer un dossier une consultation, rendre un avi
    ...  et vérifier l'ajout de consultations multiples.


    Depuis la page d'accueil  instr  instr
    Click Element  css=#widget_3 a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  ${di_2}
    Click On Back Button In Subform
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_multiple
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  t10_575_0_
    ${status} =  Run Keyword And Return Status  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#t10_575_0_.liste_gauche_service_selected

    # Sélection du dans la liste de Direction de l'Eau et de l'Assainissement
    Run Keyword If  ${status} == False  Click Element  t10_575_0_

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#t10_575_0_.liste_gauche_service_selected
    Click On Back Button In Subform
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  59.01 - Direction de l'Eau et de l'Assainissement
    ${status} =  Run Keyword And Return Status  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=div > table
    Run Keyword If  ${status} == False  Click Link  59.01 - Direction de l'Eau et de l'Assainissement
    Click On SubForm Portlet Action  consultation  marquer_comme_lu

    # Test la redirection pour une consultation de tiers
    Depuis la page d'accueil  instr  instr
    Click Element  css=#widget_3 a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  ${di_5}

    ${status} =  Run Keyword And Return Status  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=div > table
    Run Keyword If  ${status} == False  Click Link  TM3 - 3ème tiers de Marseille
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Be In SubForm  consultation  marquer_comme_lu
    Click On SubForm Portlet Action  consultation  marquer_comme_lu

Consultations marquées non-visibles filtrées dans l'auto-saisie des bibles
    [Documentation]  L'auto saisie des bibles dans l'édition d'une instruction
    ...  doit filtrer les consultations marquées comme non-visibles

    # Données du demandeur
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bourgeon
    ...  particulier_prenom=Aurora
    ...  om_collectivite=MARSEILLE
    # Données de la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=09/05/2019
    ...  om_collectivite=MARSEILLE
    # Données de la consultation
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable

    # Création du DI
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Création de la consultation
    Depuis la page d'accueil  instr  instr
    ${service} =  Set Variable  59.01 - Direction de l'Eau et de l'Assainissement
    Ajouter une consultation depuis un dossier  ${di}  ${service}

    # Rendre l'avis de la consultation
    Depuis la page d'accueil  consu  consu
    Rendre l'avis sur la consultation du dossier  ${di}  ${args_avis_consultation}

    # En tant que "instr" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  instr  instr

    # Ajout d'une instruction
    Ajouter une instruction au DI  ${di}  ARRÊTÉ DE REFUS

    # On se rend dans l'instruction et on la modifie
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  modifier

    # Déclenchement de la bible automatique sur le complément 1
    Ajout automatique de complément(s) d'instruction

    # On vérifie le contenu du champ complément 1
    # il doit contenir le titre du service
    HTML Should Contain  complement_om_html  Direction de l'Eau et de l'Assainissement

    # On marque la consultation comme non-visible
    Depuis l'onglet consultation du dossier  ${di}
    Click Element Until No More Element  xpath=//*[contains(@id, "action-soustab-consultation-left-masquer_dans_edition-")]

    # On se rend dans l'instruction et on la modifie
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  modifier

    # Déclenchement de la bible automatique sur le complément 1
    Ajout automatique de complément(s) d'instruction

    # On vérifie le contenu du champ complément 1
    # il ne doit pas contenir le titre du service
    HTML Should Not Contain  complement_om_html  Direction de l'Eau et de l'Assainissement

    # On marque la consultation comme visible
    Depuis l'onglet consultation du dossier  ${di}
    Click Element Until No More Element  xpath=//*[contains(@id, "action-soustab-consultation-left-afficher_dans_edition-")]

    # On se rend dans l'instruction et on la modifie
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  modifier

    # Déclenchement de la bible automatique sur le complément 1
    Ajout automatique de complément(s) d'instruction

    # On vérifie le contenu du champ complément 1
    # il ne doit pas contenir le titre du service
    HTML Should Contain  complement_om_html  Direction de l'Eau et de l'Assainissement

Consultations de tiers marquées non-visibles filtrées dans l'auto-saisie des bibles
    [Documentation]  L'auto saisie des bibles dans l'édition d'une instruction
    ...  doit filtrer les consultations marquées comme non-visibles

    # Données du demandeur
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bourgeon
    ...  particulier_prenom=Aurora
    ...  om_collectivite=MARSEILLE
    # Données de la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=09/05/2019
    ...  om_collectivite=MARSEILLE
    # Données de la consultation
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable

    # Création du DI
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Création de la consultation
    Depuis la page d'accueil  instr  instr
    ${tiers_1} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  tiers_consulte=TM1 - 1er tiers de Marseille
    ...  motif_consultation=Premier motif de consultation
    Ajouter une consultation vers un tiers depuis un dossier  ${di}  ${tiers_1}

    # Rendre l'avis de la consultation
    Depuis la page d'accueil  consu  consu
    Rendre l'avis sur la consultation du dossier  ${di}  ${args_avis_consultation}

    # En tant que "instr" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  instr  instr

    # Ajout d'une instruction
    Ajouter une instruction au DI  ${di}  ARRÊTÉ DE REFUS

    # On se rend dans l'instruction et on la modifie
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  modifier

    # Déclenchement de la bible automatique sur le complément 1
    Ajout automatique de complément(s) d'instruction

    # On vérifie le contenu du champ complément 1
    # il doit contenir le titre du service
    HTML Should Contain  complement_om_html  1er tiers de Marseille

    # On marque la consultation comme non-visible
    Depuis l'onglet consultation du dossier  ${di}
    Click Element Until No More Element  xpath=//*[contains(@id, "action-soustab-consultation-left-masquer_dans_edition-")]

    # On se rend dans l'instruction et on la modifie
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  modifier

    # Déclenchement de la bible automatique sur le complément 1
    Ajout automatique de complément(s) d'instruction

    # On vérifie le contenu du champ complément 1
    # il ne doit pas contenir le titre du service
    HTML Should Not Contain  complement_om_html  1er tiers de Marseille

    # On marque la consultation comme visible
    Depuis l'onglet consultation du dossier  ${di}
    Click Element Until No More Element  xpath=//*[contains(@id, "action-soustab-consultation-left-afficher_dans_edition-")]

    # On se rend dans l'instruction et on la modifie
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  modifier

    # Déclenchement de la bible automatique sur le complément 1
    Ajout automatique de complément(s) d'instruction

    # On vérifie le contenu du champ complément 1
    # il ne doit pas contenir le titre du service
    HTML Should Contain  complement_om_html  1er tiers de Marseille

Vérification des habilitations des tiers consultés 
    [Documentation]  Lorsque l'utilisateur se rend dans les habilitations de tiers consultés,
    ...  la recherche avancée doit filtrer correctement en ne retournant dans la liste
    ...  uniquement les habilitations qui correspondent aux critères de recherche avancée.

    # On crée différents types d'habilitations de tiers consultés
    Depuis la page d'accueil  admin  admin

    # Ajout d'une commune et d'un département pour tester l'export des champs
    # division territoriales d'intervention commune et [...] département
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=01010
    ...  reg=01
    ...  dep=01
    ...  arr=010
    ...  tncc=0
    ...  ncc=EXPORTCOM
    ...  nccenr=EXPORTCOM
    ...  libelle=EXPORTCOM
    ...  can=01
    ...  comparent=
    ...  om_validite_debut=01/01/2020
    Ajouter commune avec dates validité  ${com_values}
    &{dep_values} =  Create Dictionary
    ...  dep=01
    ...  reg=01
    ...  cheflieu=01010
    ...  tncc=0
    ...  ncc=EXPORTDEP
    ...  nccenr=EXPORTDEP
    ...  libelle=Département test export
    ...  om_validite_debut=01/01/2020
    Ajouter département  ${dep_values}

    ## On crée un premier type d'habilitation de tiers consulté
    Depuis le listing  type_habilitation_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  123
    Input Text  css=input#libelle.champFormulaire  TypeHTC1
    Input Text  css=input#om_validite_debut.champFormulaire  01/01/20203
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button

    ## On procède à la même opération pour crée un second type d'habilitation de tiers consulté
    Depuis le listing  type_habilitation_tiers_consulte 
    Click On Add Button
    Input Text  css=input#code.champFormulaire  456
    Input Text  css=input#libelle.champFormulaire  TypeHTC2
    Input Text  css=input#om_validite_debut.champFormulaire  02/02/2022
    Input Text  css=input#om_validite_fin.champFormulaire  02/02/2099
    Click On Submit Button

    # L'ajout de la spécialité de tiers consulté, du dept et de la commune servent au test :
    # Export des tiers consulté
    # Ils sont ajoutés ici pour éviter un traitement supplémentaires de modification de l'habilitation
    # du tiers pour avoir toutes les valeurs voules dans l'export.
    # On crée une spécialité de tiers consulté
    &{spe_values} =  Create Dictionary
    ...  code=plop
    ...  libelle=plop
    ${id_spe} =  Ajouter la spécialité de tiers consulté  ${spe_values}
    Set Suite Variable  ${spe_values}
    Set Suite Variable  ${id_spe}

    ## On crée une première habilitation de tiers consulté
    &{dept_values} =  Create Dictionary
    ...  dep=35
    ...  reg=35
    ...  cheflieu=35535
    ...  tncc=0
    ...  ncc=DEP_HTC1
    ...  nccenr=DEP_HTC1
    ...  libelle=DEP_HTC1
    ...  om_validite_debut=01/01/2023
    ${id_dep} =  Ajouter département  ${dept_values}
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=35535
    ...  reg=35
    ...  dep=35
    ...  arr=535
    ...  tncc=0
    ...  ncc=COM_HTC1
    ...  nccenr=COM_HTC1
    ...  libelle=COM_HTC1
    ...  can=35
    ...  om_validite_debut=01/01/2023
    ${id_com} =  Ajouter commune avec dates validité  ${com_values}
    @{dep_HTC1} =  Create List  ${dept_values.dep} - ${dept_values.libelle}
    @{com_HTC1} =  Create List  ${com_values.com} - ${com_values.libelle}
    @{spe_tc} =  Create List  ${spe_values.code} - ${spe_values.libelle}
    ${hab_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=TypeHTC1
    ...  texte_agrement=txt agrement
    ...  tiers_consulte=1er tiers de Marseille
    ...  division_territoriales=DivisionHTC1
    ...  om_validite_debut=01/01/2022
    ...  om_validite_fin=01/01/2099
    ...  specialite_tiers_consulte=${spe_tc}
    ${id_hab} =  Ajouter une habilitation de tiers consulté  ${hab_values}  ${dep_HTC1}  ${com_HTC1}
    # Récupération des valeurs des champs qui serviront à tester l'export des tiers dans un autre test
    Set Suite Variable  ${id_hab}
    Set Suite Variable  ${id_dep}
    Set Suite Variable  ${dept_values}
    Set Suite Variable  ${id_com}
    Set Suite Variable  ${com_values}
    Set Suite Variable  ${hab_values}

    ## On crée une seconde habilitation de tiers consulté 
    Depuis le listing  habilitation_tiers_consulte
    Click On Add Button
    Select From List By Label  type_habilitation_tiers_consulte  TypeHTC2
    Select From List By Label  tiers_consulte  2ème tiers de Marseille
    Input Text  css=textarea#division_territoriales.champFormulaire  DivisionHTC2
    Input Text  css=input#om_validite_debut.champFormulaire  02/02/2022
    Input Text  css=input#om_validite_fin.champFormulaire  02/02/2099
    Click On Submit Button

    # On effectue une recherche (en remplissant tous les champs) : Seule 
    # une habilitations doit apparaitre. L'autre ne doit pas apparaitre.
    Depuis le listing  habilitation_tiers_consulte
    Click Element  css=legend#toggle-advanced-display
    Select From List By Label  type_habilitation_tiers_consulte  TypeHTC1
    Input Text  css=input#om_validite_debut_min.champFormulaire  15/01/2020
    Input Text  css=input#om_validite_debut_max.champFormulaire  15/01/2022
    Input Text  css=input#om_validite_fin_min.champFormulaire  15/01/2042
    Input Text  css=input#om_validite_fin_max.champFormulaire  15/01/2099
    Input Text  css=input#division_territoriales.champFormulaire  DivisionHTC1
    Click On Search Button

    Element Should Contain  css=table.tab-tab  TypeHTC1

    
    # Télécharge le fichier d'export CSV 
    ${link} =  Get Element Attribute  css=div.tab-export a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    
    # On vérifie que le contenu du fichier CSV corresponde au filtre de recherche avancée
    ${content_file} =  Get File  ${full_path_to_file}

    @{hab_field_values} =  Create List  ${hab_values.type_habilitation_tiers_consulte}  ${hab_values.division_territoriales}  "${com_values.com} - ${com_values.libelle}"  "${dept_values.dep} - ${dept_values.libelle}"  "${hab_values.texte_agrement}"  "${spe_values.code} - ${spe_values.libelle}"  ${hab_values.om_validite_debut}  ${hab_values.om_validite_fin}
    @{tiers_field_values} =  Create List  "${args_tiers_1.libelle}"  "${args_tiers_1.categorie_tiers_consulte}"  ${args_tiers_1.abrege}  "${args_tiers_1.libelle}"  "${args_tiers_1.adresse}"  "${args_tiers_1.complement}"  ${args_tiers_1.cp}  ${args_tiers_1.ville}  "${args_tiers_1.liste_diffusion}"  Oui  ${args_tiers_1.uid_platau_acteur}  "consu, instrserv"

    ${lines_csv_file} =  Catenate  SEPARATOR=;  @{hab_field_values}  @{tiers_field_values}
    Should Contain  ${content_file}  ${lines_csv_file}


Vérification des habilitations des tiers consultés avec division territoriale d’intervention
    [Documentation]  Le formulaire avec le champ de division territoriale d’intervention
    ...  séparé en deux champs (commune et département) doit fonctionner.

    ${yyyy} =  Get Time  year
    ${mm} =  Get Time  month
    ${dd} =  Get Time  day
    ${date_courante} =  Catenate  SEPARATOR=/  ${dd}  ${mm}  ${yyyy}

    # On crée différents types d'habilitations de tiers consultés
    Depuis la page d'accueil  admin  admin

    ## On crée un premier type d'habilitation de tiers consulté
    Depuis le listing  type_habilitation_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  456
    Input Text  css=input#libelle.champFormulaire  TypeHTCZ
    Input Text  css=input#om_validite_debut.champFormulaire  ${date_courante}
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button

    ## On ajoute trois communes (ue dans le passé, deux valides)
    &{expiredcom_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=46646
    ...  reg=46
    ...  dep=46
    ...  arr=646
    ...  tncc=0
    ...  ncc=EXPIREDCOM6
    ...  nccenr=Expiredcom6
    ...  libelle=Expiredcom6
    ...  can=46
    ...  comparent=
    ...  om_validite_debut=01/01/2020
    ...  om_validite_fin=01/02/2020
    Ajouter commune avec dates validité  ${expiredcom_values}
    &{validcom1_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=41141
    ...  reg=41
    ...  dep=41
    ...  arr=141
    ...  tncc=0
    ...  ncc=VALIDCOM1
    ...  nccenr=Validcom1
    ...  libelle=Validcom1
    ...  can=41
    ...  comparent=
    ...  om_validite_debut=${date_courante}
    Ajouter commune avec dates validité  ${validcom1_values}
    &{validcom2_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=42242
    ...  reg=42
    ...  dep=42
    ...  arr=242
    ...  tncc=0
    ...  ncc=VALIDCOM2
    ...  nccenr=Validcom2
    ...  libelle=Validcom2
    ...  can=42
    ...  comparent=
    ...  om_validite_debut=${date_courante}
    Ajouter commune avec dates validité  ${validcom2_values}

    ## On ajoute trois départements
    &{dept1_values} =  Create Dictionary
    ...  dep=41
    ...  reg=41
    ...  cheflieu=41141
    ...  tncc=0
    ...  ncc=DEPT1
    ...  nccenr=Dept1
    ...  libelle=Département1
    ...  om_validite_debut=${date_courante}
    Ajouter département  ${dept1_values}
    &{dept2_values} =  Create Dictionary
    ...  dep=42
    ...  reg=42
    ...  cheflieu=42242
    ...  tncc=0
    ...  ncc=DEPT2
    ...  nccenr=Dept2
    ...  libelle=Département2
    ...  om_validite_debut=${date_courante}
    Ajouter département  ${dept2_values}
    &{dept3_values} =  Create Dictionary
    ...  dep=46
    ...  reg=46
    ...  cheflieu=46646
    ...  tncc=0
    ...  ncc=DEPT6
    ...  nccenr=Dept6
    ...  libelle=Département6
    ...  om_validite_debut=01/01/2020
    ...  om_validite_fin=01/02/2020
    Ajouter département  ${dept3_values}

    ## On ajoute un tiers consulté
    &{tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  abrege=TMZ
    ...  libelle=Zieme tiers de Marseille
    ...  ville=MARSEILLE
    ...  liste_diffusion=support@atreal.fr
    ...  accepte_notification_email=Oui
    Ajouter le tiers consulte depuis le listing  ${tc_values}

    ## On ajoute une habilitation
    Depuis le listing  habilitation_tiers_consulte
    Click On Add Button
    Select From List By Label  type_habilitation_tiers_consulte  TypeHTCZ
    Select From List By Label  tiers_consulte  ${tc_values.libelle}
    @{communes_a_selectionner} =  Create List
    ...  ${validcom1_values.com} - ${validcom1_values.libelle}
    ...  ${expiredcom_values.com} - ${expiredcom_values.libelle}
    Select From Multiple Chosen List   division_territoire_intervention_commune  ${communes_a_selectionner}
    @{departements_a_selectionner} =  Create List
    ...  ${dept2_values.dep} - ${dept2_values.libelle}
    ...  ${dept3_values.dep} - ${dept3_values.libelle}
    Select From Multiple Chosen List   division_territoire_intervention_departement  ${departements_a_selectionner}
    Input Text  css=textarea#division_territoriales.champFormulaire  DivisionHTCZ
    Input Text  css=input#om_validite_debut.champFormulaire  01/01/2022
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Capture Page Screenshot
    Click On Submit Button

    Depuis le listing  habilitation_tiers_consulte
    Click Element  css=legend#toggle-advanced-display
    Select From List By Label  type_habilitation_tiers_consulte  TypeHTCZ
    Input Text  css=input#division_territoriales.champFormulaire  DivisionHTCZ
    Click On Search Button
    Click Element  css=div#tab-habilitation_tiers_consulte table.tab-tab td.col-0.firstcol a.lienTable

    Capture Page Screenshot

    Form Static Value Should Be  css=#type_habilitation_tiers_consulte  TypeHTCZ
    #Form Static Value Should Be  css=#division_territoire_intervention_commune  ${validcom1_values.com} - ${validcom1_values.libelle}
    Page Should Contain Element      xpath=//div[contains(@class, "field-type-select_multiple_static")]/div/ul/li[normalize-space(text()) = "${validcom1_values.com} - ${validcom1_values.libelle}"]
    Page Should Not Contain Element  xpath=//div[contains(@class, "field-type-select_multiple_static")]/div/ul/li[normalize-space(text()) = "${validcom2_values.com} - ${validcom2_values.libelle}"]
    Page Should Not Contain Element  xpath=//div[contains(@class, "field-type-select_multiple_static")]/div/ul/li[normalize-space(text()) = "${expiredcom_values.com} - ${expiredcom_values.libelle}"]
    #Form Static Value Should Be  css=#division_territoire_intervention_departement  ${dept2_values.dep} - ${dept2_values.libelle}
    Page Should Contain Element  xpath=//div[contains(@class, "field-type-select_multiple_static")]/div/ul/li[normalize-space(text()) = "${dept2_values.dep} - ${dept2_values.libelle}"]
    Page Should Not Contain Element  xpath=//div[contains(@class, "field-type-select_multiple_static")]/div/ul/li[normalize-space(text()) = "${dept1_values.dep} - ${dept1_values.libelle}"]
    Page Should Not Contain Element  xpath=//div[contains(@class, "field-type-select_multiple_static")]/div/ul/li[normalize-space(text()) = "${dept3_values.dep} - ${dept3_values.libelle}"]
    Form Static Value Should Be  css=#division_territoriales  DivisionHTCZ
    Form Static Value Should Be  css=#tiers_consulte  ${tc_values.libelle}


    # Vérification filtrage catégorie tiers consulté 
    &{allauch_cat_tiers_consulte} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie ALLAUCH
    ...  abrege=TMZ
    ...  libelle=toto
    ...  ville=ALLAUCH

    Ajouter le tiers consulte depuis le listing  ${allauch_cat_tiers_consulte}

    # Catégorie ALLAUCH
    Depuis le listing  categorie_tiers_consulte
    Click On Link  css=tbody > tr > td.col-1 > a.lienTable
    ${libelle_categorie_tc} =  Get Text  css=#libelle
    Log  ${libelle_categorie_tc}

    Click On Link  css=#tiers_consulte
    Element Should Contain  css=tbody > tr > td.col-1 > a.lienTable  Catégorie ALLAUCH
    Element Should Not Contain  css=tbody > tr > td.col-1 > a.lienTable  Catégorie Marseille
    Element Should Not Contain  css=tbody > tr > td.col-1 > a.lienTable  Catégorie MA

Export des tiers consulté
    [Documentation]  L'export des tiers dois contenir les données suivantes :
    ...  - Information de la table tiers
    ...  - Informations de la table categorie_tiers_consulte
    ...  - Informations de la table  habilitation_tiers_consulte
    ...  - La specialite de tiers consulte
    ...  - Les divisions territoriales d'intervention commune et département
    ...  /!\ ce test dépend des deux tests précédents

    # Ajout des données manquantes pour que les formulaires soient complet
    @{collectivite} =  Create List  MARSEILLE
    ${cat_values} =  Create Dictionary
    ...  code=CAT1
    ...  description=Catégorie des tiers de Marseille
    ...  libelle=Catégorie Marseille
    ...  om_validite_debut=01/01/2023
    ...  om_validite_fin=30/12/2099
    ...  om_collectivite=${collectivite}
    Modifier la categorie de tiers consulte  CAT1  ${cat_values}

    Depuis le listing  tiers_consulte
    # Télécharge le fichier d'export CSV
    ${link} =  Get Element Attribute  css=div.tab-export a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    ${content_file} =  Get File  ${full_path_to_file}
    
    # Test le contenu du fichier CSV
    @{tiers_field_values} =  Create List  ${args_tiers_1.abrege}  "${args_tiers_1.libelle}"  "${args_tiers_1.adresse}"  "${args_tiers_1.complement}"  ${args_tiers_1.cp}  ${args_tiers_1.ville}  "${args_tiers_1.liste_diffusion}"  Oui  ${args_tiers_1.uid_platau_acteur}  "consu, instrserv"
    @{cat_field_values} =  Create List  1  "${cat_values.libelle}"  ${cat_values.code}  "${cat_values.description}"  ${cat_values.om_validite_debut}  ${cat_values.om_validite_fin}  MARSEILLE
    @{hab_field_values} =  Create List  ${id_hab}  ${hab_values.type_habilitation_tiers_consulte}  "${hab_values.texte_agrement}"  ${id_com}  ${com_values.libelle}  ${id_dep}  ${dept_values.libelle}  ${hab_values.division_territoriales}  ${hab_values.om_validite_debut}  ${hab_values.om_validite_fin}  "${id_spe} - ${spe_values.code} - ${spe_values.libelle}"
    ${values_to_check} =  Catenate  SEPARATOR=;  @{tiers_field_values}  @{cat_field_values}  @{hab_field_values}
    Should Contain  ${content_file}  ${values_to_check}

Gestion des opérateurs
    [Documentation]  Permet de tester les différents cas permettant la désignation d'un opérateur.

    # Isolation du contexte
    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=FREECITY080GO
    ...  departement=013
    ...  commune=086
    ...  insee=13086
    ...  direction_code=GT
    ...  direction_libelle=Direction de FREECITY080GO
    ...  direction_chef=Chef
    ...  division_code=GT
    ...  division_libelle=Division GT
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Blice Planglais
    ...  guichet_om_utilisateur_email=bliceplanglais@openads-test.fr
    ...  guichet_om_utilisateur_login=bplanglais
    ...  guichet_om_utilisateur_pwd=bplanglais
    ...  instr_om_utilisateur_nom=Fliot Oevasseur
    ...  instr_om_utilisateur_email=foiotlevasseur@openads-test.fr
    ...  instr_om_utilisateur_login=foevasseur
    ...  instr_om_utilisateur_pwd=foevasseur
    Isolation d'un contexte  ${isolation_values}

    # Création d'un évènement
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=TEST_080
    ...  dossier_instruction_type=${type_di}
    #
    Ajouter l'événement depuis le menu  ${args_evenement}
    ${evenement_id} =  Get Text  css=div.form-content span#evenement

    &{validcom1_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=69259
    ...  reg=69
    ...  dep=69
    ...  arr=259
    ...  tncc=0
    ...  ncc=COMGO
    ...  nccenr=COMGO1
    ...  libelle=COMGO1
    ...  can=69
    ...  comparent=
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter commune avec dates validité  ${validcom1_values}

    &{dept01_values} =  Create Dictionary
    ...  dep=01
    ...  reg=01
    ...  cheflieu=01086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept01_values}

    &{dept03_values} =  Create Dictionary
    ...  dep=03
    ...  reg=03
    ...  cheflieu=03086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept03_values}

    &{dept07_values} =  Create Dictionary
    ...  dep=07
    ...  reg=07
    ...  cheflieu=07086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept07_values}

    &{dept13_values} =  Create Dictionary
    ...  dep=13
    ...  reg=13
    ...  cheflieu=13086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept13_values}

    &{dept15_values} =  Create Dictionary
    ...  dep=15
    ...  reg=15
    ...  cheflieu=15086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept15_values}

    &{dept26_values} =  Create Dictionary
    ...  dep=26
    ...  reg=26
    ...  cheflieu=26086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept26_values}

    &{dept38_values} =  Create Dictionary
    ...  dep=38
    ...  reg=38
    ...  cheflieu=38086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept38_values}

    &{dept42_values} =  Create Dictionary
    ...  dep=42
    ...  reg=42
    ...  cheflieu=42086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept42_values}

    &{dept43_values} =  Create Dictionary
    ...  dep=43
    ...  reg=43
    ...  cheflieu=43086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept43_values}

    &{dept63_values} =  Create Dictionary
    ...  dep=63
    ...  reg=63
    ...  cheflieu=63086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept63_values}

    &{dept69_values} =  Create Dictionary
    ...  dep=69
    ...  reg=69
    ...  cheflieu=69086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept69_values}

    &{dept73_values} =  Create Dictionary
    ...  dep=73
    ...  reg=73
    ...  cheflieu=73086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept73_values}

    &{dept74_values} =  Create Dictionary
    ...  dep=74
    ...  reg=74
    ...  cheflieu=74086
    ...  tncc=0
    ...  ncc=DEPTGO1
    ...  nccenr=DEPTGO1
    ...  libelle=DépartementGO1
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter département  ${dept74_values}

    # Ajout des paramètres nécessaires

    # option_dossier_commune
    &{param_values} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # option_mode_service_consulte
    &{param_values} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # TODO Tester la vérification de l'ajout d'un json non valide dans le param_operteur (message d'erreur)

    # On crée un premier type d'habilitation de tiers consulté
    Depuis le listing  type_habilitation_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  THINRAP
    Input Text  css=input#libelle.champFormulaire  Type Habilitation INRAP
    Input Text  css=input#om_validite_debut.champFormulaire  ${date_ddmmyyyy}
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${type_habilitation_inrap} =  Get Text  css=div.form-content span#type_habilitation_tiers_consulte

    # On crée un premier type d'habilitation de tiers consulté
    Depuis le listing  type_habilitation_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  THCOLLTERR1
    Input Text  css=input#libelle.champFormulaire  Type Habilitation Collterr1
    Input Text  css=input#om_validite_debut.champFormulaire  ${date_ddmmyyyy}
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${type_habilitation_collterr1} =  Get Text  css=div.form-content span#type_habilitation_tiers_consulte

    # On crée un premier type d'habilitation de tiers consulté
    Depuis le listing  type_habilitation_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  THCOLLTERR2
    Input Text  css=input#libelle.champFormulaire  Type Habilitation Collterr2
    Input Text  css=input#om_validite_debut.champFormulaire  ${date_ddmmyyyy}
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${type_habilitation_collterr2} =  Get Text  css=div.form-content span#type_habilitation_tiers_consulte

    # On crée un premier type d'habilitation de tiers consulté
    Depuis le listing  type_habilitation_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  THCOLLTERR3
    Input Text  css=input#libelle.champFormulaire  Type Habilitation Collterr3
    Input Text  css=input#om_validite_debut.champFormulaire  ${date_ddmmyyyy}
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${type_habilitation_collterr3} =  Get Text  css=div.form-content span#type_habilitation_tiers_consulte

    # On crée un premier type d'habilitation de tiers consulté
    Depuis le listing  type_habilitation_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  THCOLLTERR4
    Input Text  css=input#libelle.champFormulaire  Type Habilitation Collterr4
    Input Text  css=input#om_validite_debut.champFormulaire  ${date_ddmmyyyy}
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${type_habilitation_collterr4} =  Get Text  css=div.form-content span#type_habilitation_tiers_consulte

    # On crée une catégorie INRAP
    Depuis le listing  categorie_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  INRAP
    Input Text  css=input#libelle.champFormulaire  Catégorie INRAP
    Input Text  css=input#om_validite_debut.champFormulaire  ${date_ddmmyyyy}
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    # @{communes_a_selectionner} =  Create List
    # ...  ${isolation_values.om_collectivite_libelle}
    Select From List By Label   om_collectivite  ${isolation_values.om_collectivite_libelle}
    Click On Submit Button
    ${categorie_tiers_consulte_inrap} =  Get Text  css=div.form-content span#categorie_tiers_consulte

    # On crée une catégorie Collterr
    Depuis le listing  categorie_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  Collterr
    Input Text  css=input#libelle.champFormulaire  Catégorie Collterr
    Input Text  css=input#om_validite_debut.champFormulaire  ${date_ddmmyyyy}
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    # @{communes_a_selectionner} =  Create List
    # ...  ${isolation_values.om_collectivite_libelle}
    Select From List By Label   om_collectivite  ${isolation_values.om_collectivite_libelle}
    Click On Submit Button
    ${categorie_tiers_consulte_collterr} =  Get Text  css=div.form-content span#categorie_tiers_consulte

    # On crée une catégorie Collterr
    Depuis le listing  categorie_tiers_consulte
    Click On Add Button
    Input Text  css=input#code.champFormulaire  AmPu
    Input Text  css=input#libelle.champFormulaire  Catégorie Aménageur Publique
    Input Text  css=input#om_validite_debut.champFormulaire  ${date_ddmmyyyy}
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    # @{communes_a_selectionner} =  Create List
    # ...  ${isolation_values.om_collectivite_libelle}
    Select From List By Label   om_collectivite  ${isolation_values.om_collectivite_libelle}
    Click On Submit Button
    ${categorie_tiers_consulte_ampu} =  Get Text  css=div.form-content span#categorie_tiers_consulte

    # On ajoute un tiers consulté INRAP
    &{tiers_consulte_inrap_values} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie INRAP
    ...  abrege=INRAPARA
    ...  libelle=Opérateur INRAP ARA
    ...  ville=FREECITY080GO
    ...  liste_diffusion=plop@atreal.fr
    ...  accepte_notification_email=Non
    ${tiers_consulte_inrap} =  Ajouter le tiers consulte depuis le listing  ${tiers_consulte_inrap_values}

    # On ajoute un tiers consulté Collterr 1
    &{tiers_consulte_collterr1_values} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Collterr
    ...  abrege=Collterr1
    ...  libelle=Opérateur Collterr1
    ...  ville=FREECITY080GO
    ...  liste_diffusion=plop@atreal.fr
    ...  accepte_notification_email=Non
    ${tiers_consulte_collterr1} =  Ajouter le tiers consulte depuis le listing  ${tiers_consulte_collterr1_values}

    # On ajoute un tiers consulté Collterr 2
    &{tiers_consulte_collterr2_values} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Collterr
    ...  abrege=Collterr2
    ...  libelle=Opérateur Collterr2
    ...  ville=FREECITY080GO
    ...  liste_diffusion=plop@atreal.fr
    ...  accepte_notification_email=Non
    ${tiers_consulte_collterr2} =  Ajouter le tiers consulte depuis le listing  ${tiers_consulte_collterr2_values}

    # On ajoute un tiers consulté Collterr 3
    &{tiers_consulte_collterr3_values} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Collterr
    ...  abrege=Collterr3
    ...  libelle=Opérateur Collterr3
    ...  ville=FREECITY080GO
    ...  liste_diffusion=plop@atreal.fr
    ...  accepte_notification_email=Non
    ${tiers_consulte_collterr3} =  Ajouter le tiers consulte depuis le listing  ${tiers_consulte_collterr3_values}

    # On ajoute un tiers consulté Collterr 4
    &{tiers_consulte_collterr4_values} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Collterr
    ...  abrege=Collterr4
    ...  libelle=Opérateur Collterr4
    ...  ville=FREECITY080GO
    ...  liste_diffusion=plop@atreal.fr
    ...  accepte_notification_email=Non
    ${tiers_consulte_collterr4} =  Ajouter le tiers consulte depuis le listing  ${tiers_consulte_collterr4_values}

    # On ajoute un tiers consulté Aménageur publique
    &{tiers_consulte_amenageur_public_values} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Aménageur Publique
    ...  abrege=AmPu
    ...  libelle=Opérateur Aménageur Publique
    ...  ville=FREECITY080GO
    ...  liste_diffusion=plop@atreal.fr
    ...  accepte_notification_email=Non
    ${tiers_consulte_amenageur_public} =  Ajouter le tiers consulte depuis le listing  ${tiers_consulte_amenageur_public_values}

    # On ajoute une habilitation pour INRAP
    Depuis le listing  habilitation_tiers_consulte
    Click On Add Button
    Select From List By Label  type_habilitation_tiers_consulte  Type Habilitation INRAP
    Select From List By Label  tiers_consulte  ${tiers_consulte_inrap_values.libelle}
    @{dep_a_selectionner} =  Create List
    ...  ${dept01_values.dep} - ${dept01_values.libelle}
    ...  ${dept03_values.dep} - ${dept03_values.libelle}
    ...  ${dept07_values.dep} - ${dept07_values.libelle}
    ...  ${dept15_values.dep} - ${dept15_values.libelle}
    ...  ${dept26_values.dep} - ${dept26_values.libelle}
    ...  ${dept38_values.dep} - ${dept38_values.libelle}
    ...  ${dept42_values.dep} - ${dept42_values.libelle}
    ...  ${dept43_values.dep} - ${dept43_values.libelle}
    ...  ${dept63_values.dep} - ${dept63_values.libelle}
    ...  ${dept69_values.dep} - ${dept69_values.libelle}
    ...  ${dept73_values.dep} - ${dept73_values.libelle}
    ...  ${dept74_values.dep} - ${dept74_values.libelle}
    Select From Multiple Chosen List   division_territoire_intervention_departement  ${dep_a_selectionner}
    Input Text  css=textarea#division_territoriales.champFormulaire  DivisionHTCZ
    Input Text  css=input#om_validite_debut.champFormulaire  01/01/2022
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${habilitation_inrap} =  Get Text  css=div.form-content span#habilitation_tiers_consulte

    # On ajoute une habilitation pour Collterr4
    Depuis le listing  habilitation_tiers_consulte
    Click On Add Button
    Select From List By Label  type_habilitation_tiers_consulte  Type Habilitation Collterr4
    Select From List By Label  tiers_consulte  ${tiers_consulte_collterr4_values.libelle}
    @{communes_a_selectionner} =  Create List
    ...  ${validcom1_values.com} - ${validcom1_values.libelle}
    Select From Multiple Chosen List   division_territoire_intervention_commune  ${communes_a_selectionner}
    Input Text  css=textarea#division_territoriales.champFormulaire  DivisionHTCZ
    Input Text  css=input#om_validite_debut.champFormulaire  01/01/2022
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${habilitation_collterr4} =  Get Text  css=div.form-content span#habilitation_tiers_consulte

    # On ajoute une habilitation pour Collterr 1
    Depuis le listing  habilitation_tiers_consulte
    Click On Add Button
    Select From List By Label  type_habilitation_tiers_consulte  Type Habilitation Collterr1
    Select From List By Label  tiers_consulte  ${tiers_consulte_collterr1_values.libelle}
    @{dep_a_selectionner} =  Create List
    ...  ${dept69_values.dep} - ${dept69_values.libelle}
    Select From Multiple Chosen List   division_territoire_intervention_departement  ${dep_a_selectionner}
    Input Text  css=textarea#division_territoriales.champFormulaire  DivisionHTCZ
    Input Text  css=input#om_validite_debut.champFormulaire  01/01/2022
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${habilitation_collterr_1} =  Get Text  css=div.form-content span#habilitation_tiers_consulte

    # On ajoute une habilitation pour Collterr 3
    Depuis le listing  habilitation_tiers_consulte
    Click On Add Button
    Select From List By Label  type_habilitation_tiers_consulte  Type Habilitation Collterr3
    Select From List By Label  tiers_consulte  ${tiers_consulte_collterr3_values.libelle}
    @{dep_a_selectionner} =  Create List
    ...  ${dept69_values.dep} - ${dept69_values.libelle}
    Select From Multiple Chosen List   division_territoire_intervention_departement  ${dep_a_selectionner}
    Input Text  css=textarea#division_territoriales.champFormulaire  DivisionHTCZ
    Input Text  css=input#om_validite_debut.champFormulaire  01/01/2022
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${habilitation_collterr_3} =  Get Text  css=div.form-content span#habilitation_tiers_consulte

    # On ajoute une habilitation pour Collterr 2
    Depuis le listing  habilitation_tiers_consulte
    Click On Add Button
    Select From List By Label  type_habilitation_tiers_consulte  Type Habilitation Collterr2
    Select From List By Label  tiers_consulte  ${tiers_consulte_collterr2_values.libelle}
    @{dep_a_selectionner} =  Create List
    ...  ${dept13_values.dep} - ${dept13_values.libelle}
    Select From Multiple Chosen List   division_territoire_intervention_departement  ${dep_a_selectionner}
    Input Text  css=textarea#division_territoriales.champFormulaire  DivisionHTCZ
    Input Text  css=input#om_validite_debut.champFormulaire  01/01/2022
    Input Text  css=input#om_validite_fin.champFormulaire  01/01/2099
    Click On Submit Button
    ${habilitation_collterr2} =  Get Text  css=div.form-content span#habilitation_tiers_consulte

    ${param_operateur} =  Get File  ${EXECDIR}${/}binary_files${/}param_operateur.txt

    ${param_operateur} =  Replace String  ${param_operateur}  "type_habilitations_operateurs_inrap": [2],  "type_habilitations_operateurs_inrap": [${type_habilitation_inrap}],
    ${param_operateur} =  Replace String  ${param_operateur}  "categorie_tiers_inrap": [1, 2],  "categorie_tiers_inrap": [${categorie_tiers_consulte_inrap}],
    ${param_operateur} =  Replace String  ${param_operateur}  "categorie_tiers_collterr": [1,2],  "categorie_tiers_collterr": [${categorie_tiers_consulte_collterr}],
    ${param_operateur} =  Replace String  ${param_operateur}  "type_habilitations_operateurs_diag_kpark": [1, 2],  "type_habilitations_operateurs_diag_kpark": [${type_habilitation_collterr3},${type_habilitation_collterr4}],
    ${param_operateur} =  Replace String  ${param_operateur}  "type_habilitations_operateurs_diag_toutdiag": [4,5],  "type_habilitations_operateurs_diag_toutdiag": [${type_habilitation_collterr2},${type_habilitation_collterr1}],
    ${param_operateur} =  Replace String  ${param_operateur}  "categorie_tiers_amenageur_public": [4],  "categorie_tiers_amenageur_public": [${categorie_tiers_consulte_ampu}],
    ${param_operateur} =  Replace String  ${param_operateur}   "evenement" : 416  "evenement" : ${evenement_id}

    # param_operateur
    &{param_values} =  Create Dictionary
    ...  libelle=param_operateur
    ...  valeur=${param_operateur}
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=080GO1NOM
    ...  particulier_prenom=080GO1PRENOM
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  commune= 69259 - COMGO1
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    # @{departements_a_selectionner} =  Create List
    # ...  ${dept2_values.dep} - ${dept2_values.libelle}
    # ...  ${dept3_values.dep} - ${dept3_values.libelle}
    # Select From Multiple Chosen List   division_territoire_intervention_departement  ${departements_a_selectionner}

    # CAS A
    # On détecte seulement un opérateur INRAP
    Depuis le contexte du dossier d'instruction  ${di}
    Portlet Action Should Be In Form  dossier_instruction  designation_operateur
    Click On Form Portlet Action  dossier_instruction  designation_operateur  modale

    Portlet Action Should Be In Subform  dossier_operateur  recherche_operateur
    Click On SubForm Portlet Action  dossier_operateur  recherche_operateur

    Form Value Should Contain  css=#operateur_detecte_inrap  ${tiers_consulte_inrap}
    Element Should Contain  css=.field-type-tab_custom  Opérateur Collterr1
    Element Should Contain  css=.field-type-tab_custom  Opérateur Collterr3
    Element Should Contain  css=.field-type-tab_custom  Opérateur Collterr4
    Element Should Contain  css=.field-type-tab_custom  Consultation obligatoire
    Element Should Not Contain  css=.field-type-tab_custom  Opérateur Collterr2

    # Le message est ajouté dans le champ seulement si le type d'aggrément est "kpark"
    # donc on vérifie la valeur du champ
    Form Value Should Be  css=#operateur_message_kpark   Vous devez consulter les opérateurs au cas par cas depuis l'onglet Consultation

    Portlet Action Should Be In Subform  dossier_operateur  reinitialiser
    Portlet Action Should Be In Subform  dossier_operateur  modifier
    Click On SubForm Portlet Action  dossier_operateur  modifier

    Select From List By Value  css=#tab_avis_1  D
    Select From List By Value  css=#tab_avis_2  F
    Select From List By Value  css=#operateur_amenagement_pers_publique  t
    Select From List By Value  css=#operateur_pers_publique_amenageur  f
    Form Value Should Be  css=#message_consultation_amenageur  Vous devez consulter l'aménageur depuis l'onglet Consultation.
    Form Value Should Be  css=#message_consultation_tiers   Vous devez consulter le tiers sélectionné.
    Select From List By Value  css=#operateur_personne_publique  ${tiers_consulte_amenageur_public}
    Select From List By Value  css=#operateur_personne_publique_avis  F
    Click On Submit Button In Subform

    Form Value Should Be  css=#operateur_selectionne  ${tiers_consulte_collterr4}
    Form Value Should Be  css=#operateur_kpark_libelle  CAS G3

    Click On SubForm Portlet Action  dossier_operateur  modifier

    Select From List By Value  css=#tab_avis_1  F
    Select From List By Value  css=#tab_avis_2  D

    Click On Submit Button In Subform

    Form Value Should Be  css=#operateur_selectionne  ${tiers_consulte_collterr3}
    Form Value Should Be  css=#operateur_kpark_libelle  CAS G3

    Portlet Action Should Be In Subform  dossier_operateur  valider
    Click Element  css=#action-sousform-dossier_operateur-valider
    Click Element  xpath=//div[contains(@class, 'ui-dialog')]/descendant::div[contains(@class, 'ui-dialog-buttonset')]/button/span[text()='Confirmer']
    Click On Back Button In Subform
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Page Should Contain  ${args_evenement.libelle}
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  designation_operateur  modale
    Portlet Action Should Be In Subform  dossier_operateur  reinitialiser
    Click Element  css=#action-sousform-dossier_operateur-reinitialiser
    Click Element  xpath=//div[contains(@class, 'ui-dialog')]/descendant::div[contains(@class, 'ui-dialog-buttonset')]/button/span[text()='Confirmer']

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#operateur_designe  ${EMPTY}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#operateur_kpark_libelle  ${EMPTY}

    # On fait en sorte d'avoir seulement l'opérateur inrap de dispo
    ${param_operateur} =  Get File  ${EXECDIR}${/}binary_files${/}param_operateur.txt

    ${param_operateur} =  Replace String  ${param_operateur}  "type_habilitations_operateurs_inrap": [2],  "type_habilitations_operateurs_inrap": [${type_habilitation_inrap}],
    ${param_operateur} =  Replace String  ${param_operateur}  "categorie_tiers_inrap": [1, 2],  "categorie_tiers_inrap": [${categorie_tiers_consulte_inrap}],
    ${param_operateur} =  Replace String  ${param_operateur}  "categorie_tiers_collterr": [1,2],  "categorie_tiers_collterr": [99],
    ${param_operateur} =  Replace String  ${param_operateur}  "type_habilitations_operateurs_diag_kpark": [1, 2],  "type_habilitations_operateurs_diag_kpark": [99],
    ${param_operateur} =  Replace String  ${param_operateur}  "type_habilitations_operateurs_diag_toutdiag": [4,5],  "type_habilitations_operateurs_diag_toutdiag": [99],
    ${param_operateur} =  Replace String  ${param_operateur}  "categorie_tiers_amenageur_public": [4],  "categorie_tiers_amenageur_public": [${categorie_tiers_consulte_ampu}],
    ${param_operateur} =  Replace String  ${param_operateur}   "evenement" : 412  "evenement" : ${evenement_id}

    Modifier le paramètre  param_operateur  ${param_operateur}  agglo

    Depuis le contexte du dossier d'instruction  ${di}
    Portlet Action Should Be In Form  dossier_instruction  designation_operateur
    Click On Form Portlet Action  dossier_instruction  designation_operateur  modale

    Portlet Action Should Be In Subform  dossier_operateur  recherche_operateur
    Click On SubForm Portlet Action  dossier_operateur  recherche_operateur

    Form Value Should Be  css=#operateur_selectionne  ${tiers_consulte_inrap}
    Form Value Should Be  css=#operateur_kpark_libelle  CAS A

    # On vérifie qu'un dossier avec un opérateur peut être correctement supprimé
    Depuis la page d'accueil  admin  admin

    # On test la suppression du dossier qui est lié à un opérateur
    # on ne peut pas vérifier par l'interface que l'opérateur est
    # bien supprimé il faut vérifier en bdd
    # On active l'option de suppression
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    Depuis le contexte du dossier d'instruction  ${di}
    Supprimer l'instruction  ${di}  TEST_080

    Supprimer le dossier d'instruction  ${di}

    # On désactive l'option de suppression
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_mode_service_consulte
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_commune
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

Filtrage des tiers selon la collectivité/service de l'utilisateur
    [Documentation]  Vérifie que pour un utilisateur de la collectivité de niveau 2
    ...  la colonne "service" est visible dans le listing des tiers. Vérifie également
    ...  que la recherche avancé permet de filtrer par service.
    ...  En tant qu'administrateur d'une collectivité, vérifie que la colonne service et
    ...  la recherche par service ne sont plus visible tandis que le filtre par catégorie
    ...  ne propose que les catégories lié au service de l'utilisateur.
    ...  Vérifie qu'à l'ajout et la modification d'un tiers seule les catégories lié au
    ...  service de l'utilisateur apparaissent.

    # Ajout d'un nouveau tiers ayant une collectivité différentes
    Depuis la page d'accueil  admin  admin
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie ALLAUCH
    ...  abrege=TA
    ...  libelle=Tiers Allauch
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    &{lien_tiers_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Service consulté 2
    ...  tiers_consulte=Tiers Allauch
    Ajouter lien utilisateur / tiers consulté  ${lien_tiers_om_utilisateur}

    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie MA
    ...  abrege=TMA
    ...  libelle=tiers M/A
    ...  ville=MARSEILLE
    ...  liste_diffusion=support@atreal.fr
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${args_tiers}

    Depuis le listing  tiers_consulte
    Wait until element contains  css=th.title.lastcol span.name  collectivité
    # Test du filtre de la recherche avancée par service
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#om_collectivite
    Select From List By Label  css=div#adv-search-adv-fields select#om_collectivite  MARSEILLE
    Click On Search Button
    Element Should Contain  css=.tab-tab  MARSEILLE
    Element Should Contain  css=.tab-tab  Catégorie MA
    Element Should Not Contain  css=.tab-tab  ALLAUCH
    # Vérifie le contenu des select en ajout et en modification
    @{listeCategorie} =  Create List  Catégorie Marseille  Catégorie ALLAUCH  Catégorie MA
    Click On Add Button
    Select List Should Contain List  css=select#categorie_tiers_consulte  ${listeCategorie}
    Click On Back Button
    # Sélectionne le premier élément de la liste, accède à son formulaire de modification
    # et vérifie le contenu du select
    Click On Link  css=tbody > tr > td.col-1 > a.lienTable
    Wait until Page Contains Element  css=#tiers_consulte
    Click On Portlet Action  tiers_consulte  modifier
    Wait until Page Contains Element  css=select#categorie_tiers_consulte
    Select List Should Contain List  css=select#categorie_tiers_consulte  ${listeCategorie}

    # Vérification que pour le mode service consulté la colonne et le champs de recherche
    # s'appelle "service"
    # Activation du mode service consulté
    &{param_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_service_consulte}
    # Vérification des intitulé sur le listing des tiers
    Depuis le listing  tiers_consulte
    Wait until element contains  css=th.title.lastcol span.name  service
    Click Element  css=#toggle-advanced-display
    Wait Until Element Contains  css=div#adv-search-adv-fields label#lib-om_collectivite  Service
    # Désactivation du mode service consulté
    &{param_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_service_consulte}

    # Connexion en tant qu'administrateur de Marseille
    Depuis la page d'accueil  admingenmars  admingenmars
    Depuis le listing  tiers_consulte
    Wait until page contains element  css=#tab-tiers_consulte
    # La colonne service n'est plus affichée
    Element Should Not Contain  css=th.title.lastcol span.name  collectivité
    # La recherche par service n'est plus affichée
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#categorie_tiers_consulte
    Page Should Not Contain Element  css=div#adv-search-adv-fields select#om_collectivite
    # Seule les catégorie lié au service Marseille doivent pouvoir être sélectionnées
    @{listeCategorie} =  Create List  Catégorie Marseille  Catégorie MA
    @{list_value_unexpected} =  Create List  Catégorie ALLAUCH
    Select List Should Contain List  css=div#adv-search-adv-fields select#categorie_tiers_consulte  ${listeCategorie}
    Select List Should Not Contain List  css=div#adv-search-adv-fields select#categorie_tiers_consulte  ${list_value_unexpected}
    # Les tiers associé à d'autre service ne sont pas visible
    Element Should Not Contain  css=.tab-tab  ALLAUCH
    # Vérifie le contenu des select en ajout et en modification
    Click On Add Button
    Select List Should Contain List  css=select#categorie_tiers_consulte  ${listeCategorie}
    Select List Should Not Contain List  css=select#categorie_tiers_consulte  ${list_value_unexpected}
    Click On Back Button
    # Sélectionne le premier élément de la liste, accède à son formulaire de modification
    # et vérifie le contenu du select
    Click On Link  css=tbody > tr > td.col-1 > a.lienTable
    Wait until Page Contains Element  css=#tiers_consulte
    Click On Portlet Action  tiers_consulte  modifier
    Wait until Page Contains Element  css=select#categorie_tiers_consulte
    Select List Should Contain List  css=select#categorie_tiers_consulte  ${listeCategorie}
    Select List Should Not Contain List  css=select#categorie_tiers_consulte  ${list_value_unexpected}

Vérification du filtrage par libelle de catégorie de tiers consulté
    [Documentation]  Lorsque l'utilisateur se rend dans recherche avancée dans tiers consulté,
    ...  la recherche avancée doit filtrer correctement en retournant dans la liste
    ...  un filtrage par libelle.

    Depuis la page d'accueil  admin  admin

    # Ajout de catégories de tiers consulté
    &{args_cat_tiers} =  Create Dictionary
    ...  code=CW
    ...  description=Tiers de A
    ...  libelle=Catégorie A
    Ajouter la categorie de tiers consulte  ${args_cat_tiers}
    &{args_cat_tiers} =  Create Dictionary
    ...  code=CW
    ...  description=Tiers de B
    ...  libelle=Catégorie B
    Ajouter la categorie de tiers consulte  ${args_cat_tiers}
    &{args_cat_tiers} =  Create Dictionary
    ...  code=CW
    ...  description=Tiers de C
    ...  libelle=Catégorie C
    Ajouter la categorie de tiers consulte  ${args_cat_tiers}
    &{args_cat_tiers} =  Create Dictionary
    ...  code=CW
    ...  description=Tiers de D
    ...  libelle=Catégorie D
    Ajouter la categorie de tiers consulte  ${args_cat_tiers}

    # Ajout de tiers 
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie B
    ...  abrege=TNR_ACT
    ...  libelle=TNR ajout consultation tiers
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie A
    ...  abrege=TNR_ACT
    ...  libelle=TNR ajout consultation tiers
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie D
    ...  abrege=TNR_ACT
    ...  libelle=TNR ajout consultation tiers
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie C
    ...  abrege=TNR_ACT
    ...  libelle=TNR ajout consultation tiers
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    # Verifie que l'ordre est bien respecté 
    # en regardant que le premier element est bien celui attendu
    Depuis le listing  tiers_consulte
    Click Element  css=#toggle-advanced-display
    Element Should Contain  css=#categorie_tiers_consulte option:nth-of-type(2)  Catégorie A
