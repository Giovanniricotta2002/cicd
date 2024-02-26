*** Settings ***
Documentation  Actions relatives aux menu Export / Import.

*** Keywords ***
Effectuer un export SITADEL avec l'utilisateur
    [Documentation]  Vérifie que l'utilisateur peut effectuer un export SITADEL

    [Arguments]  ${user}  ${password}

    #
    Depuis la page d'accueil  ${user}  ${password}
    #
    Depuis le formulaire de génération de l'export SITADEL
    # On vérifie que les dates sont obligatoires
    Cliquer sur le bouton export SITADEL
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Error Message Should Contain  Les champs dates sont obligatoires
    #
    Input Text  datedebut  15/12/2012
    #
    Cliquer sur le bouton export SITADEL
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Error Message Should Contain  Les champs dates sont obligatoires
    #
    Input Text  datedebut  15/12/2012
    Input Text  datefin  18/12/2012
    #
    Cliquer sur le bouton export SITADEL
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  fichier SITADEL
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  généré
    # Vérifie que le fichier est disponible au téléchargement dans le tableau
    # d'historique des fichiers SITADEL générés
    ${id} =  Get Element Attribute  css=#form-message div.ui-state-valid span.text a  id
    Element Should Be Visible  css=#sousform-storage-sitadel div.soustab-container table.tab-tab a#action-soustab-storage-left-telecharger-${id}

Récupérer l'export SITADEL à la date souhaitée
    [Documentation]  Remplit le formulaire de l'export avec les dates fournis,
    ...  clique sur le bouton d'export, vérifie qu'il a bien été réalisé et
    ...  renvoie le contenu du fichier.
    [Arguments]  ${date_debut}  ${date_fin}  ${numero}=null

    Depuis le formulaire de génération de l'export SITADEL
    Input Text  datedebut  ${date_debut}
    Input Text  datefin  ${date_fin}
    Run Keyword If    '${numero}' != 'null'  Select From List By Label  numero  ${numero}
    Cliquer sur le bouton export SITADEL
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  fichier SITADEL
    Valid Message Should Contain  généré
    # On télécharge le fichier CSV SITADEL
    ${link_SITADEL} =  Get Element Attribute  css=.ui-state-valid span.text a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link_SITADEL}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    # On vérifie que dans le fichier téléchargé il n'y ai pas les valeurs
    # attendues
    ${content_file} =  Get File  ${full_path_to_file}
    [return]  ${content_file}

Vérifier List Dans Export Tableau
    [Documentation]  Effectue une reqmo
    ...  et vérifie dans l'export la presence de la list fournie

    [Arguments]  ${args_export}

    Depuis le menu des statistiques à la demande
    Click On Link  ${args_export.reqmo}

    # S'il y a la presence de dossier_autorisation_type on le select dans la liste
    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${args_export}    dossier_autorisation_type
    Run Keyword If    ${exist} == True    Select From List By Label  dossier_autorisation_type  ${args_export.dossier_autorisation_type}

    Input Text  ${args_export.nom_champ_debut}  ${args_export.date_debut}
    Input Text  ${args_export.nom_champ_fin}  ${args_export.date_fin}
    Select From List By Label  sortie  Tableau - Affichage à l'écran
    # Click on submit  sans valid message
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]

    # On vérifie la présence du contenu de la list dans le tableau de resultat
    ${col_id} =  Set Variable  0
    :FOR  ${colonne}  IN  @{args_export.colonne_valeurs}
    \  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.col-${col_id}  ${colonne}
    \  ${col_id} =  Evaluate  ${col_id}+1

    Element Should Contain  content  ${args_export.content}


Vérifier List Dans Export PDF
    [Documentation]  Effectue une reqmo
    ...  et vérifie dans l'export la presence de la list fournie

    [Arguments]  ${args_export}

    Depuis le menu des statistiques à la demande
    Click On Link  ${args_export.reqmo}

    # S'il y a la presence de dossier_instruction_type on le select dans la liste
    ${exist} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${args_export}  dossier_instruction_type
    Run Keyword If  ${exist} == True  Select From List By Label  dossier_instruction_type  ${args_export.dossier_instruction_type}

    Input Text  ${args_export.nom_champ_debut}  ${args_export.date_debut}
    Input Text  ${args_export.nom_champ_fin}  ${args_export.date_fin}
    Select From List By Label  sortie  PDF - Version imprimable
    # Click on submit  sans valid message
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=.message .text a.bold
    Open PDF  ${OM_PDF_TITLE}

    # On vérifie la présence du contenu de la list dans le PDF de resultat
    :FOR  ${colonne}  IN  @{args_export.colonne_valeurs}
    \  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${colonne}

    ${exist} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${args_export}  content
    Run Keyword If  ${exist} == True  Page Should Contain  ${args_export.content}
    Run Keyword If  ${exist} != True  Page Should Not Contain  ${args_export.not_content}

    Close PDF

