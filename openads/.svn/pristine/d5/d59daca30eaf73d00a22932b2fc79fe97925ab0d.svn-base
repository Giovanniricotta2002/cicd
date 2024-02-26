*** Settings ***
Documentation     Suppression de dossier

# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown

# On inclut la librairie calendar de python
Library  calendar


*** Keywords ***
Activer le mode MC/ABF
    Depuis la page d'accueil  admin  admin

    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_option_mode_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_mode_service_consulte}
    &{param_option_om_collectivite_entity} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_om_collectivite_entity}
    &{param_option_dossier_saisie_numero_complet} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_dossier_saisie_numero_complet}


Désactiver le mode MC/ABF
    Depuis la page d'accueil  admin  admin

    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_option_mode_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_mode_service_consulte}
    &{param_option_om_collectivite_entity} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_om_collectivite_entity}
    &{param_option_dossier_saisie_numero_complet} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_dossier_saisie_numero_complet}


*** Test Cases ***
Setup

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin

    # Isolation du contexte
    &{collectivite_values} =  Create Dictionary
    ...  om_collectivite_libelle=Collectivité-supp-doss
    ...  departement=027
    ...  commune=363
    ...  insee=27363
    ...  direction_code=E
    ...  direction_libelle=Direction de Collectivité-supp-doss
    ...  direction_chef=Chef
    ...  division_code=L
    ...  division_libelle=Division L
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Chi Tah
    ...  guichet_om_utilisateur_email=ctah@openads-test.fr
    ...  guichet_om_utilisateur_login=ctah
    ...  guichet_om_utilisateur_pwd=ctah
    ...  instr_om_utilisateur_nom=Lo Fi
    ...  instr_om_utilisateur_email=lfi@openads-test.fr
    ...  instr_om_utilisateur_login=lfi
    ...  instr_om_utilisateur_pwd=lfi
    ...  code_entite=supp_doss
    ...  acteur=SP-DOS-0001
    Isolation d'un contexte  ${collectivite_values}
    Set Suite Variable  ${collectivite_values}

    Depuis le contexte de la collectivité  ${collectivite_values.om_collectivite_libelle}
    ${collectivite_id} =  Get Text  css=#om_collectivite
    Set Suite Variable  ${collectivite_id}

    # ajoute un administrateur général pour cette collectivité
    Ajouter l'utilisateur depuis le menu  Nol Bart  nol.bart@invalid.local  admingen-suppdoss  admingen-suppdoss  ADMINISTRATEUR GENERAL  Collectivité-supp-doss

    # ajout le code entité et acteur
    Ajouter le paramètre depuis le menu  code_entite  ${collectivite_values.code_entite}
    ...  ${collectivite_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte  ${collectivite_values.acteur}
    ...  ${collectivite_values.om_collectivite_libelle}

    # paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_PCI
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    &{param_type_demande_modificatif} =  Create Dictionary
    ...  libelle=param_type_demande_modificatif_PCI
    ...  valeur=DM
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_type_demande_modificatif}
    &{param_type_demande_transfert} =  Create Dictionary
    ...  libelle=param_type_demande_transfert_PCI
    ...  valeur=DT
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_type_demande_transfert}

    # rend l'instructeur polyvalent (nécessaire pour le droit de supprimer les dossiers)
    &{args_om_util} =  Create Dictionary
    ...  om_profil=INSTRUCTEUR POLYVALENT
    Modifier l'utilisateur depuis le menu  lfi  ${args_om_util}

    # même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=${collectivite_values.om_collectivite_libelle}
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # option_instructeur_division_numero_dossier
    &{param_option_instructeur_division_numero_dossier} =  Create Dictionary
    ...  libelle=option_instructeur_division_numero_dossier
    ...  valeur=true
    ...  om_collectivite=${collectivite_values.om_collectivite_libelle}
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_instructeur_division_numero_dossier}

    # Ajout d'une commune
    &{commune} =  Create Dictionary
    ...  typecom=COM
    ...  com=${collectivite_values.insee}
    ...  reg=20
    ...  dep=27
    ...  arr=363
    ...  ncc=Commune-supp-doss
    ...  nccenr=Commune-supp-doss
    ...  libelle=Commune-supp-doss
    ${commune_id} =  Ajouter commune avec dates validité  ${commune}
    Set Suite Variable  ${commune}
    Set Suite Variable  ${commune_id}


Suppression d'un dossier - mode MC/ABF - sans passer par Plat'au

    Activer le mode MC/ABF

    Depuis la page d'accueil  admin  admin

    # Activer l'option de suppression des dossiers
    &{options} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${options}

    # Ajouter un dossier : Création DA + Création demande + Dépôt DI
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=Collectivité-supp-doss
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  commune=${commune_id}
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=test036nom
    ...  particulier_prenom=test036prenom
    ...  om_collectivite=Collectivité-supp-doss
    ${di_libelle} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}
    ${di_se} =  Sans espace  ${di_libelle}
    ${da} =  Replace String Using Regexp  ${di_se}  [A-Z][0-9]+$  ${EMPTY}

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST036engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di_libelle}  ${donnees_techniques_values}

    # suppression du dossier
    Depuis la page d'accueil  lfi  lfi
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Supprimer le dossier d'instruction  ${di_libelle}
    Valid Message Should Be  La suppression a été correctement effectuée.

    # désactive le paramètre suppression dossier
    Depuis la page d'accueil  admin  admin
    &{param_option_suppression_dossier_instruction} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_suppression_dossier_instruction}

    Désactiver le mode MC/ABF


# Suppression d'un dossier - mode MC/ABF - avec service plat'au
# 
#     Activer le mode MC/ABF
# 
#     Depuis la page d'accueil  admin  admin
# 
#     # Activer l'option de suppression des dossiers
#     &{options} =  Create Dictionary
#     ...  libelle=option_suppression_dossier_instruction
#     ...  valeur=true
#     ...  om_collectivite=agglo
#     Ajouter ou modifier le paramètre depuis le menu  ${options}
# 
#     # Ajouter un service de type plat'au
#     &{service} =  Create Dictionary
#     ...  abrege=DC036
#     ...  libelle=Direction Circulation TEST036
#     ...  edition=Consultation - Pour conformité
#     ...  type_consultation=Pour conformité
#     ...  om_collectivite=Collectivité-supp-doss
#     ...  service_type=Plat'AU
#     ...  generate_edition=true
#     Ajouter le service depuis le listing  ${service}
# 
#     # Ajouter un dossier : Création DA + Création demande + Dépôt DI
#     &{args_dossier} =  Create Dictionary
#     ...  om_collectivite=Collectivité-supp-doss
#     ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
#     ...  demande_type=Dépôt Initial
#     ...  terrain_adresse_localite=TEST036AdresseLocalite
#     ...  commune=${commune_id}
#     &{args_petitionnaire1} =  Create Dictionary
#     ...  qualite=particulier
#     ...  particulier_nom=TEST036TASKNOM
#     ...  particulier_prenom=TEST036TASKPRENOM
#     ...  localite=TEST036Localite
#     ...  om_collectivite=Collectivité-supp-doss
#     ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}
#     ${di_se} =  Sans espace  ${di}
#     ${da} =  Replace String Using Regexp  ${di_se}  [A-Z][0-9]+$  ${EMPTY}
# 
#     &{donnees_techniques_values} =  Create Dictionary
#     ...  enga_decla_lieu=TEST036engadelalieu
#     ...  enga_decla_date=${date_ddmmyyyy}
#     Saisir les données techniques du DI  ${di}  ${donnees_techniques_values}
# 
# #     # Vérification status des tâches
# #     &{task_values} =  Create Dictionary
# #     ...  type=creation_DA
# #     ...  dossier=${da}
# #     ...  state=new
# #     ...  object_id=${da}
# #     ...  link_dossier=${da}
# #     ...  stream=output
# #     Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
# #     &{task_values} =  Create Dictionary
# #     ...  type=creation_DI
# #     ...  dossier=${di_se}
# #     ...  state=new
# #     ...  object_id=${di_se}
# #     ...  link_dossier=${di_se}
# #     ...  stream=output
# #     Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
# #     &{task_values} =  Create Dictionary
# #     ...  type=depot_DI
# #     ...  dossier=${di_se}
# #     ...  state=new
# #     ...  object_id=${di_se}
# #     ...  link_dossier=${di_se}
# #     ...  stream=output
# #     Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
# 
#     # Suppression de tous les objets
#     Supprimer le dossier d'instruction  ${di}
# 
#     # désactive le paramètre suppression dossier
#     Depuis la page d'accueil  admin  admin
#     &{param_option_suppression_dossier_instruction} =  Create Dictionary
#     ...  libelle=option_suppression_dossier_instruction
#     ...  valeur=false
#     ...  om_collectivite=agglo
#     Ajouter ou modifier le paramètre depuis le menu  ${param_option_suppression_dossier_instruction}
# 
# 
# Suppression d'un dossier - mode MC/ABF
# 
#     Activer le mode MC/ABF
# 
#     Depuis la page d'accueil  admin  admin
# 
#     # ajout paramètre suppression dossier
#     &{param_option_suppression_dossier_instruction} =  Create Dictionary
#     ...  libelle=option_suppression_dossier_instruction
#     ...  valeur=true
#     ...  om_collectivite=agglo
#     Ajouter ou modifier le paramètre depuis le menu  ${param_option_suppression_dossier_instruction}
# 
#     ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
#     ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-SPD-00
#     ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  SPD-000-00
#     ${json_payload} =  Replace String  ${json_payload}  13055  ${collectivite_values.insee}
#     ${json_payload} =  Replace String  ${json_payload}  "om_collectivite": "2"  "om_collectivite": "${collectivite_id}"
#     ${json_payload} =  Replace String  ${json_payload}  "annee": "20"  "annee": "22"
#     ${json_payload} =  Replace String  ${json_payload}  2020  2022
#     ${json_payload} =  Replace String  ${json_payload}  2021  2022
#     ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee} 20  0${collectivite_values.insee} 22
#     ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee}20  0${collectivite_values.insee}22
#     ${json_payload} =  Replace String  ${json_payload}  TEST300TASK  SUPPDOSS
#     ${json_payload} =  Replace String  ${json_payload}  P0  ${EMPTY}
#     ${json_payload} =  Replace String  ${json_payload}  07777  00001
#     ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${collectivite_values.acteur}
#     ${json_payload} =  Replace String  ${json_payload}  "terrain_references_cadastrales": ""  "terrain_references_cadastrales": "000AB0651"
#     ${payload_dict} =  To Json  ${json_payload}
#     ${task_values} =  Create Dictionary
#     ...  type=create_DI_for_consultation
#     ...  json_payload=${json_payload}
#     Ajouter la tâche par WS  ${task_values}
#     ${msg} =  Déclencher le traitement des tâches par WS
#     ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
#     ...  [^ ]{5}$  00001 ${collectivite_values.code_entite}01
#     ${da_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
#     ...  [^ ]{5}$  00001
#     ${di_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier"]}
#     ...  [^ ]{5}$  00001${collectivite_values.code_entite}01
#     ${da_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation"]}
#     ...  [^ ]{5}$  00001
#     ${di_regex} =  Catenate  .*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
#     ...  dossier instruction  '${di_lib_expected}'  .*$
#     ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
#     ${di_matches_len} =  Get Length  ${di_matches}
#     Should Be True  "${di_matches_len}" > "0"
#     Depuis le contexte du dossier d'instruction  ${di_lib_expected}
#     Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
#     ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
# #     Depuis le contexte du dossier d'autorisation  ${da_lib_expected}
# #     Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
# #     ...  Element Should Contain  css=#dossier_autorisation_libelle  ${da_lib_expected}
#     ${di_libelle} =  Set Variable  ${di_lib_expected}
# 
#     # suppression du dossier
#     Depuis la page d'accueil  lfi  lfi
#     Depuis le contexte du dossier d'instruction  ${di_libelle}
#     Portlet Action Should Be In Form  dossier_instruction  supprimer
#     Supprimer le dossier d'instruction  ${di_libelle}
#     Valid Message Should Be  La suppression a été correctement effectuée.
# 
#     # désactive le paramètre suppression dossier
#     Depuis la page d'accueil  admin  admin
#     &{param_option_suppression_dossier_instruction} =  Create Dictionary
#     ...  libelle=option_suppression_dossier_instruction
#     ...  valeur=false
#     ...  om_collectivite=agglo
#     Ajouter ou modifier le paramètre depuis le menu  ${param_option_suppression_dossier_instruction}
# 
#     Désactiver le mode MC/ABF
