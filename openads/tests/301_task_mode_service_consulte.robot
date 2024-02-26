*** Settings ***
Documentation  Test des tasks liées au mode service consulté.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Test Cases ***
SETUP
    [Documentation]  Préparation du jeu de données nécessaire au fonctionnement des tests.
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
    ...  valeur=TST
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
    # Active l'option d'affichage de la date de dépôt en mairie
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_date_depot_mairie
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    # Paramètre permettant de faire la correspondance entre le type de
    # demande noté dans les payload et le type de dossier à créer
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_PCI
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    # Ajout d'une commune
    Set Suite Variable  ${code_insee}  13014
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=${code_insee}
    ...  reg=00
    ...  dep=13
    ...  arr=013
    ...  tncc=0
    ...  ncc=Test-task-SC
    ...  nccenr=Test-task-SC
    ...  libelle=Test-task-SC
    ...  can=40
    ...  comparent=
    ...  om_validite_debut=01/01/0001
    Ajouter commune avec dates validité  ${com_values}
    set Suite Variable  ${uid_acteur_platau}  TST_TAC_CON
    &{om_param} =  Create Dictionary
    ...  libelle=platau_acteur_service_consulte
    ...  valeur=${uid_acteur_platau}
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

Erreur decodage de la payload lors de la récupération d'une tâches
    [Documentation]  Lorsqu'une tâche entrante est traitée, les valeurs de sa payload sont tronquées
    ...  pour respecter les limites de taille des champs. Si cette coupure est faite sur une '
    ...  (soit un &#39; dans la payload) cela provoque l'introduction de caractère spéciaux.
    ...  Le but de ce tests est de vérifier qu'après correction du décodage de la tâche lors
    ...  de sa récupération les ' sont correctement tronqué.



    # Ajoute d'une tâche avec une ' qui sera tronqué
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}payload_with_encoding_error.json
    ${json_payload} =  Replace String  ${json_payload}  "acteur": "EL0-JE1-2JO"  "acteur": "${uid_acteur_platau}"
    ${json_payload} =  Replace String  ${json_payload}  "insee": "06030"  "insee": "${code_insee}"
    ${json_payload} =  Replace String  ${json_payload}  "service_consultant_insee": "06030"  "service_consultant_insee": "${code_insee}"

    ${task_data_type} =  Create List  ${NONE}  create_DI_for_consultation
    ${task_data_payload} =  Create List  ${NONE}  ${json_payload}
    &{task_data} =  Create Dictionary
    ...  type=${task_data_type}
    ...  json_payload=${task_data_payload}
    ${COOKIE} =  Get Cookie  ${SESSION_COOKIE}
    ${cookies} =  Create Dictionary  ${SESSION_COOKIE}=${COOKIE.value}
    ${session} =  Set Variable  ${PROJECT_NAME}_web_ihm
    Create Session  ${session}  ${PROJECT_URL}  cookies=${cookies}
    ${response} =  Post Request  ${session}  /app/index.php?module=form&obj=task&action=996  files=${task_data}

    # get the task ID by parsing the response
    ${data} =  Decode Bytes To String  ${response.content}  UTF-8
    ${task_id_msg_matches} =  Get Regexp Matches  ${data}  Tâche ([0-9]+) ajoutée avec succès  1
    Length Should Be  ${task_id_msg_matches}  1
    ${task_id} =  Get From List  ${task_id_msg_matches}  0

    # Déclenchement du traitement de la tâche
    ${msg} =  Déclencher le traitement des tâches par WS

    # Récupère le numéro du dossier
    Depuis le contexte de la task  ${task_id}
    ${dossier_id_se} =  Get Text  css=#link_dossier_inactif
    # Vérification sur le dossier que ' apparaît bien
    &{seach_di_values} =  Create Dictionary
    ...  particulier=PLOP
    ...  om_collectivite=MARSEILLE
    ...  dossier=${dossier_id_se}
    Depuis le contexte du dossier d'instruction par la recherche avance  ${seach_di_values}  ${seach_di_values["om_collectivite"]}
    Open Fieldset  dossier_instruction  localisation
    Element Should Contain  css=#terrain_adresse_lieu_dit  Traverse de l'XX

Traitement d'une tâche creation DI for consultation avec une date mal formée
    [Documentation]  Lorsqu'une tâche entrante est traitée, les dates de sa payload sont formatées
    ...  pour que l'année soit toujours écrite sur 4 caractères.
    ...  Si l'année a moins de caractères alors le traitement de la tâche va échouer car la date
    ...  sera considéré comme mal formaté.

    # La date a des chiffres manquants ou une date au format incorrect
    &{payload_values} =  Create Dictionary
    ...  enga_decla_date=0220101
    ...  particulier_date_naissance=980-04-13
    ...  date_depot_mairie=2022-2-01
    ...  date_demande=2022-01-3
    ...  acteur=${uid_acteur_platau}
    ...  insee=${code_insee}
    ...  service_consultant_insee=${code_insee}
    ...  particulier_nom=TST TASK
    ...  particulier_prenom=FORMAT DATE
    Créer une tâche de type create_di_for_consultation  ${payload_values}
    # Traitement de la tâche
    ${msg} =  Déclencher le traitement des tâches par WS
    # Vérification de l'existence du dossier
    &{advs_searc_di} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  particulier=FORMAT DATE
    Depuis le contexte du dossier d'instruction par la recherche avance  ${advs_searc_di}  MARSEILLE

    # Vérification de la correction des dates
    # Cas 1 : année incorrecte
    Open Fieldset  dossier_instruction  demandeur
    Element Should Contain  css=.synthese_demandeur  13/04/0980
    # Cas 2 : mois incorrect
    Element Should Contain  css=#fieldset-form-dossier_instruction-instruction .instruction-suivi  01/02/2022
    # Cas 3 : jour incorrect
    Element Should Contain  css=#date_depot  03/01/2022
    # Cas 4 : format de date totalement erroné
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Open All Fieldset Using Javascript  donnees_techniques  sousform
    Element Should Contain  css=#fieldset-sousform-donnees_techniques-engagement-du-declarant  01/01/0001


    # Le format de la date est correct mais il manque un ou plusieurs des éléments. Ex : AAAA-MM-, AAAA--DD ou -MM-DD
    &{payload_values} =  Create Dictionary
    ...  enga_decla_date=-01-01
    ...  particulier_date_naissance=1980-04-
    ...  date_depot_mairie=2022--01
    ...  date_demande=2022-01-01
    ...  acteur=${uid_acteur_platau}
    ...  insee=${code_insee}
    ...  service_consultant_insee=${code_insee}
    ...  particulier_nom=TST TASK
    ...  particulier_prenom=#2 FORMAT DATE
    Créer une tâche de type create_di_for_consultation  ${payload_values}
    # Traitement de la tâche
    ${msg} =  Déclencher le traitement des tâches par WS
    # Vérification de l'existence du dossier
    &{advs_searc_di} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  particulier=#2 FORMAT DATE
    Depuis le contexte du dossier d'instruction par la recherche avance  ${advs_searc_di}  MARSEILLE

    # Vérification de la correction des dates
    # Cas 5 : date format AAAA-MM-
    Open Fieldset  dossier_instruction  demandeur
    Element Should Contain  css=.synthese_demandeur  01/01/0001
    # Cas 6 : date format AAAA--DD
    Element Should Contain  css=#fieldset-form-dossier_instruction-instruction .instruction-suivi  01/01/0001
    # Cas 7 : date format -MM-DD
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Open All Fieldset Using Javascript  donnees_techniques  sousform
    Element Should Contain  css=#fieldset-sousform-donnees_techniques-engagement-du-declarant  01/01/0001

TEARDOWN
    [Documentation]  Réinitialisation du jeu de données.

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
    ...  search_value=platau_type_demande_initial_DP
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${params}

    &{params} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=platau_acteur_service_consulte
    ...  click_value=${uid_acteur_platau}
    Supprimer le paramètre (surcharge)  ${params}


