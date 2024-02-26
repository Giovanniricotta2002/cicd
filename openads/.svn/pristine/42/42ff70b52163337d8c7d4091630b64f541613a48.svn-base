*** Settings ***
Documentation  Les widgets.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Création du jeu de données

    [Documentation]  Constitue le jeu de données.

    Depuis la page d'accueil  admin  admin
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Reault
    ...  particulier_prenom=Julienne
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  demande_type=Dépôt Initial REC
    ...  autorisation_contestee=PC 013055 12 00001P0
    ...  om_collectivite=MARSEILLE
    ${args_peti} =  Create Dictionary

    ${di_rec} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Ayot
    ...  particulier_prenom=Alain
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  demande_type=Dépôt Initial REC
    ...  autorisation_contestee=PC 013055 12 00001P0
    ...  om_collectivite=MARSEILLE
    ${di_rec_2} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Boncoeur
    ...  particulier_prenom=Amélie
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours gracieux
    ...  demande_type=Dépôt Initial REG
    ...  autorisation_contestee=PC 013055 12 00001P0
    ...  om_collectivite=MARSEILLE

    ${di_reg} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    #
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Ferland
    ...  particulier_prenom=Honoré
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Routhier
    ...  particulier_prenom=Vick
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE

    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    #
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Chnadonnet
    ...  particulier_prenom=Gaston
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Audet
    ...  particulier_prenom=Saber
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE

    ${di_inf_2} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    Set Suite Variable  ${di_rec}
    Set Suite Variable  ${di_rec_2}
    Set Suite Variable  ${di_reg}
    Set Suite Variable  ${di_inf}
    Set Suite Variable  ${di_inf_2}

Widget "Dossiers Limites"

    [Documentation]    L'objet de ce 'Test Case' est de vérifier le
    ...    fonctionnement du widget 'Dossiers Limites'
    ...    (widget_dossiers_limites)

    #
    # Cas d'utilisation n°1
    # Un paramètre permet de filtrer les dossiers qui apparaissent soit par :
    # - instructeur
    # - division
    # - aucun
    #
    ${om_widget_libelle} =  Set Variable  dossiers_limites

    # Ajout d'un instructeur secondaire à affecter aux dossiers
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire_dl
    # Isole le contexte du test (création d'une collectivité, 2 divisions et 3 instructeurs)
    Depuis la page d'accueil  admin  admin
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_045_DS
    ...  departement=001
    ...  commune=001
    ...  insee=01001
    ...  direction_code=B
    ...  direction_libelle=Direction B de LIBRECOM_045_DS
    ...  direction_chef=Chef
    ...  division_code=B
    ...  division_libelle=Division B
    ...  division_chef=Chef
    ...  instr_om_utilisateur_nom=Phillipa Durand
    ...  instr_om_utilisateur_email=pdurand@openads-test.fr
    ...  instr_om_utilisateur_login=pdurand
    ...  instr_om_utilisateur_pwd=pdurand
    ...  instr_2_om_utilisateur_nom=${instructeur_secondaire_login}
    ...  instr_2_om_utilisateur_email=${instructeur_secondaire_login}@openads-test.fr
    ...  instr_2_om_utilisateur_login=${instructeur_secondaire_login}
    ...  instr_2_om_utilisateur_pwd=${instructeur_secondaire_login}
    Isolation d'un contexte  ${librecom_values}
    # Ajouter la direction depuis le menu  K  Direction K de LIBRECOM_045_DS  null  Chef  null  null  ${librecom_values.om_collectivite_libelle}
    # Ajouter la division depuis le menu  K  Division K  null  Chef  null  null  Direction K de LIBRECOM_045_DS
    Ajouter l'utilisateur depuis le menu  Simone Girard  sgirard@openads-test.fr  sgirard  sgirard  INSTRUCTEUR  ${librecom_values.om_collectivite_libelle}
    Ajouter l'instructeur depuis le menu  Simone Girard  Division B  instructeur  Simone Girard
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Simone Girard (B)
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    Ajouter l'affectation depuis le menu  ${args_affectation}
    Ajouter la direction depuis le menu  M  Direction M de LIBRECOM_045_DS  null  Chef  null  null  ${librecom_values.om_collectivite_libelle}
    Ajouter la division depuis le menu  M  Division M  null  Chef  null  null  Direction M de LIBRECOM_045_DS
    Ajouter l'utilisateur depuis le menu  Louis Laprise  llaprise@openads-test.fr  llaprise  llaprise  INSTRUCTEUR  ${librecom_values.om_collectivite_libelle}
    Ajouter l'instructeur depuis le menu  Louis Laprise  Division M  instructeur  Louis Laprise
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Louis Laprise (M)
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  dossier_autorisation_type_detaille=Permis de démolir
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # En se basant sur le fait que les 3 types de dossiers ont un délai d'instruction à 2 mois
    ${date_di_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  50 days  result_format=%Y-%m-%d
    ${date_di} =  Convert Date  ${date_di_db}  result_format=%d/%m/%Y
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=PETIPRINC_NOM_01_045_DS
    ...  particulier_prenom=PETIPRINC_PRENOM_01_045_DS
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  date_demande=${date_di}
    ${di_instr_1_division_1_commune_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=PETIPRINC_NOM_02_045_DS
    ...  particulier_prenom=PETIPRINC_PRENOM_02_045_DS
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  date_demande=${date_di}
    ${di_instr_2_division_1_commune_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=PETIPRINC_NOM_03_045_DS
    ...  particulier_prenom=PETIPRINC_PRENOM_03_045_DS
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  date_demande=${date_di}
    ${di_instr_3_division_2_commune_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Filtre sur l'instructeur
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur
    ...  ${om_widget_libelle}
    #
    Depuis la page d'accueil  pdurand  pdurand
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_instr_3_division_2_commune_1}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_instr_3_division_2_commune_1}

    # Filtre sur la division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=division
    ...  ${om_widget_libelle}
    #
    Depuis la page d'accueil  pdurand  pdurand
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_instr_3_division_2_commune_1}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_instr_3_division_2_commune_1}

    # Filtre sur l'instructeur secondaire
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur_secondaire
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_instr_3_division_2_commune_1}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_instr_3_division_2_commune_1}
    # L'instructeur du dossier ne dois pas avoir de résultat
    Depuis la page d'accueil  pdurand  pdurand
    Element Should Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.

    #
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=aucun
    ...  ${om_widget_libelle}
    #
    Depuis la page d'accueil  pdurand  pdurand
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_3_division_2_commune_1}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_3_division_2_commune_1}

    #
    # Cas d'utilisation n°2
    # Un paramètre permet de filtrer sur les types de dossiers qui apparaissent
    #

    ${di_type_dp} =  Set Variable  ${di_instr_2_division_1_commune_1}
    ${di_type_pc} =  Set Variable  ${di_instr_1_division_1_commune_1}

    #
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  codes_datd=PCI;PCA;PC\nfiltre=aucun
    ...  ${om_widget_libelle}
    #
    Depuis la page d'accueil  pdurand  pdurand
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_type_pc}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_type_dp}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_type_pc}
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_type_dp}

    #
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  codes_datd=DP;DPS\nfiltre=aucun
    ...  ${om_widget_libelle}
    #
    Depuis la page d'accueil  pdurand  pdurand
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_type_dp}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_type_pc}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_type_dp}
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_type_pc}

    #
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  codes_datd=ZZ\nfiltre=aucun
    ...  ${om_widget_libelle}
    #
    Depuis la page d'accueil  pdurand  pdurand
    Element Should Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_type_dp}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_type_pc}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Voir +

    #
    # Cas d'utilisation n°3
    # Vérifier le paramètre nombre de jours
    #

    #
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  nombre_de_jours=7\nfiltre=aucun
    ...  ${om_widget_libelle}

    # En se basant sur le fait que les 3 types de dossiers ont un délai d'instruction à 2 mois
    ${date_di_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  55 days  result_format=%Y-%m-%d
    ${date_di} =  Convert Date  ${date_di_db}  result_format=%d/%m/%Y
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=PETIPRINC_NOM_04_045_DS
    ...  particulier_prenom=PETIPRINC_PRENOM_04_045_DS
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  date_demande=${date_di}
    ${di2_instr_1_division_1_commune_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #
    Depuis la page d'accueil  pdurand  pdurand
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_instr_3_division_2_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di2_instr_1_division_1_commune_1}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_instr_3_division_2_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di2_instr_1_division_1_commune_1}

    #
    # Cas d'utilisation n°4
    # Vérifie l'affichage d'un dossier d'instruction icomplet
    # Le délai d'incomplétude est géré par un autre champ que celui pour la date limite complet
    #

    ${di_limite} =  Set Variable  ${di_instr_1_division_1_commune_1}
    # ${di_limite_incomplet} =  Set Variable  AT 013055 13 00001P0

    # Filtre sur la division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=division
    ...  ${om_widget_libelle}

    Ajouter l'utilisateur depuis le menu  Arthur Heureux  aheureux@openads-test.fr  aheureux  aheureux  DIVISIONNAIRE  ${librecom_values.om_collectivite_libelle}
    Ajouter l'instructeur depuis le menu  Arthur Heureux  Division B  instructeur  Arthur Heureux

    # En se basant sur le fait que les 3 types de dossiers ont un délai d'instruction à 2 mois
    ${date_di_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  100 days  result_format=%Y-%m-%d
    ${date_di} =  Convert Date  ${date_di_db}  result_format=%d/%m/%Y
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=PETIPRINC_NOM_05_045_DS
    ...  particulier_prenom=PETIPRINC_PRENOM_05_045_DS
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  date_demande=${date_di}
    ${di3_instr_1_division_1_commune_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_limite_incomplet} =  Set Variable  ${di3_instr_1_division_1_commune_1}
    Constitution du Workflow de gestion d'une incomplétude  045
    ${date_incomplet_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  80 days  result_format=%Y-%m-%d
    ${date_incomplet} =  Convert Date  ${date_incomplet_db}  result_format=%d/%m/%Y
    Ajouter une instruction au DI et la finaliser  ${di3_instr_1_division_1_commune_1}  ${incompletude_libelle}  false  ${date_incomplet}
    Depuis l'instruction du dossier d'instruction  ${di3_instr_1_division_1_commune_1}  ${incompletude_libelle}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_incomplet}
    Click On Submit Button In Subform

    #
    Depuis la page d'accueil  aheureux  aheureux
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_${om_widget_libelle}  ${di_limite}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_${om_widget_libelle}  ${di_limite_incomplet}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_limite}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_limite_incomplet}

    #
    # Cas d'utilisation n°5
    # Restreindre le resultat aux dossiers d'instruction dont le caractère
    # tacite est actif
    #

    # Filtre sur la division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  restreindre_aux_tacites=true\nfiltre=division
    ...  ${om_widget_libelle}
    # Ajout de l'action et de l'événement pour suspendre le tacite automatique
    &{args_action} =  Create Dictionary
    ...  action=susp_tacite_auto
    ...  libelle=Suspendre le tacite automatique
    ...  regle_accord_tacite=accord_tacite
    Ajouter l'action depuis le menu  ${args_action}
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=Suspendre le tacite automatique
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=Suspendre le tacite automatique
    ...  accord_tacite=Non
    Ajouter l'événement depuis le menu  ${args_evenement}

    #
    Depuis la page d'accueil  aheureux  aheureux
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di2_instr_1_division_1_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di3_instr_1_division_1_commune_1}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di2_instr_1_division_1_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di3_instr_1_division_1_commune_1}

    # Suspend le tacite automatique d'un dossiers
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI  ${di_instr_1_division_1_commune_1}  Suspendre le tacite automatique

    # Le dossier ne doit plus apparaitre dans les dossiers limites
    Depuis la page d'accueil  aheureux  aheureux
    Element Should Not Contain  css=.widget_${om_widget_libelle}  Vous n'avez pas de dossiers limites pour le moment.
    Element Should Not Contain  css=.widget_${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di2_instr_1_division_1_commune_1}
    Element Should Contain  css=.widget_${om_widget_libelle}  ${di3_instr_1_division_1_commune_1}
    Click Element  css=.widget_${om_widget_libelle} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Limites
    Element Should Not Contain  css=#tab-${om_widget_libelle}  ${di_instr_1_division_1_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di_instr_2_division_1_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di2_instr_1_division_1_commune_1}
    Element Should Contain  css=#tab-${om_widget_libelle}  ${di3_instr_1_division_1_commune_1}

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  restreindre_aux_tacites=true\nfiltre=division\naffichage=nombre
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  aheureux  aheureux
    Element Should Contain  css=.widget_${om_widget_libelle} span.bg-info  3

    # Désactive la restriction aux dossiers d'instruction tacites sur le widget
    # des dossiers limites
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  ${EMPTY}
    ...  ${om_widget_libelle}


Widget "Infos Profil"
    [Documentation]  Ce widget affiche des informations sur l'utilisateur connecté.

    # En tant qu'utilisateur profil QUALIFICATEUR
    Depuis la page d'accueil  qualif  qualif
    # On vérifie que le profil affiché est le bon
    Element Should Contain  css=.profil-infos-profil span.value  QUALIFICATEUR
    # On vérifie que le nom de l'utilisateur est le bon
    Element Should Contain  css=.profil-infos-nom span.value  Qualificateur
    Page Should Not Contain Element  css=.profil-infos-instructeur_qualite span.value
    Element Should Contain  css=.widget_infos_profil .tab-tab  urbanisme
    Element Should Contain  css=.widget_infos_profil .tab-tab  Oui

    # En tant qu'utilisateur profil INSTRUCTEUR
    # On vérifie pour trois utilisateurs différents pour être sûr
    # que l'information de division est correcte
    # instr -> Division H
    Depuis la page d'accueil  instr  instr
    # On vérifie que le profil affiché est le bon
    Element Should Contain  css=.profil-infos-profil span.value  INSTRUCTEUR
    # On vérifie que le nom de l'utilisateur est le bon
    Element Should Contain  css=.profil-infos-nom span.value  Louis Laurent
    # On vérifie que le code de la division est le bon
    # instr1 -> Division H
    Element Should Contain  css=.profil-infos-division span.value  H
    Element Should Contain  css=.profil-infos-instructeur_qualite span.value  instructeur

    Depuis la page d'accueil  instr1  instr
    # On vérifie que le profil affiché est le bon
    Element Should Contain  css=.profil-infos-profil span.value  INSTRUCTEUR
    # On vérifie que le nom de l'utilisateur est le bon
    Element Should Contain  css=.profil-infos-nom span.value  Martine Nadeau
    # On vérifie que le code de la division est le bon
    Element Should Contain  css=.profil-infos-division span.value  H
    # instr2 -> Division J
    Depuis la page d'accueil  instr2  instr
    # On vérifie que le profil affiché est le bon
    Element Should Contain  css=.profil-infos-profil span.value  INSTRUCTEUR
    # On vérifie que le nom de l'utilisateur est le bon
    Element Should Contain  css=.profil-infos-nom span.value  Roland Richard
    # On vérifie que le code de la division est le bon
    Element Should Contain  css=.profil-infos-division span.value  J

    # Pour un utilisateur lié au groupe contentieux
    Depuis la page d'accueil  juriste  juriste
    # On vérifie que le nom de l'utilisateur est le bon
    Element Should Contain  css=.profil-infos-profil span.value  JURISTE
    Element Should Contain  css=.profil-infos-nom span.value  Juriste
    Element Should Contain  css=.profil-infos-instructeur_qualite span.value  juriste
    Element Should Contain  css=.widget_infos_profil .tab-tab  urbanisme
    Element Should Contain  css=.widget_infos_profil .tab-tab  Contentieux
    Element Should Contain  css=.widget_infos_profil .tab-tab  Oui
    Element Should Contain  css=.widget_infos_profil .tab-tab  Non


Widget "Redirection"
    [Documentation]  Ce widget redirige l'utilisateur vers les listing des
    ...  demandes d'avis en cours.

    # On se connecte avec l'utilisateur consu
    Depuis la page d'accueil  consu  consu
    # On vérifie que l'utilisateur est bien redirigé vers le listing souhaité
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Title Should Be  Demandes D'avis > En Cours


Widget "Recherche Dossier"

    [Documentation]    L'objet de ce 'Test Case' est de vérifier le
    ...    fonctionnement du widget 'Recherche Dossier'
    ...    (widget_recherche_dossier)

    Depuis la page d'accueil  admin  admin
    &{isolation_values_01} =  Create Dictionary
    ...  om_collectivite_libelle=JIYUCITY045WRD01
    ...  departement=066
    ...  commune=088
    ...  insee=66088
    ...  direction_code=O
    ...  direction_libelle=Direction de JIYUCITY045WRD01
    ...  direction_chef=Chef
    ...  division_code=O
    ...  division_libelle=Division O
    ...  division_chef=Chef
    ...  instr_om_utilisateur_nom=Alexandria Le Menard
    ...  instr_om_utilisateur_email=alemenard@openads-test.fr
    ...  instr_om_utilisateur_login=alemenard
    ...  instr_om_utilisateur_pwd=alemenard
    Isolation d'un contexte  ${isolation_values_01}
    &{isolation_values_02} =  Create Dictionary
    ...  om_collectivite_libelle=JIYUCITY045WRD02
    ...  departement=066
    ...  commune=089
    ...  insee=66089
    ...  direction_code=P
    ...  direction_libelle=Direction de JIYUCITY045WRD02
    ...  direction_chef=Chef
    ...  division_code=P
    ...  division_libelle=Division P
    ...  division_chef=Chef
    ...  instr_om_utilisateur_nom=Daniel LeGrand
    ...  instr_om_utilisateur_email=dlegrand@openads-test.fr
    ...  instr_om_utilisateur_login=dlegrand
    ...  instr_om_utilisateur_pwd=dlegrand
    Isolation d'un contexte  ${isolation_values_02}

    # Dossier pour vérifier les différents cas
    &{args_petitionnaire_di} =  Create Dictionary
    ...  particulier_nom=LABONTÉ
    ...  particulier_prenom=WILLIAM
    ...  om_collectivite=${isolation_values_01.om_collectivite_libelle}
    &{args_demande_di} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values_01.om_collectivite_libelle}
    ${di} =  Ajouter la demande par WS  ${args_demande_di}  ${args_petitionnaire_di}
    ${di_ns} =  Sans espace  ${di}
    &{args_petitionnaire_di_a} =  Create Dictionary
    ...  particulier_nom=DUPÉRÉ
    ...  particulier_prenom=ZURIE
    ...  om_collectivite=${isolation_values_02.om_collectivite_libelle}
    &{args_demande_di_a} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values_02.om_collectivite_libelle}
    ${di_allauch} =  Ajouter la demande par WS  ${args_demande_di_a}  ${args_petitionnaire_di_a}
    &{args_petitionnaire_di_b} =  Create Dictionary
    ...  particulier_nom=MARTEL
    ...  particulier_prenom=LAURENT
    ...  om_collectivite=${isolation_values_01.om_collectivite_libelle}
    &{args_demande_di_b} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values_01.om_collectivite_libelle}
    ${di_b} =  Ajouter la demande par WS  ${args_demande_di_b}  ${args_petitionnaire_di_b}

    # En tant qu'instructeur
    Depuis la page d'accueil  alemenard  alemenard

    #
    # Cas d'utilisation n°1
    #
    # Saisie d'un numéro de dossier complet (avec et sans espaces)
    #
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier input#dossier    ${di}
    Click Element    css=#dashboard div.widget_recherche_dossier div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction > ${di} ${args_petitionnaire_di.particulier_nom} ${args_petitionnaire_di.particulier_prenom}
    La page ne doit pas contenir d'erreur
    #
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier input#dossier    ${di_ns}
    Click Element    css=#dashboard div.widget_recherche_dossier div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction > ${di} ${args_petitionnaire_di.particulier_nom} ${args_petitionnaire_di.particulier_prenom}
    La page ne doit pas contenir d'erreur

    #
    # Cas d'utilisation n°2
    #
    # Saisie d'une portion d'un numéro de dossier
    #
    # Cas 2a : un seul dossier
    Go to dashboard
    ${search_2a_1} =  Get Substring  ${di_ns}  0  2
    ${search_2a_2} =  Get Substring  ${di_ns}  6  9
    ${search_2a_3} =  Get Substring  ${di_ns}  14  16
    ${search_2a} =  Catenate  SEPARATOR=*  ${search_2a_1}  ${search_2a_2}  ${search_2a_3}
    Input Text    css=#dashboard div.widget_recherche_dossier input#dossier    ${search_2a}
    Click Element    css=#dashboard div.widget_recherche_dossier div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction > ${di} ${args_petitionnaire_di.particulier_nom} ${args_petitionnaire_di.particulier_prenom}
    La page ne doit pas contenir d'erreur
    # Cas 2b : plusieurs dossiers
    Go to dashboard
    ${search_2b} =  Get Substring  ${di_ns}  2  7
    ${search_2b_adv} =  Catenate  SEPARATOR=  *  ${search_2b}
    Input Text    css=#dashboard div.widget_recherche_dossier input#dossier    ${search_2b}
    Click Element    css=#dashboard div.widget_recherche_dossier div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction
    La page ne doit pas contenir d'erreur
    Textfield Value Should Be    css=#advanced-form input#dossier    ${search_2b_adv}

    #
    # Cas d'utilisation n°3
    #
    # Saisie d'un numéro de dossier inexistant
    #
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier input#dossier    ZZZZZZZZZZZZ
    Click Element    css=#dashboard div.widget_recherche_dossier div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Tableau De Bord
    La page ne doit pas contenir d'erreur
    Element Text Should Be    css=#dashboard div.widget_recherche_dossier div.message.ui-state-error p span.text    Aucun dossier trouvé.

    #
    # Cas d'utilisation n°4
    #
    # Aucune valeur saisie
    #
    Go to dashboard
    Click Element    css=#dashboard div.widget_recherche_dossier div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Tableau De Bord
    La page ne doit pas contenir d'erreur
    Element Text Should Be    css=#dashboard div.widget_recherche_dossier div.message.ui-state-error p span.text    Veuillez saisir un No de dossier.

    #
    # TNR Bug "Erreur de base de données" lors de saisie de caractères spéciaux
    #
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier input#dossier    ;"?#'
    Click Element    css=#dashboard div.widget_recherche_dossier div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction
    La page ne doit pas contenir d'erreur
    Textfield Value Should Be    css=#advanced-form input#dossier    *,

    #
    # Les DI contentieux ne doivent pas accessibles
    #
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier input#dossier    ${di_rec}
    Click Element    css=#dashboard div.widget_recherche_dossier div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Tableau De Bord
    La page ne doit pas contenir d'erreur
    Element Text Should Be    css=#dashboard div.widget_recherche_dossier div.message.ui-state-error p span.text    Aucun dossier trouvé.

    # L'utilisateur étant mono, le DI d'une autre collectivité ne doit pas être trouvé
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier input#dossier    ${di_allauch}
    Click Element    css=#dashboard div.widget_recherche_dossier div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}      Element Text Should Be    css=#dashboard div.widget_recherche_dossier div.message.ui-state-error p span.text    Aucun dossier trouvé.
    La page ne doit pas contenir d'erreur


Widget "Recherche Dossier par type"

    [Documentation]  L'objet de ce 'Test Case' est de vérifier le
    ...  fonctionnement du widget 'Recherche Dossier par type'
    ...  (widget_recherche_dossier_par_type)
    ...
    ...  Vérification des points suivants :
    ...  - un utilisateur mono ne doit pas pouvoir rechercher un DI d'une autre collectivité
    ...  - la recherche fonctionne avec des numéros de dossier avec et sans espaces
    ...  - selon le type de dossier, on est redirigés au bon endroit

    #
    &{args_petitionnaire_di} =  Create Dictionary
    ...  particulier_nom=PETIT
    ...  particulier_prenom=SEBASTIEN
    ...  om_collectivite=MARSEILLE
    &{args_demande_di} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=01/01/1999
    ${di} =  Ajouter la demande par WS  ${args_demande_di}  ${args_petitionnaire_di}
    ${di_ns} =  Sans espace  ${di}
    &{args_petitionnaire_di_a} =  Create Dictionary
    ...  particulier_nom=PETRIE
    ...  particulier_prenom=CHRISTELLE
    ...  om_collectivite=ALLAUCH
    &{args_demande_di_a} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=ALLAUCH
    ...  date_demande=01/01/1999
    ${di_allauch} =  Ajouter la demande par WS  ${args_demande_di_a}  ${args_petitionnaire_di_a}

    Depuis la page d'accueil  assist  assist

    # Aucune valeur saisie
    Go to dashboard
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Selected List Label Should Be  css=select#type_dossier_recherche  ADS
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Tableau De Bord
    La page ne doit pas contenir d'erreur
    Element Text Should Be    css=#dashboard div.widget_recherche_dossier_par_type div.message.ui-state-error p span.text    Veuillez saisir un No de dossier.

    # Saisie d'un numéro de dossier inexistant
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ZZZZZZZZZZZZ
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Tableau De Bord
    La page ne doit pas contenir d'erreur
    Element Text Should Be    css=#dashboard div.widget_recherche_dossier_par_type div.message.ui-state-error p span.text    Aucun dossier trouvé.

    # Contrôle de la saisie de caractères spéciaux
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ;"?#'';'
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction
    La page ne doit pas contenir d'erreur
    Textfield Value Should Be    css=#advanced-form input#dossier    *,

    # L'utilisateur étant mono, le DI d'une autre collectivité ne doit pas être trouvé
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ${di_allauch}
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}      Element Text Should Be    css=#dashboard div.widget_recherche_dossier_par_type div.message.ui-state-error p span.text    Aucun dossier trouvé.
    La page ne doit pas contenir d'erreur

    # Recherche de dossiers ADS existants avec et sans espaces dans le numéro
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ${di}
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction > ${di} ${args_petitionnaire_di.particulier_nom} ${args_petitionnaire_di.particulier_prenom}
    La page ne doit pas contenir d'erreur

    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ${di_ns}
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction > ${di} ${args_petitionnaire_di.particulier_nom} ${args_petitionnaire_di.particulier_prenom}
    La page ne doit pas contenir d'erreur

    # Saisie d'une portion d'un numéro de dossier, avec un seul dossier en résultat
    Go to dashboard
    ${search_2a_1} =  Get Substring  ${di_ns}  0  2
    ${search_2a_2} =  Get Substring  ${di_ns}  6  9
    ${search_2a_3} =  Get Substring  ${di_ns}  14  16
    ${search_2a} =  Catenate  SEPARATOR=*  ${search_2a_1}  ${search_2a_2}  ${search_2a_3}
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ${search_2a}
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction > ${di} ${args_petitionnaire_di.particulier_nom} ${args_petitionnaire_di.particulier_prenom}
    La page ne doit pas contenir d'erreur

    # Saisie d'une portion d'un numéro de dossier, avec plusieurs dossiers en résultat
    Go to dashboard
    ${search_2b} =  Get Substring  ${di_ns}  2  7
    ${search_2b_adv} =  Catenate  SEPARATOR=  *${search_2b}
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ${search_2b}
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction
    La page ne doit pas contenir d'erreur
    Textfield Value Should Be    css=#advanced-form input#dossier    ${search_2b_adv}

    # Passage de l'utilisateur  juriste sur la collectivité agglo pour tester le filtre sur
    # la collectivité
    Depuis la page d'accueil  admin  admin
    Modifier l'utilisateur  juriste  support@atreal.fr  juriste  juriste  JURISTE  agglo

    # Un utilisateur multi doit pouvoir rechercher des dossiers de toutes les collectivités
    Depuis la page d'accueil  juriste  juriste
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ${di_allauch}
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Instruction > Dossiers D'instruction > ${di_allauch} ${args_petitionnaire_di_a.particulier_nom} ${args_petitionnaire_di_a.particulier_prenom}
    La page ne doit pas contenir d'erreur

    # Modification du type de dossier sélectionné par défaut
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du widget  recherche_dossier_par_type
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments    type_defaut=RE*
    Click On Submit Button
    Modifier l'utilisateur  juriste  support@atreal.fr  juriste  juriste  JURISTE  MARSEILLE

    Depuis la page d'accueil  juriste  juriste
    # Recherche d'un dossier IN
    Go to dashboard
    Selected List Label Should Be  css=select#type_dossier_recherche  RE*
    Select From List By Label  css=select#type_dossier_recherche  IN
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ${di_inf}
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Contentieux > Infraction > ${di_inf}
    La page ne doit pas contenir d'erreur

    # Recherche de dossiers IN
    Go to dashboard
    Select From List By Label  css=select#type_dossier_recherche  IN
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    IN
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Contentieux > Infractions
    La page ne doit pas contenir d'erreur

    # Recherche d'un dossier RE
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    ${di_rec}
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Contentieux > Recours > ${di_rec}
    La page ne doit pas contenir d'erreur

    # Recherche de dossiers RE
    Go to dashboard
    Input Text    css=#dashboard div.widget_recherche_dossier_par_type input#dossier    RE
    Click Element    css=#dashboard div.widget_recherche_dossier_par_type div.formControls input
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page title should be    Contentieux > Recours
    La page ne doit pas contenir d'erreur


Widget "Dossiers incomplets ou majorés sans date de notification"

    [Documentation]  L'objet de ce 'Test Case' est de vérifier le
    ...    fonctionnement du widget 'Dossiers incomplets ou majorés sans date de notification'
    ...    (dossiers_evenement_incomplet_majoration)

    ##
    ## Constitution du jeu de données
    ##
    ## On crée deux nouvelles collectivités pour être sûr du nombre
    ## de retours de messages à vérifier dans les widgets et tableaux
    ##
    #
    ${collectivite_a} =  Set Variable  DAKAR
    ${collectivite_b} =  Set Variable  SINESALOUM
    #
    ${utilisateur_nom_01} =  Set Variable  Nicole Leduc
    ${utilisateur_login_01} =  Set Variable  nleduc
    ${utilisateur_nom_02} =  Set Variable  Julie Giguère
    ${utilisateur_login_02} =  Set Variable  jguiguere
    ${utilisateur_nom_03} =  Set Variable  Arno Perreault
    ${utilisateur_login_03} =  Set Variable  aperreault
    ${utilisateur_nom_04} =  Set Variable  Albertine Echeverri
    ${utilisateur_login_04} =  Set Variable  aecheverri
    ${utilisateur_secondaire_login} =  Set Variable  instructeur_secondaire_eim
    #
    Depuis la page d'accueil  admin  admin
    #
    Ajouter la collectivité depuis le menu  ${collectivite_a}  mono
    Ajouter la collectivité depuis le menu  ${collectivite_b}  mono
    #
    Ajouter l'utilisateur  ${utilisateur_nom_01}  nospam@openmairie.org  ${utilisateur_login_01}  ${utilisateur_login_01}  INSTRUCTEUR  ${collectivite_a}
    Ajouter l'utilisateur  ${utilisateur_nom_02}  nospam@openmairie.org  ${utilisateur_login_02}  ${utilisateur_login_02}  INSTRUCTEUR  ${collectivite_a}
    Ajouter l'utilisateur  ${utilisateur_nom_03}  nospam@openmairie.org  ${utilisateur_login_03}  ${utilisateur_login_03}  INSTRUCTEUR  ${collectivite_a}
    Ajouter l'utilisateur  ${utilisateur_nom_04}  nospam@openmairie.org  ${utilisateur_login_04}  ${utilisateur_login_04}  INSTRUCTEUR  ${collectivite_b}
    Ajouter l'utilisateur  ${utilisateur_secondaire_login}  nospam@openmairie.org  ${utilisateur_secondaire_login}  ${utilisateur_secondaire_login}  INSTRUCTEUR  ${collectivite_a}
    #
    Ajouter la direction depuis le menu  D  Direction D  null  Chef D  null  null  ${collectivite_a}
    Ajouter la direction depuis le menu  S  Direction S  null  Chef S  null  null  ${collectivite_b}
    #
    Ajouter la division depuis le menu  D  subdivision D  null  Chef D  null  null  Direction D
    Ajouter la division depuis le menu  DD  subdivision DD  null  Chef D  null  null  Direction D
    Ajouter la division depuis le menu  S  subdivision S  null  Chef S  null  null  Direction S
    #
    #
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_01}  subdivision D  instructeur  ${utilisateur_nom_01}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_02}  subdivision DD  instructeur  ${utilisateur_nom_02}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_03}  subdivision D  instructeur  ${utilisateur_nom_03}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_04}  subdivision S  instructeur  ${utilisateur_nom_04}
    Ajouter l'instructeur depuis le menu  ${utilisateur_secondaire_login}  subdivision D  instructeur  ${utilisateur_secondaire_login}
    #
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_01} (D)
    ...  instructeur_2=${utilisateur_secondaire_login} (D)
    ...  om_collectivite=${collectivite_a}
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_02} (DD)
    ...  instructeur_2=${utilisateur_secondaire_login} (D)
    ...  om_collectivite=${collectivite_a}
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_03} (D)
    ...  instructeur_2=${utilisateur_secondaire_login} (D)
    ...  om_collectivite=${collectivite_a}
    ...  dossier_autorisation_type_detaille=Permis de démolir
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_04} (S)
    ...  om_collectivite=${collectivite_b}
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # DI n°1 : Permis de démolir dans Collectivité A (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_03}' (${utilisateur_login_03})
    # => Division 'D'
    #
    &{args_petitionnaire_01} =  Create Dictionary
    ...  particulier_nom=Chandonnet
    ...  particulier_prenom=Leone
    ...  om_collectivite=${collectivite_a}
    #
    &{args_demande_01} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=${collectivite_a}
    #
    ${di_01} =  Ajouter la demande par WS  ${args_demande_01}  ${args_petitionnaire_01}

    # DI n°2 : Permis de construire pour une maison individuelle et / ou ses annexes dans Collectivité A (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_01}' (${utilisateur_login_01})
    # => Division 'D'
    #
    &{args_petitionnaire_02} =  Create Dictionary
    ...  particulier_nom=Joly
    ...  particulier_prenom=Frédérique
    ...  om_collectivite=${collectivite_a}
    #
    &{args_demande_02} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=${collectivite_a}
    #
    ${di_02} =  Ajouter la demande par WS  ${args_demande_02}  ${args_petitionnaire_02}

    # DI n°3 : Permis de construire comprenant ou non des démolitions dans Collectivité A (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_02}' (${utilisateur_login_02})
    # => Division 'DD'
    #
    &{args_petitionnaire_03} =  Create Dictionary
    ...  particulier_nom=Boucher
    ...  particulier_prenom=Bernadette
    ...  om_collectivite=${collectivite_a}
    #
    &{args_demande_03} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=${collectivite_a}
    #
    ${di_03} =  Ajouter la demande par WS  ${args_demande_03}  ${args_petitionnaire_03}

    # DI n°4 : Permis de construire pour une maison individuelle et / ou ses annexes dans Collectivité B (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_04}' (${utilisateur_login_04})
    # => Division 'S'
    #
    &{args_petitionnaire_04} =  Create Dictionary
    ...  particulier_nom=BOULAGE
    ...  particulier_prenom=Damien
    ...  om_collectivite=${collectivite_b}
    #
    &{args_demande_04} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=${collectivite_b}
    #
    ${di_04} =  Ajouter la demande par WS  ${args_demande_04}  ${args_petitionnaire_04}

    # On applique l'événement "majoration + DPC hors SS" à chaque dossier et on met une
    # date d'envoi AR à l'événement pour que les dossiers soient affichés dans le widget
    Ajouter une instruction au DI et la finaliser  ${di_01}  majoration + DPC hors SS  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    Ajouter une instruction au DI et la finaliser  ${di_02}  majoration + DPC hors SS  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    Ajouter une instruction au DI et la finaliser  ${di_03}  majoration + DPC hors SS  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    Ajouter une instruction au DI et la finaliser  ${di_04}  majoration + DPC hors SS  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    #
    # Cas d'utilisation n°1
    # Un paramètre permet de filtrer les dossiers qui apparaissent soit par :
    # - instructeur
    # - division
    # - aucun (collectivite)
    #
    # Vérification du :
    # - fonctionnement des filtres
    # - de la redirection vers le dossier
    # - des dossiers affichés dans le widget ET la liste "voir plus"

    #
    ${widget_id} =  Set Variable  widget_10
    ${libelle_widget} =  Set Variable  dossiers_evenement_incomplet_majoration

    ## Vérification du filtre par défaut (instructeur)
    # On se connecte en tant que "${utilisateur_login_01}" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    Element Should Contain  css=#${widget_id}  ${di_02}
    Element Should Not Contain  css=#${widget_id}  ${di_01}
    Element Should Not Contain  css=#${widget_id}  ${di_03}
    Element Should Not Contain  css=#${widget_id}  ${di_04}
    Click Link  ${di_02}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Title Should Be  Instruction > Dossiers D'instruction > ${di_02} JOLY FRÉDÉRIQUE

    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#${widget_id} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Incomplets Ou Majorés Sans Date De Notification
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_02}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_01}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_03}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_04}
    Click Link  ${di_02}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Title Should Be  Instruction > Dossiers D'instruction > ${di_02} JOLY FRÉDÉRIQUE

    ## Vérification du filtre instructeur
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur
    ...  ${libelle_widget}

    # L'instructeur doit seulement voir son dossier
    Depuis la page d'accueil  ${utilisateur_login_04}  ${utilisateur_login_04}
    Element Should Contain  css=#${widget_id}  ${di_04}
    Element Should Not Contain  css=#${widget_id}  ${di_01}
    Element Should Not Contain  css=#${widget_id}  ${di_02}
    Element Should Not Contain  css=#${widget_id}  ${di_03}

    Click Element  css=#${widget_id} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Incomplets Ou Majorés Sans Date De Notification
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_04}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_01}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_02}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_03}

    # Filtre sur la division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=division
    ...  ${libelle_widget}

    # On doit avoir 2 dossiers de la division
    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    Element Should Contain  css=#${widget_id}  ${di_01}
    Element Should Contain  css=#${widget_id}  ${di_02}
    Element Should Not Contain  css=#${widget_id}  ${di_04}
    Element Should Not Contain  css=#${widget_id}  ${di_03}

    Click Element  css=#${widget_id} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Incomplets Ou Majorés Sans Date De Notification
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_02}
    Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_01}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_04}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_03}

    # Filtre "aucun" donc sur la collectivité
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=aucun
    ...  ${libelle_widget}

    # On doit avoir les 3 dossiers de la collectivité
    Depuis la page d'accueil  ${utilisateur_login_03}  ${utilisateur_login_03}
    Element Should Contain  css=#${widget_id}  ${di_01}
    Element Should Contain  css=#${widget_id}  ${di_02}
    Element Should Contain  css=#${widget_id}  ${di_03}
    Element Should Not Contain  css=#${widget_id}  ${di_04}
    Click Element  css=#${widget_id} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Incomplets Ou Majorés Sans Date De Notification
    Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_01}
    Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_02}
    Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_03}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_04}

    ## Vérification du filtre instructeur_secondaire
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur_secondaire
    ...  ${libelle_widget}
    # On doit avoir les 3 dossiers sur lesquels l'instructeur secondaire est affecté
    Depuis la page d'accueil  ${utilisateur_secondaire_login}  ${utilisateur_secondaire_login}
    Element Should Contain  css=#${widget_id}  ${di_01}
    Element Should Contain  css=#${widget_id}  ${di_02}
    Element Should Contain  css=#${widget_id}  ${di_03}
    Element Should Not Contain  css=#${widget_id}  ${di_04}
    Click Element  css=#${widget_id} .widget-footer a
    Page Title Should Be  Instruction > Dossiers Incomplets Ou Majorés Sans Date De Notification
    Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_01}
    Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_02}
    Element Should Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_03}
    Element Should Not Contain  css=#tab-dossiers_evenement_incomplet_majoration  ${di_04}

    # l'instructeur n'aura aucun résultat
    Depuis la page d'accueil  ${utilisateur_login_03}  ${utilisateur_login_03}
    Element Should Contain
    ...  css=.widget_dossiers_evenement_incomplet_majoration
    ...  Vous n'avez pas de dossiers d'instruction avec un événement d'incomplétude ou de majoration de délai sans date de notification.

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=aucun\naffichage=nombre
    ...  ${libelle_widget}

    Depuis la page d'accueil  ${utilisateur_login_03}  ${utilisateur_login_03}
    Element Should Contain  css=.widget_dossiers_evenement_incomplet_majoration span.bg-info  3

    # Suppression des affectations automatique
    Depuis la page d'accueil  admin  admin
    Supprimer l'affectation depuis le menu  ${utilisateur_nom_01} (D)
    Supprimer l'affectation depuis le menu  ${utilisateur_nom_02} (DD)
    Supprimer l'affectation depuis le menu  ${utilisateur_nom_03} (D)
    Supprimer l'affectation depuis le menu  ${utilisateur_nom_04} (S)

    Depuis le contexte du widget  ${libelle_widget}
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments    ${EMPTY}
    Click On Submit Button


Widget "Alerte parquet"

    [Documentation]  Permet de vérifier le fonctionnement du widget 'Alerte
    ...  parquet'. Ce widget doit afficher les 5 infractions en cours
    ...  d'instruction, les plus anciennes pour lesquelles la date de réception
    ...  est dépassée depuis plus de 9 mois et pour lesquelles la date de
    ...  transmission au parquet est nulle.

    # On ajoute une infraction dont la date de réception est dépassée de 10 mois
    ${date_di_inf_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  300 days  result_format=%Y-%m-%d
    ${date_di_inf_form} =  Convert Date  ${date_di_inf_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Charrette
    ...  particulier_prenom=Ophelia
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Moreau
    ...  particulier_prenom=Marcel
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  date_demande=${date_di_inf_form}
    ...  om_collectivite=MARSEILLE
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    # Ajout d'un widget de test dont l'argument 'dossier_encours' aura la valeur
    # 'false', sur le profil du juriste afin de vérifier l'affichage des
    # infractions clôturées
    Depuis la page d'accueil  admin  admin
    ${om_widget_libelle} =  Set Variable  TEST045WIDGETALERTEPARQUET
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=dossier_contentieux_alerte_parquet
    ...  arguments=dossier_encours=false
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=JURISTE
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    Depuis la page d'accueil  juriste  juriste
    Element Should Contain  css=.widget_dossier_contentieux_alerte_parquet  ${di_inf}

    # On vérifie que l'infraction est affichée dans le widget
    Depuis la page d'accueil  tech  tech
    Element Should Contain  css=.widget_dossier_contentieux_alerte_parquet  ${di_inf}
    # Clôture le dossier est vérifie que l'infraction n'est plus affichée dans
    # le widget
    Ajouter une instruction au DI  ${di_inf}  accepter un dossier sans réserve  null  infraction
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_alerte_parquet  ${di_inf}

    # On vérifie que l'infraction est toujours affichée pour le juriste
    Depuis la page d'accueil  juriste  juriste
    Element Should Contain  css=.widget_dossier_contentieux_alerte_parquet  ${di_inf}

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=dossier_encours=false\naffichage=nombre
    Modifier le widget  ${om_widget_libelle}  ${args_om_widget}

    Depuis la page d'accueil  juriste  juriste
    Element Should Contain  css=.widget_dossier_contentieux_alerte_parquet span.bg-info  1

    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=dossier_encours=false
    Modifier le widget  ${om_widget_libelle}  ${args_om_widget}

    # On supprime l'instruction afin que l'infraction soit toujours en cours
    Depuis la page d'accueil  admin  admin
    Supprimer l'instruction  ${di_inf}  accepter un dossier sans réserve  infraction
    Depuis la page d'accueil  tech  tech
    Element Should Contain  css=.widget_dossier_contentieux_alerte_parquet  ${di_inf}

    # On saisit la date de transmission au parquet
    Depuis la page d'accueil  juriste  juriste
    Ajouter une instruction au DI  ${di_inf}  Transmission au Parquet  null  infraction
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_alerte_parquet  ${di_inf}

    # On vérifie que l'infraction n'est plus affichée dans le widget
    Depuis la page d'accueil  tech  tech
    Element Should Not Contain  css=.widget_dossier_contentieux_alerte_parquet  ${di_inf}

    Depuis la page d'accueil  admin  admin
    Supprimer le tableau de bord depuis l'URL par l'identifiant  ${om_dashboard}
    Supprimer le widget depuis l'URL par l'identifiant  ${om_widget}


Widget "Alerte visite"

    [Documentation]  Permet de vérifier le fonctionnement du widget 'Alerte
    ...  visite'. Ce widget doit afficher les 5 infractions en cours
    ...  d'instruction, les plus anciennes pour lesquelles la date de réception
    ...  est dépassée depuis plus de 3 mois et pour lesquelles la date de
    ...  première visite est nulle.

    # On ajoute une infraction dont la date de réception est dépassée de 4 mois
    ${date_di_inf_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  120 days  result_format=%Y-%m-%d
    ${date_di_inf_form} =  Convert Date  ${date_di_inf_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Raymond
    ...  particulier_prenom=Bertrand
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Bonsaint
    ...  particulier_prenom=Philippe
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  date_demande=${date_di_inf_form}
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    # Ajout d'un widget de test dont l'argument 'dossier_encours' aura la valeur
    # 'false', sur le profil du juriste afin de vérifier l'affichage des
    # infractions clôturées
    Depuis la page d'accueil  admin  admin
    ${om_widget_libelle} =  Set Variable  TEST045WIDGETALERTEVISITE
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=dossier_contentieux_alerte_visite
    ...  arguments=dossier_encours=false
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=JURISTE
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    Depuis la page d'accueil  juriste  juriste
    Element Should Contain  css=.widget_dossier_contentieux_alerte_visite  ${di_inf}

    # On vérifie que l'infraction est affichée dans le widget
    Depuis la page d'accueil  tech  tech
    Element Should Contain  css=.widget_dossier_contentieux_alerte_visite  ${di_inf}
    # Clôture le dossier est vérifie que l'infraction n'est plus affichée dans
    # le widget
    Ajouter une instruction au DI  ${di_inf}  accepter un dossier sans réserve  null  infraction
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_alerte_visite  ${di_inf}

    # On vérifie que l'infraction est toujours affichée pour le juriste
    Depuis la page d'accueil  juriste  juriste
    Element Should Contain  css=.widget_dossier_contentieux_alerte_visite  ${di_inf}

    # On supprime l'instruction afin que l'infraction soit toujours en cours
    Depuis la page d'accueil  admin  admin
    Supprimer l'instruction  ${di_inf}  accepter un dossier sans réserve  infraction
    Depuis la page d'accueil  tech  tech
    Element Should Contain  css=.widget_dossier_contentieux_alerte_visite  ${di_inf}

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=dossier_encours=false\naffichage=nombre
    Modifier le widget  ${om_widget_libelle}  ${args_om_widget}

    Depuis la page d'accueil  juriste  juriste
    Element Should Contain  css=.widget_dossier_contentieux_alerte_visite span.bg-info  2

    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=dossier_encours=false
    Modifier le widget  ${om_widget_libelle}  ${args_om_widget}

    # On saisit la date de transmission au parquet
    Depuis la page d'accueil  juriste  juriste
    Ajouter une instruction au DI  ${di_inf}  Première visite  null  infraction
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_alerte_visite  ${di_inf}

    # On supprime l'instruction pour que l'infraction soit à nouveau en cours
    # On vérifie que l'infraction n'est plus affichée dans le widget
    Depuis la page d'accueil  tech  tech
    Element Should Not Contain  css=.widget_dossier_contentieux_alerte_visite  ${di_inf}

    Depuis la page d'accueil  admin  admin
    Supprimer le tableau de bord depuis l'URL par l'identifiant  ${om_dashboard}
    Supprimer le widget depuis l'URL par l'identifiant  ${om_widget}


Widget "Les infractions non affectées"

    [Documentation]  Permet de vérifier le fonctionnement du widget 'Les
    ...  infractions non affectées'. Ce widget doit afficher les 5 infractions
    ...  en cours les plus anciennes pour lesquelles il n'y a pas de technicien
    ...  affecté.

    # On ajoute une infraction
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Flamand
    ...  particulier_prenom=Benjamin
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Pouliotte
    ...  particulier_prenom=Clementine
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    # On vérifie que l'infraction n'est pas affichée dans le widget
    Depuis la page d'accueil  assist  assist
    Element Should Not Contain  css=.widget_dossier_contentieux_inaffectes  ${di_inf}

    # On supprime l'affectation automatique du technicien sur les infractions
    Depuis la page d'accueil  admin  admin
    Supprimer l'affectation depuis le menu  null  Infraction

    # On ajoute une infraction sans affectation automatique
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Lagueux
    ...  particulier_prenom=Anne
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Hachée
    ...  particulier_prenom=Diane
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${args_peti} =  Create Dictionary
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}

    # On vérifie que l'infraction est affichée dans le widget
    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_inaffectes  ${di_inf}

    # Clôture le dossier et vérifie que l'infraction n'est plus affichée dans
    # le widget
    Ajouter une instruction au DI  ${di_inf}  accepter un dossier sans réserve  null  infraction
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_inaffectes  ${di_inf}

    ## Vérification de l'argument dossier_encours
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun\ndossier_encours=false
    Modifier le widget  dossier_contentieux_inaffectes  ${args_om_widget}

    # On vérifie que l'infraction est de nouveau affichée affichée
    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_inaffectes  ${di_inf}

    # On supprime l'instruction afin que l'infraction soit toujours en cours
    Depuis la page d'accueil  admin  admin
    Supprimer l'instruction  ${di_inf}  accepter un dossier sans réserve  infraction
    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_inaffectes  ${di_inf}

    # On ajoute explicitement l'argument
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun\ndossier_encours=true
    Modifier le widget  dossier_contentieux_inaffectes  ${args_om_widget}
    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_inaffectes  ${di_inf}

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun\ndossier_encours=true\naffichage=nombre
    Modifier le widget  dossier_contentieux_inaffectes  ${args_om_widget}

    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_inaffectes span.bg-info  1

    # On remet en place l'affectation automatique du technicien et le widget
    Depuis la page d'accueil  admin  admin
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Juriste (H)
    ...  instructeur_2=Technicien (H)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun
    Modifier le widget  dossier_contentieux_inaffectes  ${args_om_widget}


Widget "Mes clôtures"

    [Documentation]  Permet de vérifier le fonctionnement du widget 'Mes
    ...  clôtures'. Ce widget doit afficher les 5 recours les plus proches
    ...  pour lesquels une date de clôture d'instruction existe, est comprise
    ...  entre le jour courant et un mois dans le futur et pour lesquels
    ...  l'utilisateur connecté est positionné en juriste.

    # On ajoute une autorisation à contester
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Charlebois
    ...  particulier_prenom=Agate
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_conteste} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On ajoute un recours
    ${date_di_re_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  10 days  result_format=%Y-%m-%d
    ${date_di_re_form} =  Convert Date  ${date_di_re_db}  result_format=%d/%m/%Y
    &{args_requerant} =  Create Dictionary
    ...  particulier_nom=Henrichon
    ...  particulier_prenom=Aurore
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  requerant_principal=${args_requerant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours gracieux
    ...  demande_type=Dépôt Initial REG
    ...  autorisation_contestee=${di_conteste}
    ...  om_collectivite=MARSEILLE
    ${di_re} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    # On vérifie que le recours n'est pas affiché dans le widget
    Depuis la page d'accueil  juriste  juriste
    Element Should Not Contain  css=.widget_dossier_contentieux_clotures  ${di_re}

    # On saisit la date de clôture du recours
    Ajouter une instruction au DI  ${di_re}  Clôture de l'instruction  ${date_di_re_form}  recours

    # On vérifie que le recours est affiché dans le widget
    Go To Dashboard
    Element Should Contain  css=.widget_dossier_contentieux_clotures  ${di_re}

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=affichage=nombre
    Modifier le widget  dossier_contentieux_clotures  ${args_om_widget}

    Depuis la page d'accueil  juriste  juriste
    Element Should Contain  css=.widget_dossier_contentieux_clotures span.bg-info  1

    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=${EMPTY}
    Modifier le widget  dossier_contentieux_clotures  ${args_om_widget}


Widget "Les audiences"

    [Documentation]  Permet de vérifier le fonctionnement du widget 'Les
    ...  audiences'. Ce widget doit afficher les 5 infractions dont la date
    ...  d'audience est la plus proche, pour lesquelles la date d'audience est
    ...  comprise entre le jour courant et un mois dans le futur.

    # On ajoute une infraction
    ${date_di_inf_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  10 days  result_format=%Y-%m-%d
    ${date_di_inf_form} =  Convert Date  ${date_di_inf_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Courtois
    ...  particulier_prenom=Christine
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Blais
    ...  particulier_prenom=Eugenia
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  om_collectivite=MARSEILLE
    ...  demande_type=Dépôt Initial IN
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    # On vérifie que l'infraction n'est pas affichée dans le widget
    Depuis la page d'accueil  juriste  juriste
    Element Should Not Contain  css=.widget_dossier_contentieux_audience  ${di_inf}

    # On saisit la date d'audience dans les données techniques
    &{donnees_techniques_values} =  Create Dictionary
    ...  ctx_date_audience=${date_di_inf_form}
    Saisir les données techniques du dossier infraction  ${di_inf}  ${donnees_techniques_values}

    # On vérifie que l'infraction est affichée dans le widget
    Click Element  css=.ui-icon-closethick
    Go To Dashboard
    Element Should Contain  css=.widget_dossier_contentieux_audience  ${di_inf}

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=affichage=nombre
    Modifier le widget  dossier_contentieux_audience  ${args_om_widget}

    Depuis la page d'accueil  juriste  juriste
    Element Should Contain  css=.widget_dossier_contentieux_audience span.bg-info  1

    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=${EMPTY}
    Modifier le widget  dossier_contentieux_audience  ${args_om_widget}


Widget "Mes AIT" et "Les AIT"

    [Documentation]  Permet de vérifier le fonctionnement du widget 'Mes AIT' et
    ...  du widget "Les AIT". Ces widgets doivent afficher les 5 infractions les
    ...  plus récentes pour lesquelles il y a un AIT signé, dans le cas du
    ...  widget 'Mes AIT', cela ne concerne que le juriste connecté.

    ##
    ## Widget 'Mes AIT'
    ##

    # On ajoute une infraction
    Depuis la page d'accueil  assist  assist
    #
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Champagne
    ...  particulier_prenom=Felicienne
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Blais
    ...  particulier_prenom=Eugenia
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  om_collectivite=MARSEILLE
    ...  demande_type=Dépôt Initial IN
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    # On vérifie que l'infraction n'est pas affichée dans le widget
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_ait  ${di_inf}
    Depuis la page d'accueil  juriste  juriste
    Element Should Not Contain  css=.widget_dossier_contentieux_ait  ${di_inf}

    # On saisit la date d'audience d'ait et on renseigne sa date de retour
    # signature
    Ajouter une instruction au DI et la finaliser  ${di_inf}  Arrêté interruptif des travaux  false  null  infraction
    &{args_instruction} =  Create Dictionary
    ...  date_retour_signature=${DATE_FORMAT_DD/MM/YYYY}
    Modifier le suivi des dates  ${di_inf}  Arrêté interruptif des travaux  ${args_instruction}  infraction

    # On vérifie que l'infraction est affichée dans le widget
    Go To Dashboard
    Element Should Contain  css=.widget_dossier_contentieux_ait  ${di_inf}
    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_ait  ${di_inf}

    ##
    ## Widget 'Les AIT'
    ##

    # On supprime l'affectation automatique du technicien sur les infractions
    Depuis la page d'accueil  admin  admin
    Supprimer l'affectation depuis le menu  null  Infraction

    # On ajoute une infraction non affectée
    Depuis la page d'accueil  assist  assist
    #
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Talon
    ...  particulier_prenom=Petrie
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Baril
    ...  particulier_prenom=Martin
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${args_peti} =  Create Dictionary
    ${di_inf_2} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}

    # On vérifie que l'infraction n'est pas affichée dans le widget
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_ait  ${di_inf_2}
    Depuis la page d'accueil  juriste  juriste
    Element Should Not Contain  css=.widget_dossier_contentieux_ait  ${di_inf_2}

    # On saisit la date d'ait et on renseigne sa date de retour signature
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di_inf_2}  Arrêté interruptif des travaux  false  null  infraction
    &{args_instruction} =  Create Dictionary
    ...  date_retour_signature=${DATE_FORMAT_DD/MM/YYYY}
    Modifier le suivi des dates  ${di_inf_2}  Arrêté interruptif des travaux  ${args_instruction}  infraction

    # On vérifie que l'infraction est affichée dans le widget
    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_ait  ${di_inf_2}
    Depuis la page d'accueil  juriste  juriste
    Element Should Not Contain  css=.widget_dossier_contentieux_ait  ${di_inf_2}

    #Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun\naffichage=nombre
    Modifier le widget  dossier_contentieux_ait  ${args_om_widget}

    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_ait span.bg-info  2

    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun
    Modifier le widget  dossier_contentieux_ait  ${args_om_widget}

    # On ajoute l'affectation automatique du technicien
    Depuis la page d'accueil  admin  admin
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Juriste (H)
    ...  instructeur_2=Technicien (H)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction
    Ajouter l'affectation depuis le menu  ${args_affectation}


Widget "Mes contradictoires" et "Les contradictoires"

    [Documentation]  Permet de vérifier le fonctionnement du widget 'Mes
    ...  contradictoires' et du widget "Les contradictoires". Ces widgets
    ...  doivent afficher les 5 infractions les plus anciennes pour lesquelles
    ...  la date de contradictoire est supérieure ou égale à la date du jour + 3
    ...  semaines OU la date de retour du contradictoire est vide, pour
    ...  lesquelles il n'y a pas d'événements de type 'Annlation de
    ...  contradictoire' et pour lesquelles il n'y a pas d'AIT créé. Dans le cas
    ...  du widget 'Mes contradictoires', cela ne concerne que le juriste
    ...  connecté.

    ##
    ## Cas n°1 : infraction dont la date de contradictoire est supérieure ou
    ## égale à la date du jour + 3 semaines, la date retour de contradictoire
    ## est saisie, sans événements de type 'Annlation de contradictoire' et sans
    ## AIT
    ##

    # On ajoute une infraction
    Depuis la page d'accueil  assist  assist
    #
    ${date_di_inf_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  28 days  result_format=%Y-%m-%d
    ${date_di_inf_form} =  Convert Date  ${date_di_inf_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Archambault
    ...  particulier_prenom=Corette
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Cantin
    ...  particulier_prenom=Joanna
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${di_inf_1} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}
    # On vérifie que l'infraction n'est pas affichée dans les widgets
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_1}
    Depuis la page d'accueil  juriste  juriste
    Element Should Not Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_1}

    # On saisit une date de contradictoire et une date de retour de
    # contradictoire
    Ajouter une instruction au DI  ${di_inf_1}  Date contradictoire  ${date_di_inf_form}  infraction
    Ajouter une instruction au DI  ${di_inf_1}  Retour du contradictoire  null  infraction

    # On vérifie que l'infraction est affichée dans les widgets
    Go To Dashboard
    Element Should Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_1}
    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_1}

    ##
    ## Cas n°2 : infraction dont la date de contradictoire n'est pas supérieure
    ## ou égale à la date du jour + 3 semaines, la date de retour du
    ## contradictoire n'est pas saisie, sans événements de type 'Annlation de
    ## contradictoire' et sans AIT
    ##

    #
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Desnoyer
    ...  particulier_prenom=Etoile
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Meunier
    ...  particulier_prenom=Eglantine
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${args_peti} =  Create Dictionary
    ${di_inf_2} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}

    # On vérifie que l'infraction n'est pas affichée dans les widgets
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_2}
    Depuis la page d'accueil  juriste  juriste
    Element Should Not Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_2}

    # On saisit une date de contradictoire
    Ajouter une instruction au DI  ${di_inf_2}  Date contradictoire  null  infraction

    # On vérifie que l'infraction est affichée dans les widgets
    Go To Dashboard
    Element Should Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_2}
    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_2}

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun\naffichage=nombre
    Modifier le widget  dossier_contentieux_contradictoire  ${args_om_widget}

    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=.widget_dossier_contentieux_contradictoire span.bg-info  2

    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun
    Modifier le widget  dossier_contentieux_contradictoire  ${args_om_widget}

    ##
    ## Cas n°3 : infraction du cas n°1 avec un événement de type 'Annlation de
    ## contradictoire'
    ##

    # On saisit une date de contradictoire
    Depuis la page d'accueil  juriste  juriste
    Ajouter une instruction au DI  ${di_inf_1}  Annulation de contradictoire  null  infraction

    # On vérifie que l'infraction n'est plus affichée dans les widgets
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_1}
    Depuis la page d'accueil  assist  assist
    Element Should Not Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_1}

    ##
    ## Cas n°4 : infraction du cas n°2 avec un AIT créé
    ##

    # On saisit une date de contradictoire
    Depuis la page d'accueil  juriste  juriste
    Ajouter une instruction au DI  ${di_inf_2}  Arrêté interruptif des travaux  null  infraction

    # On vérifie que l'infraction n'est plus affichée dans les widgets
    Go To Dashboard
    Element Should Not Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_2}
    Depuis la page d'accueil  assist  assist
    Element Should Not Contain  css=.widget_dossier_contentieux_contradictoire  ${di_inf_2}


Widget "Mes Recours" et "Mes Infractions"
    [Documentation]  Ces widget affiche les derniers Dossiers recours ou infraction.

    # Constitution du jeu de données
    Depuis la page d'accueil  admin  admin

    # On recupere les dossiers à creer en JSON
    ${json} =  Get File  binary_files/dossier_widget_contentieux_test.json
    # On parse le json pour avoir une liste de dossiers
    ${dossier_list}=  Evaluate  json.loads('''${json}''')  json

    # Création du juriste et du tech
    &{args_affectation_inf} =  Create Dictionary
    ...  instructeur=Félicien Roland (H)
    ...  instructeur_2=Sylvain Camille (H)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction

    &{args_affectation_rec} =  Create Dictionary
    ...  instructeur=Félicien Roland (H)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Recours contentieux

    Ajouter l'utilisateur depuis le menu  Félicien Roland  support@atreal.fr  juriste2  juriste2  JURISTE  MARSEILLE
    Ajouter l'instructeur depuis le menu  Félicien Roland  subdivision H  juriste  Félicien Roland
    Ajouter l'utilisateur depuis le menu  Sylvain Camille  support@atreal.fr  tech2  tech2  TECHNICIEN  MARSEILLE
    Ajouter l'instructeur depuis le menu  Sylvain Camille  subdivision H  technicien  Sylvain Camille
    Supprimer l'affectation depuis le menu  null  Infraction
    Supprimer l'affectation depuis le menu  null  Recours contentieux
    Ajouter l'affectation depuis le menu  ${args_affectation_inf}
    Ajouter l'affectation depuis le menu  ${args_affectation_rec}

    # Initialisation du compteur de di
    ${di_id} =  Set Variable  0

    :FOR  ${dossier}  IN  @{dossier_list["infraction"]}

    # Incrementation de l'identifient de di
    \  ${di_id} =  Evaluate  ${di_id}+1

    \  &{args_demandeur} =  Create Dictionary
    \  ...  particulier_prenom=${dossier["args_petitionnaire"]["particulier_prenom"]}
    \  ...  particulier_nom=${dossier["args_petitionnaire"]["particulier_nom"]}
    \  ...  om_collectivite=MARSEILLE

    \  &{args_petitionnaire} =  Create Dictionary
    \  ...  contrevenant_principal=&{args_demandeur}

    \  &{args_demande} =  Create Dictionary
    \  ...  dossier_autorisation_type_detaille=${dossier["args_demande"]["dossier_autorisation_type_detaille"]}
    \  ...  demande_type=${dossier["args_demande"]["demande_type"]}
    \  ...  date_demande=${dossier["args_demande"]["date_demande"]}
    \  ...  om_collectivite=MARSEILLE

    \  ${di} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_petitionnaire}
    # Concatenation du nom de di_ et du numero de di
    \  Set Test Variable  ${di_inf_${di_id}}  ${di}
    \  Set Suite Variable  ${di_inf_${di_id}}

    # Initialisation du compteur de di
    ${di_id} =  Set Variable  0

    :FOR  ${dossier}  IN  @{dossier_list["recours"]}

    # Incrementation de l'identifient de di
    \  ${di_id} =  Evaluate  ${di_id}+1

    \  &{args_petitionnaire} =  Create Dictionary
    \  ...  particulier_prenom=${dossier["args_petitionnaire"]["particulier_prenom"]}
    \  ...  particulier_nom=${dossier["args_petitionnaire"]["particulier_nom"]}
    \  ...  om_collectivite=MARSEILLE

    \  &{args_demande} =  Create Dictionary
    \  ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    \  ...  demande_type=Dépôt Initial
    \  ...  om_collectivite=MARSEILLE

    \  ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    \  &{args_demande} =  Create Dictionary
    \  ...  dossier_autorisation_type_detaille=${dossier["args_demande"]["dossier_autorisation_type_detaille"]}
    \  ...  demande_type=${dossier["args_demande"]["demande_type"]}
    \  ...  date_demande=${dossier["args_demande"]["date_demande"]}
    \  ...  autorisation_contestee=${di}
    \  ...  om_collectivite=MARSEILLE

    \  ${di_rec} =  Ajouter la demande par WS  ${args_demande}  ${NULL}
    # Concatenation du nom de di_ et du numero de di
    \  Set Test Variable  ${di_rec_${di_id}}  ${di_rec}
    \  Set Suite Variable  ${di_rec_${di_id}}

    \  Set Test Variable  ${di_${di_id}}  ${di}
    \  Set Suite Variable  ${di_${di_id}}


    # Vérification des accés du juriste (accés au infraction et pas au recours)
    Depuis la page d'accueil  juriste2  juriste2

    # On vérifie l'absence du dossier trop vieux
    Element Should Not Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_1}
    # On vérifi la presence des autres
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_2}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_3}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_4}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_5}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_6}

    # On verifie l'ingrité des raccourci
    Click Link  ${di_inf_6}
    Page Title Should Be  Contentieux > Infraction > ${di_inf_6}
    Go Back

    # On verifie le voir +
    Wait Until Element Is Visible  css=.widget_dossier_contentieux_infraction .widget-footer a
    Click Element  css=.widget_dossier_contentieux_infraction .widget-footer a
    Page Title Should Be  Contentieux > Infractions
    Element Should Contain  css=.tab-tab  ${di_inf_1}
    Element Should Contain  css=.tab-tab  ${di_inf_2}
    Element Should Contain  css=.tab-tab  ${di_inf_3}
    Element Should Contain  css=.tab-tab  ${di_inf_4}
    Element Should Contain  css=.tab-tab  ${di_inf_5}
    Element Should Contain  css=.tab-tab  ${di_inf_6}

    Go Back

    # On vérifie l'absence du dossier trop vieux
    Element Should Not Contain  css=#dashboard div.widget_dossier_contentieux_recours  ${di_rec_1}
    # On vérifi la presence des autres
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_recours  ${di_rec_2}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_recours  ${di_rec_3}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_recours  ${di_rec_4}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_recours  ${di_rec_5}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_recours  ${di_rec_6}

    # On verifie l'ingrité des raccourci
    Click Link  ${di_rec_6}
    Page Title Should Be  Contentieux > Recours > ${di_rec_6}
    Go Back

    # On verifie le voir +
    Wait Until Element Is Visible  css=.widget_dossier_contentieux_recours .widget-footer a
    Click Element  css=.widget_dossier_contentieux_recours .widget-footer a
    Page Title Should Be  Contentieux > Recours
    Element Should Contain  css=.tab-tab  ${di_rec_1}
    Element Should Contain  css=.tab-tab  ${di_rec_2}
    Element Should Contain  css=.tab-tab  ${di_rec_3}
    Element Should Contain  css=.tab-tab  ${di_rec_4}
    Element Should Contain  css=.tab-tab  ${di_rec_5}
    Element Should Contain  css=.tab-tab  ${di_rec_6}


    Depuis la page d'accueil  tech2  tech2

    # On vérifie l'absence du dossier trop vieux
    Element Should Not Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_1}
    # On vérifi la presence des autres
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_2}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_3}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_4}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_5}
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf_6}

    # On verifie l'ingrité des raccourci
    Click Link  ${di_inf_6}
    Page Title Should Be  Contentieux > Infraction > ${di_inf_6}
    Go Back

    # On verifie le voir +
    Wait Until Element Is Visible  css=.widget_dossier_contentieux_infraction .widget-footer a
    Click Element  css=.widget_dossier_contentieux_infraction .widget-footer a
    Page Title Should Be  Contentieux > Infractions
    Element Should Contain  css=.tab-tab  ${di_inf_1}
    Element Should Contain  css=.tab-tab  ${di_inf_2}
    Element Should Contain  css=.tab-tab  ${di_inf_3}
    Element Should Contain  css=.tab-tab  ${di_inf_4}
    Element Should Contain  css=.tab-tab  ${di_inf_5}
    Element Should Contain  css=.tab-tab  ${di_inf_6}

    # On remet les affectations automatique par défaut
    Depuis la page d'accueil  admin  admin
    Supprimer l'affectation depuis le menu  null  Infraction
    Supprimer l'affectation depuis le menu  null  Recours contentieux
    &{args_affectation_inf} =  Create Dictionary
    ...  instructeur=Juriste (H)
    ...  instructeur_2=Technicien (H)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction
    &{args_affectation_rec} =  Create Dictionary
    ...  instructeur=Juriste (H)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Recours contentieux
    Ajouter l'affectation depuis le menu  ${args_affectation_inf}
    Ajouter l'affectation depuis le menu  ${args_affectation_rec}

    #
    # Vérification du filtre sur les infractions en cours d'instruction lorsque
    # le filtre "instructeur" est activé ou non
    #

    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Flamand
    ...  particulier_prenom=Benjamin
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Pouliotte
    ...  particulier_prenom=Clementine
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    # On vérifie que l'infraction en cours apparait bien dans le widget et le
    # menu "Mes infractions" en tant que "TECHNICIEN"
    Depuis la page d'accueil  tech  tech
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf}
    Click Element  css=.widget_dossier_contentieux_infraction .widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=.tab-tab  ${di_inf}
    Go To Submenu  dossier_contentieux_mes_infractions
    Element Should Contain  css=.tab-tab  ${di_inf}

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=affichage=nombre
    Modifier le widget  dossier_contentieux_infraction  ${args_om_widget}

    Depuis la page d'accueil  tech  tech
    Page Should Contain Element  css=.widget_dossier_contentieux_infraction span.bg-info

    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=
    Modifier le widget  dossier_contentieux_infraction  ${args_om_widget}

    # Ajout d'un widget de test qui affiche les infractions sans filtre sur le
    # profil "ASSISTANTE" (qui n'est pas instructeur)
    Depuis la page d'accueil  admin  admin
    ${om_widget_libelle} =  Set Variable  TEST045WIDGETINFRACTIONS
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=dossier_contentieux_infraction
    ...  arguments=filtre=aucun
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=ASSISTANTE
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    # On vérifie que l'infraction en cours apparait bien dans le widget listant
    # les infractions avec le profil "ASSISTANTE"
    Depuis la page d'accueil  assist  assist
    Element Should Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf}
    Click Element  css=.widget_dossier_contentieux_infraction .widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=.tab-tab  ${di_inf}

    # On clôture le'infraction afin que l'instruction ne soit plus en cours
    # d'instruction
    Ajouter une instruction au DI  ${di_inf}  accepter un dossier sans réserve  null  infraction
    # Le profil "ASSISTANTE" doit toujours voir l'infraction
    Go To Dashboard
    Element Should Contain  css=.widget_dossier_contentieux_infraction  ${di_inf}
    Click Element  css=.widget_dossier_contentieux_infraction .widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=.tab-tab  ${di_inf}
    # Le profil "TECHNICIEN" ne doit plus voir ni l'infraction dans son widget,
    # ni dans le menu
    Depuis la page d'accueil  tech  tech
    Element Should Not Contain  css=#dashboard div.widget_dossier_contentieux_infraction  ${di_inf}
    Go To Submenu  dossier_contentieux_mes_infractions
    Element Should Not Contain  css=.tab-tab  ${di_inf}

    # On supprime les modifications effectuées sur le profil "ASSISTANTE"
    Depuis la page d'accueil  admin  admin
    Supprimer le tableau de bord depuis l'URL par l'identifiant  ${om_dashboard}
    Supprimer le widget depuis l'URL par l'identifiant  ${om_widget}


Widget "Nouveau dossier" et "Nouveau dossier contentieux"
    [Documentation]  Ces widgets affichent un lien pour rediriger l'utilisateur
    ...  Soit vers un nouveau dossier ADS soit vers un nouveau dossier contentieux.

    Depuis la page d'accueil  guichet  guichet
    Go To Dashboard
    Click On Link  Cliquer ici pour saisir une nouvelle demande concernant le dépôt d'un nouveau dossier
    Submenu In Menu Should Be Selected  guichet_unique  nouveau-dossier

    Depuis la page d'accueil  assist  assist
    Go To Dashboard
    Click On Link  Cliquer ici pour saisir une nouvelle demande concernant le dépôt d'un nouveau dossier
    Submenu In Menu Should Be Selected  contentieux  nouveau-dossier


Widget "Retours de Commission"
    [Documentation]  Ce widget indique le nombre de retours de commission non
    ...  lus.

    # On enregistre le nom du widget qui sera utilisé dans le tests
    ${om_widget} =  Set Variable  commission_retours

    # On crée une collectivité pour ne pas perturber ni être perturbé par
    # les autres tests.
    ${collectivite_a} =  Set Variable  MÉRIGNAC
    ${collectivite_b} =  Set Variable  SAINT-JOSEPH
    ${direction_a} =  Set Variable  Direction ME
    ${direction_b} =  Set Variable  Direction SJ
    ${direction_code_a} =  Set Variable  ME
    ${direction_code_b} =  Set Variable  SJ
    ${div_a1} =  Set Variable  subdivision ME1
    ${div_code_a1} =  Set Variable  ME1
    ${div_a2} =  Set Variable  subdivision ME2
    ${div_code_a2} =  Set Variable  ME2
    ${div_b} =  Set Variable  subdivision SJ
    ${div_code_b} =  Set Variable  SJ
    #
    ${utilisateur_nom_01} =  Set Variable  Arnolda Calis
    ${utilisateur_login_01} =  Set Variable  acalis
    ${utilisateur_nom_02} =  Set Variable  Bekhan Panova
    ${utilisateur_login_02} =  Set Variable  bpanova
    ${utilisateur_nom_03} =  Set Variable  Jolina Toral
    ${utilisateur_login_03} =  Set Variable  jtoral
    ${utilisateur_nom_04} =  Set Variable  Felix Simonsen
    ${utilisateur_login_04} =  Set Variable  fsimonsen
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire_rc
    #
    Depuis la page d'accueil  admin  admin
    #
    Ajouter la collectivité depuis le menu  ${collectivite_a}  mono
    Ajouter la collectivité depuis le menu  ${collectivite_b}  mono
    #
    Ajouter l'utilisateur  ${utilisateur_nom_01}  nospam@openmairie.org  ${utilisateur_login_01}  ${utilisateur_login_01}  INSTRUCTEUR  ${collectivite_a}
    Ajouter l'utilisateur  ${utilisateur_nom_02}  nospam@openmairie.org  ${utilisateur_login_02}  ${utilisateur_login_02}  INSTRUCTEUR  ${collectivite_a}
    Ajouter l'utilisateur  ${utilisateur_nom_03}  nospam@openmairie.org  ${utilisateur_login_03}  ${utilisateur_login_03}  INSTRUCTEUR  ${collectivite_a}
    Ajouter l'utilisateur  ${utilisateur_nom_04}  nospam@openmairie.org  ${utilisateur_login_04}  ${utilisateur_login_04}  INSTRUCTEUR  ${collectivite_b}
    Ajouter l'utilisateur  ${instructeur_secondaire_login}  nospam@openmairie.org  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}  INSTRUCTEUR  ${collectivite_a}
    #
    Ajouter la direction depuis le menu  ${direction_code_a}  ${direction_a}
    ...  null  Chef A  null  null  ${collectivite_a}
    Ajouter la direction depuis le menu  ${direction_code_b}  ${direction_b}
    ...  null  Chef B  null  null  ${collectivite_b}
    #
    Ajouter la division depuis le menu  ${div_code_a1}  ${div_a1}  null
    ...  Chef A  null  null  ${direction_a}
    Ajouter la division depuis le menu  ${div_code_a2}  ${div_a2}  null
    ...  Chef A  null  null  ${direction_a}
    Ajouter la division depuis le menu  ${div_code_b}  ${div_b}  null
    ...  Chef B  null  null  ${direction_b}
    #
    #
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_01}  ${div_a1}
    ...  instructeur  ${utilisateur_nom_01}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_02}  ${div_a2}
    ...  instructeur  ${utilisateur_nom_02}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_03}  ${div_a1}
    ...  instructeur  ${utilisateur_nom_03}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_04}  ${div_b}
    ...  instructeur  ${utilisateur_nom_04}
    Ajouter l'instructeur depuis le menu  ${instructeur_secondaire_login}  ${div_a1}
    ...  instructeur  ${instructeur_secondaire_login}
    #
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_01} (${div_code_a1})
    ...  instructeur_2=${instructeur_secondaire_login} (${div_code_a1})
    ...  om_collectivite=${collectivite_a}
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_02} (${div_code_a2})
    ...  instructeur_2=${instructeur_secondaire_login} (${div_code_a1})
    ...  om_collectivite=${collectivite_a}
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_03} (${div_code_a1})
    ...  instructeur_2=${instructeur_secondaire_login} (${div_code_a1})
    ...  om_collectivite=${collectivite_a}
    ...  dossier_autorisation_type_detaille=Permis de démolir
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_04} (${div_code_b})
    ...  om_collectivite=${collectivite_b}
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # DI n°1 : Permis de démolir dans Collectivité A (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_03}' (${utilisateur_login_03})
    # => Division 'J'
    #
    &{args_petitionnaire_01} =  Create Dictionary
    ...  particulier_nom=Hajnal
    ...  particulier_prenom=Katalin
    ...  om_collectivite=${collectivite_a}
    #
    &{args_demande_01} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=${collectivite_a}
    #
    ${di_01} =  Ajouter la demande par WS  ${args_demande_01}  ${args_petitionnaire_01}

    # DI n°2 : Permis de construire pour une maison individuelle et / ou ses annexes dans Collectivité A (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_01}' (${utilisateur_login_01})
    # => Division 'H'
    #
    &{args_petitionnaire_02} =  Create Dictionary
    ...  particulier_nom=Stoter
    ...  particulier_prenom=Ashni
    ...  om_collectivite=${collectivite_a}
    #
    &{args_demande_02} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=${collectivite_a}
    #
    ${di_02} =  Ajouter la demande par WS  ${args_demande_02}  ${args_petitionnaire_02}

    # DI n°3 : Permis de construire comprenant ou non des démolitions dans Collectivité A (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_02}' (${utilisateur_login_02})
    # => Division 'L'
    #
    &{args_petitionnaire_03} =  Create Dictionary
    ...  particulier_nom=West
    ...  particulier_prenom=Simon
    ...  om_collectivite=${collectivite_a}
    #
    &{args_demande_03} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=${collectivite_a}
    #
    ${di_03} =  Ajouter la demande par WS  ${args_demande_03}  ${args_petitionnaire_03}

    # DI n°4 : Permis de construire pour une maison individuelle et / ou ses annexes dans Collectivité B (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_04}' (${utilisateur_login_04})
    # => Division 'H'
    #
    &{args_petitionnaire_04} =  Create Dictionary
    ...  particulier_nom=Martin
    ...  particulier_prenom=Eloise
    ...  om_collectivite=${collectivite_b}
    #
    &{args_demande_04} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=${collectivite_b}
    #
    ${di_04} =  Ajouter la demande par WS  ${args_demande_04}  ${args_petitionnaire_04}


    ${code_type_commission_c} =  Set Variable  TC
    &{args_type_de_commission} =  Create Dictionary
    ...  code=${code_type_commission_c}
    ...  libelle=Type C
    ...  om_collectivite=${collectivite_a}
    Ajouter type de commission  ${args_type_de_commission}

    ${code_type_commission_d} =  Set Variable  TD
    &{args_type_de_commission} =  Create Dictionary
    ...  code=${code_type_commission_d}
    ...  libelle=Type D
    ...  om_collectivite=${collectivite_b}
    Ajouter type de commission  ${args_type_de_commission}

    # Demandes passage de commission
    Ajouter la commission depuis le contexte du dossier d'instruction
    ...  ${di_01}  Type C  ${date_ddmmyyyy}
    Ajouter la commission depuis le contexte du dossier d'instruction
    ...  ${di_02}  Type C  ${date_ddmmyyyy}
    Ajouter la commission depuis le contexte du dossier d'instruction
    ...  ${di_03}  Type C  ${date_ddmmyyyy}
    Ajouter la commission depuis le contexte du dossier d'instruction
    ...  ${di_04}  Type D  ${date_ddmmyyyy}

    # On vérifie que le widget n'indique aucun retour non lu
    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    Element Should Contain  css=.widget_${om_widget} .widget-content
    ...  Aucun retour de commission non lu.

    # Créer une commission pour les 2 collectivités
    Depuis la page d'accueil  admin  admin
    &{args_commission} =  Create Dictionary
    ...  om_collectivite=${collectivite_a}
    ...  commission_type=Type C
    Ajouter un suivi de commission  ${args_commission}
    &{args_commission} =  Create Dictionary
    ...  om_collectivite=${collectivite_b}
    ...  commission_type=Type D
    Ajouter un suivi de commission  ${args_commission}

    # Planifier et rendre des avis sur les 4 DI
    Planifier un dossier pour une commission
    ...  ${di_01}  ${code_type_commission_c}${DATE_FORMAT_YYYYMMDD}
    Rendre un avis sur dossier passé en commission
    ...  favorable  ${di_01}  ${code_type_commission_c}${DATE_FORMAT_YYYYMMDD}

    Planifier un dossier pour une commission
    ...  ${di_02}  ${code_type_commission_c}${DATE_FORMAT_YYYYMMDD}
    Rendre un avis sur dossier passé en commission
    ...  favorable  ${di_02}  ${code_type_commission_c}${DATE_FORMAT_YYYYMMDD}

    Planifier un dossier pour une commission
    ...  ${di_03}  ${code_type_commission_c}${DATE_FORMAT_YYYYMMDD}
    Rendre un avis sur dossier passé en commission
    ...  favorable  ${di_03}  ${code_type_commission_c}${DATE_FORMAT_YYYYMMDD}

    Planifier un dossier pour une commission
    ...  ${di_04}  ${code_type_commission_d}${DATE_FORMAT_YYYYMMDD}
    Rendre un avis sur dossier passé en commission
    ...  favorable  ${di_04}  ${code_type_commission_d}${DATE_FORMAT_YYYYMMDD}

    ## Vérification du filtre par défaut (instructeur)
    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    Element Should Contain  css=.widget_${om_widget} .box-icon  1
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_${om_widget} .widget-footer a
    Page Title Should Be  Instruction > Commissions > Mes Retours
    # L'instructeur doit seulement voir son dossier
    Element Should Contain  css=#tab-commission_mes_retours  ${di_02}
    Element Should Not Contain  css=#tab-commission_mes_retours  ${di_01}
    Element Should Not Contain  css=#tab-commission_mes_retours  ${di_03}
    Element Should Not Contain  css=#tab-commission_mes_retours  ${di_04}

    La page ne doit pas contenir d'erreur
    Click Link  ${di_02}
    Page Title Should Contain  Instruction > Dossiers D'instruction > ${di_02}
    La page ne doit pas contenir d'erreur

    ## Vérification du filtre instructeur
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur
    ...  ${om_widget}

    Depuis la page d'accueil  ${utilisateur_login_04}  ${utilisateur_login_04}
    Element Should Contain  css=.widget_${om_widget} .box-icon  1
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_${om_widget} .widget-footer a
    Page Title Should Be  Instruction > Commissions > Mes Retours
    # L'instructeur doit seulement voir son dossier
    Element Should Contain  css=#tab-commission_mes_retours  ${di_04}
    Element Should Not Contain  css=#tab-commission_mes_retours  ${di_01}
    Element Should Not Contain  css=#tab-commission_mes_retours  ${di_02}
    Element Should Not Contain  css=#tab-commission_mes_retours  ${di_03}


    ## Filtre sur l'instructeur secondaire'
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur_secondaire
    ...  ${om_widget}

    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    # On doit avoir 0 dossier pour l'instructeur
    Element Should Contain  css=.widget_${om_widget}  Aucun retour de commission non lu.

    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    # Les 3 dossiers affectés à l'instructeur secondaire doivent être visible
    Element Should Contain  css=.widget_${om_widget} .box-icon  3
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_${om_widget} .widget-footer a
    Page Title Should Be  Instruction > Commissions > Mes Retours
    Element Should Contain  css=#tab-commission_mes_retours  ${di_01}
    Element Should Contain  css=#tab-commission_mes_retours  ${di_02}
    Element Should Contain  css=#tab-commission_mes_retours  ${di_03}
    Element Should Not Contain  css=#tab-commission_mes_retours  ${di_04}


    ## Filtre sur la division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=division
    ...  ${om_widget}

    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    # On doit avoir 2 dossiers de la division
    Element Should Contain  css=.widget_${om_widget} .box-icon  2
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_${om_widget} .widget-footer a
    Page Title Should Be  Instruction > Commissions > Retours De Ma Division
    Element Should Contain  css=#tab-${om_widget}_ma_division  ${di_01}
    Element Should Contain  css=#tab-${om_widget}_ma_division  ${di_02}
    Element Should Not Contain  css=#tab-${om_widget}_ma_division  ${di_03}
    Element Should Not Contain  css=#tab-${om_widget}_ma_division  ${di_04}


    ## Filtre sur la division quand aucun instructeur sur le DI
    # TNR pour s'assurer que la division est récupérée directement sur le DI et
    # pas sur l'instructeur du DI. On supprime donc l'instructeur d'un DI.
    # Il faut changer l'instructeur puis resélectionner la division car la
    # division change en fnction de l'instructeur
    Depuis la page d'accueil  admin  admin
    Depuis la page d'accueil  admin  admin
    &{modifications} =  Create Dictionary 
    ...  instructeur=choisir l'instructeur${EMPTY}
    ...  division=subdivision ME1
    Modifier le dossier d'instruction  ${di_01}  ${modifications}

    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    # On doit avoir 2 dossiers de la division
    Element Should Contain  css=.widget_${om_widget} .box-icon  2
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_${om_widget} .widget-footer a
    Page Title Should Be  Instruction > Commissions > Retours De Ma Division
    Element Should Contain  css=#tab-${om_widget}_ma_division  ${di_01}
    Element Should Contain  css=#tab-${om_widget}_ma_division  ${di_02}
    Element Should Not Contain  css=#tab-${om_widget}_ma_division  ${di_04}
    Element Should Not Contain  css=#tab-${om_widget}_ma_division  ${di_03}

    ## Filtre "aucun" donc sur la collectivité
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=aucun
    ...  ${om_widget}

    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    # On doit avoir 3 dossiers de la collectivité
    Element Should Contain  css=.widget_${om_widget} .box-icon  3
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_${om_widget} .widget-footer a
    Page Title Should Be  Instruction > Commissions > Tous Les Retours
    Element Should Contain  css=#tab-commission_tous_retours  ${di_01}
    Element Should Contain  css=#tab-commission_tous_retours  ${di_02}
    Element Should Contain  css=#tab-commission_tous_retours  ${di_03}
    Element Should Not Contain  css=#tab-commission_tous_retours  ${di_04}

    ## Marquage comme non lu et vérifation widget et listing
    Click Link  ${di_01}  # pas le même instructeur mais même division
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Portlet Action Should Be In SubForm  dossier_commission  marquer_comme_lu
    # On marque comme lu
    Click On SubForm Portlet Action  dossier_commission  marquer_comme_lu
    Valid Message Should Contain In Subform    Mise à jour effectuée avec succès
    Element Should Contain  css=#lu  Oui

    # vérification que c'est bien pris en compte dans widget et listing
    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    # On doit avoir 2 dossiers de la collectivité
    Element Should Contain  css=.widget_${om_widget} .box-icon  2
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_${om_widget} .widget-footer a
    Page Title Should Be  Instruction > Commissions > Tous Les Retours
    Element Should Contain  css=#tab-commission_tous_retours  ${di_02}
    Element Should Contain  css=#tab-commission_tous_retours  ${di_03}
    Element Should Not Contain  css=#tab-commission_tous_retours  ${di_01}
    Element Should Not Contain  css=#tab-commission_tous_retours  ${di_04}

    ## Nettoyage: suppression de l'argument du widget pour ne pas perturber les
    ## autres tests.
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du widget  ${om_widget}
    Click On Form Portlet Action  om_widget  modifier
    Input Text  arguments  ${EMPTY}
    Click On Submit Button


Widget "RSS"
    [Documentation]  Ce widget lis les flux RSS.
    # 3 paramètres présent :
    # - urls = 1 ou 2 url séparé par une virgule
    # - mode = client_side ou server_side
    # - max_item = nb d'élément affiché donc un entier

    # Copy des fichiers de flux rss dans /app pour y avoir accés
    Copy Directory  ..${/}tests${/}binary_files${/}rss  ..${/}app${/}

    ${url_rss_no_entry} =  Set Variable  ${PROJECT_URL}app/rss/rss_no_entry.xml
    ${url_rss_1} =  Set Variable  ${PROJECT_URL}app/rss/rss_1.xml
    ${url_rss_2} =  Set Variable  ${PROJECT_URL}app/rss/rss_2.xml

    Depuis la page d'accueil  admin  admin

    # Création des widget

    # Widget RSS NO ENTRY CLIENT = urls=${url_rss_no_entry} mode = client_side max_item = 3
    # Depuis la page d'ajout d'un widget
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=0&advs_id=&premier=0&tricol=&valide=&retour=form
    Input Text  libelle  RSS NO ENTRY CLIENT
    # Selection
    Select From List By Label  type  file - le contenu du widget provient d'un script sur le serveur
    Select From List By Label  script  rss
    Input Text  arguments  urls=${url_rss_no_entry}\nmode=client_side\nmax_item=3
    Click On Submit Button


    # Widget RSS NO ENTRY SERVER = urls=${url_rss_no_entry} mode = client_side max_item = 3
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=0&advs_id=&premier=0&tricol=&valide=&retour=form
    Input Text  libelle  RSS NO ENTRY SERVER
    # Selection
    Select From List By Label  type  file - le contenu du widget provient d'un script sur le serveur
    Select From List By Label  script  rss
    Input Text  arguments  urls=${url_rss_no_entry}\nmode=server_side\nmax_item=3
    Click On Submit Button


    # Widget RSS CLIENT 3items 1urls = urls=${url_rss_1} mode = client_side max_item = 3
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=0&advs_id=&premier=0&tricol=&valide=&retour=form
    Input Text  libelle   RSS CLIENT 3items 1urls
    # Selection
    Select From List By Label  type  file - le contenu du widget provient d'un script sur le serveur
    Select From List By Label  script  rss
    Input Text  arguments  urls=${url_rss_1}\nmode=client_side\nmax_item=3
    Click On Submit Button

    # Widget RSS CLIENT 2items 2urls = urls=${url_rss_1},${url_rss_2} mode = client_side max_item = 2
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=0&advs_id=&premier=0&tricol=&valide=&retour=form
    Input Text  libelle   RSS CLIENT 3items 2urls
    # Selection
    Select From List By Label  type  file - le contenu du widget provient d'un script sur le serveur
    Select From List By Label  script  rss
    Input Text  arguments  urls=${url_rss_1},${url_rss_2}\nmode=client_side\nmax_item=3
    Click On Submit Button


    # Widget RSS SERVER 1items 1urls = urls=${url_rss_1} mode = server_side max_item = 1
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=0&advs_id=&premier=0&tricol=&valide=&retour=form
    Input Text  libelle   RSS SERVER 1items 1urls
    # Selection
    Select From List By Label  type  file - le contenu du widget provient d'un script sur le serveur
    Select From List By Label  script  rss
    Input Text  arguments  urls=${url_rss_1}\nmode=server_side\nmax_item=1
    Click On Submit Button


    # Widget RSS SERVER 2items 2urls = urls={url_rss_1},${url_rss_2} mode = server_side max_item = 2
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=0&advs_id=&premier=0&tricol=&valide=&retour=form
    Input Text  libelle   RSS SERVER 2items 2urls
    # Selection
    Select From List By Label  type  file - le contenu du widget provient d'un script sur le serveur
    Select From List By Label  script  rss
    Input Text  arguments  urls=${url_rss_1},${url_rss_2}\nmode=server_side\nmax_item=2
    Click On Submit Button



    # Composition du tableau de bord du profil ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0&advs_id=&premier=0&tricol=-0&valide=&retour=form
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  RSS NO ENTRY CLIENT
    Click On Submit Button
    ${id_widget_client_no_entry}=  Get Text  om_dashboard

    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0&advs_id=&premier=0&tricol=-0&valide=&retour=form
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  RSS NO ENTRY SERVER
    Click On Submit Button
    ${id_widget_server_no_entry}=  Get Text  om_dashboard


    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0&advs_id=&premier=0&tricol=-0&valide=&retour=form
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  RSS CLIENT 3items 1urls
    Click On Submit Button
    ${id_widget_client_3i_1u}=  Get Text  om_dashboard

    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0&advs_id=&premier=0&tricol=-0&valide=&retour=form
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  RSS CLIENT 3items 2urls
    Click On Submit Button
    ${id_widget_client_3i_2u}=  Get Text  om_dashboard

    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0&advs_id=&premier=0&tricol=-0&valide=&retour=form
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  RSS SERVER 1items 1urls
    Click On Submit Button
    ${id_widget_server_1i_1u}=  Get Text  om_dashboard

    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0&advs_id=&premier=0&tricol=-0&valide=&retour=form
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  RSS SERVER 2items 2urls
    Click On Submit Button
    ${id_widget_server_2i_2u}=  Get Text  om_dashboard


    # Vérification des informations reçu
    Depuis la page d'accueil  admin  admin
    # Vérification Pour le widget RSS SERVER 2items 2urls
    # titre widget
    Element Should Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-header h3  RSS SERVER 2items 2urls
    # Channel
    Element Should Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker ul  RSS_1 5 Items
    # item 1
    Element Should Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker ul li a  item_1 du flux rss_1
    # Description item 1
    Element Should Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker ul li p  Description de l'item 1 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker ul > li:nth-child(3) a  item_2 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker ul > li:nth-child(3) p  Description de l'item 2 du flux rss_1
    Element Should Not Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker ul  item_3 du flux rss_1
    Element Should Not Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker ul  item_4 du flux rss_1

    Element Should Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker > ul:nth-child(2)  RSS_2 4 Item
    Element Should Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker > ul:nth-child(2) li a  item_1 du flux rss_2
    Element Should Contain  css=div#widget_${id_widget_server_2i_2u} div.widget-content div.widget-rss-marker > ul:nth-child(2) li p  Description de l'item 1 du flux rss_2


    # Vérification Pour le widget RSS SERVER 1items 1urls
    Element Should Contain  css=div#widget_${id_widget_server_1i_1u} div.widget-header h3  RSS SERVER 1items 1urls
    Element Should Contain  css=div#widget_${id_widget_server_1i_1u} div.widget-content div.widget-rss-marker ul h4  RSS_1 5 Items
    Element Should Contain  css=div#widget_${id_widget_server_1i_1u} div.widget-content div.widget-rss-marker ul li a  item_1 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_server_1i_1u} div.widget-content div.widget-rss-marker ul li p  Description de l'item 1 du flux rss_1
    Element Should Not Contain  css=div#widget_${id_widget_server_1i_1u} div.widget-content div.widget-rss-marker ul li a  item_2 du flux rss_1
    Element Should Not Contain  css=div#widget_${id_widget_server_1i_1u} div.widget-content div.widget-rss-marker ul li a  item_3 du flux rss_1

    # Vérification pour le widget RSS CLIENT 3items 2urls
    Element Should Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-header h3  RSS CLIENT 3items 2urls

    Element Should Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-content div.widget-rss-marker  RSS_1 5 Items
    Element Should Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-content div.widget-rss-marker  item_1 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-content div.widget-rss-marker  Description de l'item 1 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-content div.widget-rss-marker  item_2 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-content div.widget-rss-marker  Description de l'item 2 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-content div.widget-rss-marker  item_3 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-content div.widget-rss-marker  Description de l'item 3 du flux rss_1
    Element Should Not Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-content div.widget-rss-marker  item_4 du flux rss_1

    Element Should Contain  css=div#widget_${id_widget_client_3i_2u} div.widget-content div.widget-rss-marker  RSS_2 4 Item


    # Vérification pour le widget RSS CLIENT 3items 1urls
    Element Should Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-header h3  RSS CLIENT 3items 1urls
    Element Should Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-content div.widget-rss-marker ul h4  RSS_1 5 Items
    Element Should Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-content div.widget-rss-marker ul li a  item_1 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-content div.widget-rss-marker ul li p  Description de l'item 1 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-content div.widget-rss-marker ul > li:nth-child(3) a  item_2 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-content div.widget-rss-marker ul > li:nth-child(3) p  Description de l'item 2 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-content div.widget-rss-marker ul > li:nth-child(4) a  item_3 du flux rss_1
    Element Should Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-content div.widget-rss-marker ul > li:nth-child(4) p  Description de l'item 3 du flux rss_1
    Element Should Not Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-content div.widget-rss-marker ul li a  item_4 du flux rss_1
    Element Should Not Contain  css=div#widget_${id_widget_client_3i_1u} div.widget-content div.widget-rss-marker ul li a  item_5 du flux rss_1

    # Vérification pour le widget RSS NO ENTRY CLIENT
    Element Should Contain  css=div#widget_${id_widget_client_no_entry} div.widget-header h3  RSS NO ENTRY CLIENT
    Element Should Contain  css=div#widget_${id_widget_client_no_entry} div.widget-content div.widget-rss-marker  Aucune donnée disponible

    # Vérification pour le widget RSS NO ENTRY SERVER
    Element Should Contain  css=div#widget_${id_widget_server_no_entry} div.widget-header h3  RSS NO ENTRY SERVER
    Element Should Contain  css=div#widget_${id_widget_server_no_entry} div.widget-content div.widget-rss-marker  Aucune donnée disponible

    # Suppression des fichiers de /app.
    Remove Directory  ..${/}app${/}rss  true

    # # Suppression des widget du tdb
    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_dashboard&premier=0&tricol=-0&advs_id=&valide=&style=tab&onglet=&
    Click Link  ${id_widget_client_no_entry}
    Wait Until Page Contains Element  css=#action-form-om_dashboard-supprimer
    Click On Form Portlet Action  om_dashboard  supprimer
    Click On Submit Button

    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_dashboard&premier=0&tricol=-0&advs_id=&valide=&style=tab&onglet=&
    Click Link  ${id_widget_server_no_entry}
    Wait Until Page Contains Element  css=#action-form-om_dashboard-supprimer
    Click On Form Portlet Action  om_dashboard  supprimer
    Click On Submit Button

    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_dashboard&premier=0&tricol=-0&advs_id=&valide=&style=tab&onglet=&
    Click Link  ${id_widget_server_2i_2u}
    Wait Until Page Contains Element  css=#action-form-om_dashboard-supprimer
    Click On Form Portlet Action  om_dashboard  supprimer
    Click On Submit Button

    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_dashboard&premier=0&tricol=-0&advs_id=&valide=&style=tab&onglet=&
    Click Link  ${id_widget_server_1i_1u}
    Wait Until Page Contains Element  css=#action-form-om_dashboard-supprimer
    Click On Form Portlet Action  om_dashboard  supprimer
    Click On Submit Button

    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_dashboard&premier=0&tricol=-0&advs_id=&valide=&style=tab&onglet=&
    Click Link  ${id_widget_client_3i_2u}
    Wait Until Page Contains Element  css=#action-form-om_dashboard-supprimer
    Click On Form Portlet Action  om_dashboard  supprimer
    Click On Submit Button

    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_dashboard&premier=0&tricol=-0&advs_id=&valide=&style=tab&onglet=&
    Click Link  ${id_widget_client_3i_1u}
    Wait Until Page Contains Element  css=#action-form-om_dashboard-supprimer
    Click On Form Portlet Action  om_dashboard  supprimer
    Click On Submit Button


Widget "Dossiers Consultés"
    [Documentation]  Ce widget affiche dans un tableau les X derniers dossiers consultés.

    # Permet de réinitialiser la session
    Depuis la page d'accueil  instr  instr
    Depuis la page d'accueil  admin  admin
    # Ajouter des DI
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Parfa
    ...  particulier_prenom=Pierre
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_consulte_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Maurice
    ...  particulier_prenom=Eric
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_consulte_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Oracle
    ...  particulier_prenom=Yeal
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_consulte_3} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Paya
    ...  particulier_prenom=Tim
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_consulte_4} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Marcel
    ...  particulier_prenom=Jean
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_consulte_5} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Suppression du widget des dossiers consultés par défaut du tableau de bord
    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_dashboard
    Use Simple Search  Profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Click Link  Les derniers dossiers consultés
    Click On Form Portlet Action  om_dashboard  supprimer
    Click On Submit Button

    # Ajout du Widget avec un nombre limite à 3
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=0
    Input Text  libelle   Les derniers dossiers consultés (3)
    # Selection
    Select From List By Label  type  file - le contenu du widget provient d'un script sur le serveur
    Select From List By Label  script  dossier_consulter
    Input Text  arguments  nb_dossiers=3
    Click On Submit Button

    # Ajouter a la composition
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  Les derniers dossiers consultés (3)
    Click On Submit Button

    Go to dashboard
    Element Should Not Contain  css=.widget_dossier_consulter  ${di_consulte_1}
    Element Should Not Contain  css=.widget_dossier_consulter  ${di_consulte_2}
    Element Should Contain  css=.widget_dossier_consulter  Vous n'avez pas consulté de dossier pour le moment.

    # Les consulter
    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=dossier_instruction
    Input Text    dossier    ${di_consulte_1},${di_consulte_2}
    Click Element  css=#adv-search-submit
    Click On Link  ${di_consulte_1}
    Click On Back Button
    Click On Link  ${di_consulte_2}

    # On vérifie que le bouton "Afficher +" n'est pas affiché
    Go to dashboard
    Element Should Not Contain  css=.widget_dossier_consulter  Afficher +

    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=dossier_instruction
    Input Text    dossier    ${di_consulte_3},${di_consulte_4},${di_consulte_5}
    Click Element  css=#adv-search-submit
    Click On Link  ${di_consulte_3}
    Click On Back Button
    Click On Link  ${di_consulte_4}
    Click On Back Button
    Click On Link  ${di_consulte_5}

    Go to dashboard
    Element Should Not Contain  css=.widget_dossier_consulter  ${di_consulte_1}
    Element Should Not Contain  css=.widget_dossier_consulter  ${di_consulte_2}
    Element Should Contain  css=.widget_dossier_consulter  ${di_consulte_3}
    Element Should Contain  css=.widget_dossier_consulter  ${di_consulte_4}
    Element Should Contain  css=.widget_dossier_consulter  ${di_consulte_5}
    Element Should Not Contain  css=.widget_dossier_consulter  Vous n'avez pas consulté de dossier pour le moment.

    # Test contenu du Afficher +
    Click Element  css=.widget_dossier_consulter .widget-footer a
    Element Should Contain  css=.widget_dossier_consulter  ${di_consulte_1}
    Element Should Contain  css=.widget_dossier_consulter  ${di_consulte_2}

    # Ajout d'un dossier de recours et d'un dossier d'infraction pour tester les
    # différentes redirections possibles
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Parfa
    ...  particulier_prenom=Pierre
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours gracieux
    ...  demande_type=Dépôt Initial REG
    ...  autorisation_contestee=${di_consulte_1}
    ...  om_collectivite=MARSEILLE
    ${di_reg} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Massé
    ...  particulier_prenom=Madelene
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    Depuis le contexte du dossier recours  ${di_reg}
    Depuis le contexte du dossier infraction  ${di_inf}
    Depuis le contexte du dossier d'instruction  ${di_consulte_1}

    Go to dashboard
    Click Element  css=.widget_dossier_consulter .widget-footer a
    Click On Link  ${di_consulte_1}
    Page Should Not Contain  Droits insuffisants
    Go to dashboard
    Click Element  css=.widget_dossier_consulter .widget-footer a
    Click On Link  ${di_reg}
    Page Should Not Contain  Droits insuffisants
    Go to dashboard
    Click Element  css=.widget_dossier_consulter .widget-footer a
    Click On Link  ${di_inf}
    Page Should Not Contain  Droits insuffisants

    # Suppression du widget du tableau de bord
    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_dashboard
    Use Simple Search  Profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Click Link  Les derniers dossiers consultés (3)
    Click On Form Portlet Action  om_dashboard  supprimer
    Click On Submit Button

    # Suppression du widget
    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_widget
    Use Simple Search  libellé  Les derniers dossiers consultés (3)
    Click Link  Les derniers dossiers consultés (3)
    Click On Form Portlet Action  om_widget  supprimer
    Click On Submit Button

    # Ajout le widget par défaut
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  Les derniers dossiers consultés
    Click On Submit Button


Widget "Derniers dossiers déposés"
    [Documentation]  Ce widget affiche le nombre des derniers
    ...  dossiers déposés.

    # On crée une collectivité, ses divisions et ses instructeurs
    # pour ne pas perturber ni être perturbé par les autres tests.
    #
    Depuis la page d'accueil  admin  admin
    #
    Ajouter la collectivité depuis le menu  STORYBROOK  mono
    Ajouter la direction depuis le menu  STORYBROOK  STORYBROOK  null  Chef STORYBROOK  null  null  STORYBROOK
    Ajouter la division depuis le menu  SB1  subdivision SB1  null
    ...  Chef STORYBROOK  null  null  STORYBROOK
    Ajouter la division depuis le menu  SB2  subdivision SB2  null
    ...  Chef STORYBROOK  null  null  STORYBROOK

    # Ajout d'un instructeur secondaire à affecter aux dossiers
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire_ddd
    Ajouter l'utilisateur  ${instructeur_secondaire_login}  nospam@openmairie.org  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}  INSTRUCTEUR  STORYBROOK
    Ajouter l'instructeur depuis le menu  ${instructeur_secondaire_login}  subdivision SB1  instructeur  ${instructeur_secondaire_login}

    Ajouter l'utilisateur  Peter Pan  nospam@openmairie.org  ppan  ppan  INSTRUCTEUR  STORYBROOK
    Ajouter l'instructeur depuis le menu  Peter Pan  subdivision SB1  instructeur  Peter Pan
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Peter Pan (SB1)
    ...  instructeur_2=${instructeur_secondaire_login} (SB1)
    ...  om_collectivite=STORYBROOK
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    Ajouter l'affectation depuis le menu  ${args_affectation}
    #
    Ajouter l'utilisateur  Wendy Darling  nospam@openmairie.org  wdarling  wdarling  INSTRUCTEUR  STORYBROOK
    Ajouter l'instructeur depuis le menu  Wendy Darling  subdivision SB2  instructeur  Wendy Darling
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Wendy Darling (SB2)
    ...  instructeur_2=${instructeur_secondaire_login} (SB1)
    ...  om_collectivite=STORYBROOK
    ...  dossier_autorisation_type_detaille=Permis de démolir
    Ajouter l'affectation depuis le menu  ${args_affectation}
    #
    #Création  des divisions, instructeurs et affectations automatiques

    # On ajoute le droit au profil instructeur
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu  derniers_dossiers_deposes  INSTRUCTEUR


    # On vérifie que le widget est paramétré correctement:
    # DATD: PCI et PD
    # Filtre division
    # Intervalle de date de dépôt: 15 jours
    # type de dépôt: dépôt électronique
    Insérer les paramètres suivants dans le widget
    ...  codes_datd=PCI;PD\nfiltre=division\nfiltre_depot=depot_electronique\nnombre_de_jours=15
    ...  derniers_dossiers_deposes

    # On ajoute le widget au tableau de bord des instructeurs
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  INSTRUCTEUR
    Input Text  bloc  C1
    Select From List By Label  om_widget  Les derniers dossiers déposés
    Click On Submit Button

    # On vérifie que le widget n'indique aucun dossier déposé
    Depuis la page d'accueil  ppan  ppan
    Element Should Contain  css=.widget_derniers_dossiers_deposes .widget-content
    ...  Aucun dossier déposé dernièrement.

    #En DIVISION 1 :Création d'un jeu de dossiers remplissant les critères :
    # intervalle de dépôt, dépôt électronique
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Applefield
    ...  particulier_prenom=Nadia
    ...  om_collectivite=STORYBROOK
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=STORYBROOK
    ...  depot_electronique=true
    ${di_01} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Dandelion
    ...  particulier_prenom=Leopold
    ...  om_collectivite=STORYBROOK
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=STORYBROOK
    ...  depot_electronique=true
    ${di_02} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #En DIVISION 2: Création d'un jeu de dossiers remplissant les critères :
    # intervalle de dépôt, dépôt électronique
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Haskill
    ...  particulier_prenom=George
    ...  om_collectivite=STORYBROOK
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=STORYBROOK
    ...  depot_electronique=true
    ${di_03} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}


    #DIV 1: Création d'un dossier ne remplissant pas le critère intervalle de dépôt
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Prince
    ...  particulier_prenom=François
    ...  om_collectivite=STORYBROOK
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=STORYBROOK
    ...  date_demande=01/01/2015
    ...  depot_electronique=true
    ${di_04} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #DIV 1: Création d'un dossier ne remplissant pas le critère dépôt électronique
        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Noire
    ...  particulier_prenom=Rose
    ...  om_collectivite=STORYBROOK
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=STORYBROOK
    ...  depot_electronique=false
    ${di_05} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    ## Vérification du widget et du listing Division 1
    Depuis la page d'accueil  ppan  ppan
    ${nombre_derniers_dossiers_deposes} =  Get Text
    ...  css=div#content.ui-widget.ui-widget-content.ui-corner-all div.widget_derniers_dossiers_deposes .widget-content span.size-h3.box-icon.rounded.bg-info
    Should Not Be Empty  ${nombre_derniers_dossiers_deposes}
    Should Be Equal  ${nombre_derniers_dossiers_deposes}  2
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_derniers_dossiers_deposes .widget-footer a
    Page Title Should Be  Instruction > Dossiers Déposés
    # L'instructeur doit voir tous les dossiers de sa division
    # qui respectent les paramètres du widget(sauf intervalle de dépot)
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_01}
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_02}
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_03}
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_04}
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_05}

    ## Vérification du widget et du listing Division 2
    Depuis la page d'accueil  wdarling  wdarling
    ${nombre_derniers_dossiers_deposes} =  Get Text
    ...  css=.widget_derniers_dossiers_deposes .widget-content span.size-h3.box-icon.rounded.bg-info
    Should Not Be Empty  ${nombre_derniers_dossiers_deposes}
    Should Be Equal  ${nombre_derniers_dossiers_deposes}  1
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_derniers_dossiers_deposes .widget-footer a
    Page Title Should Be  Instruction > Dossiers Déposés
    # L'instructeur doit voir tous les dossiers de sa division
    # qui respectent les paramètres du widget(sauf intervalle de dépot)
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_01}
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_02}
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_03}
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_05}
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_04}

    # Modification du filtre de dépôt pour vérifier la modification du résultat
    # et l'ajout d'une colonne au lisitng
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  codes_datd=PCI;PD\nfiltre=division\nfiltre_depot=aucun\nnombre_de_jours=15
    ...  derniers_dossiers_deposes

    ## Vérification du widget et du listing Division 1
    Depuis la page d'accueil  ppan  ppan
    ${nombre_derniers_dossiers_deposes} =  Get Text
    ...  css=div#content.ui-widget.ui-widget-content.ui-corner-all div.widget_derniers_dossiers_deposes .widget-content span.size-h3.box-icon.rounded.bg-info
    Should Not Be Empty  ${nombre_derniers_dossiers_deposes}
    Should Be Equal  ${nombre_derniers_dossiers_deposes}  3
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_derniers_dossiers_deposes .widget-footer a
    Page Title Should Be  Instruction > Dossiers Déposés
    # L'instructeur doit voir tous les dossiers de sa division
    # qui respectent les paramètres du widget(sauf intervalle de dépot)
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_01}
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_02}
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_03}
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_04}
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_05}
    # Vérifie que la colonne "dépôt électronique" est affichée
    Element Should Contain  css=#tab-derniers_dossiers_deposes  dépôt électronique

    # Modification du filtre de dépôt pour tester le filtre sur l'instructeur secondaire
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur_secondaire\ncodes_datd=PCI;PD\nfiltre_depot=aucun\nnombre_de_jours=15
    ...  derniers_dossiers_deposes
    # Vérification des résultats affichés dans le widgets
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Element Should Contain  css=.widget_derniers_dossiers_deposes span.bg-info  4
    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_derniers_dossiers_deposes .widget-footer a
    # L'instructeur doit voir tous les dossiers sur lesquels il est affecté en tant qu'instructeur
    # secondaire et qui respectent les paramètres du widget(sauf intervalle de dépot)
    Wait Until Page Contains Element  css=#tab-derniers_dossiers_deposes
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_01}
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_02}
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_03}
    Element Should Not Contain  css=#tab-derniers_dossiers_deposes  ${di_04}
    Element Should Contain  css=#tab-derniers_dossiers_deposes  ${di_05}

    #Supprimer le droit ajouté en début de test pour revenir en condition initiale
    Depuis la page d'accueil  admin  admin
    Depuis le listing des droits
    Use Simple Search  libellé  derniers_dossiers_deposes
    Select From List By Label  name=selectioncol  Tous
    Click Element  css=button#search-submit
    Wait Until Element Is Visible  css=table.tab-tab
    Click On Link  INSTRUCTEUR
    Click On Form Portlet Action  om_droit  supprimer
    Click On Submit Button


Widget "Dossiers à qualifier (limite de la notification du délai)"
    [Documentation]  Ce widget affiche les dossiers à qualifier
    ...  et dont la date notification de délai n'est par encore dépassée.

    #
    Depuis la page d'accueil  admin  admin
    # Isolation du contexte
    Ajouter la collectivité depuis le menu  TESTNOTIFICATIONDELAI  mono
    Ajouter la direction depuis le menu  TESTNOTIFICATIONDELAI  TESTNOTIFICATIONDELAI  null  Chef TESTNOTIFICATIONDELAI  null  null  TESTNOTIFICATIONDELAI
    Ajouter la division depuis le menu  SB8  subdivision SB8  null
    ...  Chef TESTNOTIFICATIONDELAI  null  null  TESTNOTIFICATIONDELAI
    Ajouter la division depuis le menu  SB9  subdivision SB9  null
    ...  Chef TESTNOTIFICATIONDELAI  null  null  TESTNOTIFICATIONDELAI

    Ajouter l'utilisateur  delai_pre_inst  nospam@openmairie.org  delai_pre_inst  delai_pre_inst  INSTRUCTEUR POLYVALENT  TESTNOTIFICATIONDELAI
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire
    Ajouter l'utilisateur  ${instructeur_secondaire_login}  nospam@openmairie.org  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}  INSTRUCTEUR POLYVALENT  TESTNOTIFICATIONDELAI
    # TODO : ajouter un 3ème profil et l'affecter en instructeur secondaire
    # On affecte cet instructeur aux PCI
    Ajouter l'instructeur depuis le menu  delai_pre_inst  subdivision SB8  instructeur  delai_pre_inst
    Ajouter l'instructeur depuis le menu  ${instructeur_secondaire_login}  subdivision SB8  instructeur  ${instructeur_secondaire_login}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=delai_pre_inst (SB8)
    ...  instructeur_2=${instructeur_secondaire_login} (SB8)
    ...  om_collectivite=TESTNOTIFICATIONDELAI
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    Ajouter l'affectation depuis le menu  ${args_affectation}
    # On affecte cet instructeur aux CU
    Ajouter l'utilisateur  delai_pre_inst_polycomm  nospam@openmairie.org  delai_pre_inst_polycomm  delai_pre_inst_polycomm  INSTRUCTEUR POLYVALENT COMMUNE  TESTNOTIFICATIONDELAI
    Ajouter l'instructeur depuis le menu  delai_pre_inst_polycomm  subdivision SB9  instructeur  delai_pre_inst_polycomm
    &{args_affectation} =  Create Dictionary
    ...  instructeur=delai_pre_inst_polycomm (SB9)
    ...  instructeur_2=${instructeur_secondaire_login} (SB8)
    ...  om_collectivite=TESTNOTIFICATIONDELAI
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # On vérifie que le widget apparaît sur le tableau de bord des utilisateurs instrpolycomm
    Depuis la page d'accueil  delai_pre_inst_polycomm  delai_pre_inst_polycomm
    Element Should Contain  css=.widget_dossiers_pre_instruction  Vous n'avez aucun dossier d'instruction à qualifier dont la date limite de notification du délai au pétitionnaire arrive bientôt à échéance.

    # Calcul de la date de demande des dossiers pour leur donner une date limite de notification (dln)
    # le plus proche possible de celle du jour
    # La dln est calculé en ajoutant 1 mois à la date de demande. On enlève donc 1 mois
    # à la date courante pour s'en approcher
    ${date_di} =  Ajouter ou supprimer des mois à une date  -1  ${date_ddmmyyyy}
    # Calcul la dln à partir de la date de demande précédente
    ${date_limite_notification} =  Ajouter ou supprimer des mois à une date  1  ${date_di}
    # Vérifie si la date courante n'est pas supérieure à la dln.
    # Ce cas est possible pour les jours en 31 ou si on est le 29, 30 ou 31 mars.
    # Si c'est le cas on prend le 1 jour du mois courant comme jour pour la date de demande
    ${date_dmy} =  Convert Date  ${date_ddmmyyyy}  datetime  date_format=%d/%m/%Y
    ${month_dmy} =  Set Variable If  ${date_dmy.month} < 10  0${date_dmy.month}  ${date_dmy.month}
    ${date_dln} =  Convert Date  ${date_limite_notification}  datetime  date_format=%d/%m/%Y
    ${date_di} =  Run Keyword If  ${date_dmy.day} > ${date_dln.day} 
    ...  Convert date  ${date_dmy.year}-${month_dmy}-01  result_format=%d/%m/%Y
    ...  ELSE    Set Variable  ${date_di}

    # Ajout d'un dossier afin qu'il soit affiché dans le widget (-1 mois avant)
    &{args_petitionnaire_alert_pre_instruction} =  Create Dictionary
    ...  particulier_nom=045TESTDELAIPREINSTRUCTIONNOM
    ...  particulier_prenom=045TESTDELAIPREINSTRUCTIONPRENOM
    ...  om_collectivite=TESTNOTIFICATIONDELAI
    &{args_demande_alert_pre_instruction} =  Create Dictionary
    ...  date_demande=${date_di}
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=TESTNOTIFICATIONDELAI
    ${di_alert_pre_instruction} =  Ajouter la demande par WS  ${args_demande_alert_pre_instruction}  ${args_petitionnaire_alert_pre_instruction}
    # On vérifie que le dossier apparraît ou non dans le widget des utilisateurs
    Depuis la page d'accueil  delai_pre_inst_polycomm  delai_pre_inst_polycomm
    Element Should Contain  css=#dossier_dossiers_pre_instruction_0  ${di_alert_pre_instruction}

    Depuis la page d'accueil  delai_pre_inst  delai_pre_inst
    Element Should Contain  css=.widget_dossiers_pre_instruction  Vous n'avez aucun dossier d'instruction à qualifier dont la date limite de notification du délai au pétitionnaire arrive bientôt à échéance.

    # On change le filtre sur 'aucun'
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  filtre=aucun  dossiers_pre_instruction

    Depuis la page d'accueil  delai_pre_inst  delai_pre_inst
    Element Should Contain  css=#dossier_dossiers_pre_instruction_0  ${di_alert_pre_instruction}

    # On remet le filtre par défaut (instructeur)
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  ${EMPTY}  dossiers_pre_instruction

    &{args_petitionnaire_alert_pre_instruction1} =  Create Dictionary
    ...  particulier_nom=045TESTDELAIPREINSTRUCTIONNOM1
    ...  particulier_prenom=045TESTDELAIPREINSTRUCTIONPRENOM1
    ...  om_collectivite=TESTNOTIFICATIONDELAI
    &{args_demande_alert_pre_instruction1} =  Create Dictionary
    ...  date_demande=${date_di}
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=TESTNOTIFICATIONDELAI
    ${di_alert_pre_instruction1} =  Ajouter la demande par WS  ${args_demande_alert_pre_instruction1}  ${args_petitionnaire_alert_pre_instruction1}

    Depuis la page d'accueil  delai_pre_inst_polycomm  delai_pre_inst_polycomm
    Element Should Contain  css=#dossier_dossiers_pre_instruction_0  ${di_alert_pre_instruction}
    Element Should Contain  css=#dossier_dossiers_pre_instruction_1  ${di_alert_pre_instruction1}

    Depuis la page d'accueil  delai_pre_inst  delai_pre_inst
    Element Should Contain  css=.widget_dossiers_pre_instruction  Vous n'avez aucun dossier d'instruction à qualifier dont la date limite de notification du délai au pétitionnaire arrive bientôt à échéance.

    # On change le filtre sur 'aucun'
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  filtre=aucun  dossiers_pre_instruction

    Depuis la page d'accueil  delai_pre_inst  delai_pre_inst
    Element Should Contain  css=#dossier_dossiers_pre_instruction_0  ${di_alert_pre_instruction}
    Element Should Contain  css=#dossier_dossiers_pre_instruction_1  ${di_alert_pre_instruction1}
    Click Element  css=.widget_dossiers_pre_instruction .widget-footer a
    Page Title Should Be  Instruction > Dossiers À Qualifier (limite De La Notification Du Délai)
    Element Should Contain  css=#tab-dossiers_pre_instruction  ${di_alert_pre_instruction}
    Element Should Contain  css=#tab-dossiers_pre_instruction  ${di_alert_pre_instruction1}

    # On met un filtre sur les PCI
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  filtre=aucun\ncodes_datd=PCI  dossiers_pre_instruction
    # L'utilisateur ne possède que des CU donc il ne doit pas y avoir de dossier.
    Depuis la page d'accueil  delai_pre_inst_polycomm  delai_pre_inst_polycomm
    Element Should Contain  css=.widget_dossiers_pre_instruction  Vous n'avez aucun dossier d'instruction à qualifier dont la date limite de notification du délai au pétitionnaire arrive bientôt à échéance.

    &{args_petitionnaire_alert_pre_instruction2} =  Create Dictionary
    ...  particulier_nom=045TESTDELAIPREINSTRUCTIONNOM2
    ...  particulier_prenom=045TESTDELAIPREINSTRUCTIONPRENOM2
    ...  om_collectivite=TESTNOTIFICATIONDELAI
    &{args_demande_alert_pre_instruction2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  date_demande=${date_di}
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=TESTNOTIFICATIONDELAI
    ${di_alert_pre_instruction2} =  Ajouter la demande par WS  ${args_demande_alert_pre_instruction2}  ${args_petitionnaire_alert_pre_instruction2}

    Depuis la page d'accueil  delai_pre_inst  delai_pre_inst
    Element Should Contain  css=#dossier_dossiers_pre_instruction_0  ${di_alert_pre_instruction2}

    Depuis la page d'accueil  delai_pre_inst_polycomm  delai_pre_inst_polycomm
    Element Should Contain  css=#dossier_dossiers_pre_instruction_0  ${di_alert_pre_instruction2}
    # On clique sur Voir + pour vérifier que les dossiers sont présents
    Click Element  css=.widget_dossiers_pre_instruction .widget-footer a
    Page Title Should Be  Instruction > Dossiers À Qualifier (limite De La Notification Du Délai)
    Element Should Not Contain  css=#tab-dossiers_pre_instruction  ${di_alert_pre_instruction}
    Element Should Not Contain  css=#tab-dossiers_pre_instruction  ${di_alert_pre_instruction1}
    Element Should Contain  css=#tab-dossiers_pre_instruction  ${di_alert_pre_instruction2}

    # On met un filtre de division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  filtre=division  dossiers_pre_instruction
    #On vérifie que seulement les dossier de la division de l'utilisateur sont présentes
    Depuis la page d'accueil  delai_pre_inst_polycomm  delai_pre_inst_polycomm
    Element Should Contain  css=#dossier_dossiers_pre_instruction_0  ${di_alert_pre_instruction}
    Element Should Contain  css=#dossier_dossiers_pre_instruction_1  ${di_alert_pre_instruction1}
    Page Should Not Contain  ${di_alert_pre_instruction2}
    # De même dans Voir +
    Click Element  css=.widget_dossiers_pre_instruction .widget-footer a
    Page Title Should Be  Instruction > Dossiers À Qualifier (limite De La Notification Du Délai)
    Element Should Not Contain  css=#tab-dossiers_pre_instruction  ${di_alert_pre_instruction2}
    Element Should Contain  css=#tab-dossiers_pre_instruction  ${di_alert_pre_instruction}
    Element Should Contain  css=#tab-dossiers_pre_instruction  ${di_alert_pre_instruction1}

    # Test l'affichage du widget avec un nombre plutôt qu'une liste
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  filtre=division\naffichage=nombre  dossiers_pre_instruction

    Depuis la page d'accueil  delai_pre_inst_polycomm  delai_pre_inst_polycomm
    Element Should Contain  css=.widget_dossiers_pre_instruction span.bg-info  2

    # Test du filtrage par instructeur secondaire
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  filtre=instructeur_secondaire\naffichage=nombre  dossiers_pre_instruction

    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Element Should Contain  css=.widget_dossiers_pre_instruction span.bg-info  3

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  ${EMPTY}  dossiers_pre_instruction


TNR Vérifier que la pagination fonctionne pour le widget "Derniers dossiers déposés"
    [Documentation]  Suite à un bug concernant la pagination du listing du widget "Derniers dossiers déposés"
    ...  on vérifie que cette pagination fonctionne correctement

    # On crée une collectivité, ses divisions et ses instructeurs
    # pour ne pas perturber ni être perturbé par les autres tests.
    #
    Depuis la page d'accueil  admin  admin
    #
    Ajouter la collectivité depuis le menu  DDD  mono
    Ajouter la direction depuis le menu  DDD  DDD  null  Chef DDD  null  null  DDD
    Ajouter la division depuis le menu  SB11  subdivision SB11  null
    ...  Chef DDD  null  null  DDD

    Ajouter l'utilisateur  Poter Pun  nospam@openmairie.org  ppun  ppun  INSTRUCTEUR  DDD

    Ajouter l'instructeur depuis le menu  Poter Pun  subdivision SB11  instructeur  Poter Pun
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Poter Pun (SB11)
    ...  om_collectivite=DDD
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # On ajoute le droit au profil instructeur
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu si il n'existe pas  derniers_dossiers_deposes  INSTRUCTEUR


    # On paramètre le widget :
    # DATD: PCI et PD
    # Filtre division
    # Intervalle de date de dépôt: 15 jours
    # type de dépôt: dépôt électronique
    Depuis le contexte du widget  derniers_dossiers_deposes
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments
    ...  codes_datd=PCI;PD\nfiltre=division\nfiltre_depot=depot_electronique\nnombre_de_jours=15
    Click On Submit Button

    # On ajoute le widget au tableau de bord des instructeurs
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  INSTRUCTEUR
    Input Text  bloc  C1
    Select From List By Label  om_widget  Les derniers dossiers déposés
    Click On Submit Button

    # On vérifie que le widget n'indique aucun dossier déposé
    Depuis la page d'accueil  ppun  ppun
    Element Should Contain  css=.widget_derniers_dossiers_deposes .widget-content
    ...  Aucun dossier déposé dernièrement.

    # On doit ajouter 16 dossiers afin de pouvoir utiliser la page suivant dans le listing de "Voir +"
    # du widget.
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Applefield
    ...  particulier_prenom=Nadia
    ...  om_collectivite=DDD
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=DDD
    ...  depot_electronique=true
    # TODO : faire une boucle pour ajouter les demandes
    ${di_01} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_02} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_03} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_04} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_05} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_06} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_07} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_08} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_09} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_10} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_11} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_12} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_13} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_14} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_15} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_16} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  ppun  ppun
    # On accède au "Voir +"
    Click Element  css=.widget_derniers_dossiers_deposes .widget-footer a
    Wait Until Page Contains Element  css=.pagination-next
    # On change de page
    Click Element  css=.pagination-next
    Wait Until Element Contains  css=div.pagination-nb  16 -
    # On doit trouver le dernier dossier ajouté
    Element Should Contain  css=td.col-3 a.lienTable  ${di_16}

    #Supprimer le droit ajouté en début de test pour revenir en condition initiale
    Depuis la page d'accueil  admin  admin
    Depuis le listing des droits
    Use Simple Search  libellé  derniers_dossiers_deposes
    Select From List By Label  name=selectioncol  Tous
    Click Element  css=button#search-submit
    Wait Until Element Is Visible  css=table.tab-tab
    Click On Link  INSTRUCTEUR
    Click On Form Portlet Action  om_droit  supprimer
    Click On Submit Button


TNR Vérifier que les widget de recherche de dossier fonctionne si le nom du dossier a une minuscule
    [Documentation]  Suite à un bug concernant les widget de recherche de dossier
    ...  on vérifie que cette recherche fonctionne correctement

    Depuis la page d'accueil  admin  admin

    # On ajoute le widget au tableau de bord des admin
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  Recherche accès direct
    Click On Submit Button

    # Paramètre l'appli pour pouvoir choisir le nom du dossier
    &{param_values} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # On ajoute deux dossier contenant des minuscules dans leur nom
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Applefield
    ...  particulier_prenom=Nadia
    ...  om_collectivite=agglo
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=agglo
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}
    # Activer la saisie du numéro de dossier
    Click Element Until New Element  css=#num_doss_manuel  css=div.bloc_num_manu
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#num_doss_sequence
    # Saisie du numéro de dossier avec une lettre en minuscule
    Wait Until Element Is Visible  css=#num_doss_division
    Input Text  css=#num_doss_division  a
    Validation du formulaire de la demande
    # On récupère le libelle du dossier d'instruction
    ${libelle_di} =  Get Text  new_di

    # On effectue une recherche à l'aide du widget
    Go To Dashboard
    Input Text  css=#widget_recherche_dossier_form input#dossier  ${libelle_di}
    Click Element  css=#widget_recherche_dossier_form input.om-button
    Page should not contain  Droit insuffisants
    Element Should Contain  css=#dossier_libelle  ${libelle_di}

    #Supprime le paramètre de saisie du nom des dossiers
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_saisie_numero
    ...  click_value=option_dossier_saisie_numero
    Supprimer le paramètre (surcharge)  ${param_values}

TNR Vérifier que le widget mes messages prend ou ne prend pas en compte les messages des dossiers cloturer en fonction d'un argument
    [Documentation]  Vérifie que si des messages sont marquées comme "non lu" dans un
    ...  dossier cloturer, il ne sont pas compté sur le widget "mes messages"

    Depuis la page d'accueil  admin  admin

    # paramétrage du widget comme le widget a un nom similaire a celui d'un autre
    # on utilise son id pour l'identifier
    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun
    Modifier le widget  4  ${args_om_widget}

    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Rivière
    ...  particulier_prenom=Coralie
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'une pièce pour avoir un message de notication de l'instructeur
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    # Ajout d'un nouveau dossier pour toujours avoir accès au voir+ du widget
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Jean
    ...  particulier_prenom=Neimar
    ...  om_collectivite=MARSEILLE
    ${di_non_cloture} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'une pièce pour avoir un message de notication de l'instructeur
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di_non_cloture}  ${document_numerise_values}

    # Vérification de la prise en compte du message dans le widget avec
    # un profil instructeur
    Depuis la page d'accueil  instr  instr
    Go to dashboard
    Click Element  css=div.widget_messages_retours div.widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    css=div#tab-messages_tous_retours form#advanced-form input  ${di}
    Element Should Contain  css=#tab-messages_tous_retours  ${di}

    # Cloture du dossier
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve
    Ajouter une instruction au DI  ${di}  cloture suite a transfert accepte

    # Vérification de l'affichage du widget
    Go to dashboard
    Click Element  css=div.widget_messages_retours div.widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    css=div#tab-messages_tous_retours form#advanced-form input  ${di}
    Element Should Not Contain  css=#tab-messages_tous_retours  ${di}

    # modifier le widget mes messages, 
    Depuis la page d'accueil  admin  admin

    &{args_om_widget} =  Create Dictionary
    ...  arguments=filtre=aucun\ndossier_cloture=true
    Modifier le widget  4  ${args_om_widget}

    Depuis la page d'accueil  instr  instr
    Go to dashboard
    Click Element  css=div.widget_messages_retours div.widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    css=div#tab-messages_tous_retours form#advanced-form input  ${di}
    # verifier que le $di existe dans le widget
    Element Should Contain  css=#tab-messages_tous_retours  ${di}

    # Remet le paramétrage de base du widget
    Depuis la page d'accueil  admin  admin
    &{args_om_widget} =  Create Dictionary
    ...  arguments=${EMPTY}
    Modifier le widget  4  ${args_om_widget}


TNR vérifier que le listing du widget derniers dossiers déposés n'affiche pas de doublon
    # On crée une collectivité, ses divisions et ses instructeurs
    # pour ne pas perturber ni être perturbé par les autres tests.
    #
    Depuis la page d'accueil  admin  admin
    #
    Ajouter la collectivité depuis le menu  EEE  mono
    Ajouter la direction depuis le menu  EEE  EEE  null  Chef EEE  null  null  EEE
    Ajouter la division depuis le menu  SB12  subdivision SB12  null
    ...  Chef EEE  null  null  EEE

    Ajouter l'utilisateur  Poter Pin  nospam@openmairie.org  ppin  ppin  INSTRUCTEUR  EEE

    Ajouter l'instructeur depuis le menu  Poter Pin  subdivision SB12  instructeur  Poter Pin
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Poter Pin (SB12)
    ...  om_collectivite=EEE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # On ajoute le droit au profil instructeur
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu si il n'existe pas  derniers_dossiers_deposes  INSTRUCTEUR

    Depuis le contexte du widget  derniers_dossiers_deposes
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments
    ...  codes_datd=PCI;PD\nfiltre=division\nfiltre_depot=depot_electronique\nnombre_de_jours=15
    Click On Submit Button

    # On ajoute le widget au tableau de bord des instructeurs
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  INSTRUCTEUR
    Input Text  bloc  C1
    Select From List By Label  om_widget  Les derniers dossiers déposés
    Click On Submit Button

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=045WIDGETDOUBLONNOM
    ...  particulier_prenom=045WIDGETDOUBLONPRENOM
    ...  om_collectivite=EEE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=EEE
    ...  depot_electronique=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Ajouter un message dans le dossier d'instruction  ${di}  Test doublon message 1
    Ajouter un message dans le dossier d'instruction  ${di}  Test doublon message 2


    Depuis la page d'accueil  ppin  ppin
    # On accède au "Voir +"
    Click Element  css=.widget_derniers_dossiers_deposes .widget-footer a

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=.pagination-nb .pagination-text  1 - 1 enregistrement(s) sur 1

    #Supprimer le droit ajouté en début de test pour revenir en condition initiale
    Depuis la page d'accueil  admin  admin
    Supprimer le droit depuis le contexte du profil  derniers_dossiers_deposes  INSTRUCTEUR


Rendre les types de dossier d'autorisation détaillés utilisés transmissible à Plat'AU
    [Documentation]  Il est nécessaire de faire cette manipulation pour tous les tests liés à la transmission à Plat'AU.
    ...  Si cette case n'est pas coché, il n'y a pas d'ajout de tâche sur le type de da détaillé concerné.
    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}


Widget de controle de donnee
    [Documentation]  Ce test permet de vérifier que le widget de contrôle de données
    ...  affiche bien les éléments 

    Depuis la page d'accueil  admin  admin
    # Isolation du contexte
    Ajouter la collectivité depuis le menu  FFF  mono
    Ajouter la direction depuis le menu  FFF  FFF  null  Chef FFF  null  null  FFF
    Ajouter la division depuis le menu  SB13  subdivision SB13  null
    ...  Chef FFF  null  null  FFF

    # Ajout d'un instructeur secondaire à affecter aux dossiers
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire_dntp
    Ajouter l'utilisateur  ${instructeur_secondaire_login}  nospam@openmairie.org  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}  INSTRUCTEUR  FFF
    Ajouter l'instructeur depuis le menu  ${instructeur_secondaire_login}  subdivision SB13  instructeur  ${instructeur_secondaire_login}

    # Ajout de 2 instructeur de même division, un rattaché au dossier l'autre non pour tester
    # le filtre par division
    Ajouter l'utilisateur  Gilbert Wyatt  nospam@openmairie.org  gwyatt  gwyatt  INSTRUCTEUR  FFF

    Ajouter l'instructeur depuis le menu  Gilbert Wyatt  subdivision SB13  instructeur  Gilbert Wyatt
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Gilbert Wyatt (SB13)
    ...  instructeur_2=${instructeur_secondaire_login} (SB13)
    ...  om_collectivite=FFF
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    Ajouter l'affectation depuis le menu  ${args_affectation}

    Ajouter l'utilisateur  Jean Dubois  nospam@openmairie.org  jdubois  jdubois  INSTRUCTEUR  FFF
    Ajouter l'instructeur depuis le menu  Jean Dubois  subdivision SB13  instructeur  Jean Dubois

    # Création de nouveau dossier incomplet (non transmissible plat'AU)
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=WTRANSMISSIONPLATAUNOM
    ...  particulier_prenom=WTRANSMISSIONPLATAUPRENOM
    ...  om_collectivite=FFF
    ...  localite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=FFF
    ...  depot_electronique=true
    ${di_FFF} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=AUTRENOM
    ...  particulier_prenom=AUTREPRENOM
    ...  om_collectivite=MARSEILLE
    ...  localite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  depot_electronique=true
    ${di_Marseille} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Connexion avec l'instructeur
    Depuis la page d'accueil  gwyatt  gwyatt
    # On accède au "Voir +"
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.widget_controle_donnee .widget-footer a
    # Par défaut les dossiers sont filtrés par instructeur donc seul le premier est visble dans la liste
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossier_non_transmis table  WTRANSMISSIONPLATAUNOM
    Element Should Not Contain  css=#tab-dossier_non_transmis table  AUTRENOM

    # Connexion avec l'autre instructeur
    Depuis la page d'accueil  jdubois  jdubois
    # Par défaut les dossiers sont filtrés par instructeur donc non visible par le 2eme instructeur
    Element Should Contain  css=.widget_controle_donnee  Aucun dossier non transmis pour le moment. 

    # Connexion avec l'instructeur secondaire
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    # Par défaut les dossiers sont filtrés par instructeur donc non visible par l'instructeur secondaire
    Element Should Contain  css=.widget_controle_donnee  Aucun dossier non transmis pour le moment. 

    # Filtrage par division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=division
    ...  controle_donnee

    # Les dossiers sont filtrés par division donc visible par les 3 instructeurs
    Depuis la page d'accueil  jdubois  jdubois
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.widget_controle_donnee .widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossier_non_transmis table  WTRANSMISSIONPLATAUNOM
    Element Should Not Contain  css=#tab-dossier_non_transmis table  AUTRENOM

    Depuis la page d'accueil  gwyatt  gwyatt
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.widget_controle_donnee .widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossier_non_transmis table  WTRANSMISSIONPLATAUNOM
    Element Should Not Contain  css=#tab-dossier_non_transmis table  AUTRENOM

    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.widget_controle_donnee .widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossier_non_transmis table  WTRANSMISSIONPLATAUNOM
    Element Should Not Contain  css=#tab-dossier_non_transmis table  AUTRENOM

    # Filtrage par instructeur secondaire
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur_secondaire
    ...  controle_donnee

    # Les dossiers sont visibles par l'instructeur secondaire et pas par les instricteur du dossier
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.widget_controle_donnee .widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossier_non_transmis table  WTRANSMISSIONPLATAUNOM
    Element Should Not Contain  css=#tab-dossier_non_transmis table  AUTRENOM

    Depuis la page d'accueil  jdubois  jdubois
    # Par défaut les dossiers sont filtrés par instructeur donc non visible par l'instructeur secondaire
    Element Should Contain  css=.widget_controle_donnee  Aucun dossier non transmis pour le moment. 

    # Aucun filtrage
    #Depuis la page d'accueil  admin  admin
    #Depuis le contexte du widget  controle_donnee
    #Click On Form Portlet Action    om_widget    modifier
    #Input Text    arguments
    #...  filtre=aucun
    #Click On Submit Button

    # Les dossiers ne sont pas filtrés donc visible par tous
    #Depuis la page d'accueil  gwyatt  gwyatt
    #Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.widget_controle_donnee .widget-footer a
    #Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossier_non_transmis table  WTRANSMISSIONPLATAUNOM
    #Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossier_non_transmis table  AUTRENOM 

    # Affichage avec bulle
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du widget  controle_donnee
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments
    ...  filtre=instructeur\naffichage=nombre
    Click On Submit Button

    # Affichage de la bulle avec le nombre 1 (1 seul dossier)
    Depuis la page d'accueil  gwyatt  gwyatt
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Text Should Be  css=.widget_controle_donnee .box-icon  1

    # On complète le dossier pour qu'il soit transmissible
    Depuis le contexte du dossier d'instruction  ${di_FFF}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    Open fieldset In Subform  donnees_techniques  engagement-du-declarant
    Input Text  enga_decla_lieu  MARSEILLE
    Input Datepicker  enga_decla_date  ${date_ddmmyyyy}
    Click On Submit Button In Subform
    
    &{args_di} =  Create Dictionary
    ...  terrain_adresse_localite=MARSEILLE 
    Modifier le dossier d'instruction  ${di_FFF}  ${args_di}


    # Vérifie que le dossier n'apparaît plus dans le widget
    Go To Dashboard
    Element Should Not Contain  css=.widget_controle_donnee  WTRANSMISSIONPLATAUNOM

    # On complète le dossier pour qu'il soit transmissible
    Depuis le contexte du dossier d'instruction  ${di_FFF}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    Open fieldset In Subform  donnees_techniques  engagement-du-declarant
    Input Text  enga_decla_lieu  MARSEILLE
    Input Datepicker  enga_decla_date  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    &{args_di} =  Create Dictionary
    ...  terrain_adresse_localite=${EMPTY}
    Modifier le dossier d'instruction  ${di_FFF}  ${args_di}


TNR Vérification qu'il n'y a pas de doublon sur le widget de contrôle de donnée
    # Ce test case est lié à celui d'audessus
    # Vérification qu'il n'y a pas de doublon dans les dossiers sur le widget "dossiers non 
    # transmis à Plat'au"
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Bouchakour
    ...  particulier_prenom=Amine

    &{args_architecte_lc} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Monsieur-l'archi
    ...  particulier_prenom=l'archi

    Go To Dashboard
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.widget_controle_donnee .widget-footer a

    Click On Link  WTRANSMISSIONPLATAUNOM WTRANSMISSIONPLATAUPRENOM
    ${num_di} =  Get Text  css=#dossier_libelle
    Click On Form Portlet Action  dossier_instruction  modifier
    # Ajout pétitionnaire
    Open Fieldset  dossier_instruction    demandeur
    Ajouter le demandeur  petitionnaire  ${args_petitionnaire}
    # # Ajout architecte
    Ajouter le demandeur  architecte_lc  ${args_architecte_lc}
    Click On Submit Button

    Go To Dashboard

    # Comparaison du nombre de dossier par rapport à 1 WIDGET
    ${nb_dossier_bulle_widget}=  Get Text  css=.widget_controle_donnee .box-icon
    Should Be Equal  ${nb_dossier_bulle_widget}  1

    # On accède au "Voir +"
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.widget_controle_donnee .widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tab-dossier_non_transmis table  WTRANSMISSIONPLATAUNOM
    # On récupère le numéro du dossier et on le compare
    ${num_dossier_widget}=  Get Text  css=td.col-3 a.lienTable
    Should Be Equal  ${num_dossier_widget}  ${num_di}
    # Ensuite on vérifie qu'il n'y a bien qu'une seule occurence pour ce dossier
    ${nb_enregistrement}=  Get Text  css=.pagination-text
    Should Be Equal  ${nb_enregistrement}  1 - 1 enregistrement(s) sur 1


Widget de suivi de transferts
    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # On ajoute le droit au profil instructeur
    Ajouter le droit depuis le menu  suivi_tache  INSTRUCTEUR

    # Ajout d'un instructeur secondaire à affecter aux dossiers
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire_st
    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WIDGET_TACHE
    ...  departement=085
    ...  commune=145
    ...  insee=85145
    ...  direction_code=GR
    ...  direction_libelle=Direction de LIBRECOM_WIDGET_TACHE
    ...  direction_chef=Chef
    ...  division_code=GR
    ...  division_libelle=Division GR
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Lhalil Kibr
    ...  guichet_om_utilisateur_email=lkibr@openads-test.fr
    ...  guichet_om_utilisateur_login=lkibr
    ...  guichet_om_utilisateur_pwd=lkibr
    ...  instr_om_utilisateur_nom=Lomir Kamb
    ...  instr_om_utilisateur_email=lkamb@openads-test.fr
    ...  instr_om_utilisateur_login=lkamb
    ...  instr_om_utilisateur_pwd=lkamb
    ...  instr_2_om_utilisateur_nom=${instructeur_secondaire_login}
    ...  instr_2_om_utilisateur_email=${instructeur_secondaire_login}@test.fr
    ...  instr_2_om_utilisateur_login=${instructeur_secondaire_login}
    ...  instr_2_om_utilisateur_pwd=${instructeur_secondaire_login}
    ...  code_entite=LBCOM_255
    ...  acteur=LIBRECOM-ACT-255
    Isolation d'un contexte  ${librecom_values}

    Depuis le contexte de l'instructeur  Lomir Kamb
    ${id_instructeur} =  Get Text  css=#instructeur

    # Par défaut le filtre est sur instructeur
    Depuis la page d'accueil  admin  admin
    ${om_widget_libelle} =  Set Variable  TEST045WIDGETSUIVITACHE
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=suivi_tache
    ...  arguments=etat_tache=new\naffichage=liste\ntype_tache=creation_di
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=INSTRUCTEUR
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}


    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=AUTRENOMTACHE
    ...  particulier_prenom=AUTREPRENOMTACHE
    ...  om_collectivite=LIBRECOM_WIDGET_TACHE
    ...  localite=PLOP
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_TACHE
    ...  terrain_adresse_localite=PLOPPLOP
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Ajouter une instruction au DI  ${di}  Changer l'autorité compétente 'commune état'

    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve

    # Ajouter une pièce numérisée : ajout_piece
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=Test type document numerise de catégorie PLATAU
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    Depuis la page d'accueil  lkamb  lkamb

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=.widget_suivi_tache  ${di}

    Depuis la page d'accueil  admin  admin
    # On complète le dossier pour qu'il soit transmissible
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    Open fieldset In Subform  donnees_techniques  engagement-du-declarant
    Input Text  enga_decla_lieu  MARSEILLE
    Input Datepicker  enga_decla_date  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    Depuis la page d'accueil  lkamb  lkamb

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  ${di}

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  etat_tache=new\naffichage=liste\ntype_tache=creation_di;creation_da
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  lkamb  lkamb
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Création DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Création DA

    Click Element  css=.widget_suivi_tache .widget-footer a
    La page ne doit pas contenir d'erreur

    Page Should Contain  ${di}

    Click Element  css=.col-3
    La page ne doit pas contenir d'erreur

    # On test les autres filtres
    # Filtre sur tache de flux input ne dois rien afficher dans le widget
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  etat_tache=new\naffichage=liste\ntype_tache=creation_di;creation_da\ncategorie_tache=platau\nflux_tache=input
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  lkamb  lkamb
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Aucun dossier répondant aux critères.

    # Filtre sur tache de flux output dois afficher des résultats
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  etat_tache=new\naffichage=liste\ntype_tache=creation_di;creation_da\ncategorie_tache=platau\nflux_tache=output
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  lkamb  lkamb
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Création DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Création DA

    # La categorie tache platau affiche Plat'AU dans le fil d'Arianne sur le listing du widget
    Click Element  css=.widget_suivi_tache .widget-footer a
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=#title  Suivi Des Transferts Plat'AU
    ${infobulle} =  Get Element Attribute  css=#infobulle-type  title
    Should Be Equal  ${infobulle}  Création DA : Création du projet\nCréation demande : Création du dossier d'instruction\nDépôt DI : Dépôt du dossier d'instruction\nModification DI : Modification du dossier d'instruction\nQualification DI : Permet le changement de compétence en état ou commune pour état\nDécision DI : Décision sur le dossier d'instruction\nIncomplétude DI : Incomplétude sur le dossier\nCompletude DI : Complétude sur le dossier\nAjout pièce (sortant) : Ajout d'une pièce au dossier\nAjout pièce (entrant) : Ajout d'une pièce au dossier\nCréation consultation : Création d'une consultation sur le dossier\nModification DA : Modification du projet\nEnvoi contrôle de légalité : Envoi contrôle de légalité\nCréation DI pour consultation : Ajour d'un dossier à partir d'une consultation entrante\nAvis : Avis sur une consultation\nPeC consultation : Prise en compte métier sur une consultation\nMessage : Ajout d'un message au dossier d'instruction \nPrescription : Création d'une préscription\nNotification récépissé : Notification du récépissé\nNotification instruction : Notification de l'instruction\nNotification décision : Notification de la décision\nNotification service consulté : Notification du service consulté\nNotification tiers : Notification du tiers\n

    # Filtre sur tache qualification DI, ajout_piece et decision di
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  etat_tache=new\naffichage=liste\ntype_tache=qualification_di;decision_di;ajout_piece\ncategorie_tache=platau\nflux_tache=output
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  lkamb  lkamb
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Qualification DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Décision DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Ajout pièce
    # Par défaut on fltre sur les instructeur, l'instructeur secondaire ne dois donc pas avoir de résultat
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=.widget_suivi_tache  Qualification DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=.widget_suivi_tache  Décision DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=.widget_suivi_tache  Ajout pièce

    # Filtre sur l'instructeur secondaire du dossier
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur_secondaire\netat_tache=new\naffichage=liste\ntype_tache=qualification_di;decision_di;ajout_piece\ncategorie_tache=platau\nflux_tache=output
    ...  ${om_widget_libelle}
    # L'instructeur secondaire dois voir les différentes tâches mais pas l'instructeur
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Qualification DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Décision DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.widget_suivi_tache  Ajout pièce
    Depuis la page d'accueil  lkamb  lkamb
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=.widget_suivi_tache  Qualification DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=.widget_suivi_tache  Décision DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=.widget_suivi_tache  Ajout pièce

    #Supprimer le droit ajouté en début de test pour revenir en condition initiale
    Depuis la page d'accueil  admin  admin
    Depuis le listing des droits
    Use Simple Search  libellé  suivi_tache
    Select From List By Label  name=selectioncol  Tous
    Click Element  css=button#search-submit
    Wait Until Element Is Visible  css=table.tab-tab
    Click On Link  INSTRUCTEUR
    Click On Form Portlet Action  om_droit  supprimer
    Click On Submit Button

Rendre les types de dossier d'autorisation détaillés utilisés non transmissible à Plat'AU
    [Documentation]  Il est nécessaire de faire cette manipulation pour revenir à un état normal
    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

Widget "Recherche paramétrable"
    [Documentation]  Permet de vérifier que le widget de recherche paramétrable
    ...  fonctionne correctement

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    ${om_widget} =  Set Variable  recherche_parametrable
    # Ajout d'un instructeur secondaire à affecter aux dossiers
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire_rp

    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WIDGET_RECHERCHE
    ...  departement=045
    ...  commune=188
    ...  insee=45188
    ...  direction_code=GA
    ...  direction_libelle=Direction de LIBRECOM_WIDGET_RECHERCHE
    ...  direction_chef=Chef
    ...  division_code=GA
    ...  division_libelle=Division GA
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Yhalil Gibr
    ...  guichet_om_utilisateur_email=ygibr@openads-test.fr
    ...  guichet_om_utilisateur_login=ygibr
    ...  guichet_om_utilisateur_pwd=ygibr
    ...  instr_om_utilisateur_nom=Yomir Tamb
    ...  instr_om_utilisateur_email=ytamb@openads-test.fr
    ...  instr_om_utilisateur_login=ytamb
    ...  instr_om_utilisateur_pwd=ytamb
    ...  instr_2_om_utilisateur_nom=${instructeur_secondaire_login}
    ...  instr_2_om_utilisateur_email=${instructeur_secondaire_login}@openads-test.fr
    ...  instr_2_om_utilisateur_login=${instructeur_secondaire_login}
    ...  instr_2_om_utilisateur_pwd=${instructeur_secondaire_login}
    ...  code_entite=LBCOM_25
    ...  acteur=LIBRECOM-ACT-25
    Isolation d'un contexte  ${librecom_values}

    Depuis le contexte de l'instructeur  Yomir Tamb
    ${id_instructeur} =  Get Text  css=#instructeur
    Depuis le contexte de l'instructeur  ${instructeur_secondaire_login}
    ${id_instructeur_secondaire} =  Get Text  css=#instructeur

    # Par défaut le filtre est sur instructeur
    Depuis la page d'accueil  admin  admin
    ${om_widget_libelle} =  Set Variable  TEST045WIDGETRECHERCHEPARAMETRABLE
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=${om_widget}
    ...  arguments=etat=notifier\naffichage=nombre\ntri=-6
    ${id_om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=INSTRUCTEUR
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    Depuis la page d'accueil  ytamb  ytamb

    Element Should Contain  css=.widget_${om_widget} .widget-content
    ...  Aucun dossier trouvé.

    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_RECHERCHE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Rivière
    ...  particulier_prenom=Coralie
    ...  om_collectivite=LIBRECOM_WIDGET_RECHERCHE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  ytamb  ytamb

    Element Should Not Contain  css=.widget_${om_widget} .widget-content
    ...  Aucun dossier trouvé.

    Element Should Contain  css=.widget_${om_widget} .box-icon  1
    Element Should Contain  css=.widget_${om_widget}  Voir +

    Click Element  css=.widget_${om_widget} .widget-footer a
    La page ne doit pas contenir d'erreur

    Form Value Should Be  css=#adv-search-adv-fields #etat  notifier
    Form Value Should Be  css=#adv-search-adv-fields #instructeur  ${id_instructeur}

    # Filtrage avec l'instructeur secondaire
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  etat=notifier\naffichage=nombre\ntri=-6\nmessage_help=widget de test\nfiltre=instructeur_secondaire
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Element Should Contain  css=.widget_${om_widget} .box-icon  1
    Element Should Contain  css=.widget_${om_widget}  Voir +
    Click Element  css=.widget_${om_widget} .widget-footer a
    La page ne doit pas contenir d'erreur
    Form Value Should Be  css=#adv-search-adv-fields #etat  notifier
    Form Value Should Be  css=#adv-search-adv-fields #instructeur_2  ${id_instructeur_secondaire}

    Depuis la page d'accueil  ytamb  ytamb
    Element Should Contain  css=.widget_${om_widget} .widget-content
    ...  Aucun dossier trouvé.
    Element Should Not Contain  css=.widget_${om_widget}  Voir +

    # Filtrage avec la division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  etat=notifier\naffichage=nombre\ntri=-6\nmessage_help=widget de test\nfiltre=division
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  ytamb  ytamb

    Element Should Not Contain  css=.widget_${om_widget} .widget-content
    ...  Aucun dossier trouvé.

    Element Should Contain  css=.widget_${om_widget} .box-icon  1
    Element Should Contain  css=.widget_${om_widget}  Voir +

    Click Element  css=.widget_${om_widget} .widget-footer a
    La page ne doit pas contenir d'erreur

    Form Value Should Be  css=#adv-search-adv-fields #etat  notifier
    List Selection Should Be  css=#adv-search-adv-fields #division  ${librecom_values.division_libelle}

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  etat=rejeter\naffichage=nombre\ntri=-6\nmessage_help=widget de test\nfiltre=division
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  ytamb  ytamb

    Element Should Contain  css=.widget_recherche_parametrable .widget-content
    ...  Aucun dossier trouvé.
    Element Should Not Contain  css=.widget_recherche_parametrable  Voir +

    Depuis la page d'accueil  admin  admin
    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_RECHERCHE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Torrent
    ...  particulier_prenom=Magalie
    ...  om_collectivite=LIBRECOM_WIDGET_RECHERCHE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Ajouter une instruction au DI  ${di}  demande de pièces complémentaires sans majoration

    Depuis la page d'accueil  ytamb  ytamb

    Element Should Not Contain  css=.widget_${om_widget} .widget-content
    ...  Aucun dossier trouvé.

    Element Should Contain  css=.widget_${om_widget} .box-icon  1
    Element Should Contain  css=.widget_${om_widget}  Voir +

    Click Element  css=.widget_${om_widget} .widget-footer a
    La page ne doit pas contenir d'erreur

    Form Value Should Be  css=#adv-search-adv-fields #etat  rejeter
    List Selection Should Be  css=#adv-search-adv-fields #division  ${librecom_values.division_libelle}

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  etat=notifier\naffichage=nombre\ntri=-6\nmessage_help=widget de test\nfiltre=division\nsource_depot=platau
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  ytamb  ytamb

    Element Should Contain  css=.widget_${om_widget} .widget-content
    ...  Aucun dossier trouvé.
    Element Should Not Contain  css=.widget_${om_widget}  Voir +

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  etat=notifier\naffichage=nombre\ntri=-6\nmessage_help=widget de test\nfiltre=division\nsource_depot=app
    ...  ${om_widget_libelle}

    Depuis la page d'accueil  ytamb  ytamb

    Element Should Not Contain  css=.widget_${om_widget} .widget-content
    ...  Aucun dossier trouvé.

    Element Should Contain  css=.widget_${om_widget} .box-icon  1
    Element Should Contain  css=.widget_${om_widget}  Voir +

    Click Element  css=.widget_${om_widget} .widget-footer a
    La page ne doit pas contenir d'erreur

    Form Value Should Be  css=#adv-search-adv-fields #etat  notifier
    List Selection Should Be  css=#adv-search-adv-fields #division  ${librecom_values.division_libelle}
    List Selection Should Be  css=#adv-search-adv-fields #source_depot  app
    Element Should Contain  css=.pageDescription  widget de test

    # Vérification en condition similaire à "Derniers dossiers déposé via IDE'AU"
    Depuis la page d'accueil  admin  admin

    &{args_demande_ideau} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_RECHERCHE
    
    &{args_petitionnaire_ideau} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Rivière
    ...  particulier_prenom=Coralie
    ...  om_collectivite=LIBRECOM_WIDGET_RECHERCHE
    ${di} =  Ajouter la demande par WS  ${args_demande_ideau}  ${args_petitionnaire_ideau}

    Ajouter une instruction au DI  ${di}  demande de pièces complémentaires sans majoration

    Insérer les paramètres suivants dans le widget
    ...  etat=notifier\naffichage=nombre\ntri=-7\nfiltre=aucun\nsource_depot=app
    ...  ${om_widget_libelle}
    
    Depuis la page d'accueil  ytamb  ytamb

    Element Should Not Contain  css=.widget_${om_widget} .widget-content
    ...  Aucun dossier trouvé.
    
    ${nb_dossiers_deposes} =  Get Text  css=.widget_${om_widget} .size-h3.box-icon.rounded.bg-info
    Element Should Contain  css=.widget_${om_widget}  Voir +

    Click Element  css=.widget_${om_widget} .widget-footer a
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=span.pagination-text  enregistrement(s) sur ${nb_dossiers_deposes}
