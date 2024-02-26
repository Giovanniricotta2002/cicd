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
Activation de l'option 'option_notification_piece_numerisee'
    [Documentation]  Il est nécessaire de faire cette manipulation pour éviter le
    ...  FAIL: Element with locator 'dossier_message_id' not found.

    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_notification_piece_numerisee
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

Rendre les types de dossier d'autorisation détaillés utilisés transmissible à Plat'AU
    [Documentation]  Il est nécessaire de faire cette manipulation pour tous les tests liés à la transmission à Plat'AU.
    ...  Si cette case n'est pas coché, il n'y a pas d'ajout de tâche sur le type de da détaillé concerné.
    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}
    Modifier type de dossier d'autorisation détaillé  DP  ${args_type_DA_detaille_modification}

Verification calcul de l'instruction suivante lors de la récupération des id externes 
    [Documentation]  Ce test vérifie que depuis lors de la récuperation des id externes le calcul
    ...  le calcul de numero de dossier se fait bien.
    Depuis la page d'accueil  admin  admin
    @{type_di} =  Create List  PCI - P - Initial
    @{etat_source} =  Create List  delai de notification envoye
    # Création des événements
    &{args_evenement_ACCORD2} =  Create Dictionary
    ...  libelle=ACCORD 2
    ...  retour=true
    ...  action=accepter un dossier
    ...  etat=dossier accepter
    Ajouter l'événement depuis le menu  ${args_evenement_ACCORD2}

    &{args_evenement_ACCORD1} =  Create Dictionary
    ...  libelle=ACCORD 1
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=arrete ARRETE
    ...  evenement_retour_ar=ACCORD 2
    ...  avis_decision=Favorable
    Ajouter l'événement depuis le menu  ${args_evenement_ACCORD1}

    &{args_demande_auto} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire_auto} =  Create Dictionary
    ...  particulier_nom=SEPTIM
    ...  particulier_prenom=MARTIN
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande_auto}  ${args_petitionnaire_auto}

    # Création du dossier
    Ajouter une instruction au DI et la finaliser  ${di}  ${args_evenement_ACCORD1.libelle}
    
    Click Element  css=#main
    ${numdossier} =  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Get Text  css=#dossier_libelle
    ${numdossier_sans_espace} =  Sans espace  ${numdossier} 
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    &{args_instruction} =  Create Dictionary
    ...  date_retour_rar=${DATE_FORMAT_DD/MM/YYYY}
    Modifier le suivi des dates  ${di}  ACCORD 1  ${args_instruction}  
    Depuis le contexte de la task via numero de dossier et son type sur le moniteur Plat'AU  ${numdossier_sans_espace}  Décision DI
    Open Fieldset  task  json_payload-calculee
    Element Should Contain  css=#json_payload  "path"

Vérification de l'ajout des tasks creation_DA, creation_DI, depot_DI et qualification_DI lors de l'ajout d'un dossier d'instruction.
    [Documentation]  Permet de vérifier le bon fonctionnement de la création des tâches lié à la création d'un dossier d'instruction
    ...  Vérifie aussi qu'il n'y a pas de création d'autre tâche non concerné
    Depuis la page d'accueil  admin  admin
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300AdresseLocalite
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOM01
    ...  particulier_prenom=TEST300TASKPRENOM01
    ...  localite=TEST300Localite
    ...  om_collectivite=MARSEILLE
    ${di1} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di1}  ${donnees_techniques_values}

    Depuis le menu Moniteur Plat'AU

    ${di1_sans_espace} =  Sans espace  ${di1}
    ${di1_da} =  Replace String Using Regexp  ${di1_sans_espace}  [A-Z][0-9]+$  ${EMPTY}
    Set Suite Variable  ${di1}
    Set Suite Variable  ${di1_sans_espace}
    Set Suite Variable  ${di1_da}
    # On recherche l'enregistrement
    #
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#dossier
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#type
    # On remplit
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di1_da}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Création DA
    # On valide le formulaire de recherche
    Click On Search Button

    Element Should Contain  css=td.col-1 a.lienTable  Création DA
    Element Should Contain  css=td.col-4 a.lienTable  ${di1_da}

    # On remplit
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di1_da}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Création DI
    # On valide le formulaire de recherche
    Click On Search Button

    Element Should Contain  css=td.col-1 a.lienTable  Création DI
    Element Should Contain  css=td.col-4 a.lienTable  ${di1_da}

    # On remplit
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di1_da}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Dépôt DI
    # On valide le formulaire de recherche
    Click On Search Button

    Element Should Contain  css=td.col-1 a.lienTable  Dépôt DI
    Element Should Contain  css=td.col-4 a.lienTable  ${di1_da}

    # On remplit
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di1_da}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Qualification DI
    # On valide le formulaire de recherche
    Click On Search Button

    Element Should Contain  css=td.col-1 a.lienTable  Qualification DI
    Element Should Contain  css=td.col-4 a.lienTable  ${di1_da}

    Click On Link  ${di1_sans_espace}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#task
    ${id_depot_DI} =  Get Text  css=#task
    ${id_next_task} =  Evaluate  ${id_depot_DI} + 1
    Vérifier qu'il n'y a pas de création d'autre tâche non concerné  ${id_next_task}  ${di1_da}

Vérification de la mise à jour de la task Création demande lors de l'ajout des données techniques
    [Documentation]  Permet de vérifier que la tâche Création demande est mise à jour sur son state est à "à traiter" lors de la modification du DI
    ...  et qu'il n'y a pas de création de tache Modification DI, vérifie aussi que lors que la tache Création demande n'est pas en state "à traiter" 
    ...  il y a bien une création de la tâche Modification DI.
    ...  Vérifie également la création d'une tâche Modification DA lors de la modification des données techniques.
    Depuis la page d'accueil  admin  admin

    &{task_values} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${di1_da}
    ...  state=new
    ...  object_id=${di1_da}
    ...  link_dossier=${di1_da}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DA} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di1_sans_espace}
    ...  state=new
    ...  object_id=${di1_sans_espace}
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DI} =  Get Text  css=#task
    ${time_stamp_log} =  Get Text  css=#timestamp_log_jsontotab

    &{donnees_techniques_values} =  Create Dictionary
    ...  ope_proj_desc=Description test dossier parallele
    Saisir les données techniques du DI  ${di1}  ${donnees_techniques_values}
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    ${timestamp_log_changed} =  Get Text  css=#timestamp_log_jsontotab

    Should Not Be Equal As Strings  ${time_stamp_log}  ${timestamp_log_changed}

    Click On Back Button

    # On vérifie qu'il n'y pas de task Modification DI
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Modification DI
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Modification DI
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=#tab-task  Aucun enregistrement.

    &{task_values_modif} =  Create Dictionary
    ...  state=terminé
    Modifier la task  ${id_creation_DI}  ${task_values_modif}
    La page ne doit pas contenir d'erreur
    Modifier la task  ${id_creation_DA}  ${task_values_modif}
    La page ne doit pas contenir d'erreur

    &{donnees_techniques_values} =  Create Dictionary
    ...  ope_proj_desc=Description test dossier parallele BIS
    Saisir les données techniques du DI  ${di1}  ${donnees_techniques_values}
    La page ne doit pas contenir d'erreur

    &{task_values} =  Create Dictionary
    ...  type=modification_DI
    ...  dossier=${di1_sans_espace}
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}

    # &{task_values} =  Create Dictionary
    # ...  type=Modification DA
    # ...  dossier=${di1_da}
    # Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}


Vérification de l'ajout de la task qualification lors du changement de qualification d'un dossier d'instruction + modification manuelle d'une task
    [Documentation]  Permet de vérifier que la tâche Qualification DI est bien ajoutée lors du changement de l'autorité compétente.
    ...  Vérifie aussi qu'il n'y a pas de création d'autre tâche non concerné et que le object_id de la tâche pointe bien vers la
    ...  nouvelle instruction.
    ...  Dans un second temps, est vérifié la modification manuelle et son impact sur le timestamp_log.
    Depuis la page d'accueil  admin  admin
    ${instr_ac} =  Ajouter une instruction au DI  ${di1}  Changer l'autorité compétente 'commune état'
    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di1_sans_espace}
    ...  state=new
    ...  object_id=${instr_ac}
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${status} =  Run Keyword And Return Status  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload>legend  css=#json_payload
    Run Keyword If  '${status}' != 'True'  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload-calculee>legend  css=#json_payload
    Element Should Contain  css=#json_payload  "autorite_competente_code": "ETATMAIRE"

    Supprimer l'instruction  ${di1}  Changer l'autorité compétente 'commune état'
    ${instr_ac} =  Evaluate  ${instr_ac} - 1
    ${instr_ac} =  Convert to String  ${instr_ac}
    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di1_sans_espace}
    ...  state=new
    ...  object_id=${instr_ac}
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_task} =  Get Text  css=#task
    ${time_stamp_log} =  Get Value  css=#timestamp_log_hidden

    # Converti la payload JSON en dico python
    ${time_stamp_log_dic}=  Evaluate  ${time_stamp_log}
    # Récupérer le nombre d'entrée dans le timestamp_log
    ${nb_entree_timestamp_log} =  Get Length  ${time_stamp_log_dic}
    # Récupération du dernier index du timestamp_log
    ${last_index_timestamp_log} =  Evaluate  ${nb_entree_timestamp_log} - 1
    # On récupère la dernière entrée pour comparer les state
    ${before_last_state} =  Set Variable  ${time_stamp_log_dic[${last_index_timestamp_log}]["state"]}

    # Modification de la tâche en state = done
    Click On Form Portlet Action  task  modifier
    Wait Until Element Is Visible  css=#state
    Select From List By Label  css=div#form-container select#state  terminé
    Click On Submit Button
    ${time_stamp_log_bis} =  Get Value  css=#timestamp_log_hidden

    # Modifie le dossier 'a_qualifier' pour le passer en false et vérifier que l'info n'a pas été mise à jour dans la json payload, ce qui montre qu'on a bien figé la json payload
    Click On Link  ${di1_sans_espace}
    Element should Contain  css=#a_qualifier  Oui
    Click On Form Portlet Action  dossier_instruction  modifier
    Set Checkbox  a_qualifier  false
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On vérifie que la variable 'tax_surf_tot_cstr' des données techniques n'a pas été modifié, car la payload json doit être 
    # figé pour les tâches de type 'output' et de statut 'done'
    Depuis le contexte de la task  ${id_task}
    ${status} =  Run Keyword And Return Status  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload>legend  css=#json_payload
    Run Keyword If  '${status}' != 'True'  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload-calculee>legend  css=#json_payload
    Element Should Contain  css=#json_payload  "a_qualifier": "t"

    # Converti la payload JSON en dico python
    ${time_stamp_log_dic} =  Evaluate  ${time_stamp_log_bis}
    # Récupérer le nombre d'entrée dans le timestamp_log
    ${nb_entree_timestamp_log_bis} =  Get Length  ${time_stamp_log_dic}
    # Récupération du dernier index du timestamp_log
    ${last_index_timestamp_log} =  Evaluate  ${nb_entree_timestamp_log_bis} - 1
    # On récupère la dernière entrée pour comparer les prev_state et state
    ${last_prev_state} =  Set Variable  ${time_stamp_log_dic[${last_index_timestamp_log}]["prev_state"]}
    ${last_state} =  Set Variable  ${time_stamp_log_dic[${last_index_timestamp_log}]["state"]}

    # On vérifie qu'une entrée supplémentaire à bien été prise en compte dans le timestamp_log
    Should Not Be Equal As Strings  ${nb_entree_timestamp_log}  ${nb_entree_timestamp_log_bis}
    # Comparaison entre le dernier prev_state avec l'avant dernier state
    Should Be Equal As Strings  ${last_prev_state}  ${before_last_state}
    # Vérification que le dernier state est bien à "done" suite à notre modification au-dessus
    Should Be Equal As Strings  ${last_state}  done

    # Modification de la tâche en state = done
    Click On Form Portlet Action  task  modifier
    Wait Until Element Is Visible  css=#comment
    Input Text  css=textarea#comment  CommentaireTest300
    Click On Submit Button

    Element Text Should Be  comment  CommentaireTest300
    ${time_stamp_log_comment} =  Get Value  css=#timestamp_log_hidden

    # Converti la payload JSON en dico python
    ${time_stamp_log_dic} =  Evaluate  ${time_stamp_log_comment}
    # Récupérer le nombre d'entrée dans le timestamp_log
    ${nb_entree_timestamp_log_comment} =  Get Length  ${time_stamp_log_dic}
    # Récupération du dernier index du timestamp_log
    ${last_index_timestamp_log} =  Evaluate  ${nb_entree_timestamp_log_comment} - 1
    # On récupère la dernière entrée pour vérifier la valeur du champs commentaire
    ${last_comment} =  Set Variable  ${time_stamp_log_dic[${last_index_timestamp_log}]["comment"]}

    # Vérification que le dernier commentaire est bien celui que l'on a ajouté lors de la dernière modification
    Should Be Equal As Strings  ${last_comment}  CommentaireTest300

    # Modification de la tâche en state = new
    Click On Form Portlet Action  task  modifier
    Wait Until Element Is Visible  css=#state
    Select From List By Label  css=div#form-container select#state  à traiter
    Click On Submit Button


Vérification qu'il n'y a pas d'ajout de la task Ajout pièce lors de l'ajout d'un document de travail au dossier d'instruction
    [Documentation]  Permet de vérifier que la tâche Ajout pièce n'est pas ajouté lors de l'ajout d'un document de travail
    ...  au dossier d'instruction.

    Depuis la page d'accueil  admin  admin
    # On ajoute un document de travail
    &{document_travail_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  description_type=document de travail
    ...  date_creation=06/06/2001
    Ajouter un document de travail depuis le dossier d'instruction  ${di1}  ${document_travail_values}

    &{task_values} =  Create Dictionary
    ...  type=Ajout pièce (sortant)
    ...  dossier=${di1_sans_espace}
    ...  stream=Sortant
    # On accède au tableau
    Depuis le menu Moniteur Plat'AU

    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Ajout pièce (sortant)
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Ajout pièce (sortant)
    Run Keyword If  ${passed}==False  Input Text  css=#dossier  ${di1_sans_espace}
    Run Keyword If  ${passed}==False  Select From List By Label  css=#stream  Sortant
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=#tab-task  Aucun enregistrement.

    

Vérification de l'ajout de la task Ajout pièce lors de l'ajout d'une piece de catégorie Plat'AU au dossier d'instruction
    [Documentation]  Permet de vérifier que la tâche Ajout pièce est bien ajouté lors de l'ajout du pièce au dossier d'instruction
    ...  et que le contenu ajouté est téléchargé à partir de la tâche est identique.
    ...  Vérifie aussi qu'il n'y a pas de création d'autre tâche non concerné
    Depuis la page d'accueil  admin  admin
    # On ajoute un document numérisé par DI
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=Test type document numerise de catégorie PLATAU
    Ajouter une pièce depuis le dossier d'instruction  ${di1}  ${document_numerise_values}

    &{task_values} =  Create Dictionary
    ...  type=ajout_piece
    ...  dossier=${di1_sans_espace}
    ...  state=new
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    ${link_piece} =  Set Variable  ${json_payload_loaded['document_numerise']['path']}
    ${output_dir}  ${output_name}=  Télécharger un fichier  ${SESSION_COOKIE}  ${PROJECT_URL}${link_piece}  ${EXECDIR}${/}binary_files${/}

    ${base64_file} =  Run  base64 ${output_dir}${output_name}
    ${base64_model} =  Run  base64 ${EXECDIR}${/}binary_files${/}testImportManuel.pdf
    Should Be Equal As Strings  ${base64_file}  ${base64_model}

    ${id_qualification_DI} =  Get Text  css=#task
    ${id_next_task} =  Evaluate  ${id_qualification_DI} + 1
    Vérifier qu'il n'y a pas de création d'autre tâche non concerné  ${id_next_task}  ${di1_da}

Vérification de l'ajout de la task decision lors de l'ajout d'une décision dans le di
    [Documentation]  Permet de vérifier que la tâche Décision DI est bien ajoutée lors de l'ajout de la décision au dossier d'instruction
    ...  et que le contenu généré et téléchargé à partir de la tâche est identique.
    ...  Vérifie aussi qu'il n'y a pas de création d'autre tâche non concernée.
    ...  Vérifie également la gestion des mosidifcations d'une tâche en cours de traitement
    Depuis la page d'accueil  admin  admin
    ${instr_ad} =  Ajouter une instruction au DI et la finaliser  ${di1}  accepter un dossier sans réserve  true
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    ${link_decision_portlet} =  Get Location
    Close PDF
    ${output_dir_decision_portlet}  ${output_name_decision_portlet}=  Télécharger un fichier  ${SESSION_COOKIE}  ${link_decision_portlet}  ${EXECDIR}${/}binary_files${/}

    &{task_values} =  Create Dictionary
    ...  type=decision_DI
    ...  dossier=${di1_sans_espace}
    ...  state=new
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    ...  object_id=${instr_ad}
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_decision_DI} =  Get Text  css=#task

    ${status} =  Run Keyword And Return Status  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload>legend  css=#json_payload
    Run Keyword If  '${status}' != 'True'  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload-calculee>legend  css=#json_payload
    Element Should Contain  css=#json_payload  "avis_decision": "7",

    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    ${link_decision} =  Set Variable  ${json_payload_loaded['instruction']['path']}
    ${output_dir_json_payload}  ${output_name_json_payload}=  Télécharger un fichier  ${SESSION_COOKIE}  ${PROJECT_URL}${link_decision}  ${EXECDIR}${/}binary_files${/}

    ${base64_file_portlet} =  Run  base64 ${output_dir_decision_portlet}${output_name_decision_portlet}
    ${base64_json_payload} =  Run  base64 ${output_dir_json_payload}${output_name_json_payload}
    Should Be Equal As Strings  ${base64_file_portlet}  ${base64_json_payload}

    ${id_decision_DI} =  Get Text  css=#task
    ${id_next_task} =  Evaluate  ${id_decision_DI} + 1
    Vérifier qu'il n'y a pas de création d'autre tâche non concerné  ${id_next_task}  ${di1_da}

    # Task considéré en cours de traitement pour vérifier que l'ajout d'une nouvelle décision,
    # ajoute une nouvelle tâche et ne modifie pas l'existante

    # Tâche considérée en cours de traitement
    &{task_values_modif} =  Create Dictionary
    ...  state=en cours
    Modifier la task  ${id_decision_DI}  ${task_values_modif}
    &{task_values} =  Create Dictionary
    ...  type=decision_DI
    ...  dossier=${di1_sans_espace}
    ...  state=pending
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    ...  object_id=${instr_ad}
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    # Ajout d'un événement de reprise pour ajouter à nouveau un événement de décision
    @{type_di} =  Create List
    ...  PCI - P - Initial
    &{args_action} =  Create Dictionary
    ...  action=reprise_instruction_300
    ...  libelle=reprise de l'instruction - 300
    ...  regle_etat=etat
    ...  regle_accord_tacite=accord_tacite
    ...  regle_avis=null
    ...  regle_date_validite=null
    ...  regle_date_decision=null
    Ajouter Action  ${args_action}
    @{etats_autorises} =  Create List  dossier accepter
    &{args_evenement_para} =  Create Dictionary
    ...  libelle=Reprise de l'instruction - 300_task
    ...  dossier_instruction_type=${type_di}
    ...  action=${args_action.libelle}
    ...  etats_autorises=${etats_autorises}
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etats_autorises}
    ...  etat=delai de notification envoye
    ...  accord_tacite=Non
    Ajouter l'événement depuis le menu  ${args_evenement_para}
    ${instr_reprise} =  Ajouter une instruction au DI  ${di1}  ${args_evenement_para.libelle}
    # Vérifie que la reprise de l'instruction n'est pas altérée la tâche de décision
    # (un bug faisait que l'object_id était modifié par l'id de l'instruction de reprise)
    &{task_values} =  Create Dictionary
    ...  task=${id_decision_DI}
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    Element Should Not Contain  css=#object_id  ${instr_reprise}
    Element Should Contain  css=#object_id  ${instr_ad}

    # Ajoute à nouveau une instruction de décision et vérifie que la task en cours de traitement
    # n'est pas altérée et qu'une nouvelle task a été ajoutée
    ${instr_ad_2} =  Ajouter une instruction au DI  ${di1}  accepter un dossier sans réserve
    &{task_values} =  Create Dictionary
    ...  type=decision_DI
    ...  dossier=${di1_sans_espace}
    ...  state=pending
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    ...  object_id=${instr_ad}
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=decision_DI
    ...  dossier=${di1_sans_espace}
    ...  state=new
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    ...  object_id=${instr_ad_2}
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

Vérification de l'ajout de la task decision lors de l'ajout d'une décision tacite dans le di
    [Documentation]  Permet de vérifier que la tâche Décision DI est bien ajoutée lors de l'ajout de la décision tacite au dossier d'instruction
    ...  et que la tâche ne contient pas de fichier à télécharger.
    ...  Vérifie aussi qu'il n'y a pas de création d'autre tâche non concerné
    Depuis la page d'accueil  admin  admin
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300AdresseLocalite
    ...  depot_electronique=true
    ...  source_depot=platau
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOM02
    ...  particulier_prenom=TEST300TASKPRENOM02
    ...  localite=TEST300Localite
    ...  om_collectivite=MARSEILLE
    ${di2} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di2}  ${donnees_techniques_values}

    ${di2_sans_espace} =  Sans espace  ${di2}
    ${di2_da} =  Replace String Using Regexp  ${di2_sans_espace}  [A-Z][0-9]+$  ${EMPTY}

    Ajouter une instruction au DI  ${di2}  accord tacite (sans arrete)

    &{task_values} =  Create Dictionary
    ...  type=decision_DI
    ...  dossier=${di2_sans_espace}
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}

    Dictionary Should Not Contain Key  ${json_payload_loaded['instruction']}  path

    ${id_decision_DI} =  Get Text  css=#task
    ${id_next_task} =  Evaluate  ${id_decision_DI} + 1
    Vérifier qu'il n'y a pas de création d'autre tâche non concerné  ${id_next_task}  ${di1_da}


Vérification de l'ajout et de la consultation d'une tâche de type stream input
    [Documentation]  Permet de vérifier que l'ajout de la tâche à partir du WS de test
    ...  fonctionne correctement

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-AAA-00
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  AAA-000-00
    ${json_payload} =  Replace String  ${json_payload}  013055 20  013055 19
    ${json_payload} =  Replace String  ${json_payload}  01305520  01305519
    ${json_payload} =  Replace String  ${json_payload}  2020  2019
    ${json_payload} =  Replace String  ${json_payload}  07777P0  01111P0
    ${json_payload} =  Replace String  ${json_payload}  "acteur": "EF-DSQ-4512",  ${EMPTY}
    ${payload_dict} =  To Json  ${json_payload}

    # Les attributs state et stream ne sont pas nécessaires lors de l'ajout de la tache
    # Ici ces attributs sont utilisés lors de la vérification des données de la tâches en consultation
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  dossier=${payload_dict["dossier"]["dossier"]}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    Depuis la page d'accueil  admin  admin
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}

    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${status} =  Run Keyword And Return Status  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload>legend  css=#json_payload
    Run Keyword If  '${status}' != 'True'  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload-calculee>legend  css=#json_payload
    ${json_payload_to_compare} =  Get Text  css=#json_payload
    ${json_payload_to_compare} =  Evaluate  json.loads('''${json_payload_to_compare}''')  json
    ${json_payload_to_compare} =  Set Variable  ${json_payload_to_compare["external_uids"]}

    ${json_payload_loaded} =  Evaluate  json.loads('''${json_payload}''')  json
    ${json_payload_loaded} =  Set Variable  ${json_payload_loaded["external_uids"]}

    Should Be Equal As Strings  ${json_payload_loaded}  ${json_payload_to_compare}

    Element Should Contain  css=#json_payload  "tax_statut_info": "Déclaré"

Ajout d'une tâche de création de DI via WS, puis traitement + Vérification de la date de création et de la date de dernière modification sur le moniteur Plat'AU.
    [Documentation]  Vérifie l'ajout de la tâche via WS et son traitement.
    ...  Vérifie la date de création et la date de dernière modification sur le listing des tasks.

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # desactiver l'option dossier_commune et la saisie complète des numéros
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # définir les paramètres de type de demande
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

    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS
    ...  departement=013
    ...  commune=095
    ...  insee=13095
    ...  direction_code=E
    ...  direction_libelle=Direction de LIBRECOM_WS
    ...  direction_chef=Chef
    ...  division_code=E
    ...  division_libelle=Division E
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Thom Moht
    ...  guichet_om_utilisateur_email=tmoth@openads-test.fr
    ...  guichet_om_utilisateur_login=tmoth
    ...  guichet_om_utilisateur_pwd=tmoth
    ...  instr_om_utilisateur_nom=Qualdi Idlauq
    ...  instr_om_utilisateur_email=qidlauq@openads-test.fr
    ...  instr_om_utilisateur_login=qidlauq
    ...  instr_om_utilisateur_pwd=qidlauq
    ...  code_entite=LBCOM_13
    ...  acteur=LIBRECOM-ACT-013
    Isolation d'un contexte  ${librecom_values}
    &{loincom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LOINCOM_WS
    ...  departement=796
    ...  commune=095
    ...  insee=79695
    ...  direction_code=F
    ...  direction_libelle=Direction de LOINCOM_WS
    ...  direction_chef=Chef
    ...  division_code=F
    ...  division_libelle=Division F
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Somar Ramos
    ...  guichet_om_utilisateur_email=sramos@openads-test.fr
    ...  guichet_om_utilisateur_login=sramos
    ...  guichet_om_utilisateur_pwd=sramos
    ...  instr_om_utilisateur_nom=Bliguet Teugilb
    ...  instr_om_utilisateur_email=bteugilb@openads-test.fr
    ...  instr_om_utilisateur_login=bteugilb
    ...  instr_om_utilisateur_pwd=bteugilb
    Isolation d'un contexte  ${loincom_values}

    # Récupère l'identifiant de la collectivité LIBRECOM_WS
    Depuis le contexte de la collectivité  ${librecom_values["om_collectivite_libelle"]}
    ${librecom_ws_id} =  Get Text  css=#om_collectivite

    # récupération de l'identifiant de l'instructeur de la collectivité
    Depuis le contexte de l'instructeur  ${librecom_values["instr_om_utilisateur_nom"]}
    ${librecom_instr_id} =  Get Text  css=span#instructeur

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-AAA-01
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  AAA-000-01
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  "om_collectivite": "2"  "om_collectivite": "${librecom_ws_id}"
    ${json_payload} =  Replace String  ${json_payload}  "instructeur": "1"  "instructeur": "${librecom_instr_id}"

    ${payload_dict} =  To Json  ${json_payload}

    # sauvegarde le code d'acteur
    ${acteur_code} =  Set Variable  ${payload_dict["external_uids"]["acteur"]}

    # retire le paramètre 'acteur' de la payload JSON
    Remove From Dictionary  ${payload_dict["external_uids"]}  acteur

    # (re)Converti la payload JSON en string
    ${json_string}=  evaluate  json.dumps(${payload_dict})  json

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_string}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    #
    # Vérification de la date de création et de la date de dernière modification
    # sur le moniteur Plat'AU.
    #

    ${date} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y

    # Utilisation de la recherche avancée sur le listing des tâches
    &{search_task_values} =  Create Dictionary
    ...  task=${task_id}
    ...  creation_date_min=${date}
    ...  creation_date_max=${date}
    Depuis le listing des tasks à partir de la recherche avancée  ${search_task_values}

    # Vérification de l'existence des colonnes de la date de création et de la
    # date de dernière modification
    Element Should Contain  css=.tab-tab  date de création
    Element Should Contain  css=.tab-tab  date de dernière modification
    # Vérification de la valeur recherchée
    Element Should Contain  css=.tab-tab  ${task_id}

    # Utilisation de la recherche avancée sur le listing des tâches
    # Utilisation de la recherche avancée sur le listing des tâches
    &{search_task_values} =  Create Dictionary
    ...  task=${task_id}
    ...  creation_date_min=21/04/2022
    ...  creation_date_max=21/04/2022
    Depuis le listing des tasks à partir de la recherche avancée  ${search_task_values}

    # Vérification de la valeur recherchée
    Element Should Not Contain  css=.tab-tab  ${task_id}

    # Utilisation de la recherche avancée sur le listing des tâches
    &{search_task_values} =  Create Dictionary
    ...  task=${task_id}
    ...  last_modification_date_min=${date}
    ...  last_modification_date_max=${date}
    Depuis le listing des tasks à partir de la recherche avancée  ${search_task_values}
    # Vérification de la valeur recherchée
    Element Should Contain  css=.tab-tab  ${task_id}

    # Utilisation de la recherche avancée sur le listing des tâches
    &{search_task_values} =  Create Dictionary
    ...  task=${task_id}
    ...  last_modification_date_min=21/04/2022
    ...  last_modification_date_max=21/04/2022
    Depuis le listing des tasks à partir de la recherche avancée  ${search_task_values}
    # Vérification de la valeur recherchée
    Element Should Not Contain  css=.tab-tab  ${task_id}

    # Vérification du bon format du timestamp_log
    &{search_task_values} =  Create Dictionary
    ...  task=${task_id}
    ...  creation_date_min=${date}
    ...  creation_date_max=${date}
    ...  last_modification_date_min=${date}
    ...  last_modification_date_max=${date}
    Depuis le contexte d'une task à partir de la recherche avancée  ${search_task_values}
    Element Should Contain  css=#timestamp_log_jsontotab  ${DATE_FORMAT_YYYY-MM-DD}
    Element Should Contain  css=#timestamp_log_jsontotab  modification_date

    # Le libellé du DI créé ne correspondra pas au numéro renseigné
    # car l'option de saisie complète du numéro de dossier n'est pas activée
    # Il sera créé avec la séquence, débutant au numéro 1
    ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  [^ ]{7}$  00001P0
    ${da_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ...  [^ ]{5}$  00001
    # Idem pour les numéros DI et DA
    ${di_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier"]}
    ...  [^ ]{7}$  00001P0
    ${da_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation"]}
    ...  [^ ]{7}$  00001P0

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  .*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    Depuis le contexte du dossier d'autorisation  ${da_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_autorisation_libelle  ${da_lib_expected}

    # Vérifie que les données techniques ont bien été modifiées
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Click On Form Portlet Action    dossier_instruction    donnees_techniques    modale
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Portlet Action Should Be In SubForm  donnees_techniques  modifier
    Open Fieldset In Subform  donnees_techniques  description-de-la-demande---du-projet
    Form Static Value Should Be  ope_proj_desc  Description test dossier parallele BIS

    # nouvelle itération mais avec la saisie complète des numéros de dossier

    # activer la complète des numéros de dossiers
    Set To Dictionary  ${param_saisie_complete}  valeur=true
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # modification des externals uids
    Set To Dictionary  ${payload_dict["external_uids"]}  dossier=000-AAA-02
    Set To Dictionary  ${payload_dict["external_uids"]}  consultation=AAA-000-02

    # (re)Converti la payload JSON en string
    ${json_string}=  evaluate  json.dumps(${payload_dict})  json

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_string}
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    # Cette fois-ci aucun changement dans les valeurs du numéro de dossier, ou presque
    # le numéro n'est pas 'P0' mais 'P00' (je ne sais pas pourquoi)
    ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  P0$  P00
    ${da_lib_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    # Idem pour les numéros DI et DA
    ${di_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier"]}
    ...  P0$  P00
    ${da_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_autorisation"]}

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    Depuis le contexte du dossier d'autorisation  ${da_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_autorisation_libelle  ${da_lib_expected}


    # nouvelle itération mais avec l'option commune et le rattachement via un numéro d'acteur

    # activer l'option dossier_commune
    Depuis la page d'accueil  admin  admin
    Set To Dictionary  ${param_dossier_commune}  valeur=true
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}

    #-- ajouter manuellement une commune en saisissant une date de validité dans le passé
    &{oldcom_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=45645
    ...  reg=45
    ...  dep=45
    ...  arr=645
    ...  tncc=0
    ...  ncc=LIBRECOM_OLD
    ...  nccenr=LibreCom_old
    ...  libelle=LIBRECOM_OLD
    ...  can=45
    ...  comparent=
    ...  om_validite_debut=01/11/2020
    Ajouter commune avec dates validité  ${oldcom_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_values["acteur"]}  ${librecom_values["om_collectivite_libelle"]}

    # Change le numéro de dossier et le code commune dans la payload JSON
    ${json_payload} =  Replace String  ${json_payload}  P0  P04
    ${json_payload} =  Replace String  ${json_payload}
    ...  ${librecom_values["insee"]}  ${oldcom_values["com"]}
    ${json_payload} =  Replace String  ${json_payload}  ${acteur_code}  ${librecom_values["acteur"]}
    ${payload_dict} =  To Json  ${json_payload}

    # retire le paramètre 'om_collectivite' de la payload JSON
    Remove From Dictionary  ${payload_dict["dossier"]}  om_collectivite

    # modification des externals uids
    Set To Dictionary  ${payload_dict["external_uids"]}  dossier=000-AAA-03
    Set To Dictionary  ${payload_dict["external_uids"]}  consultation=AAA-000-03

    # (re)Converti la payload JSON en string
    ${json_string}=  evaluate  json.dumps(${payload_dict})  json

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_string}
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    # Cette fois-ci aucun changement dans les valeurs du numéro de dossier
    ${di_lib_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_libelle"]}
    ${da_lib_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ${di_expected} =  Set Variable  ${payload_dict["dossier"]["dossier"]}
    ${da_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_autorisation"]}

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"

    # En tant qu'instructeur de la collectivité/du service LIBRECOM
    Depuis la page d'accueil  tmoth  tmoth

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    Depuis le contexte du dossier d'autorisation  ${da_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_autorisation_libelle  ${da_lib_expected}


    # nouvelle itération avec le même DA pour être sûr qu'il est réutilisé avec succès
    Depuis la page d'accueil  admin  admin

    # Change le numéro de dossier et le code commune dans la payload JSON
    ${json_payload} =  Replace String  ${json_payload}  P04  P03
    ${payload_dict} =  To Json  ${json_payload}

    # retire le paramètre 'om_collectivite' de la payload JSON
    Remove From Dictionary  ${payload_dict["dossier"]}  om_collectivite

    # modification des externals uids
    Set To Dictionary  ${payload_dict["external_uids"]}  dossier=000-AAA-04
    Set To Dictionary  ${payload_dict["external_uids"]}  consultation=AAA-000-04

    # (re)Converti la payload JSON en string
    ${json_string}=  evaluate  json.dumps(${payload_dict})  json

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_string}
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    # Cette fois-ci aucun changement dans les valeurs du numéro de dossier
    ${di_lib_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_libelle"]}
    ${da_lib_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ${di_expected} =  Set Variable  ${payload_dict["dossier"]["dossier"]}
    ${da_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_autorisation"]}

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"

    # En tant qu'instructeur de la collectivité/du service LIBRECOM
    Depuis la page d'accueil  tmoth  tmoth

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    Depuis le contexte du dossier d'autorisation  ${da_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_autorisation_libelle  ${da_lib_expected}


    # nouvelle itération avec l'option des codes entités
    Depuis la page d'accueil  admin  admin

    # active l'option entité pour la collectivité/le service
    &{param_entite} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=true
    ...  om_collectivite=${librecom_values["om_collectivite_libelle"]}
    Ajouter ou modifier le paramètre depuis le menu  ${param_entite}

    # ajoute le paramètre 'code_entite' à la collectivité/le service
    Ajouter le paramètre depuis le menu  code_entite
    ...  ${librecom_values["code_entite"]}  ${librecom_values["om_collectivite_libelle"]}

    # modification des externals uids
    Set To Dictionary  ${payload_dict["external_uids"]}  dossier=000-AAA-05
    Set To Dictionary  ${payload_dict["external_uids"]}  consultation=AAA-000-05

    # (re)Converti la payload JSON en string
    ${json_string}=  evaluate  json.dumps(${payload_dict})  json

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_string}
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    # Cette fois-ci aucun changement dans les valeurs du numéro de dossier
    ${di_lib_expected} =  Catenate  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  ${librecom_values["code_entite"]}01
    ${da_lib_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ${di_expected} =  Catenate  ${payload_dict["dossier"]["dossier"]}
    ...  ${librecom_values["code_entite"]}01
    ${da_expected} =  Set Variable  ${payload_dict["dossier"]["dossier_autorisation"]}

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"

    # En tant qu'instructeur de la collectivité/du service LIBRECOM
    Depuis la page d'accueil  tmoth  tmoth

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    Depuis le contexte du dossier d'autorisation par la recherche  ${da_lib_expected}
    # l'onglet du DA est vide dans le mode MC, mais le simple fait d'arriver à y accéder
    # montre qu'il existe


    # nouvelle itération avec une payload JSON minimale
    Depuis la page d'accueil  admin  admin

    # Ajout du lien pour les suivis de demande
    &{param_args} =  Create Dictionary
    ...  libelle=portal_code_suivi_base_url
    ...  valeur=LIEN_PORTAL/[PORTAL_CODE_SUIVI]/load
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_args}

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  7SZ-SX8-TR4  000-AAA-06
    ${json_payload} =  Replace String  ${json_payload}  2SZ-SX8-AZ6  AAA-000-06
    ${json_payload} =  Replace String  ${json_payload}  00009  00009P0
    ${json_payload} =  Replace String  ${json_payload}  13055  ${oldcom_values["com"]}
    ${json_payload} =  Replace String  ${json_payload}  ${acteur_code}  ${librecom_values["acteur"]}
    # TNR pour vérifier le tronquage des chaînes de caractère sur un caractère accentué
    ${json_payload} =  Replace String  ${json_payload}  "personne_morale_categorie_juridique": "SA"  "personne_morale_categorie_juridique": "SA____________\u00e9_"
    # Modifie le code de suivi de demande
    ${json_payload} =  Replace String  ${json_payload}  TESTCODESUIVI  CNPHNTFB
    ${payload_dict} =  To Json  ${json_payload}

    # Converti la payload JSON en string
    ${json_string}=  evaluate  json.dumps(${payload_dict})  json

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_string}
    ...  category=portal
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${msg}  ${di_regex}  \\1

    # En tant qu'instructeur de la collectivité/du service LIBRECOM
    Depuis la page d'accueil  tmoth  tmoth

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction  ${di_lib}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib}

    # Commune
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#commune  ${oldcom_values["libelle"]}

    # Code entité
    ${num_entite_value} =  Get Value  css=input#numerotation_entite
    Should Be Equal  ${num_entite_value}  ${librecom_values["code_entite"]}

    # Demandeur principale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Form Value Should Contain  css=#dossier_petitionnaire  Perry Katy

    # Date demande = date dépôt
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#date_depot  23/11/2020

    # Autres demandeurs
    Open Fieldset  dossier_instruction  demandeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#liste_demandeur  Madame Perry Katy
    Element Should Contain  css=#liste_demandeur  Métropole Construction SA Métropole
    Element Should Contain  css=#liste_demandeur  Monsieur Bloom Orlando
    Element Should Contain  css=#liste_demandeur  67 rue de l'espérance

    # Dépôt électronique
    Element Should Be Visible  css=span.om-icon.om-icon-16.om-icon-fix.depot-electronique-16

    # Code suivi de demande
    Open All Fieldset Using Javascript  dossier_instruction
    Element Should Contain  css=span#lien_iiue_portal  CNPHNTFB

    # Suppression du lien pour les suivis de demande
    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=portal_code_suivi_base_url
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}


    # On vérifie qu'un dossier issus du portail ne peut pas être supprimé

    # On active l'option de suppression
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    Depuis le contexte du dossier d'instruction  ${di_lib}

    Portlet Action Should Not Be In Form  dossier_instruction  supprimer

    # On désactive l'option de suppression
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # nouvelle itération avec deux DI non-réglementaires
    # générant deux DA/DI différents à cause que l'option code entité
    Depuis la page d'accueil  admin  admin

    # # sans l'option de code entité
    # Set To Dictionary  ${param_entite}  valeur=false
    # Ajouter ou modifier le paramètre depuis le menu  ${param_entite}

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  7SZ-SX8-TR4  000-AAA-07
    ${json_payload} =  Replace String  ${json_payload}  2SZ-SX8-AZ6  AAA-000-07
    ${json_payload} =  Replace String  ${json_payload}  00009  7a9eeP0
    ${json_payload} =  Replace String  ${json_payload}  13055  ${oldcom_values["com"]}
    ${json_payload} =  Replace String  ${json_payload}  ${acteur_code}  ${librecom_values["acteur"]}
    ${payload_dict} =  To Json  ${json_payload}

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${msg}  ${di_regex}  \\1
    Log  ${di_lib}

    ${di_lib_no_space} =  Sans espace  ${di_lib}
    ${di_to_search} =  Replace String  ${di_lib_no_space}  ${librecom_values["code_entite"]}  ${SPACE}${librecom_values["code_entite"]}

    # En tant qu'instructeur de la collectivité/du service LIBRECOM
    Depuis la page d'accueil  tmoth  tmoth

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_to_search}

    # Commune
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#commune  ${oldcom_values["libelle"]}

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Remplace certaines valeurs
    #${json_payload} =  Replace String  ${json_payload}  000-AAA-07  000-AAA-08
    ${json_payload} =  Replace String  ${json_payload}  AAA-000-07  AAA-000-08

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${msg}  ${di_regex}  \\1
    Log  ${di_lib}

    ${di_lib_no_space} =  Sans espace  ${di_lib}
    ${di_to_search} =  Replace String  ${di_lib_no_space}  ${librecom_values["code_entite"]}  ${SPACE}${librecom_values["code_entite"]}

    # En tant qu'instructeur de la collectivité/du service LIBRECOM
    Depuis la page d'accueil  tmoth  tmoth

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_to_search}


    # nouvelle itération avec deux DI non-réglementaires sans l'option code entité
    Depuis la page d'accueil  admin  admin

    # sans l'option de code entité
    Set To Dictionary  ${param_entite}  valeur=false
    Ajouter ou modifier le paramètre depuis le menu  ${param_entite}

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  7SZ-SX8-TR4  000-AAA-09
    ${json_payload} =  Replace String  ${json_payload}  2SZ-SX8-AZ6  AAA-000-09
    ${json_payload} =  Replace String  ${json_payload}  00009  4d67qsP0
    ${json_payload} =  Replace String  ${json_payload}  13055  ${oldcom_values["com"]}
    ${json_payload} =  Replace String  ${json_payload}  ${acteur_code}  ${librecom_values["acteur"]}
    ${payload_dict} =  To Json  ${json_payload}

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${msg}  ${di_regex}  \\1
    Log  ${di_lib}

    ${di_lib_no_space} =  Sans espace  ${di_lib}

    # En tant qu'instructeur de la collectivité/du service LIBRECOM
    Depuis la page d'accueil  tmoth  tmoth

    # Vérifier que le dossier a bien été ajouté
    #Depuis le contexte du dossier d'instruction par recherche  ${di_lib_no_space}
    Depuis le contexte du dossier d'instruction  ${di_lib_no_space}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_no_space}

    # Vérification liste des identifiants externe sur le DI
    # dossier_consultation
    Open Fieldset  dossier_instruction  plat_au---identifiants-techniques
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques  ${payload_dict["external_uids"]["dossier"]}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques  ${payload_dict["external_uids"]["dossier_consultation"]}

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  AAA-000-09  ZZZ-000-09

    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${passed} =  Run Keyword And Return Status  Déclencher le traitement des tâches par WS
    Should Be Equal  ${passed}  ${FALSE}

    # fin, suppression des options
    Depuis la page d'accueil  admin  admin
    Set To Dictionary  ${param_division}  valeur=false
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    Set To Dictionary  ${param_saisie_complete}  valeur=true
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}
    Set To Dictionary  ${param_dossier_commune}  valeur=false
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}

    # Vérification du bon fonctionnement de la RA pour l'input contenu_json
    # Permet de vérifier que l'on a bien un résultat lors de la recherche d'une occurence dans le json_payload des
    # tâches et de les afficher sur le listing des moniteurs plat'au et ide'au
    Depuis la page d'accueil  admin  admin

    Depuis le menu Moniteur Plat'AU

    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#contenu_json

    Input Text  css=div#adv-search-adv-fields input#contenu_json  *000-AAA-01*
    Click On Search Button

    Element Should Contain  css=td.col-1 a.lienTable  Création DI pour consultation
    Element Should Contain  css=td.col-4 a.lienTable  PC0130952007777P0

    Input Text  css=div#adv-search-adv-fields input#contenu_json  *PC 045645 20 07777P04*
    Click On Search Button

    Element Should Contain  css=td.col-1 a.lienTable  Création DI pour consultation
    Element Should Contain  css=td.col-4 a.lienTable  PC0456452007777P04

Activation de la configuration du filestorage alternatif
    # On change la configuration du filestorage
    Move File  ..${/}dyn${/}filestorage.inc.php  ..${/}dyn${/}filestorage.inc.php.bak
    Copy File  ..${/}tests${/}binary_files${/}alternate_filestorage.inc.php  ..${/}dyn${/}
    Move File  ..${/}dyn${/}alternate_filestorage.inc.php  ..${/}dyn${/}filestorage.inc.php


Ajout d'une tâche Ajout pièce en utilisant le filestorage alternatif
    [Documentation]  Ce test case permet de vérifier le bon fonctionnement de l'ajout d'une tâche Ajout pièce avec un filesotrage alternatif.
    ...  On ajout tout d'abord la tâche par web service et on vérifie que l'uid contient bien le préfixe fs qui a été configuré dans le fichier
    ...  filesotrage.inc.php. On vérifie ensuite que le fichier a bien été ajouté dans le filestorage alternatif (../var/filestorage_plop)
    ...  et qu'il n'est pas présent dans le filstorage pricipal. On traite la tâche Ajout pièce ce qui va lié la pièce à un dossier et on consulte
    ...  la pièce afin de vérifier que l'uid contient bien le préfixe dans le sous titre.


    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # desactiver l'option dossier_commune et la saisie complète des numéros
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_PIECE_AFS
    ...  departement=016
    ...  commune=098
    ...  insee=16098
    ...  direction_code=O
    ...  direction_libelle=Direction de LIBRECOM_WS_PIECE_AFS
    ...  direction_chef=Chef
    ...  division_code=OO
    ...  division_libelle=Division OO
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=KhalilAFS GibrAFS
    ...  guichet_om_utilisateur_email=kgibrafs@openads-test.fr
    ...  guichet_om_utilisateur_login=kgibrafs
    ...  guichet_om_utilisateur_pwd=kgibrafs
    ...  instr_om_utilisateur_nom=DomirAFS TambAFS
    ...  instr_om_utilisateur_email=dtambafs@openads-test.fr
    ...  instr_om_utilisateur_login=dtambafs
    ...  instr_om_utilisateur_pwd=dtambafs
    ...  code_entite=LBCOM_16
    ...  acteur=LIBRECOM-ACT-016-AFS
    Isolation d'un contexte  ${librecom_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_values["acteur"]}  ${librecom_values["om_collectivite_libelle"]}

    # Ajouter le type de document avec le code '90' tel qu'il est dans la payload
    ${dnt_code} =  Set Variable  95
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Document numérisé Plat'AU AFS
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Récupère l'identifiant de la collectivité LIBRECOM_WS
    Depuis le contexte de la collectivité  ${librecom_values["om_collectivite_libelle"]}
    ${librecom_ws_id} =  Get Text  css=#om_collectivite

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${dossier_json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  EF-DSQ-4512  ${librecom_values["acteur"]}
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  7SZ-SX8-TR4  000-AAA-10
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  2SZ-SX8-AZ6  AAA-000-10
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  00009  00001P0
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  13055  ${librecom_values["insee"]}
    ${dossier_payload_dict} =  To Json  ${dossier_json_payload}

    # Ajoute d'une tâche de création de DI
    ${dossier_task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${dossier_json_payload}
    Ajouter la tâche par WS  ${dossier_task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${dossier_msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${dossier_task_values["type"]}
    ...  ${dossier_payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${dossier_msg}  ${di_regex}  \\1

    # En tant qu'instructeur de la collectivité/du service LIBRECOM_WS_PIECE
    Depuis la page d'accueil  kgibrafs  kgibrafs

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction  ${di_lib}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib}


    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-AAA-10
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-10
    ${json_payload} =  Replace String  ${json_payload}  FE4-JR5-8W  AAA-000-10
    ${json_payload} =  Replace String  ${json_payload}  "document_numerise_type_code": "90"  "document_numerise_type_code": "95"
    ${piece_payload_dict} =  To Json  ${json_payload}
    ${external_uid_piece_1} =  Set Variable  ${piece_payload_dict["external_uids"]["piece"]}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    # se rend sur la page de la tâche
    #Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    Depuis le contexte de la task  ${task_id}

    # vérifie qu'elle a bien été ajoutée
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['document_numerise']}
    Dictionary Should Contain Key  ${json_payload_loaded['document_numerise']}  uid

    # L'uid doit contenir le préfixe correspondant au filestorage alternatif
    ${uid} =  Set Variable  ${json_payload_loaded['document_numerise']['uid']}
    ${prefix} =  Get Substring  ${uid}  0  5
    Should Be Equal As Strings  ${prefix}  fs://
    # On enlève le préfixe de l'uid
    ${uid_without_prefix} =  Get Substring  ${uid}  5
    ${path_1} =  Get Substring  ${uid}  5  7
    ${path_2} =  Get Substring  ${uid}  5  9

    # Vérification dans le filestorage alternatif, le fichier doit être présent
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}.info

    # Vérification dans le filestorage principale, le fichier ne doit pas être présent
    File Should Not Exist  ..${/}var${/}filstorage${/}${path_1}${/}${path_2}${/}${uid_without_prefix}
    File Should Not Exist  ..${/}var${/}filstorage${/}${path_1}${/}${path_2}${/}${uid_without_prefix}.info

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS
    Log  ${msg}

    # Extraction du libellé du DI dans le message
    ${piece_di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]} *
    ...  :  pièce  :  '[^']+'  créée sur le dossier d'instruction '([^']+)'.*$
    ${piece_di_lib} =  Replace String Using Regexp  ${msg}  ${piece_di_regex}  \\1

    # Le DI devrait être le même que celui du dossier
    Should Be Equal  ${piece_di_lib}  ${dossier_payload_dict["dossier"]["dossier"]}

    # Depuis la pièce
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_lib}
    ...  Document numérisé Plat'AU

    # Lors de la consultation de la pièce, on affiche l'uid dans le sous titre.
    # Le traitement déplaçant le fichier dans le backend de storage principal, l'uid
    # affiché doit être différent
    Page Should Not Contain  sousform-document_numerise  ${uid}

Vérification de l'ajout de la task Sortant Prescription archéologique lors d'une décision sur un dossier ajouté par une task input
    [Documentation]  Permet de vérfier l'ajout d'une tâche de Prescription si le WF est
    ...  correctement paramétré.

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    #
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}
    &{param_mode_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_mode_service_consulte}

    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_PRESCRIPTION
    ...  departement=016
    ...  commune=100
    ...  insee=16100
    ...  direction_code=1
    ...  direction_libelle=Direction de LIBRECOM_WS_PRESCRIPTION
    ...  direction_chef=Chef
    ...  division_code=01
    ...  division_libelle=Division 01
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Zurie Parmentier
    ...  guichet_om_utilisateur_email=zparmentier@openads-test.fr
    ...  guichet_om_utilisateur_login=zparmentier
    ...  guichet_om_utilisateur_pwd=zparmentier
    ...  instr_om_utilisateur_nom=Mirabelle Laberge
    ...  instr_om_utilisateur_email=mlaberge@openads-test.fr
    ...  instr_om_utilisateur_login=mlaberge
    ...  instr_om_utilisateur_pwd=mlaberge
    ...  code_entite=LBCOM_16
    ...  acteur=LIBRECOM-ACT-016-PRESCRIPTION
    Isolation d'un contexte  ${librecom_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_values["acteur"]}  ${librecom_values["om_collectivite_libelle"]}

    # Récupère l'identifiant de la collectivité LIBRECOM_WS
    Depuis le contexte de la collectivité  ${librecom_values["om_collectivite_libelle"]}
    ${librecom_ws_id} =  Get Text  css=#om_collectivite

    # Ajout PRESCRIPTION avis_decision + action + evenement
    &{args_avis_decision} =  Create Dictionary
    ...  libelle=300 - Prescription
    ...  typeavis=favorable
    ...  avis_decision_type=Conforme
    ...  avis_decision_nature=Favorable
    ...  prescription=true
    Ajouter l'avis de décision  ${args_avis_decision}
    &{args_action} =  Create Dictionary
    ...  action=Prescription300
    ...  libelle=Prescription300
    ...  regle_avis=avis_decision
    ...  regle_date_decision=date_evenement
    Ajouter l'action depuis le menu  ${args_action}
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  DP - P - Initiale
    &{args_evenement} =  Create Dictionary
    ...  libelle=300 - Prescription
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=${args_action.libelle}
    ...  avis_decision=${args_avis_decision.libelle}
    Ajouter l'événement depuis le menu  ${args_evenement}

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${dossier_json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  EF-DSQ-4512  ${librecom_values["acteur"]}
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  7SZ-SX8-TR4  000-AAA-20
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  2SZ-SX8-AZ6  AAA-000-20
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  00009  00001P0
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  13055  ${librecom_values["insee"]}
    ${dossier_payload_dict} =  To Json  ${dossier_json_payload}

    # Ajoute d'une tâche de création de DI
    ${dossier_task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${dossier_json_payload}
    Ajouter la tâche par WS  ${dossier_task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${dossier_msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${dossier_task_values["type"]}
    ...  ${dossier_payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${dossier_msg}  ${di_regex}  \\1
    ${di_lib_sans_espace} =  Sans espace  ${di_lib}

    # Ajout d'une instruction Prescription et vérification de la création de la tâche
    ${instr_ad} =  Ajouter une instruction au DI  ${di_lib}  ${args_evenement.libelle}
    &{task_values} =  Create Dictionary
    ...  type=prescription
    ...  dossier=${di_lib_sans_espace}
    ...  state=new
    ...  object_id=${instr_ad}
    ...  link_dossier=${di_lib_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}
    # Vérification que le champ commentaire est bien intégré au json
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['avis_decision']}
    Dictionary Should Contain Key  ${json_payload_loaded['avis_decision']['libelle']}  ${args_avis_decision.libelle}

    # On vérifie qu'il n'y ait pas de tâche Décision DI ou avis
    Depuis le menu Moniteur Plat'AU
    # Input Text  css=div#adv-search-adv-fields input#dossier  ${di_lib}
    # Select From List By Label  css=div#adv-search-adv-fields select#type  Décision DI
    # Click On Search Button
    # Element Should Contain  css=.tab-data  Aucun enregistrement.
    # Input Text  css=div#adv-search-adv-fields input#dossier  ${di_lib}
    # Select From List By Label  css=div#adv-search-adv-fields select#type  Avis
    # Click On Search Button
    # Element Should Contain  css=.tab-data  Aucun enregistrement.

    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Décision DI
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Décision DI
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${di_lib}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.

    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Avis
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Avis
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${di_lib}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.

    #
    &{param_mode_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_mode_service_consulte}

Vérification de l'ajout de la tâche Ajout pièce par ws, puis traitement
    [Documentation]  Permet de vérifier que la tâche ajout_pièce en stream input ajout bien un fichier dans le filestorage
    ...  à partir du contenu du json payload vérifie aussi que l'uid du fichier ajouté est bien enregistré
    ...  dans le json payload

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # desactiver l'option dossier_commune et la saisie complète des numéros
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_PIECE
    ...  departement=014
    ...  commune=095
    ...  insee=14095
    ...  direction_code=GF1
    ...  direction_libelle=Direction de LIBRECOM_WS_PIECE
    ...  direction_chef=Chef
    ...  division_code=GF1
    ...  division_libelle=Division GF1
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Khalil Gibran
    ...  guichet_om_utilisateur_email=kgibran@openads-test.fr
    ...  guichet_om_utilisateur_login=kgibran
    ...  guichet_om_utilisateur_pwd=kgibran
    ...  instr_om_utilisateur_nom=Domir Tambu
    ...  instr_om_utilisateur_email=dtambu@openads-test.fr
    ...  instr_om_utilisateur_login=dtambu
    ...  instr_om_utilisateur_pwd=dtambu
    ...  code_entite=LBCOM_14
    ...  acteur=LIBRECOM-ACT-014
    Isolation d'un contexte  ${librecom_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_values["acteur"]}  ${librecom_values["om_collectivite_libelle"]}

    # Ajouter le type de document avec le code '90' tel qu'il est dans la payload
    ${dnt_code} =  Set Variable  90
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Document numérisé Plat'AU
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Récupère l'identifiant de la collectivité LIBRECOM_WS
    Depuis le contexte de la collectivité  ${librecom_values["om_collectivite_libelle"]}
    ${librecom_ws_id} =  Get Text  css=#om_collectivite

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${dossier_json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  EF-DSQ-4512  ${librecom_values["acteur"]}
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  7SZ-SX8-TR4  000-AAA-10
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  2SZ-SX8-AZ6  AAA-000-10
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  00009  00001P0
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  13055  ${librecom_values["insee"]}
    # On remplace le code postal par une valeur trop grande
    #  afin de vérifier si elle va être tronqué
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}
    ...  "terrain_adresse_code_postal" : "75001"  "terrain_adresse_code_postal" : "7500138432"
    ${dossier_payload_dict} =  To Json  ${dossier_json_payload}

    # Ajoute d'une tâche de création de DI
    ${dossier_task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${dossier_json_payload}
    Ajouter la tâche par WS  ${dossier_task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${dossier_msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${dossier_task_values["type"]}
    ...  ${dossier_payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${dossier_msg}  ${di_regex}  \\1

    # En tant qu'instructeur de la collectivité/du service LIBRECOM_WS_PIECE
    Depuis la page d'accueil  kgibran  kgibran

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction  ${di_lib}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib}

    # On vérifie que le code postal a bien été tronqué (7500138432 doit devenir 75001)
    Open Fieldset  dossier_instruction  localisation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#terrain_adresse_code_postal  75001

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Active l'option de renommage des fichiers
    &{param_option} =  Create Dictionary
    ...  libelle=option_renommage_document_numerise_tache
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option}

    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-AAA-10
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-10
    ${json_payload} =  Replace String  ${json_payload}  FE4-JR5-8W  AAA-000-10
    ${piece_payload_dict} =  To Json  ${json_payload}
    ${external_uid_piece_1} =  Set Variable  ${piece_payload_dict["external_uids"]["piece"]}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    # se rend sur la page de la tâche
    #Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    Depuis le contexte de la task  ${task_id}

    # vérifie qu'elle a bien été ajoutée
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['document_numerise']}
    Dictionary Should Contain Key  ${json_payload_loaded['document_numerise']}  uid

    ${uid} =  Set Variable  ${json_payload_loaded['document_numerise']['uid']}
    # On enlève le préfixe de l'uid
    ${uid_without_prefix} =  Get Substring  ${uid}  5
    ${path_1} =  Get Substring  ${uid}  5  7
    ${path_2} =  Get Substring  ${uid}  5  9

    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}.info

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS
    Log  ${msg}

    # Extraction du libellé du DI dans le message
    ${piece_di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]} *
    ...  :  pièce  :  '[^']+'  créée sur le dossier d'instruction '([^']+)'.*$
    ${piece_di_lib} =  Replace String Using Regexp  ${msg}  ${piece_di_regex}  \\1

    # Le DI devrait être le même que celui du dossier
    Should Be Equal  ${piece_di_lib}  ${dossier_payload_dict["dossier"]["dossier"]}

    # Depuis la page des pièces du dossier
    Depuis l'onglet des pièces du dossier d'instruction  ${di_lib}

    # Le nom du fichier doit être présent en tant que pièce
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be
    ...  css=table.document_numerise:nth-child(3) td a.lienDocumentNumerise span[title="Télécharger"]
    ...  ${piece_payload_dict["document_numerise"]["nom_fichier"]}

    # Depuis la pièce
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_lib}
    ...  Document numérisé Plat'AU

    # La date de création doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#date_creation  27/11/2020

    # Le type de pièce doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#document_numerise_type
    ...  Document numérisé Plat'AU


    # ajout d'une seconde pièce au dossier

    # Ajouter le type de document avec le code '91' tel qu'il est dans la payload
    ${dnt_code_2} =  Set Variable  91
    &{dnt_values_2} =  Create Dictionary
    ...  code=${dnt_code_2}
    ...  libelle=Document numérisé Plat'AU 2
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values_2}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # json_payload correspondant à la tâche Ajout pièce, dont on modifie certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}
    ...  "date_creation": "2020-11-27"  "date_creation": "2020-12-04"
    ${json_payload} =  Replace String  ${json_payload}
    ...  "document_numerise_nature_code": "INIT"  "document_numerise_nature_code": "COMP"
    ${json_payload} =  Replace String  ${json_payload}
    ...  "document_numerise_type_code": "90"  "document_numerise_type_code": "91"

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  PPP-000-10  PPP-000-11
    ${piece_payload_dict} =  To Json  ${json_payload}
    ${external_uid_piece_2} =  Set Variable  ${piece_payload_dict["external_uids"]["piece"]}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    # se rend sur la page de la tâche
    #Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    Depuis le contexte de la task  ${task_id}

    # vérifie qu'elle a bien été ajoutée
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['document_numerise']}
    Dictionary Should Contain Key  ${json_payload_loaded['document_numerise']}  uid

    ${uid} =  Set Variable  ${json_payload_loaded['document_numerise']['uid']}
    # On enlève le préfixe de l'uid
    ${uid_without_prefix} =  Get Substring  ${uid}  5
    ${path_1} =  Get Substring  ${uid}  5  7
    ${path_2} =  Get Substring  ${uid}  5  9

    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}.info

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS
    Log  ${msg}

    # Extraction du libellé du DI dans le message
    ${piece_di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]} *
    ...  :  pièce  :  '[^']+'  créée sur le dossier d'instruction '([^']+)'.*$
    ${piece_di_lib} =  Replace String Using Regexp  ${msg}  ${piece_di_regex}  \\1

    # Le DI devrait être le même que celui du dossier
    Should Be Equal  ${piece_di_lib}  ${dossier_payload_dict["dossier"]["dossier"]}

    # Depuis la page des pièces du dossier
    Depuis l'onglet des pièces du dossier d'instruction  ${di_lib}

    # Le nom du fichier doit être présent en tant que pièce
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be
    ...  css=table.document_numerise:nth-child(4) td a.lienDocumentNumerise span[title="Télécharger"]
    # Suite à l'activation de l'option de renommage des fichiers : option_renommage_document_numerise_tache
    # Le nom du fichier sera modifié par celui-ci au vu du contenu de la variable ${json_payload}
    ...  2020120491.pdf

    # Depuis la pièce
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_lib}
    ...  Document numérisé Plat'AU 2

    # La date de création doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#date_creation  04/12/2020

    # Le type de pièce doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#document_numerise_type
    ...  Document numérisé Plat'AU 2

    # Vérification liste des identifiants externe sur le DI
    # piece
    Depuis le contexte du dossier d'instruction  ${di_lib}
    Open Fieldset  dossier_instruction  plat_au---identifiants-techniques
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques  ${piece_payload_dict["external_uids"]["dossier"]}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques  ${dossier_payload_dict["external_uids"]["dossier_consultation"]}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques  ${external_uid_piece_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques  ${external_uid_piece_2}

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Désactive l'option de renommage des fichiers
    &{param_option} =  Create Dictionary
    ...  libelle=option_renommage_document_numerise_tache
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option}


Vérification de l'ajout d'une même pièce sur deux dossiers, le tout ajouté par WS
    [Documentation]  Permet de vérifier que la même pièce peut être ajoutée sur 2 dossiers

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # desactiver l'option dossier_commune et activer la saisie complète des numéros
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_multi_1_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_PIECE_MULTI_1
    ...  departement=015
    ...  commune=085
    ...  insee=15085
    ...  direction_code=T
    ...  direction_libelle=Direction de LIBRECOM_WS_PIECE_MULTI_1
    ...  direction_chef=Chef
    ...  division_code=TT
    ...  division_libelle=Division TT
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Joseph Proudhon
    ...  guichet_om_utilisateur_email=jproudhon@openads-test.fr
    ...  guichet_om_utilisateur_login=jproudhon
    ...  guichet_om_utilisateur_pwd=jproudhon
    ...  instr_om_utilisateur_nom=François Rebalais
    ...  instr_om_utilisateur_email=frebalais@openads-test.fr
    ...  instr_om_utilisateur_login=frebalais
    ...  instr_om_utilisateur_pwd=frebalais
    ...  code_entite=LBCOM_15
    ...  acteur=LIBRECOM-ACT-015
    Isolation d'un contexte  ${librecom_multi_1_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_multi_1_values["acteur"]}  ${librecom_multi_1_values["om_collectivite_libelle"]}

    # Active l'option entité pour la collectivité/le service
    &{param_entite} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=true
    ...  om_collectivite=${librecom_multi_1_values["om_collectivite_libelle"]}
    Ajouter ou modifier le paramètre depuis le menu  ${param_entite}

    # Ajoute le paramètre 'code_entite' à la collectivité/le service
    Ajouter le paramètre depuis le menu  code_entite
    ...  ${librecom_multi_1_values["code_entite"]}  ${librecom_multi_1_values["om_collectivite_libelle"]}

    # Ajouter le type de document avec le code '92' tel qu'il est dans la payload
    ${dnt_code} =  Set Variable  92
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Document numérisé Plat'AU
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Ajout d'un dossier

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${dossier_json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  EF-DSQ-4512  ${librecom_multi_1_values["acteur"]}
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  7SZ-SX8-TR4  000-AAA-15
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  2SZ-SX8-AZ6  AAA-000-15
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  00009  000011P0
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  13055  ${librecom_multi_1_values["insee"]}
    ${dossier_payload_dict} =  To Json  ${dossier_json_payload}

    # Ajoute d'une tâche de création de DI
    ${dossier_task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${dossier_json_payload}
    Ajouter la tâche par WS  ${dossier_task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${dossier_msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${dossier_task_values["type"]}
    ...  ${dossier_payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${dossier_msg}  ${di_regex}  \\1
    ${di_lib_sans_espace} =  Sans espace  ${di_lib}
    ${di_to_search} =  Replace String  ${di_lib_sans_espace}  ${librecom_multi_1_values["code_entite"]}  ${SPACE}${librecom_multi_1_values["code_entite"]}

    # En tant qu'instructeur de la collectivité/du service LIBRECOM_WS_PIECE_MULTI_1
    Depuis la page d'accueil  jproudhon  jproudhon

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_to_search}


    # Ajout de la pièce au dossier

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_multi_1_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-AAA-15
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-15
    ${json_payload} =  Replace String  ${json_payload}  "dossier_consultation": "FE4-JR5-8W",  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  "document_numerise_type_code": "90"  "document_numerise_type_code": "92"
    ${json_payload} =  Replace String  ${json_payload}  "nom_fichier": "2020112790.pdf"  "nom_fichier": "2020112792.pdf"
    ${piece_payload_dict} =  To Json  ${json_payload}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    # se rend sur la page de la tâche
    #Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    Depuis le contexte de la task  ${task_id}

    # vérifie qu'elle a bien été ajoutée
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['document_numerise']}
    Dictionary Should Contain Key  ${json_payload_loaded['document_numerise']}  uid

    ${uid} =  Set Variable  ${json_payload_loaded['document_numerise']['uid']}
    # On enlève le préfixe de l'uid
    ${uid_without_prefix} =  Get Substring  ${uid}  5
    ${path_1} =  Get Substring  ${uid}  5  7
    ${path_2} =  Get Substring  ${uid}  5  9

    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}.info

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS
    Log  ${msg}

    # Extraction du libellé du DI dans le message
    ${piece_di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]} *
    ...  :  pièce  :  '[^']+'  créée sur le dossier d'instruction '([^']+)'.*$
    ${piece_di_lib} =  Replace String Using Regexp  ${msg}  ${piece_di_regex}  \\1

    # Le DI devrait être le même que celui du dossier
    Should Be Equal  ${piece_di_lib}  ${di_lib_sans_espace}

    # Depuis la page des pièces du dossier
    Depuis l'onglet des pièces du dossier d'instruction  ${di_to_search}

    # Le nom du fichier doit être présent en tant que pièce
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be
    ...  css=table.document_numerise:nth-child(3) td a.lienDocumentNumerise span[title="Télécharger"]
    ...  ${piece_payload_dict["document_numerise"]["nom_fichier"]}

    # Depuis la pièce
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_to_search}
    ...  Document numérisé Plat'AU

    # La date de création doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#date_creation  27/11/2020

    # Le type de pièce doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#document_numerise_type
    ...  Document numérisé Plat'AU


    # Ajout d'un second dossier (simulant une seconde consultation sur le même dossier)

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Ajout d'une seconde entité
    &{librecom_multi_2_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_PIECE_MULTI_2
    ...  departement=016
    ...  commune=086
    ...  insee=16086
    ...  direction_code=C
    ...  direction_libelle=Direction de LIBRECOM_WS_PIECE_MULTI_2
    ...  direction_chef=Chef
    ...  division_code=C
    ...  division_libelle=Division C
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Peter Kropotkin
    ...  guichet_om_utilisateur_email=pkropotkin@openads-test.fr
    ...  guichet_om_utilisateur_login=pkropotkin
    ...  guichet_om_utilisateur_pwd=pkropotkin
    ...  instr_om_utilisateur_nom=Mikhail Bakunin
    ...  instr_om_utilisateur_email=mbakunin@openads-test.fr
    ...  instr_om_utilisateur_login=mbakunin
    ...  instr_om_utilisateur_pwd=mbakunin
    ...  code_entite=LBCOM_16
    ...  acteur=LIBRECOM-ACT-016
    Isolation d'un contexte  ${librecom_multi_2_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_multi_2_values["acteur"]}  ${librecom_multi_2_values["om_collectivite_libelle"]}

    # Active l'option entité pour la collectivité/le service
    &{param_entite} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=true
    ...  om_collectivite=${librecom_multi_2_values["om_collectivite_libelle"]}
    Ajouter ou modifier le paramètre depuis le menu  ${param_entite}

    # Ajoute le paramètre 'code_entite' à la collectivité/le service
    Ajouter le paramètre depuis le menu  code_entite
    ...  ${librecom_multi_2_values["code_entite"]}  ${librecom_multi_2_values["om_collectivite_libelle"]}


    # Ajout d'un dossier

    # Remplace certaines valeurs, mais conserve le même external_uid pour le dossier
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  ${librecom_multi_1_values["acteur"]}  ${librecom_multi_2_values["acteur"]}
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  AAA-000-15  AAA-000-16
    ${dossier_payload_dict} =  To Json  ${dossier_json_payload}

    # Ajoute d'une tâche de création de DI
    ${dossier_task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${dossier_json_payload}
    Ajouter la tâche par WS  ${dossier_task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${dossier_msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${dossier_task_values["type"]}
    ...  ${dossier_payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${dossier_msg}  ${di_regex}  \\1
    ${di_lib_sans_espace} =  Sans espace  ${di_lib}
    ${di_to_search} =  Replace String  ${di_lib_sans_espace}  ${librecom_multi_2_values["code_entite"]}  ${SPACE}${librecom_multi_2_values["code_entite"]}

    # En tant qu'instructeur de la collectivité/du service LIBRECOM_WS_PIECE_MULTI_2
    Depuis la page d'accueil  pkropotkin  pkropotkin

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_to_search}


    # Ajout de la même pièce au second dossier

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs, et conserve le même external_uid que la pièce ajoutée au dossier
    # précédent
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_multi_2_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-AAA-15
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-15
    ${json_payload} =  Replace String  ${json_payload}  "dossier_consultation": "FE4-JR5-8W",  ${EMPTY}
    ${piece_payload_dict} =  To Json  ${json_payload}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    # se rend sur la page de la tâche
    #Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    Depuis le contexte de la task  ${task_id}

    # vérifie qu'elle a bien été ajoutée
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['document_numerise']}
    Dictionary Should Contain Key  ${json_payload_loaded['document_numerise']}  uid

    ${uid} =  Set Variable  ${json_payload_loaded['document_numerise']['uid']}
    # On enlève le préfixe de l'uid
    ${uid_without_prefix} =  Get Substring  ${uid}  5
    ${path_1} =  Get Substring  ${uid}  5  7
    ${path_2} =  Get Substring  ${uid}  5  9

    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}.info

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS
    Log  ${msg}

    # Extraction du libellé du DI dans le message
    ${piece_di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]} *
    ...  :  pièce  :  '[^']+'  créée sur le dossier d'instruction '([^']+)'.*$
    ${piece_di_lib} =  Replace String Using Regexp  ${msg}  ${piece_di_regex}  \\1

    # Le DI devrait être le même que celui du dossier
    Should Be Equal  ${piece_di_lib}  ${di_lib_sans_espace}

    # Depuis la page des pièces du dossier
    Depuis l'onglet des pièces du dossier d'instruction  ${di_to_search}

    # Le nom du fichier doit être présent en tant que pièce
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be
    ...  css=table.document_numerise:nth-child(3) td a.lienDocumentNumerise span[title="Télécharger"]
    ...  ${piece_payload_dict["document_numerise"]["nom_fichier"]}

    # Depuis la pièce
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_to_search}
    ...  Document numérisé Plat'AU

    # La date de création doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#date_creation  27/11/2020

    # Le type de pièce doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#document_numerise_type
    ...  Document numérisé Plat'AU

    # desactiver l'option saisie complète des numéros
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}


Vérification de l'ajout d'une même pièce sur deux dossiers pour le même acteur
    [Documentation]  Permet de vérifier que la même pièce peut être ajoutée sur 2 dossiers
    ...  avec le même acteur

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # desactiver l'option dossier_commune et activer la saisie complète des numéros
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_multi_3_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_PIECE_MULTI_3
    ...  departement=018
    ...  commune=088
    ...  insee=18088
    ...  direction_code=D
    ...  direction_libelle=Direction de LIBRECOM_WS_PIECE_MULTI_3
    ...  direction_chef=Chef
    ...  division_code=D
    ...  division_libelle=Division D
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Malcom Ferdinand
    ...  guichet_om_utilisateur_email=mferdinand@openads-test.fr
    ...  guichet_om_utilisateur_login=mferdinand
    ...  guichet_om_utilisateur_pwd=mferdinand
    ...  instr_om_utilisateur_nom=Dominique Bourg
    ...  instr_om_utilisateur_email=dbourg@openads-test.fr
    ...  instr_om_utilisateur_login=dbourg
    ...  instr_om_utilisateur_pwd=dbourg
    ...  code_entite=LBCOM_18
    ...  acteur=LIBRECOM-ACT-018
    Isolation d'un contexte  ${librecom_multi_3_values}


    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_multi_3_values["acteur"]}  ${librecom_multi_3_values["om_collectivite_libelle"]}

    # Active l'option entité pour la collectivité/le service
    &{param_entite} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=true
    ...  om_collectivite=${librecom_multi_3_values["om_collectivite_libelle"]}
    Ajouter ou modifier le paramètre depuis le menu  ${param_entite}

    # Ajoute le paramètre 'code_entite' à la collectivité/le service
    Ajouter le paramètre depuis le menu  code_entite
    ...  ${librecom_multi_3_values["code_entite"]}  ${librecom_multi_3_values["om_collectivite_libelle"]}

    # Ajouter le type de document avec le code '93' tel qu'il est dans la payload
    ${dnt_code} =  Set Variable  93
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Document numérisé Plat'AU
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Ajout d'un dossier

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${dossier_json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  EF-DSQ-4512  ${librecom_multi_3_values["acteur"]}
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  7SZ-SX8-TR4  000-AAA-18
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  2SZ-SX8-AZ6  AAA-000-18
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  00009  000018P0
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  13055  ${librecom_multi_3_values["insee"]}
    ${dossier_payload_dict} =  To Json  ${dossier_json_payload}

    # Ajoute d'une tâche de création de DI
    ${dossier_task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${dossier_json_payload}
    Ajouter la tâche par WS  ${dossier_task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${dossier_msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex_1} =  Catenate  ^.*\\[[0-9]+\\]  ${dossier_task_values["type"]}
    ...  ${dossier_payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib_1} =  Replace String Using Regexp  ${dossier_msg}  ${di_regex_1}  \\1
    ${di_lib_sans_espace_1} =  Sans espace  ${di_lib_1}
    ${di_to_search_1} =  Replace String  ${di_lib_sans_espace_1}  ${librecom_multi_3_values["code_entite"]}  ${SPACE}${librecom_multi_3_values["code_entite"]}

    # En tant qu'instructeur de la collectivité/du service LIBRECOM_WS_PIECE_MULTI_3
    Depuis la page d'accueil  mferdinand  mferdinand

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_to_search_1}


    # Ajout d'un second dossier (simulant une seconde consultation sur le même dossier)

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Remplace certaines valeurs
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  AAA-000-18  BBB-000-18
    ${dossier_payload_dict} =  To Json  ${dossier_json_payload}

    # Ajoute d'une tâche de création de DI
    ${dossier_task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${dossier_json_payload}
    Ajouter la tâche par WS  ${dossier_task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${dossier_msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex_2} =  Catenate  ^.*\\[[0-9]+\\]  ${dossier_task_values["type"]}
    ...  ${dossier_payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib_2} =  Replace String Using Regexp  ${dossier_msg}  ${di_regex_2}  \\1
    ${di_lib_sans_espace_2} =  Sans espace  ${di_lib_2}
    ${di_to_search_2} =  Replace String  ${di_lib_sans_espace_2}  ${librecom_multi_3_values["code_entite"]}  ${SPACE}${librecom_multi_3_values["code_entite"]}

    # En tant qu'instructeur de la collectivité/du service LIBRECOM_WS_PIECE_MULTI_3
    Depuis la page d'accueil  mferdinand  mferdinand

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search_2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_to_search_2}


    # Ajout de la pièce au 1er dossier

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_multi_3_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-AAA-18
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-18
    ${json_payload} =  Replace String  ${json_payload}  FE4-JR5-8W  AAA-000-18
    ${json_payload} =  Replace String  ${json_payload}  "document_numerise_type_code": "90"  "document_numerise_type_code": "93"
    ${json_payload} =  Replace String  ${json_payload}  "nom_fichier": "2020112790.pdf"  "nom_fichier": "2020112793.pdf"
    ${piece_payload_dict} =  To Json  ${json_payload}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    # se rend sur la page de la tâche
    #Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    Depuis le contexte de la task  ${task_id}

    # vérifie qu'elle a bien été ajoutée
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['document_numerise']}
    Dictionary Should Contain Key  ${json_payload_loaded['document_numerise']}  uid

    ${uid} =  Set Variable  ${json_payload_loaded['document_numerise']['uid']}
    # On enlève le préfixe de l'uid
    ${uid_without_prefix} =  Get Substring  ${uid}  5
    ${path_1} =  Get Substring  ${uid}  5  7
    ${path_2} =  Get Substring  ${uid}  5  9

    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}.info

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS
    Log  ${msg}

    # Extraction du libellé du DI dans le message
    ${piece_di_regex_1} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]} *
    ...  :  pièce  :  '[^']+'  créée sur le dossier d'instruction '([^']+)'.*$
    ${piece_di_lib_1} =  Replace String Using Regexp  ${msg}  ${piece_di_regex_1}  \\1

    # Le DI devrait être le même que celui du dossier
    Should Be Equal  ${piece_di_lib_1}  ${di_lib_sans_espace_1}

    # Depuis la page des pièces du dossier
    Depuis l'onglet des pièces du dossier d'instruction  ${di_to_search_1}

    # Le nom du fichier doit être présent en tant que pièce
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be
    ...  css=table.document_numerise:nth-child(3) td a.lienDocumentNumerise span[title="Télécharger"]
    ...  ${piece_payload_dict["document_numerise"]["nom_fichier"]}

    # Depuis la pièce
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_to_search_1}
    ...  Document numérisé Plat'AU

    # La date de création doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#date_creation  27/11/2020

    # Le type de pièce doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#document_numerise_type
    ...  Document numérisé Plat'AU


    # Ajout de la même pièce au second dossier

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # modifie l'ID de la consultation
    ${json_payload} =  Replace String  ${json_payload}  AAA-000-18  BBB-000-18
    ${piece_payload_dict} =  To Json  ${json_payload}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    # se rend sur la page de la tâche
    #Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    Depuis le contexte de la task  ${task_id}

    # vérifie qu'elle a bien été ajoutée
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['document_numerise']}
    Dictionary Should Contain Key  ${json_payload_loaded['document_numerise']}  uid

    ${uid} =  Set Variable  ${json_payload_loaded['document_numerise']['uid']}
    # On enlève le préfixe de l'uid
    ${uid_without_prefix} =  Get Substring  ${uid}  5
    ${path_1} =  Get Substring  ${uid}  5  7
    ${path_2} =  Get Substring  ${uid}  5  9

    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}.info

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS
    Log  ${msg}

    # Extraction du libellé du DI dans le message
    ${piece_di_regex_2} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]} *
    ...  :  pièce  :  '[^']+'  créée sur le dossier d'instruction '([^']+)'.*$
    ${piece_di_lib_2} =  Replace String Using Regexp  ${msg}  ${piece_di_regex_2}  \\1

    # Le DI devrait être le même que celui du dossier
    Should Be Equal  ${piece_di_lib_2}  ${di_lib_sans_espace_2}

    # Depuis la page des pièces du dossier
    Depuis l'onglet des pièces du dossier d'instruction  ${di_to_search_2}

    # Le nom du fichier doit être présent en tant que pièce
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be
    ...  css=table.document_numerise:nth-child(3) td a.lienDocumentNumerise span[title="Télécharger"]
    ...  ${piece_payload_dict["document_numerise"]["nom_fichier"]}

    # Depuis la pièce
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_to_search_2}
    ...  Document numérisé Plat'AU

    # La date de création doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#date_creation  27/11/2020

    # Le type de pièce doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#document_numerise_type
    ...  Document numérisé Plat'AU

    # desactiver l'option saisie complète des numéros
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}


Vérification de l'ajout de la tâche Ajout pièce par IHM web, puis traitement
    [Documentation]  Permet de vérifier que l'ajout d'une pièce via l'IHM fonctionne

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # desactiver l'option dossier_commune et la saisie complète des numéros
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_IHM_PIECE
    ...  departement=017
    ...  commune=097
    ...  insee=17097
    ...  direction_code=Q
    ...  direction_libelle=Direction de LIBRECOM_IHM_PIECE
    ...  direction_chef=Chef
    ...  division_code=Q
    ...  division_libelle=Division Q
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Emmanuel Kant
    ...  guichet_om_utilisateur_email=ekant@openads-test.fr
    ...  guichet_om_utilisateur_login=ekant
    ...  guichet_om_utilisateur_pwd=ekant
    ...  instr_om_utilisateur_nom=Bertrand Russell
    ...  instr_om_utilisateur_email=brussell@openads-test.fr
    ...  instr_om_utilisateur_login=brussell
    ...  instr_om_utilisateur_pwd=brussell
    ...  code_entite=LBCOM_17
    ...  acteur=LIBRECOM-ACT-017
    Isolation d'un contexte  ${librecom_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_values["acteur"]}  ${librecom_values["om_collectivite_libelle"]}

    # Ajouter le type de document avec le code '94' tel qu'il est dans la payload
    ${dnt_code} =  Set Variable  94
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Document numérisé Plat'AU
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Récupère l'identifiant de la collectivité LIBRECOM_WS
    Depuis le contexte de la collectivité  ${librecom_values["om_collectivite_libelle"]}
    ${librecom_ws_id} =  Get Text  css=#om_collectivite

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${dossier_json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  EF-DSQ-4512  ${librecom_values["acteur"]}
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  7SZ-SX8-TR4  000-AAA-17
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  2SZ-SX8-AZ6  AAA-000-17
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  00009  00001P0
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  13055  ${librecom_values["insee"]}
    ${dossier_payload_dict} =  To Json  ${dossier_json_payload}

    # Ajoute d'une tâche de création de DI
    ${dossier_task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${dossier_json_payload}
    Ajouter la tâche par WS  ${dossier_task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${dossier_msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${dossier_task_values["type"]}
    ...  ${dossier_payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${dossier_msg}  ${di_regex}  \\1

    # En tant qu'instructeur de la collectivité/du service LIBRECOM_IHM_PIECE
    Depuis la page d'accueil  ekant  ekant

    # Vérifier que le dossier a bien été ajouté
    Depuis le contexte du dossier d'instruction  ${di_lib}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib}

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-AAA-17
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-17
    ${json_payload} =  Replace String  ${json_payload}  "dossier_consultation": "FE4-JR5-8W",  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  "document_numerise_type_code": "90"  "document_numerise_type_code": "94"
    ${json_payload} =  Replace String  ${json_payload}  "nom_fichier": "2020112790.pdf"  "nom_fichier": "2020112794.pdf"
    ${piece_payload_dict} =  To Json  ${json_payload}

    # Ajoute la tâche via l'IHM
    ${task_data_type} =  Create List  ${NONE}  add_piece
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

    # créé le dictionnaire qui va permettre de vérifier les infos de la tâche
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ...  task=${task_id}
    ...  state=new
    ...  stream=input

    # se rend sur la page de la tâche
    #Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    Depuis le contexte de la task  ${task_id}

    # vérifie qu'elle a bien été ajoutée
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['document_numerise']}
    Dictionary Should Contain Key  ${json_payload_loaded['document_numerise']}  uid

    ${uid} =  Set Variable  ${json_payload_loaded['document_numerise']['uid']}
    # On enlève le préfixe de l'uid
    ${uid_without_prefix} =  Get Substring  ${uid}  5
    ${path_1} =  Get Substring  ${uid}  5  7
    ${path_2} =  Get Substring  ${uid}  5  9

    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}
    File Should Exist  ..${/}var${/}${alternate_filestorage}${/}${path_1}${/}${path_2}${/}${uid_without_prefix}.info

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS
    Log  ${msg}

    # Extraction du libellé du DI dans le message
    ${piece_di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]} *
    ...  :  pièce  :  '[^']+'  créée sur le dossier d'instruction '([^']+)'.*$
    ${piece_di_lib} =  Replace String Using Regexp  ${msg}  ${piece_di_regex}  \\1

    # Le DI devrait être le même que celui du dossier
    Should Be Equal  ${piece_di_lib}  ${dossier_payload_dict["dossier"]["dossier"]}

    # Depuis la page des pièces du dossier
    Depuis l'onglet des pièces du dossier d'instruction  ${di_lib}

    # Le nom du fichier doit être présent en tant que pièce
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be
    ...  css=table.document_numerise:nth-child(3) td a.lienDocumentNumerise span[title="Télécharger"]
    ...  ${piece_payload_dict["document_numerise"]["nom_fichier"]}

    # Depuis la pièce
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_lib}
    ...  Document numérisé Plat'AU

    # La date de création doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#date_creation  27/11/2020

    # Le type de pièce doit correspondre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=#document_numerise_type
    ...  Document numérisé Plat'AU


Ajout d'une tâche de création de PeC avec vérification de la gestion du state annulé, et d'avis de consultation via WS, puis traitement
    [Documentation]  Vérification de la création des tâches *PeC consultation* et
    ...  *avis* en stream Sortant.
    ...  Vérification de la gestion de la tâche lors de la suppression de l'objet lié
    ...  si celle-ci à subit plusieurs modification de object_id.

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # desactiver l'option dossier_commune et activer la saisie complète des numéros
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # Active le mode service consulté
    &{param_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_service_consulte}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_multi_1_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_PEC_AVIS_1
    ...  departement=06
    ...  commune=095
    ...  insee=16095
    ...  direction_code=U
    ...  direction_libelle=Direction de LIBRECOM_WS_PEC_AVIS_1
    ...  direction_chef=Chef
    ...  division_code=U
    ...  division_libelle=Division U
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Adrien Caya
    ...  guichet_om_utilisateur_email=acaya@openads-test.fr
    ...  guichet_om_utilisateur_login=acaya
    ...  guichet_om_utilisateur_pwd=acaya
    ...  instr_om_utilisateur_nom=Mandel Deslauriers
    ...  instr_om_utilisateur_email=mdeslauriers@openads-test.fr
    ...  instr_om_utilisateur_login=mdeslauriers
    ...  instr_om_utilisateur_pwd=mdeslauriers
    ...  code_entite=LBCOM_19
    ...  acteur=LIBRECOM-ACT-019
    Isolation d'un contexte  ${librecom_multi_1_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_multi_1_values["acteur"]}  ${librecom_multi_1_values["om_collectivite_libelle"]}

    # Active l'option entité pour la collectivité/le service
    &{param_entite} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=true
    ...  om_collectivite=${librecom_multi_1_values["om_collectivite_libelle"]}
    Ajouter ou modifier le paramètre depuis le menu  ${param_entite}

    # Ajoute le paramètre 'code_entite' à la collectivité/le service
    Ajouter le paramètre depuis le menu  code_entite
    ...  ${librecom_multi_1_values["code_entite"]}  ${librecom_multi_1_values["om_collectivite_libelle"]}

    # Ajoute l'action et l'événement pour changer la prise en compte métier
    &{args_action} =  Create Dictionary
    ...  action=changer_pec
    ...  libelle=Changer PeC
    ...  regle_pec_metier=pec_metier
    Ajouter l'action depuis le menu  ${args_action}
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  DP - P - Initiale
    &{args_evenement} =  Create Dictionary
    ...  libelle=300 - Prise en compte métier
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=Changer PeC
    ...  etat=delai de notification envoye
    ...  pec_metier=Pris en compte
    ...  commentaire=true
    Ajouter l'événement depuis le menu  ${args_evenement}
    &{args_evenement_2} =  Create Dictionary
    ...  libelle=300 - Prise en compte métier 2
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=Changer PeC
    ...  etat=delai de notification envoye
    ...  pec_metier=Refusé (autre motif)
    ...  commentaire=true
    Ajouter l'événement depuis le menu  ${args_evenement_2}

    # Ajout d'un dossier

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${dossier_json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_min.txt

    # Remplace certaines valeurs
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  EF-DSQ-4512  ${librecom_multi_1_values["acteur"]}
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  7SZ-SX8-TR4  000-AAA-19
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  2SZ-SX8-AZ6  AAA-000-19
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  00009  000012P0
    ${dossier_json_payload} =  Replace String  ${dossier_json_payload}  13055  ${librecom_multi_1_values["insee"]}
    ${dossier_payload_dict} =  To Json  ${dossier_json_payload}

    # Ajoute d'une tâche de création de DI
    ${dossier_task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${dossier_json_payload}
    Ajouter la tâche par WS  ${dossier_task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${dossier_msg} =  Déclencher le traitement des tâches par WS

    # Extraction du libellé du DI dans le message
    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${dossier_task_values["type"]}
    ...  ${dossier_payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${dossier_msg}  ${di_regex}  \\1
    ${di_lib_sans_espace} =  Sans espace  ${di_lib}
    ${di_to_search} =  Replace String  ${di_lib_sans_espace}  ${librecom_multi_1_values["code_entite"]}  ${SPACE}${librecom_multi_1_values["code_entite"]}
    ${di_to_search_se} =  Sans espace  ${di_to_search}

    # Ajout d'une instruction de prise en compte et vérification de la modification
    # sur le dossier d'instruction, ainsi que de la création de la tâche
    ${instr_pec} =  Ajouter une instruction au DI  ${di_to_search}  300 - Prise en compte métier  null  null  null  null  commentaire sur la pec
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search}
    Element Should Contain  css=#fieldset-form-dossier_instruction-qualification  ${args_evenement.pec_metier}
    &{task_values} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  dossier=${di_to_search_se}
    ...  state=new
    ...  object_id=${instr_pec}
    ...  link_dossier=${di_to_search_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}
    # Vérification que le champ commentaire est bien intégré au json
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['instruction']}
    Dictionary Should Contain Key  ${json_payload_loaded['instruction']}  commentaire
    Dictionary Should Contain Value  ${json_payload_loaded['instruction']}  commentaire sur la pec

    # Ajout d'une deuxième instruction de prise en compte et vérification de la modification
    # sur le dossier d'instruction, ainsi que de la création de la tâche
    ${instr_pec_2} =  Ajouter une instruction au DI  ${di_to_search}  300 - Prise en compte métier  null  null  null  null  commentaire sur la pec 2
    # On ajoute 1 à l'id de l'instruction car dans le keyword 'ajouter une instruction au DI' on recheche le nom de l'évènement, or il existe deux évènements identiques du même nom, et c'est l'avant dernier qui est récupéré, sauf que nous voulons récupérer le dernier évènement 'Prise en compte métier'
    ${instr_pec_2} =  Evaluate  ${instr_pec_2} + 1
    ${instr_pec_2} =  Convert to String  ${instr_pec_2}
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search}
    Element Should Contain  css=#fieldset-form-dossier_instruction-qualification  ${args_evenement.pec_metier}
    &{task_values} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  dossier=${di_to_search_se}
    ...  state=new
    ...  object_id=${instr_pec_2}
    ...  link_dossier=${di_to_search_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    # Vérification que le champ commentaire est bien intégré au json
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['instruction']}
    Dictionary Should Contain Key  ${json_payload_loaded['instruction']}  commentaire
    Dictionary Should Contain Value  ${json_payload_loaded['instruction']}  commentaire sur la pec 2

    # Ajout d'une troisième instruction de prise en compte et vérification de la modification
    # sur le dossier d'instruction, ainsi que de la création de la tâche
    ${instr_pec_3} =  Ajouter une instruction au DI  ${di_to_search}  300 - Prise en compte métier 2  null  null  null  null  commentaire sur la pec 3
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search}
    Element Should Contain  css=#fieldset-form-dossier_instruction-qualification  ${args_evenement_2.pec_metier}
    &{task_values} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  dossier=${di_to_search_se}
    ...  state=new
    ...  object_id=${instr_pec_3}
    ...  link_dossier=${di_to_search_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    # Vérification que le champ commentaire est bien intégré au json
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['instruction']}
    Dictionary Should Contain Key  ${json_payload_loaded['instruction']}  commentaire
    Dictionary Should Contain Value  ${json_payload_loaded['instruction']}  commentaire sur la pec 3

    # Suppression de la troisième instruction de prise en compte métier
    Supprimer l'instruction  ${di_to_search}  ${instr_pec_3}
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search}
    Element Should Contain  css=#fieldset-form-dossier_instruction-qualification  ${args_evenement.pec_metier}
    &{task_values} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  dossier=${di_to_search_se}
    ...  state=new
    ...  object_id=${instr_pec_2}
    ...  link_dossier=${di_to_search_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    # Vérification que le champ commentaire est bien intégré au json
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['instruction']}
    Dictionary Should Contain Key  ${json_payload_loaded['instruction']}  commentaire
    Dictionary Should Contain Value  ${json_payload_loaded['instruction']}  commentaire sur la pec 2

    # Suppression de la deuxième instruction de prise en compte métier
    Supprimer l'instruction  ${di_to_search}  ${instr_pec_2}
    Depuis le contexte du dossier d'instruction par recherche  ${di_to_search}
    Element Should Contain  css=#fieldset-form-dossier_instruction-qualification  ${args_evenement.pec_metier}
    &{di_values} =  Create Dictionary
    ...  terrain_adresse_lieu_dit=lieu-dit
    Modifier le dossier d'instruction  ${di_to_search}  ${di_values}
    Element Should Contain  css=#fieldset-form-dossier_instruction-qualification  ${args_evenement.pec_metier}
    # TNR : vérifie que la modification du dossier ne change pas la pec

    &{task_values} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  dossier=${di_to_search_se}
    ...  state=new
    ...  object_id=${instr_pec}
    ...  link_dossier=${di_to_search_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    # Vérification que le champ commentaire est bien intégré au json
    ${json_payload_loaded} =  Récupérer le contenu du champ json_payload  ${task_values}
    Log Dictionary  ${json_payload_loaded['instruction']}
    Dictionary Should Contain Key  ${json_payload_loaded['instruction']}  commentaire
    Dictionary Should Contain Value  ${json_payload_loaded['instruction']}  commentaire sur la pec

    # Ajoute l'avis de décision et l'événement pour changer l'avis
    &{ad_values} =  Create Dictionary
    ...  libelle=Avis favorable
    ...  typeavis=favorable
    ...  avis_decision_type=Conforme
    ...  avis_decision_nature=Favorable
    Ajouter l'avis de décision  ${ad_values}
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  DP - P - Initiale
    &{args_evenement} =  Create Dictionary
    ...  libelle=300 - Avis favorable
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=accepter un dossier
    ...  etat=dossier accepter
    ...  avis_decision=${ad_values.libelle}
    Ajouter l'événement depuis le menu  ${args_evenement}

    # Ajout d'une instruction de décision et vérification de la création de la tâche
    ${instr_pec} =  Ajouter une instruction au DI  ${di_to_search}  300 - Avis favorable
    &{task_values} =  Create Dictionary
    ...  type=avis_consultation
    ...  dossier=${di_to_search_se}
    ...  state=new
    ...  object_id=${instr_pec}
    ...  link_dossier=${di_to_search_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}

    # Désactive le mode service consulté
    &{param_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_service_consulte}


Vérification du contrôle de données et déclencheur + vérification d'un retour d'avis de consultation
    [Documentation]  Vérifie le bon fonctionnement du contrôle de saisi des champs requis Plat'AU
    ...  et de la mise à jour des tâches en fonction de ce qui a été saisi dans le dossier.
    ...  La deuxième partie du test case permet de vérifier qu'un retour d'avis de consultation
    ...  réalisé par un tier est bien considéré comme non lu pour l'instructeur.
    ...  Test également :
    ...     - la présence de l'action de suppression de la consultation selon l'état de la tâche.
    ...     - l'état de la tâche si la consultation liée est supprimée.

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # Active le mode service consulté
    &{param_division} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_multi_1_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_CONTROLE_DONNEE_MULTI_1
    ...  departement=019
    ...  commune=100
    ...  insee=19100
    ...  direction_code=BCD
    ...  direction_libelle=Direction de LIBRECOM_WS_CONTROLE_DONNEE_MULTI_1
    ...  direction_chef=Chef
    ...  division_code=BCD
    ...  division_libelle=Division BCD
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Pacquenett Lerrault
    ...  guichet_om_utilisateur_email=plerrault@openads-test.fr
    ...  guichet_om_utilisateur_login=plerrault
    ...  guichet_om_utilisateur_pwd=plerrault
    ...  instr_om_utilisateur_nom=Molaine Trimard
    ...  instr_om_utilisateur_email=mtrimard@openads-test.fr
    ...  instr_om_utilisateur_login=mtrimard
    ...  instr_om_utilisateur_pwd=mtrimard
    ...  code_entite=LBCOM_24
    ...  acteur=LIBRECOM-ACT-024
    Isolation d'un contexte  ${librecom_multi_1_values}

    ${code_service1} =  Set Variable  300
    ${libelle_service1} =  Set Variable  TEST300SERVIC01
    &{args_service} =  Create Dictionary
    ...  abrege=${code_service1}
    ...  libelle=${libelle_service1}
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=LIBRECOM_WS_CONTROLE_DONNEE_MULTI_1
    ...  service_type=Plat'AU
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${args_service}

    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=LIBRECOM_WS_CONTROLE_DONNEE_MULTI_1
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOM01
    ...  particulier_prenom=TEST300TASKPRENOM01
    ...  om_collectivite=LIBRECOM_WS_CONTROLE_DONNEE_MULTI_1
    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    ${di_se} =  Sans espace  ${di}
    ${da} =  Replace String Using Regexp  ${di_se}  [A-Z][0-9]+$  ${EMPTY}

    Ajouter une consultation depuis un dossier  ${di}  ${code_service1} - ${libelle_service1}

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#sousform-consultation #service
    ${consultation_id} =  Get Value  css=#sousform-consultation #consultation

    # On vérifie le message concernant les champs requis

    Depuis l'onglet instruction du dossier d'instruction  ${di}
    ${instr_qualif} =  Get Text  css=td.col-0 a.lienTable

    # Ajout d'une pièce pour avoir un message de notication de l'instructeur
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=Test type document numerise de catégorie PLATAU
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    Click On Back Button In Subform
    Click Link  Test type document numerise de catégorie PLATAU
    # Form Value Should Contain  css=#sousform-document_numerise #document_numerise  4
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#sousform-document_numerise #uid
    ${document_numerise_id} =  Get Value  css=#sousform-document_numerise #document_numerise

    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Contain  css=div.panel_information.ui-state-demat-color p span.text  La transmission à Plat'AU n'est pas possible car certains champs requis ne sont pas saisis.
    Click Element  css=#fieldset-message-tab_demat-color legend

    Wait Until Element Is Visible  css=#fieldset-message-tab-content

    # On vérifie la liste des champs à saisir
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#fieldset-message-tab-content  Dans le formulaire données techniques le champ : date de signature
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#fieldset-message-tab-content  Dans le formulaire données techniques le champ : lieu de signature
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#fieldset-message-tab-content  Dans le formulaire dossier le champ : Localité
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#fieldset-message-tab-content  Dans le formulaire demandeur le champ : localité pour ${args_petitionnaire1.particulier_nom} ${args_petitionnaire1.particulier_prenom}

    # Vérification status des tâches, les tâche doivent être en draft
    &{task_values} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${da}
    ...  state=draft
    ...  object_id=${da}
    ...  link_dossier=${da}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_se}
    ...  state=draft
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${di_se}
    ...  state=draft
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di_se}
    ...  state=draft
    ...  object_id=${instr_qualif}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=ajout_piece
    ...  dossier=${di_se}
    ...  state=draft
    ...  object_id=${document_numerise_id}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=creation_consultation
    ...  dossier=${di_se}
    ...  state=draft
    ...  object_id=${consultation_id}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}

    &{args_dossier} =  Create Dictionary
    ...  terrain_adresse_localite=300TESTLocalite
    Modifier le dossier d'instruction  ${di}  ${args_dossier}

    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  modifier
    Open Fieldset  dossier_instruction  demandeur
    Click Element  css=.edit_demandeur
    Input Text  css=#localite  Plop
    Click Element  css=#sformulaire div.formControls input[type="button"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click Element  css=#sformulaire div.formControls a.retour

    # On rend le dossier transmissible
    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di}  ${donnees_techniques_values}

    # On vérifie qu'il n'y a plus de message concernant les champs requis
    # et que le formulaire du di est bien mis à jour lors du clic sur le bouton retour
    # de l'overlay
    Click On Back Button In Subform
    Element Should Not Be Visible  css=div.panel_information.ui-state-demat-color p span.text

    # Vérification status des tâches, les tâches doivent être en new car le dossier est transmissible
    &{task_values} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${da}
    ...  state=new
    ...  object_id=${da}
    ...  link_dossier=${da}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DA} =  Get Text  css=#task
    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DI} =  Get Text  css=#task
    &{task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_depot_DI} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${instr_qualif}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_qualification_DI} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=ajout_piece
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${document_numerise_id}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=creation_consultation
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${consultation_id}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    # TNR : on vérifie que si la tâche creation_consultation est à l'état new
    #       elle peut être supprimée
    Depuis le contexte de la consultation  ${di}  ${consultation_id}
    Portlet Action Should Be In SubForm  consultation  supprimer

    # On met les tâche à done pour dire qu'elles sont été transmisent à Plat'AU
    &{task_values_modif} =  Create Dictionary
    ...  state=terminé
    Modifier la task  ${id_creation_DA}  ${task_values_modif}

    &{task_values_modif} =  Create Dictionary
    ...  state=terminé
    Modifier la task  ${id_creation_DI}  ${task_values_modif}

    &{task_values_modif} =  Create Dictionary
    ...  state=terminé
    Modifier la task  ${id_depot_DI}  ${task_values_modif}

    &{args_dossier} =  Create Dictionary
    ...  date_affichage=${date_ddmmyyyy}
    Modifier le dossier d'instruction  ${di}  ${args_dossier}

    # Vérification status des tâches
    # &{task_values} =  Create Dictionary
    # ...  type=modification_DA
    # ...  dossier=${da}
    # ...  state=new
    # ...  object_id=${da}
    # ...  link_dossier=${da}
    # ...  stream=output
    # Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    # ${id_modification_DA} =  Get Text  css=#task
    &{task_values} =  Create Dictionary
    ...  type=modification_DI
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}

    ${id_modification_DI} =  Get Text  css=#task

    # On ajoute un architecte à partir des données techniques sans mettre de ville (requis pour transmission à Plat'AU)
    &{args_architecte} =  Create Dictionary
    ...  nom=TESTDECLENCHEURNOM
    ...  prenom=TESTDECLENCHEURPRENOM
    ...  adresse1=5 Bis rue du test
    ...  adresse2=
    ...  cp=13200
    ...  pays=France
    ...  telephone=0235645201
    ...  email=declencheur@test.com
    ${id_architecte} =  Ajouter l'architecte  ${di}  ${args_architecte}

    # On vérifie que le message est modifié
    Depuis le contexte du dossier d'instruction  ${di}

    Element Should Contain  css=div.panel_information.ui-state-demat-color p span.text  La transmission des modifications à Plat'AU n'est pas possible car certains champs requis ne sont pas saisis.
    Click Element  css=#fieldset-message-tab_demat-color legend

    Wait Until Element Is Visible  css=#fieldset-message-tab-content

    Element Should Contain  css=#fieldset-message-tab-content  Dans le formulaire architecte le champ : ville

    # Vérification status des tâches, il faut qu'elles soient en draft
    # &{task_values} =  Create Dictionary
    # ...  type=modification_DA
    # ...  dossier=${da}
    # ...  state=draft
    # ...  object_id=${da}
    # ...  link_dossier=${da}
    # ...  stream=output
    # Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=modification_DI
    ...  dossier=${di_se}
    ...  state=draft
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di_se}
    ...  state=draft
    ...  object_id=${instr_qualif}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_qualification_DI} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=ajout_piece
    ...  dossier=${di_se}
    ...  state=draft
    ...  object_id=${document_numerise_id}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=creation_consultation
    ...  dossier=${di_se}
    ...  state=draft
    ...  object_id=${consultation_id}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    # TNR : on vérifie que si la tâche creation_consultation n'est pas à l'état new
    #       elle ne peut pas être supprimée
    Depuis le contexte de la consultation  ${di}  ${consultation_id}
    Portlet Action Should Not Be In SubForm  consultation  supprimer
    
    # On ajoute la ville à l'architecte
    &{args_architecte} =  Create Dictionary
    ...  ville=ville test
    Modifier l'architecte  ${di}  ${args_architecte}

    # On vérifie qu'il n'y a plus de message concernant les champs requis
    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Not Be Visible  css=div.panel_information.ui-state-demat-color p span.text

    &{task_values} =  Create Dictionary
    ...  type=modification_DI
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${instr_qualif}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_qualification_DI} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=ajout_piece
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${document_numerise_id}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    &{task_values} =  Create Dictionary
    ...  type=creation_consultation
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${consultation_id}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    # Traitement des tâches précédentes pour ne pas impacter la tâche de pec
    ${msg} =  Déclencher le traitement des tâches par WS

    #
    # Vérifie que le retour d'avis de consultation depuis Plat'AU soit considéré comme non lu.
    #

    # Préparation et traitement de la tache de retour d'avis de la consultation
    # Récupération de l'external uid du dossier si il existe. Sinon on le créé
    ${external_uid_di} =  Set Variable  EXT_UID_DOS
    &{external_uid_values} =  Create Dictionary
    ...  object=dossier
    ...  object_id=${di_se}
    ...  external_uid=${external_uid_di}
    ...  dossier=${di_se}
    ...  category=platau
    ${status} =  Run Keyword And Return Status  Récupérer un external UID  ${di_se}  dossier
    Run Keyword If  ${status} == False  Ajouter un external UID  ${external_uid_values}
    # Récupération de l'external uid de la consultation si elle existe. Sinon on la créé
    ${external_uid_consult} =  Set Variable  EXT_UID_CSL
    &{external_uid_values} =  Create Dictionary
    ...  object=consultation
    ...  object_id=${consultation_id}
    ...  external_uid=${external_uid_consult}
    ...  dossier=${di_se}
    ...  category=platau
    ${status} =  Run Keyword And Return Status  Récupérer un external UID  ${consultation_id}  consultation
    Run Keyword If  ${status} == False  Ajouter un external UID  ${external_uid_values}

    # Simulation retour PEC négative avec liste des pièces manquantes
    # Création des types de pièces spécifiques pour la vérification
    ${dnt_code_1} =  Set Variable  DNTPEC1
    ${dnt_libelle_1} =  Set Variable  TEST300PECNEGPMANQUANTES001
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code_1}
    ...  libelle=${dnt_libelle_1}
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    ${dnt_code_2} =  Set Variable  DNTPEC2
    ${dnt_libelle_2} =  Set Variable  TEST300PECNEGPMANQUANTES002
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code_2}
    ...  libelle=${dnt_libelle_2}
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}
    ${nomenclature_code} =  Set Variable  CODECERFA1
    &{nomenclature_values} =  Create Dictionary
    ...  document_numerise_type=${dnt_libelle_2}
    ...  dossier_instruction_type=PCI Initial
    ...  code=${nomenclature_code}
    Ajouter une nomenclature de piece  ${nomenclature_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    ${dnt_code_3} =  Set Variable  DNTPEC3
    ${dnt_libelle_3} =  Set Variable  TEST300PECNEGPMANQUANTES003
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code_3}
    ...  libelle=${dnt_libelle_3}
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}

    # Ajout d'une tache de prise en compte (PeC) avec document
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_pec_metier_consultation_input.json
    ${json_payload} =  Replace String  ${json_payload}  AAA-BBB-CCC  ${external_uid_consult}
    ${json_payload} =  Replace String  ${json_payload}  RRR-SSS-TTT  ${external_uid_di}
    ${json_payload} =  Replace String  ${json_payload}  OOO-PPP-QQQ  EXT-UID-PEC
    ${json_payload} =  Replace String  ${json_payload}  XXX  ${dnt_code_1}
    ${json_payload} =  Replace String  ${json_payload}  YYY  ${dnt_code_2}
    ${task_values} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}  application

    # Vérification que la tâche a bien été ajoutée
    ${task_to_find} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  state=new
    ...  stream=input
    ...  task=${task_id}
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_to_find}

    # Traitement de la tâches pec_metier_consultation    
    ${msg} =  Déclencher le traitement des tâches par WS

    # On vérifie que la motivation de la consultation liste les pièces manquantes
    Depuis le contexte de la consultation  ${di}  ${consultation_id}
    Element Should Contain  css=#motif_pec  ${dnt_libelle_1}
    Element Should Contain  css=#motif_pec  ${nomenclature_code} | ${dnt_libelle_2}

    #
    # Ajout d'une tache de prise en compte (PeC) sans document
    #
    # L'ajout et le traitement d'une PeC métier sans document après celui d'une PeC avec document
    # dois modifier la PeC sur la consultation.
    # /!\ - Actuellement le document associé à la précédente PeC n'est pas supprimé lors du traitement de
    # la PeC sans document. Ce comportement est normal. Le cas d'une PeC avec doc suivi d'une PeC 
    # sans doc n'existe pas pour le moment.
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_pec_metier_consultation_sans_document_input.json
    ${json_payload} =  Replace String  ${json_payload}  AAA-BBB-CCC  ${external_uid_consult}
    ${json_payload} =  Replace String  ${json_payload}  RRR-SSS-TTT  ${external_uid_di}
    ${json_payload} =  Replace String  ${json_payload}  OOO-PPP-QQQ  EXT-UID-PEC
    ${json_payload} =  Replace String  ${json_payload}  XXX  ${dnt_code_3}
    ${json_payload} =  Replace String  ${json_payload}  YYY  ${dnt_code_2}
    # Création de la tâches pec_metier_consultation
    ${task_values} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}  application

    # Vérification que la tâche a bien été ajoutée
    ${task_to_find} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  state=new
    ...  stream=input
    ...  task=${task_id}
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_to_find}

    # Traitement de la tâches pec_metier_consultation    
    ${msg} =  Déclencher le traitement des tâches par WS

    # On vérifie que la motivation de la consultation liste les pièces manquantes
    Depuis le contexte de la consultation  ${di}  ${consultation_id}
    Element Should Contain  css=#motif_pec  ${dnt_libelle_3}
    Element Should Contain  css=#motif_pec  ${nomenclature_code} | ${dnt_libelle_2}

    # La pec contient aussi un fichier qui est ajouté à la consultation
    # On vérifie ici que le champ fichier_pec a bien été mis à jour
    Element Should Contain  css=#fichier_pec  consultation_pec_${consultation_id}.pdf

    # On vérifie que le document de la pec est présent dans le sous onglet téléchargement.
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie que le retour d'avis est présent
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Click Element  css=div.switcher__label[data-view="document_numerise_telechargement"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  consultation_pec_${consultation_id}

    # Simulation du retour d'avis via platau
    &{external_uids_consultation} =  Create Dictionary
    ...  avis=EXT-UID-AVI
    ...  consultation=${external_uid_consult}
    ...  dossier=${external_uid_di}
    &{data_avis_consultation} =  Create Dictionary
    ...  avis_consultation=3
    ...  date_avis=2022-05-05
    ...  date_emission=2022-05-05
    ...  nom_auteur=Charlebois
    ...  prenom_auteur=Slainie
    ...  qualite_auteur=adjoint de quelqu'un
    ...  texte_avis=Avis favorable au titre du plop, sous réserve d'autres plop.
    ...  texte_fondement_avis=Construction en continuité du bâti existant.
    Rendre un avis par WS  ${external_uids_consultation}  ${data_avis_consultation}

    # On vérifie que la consultation est bien marquée comme non lu
    Depuis le contexte de la consultation  ${di}  ${consultation_id}
    Element Should Contain  css=#lu  Non

    # On vérifie que l'avis a bien été mis à jour
    Element Should Contain  css=#avis_consultation  Favorable avec Reserve
    Element Should Contain  css=#date_retour  05/05/2022
    Element Should Contain  css=#nom_auteur  Charlebois
    Element Should Contain  css=#prenom_auteur  Slainie
    Element Should Contain  css=#qualite_auteur  adjoint de quelqu'un
    Element Should Contain  css=#texte_avis  Avis favorable au titre du plop, sous réserve d'autres plop.
    Element Should Contain  css=#texte_fondement_avis  Construction en continuité du bâti existant.
    # On vérifie que le fichier possède bien l'extension ".pdf"
    Element Should Contain  css=#fichier  .pdf

    # TNR : vérifie que la suppression de la tâche création_consultation entraine son annulation
    # si la tâche associé n'a pas été traité.
    # Note : Les consultations ne peuvent être supprimé que si la tâche associée est "à traité".
    # La suppression d'une consultation transmise pour vérifier sa non annulation ne peut donc pas être testé.
    Ajouter une consultation depuis un dossier  ${di}  ${code_service1} - ${libelle_service1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#sousform-consultation #service
    ${consultation_id} =  Get Value  css=#sousform-consultation #consultation

    Supprimer la consultation depuis le contexte du dossier d'instruction  ${di}  ${consultation_id}

    # La tâche lié à la consultation dois être annulé
    ${task_to_find} =  Create Dictionary
    ...  type=creation_consultation
    ...  dossier=${di_se}
    ...  object_id=${consultation_id}
    ...  state=canceled
    ...  stream=output
    ...  link_dossier=${di_se}
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_to_find}


    # Vérification du contrôle de données et déclencheur pour les DOC et DAACT
    # (champs spécifique requis pour la transmission)

    # Clotûre le dernier DI du DA pour permettre l'ajout d'un nouveau dossier
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve

    # Ajout d'une DOC
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande d'ouverture de chantier
    ...  dossier_instruction=${di}
    ${di_doc} =  Ajouter la demande par WS  ${args_demande}
    ${di_doc_se} =  Sans espace  ${di_doc}

    Depuis l'onglet instruction du dossier d'instruction  ${di_doc}
    ${instr_qualif} =  Get Text  css=td.col-0 a.lienTable

    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_doc_se}
    ...  state=draft
    ...  object_id=${di_doc_se}
    ...  link_dossier=${di_doc_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DI} =  Get Text  css=#task
    &{task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${di_doc_se}
    ...  state=draft
    ...  object_id=${di_doc_se}
    ...  link_dossier=${di_doc_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_depot_DI} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di_doc_se}
    ...  state=draft
    ...  object_id=${instr_qualif}
    ...  link_dossier=${di_doc_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_qualification_DI} =  Get Text  css=#task

    # On rend le dossier transmissible
    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    ...  doc_date=${date_ddmmyyyy}
    ...  doc_surf=123
    Saisir les données techniques du DI  ${di_doc}  ${donnees_techniques_values}

    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_doc_se}
    ...  state=new
    ...  object_id=${di_doc_se}
    ...  link_dossier=${di_doc_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DI} =  Get Text  css=#task
    &{task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${di_doc_se}
    ...  state=new
    ...  object_id=${di_doc_se}
    ...  link_dossier=${di_doc_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_depot_DI} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di_doc_se}
    ...  state=new
    ...  object_id=${instr_qualif}
    ...  link_dossier=${di_doc_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_qualification_DI} =  Get Text  css=#task

    # Vérification de la nonexistance de la tâches de création de DI
    Depuis le menu Moniteur Plat'AU
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Création demande
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Création demande
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${di_doc_sans_espace}

    # Clotûre le dernier DI du DA pour permettre l'ajout d'un nouveau dossier
    ${id_instr} =  Ajouter une instruction au DI et la finaliser  ${di_doc}  accepter un dossier sans réserve

    # Ajout d'une DAACT
    &{args_demande} =  Create Dictionary
    ...  demande_type=Déclaration attestant l'achèvement et la conformité des travaux
    ...  dossier_instruction=${di}
    ${di_daact} =  Ajouter la demande par WS  ${args_demande}
    ${di_daact_se} =  Sans espace  ${di_daact}

    Depuis l'onglet instruction du dossier d'instruction  ${di_daact}
    ${instr_qualif} =  Get Text  css=td.col-0 a.lienTable

    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_daact_se}
    ...  state=draft
    ...  object_id=${di_daact_se}
    ...  link_dossier=${di_daact_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DI} =  Get Text  css=#task
    &{task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${di_daact_se}
    ...  state=draft
    ...  object_id=${di_daact_se}
    ...  link_dossier=${di_daact_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_depot_DI} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di_daact_se}
    ...  state=draft
    ...  object_id=${instr_qualif}
    ...  link_dossier=${di_daact_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_qualification_DI} =  Get Text  css=#task

    # On rend le dossier transmissible
    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    ...  daact_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di_daact}  ${donnees_techniques_values}

    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_daact_se}
    ...  state=new
    ...  object_id=${di_daact_se}
    ...  link_dossier=${di_daact_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DI} =  Get Text  css=#task
    &{task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${di_daact_se}
    ...  state=new
    ...  object_id=${di_daact_se}
    ...  link_dossier=${di_daact_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_depot_DI} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=qualification_DI
    ...  dossier=${di_daact_se}
    ...  state=new
    ...  object_id=${instr_qualif}
    ...  link_dossier=${di_daact_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_qualification_DI} =  Get Text  css=#task

    # Vérification de la nonexistance de la tâches de création de DI
    Depuis le menu Moniteur Plat'AU
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Création demande
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Création demande
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${di_daact_sans_espace}

    # Clotûre le dernier DI du DA pour permettre l'ajout d'un nouveau dossier
    Ajouter une instruction au DI et la finaliser  ${di_daact}  accepter un dossier sans réserve

    # Vérification du fonctionnement de la gestion des consultations et des tâches pec_metier_consultation
    # en input lorsqu'un dossier et sa consultation ont été supprimé directement depuis openads

    # On active l'option de suppression
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    Depuis l'instruction du dossier d'instruction  ${di_daact}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  definaliser
    Supprimer l'instruction  ${di_daact}  accepter un dossier sans réserve
    Supprimer le dossier d'instruction  ${di_daact}

    Depuis l'instruction du dossier d'instruction  ${di_doc}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  definaliser
    Supprimer l'instruction  ${di_doc}  accepter un dossier sans réserve
    Supprimer le dossier d'instruction  ${di_doc}

    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  definaliser
    Supprimer l'instruction  ${di}  accepter un dossier sans réserve

    # Ajout d'une consultation vers un service plat'au
    Ajouter une consultation depuis un dossier  ${di}  ${code_service1} - ${libelle_service1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#sousform-consultation #service
    ${consultation_id2} =  Get Value  css=#sousform-consultation #consultation

    # Création dans la table de lien id_interne_uid_externe d'un nouveau lien entre id openads etid plat'au
    ${external_uid_consult2} =  Set Variable  EXT_UID_CSL2
    &{external_uid_values2} =  Create Dictionary
    ...  object=consultation
    ...  object_id=${consultation_id2}
    ...  external_uid=${external_uid_consult2}
    ...  dossier=${di_se}
    ...  category=platau
    ${status} =  Run Keyword And Return Status  Récupérer un external UID  ${consultation_id2}  consultation
    Run Keyword If  ${status} == False  Ajouter un external UID  ${external_uid_values2}

    # Modification de la json payload pour changer l'uid de la consultation
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_pec_metier_consultation_input.json
    ${json_payload} =  Replace String  ${json_payload}  AAA-BBB-CCC  ${external_uid_consult2}
    ${json_payload} =  Replace String  ${json_payload}  RRR-SSS-TTT  ${external_uid_di}
    ${json_payload} =  Replace String  ${json_payload}  OOO-PPP-QQQ  EXT-UID-PEC2
    ${json_payload} =  Replace String  ${json_payload}  XXX  ${dnt_code_1}
    ${json_payload2} =  Replace String  ${json_payload}  YYY  ${dnt_code_2}

    # Création de la tâches pec_metier_consultation
    ${task_values} =  Create Dictionary
    ...  type=pec_metier_consultation
    ...  json_payload=${json_payload2}
    ...  state=new
    ...  stream=input
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    Supprimer la consultation depuis le contexte du dossier d'instruction  ${di}  ${consultation_id2}
    Supprimer le dossier d'instruction  ${di}

    # Ces vérifications doivent généré un log "Le dossier XXX n'existe pas" sur la tâche pec_metier_consultation
    ${msg} =  Déclencher le traitement des tâches par WS  false
    Should Match Regexp  ${msg}  pec_metier_consultation : InvalidArgumentException : Le dossier EXT_UID_DOS n'existe pas.


Désactivation de la configuration du filestorage alternatif
    # On remet la configuration du filestorage par défaut
    Move File  ..${/}dyn${/}filestorage.inc.php.bak  ..${/}dyn${/}filestorage.inc.php


Vérification de l'ajout (app) d'un dossier d'instruction sur existant + Vérification du filtre sur les types de dossier d'instruction
    [Documentation]  Le but est de vérifier que l'ajout de la tâche creation_DI et creation_DA
    ...  est bien effectué lors de l'ajout d'un dossier sur existant.
    ...  Permet de vérifier que le paramètre *dit_code__to_transmit__platau*
    ...  filtre bien la transmission Plat'AU d'un DI en fonction du type de DI.

    # Ajout d'un dossier initial et traitement de toutes les tâches de création de dossier.
    Depuis la page d'accueil  admin  admin
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300AdresseLocalite
    &{args_petitionnaire2} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOMM
    ...  particulier_prenom=TEST300TASKPRENOMM
    ...  localite=TEST300Localite
    ...  om_collectivite=MARSEILLE
    ${di2} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire2}

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di2}  ${donnees_techniques_values}

    ${di2_sans_espace} =  Sans espace  ${di2}
    ${di2_da} =  Replace String Using Regexp  ${di2_sans_espace}  [A-Z][0-9]+$  ${EMPTY}

    &{task_values} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${di2_da}
    ...  state=new
    ...  object_id=${di2_da}
    ...  link_dossier=${di2_da}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DA} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di2_sans_espace}
    ...  state=new
    ...  object_id=${di2_sans_espace}
    ...  link_dossier=${di2_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DI} =  Get Text  css=#task

    # On traite les tâches output pour qu'elles soient en 'terminé'
    &{task_values_modif} =  Create Dictionary
    ...  state=terminé
    Modifier la task  ${id_creation_DI}  ${task_values_modif}
    La page ne doit pas contenir d'erreur
    Modifier la task  ${id_creation_DA}  ${task_values_modif}
    La page ne doit pas contenir d'erreur

    Ajouter une instruction au DI et la finaliser  ${di2}  accepter un dossier sans réserve

    # Sans le paramètre *dit_code__to_transmit__platau* renseigné, tous les types de DI sont transmissibles

    # Ajout d'un dossier modificatif et vérification de la bonne création de la tâche creation_modif
    # liste des taches possible pour un modificatif
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di2}
    ${di_modif} =  Ajouter la demande par WS  ${args_demande}

    ${di_modif_sans_espace} =  Sans espace  ${di_modif}
    ${di_modif_da} =  Replace String Using Regexp  ${di_modif_sans_espace}  [A-Z][0-9]+$  ${EMPTY}

    # Si le dossier d'autorisation n'a pas de lien_id_interne_uid_externe
    # alors on ajoute une nouvelle tache creation_DA
    &{task_values} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${di2_da}
    ...  state=new
    ...  object_id=${di2_da}
    ...  link_dossier=${di2_da}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_da_modif} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_modif_sans_espace}
    ...  state=new
    ...  object_id=${di_modif_sans_espace}
    ...  link_dossier=${di_modif_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_di_modif} =  Get Text  css=#task

    &{task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${di_modif_sans_espace}
    ...  state=new
    ...  object_id=${di_modif_sans_espace}
    ...  link_dossier=${di_modif_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_depot_modif} =  Get Text  css=#task

    Modifier la task  ${id_creation_di_modif}  ${task_values_modif}
    La page ne doit pas contenir d'erreur
    Modifier la task  ${id_creation_da_modif}  ${task_values_modif}
    La page ne doit pas contenir d'erreur
    Modifier la task  ${id_depot_modif}  ${task_values_modif}
    La page ne doit pas contenir d'erreur

    # Avec le paramètre *dit_code__to_transmit__platau* renseigné, seulement les types de DI
    # identifiés sont transmissibles

    # Autorise la transmission sur les modificatifs et transferts
    &{param_dit_filtre} =  Create Dictionary
    ...  libelle=dit_code__to_transmit__platau
    ...  valeur=M;T
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dit_filtre}

    # Clotûre le dernier DI du DA pour permettre l'ajout d'un nouveau dossier
    Ajouter une instruction au DI et la finaliser  ${di_modif}  accepter un dossier sans réserve
    # Ajout d'un modificatif transmissible
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di2}
    ${di_modif_2} =  Ajouter la demande par WS  ${args_demande}
    ${di_modif_2_sans_espace} =  Sans espace  ${di_modif_2}
    # Vérification de l'existance de la tâches de création de DI
    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_modif_2_sans_espace}
    ...  state=new
    ...  object_id=${di_modif_2_sans_espace}
    ...  link_dossier=${di_modif_2_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_depot_modif_2} =  Get Text  css=#task
    Modifier la task  ${id_depot_modif_2}  ${task_values_modif}
    La page ne doit pas contenir d'erreur

    # Modification du paramètre pour que les modificatifs ne soient plus transmissibles
    &{param_dit_filtre} =  Create Dictionary
    ...  libelle=dit_code__to_transmit__platau
    ...  valeur=T
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dit_filtre}

    # Clotûre le dernier DI du DA pour permettre l'ajout d'un nouveau dossier
    Ajouter une instruction au DI et la finaliser  ${di_modif_2}  accepter un dossier sans réserve
    # Ajout d'un modificatif non transmissible
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di2}
    ${di_modif_3} =  Ajouter la demande par WS  ${args_demande}
    ${di_modif_3_sans_espace} =  Sans espace  ${di_modif_3}
    # Vérification de la nonexistance de la tâches de création de DI
    Depuis le menu Moniteur Plat'AU
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Création demande
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Création demande
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${di_modif_3_sans_espace}

    # Clotûre le dernier DI du DA pour permettre l'ajout d'un nouveau dossier
    Ajouter une instruction au DI et la finaliser  ${di_modif_3}  accepter un dossier sans réserve
    # Ajout d'un transfert transmissible
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de transfert
    ...  dossier_instruction=${di2}
    ${di_trsf} =  Ajouter la demande par WS  ${args_demande}
    ${di_trsf_sans_espace} =  Sans espace  ${di_trsf}
    # Vérification de l'existance de la tâches de création de DI
    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_trsf_sans_espace}
    ...  state=new
    ...  object_id=${di_trsf_sans_espace}
    ...  link_dossier=${di_trsf_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_depot_trsf} =  Get Text  css=#task
    Modifier la task  ${id_depot_trsf}  ${task_values_modif}
    La page ne doit pas contenir d'erreur

    # Suppression du paramètre de filtre des types de DI
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=dit_code__to_transmit__platau
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}


Vérification des fiches de synthèse des dossiers d'instruction et de l'icône pour consulter depuis le listing
    [Documentation]  Contrôle les affichages spécifiques pour le DI.
    ...
    ...  Les cas d'affichage possibles pour le fieldset "Consultation" :
    ...  1/ Vérifications concernant l'affichage de type "CONSULTATION ENTRANTE"
    ...     a- Avoir le type d'affichage du type de DA avec la valeur
    ...        "CONSULTATION ENTRANTE" + source dépôt de la demande à 'platau' ou 'portal'.
    ...     b- Vérifie depuis le menu Guichet Unique > Nouveau dossier que l'ajout
    ...        d'une demande de "CONSULTATION ENTRANTE" ne permet la saisie que du pétionnaire
    ...        principal et pas des autres types de demandeur principal.
    ...     c- Vérifie que pour un affichage de type "CONSULTATION ENTRANTE" l'instructeur
    ...        secondaire est visible dans la synthèse et en modification du DI.
    ...  2/ Dans tous les autres cas le fieldset ne doit pas être affiché.
    ...
    ...  Dans les deux cas précédents, on vérifie également la classe de l'icône pour
    ...  consulter le dossier. Flêche jaune, le dossier est dématérialisé (cas 1) ; flêche
    ...  bleue le dossier est papier (cas 2).
    ...
    ...  Les cas d'affichage possibles pour le fieldset "Plat'AU : identifiants techniques" :
    ...  1/ Le type du datd est transmis à Plat'AU + l'option option_mode_service_consulte est
    ...  activée + source dépôt de la demande à 'platau' ou 'portal'.
    ...  2/ Le type du datd est transmis à Plat'AU + l'option option_mode_service_consulte est
    ...  désactivée
    ...  3/ Dans tous les autres cas le fieldset ne doit pas être affiché.

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # activer la saisie complète des numéros
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_multi_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_AFF_DI
    ...  departement=016
    ...  commune=099
    ...  insee=16099
    ...  direction_code=V
    ...  direction_libelle=Direction de LIBRECOM_WS_AFF_DI
    ...  direction_chef=Chef
    ...  division_code=V
    ...  division_libelle=Division V
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Merci Collin
    ...  guichet_om_utilisateur_email=mcollin@openads-test.fr
    ...  guichet_om_utilisateur_login=mcollin
    ...  guichet_om_utilisateur_pwd=mcollin
    ...  instr_om_utilisateur_nom=Carolos Beauchemin
    ...  instr_om_utilisateur_email=cbeauchemin@openads-test.fr
    ...  instr_om_utilisateur_login=cbeauchemin
    ...  instr_om_utilisateur_pwd=cbeauchemin
    ...  code_entite=LBCOM_20
    ...  acteur=LIBRECOM-ACT-020
    Isolation d'un contexte  ${librecom_multi_values}

    # récupération de l'identifiant de l'instructeur de la collectivité
    Depuis le contexte de l'instructeur  ${librecom_multi_values["instr_om_utilisateur_nom"]}
    ${librecom_instr_id} =  Get Text  css=span#instructeur

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_multi_values["acteur"]}  ${librecom_multi_values["om_collectivite_libelle"]}

    # Change le type affichage du type de DA
    &{args_da_type} =  Create Dictionary
    ...  affichage_form=CONSULTATION ENTRANTE
    Modifier le type de dossier d'autorisation  Permis de construire  ${args_da_type}

    # Fieldset "Consultation" cas 1/
    # Avoir le type d'affichage du type de DA avec la valeur "CONSULTATION ENTRANTE"
    # + source dépôt portal ou platau.
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=LIBRECOM_WS_AFF_DI
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300AdresseLocalite
    ...  depot_electronique=true
    ...  source_depot=platau
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOM03
    ...  particulier_prenom=TEST300TASKPRENOM03
    ...  localite=TEST300Localite
    ...  om_collectivite=LIBRECOM_WS_AFF_DI
    ${di_case_1} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    # TNR : Vérification que l'ajout de la demande via le menu ne permet de saisir
    # que le pétitionnaire principal et pas les autres types de demandeur
    # principaux
    Depuis le contexte de nouvelle demande via l'URL
    &{args_demande} =  Create Dictionary
    ...  om_collectivite=LIBRECOM_WS_AFF_DI
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    Saisir la demande  ${args_demande}

    Wait Until Element Is Visible  css=#add_petitionnaire_principal
    @{petitionnaires}=    Create List  requerant_principal  contrevenant_principal  bailleur_principal  plaignant_principal  avocat_principal
    :FOR  ${petitionnaire}  IN  @{petitionnaires}
    \  Element Should Not Be Visible  css=#add_${petitionnaire}
    # Vérification de l'icône du listing : la ligne doit avoir la classe consult-demat
    Depuis le listing  dossier_instruction
    ${di_case_1_sans_espace} =  Sans espace  ${di_case_1}
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di_case_1_sans_espace}
    Click On Search Button
    Element Should Be Visible  css=table.tab-tab tr.consult-demat

    # TNR vérification que le champs instructeur secondaire n'est pas visible en consultation par défaut
    Depuis le contexte du dossier d'instruction  ${di_case_1}
    Page Should Not Contain  css=#lib-instructeur_2
    # TNR vérification que le champs instructeur secondaire est visible en modification
    Click On Form Portlet Action  dossier_instruction  modifier
    Element Should Contain  css=#instructeur_2  choisir l'instructeur secondaire

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di_case_1}  ${donnees_techniques_values}

    Depuis le contexte du dossier d'instruction  ${di_case_1}
    Page Should Contain Element  css=#fieldset-form-dossier_instruction-consultation

    # Fieldset "Consultation" cas 2/
    # Dans tous les autres cas le fieldset ne doit pas être affiché

    # Avec le type d'affichage "CONSULTATION ENTRANTE" + dépôt électronique à "Non"
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=LIBRECOM_WS_AFF_DI
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300AdresseLocalite
    ...  depot_electronique=false
    ...  source_depot=app
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOM04
    ...  particulier_prenom=TEST300TASKPRENOM04
    ...  localite=TEST300Localite
    ...  om_collectivite=LIBRECOM_WS_AFF_DI
    ${di_case_2} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    # Vérification de l'icône du listing : la ligne ne doit pas avoir la classe consult-demat
    Depuis le listing  dossier_instruction
    ${di_case_2_sans_espace} =  Sans espace  ${di_case_2}
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di_case_2_sans_espace}
    Click On Search Button
    Element Should Not Be Visible  css=table.tab-tab tr.consult-demat

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di_case_2}  ${donnees_techniques_values}

    Depuis le contexte du dossier d'instruction  ${di_case_2}
    Page Should Not Contain Element  css=#fieldset-form-dossier_instruction-consultation

    # Change le type affichage du type de DA
    &{args_da_type} =  Create Dictionary
    ...  affichage_form=ADS
    Modifier le type de dossier d'autorisation  Permis de construire  ${args_da_type}

    # Sans le type d'affichage "CONSULTATION ENTRANTE" + dépôt électronique à "Oui"
    Depuis le contexte du dossier d'instruction  ${di_case_1}
    Page Should Not Contain Element  css=#fieldset-form-dossier_instruction-consultation

    # Sans le type d'affichage "CONSULTATION ENTRANTE" + dépôt électronique à "Non"
    Depuis le contexte du dossier d'instruction  ${di_case_2}
    Page Should Not Contain Element  css=#fieldset-form-dossier_instruction-consultation

    # Fieldset "Plat'AU : identifiants techniques" cas 1/
    # Le type du datd est transmis à Plat'AU + l'option option_mode_service_consulte est
    # activée + source dépôt de la demande à 'platau' ou 'portal'.

    # Prépare la payload
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-CCC-00
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  CCC-000-00
    ${json_payload} =  Replace String  ${json_payload}  013055 20  016099 21
    ${json_payload} =  Replace String  ${json_payload}  01305520  01609921
    ${json_payload} =  Replace String  ${json_payload}  2020  2021
    ${json_payload} =  Replace String  ${json_payload}  07777P0  01111P
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_multi_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${librecom_multi_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  "instructeur": "1"  "instructeur": "${librecom_instr_id}"
    ${payload_dict} =  To Json  ${json_payload}
    # définir les paramètres de type de demande
    &{param_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_PCI
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_type_demande_initial}
    # Active option_mode_service_consulte
    &{param_option_sc} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_sc}

    # Les attributs state et stream ne sont pas nécessaires lors de l'ajout de la tache
    # Ici ces attributs sont utilisés lors de la vérification des données de la tâches en consultation
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  [^ ]{7}$  01111P0
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Page Should Contain Element  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques

    # Fieldset "Plat'AU : identifiants techniques" cas 2/
    # Le type du datd est transmis à Plat'AU + l'option option_mode_service_consulte est désactivée
    # Désactive option_mode_service_consulte
    &{param_option_sc} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_sc}
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Page Should Contain Element  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques

    # Fieldset "Plat'AU : identifiants techniques" cas 3/
    # Dans tous les autres cas le fieldset ne doit pas être affiché.

    # Désactive la transmission Plat'AU du datd
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    Depuis le contexte du dossier d'instruction  ${di_case_1}
    Page Should Not Contain Element  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques

    Depuis le contexte du dossier d'instruction  ${di_case_2}
    Page Should Not Contain Element  css=#fieldset-form-dossier_instruction-plat_au---identifiants-techniques

    # Remet les paramètres par défaut
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}


Vérification de la suppression d'un objet lié à une tâche non traitée
    [Documentation]  XXX

    Depuis la page d'accueil  admin  admin

    # Activer l'option de suppression des dossiers
    &{options} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${options}

    # Ajouter un service de type plat'au
    &{service} =  Create Dictionary
    ...  abrege=DC300
    ...  libelle=Direction Circulation TEST300
    ...  edition=Consultation - Pour conformité
    ...  type_consultation=Pour conformité
    ...  om_collectivite=MARSEILLE
    ...  service_type=Plat'AU
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}

    # Ajouter un dossier : Création DA + Création demande + Dépôt DI
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300AdresseLocalite
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOM05
    ...  particulier_prenom=TEST300TASKPRENOM05
    ...  localite=TEST300Localite
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}
    ${di_se} =  Sans espace  ${di}
    ${da} =  Replace String Using Regexp  ${di_se}  [A-Z][0-9]+$  ${EMPTY}

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di}  ${donnees_techniques_values}

    # Ajouter une pièce numérisée : Ajout pièce
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=Test type document numerise de catégorie PLATAU
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    ${dn} =  Get Value  css=input#document_numerise

    # Ajouter une consultation : Création consultation
    Ajouter une consultation depuis un dossier  ${di}  ${service.abrege} - ${service.libelle}
    Depuis le contexte de la consultation  ${di}  ${service.abrege} - ${service.libelle}
    ${consultation} =  Get Value  css=#sousform-consultation #consultation

    # Ajouter une instruction de décision : Décision DI
    ${instr_dec} =  Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve

    # Vérification status des tâches
    &{task_values} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${da}
    ...  state=new
    ...  object_id=${da}
    ...  link_dossier=${da}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=ajout_piece
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${dn}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=creation_consultation
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${consultation}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_qualification_DI} =  Get Text  css=#task
    &{task_values} =  Create Dictionary
    ...  type=decision_DI
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${instr_dec}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    # Suppression de tous les objets
    Supprimer la consultation depuis le contexte du dossier d'instruction  ${di}  ${service.abrege} - ${service.libelle}
    Supprimer l'instruction  ${di}  accepter un dossier sans réserve
    Supprimer le dossier d'instruction  ${di}

    # Vérification status des tâches
    &{task_values} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${da}
    ...  state=canceled
    ...  object_id=${da}
    ...  link_dossier=${da}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_se}
    ...  state=canceled
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${di_se}
    ...  state=canceled
    ...  object_id=${di_se}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=ajout_piece
    ...  dossier=${di_se}
    ...  state=canceled
    ...  object_id=${dn}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=creation_consultation
    ...  dossier=${di_se}
    ...  state=canceled
    ...  object_id=${consultation}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    &{task_values} =  Create Dictionary
    ...  type=decision_DI
    ...  dossier=${di_se}
    ...  state=canceled
    ...  object_id=${instr_dec}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    # Désactiver l'option de suppression des dossiers
    &{options} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${options}

    # Création d'un nouveau dossier dont le numéro va reprendre celui du dossier
    # supprimer. Nécessaire pour éviter que dans les tests suivants des tâches existent
    # sur un dossier alors qu'il viens juste d'être ajouté
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=TEST300TASKNOM05
    ...  particulier_prenom=TEST300TASKPRENOM05
    ...  om_collectivite=MARSEILLE
    Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

Vérification du traitement de la tâche création DI
    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # Active le mode service consulté
    &{param_division} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_multi_1_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_CREATE_DI_MULTI_1
    ...  departement=017
    ...  commune=100
    ...  insee=17100
    ...  direction_code=WE
    ...  direction_libelle=Direction de LIBRECOM_WS_CREATE_DI_MULTI_1
    ...  direction_chef=Chef
    ...  division_code=WE
    ...  division_libelle=Division WE
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Derien Bollin
    ...  guichet_om_utilisateur_email=dbollin@openads-test.fr
    ...  guichet_om_utilisateur_login=dbollin
    ...  guichet_om_utilisateur_pwd=dbollin
    ...  instr_om_utilisateur_nom=Marolos Heauchemin
    ...  instr_om_utilisateur_email=mheauchemin@openads-test.fr
    ...  instr_om_utilisateur_login=mheauchemin
    ...  instr_om_utilisateur_pwd=mheauchemin
    ...  code_entite=LBCOM_21
    ...  acteur=LIBRECOM-ACT-021
    Isolation d'un contexte  ${librecom_multi_1_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_instructeur
    ...  ${librecom_multi_1_values["acteur"]}  ${librecom_multi_1_values["om_collectivite_libelle"]}

    # Récupère le payload de création DI
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  KWE-Z9G-OYW  000-DDD-00
    ${json_payload} =  Replace String  ${json_payload}  515-Q0L-KMX  DDD-000-00
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_multi_1_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  71Z-Y9O-KWQ  ${librecom_multi_1_values["acteur"]}
    ${payload_dict} =  To Json  ${json_payload}
    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    # Active option_dossier_commune
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    # Ajoute une commune
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=17100
    ...  reg=17
    ...  dep=17
    ...  arr=100
    ...  tncc=0
    ...  ncc=LIBRECOM_WS_CREATE_DI_MULTI_1
    ...  nccenr=LIBRECOM_WS_CREATE_DI_MULTI_1
    ...  libelle=LIBRECOM_WS_CREATE_DI_MULTI_1
    ...  can=17
    ...  comparent=
    ...  om_validite_debut=01/11/2020
    Ajouter commune avec dates validité  ${com_values}
    # Les attributs state et stream ne sont pas nécessaires lors de l'ajout de la tache
    # Ici ces attributs sont utilisés lors de la vérification des données de la tâches en consultation
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # Ajouter le type de document avec le code '90' tel qu'il est dans la payload
    ${dnt_code} =  Set Variable  96
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Document numérisé Plat'AU create DI
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Ajout d'une pièce
    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_multi_1_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-DDD-00
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-11
    ${json_payload} =  Replace String  ${json_payload}  "dossier_consultation": "FE4-JR5-8W",  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  "document_numerise_type_code": "90"  "document_numerise_type_code": "96"
    ${json_payload} =  Replace String  ${json_payload}
    ...  "nom_fichier": "2020112790.pdf"  "nom_fichier": "20210824.pdf"
    ${piece_payload_dict} =  To Json  ${json_payload}
    ${external_uid_piece_1} =  Set Variable  ${piece_payload_dict["external_uids"]["piece"]}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    # Ajout d'une deuxième pièce
    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_multi_1_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-DDD-00
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-12
    ${json_payload} =  Replace String  ${json_payload}  "dossier_consultation": "FE4-JR5-8W",  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  "document_numerise_type_code": "90"  "document_numerise_type_code": "96"
    ${piece_payload_dict} =  To Json  ${json_payload}
    ${json_payload} =  Replace String  ${json_payload}
    ...  "nom_fichier": "2020112790.pdf"  "nom_fichier": "20210824-1.pdf"
    ${external_uid_piece_1} =  Set Variable  ${piece_payload_dict["external_uids"]["piece"]}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    ${msg} =  Déclencher le traitement des tâches par WS

    Depuis la page d'accueil  mheauchemin  mheauchemin

    Depuis le listing  dossier_instruction

    Click Link  ${librecom_multi_1_values["om_collectivite_libelle"]}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#dossier_libelle
    ${dossier_libelle} =  Get Text  css=#dossier_libelle
    ${dossier_libelle} =  Sans espace  ${dossier_libelle}

    Depuis la page d'accueil  admin  admin
    Depuis le menu Moniteur Plat'AU

    # On vérifie qu'il n'y ait pas de tâche Création demande

    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Création demande
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Création demande
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.        

    # On vérifie qu'il n'y ait pas de tâche Création DA
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Création DA
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Création DA
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.        

    # On vérifie qu'il n'y ait pas de tâche Ajout pièce
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Ajout pièce (sortant)
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Ajout pièce (sortant)
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.        


    # On vérifie que la tâche Modification DI est bien ajoutée
    Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Modification DI

    Click On Search Button
    Element Should Not Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie que la tâche Dépôt DI est bien ajoutée
    Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Dépôt DI
    Select From List By Label  css=div#adv-search-adv-fields select#state  à traiter

    Click On Search Button
    Element Should Not Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie que la tâche Qualification DI est bien ajoutée
    Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Qualification DI
    Select From List By Label  css=div#adv-search-adv-fields select#state  à traiter

    Click On Search Button
    Element Should Not Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie que la tâche création DI a bien été mis à jour avec l'identifiant du dossier
    Input Text  css=div#adv-search-adv-fields input#object_id  ${dossier_libelle}
    Input Text  css=div#adv-search-adv-fields input#dossier  ${EMPTY}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Création demande
    Select From List By Label  css=div#adv-search-adv-fields select#state  terminé

    Click On Search Button
    Element Should Not Contain  css=.tab-data  Aucun enregistrement.

    &{librecom_multi_2_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_CREATE_DI_MULTI_2
    ...  departement=018
    ...  commune=101
    ...  insee=18101
    ...  direction_code=X
    ...  direction_libelle=Direction de LIBRECOM_WS_CREATE_DI_MULTI_2
    ...  direction_chef=Chef
    ...  division_code=X
    ...  division_libelle=Division XX
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Latienne Bollon
    ...  guichet_om_utilisateur_email=lbollon@openads-test.fr
    ...  guichet_om_utilisateur_login=lbollon
    ...  guichet_om_utilisateur_pwd=lbollon
    ...  instr_om_utilisateur_nom=Marvolos Treauchemin
    ...  instr_om_utilisateur_email=mtreauchemin@openads-test.fr
    ...  instr_om_utilisateur_login=mtreauchemin
    ...  instr_om_utilisateur_pwd=mtreauchemin
    ...  code_entite=LBCOM_22
    ...  acteur=LIBRECOM-ACT-022
    Isolation d'un contexte  ${librecom_multi_2_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_instructeur
    ...  ${librecom_multi_2_values["acteur"]}  ${librecom_multi_2_values["om_collectivite_libelle"]}

    # Récupère le payload de création DI
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  KWE-Z9G-OYW  000-EEE-00
    ${json_payload} =  Replace String  ${json_payload}  515-Q0L-KMX  EEE-000-00
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_multi_2_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  71Z-Y9O-KWQ  ${librecom_multi_2_values["acteur"]}
    ${payload_dict} =  To Json  ${json_payload}

    # Ajoute une commune
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=18101
    ...  reg=18
    ...  dep=18
    ...  arr=101
    ...  tncc=0
    ...  ncc=LIBRECOM_WS_CREATE_DI_MULTI_2
    ...  nccenr=LIBRECOM_WS_CREATE_DI_MULTI_2
    ...  libelle=LIBRECOM_WS_CREATE_DI_MULTI_2
    ...  can=18
    ...  comparent=
    ...  om_validite_debut=01/11/2020
    Ajouter commune avec dates validité  ${com_values}
    # Les attributs state et stream ne sont pas nécessaires lors de l'ajout de la tache
    # Ici ces attributs sont utilisés lors de la vérification des données de la tâches en consultation
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # Ajout d'une pièce
    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_multi_2_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-EEE-00
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-13
    ${json_payload} =  Replace String  ${json_payload}  "dossier_consultation": "FE4-JR5-8W",  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  "document_numerise_type_code": "90"  "document_numerise_type_code": "96"
    ${json_payload} =  Replace String  ${json_payload}
    ...  "nom_fichier": "2020112790.pdf"  "nom_fichier": "20210824.pdf"
    ${piece_payload_dict} =  To Json  ${json_payload}
    ${external_uid_piece_1} =  Set Variable  ${piece_payload_dict["external_uids"]["piece"]}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    # Ajout d'une deuxième pièce
    # On récupère le contenu du fichier json_ajout_piece_with_b64.json qui sera notre
    # json_payload correspondant à la tâche Ajout pièce
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json

    # Remplace certaines valeurs
    ${json_payload} =  Replace String  ${json_payload}  GH-EQ6-5432  ${librecom_multi_2_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-EEE-00
    ${json_payload} =  Replace String  ${json_payload}  1EY-RT8-5X  PPP-000-14
    ${json_payload} =  Replace String  ${json_payload}  "dossier_consultation": "FE4-JR5-8W",  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  "document_numerise_type_code": "90"  "document_numerise_type_code": "96"
    ${piece_payload_dict} =  To Json  ${json_payload}
    ${json_payload} =  Replace String  ${json_payload}
    ...  "nom_fichier": "2020112790.pdf"  "nom_fichier": "20210824-1.pdf"
    ${external_uid_piece_1} =  Set Variable  ${piece_payload_dict["external_uids"]["piece"]}

    # Ajoute la tâche d'ajout de pièce
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    ${msg} =  Déclencher le traitement des tâches par WS

    Depuis la page d'accueil  mtreauchemin  mtreauchemin

    Depuis le listing  dossier_instruction

    Click Link  ${librecom_multi_2_values["om_collectivite_libelle"]}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#dossier_libelle
    ${dossier_libelle} =  Get Text  css=#dossier_libelle
    ${dossier_libelle} =  Sans espace  ${dossier_libelle}

    Depuis la page d'accueil  admin  admin

    Depuis le menu Moniteur Plat'AU

    # On vérifie qu'il n'y ait pas de tâche Création demande

    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Création DI (sortant)
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Création DI
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie qu'il n'y ait pas de tâche Création DA
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Création DA (sortant)
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Création DA
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie qu'il n'y ait pas de tâche Ajout pièce
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Ajout pièce (sortant) (sortant)
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Ajout pièce (sortant)
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie que la tâche Modification DI est bien ajoutée
    Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Modification DI

    Click On Search Button
    Element Should Not Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie que la tâche Dépôt DI est bien ajoutée
    Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Dépôt DI
    Select From List By Label  css=div#adv-search-adv-fields select#state  à traiter

    Click On Search Button
    Element Should Not Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie que la tâche Qualification DI est bien ajoutée
    Input Text  css=div#adv-search-adv-fields input#dossier  ${dossier_libelle}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Qualification DI
    Select From List By Label  css=div#adv-search-adv-fields select#state  à traiter

    Click On Search Button
    Element Should Not Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie que la tâche création DI a bien été mis à jour avec l'identifiant du dossier
    Input Text  css=div#adv-search-adv-fields input#object_id  ${dossier_libelle}
    Input Text  css=div#adv-search-adv-fields input#dossier  ${EMPTY}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Création demande
    Select From List By Label  css=div#adv-search-adv-fields select#state  terminé

    Click On Search Button
    Element Should Not Contain  css=.tab-data  Aucun enregistrement.

    Depuis la page d'accueil  admin  admin

    ${task_values} =  Create Dictionary
    ...  type=modification_DI
    ...  dossier=${dossier_libelle}
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}

    ${task_values} =  Create Dictionary
    ...  type=depot_DI
    ...  dossier=${dossier_libelle}
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}

    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # Désactive option_dossier_commune
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}


Vérification du traitement de la tâche message
    [Documentation]  Vérifie que le traitement de la tâche message entraine bien
    ...  la création d'un message avec toutes les informations nécessaires issues du json
    ...  payload

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # Active le mode service consulté
    &{param_division} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_multi_1_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_CREATE_MESSAGE_MULTI_1
    ...  departement=018
    ...  commune=100
    ...  insee=18100
    ...  direction_code=ABC
    ...  direction_libelle=Direction de LIBRECOM_WS_CREATE_MESSAGE_MULTI_1
    ...  direction_chef=Chef
    ...  division_code=ABC
    ...  division_libelle=Division ABC
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Jacquenett Perrault
    ...  guichet_om_utilisateur_email=jperrault@openads-test.fr
    ...  guichet_om_utilisateur_login=jperrault
    ...  guichet_om_utilisateur_pwd=jperrault
    ...  instr_om_utilisateur_nom=Solaine Grimard
    ...  instr_om_utilisateur_email=sgrimard@openads-test.fr
    ...  instr_om_utilisateur_login=sgrimard
    ...  instr_om_utilisateur_pwd=sgrimard
    ...  code_entite=LBCOM_23
    ...  acteur=LIBRECOM-ACT-023
    Isolation d'un contexte  ${librecom_multi_1_values}


    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_instructeur
    ...  ${librecom_multi_1_values["acteur"]}  ${librecom_multi_1_values["om_collectivite_libelle"]}

    # Ajoute d'une tâche de création de DI
    # Récupère l'identifiant de la collectivité LIBRECOM_WS
    Depuis le contexte de la collectivité  ${librecom_multi_1_values["om_collectivite_libelle"]}
    ${librecom_ws_id} =  Get Text  css=#om_collectivite

    # Récupère le template de payload JSON et le transforme en dictionnaire
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  KWE-Z9G-OYW  000-FFF-00
    ${json_payload} =  Replace String  ${json_payload}  515-Q0L-KMX  FFF-000-00
    ${json_payload} =  Replace String  ${json_payload}  71Z-Y9O-KWQ  ${librecom_multi_1_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  00009       00030P0
    ${json_payload} =  Replace String  ${json_payload}  "om_collectivite": "3"  "om_collectivite": "${librecom_ws_id}"
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_multi_1_values["insee"]}
    ${payload_dict} =  To Json  ${json_payload}
    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # Active option_dossier_commune
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    
    # Ajoute des commune
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=18100
    ...  reg=18
    ...  dep=18
    ...  arr=100
    ...  tncc=0
    ...  ncc=LIBRECOM_WS_CREATE_MESSAGE_MULTI_1
    ...  nccenr=LIBRECOM_WS_CREATE_MESSAGE_MULTI_1
    ...  libelle=LIBRECOM_WS_CREATE_MESSAGE_MULTI_1
    ...  can=18
    ...  comparent=
    ...  om_validite_debut=${DATE_FORMAT_DD/MM/YYYY}
    Ajouter commune avec dates validité  ${com_values}
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=18100
    ...  reg=18
    ...  dep=18
    ...  arr=100
    ...  tncc=0
    ...  ncc=TESTCOM
    ...  nccenr=TESTCOM
    ...  libelle=TESTCOM
    ...  can=18
    ...  comparent=
    ...  om_validite_debut=${DATE_FORMAT_DD/MM/YYYY}
    Ajouter commune avec dates validité  ${com_values}
    # Ajoute d'une tâche de création de DI (devant aussi créer le DA associé si inexistant)
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}

    # Lancer le traitement des tâches (entrantes avec statut 'à traiter', par défaut)
    ${msg} =  Déclencher le traitement des tâches par WS

    # Récupère le payload de message
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_message_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  7SZ-SX8-TR4  000-FFF-00
    ${payload_dict} =  To Json  ${json_payload}
    # Les attributs state et stream ne sont pas nécessaires lors de l'ajout de la tache
    # Ici ces attributs sont utilisés lors de la vérification des données de la tâches en consultation
    ${task_values} =  Create Dictionary
    ...  type=create_message
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}

    # ajout manuellement les éléments qui ont du être défini par défaut
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input

    ${msg} =  Déclencher le traitement des tâches par WS

    Depuis la page d'accueil  sgrimard  sgrimard
    # Récupération du libellé du dossier
    Depuis le listing  dossier_instruction
    Click Link  ${librecom_multi_1_values["om_collectivite_libelle"]}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#dossier_libelle
    ${dossier_libelle} =  Get Text  css=#dossier_libelle

    # Vérifie que le message a bien été créé
    Depuis l'onglet des messages du dossier d'instruction  ${dossier_libelle}
    Click Link  Incomplétude|complétude
    Wait Until Element Is Visible  css=div#sousform-dossier_message span#contenu

    Element Should Contain  css=div#sousform-dossier_message span#contenu    Le dossier a été déclaré complet|incomplet par la collectivité
    Element Should Contain  css=div#sousform-dossier_message span#categorie    platau

    # On ajoute un second message totalement identique pour vérifier que la gestion des doublons ne
    # s'applique pas au message créée par tâche
    ${task_values} =  Create Dictionary
    ...  type=create_message
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_values}
    Set To Dictionary  ${task_values}  task=${task_id}
    Set To Dictionary  ${task_values}  state=new
    Set To Dictionary  ${task_values}  stream=input
    ${msg} =  Déclencher le traitement des tâches par WS
    Depuis la page d'accueil  sgrimard  sgrimard
    Depuis l'onglet des messages du dossier d'instruction  ${dossier_libelle}
    Page Should Contain Element   //*[contains(text(), "Incomplétude|complétude")]  limit=2

    # Réinitialisation des paramètres
    Depuis la page d'accueil  admin  admin
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # Désactive option_dossier_commune
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}


Vérification du flux contrôle de légalité
    [Documentation]  Permet de vérifier le bon fonctionnement de l'action envoyer
    ...  au contrôle de légalité qui crée une nouvelle tâche Envoi contrôle de légalité

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # desactiver l'option dossier_commune et la saisie complète des numéros
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # Modification de l'événement pour transmission au CL par Plat'AU
    &{args_evenement} =  Create Dictionary
    ...  libelle=accepter un dossier sans réserve
    ...  envoi_cl_platau=true
    Modifier l'événement  ${args_evenement}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_CONTROLE_LEGALITE
    ...  departement=025
    ...  commune=160
    ...  insee=25160
    ...  direction_code=GM
    ...  direction_libelle=Direction de LIBRECOM_CONTROLE_LEGALITE
    ...  direction_chef=Chef
    ...  division_code=GM
    ...  division_libelle=Division GM
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Shalil Dibran
    ...  guichet_om_utilisateur_email=sdibran@openads-test.fr
    ...  guichet_om_utilisateur_login=sdibran
    ...  guichet_om_utilisateur_pwd=sdibran
    ...  instr_om_utilisateur_nom=Uomir Sambu
    ...  instr_om_utilisateur_email=usambu@openads-test.fr
    ...  instr_om_utilisateur_login=usambu
    ...  instr_om_utilisateur_pwd=usambu
    ...  code_entite=LBCOM_25
    ...  acteur=LIBRECOM-ACT-025
    Isolation d'un contexte  ${librecom_values}

    # Prépare le dossiers d'instruction
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=LIBRECOM_CONTROLE_LEGALITE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300controlelegalite
    ...  depot_electronique=true
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOMCONTROLELEGALITE
    ...  particulier_prenom=TEST300TASKPRENOMCONTROLELEGALITE
    ...  localite=TEST300Localite
    ...  om_collectivite=LIBRECOM_CONTROLE_LEGALITE
    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}
    ${di_se} =  Sans espace  ${di}
    ${da} =  Replace String Using Regexp  ${di_se}  [A-Z][0-9]+$  ${EMPTY}
    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di}  ${donnees_techniques_values}

    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve

    Element Should Not Be Visible  css=#action-sousform-instruction-envoyer_au_controle_de_legalite

    &{args_date} =  Create Dictionary
    ...  date_retour_signature=${date_ddmmyyyy}
    Modifier le suivi des dates  ${di}  accepter un dossier sans réserve  ${args_date}

    # Tant qu'on n'a pas envoyé au cl, le champ envoi au controle de légalité est modifiable
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Element Should Not Be Visible  css=#date_envoi_controle_legalite[disabled="disabled"]
    Element Should Be Visible  css=#date_envoi_controle_legalite
    Click On Back Button In Subform

    Element Should Be Visible  css=#action-sousform-instruction-envoyer_au_controle_de_legalite

    Click On SubForm Portlet Action  instruction  envoyer_au_controle_de_legalite  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Valid Message Should Contain In Subform  Votre demande de transfert au contrôle de légalité à bien été prise en compte.
    Form Static Value Should Be  css=#date_envoi_controle_legalite  ${EMPTY}
    Portlet Action Should Not Be In SubForm  instruction  envoyer_au_controle_de_legalite
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Element Should Be Visible  css=#date_envoi_controle_legalite[disabled="disabled"]

    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    Form Value Should Contain  css=#date_envoi_controle_legalite  En cours de traitement.

    # Vérification status des tâches, il faut qu'elles soient en brouillon
    &{task_values} =  Create Dictionary
    ...  type=envoi_CL
    ...  dossier=${di_se}
    ...  state=new
    ...  object_id=${id_instruction}
    ...  link_dossier=${di_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    Vérifier que la tâche à une payload fonctionnelle  ${task_values}
    ${task_id} =  Get Text  css=#task
    &{task_values_modif} =  Create Dictionary
    ...  state=terminé
    Modifier la task  ${task_id}  ${task_values_modif}
    La page ne doit pas contenir d'erreur

    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    Form Static Value Should Be  css=#date_envoi_controle_legalite  ${date_ddmmyyyy}

    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    Element Should Not Be Visible  css=#action-sousform-instruction-envoyer_au_controle_de_legalite

    # Réinitialisation des paramètres
    Depuis la page d'accueil  admin  admin
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    &{args_evenement} =  Create Dictionary
    ...  libelle=accepter un dossier sans réserve
    ...  envoi_cl_platau=false
    Modifier l'événement  ${args_evenement}

Vérification du state de Création DA lors de l'ajout d'un dossier Publik
    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # Active le mode service consulté
    &{param_division} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_multi_1_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_CREATE_DI_MULTI_20
    ...  departement=020
    ...  commune=900
    ...  insee=20900
    ...  direction_code=WG
    ...  direction_libelle=Direction de LIBRECOM_WS_CREATE_DI_MULTI_20
    ...  direction_chef=Chef
    ...  division_code=WG
    ...  division_libelle=Division WG
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Herien Kollin
    ...  guichet_om_utilisateur_email=hkollin@openads-test.fr
    ...  guichet_om_utilisateur_login=hkollin
    ...  guichet_om_utilisateur_pwd=hkollin
    ...  instr_om_utilisateur_nom=Larolos Feauchemin
    ...  instr_om_utilisateur_email=lfeauchemin@openads-test.fr
    ...  instr_om_utilisateur_login=lfeauchemin
    ...  instr_om_utilisateur_pwd=lfeauchemin
    ...  code_entite=LBCOM_56
    ...  acteur=LIBRECOM-ACT-056
    Isolation d'un contexte  ${librecom_multi_1_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_instructeur
    ...  ${librecom_multi_1_values["acteur"]}  ${librecom_multi_1_values["om_collectivite_libelle"]}

    # Récupère le payload de création DI
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  KWE-Z9G-OYW  000-MMM-00
    ${json_payload} =  Replace String  ${json_payload}  515-Q0L-KMX  MMM-000-00
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_multi_1_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  71Z-Y9O-KWQ  ${librecom_multi_1_values["acteur"]}
    ${json_payload} =  Replace String  ${json_payload}  71Z-Y9O-KWQ  ${librecom_multi_1_values["acteur"]}
    ${payload_dict} =  To Json  ${json_payload}
    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    # Active option_dossier_commune
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    # Ajoute une commune
    &{com_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=20900
    ...  reg=20
    ...  dep=20
    ...  arr=900
    ...  tncc=0
    ...  ncc=LIBRECOM_WS_CREATE_DI_MULTI_20
    ...  nccenr=LIBRECOM_WS_CREATE_DI_MULTI_20
    ...  libelle=LIBRECOM_WS_CREATE_DI_MULTI_20
    ...  can=17
    ...  comparent=
    ...  om_validite_debut=01/11/2020
    Ajouter commune avec dates validité  ${com_values}
    # Les attributs state et stream ne sont pas nécessaires lors de l'ajout de la tache
    # Ici ces attributs sont utilisés lors de la vérification des données de la tâches en consultation
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    ...  category=portal
    Ajouter la tâche par WS  ${task_values}

    ${msg} =  Déclencher le traitement des tâches par WS

    ${di_regex} =  Catenate  ^.*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '([^']+)'  .*$
    ${di_lib} =  Replace String Using Regexp  ${msg}  ${di_regex}  \\1

    ${dossier_autorisation} =  Get Substring  ${di_lib}  0  -2

    ${dossier_autorisation} =  Sans espace  ${dossier_autorisation}

    &{task_values} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${dossier_autorisation}
    ...  state=new
    ...  object_id=${dossier_autorisation}
    ...  link_dossier=${dossier_autorisation}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # Désactive option_dossier_commune
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}


TNR Non création de tache Ajout pièce pour les pièces de catégorie différentes de Plat'AU
    [Documentation]  Vérifie que lors de l'ajout d'une pièce de catégorie différente de
    ...  Plat'AU, aucune tâche Ajout pièce n'est crée.

    # On crée une nouvelle demande pour le TNR
        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Riel
    ...  particulier_prenom=Sébastien
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On ajoute une pièce et on vérifie qu'aucune tâche n'a été créée
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=vues et coupes du projet dans le profil du terrain naturel
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    ${di_sans_espace} =  Sans espace  ${di}
    ${di_da} =  Replace String Using Regexp  ${di_sans_espace}  [A-Z][0-9]+$  ${EMPTY}
    Depuis le menu Moniteur Plat'AU
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#dossier
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#type
    Input Text  css=#dossier  ${di_da}
    Select From List By Label  css=#type  Ajout pièce (sortant)
    # Select From List By Label  css=#state  à traiter
    Click On Search Button
    Element Should Contain  css=table.tab-tab  Aucun enregistrement.

TNR vérification que le lien du dossier fonctionne correctement
    [Documentation]  Test les différents cas pour lequel on a un lien vers le dossier
    ...  qui s'affiche en consultation d'une tâche. Les cas sont les suivants :
    ...  Cas 1 : tâche Sortante avec un numéro de dossier d'autorisation (DA) -> le numéro
    ...          est cliquable et redirige l'utilisateur vers le dossier d'autorisation
    ...  Cas 2 : tâche Sortante avec un numéro de dossier d'instruction (DI) -> le numéro
    ...          est cliquable et renvoie l'utilisateur vers le dossier d'instruction
    ...  Cas 3 : tâche Sortante avec un numéro de DA et le DA n'existe plus -> le numéro est
    ...          affiché mais ce n'est pas un lien
    ...  Cas 4 : tâche Sortante avec un numéro de DI et le DI n'existe plus -> le numéro est
    ...          affiché mais ce n'est pas un lien
    ...  Cas 5 : tâche entrante avec un numéro de DI existant dans l'application -> le numéro
    ...          est cliquable et renvoie l'utilisateur vers le DI
    ...  Cas 6 : tâche entrante avec un numéro de DI non existant dans l'application -> le numéro est
    ...          affiché mais ce n'est pas un lien
    ...  Cas 7 : tâche entrante sans numéro de dossier et sans external UID permettant de le récupérer
    ...          -> pas de numéro et pas de lien affiché dans la synthèse de la tâche
    ...  Cas 8 : tâche entrante pour laquelle un numéro de dossier a été récupéré à l'aide des
    ...          external UID de la tâche et où le DI existe -> le numéro est cliquable et
    ...          renvoie l'utilisateur vers le DI
    ...  Cas 9 : tâche entrante pour laquelle un numéro de dossier a été récupéré à l'aide des
    ...          external UID de la tâche et où le DI n'existe pas -> le numéro n'est pas cliquable
    ...  Cas 10 : tâche entrante de type portal pour laquelle un numéro de dossier a été récupéré
    ...           à l'aide des external UID de la tâche et où le DI existe -> le numéro est pas cliquable

    # Création d'un dossier transmissible à plat'AU. La création de ce dossier entraine
    # l'ajout de nouvelles tâches.
    # La tâche creation_DA sert à tester les cas 1 et 3
    # La tâche creation_DI sert à tester les cas 2 et 4
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300AdresseLocalite
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOM05
    ...  particulier_prenom=TEST300TASKPRENOM05
    ...  localite=TEST300Localite
    ...  om_collectivite=MARSEILLE
    ${di_lie_taches} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire}
    # Récupération du numéro de dossier sans espace et du numéro de dossier d'autorisation
    # à partir du numéro de dossier fourni à la création du dossier
    ${di_se} =  Sans espace  ${di_lie_taches}
    ${da_lie_taches} =  Replace String Using Regexp  ${di_lie_taches}  [A-Z][0-9]+$  ${EMPTY}
    ${da_se} =  Sans espace  ${da_lie_taches}


    # Ajout d'un élément dans la table lien_id_interne_uid_externe faisant référence
    # à ce dossier.
    # Cette référence permettra de tester les tâches en input (cas 5 à 9)
    ${lien_dossier_payload} =  Create Dictionary
    ...  object=dossier
    ...  object_id=${di_se}
    ...  external_uid=000-MMM-10
    ...  dossier=${di_se}
    ...  category=platau
    Ajouter un external UID  ${lien_dossier_payload}

    # Cas 1 : tâches entrante avec un numéro de DA existant
    # On accède à cette tâche et on vérifie que le lien vers le dossier est présent
    # sur le formulaire de consultation de la tâche. Vérifie également que cliquer
    # sur ce lien redirige bien vers le formulaire de consultation du dossier
    # d'autorisation
    &{task_values_cas1} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${da_se}
    ...  stream=output
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values_cas1}
    # Vérifie l'existance du lien
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=#dossier + a  ${da_se}
    ${id_creation_DA} =  Get Text  css=#task
    # Test la redirection
    Click Link  ${da_se}
    # Temporisation pour s'assurer que la page a bien le temps de se charger
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}    Element Should Contain  css=form#dossier_autorisation #dossier_autorisation_libelle  ${da_lie_taches}
    # Cas 2 : tâches entrante avec un numéro de DI existant
    # On accède à cette tâche et on vérifie que le lien vers le dossier est présent
    # sur le formulaire de consultation de la tâche. Vérifie également que cliquer
    # sur ce lien redirige bien vers le formulaire de consultation du dossier
    &{task_values_cas2} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_se}
    ...  stream=output
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values_cas2}
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=#dossier + a  ${di_se}
    Click Link  ${di_se}
    # Temporisation pour s'assurer que la page a bien le temps de se charger
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}    Element Should Contain  css=#fieldset-form-dossier_instruction-dossier-d_instruction #dossier_libelle  ${di_lie_taches}

    # Cas 5 : Tâche entrante avec un numéro de dossier existant dans l'application
    # Création d'une tâche faisant référence au dossier créé précedemment
    # Récupération de la payload d'une tâche create_DI_for_consultation et modification
    # du numéro et de l'external uid du dossier pour qu'ils correspondent à ceux ajouté
    # en début de test
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-MMM-10
    ${json_payload} =  Replace String  ${json_payload}  PC0130552007777P0  ${di_se}
    ${payload_dict} =  To Json  ${json_payload}

    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    ...  dossier=${di_se}
    ${task_id_cas5} =  Ajouter la tâche par WS  ${task_values}

    # Accède à la tâche, vérifie qu'il existe bien un lien vers le dossier
    # Vérifie également que cliquer sur ce lien renvoie vers le formulaire
    # consultation du DI
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  state=new
    ...  dossier=${di_se}
    ...  stream=input
    ...  task=${task_id_cas5}
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=#dossier + a  ${di_se}
    Click Link  ${di_se}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}    Element Should Contain  css=#fieldset-form-dossier_instruction-dossier-d_instruction #dossier_libelle  ${di_lie_taches}

    # Cas 7 : tâche entrante pour laquelle le numéro de dossier n'a pas été récupéré
    #  via l'external uid de sa payload
    # En consultation de la tâche il ne doit pas y avoir de numéro de dossier visible
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_ajout_piece_with_b64.json
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-000-00
    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id_cas7} =  Ajouter la tâche par WS  ${task_values}

    # Accéde à la tâche et vérifie que le numéro de dossier n'est pas rempli
    Depuis le contexte de la task  ${task_id_cas7}
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=#dossier  ${EMPTY}


    # Cas 8 : tâche entrante pour laquelle le numéro de dossier a été récupéré via l'external uid
    # dossier renseignée dans sa payload
    # Le numéro de dossier doit être visible et cliquable en consultation de la tâche
    # Récupère le template de payload JSON et le transforme en dictionnaire
    # Modifie la payload du json pour y ajouter l'external UID faisant référence au dossier
    # créé pour ce test
    ${json_payload} =  Replace String  ${json_payload}  000-000-00  000-MMM-10

    ${task_values} =  Create Dictionary
    ...  type=add_piece
    ...  json_payload=${json_payload}
    ${task_id_cas8} =  Ajouter la tâche par WS  ${task_values}
    # Accéde à la tâche et vérifie la présence du numéro de dossier et le fonctionnement du lien
    Depuis le contexte de la task  ${task_id_cas8}
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=#dossier + a  ${di_se}
    Click Link  ${di_se}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}    Element Should Contain  css=#fieldset-form-dossier_instruction-dossier-d_instruction #dossier_libelle  ${di_lie_taches}
    # Fait en sorte que les taches ne soit pas traité pour ne pas provoquer
    # des erreurs lors de futur déclenchement des tâches
    &{task_values_modif} =  Create Dictionary
    ...  state=brouillon
    Modifier la task  ${task_id_cas8}  ${task_values_modif}
    Modifier la task  ${task_id_cas7}  ${task_values_modif}
    # Activation de l'option de suppression des dossiers
    &{options} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${options}

    # Suppression du dossier. Les tâches liées a ce dossier ne le seront plus.
    Supprimer le dossier d'instruction  ${di_lie_taches}
    Le dossier d'instruction ne doit pas exister  ${di_lie_taches}   

    # Cas 3 : tâche Sortante avec un numéro de DA non existant dans l'application.
    # Réutilise la tâche créée pour le cas 1. Cette tâche n'est plus liée au
    # dossier car il a été supprimé.
    # Vérifie que le numéro de dossier est visible mais que ce n'est pas un lien
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values_cas1}
    La page ne doit pas contenir d'erreur
    Page Should Not Contain Element  css=#dossier + a
    Element Should Contain  css=#dossier + span  ${da_se}

    # Cas 4 : tâche Sortante avec un numéro de DI non existant dans l'application.
    # Réutilise la tâche créée pour le cas 2. Cette tâche n'est plus liée au
    # dossier car il a été supprimé.
    # Vérifie que le numéro de dossier est visible mais que ce n'est pas un lien
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values_cas2}
    La page ne doit pas contenir d'erreur
    Page Should Not Contain Element  css=#dossier + a
    Element Should Contain  css=#dossier + span  ${di_se}

    # Cas 6 : tâche entrante avec un numéro de DI non existant dans l'application.
    # Réutilise la tâche créée pour le cas 5. Cette tâche n'est plus liée au
    # dossier car il a été supprimé.
    # Vérifie que le numéro de dossier est visible mais que ce n'est pas un lien
    Depuis le contexte de la task  ${task_id_cas5}
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=#dossier + span  ${di_se}

    # Cas 9 : tâche entrante pour laquelle un numéro de dossier a été récupéré
    # à l'aide des external UID
    # Réutilise la tâche créée pour le cas 7. Cette tâche n'est plus liée au
    # dossier car il a été supprimé.
    # Vérifie que le numéro de dossier est visible mais que ce n'est pas un lien
    Depuis le contexte de la task  ${task_id_cas8}
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=#dossier + span  ${di_se}

    # Cas 10 : tache entrante de type portal pour laquelle un numero de dossier a été récuperé
    # Le numéro de dossier doit être visible et cliquable en consultation de la tâche
    # Récupère le template de payload JSON et le transforme en dictionnaire. Créé
    # la tâche avec cette payload et déclenche le traitement pour créer le dossier.
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}portal_task_create_di.json

    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_PCI
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    ...  category=portal
    ${task_id_cas10} =  Ajouter la tâche par WS  ${task_values}
    # Avant traitement le numéro de dossier ne dois pas être rempli ni cliquable
    Depuis le contexte de la task  ${task_id_cas10}  IDE'AU
    Page Should Not Contain Element  css=#dossier + a
    Element Should Contain  css=#dossier  ${EMPTY}

    # Déclenchement de la tâche et vérification de la présence du numéro de dossier
    # cliquable
    Déclencher le traitement des tâches par WS  
    Depuis le contexte de la task  ${task_id_cas10}  IDE'AU
    La page ne doit pas contenir d'erreur
    # Comme on ne connaît pas le numéro de dossier on vérifie qu'il s'agit du bon
    # en se basant sur les données de la payload
    Click Link  css=#dossier + a
    # Temporisation pour s'assurer que la page a bien le temps de se charger
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}    Page Should Contain   Avenue Plop, 13000 

Rendre les types de dossier d'autorisation détaillés utilisés non transmissible à Plat'AU
    [Documentation]  Il est nécessaire de faire cette manipulation pour revenir à un état normal
    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}
    Modifier type de dossier d'autorisation détaillé  DP  ${args_type_DA_detaille_modification}

TNR vérification que la création de dossiers non transmissible n'entraine pas une tache Création DA
    [Documentation]  Vérifie que lorsqu'un dossier est créé, si ce n'est pas un type de dossier
    ...  transmissible à Plat'Au alors il n'y a pas de tâche Création DA ajoutée à la liste des
    ...  task

    # Tout les types de dossier ont été rendu non transmissible au test précédent
    # n'importe quel type de dossier peut donc être utilisé
    Depuis la page d'accueil  admin  admin

    # Création d'un dossier non transmissible
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  depot_electronique=true
    ...  source_depot=platau
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Sirois
    ...  particulier_prenom=Eugenia
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    # Vérification de l'absence de task Création DA lié au dossier
    Depuis le menu Moniteur Plat'AU
    #
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#dossier
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#type
    # On remplit
    ${di_sans_espace} =  Sans espace  ${di}
    ${di_da} =  Replace String Using Regexp  ${di_sans_espace}  [A-Z][0-9]+$  ${EMPTY}
    Select From List By Label  css=#type  Création DA
    Input Text  css=#dossier  ${di_da}
    Select From List By Label  css=#state  à traiter
    Select From List By Label  css=#stream  Sortant
    # On valide le formulaire de recherche
    Click On Search Button
    # Aucune tache d'ajout de pièce ne doit être trouvé
    Element Should Contain  css=#tab-task  Aucun enregistrement.

Rendre les types de dossier d'autorisation détaillés utilisés transmissible à Plat'AU
    [Documentation]  Il est nécessaire de faire cette manipulation pour tous les tests liés à la transmission à Plat'AU.
    ...  Si cette case n'est pas coché, il n'y a pas d'ajout de tâche sur le type de da détaillé concerné.
    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}
    Modifier type de dossier d'autorisation détaillé  DP  ${args_type_DA_detaille_modification}

Ajout de commentaire aux tâches du moniteur 
    [Documentation]  Vérifie l'implémentation du champ commentaire ainsi que la modification de ce champ
    ...  pour un tache du moniteur Plat'AU/IDE'AU
    
    Depuis la page d'accueil  admin  admin

    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300LieuComments
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Terrieur
    ...  particulier_prenom=Alain
    ...  localite=TEST300Localite
    ...  om_collectivite=MARSEILLE
    ${di_comments} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di_comments}  ${donnees_techniques_values}

    ${di_comments_sans_espace} =  Sans espace  ${di_comments}
    ${di_comments_da} =  Replace String Using Regexp  ${di_comments_sans_espace}  [A-Z][0-9]+$  ${EMPTY}
    Set Suite Variable  ${di_comments}
    Set Suite Variable  ${di_comments_sans_espace}
    Set Suite Variable  ${di_comments_da}
    
    #On accède au listing du moniteur Plat'AU et on  vérifie que la colonne "Commentaire" existe bien.
    Depuis le menu Moniteur Plat'AU
    Element Should Contain  css=th.title.col-8.lastcol  commentaire

    #On effectue une recherche avancée sur le dossier d'instruction précedemment créé.
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#dossier
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#type
    # On remplit
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di_comments_da}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Création DA
    # On valide le formulaire de recherche
    Click On Search Button
    #On vérifie que la tâche que l'on recherche apparait dans le listing.
    Element Should Contain  css=td.col-1 a.lienTable  Création DA
    Element Should Contain  css=td.col-4 a.lienTable  ${di_comments_da}

    &{comments_task_values} =  Create Dictionary
    ...  type=creation_DA
    ...  dossier=${di_comments_da}
    ...  state=new
    ...  object_id=${di_comments_da}
    ...  link_dossier=${di_comments_da}
    ...  stream=output
    
    #On accède à la tâche afin de la modifier
    Depuis le contexte d'une task à partir de la recherche avancée  ${comments_task_values}
    ${task_id} =  Get Text  css=#task
    Click On Form Portlet Action  task  modifier
    #On ajoute un commentaire dans le textarea et on valide la modification
    Input Text  css=textarea#comment.champFormulaire  C'est un commentaire de test avec des apostrophes et caractères spéciaux !
    Click On Submit Button
    #On vérifie que dans le résumé de la tâche, le commentaire soit bien mis à jour.
    Element Text Should Be  css=span#comment  C'est un commentaire de test avec des apostrophes et caractères spéciaux !
    
    #On retourne sur le listing global et on recherche à nouveau notre tâche. On peut ainsi vérifier 
    # si le commentaire apparait correctement dans la colonne "Commentaire"
    Depuis le menu Moniteur Plat'AU
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#dossier
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#type
    # On remplit
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di_comments_da}
    Select From List By Label  css=div#adv-search-adv-fields select#type  Création DA
    # On valide le formulaire de recherche
    Click On Search Button
    #On vérifie le contenu de la colonne commentaire.
    Element Text Should Be  css=td.col-8.lastcol  C'est un commentaire de test avec des apostrophes et caractères spéciaux !

    # Modification de l'état et du commentaire depuis l'action 997
    &{task_data} =  Create Dictionary
    ...  state=debug
    ...  comment=C'est un autre commentaire de test avec des apostrophes et caractères spéciaux !
    ${COOKIE} =  Get Cookie  ${SESSION_COOKIE}
    ${cookies} =  Create Dictionary  ${SESSION_COOKIE}=${COOKIE.value}
    ${session} =  Set Variable  ${PROJECT_NAME}_web_ihm
    Create Session  ${session}  ${PROJECT_URL}  cookies=${cookies}
    ${headers} =  Create Dictionary  Content-Type=application/x-www-form-urlencoded
    ${response} =  Post Request  ${session}  /app/index.php?module=form&obj=task&action=997&idx=${task_id}  data=${task_data}  headers=${headers}

    Depuis le contexte de la task  ${task_id}
    Element Text Should Be  css=span#comment  C'est un autre commentaire de test avec des apostrophes et caractères spéciaux !


Vérification de l'ajout d'un dossier d'instruction depuis Plat'AU + vérification d'un dépôt sur dossier existant
    [Documentation]  Vérifie la création de dossier avec une tâche issue de Plat'AU.
    ...  Dans ce contexte il ne doit pas y avoir de task de création de DA, ni de création de DI.
    ...  Vérifie également le dépôt d'une demande sur dossier existant, qui ne créée pas de dossier.

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}
    &{param_mode_sc} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_mode_sc}
    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # Isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_CREATE_DI_PLATAU
    ...  departement=030
    ...  commune=111
    ...  insee=30111
    ...  direction_code=STI
    ...  direction_libelle=Direction de LIBRECOM_WS_CREATE_DI_PLATAU
    ...  direction_chef=Chef
    ...  division_code=STI
    ...  division_libelle=Division STI
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Agnès Leroux
    ...  guichet_om_utilisateur_email=aleroux@openads-test.fr
    ...  guichet_om_utilisateur_login=aleroux
    ...  guichet_om_utilisateur_pwd=aleroux
    ...  instr_om_utilisateur_nom=Nathalie Beaulé
    ...  instr_om_utilisateur_email=nbeaule@openads-test.fr
    ...  instr_om_utilisateur_login=nbeaule
    ...  instr_om_utilisateur_pwd=nbeaule
    ...  code_entite=LBCOM_30
    ...  acteur=LIBRECOM-ACT-030
    Isolation d'un contexte  ${librecom_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_instructeur
    ...  ${librecom_values["acteur"]}  ${librecom_values["om_collectivite_libelle"]}

    ##
    ## Vérification de l'ajout d'un dossier d'instruction depuis Plat'AU
    ##

    # Récupère le payload de création DI
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  KWE-Z9G-OYW  123-DDD-12
    ${json_payload} =  Replace String  ${json_payload}  515-Q0L-KMX  DDD-123-12
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  71Z-Y9O-KWQ  ${librecom_values["acteur"]}
    ${payload_dict} =  To Json  ${json_payload}
    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    # Les attributs state et stream ne sont pas nécessaires lors de l'ajout de la tache
    # Ici ces attributs sont utilisés lors de la vérification des données de la tâches en consultation
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    ...  category=platau
    Ajouter la tâche par WS  ${task_values}

    ${msg} =  Déclencher le traitement des tâches par WS

    &{seach_di_values} =  Create Dictionary
    ...  om_collectivite=${librecom_values["om_collectivite_libelle"]}
    Depuis le contexte du dossier d'instruction par la recherche avance  ${seach_di_values}  ${librecom_values["om_collectivite_libelle"]}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#dossier_libelle
    ${dossier_libelle} =  Get Text  css=#dossier_libelle
    ${di} =  Sans espace  ${dossier_libelle}

    Depuis le menu Moniteur Plat'AU

    # On vérifie qu'il n'y ait pas de tâche Création demande
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Création demande
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Création demande
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${di}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.

    # On vérifie qu'il n'y ait pas de tâche Création DA
    ${passed} =  Run Keyword And Return Status  Element Should Not Contain  css=div#adv-search-adv-fields select#type  Création DA
    Run Keyword If  ${passed}==False  Select From List By Label  css=select#type  Création DA
    Run Keyword If  ${passed}==False  Input Text  css=div#adv-search-adv-fields input#dossier  ${di}
    Run Keyword If  ${passed}==False  Click On Search Button
    Run Keyword If  ${passed}==False  Element Should Contain  css=.tab-data  Aucun enregistrement.

    ##
    ## Vérification d'un dépôt sur dossier existant.
    ## L'objectif est de vérifier l'ajout d'une demande sur existant et de vérifier également
    ## que dans le cas de plusieurs types de demande similaire, l'état du dossier initial
    ## est correctement pris en compte.
    ##

    # Création des événements de DPC
    &{args_evenement_01} =  Create Dictionary
    ...  libelle=Dépôt de pièces complémentaire 01 TEST300VERIFDEPOTEXISTS
    Ajouter l'événement depuis le menu  ${args_evenement_01}
    &{args_evenement_02} =  Create Dictionary
    ...  libelle=Dépôt de pièces complémentaire 02 TEST300VERIFDEPOTEXISTS
    Ajouter l'événement depuis le menu  ${args_evenement_02}

    # Création de deux types de dépôt sur existant partageant le même code mais ne s'appliquant
    # pas sur le même état
    @{etats_autorises} =  Create List
    ...  delai de notification envoye
    &{args_demande_type_01} =  Create Dictionary
    ...  code=DPC
    ...  libelle=Dépot de pièces complémentaire DP 01 TEST300VERIFDEPOTEXISTS
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=DP (Déclaration préalable)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=@{etats_autorises}
    ...  contraintes=Récupération des demandeurs avec modification et ajout
    ...  evenement=${args_evenement_01.libelle}
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type_01}
    @{etats_autorises} =  Create List
    ...  dossier incomplet
    &{args_demande_type_02} =  Create Dictionary
    ...  code=DPC
    ...  libelle=Dépot de pièces complémentaire DP 02 TEST300VERIFDEPOTEXISTS
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=DP (Déclaration préalable)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=@{etats_autorises}
    ...  contraintes=Récupération des demandeurs avec modification et ajout
    ...  evenement=${args_evenement_02.libelle}
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type_02}
    # définir les paramètres de type de demande
    &{platau_type_demande_dpc} =  Create Dictionary
    ...  libelle=platau_type_demande_dpc_DP
    ...  valeur=DPC
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_dpc}

    # Récupère le payload de création DI sur exisant (dépôt de pièce complémentaire)
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_sur_existant_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  XXX  ${di}
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    ...  category=portal
    Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS

    # Vérifie que l'instruction s'est correctement appliqué au dossier d'instruction
    # et que le bon type de demande a été sélectionné
    Depuis l'onglet instruction du dossier d'instruction  ${dossier_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.tab-tab  ${args_evenement_01.libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=.tab-tab  ${args_evenement_02.libelle}

    # Ajoute une instruction pour modifier l'état du dossier d'insturction
    Ajouter une instruction au DI  ${dossier_libelle}  Notification de pieces manquante

    # Réapplique la demande sur existant
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_sur_existant_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  XXX  ${di}
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    ...  category=portal
    Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS

    # Vérifie que l'instruction s'est correctement appliqué au dossier d'instruction
    # et que le bon type de demande a été sélectionné
    Depuis l'onglet instruction du dossier d'instruction  ${dossier_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.tab-tab  ${args_evenement_02.libelle}

    ##
    ## Vérification d'un dépôt sur dossier existant.
    ## L'objectif est de vérifier l'ajout d'une demande sur existant qui ajoute une dossier d'instruction
    ## et de vérifier la gestion des contraintes de récupération des demandeurs.
    ##

    # Active l'option pour afficher le menu task_portal
    &{param_args} =  Create Dictionary
    ...  libelle=option_notification
    ...  valeur=portal
    ...  om_collectivite=${librecom_values["om_collectivite_libelle"]}
    Ajouter ou modifier le paramètre depuis le menu   ${param_args}

    # Ajout d'un modificatif sur l'autorisation avec une contrainte de récupération
    # des demandeurs "Récupération des demandeurs avec modification et ajout"
    # Ajout d'un événement permettant de reprendre l'instruction du dossier initial
    &{args_action} =  Create Dictionary
    ...  action=changer_etat_300
    ...  libelle=changer_etat_300
    ...  regle_etat=etat
    Ajouter l'action depuis le menu  ${args_action}
    @{etat_source} =  Create List  dossier incomplet
    @{type_di} =  Create List  DP - P - Initiale
    &{args_evenement} =  Create Dictionary
    ...  libelle=Reprendre instruction 300
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=${args_action.libelle}
    ...  etat=delai de notification envoye
    Ajouter l'événement depuis le menu  ${args_evenement}
    Ajouter une instruction au DI  ${dossier_libelle}  ${args_evenement.libelle}
    Ajouter une instruction au DI  ${dossier_libelle}  accepter un dossier avec reserve
    # Création du type de demande
    @{etats_autorises} =  Create List
    ...  dossier accepter
    &{args_demande_type} =  Create Dictionary
    ...  code=DPM
    ...  libelle=Modificatif DP TEST300VERIFDEPOTEXISTS
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=DP (Déclaration préalable)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=@{etats_autorises}
    ...  contraintes=Récupération des demandeurs avec modification et ajout
    ...  evenement=Notification du delai legal maison individuelle
    ...  dossier_instruction_type=DP - Modificatif
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}
    # Défini les paramètres de type de demande
    &{platau_type_demande} =  Create Dictionary
    ...  libelle=platau_type_demande_DPM_DP
    ...  valeur=DPM
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande}
    # Traitement de la tâche
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_sur_existant_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  XXX  ${di}
    ${json_payload} =  Replace String  ${json_payload}  dpc  DPM
    ${json_payload} =  Replace String  ${json_payload}  pieces_complementaires/44  DPM/11
    ${json_payload} =  Replace String  ${json_payload}  Perry  FRANCOEUR
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    ...  category=portal
    ${task_id} =  Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    Depuis le contexte de la task  ${task_id}  IDE'AU
    ${dossier} =  Get Text  css=#object_id
    # Contrôle la localisation et les demandeurs depuis le nouveau dossier d'instruction
    Depuis le contexte du dossier d'instruction  ${dossier}  null  false
    ${dossier} =  Get Text  css=#dossier_libelle
    Open Fieldset  dossier_instruction  localisation
    Element Should Not Contain  fieldset-form-dossier_instruction-localisation  rue de l'espoir
    Element Should Contain  fieldset-form-dossier_instruction-localisation  rue de l'espérance
    Open Fieldset  dossier_instruction  demandeur
    Element Should Not Contain  liste_demandeur  Perry Katy
    Element Should Contain  liste_demandeur  FRANCOEUR Katy
    Element Should Contain  liste_demandeur  Bloom Orlando
    Element Should Contain  liste_demandeur  LAGRANGE Marcel
    Element Should Contain  liste_demandeur  Dupré Michel
    Element Should Contain  liste_demandeur  Perry Plop
    Ajouter une instruction au DI  ${dossier}  accepter un dossier avec reserve

    #
    # Ajout d'un code de suivi portail au dossier d'instruction
    #

    # Ajout du lien pour les suivis de demande
    &{param_args} =  Create Dictionary
    ...  libelle=portal_code_suivi_base_url
    ...  valeur=LIEN_PORTAL/[PORTAL_CODE_SUIVI]/load
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_args}

    # Utilisation de l'action 997 pour ajouter le code de suivi
    &{data} =  Create Dictionary
    ...  external_uid=code-suivi://TEST300CODESUIVIPORTAL
    ${COOKIE} =  Get Cookie  ${SESSION_COOKIE}
    ${cookies} =  Create Dictionary  ${SESSION_COOKIE}=${COOKIE.value}
    ${session} =  Set Variable  ${PROJECT_NAME}_web_ihm
    Create Session  ${session}  ${PROJECT_URL}  cookies=${cookies}
    ${headers} =  Create Dictionary  Content-Type=application/x-www-form-urlencoded
    ${response} =  Post Request  ${session}  /app/index.php?module=form&obj=task&action=997&idx=${task_id}  data=${data}  headers=${headers}
    # Vérification du lien
    Depuis le contexte du dossier d'instruction  ${dossier}
    Open All Fieldset Using Javascript  dossier_instruction
    Element Should Contain  css=span#lien_iiue_portal  TEST300CODESUIVIPORTAL

    # Ajout de plusieurs codes de suivi
    &{data} =  Create Dictionary
    ...  external_uid=code-suivi://TEST300CODESUIVIPORTAL2
    ${COOKIE} =  Get Cookie  ${SESSION_COOKIE}
    ${cookies} =  Create Dictionary  ${SESSION_COOKIE}=${COOKIE.value}
    ${session} =  Set Variable  ${PROJECT_NAME}_web_ihm
    Create Session  ${session}  ${PROJECT_URL}  cookies=${cookies}
    ${headers} =  Create Dictionary  Content-Type=application/x-www-form-urlencoded
    ${response} =  Post Request  ${session}  /app/index.php?module=form&obj=task&action=997&idx=${task_id}  data=${data}  headers=${headers}
    &{data} =  Create Dictionary
    ...  external_uid=code-suivi://TEST300CODESUIVIPORTAL3
    ${COOKIE} =  Get Cookie  ${SESSION_COOKIE}
    ${cookies} =  Create Dictionary  ${SESSION_COOKIE}=${COOKIE.value}
    ${session} =  Set Variable  ${PROJECT_NAME}_web_ihm
    Create Session  ${session}  ${PROJECT_URL}  cookies=${cookies}
    ${headers} =  Create Dictionary  Content-Type=application/x-www-form-urlencoded
    ${response} =  Post Request  ${session}  /app/index.php?module=form&obj=task&action=997&idx=${task_id}  data=${data}  headers=${headers}
    # Vérification des liens
    Depuis le contexte du dossier d'instruction  ${dossier}
    Open All Fieldset Using Javascript  dossier_instruction
    Element Should Contain  css=span#lien_iiue_portal  TEST300CODESUIVIPORTAL
    Element Should Contain  css=span#lien_iiue_portal  TEST300CODESUIVIPORTAL2
    Element Should Contain  css=span#lien_iiue_portal  TEST300CODESUIVIPORTAL3

    # Suppression du lien pour les suivis de demande
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=portal_code_suivi_base_url
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

    # Ajout d'une DAACT sur l'autorisation avec une contrainte de récupération
    # des demandeurs "Récupération des demandeurs sans modification ni ajout"

    # Création du type de demande
    @{etats_autorises} =  Create List
    ...  dossier accepter
    &{args_demande_type} =  Create Dictionary
    ...  code=DPDAACT
    ...  libelle=DAACT DP TEST300VERIFDEPOTEXISTS
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=DP (Déclaration préalable)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=@{etats_autorises}
    ...  contraintes=Récupération des demandeurs sans modification ni ajout
    ...  evenement=Notification du delai legal maison individuelle
    ...  dossier_instruction_type=DP - Achèvement et conformité
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}
    # Défini les paramètres de type de demande
    &{platau_type_demande} =  Create Dictionary
    ...  libelle=platau_type_demande_DPDAACT_DP
    ...  valeur=DPDAACT
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande}
    # Traitement de la tâche
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_sur_existant_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  XXX  ${di}
    ${json_payload} =  Replace String  ${json_payload}  dpc  DPDAACT
    ${json_payload} =  Replace String  ${json_payload}  pieces_complementaires/44  DPDAACT/22
    ${json_payload} =  Replace String  ${json_payload}  Perry  MAHEU
    ${json_payload} =  Replace String  ${json_payload}  LAGRANGE  GADBOIS
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    ...  category=portal
    ${task_id} =  Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    Depuis le contexte de la task  ${task_id}  IDE'AU
    ${dossier} =  Get Text  css=#object_id
    # Contrôle la localisation et les demandeurs depuis le nouveau dossier d'instruction
    Depuis le contexte du dossier d'instruction  ${dossier}  null  false
    ${dossier} =  Get Text  css=#dossier_libelle
    Open Fieldset  dossier_instruction  localisation
    Element Should Not Contain  fieldset-form-dossier_instruction-localisation  rue de l'espoir
    Element Should Contain  fieldset-form-dossier_instruction-localisation  rue de l'espérance
    Open Fieldset  dossier_instruction  demandeur
    Element Should Not Contain  liste_demandeur  MAHEU Katy
    Element Should Not Contain  liste_demandeur  GADBOIS Marcel
    Element Should Contain  liste_demandeur  FRANCOEUR Katy
    Element Should Contain  liste_demandeur  Bloom Orlando
    Element Should Contain  liste_demandeur  LAGRANGE Marcel
    Element Should Contain  liste_demandeur  Dupré Michel
    Element Should Contain  liste_demandeur  Perry Plop
    Ajouter une instruction au DI  ${dossier}  accepter un dossier avec reserve

    # Ajout d'un transfert sur l'autorisation avec une contrainte de récupération
    # des demandeurs "Sans récupération des demandeurs"

    # Création du type de demande
    @{etats_autorises} =  Create List
    ...  dossier accepter
    &{args_demande_type} =  Create Dictionary
    ...  code=DPT
    ...  libelle=Transfert DP TEST300VERIFDEPOTEXISTS
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=DP (Déclaration préalable)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=@{etats_autorises}
    ...  contraintes=Sans récupération des demandeurs
    ...  evenement=Notification du delai legal maison individuelle
    ...  dossier_instruction_type=DP - Transfert
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}
    # Défini les paramètres de type de demande
    &{platau_type_demande} =  Create Dictionary
    ...  libelle=platau_type_demande_DPT_DP
    ...  valeur=DPT
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande}
    # Traitement de la tâche
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_sur_existant_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  XXX  ${di}
    ${json_payload} =  Replace String  ${json_payload}  dpc  DPT
    ${json_payload} =  Replace String  ${json_payload}  pieces_complementaires/44  DPT/33
    ${json_payload} =  Replace String  ${json_payload}  Perry  SEGUIN
    ${json_payload} =  Replace String  ${json_payload}  LAGRANGE  DUFRESNE
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    ...  category=portal
    ${task_id} =  Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    Depuis le contexte de la task  ${task_id}  IDE'AU
    ${dossier} =  Get Text  css=#object_id
    # Contrôle la localisation et les demandeurs depuis le nouveau dossier d'instruction
    Depuis le contexte du dossier d'instruction  ${dossier}  null  false
    ${dossier} =  Get Text  css=#dossier_libelle
    Open Fieldset  dossier_instruction  localisation
    Element Should Not Contain  fieldset-form-dossier_instruction-localisation  rue de l'espoir
    Element Should Contain  fieldset-form-dossier_instruction-localisation  rue de l'espérance
    Open Fieldset  dossier_instruction  demandeur
    Element Should Not Contain  liste_demandeur  FRANCOEUR Katy
    Element Should Not Contain  liste_demandeur  Bloom Orlando
    Element Should Not Contain  liste_demandeur  LAGRANGE Marcel
    Element Should Not Contain  liste_demandeur  Dupré Michel
    Element Should Not Contain  liste_demandeur  Perry Plop
    Element Should Contain  liste_demandeur  SEGUIN Katy
    Element Should Contain  liste_demandeur  DUFRESNE Marcel
    Ajouter une instruction au DI  ${dossier}  accepter un dossier avec reserve

    # Ajout d'une DOC sur l'autorisation avec une contrainte de récupération
    # des demandeurs "Récupération des demandeurs sans modification avec ajout"

    # Création du type de demande
    @{etats_autorises} =  Create List
    ...  dossier accepter
    &{args_demande_type} =  Create Dictionary
    ...  code=DPDOC
    ...  libelle=DOC DP TEST300VERIFDEPOTEXISTS
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=DP (Déclaration préalable)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=@{etats_autorises}
    ...  contraintes=Récupération des demandeurs sans modification avec ajout
    ...  evenement=Notification du delai legal maison individuelle
    ...  dossier_instruction_type=DP - Ouverture de chantier
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}
    # Défini les paramètres de type de demande
    &{platau_type_demande} =  Create Dictionary
    ...  libelle=platau_type_demande_DPDOC_DP
    ...  valeur=DPDOC
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande}
    # Traitement de la tâche
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_sur_existant_payload.txt
    ${json_payload} =  Replace String  ${json_payload}  13055  ${librecom_values["insee"]}
    ${json_payload} =  Replace String  ${json_payload}  XXX  ${di}
    ${json_payload} =  Replace String  ${json_payload}  dpc  DPDOC
    ${json_payload} =  Replace String  ${json_payload}  pieces_complementaires/44  DPDOC/44
    ${json_payload} =  Replace String  ${json_payload}  Perry  PICARD
    ${json_payload} =  Replace String  ${json_payload}  LAGRANGE  CAMUS
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI
    ...  json_payload=${json_payload}
    ...  category=portal
    ${task_id} =  Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    Depuis le contexte de la task  ${task_id}  IDE'AU
    ${dossier} =  Get Text  css=#object_id
    # Contrôle la localisation et les demandeurs depuis le nouveau dossier d'instruction
    Depuis le contexte du dossier d'instruction  ${dossier}  null  false
    Open Fieldset  dossier_instruction  localisation
    Element Should Not Contain  fieldset-form-dossier_instruction-localisation  rue de l'espoir
    Element Should Contain  fieldset-form-dossier_instruction-localisation  rue de l'espérance
    Open Fieldset  dossier_instruction  demandeur
    Element Should Contain  liste_demandeur  SEGUIN Katy
    Element Should Contain  liste_demandeur  DUFRESNE Marcel
    Element Should Contain  liste_demandeur  PICARD Katy
    Element Should Contain  liste_demandeur  CAMUS Marcel

    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # Suppression du paramétrage de notification
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification
    ...  click_value=${librecom_values["om_collectivite_libelle"]}
    Supprimer le paramètre (surcharge)  ${param_args}

Rendre les types de dossier d'autorisation détaillés utilisés non transmissible à Plat'AU
    [Documentation]  Il est nécessaire de faire cette manipulation pour revenir à un état normal
    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}
    Modifier type de dossier d'autorisation détaillé  DP  ${args_type_DA_detaille_modification}

Désactivation de l'option 'option_notification_piece_numerisee'
    [Documentation]  Il est nécessaire de faire cette manipulation pour éviter le
    ...  FAIL: Element with locator 'dossier_message_id' not found.

    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_notification_piece_numerisee
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

