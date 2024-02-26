*** Settings ***
Documentation     Actions spécifiques au Suivi.

*** Keywords ***
Mettre à jour les dates de suivi
    [Arguments]  ${type_date}  ${date}  ${code_barres}

        [Documentation]

    Select From List By Label  css=#type_mise_a_jour  ${type_date}
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Input Text  date  ${date}
    Input Text  code_barres  ${code_barres}
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=#formulaire div.formControls input[type="submit"]
    # On valide la synthèse
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Contain  Saisie enregistrée

Récupérer le code barre de l'instruction
    [Arguments]  ${instruction}

    ${id_instruction} =  Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Get Text  css=div#form-content span#instruction
    ${code_barres} =  STR_PAD_LEFT  ${id_instruction}  10  0
    ${code_barres} =  Catenate  11${code_barres}

    [Return]  ${code_barres}

Ouvrir le bordereau de suivi
    [Arguments]  ${type_bordereau}

    Wait Until Element Is Visible  bordereau
    Select From List By Label  bordereau  ${type_bordereau}
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  ${type_bordereau} du ${date_ddmmyyyy} au ${date_ddmmyyyy}
    Open PDF  ${OM_PDF_TITLE}

Ouvrir l'édition envoi lettre AR avec le code barres
    [Arguments]  ${date}  ${code_barres}

    Click Link  envoi lettre AR
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Input Text  date  ${date}
    Input Text  liste_code_barres_instruction  ${code_barres}
    Click On Submit Button
    Valid Message Should Contain  Cliquez sur le lien ci-dessous pour télécharger votre document :
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.pdf-16
    Open PDF  ${OM_PDF_TITLE}


