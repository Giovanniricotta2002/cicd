*** Settings ***
Documentation  Actions spécifiques aux tasks.

*** Keywords ***
Depuis le menu Moniteur Plat'AU
    # On accède au tableau
    Depuis le listing  task

Depuis le menu Moniteur IDE'AU
    # On accède au tableau
    Depuis le listing  task_portal

Depuis le listing des tasks à partir de la recherche avancée
    [Documentation]  Accède au listing des tasks et fait une recherche avancée
    [Arguments]  ${values}  ${menu}=platau

    # On accède au tableau
    Run Keyword If  '${menu}' == 'platau'  Depuis le menu Moniteur Plat'AU
    ...  ELSE  Depuis le menu Moniteur IDE'AU
    #
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#dossier
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#type
    # On remplit
    Si "task" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "type" existe dans "${values}" on execute "Select From List By Value" dans le formulaire
    Si "state" existe dans "${values}" on execute "Select From List By Value" dans le formulaire
    Si "stream" existe dans "${values}" on execute "Select From List By Value" dans le formulaire
    Si "object_id" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "creation_date_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "creation_date_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "last_modification_date_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "last_modification_date_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "comment" existe dans "${values}" on execute "Input Text" dans le formulaire
    # On valide le formulaire de recherche
    Click On Search Button

Depuis le contexte d'une task à partir de la recherche avancée
    [Documentation]  Accède à la task
    [Arguments]  ${values}  ${menu}=platau

    Depuis le listing des tasks à partir de la recherche avancée  ${values}  ${menu}
    # On clique sur le résultat
    Run Keyword If  'task' in ${values}  Click On Link  ${values.task}
    Run Keyword If  'task' not in ${values} and 'dossier' in ${values}  Click On Link  ${values.dossier}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Depuis le contexte de la task
    [Documentation]  Accède au formulaire
    [Arguments]  ${task}  ${moniteur}=Plat'AU

    # On accède au tableau
    Run Keyword  Depuis le menu Moniteur ${moniteur}
    # On recherche l'enregistrement
    Input text  css=#task  ${task}
    Click On Search Button
    # On clique sur le résultat
    Click On Link  ${task}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Depuis le contexte de la task via numero de dossier et son type sur le moniteur Plat'AU
    [Documentation]  Accède au formulaire via le num de dossier
    ...    WARNING => A utiliser en cas de task ayant le type
    ...    voulu unique pour le dossier voulu
    [Arguments]  ${numdossier}  ${type}  

    # On accède au tableau
    Run Keyword  Depuis le menu Moniteur Plat'AU
    # On recherche l'enregistrement
    Input text  css=#dossier  ${numdossier}
    Select From List By Label  css=#type  ${type}
    Click On Search Button
    # On clique sur le résultat
    Click On Link  ${numdossier}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Modifier la task
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${task}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte de la task  ${task}
    # Modification de la tâche
    Modifier la tâche depuis sa page de consultation  ${values}

Modifier la tâche depuis sa page de consultation
    [Documentation]  Modifie l'enregistrement en partant de la page
    ...  de consultation de la tâche
    [Arguments]  ${values}  ${form}=task

    # On clique sur le bouton modifier
    Click On Form Portlet Action  ${form}  modifier
    # On saisit des valeurs
    Saisir la task  ${values}
    # On valide le formulaire
    Click On Submit Button
    # Vérification de la présence d'erreur
    La page ne doit pas contenir d'erreur

Supprimer tâche
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${task}

    # On accède à l'enregistrement
    Depuis le contexte de la task  ${task}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  task  supprimer
    # On valide le formulaire
    Click On Submit Button
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Saisir la task
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "timestamp_log" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "state" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "object_id" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "json_payload" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "stream" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "category" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "creation_date" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "creation_time" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "last_modification_date" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "last_modification_time" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "comment" existe dans "${values}" on execute "Input Text" dans le formulaire

Vérifier que la tâche a bien été ajoutée ou modifiée
    [Documentation]  Vérifie que tous les éléments passés en paramètre sont présents
    [Arguments]  ${values}  ${menu}=platau
    Depuis le contexte d'une task à partir de la recherche avancée  ${values}  ${menu}
    Form Value Should Contain  css=#type  ${values.type}
    Form Value Should Contain  css=#state  ${values.state}
    Form Value Should Contain  css=#stream  ${values.stream}
    # Cherche le nom du dossier dans le champs dossier que le lien soit actif ou pas
    Run Keyword If  '${values.stream}'=='output'  Element Should Contain  css=[id^=link_dossier]  ${values.link_dossier}
    Run Keyword If  '${values.stream}'=='input' and 'task' in ${values}  Log  ${values.task}
    Run Keyword If  '${values.stream}'=='input' and 'task' in ${values}  Element Text Should Be  css=#task  ${values.task}
    Run Keyword If  '${values.stream}'=='input' and 'dossier' in ${values}  Log  ${values.dossier}
    Run Keyword If  '${values.stream}'=='input' and 'dossier' in ${values}  Form Value Should Contain  css=#dossier  ${values.dossier}
    Run Keyword If  'object_id' in ${values}  Element Should Contain  css=#object_id  ${values.object_id}

Vérifier qu'il n'y a pas de création d'autre tâche non concerné
    [Arguments]  ${id_next_task}  ${id_dossier}

    Depuis le menu Moniteur Plat'AU
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#dossier
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#type
    Input Text  css=div#adv-search-adv-fields input#dossier  ${id_dossier}
    Input Text  css=div#adv-search-adv-fields input#task  ${id_next_task}
    # Select From List By Label  css=div#adv-search-adv-fields select#type  ${EMPTY}
    Input Text  css=div#adv-search-adv-fields input#object_id  ${EMPTY}
    Click On Search Button
    Element Should Contain  css=.tab-data  Aucun enregistrement.

Vérifier que la tâche à une payload fonctionnelle
    [Documentation]  Vérifie que la tâche courante à une payload qui respecte ces critères :
    ...  - payload avec un format Json valide
    ...  - payload différentes de vide
    ...  - payload sans erreur de récupération
    [Arguments]  ${values}  ${menu}=platau

    Depuis le contexte d'une task à partir de la recherche avancée  ${values}  ${menu}

    # Vérification que pour les tâches sortantes  :
    # - la payload est correctement formaté (json valide)
    # - la payload n'est pas vide
    # - la payload n'est pas d'erreur de récupération
    Open Fieldset  task  json_payload-calculee
    ${payload} =  Get Text  css=pre#json_payload
    # Vérification de la json validité de la payload
    ${payload_json}=  Evaluate  json.loads('''${payload}''')  json
    # Vérification que la payload n'est pas vide et n'a pas d'erreur de récupération
    Should Not Be Equal As Strings  ${payload_json}  ""
    Should Not Be Equal As Strings  ${payload_json}  Impossible de recuperer la payload car l'objet de reference n'existe pas.

Vérifier que la tâche renvoie payload fonctionnelle
    [Documentation]  Vérifie que lorsque l'action (998) de récupération de la payload d'une tâche
    ...  est réalisée, la payload répond aux critères suivant :
    ...  - format Json valide
    ...  - non vide
    ...  - pas d'erreur de récupération
    [Arguments]  ${task_id}

    # Accès à la vue de récupération de la payload
    Go To   ${PROJECT_URL}${OM_ROUTE_FORM}&obj=task&action=998&idx=${task_id}
    Wait Until Page Contains  "task":"${task_id}"

    # Récupération de la payload
    ${payload} =  Get Text  css=#form-container
    Log  ${payload}
    # Vérification de la json validité de la payload
    ${payload_json}=  Evaluate  json.loads(${payload})  json
    # Vérification que la payload n'est pas vide
    # La payload doit obligatoirement contenir des external_uids, si ce terme n'est pas
    # présent, on considère que la payload est vide
    Page Should Contain  external_uids
    # Vérification que la payload n'a pas d'erreur de récupération
    Page Should Not Contain  Impossible de recuperer la payload car l'objet de reference n'existe pas.

Récupérer le contenu du champ json_payload
    [Arguments]  ${values}
    Depuis le contexte d'une task à partir de la recherche avancée  ${values}
    ${status} =  Run Keyword And Return Status  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload>legend  css=#json_payload
    Run Keyword If  '${status}' != 'True'  Click Element Until New Element  css=fieldset#fieldset-form-task-json_payload-calculee>legend  css=#json_payload
    ${json_payload_content} =  Get Text  css=#json_payload
    ${json_payload_loaded} =  Evaluate  json.loads('''${json_payload_content}''')  json
    [Return]  ${json_payload_loaded}

Ajouter la tâche par WS
    [Documentation]  Ajoute une tâche en utilisant le WS voulu. Par défaut
    ...  c'est le WS de test qui est utilisé.
    [Arguments]  ${task_values}  ${ws_to_use}=${EMPTY}

    ${task_id} =  Run Keyword If  '${ws_to_use}'=='application'
    ...  Ajouter la tâche par WS en utilisant le WS de l'application  ${task_values}
    ...  ELSE
    ...  Ajouter la tâche par WS en utilisant le WS de test  ${task_values}

    Log  ${task_id}

    [Return]  ${task_id}

Ajouter la tâche par WS en utilisant le WS de test
    [Documentation]  Ajoute une tâche avec les mêmes paramètres que task
    [Arguments]  ${task_values}

    ${json_task} =  Create Dictionary
    ...  type=${task_values.type}
    ...  json_payload=${task_values.json_payload}
    ...  stream=input
    ${is_object_id_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${task_values}  object_id
    Run Keyword If  ${is_object_id_defined}  Set To Dictionary  ${json_task}  object_id=${task_values.object_id}
    ${is_dossier_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${task_values}  dossier
    Run Keyword If  ${is_dossier_defined}  Set To Dictionary  ${json_task}  dossier=${task_values.dossier}
    ${is_category_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${task_values}  category
    Run Keyword If  ${is_category_defined}  Set To Dictionary  ${json_task}  category=${task_values.category}

    Log  ${json_task}

    ${json_data} =  Create Dictionary
    ...  task=${json_task}

    ${session} =  Catenate  http${PROJECT_NAME}
    Create Session  ${session}  ${PROJECT_URL}tests_services/rest_entry.php
    ${headers} =  Create Dictionary  Content-Type=application/json

    # Convertion de dictionnaire enshaine JSON
    ${json_string}=  evaluate  json.dumps(${json_data})  json

    ${resp}  Post Request  ${session}  /taskadd  data=${json_string}  headers=${headers}

    # On verifie s'il y a eu une erreur
    ${status} =  Run Keyword And Return Status  To Json  ${resp.content}
    Run Keyword If  '${status}' != 'True'  Log  ${resp.content}  WARN

    # Convertion de chaine JSON en dict python
    ${resp} =  To Json  ${resp.content}

    Run Keyword If  '${resp["http_code"]}' != '200'  Log  ${resp["message"]}  WARN
    Should be Equal  '${resp["http_code"]}'  '200'

    # Extraction de l'ID de la tâche dans le message
    ${task_id} =  Replace String Using Regexp  ${resp["message"]}
    ...  ^Tâche '([^']+)' ajoutée avec succès$  \\1
    Log  ${task_id}

    [Return]  ${task_id}

Ajouter la tâche par WS en utilisant le WS de l'application
    [Documentation]  Ajoute une tâche avec les mêmes paramètres que task
    [Arguments]  ${task_values}

    ${task_data_type} =  Create List  ${NONE}  ${task_values.type}
    ${task_data_payload} =  Create List  ${NONE}  ${task_values.json_payload}
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

    [Return]  ${task_id}

Déclencher le traitement des tâches par WS
    [Documentation]  Délenche le traitement des tâches par WS
    [Arguments]  ${values}=null

    ${json_payload} =  Create Dictionary
    ...  module=taches

    ${session} =  Catenate  http${PROJECT_NAME}
    Create Session  ${session}  ${PROJECT_URL}services/rest_entry.php
    ${headers} =  Create Dictionary  Content-Type=application/json

    # Convertion de dictionnaire en chaine JSON
    ${json_string}=  evaluate  json.dumps(${json_payload})  json

    ${resp}  Post Request  ${session}  /taches  data=${json_string}  headers=${headers}

    # On verifie s'il y a eu une erreur
    ${status} =  Run Keyword And Return Status  To Json  ${resp.content}
    Run Keyword If  '${status}' != 'True'  Log  ${resp.content}  WARN

    # Convertion de chaine JSON en dict python
    ${resp} =  To Json  ${resp.content}

    Run Keyword If  '${resp["http_code"]}' != '200'  Log  ${resp["message"]}  WARN
    Run Keyword If  '${values}' == 'null'  Should be Equal  '${resp["http_code"]}'  '200'

    [Return]  ${resp["message"]}

Déclencher le traitement des tâches par WS et retourner la réponse
    [Documentation]  Délenche le traitement des tâches par WS et retourner la réponse
    [Arguments]  ${values}=null

    ${json_payload} =  Create Dictionary
    ...  module=taches

    ${session} =  Catenate  http${PROJECT_NAME}
    Create Session  ${session}  ${PROJECT_URL}services/rest_entry.php
    ${headers} =  Create Dictionary  Content-Type=application/json

    # Convertion de dictionnaire en chaine JSON
    ${json_string}=  evaluate  json.dumps(${json_payload})  json

    ${resp}  Post Request  ${session}  /taches  data=${json_string}  headers=${headers}
    [Return]  ${resp}

Ajouter un external UID
    [Documentation]  Ajoute un nouvel élément dans la table lien_id_interne_uid_externe
    ...  avec les paramètres fournis
    [Arguments]  ${values}

    # Accède au formulaire d'ajout des external uid
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&obj=lien_id_interne_uid_externe&action=0
    # Saisie des valeurs du lien
    Saisir le lien_id_interne_uid_externe  ${values}
    # On valide le formulaire
    Click On Submit Button

Récupérer un external UID
    [Documentation]  Récupère l'external uid d'un élément à partir de son object_id
    [Arguments]  ${object_id}  ${object}

    # Accède au listing des external uid
    Depuis le listing  lien_id_interne_uid_externe
    # Fais une recherche sur l'object_id
    Use Simple Search  object_id  ${object_id}
    # Accède au lien voulu
    Click Element Until No More Element  link:${object}
    # Renvoie l'external_uid de l'élement
    [Return]  Get Text  css=#external_uid

Saisir le lien_id_interne_uid_externe 
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "object" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "object_id" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "external_uid" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "category" existe dans "${values}" on execute "Input Text" dans le formulaire

Créer une tâche de type create_di_for_consultation
    [Documentation]  Recupère la payload d'une tâche create_di_for_consultation et
    ...  la remplis avec les valeurs passée en paramètre.
    [Arguments]  ${values}

    # Récupération de la payload de référence
    ${payload} =  Get File  ${EXECDIR}${/}binary_files${/}create_DI_for_consultation_payload.json
    # Remplissage de la payload à l'aide des valeurs fournies
    # La clé dossier apparaît 2 fois dans la payload pour éviter des erreurs seul l'entrée dossier
    # de la partie external_uid sera modifiée
    :FOR  ${key}  in  @{values.keys()}
    \  ${payload}=  Run keyword If  '${key}' == 'external_uids_dossier'
    \  ...  Replace String  ${payload}  "dossier": "TST_DEF_VAL"  "dossier": "${values["${key}"]}"
    \  ...  ELSE IF  '${key}' == 'dossier'
    \  ...  Replace String  ${payload}  "dossier": "PC0130132200001"  "${key}": "${values["${key}"]}"
    \  ...  ELSE
    \  ...  Replace String Using Regexp  ${payload}  ("${key}": ").*"  "${key}": "${values["${key}"]}"
    Log  ${payload}
    # Ajout de la tâche dans l'application et récupération de son id
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${payload}
    ${task_id}  Ajouter la tâche par WS  ${task_values}
    [return]  ${task_id}
