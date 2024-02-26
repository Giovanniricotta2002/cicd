*** Settings ***
Documentation  Actions spécifiques aux instructions.

*** Keywords ***
Ouvrir la bible du complément d'instruction n°
    [Arguments]  ${numero_complement}

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=a[onclick^="bible(${numero_complement});"]

Ajout automatique de complément(s) d'instruction
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=a[onclick^="bible_auto();"]

Depuis le formulaire d'ajout d'une instruction du DI
    [Arguments]  ${di}  ${menu}=null

    Depuis l'onglet instruction du dossier d'instruction  ${di}  ${menu}
    Run Keyword If  '${menu}' == 'infraction'  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction_contexte_ctx_inf-corner-ajouter
    ...  ELSE IF  '${menu}' == 'recours'  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction_contexte_ctx_re-corner-ajouter
    ...  ELSE  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Wait Until Element Is Visible  evenement_chosen


Ajouter une instruction au DI
    [Arguments]  ${di}  ${evenement}  ${date_evenement}=null  ${menu}=null  ${signataire_arrete}=null  ${redaction_type}=null  ${commentaire}=null

    Depuis le formulaire d'ajout d'une instruction du DI  ${di}  ${menu}
    Saisir instruction  ${evenement}  ${date_evenement}  ${signataire_arrete}  ${redaction_type}  ${commentaire}

    # Vérification si une lettre type est associée à l'instruction en cours :
    ${status} =  Run Keyword And Return Status  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#lib-signataire_arrete
    Click On Submit Button In Subform
    # Si c'est le cas -> parcours utilisateur inchangé
    Run Keyword If  ${status} == True  Page Should Contain  Vos modifications ont bien été enregistrées.
    ${instruction_avec_lettretype} =  Run Keyword If  ${status} == True  Get Value  css=.form-content input#instruction
    # Sinon -> on récupère le numero de l'instruction à l'aide du nom de son évènement, car le parcours utilisateur
    # à été modifié (une étape "retour" désuet à été supprimé)
    Run Keyword If  ${status} == False  Page Should Contain  Vos modifications ont bien été enregistrées.
    ${instruction_sans_lettretype} =  Run Keyword If  ${status} == False  Get Text  xpath=//div[@class="soustab-container"]/descendant::a[normalize-space(text()) = "${evenement}"]/ancestor::tr/td[2]/a[@class ="lienTable"]

    ${instruction} =  Run Keyword If  ${status} == True  
    ...  Set Variable  ${instruction_avec_lettretype}
    ...  ELSE  
    ...  Set Variable  ${instruction_sans_lettretype}

    [return]  ${instruction}

Ajouter une instruction au DI et la finaliser
    [Arguments]  ${di}  ${evenement}  ${return_id}=false  ${date_evenement}=null  ${menu}=null  ${signataire_arrete}=null  ${redaction_type}=null

    Depuis l'onglet instruction du dossier d'instruction  ${di}  ${menu}
    Run Keyword If  '${menu}' == 'infraction'  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction_contexte_ctx_inf-corner-ajouter
    ...  ELSE IF  '${menu}' == 'recours'  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction_contexte_ctx_re-corner-ajouter
    ...  ELSE  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Saisir instruction  ${evenement}  ${date_evenement}  ${signataire_arrete}  ${redaction_type}
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click On Link  ${evenement}
    Wait Until Page Does Not Contain  Le traitement est en cours. Merci de patienter.
    ${instruction} =  Get Value  css=.form-content input#instruction
    ${code_barres} =  STR_PAD_LEFT  ${instruction}  10  0
    ${code_barres} =  Catenate  11${code_barres}
    Run Keyword If  '${menu}' == 'infraction'  Click On SubForm Portlet Action  instruction_contexte_ctx_inf  finaliser
    ...  ELSE IF  '${menu}' == 'recours'  Click On SubForm Portlet Action  instruction_contexte_ctx_re  finaliser
    ...  ELSE  Click On SubForm Portlet Action  instruction  finaliser
    ${res} =  Set Variable If  '${return_id}' == 'false'  ${code_barres}
    ...  ${instruction}

    [Return]  ${res}

Saisir instruction
    [Arguments]  ${evenement}=null  ${date_evenement}=null  ${signataire_arrete}=null  ${redaction_type}=null  ${commentaire}=null

    # On sélectionne l'événement, avec utilisation de doubles quotes pour que
    # les événements contenant une apostrophe ne fassent pas bug
    Run Keyword If  "${evenement}" != "null"  Select From Chosen List  evenement  ${evenement}
    # On saisit la date
    Run Keyword If  "${date_evenement}" != "null"  Input Text  date_evenement  ${date_evenement}
    # On saisie le signataire
    Run Keyword If  "${signataire_arrete}" != "null"  Select From List By Label  signataire_arrete  ${signataire_arrete}
    # On saisie le type de rédaction
    Run Keyword If  "${redaction_type}" != "null"  Select From List By Label  flag_edition_integrale  ${redaction_type}
    # On saisie le commenatire justifiant l'instruction
    Run Keyword If  "${commentaire}" != "null"  Input Text  commentaire  ${commentaire}

Depuis l'instruction du dossier d'instruction

    [Documentation]  Permet d'accéder à la fiche de l'instruction du dossier
    ...  d'instruction.

    [Arguments]  ${dossier_instruction}  ${instruction}  ${menu}=null

    Depuis l'onglet instruction du dossier d'instruction  ${dossier_instruction}  ${menu}
    # On clique sur l'instruction
    Click On Link  ${instruction}

Supprimer l'instruction
    [Arguments]  ${di}  ${libelle}  ${menu}=null

    Depuis l'instruction du dossier d'instruction  ${di}  ${libelle}  ${menu}
    # On clique sur l'action modifier
    Run Keyword If  '${menu}' == 'infraction'  Click On SubForm Portlet Action  instruction_contexte_ctx_inf  supprimer
    ...  ELSE IF  '${menu}' == 'recours'  Click On SubForm Portlet Action  instruction_contexte_ctx_re  supprimer
    ...  ELSE  Click On SubForm Portlet Action  instruction  supprimer
    # On valide
    Click On Submit Button In Subform
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Valid Message Should Contain  La suppression a été correctement effectuée.


Récupérer le code barres de l'instruction
    [Arguments]  ${di}  ${libelle}

    Depuis l'instruction du dossier d'instruction  ${di}  ${libelle}
    ${instruction} =  Get Value  css=.form-content input#instruction
    ${code_barres} =  STR_PAD_LEFT  ${instruction}  10  0
    ${code_barres} =  Catenate  11${code_barres}

    [Return]  ${code_barres}


Modifier le suivi des dates
    [Documentation]  Permet d'utiliser l'action 'Suivi des dates' du portlet.
    [Arguments]  ${di}  ${instruction}  ${instruction_values}  ${menu}=null

    Depuis l'instruction du dossier d'instruction  ${di}  ${instruction}  ${menu}
    # On clique sur l'action 'Suivi des dates'
    ${sousform} =  Set Variable If  '${menu}' == 'infraction'  instruction_contexte_ctx_inf
    ...  '${menu}' == 'recours'  instruction_contexte_ctx_re
    ...  instruction
    Click On SubForm Portlet Action  ${sousform}  modifier_suivi
    Si "date_finalisation_courrier" existe dans "${instruction_values}" on execute "Input Text" dans "${sousform}"
    Si "date_envoi_signature" existe dans "${instruction_values}" on execute "Input Text" dans "${sousform}"
    Si "date_retour_signature" existe dans "${instruction_values}" on execute "Input Text" dans "${sousform}"
    Si "date_envoi_rar" existe dans "${instruction_values}" on execute "Input Text" dans "${sousform}"
    Si "date_retour_rar" existe dans "${instruction_values}" on execute "Input Text" dans "${sousform}"
    Si "date_envoi_controle_legalite" existe dans "${instruction_values}" on execute "Input Text" dans "${sousform}"
    Si "date_retour_controle_legalite" existe dans "${instruction_values}" on execute "Input Text" dans "${sousform}"
    # On valide le formulaire
    Click On Submit Button In Subform
    # On contôle le message de validation
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.


Cliquer sur le bouton de la fenêtre modale
    [Documentation]  Clic sur un bouton de la fenêtre modale d'après son texte
    [Arguments]  ${texte}

    # construit le sélecteur
    ${selector}=  Set Variable  //div[contains(@class, 'ui-dialog')]/descendant::div[contains(@class, 'ui-dialog-buttonset')]/button/span[text()='${texte}']

    # attend que la fenêtre modale soit remplie et le bouton présent
    Sleep  1
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  xpath=//div[contains(@class, 'ui-dialog')]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  xpath=${selector}

    # attend que la fenêtre modale soit visible et le bouton aussi
    Wait Until Element Is Visible  xpath=//div[contains(@class, 'ui-dialog')]
    Wait Until Element Is Visible  xpath=${selector}

    # clic sur le bouton
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  xpath=${selector}

    # attend que la fenêtre modale soit invisible
    Wait Until Element Is Not Visible  xpath=//div[contains(@class, 'ui-dialog')]

    # délai pour que l'action soit effectuée
    Sleep  2.5
