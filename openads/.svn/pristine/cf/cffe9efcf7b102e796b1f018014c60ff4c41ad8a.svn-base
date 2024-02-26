*** Settings ***
Documentation  Rubrique "Export / Import".

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Effectuer un export SITADEL
    [Documentation]  Vérifie que les utilisateurs avec différents profils
    ...  peuvent effectuer un export SITADEL

    # Profil CELLULE SUIVI
    Effectuer un export SITADEL avec l'utilisateur  suivi  suivi
    # Profil ADMINISTRATEUR GENERAL
    Effectuer un export SITADEL avec l'utilisateur  admingen  admingen
    # Profil INSTRUCTEUR POLYVALENT
    Effectuer un export SITADEL avec l'utilisateur  instrpoly  instrpoly
    # Profil INSTRUCTEUR POLYVALENT COMMUNE
    Effectuer un export SITADEL avec l'utilisateur  instrpolycomm  instrpolycomm
    # Profil GUICHET ET SUIVI
    Effectuer un export SITADEL avec l'utilisateur  guichetsuivi  guichetsuivi


Vérification de l'export SITADEL, des problèmes de cohérence et des champs de fusion

    [Documentation]  Vérifie le contenu du fichier SITADEL généré, le fichier
    ...  des problèmes de cohérence et les champs de fusion en rapport avec les
    ...  champs requis par SITADEL (évite de dupliquer les tests).

    # Création d'un nouvel utilisateur dans la commune d'Allauch pour tester
    # le filtrage de l'export par commune
    Depuis la page d'accueil  admin   admin
    @{new_user} =  Create List  penlaine  penlaine
    Ajouter l'utilisateur depuis le menu
    ...  Pull EnLaine
    ...  support@atreal.fr
    ...  @{new_user}
    ...  ADMINISTRATEUR GENERAL
    ...  ALLAUCH

    ##
    ## Concernant le nouveau tableau des SHON
    ##

    ${date_di_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  10 days  result_format=%Y-%m-%d
    ${date_di} =  Convert Date  ${date_di_db}  result_format=%d/%m/%Y
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Neville
    ...  particulier_prenom=Artois
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=${date_di}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # On modifie les valeurs du premier tableau des surfaces dans les données
    # techniques
    Depuis la page d'accueil  instr   instr
    &{donnees_techniques_values} =  Create Dictionary
    ...  su_avt_shon1=214
    ...  su_avt_shon2=213
    ...  su_avt_shon3=219
    ...  su_avt_shon4=224
    ...  su_avt_shon5=217
    ...  su_avt_shon6=218
    ...  su_avt_shon7=218
    ...  su_avt_shon8=218
    ...  su_avt_shon9=218
    ...  su_cstr_shon1=563
    ...  su_cstr_shon2=218
    ...  su_cstr_shon3=218
    ...  su_cstr_shon4=218
    ...  su_cstr_shon5=218
    ...  su_cstr_shon6=218
    ...  su_cstr_shon7=218
    ...  su_cstr_shon8=218
    ...  su_cstr_shon9=218
    ...  su_chge_shon1=218
    ...  su_chge_shon2=218
    ...  su_chge_shon3=218
    ...  su_chge_shon4=218
    ...  su_chge_shon5=218
    ...  su_chge_shon6=218
    ...  su_chge_shon7=218
    ...  su_chge_shon8=218
    ...  su_chge_shon9=218
    ...  su_demo_shon1=318
    ...  su_demo_shon2=218
    ...  su_demo_shon3=218
    ...  su_demo_shon4=218
    ...  su_demo_shon5=218
    ...  su_demo_shon6=218
    ...  su_demo_shon7=218
    ...  su_demo_shon8=218
    ...  su_demo_shon9=218
    ...  su_sup_shon1=218
    ...  su_sup_shon2=218
    ...  su_sup_shon3=218
    ...  su_sup_shon4=218
    ...  su_sup_shon5=218
    ...  su_sup_shon6=218
    ...  su_sup_shon7=218
    ...  su_sup_shon8=218
    ...  su_sup_shon9=218
    Modifier les données techniques pour le calcul des surfaces  ${di}  ${donnees_techniques_values}

    # On génère le fichier SITADEL
    Depuis la page d'accueil  guichetsuivi   guichetsuivi

    # On vérifie que la date de référence est celle de la dernirère modification
    # et non plus les dates saisies dans le dossier

    # On génère l'expport avec la date de dépôt du dossier
    ${content_file} =  Récupérer l'export SITADEL à la date souhaitée  ${date_di}  ${date_di}
    # On vérifie que dans le fichier téléchargé il n'y ai pas les valeurs
    # attendues
    ${expected_content_file} =  Set Variable  214|213|219|224|217|218|
    Should Not Contain  ${content_file}  ${expected_content_file}

    # On génère avec la date du jour qui est la date de dernière modification du
    # dossier
    # TNR vérifie que l'export SITADEL n'exporte que les dossiers de la commune
    # de l'utilisateur. Les modifications ne doivent donc pas apparaître dans
    # l'export
    Depuis la page d'accueil  @{new_user}
    ${content_file} =  Récupérer l'export SITADEL à la date souhaitée  ${DATE_FORMAT_DD/MM/YYYY}  ${DATE_FORMAT_DD/MM/YYYY}
    Should Not Contain  ${content_file}  DECISION_DI
    # On refait l'export mais avec un utilisateur rallié à la collectivité Marseille.
    # Les modifications doivent être présente dans l'export.
    Depuis la page d'accueil  guichetsuivi   guichetsuivi
    ${content_file} =  Récupérer l'export SITADEL à la date souhaitée  ${DATE_FORMAT_DD/MM/YYYY}  ${DATE_FORMAT_DD/MM/YYYY}
    # On vérifie que dans le fichier téléchargé les valeurs concernant le SHON
    # sont issues de la colonne "avt" du premier tableau des surfaces
    Should Contain  ${content_file}  ${expected_content_file}

    # On vérifie l'affichage des champs de fusion qui devraient avoir le même
    # comportement que dans SITADEL
    Depuis la page d'accueil  admin  admin
    # On ajoute une lettre type
    &{args_lettretype} =  Create Dictionary
    ...  id=lettre_info_su
    ...  libelle=Lettre d information des surfaces
    ...  sql=Récapitulatif du dossier d'instruction / instruction
    ...  titre=<p>Total surface créée : [su_cstr_shon_tot_donnees_techniques]</p><p>Total surface supprimée : [su_demo_shon_tot_donnees_techniques]</p><p>Total : [su_tot_shon_tot_donnees_techniques]</p><p>[tab_surface_donnees_techniques]</p>
    ...  corps=<p><br pagebreak="true" /></p><p>Total surface créée : [su_cstr_shon_tot_donnees_techniques]</p><p>Total surface supprimée : [su_demo_shon_tot_donnees_techniques]</p><p>Total : [su_tot_shon_tot_donnees_techniques]</p><p>[tab_surface_donnees_techniques]</p>
    ...  actif=true
    ...  collectivite=agglo
    Ajouter la lettre-type depuis le menu  &{args_lettretype}
    # On ajoute un événement
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=Lettre information surfaces
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=lettre_info_su Lettre d information des surfaces
    Ajouter l'événement depuis le menu  ${args_evenement}
    # On ajoute l'événement d'instruction au dossier
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    Ajouter une instruction au DI  ${di}  Lettre information surfaces
    # On contrôle le contenu du PDF
    Depuis l'instruction du dossier d'instruction  ${di}  Lettre information surfaces
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  Total surface créée : 2307
    PDF Page Number Should Contain  1  Total surface supprimée : 2062
    PDF Page Number Should Contain  1  Total : 2204
    PDF Page Number Should Contain  1  Habitation - 563 m²
    # On contrôle le corps
    PDF Page Number Should Contain  2  Total surface créée : 2307
    PDF Page Number Should Contain  2  Total surface supprimée : 2062
    PDF Page Number Should Contain  2  Total : 2204
    PDF Page Number Should Contain  2  Habitation - 563 m²
    # On ferme le PDF
    Close PDF

    # On ajoute des valeurs sur le second tableau des surfaces pour qu'il soit
    # récupéré pour le fichier SITADEL à la place des valeurs du tableau 1
    Depuis la page d'accueil  instr   instr
    &{donnees_techniques_values} =  Create Dictionary
    ...  su2_avt_shon1=14
    ...  su2_avt_shon2=14
    ...  su2_avt_shon3=87
    ...  su2_avt_shon4=4
    ...  su2_avt_shon5=2
    ...  su2_avt_shon6=22
    ...  su2_avt_shon7=33
    ...  su2_avt_shon8=10
    ...  su2_avt_shon10=10
    ...  su2_avt_shon11=10
    ...  su2_avt_shon12=10
    ...  su2_avt_shon13=10
    ...  su2_avt_shon14=10
    ...  su2_avt_shon15=10
    ...  su2_avt_shon16=10
    ...  su2_avt_shon17=123
    ...  su2_avt_shon18=47
    ...  su2_avt_shon19=69
    ...  su2_avt_shon20=10
    ...  su2_avt_shon21=22
    ...  su2_avt_shon22=22
    ...  su2_cstr_shon1=14
    ...  su2_cstr_shon2=6
    ...  su2_cstr_shon3=51
    ...  su2_cstr_shon4=8
    ...  su2_cstr_shon5=8
    ...  su2_cstr_shon6=8
    ...  su2_cstr_shon7=8
    ...  su2_cstr_shon8=8
    ...  su2_cstr_shon10=8
    ...  su2_cstr_shon11=8
    ...  su2_cstr_shon12=8
    ...  su2_cstr_shon13=8
    ...  su2_cstr_shon14=8
    ...  su2_cstr_shon15=8
    ...  su2_cstr_shon16=8
    ...  su2_cstr_shon17=8
    ...  su2_cstr_shon18=8
    ...  su2_cstr_shon19=8
    ...  su2_cstr_shon20=8
    ...  su2_cstr_shon21=4
    ...  su2_cstr_shon22=4
    ...  su2_chge_shon1=8
    ...  su2_chge_shon2=8
    ...  su2_chge_shon3=8
    ...  su2_chge_shon4=8
    ...  su2_chge_shon5=8
    ...  su2_chge_shon6=8
    ...  su2_chge_shon7=8
    ...  su2_chge_shon8=8
    ...  su2_chge_shon10=8
    ...  su2_chge_shon11=8
    ...  su2_chge_shon12=8
    ...  su2_chge_shon13=8
    ...  su2_chge_shon14=8
    ...  su2_chge_shon15=8
    ...  su2_chge_shon16=8
    ...  su2_chge_shon17=8
    ...  su2_chge_shon18=8
    ...  su2_chge_shon19=8
    ...  su2_chge_shon20=8
    ...  su2_chge_shon21=4
    ...  su2_chge_shon22=4
    ...  su2_demo_shon1=19
    ...  su2_demo_shon2=63
    ...  su2_demo_shon3=8
    ...  su2_demo_shon4=8
    ...  su2_demo_shon5=8
    ...  su2_demo_shon6=8
    ...  su2_demo_shon7=8
    ...  su2_demo_shon8=8
    ...  su2_demo_shon10=8
    ...  su2_demo_shon11=8
    ...  su2_demo_shon12=8
    ...  su2_demo_shon13=8
    ...  su2_demo_shon14=8
    ...  su2_demo_shon15=8
    ...  su2_demo_shon16=8
    ...  su2_demo_shon17=8
    ...  su2_demo_shon18=8
    ...  su2_demo_shon19=8
    ...  su2_demo_shon20=8
    ...  su2_demo_shon21=4
    ...  su2_demo_shon22=4
    ...  su2_sup_shon1=8
    ...  su2_sup_shon2=8
    ...  su2_sup_shon3=8
    ...  su2_sup_shon4=8
    ...  su2_sup_shon5=8
    ...  su2_sup_shon6=8
    ...  su2_sup_shon7=8
    ...  su2_sup_shon8=8
    ...  su2_sup_shon10=8
    ...  su2_sup_shon11=8
    ...  su2_sup_shon12=8
    ...  su2_sup_shon13=8
    ...  su2_sup_shon14=8
    ...  su2_sup_shon15=8
    ...  su2_sup_shon16=8
    ...  su2_sup_shon17=8
    ...  su2_sup_shon18=8
    ...  su2_sup_shon19=8
    ...  su2_sup_shon20=8
    ...  su2_sup_shon21=4
    ...  su2_sup_shon22=4
    Modifier les données techniques pour le calcul des surfaces  ${di}  ${donnees_techniques_values}

    # On génère le fichier SITADEL
    Depuis la page d'accueil  guichetsuivi   guichetsuivi
    ${content_file} =  Récupérer l'export SITADEL à la date souhaitée  ${DATE_FORMAT_DD/MM/YYYY}  ${DATE_FORMAT_DD/MM/YYYY}
    # On vérifie que dans le fichier téléchargé les valeurs concernant le SHON
    # ont changées
    # Correspondance d'après la ligne "avt" testée :
    # 91 = shon3+shon4
    # 44 = shon9 (ou shon21+22)
    # 69 = shon19
    # 67 = shon5+shon6+shon7+shon8
    # 0 = pas de correspondance
    # 123 = shon17
    # 28 = shon1+shon2
    # 47 = shon18
    # 80 = shon10+shon11+shon12+shon13+shon14+shon15+shon16+shon20
    ${expected_content_file} =  Set Variable  91|44|69|67|0|123|28|47|80|
    Should Contain  ${content_file}  ${expected_content_file}

    # On vérifie que les champs de fusion utilisent les valeurs du second
    # tableau
    # On contrôle le contenu du PDF
    Depuis l'instruction du dossier d'instruction  ${di}  Lettre information surfaces
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  Total surface créée : 207
    PDF Page Number Should Contain  1  Total surface supprimée : 226
    PDF Page Number Should Contain  1  Total : 530
    PDF Page Number Should Contain  1  Exploitation agricole - 14 m²
    # On contrôle le corps
    PDF Page Number Should Contain  2  Total surface créée : 207
    PDF Page Number Should Contain  2  Total surface supprimée : 226
    PDF Page Number Should Contain  2  Total : 530
    PDF Page Number Should Contain  2  Exploitation agricole - 14 m²
    # On ferme le PDF
    Close PDF

    ##
    ## Contrôle la colonne de la version du dossier d'instruction (colonne 8)
    ##

    # On ajoute une demande sur laquelle plusieurs modificatifs seront ajoutés
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lejeune
    ...  particulier_prenom=Nicolas
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # On clôture le dossier pour ajouter un modificatif
    Depuis la page d'accueil  instrpoly   instrpoly
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve

    # On ajoute un modificatif sur le dossier d'instruction
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di}
    ${di_modif} =  Ajouter la demande par WS  ${args_demande}
    # On clôture le modificatif
    Ajouter une instruction au DI et la finaliser  ${di_modif}  accepter un dossier sans réserve

    # On ajoute un modificatif sur le dossier d'instruction
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di}
    ${di_modif_2} =  Ajouter la demande par WS  ${args_demande}
    # On clôture le modificatif
    Ajouter une instruction au DI et la finaliser  ${di_modif_2}  accepter un dossier sans réserve

    # On ajoute une DAACT sur le dossier d'instruction pour que le prochain
    # modificatif ait le champ dossier.version à 4
    &{args_demande} =  Create Dictionary
    ...  demande_type=Déclaration attestant l'achèvement et la conformité des travaux
    ...  dossier_instruction=${di}
    ${di_daact} =  Ajouter la demande par WS  ${args_demande}
    # On clôture la DAACT
    Ajouter une instruction au DI et la finaliser  ${di_daact}  accepter un dossier sans réserve
    Ajouter une instruction au DI  ${di_daact}  Declaration ouverture de chantier
    Ajouter une instruction au DI  ${di_daact}  Declaration attestation achevement conformite travaux
    &{args_cerfa} =  Create Dictionary
    ...  daact_surf=100
    Saisir les données techniques du DI  ${di_daact}  ${args_cerfa}

    Click On Back Button In Subform
    # On ajoute un modificatif sur le dossier d'instruction qui doit avoir son
    # indice dans SITADEL (la colonne 8 dde l'export) à 3 malgré sa version à 4
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di}
    ${di_modif_3} =  Ajouter la demande par WS  ${args_demande}
    # On clôture le modificatif
    Ajouter une instruction au DI et la finaliser  ${di_modif_3}  accepter un dossier sans réserve

    # On ajoute un dossier d'annulation
    Depuis la page d'accueil  admin  admin
    &{args_dit} =  Create Dictionary
    ...  code=ANNUL
    ...  libelle=Demande d'annulation TEST070
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  suffixe=true
    ...  mouvement_sitadel=DEPOT
    ...  maj_da_etat=true
    Ajouter type de dossier d'instruction  ${args_dit}
    @{etats_autorises} =  Create List
    ...  dossier accepter
    &{args_dt} =  Create Dictionary
    ...  code=ANNUL
    ...  libelle=Demande d'annulation TEST070
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=${etats_autorises}
    ...  contraintes=Récupération des demandeurs avec modification et ajout
    ...  dossier_instruction_type=PCI - Demande d'annulation TEST070
    ...  evenement=Notification du delai legal maison individuelle
    Ajouter un nouveau type de demande depuis le menu  ${args_dt}
    &{args_action} =  Create Dictionary
    ...  regle_avis=avis_decision
    ...  regle_date_decision=date_evenement
    Modifier Action  abandon  ${args_action}
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - ANNUL - Demande d'annulation TEST070
    &{args_evenement} =  Create Dictionary
    ...  libelle=Abandonner les travaux depuis ANNUL TEST070
    ...  type=arrete
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=abandon par le demandeur
    ...  etat=instruction terminee (archive)
    ...  avis_decision=Abandon des Travaux
    Ajouter l'événement depuis le menu  ${args_evenement}
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande d'annulation TEST070
    ...  dossier_instruction=${di}
    ${di_annul} =  Ajouter la demande par WS  ${args_demande}
    Ajouter une instruction au DI  ${di_annul}  Abandonner les travaux depuis ANNUL TEST070

    # On génère le fichier SITADEL
    Depuis la page d'accueil  guichetsuivi   guichetsuivi
    ${content_file} =  Récupérer l'export SITADEL à la date souhaitée  ${DATE_FORMAT_DD/MM/YYYY}  ${DATE_FORMAT_DD/MM/YYYY}
    # On vérifie que dans le fichier téléchargé la colonne correspondant à la
    # version ait la bonne valeur pour chaque DI
    ${numero_di} =  Get Substring  ${di}  13  18
    ${year} =  Get Time  year
    ${yy} =  Get Substring  ${year}  2  4
    ${expected_content_file_1} =  Set Variable  DEPOT|PC||||${yy}|${numero_di}||1||NICOLAS|LEJEUNE
    ${expected_content_file_2} =  Set Variable  DECISION|PC||||${yy}|${numero_di}||1|4
    ${expected_content_file_3} =  Set Variable  DEPOT|PC||||${yy}|${numero_di}|01|1||NICOLAS|LEJEUNE
    ${expected_content_file_4} =  Set Variable  MODIFICATIF|PC||||${yy}|${numero_di}|01|1|4
    ${expected_content_file_5} =  Set Variable  DEPOT|PC||||${yy}|${numero_di}|02|1||NICOLAS|LEJEUNE
    ${expected_content_file_6} =  Set Variable  MODIFICATIF|PC||||${yy}|${numero_di}|02|1|4
    ${expected_content_file_7} =  Set Variable  DEPOT|PC||||${yy}|${numero_di}|03|1||NICOLAS|LEJEUNE
    ${expected_content_file_8} =  Set Variable  MODIFICATIF|PC||||${yy}|${numero_di}|03|1|4
    ${expected_content_file_9} =  Set Variable  DEPOT|PC||||${yy}|${numero_di}||1||NICOLAS|LEJEUNE
    ${expected_content_file_10} =  Set Variable  DECISION|PC||||${yy}|${numero_di}||1|8
    ${expected_content_file_11} =  Set Variable  SUIVI|PC||||${yy}|${numero_di}
    Should Contain  ${content_file}  ${expected_content_file_1}
    Should Contain  ${content_file}  ${expected_content_file_2}
    Should Contain  ${content_file}  ${expected_content_file_3}
    Should Contain  ${content_file}  ${expected_content_file_4}
    Should Contain  ${content_file}  ${expected_content_file_5}
    Should Contain  ${content_file}  ${expected_content_file_6}
    Should Contain  ${content_file}  ${expected_content_file_7}
    Should Contain  ${content_file}  ${expected_content_file_8}
    Should Contain  ${content_file}  ${expected_content_file_9}
    Should Contain  ${content_file}  ${expected_content_file_10}
    Should Contain  ${content_file}  ${expected_content_file_11}

    # On génère à nouveau le fichier SITADEL, celui-ci devrait être vide car le
    # hash des lignes SITADEL sauvegardés sur les dossiers devraient exclure les
    # dossiers en question
    ${content_file} =  Récupérer l'export SITADEL à la date souhaitée  ${DATE_FORMAT_DD/MM/YYYY}  ${DATE_FORMAT_DD/MM/YYYY}
    Should Not Contain  ${content_file}  ${expected_content_file_1}
    Should Not Contain  ${content_file}  ${expected_content_file_2}
    Should Not Contain  ${content_file}  ${expected_content_file_3}
    Should Not Contain  ${content_file}  ${expected_content_file_4}
    Should Not Contain  ${content_file}  ${expected_content_file_5}
    Should Not Contain  ${content_file}  ${expected_content_file_6}
    Should Not Contain  ${content_file}  ${expected_content_file_7}
    Should Not Contain  ${content_file}  ${expected_content_file_8}
    Should Not Contain  ${content_file}  ${expected_content_file_9}
    Should Not Contain  ${content_file}  ${expected_content_file_10}
    Should Not Contain  ${content_file}  ${expected_content_file_11}

    # On modifie les données techniques du premier dossier afin de vérifier
    # que le hash soit différent est donc qu'il soit dans le fichier d'export
    # SITADEL
    Depuis la page d'accueil  instr   instr
    &{donnees_techniques_values} =  Create Dictionary
    ...  su_avt_shon1=500
    Modifier les données techniques pour le calcul des surfaces  ${di}  ${donnees_techniques_values}
    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    ${content_file} =  Récupérer l'export SITADEL à la date souhaitée  ${DATE_FORMAT_DD/MM/YYYY}  ${DATE_FORMAT_DD/MM/YYYY}
    ${expected_content_file} =  Set Variable  500|213|219|224|217|218|
    Should Not Contain  ${content_file}  ${expected_content_file}


Versement aux archives

    [Documentation]  'Export / Import > Versement Aux Archives'. Cet écran
    ...  permet de mettre à jour le champ 'numéro archive' d'une liste de
    ...  dossiers d'instruction grâce à un fichier CSV.

    ##
    ## Étape n°1
    ##
    ## En tant qu'in profil SUIVI, on accède à l'écran dédié à l'import de CSV
    ## de numéro d'archive, et on vérifie les particularités du formulaire :
    ## - fichier obligatoires
    ## - fichier avec un extension .csv
    ## Ensuite on importe un fichier CSV de test qui met à jour des données
    ## existantes.
    ##
    # On se connecte avec un profil 'SUIVI'
    Depuis la page d'accueil  suivi  suivi
    # On accède à l'acran dédié pour réaliser l'import
    Go To Submenu In Menu  edition  versement_archives
    Page Title Should Be  Export / Import > Versement Aux Archives
    # On remplit le champ "insee"
    Input Text  css=#insee  01234
    # On tente d'ajouter un fichier avec une mauvais extension
    Add File and Expect Error Message Be  fichier  lettre_rar16042013124515.pdf  Le fichier n'est pas conforme à la liste des extension(s) autorisée(s) (.csv). [lettre_rar16042013124515.pdf]
    # On clic sur le bouton "Importer"
    Click Element  css=div.formControls input
    # On vérifie le message d'erreur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Error Message Should Be  Vous n'avez pas sélectionné de fichier à importer.
    # On vérifie que le code insee est toujours celui indiqué par
    # l'utilisateur
    Form Value Should Be  css=#insee  01234
    # On ajoute un fichier correct
    Add File  fichier  versement_archives.csv
    # On clic sur le bouton "Importer"
    Click Element  css=div.formControls input
    # On vérifie qu'il y a le message de validation d'import du csv
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Il y a eu 6 ligne(s) lue(s), 1 ligne(s) acceptée(s), 3 ligne(s) rejetée(s) et 2 ligne(s) ignorée(s)

    # Télécharge le fichier d'export CSV sur le disque
    ${link} =  Get Element Attribute  css=div.message a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    # On vérifie dans le fichier téléchargé que l'entête correspond à ce qui est attendu
    ${content_file} =  Get File  ${full_path_to_file}
    ${firstline_csv_file} =  Set Variable  03185;08;PC;1;0;1025W;111111;"ligne ignorée : code insee différent de celui indiqué dans le formulaire."
    Should Contain  ${content_file}  ${firstline_csv_file}


    ##
    ## Étape 2
    ##
    ## En tant que profil 'INSTRUCTEUR', on accède à un dossier concerné pour
    ## vérifier que le numéro d'archive a été mis à jour.
    ##
    # On se connecte en tant que "instr"
    Depuis la page d'accueil  instr  instr
    # On clique sur le dossier d'instruction ("PC 013055 12 00001P0")
    Depuis le contexte du dossier d'instruction  PC 013055 12 00001P0
    # On vérifie le numéro de versement aux archives
    Element Should Contain  css=#numero_versement_archive  1025W 444444


Statistiques d'usage

    [Documentation]  Vérifie l'export mono et multi des statistiques d'usage
    ...  ainsi que la prise en compte des dates

    # Nouvelle collectivité mono NICE
    Depuis la page d'accueil  admin  admin
    Ajouter la collectivité depuis le menu  NICE  mono

    # Création d'un DI de NICE
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Missy
    ...  particulier_prenom=Julien
    ...  om_collectivite=NICE
    &{args_demande} =  Create Dictionary
    ...  date_demande=25/06/2009
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=NICE
    ${di_allauch} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #
    # MONO
    #
    Depuis la page d'accueil  guichet   guichet
    Depuis le menu des statistiques à la demande
    Click On Link  statistiques_usage
    Choix du format de sortie CSV
    Exécuter la reqmo
    ${link} =  Lien téléchargement CSV
    ${content_file} =  Contenu CSV  ${link}
    # On vérifie dans le fichier téléchargé que l'entête correspond à ce qui est attendu
    ${header_csv_file} =  Set Variable  référence dossier instruction;référence dossier autorisation;commune;division dossier;code type da détaillé;libellé type da détaillé;code type di;libellé type di;identifiant instructeur;nom instructeur;division instructeur;direction instructeur;date dépôt initial;date limite instruction;date décision;état di;total instructions;total consultations;simulation taxes part communale;simulation taxes part départementale;simulation taxes total;description du projet;
    Should Contain  ${content_file}  ${header_csv_file}
    # On vérifie qu'il y a des dossiers mono de collectivité unique
    Should Contain  ${content_file}  MARSEILLE
    Should Not Contain  ${content_file}  NICE

    #
    # MULTI
    #
    Depuis la page d'accueil  admingen   admingen
    Depuis le menu des statistiques à la demande
    Click On Link  statistiques_usage
    Choix du format de sortie CSV
    Exécuter la reqmo
    ${link} =  Lien téléchargement CSV
    ${content_file} =  Contenu CSV  ${link}
    # On vérifie dans le fichier téléchargé que l'entête correspond à ce qui est attendu
    ${header_csv_file} =  Set Variable  référence dossier instruction;référence dossier autorisation;commune;division dossier;code type da détaillé;libellé type da détaillé;code type di;libellé type di;identifiant instructeur;nom instructeur;division instructeur;direction instructeur;date dépôt initial;date limite instruction;date décision;état di;total instructions;total consultations;simulation taxes part communale;simulation taxes part départementale;simulation taxes total;description du projet;
    Should Contain  ${content_file}  ${header_csv_file}
    # On vérifie qu'il y a des dossiers mono de collectivité différente
    Should Contain  ${content_file}  MARSEILLE
    Should Contain  ${content_file}  NICE

    #
    # DATE DE DEPOT
    #
    Click On Link  Retour
    Choix du format de sortie CSV
    Input Text  css=input[name='date_depot_debut']  25/06/2009
    Input Text  css=input[name='date_depot_fin']  25/06/2009
    Exécuter la reqmo
    ${link} =  Lien téléchargement CSV
    ${content_file} =  Contenu CSV  ${link}
    # On vérifie qu'il n'y a que le dossier de nice
    Should Not Contain  ${content_file}  MARSEILLE
    Should Contain  ${content_file}  NICE


Vérification des listes simplifiées
    [Documentation]  On verifie les retours des ReqMo concernant les listes simplifiées


    @{colonne_valeur_dossier_simplifiee} =    Create List
    ...  numéro de dossier
    ...  date de dépôt
    ...  petitionnaire principal
    ...  localisation
    ...  shon
    ...  libellé de la destination

    &{args_export_dossier_simplifiee} =  Create Dictionary
    ...  reqmo=dossier_simplifiee
    ...  dossier_autorisation_type=PC
    ...  nom_champ_debut=date_depot_debut
    ...  date_debut=01/12/2012
    ...  nom_champ_fin=date_depot_fin
    ...  date_fin=01/01/2013
    ...  colonne_valeurs=${colonne_valeur_dossier_simplifiee}
    ...  content=PC 013055 12 00001P0

    @{colonne_valeur_dossier_simplifiee_accordes} =    Create List
    ...  numéro de dossier
    ...  date de décision
    ...  petitionnaire principal
    ...  localisation
    ...  shon
    ...  libellé de la destination

    &{args_export_dossier_simplifiee_accordes} =  Create Dictionary
    ...  reqmo=dossier_simplifiee_accordes
    ...  dossier_autorisation_type=PA
    ...  nom_champ_debut=date_decision_debut
    ...  date_debut=01/08/2010
    ...  nom_champ_fin=date_decision_fin
    ...  date_fin=01/09/2010
    ...  colonne_valeurs=${colonne_valeur_dossier_simplifiee_accordes}
    ...  content=PA 013055 12 00001

    @{colonne_valeur_dossier_simplifiee_deposes} =    Create List
    ...  numéro de dossier
    ...  date de dépôt
    ...  petitionnaire principal
    ...  localisation
    ...  shon
    ...  libellé de la destination

    &{args_export_dossier_simplifiee_deposes} =  Create Dictionary
    ...  reqmo=dossier_simplifiee_deposes
    ...  dossier_autorisation_type=AT
    ...  nom_champ_debut=date_depot_debut
    ...  date_debut=01/12/2012
    ...  nom_champ_fin=date_depot_fin
    ...  date_fin=01/01/2013
    ...  colonne_valeurs=${colonne_valeur_dossier_simplifiee_deposes}
    ...  content=AT 013055 12 00001P0

    @{colonne_valeur_dossier_simplifiee_refuses} =    Create List
    ...  numéro de dossier
    ...  date de décision
    ...  petitionnaire principal
    ...  localisation
    ...  shon
    ...  libellé de la destination

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Vadeboncoeur
    ...  particulier_prenom=Théodore
    ...  om_collectivite=agglo

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=27/11/1994
    ...  om_collectivite=agglo

    Depuis la page d'accueil  admin  admin
    Vérifier List Dans Export Tableau  ${args_export_dossier_simplifiee}
    Vérifier List Dans Export Tableau  ${args_export_dossier_simplifiee_accordes}
    Vérifier List Dans Export Tableau  ${args_export_dossier_simplifiee_deposes}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Set Suite Variable  ${di}



    &{args_export_dossier_simplifiee_refuses} =  Create Dictionary
    ...  reqmo=dossier_simplifiee_refuses
    ...  dossier_autorisation_type=PC
    ...  nom_champ_debut=date_decision_debut
    ...  date_debut=27/10/1994
    ...  nom_champ_fin=date_decision_fin
    ...  date_fin=27/12/1994
    ...  colonne_valeurs=${colonne_valeur_dossier_simplifiee_refuses}
    ...  content=${di}

    Ajouter une instruction au DI  ${di}  refus HS  28/11/1994
    Vérifier List Dans Export Tableau  ${args_export_dossier_simplifiee_refuses}

Vérification Listes Détaillées
  [Documentation]  On verifie les retours des ReqMo concernant les listes detaillées
    @{colonne_valeur_dossier_detaillee} =    Create List
    ...  numéro de dossier
    ...  date de dépôt
    ...  date d'ouverture de chantier
    ...  date de demande
    ...  date achèvement
    ...  date prévue de recevabilité
    ...  destination des surfaces
    ...  petitionnaire principal
    ...  localisation
    ...  référence cadastrale
    ...  date de décision
    ...  shon
    ...  architecte
    ...  affectation_surface
    ...  nature des travaux
    ...  nature du financement
    ...  nombre de logements
    ...  autorité compétente
    ...  décision

    &{args_export_dossier_detaillee} =  Create Dictionary
    ...  reqmo=dossier_detaillee
    ...  dossier_autorisation_type=PC
    ...  nom_champ_debut=date_depot_debut
    ...  date_debut=01/12/2012
    ...  nom_champ_fin=date_depot_fin
    ...  date_fin=01/01/2013
    ...  colonne_valeurs=${colonne_valeur_dossier_detaillee}
    ...  content=PC 013055 12 00001P0

    @{colonne_valeur_dossier_detaillee_accordes} =  Create List
    ...  numéro de dossier
    ...  date de dépôt
    ...  date d'ouverture de chantier
    ...  date de demande
    ...  date achèvement
    ...  date prévue de recevabilité
    ...  destination des surfaces
    ...  petitionnaire principal
    ...  localisation
    ...  référence cadastrale
    ...  date de décision
    ...  shon
    ...  affectation_surface
    ...  nature du financement
    ...  nombre de logements
    ...  autorité compétente
    ...  décision

    &{args_export_dossier_detaillee_accordes} =  Create Dictionary
    ...  reqmo=dossier_detaillee_accordes
    ...  dossier_autorisation_type=PA
    ...  nom_champ_debut=date_decision_debut
    ...  date_debut=01/08/2010
    ...  nom_champ_fin=date_decision_fin
    ...  date_fin=01/09/2010
    ...  colonne_valeurs=${colonne_valeur_dossier_detaillee_accordes}
    ...  content=PA 013055 12 00001

    @{colonne_valeur_dossier_detaillee_detail} =    Create List
    ...  numéro de dossier
    ...  date de dépôt
    ...  date d'ouverture de chantier
    ...  date de demande
    ...  date achèvement
    ...  date prévue de recevabilité
    ...  destination des surfaces
    ...  petitionnaire principal
    ...  localisation
    ...  référence cadastrale
    ...  date de décision
    ...  shon
    ...  architecte
    ...  affectation_surface
    ...  nature des travaux
    ...  nature du financement
    ...  nombre de logements
    ...  autorité compétente
    ...  décision

    &{args_export_dossier_detaillee_detail} =  Create Dictionary
    ...  reqmo=dossier_detaillee_detail
    ...  nom_champ_debut=date_decision_debut
    ...  date_debut=01/08/2010
    ...  nom_champ_fin=date_decision_fin
    ...  date_fin=01/09/2010
    ...  colonne_valeurs=${colonne_valeur_dossier_detaillee_detail}
    ...  content=aucun enregistrement

    @{colonne_valeur_dossier_detaillee_refuses} =    Create List
    ...  numéro de dossier
    ...  date de dépôt
    ...  date d'ouverture de chantier
    ...  date de demande
    ...  date achèvement
    ...  date prévue de recevabilité
    ...  destination des surfaces
    ...  petitionnaire principal
    ...  localisation
    ...  référence cadastrale
    ...  date de décision
    ...  shon
    ...  affectation_surface
    ...  nature du financement
    ...  nombre de logements
    ...  autorité compétente
    ...  décision

    &{args_export_dossier_detaillee_refuses} =  Create Dictionary
    ...  reqmo=dossier_detaillee_refuses
    ...  dossier_autorisation_type=PC
    ...  nom_champ_debut=date_decision_debut
    ...  date_debut=27/10/1994
    ...  nom_champ_fin=date_decision_fin
    ...  date_fin=27/12/1994
    ...  colonne_valeurs=${colonne_valeur_dossier_detaillee_refuses}
    ...  content=${di}

    Depuis la page d'accueil  admin  admin
    Vérifier List Dans Export Tableau  ${args_export_dossier_detaillee}
    Vérifier List Dans Export Tableau  ${args_export_dossier_detaillee_accordes}
    Vérifier List Dans Export Tableau  ${args_export_dossier_detaillee_detail}
    Vérifier List Dans Export Tableau  ${args_export_dossier_detaillee_refuses}


Vérification des éditions du module pilotage
    [Documentation]  Test les 3 éditions PDF du module de pilotage


    @{colonne_valeur_dossier_premiers_depots_dttm} =    Create List
    ...  N° DE DOSSIER
    ...  DATE DE DÉPÔT
    ...  PÉTITIONNAIRE PRINCIPAL
    ...  LOCALISATION

    &{args_export_dossier_premiers_depots_dttm} =  Create Dictionary
    ...  reqmo=dossier_premiers_depots_dttm
    ...  dossier_instruction_type=PCI - P - Initial
    ...  nom_champ_debut=date_depot_debut
    ...  date_debut=01/12/2012
    ...  nom_champ_fin=date_depot_fin
    ...  date_fin=01/01/2013
    ...  colonne_valeurs=${colonne_valeur_dossier_premiers_depots_dttm}
    ...  content=PC 013055 12 00001P0

    @{colonne_valeur_dossier_depots_division} =    Create List
    ...  N° DE DOSSIER
    ...  DIVISION
    ...  PÉTITIONNAIRE PRINCIPAL
    ...  LOCALISATION

    &{args_export_dossier_depots_division} =  Create Dictionary
    ...  reqmo=dossier_depots_division
    ...  nom_champ_debut=date_depot_debut
    ...  date_debut=01/12/2012
    ...  nom_champ_fin=date_depot_fin
    ...  date_fin=01/01/2013
    ...  colonne_valeurs=${colonne_valeur_dossier_depots_division}
    ...  content=PC 013055 12 00001P0

    @{colonne_valeur_dossier_transmission_dttm_signature_prefet} =    Create List
    ...  N° DE DOSSIER
    ...  DATE DE RETOUR SIGNATURE
    ...  PÉTITIONNAIRE PRINCIPAL
    ...  LOCALISATION

    &{args_export_dossier_transmission_dttm_signature_prefet} =  Create Dictionary
    ...  reqmo=dossier_transmission_dttm_signature_prefet
    ...  dossier_instruction_type=AT - P - Initiale
    ...  nom_champ_debut=date_retour_signature_debut
    ...  date_debut=07/10/2016
    ...  nom_champ_fin=date_retour_signature_fin
    ...  date_fin=07/12/2016
    ...  colonne_valeurs=${colonne_valeur_dossier_transmission_dttm_signature_prefet}
    ...  not_content=AT 013055 13 00001P0

    Depuis la page d'accueil  admin  admin
    Vérifier List Dans Export PDF  ${args_export_dossier_premiers_depots_dttm}
    Vérifier List Dans Export PDF  ${args_export_dossier_depots_division}
    Vérifier List Dans Export PDF  ${args_export_dossier_transmission_dttm_signature_prefet}


Export statistique des déclarations d'intentions d'aliéner
    [Documentation]  Vérifie l'export mono et multi des déclarations d'intentions d'aliéner
    ...  ainsi que la prise en compte des dates de décision

    # On prépare une date (date du jour + 300 jours)
    ${date_jour_add_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  300 days  result_format=%Y-%m-%d
    ${date_jour_add_form} =  Convert Date  ${date_jour_add_db}  result_format=%d/%m/%Y

    #
    # Pour le cas d'un utilisateur de collectivité de niveau 2
    #

    Depuis la page d'accueil  admingen  admingen
    &{param_values_1} =  Create Dictionary
    ...  libelle=id_datd_filtre_reqmo_dossier_dia
    ...  valeur=1
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values_1}
    Ajouter la collectivité depuis le menu  PEYPIN  mono
    Ajouter la collectivité depuis le menu  ROQUEVAIRE  mono
    Ajouter l'utilisateur  Bilodeau Simone  support@atreal.fr  guichetroq  guichetroq  GUICHET UNIQUE  ROQUEVAIRE

    # On ajoute un dossier d'instruction clôturé à la date du jour sur la
    # collectivité de ROQUEVAIRE
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Leonardo
    ...  particulier_prenom=Bleu
    ...  om_collectivite=ROQUEVAIRE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=ROQUEVAIRE
    ${di_roquevaire} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_roquevaire}  accepter un dossier sans réserve  false  ${DATE_DDMMYYYY}

    # On ajoute deux dossiers d'instruction dont un clôturé à une date dans le
    # futur sur la collectivité de PEYPIN
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Michelangelo
    ...  particulier_prenom=Orange
    ...  om_collectivite=PEYPIN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=PEYPIN
    ${di_peypin_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    @{ref_cad} =  Create List  012  AA  0012
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Raph
    ...  particulier_prenom=Rouge
    ...  om_collectivite=PEYPIN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=PEYPIN
    ...  terrain_adresse_voie_numero=900
    ...  terrain_adresse_voie=A1
    ...  terrain_adresse_lieu_dit=PEYPIN
    ...  terrain_adresse_code_postal=13124
    ...  terrain_adresse_cedex=PEYPIN
    ...  terrain_references_cadastrales=${ref_cad}
    ...  terrain_adresse_bp=13124
    ...  terrain_adresse_localite=PEYPIN
    ...  terrain_superficie=250

    &{args_donnees_techniques} =  Create Dictionary
    ...  dia_imm_bati_terr_propr=t
    ...  dia_su_co_sol_num=250
    ...  dia_su_util_hab_num=200
    ...  dia_nb_niv=2
    ...  dia_nb_appart=1
    ...  dia_nb_autre_loc=3
    ...  dia_vente_lot_volume=t
    ...  dia_vente_lot_volume_txt=3 lots
    ...  dia_bat_copro=t
    ...  dia_bat_copro_desc=Local à poubelle
    ...  dia_lot_quote_part=3
    ...  dia_acquereur_nom_prenom=Jean Philippe Smet
    ...  dia_acquereur_adr_num_voie=89
    ...  dia_acquereur_adr_type_voie=Rue
    ...  dia_acquereur_adr_nom_voie=Captain Desmond
    ...  dia_acquereur_adr_cp=13007
    ...  dia_acquereur_adr_localite=MARSEILLE
    ...  dia_indivi_quote_part=parts égales
    ...  dia_mod_cess_prix_vente_num=45000
    ...  dia_us_hab=t
    ...  dia_us_agr=t

    ${di_peypin_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Saisir les données techniques du DI  ${di_peypin_2}  ${args_donnees_techniques}
    Ajouter une instruction au DI et la finaliser  ${di_peypin_2}  accepter un dossier sans réserve  false  ${date_jour_add_form}

    Depuis le menu des statistiques à la demande
    Click On Link  dossier_dia
    # On vérifie la présence de la chexkcbox collectivite
    Page Should Contain Checkbox  om_collectivite
    # Selection dans le champs du format "Tableau-Affichage à l'écran"
    Select From List By Label  sortie  Tableau - Affichage à l'écran
    Sleep  2
    Exécuter la reqmo

    # On vérifie la présence des trois DI dans le tableau affiché
    Element Should Not Contain  css=.tab-tab  ${di_peypin_1}
    Element Should Contain  css=.tab-tab  ${di_roquevaire}
    # on vérifié entierement l'enregistrement pour "Raph Rouge"
    Element Should Contain  css=.tab-tab  ${di_peypin_2}
    Element Should Contain  css=.tab-tab  ${DATE_DDMMYYYY}
    Element Should Contain  css=.tab-tab  Raph Rouge
    Element Should Contain  css=.tab-tab  Bâti sur terrain propre
    Element Should Contain  css=.tab-tab  250
    Element Should Contain  css=.tab-tab  200
    Element Should Contain  css=.tab-tab  habitation / agricole
    Element Should Contain  css=.tab-tab  1
    Element Should Contain  css=.tab-tab  2
    Element Should Contain  css=.tab-tab  3
    Element Should Contain  css=.tab-tab  Oui
    Element Should Contain  css=.tab-tab  3 lots
    Element Should Contain  css=.tab-tab  Local à poubelle
    Element Should Contain  css=.tab-tab  parts égales
    Element Should Contain  css=.tab-tab  012AA0012;
    Element Should Contain  css=.tab-tab  900
    Element Should Contain  css=.tab-tab  A1
    Element Should Contain  css=.tab-tab  PEYPIN
    Element Should Contain  css=.tab-tab  13124
    Element Should Contain  css=.tab-tab  CEDEX PEYPIN
    Element Should Contain  css=.tab-tab  45000
    Element Should Contain  css=.tab-tab  Jean Philippe Smet
    Element Should Contain  css=.tab-tab  MARSEILLE
    Element Should Contain  css=.tab-tab  accepter

    # On vérifie la présence de la colonne collectivite
    Element Should Contain  css=.tab-tab  Collectivité

    # On modifie les filtres de date de début et de fin de décision à la date du
    # jour
    Click On Back Button
    Input Text  css=input[name='date_decision_debut']  ${DATE_DDMMYYYY}
    Input Text  css=input[name='date_decision_fin']  ${DATE_DDMMYYYY}
    Exécuter la reqmo
    # On vérifie la présence du seul DI clôturé à cette date
    Element Should Contain  css=.tab-tab  ${di_roquevaire}
    Element Should Not Contain  css=.tab-tab  ${di_peypin_2}
    Element Should Not Contain  css=.tab-tab  ${di_peypin_1}

    # On modifie les filtres de date de début et de fin de décision à la date
    # dans le futur
    Click On Back Button
    Input Text  css=input[name='date_decision_debut']  ${date_jour_add_form}
    Input Text  css=input[name='date_decision_fin']  ${date_jour_add_form}
    Exécuter la reqmo
    # On vérifie la présence du seul DI clôturé à cette date
    Element Should Not Contain  css=.tab-tab  ${di_roquevaire}
    Element Should Contain  css=.tab-tab  ${di_peypin_2}
    Element Should Not Contain  css=.tab-tab  ${di_peypin_1}

    # On vérifie que l'export csv fonctionne
    Click On Back Button
    Choix du format de sortie CSV
    Exécuter la reqmo
    ${link} =  Lien téléchargement CSV
    ${content_file} =  Contenu CSV  ${link}
    # On vérifie dans le fichier que l'enregistrement est présent
    Should Contain  ${content_file}  ${di_peypin_2}

    # On vérifie que le caractère optionnel d'une colonne (ex: prix de vente)
    Click On Back Button
    # Selection dans le champs du format "Tableau-Affichage à l'écran"
    Select From List By Label  sortie  Tableau - Affichage à l'écran
    Unselect Checkbox  dia_mod_cess_prix_vente_num
    Exécuter la reqmo
    Element Should Not Contain  css=.tab-tab  45000

    #
    # Pour le cas d'un utilisateur de collectivité de niveau 1
    #

    Depuis la page d'accueil  guichetroq   guichetroq
    Depuis le menu des statistiques à la demande
    Click On Link  dossier_dia
    # On vérifie la non présence de la chexkcbox collectivite
    Page Should Not Contain Checkbox  om_collectivite
    Select From List By Label  sortie  Tableau - Affichage à l'écran
    Exécuter la reqmo
    # On vérifie la présence du seul DI de cette collectivité
    Element Should Contain  css=.tab-tab  ${di_roquevaire}
    Element Should Not Contain  css=.tab-tab  ${di_peypin_2}
    Element Should Not Contain  css=.tab-tab  ${di_peypin_1}
    # On vérifie la non présence de la colonne collectivite
    Element Should Not Contain  css=.tab-tab  Collectivité

    # On modifie les filtres de date de début et de fin de décision à la date du
    # jour
    Click On Back Button
    Input Text  css=input[name='date_decision_debut']  ${DATE_DDMMYYYY}
    Input Text  css=input[name='date_decision_fin']  ${DATE_DDMMYYYY}
    Exécuter la reqmo
    # On vérifie la présence du seul DI de cette collectivité clôturé à cette
    # date
    Element Should Contain  css=.tab-tab  ${di_roquevaire}
    Element Should Not Contain  css=.tab-tab  ${di_peypin_2}
    Element Should Not Contain  css=.tab-tab  ${di_peypin_1}

    # On modifie les filtres de date de début et de fin de décision à la date
    # dans le futur
    Click On Back Button
    Input Text  css=input[name='date_decision_debut']  ${date_jour_add_form}
    Input Text  css=input[name='date_decision_fin']  ${date_jour_add_form}
    Exécuter la reqmo
    # On vérifie qu'aucun DI ne soient présents dans le tableau
    Element Should Not Contain  css=.tab-tab  ${di_roquevaire}
    Element Should Not Contain  css=.tab-tab  ${di_peypin_2}
    Element Should Not Contain  css=.tab-tab  ${di_peypin_1}

    Depuis la page d'accueil  admin  admin
    &{param_values_1} =  Create Dictionary
    ...  libelle=id_datd_filtre_reqmo_dossier_dia
    ...  valeur=-1
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values_1}

Vérification des permission d'accès aux exports CSV
    [Documentation]  On vérifie que les profils "GUICHET" et "GUICHET et SUIVI" ont accès
    ...  au menu des statistiques à la demande, ainsi qu'au bouton CSV sur les listings
    ...  des dossiers d'instructions

    Depuis la page d'accueil  guichet  guichet
    Depuis le menu des statistiques à la demande
    # On affiche le listing des dossiers d'instruction
    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    Page Should Contain Element  css=.csv-25

    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    Depuis le menu des statistiques à la demande
    # On affiche le listing des dossiers d'instruction
    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    Page Should Contain Element  css=.csv-25

TNR de l'affichage du numéro d'ordre d'envoi de l'export SITADEL
    [Documentation]  On vérifie que le numéro d'envoi est bien affiché dans
    ...  la première ligne de l'export SITADEL


    # Récupération de la date au format yymmdd pour composer la première ligne
    # du fichier jusqu'au numéroi d'ordre
    ${DATE_FORMAT_YYYY-MM-DD} =  Date du jour EN
    ${DATE_FORMAT_YYMMDD} =  Replace String  ${DATE_FORMAT_YYYY-MM-DD}  -  ${EMPTY}
    ${DATE_FORMAT_YYMMDD} =  Get Substring  ${DATE_FORMAT_YYMMDD}  2
    ${expected_content_file} =  Set Variable  SITADEL|013|055|93|${DATE_FORMAT_YYMMDD}013055|3

    # Export SITADEL
    Depuis la page d'accueil  guichetsuivi   guichetsuivi
    ${content_file} =  Récupérer l'export SITADEL à la date souhaitée  ${DATE_FORMAT_DD/MM/YYYY}  ${DATE_FORMAT_DD/MM/YYYY}  3
    # On vérifie que les valeurs voulues existent dans le fichier
    Should Contain  ${content_file}  ${expected_content_file}


Test des imports relatifs au tiers consulté
    [Documentation]  Test les imports des :
    ...  - tiers consulté
    ...  - habilitation de tiers consulté
    ...  - lien entre les spécialité de tiers consulté et les habilitations de tiers consulté
    ...  - lien entre les communes et les habilitations de tiers consulté
    ...  - lien entre les départements et les habilitations de tiers consulté
    ...  Pour chaque import le test consiste à accéder à l'import. Remplir le formulaire avec
    ...  le fichier csv correspondant. Vérifier le message de validation de l'import et vérifier
    ...  que les données ont été correctement enregistrées.

    Depuis la page d'accueil  admin  admin

    ## Mise en place de la configuration nécessaire pour le bon fonctionnement des imports
    # Ajout d'une COMMUNE
    &{070Com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=53053
    ...  reg=53
    ...  dep=53
    ...  arr=053
    ...  tncc=0
    ...  ncc=070Com
    ...  nccenr=070Com
    ...  libelle=Commune test 070
    ...  can=53
    ...  comparent=
    ...  om_validite_debut=01/01/2020
    ${id_commune} =  Ajouter commune avec dates validité  ${070Com_values}

    # Ajout d'un DÉPARTEMENT
    &{070Dep_values} =  Create Dictionary
    ...  dep=36
    ...  reg=36
    ...  cheflieu=36036
    ...  tncc=0
    ...  ncc=070Dep
    ...  nccenr=070Dep
    ...  libelle=Département test 070
    ...  om_validite_debut=${date_ddmmyyyy}
    ${id_departement} =  Ajouter département  ${070Dep_values}

    # Ajout d'un TYPE D'HABILITATION TIERS CONSULTÉ
    &{type_hab_tc} =  Create Dictionary
    ...  code=53
    ...  libelle=Type habilitation tc test 070
    ...  om_validite_debut=01/01/2022
    ${id_type_hab_tc} =  Ajouter un type d'habilitation de tiers consulté  ${type_hab_tc}

    # Ajout d'une CATÉGORIE TIERS CONSULTÉ
    &{cat_tc} =  Create Dictionary
    ...  categorie_tiers_consulte=2
    ...  code=Cat_test_070
    ...  description=Catégorie de tiers consulté test 070
    ...  libelle=Catégorie TC test 070
    ${id_cat_tc} =  Ajouter la categorie de tiers consulte  ${cat_tc}

    # Ajout d'une SPÉCIALITÉ TIERS CONSULTÉ
    &{spe_tc} =  Create Dictionary
    ...  code=1
    ...  description=test spe tiers consulté
    ...  libelle=Spécialité TC test 070
    ...  om_validite_debut=${date_ddmmyyyy}
    ${id_spe_tc} =  Ajouter la spécialité de tiers consulté  ${spe_tc}

    # 1 - import d'un tiers consulté
    # tiers consulte (abrege n'est pas présent dans le fichier CSV)
    &{import_tc_values} =  Create Dictionary
    ...  categorie_tiers_consulte=${cat_tc.libelle}
    ...  abrege=TNR_070_tc
    ...  libelle=import_tc
    ...  adresse=10 rue des tests d'import de tiers
    ...  complement=cplmt_tc
    ...  cp=cp_tc
    ...  ville=ville_tc
    ...  liste_diffusion=test@070.export\ntest2@070.export
    ...  accepte_notification_email=Oui
    ...  uid_platau_acteur=TST_UID_PLA
    # Modification du fichier d'import pour attribuer les identifiants voulus
    ${import_file_name} =  Set Variable  import_tc
    ${content_csv} =  Get File  binary_files/${import_file_name}.csv.tpl
    ${content_csv} =  Replace String  ${content_csv}  id_cat_tc  ${id_cat_tc}
    ${import_file} =  Set Variable  ${import_file_name}.csv
    Create File  binary_files/${import_file}  ${content_csv}
    # import des données
    &{import_values} =  Create Dictionary
    ...  fic1=${import_file_name}.csv
    @{results} =  Create List
    ...  2 ligne(s) dans le fichier dont :
    ...  - 1 ligne(s) d'entête
    ...  - 1 ligne(s) importée(s)
    ...  - 0 ligne(s) rejetée(s)
    ...  - 0 ligne(s) vide(s)
    Importer des données  tiers_consulte  ${import_values}  ${results}

    # Vérification des données enregistrées. Tous les champs de l'import
    # sont accessibles dans la recherche avancée. Si la recherche avancée
    # renvoie qqch c'est que l'import à bien été réalisé.
    Rechercher des tiers consultes  ${import_tc_values}
    Page Should Not Contain  Aucun enregistrement.
    Click Link  ${import_tc_values.libelle}
    # Récupération de l'identifiant du tiers consulté
    Wait Until Page Contains Element  css=#tiers_consulte
    ${id_tc} =  Get Text  css=#tiers_consulte

    # 2 - import d'une habilitation de tiers consulte
    # Modification du fichier d'import pour attribuer les identifiants voulus
    ${import_file_name} =  Set Variable  import_hab_tc
    ${content_csv} =  Get File  binary_files/${import_file_name}.csv.tpl
    ${content_csv} =  Replace String  ${content_csv}  id_type_hab_tc  ${id_type_hab_tc}
    ${content_csv} =  Replace String  ${content_csv}  id_tc  ${id_tc}
    ${import_file} =  Set Variable  ${import_file_name}.csv
    Create File  binary_files/${import_file}  ${content_csv}
    # import des données
    &{import_values} =  Create Dictionary
    ...  fic1=${import_file_name}.csv
    Importer des données  habilitation_tiers_consulte  ${import_values}  ${results}

    # Vérification des données enregistrées
    &{import_hab_tc_values} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_hab_tc.libelle}
    ...  division_territoriales=div terr
    ...  om_validite_debut_min=01/01/2022
    ...  om_validite_debut_max=01/01/2022
    ...  om_validite_fin_min=01/01/2099
    ...  om_validite_fin_max=01/01/2099
    Rechercher des habilitations de tiers consultes  ${import_hab_tc_values}
    Page Should Not Contain  Aucun enregistrement.
    Click Link  ${import_hab_tc_values.type_habilitation_tiers_consulte}
    # Récupération de l'identifiant du tiers consulté
    Wait Until Page Contains Element  css=#tiers_consulte
    ${id_hab_tc} =  Get Text  css=#habilitation_tiers_consulte

    # 3 - import d'un lien habilitation tiers - commune
    # Modification du fichier d'import pour attribuer les identifiants voulus
    ${import_file_name} =  Set Variable  import_lien_hab_tc_commune
    ${content_csv} =  Get File  binary_files/${import_file_name}.csv.tpl
    ${content_csv} =  Replace String  ${content_csv}  id_hab_tc  ${id_hab_tc}
    ${content_csv} =  Replace String  ${content_csv}  id_commune  ${id_commune}
    ${import_file} =  Set Variable  ${import_file_name}.csv
    Create File  binary_files/${import_file}  ${content_csv}
    # import des données
    &{import_values} =  Create Dictionary
    ...  fic1=${import_file_name}.csv
    Importer des données  lien_habilitation_tiers_consulte_commune  ${import_values}  ${results}

    # 4 - import d'un lien habilitation tiers - departement
    # Modification du fichier d'import pour attribuer les identifiants voulus
    ${import_file_name} =  Set Variable  import_lien_hab_tc_departement
    ${content_csv} =  Get File  binary_files/${import_file_name}.csv.tpl
    ${content_csv} =  Replace String  ${content_csv}  id_hab_tc  ${id_hab_tc}
    ${content_csv} =  Replace String  ${content_csv}  id_departement  ${id_departement}
    ${import_file} =  Set Variable  ${import_file_name}.csv
    Create File  binary_files/${import_file}  ${content_csv}
    # import des données
    &{import_values} =  Create Dictionary
    ...  fic1=${import_file_name}.csv
    Importer des données  lien_habilitation_tiers_consulte_departement  ${import_values}  ${results}

    # 5 - import d'un lien habilitation tiers - specialite tiers
    # Modification du fichier d'import pour attribuer les identifiants voulus
    ${import_file_name} =  Set Variable  import_lien_hab_tc_specialite_tc
    ${content_csv} =  Get File  binary_files/${import_file_name}.csv.tpl
    ${content_csv} =  Replace String  ${content_csv}  id_hab_tc  ${id_hab_tc}
    ${content_csv} =  Replace String  ${content_csv}  id_spe_tc  ${id_spe_tc}
    ${import_file} =  Set Variable  ${import_file_name}.csv
    Create File  binary_files/${import_file}  ${content_csv}
    # import des données
    &{import_values} =  Create Dictionary
    ...  fic1=${import_file_name}.csv
    Importer des données  lien_habilitation_tiers_consulte_specialite_tiers_consulte  ${import_values}  ${results}

    # Vérification des données enregistrées
    Depuis le contexte de l'habilitation de tiers consulté  ${id_hab_tc}
    &{values_to_test} =  Create Dictionary
    ...  type_habilitation_tiers_consulte=${type_hab_tc.libelle}
    ...  texte_agrement=texte agrement_hab_tc_csv
    ...  division_territoriales=div terr
    ...  om_validite_debut=01/01/2022
    ...  om_validite_fin=01/01/2099
    ...  tiers_consulte=${import_tc_values.libelle}
    ${values}=  Get Dictionary Items  ${values_to_test}
    :FOR  ${key}  ${value}  IN  @{values}
    \  Element Should Contain  css=#${key}  ${value}
    # Les champs liés à des select multiple n'étant pas géré comme les autres (pas d'id sur le champs)
    # on les vérifie à part
    @{select_mult_to_test} =  Create List
    ...  ${070Com_values.com} - ${070Com_values.libelle}
    ...  ${070Dep_values.dep} - ${070Dep_values.libelle}
    ...  ${spe_tc.code} - ${spe_tc.libelle}
    :FOR  ${value}  IN  @{select_mult_to_test}
    \  Page Should Contain  ${value}
    
    # Suppression du tiers consulté pour ne pas impacter le test 080
    Supprimer une habilitation de tiers consulté  ${id_hab_tc}
    Supprimer le tiers consulte  ${id_tc}
