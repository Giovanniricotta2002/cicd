*** Settings ***
Documentation  Test de task.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Variables ***
${alternate_filestorage}  filestorage_plop

*** Test Cases ***
Rendre les types de dossier d'autorisation détaillés utilisés transmissible à Plat'AU
    [Documentation]  Il est nécessaire de faire cette manipulation pour tous les tests liés à la transmission à Plat'AU.
    ...  Si cette case n'est pas coché, il n'y a pas d'ajout de tâche sur le type de DA détaillé concerné.
    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    &{om_param} =  Create Dictionary
    ...  libelle=option_notification_piece_numerisee
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

Vérification du fonctionnement des tâches liées à une incompletude
    [Documentation]  Créer un dossier et lui ajoute une instruction d'incompletude.
    ...  Vérifie que les tâches incompletude_DI et lettre_incompletude sont crées après
    ...  la saisie des dates de l'instruction d'incompletude.
    ...  Supprimer l'instruction d'incompletude et vérifie que l'état de ses tâches
    ...  est bien ANNULÉ (canceled).

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Incom
    ...  particulier_prenom=Pletude
    ...  om_collectivite=MARSEILLE
    ...  localite=TEST301Localite
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_localite=TEST301AdresseLocalite
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_sans_espace} =  Sans espace  ${di}
    Depuis la page d'accueil  admin  admin
    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST301engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di}  ${donnees_techniques_values}
    # Constitution du workflow d'incompletude et ajout de l'instruction au dossier
    Constitution du Workflow de gestion d'une incomplétude  301
    ${instr_in} =  Ajouter une instruction au DI et la finaliser  ${di}  ${incompletude_libelle}  true
    # Il ne dois pas y avoir de tâche lié à cette instruction
    ${dates_value} =  Create Dictionary
    ...  dossier=${di_sans_espace}
    ...  object_id=${instr_in}
    Depuis le listing des tasks à partir de la recherche avancée  ${dates_value}
    Wait Until Element Contains  css=tr.tab-data  Aucun enregistrement.

    # Saisi des dates
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    ${dates_value} =  Create Dictionary
    ...  date_retour_signature=${CurrentDate}
    ...  date_envoi_rar=${CurrentDate}
    Modifier le suivi des dates  ${di}  ${incompletude_libelle}  ${dates_value}
    # Les tâches incompletude_DI et lettre_incompletude doivent exister
    ${id_next_inst} =  Convert To String  ${${instr_in}+${1}}
    &{task_values} =  Create Dictionary
    ...  type=incompletude_DI
    ...  dossier=${di_sans_espace}
    ...  state=new
    ...  object_id=${id_next_inst}
    ...  link_dossier=${di_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=lettre_incompletude
    ...  dossier=${di_sans_espace}
    ...  state=new
    ...  object_id=${id_next_inst}
    ...  link_dossier=${di_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    # Vérification des valeurs de la lettre d'incompletude
    Open Fieldset  task  json_payload-calculee
    Element Should Contain  css=pre#json_payload  "nomEtatLettre": "3"
    Element Should Contain  css=pre#json_payload  "nomModaliteNotifMetier": "4"
    Element Should Contain  css=pre#json_payload  "nomTypeLettre": "1"
    Element Should Contain  css=pre#json_payload  "nomTypeDocument": "3"

    # Suppression de l'instruction d'incompletude
    Supprimer l'instruction  ${di}  incompletude_notifiee_301
    # Les tâches doivent être à l'état annulé (canceled)
    &{task_values} =  Create Dictionary
    ...  type=incompletude_DI
    ...  dossier=${di_sans_espace}
    ...  state=canceled
    ...  object_id=${id_next_inst}
    ...  link_dossier=${di_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=lettre_incompletude
    ...  dossier=${di_sans_espace}
    ...  state=canceled
    ...  object_id=${id_next_inst}
    ...  link_dossier=${di_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

Vérification du fonctionnement des tâches liées à une majoration
    [Documentation]  Créer un dossier et lui ajoute une instruction de majoration du délai.
    ...  Vérifie que la tâche lettre_majoration est crée suite à l'ajout de l'instruction.
    ...  Supprimer l'instruction et vérifie que l'état de sa tâches est bien ANNULÉ (canceled).

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Ration
    ...  particulier_prenom=Majo
    ...  om_collectivite=MARSEILLE
    ...  localite=TEST301Localite
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_localite=TEST301AdresseLocalite
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_sans_espace} =  Sans espace  ${di}
    Depuis la page d'accueil  admin  admin
    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST301engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di}  ${donnees_techniques_values}
    ${lib_instr} =  Set Variable   commission nationale
    ${instr_in} =  Ajouter une instruction au DI  ${di}  ${lib_instr}
    # La tâche lettre_majoration doit exister
    &{task_values} =  Create Dictionary
    ...  type=lettre_majoration
    ...  dossier=${di_sans_espace}
    ...  state=new
    ...  object_id=${instr_in}
    ...  link_dossier=${di_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    # Vérification des valeurs de la lettre de majoration avant dépassement du délai
    Open Fieldset  task  json_payload-calculee
    Element Should Contain  css=pre#json_payload  "nomEtatLettre": "3"
    Element Should Contain  css=pre#json_payload  "nomModaliteNotifMetier": "4"
    Element Should Contain  css=pre#json_payload  "nomTypeLettre": "1"
    Element Should Contain  css=pre#json_payload  "nomTypeDocument": "3"

    # Vérification des valeurs de la lettre de majoration après dépassement du délai
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Ration AP1M
    ...  particulier_prenom=Majo
    ...  om_collectivite=MARSEILLE
    ...  localite=TEST301Localite
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=01/01/2023
    ...  terrain_adresse_localite=TEST301AdresseLocalite
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_sans_espace} =  Sans espace  ${di}
    Depuis la page d'accueil  admin  admin
    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST301engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di}  ${donnees_techniques_values}
    ${lib_instr} =  Set Variable   commission nationale
    ${instr_in} =  Ajouter une instruction au DI  ${di}  ${lib_instr}
    # La tâche lettre_majoration doit exister
    &{task_values} =  Create Dictionary
    ...  type=lettre_majoration
    ...  dossier=${di_sans_espace}
    ...  state=new
    ...  object_id=${instr_in}
    ...  link_dossier=${di_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    # Vérification des valeurs de la lettre de majoration avant dépassement du délai
    Open Fieldset  task  json_payload-calculee
    Element Should Contain  css=pre#json_payload  "nomEtatLettre": "3"
    Element Should Contain  css=pre#json_payload  "nomModaliteNotifMetier": "4"
    Element Should Contain  css=pre#json_payload  "nomTypeLettre": "4"
    Element Should Contain  css=pre#json_payload  "nomTypeDocument": "6"

    # Suppression de l'instruction de majoration
    Supprimer l'instruction  ${di}  ${lib_instr}
    # Les tâches doivent être à l'état annulé (canceled)
    &{task_values} =  Create Dictionary
    ...  type=lettre_majoration
    ...  dossier=${di_sans_espace}
    ...  state=canceled
    ...  object_id=${instr_in}
    ...  link_dossier=${di_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

Rendre les types de dossier d'autorisation détaillés utilisés non transmissible à Plat'AU
    [Documentation]  Il est nécessaire de faire cette manipulation pour revenir à un état normal
    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification_piece_numerisee
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
