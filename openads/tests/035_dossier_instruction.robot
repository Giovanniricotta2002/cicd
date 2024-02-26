*** Settings ***
Documentation  Test sur les dossiers d'instruction.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Test Cases ***

Suppression d'un dossier d'instruction
    [Documentation]  Ce test case permet de verifier la suppression d'un dossier
    ...  d'instruction non instruit pour les profils ayant la permission.
    ...  La vérification de l'action avec l'option de saisie de la numérotation
    ...  est réalisée dans le Test Case "Saisie du numéro de dossier sur le
    ...  formulaire d'ajout d'une nouvelle demande" dans le Test Suite
    ...  "030_demande.robot" afin d'utiliser l'isolation de contexte déjà
    ...  existante.

    # On désactive l'option de suppression des dossiers d'instruction
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # On ajoute les permissions de supression des dossiers d'instruction du
    # contentieux au profil 'JURISTE'
    Ajouter le droit depuis le menu  dossier_contentieux_mes_recours_supprimer  JURISTE
    Ajouter le droit depuis le menu  dossier_contentieux_tous_recours_supprimer  JURISTE
    Ajouter le droit depuis le menu  dossier_contentieux_mes_infractions_supprimer  JURISTE
    Ajouter le droit depuis le menu  dossier_contentieux_toutes_infractions_supprimer  JURISTE

    # On ajoute les permissions de supression des dossiers d'instruction ADS au
    # profil 'INSTRUCTEUR'
    Ajouter le droit depuis le menu  dossier_instruction_supprimer  INSTRUCTEUR
    Ajouter le droit depuis le menu  dossier_instruction_mes_encours_supprimer  INSTRUCTEUR
    Ajouter le droit depuis le menu  dossier_instruction_tous_encours_supprimer  INSTRUCTEUR
    Ajouter le droit depuis le menu  dossier_instruction_mes_clotures_supprimer  INSTRUCTEUR
    Ajouter le droit depuis le menu  dossier_instruction_tous_clotures_supprimer  INSTRUCTEUR

    # On ajoute la permission de supression des dossiers d'instruction au profil
    # 'GUICHET UNIQUE'
    Ajouter le droit depuis le menu  dossier_instruction_supprimer  GUICHET UNIQUE

    # On vérifie que l'option désactivée ne permet pas la suppression d'un
    # dossier d'instruction
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM01
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM01
    ...  om_collectivite=MARSEILLE
    ${di1} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di1}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer

    # On active l'option de suppression des dossiers d'instruction
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # On vérifie que l'option activée permet la suppression d'un dossier
    # d'instruction
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di1}
    Portlet Action Should Be In Form  dossier_instruction  supprimer

    # On vérifie qu'un instructeur d'une autre division ne puisse pas supprimer
    # le dossier d'instruction
    Depuis la page d'accueil  instr2  instr
    Depuis le contexte du dossier d'instruction  ${di1}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer

    # On supprime le dossier d'instruction
    Depuis la page d'accueil  instr  instr
    Supprimer le dossier d'instruction  ${di1}
    Valid Message Should Be  La suppression a été correctement effectuée.

    # On vérifie que le dossier d'instruction suivant récupère bien la
    # numérotation du dossier supprimé
    &{args_petitionnaire2} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM02
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM02
    ...  om_collectivite=MARSEILLE
    ${di2} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire2}
    Should Be Equal  ${di1}  ${di2}
    Supprimer le dossier d'instruction  ${di2}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On vérifie que l'option activée ne permet pas la suppression d'un dossier
    # d'instruction venant de portal
    &{args_dossier} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_localite=TestNotifAdresseLocalite
    ...  depot_electronique=true
    ...  source_depot=portal
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TestNotifDepotDematNom
    ...  particulier_prenom=TestNotifDepotDematPrenom
    ...  localite=TestNotifLocalite
    ...  om_collectivite=MARSEILLE
    ${di_portal} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire}
    Depuis le contexte du dossier d'instruction  ${di_portal}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer

    # On vérifie que l'option activée ne permet pas la suppression d'un dossier
    # d'instruction venant de plat'au
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
    Depuis le contexte du dossier d'instruction  ${di_platau}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer

    # On vérifie que la suppression d'un dossier d'instruction ADS n'est pas
    # possible si celui-ci est l'autorisation contestée d'un recours
    &{args_dossier} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_localite=TestNotifAdresseLocalite
    ...  depot_electronique=true
    &{args_petitionnaire3} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM03
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM03
    ...  om_collectivite=MARSEILLE
    ${di3} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire3}
    &{args_dossier_contentieux} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  demande_type=Dépôt Initial REC
    ...  autorisation_contestee=${di3}
    ...  om_collectivite=MARSEILLE
    ${di4} =  Ajouter la demande par WS  ${args_dossier_contentieux}

    Depuis le contexte du dossier d'instruction  ${di3}
    Run Keyword And Expect Error  Le clic sur 'css=#formulaire div.formControls input[type="submit"]' a échoué  Supprimer le dossier d'instruction  ${di3}
    Error Message Should Contain  Le dossier d'instruction ne peut pas être supprimé car celui-ci est lié à un contentieux.

    # On supprime le recours
    Depuis la page d'accueil  juriste  juriste
    Supprimer le dossier d'instruction  ${di4}  recours
    Valid Message Should Contain  La suppression a été correctement effectuée.
    # On vérifie que l'autorisation constestée peut être désormais supprimée
    Depuis la page d'accueil  instr  instr
    Supprimer le dossier d'instruction  ${di3}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On vérifie qu'un profil "guichet" peut supprimer un dossier d'instruction
    # non instruit
    &{args_petitionnaire4} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM04
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM04
    ...  om_collectivite=MARSEILLE
    ${di5} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire4}
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte du dossier d'instruction  ${di5}
    Supprimer le dossier d'instruction  ${di5}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On vérifie qu'un profil "guichet" ne peut pas supprimer un dossier
    # d'instruction déjà instruit
    # On vérifie également l'affichage du dossier d'autorisation à chaque étape
    &{args_petitionnaire5} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM05
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM05
    ...  om_collectivite=MARSEILLE
    ${di6} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire5}
    Depuis la page d'accueil  instr  instr

    ${da} =  Get Substring  ${di6}  0  -2
    Depuis le contexte du dossier d'autorisation  ${da}
    Form Static Value Should Be  id=dit_libelle_0  Initial

    Ajouter une instruction au DI  ${di6}  accepter un dossier sans réserve

    Depuis le contexte du dossier d'autorisation  ${da}
    Element Should Not Be Visible  id=dit_libelle_0

    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte du dossier d'instruction  ${di6}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer

    # On vérifie la suppression d'un dossier d'instruction sur existant
    # On vérifie également l'affichage du dossier d'autorisation à chaque étape
    &{args_dossier_existant} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di6}
    ${di_m1} =  Ajouter la demande par WS  ${args_dossier_existant}

    Depuis le contexte du dossier d'autorisation  ${da}
    Form Static Value Should Be  id=dit_libelle_0  Modificatif

    Supprimer le dossier d'instruction  ${di_m1}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On vérifie la numérotation du prochain dossier d'instruction sur existant
    &{args_dossier_existant} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di6}
    ${di_m2} =  Ajouter la demande par WS  ${args_dossier_existant}
    Should Be Equal  ${di_m1}  ${di_m2}
    Supprimer le dossier d'instruction  ${di_m2}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On vérifie que le super administrateur peut supprimer un dossier
    # d'instruction non instruit
    # On vérifie également l'affichage du dossier d'autorisation à chaque étape
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di6}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer
    Supprimer l'instruction  ${di6}  accepter un dossier sans réserve
    Depuis le contexte du dossier d'autorisation  ${da}
    Form Static Value Should Be  id=dit_libelle_0  Initial
    Supprimer le dossier d'instruction  ${di6}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On vérifie la suppression de plusieurs dossier d'instruction en cascade
    # ainsi que la condition d'affichage de l'action de suppression précisant
    # qu'il s'agit du dernier dossier de sa numérotation
    &{args_petitionnaire6} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM06
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM06
    ...  om_collectivite=MARSEILLE
    ${di7} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire6}
    &{args_petitionnaire7} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM07
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM07
    ...  om_collectivite=MARSEILLE
    ${di8} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire7}
    &{args_petitionnaire8} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM08
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM08
    ...  om_collectivite=MARSEILLE
    ${di9} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire8}
    &{args_petitionnaire9} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM09
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM09
    ...  om_collectivite=MARSEILLE
    ${di10} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire9}
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di7}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer
    Depuis le contexte du dossier d'instruction  ${di8}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer
    Depuis le contexte du dossier d'instruction  ${di9}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer
    Depuis le contexte du dossier d'instruction  ${di10}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Supprimer le dossier d'instruction  ${di10}
    Valid Message Should Contain  La suppression a été correctement effectuée.
    Depuis le contexte du dossier d'instruction  ${di7}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer
    Depuis le contexte du dossier d'instruction  ${di8}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer
    Depuis le contexte du dossier d'instruction  ${di9}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Supprimer le dossier d'instruction  ${di9}
    Valid Message Should Contain  La suppression a été correctement effectuée.
    Depuis le contexte du dossier d'instruction  ${di7}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer
    Depuis le contexte du dossier d'instruction  ${di8}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Supprimer le dossier d'instruction  ${di8}
    Valid Message Should Contain  La suppression a été correctement effectuée.
    Depuis le contexte du dossier d'instruction  ${di7}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    # On ajoute à nouveau un dossier d'instruction et on vérifie sa numérotation
    &{args_petitionnaire10} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM10
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM10
    ...  om_collectivite=MARSEILLE
    ${di11} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire10}
    Should Be Equal  ${di8}  ${di11}

    # TNR : la suppression d'un dossier d'instruction sans suffixe ne déclenchait
    #       plus la mise à jour du numéro de DI.
    # Ce test consiste à désactiver le suffixe pour les PCMI, créer un dossier puis
    # le supprimer et en créer un nouveau pour vérifier que le numéros de dossier
    # est bien mis à jour.
    @{admin} =  Create List  admin  admin
    Depuis la page d'accueil  @{admin}
    &{val_PCI} =  Create Dictionary
    ...  suffixe=false
    Modifier type de dossier d'instruction  PCI  P  ${val_PCI}

    &{args_di_ss_suffixe} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=SuppressionDossierSansSufixeNOM
    ...  particulier_prenom=SuppressionDossierSansSufixePRENOM
    ...  om_collectivite=MARSEILLE
    ${di_ss_suffixe1} =  Ajouter la demande par WS  ${args_dossier}  ${args_di_ss_suffixe}
    @{instr} =  Create List  instr  instr
    # Vérifie que la suppression est possible
    Depuis la page d'accueil  @{instr}
    Depuis le contexte du dossier d'instruction  ${di_ss_suffixe1}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    # Supprimer le dossier et en recréer un pour vérifier que le numéro n'a pas été sauté
    Supprimer le dossier d'instruction  ${di_ss_suffixe1}
    &{args_di_ss_suffixe} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=SuppressionDossierSansSufixeNOM2
    ...  particulier_prenom=SuppressionDossierSansSufixePRENOM2
    ...  om_collectivite=MARSEILLE
    ${di_ss_suffixe2} =  Ajouter la demande par WS  ${args_dossier}  ${args_di_ss_suffixe}
    Should Be Equal  ${di_ss_suffixe1}  ${di_ss_suffixe2}

    # Remet le suffixe
    Depuis la page d'accueil  @{admin}
    &{val_PCI} =  Create Dictionary
    ...  suffixe=true
    Modifier type de dossier d'instruction  PCI  P  ${val_PCI}


    # Isolation de contexte pour vérifier la suppression d'un dossier
    # d'instruction premier de sa numérotation
    Ajouter la collectivité depuis le menu  FREECITY050  mono
    Ajouter le paramètre depuis le menu  departement  032  FREECITY050
    Ajouter le paramètre depuis le menu  commune  098  FREECITY050
    Ajouter le paramètre depuis le menu  insee  32098  FREECITY050
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=FREECITY050
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire11} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM11
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM11
    ...  om_collectivite=FREECITY050
    ${di12} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire11}
    Supprimer le dossier d'instruction  ${di12}
    Valid Message Should Contain  La suppression a été correctement effectuée.
    &{args_petitionnaire12} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM12
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM12
    ...  om_collectivite=FREECITY050
    ${di13} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire12}
    Should Be Equal  ${di12}  ${di13}
    &{args_petitionnaire13} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM13
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM13
    ...  om_collectivite=FREECITY050
    ${di14} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire13}
    Supprimer le dossier d'instruction  ${di14}
    Valid Message Should Contain  La suppression a été correctement effectuée.
    Supprimer le dossier d'instruction  ${di13}
    Valid Message Should Contain  La suppression a été correctement effectuée.
    &{args_petitionnaire14} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM14
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM14
    ...  om_collectivite=FREECITY050
    ${di15} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire14}
    Should Be Equal  ${di13}  ${di15}

    # On complète l'isolation de contexte pour les prochains cas à vérifier
    ${id_contrainte_1} =  Ajouter la contrainte depuis le menu  TEST035SUPPRDICONTRLIB01  PLU  FREECITY050  TEST035SUPPRDICONTRGROUPE  TEST035SUPPRDICONTRSSGROUPE  TEST035SUPPRDICONTRTEXT01
    ${id_contrainte_2} =  Ajouter la contrainte depuis le menu  TEST035SUPPRDICONTRLIB02  PLU  FREECITY050  TEST035SUPPRDICONTRGROUPE  TEST035SUPPRDICONTRSSGROUPE  TEST035SUPPRDICONTRTEXT02
    ${code_service1} =  Set Variable  77
    ${libelle_service1} =  Set Variable  TEST035SERVIC01
    &{args_service} =  Create Dictionary
    ...  abrege=${code_service1}
    ...  libelle=${libelle_service1}
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=FREECITY050
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${args_service}
    ${code_service2} =  Set Variable  77
    ${libelle_service2} =  Set Variable  TEST035SERVIC02
    &{args_service} =  Create Dictionary
    ...  abrege=${code_service2}
    ...  libelle=${libelle_service2}
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=FREECITY050
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${args_service}
    ${libelle_type_commission} =  Set Variable  TEST035TCOMM01
    &{args_type_commission} =  Create Dictionary
    ...  code=TC
    ...  libelle=${libelle_type_commission}
    ...  om_collectivite=FREECITY050
    Ajouter type de commission  ${args_type_commission}
    &{args_dossier_cu} =  Create Dictionary
    ...  om_collectivite=FREECITY050
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire16} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM16
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM16
    ...  om_collectivite=FREECITY050
    ${di16} =  Ajouter la demande par WS  ${args_dossier_cu}  ${args_petitionnaire16}
    &{args_petitionnaire17} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM17
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM17
    ...  om_collectivite=FREECITY050
    ${di17} =  Ajouter la demande par WS  ${args_dossier_cu}  ${args_petitionnaire17}

    # On vérifie la suppression d'un DI initial qui n'est pas le premier de sa
    # numérotation dont chaque table liée à au moins deux enregistrements
    &{args_petitionnaire18} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM18
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM18
    ...  om_collectivite=FREECITY050
    ${di18} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire18}
    Should Be Equal  ${di14}  ${di18}
    # On ajoute le rapport d'instruction
    Depuis le contexte du rapport d'instruction  ${di18}
    Click On Submit Button In Subform
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Depuis le contexte du rapport d'instruction  ${di18}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Click On Back Button In Subform
    # On ajoute deux contraintes
    @{contraintes_a_selectionner} =  Create List  ${id_contrainte_1}  ${id_contrainte_2}
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${di18}  ${contraintes_a_selectionner}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST035SUPPRDICONTRLIB01
    Page Should Contain  TEST035SUPPRDICONTRLIB02
    # On ajoute deux consultations
    Ajouter une consultation depuis un dossier  ${di18}  ${code_service1} - ${libelle_service1}
    Ajouter une consultation depuis un dossier  ${di18}  ${code_service2} - ${libelle_service2}
    # On ajoute deux demandes de commission
    Ajouter la commission depuis le contexte du dossier d'instruction  ${di18}  ${libelle_type_commission}  ${date_ddmmyyyy}
    Ajouter la commission depuis le contexte du dossier d'instruction  ${di18}  ${libelle_type_commission}  ${date_ddmmyyyy}
    # On ajoute deux lots
    ${libelle_lot1} =  Set Variable  TEST035LOT01
    &{args_lot} =  Create Dictionary
    ...  libelle=${libelle_lot1}
    Ajouter le lot  ${di18}  ${args_lot}
    ${libelle_lot2} =  Set Variable  TEST035LOT02
    &{args_lot} =  Create Dictionary
    ...  libelle=${libelle_lot2}
    Ajouter le lot  ${di18}  ${args_lot}
    # On ajoute deux pièces + automatiquement un message
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté retour préfecture
    ${dossier_message1} =  Ajouter une pièce depuis le dossier d'instruction  ${di18}  ${document_numerise_values}
    Ajouter une pièce depuis le dossier d'instruction  ${di18}  ${document_numerise_values}
    Depuis le contexte du message dans le dossier d'instruction  ${di18}  ${dossier_message1}
    # On ajoute un message manuellement
    ${message} =  Set Variable  MESSAGETEST035SUPPRDI01
    ${dossier_message2} =  Ajouter un message dans le dossier d'instruction  ${di18}  ${message}
    Depuis le contexte du message dans le dossier d'instruction  ${di18}  ${dossier_message2}
    # On ajoute deux blocnotes
    &{args_blocnote} =  Create Dictionary
    ...  note=TEST035BLOCNOTE01
    Ajouter le bloc-note depuis le contexte du dossier d'instruction  ${di18}  ${args_blocnote}
    &{args_blocnote} =  Create Dictionary
    ...  note=TEST035BLOCNOTE02
    Ajouter le bloc-note depuis le contexte du dossier d'instruction  ${di18}  ${args_blocnote}
    # On ajoute deux liaisons
    Ajouter la liaison entre le dossier d'instruction source et le dossier d'instruction cible  ${di18}  ${di16}
    Ajouter la liaison entre le dossier d'instruction source et le dossier d'instruction cible  ${di18}  ${di17}
    Supprimer le dossier d'instruction  ${di18}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On vérifie la suppression d'un DI sur existant dont chaque table liée à au
    # moins deux enregistrements
    Ajouter une instruction au DI  ${di15}  accepter un dossier sans réserve
    &{args_dossier_existant} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di15}
    ${di_m3} =  Ajouter la demande par WS  ${args_dossier_existant}
    # On ajoute le rapport d'instruction
    Depuis le contexte du rapport d'instruction  ${di_m3}
    Click On Submit Button In Subform
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Depuis le contexte du rapport d'instruction  ${di_m3}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Click On Back Button In Subform
    # On ajoute deux contraintes
    @{contraintes_a_selectionner} =  Create List  ${id_contrainte_1}  ${id_contrainte_2}
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${di_m3}  ${contraintes_a_selectionner}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST035SUPPRDICONTRLIB01
    Page Should Contain  TEST035SUPPRDICONTRLIB02
    # On ajoute deux consultations
    Ajouter une consultation depuis un dossier  ${di_m3}  ${code_service1} - ${libelle_service1}
    Ajouter une consultation depuis un dossier  ${di_m3}  ${code_service2} - ${libelle_service2}
    # On ajoute deux demandes de commission
    Ajouter la commission depuis le contexte du dossier d'instruction  ${di_m3}  ${libelle_type_commission}  ${date_ddmmyyyy}
    Ajouter la commission depuis le contexte du dossier d'instruction  ${di_m3}  ${libelle_type_commission}  ${date_ddmmyyyy}
    # On ajoute deux lots
    ${libelle_lot1} =  Set Variable  TEST035LOT01
    &{args_lot} =  Create Dictionary
    ...  libelle=${libelle_lot1}
    Ajouter le lot  ${di_m3}  ${args_lot}
    ${libelle_lot2} =  Set Variable  TEST035LOT02
    &{args_lot} =  Create Dictionary
    ...  libelle=${libelle_lot2}
    Ajouter le lot  ${di_m3}  ${args_lot}
    # On ajoute deux pièces + automatiquement un message
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté retour préfecture
    ${dossier_message1} =  Ajouter une pièce depuis le dossier d'instruction  ${di_m3}  ${document_numerise_values}
    Ajouter une pièce depuis le dossier d'instruction  ${di_m3}  ${document_numerise_values}
    Depuis le contexte du message dans le dossier d'instruction  ${di_m3}  ${dossier_message1}
    # On ajoute un message manuellement
    ${message} =  Set Variable  MESSAGETEST035SUPPRDI01
    ${dossier_message2} =  Ajouter un message dans le dossier d'instruction  ${di_m3}  ${message}
    Depuis le contexte du message dans le dossier d'instruction  ${di_m3}  ${dossier_message2}
    # On ajoute deux blocnotes
    &{args_blocnote} =  Create Dictionary
    ...  note=TEST035BLOCNOTE01
    Ajouter le bloc-note depuis le contexte du dossier d'instruction  ${di_m3}  ${args_blocnote}
    &{args_blocnote} =  Create Dictionary
    ...  note=TEST035BLOCNOTE02
    Ajouter le bloc-note depuis le contexte du dossier d'instruction  ${di_m3}  ${args_blocnote}
    # On ajoute deux liaisons
    Ajouter la liaison entre le dossier d'instruction source et le dossier d'instruction cible  ${di_m3}  ${di16}
    Ajouter la liaison entre le dossier d'instruction source et le dossier d'instruction cible  ${di_m3}  ${di17}
    Supprimer le dossier d'instruction  ${di_m3}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On vérifie la suppression d'un DI initial qui est le premier de sa
    # numérotation  dont chaque table liée à au moins deux enregistrements
    # On ajoute une contrainte
    # On ajoute deux contraintes
    @{contraintes_a_selectionner} =  Create List  ${id_contrainte_1}  ${id_contrainte_2}
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${di15}  ${contraintes_a_selectionner}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST035SUPPRDICONTRLIB01
    Page Should Contain  TEST035SUPPRDICONTRLIB02
    # On ajoute le rapport d'instruction
    Depuis le contexte du rapport d'instruction  ${di15}
    Click On Submit Button In Subform
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Depuis le contexte du rapport d'instruction  ${di15}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Click On Back Button In Subform
    # On ajoute deux consultations
    Ajouter une consultation depuis un dossier  ${di15}  ${code_service1} - ${libelle_service1}
    Ajouter une consultation depuis un dossier  ${di15}  ${code_service2} - ${libelle_service2}
    # On ajoute deux demandes de commission
    Ajouter la commission depuis le contexte du dossier d'instruction  ${di15}  ${libelle_type_commission}  ${date_ddmmyyyy}
    Ajouter la commission depuis le contexte du dossier d'instruction  ${di15}  ${libelle_type_commission}  ${date_ddmmyyyy}
    # On ajoute deux lots
    ${libelle_lot1} =  Set Variable  TEST035LOT01
    &{args_lot} =  Create Dictionary
    ...  libelle=${libelle_lot1}
    Ajouter le lot  ${di15}  ${args_lot}
    ${libelle_lot2} =  Set Variable  TEST035LOT02
    &{args_lot} =  Create Dictionary
    ...  libelle=${libelle_lot2}
    Ajouter le lot  ${di15}  ${args_lot}
    # On ajoute deux pièces + automatiquement un message
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté retour préfecture
    ${dossier_message1} =  Ajouter une pièce depuis le dossier d'instruction  ${di15}  ${document_numerise_values}
    Ajouter une pièce depuis le dossier d'instruction  ${di15}  ${document_numerise_values}
    Depuis le contexte du message dans le dossier d'instruction  ${di15}  ${dossier_message1}
    # On ajoute un message manuellement
    ${message} =  Set Variable  MESSAGETEST035SUPPRDI01
    ${dossier_message2} =  Ajouter un message dans le dossier d'instruction  ${di15}  ${message}
    Depuis le contexte du message dans le dossier d'instruction  ${di15}  ${dossier_message2}
    # On ajoute deux blocnotes
    &{args_blocnote} =  Create Dictionary
    ...  note=TEST035BLOCNOTE01
    Ajouter le bloc-note depuis le contexte du dossier d'instruction  ${di15}  ${args_blocnote}
    &{args_blocnote} =  Create Dictionary
    ...  note=TEST035BLOCNOTE02
    Ajouter le bloc-note depuis le contexte du dossier d'instruction  ${di15}  ${args_blocnote}
    # On ajoute deux liaisons
    Ajouter la liaison entre le dossier d'instruction source et le dossier d'instruction cible  ${di15}  ${di16}
    Ajouter la liaison entre le dossier d'instruction source et le dossier d'instruction cible  ${di15}  ${di17}
    Supprimer l'instruction  ${di15}  accepter un dossier sans réserve
    Supprimer le dossier d'instruction  ${di15}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On supprime un dossier d'instruction avec un admingen qui a un instructeur lié
    &{args_dossier_admingen} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire15} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM15
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM15
    ...  om_collectivite=MARSEILLE
    ${di16} =  Ajouter la demande par WS  ${args_dossier_admingen}  ${args_petitionnaire15}

    Depuis la page d'accueil  admin  admin
    &{args_om_util} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    Modifier l'utilisateur depuis le menu  admingen  ${args_om_util}
    &{args_instructeur} =  Create Dictionary
    ...  nom=TEST035INSTRUCTEURNOM
    ...  division=subdivision H
    ...  instructeur_qualite=instructeur
    ...  om_utilisateur=Administrateur général
    Ajouter l'instructeur  ${args_instructeur}
    #
    Supprimer le droit depuis le contexte du profil  dossier_instruction_suppression_division_bypass  ADMINISTRATEUR GENERAL

    Depuis la page d'accueil  admingen  admingen
    Depuis le contexte du dossier d'instruction  ${di16}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer

    #
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu  dossier_instruction_suppression_division_bypass  ADMINISTRATEUR GENERAL

    Depuis la page d'accueil  admingen  admingen
    Depuis le contexte du dossier d'instruction  ${di16}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Supprimer le dossier d'instruction  ${di16}

    Depuis la page d'accueil  admin  admin
    &{args_om_util} =  Create Dictionary
    ...  om_collectivite=agglo
    Modifier l'utilisateur depuis le menu  admingen  ${args_om_util}
    Supprimer instructeur  TEST035INSTRUCTEURNOM

    # Vérification de la suppression du dossier d'instruction non initial sur
    # une autorisation qui n'est pas la dernière de sa numérotation
    # - Création de deux dossiers d'instrution initiaux PC
    # - Clôture du DI le plus ancien des deux pour ajouter un modificatif
    # - Le DI le plus ancien des deux ne doit pas être supprimable
    # - LE DI le plus récent des deux doit être supprimable
    # - Le modificatif sur le DI le plus ancien doit être supprimable
    # - Suppression du modificatif sur le DI le plus ancien
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire19} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM19
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM19
    ...  om_collectivite=MARSEILLE
    ${di17} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire19}
    &{args_petitionnaire20} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM20
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM20
    ...  om_collectivite=MARSEILLE
    ${di18} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire20}

    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${di17}  accepter un dossier sans réserve

    &{args_dossier_existant} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di17}
    ${di_m4} =  Ajouter la demande par WS  ${args_dossier_existant}

    Depuis le contexte du dossier d'instruction  ${di17}
    Portlet Action Should Not Be In Form  dossier_instruction  supprimer

    Depuis le contexte du dossier d'instruction  ${di18}
    Portlet Action Should Be In Form  dossier_instruction  supprimer

    Depuis le contexte du dossier d'instruction  ${di_m4}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Supprimer le dossier d'instruction  ${di_m4}

    # On supprime les permissions de supression des dossiers d'instruction du
    # contentieux au profil 'JURISTE'
    Depuis la page d'accueil  admin  admin
    Supprimer le droit depuis le contexte du profil  dossier_contentieux_mes_recours_supprimer  JURISTE
    Supprimer le droit depuis le contexte du profil  dossier_contentieux_tous_recours_supprimer  JURISTE
    Supprimer le droit depuis le contexte du profil  dossier_contentieux_mes_infractions_supprimer  JURISTE
    Supprimer le droit depuis le contexte du profil  dossier_contentieux_toutes_infractions_supprimer  JURISTE

    # On supprime les permissions de supression des dossiers d'instruction ADS
    # au profil 'INSTRUCTEUR'
    Supprimer le droit depuis le contexte du profil  dossier_instruction_supprimer  INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  dossier_instruction_mes_encours_supprimer  INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  dossier_instruction_tous_encours_supprimer  INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  dossier_instruction_mes_clotures_supprimer  INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  dossier_instruction_tous_clotures_supprimer  INSTRUCTEUR

    # Vérification de la suppression d'un dossier d'instruction avec numérotation complet

    # Les options à activer :
    #     option_saisie_numero_complet true
    #     option_afficher_division true
    #     option_dossier_commune true
    #     option_suppression_dossier_instruction true
    Depuis la page d'accueil  admin  admin
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}

    # On désactive l'option
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Isolation du contexte
    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=SUPPRCOND
    ...  departement=040
    ...  commune=192
    ...  insee=040192
    ...  direction_code=QSD
    ...  direction_libelle=Direction de SUPPRCOND
    ...  direction_chef=Chef
    ...  division_code=QSD
    ...  division_libelle=Division QSD
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Pulia Arranccini
    ...  guichet_om_utilisateur_email=parranccini@openads-test.fr
    ...  guichet_om_utilisateur_login=parranccini
    ...  guichet_om_utilisateur_pwd=parranccini
    ...  instr_om_utilisateur_nom=hobert Vissoux
    ...  instr_om_utilisateur_email=hvissoux@openads-test.fr
    ...  instr_om_utilisateur_login=hvissoux
    ...  instr_om_utilisateur_pwd=hvissoux
    Isolation d'un contexte  ${isolation_values}

    # Ajout d'une commune
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=40192
    ...  reg=40
    ...  dep=40
    ...  arr=192
    ...  tncc=0
    ...  ncc=Mont-de-Marsan
    ...  nccenr=Mont-de-Marsan
    ...  libelle=Mont-de-Marsan
    ...  can=40
    ...  comparent=
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter commune avec dates validité  ${com_values}

    # Ajouter un dossier DP sur la commune avec comme numéro de dossier complet :
    # DP 040192 22 000111222333 CNAQ01
    &{args_petitionnaire_3} =  Create Dictionary
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ...  particulier_nom=plopAllaire035
    ...  particulier_prenom=plopJeoffroi035
    &{args_demande_3} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ...  demande_type=Dépôt Initial
    ...  num_dossier_complet=DP04019222000111222333CNAQ01
    ...  commune=${com_values.libelle}
    ...  date_demande=${date_ddmmyyyy}
    ${di1} =  Ajouter la nouvelle demande  ${args_demande_3}  ${args_petitionnaire_3}

    Depuis la page d'accueil  admin  admin

    Depuis le contexte du dossier d'instruction  ${di1}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Supprimer le dossier d'instruction  ${di1}

    # On supprime la permission de supression des dossiers d'instruction au
    # profil 'GUICHET UNIQUE'
    Supprimer le droit depuis le contexte du profil  dossier_instruction_supprimer  GUICHET UNIQUE

    # Désactivation des options
    Depuis la page d'accueil  admin  admin
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}

    # Désactivation de l'option
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

Suppression d'un dossier dont le code pour la commune ou le département vaut 000
	[Documentation]  En tant qu'administrateur, active l'option de suppression des dossiers
    ...  d'instruction.
    ...  Crée une nouvelle collectivité ainsi que la commune et le département correspondant
    ...  en leur donnant le code 000.
    ...  Ajoute un dossier pour cette collectivité puis déclenche sa suppression. La
    ...  suppression ne doit pas déclencher d'erreur.

    # On active l'option de suppression des dossiers d'instruction
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Isolation du contexte
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=TNRCITYSUPPR000
    ...  departement=000
    ...  commune=000
    ...  insee=00000
    ...  direction_code=AZEW
    ...  direction_libelle=Direction de TNRCITYSUPPR000
    ...  direction_chef=Chef
    ...  division_code=AZEW
    ...  division_libelle=Division AZEW
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Jules Boulé
    ...  guichet_om_utilisateur_email=jboule@openads-test.fr
    ...  guichet_om_utilisateur_login=jboule
    ...  guichet_om_utilisateur_pwd=jboule
    ...  instr_om_utilisateur_nom=Arnaud Chateau
    ...  instr_om_utilisateur_email=achateau@openads-test.fr
    ...  instr_om_utilisateur_login=achateau
    ...  instr_om_utilisateur_pwd=achateau
    Isolation d'un contexte  ${isolation_values}
    &{args_petitionnaire_4} =  Create Dictionary
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ...  particulier_nom=Collin
    ...  particulier_prenom=Roxanne
    &{args_demande_4} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ...  demande_type=Dépôt Initial
    ${di_000} =  Ajouter la demande par WS  ${args_demande_4}  ${args_petitionnaire_4}
    Supprimer le dossier d'instruction  ${di_000}

    # Désactivation de l'option
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

Normalisation de l'adresse du terrain 	
	[Documentation]  Création d'une adresse normalisée récupérée depuis la BAN, 	
	...  sur un dossier d'instruction et vérification de l'utilisation de cette 	
	...  adresse dans certains affichages et pour la recherche avancée. 	

	Depuis la page d'accueil  admin  admin 	

	&{args_demande} =  Create Dictionary 	
	...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes 	
	...  demande_type=Dépôt Initial 	
	...  om_collectivite=MARSEILLE 	
	...  terrain_adresse_voie_numero=56 	
	...  terrain_adresse_voie=boulevard Amiral Courbet 	
	...  terrain_adresse_lieu_dit= 	
	...  terrain_adresse_code_postal= 	
	...  terrain_adresse_localite=Marseille 	
	...  terrain_adresse_bp= 	
	...  terrain_adresse_cedex= 	
	&{args_petitionnaire} =  Create Dictionary 	
	...  particulier_civilite=Madame 	
	...  particulier_nom=Reault 	
	...  particulier_prenom=Yvette 	
	...  om_collectivite=MARSEILLE 	
	${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire} 	

	# Utilisation de la fonctionnalité de normalisation de l'adresse 	
	Depuis le contexte du dossier d'instruction  ${di} 	
	Click On Form Portlet Action  dossier_instruction  normalize_address  modale 	
	${expected_address_value} =  Catenate 	
	...  SEPARATOR=${SPACE} 	
	...  ${args_demande.terrain_adresse_voie_numero} 	
	...  ${args_demande.terrain_adresse_voie} 	
	...  ${args_demande.terrain_adresse_localite} 	
	Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#sousform-normalize_address input#address  ${expected_address_value} 	
	Wait Until Element Is Visible  css=ul.ui-autocomplete 	
	${normalized_address} =  Get Text  css=ul.ui-autocomplete li.ui-menu-item a 	
	Click Element Until No More Element 	
	...  css=ul.ui-autocomplete li.ui-menu-item a 	
	Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#sousform-normalize_address input#address  ${normalized_address} 	
	Click Element Until No More Element 	
	...  css=#sousform-normalize_address form[name="f2_normalize_address"] div.formControls input[type="submit"] 	
	Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Contain From List  css=.localisation-terrain-adresse  ${normalized_address} 	

	# Message précisant que l'adresse a déjà été normalisée 	
	Click On Form Portlet Action  dossier_instruction  normalize_address  modale 	
	Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#sousform-normalize_address input#address  ${normalized_address} 	
	Element Text Should Be  css=div#sousform-normalize_address div.message p span.text  L'adresse de ce terrain a déjà été normalisée. 	

	# Recherche du dossier depuis l'adresse normalisée 	
	Depuis le listing  dossier_instruction 	
	Input Text  css=div#adv-search-adv-fields input#adresse  *${normalized_address} 	
	Click On Search Button 	
	Element Should Contain  css=#tab-dossier_instruction table.tab-tab tbody  ${di} 	
	# Recherche du dossier depuis l'adresse du dossier 	
	Input Text  css=div#adv-search-adv-fields input#adresse  *${args_demande.terrain_adresse_voie} 	
	Click On Search Button 	
	Element Should Contain  css=#tab-dossier_instruction table.tab-tab tbody  ${di} 	

	# Ajoute une instruction pour mettre à jour l'adresse du dossier d'autorisation 	
	# et vérifie l'adresse dans son listing et sur la fiche 	
	${da} =  Get Substring  ${di}  0  -2 	
	Ajouter une instruction au DI  ${di}  Notification de pieces manquante 	
	Depuis le listing des dossiers d'autorisation 	
	Input Text  css=div#adv-search-adv-fields input#adresse  *${normalized_address} 	
	Click On Search Button 	
	Element Should Contain  css=#tab-dossier_autorisation table.tab-tab tbody  ${da} 	
	Input Text  css=div#adv-search-adv-fields input#adresse  *${args_demande.terrain_adresse_voie} 	
	Click On Search Button 	
	Element Should Contain  css=#tab-dossier_autorisation table.tab-tab tbody  ${da} 	
	Click On Link  ${da} 	
	Form Static Value Should Be  css=#infos_localisation_terrain  ${normalized_address} 	

	# Modification de l'adresse depuis le dossier 	
	&{di_values} =  Create Dictionary 	
	...  terrain_adresse_voie_numero=${EMPTY} 	
	...  terrain_adresse_voie=rue de la république 	
	...  terrain_adresse_lieu_dit= 	
	...  terrain_adresse_code_postal= 	
	...  terrain_adresse_localite=Marseille 	
	...  terrain_adresse_bp= 	
	...  terrain_adresse_cedex= 	
	Modifier le dossier d'instruction  ${di}  ${di_values} 	
	Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Text Should Not Be  css=.localisation-terrain-adresse  ${normalized_address} 	
	Click On Form Portlet Action  dossier_instruction  normalize_address  modale 	
	Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=#sousform-normalize_address  L'adresse de ce terrain a déjà été normalisée. 	

	# Recherche du dossier depuis l'adresse normalisée doit échouée 	
	Depuis le listing  dossier_instruction 	
	Input Text  css=div#adv-search-adv-fields input#adresse  *${normalized_address} 	
	Click On Search Button 	
	Element Should Not Contain  css=#tab-dossier_instruction table.tab-tab tbody  ${di} 	
	# Recherche du dossier depuis l'adresse du dossier 	
	Input Text  css=div#adv-search-adv-fields input#adresse  *${di_values.terrain_adresse_voie} 	
	Click On Search Button 	
	Element Should Contain  css=#tab-dossier_instruction table.tab-tab tbody  ${di} 	

	Normaliser l'adresse du terrain avec le premier résultat  ${di}

Vérification de l'apparition de journal d'instruction depuis le menu 'mes encours', 'tous les encours', 'mes clotures' et 'tous les clotures'
    [Documentation]  Ce test vérifie que l'option journal d'instruction apparait depuis
    ...    le menu 'mes encours', 'tous les encours', 'mes clotures' et 'tous les clotures'
    
    Depuis la page d'accueil  admin  admin
    # Création d'un instructeur ADMINISTRATEUR GENERAL
    &{args_instructeur} =  Create Dictionary
    ...  nom=Uriel 
    ...  division=subdivision H
    ...  instructeur_qualite=instructeur
    ...  om_utilisateur=Administrateur gen Marseile
    Ajouter l'instructeur  ${args_instructeur}

    # Création d'un dossier
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035LOGS
    ...  particulier_prenom=TEST035LOGS
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire}
    &{di_values} =  Create Dictionary
    ...  instructeur=Uriel
    Modifier le dossier d'instruction  ${di}  ${di_values}
    
    Depuis la page d'accueil  admingenmars  admingenmars

    # Depuis le menu mes encours
    
    Depuis le contexte du dossier d'instruction de mes encours  ${di}
    # Vérifie l'action Journnal d'instruction pour l'instructeur polyvalent
    Element Should Be Visible  css=.om-prev-icon.om-icon-16.journal-instruction-16

    # Depuis le menu tous les encours
    
    Depuis le contexte du dossier d'instruction de tous les encours  ${di}
    # Vérifie l'action Journnal d'instruction pour l'instructeur polyvalent
    Element Should Be Visible  css=.om-prev-icon.om-icon-16.journal-instruction-16

    Ajouter une instruction au DI et la finaliser  ${di}
    ...  accepter un dossier sans réserve

    # Depuis le menu mes clotures

    Depuis le contexte du dossier d'instruction de mes clotures  ${di}
    # Vérifie l'action Journnal d'instruction pour l'instructeur polyvalent
    Element Should Be Visible  css=.om-prev-icon.om-icon-16.journal-instruction-16

    # Depuis le menu tous les clotures

    Depuis le contexte du dossier d'instruction de tous les cloture  ${di}
    # Vérifie l'action Journnal d'instruction pour l'instructeur polyvalent
    Element Should Be Visible  css=.om-prev-icon.om-icon-16.journal-instruction-16

Vérification du découpage des données mises à jour du DA
    [Documentation]  Vérifie le découpage des mises à jour des données du
    ...  dossier d'autorisation.
    ...  Depuis un PCI initial qui met à jour toutes les données du DA, la mise
    ...  à jour des données techniques est désactivée et la fiche du DA est
    ...  contrôlé.

    &{args_dossier_para} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1_para} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=T035DOSSPARAN
    ...  particulier_prenom=T035DOSSPARAP
    ...  om_collectivite=MARSEILLE
    ${dipara1} =  Ajouter la demande par WS  ${args_dossier_para}  ${args_petitionnaire1_para}

    # Vérifie la mise à jour des données techniques su DA depuis le DI initial
    Depuis la page d'accueil  instr  instr
    &{donnees_techniques_values} =  Create Dictionary
    ...  ope_proj_desc=Description test dossier parallèle
    Saisir les données techniques du DI  ${dipara1}  ${donnees_techniques_values}
    ${da_para} =  Get Substring  ${dipara1}  0  -2
    Depuis le contexte du dossier d'autorisation  ${da_para}
    Element Should Contain  da_description_projet  -
    Depuis le formulaire de modification du dossier d'instruction  ${dipara1}
    Open Fieldset  dossier_instruction  demandeur
    Click Element Until New Element  css=div.synthese_demandeur a.edit_demandeur  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  css=#particulier_nom  T035DOSSPARANCHANGED
    Click Element Until No More Element  css=#sousform-petitionnaire input[value=Modifier]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click Element Until No More Element  css=#sousform-petitionnaire a.retour
    Ajouter une instruction au DI  ${dipara1}  adjoint
    Depuis le contexte du dossier d'autorisation  ${da_para}
    Element Should Contain  css=#da_demandeur  T035DOSSPARANCHANGED
    Element Should Contain  css=#da_description_projet  Description test dossier parallèle

    # Désactive la mise à jour des données techniques du DA depuis le DI initial
    Depuis la page d'accueil  admin  admin
    &{val_type_PCI_P} =  Create Dictionary
    ...  maj_da_dt=false
    Modifier type de dossier d'instruction  PCI  P  ${val_type_PCI_P}

    # Vérifie que les données techniques n'ont pas été mise à jour sur le DA
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${dipara1}
    &{donnees_techniques_values_2} =  Create Dictionary
    ...  ope_proj_desc=Dossier sans maj données techniques
    Saisir les données techniques du DI  ${dipara1}  ${donnees_techniques_values_2}
    Depuis le contexte du dossier d'autorisation  ${da_para}
    Element Should Contain  css=#da_description_projet  Description test dossier parallèle
    Depuis le formulaire de modification du dossier d'instruction  ${dipara1}
    Open Fieldset  dossier_instruction  demandeur
    Click Element Until New Element  css=div.synthese_demandeur a.edit_demandeur  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  css=#particulier_nom  T035DOSSPARANCHANGED2
    Click Element Until No More Element  css=#sousform-petitionnaire input[value=Modifier]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click Element Until No More Element  css=#sousform-petitionnaire a.retour
    Ajouter une instruction au DI  ${dipara1}  ARRÊTÉ DE REFUS
    Depuis le contexte du dossier d'autorisation  ${da_para}
    Element Should Contain  css=#da_demandeur  T035DOSSPARANCHANGED2
    Element Should Contain  css=#da_description_projet  Description test dossier parallèle

    # Réactive la mise à jour des données techniques du DA depuis le DI initial
    Depuis la page d'accueil  admin  admin
    &{val_type_PCI_P} =  Create Dictionary
    ...  maj_da_dt=true
    Modifier type de dossier d'instruction  PCI  P  ${val_type_PCI_P}


Vérification de l'instruction de dossier en parallèle
    [Documentation]  Vérifie l'instruction de plusieurs dossiers d'instruction
    ...  sur la même autorisation, en parallèle.
    ...  Depuis un PCI initial accordé, ajout d'un modificatif, d'une DOC et
    ...  à nouveau d'un modificatif. Les trois dossiers d'instruction sont
    ...  instruits parallèlement.
    ...  On vérifie également le comportemet de la mise à jour des données du DA
    ...  lors de l'ajout d'un DI en parallèle mais également lors de la
    ...  suppression d'un DI en parallèle.
    ...  On s'attarde également sur la mise à jour des demandeurs sur le DA afin
    ...  de ne pas avoir de doublon de demandeur principal dans les liaisons
    ...  entre le DA et les demandeurs.

    # Modification des types d'instruction PCI modificatif et DOC pour ne plus
    # mettre à jour toutes les données du DA
    # Le modificatif met à jour toutes les données excepté la date de DOC
    # La DOC met à jour seulement la date de DOC et les données techniques
    Depuis la page d'accueil  admin  admin
    &{val_type_PCI_DOC} =  Create Dictionary
    ...  maj_da_date_daact=false
    ...  maj_da_date_validite=false
    ...  maj_da_date_init=false
    ...  maj_da_etat=false
    ...  maj_da_demandeur=false
    ...  maj_da_lot=false
    ...  maj_da_localisation=false
    ...  maj_da_date_doc=true
    ...  maj_da_dt=true
    Modifier type de dossier d'instruction  PCI  DOC  ${val_type_PCI_DOC}
    &{val_type_PCI_M} =  Create Dictionary
    ...  maj_da_date_doc=false
    Modifier type de dossier d'instruction  PCI  M  ${val_type_PCI_M}

    # Ajout d'un événement disponible pour une DOC et Modificatif, permettant de
    # modifier la date de chantier (un modificatif ne devrait pas pouvoir
    # modifier la date de chantier)
    @{type_di} =  Create List
    ...  PCI - DOC - Ouverture de chantier
    ...  PCI - M - Modificatif
    @{etats_autorises} =  Create List  delai de notification envoye
    &{args_evenement_para} =  Create Dictionary
    ...  libelle=Déclaration ouverture de chantier - 035_dossier_instruction
    ...  dossier_instruction_type=${type_di}
    ...  action=executer les travaux
    ...  etats_autorises=${etats_autorises}
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etats_autorises}
    ...  etat=delai de notification envoye
    Ajouter l'événement depuis le menu  ${args_evenement_para}

    # Ajout d'un événement de réouverture de l'instruction du dossier pour les
    # Modificatif et les DOC
    &{args_action} =  Create Dictionary
    ...  action=reprise_instruction_035
    ...  libelle=reprise de l'instruction - 035
    ...  regle_etat=etat
    ...  regle_accord_tacite=accord_tacite
    ...  regle_avis=null
    ...  regle_date_validite=null
    ...  regle_date_decision=null
    Ajouter Action  ${args_action}
    @{etats_autorises2} =  Create List  dossier accepter
    &{args_evenement_para2} =  Create Dictionary
    ...  libelle=Reprise de l'instruction - 035_dossier_instruction
    ...  dossier_instruction_type=${type_di}
    ...  action=${args_action.libelle}
    ...  etats_autorises=${etats_autorises2}
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etats_autorises2}
    ...  etat=delai de notification envoye
    ...  accord_tacite=Non
    Ajouter l'événement depuis le menu  ${args_evenement_para2}

    &{args_dossier_para2} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1_para2} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035DOSSIERPARALLELENOM2
    ...  particulier_prenom=TEST035DOSSIERPARALLELEPRENOM2
    ...  om_collectivite=MARSEILLE
    ${dipara2} =  Ajouter la demande par WS  ${args_dossier_para2}  ${args_petitionnaire1_para2}
    ${da_para2} =  Get Substring  ${dipara2}  0  -2
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${dipara2}  accepter un dossier sans réserve

    # Vérifie que l'ajout d'un modificatif sur l'initial est possible puis ajout
    # de celui-ci
    &{args_demande_modif_para} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${dipara2}
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte de demande sur dossier en cours via le menu  ${dipara2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  demande_type  ${args_demande_modif_para.demande_type}
    &{args_petitionnaire_modif_para} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035DOSSIERPARALLELENOM2.5
    ...  particulier_prenom=TEST035DOSSIERPARALLELEPRENOM2.5
    ...  delete_demandeur=true
    ${di_modif_para} =  Ajouter la demande sur dossier en cours  ${dipara2}  ${args_demande_modif_para}  ${args_petitionnaire_modif_para}

    # Vérifie que le DA ne soit pas lié à deux demandeurs principaux
    # Donc on vérifie que le DA n'apparait qu'une fois dans le listing des DA
    Depuis le listing des dossiers d'autorisation
    ${da_para2_sans_espace} =  Sans espace  ${da_para2}
    Input Text  css=div#adv-search-adv-fields input#dossier  ${da_para2_sans_espace}
    Click On Search Button
    Total Results Should Be Equal  1
    Elements From Column Should Be  2  ${args_petitionnaire1_para2.particulier_nom} ${args_petitionnaire1_para2.particulier_prenom}

    # Vérifie que l'ajout d'une DOC dans ce contexte n'est pas possible
    &{args_demande_doc_para} =  Create Dictionary
    ...  demande_type=Demande d'ouverture de chantier
    ...  dossier_instruction=${dipara2}
    Depuis le contexte de demande sur dossier en cours via le menu  ${dipara2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  demande_type  ${args_demande_doc_para.demande_type}
    Depuis le contexte de demande sur dossier en cours via le menu  ${di_modif_para}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  demande_type  ${args_demande_doc_para.demande_type}

    # Modification des types de demande pour qu'une DOC et un modificatif soient
    # compatibles à l'instruction en parallèle
    @{type_di_comp_doc} =  Create List  PCI - Modificatif
    &{type_PCI_DOC_comp} =  Create Dictionary
    ...  dossier_instruction_type_compatible=${type_di_comp_doc}
    Depuis la page d'accueil  admin  admin
    Modifier le type de demande  PCI  DOC  ${type_PCI_DOC_comp}

    # Vérifie que l'ajout d'une DOC sur l'initial ou le modificatif est
    # désormais possible puis ajout de celle-ci
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte de demande sur dossier en cours via le menu  ${dipara2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  demande_type  ${args_demande_doc_para.demande_type}
    Depuis le contexte de demande sur dossier en cours via le menu  ${di_modif_para}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  demande_type  ${args_demande_doc_para.demande_type}
    ${di_doc_para} =  Ajouter la demande par WS  ${args_demande_doc_para}

    # Vérifie que la DOC ne soit pas liée à deux demandeurs principaux
    # Donc on vérifie que le DI n'apparait qu'une fois dans le listing des DI
    Depuis le listing  dossier_instruction
    ${di_doc_para_sans_espace} =  Sans espace  ${di_doc_para}
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di_doc_para_sans_espace}
    Click On Search Button
    Total Results Should Be Equal  1
    Elements From Column Should Be  4  ${args_petitionnaire1_para2.particulier_nom} ${args_petitionnaire1_para2.particulier_prenom}

    # Vérifie que les deux dossiers d'instruction en cours sont affichés sur la
    # fiche du DA et que les données techniques du DI sont affichées
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Contain  da_demandeur  ${args_petitionnaire1_para2.particulier_nom}  ${args_petitionnaire1_para2.particulier_prenom}
    Element Should Contain  dit_libelle_0  Ouverture de chantier
    Element Should Contain  dit_libelle_1  Modificatif

    # Vérifie les modifications sur la fiche du DA
    ${date_chantier_doc} =  Add Time To Date  ${date_ddmmyyyy}  5 days  %d/%m/%Y  True  %d/%m/%Y
    Ajouter une instruction au DI  ${di_doc_para}  Déclaration ouverture de chantier - 035_dossier_instruction  ${date_chantier_doc}
    &{donnees_techniques_values_doc} =  Create Dictionary
    ...  ope_proj_desc=Description test dossier parallèle doc
    Saisir les données techniques du DI  ${di_doc_para}  ${donnees_techniques_values_doc}
    Ajouter une instruction au DI et la finaliser  ${di_doc_para}  accepter un dossier sans réserve
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Contain  da_demandeur  ${args_petitionnaire1_para2.particulier_nom}  ${args_petitionnaire1_para2.particulier_prenom}
    Element Should Contain  dit_libelle_0  Modificatif
    Element Should Not Be Visible  dit_libelle_1
    Element Should Contain  date_depot_DOC  ${date_chantier_doc}
    Element Should Contain  da_description_projet  ${donnees_techniques_values_doc.ope_proj_desc}
    ${date_chantier_m} =  Add Time To Date  ${date_ddmmyyyy}  10 days  %d/%m/%Y  True  %d/%m/%Y
    Ajouter une instruction au DI  ${di_modif_para}  Déclaration ouverture de chantier - 035_dossier_instruction  ${date_chantier_m}
    &{donnees_techniques_values_m} =  Create Dictionary
    ...  co_tot_coll_nb=10
    Saisir les données techniques du DI  ${di_modif_para}  ${donnees_techniques_values_m}
    Ajouter une instruction au DI et la finaliser  ${di_modif_para}  accepter un dossier sans réserve
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Contain  da_demandeur  ${args_petitionnaire_modif_para.particulier_nom} ${args_petitionnaire_modif_para.particulier_prenom}
    Element Should Not Be Visible  dit_libelle_0
    Element Should Not Be Visible  dit_libelle_1
    Element Should Contain  date_depot_DOC  ${date_chantier_doc}
    Element Should Contain  da_description_projet  ${donnees_techniques_values_doc.ope_proj_desc}
    Element Should Contain  da_nombre_logement_crees_collectif  ${donnees_techniques_values_m.co_tot_coll_nb}

    # Vérification des données sur la fiche du DA suite à l'ajout d'un nouveau
    # DI, à la suppression de l'instruction de clôture et à la suppression du DI
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    Ajouter le droit depuis le menu si il n'existe pas  dossier_instruction_supprimer  INSTRUCTEUR
    Depuis la page d'accueil  instr  instr
    ${di_modif_para2} =  Ajouter la demande par WS  ${args_demande_modif_para}
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Contain  dit_libelle_0  Modificatif
    Element Should Contain  date_depot_DOC  ${date_chantier_doc}
    Element Should Contain  da_description_projet  ${donnees_techniques_values_doc.ope_proj_desc}
    Element Should Contain  da_nombre_logement_crees_collectif  ${donnees_techniques_values_m.co_tot_coll_nb}
    &{donnees_techniques_values_m2} =  Create Dictionary
    ...  ope_proj_desc=Une description vraiment différente pour le M02
    Saisir les données techniques du DI  ${di_modif_para2}  ${donnees_techniques_values_m2}
    Ajouter une instruction au DI  ${di_modif_para2}  accepter un dossier sans réserve
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Not Be Visible  dit_libelle_0
    Element Should Contain  date_depot_DOC  ${date_chantier_doc}
    Element Should Contain  da_description_projet  ${donnees_techniques_values_m2.ope_proj_desc}
    Element Should Contain  da_nombre_logement_crees_collectif  ${donnees_techniques_values_m.co_tot_coll_nb}
    Depuis la page d'accueil  admin  admin
    Supprimer l'instruction  ${di_modif_para2}  accepter un dossier sans réserve
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Contain  dit_libelle_0  Modificatif
    Element Should Contain  date_depot_DOC  ${date_chantier_doc}
    Element Should Contain  da_description_projet  ${donnees_techniques_values_doc.ope_proj_desc}
    Element Should Contain  da_nombre_logement_crees_collectif  ${donnees_techniques_values_m.co_tot_coll_nb}
    Supprimer le dossier d'instruction  ${di_modif_para2}
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Not Be Visible  dit_libelle_0
    Element Should Contain  date_depot_DOC  ${date_chantier_doc}
    Element Should Contain  da_description_projet  ${donnees_techniques_values_doc.ope_proj_desc}
    Element Should Contain  da_nombre_logement_crees_collectif  ${donnees_techniques_values_m.co_tot_coll_nb}
    ${di_modif_para3} =  Ajouter la demande par WS  ${args_demande_modif_para}
    &{donnees_techniques_values_m3} =  Create Dictionary
    ...  ope_proj_desc=Encore plus différent pour le M03
    ...  co_tot_coll_nb=25
    Saisir les données techniques du DI  ${di_modif_para3}  ${donnees_techniques_values_m3}
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Contain  dit_libelle_0  Modificatif
    Element Should Contain  date_depot_DOC  ${date_chantier_doc}
    Element Should Contain  da_description_projet  ${donnees_techniques_values_doc.ope_proj_desc}
    Element Should Contain  da_nombre_logement_crees_collectif  ${donnees_techniques_values_m.co_tot_coll_nb}

    # Vérification de la reprise de l'instruction
    Ajouter une instruction au DI  ${di_modif_para3}  accepter un dossier sans réserve
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Not Be Visible  dit_libelle_0
    Element Should Contain  date_depot_DOC  ${date_chantier_doc}
    Element Should Contain  da_description_projet  ${donnees_techniques_values_m3.ope_proj_desc}
    Element Should Contain  da_nombre_logement_crees_collectif  ${donnees_techniques_values_m3.co_tot_coll_nb}
    Ajouter une instruction au DI  ${di_modif_para3}  Reprise de l'instruction - 035_dossier_instruction
    Depuis le contexte du dossier d'autorisation  ${da_para2}
    Element Should Contain  dit_libelle_0  Modificatif
    Element Should Contain  date_depot_DOC  ${date_chantier_doc}
    Element Should Contain  da_description_projet  ${donnees_techniques_values_doc.ope_proj_desc}
    Element Should Contain  da_nombre_logement_crees_collectif  ${donnees_techniques_values_m.co_tot_coll_nb}

    # Remise à la valeur initiale des paramètres
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    Supprimer le droit depuis le contexte du profil  dossier_instruction_supprimer  INSTRUCTEUR

    # Réactive la mise à jour des infos pour les deux types de dossier
    &{val_type_PCI_DOC} =  Create Dictionary
    ...  maj_da_dt=true
    ...  maj_da_date_daact=true
    ...  maj_da_date_validite=true
    ...  maj_da_date_init=true
    ...  maj_da_etat=true
    ...  maj_da_demandeur=true
    ...  maj_da_lot=true
    ...  maj_da_localisation=true
    Modifier type de dossier d'instruction  PCI  DOC  ${val_type_PCI_DOC}
    &{val_type_PCI_M} =  Create Dictionary
    ...  maj_da_date_doc=true
    Modifier type de dossier d'instruction  PCI  M  ${val_type_PCI_M}
    # Supprime le dossier compatible du type de demande
    Désactiver les types de demande compatible  PCI  DOC  ${type_PCI_DOC_comp}


Vérification du cas des dossiers en parallèle sur un initial dont l'autorité compétente est différent de commune
    [Documentation]  Vérifie l'instruction de plusieurs dossiers d'instruction
    ...  sur la même autorisation, en parallèle dont l'un est l'initial.
    ...  Depuis un PCI initial en cours dont l'autorité compétente n'est pas la
    ...  commune, ajout d'un modificatif. Les deux dossiers d'instruction sont
    ...  instruits parallèlement.

    # Ajout du type de dossier d'instruction compatible
    Depuis la page d'accueil  admin  admin
    @{type_di_comp} =  Create List  PCI - Initial
    &{type_PCI_DM_comp} =  Create Dictionary
    ...  dossier_instruction_type_compatible=${type_di_comp}
    Modifier le type de demande  PCI  DM  ${type_PCI_DM_comp}

    # Ajout du dossier d'instruction initial et modifie son autorité compétente
    &{args_dossier_para3} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1_para3} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035DOSSIERPARALLELENOM3
    ...  particulier_prenom=TEST035DOSSIERPARALLELEPRENOM3
    ...  om_collectivite=MARSEILLE
    ${dipara3} =  Ajouter la demande par WS  ${args_dossier_para3}  ${args_petitionnaire1_para3}
    ${da_para3} =  Get Substring  ${dipara3}  0  -2
    &{args_demande_modif_para3} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${dipara3}
    # Vérifie qu'avec l'autorité commune, il n'est pas possible d'avoir de DI
    # en parallèle
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte de demande sur dossier en cours via le menu  ${dipara3}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  demande_type  ${args_demande_modif_para3.demande_type}
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${dipara3}  Changer l'autorité compétente 'commune état'
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte de demande sur dossier en cours via le menu  ${dipara3}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  demande_type  ${args_demande_modif_para3.demande_type}
    ${di_modif_para3} =  Ajouter la demande par WS  ${args_demande_modif_para3}
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'autorisation  ${da_para3}
    Element Should Contain  dit_libelle_0  Modificatif
    Element Should Contain  dit_libelle_1  Initial

    # Supprime le dossier compatible du type de demande
    Depuis la page d'accueil  admin  admin
    Désactiver les types de demande compatible  PCI  DM  ${type_PCI_DM_comp}


Vérification de l'ajout de demande ne créant pas de DI
    [Documentation]  Vérifie la possibilité d''ajouter des demandes sans
    ...  création de dossier d'instruction mais seulement d'un événement sur le
    ...  dossier ciblé.

    &{args_dossier_para4} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1_para4} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035DOSSIERPARALLELENOM4
    ...  particulier_prenom=TEST035DOSSIERPARALLELEPRENOM4
    ...  om_collectivite=MARSEILLE
    ${dipara4} =  Ajouter la demande par WS  ${args_dossier_para4}  ${args_petitionnaire1_para4}
    ${da_para4} =  Get Substring  ${dipara4}  0  -2
        # Ajout de la demande en parallèle
    &{args_demande_modif_para4} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${dipara4}
    ${di_modif_para4} =  Ajouter la demande par WS  ${args_demande_modif_para4}

    # Vérifie la possibilité d'ajouter la demande dans les différents contextes
    # et contrôle la création de l'événement et la non création de DI
    &{args_demande_depot_para4} =  Create Dictionary
    ...  demande_type=Dépôt de pièces complémentaire
    ...  om_collectivite=MARSEILLE
    ...  dossier_instruction=${dipara4}
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte de demande sur dossier en cours via le menu  ${dipara4}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  demande_type  ${args_demande_depot_para4.demande_type}
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${dipara4}  Notification de pieces manquante
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte de demande sur dossier en cours via le menu  ${dipara4}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  demande_type  ${args_demande_depot_para4.demande_type}
    ${di_depot_para4} =  Ajouter la demande par WS  ${args_demande_depot_para4}
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet instruction du dossier d'instruction  ${dipara4}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dépôt de pièces complémentaires
    Depuis l'onglet instruction du dossier d'instruction  ${di_modif_para4}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  dépôt de pièces complémentaires
    Depuis le contexte du dossier d'autorisation  ${da_para4}
    Page Should Not Contain Element  dit_libelle_1

    # Vérifie qu'il n'existe pas de doublon dans le listing des dossiers d'instruction
    Depuis le listing  dossier_instruction
    ${libelle_sans_espace} =  Sans espace  ${dipara4}
    Input Text  css=div#adv-search-adv-fields input#dossier  ${libelle_sans_espace}
    Click On Search Button
    ${count} =  Get Element Count  css=table.tab-tab tbody tr
    Should Be True  ${count} == 1


Date d'affichage obligatoire
    [Documentation]  Vérifie la gestion de la date d'affichage obligatoire

    # en tant qu'admin
    Depuis la page d'accueil  admin  admin

    #-- ajout du paramétrage
    # action de mise à jour de la date d'affichage
    &{args_action} =  Create Dictionary
    ...  action=maj_date_affichage
    ...  libelle=mise à jour de la date d'affichage
    ...  regle_date_affichage=date_evenement
    Ajouter Action  ${args_action}
    # évènement d'affichage obligatoire
    &{args_evenement} =  Create Dictionary
    ...  evenement=89
    ...  libelle=affichage_obligatoire
    ...  action=mise à jour de la date d'affichage
    Modifier l'événement  ${args_evenement}

    #-- jeu de données
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035DATEAFF
    ...  particulier_prenom=TEST035DATEAFF
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire}

    #-- présence de la date d'Affichage obligatoire
    #-- absence de l'action de portlet d'Affichage obligatoire
    # avec un profil ayant l'autorisation
    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Contain  lib-date_affichage  Date d'affichage
    Portlet Action Should Not Be In SubForm  dossier_instruction  date_affichage
    # avec un profil n'ayant pas l'autorisation
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Contain  lib-date_affichage  Date d'affichage
    Portlet Action Should Not Be In SubForm  dossier_instruction  date_affichage

    #-- modification manuelle de la date d'affichage
    # avec un profil ayant l'autorisation
    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis le contexte du dossier d'instruction  ${di}
    ${d_aff_1} =  Get Text  date_affichage
    Should Be Equal  ${d_aff_1}  Néant
    &{di_values} =  Create Dictionary
    ...  date_affichage=26/02/2019
    Modifier le dossier d'instruction  ${di}  ${di_values}
    ${d_aff_2} =  Get Text  date_affichage
    Should Be Equal  ${d_aff_2}  26/02/2019
    Should Not Be Equal  ${d_aff_1}  ${d_aff_2}
    # avec un profil n'ayant pas l'autorisation
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  modifier
    Page Should Not Contain  css=input#date_affichage
    Click On Submit Button Until Message  Vos modifications ont bien été enregistrées.

    #-- modification de la date d'affichage par le menu "Registre"
    # Le traitement de registre applique l'événement d'instruction identifié
    # comme attestation d'affichage et c'est celui-ci qui change la date
    # d'affichage
    Depuis la page d'accueil  instrpoly  instrpoly
    &{di_values} =  Create Dictionary
    ...  date_affichage=${EMPTY}
    # Supprime la date d'affichage pour l'événement puisse la mettre à jour
    Modifier le dossier d'instruction  ${di}  ${di_values}
    ${d_aff_3} =  Get Text  date_affichage
    Should Not Be Equal  ${d_aff_3}  ${d_aff_2}
    Should Be Equal  ${d_aff_3}  Néant
    Depuis la page d'accueil  guichet  guichet
    Go To Submenu In Menu  guichet_unique  affichage_reglementaire_registre
    Click Element  id=registre-form-submit
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  2 min  0.4 sec  Valid Message Should Contain  Traitement terminé. Le registre a été généré.
    # Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Traitement terminé. Le registre a été généré.
    La page ne doit pas contenir d'erreur
    Click Element  id=registre-form-download
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Registre des dossiers en cours
    Close PDF
    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Contain  lib-date_affichage  Date d'affichage
    ${d_aff_4} =  Get Text  date_affichage
    Should Not Be Equal  ${d_aff_4}  ${d_aff_3}
    Should Be Equal  ${d_aff_4}  ${date_ddmmyyyy}

    #-- vérification de l'action de portlet d'Affichage obligatoire
    # avec un profil n'ayant pas l'autorisation
    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte du dossier d'instruction  ${di}
    Portlet Action Should Not Be In Form  dossier_instruction  date_affichage
    # avec un profil ayant l'autorisation
    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis le contexte du dossier d'instruction  ${di}
    Portlet Action Should Be In Form  dossier_instruction  date_affichage

    #-- accéder à l'attestation d'affichage via l'action de portlet
    Click On Form Portlet Action  dossier_instruction  date_affichage  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ATTESTATION D'AFFICHAGE REGLEMENTAIRE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di}
    Close PDF

    #-- modification de la lettre type d'Affichage Règlementaire (inclusion complément dans corps)
    Depuis la page d'accueil  admin  admin
    Modifier la lettre-type  attestation_affichage  corps=[complement1_instruction]

    #-- définalisation de l'évènement d'instruction d'affichage obligatoire
    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Click Element Until No More Element  xpath=//a[text()[contains(.,"affichage_obligatoire")]]
    Click On SubForm Portlet Action  instruction  definaliser
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Portlet Action Should Not Be In Form  dossier_instruction  date_affichage

    #-- ajout de la date d'affichage dans les compléments de l'édition
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Click Element Until No More Element  xpath=//a[text()[contains(.,"affichage_obligatoire")]]
    Click On SubForm Portlet Action  instruction  modifier
    Input HTML  complement_om_html  Date d'affichage: [date_affichage]
    Click On Submit Button In Subform Until Message  Vos modifications ont bien été enregistrées.
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ATTESTATION D'AFFICHAGE REGLEMENTAIRE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Date d'affichage: ${date_ddmmyyyy}
    Close PDF

    #-- suppression de l'instruction
    # supprimer l'instruction et vérifier que la valeur du dossier n'est pas
    # modifiée
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Click Element Until No More Element  xpath=//a[text()[contains(.,"affichage_obligatoire")]]
    Click On SubForm Portlet Action  instruction  supprimer
    Click On Submit Button In Subform Until Message  La suppression a été correctement effectuée.  css=div.soustab-message div.message
    Depuis le contexte du dossier d'instruction  ${di}
    Portlet Action Should Not Be In Form  dossier_instruction  date_affichage
    Element Should Contain  lib-date_affichage  Date d'affichage
    ${d_aff_5} =  Get Text  date_affichage
    Should Be Equal  ${d_aff_5}  ${d_aff_4}
    Should Not Be Equal  ${d_aff_5}  Néant

    #-- la modification de la date d'affichage depuis l'événement ne doit pas
    # écraser la date déjà renseignée
    Depuis la page d'accueil  instrpoly  instrpoly
    Ajouter une instruction au DI  ${di}  affichage_obligatoire  27/02/2019
    Depuis le contexte du dossier d'instruction  ${di}
    ${d_aff_6} =  Get Text  date_affichage
    Should Not Be Equal  ${d_aff_6}  27/02/2019
    Should Be Equal  ${d_aff_6}  ${d_aff_5}

    # restauration de l'action de l'évènement
    Depuis la page d'accueil  admin  admin
    &{args_evenement} =  Create Dictionary
    ...  evenement=89
    ...  libelle=affichage_obligatoire
    ...  action=action sans effet sur le dossier
    Modifier l'événement  ${args_evenement}


Transfert d'un dossier sur une année dont aucune séquence n'existe encore
    [Documentation]  Vérifie la possibilité de transférer un dossier dont
    ...  la (nouvelle) date de dépot est d'une année pour laquelle il n'y
    ...  a pas encore de dossier de ce type et donc pas de séquence en BDD.

    Depuis la page d'accueil  admin  admin

    # créé une collectivité
    Ajouter la collectivité depuis le menu  testville1  mono
    Ajouter le paramètre depuis le menu  departement  059  testville1
    Ajouter le paramètre depuis le menu  commune      679  testville1
    Ajouter le paramètre depuis le menu  insee      59679  testville1

    # active l'option de suppression des dossiers d'instruction
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # créer un dossier d'instruction
    &{di_testville1} =  Create Dictionary
    ...  om_collectivite=testville1
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=20/04/2018
    &{petitionnaire_testville1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035TRANSFERTNOSEQUENCE
    ...  particulier_prenom=TEST035TRANSFERTNOSEQUENCE
    ...  om_collectivite=testville1
    ${di_id} =  Ajouter la demande par WS  ${di_testville1}  ${petitionnaire_testville1}

    # accepte le dossier sans réserve (ajoute une instruction)
    Ajouter une instruction au DI  ${di_id}  accepter un dossier sans réserve

    # créé un autre dossier avec demande de modification
    # dans une année où il n'y a pas encore de dossier de ce type
    # (le fait d'avoir créé une nouvelle collectivité permet d'en être sûr)
    &{dim_testville1} =  Create Dictionary
    ...  om_collectivite=testville1
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di_id}
    ...  date_demande=20/05/2019
    ${dim_id} =  Ajouter la demande par WS  ${dim_testville1}

    # accède au dossier
    Depuis le contexte du dossier d'instruction  ${dim_id}

    # il ne doit pas y avoir de bug (erreur de base de données)
    La page ne doit pas contenir d'erreur

    # Désactive option
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

TNR affichage de l'adresse suite à la normalisation
    [Documentation]  Vérifie que l'adresse est toujours correctement affiché
    ...  après une normalisation avec une adresse vide.

    Depuis la page d'accueil  admin  admin

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_voie_numero=56
    ...  terrain_adresse_voie=boulevard Amiral Courbet
    ...  terrain_adresse_lieu_dit=
    ...  terrain_adresse_code_postal=
    ...  terrain_adresse_localite=Marseille
    ...  terrain_adresse_bp=
    ...  terrain_adresse_cedex=
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Reault
    ...  particulier_prenom=Yvette
    ...  om_collectivite=MARSEILLE
    ${di_tnr_normalisation1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Utilisation de la fonctionnalité de normalisation de l'adresse
    Depuis le contexte du dossier d'instruction  ${di_tnr_normalisation1}
    Click On Form Portlet Action  dossier_instruction  normalize_address  modale
    Input Text  css=input#address  ${EMPTY}
    Click Element  css=input[value="Normaliser l'adresse"]

    # Vérification que l'adresse est correcte dans la synthèse du di et dans le listing
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=.localisation-terrain-adresse  56 boulevard Amiral Courbet
    Depuis le listing  dossier_instruction
    Input Text  css=div#adv-search-adv-fields input#adresse  *boulevard Amiral Courbet
    Click On Search Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossier_instruction table.tab-tab tbody  ${di_tnr_normalisation1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_voie_numero=47
    ...  terrain_adresse_voie=rue de la Boétie
    ...  terrain_adresse_lieu_dit=
    ...  terrain_adresse_code_postal=
    ...  terrain_adresse_localite=Poissy
    ...  terrain_adresse_bp=
    ...  terrain_adresse_cedex=
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Bonami
    ...  particulier_prenom=Inès
    ...  om_collectivite=MARSEILLE
    ${di_tnr_normalisation2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Utilisation de la fonctionnalité de normalisation de l'adresse
    Depuis le contexte du dossier d'instruction  ${di_tnr_normalisation2}
    Click On Form Portlet Action  dossier_instruction  normalize_address  modale
    Input Text  css=input#address  ${SPACE}
    Click Element  css=input[value="Normaliser l'adresse"]

    # Vérification que l'adresse est correcte dans la synthèse du di et dans le listing
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.localisation-terrain-adresse  47 rue de la Boétie
    Depuis le listing  dossier_instruction
    Input Text  css=div#adv-search-adv-fields input#adresse  *rue de la Boétie
    Click On Search Button
    Element Should Contain  css=#tab-dossier_instruction table.tab-tab tbody  ${di_tnr_normalisation2}


Affichage du lien streetView
    [Documentation]  Test servant à vérifier que le clic sur le lien streetview ouvre
    ...  bien une nouvelle fenêtre sur Google Maps

    Depuis la page d'accueil  admin  admin

    # Active l'affichage du lien streetView
    &{om_param} =  Create Dictionary
    ...  libelle=option_streetview
    ...  valeur=true
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_voie_numero=56
    ...  terrain_adresse_voie=boulevard Amiral Courbet
    ...  terrain_adresse_lieu_dit=
    ...  terrain_adresse_code_postal=
    ...  terrain_adresse_localite=Marseille
    ...  terrain_adresse_bp=
    ...  terrain_adresse_cedex=
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Reault
    ...  particulier_prenom=Yvette
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # clic sur le lien street map
    Depuis le contexte du dossier d'instruction  ${di}
    Click Link  css=#action-form-gstreetview
    La page ne doit pas contenir d'erreur

    # Vérifie que Maps est bien ouvert
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select Window  NEW
    Location Should Contain  https://www.google.com/maps

    # Désactive l'affichage du lien streetview
    &{om_param} =  Create Dictionary
    ...  libelle=option_streetview
    ...  valeur=false
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

Affichage des champs de la recherche avancée

    [Documentation]  ce test vérifie quand on est en mode service consulte que certains
    ...  champs ne sont pas affichés.

    
    Depuis la page d'accueil  admin  admin
    # activation de mode service consulté
    &{om_param} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    Depuis le listing  dossier_instruction
    Page Should Not Contain Element  css=#accord_tacite
    Page Should Not Contain Element  css=#date_chantier_min
    Page Should Not Contain Element  css=#date_chantier_max
    Page Should Not Contain Element  css=#date_achevement_min
    Page Should Not Contain Element  css=#date_achevement_max
    Page Should Not Contain Element  css=#date_conformite_min
    Page Should Not Contain Element  css=#date_conformite_max
    Page Should Not Contain Element  css=#date_validite_min
    Page Should Not Contain Element  css=#date_validite_max
    Page Should Not Contain Element  css=#date_rejet_min
    Page Should Not Contain Element  css=#date_rejet_max

    # desactivation du mode service consulté
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_mode_service_consulte
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_values}

Modification de la division lors de la modification de l'instructeur
    [Documentation]  ce test vérifie qu'en modification d'un dossier d'instruction
    ...  si l'instructeur est modifié alors la division du dossier est positionnée
    ...  à celle de l'instructeur sélectionné.

    Depuis la page d'accueil  admin  admin
    # Désactive l'affichage de la division pour éviter que le nom de la division fasse bugger
    # la recherche du nom de l'instructeur
    # Cette option est activer globalement dans le test 010_multicollectivite -> Direction
    # Comme l'impact de la modif directement depuis ce test n'est pas connu la modification
    # est faite uniquement ici pour le moment
    # TODO : déplacer cette modif directement dans le test 010
    
    # Remarque : pour que le nom de la division ne soit pas afficher avec le nom de l'instructeur
    # il faut que option_afficher_division ait pour valeur false pour l'agglo et true pour
    # la collectivité
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    Ajouter la collectivité depuis le menu  TestModifDiv  mono
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=TestModifDiv
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}


    # Ajout de 2 instructeur ayant chacun une division différente
    Ajouter la direction depuis le menu  TModifDiv  Direction TModifDiv  null  Chef TModifDiv  null  null  TestModifDiv
    Ajouter la division depuis le menu  test 1  subdivision test 1  null  Jeanette Rochefort  null  null  Direction TModifDiv
    Ajouter l'utilisateur  LANGELIER Audric  alangelier@mail.fr  alangelier  alangelier  INSTRUCTEUR  TestModifDiv
    Ajouter l'instructeur depuis le menu  LANGELIER Audric  subdivision test 1  instructeur  LANGELIER Audric
    Ajouter la division depuis le menu  test 2  subdivision test 2  null  CJeanette Rochefort  null  null  Direction TModifDiv
    Ajouter l'utilisateur  LaGrande Olympia  olagrande@mail.fr  olagrande  olagrande  INSTRUCTEUR  TestModifDiv
    Ajouter l'instructeur depuis le menu  LaGrande Olympia  subdivision test 2  instructeur  LaGrande Olympia

    # Création d'un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Veilleux
    ...  particulier_prenom=Charles
    ...  om_collectivite=TestModifDiv
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=TestModifDiv
    ${di1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Modification du dossier pour choisir le premier instructeur
    Depuis le contexte du dossier d'instruction  ${di1}
    Click On Form Portlet Action  dossier_instruction  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  css=select#instructeur  LANGELIER Audric
    List Selection Should Be  css=select#division  subdivision test 1
    La page ne doit pas contenir d'erreur

    # Sélection du deuxième instructeur
    Select From List By Label  css=select#instructeur  LaGrande Olympia
    List Selection Should Be  css=select#division  subdivision test 2
    La page ne doit pas contenir d'erreur

    # Sélection d'aucun instructeur pour vérifier qu'il n'y a pas d'erreur
    Select From List By Label  css=select#instructeur  choisir l'instructeur
    List Selection Should Be  css=select#division  choisir division
    La page ne doit pas contenir d'erreur

    # Réactive l'affichage de la division
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_afficher_division
    ...  click_value=TestModifDiv
    Supprimer le paramètre (surcharge)  ${param_args}

TNR ajout DI si option commune activée
    [Documentation]  Ce test vérifie qu'après avoir ajouté l'option
    ...  option_dossier_commune dans Administration -> Paramètre,
    ...  puis ajouté un DI(en spécifiant la commune) et l'avoir accepté (ajout instruction).
    ...  lors de l'ajout d'un DI à partir de ce premier, il ne doit y avoir de message d'erreur.
    Depuis la page d'accueil  admin  admin

    # Ajout de l'option
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}

    # Ajout d'une commune
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=40192
    ...  reg=40
    ...  dep=40
    ...  arr=192
    ...  tncc=0
    ...  ncc=Mont-de-Marsan
    ...  nccenr=Mont-de-Marsan
    ...  libelle=Mont-de-Marsan
    ...  can=40
    ...  comparent=
    ...  om_validite_debut=${date_ddmmyyyy}
    Ajouter commune avec dates validité  ${com_values}

    Depuis la page d'accueil  guichet  guichet
    # Création du dossier demande
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TESTAJOUTDIOPTIONCOMMUNENOM
    ...  particulier_prenom=TESTAJOUTDIOPTIONCOMMUNEPRENOM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  commune=Mont-de-Marsan
    ${di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    # Ajout de l'instruction en admin
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve
    
    # Tentative d'ajout d'un DI sur dossier existant
    Depuis le contexte de demande sur dossier en cours via l'URL  ${di}

    # Saisie des informations du DI
    &{args_demande} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  demande_type=Déclaration attestant l'achèvement et la conformité des travaux

    # Ajout de la demande pour vérifier l'absence d'erreur
    Ajouter la demande sur existant  ${di}  ${args_demande}

    # Suppression de l'option
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}

TNR suppression DI transmissible a Plat'AU après modification de son instructeur
    [Documentation]  ce test vérifie qu'après une modification de l'instructeur du dossier
    ...  il est toujours possible de supprimer le dossier.

    Depuis la page d'accueil  admin  admin
    # Désactive l'affichage de la division pour éviter des erreurs
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    Ajouter la collectivité depuis le menu  TNRSUPPRDI  mono
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=TNRSUPPRDI
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # Le dossier doit être transmissible a Plat'AU
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    # Création de 2 instructeur pour la collectivité
    Ajouter la direction depuis le menu  TNRSUPPRDI  Direction TNRSUPPRDI  null  Chef TNRSUPPRDI  null  null  TNRSUPPRDI

    Ajouter la division depuis le menu  test 1  subdivision TNRSUPPRDI 1  null  Delphine Anglais  null  null  Direction TNRSUPPRDI
    Ajouter l'utilisateur  Delphine Anglais  danglais@mail.fr  danglais  danglais  INSTRUCTEUR  TNRSUPPRDI
    Ajouter l'instructeur depuis le menu  Delphine Anglais  subdivision TNRSUPPRDI 1  instructeur  Delphine Anglais

    Ajouter la division depuis le menu  test 2  subdivision TNRSUPPRDI 2  null  Soren Ayot  null  null  Direction TNRSUPPRDI
    Ajouter l'utilisateur  Soren Ayot  sayot@mail.fr  sayot  sayot  INSTRUCTEUR  TNRSUPPRDI
    Ajouter l'instructeur depuis le menu  Soren Ayot  subdivision TNRSUPPRDI 2  instructeur  Soren Ayot

    # On désactive l'option de suppression des dossiers d'instruction
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=TNRSUPPRDI
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300AdresseLocalite
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TNRSUPPRESSIONDOSSIER
    ...  particulier_prenom=TNRSUPPRESSIONDOSSIER
    ...  om_collectivite=TNRSUPPRDI
    ...  localite=TEST300Localite
    ${di1} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di1}  ${donnees_techniques_values}

    # Modification de l'instructeur du dossier
    &{modifications} =  Create Dictionary 
    ...  instructeur=Soren Ayot
    Modifier le dossier d'instruction  ${di1}  ${modifications}
    Valid Message Should Be  Vos modifications ont bien été enregistrées.

    # Vérification que la tâche qualification_DI fait maintenant reférence au dossier
    ${di1_sans_espace} =  Sans espace  ${di1}
    ${di1_da} =  Replace String Using Regexp  ${di1_sans_espace}  [A-Z][0-9]+$  ${EMPTY}
    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di1_sans_espace}
    ...  state=new
    ...  object_id=${di1_sans_espace}
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    # Suppression du dossier d'instruction
    Supprimer le dossier d'instruction  ${di1}
    La page ne doit pas contenir d'erreur

    # Désactive l'option de suppression
    # On désactive l'option
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    # Le type de dossier ne doit plus être transmissible
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    # Réactive l'affichage de la division
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_afficher_division
    ...  click_value=TNRSUPPRDI
    Supprimer le paramètre (surcharge)  ${param_args}


TNR la date de dépôt ne doit pas être supérieur à la date du jour
    [Documentation]  Ce test vérifie que si dans le formulaire de modification du dossier
    ...  l'utilisateur à saisi une date de dépôt dans le futur un message d'erreur
    ...  s'affiche et ses modifications ne sont pas enregistrées

    ${demain} =  Add Time To Date  ${date_ddmmyyyy}  1 days  %d/%m/%Y  True  %d/%m/%Y
    # Création d'un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Futur
    ...  particulier_prenom=Date
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Modification du dossier pour tester l'enregistrement avec une date de dépôt dans le futur
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di1}
    Click On Form Portlet Action  dossier_instruction  modifier
    Input Datepicker  date_depot  ${demain}
    Click On Submit Button
    Error Message Should Contain  La date de depot ne peut pas être superieure à la date du jour.


TNR la colonne du geom doit restée cachée dans les listings des dossiers

    # Isolation du contexte
    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=TNRCITYPICTO
    ...  departement=013
    ...  commune=032
    ...  insee=13032
    ...  direction_code=AZE
    ...  direction_libelle=Direction de TNRCITYPICTO
    ...  direction_chef=Chef
    ...  division_code=AZE
    ...  division_libelle=Division AZE
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Julia Arranccini
    ...  guichet_om_utilisateur_email=jarranccini@openads-test.fr
    ...  guichet_om_utilisateur_login=jarranccini
    ...  guichet_om_utilisateur_pwd=jarranccini
    ...  instr_om_utilisateur_nom=Robert Vissoux
    ...  instr_om_utilisateur_email=rvissoux@openads-test.fr
    ...  instr_om_utilisateur_login=rvissoux
    ...  instr_om_utilisateur_pwd=rvissoux
    Isolation d'un contexte  ${isolation_values}

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_sig
    ...  valeur=sig_externe
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    @{ref_cad} =  Create List  999  ZZ  0013

    &{args_di1} =  Create Dictionary
    ...  om_collectivite=TNRCITYPICTO
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TNRCITYPICTOAdresseLocalite
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}

    &{args_di2} =  Create Dictionary
    ...  om_collectivite=TNRCITYPICTO
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TNRCITYPICTOAdresseLocalite
    ...  date_demande=02/02/2018

    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TNRCITYPICTONOM
    ...  particulier_prenom=TNRCITYPICTOPRENOM
    ...  om_collectivite=TNRCITYPICTO
    ...  localite=TNRCITYPICTOLocalite

    ${di1} =  Ajouter la demande par WS  ${args_di1}  ${args_petitionnaire1}
    ${di1_sans_espace} =  Sans espace  ${di1}
    ${di2} =  Ajouter la demande par WS  ${args_di2}  ${args_petitionnaire1}
    ${di2_sans_espace} =  Sans espace  ${di2}

    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button

    Depuis le listing  dossier_instruction

    Input Text  css=div#adv-search-adv-fields input#dossier  ${di1}
    Click On Search Button
    Element Should Contain  css=#tab-dossier_instruction table.tab-tab tbody  ${di1}
    Page Should Not Contain Element  css=#tab-dossier_instruction table.tab-tab tr.no-geoloc > td > a#action-tab-dossier_instruction-left-localiser-sig-externe-${di1_sans_espace} > span.sig-16
    Page Should Contain Element  css=#tab-dossier_instruction table.tab-tab tr > td > a#action-tab-dossier_instruction-left-localiser-sig-externe-${di1_sans_espace} > span.sig-16

    Input Text  css=div#adv-search-adv-fields input#dossier  ${di2}
    Click On Search Button
    Element Should Contain  css=#tab-dossier_instruction table.tab-tab tbody  ${di2}
    Page Should Contain Element  css=#tab-dossier_instruction table.tab-tab tr.no-geoloc > td > a#action-tab-dossier_instruction-left-localiser-sig-externe-${di2_sans_espace} > span.sig-16

    Page Should Contain Element  xpath=//a[text()[contains(.,"geom_picto")]]
    Element Should Not Be Visible  xpath=//a[text()[contains(.,"geom_picto")]]

    Supprimer le paramètre  option_sig


Un lien vers le journal d'instruction doit apparaître pour les admins
        [Documentation]  Ce test vérifie que dans un dossier d'instruction
    ...  un lien dans le portlet s'affiche menant vers le journal 
    ...  d'instruction (ACTION 200)

    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST200
    ...  particulier_prenom=TESTACTION
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On entre dans le dossier d'instruction en tant qu'admin afin d'accéder au journal d'instruction
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di1}
    Click On Form Portlet Action  dossier_instruction  get_log_di

    # Vérification de l'affichage du tableau du journal d'instruction
    Element Should Contain  css=div#log_instructions_jsontotab  date
    Element Should Contain  css=div#log_instructions_jsontotab  id
    Element Should Contain  css=div#log_instructions_jsontotab  contexte
    Element Should Contain  css=div#log_instructions_jsontotab  login
    Element Should Contain  css=div#log_instructions_jsontotab  date d'événement
    Element Should Contain  css=div#log_instructions_jsontotab  retour RAR
    Element Should Contain  css=div#log_instructions_jsontotab  retour signature
    Element Should Contain  css=div#log_instructions_jsontotab  événement
    Element Should Contain  css=div#log_instructions_jsontotab  Action
    Element Should Contain  css=div#log_instructions_jsontotab  état
    
    #On vérifie que d'autres éléments n'apparaissent pas: 
    Page Should Not Contain Element  css=fieldset#liste_contrainte
    Page Should Not Contain Element  css=fieldset#fieldset-form-dossier_instruction-dossier-d_instruction
    Page Should Not Contain Element  css=fieldset#fieldset-form-dossier_instruction-suivi
    Page Should Not Contain Element  css=fieldset#fieldset-form-dossier_instruction-decision
    Page Should Not Contain Element  css=fieldset#fieldset-form-dossier_instruction-validite-de-l_autorisation
    Page Should Not Contain Element  css=fieldset#fieldset-form-dossier_instruction-localisation
    Page Should Not Contain Element  css=fieldset#fieldset_contraintes_liees
    Page Should Not Contain Element  css=fieldset#fieldset-form-dossier_instruction-demandeur

Vérification des tris par défaut pour les listings Mes encours et Tous les encours
    [Documentation]  Ce test vérifie que depuis les menu mes Encours et Tous les Encours
    ...  les dossiers sont triés par date limite croissante.
    # Isolation d'un contexte
    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=NATURALCITY
    ...  departement=013
    ...  commune=088
    ...  insee=13088
    ...  direction_code=T
    ...  direction_libelle=Direction de NATURALCITY
    ...  direction_chef=Chef
    ...  division_code=T
    ...  division_libelle=Division T
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Jung Doo-hong
    ...  guichet_om_utilisateur_email=jdoohong@openads-test.fr
    ...  guichet_om_utilisateur_login=jdoohong
    ...  guichet_om_utilisateur_pwd=jdoohong
    ...  instr_om_utilisateur_nom=Yoo Ji-tae
    ...  instr_om_utilisateur_email=yjitae@openads-test.fr
    ...  instr_om_utilisateur_login=yjitae
    ...  instr_om_utilisateur_pwd=yjitae
    Isolation d'un contexte  ${isolation_values}
    
    # Attribution du rôle d'instructeur polyvalent à l'individu créé durant l'isolation
    Modifier l'utilisateur
    ...  ${isolation_values.instr_om_utilisateur_nom}
    ...  ${isolation_values.instr_om_utilisateur_email}
    ...  ${isolation_values.instr_om_utilisateur_login}
    ...  ${isolation_values.instr_om_utilisateur_pwd}
    ...  INSTRUCTEUR POLYVALENT

    # Création de dossiers dans le profil isolé :
    Depuis la page d'accueil  yjitae  yjitae
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Rivia
    ...  particulier_prenom=Geralt
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}

    # Création de 3 dates à rebours de la date du jour courant
    :FOR    ${i}    IN RANGE    1    4    1
    \   ${date_di_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  ${i} days  result_format=%Y-%m-%d
    \   ${date_di} =  Convert Date  ${date_di_db}  result_format=%d/%m/%Y
    \   &{args_demande} =  Create Dictionary
    \   ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    \   ...  demande_type=Dépôt Initial
    \   ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    \   ...  date_demande=${date_di}
    \   ${libelle_di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Récupération et comparaison des valeurs des dates entre chaque ligne du tableau
    # de l'onglet Mes Encours
    Depuis le listing  dossier_instruction_mes_encours
    :FOR    ${i}    IN RANGE    1    3    1
    \   ${date_1} =  Get Text  css=#tab-dossier_instruction_mes_encours .tab-container table.tab-tab tr:nth-child(${i})>td.col-8>a
    \   ${date_2} =  Get Text  css=#tab-dossier_instruction_mes_encours .tab-container table.tab-tab tr:nth-child(${i+1})>td.col-8>a
    \   Vérifier que la date ${date_1} est inférieure à la date ${date_2}

    # Récupération et comparaison des valeurs des dates entre chaque ligne du tableau
    # de l'onglet Tous les Encours
    Depuis le listing  dossier_instruction_tous_encours
    :FOR    ${i}    IN RANGE    1    3    1
    # Récupération des valeurs des dates
    \   ${date_1} =  Get Text  css=#tab-dossier_instruction_tous_encours .tab-container table.tab-tab tr:nth-child(${i})>td.col-10>a
    \   ${date_2} =  Get Text  css=#tab-dossier_instruction_tous_encours .tab-container table.tab-tab tr:nth-child(${i+1})>td.col-10>a
    \   Vérifier que la date ${date_1} est inférieure à la date ${date_2}


Vérification de la date limite d'incomplétude dans les tris
    [Documentation]  Ce test vérifie que lorsque la date limite d'incomplétude
    ...  remplace la date limite dans les listings :
    ...  Mes Encours, Tous les Encours et recherche,
    ...  les tris et recherches en tiennent compte.  

    Depuis la page d'accueil  admin  admin

    Constitution du Workflow de gestion d'une incomplétude  195

    # Isolation d'un contexte
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=TRI_COMPLETUDE_CITY
    ...  departement=013
    ...  commune=089
    ...  insee=13089
    ...  direction_code=TRI
    ...  direction_libelle=Direction de TRI_COMPLETUDE_CITY
    ...  direction_chef=Chef
    ...  division_code=TRI
    ...  division_libelle=Division TRI
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Jean-Ben Tri-Tri
    ...  guichet_om_utilisateur_email=jeanben@openads-test.fr
    ...  guichet_om_utilisateur_login=jeanben
    ...  guichet_om_utilisateur_pwd=jeanben
    ...  instr_om_utilisateur_nom=Guy Guytri
    ...  instr_om_utilisateur_email=guytri@openads-test.fr
    ...  instr_om_utilisateur_login=guytri
    ...  instr_om_utilisateur_pwd=guytri
    Isolation d'un contexte  ${isolation_values}
    
    # Attribution du rôle d'instructeur polyvalent à l'individu créé durant l'isolation
    Modifier l'utilisateur
    ...  ${isolation_values.instr_om_utilisateur_nom}
    ...  ${isolation_values.instr_om_utilisateur_email}
    ...  ${isolation_values.instr_om_utilisateur_login}
    ...  ${isolation_values.instr_om_utilisateur_pwd}
    ...  INSTRUCTEUR POLYVALENT

    # Création de dossiers dans le profil isolé :
    Depuis la page d'accueil  guytri  guytri
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Tri
    ...  particulier_prenom=Herald
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    
    # Extrait les 2 derniers caractères pour savoir si le jour traité est un 28, 29, 30, 31 ou un 01
    ${month_day}    Get Substring    ${DATE_FORMAT_YYYY-MM-DD}    -2    
    ${date_minus_5} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  5 days  result_format=%Y-%m-%d

    ${starting_day} =    Set Variable   ${DATE_FORMAT_YYYY-MM-DD}
    
    # Au cas où la date du jour du test soit un 28, 29, 30, 31 ou un 01, 
    # elle est ramenée à 5 jours avant afin d'éviter le cas de figure suivant,
    # qui rend impossible la distinction de dates consécutives dont la modification tombe sur le même jour :
    # 31/01/XX + 2 mois => 28/02 et
    # 30/01/XX + 2 mois => 28/02
    ${starting_day} =  Run Keyword If  '${month_day}' == '28'  Set Variable   ${date_minus_5}
    ...    ELSE IF  '${month_day}' == '29'  Set Variable   ${date_minus_5}
    ...    ELSE IF  '${month_day}' == '30'  Set Variable   ${date_minus_5}
    ...    ELSE IF  '${month_day}' == '31'  Set Variable   ${date_minus_5}
    ...    ELSE IF  '${month_day}' == '01'  Set Variable   ${date_minus_5}
    ...    ELSE                             Set Variable   ${DATE_FORMAT_YYYY-MM-DD}

    # Création de 3 dates à rebours de la date du jour courant
    :FOR    ${i}    IN RANGE    1    4    1
    \   ${date_di_db} =  Subtract Time From Date  ${starting_day}  ${i} days  result_format=%Y-%m-%d
    \   ${date_di} =  Convert Date  ${date_di_db}  result_format=%d/%m/%Y
    \   &{args_demande} =  Create Dictionary
    \   ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    \   ...  demande_type=Dépôt Initial
    \   ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    \   ...  date_demande=${date_di}
    \   ${libelle_di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'une nouvelle date limite d'incomplétude sur un dossier
    Ajouter une instruction au DI et la finaliser  PC 013089 23 00003P0  incompletude_195  
    
    ${date_retour_signature} =  Add Time To Date  ${starting_day}  20 days  result_format=%Y-%m-%d
    ${date_retour_signature} =  Convert Date  ${date_retour_signature}  result_format=%d/%m/%Y
    log  ${date_retour_signature}
    &{args_instruction} =  Create Dictionary
    ...  date_retour_signature=${date_retour_signature}
    Modifier le suivi des dates  PC 013089 23 00003P0  incompletude_195  ${args_instruction}

    # Vérification du bon fonctionnement du tri date limite dans mes encours, tous mes encours
    # lorsqu'on à une incomplétude :

    # - Mes encours
    Depuis le listing  dossier_instruction_mes_encours
    Wait Until Element Contains  css=table.tab-tab tr:first-child td.col-3 a  PC 013089 23 00002P0
    # L'incomplétude est censée être en dernier dans le listing
    Element Should Contain  css=table.tab-tab tr:nth-child(3) td.col-3 a  PC 013089 23 00003P0

    # On clique sur "date limite" du listing  mes encours pour changer l'ordre d'affichage du listing
    # On clique 2 fois, car le 1er clique n'est pas pris en compte
    Click Element  css=table.tab-tab tr:nth-child(1) th.col-10
    Click Element  css=table.tab-tab tr:nth-child(1) th.col-10

    # L'incomplétude est censée être en premier maintenant dans le listing
    Wait Until Element Contains  css=table.tab-tab tr:nth-child(1) td.col-3 a  PC 013089 23 00003P0
    Element Should Contain  css=table.tab-tab tr:nth-child(3) td.col-3 a  PC 013089 23 00002P0

    # - Tous les encours
    Depuis le listing  dossier_instruction_tous_encours
    Wait Until Element Contains  css=table.tab-tab tr:nth-child(1) td.col-3 a  PC 013089 23 00002P0
    # L'incomplétude est censée être en dernier dans le listing
    Element Should Contain  css=table.tab-tab tr:nth-child(3) td.col-3 a  PC 013089 23 00003P0

    # On clique sur "date limite" du listing  mes encours pour changer l'ordre d'affichage du listing
    # On clique 2 fois, car le 1er clique n'est pas pris en compte
    Click Element  css=table.tab-tab tr:nth-child(1) th.col-10
    Click Element  css=table.tab-tab tr:nth-child(1) th.col-10

    # L'incomplétude est censée être en premier maintenant dans le listing
    Wait Until Element Contains  css=table.tab-tab tr:nth-child(1) td.col-3 a  PC 013089 23 00003P0
    Element Should Contain  css=table.tab-tab tr:nth-child(3) td.col-3 a  PC 013089 23 00002P0


Vérification de l'identification des dossiers par couleurs
    [Documentation]  Ce test vérifie qu'après avoir ajouté l'option
    ...  option_afficher_couleur_dossier dans Administration -> Paramètre,
    ...  puis ajouté une couleur pour un type de DA détaillé, ce type de DA
    ...  soit souligné par cette couleur dans les listings

    # Création d'un da auquel appliquer la couleur
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035COULEURDOSSIER
    ...  particulier_prenom=TEST035
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Fonds de commerce
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout de l'option d'affichage des couleurs de dossier
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_couleur_dossier
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Ajout d'une couleur pour un certain type de dossier (ici FC)
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  couleur=45FFF3

    ${type_da}=  Set Variable  FC
    Modifier type de dossier d'autorisation détaillé  ${type_da}  ${args_type_DA_detaille_modification}

    # Recherche afin d'afficher uniquement le da de test
    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di}
    Click On Search Button

    # Vérifie la présence d'une couleur dans la class CSS correspondant à l'élément modifié
    Page should contain element  css=p[style^="--datd-color:#${args_type_DA_detaille_modification.couleur};"] span[id="${di}"]

    # Retrait de l'option d'affichage des couleurs de dossier
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_couleur_dossier
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}


TNR ajout DI ayant un type dont le code a plus de 10 caractères
    [Documentation]  Ce test vérifie qu'après avoir modifié
    ...  un type de DI avec un code compris entre 10 et 20 caractères
    ...  lors de l'ajout d'un DI de ce type, il ne doit y avoir de message d'erreur.

    Depuis la page d'accueil  admin  admin

    # Vérification de l'absence de l'option 'option_dossier_commune'
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}

    # Introduction d'un code compris entre 10 et 20 caractères
    &{val_dit} =  Create Dictionary
    ...  code=P123456789112345
    Modifier type de dossier d'instruction  CU  P  ${val_dit}

    # Création du dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TESTAJOUTDI10CHARNOM
    ...  particulier_prenom=TESTAJOUTDI10CHARPRENOM
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la nouvelle demande depuis le menu  ${args_demande}  ${args_petitionnaire}

    # Retrait du code compris entre 10 et 20 caractères pour la suite des tests
    &{val_dit} =  Create Dictionary
    ...  code=P
    Modifier type de dossier d'instruction  CU  P123456789112345  ${val_dit}
