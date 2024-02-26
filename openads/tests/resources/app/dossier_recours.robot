*** Settings ***
Documentation     Actions spécifiques aux dossiers recours.

*** Keywords ***
Depuis le contexte du dossier recours par recherche
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier recours.
    [Arguments]  ${dossier_recours}

    # On accède directement au tableau de tous les dossiers recours
    Depuis le listing  dossier_contentieux_tous_recours
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_recours}
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  ${libelle_sans_espace}
    # On valide le formulaire de recherche
    Click On Search Button
    # On accède à la visualisation du DI
    Click On Link  ${dossier_recours}
    #
    Page Title Should Contain  ${dossier_recours}

Depuis le contexte du dossier recours
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier recours.
    [Arguments]  ${dossier_recours}

    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_recours}
    # On accède directement au dossier recours
    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_contentieux_tous_recours&action=3&idx=${libelle_sans_espace}
    # On vérifie qu'on est bien sur le DI
    Page Title Should Contain  ${dossier_recours}


Depuis le contexte du dossier recours de mes recours
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier recours.
    [Arguments]  ${dossier_recours}

    # On accède directement au tableau de tous mes dossiers recours
    Depuis le listing  dossier_contentieux_mes_recours
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_recours}
    # On fait une recherche sur le libellé du DI
    Use Simple Search  Tous  ${libelle_sans_espace}
    # On accède à la visualisation du DI
    Click On Link  ${dossier_recours}
    #
    Page Title Should Contain  ${dossier_recours}


Depuis le formulaire de modification du dossier recours
    [Documentation]
    [Arguments]  ${dossier_recours}

    Depuis le contexte du dossier recours  ${dossier_recours}
    Click On Form Portlet Action  dossier_contentieux_tous_recours  modifier

Depuis l'onglet contrainte(s) du dossier recours
    [Documentation]    Permet d'accéder à l'onglet contrainte(s) dans le contexte d'un
    ...    dossier recours.
    [Arguments]  ${dossier_recours}

    #
    Depuis le contexte du dossier recours  ${dossier_recours}
    #
    On clique sur l'onglet  dossier_contrainte_contexte_ctx  Contrainte(s)

Depuis l'onglet instruction du dossier recours
    [Documentation]    Permet d'accéder à l'onglet instruction dans le contexte d'un
    ...    dossier recours.
    [Arguments]  ${dossier_recours}

    #
    Depuis le contexte du dossier recours  ${dossier_recours}
    #
    On clique sur l'onglet  instruction_contexte_ctx_re  Instruction


Depuis l'onglet des pièces du dossier recours

    [Documentation]  Permet d'accéder à l'onglet des pièces dans le contexte
    ...  d'un dossier recours.

    [Arguments]  ${dossier_recours}

    #
    Depuis le contexte du dossier recours  ${dossier_recours}
    #
    On clique sur l'onglet  document_numerise_contexte_ctx  Pièces & Documents


Depuis l'onglet des messages du dossier recours

    [Documentation]  Permet d'accéder à l'onglet des messages dans le contexte
    ...  d'un dossier recours.
    [Arguments]  ${dossier_recours}

    Depuis le contexte du dossier recours  ${dossier_recours}
    On clique sur l'onglet  dossier_message_contexte_ctx  Message(s)


Depuis l'onglet Dossiers Liés du dossier recours

    [Documentation]  Permet d'accéder à l'onglet des dossiers liés dans le contexte
    ...  d'un dossier recours.

    [Arguments]  ${dossier_recours}

    #
    Depuis le contexte du dossier recours  ${dossier_recours}
    On clique sur l'onglet  lien_dossier_dossier_contexte_ctx_re  Dossiers Liés


Ajouter une contrainte depuis l'onglet du dossier recours
    [Arguments]  ${dossier_recours}

    Depuis l'onglet contrainte(s) du dossier recours  ${dossier_recours}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-dossier_contrainte-corner-ajouter

Saisir le formulaire du dossier recours

    [Documentation]  Permet de saisir le formulaire du dossier recours.

    [Arguments]  ${instructeur}=null  ${division}=null  ${tax_secteur}=null  ${terrain_adresse_voie_numero}=null  ${terrain_adresse_voie}=null  ${terrain_adresse_lieu_dit}=null  ${terrain_adresse_localite}=null  ${terrain_adresse_code_postal}=null  ${terrain_adresse_bp}=null  ${terrain_adresse_cedex}=null  ${terrain_superficie}=null  ${numero_versement_archive}=null

    Run Keyword If  '${instructeur}' != 'null'  Select From List By Label  css=#instructeur  ${instructeur}
    Run Keyword If  '${division}' != 'null'  Select From List By Label  css=#division  ${division}
    #
    Run Keyword If  '${tax_secteur}' != 'null'  Open Fieldset    dossier_contentieux_tous_recours    simulation-des-taxes
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Run Keyword If  '${tax_secteur}' != 'null'  Select From List By Label  css=#tax_secteur  ${tax_secteur}
    #
    Open Fieldset    dossier_contentieux_tous_recours    localisation
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Run Keyword If  '${terrain_adresse_voie_numero}' != 'null'  Input Text css=#terrain_adresse_voie_numero  ${terrain_adresse_voie_numero}
    Run Keyword If  '${terrain_adresse_voie}' != 'null'  Input Text  css=#terrain_adresse_voie  ${terrain_adresse_voie}
    Run Keyword If  '${terrain_adresse_lieu_dit}' != 'null'  Input Text  css=#terrain_adresse_lieu_dit  ${terrain_adresse_lieu_dit}
    Run Keyword If  '${terrain_adresse_localite}' != 'null'  Input Text  css=#terrain_adresse_localite  ${terrain_adresse_localite}
    Run Keyword If  '${terrain_adresse_code_postal}' != 'null'  Input Text  css=#terrain_adresse_code_postal  ${terrain_adresse_code_postal}
    Run Keyword If  '${terrain_adresse_bp}' != 'null'  Input Text  css=#terrain_adresse_bp  ${terrain_adresse_bp}
    Run Keyword If  '${terrain_adresse_cedex}' != 'null'  Input Text  css=#terrain_adresse_cedex  ${terrain_adresse_cedex}
    Run Keyword If  '${terrain_superficie}' != 'null'  Input Text  css=#terrain_superficie  ${terrain_superficie}
    Run Keyword If  '${numero_versement_archive}' != 'null'  Input Text  css=#numero_versement_archive  ${numero_versement_archive}


Modifier le dossier recours

    [Documentation]  Permet de modifier le dossier recours.

    [Arguments]  ${dossier_recours}  ${instructeur}=null  ${division}=null  ${tax_secteur}=null  ${terrain_adresse_voie_numero}=null  ${terrain_adresse_voie}=null  ${terrain_adresse_lieu_dit}=null  ${terrain_adresse_localite}=null  ${terrain_adresse_code_postal}=null  ${terrain_adresse_bp}=null  ${terrain_adresse_cedex}=null  ${terrain_superficie}=null  ${numero_versement_archive}=null

    Depuis le contexte du dossier recours  ${dossier_recours}
    # On clique sur l'action modifier du portlet
    Click On Form Portlet Action    dossier_contentieux_tous_recours    modifier
    # On saisit le formulaire
    Saisir le formulaire du dossier recours  ${instructeur}  ${division}  ${tax_secteur}  ${terrain_adresse_voie_numero}  ${terrain_adresse_voie}  ${terrain_adresse_lieu_dit}  ${terrain_adresse_localite}  ${terrain_adresse_code_postal}  ${terrain_adresse_bp}  ${terrain_adresse_cedex}  ${terrain_superficie}  ${numero_versement_archive}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message affiché à l'utilisateur
    Valid Message Should Be  Vos modifications ont bien été enregistrées.


Modifier les données techniques d'un dossier recours pour le calcul des surfaces

    [Documentation]  Permet de modifier les données techniques pour le calcul
    ...  des impositions du dossier recours.

    [Arguments]  ${dossier_recours}  ${donnees_techniques_values}

    Depuis le contexte du dossier recours  ${dossier_recours}
    # On clique sur l'action données techniques du portlet
    Click On Form Portlet Action    dossier_contentieux_tous_recours    donnees_techniques    modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click On SubForm Portlet Action  donnees_techniques_contexte_ctx  modifier
    # On saisit le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Saisir les données techniques pour le calcul des surfaces  ${donnees_techniques_values}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  Vos modifications ont bien été enregistrées.

Saisir les données techniques du dossier recours

    [Documentation]  Permet de saisir les données techniques dans n'importe quel fieldset
    ...  Prend en paramètre le n° de dossier d'inscription, et la liste de données
    ...  techniques à insérer sous la forme de dictionary ex : ope_proj_desc=testset

    [Arguments]  ${dossier_recours}  ${donnees_techniques_values}


    Depuis le contexte du dossier recours  ${dossier_recours}
    # On clique sur l'action données techniques du portlet
    Click On Form Portlet Action    dossier_contentieux_tous_recours    donnees_techniques    modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click On SubForm Portlet Action  donnees_techniques  modifier
    Saisir les données techniques  ${donnees_techniques_values}


Le dossier recours doit exister

    [Documentation]    Vérifie que le dossier a bien été créé
    [Arguments]  ${dossier_recours}

    # On se rend sur le dossier recours directement par URL
    Depuis le contexte du dossier recours  ${dossier_recours}

Le dossier recours ne doit pas exister

    [Documentation]    Vérifie que le dossier a bien été créé
    [Arguments]  ${dossier_recours}

    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_recours}
    # On accède directement au tableau de tous les dossiers recours
    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_contentieux_tous_recours&action=3&idx=${libelle_sans_espace}
    # On vérifie qu'on est bien sur le DI
    Page Should Not Contain  ${dossier_recours}
