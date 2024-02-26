*** Settings ***
Documentation     Actions spécifiques aux pièces.

*** Keywords ***
Depuis le contexte de la pièce par le dossier d'instruction

    [Documentation]  Permet d'accéder à l'écran de visualisation de la pièce.

    [Arguments]  ${dossier_instruction}  ${document_numerise}

    Depuis l'onglet des pièces du dossier d'instruction  ${dossier_instruction}
    Click Element Until No More Element  xpath=//div[@id="sousform-document_numerise"]/descendant::div[@id="sousform-container"]/descendant::table[contains(@class,"document_numerise")]/descendant::a[text()[contains(.,"${document_numerise}")]]
    #${selector} =  Set Variable  xpath=//div[@id="sousform-document_numerise"]/descendant::table[contains(@class,"document_numerise")]/descendant::a/span[normalize-space(text())="${document_numerise}"]/ancestor::tr/descendant::a/span[normalize-space(text())="Consulter"]
    #Click Element Until No More Element  ${selector}



Ajouter une pièce depuis le dossier d'instruction

    [Documentation]  Permet d'ajouter une pièce sur un dossier d'instruction.
    ...  ATTENTION : si l'option option_notification_piece_numerisee n'est pas active ce KW échoue
    ...              car il ne peut pas récupérer l'id du message.

    [Arguments]  ${dossier_instruction}  ${document_numerise_values}  ${message}=null

    Saisir et valider le formulaire d'ajout d'une pièce sur le dossier d'instruction
    ...  ${dossier_instruction}
    ...  ${document_numerise_values} 
    ...  ${message}
    # Retourne l'identifiant du message de notification
    ${dossier_message_id} =  Get Value  dossier_message_id
    [Return]  ${dossier_message_id}


Saisir et valider le formulaire d'ajout d'une pièce sur le dossier d'instruction
    [Documentation]  Permet d'ajouter une pièce sur un dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${document_numerise_values}  ${message}=null

    Depuis l'onglet des pièces du dossier d'instruction  ${dossier_instruction}
    # Vérifie que l'action d'ajout est accessible et accède au formulaire d'ajout
    Wait Until Element Is Visible  id=action-soustab-blocnote-message-ajouter
    Click Element  id=action-soustab-blocnote-message-ajouter
    # Remplit le formulaire d'ajout
    Saisir la pièce  ${document_numerise_values}
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform
    # On vérifie le message de validation
    Run Keyword If  '${message}' != 'null'  Message Should Contain In Subform  ${message}
    Run Keyword If  '${message}' == 'null'  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.


Modifier une pièce depuis le dossier d'instruction

    [Documentation]  Permet de modifier une pièce sur un dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${document_numerise}  ${document_numerise_values}  ${message}=null

    #
    Depuis le contexte de la pièce par le dossier d'instruction  ${dossier_instruction}  ${document_numerise}
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  document_numerise  modifier
    #
    Saisir la pièce  ${document_numerise_values}
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform
    # On vérifie le message de validation
    Run Keyword If  '${message}' != 'null'  Message Should Contain In Subform  ${message}
    Run Keyword If  '${message}' == 'null'  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.


Supprimer une pièce depuis le dossier d'instruction

    [Documentation]  Permet de supprimer une pièce sur un dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${document_numerise}  ${message}=null

    #
    Depuis le contexte de la pièce par le dossier d'instruction  ${dossier_instruction}  ${document_numerise}
    # On supprime la pièce
    Supprimer une pièce depuis la page de consultation de la pièce

Supprimer une pièce depuis la page de consultation de la pièce
    [Documentation]  Permet de supprimer une pièce en partant de son interface de consultation.

    [Arguments]  ${message}=null

    # On clique sur laction supprimer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  document_numerise  supprimer
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform
    # On vérifie le message de validation
    Run Keyword If  '${message}' != 'null'  Message Should Contain In Subform  ${message}
    Run Keyword If  '${message}' == 'null'  Valid Message Should Contain In Subform  La suppression a été correctement effectuée.

Saisir la pièce

    [Documentation]  Saisit les valeurs du formulaire.

    [Arguments]  ${document_numerise_values}

    #
    Si "uid_upload" existe dans "${document_numerise_values}" on execute "Add File" sur "uid"
    Si "date_creation" existe dans "${document_numerise_values}" on execute "Input Datepicker From Css Selector" dans "document_numerise"
    ${exist} =    Run Keyword And Return Status   Dictionary Should Contain Key  ${document_numerise_values}  document_numerise_type
    Run Keyword If   ${exist} == True     Select From Chosen List  document_numerise_type  ${document_numerise_values.document_numerise_type}
    Si "description_type" existe dans "${document_numerise_values}" on execute "Input Text" dans "document_numerise"
    Si "uid_dossier_final" existe dans "${document_numerise_values}" on execute "Input HTML" dans "document_numerise"
    Si "document_numerise_nature" existe dans "${document_numerise_values}" on execute "Select From List By Label" dans "document_numerise"

Télécharger toutes les pièces

    [Documentation]  Utilise l'action "Récupérer toutes les pièces" pour récupérer
    ...  l'archive, qui est ensuite enregistrée dans le répertoire courant

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  zip_download_link
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Êtes vous sûr de vouloir télécharger l'intégralité des pièces du dossier
    Click Element  css=button.ui-button:nth-child(1)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Votre archive est prête,
    Page Should Contain  Cliquez ici pour la télécharger
    ${link} =  Get Element Attribute  archive_download_link  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    Click Element  css=.ui-icon-closethick

    [Return]  ${full_path_to_file}  ${output_name}

Télécharger tous les documents

    [Documentation]  Utilise l'action "Télécharger tous les documents" pour récupérer
    ...  l'archive, qui est ensuite enregistrée dans le répertoire courant

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  zip_download_link
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Êtes vous sûr de vouloir télécharger l'intégralité des documents du dossier
    Click Element  css=button.ui-button:nth-child(1)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Votre archive est prête,
    Page Should Contain  Cliquez ici pour la télécharger
    ${link} =  Get Element Attribute  archive_download_link  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    Click Element  css=.ui-icon-closethick

    [Return]  ${full_path_to_file}  ${output_name}

Télécharger le dossier final

    [Documentation]  Utilise l'action "Récupérer toutes les pièces" pour récupérer
    ...  l'archive, qui est ensuite enregistrée dans le répertoire courant

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  telecharger_dossier_final
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Êtes vous sûr(e) de vouloir télécharger l'ensemble des pièces du dossier final ?
    Click Element  css=button.ui-button:nth-child(1)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Votre archive est prête,
    Page Should Contain  Cliquez ici pour la télécharger
    ${link} =  Get Element Attribute  archive_download_link  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    Click Element  css=.ui-icon-closethick

    [Return]  ${full_path_to_file}  ${output_name}

Télécharger l'archive du sous onglet téléchargement
    [Documentation]  On suit les étapes pour télécharger l'archive contenant
    ...  les pièces sélectionnées dans le sous onglet "Téléchargement"

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Êtes vous sûr(e) de vouloir télécharger l'ensemble des documents sélectionnés ?
    Click Element  css=button.ui-button:nth-child(1)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Votre archive est prête,
    Page Should Contain  Cliquez ici pour la télécharger
    ${link} =  Get Element Attribute  archive_download_link  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    Click Element  css=.ui-icon-closethick

    [Return]  ${full_path_to_file}  ${output_name}



Activer l'option de numérisation
    [Documentation]  Permet d'activer l'option de numérisation.
    Move File  ..${/}dyn${/}config.inc.php  ..${/}dyn${/}config.inc.php.bak
    Copy File  ..${/}tests${/}binary_files${/}config_option_numerisation.inc.php  ..${/}dyn${/}config.inc.php
    Depuis la page d'accueil  admin  admin


Désactiver l'option de numérisation
    [Documentation]  Permet de désactiver l'option de numérisation
    Remove File  ..${/}dyn${/}config.inc.php
    Move File  ..${/}dyn${/}config.inc.php.bak  ..${/}dyn${/}config.inc.php
    Depuis la page d'accueil  admin  admin


Vérifier création répertoire du dossier
    [Documentation]    Nécessite la librairie OperatingSystem
    [Arguments]  ${dossier_instruction}

    # On supprime les espaces
    ${temp} =  Sans espace  ${dossier_instruction}
    # On compte la longueur du libellé
    ${input_lenght} =  Get Length  ${temp}
    # A laquelle on ote 2 (taille du suffixe)
    ${over} =    Evaluate    ${input_lenght}-2
    # On récupère le suffixe
    ${part2} =  Get Substring  ${temp}  ${over}
    # On récupère le préfixe
    ${part1} =  Replace String  ${temp}  ${part2}  ${EMPTY}
    # On concatène les deux, séparés par un point
    ${repertoire} =  Catenate  ${part1}.${part2}
    # On vérifie l'existance du répertoire
    Directory Should Exist  ${EXECDIR}${/}..${/}var${/}digitalization${/}Todo${/}${repertoire}

    [Return]  ${repertoire}


Récupérer le chemin du fichier .info de la pièce stocké
    [Documentation]  Permet de récupérer le chemin du .info d'une pièce numérisée dans le
    ...  cas de l'utilisation du conencteur filesystem.
    [Arguments]  ${di}  ${dn}

    Depuis le contexte de la pièce par le dossier d'instruction  ${di}  ${dn}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Subform Portlet Action  document_numerise  modifier
    ${uid} =  Get Value  uid
    ${path_1} =  Get Substring  ${uid}  0  2
    ${path_2} =  Get Substring  ${uid}  0  4
    [Return]  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info


Ajouter une pièce depuis le dossier contentieux

    [Documentation]  Permet d'ajouter une pièce sur un dossier contentieux.

    [Arguments]  ${contentieux}  ${dossier}  ${document_numerise_values}  ${message}=null

    #

    Run Keyword If  '${contentieux}' == 'infraction'  Depuis l'onglet des pièces du dossier infraction  ${dossier}
    Run Keyword If  '${contentieux}' == 'recours'  Depuis l'onglet des pièces du dossier recours  ${dossier}
    #
    Wait Until Element Is Visible  id=action-soustab-blocnote-message-ajouter
    Click Element  id=action-soustab-blocnote-message-ajouter
    #
    Saisir la pièce dans le contexte ctx  ${document_numerise_values}
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform
    # On vérifie le message de validation
    Run Keyword If  '${message}' != 'null'  Message Should Contain In Subform  ${message}
    Run Keyword If  '${message}' == 'null'  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    # Retourne l'identifiant du message de notification
    ${dossier_message_id} =  Get Value  dossier_message_id
    [Return]  ${dossier_message_id}


Saisir la pièce dans le contexte ctx

    [Documentation]  Saisit les valeurs du formulaire dans le contexte des contentieux.

    [Arguments]  ${document_numerise_values}

    #
    Si "uid_upload" existe dans "${document_numerise_values}" on execute "Add File" sur "uid"
    Si "date_creation" existe dans "${document_numerise_values}" on execute "Input Datepicker From Css Selector" dans "document_numerise_contexte_ctx"
    ${exist} =    Run Keyword And Return Status   Dictionary Should Contain Key  ${document_numerise_values}  document_numerise_type
    Run Keyword If   ${exist} == True     Select From Chosen List  document_numerise_type  ${document_numerise_values.document_numerise_type}
    Si "description_type" existe dans "${document_numerise_values}" on execute "Input Text" dans "document_numerise"

Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction

    [Documentation]  Permet d'accéder à l'écran de visualisation des documents de l'onglet pièce.

    [Arguments]  ${dossier_instruction}

    Depuis l'onglet des pièces du dossier d'instruction  ${dossier_instruction}
    Click Element Until New Element  css=div[data-view="document_instruction"]  css=div.switcher__label.onglet_active[data-view="document_instruction"]
    La page ne doit pas contenir d'erreur


Depuis le contexte des documents de travail par le dossier d'instruction

    [Documentation]  Permet d'accéder à l'écran de visualisation du document de travail.

    [Arguments]  ${dossier_instruction}  ${document_travail}
    
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${dossier_instruction}
    # Sélectionne le document de travail cherché
    Click Element Until No More Element  xpath=//div[@id="sousform-document_numerise"]/descendant::div[@id="sousform-container"]/descendant::div[@id="sousform-document_travail"]/descendant::a[text()[contains(.,"${document_travail}")]]


Ajouter un document de travail depuis le dossier d'instruction

    [Documentation]  Permet d'ajouter un document de travail sur un dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${document_numerise_values}  ${message}=null

    #
    Depuis l'onglet des pièces du dossier d'instruction  ${dossier_instruction}
    Click Element Until New Element  css=div[data-view="document_instruction"]  css=div.switcher__label.onglet_active[data-view="document_instruction"]
    #
    Wait Until Element Is Visible  id=action-soustab-document_numerise-corner-ajouter
    Click Element  id=action-soustab-document_numerise-corner-ajouter
    #
    Saisir la pièce  ${document_numerise_values}
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform
    # On vérifie le message de validation
    Run Keyword If  '${message}' != 'null'  Message Should Contain In Subform  ${message}
    Run Keyword If  '${message}' == 'null'  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    # Retourne l'identifiant du message de notification
    ${dossier_message_id} =  Get Value  dossier_message_id
    [Return]  ${dossier_message_id}


Modifier un document de travail depuis le dossier d'instruction

    [Documentation]  Permet de modifier un document de travail sur un dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${document_travail}  ${document_numerise_values}  ${message}=null

    #
    Depuis le contexte des documents de travail par le dossier d'instruction  ${dossier_instruction}  ${document_travail}
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  document_numerise  modifier
    #
    Saisir la pièce  ${document_numerise_values}
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform
    # On vérifie le message de validation
    Run Keyword If  '${message}' != 'null'  Message Should Contain In Subform  ${message}
    Run Keyword If  '${message}' == 'null'  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.


Supprimer un document de travail depuis le dossier d'instruction

    [Documentation]  Permet de supprimer un document de travail sur un dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${document_travail}  ${message}=null

    #
    Depuis le contexte des documents de travail par le dossier d'instruction  ${dossier_instruction}  ${document_travail}
    # On clique sur laction supprimer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  document_numerise  supprimer
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform
    # On vérifie le message de validation
    Run Keyword If  '${message}' != 'null'  Message Should Contain In Subform  ${message}
    Run Keyword If  '${message}' == 'null'  Valid Message Should Contain In Subform  La suppression a été correctement effectuée.


Le document numerise contiens
    [Documentation]  Clique sur le bouton de visualisation de la pièce dont l'identifiant est passé
    ...  en paramètre. Fait un focus sur l'iframe du document pour pouvoir en valider le contenu.
    ...  Déselectionne la frame et ferme la fenêtre.
    ...  /!\ ne fonctionne que pour les documents numérisés au format PDF
    [Arguments]  ${document}  ${content}

    # Ouverture et focus sur le document
    Click Element Until New Element
    ...  xpath=//td[text()[contains(.,"${document}")]]/ancestor::tr/descendant::a[@title = "Prévisualiser"]
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf
    Select Frame  frame_pdf
    # Vérification du contenu
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#viewer .page .textLayer  ${content}
    # Fermeture du document
    Unselect Frame
    Click Element Until No More Element  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=.ui-widget-overlay
