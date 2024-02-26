<?php
//$Id$ 
//gen openMairie le 29/08/2023 16:10

require_once "../obj/om_dbform.class.php";

class donnees_techniques_gen extends om_dbform {

    protected $_absolute_class_name = "donnees_techniques";

    var $table = "donnees_techniques";
    var $clePrimaire = "donnees_techniques";
    var $typeCle = "N";
    var $required_field = array(
        "cerfa",
        "donnees_techniques"
    );
    var $unique_key = array(
      "dossier_autorisation",
      "dossier_instruction",
      "lot",
    );
    var $foreign_keys_extended = array(
        "architecte" => array("architecte", ),
        "objet_recours" => array("objet_recours", ),
        "dossier_autorisation" => array("dossier_autorisation", ),
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
        "lot" => array("lot", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("dossier_instruction");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "donnees_techniques",
            "dossier_instruction",
            "lot",
            "am_lotiss",
            "am_autre_div",
            "am_camping",
            "am_caravane",
            "am_carav_duree",
            "am_statio",
            "am_statio_cont",
            "am_affou_exhau",
            "am_affou_exhau_sup",
            "am_affou_prof",
            "am_exhau_haut",
            "am_coupe_abat",
            "am_prot_plu",
            "am_prot_muni",
            "am_mobil_voyage",
            "am_aire_voyage",
            "am_rememb_afu",
            "am_parc_resid_loi",
            "am_sport_moto",
            "am_sport_attrac",
            "am_sport_golf",
            "am_mob_art",
            "am_modif_voie_esp",
            "am_plant_voie_esp",
            "am_chem_ouv_esp",
            "am_agri_peche",
            "am_crea_voie",
            "am_modif_voie_exist",
            "am_crea_esp_sauv",
            "am_crea_esp_class",
            "am_projet_desc",
            "am_terr_surf",
            "am_tranche_desc",
            "am_lot_max_nb",
            "am_lot_max_shon",
            "am_lot_cstr_cos",
            "am_lot_cstr_plan",
            "am_lot_cstr_vente",
            "am_lot_fin_diff",
            "am_lot_consign",
            "am_lot_gar_achev",
            "am_lot_vente_ant",
            "am_empl_nb",
            "am_tente_nb",
            "am_carav_nb",
            "am_mobil_nb",
            "am_pers_nb",
            "am_empl_hll_nb",
            "am_hll_shon",
            "am_periode_exploit",
            "am_exist_agrand",
            "am_exist_date",
            "am_exist_num",
            "am_exist_nb_avant",
            "am_exist_nb_apres",
            "am_coupe_bois",
            "am_coupe_parc",
            "am_coupe_align",
            "am_coupe_ess",
            "am_coupe_age",
            "am_coupe_dens",
            "am_coupe_qual",
            "am_coupe_trait",
            "am_coupe_autr",
            "co_archi_recours",
            "co_cstr_nouv",
            "co_cstr_exist",
            "co_cloture",
            "co_elec_tension",
            "co_div_terr",
            "co_projet_desc",
            "co_anx_pisc",
            "co_anx_gara",
            "co_anx_veran",
            "co_anx_abri",
            "co_anx_autr",
            "co_anx_autr_desc",
            "co_tot_log_nb",
            "co_tot_ind_nb",
            "co_tot_coll_nb",
            "co_mais_piece_nb",
            "co_mais_niv_nb",
            "co_fin_lls_nb",
            "co_fin_aa_nb",
            "co_fin_ptz_nb",
            "co_fin_autr_nb",
            "co_fin_autr_desc",
            "co_mais_contrat_ind",
            "co_uti_pers",
            "co_uti_vente",
            "co_uti_loc",
            "co_uti_princ",
            "co_uti_secon",
            "co_resid_agees",
            "co_resid_etud",
            "co_resid_tourism",
            "co_resid_hot_soc",
            "co_resid_soc",
            "co_resid_hand",
            "co_resid_autr",
            "co_resid_autr_desc",
            "co_foyer_chamb_nb",
            "co_log_1p_nb",
            "co_log_2p_nb",
            "co_log_3p_nb",
            "co_log_4p_nb",
            "co_log_5p_nb",
            "co_log_6p_nb",
            "co_bat_niv_nb",
            "co_trx_exten",
            "co_trx_surelev",
            "co_trx_nivsup",
            "co_demont_periode",
            "co_sp_transport",
            "co_sp_enseign",
            "co_sp_act_soc",
            "co_sp_ouvr_spe",
            "co_sp_sante",
            "co_sp_culture",
            "co_statio_avt_nb",
            "co_statio_apr_nb",
            "co_statio_adr",
            "co_statio_place_nb",
            "co_statio_tot_surf",
            "co_statio_tot_shob",
            "co_statio_comm_cin_surf",
            "su_avt_shon1",
            "su_avt_shon2",
            "su_avt_shon3",
            "su_avt_shon4",
            "su_avt_shon5",
            "su_avt_shon6",
            "su_avt_shon7",
            "su_avt_shon8",
            "su_avt_shon9",
            "su_cstr_shon1",
            "su_cstr_shon2",
            "su_cstr_shon3",
            "su_cstr_shon4",
            "su_cstr_shon5",
            "su_cstr_shon6",
            "su_cstr_shon7",
            "su_cstr_shon8",
            "su_cstr_shon9",
            "su_trsf_shon1",
            "su_trsf_shon2",
            "su_trsf_shon3",
            "su_trsf_shon4",
            "su_trsf_shon5",
            "su_trsf_shon6",
            "su_trsf_shon7",
            "su_trsf_shon8",
            "su_trsf_shon9",
            "su_chge_shon1",
            "su_chge_shon2",
            "su_chge_shon3",
            "su_chge_shon4",
            "su_chge_shon5",
            "su_chge_shon6",
            "su_chge_shon7",
            "su_chge_shon8",
            "su_chge_shon9",
            "su_demo_shon1",
            "su_demo_shon2",
            "su_demo_shon3",
            "su_demo_shon4",
            "su_demo_shon5",
            "su_demo_shon6",
            "su_demo_shon7",
            "su_demo_shon8",
            "su_demo_shon9",
            "su_sup_shon1",
            "su_sup_shon2",
            "su_sup_shon3",
            "su_sup_shon4",
            "su_sup_shon5",
            "su_sup_shon6",
            "su_sup_shon7",
            "su_sup_shon8",
            "su_sup_shon9",
            "su_tot_shon1",
            "su_tot_shon2",
            "su_tot_shon3",
            "su_tot_shon4",
            "su_tot_shon5",
            "su_tot_shon6",
            "su_tot_shon7",
            "su_tot_shon8",
            "su_tot_shon9",
            "su_avt_shon_tot",
            "su_cstr_shon_tot",
            "su_trsf_shon_tot",
            "su_chge_shon_tot",
            "su_demo_shon_tot",
            "su_sup_shon_tot",
            "su_tot_shon_tot",
            "dm_constr_dates",
            "dm_total",
            "dm_partiel",
            "dm_projet_desc",
            "dm_tot_log_nb",
            "tax_surf_tot",
            "tax_surf",
            "tax_surf_suppr_mod",
            "tax_su_princ_log_nb1",
            "tax_su_princ_log_nb2",
            "tax_su_princ_log_nb3",
            "tax_su_princ_log_nb4",
            "tax_su_princ_log_nb_tot1",
            "tax_su_princ_log_nb_tot2",
            "tax_su_princ_log_nb_tot3",
            "tax_su_princ_log_nb_tot4",
            "tax_su_princ_surf1",
            "tax_su_princ_surf2",
            "tax_su_princ_surf3",
            "tax_su_princ_surf4",
            "tax_su_princ_surf_sup1",
            "tax_su_princ_surf_sup2",
            "tax_su_princ_surf_sup3",
            "tax_su_princ_surf_sup4",
            "tax_su_heber_log_nb1",
            "tax_su_heber_log_nb2",
            "tax_su_heber_log_nb3",
            "tax_su_heber_log_nb_tot1",
            "tax_su_heber_log_nb_tot2",
            "tax_su_heber_log_nb_tot3",
            "tax_su_heber_surf1",
            "tax_su_heber_surf2",
            "tax_su_heber_surf3",
            "tax_su_heber_surf_sup1",
            "tax_su_heber_surf_sup2",
            "tax_su_heber_surf_sup3",
            "tax_su_secon_log_nb",
            "tax_su_tot_log_nb",
            "tax_su_secon_log_nb_tot",
            "tax_su_tot_log_nb_tot",
            "tax_su_secon_surf",
            "tax_su_tot_surf",
            "tax_su_secon_surf_sup",
            "tax_su_tot_surf_sup",
            "tax_ext_pret",
            "tax_ext_desc",
            "tax_surf_tax_exist_cons",
            "tax_log_exist_nb",
            "tax_am_statio_ext",
            "tax_sup_bass_pisc",
            "tax_empl_ten_carav_mobil_nb",
            "tax_empl_hll_nb",
            "tax_eol_haut_nb",
            "tax_pann_volt_sup",
            "tax_am_statio_ext_sup",
            "tax_sup_bass_pisc_sup",
            "tax_empl_ten_carav_mobil_nb_sup",
            "tax_empl_hll_nb_sup",
            "tax_eol_haut_nb_sup",
            "tax_pann_volt_sup_sup",
            "tax_trx_presc_ppr",
            "tax_monu_hist",
            "tax_comm_nb",
            "tax_su_non_habit_surf1",
            "tax_su_non_habit_surf2",
            "tax_su_non_habit_surf3",
            "tax_su_non_habit_surf4",
            "tax_su_non_habit_surf5",
            "tax_su_non_habit_surf6",
            "tax_su_non_habit_surf7",
            "tax_su_non_habit_surf_sup1",
            "tax_su_non_habit_surf_sup2",
            "tax_su_non_habit_surf_sup3",
            "tax_su_non_habit_surf_sup4",
            "tax_su_non_habit_surf_sup5",
            "tax_su_non_habit_surf_sup6",
            "tax_su_non_habit_surf_sup7",
            "vsd_surf_planch_smd",
            "vsd_unit_fonc_sup",
            "vsd_unit_fonc_constr_sup",
            "vsd_val_terr",
            "vsd_const_sxist_non_dem_surf",
            "vsd_rescr_fisc",
            "pld_val_terr",
            "pld_const_exist_dem",
            "pld_const_exist_dem_surf",
            "code_cnil",
            "terr_juri_titul",
            "terr_juri_lot",
            "terr_juri_zac",
            "terr_juri_afu",
            "terr_juri_pup",
            "terr_juri_oin",
            "terr_juri_desc",
            "terr_div_surf_etab",
            "terr_div_surf_av_div",
            "doc_date",
            "doc_tot_trav",
            "doc_tranche_trav",
            "doc_tranche_trav_desc",
            "doc_surf",
            "doc_nb_log",
            "doc_nb_log_indiv",
            "doc_nb_log_coll",
            "doc_nb_log_lls",
            "doc_nb_log_aa",
            "doc_nb_log_ptz",
            "doc_nb_log_autre",
            "daact_date",
            "daact_date_chgmt_dest",
            "daact_tot_trav",
            "daact_tranche_trav",
            "daact_tranche_trav_desc",
            "daact_surf",
            "daact_nb_log",
            "daact_nb_log_indiv",
            "daact_nb_log_coll",
            "daact_nb_log_lls",
            "daact_nb_log_aa",
            "daact_nb_log_ptz",
            "daact_nb_log_autre",
            "dossier_autorisation",
            "am_div_mun",
            "co_perf_energ",
            "architecte",
            "co_statio_avt_shob",
            "co_statio_apr_shob",
            "co_statio_avt_surf",
            "co_statio_apr_surf",
            "co_trx_amgt",
            "co_modif_aspect",
            "co_modif_struct",
            "co_ouvr_elec",
            "co_ouvr_infra",
            "co_trx_imm",
            "co_cstr_shob",
            "am_voyage_deb",
            "am_voyage_fin",
            "am_modif_amgt",
            "am_lot_max_shob",
            "mod_desc",
            "tr_total",
            "tr_partiel",
            "tr_desc",
            "avap_co_elt_pro",
            "avap_nouv_haut_surf",
            "avap_co_clot",
            "avap_aut_coup_aba_arb",
            "avap_ouv_infra",
            "avap_aut_inst_mob",
            "avap_aut_plant",
            "avap_aut_auv_elec",
            "tax_dest_loc_tr",
            "ope_proj_desc",
            "tax_surf_tot_cstr",
            "cerfa",
            "tax_surf_loc_stat",
            "tax_su_princ_surf_stat1",
            "tax_su_princ_surf_stat2",
            "tax_su_princ_surf_stat3",
            "tax_su_princ_surf_stat4",
            "tax_su_secon_surf_stat",
            "tax_su_heber_surf_stat1",
            "tax_su_heber_surf_stat2",
            "tax_su_heber_surf_stat3",
            "tax_su_tot_surf_stat",
            "tax_su_non_habit_surf_stat1",
            "tax_su_non_habit_surf_stat2",
            "tax_su_non_habit_surf_stat3",
            "tax_su_non_habit_surf_stat4",
            "tax_su_non_habit_surf_stat5",
            "tax_su_non_habit_surf_stat6",
            "tax_su_non_habit_surf_stat7",
            "tax_su_parc_statio_expl_comm_surf",
            "tax_log_ap_trvx_nb",
            "tax_am_statio_ext_cr",
            "tax_sup_bass_pisc_cr",
            "tax_empl_ten_carav_mobil_nb_cr",
            "tax_empl_hll_nb_cr",
            "tax_eol_haut_nb_cr",
            "tax_pann_volt_sup_cr",
            "tax_surf_loc_arch",
            "tax_surf_pisc_arch",
            "tax_am_statio_ext_arch",
            "tax_empl_ten_carav_mobil_nb_arch",
            "tax_empl_hll_nb_arch",
            "tax_eol_haut_nb_arch",
            "ope_proj_div_co",
            "ope_proj_div_contr",
            "tax_desc",
            "erp_cstr_neuve",
            "erp_trvx_acc",
            "erp_extension",
            "erp_rehab",
            "erp_trvx_am",
            "erp_vol_nouv_exist",
            "erp_loc_eff1",
            "erp_loc_eff2",
            "erp_loc_eff3",
            "erp_loc_eff4",
            "erp_loc_eff5",
            "erp_loc_eff_tot",
            "erp_public_eff1",
            "erp_public_eff2",
            "erp_public_eff3",
            "erp_public_eff4",
            "erp_public_eff5",
            "erp_public_eff_tot",
            "erp_perso_eff1",
            "erp_perso_eff2",
            "erp_perso_eff3",
            "erp_perso_eff4",
            "erp_perso_eff5",
            "erp_perso_eff_tot",
            "erp_tot_eff1",
            "erp_tot_eff2",
            "erp_tot_eff3",
            "erp_tot_eff4",
            "erp_tot_eff5",
            "erp_tot_eff_tot",
            "erp_class_cat",
            "erp_class_type",
            "tax_surf_abr_jard_pig_colom",
            "tax_su_non_habit_abr_jard_pig_colom",
            "dia_imm_non_bati",
            "dia_imm_bati_terr_propr",
            "dia_imm_bati_terr_autr",
            "dia_imm_bati_terr_autr_desc",
            "dia_bat_copro",
            "dia_bat_copro_desc",
            "dia_lot_numero",
            "dia_lot_bat",
            "dia_lot_etage",
            "dia_lot_quote_part",
            "dia_us_hab",
            "dia_us_pro",
            "dia_us_mixte",
            "dia_us_comm",
            "dia_us_agr",
            "dia_us_autre",
            "dia_us_autre_prec",
            "dia_occ_prop",
            "dia_occ_loc",
            "dia_occ_sans_occ",
            "dia_occ_autre",
            "dia_occ_autre_prec",
            "dia_mod_cess_prix_vente",
            "dia_mod_cess_prix_vente_mob",
            "dia_mod_cess_prix_vente_cheptel",
            "dia_mod_cess_prix_vente_recol",
            "dia_mod_cess_prix_vente_autre",
            "dia_mod_cess_commi",
            "dia_mod_cess_commi_ttc",
            "dia_mod_cess_commi_ht",
            "dia_acquereur_nom_prenom",
            "dia_acquereur_adr_num_voie",
            "dia_acquereur_adr_ext",
            "dia_acquereur_adr_type_voie",
            "dia_acquereur_adr_nom_voie",
            "dia_acquereur_adr_lieu_dit_bp",
            "dia_acquereur_adr_cp",
            "dia_acquereur_adr_localite",
            "dia_observation",
            "su2_avt_shon1",
            "su2_avt_shon2",
            "su2_avt_shon3",
            "su2_avt_shon4",
            "su2_avt_shon5",
            "su2_avt_shon6",
            "su2_avt_shon7",
            "su2_avt_shon8",
            "su2_avt_shon9",
            "su2_avt_shon10",
            "su2_avt_shon11",
            "su2_avt_shon12",
            "su2_avt_shon13",
            "su2_avt_shon14",
            "su2_avt_shon15",
            "su2_avt_shon16",
            "su2_avt_shon17",
            "su2_avt_shon18",
            "su2_avt_shon19",
            "su2_avt_shon20",
            "su2_avt_shon_tot",
            "su2_cstr_shon1",
            "su2_cstr_shon2",
            "su2_cstr_shon3",
            "su2_cstr_shon4",
            "su2_cstr_shon5",
            "su2_cstr_shon6",
            "su2_cstr_shon7",
            "su2_cstr_shon8",
            "su2_cstr_shon9",
            "su2_cstr_shon10",
            "su2_cstr_shon11",
            "su2_cstr_shon12",
            "su2_cstr_shon13",
            "su2_cstr_shon14",
            "su2_cstr_shon15",
            "su2_cstr_shon16",
            "su2_cstr_shon17",
            "su2_cstr_shon18",
            "su2_cstr_shon19",
            "su2_cstr_shon20",
            "su2_cstr_shon_tot",
            "su2_chge_shon1",
            "su2_chge_shon2",
            "su2_chge_shon3",
            "su2_chge_shon4",
            "su2_chge_shon5",
            "su2_chge_shon6",
            "su2_chge_shon7",
            "su2_chge_shon8",
            "su2_chge_shon9",
            "su2_chge_shon10",
            "su2_chge_shon11",
            "su2_chge_shon12",
            "su2_chge_shon13",
            "su2_chge_shon14",
            "su2_chge_shon15",
            "su2_chge_shon16",
            "su2_chge_shon17",
            "su2_chge_shon18",
            "su2_chge_shon19",
            "su2_chge_shon20",
            "su2_chge_shon_tot",
            "su2_demo_shon1",
            "su2_demo_shon2",
            "su2_demo_shon3",
            "su2_demo_shon4",
            "su2_demo_shon5",
            "su2_demo_shon6",
            "su2_demo_shon7",
            "su2_demo_shon8",
            "su2_demo_shon9",
            "su2_demo_shon10",
            "su2_demo_shon11",
            "su2_demo_shon12",
            "su2_demo_shon13",
            "su2_demo_shon14",
            "su2_demo_shon15",
            "su2_demo_shon16",
            "su2_demo_shon17",
            "su2_demo_shon18",
            "su2_demo_shon19",
            "su2_demo_shon20",
            "su2_demo_shon_tot",
            "su2_sup_shon1",
            "su2_sup_shon2",
            "su2_sup_shon3",
            "su2_sup_shon4",
            "su2_sup_shon5",
            "su2_sup_shon6",
            "su2_sup_shon7",
            "su2_sup_shon8",
            "su2_sup_shon9",
            "su2_sup_shon10",
            "su2_sup_shon11",
            "su2_sup_shon12",
            "su2_sup_shon13",
            "su2_sup_shon14",
            "su2_sup_shon15",
            "su2_sup_shon16",
            "su2_sup_shon17",
            "su2_sup_shon18",
            "su2_sup_shon19",
            "su2_sup_shon20",
            "su2_sup_shon_tot",
            "su2_tot_shon1",
            "su2_tot_shon2",
            "su2_tot_shon3",
            "su2_tot_shon4",
            "su2_tot_shon5",
            "su2_tot_shon6",
            "su2_tot_shon7",
            "su2_tot_shon8",
            "su2_tot_shon9",
            "su2_tot_shon10",
            "su2_tot_shon11",
            "su2_tot_shon12",
            "su2_tot_shon13",
            "su2_tot_shon14",
            "su2_tot_shon15",
            "su2_tot_shon16",
            "su2_tot_shon17",
            "su2_tot_shon18",
            "su2_tot_shon19",
            "su2_tot_shon20",
            "su2_tot_shon_tot",
            "dia_occ_sol_su_terre",
            "dia_occ_sol_su_pres",
            "dia_occ_sol_su_verger",
            "dia_occ_sol_su_vigne",
            "dia_occ_sol_su_bois",
            "dia_occ_sol_su_lande",
            "dia_occ_sol_su_carriere",
            "dia_occ_sol_su_eau_cadastree",
            "dia_occ_sol_su_jardin",
            "dia_occ_sol_su_terr_batir",
            "dia_occ_sol_su_terr_agr",
            "dia_occ_sol_su_sol",
            "dia_bati_vend_tot",
            "dia_bati_vend_tot_txt",
            "dia_su_co_sol",
            "dia_su_util_hab",
            "dia_nb_niv",
            "dia_nb_appart",
            "dia_nb_autre_loc",
            "dia_vente_lot_volume",
            "dia_vente_lot_volume_txt",
            "dia_lot_nat_su",
            "dia_lot_bat_achv_plus_10",
            "dia_lot_bat_achv_moins_10",
            "dia_lot_regl_copro_publ_hypo_plus_10",
            "dia_lot_regl_copro_publ_hypo_moins_10",
            "dia_indivi_quote_part",
            "dia_design_societe",
            "dia_design_droit",
            "dia_droit_soc_nat",
            "dia_droit_soc_nb",
            "dia_droit_soc_num_part",
            "dia_droit_reel_perso_grevant_bien_oui",
            "dia_droit_reel_perso_grevant_bien_non",
            "dia_droit_reel_perso_nat",
            "dia_droit_reel_perso_viag",
            "dia_mod_cess_adr",
            "dia_mod_cess_sign_act_auth",
            "dia_mod_cess_terme",
            "dia_mod_cess_terme_prec",
            "dia_mod_cess_bene_acquereur",
            "dia_mod_cess_bene_vendeur",
            "dia_mod_cess_paie_nat",
            "dia_mod_cess_design_contr_alien",
            "dia_mod_cess_eval_contr",
            "dia_mod_cess_rente_viag",
            "dia_mod_cess_mnt_an",
            "dia_mod_cess_mnt_compt",
            "dia_mod_cess_bene_rente",
            "dia_mod_cess_droit_usa_hab",
            "dia_mod_cess_droit_usa_hab_prec",
            "dia_mod_cess_eval_usa_usufruit",
            "dia_mod_cess_vente_nue_prop",
            "dia_mod_cess_vente_nue_prop_prec",
            "dia_mod_cess_echange",
            "dia_mod_cess_design_bien_recus_ech",
            "dia_mod_cess_mnt_soulte",
            "dia_mod_cess_prop_contre_echan",
            "dia_mod_cess_apport_societe",
            "dia_mod_cess_bene",
            "dia_mod_cess_esti_bien",
            "dia_mod_cess_cess_terr_loc_co",
            "dia_mod_cess_esti_terr",
            "dia_mod_cess_esti_loc",
            "dia_mod_cess_esti_imm_loca",
            "dia_mod_cess_adju_vol",
            "dia_mod_cess_adju_obl",
            "dia_mod_cess_adju_fin_indivi",
            "dia_mod_cess_adju_date_lieu",
            "dia_mod_cess_mnt_mise_prix",
            "dia_prop_titu_prix_indique",
            "dia_prop_recherche_acqu_prix_indique",
            "dia_acquereur_prof",
            "dia_indic_compl_ope",
            "dia_vente_adju",
            "am_terr_res_demon",
            "am_air_terr_res_mob",
            "ctx_objet_recours",
            "ctx_reference_sagace",
            "ctx_nature_travaux_infra_om_html",
            "ctx_synthese_nti",
            "ctx_article_non_resp_om_html",
            "ctx_synthese_anr",
            "ctx_reference_parquet",
            "ctx_element_taxation",
            "ctx_infraction",
            "ctx_regularisable",
            "ctx_reference_courrier",
            "ctx_date_audience",
            "ctx_date_ajournement",
            "exo_facul_1",
            "exo_facul_2",
            "exo_facul_3",
            "exo_facul_4",
            "exo_facul_5",
            "exo_facul_6",
            "exo_facul_7",
            "exo_facul_8",
            "exo_facul_9",
            "exo_ta_1",
            "exo_ta_2",
            "exo_ta_3",
            "exo_ta_4",
            "exo_ta_5",
            "exo_ta_6",
            "exo_ta_7",
            "exo_ta_8",
            "exo_ta_9",
            "exo_rap_1",
            "exo_rap_2",
            "exo_rap_3",
            "exo_rap_4",
            "exo_rap_5",
            "exo_rap_6",
            "exo_rap_7",
            "exo_rap_8",
            "mtn_exo_ta_part_commu",
            "mtn_exo_ta_part_depart",
            "mtn_exo_ta_part_reg",
            "mtn_exo_rap",
            "dpc_type",
            "dpc_desc_actv_ex",
            "dpc_desc_ca",
            "dpc_desc_aut_prec",
            "dpc_desig_comm_arti",
            "dpc_desig_loc_hab",
            "dpc_desig_loc_ann",
            "dpc_desig_loc_ann_prec",
            "dpc_bail_comm_date",
            "dpc_bail_comm_loyer",
            "dpc_actv_acqu",
            "dpc_nb_sala_di",
            "dpc_nb_sala_dd",
            "dpc_nb_sala_tc",
            "dpc_nb_sala_tp",
            "dpc_moda_cess_vente_am",
            "dpc_moda_cess_adj",
            "dpc_moda_cess_prix",
            "dpc_moda_cess_adj_date",
            "dpc_moda_cess_adj_prec",
            "dpc_moda_cess_paie_comp",
            "dpc_moda_cess_paie_terme",
            "dpc_moda_cess_paie_terme_prec",
            "dpc_moda_cess_paie_nat",
            "dpc_moda_cess_paie_nat_desig_alien",
            "dpc_moda_cess_paie_nat_desig_alien_prec",
            "dpc_moda_cess_paie_nat_eval",
            "dpc_moda_cess_paie_nat_eval_prec",
            "dpc_moda_cess_paie_aut",
            "dpc_moda_cess_paie_aut_prec",
            "dpc_ss_signe_demande_acqu",
            "dpc_ss_signe_recher_trouv_acqu",
            "dpc_notif_adr_prop",
            "dpc_notif_adr_manda",
            "dpc_obs",
            "co_peri_site_patri_remar",
            "co_abo_monu_hist",
            "co_inst_ouvr_trav_act_code_envir",
            "co_trav_auto_env",
            "co_derog_esp_prot",
            "ctx_reference_dsj",
            "co_piscine",
            "co_fin_lls",
            "co_fin_aa",
            "co_fin_ptz",
            "co_fin_autr",
            "dia_ss_date",
            "dia_ss_lieu",
            "enga_decla_lieu",
            "enga_decla_date",
            "co_archi_attest_honneur",
            "co_bat_niv_dessous_nb",
            "co_install_classe",
            "co_derog_innov",
            "co_avis_abf",
            "tax_surf_tot_demo",
            "tax_surf_tax_demo",
            "tax_su_non_habit_surf8",
            "tax_su_non_habit_surf_stat8",
            "tax_su_non_habit_surf9",
            "tax_su_non_habit_surf_stat9",
            "tax_terrassement_arch",
            "tax_adresse_future_numero",
            "tax_adresse_future_voie",
            "tax_adresse_future_lieudit",
            "tax_adresse_future_localite",
            "tax_adresse_future_cp",
            "tax_adresse_future_bp",
            "tax_adresse_future_cedex",
            "tax_adresse_future_pays",
            "tax_adresse_future_division",
            "co_bat_projete",
            "co_bat_existant",
            "co_bat_nature",
            "terr_juri_titul_date",
            "co_autre_desc",
            "co_trx_autre",
            "co_autre",
            "erp_modif_facades",
            "erp_trvx_adap",
            "erp_trvx_adap_numero",
            "erp_trvx_adap_valid",
            "erp_prod_dangereux",
            "co_trav_supp_dessus",
            "co_trav_supp_dessous",
            "tax_su_habit_abr_jard_pig_colom",
            "enga_decla_donnees_nomi_comm",
            "x1l_legislation",
            "x1p_precisions",
            "x1u_raccordement",
            "x2m_inscritmh",
            "s1na1_numero",
            "s1va1_voie",
            "s1wa1_lieudit",
            "s1la1_localite",
            "s1pa1_codepostal",
            "s1na2_numero",
            "s1va2_voie",
            "s1wa2_lieudit",
            "s1la2_localite",
            "s1pa2_codepostal",
            "e3c_certification",
            "e3a_competence",
            "a4d_description",
            "m2b_abf",
            "m2j_pn",
            "m2r_cdac",
            "m2r_cnac",
            "u3a_voirieoui",
            "u3f_voirienon",
            "u3c_eauoui",
            "u3h_eaunon",
            "u3g_assainissementoui",
            "u3n_assainissementnon",
            "u3m_electriciteoui",
            "u3b_electricitenon",
            "u3t_observations",
            "u1a_voirieoui",
            "u1v_voirienon",
            "u1q_voirieconcessionnaire",
            "u1b_voirieavant",
            "u1j_eauoui",
            "u1t_eaunon",
            "u1e_eauconcessionnaire",
            "u1k_eauavant",
            "u1s_assainissementoui",
            "u1d_assainissementnon",
            "u1l_assainissementconcessionnaire",
            "u1r_assainissementavant",
            "u1c_electriciteoui",
            "u1u_electricitenon",
            "u1m_electriciteconcessionnaire",
            "u1f_electriciteavant",
            "u2a_observations",
            "f1ts4_surftaxestation",
            "f1ut1_surfcree",
            "f9d_date",
            "f9n_nom",
            "su2_avt_shon21",
            "su2_avt_shon22",
            "su2_cstr_shon21",
            "su2_cstr_shon22",
            "su2_chge_shon21",
            "su2_chge_shon22",
            "su2_demo_shon21",
            "su2_demo_shon22",
            "su2_sup_shon21",
            "su2_sup_shon22",
            "su2_tot_shon21",
            "su2_tot_shon22",
            "f1gu1_f1gu2_f1gu3",
            "f1lu1_f1lu2_f1lu3",
            "f1zu1_f1zu2_f1zu3",
            "f1pu1_f1pu2_f1pu3",
            "f1gt4_f1gt5_f1gt6",
            "f1lt4_f1lt5_f1lt6",
            "f1zt4_f1zt5_f1zt6",
            "f1pt4_f1pt5_f1pt6",
            "f1xu1_f1xu2_f1xu3",
            "f1xt4_f1xt5_f1xt6",
            "f1hu1_f1hu2_f1hu3",
            "f1mu1_f1mu2_f1mu3",
            "f1qu1_f1qu2_f1qu3",
            "f1ht4_f1ht5_f1ht6",
            "f1mt4_f1mt5_f1mt6",
            "f1qt4_f1qt5_f1qt6",
            "f2cu1_f2cu2_f2cu3",
            "f2bu1_f2bu2_f2bu3",
            "f2su1_f2su2_f2su3",
            "f2hu1_f2hu2_f2hu3",
            "f2eu1_f2eu2_f2eu3",
            "f2qu1_f2qu2_f2qu3",
            "f2ct4_f2ct5_f2ct6",
            "f2bt4_f2bt5_f2bt6",
            "f2st4_f2st5_f2st6",
            "f2ht4_f2ht5_f2ht6",
            "f2et4_f2et5_f2et6",
            "f2qt4_f2qt5_f2qt6",
            "dia_droit_reel_perso_grevant_bien_desc",
            "dia_mod_cess_paie_nat_desc",
            "dia_mod_cess_rente_viag_desc",
            "dia_mod_cess_echange_desc",
            "dia_mod_cess_apport_societe_desc",
            "dia_mod_cess_cess_terr_loc_co_desc",
            "dia_mod_cess_esti_imm_loca_desc",
            "dia_mod_cess_adju_obl_desc",
            "dia_mod_cess_adju_fin_indivi_desc",
            "dia_cadre_titul_droit_prempt",
            "dia_mairie_prix_moyen",
            "dia_propri_indivi",
            "dia_situa_bien_plan_cadas_oui",
            "dia_situa_bien_plan_cadas_non",
            "dia_notif_dec_titul_adr_prop",
            "dia_notif_dec_titul_adr_prop_desc",
            "dia_notif_dec_titul_adr_manda",
            "dia_notif_dec_titul_adr_manda_desc",
            "dia_dia_dpu",
            "dia_dia_zad",
            "dia_dia_zone_preempt_esp_natu_sensi",
            "dia_dab_dpu",
            "dia_dab_zad",
            "dia_mod_cess_commi_mnt",
            "dia_mod_cess_commi_mnt_ttc",
            "dia_mod_cess_commi_mnt_ht",
            "dia_mod_cess_prix_vente_num",
            "dia_mod_cess_prix_vente_mob_num",
            "dia_mod_cess_prix_vente_cheptel_num",
            "dia_mod_cess_prix_vente_recol_num",
            "dia_mod_cess_prix_vente_autre_num",
            "dia_su_co_sol_num",
            "dia_su_util_hab_num",
            "dia_mod_cess_mnt_an_num",
            "dia_mod_cess_mnt_compt_num",
            "dia_mod_cess_mnt_soulte_num",
            "dia_comp_prix_vente",
            "dia_comp_surface",
            "dia_comp_total_frais",
            "dia_comp_mtn_total",
            "dia_comp_valeur_m2",
            "dia_esti_prix_france_dom",
            "dia_prop_collectivite",
            "dia_delegataire_denomination",
            "dia_delegataire_raison_sociale",
            "dia_delegataire_siret",
            "dia_delegataire_categorie_juridique",
            "dia_delegataire_representant_nom",
            "dia_delegataire_representant_prenom",
            "dia_delegataire_adresse_numero",
            "dia_delegataire_adresse_voie",
            "dia_delegataire_adresse_complement",
            "dia_delegataire_adresse_lieu_dit",
            "dia_delegataire_adresse_localite",
            "dia_delegataire_adresse_code_postal",
            "dia_delegataire_adresse_bp",
            "dia_delegataire_adresse_cedex",
            "dia_delegataire_adresse_pays",
            "dia_delegataire_telephone_fixe",
            "dia_delegataire_telephone_mobile",
            "dia_delegataire_telephone_mobile_indicatif",
            "dia_delegataire_courriel",
            "dia_delegataire_fax",
            "dia_entree_jouissance_type",
            "dia_entree_jouissance_date",
            "dia_entree_jouissance_date_effet",
            "dia_entree_jouissance_com",
            "dia_remise_bien_date_effet",
            "dia_remise_bien_com",
            "c2zp1_crete",
            "c2zr1_destination",
            "mh_design_appel_denom",
            "mh_design_type_protect",
            "mh_design_elem_prot",
            "mh_design_ref_merimee_palissy",
            "mh_design_nature_prop",
            "mh_loc_denom",
            "mh_pres_intitule",
            "mh_trav_cat_1",
            "mh_trav_cat_2",
            "mh_trav_cat_3",
            "mh_trav_cat_4",
            "mh_trav_cat_5",
            "mh_trav_cat_6",
            "mh_trav_cat_7",
            "mh_trav_cat_8",
            "mh_trav_cat_9",
            "mh_trav_cat_10",
            "mh_trav_cat_11",
            "mh_trav_cat_12",
            "mh_trav_cat_12_prec",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_architecte() {
        return "SELECT architecte.architecte, architecte.nom FROM ".DB_PREFIXE."architecte ORDER BY architecte.nom ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_architecte_by_id() {
        return "SELECT architecte.architecte, architecte.nom FROM ".DB_PREFIXE."architecte WHERE architecte = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_ctx_objet_recours() {
        return "SELECT objet_recours.objet_recours, objet_recours.libelle FROM ".DB_PREFIXE."objet_recours WHERE ((objet_recours.om_validite_debut IS NULL AND (objet_recours.om_validite_fin IS NULL OR objet_recours.om_validite_fin > CURRENT_DATE)) OR (objet_recours.om_validite_debut <= CURRENT_DATE AND (objet_recours.om_validite_fin IS NULL OR objet_recours.om_validite_fin > CURRENT_DATE))) ORDER BY objet_recours.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_ctx_objet_recours_by_id() {
        return "SELECT objet_recours.objet_recours, objet_recours.libelle FROM ".DB_PREFIXE."objet_recours WHERE objet_recours = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation() {
        return "SELECT dossier_autorisation.dossier_autorisation, dossier_autorisation.dossier_autorisation_type_detaille FROM ".DB_PREFIXE."dossier_autorisation ORDER BY dossier_autorisation.dossier_autorisation_type_detaille ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_by_id() {
        return "SELECT dossier_autorisation.dossier_autorisation, dossier_autorisation.dossier_autorisation_type_detaille FROM ".DB_PREFIXE."dossier_autorisation WHERE dossier_autorisation = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_lot() {
        return "SELECT lot.lot, lot.libelle FROM ".DB_PREFIXE."lot ORDER BY lot.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_lot_by_id() {
        return "SELECT lot.lot, lot.libelle FROM ".DB_PREFIXE."lot WHERE lot = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['donnees_techniques'])) {
            $this->valF['donnees_techniques'] = ""; // -> requis
        } else {
            $this->valF['donnees_techniques'] = $val['donnees_techniques'];
        }
        if ($val['dossier_instruction'] == "") {
            $this->valF['dossier_instruction'] = NULL;
        } else {
            $this->valF['dossier_instruction'] = $val['dossier_instruction'];
        }
        if (!is_numeric($val['lot'])) {
            $this->valF['lot'] = NULL;
        } else {
            $this->valF['lot'] = $val['lot'];
        }
        if ($val['am_lotiss'] == 1 || $val['am_lotiss'] == "t" || $val['am_lotiss'] == "Oui") {
            $this->valF['am_lotiss'] = true;
        } else {
            $this->valF['am_lotiss'] = false;
        }
        if ($val['am_autre_div'] == 1 || $val['am_autre_div'] == "t" || $val['am_autre_div'] == "Oui") {
            $this->valF['am_autre_div'] = true;
        } else {
            $this->valF['am_autre_div'] = false;
        }
        if ($val['am_camping'] == 1 || $val['am_camping'] == "t" || $val['am_camping'] == "Oui") {
            $this->valF['am_camping'] = true;
        } else {
            $this->valF['am_camping'] = false;
        }
        if ($val['am_caravane'] == 1 || $val['am_caravane'] == "t" || $val['am_caravane'] == "Oui") {
            $this->valF['am_caravane'] = true;
        } else {
            $this->valF['am_caravane'] = false;
        }
        if (!is_numeric($val['am_carav_duree'])) {
            $this->valF['am_carav_duree'] = NULL;
        } else {
            $this->valF['am_carav_duree'] = $val['am_carav_duree'];
        }
        if ($val['am_statio'] == 1 || $val['am_statio'] == "t" || $val['am_statio'] == "Oui") {
            $this->valF['am_statio'] = true;
        } else {
            $this->valF['am_statio'] = false;
        }
        if (!is_numeric($val['am_statio_cont'])) {
            $this->valF['am_statio_cont'] = NULL;
        } else {
            $this->valF['am_statio_cont'] = $val['am_statio_cont'];
        }
        if ($val['am_affou_exhau'] == 1 || $val['am_affou_exhau'] == "t" || $val['am_affou_exhau'] == "Oui") {
            $this->valF['am_affou_exhau'] = true;
        } else {
            $this->valF['am_affou_exhau'] = false;
        }
        if (!is_numeric($val['am_affou_exhau_sup'])) {
            $this->valF['am_affou_exhau_sup'] = NULL;
        } else {
            $this->valF['am_affou_exhau_sup'] = $val['am_affou_exhau_sup'];
        }
        if (!is_numeric($val['am_affou_prof'])) {
            $this->valF['am_affou_prof'] = NULL;
        } else {
            $this->valF['am_affou_prof'] = $val['am_affou_prof'];
        }
        if (!is_numeric($val['am_exhau_haut'])) {
            $this->valF['am_exhau_haut'] = NULL;
        } else {
            $this->valF['am_exhau_haut'] = $val['am_exhau_haut'];
        }
        if ($val['am_coupe_abat'] == 1 || $val['am_coupe_abat'] == "t" || $val['am_coupe_abat'] == "Oui") {
            $this->valF['am_coupe_abat'] = true;
        } else {
            $this->valF['am_coupe_abat'] = false;
        }
        if ($val['am_prot_plu'] == 1 || $val['am_prot_plu'] == "t" || $val['am_prot_plu'] == "Oui") {
            $this->valF['am_prot_plu'] = true;
        } else {
            $this->valF['am_prot_plu'] = false;
        }
        if ($val['am_prot_muni'] == 1 || $val['am_prot_muni'] == "t" || $val['am_prot_muni'] == "Oui") {
            $this->valF['am_prot_muni'] = true;
        } else {
            $this->valF['am_prot_muni'] = false;
        }
        if ($val['am_mobil_voyage'] == 1 || $val['am_mobil_voyage'] == "t" || $val['am_mobil_voyage'] == "Oui") {
            $this->valF['am_mobil_voyage'] = true;
        } else {
            $this->valF['am_mobil_voyage'] = false;
        }
        if ($val['am_aire_voyage'] == 1 || $val['am_aire_voyage'] == "t" || $val['am_aire_voyage'] == "Oui") {
            $this->valF['am_aire_voyage'] = true;
        } else {
            $this->valF['am_aire_voyage'] = false;
        }
        if ($val['am_rememb_afu'] == 1 || $val['am_rememb_afu'] == "t" || $val['am_rememb_afu'] == "Oui") {
            $this->valF['am_rememb_afu'] = true;
        } else {
            $this->valF['am_rememb_afu'] = false;
        }
        if ($val['am_parc_resid_loi'] == 1 || $val['am_parc_resid_loi'] == "t" || $val['am_parc_resid_loi'] == "Oui") {
            $this->valF['am_parc_resid_loi'] = true;
        } else {
            $this->valF['am_parc_resid_loi'] = false;
        }
        if ($val['am_sport_moto'] == 1 || $val['am_sport_moto'] == "t" || $val['am_sport_moto'] == "Oui") {
            $this->valF['am_sport_moto'] = true;
        } else {
            $this->valF['am_sport_moto'] = false;
        }
        if ($val['am_sport_attrac'] == 1 || $val['am_sport_attrac'] == "t" || $val['am_sport_attrac'] == "Oui") {
            $this->valF['am_sport_attrac'] = true;
        } else {
            $this->valF['am_sport_attrac'] = false;
        }
        if ($val['am_sport_golf'] == 1 || $val['am_sport_golf'] == "t" || $val['am_sport_golf'] == "Oui") {
            $this->valF['am_sport_golf'] = true;
        } else {
            $this->valF['am_sport_golf'] = false;
        }
        if ($val['am_mob_art'] == 1 || $val['am_mob_art'] == "t" || $val['am_mob_art'] == "Oui") {
            $this->valF['am_mob_art'] = true;
        } else {
            $this->valF['am_mob_art'] = false;
        }
        if ($val['am_modif_voie_esp'] == 1 || $val['am_modif_voie_esp'] == "t" || $val['am_modif_voie_esp'] == "Oui") {
            $this->valF['am_modif_voie_esp'] = true;
        } else {
            $this->valF['am_modif_voie_esp'] = false;
        }
        if ($val['am_plant_voie_esp'] == 1 || $val['am_plant_voie_esp'] == "t" || $val['am_plant_voie_esp'] == "Oui") {
            $this->valF['am_plant_voie_esp'] = true;
        } else {
            $this->valF['am_plant_voie_esp'] = false;
        }
        if ($val['am_chem_ouv_esp'] == 1 || $val['am_chem_ouv_esp'] == "t" || $val['am_chem_ouv_esp'] == "Oui") {
            $this->valF['am_chem_ouv_esp'] = true;
        } else {
            $this->valF['am_chem_ouv_esp'] = false;
        }
        if ($val['am_agri_peche'] == 1 || $val['am_agri_peche'] == "t" || $val['am_agri_peche'] == "Oui") {
            $this->valF['am_agri_peche'] = true;
        } else {
            $this->valF['am_agri_peche'] = false;
        }
        if ($val['am_crea_voie'] == 1 || $val['am_crea_voie'] == "t" || $val['am_crea_voie'] == "Oui") {
            $this->valF['am_crea_voie'] = true;
        } else {
            $this->valF['am_crea_voie'] = false;
        }
        if ($val['am_modif_voie_exist'] == 1 || $val['am_modif_voie_exist'] == "t" || $val['am_modif_voie_exist'] == "Oui") {
            $this->valF['am_modif_voie_exist'] = true;
        } else {
            $this->valF['am_modif_voie_exist'] = false;
        }
        if ($val['am_crea_esp_sauv'] == 1 || $val['am_crea_esp_sauv'] == "t" || $val['am_crea_esp_sauv'] == "Oui") {
            $this->valF['am_crea_esp_sauv'] = true;
        } else {
            $this->valF['am_crea_esp_sauv'] = false;
        }
        if ($val['am_crea_esp_class'] == 1 || $val['am_crea_esp_class'] == "t" || $val['am_crea_esp_class'] == "Oui") {
            $this->valF['am_crea_esp_class'] = true;
        } else {
            $this->valF['am_crea_esp_class'] = false;
        }
            $this->valF['am_projet_desc'] = $val['am_projet_desc'];
        if (!is_numeric($val['am_terr_surf'])) {
            $this->valF['am_terr_surf'] = NULL;
        } else {
            $this->valF['am_terr_surf'] = $val['am_terr_surf'];
        }
            $this->valF['am_tranche_desc'] = $val['am_tranche_desc'];
        if (!is_numeric($val['am_lot_max_nb'])) {
            $this->valF['am_lot_max_nb'] = NULL;
        } else {
            $this->valF['am_lot_max_nb'] = $val['am_lot_max_nb'];
        }
        if (!is_numeric($val['am_lot_max_shon'])) {
            $this->valF['am_lot_max_shon'] = NULL;
        } else {
            $this->valF['am_lot_max_shon'] = $val['am_lot_max_shon'];
        }
        if ($val['am_lot_cstr_cos'] == 1 || $val['am_lot_cstr_cos'] == "t" || $val['am_lot_cstr_cos'] == "Oui") {
            $this->valF['am_lot_cstr_cos'] = true;
        } else {
            $this->valF['am_lot_cstr_cos'] = false;
        }
        if ($val['am_lot_cstr_plan'] == 1 || $val['am_lot_cstr_plan'] == "t" || $val['am_lot_cstr_plan'] == "Oui") {
            $this->valF['am_lot_cstr_plan'] = true;
        } else {
            $this->valF['am_lot_cstr_plan'] = false;
        }
        if ($val['am_lot_cstr_vente'] == 1 || $val['am_lot_cstr_vente'] == "t" || $val['am_lot_cstr_vente'] == "Oui") {
            $this->valF['am_lot_cstr_vente'] = true;
        } else {
            $this->valF['am_lot_cstr_vente'] = false;
        }
        if ($val['am_lot_fin_diff'] == 1 || $val['am_lot_fin_diff'] == "t" || $val['am_lot_fin_diff'] == "Oui") {
            $this->valF['am_lot_fin_diff'] = true;
        } else {
            $this->valF['am_lot_fin_diff'] = false;
        }
        if ($val['am_lot_consign'] == 1 || $val['am_lot_consign'] == "t" || $val['am_lot_consign'] == "Oui") {
            $this->valF['am_lot_consign'] = true;
        } else {
            $this->valF['am_lot_consign'] = false;
        }
        if ($val['am_lot_gar_achev'] == 1 || $val['am_lot_gar_achev'] == "t" || $val['am_lot_gar_achev'] == "Oui") {
            $this->valF['am_lot_gar_achev'] = true;
        } else {
            $this->valF['am_lot_gar_achev'] = false;
        }
        if ($val['am_lot_vente_ant'] == 1 || $val['am_lot_vente_ant'] == "t" || $val['am_lot_vente_ant'] == "Oui") {
            $this->valF['am_lot_vente_ant'] = true;
        } else {
            $this->valF['am_lot_vente_ant'] = false;
        }
        if (!is_numeric($val['am_empl_nb'])) {
            $this->valF['am_empl_nb'] = NULL;
        } else {
            $this->valF['am_empl_nb'] = $val['am_empl_nb'];
        }
        if (!is_numeric($val['am_tente_nb'])) {
            $this->valF['am_tente_nb'] = NULL;
        } else {
            $this->valF['am_tente_nb'] = $val['am_tente_nb'];
        }
        if (!is_numeric($val['am_carav_nb'])) {
            $this->valF['am_carav_nb'] = NULL;
        } else {
            $this->valF['am_carav_nb'] = $val['am_carav_nb'];
        }
        if (!is_numeric($val['am_mobil_nb'])) {
            $this->valF['am_mobil_nb'] = NULL;
        } else {
            $this->valF['am_mobil_nb'] = $val['am_mobil_nb'];
        }
        if (!is_numeric($val['am_pers_nb'])) {
            $this->valF['am_pers_nb'] = NULL;
        } else {
            $this->valF['am_pers_nb'] = $val['am_pers_nb'];
        }
        if (!is_numeric($val['am_empl_hll_nb'])) {
            $this->valF['am_empl_hll_nb'] = NULL;
        } else {
            $this->valF['am_empl_hll_nb'] = $val['am_empl_hll_nb'];
        }
        if (!is_numeric($val['am_hll_shon'])) {
            $this->valF['am_hll_shon'] = NULL;
        } else {
            $this->valF['am_hll_shon'] = $val['am_hll_shon'];
        }
            $this->valF['am_periode_exploit'] = $val['am_periode_exploit'];
        if ($val['am_exist_agrand'] == 1 || $val['am_exist_agrand'] == "t" || $val['am_exist_agrand'] == "Oui") {
            $this->valF['am_exist_agrand'] = true;
        } else {
            $this->valF['am_exist_agrand'] = false;
        }
        if ($val['am_exist_date'] == "") {
            $this->valF['am_exist_date'] = NULL;
        } else {
            $this->valF['am_exist_date'] = $val['am_exist_date'];
        }
        if ($val['am_exist_num'] == "") {
            $this->valF['am_exist_num'] = NULL;
        } else {
            $this->valF['am_exist_num'] = $val['am_exist_num'];
        }
        if (!is_numeric($val['am_exist_nb_avant'])) {
            $this->valF['am_exist_nb_avant'] = NULL;
        } else {
            $this->valF['am_exist_nb_avant'] = $val['am_exist_nb_avant'];
        }
        if (!is_numeric($val['am_exist_nb_apres'])) {
            $this->valF['am_exist_nb_apres'] = NULL;
        } else {
            $this->valF['am_exist_nb_apres'] = $val['am_exist_nb_apres'];
        }
        if ($val['am_coupe_bois'] == 1 || $val['am_coupe_bois'] == "t" || $val['am_coupe_bois'] == "Oui") {
            $this->valF['am_coupe_bois'] = true;
        } else {
            $this->valF['am_coupe_bois'] = false;
        }
        if ($val['am_coupe_parc'] == 1 || $val['am_coupe_parc'] == "t" || $val['am_coupe_parc'] == "Oui") {
            $this->valF['am_coupe_parc'] = true;
        } else {
            $this->valF['am_coupe_parc'] = false;
        }
        if ($val['am_coupe_align'] == 1 || $val['am_coupe_align'] == "t" || $val['am_coupe_align'] == "Oui") {
            $this->valF['am_coupe_align'] = true;
        } else {
            $this->valF['am_coupe_align'] = false;
        }
        if ($val['am_coupe_ess'] == "") {
            $this->valF['am_coupe_ess'] = NULL;
        } else {
            $this->valF['am_coupe_ess'] = $val['am_coupe_ess'];
        }
        if ($val['am_coupe_age'] == "") {
            $this->valF['am_coupe_age'] = NULL;
        } else {
            $this->valF['am_coupe_age'] = $val['am_coupe_age'];
        }
        if ($val['am_coupe_dens'] == "") {
            $this->valF['am_coupe_dens'] = NULL;
        } else {
            $this->valF['am_coupe_dens'] = $val['am_coupe_dens'];
        }
        if ($val['am_coupe_qual'] == "") {
            $this->valF['am_coupe_qual'] = NULL;
        } else {
            $this->valF['am_coupe_qual'] = $val['am_coupe_qual'];
        }
        if ($val['am_coupe_trait'] == "") {
            $this->valF['am_coupe_trait'] = NULL;
        } else {
            $this->valF['am_coupe_trait'] = $val['am_coupe_trait'];
        }
        if ($val['am_coupe_autr'] == "") {
            $this->valF['am_coupe_autr'] = NULL;
        } else {
            $this->valF['am_coupe_autr'] = $val['am_coupe_autr'];
        }
        if ($val['co_archi_recours'] == 1 || $val['co_archi_recours'] == "t" || $val['co_archi_recours'] == "Oui") {
            $this->valF['co_archi_recours'] = true;
        } else {
            $this->valF['co_archi_recours'] = false;
        }
        if ($val['co_cstr_nouv'] == 1 || $val['co_cstr_nouv'] == "t" || $val['co_cstr_nouv'] == "Oui") {
            $this->valF['co_cstr_nouv'] = true;
        } else {
            $this->valF['co_cstr_nouv'] = false;
        }
        if ($val['co_cstr_exist'] == 1 || $val['co_cstr_exist'] == "t" || $val['co_cstr_exist'] == "Oui") {
            $this->valF['co_cstr_exist'] = true;
        } else {
            $this->valF['co_cstr_exist'] = false;
        }
        if ($val['co_cloture'] == 1 || $val['co_cloture'] == "t" || $val['co_cloture'] == "Oui") {
            $this->valF['co_cloture'] = true;
        } else {
            $this->valF['co_cloture'] = false;
        }
        if (!is_numeric($val['co_elec_tension'])) {
            $this->valF['co_elec_tension'] = NULL;
        } else {
            $this->valF['co_elec_tension'] = $val['co_elec_tension'];
        }
        if ($val['co_div_terr'] == 1 || $val['co_div_terr'] == "t" || $val['co_div_terr'] == "Oui") {
            $this->valF['co_div_terr'] = true;
        } else {
            $this->valF['co_div_terr'] = false;
        }
            $this->valF['co_projet_desc'] = $val['co_projet_desc'];
        if ($val['co_anx_pisc'] == 1 || $val['co_anx_pisc'] == "t" || $val['co_anx_pisc'] == "Oui") {
            $this->valF['co_anx_pisc'] = true;
        } else {
            $this->valF['co_anx_pisc'] = false;
        }
        if ($val['co_anx_gara'] == 1 || $val['co_anx_gara'] == "t" || $val['co_anx_gara'] == "Oui") {
            $this->valF['co_anx_gara'] = true;
        } else {
            $this->valF['co_anx_gara'] = false;
        }
        if ($val['co_anx_veran'] == 1 || $val['co_anx_veran'] == "t" || $val['co_anx_veran'] == "Oui") {
            $this->valF['co_anx_veran'] = true;
        } else {
            $this->valF['co_anx_veran'] = false;
        }
        if ($val['co_anx_abri'] == 1 || $val['co_anx_abri'] == "t" || $val['co_anx_abri'] == "Oui") {
            $this->valF['co_anx_abri'] = true;
        } else {
            $this->valF['co_anx_abri'] = false;
        }
        if ($val['co_anx_autr'] == 1 || $val['co_anx_autr'] == "t" || $val['co_anx_autr'] == "Oui") {
            $this->valF['co_anx_autr'] = true;
        } else {
            $this->valF['co_anx_autr'] = false;
        }
            $this->valF['co_anx_autr_desc'] = $val['co_anx_autr_desc'];
        if (!is_numeric($val['co_tot_log_nb'])) {
            $this->valF['co_tot_log_nb'] = NULL;
        } else {
            $this->valF['co_tot_log_nb'] = $val['co_tot_log_nb'];
        }
        if (!is_numeric($val['co_tot_ind_nb'])) {
            $this->valF['co_tot_ind_nb'] = NULL;
        } else {
            $this->valF['co_tot_ind_nb'] = $val['co_tot_ind_nb'];
        }
        if (!is_numeric($val['co_tot_coll_nb'])) {
            $this->valF['co_tot_coll_nb'] = NULL;
        } else {
            $this->valF['co_tot_coll_nb'] = $val['co_tot_coll_nb'];
        }
        if (!is_numeric($val['co_mais_piece_nb'])) {
            $this->valF['co_mais_piece_nb'] = NULL;
        } else {
            $this->valF['co_mais_piece_nb'] = $val['co_mais_piece_nb'];
        }
        if (!is_numeric($val['co_mais_niv_nb'])) {
            $this->valF['co_mais_niv_nb'] = NULL;
        } else {
            $this->valF['co_mais_niv_nb'] = $val['co_mais_niv_nb'];
        }
        if (!is_numeric($val['co_fin_lls_nb'])) {
            $this->valF['co_fin_lls_nb'] = NULL;
        } else {
            $this->valF['co_fin_lls_nb'] = $val['co_fin_lls_nb'];
        }
        if (!is_numeric($val['co_fin_aa_nb'])) {
            $this->valF['co_fin_aa_nb'] = NULL;
        } else {
            $this->valF['co_fin_aa_nb'] = $val['co_fin_aa_nb'];
        }
        if (!is_numeric($val['co_fin_ptz_nb'])) {
            $this->valF['co_fin_ptz_nb'] = NULL;
        } else {
            $this->valF['co_fin_ptz_nb'] = $val['co_fin_ptz_nb'];
        }
        if (!is_numeric($val['co_fin_autr_nb'])) {
            $this->valF['co_fin_autr_nb'] = NULL;
        } else {
            $this->valF['co_fin_autr_nb'] = $val['co_fin_autr_nb'];
        }
            $this->valF['co_fin_autr_desc'] = $val['co_fin_autr_desc'];
        if ($val['co_mais_contrat_ind'] == 1 || $val['co_mais_contrat_ind'] == "t" || $val['co_mais_contrat_ind'] == "Oui") {
            $this->valF['co_mais_contrat_ind'] = true;
        } else {
            $this->valF['co_mais_contrat_ind'] = false;
        }
        if ($val['co_uti_pers'] == 1 || $val['co_uti_pers'] == "t" || $val['co_uti_pers'] == "Oui") {
            $this->valF['co_uti_pers'] = true;
        } else {
            $this->valF['co_uti_pers'] = false;
        }
        if ($val['co_uti_vente'] == 1 || $val['co_uti_vente'] == "t" || $val['co_uti_vente'] == "Oui") {
            $this->valF['co_uti_vente'] = true;
        } else {
            $this->valF['co_uti_vente'] = false;
        }
        if ($val['co_uti_loc'] == 1 || $val['co_uti_loc'] == "t" || $val['co_uti_loc'] == "Oui") {
            $this->valF['co_uti_loc'] = true;
        } else {
            $this->valF['co_uti_loc'] = false;
        }
        if ($val['co_uti_princ'] == 1 || $val['co_uti_princ'] == "t" || $val['co_uti_princ'] == "Oui") {
            $this->valF['co_uti_princ'] = true;
        } else {
            $this->valF['co_uti_princ'] = false;
        }
        if ($val['co_uti_secon'] == 1 || $val['co_uti_secon'] == "t" || $val['co_uti_secon'] == "Oui") {
            $this->valF['co_uti_secon'] = true;
        } else {
            $this->valF['co_uti_secon'] = false;
        }
        if ($val['co_resid_agees'] == 1 || $val['co_resid_agees'] == "t" || $val['co_resid_agees'] == "Oui") {
            $this->valF['co_resid_agees'] = true;
        } else {
            $this->valF['co_resid_agees'] = false;
        }
        if ($val['co_resid_etud'] == 1 || $val['co_resid_etud'] == "t" || $val['co_resid_etud'] == "Oui") {
            $this->valF['co_resid_etud'] = true;
        } else {
            $this->valF['co_resid_etud'] = false;
        }
        if ($val['co_resid_tourism'] == 1 || $val['co_resid_tourism'] == "t" || $val['co_resid_tourism'] == "Oui") {
            $this->valF['co_resid_tourism'] = true;
        } else {
            $this->valF['co_resid_tourism'] = false;
        }
        if ($val['co_resid_hot_soc'] == 1 || $val['co_resid_hot_soc'] == "t" || $val['co_resid_hot_soc'] == "Oui") {
            $this->valF['co_resid_hot_soc'] = true;
        } else {
            $this->valF['co_resid_hot_soc'] = false;
        }
        if ($val['co_resid_soc'] == 1 || $val['co_resid_soc'] == "t" || $val['co_resid_soc'] == "Oui") {
            $this->valF['co_resid_soc'] = true;
        } else {
            $this->valF['co_resid_soc'] = false;
        }
        if ($val['co_resid_hand'] == 1 || $val['co_resid_hand'] == "t" || $val['co_resid_hand'] == "Oui") {
            $this->valF['co_resid_hand'] = true;
        } else {
            $this->valF['co_resid_hand'] = false;
        }
        if ($val['co_resid_autr'] == 1 || $val['co_resid_autr'] == "t" || $val['co_resid_autr'] == "Oui") {
            $this->valF['co_resid_autr'] = true;
        } else {
            $this->valF['co_resid_autr'] = false;
        }
            $this->valF['co_resid_autr_desc'] = $val['co_resid_autr_desc'];
        if (!is_numeric($val['co_foyer_chamb_nb'])) {
            $this->valF['co_foyer_chamb_nb'] = NULL;
        } else {
            $this->valF['co_foyer_chamb_nb'] = $val['co_foyer_chamb_nb'];
        }
        if (!is_numeric($val['co_log_1p_nb'])) {
            $this->valF['co_log_1p_nb'] = NULL;
        } else {
            $this->valF['co_log_1p_nb'] = $val['co_log_1p_nb'];
        }
        if (!is_numeric($val['co_log_2p_nb'])) {
            $this->valF['co_log_2p_nb'] = NULL;
        } else {
            $this->valF['co_log_2p_nb'] = $val['co_log_2p_nb'];
        }
        if (!is_numeric($val['co_log_3p_nb'])) {
            $this->valF['co_log_3p_nb'] = NULL;
        } else {
            $this->valF['co_log_3p_nb'] = $val['co_log_3p_nb'];
        }
        if (!is_numeric($val['co_log_4p_nb'])) {
            $this->valF['co_log_4p_nb'] = NULL;
        } else {
            $this->valF['co_log_4p_nb'] = $val['co_log_4p_nb'];
        }
        if (!is_numeric($val['co_log_5p_nb'])) {
            $this->valF['co_log_5p_nb'] = NULL;
        } else {
            $this->valF['co_log_5p_nb'] = $val['co_log_5p_nb'];
        }
        if (!is_numeric($val['co_log_6p_nb'])) {
            $this->valF['co_log_6p_nb'] = NULL;
        } else {
            $this->valF['co_log_6p_nb'] = $val['co_log_6p_nb'];
        }
        if (!is_numeric($val['co_bat_niv_nb'])) {
            $this->valF['co_bat_niv_nb'] = NULL;
        } else {
            $this->valF['co_bat_niv_nb'] = $val['co_bat_niv_nb'];
        }
        if ($val['co_trx_exten'] == 1 || $val['co_trx_exten'] == "t" || $val['co_trx_exten'] == "Oui") {
            $this->valF['co_trx_exten'] = true;
        } else {
            $this->valF['co_trx_exten'] = false;
        }
        if ($val['co_trx_surelev'] == 1 || $val['co_trx_surelev'] == "t" || $val['co_trx_surelev'] == "Oui") {
            $this->valF['co_trx_surelev'] = true;
        } else {
            $this->valF['co_trx_surelev'] = false;
        }
        if ($val['co_trx_nivsup'] == 1 || $val['co_trx_nivsup'] == "t" || $val['co_trx_nivsup'] == "Oui") {
            $this->valF['co_trx_nivsup'] = true;
        } else {
            $this->valF['co_trx_nivsup'] = false;
        }
            $this->valF['co_demont_periode'] = $val['co_demont_periode'];
        if ($val['co_sp_transport'] == 1 || $val['co_sp_transport'] == "t" || $val['co_sp_transport'] == "Oui") {
            $this->valF['co_sp_transport'] = true;
        } else {
            $this->valF['co_sp_transport'] = false;
        }
        if ($val['co_sp_enseign'] == 1 || $val['co_sp_enseign'] == "t" || $val['co_sp_enseign'] == "Oui") {
            $this->valF['co_sp_enseign'] = true;
        } else {
            $this->valF['co_sp_enseign'] = false;
        }
        if ($val['co_sp_act_soc'] == 1 || $val['co_sp_act_soc'] == "t" || $val['co_sp_act_soc'] == "Oui") {
            $this->valF['co_sp_act_soc'] = true;
        } else {
            $this->valF['co_sp_act_soc'] = false;
        }
        if ($val['co_sp_ouvr_spe'] == 1 || $val['co_sp_ouvr_spe'] == "t" || $val['co_sp_ouvr_spe'] == "Oui") {
            $this->valF['co_sp_ouvr_spe'] = true;
        } else {
            $this->valF['co_sp_ouvr_spe'] = false;
        }
        if ($val['co_sp_sante'] == 1 || $val['co_sp_sante'] == "t" || $val['co_sp_sante'] == "Oui") {
            $this->valF['co_sp_sante'] = true;
        } else {
            $this->valF['co_sp_sante'] = false;
        }
        if ($val['co_sp_culture'] == 1 || $val['co_sp_culture'] == "t" || $val['co_sp_culture'] == "Oui") {
            $this->valF['co_sp_culture'] = true;
        } else {
            $this->valF['co_sp_culture'] = false;
        }
        if (!is_numeric($val['co_statio_avt_nb'])) {
            $this->valF['co_statio_avt_nb'] = NULL;
        } else {
            $this->valF['co_statio_avt_nb'] = $val['co_statio_avt_nb'];
        }
        if (!is_numeric($val['co_statio_apr_nb'])) {
            $this->valF['co_statio_apr_nb'] = NULL;
        } else {
            $this->valF['co_statio_apr_nb'] = $val['co_statio_apr_nb'];
        }
            $this->valF['co_statio_adr'] = $val['co_statio_adr'];
        if (!is_numeric($val['co_statio_place_nb'])) {
            $this->valF['co_statio_place_nb'] = NULL;
        } else {
            $this->valF['co_statio_place_nb'] = $val['co_statio_place_nb'];
        }
        if (!is_numeric($val['co_statio_tot_surf'])) {
            $this->valF['co_statio_tot_surf'] = NULL;
        } else {
            $this->valF['co_statio_tot_surf'] = $val['co_statio_tot_surf'];
        }
        if (!is_numeric($val['co_statio_tot_shob'])) {
            $this->valF['co_statio_tot_shob'] = NULL;
        } else {
            $this->valF['co_statio_tot_shob'] = $val['co_statio_tot_shob'];
        }
        if (!is_numeric($val['co_statio_comm_cin_surf'])) {
            $this->valF['co_statio_comm_cin_surf'] = NULL;
        } else {
            $this->valF['co_statio_comm_cin_surf'] = $val['co_statio_comm_cin_surf'];
        }
        if (!is_numeric($val['su_avt_shon1'])) {
            $this->valF['su_avt_shon1'] = NULL;
        } else {
            $this->valF['su_avt_shon1'] = $val['su_avt_shon1'];
        }
        if (!is_numeric($val['su_avt_shon2'])) {
            $this->valF['su_avt_shon2'] = NULL;
        } else {
            $this->valF['su_avt_shon2'] = $val['su_avt_shon2'];
        }
        if (!is_numeric($val['su_avt_shon3'])) {
            $this->valF['su_avt_shon3'] = NULL;
        } else {
            $this->valF['su_avt_shon3'] = $val['su_avt_shon3'];
        }
        if (!is_numeric($val['su_avt_shon4'])) {
            $this->valF['su_avt_shon4'] = NULL;
        } else {
            $this->valF['su_avt_shon4'] = $val['su_avt_shon4'];
        }
        if (!is_numeric($val['su_avt_shon5'])) {
            $this->valF['su_avt_shon5'] = NULL;
        } else {
            $this->valF['su_avt_shon5'] = $val['su_avt_shon5'];
        }
        if (!is_numeric($val['su_avt_shon6'])) {
            $this->valF['su_avt_shon6'] = NULL;
        } else {
            $this->valF['su_avt_shon6'] = $val['su_avt_shon6'];
        }
        if (!is_numeric($val['su_avt_shon7'])) {
            $this->valF['su_avt_shon7'] = NULL;
        } else {
            $this->valF['su_avt_shon7'] = $val['su_avt_shon7'];
        }
        if (!is_numeric($val['su_avt_shon8'])) {
            $this->valF['su_avt_shon8'] = NULL;
        } else {
            $this->valF['su_avt_shon8'] = $val['su_avt_shon8'];
        }
        if (!is_numeric($val['su_avt_shon9'])) {
            $this->valF['su_avt_shon9'] = NULL;
        } else {
            $this->valF['su_avt_shon9'] = $val['su_avt_shon9'];
        }
        if (!is_numeric($val['su_cstr_shon1'])) {
            $this->valF['su_cstr_shon1'] = NULL;
        } else {
            $this->valF['su_cstr_shon1'] = $val['su_cstr_shon1'];
        }
        if (!is_numeric($val['su_cstr_shon2'])) {
            $this->valF['su_cstr_shon2'] = NULL;
        } else {
            $this->valF['su_cstr_shon2'] = $val['su_cstr_shon2'];
        }
        if (!is_numeric($val['su_cstr_shon3'])) {
            $this->valF['su_cstr_shon3'] = NULL;
        } else {
            $this->valF['su_cstr_shon3'] = $val['su_cstr_shon3'];
        }
        if (!is_numeric($val['su_cstr_shon4'])) {
            $this->valF['su_cstr_shon4'] = NULL;
        } else {
            $this->valF['su_cstr_shon4'] = $val['su_cstr_shon4'];
        }
        if (!is_numeric($val['su_cstr_shon5'])) {
            $this->valF['su_cstr_shon5'] = NULL;
        } else {
            $this->valF['su_cstr_shon5'] = $val['su_cstr_shon5'];
        }
        if (!is_numeric($val['su_cstr_shon6'])) {
            $this->valF['su_cstr_shon6'] = NULL;
        } else {
            $this->valF['su_cstr_shon6'] = $val['su_cstr_shon6'];
        }
        if (!is_numeric($val['su_cstr_shon7'])) {
            $this->valF['su_cstr_shon7'] = NULL;
        } else {
            $this->valF['su_cstr_shon7'] = $val['su_cstr_shon7'];
        }
        if (!is_numeric($val['su_cstr_shon8'])) {
            $this->valF['su_cstr_shon8'] = NULL;
        } else {
            $this->valF['su_cstr_shon8'] = $val['su_cstr_shon8'];
        }
        if (!is_numeric($val['su_cstr_shon9'])) {
            $this->valF['su_cstr_shon9'] = NULL;
        } else {
            $this->valF['su_cstr_shon9'] = $val['su_cstr_shon9'];
        }
        if (!is_numeric($val['su_trsf_shon1'])) {
            $this->valF['su_trsf_shon1'] = NULL;
        } else {
            $this->valF['su_trsf_shon1'] = $val['su_trsf_shon1'];
        }
        if (!is_numeric($val['su_trsf_shon2'])) {
            $this->valF['su_trsf_shon2'] = NULL;
        } else {
            $this->valF['su_trsf_shon2'] = $val['su_trsf_shon2'];
        }
        if (!is_numeric($val['su_trsf_shon3'])) {
            $this->valF['su_trsf_shon3'] = NULL;
        } else {
            $this->valF['su_trsf_shon3'] = $val['su_trsf_shon3'];
        }
        if (!is_numeric($val['su_trsf_shon4'])) {
            $this->valF['su_trsf_shon4'] = NULL;
        } else {
            $this->valF['su_trsf_shon4'] = $val['su_trsf_shon4'];
        }
        if (!is_numeric($val['su_trsf_shon5'])) {
            $this->valF['su_trsf_shon5'] = NULL;
        } else {
            $this->valF['su_trsf_shon5'] = $val['su_trsf_shon5'];
        }
        if (!is_numeric($val['su_trsf_shon6'])) {
            $this->valF['su_trsf_shon6'] = NULL;
        } else {
            $this->valF['su_trsf_shon6'] = $val['su_trsf_shon6'];
        }
        if (!is_numeric($val['su_trsf_shon7'])) {
            $this->valF['su_trsf_shon7'] = NULL;
        } else {
            $this->valF['su_trsf_shon7'] = $val['su_trsf_shon7'];
        }
        if (!is_numeric($val['su_trsf_shon8'])) {
            $this->valF['su_trsf_shon8'] = NULL;
        } else {
            $this->valF['su_trsf_shon8'] = $val['su_trsf_shon8'];
        }
        if (!is_numeric($val['su_trsf_shon9'])) {
            $this->valF['su_trsf_shon9'] = NULL;
        } else {
            $this->valF['su_trsf_shon9'] = $val['su_trsf_shon9'];
        }
        if (!is_numeric($val['su_chge_shon1'])) {
            $this->valF['su_chge_shon1'] = NULL;
        } else {
            $this->valF['su_chge_shon1'] = $val['su_chge_shon1'];
        }
        if (!is_numeric($val['su_chge_shon2'])) {
            $this->valF['su_chge_shon2'] = NULL;
        } else {
            $this->valF['su_chge_shon2'] = $val['su_chge_shon2'];
        }
        if (!is_numeric($val['su_chge_shon3'])) {
            $this->valF['su_chge_shon3'] = NULL;
        } else {
            $this->valF['su_chge_shon3'] = $val['su_chge_shon3'];
        }
        if (!is_numeric($val['su_chge_shon4'])) {
            $this->valF['su_chge_shon4'] = NULL;
        } else {
            $this->valF['su_chge_shon4'] = $val['su_chge_shon4'];
        }
        if (!is_numeric($val['su_chge_shon5'])) {
            $this->valF['su_chge_shon5'] = NULL;
        } else {
            $this->valF['su_chge_shon5'] = $val['su_chge_shon5'];
        }
        if (!is_numeric($val['su_chge_shon6'])) {
            $this->valF['su_chge_shon6'] = NULL;
        } else {
            $this->valF['su_chge_shon6'] = $val['su_chge_shon6'];
        }
        if (!is_numeric($val['su_chge_shon7'])) {
            $this->valF['su_chge_shon7'] = NULL;
        } else {
            $this->valF['su_chge_shon7'] = $val['su_chge_shon7'];
        }
        if (!is_numeric($val['su_chge_shon8'])) {
            $this->valF['su_chge_shon8'] = NULL;
        } else {
            $this->valF['su_chge_shon8'] = $val['su_chge_shon8'];
        }
        if (!is_numeric($val['su_chge_shon9'])) {
            $this->valF['su_chge_shon9'] = NULL;
        } else {
            $this->valF['su_chge_shon9'] = $val['su_chge_shon9'];
        }
        if (!is_numeric($val['su_demo_shon1'])) {
            $this->valF['su_demo_shon1'] = NULL;
        } else {
            $this->valF['su_demo_shon1'] = $val['su_demo_shon1'];
        }
        if (!is_numeric($val['su_demo_shon2'])) {
            $this->valF['su_demo_shon2'] = NULL;
        } else {
            $this->valF['su_demo_shon2'] = $val['su_demo_shon2'];
        }
        if (!is_numeric($val['su_demo_shon3'])) {
            $this->valF['su_demo_shon3'] = NULL;
        } else {
            $this->valF['su_demo_shon3'] = $val['su_demo_shon3'];
        }
        if (!is_numeric($val['su_demo_shon4'])) {
            $this->valF['su_demo_shon4'] = NULL;
        } else {
            $this->valF['su_demo_shon4'] = $val['su_demo_shon4'];
        }
        if (!is_numeric($val['su_demo_shon5'])) {
            $this->valF['su_demo_shon5'] = NULL;
        } else {
            $this->valF['su_demo_shon5'] = $val['su_demo_shon5'];
        }
        if (!is_numeric($val['su_demo_shon6'])) {
            $this->valF['su_demo_shon6'] = NULL;
        } else {
            $this->valF['su_demo_shon6'] = $val['su_demo_shon6'];
        }
        if (!is_numeric($val['su_demo_shon7'])) {
            $this->valF['su_demo_shon7'] = NULL;
        } else {
            $this->valF['su_demo_shon7'] = $val['su_demo_shon7'];
        }
        if (!is_numeric($val['su_demo_shon8'])) {
            $this->valF['su_demo_shon8'] = NULL;
        } else {
            $this->valF['su_demo_shon8'] = $val['su_demo_shon8'];
        }
        if (!is_numeric($val['su_demo_shon9'])) {
            $this->valF['su_demo_shon9'] = NULL;
        } else {
            $this->valF['su_demo_shon9'] = $val['su_demo_shon9'];
        }
        if (!is_numeric($val['su_sup_shon1'])) {
            $this->valF['su_sup_shon1'] = NULL;
        } else {
            $this->valF['su_sup_shon1'] = $val['su_sup_shon1'];
        }
        if (!is_numeric($val['su_sup_shon2'])) {
            $this->valF['su_sup_shon2'] = NULL;
        } else {
            $this->valF['su_sup_shon2'] = $val['su_sup_shon2'];
        }
        if (!is_numeric($val['su_sup_shon3'])) {
            $this->valF['su_sup_shon3'] = NULL;
        } else {
            $this->valF['su_sup_shon3'] = $val['su_sup_shon3'];
        }
        if (!is_numeric($val['su_sup_shon4'])) {
            $this->valF['su_sup_shon4'] = NULL;
        } else {
            $this->valF['su_sup_shon4'] = $val['su_sup_shon4'];
        }
        if (!is_numeric($val['su_sup_shon5'])) {
            $this->valF['su_sup_shon5'] = NULL;
        } else {
            $this->valF['su_sup_shon5'] = $val['su_sup_shon5'];
        }
        if (!is_numeric($val['su_sup_shon6'])) {
            $this->valF['su_sup_shon6'] = NULL;
        } else {
            $this->valF['su_sup_shon6'] = $val['su_sup_shon6'];
        }
        if (!is_numeric($val['su_sup_shon7'])) {
            $this->valF['su_sup_shon7'] = NULL;
        } else {
            $this->valF['su_sup_shon7'] = $val['su_sup_shon7'];
        }
        if (!is_numeric($val['su_sup_shon8'])) {
            $this->valF['su_sup_shon8'] = NULL;
        } else {
            $this->valF['su_sup_shon8'] = $val['su_sup_shon8'];
        }
        if (!is_numeric($val['su_sup_shon9'])) {
            $this->valF['su_sup_shon9'] = NULL;
        } else {
            $this->valF['su_sup_shon9'] = $val['su_sup_shon9'];
        }
        if (!is_numeric($val['su_tot_shon1'])) {
            $this->valF['su_tot_shon1'] = NULL;
        } else {
            $this->valF['su_tot_shon1'] = $val['su_tot_shon1'];
        }
        if (!is_numeric($val['su_tot_shon2'])) {
            $this->valF['su_tot_shon2'] = NULL;
        } else {
            $this->valF['su_tot_shon2'] = $val['su_tot_shon2'];
        }
        if (!is_numeric($val['su_tot_shon3'])) {
            $this->valF['su_tot_shon3'] = NULL;
        } else {
            $this->valF['su_tot_shon3'] = $val['su_tot_shon3'];
        }
        if (!is_numeric($val['su_tot_shon4'])) {
            $this->valF['su_tot_shon4'] = NULL;
        } else {
            $this->valF['su_tot_shon4'] = $val['su_tot_shon4'];
        }
        if (!is_numeric($val['su_tot_shon5'])) {
            $this->valF['su_tot_shon5'] = NULL;
        } else {
            $this->valF['su_tot_shon5'] = $val['su_tot_shon5'];
        }
        if (!is_numeric($val['su_tot_shon6'])) {
            $this->valF['su_tot_shon6'] = NULL;
        } else {
            $this->valF['su_tot_shon6'] = $val['su_tot_shon6'];
        }
        if (!is_numeric($val['su_tot_shon7'])) {
            $this->valF['su_tot_shon7'] = NULL;
        } else {
            $this->valF['su_tot_shon7'] = $val['su_tot_shon7'];
        }
        if (!is_numeric($val['su_tot_shon8'])) {
            $this->valF['su_tot_shon8'] = NULL;
        } else {
            $this->valF['su_tot_shon8'] = $val['su_tot_shon8'];
        }
        if (!is_numeric($val['su_tot_shon9'])) {
            $this->valF['su_tot_shon9'] = NULL;
        } else {
            $this->valF['su_tot_shon9'] = $val['su_tot_shon9'];
        }
        if (!is_numeric($val['su_avt_shon_tot'])) {
            $this->valF['su_avt_shon_tot'] = NULL;
        } else {
            $this->valF['su_avt_shon_tot'] = $val['su_avt_shon_tot'];
        }
        if (!is_numeric($val['su_cstr_shon_tot'])) {
            $this->valF['su_cstr_shon_tot'] = NULL;
        } else {
            $this->valF['su_cstr_shon_tot'] = $val['su_cstr_shon_tot'];
        }
        if (!is_numeric($val['su_trsf_shon_tot'])) {
            $this->valF['su_trsf_shon_tot'] = NULL;
        } else {
            $this->valF['su_trsf_shon_tot'] = $val['su_trsf_shon_tot'];
        }
        if (!is_numeric($val['su_chge_shon_tot'])) {
            $this->valF['su_chge_shon_tot'] = NULL;
        } else {
            $this->valF['su_chge_shon_tot'] = $val['su_chge_shon_tot'];
        }
        if (!is_numeric($val['su_demo_shon_tot'])) {
            $this->valF['su_demo_shon_tot'] = NULL;
        } else {
            $this->valF['su_demo_shon_tot'] = $val['su_demo_shon_tot'];
        }
        if (!is_numeric($val['su_sup_shon_tot'])) {
            $this->valF['su_sup_shon_tot'] = NULL;
        } else {
            $this->valF['su_sup_shon_tot'] = $val['su_sup_shon_tot'];
        }
        if (!is_numeric($val['su_tot_shon_tot'])) {
            $this->valF['su_tot_shon_tot'] = NULL;
        } else {
            $this->valF['su_tot_shon_tot'] = $val['su_tot_shon_tot'];
        }
            $this->valF['dm_constr_dates'] = $val['dm_constr_dates'];
        if ($val['dm_total'] == 1 || $val['dm_total'] == "t" || $val['dm_total'] == "Oui") {
            $this->valF['dm_total'] = true;
        } else {
            $this->valF['dm_total'] = false;
        }
        if ($val['dm_partiel'] == 1 || $val['dm_partiel'] == "t" || $val['dm_partiel'] == "Oui") {
            $this->valF['dm_partiel'] = true;
        } else {
            $this->valF['dm_partiel'] = false;
        }
            $this->valF['dm_projet_desc'] = $val['dm_projet_desc'];
        if (!is_numeric($val['dm_tot_log_nb'])) {
            $this->valF['dm_tot_log_nb'] = NULL;
        } else {
            $this->valF['dm_tot_log_nb'] = $val['dm_tot_log_nb'];
        }
        if (!is_numeric($val['tax_surf_tot'])) {
            $this->valF['tax_surf_tot'] = NULL;
        } else {
            $this->valF['tax_surf_tot'] = $val['tax_surf_tot'];
        }
        if (!is_numeric($val['tax_surf'])) {
            $this->valF['tax_surf'] = NULL;
        } else {
            $this->valF['tax_surf'] = $val['tax_surf'];
        }
        if (!is_numeric($val['tax_surf_suppr_mod'])) {
            $this->valF['tax_surf_suppr_mod'] = NULL;
        } else {
            $this->valF['tax_surf_suppr_mod'] = $val['tax_surf_suppr_mod'];
        }
        if (!is_numeric($val['tax_su_princ_log_nb1'])) {
            $this->valF['tax_su_princ_log_nb1'] = NULL;
        } else {
            $this->valF['tax_su_princ_log_nb1'] = $val['tax_su_princ_log_nb1'];
        }
        if (!is_numeric($val['tax_su_princ_log_nb2'])) {
            $this->valF['tax_su_princ_log_nb2'] = NULL;
        } else {
            $this->valF['tax_su_princ_log_nb2'] = $val['tax_su_princ_log_nb2'];
        }
        if (!is_numeric($val['tax_su_princ_log_nb3'])) {
            $this->valF['tax_su_princ_log_nb3'] = NULL;
        } else {
            $this->valF['tax_su_princ_log_nb3'] = $val['tax_su_princ_log_nb3'];
        }
        if (!is_numeric($val['tax_su_princ_log_nb4'])) {
            $this->valF['tax_su_princ_log_nb4'] = NULL;
        } else {
            $this->valF['tax_su_princ_log_nb4'] = $val['tax_su_princ_log_nb4'];
        }
        if (!is_numeric($val['tax_su_princ_log_nb_tot1'])) {
            $this->valF['tax_su_princ_log_nb_tot1'] = NULL;
        } else {
            $this->valF['tax_su_princ_log_nb_tot1'] = $val['tax_su_princ_log_nb_tot1'];
        }
        if (!is_numeric($val['tax_su_princ_log_nb_tot2'])) {
            $this->valF['tax_su_princ_log_nb_tot2'] = NULL;
        } else {
            $this->valF['tax_su_princ_log_nb_tot2'] = $val['tax_su_princ_log_nb_tot2'];
        }
        if (!is_numeric($val['tax_su_princ_log_nb_tot3'])) {
            $this->valF['tax_su_princ_log_nb_tot3'] = NULL;
        } else {
            $this->valF['tax_su_princ_log_nb_tot3'] = $val['tax_su_princ_log_nb_tot3'];
        }
        if (!is_numeric($val['tax_su_princ_log_nb_tot4'])) {
            $this->valF['tax_su_princ_log_nb_tot4'] = NULL;
        } else {
            $this->valF['tax_su_princ_log_nb_tot4'] = $val['tax_su_princ_log_nb_tot4'];
        }
        if (!is_numeric($val['tax_su_princ_surf1'])) {
            $this->valF['tax_su_princ_surf1'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf1'] = $val['tax_su_princ_surf1'];
        }
        if (!is_numeric($val['tax_su_princ_surf2'])) {
            $this->valF['tax_su_princ_surf2'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf2'] = $val['tax_su_princ_surf2'];
        }
        if (!is_numeric($val['tax_su_princ_surf3'])) {
            $this->valF['tax_su_princ_surf3'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf3'] = $val['tax_su_princ_surf3'];
        }
        if (!is_numeric($val['tax_su_princ_surf4'])) {
            $this->valF['tax_su_princ_surf4'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf4'] = $val['tax_su_princ_surf4'];
        }
        if (!is_numeric($val['tax_su_princ_surf_sup1'])) {
            $this->valF['tax_su_princ_surf_sup1'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf_sup1'] = $val['tax_su_princ_surf_sup1'];
        }
        if (!is_numeric($val['tax_su_princ_surf_sup2'])) {
            $this->valF['tax_su_princ_surf_sup2'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf_sup2'] = $val['tax_su_princ_surf_sup2'];
        }
        if (!is_numeric($val['tax_su_princ_surf_sup3'])) {
            $this->valF['tax_su_princ_surf_sup3'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf_sup3'] = $val['tax_su_princ_surf_sup3'];
        }
        if (!is_numeric($val['tax_su_princ_surf_sup4'])) {
            $this->valF['tax_su_princ_surf_sup4'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf_sup4'] = $val['tax_su_princ_surf_sup4'];
        }
        if (!is_numeric($val['tax_su_heber_log_nb1'])) {
            $this->valF['tax_su_heber_log_nb1'] = NULL;
        } else {
            $this->valF['tax_su_heber_log_nb1'] = $val['tax_su_heber_log_nb1'];
        }
        if (!is_numeric($val['tax_su_heber_log_nb2'])) {
            $this->valF['tax_su_heber_log_nb2'] = NULL;
        } else {
            $this->valF['tax_su_heber_log_nb2'] = $val['tax_su_heber_log_nb2'];
        }
        if (!is_numeric($val['tax_su_heber_log_nb3'])) {
            $this->valF['tax_su_heber_log_nb3'] = NULL;
        } else {
            $this->valF['tax_su_heber_log_nb3'] = $val['tax_su_heber_log_nb3'];
        }
        if (!is_numeric($val['tax_su_heber_log_nb_tot1'])) {
            $this->valF['tax_su_heber_log_nb_tot1'] = NULL;
        } else {
            $this->valF['tax_su_heber_log_nb_tot1'] = $val['tax_su_heber_log_nb_tot1'];
        }
        if (!is_numeric($val['tax_su_heber_log_nb_tot2'])) {
            $this->valF['tax_su_heber_log_nb_tot2'] = NULL;
        } else {
            $this->valF['tax_su_heber_log_nb_tot2'] = $val['tax_su_heber_log_nb_tot2'];
        }
        if (!is_numeric($val['tax_su_heber_log_nb_tot3'])) {
            $this->valF['tax_su_heber_log_nb_tot3'] = NULL;
        } else {
            $this->valF['tax_su_heber_log_nb_tot3'] = $val['tax_su_heber_log_nb_tot3'];
        }
        if (!is_numeric($val['tax_su_heber_surf1'])) {
            $this->valF['tax_su_heber_surf1'] = NULL;
        } else {
            $this->valF['tax_su_heber_surf1'] = $val['tax_su_heber_surf1'];
        }
        if (!is_numeric($val['tax_su_heber_surf2'])) {
            $this->valF['tax_su_heber_surf2'] = NULL;
        } else {
            $this->valF['tax_su_heber_surf2'] = $val['tax_su_heber_surf2'];
        }
        if (!is_numeric($val['tax_su_heber_surf3'])) {
            $this->valF['tax_su_heber_surf3'] = NULL;
        } else {
            $this->valF['tax_su_heber_surf3'] = $val['tax_su_heber_surf3'];
        }
        if (!is_numeric($val['tax_su_heber_surf_sup1'])) {
            $this->valF['tax_su_heber_surf_sup1'] = NULL;
        } else {
            $this->valF['tax_su_heber_surf_sup1'] = $val['tax_su_heber_surf_sup1'];
        }
        if (!is_numeric($val['tax_su_heber_surf_sup2'])) {
            $this->valF['tax_su_heber_surf_sup2'] = NULL;
        } else {
            $this->valF['tax_su_heber_surf_sup2'] = $val['tax_su_heber_surf_sup2'];
        }
        if (!is_numeric($val['tax_su_heber_surf_sup3'])) {
            $this->valF['tax_su_heber_surf_sup3'] = NULL;
        } else {
            $this->valF['tax_su_heber_surf_sup3'] = $val['tax_su_heber_surf_sup3'];
        }
        if (!is_numeric($val['tax_su_secon_log_nb'])) {
            $this->valF['tax_su_secon_log_nb'] = NULL;
        } else {
            $this->valF['tax_su_secon_log_nb'] = $val['tax_su_secon_log_nb'];
        }
        if (!is_numeric($val['tax_su_tot_log_nb'])) {
            $this->valF['tax_su_tot_log_nb'] = NULL;
        } else {
            $this->valF['tax_su_tot_log_nb'] = $val['tax_su_tot_log_nb'];
        }
        if (!is_numeric($val['tax_su_secon_log_nb_tot'])) {
            $this->valF['tax_su_secon_log_nb_tot'] = NULL;
        } else {
            $this->valF['tax_su_secon_log_nb_tot'] = $val['tax_su_secon_log_nb_tot'];
        }
        if (!is_numeric($val['tax_su_tot_log_nb_tot'])) {
            $this->valF['tax_su_tot_log_nb_tot'] = NULL;
        } else {
            $this->valF['tax_su_tot_log_nb_tot'] = $val['tax_su_tot_log_nb_tot'];
        }
        if (!is_numeric($val['tax_su_secon_surf'])) {
            $this->valF['tax_su_secon_surf'] = NULL;
        } else {
            $this->valF['tax_su_secon_surf'] = $val['tax_su_secon_surf'];
        }
        if (!is_numeric($val['tax_su_tot_surf'])) {
            $this->valF['tax_su_tot_surf'] = NULL;
        } else {
            $this->valF['tax_su_tot_surf'] = $val['tax_su_tot_surf'];
        }
        if (!is_numeric($val['tax_su_secon_surf_sup'])) {
            $this->valF['tax_su_secon_surf_sup'] = NULL;
        } else {
            $this->valF['tax_su_secon_surf_sup'] = $val['tax_su_secon_surf_sup'];
        }
        if (!is_numeric($val['tax_su_tot_surf_sup'])) {
            $this->valF['tax_su_tot_surf_sup'] = NULL;
        } else {
            $this->valF['tax_su_tot_surf_sup'] = $val['tax_su_tot_surf_sup'];
        }
        if ($val['tax_ext_pret'] == 1 || $val['tax_ext_pret'] == "t" || $val['tax_ext_pret'] == "Oui") {
            $this->valF['tax_ext_pret'] = true;
        } else {
            $this->valF['tax_ext_pret'] = false;
        }
            $this->valF['tax_ext_desc'] = $val['tax_ext_desc'];
        if (!is_numeric($val['tax_surf_tax_exist_cons'])) {
            $this->valF['tax_surf_tax_exist_cons'] = NULL;
        } else {
            $this->valF['tax_surf_tax_exist_cons'] = $val['tax_surf_tax_exist_cons'];
        }
        if (!is_numeric($val['tax_log_exist_nb'])) {
            $this->valF['tax_log_exist_nb'] = NULL;
        } else {
            $this->valF['tax_log_exist_nb'] = $val['tax_log_exist_nb'];
        }
        if (!is_numeric($val['tax_am_statio_ext'])) {
            $this->valF['tax_am_statio_ext'] = NULL;
        } else {
            $this->valF['tax_am_statio_ext'] = $val['tax_am_statio_ext'];
        }
        if (!is_numeric($val['tax_sup_bass_pisc'])) {
            $this->valF['tax_sup_bass_pisc'] = NULL;
        } else {
            $this->valF['tax_sup_bass_pisc'] = $val['tax_sup_bass_pisc'];
        }
        if (!is_numeric($val['tax_empl_ten_carav_mobil_nb'])) {
            $this->valF['tax_empl_ten_carav_mobil_nb'] = NULL;
        } else {
            $this->valF['tax_empl_ten_carav_mobil_nb'] = $val['tax_empl_ten_carav_mobil_nb'];
        }
        if (!is_numeric($val['tax_empl_hll_nb'])) {
            $this->valF['tax_empl_hll_nb'] = NULL;
        } else {
            $this->valF['tax_empl_hll_nb'] = $val['tax_empl_hll_nb'];
        }
        if (!is_numeric($val['tax_eol_haut_nb'])) {
            $this->valF['tax_eol_haut_nb'] = NULL;
        } else {
            $this->valF['tax_eol_haut_nb'] = $val['tax_eol_haut_nb'];
        }
        if (!is_numeric($val['tax_pann_volt_sup'])) {
            $this->valF['tax_pann_volt_sup'] = NULL;
        } else {
            $this->valF['tax_pann_volt_sup'] = $val['tax_pann_volt_sup'];
        }
        if (!is_numeric($val['tax_am_statio_ext_sup'])) {
            $this->valF['tax_am_statio_ext_sup'] = NULL;
        } else {
            $this->valF['tax_am_statio_ext_sup'] = $val['tax_am_statio_ext_sup'];
        }
        if (!is_numeric($val['tax_sup_bass_pisc_sup'])) {
            $this->valF['tax_sup_bass_pisc_sup'] = NULL;
        } else {
            $this->valF['tax_sup_bass_pisc_sup'] = $val['tax_sup_bass_pisc_sup'];
        }
        if (!is_numeric($val['tax_empl_ten_carav_mobil_nb_sup'])) {
            $this->valF['tax_empl_ten_carav_mobil_nb_sup'] = NULL;
        } else {
            $this->valF['tax_empl_ten_carav_mobil_nb_sup'] = $val['tax_empl_ten_carav_mobil_nb_sup'];
        }
        if (!is_numeric($val['tax_empl_hll_nb_sup'])) {
            $this->valF['tax_empl_hll_nb_sup'] = NULL;
        } else {
            $this->valF['tax_empl_hll_nb_sup'] = $val['tax_empl_hll_nb_sup'];
        }
        if (!is_numeric($val['tax_eol_haut_nb_sup'])) {
            $this->valF['tax_eol_haut_nb_sup'] = NULL;
        } else {
            $this->valF['tax_eol_haut_nb_sup'] = $val['tax_eol_haut_nb_sup'];
        }
        if (!is_numeric($val['tax_pann_volt_sup_sup'])) {
            $this->valF['tax_pann_volt_sup_sup'] = NULL;
        } else {
            $this->valF['tax_pann_volt_sup_sup'] = $val['tax_pann_volt_sup_sup'];
        }
        if ($val['tax_trx_presc_ppr'] == 1 || $val['tax_trx_presc_ppr'] == "t" || $val['tax_trx_presc_ppr'] == "Oui") {
            $this->valF['tax_trx_presc_ppr'] = true;
        } else {
            $this->valF['tax_trx_presc_ppr'] = false;
        }
        if ($val['tax_monu_hist'] == 1 || $val['tax_monu_hist'] == "t" || $val['tax_monu_hist'] == "Oui") {
            $this->valF['tax_monu_hist'] = true;
        } else {
            $this->valF['tax_monu_hist'] = false;
        }
        if (!is_numeric($val['tax_comm_nb'])) {
            $this->valF['tax_comm_nb'] = NULL;
        } else {
            $this->valF['tax_comm_nb'] = $val['tax_comm_nb'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf1'])) {
            $this->valF['tax_su_non_habit_surf1'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf1'] = $val['tax_su_non_habit_surf1'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf2'])) {
            $this->valF['tax_su_non_habit_surf2'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf2'] = $val['tax_su_non_habit_surf2'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf3'])) {
            $this->valF['tax_su_non_habit_surf3'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf3'] = $val['tax_su_non_habit_surf3'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf4'])) {
            $this->valF['tax_su_non_habit_surf4'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf4'] = $val['tax_su_non_habit_surf4'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf5'])) {
            $this->valF['tax_su_non_habit_surf5'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf5'] = $val['tax_su_non_habit_surf5'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf6'])) {
            $this->valF['tax_su_non_habit_surf6'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf6'] = $val['tax_su_non_habit_surf6'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf7'])) {
            $this->valF['tax_su_non_habit_surf7'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf7'] = $val['tax_su_non_habit_surf7'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_sup1'])) {
            $this->valF['tax_su_non_habit_surf_sup1'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_sup1'] = $val['tax_su_non_habit_surf_sup1'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_sup2'])) {
            $this->valF['tax_su_non_habit_surf_sup2'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_sup2'] = $val['tax_su_non_habit_surf_sup2'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_sup3'])) {
            $this->valF['tax_su_non_habit_surf_sup3'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_sup3'] = $val['tax_su_non_habit_surf_sup3'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_sup4'])) {
            $this->valF['tax_su_non_habit_surf_sup4'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_sup4'] = $val['tax_su_non_habit_surf_sup4'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_sup5'])) {
            $this->valF['tax_su_non_habit_surf_sup5'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_sup5'] = $val['tax_su_non_habit_surf_sup5'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_sup6'])) {
            $this->valF['tax_su_non_habit_surf_sup6'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_sup6'] = $val['tax_su_non_habit_surf_sup6'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_sup7'])) {
            $this->valF['tax_su_non_habit_surf_sup7'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_sup7'] = $val['tax_su_non_habit_surf_sup7'];
        }
        if ($val['vsd_surf_planch_smd'] == 1 || $val['vsd_surf_planch_smd'] == "t" || $val['vsd_surf_planch_smd'] == "Oui") {
            $this->valF['vsd_surf_planch_smd'] = true;
        } else {
            $this->valF['vsd_surf_planch_smd'] = false;
        }
        if (!is_numeric($val['vsd_unit_fonc_sup'])) {
            $this->valF['vsd_unit_fonc_sup'] = NULL;
        } else {
            $this->valF['vsd_unit_fonc_sup'] = $val['vsd_unit_fonc_sup'];
        }
        if (!is_numeric($val['vsd_unit_fonc_constr_sup'])) {
            $this->valF['vsd_unit_fonc_constr_sup'] = NULL;
        } else {
            $this->valF['vsd_unit_fonc_constr_sup'] = $val['vsd_unit_fonc_constr_sup'];
        }
        if (!is_numeric($val['vsd_val_terr'])) {
            $this->valF['vsd_val_terr'] = NULL;
        } else {
            $this->valF['vsd_val_terr'] = $val['vsd_val_terr'];
        }
        if (!is_numeric($val['vsd_const_sxist_non_dem_surf'])) {
            $this->valF['vsd_const_sxist_non_dem_surf'] = NULL;
        } else {
            $this->valF['vsd_const_sxist_non_dem_surf'] = $val['vsd_const_sxist_non_dem_surf'];
        }
        if ($val['vsd_rescr_fisc'] != "") {
            $this->valF['vsd_rescr_fisc'] = $this->dateDB($val['vsd_rescr_fisc']);
        } else {
            $this->valF['vsd_rescr_fisc'] = NULL;
        }
        if (!is_numeric($val['pld_val_terr'])) {
            $this->valF['pld_val_terr'] = NULL;
        } else {
            $this->valF['pld_val_terr'] = $val['pld_val_terr'];
        }
        if ($val['pld_const_exist_dem'] == 1 || $val['pld_const_exist_dem'] == "t" || $val['pld_const_exist_dem'] == "Oui") {
            $this->valF['pld_const_exist_dem'] = true;
        } else {
            $this->valF['pld_const_exist_dem'] = false;
        }
        if (!is_numeric($val['pld_const_exist_dem_surf'])) {
            $this->valF['pld_const_exist_dem_surf'] = NULL;
        } else {
            $this->valF['pld_const_exist_dem_surf'] = $val['pld_const_exist_dem_surf'];
        }
        if ($val['code_cnil'] == 1 || $val['code_cnil'] == "t" || $val['code_cnil'] == "Oui") {
            $this->valF['code_cnil'] = true;
        } else {
            $this->valF['code_cnil'] = false;
        }
        if ($val['terr_juri_titul'] == "") {
            $this->valF['terr_juri_titul'] = NULL;
        } else {
            $this->valF['terr_juri_titul'] = $val['terr_juri_titul'];
        }
        if ($val['terr_juri_lot'] == "") {
            $this->valF['terr_juri_lot'] = NULL;
        } else {
            $this->valF['terr_juri_lot'] = $val['terr_juri_lot'];
        }
        if ($val['terr_juri_zac'] == "") {
            $this->valF['terr_juri_zac'] = NULL;
        } else {
            $this->valF['terr_juri_zac'] = $val['terr_juri_zac'];
        }
        if ($val['terr_juri_afu'] == "") {
            $this->valF['terr_juri_afu'] = NULL;
        } else {
            $this->valF['terr_juri_afu'] = $val['terr_juri_afu'];
        }
        if ($val['terr_juri_pup'] == "") {
            $this->valF['terr_juri_pup'] = NULL;
        } else {
            $this->valF['terr_juri_pup'] = $val['terr_juri_pup'];
        }
        if ($val['terr_juri_oin'] == "") {
            $this->valF['terr_juri_oin'] = NULL;
        } else {
            $this->valF['terr_juri_oin'] = $val['terr_juri_oin'];
        }
            $this->valF['terr_juri_desc'] = $val['terr_juri_desc'];
        if (!is_numeric($val['terr_div_surf_etab'])) {
            $this->valF['terr_div_surf_etab'] = NULL;
        } else {
            $this->valF['terr_div_surf_etab'] = $val['terr_div_surf_etab'];
        }
        if (!is_numeric($val['terr_div_surf_av_div'])) {
            $this->valF['terr_div_surf_av_div'] = NULL;
        } else {
            $this->valF['terr_div_surf_av_div'] = $val['terr_div_surf_av_div'];
        }
        if ($val['doc_date'] != "") {
            $this->valF['doc_date'] = $this->dateDB($val['doc_date']);
        } else {
            $this->valF['doc_date'] = NULL;
        }
        if ($val['doc_tot_trav'] == 1 || $val['doc_tot_trav'] == "t" || $val['doc_tot_trav'] == "Oui") {
            $this->valF['doc_tot_trav'] = true;
        } else {
            $this->valF['doc_tot_trav'] = false;
        }
        if ($val['doc_tranche_trav'] == 1 || $val['doc_tranche_trav'] == "t" || $val['doc_tranche_trav'] == "Oui") {
            $this->valF['doc_tranche_trav'] = true;
        } else {
            $this->valF['doc_tranche_trav'] = false;
        }
            $this->valF['doc_tranche_trav_desc'] = $val['doc_tranche_trav_desc'];
        if (!is_numeric($val['doc_surf'])) {
            $this->valF['doc_surf'] = NULL;
        } else {
            $this->valF['doc_surf'] = $val['doc_surf'];
        }
        if (!is_numeric($val['doc_nb_log'])) {
            $this->valF['doc_nb_log'] = NULL;
        } else {
            $this->valF['doc_nb_log'] = $val['doc_nb_log'];
        }
        if (!is_numeric($val['doc_nb_log_indiv'])) {
            $this->valF['doc_nb_log_indiv'] = NULL;
        } else {
            $this->valF['doc_nb_log_indiv'] = $val['doc_nb_log_indiv'];
        }
        if (!is_numeric($val['doc_nb_log_coll'])) {
            $this->valF['doc_nb_log_coll'] = NULL;
        } else {
            $this->valF['doc_nb_log_coll'] = $val['doc_nb_log_coll'];
        }
        if (!is_numeric($val['doc_nb_log_lls'])) {
            $this->valF['doc_nb_log_lls'] = NULL;
        } else {
            $this->valF['doc_nb_log_lls'] = $val['doc_nb_log_lls'];
        }
        if (!is_numeric($val['doc_nb_log_aa'])) {
            $this->valF['doc_nb_log_aa'] = NULL;
        } else {
            $this->valF['doc_nb_log_aa'] = $val['doc_nb_log_aa'];
        }
        if (!is_numeric($val['doc_nb_log_ptz'])) {
            $this->valF['doc_nb_log_ptz'] = NULL;
        } else {
            $this->valF['doc_nb_log_ptz'] = $val['doc_nb_log_ptz'];
        }
        if (!is_numeric($val['doc_nb_log_autre'])) {
            $this->valF['doc_nb_log_autre'] = NULL;
        } else {
            $this->valF['doc_nb_log_autre'] = $val['doc_nb_log_autre'];
        }
        if ($val['daact_date'] != "") {
            $this->valF['daact_date'] = $this->dateDB($val['daact_date']);
        } else {
            $this->valF['daact_date'] = NULL;
        }
        if ($val['daact_date_chgmt_dest'] != "") {
            $this->valF['daact_date_chgmt_dest'] = $this->dateDB($val['daact_date_chgmt_dest']);
        } else {
            $this->valF['daact_date_chgmt_dest'] = NULL;
        }
        if ($val['daact_tot_trav'] == 1 || $val['daact_tot_trav'] == "t" || $val['daact_tot_trav'] == "Oui") {
            $this->valF['daact_tot_trav'] = true;
        } else {
            $this->valF['daact_tot_trav'] = false;
        }
        if ($val['daact_tranche_trav'] == 1 || $val['daact_tranche_trav'] == "t" || $val['daact_tranche_trav'] == "Oui") {
            $this->valF['daact_tranche_trav'] = true;
        } else {
            $this->valF['daact_tranche_trav'] = false;
        }
            $this->valF['daact_tranche_trav_desc'] = $val['daact_tranche_trav_desc'];
        if (!is_numeric($val['daact_surf'])) {
            $this->valF['daact_surf'] = NULL;
        } else {
            $this->valF['daact_surf'] = $val['daact_surf'];
        }
        if (!is_numeric($val['daact_nb_log'])) {
            $this->valF['daact_nb_log'] = NULL;
        } else {
            $this->valF['daact_nb_log'] = $val['daact_nb_log'];
        }
        if (!is_numeric($val['daact_nb_log_indiv'])) {
            $this->valF['daact_nb_log_indiv'] = NULL;
        } else {
            $this->valF['daact_nb_log_indiv'] = $val['daact_nb_log_indiv'];
        }
        if (!is_numeric($val['daact_nb_log_coll'])) {
            $this->valF['daact_nb_log_coll'] = NULL;
        } else {
            $this->valF['daact_nb_log_coll'] = $val['daact_nb_log_coll'];
        }
        if (!is_numeric($val['daact_nb_log_lls'])) {
            $this->valF['daact_nb_log_lls'] = NULL;
        } else {
            $this->valF['daact_nb_log_lls'] = $val['daact_nb_log_lls'];
        }
        if (!is_numeric($val['daact_nb_log_aa'])) {
            $this->valF['daact_nb_log_aa'] = NULL;
        } else {
            $this->valF['daact_nb_log_aa'] = $val['daact_nb_log_aa'];
        }
        if (!is_numeric($val['daact_nb_log_ptz'])) {
            $this->valF['daact_nb_log_ptz'] = NULL;
        } else {
            $this->valF['daact_nb_log_ptz'] = $val['daact_nb_log_ptz'];
        }
        if (!is_numeric($val['daact_nb_log_autre'])) {
            $this->valF['daact_nb_log_autre'] = NULL;
        } else {
            $this->valF['daact_nb_log_autre'] = $val['daact_nb_log_autre'];
        }
        if ($val['dossier_autorisation'] == "") {
            $this->valF['dossier_autorisation'] = NULL;
        } else {
            $this->valF['dossier_autorisation'] = $val['dossier_autorisation'];
        }
        if ($val['am_div_mun'] == 1 || $val['am_div_mun'] == "t" || $val['am_div_mun'] == "Oui") {
            $this->valF['am_div_mun'] = true;
        } else {
            $this->valF['am_div_mun'] = false;
        }
        if ($val['co_perf_energ'] == "") {
            $this->valF['co_perf_energ'] = NULL;
        } else {
            $this->valF['co_perf_energ'] = $val['co_perf_energ'];
        }
        if (!is_numeric($val['architecte'])) {
            $this->valF['architecte'] = NULL;
        } else {
            $this->valF['architecte'] = $val['architecte'];
        }
        if ($val['co_statio_avt_shob'] == "") {
            $this->valF['co_statio_avt_shob'] = NULL;
        } else {
            $this->valF['co_statio_avt_shob'] = $val['co_statio_avt_shob'];
        }
        if ($val['co_statio_apr_shob'] == "") {
            $this->valF['co_statio_apr_shob'] = NULL;
        } else {
            $this->valF['co_statio_apr_shob'] = $val['co_statio_apr_shob'];
        }
        if ($val['co_statio_avt_surf'] == "") {
            $this->valF['co_statio_avt_surf'] = NULL;
        } else {
            $this->valF['co_statio_avt_surf'] = $val['co_statio_avt_surf'];
        }
        if ($val['co_statio_apr_surf'] == "") {
            $this->valF['co_statio_apr_surf'] = NULL;
        } else {
            $this->valF['co_statio_apr_surf'] = $val['co_statio_apr_surf'];
        }
        if ($val['co_trx_amgt'] == "") {
            $this->valF['co_trx_amgt'] = NULL;
        } else {
            $this->valF['co_trx_amgt'] = $val['co_trx_amgt'];
        }
        if ($val['co_modif_aspect'] == "") {
            $this->valF['co_modif_aspect'] = NULL;
        } else {
            $this->valF['co_modif_aspect'] = $val['co_modif_aspect'];
        }
        if ($val['co_modif_struct'] == "") {
            $this->valF['co_modif_struct'] = NULL;
        } else {
            $this->valF['co_modif_struct'] = $val['co_modif_struct'];
        }
        if ($val['co_ouvr_elec'] == 1 || $val['co_ouvr_elec'] == "t" || $val['co_ouvr_elec'] == "Oui") {
            $this->valF['co_ouvr_elec'] = true;
        } else {
            $this->valF['co_ouvr_elec'] = false;
        }
        if ($val['co_ouvr_infra'] == 1 || $val['co_ouvr_infra'] == "t" || $val['co_ouvr_infra'] == "Oui") {
            $this->valF['co_ouvr_infra'] = true;
        } else {
            $this->valF['co_ouvr_infra'] = false;
        }
        if ($val['co_trx_imm'] == "") {
            $this->valF['co_trx_imm'] = NULL;
        } else {
            $this->valF['co_trx_imm'] = $val['co_trx_imm'];
        }
        if ($val['co_cstr_shob'] == "") {
            $this->valF['co_cstr_shob'] = NULL;
        } else {
            $this->valF['co_cstr_shob'] = $val['co_cstr_shob'];
        }
        if ($val['am_voyage_deb'] == "") {
            $this->valF['am_voyage_deb'] = NULL;
        } else {
            $this->valF['am_voyage_deb'] = $val['am_voyage_deb'];
        }
        if ($val['am_voyage_fin'] == "") {
            $this->valF['am_voyage_fin'] = NULL;
        } else {
            $this->valF['am_voyage_fin'] = $val['am_voyage_fin'];
        }
        if ($val['am_modif_amgt'] == "") {
            $this->valF['am_modif_amgt'] = NULL;
        } else {
            $this->valF['am_modif_amgt'] = $val['am_modif_amgt'];
        }
        if ($val['am_lot_max_shob'] == "") {
            $this->valF['am_lot_max_shob'] = NULL;
        } else {
            $this->valF['am_lot_max_shob'] = $val['am_lot_max_shob'];
        }
        if ($val['mod_desc'] == "") {
            $this->valF['mod_desc'] = NULL;
        } else {
            $this->valF['mod_desc'] = $val['mod_desc'];
        }
        if ($val['tr_total'] == "") {
            $this->valF['tr_total'] = NULL;
        } else {
            $this->valF['tr_total'] = $val['tr_total'];
        }
        if ($val['tr_partiel'] == "") {
            $this->valF['tr_partiel'] = NULL;
        } else {
            $this->valF['tr_partiel'] = $val['tr_partiel'];
        }
        if ($val['tr_desc'] == "") {
            $this->valF['tr_desc'] = NULL;
        } else {
            $this->valF['tr_desc'] = $val['tr_desc'];
        }
        if ($val['avap_co_elt_pro'] == 1 || $val['avap_co_elt_pro'] == "t" || $val['avap_co_elt_pro'] == "Oui") {
            $this->valF['avap_co_elt_pro'] = true;
        } else {
            $this->valF['avap_co_elt_pro'] = false;
        }
        if ($val['avap_nouv_haut_surf'] == 1 || $val['avap_nouv_haut_surf'] == "t" || $val['avap_nouv_haut_surf'] == "Oui") {
            $this->valF['avap_nouv_haut_surf'] = true;
        } else {
            $this->valF['avap_nouv_haut_surf'] = false;
        }
        if ($val['avap_co_clot'] == "") {
            $this->valF['avap_co_clot'] = NULL;
        } else {
            $this->valF['avap_co_clot'] = $val['avap_co_clot'];
        }
        if ($val['avap_aut_coup_aba_arb'] == "") {
            $this->valF['avap_aut_coup_aba_arb'] = NULL;
        } else {
            $this->valF['avap_aut_coup_aba_arb'] = $val['avap_aut_coup_aba_arb'];
        }
        if ($val['avap_ouv_infra'] == "") {
            $this->valF['avap_ouv_infra'] = NULL;
        } else {
            $this->valF['avap_ouv_infra'] = $val['avap_ouv_infra'];
        }
        if ($val['avap_aut_inst_mob'] == "") {
            $this->valF['avap_aut_inst_mob'] = NULL;
        } else {
            $this->valF['avap_aut_inst_mob'] = $val['avap_aut_inst_mob'];
        }
        if ($val['avap_aut_plant'] == "") {
            $this->valF['avap_aut_plant'] = NULL;
        } else {
            $this->valF['avap_aut_plant'] = $val['avap_aut_plant'];
        }
        if ($val['avap_aut_auv_elec'] == "") {
            $this->valF['avap_aut_auv_elec'] = NULL;
        } else {
            $this->valF['avap_aut_auv_elec'] = $val['avap_aut_auv_elec'];
        }
        if ($val['tax_dest_loc_tr'] == "") {
            $this->valF['tax_dest_loc_tr'] = NULL;
        } else {
            $this->valF['tax_dest_loc_tr'] = $val['tax_dest_loc_tr'];
        }
            $this->valF['ope_proj_desc'] = $val['ope_proj_desc'];
        if (!is_numeric($val['tax_surf_tot_cstr'])) {
            $this->valF['tax_surf_tot_cstr'] = NULL;
        } else {
            $this->valF['tax_surf_tot_cstr'] = $val['tax_surf_tot_cstr'];
        }
        if (!is_numeric($val['cerfa'])) {
            $this->valF['cerfa'] = ""; // -> requis
        } else {
            $this->valF['cerfa'] = $val['cerfa'];
        }
        if (!is_numeric($val['tax_surf_loc_stat'])) {
            $this->valF['tax_surf_loc_stat'] = NULL;
        } else {
            $this->valF['tax_surf_loc_stat'] = $val['tax_surf_loc_stat'];
        }
        if (!is_numeric($val['tax_su_princ_surf_stat1'])) {
            $this->valF['tax_su_princ_surf_stat1'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf_stat1'] = $val['tax_su_princ_surf_stat1'];
        }
        if (!is_numeric($val['tax_su_princ_surf_stat2'])) {
            $this->valF['tax_su_princ_surf_stat2'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf_stat2'] = $val['tax_su_princ_surf_stat2'];
        }
        if (!is_numeric($val['tax_su_princ_surf_stat3'])) {
            $this->valF['tax_su_princ_surf_stat3'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf_stat3'] = $val['tax_su_princ_surf_stat3'];
        }
        if (!is_numeric($val['tax_su_princ_surf_stat4'])) {
            $this->valF['tax_su_princ_surf_stat4'] = NULL;
        } else {
            $this->valF['tax_su_princ_surf_stat4'] = $val['tax_su_princ_surf_stat4'];
        }
        if (!is_numeric($val['tax_su_secon_surf_stat'])) {
            $this->valF['tax_su_secon_surf_stat'] = NULL;
        } else {
            $this->valF['tax_su_secon_surf_stat'] = $val['tax_su_secon_surf_stat'];
        }
        if (!is_numeric($val['tax_su_heber_surf_stat1'])) {
            $this->valF['tax_su_heber_surf_stat1'] = NULL;
        } else {
            $this->valF['tax_su_heber_surf_stat1'] = $val['tax_su_heber_surf_stat1'];
        }
        if (!is_numeric($val['tax_su_heber_surf_stat2'])) {
            $this->valF['tax_su_heber_surf_stat2'] = NULL;
        } else {
            $this->valF['tax_su_heber_surf_stat2'] = $val['tax_su_heber_surf_stat2'];
        }
        if (!is_numeric($val['tax_su_heber_surf_stat3'])) {
            $this->valF['tax_su_heber_surf_stat3'] = NULL;
        } else {
            $this->valF['tax_su_heber_surf_stat3'] = $val['tax_su_heber_surf_stat3'];
        }
        if (!is_numeric($val['tax_su_tot_surf_stat'])) {
            $this->valF['tax_su_tot_surf_stat'] = NULL;
        } else {
            $this->valF['tax_su_tot_surf_stat'] = $val['tax_su_tot_surf_stat'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_stat1'])) {
            $this->valF['tax_su_non_habit_surf_stat1'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_stat1'] = $val['tax_su_non_habit_surf_stat1'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_stat2'])) {
            $this->valF['tax_su_non_habit_surf_stat2'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_stat2'] = $val['tax_su_non_habit_surf_stat2'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_stat3'])) {
            $this->valF['tax_su_non_habit_surf_stat3'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_stat3'] = $val['tax_su_non_habit_surf_stat3'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_stat4'])) {
            $this->valF['tax_su_non_habit_surf_stat4'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_stat4'] = $val['tax_su_non_habit_surf_stat4'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_stat5'])) {
            $this->valF['tax_su_non_habit_surf_stat5'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_stat5'] = $val['tax_su_non_habit_surf_stat5'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_stat6'])) {
            $this->valF['tax_su_non_habit_surf_stat6'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_stat6'] = $val['tax_su_non_habit_surf_stat6'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_stat7'])) {
            $this->valF['tax_su_non_habit_surf_stat7'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_stat7'] = $val['tax_su_non_habit_surf_stat7'];
        }
        if (!is_numeric($val['tax_su_parc_statio_expl_comm_surf'])) {
            $this->valF['tax_su_parc_statio_expl_comm_surf'] = NULL;
        } else {
            $this->valF['tax_su_parc_statio_expl_comm_surf'] = $val['tax_su_parc_statio_expl_comm_surf'];
        }
        if (!is_numeric($val['tax_log_ap_trvx_nb'])) {
            $this->valF['tax_log_ap_trvx_nb'] = NULL;
        } else {
            $this->valF['tax_log_ap_trvx_nb'] = $val['tax_log_ap_trvx_nb'];
        }
        if (!is_numeric($val['tax_am_statio_ext_cr'])) {
            $this->valF['tax_am_statio_ext_cr'] = NULL;
        } else {
            $this->valF['tax_am_statio_ext_cr'] = $val['tax_am_statio_ext_cr'];
        }
        if (!is_numeric($val['tax_sup_bass_pisc_cr'])) {
            $this->valF['tax_sup_bass_pisc_cr'] = NULL;
        } else {
            $this->valF['tax_sup_bass_pisc_cr'] = $val['tax_sup_bass_pisc_cr'];
        }
        if (!is_numeric($val['tax_empl_ten_carav_mobil_nb_cr'])) {
            $this->valF['tax_empl_ten_carav_mobil_nb_cr'] = NULL;
        } else {
            $this->valF['tax_empl_ten_carav_mobil_nb_cr'] = $val['tax_empl_ten_carav_mobil_nb_cr'];
        }
        if (!is_numeric($val['tax_empl_hll_nb_cr'])) {
            $this->valF['tax_empl_hll_nb_cr'] = NULL;
        } else {
            $this->valF['tax_empl_hll_nb_cr'] = $val['tax_empl_hll_nb_cr'];
        }
        if (!is_numeric($val['tax_eol_haut_nb_cr'])) {
            $this->valF['tax_eol_haut_nb_cr'] = NULL;
        } else {
            $this->valF['tax_eol_haut_nb_cr'] = $val['tax_eol_haut_nb_cr'];
        }
        if (!is_numeric($val['tax_pann_volt_sup_cr'])) {
            $this->valF['tax_pann_volt_sup_cr'] = NULL;
        } else {
            $this->valF['tax_pann_volt_sup_cr'] = $val['tax_pann_volt_sup_cr'];
        }
        if (!is_numeric($val['tax_surf_loc_arch'])) {
            $this->valF['tax_surf_loc_arch'] = NULL;
        } else {
            $this->valF['tax_surf_loc_arch'] = $val['tax_surf_loc_arch'];
        }
        if (!is_numeric($val['tax_surf_pisc_arch'])) {
            $this->valF['tax_surf_pisc_arch'] = NULL;
        } else {
            $this->valF['tax_surf_pisc_arch'] = $val['tax_surf_pisc_arch'];
        }
        if (!is_numeric($val['tax_am_statio_ext_arch'])) {
            $this->valF['tax_am_statio_ext_arch'] = NULL;
        } else {
            $this->valF['tax_am_statio_ext_arch'] = $val['tax_am_statio_ext_arch'];
        }
        if (!is_numeric($val['tax_empl_ten_carav_mobil_nb_arch'])) {
            $this->valF['tax_empl_ten_carav_mobil_nb_arch'] = NULL;
        } else {
            $this->valF['tax_empl_ten_carav_mobil_nb_arch'] = $val['tax_empl_ten_carav_mobil_nb_arch'];
        }
        if (!is_numeric($val['tax_empl_hll_nb_arch'])) {
            $this->valF['tax_empl_hll_nb_arch'] = NULL;
        } else {
            $this->valF['tax_empl_hll_nb_arch'] = $val['tax_empl_hll_nb_arch'];
        }
        if (!is_numeric($val['tax_eol_haut_nb_arch'])) {
            $this->valF['tax_eol_haut_nb_arch'] = NULL;
        } else {
            $this->valF['tax_eol_haut_nb_arch'] = $val['tax_eol_haut_nb_arch'];
        }
        if ($val['ope_proj_div_co'] == 1 || $val['ope_proj_div_co'] == "t" || $val['ope_proj_div_co'] == "Oui") {
            $this->valF['ope_proj_div_co'] = true;
        } else {
            $this->valF['ope_proj_div_co'] = false;
        }
        if ($val['ope_proj_div_contr'] == 1 || $val['ope_proj_div_contr'] == "t" || $val['ope_proj_div_contr'] == "Oui") {
            $this->valF['ope_proj_div_contr'] = true;
        } else {
            $this->valF['ope_proj_div_contr'] = false;
        }
            $this->valF['tax_desc'] = $val['tax_desc'];
        if ($val['erp_cstr_neuve'] == 1 || $val['erp_cstr_neuve'] == "t" || $val['erp_cstr_neuve'] == "Oui") {
            $this->valF['erp_cstr_neuve'] = true;
        } else {
            $this->valF['erp_cstr_neuve'] = false;
        }
        if ($val['erp_trvx_acc'] == 1 || $val['erp_trvx_acc'] == "t" || $val['erp_trvx_acc'] == "Oui") {
            $this->valF['erp_trvx_acc'] = true;
        } else {
            $this->valF['erp_trvx_acc'] = false;
        }
        if ($val['erp_extension'] == 1 || $val['erp_extension'] == "t" || $val['erp_extension'] == "Oui") {
            $this->valF['erp_extension'] = true;
        } else {
            $this->valF['erp_extension'] = false;
        }
        if ($val['erp_rehab'] == 1 || $val['erp_rehab'] == "t" || $val['erp_rehab'] == "Oui") {
            $this->valF['erp_rehab'] = true;
        } else {
            $this->valF['erp_rehab'] = false;
        }
        if ($val['erp_trvx_am'] == 1 || $val['erp_trvx_am'] == "t" || $val['erp_trvx_am'] == "Oui") {
            $this->valF['erp_trvx_am'] = true;
        } else {
            $this->valF['erp_trvx_am'] = false;
        }
        if ($val['erp_vol_nouv_exist'] == 1 || $val['erp_vol_nouv_exist'] == "t" || $val['erp_vol_nouv_exist'] == "Oui") {
            $this->valF['erp_vol_nouv_exist'] = true;
        } else {
            $this->valF['erp_vol_nouv_exist'] = false;
        }
        if ($val['erp_loc_eff1'] == "") {
            $this->valF['erp_loc_eff1'] = NULL;
        } else {
            $this->valF['erp_loc_eff1'] = $val['erp_loc_eff1'];
        }
        if ($val['erp_loc_eff2'] == "") {
            $this->valF['erp_loc_eff2'] = NULL;
        } else {
            $this->valF['erp_loc_eff2'] = $val['erp_loc_eff2'];
        }
        if ($val['erp_loc_eff3'] == "") {
            $this->valF['erp_loc_eff3'] = NULL;
        } else {
            $this->valF['erp_loc_eff3'] = $val['erp_loc_eff3'];
        }
        if ($val['erp_loc_eff4'] == "") {
            $this->valF['erp_loc_eff4'] = NULL;
        } else {
            $this->valF['erp_loc_eff4'] = $val['erp_loc_eff4'];
        }
        if ($val['erp_loc_eff5'] == "") {
            $this->valF['erp_loc_eff5'] = NULL;
        } else {
            $this->valF['erp_loc_eff5'] = $val['erp_loc_eff5'];
        }
        if ($val['erp_loc_eff_tot'] == "") {
            $this->valF['erp_loc_eff_tot'] = NULL;
        } else {
            $this->valF['erp_loc_eff_tot'] = $val['erp_loc_eff_tot'];
        }
        if (!is_numeric($val['erp_public_eff1'])) {
            $this->valF['erp_public_eff1'] = NULL;
        } else {
            $this->valF['erp_public_eff1'] = $val['erp_public_eff1'];
        }
        if (!is_numeric($val['erp_public_eff2'])) {
            $this->valF['erp_public_eff2'] = NULL;
        } else {
            $this->valF['erp_public_eff2'] = $val['erp_public_eff2'];
        }
        if (!is_numeric($val['erp_public_eff3'])) {
            $this->valF['erp_public_eff3'] = NULL;
        } else {
            $this->valF['erp_public_eff3'] = $val['erp_public_eff3'];
        }
        if (!is_numeric($val['erp_public_eff4'])) {
            $this->valF['erp_public_eff4'] = NULL;
        } else {
            $this->valF['erp_public_eff4'] = $val['erp_public_eff4'];
        }
        if (!is_numeric($val['erp_public_eff5'])) {
            $this->valF['erp_public_eff5'] = NULL;
        } else {
            $this->valF['erp_public_eff5'] = $val['erp_public_eff5'];
        }
        if (!is_numeric($val['erp_public_eff_tot'])) {
            $this->valF['erp_public_eff_tot'] = NULL;
        } else {
            $this->valF['erp_public_eff_tot'] = $val['erp_public_eff_tot'];
        }
        if (!is_numeric($val['erp_perso_eff1'])) {
            $this->valF['erp_perso_eff1'] = NULL;
        } else {
            $this->valF['erp_perso_eff1'] = $val['erp_perso_eff1'];
        }
        if (!is_numeric($val['erp_perso_eff2'])) {
            $this->valF['erp_perso_eff2'] = NULL;
        } else {
            $this->valF['erp_perso_eff2'] = $val['erp_perso_eff2'];
        }
        if (!is_numeric($val['erp_perso_eff3'])) {
            $this->valF['erp_perso_eff3'] = NULL;
        } else {
            $this->valF['erp_perso_eff3'] = $val['erp_perso_eff3'];
        }
        if (!is_numeric($val['erp_perso_eff4'])) {
            $this->valF['erp_perso_eff4'] = NULL;
        } else {
            $this->valF['erp_perso_eff4'] = $val['erp_perso_eff4'];
        }
        if (!is_numeric($val['erp_perso_eff5'])) {
            $this->valF['erp_perso_eff5'] = NULL;
        } else {
            $this->valF['erp_perso_eff5'] = $val['erp_perso_eff5'];
        }
        if (!is_numeric($val['erp_perso_eff_tot'])) {
            $this->valF['erp_perso_eff_tot'] = NULL;
        } else {
            $this->valF['erp_perso_eff_tot'] = $val['erp_perso_eff_tot'];
        }
        if (!is_numeric($val['erp_tot_eff1'])) {
            $this->valF['erp_tot_eff1'] = NULL;
        } else {
            $this->valF['erp_tot_eff1'] = $val['erp_tot_eff1'];
        }
        if (!is_numeric($val['erp_tot_eff2'])) {
            $this->valF['erp_tot_eff2'] = NULL;
        } else {
            $this->valF['erp_tot_eff2'] = $val['erp_tot_eff2'];
        }
        if (!is_numeric($val['erp_tot_eff3'])) {
            $this->valF['erp_tot_eff3'] = NULL;
        } else {
            $this->valF['erp_tot_eff3'] = $val['erp_tot_eff3'];
        }
        if (!is_numeric($val['erp_tot_eff4'])) {
            $this->valF['erp_tot_eff4'] = NULL;
        } else {
            $this->valF['erp_tot_eff4'] = $val['erp_tot_eff4'];
        }
        if (!is_numeric($val['erp_tot_eff5'])) {
            $this->valF['erp_tot_eff5'] = NULL;
        } else {
            $this->valF['erp_tot_eff5'] = $val['erp_tot_eff5'];
        }
        if (!is_numeric($val['erp_tot_eff_tot'])) {
            $this->valF['erp_tot_eff_tot'] = NULL;
        } else {
            $this->valF['erp_tot_eff_tot'] = $val['erp_tot_eff_tot'];
        }
        if (!is_numeric($val['erp_class_cat'])) {
            $this->valF['erp_class_cat'] = NULL;
        } else {
            $this->valF['erp_class_cat'] = $val['erp_class_cat'];
        }
        if (!is_numeric($val['erp_class_type'])) {
            $this->valF['erp_class_type'] = NULL;
        } else {
            $this->valF['erp_class_type'] = $val['erp_class_type'];
        }
        if (!is_numeric($val['tax_surf_abr_jard_pig_colom'])) {
            $this->valF['tax_surf_abr_jard_pig_colom'] = NULL;
        } else {
            $this->valF['tax_surf_abr_jard_pig_colom'] = $val['tax_surf_abr_jard_pig_colom'];
        }
        if (!is_numeric($val['tax_su_non_habit_abr_jard_pig_colom'])) {
            $this->valF['tax_su_non_habit_abr_jard_pig_colom'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_abr_jard_pig_colom'] = $val['tax_su_non_habit_abr_jard_pig_colom'];
        }
        if ($val['dia_imm_non_bati'] == 1 || $val['dia_imm_non_bati'] == "t" || $val['dia_imm_non_bati'] == "Oui") {
            $this->valF['dia_imm_non_bati'] = true;
        } else {
            $this->valF['dia_imm_non_bati'] = false;
        }
        if ($val['dia_imm_bati_terr_propr'] == 1 || $val['dia_imm_bati_terr_propr'] == "t" || $val['dia_imm_bati_terr_propr'] == "Oui") {
            $this->valF['dia_imm_bati_terr_propr'] = true;
        } else {
            $this->valF['dia_imm_bati_terr_propr'] = false;
        }
        if ($val['dia_imm_bati_terr_autr'] == 1 || $val['dia_imm_bati_terr_autr'] == "t" || $val['dia_imm_bati_terr_autr'] == "Oui") {
            $this->valF['dia_imm_bati_terr_autr'] = true;
        } else {
            $this->valF['dia_imm_bati_terr_autr'] = false;
        }
            $this->valF['dia_imm_bati_terr_autr_desc'] = $val['dia_imm_bati_terr_autr_desc'];
        if ($val['dia_bat_copro'] == 1 || $val['dia_bat_copro'] == "t" || $val['dia_bat_copro'] == "Oui") {
            $this->valF['dia_bat_copro'] = true;
        } else {
            $this->valF['dia_bat_copro'] = false;
        }
            $this->valF['dia_bat_copro_desc'] = $val['dia_bat_copro_desc'];
            $this->valF['dia_lot_numero'] = $val['dia_lot_numero'];
            $this->valF['dia_lot_bat'] = $val['dia_lot_bat'];
            $this->valF['dia_lot_etage'] = $val['dia_lot_etage'];
            $this->valF['dia_lot_quote_part'] = $val['dia_lot_quote_part'];
        if ($val['dia_us_hab'] == 1 || $val['dia_us_hab'] == "t" || $val['dia_us_hab'] == "Oui") {
            $this->valF['dia_us_hab'] = true;
        } else {
            $this->valF['dia_us_hab'] = false;
        }
        if ($val['dia_us_pro'] == 1 || $val['dia_us_pro'] == "t" || $val['dia_us_pro'] == "Oui") {
            $this->valF['dia_us_pro'] = true;
        } else {
            $this->valF['dia_us_pro'] = false;
        }
        if ($val['dia_us_mixte'] == 1 || $val['dia_us_mixte'] == "t" || $val['dia_us_mixte'] == "Oui") {
            $this->valF['dia_us_mixte'] = true;
        } else {
            $this->valF['dia_us_mixte'] = false;
        }
        if ($val['dia_us_comm'] == 1 || $val['dia_us_comm'] == "t" || $val['dia_us_comm'] == "Oui") {
            $this->valF['dia_us_comm'] = true;
        } else {
            $this->valF['dia_us_comm'] = false;
        }
        if ($val['dia_us_agr'] == 1 || $val['dia_us_agr'] == "t" || $val['dia_us_agr'] == "Oui") {
            $this->valF['dia_us_agr'] = true;
        } else {
            $this->valF['dia_us_agr'] = false;
        }
        if ($val['dia_us_autre'] == 1 || $val['dia_us_autre'] == "t" || $val['dia_us_autre'] == "Oui") {
            $this->valF['dia_us_autre'] = true;
        } else {
            $this->valF['dia_us_autre'] = false;
        }
            $this->valF['dia_us_autre_prec'] = $val['dia_us_autre_prec'];
        if ($val['dia_occ_prop'] == 1 || $val['dia_occ_prop'] == "t" || $val['dia_occ_prop'] == "Oui") {
            $this->valF['dia_occ_prop'] = true;
        } else {
            $this->valF['dia_occ_prop'] = false;
        }
        if ($val['dia_occ_loc'] == 1 || $val['dia_occ_loc'] == "t" || $val['dia_occ_loc'] == "Oui") {
            $this->valF['dia_occ_loc'] = true;
        } else {
            $this->valF['dia_occ_loc'] = false;
        }
        if ($val['dia_occ_sans_occ'] == 1 || $val['dia_occ_sans_occ'] == "t" || $val['dia_occ_sans_occ'] == "Oui") {
            $this->valF['dia_occ_sans_occ'] = true;
        } else {
            $this->valF['dia_occ_sans_occ'] = false;
        }
        if ($val['dia_occ_autre'] == 1 || $val['dia_occ_autre'] == "t" || $val['dia_occ_autre'] == "Oui") {
            $this->valF['dia_occ_autre'] = true;
        } else {
            $this->valF['dia_occ_autre'] = false;
        }
            $this->valF['dia_occ_autre_prec'] = $val['dia_occ_autre_prec'];
        if ($val['dia_mod_cess_prix_vente'] == "") {
            $this->valF['dia_mod_cess_prix_vente'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente'] = $val['dia_mod_cess_prix_vente'];
        }
        if ($val['dia_mod_cess_prix_vente_mob'] == "") {
            $this->valF['dia_mod_cess_prix_vente_mob'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente_mob'] = $val['dia_mod_cess_prix_vente_mob'];
        }
        if ($val['dia_mod_cess_prix_vente_cheptel'] == "") {
            $this->valF['dia_mod_cess_prix_vente_cheptel'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente_cheptel'] = $val['dia_mod_cess_prix_vente_cheptel'];
        }
        if ($val['dia_mod_cess_prix_vente_recol'] == "") {
            $this->valF['dia_mod_cess_prix_vente_recol'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente_recol'] = $val['dia_mod_cess_prix_vente_recol'];
        }
        if ($val['dia_mod_cess_prix_vente_autre'] == "") {
            $this->valF['dia_mod_cess_prix_vente_autre'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente_autre'] = $val['dia_mod_cess_prix_vente_autre'];
        }
        if ($val['dia_mod_cess_commi'] == 1 || $val['dia_mod_cess_commi'] == "t" || $val['dia_mod_cess_commi'] == "Oui") {
            $this->valF['dia_mod_cess_commi'] = true;
        } else {
            $this->valF['dia_mod_cess_commi'] = false;
        }
        if ($val['dia_mod_cess_commi_ttc'] == "") {
            $this->valF['dia_mod_cess_commi_ttc'] = NULL;
        } else {
            $this->valF['dia_mod_cess_commi_ttc'] = $val['dia_mod_cess_commi_ttc'];
        }
        if ($val['dia_mod_cess_commi_ht'] == "") {
            $this->valF['dia_mod_cess_commi_ht'] = NULL;
        } else {
            $this->valF['dia_mod_cess_commi_ht'] = $val['dia_mod_cess_commi_ht'];
        }
        if ($val['dia_acquereur_nom_prenom'] == "") {
            $this->valF['dia_acquereur_nom_prenom'] = NULL;
        } else {
            $this->valF['dia_acquereur_nom_prenom'] = $val['dia_acquereur_nom_prenom'];
        }
        if ($val['dia_acquereur_adr_num_voie'] == "") {
            $this->valF['dia_acquereur_adr_num_voie'] = NULL;
        } else {
            $this->valF['dia_acquereur_adr_num_voie'] = $val['dia_acquereur_adr_num_voie'];
        }
        if ($val['dia_acquereur_adr_ext'] == "") {
            $this->valF['dia_acquereur_adr_ext'] = NULL;
        } else {
            $this->valF['dia_acquereur_adr_ext'] = $val['dia_acquereur_adr_ext'];
        }
        if ($val['dia_acquereur_adr_type_voie'] == "") {
            $this->valF['dia_acquereur_adr_type_voie'] = NULL;
        } else {
            $this->valF['dia_acquereur_adr_type_voie'] = $val['dia_acquereur_adr_type_voie'];
        }
        if ($val['dia_acquereur_adr_nom_voie'] == "") {
            $this->valF['dia_acquereur_adr_nom_voie'] = NULL;
        } else {
            $this->valF['dia_acquereur_adr_nom_voie'] = $val['dia_acquereur_adr_nom_voie'];
        }
        if ($val['dia_acquereur_adr_lieu_dit_bp'] == "") {
            $this->valF['dia_acquereur_adr_lieu_dit_bp'] = NULL;
        } else {
            $this->valF['dia_acquereur_adr_lieu_dit_bp'] = $val['dia_acquereur_adr_lieu_dit_bp'];
        }
        if ($val['dia_acquereur_adr_cp'] == "") {
            $this->valF['dia_acquereur_adr_cp'] = NULL;
        } else {
            $this->valF['dia_acquereur_adr_cp'] = $val['dia_acquereur_adr_cp'];
        }
        if ($val['dia_acquereur_adr_localite'] == "") {
            $this->valF['dia_acquereur_adr_localite'] = NULL;
        } else {
            $this->valF['dia_acquereur_adr_localite'] = $val['dia_acquereur_adr_localite'];
        }
            $this->valF['dia_observation'] = $val['dia_observation'];
        if (!is_numeric($val['su2_avt_shon1'])) {
            $this->valF['su2_avt_shon1'] = NULL;
        } else {
            $this->valF['su2_avt_shon1'] = $val['su2_avt_shon1'];
        }
        if (!is_numeric($val['su2_avt_shon2'])) {
            $this->valF['su2_avt_shon2'] = NULL;
        } else {
            $this->valF['su2_avt_shon2'] = $val['su2_avt_shon2'];
        }
        if (!is_numeric($val['su2_avt_shon3'])) {
            $this->valF['su2_avt_shon3'] = NULL;
        } else {
            $this->valF['su2_avt_shon3'] = $val['su2_avt_shon3'];
        }
        if (!is_numeric($val['su2_avt_shon4'])) {
            $this->valF['su2_avt_shon4'] = NULL;
        } else {
            $this->valF['su2_avt_shon4'] = $val['su2_avt_shon4'];
        }
        if (!is_numeric($val['su2_avt_shon5'])) {
            $this->valF['su2_avt_shon5'] = NULL;
        } else {
            $this->valF['su2_avt_shon5'] = $val['su2_avt_shon5'];
        }
        if (!is_numeric($val['su2_avt_shon6'])) {
            $this->valF['su2_avt_shon6'] = NULL;
        } else {
            $this->valF['su2_avt_shon6'] = $val['su2_avt_shon6'];
        }
        if (!is_numeric($val['su2_avt_shon7'])) {
            $this->valF['su2_avt_shon7'] = NULL;
        } else {
            $this->valF['su2_avt_shon7'] = $val['su2_avt_shon7'];
        }
        if (!is_numeric($val['su2_avt_shon8'])) {
            $this->valF['su2_avt_shon8'] = NULL;
        } else {
            $this->valF['su2_avt_shon8'] = $val['su2_avt_shon8'];
        }
        if (!is_numeric($val['su2_avt_shon9'])) {
            $this->valF['su2_avt_shon9'] = NULL;
        } else {
            $this->valF['su2_avt_shon9'] = $val['su2_avt_shon9'];
        }
        if (!is_numeric($val['su2_avt_shon10'])) {
            $this->valF['su2_avt_shon10'] = NULL;
        } else {
            $this->valF['su2_avt_shon10'] = $val['su2_avt_shon10'];
        }
        if (!is_numeric($val['su2_avt_shon11'])) {
            $this->valF['su2_avt_shon11'] = NULL;
        } else {
            $this->valF['su2_avt_shon11'] = $val['su2_avt_shon11'];
        }
        if (!is_numeric($val['su2_avt_shon12'])) {
            $this->valF['su2_avt_shon12'] = NULL;
        } else {
            $this->valF['su2_avt_shon12'] = $val['su2_avt_shon12'];
        }
        if (!is_numeric($val['su2_avt_shon13'])) {
            $this->valF['su2_avt_shon13'] = NULL;
        } else {
            $this->valF['su2_avt_shon13'] = $val['su2_avt_shon13'];
        }
        if (!is_numeric($val['su2_avt_shon14'])) {
            $this->valF['su2_avt_shon14'] = NULL;
        } else {
            $this->valF['su2_avt_shon14'] = $val['su2_avt_shon14'];
        }
        if (!is_numeric($val['su2_avt_shon15'])) {
            $this->valF['su2_avt_shon15'] = NULL;
        } else {
            $this->valF['su2_avt_shon15'] = $val['su2_avt_shon15'];
        }
        if (!is_numeric($val['su2_avt_shon16'])) {
            $this->valF['su2_avt_shon16'] = NULL;
        } else {
            $this->valF['su2_avt_shon16'] = $val['su2_avt_shon16'];
        }
        if (!is_numeric($val['su2_avt_shon17'])) {
            $this->valF['su2_avt_shon17'] = NULL;
        } else {
            $this->valF['su2_avt_shon17'] = $val['su2_avt_shon17'];
        }
        if (!is_numeric($val['su2_avt_shon18'])) {
            $this->valF['su2_avt_shon18'] = NULL;
        } else {
            $this->valF['su2_avt_shon18'] = $val['su2_avt_shon18'];
        }
        if (!is_numeric($val['su2_avt_shon19'])) {
            $this->valF['su2_avt_shon19'] = NULL;
        } else {
            $this->valF['su2_avt_shon19'] = $val['su2_avt_shon19'];
        }
        if (!is_numeric($val['su2_avt_shon20'])) {
            $this->valF['su2_avt_shon20'] = NULL;
        } else {
            $this->valF['su2_avt_shon20'] = $val['su2_avt_shon20'];
        }
        if (!is_numeric($val['su2_avt_shon_tot'])) {
            $this->valF['su2_avt_shon_tot'] = NULL;
        } else {
            $this->valF['su2_avt_shon_tot'] = $val['su2_avt_shon_tot'];
        }
        if (!is_numeric($val['su2_cstr_shon1'])) {
            $this->valF['su2_cstr_shon1'] = NULL;
        } else {
            $this->valF['su2_cstr_shon1'] = $val['su2_cstr_shon1'];
        }
        if (!is_numeric($val['su2_cstr_shon2'])) {
            $this->valF['su2_cstr_shon2'] = NULL;
        } else {
            $this->valF['su2_cstr_shon2'] = $val['su2_cstr_shon2'];
        }
        if (!is_numeric($val['su2_cstr_shon3'])) {
            $this->valF['su2_cstr_shon3'] = NULL;
        } else {
            $this->valF['su2_cstr_shon3'] = $val['su2_cstr_shon3'];
        }
        if (!is_numeric($val['su2_cstr_shon4'])) {
            $this->valF['su2_cstr_shon4'] = NULL;
        } else {
            $this->valF['su2_cstr_shon4'] = $val['su2_cstr_shon4'];
        }
        if (!is_numeric($val['su2_cstr_shon5'])) {
            $this->valF['su2_cstr_shon5'] = NULL;
        } else {
            $this->valF['su2_cstr_shon5'] = $val['su2_cstr_shon5'];
        }
        if (!is_numeric($val['su2_cstr_shon6'])) {
            $this->valF['su2_cstr_shon6'] = NULL;
        } else {
            $this->valF['su2_cstr_shon6'] = $val['su2_cstr_shon6'];
        }
        if (!is_numeric($val['su2_cstr_shon7'])) {
            $this->valF['su2_cstr_shon7'] = NULL;
        } else {
            $this->valF['su2_cstr_shon7'] = $val['su2_cstr_shon7'];
        }
        if (!is_numeric($val['su2_cstr_shon8'])) {
            $this->valF['su2_cstr_shon8'] = NULL;
        } else {
            $this->valF['su2_cstr_shon8'] = $val['su2_cstr_shon8'];
        }
        if (!is_numeric($val['su2_cstr_shon9'])) {
            $this->valF['su2_cstr_shon9'] = NULL;
        } else {
            $this->valF['su2_cstr_shon9'] = $val['su2_cstr_shon9'];
        }
        if (!is_numeric($val['su2_cstr_shon10'])) {
            $this->valF['su2_cstr_shon10'] = NULL;
        } else {
            $this->valF['su2_cstr_shon10'] = $val['su2_cstr_shon10'];
        }
        if (!is_numeric($val['su2_cstr_shon11'])) {
            $this->valF['su2_cstr_shon11'] = NULL;
        } else {
            $this->valF['su2_cstr_shon11'] = $val['su2_cstr_shon11'];
        }
        if (!is_numeric($val['su2_cstr_shon12'])) {
            $this->valF['su2_cstr_shon12'] = NULL;
        } else {
            $this->valF['su2_cstr_shon12'] = $val['su2_cstr_shon12'];
        }
        if (!is_numeric($val['su2_cstr_shon13'])) {
            $this->valF['su2_cstr_shon13'] = NULL;
        } else {
            $this->valF['su2_cstr_shon13'] = $val['su2_cstr_shon13'];
        }
        if (!is_numeric($val['su2_cstr_shon14'])) {
            $this->valF['su2_cstr_shon14'] = NULL;
        } else {
            $this->valF['su2_cstr_shon14'] = $val['su2_cstr_shon14'];
        }
        if (!is_numeric($val['su2_cstr_shon15'])) {
            $this->valF['su2_cstr_shon15'] = NULL;
        } else {
            $this->valF['su2_cstr_shon15'] = $val['su2_cstr_shon15'];
        }
        if (!is_numeric($val['su2_cstr_shon16'])) {
            $this->valF['su2_cstr_shon16'] = NULL;
        } else {
            $this->valF['su2_cstr_shon16'] = $val['su2_cstr_shon16'];
        }
        if (!is_numeric($val['su2_cstr_shon17'])) {
            $this->valF['su2_cstr_shon17'] = NULL;
        } else {
            $this->valF['su2_cstr_shon17'] = $val['su2_cstr_shon17'];
        }
        if (!is_numeric($val['su2_cstr_shon18'])) {
            $this->valF['su2_cstr_shon18'] = NULL;
        } else {
            $this->valF['su2_cstr_shon18'] = $val['su2_cstr_shon18'];
        }
        if (!is_numeric($val['su2_cstr_shon19'])) {
            $this->valF['su2_cstr_shon19'] = NULL;
        } else {
            $this->valF['su2_cstr_shon19'] = $val['su2_cstr_shon19'];
        }
        if (!is_numeric($val['su2_cstr_shon20'])) {
            $this->valF['su2_cstr_shon20'] = NULL;
        } else {
            $this->valF['su2_cstr_shon20'] = $val['su2_cstr_shon20'];
        }
        if (!is_numeric($val['su2_cstr_shon_tot'])) {
            $this->valF['su2_cstr_shon_tot'] = NULL;
        } else {
            $this->valF['su2_cstr_shon_tot'] = $val['su2_cstr_shon_tot'];
        }
        if (!is_numeric($val['su2_chge_shon1'])) {
            $this->valF['su2_chge_shon1'] = NULL;
        } else {
            $this->valF['su2_chge_shon1'] = $val['su2_chge_shon1'];
        }
        if (!is_numeric($val['su2_chge_shon2'])) {
            $this->valF['su2_chge_shon2'] = NULL;
        } else {
            $this->valF['su2_chge_shon2'] = $val['su2_chge_shon2'];
        }
        if (!is_numeric($val['su2_chge_shon3'])) {
            $this->valF['su2_chge_shon3'] = NULL;
        } else {
            $this->valF['su2_chge_shon3'] = $val['su2_chge_shon3'];
        }
        if (!is_numeric($val['su2_chge_shon4'])) {
            $this->valF['su2_chge_shon4'] = NULL;
        } else {
            $this->valF['su2_chge_shon4'] = $val['su2_chge_shon4'];
        }
        if (!is_numeric($val['su2_chge_shon5'])) {
            $this->valF['su2_chge_shon5'] = NULL;
        } else {
            $this->valF['su2_chge_shon5'] = $val['su2_chge_shon5'];
        }
        if (!is_numeric($val['su2_chge_shon6'])) {
            $this->valF['su2_chge_shon6'] = NULL;
        } else {
            $this->valF['su2_chge_shon6'] = $val['su2_chge_shon6'];
        }
        if (!is_numeric($val['su2_chge_shon7'])) {
            $this->valF['su2_chge_shon7'] = NULL;
        } else {
            $this->valF['su2_chge_shon7'] = $val['su2_chge_shon7'];
        }
        if (!is_numeric($val['su2_chge_shon8'])) {
            $this->valF['su2_chge_shon8'] = NULL;
        } else {
            $this->valF['su2_chge_shon8'] = $val['su2_chge_shon8'];
        }
        if (!is_numeric($val['su2_chge_shon9'])) {
            $this->valF['su2_chge_shon9'] = NULL;
        } else {
            $this->valF['su2_chge_shon9'] = $val['su2_chge_shon9'];
        }
        if (!is_numeric($val['su2_chge_shon10'])) {
            $this->valF['su2_chge_shon10'] = NULL;
        } else {
            $this->valF['su2_chge_shon10'] = $val['su2_chge_shon10'];
        }
        if (!is_numeric($val['su2_chge_shon11'])) {
            $this->valF['su2_chge_shon11'] = NULL;
        } else {
            $this->valF['su2_chge_shon11'] = $val['su2_chge_shon11'];
        }
        if (!is_numeric($val['su2_chge_shon12'])) {
            $this->valF['su2_chge_shon12'] = NULL;
        } else {
            $this->valF['su2_chge_shon12'] = $val['su2_chge_shon12'];
        }
        if (!is_numeric($val['su2_chge_shon13'])) {
            $this->valF['su2_chge_shon13'] = NULL;
        } else {
            $this->valF['su2_chge_shon13'] = $val['su2_chge_shon13'];
        }
        if (!is_numeric($val['su2_chge_shon14'])) {
            $this->valF['su2_chge_shon14'] = NULL;
        } else {
            $this->valF['su2_chge_shon14'] = $val['su2_chge_shon14'];
        }
        if (!is_numeric($val['su2_chge_shon15'])) {
            $this->valF['su2_chge_shon15'] = NULL;
        } else {
            $this->valF['su2_chge_shon15'] = $val['su2_chge_shon15'];
        }
        if (!is_numeric($val['su2_chge_shon16'])) {
            $this->valF['su2_chge_shon16'] = NULL;
        } else {
            $this->valF['su2_chge_shon16'] = $val['su2_chge_shon16'];
        }
        if (!is_numeric($val['su2_chge_shon17'])) {
            $this->valF['su2_chge_shon17'] = NULL;
        } else {
            $this->valF['su2_chge_shon17'] = $val['su2_chge_shon17'];
        }
        if (!is_numeric($val['su2_chge_shon18'])) {
            $this->valF['su2_chge_shon18'] = NULL;
        } else {
            $this->valF['su2_chge_shon18'] = $val['su2_chge_shon18'];
        }
        if (!is_numeric($val['su2_chge_shon19'])) {
            $this->valF['su2_chge_shon19'] = NULL;
        } else {
            $this->valF['su2_chge_shon19'] = $val['su2_chge_shon19'];
        }
        if (!is_numeric($val['su2_chge_shon20'])) {
            $this->valF['su2_chge_shon20'] = NULL;
        } else {
            $this->valF['su2_chge_shon20'] = $val['su2_chge_shon20'];
        }
        if (!is_numeric($val['su2_chge_shon_tot'])) {
            $this->valF['su2_chge_shon_tot'] = NULL;
        } else {
            $this->valF['su2_chge_shon_tot'] = $val['su2_chge_shon_tot'];
        }
        if (!is_numeric($val['su2_demo_shon1'])) {
            $this->valF['su2_demo_shon1'] = NULL;
        } else {
            $this->valF['su2_demo_shon1'] = $val['su2_demo_shon1'];
        }
        if (!is_numeric($val['su2_demo_shon2'])) {
            $this->valF['su2_demo_shon2'] = NULL;
        } else {
            $this->valF['su2_demo_shon2'] = $val['su2_demo_shon2'];
        }
        if (!is_numeric($val['su2_demo_shon3'])) {
            $this->valF['su2_demo_shon3'] = NULL;
        } else {
            $this->valF['su2_demo_shon3'] = $val['su2_demo_shon3'];
        }
        if (!is_numeric($val['su2_demo_shon4'])) {
            $this->valF['su2_demo_shon4'] = NULL;
        } else {
            $this->valF['su2_demo_shon4'] = $val['su2_demo_shon4'];
        }
        if (!is_numeric($val['su2_demo_shon5'])) {
            $this->valF['su2_demo_shon5'] = NULL;
        } else {
            $this->valF['su2_demo_shon5'] = $val['su2_demo_shon5'];
        }
        if (!is_numeric($val['su2_demo_shon6'])) {
            $this->valF['su2_demo_shon6'] = NULL;
        } else {
            $this->valF['su2_demo_shon6'] = $val['su2_demo_shon6'];
        }
        if (!is_numeric($val['su2_demo_shon7'])) {
            $this->valF['su2_demo_shon7'] = NULL;
        } else {
            $this->valF['su2_demo_shon7'] = $val['su2_demo_shon7'];
        }
        if (!is_numeric($val['su2_demo_shon8'])) {
            $this->valF['su2_demo_shon8'] = NULL;
        } else {
            $this->valF['su2_demo_shon8'] = $val['su2_demo_shon8'];
        }
        if (!is_numeric($val['su2_demo_shon9'])) {
            $this->valF['su2_demo_shon9'] = NULL;
        } else {
            $this->valF['su2_demo_shon9'] = $val['su2_demo_shon9'];
        }
        if (!is_numeric($val['su2_demo_shon10'])) {
            $this->valF['su2_demo_shon10'] = NULL;
        } else {
            $this->valF['su2_demo_shon10'] = $val['su2_demo_shon10'];
        }
        if (!is_numeric($val['su2_demo_shon11'])) {
            $this->valF['su2_demo_shon11'] = NULL;
        } else {
            $this->valF['su2_demo_shon11'] = $val['su2_demo_shon11'];
        }
        if (!is_numeric($val['su2_demo_shon12'])) {
            $this->valF['su2_demo_shon12'] = NULL;
        } else {
            $this->valF['su2_demo_shon12'] = $val['su2_demo_shon12'];
        }
        if (!is_numeric($val['su2_demo_shon13'])) {
            $this->valF['su2_demo_shon13'] = NULL;
        } else {
            $this->valF['su2_demo_shon13'] = $val['su2_demo_shon13'];
        }
        if (!is_numeric($val['su2_demo_shon14'])) {
            $this->valF['su2_demo_shon14'] = NULL;
        } else {
            $this->valF['su2_demo_shon14'] = $val['su2_demo_shon14'];
        }
        if (!is_numeric($val['su2_demo_shon15'])) {
            $this->valF['su2_demo_shon15'] = NULL;
        } else {
            $this->valF['su2_demo_shon15'] = $val['su2_demo_shon15'];
        }
        if (!is_numeric($val['su2_demo_shon16'])) {
            $this->valF['su2_demo_shon16'] = NULL;
        } else {
            $this->valF['su2_demo_shon16'] = $val['su2_demo_shon16'];
        }
        if (!is_numeric($val['su2_demo_shon17'])) {
            $this->valF['su2_demo_shon17'] = NULL;
        } else {
            $this->valF['su2_demo_shon17'] = $val['su2_demo_shon17'];
        }
        if (!is_numeric($val['su2_demo_shon18'])) {
            $this->valF['su2_demo_shon18'] = NULL;
        } else {
            $this->valF['su2_demo_shon18'] = $val['su2_demo_shon18'];
        }
        if (!is_numeric($val['su2_demo_shon19'])) {
            $this->valF['su2_demo_shon19'] = NULL;
        } else {
            $this->valF['su2_demo_shon19'] = $val['su2_demo_shon19'];
        }
        if (!is_numeric($val['su2_demo_shon20'])) {
            $this->valF['su2_demo_shon20'] = NULL;
        } else {
            $this->valF['su2_demo_shon20'] = $val['su2_demo_shon20'];
        }
        if (!is_numeric($val['su2_demo_shon_tot'])) {
            $this->valF['su2_demo_shon_tot'] = NULL;
        } else {
            $this->valF['su2_demo_shon_tot'] = $val['su2_demo_shon_tot'];
        }
        if (!is_numeric($val['su2_sup_shon1'])) {
            $this->valF['su2_sup_shon1'] = NULL;
        } else {
            $this->valF['su2_sup_shon1'] = $val['su2_sup_shon1'];
        }
        if (!is_numeric($val['su2_sup_shon2'])) {
            $this->valF['su2_sup_shon2'] = NULL;
        } else {
            $this->valF['su2_sup_shon2'] = $val['su2_sup_shon2'];
        }
        if (!is_numeric($val['su2_sup_shon3'])) {
            $this->valF['su2_sup_shon3'] = NULL;
        } else {
            $this->valF['su2_sup_shon3'] = $val['su2_sup_shon3'];
        }
        if (!is_numeric($val['su2_sup_shon4'])) {
            $this->valF['su2_sup_shon4'] = NULL;
        } else {
            $this->valF['su2_sup_shon4'] = $val['su2_sup_shon4'];
        }
        if (!is_numeric($val['su2_sup_shon5'])) {
            $this->valF['su2_sup_shon5'] = NULL;
        } else {
            $this->valF['su2_sup_shon5'] = $val['su2_sup_shon5'];
        }
        if (!is_numeric($val['su2_sup_shon6'])) {
            $this->valF['su2_sup_shon6'] = NULL;
        } else {
            $this->valF['su2_sup_shon6'] = $val['su2_sup_shon6'];
        }
        if (!is_numeric($val['su2_sup_shon7'])) {
            $this->valF['su2_sup_shon7'] = NULL;
        } else {
            $this->valF['su2_sup_shon7'] = $val['su2_sup_shon7'];
        }
        if (!is_numeric($val['su2_sup_shon8'])) {
            $this->valF['su2_sup_shon8'] = NULL;
        } else {
            $this->valF['su2_sup_shon8'] = $val['su2_sup_shon8'];
        }
        if (!is_numeric($val['su2_sup_shon9'])) {
            $this->valF['su2_sup_shon9'] = NULL;
        } else {
            $this->valF['su2_sup_shon9'] = $val['su2_sup_shon9'];
        }
        if (!is_numeric($val['su2_sup_shon10'])) {
            $this->valF['su2_sup_shon10'] = NULL;
        } else {
            $this->valF['su2_sup_shon10'] = $val['su2_sup_shon10'];
        }
        if (!is_numeric($val['su2_sup_shon11'])) {
            $this->valF['su2_sup_shon11'] = NULL;
        } else {
            $this->valF['su2_sup_shon11'] = $val['su2_sup_shon11'];
        }
        if (!is_numeric($val['su2_sup_shon12'])) {
            $this->valF['su2_sup_shon12'] = NULL;
        } else {
            $this->valF['su2_sup_shon12'] = $val['su2_sup_shon12'];
        }
        if (!is_numeric($val['su2_sup_shon13'])) {
            $this->valF['su2_sup_shon13'] = NULL;
        } else {
            $this->valF['su2_sup_shon13'] = $val['su2_sup_shon13'];
        }
        if (!is_numeric($val['su2_sup_shon14'])) {
            $this->valF['su2_sup_shon14'] = NULL;
        } else {
            $this->valF['su2_sup_shon14'] = $val['su2_sup_shon14'];
        }
        if (!is_numeric($val['su2_sup_shon15'])) {
            $this->valF['su2_sup_shon15'] = NULL;
        } else {
            $this->valF['su2_sup_shon15'] = $val['su2_sup_shon15'];
        }
        if (!is_numeric($val['su2_sup_shon16'])) {
            $this->valF['su2_sup_shon16'] = NULL;
        } else {
            $this->valF['su2_sup_shon16'] = $val['su2_sup_shon16'];
        }
        if (!is_numeric($val['su2_sup_shon17'])) {
            $this->valF['su2_sup_shon17'] = NULL;
        } else {
            $this->valF['su2_sup_shon17'] = $val['su2_sup_shon17'];
        }
        if (!is_numeric($val['su2_sup_shon18'])) {
            $this->valF['su2_sup_shon18'] = NULL;
        } else {
            $this->valF['su2_sup_shon18'] = $val['su2_sup_shon18'];
        }
        if (!is_numeric($val['su2_sup_shon19'])) {
            $this->valF['su2_sup_shon19'] = NULL;
        } else {
            $this->valF['su2_sup_shon19'] = $val['su2_sup_shon19'];
        }
        if (!is_numeric($val['su2_sup_shon20'])) {
            $this->valF['su2_sup_shon20'] = NULL;
        } else {
            $this->valF['su2_sup_shon20'] = $val['su2_sup_shon20'];
        }
        if (!is_numeric($val['su2_sup_shon_tot'])) {
            $this->valF['su2_sup_shon_tot'] = NULL;
        } else {
            $this->valF['su2_sup_shon_tot'] = $val['su2_sup_shon_tot'];
        }
        if (!is_numeric($val['su2_tot_shon1'])) {
            $this->valF['su2_tot_shon1'] = NULL;
        } else {
            $this->valF['su2_tot_shon1'] = $val['su2_tot_shon1'];
        }
        if (!is_numeric($val['su2_tot_shon2'])) {
            $this->valF['su2_tot_shon2'] = NULL;
        } else {
            $this->valF['su2_tot_shon2'] = $val['su2_tot_shon2'];
        }
        if (!is_numeric($val['su2_tot_shon3'])) {
            $this->valF['su2_tot_shon3'] = NULL;
        } else {
            $this->valF['su2_tot_shon3'] = $val['su2_tot_shon3'];
        }
        if (!is_numeric($val['su2_tot_shon4'])) {
            $this->valF['su2_tot_shon4'] = NULL;
        } else {
            $this->valF['su2_tot_shon4'] = $val['su2_tot_shon4'];
        }
        if (!is_numeric($val['su2_tot_shon5'])) {
            $this->valF['su2_tot_shon5'] = NULL;
        } else {
            $this->valF['su2_tot_shon5'] = $val['su2_tot_shon5'];
        }
        if (!is_numeric($val['su2_tot_shon6'])) {
            $this->valF['su2_tot_shon6'] = NULL;
        } else {
            $this->valF['su2_tot_shon6'] = $val['su2_tot_shon6'];
        }
        if (!is_numeric($val['su2_tot_shon7'])) {
            $this->valF['su2_tot_shon7'] = NULL;
        } else {
            $this->valF['su2_tot_shon7'] = $val['su2_tot_shon7'];
        }
        if (!is_numeric($val['su2_tot_shon8'])) {
            $this->valF['su2_tot_shon8'] = NULL;
        } else {
            $this->valF['su2_tot_shon8'] = $val['su2_tot_shon8'];
        }
        if (!is_numeric($val['su2_tot_shon9'])) {
            $this->valF['su2_tot_shon9'] = NULL;
        } else {
            $this->valF['su2_tot_shon9'] = $val['su2_tot_shon9'];
        }
        if (!is_numeric($val['su2_tot_shon10'])) {
            $this->valF['su2_tot_shon10'] = NULL;
        } else {
            $this->valF['su2_tot_shon10'] = $val['su2_tot_shon10'];
        }
        if (!is_numeric($val['su2_tot_shon11'])) {
            $this->valF['su2_tot_shon11'] = NULL;
        } else {
            $this->valF['su2_tot_shon11'] = $val['su2_tot_shon11'];
        }
        if (!is_numeric($val['su2_tot_shon12'])) {
            $this->valF['su2_tot_shon12'] = NULL;
        } else {
            $this->valF['su2_tot_shon12'] = $val['su2_tot_shon12'];
        }
        if (!is_numeric($val['su2_tot_shon13'])) {
            $this->valF['su2_tot_shon13'] = NULL;
        } else {
            $this->valF['su2_tot_shon13'] = $val['su2_tot_shon13'];
        }
        if (!is_numeric($val['su2_tot_shon14'])) {
            $this->valF['su2_tot_shon14'] = NULL;
        } else {
            $this->valF['su2_tot_shon14'] = $val['su2_tot_shon14'];
        }
        if (!is_numeric($val['su2_tot_shon15'])) {
            $this->valF['su2_tot_shon15'] = NULL;
        } else {
            $this->valF['su2_tot_shon15'] = $val['su2_tot_shon15'];
        }
        if (!is_numeric($val['su2_tot_shon16'])) {
            $this->valF['su2_tot_shon16'] = NULL;
        } else {
            $this->valF['su2_tot_shon16'] = $val['su2_tot_shon16'];
        }
        if (!is_numeric($val['su2_tot_shon17'])) {
            $this->valF['su2_tot_shon17'] = NULL;
        } else {
            $this->valF['su2_tot_shon17'] = $val['su2_tot_shon17'];
        }
        if (!is_numeric($val['su2_tot_shon18'])) {
            $this->valF['su2_tot_shon18'] = NULL;
        } else {
            $this->valF['su2_tot_shon18'] = $val['su2_tot_shon18'];
        }
        if (!is_numeric($val['su2_tot_shon19'])) {
            $this->valF['su2_tot_shon19'] = NULL;
        } else {
            $this->valF['su2_tot_shon19'] = $val['su2_tot_shon19'];
        }
        if (!is_numeric($val['su2_tot_shon20'])) {
            $this->valF['su2_tot_shon20'] = NULL;
        } else {
            $this->valF['su2_tot_shon20'] = $val['su2_tot_shon20'];
        }
        if (!is_numeric($val['su2_tot_shon_tot'])) {
            $this->valF['su2_tot_shon_tot'] = NULL;
        } else {
            $this->valF['su2_tot_shon_tot'] = $val['su2_tot_shon_tot'];
        }
            $this->valF['dia_occ_sol_su_terre'] = $val['dia_occ_sol_su_terre'];
            $this->valF['dia_occ_sol_su_pres'] = $val['dia_occ_sol_su_pres'];
            $this->valF['dia_occ_sol_su_verger'] = $val['dia_occ_sol_su_verger'];
            $this->valF['dia_occ_sol_su_vigne'] = $val['dia_occ_sol_su_vigne'];
            $this->valF['dia_occ_sol_su_bois'] = $val['dia_occ_sol_su_bois'];
            $this->valF['dia_occ_sol_su_lande'] = $val['dia_occ_sol_su_lande'];
            $this->valF['dia_occ_sol_su_carriere'] = $val['dia_occ_sol_su_carriere'];
            $this->valF['dia_occ_sol_su_eau_cadastree'] = $val['dia_occ_sol_su_eau_cadastree'];
            $this->valF['dia_occ_sol_su_jardin'] = $val['dia_occ_sol_su_jardin'];
            $this->valF['dia_occ_sol_su_terr_batir'] = $val['dia_occ_sol_su_terr_batir'];
            $this->valF['dia_occ_sol_su_terr_agr'] = $val['dia_occ_sol_su_terr_agr'];
            $this->valF['dia_occ_sol_su_sol'] = $val['dia_occ_sol_su_sol'];
        if ($val['dia_bati_vend_tot'] == 1 || $val['dia_bati_vend_tot'] == "t" || $val['dia_bati_vend_tot'] == "Oui") {
            $this->valF['dia_bati_vend_tot'] = true;
        } else {
            $this->valF['dia_bati_vend_tot'] = false;
        }
            $this->valF['dia_bati_vend_tot_txt'] = $val['dia_bati_vend_tot_txt'];
            $this->valF['dia_su_co_sol'] = $val['dia_su_co_sol'];
            $this->valF['dia_su_util_hab'] = $val['dia_su_util_hab'];
            $this->valF['dia_nb_niv'] = $val['dia_nb_niv'];
            $this->valF['dia_nb_appart'] = $val['dia_nb_appart'];
            $this->valF['dia_nb_autre_loc'] = $val['dia_nb_autre_loc'];
        if ($val['dia_vente_lot_volume'] == 1 || $val['dia_vente_lot_volume'] == "t" || $val['dia_vente_lot_volume'] == "Oui") {
            $this->valF['dia_vente_lot_volume'] = true;
        } else {
            $this->valF['dia_vente_lot_volume'] = false;
        }
            $this->valF['dia_vente_lot_volume_txt'] = $val['dia_vente_lot_volume_txt'];
            $this->valF['dia_lot_nat_su'] = $val['dia_lot_nat_su'];
        if ($val['dia_lot_bat_achv_plus_10'] == 1 || $val['dia_lot_bat_achv_plus_10'] == "t" || $val['dia_lot_bat_achv_plus_10'] == "Oui") {
            $this->valF['dia_lot_bat_achv_plus_10'] = true;
        } else {
            $this->valF['dia_lot_bat_achv_plus_10'] = false;
        }
        if ($val['dia_lot_bat_achv_moins_10'] == 1 || $val['dia_lot_bat_achv_moins_10'] == "t" || $val['dia_lot_bat_achv_moins_10'] == "Oui") {
            $this->valF['dia_lot_bat_achv_moins_10'] = true;
        } else {
            $this->valF['dia_lot_bat_achv_moins_10'] = false;
        }
        if ($val['dia_lot_regl_copro_publ_hypo_plus_10'] == 1 || $val['dia_lot_regl_copro_publ_hypo_plus_10'] == "t" || $val['dia_lot_regl_copro_publ_hypo_plus_10'] == "Oui") {
            $this->valF['dia_lot_regl_copro_publ_hypo_plus_10'] = true;
        } else {
            $this->valF['dia_lot_regl_copro_publ_hypo_plus_10'] = false;
        }
        if ($val['dia_lot_regl_copro_publ_hypo_moins_10'] == 1 || $val['dia_lot_regl_copro_publ_hypo_moins_10'] == "t" || $val['dia_lot_regl_copro_publ_hypo_moins_10'] == "Oui") {
            $this->valF['dia_lot_regl_copro_publ_hypo_moins_10'] = true;
        } else {
            $this->valF['dia_lot_regl_copro_publ_hypo_moins_10'] = false;
        }
            $this->valF['dia_indivi_quote_part'] = $val['dia_indivi_quote_part'];
            $this->valF['dia_design_societe'] = $val['dia_design_societe'];
            $this->valF['dia_design_droit'] = $val['dia_design_droit'];
            $this->valF['dia_droit_soc_nat'] = $val['dia_droit_soc_nat'];
            $this->valF['dia_droit_soc_nb'] = $val['dia_droit_soc_nb'];
            $this->valF['dia_droit_soc_num_part'] = $val['dia_droit_soc_num_part'];
        if ($val['dia_droit_reel_perso_grevant_bien_oui'] == 1 || $val['dia_droit_reel_perso_grevant_bien_oui'] == "t" || $val['dia_droit_reel_perso_grevant_bien_oui'] == "Oui") {
            $this->valF['dia_droit_reel_perso_grevant_bien_oui'] = true;
        } else {
            $this->valF['dia_droit_reel_perso_grevant_bien_oui'] = false;
        }
        if ($val['dia_droit_reel_perso_grevant_bien_non'] == 1 || $val['dia_droit_reel_perso_grevant_bien_non'] == "t" || $val['dia_droit_reel_perso_grevant_bien_non'] == "Oui") {
            $this->valF['dia_droit_reel_perso_grevant_bien_non'] = true;
        } else {
            $this->valF['dia_droit_reel_perso_grevant_bien_non'] = false;
        }
            $this->valF['dia_droit_reel_perso_nat'] = $val['dia_droit_reel_perso_nat'];
            $this->valF['dia_droit_reel_perso_viag'] = $val['dia_droit_reel_perso_viag'];
            $this->valF['dia_mod_cess_adr'] = $val['dia_mod_cess_adr'];
        if ($val['dia_mod_cess_sign_act_auth'] == 1 || $val['dia_mod_cess_sign_act_auth'] == "t" || $val['dia_mod_cess_sign_act_auth'] == "Oui") {
            $this->valF['dia_mod_cess_sign_act_auth'] = true;
        } else {
            $this->valF['dia_mod_cess_sign_act_auth'] = false;
        }
        if ($val['dia_mod_cess_terme'] == 1 || $val['dia_mod_cess_terme'] == "t" || $val['dia_mod_cess_terme'] == "Oui") {
            $this->valF['dia_mod_cess_terme'] = true;
        } else {
            $this->valF['dia_mod_cess_terme'] = false;
        }
            $this->valF['dia_mod_cess_terme_prec'] = $val['dia_mod_cess_terme_prec'];
        if ($val['dia_mod_cess_bene_acquereur'] == 1 || $val['dia_mod_cess_bene_acquereur'] == "t" || $val['dia_mod_cess_bene_acquereur'] == "Oui") {
            $this->valF['dia_mod_cess_bene_acquereur'] = true;
        } else {
            $this->valF['dia_mod_cess_bene_acquereur'] = false;
        }
        if ($val['dia_mod_cess_bene_vendeur'] == 1 || $val['dia_mod_cess_bene_vendeur'] == "t" || $val['dia_mod_cess_bene_vendeur'] == "Oui") {
            $this->valF['dia_mod_cess_bene_vendeur'] = true;
        } else {
            $this->valF['dia_mod_cess_bene_vendeur'] = false;
        }
        if ($val['dia_mod_cess_paie_nat'] == 1 || $val['dia_mod_cess_paie_nat'] == "t" || $val['dia_mod_cess_paie_nat'] == "Oui") {
            $this->valF['dia_mod_cess_paie_nat'] = true;
        } else {
            $this->valF['dia_mod_cess_paie_nat'] = false;
        }
            $this->valF['dia_mod_cess_design_contr_alien'] = $val['dia_mod_cess_design_contr_alien'];
            $this->valF['dia_mod_cess_eval_contr'] = $val['dia_mod_cess_eval_contr'];
        if ($val['dia_mod_cess_rente_viag'] == 1 || $val['dia_mod_cess_rente_viag'] == "t" || $val['dia_mod_cess_rente_viag'] == "Oui") {
            $this->valF['dia_mod_cess_rente_viag'] = true;
        } else {
            $this->valF['dia_mod_cess_rente_viag'] = false;
        }
            $this->valF['dia_mod_cess_mnt_an'] = $val['dia_mod_cess_mnt_an'];
            $this->valF['dia_mod_cess_mnt_compt'] = $val['dia_mod_cess_mnt_compt'];
            $this->valF['dia_mod_cess_bene_rente'] = $val['dia_mod_cess_bene_rente'];
        if ($val['dia_mod_cess_droit_usa_hab'] == 1 || $val['dia_mod_cess_droit_usa_hab'] == "t" || $val['dia_mod_cess_droit_usa_hab'] == "Oui") {
            $this->valF['dia_mod_cess_droit_usa_hab'] = true;
        } else {
            $this->valF['dia_mod_cess_droit_usa_hab'] = false;
        }
            $this->valF['dia_mod_cess_droit_usa_hab_prec'] = $val['dia_mod_cess_droit_usa_hab_prec'];
            $this->valF['dia_mod_cess_eval_usa_usufruit'] = $val['dia_mod_cess_eval_usa_usufruit'];
        if ($val['dia_mod_cess_vente_nue_prop'] == 1 || $val['dia_mod_cess_vente_nue_prop'] == "t" || $val['dia_mod_cess_vente_nue_prop'] == "Oui") {
            $this->valF['dia_mod_cess_vente_nue_prop'] = true;
        } else {
            $this->valF['dia_mod_cess_vente_nue_prop'] = false;
        }
            $this->valF['dia_mod_cess_vente_nue_prop_prec'] = $val['dia_mod_cess_vente_nue_prop_prec'];
        if ($val['dia_mod_cess_echange'] == 1 || $val['dia_mod_cess_echange'] == "t" || $val['dia_mod_cess_echange'] == "Oui") {
            $this->valF['dia_mod_cess_echange'] = true;
        } else {
            $this->valF['dia_mod_cess_echange'] = false;
        }
            $this->valF['dia_mod_cess_design_bien_recus_ech'] = $val['dia_mod_cess_design_bien_recus_ech'];
            $this->valF['dia_mod_cess_mnt_soulte'] = $val['dia_mod_cess_mnt_soulte'];
            $this->valF['dia_mod_cess_prop_contre_echan'] = $val['dia_mod_cess_prop_contre_echan'];
            $this->valF['dia_mod_cess_apport_societe'] = $val['dia_mod_cess_apport_societe'];
            $this->valF['dia_mod_cess_bene'] = $val['dia_mod_cess_bene'];
            $this->valF['dia_mod_cess_esti_bien'] = $val['dia_mod_cess_esti_bien'];
        if ($val['dia_mod_cess_cess_terr_loc_co'] == 1 || $val['dia_mod_cess_cess_terr_loc_co'] == "t" || $val['dia_mod_cess_cess_terr_loc_co'] == "Oui") {
            $this->valF['dia_mod_cess_cess_terr_loc_co'] = true;
        } else {
            $this->valF['dia_mod_cess_cess_terr_loc_co'] = false;
        }
            $this->valF['dia_mod_cess_esti_terr'] = $val['dia_mod_cess_esti_terr'];
            $this->valF['dia_mod_cess_esti_loc'] = $val['dia_mod_cess_esti_loc'];
        if ($val['dia_mod_cess_esti_imm_loca'] == 1 || $val['dia_mod_cess_esti_imm_loca'] == "t" || $val['dia_mod_cess_esti_imm_loca'] == "Oui") {
            $this->valF['dia_mod_cess_esti_imm_loca'] = true;
        } else {
            $this->valF['dia_mod_cess_esti_imm_loca'] = false;
        }
        if ($val['dia_mod_cess_adju_vol'] == 1 || $val['dia_mod_cess_adju_vol'] == "t" || $val['dia_mod_cess_adju_vol'] == "Oui") {
            $this->valF['dia_mod_cess_adju_vol'] = true;
        } else {
            $this->valF['dia_mod_cess_adju_vol'] = false;
        }
        if ($val['dia_mod_cess_adju_obl'] == 1 || $val['dia_mod_cess_adju_obl'] == "t" || $val['dia_mod_cess_adju_obl'] == "Oui") {
            $this->valF['dia_mod_cess_adju_obl'] = true;
        } else {
            $this->valF['dia_mod_cess_adju_obl'] = false;
        }
        if ($val['dia_mod_cess_adju_fin_indivi'] == 1 || $val['dia_mod_cess_adju_fin_indivi'] == "t" || $val['dia_mod_cess_adju_fin_indivi'] == "Oui") {
            $this->valF['dia_mod_cess_adju_fin_indivi'] = true;
        } else {
            $this->valF['dia_mod_cess_adju_fin_indivi'] = false;
        }
            $this->valF['dia_mod_cess_adju_date_lieu'] = $val['dia_mod_cess_adju_date_lieu'];
            $this->valF['dia_mod_cess_mnt_mise_prix'] = $val['dia_mod_cess_mnt_mise_prix'];
        if ($val['dia_prop_titu_prix_indique'] == 1 || $val['dia_prop_titu_prix_indique'] == "t" || $val['dia_prop_titu_prix_indique'] == "Oui") {
            $this->valF['dia_prop_titu_prix_indique'] = true;
        } else {
            $this->valF['dia_prop_titu_prix_indique'] = false;
        }
        if ($val['dia_prop_recherche_acqu_prix_indique'] == 1 || $val['dia_prop_recherche_acqu_prix_indique'] == "t" || $val['dia_prop_recherche_acqu_prix_indique'] == "Oui") {
            $this->valF['dia_prop_recherche_acqu_prix_indique'] = true;
        } else {
            $this->valF['dia_prop_recherche_acqu_prix_indique'] = false;
        }
            $this->valF['dia_acquereur_prof'] = $val['dia_acquereur_prof'];
            $this->valF['dia_indic_compl_ope'] = $val['dia_indic_compl_ope'];
        if ($val['dia_vente_adju'] == 1 || $val['dia_vente_adju'] == "t" || $val['dia_vente_adju'] == "Oui") {
            $this->valF['dia_vente_adju'] = true;
        } else {
            $this->valF['dia_vente_adju'] = false;
        }
        if ($val['am_terr_res_demon'] == 1 || $val['am_terr_res_demon'] == "t" || $val['am_terr_res_demon'] == "Oui") {
            $this->valF['am_terr_res_demon'] = true;
        } else {
            $this->valF['am_terr_res_demon'] = false;
        }
        if ($val['am_air_terr_res_mob'] == 1 || $val['am_air_terr_res_mob'] == "t" || $val['am_air_terr_res_mob'] == "Oui") {
            $this->valF['am_air_terr_res_mob'] = true;
        } else {
            $this->valF['am_air_terr_res_mob'] = false;
        }
        if (!is_numeric($val['ctx_objet_recours'])) {
            $this->valF['ctx_objet_recours'] = NULL;
        } else {
            $this->valF['ctx_objet_recours'] = $val['ctx_objet_recours'];
        }
        if ($val['ctx_reference_sagace'] == "") {
            $this->valF['ctx_reference_sagace'] = NULL;
        } else {
            $this->valF['ctx_reference_sagace'] = $val['ctx_reference_sagace'];
        }
            $this->valF['ctx_nature_travaux_infra_om_html'] = $val['ctx_nature_travaux_infra_om_html'];
            $this->valF['ctx_synthese_nti'] = $val['ctx_synthese_nti'];
            $this->valF['ctx_article_non_resp_om_html'] = $val['ctx_article_non_resp_om_html'];
            $this->valF['ctx_synthese_anr'] = $val['ctx_synthese_anr'];
        if ($val['ctx_reference_parquet'] == "") {
            $this->valF['ctx_reference_parquet'] = NULL;
        } else {
            $this->valF['ctx_reference_parquet'] = $val['ctx_reference_parquet'];
        }
        if ($val['ctx_element_taxation'] == "") {
            $this->valF['ctx_element_taxation'] = NULL;
        } else {
            $this->valF['ctx_element_taxation'] = $val['ctx_element_taxation'];
        }
        if ($val['ctx_infraction'] == 1 || $val['ctx_infraction'] == "t" || $val['ctx_infraction'] == "Oui") {
            $this->valF['ctx_infraction'] = true;
        } else {
            $this->valF['ctx_infraction'] = false;
        }
        if ($val['ctx_regularisable'] == 1 || $val['ctx_regularisable'] == "t" || $val['ctx_regularisable'] == "Oui") {
            $this->valF['ctx_regularisable'] = true;
        } else {
            $this->valF['ctx_regularisable'] = false;
        }
        if ($val['ctx_reference_courrier'] == "") {
            $this->valF['ctx_reference_courrier'] = NULL;
        } else {
            $this->valF['ctx_reference_courrier'] = $val['ctx_reference_courrier'];
        }
        if ($val['ctx_date_audience'] != "") {
            $this->valF['ctx_date_audience'] = $this->dateDB($val['ctx_date_audience']);
        } else {
            $this->valF['ctx_date_audience'] = NULL;
        }
        if ($val['ctx_date_ajournement'] != "") {
            $this->valF['ctx_date_ajournement'] = $this->dateDB($val['ctx_date_ajournement']);
        } else {
            $this->valF['ctx_date_ajournement'] = NULL;
        }
        if ($val['exo_facul_1'] == 1 || $val['exo_facul_1'] == "t" || $val['exo_facul_1'] == "Oui") {
            $this->valF['exo_facul_1'] = true;
        } else {
            $this->valF['exo_facul_1'] = false;
        }
        if ($val['exo_facul_2'] == 1 || $val['exo_facul_2'] == "t" || $val['exo_facul_2'] == "Oui") {
            $this->valF['exo_facul_2'] = true;
        } else {
            $this->valF['exo_facul_2'] = false;
        }
        if ($val['exo_facul_3'] == 1 || $val['exo_facul_3'] == "t" || $val['exo_facul_3'] == "Oui") {
            $this->valF['exo_facul_3'] = true;
        } else {
            $this->valF['exo_facul_3'] = false;
        }
        if ($val['exo_facul_4'] == 1 || $val['exo_facul_4'] == "t" || $val['exo_facul_4'] == "Oui") {
            $this->valF['exo_facul_4'] = true;
        } else {
            $this->valF['exo_facul_4'] = false;
        }
        if ($val['exo_facul_5'] == 1 || $val['exo_facul_5'] == "t" || $val['exo_facul_5'] == "Oui") {
            $this->valF['exo_facul_5'] = true;
        } else {
            $this->valF['exo_facul_5'] = false;
        }
        if ($val['exo_facul_6'] == 1 || $val['exo_facul_6'] == "t" || $val['exo_facul_6'] == "Oui") {
            $this->valF['exo_facul_6'] = true;
        } else {
            $this->valF['exo_facul_6'] = false;
        }
        if ($val['exo_facul_7'] == 1 || $val['exo_facul_7'] == "t" || $val['exo_facul_7'] == "Oui") {
            $this->valF['exo_facul_7'] = true;
        } else {
            $this->valF['exo_facul_7'] = false;
        }
        if ($val['exo_facul_8'] == 1 || $val['exo_facul_8'] == "t" || $val['exo_facul_8'] == "Oui") {
            $this->valF['exo_facul_8'] = true;
        } else {
            $this->valF['exo_facul_8'] = false;
        }
        if ($val['exo_facul_9'] == 1 || $val['exo_facul_9'] == "t" || $val['exo_facul_9'] == "Oui") {
            $this->valF['exo_facul_9'] = true;
        } else {
            $this->valF['exo_facul_9'] = false;
        }
        if ($val['exo_ta_1'] == 1 || $val['exo_ta_1'] == "t" || $val['exo_ta_1'] == "Oui") {
            $this->valF['exo_ta_1'] = true;
        } else {
            $this->valF['exo_ta_1'] = false;
        }
        if ($val['exo_ta_2'] == 1 || $val['exo_ta_2'] == "t" || $val['exo_ta_2'] == "Oui") {
            $this->valF['exo_ta_2'] = true;
        } else {
            $this->valF['exo_ta_2'] = false;
        }
        if ($val['exo_ta_3'] == 1 || $val['exo_ta_3'] == "t" || $val['exo_ta_3'] == "Oui") {
            $this->valF['exo_ta_3'] = true;
        } else {
            $this->valF['exo_ta_3'] = false;
        }
        if ($val['exo_ta_4'] == 1 || $val['exo_ta_4'] == "t" || $val['exo_ta_4'] == "Oui") {
            $this->valF['exo_ta_4'] = true;
        } else {
            $this->valF['exo_ta_4'] = false;
        }
        if ($val['exo_ta_5'] == 1 || $val['exo_ta_5'] == "t" || $val['exo_ta_5'] == "Oui") {
            $this->valF['exo_ta_5'] = true;
        } else {
            $this->valF['exo_ta_5'] = false;
        }
        if ($val['exo_ta_6'] == 1 || $val['exo_ta_6'] == "t" || $val['exo_ta_6'] == "Oui") {
            $this->valF['exo_ta_6'] = true;
        } else {
            $this->valF['exo_ta_6'] = false;
        }
        if ($val['exo_ta_7'] == 1 || $val['exo_ta_7'] == "t" || $val['exo_ta_7'] == "Oui") {
            $this->valF['exo_ta_7'] = true;
        } else {
            $this->valF['exo_ta_7'] = false;
        }
        if ($val['exo_ta_8'] == 1 || $val['exo_ta_8'] == "t" || $val['exo_ta_8'] == "Oui") {
            $this->valF['exo_ta_8'] = true;
        } else {
            $this->valF['exo_ta_8'] = false;
        }
        if ($val['exo_ta_9'] == 1 || $val['exo_ta_9'] == "t" || $val['exo_ta_9'] == "Oui") {
            $this->valF['exo_ta_9'] = true;
        } else {
            $this->valF['exo_ta_9'] = false;
        }
        if ($val['exo_rap_1'] == 1 || $val['exo_rap_1'] == "t" || $val['exo_rap_1'] == "Oui") {
            $this->valF['exo_rap_1'] = true;
        } else {
            $this->valF['exo_rap_1'] = false;
        }
        if ($val['exo_rap_2'] == 1 || $val['exo_rap_2'] == "t" || $val['exo_rap_2'] == "Oui") {
            $this->valF['exo_rap_2'] = true;
        } else {
            $this->valF['exo_rap_2'] = false;
        }
        if ($val['exo_rap_3'] == 1 || $val['exo_rap_3'] == "t" || $val['exo_rap_3'] == "Oui") {
            $this->valF['exo_rap_3'] = true;
        } else {
            $this->valF['exo_rap_3'] = false;
        }
        if ($val['exo_rap_4'] == 1 || $val['exo_rap_4'] == "t" || $val['exo_rap_4'] == "Oui") {
            $this->valF['exo_rap_4'] = true;
        } else {
            $this->valF['exo_rap_4'] = false;
        }
        if ($val['exo_rap_5'] == 1 || $val['exo_rap_5'] == "t" || $val['exo_rap_5'] == "Oui") {
            $this->valF['exo_rap_5'] = true;
        } else {
            $this->valF['exo_rap_5'] = false;
        }
        if ($val['exo_rap_6'] == 1 || $val['exo_rap_6'] == "t" || $val['exo_rap_6'] == "Oui") {
            $this->valF['exo_rap_6'] = true;
        } else {
            $this->valF['exo_rap_6'] = false;
        }
        if ($val['exo_rap_7'] == 1 || $val['exo_rap_7'] == "t" || $val['exo_rap_7'] == "Oui") {
            $this->valF['exo_rap_7'] = true;
        } else {
            $this->valF['exo_rap_7'] = false;
        }
        if ($val['exo_rap_8'] == 1 || $val['exo_rap_8'] == "t" || $val['exo_rap_8'] == "Oui") {
            $this->valF['exo_rap_8'] = true;
        } else {
            $this->valF['exo_rap_8'] = false;
        }
        if (!is_numeric($val['mtn_exo_ta_part_commu'])) {
            $this->valF['mtn_exo_ta_part_commu'] = NULL;
        } else {
            $this->valF['mtn_exo_ta_part_commu'] = $val['mtn_exo_ta_part_commu'];
        }
        if (!is_numeric($val['mtn_exo_ta_part_depart'])) {
            $this->valF['mtn_exo_ta_part_depart'] = NULL;
        } else {
            $this->valF['mtn_exo_ta_part_depart'] = $val['mtn_exo_ta_part_depart'];
        }
        if (!is_numeric($val['mtn_exo_ta_part_reg'])) {
            $this->valF['mtn_exo_ta_part_reg'] = NULL;
        } else {
            $this->valF['mtn_exo_ta_part_reg'] = $val['mtn_exo_ta_part_reg'];
        }
        if (!is_numeric($val['mtn_exo_rap'])) {
            $this->valF['mtn_exo_rap'] = NULL;
        } else {
            $this->valF['mtn_exo_rap'] = $val['mtn_exo_rap'];
        }
        if ($val['dpc_type'] == "") {
            $this->valF['dpc_type'] = NULL;
        } else {
            $this->valF['dpc_type'] = $val['dpc_type'];
        }
            $this->valF['dpc_desc_actv_ex'] = $val['dpc_desc_actv_ex'];
            $this->valF['dpc_desc_ca'] = $val['dpc_desc_ca'];
            $this->valF['dpc_desc_aut_prec'] = $val['dpc_desc_aut_prec'];
        if ($val['dpc_desig_comm_arti'] == 1 || $val['dpc_desig_comm_arti'] == "t" || $val['dpc_desig_comm_arti'] == "Oui") {
            $this->valF['dpc_desig_comm_arti'] = true;
        } else {
            $this->valF['dpc_desig_comm_arti'] = false;
        }
        if ($val['dpc_desig_loc_hab'] == 1 || $val['dpc_desig_loc_hab'] == "t" || $val['dpc_desig_loc_hab'] == "Oui") {
            $this->valF['dpc_desig_loc_hab'] = true;
        } else {
            $this->valF['dpc_desig_loc_hab'] = false;
        }
        if ($val['dpc_desig_loc_ann'] == 1 || $val['dpc_desig_loc_ann'] == "t" || $val['dpc_desig_loc_ann'] == "Oui") {
            $this->valF['dpc_desig_loc_ann'] = true;
        } else {
            $this->valF['dpc_desig_loc_ann'] = false;
        }
            $this->valF['dpc_desig_loc_ann_prec'] = $val['dpc_desig_loc_ann_prec'];
        if ($val['dpc_bail_comm_date'] != "") {
            $this->valF['dpc_bail_comm_date'] = $this->dateDB($val['dpc_bail_comm_date']);
        } else {
            $this->valF['dpc_bail_comm_date'] = NULL;
        }
            $this->valF['dpc_bail_comm_loyer'] = $val['dpc_bail_comm_loyer'];
            $this->valF['dpc_actv_acqu'] = $val['dpc_actv_acqu'];
            $this->valF['dpc_nb_sala_di'] = $val['dpc_nb_sala_di'];
            $this->valF['dpc_nb_sala_dd'] = $val['dpc_nb_sala_dd'];
            $this->valF['dpc_nb_sala_tc'] = $val['dpc_nb_sala_tc'];
            $this->valF['dpc_nb_sala_tp'] = $val['dpc_nb_sala_tp'];
        if ($val['dpc_moda_cess_vente_am'] == 1 || $val['dpc_moda_cess_vente_am'] == "t" || $val['dpc_moda_cess_vente_am'] == "Oui") {
            $this->valF['dpc_moda_cess_vente_am'] = true;
        } else {
            $this->valF['dpc_moda_cess_vente_am'] = false;
        }
        if ($val['dpc_moda_cess_adj'] == 1 || $val['dpc_moda_cess_adj'] == "t" || $val['dpc_moda_cess_adj'] == "Oui") {
            $this->valF['dpc_moda_cess_adj'] = true;
        } else {
            $this->valF['dpc_moda_cess_adj'] = false;
        }
            $this->valF['dpc_moda_cess_prix'] = $val['dpc_moda_cess_prix'];
        if ($val['dpc_moda_cess_adj_date'] != "") {
            $this->valF['dpc_moda_cess_adj_date'] = $this->dateDB($val['dpc_moda_cess_adj_date']);
        } else {
            $this->valF['dpc_moda_cess_adj_date'] = NULL;
        }
            $this->valF['dpc_moda_cess_adj_prec'] = $val['dpc_moda_cess_adj_prec'];
        if ($val['dpc_moda_cess_paie_comp'] == 1 || $val['dpc_moda_cess_paie_comp'] == "t" || $val['dpc_moda_cess_paie_comp'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_comp'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_comp'] = false;
        }
        if ($val['dpc_moda_cess_paie_terme'] == 1 || $val['dpc_moda_cess_paie_terme'] == "t" || $val['dpc_moda_cess_paie_terme'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_terme'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_terme'] = false;
        }
            $this->valF['dpc_moda_cess_paie_terme_prec'] = $val['dpc_moda_cess_paie_terme_prec'];
        if ($val['dpc_moda_cess_paie_nat'] == 1 || $val['dpc_moda_cess_paie_nat'] == "t" || $val['dpc_moda_cess_paie_nat'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_nat'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_nat'] = false;
        }
        if ($val['dpc_moda_cess_paie_nat_desig_alien'] == 1 || $val['dpc_moda_cess_paie_nat_desig_alien'] == "t" || $val['dpc_moda_cess_paie_nat_desig_alien'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_nat_desig_alien'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_nat_desig_alien'] = false;
        }
            $this->valF['dpc_moda_cess_paie_nat_desig_alien_prec'] = $val['dpc_moda_cess_paie_nat_desig_alien_prec'];
        if ($val['dpc_moda_cess_paie_nat_eval'] == 1 || $val['dpc_moda_cess_paie_nat_eval'] == "t" || $val['dpc_moda_cess_paie_nat_eval'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_nat_eval'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_nat_eval'] = false;
        }
            $this->valF['dpc_moda_cess_paie_nat_eval_prec'] = $val['dpc_moda_cess_paie_nat_eval_prec'];
        if ($val['dpc_moda_cess_paie_aut'] == 1 || $val['dpc_moda_cess_paie_aut'] == "t" || $val['dpc_moda_cess_paie_aut'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_aut'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_aut'] = false;
        }
            $this->valF['dpc_moda_cess_paie_aut_prec'] = $val['dpc_moda_cess_paie_aut_prec'];
        if ($val['dpc_ss_signe_demande_acqu'] == 1 || $val['dpc_ss_signe_demande_acqu'] == "t" || $val['dpc_ss_signe_demande_acqu'] == "Oui") {
            $this->valF['dpc_ss_signe_demande_acqu'] = true;
        } else {
            $this->valF['dpc_ss_signe_demande_acqu'] = false;
        }
        if ($val['dpc_ss_signe_recher_trouv_acqu'] == 1 || $val['dpc_ss_signe_recher_trouv_acqu'] == "t" || $val['dpc_ss_signe_recher_trouv_acqu'] == "Oui") {
            $this->valF['dpc_ss_signe_recher_trouv_acqu'] = true;
        } else {
            $this->valF['dpc_ss_signe_recher_trouv_acqu'] = false;
        }
        if ($val['dpc_notif_adr_prop'] == 1 || $val['dpc_notif_adr_prop'] == "t" || $val['dpc_notif_adr_prop'] == "Oui") {
            $this->valF['dpc_notif_adr_prop'] = true;
        } else {
            $this->valF['dpc_notif_adr_prop'] = false;
        }
        if ($val['dpc_notif_adr_manda'] == 1 || $val['dpc_notif_adr_manda'] == "t" || $val['dpc_notif_adr_manda'] == "Oui") {
            $this->valF['dpc_notif_adr_manda'] = true;
        } else {
            $this->valF['dpc_notif_adr_manda'] = false;
        }
            $this->valF['dpc_obs'] = $val['dpc_obs'];
        if ($val['co_peri_site_patri_remar'] == 1 || $val['co_peri_site_patri_remar'] == "t" || $val['co_peri_site_patri_remar'] == "Oui") {
            $this->valF['co_peri_site_patri_remar'] = true;
        } else {
            $this->valF['co_peri_site_patri_remar'] = false;
        }
        if ($val['co_abo_monu_hist'] == 1 || $val['co_abo_monu_hist'] == "t" || $val['co_abo_monu_hist'] == "Oui") {
            $this->valF['co_abo_monu_hist'] = true;
        } else {
            $this->valF['co_abo_monu_hist'] = false;
        }
        if ($val['co_inst_ouvr_trav_act_code_envir'] == 1 || $val['co_inst_ouvr_trav_act_code_envir'] == "t" || $val['co_inst_ouvr_trav_act_code_envir'] == "Oui") {
            $this->valF['co_inst_ouvr_trav_act_code_envir'] = true;
        } else {
            $this->valF['co_inst_ouvr_trav_act_code_envir'] = false;
        }
        if ($val['co_trav_auto_env'] == 1 || $val['co_trav_auto_env'] == "t" || $val['co_trav_auto_env'] == "Oui") {
            $this->valF['co_trav_auto_env'] = true;
        } else {
            $this->valF['co_trav_auto_env'] = false;
        }
        if ($val['co_derog_esp_prot'] == 1 || $val['co_derog_esp_prot'] == "t" || $val['co_derog_esp_prot'] == "Oui") {
            $this->valF['co_derog_esp_prot'] = true;
        } else {
            $this->valF['co_derog_esp_prot'] = false;
        }
        if ($val['ctx_reference_dsj'] == "") {
            $this->valF['ctx_reference_dsj'] = NULL;
        } else {
            $this->valF['ctx_reference_dsj'] = $val['ctx_reference_dsj'];
        }
        if ($val['co_piscine'] == 1 || $val['co_piscine'] == "t" || $val['co_piscine'] == "Oui") {
            $this->valF['co_piscine'] = true;
        } else {
            $this->valF['co_piscine'] = false;
        }
        if ($val['co_fin_lls'] == 1 || $val['co_fin_lls'] == "t" || $val['co_fin_lls'] == "Oui") {
            $this->valF['co_fin_lls'] = true;
        } else {
            $this->valF['co_fin_lls'] = false;
        }
        if ($val['co_fin_aa'] == 1 || $val['co_fin_aa'] == "t" || $val['co_fin_aa'] == "Oui") {
            $this->valF['co_fin_aa'] = true;
        } else {
            $this->valF['co_fin_aa'] = false;
        }
        if ($val['co_fin_ptz'] == 1 || $val['co_fin_ptz'] == "t" || $val['co_fin_ptz'] == "Oui") {
            $this->valF['co_fin_ptz'] = true;
        } else {
            $this->valF['co_fin_ptz'] = false;
        }
            $this->valF['co_fin_autr'] = $val['co_fin_autr'];
        if ($val['dia_ss_date'] != "") {
            $this->valF['dia_ss_date'] = $this->dateDB($val['dia_ss_date']);
        } else {
            $this->valF['dia_ss_date'] = NULL;
        }
        if ($val['dia_ss_lieu'] == "") {
            $this->valF['dia_ss_lieu'] = NULL;
        } else {
            $this->valF['dia_ss_lieu'] = $val['dia_ss_lieu'];
        }
        if ($val['enga_decla_lieu'] == "") {
            $this->valF['enga_decla_lieu'] = NULL;
        } else {
            $this->valF['enga_decla_lieu'] = $val['enga_decla_lieu'];
        }
        if ($val['enga_decla_date'] != "") {
            $this->valF['enga_decla_date'] = $this->dateDB($val['enga_decla_date']);
        } else {
            $this->valF['enga_decla_date'] = NULL;
        }
        if ($val['co_archi_attest_honneur'] == 1 || $val['co_archi_attest_honneur'] == "t" || $val['co_archi_attest_honneur'] == "Oui") {
            $this->valF['co_archi_attest_honneur'] = true;
        } else {
            $this->valF['co_archi_attest_honneur'] = false;
        }
        if (!is_numeric($val['co_bat_niv_dessous_nb'])) {
            $this->valF['co_bat_niv_dessous_nb'] = NULL;
        } else {
            $this->valF['co_bat_niv_dessous_nb'] = $val['co_bat_niv_dessous_nb'];
        }
        if ($val['co_install_classe'] == 1 || $val['co_install_classe'] == "t" || $val['co_install_classe'] == "Oui") {
            $this->valF['co_install_classe'] = true;
        } else {
            $this->valF['co_install_classe'] = false;
        }
        if ($val['co_derog_innov'] == 1 || $val['co_derog_innov'] == "t" || $val['co_derog_innov'] == "Oui") {
            $this->valF['co_derog_innov'] = true;
        } else {
            $this->valF['co_derog_innov'] = false;
        }
        if ($val['co_avis_abf'] == 1 || $val['co_avis_abf'] == "t" || $val['co_avis_abf'] == "Oui") {
            $this->valF['co_avis_abf'] = true;
        } else {
            $this->valF['co_avis_abf'] = false;
        }
        if (!is_numeric($val['tax_surf_tot_demo'])) {
            $this->valF['tax_surf_tot_demo'] = NULL;
        } else {
            $this->valF['tax_surf_tot_demo'] = $val['tax_surf_tot_demo'];
        }
        if (!is_numeric($val['tax_surf_tax_demo'])) {
            $this->valF['tax_surf_tax_demo'] = NULL;
        } else {
            $this->valF['tax_surf_tax_demo'] = $val['tax_surf_tax_demo'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf8'])) {
            $this->valF['tax_su_non_habit_surf8'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf8'] = $val['tax_su_non_habit_surf8'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_stat8'])) {
            $this->valF['tax_su_non_habit_surf_stat8'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_stat8'] = $val['tax_su_non_habit_surf_stat8'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf9'])) {
            $this->valF['tax_su_non_habit_surf9'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf9'] = $val['tax_su_non_habit_surf9'];
        }
        if (!is_numeric($val['tax_su_non_habit_surf_stat9'])) {
            $this->valF['tax_su_non_habit_surf_stat9'] = NULL;
        } else {
            $this->valF['tax_su_non_habit_surf_stat9'] = $val['tax_su_non_habit_surf_stat9'];
        }
        if ($val['tax_terrassement_arch'] == 1 || $val['tax_terrassement_arch'] == "t" || $val['tax_terrassement_arch'] == "Oui") {
            $this->valF['tax_terrassement_arch'] = true;
        } else {
            $this->valF['tax_terrassement_arch'] = false;
        }
        if ($val['tax_adresse_future_numero'] == "") {
            $this->valF['tax_adresse_future_numero'] = NULL;
        } else {
            $this->valF['tax_adresse_future_numero'] = $val['tax_adresse_future_numero'];
        }
        if ($val['tax_adresse_future_voie'] == "") {
            $this->valF['tax_adresse_future_voie'] = NULL;
        } else {
            $this->valF['tax_adresse_future_voie'] = $val['tax_adresse_future_voie'];
        }
        if ($val['tax_adresse_future_lieudit'] == "") {
            $this->valF['tax_adresse_future_lieudit'] = NULL;
        } else {
            $this->valF['tax_adresse_future_lieudit'] = $val['tax_adresse_future_lieudit'];
        }
        if ($val['tax_adresse_future_localite'] == "") {
            $this->valF['tax_adresse_future_localite'] = NULL;
        } else {
            $this->valF['tax_adresse_future_localite'] = $val['tax_adresse_future_localite'];
        }
        if ($val['tax_adresse_future_cp'] == "") {
            $this->valF['tax_adresse_future_cp'] = NULL;
        } else {
            $this->valF['tax_adresse_future_cp'] = $val['tax_adresse_future_cp'];
        }
        if ($val['tax_adresse_future_bp'] == "") {
            $this->valF['tax_adresse_future_bp'] = NULL;
        } else {
            $this->valF['tax_adresse_future_bp'] = $val['tax_adresse_future_bp'];
        }
        if ($val['tax_adresse_future_cedex'] == "") {
            $this->valF['tax_adresse_future_cedex'] = NULL;
        } else {
            $this->valF['tax_adresse_future_cedex'] = $val['tax_adresse_future_cedex'];
        }
        if ($val['tax_adresse_future_pays'] == "") {
            $this->valF['tax_adresse_future_pays'] = NULL;
        } else {
            $this->valF['tax_adresse_future_pays'] = $val['tax_adresse_future_pays'];
        }
        if ($val['tax_adresse_future_division'] == "") {
            $this->valF['tax_adresse_future_division'] = NULL;
        } else {
            $this->valF['tax_adresse_future_division'] = $val['tax_adresse_future_division'];
        }
            $this->valF['co_bat_projete'] = $val['co_bat_projete'];
            $this->valF['co_bat_existant'] = $val['co_bat_existant'];
            $this->valF['co_bat_nature'] = $val['co_bat_nature'];
        if ($val['terr_juri_titul_date'] != "") {
            $this->valF['terr_juri_titul_date'] = $this->dateDB($val['terr_juri_titul_date']);
        } else {
            $this->valF['terr_juri_titul_date'] = NULL;
        }
            $this->valF['co_autre_desc'] = $val['co_autre_desc'];
            $this->valF['co_trx_autre'] = $val['co_trx_autre'];
        if ($val['co_autre'] == 1 || $val['co_autre'] == "t" || $val['co_autre'] == "Oui") {
            $this->valF['co_autre'] = true;
        } else {
            $this->valF['co_autre'] = false;
        }
        if ($val['erp_modif_facades'] == 1 || $val['erp_modif_facades'] == "t" || $val['erp_modif_facades'] == "Oui") {
            $this->valF['erp_modif_facades'] = true;
        } else {
            $this->valF['erp_modif_facades'] = false;
        }
        if ($val['erp_trvx_adap'] == 1 || $val['erp_trvx_adap'] == "t" || $val['erp_trvx_adap'] == "Oui") {
            $this->valF['erp_trvx_adap'] = true;
        } else {
            $this->valF['erp_trvx_adap'] = false;
        }
        if ($val['erp_trvx_adap_numero'] == "") {
            $this->valF['erp_trvx_adap_numero'] = NULL;
        } else {
            $this->valF['erp_trvx_adap_numero'] = $val['erp_trvx_adap_numero'];
        }
        if ($val['erp_trvx_adap_valid'] != "") {
            $this->valF['erp_trvx_adap_valid'] = $this->dateDB($val['erp_trvx_adap_valid']);
        } else {
            $this->valF['erp_trvx_adap_valid'] = NULL;
        }
        if ($val['erp_prod_dangereux'] == 1 || $val['erp_prod_dangereux'] == "t" || $val['erp_prod_dangereux'] == "Oui") {
            $this->valF['erp_prod_dangereux'] = true;
        } else {
            $this->valF['erp_prod_dangereux'] = false;
        }
        if (!is_numeric($val['co_trav_supp_dessus'])) {
            $this->valF['co_trav_supp_dessus'] = NULL;
        } else {
            $this->valF['co_trav_supp_dessus'] = $val['co_trav_supp_dessus'];
        }
        if (!is_numeric($val['co_trav_supp_dessous'])) {
            $this->valF['co_trav_supp_dessous'] = NULL;
        } else {
            $this->valF['co_trav_supp_dessous'] = $val['co_trav_supp_dessous'];
        }
        if (!is_numeric($val['tax_su_habit_abr_jard_pig_colom'])) {
            $this->valF['tax_su_habit_abr_jard_pig_colom'] = NULL;
        } else {
            $this->valF['tax_su_habit_abr_jard_pig_colom'] = $val['tax_su_habit_abr_jard_pig_colom'];
        }
        if ($val['enga_decla_donnees_nomi_comm'] == 1 || $val['enga_decla_donnees_nomi_comm'] == "t" || $val['enga_decla_donnees_nomi_comm'] == "Oui") {
            $this->valF['enga_decla_donnees_nomi_comm'] = true;
        } else {
            $this->valF['enga_decla_donnees_nomi_comm'] = false;
        }
        if ($val['x1l_legislation'] == 1 || $val['x1l_legislation'] == "t" || $val['x1l_legislation'] == "Oui") {
            $this->valF['x1l_legislation'] = true;
        } else {
            $this->valF['x1l_legislation'] = false;
        }
        if ($val['x1p_precisions'] == "") {
            $this->valF['x1p_precisions'] = NULL;
        } else {
            $this->valF['x1p_precisions'] = $val['x1p_precisions'];
        }
        if ($val['x1u_raccordement'] == 1 || $val['x1u_raccordement'] == "t" || $val['x1u_raccordement'] == "Oui") {
            $this->valF['x1u_raccordement'] = true;
        } else {
            $this->valF['x1u_raccordement'] = false;
        }
        if ($val['x2m_inscritmh'] == 1 || $val['x2m_inscritmh'] == "t" || $val['x2m_inscritmh'] == "Oui") {
            $this->valF['x2m_inscritmh'] = true;
        } else {
            $this->valF['x2m_inscritmh'] = false;
        }
        if (!is_numeric($val['s1na1_numero'])) {
            $this->valF['s1na1_numero'] = NULL;
        } else {
            $this->valF['s1na1_numero'] = $val['s1na1_numero'];
        }
        if ($val['s1va1_voie'] == "") {
            $this->valF['s1va1_voie'] = NULL;
        } else {
            $this->valF['s1va1_voie'] = $val['s1va1_voie'];
        }
        if ($val['s1wa1_lieudit'] == "") {
            $this->valF['s1wa1_lieudit'] = NULL;
        } else {
            $this->valF['s1wa1_lieudit'] = $val['s1wa1_lieudit'];
        }
        if ($val['s1la1_localite'] == "") {
            $this->valF['s1la1_localite'] = NULL;
        } else {
            $this->valF['s1la1_localite'] = $val['s1la1_localite'];
        }
        if ($val['s1pa1_codepostal'] == "") {
            $this->valF['s1pa1_codepostal'] = NULL;
        } else {
            $this->valF['s1pa1_codepostal'] = $val['s1pa1_codepostal'];
        }
        if (!is_numeric($val['s1na2_numero'])) {
            $this->valF['s1na2_numero'] = NULL;
        } else {
            $this->valF['s1na2_numero'] = $val['s1na2_numero'];
        }
        if ($val['s1va2_voie'] == "") {
            $this->valF['s1va2_voie'] = NULL;
        } else {
            $this->valF['s1va2_voie'] = $val['s1va2_voie'];
        }
        if ($val['s1wa2_lieudit'] == "") {
            $this->valF['s1wa2_lieudit'] = NULL;
        } else {
            $this->valF['s1wa2_lieudit'] = $val['s1wa2_lieudit'];
        }
        if ($val['s1la2_localite'] == "") {
            $this->valF['s1la2_localite'] = NULL;
        } else {
            $this->valF['s1la2_localite'] = $val['s1la2_localite'];
        }
        if ($val['s1pa2_codepostal'] == "") {
            $this->valF['s1pa2_codepostal'] = NULL;
        } else {
            $this->valF['s1pa2_codepostal'] = $val['s1pa2_codepostal'];
        }
        if ($val['e3c_certification'] == 1 || $val['e3c_certification'] == "t" || $val['e3c_certification'] == "Oui") {
            $this->valF['e3c_certification'] = true;
        } else {
            $this->valF['e3c_certification'] = false;
        }
        if ($val['e3a_competence'] == 1 || $val['e3a_competence'] == "t" || $val['e3a_competence'] == "Oui") {
            $this->valF['e3a_competence'] = true;
        } else {
            $this->valF['e3a_competence'] = false;
        }
        if ($val['a4d_description'] == "") {
            $this->valF['a4d_description'] = NULL;
        } else {
            $this->valF['a4d_description'] = $val['a4d_description'];
        }
        if ($val['m2b_abf'] == 1 || $val['m2b_abf'] == "t" || $val['m2b_abf'] == "Oui") {
            $this->valF['m2b_abf'] = true;
        } else {
            $this->valF['m2b_abf'] = false;
        }
        if ($val['m2j_pn'] == 1 || $val['m2j_pn'] == "t" || $val['m2j_pn'] == "Oui") {
            $this->valF['m2j_pn'] = true;
        } else {
            $this->valF['m2j_pn'] = false;
        }
        if ($val['m2r_cdac'] == 1 || $val['m2r_cdac'] == "t" || $val['m2r_cdac'] == "Oui") {
            $this->valF['m2r_cdac'] = true;
        } else {
            $this->valF['m2r_cdac'] = false;
        }
        if ($val['m2r_cnac'] == 1 || $val['m2r_cnac'] == "t" || $val['m2r_cnac'] == "Oui") {
            $this->valF['m2r_cnac'] = true;
        } else {
            $this->valF['m2r_cnac'] = false;
        }
        if ($val['u3a_voirieoui'] == 1 || $val['u3a_voirieoui'] == "t" || $val['u3a_voirieoui'] == "Oui") {
            $this->valF['u3a_voirieoui'] = true;
        } else {
            $this->valF['u3a_voirieoui'] = false;
        }
        if ($val['u3f_voirienon'] == 1 || $val['u3f_voirienon'] == "t" || $val['u3f_voirienon'] == "Oui") {
            $this->valF['u3f_voirienon'] = true;
        } else {
            $this->valF['u3f_voirienon'] = false;
        }
        if ($val['u3c_eauoui'] == 1 || $val['u3c_eauoui'] == "t" || $val['u3c_eauoui'] == "Oui") {
            $this->valF['u3c_eauoui'] = true;
        } else {
            $this->valF['u3c_eauoui'] = false;
        }
        if ($val['u3h_eaunon'] == 1 || $val['u3h_eaunon'] == "t" || $val['u3h_eaunon'] == "Oui") {
            $this->valF['u3h_eaunon'] = true;
        } else {
            $this->valF['u3h_eaunon'] = false;
        }
        if ($val['u3g_assainissementoui'] == 1 || $val['u3g_assainissementoui'] == "t" || $val['u3g_assainissementoui'] == "Oui") {
            $this->valF['u3g_assainissementoui'] = true;
        } else {
            $this->valF['u3g_assainissementoui'] = false;
        }
        if ($val['u3n_assainissementnon'] == 1 || $val['u3n_assainissementnon'] == "t" || $val['u3n_assainissementnon'] == "Oui") {
            $this->valF['u3n_assainissementnon'] = true;
        } else {
            $this->valF['u3n_assainissementnon'] = false;
        }
        if ($val['u3m_electriciteoui'] == 1 || $val['u3m_electriciteoui'] == "t" || $val['u3m_electriciteoui'] == "Oui") {
            $this->valF['u3m_electriciteoui'] = true;
        } else {
            $this->valF['u3m_electriciteoui'] = false;
        }
        if ($val['u3b_electricitenon'] == 1 || $val['u3b_electricitenon'] == "t" || $val['u3b_electricitenon'] == "Oui") {
            $this->valF['u3b_electricitenon'] = true;
        } else {
            $this->valF['u3b_electricitenon'] = false;
        }
        if ($val['u3t_observations'] == "") {
            $this->valF['u3t_observations'] = NULL;
        } else {
            $this->valF['u3t_observations'] = $val['u3t_observations'];
        }
        if ($val['u1a_voirieoui'] == 1 || $val['u1a_voirieoui'] == "t" || $val['u1a_voirieoui'] == "Oui") {
            $this->valF['u1a_voirieoui'] = true;
        } else {
            $this->valF['u1a_voirieoui'] = false;
        }
        if ($val['u1v_voirienon'] == 1 || $val['u1v_voirienon'] == "t" || $val['u1v_voirienon'] == "Oui") {
            $this->valF['u1v_voirienon'] = true;
        } else {
            $this->valF['u1v_voirienon'] = false;
        }
        if ($val['u1q_voirieconcessionnaire'] == "") {
            $this->valF['u1q_voirieconcessionnaire'] = NULL;
        } else {
            $this->valF['u1q_voirieconcessionnaire'] = $val['u1q_voirieconcessionnaire'];
        }
        if ($val['u1b_voirieavant'] != "") {
            $this->valF['u1b_voirieavant'] = $this->dateDB($val['u1b_voirieavant']);
        } else {
            $this->valF['u1b_voirieavant'] = NULL;
        }
        if ($val['u1j_eauoui'] == 1 || $val['u1j_eauoui'] == "t" || $val['u1j_eauoui'] == "Oui") {
            $this->valF['u1j_eauoui'] = true;
        } else {
            $this->valF['u1j_eauoui'] = false;
        }
        if ($val['u1t_eaunon'] == 1 || $val['u1t_eaunon'] == "t" || $val['u1t_eaunon'] == "Oui") {
            $this->valF['u1t_eaunon'] = true;
        } else {
            $this->valF['u1t_eaunon'] = false;
        }
        if ($val['u1e_eauconcessionnaire'] == "") {
            $this->valF['u1e_eauconcessionnaire'] = NULL;
        } else {
            $this->valF['u1e_eauconcessionnaire'] = $val['u1e_eauconcessionnaire'];
        }
        if ($val['u1k_eauavant'] != "") {
            $this->valF['u1k_eauavant'] = $this->dateDB($val['u1k_eauavant']);
        } else {
            $this->valF['u1k_eauavant'] = NULL;
        }
        if ($val['u1s_assainissementoui'] == 1 || $val['u1s_assainissementoui'] == "t" || $val['u1s_assainissementoui'] == "Oui") {
            $this->valF['u1s_assainissementoui'] = true;
        } else {
            $this->valF['u1s_assainissementoui'] = false;
        }
        if ($val['u1d_assainissementnon'] == 1 || $val['u1d_assainissementnon'] == "t" || $val['u1d_assainissementnon'] == "Oui") {
            $this->valF['u1d_assainissementnon'] = true;
        } else {
            $this->valF['u1d_assainissementnon'] = false;
        }
        if ($val['u1l_assainissementconcessionnaire'] == "") {
            $this->valF['u1l_assainissementconcessionnaire'] = NULL;
        } else {
            $this->valF['u1l_assainissementconcessionnaire'] = $val['u1l_assainissementconcessionnaire'];
        }
        if ($val['u1r_assainissementavant'] != "") {
            $this->valF['u1r_assainissementavant'] = $this->dateDB($val['u1r_assainissementavant']);
        } else {
            $this->valF['u1r_assainissementavant'] = NULL;
        }
        if ($val['u1c_electriciteoui'] == 1 || $val['u1c_electriciteoui'] == "t" || $val['u1c_electriciteoui'] == "Oui") {
            $this->valF['u1c_electriciteoui'] = true;
        } else {
            $this->valF['u1c_electriciteoui'] = false;
        }
        if ($val['u1u_electricitenon'] == 1 || $val['u1u_electricitenon'] == "t" || $val['u1u_electricitenon'] == "Oui") {
            $this->valF['u1u_electricitenon'] = true;
        } else {
            $this->valF['u1u_electricitenon'] = false;
        }
        if ($val['u1m_electriciteconcessionnaire'] == "") {
            $this->valF['u1m_electriciteconcessionnaire'] = NULL;
        } else {
            $this->valF['u1m_electriciteconcessionnaire'] = $val['u1m_electriciteconcessionnaire'];
        }
        if ($val['u1f_electriciteavant'] != "") {
            $this->valF['u1f_electriciteavant'] = $this->dateDB($val['u1f_electriciteavant']);
        } else {
            $this->valF['u1f_electriciteavant'] = NULL;
        }
        if ($val['u2a_observations'] == "") {
            $this->valF['u2a_observations'] = NULL;
        } else {
            $this->valF['u2a_observations'] = $val['u2a_observations'];
        }
        if (!is_numeric($val['f1ts4_surftaxestation'])) {
            $this->valF['f1ts4_surftaxestation'] = NULL;
        } else {
            $this->valF['f1ts4_surftaxestation'] = $val['f1ts4_surftaxestation'];
        }
        if (!is_numeric($val['f1ut1_surfcree'])) {
            $this->valF['f1ut1_surfcree'] = NULL;
        } else {
            $this->valF['f1ut1_surfcree'] = $val['f1ut1_surfcree'];
        }
        if ($val['f9d_date'] != "") {
            $this->valF['f9d_date'] = $this->dateDB($val['f9d_date']);
        } else {
            $this->valF['f9d_date'] = NULL;
        }
        if ($val['f9n_nom'] == "") {
            $this->valF['f9n_nom'] = NULL;
        } else {
            $this->valF['f9n_nom'] = $val['f9n_nom'];
        }
        if (!is_numeric($val['su2_avt_shon21'])) {
            $this->valF['su2_avt_shon21'] = NULL;
        } else {
            $this->valF['su2_avt_shon21'] = $val['su2_avt_shon21'];
        }
        if (!is_numeric($val['su2_avt_shon22'])) {
            $this->valF['su2_avt_shon22'] = NULL;
        } else {
            $this->valF['su2_avt_shon22'] = $val['su2_avt_shon22'];
        }
        if (!is_numeric($val['su2_cstr_shon21'])) {
            $this->valF['su2_cstr_shon21'] = NULL;
        } else {
            $this->valF['su2_cstr_shon21'] = $val['su2_cstr_shon21'];
        }
        if (!is_numeric($val['su2_cstr_shon22'])) {
            $this->valF['su2_cstr_shon22'] = NULL;
        } else {
            $this->valF['su2_cstr_shon22'] = $val['su2_cstr_shon22'];
        }
        if (!is_numeric($val['su2_chge_shon21'])) {
            $this->valF['su2_chge_shon21'] = NULL;
        } else {
            $this->valF['su2_chge_shon21'] = $val['su2_chge_shon21'];
        }
        if (!is_numeric($val['su2_chge_shon22'])) {
            $this->valF['su2_chge_shon22'] = NULL;
        } else {
            $this->valF['su2_chge_shon22'] = $val['su2_chge_shon22'];
        }
        if (!is_numeric($val['su2_demo_shon21'])) {
            $this->valF['su2_demo_shon21'] = NULL;
        } else {
            $this->valF['su2_demo_shon21'] = $val['su2_demo_shon21'];
        }
        if (!is_numeric($val['su2_demo_shon22'])) {
            $this->valF['su2_demo_shon22'] = NULL;
        } else {
            $this->valF['su2_demo_shon22'] = $val['su2_demo_shon22'];
        }
        if (!is_numeric($val['su2_sup_shon21'])) {
            $this->valF['su2_sup_shon21'] = NULL;
        } else {
            $this->valF['su2_sup_shon21'] = $val['su2_sup_shon21'];
        }
        if (!is_numeric($val['su2_sup_shon22'])) {
            $this->valF['su2_sup_shon22'] = NULL;
        } else {
            $this->valF['su2_sup_shon22'] = $val['su2_sup_shon22'];
        }
        if (!is_numeric($val['su2_tot_shon21'])) {
            $this->valF['su2_tot_shon21'] = NULL;
        } else {
            $this->valF['su2_tot_shon21'] = $val['su2_tot_shon21'];
        }
        if (!is_numeric($val['su2_tot_shon22'])) {
            $this->valF['su2_tot_shon22'] = NULL;
        } else {
            $this->valF['su2_tot_shon22'] = $val['su2_tot_shon22'];
        }
        if (!is_numeric($val['f1gu1_f1gu2_f1gu3'])) {
            $this->valF['f1gu1_f1gu2_f1gu3'] = NULL;
        } else {
            $this->valF['f1gu1_f1gu2_f1gu3'] = $val['f1gu1_f1gu2_f1gu3'];
        }
        if (!is_numeric($val['f1lu1_f1lu2_f1lu3'])) {
            $this->valF['f1lu1_f1lu2_f1lu3'] = NULL;
        } else {
            $this->valF['f1lu1_f1lu2_f1lu3'] = $val['f1lu1_f1lu2_f1lu3'];
        }
        if (!is_numeric($val['f1zu1_f1zu2_f1zu3'])) {
            $this->valF['f1zu1_f1zu2_f1zu3'] = NULL;
        } else {
            $this->valF['f1zu1_f1zu2_f1zu3'] = $val['f1zu1_f1zu2_f1zu3'];
        }
        if (!is_numeric($val['f1pu1_f1pu2_f1pu3'])) {
            $this->valF['f1pu1_f1pu2_f1pu3'] = NULL;
        } else {
            $this->valF['f1pu1_f1pu2_f1pu3'] = $val['f1pu1_f1pu2_f1pu3'];
        }
        if (!is_numeric($val['f1gt4_f1gt5_f1gt6'])) {
            $this->valF['f1gt4_f1gt5_f1gt6'] = NULL;
        } else {
            $this->valF['f1gt4_f1gt5_f1gt6'] = $val['f1gt4_f1gt5_f1gt6'];
        }
        if (!is_numeric($val['f1lt4_f1lt5_f1lt6'])) {
            $this->valF['f1lt4_f1lt5_f1lt6'] = NULL;
        } else {
            $this->valF['f1lt4_f1lt5_f1lt6'] = $val['f1lt4_f1lt5_f1lt6'];
        }
        if (!is_numeric($val['f1zt4_f1zt5_f1zt6'])) {
            $this->valF['f1zt4_f1zt5_f1zt6'] = NULL;
        } else {
            $this->valF['f1zt4_f1zt5_f1zt6'] = $val['f1zt4_f1zt5_f1zt6'];
        }
        if (!is_numeric($val['f1pt4_f1pt5_f1pt6'])) {
            $this->valF['f1pt4_f1pt5_f1pt6'] = NULL;
        } else {
            $this->valF['f1pt4_f1pt5_f1pt6'] = $val['f1pt4_f1pt5_f1pt6'];
        }
        if (!is_numeric($val['f1xu1_f1xu2_f1xu3'])) {
            $this->valF['f1xu1_f1xu2_f1xu3'] = NULL;
        } else {
            $this->valF['f1xu1_f1xu2_f1xu3'] = $val['f1xu1_f1xu2_f1xu3'];
        }
        if (!is_numeric($val['f1xt4_f1xt5_f1xt6'])) {
            $this->valF['f1xt4_f1xt5_f1xt6'] = NULL;
        } else {
            $this->valF['f1xt4_f1xt5_f1xt6'] = $val['f1xt4_f1xt5_f1xt6'];
        }
        if (!is_numeric($val['f1hu1_f1hu2_f1hu3'])) {
            $this->valF['f1hu1_f1hu2_f1hu3'] = NULL;
        } else {
            $this->valF['f1hu1_f1hu2_f1hu3'] = $val['f1hu1_f1hu2_f1hu3'];
        }
        if (!is_numeric($val['f1mu1_f1mu2_f1mu3'])) {
            $this->valF['f1mu1_f1mu2_f1mu3'] = NULL;
        } else {
            $this->valF['f1mu1_f1mu2_f1mu3'] = $val['f1mu1_f1mu2_f1mu3'];
        }
        if (!is_numeric($val['f1qu1_f1qu2_f1qu3'])) {
            $this->valF['f1qu1_f1qu2_f1qu3'] = NULL;
        } else {
            $this->valF['f1qu1_f1qu2_f1qu3'] = $val['f1qu1_f1qu2_f1qu3'];
        }
        if (!is_numeric($val['f1ht4_f1ht5_f1ht6'])) {
            $this->valF['f1ht4_f1ht5_f1ht6'] = NULL;
        } else {
            $this->valF['f1ht4_f1ht5_f1ht6'] = $val['f1ht4_f1ht5_f1ht6'];
        }
        if (!is_numeric($val['f1mt4_f1mt5_f1mt6'])) {
            $this->valF['f1mt4_f1mt5_f1mt6'] = NULL;
        } else {
            $this->valF['f1mt4_f1mt5_f1mt6'] = $val['f1mt4_f1mt5_f1mt6'];
        }
        if (!is_numeric($val['f1qt4_f1qt5_f1qt6'])) {
            $this->valF['f1qt4_f1qt5_f1qt6'] = NULL;
        } else {
            $this->valF['f1qt4_f1qt5_f1qt6'] = $val['f1qt4_f1qt5_f1qt6'];
        }
        if (!is_numeric($val['f2cu1_f2cu2_f2cu3'])) {
            $this->valF['f2cu1_f2cu2_f2cu3'] = NULL;
        } else {
            $this->valF['f2cu1_f2cu2_f2cu3'] = $val['f2cu1_f2cu2_f2cu3'];
        }
        if (!is_numeric($val['f2bu1_f2bu2_f2bu3'])) {
            $this->valF['f2bu1_f2bu2_f2bu3'] = NULL;
        } else {
            $this->valF['f2bu1_f2bu2_f2bu3'] = $val['f2bu1_f2bu2_f2bu3'];
        }
        if (!is_numeric($val['f2su1_f2su2_f2su3'])) {
            $this->valF['f2su1_f2su2_f2su3'] = NULL;
        } else {
            $this->valF['f2su1_f2su2_f2su3'] = $val['f2su1_f2su2_f2su3'];
        }
        if (!is_numeric($val['f2hu1_f2hu2_f2hu3'])) {
            $this->valF['f2hu1_f2hu2_f2hu3'] = NULL;
        } else {
            $this->valF['f2hu1_f2hu2_f2hu3'] = $val['f2hu1_f2hu2_f2hu3'];
        }
        if (!is_numeric($val['f2eu1_f2eu2_f2eu3'])) {
            $this->valF['f2eu1_f2eu2_f2eu3'] = NULL;
        } else {
            $this->valF['f2eu1_f2eu2_f2eu3'] = $val['f2eu1_f2eu2_f2eu3'];
        }
        if (!is_numeric($val['f2qu1_f2qu2_f2qu3'])) {
            $this->valF['f2qu1_f2qu2_f2qu3'] = NULL;
        } else {
            $this->valF['f2qu1_f2qu2_f2qu3'] = $val['f2qu1_f2qu2_f2qu3'];
        }
        if (!is_numeric($val['f2ct4_f2ct5_f2ct6'])) {
            $this->valF['f2ct4_f2ct5_f2ct6'] = NULL;
        } else {
            $this->valF['f2ct4_f2ct5_f2ct6'] = $val['f2ct4_f2ct5_f2ct6'];
        }
        if (!is_numeric($val['f2bt4_f2bt5_f2bt6'])) {
            $this->valF['f2bt4_f2bt5_f2bt6'] = NULL;
        } else {
            $this->valF['f2bt4_f2bt5_f2bt6'] = $val['f2bt4_f2bt5_f2bt6'];
        }
        if (!is_numeric($val['f2st4_f2st5_f2st6'])) {
            $this->valF['f2st4_f2st5_f2st6'] = NULL;
        } else {
            $this->valF['f2st4_f2st5_f2st6'] = $val['f2st4_f2st5_f2st6'];
        }
        if (!is_numeric($val['f2ht4_f2ht5_f2ht6'])) {
            $this->valF['f2ht4_f2ht5_f2ht6'] = NULL;
        } else {
            $this->valF['f2ht4_f2ht5_f2ht6'] = $val['f2ht4_f2ht5_f2ht6'];
        }
        if (!is_numeric($val['f2et4_f2et5_f2et6'])) {
            $this->valF['f2et4_f2et5_f2et6'] = NULL;
        } else {
            $this->valF['f2et4_f2et5_f2et6'] = $val['f2et4_f2et5_f2et6'];
        }
        if (!is_numeric($val['f2qt4_f2qt5_f2qt6'])) {
            $this->valF['f2qt4_f2qt5_f2qt6'] = NULL;
        } else {
            $this->valF['f2qt4_f2qt5_f2qt6'] = $val['f2qt4_f2qt5_f2qt6'];
        }
            $this->valF['dia_droit_reel_perso_grevant_bien_desc'] = $val['dia_droit_reel_perso_grevant_bien_desc'];
            $this->valF['dia_mod_cess_paie_nat_desc'] = $val['dia_mod_cess_paie_nat_desc'];
            $this->valF['dia_mod_cess_rente_viag_desc'] = $val['dia_mod_cess_rente_viag_desc'];
            $this->valF['dia_mod_cess_echange_desc'] = $val['dia_mod_cess_echange_desc'];
            $this->valF['dia_mod_cess_apport_societe_desc'] = $val['dia_mod_cess_apport_societe_desc'];
            $this->valF['dia_mod_cess_cess_terr_loc_co_desc'] = $val['dia_mod_cess_cess_terr_loc_co_desc'];
            $this->valF['dia_mod_cess_esti_imm_loca_desc'] = $val['dia_mod_cess_esti_imm_loca_desc'];
            $this->valF['dia_mod_cess_adju_obl_desc'] = $val['dia_mod_cess_adju_obl_desc'];
            $this->valF['dia_mod_cess_adju_fin_indivi_desc'] = $val['dia_mod_cess_adju_fin_indivi_desc'];
            $this->valF['dia_cadre_titul_droit_prempt'] = $val['dia_cadre_titul_droit_prempt'];
        if (!is_numeric($val['dia_mairie_prix_moyen'])) {
            $this->valF['dia_mairie_prix_moyen'] = NULL;
        } else {
            $this->valF['dia_mairie_prix_moyen'] = $val['dia_mairie_prix_moyen'];
        }
            $this->valF['dia_propri_indivi'] = $val['dia_propri_indivi'];
        if ($val['dia_situa_bien_plan_cadas_oui'] == 1 || $val['dia_situa_bien_plan_cadas_oui'] == "t" || $val['dia_situa_bien_plan_cadas_oui'] == "Oui") {
            $this->valF['dia_situa_bien_plan_cadas_oui'] = true;
        } else {
            $this->valF['dia_situa_bien_plan_cadas_oui'] = false;
        }
        if ($val['dia_situa_bien_plan_cadas_non'] == 1 || $val['dia_situa_bien_plan_cadas_non'] == "t" || $val['dia_situa_bien_plan_cadas_non'] == "Oui") {
            $this->valF['dia_situa_bien_plan_cadas_non'] = true;
        } else {
            $this->valF['dia_situa_bien_plan_cadas_non'] = false;
        }
        if ($val['dia_notif_dec_titul_adr_prop'] == 1 || $val['dia_notif_dec_titul_adr_prop'] == "t" || $val['dia_notif_dec_titul_adr_prop'] == "Oui") {
            $this->valF['dia_notif_dec_titul_adr_prop'] = true;
        } else {
            $this->valF['dia_notif_dec_titul_adr_prop'] = false;
        }
            $this->valF['dia_notif_dec_titul_adr_prop_desc'] = $val['dia_notif_dec_titul_adr_prop_desc'];
        if ($val['dia_notif_dec_titul_adr_manda'] == 1 || $val['dia_notif_dec_titul_adr_manda'] == "t" || $val['dia_notif_dec_titul_adr_manda'] == "Oui") {
            $this->valF['dia_notif_dec_titul_adr_manda'] = true;
        } else {
            $this->valF['dia_notif_dec_titul_adr_manda'] = false;
        }
            $this->valF['dia_notif_dec_titul_adr_manda_desc'] = $val['dia_notif_dec_titul_adr_manda_desc'];
        if ($val['dia_dia_dpu'] == 1 || $val['dia_dia_dpu'] == "t" || $val['dia_dia_dpu'] == "Oui") {
            $this->valF['dia_dia_dpu'] = true;
        } else {
            $this->valF['dia_dia_dpu'] = false;
        }
        if ($val['dia_dia_zad'] == 1 || $val['dia_dia_zad'] == "t" || $val['dia_dia_zad'] == "Oui") {
            $this->valF['dia_dia_zad'] = true;
        } else {
            $this->valF['dia_dia_zad'] = false;
        }
        if ($val['dia_dia_zone_preempt_esp_natu_sensi'] == 1 || $val['dia_dia_zone_preempt_esp_natu_sensi'] == "t" || $val['dia_dia_zone_preempt_esp_natu_sensi'] == "Oui") {
            $this->valF['dia_dia_zone_preempt_esp_natu_sensi'] = true;
        } else {
            $this->valF['dia_dia_zone_preempt_esp_natu_sensi'] = false;
        }
        if ($val['dia_dab_dpu'] == 1 || $val['dia_dab_dpu'] == "t" || $val['dia_dab_dpu'] == "Oui") {
            $this->valF['dia_dab_dpu'] = true;
        } else {
            $this->valF['dia_dab_dpu'] = false;
        }
        if ($val['dia_dab_zad'] == 1 || $val['dia_dab_zad'] == "t" || $val['dia_dab_zad'] == "Oui") {
            $this->valF['dia_dab_zad'] = true;
        } else {
            $this->valF['dia_dab_zad'] = false;
        }
        if (!is_numeric($val['dia_mod_cess_commi_mnt'])) {
            $this->valF['dia_mod_cess_commi_mnt'] = NULL;
        } else {
            $this->valF['dia_mod_cess_commi_mnt'] = $val['dia_mod_cess_commi_mnt'];
        }
        if ($val['dia_mod_cess_commi_mnt_ttc'] == 1 || $val['dia_mod_cess_commi_mnt_ttc'] == "t" || $val['dia_mod_cess_commi_mnt_ttc'] == "Oui") {
            $this->valF['dia_mod_cess_commi_mnt_ttc'] = true;
        } else {
            $this->valF['dia_mod_cess_commi_mnt_ttc'] = false;
        }
        if ($val['dia_mod_cess_commi_mnt_ht'] == 1 || $val['dia_mod_cess_commi_mnt_ht'] == "t" || $val['dia_mod_cess_commi_mnt_ht'] == "Oui") {
            $this->valF['dia_mod_cess_commi_mnt_ht'] = true;
        } else {
            $this->valF['dia_mod_cess_commi_mnt_ht'] = false;
        }
        if (!is_numeric($val['dia_mod_cess_prix_vente_num'])) {
            $this->valF['dia_mod_cess_prix_vente_num'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente_num'] = $val['dia_mod_cess_prix_vente_num'];
        }
        if (!is_numeric($val['dia_mod_cess_prix_vente_mob_num'])) {
            $this->valF['dia_mod_cess_prix_vente_mob_num'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente_mob_num'] = $val['dia_mod_cess_prix_vente_mob_num'];
        }
        if (!is_numeric($val['dia_mod_cess_prix_vente_cheptel_num'])) {
            $this->valF['dia_mod_cess_prix_vente_cheptel_num'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente_cheptel_num'] = $val['dia_mod_cess_prix_vente_cheptel_num'];
        }
        if (!is_numeric($val['dia_mod_cess_prix_vente_recol_num'])) {
            $this->valF['dia_mod_cess_prix_vente_recol_num'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente_recol_num'] = $val['dia_mod_cess_prix_vente_recol_num'];
        }
        if (!is_numeric($val['dia_mod_cess_prix_vente_autre_num'])) {
            $this->valF['dia_mod_cess_prix_vente_autre_num'] = NULL;
        } else {
            $this->valF['dia_mod_cess_prix_vente_autre_num'] = $val['dia_mod_cess_prix_vente_autre_num'];
        }
        if (!is_numeric($val['dia_su_co_sol_num'])) {
            $this->valF['dia_su_co_sol_num'] = NULL;
        } else {
            $this->valF['dia_su_co_sol_num'] = $val['dia_su_co_sol_num'];
        }
        if (!is_numeric($val['dia_su_util_hab_num'])) {
            $this->valF['dia_su_util_hab_num'] = NULL;
        } else {
            $this->valF['dia_su_util_hab_num'] = $val['dia_su_util_hab_num'];
        }
        if (!is_numeric($val['dia_mod_cess_mnt_an_num'])) {
            $this->valF['dia_mod_cess_mnt_an_num'] = NULL;
        } else {
            $this->valF['dia_mod_cess_mnt_an_num'] = $val['dia_mod_cess_mnt_an_num'];
        }
        if (!is_numeric($val['dia_mod_cess_mnt_compt_num'])) {
            $this->valF['dia_mod_cess_mnt_compt_num'] = NULL;
        } else {
            $this->valF['dia_mod_cess_mnt_compt_num'] = $val['dia_mod_cess_mnt_compt_num'];
        }
        if (!is_numeric($val['dia_mod_cess_mnt_soulte_num'])) {
            $this->valF['dia_mod_cess_mnt_soulte_num'] = NULL;
        } else {
            $this->valF['dia_mod_cess_mnt_soulte_num'] = $val['dia_mod_cess_mnt_soulte_num'];
        }
        if (!is_numeric($val['dia_comp_prix_vente'])) {
            $this->valF['dia_comp_prix_vente'] = NULL;
        } else {
            $this->valF['dia_comp_prix_vente'] = $val['dia_comp_prix_vente'];
        }
        if (!is_numeric($val['dia_comp_surface'])) {
            $this->valF['dia_comp_surface'] = NULL;
        } else {
            $this->valF['dia_comp_surface'] = $val['dia_comp_surface'];
        }
        if (!is_numeric($val['dia_comp_total_frais'])) {
            $this->valF['dia_comp_total_frais'] = NULL;
        } else {
            $this->valF['dia_comp_total_frais'] = $val['dia_comp_total_frais'];
        }
        if (!is_numeric($val['dia_comp_mtn_total'])) {
            $this->valF['dia_comp_mtn_total'] = NULL;
        } else {
            $this->valF['dia_comp_mtn_total'] = $val['dia_comp_mtn_total'];
        }
        if (!is_numeric($val['dia_comp_valeur_m2'])) {
            $this->valF['dia_comp_valeur_m2'] = NULL;
        } else {
            $this->valF['dia_comp_valeur_m2'] = $val['dia_comp_valeur_m2'];
        }
        if (!is_numeric($val['dia_esti_prix_france_dom'])) {
            $this->valF['dia_esti_prix_france_dom'] = NULL;
        } else {
            $this->valF['dia_esti_prix_france_dom'] = $val['dia_esti_prix_france_dom'];
        }
        if (!is_numeric($val['dia_prop_collectivite'])) {
            $this->valF['dia_prop_collectivite'] = NULL;
        } else {
            $this->valF['dia_prop_collectivite'] = $val['dia_prop_collectivite'];
        }
        if ($val['dia_delegataire_denomination'] == "") {
            $this->valF['dia_delegataire_denomination'] = NULL;
        } else {
            $this->valF['dia_delegataire_denomination'] = $val['dia_delegataire_denomination'];
        }
        if ($val['dia_delegataire_raison_sociale'] == "") {
            $this->valF['dia_delegataire_raison_sociale'] = NULL;
        } else {
            $this->valF['dia_delegataire_raison_sociale'] = $val['dia_delegataire_raison_sociale'];
        }
        if ($val['dia_delegataire_siret'] == "") {
            $this->valF['dia_delegataire_siret'] = NULL;
        } else {
            $this->valF['dia_delegataire_siret'] = $val['dia_delegataire_siret'];
        }
        if ($val['dia_delegataire_categorie_juridique'] == "") {
            $this->valF['dia_delegataire_categorie_juridique'] = NULL;
        } else {
            $this->valF['dia_delegataire_categorie_juridique'] = $val['dia_delegataire_categorie_juridique'];
        }
        if ($val['dia_delegataire_representant_nom'] == "") {
            $this->valF['dia_delegataire_representant_nom'] = NULL;
        } else {
            $this->valF['dia_delegataire_representant_nom'] = $val['dia_delegataire_representant_nom'];
        }
        if ($val['dia_delegataire_representant_prenom'] == "") {
            $this->valF['dia_delegataire_representant_prenom'] = NULL;
        } else {
            $this->valF['dia_delegataire_representant_prenom'] = $val['dia_delegataire_representant_prenom'];
        }
        if ($val['dia_delegataire_adresse_numero'] == "") {
            $this->valF['dia_delegataire_adresse_numero'] = NULL;
        } else {
            $this->valF['dia_delegataire_adresse_numero'] = $val['dia_delegataire_adresse_numero'];
        }
        if ($val['dia_delegataire_adresse_voie'] == "") {
            $this->valF['dia_delegataire_adresse_voie'] = NULL;
        } else {
            $this->valF['dia_delegataire_adresse_voie'] = $val['dia_delegataire_adresse_voie'];
        }
        if ($val['dia_delegataire_adresse_complement'] == "") {
            $this->valF['dia_delegataire_adresse_complement'] = NULL;
        } else {
            $this->valF['dia_delegataire_adresse_complement'] = $val['dia_delegataire_adresse_complement'];
        }
        if ($val['dia_delegataire_adresse_lieu_dit'] == "") {
            $this->valF['dia_delegataire_adresse_lieu_dit'] = NULL;
        } else {
            $this->valF['dia_delegataire_adresse_lieu_dit'] = $val['dia_delegataire_adresse_lieu_dit'];
        }
        if ($val['dia_delegataire_adresse_localite'] == "") {
            $this->valF['dia_delegataire_adresse_localite'] = NULL;
        } else {
            $this->valF['dia_delegataire_adresse_localite'] = $val['dia_delegataire_adresse_localite'];
        }
        if ($val['dia_delegataire_adresse_code_postal'] == "") {
            $this->valF['dia_delegataire_adresse_code_postal'] = NULL;
        } else {
            $this->valF['dia_delegataire_adresse_code_postal'] = $val['dia_delegataire_adresse_code_postal'];
        }
        if ($val['dia_delegataire_adresse_bp'] == "") {
            $this->valF['dia_delegataire_adresse_bp'] = NULL;
        } else {
            $this->valF['dia_delegataire_adresse_bp'] = $val['dia_delegataire_adresse_bp'];
        }
        if ($val['dia_delegataire_adresse_cedex'] == "") {
            $this->valF['dia_delegataire_adresse_cedex'] = NULL;
        } else {
            $this->valF['dia_delegataire_adresse_cedex'] = $val['dia_delegataire_adresse_cedex'];
        }
        if ($val['dia_delegataire_adresse_pays'] == "") {
            $this->valF['dia_delegataire_adresse_pays'] = NULL;
        } else {
            $this->valF['dia_delegataire_adresse_pays'] = $val['dia_delegataire_adresse_pays'];
        }
        if ($val['dia_delegataire_telephone_fixe'] == "") {
            $this->valF['dia_delegataire_telephone_fixe'] = NULL;
        } else {
            $this->valF['dia_delegataire_telephone_fixe'] = $val['dia_delegataire_telephone_fixe'];
        }
        if ($val['dia_delegataire_telephone_mobile'] == "") {
            $this->valF['dia_delegataire_telephone_mobile'] = NULL;
        } else {
            $this->valF['dia_delegataire_telephone_mobile'] = $val['dia_delegataire_telephone_mobile'];
        }
        if ($val['dia_delegataire_telephone_mobile_indicatif'] == "") {
            $this->valF['dia_delegataire_telephone_mobile_indicatif'] = NULL;
        } else {
            $this->valF['dia_delegataire_telephone_mobile_indicatif'] = $val['dia_delegataire_telephone_mobile_indicatif'];
        }
        if ($val['dia_delegataire_courriel'] == "") {
            $this->valF['dia_delegataire_courriel'] = NULL;
        } else {
            $this->valF['dia_delegataire_courriel'] = $val['dia_delegataire_courriel'];
        }
        if ($val['dia_delegataire_fax'] == "") {
            $this->valF['dia_delegataire_fax'] = NULL;
        } else {
            $this->valF['dia_delegataire_fax'] = $val['dia_delegataire_fax'];
        }
        if ($val['dia_entree_jouissance_type'] == "") {
            $this->valF['dia_entree_jouissance_type'] = NULL;
        } else {
            $this->valF['dia_entree_jouissance_type'] = $val['dia_entree_jouissance_type'];
        }
        if ($val['dia_entree_jouissance_date'] != "") {
            $this->valF['dia_entree_jouissance_date'] = $this->dateDB($val['dia_entree_jouissance_date']);
        } else {
            $this->valF['dia_entree_jouissance_date'] = NULL;
        }
        if ($val['dia_entree_jouissance_date_effet'] != "") {
            $this->valF['dia_entree_jouissance_date_effet'] = $this->dateDB($val['dia_entree_jouissance_date_effet']);
        } else {
            $this->valF['dia_entree_jouissance_date_effet'] = NULL;
        }
            $this->valF['dia_entree_jouissance_com'] = $val['dia_entree_jouissance_com'];
        if ($val['dia_remise_bien_date_effet'] != "") {
            $this->valF['dia_remise_bien_date_effet'] = $this->dateDB($val['dia_remise_bien_date_effet']);
        } else {
            $this->valF['dia_remise_bien_date_effet'] = NULL;
        }
            $this->valF['dia_remise_bien_com'] = $val['dia_remise_bien_com'];
        if (!is_numeric($val['c2zp1_crete'])) {
            $this->valF['c2zp1_crete'] = NULL;
        } else {
            $this->valF['c2zp1_crete'] = $val['c2zp1_crete'];
        }
        if ($val['c2zr1_destination'] == "") {
            $this->valF['c2zr1_destination'] = NULL;
        } else {
            $this->valF['c2zr1_destination'] = $val['c2zr1_destination'];
        }
            $this->valF['mh_design_appel_denom'] = $val['mh_design_appel_denom'];
        if ($val['mh_design_type_protect'] == "") {
            $this->valF['mh_design_type_protect'] = NULL;
        } else {
            $this->valF['mh_design_type_protect'] = $val['mh_design_type_protect'];
        }
            $this->valF['mh_design_elem_prot'] = $val['mh_design_elem_prot'];
        if ($val['mh_design_ref_merimee_palissy'] == "") {
            $this->valF['mh_design_ref_merimee_palissy'] = NULL;
        } else {
            $this->valF['mh_design_ref_merimee_palissy'] = $val['mh_design_ref_merimee_palissy'];
        }
        if ($val['mh_design_nature_prop'] == "") {
            $this->valF['mh_design_nature_prop'] = NULL;
        } else {
            $this->valF['mh_design_nature_prop'] = $val['mh_design_nature_prop'];
        }
            $this->valF['mh_loc_denom'] = $val['mh_loc_denom'];
            $this->valF['mh_pres_intitule'] = $val['mh_pres_intitule'];
        if ($val['mh_trav_cat_1'] == 1 || $val['mh_trav_cat_1'] == "t" || $val['mh_trav_cat_1'] == "Oui") {
            $this->valF['mh_trav_cat_1'] = true;
        } else {
            $this->valF['mh_trav_cat_1'] = false;
        }
        if ($val['mh_trav_cat_2'] == 1 || $val['mh_trav_cat_2'] == "t" || $val['mh_trav_cat_2'] == "Oui") {
            $this->valF['mh_trav_cat_2'] = true;
        } else {
            $this->valF['mh_trav_cat_2'] = false;
        }
        if ($val['mh_trav_cat_3'] == 1 || $val['mh_trav_cat_3'] == "t" || $val['mh_trav_cat_3'] == "Oui") {
            $this->valF['mh_trav_cat_3'] = true;
        } else {
            $this->valF['mh_trav_cat_3'] = false;
        }
        if ($val['mh_trav_cat_4'] == 1 || $val['mh_trav_cat_4'] == "t" || $val['mh_trav_cat_4'] == "Oui") {
            $this->valF['mh_trav_cat_4'] = true;
        } else {
            $this->valF['mh_trav_cat_4'] = false;
        }
        if ($val['mh_trav_cat_5'] == 1 || $val['mh_trav_cat_5'] == "t" || $val['mh_trav_cat_5'] == "Oui") {
            $this->valF['mh_trav_cat_5'] = true;
        } else {
            $this->valF['mh_trav_cat_5'] = false;
        }
        if ($val['mh_trav_cat_6'] == 1 || $val['mh_trav_cat_6'] == "t" || $val['mh_trav_cat_6'] == "Oui") {
            $this->valF['mh_trav_cat_6'] = true;
        } else {
            $this->valF['mh_trav_cat_6'] = false;
        }
        if ($val['mh_trav_cat_7'] == 1 || $val['mh_trav_cat_7'] == "t" || $val['mh_trav_cat_7'] == "Oui") {
            $this->valF['mh_trav_cat_7'] = true;
        } else {
            $this->valF['mh_trav_cat_7'] = false;
        }
        if ($val['mh_trav_cat_8'] == 1 || $val['mh_trav_cat_8'] == "t" || $val['mh_trav_cat_8'] == "Oui") {
            $this->valF['mh_trav_cat_8'] = true;
        } else {
            $this->valF['mh_trav_cat_8'] = false;
        }
        if ($val['mh_trav_cat_9'] == 1 || $val['mh_trav_cat_9'] == "t" || $val['mh_trav_cat_9'] == "Oui") {
            $this->valF['mh_trav_cat_9'] = true;
        } else {
            $this->valF['mh_trav_cat_9'] = false;
        }
        if ($val['mh_trav_cat_10'] == 1 || $val['mh_trav_cat_10'] == "t" || $val['mh_trav_cat_10'] == "Oui") {
            $this->valF['mh_trav_cat_10'] = true;
        } else {
            $this->valF['mh_trav_cat_10'] = false;
        }
        if ($val['mh_trav_cat_11'] == 1 || $val['mh_trav_cat_11'] == "t" || $val['mh_trav_cat_11'] == "Oui") {
            $this->valF['mh_trav_cat_11'] = true;
        } else {
            $this->valF['mh_trav_cat_11'] = false;
        }
        if ($val['mh_trav_cat_12'] == 1 || $val['mh_trav_cat_12'] == "t" || $val['mh_trav_cat_12'] == "Oui") {
            $this->valF['mh_trav_cat_12'] = true;
        } else {
            $this->valF['mh_trav_cat_12'] = false;
        }
            $this->valF['mh_trav_cat_12_prec'] = $val['mh_trav_cat_12_prec'];
    }

    //=================================================
    //cle primaire automatique [automatic primary key]
    //==================================================

    function setId(&$dnu1 = null) {
    //numero automatique
        $this->valF[$this->clePrimaire] = $this->f->db->nextId(DB_PREFIXE.$this->table);
    }

    function setValFAjout($val = array()) {
    //numero automatique -> pas de controle ajout cle primaire
    }

    function verifierAjout($val = array(), &$dnu1 = null) {
    //numero automatique -> pas de verfication de cle primaire
    }

    //==========================
    // Formulaire  [form]
    //==========================
    /**
     *
     */
    function setType(&$form, $maj) {
        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        // MODE AJOUTER
        if ($maj == 0 || $crud == 'create') {
            $form->setType("donnees_techniques", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_instruction", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction", "select");
            }
            if ($this->is_in_context_of_foreign_key("lot", $this->retourformulaire)) {
                $form->setType("lot", "selecthiddenstatic");
            } else {
                $form->setType("lot", "select");
            }
            $form->setType("am_lotiss", "checkbox");
            $form->setType("am_autre_div", "checkbox");
            $form->setType("am_camping", "checkbox");
            $form->setType("am_caravane", "checkbox");
            $form->setType("am_carav_duree", "text");
            $form->setType("am_statio", "checkbox");
            $form->setType("am_statio_cont", "text");
            $form->setType("am_affou_exhau", "checkbox");
            $form->setType("am_affou_exhau_sup", "text");
            $form->setType("am_affou_prof", "text");
            $form->setType("am_exhau_haut", "text");
            $form->setType("am_coupe_abat", "checkbox");
            $form->setType("am_prot_plu", "checkbox");
            $form->setType("am_prot_muni", "checkbox");
            $form->setType("am_mobil_voyage", "checkbox");
            $form->setType("am_aire_voyage", "checkbox");
            $form->setType("am_rememb_afu", "checkbox");
            $form->setType("am_parc_resid_loi", "checkbox");
            $form->setType("am_sport_moto", "checkbox");
            $form->setType("am_sport_attrac", "checkbox");
            $form->setType("am_sport_golf", "checkbox");
            $form->setType("am_mob_art", "checkbox");
            $form->setType("am_modif_voie_esp", "checkbox");
            $form->setType("am_plant_voie_esp", "checkbox");
            $form->setType("am_chem_ouv_esp", "checkbox");
            $form->setType("am_agri_peche", "checkbox");
            $form->setType("am_crea_voie", "checkbox");
            $form->setType("am_modif_voie_exist", "checkbox");
            $form->setType("am_crea_esp_sauv", "checkbox");
            $form->setType("am_crea_esp_class", "checkbox");
            $form->setType("am_projet_desc", "textarea");
            $form->setType("am_terr_surf", "text");
            $form->setType("am_tranche_desc", "textarea");
            $form->setType("am_lot_max_nb", "text");
            $form->setType("am_lot_max_shon", "text");
            $form->setType("am_lot_cstr_cos", "checkbox");
            $form->setType("am_lot_cstr_plan", "checkbox");
            $form->setType("am_lot_cstr_vente", "checkbox");
            $form->setType("am_lot_fin_diff", "checkbox");
            $form->setType("am_lot_consign", "checkbox");
            $form->setType("am_lot_gar_achev", "checkbox");
            $form->setType("am_lot_vente_ant", "checkbox");
            $form->setType("am_empl_nb", "text");
            $form->setType("am_tente_nb", "text");
            $form->setType("am_carav_nb", "text");
            $form->setType("am_mobil_nb", "text");
            $form->setType("am_pers_nb", "text");
            $form->setType("am_empl_hll_nb", "text");
            $form->setType("am_hll_shon", "text");
            $form->setType("am_periode_exploit", "textarea");
            $form->setType("am_exist_agrand", "checkbox");
            $form->setType("am_exist_date", "text");
            $form->setType("am_exist_num", "text");
            $form->setType("am_exist_nb_avant", "text");
            $form->setType("am_exist_nb_apres", "text");
            $form->setType("am_coupe_bois", "checkbox");
            $form->setType("am_coupe_parc", "checkbox");
            $form->setType("am_coupe_align", "checkbox");
            $form->setType("am_coupe_ess", "text");
            $form->setType("am_coupe_age", "text");
            $form->setType("am_coupe_dens", "text");
            $form->setType("am_coupe_qual", "text");
            $form->setType("am_coupe_trait", "text");
            $form->setType("am_coupe_autr", "text");
            $form->setType("co_archi_recours", "checkbox");
            $form->setType("co_cstr_nouv", "checkbox");
            $form->setType("co_cstr_exist", "checkbox");
            $form->setType("co_cloture", "checkbox");
            $form->setType("co_elec_tension", "text");
            $form->setType("co_div_terr", "checkbox");
            $form->setType("co_projet_desc", "textarea");
            $form->setType("co_anx_pisc", "checkbox");
            $form->setType("co_anx_gara", "checkbox");
            $form->setType("co_anx_veran", "checkbox");
            $form->setType("co_anx_abri", "checkbox");
            $form->setType("co_anx_autr", "checkbox");
            $form->setType("co_anx_autr_desc", "textarea");
            $form->setType("co_tot_log_nb", "text");
            $form->setType("co_tot_ind_nb", "text");
            $form->setType("co_tot_coll_nb", "text");
            $form->setType("co_mais_piece_nb", "text");
            $form->setType("co_mais_niv_nb", "text");
            $form->setType("co_fin_lls_nb", "text");
            $form->setType("co_fin_aa_nb", "text");
            $form->setType("co_fin_ptz_nb", "text");
            $form->setType("co_fin_autr_nb", "text");
            $form->setType("co_fin_autr_desc", "textarea");
            $form->setType("co_mais_contrat_ind", "checkbox");
            $form->setType("co_uti_pers", "checkbox");
            $form->setType("co_uti_vente", "checkbox");
            $form->setType("co_uti_loc", "checkbox");
            $form->setType("co_uti_princ", "checkbox");
            $form->setType("co_uti_secon", "checkbox");
            $form->setType("co_resid_agees", "checkbox");
            $form->setType("co_resid_etud", "checkbox");
            $form->setType("co_resid_tourism", "checkbox");
            $form->setType("co_resid_hot_soc", "checkbox");
            $form->setType("co_resid_soc", "checkbox");
            $form->setType("co_resid_hand", "checkbox");
            $form->setType("co_resid_autr", "checkbox");
            $form->setType("co_resid_autr_desc", "textarea");
            $form->setType("co_foyer_chamb_nb", "text");
            $form->setType("co_log_1p_nb", "text");
            $form->setType("co_log_2p_nb", "text");
            $form->setType("co_log_3p_nb", "text");
            $form->setType("co_log_4p_nb", "text");
            $form->setType("co_log_5p_nb", "text");
            $form->setType("co_log_6p_nb", "text");
            $form->setType("co_bat_niv_nb", "text");
            $form->setType("co_trx_exten", "checkbox");
            $form->setType("co_trx_surelev", "checkbox");
            $form->setType("co_trx_nivsup", "checkbox");
            $form->setType("co_demont_periode", "textarea");
            $form->setType("co_sp_transport", "checkbox");
            $form->setType("co_sp_enseign", "checkbox");
            $form->setType("co_sp_act_soc", "checkbox");
            $form->setType("co_sp_ouvr_spe", "checkbox");
            $form->setType("co_sp_sante", "checkbox");
            $form->setType("co_sp_culture", "checkbox");
            $form->setType("co_statio_avt_nb", "text");
            $form->setType("co_statio_apr_nb", "text");
            $form->setType("co_statio_adr", "textarea");
            $form->setType("co_statio_place_nb", "text");
            $form->setType("co_statio_tot_surf", "text");
            $form->setType("co_statio_tot_shob", "text");
            $form->setType("co_statio_comm_cin_surf", "text");
            $form->setType("su_avt_shon1", "text");
            $form->setType("su_avt_shon2", "text");
            $form->setType("su_avt_shon3", "text");
            $form->setType("su_avt_shon4", "text");
            $form->setType("su_avt_shon5", "text");
            $form->setType("su_avt_shon6", "text");
            $form->setType("su_avt_shon7", "text");
            $form->setType("su_avt_shon8", "text");
            $form->setType("su_avt_shon9", "text");
            $form->setType("su_cstr_shon1", "text");
            $form->setType("su_cstr_shon2", "text");
            $form->setType("su_cstr_shon3", "text");
            $form->setType("su_cstr_shon4", "text");
            $form->setType("su_cstr_shon5", "text");
            $form->setType("su_cstr_shon6", "text");
            $form->setType("su_cstr_shon7", "text");
            $form->setType("su_cstr_shon8", "text");
            $form->setType("su_cstr_shon9", "text");
            $form->setType("su_trsf_shon1", "text");
            $form->setType("su_trsf_shon2", "text");
            $form->setType("su_trsf_shon3", "text");
            $form->setType("su_trsf_shon4", "text");
            $form->setType("su_trsf_shon5", "text");
            $form->setType("su_trsf_shon6", "text");
            $form->setType("su_trsf_shon7", "text");
            $form->setType("su_trsf_shon8", "text");
            $form->setType("su_trsf_shon9", "text");
            $form->setType("su_chge_shon1", "text");
            $form->setType("su_chge_shon2", "text");
            $form->setType("su_chge_shon3", "text");
            $form->setType("su_chge_shon4", "text");
            $form->setType("su_chge_shon5", "text");
            $form->setType("su_chge_shon6", "text");
            $form->setType("su_chge_shon7", "text");
            $form->setType("su_chge_shon8", "text");
            $form->setType("su_chge_shon9", "text");
            $form->setType("su_demo_shon1", "text");
            $form->setType("su_demo_shon2", "text");
            $form->setType("su_demo_shon3", "text");
            $form->setType("su_demo_shon4", "text");
            $form->setType("su_demo_shon5", "text");
            $form->setType("su_demo_shon6", "text");
            $form->setType("su_demo_shon7", "text");
            $form->setType("su_demo_shon8", "text");
            $form->setType("su_demo_shon9", "text");
            $form->setType("su_sup_shon1", "text");
            $form->setType("su_sup_shon2", "text");
            $form->setType("su_sup_shon3", "text");
            $form->setType("su_sup_shon4", "text");
            $form->setType("su_sup_shon5", "text");
            $form->setType("su_sup_shon6", "text");
            $form->setType("su_sup_shon7", "text");
            $form->setType("su_sup_shon8", "text");
            $form->setType("su_sup_shon9", "text");
            $form->setType("su_tot_shon1", "text");
            $form->setType("su_tot_shon2", "text");
            $form->setType("su_tot_shon3", "text");
            $form->setType("su_tot_shon4", "text");
            $form->setType("su_tot_shon5", "text");
            $form->setType("su_tot_shon6", "text");
            $form->setType("su_tot_shon7", "text");
            $form->setType("su_tot_shon8", "text");
            $form->setType("su_tot_shon9", "text");
            $form->setType("su_avt_shon_tot", "text");
            $form->setType("su_cstr_shon_tot", "text");
            $form->setType("su_trsf_shon_tot", "text");
            $form->setType("su_chge_shon_tot", "text");
            $form->setType("su_demo_shon_tot", "text");
            $form->setType("su_sup_shon_tot", "text");
            $form->setType("su_tot_shon_tot", "text");
            $form->setType("dm_constr_dates", "textarea");
            $form->setType("dm_total", "checkbox");
            $form->setType("dm_partiel", "checkbox");
            $form->setType("dm_projet_desc", "textarea");
            $form->setType("dm_tot_log_nb", "text");
            $form->setType("tax_surf_tot", "text");
            $form->setType("tax_surf", "text");
            $form->setType("tax_surf_suppr_mod", "text");
            $form->setType("tax_su_princ_log_nb1", "text");
            $form->setType("tax_su_princ_log_nb2", "text");
            $form->setType("tax_su_princ_log_nb3", "text");
            $form->setType("tax_su_princ_log_nb4", "text");
            $form->setType("tax_su_princ_log_nb_tot1", "text");
            $form->setType("tax_su_princ_log_nb_tot2", "text");
            $form->setType("tax_su_princ_log_nb_tot3", "text");
            $form->setType("tax_su_princ_log_nb_tot4", "text");
            $form->setType("tax_su_princ_surf1", "text");
            $form->setType("tax_su_princ_surf2", "text");
            $form->setType("tax_su_princ_surf3", "text");
            $form->setType("tax_su_princ_surf4", "text");
            $form->setType("tax_su_princ_surf_sup1", "text");
            $form->setType("tax_su_princ_surf_sup2", "text");
            $form->setType("tax_su_princ_surf_sup3", "text");
            $form->setType("tax_su_princ_surf_sup4", "text");
            $form->setType("tax_su_heber_log_nb1", "text");
            $form->setType("tax_su_heber_log_nb2", "text");
            $form->setType("tax_su_heber_log_nb3", "text");
            $form->setType("tax_su_heber_log_nb_tot1", "text");
            $form->setType("tax_su_heber_log_nb_tot2", "text");
            $form->setType("tax_su_heber_log_nb_tot3", "text");
            $form->setType("tax_su_heber_surf1", "text");
            $form->setType("tax_su_heber_surf2", "text");
            $form->setType("tax_su_heber_surf3", "text");
            $form->setType("tax_su_heber_surf_sup1", "text");
            $form->setType("tax_su_heber_surf_sup2", "text");
            $form->setType("tax_su_heber_surf_sup3", "text");
            $form->setType("tax_su_secon_log_nb", "text");
            $form->setType("tax_su_tot_log_nb", "text");
            $form->setType("tax_su_secon_log_nb_tot", "text");
            $form->setType("tax_su_tot_log_nb_tot", "text");
            $form->setType("tax_su_secon_surf", "text");
            $form->setType("tax_su_tot_surf", "text");
            $form->setType("tax_su_secon_surf_sup", "text");
            $form->setType("tax_su_tot_surf_sup", "text");
            $form->setType("tax_ext_pret", "checkbox");
            $form->setType("tax_ext_desc", "textarea");
            $form->setType("tax_surf_tax_exist_cons", "text");
            $form->setType("tax_log_exist_nb", "text");
            $form->setType("tax_am_statio_ext", "text");
            $form->setType("tax_sup_bass_pisc", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb", "text");
            $form->setType("tax_empl_hll_nb", "text");
            $form->setType("tax_eol_haut_nb", "text");
            $form->setType("tax_pann_volt_sup", "text");
            $form->setType("tax_am_statio_ext_sup", "text");
            $form->setType("tax_sup_bass_pisc_sup", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb_sup", "text");
            $form->setType("tax_empl_hll_nb_sup", "text");
            $form->setType("tax_eol_haut_nb_sup", "text");
            $form->setType("tax_pann_volt_sup_sup", "text");
            $form->setType("tax_trx_presc_ppr", "checkbox");
            $form->setType("tax_monu_hist", "checkbox");
            $form->setType("tax_comm_nb", "text");
            $form->setType("tax_su_non_habit_surf1", "text");
            $form->setType("tax_su_non_habit_surf2", "text");
            $form->setType("tax_su_non_habit_surf3", "text");
            $form->setType("tax_su_non_habit_surf4", "text");
            $form->setType("tax_su_non_habit_surf5", "text");
            $form->setType("tax_su_non_habit_surf6", "text");
            $form->setType("tax_su_non_habit_surf7", "text");
            $form->setType("tax_su_non_habit_surf_sup1", "text");
            $form->setType("tax_su_non_habit_surf_sup2", "text");
            $form->setType("tax_su_non_habit_surf_sup3", "text");
            $form->setType("tax_su_non_habit_surf_sup4", "text");
            $form->setType("tax_su_non_habit_surf_sup5", "text");
            $form->setType("tax_su_non_habit_surf_sup6", "text");
            $form->setType("tax_su_non_habit_surf_sup7", "text");
            $form->setType("vsd_surf_planch_smd", "checkbox");
            $form->setType("vsd_unit_fonc_sup", "text");
            $form->setType("vsd_unit_fonc_constr_sup", "text");
            $form->setType("vsd_val_terr", "text");
            $form->setType("vsd_const_sxist_non_dem_surf", "text");
            $form->setType("vsd_rescr_fisc", "date");
            $form->setType("pld_val_terr", "text");
            $form->setType("pld_const_exist_dem", "checkbox");
            $form->setType("pld_const_exist_dem_surf", "text");
            $form->setType("code_cnil", "checkbox");
            $form->setType("terr_juri_titul", "text");
            $form->setType("terr_juri_lot", "text");
            $form->setType("terr_juri_zac", "text");
            $form->setType("terr_juri_afu", "text");
            $form->setType("terr_juri_pup", "text");
            $form->setType("terr_juri_oin", "text");
            $form->setType("terr_juri_desc", "textarea");
            $form->setType("terr_div_surf_etab", "text");
            $form->setType("terr_div_surf_av_div", "text");
            $form->setType("doc_date", "date");
            $form->setType("doc_tot_trav", "checkbox");
            $form->setType("doc_tranche_trav", "checkbox");
            $form->setType("doc_tranche_trav_desc", "textarea");
            $form->setType("doc_surf", "text");
            $form->setType("doc_nb_log", "text");
            $form->setType("doc_nb_log_indiv", "text");
            $form->setType("doc_nb_log_coll", "text");
            $form->setType("doc_nb_log_lls", "text");
            $form->setType("doc_nb_log_aa", "text");
            $form->setType("doc_nb_log_ptz", "text");
            $form->setType("doc_nb_log_autre", "text");
            $form->setType("daact_date", "date");
            $form->setType("daact_date_chgmt_dest", "date");
            $form->setType("daact_tot_trav", "checkbox");
            $form->setType("daact_tranche_trav", "checkbox");
            $form->setType("daact_tranche_trav_desc", "textarea");
            $form->setType("daact_surf", "text");
            $form->setType("daact_nb_log", "text");
            $form->setType("daact_nb_log_indiv", "text");
            $form->setType("daact_nb_log_coll", "text");
            $form->setType("daact_nb_log_lls", "text");
            $form->setType("daact_nb_log_aa", "text");
            $form->setType("daact_nb_log_ptz", "text");
            $form->setType("daact_nb_log_autre", "text");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            $form->setType("am_div_mun", "checkbox");
            $form->setType("co_perf_energ", "text");
            if ($this->is_in_context_of_foreign_key("architecte", $this->retourformulaire)) {
                $form->setType("architecte", "selecthiddenstatic");
            } else {
                $form->setType("architecte", "select");
            }
            $form->setType("co_statio_avt_shob", "text");
            $form->setType("co_statio_apr_shob", "text");
            $form->setType("co_statio_avt_surf", "text");
            $form->setType("co_statio_apr_surf", "text");
            $form->setType("co_trx_amgt", "text");
            $form->setType("co_modif_aspect", "text");
            $form->setType("co_modif_struct", "text");
            $form->setType("co_ouvr_elec", "checkbox");
            $form->setType("co_ouvr_infra", "checkbox");
            $form->setType("co_trx_imm", "text");
            $form->setType("co_cstr_shob", "text");
            $form->setType("am_voyage_deb", "text");
            $form->setType("am_voyage_fin", "text");
            $form->setType("am_modif_amgt", "text");
            $form->setType("am_lot_max_shob", "text");
            $form->setType("mod_desc", "text");
            $form->setType("tr_total", "text");
            $form->setType("tr_partiel", "text");
            $form->setType("tr_desc", "text");
            $form->setType("avap_co_elt_pro", "checkbox");
            $form->setType("avap_nouv_haut_surf", "checkbox");
            $form->setType("avap_co_clot", "text");
            $form->setType("avap_aut_coup_aba_arb", "text");
            $form->setType("avap_ouv_infra", "text");
            $form->setType("avap_aut_inst_mob", "text");
            $form->setType("avap_aut_plant", "text");
            $form->setType("avap_aut_auv_elec", "text");
            $form->setType("tax_dest_loc_tr", "text");
            $form->setType("ope_proj_desc", "textarea");
            $form->setType("tax_surf_tot_cstr", "text");
            $form->setType("cerfa", "text");
            $form->setType("tax_surf_loc_stat", "text");
            $form->setType("tax_su_princ_surf_stat1", "text");
            $form->setType("tax_su_princ_surf_stat2", "text");
            $form->setType("tax_su_princ_surf_stat3", "text");
            $form->setType("tax_su_princ_surf_stat4", "text");
            $form->setType("tax_su_secon_surf_stat", "text");
            $form->setType("tax_su_heber_surf_stat1", "text");
            $form->setType("tax_su_heber_surf_stat2", "text");
            $form->setType("tax_su_heber_surf_stat3", "text");
            $form->setType("tax_su_tot_surf_stat", "text");
            $form->setType("tax_su_non_habit_surf_stat1", "text");
            $form->setType("tax_su_non_habit_surf_stat2", "text");
            $form->setType("tax_su_non_habit_surf_stat3", "text");
            $form->setType("tax_su_non_habit_surf_stat4", "text");
            $form->setType("tax_su_non_habit_surf_stat5", "text");
            $form->setType("tax_su_non_habit_surf_stat6", "text");
            $form->setType("tax_su_non_habit_surf_stat7", "text");
            $form->setType("tax_su_parc_statio_expl_comm_surf", "text");
            $form->setType("tax_log_ap_trvx_nb", "text");
            $form->setType("tax_am_statio_ext_cr", "text");
            $form->setType("tax_sup_bass_pisc_cr", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb_cr", "text");
            $form->setType("tax_empl_hll_nb_cr", "text");
            $form->setType("tax_eol_haut_nb_cr", "text");
            $form->setType("tax_pann_volt_sup_cr", "text");
            $form->setType("tax_surf_loc_arch", "text");
            $form->setType("tax_surf_pisc_arch", "text");
            $form->setType("tax_am_statio_ext_arch", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb_arch", "text");
            $form->setType("tax_empl_hll_nb_arch", "text");
            $form->setType("tax_eol_haut_nb_arch", "text");
            $form->setType("ope_proj_div_co", "checkbox");
            $form->setType("ope_proj_div_contr", "checkbox");
            $form->setType("tax_desc", "textarea");
            $form->setType("erp_cstr_neuve", "checkbox");
            $form->setType("erp_trvx_acc", "checkbox");
            $form->setType("erp_extension", "checkbox");
            $form->setType("erp_rehab", "checkbox");
            $form->setType("erp_trvx_am", "checkbox");
            $form->setType("erp_vol_nouv_exist", "checkbox");
            $form->setType("erp_loc_eff1", "text");
            $form->setType("erp_loc_eff2", "text");
            $form->setType("erp_loc_eff3", "text");
            $form->setType("erp_loc_eff4", "text");
            $form->setType("erp_loc_eff5", "text");
            $form->setType("erp_loc_eff_tot", "text");
            $form->setType("erp_public_eff1", "text");
            $form->setType("erp_public_eff2", "text");
            $form->setType("erp_public_eff3", "text");
            $form->setType("erp_public_eff4", "text");
            $form->setType("erp_public_eff5", "text");
            $form->setType("erp_public_eff_tot", "text");
            $form->setType("erp_perso_eff1", "text");
            $form->setType("erp_perso_eff2", "text");
            $form->setType("erp_perso_eff3", "text");
            $form->setType("erp_perso_eff4", "text");
            $form->setType("erp_perso_eff5", "text");
            $form->setType("erp_perso_eff_tot", "text");
            $form->setType("erp_tot_eff1", "text");
            $form->setType("erp_tot_eff2", "text");
            $form->setType("erp_tot_eff3", "text");
            $form->setType("erp_tot_eff4", "text");
            $form->setType("erp_tot_eff5", "text");
            $form->setType("erp_tot_eff_tot", "text");
            $form->setType("erp_class_cat", "text");
            $form->setType("erp_class_type", "text");
            $form->setType("tax_surf_abr_jard_pig_colom", "text");
            $form->setType("tax_su_non_habit_abr_jard_pig_colom", "text");
            $form->setType("dia_imm_non_bati", "checkbox");
            $form->setType("dia_imm_bati_terr_propr", "checkbox");
            $form->setType("dia_imm_bati_terr_autr", "checkbox");
            $form->setType("dia_imm_bati_terr_autr_desc", "textarea");
            $form->setType("dia_bat_copro", "checkbox");
            $form->setType("dia_bat_copro_desc", "textarea");
            $form->setType("dia_lot_numero", "textarea");
            $form->setType("dia_lot_bat", "textarea");
            $form->setType("dia_lot_etage", "textarea");
            $form->setType("dia_lot_quote_part", "textarea");
            $form->setType("dia_us_hab", "checkbox");
            $form->setType("dia_us_pro", "checkbox");
            $form->setType("dia_us_mixte", "checkbox");
            $form->setType("dia_us_comm", "checkbox");
            $form->setType("dia_us_agr", "checkbox");
            $form->setType("dia_us_autre", "checkbox");
            $form->setType("dia_us_autre_prec", "textarea");
            $form->setType("dia_occ_prop", "checkbox");
            $form->setType("dia_occ_loc", "checkbox");
            $form->setType("dia_occ_sans_occ", "checkbox");
            $form->setType("dia_occ_autre", "checkbox");
            $form->setType("dia_occ_autre_prec", "textarea");
            $form->setType("dia_mod_cess_prix_vente", "text");
            $form->setType("dia_mod_cess_prix_vente_mob", "text");
            $form->setType("dia_mod_cess_prix_vente_cheptel", "text");
            $form->setType("dia_mod_cess_prix_vente_recol", "text");
            $form->setType("dia_mod_cess_prix_vente_autre", "text");
            $form->setType("dia_mod_cess_commi", "checkbox");
            $form->setType("dia_mod_cess_commi_ttc", "text");
            $form->setType("dia_mod_cess_commi_ht", "text");
            $form->setType("dia_acquereur_nom_prenom", "text");
            $form->setType("dia_acquereur_adr_num_voie", "text");
            $form->setType("dia_acquereur_adr_ext", "text");
            $form->setType("dia_acquereur_adr_type_voie", "text");
            $form->setType("dia_acquereur_adr_nom_voie", "text");
            $form->setType("dia_acquereur_adr_lieu_dit_bp", "text");
            $form->setType("dia_acquereur_adr_cp", "text");
            $form->setType("dia_acquereur_adr_localite", "text");
            $form->setType("dia_observation", "textarea");
            $form->setType("su2_avt_shon1", "text");
            $form->setType("su2_avt_shon2", "text");
            $form->setType("su2_avt_shon3", "text");
            $form->setType("su2_avt_shon4", "text");
            $form->setType("su2_avt_shon5", "text");
            $form->setType("su2_avt_shon6", "text");
            $form->setType("su2_avt_shon7", "text");
            $form->setType("su2_avt_shon8", "text");
            $form->setType("su2_avt_shon9", "text");
            $form->setType("su2_avt_shon10", "text");
            $form->setType("su2_avt_shon11", "text");
            $form->setType("su2_avt_shon12", "text");
            $form->setType("su2_avt_shon13", "text");
            $form->setType("su2_avt_shon14", "text");
            $form->setType("su2_avt_shon15", "text");
            $form->setType("su2_avt_shon16", "text");
            $form->setType("su2_avt_shon17", "text");
            $form->setType("su2_avt_shon18", "text");
            $form->setType("su2_avt_shon19", "text");
            $form->setType("su2_avt_shon20", "text");
            $form->setType("su2_avt_shon_tot", "text");
            $form->setType("su2_cstr_shon1", "text");
            $form->setType("su2_cstr_shon2", "text");
            $form->setType("su2_cstr_shon3", "text");
            $form->setType("su2_cstr_shon4", "text");
            $form->setType("su2_cstr_shon5", "text");
            $form->setType("su2_cstr_shon6", "text");
            $form->setType("su2_cstr_shon7", "text");
            $form->setType("su2_cstr_shon8", "text");
            $form->setType("su2_cstr_shon9", "text");
            $form->setType("su2_cstr_shon10", "text");
            $form->setType("su2_cstr_shon11", "text");
            $form->setType("su2_cstr_shon12", "text");
            $form->setType("su2_cstr_shon13", "text");
            $form->setType("su2_cstr_shon14", "text");
            $form->setType("su2_cstr_shon15", "text");
            $form->setType("su2_cstr_shon16", "text");
            $form->setType("su2_cstr_shon17", "text");
            $form->setType("su2_cstr_shon18", "text");
            $form->setType("su2_cstr_shon19", "text");
            $form->setType("su2_cstr_shon20", "text");
            $form->setType("su2_cstr_shon_tot", "text");
            $form->setType("su2_chge_shon1", "text");
            $form->setType("su2_chge_shon2", "text");
            $form->setType("su2_chge_shon3", "text");
            $form->setType("su2_chge_shon4", "text");
            $form->setType("su2_chge_shon5", "text");
            $form->setType("su2_chge_shon6", "text");
            $form->setType("su2_chge_shon7", "text");
            $form->setType("su2_chge_shon8", "text");
            $form->setType("su2_chge_shon9", "text");
            $form->setType("su2_chge_shon10", "text");
            $form->setType("su2_chge_shon11", "text");
            $form->setType("su2_chge_shon12", "text");
            $form->setType("su2_chge_shon13", "text");
            $form->setType("su2_chge_shon14", "text");
            $form->setType("su2_chge_shon15", "text");
            $form->setType("su2_chge_shon16", "text");
            $form->setType("su2_chge_shon17", "text");
            $form->setType("su2_chge_shon18", "text");
            $form->setType("su2_chge_shon19", "text");
            $form->setType("su2_chge_shon20", "text");
            $form->setType("su2_chge_shon_tot", "text");
            $form->setType("su2_demo_shon1", "text");
            $form->setType("su2_demo_shon2", "text");
            $form->setType("su2_demo_shon3", "text");
            $form->setType("su2_demo_shon4", "text");
            $form->setType("su2_demo_shon5", "text");
            $form->setType("su2_demo_shon6", "text");
            $form->setType("su2_demo_shon7", "text");
            $form->setType("su2_demo_shon8", "text");
            $form->setType("su2_demo_shon9", "text");
            $form->setType("su2_demo_shon10", "text");
            $form->setType("su2_demo_shon11", "text");
            $form->setType("su2_demo_shon12", "text");
            $form->setType("su2_demo_shon13", "text");
            $form->setType("su2_demo_shon14", "text");
            $form->setType("su2_demo_shon15", "text");
            $form->setType("su2_demo_shon16", "text");
            $form->setType("su2_demo_shon17", "text");
            $form->setType("su2_demo_shon18", "text");
            $form->setType("su2_demo_shon19", "text");
            $form->setType("su2_demo_shon20", "text");
            $form->setType("su2_demo_shon_tot", "text");
            $form->setType("su2_sup_shon1", "text");
            $form->setType("su2_sup_shon2", "text");
            $form->setType("su2_sup_shon3", "text");
            $form->setType("su2_sup_shon4", "text");
            $form->setType("su2_sup_shon5", "text");
            $form->setType("su2_sup_shon6", "text");
            $form->setType("su2_sup_shon7", "text");
            $form->setType("su2_sup_shon8", "text");
            $form->setType("su2_sup_shon9", "text");
            $form->setType("su2_sup_shon10", "text");
            $form->setType("su2_sup_shon11", "text");
            $form->setType("su2_sup_shon12", "text");
            $form->setType("su2_sup_shon13", "text");
            $form->setType("su2_sup_shon14", "text");
            $form->setType("su2_sup_shon15", "text");
            $form->setType("su2_sup_shon16", "text");
            $form->setType("su2_sup_shon17", "text");
            $form->setType("su2_sup_shon18", "text");
            $form->setType("su2_sup_shon19", "text");
            $form->setType("su2_sup_shon20", "text");
            $form->setType("su2_sup_shon_tot", "text");
            $form->setType("su2_tot_shon1", "text");
            $form->setType("su2_tot_shon2", "text");
            $form->setType("su2_tot_shon3", "text");
            $form->setType("su2_tot_shon4", "text");
            $form->setType("su2_tot_shon5", "text");
            $form->setType("su2_tot_shon6", "text");
            $form->setType("su2_tot_shon7", "text");
            $form->setType("su2_tot_shon8", "text");
            $form->setType("su2_tot_shon9", "text");
            $form->setType("su2_tot_shon10", "text");
            $form->setType("su2_tot_shon11", "text");
            $form->setType("su2_tot_shon12", "text");
            $form->setType("su2_tot_shon13", "text");
            $form->setType("su2_tot_shon14", "text");
            $form->setType("su2_tot_shon15", "text");
            $form->setType("su2_tot_shon16", "text");
            $form->setType("su2_tot_shon17", "text");
            $form->setType("su2_tot_shon18", "text");
            $form->setType("su2_tot_shon19", "text");
            $form->setType("su2_tot_shon20", "text");
            $form->setType("su2_tot_shon_tot", "text");
            $form->setType("dia_occ_sol_su_terre", "textarea");
            $form->setType("dia_occ_sol_su_pres", "textarea");
            $form->setType("dia_occ_sol_su_verger", "textarea");
            $form->setType("dia_occ_sol_su_vigne", "textarea");
            $form->setType("dia_occ_sol_su_bois", "textarea");
            $form->setType("dia_occ_sol_su_lande", "textarea");
            $form->setType("dia_occ_sol_su_carriere", "textarea");
            $form->setType("dia_occ_sol_su_eau_cadastree", "textarea");
            $form->setType("dia_occ_sol_su_jardin", "textarea");
            $form->setType("dia_occ_sol_su_terr_batir", "textarea");
            $form->setType("dia_occ_sol_su_terr_agr", "textarea");
            $form->setType("dia_occ_sol_su_sol", "textarea");
            $form->setType("dia_bati_vend_tot", "checkbox");
            $form->setType("dia_bati_vend_tot_txt", "textarea");
            $form->setType("dia_su_co_sol", "textarea");
            $form->setType("dia_su_util_hab", "textarea");
            $form->setType("dia_nb_niv", "textarea");
            $form->setType("dia_nb_appart", "textarea");
            $form->setType("dia_nb_autre_loc", "textarea");
            $form->setType("dia_vente_lot_volume", "checkbox");
            $form->setType("dia_vente_lot_volume_txt", "textarea");
            $form->setType("dia_lot_nat_su", "textarea");
            $form->setType("dia_lot_bat_achv_plus_10", "checkbox");
            $form->setType("dia_lot_bat_achv_moins_10", "checkbox");
            $form->setType("dia_lot_regl_copro_publ_hypo_plus_10", "checkbox");
            $form->setType("dia_lot_regl_copro_publ_hypo_moins_10", "checkbox");
            $form->setType("dia_indivi_quote_part", "textarea");
            $form->setType("dia_design_societe", "textarea");
            $form->setType("dia_design_droit", "textarea");
            $form->setType("dia_droit_soc_nat", "textarea");
            $form->setType("dia_droit_soc_nb", "textarea");
            $form->setType("dia_droit_soc_num_part", "textarea");
            $form->setType("dia_droit_reel_perso_grevant_bien_oui", "checkbox");
            $form->setType("dia_droit_reel_perso_grevant_bien_non", "checkbox");
            $form->setType("dia_droit_reel_perso_nat", "textarea");
            $form->setType("dia_droit_reel_perso_viag", "textarea");
            $form->setType("dia_mod_cess_adr", "textarea");
            $form->setType("dia_mod_cess_sign_act_auth", "checkbox");
            $form->setType("dia_mod_cess_terme", "checkbox");
            $form->setType("dia_mod_cess_terme_prec", "textarea");
            $form->setType("dia_mod_cess_bene_acquereur", "checkbox");
            $form->setType("dia_mod_cess_bene_vendeur", "checkbox");
            $form->setType("dia_mod_cess_paie_nat", "checkbox");
            $form->setType("dia_mod_cess_design_contr_alien", "textarea");
            $form->setType("dia_mod_cess_eval_contr", "textarea");
            $form->setType("dia_mod_cess_rente_viag", "checkbox");
            $form->setType("dia_mod_cess_mnt_an", "textarea");
            $form->setType("dia_mod_cess_mnt_compt", "textarea");
            $form->setType("dia_mod_cess_bene_rente", "textarea");
            $form->setType("dia_mod_cess_droit_usa_hab", "checkbox");
            $form->setType("dia_mod_cess_droit_usa_hab_prec", "textarea");
            $form->setType("dia_mod_cess_eval_usa_usufruit", "textarea");
            $form->setType("dia_mod_cess_vente_nue_prop", "checkbox");
            $form->setType("dia_mod_cess_vente_nue_prop_prec", "textarea");
            $form->setType("dia_mod_cess_echange", "checkbox");
            $form->setType("dia_mod_cess_design_bien_recus_ech", "textarea");
            $form->setType("dia_mod_cess_mnt_soulte", "textarea");
            $form->setType("dia_mod_cess_prop_contre_echan", "textarea");
            $form->setType("dia_mod_cess_apport_societe", "textarea");
            $form->setType("dia_mod_cess_bene", "textarea");
            $form->setType("dia_mod_cess_esti_bien", "textarea");
            $form->setType("dia_mod_cess_cess_terr_loc_co", "checkbox");
            $form->setType("dia_mod_cess_esti_terr", "textarea");
            $form->setType("dia_mod_cess_esti_loc", "textarea");
            $form->setType("dia_mod_cess_esti_imm_loca", "checkbox");
            $form->setType("dia_mod_cess_adju_vol", "checkbox");
            $form->setType("dia_mod_cess_adju_obl", "checkbox");
            $form->setType("dia_mod_cess_adju_fin_indivi", "checkbox");
            $form->setType("dia_mod_cess_adju_date_lieu", "textarea");
            $form->setType("dia_mod_cess_mnt_mise_prix", "textarea");
            $form->setType("dia_prop_titu_prix_indique", "checkbox");
            $form->setType("dia_prop_recherche_acqu_prix_indique", "checkbox");
            $form->setType("dia_acquereur_prof", "textarea");
            $form->setType("dia_indic_compl_ope", "textarea");
            $form->setType("dia_vente_adju", "checkbox");
            $form->setType("am_terr_res_demon", "checkbox");
            $form->setType("am_air_terr_res_mob", "checkbox");
            if ($this->is_in_context_of_foreign_key("objet_recours", $this->retourformulaire)) {
                $form->setType("ctx_objet_recours", "selecthiddenstatic");
            } else {
                $form->setType("ctx_objet_recours", "select");
            }
            $form->setType("ctx_reference_sagace", "text");
            $form->setType("ctx_nature_travaux_infra_om_html", "html");
            $form->setType("ctx_synthese_nti", "textarea");
            $form->setType("ctx_article_non_resp_om_html", "html");
            $form->setType("ctx_synthese_anr", "textarea");
            $form->setType("ctx_reference_parquet", "text");
            $form->setType("ctx_element_taxation", "text");
            $form->setType("ctx_infraction", "checkbox");
            $form->setType("ctx_regularisable", "checkbox");
            $form->setType("ctx_reference_courrier", "text");
            $form->setType("ctx_date_audience", "date");
            $form->setType("ctx_date_ajournement", "date");
            $form->setType("exo_facul_1", "checkbox");
            $form->setType("exo_facul_2", "checkbox");
            $form->setType("exo_facul_3", "checkbox");
            $form->setType("exo_facul_4", "checkbox");
            $form->setType("exo_facul_5", "checkbox");
            $form->setType("exo_facul_6", "checkbox");
            $form->setType("exo_facul_7", "checkbox");
            $form->setType("exo_facul_8", "checkbox");
            $form->setType("exo_facul_9", "checkbox");
            $form->setType("exo_ta_1", "checkbox");
            $form->setType("exo_ta_2", "checkbox");
            $form->setType("exo_ta_3", "checkbox");
            $form->setType("exo_ta_4", "checkbox");
            $form->setType("exo_ta_5", "checkbox");
            $form->setType("exo_ta_6", "checkbox");
            $form->setType("exo_ta_7", "checkbox");
            $form->setType("exo_ta_8", "checkbox");
            $form->setType("exo_ta_9", "checkbox");
            $form->setType("exo_rap_1", "checkbox");
            $form->setType("exo_rap_2", "checkbox");
            $form->setType("exo_rap_3", "checkbox");
            $form->setType("exo_rap_4", "checkbox");
            $form->setType("exo_rap_5", "checkbox");
            $form->setType("exo_rap_6", "checkbox");
            $form->setType("exo_rap_7", "checkbox");
            $form->setType("exo_rap_8", "checkbox");
            $form->setType("mtn_exo_ta_part_commu", "text");
            $form->setType("mtn_exo_ta_part_depart", "text");
            $form->setType("mtn_exo_ta_part_reg", "text");
            $form->setType("mtn_exo_rap", "text");
            $form->setType("dpc_type", "text");
            $form->setType("dpc_desc_actv_ex", "textarea");
            $form->setType("dpc_desc_ca", "textarea");
            $form->setType("dpc_desc_aut_prec", "textarea");
            $form->setType("dpc_desig_comm_arti", "checkbox");
            $form->setType("dpc_desig_loc_hab", "checkbox");
            $form->setType("dpc_desig_loc_ann", "checkbox");
            $form->setType("dpc_desig_loc_ann_prec", "textarea");
            $form->setType("dpc_bail_comm_date", "date");
            $form->setType("dpc_bail_comm_loyer", "textarea");
            $form->setType("dpc_actv_acqu", "textarea");
            $form->setType("dpc_nb_sala_di", "textarea");
            $form->setType("dpc_nb_sala_dd", "textarea");
            $form->setType("dpc_nb_sala_tc", "textarea");
            $form->setType("dpc_nb_sala_tp", "textarea");
            $form->setType("dpc_moda_cess_vente_am", "checkbox");
            $form->setType("dpc_moda_cess_adj", "checkbox");
            $form->setType("dpc_moda_cess_prix", "textarea");
            $form->setType("dpc_moda_cess_adj_date", "date");
            $form->setType("dpc_moda_cess_adj_prec", "textarea");
            $form->setType("dpc_moda_cess_paie_comp", "checkbox");
            $form->setType("dpc_moda_cess_paie_terme", "checkbox");
            $form->setType("dpc_moda_cess_paie_terme_prec", "textarea");
            $form->setType("dpc_moda_cess_paie_nat", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien_prec", "textarea");
            $form->setType("dpc_moda_cess_paie_nat_eval", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_eval_prec", "textarea");
            $form->setType("dpc_moda_cess_paie_aut", "checkbox");
            $form->setType("dpc_moda_cess_paie_aut_prec", "textarea");
            $form->setType("dpc_ss_signe_demande_acqu", "checkbox");
            $form->setType("dpc_ss_signe_recher_trouv_acqu", "checkbox");
            $form->setType("dpc_notif_adr_prop", "checkbox");
            $form->setType("dpc_notif_adr_manda", "checkbox");
            $form->setType("dpc_obs", "textarea");
            $form->setType("co_peri_site_patri_remar", "checkbox");
            $form->setType("co_abo_monu_hist", "checkbox");
            $form->setType("co_inst_ouvr_trav_act_code_envir", "checkbox");
            $form->setType("co_trav_auto_env", "checkbox");
            $form->setType("co_derog_esp_prot", "checkbox");
            $form->setType("ctx_reference_dsj", "text");
            $form->setType("co_piscine", "checkbox");
            $form->setType("co_fin_lls", "checkbox");
            $form->setType("co_fin_aa", "checkbox");
            $form->setType("co_fin_ptz", "checkbox");
            $form->setType("co_fin_autr", "textarea");
            $form->setType("dia_ss_date", "date");
            $form->setType("dia_ss_lieu", "text");
            $form->setType("enga_decla_lieu", "text");
            $form->setType("enga_decla_date", "date");
            $form->setType("co_archi_attest_honneur", "checkbox");
            $form->setType("co_bat_niv_dessous_nb", "text");
            $form->setType("co_install_classe", "checkbox");
            $form->setType("co_derog_innov", "checkbox");
            $form->setType("co_avis_abf", "checkbox");
            $form->setType("tax_surf_tot_demo", "text");
            $form->setType("tax_surf_tax_demo", "text");
            $form->setType("tax_su_non_habit_surf8", "text");
            $form->setType("tax_su_non_habit_surf_stat8", "text");
            $form->setType("tax_su_non_habit_surf9", "text");
            $form->setType("tax_su_non_habit_surf_stat9", "text");
            $form->setType("tax_terrassement_arch", "checkbox");
            $form->setType("tax_adresse_future_numero", "text");
            $form->setType("tax_adresse_future_voie", "text");
            $form->setType("tax_adresse_future_lieudit", "text");
            $form->setType("tax_adresse_future_localite", "text");
            $form->setType("tax_adresse_future_cp", "text");
            $form->setType("tax_adresse_future_bp", "text");
            $form->setType("tax_adresse_future_cedex", "text");
            $form->setType("tax_adresse_future_pays", "text");
            $form->setType("tax_adresse_future_division", "text");
            $form->setType("co_bat_projete", "textarea");
            $form->setType("co_bat_existant", "textarea");
            $form->setType("co_bat_nature", "textarea");
            $form->setType("terr_juri_titul_date", "date");
            $form->setType("co_autre_desc", "textarea");
            $form->setType("co_trx_autre", "textarea");
            $form->setType("co_autre", "checkbox");
            $form->setType("erp_modif_facades", "checkbox");
            $form->setType("erp_trvx_adap", "checkbox");
            $form->setType("erp_trvx_adap_numero", "text");
            $form->setType("erp_trvx_adap_valid", "date");
            $form->setType("erp_prod_dangereux", "checkbox");
            $form->setType("co_trav_supp_dessus", "text");
            $form->setType("co_trav_supp_dessous", "text");
            $form->setType("tax_su_habit_abr_jard_pig_colom", "text");
            $form->setType("enga_decla_donnees_nomi_comm", "checkbox");
            $form->setType("x1l_legislation", "checkbox");
            $form->setType("x1p_precisions", "text");
            $form->setType("x1u_raccordement", "checkbox");
            $form->setType("x2m_inscritmh", "checkbox");
            $form->setType("s1na1_numero", "text");
            $form->setType("s1va1_voie", "text");
            $form->setType("s1wa1_lieudit", "text");
            $form->setType("s1la1_localite", "text");
            $form->setType("s1pa1_codepostal", "text");
            $form->setType("s1na2_numero", "text");
            $form->setType("s1va2_voie", "text");
            $form->setType("s1wa2_lieudit", "text");
            $form->setType("s1la2_localite", "text");
            $form->setType("s1pa2_codepostal", "text");
            $form->setType("e3c_certification", "checkbox");
            $form->setType("e3a_competence", "checkbox");
            $form->setType("a4d_description", "text");
            $form->setType("m2b_abf", "checkbox");
            $form->setType("m2j_pn", "checkbox");
            $form->setType("m2r_cdac", "checkbox");
            $form->setType("m2r_cnac", "checkbox");
            $form->setType("u3a_voirieoui", "checkbox");
            $form->setType("u3f_voirienon", "checkbox");
            $form->setType("u3c_eauoui", "checkbox");
            $form->setType("u3h_eaunon", "checkbox");
            $form->setType("u3g_assainissementoui", "checkbox");
            $form->setType("u3n_assainissementnon", "checkbox");
            $form->setType("u3m_electriciteoui", "checkbox");
            $form->setType("u3b_electricitenon", "checkbox");
            $form->setType("u3t_observations", "text");
            $form->setType("u1a_voirieoui", "checkbox");
            $form->setType("u1v_voirienon", "checkbox");
            $form->setType("u1q_voirieconcessionnaire", "text");
            $form->setType("u1b_voirieavant", "date");
            $form->setType("u1j_eauoui", "checkbox");
            $form->setType("u1t_eaunon", "checkbox");
            $form->setType("u1e_eauconcessionnaire", "text");
            $form->setType("u1k_eauavant", "date");
            $form->setType("u1s_assainissementoui", "checkbox");
            $form->setType("u1d_assainissementnon", "checkbox");
            $form->setType("u1l_assainissementconcessionnaire", "text");
            $form->setType("u1r_assainissementavant", "date");
            $form->setType("u1c_electriciteoui", "checkbox");
            $form->setType("u1u_electricitenon", "checkbox");
            $form->setType("u1m_electriciteconcessionnaire", "text");
            $form->setType("u1f_electriciteavant", "date");
            $form->setType("u2a_observations", "text");
            $form->setType("f1ts4_surftaxestation", "text");
            $form->setType("f1ut1_surfcree", "text");
            $form->setType("f9d_date", "date");
            $form->setType("f9n_nom", "text");
            $form->setType("su2_avt_shon21", "text");
            $form->setType("su2_avt_shon22", "text");
            $form->setType("su2_cstr_shon21", "text");
            $form->setType("su2_cstr_shon22", "text");
            $form->setType("su2_chge_shon21", "text");
            $form->setType("su2_chge_shon22", "text");
            $form->setType("su2_demo_shon21", "text");
            $form->setType("su2_demo_shon22", "text");
            $form->setType("su2_sup_shon21", "text");
            $form->setType("su2_sup_shon22", "text");
            $form->setType("su2_tot_shon21", "text");
            $form->setType("su2_tot_shon22", "text");
            $form->setType("f1gu1_f1gu2_f1gu3", "text");
            $form->setType("f1lu1_f1lu2_f1lu3", "text");
            $form->setType("f1zu1_f1zu2_f1zu3", "text");
            $form->setType("f1pu1_f1pu2_f1pu3", "text");
            $form->setType("f1gt4_f1gt5_f1gt6", "text");
            $form->setType("f1lt4_f1lt5_f1lt6", "text");
            $form->setType("f1zt4_f1zt5_f1zt6", "text");
            $form->setType("f1pt4_f1pt5_f1pt6", "text");
            $form->setType("f1xu1_f1xu2_f1xu3", "text");
            $form->setType("f1xt4_f1xt5_f1xt6", "text");
            $form->setType("f1hu1_f1hu2_f1hu3", "text");
            $form->setType("f1mu1_f1mu2_f1mu3", "text");
            $form->setType("f1qu1_f1qu2_f1qu3", "text");
            $form->setType("f1ht4_f1ht5_f1ht6", "text");
            $form->setType("f1mt4_f1mt5_f1mt6", "text");
            $form->setType("f1qt4_f1qt5_f1qt6", "text");
            $form->setType("f2cu1_f2cu2_f2cu3", "text");
            $form->setType("f2bu1_f2bu2_f2bu3", "text");
            $form->setType("f2su1_f2su2_f2su3", "text");
            $form->setType("f2hu1_f2hu2_f2hu3", "text");
            $form->setType("f2eu1_f2eu2_f2eu3", "text");
            $form->setType("f2qu1_f2qu2_f2qu3", "text");
            $form->setType("f2ct4_f2ct5_f2ct6", "text");
            $form->setType("f2bt4_f2bt5_f2bt6", "text");
            $form->setType("f2st4_f2st5_f2st6", "text");
            $form->setType("f2ht4_f2ht5_f2ht6", "text");
            $form->setType("f2et4_f2et5_f2et6", "text");
            $form->setType("f2qt4_f2qt5_f2qt6", "text");
            $form->setType("dia_droit_reel_perso_grevant_bien_desc", "textarea");
            $form->setType("dia_mod_cess_paie_nat_desc", "textarea");
            $form->setType("dia_mod_cess_rente_viag_desc", "textarea");
            $form->setType("dia_mod_cess_echange_desc", "textarea");
            $form->setType("dia_mod_cess_apport_societe_desc", "textarea");
            $form->setType("dia_mod_cess_cess_terr_loc_co_desc", "textarea");
            $form->setType("dia_mod_cess_esti_imm_loca_desc", "textarea");
            $form->setType("dia_mod_cess_adju_obl_desc", "textarea");
            $form->setType("dia_mod_cess_adju_fin_indivi_desc", "textarea");
            $form->setType("dia_cadre_titul_droit_prempt", "textarea");
            $form->setType("dia_mairie_prix_moyen", "text");
            $form->setType("dia_propri_indivi", "textarea");
            $form->setType("dia_situa_bien_plan_cadas_oui", "checkbox");
            $form->setType("dia_situa_bien_plan_cadas_non", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_prop", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_prop_desc", "textarea");
            $form->setType("dia_notif_dec_titul_adr_manda", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_manda_desc", "textarea");
            $form->setType("dia_dia_dpu", "checkbox");
            $form->setType("dia_dia_zad", "checkbox");
            $form->setType("dia_dia_zone_preempt_esp_natu_sensi", "checkbox");
            $form->setType("dia_dab_dpu", "checkbox");
            $form->setType("dia_dab_zad", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt", "text");
            $form->setType("dia_mod_cess_commi_mnt_ttc", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt_ht", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_num", "text");
            $form->setType("dia_mod_cess_prix_vente_mob_num", "text");
            $form->setType("dia_mod_cess_prix_vente_cheptel_num", "text");
            $form->setType("dia_mod_cess_prix_vente_recol_num", "text");
            $form->setType("dia_mod_cess_prix_vente_autre_num", "text");
            $form->setType("dia_su_co_sol_num", "text");
            $form->setType("dia_su_util_hab_num", "text");
            $form->setType("dia_mod_cess_mnt_an_num", "text");
            $form->setType("dia_mod_cess_mnt_compt_num", "text");
            $form->setType("dia_mod_cess_mnt_soulte_num", "text");
            $form->setType("dia_comp_prix_vente", "text");
            $form->setType("dia_comp_surface", "text");
            $form->setType("dia_comp_total_frais", "text");
            $form->setType("dia_comp_mtn_total", "text");
            $form->setType("dia_comp_valeur_m2", "text");
            $form->setType("dia_esti_prix_france_dom", "text");
            $form->setType("dia_prop_collectivite", "text");
            $form->setType("dia_delegataire_denomination", "text");
            $form->setType("dia_delegataire_raison_sociale", "text");
            $form->setType("dia_delegataire_siret", "text");
            $form->setType("dia_delegataire_categorie_juridique", "text");
            $form->setType("dia_delegataire_representant_nom", "text");
            $form->setType("dia_delegataire_representant_prenom", "text");
            $form->setType("dia_delegataire_adresse_numero", "text");
            $form->setType("dia_delegataire_adresse_voie", "text");
            $form->setType("dia_delegataire_adresse_complement", "text");
            $form->setType("dia_delegataire_adresse_lieu_dit", "text");
            $form->setType("dia_delegataire_adresse_localite", "text");
            $form->setType("dia_delegataire_adresse_code_postal", "text");
            $form->setType("dia_delegataire_adresse_bp", "text");
            $form->setType("dia_delegataire_adresse_cedex", "text");
            $form->setType("dia_delegataire_adresse_pays", "text");
            $form->setType("dia_delegataire_telephone_fixe", "text");
            $form->setType("dia_delegataire_telephone_mobile", "text");
            $form->setType("dia_delegataire_telephone_mobile_indicatif", "text");
            $form->setType("dia_delegataire_courriel", "text");
            $form->setType("dia_delegataire_fax", "text");
            $form->setType("dia_entree_jouissance_type", "text");
            $form->setType("dia_entree_jouissance_date", "date");
            $form->setType("dia_entree_jouissance_date_effet", "date");
            $form->setType("dia_entree_jouissance_com", "textarea");
            $form->setType("dia_remise_bien_date_effet", "date");
            $form->setType("dia_remise_bien_com", "textarea");
            $form->setType("c2zp1_crete", "text");
            $form->setType("c2zr1_destination", "text");
            $form->setType("mh_design_appel_denom", "textarea");
            $form->setType("mh_design_type_protect", "text");
            $form->setType("mh_design_elem_prot", "textarea");
            $form->setType("mh_design_ref_merimee_palissy", "text");
            $form->setType("mh_design_nature_prop", "text");
            $form->setType("mh_loc_denom", "textarea");
            $form->setType("mh_pres_intitule", "textarea");
            $form->setType("mh_trav_cat_1", "checkbox");
            $form->setType("mh_trav_cat_2", "checkbox");
            $form->setType("mh_trav_cat_3", "checkbox");
            $form->setType("mh_trav_cat_4", "checkbox");
            $form->setType("mh_trav_cat_5", "checkbox");
            $form->setType("mh_trav_cat_6", "checkbox");
            $form->setType("mh_trav_cat_7", "checkbox");
            $form->setType("mh_trav_cat_8", "checkbox");
            $form->setType("mh_trav_cat_9", "checkbox");
            $form->setType("mh_trav_cat_10", "checkbox");
            $form->setType("mh_trav_cat_11", "checkbox");
            $form->setType("mh_trav_cat_12", "checkbox");
            $form->setType("mh_trav_cat_12_prec", "textarea");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("donnees_techniques", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_instruction", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction", "select");
            }
            if ($this->is_in_context_of_foreign_key("lot", $this->retourformulaire)) {
                $form->setType("lot", "selecthiddenstatic");
            } else {
                $form->setType("lot", "select");
            }
            $form->setType("am_lotiss", "checkbox");
            $form->setType("am_autre_div", "checkbox");
            $form->setType("am_camping", "checkbox");
            $form->setType("am_caravane", "checkbox");
            $form->setType("am_carav_duree", "text");
            $form->setType("am_statio", "checkbox");
            $form->setType("am_statio_cont", "text");
            $form->setType("am_affou_exhau", "checkbox");
            $form->setType("am_affou_exhau_sup", "text");
            $form->setType("am_affou_prof", "text");
            $form->setType("am_exhau_haut", "text");
            $form->setType("am_coupe_abat", "checkbox");
            $form->setType("am_prot_plu", "checkbox");
            $form->setType("am_prot_muni", "checkbox");
            $form->setType("am_mobil_voyage", "checkbox");
            $form->setType("am_aire_voyage", "checkbox");
            $form->setType("am_rememb_afu", "checkbox");
            $form->setType("am_parc_resid_loi", "checkbox");
            $form->setType("am_sport_moto", "checkbox");
            $form->setType("am_sport_attrac", "checkbox");
            $form->setType("am_sport_golf", "checkbox");
            $form->setType("am_mob_art", "checkbox");
            $form->setType("am_modif_voie_esp", "checkbox");
            $form->setType("am_plant_voie_esp", "checkbox");
            $form->setType("am_chem_ouv_esp", "checkbox");
            $form->setType("am_agri_peche", "checkbox");
            $form->setType("am_crea_voie", "checkbox");
            $form->setType("am_modif_voie_exist", "checkbox");
            $form->setType("am_crea_esp_sauv", "checkbox");
            $form->setType("am_crea_esp_class", "checkbox");
            $form->setType("am_projet_desc", "textarea");
            $form->setType("am_terr_surf", "text");
            $form->setType("am_tranche_desc", "textarea");
            $form->setType("am_lot_max_nb", "text");
            $form->setType("am_lot_max_shon", "text");
            $form->setType("am_lot_cstr_cos", "checkbox");
            $form->setType("am_lot_cstr_plan", "checkbox");
            $form->setType("am_lot_cstr_vente", "checkbox");
            $form->setType("am_lot_fin_diff", "checkbox");
            $form->setType("am_lot_consign", "checkbox");
            $form->setType("am_lot_gar_achev", "checkbox");
            $form->setType("am_lot_vente_ant", "checkbox");
            $form->setType("am_empl_nb", "text");
            $form->setType("am_tente_nb", "text");
            $form->setType("am_carav_nb", "text");
            $form->setType("am_mobil_nb", "text");
            $form->setType("am_pers_nb", "text");
            $form->setType("am_empl_hll_nb", "text");
            $form->setType("am_hll_shon", "text");
            $form->setType("am_periode_exploit", "textarea");
            $form->setType("am_exist_agrand", "checkbox");
            $form->setType("am_exist_date", "text");
            $form->setType("am_exist_num", "text");
            $form->setType("am_exist_nb_avant", "text");
            $form->setType("am_exist_nb_apres", "text");
            $form->setType("am_coupe_bois", "checkbox");
            $form->setType("am_coupe_parc", "checkbox");
            $form->setType("am_coupe_align", "checkbox");
            $form->setType("am_coupe_ess", "text");
            $form->setType("am_coupe_age", "text");
            $form->setType("am_coupe_dens", "text");
            $form->setType("am_coupe_qual", "text");
            $form->setType("am_coupe_trait", "text");
            $form->setType("am_coupe_autr", "text");
            $form->setType("co_archi_recours", "checkbox");
            $form->setType("co_cstr_nouv", "checkbox");
            $form->setType("co_cstr_exist", "checkbox");
            $form->setType("co_cloture", "checkbox");
            $form->setType("co_elec_tension", "text");
            $form->setType("co_div_terr", "checkbox");
            $form->setType("co_projet_desc", "textarea");
            $form->setType("co_anx_pisc", "checkbox");
            $form->setType("co_anx_gara", "checkbox");
            $form->setType("co_anx_veran", "checkbox");
            $form->setType("co_anx_abri", "checkbox");
            $form->setType("co_anx_autr", "checkbox");
            $form->setType("co_anx_autr_desc", "textarea");
            $form->setType("co_tot_log_nb", "text");
            $form->setType("co_tot_ind_nb", "text");
            $form->setType("co_tot_coll_nb", "text");
            $form->setType("co_mais_piece_nb", "text");
            $form->setType("co_mais_niv_nb", "text");
            $form->setType("co_fin_lls_nb", "text");
            $form->setType("co_fin_aa_nb", "text");
            $form->setType("co_fin_ptz_nb", "text");
            $form->setType("co_fin_autr_nb", "text");
            $form->setType("co_fin_autr_desc", "textarea");
            $form->setType("co_mais_contrat_ind", "checkbox");
            $form->setType("co_uti_pers", "checkbox");
            $form->setType("co_uti_vente", "checkbox");
            $form->setType("co_uti_loc", "checkbox");
            $form->setType("co_uti_princ", "checkbox");
            $form->setType("co_uti_secon", "checkbox");
            $form->setType("co_resid_agees", "checkbox");
            $form->setType("co_resid_etud", "checkbox");
            $form->setType("co_resid_tourism", "checkbox");
            $form->setType("co_resid_hot_soc", "checkbox");
            $form->setType("co_resid_soc", "checkbox");
            $form->setType("co_resid_hand", "checkbox");
            $form->setType("co_resid_autr", "checkbox");
            $form->setType("co_resid_autr_desc", "textarea");
            $form->setType("co_foyer_chamb_nb", "text");
            $form->setType("co_log_1p_nb", "text");
            $form->setType("co_log_2p_nb", "text");
            $form->setType("co_log_3p_nb", "text");
            $form->setType("co_log_4p_nb", "text");
            $form->setType("co_log_5p_nb", "text");
            $form->setType("co_log_6p_nb", "text");
            $form->setType("co_bat_niv_nb", "text");
            $form->setType("co_trx_exten", "checkbox");
            $form->setType("co_trx_surelev", "checkbox");
            $form->setType("co_trx_nivsup", "checkbox");
            $form->setType("co_demont_periode", "textarea");
            $form->setType("co_sp_transport", "checkbox");
            $form->setType("co_sp_enseign", "checkbox");
            $form->setType("co_sp_act_soc", "checkbox");
            $form->setType("co_sp_ouvr_spe", "checkbox");
            $form->setType("co_sp_sante", "checkbox");
            $form->setType("co_sp_culture", "checkbox");
            $form->setType("co_statio_avt_nb", "text");
            $form->setType("co_statio_apr_nb", "text");
            $form->setType("co_statio_adr", "textarea");
            $form->setType("co_statio_place_nb", "text");
            $form->setType("co_statio_tot_surf", "text");
            $form->setType("co_statio_tot_shob", "text");
            $form->setType("co_statio_comm_cin_surf", "text");
            $form->setType("su_avt_shon1", "text");
            $form->setType("su_avt_shon2", "text");
            $form->setType("su_avt_shon3", "text");
            $form->setType("su_avt_shon4", "text");
            $form->setType("su_avt_shon5", "text");
            $form->setType("su_avt_shon6", "text");
            $form->setType("su_avt_shon7", "text");
            $form->setType("su_avt_shon8", "text");
            $form->setType("su_avt_shon9", "text");
            $form->setType("su_cstr_shon1", "text");
            $form->setType("su_cstr_shon2", "text");
            $form->setType("su_cstr_shon3", "text");
            $form->setType("su_cstr_shon4", "text");
            $form->setType("su_cstr_shon5", "text");
            $form->setType("su_cstr_shon6", "text");
            $form->setType("su_cstr_shon7", "text");
            $form->setType("su_cstr_shon8", "text");
            $form->setType("su_cstr_shon9", "text");
            $form->setType("su_trsf_shon1", "text");
            $form->setType("su_trsf_shon2", "text");
            $form->setType("su_trsf_shon3", "text");
            $form->setType("su_trsf_shon4", "text");
            $form->setType("su_trsf_shon5", "text");
            $form->setType("su_trsf_shon6", "text");
            $form->setType("su_trsf_shon7", "text");
            $form->setType("su_trsf_shon8", "text");
            $form->setType("su_trsf_shon9", "text");
            $form->setType("su_chge_shon1", "text");
            $form->setType("su_chge_shon2", "text");
            $form->setType("su_chge_shon3", "text");
            $form->setType("su_chge_shon4", "text");
            $form->setType("su_chge_shon5", "text");
            $form->setType("su_chge_shon6", "text");
            $form->setType("su_chge_shon7", "text");
            $form->setType("su_chge_shon8", "text");
            $form->setType("su_chge_shon9", "text");
            $form->setType("su_demo_shon1", "text");
            $form->setType("su_demo_shon2", "text");
            $form->setType("su_demo_shon3", "text");
            $form->setType("su_demo_shon4", "text");
            $form->setType("su_demo_shon5", "text");
            $form->setType("su_demo_shon6", "text");
            $form->setType("su_demo_shon7", "text");
            $form->setType("su_demo_shon8", "text");
            $form->setType("su_demo_shon9", "text");
            $form->setType("su_sup_shon1", "text");
            $form->setType("su_sup_shon2", "text");
            $form->setType("su_sup_shon3", "text");
            $form->setType("su_sup_shon4", "text");
            $form->setType("su_sup_shon5", "text");
            $form->setType("su_sup_shon6", "text");
            $form->setType("su_sup_shon7", "text");
            $form->setType("su_sup_shon8", "text");
            $form->setType("su_sup_shon9", "text");
            $form->setType("su_tot_shon1", "text");
            $form->setType("su_tot_shon2", "text");
            $form->setType("su_tot_shon3", "text");
            $form->setType("su_tot_shon4", "text");
            $form->setType("su_tot_shon5", "text");
            $form->setType("su_tot_shon6", "text");
            $form->setType("su_tot_shon7", "text");
            $form->setType("su_tot_shon8", "text");
            $form->setType("su_tot_shon9", "text");
            $form->setType("su_avt_shon_tot", "text");
            $form->setType("su_cstr_shon_tot", "text");
            $form->setType("su_trsf_shon_tot", "text");
            $form->setType("su_chge_shon_tot", "text");
            $form->setType("su_demo_shon_tot", "text");
            $form->setType("su_sup_shon_tot", "text");
            $form->setType("su_tot_shon_tot", "text");
            $form->setType("dm_constr_dates", "textarea");
            $form->setType("dm_total", "checkbox");
            $form->setType("dm_partiel", "checkbox");
            $form->setType("dm_projet_desc", "textarea");
            $form->setType("dm_tot_log_nb", "text");
            $form->setType("tax_surf_tot", "text");
            $form->setType("tax_surf", "text");
            $form->setType("tax_surf_suppr_mod", "text");
            $form->setType("tax_su_princ_log_nb1", "text");
            $form->setType("tax_su_princ_log_nb2", "text");
            $form->setType("tax_su_princ_log_nb3", "text");
            $form->setType("tax_su_princ_log_nb4", "text");
            $form->setType("tax_su_princ_log_nb_tot1", "text");
            $form->setType("tax_su_princ_log_nb_tot2", "text");
            $form->setType("tax_su_princ_log_nb_tot3", "text");
            $form->setType("tax_su_princ_log_nb_tot4", "text");
            $form->setType("tax_su_princ_surf1", "text");
            $form->setType("tax_su_princ_surf2", "text");
            $form->setType("tax_su_princ_surf3", "text");
            $form->setType("tax_su_princ_surf4", "text");
            $form->setType("tax_su_princ_surf_sup1", "text");
            $form->setType("tax_su_princ_surf_sup2", "text");
            $form->setType("tax_su_princ_surf_sup3", "text");
            $form->setType("tax_su_princ_surf_sup4", "text");
            $form->setType("tax_su_heber_log_nb1", "text");
            $form->setType("tax_su_heber_log_nb2", "text");
            $form->setType("tax_su_heber_log_nb3", "text");
            $form->setType("tax_su_heber_log_nb_tot1", "text");
            $form->setType("tax_su_heber_log_nb_tot2", "text");
            $form->setType("tax_su_heber_log_nb_tot3", "text");
            $form->setType("tax_su_heber_surf1", "text");
            $form->setType("tax_su_heber_surf2", "text");
            $form->setType("tax_su_heber_surf3", "text");
            $form->setType("tax_su_heber_surf_sup1", "text");
            $form->setType("tax_su_heber_surf_sup2", "text");
            $form->setType("tax_su_heber_surf_sup3", "text");
            $form->setType("tax_su_secon_log_nb", "text");
            $form->setType("tax_su_tot_log_nb", "text");
            $form->setType("tax_su_secon_log_nb_tot", "text");
            $form->setType("tax_su_tot_log_nb_tot", "text");
            $form->setType("tax_su_secon_surf", "text");
            $form->setType("tax_su_tot_surf", "text");
            $form->setType("tax_su_secon_surf_sup", "text");
            $form->setType("tax_su_tot_surf_sup", "text");
            $form->setType("tax_ext_pret", "checkbox");
            $form->setType("tax_ext_desc", "textarea");
            $form->setType("tax_surf_tax_exist_cons", "text");
            $form->setType("tax_log_exist_nb", "text");
            $form->setType("tax_am_statio_ext", "text");
            $form->setType("tax_sup_bass_pisc", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb", "text");
            $form->setType("tax_empl_hll_nb", "text");
            $form->setType("tax_eol_haut_nb", "text");
            $form->setType("tax_pann_volt_sup", "text");
            $form->setType("tax_am_statio_ext_sup", "text");
            $form->setType("tax_sup_bass_pisc_sup", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb_sup", "text");
            $form->setType("tax_empl_hll_nb_sup", "text");
            $form->setType("tax_eol_haut_nb_sup", "text");
            $form->setType("tax_pann_volt_sup_sup", "text");
            $form->setType("tax_trx_presc_ppr", "checkbox");
            $form->setType("tax_monu_hist", "checkbox");
            $form->setType("tax_comm_nb", "text");
            $form->setType("tax_su_non_habit_surf1", "text");
            $form->setType("tax_su_non_habit_surf2", "text");
            $form->setType("tax_su_non_habit_surf3", "text");
            $form->setType("tax_su_non_habit_surf4", "text");
            $form->setType("tax_su_non_habit_surf5", "text");
            $form->setType("tax_su_non_habit_surf6", "text");
            $form->setType("tax_su_non_habit_surf7", "text");
            $form->setType("tax_su_non_habit_surf_sup1", "text");
            $form->setType("tax_su_non_habit_surf_sup2", "text");
            $form->setType("tax_su_non_habit_surf_sup3", "text");
            $form->setType("tax_su_non_habit_surf_sup4", "text");
            $form->setType("tax_su_non_habit_surf_sup5", "text");
            $form->setType("tax_su_non_habit_surf_sup6", "text");
            $form->setType("tax_su_non_habit_surf_sup7", "text");
            $form->setType("vsd_surf_planch_smd", "checkbox");
            $form->setType("vsd_unit_fonc_sup", "text");
            $form->setType("vsd_unit_fonc_constr_sup", "text");
            $form->setType("vsd_val_terr", "text");
            $form->setType("vsd_const_sxist_non_dem_surf", "text");
            $form->setType("vsd_rescr_fisc", "date");
            $form->setType("pld_val_terr", "text");
            $form->setType("pld_const_exist_dem", "checkbox");
            $form->setType("pld_const_exist_dem_surf", "text");
            $form->setType("code_cnil", "checkbox");
            $form->setType("terr_juri_titul", "text");
            $form->setType("terr_juri_lot", "text");
            $form->setType("terr_juri_zac", "text");
            $form->setType("terr_juri_afu", "text");
            $form->setType("terr_juri_pup", "text");
            $form->setType("terr_juri_oin", "text");
            $form->setType("terr_juri_desc", "textarea");
            $form->setType("terr_div_surf_etab", "text");
            $form->setType("terr_div_surf_av_div", "text");
            $form->setType("doc_date", "date");
            $form->setType("doc_tot_trav", "checkbox");
            $form->setType("doc_tranche_trav", "checkbox");
            $form->setType("doc_tranche_trav_desc", "textarea");
            $form->setType("doc_surf", "text");
            $form->setType("doc_nb_log", "text");
            $form->setType("doc_nb_log_indiv", "text");
            $form->setType("doc_nb_log_coll", "text");
            $form->setType("doc_nb_log_lls", "text");
            $form->setType("doc_nb_log_aa", "text");
            $form->setType("doc_nb_log_ptz", "text");
            $form->setType("doc_nb_log_autre", "text");
            $form->setType("daact_date", "date");
            $form->setType("daact_date_chgmt_dest", "date");
            $form->setType("daact_tot_trav", "checkbox");
            $form->setType("daact_tranche_trav", "checkbox");
            $form->setType("daact_tranche_trav_desc", "textarea");
            $form->setType("daact_surf", "text");
            $form->setType("daact_nb_log", "text");
            $form->setType("daact_nb_log_indiv", "text");
            $form->setType("daact_nb_log_coll", "text");
            $form->setType("daact_nb_log_lls", "text");
            $form->setType("daact_nb_log_aa", "text");
            $form->setType("daact_nb_log_ptz", "text");
            $form->setType("daact_nb_log_autre", "text");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            $form->setType("am_div_mun", "checkbox");
            $form->setType("co_perf_energ", "text");
            if ($this->is_in_context_of_foreign_key("architecte", $this->retourformulaire)) {
                $form->setType("architecte", "selecthiddenstatic");
            } else {
                $form->setType("architecte", "select");
            }
            $form->setType("co_statio_avt_shob", "text");
            $form->setType("co_statio_apr_shob", "text");
            $form->setType("co_statio_avt_surf", "text");
            $form->setType("co_statio_apr_surf", "text");
            $form->setType("co_trx_amgt", "text");
            $form->setType("co_modif_aspect", "text");
            $form->setType("co_modif_struct", "text");
            $form->setType("co_ouvr_elec", "checkbox");
            $form->setType("co_ouvr_infra", "checkbox");
            $form->setType("co_trx_imm", "text");
            $form->setType("co_cstr_shob", "text");
            $form->setType("am_voyage_deb", "text");
            $form->setType("am_voyage_fin", "text");
            $form->setType("am_modif_amgt", "text");
            $form->setType("am_lot_max_shob", "text");
            $form->setType("mod_desc", "text");
            $form->setType("tr_total", "text");
            $form->setType("tr_partiel", "text");
            $form->setType("tr_desc", "text");
            $form->setType("avap_co_elt_pro", "checkbox");
            $form->setType("avap_nouv_haut_surf", "checkbox");
            $form->setType("avap_co_clot", "text");
            $form->setType("avap_aut_coup_aba_arb", "text");
            $form->setType("avap_ouv_infra", "text");
            $form->setType("avap_aut_inst_mob", "text");
            $form->setType("avap_aut_plant", "text");
            $form->setType("avap_aut_auv_elec", "text");
            $form->setType("tax_dest_loc_tr", "text");
            $form->setType("ope_proj_desc", "textarea");
            $form->setType("tax_surf_tot_cstr", "text");
            $form->setType("cerfa", "text");
            $form->setType("tax_surf_loc_stat", "text");
            $form->setType("tax_su_princ_surf_stat1", "text");
            $form->setType("tax_su_princ_surf_stat2", "text");
            $form->setType("tax_su_princ_surf_stat3", "text");
            $form->setType("tax_su_princ_surf_stat4", "text");
            $form->setType("tax_su_secon_surf_stat", "text");
            $form->setType("tax_su_heber_surf_stat1", "text");
            $form->setType("tax_su_heber_surf_stat2", "text");
            $form->setType("tax_su_heber_surf_stat3", "text");
            $form->setType("tax_su_tot_surf_stat", "text");
            $form->setType("tax_su_non_habit_surf_stat1", "text");
            $form->setType("tax_su_non_habit_surf_stat2", "text");
            $form->setType("tax_su_non_habit_surf_stat3", "text");
            $form->setType("tax_su_non_habit_surf_stat4", "text");
            $form->setType("tax_su_non_habit_surf_stat5", "text");
            $form->setType("tax_su_non_habit_surf_stat6", "text");
            $form->setType("tax_su_non_habit_surf_stat7", "text");
            $form->setType("tax_su_parc_statio_expl_comm_surf", "text");
            $form->setType("tax_log_ap_trvx_nb", "text");
            $form->setType("tax_am_statio_ext_cr", "text");
            $form->setType("tax_sup_bass_pisc_cr", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb_cr", "text");
            $form->setType("tax_empl_hll_nb_cr", "text");
            $form->setType("tax_eol_haut_nb_cr", "text");
            $form->setType("tax_pann_volt_sup_cr", "text");
            $form->setType("tax_surf_loc_arch", "text");
            $form->setType("tax_surf_pisc_arch", "text");
            $form->setType("tax_am_statio_ext_arch", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb_arch", "text");
            $form->setType("tax_empl_hll_nb_arch", "text");
            $form->setType("tax_eol_haut_nb_arch", "text");
            $form->setType("ope_proj_div_co", "checkbox");
            $form->setType("ope_proj_div_contr", "checkbox");
            $form->setType("tax_desc", "textarea");
            $form->setType("erp_cstr_neuve", "checkbox");
            $form->setType("erp_trvx_acc", "checkbox");
            $form->setType("erp_extension", "checkbox");
            $form->setType("erp_rehab", "checkbox");
            $form->setType("erp_trvx_am", "checkbox");
            $form->setType("erp_vol_nouv_exist", "checkbox");
            $form->setType("erp_loc_eff1", "text");
            $form->setType("erp_loc_eff2", "text");
            $form->setType("erp_loc_eff3", "text");
            $form->setType("erp_loc_eff4", "text");
            $form->setType("erp_loc_eff5", "text");
            $form->setType("erp_loc_eff_tot", "text");
            $form->setType("erp_public_eff1", "text");
            $form->setType("erp_public_eff2", "text");
            $form->setType("erp_public_eff3", "text");
            $form->setType("erp_public_eff4", "text");
            $form->setType("erp_public_eff5", "text");
            $form->setType("erp_public_eff_tot", "text");
            $form->setType("erp_perso_eff1", "text");
            $form->setType("erp_perso_eff2", "text");
            $form->setType("erp_perso_eff3", "text");
            $form->setType("erp_perso_eff4", "text");
            $form->setType("erp_perso_eff5", "text");
            $form->setType("erp_perso_eff_tot", "text");
            $form->setType("erp_tot_eff1", "text");
            $form->setType("erp_tot_eff2", "text");
            $form->setType("erp_tot_eff3", "text");
            $form->setType("erp_tot_eff4", "text");
            $form->setType("erp_tot_eff5", "text");
            $form->setType("erp_tot_eff_tot", "text");
            $form->setType("erp_class_cat", "text");
            $form->setType("erp_class_type", "text");
            $form->setType("tax_surf_abr_jard_pig_colom", "text");
            $form->setType("tax_su_non_habit_abr_jard_pig_colom", "text");
            $form->setType("dia_imm_non_bati", "checkbox");
            $form->setType("dia_imm_bati_terr_propr", "checkbox");
            $form->setType("dia_imm_bati_terr_autr", "checkbox");
            $form->setType("dia_imm_bati_terr_autr_desc", "textarea");
            $form->setType("dia_bat_copro", "checkbox");
            $form->setType("dia_bat_copro_desc", "textarea");
            $form->setType("dia_lot_numero", "textarea");
            $form->setType("dia_lot_bat", "textarea");
            $form->setType("dia_lot_etage", "textarea");
            $form->setType("dia_lot_quote_part", "textarea");
            $form->setType("dia_us_hab", "checkbox");
            $form->setType("dia_us_pro", "checkbox");
            $form->setType("dia_us_mixte", "checkbox");
            $form->setType("dia_us_comm", "checkbox");
            $form->setType("dia_us_agr", "checkbox");
            $form->setType("dia_us_autre", "checkbox");
            $form->setType("dia_us_autre_prec", "textarea");
            $form->setType("dia_occ_prop", "checkbox");
            $form->setType("dia_occ_loc", "checkbox");
            $form->setType("dia_occ_sans_occ", "checkbox");
            $form->setType("dia_occ_autre", "checkbox");
            $form->setType("dia_occ_autre_prec", "textarea");
            $form->setType("dia_mod_cess_prix_vente", "text");
            $form->setType("dia_mod_cess_prix_vente_mob", "text");
            $form->setType("dia_mod_cess_prix_vente_cheptel", "text");
            $form->setType("dia_mod_cess_prix_vente_recol", "text");
            $form->setType("dia_mod_cess_prix_vente_autre", "text");
            $form->setType("dia_mod_cess_commi", "checkbox");
            $form->setType("dia_mod_cess_commi_ttc", "text");
            $form->setType("dia_mod_cess_commi_ht", "text");
            $form->setType("dia_acquereur_nom_prenom", "text");
            $form->setType("dia_acquereur_adr_num_voie", "text");
            $form->setType("dia_acquereur_adr_ext", "text");
            $form->setType("dia_acquereur_adr_type_voie", "text");
            $form->setType("dia_acquereur_adr_nom_voie", "text");
            $form->setType("dia_acquereur_adr_lieu_dit_bp", "text");
            $form->setType("dia_acquereur_adr_cp", "text");
            $form->setType("dia_acquereur_adr_localite", "text");
            $form->setType("dia_observation", "textarea");
            $form->setType("su2_avt_shon1", "text");
            $form->setType("su2_avt_shon2", "text");
            $form->setType("su2_avt_shon3", "text");
            $form->setType("su2_avt_shon4", "text");
            $form->setType("su2_avt_shon5", "text");
            $form->setType("su2_avt_shon6", "text");
            $form->setType("su2_avt_shon7", "text");
            $form->setType("su2_avt_shon8", "text");
            $form->setType("su2_avt_shon9", "text");
            $form->setType("su2_avt_shon10", "text");
            $form->setType("su2_avt_shon11", "text");
            $form->setType("su2_avt_shon12", "text");
            $form->setType("su2_avt_shon13", "text");
            $form->setType("su2_avt_shon14", "text");
            $form->setType("su2_avt_shon15", "text");
            $form->setType("su2_avt_shon16", "text");
            $form->setType("su2_avt_shon17", "text");
            $form->setType("su2_avt_shon18", "text");
            $form->setType("su2_avt_shon19", "text");
            $form->setType("su2_avt_shon20", "text");
            $form->setType("su2_avt_shon_tot", "text");
            $form->setType("su2_cstr_shon1", "text");
            $form->setType("su2_cstr_shon2", "text");
            $form->setType("su2_cstr_shon3", "text");
            $form->setType("su2_cstr_shon4", "text");
            $form->setType("su2_cstr_shon5", "text");
            $form->setType("su2_cstr_shon6", "text");
            $form->setType("su2_cstr_shon7", "text");
            $form->setType("su2_cstr_shon8", "text");
            $form->setType("su2_cstr_shon9", "text");
            $form->setType("su2_cstr_shon10", "text");
            $form->setType("su2_cstr_shon11", "text");
            $form->setType("su2_cstr_shon12", "text");
            $form->setType("su2_cstr_shon13", "text");
            $form->setType("su2_cstr_shon14", "text");
            $form->setType("su2_cstr_shon15", "text");
            $form->setType("su2_cstr_shon16", "text");
            $form->setType("su2_cstr_shon17", "text");
            $form->setType("su2_cstr_shon18", "text");
            $form->setType("su2_cstr_shon19", "text");
            $form->setType("su2_cstr_shon20", "text");
            $form->setType("su2_cstr_shon_tot", "text");
            $form->setType("su2_chge_shon1", "text");
            $form->setType("su2_chge_shon2", "text");
            $form->setType("su2_chge_shon3", "text");
            $form->setType("su2_chge_shon4", "text");
            $form->setType("su2_chge_shon5", "text");
            $form->setType("su2_chge_shon6", "text");
            $form->setType("su2_chge_shon7", "text");
            $form->setType("su2_chge_shon8", "text");
            $form->setType("su2_chge_shon9", "text");
            $form->setType("su2_chge_shon10", "text");
            $form->setType("su2_chge_shon11", "text");
            $form->setType("su2_chge_shon12", "text");
            $form->setType("su2_chge_shon13", "text");
            $form->setType("su2_chge_shon14", "text");
            $form->setType("su2_chge_shon15", "text");
            $form->setType("su2_chge_shon16", "text");
            $form->setType("su2_chge_shon17", "text");
            $form->setType("su2_chge_shon18", "text");
            $form->setType("su2_chge_shon19", "text");
            $form->setType("su2_chge_shon20", "text");
            $form->setType("su2_chge_shon_tot", "text");
            $form->setType("su2_demo_shon1", "text");
            $form->setType("su2_demo_shon2", "text");
            $form->setType("su2_demo_shon3", "text");
            $form->setType("su2_demo_shon4", "text");
            $form->setType("su2_demo_shon5", "text");
            $form->setType("su2_demo_shon6", "text");
            $form->setType("su2_demo_shon7", "text");
            $form->setType("su2_demo_shon8", "text");
            $form->setType("su2_demo_shon9", "text");
            $form->setType("su2_demo_shon10", "text");
            $form->setType("su2_demo_shon11", "text");
            $form->setType("su2_demo_shon12", "text");
            $form->setType("su2_demo_shon13", "text");
            $form->setType("su2_demo_shon14", "text");
            $form->setType("su2_demo_shon15", "text");
            $form->setType("su2_demo_shon16", "text");
            $form->setType("su2_demo_shon17", "text");
            $form->setType("su2_demo_shon18", "text");
            $form->setType("su2_demo_shon19", "text");
            $form->setType("su2_demo_shon20", "text");
            $form->setType("su2_demo_shon_tot", "text");
            $form->setType("su2_sup_shon1", "text");
            $form->setType("su2_sup_shon2", "text");
            $form->setType("su2_sup_shon3", "text");
            $form->setType("su2_sup_shon4", "text");
            $form->setType("su2_sup_shon5", "text");
            $form->setType("su2_sup_shon6", "text");
            $form->setType("su2_sup_shon7", "text");
            $form->setType("su2_sup_shon8", "text");
            $form->setType("su2_sup_shon9", "text");
            $form->setType("su2_sup_shon10", "text");
            $form->setType("su2_sup_shon11", "text");
            $form->setType("su2_sup_shon12", "text");
            $form->setType("su2_sup_shon13", "text");
            $form->setType("su2_sup_shon14", "text");
            $form->setType("su2_sup_shon15", "text");
            $form->setType("su2_sup_shon16", "text");
            $form->setType("su2_sup_shon17", "text");
            $form->setType("su2_sup_shon18", "text");
            $form->setType("su2_sup_shon19", "text");
            $form->setType("su2_sup_shon20", "text");
            $form->setType("su2_sup_shon_tot", "text");
            $form->setType("su2_tot_shon1", "text");
            $form->setType("su2_tot_shon2", "text");
            $form->setType("su2_tot_shon3", "text");
            $form->setType("su2_tot_shon4", "text");
            $form->setType("su2_tot_shon5", "text");
            $form->setType("su2_tot_shon6", "text");
            $form->setType("su2_tot_shon7", "text");
            $form->setType("su2_tot_shon8", "text");
            $form->setType("su2_tot_shon9", "text");
            $form->setType("su2_tot_shon10", "text");
            $form->setType("su2_tot_shon11", "text");
            $form->setType("su2_tot_shon12", "text");
            $form->setType("su2_tot_shon13", "text");
            $form->setType("su2_tot_shon14", "text");
            $form->setType("su2_tot_shon15", "text");
            $form->setType("su2_tot_shon16", "text");
            $form->setType("su2_tot_shon17", "text");
            $form->setType("su2_tot_shon18", "text");
            $form->setType("su2_tot_shon19", "text");
            $form->setType("su2_tot_shon20", "text");
            $form->setType("su2_tot_shon_tot", "text");
            $form->setType("dia_occ_sol_su_terre", "textarea");
            $form->setType("dia_occ_sol_su_pres", "textarea");
            $form->setType("dia_occ_sol_su_verger", "textarea");
            $form->setType("dia_occ_sol_su_vigne", "textarea");
            $form->setType("dia_occ_sol_su_bois", "textarea");
            $form->setType("dia_occ_sol_su_lande", "textarea");
            $form->setType("dia_occ_sol_su_carriere", "textarea");
            $form->setType("dia_occ_sol_su_eau_cadastree", "textarea");
            $form->setType("dia_occ_sol_su_jardin", "textarea");
            $form->setType("dia_occ_sol_su_terr_batir", "textarea");
            $form->setType("dia_occ_sol_su_terr_agr", "textarea");
            $form->setType("dia_occ_sol_su_sol", "textarea");
            $form->setType("dia_bati_vend_tot", "checkbox");
            $form->setType("dia_bati_vend_tot_txt", "textarea");
            $form->setType("dia_su_co_sol", "textarea");
            $form->setType("dia_su_util_hab", "textarea");
            $form->setType("dia_nb_niv", "textarea");
            $form->setType("dia_nb_appart", "textarea");
            $form->setType("dia_nb_autre_loc", "textarea");
            $form->setType("dia_vente_lot_volume", "checkbox");
            $form->setType("dia_vente_lot_volume_txt", "textarea");
            $form->setType("dia_lot_nat_su", "textarea");
            $form->setType("dia_lot_bat_achv_plus_10", "checkbox");
            $form->setType("dia_lot_bat_achv_moins_10", "checkbox");
            $form->setType("dia_lot_regl_copro_publ_hypo_plus_10", "checkbox");
            $form->setType("dia_lot_regl_copro_publ_hypo_moins_10", "checkbox");
            $form->setType("dia_indivi_quote_part", "textarea");
            $form->setType("dia_design_societe", "textarea");
            $form->setType("dia_design_droit", "textarea");
            $form->setType("dia_droit_soc_nat", "textarea");
            $form->setType("dia_droit_soc_nb", "textarea");
            $form->setType("dia_droit_soc_num_part", "textarea");
            $form->setType("dia_droit_reel_perso_grevant_bien_oui", "checkbox");
            $form->setType("dia_droit_reel_perso_grevant_bien_non", "checkbox");
            $form->setType("dia_droit_reel_perso_nat", "textarea");
            $form->setType("dia_droit_reel_perso_viag", "textarea");
            $form->setType("dia_mod_cess_adr", "textarea");
            $form->setType("dia_mod_cess_sign_act_auth", "checkbox");
            $form->setType("dia_mod_cess_terme", "checkbox");
            $form->setType("dia_mod_cess_terme_prec", "textarea");
            $form->setType("dia_mod_cess_bene_acquereur", "checkbox");
            $form->setType("dia_mod_cess_bene_vendeur", "checkbox");
            $form->setType("dia_mod_cess_paie_nat", "checkbox");
            $form->setType("dia_mod_cess_design_contr_alien", "textarea");
            $form->setType("dia_mod_cess_eval_contr", "textarea");
            $form->setType("dia_mod_cess_rente_viag", "checkbox");
            $form->setType("dia_mod_cess_mnt_an", "textarea");
            $form->setType("dia_mod_cess_mnt_compt", "textarea");
            $form->setType("dia_mod_cess_bene_rente", "textarea");
            $form->setType("dia_mod_cess_droit_usa_hab", "checkbox");
            $form->setType("dia_mod_cess_droit_usa_hab_prec", "textarea");
            $form->setType("dia_mod_cess_eval_usa_usufruit", "textarea");
            $form->setType("dia_mod_cess_vente_nue_prop", "checkbox");
            $form->setType("dia_mod_cess_vente_nue_prop_prec", "textarea");
            $form->setType("dia_mod_cess_echange", "checkbox");
            $form->setType("dia_mod_cess_design_bien_recus_ech", "textarea");
            $form->setType("dia_mod_cess_mnt_soulte", "textarea");
            $form->setType("dia_mod_cess_prop_contre_echan", "textarea");
            $form->setType("dia_mod_cess_apport_societe", "textarea");
            $form->setType("dia_mod_cess_bene", "textarea");
            $form->setType("dia_mod_cess_esti_bien", "textarea");
            $form->setType("dia_mod_cess_cess_terr_loc_co", "checkbox");
            $form->setType("dia_mod_cess_esti_terr", "textarea");
            $form->setType("dia_mod_cess_esti_loc", "textarea");
            $form->setType("dia_mod_cess_esti_imm_loca", "checkbox");
            $form->setType("dia_mod_cess_adju_vol", "checkbox");
            $form->setType("dia_mod_cess_adju_obl", "checkbox");
            $form->setType("dia_mod_cess_adju_fin_indivi", "checkbox");
            $form->setType("dia_mod_cess_adju_date_lieu", "textarea");
            $form->setType("dia_mod_cess_mnt_mise_prix", "textarea");
            $form->setType("dia_prop_titu_prix_indique", "checkbox");
            $form->setType("dia_prop_recherche_acqu_prix_indique", "checkbox");
            $form->setType("dia_acquereur_prof", "textarea");
            $form->setType("dia_indic_compl_ope", "textarea");
            $form->setType("dia_vente_adju", "checkbox");
            $form->setType("am_terr_res_demon", "checkbox");
            $form->setType("am_air_terr_res_mob", "checkbox");
            if ($this->is_in_context_of_foreign_key("objet_recours", $this->retourformulaire)) {
                $form->setType("ctx_objet_recours", "selecthiddenstatic");
            } else {
                $form->setType("ctx_objet_recours", "select");
            }
            $form->setType("ctx_reference_sagace", "text");
            $form->setType("ctx_nature_travaux_infra_om_html", "html");
            $form->setType("ctx_synthese_nti", "textarea");
            $form->setType("ctx_article_non_resp_om_html", "html");
            $form->setType("ctx_synthese_anr", "textarea");
            $form->setType("ctx_reference_parquet", "text");
            $form->setType("ctx_element_taxation", "text");
            $form->setType("ctx_infraction", "checkbox");
            $form->setType("ctx_regularisable", "checkbox");
            $form->setType("ctx_reference_courrier", "text");
            $form->setType("ctx_date_audience", "date");
            $form->setType("ctx_date_ajournement", "date");
            $form->setType("exo_facul_1", "checkbox");
            $form->setType("exo_facul_2", "checkbox");
            $form->setType("exo_facul_3", "checkbox");
            $form->setType("exo_facul_4", "checkbox");
            $form->setType("exo_facul_5", "checkbox");
            $form->setType("exo_facul_6", "checkbox");
            $form->setType("exo_facul_7", "checkbox");
            $form->setType("exo_facul_8", "checkbox");
            $form->setType("exo_facul_9", "checkbox");
            $form->setType("exo_ta_1", "checkbox");
            $form->setType("exo_ta_2", "checkbox");
            $form->setType("exo_ta_3", "checkbox");
            $form->setType("exo_ta_4", "checkbox");
            $form->setType("exo_ta_5", "checkbox");
            $form->setType("exo_ta_6", "checkbox");
            $form->setType("exo_ta_7", "checkbox");
            $form->setType("exo_ta_8", "checkbox");
            $form->setType("exo_ta_9", "checkbox");
            $form->setType("exo_rap_1", "checkbox");
            $form->setType("exo_rap_2", "checkbox");
            $form->setType("exo_rap_3", "checkbox");
            $form->setType("exo_rap_4", "checkbox");
            $form->setType("exo_rap_5", "checkbox");
            $form->setType("exo_rap_6", "checkbox");
            $form->setType("exo_rap_7", "checkbox");
            $form->setType("exo_rap_8", "checkbox");
            $form->setType("mtn_exo_ta_part_commu", "text");
            $form->setType("mtn_exo_ta_part_depart", "text");
            $form->setType("mtn_exo_ta_part_reg", "text");
            $form->setType("mtn_exo_rap", "text");
            $form->setType("dpc_type", "text");
            $form->setType("dpc_desc_actv_ex", "textarea");
            $form->setType("dpc_desc_ca", "textarea");
            $form->setType("dpc_desc_aut_prec", "textarea");
            $form->setType("dpc_desig_comm_arti", "checkbox");
            $form->setType("dpc_desig_loc_hab", "checkbox");
            $form->setType("dpc_desig_loc_ann", "checkbox");
            $form->setType("dpc_desig_loc_ann_prec", "textarea");
            $form->setType("dpc_bail_comm_date", "date");
            $form->setType("dpc_bail_comm_loyer", "textarea");
            $form->setType("dpc_actv_acqu", "textarea");
            $form->setType("dpc_nb_sala_di", "textarea");
            $form->setType("dpc_nb_sala_dd", "textarea");
            $form->setType("dpc_nb_sala_tc", "textarea");
            $form->setType("dpc_nb_sala_tp", "textarea");
            $form->setType("dpc_moda_cess_vente_am", "checkbox");
            $form->setType("dpc_moda_cess_adj", "checkbox");
            $form->setType("dpc_moda_cess_prix", "textarea");
            $form->setType("dpc_moda_cess_adj_date", "date");
            $form->setType("dpc_moda_cess_adj_prec", "textarea");
            $form->setType("dpc_moda_cess_paie_comp", "checkbox");
            $form->setType("dpc_moda_cess_paie_terme", "checkbox");
            $form->setType("dpc_moda_cess_paie_terme_prec", "textarea");
            $form->setType("dpc_moda_cess_paie_nat", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien_prec", "textarea");
            $form->setType("dpc_moda_cess_paie_nat_eval", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_eval_prec", "textarea");
            $form->setType("dpc_moda_cess_paie_aut", "checkbox");
            $form->setType("dpc_moda_cess_paie_aut_prec", "textarea");
            $form->setType("dpc_ss_signe_demande_acqu", "checkbox");
            $form->setType("dpc_ss_signe_recher_trouv_acqu", "checkbox");
            $form->setType("dpc_notif_adr_prop", "checkbox");
            $form->setType("dpc_notif_adr_manda", "checkbox");
            $form->setType("dpc_obs", "textarea");
            $form->setType("co_peri_site_patri_remar", "checkbox");
            $form->setType("co_abo_monu_hist", "checkbox");
            $form->setType("co_inst_ouvr_trav_act_code_envir", "checkbox");
            $form->setType("co_trav_auto_env", "checkbox");
            $form->setType("co_derog_esp_prot", "checkbox");
            $form->setType("ctx_reference_dsj", "text");
            $form->setType("co_piscine", "checkbox");
            $form->setType("co_fin_lls", "checkbox");
            $form->setType("co_fin_aa", "checkbox");
            $form->setType("co_fin_ptz", "checkbox");
            $form->setType("co_fin_autr", "textarea");
            $form->setType("dia_ss_date", "date");
            $form->setType("dia_ss_lieu", "text");
            $form->setType("enga_decla_lieu", "text");
            $form->setType("enga_decla_date", "date");
            $form->setType("co_archi_attest_honneur", "checkbox");
            $form->setType("co_bat_niv_dessous_nb", "text");
            $form->setType("co_install_classe", "checkbox");
            $form->setType("co_derog_innov", "checkbox");
            $form->setType("co_avis_abf", "checkbox");
            $form->setType("tax_surf_tot_demo", "text");
            $form->setType("tax_surf_tax_demo", "text");
            $form->setType("tax_su_non_habit_surf8", "text");
            $form->setType("tax_su_non_habit_surf_stat8", "text");
            $form->setType("tax_su_non_habit_surf9", "text");
            $form->setType("tax_su_non_habit_surf_stat9", "text");
            $form->setType("tax_terrassement_arch", "checkbox");
            $form->setType("tax_adresse_future_numero", "text");
            $form->setType("tax_adresse_future_voie", "text");
            $form->setType("tax_adresse_future_lieudit", "text");
            $form->setType("tax_adresse_future_localite", "text");
            $form->setType("tax_adresse_future_cp", "text");
            $form->setType("tax_adresse_future_bp", "text");
            $form->setType("tax_adresse_future_cedex", "text");
            $form->setType("tax_adresse_future_pays", "text");
            $form->setType("tax_adresse_future_division", "text");
            $form->setType("co_bat_projete", "textarea");
            $form->setType("co_bat_existant", "textarea");
            $form->setType("co_bat_nature", "textarea");
            $form->setType("terr_juri_titul_date", "date");
            $form->setType("co_autre_desc", "textarea");
            $form->setType("co_trx_autre", "textarea");
            $form->setType("co_autre", "checkbox");
            $form->setType("erp_modif_facades", "checkbox");
            $form->setType("erp_trvx_adap", "checkbox");
            $form->setType("erp_trvx_adap_numero", "text");
            $form->setType("erp_trvx_adap_valid", "date");
            $form->setType("erp_prod_dangereux", "checkbox");
            $form->setType("co_trav_supp_dessus", "text");
            $form->setType("co_trav_supp_dessous", "text");
            $form->setType("tax_su_habit_abr_jard_pig_colom", "text");
            $form->setType("enga_decla_donnees_nomi_comm", "checkbox");
            $form->setType("x1l_legislation", "checkbox");
            $form->setType("x1p_precisions", "text");
            $form->setType("x1u_raccordement", "checkbox");
            $form->setType("x2m_inscritmh", "checkbox");
            $form->setType("s1na1_numero", "text");
            $form->setType("s1va1_voie", "text");
            $form->setType("s1wa1_lieudit", "text");
            $form->setType("s1la1_localite", "text");
            $form->setType("s1pa1_codepostal", "text");
            $form->setType("s1na2_numero", "text");
            $form->setType("s1va2_voie", "text");
            $form->setType("s1wa2_lieudit", "text");
            $form->setType("s1la2_localite", "text");
            $form->setType("s1pa2_codepostal", "text");
            $form->setType("e3c_certification", "checkbox");
            $form->setType("e3a_competence", "checkbox");
            $form->setType("a4d_description", "text");
            $form->setType("m2b_abf", "checkbox");
            $form->setType("m2j_pn", "checkbox");
            $form->setType("m2r_cdac", "checkbox");
            $form->setType("m2r_cnac", "checkbox");
            $form->setType("u3a_voirieoui", "checkbox");
            $form->setType("u3f_voirienon", "checkbox");
            $form->setType("u3c_eauoui", "checkbox");
            $form->setType("u3h_eaunon", "checkbox");
            $form->setType("u3g_assainissementoui", "checkbox");
            $form->setType("u3n_assainissementnon", "checkbox");
            $form->setType("u3m_electriciteoui", "checkbox");
            $form->setType("u3b_electricitenon", "checkbox");
            $form->setType("u3t_observations", "text");
            $form->setType("u1a_voirieoui", "checkbox");
            $form->setType("u1v_voirienon", "checkbox");
            $form->setType("u1q_voirieconcessionnaire", "text");
            $form->setType("u1b_voirieavant", "date");
            $form->setType("u1j_eauoui", "checkbox");
            $form->setType("u1t_eaunon", "checkbox");
            $form->setType("u1e_eauconcessionnaire", "text");
            $form->setType("u1k_eauavant", "date");
            $form->setType("u1s_assainissementoui", "checkbox");
            $form->setType("u1d_assainissementnon", "checkbox");
            $form->setType("u1l_assainissementconcessionnaire", "text");
            $form->setType("u1r_assainissementavant", "date");
            $form->setType("u1c_electriciteoui", "checkbox");
            $form->setType("u1u_electricitenon", "checkbox");
            $form->setType("u1m_electriciteconcessionnaire", "text");
            $form->setType("u1f_electriciteavant", "date");
            $form->setType("u2a_observations", "text");
            $form->setType("f1ts4_surftaxestation", "text");
            $form->setType("f1ut1_surfcree", "text");
            $form->setType("f9d_date", "date");
            $form->setType("f9n_nom", "text");
            $form->setType("su2_avt_shon21", "text");
            $form->setType("su2_avt_shon22", "text");
            $form->setType("su2_cstr_shon21", "text");
            $form->setType("su2_cstr_shon22", "text");
            $form->setType("su2_chge_shon21", "text");
            $form->setType("su2_chge_shon22", "text");
            $form->setType("su2_demo_shon21", "text");
            $form->setType("su2_demo_shon22", "text");
            $form->setType("su2_sup_shon21", "text");
            $form->setType("su2_sup_shon22", "text");
            $form->setType("su2_tot_shon21", "text");
            $form->setType("su2_tot_shon22", "text");
            $form->setType("f1gu1_f1gu2_f1gu3", "text");
            $form->setType("f1lu1_f1lu2_f1lu3", "text");
            $form->setType("f1zu1_f1zu2_f1zu3", "text");
            $form->setType("f1pu1_f1pu2_f1pu3", "text");
            $form->setType("f1gt4_f1gt5_f1gt6", "text");
            $form->setType("f1lt4_f1lt5_f1lt6", "text");
            $form->setType("f1zt4_f1zt5_f1zt6", "text");
            $form->setType("f1pt4_f1pt5_f1pt6", "text");
            $form->setType("f1xu1_f1xu2_f1xu3", "text");
            $form->setType("f1xt4_f1xt5_f1xt6", "text");
            $form->setType("f1hu1_f1hu2_f1hu3", "text");
            $form->setType("f1mu1_f1mu2_f1mu3", "text");
            $form->setType("f1qu1_f1qu2_f1qu3", "text");
            $form->setType("f1ht4_f1ht5_f1ht6", "text");
            $form->setType("f1mt4_f1mt5_f1mt6", "text");
            $form->setType("f1qt4_f1qt5_f1qt6", "text");
            $form->setType("f2cu1_f2cu2_f2cu3", "text");
            $form->setType("f2bu1_f2bu2_f2bu3", "text");
            $form->setType("f2su1_f2su2_f2su3", "text");
            $form->setType("f2hu1_f2hu2_f2hu3", "text");
            $form->setType("f2eu1_f2eu2_f2eu3", "text");
            $form->setType("f2qu1_f2qu2_f2qu3", "text");
            $form->setType("f2ct4_f2ct5_f2ct6", "text");
            $form->setType("f2bt4_f2bt5_f2bt6", "text");
            $form->setType("f2st4_f2st5_f2st6", "text");
            $form->setType("f2ht4_f2ht5_f2ht6", "text");
            $form->setType("f2et4_f2et5_f2et6", "text");
            $form->setType("f2qt4_f2qt5_f2qt6", "text");
            $form->setType("dia_droit_reel_perso_grevant_bien_desc", "textarea");
            $form->setType("dia_mod_cess_paie_nat_desc", "textarea");
            $form->setType("dia_mod_cess_rente_viag_desc", "textarea");
            $form->setType("dia_mod_cess_echange_desc", "textarea");
            $form->setType("dia_mod_cess_apport_societe_desc", "textarea");
            $form->setType("dia_mod_cess_cess_terr_loc_co_desc", "textarea");
            $form->setType("dia_mod_cess_esti_imm_loca_desc", "textarea");
            $form->setType("dia_mod_cess_adju_obl_desc", "textarea");
            $form->setType("dia_mod_cess_adju_fin_indivi_desc", "textarea");
            $form->setType("dia_cadre_titul_droit_prempt", "textarea");
            $form->setType("dia_mairie_prix_moyen", "text");
            $form->setType("dia_propri_indivi", "textarea");
            $form->setType("dia_situa_bien_plan_cadas_oui", "checkbox");
            $form->setType("dia_situa_bien_plan_cadas_non", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_prop", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_prop_desc", "textarea");
            $form->setType("dia_notif_dec_titul_adr_manda", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_manda_desc", "textarea");
            $form->setType("dia_dia_dpu", "checkbox");
            $form->setType("dia_dia_zad", "checkbox");
            $form->setType("dia_dia_zone_preempt_esp_natu_sensi", "checkbox");
            $form->setType("dia_dab_dpu", "checkbox");
            $form->setType("dia_dab_zad", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt", "text");
            $form->setType("dia_mod_cess_commi_mnt_ttc", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt_ht", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_num", "text");
            $form->setType("dia_mod_cess_prix_vente_mob_num", "text");
            $form->setType("dia_mod_cess_prix_vente_cheptel_num", "text");
            $form->setType("dia_mod_cess_prix_vente_recol_num", "text");
            $form->setType("dia_mod_cess_prix_vente_autre_num", "text");
            $form->setType("dia_su_co_sol_num", "text");
            $form->setType("dia_su_util_hab_num", "text");
            $form->setType("dia_mod_cess_mnt_an_num", "text");
            $form->setType("dia_mod_cess_mnt_compt_num", "text");
            $form->setType("dia_mod_cess_mnt_soulte_num", "text");
            $form->setType("dia_comp_prix_vente", "text");
            $form->setType("dia_comp_surface", "text");
            $form->setType("dia_comp_total_frais", "text");
            $form->setType("dia_comp_mtn_total", "text");
            $form->setType("dia_comp_valeur_m2", "text");
            $form->setType("dia_esti_prix_france_dom", "text");
            $form->setType("dia_prop_collectivite", "text");
            $form->setType("dia_delegataire_denomination", "text");
            $form->setType("dia_delegataire_raison_sociale", "text");
            $form->setType("dia_delegataire_siret", "text");
            $form->setType("dia_delegataire_categorie_juridique", "text");
            $form->setType("dia_delegataire_representant_nom", "text");
            $form->setType("dia_delegataire_representant_prenom", "text");
            $form->setType("dia_delegataire_adresse_numero", "text");
            $form->setType("dia_delegataire_adresse_voie", "text");
            $form->setType("dia_delegataire_adresse_complement", "text");
            $form->setType("dia_delegataire_adresse_lieu_dit", "text");
            $form->setType("dia_delegataire_adresse_localite", "text");
            $form->setType("dia_delegataire_adresse_code_postal", "text");
            $form->setType("dia_delegataire_adresse_bp", "text");
            $form->setType("dia_delegataire_adresse_cedex", "text");
            $form->setType("dia_delegataire_adresse_pays", "text");
            $form->setType("dia_delegataire_telephone_fixe", "text");
            $form->setType("dia_delegataire_telephone_mobile", "text");
            $form->setType("dia_delegataire_telephone_mobile_indicatif", "text");
            $form->setType("dia_delegataire_courriel", "text");
            $form->setType("dia_delegataire_fax", "text");
            $form->setType("dia_entree_jouissance_type", "text");
            $form->setType("dia_entree_jouissance_date", "date");
            $form->setType("dia_entree_jouissance_date_effet", "date");
            $form->setType("dia_entree_jouissance_com", "textarea");
            $form->setType("dia_remise_bien_date_effet", "date");
            $form->setType("dia_remise_bien_com", "textarea");
            $form->setType("c2zp1_crete", "text");
            $form->setType("c2zr1_destination", "text");
            $form->setType("mh_design_appel_denom", "textarea");
            $form->setType("mh_design_type_protect", "text");
            $form->setType("mh_design_elem_prot", "textarea");
            $form->setType("mh_design_ref_merimee_palissy", "text");
            $form->setType("mh_design_nature_prop", "text");
            $form->setType("mh_loc_denom", "textarea");
            $form->setType("mh_pres_intitule", "textarea");
            $form->setType("mh_trav_cat_1", "checkbox");
            $form->setType("mh_trav_cat_2", "checkbox");
            $form->setType("mh_trav_cat_3", "checkbox");
            $form->setType("mh_trav_cat_4", "checkbox");
            $form->setType("mh_trav_cat_5", "checkbox");
            $form->setType("mh_trav_cat_6", "checkbox");
            $form->setType("mh_trav_cat_7", "checkbox");
            $form->setType("mh_trav_cat_8", "checkbox");
            $form->setType("mh_trav_cat_9", "checkbox");
            $form->setType("mh_trav_cat_10", "checkbox");
            $form->setType("mh_trav_cat_11", "checkbox");
            $form->setType("mh_trav_cat_12", "checkbox");
            $form->setType("mh_trav_cat_12_prec", "textarea");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("donnees_techniques", "hiddenstatic");
            $form->setType("dossier_instruction", "selectstatic");
            $form->setType("lot", "selectstatic");
            $form->setType("am_lotiss", "hiddenstatic");
            $form->setType("am_autre_div", "hiddenstatic");
            $form->setType("am_camping", "hiddenstatic");
            $form->setType("am_caravane", "hiddenstatic");
            $form->setType("am_carav_duree", "hiddenstatic");
            $form->setType("am_statio", "hiddenstatic");
            $form->setType("am_statio_cont", "hiddenstatic");
            $form->setType("am_affou_exhau", "hiddenstatic");
            $form->setType("am_affou_exhau_sup", "hiddenstatic");
            $form->setType("am_affou_prof", "hiddenstatic");
            $form->setType("am_exhau_haut", "hiddenstatic");
            $form->setType("am_coupe_abat", "hiddenstatic");
            $form->setType("am_prot_plu", "hiddenstatic");
            $form->setType("am_prot_muni", "hiddenstatic");
            $form->setType("am_mobil_voyage", "hiddenstatic");
            $form->setType("am_aire_voyage", "hiddenstatic");
            $form->setType("am_rememb_afu", "hiddenstatic");
            $form->setType("am_parc_resid_loi", "hiddenstatic");
            $form->setType("am_sport_moto", "hiddenstatic");
            $form->setType("am_sport_attrac", "hiddenstatic");
            $form->setType("am_sport_golf", "hiddenstatic");
            $form->setType("am_mob_art", "hiddenstatic");
            $form->setType("am_modif_voie_esp", "hiddenstatic");
            $form->setType("am_plant_voie_esp", "hiddenstatic");
            $form->setType("am_chem_ouv_esp", "hiddenstatic");
            $form->setType("am_agri_peche", "hiddenstatic");
            $form->setType("am_crea_voie", "hiddenstatic");
            $form->setType("am_modif_voie_exist", "hiddenstatic");
            $form->setType("am_crea_esp_sauv", "hiddenstatic");
            $form->setType("am_crea_esp_class", "hiddenstatic");
            $form->setType("am_projet_desc", "hiddenstatic");
            $form->setType("am_terr_surf", "hiddenstatic");
            $form->setType("am_tranche_desc", "hiddenstatic");
            $form->setType("am_lot_max_nb", "hiddenstatic");
            $form->setType("am_lot_max_shon", "hiddenstatic");
            $form->setType("am_lot_cstr_cos", "hiddenstatic");
            $form->setType("am_lot_cstr_plan", "hiddenstatic");
            $form->setType("am_lot_cstr_vente", "hiddenstatic");
            $form->setType("am_lot_fin_diff", "hiddenstatic");
            $form->setType("am_lot_consign", "hiddenstatic");
            $form->setType("am_lot_gar_achev", "hiddenstatic");
            $form->setType("am_lot_vente_ant", "hiddenstatic");
            $form->setType("am_empl_nb", "hiddenstatic");
            $form->setType("am_tente_nb", "hiddenstatic");
            $form->setType("am_carav_nb", "hiddenstatic");
            $form->setType("am_mobil_nb", "hiddenstatic");
            $form->setType("am_pers_nb", "hiddenstatic");
            $form->setType("am_empl_hll_nb", "hiddenstatic");
            $form->setType("am_hll_shon", "hiddenstatic");
            $form->setType("am_periode_exploit", "hiddenstatic");
            $form->setType("am_exist_agrand", "hiddenstatic");
            $form->setType("am_exist_date", "hiddenstatic");
            $form->setType("am_exist_num", "hiddenstatic");
            $form->setType("am_exist_nb_avant", "hiddenstatic");
            $form->setType("am_exist_nb_apres", "hiddenstatic");
            $form->setType("am_coupe_bois", "hiddenstatic");
            $form->setType("am_coupe_parc", "hiddenstatic");
            $form->setType("am_coupe_align", "hiddenstatic");
            $form->setType("am_coupe_ess", "hiddenstatic");
            $form->setType("am_coupe_age", "hiddenstatic");
            $form->setType("am_coupe_dens", "hiddenstatic");
            $form->setType("am_coupe_qual", "hiddenstatic");
            $form->setType("am_coupe_trait", "hiddenstatic");
            $form->setType("am_coupe_autr", "hiddenstatic");
            $form->setType("co_archi_recours", "hiddenstatic");
            $form->setType("co_cstr_nouv", "hiddenstatic");
            $form->setType("co_cstr_exist", "hiddenstatic");
            $form->setType("co_cloture", "hiddenstatic");
            $form->setType("co_elec_tension", "hiddenstatic");
            $form->setType("co_div_terr", "hiddenstatic");
            $form->setType("co_projet_desc", "hiddenstatic");
            $form->setType("co_anx_pisc", "hiddenstatic");
            $form->setType("co_anx_gara", "hiddenstatic");
            $form->setType("co_anx_veran", "hiddenstatic");
            $form->setType("co_anx_abri", "hiddenstatic");
            $form->setType("co_anx_autr", "hiddenstatic");
            $form->setType("co_anx_autr_desc", "hiddenstatic");
            $form->setType("co_tot_log_nb", "hiddenstatic");
            $form->setType("co_tot_ind_nb", "hiddenstatic");
            $form->setType("co_tot_coll_nb", "hiddenstatic");
            $form->setType("co_mais_piece_nb", "hiddenstatic");
            $form->setType("co_mais_niv_nb", "hiddenstatic");
            $form->setType("co_fin_lls_nb", "hiddenstatic");
            $form->setType("co_fin_aa_nb", "hiddenstatic");
            $form->setType("co_fin_ptz_nb", "hiddenstatic");
            $form->setType("co_fin_autr_nb", "hiddenstatic");
            $form->setType("co_fin_autr_desc", "hiddenstatic");
            $form->setType("co_mais_contrat_ind", "hiddenstatic");
            $form->setType("co_uti_pers", "hiddenstatic");
            $form->setType("co_uti_vente", "hiddenstatic");
            $form->setType("co_uti_loc", "hiddenstatic");
            $form->setType("co_uti_princ", "hiddenstatic");
            $form->setType("co_uti_secon", "hiddenstatic");
            $form->setType("co_resid_agees", "hiddenstatic");
            $form->setType("co_resid_etud", "hiddenstatic");
            $form->setType("co_resid_tourism", "hiddenstatic");
            $form->setType("co_resid_hot_soc", "hiddenstatic");
            $form->setType("co_resid_soc", "hiddenstatic");
            $form->setType("co_resid_hand", "hiddenstatic");
            $form->setType("co_resid_autr", "hiddenstatic");
            $form->setType("co_resid_autr_desc", "hiddenstatic");
            $form->setType("co_foyer_chamb_nb", "hiddenstatic");
            $form->setType("co_log_1p_nb", "hiddenstatic");
            $form->setType("co_log_2p_nb", "hiddenstatic");
            $form->setType("co_log_3p_nb", "hiddenstatic");
            $form->setType("co_log_4p_nb", "hiddenstatic");
            $form->setType("co_log_5p_nb", "hiddenstatic");
            $form->setType("co_log_6p_nb", "hiddenstatic");
            $form->setType("co_bat_niv_nb", "hiddenstatic");
            $form->setType("co_trx_exten", "hiddenstatic");
            $form->setType("co_trx_surelev", "hiddenstatic");
            $form->setType("co_trx_nivsup", "hiddenstatic");
            $form->setType("co_demont_periode", "hiddenstatic");
            $form->setType("co_sp_transport", "hiddenstatic");
            $form->setType("co_sp_enseign", "hiddenstatic");
            $form->setType("co_sp_act_soc", "hiddenstatic");
            $form->setType("co_sp_ouvr_spe", "hiddenstatic");
            $form->setType("co_sp_sante", "hiddenstatic");
            $form->setType("co_sp_culture", "hiddenstatic");
            $form->setType("co_statio_avt_nb", "hiddenstatic");
            $form->setType("co_statio_apr_nb", "hiddenstatic");
            $form->setType("co_statio_adr", "hiddenstatic");
            $form->setType("co_statio_place_nb", "hiddenstatic");
            $form->setType("co_statio_tot_surf", "hiddenstatic");
            $form->setType("co_statio_tot_shob", "hiddenstatic");
            $form->setType("co_statio_comm_cin_surf", "hiddenstatic");
            $form->setType("su_avt_shon1", "hiddenstatic");
            $form->setType("su_avt_shon2", "hiddenstatic");
            $form->setType("su_avt_shon3", "hiddenstatic");
            $form->setType("su_avt_shon4", "hiddenstatic");
            $form->setType("su_avt_shon5", "hiddenstatic");
            $form->setType("su_avt_shon6", "hiddenstatic");
            $form->setType("su_avt_shon7", "hiddenstatic");
            $form->setType("su_avt_shon8", "hiddenstatic");
            $form->setType("su_avt_shon9", "hiddenstatic");
            $form->setType("su_cstr_shon1", "hiddenstatic");
            $form->setType("su_cstr_shon2", "hiddenstatic");
            $form->setType("su_cstr_shon3", "hiddenstatic");
            $form->setType("su_cstr_shon4", "hiddenstatic");
            $form->setType("su_cstr_shon5", "hiddenstatic");
            $form->setType("su_cstr_shon6", "hiddenstatic");
            $form->setType("su_cstr_shon7", "hiddenstatic");
            $form->setType("su_cstr_shon8", "hiddenstatic");
            $form->setType("su_cstr_shon9", "hiddenstatic");
            $form->setType("su_trsf_shon1", "hiddenstatic");
            $form->setType("su_trsf_shon2", "hiddenstatic");
            $form->setType("su_trsf_shon3", "hiddenstatic");
            $form->setType("su_trsf_shon4", "hiddenstatic");
            $form->setType("su_trsf_shon5", "hiddenstatic");
            $form->setType("su_trsf_shon6", "hiddenstatic");
            $form->setType("su_trsf_shon7", "hiddenstatic");
            $form->setType("su_trsf_shon8", "hiddenstatic");
            $form->setType("su_trsf_shon9", "hiddenstatic");
            $form->setType("su_chge_shon1", "hiddenstatic");
            $form->setType("su_chge_shon2", "hiddenstatic");
            $form->setType("su_chge_shon3", "hiddenstatic");
            $form->setType("su_chge_shon4", "hiddenstatic");
            $form->setType("su_chge_shon5", "hiddenstatic");
            $form->setType("su_chge_shon6", "hiddenstatic");
            $form->setType("su_chge_shon7", "hiddenstatic");
            $form->setType("su_chge_shon8", "hiddenstatic");
            $form->setType("su_chge_shon9", "hiddenstatic");
            $form->setType("su_demo_shon1", "hiddenstatic");
            $form->setType("su_demo_shon2", "hiddenstatic");
            $form->setType("su_demo_shon3", "hiddenstatic");
            $form->setType("su_demo_shon4", "hiddenstatic");
            $form->setType("su_demo_shon5", "hiddenstatic");
            $form->setType("su_demo_shon6", "hiddenstatic");
            $form->setType("su_demo_shon7", "hiddenstatic");
            $form->setType("su_demo_shon8", "hiddenstatic");
            $form->setType("su_demo_shon9", "hiddenstatic");
            $form->setType("su_sup_shon1", "hiddenstatic");
            $form->setType("su_sup_shon2", "hiddenstatic");
            $form->setType("su_sup_shon3", "hiddenstatic");
            $form->setType("su_sup_shon4", "hiddenstatic");
            $form->setType("su_sup_shon5", "hiddenstatic");
            $form->setType("su_sup_shon6", "hiddenstatic");
            $form->setType("su_sup_shon7", "hiddenstatic");
            $form->setType("su_sup_shon8", "hiddenstatic");
            $form->setType("su_sup_shon9", "hiddenstatic");
            $form->setType("su_tot_shon1", "hiddenstatic");
            $form->setType("su_tot_shon2", "hiddenstatic");
            $form->setType("su_tot_shon3", "hiddenstatic");
            $form->setType("su_tot_shon4", "hiddenstatic");
            $form->setType("su_tot_shon5", "hiddenstatic");
            $form->setType("su_tot_shon6", "hiddenstatic");
            $form->setType("su_tot_shon7", "hiddenstatic");
            $form->setType("su_tot_shon8", "hiddenstatic");
            $form->setType("su_tot_shon9", "hiddenstatic");
            $form->setType("su_avt_shon_tot", "hiddenstatic");
            $form->setType("su_cstr_shon_tot", "hiddenstatic");
            $form->setType("su_trsf_shon_tot", "hiddenstatic");
            $form->setType("su_chge_shon_tot", "hiddenstatic");
            $form->setType("su_demo_shon_tot", "hiddenstatic");
            $form->setType("su_sup_shon_tot", "hiddenstatic");
            $form->setType("su_tot_shon_tot", "hiddenstatic");
            $form->setType("dm_constr_dates", "hiddenstatic");
            $form->setType("dm_total", "hiddenstatic");
            $form->setType("dm_partiel", "hiddenstatic");
            $form->setType("dm_projet_desc", "hiddenstatic");
            $form->setType("dm_tot_log_nb", "hiddenstatic");
            $form->setType("tax_surf_tot", "hiddenstatic");
            $form->setType("tax_surf", "hiddenstatic");
            $form->setType("tax_surf_suppr_mod", "hiddenstatic");
            $form->setType("tax_su_princ_log_nb1", "hiddenstatic");
            $form->setType("tax_su_princ_log_nb2", "hiddenstatic");
            $form->setType("tax_su_princ_log_nb3", "hiddenstatic");
            $form->setType("tax_su_princ_log_nb4", "hiddenstatic");
            $form->setType("tax_su_princ_log_nb_tot1", "hiddenstatic");
            $form->setType("tax_su_princ_log_nb_tot2", "hiddenstatic");
            $form->setType("tax_su_princ_log_nb_tot3", "hiddenstatic");
            $form->setType("tax_su_princ_log_nb_tot4", "hiddenstatic");
            $form->setType("tax_su_princ_surf1", "hiddenstatic");
            $form->setType("tax_su_princ_surf2", "hiddenstatic");
            $form->setType("tax_su_princ_surf3", "hiddenstatic");
            $form->setType("tax_su_princ_surf4", "hiddenstatic");
            $form->setType("tax_su_princ_surf_sup1", "hiddenstatic");
            $form->setType("tax_su_princ_surf_sup2", "hiddenstatic");
            $form->setType("tax_su_princ_surf_sup3", "hiddenstatic");
            $form->setType("tax_su_princ_surf_sup4", "hiddenstatic");
            $form->setType("tax_su_heber_log_nb1", "hiddenstatic");
            $form->setType("tax_su_heber_log_nb2", "hiddenstatic");
            $form->setType("tax_su_heber_log_nb3", "hiddenstatic");
            $form->setType("tax_su_heber_log_nb_tot1", "hiddenstatic");
            $form->setType("tax_su_heber_log_nb_tot2", "hiddenstatic");
            $form->setType("tax_su_heber_log_nb_tot3", "hiddenstatic");
            $form->setType("tax_su_heber_surf1", "hiddenstatic");
            $form->setType("tax_su_heber_surf2", "hiddenstatic");
            $form->setType("tax_su_heber_surf3", "hiddenstatic");
            $form->setType("tax_su_heber_surf_sup1", "hiddenstatic");
            $form->setType("tax_su_heber_surf_sup2", "hiddenstatic");
            $form->setType("tax_su_heber_surf_sup3", "hiddenstatic");
            $form->setType("tax_su_secon_log_nb", "hiddenstatic");
            $form->setType("tax_su_tot_log_nb", "hiddenstatic");
            $form->setType("tax_su_secon_log_nb_tot", "hiddenstatic");
            $form->setType("tax_su_tot_log_nb_tot", "hiddenstatic");
            $form->setType("tax_su_secon_surf", "hiddenstatic");
            $form->setType("tax_su_tot_surf", "hiddenstatic");
            $form->setType("tax_su_secon_surf_sup", "hiddenstatic");
            $form->setType("tax_su_tot_surf_sup", "hiddenstatic");
            $form->setType("tax_ext_pret", "hiddenstatic");
            $form->setType("tax_ext_desc", "hiddenstatic");
            $form->setType("tax_surf_tax_exist_cons", "hiddenstatic");
            $form->setType("tax_log_exist_nb", "hiddenstatic");
            $form->setType("tax_am_statio_ext", "hiddenstatic");
            $form->setType("tax_sup_bass_pisc", "hiddenstatic");
            $form->setType("tax_empl_ten_carav_mobil_nb", "hiddenstatic");
            $form->setType("tax_empl_hll_nb", "hiddenstatic");
            $form->setType("tax_eol_haut_nb", "hiddenstatic");
            $form->setType("tax_pann_volt_sup", "hiddenstatic");
            $form->setType("tax_am_statio_ext_sup", "hiddenstatic");
            $form->setType("tax_sup_bass_pisc_sup", "hiddenstatic");
            $form->setType("tax_empl_ten_carav_mobil_nb_sup", "hiddenstatic");
            $form->setType("tax_empl_hll_nb_sup", "hiddenstatic");
            $form->setType("tax_eol_haut_nb_sup", "hiddenstatic");
            $form->setType("tax_pann_volt_sup_sup", "hiddenstatic");
            $form->setType("tax_trx_presc_ppr", "hiddenstatic");
            $form->setType("tax_monu_hist", "hiddenstatic");
            $form->setType("tax_comm_nb", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf1", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf2", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf3", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf4", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf5", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf6", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf7", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_sup1", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_sup2", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_sup3", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_sup4", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_sup5", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_sup6", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_sup7", "hiddenstatic");
            $form->setType("vsd_surf_planch_smd", "hiddenstatic");
            $form->setType("vsd_unit_fonc_sup", "hiddenstatic");
            $form->setType("vsd_unit_fonc_constr_sup", "hiddenstatic");
            $form->setType("vsd_val_terr", "hiddenstatic");
            $form->setType("vsd_const_sxist_non_dem_surf", "hiddenstatic");
            $form->setType("vsd_rescr_fisc", "hiddenstatic");
            $form->setType("pld_val_terr", "hiddenstatic");
            $form->setType("pld_const_exist_dem", "hiddenstatic");
            $form->setType("pld_const_exist_dem_surf", "hiddenstatic");
            $form->setType("code_cnil", "hiddenstatic");
            $form->setType("terr_juri_titul", "hiddenstatic");
            $form->setType("terr_juri_lot", "hiddenstatic");
            $form->setType("terr_juri_zac", "hiddenstatic");
            $form->setType("terr_juri_afu", "hiddenstatic");
            $form->setType("terr_juri_pup", "hiddenstatic");
            $form->setType("terr_juri_oin", "hiddenstatic");
            $form->setType("terr_juri_desc", "hiddenstatic");
            $form->setType("terr_div_surf_etab", "hiddenstatic");
            $form->setType("terr_div_surf_av_div", "hiddenstatic");
            $form->setType("doc_date", "hiddenstatic");
            $form->setType("doc_tot_trav", "hiddenstatic");
            $form->setType("doc_tranche_trav", "hiddenstatic");
            $form->setType("doc_tranche_trav_desc", "hiddenstatic");
            $form->setType("doc_surf", "hiddenstatic");
            $form->setType("doc_nb_log", "hiddenstatic");
            $form->setType("doc_nb_log_indiv", "hiddenstatic");
            $form->setType("doc_nb_log_coll", "hiddenstatic");
            $form->setType("doc_nb_log_lls", "hiddenstatic");
            $form->setType("doc_nb_log_aa", "hiddenstatic");
            $form->setType("doc_nb_log_ptz", "hiddenstatic");
            $form->setType("doc_nb_log_autre", "hiddenstatic");
            $form->setType("daact_date", "hiddenstatic");
            $form->setType("daact_date_chgmt_dest", "hiddenstatic");
            $form->setType("daact_tot_trav", "hiddenstatic");
            $form->setType("daact_tranche_trav", "hiddenstatic");
            $form->setType("daact_tranche_trav_desc", "hiddenstatic");
            $form->setType("daact_surf", "hiddenstatic");
            $form->setType("daact_nb_log", "hiddenstatic");
            $form->setType("daact_nb_log_indiv", "hiddenstatic");
            $form->setType("daact_nb_log_coll", "hiddenstatic");
            $form->setType("daact_nb_log_lls", "hiddenstatic");
            $form->setType("daact_nb_log_aa", "hiddenstatic");
            $form->setType("daact_nb_log_ptz", "hiddenstatic");
            $form->setType("daact_nb_log_autre", "hiddenstatic");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("am_div_mun", "hiddenstatic");
            $form->setType("co_perf_energ", "hiddenstatic");
            $form->setType("architecte", "selectstatic");
            $form->setType("co_statio_avt_shob", "hiddenstatic");
            $form->setType("co_statio_apr_shob", "hiddenstatic");
            $form->setType("co_statio_avt_surf", "hiddenstatic");
            $form->setType("co_statio_apr_surf", "hiddenstatic");
            $form->setType("co_trx_amgt", "hiddenstatic");
            $form->setType("co_modif_aspect", "hiddenstatic");
            $form->setType("co_modif_struct", "hiddenstatic");
            $form->setType("co_ouvr_elec", "hiddenstatic");
            $form->setType("co_ouvr_infra", "hiddenstatic");
            $form->setType("co_trx_imm", "hiddenstatic");
            $form->setType("co_cstr_shob", "hiddenstatic");
            $form->setType("am_voyage_deb", "hiddenstatic");
            $form->setType("am_voyage_fin", "hiddenstatic");
            $form->setType("am_modif_amgt", "hiddenstatic");
            $form->setType("am_lot_max_shob", "hiddenstatic");
            $form->setType("mod_desc", "hiddenstatic");
            $form->setType("tr_total", "hiddenstatic");
            $form->setType("tr_partiel", "hiddenstatic");
            $form->setType("tr_desc", "hiddenstatic");
            $form->setType("avap_co_elt_pro", "hiddenstatic");
            $form->setType("avap_nouv_haut_surf", "hiddenstatic");
            $form->setType("avap_co_clot", "hiddenstatic");
            $form->setType("avap_aut_coup_aba_arb", "hiddenstatic");
            $form->setType("avap_ouv_infra", "hiddenstatic");
            $form->setType("avap_aut_inst_mob", "hiddenstatic");
            $form->setType("avap_aut_plant", "hiddenstatic");
            $form->setType("avap_aut_auv_elec", "hiddenstatic");
            $form->setType("tax_dest_loc_tr", "hiddenstatic");
            $form->setType("ope_proj_desc", "hiddenstatic");
            $form->setType("tax_surf_tot_cstr", "hiddenstatic");
            $form->setType("cerfa", "hiddenstatic");
            $form->setType("tax_surf_loc_stat", "hiddenstatic");
            $form->setType("tax_su_princ_surf_stat1", "hiddenstatic");
            $form->setType("tax_su_princ_surf_stat2", "hiddenstatic");
            $form->setType("tax_su_princ_surf_stat3", "hiddenstatic");
            $form->setType("tax_su_princ_surf_stat4", "hiddenstatic");
            $form->setType("tax_su_secon_surf_stat", "hiddenstatic");
            $form->setType("tax_su_heber_surf_stat1", "hiddenstatic");
            $form->setType("tax_su_heber_surf_stat2", "hiddenstatic");
            $form->setType("tax_su_heber_surf_stat3", "hiddenstatic");
            $form->setType("tax_su_tot_surf_stat", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_stat1", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_stat2", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_stat3", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_stat4", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_stat5", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_stat6", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_stat7", "hiddenstatic");
            $form->setType("tax_su_parc_statio_expl_comm_surf", "hiddenstatic");
            $form->setType("tax_log_ap_trvx_nb", "hiddenstatic");
            $form->setType("tax_am_statio_ext_cr", "hiddenstatic");
            $form->setType("tax_sup_bass_pisc_cr", "hiddenstatic");
            $form->setType("tax_empl_ten_carav_mobil_nb_cr", "hiddenstatic");
            $form->setType("tax_empl_hll_nb_cr", "hiddenstatic");
            $form->setType("tax_eol_haut_nb_cr", "hiddenstatic");
            $form->setType("tax_pann_volt_sup_cr", "hiddenstatic");
            $form->setType("tax_surf_loc_arch", "hiddenstatic");
            $form->setType("tax_surf_pisc_arch", "hiddenstatic");
            $form->setType("tax_am_statio_ext_arch", "hiddenstatic");
            $form->setType("tax_empl_ten_carav_mobil_nb_arch", "hiddenstatic");
            $form->setType("tax_empl_hll_nb_arch", "hiddenstatic");
            $form->setType("tax_eol_haut_nb_arch", "hiddenstatic");
            $form->setType("ope_proj_div_co", "hiddenstatic");
            $form->setType("ope_proj_div_contr", "hiddenstatic");
            $form->setType("tax_desc", "hiddenstatic");
            $form->setType("erp_cstr_neuve", "hiddenstatic");
            $form->setType("erp_trvx_acc", "hiddenstatic");
            $form->setType("erp_extension", "hiddenstatic");
            $form->setType("erp_rehab", "hiddenstatic");
            $form->setType("erp_trvx_am", "hiddenstatic");
            $form->setType("erp_vol_nouv_exist", "hiddenstatic");
            $form->setType("erp_loc_eff1", "hiddenstatic");
            $form->setType("erp_loc_eff2", "hiddenstatic");
            $form->setType("erp_loc_eff3", "hiddenstatic");
            $form->setType("erp_loc_eff4", "hiddenstatic");
            $form->setType("erp_loc_eff5", "hiddenstatic");
            $form->setType("erp_loc_eff_tot", "hiddenstatic");
            $form->setType("erp_public_eff1", "hiddenstatic");
            $form->setType("erp_public_eff2", "hiddenstatic");
            $form->setType("erp_public_eff3", "hiddenstatic");
            $form->setType("erp_public_eff4", "hiddenstatic");
            $form->setType("erp_public_eff5", "hiddenstatic");
            $form->setType("erp_public_eff_tot", "hiddenstatic");
            $form->setType("erp_perso_eff1", "hiddenstatic");
            $form->setType("erp_perso_eff2", "hiddenstatic");
            $form->setType("erp_perso_eff3", "hiddenstatic");
            $form->setType("erp_perso_eff4", "hiddenstatic");
            $form->setType("erp_perso_eff5", "hiddenstatic");
            $form->setType("erp_perso_eff_tot", "hiddenstatic");
            $form->setType("erp_tot_eff1", "hiddenstatic");
            $form->setType("erp_tot_eff2", "hiddenstatic");
            $form->setType("erp_tot_eff3", "hiddenstatic");
            $form->setType("erp_tot_eff4", "hiddenstatic");
            $form->setType("erp_tot_eff5", "hiddenstatic");
            $form->setType("erp_tot_eff_tot", "hiddenstatic");
            $form->setType("erp_class_cat", "hiddenstatic");
            $form->setType("erp_class_type", "hiddenstatic");
            $form->setType("tax_surf_abr_jard_pig_colom", "hiddenstatic");
            $form->setType("tax_su_non_habit_abr_jard_pig_colom", "hiddenstatic");
            $form->setType("dia_imm_non_bati", "hiddenstatic");
            $form->setType("dia_imm_bati_terr_propr", "hiddenstatic");
            $form->setType("dia_imm_bati_terr_autr", "hiddenstatic");
            $form->setType("dia_imm_bati_terr_autr_desc", "hiddenstatic");
            $form->setType("dia_bat_copro", "hiddenstatic");
            $form->setType("dia_bat_copro_desc", "hiddenstatic");
            $form->setType("dia_lot_numero", "hiddenstatic");
            $form->setType("dia_lot_bat", "hiddenstatic");
            $form->setType("dia_lot_etage", "hiddenstatic");
            $form->setType("dia_lot_quote_part", "hiddenstatic");
            $form->setType("dia_us_hab", "hiddenstatic");
            $form->setType("dia_us_pro", "hiddenstatic");
            $form->setType("dia_us_mixte", "hiddenstatic");
            $form->setType("dia_us_comm", "hiddenstatic");
            $form->setType("dia_us_agr", "hiddenstatic");
            $form->setType("dia_us_autre", "hiddenstatic");
            $form->setType("dia_us_autre_prec", "hiddenstatic");
            $form->setType("dia_occ_prop", "hiddenstatic");
            $form->setType("dia_occ_loc", "hiddenstatic");
            $form->setType("dia_occ_sans_occ", "hiddenstatic");
            $form->setType("dia_occ_autre", "hiddenstatic");
            $form->setType("dia_occ_autre_prec", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente_mob", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente_cheptel", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente_recol", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente_autre", "hiddenstatic");
            $form->setType("dia_mod_cess_commi", "hiddenstatic");
            $form->setType("dia_mod_cess_commi_ttc", "hiddenstatic");
            $form->setType("dia_mod_cess_commi_ht", "hiddenstatic");
            $form->setType("dia_acquereur_nom_prenom", "hiddenstatic");
            $form->setType("dia_acquereur_adr_num_voie", "hiddenstatic");
            $form->setType("dia_acquereur_adr_ext", "hiddenstatic");
            $form->setType("dia_acquereur_adr_type_voie", "hiddenstatic");
            $form->setType("dia_acquereur_adr_nom_voie", "hiddenstatic");
            $form->setType("dia_acquereur_adr_lieu_dit_bp", "hiddenstatic");
            $form->setType("dia_acquereur_adr_cp", "hiddenstatic");
            $form->setType("dia_acquereur_adr_localite", "hiddenstatic");
            $form->setType("dia_observation", "hiddenstatic");
            $form->setType("su2_avt_shon1", "hiddenstatic");
            $form->setType("su2_avt_shon2", "hiddenstatic");
            $form->setType("su2_avt_shon3", "hiddenstatic");
            $form->setType("su2_avt_shon4", "hiddenstatic");
            $form->setType("su2_avt_shon5", "hiddenstatic");
            $form->setType("su2_avt_shon6", "hiddenstatic");
            $form->setType("su2_avt_shon7", "hiddenstatic");
            $form->setType("su2_avt_shon8", "hiddenstatic");
            $form->setType("su2_avt_shon9", "hiddenstatic");
            $form->setType("su2_avt_shon10", "hiddenstatic");
            $form->setType("su2_avt_shon11", "hiddenstatic");
            $form->setType("su2_avt_shon12", "hiddenstatic");
            $form->setType("su2_avt_shon13", "hiddenstatic");
            $form->setType("su2_avt_shon14", "hiddenstatic");
            $form->setType("su2_avt_shon15", "hiddenstatic");
            $form->setType("su2_avt_shon16", "hiddenstatic");
            $form->setType("su2_avt_shon17", "hiddenstatic");
            $form->setType("su2_avt_shon18", "hiddenstatic");
            $form->setType("su2_avt_shon19", "hiddenstatic");
            $form->setType("su2_avt_shon20", "hiddenstatic");
            $form->setType("su2_avt_shon_tot", "hiddenstatic");
            $form->setType("su2_cstr_shon1", "hiddenstatic");
            $form->setType("su2_cstr_shon2", "hiddenstatic");
            $form->setType("su2_cstr_shon3", "hiddenstatic");
            $form->setType("su2_cstr_shon4", "hiddenstatic");
            $form->setType("su2_cstr_shon5", "hiddenstatic");
            $form->setType("su2_cstr_shon6", "hiddenstatic");
            $form->setType("su2_cstr_shon7", "hiddenstatic");
            $form->setType("su2_cstr_shon8", "hiddenstatic");
            $form->setType("su2_cstr_shon9", "hiddenstatic");
            $form->setType("su2_cstr_shon10", "hiddenstatic");
            $form->setType("su2_cstr_shon11", "hiddenstatic");
            $form->setType("su2_cstr_shon12", "hiddenstatic");
            $form->setType("su2_cstr_shon13", "hiddenstatic");
            $form->setType("su2_cstr_shon14", "hiddenstatic");
            $form->setType("su2_cstr_shon15", "hiddenstatic");
            $form->setType("su2_cstr_shon16", "hiddenstatic");
            $form->setType("su2_cstr_shon17", "hiddenstatic");
            $form->setType("su2_cstr_shon18", "hiddenstatic");
            $form->setType("su2_cstr_shon19", "hiddenstatic");
            $form->setType("su2_cstr_shon20", "hiddenstatic");
            $form->setType("su2_cstr_shon_tot", "hiddenstatic");
            $form->setType("su2_chge_shon1", "hiddenstatic");
            $form->setType("su2_chge_shon2", "hiddenstatic");
            $form->setType("su2_chge_shon3", "hiddenstatic");
            $form->setType("su2_chge_shon4", "hiddenstatic");
            $form->setType("su2_chge_shon5", "hiddenstatic");
            $form->setType("su2_chge_shon6", "hiddenstatic");
            $form->setType("su2_chge_shon7", "hiddenstatic");
            $form->setType("su2_chge_shon8", "hiddenstatic");
            $form->setType("su2_chge_shon9", "hiddenstatic");
            $form->setType("su2_chge_shon10", "hiddenstatic");
            $form->setType("su2_chge_shon11", "hiddenstatic");
            $form->setType("su2_chge_shon12", "hiddenstatic");
            $form->setType("su2_chge_shon13", "hiddenstatic");
            $form->setType("su2_chge_shon14", "hiddenstatic");
            $form->setType("su2_chge_shon15", "hiddenstatic");
            $form->setType("su2_chge_shon16", "hiddenstatic");
            $form->setType("su2_chge_shon17", "hiddenstatic");
            $form->setType("su2_chge_shon18", "hiddenstatic");
            $form->setType("su2_chge_shon19", "hiddenstatic");
            $form->setType("su2_chge_shon20", "hiddenstatic");
            $form->setType("su2_chge_shon_tot", "hiddenstatic");
            $form->setType("su2_demo_shon1", "hiddenstatic");
            $form->setType("su2_demo_shon2", "hiddenstatic");
            $form->setType("su2_demo_shon3", "hiddenstatic");
            $form->setType("su2_demo_shon4", "hiddenstatic");
            $form->setType("su2_demo_shon5", "hiddenstatic");
            $form->setType("su2_demo_shon6", "hiddenstatic");
            $form->setType("su2_demo_shon7", "hiddenstatic");
            $form->setType("su2_demo_shon8", "hiddenstatic");
            $form->setType("su2_demo_shon9", "hiddenstatic");
            $form->setType("su2_demo_shon10", "hiddenstatic");
            $form->setType("su2_demo_shon11", "hiddenstatic");
            $form->setType("su2_demo_shon12", "hiddenstatic");
            $form->setType("su2_demo_shon13", "hiddenstatic");
            $form->setType("su2_demo_shon14", "hiddenstatic");
            $form->setType("su2_demo_shon15", "hiddenstatic");
            $form->setType("su2_demo_shon16", "hiddenstatic");
            $form->setType("su2_demo_shon17", "hiddenstatic");
            $form->setType("su2_demo_shon18", "hiddenstatic");
            $form->setType("su2_demo_shon19", "hiddenstatic");
            $form->setType("su2_demo_shon20", "hiddenstatic");
            $form->setType("su2_demo_shon_tot", "hiddenstatic");
            $form->setType("su2_sup_shon1", "hiddenstatic");
            $form->setType("su2_sup_shon2", "hiddenstatic");
            $form->setType("su2_sup_shon3", "hiddenstatic");
            $form->setType("su2_sup_shon4", "hiddenstatic");
            $form->setType("su2_sup_shon5", "hiddenstatic");
            $form->setType("su2_sup_shon6", "hiddenstatic");
            $form->setType("su2_sup_shon7", "hiddenstatic");
            $form->setType("su2_sup_shon8", "hiddenstatic");
            $form->setType("su2_sup_shon9", "hiddenstatic");
            $form->setType("su2_sup_shon10", "hiddenstatic");
            $form->setType("su2_sup_shon11", "hiddenstatic");
            $form->setType("su2_sup_shon12", "hiddenstatic");
            $form->setType("su2_sup_shon13", "hiddenstatic");
            $form->setType("su2_sup_shon14", "hiddenstatic");
            $form->setType("su2_sup_shon15", "hiddenstatic");
            $form->setType("su2_sup_shon16", "hiddenstatic");
            $form->setType("su2_sup_shon17", "hiddenstatic");
            $form->setType("su2_sup_shon18", "hiddenstatic");
            $form->setType("su2_sup_shon19", "hiddenstatic");
            $form->setType("su2_sup_shon20", "hiddenstatic");
            $form->setType("su2_sup_shon_tot", "hiddenstatic");
            $form->setType("su2_tot_shon1", "hiddenstatic");
            $form->setType("su2_tot_shon2", "hiddenstatic");
            $form->setType("su2_tot_shon3", "hiddenstatic");
            $form->setType("su2_tot_shon4", "hiddenstatic");
            $form->setType("su2_tot_shon5", "hiddenstatic");
            $form->setType("su2_tot_shon6", "hiddenstatic");
            $form->setType("su2_tot_shon7", "hiddenstatic");
            $form->setType("su2_tot_shon8", "hiddenstatic");
            $form->setType("su2_tot_shon9", "hiddenstatic");
            $form->setType("su2_tot_shon10", "hiddenstatic");
            $form->setType("su2_tot_shon11", "hiddenstatic");
            $form->setType("su2_tot_shon12", "hiddenstatic");
            $form->setType("su2_tot_shon13", "hiddenstatic");
            $form->setType("su2_tot_shon14", "hiddenstatic");
            $form->setType("su2_tot_shon15", "hiddenstatic");
            $form->setType("su2_tot_shon16", "hiddenstatic");
            $form->setType("su2_tot_shon17", "hiddenstatic");
            $form->setType("su2_tot_shon18", "hiddenstatic");
            $form->setType("su2_tot_shon19", "hiddenstatic");
            $form->setType("su2_tot_shon20", "hiddenstatic");
            $form->setType("su2_tot_shon_tot", "hiddenstatic");
            $form->setType("dia_occ_sol_su_terre", "hiddenstatic");
            $form->setType("dia_occ_sol_su_pres", "hiddenstatic");
            $form->setType("dia_occ_sol_su_verger", "hiddenstatic");
            $form->setType("dia_occ_sol_su_vigne", "hiddenstatic");
            $form->setType("dia_occ_sol_su_bois", "hiddenstatic");
            $form->setType("dia_occ_sol_su_lande", "hiddenstatic");
            $form->setType("dia_occ_sol_su_carriere", "hiddenstatic");
            $form->setType("dia_occ_sol_su_eau_cadastree", "hiddenstatic");
            $form->setType("dia_occ_sol_su_jardin", "hiddenstatic");
            $form->setType("dia_occ_sol_su_terr_batir", "hiddenstatic");
            $form->setType("dia_occ_sol_su_terr_agr", "hiddenstatic");
            $form->setType("dia_occ_sol_su_sol", "hiddenstatic");
            $form->setType("dia_bati_vend_tot", "hiddenstatic");
            $form->setType("dia_bati_vend_tot_txt", "hiddenstatic");
            $form->setType("dia_su_co_sol", "hiddenstatic");
            $form->setType("dia_su_util_hab", "hiddenstatic");
            $form->setType("dia_nb_niv", "hiddenstatic");
            $form->setType("dia_nb_appart", "hiddenstatic");
            $form->setType("dia_nb_autre_loc", "hiddenstatic");
            $form->setType("dia_vente_lot_volume", "hiddenstatic");
            $form->setType("dia_vente_lot_volume_txt", "hiddenstatic");
            $form->setType("dia_lot_nat_su", "hiddenstatic");
            $form->setType("dia_lot_bat_achv_plus_10", "hiddenstatic");
            $form->setType("dia_lot_bat_achv_moins_10", "hiddenstatic");
            $form->setType("dia_lot_regl_copro_publ_hypo_plus_10", "hiddenstatic");
            $form->setType("dia_lot_regl_copro_publ_hypo_moins_10", "hiddenstatic");
            $form->setType("dia_indivi_quote_part", "hiddenstatic");
            $form->setType("dia_design_societe", "hiddenstatic");
            $form->setType("dia_design_droit", "hiddenstatic");
            $form->setType("dia_droit_soc_nat", "hiddenstatic");
            $form->setType("dia_droit_soc_nb", "hiddenstatic");
            $form->setType("dia_droit_soc_num_part", "hiddenstatic");
            $form->setType("dia_droit_reel_perso_grevant_bien_oui", "hiddenstatic");
            $form->setType("dia_droit_reel_perso_grevant_bien_non", "hiddenstatic");
            $form->setType("dia_droit_reel_perso_nat", "hiddenstatic");
            $form->setType("dia_droit_reel_perso_viag", "hiddenstatic");
            $form->setType("dia_mod_cess_adr", "hiddenstatic");
            $form->setType("dia_mod_cess_sign_act_auth", "hiddenstatic");
            $form->setType("dia_mod_cess_terme", "hiddenstatic");
            $form->setType("dia_mod_cess_terme_prec", "hiddenstatic");
            $form->setType("dia_mod_cess_bene_acquereur", "hiddenstatic");
            $form->setType("dia_mod_cess_bene_vendeur", "hiddenstatic");
            $form->setType("dia_mod_cess_paie_nat", "hiddenstatic");
            $form->setType("dia_mod_cess_design_contr_alien", "hiddenstatic");
            $form->setType("dia_mod_cess_eval_contr", "hiddenstatic");
            $form->setType("dia_mod_cess_rente_viag", "hiddenstatic");
            $form->setType("dia_mod_cess_mnt_an", "hiddenstatic");
            $form->setType("dia_mod_cess_mnt_compt", "hiddenstatic");
            $form->setType("dia_mod_cess_bene_rente", "hiddenstatic");
            $form->setType("dia_mod_cess_droit_usa_hab", "hiddenstatic");
            $form->setType("dia_mod_cess_droit_usa_hab_prec", "hiddenstatic");
            $form->setType("dia_mod_cess_eval_usa_usufruit", "hiddenstatic");
            $form->setType("dia_mod_cess_vente_nue_prop", "hiddenstatic");
            $form->setType("dia_mod_cess_vente_nue_prop_prec", "hiddenstatic");
            $form->setType("dia_mod_cess_echange", "hiddenstatic");
            $form->setType("dia_mod_cess_design_bien_recus_ech", "hiddenstatic");
            $form->setType("dia_mod_cess_mnt_soulte", "hiddenstatic");
            $form->setType("dia_mod_cess_prop_contre_echan", "hiddenstatic");
            $form->setType("dia_mod_cess_apport_societe", "hiddenstatic");
            $form->setType("dia_mod_cess_bene", "hiddenstatic");
            $form->setType("dia_mod_cess_esti_bien", "hiddenstatic");
            $form->setType("dia_mod_cess_cess_terr_loc_co", "hiddenstatic");
            $form->setType("dia_mod_cess_esti_terr", "hiddenstatic");
            $form->setType("dia_mod_cess_esti_loc", "hiddenstatic");
            $form->setType("dia_mod_cess_esti_imm_loca", "hiddenstatic");
            $form->setType("dia_mod_cess_adju_vol", "hiddenstatic");
            $form->setType("dia_mod_cess_adju_obl", "hiddenstatic");
            $form->setType("dia_mod_cess_adju_fin_indivi", "hiddenstatic");
            $form->setType("dia_mod_cess_adju_date_lieu", "hiddenstatic");
            $form->setType("dia_mod_cess_mnt_mise_prix", "hiddenstatic");
            $form->setType("dia_prop_titu_prix_indique", "hiddenstatic");
            $form->setType("dia_prop_recherche_acqu_prix_indique", "hiddenstatic");
            $form->setType("dia_acquereur_prof", "hiddenstatic");
            $form->setType("dia_indic_compl_ope", "hiddenstatic");
            $form->setType("dia_vente_adju", "hiddenstatic");
            $form->setType("am_terr_res_demon", "hiddenstatic");
            $form->setType("am_air_terr_res_mob", "hiddenstatic");
            $form->setType("ctx_objet_recours", "selectstatic");
            $form->setType("ctx_reference_sagace", "hiddenstatic");
            $form->setType("ctx_nature_travaux_infra_om_html", "hiddenstatic");
            $form->setType("ctx_synthese_nti", "hiddenstatic");
            $form->setType("ctx_article_non_resp_om_html", "hiddenstatic");
            $form->setType("ctx_synthese_anr", "hiddenstatic");
            $form->setType("ctx_reference_parquet", "hiddenstatic");
            $form->setType("ctx_element_taxation", "hiddenstatic");
            $form->setType("ctx_infraction", "hiddenstatic");
            $form->setType("ctx_regularisable", "hiddenstatic");
            $form->setType("ctx_reference_courrier", "hiddenstatic");
            $form->setType("ctx_date_audience", "hiddenstatic");
            $form->setType("ctx_date_ajournement", "hiddenstatic");
            $form->setType("exo_facul_1", "hiddenstatic");
            $form->setType("exo_facul_2", "hiddenstatic");
            $form->setType("exo_facul_3", "hiddenstatic");
            $form->setType("exo_facul_4", "hiddenstatic");
            $form->setType("exo_facul_5", "hiddenstatic");
            $form->setType("exo_facul_6", "hiddenstatic");
            $form->setType("exo_facul_7", "hiddenstatic");
            $form->setType("exo_facul_8", "hiddenstatic");
            $form->setType("exo_facul_9", "hiddenstatic");
            $form->setType("exo_ta_1", "hiddenstatic");
            $form->setType("exo_ta_2", "hiddenstatic");
            $form->setType("exo_ta_3", "hiddenstatic");
            $form->setType("exo_ta_4", "hiddenstatic");
            $form->setType("exo_ta_5", "hiddenstatic");
            $form->setType("exo_ta_6", "hiddenstatic");
            $form->setType("exo_ta_7", "hiddenstatic");
            $form->setType("exo_ta_8", "hiddenstatic");
            $form->setType("exo_ta_9", "hiddenstatic");
            $form->setType("exo_rap_1", "hiddenstatic");
            $form->setType("exo_rap_2", "hiddenstatic");
            $form->setType("exo_rap_3", "hiddenstatic");
            $form->setType("exo_rap_4", "hiddenstatic");
            $form->setType("exo_rap_5", "hiddenstatic");
            $form->setType("exo_rap_6", "hiddenstatic");
            $form->setType("exo_rap_7", "hiddenstatic");
            $form->setType("exo_rap_8", "hiddenstatic");
            $form->setType("mtn_exo_ta_part_commu", "hiddenstatic");
            $form->setType("mtn_exo_ta_part_depart", "hiddenstatic");
            $form->setType("mtn_exo_ta_part_reg", "hiddenstatic");
            $form->setType("mtn_exo_rap", "hiddenstatic");
            $form->setType("dpc_type", "hiddenstatic");
            $form->setType("dpc_desc_actv_ex", "hiddenstatic");
            $form->setType("dpc_desc_ca", "hiddenstatic");
            $form->setType("dpc_desc_aut_prec", "hiddenstatic");
            $form->setType("dpc_desig_comm_arti", "hiddenstatic");
            $form->setType("dpc_desig_loc_hab", "hiddenstatic");
            $form->setType("dpc_desig_loc_ann", "hiddenstatic");
            $form->setType("dpc_desig_loc_ann_prec", "hiddenstatic");
            $form->setType("dpc_bail_comm_date", "hiddenstatic");
            $form->setType("dpc_bail_comm_loyer", "hiddenstatic");
            $form->setType("dpc_actv_acqu", "hiddenstatic");
            $form->setType("dpc_nb_sala_di", "hiddenstatic");
            $form->setType("dpc_nb_sala_dd", "hiddenstatic");
            $form->setType("dpc_nb_sala_tc", "hiddenstatic");
            $form->setType("dpc_nb_sala_tp", "hiddenstatic");
            $form->setType("dpc_moda_cess_vente_am", "hiddenstatic");
            $form->setType("dpc_moda_cess_adj", "hiddenstatic");
            $form->setType("dpc_moda_cess_prix", "hiddenstatic");
            $form->setType("dpc_moda_cess_adj_date", "hiddenstatic");
            $form->setType("dpc_moda_cess_adj_prec", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_comp", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_terme", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_terme_prec", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_nat", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien_prec", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_nat_eval", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_nat_eval_prec", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_aut", "hiddenstatic");
            $form->setType("dpc_moda_cess_paie_aut_prec", "hiddenstatic");
            $form->setType("dpc_ss_signe_demande_acqu", "hiddenstatic");
            $form->setType("dpc_ss_signe_recher_trouv_acqu", "hiddenstatic");
            $form->setType("dpc_notif_adr_prop", "hiddenstatic");
            $form->setType("dpc_notif_adr_manda", "hiddenstatic");
            $form->setType("dpc_obs", "hiddenstatic");
            $form->setType("co_peri_site_patri_remar", "hiddenstatic");
            $form->setType("co_abo_monu_hist", "hiddenstatic");
            $form->setType("co_inst_ouvr_trav_act_code_envir", "hiddenstatic");
            $form->setType("co_trav_auto_env", "hiddenstatic");
            $form->setType("co_derog_esp_prot", "hiddenstatic");
            $form->setType("ctx_reference_dsj", "hiddenstatic");
            $form->setType("co_piscine", "hiddenstatic");
            $form->setType("co_fin_lls", "hiddenstatic");
            $form->setType("co_fin_aa", "hiddenstatic");
            $form->setType("co_fin_ptz", "hiddenstatic");
            $form->setType("co_fin_autr", "hiddenstatic");
            $form->setType("dia_ss_date", "hiddenstatic");
            $form->setType("dia_ss_lieu", "hiddenstatic");
            $form->setType("enga_decla_lieu", "hiddenstatic");
            $form->setType("enga_decla_date", "hiddenstatic");
            $form->setType("co_archi_attest_honneur", "hiddenstatic");
            $form->setType("co_bat_niv_dessous_nb", "hiddenstatic");
            $form->setType("co_install_classe", "hiddenstatic");
            $form->setType("co_derog_innov", "hiddenstatic");
            $form->setType("co_avis_abf", "hiddenstatic");
            $form->setType("tax_surf_tot_demo", "hiddenstatic");
            $form->setType("tax_surf_tax_demo", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf8", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_stat8", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf9", "hiddenstatic");
            $form->setType("tax_su_non_habit_surf_stat9", "hiddenstatic");
            $form->setType("tax_terrassement_arch", "hiddenstatic");
            $form->setType("tax_adresse_future_numero", "hiddenstatic");
            $form->setType("tax_adresse_future_voie", "hiddenstatic");
            $form->setType("tax_adresse_future_lieudit", "hiddenstatic");
            $form->setType("tax_adresse_future_localite", "hiddenstatic");
            $form->setType("tax_adresse_future_cp", "hiddenstatic");
            $form->setType("tax_adresse_future_bp", "hiddenstatic");
            $form->setType("tax_adresse_future_cedex", "hiddenstatic");
            $form->setType("tax_adresse_future_pays", "hiddenstatic");
            $form->setType("tax_adresse_future_division", "hiddenstatic");
            $form->setType("co_bat_projete", "hiddenstatic");
            $form->setType("co_bat_existant", "hiddenstatic");
            $form->setType("co_bat_nature", "hiddenstatic");
            $form->setType("terr_juri_titul_date", "hiddenstatic");
            $form->setType("co_autre_desc", "hiddenstatic");
            $form->setType("co_trx_autre", "hiddenstatic");
            $form->setType("co_autre", "hiddenstatic");
            $form->setType("erp_modif_facades", "hiddenstatic");
            $form->setType("erp_trvx_adap", "hiddenstatic");
            $form->setType("erp_trvx_adap_numero", "hiddenstatic");
            $form->setType("erp_trvx_adap_valid", "hiddenstatic");
            $form->setType("erp_prod_dangereux", "hiddenstatic");
            $form->setType("co_trav_supp_dessus", "hiddenstatic");
            $form->setType("co_trav_supp_dessous", "hiddenstatic");
            $form->setType("tax_su_habit_abr_jard_pig_colom", "hiddenstatic");
            $form->setType("enga_decla_donnees_nomi_comm", "hiddenstatic");
            $form->setType("x1l_legislation", "hiddenstatic");
            $form->setType("x1p_precisions", "hiddenstatic");
            $form->setType("x1u_raccordement", "hiddenstatic");
            $form->setType("x2m_inscritmh", "hiddenstatic");
            $form->setType("s1na1_numero", "hiddenstatic");
            $form->setType("s1va1_voie", "hiddenstatic");
            $form->setType("s1wa1_lieudit", "hiddenstatic");
            $form->setType("s1la1_localite", "hiddenstatic");
            $form->setType("s1pa1_codepostal", "hiddenstatic");
            $form->setType("s1na2_numero", "hiddenstatic");
            $form->setType("s1va2_voie", "hiddenstatic");
            $form->setType("s1wa2_lieudit", "hiddenstatic");
            $form->setType("s1la2_localite", "hiddenstatic");
            $form->setType("s1pa2_codepostal", "hiddenstatic");
            $form->setType("e3c_certification", "hiddenstatic");
            $form->setType("e3a_competence", "hiddenstatic");
            $form->setType("a4d_description", "hiddenstatic");
            $form->setType("m2b_abf", "hiddenstatic");
            $form->setType("m2j_pn", "hiddenstatic");
            $form->setType("m2r_cdac", "hiddenstatic");
            $form->setType("m2r_cnac", "hiddenstatic");
            $form->setType("u3a_voirieoui", "hiddenstatic");
            $form->setType("u3f_voirienon", "hiddenstatic");
            $form->setType("u3c_eauoui", "hiddenstatic");
            $form->setType("u3h_eaunon", "hiddenstatic");
            $form->setType("u3g_assainissementoui", "hiddenstatic");
            $form->setType("u3n_assainissementnon", "hiddenstatic");
            $form->setType("u3m_electriciteoui", "hiddenstatic");
            $form->setType("u3b_electricitenon", "hiddenstatic");
            $form->setType("u3t_observations", "hiddenstatic");
            $form->setType("u1a_voirieoui", "hiddenstatic");
            $form->setType("u1v_voirienon", "hiddenstatic");
            $form->setType("u1q_voirieconcessionnaire", "hiddenstatic");
            $form->setType("u1b_voirieavant", "hiddenstatic");
            $form->setType("u1j_eauoui", "hiddenstatic");
            $form->setType("u1t_eaunon", "hiddenstatic");
            $form->setType("u1e_eauconcessionnaire", "hiddenstatic");
            $form->setType("u1k_eauavant", "hiddenstatic");
            $form->setType("u1s_assainissementoui", "hiddenstatic");
            $form->setType("u1d_assainissementnon", "hiddenstatic");
            $form->setType("u1l_assainissementconcessionnaire", "hiddenstatic");
            $form->setType("u1r_assainissementavant", "hiddenstatic");
            $form->setType("u1c_electriciteoui", "hiddenstatic");
            $form->setType("u1u_electricitenon", "hiddenstatic");
            $form->setType("u1m_electriciteconcessionnaire", "hiddenstatic");
            $form->setType("u1f_electriciteavant", "hiddenstatic");
            $form->setType("u2a_observations", "hiddenstatic");
            $form->setType("f1ts4_surftaxestation", "hiddenstatic");
            $form->setType("f1ut1_surfcree", "hiddenstatic");
            $form->setType("f9d_date", "hiddenstatic");
            $form->setType("f9n_nom", "hiddenstatic");
            $form->setType("su2_avt_shon21", "hiddenstatic");
            $form->setType("su2_avt_shon22", "hiddenstatic");
            $form->setType("su2_cstr_shon21", "hiddenstatic");
            $form->setType("su2_cstr_shon22", "hiddenstatic");
            $form->setType("su2_chge_shon21", "hiddenstatic");
            $form->setType("su2_chge_shon22", "hiddenstatic");
            $form->setType("su2_demo_shon21", "hiddenstatic");
            $form->setType("su2_demo_shon22", "hiddenstatic");
            $form->setType("su2_sup_shon21", "hiddenstatic");
            $form->setType("su2_sup_shon22", "hiddenstatic");
            $form->setType("su2_tot_shon21", "hiddenstatic");
            $form->setType("su2_tot_shon22", "hiddenstatic");
            $form->setType("f1gu1_f1gu2_f1gu3", "hiddenstatic");
            $form->setType("f1lu1_f1lu2_f1lu3", "hiddenstatic");
            $form->setType("f1zu1_f1zu2_f1zu3", "hiddenstatic");
            $form->setType("f1pu1_f1pu2_f1pu3", "hiddenstatic");
            $form->setType("f1gt4_f1gt5_f1gt6", "hiddenstatic");
            $form->setType("f1lt4_f1lt5_f1lt6", "hiddenstatic");
            $form->setType("f1zt4_f1zt5_f1zt6", "hiddenstatic");
            $form->setType("f1pt4_f1pt5_f1pt6", "hiddenstatic");
            $form->setType("f1xu1_f1xu2_f1xu3", "hiddenstatic");
            $form->setType("f1xt4_f1xt5_f1xt6", "hiddenstatic");
            $form->setType("f1hu1_f1hu2_f1hu3", "hiddenstatic");
            $form->setType("f1mu1_f1mu2_f1mu3", "hiddenstatic");
            $form->setType("f1qu1_f1qu2_f1qu3", "hiddenstatic");
            $form->setType("f1ht4_f1ht5_f1ht6", "hiddenstatic");
            $form->setType("f1mt4_f1mt5_f1mt6", "hiddenstatic");
            $form->setType("f1qt4_f1qt5_f1qt6", "hiddenstatic");
            $form->setType("f2cu1_f2cu2_f2cu3", "hiddenstatic");
            $form->setType("f2bu1_f2bu2_f2bu3", "hiddenstatic");
            $form->setType("f2su1_f2su2_f2su3", "hiddenstatic");
            $form->setType("f2hu1_f2hu2_f2hu3", "hiddenstatic");
            $form->setType("f2eu1_f2eu2_f2eu3", "hiddenstatic");
            $form->setType("f2qu1_f2qu2_f2qu3", "hiddenstatic");
            $form->setType("f2ct4_f2ct5_f2ct6", "hiddenstatic");
            $form->setType("f2bt4_f2bt5_f2bt6", "hiddenstatic");
            $form->setType("f2st4_f2st5_f2st6", "hiddenstatic");
            $form->setType("f2ht4_f2ht5_f2ht6", "hiddenstatic");
            $form->setType("f2et4_f2et5_f2et6", "hiddenstatic");
            $form->setType("f2qt4_f2qt5_f2qt6", "hiddenstatic");
            $form->setType("dia_droit_reel_perso_grevant_bien_desc", "hiddenstatic");
            $form->setType("dia_mod_cess_paie_nat_desc", "hiddenstatic");
            $form->setType("dia_mod_cess_rente_viag_desc", "hiddenstatic");
            $form->setType("dia_mod_cess_echange_desc", "hiddenstatic");
            $form->setType("dia_mod_cess_apport_societe_desc", "hiddenstatic");
            $form->setType("dia_mod_cess_cess_terr_loc_co_desc", "hiddenstatic");
            $form->setType("dia_mod_cess_esti_imm_loca_desc", "hiddenstatic");
            $form->setType("dia_mod_cess_adju_obl_desc", "hiddenstatic");
            $form->setType("dia_mod_cess_adju_fin_indivi_desc", "hiddenstatic");
            $form->setType("dia_cadre_titul_droit_prempt", "hiddenstatic");
            $form->setType("dia_mairie_prix_moyen", "hiddenstatic");
            $form->setType("dia_propri_indivi", "hiddenstatic");
            $form->setType("dia_situa_bien_plan_cadas_oui", "hiddenstatic");
            $form->setType("dia_situa_bien_plan_cadas_non", "hiddenstatic");
            $form->setType("dia_notif_dec_titul_adr_prop", "hiddenstatic");
            $form->setType("dia_notif_dec_titul_adr_prop_desc", "hiddenstatic");
            $form->setType("dia_notif_dec_titul_adr_manda", "hiddenstatic");
            $form->setType("dia_notif_dec_titul_adr_manda_desc", "hiddenstatic");
            $form->setType("dia_dia_dpu", "hiddenstatic");
            $form->setType("dia_dia_zad", "hiddenstatic");
            $form->setType("dia_dia_zone_preempt_esp_natu_sensi", "hiddenstatic");
            $form->setType("dia_dab_dpu", "hiddenstatic");
            $form->setType("dia_dab_zad", "hiddenstatic");
            $form->setType("dia_mod_cess_commi_mnt", "hiddenstatic");
            $form->setType("dia_mod_cess_commi_mnt_ttc", "hiddenstatic");
            $form->setType("dia_mod_cess_commi_mnt_ht", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente_num", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente_mob_num", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente_cheptel_num", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente_recol_num", "hiddenstatic");
            $form->setType("dia_mod_cess_prix_vente_autre_num", "hiddenstatic");
            $form->setType("dia_su_co_sol_num", "hiddenstatic");
            $form->setType("dia_su_util_hab_num", "hiddenstatic");
            $form->setType("dia_mod_cess_mnt_an_num", "hiddenstatic");
            $form->setType("dia_mod_cess_mnt_compt_num", "hiddenstatic");
            $form->setType("dia_mod_cess_mnt_soulte_num", "hiddenstatic");
            $form->setType("dia_comp_prix_vente", "hiddenstatic");
            $form->setType("dia_comp_surface", "hiddenstatic");
            $form->setType("dia_comp_total_frais", "hiddenstatic");
            $form->setType("dia_comp_mtn_total", "hiddenstatic");
            $form->setType("dia_comp_valeur_m2", "hiddenstatic");
            $form->setType("dia_esti_prix_france_dom", "hiddenstatic");
            $form->setType("dia_prop_collectivite", "hiddenstatic");
            $form->setType("dia_delegataire_denomination", "hiddenstatic");
            $form->setType("dia_delegataire_raison_sociale", "hiddenstatic");
            $form->setType("dia_delegataire_siret", "hiddenstatic");
            $form->setType("dia_delegataire_categorie_juridique", "hiddenstatic");
            $form->setType("dia_delegataire_representant_nom", "hiddenstatic");
            $form->setType("dia_delegataire_representant_prenom", "hiddenstatic");
            $form->setType("dia_delegataire_adresse_numero", "hiddenstatic");
            $form->setType("dia_delegataire_adresse_voie", "hiddenstatic");
            $form->setType("dia_delegataire_adresse_complement", "hiddenstatic");
            $form->setType("dia_delegataire_adresse_lieu_dit", "hiddenstatic");
            $form->setType("dia_delegataire_adresse_localite", "hiddenstatic");
            $form->setType("dia_delegataire_adresse_code_postal", "hiddenstatic");
            $form->setType("dia_delegataire_adresse_bp", "hiddenstatic");
            $form->setType("dia_delegataire_adresse_cedex", "hiddenstatic");
            $form->setType("dia_delegataire_adresse_pays", "hiddenstatic");
            $form->setType("dia_delegataire_telephone_fixe", "hiddenstatic");
            $form->setType("dia_delegataire_telephone_mobile", "hiddenstatic");
            $form->setType("dia_delegataire_telephone_mobile_indicatif", "hiddenstatic");
            $form->setType("dia_delegataire_courriel", "hiddenstatic");
            $form->setType("dia_delegataire_fax", "hiddenstatic");
            $form->setType("dia_entree_jouissance_type", "hiddenstatic");
            $form->setType("dia_entree_jouissance_date", "hiddenstatic");
            $form->setType("dia_entree_jouissance_date_effet", "hiddenstatic");
            $form->setType("dia_entree_jouissance_com", "hiddenstatic");
            $form->setType("dia_remise_bien_date_effet", "hiddenstatic");
            $form->setType("dia_remise_bien_com", "hiddenstatic");
            $form->setType("c2zp1_crete", "hiddenstatic");
            $form->setType("c2zr1_destination", "hiddenstatic");
            $form->setType("mh_design_appel_denom", "hiddenstatic");
            $form->setType("mh_design_type_protect", "hiddenstatic");
            $form->setType("mh_design_elem_prot", "hiddenstatic");
            $form->setType("mh_design_ref_merimee_palissy", "hiddenstatic");
            $form->setType("mh_design_nature_prop", "hiddenstatic");
            $form->setType("mh_loc_denom", "hiddenstatic");
            $form->setType("mh_pres_intitule", "hiddenstatic");
            $form->setType("mh_trav_cat_1", "hiddenstatic");
            $form->setType("mh_trav_cat_2", "hiddenstatic");
            $form->setType("mh_trav_cat_3", "hiddenstatic");
            $form->setType("mh_trav_cat_4", "hiddenstatic");
            $form->setType("mh_trav_cat_5", "hiddenstatic");
            $form->setType("mh_trav_cat_6", "hiddenstatic");
            $form->setType("mh_trav_cat_7", "hiddenstatic");
            $form->setType("mh_trav_cat_8", "hiddenstatic");
            $form->setType("mh_trav_cat_9", "hiddenstatic");
            $form->setType("mh_trav_cat_10", "hiddenstatic");
            $form->setType("mh_trav_cat_11", "hiddenstatic");
            $form->setType("mh_trav_cat_12", "hiddenstatic");
            $form->setType("mh_trav_cat_12_prec", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("donnees_techniques", "static");
            $form->setType("dossier_instruction", "selectstatic");
            $form->setType("lot", "selectstatic");
            $form->setType("am_lotiss", "checkboxstatic");
            $form->setType("am_autre_div", "checkboxstatic");
            $form->setType("am_camping", "checkboxstatic");
            $form->setType("am_caravane", "checkboxstatic");
            $form->setType("am_carav_duree", "static");
            $form->setType("am_statio", "checkboxstatic");
            $form->setType("am_statio_cont", "static");
            $form->setType("am_affou_exhau", "checkboxstatic");
            $form->setType("am_affou_exhau_sup", "static");
            $form->setType("am_affou_prof", "static");
            $form->setType("am_exhau_haut", "static");
            $form->setType("am_coupe_abat", "checkboxstatic");
            $form->setType("am_prot_plu", "checkboxstatic");
            $form->setType("am_prot_muni", "checkboxstatic");
            $form->setType("am_mobil_voyage", "checkboxstatic");
            $form->setType("am_aire_voyage", "checkboxstatic");
            $form->setType("am_rememb_afu", "checkboxstatic");
            $form->setType("am_parc_resid_loi", "checkboxstatic");
            $form->setType("am_sport_moto", "checkboxstatic");
            $form->setType("am_sport_attrac", "checkboxstatic");
            $form->setType("am_sport_golf", "checkboxstatic");
            $form->setType("am_mob_art", "checkboxstatic");
            $form->setType("am_modif_voie_esp", "checkboxstatic");
            $form->setType("am_plant_voie_esp", "checkboxstatic");
            $form->setType("am_chem_ouv_esp", "checkboxstatic");
            $form->setType("am_agri_peche", "checkboxstatic");
            $form->setType("am_crea_voie", "checkboxstatic");
            $form->setType("am_modif_voie_exist", "checkboxstatic");
            $form->setType("am_crea_esp_sauv", "checkboxstatic");
            $form->setType("am_crea_esp_class", "checkboxstatic");
            $form->setType("am_projet_desc", "textareastatic");
            $form->setType("am_terr_surf", "static");
            $form->setType("am_tranche_desc", "textareastatic");
            $form->setType("am_lot_max_nb", "static");
            $form->setType("am_lot_max_shon", "static");
            $form->setType("am_lot_cstr_cos", "checkboxstatic");
            $form->setType("am_lot_cstr_plan", "checkboxstatic");
            $form->setType("am_lot_cstr_vente", "checkboxstatic");
            $form->setType("am_lot_fin_diff", "checkboxstatic");
            $form->setType("am_lot_consign", "checkboxstatic");
            $form->setType("am_lot_gar_achev", "checkboxstatic");
            $form->setType("am_lot_vente_ant", "checkboxstatic");
            $form->setType("am_empl_nb", "static");
            $form->setType("am_tente_nb", "static");
            $form->setType("am_carav_nb", "static");
            $form->setType("am_mobil_nb", "static");
            $form->setType("am_pers_nb", "static");
            $form->setType("am_empl_hll_nb", "static");
            $form->setType("am_hll_shon", "static");
            $form->setType("am_periode_exploit", "textareastatic");
            $form->setType("am_exist_agrand", "checkboxstatic");
            $form->setType("am_exist_date", "static");
            $form->setType("am_exist_num", "static");
            $form->setType("am_exist_nb_avant", "static");
            $form->setType("am_exist_nb_apres", "static");
            $form->setType("am_coupe_bois", "checkboxstatic");
            $form->setType("am_coupe_parc", "checkboxstatic");
            $form->setType("am_coupe_align", "checkboxstatic");
            $form->setType("am_coupe_ess", "static");
            $form->setType("am_coupe_age", "static");
            $form->setType("am_coupe_dens", "static");
            $form->setType("am_coupe_qual", "static");
            $form->setType("am_coupe_trait", "static");
            $form->setType("am_coupe_autr", "static");
            $form->setType("co_archi_recours", "checkboxstatic");
            $form->setType("co_cstr_nouv", "checkboxstatic");
            $form->setType("co_cstr_exist", "checkboxstatic");
            $form->setType("co_cloture", "checkboxstatic");
            $form->setType("co_elec_tension", "static");
            $form->setType("co_div_terr", "checkboxstatic");
            $form->setType("co_projet_desc", "textareastatic");
            $form->setType("co_anx_pisc", "checkboxstatic");
            $form->setType("co_anx_gara", "checkboxstatic");
            $form->setType("co_anx_veran", "checkboxstatic");
            $form->setType("co_anx_abri", "checkboxstatic");
            $form->setType("co_anx_autr", "checkboxstatic");
            $form->setType("co_anx_autr_desc", "textareastatic");
            $form->setType("co_tot_log_nb", "static");
            $form->setType("co_tot_ind_nb", "static");
            $form->setType("co_tot_coll_nb", "static");
            $form->setType("co_mais_piece_nb", "static");
            $form->setType("co_mais_niv_nb", "static");
            $form->setType("co_fin_lls_nb", "static");
            $form->setType("co_fin_aa_nb", "static");
            $form->setType("co_fin_ptz_nb", "static");
            $form->setType("co_fin_autr_nb", "static");
            $form->setType("co_fin_autr_desc", "textareastatic");
            $form->setType("co_mais_contrat_ind", "checkboxstatic");
            $form->setType("co_uti_pers", "checkboxstatic");
            $form->setType("co_uti_vente", "checkboxstatic");
            $form->setType("co_uti_loc", "checkboxstatic");
            $form->setType("co_uti_princ", "checkboxstatic");
            $form->setType("co_uti_secon", "checkboxstatic");
            $form->setType("co_resid_agees", "checkboxstatic");
            $form->setType("co_resid_etud", "checkboxstatic");
            $form->setType("co_resid_tourism", "checkboxstatic");
            $form->setType("co_resid_hot_soc", "checkboxstatic");
            $form->setType("co_resid_soc", "checkboxstatic");
            $form->setType("co_resid_hand", "checkboxstatic");
            $form->setType("co_resid_autr", "checkboxstatic");
            $form->setType("co_resid_autr_desc", "textareastatic");
            $form->setType("co_foyer_chamb_nb", "static");
            $form->setType("co_log_1p_nb", "static");
            $form->setType("co_log_2p_nb", "static");
            $form->setType("co_log_3p_nb", "static");
            $form->setType("co_log_4p_nb", "static");
            $form->setType("co_log_5p_nb", "static");
            $form->setType("co_log_6p_nb", "static");
            $form->setType("co_bat_niv_nb", "static");
            $form->setType("co_trx_exten", "checkboxstatic");
            $form->setType("co_trx_surelev", "checkboxstatic");
            $form->setType("co_trx_nivsup", "checkboxstatic");
            $form->setType("co_demont_periode", "textareastatic");
            $form->setType("co_sp_transport", "checkboxstatic");
            $form->setType("co_sp_enseign", "checkboxstatic");
            $form->setType("co_sp_act_soc", "checkboxstatic");
            $form->setType("co_sp_ouvr_spe", "checkboxstatic");
            $form->setType("co_sp_sante", "checkboxstatic");
            $form->setType("co_sp_culture", "checkboxstatic");
            $form->setType("co_statio_avt_nb", "static");
            $form->setType("co_statio_apr_nb", "static");
            $form->setType("co_statio_adr", "textareastatic");
            $form->setType("co_statio_place_nb", "static");
            $form->setType("co_statio_tot_surf", "static");
            $form->setType("co_statio_tot_shob", "static");
            $form->setType("co_statio_comm_cin_surf", "static");
            $form->setType("su_avt_shon1", "static");
            $form->setType("su_avt_shon2", "static");
            $form->setType("su_avt_shon3", "static");
            $form->setType("su_avt_shon4", "static");
            $form->setType("su_avt_shon5", "static");
            $form->setType("su_avt_shon6", "static");
            $form->setType("su_avt_shon7", "static");
            $form->setType("su_avt_shon8", "static");
            $form->setType("su_avt_shon9", "static");
            $form->setType("su_cstr_shon1", "static");
            $form->setType("su_cstr_shon2", "static");
            $form->setType("su_cstr_shon3", "static");
            $form->setType("su_cstr_shon4", "static");
            $form->setType("su_cstr_shon5", "static");
            $form->setType("su_cstr_shon6", "static");
            $form->setType("su_cstr_shon7", "static");
            $form->setType("su_cstr_shon8", "static");
            $form->setType("su_cstr_shon9", "static");
            $form->setType("su_trsf_shon1", "static");
            $form->setType("su_trsf_shon2", "static");
            $form->setType("su_trsf_shon3", "static");
            $form->setType("su_trsf_shon4", "static");
            $form->setType("su_trsf_shon5", "static");
            $form->setType("su_trsf_shon6", "static");
            $form->setType("su_trsf_shon7", "static");
            $form->setType("su_trsf_shon8", "static");
            $form->setType("su_trsf_shon9", "static");
            $form->setType("su_chge_shon1", "static");
            $form->setType("su_chge_shon2", "static");
            $form->setType("su_chge_shon3", "static");
            $form->setType("su_chge_shon4", "static");
            $form->setType("su_chge_shon5", "static");
            $form->setType("su_chge_shon6", "static");
            $form->setType("su_chge_shon7", "static");
            $form->setType("su_chge_shon8", "static");
            $form->setType("su_chge_shon9", "static");
            $form->setType("su_demo_shon1", "static");
            $form->setType("su_demo_shon2", "static");
            $form->setType("su_demo_shon3", "static");
            $form->setType("su_demo_shon4", "static");
            $form->setType("su_demo_shon5", "static");
            $form->setType("su_demo_shon6", "static");
            $form->setType("su_demo_shon7", "static");
            $form->setType("su_demo_shon8", "static");
            $form->setType("su_demo_shon9", "static");
            $form->setType("su_sup_shon1", "static");
            $form->setType("su_sup_shon2", "static");
            $form->setType("su_sup_shon3", "static");
            $form->setType("su_sup_shon4", "static");
            $form->setType("su_sup_shon5", "static");
            $form->setType("su_sup_shon6", "static");
            $form->setType("su_sup_shon7", "static");
            $form->setType("su_sup_shon8", "static");
            $form->setType("su_sup_shon9", "static");
            $form->setType("su_tot_shon1", "static");
            $form->setType("su_tot_shon2", "static");
            $form->setType("su_tot_shon3", "static");
            $form->setType("su_tot_shon4", "static");
            $form->setType("su_tot_shon5", "static");
            $form->setType("su_tot_shon6", "static");
            $form->setType("su_tot_shon7", "static");
            $form->setType("su_tot_shon8", "static");
            $form->setType("su_tot_shon9", "static");
            $form->setType("su_avt_shon_tot", "static");
            $form->setType("su_cstr_shon_tot", "static");
            $form->setType("su_trsf_shon_tot", "static");
            $form->setType("su_chge_shon_tot", "static");
            $form->setType("su_demo_shon_tot", "static");
            $form->setType("su_sup_shon_tot", "static");
            $form->setType("su_tot_shon_tot", "static");
            $form->setType("dm_constr_dates", "textareastatic");
            $form->setType("dm_total", "checkboxstatic");
            $form->setType("dm_partiel", "checkboxstatic");
            $form->setType("dm_projet_desc", "textareastatic");
            $form->setType("dm_tot_log_nb", "static");
            $form->setType("tax_surf_tot", "static");
            $form->setType("tax_surf", "static");
            $form->setType("tax_surf_suppr_mod", "static");
            $form->setType("tax_su_princ_log_nb1", "static");
            $form->setType("tax_su_princ_log_nb2", "static");
            $form->setType("tax_su_princ_log_nb3", "static");
            $form->setType("tax_su_princ_log_nb4", "static");
            $form->setType("tax_su_princ_log_nb_tot1", "static");
            $form->setType("tax_su_princ_log_nb_tot2", "static");
            $form->setType("tax_su_princ_log_nb_tot3", "static");
            $form->setType("tax_su_princ_log_nb_tot4", "static");
            $form->setType("tax_su_princ_surf1", "static");
            $form->setType("tax_su_princ_surf2", "static");
            $form->setType("tax_su_princ_surf3", "static");
            $form->setType("tax_su_princ_surf4", "static");
            $form->setType("tax_su_princ_surf_sup1", "static");
            $form->setType("tax_su_princ_surf_sup2", "static");
            $form->setType("tax_su_princ_surf_sup3", "static");
            $form->setType("tax_su_princ_surf_sup4", "static");
            $form->setType("tax_su_heber_log_nb1", "static");
            $form->setType("tax_su_heber_log_nb2", "static");
            $form->setType("tax_su_heber_log_nb3", "static");
            $form->setType("tax_su_heber_log_nb_tot1", "static");
            $form->setType("tax_su_heber_log_nb_tot2", "static");
            $form->setType("tax_su_heber_log_nb_tot3", "static");
            $form->setType("tax_su_heber_surf1", "static");
            $form->setType("tax_su_heber_surf2", "static");
            $form->setType("tax_su_heber_surf3", "static");
            $form->setType("tax_su_heber_surf_sup1", "static");
            $form->setType("tax_su_heber_surf_sup2", "static");
            $form->setType("tax_su_heber_surf_sup3", "static");
            $form->setType("tax_su_secon_log_nb", "static");
            $form->setType("tax_su_tot_log_nb", "static");
            $form->setType("tax_su_secon_log_nb_tot", "static");
            $form->setType("tax_su_tot_log_nb_tot", "static");
            $form->setType("tax_su_secon_surf", "static");
            $form->setType("tax_su_tot_surf", "static");
            $form->setType("tax_su_secon_surf_sup", "static");
            $form->setType("tax_su_tot_surf_sup", "static");
            $form->setType("tax_ext_pret", "checkboxstatic");
            $form->setType("tax_ext_desc", "textareastatic");
            $form->setType("tax_surf_tax_exist_cons", "static");
            $form->setType("tax_log_exist_nb", "static");
            $form->setType("tax_am_statio_ext", "static");
            $form->setType("tax_sup_bass_pisc", "static");
            $form->setType("tax_empl_ten_carav_mobil_nb", "static");
            $form->setType("tax_empl_hll_nb", "static");
            $form->setType("tax_eol_haut_nb", "static");
            $form->setType("tax_pann_volt_sup", "static");
            $form->setType("tax_am_statio_ext_sup", "static");
            $form->setType("tax_sup_bass_pisc_sup", "static");
            $form->setType("tax_empl_ten_carav_mobil_nb_sup", "static");
            $form->setType("tax_empl_hll_nb_sup", "static");
            $form->setType("tax_eol_haut_nb_sup", "static");
            $form->setType("tax_pann_volt_sup_sup", "static");
            $form->setType("tax_trx_presc_ppr", "checkboxstatic");
            $form->setType("tax_monu_hist", "checkboxstatic");
            $form->setType("tax_comm_nb", "static");
            $form->setType("tax_su_non_habit_surf1", "static");
            $form->setType("tax_su_non_habit_surf2", "static");
            $form->setType("tax_su_non_habit_surf3", "static");
            $form->setType("tax_su_non_habit_surf4", "static");
            $form->setType("tax_su_non_habit_surf5", "static");
            $form->setType("tax_su_non_habit_surf6", "static");
            $form->setType("tax_su_non_habit_surf7", "static");
            $form->setType("tax_su_non_habit_surf_sup1", "static");
            $form->setType("tax_su_non_habit_surf_sup2", "static");
            $form->setType("tax_su_non_habit_surf_sup3", "static");
            $form->setType("tax_su_non_habit_surf_sup4", "static");
            $form->setType("tax_su_non_habit_surf_sup5", "static");
            $form->setType("tax_su_non_habit_surf_sup6", "static");
            $form->setType("tax_su_non_habit_surf_sup7", "static");
            $form->setType("vsd_surf_planch_smd", "checkboxstatic");
            $form->setType("vsd_unit_fonc_sup", "static");
            $form->setType("vsd_unit_fonc_constr_sup", "static");
            $form->setType("vsd_val_terr", "static");
            $form->setType("vsd_const_sxist_non_dem_surf", "static");
            $form->setType("vsd_rescr_fisc", "datestatic");
            $form->setType("pld_val_terr", "static");
            $form->setType("pld_const_exist_dem", "checkboxstatic");
            $form->setType("pld_const_exist_dem_surf", "static");
            $form->setType("code_cnil", "checkboxstatic");
            $form->setType("terr_juri_titul", "static");
            $form->setType("terr_juri_lot", "static");
            $form->setType("terr_juri_zac", "static");
            $form->setType("terr_juri_afu", "static");
            $form->setType("terr_juri_pup", "static");
            $form->setType("terr_juri_oin", "static");
            $form->setType("terr_juri_desc", "textareastatic");
            $form->setType("terr_div_surf_etab", "static");
            $form->setType("terr_div_surf_av_div", "static");
            $form->setType("doc_date", "datestatic");
            $form->setType("doc_tot_trav", "checkboxstatic");
            $form->setType("doc_tranche_trav", "checkboxstatic");
            $form->setType("doc_tranche_trav_desc", "textareastatic");
            $form->setType("doc_surf", "static");
            $form->setType("doc_nb_log", "static");
            $form->setType("doc_nb_log_indiv", "static");
            $form->setType("doc_nb_log_coll", "static");
            $form->setType("doc_nb_log_lls", "static");
            $form->setType("doc_nb_log_aa", "static");
            $form->setType("doc_nb_log_ptz", "static");
            $form->setType("doc_nb_log_autre", "static");
            $form->setType("daact_date", "datestatic");
            $form->setType("daact_date_chgmt_dest", "datestatic");
            $form->setType("daact_tot_trav", "checkboxstatic");
            $form->setType("daact_tranche_trav", "checkboxstatic");
            $form->setType("daact_tranche_trav_desc", "textareastatic");
            $form->setType("daact_surf", "static");
            $form->setType("daact_nb_log", "static");
            $form->setType("daact_nb_log_indiv", "static");
            $form->setType("daact_nb_log_coll", "static");
            $form->setType("daact_nb_log_lls", "static");
            $form->setType("daact_nb_log_aa", "static");
            $form->setType("daact_nb_log_ptz", "static");
            $form->setType("daact_nb_log_autre", "static");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("am_div_mun", "checkboxstatic");
            $form->setType("co_perf_energ", "static");
            $form->setType("architecte", "selectstatic");
            $form->setType("co_statio_avt_shob", "static");
            $form->setType("co_statio_apr_shob", "static");
            $form->setType("co_statio_avt_surf", "static");
            $form->setType("co_statio_apr_surf", "static");
            $form->setType("co_trx_amgt", "static");
            $form->setType("co_modif_aspect", "static");
            $form->setType("co_modif_struct", "static");
            $form->setType("co_ouvr_elec", "checkboxstatic");
            $form->setType("co_ouvr_infra", "checkboxstatic");
            $form->setType("co_trx_imm", "static");
            $form->setType("co_cstr_shob", "static");
            $form->setType("am_voyage_deb", "static");
            $form->setType("am_voyage_fin", "static");
            $form->setType("am_modif_amgt", "static");
            $form->setType("am_lot_max_shob", "static");
            $form->setType("mod_desc", "static");
            $form->setType("tr_total", "static");
            $form->setType("tr_partiel", "static");
            $form->setType("tr_desc", "static");
            $form->setType("avap_co_elt_pro", "checkboxstatic");
            $form->setType("avap_nouv_haut_surf", "checkboxstatic");
            $form->setType("avap_co_clot", "static");
            $form->setType("avap_aut_coup_aba_arb", "static");
            $form->setType("avap_ouv_infra", "static");
            $form->setType("avap_aut_inst_mob", "static");
            $form->setType("avap_aut_plant", "static");
            $form->setType("avap_aut_auv_elec", "static");
            $form->setType("tax_dest_loc_tr", "static");
            $form->setType("ope_proj_desc", "textareastatic");
            $form->setType("tax_surf_tot_cstr", "static");
            $form->setType("cerfa", "static");
            $form->setType("tax_surf_loc_stat", "static");
            $form->setType("tax_su_princ_surf_stat1", "static");
            $form->setType("tax_su_princ_surf_stat2", "static");
            $form->setType("tax_su_princ_surf_stat3", "static");
            $form->setType("tax_su_princ_surf_stat4", "static");
            $form->setType("tax_su_secon_surf_stat", "static");
            $form->setType("tax_su_heber_surf_stat1", "static");
            $form->setType("tax_su_heber_surf_stat2", "static");
            $form->setType("tax_su_heber_surf_stat3", "static");
            $form->setType("tax_su_tot_surf_stat", "static");
            $form->setType("tax_su_non_habit_surf_stat1", "static");
            $form->setType("tax_su_non_habit_surf_stat2", "static");
            $form->setType("tax_su_non_habit_surf_stat3", "static");
            $form->setType("tax_su_non_habit_surf_stat4", "static");
            $form->setType("tax_su_non_habit_surf_stat5", "static");
            $form->setType("tax_su_non_habit_surf_stat6", "static");
            $form->setType("tax_su_non_habit_surf_stat7", "static");
            $form->setType("tax_su_parc_statio_expl_comm_surf", "static");
            $form->setType("tax_log_ap_trvx_nb", "static");
            $form->setType("tax_am_statio_ext_cr", "static");
            $form->setType("tax_sup_bass_pisc_cr", "static");
            $form->setType("tax_empl_ten_carav_mobil_nb_cr", "static");
            $form->setType("tax_empl_hll_nb_cr", "static");
            $form->setType("tax_eol_haut_nb_cr", "static");
            $form->setType("tax_pann_volt_sup_cr", "static");
            $form->setType("tax_surf_loc_arch", "static");
            $form->setType("tax_surf_pisc_arch", "static");
            $form->setType("tax_am_statio_ext_arch", "static");
            $form->setType("tax_empl_ten_carav_mobil_nb_arch", "static");
            $form->setType("tax_empl_hll_nb_arch", "static");
            $form->setType("tax_eol_haut_nb_arch", "static");
            $form->setType("ope_proj_div_co", "checkboxstatic");
            $form->setType("ope_proj_div_contr", "checkboxstatic");
            $form->setType("tax_desc", "textareastatic");
            $form->setType("erp_cstr_neuve", "checkboxstatic");
            $form->setType("erp_trvx_acc", "checkboxstatic");
            $form->setType("erp_extension", "checkboxstatic");
            $form->setType("erp_rehab", "checkboxstatic");
            $form->setType("erp_trvx_am", "checkboxstatic");
            $form->setType("erp_vol_nouv_exist", "checkboxstatic");
            $form->setType("erp_loc_eff1", "static");
            $form->setType("erp_loc_eff2", "static");
            $form->setType("erp_loc_eff3", "static");
            $form->setType("erp_loc_eff4", "static");
            $form->setType("erp_loc_eff5", "static");
            $form->setType("erp_loc_eff_tot", "static");
            $form->setType("erp_public_eff1", "static");
            $form->setType("erp_public_eff2", "static");
            $form->setType("erp_public_eff3", "static");
            $form->setType("erp_public_eff4", "static");
            $form->setType("erp_public_eff5", "static");
            $form->setType("erp_public_eff_tot", "static");
            $form->setType("erp_perso_eff1", "static");
            $form->setType("erp_perso_eff2", "static");
            $form->setType("erp_perso_eff3", "static");
            $form->setType("erp_perso_eff4", "static");
            $form->setType("erp_perso_eff5", "static");
            $form->setType("erp_perso_eff_tot", "static");
            $form->setType("erp_tot_eff1", "static");
            $form->setType("erp_tot_eff2", "static");
            $form->setType("erp_tot_eff3", "static");
            $form->setType("erp_tot_eff4", "static");
            $form->setType("erp_tot_eff5", "static");
            $form->setType("erp_tot_eff_tot", "static");
            $form->setType("erp_class_cat", "static");
            $form->setType("erp_class_type", "static");
            $form->setType("tax_surf_abr_jard_pig_colom", "static");
            $form->setType("tax_su_non_habit_abr_jard_pig_colom", "static");
            $form->setType("dia_imm_non_bati", "checkboxstatic");
            $form->setType("dia_imm_bati_terr_propr", "checkboxstatic");
            $form->setType("dia_imm_bati_terr_autr", "checkboxstatic");
            $form->setType("dia_imm_bati_terr_autr_desc", "textareastatic");
            $form->setType("dia_bat_copro", "checkboxstatic");
            $form->setType("dia_bat_copro_desc", "textareastatic");
            $form->setType("dia_lot_numero", "textareastatic");
            $form->setType("dia_lot_bat", "textareastatic");
            $form->setType("dia_lot_etage", "textareastatic");
            $form->setType("dia_lot_quote_part", "textareastatic");
            $form->setType("dia_us_hab", "checkboxstatic");
            $form->setType("dia_us_pro", "checkboxstatic");
            $form->setType("dia_us_mixte", "checkboxstatic");
            $form->setType("dia_us_comm", "checkboxstatic");
            $form->setType("dia_us_agr", "checkboxstatic");
            $form->setType("dia_us_autre", "checkboxstatic");
            $form->setType("dia_us_autre_prec", "textareastatic");
            $form->setType("dia_occ_prop", "checkboxstatic");
            $form->setType("dia_occ_loc", "checkboxstatic");
            $form->setType("dia_occ_sans_occ", "checkboxstatic");
            $form->setType("dia_occ_autre", "checkboxstatic");
            $form->setType("dia_occ_autre_prec", "textareastatic");
            $form->setType("dia_mod_cess_prix_vente", "static");
            $form->setType("dia_mod_cess_prix_vente_mob", "static");
            $form->setType("dia_mod_cess_prix_vente_cheptel", "static");
            $form->setType("dia_mod_cess_prix_vente_recol", "static");
            $form->setType("dia_mod_cess_prix_vente_autre", "static");
            $form->setType("dia_mod_cess_commi", "checkboxstatic");
            $form->setType("dia_mod_cess_commi_ttc", "static");
            $form->setType("dia_mod_cess_commi_ht", "static");
            $form->setType("dia_acquereur_nom_prenom", "static");
            $form->setType("dia_acquereur_adr_num_voie", "static");
            $form->setType("dia_acquereur_adr_ext", "static");
            $form->setType("dia_acquereur_adr_type_voie", "static");
            $form->setType("dia_acquereur_adr_nom_voie", "static");
            $form->setType("dia_acquereur_adr_lieu_dit_bp", "static");
            $form->setType("dia_acquereur_adr_cp", "static");
            $form->setType("dia_acquereur_adr_localite", "static");
            $form->setType("dia_observation", "textareastatic");
            $form->setType("su2_avt_shon1", "static");
            $form->setType("su2_avt_shon2", "static");
            $form->setType("su2_avt_shon3", "static");
            $form->setType("su2_avt_shon4", "static");
            $form->setType("su2_avt_shon5", "static");
            $form->setType("su2_avt_shon6", "static");
            $form->setType("su2_avt_shon7", "static");
            $form->setType("su2_avt_shon8", "static");
            $form->setType("su2_avt_shon9", "static");
            $form->setType("su2_avt_shon10", "static");
            $form->setType("su2_avt_shon11", "static");
            $form->setType("su2_avt_shon12", "static");
            $form->setType("su2_avt_shon13", "static");
            $form->setType("su2_avt_shon14", "static");
            $form->setType("su2_avt_shon15", "static");
            $form->setType("su2_avt_shon16", "static");
            $form->setType("su2_avt_shon17", "static");
            $form->setType("su2_avt_shon18", "static");
            $form->setType("su2_avt_shon19", "static");
            $form->setType("su2_avt_shon20", "static");
            $form->setType("su2_avt_shon_tot", "static");
            $form->setType("su2_cstr_shon1", "static");
            $form->setType("su2_cstr_shon2", "static");
            $form->setType("su2_cstr_shon3", "static");
            $form->setType("su2_cstr_shon4", "static");
            $form->setType("su2_cstr_shon5", "static");
            $form->setType("su2_cstr_shon6", "static");
            $form->setType("su2_cstr_shon7", "static");
            $form->setType("su2_cstr_shon8", "static");
            $form->setType("su2_cstr_shon9", "static");
            $form->setType("su2_cstr_shon10", "static");
            $form->setType("su2_cstr_shon11", "static");
            $form->setType("su2_cstr_shon12", "static");
            $form->setType("su2_cstr_shon13", "static");
            $form->setType("su2_cstr_shon14", "static");
            $form->setType("su2_cstr_shon15", "static");
            $form->setType("su2_cstr_shon16", "static");
            $form->setType("su2_cstr_shon17", "static");
            $form->setType("su2_cstr_shon18", "static");
            $form->setType("su2_cstr_shon19", "static");
            $form->setType("su2_cstr_shon20", "static");
            $form->setType("su2_cstr_shon_tot", "static");
            $form->setType("su2_chge_shon1", "static");
            $form->setType("su2_chge_shon2", "static");
            $form->setType("su2_chge_shon3", "static");
            $form->setType("su2_chge_shon4", "static");
            $form->setType("su2_chge_shon5", "static");
            $form->setType("su2_chge_shon6", "static");
            $form->setType("su2_chge_shon7", "static");
            $form->setType("su2_chge_shon8", "static");
            $form->setType("su2_chge_shon9", "static");
            $form->setType("su2_chge_shon10", "static");
            $form->setType("su2_chge_shon11", "static");
            $form->setType("su2_chge_shon12", "static");
            $form->setType("su2_chge_shon13", "static");
            $form->setType("su2_chge_shon14", "static");
            $form->setType("su2_chge_shon15", "static");
            $form->setType("su2_chge_shon16", "static");
            $form->setType("su2_chge_shon17", "static");
            $form->setType("su2_chge_shon18", "static");
            $form->setType("su2_chge_shon19", "static");
            $form->setType("su2_chge_shon20", "static");
            $form->setType("su2_chge_shon_tot", "static");
            $form->setType("su2_demo_shon1", "static");
            $form->setType("su2_demo_shon2", "static");
            $form->setType("su2_demo_shon3", "static");
            $form->setType("su2_demo_shon4", "static");
            $form->setType("su2_demo_shon5", "static");
            $form->setType("su2_demo_shon6", "static");
            $form->setType("su2_demo_shon7", "static");
            $form->setType("su2_demo_shon8", "static");
            $form->setType("su2_demo_shon9", "static");
            $form->setType("su2_demo_shon10", "static");
            $form->setType("su2_demo_shon11", "static");
            $form->setType("su2_demo_shon12", "static");
            $form->setType("su2_demo_shon13", "static");
            $form->setType("su2_demo_shon14", "static");
            $form->setType("su2_demo_shon15", "static");
            $form->setType("su2_demo_shon16", "static");
            $form->setType("su2_demo_shon17", "static");
            $form->setType("su2_demo_shon18", "static");
            $form->setType("su2_demo_shon19", "static");
            $form->setType("su2_demo_shon20", "static");
            $form->setType("su2_demo_shon_tot", "static");
            $form->setType("su2_sup_shon1", "static");
            $form->setType("su2_sup_shon2", "static");
            $form->setType("su2_sup_shon3", "static");
            $form->setType("su2_sup_shon4", "static");
            $form->setType("su2_sup_shon5", "static");
            $form->setType("su2_sup_shon6", "static");
            $form->setType("su2_sup_shon7", "static");
            $form->setType("su2_sup_shon8", "static");
            $form->setType("su2_sup_shon9", "static");
            $form->setType("su2_sup_shon10", "static");
            $form->setType("su2_sup_shon11", "static");
            $form->setType("su2_sup_shon12", "static");
            $form->setType("su2_sup_shon13", "static");
            $form->setType("su2_sup_shon14", "static");
            $form->setType("su2_sup_shon15", "static");
            $form->setType("su2_sup_shon16", "static");
            $form->setType("su2_sup_shon17", "static");
            $form->setType("su2_sup_shon18", "static");
            $form->setType("su2_sup_shon19", "static");
            $form->setType("su2_sup_shon20", "static");
            $form->setType("su2_sup_shon_tot", "static");
            $form->setType("su2_tot_shon1", "static");
            $form->setType("su2_tot_shon2", "static");
            $form->setType("su2_tot_shon3", "static");
            $form->setType("su2_tot_shon4", "static");
            $form->setType("su2_tot_shon5", "static");
            $form->setType("su2_tot_shon6", "static");
            $form->setType("su2_tot_shon7", "static");
            $form->setType("su2_tot_shon8", "static");
            $form->setType("su2_tot_shon9", "static");
            $form->setType("su2_tot_shon10", "static");
            $form->setType("su2_tot_shon11", "static");
            $form->setType("su2_tot_shon12", "static");
            $form->setType("su2_tot_shon13", "static");
            $form->setType("su2_tot_shon14", "static");
            $form->setType("su2_tot_shon15", "static");
            $form->setType("su2_tot_shon16", "static");
            $form->setType("su2_tot_shon17", "static");
            $form->setType("su2_tot_shon18", "static");
            $form->setType("su2_tot_shon19", "static");
            $form->setType("su2_tot_shon20", "static");
            $form->setType("su2_tot_shon_tot", "static");
            $form->setType("dia_occ_sol_su_terre", "textareastatic");
            $form->setType("dia_occ_sol_su_pres", "textareastatic");
            $form->setType("dia_occ_sol_su_verger", "textareastatic");
            $form->setType("dia_occ_sol_su_vigne", "textareastatic");
            $form->setType("dia_occ_sol_su_bois", "textareastatic");
            $form->setType("dia_occ_sol_su_lande", "textareastatic");
            $form->setType("dia_occ_sol_su_carriere", "textareastatic");
            $form->setType("dia_occ_sol_su_eau_cadastree", "textareastatic");
            $form->setType("dia_occ_sol_su_jardin", "textareastatic");
            $form->setType("dia_occ_sol_su_terr_batir", "textareastatic");
            $form->setType("dia_occ_sol_su_terr_agr", "textareastatic");
            $form->setType("dia_occ_sol_su_sol", "textareastatic");
            $form->setType("dia_bati_vend_tot", "checkboxstatic");
            $form->setType("dia_bati_vend_tot_txt", "textareastatic");
            $form->setType("dia_su_co_sol", "textareastatic");
            $form->setType("dia_su_util_hab", "textareastatic");
            $form->setType("dia_nb_niv", "textareastatic");
            $form->setType("dia_nb_appart", "textareastatic");
            $form->setType("dia_nb_autre_loc", "textareastatic");
            $form->setType("dia_vente_lot_volume", "checkboxstatic");
            $form->setType("dia_vente_lot_volume_txt", "textareastatic");
            $form->setType("dia_lot_nat_su", "textareastatic");
            $form->setType("dia_lot_bat_achv_plus_10", "checkboxstatic");
            $form->setType("dia_lot_bat_achv_moins_10", "checkboxstatic");
            $form->setType("dia_lot_regl_copro_publ_hypo_plus_10", "checkboxstatic");
            $form->setType("dia_lot_regl_copro_publ_hypo_moins_10", "checkboxstatic");
            $form->setType("dia_indivi_quote_part", "textareastatic");
            $form->setType("dia_design_societe", "textareastatic");
            $form->setType("dia_design_droit", "textareastatic");
            $form->setType("dia_droit_soc_nat", "textareastatic");
            $form->setType("dia_droit_soc_nb", "textareastatic");
            $form->setType("dia_droit_soc_num_part", "textareastatic");
            $form->setType("dia_droit_reel_perso_grevant_bien_oui", "checkboxstatic");
            $form->setType("dia_droit_reel_perso_grevant_bien_non", "checkboxstatic");
            $form->setType("dia_droit_reel_perso_nat", "textareastatic");
            $form->setType("dia_droit_reel_perso_viag", "textareastatic");
            $form->setType("dia_mod_cess_adr", "textareastatic");
            $form->setType("dia_mod_cess_sign_act_auth", "checkboxstatic");
            $form->setType("dia_mod_cess_terme", "checkboxstatic");
            $form->setType("dia_mod_cess_terme_prec", "textareastatic");
            $form->setType("dia_mod_cess_bene_acquereur", "checkboxstatic");
            $form->setType("dia_mod_cess_bene_vendeur", "checkboxstatic");
            $form->setType("dia_mod_cess_paie_nat", "checkboxstatic");
            $form->setType("dia_mod_cess_design_contr_alien", "textareastatic");
            $form->setType("dia_mod_cess_eval_contr", "textareastatic");
            $form->setType("dia_mod_cess_rente_viag", "checkboxstatic");
            $form->setType("dia_mod_cess_mnt_an", "textareastatic");
            $form->setType("dia_mod_cess_mnt_compt", "textareastatic");
            $form->setType("dia_mod_cess_bene_rente", "textareastatic");
            $form->setType("dia_mod_cess_droit_usa_hab", "checkboxstatic");
            $form->setType("dia_mod_cess_droit_usa_hab_prec", "textareastatic");
            $form->setType("dia_mod_cess_eval_usa_usufruit", "textareastatic");
            $form->setType("dia_mod_cess_vente_nue_prop", "checkboxstatic");
            $form->setType("dia_mod_cess_vente_nue_prop_prec", "textareastatic");
            $form->setType("dia_mod_cess_echange", "checkboxstatic");
            $form->setType("dia_mod_cess_design_bien_recus_ech", "textareastatic");
            $form->setType("dia_mod_cess_mnt_soulte", "textareastatic");
            $form->setType("dia_mod_cess_prop_contre_echan", "textareastatic");
            $form->setType("dia_mod_cess_apport_societe", "textareastatic");
            $form->setType("dia_mod_cess_bene", "textareastatic");
            $form->setType("dia_mod_cess_esti_bien", "textareastatic");
            $form->setType("dia_mod_cess_cess_terr_loc_co", "checkboxstatic");
            $form->setType("dia_mod_cess_esti_terr", "textareastatic");
            $form->setType("dia_mod_cess_esti_loc", "textareastatic");
            $form->setType("dia_mod_cess_esti_imm_loca", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_vol", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_obl", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_fin_indivi", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_date_lieu", "textareastatic");
            $form->setType("dia_mod_cess_mnt_mise_prix", "textareastatic");
            $form->setType("dia_prop_titu_prix_indique", "checkboxstatic");
            $form->setType("dia_prop_recherche_acqu_prix_indique", "checkboxstatic");
            $form->setType("dia_acquereur_prof", "textareastatic");
            $form->setType("dia_indic_compl_ope", "textareastatic");
            $form->setType("dia_vente_adju", "checkboxstatic");
            $form->setType("am_terr_res_demon", "checkboxstatic");
            $form->setType("am_air_terr_res_mob", "checkboxstatic");
            $form->setType("ctx_objet_recours", "selectstatic");
            $form->setType("ctx_reference_sagace", "static");
            $form->setType("ctx_nature_travaux_infra_om_html", "htmlstatic");
            $form->setType("ctx_synthese_nti", "textareastatic");
            $form->setType("ctx_article_non_resp_om_html", "htmlstatic");
            $form->setType("ctx_synthese_anr", "textareastatic");
            $form->setType("ctx_reference_parquet", "static");
            $form->setType("ctx_element_taxation", "static");
            $form->setType("ctx_infraction", "checkboxstatic");
            $form->setType("ctx_regularisable", "checkboxstatic");
            $form->setType("ctx_reference_courrier", "static");
            $form->setType("ctx_date_audience", "datestatic");
            $form->setType("ctx_date_ajournement", "datestatic");
            $form->setType("exo_facul_1", "checkboxstatic");
            $form->setType("exo_facul_2", "checkboxstatic");
            $form->setType("exo_facul_3", "checkboxstatic");
            $form->setType("exo_facul_4", "checkboxstatic");
            $form->setType("exo_facul_5", "checkboxstatic");
            $form->setType("exo_facul_6", "checkboxstatic");
            $form->setType("exo_facul_7", "checkboxstatic");
            $form->setType("exo_facul_8", "checkboxstatic");
            $form->setType("exo_facul_9", "checkboxstatic");
            $form->setType("exo_ta_1", "checkboxstatic");
            $form->setType("exo_ta_2", "checkboxstatic");
            $form->setType("exo_ta_3", "checkboxstatic");
            $form->setType("exo_ta_4", "checkboxstatic");
            $form->setType("exo_ta_5", "checkboxstatic");
            $form->setType("exo_ta_6", "checkboxstatic");
            $form->setType("exo_ta_7", "checkboxstatic");
            $form->setType("exo_ta_8", "checkboxstatic");
            $form->setType("exo_ta_9", "checkboxstatic");
            $form->setType("exo_rap_1", "checkboxstatic");
            $form->setType("exo_rap_2", "checkboxstatic");
            $form->setType("exo_rap_3", "checkboxstatic");
            $form->setType("exo_rap_4", "checkboxstatic");
            $form->setType("exo_rap_5", "checkboxstatic");
            $form->setType("exo_rap_6", "checkboxstatic");
            $form->setType("exo_rap_7", "checkboxstatic");
            $form->setType("exo_rap_8", "checkboxstatic");
            $form->setType("mtn_exo_ta_part_commu", "static");
            $form->setType("mtn_exo_ta_part_depart", "static");
            $form->setType("mtn_exo_ta_part_reg", "static");
            $form->setType("mtn_exo_rap", "static");
            $form->setType("dpc_type", "static");
            $form->setType("dpc_desc_actv_ex", "textareastatic");
            $form->setType("dpc_desc_ca", "textareastatic");
            $form->setType("dpc_desc_aut_prec", "textareastatic");
            $form->setType("dpc_desig_comm_arti", "checkboxstatic");
            $form->setType("dpc_desig_loc_hab", "checkboxstatic");
            $form->setType("dpc_desig_loc_ann", "checkboxstatic");
            $form->setType("dpc_desig_loc_ann_prec", "textareastatic");
            $form->setType("dpc_bail_comm_date", "datestatic");
            $form->setType("dpc_bail_comm_loyer", "textareastatic");
            $form->setType("dpc_actv_acqu", "textareastatic");
            $form->setType("dpc_nb_sala_di", "textareastatic");
            $form->setType("dpc_nb_sala_dd", "textareastatic");
            $form->setType("dpc_nb_sala_tc", "textareastatic");
            $form->setType("dpc_nb_sala_tp", "textareastatic");
            $form->setType("dpc_moda_cess_vente_am", "checkboxstatic");
            $form->setType("dpc_moda_cess_adj", "checkboxstatic");
            $form->setType("dpc_moda_cess_prix", "textareastatic");
            $form->setType("dpc_moda_cess_adj_date", "datestatic");
            $form->setType("dpc_moda_cess_adj_prec", "textareastatic");
            $form->setType("dpc_moda_cess_paie_comp", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_terme", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_terme_prec", "textareastatic");
            $form->setType("dpc_moda_cess_paie_nat", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien_prec", "textareastatic");
            $form->setType("dpc_moda_cess_paie_nat_eval", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_nat_eval_prec", "textareastatic");
            $form->setType("dpc_moda_cess_paie_aut", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_aut_prec", "textareastatic");
            $form->setType("dpc_ss_signe_demande_acqu", "checkboxstatic");
            $form->setType("dpc_ss_signe_recher_trouv_acqu", "checkboxstatic");
            $form->setType("dpc_notif_adr_prop", "checkboxstatic");
            $form->setType("dpc_notif_adr_manda", "checkboxstatic");
            $form->setType("dpc_obs", "textareastatic");
            $form->setType("co_peri_site_patri_remar", "checkboxstatic");
            $form->setType("co_abo_monu_hist", "checkboxstatic");
            $form->setType("co_inst_ouvr_trav_act_code_envir", "checkboxstatic");
            $form->setType("co_trav_auto_env", "checkboxstatic");
            $form->setType("co_derog_esp_prot", "checkboxstatic");
            $form->setType("ctx_reference_dsj", "static");
            $form->setType("co_piscine", "checkboxstatic");
            $form->setType("co_fin_lls", "checkboxstatic");
            $form->setType("co_fin_aa", "checkboxstatic");
            $form->setType("co_fin_ptz", "checkboxstatic");
            $form->setType("co_fin_autr", "textareastatic");
            $form->setType("dia_ss_date", "datestatic");
            $form->setType("dia_ss_lieu", "static");
            $form->setType("enga_decla_lieu", "static");
            $form->setType("enga_decla_date", "datestatic");
            $form->setType("co_archi_attest_honneur", "checkboxstatic");
            $form->setType("co_bat_niv_dessous_nb", "static");
            $form->setType("co_install_classe", "checkboxstatic");
            $form->setType("co_derog_innov", "checkboxstatic");
            $form->setType("co_avis_abf", "checkboxstatic");
            $form->setType("tax_surf_tot_demo", "static");
            $form->setType("tax_surf_tax_demo", "static");
            $form->setType("tax_su_non_habit_surf8", "static");
            $form->setType("tax_su_non_habit_surf_stat8", "static");
            $form->setType("tax_su_non_habit_surf9", "static");
            $form->setType("tax_su_non_habit_surf_stat9", "static");
            $form->setType("tax_terrassement_arch", "checkboxstatic");
            $form->setType("tax_adresse_future_numero", "static");
            $form->setType("tax_adresse_future_voie", "static");
            $form->setType("tax_adresse_future_lieudit", "static");
            $form->setType("tax_adresse_future_localite", "static");
            $form->setType("tax_adresse_future_cp", "static");
            $form->setType("tax_adresse_future_bp", "static");
            $form->setType("tax_adresse_future_cedex", "static");
            $form->setType("tax_adresse_future_pays", "static");
            $form->setType("tax_adresse_future_division", "static");
            $form->setType("co_bat_projete", "textareastatic");
            $form->setType("co_bat_existant", "textareastatic");
            $form->setType("co_bat_nature", "textareastatic");
            $form->setType("terr_juri_titul_date", "datestatic");
            $form->setType("co_autre_desc", "textareastatic");
            $form->setType("co_trx_autre", "textareastatic");
            $form->setType("co_autre", "checkboxstatic");
            $form->setType("erp_modif_facades", "checkboxstatic");
            $form->setType("erp_trvx_adap", "checkboxstatic");
            $form->setType("erp_trvx_adap_numero", "static");
            $form->setType("erp_trvx_adap_valid", "datestatic");
            $form->setType("erp_prod_dangereux", "checkboxstatic");
            $form->setType("co_trav_supp_dessus", "static");
            $form->setType("co_trav_supp_dessous", "static");
            $form->setType("tax_su_habit_abr_jard_pig_colom", "static");
            $form->setType("enga_decla_donnees_nomi_comm", "checkboxstatic");
            $form->setType("x1l_legislation", "checkboxstatic");
            $form->setType("x1p_precisions", "static");
            $form->setType("x1u_raccordement", "checkboxstatic");
            $form->setType("x2m_inscritmh", "checkboxstatic");
            $form->setType("s1na1_numero", "static");
            $form->setType("s1va1_voie", "static");
            $form->setType("s1wa1_lieudit", "static");
            $form->setType("s1la1_localite", "static");
            $form->setType("s1pa1_codepostal", "static");
            $form->setType("s1na2_numero", "static");
            $form->setType("s1va2_voie", "static");
            $form->setType("s1wa2_lieudit", "static");
            $form->setType("s1la2_localite", "static");
            $form->setType("s1pa2_codepostal", "static");
            $form->setType("e3c_certification", "checkboxstatic");
            $form->setType("e3a_competence", "checkboxstatic");
            $form->setType("a4d_description", "static");
            $form->setType("m2b_abf", "checkboxstatic");
            $form->setType("m2j_pn", "checkboxstatic");
            $form->setType("m2r_cdac", "checkboxstatic");
            $form->setType("m2r_cnac", "checkboxstatic");
            $form->setType("u3a_voirieoui", "checkboxstatic");
            $form->setType("u3f_voirienon", "checkboxstatic");
            $form->setType("u3c_eauoui", "checkboxstatic");
            $form->setType("u3h_eaunon", "checkboxstatic");
            $form->setType("u3g_assainissementoui", "checkboxstatic");
            $form->setType("u3n_assainissementnon", "checkboxstatic");
            $form->setType("u3m_electriciteoui", "checkboxstatic");
            $form->setType("u3b_electricitenon", "checkboxstatic");
            $form->setType("u3t_observations", "static");
            $form->setType("u1a_voirieoui", "checkboxstatic");
            $form->setType("u1v_voirienon", "checkboxstatic");
            $form->setType("u1q_voirieconcessionnaire", "static");
            $form->setType("u1b_voirieavant", "datestatic");
            $form->setType("u1j_eauoui", "checkboxstatic");
            $form->setType("u1t_eaunon", "checkboxstatic");
            $form->setType("u1e_eauconcessionnaire", "static");
            $form->setType("u1k_eauavant", "datestatic");
            $form->setType("u1s_assainissementoui", "checkboxstatic");
            $form->setType("u1d_assainissementnon", "checkboxstatic");
            $form->setType("u1l_assainissementconcessionnaire", "static");
            $form->setType("u1r_assainissementavant", "datestatic");
            $form->setType("u1c_electriciteoui", "checkboxstatic");
            $form->setType("u1u_electricitenon", "checkboxstatic");
            $form->setType("u1m_electriciteconcessionnaire", "static");
            $form->setType("u1f_electriciteavant", "datestatic");
            $form->setType("u2a_observations", "static");
            $form->setType("f1ts4_surftaxestation", "static");
            $form->setType("f1ut1_surfcree", "static");
            $form->setType("f9d_date", "datestatic");
            $form->setType("f9n_nom", "static");
            $form->setType("su2_avt_shon21", "static");
            $form->setType("su2_avt_shon22", "static");
            $form->setType("su2_cstr_shon21", "static");
            $form->setType("su2_cstr_shon22", "static");
            $form->setType("su2_chge_shon21", "static");
            $form->setType("su2_chge_shon22", "static");
            $form->setType("su2_demo_shon21", "static");
            $form->setType("su2_demo_shon22", "static");
            $form->setType("su2_sup_shon21", "static");
            $form->setType("su2_sup_shon22", "static");
            $form->setType("su2_tot_shon21", "static");
            $form->setType("su2_tot_shon22", "static");
            $form->setType("f1gu1_f1gu2_f1gu3", "static");
            $form->setType("f1lu1_f1lu2_f1lu3", "static");
            $form->setType("f1zu1_f1zu2_f1zu3", "static");
            $form->setType("f1pu1_f1pu2_f1pu3", "static");
            $form->setType("f1gt4_f1gt5_f1gt6", "static");
            $form->setType("f1lt4_f1lt5_f1lt6", "static");
            $form->setType("f1zt4_f1zt5_f1zt6", "static");
            $form->setType("f1pt4_f1pt5_f1pt6", "static");
            $form->setType("f1xu1_f1xu2_f1xu3", "static");
            $form->setType("f1xt4_f1xt5_f1xt6", "static");
            $form->setType("f1hu1_f1hu2_f1hu3", "static");
            $form->setType("f1mu1_f1mu2_f1mu3", "static");
            $form->setType("f1qu1_f1qu2_f1qu3", "static");
            $form->setType("f1ht4_f1ht5_f1ht6", "static");
            $form->setType("f1mt4_f1mt5_f1mt6", "static");
            $form->setType("f1qt4_f1qt5_f1qt6", "static");
            $form->setType("f2cu1_f2cu2_f2cu3", "static");
            $form->setType("f2bu1_f2bu2_f2bu3", "static");
            $form->setType("f2su1_f2su2_f2su3", "static");
            $form->setType("f2hu1_f2hu2_f2hu3", "static");
            $form->setType("f2eu1_f2eu2_f2eu3", "static");
            $form->setType("f2qu1_f2qu2_f2qu3", "static");
            $form->setType("f2ct4_f2ct5_f2ct6", "static");
            $form->setType("f2bt4_f2bt5_f2bt6", "static");
            $form->setType("f2st4_f2st5_f2st6", "static");
            $form->setType("f2ht4_f2ht5_f2ht6", "static");
            $form->setType("f2et4_f2et5_f2et6", "static");
            $form->setType("f2qt4_f2qt5_f2qt6", "static");
            $form->setType("dia_droit_reel_perso_grevant_bien_desc", "textareastatic");
            $form->setType("dia_mod_cess_paie_nat_desc", "textareastatic");
            $form->setType("dia_mod_cess_rente_viag_desc", "textareastatic");
            $form->setType("dia_mod_cess_echange_desc", "textareastatic");
            $form->setType("dia_mod_cess_apport_societe_desc", "textareastatic");
            $form->setType("dia_mod_cess_cess_terr_loc_co_desc", "textareastatic");
            $form->setType("dia_mod_cess_esti_imm_loca_desc", "textareastatic");
            $form->setType("dia_mod_cess_adju_obl_desc", "textareastatic");
            $form->setType("dia_mod_cess_adju_fin_indivi_desc", "textareastatic");
            $form->setType("dia_cadre_titul_droit_prempt", "textareastatic");
            $form->setType("dia_mairie_prix_moyen", "static");
            $form->setType("dia_propri_indivi", "textareastatic");
            $form->setType("dia_situa_bien_plan_cadas_oui", "checkboxstatic");
            $form->setType("dia_situa_bien_plan_cadas_non", "checkboxstatic");
            $form->setType("dia_notif_dec_titul_adr_prop", "checkboxstatic");
            $form->setType("dia_notif_dec_titul_adr_prop_desc", "textareastatic");
            $form->setType("dia_notif_dec_titul_adr_manda", "checkboxstatic");
            $form->setType("dia_notif_dec_titul_adr_manda_desc", "textareastatic");
            $form->setType("dia_dia_dpu", "checkboxstatic");
            $form->setType("dia_dia_zad", "checkboxstatic");
            $form->setType("dia_dia_zone_preempt_esp_natu_sensi", "checkboxstatic");
            $form->setType("dia_dab_dpu", "checkboxstatic");
            $form->setType("dia_dab_zad", "checkboxstatic");
            $form->setType("dia_mod_cess_commi_mnt", "static");
            $form->setType("dia_mod_cess_commi_mnt_ttc", "checkboxstatic");
            $form->setType("dia_mod_cess_commi_mnt_ht", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_num", "static");
            $form->setType("dia_mod_cess_prix_vente_mob_num", "static");
            $form->setType("dia_mod_cess_prix_vente_cheptel_num", "static");
            $form->setType("dia_mod_cess_prix_vente_recol_num", "static");
            $form->setType("dia_mod_cess_prix_vente_autre_num", "static");
            $form->setType("dia_su_co_sol_num", "static");
            $form->setType("dia_su_util_hab_num", "static");
            $form->setType("dia_mod_cess_mnt_an_num", "static");
            $form->setType("dia_mod_cess_mnt_compt_num", "static");
            $form->setType("dia_mod_cess_mnt_soulte_num", "static");
            $form->setType("dia_comp_prix_vente", "static");
            $form->setType("dia_comp_surface", "static");
            $form->setType("dia_comp_total_frais", "static");
            $form->setType("dia_comp_mtn_total", "static");
            $form->setType("dia_comp_valeur_m2", "static");
            $form->setType("dia_esti_prix_france_dom", "static");
            $form->setType("dia_prop_collectivite", "static");
            $form->setType("dia_delegataire_denomination", "static");
            $form->setType("dia_delegataire_raison_sociale", "static");
            $form->setType("dia_delegataire_siret", "static");
            $form->setType("dia_delegataire_categorie_juridique", "static");
            $form->setType("dia_delegataire_representant_nom", "static");
            $form->setType("dia_delegataire_representant_prenom", "static");
            $form->setType("dia_delegataire_adresse_numero", "static");
            $form->setType("dia_delegataire_adresse_voie", "static");
            $form->setType("dia_delegataire_adresse_complement", "static");
            $form->setType("dia_delegataire_adresse_lieu_dit", "static");
            $form->setType("dia_delegataire_adresse_localite", "static");
            $form->setType("dia_delegataire_adresse_code_postal", "static");
            $form->setType("dia_delegataire_adresse_bp", "static");
            $form->setType("dia_delegataire_adresse_cedex", "static");
            $form->setType("dia_delegataire_adresse_pays", "static");
            $form->setType("dia_delegataire_telephone_fixe", "static");
            $form->setType("dia_delegataire_telephone_mobile", "static");
            $form->setType("dia_delegataire_telephone_mobile_indicatif", "static");
            $form->setType("dia_delegataire_courriel", "static");
            $form->setType("dia_delegataire_fax", "static");
            $form->setType("dia_entree_jouissance_type", "static");
            $form->setType("dia_entree_jouissance_date", "datestatic");
            $form->setType("dia_entree_jouissance_date_effet", "datestatic");
            $form->setType("dia_entree_jouissance_com", "textareastatic");
            $form->setType("dia_remise_bien_date_effet", "datestatic");
            $form->setType("dia_remise_bien_com", "textareastatic");
            $form->setType("c2zp1_crete", "static");
            $form->setType("c2zr1_destination", "static");
            $form->setType("mh_design_appel_denom", "textareastatic");
            $form->setType("mh_design_type_protect", "static");
            $form->setType("mh_design_elem_prot", "textareastatic");
            $form->setType("mh_design_ref_merimee_palissy", "static");
            $form->setType("mh_design_nature_prop", "static");
            $form->setType("mh_loc_denom", "textareastatic");
            $form->setType("mh_pres_intitule", "textareastatic");
            $form->setType("mh_trav_cat_1", "checkboxstatic");
            $form->setType("mh_trav_cat_2", "checkboxstatic");
            $form->setType("mh_trav_cat_3", "checkboxstatic");
            $form->setType("mh_trav_cat_4", "checkboxstatic");
            $form->setType("mh_trav_cat_5", "checkboxstatic");
            $form->setType("mh_trav_cat_6", "checkboxstatic");
            $form->setType("mh_trav_cat_7", "checkboxstatic");
            $form->setType("mh_trav_cat_8", "checkboxstatic");
            $form->setType("mh_trav_cat_9", "checkboxstatic");
            $form->setType("mh_trav_cat_10", "checkboxstatic");
            $form->setType("mh_trav_cat_11", "checkboxstatic");
            $form->setType("mh_trav_cat_12", "checkboxstatic");
            $form->setType("mh_trav_cat_12_prec", "textareastatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('donnees_techniques','VerifNum(this)');
        $form->setOnchange('lot','VerifNum(this)');
        $form->setOnchange('am_carav_duree','VerifNum(this)');
        $form->setOnchange('am_statio_cont','VerifNum(this)');
        $form->setOnchange('am_affou_exhau_sup','VerifFloat(this)');
        $form->setOnchange('am_affou_prof','VerifFloat(this)');
        $form->setOnchange('am_exhau_haut','VerifFloat(this)');
        $form->setOnchange('am_terr_surf','VerifFloat(this)');
        $form->setOnchange('am_lot_max_nb','VerifNum(this)');
        $form->setOnchange('am_lot_max_shon','VerifFloat(this)');
        $form->setOnchange('am_empl_nb','VerifNum(this)');
        $form->setOnchange('am_tente_nb','VerifNum(this)');
        $form->setOnchange('am_carav_nb','VerifNum(this)');
        $form->setOnchange('am_mobil_nb','VerifNum(this)');
        $form->setOnchange('am_pers_nb','VerifNum(this)');
        $form->setOnchange('am_empl_hll_nb','VerifNum(this)');
        $form->setOnchange('am_hll_shon','VerifFloat(this)');
        $form->setOnchange('am_exist_nb_avant','VerifNum(this)');
        $form->setOnchange('am_exist_nb_apres','VerifNum(this)');
        $form->setOnchange('co_elec_tension','VerifFloat(this)');
        $form->setOnchange('co_tot_log_nb','VerifNum(this)');
        $form->setOnchange('co_tot_ind_nb','VerifNum(this)');
        $form->setOnchange('co_tot_coll_nb','VerifNum(this)');
        $form->setOnchange('co_mais_piece_nb','VerifNum(this)');
        $form->setOnchange('co_mais_niv_nb','VerifNum(this)');
        $form->setOnchange('co_fin_lls_nb','VerifNum(this)');
        $form->setOnchange('co_fin_aa_nb','VerifNum(this)');
        $form->setOnchange('co_fin_ptz_nb','VerifNum(this)');
        $form->setOnchange('co_fin_autr_nb','VerifNum(this)');
        $form->setOnchange('co_foyer_chamb_nb','VerifNum(this)');
        $form->setOnchange('co_log_1p_nb','VerifNum(this)');
        $form->setOnchange('co_log_2p_nb','VerifNum(this)');
        $form->setOnchange('co_log_3p_nb','VerifNum(this)');
        $form->setOnchange('co_log_4p_nb','VerifNum(this)');
        $form->setOnchange('co_log_5p_nb','VerifNum(this)');
        $form->setOnchange('co_log_6p_nb','VerifNum(this)');
        $form->setOnchange('co_bat_niv_nb','VerifNum(this)');
        $form->setOnchange('co_statio_avt_nb','VerifNum(this)');
        $form->setOnchange('co_statio_apr_nb','VerifNum(this)');
        $form->setOnchange('co_statio_place_nb','VerifNum(this)');
        $form->setOnchange('co_statio_tot_surf','VerifFloat(this)');
        $form->setOnchange('co_statio_tot_shob','VerifFloat(this)');
        $form->setOnchange('co_statio_comm_cin_surf','VerifFloat(this)');
        $form->setOnchange('su_avt_shon1','VerifFloat(this)');
        $form->setOnchange('su_avt_shon2','VerifFloat(this)');
        $form->setOnchange('su_avt_shon3','VerifFloat(this)');
        $form->setOnchange('su_avt_shon4','VerifFloat(this)');
        $form->setOnchange('su_avt_shon5','VerifFloat(this)');
        $form->setOnchange('su_avt_shon6','VerifFloat(this)');
        $form->setOnchange('su_avt_shon7','VerifFloat(this)');
        $form->setOnchange('su_avt_shon8','VerifFloat(this)');
        $form->setOnchange('su_avt_shon9','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon1','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon2','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon3','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon4','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon5','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon6','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon7','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon8','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon9','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon1','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon2','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon3','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon4','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon5','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon6','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon7','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon8','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon9','VerifFloat(this)');
        $form->setOnchange('su_chge_shon1','VerifFloat(this)');
        $form->setOnchange('su_chge_shon2','VerifFloat(this)');
        $form->setOnchange('su_chge_shon3','VerifFloat(this)');
        $form->setOnchange('su_chge_shon4','VerifFloat(this)');
        $form->setOnchange('su_chge_shon5','VerifFloat(this)');
        $form->setOnchange('su_chge_shon6','VerifFloat(this)');
        $form->setOnchange('su_chge_shon7','VerifFloat(this)');
        $form->setOnchange('su_chge_shon8','VerifFloat(this)');
        $form->setOnchange('su_chge_shon9','VerifFloat(this)');
        $form->setOnchange('su_demo_shon1','VerifFloat(this)');
        $form->setOnchange('su_demo_shon2','VerifFloat(this)');
        $form->setOnchange('su_demo_shon3','VerifFloat(this)');
        $form->setOnchange('su_demo_shon4','VerifFloat(this)');
        $form->setOnchange('su_demo_shon5','VerifFloat(this)');
        $form->setOnchange('su_demo_shon6','VerifFloat(this)');
        $form->setOnchange('su_demo_shon7','VerifFloat(this)');
        $form->setOnchange('su_demo_shon8','VerifFloat(this)');
        $form->setOnchange('su_demo_shon9','VerifFloat(this)');
        $form->setOnchange('su_sup_shon1','VerifFloat(this)');
        $form->setOnchange('su_sup_shon2','VerifFloat(this)');
        $form->setOnchange('su_sup_shon3','VerifFloat(this)');
        $form->setOnchange('su_sup_shon4','VerifFloat(this)');
        $form->setOnchange('su_sup_shon5','VerifFloat(this)');
        $form->setOnchange('su_sup_shon6','VerifFloat(this)');
        $form->setOnchange('su_sup_shon7','VerifFloat(this)');
        $form->setOnchange('su_sup_shon8','VerifFloat(this)');
        $form->setOnchange('su_sup_shon9','VerifFloat(this)');
        $form->setOnchange('su_tot_shon1','VerifFloat(this)');
        $form->setOnchange('su_tot_shon2','VerifFloat(this)');
        $form->setOnchange('su_tot_shon3','VerifFloat(this)');
        $form->setOnchange('su_tot_shon4','VerifFloat(this)');
        $form->setOnchange('su_tot_shon5','VerifFloat(this)');
        $form->setOnchange('su_tot_shon6','VerifFloat(this)');
        $form->setOnchange('su_tot_shon7','VerifFloat(this)');
        $form->setOnchange('su_tot_shon8','VerifFloat(this)');
        $form->setOnchange('su_tot_shon9','VerifFloat(this)');
        $form->setOnchange('su_avt_shon_tot','VerifFloat(this)');
        $form->setOnchange('su_cstr_shon_tot','VerifFloat(this)');
        $form->setOnchange('su_trsf_shon_tot','VerifFloat(this)');
        $form->setOnchange('su_chge_shon_tot','VerifFloat(this)');
        $form->setOnchange('su_demo_shon_tot','VerifFloat(this)');
        $form->setOnchange('su_sup_shon_tot','VerifFloat(this)');
        $form->setOnchange('su_tot_shon_tot','VerifFloat(this)');
        $form->setOnchange('dm_tot_log_nb','VerifNum(this)');
        $form->setOnchange('tax_surf_tot','VerifFloat(this)');
        $form->setOnchange('tax_surf','VerifFloat(this)');
        $form->setOnchange('tax_surf_suppr_mod','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_log_nb1','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_log_nb2','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_log_nb3','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_log_nb4','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_log_nb_tot1','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_log_nb_tot2','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_log_nb_tot3','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_log_nb_tot4','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf1','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf2','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf3','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf4','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf_sup1','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf_sup2','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf_sup3','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf_sup4','VerifFloat(this)');
        $form->setOnchange('tax_su_heber_log_nb1','VerifNum(this)');
        $form->setOnchange('tax_su_heber_log_nb2','VerifNum(this)');
        $form->setOnchange('tax_su_heber_log_nb3','VerifNum(this)');
        $form->setOnchange('tax_su_heber_log_nb_tot1','VerifNum(this)');
        $form->setOnchange('tax_su_heber_log_nb_tot2','VerifNum(this)');
        $form->setOnchange('tax_su_heber_log_nb_tot3','VerifNum(this)');
        $form->setOnchange('tax_su_heber_surf1','VerifFloat(this)');
        $form->setOnchange('tax_su_heber_surf2','VerifFloat(this)');
        $form->setOnchange('tax_su_heber_surf3','VerifFloat(this)');
        $form->setOnchange('tax_su_heber_surf_sup1','VerifFloat(this)');
        $form->setOnchange('tax_su_heber_surf_sup2','VerifFloat(this)');
        $form->setOnchange('tax_su_heber_surf_sup3','VerifFloat(this)');
        $form->setOnchange('tax_su_secon_log_nb','VerifNum(this)');
        $form->setOnchange('tax_su_tot_log_nb','VerifNum(this)');
        $form->setOnchange('tax_su_secon_log_nb_tot','VerifNum(this)');
        $form->setOnchange('tax_su_tot_log_nb_tot','VerifNum(this)');
        $form->setOnchange('tax_su_secon_surf','VerifFloat(this)');
        $form->setOnchange('tax_su_tot_surf','VerifFloat(this)');
        $form->setOnchange('tax_su_secon_surf_sup','VerifFloat(this)');
        $form->setOnchange('tax_su_tot_surf_sup','VerifFloat(this)');
        $form->setOnchange('tax_surf_tax_exist_cons','VerifFloat(this)');
        $form->setOnchange('tax_log_exist_nb','VerifNum(this)');
        $form->setOnchange('tax_am_statio_ext','VerifNum(this)');
        $form->setOnchange('tax_sup_bass_pisc','VerifFloat(this)');
        $form->setOnchange('tax_empl_ten_carav_mobil_nb','VerifNum(this)');
        $form->setOnchange('tax_empl_hll_nb','VerifNum(this)');
        $form->setOnchange('tax_eol_haut_nb','VerifNum(this)');
        $form->setOnchange('tax_pann_volt_sup','VerifFloat(this)');
        $form->setOnchange('tax_am_statio_ext_sup','VerifNum(this)');
        $form->setOnchange('tax_sup_bass_pisc_sup','VerifFloat(this)');
        $form->setOnchange('tax_empl_ten_carav_mobil_nb_sup','VerifNum(this)');
        $form->setOnchange('tax_empl_hll_nb_sup','VerifNum(this)');
        $form->setOnchange('tax_eol_haut_nb_sup','VerifNum(this)');
        $form->setOnchange('tax_pann_volt_sup_sup','VerifFloat(this)');
        $form->setOnchange('tax_comm_nb','VerifNum(this)');
        $form->setOnchange('tax_su_non_habit_surf1','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf2','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf3','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf4','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf5','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf6','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf7','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_sup1','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_sup2','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_sup3','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_sup4','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_sup5','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_sup6','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_sup7','VerifFloat(this)');
        $form->setOnchange('vsd_unit_fonc_sup','VerifFloat(this)');
        $form->setOnchange('vsd_unit_fonc_constr_sup','VerifFloat(this)');
        $form->setOnchange('vsd_val_terr','VerifFloat(this)');
        $form->setOnchange('vsd_const_sxist_non_dem_surf','VerifFloat(this)');
        $form->setOnchange('vsd_rescr_fisc','fdate(this)');
        $form->setOnchange('pld_val_terr','VerifFloat(this)');
        $form->setOnchange('pld_const_exist_dem_surf','VerifFloat(this)');
        $form->setOnchange('terr_div_surf_etab','VerifFloat(this)');
        $form->setOnchange('terr_div_surf_av_div','VerifFloat(this)');
        $form->setOnchange('doc_date','fdate(this)');
        $form->setOnchange('doc_surf','VerifFloat(this)');
        $form->setOnchange('doc_nb_log','VerifNum(this)');
        $form->setOnchange('doc_nb_log_indiv','VerifNum(this)');
        $form->setOnchange('doc_nb_log_coll','VerifNum(this)');
        $form->setOnchange('doc_nb_log_lls','VerifNum(this)');
        $form->setOnchange('doc_nb_log_aa','VerifNum(this)');
        $form->setOnchange('doc_nb_log_ptz','VerifNum(this)');
        $form->setOnchange('doc_nb_log_autre','VerifNum(this)');
        $form->setOnchange('daact_date','fdate(this)');
        $form->setOnchange('daact_date_chgmt_dest','fdate(this)');
        $form->setOnchange('daact_surf','VerifFloat(this)');
        $form->setOnchange('daact_nb_log','VerifNum(this)');
        $form->setOnchange('daact_nb_log_indiv','VerifNum(this)');
        $form->setOnchange('daact_nb_log_coll','VerifNum(this)');
        $form->setOnchange('daact_nb_log_lls','VerifNum(this)');
        $form->setOnchange('daact_nb_log_aa','VerifNum(this)');
        $form->setOnchange('daact_nb_log_ptz','VerifNum(this)');
        $form->setOnchange('daact_nb_log_autre','VerifNum(this)');
        $form->setOnchange('architecte','VerifNum(this)');
        $form->setOnchange('tax_surf_tot_cstr','VerifNum(this)');
        $form->setOnchange('cerfa','VerifNum(this)');
        $form->setOnchange('tax_surf_loc_stat','VerifNum(this)');
        $form->setOnchange('tax_su_princ_surf_stat1','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf_stat2','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf_stat3','VerifFloat(this)');
        $form->setOnchange('tax_su_princ_surf_stat4','VerifFloat(this)');
        $form->setOnchange('tax_su_secon_surf_stat','VerifFloat(this)');
        $form->setOnchange('tax_su_heber_surf_stat1','VerifFloat(this)');
        $form->setOnchange('tax_su_heber_surf_stat2','VerifFloat(this)');
        $form->setOnchange('tax_su_heber_surf_stat3','VerifFloat(this)');
        $form->setOnchange('tax_su_tot_surf_stat','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_stat1','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_stat2','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_stat3','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_stat4','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_stat5','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_stat6','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_stat7','VerifFloat(this)');
        $form->setOnchange('tax_su_parc_statio_expl_comm_surf','VerifFloat(this)');
        $form->setOnchange('tax_log_ap_trvx_nb','VerifNum(this)');
        $form->setOnchange('tax_am_statio_ext_cr','VerifNum(this)');
        $form->setOnchange('tax_sup_bass_pisc_cr','VerifFloat(this)');
        $form->setOnchange('tax_empl_ten_carav_mobil_nb_cr','VerifNum(this)');
        $form->setOnchange('tax_empl_hll_nb_cr','VerifNum(this)');
        $form->setOnchange('tax_eol_haut_nb_cr','VerifNum(this)');
        $form->setOnchange('tax_pann_volt_sup_cr','VerifFloat(this)');
        $form->setOnchange('tax_surf_loc_arch','VerifFloat(this)');
        $form->setOnchange('tax_surf_pisc_arch','VerifFloat(this)');
        $form->setOnchange('tax_am_statio_ext_arch','VerifFloat(this)');
        $form->setOnchange('tax_empl_ten_carav_mobil_nb_arch','VerifFloat(this)');
        $form->setOnchange('tax_empl_hll_nb_arch','VerifFloat(this)');
        $form->setOnchange('tax_eol_haut_nb_arch','VerifNum(this)');
        $form->setOnchange('erp_public_eff1','VerifFloat(this)');
        $form->setOnchange('erp_public_eff2','VerifFloat(this)');
        $form->setOnchange('erp_public_eff3','VerifFloat(this)');
        $form->setOnchange('erp_public_eff4','VerifFloat(this)');
        $form->setOnchange('erp_public_eff5','VerifFloat(this)');
        $form->setOnchange('erp_public_eff_tot','VerifFloat(this)');
        $form->setOnchange('erp_perso_eff1','VerifFloat(this)');
        $form->setOnchange('erp_perso_eff2','VerifFloat(this)');
        $form->setOnchange('erp_perso_eff3','VerifFloat(this)');
        $form->setOnchange('erp_perso_eff4','VerifFloat(this)');
        $form->setOnchange('erp_perso_eff5','VerifFloat(this)');
        $form->setOnchange('erp_perso_eff_tot','VerifFloat(this)');
        $form->setOnchange('erp_tot_eff1','VerifFloat(this)');
        $form->setOnchange('erp_tot_eff2','VerifFloat(this)');
        $form->setOnchange('erp_tot_eff3','VerifFloat(this)');
        $form->setOnchange('erp_tot_eff4','VerifFloat(this)');
        $form->setOnchange('erp_tot_eff5','VerifFloat(this)');
        $form->setOnchange('erp_tot_eff_tot','VerifFloat(this)');
        $form->setOnchange('erp_class_cat','VerifNum(this)');
        $form->setOnchange('erp_class_type','VerifNum(this)');
        $form->setOnchange('tax_surf_abr_jard_pig_colom','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_abr_jard_pig_colom','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon1','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon2','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon3','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon4','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon5','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon6','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon7','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon8','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon9','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon10','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon11','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon12','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon13','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon14','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon15','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon16','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon17','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon18','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon19','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon20','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon_tot','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon1','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon2','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon3','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon4','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon5','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon6','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon7','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon8','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon9','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon10','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon11','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon12','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon13','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon14','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon15','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon16','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon17','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon18','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon19','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon20','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon_tot','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon1','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon2','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon3','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon4','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon5','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon6','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon7','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon8','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon9','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon10','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon11','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon12','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon13','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon14','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon15','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon16','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon17','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon18','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon19','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon20','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon_tot','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon1','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon2','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon3','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon4','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon5','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon6','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon7','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon8','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon9','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon10','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon11','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon12','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon13','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon14','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon15','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon16','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon17','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon18','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon19','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon20','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon_tot','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon1','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon2','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon3','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon4','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon5','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon6','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon7','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon8','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon9','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon10','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon11','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon12','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon13','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon14','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon15','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon16','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon17','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon18','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon19','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon20','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon_tot','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon1','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon2','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon3','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon4','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon5','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon6','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon7','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon8','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon9','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon10','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon11','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon12','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon13','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon14','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon15','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon16','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon17','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon18','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon19','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon20','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon_tot','VerifFloat(this)');
        $form->setOnchange('ctx_objet_recours','VerifNum(this)');
        $form->setOnchange('ctx_date_audience','fdate(this)');
        $form->setOnchange('ctx_date_ajournement','fdate(this)');
        $form->setOnchange('mtn_exo_ta_part_commu','VerifFloat(this)');
        $form->setOnchange('mtn_exo_ta_part_depart','VerifFloat(this)');
        $form->setOnchange('mtn_exo_ta_part_reg','VerifFloat(this)');
        $form->setOnchange('mtn_exo_rap','VerifFloat(this)');
        $form->setOnchange('dpc_bail_comm_date','fdate(this)');
        $form->setOnchange('dpc_moda_cess_adj_date','fdate(this)');
        $form->setOnchange('dia_ss_date','fdate(this)');
        $form->setOnchange('enga_decla_date','fdate(this)');
        $form->setOnchange('co_bat_niv_dessous_nb','VerifNum(this)');
        $form->setOnchange('tax_surf_tot_demo','VerifFloat(this)');
        $form->setOnchange('tax_surf_tax_demo','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf8','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_stat8','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf9','VerifFloat(this)');
        $form->setOnchange('tax_su_non_habit_surf_stat9','VerifFloat(this)');
        $form->setOnchange('terr_juri_titul_date','fdate(this)');
        $form->setOnchange('erp_trvx_adap_valid','fdate(this)');
        $form->setOnchange('co_trav_supp_dessus','VerifFloat(this)');
        $form->setOnchange('co_trav_supp_dessous','VerifFloat(this)');
        $form->setOnchange('tax_su_habit_abr_jard_pig_colom','VerifFloat(this)');
        $form->setOnchange('s1na1_numero','VerifNum(this)');
        $form->setOnchange('s1na2_numero','VerifNum(this)');
        $form->setOnchange('u1b_voirieavant','fdate(this)');
        $form->setOnchange('u1k_eauavant','fdate(this)');
        $form->setOnchange('u1r_assainissementavant','fdate(this)');
        $form->setOnchange('u1f_electriciteavant','fdate(this)');
        $form->setOnchange('f1ts4_surftaxestation','VerifNum(this)');
        $form->setOnchange('f1ut1_surfcree','VerifNum(this)');
        $form->setOnchange('f9d_date','fdate(this)');
        $form->setOnchange('su2_avt_shon21','VerifFloat(this)');
        $form->setOnchange('su2_avt_shon22','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon21','VerifFloat(this)');
        $form->setOnchange('su2_cstr_shon22','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon21','VerifFloat(this)');
        $form->setOnchange('su2_chge_shon22','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon21','VerifFloat(this)');
        $form->setOnchange('su2_demo_shon22','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon21','VerifFloat(this)');
        $form->setOnchange('su2_sup_shon22','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon21','VerifFloat(this)');
        $form->setOnchange('su2_tot_shon22','VerifFloat(this)');
        $form->setOnchange('f1gu1_f1gu2_f1gu3','VerifFloat(this)');
        $form->setOnchange('f1lu1_f1lu2_f1lu3','VerifFloat(this)');
        $form->setOnchange('f1zu1_f1zu2_f1zu3','VerifFloat(this)');
        $form->setOnchange('f1pu1_f1pu2_f1pu3','VerifFloat(this)');
        $form->setOnchange('f1gt4_f1gt5_f1gt6','VerifFloat(this)');
        $form->setOnchange('f1lt4_f1lt5_f1lt6','VerifFloat(this)');
        $form->setOnchange('f1zt4_f1zt5_f1zt6','VerifFloat(this)');
        $form->setOnchange('f1pt4_f1pt5_f1pt6','VerifFloat(this)');
        $form->setOnchange('f1xu1_f1xu2_f1xu3','VerifFloat(this)');
        $form->setOnchange('f1xt4_f1xt5_f1xt6','VerifFloat(this)');
        $form->setOnchange('f1hu1_f1hu2_f1hu3','VerifFloat(this)');
        $form->setOnchange('f1mu1_f1mu2_f1mu3','VerifFloat(this)');
        $form->setOnchange('f1qu1_f1qu2_f1qu3','VerifFloat(this)');
        $form->setOnchange('f1ht4_f1ht5_f1ht6','VerifFloat(this)');
        $form->setOnchange('f1mt4_f1mt5_f1mt6','VerifFloat(this)');
        $form->setOnchange('f1qt4_f1qt5_f1qt6','VerifFloat(this)');
        $form->setOnchange('f2cu1_f2cu2_f2cu3','VerifFloat(this)');
        $form->setOnchange('f2bu1_f2bu2_f2bu3','VerifFloat(this)');
        $form->setOnchange('f2su1_f2su2_f2su3','VerifFloat(this)');
        $form->setOnchange('f2hu1_f2hu2_f2hu3','VerifFloat(this)');
        $form->setOnchange('f2eu1_f2eu2_f2eu3','VerifFloat(this)');
        $form->setOnchange('f2qu1_f2qu2_f2qu3','VerifFloat(this)');
        $form->setOnchange('f2ct4_f2ct5_f2ct6','VerifFloat(this)');
        $form->setOnchange('f2bt4_f2bt5_f2bt6','VerifFloat(this)');
        $form->setOnchange('f2st4_f2st5_f2st6','VerifFloat(this)');
        $form->setOnchange('f2ht4_f2ht5_f2ht6','VerifFloat(this)');
        $form->setOnchange('f2et4_f2et5_f2et6','VerifFloat(this)');
        $form->setOnchange('f2qt4_f2qt5_f2qt6','VerifFloat(this)');
        $form->setOnchange('dia_mairie_prix_moyen','VerifFloat(this)');
        $form->setOnchange('dia_mod_cess_commi_mnt','VerifFloat(this)');
        $form->setOnchange('dia_mod_cess_prix_vente_num','VerifFloat(this)');
        $form->setOnchange('dia_mod_cess_prix_vente_mob_num','VerifFloat(this)');
        $form->setOnchange('dia_mod_cess_prix_vente_cheptel_num','VerifFloat(this)');
        $form->setOnchange('dia_mod_cess_prix_vente_recol_num','VerifFloat(this)');
        $form->setOnchange('dia_mod_cess_prix_vente_autre_num','VerifFloat(this)');
        $form->setOnchange('dia_su_co_sol_num','VerifFloat(this)');
        $form->setOnchange('dia_su_util_hab_num','VerifFloat(this)');
        $form->setOnchange('dia_mod_cess_mnt_an_num','VerifFloat(this)');
        $form->setOnchange('dia_mod_cess_mnt_compt_num','VerifFloat(this)');
        $form->setOnchange('dia_mod_cess_mnt_soulte_num','VerifFloat(this)');
        $form->setOnchange('dia_comp_prix_vente','VerifFloat(this)');
        $form->setOnchange('dia_comp_surface','VerifFloat(this)');
        $form->setOnchange('dia_comp_total_frais','VerifFloat(this)');
        $form->setOnchange('dia_comp_mtn_total','VerifFloat(this)');
        $form->setOnchange('dia_comp_valeur_m2','VerifFloat(this)');
        $form->setOnchange('dia_esti_prix_france_dom','VerifFloat(this)');
        $form->setOnchange('dia_prop_collectivite','VerifFloat(this)');
        $form->setOnchange('dia_entree_jouissance_date','fdate(this)');
        $form->setOnchange('dia_entree_jouissance_date_effet','fdate(this)');
        $form->setOnchange('dia_remise_bien_date_effet','fdate(this)');
        $form->setOnchange('c2zp1_crete','VerifFloat(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("donnees_techniques", 11);
        $form->setTaille("dossier_instruction", 30);
        $form->setTaille("lot", 11);
        $form->setTaille("am_lotiss", 1);
        $form->setTaille("am_autre_div", 1);
        $form->setTaille("am_camping", 1);
        $form->setTaille("am_caravane", 1);
        $form->setTaille("am_carav_duree", 11);
        $form->setTaille("am_statio", 1);
        $form->setTaille("am_statio_cont", 11);
        $form->setTaille("am_affou_exhau", 1);
        $form->setTaille("am_affou_exhau_sup", 10);
        $form->setTaille("am_affou_prof", 10);
        $form->setTaille("am_exhau_haut", 10);
        $form->setTaille("am_coupe_abat", 1);
        $form->setTaille("am_prot_plu", 1);
        $form->setTaille("am_prot_muni", 1);
        $form->setTaille("am_mobil_voyage", 1);
        $form->setTaille("am_aire_voyage", 1);
        $form->setTaille("am_rememb_afu", 1);
        $form->setTaille("am_parc_resid_loi", 1);
        $form->setTaille("am_sport_moto", 1);
        $form->setTaille("am_sport_attrac", 1);
        $form->setTaille("am_sport_golf", 1);
        $form->setTaille("am_mob_art", 1);
        $form->setTaille("am_modif_voie_esp", 1);
        $form->setTaille("am_plant_voie_esp", 1);
        $form->setTaille("am_chem_ouv_esp", 1);
        $form->setTaille("am_agri_peche", 1);
        $form->setTaille("am_crea_voie", 1);
        $form->setTaille("am_modif_voie_exist", 1);
        $form->setTaille("am_crea_esp_sauv", 1);
        $form->setTaille("am_crea_esp_class", 1);
        $form->setTaille("am_projet_desc", 80);
        $form->setTaille("am_terr_surf", 10);
        $form->setTaille("am_tranche_desc", 80);
        $form->setTaille("am_lot_max_nb", 11);
        $form->setTaille("am_lot_max_shon", 10);
        $form->setTaille("am_lot_cstr_cos", 1);
        $form->setTaille("am_lot_cstr_plan", 1);
        $form->setTaille("am_lot_cstr_vente", 1);
        $form->setTaille("am_lot_fin_diff", 1);
        $form->setTaille("am_lot_consign", 1);
        $form->setTaille("am_lot_gar_achev", 1);
        $form->setTaille("am_lot_vente_ant", 1);
        $form->setTaille("am_empl_nb", 11);
        $form->setTaille("am_tente_nb", 11);
        $form->setTaille("am_carav_nb", 11);
        $form->setTaille("am_mobil_nb", 11);
        $form->setTaille("am_pers_nb", 11);
        $form->setTaille("am_empl_hll_nb", 11);
        $form->setTaille("am_hll_shon", 10);
        $form->setTaille("am_periode_exploit", 80);
        $form->setTaille("am_exist_agrand", 1);
        $form->setTaille("am_exist_date", 30);
        $form->setTaille("am_exist_num", 30);
        $form->setTaille("am_exist_nb_avant", 11);
        $form->setTaille("am_exist_nb_apres", 11);
        $form->setTaille("am_coupe_bois", 1);
        $form->setTaille("am_coupe_parc", 1);
        $form->setTaille("am_coupe_align", 1);
        $form->setTaille("am_coupe_ess", 30);
        $form->setTaille("am_coupe_age", 15);
        $form->setTaille("am_coupe_dens", 30);
        $form->setTaille("am_coupe_qual", 30);
        $form->setTaille("am_coupe_trait", 30);
        $form->setTaille("am_coupe_autr", 30);
        $form->setTaille("co_archi_recours", 1);
        $form->setTaille("co_cstr_nouv", 1);
        $form->setTaille("co_cstr_exist", 1);
        $form->setTaille("co_cloture", 1);
        $form->setTaille("co_elec_tension", 10);
        $form->setTaille("co_div_terr", 1);
        $form->setTaille("co_projet_desc", 80);
        $form->setTaille("co_anx_pisc", 1);
        $form->setTaille("co_anx_gara", 1);
        $form->setTaille("co_anx_veran", 1);
        $form->setTaille("co_anx_abri", 1);
        $form->setTaille("co_anx_autr", 1);
        $form->setTaille("co_anx_autr_desc", 80);
        $form->setTaille("co_tot_log_nb", 11);
        $form->setTaille("co_tot_ind_nb", 11);
        $form->setTaille("co_tot_coll_nb", 11);
        $form->setTaille("co_mais_piece_nb", 11);
        $form->setTaille("co_mais_niv_nb", 11);
        $form->setTaille("co_fin_lls_nb", 11);
        $form->setTaille("co_fin_aa_nb", 11);
        $form->setTaille("co_fin_ptz_nb", 11);
        $form->setTaille("co_fin_autr_nb", 11);
        $form->setTaille("co_fin_autr_desc", 80);
        $form->setTaille("co_mais_contrat_ind", 1);
        $form->setTaille("co_uti_pers", 1);
        $form->setTaille("co_uti_vente", 1);
        $form->setTaille("co_uti_loc", 1);
        $form->setTaille("co_uti_princ", 1);
        $form->setTaille("co_uti_secon", 1);
        $form->setTaille("co_resid_agees", 1);
        $form->setTaille("co_resid_etud", 1);
        $form->setTaille("co_resid_tourism", 1);
        $form->setTaille("co_resid_hot_soc", 1);
        $form->setTaille("co_resid_soc", 1);
        $form->setTaille("co_resid_hand", 1);
        $form->setTaille("co_resid_autr", 1);
        $form->setTaille("co_resid_autr_desc", 80);
        $form->setTaille("co_foyer_chamb_nb", 11);
        $form->setTaille("co_log_1p_nb", 11);
        $form->setTaille("co_log_2p_nb", 11);
        $form->setTaille("co_log_3p_nb", 11);
        $form->setTaille("co_log_4p_nb", 11);
        $form->setTaille("co_log_5p_nb", 11);
        $form->setTaille("co_log_6p_nb", 11);
        $form->setTaille("co_bat_niv_nb", 11);
        $form->setTaille("co_trx_exten", 1);
        $form->setTaille("co_trx_surelev", 1);
        $form->setTaille("co_trx_nivsup", 1);
        $form->setTaille("co_demont_periode", 80);
        $form->setTaille("co_sp_transport", 1);
        $form->setTaille("co_sp_enseign", 1);
        $form->setTaille("co_sp_act_soc", 1);
        $form->setTaille("co_sp_ouvr_spe", 1);
        $form->setTaille("co_sp_sante", 1);
        $form->setTaille("co_sp_culture", 1);
        $form->setTaille("co_statio_avt_nb", 11);
        $form->setTaille("co_statio_apr_nb", 11);
        $form->setTaille("co_statio_adr", 80);
        $form->setTaille("co_statio_place_nb", 11);
        $form->setTaille("co_statio_tot_surf", 10);
        $form->setTaille("co_statio_tot_shob", 10);
        $form->setTaille("co_statio_comm_cin_surf", 10);
        $form->setTaille("su_avt_shon1", 10);
        $form->setTaille("su_avt_shon2", 10);
        $form->setTaille("su_avt_shon3", 10);
        $form->setTaille("su_avt_shon4", 10);
        $form->setTaille("su_avt_shon5", 10);
        $form->setTaille("su_avt_shon6", 10);
        $form->setTaille("su_avt_shon7", 10);
        $form->setTaille("su_avt_shon8", 10);
        $form->setTaille("su_avt_shon9", 10);
        $form->setTaille("su_cstr_shon1", 10);
        $form->setTaille("su_cstr_shon2", 10);
        $form->setTaille("su_cstr_shon3", 10);
        $form->setTaille("su_cstr_shon4", 10);
        $form->setTaille("su_cstr_shon5", 10);
        $form->setTaille("su_cstr_shon6", 10);
        $form->setTaille("su_cstr_shon7", 10);
        $form->setTaille("su_cstr_shon8", 10);
        $form->setTaille("su_cstr_shon9", 10);
        $form->setTaille("su_trsf_shon1", 10);
        $form->setTaille("su_trsf_shon2", 10);
        $form->setTaille("su_trsf_shon3", 10);
        $form->setTaille("su_trsf_shon4", 10);
        $form->setTaille("su_trsf_shon5", 10);
        $form->setTaille("su_trsf_shon6", 10);
        $form->setTaille("su_trsf_shon7", 10);
        $form->setTaille("su_trsf_shon8", 10);
        $form->setTaille("su_trsf_shon9", 10);
        $form->setTaille("su_chge_shon1", 10);
        $form->setTaille("su_chge_shon2", 10);
        $form->setTaille("su_chge_shon3", 10);
        $form->setTaille("su_chge_shon4", 10);
        $form->setTaille("su_chge_shon5", 10);
        $form->setTaille("su_chge_shon6", 10);
        $form->setTaille("su_chge_shon7", 10);
        $form->setTaille("su_chge_shon8", 10);
        $form->setTaille("su_chge_shon9", 10);
        $form->setTaille("su_demo_shon1", 10);
        $form->setTaille("su_demo_shon2", 10);
        $form->setTaille("su_demo_shon3", 10);
        $form->setTaille("su_demo_shon4", 10);
        $form->setTaille("su_demo_shon5", 10);
        $form->setTaille("su_demo_shon6", 10);
        $form->setTaille("su_demo_shon7", 10);
        $form->setTaille("su_demo_shon8", 10);
        $form->setTaille("su_demo_shon9", 10);
        $form->setTaille("su_sup_shon1", 10);
        $form->setTaille("su_sup_shon2", 10);
        $form->setTaille("su_sup_shon3", 10);
        $form->setTaille("su_sup_shon4", 10);
        $form->setTaille("su_sup_shon5", 10);
        $form->setTaille("su_sup_shon6", 10);
        $form->setTaille("su_sup_shon7", 10);
        $form->setTaille("su_sup_shon8", 10);
        $form->setTaille("su_sup_shon9", 10);
        $form->setTaille("su_tot_shon1", 10);
        $form->setTaille("su_tot_shon2", 10);
        $form->setTaille("su_tot_shon3", 10);
        $form->setTaille("su_tot_shon4", 10);
        $form->setTaille("su_tot_shon5", 10);
        $form->setTaille("su_tot_shon6", 10);
        $form->setTaille("su_tot_shon7", 10);
        $form->setTaille("su_tot_shon8", 10);
        $form->setTaille("su_tot_shon9", 10);
        $form->setTaille("su_avt_shon_tot", 10);
        $form->setTaille("su_cstr_shon_tot", 10);
        $form->setTaille("su_trsf_shon_tot", 10);
        $form->setTaille("su_chge_shon_tot", 10);
        $form->setTaille("su_demo_shon_tot", 10);
        $form->setTaille("su_sup_shon_tot", 10);
        $form->setTaille("su_tot_shon_tot", 10);
        $form->setTaille("dm_constr_dates", 80);
        $form->setTaille("dm_total", 1);
        $form->setTaille("dm_partiel", 1);
        $form->setTaille("dm_projet_desc", 80);
        $form->setTaille("dm_tot_log_nb", 11);
        $form->setTaille("tax_surf_tot", 10);
        $form->setTaille("tax_surf", 10);
        $form->setTaille("tax_surf_suppr_mod", 10);
        $form->setTaille("tax_su_princ_log_nb1", 10);
        $form->setTaille("tax_su_princ_log_nb2", 10);
        $form->setTaille("tax_su_princ_log_nb3", 10);
        $form->setTaille("tax_su_princ_log_nb4", 10);
        $form->setTaille("tax_su_princ_log_nb_tot1", 10);
        $form->setTaille("tax_su_princ_log_nb_tot2", 10);
        $form->setTaille("tax_su_princ_log_nb_tot3", 10);
        $form->setTaille("tax_su_princ_log_nb_tot4", 10);
        $form->setTaille("tax_su_princ_surf1", 10);
        $form->setTaille("tax_su_princ_surf2", 10);
        $form->setTaille("tax_su_princ_surf3", 10);
        $form->setTaille("tax_su_princ_surf4", 10);
        $form->setTaille("tax_su_princ_surf_sup1", 10);
        $form->setTaille("tax_su_princ_surf_sup2", 10);
        $form->setTaille("tax_su_princ_surf_sup3", 10);
        $form->setTaille("tax_su_princ_surf_sup4", 10);
        $form->setTaille("tax_su_heber_log_nb1", 11);
        $form->setTaille("tax_su_heber_log_nb2", 11);
        $form->setTaille("tax_su_heber_log_nb3", 11);
        $form->setTaille("tax_su_heber_log_nb_tot1", 11);
        $form->setTaille("tax_su_heber_log_nb_tot2", 11);
        $form->setTaille("tax_su_heber_log_nb_tot3", 11);
        $form->setTaille("tax_su_heber_surf1", 10);
        $form->setTaille("tax_su_heber_surf2", 10);
        $form->setTaille("tax_su_heber_surf3", 10);
        $form->setTaille("tax_su_heber_surf_sup1", 10);
        $form->setTaille("tax_su_heber_surf_sup2", 10);
        $form->setTaille("tax_su_heber_surf_sup3", 10);
        $form->setTaille("tax_su_secon_log_nb", 11);
        $form->setTaille("tax_su_tot_log_nb", 11);
        $form->setTaille("tax_su_secon_log_nb_tot", 11);
        $form->setTaille("tax_su_tot_log_nb_tot", 11);
        $form->setTaille("tax_su_secon_surf", 10);
        $form->setTaille("tax_su_tot_surf", 10);
        $form->setTaille("tax_su_secon_surf_sup", 10);
        $form->setTaille("tax_su_tot_surf_sup", 10);
        $form->setTaille("tax_ext_pret", 1);
        $form->setTaille("tax_ext_desc", 80);
        $form->setTaille("tax_surf_tax_exist_cons", 10);
        $form->setTaille("tax_log_exist_nb", 11);
        $form->setTaille("tax_am_statio_ext", 11);
        $form->setTaille("tax_sup_bass_pisc", 10);
        $form->setTaille("tax_empl_ten_carav_mobil_nb", 11);
        $form->setTaille("tax_empl_hll_nb", 11);
        $form->setTaille("tax_eol_haut_nb", 11);
        $form->setTaille("tax_pann_volt_sup", 10);
        $form->setTaille("tax_am_statio_ext_sup", 11);
        $form->setTaille("tax_sup_bass_pisc_sup", 10);
        $form->setTaille("tax_empl_ten_carav_mobil_nb_sup", 11);
        $form->setTaille("tax_empl_hll_nb_sup", 11);
        $form->setTaille("tax_eol_haut_nb_sup", 11);
        $form->setTaille("tax_pann_volt_sup_sup", 10);
        $form->setTaille("tax_trx_presc_ppr", 1);
        $form->setTaille("tax_monu_hist", 1);
        $form->setTaille("tax_comm_nb", 11);
        $form->setTaille("tax_su_non_habit_surf1", 10);
        $form->setTaille("tax_su_non_habit_surf2", 10);
        $form->setTaille("tax_su_non_habit_surf3", 10);
        $form->setTaille("tax_su_non_habit_surf4", 10);
        $form->setTaille("tax_su_non_habit_surf5", 10);
        $form->setTaille("tax_su_non_habit_surf6", 10);
        $form->setTaille("tax_su_non_habit_surf7", 10);
        $form->setTaille("tax_su_non_habit_surf_sup1", 10);
        $form->setTaille("tax_su_non_habit_surf_sup2", 10);
        $form->setTaille("tax_su_non_habit_surf_sup3", 10);
        $form->setTaille("tax_su_non_habit_surf_sup4", 10);
        $form->setTaille("tax_su_non_habit_surf_sup5", 10);
        $form->setTaille("tax_su_non_habit_surf_sup6", 10);
        $form->setTaille("tax_su_non_habit_surf_sup7", 10);
        $form->setTaille("vsd_surf_planch_smd", 1);
        $form->setTaille("vsd_unit_fonc_sup", 10);
        $form->setTaille("vsd_unit_fonc_constr_sup", 10);
        $form->setTaille("vsd_val_terr", 10);
        $form->setTaille("vsd_const_sxist_non_dem_surf", 10);
        $form->setTaille("vsd_rescr_fisc", 12);
        $form->setTaille("pld_val_terr", 10);
        $form->setTaille("pld_const_exist_dem", 1);
        $form->setTaille("pld_const_exist_dem_surf", 10);
        $form->setTaille("code_cnil", 1);
        $form->setTaille("terr_juri_titul", 20);
        $form->setTaille("terr_juri_lot", 20);
        $form->setTaille("terr_juri_zac", 20);
        $form->setTaille("terr_juri_afu", 20);
        $form->setTaille("terr_juri_pup", 20);
        $form->setTaille("terr_juri_oin", 20);
        $form->setTaille("terr_juri_desc", 80);
        $form->setTaille("terr_div_surf_etab", 10);
        $form->setTaille("terr_div_surf_av_div", 10);
        $form->setTaille("doc_date", 12);
        $form->setTaille("doc_tot_trav", 1);
        $form->setTaille("doc_tranche_trav", 1);
        $form->setTaille("doc_tranche_trav_desc", 80);
        $form->setTaille("doc_surf", 10);
        $form->setTaille("doc_nb_log", 11);
        $form->setTaille("doc_nb_log_indiv", 11);
        $form->setTaille("doc_nb_log_coll", 11);
        $form->setTaille("doc_nb_log_lls", 11);
        $form->setTaille("doc_nb_log_aa", 11);
        $form->setTaille("doc_nb_log_ptz", 11);
        $form->setTaille("doc_nb_log_autre", 11);
        $form->setTaille("daact_date", 12);
        $form->setTaille("daact_date_chgmt_dest", 12);
        $form->setTaille("daact_tot_trav", 1);
        $form->setTaille("daact_tranche_trav", 1);
        $form->setTaille("daact_tranche_trav_desc", 80);
        $form->setTaille("daact_surf", 10);
        $form->setTaille("daact_nb_log", 11);
        $form->setTaille("daact_nb_log_indiv", 11);
        $form->setTaille("daact_nb_log_coll", 11);
        $form->setTaille("daact_nb_log_lls", 11);
        $form->setTaille("daact_nb_log_aa", 11);
        $form->setTaille("daact_nb_log_ptz", 11);
        $form->setTaille("daact_nb_log_autre", 11);
        $form->setTaille("dossier_autorisation", 30);
        $form->setTaille("am_div_mun", 1);
        $form->setTaille("co_perf_energ", 30);
        $form->setTaille("architecte", 11);
        $form->setTaille("co_statio_avt_shob", 30);
        $form->setTaille("co_statio_apr_shob", 30);
        $form->setTaille("co_statio_avt_surf", 30);
        $form->setTaille("co_statio_apr_surf", 30);
        $form->setTaille("co_trx_amgt", 30);
        $form->setTaille("co_modif_aspect", 30);
        $form->setTaille("co_modif_struct", 30);
        $form->setTaille("co_ouvr_elec", 1);
        $form->setTaille("co_ouvr_infra", 1);
        $form->setTaille("co_trx_imm", 30);
        $form->setTaille("co_cstr_shob", 30);
        $form->setTaille("am_voyage_deb", 30);
        $form->setTaille("am_voyage_fin", 30);
        $form->setTaille("am_modif_amgt", 30);
        $form->setTaille("am_lot_max_shob", 30);
        $form->setTaille("mod_desc", 30);
        $form->setTaille("tr_total", 30);
        $form->setTaille("tr_partiel", 30);
        $form->setTaille("tr_desc", 30);
        $form->setTaille("avap_co_elt_pro", 1);
        $form->setTaille("avap_nouv_haut_surf", 1);
        $form->setTaille("avap_co_clot", 30);
        $form->setTaille("avap_aut_coup_aba_arb", 30);
        $form->setTaille("avap_ouv_infra", 30);
        $form->setTaille("avap_aut_inst_mob", 30);
        $form->setTaille("avap_aut_plant", 30);
        $form->setTaille("avap_aut_auv_elec", 30);
        $form->setTaille("tax_dest_loc_tr", 30);
        $form->setTaille("ope_proj_desc", 80);
        $form->setTaille("tax_surf_tot_cstr", 11);
        $form->setTaille("cerfa", 11);
        $form->setTaille("tax_surf_loc_stat", 11);
        $form->setTaille("tax_su_princ_surf_stat1", 10);
        $form->setTaille("tax_su_princ_surf_stat2", 10);
        $form->setTaille("tax_su_princ_surf_stat3", 10);
        $form->setTaille("tax_su_princ_surf_stat4", 10);
        $form->setTaille("tax_su_secon_surf_stat", 10);
        $form->setTaille("tax_su_heber_surf_stat1", 10);
        $form->setTaille("tax_su_heber_surf_stat2", 10);
        $form->setTaille("tax_su_heber_surf_stat3", 10);
        $form->setTaille("tax_su_tot_surf_stat", 10);
        $form->setTaille("tax_su_non_habit_surf_stat1", 10);
        $form->setTaille("tax_su_non_habit_surf_stat2", 10);
        $form->setTaille("tax_su_non_habit_surf_stat3", 10);
        $form->setTaille("tax_su_non_habit_surf_stat4", 10);
        $form->setTaille("tax_su_non_habit_surf_stat5", 10);
        $form->setTaille("tax_su_non_habit_surf_stat6", 10);
        $form->setTaille("tax_su_non_habit_surf_stat7", 10);
        $form->setTaille("tax_su_parc_statio_expl_comm_surf", 10);
        $form->setTaille("tax_log_ap_trvx_nb", 11);
        $form->setTaille("tax_am_statio_ext_cr", 11);
        $form->setTaille("tax_sup_bass_pisc_cr", 10);
        $form->setTaille("tax_empl_ten_carav_mobil_nb_cr", 11);
        $form->setTaille("tax_empl_hll_nb_cr", 11);
        $form->setTaille("tax_eol_haut_nb_cr", 11);
        $form->setTaille("tax_pann_volt_sup_cr", 10);
        $form->setTaille("tax_surf_loc_arch", 10);
        $form->setTaille("tax_surf_pisc_arch", 10);
        $form->setTaille("tax_am_statio_ext_arch", 10);
        $form->setTaille("tax_empl_ten_carav_mobil_nb_arch", 10);
        $form->setTaille("tax_empl_hll_nb_arch", 10);
        $form->setTaille("tax_eol_haut_nb_arch", 11);
        $form->setTaille("ope_proj_div_co", 1);
        $form->setTaille("ope_proj_div_contr", 1);
        $form->setTaille("tax_desc", 80);
        $form->setTaille("erp_cstr_neuve", 1);
        $form->setTaille("erp_trvx_acc", 1);
        $form->setTaille("erp_extension", 1);
        $form->setTaille("erp_rehab", 1);
        $form->setTaille("erp_trvx_am", 1);
        $form->setTaille("erp_vol_nouv_exist", 1);
        $form->setTaille("erp_loc_eff1", 30);
        $form->setTaille("erp_loc_eff2", 30);
        $form->setTaille("erp_loc_eff3", 30);
        $form->setTaille("erp_loc_eff4", 30);
        $form->setTaille("erp_loc_eff5", 30);
        $form->setTaille("erp_loc_eff_tot", 30);
        $form->setTaille("erp_public_eff1", 10);
        $form->setTaille("erp_public_eff2", 10);
        $form->setTaille("erp_public_eff3", 10);
        $form->setTaille("erp_public_eff4", 10);
        $form->setTaille("erp_public_eff5", 10);
        $form->setTaille("erp_public_eff_tot", 10);
        $form->setTaille("erp_perso_eff1", 10);
        $form->setTaille("erp_perso_eff2", 10);
        $form->setTaille("erp_perso_eff3", 10);
        $form->setTaille("erp_perso_eff4", 10);
        $form->setTaille("erp_perso_eff5", 10);
        $form->setTaille("erp_perso_eff_tot", 10);
        $form->setTaille("erp_tot_eff1", 10);
        $form->setTaille("erp_tot_eff2", 10);
        $form->setTaille("erp_tot_eff3", 10);
        $form->setTaille("erp_tot_eff4", 10);
        $form->setTaille("erp_tot_eff5", 10);
        $form->setTaille("erp_tot_eff_tot", 10);
        $form->setTaille("erp_class_cat", 11);
        $form->setTaille("erp_class_type", 11);
        $form->setTaille("tax_surf_abr_jard_pig_colom", 10);
        $form->setTaille("tax_su_non_habit_abr_jard_pig_colom", 10);
        $form->setTaille("dia_imm_non_bati", 1);
        $form->setTaille("dia_imm_bati_terr_propr", 1);
        $form->setTaille("dia_imm_bati_terr_autr", 1);
        $form->setTaille("dia_imm_bati_terr_autr_desc", 80);
        $form->setTaille("dia_bat_copro", 1);
        $form->setTaille("dia_bat_copro_desc", 80);
        $form->setTaille("dia_lot_numero", 80);
        $form->setTaille("dia_lot_bat", 80);
        $form->setTaille("dia_lot_etage", 80);
        $form->setTaille("dia_lot_quote_part", 80);
        $form->setTaille("dia_us_hab", 1);
        $form->setTaille("dia_us_pro", 1);
        $form->setTaille("dia_us_mixte", 1);
        $form->setTaille("dia_us_comm", 1);
        $form->setTaille("dia_us_agr", 1);
        $form->setTaille("dia_us_autre", 1);
        $form->setTaille("dia_us_autre_prec", 80);
        $form->setTaille("dia_occ_prop", 1);
        $form->setTaille("dia_occ_loc", 1);
        $form->setTaille("dia_occ_sans_occ", 1);
        $form->setTaille("dia_occ_autre", 1);
        $form->setTaille("dia_occ_autre_prec", 80);
        $form->setTaille("dia_mod_cess_prix_vente", 30);
        $form->setTaille("dia_mod_cess_prix_vente_mob", 30);
        $form->setTaille("dia_mod_cess_prix_vente_cheptel", 30);
        $form->setTaille("dia_mod_cess_prix_vente_recol", 30);
        $form->setTaille("dia_mod_cess_prix_vente_autre", 30);
        $form->setTaille("dia_mod_cess_commi", 1);
        $form->setTaille("dia_mod_cess_commi_ttc", 30);
        $form->setTaille("dia_mod_cess_commi_ht", 30);
        $form->setTaille("dia_acquereur_nom_prenom", 30);
        $form->setTaille("dia_acquereur_adr_num_voie", 10);
        $form->setTaille("dia_acquereur_adr_ext", 30);
        $form->setTaille("dia_acquereur_adr_type_voie", 20);
        $form->setTaille("dia_acquereur_adr_nom_voie", 30);
        $form->setTaille("dia_acquereur_adr_lieu_dit_bp", 30);
        $form->setTaille("dia_acquereur_adr_cp", 10);
        $form->setTaille("dia_acquereur_adr_localite", 30);
        $form->setTaille("dia_observation", 80);
        $form->setTaille("su2_avt_shon1", 10);
        $form->setTaille("su2_avt_shon2", 10);
        $form->setTaille("su2_avt_shon3", 10);
        $form->setTaille("su2_avt_shon4", 10);
        $form->setTaille("su2_avt_shon5", 10);
        $form->setTaille("su2_avt_shon6", 10);
        $form->setTaille("su2_avt_shon7", 10);
        $form->setTaille("su2_avt_shon8", 10);
        $form->setTaille("su2_avt_shon9", 10);
        $form->setTaille("su2_avt_shon10", 10);
        $form->setTaille("su2_avt_shon11", 10);
        $form->setTaille("su2_avt_shon12", 10);
        $form->setTaille("su2_avt_shon13", 10);
        $form->setTaille("su2_avt_shon14", 10);
        $form->setTaille("su2_avt_shon15", 10);
        $form->setTaille("su2_avt_shon16", 10);
        $form->setTaille("su2_avt_shon17", 10);
        $form->setTaille("su2_avt_shon18", 10);
        $form->setTaille("su2_avt_shon19", 10);
        $form->setTaille("su2_avt_shon20", 10);
        $form->setTaille("su2_avt_shon_tot", 10);
        $form->setTaille("su2_cstr_shon1", 10);
        $form->setTaille("su2_cstr_shon2", 10);
        $form->setTaille("su2_cstr_shon3", 10);
        $form->setTaille("su2_cstr_shon4", 10);
        $form->setTaille("su2_cstr_shon5", 10);
        $form->setTaille("su2_cstr_shon6", 10);
        $form->setTaille("su2_cstr_shon7", 10);
        $form->setTaille("su2_cstr_shon8", 10);
        $form->setTaille("su2_cstr_shon9", 10);
        $form->setTaille("su2_cstr_shon10", 10);
        $form->setTaille("su2_cstr_shon11", 10);
        $form->setTaille("su2_cstr_shon12", 10);
        $form->setTaille("su2_cstr_shon13", 10);
        $form->setTaille("su2_cstr_shon14", 10);
        $form->setTaille("su2_cstr_shon15", 10);
        $form->setTaille("su2_cstr_shon16", 10);
        $form->setTaille("su2_cstr_shon17", 10);
        $form->setTaille("su2_cstr_shon18", 10);
        $form->setTaille("su2_cstr_shon19", 10);
        $form->setTaille("su2_cstr_shon20", 10);
        $form->setTaille("su2_cstr_shon_tot", 10);
        $form->setTaille("su2_chge_shon1", 10);
        $form->setTaille("su2_chge_shon2", 10);
        $form->setTaille("su2_chge_shon3", 10);
        $form->setTaille("su2_chge_shon4", 10);
        $form->setTaille("su2_chge_shon5", 10);
        $form->setTaille("su2_chge_shon6", 10);
        $form->setTaille("su2_chge_shon7", 10);
        $form->setTaille("su2_chge_shon8", 10);
        $form->setTaille("su2_chge_shon9", 10);
        $form->setTaille("su2_chge_shon10", 10);
        $form->setTaille("su2_chge_shon11", 10);
        $form->setTaille("su2_chge_shon12", 10);
        $form->setTaille("su2_chge_shon13", 10);
        $form->setTaille("su2_chge_shon14", 10);
        $form->setTaille("su2_chge_shon15", 10);
        $form->setTaille("su2_chge_shon16", 10);
        $form->setTaille("su2_chge_shon17", 10);
        $form->setTaille("su2_chge_shon18", 10);
        $form->setTaille("su2_chge_shon19", 10);
        $form->setTaille("su2_chge_shon20", 10);
        $form->setTaille("su2_chge_shon_tot", 10);
        $form->setTaille("su2_demo_shon1", 10);
        $form->setTaille("su2_demo_shon2", 10);
        $form->setTaille("su2_demo_shon3", 10);
        $form->setTaille("su2_demo_shon4", 10);
        $form->setTaille("su2_demo_shon5", 10);
        $form->setTaille("su2_demo_shon6", 10);
        $form->setTaille("su2_demo_shon7", 10);
        $form->setTaille("su2_demo_shon8", 10);
        $form->setTaille("su2_demo_shon9", 10);
        $form->setTaille("su2_demo_shon10", 10);
        $form->setTaille("su2_demo_shon11", 10);
        $form->setTaille("su2_demo_shon12", 10);
        $form->setTaille("su2_demo_shon13", 10);
        $form->setTaille("su2_demo_shon14", 10);
        $form->setTaille("su2_demo_shon15", 10);
        $form->setTaille("su2_demo_shon16", 10);
        $form->setTaille("su2_demo_shon17", 10);
        $form->setTaille("su2_demo_shon18", 10);
        $form->setTaille("su2_demo_shon19", 10);
        $form->setTaille("su2_demo_shon20", 10);
        $form->setTaille("su2_demo_shon_tot", 10);
        $form->setTaille("su2_sup_shon1", 10);
        $form->setTaille("su2_sup_shon2", 10);
        $form->setTaille("su2_sup_shon3", 10);
        $form->setTaille("su2_sup_shon4", 10);
        $form->setTaille("su2_sup_shon5", 10);
        $form->setTaille("su2_sup_shon6", 10);
        $form->setTaille("su2_sup_shon7", 10);
        $form->setTaille("su2_sup_shon8", 10);
        $form->setTaille("su2_sup_shon9", 10);
        $form->setTaille("su2_sup_shon10", 10);
        $form->setTaille("su2_sup_shon11", 10);
        $form->setTaille("su2_sup_shon12", 10);
        $form->setTaille("su2_sup_shon13", 10);
        $form->setTaille("su2_sup_shon14", 10);
        $form->setTaille("su2_sup_shon15", 10);
        $form->setTaille("su2_sup_shon16", 10);
        $form->setTaille("su2_sup_shon17", 10);
        $form->setTaille("su2_sup_shon18", 10);
        $form->setTaille("su2_sup_shon19", 10);
        $form->setTaille("su2_sup_shon20", 10);
        $form->setTaille("su2_sup_shon_tot", 10);
        $form->setTaille("su2_tot_shon1", 10);
        $form->setTaille("su2_tot_shon2", 10);
        $form->setTaille("su2_tot_shon3", 10);
        $form->setTaille("su2_tot_shon4", 10);
        $form->setTaille("su2_tot_shon5", 10);
        $form->setTaille("su2_tot_shon6", 10);
        $form->setTaille("su2_tot_shon7", 10);
        $form->setTaille("su2_tot_shon8", 10);
        $form->setTaille("su2_tot_shon9", 10);
        $form->setTaille("su2_tot_shon10", 10);
        $form->setTaille("su2_tot_shon11", 10);
        $form->setTaille("su2_tot_shon12", 10);
        $form->setTaille("su2_tot_shon13", 10);
        $form->setTaille("su2_tot_shon14", 10);
        $form->setTaille("su2_tot_shon15", 10);
        $form->setTaille("su2_tot_shon16", 10);
        $form->setTaille("su2_tot_shon17", 10);
        $form->setTaille("su2_tot_shon18", 10);
        $form->setTaille("su2_tot_shon19", 10);
        $form->setTaille("su2_tot_shon20", 10);
        $form->setTaille("su2_tot_shon_tot", 10);
        $form->setTaille("dia_occ_sol_su_terre", 80);
        $form->setTaille("dia_occ_sol_su_pres", 80);
        $form->setTaille("dia_occ_sol_su_verger", 80);
        $form->setTaille("dia_occ_sol_su_vigne", 80);
        $form->setTaille("dia_occ_sol_su_bois", 80);
        $form->setTaille("dia_occ_sol_su_lande", 80);
        $form->setTaille("dia_occ_sol_su_carriere", 80);
        $form->setTaille("dia_occ_sol_su_eau_cadastree", 80);
        $form->setTaille("dia_occ_sol_su_jardin", 80);
        $form->setTaille("dia_occ_sol_su_terr_batir", 80);
        $form->setTaille("dia_occ_sol_su_terr_agr", 80);
        $form->setTaille("dia_occ_sol_su_sol", 80);
        $form->setTaille("dia_bati_vend_tot", 1);
        $form->setTaille("dia_bati_vend_tot_txt", 80);
        $form->setTaille("dia_su_co_sol", 80);
        $form->setTaille("dia_su_util_hab", 80);
        $form->setTaille("dia_nb_niv", 80);
        $form->setTaille("dia_nb_appart", 80);
        $form->setTaille("dia_nb_autre_loc", 80);
        $form->setTaille("dia_vente_lot_volume", 1);
        $form->setTaille("dia_vente_lot_volume_txt", 80);
        $form->setTaille("dia_lot_nat_su", 80);
        $form->setTaille("dia_lot_bat_achv_plus_10", 1);
        $form->setTaille("dia_lot_bat_achv_moins_10", 1);
        $form->setTaille("dia_lot_regl_copro_publ_hypo_plus_10", 1);
        $form->setTaille("dia_lot_regl_copro_publ_hypo_moins_10", 1);
        $form->setTaille("dia_indivi_quote_part", 80);
        $form->setTaille("dia_design_societe", 80);
        $form->setTaille("dia_design_droit", 80);
        $form->setTaille("dia_droit_soc_nat", 80);
        $form->setTaille("dia_droit_soc_nb", 80);
        $form->setTaille("dia_droit_soc_num_part", 80);
        $form->setTaille("dia_droit_reel_perso_grevant_bien_oui", 1);
        $form->setTaille("dia_droit_reel_perso_grevant_bien_non", 1);
        $form->setTaille("dia_droit_reel_perso_nat", 80);
        $form->setTaille("dia_droit_reel_perso_viag", 80);
        $form->setTaille("dia_mod_cess_adr", 80);
        $form->setTaille("dia_mod_cess_sign_act_auth", 1);
        $form->setTaille("dia_mod_cess_terme", 1);
        $form->setTaille("dia_mod_cess_terme_prec", 80);
        $form->setTaille("dia_mod_cess_bene_acquereur", 1);
        $form->setTaille("dia_mod_cess_bene_vendeur", 1);
        $form->setTaille("dia_mod_cess_paie_nat", 1);
        $form->setTaille("dia_mod_cess_design_contr_alien", 80);
        $form->setTaille("dia_mod_cess_eval_contr", 80);
        $form->setTaille("dia_mod_cess_rente_viag", 1);
        $form->setTaille("dia_mod_cess_mnt_an", 80);
        $form->setTaille("dia_mod_cess_mnt_compt", 80);
        $form->setTaille("dia_mod_cess_bene_rente", 80);
        $form->setTaille("dia_mod_cess_droit_usa_hab", 1);
        $form->setTaille("dia_mod_cess_droit_usa_hab_prec", 80);
        $form->setTaille("dia_mod_cess_eval_usa_usufruit", 80);
        $form->setTaille("dia_mod_cess_vente_nue_prop", 1);
        $form->setTaille("dia_mod_cess_vente_nue_prop_prec", 80);
        $form->setTaille("dia_mod_cess_echange", 1);
        $form->setTaille("dia_mod_cess_design_bien_recus_ech", 80);
        $form->setTaille("dia_mod_cess_mnt_soulte", 80);
        $form->setTaille("dia_mod_cess_prop_contre_echan", 80);
        $form->setTaille("dia_mod_cess_apport_societe", 80);
        $form->setTaille("dia_mod_cess_bene", 80);
        $form->setTaille("dia_mod_cess_esti_bien", 80);
        $form->setTaille("dia_mod_cess_cess_terr_loc_co", 1);
        $form->setTaille("dia_mod_cess_esti_terr", 80);
        $form->setTaille("dia_mod_cess_esti_loc", 80);
        $form->setTaille("dia_mod_cess_esti_imm_loca", 1);
        $form->setTaille("dia_mod_cess_adju_vol", 1);
        $form->setTaille("dia_mod_cess_adju_obl", 1);
        $form->setTaille("dia_mod_cess_adju_fin_indivi", 1);
        $form->setTaille("dia_mod_cess_adju_date_lieu", 80);
        $form->setTaille("dia_mod_cess_mnt_mise_prix", 80);
        $form->setTaille("dia_prop_titu_prix_indique", 1);
        $form->setTaille("dia_prop_recherche_acqu_prix_indique", 1);
        $form->setTaille("dia_acquereur_prof", 80);
        $form->setTaille("dia_indic_compl_ope", 80);
        $form->setTaille("dia_vente_adju", 1);
        $form->setTaille("am_terr_res_demon", 1);
        $form->setTaille("am_air_terr_res_mob", 1);
        $form->setTaille("ctx_objet_recours", 11);
        $form->setTaille("ctx_reference_sagace", 30);
        $form->setTaille("ctx_nature_travaux_infra_om_html", 80);
        $form->setTaille("ctx_synthese_nti", 80);
        $form->setTaille("ctx_article_non_resp_om_html", 80);
        $form->setTaille("ctx_synthese_anr", 80);
        $form->setTaille("ctx_reference_parquet", 30);
        $form->setTaille("ctx_element_taxation", 30);
        $form->setTaille("ctx_infraction", 1);
        $form->setTaille("ctx_regularisable", 1);
        $form->setTaille("ctx_reference_courrier", 30);
        $form->setTaille("ctx_date_audience", 12);
        $form->setTaille("ctx_date_ajournement", 12);
        $form->setTaille("exo_facul_1", 1);
        $form->setTaille("exo_facul_2", 1);
        $form->setTaille("exo_facul_3", 1);
        $form->setTaille("exo_facul_4", 1);
        $form->setTaille("exo_facul_5", 1);
        $form->setTaille("exo_facul_6", 1);
        $form->setTaille("exo_facul_7", 1);
        $form->setTaille("exo_facul_8", 1);
        $form->setTaille("exo_facul_9", 1);
        $form->setTaille("exo_ta_1", 1);
        $form->setTaille("exo_ta_2", 1);
        $form->setTaille("exo_ta_3", 1);
        $form->setTaille("exo_ta_4", 1);
        $form->setTaille("exo_ta_5", 1);
        $form->setTaille("exo_ta_6", 1);
        $form->setTaille("exo_ta_7", 1);
        $form->setTaille("exo_ta_8", 1);
        $form->setTaille("exo_ta_9", 1);
        $form->setTaille("exo_rap_1", 1);
        $form->setTaille("exo_rap_2", 1);
        $form->setTaille("exo_rap_3", 1);
        $form->setTaille("exo_rap_4", 1);
        $form->setTaille("exo_rap_5", 1);
        $form->setTaille("exo_rap_6", 1);
        $form->setTaille("exo_rap_7", 1);
        $form->setTaille("exo_rap_8", 1);
        $form->setTaille("mtn_exo_ta_part_commu", 10);
        $form->setTaille("mtn_exo_ta_part_depart", 10);
        $form->setTaille("mtn_exo_ta_part_reg", 10);
        $form->setTaille("mtn_exo_rap", 10);
        $form->setTaille("dpc_type", 30);
        $form->setTaille("dpc_desc_actv_ex", 80);
        $form->setTaille("dpc_desc_ca", 80);
        $form->setTaille("dpc_desc_aut_prec", 80);
        $form->setTaille("dpc_desig_comm_arti", 1);
        $form->setTaille("dpc_desig_loc_hab", 1);
        $form->setTaille("dpc_desig_loc_ann", 1);
        $form->setTaille("dpc_desig_loc_ann_prec", 80);
        $form->setTaille("dpc_bail_comm_date", 12);
        $form->setTaille("dpc_bail_comm_loyer", 80);
        $form->setTaille("dpc_actv_acqu", 80);
        $form->setTaille("dpc_nb_sala_di", 80);
        $form->setTaille("dpc_nb_sala_dd", 80);
        $form->setTaille("dpc_nb_sala_tc", 80);
        $form->setTaille("dpc_nb_sala_tp", 80);
        $form->setTaille("dpc_moda_cess_vente_am", 1);
        $form->setTaille("dpc_moda_cess_adj", 1);
        $form->setTaille("dpc_moda_cess_prix", 80);
        $form->setTaille("dpc_moda_cess_adj_date", 12);
        $form->setTaille("dpc_moda_cess_adj_prec", 80);
        $form->setTaille("dpc_moda_cess_paie_comp", 1);
        $form->setTaille("dpc_moda_cess_paie_terme", 1);
        $form->setTaille("dpc_moda_cess_paie_terme_prec", 80);
        $form->setTaille("dpc_moda_cess_paie_nat", 1);
        $form->setTaille("dpc_moda_cess_paie_nat_desig_alien", 1);
        $form->setTaille("dpc_moda_cess_paie_nat_desig_alien_prec", 80);
        $form->setTaille("dpc_moda_cess_paie_nat_eval", 1);
        $form->setTaille("dpc_moda_cess_paie_nat_eval_prec", 80);
        $form->setTaille("dpc_moda_cess_paie_aut", 1);
        $form->setTaille("dpc_moda_cess_paie_aut_prec", 80);
        $form->setTaille("dpc_ss_signe_demande_acqu", 1);
        $form->setTaille("dpc_ss_signe_recher_trouv_acqu", 1);
        $form->setTaille("dpc_notif_adr_prop", 1);
        $form->setTaille("dpc_notif_adr_manda", 1);
        $form->setTaille("dpc_obs", 80);
        $form->setTaille("co_peri_site_patri_remar", 1);
        $form->setTaille("co_abo_monu_hist", 1);
        $form->setTaille("co_inst_ouvr_trav_act_code_envir", 1);
        $form->setTaille("co_trav_auto_env", 1);
        $form->setTaille("co_derog_esp_prot", 1);
        $form->setTaille("ctx_reference_dsj", 30);
        $form->setTaille("co_piscine", 1);
        $form->setTaille("co_fin_lls", 1);
        $form->setTaille("co_fin_aa", 1);
        $form->setTaille("co_fin_ptz", 1);
        $form->setTaille("co_fin_autr", 80);
        $form->setTaille("dia_ss_date", 12);
        $form->setTaille("dia_ss_lieu", 30);
        $form->setTaille("enga_decla_lieu", 30);
        $form->setTaille("enga_decla_date", 12);
        $form->setTaille("co_archi_attest_honneur", 1);
        $form->setTaille("co_bat_niv_dessous_nb", 11);
        $form->setTaille("co_install_classe", 1);
        $form->setTaille("co_derog_innov", 1);
        $form->setTaille("co_avis_abf", 1);
        $form->setTaille("tax_surf_tot_demo", 10);
        $form->setTaille("tax_surf_tax_demo", 10);
        $form->setTaille("tax_su_non_habit_surf8", 10);
        $form->setTaille("tax_su_non_habit_surf_stat8", 10);
        $form->setTaille("tax_su_non_habit_surf9", 10);
        $form->setTaille("tax_su_non_habit_surf_stat9", 10);
        $form->setTaille("tax_terrassement_arch", 1);
        $form->setTaille("tax_adresse_future_numero", 30);
        $form->setTaille("tax_adresse_future_voie", 30);
        $form->setTaille("tax_adresse_future_lieudit", 30);
        $form->setTaille("tax_adresse_future_localite", 30);
        $form->setTaille("tax_adresse_future_cp", 30);
        $form->setTaille("tax_adresse_future_bp", 30);
        $form->setTaille("tax_adresse_future_cedex", 30);
        $form->setTaille("tax_adresse_future_pays", 30);
        $form->setTaille("tax_adresse_future_division", 30);
        $form->setTaille("co_bat_projete", 80);
        $form->setTaille("co_bat_existant", 80);
        $form->setTaille("co_bat_nature", 80);
        $form->setTaille("terr_juri_titul_date", 12);
        $form->setTaille("co_autre_desc", 80);
        $form->setTaille("co_trx_autre", 80);
        $form->setTaille("co_autre", 1);
        $form->setTaille("erp_modif_facades", 1);
        $form->setTaille("erp_trvx_adap", 1);
        $form->setTaille("erp_trvx_adap_numero", 30);
        $form->setTaille("erp_trvx_adap_valid", 12);
        $form->setTaille("erp_prod_dangereux", 1);
        $form->setTaille("co_trav_supp_dessus", 10);
        $form->setTaille("co_trav_supp_dessous", 10);
        $form->setTaille("tax_su_habit_abr_jard_pig_colom", 10);
        $form->setTaille("enga_decla_donnees_nomi_comm", 1);
        $form->setTaille("x1l_legislation", 1);
        $form->setTaille("x1p_precisions", 30);
        $form->setTaille("x1u_raccordement", 1);
        $form->setTaille("x2m_inscritmh", 1);
        $form->setTaille("s1na1_numero", 11);
        $form->setTaille("s1va1_voie", 30);
        $form->setTaille("s1wa1_lieudit", 30);
        $form->setTaille("s1la1_localite", 30);
        $form->setTaille("s1pa1_codepostal", 10);
        $form->setTaille("s1na2_numero", 11);
        $form->setTaille("s1va2_voie", 30);
        $form->setTaille("s1wa2_lieudit", 30);
        $form->setTaille("s1la2_localite", 30);
        $form->setTaille("s1pa2_codepostal", 10);
        $form->setTaille("e3c_certification", 1);
        $form->setTaille("e3a_competence", 1);
        $form->setTaille("a4d_description", 30);
        $form->setTaille("m2b_abf", 1);
        $form->setTaille("m2j_pn", 1);
        $form->setTaille("m2r_cdac", 1);
        $form->setTaille("m2r_cnac", 1);
        $form->setTaille("u3a_voirieoui", 1);
        $form->setTaille("u3f_voirienon", 1);
        $form->setTaille("u3c_eauoui", 1);
        $form->setTaille("u3h_eaunon", 1);
        $form->setTaille("u3g_assainissementoui", 1);
        $form->setTaille("u3n_assainissementnon", 1);
        $form->setTaille("u3m_electriciteoui", 1);
        $form->setTaille("u3b_electricitenon", 1);
        $form->setTaille("u3t_observations", 30);
        $form->setTaille("u1a_voirieoui", 1);
        $form->setTaille("u1v_voirienon", 1);
        $form->setTaille("u1q_voirieconcessionnaire", 30);
        $form->setTaille("u1b_voirieavant", 12);
        $form->setTaille("u1j_eauoui", 1);
        $form->setTaille("u1t_eaunon", 1);
        $form->setTaille("u1e_eauconcessionnaire", 30);
        $form->setTaille("u1k_eauavant", 12);
        $form->setTaille("u1s_assainissementoui", 1);
        $form->setTaille("u1d_assainissementnon", 1);
        $form->setTaille("u1l_assainissementconcessionnaire", 30);
        $form->setTaille("u1r_assainissementavant", 12);
        $form->setTaille("u1c_electriciteoui", 1);
        $form->setTaille("u1u_electricitenon", 1);
        $form->setTaille("u1m_electriciteconcessionnaire", 30);
        $form->setTaille("u1f_electriciteavant", 12);
        $form->setTaille("u2a_observations", 30);
        $form->setTaille("f1ts4_surftaxestation", 11);
        $form->setTaille("f1ut1_surfcree", 11);
        $form->setTaille("f9d_date", 12);
        $form->setTaille("f9n_nom", 30);
        $form->setTaille("su2_avt_shon21", 10);
        $form->setTaille("su2_avt_shon22", 10);
        $form->setTaille("su2_cstr_shon21", 10);
        $form->setTaille("su2_cstr_shon22", 10);
        $form->setTaille("su2_chge_shon21", 10);
        $form->setTaille("su2_chge_shon22", 10);
        $form->setTaille("su2_demo_shon21", 10);
        $form->setTaille("su2_demo_shon22", 10);
        $form->setTaille("su2_sup_shon21", 10);
        $form->setTaille("su2_sup_shon22", 10);
        $form->setTaille("su2_tot_shon21", 10);
        $form->setTaille("su2_tot_shon22", 10);
        $form->setTaille("f1gu1_f1gu2_f1gu3", 10);
        $form->setTaille("f1lu1_f1lu2_f1lu3", 10);
        $form->setTaille("f1zu1_f1zu2_f1zu3", 10);
        $form->setTaille("f1pu1_f1pu2_f1pu3", 10);
        $form->setTaille("f1gt4_f1gt5_f1gt6", 10);
        $form->setTaille("f1lt4_f1lt5_f1lt6", 10);
        $form->setTaille("f1zt4_f1zt5_f1zt6", 10);
        $form->setTaille("f1pt4_f1pt5_f1pt6", 10);
        $form->setTaille("f1xu1_f1xu2_f1xu3", 10);
        $form->setTaille("f1xt4_f1xt5_f1xt6", 10);
        $form->setTaille("f1hu1_f1hu2_f1hu3", 10);
        $form->setTaille("f1mu1_f1mu2_f1mu3", 10);
        $form->setTaille("f1qu1_f1qu2_f1qu3", 10);
        $form->setTaille("f1ht4_f1ht5_f1ht6", 10);
        $form->setTaille("f1mt4_f1mt5_f1mt6", 10);
        $form->setTaille("f1qt4_f1qt5_f1qt6", 10);
        $form->setTaille("f2cu1_f2cu2_f2cu3", 10);
        $form->setTaille("f2bu1_f2bu2_f2bu3", 10);
        $form->setTaille("f2su1_f2su2_f2su3", 10);
        $form->setTaille("f2hu1_f2hu2_f2hu3", 10);
        $form->setTaille("f2eu1_f2eu2_f2eu3", 10);
        $form->setTaille("f2qu1_f2qu2_f2qu3", 10);
        $form->setTaille("f2ct4_f2ct5_f2ct6", 10);
        $form->setTaille("f2bt4_f2bt5_f2bt6", 10);
        $form->setTaille("f2st4_f2st5_f2st6", 10);
        $form->setTaille("f2ht4_f2ht5_f2ht6", 10);
        $form->setTaille("f2et4_f2et5_f2et6", 10);
        $form->setTaille("f2qt4_f2qt5_f2qt6", 10);
        $form->setTaille("dia_droit_reel_perso_grevant_bien_desc", 80);
        $form->setTaille("dia_mod_cess_paie_nat_desc", 80);
        $form->setTaille("dia_mod_cess_rente_viag_desc", 80);
        $form->setTaille("dia_mod_cess_echange_desc", 80);
        $form->setTaille("dia_mod_cess_apport_societe_desc", 80);
        $form->setTaille("dia_mod_cess_cess_terr_loc_co_desc", 80);
        $form->setTaille("dia_mod_cess_esti_imm_loca_desc", 80);
        $form->setTaille("dia_mod_cess_adju_obl_desc", 80);
        $form->setTaille("dia_mod_cess_adju_fin_indivi_desc", 80);
        $form->setTaille("dia_cadre_titul_droit_prempt", 80);
        $form->setTaille("dia_mairie_prix_moyen", 10);
        $form->setTaille("dia_propri_indivi", 80);
        $form->setTaille("dia_situa_bien_plan_cadas_oui", 1);
        $form->setTaille("dia_situa_bien_plan_cadas_non", 1);
        $form->setTaille("dia_notif_dec_titul_adr_prop", 1);
        $form->setTaille("dia_notif_dec_titul_adr_prop_desc", 80);
        $form->setTaille("dia_notif_dec_titul_adr_manda", 1);
        $form->setTaille("dia_notif_dec_titul_adr_manda_desc", 80);
        $form->setTaille("dia_dia_dpu", 1);
        $form->setTaille("dia_dia_zad", 1);
        $form->setTaille("dia_dia_zone_preempt_esp_natu_sensi", 1);
        $form->setTaille("dia_dab_dpu", 1);
        $form->setTaille("dia_dab_zad", 1);
        $form->setTaille("dia_mod_cess_commi_mnt", 10);
        $form->setTaille("dia_mod_cess_commi_mnt_ttc", 1);
        $form->setTaille("dia_mod_cess_commi_mnt_ht", 1);
        $form->setTaille("dia_mod_cess_prix_vente_num", 10);
        $form->setTaille("dia_mod_cess_prix_vente_mob_num", 10);
        $form->setTaille("dia_mod_cess_prix_vente_cheptel_num", 10);
        $form->setTaille("dia_mod_cess_prix_vente_recol_num", 10);
        $form->setTaille("dia_mod_cess_prix_vente_autre_num", 10);
        $form->setTaille("dia_su_co_sol_num", 10);
        $form->setTaille("dia_su_util_hab_num", 10);
        $form->setTaille("dia_mod_cess_mnt_an_num", 10);
        $form->setTaille("dia_mod_cess_mnt_compt_num", 10);
        $form->setTaille("dia_mod_cess_mnt_soulte_num", 10);
        $form->setTaille("dia_comp_prix_vente", 10);
        $form->setTaille("dia_comp_surface", 10);
        $form->setTaille("dia_comp_total_frais", 10);
        $form->setTaille("dia_comp_mtn_total", 10);
        $form->setTaille("dia_comp_valeur_m2", 10);
        $form->setTaille("dia_esti_prix_france_dom", 10);
        $form->setTaille("dia_prop_collectivite", 10);
        $form->setTaille("dia_delegataire_denomination", 30);
        $form->setTaille("dia_delegataire_raison_sociale", 30);
        $form->setTaille("dia_delegataire_siret", 15);
        $form->setTaille("dia_delegataire_categorie_juridique", 15);
        $form->setTaille("dia_delegataire_representant_nom", 30);
        $form->setTaille("dia_delegataire_representant_prenom", 30);
        $form->setTaille("dia_delegataire_adresse_numero", 10);
        $form->setTaille("dia_delegataire_adresse_voie", 30);
        $form->setTaille("dia_delegataire_adresse_complement", 30);
        $form->setTaille("dia_delegataire_adresse_lieu_dit", 30);
        $form->setTaille("dia_delegataire_adresse_localite", 30);
        $form->setTaille("dia_delegataire_adresse_code_postal", 10);
        $form->setTaille("dia_delegataire_adresse_bp", 10);
        $form->setTaille("dia_delegataire_adresse_cedex", 10);
        $form->setTaille("dia_delegataire_adresse_pays", 30);
        $form->setTaille("dia_delegataire_telephone_fixe", 20);
        $form->setTaille("dia_delegataire_telephone_mobile", 20);
        $form->setTaille("dia_delegataire_telephone_mobile_indicatif", 10);
        $form->setTaille("dia_delegataire_courriel", 30);
        $form->setTaille("dia_delegataire_fax", 20);
        $form->setTaille("dia_entree_jouissance_type", 30);
        $form->setTaille("dia_entree_jouissance_date", 12);
        $form->setTaille("dia_entree_jouissance_date_effet", 12);
        $form->setTaille("dia_entree_jouissance_com", 80);
        $form->setTaille("dia_remise_bien_date_effet", 12);
        $form->setTaille("dia_remise_bien_com", 80);
        $form->setTaille("c2zp1_crete", 10);
        $form->setTaille("c2zr1_destination", 30);
        $form->setTaille("mh_design_appel_denom", 80);
        $form->setTaille("mh_design_type_protect", 30);
        $form->setTaille("mh_design_elem_prot", 80);
        $form->setTaille("mh_design_ref_merimee_palissy", 10);
        $form->setTaille("mh_design_nature_prop", 30);
        $form->setTaille("mh_loc_denom", 80);
        $form->setTaille("mh_pres_intitule", 80);
        $form->setTaille("mh_trav_cat_1", 1);
        $form->setTaille("mh_trav_cat_2", 1);
        $form->setTaille("mh_trav_cat_3", 1);
        $form->setTaille("mh_trav_cat_4", 1);
        $form->setTaille("mh_trav_cat_5", 1);
        $form->setTaille("mh_trav_cat_6", 1);
        $form->setTaille("mh_trav_cat_7", 1);
        $form->setTaille("mh_trav_cat_8", 1);
        $form->setTaille("mh_trav_cat_9", 1);
        $form->setTaille("mh_trav_cat_10", 1);
        $form->setTaille("mh_trav_cat_11", 1);
        $form->setTaille("mh_trav_cat_12", 1);
        $form->setTaille("mh_trav_cat_12_prec", 80);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("donnees_techniques", 11);
        $form->setMax("dossier_instruction", 255);
        $form->setMax("lot", 11);
        $form->setMax("am_lotiss", 1);
        $form->setMax("am_autre_div", 1);
        $form->setMax("am_camping", 1);
        $form->setMax("am_caravane", 1);
        $form->setMax("am_carav_duree", 11);
        $form->setMax("am_statio", 1);
        $form->setMax("am_statio_cont", 11);
        $form->setMax("am_affou_exhau", 1);
        $form->setMax("am_affou_exhau_sup", -5);
        $form->setMax("am_affou_prof", -5);
        $form->setMax("am_exhau_haut", -5);
        $form->setMax("am_coupe_abat", 1);
        $form->setMax("am_prot_plu", 1);
        $form->setMax("am_prot_muni", 1);
        $form->setMax("am_mobil_voyage", 1);
        $form->setMax("am_aire_voyage", 1);
        $form->setMax("am_rememb_afu", 1);
        $form->setMax("am_parc_resid_loi", 1);
        $form->setMax("am_sport_moto", 1);
        $form->setMax("am_sport_attrac", 1);
        $form->setMax("am_sport_golf", 1);
        $form->setMax("am_mob_art", 1);
        $form->setMax("am_modif_voie_esp", 1);
        $form->setMax("am_plant_voie_esp", 1);
        $form->setMax("am_chem_ouv_esp", 1);
        $form->setMax("am_agri_peche", 1);
        $form->setMax("am_crea_voie", 1);
        $form->setMax("am_modif_voie_exist", 1);
        $form->setMax("am_crea_esp_sauv", 1);
        $form->setMax("am_crea_esp_class", 1);
        $form->setMax("am_projet_desc", 6);
        $form->setMax("am_terr_surf", -5);
        $form->setMax("am_tranche_desc", 6);
        $form->setMax("am_lot_max_nb", 11);
        $form->setMax("am_lot_max_shon", -5);
        $form->setMax("am_lot_cstr_cos", 1);
        $form->setMax("am_lot_cstr_plan", 1);
        $form->setMax("am_lot_cstr_vente", 1);
        $form->setMax("am_lot_fin_diff", 1);
        $form->setMax("am_lot_consign", 1);
        $form->setMax("am_lot_gar_achev", 1);
        $form->setMax("am_lot_vente_ant", 1);
        $form->setMax("am_empl_nb", 11);
        $form->setMax("am_tente_nb", 11);
        $form->setMax("am_carav_nb", 11);
        $form->setMax("am_mobil_nb", 11);
        $form->setMax("am_pers_nb", 11);
        $form->setMax("am_empl_hll_nb", 11);
        $form->setMax("am_hll_shon", -5);
        $form->setMax("am_periode_exploit", 6);
        $form->setMax("am_exist_agrand", 1);
        $form->setMax("am_exist_date", 100);
        $form->setMax("am_exist_num", 100);
        $form->setMax("am_exist_nb_avant", 11);
        $form->setMax("am_exist_nb_apres", 11);
        $form->setMax("am_coupe_bois", 1);
        $form->setMax("am_coupe_parc", 1);
        $form->setMax("am_coupe_align", 1);
        $form->setMax("am_coupe_ess", 100);
        $form->setMax("am_coupe_age", 15);
        $form->setMax("am_coupe_dens", 100);
        $form->setMax("am_coupe_qual", 100);
        $form->setMax("am_coupe_trait", 100);
        $form->setMax("am_coupe_autr", 100);
        $form->setMax("co_archi_recours", 1);
        $form->setMax("co_cstr_nouv", 1);
        $form->setMax("co_cstr_exist", 1);
        $form->setMax("co_cloture", 1);
        $form->setMax("co_elec_tension", -5);
        $form->setMax("co_div_terr", 1);
        $form->setMax("co_projet_desc", 6);
        $form->setMax("co_anx_pisc", 1);
        $form->setMax("co_anx_gara", 1);
        $form->setMax("co_anx_veran", 1);
        $form->setMax("co_anx_abri", 1);
        $form->setMax("co_anx_autr", 1);
        $form->setMax("co_anx_autr_desc", 6);
        $form->setMax("co_tot_log_nb", 11);
        $form->setMax("co_tot_ind_nb", 11);
        $form->setMax("co_tot_coll_nb", 11);
        $form->setMax("co_mais_piece_nb", 11);
        $form->setMax("co_mais_niv_nb", 11);
        $form->setMax("co_fin_lls_nb", 11);
        $form->setMax("co_fin_aa_nb", 11);
        $form->setMax("co_fin_ptz_nb", 11);
        $form->setMax("co_fin_autr_nb", 11);
        $form->setMax("co_fin_autr_desc", 6);
        $form->setMax("co_mais_contrat_ind", 1);
        $form->setMax("co_uti_pers", 1);
        $form->setMax("co_uti_vente", 1);
        $form->setMax("co_uti_loc", 1);
        $form->setMax("co_uti_princ", 1);
        $form->setMax("co_uti_secon", 1);
        $form->setMax("co_resid_agees", 1);
        $form->setMax("co_resid_etud", 1);
        $form->setMax("co_resid_tourism", 1);
        $form->setMax("co_resid_hot_soc", 1);
        $form->setMax("co_resid_soc", 1);
        $form->setMax("co_resid_hand", 1);
        $form->setMax("co_resid_autr", 1);
        $form->setMax("co_resid_autr_desc", 6);
        $form->setMax("co_foyer_chamb_nb", 11);
        $form->setMax("co_log_1p_nb", 11);
        $form->setMax("co_log_2p_nb", 11);
        $form->setMax("co_log_3p_nb", 11);
        $form->setMax("co_log_4p_nb", 11);
        $form->setMax("co_log_5p_nb", 11);
        $form->setMax("co_log_6p_nb", 11);
        $form->setMax("co_bat_niv_nb", 11);
        $form->setMax("co_trx_exten", 1);
        $form->setMax("co_trx_surelev", 1);
        $form->setMax("co_trx_nivsup", 1);
        $form->setMax("co_demont_periode", 6);
        $form->setMax("co_sp_transport", 1);
        $form->setMax("co_sp_enseign", 1);
        $form->setMax("co_sp_act_soc", 1);
        $form->setMax("co_sp_ouvr_spe", 1);
        $form->setMax("co_sp_sante", 1);
        $form->setMax("co_sp_culture", 1);
        $form->setMax("co_statio_avt_nb", 11);
        $form->setMax("co_statio_apr_nb", 11);
        $form->setMax("co_statio_adr", 6);
        $form->setMax("co_statio_place_nb", 11);
        $form->setMax("co_statio_tot_surf", -5);
        $form->setMax("co_statio_tot_shob", -5);
        $form->setMax("co_statio_comm_cin_surf", -5);
        $form->setMax("su_avt_shon1", -5);
        $form->setMax("su_avt_shon2", -5);
        $form->setMax("su_avt_shon3", -5);
        $form->setMax("su_avt_shon4", -5);
        $form->setMax("su_avt_shon5", -5);
        $form->setMax("su_avt_shon6", -5);
        $form->setMax("su_avt_shon7", -5);
        $form->setMax("su_avt_shon8", -5);
        $form->setMax("su_avt_shon9", -5);
        $form->setMax("su_cstr_shon1", -5);
        $form->setMax("su_cstr_shon2", -5);
        $form->setMax("su_cstr_shon3", -5);
        $form->setMax("su_cstr_shon4", -5);
        $form->setMax("su_cstr_shon5", -5);
        $form->setMax("su_cstr_shon6", -5);
        $form->setMax("su_cstr_shon7", -5);
        $form->setMax("su_cstr_shon8", -5);
        $form->setMax("su_cstr_shon9", -5);
        $form->setMax("su_trsf_shon1", -5);
        $form->setMax("su_trsf_shon2", -5);
        $form->setMax("su_trsf_shon3", -5);
        $form->setMax("su_trsf_shon4", -5);
        $form->setMax("su_trsf_shon5", -5);
        $form->setMax("su_trsf_shon6", -5);
        $form->setMax("su_trsf_shon7", -5);
        $form->setMax("su_trsf_shon8", -5);
        $form->setMax("su_trsf_shon9", -5);
        $form->setMax("su_chge_shon1", -5);
        $form->setMax("su_chge_shon2", -5);
        $form->setMax("su_chge_shon3", -5);
        $form->setMax("su_chge_shon4", -5);
        $form->setMax("su_chge_shon5", -5);
        $form->setMax("su_chge_shon6", -5);
        $form->setMax("su_chge_shon7", -5);
        $form->setMax("su_chge_shon8", -5);
        $form->setMax("su_chge_shon9", -5);
        $form->setMax("su_demo_shon1", -5);
        $form->setMax("su_demo_shon2", -5);
        $form->setMax("su_demo_shon3", -5);
        $form->setMax("su_demo_shon4", -5);
        $form->setMax("su_demo_shon5", -5);
        $form->setMax("su_demo_shon6", -5);
        $form->setMax("su_demo_shon7", -5);
        $form->setMax("su_demo_shon8", -5);
        $form->setMax("su_demo_shon9", -5);
        $form->setMax("su_sup_shon1", -5);
        $form->setMax("su_sup_shon2", -5);
        $form->setMax("su_sup_shon3", -5);
        $form->setMax("su_sup_shon4", -5);
        $form->setMax("su_sup_shon5", -5);
        $form->setMax("su_sup_shon6", -5);
        $form->setMax("su_sup_shon7", -5);
        $form->setMax("su_sup_shon8", -5);
        $form->setMax("su_sup_shon9", -5);
        $form->setMax("su_tot_shon1", -5);
        $form->setMax("su_tot_shon2", -5);
        $form->setMax("su_tot_shon3", -5);
        $form->setMax("su_tot_shon4", -5);
        $form->setMax("su_tot_shon5", -5);
        $form->setMax("su_tot_shon6", -5);
        $form->setMax("su_tot_shon7", -5);
        $form->setMax("su_tot_shon8", -5);
        $form->setMax("su_tot_shon9", -5);
        $form->setMax("su_avt_shon_tot", -5);
        $form->setMax("su_cstr_shon_tot", -5);
        $form->setMax("su_trsf_shon_tot", -5);
        $form->setMax("su_chge_shon_tot", -5);
        $form->setMax("su_demo_shon_tot", -5);
        $form->setMax("su_sup_shon_tot", -5);
        $form->setMax("su_tot_shon_tot", -5);
        $form->setMax("dm_constr_dates", 6);
        $form->setMax("dm_total", 1);
        $form->setMax("dm_partiel", 1);
        $form->setMax("dm_projet_desc", 6);
        $form->setMax("dm_tot_log_nb", 11);
        $form->setMax("tax_surf_tot", -5);
        $form->setMax("tax_surf", -5);
        $form->setMax("tax_surf_suppr_mod", -5);
        $form->setMax("tax_su_princ_log_nb1", -5);
        $form->setMax("tax_su_princ_log_nb2", -5);
        $form->setMax("tax_su_princ_log_nb3", -5);
        $form->setMax("tax_su_princ_log_nb4", -5);
        $form->setMax("tax_su_princ_log_nb_tot1", -5);
        $form->setMax("tax_su_princ_log_nb_tot2", -5);
        $form->setMax("tax_su_princ_log_nb_tot3", -5);
        $form->setMax("tax_su_princ_log_nb_tot4", -5);
        $form->setMax("tax_su_princ_surf1", -5);
        $form->setMax("tax_su_princ_surf2", -5);
        $form->setMax("tax_su_princ_surf3", -5);
        $form->setMax("tax_su_princ_surf4", -5);
        $form->setMax("tax_su_princ_surf_sup1", -5);
        $form->setMax("tax_su_princ_surf_sup2", -5);
        $form->setMax("tax_su_princ_surf_sup3", -5);
        $form->setMax("tax_su_princ_surf_sup4", -5);
        $form->setMax("tax_su_heber_log_nb1", 11);
        $form->setMax("tax_su_heber_log_nb2", 11);
        $form->setMax("tax_su_heber_log_nb3", 11);
        $form->setMax("tax_su_heber_log_nb_tot1", 11);
        $form->setMax("tax_su_heber_log_nb_tot2", 11);
        $form->setMax("tax_su_heber_log_nb_tot3", 11);
        $form->setMax("tax_su_heber_surf1", -5);
        $form->setMax("tax_su_heber_surf2", -5);
        $form->setMax("tax_su_heber_surf3", -5);
        $form->setMax("tax_su_heber_surf_sup1", -5);
        $form->setMax("tax_su_heber_surf_sup2", -5);
        $form->setMax("tax_su_heber_surf_sup3", -5);
        $form->setMax("tax_su_secon_log_nb", 11);
        $form->setMax("tax_su_tot_log_nb", 11);
        $form->setMax("tax_su_secon_log_nb_tot", 11);
        $form->setMax("tax_su_tot_log_nb_tot", 11);
        $form->setMax("tax_su_secon_surf", -5);
        $form->setMax("tax_su_tot_surf", -5);
        $form->setMax("tax_su_secon_surf_sup", -5);
        $form->setMax("tax_su_tot_surf_sup", -5);
        $form->setMax("tax_ext_pret", 1);
        $form->setMax("tax_ext_desc", 6);
        $form->setMax("tax_surf_tax_exist_cons", -5);
        $form->setMax("tax_log_exist_nb", 11);
        $form->setMax("tax_am_statio_ext", 11);
        $form->setMax("tax_sup_bass_pisc", -5);
        $form->setMax("tax_empl_ten_carav_mobil_nb", 11);
        $form->setMax("tax_empl_hll_nb", 11);
        $form->setMax("tax_eol_haut_nb", 11);
        $form->setMax("tax_pann_volt_sup", -5);
        $form->setMax("tax_am_statio_ext_sup", 11);
        $form->setMax("tax_sup_bass_pisc_sup", -5);
        $form->setMax("tax_empl_ten_carav_mobil_nb_sup", 11);
        $form->setMax("tax_empl_hll_nb_sup", 11);
        $form->setMax("tax_eol_haut_nb_sup", 11);
        $form->setMax("tax_pann_volt_sup_sup", -5);
        $form->setMax("tax_trx_presc_ppr", 1);
        $form->setMax("tax_monu_hist", 1);
        $form->setMax("tax_comm_nb", 11);
        $form->setMax("tax_su_non_habit_surf1", -5);
        $form->setMax("tax_su_non_habit_surf2", -5);
        $form->setMax("tax_su_non_habit_surf3", -5);
        $form->setMax("tax_su_non_habit_surf4", -5);
        $form->setMax("tax_su_non_habit_surf5", -5);
        $form->setMax("tax_su_non_habit_surf6", -5);
        $form->setMax("tax_su_non_habit_surf7", -5);
        $form->setMax("tax_su_non_habit_surf_sup1", -5);
        $form->setMax("tax_su_non_habit_surf_sup2", -5);
        $form->setMax("tax_su_non_habit_surf_sup3", -5);
        $form->setMax("tax_su_non_habit_surf_sup4", -5);
        $form->setMax("tax_su_non_habit_surf_sup5", -5);
        $form->setMax("tax_su_non_habit_surf_sup6", -5);
        $form->setMax("tax_su_non_habit_surf_sup7", -5);
        $form->setMax("vsd_surf_planch_smd", 1);
        $form->setMax("vsd_unit_fonc_sup", -5);
        $form->setMax("vsd_unit_fonc_constr_sup", -5);
        $form->setMax("vsd_val_terr", -5);
        $form->setMax("vsd_const_sxist_non_dem_surf", -5);
        $form->setMax("vsd_rescr_fisc", 12);
        $form->setMax("pld_val_terr", -5);
        $form->setMax("pld_const_exist_dem", 1);
        $form->setMax("pld_const_exist_dem_surf", -5);
        $form->setMax("code_cnil", 1);
        $form->setMax("terr_juri_titul", 20);
        $form->setMax("terr_juri_lot", 20);
        $form->setMax("terr_juri_zac", 20);
        $form->setMax("terr_juri_afu", 20);
        $form->setMax("terr_juri_pup", 20);
        $form->setMax("terr_juri_oin", 20);
        $form->setMax("terr_juri_desc", 6);
        $form->setMax("terr_div_surf_etab", -5);
        $form->setMax("terr_div_surf_av_div", -5);
        $form->setMax("doc_date", 12);
        $form->setMax("doc_tot_trav", 1);
        $form->setMax("doc_tranche_trav", 1);
        $form->setMax("doc_tranche_trav_desc", 6);
        $form->setMax("doc_surf", -5);
        $form->setMax("doc_nb_log", 11);
        $form->setMax("doc_nb_log_indiv", 11);
        $form->setMax("doc_nb_log_coll", 11);
        $form->setMax("doc_nb_log_lls", 11);
        $form->setMax("doc_nb_log_aa", 11);
        $form->setMax("doc_nb_log_ptz", 11);
        $form->setMax("doc_nb_log_autre", 11);
        $form->setMax("daact_date", 12);
        $form->setMax("daact_date_chgmt_dest", 12);
        $form->setMax("daact_tot_trav", 1);
        $form->setMax("daact_tranche_trav", 1);
        $form->setMax("daact_tranche_trav_desc", 6);
        $form->setMax("daact_surf", -5);
        $form->setMax("daact_nb_log", 11);
        $form->setMax("daact_nb_log_indiv", 11);
        $form->setMax("daact_nb_log_coll", 11);
        $form->setMax("daact_nb_log_lls", 11);
        $form->setMax("daact_nb_log_aa", 11);
        $form->setMax("daact_nb_log_ptz", 11);
        $form->setMax("daact_nb_log_autre", 11);
        $form->setMax("dossier_autorisation", 255);
        $form->setMax("am_div_mun", 1);
        $form->setMax("co_perf_energ", 40);
        $form->setMax("architecte", 11);
        $form->setMax("co_statio_avt_shob", 250);
        $form->setMax("co_statio_apr_shob", 250);
        $form->setMax("co_statio_avt_surf", 250);
        $form->setMax("co_statio_apr_surf", 250);
        $form->setMax("co_trx_amgt", 250);
        $form->setMax("co_modif_aspect", 250);
        $form->setMax("co_modif_struct", 250);
        $form->setMax("co_ouvr_elec", 1);
        $form->setMax("co_ouvr_infra", 1);
        $form->setMax("co_trx_imm", 250);
        $form->setMax("co_cstr_shob", 250);
        $form->setMax("am_voyage_deb", 250);
        $form->setMax("am_voyage_fin", 250);
        $form->setMax("am_modif_amgt", 250);
        $form->setMax("am_lot_max_shob", 250);
        $form->setMax("mod_desc", 250);
        $form->setMax("tr_total", 250);
        $form->setMax("tr_partiel", 250);
        $form->setMax("tr_desc", 250);
        $form->setMax("avap_co_elt_pro", 1);
        $form->setMax("avap_nouv_haut_surf", 1);
        $form->setMax("avap_co_clot", 250);
        $form->setMax("avap_aut_coup_aba_arb", 250);
        $form->setMax("avap_ouv_infra", 250);
        $form->setMax("avap_aut_inst_mob", 250);
        $form->setMax("avap_aut_plant", 250);
        $form->setMax("avap_aut_auv_elec", 250);
        $form->setMax("tax_dest_loc_tr", 250);
        $form->setMax("ope_proj_desc", 6);
        $form->setMax("tax_surf_tot_cstr", 11);
        $form->setMax("cerfa", 11);
        $form->setMax("tax_surf_loc_stat", 11);
        $form->setMax("tax_su_princ_surf_stat1", -5);
        $form->setMax("tax_su_princ_surf_stat2", -5);
        $form->setMax("tax_su_princ_surf_stat3", -5);
        $form->setMax("tax_su_princ_surf_stat4", -5);
        $form->setMax("tax_su_secon_surf_stat", -5);
        $form->setMax("tax_su_heber_surf_stat1", -5);
        $form->setMax("tax_su_heber_surf_stat2", -5);
        $form->setMax("tax_su_heber_surf_stat3", -5);
        $form->setMax("tax_su_tot_surf_stat", -5);
        $form->setMax("tax_su_non_habit_surf_stat1", -5);
        $form->setMax("tax_su_non_habit_surf_stat2", -5);
        $form->setMax("tax_su_non_habit_surf_stat3", -5);
        $form->setMax("tax_su_non_habit_surf_stat4", -5);
        $form->setMax("tax_su_non_habit_surf_stat5", -5);
        $form->setMax("tax_su_non_habit_surf_stat6", -5);
        $form->setMax("tax_su_non_habit_surf_stat7", -5);
        $form->setMax("tax_su_parc_statio_expl_comm_surf", -5);
        $form->setMax("tax_log_ap_trvx_nb", 11);
        $form->setMax("tax_am_statio_ext_cr", 11);
        $form->setMax("tax_sup_bass_pisc_cr", -5);
        $form->setMax("tax_empl_ten_carav_mobil_nb_cr", 11);
        $form->setMax("tax_empl_hll_nb_cr", 11);
        $form->setMax("tax_eol_haut_nb_cr", 11);
        $form->setMax("tax_pann_volt_sup_cr", -5);
        $form->setMax("tax_surf_loc_arch", -5);
        $form->setMax("tax_surf_pisc_arch", -5);
        $form->setMax("tax_am_statio_ext_arch", -5);
        $form->setMax("tax_empl_ten_carav_mobil_nb_arch", -5);
        $form->setMax("tax_empl_hll_nb_arch", -5);
        $form->setMax("tax_eol_haut_nb_arch", 11);
        $form->setMax("ope_proj_div_co", 1);
        $form->setMax("ope_proj_div_contr", 1);
        $form->setMax("tax_desc", 6);
        $form->setMax("erp_cstr_neuve", 1);
        $form->setMax("erp_trvx_acc", 1);
        $form->setMax("erp_extension", 1);
        $form->setMax("erp_rehab", 1);
        $form->setMax("erp_trvx_am", 1);
        $form->setMax("erp_vol_nouv_exist", 1);
        $form->setMax("erp_loc_eff1", 250);
        $form->setMax("erp_loc_eff2", 250);
        $form->setMax("erp_loc_eff3", 250);
        $form->setMax("erp_loc_eff4", 250);
        $form->setMax("erp_loc_eff5", 250);
        $form->setMax("erp_loc_eff_tot", 250);
        $form->setMax("erp_public_eff1", -5);
        $form->setMax("erp_public_eff2", -5);
        $form->setMax("erp_public_eff3", -5);
        $form->setMax("erp_public_eff4", -5);
        $form->setMax("erp_public_eff5", -5);
        $form->setMax("erp_public_eff_tot", -5);
        $form->setMax("erp_perso_eff1", -5);
        $form->setMax("erp_perso_eff2", -5);
        $form->setMax("erp_perso_eff3", -5);
        $form->setMax("erp_perso_eff4", -5);
        $form->setMax("erp_perso_eff5", -5);
        $form->setMax("erp_perso_eff_tot", -5);
        $form->setMax("erp_tot_eff1", -5);
        $form->setMax("erp_tot_eff2", -5);
        $form->setMax("erp_tot_eff3", -5);
        $form->setMax("erp_tot_eff4", -5);
        $form->setMax("erp_tot_eff5", -5);
        $form->setMax("erp_tot_eff_tot", -5);
        $form->setMax("erp_class_cat", 11);
        $form->setMax("erp_class_type", 11);
        $form->setMax("tax_surf_abr_jard_pig_colom", -5);
        $form->setMax("tax_su_non_habit_abr_jard_pig_colom", -5);
        $form->setMax("dia_imm_non_bati", 1);
        $form->setMax("dia_imm_bati_terr_propr", 1);
        $form->setMax("dia_imm_bati_terr_autr", 1);
        $form->setMax("dia_imm_bati_terr_autr_desc", 6);
        $form->setMax("dia_bat_copro", 1);
        $form->setMax("dia_bat_copro_desc", 6);
        $form->setMax("dia_lot_numero", 6);
        $form->setMax("dia_lot_bat", 6);
        $form->setMax("dia_lot_etage", 6);
        $form->setMax("dia_lot_quote_part", 6);
        $form->setMax("dia_us_hab", 1);
        $form->setMax("dia_us_pro", 1);
        $form->setMax("dia_us_mixte", 1);
        $form->setMax("dia_us_comm", 1);
        $form->setMax("dia_us_agr", 1);
        $form->setMax("dia_us_autre", 1);
        $form->setMax("dia_us_autre_prec", 6);
        $form->setMax("dia_occ_prop", 1);
        $form->setMax("dia_occ_loc", 1);
        $form->setMax("dia_occ_sans_occ", 1);
        $form->setMax("dia_occ_autre", 1);
        $form->setMax("dia_occ_autre_prec", 6);
        $form->setMax("dia_mod_cess_prix_vente", 250);
        $form->setMax("dia_mod_cess_prix_vente_mob", 250);
        $form->setMax("dia_mod_cess_prix_vente_cheptel", 250);
        $form->setMax("dia_mod_cess_prix_vente_recol", 250);
        $form->setMax("dia_mod_cess_prix_vente_autre", 250);
        $form->setMax("dia_mod_cess_commi", 1);
        $form->setMax("dia_mod_cess_commi_ttc", 250);
        $form->setMax("dia_mod_cess_commi_ht", 250);
        $form->setMax("dia_acquereur_nom_prenom", 150);
        $form->setMax("dia_acquereur_adr_num_voie", 10);
        $form->setMax("dia_acquereur_adr_ext", 55);
        $form->setMax("dia_acquereur_adr_type_voie", 20);
        $form->setMax("dia_acquereur_adr_nom_voie", 55);
        $form->setMax("dia_acquereur_adr_lieu_dit_bp", 39);
        $form->setMax("dia_acquereur_adr_cp", 5);
        $form->setMax("dia_acquereur_adr_localite", 250);
        $form->setMax("dia_observation", 6);
        $form->setMax("su2_avt_shon1", -5);
        $form->setMax("su2_avt_shon2", -5);
        $form->setMax("su2_avt_shon3", -5);
        $form->setMax("su2_avt_shon4", -5);
        $form->setMax("su2_avt_shon5", -5);
        $form->setMax("su2_avt_shon6", -5);
        $form->setMax("su2_avt_shon7", -5);
        $form->setMax("su2_avt_shon8", -5);
        $form->setMax("su2_avt_shon9", -5);
        $form->setMax("su2_avt_shon10", -5);
        $form->setMax("su2_avt_shon11", -5);
        $form->setMax("su2_avt_shon12", -5);
        $form->setMax("su2_avt_shon13", -5);
        $form->setMax("su2_avt_shon14", -5);
        $form->setMax("su2_avt_shon15", -5);
        $form->setMax("su2_avt_shon16", -5);
        $form->setMax("su2_avt_shon17", -5);
        $form->setMax("su2_avt_shon18", -5);
        $form->setMax("su2_avt_shon19", -5);
        $form->setMax("su2_avt_shon20", -5);
        $form->setMax("su2_avt_shon_tot", -5);
        $form->setMax("su2_cstr_shon1", -5);
        $form->setMax("su2_cstr_shon2", -5);
        $form->setMax("su2_cstr_shon3", -5);
        $form->setMax("su2_cstr_shon4", -5);
        $form->setMax("su2_cstr_shon5", -5);
        $form->setMax("su2_cstr_shon6", -5);
        $form->setMax("su2_cstr_shon7", -5);
        $form->setMax("su2_cstr_shon8", -5);
        $form->setMax("su2_cstr_shon9", -5);
        $form->setMax("su2_cstr_shon10", -5);
        $form->setMax("su2_cstr_shon11", -5);
        $form->setMax("su2_cstr_shon12", -5);
        $form->setMax("su2_cstr_shon13", -5);
        $form->setMax("su2_cstr_shon14", -5);
        $form->setMax("su2_cstr_shon15", -5);
        $form->setMax("su2_cstr_shon16", -5);
        $form->setMax("su2_cstr_shon17", -5);
        $form->setMax("su2_cstr_shon18", -5);
        $form->setMax("su2_cstr_shon19", -5);
        $form->setMax("su2_cstr_shon20", -5);
        $form->setMax("su2_cstr_shon_tot", -5);
        $form->setMax("su2_chge_shon1", -5);
        $form->setMax("su2_chge_shon2", -5);
        $form->setMax("su2_chge_shon3", -5);
        $form->setMax("su2_chge_shon4", -5);
        $form->setMax("su2_chge_shon5", -5);
        $form->setMax("su2_chge_shon6", -5);
        $form->setMax("su2_chge_shon7", -5);
        $form->setMax("su2_chge_shon8", -5);
        $form->setMax("su2_chge_shon9", -5);
        $form->setMax("su2_chge_shon10", -5);
        $form->setMax("su2_chge_shon11", -5);
        $form->setMax("su2_chge_shon12", -5);
        $form->setMax("su2_chge_shon13", -5);
        $form->setMax("su2_chge_shon14", -5);
        $form->setMax("su2_chge_shon15", -5);
        $form->setMax("su2_chge_shon16", -5);
        $form->setMax("su2_chge_shon17", -5);
        $form->setMax("su2_chge_shon18", -5);
        $form->setMax("su2_chge_shon19", -5);
        $form->setMax("su2_chge_shon20", -5);
        $form->setMax("su2_chge_shon_tot", -5);
        $form->setMax("su2_demo_shon1", -5);
        $form->setMax("su2_demo_shon2", -5);
        $form->setMax("su2_demo_shon3", -5);
        $form->setMax("su2_demo_shon4", -5);
        $form->setMax("su2_demo_shon5", -5);
        $form->setMax("su2_demo_shon6", -5);
        $form->setMax("su2_demo_shon7", -5);
        $form->setMax("su2_demo_shon8", -5);
        $form->setMax("su2_demo_shon9", -5);
        $form->setMax("su2_demo_shon10", -5);
        $form->setMax("su2_demo_shon11", -5);
        $form->setMax("su2_demo_shon12", -5);
        $form->setMax("su2_demo_shon13", -5);
        $form->setMax("su2_demo_shon14", -5);
        $form->setMax("su2_demo_shon15", -5);
        $form->setMax("su2_demo_shon16", -5);
        $form->setMax("su2_demo_shon17", -5);
        $form->setMax("su2_demo_shon18", -5);
        $form->setMax("su2_demo_shon19", -5);
        $form->setMax("su2_demo_shon20", -5);
        $form->setMax("su2_demo_shon_tot", -5);
        $form->setMax("su2_sup_shon1", -5);
        $form->setMax("su2_sup_shon2", -5);
        $form->setMax("su2_sup_shon3", -5);
        $form->setMax("su2_sup_shon4", -5);
        $form->setMax("su2_sup_shon5", -5);
        $form->setMax("su2_sup_shon6", -5);
        $form->setMax("su2_sup_shon7", -5);
        $form->setMax("su2_sup_shon8", -5);
        $form->setMax("su2_sup_shon9", -5);
        $form->setMax("su2_sup_shon10", -5);
        $form->setMax("su2_sup_shon11", -5);
        $form->setMax("su2_sup_shon12", -5);
        $form->setMax("su2_sup_shon13", -5);
        $form->setMax("su2_sup_shon14", -5);
        $form->setMax("su2_sup_shon15", -5);
        $form->setMax("su2_sup_shon16", -5);
        $form->setMax("su2_sup_shon17", -5);
        $form->setMax("su2_sup_shon18", -5);
        $form->setMax("su2_sup_shon19", -5);
        $form->setMax("su2_sup_shon20", -5);
        $form->setMax("su2_sup_shon_tot", -5);
        $form->setMax("su2_tot_shon1", -5);
        $form->setMax("su2_tot_shon2", -5);
        $form->setMax("su2_tot_shon3", -5);
        $form->setMax("su2_tot_shon4", -5);
        $form->setMax("su2_tot_shon5", -5);
        $form->setMax("su2_tot_shon6", -5);
        $form->setMax("su2_tot_shon7", -5);
        $form->setMax("su2_tot_shon8", -5);
        $form->setMax("su2_tot_shon9", -5);
        $form->setMax("su2_tot_shon10", -5);
        $form->setMax("su2_tot_shon11", -5);
        $form->setMax("su2_tot_shon12", -5);
        $form->setMax("su2_tot_shon13", -5);
        $form->setMax("su2_tot_shon14", -5);
        $form->setMax("su2_tot_shon15", -5);
        $form->setMax("su2_tot_shon16", -5);
        $form->setMax("su2_tot_shon17", -5);
        $form->setMax("su2_tot_shon18", -5);
        $form->setMax("su2_tot_shon19", -5);
        $form->setMax("su2_tot_shon20", -5);
        $form->setMax("su2_tot_shon_tot", -5);
        $form->setMax("dia_occ_sol_su_terre", 6);
        $form->setMax("dia_occ_sol_su_pres", 6);
        $form->setMax("dia_occ_sol_su_verger", 6);
        $form->setMax("dia_occ_sol_su_vigne", 6);
        $form->setMax("dia_occ_sol_su_bois", 6);
        $form->setMax("dia_occ_sol_su_lande", 6);
        $form->setMax("dia_occ_sol_su_carriere", 6);
        $form->setMax("dia_occ_sol_su_eau_cadastree", 6);
        $form->setMax("dia_occ_sol_su_jardin", 6);
        $form->setMax("dia_occ_sol_su_terr_batir", 6);
        $form->setMax("dia_occ_sol_su_terr_agr", 6);
        $form->setMax("dia_occ_sol_su_sol", 6);
        $form->setMax("dia_bati_vend_tot", 1);
        $form->setMax("dia_bati_vend_tot_txt", 6);
        $form->setMax("dia_su_co_sol", 6);
        $form->setMax("dia_su_util_hab", 6);
        $form->setMax("dia_nb_niv", 6);
        $form->setMax("dia_nb_appart", 6);
        $form->setMax("dia_nb_autre_loc", 6);
        $form->setMax("dia_vente_lot_volume", 1);
        $form->setMax("dia_vente_lot_volume_txt", 6);
        $form->setMax("dia_lot_nat_su", 6);
        $form->setMax("dia_lot_bat_achv_plus_10", 1);
        $form->setMax("dia_lot_bat_achv_moins_10", 1);
        $form->setMax("dia_lot_regl_copro_publ_hypo_plus_10", 1);
        $form->setMax("dia_lot_regl_copro_publ_hypo_moins_10", 1);
        $form->setMax("dia_indivi_quote_part", 6);
        $form->setMax("dia_design_societe", 6);
        $form->setMax("dia_design_droit", 6);
        $form->setMax("dia_droit_soc_nat", 6);
        $form->setMax("dia_droit_soc_nb", 6);
        $form->setMax("dia_droit_soc_num_part", 6);
        $form->setMax("dia_droit_reel_perso_grevant_bien_oui", 1);
        $form->setMax("dia_droit_reel_perso_grevant_bien_non", 1);
        $form->setMax("dia_droit_reel_perso_nat", 6);
        $form->setMax("dia_droit_reel_perso_viag", 6);
        $form->setMax("dia_mod_cess_adr", 6);
        $form->setMax("dia_mod_cess_sign_act_auth", 1);
        $form->setMax("dia_mod_cess_terme", 1);
        $form->setMax("dia_mod_cess_terme_prec", 6);
        $form->setMax("dia_mod_cess_bene_acquereur", 1);
        $form->setMax("dia_mod_cess_bene_vendeur", 1);
        $form->setMax("dia_mod_cess_paie_nat", 1);
        $form->setMax("dia_mod_cess_design_contr_alien", 6);
        $form->setMax("dia_mod_cess_eval_contr", 6);
        $form->setMax("dia_mod_cess_rente_viag", 1);
        $form->setMax("dia_mod_cess_mnt_an", 6);
        $form->setMax("dia_mod_cess_mnt_compt", 6);
        $form->setMax("dia_mod_cess_bene_rente", 6);
        $form->setMax("dia_mod_cess_droit_usa_hab", 1);
        $form->setMax("dia_mod_cess_droit_usa_hab_prec", 6);
        $form->setMax("dia_mod_cess_eval_usa_usufruit", 6);
        $form->setMax("dia_mod_cess_vente_nue_prop", 1);
        $form->setMax("dia_mod_cess_vente_nue_prop_prec", 6);
        $form->setMax("dia_mod_cess_echange", 1);
        $form->setMax("dia_mod_cess_design_bien_recus_ech", 6);
        $form->setMax("dia_mod_cess_mnt_soulte", 6);
        $form->setMax("dia_mod_cess_prop_contre_echan", 6);
        $form->setMax("dia_mod_cess_apport_societe", 6);
        $form->setMax("dia_mod_cess_bene", 6);
        $form->setMax("dia_mod_cess_esti_bien", 6);
        $form->setMax("dia_mod_cess_cess_terr_loc_co", 1);
        $form->setMax("dia_mod_cess_esti_terr", 6);
        $form->setMax("dia_mod_cess_esti_loc", 6);
        $form->setMax("dia_mod_cess_esti_imm_loca", 1);
        $form->setMax("dia_mod_cess_adju_vol", 1);
        $form->setMax("dia_mod_cess_adju_obl", 1);
        $form->setMax("dia_mod_cess_adju_fin_indivi", 1);
        $form->setMax("dia_mod_cess_adju_date_lieu", 6);
        $form->setMax("dia_mod_cess_mnt_mise_prix", 6);
        $form->setMax("dia_prop_titu_prix_indique", 1);
        $form->setMax("dia_prop_recherche_acqu_prix_indique", 1);
        $form->setMax("dia_acquereur_prof", 6);
        $form->setMax("dia_indic_compl_ope", 6);
        $form->setMax("dia_vente_adju", 1);
        $form->setMax("am_terr_res_demon", 1);
        $form->setMax("am_air_terr_res_mob", 1);
        $form->setMax("ctx_objet_recours", 11);
        $form->setMax("ctx_reference_sagace", 255);
        $form->setMax("ctx_nature_travaux_infra_om_html", 6);
        $form->setMax("ctx_synthese_nti", 6);
        $form->setMax("ctx_article_non_resp_om_html", 6);
        $form->setMax("ctx_synthese_anr", 6);
        $form->setMax("ctx_reference_parquet", 255);
        $form->setMax("ctx_element_taxation", 255);
        $form->setMax("ctx_infraction", 1);
        $form->setMax("ctx_regularisable", 1);
        $form->setMax("ctx_reference_courrier", 255);
        $form->setMax("ctx_date_audience", 12);
        $form->setMax("ctx_date_ajournement", 12);
        $form->setMax("exo_facul_1", 1);
        $form->setMax("exo_facul_2", 1);
        $form->setMax("exo_facul_3", 1);
        $form->setMax("exo_facul_4", 1);
        $form->setMax("exo_facul_5", 1);
        $form->setMax("exo_facul_6", 1);
        $form->setMax("exo_facul_7", 1);
        $form->setMax("exo_facul_8", 1);
        $form->setMax("exo_facul_9", 1);
        $form->setMax("exo_ta_1", 1);
        $form->setMax("exo_ta_2", 1);
        $form->setMax("exo_ta_3", 1);
        $form->setMax("exo_ta_4", 1);
        $form->setMax("exo_ta_5", 1);
        $form->setMax("exo_ta_6", 1);
        $form->setMax("exo_ta_7", 1);
        $form->setMax("exo_ta_8", 1);
        $form->setMax("exo_ta_9", 1);
        $form->setMax("exo_rap_1", 1);
        $form->setMax("exo_rap_2", 1);
        $form->setMax("exo_rap_3", 1);
        $form->setMax("exo_rap_4", 1);
        $form->setMax("exo_rap_5", 1);
        $form->setMax("exo_rap_6", 1);
        $form->setMax("exo_rap_7", 1);
        $form->setMax("exo_rap_8", 1);
        $form->setMax("mtn_exo_ta_part_commu", -5);
        $form->setMax("mtn_exo_ta_part_depart", -5);
        $form->setMax("mtn_exo_ta_part_reg", -5);
        $form->setMax("mtn_exo_rap", -5);
        $form->setMax("dpc_type", 100);
        $form->setMax("dpc_desc_actv_ex", 6);
        $form->setMax("dpc_desc_ca", 6);
        $form->setMax("dpc_desc_aut_prec", 6);
        $form->setMax("dpc_desig_comm_arti", 1);
        $form->setMax("dpc_desig_loc_hab", 1);
        $form->setMax("dpc_desig_loc_ann", 1);
        $form->setMax("dpc_desig_loc_ann_prec", 6);
        $form->setMax("dpc_bail_comm_date", 12);
        $form->setMax("dpc_bail_comm_loyer", 6);
        $form->setMax("dpc_actv_acqu", 6);
        $form->setMax("dpc_nb_sala_di", 6);
        $form->setMax("dpc_nb_sala_dd", 6);
        $form->setMax("dpc_nb_sala_tc", 6);
        $form->setMax("dpc_nb_sala_tp", 6);
        $form->setMax("dpc_moda_cess_vente_am", 1);
        $form->setMax("dpc_moda_cess_adj", 1);
        $form->setMax("dpc_moda_cess_prix", 6);
        $form->setMax("dpc_moda_cess_adj_date", 12);
        $form->setMax("dpc_moda_cess_adj_prec", 6);
        $form->setMax("dpc_moda_cess_paie_comp", 1);
        $form->setMax("dpc_moda_cess_paie_terme", 1);
        $form->setMax("dpc_moda_cess_paie_terme_prec", 6);
        $form->setMax("dpc_moda_cess_paie_nat", 1);
        $form->setMax("dpc_moda_cess_paie_nat_desig_alien", 1);
        $form->setMax("dpc_moda_cess_paie_nat_desig_alien_prec", 6);
        $form->setMax("dpc_moda_cess_paie_nat_eval", 1);
        $form->setMax("dpc_moda_cess_paie_nat_eval_prec", 6);
        $form->setMax("dpc_moda_cess_paie_aut", 1);
        $form->setMax("dpc_moda_cess_paie_aut_prec", 6);
        $form->setMax("dpc_ss_signe_demande_acqu", 1);
        $form->setMax("dpc_ss_signe_recher_trouv_acqu", 1);
        $form->setMax("dpc_notif_adr_prop", 1);
        $form->setMax("dpc_notif_adr_manda", 1);
        $form->setMax("dpc_obs", 6);
        $form->setMax("co_peri_site_patri_remar", 1);
        $form->setMax("co_abo_monu_hist", 1);
        $form->setMax("co_inst_ouvr_trav_act_code_envir", 1);
        $form->setMax("co_trav_auto_env", 1);
        $form->setMax("co_derog_esp_prot", 1);
        $form->setMax("ctx_reference_dsj", 30);
        $form->setMax("co_piscine", 1);
        $form->setMax("co_fin_lls", 1);
        $form->setMax("co_fin_aa", 1);
        $form->setMax("co_fin_ptz", 1);
        $form->setMax("co_fin_autr", 6);
        $form->setMax("dia_ss_date", 12);
        $form->setMax("dia_ss_lieu", 255);
        $form->setMax("enga_decla_lieu", 255);
        $form->setMax("enga_decla_date", 12);
        $form->setMax("co_archi_attest_honneur", 1);
        $form->setMax("co_bat_niv_dessous_nb", 11);
        $form->setMax("co_install_classe", 1);
        $form->setMax("co_derog_innov", 1);
        $form->setMax("co_avis_abf", 1);
        $form->setMax("tax_surf_tot_demo", -5);
        $form->setMax("tax_surf_tax_demo", -5);
        $form->setMax("tax_su_non_habit_surf8", -5);
        $form->setMax("tax_su_non_habit_surf_stat8", -5);
        $form->setMax("tax_su_non_habit_surf9", -5);
        $form->setMax("tax_su_non_habit_surf_stat9", -5);
        $form->setMax("tax_terrassement_arch", 1);
        $form->setMax("tax_adresse_future_numero", 255);
        $form->setMax("tax_adresse_future_voie", 255);
        $form->setMax("tax_adresse_future_lieudit", 255);
        $form->setMax("tax_adresse_future_localite", 255);
        $form->setMax("tax_adresse_future_cp", 255);
        $form->setMax("tax_adresse_future_bp", 255);
        $form->setMax("tax_adresse_future_cedex", 255);
        $form->setMax("tax_adresse_future_pays", 255);
        $form->setMax("tax_adresse_future_division", 255);
        $form->setMax("co_bat_projete", 6);
        $form->setMax("co_bat_existant", 6);
        $form->setMax("co_bat_nature", 6);
        $form->setMax("terr_juri_titul_date", 12);
        $form->setMax("co_autre_desc", 6);
        $form->setMax("co_trx_autre", 6);
        $form->setMax("co_autre", 1);
        $form->setMax("erp_modif_facades", 1);
        $form->setMax("erp_trvx_adap", 1);
        $form->setMax("erp_trvx_adap_numero", 255);
        $form->setMax("erp_trvx_adap_valid", 12);
        $form->setMax("erp_prod_dangereux", 1);
        $form->setMax("co_trav_supp_dessus", -5);
        $form->setMax("co_trav_supp_dessous", -5);
        $form->setMax("tax_su_habit_abr_jard_pig_colom", -5);
        $form->setMax("enga_decla_donnees_nomi_comm", 1);
        $form->setMax("x1l_legislation", 1);
        $form->setMax("x1p_precisions", 40);
        $form->setMax("x1u_raccordement", 1);
        $form->setMax("x2m_inscritmh", 1);
        $form->setMax("s1na1_numero", 11);
        $form->setMax("s1va1_voie", 40);
        $form->setMax("s1wa1_lieudit", 40);
        $form->setMax("s1la1_localite", 60);
        $form->setMax("s1pa1_codepostal", 5);
        $form->setMax("s1na2_numero", 11);
        $form->setMax("s1va2_voie", 40);
        $form->setMax("s1wa2_lieudit", 40);
        $form->setMax("s1la2_localite", 60);
        $form->setMax("s1pa2_codepostal", 5);
        $form->setMax("e3c_certification", 1);
        $form->setMax("e3a_competence", 1);
        $form->setMax("a4d_description", 1000);
        $form->setMax("m2b_abf", 1);
        $form->setMax("m2j_pn", 1);
        $form->setMax("m2r_cdac", 1);
        $form->setMax("m2r_cnac", 1);
        $form->setMax("u3a_voirieoui", 1);
        $form->setMax("u3f_voirienon", 1);
        $form->setMax("u3c_eauoui", 1);
        $form->setMax("u3h_eaunon", 1);
        $form->setMax("u3g_assainissementoui", 1);
        $form->setMax("u3n_assainissementnon", 1);
        $form->setMax("u3m_electriciteoui", 1);
        $form->setMax("u3b_electricitenon", 1);
        $form->setMax("u3t_observations", 50);
        $form->setMax("u1a_voirieoui", 1);
        $form->setMax("u1v_voirienon", 1);
        $form->setMax("u1q_voirieconcessionnaire", 30);
        $form->setMax("u1b_voirieavant", 12);
        $form->setMax("u1j_eauoui", 1);
        $form->setMax("u1t_eaunon", 1);
        $form->setMax("u1e_eauconcessionnaire", 30);
        $form->setMax("u1k_eauavant", 12);
        $form->setMax("u1s_assainissementoui", 1);
        $form->setMax("u1d_assainissementnon", 1);
        $form->setMax("u1l_assainissementconcessionnaire", 30);
        $form->setMax("u1r_assainissementavant", 12);
        $form->setMax("u1c_electriciteoui", 1);
        $form->setMax("u1u_electricitenon", 1);
        $form->setMax("u1m_electriciteconcessionnaire", 30);
        $form->setMax("u1f_electriciteavant", 12);
        $form->setMax("u2a_observations", 600);
        $form->setMax("f1ts4_surftaxestation", 11);
        $form->setMax("f1ut1_surfcree", 11);
        $form->setMax("f9d_date", 12);
        $form->setMax("f9n_nom", 40);
        $form->setMax("su2_avt_shon21", -5);
        $form->setMax("su2_avt_shon22", -5);
        $form->setMax("su2_cstr_shon21", -5);
        $form->setMax("su2_cstr_shon22", -5);
        $form->setMax("su2_chge_shon21", -5);
        $form->setMax("su2_chge_shon22", -5);
        $form->setMax("su2_demo_shon21", -5);
        $form->setMax("su2_demo_shon22", -5);
        $form->setMax("su2_sup_shon21", -5);
        $form->setMax("su2_sup_shon22", -5);
        $form->setMax("su2_tot_shon21", -5);
        $form->setMax("su2_tot_shon22", -5);
        $form->setMax("f1gu1_f1gu2_f1gu3", -5);
        $form->setMax("f1lu1_f1lu2_f1lu3", -5);
        $form->setMax("f1zu1_f1zu2_f1zu3", -5);
        $form->setMax("f1pu1_f1pu2_f1pu3", -5);
        $form->setMax("f1gt4_f1gt5_f1gt6", -5);
        $form->setMax("f1lt4_f1lt5_f1lt6", -5);
        $form->setMax("f1zt4_f1zt5_f1zt6", -5);
        $form->setMax("f1pt4_f1pt5_f1pt6", -5);
        $form->setMax("f1xu1_f1xu2_f1xu3", -5);
        $form->setMax("f1xt4_f1xt5_f1xt6", -5);
        $form->setMax("f1hu1_f1hu2_f1hu3", -5);
        $form->setMax("f1mu1_f1mu2_f1mu3", -5);
        $form->setMax("f1qu1_f1qu2_f1qu3", -5);
        $form->setMax("f1ht4_f1ht5_f1ht6", -5);
        $form->setMax("f1mt4_f1mt5_f1mt6", -5);
        $form->setMax("f1qt4_f1qt5_f1qt6", -5);
        $form->setMax("f2cu1_f2cu2_f2cu3", -5);
        $form->setMax("f2bu1_f2bu2_f2bu3", -5);
        $form->setMax("f2su1_f2su2_f2su3", -5);
        $form->setMax("f2hu1_f2hu2_f2hu3", -5);
        $form->setMax("f2eu1_f2eu2_f2eu3", -5);
        $form->setMax("f2qu1_f2qu2_f2qu3", -5);
        $form->setMax("f2ct4_f2ct5_f2ct6", -5);
        $form->setMax("f2bt4_f2bt5_f2bt6", -5);
        $form->setMax("f2st4_f2st5_f2st6", -5);
        $form->setMax("f2ht4_f2ht5_f2ht6", -5);
        $form->setMax("f2et4_f2et5_f2et6", -5);
        $form->setMax("f2qt4_f2qt5_f2qt6", -5);
        $form->setMax("dia_droit_reel_perso_grevant_bien_desc", 6);
        $form->setMax("dia_mod_cess_paie_nat_desc", 6);
        $form->setMax("dia_mod_cess_rente_viag_desc", 6);
        $form->setMax("dia_mod_cess_echange_desc", 6);
        $form->setMax("dia_mod_cess_apport_societe_desc", 6);
        $form->setMax("dia_mod_cess_cess_terr_loc_co_desc", 6);
        $form->setMax("dia_mod_cess_esti_imm_loca_desc", 6);
        $form->setMax("dia_mod_cess_adju_obl_desc", 6);
        $form->setMax("dia_mod_cess_adju_fin_indivi_desc", 6);
        $form->setMax("dia_cadre_titul_droit_prempt", 6);
        $form->setMax("dia_mairie_prix_moyen", -5);
        $form->setMax("dia_propri_indivi", 6);
        $form->setMax("dia_situa_bien_plan_cadas_oui", 1);
        $form->setMax("dia_situa_bien_plan_cadas_non", 1);
        $form->setMax("dia_notif_dec_titul_adr_prop", 1);
        $form->setMax("dia_notif_dec_titul_adr_prop_desc", 6);
        $form->setMax("dia_notif_dec_titul_adr_manda", 1);
        $form->setMax("dia_notif_dec_titul_adr_manda_desc", 6);
        $form->setMax("dia_dia_dpu", 1);
        $form->setMax("dia_dia_zad", 1);
        $form->setMax("dia_dia_zone_preempt_esp_natu_sensi", 1);
        $form->setMax("dia_dab_dpu", 1);
        $form->setMax("dia_dab_zad", 1);
        $form->setMax("dia_mod_cess_commi_mnt", -5);
        $form->setMax("dia_mod_cess_commi_mnt_ttc", 1);
        $form->setMax("dia_mod_cess_commi_mnt_ht", 1);
        $form->setMax("dia_mod_cess_prix_vente_num", -5);
        $form->setMax("dia_mod_cess_prix_vente_mob_num", -5);
        $form->setMax("dia_mod_cess_prix_vente_cheptel_num", -5);
        $form->setMax("dia_mod_cess_prix_vente_recol_num", -5);
        $form->setMax("dia_mod_cess_prix_vente_autre_num", -5);
        $form->setMax("dia_su_co_sol_num", -5);
        $form->setMax("dia_su_util_hab_num", -5);
        $form->setMax("dia_mod_cess_mnt_an_num", -5);
        $form->setMax("dia_mod_cess_mnt_compt_num", -5);
        $form->setMax("dia_mod_cess_mnt_soulte_num", -5);
        $form->setMax("dia_comp_prix_vente", -5);
        $form->setMax("dia_comp_surface", -5);
        $form->setMax("dia_comp_total_frais", -5);
        $form->setMax("dia_comp_mtn_total", -5);
        $form->setMax("dia_comp_valeur_m2", -5);
        $form->setMax("dia_esti_prix_france_dom", -5);
        $form->setMax("dia_prop_collectivite", -5);
        $form->setMax("dia_delegataire_denomination", 40);
        $form->setMax("dia_delegataire_raison_sociale", 50);
        $form->setMax("dia_delegataire_siret", 15);
        $form->setMax("dia_delegataire_categorie_juridique", 15);
        $form->setMax("dia_delegataire_representant_nom", 250);
        $form->setMax("dia_delegataire_representant_prenom", 250);
        $form->setMax("dia_delegataire_adresse_numero", 10);
        $form->setMax("dia_delegataire_adresse_voie", 55);
        $form->setMax("dia_delegataire_adresse_complement", 50);
        $form->setMax("dia_delegataire_adresse_lieu_dit", 39);
        $form->setMax("dia_delegataire_adresse_localite", 250);
        $form->setMax("dia_delegataire_adresse_code_postal", 5);
        $form->setMax("dia_delegataire_adresse_bp", 5);
        $form->setMax("dia_delegataire_adresse_cedex", 5);
        $form->setMax("dia_delegataire_adresse_pays", 250);
        $form->setMax("dia_delegataire_telephone_fixe", 20);
        $form->setMax("dia_delegataire_telephone_mobile", 20);
        $form->setMax("dia_delegataire_telephone_mobile_indicatif", 5);
        $form->setMax("dia_delegataire_courriel", 250);
        $form->setMax("dia_delegataire_fax", 20);
        $form->setMax("dia_entree_jouissance_type", 250);
        $form->setMax("dia_entree_jouissance_date", 12);
        $form->setMax("dia_entree_jouissance_date_effet", 12);
        $form->setMax("dia_entree_jouissance_com", 6);
        $form->setMax("dia_remise_bien_date_effet", 12);
        $form->setMax("dia_remise_bien_com", 6);
        $form->setMax("c2zp1_crete", -5);
        $form->setMax("c2zr1_destination", 70);
        $form->setMax("mh_design_appel_denom", 6);
        $form->setMax("mh_design_type_protect", 200);
        $form->setMax("mh_design_elem_prot", 6);
        $form->setMax("mh_design_ref_merimee_palissy", 10);
        $form->setMax("mh_design_nature_prop", 200);
        $form->setMax("mh_loc_denom", 6);
        $form->setMax("mh_pres_intitule", 6);
        $form->setMax("mh_trav_cat_1", 1);
        $form->setMax("mh_trav_cat_2", 1);
        $form->setMax("mh_trav_cat_3", 1);
        $form->setMax("mh_trav_cat_4", 1);
        $form->setMax("mh_trav_cat_5", 1);
        $form->setMax("mh_trav_cat_6", 1);
        $form->setMax("mh_trav_cat_7", 1);
        $form->setMax("mh_trav_cat_8", 1);
        $form->setMax("mh_trav_cat_9", 1);
        $form->setMax("mh_trav_cat_10", 1);
        $form->setMax("mh_trav_cat_11", 1);
        $form->setMax("mh_trav_cat_12", 1);
        $form->setMax("mh_trav_cat_12_prec", 6);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('donnees_techniques', __('donnees_techniques'));
        $form->setLib('dossier_instruction', __('dossier_instruction'));
        $form->setLib('lot', __('lot'));
        $form->setLib('am_lotiss', __('am_lotiss'));
        $form->setLib('am_autre_div', __('am_autre_div'));
        $form->setLib('am_camping', __('am_camping'));
        $form->setLib('am_caravane', __('am_caravane'));
        $form->setLib('am_carav_duree', __('am_carav_duree'));
        $form->setLib('am_statio', __('am_statio'));
        $form->setLib('am_statio_cont', __('am_statio_cont'));
        $form->setLib('am_affou_exhau', __('am_affou_exhau'));
        $form->setLib('am_affou_exhau_sup', __('am_affou_exhau_sup'));
        $form->setLib('am_affou_prof', __('am_affou_prof'));
        $form->setLib('am_exhau_haut', __('am_exhau_haut'));
        $form->setLib('am_coupe_abat', __('am_coupe_abat'));
        $form->setLib('am_prot_plu', __('am_prot_plu'));
        $form->setLib('am_prot_muni', __('am_prot_muni'));
        $form->setLib('am_mobil_voyage', __('am_mobil_voyage'));
        $form->setLib('am_aire_voyage', __('am_aire_voyage'));
        $form->setLib('am_rememb_afu', __('am_rememb_afu'));
        $form->setLib('am_parc_resid_loi', __('am_parc_resid_loi'));
        $form->setLib('am_sport_moto', __('am_sport_moto'));
        $form->setLib('am_sport_attrac', __('am_sport_attrac'));
        $form->setLib('am_sport_golf', __('am_sport_golf'));
        $form->setLib('am_mob_art', __('am_mob_art'));
        $form->setLib('am_modif_voie_esp', __('am_modif_voie_esp'));
        $form->setLib('am_plant_voie_esp', __('am_plant_voie_esp'));
        $form->setLib('am_chem_ouv_esp', __('am_chem_ouv_esp'));
        $form->setLib('am_agri_peche', __('am_agri_peche'));
        $form->setLib('am_crea_voie', __('am_crea_voie'));
        $form->setLib('am_modif_voie_exist', __('am_modif_voie_exist'));
        $form->setLib('am_crea_esp_sauv', __('am_crea_esp_sauv'));
        $form->setLib('am_crea_esp_class', __('am_crea_esp_class'));
        $form->setLib('am_projet_desc', __('am_projet_desc'));
        $form->setLib('am_terr_surf', __('am_terr_surf'));
        $form->setLib('am_tranche_desc', __('am_tranche_desc'));
        $form->setLib('am_lot_max_nb', __('am_lot_max_nb'));
        $form->setLib('am_lot_max_shon', __('am_lot_max_shon'));
        $form->setLib('am_lot_cstr_cos', __('am_lot_cstr_cos'));
        $form->setLib('am_lot_cstr_plan', __('am_lot_cstr_plan'));
        $form->setLib('am_lot_cstr_vente', __('am_lot_cstr_vente'));
        $form->setLib('am_lot_fin_diff', __('am_lot_fin_diff'));
        $form->setLib('am_lot_consign', __('am_lot_consign'));
        $form->setLib('am_lot_gar_achev', __('am_lot_gar_achev'));
        $form->setLib('am_lot_vente_ant', __('am_lot_vente_ant'));
        $form->setLib('am_empl_nb', __('am_empl_nb'));
        $form->setLib('am_tente_nb', __('am_tente_nb'));
        $form->setLib('am_carav_nb', __('am_carav_nb'));
        $form->setLib('am_mobil_nb', __('am_mobil_nb'));
        $form->setLib('am_pers_nb', __('am_pers_nb'));
        $form->setLib('am_empl_hll_nb', __('am_empl_hll_nb'));
        $form->setLib('am_hll_shon', __('am_hll_shon'));
        $form->setLib('am_periode_exploit', __('am_periode_exploit'));
        $form->setLib('am_exist_agrand', __('am_exist_agrand'));
        $form->setLib('am_exist_date', __('am_exist_date'));
        $form->setLib('am_exist_num', __('am_exist_num'));
        $form->setLib('am_exist_nb_avant', __('am_exist_nb_avant'));
        $form->setLib('am_exist_nb_apres', __('am_exist_nb_apres'));
        $form->setLib('am_coupe_bois', __('am_coupe_bois'));
        $form->setLib('am_coupe_parc', __('am_coupe_parc'));
        $form->setLib('am_coupe_align', __('am_coupe_align'));
        $form->setLib('am_coupe_ess', __('am_coupe_ess'));
        $form->setLib('am_coupe_age', __('am_coupe_age'));
        $form->setLib('am_coupe_dens', __('am_coupe_dens'));
        $form->setLib('am_coupe_qual', __('am_coupe_qual'));
        $form->setLib('am_coupe_trait', __('am_coupe_trait'));
        $form->setLib('am_coupe_autr', __('am_coupe_autr'));
        $form->setLib('co_archi_recours', __('co_archi_recours'));
        $form->setLib('co_cstr_nouv', __('co_cstr_nouv'));
        $form->setLib('co_cstr_exist', __('co_cstr_exist'));
        $form->setLib('co_cloture', __('co_cloture'));
        $form->setLib('co_elec_tension', __('co_elec_tension'));
        $form->setLib('co_div_terr', __('co_div_terr'));
        $form->setLib('co_projet_desc', __('co_projet_desc'));
        $form->setLib('co_anx_pisc', __('co_anx_pisc'));
        $form->setLib('co_anx_gara', __('co_anx_gara'));
        $form->setLib('co_anx_veran', __('co_anx_veran'));
        $form->setLib('co_anx_abri', __('co_anx_abri'));
        $form->setLib('co_anx_autr', __('co_anx_autr'));
        $form->setLib('co_anx_autr_desc', __('co_anx_autr_desc'));
        $form->setLib('co_tot_log_nb', __('co_tot_log_nb'));
        $form->setLib('co_tot_ind_nb', __('co_tot_ind_nb'));
        $form->setLib('co_tot_coll_nb', __('co_tot_coll_nb'));
        $form->setLib('co_mais_piece_nb', __('co_mais_piece_nb'));
        $form->setLib('co_mais_niv_nb', __('co_mais_niv_nb'));
        $form->setLib('co_fin_lls_nb', __('co_fin_lls_nb'));
        $form->setLib('co_fin_aa_nb', __('co_fin_aa_nb'));
        $form->setLib('co_fin_ptz_nb', __('co_fin_ptz_nb'));
        $form->setLib('co_fin_autr_nb', __('co_fin_autr_nb'));
        $form->setLib('co_fin_autr_desc', __('co_fin_autr_desc'));
        $form->setLib('co_mais_contrat_ind', __('co_mais_contrat_ind'));
        $form->setLib('co_uti_pers', __('co_uti_pers'));
        $form->setLib('co_uti_vente', __('co_uti_vente'));
        $form->setLib('co_uti_loc', __('co_uti_loc'));
        $form->setLib('co_uti_princ', __('co_uti_princ'));
        $form->setLib('co_uti_secon', __('co_uti_secon'));
        $form->setLib('co_resid_agees', __('co_resid_agees'));
        $form->setLib('co_resid_etud', __('co_resid_etud'));
        $form->setLib('co_resid_tourism', __('co_resid_tourism'));
        $form->setLib('co_resid_hot_soc', __('co_resid_hot_soc'));
        $form->setLib('co_resid_soc', __('co_resid_soc'));
        $form->setLib('co_resid_hand', __('co_resid_hand'));
        $form->setLib('co_resid_autr', __('co_resid_autr'));
        $form->setLib('co_resid_autr_desc', __('co_resid_autr_desc'));
        $form->setLib('co_foyer_chamb_nb', __('co_foyer_chamb_nb'));
        $form->setLib('co_log_1p_nb', __('co_log_1p_nb'));
        $form->setLib('co_log_2p_nb', __('co_log_2p_nb'));
        $form->setLib('co_log_3p_nb', __('co_log_3p_nb'));
        $form->setLib('co_log_4p_nb', __('co_log_4p_nb'));
        $form->setLib('co_log_5p_nb', __('co_log_5p_nb'));
        $form->setLib('co_log_6p_nb', __('co_log_6p_nb'));
        $form->setLib('co_bat_niv_nb', __('co_bat_niv_nb'));
        $form->setLib('co_trx_exten', __('co_trx_exten'));
        $form->setLib('co_trx_surelev', __('co_trx_surelev'));
        $form->setLib('co_trx_nivsup', __('co_trx_nivsup'));
        $form->setLib('co_demont_periode', __('co_demont_periode'));
        $form->setLib('co_sp_transport', __('co_sp_transport'));
        $form->setLib('co_sp_enseign', __('co_sp_enseign'));
        $form->setLib('co_sp_act_soc', __('co_sp_act_soc'));
        $form->setLib('co_sp_ouvr_spe', __('co_sp_ouvr_spe'));
        $form->setLib('co_sp_sante', __('co_sp_sante'));
        $form->setLib('co_sp_culture', __('co_sp_culture'));
        $form->setLib('co_statio_avt_nb', __('co_statio_avt_nb'));
        $form->setLib('co_statio_apr_nb', __('co_statio_apr_nb'));
        $form->setLib('co_statio_adr', __('co_statio_adr'));
        $form->setLib('co_statio_place_nb', __('co_statio_place_nb'));
        $form->setLib('co_statio_tot_surf', __('co_statio_tot_surf'));
        $form->setLib('co_statio_tot_shob', __('co_statio_tot_shob'));
        $form->setLib('co_statio_comm_cin_surf', __('co_statio_comm_cin_surf'));
        $form->setLib('su_avt_shon1', __('su_avt_shon1'));
        $form->setLib('su_avt_shon2', __('su_avt_shon2'));
        $form->setLib('su_avt_shon3', __('su_avt_shon3'));
        $form->setLib('su_avt_shon4', __('su_avt_shon4'));
        $form->setLib('su_avt_shon5', __('su_avt_shon5'));
        $form->setLib('su_avt_shon6', __('su_avt_shon6'));
        $form->setLib('su_avt_shon7', __('su_avt_shon7'));
        $form->setLib('su_avt_shon8', __('su_avt_shon8'));
        $form->setLib('su_avt_shon9', __('su_avt_shon9'));
        $form->setLib('su_cstr_shon1', __('su_cstr_shon1'));
        $form->setLib('su_cstr_shon2', __('su_cstr_shon2'));
        $form->setLib('su_cstr_shon3', __('su_cstr_shon3'));
        $form->setLib('su_cstr_shon4', __('su_cstr_shon4'));
        $form->setLib('su_cstr_shon5', __('su_cstr_shon5'));
        $form->setLib('su_cstr_shon6', __('su_cstr_shon6'));
        $form->setLib('su_cstr_shon7', __('su_cstr_shon7'));
        $form->setLib('su_cstr_shon8', __('su_cstr_shon8'));
        $form->setLib('su_cstr_shon9', __('su_cstr_shon9'));
        $form->setLib('su_trsf_shon1', __('su_trsf_shon1'));
        $form->setLib('su_trsf_shon2', __('su_trsf_shon2'));
        $form->setLib('su_trsf_shon3', __('su_trsf_shon3'));
        $form->setLib('su_trsf_shon4', __('su_trsf_shon4'));
        $form->setLib('su_trsf_shon5', __('su_trsf_shon5'));
        $form->setLib('su_trsf_shon6', __('su_trsf_shon6'));
        $form->setLib('su_trsf_shon7', __('su_trsf_shon7'));
        $form->setLib('su_trsf_shon8', __('su_trsf_shon8'));
        $form->setLib('su_trsf_shon9', __('su_trsf_shon9'));
        $form->setLib('su_chge_shon1', __('su_chge_shon1'));
        $form->setLib('su_chge_shon2', __('su_chge_shon2'));
        $form->setLib('su_chge_shon3', __('su_chge_shon3'));
        $form->setLib('su_chge_shon4', __('su_chge_shon4'));
        $form->setLib('su_chge_shon5', __('su_chge_shon5'));
        $form->setLib('su_chge_shon6', __('su_chge_shon6'));
        $form->setLib('su_chge_shon7', __('su_chge_shon7'));
        $form->setLib('su_chge_shon8', __('su_chge_shon8'));
        $form->setLib('su_chge_shon9', __('su_chge_shon9'));
        $form->setLib('su_demo_shon1', __('su_demo_shon1'));
        $form->setLib('su_demo_shon2', __('su_demo_shon2'));
        $form->setLib('su_demo_shon3', __('su_demo_shon3'));
        $form->setLib('su_demo_shon4', __('su_demo_shon4'));
        $form->setLib('su_demo_shon5', __('su_demo_shon5'));
        $form->setLib('su_demo_shon6', __('su_demo_shon6'));
        $form->setLib('su_demo_shon7', __('su_demo_shon7'));
        $form->setLib('su_demo_shon8', __('su_demo_shon8'));
        $form->setLib('su_demo_shon9', __('su_demo_shon9'));
        $form->setLib('su_sup_shon1', __('su_sup_shon1'));
        $form->setLib('su_sup_shon2', __('su_sup_shon2'));
        $form->setLib('su_sup_shon3', __('su_sup_shon3'));
        $form->setLib('su_sup_shon4', __('su_sup_shon4'));
        $form->setLib('su_sup_shon5', __('su_sup_shon5'));
        $form->setLib('su_sup_shon6', __('su_sup_shon6'));
        $form->setLib('su_sup_shon7', __('su_sup_shon7'));
        $form->setLib('su_sup_shon8', __('su_sup_shon8'));
        $form->setLib('su_sup_shon9', __('su_sup_shon9'));
        $form->setLib('su_tot_shon1', __('su_tot_shon1'));
        $form->setLib('su_tot_shon2', __('su_tot_shon2'));
        $form->setLib('su_tot_shon3', __('su_tot_shon3'));
        $form->setLib('su_tot_shon4', __('su_tot_shon4'));
        $form->setLib('su_tot_shon5', __('su_tot_shon5'));
        $form->setLib('su_tot_shon6', __('su_tot_shon6'));
        $form->setLib('su_tot_shon7', __('su_tot_shon7'));
        $form->setLib('su_tot_shon8', __('su_tot_shon8'));
        $form->setLib('su_tot_shon9', __('su_tot_shon9'));
        $form->setLib('su_avt_shon_tot', __('su_avt_shon_tot'));
        $form->setLib('su_cstr_shon_tot', __('su_cstr_shon_tot'));
        $form->setLib('su_trsf_shon_tot', __('su_trsf_shon_tot'));
        $form->setLib('su_chge_shon_tot', __('su_chge_shon_tot'));
        $form->setLib('su_demo_shon_tot', __('su_demo_shon_tot'));
        $form->setLib('su_sup_shon_tot', __('su_sup_shon_tot'));
        $form->setLib('su_tot_shon_tot', __('su_tot_shon_tot'));
        $form->setLib('dm_constr_dates', __('dm_constr_dates'));
        $form->setLib('dm_total', __('dm_total'));
        $form->setLib('dm_partiel', __('dm_partiel'));
        $form->setLib('dm_projet_desc', __('dm_projet_desc'));
        $form->setLib('dm_tot_log_nb', __('dm_tot_log_nb'));
        $form->setLib('tax_surf_tot', __('tax_surf_tot'));
        $form->setLib('tax_surf', __('tax_surf'));
        $form->setLib('tax_surf_suppr_mod', __('tax_surf_suppr_mod'));
        $form->setLib('tax_su_princ_log_nb1', __('tax_su_princ_log_nb1'));
        $form->setLib('tax_su_princ_log_nb2', __('tax_su_princ_log_nb2'));
        $form->setLib('tax_su_princ_log_nb3', __('tax_su_princ_log_nb3'));
        $form->setLib('tax_su_princ_log_nb4', __('tax_su_princ_log_nb4'));
        $form->setLib('tax_su_princ_log_nb_tot1', __('tax_su_princ_log_nb_tot1'));
        $form->setLib('tax_su_princ_log_nb_tot2', __('tax_su_princ_log_nb_tot2'));
        $form->setLib('tax_su_princ_log_nb_tot3', __('tax_su_princ_log_nb_tot3'));
        $form->setLib('tax_su_princ_log_nb_tot4', __('tax_su_princ_log_nb_tot4'));
        $form->setLib('tax_su_princ_surf1', __('tax_su_princ_surf1'));
        $form->setLib('tax_su_princ_surf2', __('tax_su_princ_surf2'));
        $form->setLib('tax_su_princ_surf3', __('tax_su_princ_surf3'));
        $form->setLib('tax_su_princ_surf4', __('tax_su_princ_surf4'));
        $form->setLib('tax_su_princ_surf_sup1', __('tax_su_princ_surf_sup1'));
        $form->setLib('tax_su_princ_surf_sup2', __('tax_su_princ_surf_sup2'));
        $form->setLib('tax_su_princ_surf_sup3', __('tax_su_princ_surf_sup3'));
        $form->setLib('tax_su_princ_surf_sup4', __('tax_su_princ_surf_sup4'));
        $form->setLib('tax_su_heber_log_nb1', __('tax_su_heber_log_nb1'));
        $form->setLib('tax_su_heber_log_nb2', __('tax_su_heber_log_nb2'));
        $form->setLib('tax_su_heber_log_nb3', __('tax_su_heber_log_nb3'));
        $form->setLib('tax_su_heber_log_nb_tot1', __('tax_su_heber_log_nb_tot1'));
        $form->setLib('tax_su_heber_log_nb_tot2', __('tax_su_heber_log_nb_tot2'));
        $form->setLib('tax_su_heber_log_nb_tot3', __('tax_su_heber_log_nb_tot3'));
        $form->setLib('tax_su_heber_surf1', __('tax_su_heber_surf1'));
        $form->setLib('tax_su_heber_surf2', __('tax_su_heber_surf2'));
        $form->setLib('tax_su_heber_surf3', __('tax_su_heber_surf3'));
        $form->setLib('tax_su_heber_surf_sup1', __('tax_su_heber_surf_sup1'));
        $form->setLib('tax_su_heber_surf_sup2', __('tax_su_heber_surf_sup2'));
        $form->setLib('tax_su_heber_surf_sup3', __('tax_su_heber_surf_sup3'));
        $form->setLib('tax_su_secon_log_nb', __('tax_su_secon_log_nb'));
        $form->setLib('tax_su_tot_log_nb', __('tax_su_tot_log_nb'));
        $form->setLib('tax_su_secon_log_nb_tot', __('tax_su_secon_log_nb_tot'));
        $form->setLib('tax_su_tot_log_nb_tot', __('tax_su_tot_log_nb_tot'));
        $form->setLib('tax_su_secon_surf', __('tax_su_secon_surf'));
        $form->setLib('tax_su_tot_surf', __('tax_su_tot_surf'));
        $form->setLib('tax_su_secon_surf_sup', __('tax_su_secon_surf_sup'));
        $form->setLib('tax_su_tot_surf_sup', __('tax_su_tot_surf_sup'));
        $form->setLib('tax_ext_pret', __('tax_ext_pret'));
        $form->setLib('tax_ext_desc', __('tax_ext_desc'));
        $form->setLib('tax_surf_tax_exist_cons', __('tax_surf_tax_exist_cons'));
        $form->setLib('tax_log_exist_nb', __('tax_log_exist_nb'));
        $form->setLib('tax_am_statio_ext', __('tax_am_statio_ext'));
        $form->setLib('tax_sup_bass_pisc', __('tax_sup_bass_pisc'));
        $form->setLib('tax_empl_ten_carav_mobil_nb', __('tax_empl_ten_carav_mobil_nb'));
        $form->setLib('tax_empl_hll_nb', __('tax_empl_hll_nb'));
        $form->setLib('tax_eol_haut_nb', __('tax_eol_haut_nb'));
        $form->setLib('tax_pann_volt_sup', __('tax_pann_volt_sup'));
        $form->setLib('tax_am_statio_ext_sup', __('tax_am_statio_ext_sup'));
        $form->setLib('tax_sup_bass_pisc_sup', __('tax_sup_bass_pisc_sup'));
        $form->setLib('tax_empl_ten_carav_mobil_nb_sup', __('tax_empl_ten_carav_mobil_nb_sup'));
        $form->setLib('tax_empl_hll_nb_sup', __('tax_empl_hll_nb_sup'));
        $form->setLib('tax_eol_haut_nb_sup', __('tax_eol_haut_nb_sup'));
        $form->setLib('tax_pann_volt_sup_sup', __('tax_pann_volt_sup_sup'));
        $form->setLib('tax_trx_presc_ppr', __('tax_trx_presc_ppr'));
        $form->setLib('tax_monu_hist', __('tax_monu_hist'));
        $form->setLib('tax_comm_nb', __('tax_comm_nb'));
        $form->setLib('tax_su_non_habit_surf1', __('tax_su_non_habit_surf1'));
        $form->setLib('tax_su_non_habit_surf2', __('tax_su_non_habit_surf2'));
        $form->setLib('tax_su_non_habit_surf3', __('tax_su_non_habit_surf3'));
        $form->setLib('tax_su_non_habit_surf4', __('tax_su_non_habit_surf4'));
        $form->setLib('tax_su_non_habit_surf5', __('tax_su_non_habit_surf5'));
        $form->setLib('tax_su_non_habit_surf6', __('tax_su_non_habit_surf6'));
        $form->setLib('tax_su_non_habit_surf7', __('tax_su_non_habit_surf7'));
        $form->setLib('tax_su_non_habit_surf_sup1', __('tax_su_non_habit_surf_sup1'));
        $form->setLib('tax_su_non_habit_surf_sup2', __('tax_su_non_habit_surf_sup2'));
        $form->setLib('tax_su_non_habit_surf_sup3', __('tax_su_non_habit_surf_sup3'));
        $form->setLib('tax_su_non_habit_surf_sup4', __('tax_su_non_habit_surf_sup4'));
        $form->setLib('tax_su_non_habit_surf_sup5', __('tax_su_non_habit_surf_sup5'));
        $form->setLib('tax_su_non_habit_surf_sup6', __('tax_su_non_habit_surf_sup6'));
        $form->setLib('tax_su_non_habit_surf_sup7', __('tax_su_non_habit_surf_sup7'));
        $form->setLib('vsd_surf_planch_smd', __('vsd_surf_planch_smd'));
        $form->setLib('vsd_unit_fonc_sup', __('vsd_unit_fonc_sup'));
        $form->setLib('vsd_unit_fonc_constr_sup', __('vsd_unit_fonc_constr_sup'));
        $form->setLib('vsd_val_terr', __('vsd_val_terr'));
        $form->setLib('vsd_const_sxist_non_dem_surf', __('vsd_const_sxist_non_dem_surf'));
        $form->setLib('vsd_rescr_fisc', __('vsd_rescr_fisc'));
        $form->setLib('pld_val_terr', __('pld_val_terr'));
        $form->setLib('pld_const_exist_dem', __('pld_const_exist_dem'));
        $form->setLib('pld_const_exist_dem_surf', __('pld_const_exist_dem_surf'));
        $form->setLib('code_cnil', __('code_cnil'));
        $form->setLib('terr_juri_titul', __('terr_juri_titul'));
        $form->setLib('terr_juri_lot', __('terr_juri_lot'));
        $form->setLib('terr_juri_zac', __('terr_juri_zac'));
        $form->setLib('terr_juri_afu', __('terr_juri_afu'));
        $form->setLib('terr_juri_pup', __('terr_juri_pup'));
        $form->setLib('terr_juri_oin', __('terr_juri_oin'));
        $form->setLib('terr_juri_desc', __('terr_juri_desc'));
        $form->setLib('terr_div_surf_etab', __('terr_div_surf_etab'));
        $form->setLib('terr_div_surf_av_div', __('terr_div_surf_av_div'));
        $form->setLib('doc_date', __('doc_date'));
        $form->setLib('doc_tot_trav', __('doc_tot_trav'));
        $form->setLib('doc_tranche_trav', __('doc_tranche_trav'));
        $form->setLib('doc_tranche_trav_desc', __('doc_tranche_trav_desc'));
        $form->setLib('doc_surf', __('doc_surf'));
        $form->setLib('doc_nb_log', __('doc_nb_log'));
        $form->setLib('doc_nb_log_indiv', __('doc_nb_log_indiv'));
        $form->setLib('doc_nb_log_coll', __('doc_nb_log_coll'));
        $form->setLib('doc_nb_log_lls', __('doc_nb_log_lls'));
        $form->setLib('doc_nb_log_aa', __('doc_nb_log_aa'));
        $form->setLib('doc_nb_log_ptz', __('doc_nb_log_ptz'));
        $form->setLib('doc_nb_log_autre', __('doc_nb_log_autre'));
        $form->setLib('daact_date', __('daact_date'));
        $form->setLib('daact_date_chgmt_dest', __('daact_date_chgmt_dest'));
        $form->setLib('daact_tot_trav', __('daact_tot_trav'));
        $form->setLib('daact_tranche_trav', __('daact_tranche_trav'));
        $form->setLib('daact_tranche_trav_desc', __('daact_tranche_trav_desc'));
        $form->setLib('daact_surf', __('daact_surf'));
        $form->setLib('daact_nb_log', __('daact_nb_log'));
        $form->setLib('daact_nb_log_indiv', __('daact_nb_log_indiv'));
        $form->setLib('daact_nb_log_coll', __('daact_nb_log_coll'));
        $form->setLib('daact_nb_log_lls', __('daact_nb_log_lls'));
        $form->setLib('daact_nb_log_aa', __('daact_nb_log_aa'));
        $form->setLib('daact_nb_log_ptz', __('daact_nb_log_ptz'));
        $form->setLib('daact_nb_log_autre', __('daact_nb_log_autre'));
        $form->setLib('dossier_autorisation', __('dossier_autorisation'));
        $form->setLib('am_div_mun', __('am_div_mun'));
        $form->setLib('co_perf_energ', __('co_perf_energ'));
        $form->setLib('architecte', __('architecte'));
        $form->setLib('co_statio_avt_shob', __('co_statio_avt_shob'));
        $form->setLib('co_statio_apr_shob', __('co_statio_apr_shob'));
        $form->setLib('co_statio_avt_surf', __('co_statio_avt_surf'));
        $form->setLib('co_statio_apr_surf', __('co_statio_apr_surf'));
        $form->setLib('co_trx_amgt', __('co_trx_amgt'));
        $form->setLib('co_modif_aspect', __('co_modif_aspect'));
        $form->setLib('co_modif_struct', __('co_modif_struct'));
        $form->setLib('co_ouvr_elec', __('co_ouvr_elec'));
        $form->setLib('co_ouvr_infra', __('co_ouvr_infra'));
        $form->setLib('co_trx_imm', __('co_trx_imm'));
        $form->setLib('co_cstr_shob', __('co_cstr_shob'));
        $form->setLib('am_voyage_deb', __('am_voyage_deb'));
        $form->setLib('am_voyage_fin', __('am_voyage_fin'));
        $form->setLib('am_modif_amgt', __('am_modif_amgt'));
        $form->setLib('am_lot_max_shob', __('am_lot_max_shob'));
        $form->setLib('mod_desc', __('mod_desc'));
        $form->setLib('tr_total', __('tr_total'));
        $form->setLib('tr_partiel', __('tr_partiel'));
        $form->setLib('tr_desc', __('tr_desc'));
        $form->setLib('avap_co_elt_pro', __('avap_co_elt_pro'));
        $form->setLib('avap_nouv_haut_surf', __('avap_nouv_haut_surf'));
        $form->setLib('avap_co_clot', __('avap_co_clot'));
        $form->setLib('avap_aut_coup_aba_arb', __('avap_aut_coup_aba_arb'));
        $form->setLib('avap_ouv_infra', __('avap_ouv_infra'));
        $form->setLib('avap_aut_inst_mob', __('avap_aut_inst_mob'));
        $form->setLib('avap_aut_plant', __('avap_aut_plant'));
        $form->setLib('avap_aut_auv_elec', __('avap_aut_auv_elec'));
        $form->setLib('tax_dest_loc_tr', __('tax_dest_loc_tr'));
        $form->setLib('ope_proj_desc', __('ope_proj_desc'));
        $form->setLib('tax_surf_tot_cstr', __('tax_surf_tot_cstr'));
        $form->setLib('cerfa', __('cerfa'));
        $form->setLib('tax_surf_loc_stat', __('tax_surf_loc_stat'));
        $form->setLib('tax_su_princ_surf_stat1', __('tax_su_princ_surf_stat1'));
        $form->setLib('tax_su_princ_surf_stat2', __('tax_su_princ_surf_stat2'));
        $form->setLib('tax_su_princ_surf_stat3', __('tax_su_princ_surf_stat3'));
        $form->setLib('tax_su_princ_surf_stat4', __('tax_su_princ_surf_stat4'));
        $form->setLib('tax_su_secon_surf_stat', __('tax_su_secon_surf_stat'));
        $form->setLib('tax_su_heber_surf_stat1', __('tax_su_heber_surf_stat1'));
        $form->setLib('tax_su_heber_surf_stat2', __('tax_su_heber_surf_stat2'));
        $form->setLib('tax_su_heber_surf_stat3', __('tax_su_heber_surf_stat3'));
        $form->setLib('tax_su_tot_surf_stat', __('tax_su_tot_surf_stat'));
        $form->setLib('tax_su_non_habit_surf_stat1', __('tax_su_non_habit_surf_stat1'));
        $form->setLib('tax_su_non_habit_surf_stat2', __('tax_su_non_habit_surf_stat2'));
        $form->setLib('tax_su_non_habit_surf_stat3', __('tax_su_non_habit_surf_stat3'));
        $form->setLib('tax_su_non_habit_surf_stat4', __('tax_su_non_habit_surf_stat4'));
        $form->setLib('tax_su_non_habit_surf_stat5', __('tax_su_non_habit_surf_stat5'));
        $form->setLib('tax_su_non_habit_surf_stat6', __('tax_su_non_habit_surf_stat6'));
        $form->setLib('tax_su_non_habit_surf_stat7', __('tax_su_non_habit_surf_stat7'));
        $form->setLib('tax_su_parc_statio_expl_comm_surf', __('tax_su_parc_statio_expl_comm_surf'));
        $form->setLib('tax_log_ap_trvx_nb', __('tax_log_ap_trvx_nb'));
        $form->setLib('tax_am_statio_ext_cr', __('tax_am_statio_ext_cr'));
        $form->setLib('tax_sup_bass_pisc_cr', __('tax_sup_bass_pisc_cr'));
        $form->setLib('tax_empl_ten_carav_mobil_nb_cr', __('tax_empl_ten_carav_mobil_nb_cr'));
        $form->setLib('tax_empl_hll_nb_cr', __('tax_empl_hll_nb_cr'));
        $form->setLib('tax_eol_haut_nb_cr', __('tax_eol_haut_nb_cr'));
        $form->setLib('tax_pann_volt_sup_cr', __('tax_pann_volt_sup_cr'));
        $form->setLib('tax_surf_loc_arch', __('tax_surf_loc_arch'));
        $form->setLib('tax_surf_pisc_arch', __('tax_surf_pisc_arch'));
        $form->setLib('tax_am_statio_ext_arch', __('tax_am_statio_ext_arch'));
        $form->setLib('tax_empl_ten_carav_mobil_nb_arch', __('tax_empl_ten_carav_mobil_nb_arch'));
        $form->setLib('tax_empl_hll_nb_arch', __('tax_empl_hll_nb_arch'));
        $form->setLib('tax_eol_haut_nb_arch', __('tax_eol_haut_nb_arch'));
        $form->setLib('ope_proj_div_co', __('ope_proj_div_co'));
        $form->setLib('ope_proj_div_contr', __('ope_proj_div_contr'));
        $form->setLib('tax_desc', __('tax_desc'));
        $form->setLib('erp_cstr_neuve', __('erp_cstr_neuve'));
        $form->setLib('erp_trvx_acc', __('erp_trvx_acc'));
        $form->setLib('erp_extension', __('erp_extension'));
        $form->setLib('erp_rehab', __('erp_rehab'));
        $form->setLib('erp_trvx_am', __('erp_trvx_am'));
        $form->setLib('erp_vol_nouv_exist', __('erp_vol_nouv_exist'));
        $form->setLib('erp_loc_eff1', __('erp_loc_eff1'));
        $form->setLib('erp_loc_eff2', __('erp_loc_eff2'));
        $form->setLib('erp_loc_eff3', __('erp_loc_eff3'));
        $form->setLib('erp_loc_eff4', __('erp_loc_eff4'));
        $form->setLib('erp_loc_eff5', __('erp_loc_eff5'));
        $form->setLib('erp_loc_eff_tot', __('erp_loc_eff_tot'));
        $form->setLib('erp_public_eff1', __('erp_public_eff1'));
        $form->setLib('erp_public_eff2', __('erp_public_eff2'));
        $form->setLib('erp_public_eff3', __('erp_public_eff3'));
        $form->setLib('erp_public_eff4', __('erp_public_eff4'));
        $form->setLib('erp_public_eff5', __('erp_public_eff5'));
        $form->setLib('erp_public_eff_tot', __('erp_public_eff_tot'));
        $form->setLib('erp_perso_eff1', __('erp_perso_eff1'));
        $form->setLib('erp_perso_eff2', __('erp_perso_eff2'));
        $form->setLib('erp_perso_eff3', __('erp_perso_eff3'));
        $form->setLib('erp_perso_eff4', __('erp_perso_eff4'));
        $form->setLib('erp_perso_eff5', __('erp_perso_eff5'));
        $form->setLib('erp_perso_eff_tot', __('erp_perso_eff_tot'));
        $form->setLib('erp_tot_eff1', __('erp_tot_eff1'));
        $form->setLib('erp_tot_eff2', __('erp_tot_eff2'));
        $form->setLib('erp_tot_eff3', __('erp_tot_eff3'));
        $form->setLib('erp_tot_eff4', __('erp_tot_eff4'));
        $form->setLib('erp_tot_eff5', __('erp_tot_eff5'));
        $form->setLib('erp_tot_eff_tot', __('erp_tot_eff_tot'));
        $form->setLib('erp_class_cat', __('erp_class_cat'));
        $form->setLib('erp_class_type', __('erp_class_type'));
        $form->setLib('tax_surf_abr_jard_pig_colom', __('tax_surf_abr_jard_pig_colom'));
        $form->setLib('tax_su_non_habit_abr_jard_pig_colom', __('tax_su_non_habit_abr_jard_pig_colom'));
        $form->setLib('dia_imm_non_bati', __('dia_imm_non_bati'));
        $form->setLib('dia_imm_bati_terr_propr', __('dia_imm_bati_terr_propr'));
        $form->setLib('dia_imm_bati_terr_autr', __('dia_imm_bati_terr_autr'));
        $form->setLib('dia_imm_bati_terr_autr_desc', __('dia_imm_bati_terr_autr_desc'));
        $form->setLib('dia_bat_copro', __('dia_bat_copro'));
        $form->setLib('dia_bat_copro_desc', __('dia_bat_copro_desc'));
        $form->setLib('dia_lot_numero', __('dia_lot_numero'));
        $form->setLib('dia_lot_bat', __('dia_lot_bat'));
        $form->setLib('dia_lot_etage', __('dia_lot_etage'));
        $form->setLib('dia_lot_quote_part', __('dia_lot_quote_part'));
        $form->setLib('dia_us_hab', __('dia_us_hab'));
        $form->setLib('dia_us_pro', __('dia_us_pro'));
        $form->setLib('dia_us_mixte', __('dia_us_mixte'));
        $form->setLib('dia_us_comm', __('dia_us_comm'));
        $form->setLib('dia_us_agr', __('dia_us_agr'));
        $form->setLib('dia_us_autre', __('dia_us_autre'));
        $form->setLib('dia_us_autre_prec', __('dia_us_autre_prec'));
        $form->setLib('dia_occ_prop', __('dia_occ_prop'));
        $form->setLib('dia_occ_loc', __('dia_occ_loc'));
        $form->setLib('dia_occ_sans_occ', __('dia_occ_sans_occ'));
        $form->setLib('dia_occ_autre', __('dia_occ_autre'));
        $form->setLib('dia_occ_autre_prec', __('dia_occ_autre_prec'));
        $form->setLib('dia_mod_cess_prix_vente', __('dia_mod_cess_prix_vente'));
        $form->setLib('dia_mod_cess_prix_vente_mob', __('dia_mod_cess_prix_vente_mob'));
        $form->setLib('dia_mod_cess_prix_vente_cheptel', __('dia_mod_cess_prix_vente_cheptel'));
        $form->setLib('dia_mod_cess_prix_vente_recol', __('dia_mod_cess_prix_vente_recol'));
        $form->setLib('dia_mod_cess_prix_vente_autre', __('dia_mod_cess_prix_vente_autre'));
        $form->setLib('dia_mod_cess_commi', __('dia_mod_cess_commi'));
        $form->setLib('dia_mod_cess_commi_ttc', __('dia_mod_cess_commi_ttc'));
        $form->setLib('dia_mod_cess_commi_ht', __('dia_mod_cess_commi_ht'));
        $form->setLib('dia_acquereur_nom_prenom', __('dia_acquereur_nom_prenom'));
        $form->setLib('dia_acquereur_adr_num_voie', __('dia_acquereur_adr_num_voie'));
        $form->setLib('dia_acquereur_adr_ext', __('dia_acquereur_adr_ext'));
        $form->setLib('dia_acquereur_adr_type_voie', __('dia_acquereur_adr_type_voie'));
        $form->setLib('dia_acquereur_adr_nom_voie', __('dia_acquereur_adr_nom_voie'));
        $form->setLib('dia_acquereur_adr_lieu_dit_bp', __('dia_acquereur_adr_lieu_dit_bp'));
        $form->setLib('dia_acquereur_adr_cp', __('dia_acquereur_adr_cp'));
        $form->setLib('dia_acquereur_adr_localite', __('dia_acquereur_adr_localite'));
        $form->setLib('dia_observation', __('dia_observation'));
        $form->setLib('su2_avt_shon1', __('su2_avt_shon1'));
        $form->setLib('su2_avt_shon2', __('su2_avt_shon2'));
        $form->setLib('su2_avt_shon3', __('su2_avt_shon3'));
        $form->setLib('su2_avt_shon4', __('su2_avt_shon4'));
        $form->setLib('su2_avt_shon5', __('su2_avt_shon5'));
        $form->setLib('su2_avt_shon6', __('su2_avt_shon6'));
        $form->setLib('su2_avt_shon7', __('su2_avt_shon7'));
        $form->setLib('su2_avt_shon8', __('su2_avt_shon8'));
        $form->setLib('su2_avt_shon9', __('su2_avt_shon9'));
        $form->setLib('su2_avt_shon10', __('su2_avt_shon10'));
        $form->setLib('su2_avt_shon11', __('su2_avt_shon11'));
        $form->setLib('su2_avt_shon12', __('su2_avt_shon12'));
        $form->setLib('su2_avt_shon13', __('su2_avt_shon13'));
        $form->setLib('su2_avt_shon14', __('su2_avt_shon14'));
        $form->setLib('su2_avt_shon15', __('su2_avt_shon15'));
        $form->setLib('su2_avt_shon16', __('su2_avt_shon16'));
        $form->setLib('su2_avt_shon17', __('su2_avt_shon17'));
        $form->setLib('su2_avt_shon18', __('su2_avt_shon18'));
        $form->setLib('su2_avt_shon19', __('su2_avt_shon19'));
        $form->setLib('su2_avt_shon20', __('su2_avt_shon20'));
        $form->setLib('su2_avt_shon_tot', __('su2_avt_shon_tot'));
        $form->setLib('su2_cstr_shon1', __('su2_cstr_shon1'));
        $form->setLib('su2_cstr_shon2', __('su2_cstr_shon2'));
        $form->setLib('su2_cstr_shon3', __('su2_cstr_shon3'));
        $form->setLib('su2_cstr_shon4', __('su2_cstr_shon4'));
        $form->setLib('su2_cstr_shon5', __('su2_cstr_shon5'));
        $form->setLib('su2_cstr_shon6', __('su2_cstr_shon6'));
        $form->setLib('su2_cstr_shon7', __('su2_cstr_shon7'));
        $form->setLib('su2_cstr_shon8', __('su2_cstr_shon8'));
        $form->setLib('su2_cstr_shon9', __('su2_cstr_shon9'));
        $form->setLib('su2_cstr_shon10', __('su2_cstr_shon10'));
        $form->setLib('su2_cstr_shon11', __('su2_cstr_shon11'));
        $form->setLib('su2_cstr_shon12', __('su2_cstr_shon12'));
        $form->setLib('su2_cstr_shon13', __('su2_cstr_shon13'));
        $form->setLib('su2_cstr_shon14', __('su2_cstr_shon14'));
        $form->setLib('su2_cstr_shon15', __('su2_cstr_shon15'));
        $form->setLib('su2_cstr_shon16', __('su2_cstr_shon16'));
        $form->setLib('su2_cstr_shon17', __('su2_cstr_shon17'));
        $form->setLib('su2_cstr_shon18', __('su2_cstr_shon18'));
        $form->setLib('su2_cstr_shon19', __('su2_cstr_shon19'));
        $form->setLib('su2_cstr_shon20', __('su2_cstr_shon20'));
        $form->setLib('su2_cstr_shon_tot', __('su2_cstr_shon_tot'));
        $form->setLib('su2_chge_shon1', __('su2_chge_shon1'));
        $form->setLib('su2_chge_shon2', __('su2_chge_shon2'));
        $form->setLib('su2_chge_shon3', __('su2_chge_shon3'));
        $form->setLib('su2_chge_shon4', __('su2_chge_shon4'));
        $form->setLib('su2_chge_shon5', __('su2_chge_shon5'));
        $form->setLib('su2_chge_shon6', __('su2_chge_shon6'));
        $form->setLib('su2_chge_shon7', __('su2_chge_shon7'));
        $form->setLib('su2_chge_shon8', __('su2_chge_shon8'));
        $form->setLib('su2_chge_shon9', __('su2_chge_shon9'));
        $form->setLib('su2_chge_shon10', __('su2_chge_shon10'));
        $form->setLib('su2_chge_shon11', __('su2_chge_shon11'));
        $form->setLib('su2_chge_shon12', __('su2_chge_shon12'));
        $form->setLib('su2_chge_shon13', __('su2_chge_shon13'));
        $form->setLib('su2_chge_shon14', __('su2_chge_shon14'));
        $form->setLib('su2_chge_shon15', __('su2_chge_shon15'));
        $form->setLib('su2_chge_shon16', __('su2_chge_shon16'));
        $form->setLib('su2_chge_shon17', __('su2_chge_shon17'));
        $form->setLib('su2_chge_shon18', __('su2_chge_shon18'));
        $form->setLib('su2_chge_shon19', __('su2_chge_shon19'));
        $form->setLib('su2_chge_shon20', __('su2_chge_shon20'));
        $form->setLib('su2_chge_shon_tot', __('su2_chge_shon_tot'));
        $form->setLib('su2_demo_shon1', __('su2_demo_shon1'));
        $form->setLib('su2_demo_shon2', __('su2_demo_shon2'));
        $form->setLib('su2_demo_shon3', __('su2_demo_shon3'));
        $form->setLib('su2_demo_shon4', __('su2_demo_shon4'));
        $form->setLib('su2_demo_shon5', __('su2_demo_shon5'));
        $form->setLib('su2_demo_shon6', __('su2_demo_shon6'));
        $form->setLib('su2_demo_shon7', __('su2_demo_shon7'));
        $form->setLib('su2_demo_shon8', __('su2_demo_shon8'));
        $form->setLib('su2_demo_shon9', __('su2_demo_shon9'));
        $form->setLib('su2_demo_shon10', __('su2_demo_shon10'));
        $form->setLib('su2_demo_shon11', __('su2_demo_shon11'));
        $form->setLib('su2_demo_shon12', __('su2_demo_shon12'));
        $form->setLib('su2_demo_shon13', __('su2_demo_shon13'));
        $form->setLib('su2_demo_shon14', __('su2_demo_shon14'));
        $form->setLib('su2_demo_shon15', __('su2_demo_shon15'));
        $form->setLib('su2_demo_shon16', __('su2_demo_shon16'));
        $form->setLib('su2_demo_shon17', __('su2_demo_shon17'));
        $form->setLib('su2_demo_shon18', __('su2_demo_shon18'));
        $form->setLib('su2_demo_shon19', __('su2_demo_shon19'));
        $form->setLib('su2_demo_shon20', __('su2_demo_shon20'));
        $form->setLib('su2_demo_shon_tot', __('su2_demo_shon_tot'));
        $form->setLib('su2_sup_shon1', __('su2_sup_shon1'));
        $form->setLib('su2_sup_shon2', __('su2_sup_shon2'));
        $form->setLib('su2_sup_shon3', __('su2_sup_shon3'));
        $form->setLib('su2_sup_shon4', __('su2_sup_shon4'));
        $form->setLib('su2_sup_shon5', __('su2_sup_shon5'));
        $form->setLib('su2_sup_shon6', __('su2_sup_shon6'));
        $form->setLib('su2_sup_shon7', __('su2_sup_shon7'));
        $form->setLib('su2_sup_shon8', __('su2_sup_shon8'));
        $form->setLib('su2_sup_shon9', __('su2_sup_shon9'));
        $form->setLib('su2_sup_shon10', __('su2_sup_shon10'));
        $form->setLib('su2_sup_shon11', __('su2_sup_shon11'));
        $form->setLib('su2_sup_shon12', __('su2_sup_shon12'));
        $form->setLib('su2_sup_shon13', __('su2_sup_shon13'));
        $form->setLib('su2_sup_shon14', __('su2_sup_shon14'));
        $form->setLib('su2_sup_shon15', __('su2_sup_shon15'));
        $form->setLib('su2_sup_shon16', __('su2_sup_shon16'));
        $form->setLib('su2_sup_shon17', __('su2_sup_shon17'));
        $form->setLib('su2_sup_shon18', __('su2_sup_shon18'));
        $form->setLib('su2_sup_shon19', __('su2_sup_shon19'));
        $form->setLib('su2_sup_shon20', __('su2_sup_shon20'));
        $form->setLib('su2_sup_shon_tot', __('su2_sup_shon_tot'));
        $form->setLib('su2_tot_shon1', __('su2_tot_shon1'));
        $form->setLib('su2_tot_shon2', __('su2_tot_shon2'));
        $form->setLib('su2_tot_shon3', __('su2_tot_shon3'));
        $form->setLib('su2_tot_shon4', __('su2_tot_shon4'));
        $form->setLib('su2_tot_shon5', __('su2_tot_shon5'));
        $form->setLib('su2_tot_shon6', __('su2_tot_shon6'));
        $form->setLib('su2_tot_shon7', __('su2_tot_shon7'));
        $form->setLib('su2_tot_shon8', __('su2_tot_shon8'));
        $form->setLib('su2_tot_shon9', __('su2_tot_shon9'));
        $form->setLib('su2_tot_shon10', __('su2_tot_shon10'));
        $form->setLib('su2_tot_shon11', __('su2_tot_shon11'));
        $form->setLib('su2_tot_shon12', __('su2_tot_shon12'));
        $form->setLib('su2_tot_shon13', __('su2_tot_shon13'));
        $form->setLib('su2_tot_shon14', __('su2_tot_shon14'));
        $form->setLib('su2_tot_shon15', __('su2_tot_shon15'));
        $form->setLib('su2_tot_shon16', __('su2_tot_shon16'));
        $form->setLib('su2_tot_shon17', __('su2_tot_shon17'));
        $form->setLib('su2_tot_shon18', __('su2_tot_shon18'));
        $form->setLib('su2_tot_shon19', __('su2_tot_shon19'));
        $form->setLib('su2_tot_shon20', __('su2_tot_shon20'));
        $form->setLib('su2_tot_shon_tot', __('su2_tot_shon_tot'));
        $form->setLib('dia_occ_sol_su_terre', __('dia_occ_sol_su_terre'));
        $form->setLib('dia_occ_sol_su_pres', __('dia_occ_sol_su_pres'));
        $form->setLib('dia_occ_sol_su_verger', __('dia_occ_sol_su_verger'));
        $form->setLib('dia_occ_sol_su_vigne', __('dia_occ_sol_su_vigne'));
        $form->setLib('dia_occ_sol_su_bois', __('dia_occ_sol_su_bois'));
        $form->setLib('dia_occ_sol_su_lande', __('dia_occ_sol_su_lande'));
        $form->setLib('dia_occ_sol_su_carriere', __('dia_occ_sol_su_carriere'));
        $form->setLib('dia_occ_sol_su_eau_cadastree', __('dia_occ_sol_su_eau_cadastree'));
        $form->setLib('dia_occ_sol_su_jardin', __('dia_occ_sol_su_jardin'));
        $form->setLib('dia_occ_sol_su_terr_batir', __('dia_occ_sol_su_terr_batir'));
        $form->setLib('dia_occ_sol_su_terr_agr', __('dia_occ_sol_su_terr_agr'));
        $form->setLib('dia_occ_sol_su_sol', __('dia_occ_sol_su_sol'));
        $form->setLib('dia_bati_vend_tot', __('dia_bati_vend_tot'));
        $form->setLib('dia_bati_vend_tot_txt', __('dia_bati_vend_tot_txt'));
        $form->setLib('dia_su_co_sol', __('dia_su_co_sol'));
        $form->setLib('dia_su_util_hab', __('dia_su_util_hab'));
        $form->setLib('dia_nb_niv', __('dia_nb_niv'));
        $form->setLib('dia_nb_appart', __('dia_nb_appart'));
        $form->setLib('dia_nb_autre_loc', __('dia_nb_autre_loc'));
        $form->setLib('dia_vente_lot_volume', __('dia_vente_lot_volume'));
        $form->setLib('dia_vente_lot_volume_txt', __('dia_vente_lot_volume_txt'));
        $form->setLib('dia_lot_nat_su', __('dia_lot_nat_su'));
        $form->setLib('dia_lot_bat_achv_plus_10', __('dia_lot_bat_achv_plus_10'));
        $form->setLib('dia_lot_bat_achv_moins_10', __('dia_lot_bat_achv_moins_10'));
        $form->setLib('dia_lot_regl_copro_publ_hypo_plus_10', __('dia_lot_regl_copro_publ_hypo_plus_10'));
        $form->setLib('dia_lot_regl_copro_publ_hypo_moins_10', __('dia_lot_regl_copro_publ_hypo_moins_10'));
        $form->setLib('dia_indivi_quote_part', __('dia_indivi_quote_part'));
        $form->setLib('dia_design_societe', __('dia_design_societe'));
        $form->setLib('dia_design_droit', __('dia_design_droit'));
        $form->setLib('dia_droit_soc_nat', __('dia_droit_soc_nat'));
        $form->setLib('dia_droit_soc_nb', __('dia_droit_soc_nb'));
        $form->setLib('dia_droit_soc_num_part', __('dia_droit_soc_num_part'));
        $form->setLib('dia_droit_reel_perso_grevant_bien_oui', __('dia_droit_reel_perso_grevant_bien_oui'));
        $form->setLib('dia_droit_reel_perso_grevant_bien_non', __('dia_droit_reel_perso_grevant_bien_non'));
        $form->setLib('dia_droit_reel_perso_nat', __('dia_droit_reel_perso_nat'));
        $form->setLib('dia_droit_reel_perso_viag', __('dia_droit_reel_perso_viag'));
        $form->setLib('dia_mod_cess_adr', __('dia_mod_cess_adr'));
        $form->setLib('dia_mod_cess_sign_act_auth', __('dia_mod_cess_sign_act_auth'));
        $form->setLib('dia_mod_cess_terme', __('dia_mod_cess_terme'));
        $form->setLib('dia_mod_cess_terme_prec', __('dia_mod_cess_terme_prec'));
        $form->setLib('dia_mod_cess_bene_acquereur', __('dia_mod_cess_bene_acquereur'));
        $form->setLib('dia_mod_cess_bene_vendeur', __('dia_mod_cess_bene_vendeur'));
        $form->setLib('dia_mod_cess_paie_nat', __('dia_mod_cess_paie_nat'));
        $form->setLib('dia_mod_cess_design_contr_alien', __('dia_mod_cess_design_contr_alien'));
        $form->setLib('dia_mod_cess_eval_contr', __('dia_mod_cess_eval_contr'));
        $form->setLib('dia_mod_cess_rente_viag', __('dia_mod_cess_rente_viag'));
        $form->setLib('dia_mod_cess_mnt_an', __('dia_mod_cess_mnt_an'));
        $form->setLib('dia_mod_cess_mnt_compt', __('dia_mod_cess_mnt_compt'));
        $form->setLib('dia_mod_cess_bene_rente', __('dia_mod_cess_bene_rente'));
        $form->setLib('dia_mod_cess_droit_usa_hab', __('dia_mod_cess_droit_usa_hab'));
        $form->setLib('dia_mod_cess_droit_usa_hab_prec', __('dia_mod_cess_droit_usa_hab_prec'));
        $form->setLib('dia_mod_cess_eval_usa_usufruit', __('dia_mod_cess_eval_usa_usufruit'));
        $form->setLib('dia_mod_cess_vente_nue_prop', __('dia_mod_cess_vente_nue_prop'));
        $form->setLib('dia_mod_cess_vente_nue_prop_prec', __('dia_mod_cess_vente_nue_prop_prec'));
        $form->setLib('dia_mod_cess_echange', __('dia_mod_cess_echange'));
        $form->setLib('dia_mod_cess_design_bien_recus_ech', __('dia_mod_cess_design_bien_recus_ech'));
        $form->setLib('dia_mod_cess_mnt_soulte', __('dia_mod_cess_mnt_soulte'));
        $form->setLib('dia_mod_cess_prop_contre_echan', __('dia_mod_cess_prop_contre_echan'));
        $form->setLib('dia_mod_cess_apport_societe', __('dia_mod_cess_apport_societe'));
        $form->setLib('dia_mod_cess_bene', __('dia_mod_cess_bene'));
        $form->setLib('dia_mod_cess_esti_bien', __('dia_mod_cess_esti_bien'));
        $form->setLib('dia_mod_cess_cess_terr_loc_co', __('dia_mod_cess_cess_terr_loc_co'));
        $form->setLib('dia_mod_cess_esti_terr', __('dia_mod_cess_esti_terr'));
        $form->setLib('dia_mod_cess_esti_loc', __('dia_mod_cess_esti_loc'));
        $form->setLib('dia_mod_cess_esti_imm_loca', __('dia_mod_cess_esti_imm_loca'));
        $form->setLib('dia_mod_cess_adju_vol', __('dia_mod_cess_adju_vol'));
        $form->setLib('dia_mod_cess_adju_obl', __('dia_mod_cess_adju_obl'));
        $form->setLib('dia_mod_cess_adju_fin_indivi', __('dia_mod_cess_adju_fin_indivi'));
        $form->setLib('dia_mod_cess_adju_date_lieu', __('dia_mod_cess_adju_date_lieu'));
        $form->setLib('dia_mod_cess_mnt_mise_prix', __('dia_mod_cess_mnt_mise_prix'));
        $form->setLib('dia_prop_titu_prix_indique', __('dia_prop_titu_prix_indique'));
        $form->setLib('dia_prop_recherche_acqu_prix_indique', __('dia_prop_recherche_acqu_prix_indique'));
        $form->setLib('dia_acquereur_prof', __('dia_acquereur_prof'));
        $form->setLib('dia_indic_compl_ope', __('dia_indic_compl_ope'));
        $form->setLib('dia_vente_adju', __('dia_vente_adju'));
        $form->setLib('am_terr_res_demon', __('am_terr_res_demon'));
        $form->setLib('am_air_terr_res_mob', __('am_air_terr_res_mob'));
        $form->setLib('ctx_objet_recours', __('ctx_objet_recours'));
        $form->setLib('ctx_reference_sagace', __('ctx_reference_sagace'));
        $form->setLib('ctx_nature_travaux_infra_om_html', __('ctx_nature_travaux_infra_om_html'));
        $form->setLib('ctx_synthese_nti', __('ctx_synthese_nti'));
        $form->setLib('ctx_article_non_resp_om_html', __('ctx_article_non_resp_om_html'));
        $form->setLib('ctx_synthese_anr', __('ctx_synthese_anr'));
        $form->setLib('ctx_reference_parquet', __('ctx_reference_parquet'));
        $form->setLib('ctx_element_taxation', __('ctx_element_taxation'));
        $form->setLib('ctx_infraction', __('ctx_infraction'));
        $form->setLib('ctx_regularisable', __('ctx_regularisable'));
        $form->setLib('ctx_reference_courrier', __('ctx_reference_courrier'));
        $form->setLib('ctx_date_audience', __('ctx_date_audience'));
        $form->setLib('ctx_date_ajournement', __('ctx_date_ajournement'));
        $form->setLib('exo_facul_1', __('exo_facul_1'));
        $form->setLib('exo_facul_2', __('exo_facul_2'));
        $form->setLib('exo_facul_3', __('exo_facul_3'));
        $form->setLib('exo_facul_4', __('exo_facul_4'));
        $form->setLib('exo_facul_5', __('exo_facul_5'));
        $form->setLib('exo_facul_6', __('exo_facul_6'));
        $form->setLib('exo_facul_7', __('exo_facul_7'));
        $form->setLib('exo_facul_8', __('exo_facul_8'));
        $form->setLib('exo_facul_9', __('exo_facul_9'));
        $form->setLib('exo_ta_1', __('exo_ta_1'));
        $form->setLib('exo_ta_2', __('exo_ta_2'));
        $form->setLib('exo_ta_3', __('exo_ta_3'));
        $form->setLib('exo_ta_4', __('exo_ta_4'));
        $form->setLib('exo_ta_5', __('exo_ta_5'));
        $form->setLib('exo_ta_6', __('exo_ta_6'));
        $form->setLib('exo_ta_7', __('exo_ta_7'));
        $form->setLib('exo_ta_8', __('exo_ta_8'));
        $form->setLib('exo_ta_9', __('exo_ta_9'));
        $form->setLib('exo_rap_1', __('exo_rap_1'));
        $form->setLib('exo_rap_2', __('exo_rap_2'));
        $form->setLib('exo_rap_3', __('exo_rap_3'));
        $form->setLib('exo_rap_4', __('exo_rap_4'));
        $form->setLib('exo_rap_5', __('exo_rap_5'));
        $form->setLib('exo_rap_6', __('exo_rap_6'));
        $form->setLib('exo_rap_7', __('exo_rap_7'));
        $form->setLib('exo_rap_8', __('exo_rap_8'));
        $form->setLib('mtn_exo_ta_part_commu', __('mtn_exo_ta_part_commu'));
        $form->setLib('mtn_exo_ta_part_depart', __('mtn_exo_ta_part_depart'));
        $form->setLib('mtn_exo_ta_part_reg', __('mtn_exo_ta_part_reg'));
        $form->setLib('mtn_exo_rap', __('mtn_exo_rap'));
        $form->setLib('dpc_type', __('dpc_type'));
        $form->setLib('dpc_desc_actv_ex', __('dpc_desc_actv_ex'));
        $form->setLib('dpc_desc_ca', __('dpc_desc_ca'));
        $form->setLib('dpc_desc_aut_prec', __('dpc_desc_aut_prec'));
        $form->setLib('dpc_desig_comm_arti', __('dpc_desig_comm_arti'));
        $form->setLib('dpc_desig_loc_hab', __('dpc_desig_loc_hab'));
        $form->setLib('dpc_desig_loc_ann', __('dpc_desig_loc_ann'));
        $form->setLib('dpc_desig_loc_ann_prec', __('dpc_desig_loc_ann_prec'));
        $form->setLib('dpc_bail_comm_date', __('dpc_bail_comm_date'));
        $form->setLib('dpc_bail_comm_loyer', __('dpc_bail_comm_loyer'));
        $form->setLib('dpc_actv_acqu', __('dpc_actv_acqu'));
        $form->setLib('dpc_nb_sala_di', __('dpc_nb_sala_di'));
        $form->setLib('dpc_nb_sala_dd', __('dpc_nb_sala_dd'));
        $form->setLib('dpc_nb_sala_tc', __('dpc_nb_sala_tc'));
        $form->setLib('dpc_nb_sala_tp', __('dpc_nb_sala_tp'));
        $form->setLib('dpc_moda_cess_vente_am', __('dpc_moda_cess_vente_am'));
        $form->setLib('dpc_moda_cess_adj', __('dpc_moda_cess_adj'));
        $form->setLib('dpc_moda_cess_prix', __('dpc_moda_cess_prix'));
        $form->setLib('dpc_moda_cess_adj_date', __('dpc_moda_cess_adj_date'));
        $form->setLib('dpc_moda_cess_adj_prec', __('dpc_moda_cess_adj_prec'));
        $form->setLib('dpc_moda_cess_paie_comp', __('dpc_moda_cess_paie_comp'));
        $form->setLib('dpc_moda_cess_paie_terme', __('dpc_moda_cess_paie_terme'));
        $form->setLib('dpc_moda_cess_paie_terme_prec', __('dpc_moda_cess_paie_terme_prec'));
        $form->setLib('dpc_moda_cess_paie_nat', __('dpc_moda_cess_paie_nat'));
        $form->setLib('dpc_moda_cess_paie_nat_desig_alien', __('dpc_moda_cess_paie_nat_desig_alien'));
        $form->setLib('dpc_moda_cess_paie_nat_desig_alien_prec', __('dpc_moda_cess_paie_nat_desig_alien_prec'));
        $form->setLib('dpc_moda_cess_paie_nat_eval', __('dpc_moda_cess_paie_nat_eval'));
        $form->setLib('dpc_moda_cess_paie_nat_eval_prec', __('dpc_moda_cess_paie_nat_eval_prec'));
        $form->setLib('dpc_moda_cess_paie_aut', __('dpc_moda_cess_paie_aut'));
        $form->setLib('dpc_moda_cess_paie_aut_prec', __('dpc_moda_cess_paie_aut_prec'));
        $form->setLib('dpc_ss_signe_demande_acqu', __('dpc_ss_signe_demande_acqu'));
        $form->setLib('dpc_ss_signe_recher_trouv_acqu', __('dpc_ss_signe_recher_trouv_acqu'));
        $form->setLib('dpc_notif_adr_prop', __('dpc_notif_adr_prop'));
        $form->setLib('dpc_notif_adr_manda', __('dpc_notif_adr_manda'));
        $form->setLib('dpc_obs', __('dpc_obs'));
        $form->setLib('co_peri_site_patri_remar', __('co_peri_site_patri_remar'));
        $form->setLib('co_abo_monu_hist', __('co_abo_monu_hist'));
        $form->setLib('co_inst_ouvr_trav_act_code_envir', __('co_inst_ouvr_trav_act_code_envir'));
        $form->setLib('co_trav_auto_env', __('co_trav_auto_env'));
        $form->setLib('co_derog_esp_prot', __('co_derog_esp_prot'));
        $form->setLib('ctx_reference_dsj', __('ctx_reference_dsj'));
        $form->setLib('co_piscine', __('co_piscine'));
        $form->setLib('co_fin_lls', __('co_fin_lls'));
        $form->setLib('co_fin_aa', __('co_fin_aa'));
        $form->setLib('co_fin_ptz', __('co_fin_ptz'));
        $form->setLib('co_fin_autr', __('co_fin_autr'));
        $form->setLib('dia_ss_date', __('dia_ss_date'));
        $form->setLib('dia_ss_lieu', __('dia_ss_lieu'));
        $form->setLib('enga_decla_lieu', __('enga_decla_lieu'));
        $form->setLib('enga_decla_date', __('enga_decla_date'));
        $form->setLib('co_archi_attest_honneur', __('co_archi_attest_honneur'));
        $form->setLib('co_bat_niv_dessous_nb', __('co_bat_niv_dessous_nb'));
        $form->setLib('co_install_classe', __('co_install_classe'));
        $form->setLib('co_derog_innov', __('co_derog_innov'));
        $form->setLib('co_avis_abf', __('co_avis_abf'));
        $form->setLib('tax_surf_tot_demo', __('tax_surf_tot_demo'));
        $form->setLib('tax_surf_tax_demo', __('tax_surf_tax_demo'));
        $form->setLib('tax_su_non_habit_surf8', __('tax_su_non_habit_surf8'));
        $form->setLib('tax_su_non_habit_surf_stat8', __('tax_su_non_habit_surf_stat8'));
        $form->setLib('tax_su_non_habit_surf9', __('tax_su_non_habit_surf9'));
        $form->setLib('tax_su_non_habit_surf_stat9', __('tax_su_non_habit_surf_stat9'));
        $form->setLib('tax_terrassement_arch', __('tax_terrassement_arch'));
        $form->setLib('tax_adresse_future_numero', __('tax_adresse_future_numero'));
        $form->setLib('tax_adresse_future_voie', __('tax_adresse_future_voie'));
        $form->setLib('tax_adresse_future_lieudit', __('tax_adresse_future_lieudit'));
        $form->setLib('tax_adresse_future_localite', __('tax_adresse_future_localite'));
        $form->setLib('tax_adresse_future_cp', __('tax_adresse_future_cp'));
        $form->setLib('tax_adresse_future_bp', __('tax_adresse_future_bp'));
        $form->setLib('tax_adresse_future_cedex', __('tax_adresse_future_cedex'));
        $form->setLib('tax_adresse_future_pays', __('tax_adresse_future_pays'));
        $form->setLib('tax_adresse_future_division', __('tax_adresse_future_division'));
        $form->setLib('co_bat_projete', __('co_bat_projete'));
        $form->setLib('co_bat_existant', __('co_bat_existant'));
        $form->setLib('co_bat_nature', __('co_bat_nature'));
        $form->setLib('terr_juri_titul_date', __('terr_juri_titul_date'));
        $form->setLib('co_autre_desc', __('co_autre_desc'));
        $form->setLib('co_trx_autre', __('co_trx_autre'));
        $form->setLib('co_autre', __('co_autre'));
        $form->setLib('erp_modif_facades', __('erp_modif_facades'));
        $form->setLib('erp_trvx_adap', __('erp_trvx_adap'));
        $form->setLib('erp_trvx_adap_numero', __('erp_trvx_adap_numero'));
        $form->setLib('erp_trvx_adap_valid', __('erp_trvx_adap_valid'));
        $form->setLib('erp_prod_dangereux', __('erp_prod_dangereux'));
        $form->setLib('co_trav_supp_dessus', __('co_trav_supp_dessus'));
        $form->setLib('co_trav_supp_dessous', __('co_trav_supp_dessous'));
        $form->setLib('tax_su_habit_abr_jard_pig_colom', __('tax_su_habit_abr_jard_pig_colom'));
        $form->setLib('enga_decla_donnees_nomi_comm', __('enga_decla_donnees_nomi_comm'));
        $form->setLib('x1l_legislation', __('x1l_legislation'));
        $form->setLib('x1p_precisions', __('x1p_precisions'));
        $form->setLib('x1u_raccordement', __('x1u_raccordement'));
        $form->setLib('x2m_inscritmh', __('x2m_inscritmh'));
        $form->setLib('s1na1_numero', __('s1na1_numero'));
        $form->setLib('s1va1_voie', __('s1va1_voie'));
        $form->setLib('s1wa1_lieudit', __('s1wa1_lieudit'));
        $form->setLib('s1la1_localite', __('s1la1_localite'));
        $form->setLib('s1pa1_codepostal', __('s1pa1_codepostal'));
        $form->setLib('s1na2_numero', __('s1na2_numero'));
        $form->setLib('s1va2_voie', __('s1va2_voie'));
        $form->setLib('s1wa2_lieudit', __('s1wa2_lieudit'));
        $form->setLib('s1la2_localite', __('s1la2_localite'));
        $form->setLib('s1pa2_codepostal', __('s1pa2_codepostal'));
        $form->setLib('e3c_certification', __('e3c_certification'));
        $form->setLib('e3a_competence', __('e3a_competence'));
        $form->setLib('a4d_description', __('a4d_description'));
        $form->setLib('m2b_abf', __('m2b_abf'));
        $form->setLib('m2j_pn', __('m2j_pn'));
        $form->setLib('m2r_cdac', __('m2r_cdac'));
        $form->setLib('m2r_cnac', __('m2r_cnac'));
        $form->setLib('u3a_voirieoui', __('u3a_voirieoui'));
        $form->setLib('u3f_voirienon', __('u3f_voirienon'));
        $form->setLib('u3c_eauoui', __('u3c_eauoui'));
        $form->setLib('u3h_eaunon', __('u3h_eaunon'));
        $form->setLib('u3g_assainissementoui', __('u3g_assainissementoui'));
        $form->setLib('u3n_assainissementnon', __('u3n_assainissementnon'));
        $form->setLib('u3m_electriciteoui', __('u3m_electriciteoui'));
        $form->setLib('u3b_electricitenon', __('u3b_electricitenon'));
        $form->setLib('u3t_observations', __('u3t_observations'));
        $form->setLib('u1a_voirieoui', __('u1a_voirieoui'));
        $form->setLib('u1v_voirienon', __('u1v_voirienon'));
        $form->setLib('u1q_voirieconcessionnaire', __('u1q_voirieconcessionnaire'));
        $form->setLib('u1b_voirieavant', __('u1b_voirieavant'));
        $form->setLib('u1j_eauoui', __('u1j_eauoui'));
        $form->setLib('u1t_eaunon', __('u1t_eaunon'));
        $form->setLib('u1e_eauconcessionnaire', __('u1e_eauconcessionnaire'));
        $form->setLib('u1k_eauavant', __('u1k_eauavant'));
        $form->setLib('u1s_assainissementoui', __('u1s_assainissementoui'));
        $form->setLib('u1d_assainissementnon', __('u1d_assainissementnon'));
        $form->setLib('u1l_assainissementconcessionnaire', __('u1l_assainissementconcessionnaire'));
        $form->setLib('u1r_assainissementavant', __('u1r_assainissementavant'));
        $form->setLib('u1c_electriciteoui', __('u1c_electriciteoui'));
        $form->setLib('u1u_electricitenon', __('u1u_electricitenon'));
        $form->setLib('u1m_electriciteconcessionnaire', __('u1m_electriciteconcessionnaire'));
        $form->setLib('u1f_electriciteavant', __('u1f_electriciteavant'));
        $form->setLib('u2a_observations', __('u2a_observations'));
        $form->setLib('f1ts4_surftaxestation', __('f1ts4_surftaxestation'));
        $form->setLib('f1ut1_surfcree', __('f1ut1_surfcree'));
        $form->setLib('f9d_date', __('f9d_date'));
        $form->setLib('f9n_nom', __('f9n_nom'));
        $form->setLib('su2_avt_shon21', __('su2_avt_shon21'));
        $form->setLib('su2_avt_shon22', __('su2_avt_shon22'));
        $form->setLib('su2_cstr_shon21', __('su2_cstr_shon21'));
        $form->setLib('su2_cstr_shon22', __('su2_cstr_shon22'));
        $form->setLib('su2_chge_shon21', __('su2_chge_shon21'));
        $form->setLib('su2_chge_shon22', __('su2_chge_shon22'));
        $form->setLib('su2_demo_shon21', __('su2_demo_shon21'));
        $form->setLib('su2_demo_shon22', __('su2_demo_shon22'));
        $form->setLib('su2_sup_shon21', __('su2_sup_shon21'));
        $form->setLib('su2_sup_shon22', __('su2_sup_shon22'));
        $form->setLib('su2_tot_shon21', __('su2_tot_shon21'));
        $form->setLib('su2_tot_shon22', __('su2_tot_shon22'));
        $form->setLib('f1gu1_f1gu2_f1gu3', __('f1gu1_f1gu2_f1gu3'));
        $form->setLib('f1lu1_f1lu2_f1lu3', __('f1lu1_f1lu2_f1lu3'));
        $form->setLib('f1zu1_f1zu2_f1zu3', __('f1zu1_f1zu2_f1zu3'));
        $form->setLib('f1pu1_f1pu2_f1pu3', __('f1pu1_f1pu2_f1pu3'));
        $form->setLib('f1gt4_f1gt5_f1gt6', __('f1gt4_f1gt5_f1gt6'));
        $form->setLib('f1lt4_f1lt5_f1lt6', __('f1lt4_f1lt5_f1lt6'));
        $form->setLib('f1zt4_f1zt5_f1zt6', __('f1zt4_f1zt5_f1zt6'));
        $form->setLib('f1pt4_f1pt5_f1pt6', __('f1pt4_f1pt5_f1pt6'));
        $form->setLib('f1xu1_f1xu2_f1xu3', __('f1xu1_f1xu2_f1xu3'));
        $form->setLib('f1xt4_f1xt5_f1xt6', __('f1xt4_f1xt5_f1xt6'));
        $form->setLib('f1hu1_f1hu2_f1hu3', __('f1hu1_f1hu2_f1hu3'));
        $form->setLib('f1mu1_f1mu2_f1mu3', __('f1mu1_f1mu2_f1mu3'));
        $form->setLib('f1qu1_f1qu2_f1qu3', __('f1qu1_f1qu2_f1qu3'));
        $form->setLib('f1ht4_f1ht5_f1ht6', __('f1ht4_f1ht5_f1ht6'));
        $form->setLib('f1mt4_f1mt5_f1mt6', __('f1mt4_f1mt5_f1mt6'));
        $form->setLib('f1qt4_f1qt5_f1qt6', __('f1qt4_f1qt5_f1qt6'));
        $form->setLib('f2cu1_f2cu2_f2cu3', __('f2cu1_f2cu2_f2cu3'));
        $form->setLib('f2bu1_f2bu2_f2bu3', __('f2bu1_f2bu2_f2bu3'));
        $form->setLib('f2su1_f2su2_f2su3', __('f2su1_f2su2_f2su3'));
        $form->setLib('f2hu1_f2hu2_f2hu3', __('f2hu1_f2hu2_f2hu3'));
        $form->setLib('f2eu1_f2eu2_f2eu3', __('f2eu1_f2eu2_f2eu3'));
        $form->setLib('f2qu1_f2qu2_f2qu3', __('f2qu1_f2qu2_f2qu3'));
        $form->setLib('f2ct4_f2ct5_f2ct6', __('f2ct4_f2ct5_f2ct6'));
        $form->setLib('f2bt4_f2bt5_f2bt6', __('f2bt4_f2bt5_f2bt6'));
        $form->setLib('f2st4_f2st5_f2st6', __('f2st4_f2st5_f2st6'));
        $form->setLib('f2ht4_f2ht5_f2ht6', __('f2ht4_f2ht5_f2ht6'));
        $form->setLib('f2et4_f2et5_f2et6', __('f2et4_f2et5_f2et6'));
        $form->setLib('f2qt4_f2qt5_f2qt6', __('f2qt4_f2qt5_f2qt6'));
        $form->setLib('dia_droit_reel_perso_grevant_bien_desc', __('dia_droit_reel_perso_grevant_bien_desc'));
        $form->setLib('dia_mod_cess_paie_nat_desc', __('dia_mod_cess_paie_nat_desc'));
        $form->setLib('dia_mod_cess_rente_viag_desc', __('dia_mod_cess_rente_viag_desc'));
        $form->setLib('dia_mod_cess_echange_desc', __('dia_mod_cess_echange_desc'));
        $form->setLib('dia_mod_cess_apport_societe_desc', __('dia_mod_cess_apport_societe_desc'));
        $form->setLib('dia_mod_cess_cess_terr_loc_co_desc', __('dia_mod_cess_cess_terr_loc_co_desc'));
        $form->setLib('dia_mod_cess_esti_imm_loca_desc', __('dia_mod_cess_esti_imm_loca_desc'));
        $form->setLib('dia_mod_cess_adju_obl_desc', __('dia_mod_cess_adju_obl_desc'));
        $form->setLib('dia_mod_cess_adju_fin_indivi_desc', __('dia_mod_cess_adju_fin_indivi_desc'));
        $form->setLib('dia_cadre_titul_droit_prempt', __('dia_cadre_titul_droit_prempt'));
        $form->setLib('dia_mairie_prix_moyen', __('dia_mairie_prix_moyen'));
        $form->setLib('dia_propri_indivi', __('dia_propri_indivi'));
        $form->setLib('dia_situa_bien_plan_cadas_oui', __('dia_situa_bien_plan_cadas_oui'));
        $form->setLib('dia_situa_bien_plan_cadas_non', __('dia_situa_bien_plan_cadas_non'));
        $form->setLib('dia_notif_dec_titul_adr_prop', __('dia_notif_dec_titul_adr_prop'));
        $form->setLib('dia_notif_dec_titul_adr_prop_desc', __('dia_notif_dec_titul_adr_prop_desc'));
        $form->setLib('dia_notif_dec_titul_adr_manda', __('dia_notif_dec_titul_adr_manda'));
        $form->setLib('dia_notif_dec_titul_adr_manda_desc', __('dia_notif_dec_titul_adr_manda_desc'));
        $form->setLib('dia_dia_dpu', __('dia_dia_dpu'));
        $form->setLib('dia_dia_zad', __('dia_dia_zad'));
        $form->setLib('dia_dia_zone_preempt_esp_natu_sensi', __('dia_dia_zone_preempt_esp_natu_sensi'));
        $form->setLib('dia_dab_dpu', __('dia_dab_dpu'));
        $form->setLib('dia_dab_zad', __('dia_dab_zad'));
        $form->setLib('dia_mod_cess_commi_mnt', __('dia_mod_cess_commi_mnt'));
        $form->setLib('dia_mod_cess_commi_mnt_ttc', __('dia_mod_cess_commi_mnt_ttc'));
        $form->setLib('dia_mod_cess_commi_mnt_ht', __('dia_mod_cess_commi_mnt_ht'));
        $form->setLib('dia_mod_cess_prix_vente_num', __('dia_mod_cess_prix_vente_num'));
        $form->setLib('dia_mod_cess_prix_vente_mob_num', __('dia_mod_cess_prix_vente_mob_num'));
        $form->setLib('dia_mod_cess_prix_vente_cheptel_num', __('dia_mod_cess_prix_vente_cheptel_num'));
        $form->setLib('dia_mod_cess_prix_vente_recol_num', __('dia_mod_cess_prix_vente_recol_num'));
        $form->setLib('dia_mod_cess_prix_vente_autre_num', __('dia_mod_cess_prix_vente_autre_num'));
        $form->setLib('dia_su_co_sol_num', __('dia_su_co_sol_num'));
        $form->setLib('dia_su_util_hab_num', __('dia_su_util_hab_num'));
        $form->setLib('dia_mod_cess_mnt_an_num', __('dia_mod_cess_mnt_an_num'));
        $form->setLib('dia_mod_cess_mnt_compt_num', __('dia_mod_cess_mnt_compt_num'));
        $form->setLib('dia_mod_cess_mnt_soulte_num', __('dia_mod_cess_mnt_soulte_num'));
        $form->setLib('dia_comp_prix_vente', __('dia_comp_prix_vente'));
        $form->setLib('dia_comp_surface', __('dia_comp_surface'));
        $form->setLib('dia_comp_total_frais', __('dia_comp_total_frais'));
        $form->setLib('dia_comp_mtn_total', __('dia_comp_mtn_total'));
        $form->setLib('dia_comp_valeur_m2', __('dia_comp_valeur_m2'));
        $form->setLib('dia_esti_prix_france_dom', __('dia_esti_prix_france_dom'));
        $form->setLib('dia_prop_collectivite', __('dia_prop_collectivite'));
        $form->setLib('dia_delegataire_denomination', __('dia_delegataire_denomination'));
        $form->setLib('dia_delegataire_raison_sociale', __('dia_delegataire_raison_sociale'));
        $form->setLib('dia_delegataire_siret', __('dia_delegataire_siret'));
        $form->setLib('dia_delegataire_categorie_juridique', __('dia_delegataire_categorie_juridique'));
        $form->setLib('dia_delegataire_representant_nom', __('dia_delegataire_representant_nom'));
        $form->setLib('dia_delegataire_representant_prenom', __('dia_delegataire_representant_prenom'));
        $form->setLib('dia_delegataire_adresse_numero', __('dia_delegataire_adresse_numero'));
        $form->setLib('dia_delegataire_adresse_voie', __('dia_delegataire_adresse_voie'));
        $form->setLib('dia_delegataire_adresse_complement', __('dia_delegataire_adresse_complement'));
        $form->setLib('dia_delegataire_adresse_lieu_dit', __('dia_delegataire_adresse_lieu_dit'));
        $form->setLib('dia_delegataire_adresse_localite', __('dia_delegataire_adresse_localite'));
        $form->setLib('dia_delegataire_adresse_code_postal', __('dia_delegataire_adresse_code_postal'));
        $form->setLib('dia_delegataire_adresse_bp', __('dia_delegataire_adresse_bp'));
        $form->setLib('dia_delegataire_adresse_cedex', __('dia_delegataire_adresse_cedex'));
        $form->setLib('dia_delegataire_adresse_pays', __('dia_delegataire_adresse_pays'));
        $form->setLib('dia_delegataire_telephone_fixe', __('dia_delegataire_telephone_fixe'));
        $form->setLib('dia_delegataire_telephone_mobile', __('dia_delegataire_telephone_mobile'));
        $form->setLib('dia_delegataire_telephone_mobile_indicatif', __('dia_delegataire_telephone_mobile_indicatif'));
        $form->setLib('dia_delegataire_courriel', __('dia_delegataire_courriel'));
        $form->setLib('dia_delegataire_fax', __('dia_delegataire_fax'));
        $form->setLib('dia_entree_jouissance_type', __('dia_entree_jouissance_type'));
        $form->setLib('dia_entree_jouissance_date', __('dia_entree_jouissance_date'));
        $form->setLib('dia_entree_jouissance_date_effet', __('dia_entree_jouissance_date_effet'));
        $form->setLib('dia_entree_jouissance_com', __('dia_entree_jouissance_com'));
        $form->setLib('dia_remise_bien_date_effet', __('dia_remise_bien_date_effet'));
        $form->setLib('dia_remise_bien_com', __('dia_remise_bien_com'));
        $form->setLib('c2zp1_crete', __('c2zp1_crete'));
        $form->setLib('c2zr1_destination', __('c2zr1_destination'));
        $form->setLib('mh_design_appel_denom', __('mh_design_appel_denom'));
        $form->setLib('mh_design_type_protect', __('mh_design_type_protect'));
        $form->setLib('mh_design_elem_prot', __('mh_design_elem_prot'));
        $form->setLib('mh_design_ref_merimee_palissy', __('mh_design_ref_merimee_palissy'));
        $form->setLib('mh_design_nature_prop', __('mh_design_nature_prop'));
        $form->setLib('mh_loc_denom', __('mh_loc_denom'));
        $form->setLib('mh_pres_intitule', __('mh_pres_intitule'));
        $form->setLib('mh_trav_cat_1', __('mh_trav_cat_1'));
        $form->setLib('mh_trav_cat_2', __('mh_trav_cat_2'));
        $form->setLib('mh_trav_cat_3', __('mh_trav_cat_3'));
        $form->setLib('mh_trav_cat_4', __('mh_trav_cat_4'));
        $form->setLib('mh_trav_cat_5', __('mh_trav_cat_5'));
        $form->setLib('mh_trav_cat_6', __('mh_trav_cat_6'));
        $form->setLib('mh_trav_cat_7', __('mh_trav_cat_7'));
        $form->setLib('mh_trav_cat_8', __('mh_trav_cat_8'));
        $form->setLib('mh_trav_cat_9', __('mh_trav_cat_9'));
        $form->setLib('mh_trav_cat_10', __('mh_trav_cat_10'));
        $form->setLib('mh_trav_cat_11', __('mh_trav_cat_11'));
        $form->setLib('mh_trav_cat_12', __('mh_trav_cat_12'));
        $form->setLib('mh_trav_cat_12_prec', __('mh_trav_cat_12_prec'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // architecte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "architecte",
            $this->get_var_sql_forminc__sql("architecte"),
            $this->get_var_sql_forminc__sql("architecte_by_id"),
            false
        );
        // ctx_objet_recours
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "ctx_objet_recours",
            $this->get_var_sql_forminc__sql("ctx_objet_recours"),
            $this->get_var_sql_forminc__sql("ctx_objet_recours_by_id"),
            true
        );
        // dossier_autorisation
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_autorisation",
            $this->get_var_sql_forminc__sql("dossier_autorisation"),
            $this->get_var_sql_forminc__sql("dossier_autorisation_by_id"),
            false
        );
        // dossier_instruction
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_instruction",
            $this->get_var_sql_forminc__sql("dossier_instruction"),
            $this->get_var_sql_forminc__sql("dossier_instruction_by_id"),
            false
        );
        // lot
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "lot",
            $this->get_var_sql_forminc__sql("lot"),
            $this->get_var_sql_forminc__sql("lot_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('architecte', $this->retourformulaire))
                $form->setVal('architecte', $idxformulaire);
            if($this->is_in_context_of_foreign_key('objet_recours', $this->retourformulaire))
                $form->setVal('ctx_objet_recours', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_autorisation', $this->retourformulaire))
                $form->setVal('dossier_autorisation', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier_instruction', $idxformulaire);
            if($this->is_in_context_of_foreign_key('lot', $this->retourformulaire))
                $form->setVal('lot', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    
    /**
     * Methode clesecondaire
     */
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // On appelle la methode de la classe parent
        parent::cleSecondaire($id);
        // Verification de la cle secondaire : lien_donnees_techniques_moyen_retenu_juge
        $this->rechercheTable($this->f->db, "lien_donnees_techniques_moyen_retenu_juge", "donnees_techniques", $id);
        // Verification de la cle secondaire : lien_donnees_techniques_moyen_souleve
        $this->rechercheTable($this->f->db, "lien_donnees_techniques_moyen_souleve", "donnees_techniques", $id);
    }


}
