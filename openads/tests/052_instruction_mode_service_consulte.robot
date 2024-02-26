*** Settings ***
Documentation  Test des événements d'instruction et de leur comportement spécifique au mode
...  service consulté.
...  L'activation et la désactivation du mode service consulté sont fait dans des tests cases
...  spécifique pour pouvoir être utilisé par tous les tests cases sans avoir besoin de les
...  réactivé / désactivé à chaque fois. Évite aussi qu'en cas de fail les autres tests
...  soient impactés.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Variables ***
${json_instruction_finalisation}  {"module":"instruction"}


*** Test Cases ***
Activation du mode service consulté
    [Documentation]  Activation des paramètres permettant de se mettre dans le même
    ...  environnement qu'un service consulté

    Depuis la page d'accueil  admin  admin
    # Activation du mode service consulté
    Activer le mode service consulté
    # Active option_dossier_commune
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    # Affichage du numéro d'entité dans le libellé du dossier
    &{param_entite} =  Create Dictionary
    ...  libelle=code_entite
    # Ajout d'un saut de ligne dans le code entité pour vérifier que les accès
    # aux dossiers sont toujours fonctionnels
    ...  valeur=${\n}TST
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${param_entite}
    &{param_entite} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=true
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${param_entite}
    # Active option_dossier_saisie_numero_complet
    # /!\ Cette option est nécessaire pour pouvoir avoir des dossiers de consultation
    # rattachée à un même dossier d'autorisation
    &{param_values} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    # Paramètre permettant de faire la correspondance entre le type de
    # demande noté dans les payload et le type de dossier à créer
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_PCI
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    # Ajout d'une commune
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=13013
    ...  reg=00
    ...  dep=13
    ...  arr=013
    ...  tncc=0
    ...  ncc=Test-tacite
    ...  nccenr=Test-tacite
    ...  libelle=Test-tacite
    ...  can=40
    ...  comparent=
    ...  om_validite_debut=07/04/2000
    Ajouter commune avec dates validité  ${com_values}


Gestion des tacites des consultations lorsqu'une consultation postérieure à un avis rendu
    [Documentation]  Créer deux dossiers lié à une consultation via le webservice. La
    ...  première consultation doit dater de plus de 3 mois. Un avis est ensuite rendu
    ...  sur la seconde consultation.
    ...  On applique ensuite le webservice de gestion des tacites. La première tâche ne
    ...  dois pas avoir son événement de tacite appliqué. 

    Depuis la page d'accueil  admin  admin
    ${uid_acteur_platau} =  set Variable  TST_TAC_CON
    &{om_param} =  Create Dictionary
    ...  libelle=platau_acteur_service_consulte
    ...  valeur=${uid_acteur_platau}
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    # Création du premier dossier et traitement des tâches
    &{payload_values} =  Create Dictionary
    ...  insee=13013
    ...  acteur=${uid_acteur_platau}
    ...  dossier_autorisation=EXT_UID_DA1
    ...  external_uids_dossier=EXT_UID_DI1
    ...  dossier_consultation=DOC_CON_001
    ${id_task1} =  Créer une tâche de type create_di_for_consultation  ${payload_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    # Ajout d'une instruction lié à un tacite
    &{advs_searc_di} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  particulier=CREATE_DI
    ...  parcelle=000XX0000
    Depuis le contexte du dossier d'instruction par la recherche avance  ${advs_searc_di}  MARSEILLE
    ${di_1ere_consultation} =  Get Text  css=#dossier_libelle
    Ajouter une instruction au DI et la finaliser  ${di_1ere_consultation}  ARRÊTÉ DE REFUS  false  13/09/1995
    # Modif de la date de saisie
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_finalisation_courrier  13/09/1995
    Click On Submit Button In Subform

    # Création du second dossier : Ajout d'une tâche de création de dossier pour consultation
    # et traitement de la tâche pour obtenir un deuxième DI lié au premier    
    &{payload_values} =  Create Dictionary
    ...  insee=13013
    ...  date_demande=2022-01-01
    ...  acteur=${uid_acteur_platau}
    ...  dossier_autorisation=EXT_UID_DA2
    ...  external_uids_dossier=EXT_UID_DI2
    ...  dossier_consultation=DOC_CON_002
    ...  date_consultation=2022-11-23
    ...  date_emission=2022-11-23
    ...  date_production_notification=2022-11-23
    ${id_task2} =  Créer une tâche de type create_di_for_consultation  ${payload_values}
    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS
    # Ajout d'une instruction lié à un tacite
    &{advs_searc_di} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  particulier=CREATE_DI
    ...  parcelle=000XX0000
    ...  dossier=*TST02*
    Depuis le contexte du dossier d'instruction par la recherche avance  ${advs_searc_di}  MARSEILLE
    ${di_2eme_consultation} =  Get Text  css=#dossier_libelle
    Ajouter une instruction au DI et la finaliser  ${di_2eme_consultation}  ARRÊTÉ DE REFUS  false  13/09/1995
    # Modif de la date de saisie
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_finalisation_courrier  13/09/1995
    Click On Submit Button In Subform
    # Déclenche le traitement du tacite => le premier dossier ne dois pas avoir son
    # événement tacite appliqué
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json_instruction_finalisation}  200  dossier(s) mis à jour.

    Depuis la page d'accueil  instr  instr
    # Vérifie que l'événement de tacite n'est pas visible dans les instructions du 1er dossier
    Depuis l'onglet instruction du dossier d'instruction  ${di_1ere_consultation}
    Page Should Not Contain  ARRÊTÉ DE REFUS 2
    # Vérifie que l'événement de tacite est bien présent dans les instructions du 2ème dossier
    Depuis l'onglet instruction du dossier d'instruction  ${di_2eme_consultation}
    Page Should Contain  ARRÊTÉ DE REFUS 2


Désactivation du mode service consulté
    [Documentation]  Désactive l'option "option_mode_service_consulte" pour ne pas impacter
    ...  le reste des tests.

    Depuis la page d'accueil  admin  admin
    # Désactivation du mode service consulté et suppression du paramétrage lié
    # au mode service consulté
    Désactiver le mode service consulté

    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}

    &{params} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=code_entite
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${params}

    &{params} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_om_collectivite_entity
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${params}

    &{params} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_saisie_numero_complet
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${params}

    &{params} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=platau_type_demande_initial_PCI
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${params}
