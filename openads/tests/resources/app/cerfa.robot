*** Settings ***
Documentation    CRUD de la table cerfa

*** Keywords ***

Depuis le contexte cerfa
    [Documentation]  Accède au formulaire
    [Arguments]  ${cerfa}

    # On accède au tableau
    Depuis le listing  cerfa
    # On recherche l'enregistrement
    Use Simple Search  cerfa  ${cerfa}
    # On clique sur le résultat
    Click On Link  ${cerfa}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter cerfa
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  cerfa
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir cerfa  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${cerfa} =  Get Text  css=div.fieldsetContent #cerfa
    # On le retourne
    [Return]  ${cerfa}

Modifier cerfa
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${cerfa}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte cerfa  ${cerfa}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  cerfa  modifier
    # On saisit des valeurs
    Saisir cerfa  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer cerfa
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${cerfa}

    # On accède à l'enregistrement
    Depuis le contexte cerfa  ${cerfa}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  cerfa  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir cerfa
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    # On ouvre tous les fieldsets
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#fieldset-form-cerfa-terrain legend
    # Pour une raison inconnu, ce fieldset nécessite deux clics pour s'ouvrir
    # On vérifie tout de même qu'il ne soit pas ouvert un premier clic avant
    ${present}=  Run Keyword And Return Status    Element Should Be Visible   id=terr_juri_titul
    Run Keyword If    ${present} == False    Click Element  css=#fieldset-form-cerfa-terrain legend
    Open All Fieldset Using Javascript  cerfa
    
    #
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "am_lotiss" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_autre_div" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_camping" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_caravane" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_carav_duree" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_statio" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_statio_cont" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_affou_exhau" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_affou_exhau_sup" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_affou_prof" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_exhau_haut" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_abat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_prot_plu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_prot_muni" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_mobil_voyage" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_aire_voyage" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_rememb_afu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_parc_resid_loi" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_sport_moto" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_sport_attrac" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_sport_golf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_mob_art" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_modif_voie_esp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_plant_voie_esp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_chem_ouv_esp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_agri_peche" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_crea_voie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_modif_voie_exist" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_crea_esp_sauv" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_crea_esp_class" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_projet_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_terr_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_tranche_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_max_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_max_shon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_cstr_cos" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_cstr_plan" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_cstr_vente" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_fin_diff" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_consign" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_gar_achev" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_vente_ant" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_empl_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_tente_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_carav_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_mobil_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_pers_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_empl_hll_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_hll_shon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_periode_exploit" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_exist_agrand" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_exist_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_exist_num" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_exist_nb_avant" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_exist_nb_apres" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_bois" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_parc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_align" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_ess" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_age" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_dens" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_qual" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_trait" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_coupe_autr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_archi_recours" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_cstr_nouv" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_cstr_exist" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_piscine" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_cloture" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_elec_tension" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_div_terr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_projet_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_anx_pisc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_anx_gara" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_anx_veran" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_anx_abri" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_anx_autr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_anx_autr_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_tot_log_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_tot_ind_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_tot_coll_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_mais_piece_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_mais_niv_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_lls_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_aa_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_lls" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_aa" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_ptz" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_autr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_ptz_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_autr_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_autr_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_mais_contrat_ind" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_uti_pers" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_uti_vente" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_uti_loc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_uti_princ" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_uti_secon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_resid_agees" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_resid_etud" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_resid_tourism" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_resid_hot_soc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_resid_soc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_resid_hand" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_resid_autr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_resid_autr_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_foyer_chamb_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_log_1p_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_log_2p_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_log_3p_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_log_4p_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_log_5p_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_log_6p_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_bat_niv_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_trx_exten" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_trx_surelev" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_trx_nivsup" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_demont_periode" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_sp_transport" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_sp_enseign" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_sp_act_soc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_sp_ouvr_spe" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_sp_sante" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_sp_culture" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_avt_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_apr_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_adr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_place_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_tot_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_tot_shob" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_comm_cin_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tab_surface" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dm_constr_dates" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dm_total" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dm_partiel" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dm_projet_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dm_tot_log_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_tot" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_suppr_mod" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tab_tax_su_princ" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tab_tax_su_heber" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tab_tax_su_secon" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tab_tax_su_tot" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_ext_pret" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_ext_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_tax_exist_cons" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_log_exist_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_trx_presc_ppr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_monu_hist" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_comm_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tab_tax_su_non_habit_surf" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tab_tax_am" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "vsd_surf_planch_smd" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "vsd_unit_fonc_sup" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "vsd_unit_fonc_constr_sup" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "vsd_val_terr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "vsd_const_sxist_non_dem_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "vsd_rescr_fisc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "pld_val_terr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "pld_const_exist_dem" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "pld_const_exist_dem_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "code_cnil" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_juri_titul" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_juri_lot" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_juri_zac" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_juri_afu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_juri_pup" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_juri_oin" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_juri_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_div_surf_etab" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_div_surf_av_div" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_tot_trav" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_tranche_trav" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_tranche_trav_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_nb_log" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_nb_log_indiv" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_nb_log_coll" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_nb_log_lls" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_nb_log_aa" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_nb_log_ptz" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "doc_nb_log_autre" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_date_chgmt_dest" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_tot_trav" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_tranche_trav" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_tranche_trav_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_nb_log" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_nb_log_indiv" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_nb_log_coll" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_nb_log_lls" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_nb_log_aa" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_nb_log_ptz" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "daact_nb_log_autre" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_div_mun" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_perf_energ" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "architecte" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_avt_shob" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_apr_shob" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_avt_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_statio_apr_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_trx_amgt" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_modif_aspect" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_modif_struct" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_ouvr_elec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_ouvr_infra" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_trx_imm" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_cstr_shob" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_voyage_deb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_voyage_fin" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_modif_amgt" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_lot_max_shob" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mod_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tr_total" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tr_partiel" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tr_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avap_co_elt_pro" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avap_nouv_haut_surf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avap_co_clot" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avap_aut_coup_aba_arb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avap_ouv_infra" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avap_aut_inst_mob" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avap_aut_plant" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avap_aut_auv_elec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_dest_loc_tr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ope_proj_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_tot_cstr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_loc_stat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_log_ap_trvx_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_am_statio_ext_cr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_sup_bass_pisc_cr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_empl_ten_carav_mobil_nb_cr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_empl_hll_nb_cr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_eol_haut_nb_cr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_pann_volt_sup_cr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_loc_arch" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_pisc_arch" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_am_statio_ext_arch" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tab_tax_su_parc_statio_expl_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_empl_ten_carav_mobil_nb_arch" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_empl_hll_nb_arch" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_eol_haut_nb_arch" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ope_proj_div_co" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ope_proj_div_contr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_cstr_neuve" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_trvx_acc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_extension" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_rehab" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_trvx_am" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_vol_nouv_exist" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tab_erp_eff" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "erp_class_cat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_class_type" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_abr_jard_pig_colom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_su_non_habit_abr_jard_pig_colom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_imm_non_bati" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_imm_bati_terr_propr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_imm_bati_terr_autr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_imm_bati_terr_autr_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_bat_copro" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_bat_copro_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_lot_numero" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_lot_bat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_lot_etage" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_lot_quote_part" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_us_hab" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_us_pro" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_us_mixte" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_us_comm" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_us_agr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_us_autre" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_us_autre_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_prop" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_loc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sans_occ" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_autre" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_autre_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_prix_vente" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_prix_vente_mob" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_prix_vente_cheptel" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_prix_vente_recol" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_prix_vente_autre" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_commi" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_commi_ttc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_commi_ht" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_acquereur_nom_prenom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_acquereur_adr_num_voie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_acquereur_adr_ext" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_acquereur_adr_type_voie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_acquereur_adr_nom_voie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_acquereur_adr_lieu_dit_bp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_acquereur_adr_cp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_acquereur_adr_localite" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_observation" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tab_surface2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dia_occ_sol_su_terre" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_pres" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_verger" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_vigne" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_bois" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_lande" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_carriere" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_eau_cadastree" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_jardin" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_terr_batir" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_terr_agr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_occ_sol_su_sol" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_bati_vend_tot" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_bati_vend_tot_txt" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_su_co_sol" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_su_util_hab" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_nb_niv" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_nb_appart" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_nb_autre_loc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_vente_lot_volume" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_vente_lot_volume_txt" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_lot_nat_su" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_lot_bat_achv_plus_10" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_lot_bat_achv_moins_10" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_lot_regl_copro_publ_hypo_plus_10" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_lot_regl_copro_publ_hypo_moins_10" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_indivi_quote_part" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_design_societe" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_design_droit" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_droit_soc_nat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_droit_soc_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_droit_soc_num_part" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_droit_reel_perso_grevant_bien_oui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_droit_reel_perso_grevant_bien_non" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_droit_reel_perso_nat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_droit_reel_perso_viag" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_adr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_sign_act_auth" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_terme" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_terme_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_bene_acquereur" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_bene_vendeur" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_paie_nat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_design_contr_alien" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_eval_contr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_rente_viag" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_mnt_an" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_mnt_compt" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_bene_rente" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_droit_usa_hab" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_droit_usa_hab_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_eval_usa_usufruit" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_vente_nue_prop" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_vente_nue_prop_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_echange" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_design_bien_recus_ech" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_mnt_soulte" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_prop_contre_echan" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_apport_societe" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_bene" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_esti_bien" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_cess_terr_loc_co" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_esti_terr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_esti_loc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_esti_imm_loca" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_adju_vol" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_adju_obl" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_adju_fin_indivi" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_adju_date_lieu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_mnt_mise_prix" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_prop_titu_prix_indique" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_prop_recherche_acqu_prix_indique" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_acquereur_prof" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_indic_compl_ope" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_vente_adju" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_terr_res_demon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "am_air_terr_res_mob" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_objet_recours" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_moyen_souleve" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_moyen_retenu_juge" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_reference_sagace" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_nature_travaux_infra_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "ctx_synthese_nti" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_article_non_resp_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "ctx_synthese_anr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_reference_parquet" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_element_taxation" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_infraction" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_regularisable" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_reference_courrier" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_date_audience" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_date_ajournement" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_facul_1" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_facul_2" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_facul_3" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_facul_4" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_facul_5" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_facul_6" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_facul_7" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_facul_8" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_facul_9" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_ta_1" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_ta_2" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_ta_3" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_ta_4" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_ta_5" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_ta_6" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_ta_7" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_ta_8" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_ta_9" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_rap_1" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_rap_2" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_rap_3" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_rap_4" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_rap_5" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_rap_6" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_rap_7" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "exo_rap_8" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mtn_exo_ta_part_commu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mtn_exo_ta_part_depart" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mtn_exo_ta_part_reg" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mtn_exo_rap" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_type" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_desc_actv_ex" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_desc_ca" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_desc_aut_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_desig_comm_arti" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_desig_loc_hab" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_desig_loc_ann" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_desig_loc_ann_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_bail_comm_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_bail_comm_loyer" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_actv_acqu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_nb_sala_di" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_nb_sala_dd" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_nb_sala_tc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_nb_sala_tp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_vente_am" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_adj" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_prix" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_adj_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_adj_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_comp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_terme" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_terme_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_nat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_nat_desig_alien" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_nat_desig_alien_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_nat_eval" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_nat_eval_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_aut" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_moda_cess_paie_aut_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_ss_signe_demande_acqu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_ss_signe_recher_trouv_acqu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_notif_adr_prop" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_notif_adr_manda" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dpc_obs" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_peri_site_patri_remar" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_abo_monu_hist" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_inst_ouvr_trav_act_code_envir" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_trav_auto_env" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_derog_esp_prot" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "ctx_reference_dsj" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_piscine" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_lls" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_aa" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_ptz" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_fin_autr" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_ss_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_ss_lieu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "enga_decla_lieu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "enga_decla_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_archi_attest_honneur" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_bat_niv_dessous_nb" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_install_classe" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_derog_innov" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_avis_abf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_tot_demo" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_surf_tax_demo" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_terrassement_arch" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_adresse_future_numero" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_adresse_future_voie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_adresse_future_lieudit" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_adresse_future_localite" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_adresse_future_cp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_adresse_future_bp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_adresse_future_cedex" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_adresse_future_pays" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_adresse_future_division" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_bat_projete" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_bat_existant" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_bat_nature" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terr_juri_titul_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_autre_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_trx_autre" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_autre" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_modif_facades" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_trvx_adap" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_trvx_adap_numero" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_trvx_adap_valid" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_prod_dangereux" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_trav_supp_dessus" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "co_trav_supp_dessous" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "tax_su_habit_abr_jard_pig_colom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "enga_decla_donnees_nomi_comm" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "x1l_legislation" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "x1p_precisions" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "x1u_raccordement" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "x2m_inscritmh" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1na1_numero" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1va1_voie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1wa1_lieudit" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1la1_localite" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1pa1_codepostal" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1na2_numero" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1va2_voie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1wa2_lieudit" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1la2_localite" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "s1pa2_codepostal" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "e3c_certification" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "e3a_competence" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "a4d_description" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "m2b_abf" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "m2j_pn" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "m2r_cdac" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "m2r_cnac" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u3a_voirieoui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u3f_voirienon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u3c_eauoui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u3h_eaunon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u3g_assainissementoui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u3n_assainissementnon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u3m_electriciteoui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u3b_electricitenon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u3t_observations" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1a_voirieoui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1v_voirienon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1q_voirieconcessionnaire" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1b_voirieavant" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1j_eauoui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1t_eaunon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1e_eauconcessionnaire" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1k_eauavant" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1s_assainissementoui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1d_assainissementnon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1l_assainissementconcessionnaire" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1r_assainissementavant" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1c_electriciteoui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1u_electricitenon" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1m_electriciteconcessionnaire" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u1f_electriciteavant" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "u2a_observations" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "f1ts4_surftaxestation" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "f1ut1_surfcree" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "f9d_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "f9n_nom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_droit_reel_perso_grevant_bien_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_paie_nat_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_rente_viag_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_echange_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_apport_societe_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_cess_terr_loc_co_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_esti_imm_loca_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_adju_obl_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_adju_fin_indivi_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_cadre_titul_droit_prempt" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mairie_prix_moyen" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_propri_indivi" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_situa_bien_plan_cadas_oui" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_situa_bien_plan_cadas_non" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_notif_dec_titul_adr_prop" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_notif_dec_titul_adr_prop_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_notif_dec_titul_adr_manda" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_notif_dec_titul_adr_manda_desc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_prix_vente_num" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_mnt_compt_num" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_mod_cess_mnt_soulte_num" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_comp_prix_vente" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_comp_surface" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_comp_total_frais" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_comp_mtn_total" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_comp_valeur_m2" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_esti_prix_france_dom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_prop_collectivite" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_denomination" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_raison_sociale" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_siret" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_categorie_juridique" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_representant_nom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_representant_prenom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_adresse_numero" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_adresse_voie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_adresse_complement" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_adresse_lieu_dit" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_adresse_localite" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_adresse_code_postal" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_adresse_bp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_adresse_cedex" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_adresse_pays" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_telephone_fixe" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_telephone_mobile" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_telephone_mobile_indicatif" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_courriel" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_delegataire_fax" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_entree_jouissance_type" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_entree_jouissance_date" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_entree_jouissance_date_effet" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_entree_jouissance_com" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_remise_bien_date_effet" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "dia_remise_bien_com" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "c2zp1_crete" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "c2zr1_destination" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_design_appel_denom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_design_type_protect" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_design_elem_prot" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_design_ref_merimee_palissy" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_design_nature_prop" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_loc_denom" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_pres_intitule" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_1" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_2" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_3" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_4" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_5" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_6" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_7" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_8" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_9" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_10" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_11" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_12" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mh_trav_cat_12_prec" existe dans "${values}" on execute "Set Checkbox" dans le formulaire