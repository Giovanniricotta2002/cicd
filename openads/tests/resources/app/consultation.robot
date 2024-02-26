*** Settings ***
Documentation  Actions spécifiques aux éléments de la bible.

*** Keywords ***
Depuis l'onglet consultation du dossier
    [Arguments]  ${dossier}

    Depuis le contexte du dossier d'instruction  ${dossier}
    On clique sur l'onglet  consultation  Consultation(s)

Depuis le contexte de la consultation

    [Documentation]  Permet d'accéder à la fiche de la consultation.

    [Arguments]  ${dossier_instruction}  ${consultation}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    On clique sur l'onglet  consultation  Consultation(s)
    # On clique sur le consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ${consultation}

Ajouter une consultation depuis un dossier
    [Arguments]  ${dossier}  ${service}

    Depuis l'onglet consultation du dossier  ${dossier}
    Ajouter une consultation depuis le listing des consultations  ${service}

Ajouter une consultation depuis le listing des consultations
    [Arguments]  ${service}

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter
    # On sélectionne le "service"
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  css=#sformulaire #service  ${service}
    # On valide
    Click On Submit Button In Subform
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.


Rendre l'avis sur la consultation du dossier
    [Arguments]  ${dossier}  ${avis_consultation_values}

    #
    Depuis la demande d'avis en cours du dossier  ${dossier}
    # On reprend la rédaction
    Click On SubForm Portlet Action  demande_avis_encours  rendre_avis  modale
    #
    Saisir l'avis de consultation  ${avis_consultation_values}
    #
    Click On Submit Button In Subform  #sousform-demande_avis_encours
    Page Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    #
    Depuis le listing des demandes d'avis en cours

Ajouter une consultation vers un tiers depuis un dossier
    [Documentation]  Ajout de la consultation d'un tiers. Clique sur l'action de consultation d'un tiers.
    ...  Remplis le formulaire avec les informations du tiers et vérifie que la consultation est bien enregistrée
    [Arguments]  ${dossier}  ${tiers}

    Depuis le formulaire d'ajout d'une consultation vers un tiers sur un dossier  ${dossier}
    # On sélectionne le "tiers"
    Saisir la consultation  ${tiers}
    # On valide
    Click On Submit Button In Subform
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Depuis le formulaire d'ajout d'une consultation vers un tiers sur un dossier
    [Documentation]  Ajout de la consultation d'un tiers. Clique sur l'action de consultation d'un tiers.
    ...  Remplis le formulaire avec les informations du tiers et vérifie que la consultation est bien enregistrée
    [Arguments]  ${dossier}

    Depuis l'onglet consultation du dossier  ${dossier}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_consultation_tiers
    Wait Until Page Contains Element  css=select#categorie_tiers_consulte

Depuis la demande d'avis en cours du dossier
    [Arguments]  ${dossier}
    Depuis le listing des demandes d'avis en cours
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click on link  ${dossier}


Depuis l'onglet des pièces de la demande d'avis en cours du dossier d'instruction

    [Documentation]  Ouvre l'onglet Pièce(s) depuis une demande d'avis.

    [Arguments]  ${dossier}

    #
    Depuis la demande d'avis en cours du dossier  ${dossier}
    #
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Sleep  1


Depuis l'onglet des pièces de la demande d'avis passée du dossier d'instruction

    [Documentation]  Ouvre l'onglet Pièce(s) depuis une demande d'avis.

    [Arguments]  ${dossier}

    #
    Depuis la demande d'avis passée du dossier  ${dossier}
    #
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Sleep  1


Depuis l'onglet des consultations de la demande d'avis en cours du dossier d'instruction
    [Documentation]  Ouvre l'onglet Consultation(s) depuis une demande d'avis.
    [Arguments]  ${dossier}
    #
    Depuis la demande d'avis en cours du dossier  ${dossier}
    #
    On clique sur l'onglet  consultation  Consultation(s)
    Sleep  1


Depuis l'onglet des consultations de la demande d'avis passée du dossier d'instruction
    [Documentation]  Ouvre l'onglet Consultation(s) depuis une demande d'avis.
    [Arguments]  ${dossier}
    #
    Depuis la demande d'avis passée du dossier  ${dossier}
    #
    On clique sur l'onglet  consultation  Consultation(s)
    Sleep  1


Depuis la demande d'avis passée du dossier
    [Arguments]  ${dossier}
    Depuis le listing des demandes d'avis passées
    Click on link    ${dossier}


Depuis la demande d'avis export du dossier
    [Arguments]  ${dossier}
    Depuis le listing des demandes d'avis exports
    Click on link    ${dossier}


Depuis le listing des demandes d'avis passées
    #
    Go To Submenu In Menu    demande_avis    demande_avis_passee
    #
    Page Title Should Be  Demandes D'avis > Passées


Depuis le listing des demandes d'avis exports
    #
    Go To Submenu In Menu    demande_avis    demande_avis
    #
    Page Title Should Be  Demandes D'avis


Depuis le listing des demandes d'avis en cours
    #
    Go To Submenu In Menu    demande_avis    demande_avis_encours
    #
    Page Title Should Be  Demandes D'avis > En Cours


Saisir l'avis de consultation
    [Arguments]  ${avis_consultation_values}

    Si "avis_consultation" existe dans "${avis_consultation_values}" on execute "Select From List By Label" sur "css=select#avis_consultation"
    Si "motivation" existe dans "${avis_consultation_values}" on execute "Input Text" sur "css=textarea#motivation"
    Si "fichier_upload" existe dans "${avis_consultation_values}" on execute "Add File" sur "fichier"

Modifier la consultation
    [Documentation]  Modifie la consultation en étant déjà sur son contexte, avec les
    ...  remplace les champs fournis en paramètre
    [Arguments]  ${saisie_values}

    # On clique sur l'action modifier du portlet
    Click On SubForm Portlet Action  consultation  modifier
    # On saisit le formulaire
    Saisir la consultation  ${saisie_values}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Saisir la consultation
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_envoi" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_retour" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_limite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "service" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "avis_consultation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_reception" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "motivation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "fichier_upload" existe dans "${values}" on execute "Add File" sur "fichier"
    Si "lu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "code_barres" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "categorie_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "motif_consultation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "commentaire" existe dans "${values}" on execute "Input Text" dans le formulaire

Ajouter une pièce à la consultation
    [Documentation]  Ajoute un fichier PDF à une consultation
    [Arguments]  ${values}

    Click On SubForm Portlet Action  consultation  modifier
    # On saisit les valeurs définies en paramètre
    Saisir la consultation  ${values}
    # On valide le formulaire
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    # On récupère le nom de la pièce
    ${document_numerise} =  Get Text  css=.field-type-file > div:nth-child(2)
    [Return]  ${document_numerise}

Marquer le dossier
    [Documentation]  Depuis le contexte d'une consultation, clique sur l'action et vérifie
    ...  que le dossier a bien été marqué.

    Click On Subform Portlet Action  demande_avis_encours  marquer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Dossier marqué avec succès.
    # Le fieldset Demandes d'avis a dû être mis à jour
    Element Text Should Be  marque  Oui

Dé-marquer le dossier
    [Documentation]  Depuis le contexte d'une consultation, clique sur l'action et vérifie
    ...  que le dossier a bien été dé-marqué.

    Click On Subform Portlet Action  demande_avis_encours  demarquer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Dossier dé-marqué avec succès.
    # Le fieldset Demandes d'avis a dû être mis à jour
    Element Text Should Be  marque  Non


Supprimer la consultation depuis le contexte du dossier d'instruction

    [Documentation]  Supprime la consultation depuis l'onglet "Consultation(s)"
    ...  du dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${service}

    #
    Depuis le contexte de la consultation  ${dossier_instruction}  ${service}
    #
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Click On SubForm Portlet Action  consultation  supprimer
    # On valide le formulaire
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Click On Submit Button In Subform
    #
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Valid Message Should Be  La suppression a été correctement effectuée.


Récupérer le chemin du fichier .info du fichier joint de la consultation
    [Documentation]  Permet de récupérer le chemin du .info du fichier joint à une
    ...  consultation dans le cas de l'utilisation du conencteur filesystem.
    [Arguments]  ${dossier_instruction}  ${service}

    Depuis le contexte de la consultation  ${dossier_instruction}  ${service}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  consultation  modifier
    ${uid} =  Get Value  fichier
    ${path_1} =  Get Substring  ${uid}  0  2
    ${path_2} =  Get Substring  ${uid}  0  4
    [Return]  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info

Rendre un avis par WS
    [Documentation]  Récupère une payload de retour d'avis de consultation, la modifie
    ...  pour y intégrer les informations voulues, ajoute la tâche et déclenche le
    ...  traitement des taches.
    ...  ATTENTION, avec l'argument "with_file=True" ce keyword n'est utilisable que lorsque
    ...  la configuration du filestorage alernatif est activé.
    [Arguments]  ${external_uids}  ${avis_consultation}  ${with_file}=True

    # Récupération d'un modèle de payload de retour d'avis
    ${json_payload_without_file} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_avis_consultation_input.json
    ${json_payload_with_file} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_avis_consultation_input_with_file.json
    ${json_payload} =  Set Variable If  ${with_file}==True  ${json_payload_with_file}  ${json_payload_without_file}

    # Remplissage des externals UID
    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${external_uids}    avis
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "avis": "7O3-E01-15O"  "avis": "${external_uids.avis}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${external_uids}    consultation
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "consultation": "6OY-QX3-15L"  "consultation": "${external_uids.consultation}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${external_uids}    dossier
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "dossier": "GL4-R8Q-VL7"  "dossier": "${external_uids.dossier}"
    ...  ELSE  Set Variable  ${json_payload}

    # Remplissage de l'avis
    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${avis_consultation}    avis_consultation
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "avis_consultation": ""  "avis_consultation": "${avis_consultation.avis_consultation}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${avis_consultation}    date_avis
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "date_avis": ""  "date_avis": "${avis_consultation.date_avis}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${avis_consultation}    date_emission
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "date_emission": ""  "date_emission": "${avis_consultation.date_emission}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${avis_consultation}    nom_auteur
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "nom_auteur": ""  "nom_auteur": "${avis_consultation.nom_auteur}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${avis_consultation}    prenom_auteur
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "prenom_auteur": ""  "prenom_auteur": "${avis_consultation.prenom_auteur}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${avis_consultation}    qualite_auteur
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "qualite_auteur": ""  "qualite_auteur": "${avis_consultation.qualite_auteur}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${avis_consultation}    texte_avis
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "texte_avis": ""  "texte_avis": "${avis_consultation.texte_avis}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${avis_consultation}    texte_fondement_avis
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "texte_fondement_avis": ""  "texte_fondement_avis": "${avis_consultation.texte_fondement_avis}"
    ...  ELSE  Set Variable  ${json_payload}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${avis_consultation}    texte_hypotheses
    ${json_payload} =  Run Keyword If   ${exist}    Replace String  ${json_payload}  "texte_hypotheses": ""  "texte_hypotheses": "${avis_consultation.texte_hypotheses}"
    ...  ELSE  Set Variable  ${json_payload}

    # Création de la tâches avis_consultation
    &{task_data} =  Create Dictionary
    ...  type=avis_consultation
    ...  json_payload=${json_payload}
    ${task_id} =  Ajouter la tâche par WS  ${task_data}  application
    # Vérification de la tâche a bien été ajoutée
    ${task_to_find} =  Create Dictionary
    ...  type=avis_consultation
    ...  state=new
    ...  stream=input
    ...  task=${task_id}
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_to_find}

    # Traitement de la tâches avis_consultation
    ${msg} =  Déclencher le traitement des tâches par WS
