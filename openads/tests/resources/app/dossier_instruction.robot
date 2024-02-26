*** Settings ***
Documentation     Actions spécifiques aux dossiers d'instruction.

*** Keywords ***
Depuis le contexte du dossier d'instruction par recherche
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier d'instruction.
    [Arguments]  ${dossier_instruction}

    # On accède directement au tableau de tous les dossiers d'instruction
    Depuis le listing  dossier_instruction
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_instruction}
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  ${libelle_sans_espace}
    # On valide le formulaire de recherche
    Click On Search Button
    # On accède à la visualisation du DI
    Click On Link  ${dossier_instruction}
    #
    ${libelle_majuscules} =  Convert To Upper Case  ${dossier_instruction}
    Page Title Should Contain  ${libelle_majuscules}

Depuis le contexte du dossier d'instruction par la recherche avance
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier d'instruction
    ...  en utilisant la recherche avancé et en cliquant sur l'élément voulu.
    [Arguments]  ${values}  ${link_to_click}

    # On accède directement au tableau de tous les dossiers d'instruction
    Depuis le listing  dossier_instruction
    # On fait une recherche avec les paramètres fournis
    Saisir les parametres de recherche avancé du dossier d'instruction  ${values}
    # On valide le formulaire de recherche
    Click On Search Button
    # On accède à la visualisation du DI
    Click On Link  ${link_to_click}

Saisir les parametres de recherche avancé du dossier d'instruction
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier d'instruction.
    [Arguments]  ${values}

    Si "dossier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_autorisation_type_detaille" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "particulier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "parcelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "statut" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "accord_tacite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "division" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "source_depot" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "instructeur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_depot_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_depot_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_rejet_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_rejet_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_validite_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_validite_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_complet_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_complet_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_decision_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_decision_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_limite_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_limite_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_chantier_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_chantier_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_achevement_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_achevement_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_conformite_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_conformite_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "nature_travaux" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "famille_travaux" existe dans "${values}" on execute "Select From List By Label" dans le formulaire


Depuis le contexte du dossier d'instruction
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier d'instruction.
    [Arguments]  ${dossier_instruction}  ${menu}=null  ${check_breadcrumb}=true

    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_instruction}
    # On accède directement au dossier d'instruction
    Run Keyword If  '${menu}' == 'infraction'  Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_contentieux_toutes_infractions&action=3&idx=${libelle_sans_espace}
    ...  ELSE IF  '${menu}' == 'recours'  Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_contentieux_tous_recours&action=3&idx=${libelle_sans_espace}
    ...  ELSE  Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${libelle_sans_espace}
    # On vérifie qu'on est bien sur le DI
    ${libelle_majuscules} =  Convert To Upper Case  ${dossier_instruction}
    Run Keyword If  '${check_breadcrumb}' == 'true'  Page Title Should Contain  ${libelle_majuscules}


Depuis le contexte du dossier d'instruction de mes encours
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier d'instruction.
    [Arguments]  ${dossier_instruction}

    # On accède directement au tableau de tous les dossiers d'instruction
    Depuis le listing  dossier_instruction_mes_encours
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_instruction}
    # On fait une recherche sur le libellé du DI
    Use Simple Search  Tous  ${libelle_sans_espace}
    # On accède à la visualisation du DI
    Click On Link  ${dossier_instruction}
    #
    ${libelle_majuscules} =  Convert To Upper Case  ${dossier_instruction}
    Page Title Should Contain  ${libelle_majuscules}

Depuis le contexte du dossier d'instruction de tous les encours
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier d'instruction.
    [Arguments]  ${dossier_instruction}

    # On accède directement au tableau de tous les dossiers d'instruction
    Depuis le listing  dossier_instruction_tous_encours
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_instruction}
    # On fait une recherche sur le libellé du DI
    Use Simple Search  Tous  ${libelle_sans_espace}
    # On accède à la visualisation du DI
    Click On Link  ${dossier_instruction}
    #
    ${libelle_majuscules} =  Convert To Upper Case  ${dossier_instruction}
    Page Title Should Contain  ${libelle_majuscules}

Depuis le contexte du dossier d'instruction de mes clotures
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier d'instruction.
    [Arguments]  ${dossier_instruction}

    # On accède directement au tableau de tous les dossiers d'instruction
    Depuis le listing  dossier_instruction_mes_clotures
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_instruction}
    # On fait une recherche sur le libellé du DI
    Use Simple Search  Tous  ${libelle_sans_espace}
    # On accède à la visualisation du DI
    Click On Link  ${dossier_instruction}
    #
    ${libelle_majuscules} =  Convert To Upper Case  ${dossier_instruction}
    Page Title Should Contain  ${libelle_majuscules}

Depuis le contexte du dossier d'instruction de tous les cloture
    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier d'instruction.
    [Arguments]  ${dossier_instruction}

    # On accède directement au tableau de tous les dossiers d'instruction
    Depuis le listing  dossier_instruction_tous_clotures
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_instruction}
    # On fait une recherche sur le libellé du DI
    Use Simple Search  Tous  ${libelle_sans_espace}
    # On accède à la visualisation du DI
    Click On Link  ${dossier_instruction}
    #
    ${libelle_majuscules} =  Convert To Upper Case  ${dossier_instruction}
    Page Title Should Contain  ${libelle_majuscules}

Depuis le formulaire de modification du dossier d'instruction
    [Documentation]
    [Arguments]  ${dossier_instruction}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    Click On Form Portlet Action  dossier_instruction  modifier

Depuis l'onglet acteur du dossier d'instruction

    [Documentation]  Permet d'accéder à l'onglet des pièces dans le contexte
    ...  d'un dossier d'instruction.

    [Arguments]  ${dossier_instruction}

    #
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    #
    On clique sur l'onglet  lien_dossier_tiers  Acteur(s)

Depuis l'onglet consultation(s) du dossier d'instruction
    [Documentation]    Permet d'accéder à l'onglet consultation(s) dans le contexte d'un
    ...    dossier d'instruction.
    [Arguments]  ${dossier_instruction}

    #
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    #
    On clique sur l'onglet  consultation  Consultation(s)

Depuis l'onglet contrainte(s) du dossier d'instruction
    [Documentation]    Permet d'accéder à l'onglet contrainte(s) dans le contexte d'un
    ...    dossier d'instruction.
    [Arguments]  ${dossier_instruction}

    #
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    #
    On clique sur l'onglet  dossier_contrainte  Contrainte(s)

Depuis l'onglet instruction du dossier d'instruction
    [Documentation]    Permet d'accéder à l'onglet instruction dans le contexte d'un
    ...    dossier d'instruction.
    [Arguments]  ${dossier_instruction}  ${menu}=null

    #
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}  ${menu}
    #
    Run Keyword If  '${menu}' == 'infraction'  On clique sur l'onglet  instruction_contexte_ctx_inf  Instruction
    ...  ELSE IF  '${menu}' == 'recours'  On clique sur l'onglet  instruction_contexte_ctx_re  Instruction
    ...  ELSE  On clique sur l'onglet  instruction  Instruction


Depuis l'onglet des pièces du dossier d'instruction

    [Documentation]  Permet d'accéder à l'onglet des pièces dans le contexte
    ...  d'un dossier d'instruction.

    [Arguments]  ${dossier_instruction}

    #
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    #
    On clique sur l'onglet  document_numerise  Pièces & Documents


Depuis l'onglet des sous_dossiers du dossier d'instruction

    [Documentation]  Permet d'accéder à l'onglet des sous_dossier dans le contexte
    ...  d'un dossier d'instruction.
    [Arguments]  ${dossier_instruction}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    On clique sur l'onglet  sous_dossier  Sous-dossiers

Depuis l'onglet des messages du dossier d'instruction

    [Documentation]  Permet d'accéder à l'onglet des messages dans le contexte
    ...  d'un dossier d'instruction.
    [Arguments]  ${dossier_instruction}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    On clique sur l'onglet  dossier_message  Message(s)


Ajouter une consultation depuis l'onglet du dossier d'instruction
    [Arguments]  ${dossier_instruction}

    Depuis l'onglet consultation(s) du dossier d'instruction  ${dossier_instruction}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter

Ajouter un lot de consultations depuis l'onglet du dossier d'instruction
    [Arguments]  ${dossier_instruction}

    Depuis l'onglet consultation(s) du dossier d'instruction  ${dossier_instruction}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_multiple

Ajouter des contraintes depuis l'onglet du dossier d'instruction
    [Arguments]  ${dossier_instruction}  ${contraintes_ids}

    # Accède au formulaire d'ajout des contraintes du dossier
    Acceder au formulaire d'ajout des contraintes du dossier d'instruction  ${dossier_instruction}
    # Sélection des contraintes
    Selectionner les contraintes a ajouter  ${contraintes_ids}
    # Validation du formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sformulaire div.formControls input[type="submit"]
    # Vérification des messages
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte div.message.ui-state-valid p span.text  ajoutée au dossier.
    # Retour sur le listing des contraintes
    Click On Back Button In SubForm

Acceder au formulaire d'ajout des contraintes du dossier d'instruction
    [Documentation]  Ouvre le formulaire d'ajout des contraintes du dossier.
    [Arguments]  ${dossier_instruction}

    # Accède au formulaire d'ajout des contraintes du dossier
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${dossier_instruction}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  id=action-soustab-dossier_contrainte-corner-ajouter

Selectionner les contraintes a ajouter
    [Documentation]  Depuis le formulaire d'ajout des contraintes du dossier, ouvre tous les
    ...  fieldset en utilisant du javascript et coche les contraintes voulues.
    [Arguments]  ${contraintes_ids}

    # Ouvre tous les fieldsets d'ajout de contrainte
    Open All Fieldset Using Javascript  dossier_contrainte  sousform
    # Sélection des contraintes
    :FOR  ${id}  IN  @{contraintes_ids}
    \  Select Checkbox  css=#contrainte_${id}

Saisir le formulaire du dossier d'instruction

    [Documentation]  Permet de saisir le formulaire du dossier d'instruction.
    [Arguments]  ${values}  ${context}=null  ${nature_travaux}=${EMPTY}

    # Ouvre les fieldsets nécessaires
    Run Keyword If  '${context}' == 'infraction'  Open Fieldset  dossier_contentieux_toutes_infractions  localisation
    ...  ELSE IF  '${context}' == 'recours'  Open Fieldset  dossier_contentieux_tous_recours  localisation
    ...  ELSE  Open Fieldset  dossier_instruction  localisation
    Wait Until Element Is Visible  css=#terrain_adresse_voie_numero

    Si "erp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "instructeur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "instructeur_2" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "division" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "tax_secteur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "terrain_adresse_voie_numero" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_voie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_lieu_dit" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_localite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_code_postal" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_bp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_cedex" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_superficie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "parcelle_temporaire" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "date_affichage" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_depot_mairie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "geoloc_latitude" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "geoloc_longitude" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "geoloc_rayon" existe dans "${values}" on execute "Input Text" dans le formulaire
    ${is_list}=      Evaluate     isinstance($nature_travaux, list)
    Run Keyword If  ${is_list}  Select From Multiple Chosen List  nature_travaux  ${nature_travaux}


Modifier le dossier d'instruction

    [Documentation]  Permet de modifier le dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${values}  ${context}=null  ${nature_travaux}=${EMPTY}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}  ${context}
    # On clique sur l'action modifier du portlet
    Run Keyword If  '${context}' == 'infraction'  Click On Form Portlet Action  dossier_contentieux_toutes_infractions  modifier
    ...  ELSE IF  '${context}' == 'recours'  Click On Form Portlet Action  dossier_contentieux_tous_recours  modifier
    ...  ELSE  Click On Form Portlet Action  dossier_instruction  modifier
    # On saisit le formulaire
    Saisir le formulaire du dossier d'instruction  ${values}  ${context}  ${nature_travaux}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message affiché à l'utilisateur
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.


Saisir les données techniques pour le calcul des impositions

    [Documentation]  Permet de saisir le formulaire données techniques pour le
    ...  calcul des impositions.

    [Arguments]  ${values}

    # On déplie le fieldset de la taxe d'aménagement
    Open Fieldset In Subform  donnees_techniques  declaration-des-elements-necessaires-au-calcul-des-impositions
    Open Fieldset In Subform  donnees_techniques  exonerations
    # On saisit les données
    Wait Until Element Is Visible  css=#tax_surf_tot_cstr
    Si "tax_surf_tot_cstr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_surf_loc_stat" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_surf_tot" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_surf" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_surf_suppr_mod" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_log_nb1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_log_nb2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_log_nb3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_log_nb4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_log_nb_tot1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_log_nb_tot2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_log_nb_tot3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_log_nb_tot4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf_sup1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf_sup2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf_sup3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf_sup4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_log_nb1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_log_nb2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_log_nb3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_log_nb_tot1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_log_nb_tot2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_log_nb_tot3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_surf1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_surf2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_surf3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_surf_sup1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_surf_sup2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_surf_sup3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_secon_log_nb" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_tot_log_nb" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_secon_log_nb_tot" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_tot_log_nb_tot" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_secon_surf" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_tot_surf" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_secon_surf_sup" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_tot_surf_sup" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_ext_pret" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_ext_desc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_surf_tax_exist_cons" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_log_exist_nb" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_am_statio_ext" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_sup_bass_pisc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_empl_ten_carav_mobil_nb" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_empl_hll_nb" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_eol_haut_nb" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_pann_volt_sup" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_am_statio_ext_sup" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_sup_bass_pisc_sup" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_empl_ten_carav_mobil_nb_sup" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_empl_hll_nb_sup" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_eol_haut_nb_sup" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_pann_volt_sup_sup" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_trx_presc_ppr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_monu_hist" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_comm_nb" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf5" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf7" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_sup1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_sup2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_sup3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_sup4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_sup5" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_sup6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_sup7" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_dest_loc_tr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_surf_loc_stat" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf_stat1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf_stat2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf_stat3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_princ_surf_stat4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_secon_surf_stat" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_surf_stat1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_surf_stat2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_heber_surf_stat3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_tot_surf_stat" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_stat1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_stat2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_stat3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_stat4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_stat5" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_stat6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_non_habit_surf_stat7" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_su_parc_statio_expl_comm_surf" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_log_ap_trvx_nb" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_am_statio_ext_cr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_sup_bass_pisc_cr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_empl_ten_carav_mobil_nb_cr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_empl_hll_nb_cr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_eol_haut_nb_cr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_pann_volt_sup_cr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_surf_loc_arch" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_surf_pisc_arch" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_am_statio_ext_arch" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_empl_ten_carav_mobil_nb_arch" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_empl_hll_nb_arch" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_eol_haut_nb_arch" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_terrassement_arch" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_desc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "mtn_exo_ta_part_commu" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "mtn_exo_ta_part_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "mtn_exo_ta_part_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "mtn_exo_rap" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1gu1_f1gu2_f1gu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1lu1_f1lu2_f1lu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1zu1_f1zu2_f1zu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1pu1_f1pu2_f1pu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1gt4_f1gt5_f1gt6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1lt4_f1lt5_f1lt6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1zt4_f1zt5_f1zt6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1pt4_f1pt5_f1pt6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1xu1_f1xu2_f1xu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1xt4_f1xt5_f1xt6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1hu1_f1hu2_f1hu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1mu1_f1mu2_f1mu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1qu1_f1qu2_f1qu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1ht4_f1ht5_f1ht6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1mt4_f1mt5_f1mt6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f1qt4_f1qt5_f1qt6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2cu1_f2cu2_f2cu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2bu1_f2bu2_f2bu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2su1_f2su2_f2su3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2hu1_f2hu2_f2hu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2eu1_f2eu2_f2eu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2qu1_f2qu2_f2qu3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2ct4_f2ct5_f2ct6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2bt4_f2bt5_f2bt6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2st4_f2st5_f2st6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2ht4_f2ht5_f2ht6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2et4_f2et5_f2et6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "f2qt4_f2qt5_f2qt6" existe dans "${values}" on execute "Input Text" dans le formulaire


Modifier les données techniques pour le calcul des impositions

    [Documentation]  Permet de modifier les données techniques pour le calcul
    ...  des impositions du dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${values}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    # On clique sur l'action données techniques du portlet
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    # On saisit le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Saisir les données techniques pour le calcul des impositions  ${values}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Vos modifications ont bien été enregistrées.


Depuis le contexte du rapport d'instruction

    [Documentation]  Depuis la fiche du rapport d'instruction.

    [Arguments]  ${dossier_instruction}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    # On clique sur l'action du rapport d'instruction
    Click On Form Portlet Action  dossier_instruction  rapport_instruction  modale


Modifier le rapport d'instruction
    [Documentation]  Permet de modifier le rapport d'instruction.
    [Arguments]  ${di}  ${values}

    Depuis le contexte du rapport d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Saisir le rapport d'instruction  ${values}
    Click On Submit Button In Subform
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  Vos modifications ont bien été enregistrées.


Saisir le rapport d'instruction
    [Documentation]  Remplit le formulaire du rapport d'instruction.
    [Arguments]  ${values}

    Si "analyse_reglementaire_om_html" existe dans "${values}" on execute "Input HTML" dans "rapport_instruction"
    Si "description_projet_om_html" existe dans "${values}" on execute "Input HTML" dans "rapport_instruction"
    Si "proposition_decision" existe dans "${values}" on execute "Input Text" dans "rapport_instruction"


Ajouter le rapport d'instruction
    [Documentation]  Permet d'ajouter le rapport d'instruction du DI.
    [Arguments]  ${di}  ${values}

    Depuis le contexte du rapport d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Saisir le rapport d'instruction  ${values}
    Click On Submit Button In Subform
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform


Finaliser le rapport d'instruction
    [Documentation]  Permet de finaliser le rapport d'instruction du DI.
    [Arguments]  ${di}

    Depuis le contexte du rapport d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  La finalisation du document s'est effectuée avec succès.
    Click On Back Button In Subform


Ajouter et finaliser le rapport d'instruction
    [Documentation]  Mot-clef raccourcis permettant d'ajouter et de finaliser le
    ...  rapport d'instruction du DI.
    [Arguments]  ${di}  ${values}

    Ajouter le rapport d'instruction  ${di}  ${values}
    Finaliser le rapport d'instruction  ${di}


Modifier les données techniques pour le calcul des surfaces

    [Documentation]  Permet de modifier les données techniques pour le calcul
    ...  des impositions du dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${donnees_techniques_values}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    # On clique sur l'action données techniques du portlet
    Click On Form Portlet Action    dossier_instruction    donnees_techniques    modale
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Portlet Action Should Be In SubForm  donnees_techniques  modifier
    # On clique sur l'action modifier
    Click On SubForm Portlet Action  donnees_techniques  modifier
    # On saisit le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Saisir les données techniques pour le calcul des surfaces  ${donnees_techniques_values}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  Vos modifications ont bien été enregistrées.


Saisir les données techniques pour le calcul des surfaces

    [Documentation]

    [Arguments]  ${donnees_techniques_values}

    # On déplie le fieldset "Construire"
    Open Fieldset In Subform  donnees_techniques  construire
    # On déplie le fieldset "Destinations et surfaces des constructions"
    Open Fieldset In Subform  donnees_techniques  destinations-et-surfaces-des-constructions
    #
    Si "su_avt_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_avt_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_avt_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_avt_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_avt_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_avt_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_avt_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_avt_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_avt_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_cstr_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_cstr_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_cstr_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_cstr_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_cstr_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_cstr_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_cstr_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_cstr_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_cstr_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_chge_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_chge_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_chge_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_chge_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_chge_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_chge_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_chge_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_chge_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_chge_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_demo_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_demo_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_demo_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_demo_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_demo_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_demo_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_demo_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_demo_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_demo_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_sup_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_sup_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_sup_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_sup_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_sup_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_sup_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_sup_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_sup_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su_sup_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"

    # Tableau des surface (version 2)
    Si "su2_avt_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon10" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon11" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon12" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon13" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon14" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon15" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon16" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon17" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon18" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon19" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon20" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon21" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_avt_shon22" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon10" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon11" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon12" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon13" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon14" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon15" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon16" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon17" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon18" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon19" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon20" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon21" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_cstr_shon22" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon10" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon11" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon12" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon13" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon14" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon15" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon16" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon17" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon18" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon19" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon20" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon21" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_chge_shon22" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon10" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon11" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon12" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon13" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon14" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon15" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon16" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon17" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon18" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon19" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon20" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon21" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_demo_shon22" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon1" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon2" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon3" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon4" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon5" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon6" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon7" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon8" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon9" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon10" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon11" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon12" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon13" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon14" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon15" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon16" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon17" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon18" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon19" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon20" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon21" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Si "su2_sup_shon22" existe dans "${donnees_techniques_values}" on execute "Input Text" dans "donnees_techniques"
    Sleep  1

Saisir les données techniques du DI

    [Documentation]  Permet de saisir les données techniques dans n'importe quel fieldset
    ...  Prend en paramètre le n° de dossier d'inscription, et la liste de données
    ...  techniques à insérer sous la forme de dictionary ex : ope_proj_desc=testset

    [Arguments]  ${dossier_instruction}  ${donnees_techniques_values}  ${menu}=null  ${class_suffix}=${EMPTY}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}  ${menu}

    # Défini le type de dossier
    ${dossier} =  Set Variable If  '${menu}' == 'infraction'  dossier_contentieux_toutes_infractions
    ...                            '${menu}' == 'recours'     dossier_contentieux_tous_recours
    ...                                                       dossier_instruction

    # On clique sur l'action données techniques du portlet confirmée par une modale
    Click On Form Portlet Action  ${dossier}  donnees_techniques  modale

    # Défini le contexte de l'action
    ${contexte} =  Set Variable If  '${menu}' == 'infraction'  donnees_techniques_contexte_ctx
    ...                             '${menu}' == 'recours'     donnees_techniques_contexte_ctx
    ...                                                        donnees_techniques

    # Attend l'apparition de l'action dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#action-sousform-${contexte}-modifier

    # On clique sur l'action modifier
    Click On SubForm Portlet Action  ${contexte}  modifier

    Saisir les données techniques  ${donnees_techniques_values}  ${class_suffix}

Saisir les données techniques

    [Arguments]  ${donnees_techniques_values}  ${class_suffix}=${EMPTY}

    # Déplie tous les fieldsets présents
    Open All Fieldset Using Javascript  donnees_techniques${class_suffix}  sousform

    # On convertit le dictionnaire en liste
    ${items}=    Get Dictionary Items    ${donnees_techniques_values}
    # Pour chaque couple champ-valeur dans la liste
    :FOR    ${field}    ${value}    IN    @{items}
    # On saisit la valeur dans le champ
    \   Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=div#sousform-donnees_techniques${class_suffix} #${field}
    \  Run Keyword If  "${value}" == "t"  Select Checkbox  css=div#sousform-donnees_techniques${class_suffix} #${field}  ELSE IF  "${value}" == "f"  Unselect Checkbox  css=div#sousform-donnees_techniques${class_suffix} #${field}  ELSE  Input Text  css=div#sousform-donnees_techniques${class_suffix} #${field}  ${value}

    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  Vos modifications ont bien été enregistrées.

Depuis l'onglet Dossiers Liés du dossier d'instruction

    [Documentation]  Permet d'accéder à l'onglet des dossiers liés dans le contexte
    ...  d'un dossier d'instruction.

    [Arguments]  ${dossier_instruction}

    #
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    On clique sur l'onglet  lien_dossier_dossier  Dossiers Liés


Le dossier d'instruction doit exister

    [Documentation]  Vérifie que le dossier a bien été créé.
    [Arguments]  ${dossier_instruction}

    # On se rend sur le dossier d'instruction directement par URL
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}

Le dossier d'instruction ne doit pas exister

    [Documentation]  Vérifie que le dossier n'a pas été crée.
    [Arguments]  ${dossier_instruction}

    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_instruction}
    # On accède directement à la page des DI
    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${libelle_sans_espace}
    # On vérifie qu'on voit bien la page d'erreur de dossier non trouvé.
    # Qui est identique à celle d'accès réfusé.
    Error Message Should Be  Droits insuffisants. Vous n'avez pas suffisamment de droits pour acceder à cette page.
    Page Should Not Contain  ${dossier_instruction}


Supprimer le dossier d'instruction
    [Documentation]  Supprime le dossier d'instruction.
    [Arguments]  ${dossier_instruction}  ${context}=null

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}  ${context}
    # On clique sur l'action supprimer du portlet
    Run Keyword If  '${context}' == 'infraction'  Click On Form Portlet Action  dossier_contentieux_toutes_infractions  supprimer
    ...  ELSE IF  '${context}' == 'recours'  Click On Form Portlet Action  dossier_contentieux_tous_recours  supprimer
    ...  ELSE  Click On Form Portlet Action  dossier_instruction  supprimer
    # On valide le formulaire
    Click On Submit Button Until Message  La suppression a été correctement effectuée.


Ajouter la liaison entre le dossier d'instruction source et le dossier d'instruction cible
    [Documentation]  Ajoute une liaison vers entre un dossier d'instruction
    ...  source et un dossier d'instruction cible.
    [Arguments]  ${di_source}  ${di_cible}

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${di_source}
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${di_cible}
    Click On Submit Button In SubForm
    ${di_cible_aff} =  Sans espace  ${di_cible}
    Valid Message Should Contain In Subform  Le dossier ${di_cible_aff} a été lié.


Normaliser l'adresse du terrain avec le premier résultat
    [Documentation]  Normalise l'adresse du terrain avec le premier résultat
    ...  retourné par l'API adresse.
    [Arguments]  ${di}

    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  normalize_address  modale
    Wait Until Element Is Visible  css=ul.ui-autocomplete
    ${normalized_address} =  Get Text  css=ul.ui-autocomplete li.ui-menu-item a
    Click Element Until No More Element
    ...  css=ul.ui-autocomplete li.ui-menu-item a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#sousform-normalize_address input#address  ${normalized_address}
    Click Element Until No More Element
    ...  css=#sousform-normalize_address form[name="f2_normalize_address"] div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Contain  css=#terrain  ${normalized_address}


Obtenir l'instructeur du dossier d'instruction
    [Documentation]  Retourne le nom de l'instructeur associé au DI.
    [Arguments]  ${di}  ${menu}=null

    Depuis le contexte du dossier d'instruction  ${di}  ${menu}
    ${instr} =  Get Text  instructeur

    [Return]  ${instr}

Obtenir l'instructeur secondaire du dossier d'instruction
    [Documentation]  Retourne le nom de l'instructeur associé au DI.
    [Arguments]  ${di}  ${menu}=null

    Depuis le contexte du dossier d'instruction  ${di}  ${menu}
    ${instr} =  Get Text  instructeur_2

    [Return]  ${instr}

Ajouter le sous-dossier au dossier
    [Documentation]  Depuis le contexte du dossier voulu et clique sur le
    ...  bouton d'ajout du listing du sous-dossier ayant le libellé passé en paramètre.
    [Arguments]  ${sous_dossier}

    On clique sur l'onglet  sous_dossier  Sous-dossiers
    Click On Link  css=#sousform-sous_dossier_${sous_dossier} a#action-tab-sous_dossier-corner-ajouter
