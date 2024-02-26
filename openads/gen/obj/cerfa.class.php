<?php
//$Id$ 
//gen openMairie le 29/08/2023 16:10

require_once "../obj/om_dbform.class.php";

class cerfa_gen extends om_dbform {

    protected $_absolute_class_name = "cerfa";

    var $table = "cerfa";
    var $clePrimaire = "cerfa";
    var $typeCle = "N";
    var $required_field = array(
        "cerfa"
    );
    
    var $foreign_keys_extended = array(
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("libelle");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "cerfa",
            "libelle",
            "code",
            "om_validite_debut",
            "om_validite_fin",
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
            "tab_surface",
            "dm_constr_dates",
            "dm_total",
            "dm_partiel",
            "dm_projet_desc",
            "dm_tot_log_nb",
            "tax_surf_tot",
            "tax_surf",
            "tax_surf_suppr_mod",
            "tab_tax_su_princ",
            "tab_tax_su_heber",
            "tab_tax_su_secon",
            "tab_tax_su_tot",
            "tax_ext_pret",
            "tax_ext_desc",
            "tax_surf_tax_exist_cons",
            "tax_log_exist_nb",
            "tax_trx_presc_ppr",
            "tax_monu_hist",
            "tax_comm_nb",
            "tab_tax_su_non_habit_surf",
            "tab_tax_am",
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
            "tax_surf_loc_stat",
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
            "tab_tax_su_parc_statio_expl_comm",
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
            "tab_erp_eff",
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
            "tab_surface2",
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
            "ctx_moyen_souleve",
            "ctx_moyen_retenu_juge",
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['cerfa'])) {
            $this->valF['cerfa'] = ""; // -> requis
        } else {
            $this->valF['cerfa'] = $val['cerfa'];
        }
        if ($val['libelle'] == "") {
            $this->valF['libelle'] = NULL;
        } else {
            $this->valF['libelle'] = $val['libelle'];
        }
        if ($val['code'] == "") {
            $this->valF['code'] = NULL;
        } else {
            $this->valF['code'] = $val['code'];
        }
        if ($val['om_validite_debut'] != "") {
            $this->valF['om_validite_debut'] = $this->dateDB($val['om_validite_debut']);
        } else {
            $this->valF['om_validite_debut'] = NULL;
        }
        if ($val['om_validite_fin'] != "") {
            $this->valF['om_validite_fin'] = $this->dateDB($val['om_validite_fin']);
        } else {
            $this->valF['om_validite_fin'] = NULL;
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
        if ($val['am_carav_duree'] == 1 || $val['am_carav_duree'] == "t" || $val['am_carav_duree'] == "Oui") {
            $this->valF['am_carav_duree'] = true;
        } else {
            $this->valF['am_carav_duree'] = false;
        }
        if ($val['am_statio'] == 1 || $val['am_statio'] == "t" || $val['am_statio'] == "Oui") {
            $this->valF['am_statio'] = true;
        } else {
            $this->valF['am_statio'] = false;
        }
        if ($val['am_statio_cont'] == 1 || $val['am_statio_cont'] == "t" || $val['am_statio_cont'] == "Oui") {
            $this->valF['am_statio_cont'] = true;
        } else {
            $this->valF['am_statio_cont'] = false;
        }
        if ($val['am_affou_exhau'] == 1 || $val['am_affou_exhau'] == "t" || $val['am_affou_exhau'] == "Oui") {
            $this->valF['am_affou_exhau'] = true;
        } else {
            $this->valF['am_affou_exhau'] = false;
        }
        if ($val['am_affou_exhau_sup'] == 1 || $val['am_affou_exhau_sup'] == "t" || $val['am_affou_exhau_sup'] == "Oui") {
            $this->valF['am_affou_exhau_sup'] = true;
        } else {
            $this->valF['am_affou_exhau_sup'] = false;
        }
        if ($val['am_affou_prof'] == 1 || $val['am_affou_prof'] == "t" || $val['am_affou_prof'] == "Oui") {
            $this->valF['am_affou_prof'] = true;
        } else {
            $this->valF['am_affou_prof'] = false;
        }
        if ($val['am_exhau_haut'] == 1 || $val['am_exhau_haut'] == "t" || $val['am_exhau_haut'] == "Oui") {
            $this->valF['am_exhau_haut'] = true;
        } else {
            $this->valF['am_exhau_haut'] = false;
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
        if ($val['am_projet_desc'] == 1 || $val['am_projet_desc'] == "t" || $val['am_projet_desc'] == "Oui") {
            $this->valF['am_projet_desc'] = true;
        } else {
            $this->valF['am_projet_desc'] = false;
        }
        if ($val['am_terr_surf'] == 1 || $val['am_terr_surf'] == "t" || $val['am_terr_surf'] == "Oui") {
            $this->valF['am_terr_surf'] = true;
        } else {
            $this->valF['am_terr_surf'] = false;
        }
        if ($val['am_tranche_desc'] == 1 || $val['am_tranche_desc'] == "t" || $val['am_tranche_desc'] == "Oui") {
            $this->valF['am_tranche_desc'] = true;
        } else {
            $this->valF['am_tranche_desc'] = false;
        }
        if ($val['am_lot_max_nb'] == 1 || $val['am_lot_max_nb'] == "t" || $val['am_lot_max_nb'] == "Oui") {
            $this->valF['am_lot_max_nb'] = true;
        } else {
            $this->valF['am_lot_max_nb'] = false;
        }
        if ($val['am_lot_max_shon'] == 1 || $val['am_lot_max_shon'] == "t" || $val['am_lot_max_shon'] == "Oui") {
            $this->valF['am_lot_max_shon'] = true;
        } else {
            $this->valF['am_lot_max_shon'] = false;
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
        if ($val['am_empl_nb'] == 1 || $val['am_empl_nb'] == "t" || $val['am_empl_nb'] == "Oui") {
            $this->valF['am_empl_nb'] = true;
        } else {
            $this->valF['am_empl_nb'] = false;
        }
        if ($val['am_tente_nb'] == 1 || $val['am_tente_nb'] == "t" || $val['am_tente_nb'] == "Oui") {
            $this->valF['am_tente_nb'] = true;
        } else {
            $this->valF['am_tente_nb'] = false;
        }
        if ($val['am_carav_nb'] == 1 || $val['am_carav_nb'] == "t" || $val['am_carav_nb'] == "Oui") {
            $this->valF['am_carav_nb'] = true;
        } else {
            $this->valF['am_carav_nb'] = false;
        }
        if ($val['am_mobil_nb'] == 1 || $val['am_mobil_nb'] == "t" || $val['am_mobil_nb'] == "Oui") {
            $this->valF['am_mobil_nb'] = true;
        } else {
            $this->valF['am_mobil_nb'] = false;
        }
        if ($val['am_pers_nb'] == 1 || $val['am_pers_nb'] == "t" || $val['am_pers_nb'] == "Oui") {
            $this->valF['am_pers_nb'] = true;
        } else {
            $this->valF['am_pers_nb'] = false;
        }
        if ($val['am_empl_hll_nb'] == 1 || $val['am_empl_hll_nb'] == "t" || $val['am_empl_hll_nb'] == "Oui") {
            $this->valF['am_empl_hll_nb'] = true;
        } else {
            $this->valF['am_empl_hll_nb'] = false;
        }
        if ($val['am_hll_shon'] == 1 || $val['am_hll_shon'] == "t" || $val['am_hll_shon'] == "Oui") {
            $this->valF['am_hll_shon'] = true;
        } else {
            $this->valF['am_hll_shon'] = false;
        }
        if ($val['am_periode_exploit'] == 1 || $val['am_periode_exploit'] == "t" || $val['am_periode_exploit'] == "Oui") {
            $this->valF['am_periode_exploit'] = true;
        } else {
            $this->valF['am_periode_exploit'] = false;
        }
        if ($val['am_exist_agrand'] == 1 || $val['am_exist_agrand'] == "t" || $val['am_exist_agrand'] == "Oui") {
            $this->valF['am_exist_agrand'] = true;
        } else {
            $this->valF['am_exist_agrand'] = false;
        }
        if ($val['am_exist_date'] == 1 || $val['am_exist_date'] == "t" || $val['am_exist_date'] == "Oui") {
            $this->valF['am_exist_date'] = true;
        } else {
            $this->valF['am_exist_date'] = false;
        }
        if ($val['am_exist_num'] == 1 || $val['am_exist_num'] == "t" || $val['am_exist_num'] == "Oui") {
            $this->valF['am_exist_num'] = true;
        } else {
            $this->valF['am_exist_num'] = false;
        }
        if ($val['am_exist_nb_avant'] == 1 || $val['am_exist_nb_avant'] == "t" || $val['am_exist_nb_avant'] == "Oui") {
            $this->valF['am_exist_nb_avant'] = true;
        } else {
            $this->valF['am_exist_nb_avant'] = false;
        }
        if ($val['am_exist_nb_apres'] == 1 || $val['am_exist_nb_apres'] == "t" || $val['am_exist_nb_apres'] == "Oui") {
            $this->valF['am_exist_nb_apres'] = true;
        } else {
            $this->valF['am_exist_nb_apres'] = false;
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
        if ($val['am_coupe_ess'] == 1 || $val['am_coupe_ess'] == "t" || $val['am_coupe_ess'] == "Oui") {
            $this->valF['am_coupe_ess'] = true;
        } else {
            $this->valF['am_coupe_ess'] = false;
        }
        if ($val['am_coupe_age'] == 1 || $val['am_coupe_age'] == "t" || $val['am_coupe_age'] == "Oui") {
            $this->valF['am_coupe_age'] = true;
        } else {
            $this->valF['am_coupe_age'] = false;
        }
        if ($val['am_coupe_dens'] == 1 || $val['am_coupe_dens'] == "t" || $val['am_coupe_dens'] == "Oui") {
            $this->valF['am_coupe_dens'] = true;
        } else {
            $this->valF['am_coupe_dens'] = false;
        }
        if ($val['am_coupe_qual'] == 1 || $val['am_coupe_qual'] == "t" || $val['am_coupe_qual'] == "Oui") {
            $this->valF['am_coupe_qual'] = true;
        } else {
            $this->valF['am_coupe_qual'] = false;
        }
        if ($val['am_coupe_trait'] == 1 || $val['am_coupe_trait'] == "t" || $val['am_coupe_trait'] == "Oui") {
            $this->valF['am_coupe_trait'] = true;
        } else {
            $this->valF['am_coupe_trait'] = false;
        }
        if ($val['am_coupe_autr'] == 1 || $val['am_coupe_autr'] == "t" || $val['am_coupe_autr'] == "Oui") {
            $this->valF['am_coupe_autr'] = true;
        } else {
            $this->valF['am_coupe_autr'] = false;
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
        if ($val['co_elec_tension'] == 1 || $val['co_elec_tension'] == "t" || $val['co_elec_tension'] == "Oui") {
            $this->valF['co_elec_tension'] = true;
        } else {
            $this->valF['co_elec_tension'] = false;
        }
        if ($val['co_div_terr'] == 1 || $val['co_div_terr'] == "t" || $val['co_div_terr'] == "Oui") {
            $this->valF['co_div_terr'] = true;
        } else {
            $this->valF['co_div_terr'] = false;
        }
        if ($val['co_projet_desc'] == 1 || $val['co_projet_desc'] == "t" || $val['co_projet_desc'] == "Oui") {
            $this->valF['co_projet_desc'] = true;
        } else {
            $this->valF['co_projet_desc'] = false;
        }
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
        if ($val['co_anx_autr_desc'] == 1 || $val['co_anx_autr_desc'] == "t" || $val['co_anx_autr_desc'] == "Oui") {
            $this->valF['co_anx_autr_desc'] = true;
        } else {
            $this->valF['co_anx_autr_desc'] = false;
        }
        if ($val['co_tot_log_nb'] == 1 || $val['co_tot_log_nb'] == "t" || $val['co_tot_log_nb'] == "Oui") {
            $this->valF['co_tot_log_nb'] = true;
        } else {
            $this->valF['co_tot_log_nb'] = false;
        }
        if ($val['co_tot_ind_nb'] == 1 || $val['co_tot_ind_nb'] == "t" || $val['co_tot_ind_nb'] == "Oui") {
            $this->valF['co_tot_ind_nb'] = true;
        } else {
            $this->valF['co_tot_ind_nb'] = false;
        }
        if ($val['co_tot_coll_nb'] == 1 || $val['co_tot_coll_nb'] == "t" || $val['co_tot_coll_nb'] == "Oui") {
            $this->valF['co_tot_coll_nb'] = true;
        } else {
            $this->valF['co_tot_coll_nb'] = false;
        }
        if ($val['co_mais_piece_nb'] == 1 || $val['co_mais_piece_nb'] == "t" || $val['co_mais_piece_nb'] == "Oui") {
            $this->valF['co_mais_piece_nb'] = true;
        } else {
            $this->valF['co_mais_piece_nb'] = false;
        }
        if ($val['co_mais_niv_nb'] == 1 || $val['co_mais_niv_nb'] == "t" || $val['co_mais_niv_nb'] == "Oui") {
            $this->valF['co_mais_niv_nb'] = true;
        } else {
            $this->valF['co_mais_niv_nb'] = false;
        }
        if ($val['co_fin_lls_nb'] == 1 || $val['co_fin_lls_nb'] == "t" || $val['co_fin_lls_nb'] == "Oui") {
            $this->valF['co_fin_lls_nb'] = true;
        } else {
            $this->valF['co_fin_lls_nb'] = false;
        }
        if ($val['co_fin_aa_nb'] == 1 || $val['co_fin_aa_nb'] == "t" || $val['co_fin_aa_nb'] == "Oui") {
            $this->valF['co_fin_aa_nb'] = true;
        } else {
            $this->valF['co_fin_aa_nb'] = false;
        }
        if ($val['co_fin_ptz_nb'] == 1 || $val['co_fin_ptz_nb'] == "t" || $val['co_fin_ptz_nb'] == "Oui") {
            $this->valF['co_fin_ptz_nb'] = true;
        } else {
            $this->valF['co_fin_ptz_nb'] = false;
        }
        if ($val['co_fin_autr_nb'] == 1 || $val['co_fin_autr_nb'] == "t" || $val['co_fin_autr_nb'] == "Oui") {
            $this->valF['co_fin_autr_nb'] = true;
        } else {
            $this->valF['co_fin_autr_nb'] = false;
        }
        if ($val['co_fin_autr_desc'] == 1 || $val['co_fin_autr_desc'] == "t" || $val['co_fin_autr_desc'] == "Oui") {
            $this->valF['co_fin_autr_desc'] = true;
        } else {
            $this->valF['co_fin_autr_desc'] = false;
        }
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
        if ($val['co_resid_autr_desc'] == 1 || $val['co_resid_autr_desc'] == "t" || $val['co_resid_autr_desc'] == "Oui") {
            $this->valF['co_resid_autr_desc'] = true;
        } else {
            $this->valF['co_resid_autr_desc'] = false;
        }
        if ($val['co_foyer_chamb_nb'] == 1 || $val['co_foyer_chamb_nb'] == "t" || $val['co_foyer_chamb_nb'] == "Oui") {
            $this->valF['co_foyer_chamb_nb'] = true;
        } else {
            $this->valF['co_foyer_chamb_nb'] = false;
        }
        if ($val['co_log_1p_nb'] == 1 || $val['co_log_1p_nb'] == "t" || $val['co_log_1p_nb'] == "Oui") {
            $this->valF['co_log_1p_nb'] = true;
        } else {
            $this->valF['co_log_1p_nb'] = false;
        }
        if ($val['co_log_2p_nb'] == 1 || $val['co_log_2p_nb'] == "t" || $val['co_log_2p_nb'] == "Oui") {
            $this->valF['co_log_2p_nb'] = true;
        } else {
            $this->valF['co_log_2p_nb'] = false;
        }
        if ($val['co_log_3p_nb'] == 1 || $val['co_log_3p_nb'] == "t" || $val['co_log_3p_nb'] == "Oui") {
            $this->valF['co_log_3p_nb'] = true;
        } else {
            $this->valF['co_log_3p_nb'] = false;
        }
        if ($val['co_log_4p_nb'] == 1 || $val['co_log_4p_nb'] == "t" || $val['co_log_4p_nb'] == "Oui") {
            $this->valF['co_log_4p_nb'] = true;
        } else {
            $this->valF['co_log_4p_nb'] = false;
        }
        if ($val['co_log_5p_nb'] == 1 || $val['co_log_5p_nb'] == "t" || $val['co_log_5p_nb'] == "Oui") {
            $this->valF['co_log_5p_nb'] = true;
        } else {
            $this->valF['co_log_5p_nb'] = false;
        }
        if ($val['co_log_6p_nb'] == 1 || $val['co_log_6p_nb'] == "t" || $val['co_log_6p_nb'] == "Oui") {
            $this->valF['co_log_6p_nb'] = true;
        } else {
            $this->valF['co_log_6p_nb'] = false;
        }
        if ($val['co_bat_niv_nb'] == 1 || $val['co_bat_niv_nb'] == "t" || $val['co_bat_niv_nb'] == "Oui") {
            $this->valF['co_bat_niv_nb'] = true;
        } else {
            $this->valF['co_bat_niv_nb'] = false;
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
        if ($val['co_demont_periode'] == 1 || $val['co_demont_periode'] == "t" || $val['co_demont_periode'] == "Oui") {
            $this->valF['co_demont_periode'] = true;
        } else {
            $this->valF['co_demont_periode'] = false;
        }
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
        if ($val['co_statio_avt_nb'] == 1 || $val['co_statio_avt_nb'] == "t" || $val['co_statio_avt_nb'] == "Oui") {
            $this->valF['co_statio_avt_nb'] = true;
        } else {
            $this->valF['co_statio_avt_nb'] = false;
        }
        if ($val['co_statio_apr_nb'] == 1 || $val['co_statio_apr_nb'] == "t" || $val['co_statio_apr_nb'] == "Oui") {
            $this->valF['co_statio_apr_nb'] = true;
        } else {
            $this->valF['co_statio_apr_nb'] = false;
        }
        if ($val['co_statio_adr'] == 1 || $val['co_statio_adr'] == "t" || $val['co_statio_adr'] == "Oui") {
            $this->valF['co_statio_adr'] = true;
        } else {
            $this->valF['co_statio_adr'] = false;
        }
        if ($val['co_statio_place_nb'] == 1 || $val['co_statio_place_nb'] == "t" || $val['co_statio_place_nb'] == "Oui") {
            $this->valF['co_statio_place_nb'] = true;
        } else {
            $this->valF['co_statio_place_nb'] = false;
        }
        if ($val['co_statio_tot_surf'] == 1 || $val['co_statio_tot_surf'] == "t" || $val['co_statio_tot_surf'] == "Oui") {
            $this->valF['co_statio_tot_surf'] = true;
        } else {
            $this->valF['co_statio_tot_surf'] = false;
        }
        if ($val['co_statio_tot_shob'] == 1 || $val['co_statio_tot_shob'] == "t" || $val['co_statio_tot_shob'] == "Oui") {
            $this->valF['co_statio_tot_shob'] = true;
        } else {
            $this->valF['co_statio_tot_shob'] = false;
        }
        if ($val['co_statio_comm_cin_surf'] == 1 || $val['co_statio_comm_cin_surf'] == "t" || $val['co_statio_comm_cin_surf'] == "Oui") {
            $this->valF['co_statio_comm_cin_surf'] = true;
        } else {
            $this->valF['co_statio_comm_cin_surf'] = false;
        }
        if (!is_numeric($val['tab_surface'])) {
            $this->valF['tab_surface'] = NULL;
        } else {
            $this->valF['tab_surface'] = $val['tab_surface'];
        }
        if ($val['dm_constr_dates'] == 1 || $val['dm_constr_dates'] == "t" || $val['dm_constr_dates'] == "Oui") {
            $this->valF['dm_constr_dates'] = true;
        } else {
            $this->valF['dm_constr_dates'] = false;
        }
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
        if ($val['dm_projet_desc'] == 1 || $val['dm_projet_desc'] == "t" || $val['dm_projet_desc'] == "Oui") {
            $this->valF['dm_projet_desc'] = true;
        } else {
            $this->valF['dm_projet_desc'] = false;
        }
        if ($val['dm_tot_log_nb'] == 1 || $val['dm_tot_log_nb'] == "t" || $val['dm_tot_log_nb'] == "Oui") {
            $this->valF['dm_tot_log_nb'] = true;
        } else {
            $this->valF['dm_tot_log_nb'] = false;
        }
        if ($val['tax_surf_tot'] == 1 || $val['tax_surf_tot'] == "t" || $val['tax_surf_tot'] == "Oui") {
            $this->valF['tax_surf_tot'] = true;
        } else {
            $this->valF['tax_surf_tot'] = false;
        }
        if ($val['tax_surf'] == 1 || $val['tax_surf'] == "t" || $val['tax_surf'] == "Oui") {
            $this->valF['tax_surf'] = true;
        } else {
            $this->valF['tax_surf'] = false;
        }
        if ($val['tax_surf_suppr_mod'] == 1 || $val['tax_surf_suppr_mod'] == "t" || $val['tax_surf_suppr_mod'] == "Oui") {
            $this->valF['tax_surf_suppr_mod'] = true;
        } else {
            $this->valF['tax_surf_suppr_mod'] = false;
        }
        if (!is_numeric($val['tab_tax_su_princ'])) {
            $this->valF['tab_tax_su_princ'] = NULL;
        } else {
            $this->valF['tab_tax_su_princ'] = $val['tab_tax_su_princ'];
        }
        if (!is_numeric($val['tab_tax_su_heber'])) {
            $this->valF['tab_tax_su_heber'] = NULL;
        } else {
            $this->valF['tab_tax_su_heber'] = $val['tab_tax_su_heber'];
        }
        if (!is_numeric($val['tab_tax_su_secon'])) {
            $this->valF['tab_tax_su_secon'] = NULL;
        } else {
            $this->valF['tab_tax_su_secon'] = $val['tab_tax_su_secon'];
        }
        if (!is_numeric($val['tab_tax_su_tot'])) {
            $this->valF['tab_tax_su_tot'] = NULL;
        } else {
            $this->valF['tab_tax_su_tot'] = $val['tab_tax_su_tot'];
        }
        if ($val['tax_ext_pret'] == 1 || $val['tax_ext_pret'] == "t" || $val['tax_ext_pret'] == "Oui") {
            $this->valF['tax_ext_pret'] = true;
        } else {
            $this->valF['tax_ext_pret'] = false;
        }
        if ($val['tax_ext_desc'] == 1 || $val['tax_ext_desc'] == "t" || $val['tax_ext_desc'] == "Oui") {
            $this->valF['tax_ext_desc'] = true;
        } else {
            $this->valF['tax_ext_desc'] = false;
        }
        if ($val['tax_surf_tax_exist_cons'] == 1 || $val['tax_surf_tax_exist_cons'] == "t" || $val['tax_surf_tax_exist_cons'] == "Oui") {
            $this->valF['tax_surf_tax_exist_cons'] = true;
        } else {
            $this->valF['tax_surf_tax_exist_cons'] = false;
        }
        if ($val['tax_log_exist_nb'] == 1 || $val['tax_log_exist_nb'] == "t" || $val['tax_log_exist_nb'] == "Oui") {
            $this->valF['tax_log_exist_nb'] = true;
        } else {
            $this->valF['tax_log_exist_nb'] = false;
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
        if ($val['tax_comm_nb'] == 1 || $val['tax_comm_nb'] == "t" || $val['tax_comm_nb'] == "Oui") {
            $this->valF['tax_comm_nb'] = true;
        } else {
            $this->valF['tax_comm_nb'] = false;
        }
        if (!is_numeric($val['tab_tax_su_non_habit_surf'])) {
            $this->valF['tab_tax_su_non_habit_surf'] = NULL;
        } else {
            $this->valF['tab_tax_su_non_habit_surf'] = $val['tab_tax_su_non_habit_surf'];
        }
        if (!is_numeric($val['tab_tax_am'])) {
            $this->valF['tab_tax_am'] = NULL;
        } else {
            $this->valF['tab_tax_am'] = $val['tab_tax_am'];
        }
        if ($val['vsd_surf_planch_smd'] == 1 || $val['vsd_surf_planch_smd'] == "t" || $val['vsd_surf_planch_smd'] == "Oui") {
            $this->valF['vsd_surf_planch_smd'] = true;
        } else {
            $this->valF['vsd_surf_planch_smd'] = false;
        }
        if ($val['vsd_unit_fonc_sup'] == 1 || $val['vsd_unit_fonc_sup'] == "t" || $val['vsd_unit_fonc_sup'] == "Oui") {
            $this->valF['vsd_unit_fonc_sup'] = true;
        } else {
            $this->valF['vsd_unit_fonc_sup'] = false;
        }
        if ($val['vsd_unit_fonc_constr_sup'] == 1 || $val['vsd_unit_fonc_constr_sup'] == "t" || $val['vsd_unit_fonc_constr_sup'] == "Oui") {
            $this->valF['vsd_unit_fonc_constr_sup'] = true;
        } else {
            $this->valF['vsd_unit_fonc_constr_sup'] = false;
        }
        if ($val['vsd_val_terr'] == 1 || $val['vsd_val_terr'] == "t" || $val['vsd_val_terr'] == "Oui") {
            $this->valF['vsd_val_terr'] = true;
        } else {
            $this->valF['vsd_val_terr'] = false;
        }
        if ($val['vsd_const_sxist_non_dem_surf'] == 1 || $val['vsd_const_sxist_non_dem_surf'] == "t" || $val['vsd_const_sxist_non_dem_surf'] == "Oui") {
            $this->valF['vsd_const_sxist_non_dem_surf'] = true;
        } else {
            $this->valF['vsd_const_sxist_non_dem_surf'] = false;
        }
        if ($val['vsd_rescr_fisc'] == 1 || $val['vsd_rescr_fisc'] == "t" || $val['vsd_rescr_fisc'] == "Oui") {
            $this->valF['vsd_rescr_fisc'] = true;
        } else {
            $this->valF['vsd_rescr_fisc'] = false;
        }
        if ($val['pld_val_terr'] == 1 || $val['pld_val_terr'] == "t" || $val['pld_val_terr'] == "Oui") {
            $this->valF['pld_val_terr'] = true;
        } else {
            $this->valF['pld_val_terr'] = false;
        }
        if ($val['pld_const_exist_dem'] == 1 || $val['pld_const_exist_dem'] == "t" || $val['pld_const_exist_dem'] == "Oui") {
            $this->valF['pld_const_exist_dem'] = true;
        } else {
            $this->valF['pld_const_exist_dem'] = false;
        }
        if ($val['pld_const_exist_dem_surf'] == 1 || $val['pld_const_exist_dem_surf'] == "t" || $val['pld_const_exist_dem_surf'] == "Oui") {
            $this->valF['pld_const_exist_dem_surf'] = true;
        } else {
            $this->valF['pld_const_exist_dem_surf'] = false;
        }
        if ($val['code_cnil'] == 1 || $val['code_cnil'] == "t" || $val['code_cnil'] == "Oui") {
            $this->valF['code_cnil'] = true;
        } else {
            $this->valF['code_cnil'] = false;
        }
        if ($val['terr_juri_titul'] == 1 || $val['terr_juri_titul'] == "t" || $val['terr_juri_titul'] == "Oui") {
            $this->valF['terr_juri_titul'] = true;
        } else {
            $this->valF['terr_juri_titul'] = false;
        }
        if ($val['terr_juri_lot'] == 1 || $val['terr_juri_lot'] == "t" || $val['terr_juri_lot'] == "Oui") {
            $this->valF['terr_juri_lot'] = true;
        } else {
            $this->valF['terr_juri_lot'] = false;
        }
        if ($val['terr_juri_zac'] == 1 || $val['terr_juri_zac'] == "t" || $val['terr_juri_zac'] == "Oui") {
            $this->valF['terr_juri_zac'] = true;
        } else {
            $this->valF['terr_juri_zac'] = false;
        }
        if ($val['terr_juri_afu'] == 1 || $val['terr_juri_afu'] == "t" || $val['terr_juri_afu'] == "Oui") {
            $this->valF['terr_juri_afu'] = true;
        } else {
            $this->valF['terr_juri_afu'] = false;
        }
        if ($val['terr_juri_pup'] == 1 || $val['terr_juri_pup'] == "t" || $val['terr_juri_pup'] == "Oui") {
            $this->valF['terr_juri_pup'] = true;
        } else {
            $this->valF['terr_juri_pup'] = false;
        }
        if ($val['terr_juri_oin'] == 1 || $val['terr_juri_oin'] == "t" || $val['terr_juri_oin'] == "Oui") {
            $this->valF['terr_juri_oin'] = true;
        } else {
            $this->valF['terr_juri_oin'] = false;
        }
        if ($val['terr_juri_desc'] == 1 || $val['terr_juri_desc'] == "t" || $val['terr_juri_desc'] == "Oui") {
            $this->valF['terr_juri_desc'] = true;
        } else {
            $this->valF['terr_juri_desc'] = false;
        }
        if ($val['terr_div_surf_etab'] == 1 || $val['terr_div_surf_etab'] == "t" || $val['terr_div_surf_etab'] == "Oui") {
            $this->valF['terr_div_surf_etab'] = true;
        } else {
            $this->valF['terr_div_surf_etab'] = false;
        }
        if ($val['terr_div_surf_av_div'] == 1 || $val['terr_div_surf_av_div'] == "t" || $val['terr_div_surf_av_div'] == "Oui") {
            $this->valF['terr_div_surf_av_div'] = true;
        } else {
            $this->valF['terr_div_surf_av_div'] = false;
        }
        if ($val['doc_date'] == 1 || $val['doc_date'] == "t" || $val['doc_date'] == "Oui") {
            $this->valF['doc_date'] = true;
        } else {
            $this->valF['doc_date'] = false;
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
        if ($val['doc_tranche_trav_desc'] == 1 || $val['doc_tranche_trav_desc'] == "t" || $val['doc_tranche_trav_desc'] == "Oui") {
            $this->valF['doc_tranche_trav_desc'] = true;
        } else {
            $this->valF['doc_tranche_trav_desc'] = false;
        }
        if ($val['doc_surf'] == 1 || $val['doc_surf'] == "t" || $val['doc_surf'] == "Oui") {
            $this->valF['doc_surf'] = true;
        } else {
            $this->valF['doc_surf'] = false;
        }
        if ($val['doc_nb_log'] == 1 || $val['doc_nb_log'] == "t" || $val['doc_nb_log'] == "Oui") {
            $this->valF['doc_nb_log'] = true;
        } else {
            $this->valF['doc_nb_log'] = false;
        }
        if ($val['doc_nb_log_indiv'] == 1 || $val['doc_nb_log_indiv'] == "t" || $val['doc_nb_log_indiv'] == "Oui") {
            $this->valF['doc_nb_log_indiv'] = true;
        } else {
            $this->valF['doc_nb_log_indiv'] = false;
        }
        if ($val['doc_nb_log_coll'] == 1 || $val['doc_nb_log_coll'] == "t" || $val['doc_nb_log_coll'] == "Oui") {
            $this->valF['doc_nb_log_coll'] = true;
        } else {
            $this->valF['doc_nb_log_coll'] = false;
        }
        if ($val['doc_nb_log_lls'] == 1 || $val['doc_nb_log_lls'] == "t" || $val['doc_nb_log_lls'] == "Oui") {
            $this->valF['doc_nb_log_lls'] = true;
        } else {
            $this->valF['doc_nb_log_lls'] = false;
        }
        if ($val['doc_nb_log_aa'] == 1 || $val['doc_nb_log_aa'] == "t" || $val['doc_nb_log_aa'] == "Oui") {
            $this->valF['doc_nb_log_aa'] = true;
        } else {
            $this->valF['doc_nb_log_aa'] = false;
        }
        if ($val['doc_nb_log_ptz'] == 1 || $val['doc_nb_log_ptz'] == "t" || $val['doc_nb_log_ptz'] == "Oui") {
            $this->valF['doc_nb_log_ptz'] = true;
        } else {
            $this->valF['doc_nb_log_ptz'] = false;
        }
        if ($val['doc_nb_log_autre'] == 1 || $val['doc_nb_log_autre'] == "t" || $val['doc_nb_log_autre'] == "Oui") {
            $this->valF['doc_nb_log_autre'] = true;
        } else {
            $this->valF['doc_nb_log_autre'] = false;
        }
        if ($val['daact_date'] == 1 || $val['daact_date'] == "t" || $val['daact_date'] == "Oui") {
            $this->valF['daact_date'] = true;
        } else {
            $this->valF['daact_date'] = false;
        }
        if ($val['daact_date_chgmt_dest'] == 1 || $val['daact_date_chgmt_dest'] == "t" || $val['daact_date_chgmt_dest'] == "Oui") {
            $this->valF['daact_date_chgmt_dest'] = true;
        } else {
            $this->valF['daact_date_chgmt_dest'] = false;
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
        if ($val['daact_tranche_trav_desc'] == 1 || $val['daact_tranche_trav_desc'] == "t" || $val['daact_tranche_trav_desc'] == "Oui") {
            $this->valF['daact_tranche_trav_desc'] = true;
        } else {
            $this->valF['daact_tranche_trav_desc'] = false;
        }
        if ($val['daact_surf'] == 1 || $val['daact_surf'] == "t" || $val['daact_surf'] == "Oui") {
            $this->valF['daact_surf'] = true;
        } else {
            $this->valF['daact_surf'] = false;
        }
        if ($val['daact_nb_log'] == 1 || $val['daact_nb_log'] == "t" || $val['daact_nb_log'] == "Oui") {
            $this->valF['daact_nb_log'] = true;
        } else {
            $this->valF['daact_nb_log'] = false;
        }
        if ($val['daact_nb_log_indiv'] == 1 || $val['daact_nb_log_indiv'] == "t" || $val['daact_nb_log_indiv'] == "Oui") {
            $this->valF['daact_nb_log_indiv'] = true;
        } else {
            $this->valF['daact_nb_log_indiv'] = false;
        }
        if ($val['daact_nb_log_coll'] == 1 || $val['daact_nb_log_coll'] == "t" || $val['daact_nb_log_coll'] == "Oui") {
            $this->valF['daact_nb_log_coll'] = true;
        } else {
            $this->valF['daact_nb_log_coll'] = false;
        }
        if ($val['daact_nb_log_lls'] == 1 || $val['daact_nb_log_lls'] == "t" || $val['daact_nb_log_lls'] == "Oui") {
            $this->valF['daact_nb_log_lls'] = true;
        } else {
            $this->valF['daact_nb_log_lls'] = false;
        }
        if ($val['daact_nb_log_aa'] == 1 || $val['daact_nb_log_aa'] == "t" || $val['daact_nb_log_aa'] == "Oui") {
            $this->valF['daact_nb_log_aa'] = true;
        } else {
            $this->valF['daact_nb_log_aa'] = false;
        }
        if ($val['daact_nb_log_ptz'] == 1 || $val['daact_nb_log_ptz'] == "t" || $val['daact_nb_log_ptz'] == "Oui") {
            $this->valF['daact_nb_log_ptz'] = true;
        } else {
            $this->valF['daact_nb_log_ptz'] = false;
        }
        if ($val['daact_nb_log_autre'] == 1 || $val['daact_nb_log_autre'] == "t" || $val['daact_nb_log_autre'] == "Oui") {
            $this->valF['daact_nb_log_autre'] = true;
        } else {
            $this->valF['daact_nb_log_autre'] = false;
        }
        if ($val['am_div_mun'] == 1 || $val['am_div_mun'] == "t" || $val['am_div_mun'] == "Oui") {
            $this->valF['am_div_mun'] = true;
        } else {
            $this->valF['am_div_mun'] = false;
        }
        if ($val['co_perf_energ'] == 1 || $val['co_perf_energ'] == "t" || $val['co_perf_energ'] == "Oui") {
            $this->valF['co_perf_energ'] = true;
        } else {
            $this->valF['co_perf_energ'] = false;
        }
        if ($val['architecte'] == 1 || $val['architecte'] == "t" || $val['architecte'] == "Oui") {
            $this->valF['architecte'] = true;
        } else {
            $this->valF['architecte'] = false;
        }
        if ($val['co_statio_avt_shob'] == 1 || $val['co_statio_avt_shob'] == "t" || $val['co_statio_avt_shob'] == "Oui") {
            $this->valF['co_statio_avt_shob'] = true;
        } else {
            $this->valF['co_statio_avt_shob'] = false;
        }
        if ($val['co_statio_apr_shob'] == 1 || $val['co_statio_apr_shob'] == "t" || $val['co_statio_apr_shob'] == "Oui") {
            $this->valF['co_statio_apr_shob'] = true;
        } else {
            $this->valF['co_statio_apr_shob'] = false;
        }
        if ($val['co_statio_avt_surf'] == 1 || $val['co_statio_avt_surf'] == "t" || $val['co_statio_avt_surf'] == "Oui") {
            $this->valF['co_statio_avt_surf'] = true;
        } else {
            $this->valF['co_statio_avt_surf'] = false;
        }
        if ($val['co_statio_apr_surf'] == 1 || $val['co_statio_apr_surf'] == "t" || $val['co_statio_apr_surf'] == "Oui") {
            $this->valF['co_statio_apr_surf'] = true;
        } else {
            $this->valF['co_statio_apr_surf'] = false;
        }
        if ($val['co_trx_amgt'] == 1 || $val['co_trx_amgt'] == "t" || $val['co_trx_amgt'] == "Oui") {
            $this->valF['co_trx_amgt'] = true;
        } else {
            $this->valF['co_trx_amgt'] = false;
        }
        if ($val['co_modif_aspect'] == 1 || $val['co_modif_aspect'] == "t" || $val['co_modif_aspect'] == "Oui") {
            $this->valF['co_modif_aspect'] = true;
        } else {
            $this->valF['co_modif_aspect'] = false;
        }
        if ($val['co_modif_struct'] == 1 || $val['co_modif_struct'] == "t" || $val['co_modif_struct'] == "Oui") {
            $this->valF['co_modif_struct'] = true;
        } else {
            $this->valF['co_modif_struct'] = false;
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
        if ($val['co_trx_imm'] == 1 || $val['co_trx_imm'] == "t" || $val['co_trx_imm'] == "Oui") {
            $this->valF['co_trx_imm'] = true;
        } else {
            $this->valF['co_trx_imm'] = false;
        }
        if ($val['co_cstr_shob'] == 1 || $val['co_cstr_shob'] == "t" || $val['co_cstr_shob'] == "Oui") {
            $this->valF['co_cstr_shob'] = true;
        } else {
            $this->valF['co_cstr_shob'] = false;
        }
        if ($val['am_voyage_deb'] == 1 || $val['am_voyage_deb'] == "t" || $val['am_voyage_deb'] == "Oui") {
            $this->valF['am_voyage_deb'] = true;
        } else {
            $this->valF['am_voyage_deb'] = false;
        }
        if ($val['am_voyage_fin'] == 1 || $val['am_voyage_fin'] == "t" || $val['am_voyage_fin'] == "Oui") {
            $this->valF['am_voyage_fin'] = true;
        } else {
            $this->valF['am_voyage_fin'] = false;
        }
        if ($val['am_modif_amgt'] == 1 || $val['am_modif_amgt'] == "t" || $val['am_modif_amgt'] == "Oui") {
            $this->valF['am_modif_amgt'] = true;
        } else {
            $this->valF['am_modif_amgt'] = false;
        }
        if ($val['am_lot_max_shob'] == 1 || $val['am_lot_max_shob'] == "t" || $val['am_lot_max_shob'] == "Oui") {
            $this->valF['am_lot_max_shob'] = true;
        } else {
            $this->valF['am_lot_max_shob'] = false;
        }
        if ($val['mod_desc'] == 1 || $val['mod_desc'] == "t" || $val['mod_desc'] == "Oui") {
            $this->valF['mod_desc'] = true;
        } else {
            $this->valF['mod_desc'] = false;
        }
        if ($val['tr_total'] == 1 || $val['tr_total'] == "t" || $val['tr_total'] == "Oui") {
            $this->valF['tr_total'] = true;
        } else {
            $this->valF['tr_total'] = false;
        }
        if ($val['tr_partiel'] == 1 || $val['tr_partiel'] == "t" || $val['tr_partiel'] == "Oui") {
            $this->valF['tr_partiel'] = true;
        } else {
            $this->valF['tr_partiel'] = false;
        }
        if ($val['tr_desc'] == 1 || $val['tr_desc'] == "t" || $val['tr_desc'] == "Oui") {
            $this->valF['tr_desc'] = true;
        } else {
            $this->valF['tr_desc'] = false;
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
        if ($val['avap_co_clot'] == 1 || $val['avap_co_clot'] == "t" || $val['avap_co_clot'] == "Oui") {
            $this->valF['avap_co_clot'] = true;
        } else {
            $this->valF['avap_co_clot'] = false;
        }
        if ($val['avap_aut_coup_aba_arb'] == 1 || $val['avap_aut_coup_aba_arb'] == "t" || $val['avap_aut_coup_aba_arb'] == "Oui") {
            $this->valF['avap_aut_coup_aba_arb'] = true;
        } else {
            $this->valF['avap_aut_coup_aba_arb'] = false;
        }
        if ($val['avap_ouv_infra'] == 1 || $val['avap_ouv_infra'] == "t" || $val['avap_ouv_infra'] == "Oui") {
            $this->valF['avap_ouv_infra'] = true;
        } else {
            $this->valF['avap_ouv_infra'] = false;
        }
        if ($val['avap_aut_inst_mob'] == 1 || $val['avap_aut_inst_mob'] == "t" || $val['avap_aut_inst_mob'] == "Oui") {
            $this->valF['avap_aut_inst_mob'] = true;
        } else {
            $this->valF['avap_aut_inst_mob'] = false;
        }
        if ($val['avap_aut_plant'] == 1 || $val['avap_aut_plant'] == "t" || $val['avap_aut_plant'] == "Oui") {
            $this->valF['avap_aut_plant'] = true;
        } else {
            $this->valF['avap_aut_plant'] = false;
        }
        if ($val['avap_aut_auv_elec'] == 1 || $val['avap_aut_auv_elec'] == "t" || $val['avap_aut_auv_elec'] == "Oui") {
            $this->valF['avap_aut_auv_elec'] = true;
        } else {
            $this->valF['avap_aut_auv_elec'] = false;
        }
        if ($val['tax_dest_loc_tr'] == 1 || $val['tax_dest_loc_tr'] == "t" || $val['tax_dest_loc_tr'] == "Oui") {
            $this->valF['tax_dest_loc_tr'] = true;
        } else {
            $this->valF['tax_dest_loc_tr'] = false;
        }
        if ($val['ope_proj_desc'] == 1 || $val['ope_proj_desc'] == "t" || $val['ope_proj_desc'] == "Oui") {
            $this->valF['ope_proj_desc'] = true;
        } else {
            $this->valF['ope_proj_desc'] = false;
        }
        if ($val['tax_surf_tot_cstr'] == 1 || $val['tax_surf_tot_cstr'] == "t" || $val['tax_surf_tot_cstr'] == "Oui") {
            $this->valF['tax_surf_tot_cstr'] = true;
        } else {
            $this->valF['tax_surf_tot_cstr'] = false;
        }
        if ($val['tax_surf_loc_stat'] == 1 || $val['tax_surf_loc_stat'] == "t" || $val['tax_surf_loc_stat'] == "Oui") {
            $this->valF['tax_surf_loc_stat'] = true;
        } else {
            $this->valF['tax_surf_loc_stat'] = false;
        }
        if ($val['tax_log_ap_trvx_nb'] == 1 || $val['tax_log_ap_trvx_nb'] == "t" || $val['tax_log_ap_trvx_nb'] == "Oui") {
            $this->valF['tax_log_ap_trvx_nb'] = true;
        } else {
            $this->valF['tax_log_ap_trvx_nb'] = false;
        }
        if ($val['tax_am_statio_ext_cr'] == 1 || $val['tax_am_statio_ext_cr'] == "t" || $val['tax_am_statio_ext_cr'] == "Oui") {
            $this->valF['tax_am_statio_ext_cr'] = true;
        } else {
            $this->valF['tax_am_statio_ext_cr'] = false;
        }
        if ($val['tax_sup_bass_pisc_cr'] == 1 || $val['tax_sup_bass_pisc_cr'] == "t" || $val['tax_sup_bass_pisc_cr'] == "Oui") {
            $this->valF['tax_sup_bass_pisc_cr'] = true;
        } else {
            $this->valF['tax_sup_bass_pisc_cr'] = false;
        }
        if ($val['tax_empl_ten_carav_mobil_nb_cr'] == 1 || $val['tax_empl_ten_carav_mobil_nb_cr'] == "t" || $val['tax_empl_ten_carav_mobil_nb_cr'] == "Oui") {
            $this->valF['tax_empl_ten_carav_mobil_nb_cr'] = true;
        } else {
            $this->valF['tax_empl_ten_carav_mobil_nb_cr'] = false;
        }
        if ($val['tax_empl_hll_nb_cr'] == 1 || $val['tax_empl_hll_nb_cr'] == "t" || $val['tax_empl_hll_nb_cr'] == "Oui") {
            $this->valF['tax_empl_hll_nb_cr'] = true;
        } else {
            $this->valF['tax_empl_hll_nb_cr'] = false;
        }
        if ($val['tax_eol_haut_nb_cr'] == 1 || $val['tax_eol_haut_nb_cr'] == "t" || $val['tax_eol_haut_nb_cr'] == "Oui") {
            $this->valF['tax_eol_haut_nb_cr'] = true;
        } else {
            $this->valF['tax_eol_haut_nb_cr'] = false;
        }
        if ($val['tax_pann_volt_sup_cr'] == 1 || $val['tax_pann_volt_sup_cr'] == "t" || $val['tax_pann_volt_sup_cr'] == "Oui") {
            $this->valF['tax_pann_volt_sup_cr'] = true;
        } else {
            $this->valF['tax_pann_volt_sup_cr'] = false;
        }
        if ($val['tax_surf_loc_arch'] == 1 || $val['tax_surf_loc_arch'] == "t" || $val['tax_surf_loc_arch'] == "Oui") {
            $this->valF['tax_surf_loc_arch'] = true;
        } else {
            $this->valF['tax_surf_loc_arch'] = false;
        }
        if ($val['tax_surf_pisc_arch'] == 1 || $val['tax_surf_pisc_arch'] == "t" || $val['tax_surf_pisc_arch'] == "Oui") {
            $this->valF['tax_surf_pisc_arch'] = true;
        } else {
            $this->valF['tax_surf_pisc_arch'] = false;
        }
        if ($val['tax_am_statio_ext_arch'] == 1 || $val['tax_am_statio_ext_arch'] == "t" || $val['tax_am_statio_ext_arch'] == "Oui") {
            $this->valF['tax_am_statio_ext_arch'] = true;
        } else {
            $this->valF['tax_am_statio_ext_arch'] = false;
        }
        if (!is_numeric($val['tab_tax_su_parc_statio_expl_comm'])) {
            $this->valF['tab_tax_su_parc_statio_expl_comm'] = NULL;
        } else {
            $this->valF['tab_tax_su_parc_statio_expl_comm'] = $val['tab_tax_su_parc_statio_expl_comm'];
        }
        if ($val['tax_empl_ten_carav_mobil_nb_arch'] == 1 || $val['tax_empl_ten_carav_mobil_nb_arch'] == "t" || $val['tax_empl_ten_carav_mobil_nb_arch'] == "Oui") {
            $this->valF['tax_empl_ten_carav_mobil_nb_arch'] = true;
        } else {
            $this->valF['tax_empl_ten_carav_mobil_nb_arch'] = false;
        }
        if ($val['tax_empl_hll_nb_arch'] == 1 || $val['tax_empl_hll_nb_arch'] == "t" || $val['tax_empl_hll_nb_arch'] == "Oui") {
            $this->valF['tax_empl_hll_nb_arch'] = true;
        } else {
            $this->valF['tax_empl_hll_nb_arch'] = false;
        }
        if ($val['tax_eol_haut_nb_arch'] == 1 || $val['tax_eol_haut_nb_arch'] == "t" || $val['tax_eol_haut_nb_arch'] == "Oui") {
            $this->valF['tax_eol_haut_nb_arch'] = true;
        } else {
            $this->valF['tax_eol_haut_nb_arch'] = false;
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
        if ($val['tax_desc'] == 1 || $val['tax_desc'] == "t" || $val['tax_desc'] == "Oui") {
            $this->valF['tax_desc'] = true;
        } else {
            $this->valF['tax_desc'] = false;
        }
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
        if (!is_numeric($val['tab_erp_eff'])) {
            $this->valF['tab_erp_eff'] = NULL;
        } else {
            $this->valF['tab_erp_eff'] = $val['tab_erp_eff'];
        }
        if ($val['erp_class_cat'] == 1 || $val['erp_class_cat'] == "t" || $val['erp_class_cat'] == "Oui") {
            $this->valF['erp_class_cat'] = true;
        } else {
            $this->valF['erp_class_cat'] = false;
        }
        if ($val['erp_class_type'] == 1 || $val['erp_class_type'] == "t" || $val['erp_class_type'] == "Oui") {
            $this->valF['erp_class_type'] = true;
        } else {
            $this->valF['erp_class_type'] = false;
        }
        if ($val['tax_surf_abr_jard_pig_colom'] == 1 || $val['tax_surf_abr_jard_pig_colom'] == "t" || $val['tax_surf_abr_jard_pig_colom'] == "Oui") {
            $this->valF['tax_surf_abr_jard_pig_colom'] = true;
        } else {
            $this->valF['tax_surf_abr_jard_pig_colom'] = false;
        }
        if ($val['tax_su_non_habit_abr_jard_pig_colom'] == 1 || $val['tax_su_non_habit_abr_jard_pig_colom'] == "t" || $val['tax_su_non_habit_abr_jard_pig_colom'] == "Oui") {
            $this->valF['tax_su_non_habit_abr_jard_pig_colom'] = true;
        } else {
            $this->valF['tax_su_non_habit_abr_jard_pig_colom'] = false;
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
        if ($val['dia_imm_bati_terr_autr_desc'] == 1 || $val['dia_imm_bati_terr_autr_desc'] == "t" || $val['dia_imm_bati_terr_autr_desc'] == "Oui") {
            $this->valF['dia_imm_bati_terr_autr_desc'] = true;
        } else {
            $this->valF['dia_imm_bati_terr_autr_desc'] = false;
        }
        if ($val['dia_bat_copro'] == 1 || $val['dia_bat_copro'] == "t" || $val['dia_bat_copro'] == "Oui") {
            $this->valF['dia_bat_copro'] = true;
        } else {
            $this->valF['dia_bat_copro'] = false;
        }
        if ($val['dia_bat_copro_desc'] == 1 || $val['dia_bat_copro_desc'] == "t" || $val['dia_bat_copro_desc'] == "Oui") {
            $this->valF['dia_bat_copro_desc'] = true;
        } else {
            $this->valF['dia_bat_copro_desc'] = false;
        }
        if ($val['dia_lot_numero'] == 1 || $val['dia_lot_numero'] == "t" || $val['dia_lot_numero'] == "Oui") {
            $this->valF['dia_lot_numero'] = true;
        } else {
            $this->valF['dia_lot_numero'] = false;
        }
        if ($val['dia_lot_bat'] == 1 || $val['dia_lot_bat'] == "t" || $val['dia_lot_bat'] == "Oui") {
            $this->valF['dia_lot_bat'] = true;
        } else {
            $this->valF['dia_lot_bat'] = false;
        }
        if ($val['dia_lot_etage'] == 1 || $val['dia_lot_etage'] == "t" || $val['dia_lot_etage'] == "Oui") {
            $this->valF['dia_lot_etage'] = true;
        } else {
            $this->valF['dia_lot_etage'] = false;
        }
        if ($val['dia_lot_quote_part'] == 1 || $val['dia_lot_quote_part'] == "t" || $val['dia_lot_quote_part'] == "Oui") {
            $this->valF['dia_lot_quote_part'] = true;
        } else {
            $this->valF['dia_lot_quote_part'] = false;
        }
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
        if ($val['dia_us_autre_prec'] == 1 || $val['dia_us_autre_prec'] == "t" || $val['dia_us_autre_prec'] == "Oui") {
            $this->valF['dia_us_autre_prec'] = true;
        } else {
            $this->valF['dia_us_autre_prec'] = false;
        }
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
        if ($val['dia_occ_autre_prec'] == 1 || $val['dia_occ_autre_prec'] == "t" || $val['dia_occ_autre_prec'] == "Oui") {
            $this->valF['dia_occ_autre_prec'] = true;
        } else {
            $this->valF['dia_occ_autre_prec'] = false;
        }
        if ($val['dia_mod_cess_prix_vente'] == 1 || $val['dia_mod_cess_prix_vente'] == "t" || $val['dia_mod_cess_prix_vente'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente'] = false;
        }
        if ($val['dia_mod_cess_prix_vente_mob'] == 1 || $val['dia_mod_cess_prix_vente_mob'] == "t" || $val['dia_mod_cess_prix_vente_mob'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente_mob'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente_mob'] = false;
        }
        if ($val['dia_mod_cess_prix_vente_cheptel'] == 1 || $val['dia_mod_cess_prix_vente_cheptel'] == "t" || $val['dia_mod_cess_prix_vente_cheptel'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente_cheptel'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente_cheptel'] = false;
        }
        if ($val['dia_mod_cess_prix_vente_recol'] == 1 || $val['dia_mod_cess_prix_vente_recol'] == "t" || $val['dia_mod_cess_prix_vente_recol'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente_recol'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente_recol'] = false;
        }
        if ($val['dia_mod_cess_prix_vente_autre'] == 1 || $val['dia_mod_cess_prix_vente_autre'] == "t" || $val['dia_mod_cess_prix_vente_autre'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente_autre'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente_autre'] = false;
        }
        if ($val['dia_mod_cess_commi'] == 1 || $val['dia_mod_cess_commi'] == "t" || $val['dia_mod_cess_commi'] == "Oui") {
            $this->valF['dia_mod_cess_commi'] = true;
        } else {
            $this->valF['dia_mod_cess_commi'] = false;
        }
        if ($val['dia_mod_cess_commi_ttc'] == 1 || $val['dia_mod_cess_commi_ttc'] == "t" || $val['dia_mod_cess_commi_ttc'] == "Oui") {
            $this->valF['dia_mod_cess_commi_ttc'] = true;
        } else {
            $this->valF['dia_mod_cess_commi_ttc'] = false;
        }
        if ($val['dia_mod_cess_commi_ht'] == 1 || $val['dia_mod_cess_commi_ht'] == "t" || $val['dia_mod_cess_commi_ht'] == "Oui") {
            $this->valF['dia_mod_cess_commi_ht'] = true;
        } else {
            $this->valF['dia_mod_cess_commi_ht'] = false;
        }
        if ($val['dia_acquereur_nom_prenom'] == 1 || $val['dia_acquereur_nom_prenom'] == "t" || $val['dia_acquereur_nom_prenom'] == "Oui") {
            $this->valF['dia_acquereur_nom_prenom'] = true;
        } else {
            $this->valF['dia_acquereur_nom_prenom'] = false;
        }
        if ($val['dia_acquereur_adr_num_voie'] == 1 || $val['dia_acquereur_adr_num_voie'] == "t" || $val['dia_acquereur_adr_num_voie'] == "Oui") {
            $this->valF['dia_acquereur_adr_num_voie'] = true;
        } else {
            $this->valF['dia_acquereur_adr_num_voie'] = false;
        }
        if ($val['dia_acquereur_adr_ext'] == 1 || $val['dia_acquereur_adr_ext'] == "t" || $val['dia_acquereur_adr_ext'] == "Oui") {
            $this->valF['dia_acquereur_adr_ext'] = true;
        } else {
            $this->valF['dia_acquereur_adr_ext'] = false;
        }
        if ($val['dia_acquereur_adr_type_voie'] == 1 || $val['dia_acquereur_adr_type_voie'] == "t" || $val['dia_acquereur_adr_type_voie'] == "Oui") {
            $this->valF['dia_acquereur_adr_type_voie'] = true;
        } else {
            $this->valF['dia_acquereur_adr_type_voie'] = false;
        }
        if ($val['dia_acquereur_adr_nom_voie'] == 1 || $val['dia_acquereur_adr_nom_voie'] == "t" || $val['dia_acquereur_adr_nom_voie'] == "Oui") {
            $this->valF['dia_acquereur_adr_nom_voie'] = true;
        } else {
            $this->valF['dia_acquereur_adr_nom_voie'] = false;
        }
        if ($val['dia_acquereur_adr_lieu_dit_bp'] == 1 || $val['dia_acquereur_adr_lieu_dit_bp'] == "t" || $val['dia_acquereur_adr_lieu_dit_bp'] == "Oui") {
            $this->valF['dia_acquereur_adr_lieu_dit_bp'] = true;
        } else {
            $this->valF['dia_acquereur_adr_lieu_dit_bp'] = false;
        }
        if ($val['dia_acquereur_adr_cp'] == 1 || $val['dia_acquereur_adr_cp'] == "t" || $val['dia_acquereur_adr_cp'] == "Oui") {
            $this->valF['dia_acquereur_adr_cp'] = true;
        } else {
            $this->valF['dia_acquereur_adr_cp'] = false;
        }
        if ($val['dia_acquereur_adr_localite'] == 1 || $val['dia_acquereur_adr_localite'] == "t" || $val['dia_acquereur_adr_localite'] == "Oui") {
            $this->valF['dia_acquereur_adr_localite'] = true;
        } else {
            $this->valF['dia_acquereur_adr_localite'] = false;
        }
        if ($val['dia_observation'] == 1 || $val['dia_observation'] == "t" || $val['dia_observation'] == "Oui") {
            $this->valF['dia_observation'] = true;
        } else {
            $this->valF['dia_observation'] = false;
        }
        if (!is_numeric($val['tab_surface2'])) {
            $this->valF['tab_surface2'] = NULL;
        } else {
            $this->valF['tab_surface2'] = $val['tab_surface2'];
        }
        if ($val['dia_occ_sol_su_terre'] == 1 || $val['dia_occ_sol_su_terre'] == "t" || $val['dia_occ_sol_su_terre'] == "Oui") {
            $this->valF['dia_occ_sol_su_terre'] = true;
        } else {
            $this->valF['dia_occ_sol_su_terre'] = false;
        }
        if ($val['dia_occ_sol_su_pres'] == 1 || $val['dia_occ_sol_su_pres'] == "t" || $val['dia_occ_sol_su_pres'] == "Oui") {
            $this->valF['dia_occ_sol_su_pres'] = true;
        } else {
            $this->valF['dia_occ_sol_su_pres'] = false;
        }
        if ($val['dia_occ_sol_su_verger'] == 1 || $val['dia_occ_sol_su_verger'] == "t" || $val['dia_occ_sol_su_verger'] == "Oui") {
            $this->valF['dia_occ_sol_su_verger'] = true;
        } else {
            $this->valF['dia_occ_sol_su_verger'] = false;
        }
        if ($val['dia_occ_sol_su_vigne'] == 1 || $val['dia_occ_sol_su_vigne'] == "t" || $val['dia_occ_sol_su_vigne'] == "Oui") {
            $this->valF['dia_occ_sol_su_vigne'] = true;
        } else {
            $this->valF['dia_occ_sol_su_vigne'] = false;
        }
        if ($val['dia_occ_sol_su_bois'] == 1 || $val['dia_occ_sol_su_bois'] == "t" || $val['dia_occ_sol_su_bois'] == "Oui") {
            $this->valF['dia_occ_sol_su_bois'] = true;
        } else {
            $this->valF['dia_occ_sol_su_bois'] = false;
        }
        if ($val['dia_occ_sol_su_lande'] == 1 || $val['dia_occ_sol_su_lande'] == "t" || $val['dia_occ_sol_su_lande'] == "Oui") {
            $this->valF['dia_occ_sol_su_lande'] = true;
        } else {
            $this->valF['dia_occ_sol_su_lande'] = false;
        }
        if ($val['dia_occ_sol_su_carriere'] == 1 || $val['dia_occ_sol_su_carriere'] == "t" || $val['dia_occ_sol_su_carriere'] == "Oui") {
            $this->valF['dia_occ_sol_su_carriere'] = true;
        } else {
            $this->valF['dia_occ_sol_su_carriere'] = false;
        }
        if ($val['dia_occ_sol_su_eau_cadastree'] == 1 || $val['dia_occ_sol_su_eau_cadastree'] == "t" || $val['dia_occ_sol_su_eau_cadastree'] == "Oui") {
            $this->valF['dia_occ_sol_su_eau_cadastree'] = true;
        } else {
            $this->valF['dia_occ_sol_su_eau_cadastree'] = false;
        }
        if ($val['dia_occ_sol_su_jardin'] == 1 || $val['dia_occ_sol_su_jardin'] == "t" || $val['dia_occ_sol_su_jardin'] == "Oui") {
            $this->valF['dia_occ_sol_su_jardin'] = true;
        } else {
            $this->valF['dia_occ_sol_su_jardin'] = false;
        }
        if ($val['dia_occ_sol_su_terr_batir'] == 1 || $val['dia_occ_sol_su_terr_batir'] == "t" || $val['dia_occ_sol_su_terr_batir'] == "Oui") {
            $this->valF['dia_occ_sol_su_terr_batir'] = true;
        } else {
            $this->valF['dia_occ_sol_su_terr_batir'] = false;
        }
        if ($val['dia_occ_sol_su_terr_agr'] == 1 || $val['dia_occ_sol_su_terr_agr'] == "t" || $val['dia_occ_sol_su_terr_agr'] == "Oui") {
            $this->valF['dia_occ_sol_su_terr_agr'] = true;
        } else {
            $this->valF['dia_occ_sol_su_terr_agr'] = false;
        }
        if ($val['dia_occ_sol_su_sol'] == 1 || $val['dia_occ_sol_su_sol'] == "t" || $val['dia_occ_sol_su_sol'] == "Oui") {
            $this->valF['dia_occ_sol_su_sol'] = true;
        } else {
            $this->valF['dia_occ_sol_su_sol'] = false;
        }
        if ($val['dia_bati_vend_tot'] == 1 || $val['dia_bati_vend_tot'] == "t" || $val['dia_bati_vend_tot'] == "Oui") {
            $this->valF['dia_bati_vend_tot'] = true;
        } else {
            $this->valF['dia_bati_vend_tot'] = false;
        }
        if ($val['dia_bati_vend_tot_txt'] == 1 || $val['dia_bati_vend_tot_txt'] == "t" || $val['dia_bati_vend_tot_txt'] == "Oui") {
            $this->valF['dia_bati_vend_tot_txt'] = true;
        } else {
            $this->valF['dia_bati_vend_tot_txt'] = false;
        }
        if ($val['dia_su_co_sol'] == 1 || $val['dia_su_co_sol'] == "t" || $val['dia_su_co_sol'] == "Oui") {
            $this->valF['dia_su_co_sol'] = true;
        } else {
            $this->valF['dia_su_co_sol'] = false;
        }
        if ($val['dia_su_util_hab'] == 1 || $val['dia_su_util_hab'] == "t" || $val['dia_su_util_hab'] == "Oui") {
            $this->valF['dia_su_util_hab'] = true;
        } else {
            $this->valF['dia_su_util_hab'] = false;
        }
        if ($val['dia_nb_niv'] == 1 || $val['dia_nb_niv'] == "t" || $val['dia_nb_niv'] == "Oui") {
            $this->valF['dia_nb_niv'] = true;
        } else {
            $this->valF['dia_nb_niv'] = false;
        }
        if ($val['dia_nb_appart'] == 1 || $val['dia_nb_appart'] == "t" || $val['dia_nb_appart'] == "Oui") {
            $this->valF['dia_nb_appart'] = true;
        } else {
            $this->valF['dia_nb_appart'] = false;
        }
        if ($val['dia_nb_autre_loc'] == 1 || $val['dia_nb_autre_loc'] == "t" || $val['dia_nb_autre_loc'] == "Oui") {
            $this->valF['dia_nb_autre_loc'] = true;
        } else {
            $this->valF['dia_nb_autre_loc'] = false;
        }
        if ($val['dia_vente_lot_volume'] == 1 || $val['dia_vente_lot_volume'] == "t" || $val['dia_vente_lot_volume'] == "Oui") {
            $this->valF['dia_vente_lot_volume'] = true;
        } else {
            $this->valF['dia_vente_lot_volume'] = false;
        }
        if ($val['dia_vente_lot_volume_txt'] == 1 || $val['dia_vente_lot_volume_txt'] == "t" || $val['dia_vente_lot_volume_txt'] == "Oui") {
            $this->valF['dia_vente_lot_volume_txt'] = true;
        } else {
            $this->valF['dia_vente_lot_volume_txt'] = false;
        }
        if ($val['dia_lot_nat_su'] == 1 || $val['dia_lot_nat_su'] == "t" || $val['dia_lot_nat_su'] == "Oui") {
            $this->valF['dia_lot_nat_su'] = true;
        } else {
            $this->valF['dia_lot_nat_su'] = false;
        }
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
        if ($val['dia_indivi_quote_part'] == 1 || $val['dia_indivi_quote_part'] == "t" || $val['dia_indivi_quote_part'] == "Oui") {
            $this->valF['dia_indivi_quote_part'] = true;
        } else {
            $this->valF['dia_indivi_quote_part'] = false;
        }
        if ($val['dia_design_societe'] == 1 || $val['dia_design_societe'] == "t" || $val['dia_design_societe'] == "Oui") {
            $this->valF['dia_design_societe'] = true;
        } else {
            $this->valF['dia_design_societe'] = false;
        }
        if ($val['dia_design_droit'] == 1 || $val['dia_design_droit'] == "t" || $val['dia_design_droit'] == "Oui") {
            $this->valF['dia_design_droit'] = true;
        } else {
            $this->valF['dia_design_droit'] = false;
        }
        if ($val['dia_droit_soc_nat'] == 1 || $val['dia_droit_soc_nat'] == "t" || $val['dia_droit_soc_nat'] == "Oui") {
            $this->valF['dia_droit_soc_nat'] = true;
        } else {
            $this->valF['dia_droit_soc_nat'] = false;
        }
        if ($val['dia_droit_soc_nb'] == 1 || $val['dia_droit_soc_nb'] == "t" || $val['dia_droit_soc_nb'] == "Oui") {
            $this->valF['dia_droit_soc_nb'] = true;
        } else {
            $this->valF['dia_droit_soc_nb'] = false;
        }
        if ($val['dia_droit_soc_num_part'] == 1 || $val['dia_droit_soc_num_part'] == "t" || $val['dia_droit_soc_num_part'] == "Oui") {
            $this->valF['dia_droit_soc_num_part'] = true;
        } else {
            $this->valF['dia_droit_soc_num_part'] = false;
        }
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
        if ($val['dia_droit_reel_perso_nat'] == 1 || $val['dia_droit_reel_perso_nat'] == "t" || $val['dia_droit_reel_perso_nat'] == "Oui") {
            $this->valF['dia_droit_reel_perso_nat'] = true;
        } else {
            $this->valF['dia_droit_reel_perso_nat'] = false;
        }
        if ($val['dia_droit_reel_perso_viag'] == 1 || $val['dia_droit_reel_perso_viag'] == "t" || $val['dia_droit_reel_perso_viag'] == "Oui") {
            $this->valF['dia_droit_reel_perso_viag'] = true;
        } else {
            $this->valF['dia_droit_reel_perso_viag'] = false;
        }
        if ($val['dia_mod_cess_adr'] == 1 || $val['dia_mod_cess_adr'] == "t" || $val['dia_mod_cess_adr'] == "Oui") {
            $this->valF['dia_mod_cess_adr'] = true;
        } else {
            $this->valF['dia_mod_cess_adr'] = false;
        }
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
        if ($val['dia_mod_cess_terme_prec'] == 1 || $val['dia_mod_cess_terme_prec'] == "t" || $val['dia_mod_cess_terme_prec'] == "Oui") {
            $this->valF['dia_mod_cess_terme_prec'] = true;
        } else {
            $this->valF['dia_mod_cess_terme_prec'] = false;
        }
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
        if ($val['dia_mod_cess_design_contr_alien'] == 1 || $val['dia_mod_cess_design_contr_alien'] == "t" || $val['dia_mod_cess_design_contr_alien'] == "Oui") {
            $this->valF['dia_mod_cess_design_contr_alien'] = true;
        } else {
            $this->valF['dia_mod_cess_design_contr_alien'] = false;
        }
        if ($val['dia_mod_cess_eval_contr'] == 1 || $val['dia_mod_cess_eval_contr'] == "t" || $val['dia_mod_cess_eval_contr'] == "Oui") {
            $this->valF['dia_mod_cess_eval_contr'] = true;
        } else {
            $this->valF['dia_mod_cess_eval_contr'] = false;
        }
        if ($val['dia_mod_cess_rente_viag'] == 1 || $val['dia_mod_cess_rente_viag'] == "t" || $val['dia_mod_cess_rente_viag'] == "Oui") {
            $this->valF['dia_mod_cess_rente_viag'] = true;
        } else {
            $this->valF['dia_mod_cess_rente_viag'] = false;
        }
        if ($val['dia_mod_cess_mnt_an'] == 1 || $val['dia_mod_cess_mnt_an'] == "t" || $val['dia_mod_cess_mnt_an'] == "Oui") {
            $this->valF['dia_mod_cess_mnt_an'] = true;
        } else {
            $this->valF['dia_mod_cess_mnt_an'] = false;
        }
        if ($val['dia_mod_cess_mnt_compt'] == 1 || $val['dia_mod_cess_mnt_compt'] == "t" || $val['dia_mod_cess_mnt_compt'] == "Oui") {
            $this->valF['dia_mod_cess_mnt_compt'] = true;
        } else {
            $this->valF['dia_mod_cess_mnt_compt'] = false;
        }
        if ($val['dia_mod_cess_bene_rente'] == 1 || $val['dia_mod_cess_bene_rente'] == "t" || $val['dia_mod_cess_bene_rente'] == "Oui") {
            $this->valF['dia_mod_cess_bene_rente'] = true;
        } else {
            $this->valF['dia_mod_cess_bene_rente'] = false;
        }
        if ($val['dia_mod_cess_droit_usa_hab'] == 1 || $val['dia_mod_cess_droit_usa_hab'] == "t" || $val['dia_mod_cess_droit_usa_hab'] == "Oui") {
            $this->valF['dia_mod_cess_droit_usa_hab'] = true;
        } else {
            $this->valF['dia_mod_cess_droit_usa_hab'] = false;
        }
        if ($val['dia_mod_cess_droit_usa_hab_prec'] == 1 || $val['dia_mod_cess_droit_usa_hab_prec'] == "t" || $val['dia_mod_cess_droit_usa_hab_prec'] == "Oui") {
            $this->valF['dia_mod_cess_droit_usa_hab_prec'] = true;
        } else {
            $this->valF['dia_mod_cess_droit_usa_hab_prec'] = false;
        }
        if ($val['dia_mod_cess_eval_usa_usufruit'] == 1 || $val['dia_mod_cess_eval_usa_usufruit'] == "t" || $val['dia_mod_cess_eval_usa_usufruit'] == "Oui") {
            $this->valF['dia_mod_cess_eval_usa_usufruit'] = true;
        } else {
            $this->valF['dia_mod_cess_eval_usa_usufruit'] = false;
        }
        if ($val['dia_mod_cess_vente_nue_prop'] == 1 || $val['dia_mod_cess_vente_nue_prop'] == "t" || $val['dia_mod_cess_vente_nue_prop'] == "Oui") {
            $this->valF['dia_mod_cess_vente_nue_prop'] = true;
        } else {
            $this->valF['dia_mod_cess_vente_nue_prop'] = false;
        }
        if ($val['dia_mod_cess_vente_nue_prop_prec'] == 1 || $val['dia_mod_cess_vente_nue_prop_prec'] == "t" || $val['dia_mod_cess_vente_nue_prop_prec'] == "Oui") {
            $this->valF['dia_mod_cess_vente_nue_prop_prec'] = true;
        } else {
            $this->valF['dia_mod_cess_vente_nue_prop_prec'] = false;
        }
        if ($val['dia_mod_cess_echange'] == 1 || $val['dia_mod_cess_echange'] == "t" || $val['dia_mod_cess_echange'] == "Oui") {
            $this->valF['dia_mod_cess_echange'] = true;
        } else {
            $this->valF['dia_mod_cess_echange'] = false;
        }
        if ($val['dia_mod_cess_design_bien_recus_ech'] == 1 || $val['dia_mod_cess_design_bien_recus_ech'] == "t" || $val['dia_mod_cess_design_bien_recus_ech'] == "Oui") {
            $this->valF['dia_mod_cess_design_bien_recus_ech'] = true;
        } else {
            $this->valF['dia_mod_cess_design_bien_recus_ech'] = false;
        }
        if ($val['dia_mod_cess_mnt_soulte'] == 1 || $val['dia_mod_cess_mnt_soulte'] == "t" || $val['dia_mod_cess_mnt_soulte'] == "Oui") {
            $this->valF['dia_mod_cess_mnt_soulte'] = true;
        } else {
            $this->valF['dia_mod_cess_mnt_soulte'] = false;
        }
        if ($val['dia_mod_cess_prop_contre_echan'] == 1 || $val['dia_mod_cess_prop_contre_echan'] == "t" || $val['dia_mod_cess_prop_contre_echan'] == "Oui") {
            $this->valF['dia_mod_cess_prop_contre_echan'] = true;
        } else {
            $this->valF['dia_mod_cess_prop_contre_echan'] = false;
        }
        if ($val['dia_mod_cess_apport_societe'] == 1 || $val['dia_mod_cess_apport_societe'] == "t" || $val['dia_mod_cess_apport_societe'] == "Oui") {
            $this->valF['dia_mod_cess_apport_societe'] = true;
        } else {
            $this->valF['dia_mod_cess_apport_societe'] = false;
        }
        if ($val['dia_mod_cess_bene'] == 1 || $val['dia_mod_cess_bene'] == "t" || $val['dia_mod_cess_bene'] == "Oui") {
            $this->valF['dia_mod_cess_bene'] = true;
        } else {
            $this->valF['dia_mod_cess_bene'] = false;
        }
        if ($val['dia_mod_cess_esti_bien'] == 1 || $val['dia_mod_cess_esti_bien'] == "t" || $val['dia_mod_cess_esti_bien'] == "Oui") {
            $this->valF['dia_mod_cess_esti_bien'] = true;
        } else {
            $this->valF['dia_mod_cess_esti_bien'] = false;
        }
        if ($val['dia_mod_cess_cess_terr_loc_co'] == 1 || $val['dia_mod_cess_cess_terr_loc_co'] == "t" || $val['dia_mod_cess_cess_terr_loc_co'] == "Oui") {
            $this->valF['dia_mod_cess_cess_terr_loc_co'] = true;
        } else {
            $this->valF['dia_mod_cess_cess_terr_loc_co'] = false;
        }
        if ($val['dia_mod_cess_esti_terr'] == 1 || $val['dia_mod_cess_esti_terr'] == "t" || $val['dia_mod_cess_esti_terr'] == "Oui") {
            $this->valF['dia_mod_cess_esti_terr'] = true;
        } else {
            $this->valF['dia_mod_cess_esti_terr'] = false;
        }
        if ($val['dia_mod_cess_esti_loc'] == 1 || $val['dia_mod_cess_esti_loc'] == "t" || $val['dia_mod_cess_esti_loc'] == "Oui") {
            $this->valF['dia_mod_cess_esti_loc'] = true;
        } else {
            $this->valF['dia_mod_cess_esti_loc'] = false;
        }
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
        if ($val['dia_mod_cess_adju_date_lieu'] == 1 || $val['dia_mod_cess_adju_date_lieu'] == "t" || $val['dia_mod_cess_adju_date_lieu'] == "Oui") {
            $this->valF['dia_mod_cess_adju_date_lieu'] = true;
        } else {
            $this->valF['dia_mod_cess_adju_date_lieu'] = false;
        }
        if ($val['dia_mod_cess_mnt_mise_prix'] == 1 || $val['dia_mod_cess_mnt_mise_prix'] == "t" || $val['dia_mod_cess_mnt_mise_prix'] == "Oui") {
            $this->valF['dia_mod_cess_mnt_mise_prix'] = true;
        } else {
            $this->valF['dia_mod_cess_mnt_mise_prix'] = false;
        }
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
        if ($val['dia_acquereur_prof'] == 1 || $val['dia_acquereur_prof'] == "t" || $val['dia_acquereur_prof'] == "Oui") {
            $this->valF['dia_acquereur_prof'] = true;
        } else {
            $this->valF['dia_acquereur_prof'] = false;
        }
        if ($val['dia_indic_compl_ope'] == 1 || $val['dia_indic_compl_ope'] == "t" || $val['dia_indic_compl_ope'] == "Oui") {
            $this->valF['dia_indic_compl_ope'] = true;
        } else {
            $this->valF['dia_indic_compl_ope'] = false;
        }
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
        if ($val['ctx_objet_recours'] == 1 || $val['ctx_objet_recours'] == "t" || $val['ctx_objet_recours'] == "Oui") {
            $this->valF['ctx_objet_recours'] = true;
        } else {
            $this->valF['ctx_objet_recours'] = false;
        }
        if ($val['ctx_moyen_souleve'] == 1 || $val['ctx_moyen_souleve'] == "t" || $val['ctx_moyen_souleve'] == "Oui") {
            $this->valF['ctx_moyen_souleve'] = true;
        } else {
            $this->valF['ctx_moyen_souleve'] = false;
        }
        if ($val['ctx_moyen_retenu_juge'] == 1 || $val['ctx_moyen_retenu_juge'] == "t" || $val['ctx_moyen_retenu_juge'] == "Oui") {
            $this->valF['ctx_moyen_retenu_juge'] = true;
        } else {
            $this->valF['ctx_moyen_retenu_juge'] = false;
        }
        if ($val['ctx_reference_sagace'] == 1 || $val['ctx_reference_sagace'] == "t" || $val['ctx_reference_sagace'] == "Oui") {
            $this->valF['ctx_reference_sagace'] = true;
        } else {
            $this->valF['ctx_reference_sagace'] = false;
        }
        if ($val['ctx_nature_travaux_infra_om_html'] == 1 || $val['ctx_nature_travaux_infra_om_html'] == "t" || $val['ctx_nature_travaux_infra_om_html'] == "Oui") {
            $this->valF['ctx_nature_travaux_infra_om_html'] = true;
        } else {
            $this->valF['ctx_nature_travaux_infra_om_html'] = false;
        }
        if ($val['ctx_synthese_nti'] == 1 || $val['ctx_synthese_nti'] == "t" || $val['ctx_synthese_nti'] == "Oui") {
            $this->valF['ctx_synthese_nti'] = true;
        } else {
            $this->valF['ctx_synthese_nti'] = false;
        }
        if ($val['ctx_article_non_resp_om_html'] == 1 || $val['ctx_article_non_resp_om_html'] == "t" || $val['ctx_article_non_resp_om_html'] == "Oui") {
            $this->valF['ctx_article_non_resp_om_html'] = true;
        } else {
            $this->valF['ctx_article_non_resp_om_html'] = false;
        }
        if ($val['ctx_synthese_anr'] == 1 || $val['ctx_synthese_anr'] == "t" || $val['ctx_synthese_anr'] == "Oui") {
            $this->valF['ctx_synthese_anr'] = true;
        } else {
            $this->valF['ctx_synthese_anr'] = false;
        }
        if ($val['ctx_reference_parquet'] == 1 || $val['ctx_reference_parquet'] == "t" || $val['ctx_reference_parquet'] == "Oui") {
            $this->valF['ctx_reference_parquet'] = true;
        } else {
            $this->valF['ctx_reference_parquet'] = false;
        }
        if ($val['ctx_element_taxation'] == 1 || $val['ctx_element_taxation'] == "t" || $val['ctx_element_taxation'] == "Oui") {
            $this->valF['ctx_element_taxation'] = true;
        } else {
            $this->valF['ctx_element_taxation'] = false;
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
        if ($val['ctx_reference_courrier'] == 1 || $val['ctx_reference_courrier'] == "t" || $val['ctx_reference_courrier'] == "Oui") {
            $this->valF['ctx_reference_courrier'] = true;
        } else {
            $this->valF['ctx_reference_courrier'] = false;
        }
        if ($val['ctx_date_audience'] == 1 || $val['ctx_date_audience'] == "t" || $val['ctx_date_audience'] == "Oui") {
            $this->valF['ctx_date_audience'] = true;
        } else {
            $this->valF['ctx_date_audience'] = false;
        }
        if ($val['ctx_date_ajournement'] == 1 || $val['ctx_date_ajournement'] == "t" || $val['ctx_date_ajournement'] == "Oui") {
            $this->valF['ctx_date_ajournement'] = true;
        } else {
            $this->valF['ctx_date_ajournement'] = false;
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
        if ($val['mtn_exo_ta_part_commu'] == 1 || $val['mtn_exo_ta_part_commu'] == "t" || $val['mtn_exo_ta_part_commu'] == "Oui") {
            $this->valF['mtn_exo_ta_part_commu'] = true;
        } else {
            $this->valF['mtn_exo_ta_part_commu'] = false;
        }
        if ($val['mtn_exo_ta_part_depart'] == 1 || $val['mtn_exo_ta_part_depart'] == "t" || $val['mtn_exo_ta_part_depart'] == "Oui") {
            $this->valF['mtn_exo_ta_part_depart'] = true;
        } else {
            $this->valF['mtn_exo_ta_part_depart'] = false;
        }
        if ($val['mtn_exo_ta_part_reg'] == 1 || $val['mtn_exo_ta_part_reg'] == "t" || $val['mtn_exo_ta_part_reg'] == "Oui") {
            $this->valF['mtn_exo_ta_part_reg'] = true;
        } else {
            $this->valF['mtn_exo_ta_part_reg'] = false;
        }
        if ($val['mtn_exo_rap'] == 1 || $val['mtn_exo_rap'] == "t" || $val['mtn_exo_rap'] == "Oui") {
            $this->valF['mtn_exo_rap'] = true;
        } else {
            $this->valF['mtn_exo_rap'] = false;
        }
        if ($val['dpc_type'] == 1 || $val['dpc_type'] == "t" || $val['dpc_type'] == "Oui") {
            $this->valF['dpc_type'] = true;
        } else {
            $this->valF['dpc_type'] = false;
        }
        if ($val['dpc_desc_actv_ex'] == 1 || $val['dpc_desc_actv_ex'] == "t" || $val['dpc_desc_actv_ex'] == "Oui") {
            $this->valF['dpc_desc_actv_ex'] = true;
        } else {
            $this->valF['dpc_desc_actv_ex'] = false;
        }
        if ($val['dpc_desc_ca'] == 1 || $val['dpc_desc_ca'] == "t" || $val['dpc_desc_ca'] == "Oui") {
            $this->valF['dpc_desc_ca'] = true;
        } else {
            $this->valF['dpc_desc_ca'] = false;
        }
        if ($val['dpc_desc_aut_prec'] == 1 || $val['dpc_desc_aut_prec'] == "t" || $val['dpc_desc_aut_prec'] == "Oui") {
            $this->valF['dpc_desc_aut_prec'] = true;
        } else {
            $this->valF['dpc_desc_aut_prec'] = false;
        }
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
        if ($val['dpc_desig_loc_ann_prec'] == 1 || $val['dpc_desig_loc_ann_prec'] == "t" || $val['dpc_desig_loc_ann_prec'] == "Oui") {
            $this->valF['dpc_desig_loc_ann_prec'] = true;
        } else {
            $this->valF['dpc_desig_loc_ann_prec'] = false;
        }
        if ($val['dpc_bail_comm_date'] == 1 || $val['dpc_bail_comm_date'] == "t" || $val['dpc_bail_comm_date'] == "Oui") {
            $this->valF['dpc_bail_comm_date'] = true;
        } else {
            $this->valF['dpc_bail_comm_date'] = false;
        }
        if ($val['dpc_bail_comm_loyer'] == 1 || $val['dpc_bail_comm_loyer'] == "t" || $val['dpc_bail_comm_loyer'] == "Oui") {
            $this->valF['dpc_bail_comm_loyer'] = true;
        } else {
            $this->valF['dpc_bail_comm_loyer'] = false;
        }
        if ($val['dpc_actv_acqu'] == 1 || $val['dpc_actv_acqu'] == "t" || $val['dpc_actv_acqu'] == "Oui") {
            $this->valF['dpc_actv_acqu'] = true;
        } else {
            $this->valF['dpc_actv_acqu'] = false;
        }
        if ($val['dpc_nb_sala_di'] == 1 || $val['dpc_nb_sala_di'] == "t" || $val['dpc_nb_sala_di'] == "Oui") {
            $this->valF['dpc_nb_sala_di'] = true;
        } else {
            $this->valF['dpc_nb_sala_di'] = false;
        }
        if ($val['dpc_nb_sala_dd'] == 1 || $val['dpc_nb_sala_dd'] == "t" || $val['dpc_nb_sala_dd'] == "Oui") {
            $this->valF['dpc_nb_sala_dd'] = true;
        } else {
            $this->valF['dpc_nb_sala_dd'] = false;
        }
        if ($val['dpc_nb_sala_tc'] == 1 || $val['dpc_nb_sala_tc'] == "t" || $val['dpc_nb_sala_tc'] == "Oui") {
            $this->valF['dpc_nb_sala_tc'] = true;
        } else {
            $this->valF['dpc_nb_sala_tc'] = false;
        }
        if ($val['dpc_nb_sala_tp'] == 1 || $val['dpc_nb_sala_tp'] == "t" || $val['dpc_nb_sala_tp'] == "Oui") {
            $this->valF['dpc_nb_sala_tp'] = true;
        } else {
            $this->valF['dpc_nb_sala_tp'] = false;
        }
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
        if ($val['dpc_moda_cess_prix'] == 1 || $val['dpc_moda_cess_prix'] == "t" || $val['dpc_moda_cess_prix'] == "Oui") {
            $this->valF['dpc_moda_cess_prix'] = true;
        } else {
            $this->valF['dpc_moda_cess_prix'] = false;
        }
        if ($val['dpc_moda_cess_adj_date'] == 1 || $val['dpc_moda_cess_adj_date'] == "t" || $val['dpc_moda_cess_adj_date'] == "Oui") {
            $this->valF['dpc_moda_cess_adj_date'] = true;
        } else {
            $this->valF['dpc_moda_cess_adj_date'] = false;
        }
        if ($val['dpc_moda_cess_adj_prec'] == 1 || $val['dpc_moda_cess_adj_prec'] == "t" || $val['dpc_moda_cess_adj_prec'] == "Oui") {
            $this->valF['dpc_moda_cess_adj_prec'] = true;
        } else {
            $this->valF['dpc_moda_cess_adj_prec'] = false;
        }
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
        if ($val['dpc_moda_cess_paie_terme_prec'] == 1 || $val['dpc_moda_cess_paie_terme_prec'] == "t" || $val['dpc_moda_cess_paie_terme_prec'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_terme_prec'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_terme_prec'] = false;
        }
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
        if ($val['dpc_moda_cess_paie_nat_desig_alien_prec'] == 1 || $val['dpc_moda_cess_paie_nat_desig_alien_prec'] == "t" || $val['dpc_moda_cess_paie_nat_desig_alien_prec'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_nat_desig_alien_prec'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_nat_desig_alien_prec'] = false;
        }
        if ($val['dpc_moda_cess_paie_nat_eval'] == 1 || $val['dpc_moda_cess_paie_nat_eval'] == "t" || $val['dpc_moda_cess_paie_nat_eval'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_nat_eval'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_nat_eval'] = false;
        }
        if ($val['dpc_moda_cess_paie_nat_eval_prec'] == 1 || $val['dpc_moda_cess_paie_nat_eval_prec'] == "t" || $val['dpc_moda_cess_paie_nat_eval_prec'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_nat_eval_prec'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_nat_eval_prec'] = false;
        }
        if ($val['dpc_moda_cess_paie_aut'] == 1 || $val['dpc_moda_cess_paie_aut'] == "t" || $val['dpc_moda_cess_paie_aut'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_aut'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_aut'] = false;
        }
        if ($val['dpc_moda_cess_paie_aut_prec'] == 1 || $val['dpc_moda_cess_paie_aut_prec'] == "t" || $val['dpc_moda_cess_paie_aut_prec'] == "Oui") {
            $this->valF['dpc_moda_cess_paie_aut_prec'] = true;
        } else {
            $this->valF['dpc_moda_cess_paie_aut_prec'] = false;
        }
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
        if ($val['dpc_obs'] == 1 || $val['dpc_obs'] == "t" || $val['dpc_obs'] == "Oui") {
            $this->valF['dpc_obs'] = true;
        } else {
            $this->valF['dpc_obs'] = false;
        }
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
        if ($val['ctx_reference_dsj'] == 1 || $val['ctx_reference_dsj'] == "t" || $val['ctx_reference_dsj'] == "Oui") {
            $this->valF['ctx_reference_dsj'] = true;
        } else {
            $this->valF['ctx_reference_dsj'] = false;
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
        if ($val['co_fin_autr'] == 1 || $val['co_fin_autr'] == "t" || $val['co_fin_autr'] == "Oui") {
            $this->valF['co_fin_autr'] = true;
        } else {
            $this->valF['co_fin_autr'] = false;
        }
        if ($val['dia_ss_date'] == 1 || $val['dia_ss_date'] == "t" || $val['dia_ss_date'] == "Oui") {
            $this->valF['dia_ss_date'] = true;
        } else {
            $this->valF['dia_ss_date'] = false;
        }
        if ($val['dia_ss_lieu'] == 1 || $val['dia_ss_lieu'] == "t" || $val['dia_ss_lieu'] == "Oui") {
            $this->valF['dia_ss_lieu'] = true;
        } else {
            $this->valF['dia_ss_lieu'] = false;
        }
        if ($val['enga_decla_lieu'] == 1 || $val['enga_decla_lieu'] == "t" || $val['enga_decla_lieu'] == "Oui") {
            $this->valF['enga_decla_lieu'] = true;
        } else {
            $this->valF['enga_decla_lieu'] = false;
        }
        if ($val['enga_decla_date'] == 1 || $val['enga_decla_date'] == "t" || $val['enga_decla_date'] == "Oui") {
            $this->valF['enga_decla_date'] = true;
        } else {
            $this->valF['enga_decla_date'] = false;
        }
        if ($val['co_archi_attest_honneur'] == 1 || $val['co_archi_attest_honneur'] == "t" || $val['co_archi_attest_honneur'] == "Oui") {
            $this->valF['co_archi_attest_honneur'] = true;
        } else {
            $this->valF['co_archi_attest_honneur'] = false;
        }
        if ($val['co_bat_niv_dessous_nb'] == 1 || $val['co_bat_niv_dessous_nb'] == "t" || $val['co_bat_niv_dessous_nb'] == "Oui") {
            $this->valF['co_bat_niv_dessous_nb'] = true;
        } else {
            $this->valF['co_bat_niv_dessous_nb'] = false;
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
        if ($val['tax_surf_tot_demo'] == 1 || $val['tax_surf_tot_demo'] == "t" || $val['tax_surf_tot_demo'] == "Oui") {
            $this->valF['tax_surf_tot_demo'] = true;
        } else {
            $this->valF['tax_surf_tot_demo'] = false;
        }
        if ($val['tax_surf_tax_demo'] == 1 || $val['tax_surf_tax_demo'] == "t" || $val['tax_surf_tax_demo'] == "Oui") {
            $this->valF['tax_surf_tax_demo'] = true;
        } else {
            $this->valF['tax_surf_tax_demo'] = false;
        }
        if ($val['tax_terrassement_arch'] == 1 || $val['tax_terrassement_arch'] == "t" || $val['tax_terrassement_arch'] == "Oui") {
            $this->valF['tax_terrassement_arch'] = true;
        } else {
            $this->valF['tax_terrassement_arch'] = false;
        }
        if ($val['tax_adresse_future_numero'] == 1 || $val['tax_adresse_future_numero'] == "t" || $val['tax_adresse_future_numero'] == "Oui") {
            $this->valF['tax_adresse_future_numero'] = true;
        } else {
            $this->valF['tax_adresse_future_numero'] = false;
        }
        if ($val['tax_adresse_future_voie'] == 1 || $val['tax_adresse_future_voie'] == "t" || $val['tax_adresse_future_voie'] == "Oui") {
            $this->valF['tax_adresse_future_voie'] = true;
        } else {
            $this->valF['tax_adresse_future_voie'] = false;
        }
        if ($val['tax_adresse_future_lieudit'] == 1 || $val['tax_adresse_future_lieudit'] == "t" || $val['tax_adresse_future_lieudit'] == "Oui") {
            $this->valF['tax_adresse_future_lieudit'] = true;
        } else {
            $this->valF['tax_adresse_future_lieudit'] = false;
        }
        if ($val['tax_adresse_future_localite'] == 1 || $val['tax_adresse_future_localite'] == "t" || $val['tax_adresse_future_localite'] == "Oui") {
            $this->valF['tax_adresse_future_localite'] = true;
        } else {
            $this->valF['tax_adresse_future_localite'] = false;
        }
        if ($val['tax_adresse_future_cp'] == 1 || $val['tax_adresse_future_cp'] == "t" || $val['tax_adresse_future_cp'] == "Oui") {
            $this->valF['tax_adresse_future_cp'] = true;
        } else {
            $this->valF['tax_adresse_future_cp'] = false;
        }
        if ($val['tax_adresse_future_bp'] == 1 || $val['tax_adresse_future_bp'] == "t" || $val['tax_adresse_future_bp'] == "Oui") {
            $this->valF['tax_adresse_future_bp'] = true;
        } else {
            $this->valF['tax_adresse_future_bp'] = false;
        }
        if ($val['tax_adresse_future_cedex'] == 1 || $val['tax_adresse_future_cedex'] == "t" || $val['tax_adresse_future_cedex'] == "Oui") {
            $this->valF['tax_adresse_future_cedex'] = true;
        } else {
            $this->valF['tax_adresse_future_cedex'] = false;
        }
        if ($val['tax_adresse_future_pays'] == 1 || $val['tax_adresse_future_pays'] == "t" || $val['tax_adresse_future_pays'] == "Oui") {
            $this->valF['tax_adresse_future_pays'] = true;
        } else {
            $this->valF['tax_adresse_future_pays'] = false;
        }
        if ($val['tax_adresse_future_division'] == 1 || $val['tax_adresse_future_division'] == "t" || $val['tax_adresse_future_division'] == "Oui") {
            $this->valF['tax_adresse_future_division'] = true;
        } else {
            $this->valF['tax_adresse_future_division'] = false;
        }
        if ($val['co_bat_projete'] == 1 || $val['co_bat_projete'] == "t" || $val['co_bat_projete'] == "Oui") {
            $this->valF['co_bat_projete'] = true;
        } else {
            $this->valF['co_bat_projete'] = false;
        }
        if ($val['co_bat_existant'] == 1 || $val['co_bat_existant'] == "t" || $val['co_bat_existant'] == "Oui") {
            $this->valF['co_bat_existant'] = true;
        } else {
            $this->valF['co_bat_existant'] = false;
        }
        if ($val['co_bat_nature'] == 1 || $val['co_bat_nature'] == "t" || $val['co_bat_nature'] == "Oui") {
            $this->valF['co_bat_nature'] = true;
        } else {
            $this->valF['co_bat_nature'] = false;
        }
        if ($val['terr_juri_titul_date'] == 1 || $val['terr_juri_titul_date'] == "t" || $val['terr_juri_titul_date'] == "Oui") {
            $this->valF['terr_juri_titul_date'] = true;
        } else {
            $this->valF['terr_juri_titul_date'] = false;
        }
        if ($val['co_autre_desc'] == 1 || $val['co_autre_desc'] == "t" || $val['co_autre_desc'] == "Oui") {
            $this->valF['co_autre_desc'] = true;
        } else {
            $this->valF['co_autre_desc'] = false;
        }
        if ($val['co_trx_autre'] == 1 || $val['co_trx_autre'] == "t" || $val['co_trx_autre'] == "Oui") {
            $this->valF['co_trx_autre'] = true;
        } else {
            $this->valF['co_trx_autre'] = false;
        }
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
        if ($val['erp_trvx_adap_numero'] == 1 || $val['erp_trvx_adap_numero'] == "t" || $val['erp_trvx_adap_numero'] == "Oui") {
            $this->valF['erp_trvx_adap_numero'] = true;
        } else {
            $this->valF['erp_trvx_adap_numero'] = false;
        }
        if ($val['erp_trvx_adap_valid'] == 1 || $val['erp_trvx_adap_valid'] == "t" || $val['erp_trvx_adap_valid'] == "Oui") {
            $this->valF['erp_trvx_adap_valid'] = true;
        } else {
            $this->valF['erp_trvx_adap_valid'] = false;
        }
        if ($val['erp_prod_dangereux'] == 1 || $val['erp_prod_dangereux'] == "t" || $val['erp_prod_dangereux'] == "Oui") {
            $this->valF['erp_prod_dangereux'] = true;
        } else {
            $this->valF['erp_prod_dangereux'] = false;
        }
        if ($val['co_trav_supp_dessus'] == 1 || $val['co_trav_supp_dessus'] == "t" || $val['co_trav_supp_dessus'] == "Oui") {
            $this->valF['co_trav_supp_dessus'] = true;
        } else {
            $this->valF['co_trav_supp_dessus'] = false;
        }
        if ($val['co_trav_supp_dessous'] == 1 || $val['co_trav_supp_dessous'] == "t" || $val['co_trav_supp_dessous'] == "Oui") {
            $this->valF['co_trav_supp_dessous'] = true;
        } else {
            $this->valF['co_trav_supp_dessous'] = false;
        }
        if ($val['tax_su_habit_abr_jard_pig_colom'] == 1 || $val['tax_su_habit_abr_jard_pig_colom'] == "t" || $val['tax_su_habit_abr_jard_pig_colom'] == "Oui") {
            $this->valF['tax_su_habit_abr_jard_pig_colom'] = true;
        } else {
            $this->valF['tax_su_habit_abr_jard_pig_colom'] = false;
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
        if ($val['x1p_precisions'] == 1 || $val['x1p_precisions'] == "t" || $val['x1p_precisions'] == "Oui") {
            $this->valF['x1p_precisions'] = true;
        } else {
            $this->valF['x1p_precisions'] = false;
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
        if ($val['s1na1_numero'] == 1 || $val['s1na1_numero'] == "t" || $val['s1na1_numero'] == "Oui") {
            $this->valF['s1na1_numero'] = true;
        } else {
            $this->valF['s1na1_numero'] = false;
        }
        if ($val['s1va1_voie'] == 1 || $val['s1va1_voie'] == "t" || $val['s1va1_voie'] == "Oui") {
            $this->valF['s1va1_voie'] = true;
        } else {
            $this->valF['s1va1_voie'] = false;
        }
        if ($val['s1wa1_lieudit'] == 1 || $val['s1wa1_lieudit'] == "t" || $val['s1wa1_lieudit'] == "Oui") {
            $this->valF['s1wa1_lieudit'] = true;
        } else {
            $this->valF['s1wa1_lieudit'] = false;
        }
        if ($val['s1la1_localite'] == 1 || $val['s1la1_localite'] == "t" || $val['s1la1_localite'] == "Oui") {
            $this->valF['s1la1_localite'] = true;
        } else {
            $this->valF['s1la1_localite'] = false;
        }
        if ($val['s1pa1_codepostal'] == 1 || $val['s1pa1_codepostal'] == "t" || $val['s1pa1_codepostal'] == "Oui") {
            $this->valF['s1pa1_codepostal'] = true;
        } else {
            $this->valF['s1pa1_codepostal'] = false;
        }
        if ($val['s1na2_numero'] == 1 || $val['s1na2_numero'] == "t" || $val['s1na2_numero'] == "Oui") {
            $this->valF['s1na2_numero'] = true;
        } else {
            $this->valF['s1na2_numero'] = false;
        }
        if ($val['s1va2_voie'] == 1 || $val['s1va2_voie'] == "t" || $val['s1va2_voie'] == "Oui") {
            $this->valF['s1va2_voie'] = true;
        } else {
            $this->valF['s1va2_voie'] = false;
        }
        if ($val['s1wa2_lieudit'] == 1 || $val['s1wa2_lieudit'] == "t" || $val['s1wa2_lieudit'] == "Oui") {
            $this->valF['s1wa2_lieudit'] = true;
        } else {
            $this->valF['s1wa2_lieudit'] = false;
        }
        if ($val['s1la2_localite'] == 1 || $val['s1la2_localite'] == "t" || $val['s1la2_localite'] == "Oui") {
            $this->valF['s1la2_localite'] = true;
        } else {
            $this->valF['s1la2_localite'] = false;
        }
        if ($val['s1pa2_codepostal'] == 1 || $val['s1pa2_codepostal'] == "t" || $val['s1pa2_codepostal'] == "Oui") {
            $this->valF['s1pa2_codepostal'] = true;
        } else {
            $this->valF['s1pa2_codepostal'] = false;
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
        if ($val['a4d_description'] == 1 || $val['a4d_description'] == "t" || $val['a4d_description'] == "Oui") {
            $this->valF['a4d_description'] = true;
        } else {
            $this->valF['a4d_description'] = false;
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
        if ($val['u3t_observations'] == 1 || $val['u3t_observations'] == "t" || $val['u3t_observations'] == "Oui") {
            $this->valF['u3t_observations'] = true;
        } else {
            $this->valF['u3t_observations'] = false;
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
        if ($val['u1q_voirieconcessionnaire'] == 1 || $val['u1q_voirieconcessionnaire'] == "t" || $val['u1q_voirieconcessionnaire'] == "Oui") {
            $this->valF['u1q_voirieconcessionnaire'] = true;
        } else {
            $this->valF['u1q_voirieconcessionnaire'] = false;
        }
        if ($val['u1b_voirieavant'] == 1 || $val['u1b_voirieavant'] == "t" || $val['u1b_voirieavant'] == "Oui") {
            $this->valF['u1b_voirieavant'] = true;
        } else {
            $this->valF['u1b_voirieavant'] = false;
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
        if ($val['u1e_eauconcessionnaire'] == 1 || $val['u1e_eauconcessionnaire'] == "t" || $val['u1e_eauconcessionnaire'] == "Oui") {
            $this->valF['u1e_eauconcessionnaire'] = true;
        } else {
            $this->valF['u1e_eauconcessionnaire'] = false;
        }
        if ($val['u1k_eauavant'] == 1 || $val['u1k_eauavant'] == "t" || $val['u1k_eauavant'] == "Oui") {
            $this->valF['u1k_eauavant'] = true;
        } else {
            $this->valF['u1k_eauavant'] = false;
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
        if ($val['u1l_assainissementconcessionnaire'] == 1 || $val['u1l_assainissementconcessionnaire'] == "t" || $val['u1l_assainissementconcessionnaire'] == "Oui") {
            $this->valF['u1l_assainissementconcessionnaire'] = true;
        } else {
            $this->valF['u1l_assainissementconcessionnaire'] = false;
        }
        if ($val['u1r_assainissementavant'] == 1 || $val['u1r_assainissementavant'] == "t" || $val['u1r_assainissementavant'] == "Oui") {
            $this->valF['u1r_assainissementavant'] = true;
        } else {
            $this->valF['u1r_assainissementavant'] = false;
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
        if ($val['u1m_electriciteconcessionnaire'] == 1 || $val['u1m_electriciteconcessionnaire'] == "t" || $val['u1m_electriciteconcessionnaire'] == "Oui") {
            $this->valF['u1m_electriciteconcessionnaire'] = true;
        } else {
            $this->valF['u1m_electriciteconcessionnaire'] = false;
        }
        if ($val['u1f_electriciteavant'] == 1 || $val['u1f_electriciteavant'] == "t" || $val['u1f_electriciteavant'] == "Oui") {
            $this->valF['u1f_electriciteavant'] = true;
        } else {
            $this->valF['u1f_electriciteavant'] = false;
        }
        if ($val['u2a_observations'] == 1 || $val['u2a_observations'] == "t" || $val['u2a_observations'] == "Oui") {
            $this->valF['u2a_observations'] = true;
        } else {
            $this->valF['u2a_observations'] = false;
        }
        if ($val['f1ts4_surftaxestation'] == 1 || $val['f1ts4_surftaxestation'] == "t" || $val['f1ts4_surftaxestation'] == "Oui") {
            $this->valF['f1ts4_surftaxestation'] = true;
        } else {
            $this->valF['f1ts4_surftaxestation'] = false;
        }
        if ($val['f1ut1_surfcree'] == 1 || $val['f1ut1_surfcree'] == "t" || $val['f1ut1_surfcree'] == "Oui") {
            $this->valF['f1ut1_surfcree'] = true;
        } else {
            $this->valF['f1ut1_surfcree'] = false;
        }
        if ($val['f9d_date'] == 1 || $val['f9d_date'] == "t" || $val['f9d_date'] == "Oui") {
            $this->valF['f9d_date'] = true;
        } else {
            $this->valF['f9d_date'] = false;
        }
        if ($val['f9n_nom'] == 1 || $val['f9n_nom'] == "t" || $val['f9n_nom'] == "Oui") {
            $this->valF['f9n_nom'] = true;
        } else {
            $this->valF['f9n_nom'] = false;
        }
        if ($val['dia_droit_reel_perso_grevant_bien_desc'] == 1 || $val['dia_droit_reel_perso_grevant_bien_desc'] == "t" || $val['dia_droit_reel_perso_grevant_bien_desc'] == "Oui") {
            $this->valF['dia_droit_reel_perso_grevant_bien_desc'] = true;
        } else {
            $this->valF['dia_droit_reel_perso_grevant_bien_desc'] = false;
        }
        if ($val['dia_mod_cess_paie_nat_desc'] == 1 || $val['dia_mod_cess_paie_nat_desc'] == "t" || $val['dia_mod_cess_paie_nat_desc'] == "Oui") {
            $this->valF['dia_mod_cess_paie_nat_desc'] = true;
        } else {
            $this->valF['dia_mod_cess_paie_nat_desc'] = false;
        }
        if ($val['dia_mod_cess_rente_viag_desc'] == 1 || $val['dia_mod_cess_rente_viag_desc'] == "t" || $val['dia_mod_cess_rente_viag_desc'] == "Oui") {
            $this->valF['dia_mod_cess_rente_viag_desc'] = true;
        } else {
            $this->valF['dia_mod_cess_rente_viag_desc'] = false;
        }
        if ($val['dia_mod_cess_echange_desc'] == 1 || $val['dia_mod_cess_echange_desc'] == "t" || $val['dia_mod_cess_echange_desc'] == "Oui") {
            $this->valF['dia_mod_cess_echange_desc'] = true;
        } else {
            $this->valF['dia_mod_cess_echange_desc'] = false;
        }
        if ($val['dia_mod_cess_apport_societe_desc'] == 1 || $val['dia_mod_cess_apport_societe_desc'] == "t" || $val['dia_mod_cess_apport_societe_desc'] == "Oui") {
            $this->valF['dia_mod_cess_apport_societe_desc'] = true;
        } else {
            $this->valF['dia_mod_cess_apport_societe_desc'] = false;
        }
        if ($val['dia_mod_cess_cess_terr_loc_co_desc'] == 1 || $val['dia_mod_cess_cess_terr_loc_co_desc'] == "t" || $val['dia_mod_cess_cess_terr_loc_co_desc'] == "Oui") {
            $this->valF['dia_mod_cess_cess_terr_loc_co_desc'] = true;
        } else {
            $this->valF['dia_mod_cess_cess_terr_loc_co_desc'] = false;
        }
        if ($val['dia_mod_cess_esti_imm_loca_desc'] == 1 || $val['dia_mod_cess_esti_imm_loca_desc'] == "t" || $val['dia_mod_cess_esti_imm_loca_desc'] == "Oui") {
            $this->valF['dia_mod_cess_esti_imm_loca_desc'] = true;
        } else {
            $this->valF['dia_mod_cess_esti_imm_loca_desc'] = false;
        }
        if ($val['dia_mod_cess_adju_obl_desc'] == 1 || $val['dia_mod_cess_adju_obl_desc'] == "t" || $val['dia_mod_cess_adju_obl_desc'] == "Oui") {
            $this->valF['dia_mod_cess_adju_obl_desc'] = true;
        } else {
            $this->valF['dia_mod_cess_adju_obl_desc'] = false;
        }
        if ($val['dia_mod_cess_adju_fin_indivi_desc'] == 1 || $val['dia_mod_cess_adju_fin_indivi_desc'] == "t" || $val['dia_mod_cess_adju_fin_indivi_desc'] == "Oui") {
            $this->valF['dia_mod_cess_adju_fin_indivi_desc'] = true;
        } else {
            $this->valF['dia_mod_cess_adju_fin_indivi_desc'] = false;
        }
        if ($val['dia_cadre_titul_droit_prempt'] == 1 || $val['dia_cadre_titul_droit_prempt'] == "t" || $val['dia_cadre_titul_droit_prempt'] == "Oui") {
            $this->valF['dia_cadre_titul_droit_prempt'] = true;
        } else {
            $this->valF['dia_cadre_titul_droit_prempt'] = false;
        }
        if ($val['dia_mairie_prix_moyen'] == 1 || $val['dia_mairie_prix_moyen'] == "t" || $val['dia_mairie_prix_moyen'] == "Oui") {
            $this->valF['dia_mairie_prix_moyen'] = true;
        } else {
            $this->valF['dia_mairie_prix_moyen'] = false;
        }
        if ($val['dia_propri_indivi'] == 1 || $val['dia_propri_indivi'] == "t" || $val['dia_propri_indivi'] == "Oui") {
            $this->valF['dia_propri_indivi'] = true;
        } else {
            $this->valF['dia_propri_indivi'] = false;
        }
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
        if ($val['dia_notif_dec_titul_adr_prop_desc'] == 1 || $val['dia_notif_dec_titul_adr_prop_desc'] == "t" || $val['dia_notif_dec_titul_adr_prop_desc'] == "Oui") {
            $this->valF['dia_notif_dec_titul_adr_prop_desc'] = true;
        } else {
            $this->valF['dia_notif_dec_titul_adr_prop_desc'] = false;
        }
        if ($val['dia_notif_dec_titul_adr_manda'] == 1 || $val['dia_notif_dec_titul_adr_manda'] == "t" || $val['dia_notif_dec_titul_adr_manda'] == "Oui") {
            $this->valF['dia_notif_dec_titul_adr_manda'] = true;
        } else {
            $this->valF['dia_notif_dec_titul_adr_manda'] = false;
        }
        if ($val['dia_notif_dec_titul_adr_manda_desc'] == 1 || $val['dia_notif_dec_titul_adr_manda_desc'] == "t" || $val['dia_notif_dec_titul_adr_manda_desc'] == "Oui") {
            $this->valF['dia_notif_dec_titul_adr_manda_desc'] = true;
        } else {
            $this->valF['dia_notif_dec_titul_adr_manda_desc'] = false;
        }
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
        if ($val['dia_mod_cess_commi_mnt'] == 1 || $val['dia_mod_cess_commi_mnt'] == "t" || $val['dia_mod_cess_commi_mnt'] == "Oui") {
            $this->valF['dia_mod_cess_commi_mnt'] = true;
        } else {
            $this->valF['dia_mod_cess_commi_mnt'] = false;
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
        if ($val['dia_mod_cess_prix_vente_num'] == 1 || $val['dia_mod_cess_prix_vente_num'] == "t" || $val['dia_mod_cess_prix_vente_num'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente_num'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente_num'] = false;
        }
        if ($val['dia_mod_cess_prix_vente_mob_num'] == 1 || $val['dia_mod_cess_prix_vente_mob_num'] == "t" || $val['dia_mod_cess_prix_vente_mob_num'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente_mob_num'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente_mob_num'] = false;
        }
        if ($val['dia_mod_cess_prix_vente_cheptel_num'] == 1 || $val['dia_mod_cess_prix_vente_cheptel_num'] == "t" || $val['dia_mod_cess_prix_vente_cheptel_num'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente_cheptel_num'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente_cheptel_num'] = false;
        }
        if ($val['dia_mod_cess_prix_vente_recol_num'] == 1 || $val['dia_mod_cess_prix_vente_recol_num'] == "t" || $val['dia_mod_cess_prix_vente_recol_num'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente_recol_num'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente_recol_num'] = false;
        }
        if ($val['dia_mod_cess_prix_vente_autre_num'] == 1 || $val['dia_mod_cess_prix_vente_autre_num'] == "t" || $val['dia_mod_cess_prix_vente_autre_num'] == "Oui") {
            $this->valF['dia_mod_cess_prix_vente_autre_num'] = true;
        } else {
            $this->valF['dia_mod_cess_prix_vente_autre_num'] = false;
        }
        if ($val['dia_su_co_sol_num'] == 1 || $val['dia_su_co_sol_num'] == "t" || $val['dia_su_co_sol_num'] == "Oui") {
            $this->valF['dia_su_co_sol_num'] = true;
        } else {
            $this->valF['dia_su_co_sol_num'] = false;
        }
        if ($val['dia_su_util_hab_num'] == 1 || $val['dia_su_util_hab_num'] == "t" || $val['dia_su_util_hab_num'] == "Oui") {
            $this->valF['dia_su_util_hab_num'] = true;
        } else {
            $this->valF['dia_su_util_hab_num'] = false;
        }
        if ($val['dia_mod_cess_mnt_an_num'] == 1 || $val['dia_mod_cess_mnt_an_num'] == "t" || $val['dia_mod_cess_mnt_an_num'] == "Oui") {
            $this->valF['dia_mod_cess_mnt_an_num'] = true;
        } else {
            $this->valF['dia_mod_cess_mnt_an_num'] = false;
        }
        if ($val['dia_mod_cess_mnt_compt_num'] == 1 || $val['dia_mod_cess_mnt_compt_num'] == "t" || $val['dia_mod_cess_mnt_compt_num'] == "Oui") {
            $this->valF['dia_mod_cess_mnt_compt_num'] = true;
        } else {
            $this->valF['dia_mod_cess_mnt_compt_num'] = false;
        }
        if ($val['dia_mod_cess_mnt_soulte_num'] == 1 || $val['dia_mod_cess_mnt_soulte_num'] == "t" || $val['dia_mod_cess_mnt_soulte_num'] == "Oui") {
            $this->valF['dia_mod_cess_mnt_soulte_num'] = true;
        } else {
            $this->valF['dia_mod_cess_mnt_soulte_num'] = false;
        }
        if ($val['dia_comp_prix_vente'] == 1 || $val['dia_comp_prix_vente'] == "t" || $val['dia_comp_prix_vente'] == "Oui") {
            $this->valF['dia_comp_prix_vente'] = true;
        } else {
            $this->valF['dia_comp_prix_vente'] = false;
        }
        if ($val['dia_comp_surface'] == 1 || $val['dia_comp_surface'] == "t" || $val['dia_comp_surface'] == "Oui") {
            $this->valF['dia_comp_surface'] = true;
        } else {
            $this->valF['dia_comp_surface'] = false;
        }
        if ($val['dia_comp_total_frais'] == 1 || $val['dia_comp_total_frais'] == "t" || $val['dia_comp_total_frais'] == "Oui") {
            $this->valF['dia_comp_total_frais'] = true;
        } else {
            $this->valF['dia_comp_total_frais'] = false;
        }
        if ($val['dia_comp_mtn_total'] == 1 || $val['dia_comp_mtn_total'] == "t" || $val['dia_comp_mtn_total'] == "Oui") {
            $this->valF['dia_comp_mtn_total'] = true;
        } else {
            $this->valF['dia_comp_mtn_total'] = false;
        }
        if ($val['dia_comp_valeur_m2'] == 1 || $val['dia_comp_valeur_m2'] == "t" || $val['dia_comp_valeur_m2'] == "Oui") {
            $this->valF['dia_comp_valeur_m2'] = true;
        } else {
            $this->valF['dia_comp_valeur_m2'] = false;
        }
        if ($val['dia_esti_prix_france_dom'] == 1 || $val['dia_esti_prix_france_dom'] == "t" || $val['dia_esti_prix_france_dom'] == "Oui") {
            $this->valF['dia_esti_prix_france_dom'] = true;
        } else {
            $this->valF['dia_esti_prix_france_dom'] = false;
        }
        if ($val['dia_prop_collectivite'] == 1 || $val['dia_prop_collectivite'] == "t" || $val['dia_prop_collectivite'] == "Oui") {
            $this->valF['dia_prop_collectivite'] = true;
        } else {
            $this->valF['dia_prop_collectivite'] = false;
        }
        if ($val['dia_delegataire_denomination'] == 1 || $val['dia_delegataire_denomination'] == "t" || $val['dia_delegataire_denomination'] == "Oui") {
            $this->valF['dia_delegataire_denomination'] = true;
        } else {
            $this->valF['dia_delegataire_denomination'] = false;
        }
        if ($val['dia_delegataire_raison_sociale'] == 1 || $val['dia_delegataire_raison_sociale'] == "t" || $val['dia_delegataire_raison_sociale'] == "Oui") {
            $this->valF['dia_delegataire_raison_sociale'] = true;
        } else {
            $this->valF['dia_delegataire_raison_sociale'] = false;
        }
        if ($val['dia_delegataire_siret'] == 1 || $val['dia_delegataire_siret'] == "t" || $val['dia_delegataire_siret'] == "Oui") {
            $this->valF['dia_delegataire_siret'] = true;
        } else {
            $this->valF['dia_delegataire_siret'] = false;
        }
        if ($val['dia_delegataire_categorie_juridique'] == 1 || $val['dia_delegataire_categorie_juridique'] == "t" || $val['dia_delegataire_categorie_juridique'] == "Oui") {
            $this->valF['dia_delegataire_categorie_juridique'] = true;
        } else {
            $this->valF['dia_delegataire_categorie_juridique'] = false;
        }
        if ($val['dia_delegataire_representant_nom'] == 1 || $val['dia_delegataire_representant_nom'] == "t" || $val['dia_delegataire_representant_nom'] == "Oui") {
            $this->valF['dia_delegataire_representant_nom'] = true;
        } else {
            $this->valF['dia_delegataire_representant_nom'] = false;
        }
        if ($val['dia_delegataire_representant_prenom'] == 1 || $val['dia_delegataire_representant_prenom'] == "t" || $val['dia_delegataire_representant_prenom'] == "Oui") {
            $this->valF['dia_delegataire_representant_prenom'] = true;
        } else {
            $this->valF['dia_delegataire_representant_prenom'] = false;
        }
        if ($val['dia_delegataire_adresse_numero'] == 1 || $val['dia_delegataire_adresse_numero'] == "t" || $val['dia_delegataire_adresse_numero'] == "Oui") {
            $this->valF['dia_delegataire_adresse_numero'] = true;
        } else {
            $this->valF['dia_delegataire_adresse_numero'] = false;
        }
        if ($val['dia_delegataire_adresse_voie'] == 1 || $val['dia_delegataire_adresse_voie'] == "t" || $val['dia_delegataire_adresse_voie'] == "Oui") {
            $this->valF['dia_delegataire_adresse_voie'] = true;
        } else {
            $this->valF['dia_delegataire_adresse_voie'] = false;
        }
        if ($val['dia_delegataire_adresse_complement'] == 1 || $val['dia_delegataire_adresse_complement'] == "t" || $val['dia_delegataire_adresse_complement'] == "Oui") {
            $this->valF['dia_delegataire_adresse_complement'] = true;
        } else {
            $this->valF['dia_delegataire_adresse_complement'] = false;
        }
        if ($val['dia_delegataire_adresse_lieu_dit'] == 1 || $val['dia_delegataire_adresse_lieu_dit'] == "t" || $val['dia_delegataire_adresse_lieu_dit'] == "Oui") {
            $this->valF['dia_delegataire_adresse_lieu_dit'] = true;
        } else {
            $this->valF['dia_delegataire_adresse_lieu_dit'] = false;
        }
        if ($val['dia_delegataire_adresse_localite'] == 1 || $val['dia_delegataire_adresse_localite'] == "t" || $val['dia_delegataire_adresse_localite'] == "Oui") {
            $this->valF['dia_delegataire_adresse_localite'] = true;
        } else {
            $this->valF['dia_delegataire_adresse_localite'] = false;
        }
        if ($val['dia_delegataire_adresse_code_postal'] == 1 || $val['dia_delegataire_adresse_code_postal'] == "t" || $val['dia_delegataire_adresse_code_postal'] == "Oui") {
            $this->valF['dia_delegataire_adresse_code_postal'] = true;
        } else {
            $this->valF['dia_delegataire_adresse_code_postal'] = false;
        }
        if ($val['dia_delegataire_adresse_bp'] == 1 || $val['dia_delegataire_adresse_bp'] == "t" || $val['dia_delegataire_adresse_bp'] == "Oui") {
            $this->valF['dia_delegataire_adresse_bp'] = true;
        } else {
            $this->valF['dia_delegataire_adresse_bp'] = false;
        }
        if ($val['dia_delegataire_adresse_cedex'] == 1 || $val['dia_delegataire_adresse_cedex'] == "t" || $val['dia_delegataire_adresse_cedex'] == "Oui") {
            $this->valF['dia_delegataire_adresse_cedex'] = true;
        } else {
            $this->valF['dia_delegataire_adresse_cedex'] = false;
        }
        if ($val['dia_delegataire_adresse_pays'] == 1 || $val['dia_delegataire_adresse_pays'] == "t" || $val['dia_delegataire_adresse_pays'] == "Oui") {
            $this->valF['dia_delegataire_adresse_pays'] = true;
        } else {
            $this->valF['dia_delegataire_adresse_pays'] = false;
        }
        if ($val['dia_delegataire_telephone_fixe'] == 1 || $val['dia_delegataire_telephone_fixe'] == "t" || $val['dia_delegataire_telephone_fixe'] == "Oui") {
            $this->valF['dia_delegataire_telephone_fixe'] = true;
        } else {
            $this->valF['dia_delegataire_telephone_fixe'] = false;
        }
        if ($val['dia_delegataire_telephone_mobile'] == 1 || $val['dia_delegataire_telephone_mobile'] == "t" || $val['dia_delegataire_telephone_mobile'] == "Oui") {
            $this->valF['dia_delegataire_telephone_mobile'] = true;
        } else {
            $this->valF['dia_delegataire_telephone_mobile'] = false;
        }
        if ($val['dia_delegataire_telephone_mobile_indicatif'] == 1 || $val['dia_delegataire_telephone_mobile_indicatif'] == "t" || $val['dia_delegataire_telephone_mobile_indicatif'] == "Oui") {
            $this->valF['dia_delegataire_telephone_mobile_indicatif'] = true;
        } else {
            $this->valF['dia_delegataire_telephone_mobile_indicatif'] = false;
        }
        if ($val['dia_delegataire_courriel'] == 1 || $val['dia_delegataire_courriel'] == "t" || $val['dia_delegataire_courriel'] == "Oui") {
            $this->valF['dia_delegataire_courriel'] = true;
        } else {
            $this->valF['dia_delegataire_courriel'] = false;
        }
        if ($val['dia_delegataire_fax'] == 1 || $val['dia_delegataire_fax'] == "t" || $val['dia_delegataire_fax'] == "Oui") {
            $this->valF['dia_delegataire_fax'] = true;
        } else {
            $this->valF['dia_delegataire_fax'] = false;
        }
        if ($val['dia_entree_jouissance_type'] == 1 || $val['dia_entree_jouissance_type'] == "t" || $val['dia_entree_jouissance_type'] == "Oui") {
            $this->valF['dia_entree_jouissance_type'] = true;
        } else {
            $this->valF['dia_entree_jouissance_type'] = false;
        }
        if ($val['dia_entree_jouissance_date'] == 1 || $val['dia_entree_jouissance_date'] == "t" || $val['dia_entree_jouissance_date'] == "Oui") {
            $this->valF['dia_entree_jouissance_date'] = true;
        } else {
            $this->valF['dia_entree_jouissance_date'] = false;
        }
        if ($val['dia_entree_jouissance_date_effet'] == 1 || $val['dia_entree_jouissance_date_effet'] == "t" || $val['dia_entree_jouissance_date_effet'] == "Oui") {
            $this->valF['dia_entree_jouissance_date_effet'] = true;
        } else {
            $this->valF['dia_entree_jouissance_date_effet'] = false;
        }
        if ($val['dia_entree_jouissance_com'] == 1 || $val['dia_entree_jouissance_com'] == "t" || $val['dia_entree_jouissance_com'] == "Oui") {
            $this->valF['dia_entree_jouissance_com'] = true;
        } else {
            $this->valF['dia_entree_jouissance_com'] = false;
        }
        if ($val['dia_remise_bien_date_effet'] == 1 || $val['dia_remise_bien_date_effet'] == "t" || $val['dia_remise_bien_date_effet'] == "Oui") {
            $this->valF['dia_remise_bien_date_effet'] = true;
        } else {
            $this->valF['dia_remise_bien_date_effet'] = false;
        }
        if ($val['dia_remise_bien_com'] == 1 || $val['dia_remise_bien_com'] == "t" || $val['dia_remise_bien_com'] == "Oui") {
            $this->valF['dia_remise_bien_com'] = true;
        } else {
            $this->valF['dia_remise_bien_com'] = false;
        }
        if ($val['c2zp1_crete'] == 1 || $val['c2zp1_crete'] == "t" || $val['c2zp1_crete'] == "Oui") {
            $this->valF['c2zp1_crete'] = true;
        } else {
            $this->valF['c2zp1_crete'] = false;
        }
        if ($val['c2zr1_destination'] == 1 || $val['c2zr1_destination'] == "t" || $val['c2zr1_destination'] == "Oui") {
            $this->valF['c2zr1_destination'] = true;
        } else {
            $this->valF['c2zr1_destination'] = false;
        }
        if ($val['mh_design_appel_denom'] == 1 || $val['mh_design_appel_denom'] == "t" || $val['mh_design_appel_denom'] == "Oui") {
            $this->valF['mh_design_appel_denom'] = true;
        } else {
            $this->valF['mh_design_appel_denom'] = false;
        }
        if ($val['mh_design_type_protect'] == 1 || $val['mh_design_type_protect'] == "t" || $val['mh_design_type_protect'] == "Oui") {
            $this->valF['mh_design_type_protect'] = true;
        } else {
            $this->valF['mh_design_type_protect'] = false;
        }
        if ($val['mh_design_elem_prot'] == 1 || $val['mh_design_elem_prot'] == "t" || $val['mh_design_elem_prot'] == "Oui") {
            $this->valF['mh_design_elem_prot'] = true;
        } else {
            $this->valF['mh_design_elem_prot'] = false;
        }
        if ($val['mh_design_ref_merimee_palissy'] == 1 || $val['mh_design_ref_merimee_palissy'] == "t" || $val['mh_design_ref_merimee_palissy'] == "Oui") {
            $this->valF['mh_design_ref_merimee_palissy'] = true;
        } else {
            $this->valF['mh_design_ref_merimee_palissy'] = false;
        }
        if ($val['mh_design_nature_prop'] == 1 || $val['mh_design_nature_prop'] == "t" || $val['mh_design_nature_prop'] == "Oui") {
            $this->valF['mh_design_nature_prop'] = true;
        } else {
            $this->valF['mh_design_nature_prop'] = false;
        }
        if ($val['mh_loc_denom'] == 1 || $val['mh_loc_denom'] == "t" || $val['mh_loc_denom'] == "Oui") {
            $this->valF['mh_loc_denom'] = true;
        } else {
            $this->valF['mh_loc_denom'] = false;
        }
        if ($val['mh_pres_intitule'] == 1 || $val['mh_pres_intitule'] == "t" || $val['mh_pres_intitule'] == "Oui") {
            $this->valF['mh_pres_intitule'] = true;
        } else {
            $this->valF['mh_pres_intitule'] = false;
        }
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
        if ($val['mh_trav_cat_12_prec'] == 1 || $val['mh_trav_cat_12_prec'] == "t" || $val['mh_trav_cat_12_prec'] == "Oui") {
            $this->valF['mh_trav_cat_12_prec'] = true;
        } else {
            $this->valF['mh_trav_cat_12_prec'] = false;
        }
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
    /**
     * Methode verifier
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        // On appelle la methode de la classe parent
        parent::verifier($val, $this->f->db, null);

        // gestion des dates de validites
        $date_debut = $this->valF['om_validite_debut'];
        $date_fin = $this->valF['om_validite_fin'];

        if ($date_debut != '' and $date_fin != '') {
        
            $date_debut = explode('-', $this->valF['om_validite_debut']);
            $date_fin = explode('-', $this->valF['om_validite_fin']);

            $time_debut = mktime(0, 0, 0, $date_debut[1], $date_debut[2],
                                 $date_debut[0]);
            $time_fin = mktime(0, 0, 0, $date_fin[1], $date_fin[2],
                                 $date_fin[0]);

            if ($time_debut > $time_fin or $time_debut == $time_fin) {
                $this->correct = false;
                $this->addToMessage(__('La date de fin de validite doit etre future a la de debut de validite.'));
            }
        }
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
            $form->setType("cerfa", "hidden");
            $form->setType("libelle", "text");
            $form->setType("code", "text");
            if ($this->f->isAccredited(array($this->table."_modifier_validite", $this->table, ))) {
                $form->setType("om_validite_debut", "date");
            } else {
                $form->setType("om_validite_debut", "hiddenstaticdate");
            }
            if ($this->f->isAccredited(array($this->table."_modifier_validite", $this->table, ))) {
                $form->setType("om_validite_fin", "date");
            } else {
                $form->setType("om_validite_fin", "hiddenstaticdate");
            }
            $form->setType("am_lotiss", "checkbox");
            $form->setType("am_autre_div", "checkbox");
            $form->setType("am_camping", "checkbox");
            $form->setType("am_caravane", "checkbox");
            $form->setType("am_carav_duree", "checkbox");
            $form->setType("am_statio", "checkbox");
            $form->setType("am_statio_cont", "checkbox");
            $form->setType("am_affou_exhau", "checkbox");
            $form->setType("am_affou_exhau_sup", "checkbox");
            $form->setType("am_affou_prof", "checkbox");
            $form->setType("am_exhau_haut", "checkbox");
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
            $form->setType("am_projet_desc", "checkbox");
            $form->setType("am_terr_surf", "checkbox");
            $form->setType("am_tranche_desc", "checkbox");
            $form->setType("am_lot_max_nb", "checkbox");
            $form->setType("am_lot_max_shon", "checkbox");
            $form->setType("am_lot_cstr_cos", "checkbox");
            $form->setType("am_lot_cstr_plan", "checkbox");
            $form->setType("am_lot_cstr_vente", "checkbox");
            $form->setType("am_lot_fin_diff", "checkbox");
            $form->setType("am_lot_consign", "checkbox");
            $form->setType("am_lot_gar_achev", "checkbox");
            $form->setType("am_lot_vente_ant", "checkbox");
            $form->setType("am_empl_nb", "checkbox");
            $form->setType("am_tente_nb", "checkbox");
            $form->setType("am_carav_nb", "checkbox");
            $form->setType("am_mobil_nb", "checkbox");
            $form->setType("am_pers_nb", "checkbox");
            $form->setType("am_empl_hll_nb", "checkbox");
            $form->setType("am_hll_shon", "checkbox");
            $form->setType("am_periode_exploit", "checkbox");
            $form->setType("am_exist_agrand", "checkbox");
            $form->setType("am_exist_date", "checkbox");
            $form->setType("am_exist_num", "checkbox");
            $form->setType("am_exist_nb_avant", "checkbox");
            $form->setType("am_exist_nb_apres", "checkbox");
            $form->setType("am_coupe_bois", "checkbox");
            $form->setType("am_coupe_parc", "checkbox");
            $form->setType("am_coupe_align", "checkbox");
            $form->setType("am_coupe_ess", "checkbox");
            $form->setType("am_coupe_age", "checkbox");
            $form->setType("am_coupe_dens", "checkbox");
            $form->setType("am_coupe_qual", "checkbox");
            $form->setType("am_coupe_trait", "checkbox");
            $form->setType("am_coupe_autr", "checkbox");
            $form->setType("co_archi_recours", "checkbox");
            $form->setType("co_cstr_nouv", "checkbox");
            $form->setType("co_cstr_exist", "checkbox");
            $form->setType("co_cloture", "checkbox");
            $form->setType("co_elec_tension", "checkbox");
            $form->setType("co_div_terr", "checkbox");
            $form->setType("co_projet_desc", "checkbox");
            $form->setType("co_anx_pisc", "checkbox");
            $form->setType("co_anx_gara", "checkbox");
            $form->setType("co_anx_veran", "checkbox");
            $form->setType("co_anx_abri", "checkbox");
            $form->setType("co_anx_autr", "checkbox");
            $form->setType("co_anx_autr_desc", "checkbox");
            $form->setType("co_tot_log_nb", "checkbox");
            $form->setType("co_tot_ind_nb", "checkbox");
            $form->setType("co_tot_coll_nb", "checkbox");
            $form->setType("co_mais_piece_nb", "checkbox");
            $form->setType("co_mais_niv_nb", "checkbox");
            $form->setType("co_fin_lls_nb", "checkbox");
            $form->setType("co_fin_aa_nb", "checkbox");
            $form->setType("co_fin_ptz_nb", "checkbox");
            $form->setType("co_fin_autr_nb", "checkbox");
            $form->setType("co_fin_autr_desc", "checkbox");
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
            $form->setType("co_resid_autr_desc", "checkbox");
            $form->setType("co_foyer_chamb_nb", "checkbox");
            $form->setType("co_log_1p_nb", "checkbox");
            $form->setType("co_log_2p_nb", "checkbox");
            $form->setType("co_log_3p_nb", "checkbox");
            $form->setType("co_log_4p_nb", "checkbox");
            $form->setType("co_log_5p_nb", "checkbox");
            $form->setType("co_log_6p_nb", "checkbox");
            $form->setType("co_bat_niv_nb", "checkbox");
            $form->setType("co_trx_exten", "checkbox");
            $form->setType("co_trx_surelev", "checkbox");
            $form->setType("co_trx_nivsup", "checkbox");
            $form->setType("co_demont_periode", "checkbox");
            $form->setType("co_sp_transport", "checkbox");
            $form->setType("co_sp_enseign", "checkbox");
            $form->setType("co_sp_act_soc", "checkbox");
            $form->setType("co_sp_ouvr_spe", "checkbox");
            $form->setType("co_sp_sante", "checkbox");
            $form->setType("co_sp_culture", "checkbox");
            $form->setType("co_statio_avt_nb", "checkbox");
            $form->setType("co_statio_apr_nb", "checkbox");
            $form->setType("co_statio_adr", "checkbox");
            $form->setType("co_statio_place_nb", "checkbox");
            $form->setType("co_statio_tot_surf", "checkbox");
            $form->setType("co_statio_tot_shob", "checkbox");
            $form->setType("co_statio_comm_cin_surf", "checkbox");
            $form->setType("tab_surface", "text");
            $form->setType("dm_constr_dates", "checkbox");
            $form->setType("dm_total", "checkbox");
            $form->setType("dm_partiel", "checkbox");
            $form->setType("dm_projet_desc", "checkbox");
            $form->setType("dm_tot_log_nb", "checkbox");
            $form->setType("tax_surf_tot", "checkbox");
            $form->setType("tax_surf", "checkbox");
            $form->setType("tax_surf_suppr_mod", "checkbox");
            $form->setType("tab_tax_su_princ", "text");
            $form->setType("tab_tax_su_heber", "text");
            $form->setType("tab_tax_su_secon", "text");
            $form->setType("tab_tax_su_tot", "text");
            $form->setType("tax_ext_pret", "checkbox");
            $form->setType("tax_ext_desc", "checkbox");
            $form->setType("tax_surf_tax_exist_cons", "checkbox");
            $form->setType("tax_log_exist_nb", "checkbox");
            $form->setType("tax_trx_presc_ppr", "checkbox");
            $form->setType("tax_monu_hist", "checkbox");
            $form->setType("tax_comm_nb", "checkbox");
            $form->setType("tab_tax_su_non_habit_surf", "text");
            $form->setType("tab_tax_am", "text");
            $form->setType("vsd_surf_planch_smd", "checkbox");
            $form->setType("vsd_unit_fonc_sup", "checkbox");
            $form->setType("vsd_unit_fonc_constr_sup", "checkbox");
            $form->setType("vsd_val_terr", "checkbox");
            $form->setType("vsd_const_sxist_non_dem_surf", "checkbox");
            $form->setType("vsd_rescr_fisc", "checkbox");
            $form->setType("pld_val_terr", "checkbox");
            $form->setType("pld_const_exist_dem", "checkbox");
            $form->setType("pld_const_exist_dem_surf", "checkbox");
            $form->setType("code_cnil", "checkbox");
            $form->setType("terr_juri_titul", "checkbox");
            $form->setType("terr_juri_lot", "checkbox");
            $form->setType("terr_juri_zac", "checkbox");
            $form->setType("terr_juri_afu", "checkbox");
            $form->setType("terr_juri_pup", "checkbox");
            $form->setType("terr_juri_oin", "checkbox");
            $form->setType("terr_juri_desc", "checkbox");
            $form->setType("terr_div_surf_etab", "checkbox");
            $form->setType("terr_div_surf_av_div", "checkbox");
            $form->setType("doc_date", "checkbox");
            $form->setType("doc_tot_trav", "checkbox");
            $form->setType("doc_tranche_trav", "checkbox");
            $form->setType("doc_tranche_trav_desc", "checkbox");
            $form->setType("doc_surf", "checkbox");
            $form->setType("doc_nb_log", "checkbox");
            $form->setType("doc_nb_log_indiv", "checkbox");
            $form->setType("doc_nb_log_coll", "checkbox");
            $form->setType("doc_nb_log_lls", "checkbox");
            $form->setType("doc_nb_log_aa", "checkbox");
            $form->setType("doc_nb_log_ptz", "checkbox");
            $form->setType("doc_nb_log_autre", "checkbox");
            $form->setType("daact_date", "checkbox");
            $form->setType("daact_date_chgmt_dest", "checkbox");
            $form->setType("daact_tot_trav", "checkbox");
            $form->setType("daact_tranche_trav", "checkbox");
            $form->setType("daact_tranche_trav_desc", "checkbox");
            $form->setType("daact_surf", "checkbox");
            $form->setType("daact_nb_log", "checkbox");
            $form->setType("daact_nb_log_indiv", "checkbox");
            $form->setType("daact_nb_log_coll", "checkbox");
            $form->setType("daact_nb_log_lls", "checkbox");
            $form->setType("daact_nb_log_aa", "checkbox");
            $form->setType("daact_nb_log_ptz", "checkbox");
            $form->setType("daact_nb_log_autre", "checkbox");
            $form->setType("am_div_mun", "checkbox");
            $form->setType("co_perf_energ", "checkbox");
            $form->setType("architecte", "checkbox");
            $form->setType("co_statio_avt_shob", "checkbox");
            $form->setType("co_statio_apr_shob", "checkbox");
            $form->setType("co_statio_avt_surf", "checkbox");
            $form->setType("co_statio_apr_surf", "checkbox");
            $form->setType("co_trx_amgt", "checkbox");
            $form->setType("co_modif_aspect", "checkbox");
            $form->setType("co_modif_struct", "checkbox");
            $form->setType("co_ouvr_elec", "checkbox");
            $form->setType("co_ouvr_infra", "checkbox");
            $form->setType("co_trx_imm", "checkbox");
            $form->setType("co_cstr_shob", "checkbox");
            $form->setType("am_voyage_deb", "checkbox");
            $form->setType("am_voyage_fin", "checkbox");
            $form->setType("am_modif_amgt", "checkbox");
            $form->setType("am_lot_max_shob", "checkbox");
            $form->setType("mod_desc", "checkbox");
            $form->setType("tr_total", "checkbox");
            $form->setType("tr_partiel", "checkbox");
            $form->setType("tr_desc", "checkbox");
            $form->setType("avap_co_elt_pro", "checkbox");
            $form->setType("avap_nouv_haut_surf", "checkbox");
            $form->setType("avap_co_clot", "checkbox");
            $form->setType("avap_aut_coup_aba_arb", "checkbox");
            $form->setType("avap_ouv_infra", "checkbox");
            $form->setType("avap_aut_inst_mob", "checkbox");
            $form->setType("avap_aut_plant", "checkbox");
            $form->setType("avap_aut_auv_elec", "checkbox");
            $form->setType("tax_dest_loc_tr", "checkbox");
            $form->setType("ope_proj_desc", "checkbox");
            $form->setType("tax_surf_tot_cstr", "checkbox");
            $form->setType("tax_surf_loc_stat", "checkbox");
            $form->setType("tax_log_ap_trvx_nb", "checkbox");
            $form->setType("tax_am_statio_ext_cr", "checkbox");
            $form->setType("tax_sup_bass_pisc_cr", "checkbox");
            $form->setType("tax_empl_ten_carav_mobil_nb_cr", "checkbox");
            $form->setType("tax_empl_hll_nb_cr", "checkbox");
            $form->setType("tax_eol_haut_nb_cr", "checkbox");
            $form->setType("tax_pann_volt_sup_cr", "checkbox");
            $form->setType("tax_surf_loc_arch", "checkbox");
            $form->setType("tax_surf_pisc_arch", "checkbox");
            $form->setType("tax_am_statio_ext_arch", "checkbox");
            $form->setType("tab_tax_su_parc_statio_expl_comm", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb_arch", "checkbox");
            $form->setType("tax_empl_hll_nb_arch", "checkbox");
            $form->setType("tax_eol_haut_nb_arch", "checkbox");
            $form->setType("ope_proj_div_co", "checkbox");
            $form->setType("ope_proj_div_contr", "checkbox");
            $form->setType("tax_desc", "checkbox");
            $form->setType("erp_cstr_neuve", "checkbox");
            $form->setType("erp_trvx_acc", "checkbox");
            $form->setType("erp_extension", "checkbox");
            $form->setType("erp_rehab", "checkbox");
            $form->setType("erp_trvx_am", "checkbox");
            $form->setType("erp_vol_nouv_exist", "checkbox");
            $form->setType("tab_erp_eff", "text");
            $form->setType("erp_class_cat", "checkbox");
            $form->setType("erp_class_type", "checkbox");
            $form->setType("tax_surf_abr_jard_pig_colom", "checkbox");
            $form->setType("tax_su_non_habit_abr_jard_pig_colom", "checkbox");
            $form->setType("dia_imm_non_bati", "checkbox");
            $form->setType("dia_imm_bati_terr_propr", "checkbox");
            $form->setType("dia_imm_bati_terr_autr", "checkbox");
            $form->setType("dia_imm_bati_terr_autr_desc", "checkbox");
            $form->setType("dia_bat_copro", "checkbox");
            $form->setType("dia_bat_copro_desc", "checkbox");
            $form->setType("dia_lot_numero", "checkbox");
            $form->setType("dia_lot_bat", "checkbox");
            $form->setType("dia_lot_etage", "checkbox");
            $form->setType("dia_lot_quote_part", "checkbox");
            $form->setType("dia_us_hab", "checkbox");
            $form->setType("dia_us_pro", "checkbox");
            $form->setType("dia_us_mixte", "checkbox");
            $form->setType("dia_us_comm", "checkbox");
            $form->setType("dia_us_agr", "checkbox");
            $form->setType("dia_us_autre", "checkbox");
            $form->setType("dia_us_autre_prec", "checkbox");
            $form->setType("dia_occ_prop", "checkbox");
            $form->setType("dia_occ_loc", "checkbox");
            $form->setType("dia_occ_sans_occ", "checkbox");
            $form->setType("dia_occ_autre", "checkbox");
            $form->setType("dia_occ_autre_prec", "checkbox");
            $form->setType("dia_mod_cess_prix_vente", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_mob", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_cheptel", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_recol", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_autre", "checkbox");
            $form->setType("dia_mod_cess_commi", "checkbox");
            $form->setType("dia_mod_cess_commi_ttc", "checkbox");
            $form->setType("dia_mod_cess_commi_ht", "checkbox");
            $form->setType("dia_acquereur_nom_prenom", "checkbox");
            $form->setType("dia_acquereur_adr_num_voie", "checkbox");
            $form->setType("dia_acquereur_adr_ext", "checkbox");
            $form->setType("dia_acquereur_adr_type_voie", "checkbox");
            $form->setType("dia_acquereur_adr_nom_voie", "checkbox");
            $form->setType("dia_acquereur_adr_lieu_dit_bp", "checkbox");
            $form->setType("dia_acquereur_adr_cp", "checkbox");
            $form->setType("dia_acquereur_adr_localite", "checkbox");
            $form->setType("dia_observation", "checkbox");
            $form->setType("tab_surface2", "text");
            $form->setType("dia_occ_sol_su_terre", "checkbox");
            $form->setType("dia_occ_sol_su_pres", "checkbox");
            $form->setType("dia_occ_sol_su_verger", "checkbox");
            $form->setType("dia_occ_sol_su_vigne", "checkbox");
            $form->setType("dia_occ_sol_su_bois", "checkbox");
            $form->setType("dia_occ_sol_su_lande", "checkbox");
            $form->setType("dia_occ_sol_su_carriere", "checkbox");
            $form->setType("dia_occ_sol_su_eau_cadastree", "checkbox");
            $form->setType("dia_occ_sol_su_jardin", "checkbox");
            $form->setType("dia_occ_sol_su_terr_batir", "checkbox");
            $form->setType("dia_occ_sol_su_terr_agr", "checkbox");
            $form->setType("dia_occ_sol_su_sol", "checkbox");
            $form->setType("dia_bati_vend_tot", "checkbox");
            $form->setType("dia_bati_vend_tot_txt", "checkbox");
            $form->setType("dia_su_co_sol", "checkbox");
            $form->setType("dia_su_util_hab", "checkbox");
            $form->setType("dia_nb_niv", "checkbox");
            $form->setType("dia_nb_appart", "checkbox");
            $form->setType("dia_nb_autre_loc", "checkbox");
            $form->setType("dia_vente_lot_volume", "checkbox");
            $form->setType("dia_vente_lot_volume_txt", "checkbox");
            $form->setType("dia_lot_nat_su", "checkbox");
            $form->setType("dia_lot_bat_achv_plus_10", "checkbox");
            $form->setType("dia_lot_bat_achv_moins_10", "checkbox");
            $form->setType("dia_lot_regl_copro_publ_hypo_plus_10", "checkbox");
            $form->setType("dia_lot_regl_copro_publ_hypo_moins_10", "checkbox");
            $form->setType("dia_indivi_quote_part", "checkbox");
            $form->setType("dia_design_societe", "checkbox");
            $form->setType("dia_design_droit", "checkbox");
            $form->setType("dia_droit_soc_nat", "checkbox");
            $form->setType("dia_droit_soc_nb", "checkbox");
            $form->setType("dia_droit_soc_num_part", "checkbox");
            $form->setType("dia_droit_reel_perso_grevant_bien_oui", "checkbox");
            $form->setType("dia_droit_reel_perso_grevant_bien_non", "checkbox");
            $form->setType("dia_droit_reel_perso_nat", "checkbox");
            $form->setType("dia_droit_reel_perso_viag", "checkbox");
            $form->setType("dia_mod_cess_adr", "checkbox");
            $form->setType("dia_mod_cess_sign_act_auth", "checkbox");
            $form->setType("dia_mod_cess_terme", "checkbox");
            $form->setType("dia_mod_cess_terme_prec", "checkbox");
            $form->setType("dia_mod_cess_bene_acquereur", "checkbox");
            $form->setType("dia_mod_cess_bene_vendeur", "checkbox");
            $form->setType("dia_mod_cess_paie_nat", "checkbox");
            $form->setType("dia_mod_cess_design_contr_alien", "checkbox");
            $form->setType("dia_mod_cess_eval_contr", "checkbox");
            $form->setType("dia_mod_cess_rente_viag", "checkbox");
            $form->setType("dia_mod_cess_mnt_an", "checkbox");
            $form->setType("dia_mod_cess_mnt_compt", "checkbox");
            $form->setType("dia_mod_cess_bene_rente", "checkbox");
            $form->setType("dia_mod_cess_droit_usa_hab", "checkbox");
            $form->setType("dia_mod_cess_droit_usa_hab_prec", "checkbox");
            $form->setType("dia_mod_cess_eval_usa_usufruit", "checkbox");
            $form->setType("dia_mod_cess_vente_nue_prop", "checkbox");
            $form->setType("dia_mod_cess_vente_nue_prop_prec", "checkbox");
            $form->setType("dia_mod_cess_echange", "checkbox");
            $form->setType("dia_mod_cess_design_bien_recus_ech", "checkbox");
            $form->setType("dia_mod_cess_mnt_soulte", "checkbox");
            $form->setType("dia_mod_cess_prop_contre_echan", "checkbox");
            $form->setType("dia_mod_cess_apport_societe", "checkbox");
            $form->setType("dia_mod_cess_bene", "checkbox");
            $form->setType("dia_mod_cess_esti_bien", "checkbox");
            $form->setType("dia_mod_cess_cess_terr_loc_co", "checkbox");
            $form->setType("dia_mod_cess_esti_terr", "checkbox");
            $form->setType("dia_mod_cess_esti_loc", "checkbox");
            $form->setType("dia_mod_cess_esti_imm_loca", "checkbox");
            $form->setType("dia_mod_cess_adju_vol", "checkbox");
            $form->setType("dia_mod_cess_adju_obl", "checkbox");
            $form->setType("dia_mod_cess_adju_fin_indivi", "checkbox");
            $form->setType("dia_mod_cess_adju_date_lieu", "checkbox");
            $form->setType("dia_mod_cess_mnt_mise_prix", "checkbox");
            $form->setType("dia_prop_titu_prix_indique", "checkbox");
            $form->setType("dia_prop_recherche_acqu_prix_indique", "checkbox");
            $form->setType("dia_acquereur_prof", "checkbox");
            $form->setType("dia_indic_compl_ope", "checkbox");
            $form->setType("dia_vente_adju", "checkbox");
            $form->setType("am_terr_res_demon", "checkbox");
            $form->setType("am_air_terr_res_mob", "checkbox");
            $form->setType("ctx_objet_recours", "checkbox");
            $form->setType("ctx_moyen_souleve", "checkbox");
            $form->setType("ctx_moyen_retenu_juge", "checkbox");
            $form->setType("ctx_reference_sagace", "checkbox");
            $form->setType("ctx_nature_travaux_infra_om_html", "checkbox");
            $form->setType("ctx_synthese_nti", "checkbox");
            $form->setType("ctx_article_non_resp_om_html", "checkbox");
            $form->setType("ctx_synthese_anr", "checkbox");
            $form->setType("ctx_reference_parquet", "checkbox");
            $form->setType("ctx_element_taxation", "checkbox");
            $form->setType("ctx_infraction", "checkbox");
            $form->setType("ctx_regularisable", "checkbox");
            $form->setType("ctx_reference_courrier", "checkbox");
            $form->setType("ctx_date_audience", "checkbox");
            $form->setType("ctx_date_ajournement", "checkbox");
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
            $form->setType("mtn_exo_ta_part_commu", "checkbox");
            $form->setType("mtn_exo_ta_part_depart", "checkbox");
            $form->setType("mtn_exo_ta_part_reg", "checkbox");
            $form->setType("mtn_exo_rap", "checkbox");
            $form->setType("dpc_type", "checkbox");
            $form->setType("dpc_desc_actv_ex", "checkbox");
            $form->setType("dpc_desc_ca", "checkbox");
            $form->setType("dpc_desc_aut_prec", "checkbox");
            $form->setType("dpc_desig_comm_arti", "checkbox");
            $form->setType("dpc_desig_loc_hab", "checkbox");
            $form->setType("dpc_desig_loc_ann", "checkbox");
            $form->setType("dpc_desig_loc_ann_prec", "checkbox");
            $form->setType("dpc_bail_comm_date", "checkbox");
            $form->setType("dpc_bail_comm_loyer", "checkbox");
            $form->setType("dpc_actv_acqu", "checkbox");
            $form->setType("dpc_nb_sala_di", "checkbox");
            $form->setType("dpc_nb_sala_dd", "checkbox");
            $form->setType("dpc_nb_sala_tc", "checkbox");
            $form->setType("dpc_nb_sala_tp", "checkbox");
            $form->setType("dpc_moda_cess_vente_am", "checkbox");
            $form->setType("dpc_moda_cess_adj", "checkbox");
            $form->setType("dpc_moda_cess_prix", "checkbox");
            $form->setType("dpc_moda_cess_adj_date", "checkbox");
            $form->setType("dpc_moda_cess_adj_prec", "checkbox");
            $form->setType("dpc_moda_cess_paie_comp", "checkbox");
            $form->setType("dpc_moda_cess_paie_terme", "checkbox");
            $form->setType("dpc_moda_cess_paie_terme_prec", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien_prec", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_eval", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_eval_prec", "checkbox");
            $form->setType("dpc_moda_cess_paie_aut", "checkbox");
            $form->setType("dpc_moda_cess_paie_aut_prec", "checkbox");
            $form->setType("dpc_ss_signe_demande_acqu", "checkbox");
            $form->setType("dpc_ss_signe_recher_trouv_acqu", "checkbox");
            $form->setType("dpc_notif_adr_prop", "checkbox");
            $form->setType("dpc_notif_adr_manda", "checkbox");
            $form->setType("dpc_obs", "checkbox");
            $form->setType("co_peri_site_patri_remar", "checkbox");
            $form->setType("co_abo_monu_hist", "checkbox");
            $form->setType("co_inst_ouvr_trav_act_code_envir", "checkbox");
            $form->setType("co_trav_auto_env", "checkbox");
            $form->setType("co_derog_esp_prot", "checkbox");
            $form->setType("ctx_reference_dsj", "checkbox");
            $form->setType("co_piscine", "checkbox");
            $form->setType("co_fin_lls", "checkbox");
            $form->setType("co_fin_aa", "checkbox");
            $form->setType("co_fin_ptz", "checkbox");
            $form->setType("co_fin_autr", "checkbox");
            $form->setType("dia_ss_date", "checkbox");
            $form->setType("dia_ss_lieu", "checkbox");
            $form->setType("enga_decla_lieu", "checkbox");
            $form->setType("enga_decla_date", "checkbox");
            $form->setType("co_archi_attest_honneur", "checkbox");
            $form->setType("co_bat_niv_dessous_nb", "checkbox");
            $form->setType("co_install_classe", "checkbox");
            $form->setType("co_derog_innov", "checkbox");
            $form->setType("co_avis_abf", "checkbox");
            $form->setType("tax_surf_tot_demo", "checkbox");
            $form->setType("tax_surf_tax_demo", "checkbox");
            $form->setType("tax_terrassement_arch", "checkbox");
            $form->setType("tax_adresse_future_numero", "checkbox");
            $form->setType("tax_adresse_future_voie", "checkbox");
            $form->setType("tax_adresse_future_lieudit", "checkbox");
            $form->setType("tax_adresse_future_localite", "checkbox");
            $form->setType("tax_adresse_future_cp", "checkbox");
            $form->setType("tax_adresse_future_bp", "checkbox");
            $form->setType("tax_adresse_future_cedex", "checkbox");
            $form->setType("tax_adresse_future_pays", "checkbox");
            $form->setType("tax_adresse_future_division", "checkbox");
            $form->setType("co_bat_projete", "checkbox");
            $form->setType("co_bat_existant", "checkbox");
            $form->setType("co_bat_nature", "checkbox");
            $form->setType("terr_juri_titul_date", "checkbox");
            $form->setType("co_autre_desc", "checkbox");
            $form->setType("co_trx_autre", "checkbox");
            $form->setType("co_autre", "checkbox");
            $form->setType("erp_modif_facades", "checkbox");
            $form->setType("erp_trvx_adap", "checkbox");
            $form->setType("erp_trvx_adap_numero", "checkbox");
            $form->setType("erp_trvx_adap_valid", "checkbox");
            $form->setType("erp_prod_dangereux", "checkbox");
            $form->setType("co_trav_supp_dessus", "checkbox");
            $form->setType("co_trav_supp_dessous", "checkbox");
            $form->setType("tax_su_habit_abr_jard_pig_colom", "checkbox");
            $form->setType("enga_decla_donnees_nomi_comm", "checkbox");
            $form->setType("x1l_legislation", "checkbox");
            $form->setType("x1p_precisions", "checkbox");
            $form->setType("x1u_raccordement", "checkbox");
            $form->setType("x2m_inscritmh", "checkbox");
            $form->setType("s1na1_numero", "checkbox");
            $form->setType("s1va1_voie", "checkbox");
            $form->setType("s1wa1_lieudit", "checkbox");
            $form->setType("s1la1_localite", "checkbox");
            $form->setType("s1pa1_codepostal", "checkbox");
            $form->setType("s1na2_numero", "checkbox");
            $form->setType("s1va2_voie", "checkbox");
            $form->setType("s1wa2_lieudit", "checkbox");
            $form->setType("s1la2_localite", "checkbox");
            $form->setType("s1pa2_codepostal", "checkbox");
            $form->setType("e3c_certification", "checkbox");
            $form->setType("e3a_competence", "checkbox");
            $form->setType("a4d_description", "checkbox");
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
            $form->setType("u3t_observations", "checkbox");
            $form->setType("u1a_voirieoui", "checkbox");
            $form->setType("u1v_voirienon", "checkbox");
            $form->setType("u1q_voirieconcessionnaire", "checkbox");
            $form->setType("u1b_voirieavant", "checkbox");
            $form->setType("u1j_eauoui", "checkbox");
            $form->setType("u1t_eaunon", "checkbox");
            $form->setType("u1e_eauconcessionnaire", "checkbox");
            $form->setType("u1k_eauavant", "checkbox");
            $form->setType("u1s_assainissementoui", "checkbox");
            $form->setType("u1d_assainissementnon", "checkbox");
            $form->setType("u1l_assainissementconcessionnaire", "checkbox");
            $form->setType("u1r_assainissementavant", "checkbox");
            $form->setType("u1c_electriciteoui", "checkbox");
            $form->setType("u1u_electricitenon", "checkbox");
            $form->setType("u1m_electriciteconcessionnaire", "checkbox");
            $form->setType("u1f_electriciteavant", "checkbox");
            $form->setType("u2a_observations", "checkbox");
            $form->setType("f1ts4_surftaxestation", "checkbox");
            $form->setType("f1ut1_surfcree", "checkbox");
            $form->setType("f9d_date", "checkbox");
            $form->setType("f9n_nom", "checkbox");
            $form->setType("dia_droit_reel_perso_grevant_bien_desc", "checkbox");
            $form->setType("dia_mod_cess_paie_nat_desc", "checkbox");
            $form->setType("dia_mod_cess_rente_viag_desc", "checkbox");
            $form->setType("dia_mod_cess_echange_desc", "checkbox");
            $form->setType("dia_mod_cess_apport_societe_desc", "checkbox");
            $form->setType("dia_mod_cess_cess_terr_loc_co_desc", "checkbox");
            $form->setType("dia_mod_cess_esti_imm_loca_desc", "checkbox");
            $form->setType("dia_mod_cess_adju_obl_desc", "checkbox");
            $form->setType("dia_mod_cess_adju_fin_indivi_desc", "checkbox");
            $form->setType("dia_cadre_titul_droit_prempt", "checkbox");
            $form->setType("dia_mairie_prix_moyen", "checkbox");
            $form->setType("dia_propri_indivi", "checkbox");
            $form->setType("dia_situa_bien_plan_cadas_oui", "checkbox");
            $form->setType("dia_situa_bien_plan_cadas_non", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_prop", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_prop_desc", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_manda", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_manda_desc", "checkbox");
            $form->setType("dia_dia_dpu", "checkbox");
            $form->setType("dia_dia_zad", "checkbox");
            $form->setType("dia_dia_zone_preempt_esp_natu_sensi", "checkbox");
            $form->setType("dia_dab_dpu", "checkbox");
            $form->setType("dia_dab_zad", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt_ttc", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt_ht", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_num", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_mob_num", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_cheptel_num", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_recol_num", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_autre_num", "checkbox");
            $form->setType("dia_su_co_sol_num", "checkbox");
            $form->setType("dia_su_util_hab_num", "checkbox");
            $form->setType("dia_mod_cess_mnt_an_num", "checkbox");
            $form->setType("dia_mod_cess_mnt_compt_num", "checkbox");
            $form->setType("dia_mod_cess_mnt_soulte_num", "checkbox");
            $form->setType("dia_comp_prix_vente", "checkbox");
            $form->setType("dia_comp_surface", "checkbox");
            $form->setType("dia_comp_total_frais", "checkbox");
            $form->setType("dia_comp_mtn_total", "checkbox");
            $form->setType("dia_comp_valeur_m2", "checkbox");
            $form->setType("dia_esti_prix_france_dom", "checkbox");
            $form->setType("dia_prop_collectivite", "checkbox");
            $form->setType("dia_delegataire_denomination", "checkbox");
            $form->setType("dia_delegataire_raison_sociale", "checkbox");
            $form->setType("dia_delegataire_siret", "checkbox");
            $form->setType("dia_delegataire_categorie_juridique", "checkbox");
            $form->setType("dia_delegataire_representant_nom", "checkbox");
            $form->setType("dia_delegataire_representant_prenom", "checkbox");
            $form->setType("dia_delegataire_adresse_numero", "checkbox");
            $form->setType("dia_delegataire_adresse_voie", "checkbox");
            $form->setType("dia_delegataire_adresse_complement", "checkbox");
            $form->setType("dia_delegataire_adresse_lieu_dit", "checkbox");
            $form->setType("dia_delegataire_adresse_localite", "checkbox");
            $form->setType("dia_delegataire_adresse_code_postal", "checkbox");
            $form->setType("dia_delegataire_adresse_bp", "checkbox");
            $form->setType("dia_delegataire_adresse_cedex", "checkbox");
            $form->setType("dia_delegataire_adresse_pays", "checkbox");
            $form->setType("dia_delegataire_telephone_fixe", "checkbox");
            $form->setType("dia_delegataire_telephone_mobile", "checkbox");
            $form->setType("dia_delegataire_telephone_mobile_indicatif", "checkbox");
            $form->setType("dia_delegataire_courriel", "checkbox");
            $form->setType("dia_delegataire_fax", "checkbox");
            $form->setType("dia_entree_jouissance_type", "checkbox");
            $form->setType("dia_entree_jouissance_date", "checkbox");
            $form->setType("dia_entree_jouissance_date_effet", "checkbox");
            $form->setType("dia_entree_jouissance_com", "checkbox");
            $form->setType("dia_remise_bien_date_effet", "checkbox");
            $form->setType("dia_remise_bien_com", "checkbox");
            $form->setType("c2zp1_crete", "checkbox");
            $form->setType("c2zr1_destination", "checkbox");
            $form->setType("mh_design_appel_denom", "checkbox");
            $form->setType("mh_design_type_protect", "checkbox");
            $form->setType("mh_design_elem_prot", "checkbox");
            $form->setType("mh_design_ref_merimee_palissy", "checkbox");
            $form->setType("mh_design_nature_prop", "checkbox");
            $form->setType("mh_loc_denom", "checkbox");
            $form->setType("mh_pres_intitule", "checkbox");
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
            $form->setType("mh_trav_cat_12_prec", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("cerfa", "hiddenstatic");
            $form->setType("libelle", "text");
            $form->setType("code", "text");
            if ($this->f->isAccredited(array($this->table."_modifier_validite", $this->table, ))) {
                $form->setType("om_validite_debut", "date");
            } else {
                $form->setType("om_validite_debut", "hiddenstaticdate");
            }
            if ($this->f->isAccredited(array($this->table."_modifier_validite", $this->table, ))) {
                $form->setType("om_validite_fin", "date");
            } else {
                $form->setType("om_validite_fin", "hiddenstaticdate");
            }
            $form->setType("am_lotiss", "checkbox");
            $form->setType("am_autre_div", "checkbox");
            $form->setType("am_camping", "checkbox");
            $form->setType("am_caravane", "checkbox");
            $form->setType("am_carav_duree", "checkbox");
            $form->setType("am_statio", "checkbox");
            $form->setType("am_statio_cont", "checkbox");
            $form->setType("am_affou_exhau", "checkbox");
            $form->setType("am_affou_exhau_sup", "checkbox");
            $form->setType("am_affou_prof", "checkbox");
            $form->setType("am_exhau_haut", "checkbox");
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
            $form->setType("am_projet_desc", "checkbox");
            $form->setType("am_terr_surf", "checkbox");
            $form->setType("am_tranche_desc", "checkbox");
            $form->setType("am_lot_max_nb", "checkbox");
            $form->setType("am_lot_max_shon", "checkbox");
            $form->setType("am_lot_cstr_cos", "checkbox");
            $form->setType("am_lot_cstr_plan", "checkbox");
            $form->setType("am_lot_cstr_vente", "checkbox");
            $form->setType("am_lot_fin_diff", "checkbox");
            $form->setType("am_lot_consign", "checkbox");
            $form->setType("am_lot_gar_achev", "checkbox");
            $form->setType("am_lot_vente_ant", "checkbox");
            $form->setType("am_empl_nb", "checkbox");
            $form->setType("am_tente_nb", "checkbox");
            $form->setType("am_carav_nb", "checkbox");
            $form->setType("am_mobil_nb", "checkbox");
            $form->setType("am_pers_nb", "checkbox");
            $form->setType("am_empl_hll_nb", "checkbox");
            $form->setType("am_hll_shon", "checkbox");
            $form->setType("am_periode_exploit", "checkbox");
            $form->setType("am_exist_agrand", "checkbox");
            $form->setType("am_exist_date", "checkbox");
            $form->setType("am_exist_num", "checkbox");
            $form->setType("am_exist_nb_avant", "checkbox");
            $form->setType("am_exist_nb_apres", "checkbox");
            $form->setType("am_coupe_bois", "checkbox");
            $form->setType("am_coupe_parc", "checkbox");
            $form->setType("am_coupe_align", "checkbox");
            $form->setType("am_coupe_ess", "checkbox");
            $form->setType("am_coupe_age", "checkbox");
            $form->setType("am_coupe_dens", "checkbox");
            $form->setType("am_coupe_qual", "checkbox");
            $form->setType("am_coupe_trait", "checkbox");
            $form->setType("am_coupe_autr", "checkbox");
            $form->setType("co_archi_recours", "checkbox");
            $form->setType("co_cstr_nouv", "checkbox");
            $form->setType("co_cstr_exist", "checkbox");
            $form->setType("co_cloture", "checkbox");
            $form->setType("co_elec_tension", "checkbox");
            $form->setType("co_div_terr", "checkbox");
            $form->setType("co_projet_desc", "checkbox");
            $form->setType("co_anx_pisc", "checkbox");
            $form->setType("co_anx_gara", "checkbox");
            $form->setType("co_anx_veran", "checkbox");
            $form->setType("co_anx_abri", "checkbox");
            $form->setType("co_anx_autr", "checkbox");
            $form->setType("co_anx_autr_desc", "checkbox");
            $form->setType("co_tot_log_nb", "checkbox");
            $form->setType("co_tot_ind_nb", "checkbox");
            $form->setType("co_tot_coll_nb", "checkbox");
            $form->setType("co_mais_piece_nb", "checkbox");
            $form->setType("co_mais_niv_nb", "checkbox");
            $form->setType("co_fin_lls_nb", "checkbox");
            $form->setType("co_fin_aa_nb", "checkbox");
            $form->setType("co_fin_ptz_nb", "checkbox");
            $form->setType("co_fin_autr_nb", "checkbox");
            $form->setType("co_fin_autr_desc", "checkbox");
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
            $form->setType("co_resid_autr_desc", "checkbox");
            $form->setType("co_foyer_chamb_nb", "checkbox");
            $form->setType("co_log_1p_nb", "checkbox");
            $form->setType("co_log_2p_nb", "checkbox");
            $form->setType("co_log_3p_nb", "checkbox");
            $form->setType("co_log_4p_nb", "checkbox");
            $form->setType("co_log_5p_nb", "checkbox");
            $form->setType("co_log_6p_nb", "checkbox");
            $form->setType("co_bat_niv_nb", "checkbox");
            $form->setType("co_trx_exten", "checkbox");
            $form->setType("co_trx_surelev", "checkbox");
            $form->setType("co_trx_nivsup", "checkbox");
            $form->setType("co_demont_periode", "checkbox");
            $form->setType("co_sp_transport", "checkbox");
            $form->setType("co_sp_enseign", "checkbox");
            $form->setType("co_sp_act_soc", "checkbox");
            $form->setType("co_sp_ouvr_spe", "checkbox");
            $form->setType("co_sp_sante", "checkbox");
            $form->setType("co_sp_culture", "checkbox");
            $form->setType("co_statio_avt_nb", "checkbox");
            $form->setType("co_statio_apr_nb", "checkbox");
            $form->setType("co_statio_adr", "checkbox");
            $form->setType("co_statio_place_nb", "checkbox");
            $form->setType("co_statio_tot_surf", "checkbox");
            $form->setType("co_statio_tot_shob", "checkbox");
            $form->setType("co_statio_comm_cin_surf", "checkbox");
            $form->setType("tab_surface", "text");
            $form->setType("dm_constr_dates", "checkbox");
            $form->setType("dm_total", "checkbox");
            $form->setType("dm_partiel", "checkbox");
            $form->setType("dm_projet_desc", "checkbox");
            $form->setType("dm_tot_log_nb", "checkbox");
            $form->setType("tax_surf_tot", "checkbox");
            $form->setType("tax_surf", "checkbox");
            $form->setType("tax_surf_suppr_mod", "checkbox");
            $form->setType("tab_tax_su_princ", "text");
            $form->setType("tab_tax_su_heber", "text");
            $form->setType("tab_tax_su_secon", "text");
            $form->setType("tab_tax_su_tot", "text");
            $form->setType("tax_ext_pret", "checkbox");
            $form->setType("tax_ext_desc", "checkbox");
            $form->setType("tax_surf_tax_exist_cons", "checkbox");
            $form->setType("tax_log_exist_nb", "checkbox");
            $form->setType("tax_trx_presc_ppr", "checkbox");
            $form->setType("tax_monu_hist", "checkbox");
            $form->setType("tax_comm_nb", "checkbox");
            $form->setType("tab_tax_su_non_habit_surf", "text");
            $form->setType("tab_tax_am", "text");
            $form->setType("vsd_surf_planch_smd", "checkbox");
            $form->setType("vsd_unit_fonc_sup", "checkbox");
            $form->setType("vsd_unit_fonc_constr_sup", "checkbox");
            $form->setType("vsd_val_terr", "checkbox");
            $form->setType("vsd_const_sxist_non_dem_surf", "checkbox");
            $form->setType("vsd_rescr_fisc", "checkbox");
            $form->setType("pld_val_terr", "checkbox");
            $form->setType("pld_const_exist_dem", "checkbox");
            $form->setType("pld_const_exist_dem_surf", "checkbox");
            $form->setType("code_cnil", "checkbox");
            $form->setType("terr_juri_titul", "checkbox");
            $form->setType("terr_juri_lot", "checkbox");
            $form->setType("terr_juri_zac", "checkbox");
            $form->setType("terr_juri_afu", "checkbox");
            $form->setType("terr_juri_pup", "checkbox");
            $form->setType("terr_juri_oin", "checkbox");
            $form->setType("terr_juri_desc", "checkbox");
            $form->setType("terr_div_surf_etab", "checkbox");
            $form->setType("terr_div_surf_av_div", "checkbox");
            $form->setType("doc_date", "checkbox");
            $form->setType("doc_tot_trav", "checkbox");
            $form->setType("doc_tranche_trav", "checkbox");
            $form->setType("doc_tranche_trav_desc", "checkbox");
            $form->setType("doc_surf", "checkbox");
            $form->setType("doc_nb_log", "checkbox");
            $form->setType("doc_nb_log_indiv", "checkbox");
            $form->setType("doc_nb_log_coll", "checkbox");
            $form->setType("doc_nb_log_lls", "checkbox");
            $form->setType("doc_nb_log_aa", "checkbox");
            $form->setType("doc_nb_log_ptz", "checkbox");
            $form->setType("doc_nb_log_autre", "checkbox");
            $form->setType("daact_date", "checkbox");
            $form->setType("daact_date_chgmt_dest", "checkbox");
            $form->setType("daact_tot_trav", "checkbox");
            $form->setType("daact_tranche_trav", "checkbox");
            $form->setType("daact_tranche_trav_desc", "checkbox");
            $form->setType("daact_surf", "checkbox");
            $form->setType("daact_nb_log", "checkbox");
            $form->setType("daact_nb_log_indiv", "checkbox");
            $form->setType("daact_nb_log_coll", "checkbox");
            $form->setType("daact_nb_log_lls", "checkbox");
            $form->setType("daact_nb_log_aa", "checkbox");
            $form->setType("daact_nb_log_ptz", "checkbox");
            $form->setType("daact_nb_log_autre", "checkbox");
            $form->setType("am_div_mun", "checkbox");
            $form->setType("co_perf_energ", "checkbox");
            $form->setType("architecte", "checkbox");
            $form->setType("co_statio_avt_shob", "checkbox");
            $form->setType("co_statio_apr_shob", "checkbox");
            $form->setType("co_statio_avt_surf", "checkbox");
            $form->setType("co_statio_apr_surf", "checkbox");
            $form->setType("co_trx_amgt", "checkbox");
            $form->setType("co_modif_aspect", "checkbox");
            $form->setType("co_modif_struct", "checkbox");
            $form->setType("co_ouvr_elec", "checkbox");
            $form->setType("co_ouvr_infra", "checkbox");
            $form->setType("co_trx_imm", "checkbox");
            $form->setType("co_cstr_shob", "checkbox");
            $form->setType("am_voyage_deb", "checkbox");
            $form->setType("am_voyage_fin", "checkbox");
            $form->setType("am_modif_amgt", "checkbox");
            $form->setType("am_lot_max_shob", "checkbox");
            $form->setType("mod_desc", "checkbox");
            $form->setType("tr_total", "checkbox");
            $form->setType("tr_partiel", "checkbox");
            $form->setType("tr_desc", "checkbox");
            $form->setType("avap_co_elt_pro", "checkbox");
            $form->setType("avap_nouv_haut_surf", "checkbox");
            $form->setType("avap_co_clot", "checkbox");
            $form->setType("avap_aut_coup_aba_arb", "checkbox");
            $form->setType("avap_ouv_infra", "checkbox");
            $form->setType("avap_aut_inst_mob", "checkbox");
            $form->setType("avap_aut_plant", "checkbox");
            $form->setType("avap_aut_auv_elec", "checkbox");
            $form->setType("tax_dest_loc_tr", "checkbox");
            $form->setType("ope_proj_desc", "checkbox");
            $form->setType("tax_surf_tot_cstr", "checkbox");
            $form->setType("tax_surf_loc_stat", "checkbox");
            $form->setType("tax_log_ap_trvx_nb", "checkbox");
            $form->setType("tax_am_statio_ext_cr", "checkbox");
            $form->setType("tax_sup_bass_pisc_cr", "checkbox");
            $form->setType("tax_empl_ten_carav_mobil_nb_cr", "checkbox");
            $form->setType("tax_empl_hll_nb_cr", "checkbox");
            $form->setType("tax_eol_haut_nb_cr", "checkbox");
            $form->setType("tax_pann_volt_sup_cr", "checkbox");
            $form->setType("tax_surf_loc_arch", "checkbox");
            $form->setType("tax_surf_pisc_arch", "checkbox");
            $form->setType("tax_am_statio_ext_arch", "checkbox");
            $form->setType("tab_tax_su_parc_statio_expl_comm", "text");
            $form->setType("tax_empl_ten_carav_mobil_nb_arch", "checkbox");
            $form->setType("tax_empl_hll_nb_arch", "checkbox");
            $form->setType("tax_eol_haut_nb_arch", "checkbox");
            $form->setType("ope_proj_div_co", "checkbox");
            $form->setType("ope_proj_div_contr", "checkbox");
            $form->setType("tax_desc", "checkbox");
            $form->setType("erp_cstr_neuve", "checkbox");
            $form->setType("erp_trvx_acc", "checkbox");
            $form->setType("erp_extension", "checkbox");
            $form->setType("erp_rehab", "checkbox");
            $form->setType("erp_trvx_am", "checkbox");
            $form->setType("erp_vol_nouv_exist", "checkbox");
            $form->setType("tab_erp_eff", "text");
            $form->setType("erp_class_cat", "checkbox");
            $form->setType("erp_class_type", "checkbox");
            $form->setType("tax_surf_abr_jard_pig_colom", "checkbox");
            $form->setType("tax_su_non_habit_abr_jard_pig_colom", "checkbox");
            $form->setType("dia_imm_non_bati", "checkbox");
            $form->setType("dia_imm_bati_terr_propr", "checkbox");
            $form->setType("dia_imm_bati_terr_autr", "checkbox");
            $form->setType("dia_imm_bati_terr_autr_desc", "checkbox");
            $form->setType("dia_bat_copro", "checkbox");
            $form->setType("dia_bat_copro_desc", "checkbox");
            $form->setType("dia_lot_numero", "checkbox");
            $form->setType("dia_lot_bat", "checkbox");
            $form->setType("dia_lot_etage", "checkbox");
            $form->setType("dia_lot_quote_part", "checkbox");
            $form->setType("dia_us_hab", "checkbox");
            $form->setType("dia_us_pro", "checkbox");
            $form->setType("dia_us_mixte", "checkbox");
            $form->setType("dia_us_comm", "checkbox");
            $form->setType("dia_us_agr", "checkbox");
            $form->setType("dia_us_autre", "checkbox");
            $form->setType("dia_us_autre_prec", "checkbox");
            $form->setType("dia_occ_prop", "checkbox");
            $form->setType("dia_occ_loc", "checkbox");
            $form->setType("dia_occ_sans_occ", "checkbox");
            $form->setType("dia_occ_autre", "checkbox");
            $form->setType("dia_occ_autre_prec", "checkbox");
            $form->setType("dia_mod_cess_prix_vente", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_mob", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_cheptel", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_recol", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_autre", "checkbox");
            $form->setType("dia_mod_cess_commi", "checkbox");
            $form->setType("dia_mod_cess_commi_ttc", "checkbox");
            $form->setType("dia_mod_cess_commi_ht", "checkbox");
            $form->setType("dia_acquereur_nom_prenom", "checkbox");
            $form->setType("dia_acquereur_adr_num_voie", "checkbox");
            $form->setType("dia_acquereur_adr_ext", "checkbox");
            $form->setType("dia_acquereur_adr_type_voie", "checkbox");
            $form->setType("dia_acquereur_adr_nom_voie", "checkbox");
            $form->setType("dia_acquereur_adr_lieu_dit_bp", "checkbox");
            $form->setType("dia_acquereur_adr_cp", "checkbox");
            $form->setType("dia_acquereur_adr_localite", "checkbox");
            $form->setType("dia_observation", "checkbox");
            $form->setType("tab_surface2", "text");
            $form->setType("dia_occ_sol_su_terre", "checkbox");
            $form->setType("dia_occ_sol_su_pres", "checkbox");
            $form->setType("dia_occ_sol_su_verger", "checkbox");
            $form->setType("dia_occ_sol_su_vigne", "checkbox");
            $form->setType("dia_occ_sol_su_bois", "checkbox");
            $form->setType("dia_occ_sol_su_lande", "checkbox");
            $form->setType("dia_occ_sol_su_carriere", "checkbox");
            $form->setType("dia_occ_sol_su_eau_cadastree", "checkbox");
            $form->setType("dia_occ_sol_su_jardin", "checkbox");
            $form->setType("dia_occ_sol_su_terr_batir", "checkbox");
            $form->setType("dia_occ_sol_su_terr_agr", "checkbox");
            $form->setType("dia_occ_sol_su_sol", "checkbox");
            $form->setType("dia_bati_vend_tot", "checkbox");
            $form->setType("dia_bati_vend_tot_txt", "checkbox");
            $form->setType("dia_su_co_sol", "checkbox");
            $form->setType("dia_su_util_hab", "checkbox");
            $form->setType("dia_nb_niv", "checkbox");
            $form->setType("dia_nb_appart", "checkbox");
            $form->setType("dia_nb_autre_loc", "checkbox");
            $form->setType("dia_vente_lot_volume", "checkbox");
            $form->setType("dia_vente_lot_volume_txt", "checkbox");
            $form->setType("dia_lot_nat_su", "checkbox");
            $form->setType("dia_lot_bat_achv_plus_10", "checkbox");
            $form->setType("dia_lot_bat_achv_moins_10", "checkbox");
            $form->setType("dia_lot_regl_copro_publ_hypo_plus_10", "checkbox");
            $form->setType("dia_lot_regl_copro_publ_hypo_moins_10", "checkbox");
            $form->setType("dia_indivi_quote_part", "checkbox");
            $form->setType("dia_design_societe", "checkbox");
            $form->setType("dia_design_droit", "checkbox");
            $form->setType("dia_droit_soc_nat", "checkbox");
            $form->setType("dia_droit_soc_nb", "checkbox");
            $form->setType("dia_droit_soc_num_part", "checkbox");
            $form->setType("dia_droit_reel_perso_grevant_bien_oui", "checkbox");
            $form->setType("dia_droit_reel_perso_grevant_bien_non", "checkbox");
            $form->setType("dia_droit_reel_perso_nat", "checkbox");
            $form->setType("dia_droit_reel_perso_viag", "checkbox");
            $form->setType("dia_mod_cess_adr", "checkbox");
            $form->setType("dia_mod_cess_sign_act_auth", "checkbox");
            $form->setType("dia_mod_cess_terme", "checkbox");
            $form->setType("dia_mod_cess_terme_prec", "checkbox");
            $form->setType("dia_mod_cess_bene_acquereur", "checkbox");
            $form->setType("dia_mod_cess_bene_vendeur", "checkbox");
            $form->setType("dia_mod_cess_paie_nat", "checkbox");
            $form->setType("dia_mod_cess_design_contr_alien", "checkbox");
            $form->setType("dia_mod_cess_eval_contr", "checkbox");
            $form->setType("dia_mod_cess_rente_viag", "checkbox");
            $form->setType("dia_mod_cess_mnt_an", "checkbox");
            $form->setType("dia_mod_cess_mnt_compt", "checkbox");
            $form->setType("dia_mod_cess_bene_rente", "checkbox");
            $form->setType("dia_mod_cess_droit_usa_hab", "checkbox");
            $form->setType("dia_mod_cess_droit_usa_hab_prec", "checkbox");
            $form->setType("dia_mod_cess_eval_usa_usufruit", "checkbox");
            $form->setType("dia_mod_cess_vente_nue_prop", "checkbox");
            $form->setType("dia_mod_cess_vente_nue_prop_prec", "checkbox");
            $form->setType("dia_mod_cess_echange", "checkbox");
            $form->setType("dia_mod_cess_design_bien_recus_ech", "checkbox");
            $form->setType("dia_mod_cess_mnt_soulte", "checkbox");
            $form->setType("dia_mod_cess_prop_contre_echan", "checkbox");
            $form->setType("dia_mod_cess_apport_societe", "checkbox");
            $form->setType("dia_mod_cess_bene", "checkbox");
            $form->setType("dia_mod_cess_esti_bien", "checkbox");
            $form->setType("dia_mod_cess_cess_terr_loc_co", "checkbox");
            $form->setType("dia_mod_cess_esti_terr", "checkbox");
            $form->setType("dia_mod_cess_esti_loc", "checkbox");
            $form->setType("dia_mod_cess_esti_imm_loca", "checkbox");
            $form->setType("dia_mod_cess_adju_vol", "checkbox");
            $form->setType("dia_mod_cess_adju_obl", "checkbox");
            $form->setType("dia_mod_cess_adju_fin_indivi", "checkbox");
            $form->setType("dia_mod_cess_adju_date_lieu", "checkbox");
            $form->setType("dia_mod_cess_mnt_mise_prix", "checkbox");
            $form->setType("dia_prop_titu_prix_indique", "checkbox");
            $form->setType("dia_prop_recherche_acqu_prix_indique", "checkbox");
            $form->setType("dia_acquereur_prof", "checkbox");
            $form->setType("dia_indic_compl_ope", "checkbox");
            $form->setType("dia_vente_adju", "checkbox");
            $form->setType("am_terr_res_demon", "checkbox");
            $form->setType("am_air_terr_res_mob", "checkbox");
            $form->setType("ctx_objet_recours", "checkbox");
            $form->setType("ctx_moyen_souleve", "checkbox");
            $form->setType("ctx_moyen_retenu_juge", "checkbox");
            $form->setType("ctx_reference_sagace", "checkbox");
            $form->setType("ctx_nature_travaux_infra_om_html", "checkbox");
            $form->setType("ctx_synthese_nti", "checkbox");
            $form->setType("ctx_article_non_resp_om_html", "checkbox");
            $form->setType("ctx_synthese_anr", "checkbox");
            $form->setType("ctx_reference_parquet", "checkbox");
            $form->setType("ctx_element_taxation", "checkbox");
            $form->setType("ctx_infraction", "checkbox");
            $form->setType("ctx_regularisable", "checkbox");
            $form->setType("ctx_reference_courrier", "checkbox");
            $form->setType("ctx_date_audience", "checkbox");
            $form->setType("ctx_date_ajournement", "checkbox");
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
            $form->setType("mtn_exo_ta_part_commu", "checkbox");
            $form->setType("mtn_exo_ta_part_depart", "checkbox");
            $form->setType("mtn_exo_ta_part_reg", "checkbox");
            $form->setType("mtn_exo_rap", "checkbox");
            $form->setType("dpc_type", "checkbox");
            $form->setType("dpc_desc_actv_ex", "checkbox");
            $form->setType("dpc_desc_ca", "checkbox");
            $form->setType("dpc_desc_aut_prec", "checkbox");
            $form->setType("dpc_desig_comm_arti", "checkbox");
            $form->setType("dpc_desig_loc_hab", "checkbox");
            $form->setType("dpc_desig_loc_ann", "checkbox");
            $form->setType("dpc_desig_loc_ann_prec", "checkbox");
            $form->setType("dpc_bail_comm_date", "checkbox");
            $form->setType("dpc_bail_comm_loyer", "checkbox");
            $form->setType("dpc_actv_acqu", "checkbox");
            $form->setType("dpc_nb_sala_di", "checkbox");
            $form->setType("dpc_nb_sala_dd", "checkbox");
            $form->setType("dpc_nb_sala_tc", "checkbox");
            $form->setType("dpc_nb_sala_tp", "checkbox");
            $form->setType("dpc_moda_cess_vente_am", "checkbox");
            $form->setType("dpc_moda_cess_adj", "checkbox");
            $form->setType("dpc_moda_cess_prix", "checkbox");
            $form->setType("dpc_moda_cess_adj_date", "checkbox");
            $form->setType("dpc_moda_cess_adj_prec", "checkbox");
            $form->setType("dpc_moda_cess_paie_comp", "checkbox");
            $form->setType("dpc_moda_cess_paie_terme", "checkbox");
            $form->setType("dpc_moda_cess_paie_terme_prec", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien_prec", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_eval", "checkbox");
            $form->setType("dpc_moda_cess_paie_nat_eval_prec", "checkbox");
            $form->setType("dpc_moda_cess_paie_aut", "checkbox");
            $form->setType("dpc_moda_cess_paie_aut_prec", "checkbox");
            $form->setType("dpc_ss_signe_demande_acqu", "checkbox");
            $form->setType("dpc_ss_signe_recher_trouv_acqu", "checkbox");
            $form->setType("dpc_notif_adr_prop", "checkbox");
            $form->setType("dpc_notif_adr_manda", "checkbox");
            $form->setType("dpc_obs", "checkbox");
            $form->setType("co_peri_site_patri_remar", "checkbox");
            $form->setType("co_abo_monu_hist", "checkbox");
            $form->setType("co_inst_ouvr_trav_act_code_envir", "checkbox");
            $form->setType("co_trav_auto_env", "checkbox");
            $form->setType("co_derog_esp_prot", "checkbox");
            $form->setType("ctx_reference_dsj", "checkbox");
            $form->setType("co_piscine", "checkbox");
            $form->setType("co_fin_lls", "checkbox");
            $form->setType("co_fin_aa", "checkbox");
            $form->setType("co_fin_ptz", "checkbox");
            $form->setType("co_fin_autr", "checkbox");
            $form->setType("dia_ss_date", "checkbox");
            $form->setType("dia_ss_lieu", "checkbox");
            $form->setType("enga_decla_lieu", "checkbox");
            $form->setType("enga_decla_date", "checkbox");
            $form->setType("co_archi_attest_honneur", "checkbox");
            $form->setType("co_bat_niv_dessous_nb", "checkbox");
            $form->setType("co_install_classe", "checkbox");
            $form->setType("co_derog_innov", "checkbox");
            $form->setType("co_avis_abf", "checkbox");
            $form->setType("tax_surf_tot_demo", "checkbox");
            $form->setType("tax_surf_tax_demo", "checkbox");
            $form->setType("tax_terrassement_arch", "checkbox");
            $form->setType("tax_adresse_future_numero", "checkbox");
            $form->setType("tax_adresse_future_voie", "checkbox");
            $form->setType("tax_adresse_future_lieudit", "checkbox");
            $form->setType("tax_adresse_future_localite", "checkbox");
            $form->setType("tax_adresse_future_cp", "checkbox");
            $form->setType("tax_adresse_future_bp", "checkbox");
            $form->setType("tax_adresse_future_cedex", "checkbox");
            $form->setType("tax_adresse_future_pays", "checkbox");
            $form->setType("tax_adresse_future_division", "checkbox");
            $form->setType("co_bat_projete", "checkbox");
            $form->setType("co_bat_existant", "checkbox");
            $form->setType("co_bat_nature", "checkbox");
            $form->setType("terr_juri_titul_date", "checkbox");
            $form->setType("co_autre_desc", "checkbox");
            $form->setType("co_trx_autre", "checkbox");
            $form->setType("co_autre", "checkbox");
            $form->setType("erp_modif_facades", "checkbox");
            $form->setType("erp_trvx_adap", "checkbox");
            $form->setType("erp_trvx_adap_numero", "checkbox");
            $form->setType("erp_trvx_adap_valid", "checkbox");
            $form->setType("erp_prod_dangereux", "checkbox");
            $form->setType("co_trav_supp_dessus", "checkbox");
            $form->setType("co_trav_supp_dessous", "checkbox");
            $form->setType("tax_su_habit_abr_jard_pig_colom", "checkbox");
            $form->setType("enga_decla_donnees_nomi_comm", "checkbox");
            $form->setType("x1l_legislation", "checkbox");
            $form->setType("x1p_precisions", "checkbox");
            $form->setType("x1u_raccordement", "checkbox");
            $form->setType("x2m_inscritmh", "checkbox");
            $form->setType("s1na1_numero", "checkbox");
            $form->setType("s1va1_voie", "checkbox");
            $form->setType("s1wa1_lieudit", "checkbox");
            $form->setType("s1la1_localite", "checkbox");
            $form->setType("s1pa1_codepostal", "checkbox");
            $form->setType("s1na2_numero", "checkbox");
            $form->setType("s1va2_voie", "checkbox");
            $form->setType("s1wa2_lieudit", "checkbox");
            $form->setType("s1la2_localite", "checkbox");
            $form->setType("s1pa2_codepostal", "checkbox");
            $form->setType("e3c_certification", "checkbox");
            $form->setType("e3a_competence", "checkbox");
            $form->setType("a4d_description", "checkbox");
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
            $form->setType("u3t_observations", "checkbox");
            $form->setType("u1a_voirieoui", "checkbox");
            $form->setType("u1v_voirienon", "checkbox");
            $form->setType("u1q_voirieconcessionnaire", "checkbox");
            $form->setType("u1b_voirieavant", "checkbox");
            $form->setType("u1j_eauoui", "checkbox");
            $form->setType("u1t_eaunon", "checkbox");
            $form->setType("u1e_eauconcessionnaire", "checkbox");
            $form->setType("u1k_eauavant", "checkbox");
            $form->setType("u1s_assainissementoui", "checkbox");
            $form->setType("u1d_assainissementnon", "checkbox");
            $form->setType("u1l_assainissementconcessionnaire", "checkbox");
            $form->setType("u1r_assainissementavant", "checkbox");
            $form->setType("u1c_electriciteoui", "checkbox");
            $form->setType("u1u_electricitenon", "checkbox");
            $form->setType("u1m_electriciteconcessionnaire", "checkbox");
            $form->setType("u1f_electriciteavant", "checkbox");
            $form->setType("u2a_observations", "checkbox");
            $form->setType("f1ts4_surftaxestation", "checkbox");
            $form->setType("f1ut1_surfcree", "checkbox");
            $form->setType("f9d_date", "checkbox");
            $form->setType("f9n_nom", "checkbox");
            $form->setType("dia_droit_reel_perso_grevant_bien_desc", "checkbox");
            $form->setType("dia_mod_cess_paie_nat_desc", "checkbox");
            $form->setType("dia_mod_cess_rente_viag_desc", "checkbox");
            $form->setType("dia_mod_cess_echange_desc", "checkbox");
            $form->setType("dia_mod_cess_apport_societe_desc", "checkbox");
            $form->setType("dia_mod_cess_cess_terr_loc_co_desc", "checkbox");
            $form->setType("dia_mod_cess_esti_imm_loca_desc", "checkbox");
            $form->setType("dia_mod_cess_adju_obl_desc", "checkbox");
            $form->setType("dia_mod_cess_adju_fin_indivi_desc", "checkbox");
            $form->setType("dia_cadre_titul_droit_prempt", "checkbox");
            $form->setType("dia_mairie_prix_moyen", "checkbox");
            $form->setType("dia_propri_indivi", "checkbox");
            $form->setType("dia_situa_bien_plan_cadas_oui", "checkbox");
            $form->setType("dia_situa_bien_plan_cadas_non", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_prop", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_prop_desc", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_manda", "checkbox");
            $form->setType("dia_notif_dec_titul_adr_manda_desc", "checkbox");
            $form->setType("dia_dia_dpu", "checkbox");
            $form->setType("dia_dia_zad", "checkbox");
            $form->setType("dia_dia_zone_preempt_esp_natu_sensi", "checkbox");
            $form->setType("dia_dab_dpu", "checkbox");
            $form->setType("dia_dab_zad", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt_ttc", "checkbox");
            $form->setType("dia_mod_cess_commi_mnt_ht", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_num", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_mob_num", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_cheptel_num", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_recol_num", "checkbox");
            $form->setType("dia_mod_cess_prix_vente_autre_num", "checkbox");
            $form->setType("dia_su_co_sol_num", "checkbox");
            $form->setType("dia_su_util_hab_num", "checkbox");
            $form->setType("dia_mod_cess_mnt_an_num", "checkbox");
            $form->setType("dia_mod_cess_mnt_compt_num", "checkbox");
            $form->setType("dia_mod_cess_mnt_soulte_num", "checkbox");
            $form->setType("dia_comp_prix_vente", "checkbox");
            $form->setType("dia_comp_surface", "checkbox");
            $form->setType("dia_comp_total_frais", "checkbox");
            $form->setType("dia_comp_mtn_total", "checkbox");
            $form->setType("dia_comp_valeur_m2", "checkbox");
            $form->setType("dia_esti_prix_france_dom", "checkbox");
            $form->setType("dia_prop_collectivite", "checkbox");
            $form->setType("dia_delegataire_denomination", "checkbox");
            $form->setType("dia_delegataire_raison_sociale", "checkbox");
            $form->setType("dia_delegataire_siret", "checkbox");
            $form->setType("dia_delegataire_categorie_juridique", "checkbox");
            $form->setType("dia_delegataire_representant_nom", "checkbox");
            $form->setType("dia_delegataire_representant_prenom", "checkbox");
            $form->setType("dia_delegataire_adresse_numero", "checkbox");
            $form->setType("dia_delegataire_adresse_voie", "checkbox");
            $form->setType("dia_delegataire_adresse_complement", "checkbox");
            $form->setType("dia_delegataire_adresse_lieu_dit", "checkbox");
            $form->setType("dia_delegataire_adresse_localite", "checkbox");
            $form->setType("dia_delegataire_adresse_code_postal", "checkbox");
            $form->setType("dia_delegataire_adresse_bp", "checkbox");
            $form->setType("dia_delegataire_adresse_cedex", "checkbox");
            $form->setType("dia_delegataire_adresse_pays", "checkbox");
            $form->setType("dia_delegataire_telephone_fixe", "checkbox");
            $form->setType("dia_delegataire_telephone_mobile", "checkbox");
            $form->setType("dia_delegataire_telephone_mobile_indicatif", "checkbox");
            $form->setType("dia_delegataire_courriel", "checkbox");
            $form->setType("dia_delegataire_fax", "checkbox");
            $form->setType("dia_entree_jouissance_type", "checkbox");
            $form->setType("dia_entree_jouissance_date", "checkbox");
            $form->setType("dia_entree_jouissance_date_effet", "checkbox");
            $form->setType("dia_entree_jouissance_com", "checkbox");
            $form->setType("dia_remise_bien_date_effet", "checkbox");
            $form->setType("dia_remise_bien_com", "checkbox");
            $form->setType("c2zp1_crete", "checkbox");
            $form->setType("c2zr1_destination", "checkbox");
            $form->setType("mh_design_appel_denom", "checkbox");
            $form->setType("mh_design_type_protect", "checkbox");
            $form->setType("mh_design_elem_prot", "checkbox");
            $form->setType("mh_design_ref_merimee_palissy", "checkbox");
            $form->setType("mh_design_nature_prop", "checkbox");
            $form->setType("mh_loc_denom", "checkbox");
            $form->setType("mh_pres_intitule", "checkbox");
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
            $form->setType("mh_trav_cat_12_prec", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("cerfa", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("om_validite_debut", "hiddenstatic");
            $form->setType("om_validite_fin", "hiddenstatic");
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
            $form->setType("tab_surface", "hiddenstatic");
            $form->setType("dm_constr_dates", "hiddenstatic");
            $form->setType("dm_total", "hiddenstatic");
            $form->setType("dm_partiel", "hiddenstatic");
            $form->setType("dm_projet_desc", "hiddenstatic");
            $form->setType("dm_tot_log_nb", "hiddenstatic");
            $form->setType("tax_surf_tot", "hiddenstatic");
            $form->setType("tax_surf", "hiddenstatic");
            $form->setType("tax_surf_suppr_mod", "hiddenstatic");
            $form->setType("tab_tax_su_princ", "hiddenstatic");
            $form->setType("tab_tax_su_heber", "hiddenstatic");
            $form->setType("tab_tax_su_secon", "hiddenstatic");
            $form->setType("tab_tax_su_tot", "hiddenstatic");
            $form->setType("tax_ext_pret", "hiddenstatic");
            $form->setType("tax_ext_desc", "hiddenstatic");
            $form->setType("tax_surf_tax_exist_cons", "hiddenstatic");
            $form->setType("tax_log_exist_nb", "hiddenstatic");
            $form->setType("tax_trx_presc_ppr", "hiddenstatic");
            $form->setType("tax_monu_hist", "hiddenstatic");
            $form->setType("tax_comm_nb", "hiddenstatic");
            $form->setType("tab_tax_su_non_habit_surf", "hiddenstatic");
            $form->setType("tab_tax_am", "hiddenstatic");
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
            $form->setType("am_div_mun", "hiddenstatic");
            $form->setType("co_perf_energ", "hiddenstatic");
            $form->setType("architecte", "hiddenstatic");
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
            $form->setType("tax_surf_loc_stat", "hiddenstatic");
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
            $form->setType("tab_tax_su_parc_statio_expl_comm", "hiddenstatic");
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
            $form->setType("tab_erp_eff", "hiddenstatic");
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
            $form->setType("tab_surface2", "hiddenstatic");
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
            $form->setType("ctx_objet_recours", "hiddenstatic");
            $form->setType("ctx_moyen_souleve", "hiddenstatic");
            $form->setType("ctx_moyen_retenu_juge", "hiddenstatic");
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
            $form->setType("cerfa", "static");
            $form->setType("libelle", "static");
            $form->setType("code", "static");
            $form->setType("om_validite_debut", "datestatic");
            $form->setType("om_validite_fin", "datestatic");
            $form->setType("am_lotiss", "checkboxstatic");
            $form->setType("am_autre_div", "checkboxstatic");
            $form->setType("am_camping", "checkboxstatic");
            $form->setType("am_caravane", "checkboxstatic");
            $form->setType("am_carav_duree", "checkboxstatic");
            $form->setType("am_statio", "checkboxstatic");
            $form->setType("am_statio_cont", "checkboxstatic");
            $form->setType("am_affou_exhau", "checkboxstatic");
            $form->setType("am_affou_exhau_sup", "checkboxstatic");
            $form->setType("am_affou_prof", "checkboxstatic");
            $form->setType("am_exhau_haut", "checkboxstatic");
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
            $form->setType("am_projet_desc", "checkboxstatic");
            $form->setType("am_terr_surf", "checkboxstatic");
            $form->setType("am_tranche_desc", "checkboxstatic");
            $form->setType("am_lot_max_nb", "checkboxstatic");
            $form->setType("am_lot_max_shon", "checkboxstatic");
            $form->setType("am_lot_cstr_cos", "checkboxstatic");
            $form->setType("am_lot_cstr_plan", "checkboxstatic");
            $form->setType("am_lot_cstr_vente", "checkboxstatic");
            $form->setType("am_lot_fin_diff", "checkboxstatic");
            $form->setType("am_lot_consign", "checkboxstatic");
            $form->setType("am_lot_gar_achev", "checkboxstatic");
            $form->setType("am_lot_vente_ant", "checkboxstatic");
            $form->setType("am_empl_nb", "checkboxstatic");
            $form->setType("am_tente_nb", "checkboxstatic");
            $form->setType("am_carav_nb", "checkboxstatic");
            $form->setType("am_mobil_nb", "checkboxstatic");
            $form->setType("am_pers_nb", "checkboxstatic");
            $form->setType("am_empl_hll_nb", "checkboxstatic");
            $form->setType("am_hll_shon", "checkboxstatic");
            $form->setType("am_periode_exploit", "checkboxstatic");
            $form->setType("am_exist_agrand", "checkboxstatic");
            $form->setType("am_exist_date", "checkboxstatic");
            $form->setType("am_exist_num", "checkboxstatic");
            $form->setType("am_exist_nb_avant", "checkboxstatic");
            $form->setType("am_exist_nb_apres", "checkboxstatic");
            $form->setType("am_coupe_bois", "checkboxstatic");
            $form->setType("am_coupe_parc", "checkboxstatic");
            $form->setType("am_coupe_align", "checkboxstatic");
            $form->setType("am_coupe_ess", "checkboxstatic");
            $form->setType("am_coupe_age", "checkboxstatic");
            $form->setType("am_coupe_dens", "checkboxstatic");
            $form->setType("am_coupe_qual", "checkboxstatic");
            $form->setType("am_coupe_trait", "checkboxstatic");
            $form->setType("am_coupe_autr", "checkboxstatic");
            $form->setType("co_archi_recours", "checkboxstatic");
            $form->setType("co_cstr_nouv", "checkboxstatic");
            $form->setType("co_cstr_exist", "checkboxstatic");
            $form->setType("co_cloture", "checkboxstatic");
            $form->setType("co_elec_tension", "checkboxstatic");
            $form->setType("co_div_terr", "checkboxstatic");
            $form->setType("co_projet_desc", "checkboxstatic");
            $form->setType("co_anx_pisc", "checkboxstatic");
            $form->setType("co_anx_gara", "checkboxstatic");
            $form->setType("co_anx_veran", "checkboxstatic");
            $form->setType("co_anx_abri", "checkboxstatic");
            $form->setType("co_anx_autr", "checkboxstatic");
            $form->setType("co_anx_autr_desc", "checkboxstatic");
            $form->setType("co_tot_log_nb", "checkboxstatic");
            $form->setType("co_tot_ind_nb", "checkboxstatic");
            $form->setType("co_tot_coll_nb", "checkboxstatic");
            $form->setType("co_mais_piece_nb", "checkboxstatic");
            $form->setType("co_mais_niv_nb", "checkboxstatic");
            $form->setType("co_fin_lls_nb", "checkboxstatic");
            $form->setType("co_fin_aa_nb", "checkboxstatic");
            $form->setType("co_fin_ptz_nb", "checkboxstatic");
            $form->setType("co_fin_autr_nb", "checkboxstatic");
            $form->setType("co_fin_autr_desc", "checkboxstatic");
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
            $form->setType("co_resid_autr_desc", "checkboxstatic");
            $form->setType("co_foyer_chamb_nb", "checkboxstatic");
            $form->setType("co_log_1p_nb", "checkboxstatic");
            $form->setType("co_log_2p_nb", "checkboxstatic");
            $form->setType("co_log_3p_nb", "checkboxstatic");
            $form->setType("co_log_4p_nb", "checkboxstatic");
            $form->setType("co_log_5p_nb", "checkboxstatic");
            $form->setType("co_log_6p_nb", "checkboxstatic");
            $form->setType("co_bat_niv_nb", "checkboxstatic");
            $form->setType("co_trx_exten", "checkboxstatic");
            $form->setType("co_trx_surelev", "checkboxstatic");
            $form->setType("co_trx_nivsup", "checkboxstatic");
            $form->setType("co_demont_periode", "checkboxstatic");
            $form->setType("co_sp_transport", "checkboxstatic");
            $form->setType("co_sp_enseign", "checkboxstatic");
            $form->setType("co_sp_act_soc", "checkboxstatic");
            $form->setType("co_sp_ouvr_spe", "checkboxstatic");
            $form->setType("co_sp_sante", "checkboxstatic");
            $form->setType("co_sp_culture", "checkboxstatic");
            $form->setType("co_statio_avt_nb", "checkboxstatic");
            $form->setType("co_statio_apr_nb", "checkboxstatic");
            $form->setType("co_statio_adr", "checkboxstatic");
            $form->setType("co_statio_place_nb", "checkboxstatic");
            $form->setType("co_statio_tot_surf", "checkboxstatic");
            $form->setType("co_statio_tot_shob", "checkboxstatic");
            $form->setType("co_statio_comm_cin_surf", "checkboxstatic");
            $form->setType("tab_surface", "static");
            $form->setType("dm_constr_dates", "checkboxstatic");
            $form->setType("dm_total", "checkboxstatic");
            $form->setType("dm_partiel", "checkboxstatic");
            $form->setType("dm_projet_desc", "checkboxstatic");
            $form->setType("dm_tot_log_nb", "checkboxstatic");
            $form->setType("tax_surf_tot", "checkboxstatic");
            $form->setType("tax_surf", "checkboxstatic");
            $form->setType("tax_surf_suppr_mod", "checkboxstatic");
            $form->setType("tab_tax_su_princ", "static");
            $form->setType("tab_tax_su_heber", "static");
            $form->setType("tab_tax_su_secon", "static");
            $form->setType("tab_tax_su_tot", "static");
            $form->setType("tax_ext_pret", "checkboxstatic");
            $form->setType("tax_ext_desc", "checkboxstatic");
            $form->setType("tax_surf_tax_exist_cons", "checkboxstatic");
            $form->setType("tax_log_exist_nb", "checkboxstatic");
            $form->setType("tax_trx_presc_ppr", "checkboxstatic");
            $form->setType("tax_monu_hist", "checkboxstatic");
            $form->setType("tax_comm_nb", "checkboxstatic");
            $form->setType("tab_tax_su_non_habit_surf", "static");
            $form->setType("tab_tax_am", "static");
            $form->setType("vsd_surf_planch_smd", "checkboxstatic");
            $form->setType("vsd_unit_fonc_sup", "checkboxstatic");
            $form->setType("vsd_unit_fonc_constr_sup", "checkboxstatic");
            $form->setType("vsd_val_terr", "checkboxstatic");
            $form->setType("vsd_const_sxist_non_dem_surf", "checkboxstatic");
            $form->setType("vsd_rescr_fisc", "checkboxstatic");
            $form->setType("pld_val_terr", "checkboxstatic");
            $form->setType("pld_const_exist_dem", "checkboxstatic");
            $form->setType("pld_const_exist_dem_surf", "checkboxstatic");
            $form->setType("code_cnil", "checkboxstatic");
            $form->setType("terr_juri_titul", "checkboxstatic");
            $form->setType("terr_juri_lot", "checkboxstatic");
            $form->setType("terr_juri_zac", "checkboxstatic");
            $form->setType("terr_juri_afu", "checkboxstatic");
            $form->setType("terr_juri_pup", "checkboxstatic");
            $form->setType("terr_juri_oin", "checkboxstatic");
            $form->setType("terr_juri_desc", "checkboxstatic");
            $form->setType("terr_div_surf_etab", "checkboxstatic");
            $form->setType("terr_div_surf_av_div", "checkboxstatic");
            $form->setType("doc_date", "checkboxstatic");
            $form->setType("doc_tot_trav", "checkboxstatic");
            $form->setType("doc_tranche_trav", "checkboxstatic");
            $form->setType("doc_tranche_trav_desc", "checkboxstatic");
            $form->setType("doc_surf", "checkboxstatic");
            $form->setType("doc_nb_log", "checkboxstatic");
            $form->setType("doc_nb_log_indiv", "checkboxstatic");
            $form->setType("doc_nb_log_coll", "checkboxstatic");
            $form->setType("doc_nb_log_lls", "checkboxstatic");
            $form->setType("doc_nb_log_aa", "checkboxstatic");
            $form->setType("doc_nb_log_ptz", "checkboxstatic");
            $form->setType("doc_nb_log_autre", "checkboxstatic");
            $form->setType("daact_date", "checkboxstatic");
            $form->setType("daact_date_chgmt_dest", "checkboxstatic");
            $form->setType("daact_tot_trav", "checkboxstatic");
            $form->setType("daact_tranche_trav", "checkboxstatic");
            $form->setType("daact_tranche_trav_desc", "checkboxstatic");
            $form->setType("daact_surf", "checkboxstatic");
            $form->setType("daact_nb_log", "checkboxstatic");
            $form->setType("daact_nb_log_indiv", "checkboxstatic");
            $form->setType("daact_nb_log_coll", "checkboxstatic");
            $form->setType("daact_nb_log_lls", "checkboxstatic");
            $form->setType("daact_nb_log_aa", "checkboxstatic");
            $form->setType("daact_nb_log_ptz", "checkboxstatic");
            $form->setType("daact_nb_log_autre", "checkboxstatic");
            $form->setType("am_div_mun", "checkboxstatic");
            $form->setType("co_perf_energ", "checkboxstatic");
            $form->setType("architecte", "checkboxstatic");
            $form->setType("co_statio_avt_shob", "checkboxstatic");
            $form->setType("co_statio_apr_shob", "checkboxstatic");
            $form->setType("co_statio_avt_surf", "checkboxstatic");
            $form->setType("co_statio_apr_surf", "checkboxstatic");
            $form->setType("co_trx_amgt", "checkboxstatic");
            $form->setType("co_modif_aspect", "checkboxstatic");
            $form->setType("co_modif_struct", "checkboxstatic");
            $form->setType("co_ouvr_elec", "checkboxstatic");
            $form->setType("co_ouvr_infra", "checkboxstatic");
            $form->setType("co_trx_imm", "checkboxstatic");
            $form->setType("co_cstr_shob", "checkboxstatic");
            $form->setType("am_voyage_deb", "checkboxstatic");
            $form->setType("am_voyage_fin", "checkboxstatic");
            $form->setType("am_modif_amgt", "checkboxstatic");
            $form->setType("am_lot_max_shob", "checkboxstatic");
            $form->setType("mod_desc", "checkboxstatic");
            $form->setType("tr_total", "checkboxstatic");
            $form->setType("tr_partiel", "checkboxstatic");
            $form->setType("tr_desc", "checkboxstatic");
            $form->setType("avap_co_elt_pro", "checkboxstatic");
            $form->setType("avap_nouv_haut_surf", "checkboxstatic");
            $form->setType("avap_co_clot", "checkboxstatic");
            $form->setType("avap_aut_coup_aba_arb", "checkboxstatic");
            $form->setType("avap_ouv_infra", "checkboxstatic");
            $form->setType("avap_aut_inst_mob", "checkboxstatic");
            $form->setType("avap_aut_plant", "checkboxstatic");
            $form->setType("avap_aut_auv_elec", "checkboxstatic");
            $form->setType("tax_dest_loc_tr", "checkboxstatic");
            $form->setType("ope_proj_desc", "checkboxstatic");
            $form->setType("tax_surf_tot_cstr", "checkboxstatic");
            $form->setType("tax_surf_loc_stat", "checkboxstatic");
            $form->setType("tax_log_ap_trvx_nb", "checkboxstatic");
            $form->setType("tax_am_statio_ext_cr", "checkboxstatic");
            $form->setType("tax_sup_bass_pisc_cr", "checkboxstatic");
            $form->setType("tax_empl_ten_carav_mobil_nb_cr", "checkboxstatic");
            $form->setType("tax_empl_hll_nb_cr", "checkboxstatic");
            $form->setType("tax_eol_haut_nb_cr", "checkboxstatic");
            $form->setType("tax_pann_volt_sup_cr", "checkboxstatic");
            $form->setType("tax_surf_loc_arch", "checkboxstatic");
            $form->setType("tax_surf_pisc_arch", "checkboxstatic");
            $form->setType("tax_am_statio_ext_arch", "checkboxstatic");
            $form->setType("tab_tax_su_parc_statio_expl_comm", "static");
            $form->setType("tax_empl_ten_carav_mobil_nb_arch", "checkboxstatic");
            $form->setType("tax_empl_hll_nb_arch", "checkboxstatic");
            $form->setType("tax_eol_haut_nb_arch", "checkboxstatic");
            $form->setType("ope_proj_div_co", "checkboxstatic");
            $form->setType("ope_proj_div_contr", "checkboxstatic");
            $form->setType("tax_desc", "checkboxstatic");
            $form->setType("erp_cstr_neuve", "checkboxstatic");
            $form->setType("erp_trvx_acc", "checkboxstatic");
            $form->setType("erp_extension", "checkboxstatic");
            $form->setType("erp_rehab", "checkboxstatic");
            $form->setType("erp_trvx_am", "checkboxstatic");
            $form->setType("erp_vol_nouv_exist", "checkboxstatic");
            $form->setType("tab_erp_eff", "static");
            $form->setType("erp_class_cat", "checkboxstatic");
            $form->setType("erp_class_type", "checkboxstatic");
            $form->setType("tax_surf_abr_jard_pig_colom", "checkboxstatic");
            $form->setType("tax_su_non_habit_abr_jard_pig_colom", "checkboxstatic");
            $form->setType("dia_imm_non_bati", "checkboxstatic");
            $form->setType("dia_imm_bati_terr_propr", "checkboxstatic");
            $form->setType("dia_imm_bati_terr_autr", "checkboxstatic");
            $form->setType("dia_imm_bati_terr_autr_desc", "checkboxstatic");
            $form->setType("dia_bat_copro", "checkboxstatic");
            $form->setType("dia_bat_copro_desc", "checkboxstatic");
            $form->setType("dia_lot_numero", "checkboxstatic");
            $form->setType("dia_lot_bat", "checkboxstatic");
            $form->setType("dia_lot_etage", "checkboxstatic");
            $form->setType("dia_lot_quote_part", "checkboxstatic");
            $form->setType("dia_us_hab", "checkboxstatic");
            $form->setType("dia_us_pro", "checkboxstatic");
            $form->setType("dia_us_mixte", "checkboxstatic");
            $form->setType("dia_us_comm", "checkboxstatic");
            $form->setType("dia_us_agr", "checkboxstatic");
            $form->setType("dia_us_autre", "checkboxstatic");
            $form->setType("dia_us_autre_prec", "checkboxstatic");
            $form->setType("dia_occ_prop", "checkboxstatic");
            $form->setType("dia_occ_loc", "checkboxstatic");
            $form->setType("dia_occ_sans_occ", "checkboxstatic");
            $form->setType("dia_occ_autre", "checkboxstatic");
            $form->setType("dia_occ_autre_prec", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_mob", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_cheptel", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_recol", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_autre", "checkboxstatic");
            $form->setType("dia_mod_cess_commi", "checkboxstatic");
            $form->setType("dia_mod_cess_commi_ttc", "checkboxstatic");
            $form->setType("dia_mod_cess_commi_ht", "checkboxstatic");
            $form->setType("dia_acquereur_nom_prenom", "checkboxstatic");
            $form->setType("dia_acquereur_adr_num_voie", "checkboxstatic");
            $form->setType("dia_acquereur_adr_ext", "checkboxstatic");
            $form->setType("dia_acquereur_adr_type_voie", "checkboxstatic");
            $form->setType("dia_acquereur_adr_nom_voie", "checkboxstatic");
            $form->setType("dia_acquereur_adr_lieu_dit_bp", "checkboxstatic");
            $form->setType("dia_acquereur_adr_cp", "checkboxstatic");
            $form->setType("dia_acquereur_adr_localite", "checkboxstatic");
            $form->setType("dia_observation", "checkboxstatic");
            $form->setType("tab_surface2", "static");
            $form->setType("dia_occ_sol_su_terre", "checkboxstatic");
            $form->setType("dia_occ_sol_su_pres", "checkboxstatic");
            $form->setType("dia_occ_sol_su_verger", "checkboxstatic");
            $form->setType("dia_occ_sol_su_vigne", "checkboxstatic");
            $form->setType("dia_occ_sol_su_bois", "checkboxstatic");
            $form->setType("dia_occ_sol_su_lande", "checkboxstatic");
            $form->setType("dia_occ_sol_su_carriere", "checkboxstatic");
            $form->setType("dia_occ_sol_su_eau_cadastree", "checkboxstatic");
            $form->setType("dia_occ_sol_su_jardin", "checkboxstatic");
            $form->setType("dia_occ_sol_su_terr_batir", "checkboxstatic");
            $form->setType("dia_occ_sol_su_terr_agr", "checkboxstatic");
            $form->setType("dia_occ_sol_su_sol", "checkboxstatic");
            $form->setType("dia_bati_vend_tot", "checkboxstatic");
            $form->setType("dia_bati_vend_tot_txt", "checkboxstatic");
            $form->setType("dia_su_co_sol", "checkboxstatic");
            $form->setType("dia_su_util_hab", "checkboxstatic");
            $form->setType("dia_nb_niv", "checkboxstatic");
            $form->setType("dia_nb_appart", "checkboxstatic");
            $form->setType("dia_nb_autre_loc", "checkboxstatic");
            $form->setType("dia_vente_lot_volume", "checkboxstatic");
            $form->setType("dia_vente_lot_volume_txt", "checkboxstatic");
            $form->setType("dia_lot_nat_su", "checkboxstatic");
            $form->setType("dia_lot_bat_achv_plus_10", "checkboxstatic");
            $form->setType("dia_lot_bat_achv_moins_10", "checkboxstatic");
            $form->setType("dia_lot_regl_copro_publ_hypo_plus_10", "checkboxstatic");
            $form->setType("dia_lot_regl_copro_publ_hypo_moins_10", "checkboxstatic");
            $form->setType("dia_indivi_quote_part", "checkboxstatic");
            $form->setType("dia_design_societe", "checkboxstatic");
            $form->setType("dia_design_droit", "checkboxstatic");
            $form->setType("dia_droit_soc_nat", "checkboxstatic");
            $form->setType("dia_droit_soc_nb", "checkboxstatic");
            $form->setType("dia_droit_soc_num_part", "checkboxstatic");
            $form->setType("dia_droit_reel_perso_grevant_bien_oui", "checkboxstatic");
            $form->setType("dia_droit_reel_perso_grevant_bien_non", "checkboxstatic");
            $form->setType("dia_droit_reel_perso_nat", "checkboxstatic");
            $form->setType("dia_droit_reel_perso_viag", "checkboxstatic");
            $form->setType("dia_mod_cess_adr", "checkboxstatic");
            $form->setType("dia_mod_cess_sign_act_auth", "checkboxstatic");
            $form->setType("dia_mod_cess_terme", "checkboxstatic");
            $form->setType("dia_mod_cess_terme_prec", "checkboxstatic");
            $form->setType("dia_mod_cess_bene_acquereur", "checkboxstatic");
            $form->setType("dia_mod_cess_bene_vendeur", "checkboxstatic");
            $form->setType("dia_mod_cess_paie_nat", "checkboxstatic");
            $form->setType("dia_mod_cess_design_contr_alien", "checkboxstatic");
            $form->setType("dia_mod_cess_eval_contr", "checkboxstatic");
            $form->setType("dia_mod_cess_rente_viag", "checkboxstatic");
            $form->setType("dia_mod_cess_mnt_an", "checkboxstatic");
            $form->setType("dia_mod_cess_mnt_compt", "checkboxstatic");
            $form->setType("dia_mod_cess_bene_rente", "checkboxstatic");
            $form->setType("dia_mod_cess_droit_usa_hab", "checkboxstatic");
            $form->setType("dia_mod_cess_droit_usa_hab_prec", "checkboxstatic");
            $form->setType("dia_mod_cess_eval_usa_usufruit", "checkboxstatic");
            $form->setType("dia_mod_cess_vente_nue_prop", "checkboxstatic");
            $form->setType("dia_mod_cess_vente_nue_prop_prec", "checkboxstatic");
            $form->setType("dia_mod_cess_echange", "checkboxstatic");
            $form->setType("dia_mod_cess_design_bien_recus_ech", "checkboxstatic");
            $form->setType("dia_mod_cess_mnt_soulte", "checkboxstatic");
            $form->setType("dia_mod_cess_prop_contre_echan", "checkboxstatic");
            $form->setType("dia_mod_cess_apport_societe", "checkboxstatic");
            $form->setType("dia_mod_cess_bene", "checkboxstatic");
            $form->setType("dia_mod_cess_esti_bien", "checkboxstatic");
            $form->setType("dia_mod_cess_cess_terr_loc_co", "checkboxstatic");
            $form->setType("dia_mod_cess_esti_terr", "checkboxstatic");
            $form->setType("dia_mod_cess_esti_loc", "checkboxstatic");
            $form->setType("dia_mod_cess_esti_imm_loca", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_vol", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_obl", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_fin_indivi", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_date_lieu", "checkboxstatic");
            $form->setType("dia_mod_cess_mnt_mise_prix", "checkboxstatic");
            $form->setType("dia_prop_titu_prix_indique", "checkboxstatic");
            $form->setType("dia_prop_recherche_acqu_prix_indique", "checkboxstatic");
            $form->setType("dia_acquereur_prof", "checkboxstatic");
            $form->setType("dia_indic_compl_ope", "checkboxstatic");
            $form->setType("dia_vente_adju", "checkboxstatic");
            $form->setType("am_terr_res_demon", "checkboxstatic");
            $form->setType("am_air_terr_res_mob", "checkboxstatic");
            $form->setType("ctx_objet_recours", "checkboxstatic");
            $form->setType("ctx_moyen_souleve", "checkboxstatic");
            $form->setType("ctx_moyen_retenu_juge", "checkboxstatic");
            $form->setType("ctx_reference_sagace", "checkboxstatic");
            $form->setType("ctx_nature_travaux_infra_om_html", "checkboxstatic");
            $form->setType("ctx_synthese_nti", "checkboxstatic");
            $form->setType("ctx_article_non_resp_om_html", "checkboxstatic");
            $form->setType("ctx_synthese_anr", "checkboxstatic");
            $form->setType("ctx_reference_parquet", "checkboxstatic");
            $form->setType("ctx_element_taxation", "checkboxstatic");
            $form->setType("ctx_infraction", "checkboxstatic");
            $form->setType("ctx_regularisable", "checkboxstatic");
            $form->setType("ctx_reference_courrier", "checkboxstatic");
            $form->setType("ctx_date_audience", "checkboxstatic");
            $form->setType("ctx_date_ajournement", "checkboxstatic");
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
            $form->setType("mtn_exo_ta_part_commu", "checkboxstatic");
            $form->setType("mtn_exo_ta_part_depart", "checkboxstatic");
            $form->setType("mtn_exo_ta_part_reg", "checkboxstatic");
            $form->setType("mtn_exo_rap", "checkboxstatic");
            $form->setType("dpc_type", "checkboxstatic");
            $form->setType("dpc_desc_actv_ex", "checkboxstatic");
            $form->setType("dpc_desc_ca", "checkboxstatic");
            $form->setType("dpc_desc_aut_prec", "checkboxstatic");
            $form->setType("dpc_desig_comm_arti", "checkboxstatic");
            $form->setType("dpc_desig_loc_hab", "checkboxstatic");
            $form->setType("dpc_desig_loc_ann", "checkboxstatic");
            $form->setType("dpc_desig_loc_ann_prec", "checkboxstatic");
            $form->setType("dpc_bail_comm_date", "checkboxstatic");
            $form->setType("dpc_bail_comm_loyer", "checkboxstatic");
            $form->setType("dpc_actv_acqu", "checkboxstatic");
            $form->setType("dpc_nb_sala_di", "checkboxstatic");
            $form->setType("dpc_nb_sala_dd", "checkboxstatic");
            $form->setType("dpc_nb_sala_tc", "checkboxstatic");
            $form->setType("dpc_nb_sala_tp", "checkboxstatic");
            $form->setType("dpc_moda_cess_vente_am", "checkboxstatic");
            $form->setType("dpc_moda_cess_adj", "checkboxstatic");
            $form->setType("dpc_moda_cess_prix", "checkboxstatic");
            $form->setType("dpc_moda_cess_adj_date", "checkboxstatic");
            $form->setType("dpc_moda_cess_adj_prec", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_comp", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_terme", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_terme_prec", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_nat", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_nat_desig_alien_prec", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_nat_eval", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_nat_eval_prec", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_aut", "checkboxstatic");
            $form->setType("dpc_moda_cess_paie_aut_prec", "checkboxstatic");
            $form->setType("dpc_ss_signe_demande_acqu", "checkboxstatic");
            $form->setType("dpc_ss_signe_recher_trouv_acqu", "checkboxstatic");
            $form->setType("dpc_notif_adr_prop", "checkboxstatic");
            $form->setType("dpc_notif_adr_manda", "checkboxstatic");
            $form->setType("dpc_obs", "checkboxstatic");
            $form->setType("co_peri_site_patri_remar", "checkboxstatic");
            $form->setType("co_abo_monu_hist", "checkboxstatic");
            $form->setType("co_inst_ouvr_trav_act_code_envir", "checkboxstatic");
            $form->setType("co_trav_auto_env", "checkboxstatic");
            $form->setType("co_derog_esp_prot", "checkboxstatic");
            $form->setType("ctx_reference_dsj", "checkboxstatic");
            $form->setType("co_piscine", "checkboxstatic");
            $form->setType("co_fin_lls", "checkboxstatic");
            $form->setType("co_fin_aa", "checkboxstatic");
            $form->setType("co_fin_ptz", "checkboxstatic");
            $form->setType("co_fin_autr", "checkboxstatic");
            $form->setType("dia_ss_date", "checkboxstatic");
            $form->setType("dia_ss_lieu", "checkboxstatic");
            $form->setType("enga_decla_lieu", "checkboxstatic");
            $form->setType("enga_decla_date", "checkboxstatic");
            $form->setType("co_archi_attest_honneur", "checkboxstatic");
            $form->setType("co_bat_niv_dessous_nb", "checkboxstatic");
            $form->setType("co_install_classe", "checkboxstatic");
            $form->setType("co_derog_innov", "checkboxstatic");
            $form->setType("co_avis_abf", "checkboxstatic");
            $form->setType("tax_surf_tot_demo", "checkboxstatic");
            $form->setType("tax_surf_tax_demo", "checkboxstatic");
            $form->setType("tax_terrassement_arch", "checkboxstatic");
            $form->setType("tax_adresse_future_numero", "checkboxstatic");
            $form->setType("tax_adresse_future_voie", "checkboxstatic");
            $form->setType("tax_adresse_future_lieudit", "checkboxstatic");
            $form->setType("tax_adresse_future_localite", "checkboxstatic");
            $form->setType("tax_adresse_future_cp", "checkboxstatic");
            $form->setType("tax_adresse_future_bp", "checkboxstatic");
            $form->setType("tax_adresse_future_cedex", "checkboxstatic");
            $form->setType("tax_adresse_future_pays", "checkboxstatic");
            $form->setType("tax_adresse_future_division", "checkboxstatic");
            $form->setType("co_bat_projete", "checkboxstatic");
            $form->setType("co_bat_existant", "checkboxstatic");
            $form->setType("co_bat_nature", "checkboxstatic");
            $form->setType("terr_juri_titul_date", "checkboxstatic");
            $form->setType("co_autre_desc", "checkboxstatic");
            $form->setType("co_trx_autre", "checkboxstatic");
            $form->setType("co_autre", "checkboxstatic");
            $form->setType("erp_modif_facades", "checkboxstatic");
            $form->setType("erp_trvx_adap", "checkboxstatic");
            $form->setType("erp_trvx_adap_numero", "checkboxstatic");
            $form->setType("erp_trvx_adap_valid", "checkboxstatic");
            $form->setType("erp_prod_dangereux", "checkboxstatic");
            $form->setType("co_trav_supp_dessus", "checkboxstatic");
            $form->setType("co_trav_supp_dessous", "checkboxstatic");
            $form->setType("tax_su_habit_abr_jard_pig_colom", "checkboxstatic");
            $form->setType("enga_decla_donnees_nomi_comm", "checkboxstatic");
            $form->setType("x1l_legislation", "checkboxstatic");
            $form->setType("x1p_precisions", "checkboxstatic");
            $form->setType("x1u_raccordement", "checkboxstatic");
            $form->setType("x2m_inscritmh", "checkboxstatic");
            $form->setType("s1na1_numero", "checkboxstatic");
            $form->setType("s1va1_voie", "checkboxstatic");
            $form->setType("s1wa1_lieudit", "checkboxstatic");
            $form->setType("s1la1_localite", "checkboxstatic");
            $form->setType("s1pa1_codepostal", "checkboxstatic");
            $form->setType("s1na2_numero", "checkboxstatic");
            $form->setType("s1va2_voie", "checkboxstatic");
            $form->setType("s1wa2_lieudit", "checkboxstatic");
            $form->setType("s1la2_localite", "checkboxstatic");
            $form->setType("s1pa2_codepostal", "checkboxstatic");
            $form->setType("e3c_certification", "checkboxstatic");
            $form->setType("e3a_competence", "checkboxstatic");
            $form->setType("a4d_description", "checkboxstatic");
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
            $form->setType("u3t_observations", "checkboxstatic");
            $form->setType("u1a_voirieoui", "checkboxstatic");
            $form->setType("u1v_voirienon", "checkboxstatic");
            $form->setType("u1q_voirieconcessionnaire", "checkboxstatic");
            $form->setType("u1b_voirieavant", "checkboxstatic");
            $form->setType("u1j_eauoui", "checkboxstatic");
            $form->setType("u1t_eaunon", "checkboxstatic");
            $form->setType("u1e_eauconcessionnaire", "checkboxstatic");
            $form->setType("u1k_eauavant", "checkboxstatic");
            $form->setType("u1s_assainissementoui", "checkboxstatic");
            $form->setType("u1d_assainissementnon", "checkboxstatic");
            $form->setType("u1l_assainissementconcessionnaire", "checkboxstatic");
            $form->setType("u1r_assainissementavant", "checkboxstatic");
            $form->setType("u1c_electriciteoui", "checkboxstatic");
            $form->setType("u1u_electricitenon", "checkboxstatic");
            $form->setType("u1m_electriciteconcessionnaire", "checkboxstatic");
            $form->setType("u1f_electriciteavant", "checkboxstatic");
            $form->setType("u2a_observations", "checkboxstatic");
            $form->setType("f1ts4_surftaxestation", "checkboxstatic");
            $form->setType("f1ut1_surfcree", "checkboxstatic");
            $form->setType("f9d_date", "checkboxstatic");
            $form->setType("f9n_nom", "checkboxstatic");
            $form->setType("dia_droit_reel_perso_grevant_bien_desc", "checkboxstatic");
            $form->setType("dia_mod_cess_paie_nat_desc", "checkboxstatic");
            $form->setType("dia_mod_cess_rente_viag_desc", "checkboxstatic");
            $form->setType("dia_mod_cess_echange_desc", "checkboxstatic");
            $form->setType("dia_mod_cess_apport_societe_desc", "checkboxstatic");
            $form->setType("dia_mod_cess_cess_terr_loc_co_desc", "checkboxstatic");
            $form->setType("dia_mod_cess_esti_imm_loca_desc", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_obl_desc", "checkboxstatic");
            $form->setType("dia_mod_cess_adju_fin_indivi_desc", "checkboxstatic");
            $form->setType("dia_cadre_titul_droit_prempt", "checkboxstatic");
            $form->setType("dia_mairie_prix_moyen", "checkboxstatic");
            $form->setType("dia_propri_indivi", "checkboxstatic");
            $form->setType("dia_situa_bien_plan_cadas_oui", "checkboxstatic");
            $form->setType("dia_situa_bien_plan_cadas_non", "checkboxstatic");
            $form->setType("dia_notif_dec_titul_adr_prop", "checkboxstatic");
            $form->setType("dia_notif_dec_titul_adr_prop_desc", "checkboxstatic");
            $form->setType("dia_notif_dec_titul_adr_manda", "checkboxstatic");
            $form->setType("dia_notif_dec_titul_adr_manda_desc", "checkboxstatic");
            $form->setType("dia_dia_dpu", "checkboxstatic");
            $form->setType("dia_dia_zad", "checkboxstatic");
            $form->setType("dia_dia_zone_preempt_esp_natu_sensi", "checkboxstatic");
            $form->setType("dia_dab_dpu", "checkboxstatic");
            $form->setType("dia_dab_zad", "checkboxstatic");
            $form->setType("dia_mod_cess_commi_mnt", "checkboxstatic");
            $form->setType("dia_mod_cess_commi_mnt_ttc", "checkboxstatic");
            $form->setType("dia_mod_cess_commi_mnt_ht", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_num", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_mob_num", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_cheptel_num", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_recol_num", "checkboxstatic");
            $form->setType("dia_mod_cess_prix_vente_autre_num", "checkboxstatic");
            $form->setType("dia_su_co_sol_num", "checkboxstatic");
            $form->setType("dia_su_util_hab_num", "checkboxstatic");
            $form->setType("dia_mod_cess_mnt_an_num", "checkboxstatic");
            $form->setType("dia_mod_cess_mnt_compt_num", "checkboxstatic");
            $form->setType("dia_mod_cess_mnt_soulte_num", "checkboxstatic");
            $form->setType("dia_comp_prix_vente", "checkboxstatic");
            $form->setType("dia_comp_surface", "checkboxstatic");
            $form->setType("dia_comp_total_frais", "checkboxstatic");
            $form->setType("dia_comp_mtn_total", "checkboxstatic");
            $form->setType("dia_comp_valeur_m2", "checkboxstatic");
            $form->setType("dia_esti_prix_france_dom", "checkboxstatic");
            $form->setType("dia_prop_collectivite", "checkboxstatic");
            $form->setType("dia_delegataire_denomination", "checkboxstatic");
            $form->setType("dia_delegataire_raison_sociale", "checkboxstatic");
            $form->setType("dia_delegataire_siret", "checkboxstatic");
            $form->setType("dia_delegataire_categorie_juridique", "checkboxstatic");
            $form->setType("dia_delegataire_representant_nom", "checkboxstatic");
            $form->setType("dia_delegataire_representant_prenom", "checkboxstatic");
            $form->setType("dia_delegataire_adresse_numero", "checkboxstatic");
            $form->setType("dia_delegataire_adresse_voie", "checkboxstatic");
            $form->setType("dia_delegataire_adresse_complement", "checkboxstatic");
            $form->setType("dia_delegataire_adresse_lieu_dit", "checkboxstatic");
            $form->setType("dia_delegataire_adresse_localite", "checkboxstatic");
            $form->setType("dia_delegataire_adresse_code_postal", "checkboxstatic");
            $form->setType("dia_delegataire_adresse_bp", "checkboxstatic");
            $form->setType("dia_delegataire_adresse_cedex", "checkboxstatic");
            $form->setType("dia_delegataire_adresse_pays", "checkboxstatic");
            $form->setType("dia_delegataire_telephone_fixe", "checkboxstatic");
            $form->setType("dia_delegataire_telephone_mobile", "checkboxstatic");
            $form->setType("dia_delegataire_telephone_mobile_indicatif", "checkboxstatic");
            $form->setType("dia_delegataire_courriel", "checkboxstatic");
            $form->setType("dia_delegataire_fax", "checkboxstatic");
            $form->setType("dia_entree_jouissance_type", "checkboxstatic");
            $form->setType("dia_entree_jouissance_date", "checkboxstatic");
            $form->setType("dia_entree_jouissance_date_effet", "checkboxstatic");
            $form->setType("dia_entree_jouissance_com", "checkboxstatic");
            $form->setType("dia_remise_bien_date_effet", "checkboxstatic");
            $form->setType("dia_remise_bien_com", "checkboxstatic");
            $form->setType("c2zp1_crete", "checkboxstatic");
            $form->setType("c2zr1_destination", "checkboxstatic");
            $form->setType("mh_design_appel_denom", "checkboxstatic");
            $form->setType("mh_design_type_protect", "checkboxstatic");
            $form->setType("mh_design_elem_prot", "checkboxstatic");
            $form->setType("mh_design_ref_merimee_palissy", "checkboxstatic");
            $form->setType("mh_design_nature_prop", "checkboxstatic");
            $form->setType("mh_loc_denom", "checkboxstatic");
            $form->setType("mh_pres_intitule", "checkboxstatic");
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
            $form->setType("mh_trav_cat_12_prec", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('cerfa','VerifNum(this)');
        $form->setOnchange('om_validite_debut','fdate(this)');
        $form->setOnchange('om_validite_fin','fdate(this)');
        $form->setOnchange('tab_surface','VerifNum(this)');
        $form->setOnchange('tab_tax_su_princ','VerifNum(this)');
        $form->setOnchange('tab_tax_su_heber','VerifNum(this)');
        $form->setOnchange('tab_tax_su_secon','VerifNum(this)');
        $form->setOnchange('tab_tax_su_tot','VerifNum(this)');
        $form->setOnchange('tab_tax_su_non_habit_surf','VerifNum(this)');
        $form->setOnchange('tab_tax_am','VerifNum(this)');
        $form->setOnchange('tab_tax_su_parc_statio_expl_comm','VerifNum(this)');
        $form->setOnchange('tab_erp_eff','VerifNum(this)');
        $form->setOnchange('tab_surface2','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("cerfa", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("code", 20);
        $form->setTaille("om_validite_debut", 12);
        $form->setTaille("om_validite_fin", 12);
        $form->setTaille("am_lotiss", 1);
        $form->setTaille("am_autre_div", 1);
        $form->setTaille("am_camping", 1);
        $form->setTaille("am_caravane", 1);
        $form->setTaille("am_carav_duree", 1);
        $form->setTaille("am_statio", 1);
        $form->setTaille("am_statio_cont", 1);
        $form->setTaille("am_affou_exhau", 1);
        $form->setTaille("am_affou_exhau_sup", 1);
        $form->setTaille("am_affou_prof", 1);
        $form->setTaille("am_exhau_haut", 1);
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
        $form->setTaille("am_projet_desc", 1);
        $form->setTaille("am_terr_surf", 1);
        $form->setTaille("am_tranche_desc", 1);
        $form->setTaille("am_lot_max_nb", 1);
        $form->setTaille("am_lot_max_shon", 1);
        $form->setTaille("am_lot_cstr_cos", 1);
        $form->setTaille("am_lot_cstr_plan", 1);
        $form->setTaille("am_lot_cstr_vente", 1);
        $form->setTaille("am_lot_fin_diff", 1);
        $form->setTaille("am_lot_consign", 1);
        $form->setTaille("am_lot_gar_achev", 1);
        $form->setTaille("am_lot_vente_ant", 1);
        $form->setTaille("am_empl_nb", 1);
        $form->setTaille("am_tente_nb", 1);
        $form->setTaille("am_carav_nb", 1);
        $form->setTaille("am_mobil_nb", 1);
        $form->setTaille("am_pers_nb", 1);
        $form->setTaille("am_empl_hll_nb", 1);
        $form->setTaille("am_hll_shon", 1);
        $form->setTaille("am_periode_exploit", 1);
        $form->setTaille("am_exist_agrand", 1);
        $form->setTaille("am_exist_date", 1);
        $form->setTaille("am_exist_num", 1);
        $form->setTaille("am_exist_nb_avant", 1);
        $form->setTaille("am_exist_nb_apres", 1);
        $form->setTaille("am_coupe_bois", 1);
        $form->setTaille("am_coupe_parc", 1);
        $form->setTaille("am_coupe_align", 1);
        $form->setTaille("am_coupe_ess", 1);
        $form->setTaille("am_coupe_age", 1);
        $form->setTaille("am_coupe_dens", 1);
        $form->setTaille("am_coupe_qual", 1);
        $form->setTaille("am_coupe_trait", 1);
        $form->setTaille("am_coupe_autr", 1);
        $form->setTaille("co_archi_recours", 1);
        $form->setTaille("co_cstr_nouv", 1);
        $form->setTaille("co_cstr_exist", 1);
        $form->setTaille("co_cloture", 1);
        $form->setTaille("co_elec_tension", 1);
        $form->setTaille("co_div_terr", 1);
        $form->setTaille("co_projet_desc", 1);
        $form->setTaille("co_anx_pisc", 1);
        $form->setTaille("co_anx_gara", 1);
        $form->setTaille("co_anx_veran", 1);
        $form->setTaille("co_anx_abri", 1);
        $form->setTaille("co_anx_autr", 1);
        $form->setTaille("co_anx_autr_desc", 1);
        $form->setTaille("co_tot_log_nb", 1);
        $form->setTaille("co_tot_ind_nb", 1);
        $form->setTaille("co_tot_coll_nb", 1);
        $form->setTaille("co_mais_piece_nb", 1);
        $form->setTaille("co_mais_niv_nb", 1);
        $form->setTaille("co_fin_lls_nb", 1);
        $form->setTaille("co_fin_aa_nb", 1);
        $form->setTaille("co_fin_ptz_nb", 1);
        $form->setTaille("co_fin_autr_nb", 1);
        $form->setTaille("co_fin_autr_desc", 1);
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
        $form->setTaille("co_resid_autr_desc", 1);
        $form->setTaille("co_foyer_chamb_nb", 1);
        $form->setTaille("co_log_1p_nb", 1);
        $form->setTaille("co_log_2p_nb", 1);
        $form->setTaille("co_log_3p_nb", 1);
        $form->setTaille("co_log_4p_nb", 1);
        $form->setTaille("co_log_5p_nb", 1);
        $form->setTaille("co_log_6p_nb", 1);
        $form->setTaille("co_bat_niv_nb", 1);
        $form->setTaille("co_trx_exten", 1);
        $form->setTaille("co_trx_surelev", 1);
        $form->setTaille("co_trx_nivsup", 1);
        $form->setTaille("co_demont_periode", 1);
        $form->setTaille("co_sp_transport", 1);
        $form->setTaille("co_sp_enseign", 1);
        $form->setTaille("co_sp_act_soc", 1);
        $form->setTaille("co_sp_ouvr_spe", 1);
        $form->setTaille("co_sp_sante", 1);
        $form->setTaille("co_sp_culture", 1);
        $form->setTaille("co_statio_avt_nb", 1);
        $form->setTaille("co_statio_apr_nb", 1);
        $form->setTaille("co_statio_adr", 1);
        $form->setTaille("co_statio_place_nb", 1);
        $form->setTaille("co_statio_tot_surf", 1);
        $form->setTaille("co_statio_tot_shob", 1);
        $form->setTaille("co_statio_comm_cin_surf", 1);
        $form->setTaille("tab_surface", 11);
        $form->setTaille("dm_constr_dates", 1);
        $form->setTaille("dm_total", 1);
        $form->setTaille("dm_partiel", 1);
        $form->setTaille("dm_projet_desc", 1);
        $form->setTaille("dm_tot_log_nb", 1);
        $form->setTaille("tax_surf_tot", 1);
        $form->setTaille("tax_surf", 1);
        $form->setTaille("tax_surf_suppr_mod", 1);
        $form->setTaille("tab_tax_su_princ", 11);
        $form->setTaille("tab_tax_su_heber", 11);
        $form->setTaille("tab_tax_su_secon", 11);
        $form->setTaille("tab_tax_su_tot", 11);
        $form->setTaille("tax_ext_pret", 1);
        $form->setTaille("tax_ext_desc", 1);
        $form->setTaille("tax_surf_tax_exist_cons", 1);
        $form->setTaille("tax_log_exist_nb", 1);
        $form->setTaille("tax_trx_presc_ppr", 1);
        $form->setTaille("tax_monu_hist", 1);
        $form->setTaille("tax_comm_nb", 1);
        $form->setTaille("tab_tax_su_non_habit_surf", 11);
        $form->setTaille("tab_tax_am", 11);
        $form->setTaille("vsd_surf_planch_smd", 1);
        $form->setTaille("vsd_unit_fonc_sup", 1);
        $form->setTaille("vsd_unit_fonc_constr_sup", 1);
        $form->setTaille("vsd_val_terr", 1);
        $form->setTaille("vsd_const_sxist_non_dem_surf", 1);
        $form->setTaille("vsd_rescr_fisc", 1);
        $form->setTaille("pld_val_terr", 1);
        $form->setTaille("pld_const_exist_dem", 1);
        $form->setTaille("pld_const_exist_dem_surf", 1);
        $form->setTaille("code_cnil", 1);
        $form->setTaille("terr_juri_titul", 1);
        $form->setTaille("terr_juri_lot", 1);
        $form->setTaille("terr_juri_zac", 1);
        $form->setTaille("terr_juri_afu", 1);
        $form->setTaille("terr_juri_pup", 1);
        $form->setTaille("terr_juri_oin", 1);
        $form->setTaille("terr_juri_desc", 1);
        $form->setTaille("terr_div_surf_etab", 1);
        $form->setTaille("terr_div_surf_av_div", 1);
        $form->setTaille("doc_date", 1);
        $form->setTaille("doc_tot_trav", 1);
        $form->setTaille("doc_tranche_trav", 1);
        $form->setTaille("doc_tranche_trav_desc", 1);
        $form->setTaille("doc_surf", 1);
        $form->setTaille("doc_nb_log", 1);
        $form->setTaille("doc_nb_log_indiv", 1);
        $form->setTaille("doc_nb_log_coll", 1);
        $form->setTaille("doc_nb_log_lls", 1);
        $form->setTaille("doc_nb_log_aa", 1);
        $form->setTaille("doc_nb_log_ptz", 1);
        $form->setTaille("doc_nb_log_autre", 1);
        $form->setTaille("daact_date", 1);
        $form->setTaille("daact_date_chgmt_dest", 1);
        $form->setTaille("daact_tot_trav", 1);
        $form->setTaille("daact_tranche_trav", 1);
        $form->setTaille("daact_tranche_trav_desc", 1);
        $form->setTaille("daact_surf", 1);
        $form->setTaille("daact_nb_log", 1);
        $form->setTaille("daact_nb_log_indiv", 1);
        $form->setTaille("daact_nb_log_coll", 1);
        $form->setTaille("daact_nb_log_lls", 1);
        $form->setTaille("daact_nb_log_aa", 1);
        $form->setTaille("daact_nb_log_ptz", 1);
        $form->setTaille("daact_nb_log_autre", 1);
        $form->setTaille("am_div_mun", 1);
        $form->setTaille("co_perf_energ", 1);
        $form->setTaille("architecte", 1);
        $form->setTaille("co_statio_avt_shob", 1);
        $form->setTaille("co_statio_apr_shob", 1);
        $form->setTaille("co_statio_avt_surf", 1);
        $form->setTaille("co_statio_apr_surf", 1);
        $form->setTaille("co_trx_amgt", 1);
        $form->setTaille("co_modif_aspect", 1);
        $form->setTaille("co_modif_struct", 1);
        $form->setTaille("co_ouvr_elec", 1);
        $form->setTaille("co_ouvr_infra", 1);
        $form->setTaille("co_trx_imm", 1);
        $form->setTaille("co_cstr_shob", 1);
        $form->setTaille("am_voyage_deb", 1);
        $form->setTaille("am_voyage_fin", 1);
        $form->setTaille("am_modif_amgt", 1);
        $form->setTaille("am_lot_max_shob", 1);
        $form->setTaille("mod_desc", 1);
        $form->setTaille("tr_total", 1);
        $form->setTaille("tr_partiel", 1);
        $form->setTaille("tr_desc", 1);
        $form->setTaille("avap_co_elt_pro", 1);
        $form->setTaille("avap_nouv_haut_surf", 1);
        $form->setTaille("avap_co_clot", 1);
        $form->setTaille("avap_aut_coup_aba_arb", 1);
        $form->setTaille("avap_ouv_infra", 1);
        $form->setTaille("avap_aut_inst_mob", 1);
        $form->setTaille("avap_aut_plant", 1);
        $form->setTaille("avap_aut_auv_elec", 1);
        $form->setTaille("tax_dest_loc_tr", 1);
        $form->setTaille("ope_proj_desc", 1);
        $form->setTaille("tax_surf_tot_cstr", 1);
        $form->setTaille("tax_surf_loc_stat", 1);
        $form->setTaille("tax_log_ap_trvx_nb", 1);
        $form->setTaille("tax_am_statio_ext_cr", 1);
        $form->setTaille("tax_sup_bass_pisc_cr", 1);
        $form->setTaille("tax_empl_ten_carav_mobil_nb_cr", 1);
        $form->setTaille("tax_empl_hll_nb_cr", 1);
        $form->setTaille("tax_eol_haut_nb_cr", 1);
        $form->setTaille("tax_pann_volt_sup_cr", 1);
        $form->setTaille("tax_surf_loc_arch", 1);
        $form->setTaille("tax_surf_pisc_arch", 1);
        $form->setTaille("tax_am_statio_ext_arch", 1);
        $form->setTaille("tab_tax_su_parc_statio_expl_comm", 11);
        $form->setTaille("tax_empl_ten_carav_mobil_nb_arch", 1);
        $form->setTaille("tax_empl_hll_nb_arch", 1);
        $form->setTaille("tax_eol_haut_nb_arch", 1);
        $form->setTaille("ope_proj_div_co", 1);
        $form->setTaille("ope_proj_div_contr", 1);
        $form->setTaille("tax_desc", 1);
        $form->setTaille("erp_cstr_neuve", 1);
        $form->setTaille("erp_trvx_acc", 1);
        $form->setTaille("erp_extension", 1);
        $form->setTaille("erp_rehab", 1);
        $form->setTaille("erp_trvx_am", 1);
        $form->setTaille("erp_vol_nouv_exist", 1);
        $form->setTaille("tab_erp_eff", 11);
        $form->setTaille("erp_class_cat", 1);
        $form->setTaille("erp_class_type", 1);
        $form->setTaille("tax_surf_abr_jard_pig_colom", 1);
        $form->setTaille("tax_su_non_habit_abr_jard_pig_colom", 1);
        $form->setTaille("dia_imm_non_bati", 1);
        $form->setTaille("dia_imm_bati_terr_propr", 1);
        $form->setTaille("dia_imm_bati_terr_autr", 1);
        $form->setTaille("dia_imm_bati_terr_autr_desc", 1);
        $form->setTaille("dia_bat_copro", 1);
        $form->setTaille("dia_bat_copro_desc", 1);
        $form->setTaille("dia_lot_numero", 1);
        $form->setTaille("dia_lot_bat", 1);
        $form->setTaille("dia_lot_etage", 1);
        $form->setTaille("dia_lot_quote_part", 1);
        $form->setTaille("dia_us_hab", 1);
        $form->setTaille("dia_us_pro", 1);
        $form->setTaille("dia_us_mixte", 1);
        $form->setTaille("dia_us_comm", 1);
        $form->setTaille("dia_us_agr", 1);
        $form->setTaille("dia_us_autre", 1);
        $form->setTaille("dia_us_autre_prec", 1);
        $form->setTaille("dia_occ_prop", 1);
        $form->setTaille("dia_occ_loc", 1);
        $form->setTaille("dia_occ_sans_occ", 1);
        $form->setTaille("dia_occ_autre", 1);
        $form->setTaille("dia_occ_autre_prec", 1);
        $form->setTaille("dia_mod_cess_prix_vente", 1);
        $form->setTaille("dia_mod_cess_prix_vente_mob", 1);
        $form->setTaille("dia_mod_cess_prix_vente_cheptel", 1);
        $form->setTaille("dia_mod_cess_prix_vente_recol", 1);
        $form->setTaille("dia_mod_cess_prix_vente_autre", 1);
        $form->setTaille("dia_mod_cess_commi", 1);
        $form->setTaille("dia_mod_cess_commi_ttc", 1);
        $form->setTaille("dia_mod_cess_commi_ht", 1);
        $form->setTaille("dia_acquereur_nom_prenom", 1);
        $form->setTaille("dia_acquereur_adr_num_voie", 1);
        $form->setTaille("dia_acquereur_adr_ext", 1);
        $form->setTaille("dia_acquereur_adr_type_voie", 1);
        $form->setTaille("dia_acquereur_adr_nom_voie", 1);
        $form->setTaille("dia_acquereur_adr_lieu_dit_bp", 1);
        $form->setTaille("dia_acquereur_adr_cp", 1);
        $form->setTaille("dia_acquereur_adr_localite", 1);
        $form->setTaille("dia_observation", 1);
        $form->setTaille("tab_surface2", 11);
        $form->setTaille("dia_occ_sol_su_terre", 1);
        $form->setTaille("dia_occ_sol_su_pres", 1);
        $form->setTaille("dia_occ_sol_su_verger", 1);
        $form->setTaille("dia_occ_sol_su_vigne", 1);
        $form->setTaille("dia_occ_sol_su_bois", 1);
        $form->setTaille("dia_occ_sol_su_lande", 1);
        $form->setTaille("dia_occ_sol_su_carriere", 1);
        $form->setTaille("dia_occ_sol_su_eau_cadastree", 1);
        $form->setTaille("dia_occ_sol_su_jardin", 1);
        $form->setTaille("dia_occ_sol_su_terr_batir", 1);
        $form->setTaille("dia_occ_sol_su_terr_agr", 1);
        $form->setTaille("dia_occ_sol_su_sol", 1);
        $form->setTaille("dia_bati_vend_tot", 1);
        $form->setTaille("dia_bati_vend_tot_txt", 1);
        $form->setTaille("dia_su_co_sol", 1);
        $form->setTaille("dia_su_util_hab", 1);
        $form->setTaille("dia_nb_niv", 1);
        $form->setTaille("dia_nb_appart", 1);
        $form->setTaille("dia_nb_autre_loc", 1);
        $form->setTaille("dia_vente_lot_volume", 1);
        $form->setTaille("dia_vente_lot_volume_txt", 1);
        $form->setTaille("dia_lot_nat_su", 1);
        $form->setTaille("dia_lot_bat_achv_plus_10", 1);
        $form->setTaille("dia_lot_bat_achv_moins_10", 1);
        $form->setTaille("dia_lot_regl_copro_publ_hypo_plus_10", 1);
        $form->setTaille("dia_lot_regl_copro_publ_hypo_moins_10", 1);
        $form->setTaille("dia_indivi_quote_part", 1);
        $form->setTaille("dia_design_societe", 1);
        $form->setTaille("dia_design_droit", 1);
        $form->setTaille("dia_droit_soc_nat", 1);
        $form->setTaille("dia_droit_soc_nb", 1);
        $form->setTaille("dia_droit_soc_num_part", 1);
        $form->setTaille("dia_droit_reel_perso_grevant_bien_oui", 1);
        $form->setTaille("dia_droit_reel_perso_grevant_bien_non", 1);
        $form->setTaille("dia_droit_reel_perso_nat", 1);
        $form->setTaille("dia_droit_reel_perso_viag", 1);
        $form->setTaille("dia_mod_cess_adr", 1);
        $form->setTaille("dia_mod_cess_sign_act_auth", 1);
        $form->setTaille("dia_mod_cess_terme", 1);
        $form->setTaille("dia_mod_cess_terme_prec", 1);
        $form->setTaille("dia_mod_cess_bene_acquereur", 1);
        $form->setTaille("dia_mod_cess_bene_vendeur", 1);
        $form->setTaille("dia_mod_cess_paie_nat", 1);
        $form->setTaille("dia_mod_cess_design_contr_alien", 1);
        $form->setTaille("dia_mod_cess_eval_contr", 1);
        $form->setTaille("dia_mod_cess_rente_viag", 1);
        $form->setTaille("dia_mod_cess_mnt_an", 1);
        $form->setTaille("dia_mod_cess_mnt_compt", 1);
        $form->setTaille("dia_mod_cess_bene_rente", 1);
        $form->setTaille("dia_mod_cess_droit_usa_hab", 1);
        $form->setTaille("dia_mod_cess_droit_usa_hab_prec", 1);
        $form->setTaille("dia_mod_cess_eval_usa_usufruit", 1);
        $form->setTaille("dia_mod_cess_vente_nue_prop", 1);
        $form->setTaille("dia_mod_cess_vente_nue_prop_prec", 1);
        $form->setTaille("dia_mod_cess_echange", 1);
        $form->setTaille("dia_mod_cess_design_bien_recus_ech", 1);
        $form->setTaille("dia_mod_cess_mnt_soulte", 1);
        $form->setTaille("dia_mod_cess_prop_contre_echan", 1);
        $form->setTaille("dia_mod_cess_apport_societe", 1);
        $form->setTaille("dia_mod_cess_bene", 1);
        $form->setTaille("dia_mod_cess_esti_bien", 1);
        $form->setTaille("dia_mod_cess_cess_terr_loc_co", 1);
        $form->setTaille("dia_mod_cess_esti_terr", 1);
        $form->setTaille("dia_mod_cess_esti_loc", 1);
        $form->setTaille("dia_mod_cess_esti_imm_loca", 1);
        $form->setTaille("dia_mod_cess_adju_vol", 1);
        $form->setTaille("dia_mod_cess_adju_obl", 1);
        $form->setTaille("dia_mod_cess_adju_fin_indivi", 1);
        $form->setTaille("dia_mod_cess_adju_date_lieu", 1);
        $form->setTaille("dia_mod_cess_mnt_mise_prix", 1);
        $form->setTaille("dia_prop_titu_prix_indique", 1);
        $form->setTaille("dia_prop_recherche_acqu_prix_indique", 1);
        $form->setTaille("dia_acquereur_prof", 1);
        $form->setTaille("dia_indic_compl_ope", 1);
        $form->setTaille("dia_vente_adju", 1);
        $form->setTaille("am_terr_res_demon", 1);
        $form->setTaille("am_air_terr_res_mob", 1);
        $form->setTaille("ctx_objet_recours", 1);
        $form->setTaille("ctx_moyen_souleve", 1);
        $form->setTaille("ctx_moyen_retenu_juge", 1);
        $form->setTaille("ctx_reference_sagace", 1);
        $form->setTaille("ctx_nature_travaux_infra_om_html", 1);
        $form->setTaille("ctx_synthese_nti", 1);
        $form->setTaille("ctx_article_non_resp_om_html", 1);
        $form->setTaille("ctx_synthese_anr", 1);
        $form->setTaille("ctx_reference_parquet", 1);
        $form->setTaille("ctx_element_taxation", 1);
        $form->setTaille("ctx_infraction", 1);
        $form->setTaille("ctx_regularisable", 1);
        $form->setTaille("ctx_reference_courrier", 1);
        $form->setTaille("ctx_date_audience", 1);
        $form->setTaille("ctx_date_ajournement", 1);
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
        $form->setTaille("mtn_exo_ta_part_commu", 1);
        $form->setTaille("mtn_exo_ta_part_depart", 1);
        $form->setTaille("mtn_exo_ta_part_reg", 1);
        $form->setTaille("mtn_exo_rap", 1);
        $form->setTaille("dpc_type", 1);
        $form->setTaille("dpc_desc_actv_ex", 1);
        $form->setTaille("dpc_desc_ca", 1);
        $form->setTaille("dpc_desc_aut_prec", 1);
        $form->setTaille("dpc_desig_comm_arti", 1);
        $form->setTaille("dpc_desig_loc_hab", 1);
        $form->setTaille("dpc_desig_loc_ann", 1);
        $form->setTaille("dpc_desig_loc_ann_prec", 1);
        $form->setTaille("dpc_bail_comm_date", 1);
        $form->setTaille("dpc_bail_comm_loyer", 1);
        $form->setTaille("dpc_actv_acqu", 1);
        $form->setTaille("dpc_nb_sala_di", 1);
        $form->setTaille("dpc_nb_sala_dd", 1);
        $form->setTaille("dpc_nb_sala_tc", 1);
        $form->setTaille("dpc_nb_sala_tp", 1);
        $form->setTaille("dpc_moda_cess_vente_am", 1);
        $form->setTaille("dpc_moda_cess_adj", 1);
        $form->setTaille("dpc_moda_cess_prix", 1);
        $form->setTaille("dpc_moda_cess_adj_date", 1);
        $form->setTaille("dpc_moda_cess_adj_prec", 1);
        $form->setTaille("dpc_moda_cess_paie_comp", 1);
        $form->setTaille("dpc_moda_cess_paie_terme", 1);
        $form->setTaille("dpc_moda_cess_paie_terme_prec", 1);
        $form->setTaille("dpc_moda_cess_paie_nat", 1);
        $form->setTaille("dpc_moda_cess_paie_nat_desig_alien", 1);
        $form->setTaille("dpc_moda_cess_paie_nat_desig_alien_prec", 1);
        $form->setTaille("dpc_moda_cess_paie_nat_eval", 1);
        $form->setTaille("dpc_moda_cess_paie_nat_eval_prec", 1);
        $form->setTaille("dpc_moda_cess_paie_aut", 1);
        $form->setTaille("dpc_moda_cess_paie_aut_prec", 1);
        $form->setTaille("dpc_ss_signe_demande_acqu", 1);
        $form->setTaille("dpc_ss_signe_recher_trouv_acqu", 1);
        $form->setTaille("dpc_notif_adr_prop", 1);
        $form->setTaille("dpc_notif_adr_manda", 1);
        $form->setTaille("dpc_obs", 1);
        $form->setTaille("co_peri_site_patri_remar", 1);
        $form->setTaille("co_abo_monu_hist", 1);
        $form->setTaille("co_inst_ouvr_trav_act_code_envir", 1);
        $form->setTaille("co_trav_auto_env", 1);
        $form->setTaille("co_derog_esp_prot", 1);
        $form->setTaille("ctx_reference_dsj", 1);
        $form->setTaille("co_piscine", 1);
        $form->setTaille("co_fin_lls", 1);
        $form->setTaille("co_fin_aa", 1);
        $form->setTaille("co_fin_ptz", 1);
        $form->setTaille("co_fin_autr", 1);
        $form->setTaille("dia_ss_date", 1);
        $form->setTaille("dia_ss_lieu", 1);
        $form->setTaille("enga_decla_lieu", 1);
        $form->setTaille("enga_decla_date", 1);
        $form->setTaille("co_archi_attest_honneur", 1);
        $form->setTaille("co_bat_niv_dessous_nb", 1);
        $form->setTaille("co_install_classe", 1);
        $form->setTaille("co_derog_innov", 1);
        $form->setTaille("co_avis_abf", 1);
        $form->setTaille("tax_surf_tot_demo", 1);
        $form->setTaille("tax_surf_tax_demo", 1);
        $form->setTaille("tax_terrassement_arch", 1);
        $form->setTaille("tax_adresse_future_numero", 1);
        $form->setTaille("tax_adresse_future_voie", 1);
        $form->setTaille("tax_adresse_future_lieudit", 1);
        $form->setTaille("tax_adresse_future_localite", 1);
        $form->setTaille("tax_adresse_future_cp", 1);
        $form->setTaille("tax_adresse_future_bp", 1);
        $form->setTaille("tax_adresse_future_cedex", 1);
        $form->setTaille("tax_adresse_future_pays", 1);
        $form->setTaille("tax_adresse_future_division", 1);
        $form->setTaille("co_bat_projete", 1);
        $form->setTaille("co_bat_existant", 1);
        $form->setTaille("co_bat_nature", 1);
        $form->setTaille("terr_juri_titul_date", 1);
        $form->setTaille("co_autre_desc", 1);
        $form->setTaille("co_trx_autre", 1);
        $form->setTaille("co_autre", 1);
        $form->setTaille("erp_modif_facades", 1);
        $form->setTaille("erp_trvx_adap", 1);
        $form->setTaille("erp_trvx_adap_numero", 1);
        $form->setTaille("erp_trvx_adap_valid", 1);
        $form->setTaille("erp_prod_dangereux", 1);
        $form->setTaille("co_trav_supp_dessus", 1);
        $form->setTaille("co_trav_supp_dessous", 1);
        $form->setTaille("tax_su_habit_abr_jard_pig_colom", 1);
        $form->setTaille("enga_decla_donnees_nomi_comm", 1);
        $form->setTaille("x1l_legislation", 1);
        $form->setTaille("x1p_precisions", 1);
        $form->setTaille("x1u_raccordement", 1);
        $form->setTaille("x2m_inscritmh", 1);
        $form->setTaille("s1na1_numero", 1);
        $form->setTaille("s1va1_voie", 1);
        $form->setTaille("s1wa1_lieudit", 1);
        $form->setTaille("s1la1_localite", 1);
        $form->setTaille("s1pa1_codepostal", 1);
        $form->setTaille("s1na2_numero", 1);
        $form->setTaille("s1va2_voie", 1);
        $form->setTaille("s1wa2_lieudit", 1);
        $form->setTaille("s1la2_localite", 1);
        $form->setTaille("s1pa2_codepostal", 1);
        $form->setTaille("e3c_certification", 1);
        $form->setTaille("e3a_competence", 1);
        $form->setTaille("a4d_description", 1);
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
        $form->setTaille("u3t_observations", 1);
        $form->setTaille("u1a_voirieoui", 1);
        $form->setTaille("u1v_voirienon", 1);
        $form->setTaille("u1q_voirieconcessionnaire", 1);
        $form->setTaille("u1b_voirieavant", 1);
        $form->setTaille("u1j_eauoui", 1);
        $form->setTaille("u1t_eaunon", 1);
        $form->setTaille("u1e_eauconcessionnaire", 1);
        $form->setTaille("u1k_eauavant", 1);
        $form->setTaille("u1s_assainissementoui", 1);
        $form->setTaille("u1d_assainissementnon", 1);
        $form->setTaille("u1l_assainissementconcessionnaire", 1);
        $form->setTaille("u1r_assainissementavant", 1);
        $form->setTaille("u1c_electriciteoui", 1);
        $form->setTaille("u1u_electricitenon", 1);
        $form->setTaille("u1m_electriciteconcessionnaire", 1);
        $form->setTaille("u1f_electriciteavant", 1);
        $form->setTaille("u2a_observations", 1);
        $form->setTaille("f1ts4_surftaxestation", 1);
        $form->setTaille("f1ut1_surfcree", 1);
        $form->setTaille("f9d_date", 1);
        $form->setTaille("f9n_nom", 1);
        $form->setTaille("dia_droit_reel_perso_grevant_bien_desc", 1);
        $form->setTaille("dia_mod_cess_paie_nat_desc", 1);
        $form->setTaille("dia_mod_cess_rente_viag_desc", 1);
        $form->setTaille("dia_mod_cess_echange_desc", 1);
        $form->setTaille("dia_mod_cess_apport_societe_desc", 1);
        $form->setTaille("dia_mod_cess_cess_terr_loc_co_desc", 1);
        $form->setTaille("dia_mod_cess_esti_imm_loca_desc", 1);
        $form->setTaille("dia_mod_cess_adju_obl_desc", 1);
        $form->setTaille("dia_mod_cess_adju_fin_indivi_desc", 1);
        $form->setTaille("dia_cadre_titul_droit_prempt", 1);
        $form->setTaille("dia_mairie_prix_moyen", 1);
        $form->setTaille("dia_propri_indivi", 1);
        $form->setTaille("dia_situa_bien_plan_cadas_oui", 1);
        $form->setTaille("dia_situa_bien_plan_cadas_non", 1);
        $form->setTaille("dia_notif_dec_titul_adr_prop", 1);
        $form->setTaille("dia_notif_dec_titul_adr_prop_desc", 1);
        $form->setTaille("dia_notif_dec_titul_adr_manda", 1);
        $form->setTaille("dia_notif_dec_titul_adr_manda_desc", 1);
        $form->setTaille("dia_dia_dpu", 1);
        $form->setTaille("dia_dia_zad", 1);
        $form->setTaille("dia_dia_zone_preempt_esp_natu_sensi", 1);
        $form->setTaille("dia_dab_dpu", 1);
        $form->setTaille("dia_dab_zad", 1);
        $form->setTaille("dia_mod_cess_commi_mnt", 1);
        $form->setTaille("dia_mod_cess_commi_mnt_ttc", 1);
        $form->setTaille("dia_mod_cess_commi_mnt_ht", 1);
        $form->setTaille("dia_mod_cess_prix_vente_num", 1);
        $form->setTaille("dia_mod_cess_prix_vente_mob_num", 1);
        $form->setTaille("dia_mod_cess_prix_vente_cheptel_num", 1);
        $form->setTaille("dia_mod_cess_prix_vente_recol_num", 1);
        $form->setTaille("dia_mod_cess_prix_vente_autre_num", 1);
        $form->setTaille("dia_su_co_sol_num", 1);
        $form->setTaille("dia_su_util_hab_num", 1);
        $form->setTaille("dia_mod_cess_mnt_an_num", 1);
        $form->setTaille("dia_mod_cess_mnt_compt_num", 1);
        $form->setTaille("dia_mod_cess_mnt_soulte_num", 1);
        $form->setTaille("dia_comp_prix_vente", 1);
        $form->setTaille("dia_comp_surface", 1);
        $form->setTaille("dia_comp_total_frais", 1);
        $form->setTaille("dia_comp_mtn_total", 1);
        $form->setTaille("dia_comp_valeur_m2", 1);
        $form->setTaille("dia_esti_prix_france_dom", 1);
        $form->setTaille("dia_prop_collectivite", 1);
        $form->setTaille("dia_delegataire_denomination", 1);
        $form->setTaille("dia_delegataire_raison_sociale", 1);
        $form->setTaille("dia_delegataire_siret", 1);
        $form->setTaille("dia_delegataire_categorie_juridique", 1);
        $form->setTaille("dia_delegataire_representant_nom", 1);
        $form->setTaille("dia_delegataire_representant_prenom", 1);
        $form->setTaille("dia_delegataire_adresse_numero", 1);
        $form->setTaille("dia_delegataire_adresse_voie", 1);
        $form->setTaille("dia_delegataire_adresse_complement", 1);
        $form->setTaille("dia_delegataire_adresse_lieu_dit", 1);
        $form->setTaille("dia_delegataire_adresse_localite", 1);
        $form->setTaille("dia_delegataire_adresse_code_postal", 1);
        $form->setTaille("dia_delegataire_adresse_bp", 1);
        $form->setTaille("dia_delegataire_adresse_cedex", 1);
        $form->setTaille("dia_delegataire_adresse_pays", 1);
        $form->setTaille("dia_delegataire_telephone_fixe", 1);
        $form->setTaille("dia_delegataire_telephone_mobile", 1);
        $form->setTaille("dia_delegataire_telephone_mobile_indicatif", 1);
        $form->setTaille("dia_delegataire_courriel", 1);
        $form->setTaille("dia_delegataire_fax", 1);
        $form->setTaille("dia_entree_jouissance_type", 1);
        $form->setTaille("dia_entree_jouissance_date", 1);
        $form->setTaille("dia_entree_jouissance_date_effet", 1);
        $form->setTaille("dia_entree_jouissance_com", 1);
        $form->setTaille("dia_remise_bien_date_effet", 1);
        $form->setTaille("dia_remise_bien_com", 1);
        $form->setTaille("c2zp1_crete", 1);
        $form->setTaille("c2zr1_destination", 1);
        $form->setTaille("mh_design_appel_denom", 1);
        $form->setTaille("mh_design_type_protect", 1);
        $form->setTaille("mh_design_elem_prot", 1);
        $form->setTaille("mh_design_ref_merimee_palissy", 1);
        $form->setTaille("mh_design_nature_prop", 1);
        $form->setTaille("mh_loc_denom", 1);
        $form->setTaille("mh_pres_intitule", 1);
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
        $form->setTaille("mh_trav_cat_12_prec", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("cerfa", 11);
        $form->setMax("libelle", 200);
        $form->setMax("code", 20);
        $form->setMax("om_validite_debut", 12);
        $form->setMax("om_validite_fin", 12);
        $form->setMax("am_lotiss", 1);
        $form->setMax("am_autre_div", 1);
        $form->setMax("am_camping", 1);
        $form->setMax("am_caravane", 1);
        $form->setMax("am_carav_duree", 1);
        $form->setMax("am_statio", 1);
        $form->setMax("am_statio_cont", 1);
        $form->setMax("am_affou_exhau", 1);
        $form->setMax("am_affou_exhau_sup", 1);
        $form->setMax("am_affou_prof", 1);
        $form->setMax("am_exhau_haut", 1);
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
        $form->setMax("am_projet_desc", 1);
        $form->setMax("am_terr_surf", 1);
        $form->setMax("am_tranche_desc", 1);
        $form->setMax("am_lot_max_nb", 1);
        $form->setMax("am_lot_max_shon", 1);
        $form->setMax("am_lot_cstr_cos", 1);
        $form->setMax("am_lot_cstr_plan", 1);
        $form->setMax("am_lot_cstr_vente", 1);
        $form->setMax("am_lot_fin_diff", 1);
        $form->setMax("am_lot_consign", 1);
        $form->setMax("am_lot_gar_achev", 1);
        $form->setMax("am_lot_vente_ant", 1);
        $form->setMax("am_empl_nb", 1);
        $form->setMax("am_tente_nb", 1);
        $form->setMax("am_carav_nb", 1);
        $form->setMax("am_mobil_nb", 1);
        $form->setMax("am_pers_nb", 1);
        $form->setMax("am_empl_hll_nb", 1);
        $form->setMax("am_hll_shon", 1);
        $form->setMax("am_periode_exploit", 1);
        $form->setMax("am_exist_agrand", 1);
        $form->setMax("am_exist_date", 1);
        $form->setMax("am_exist_num", 1);
        $form->setMax("am_exist_nb_avant", 1);
        $form->setMax("am_exist_nb_apres", 1);
        $form->setMax("am_coupe_bois", 1);
        $form->setMax("am_coupe_parc", 1);
        $form->setMax("am_coupe_align", 1);
        $form->setMax("am_coupe_ess", 1);
        $form->setMax("am_coupe_age", 1);
        $form->setMax("am_coupe_dens", 1);
        $form->setMax("am_coupe_qual", 1);
        $form->setMax("am_coupe_trait", 1);
        $form->setMax("am_coupe_autr", 1);
        $form->setMax("co_archi_recours", 1);
        $form->setMax("co_cstr_nouv", 1);
        $form->setMax("co_cstr_exist", 1);
        $form->setMax("co_cloture", 1);
        $form->setMax("co_elec_tension", 1);
        $form->setMax("co_div_terr", 1);
        $form->setMax("co_projet_desc", 1);
        $form->setMax("co_anx_pisc", 1);
        $form->setMax("co_anx_gara", 1);
        $form->setMax("co_anx_veran", 1);
        $form->setMax("co_anx_abri", 1);
        $form->setMax("co_anx_autr", 1);
        $form->setMax("co_anx_autr_desc", 1);
        $form->setMax("co_tot_log_nb", 1);
        $form->setMax("co_tot_ind_nb", 1);
        $form->setMax("co_tot_coll_nb", 1);
        $form->setMax("co_mais_piece_nb", 1);
        $form->setMax("co_mais_niv_nb", 1);
        $form->setMax("co_fin_lls_nb", 1);
        $form->setMax("co_fin_aa_nb", 1);
        $form->setMax("co_fin_ptz_nb", 1);
        $form->setMax("co_fin_autr_nb", 1);
        $form->setMax("co_fin_autr_desc", 1);
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
        $form->setMax("co_resid_autr_desc", 1);
        $form->setMax("co_foyer_chamb_nb", 1);
        $form->setMax("co_log_1p_nb", 1);
        $form->setMax("co_log_2p_nb", 1);
        $form->setMax("co_log_3p_nb", 1);
        $form->setMax("co_log_4p_nb", 1);
        $form->setMax("co_log_5p_nb", 1);
        $form->setMax("co_log_6p_nb", 1);
        $form->setMax("co_bat_niv_nb", 1);
        $form->setMax("co_trx_exten", 1);
        $form->setMax("co_trx_surelev", 1);
        $form->setMax("co_trx_nivsup", 1);
        $form->setMax("co_demont_periode", 1);
        $form->setMax("co_sp_transport", 1);
        $form->setMax("co_sp_enseign", 1);
        $form->setMax("co_sp_act_soc", 1);
        $form->setMax("co_sp_ouvr_spe", 1);
        $form->setMax("co_sp_sante", 1);
        $form->setMax("co_sp_culture", 1);
        $form->setMax("co_statio_avt_nb", 1);
        $form->setMax("co_statio_apr_nb", 1);
        $form->setMax("co_statio_adr", 1);
        $form->setMax("co_statio_place_nb", 1);
        $form->setMax("co_statio_tot_surf", 1);
        $form->setMax("co_statio_tot_shob", 1);
        $form->setMax("co_statio_comm_cin_surf", 1);
        $form->setMax("tab_surface", 11);
        $form->setMax("dm_constr_dates", 1);
        $form->setMax("dm_total", 1);
        $form->setMax("dm_partiel", 1);
        $form->setMax("dm_projet_desc", 1);
        $form->setMax("dm_tot_log_nb", 1);
        $form->setMax("tax_surf_tot", 1);
        $form->setMax("tax_surf", 1);
        $form->setMax("tax_surf_suppr_mod", 1);
        $form->setMax("tab_tax_su_princ", 11);
        $form->setMax("tab_tax_su_heber", 11);
        $form->setMax("tab_tax_su_secon", 11);
        $form->setMax("tab_tax_su_tot", 11);
        $form->setMax("tax_ext_pret", 1);
        $form->setMax("tax_ext_desc", 1);
        $form->setMax("tax_surf_tax_exist_cons", 1);
        $form->setMax("tax_log_exist_nb", 1);
        $form->setMax("tax_trx_presc_ppr", 1);
        $form->setMax("tax_monu_hist", 1);
        $form->setMax("tax_comm_nb", 1);
        $form->setMax("tab_tax_su_non_habit_surf", 11);
        $form->setMax("tab_tax_am", 11);
        $form->setMax("vsd_surf_planch_smd", 1);
        $form->setMax("vsd_unit_fonc_sup", 1);
        $form->setMax("vsd_unit_fonc_constr_sup", 1);
        $form->setMax("vsd_val_terr", 1);
        $form->setMax("vsd_const_sxist_non_dem_surf", 1);
        $form->setMax("vsd_rescr_fisc", 1);
        $form->setMax("pld_val_terr", 1);
        $form->setMax("pld_const_exist_dem", 1);
        $form->setMax("pld_const_exist_dem_surf", 1);
        $form->setMax("code_cnil", 1);
        $form->setMax("terr_juri_titul", 1);
        $form->setMax("terr_juri_lot", 1);
        $form->setMax("terr_juri_zac", 1);
        $form->setMax("terr_juri_afu", 1);
        $form->setMax("terr_juri_pup", 1);
        $form->setMax("terr_juri_oin", 1);
        $form->setMax("terr_juri_desc", 1);
        $form->setMax("terr_div_surf_etab", 1);
        $form->setMax("terr_div_surf_av_div", 1);
        $form->setMax("doc_date", 1);
        $form->setMax("doc_tot_trav", 1);
        $form->setMax("doc_tranche_trav", 1);
        $form->setMax("doc_tranche_trav_desc", 1);
        $form->setMax("doc_surf", 1);
        $form->setMax("doc_nb_log", 1);
        $form->setMax("doc_nb_log_indiv", 1);
        $form->setMax("doc_nb_log_coll", 1);
        $form->setMax("doc_nb_log_lls", 1);
        $form->setMax("doc_nb_log_aa", 1);
        $form->setMax("doc_nb_log_ptz", 1);
        $form->setMax("doc_nb_log_autre", 1);
        $form->setMax("daact_date", 1);
        $form->setMax("daact_date_chgmt_dest", 1);
        $form->setMax("daact_tot_trav", 1);
        $form->setMax("daact_tranche_trav", 1);
        $form->setMax("daact_tranche_trav_desc", 1);
        $form->setMax("daact_surf", 1);
        $form->setMax("daact_nb_log", 1);
        $form->setMax("daact_nb_log_indiv", 1);
        $form->setMax("daact_nb_log_coll", 1);
        $form->setMax("daact_nb_log_lls", 1);
        $form->setMax("daact_nb_log_aa", 1);
        $form->setMax("daact_nb_log_ptz", 1);
        $form->setMax("daact_nb_log_autre", 1);
        $form->setMax("am_div_mun", 1);
        $form->setMax("co_perf_energ", 1);
        $form->setMax("architecte", 1);
        $form->setMax("co_statio_avt_shob", 1);
        $form->setMax("co_statio_apr_shob", 1);
        $form->setMax("co_statio_avt_surf", 1);
        $form->setMax("co_statio_apr_surf", 1);
        $form->setMax("co_trx_amgt", 1);
        $form->setMax("co_modif_aspect", 1);
        $form->setMax("co_modif_struct", 1);
        $form->setMax("co_ouvr_elec", 1);
        $form->setMax("co_ouvr_infra", 1);
        $form->setMax("co_trx_imm", 1);
        $form->setMax("co_cstr_shob", 1);
        $form->setMax("am_voyage_deb", 1);
        $form->setMax("am_voyage_fin", 1);
        $form->setMax("am_modif_amgt", 1);
        $form->setMax("am_lot_max_shob", 1);
        $form->setMax("mod_desc", 1);
        $form->setMax("tr_total", 1);
        $form->setMax("tr_partiel", 1);
        $form->setMax("tr_desc", 1);
        $form->setMax("avap_co_elt_pro", 1);
        $form->setMax("avap_nouv_haut_surf", 1);
        $form->setMax("avap_co_clot", 1);
        $form->setMax("avap_aut_coup_aba_arb", 1);
        $form->setMax("avap_ouv_infra", 1);
        $form->setMax("avap_aut_inst_mob", 1);
        $form->setMax("avap_aut_plant", 1);
        $form->setMax("avap_aut_auv_elec", 1);
        $form->setMax("tax_dest_loc_tr", 1);
        $form->setMax("ope_proj_desc", 1);
        $form->setMax("tax_surf_tot_cstr", 1);
        $form->setMax("tax_surf_loc_stat", 1);
        $form->setMax("tax_log_ap_trvx_nb", 1);
        $form->setMax("tax_am_statio_ext_cr", 1);
        $form->setMax("tax_sup_bass_pisc_cr", 1);
        $form->setMax("tax_empl_ten_carav_mobil_nb_cr", 1);
        $form->setMax("tax_empl_hll_nb_cr", 1);
        $form->setMax("tax_eol_haut_nb_cr", 1);
        $form->setMax("tax_pann_volt_sup_cr", 1);
        $form->setMax("tax_surf_loc_arch", 1);
        $form->setMax("tax_surf_pisc_arch", 1);
        $form->setMax("tax_am_statio_ext_arch", 1);
        $form->setMax("tab_tax_su_parc_statio_expl_comm", 11);
        $form->setMax("tax_empl_ten_carav_mobil_nb_arch", 1);
        $form->setMax("tax_empl_hll_nb_arch", 1);
        $form->setMax("tax_eol_haut_nb_arch", 1);
        $form->setMax("ope_proj_div_co", 1);
        $form->setMax("ope_proj_div_contr", 1);
        $form->setMax("tax_desc", 1);
        $form->setMax("erp_cstr_neuve", 1);
        $form->setMax("erp_trvx_acc", 1);
        $form->setMax("erp_extension", 1);
        $form->setMax("erp_rehab", 1);
        $form->setMax("erp_trvx_am", 1);
        $form->setMax("erp_vol_nouv_exist", 1);
        $form->setMax("tab_erp_eff", 11);
        $form->setMax("erp_class_cat", 1);
        $form->setMax("erp_class_type", 1);
        $form->setMax("tax_surf_abr_jard_pig_colom", 1);
        $form->setMax("tax_su_non_habit_abr_jard_pig_colom", 1);
        $form->setMax("dia_imm_non_bati", 1);
        $form->setMax("dia_imm_bati_terr_propr", 1);
        $form->setMax("dia_imm_bati_terr_autr", 1);
        $form->setMax("dia_imm_bati_terr_autr_desc", 1);
        $form->setMax("dia_bat_copro", 1);
        $form->setMax("dia_bat_copro_desc", 1);
        $form->setMax("dia_lot_numero", 1);
        $form->setMax("dia_lot_bat", 1);
        $form->setMax("dia_lot_etage", 1);
        $form->setMax("dia_lot_quote_part", 1);
        $form->setMax("dia_us_hab", 1);
        $form->setMax("dia_us_pro", 1);
        $form->setMax("dia_us_mixte", 1);
        $form->setMax("dia_us_comm", 1);
        $form->setMax("dia_us_agr", 1);
        $form->setMax("dia_us_autre", 1);
        $form->setMax("dia_us_autre_prec", 1);
        $form->setMax("dia_occ_prop", 1);
        $form->setMax("dia_occ_loc", 1);
        $form->setMax("dia_occ_sans_occ", 1);
        $form->setMax("dia_occ_autre", 1);
        $form->setMax("dia_occ_autre_prec", 1);
        $form->setMax("dia_mod_cess_prix_vente", 1);
        $form->setMax("dia_mod_cess_prix_vente_mob", 1);
        $form->setMax("dia_mod_cess_prix_vente_cheptel", 1);
        $form->setMax("dia_mod_cess_prix_vente_recol", 1);
        $form->setMax("dia_mod_cess_prix_vente_autre", 1);
        $form->setMax("dia_mod_cess_commi", 1);
        $form->setMax("dia_mod_cess_commi_ttc", 1);
        $form->setMax("dia_mod_cess_commi_ht", 1);
        $form->setMax("dia_acquereur_nom_prenom", 1);
        $form->setMax("dia_acquereur_adr_num_voie", 1);
        $form->setMax("dia_acquereur_adr_ext", 1);
        $form->setMax("dia_acquereur_adr_type_voie", 1);
        $form->setMax("dia_acquereur_adr_nom_voie", 1);
        $form->setMax("dia_acquereur_adr_lieu_dit_bp", 1);
        $form->setMax("dia_acquereur_adr_cp", 1);
        $form->setMax("dia_acquereur_adr_localite", 1);
        $form->setMax("dia_observation", 1);
        $form->setMax("tab_surface2", 11);
        $form->setMax("dia_occ_sol_su_terre", 1);
        $form->setMax("dia_occ_sol_su_pres", 1);
        $form->setMax("dia_occ_sol_su_verger", 1);
        $form->setMax("dia_occ_sol_su_vigne", 1);
        $form->setMax("dia_occ_sol_su_bois", 1);
        $form->setMax("dia_occ_sol_su_lande", 1);
        $form->setMax("dia_occ_sol_su_carriere", 1);
        $form->setMax("dia_occ_sol_su_eau_cadastree", 1);
        $form->setMax("dia_occ_sol_su_jardin", 1);
        $form->setMax("dia_occ_sol_su_terr_batir", 1);
        $form->setMax("dia_occ_sol_su_terr_agr", 1);
        $form->setMax("dia_occ_sol_su_sol", 1);
        $form->setMax("dia_bati_vend_tot", 1);
        $form->setMax("dia_bati_vend_tot_txt", 1);
        $form->setMax("dia_su_co_sol", 1);
        $form->setMax("dia_su_util_hab", 1);
        $form->setMax("dia_nb_niv", 1);
        $form->setMax("dia_nb_appart", 1);
        $form->setMax("dia_nb_autre_loc", 1);
        $form->setMax("dia_vente_lot_volume", 1);
        $form->setMax("dia_vente_lot_volume_txt", 1);
        $form->setMax("dia_lot_nat_su", 1);
        $form->setMax("dia_lot_bat_achv_plus_10", 1);
        $form->setMax("dia_lot_bat_achv_moins_10", 1);
        $form->setMax("dia_lot_regl_copro_publ_hypo_plus_10", 1);
        $form->setMax("dia_lot_regl_copro_publ_hypo_moins_10", 1);
        $form->setMax("dia_indivi_quote_part", 1);
        $form->setMax("dia_design_societe", 1);
        $form->setMax("dia_design_droit", 1);
        $form->setMax("dia_droit_soc_nat", 1);
        $form->setMax("dia_droit_soc_nb", 1);
        $form->setMax("dia_droit_soc_num_part", 1);
        $form->setMax("dia_droit_reel_perso_grevant_bien_oui", 1);
        $form->setMax("dia_droit_reel_perso_grevant_bien_non", 1);
        $form->setMax("dia_droit_reel_perso_nat", 1);
        $form->setMax("dia_droit_reel_perso_viag", 1);
        $form->setMax("dia_mod_cess_adr", 1);
        $form->setMax("dia_mod_cess_sign_act_auth", 1);
        $form->setMax("dia_mod_cess_terme", 1);
        $form->setMax("dia_mod_cess_terme_prec", 1);
        $form->setMax("dia_mod_cess_bene_acquereur", 1);
        $form->setMax("dia_mod_cess_bene_vendeur", 1);
        $form->setMax("dia_mod_cess_paie_nat", 1);
        $form->setMax("dia_mod_cess_design_contr_alien", 1);
        $form->setMax("dia_mod_cess_eval_contr", 1);
        $form->setMax("dia_mod_cess_rente_viag", 1);
        $form->setMax("dia_mod_cess_mnt_an", 1);
        $form->setMax("dia_mod_cess_mnt_compt", 1);
        $form->setMax("dia_mod_cess_bene_rente", 1);
        $form->setMax("dia_mod_cess_droit_usa_hab", 1);
        $form->setMax("dia_mod_cess_droit_usa_hab_prec", 1);
        $form->setMax("dia_mod_cess_eval_usa_usufruit", 1);
        $form->setMax("dia_mod_cess_vente_nue_prop", 1);
        $form->setMax("dia_mod_cess_vente_nue_prop_prec", 1);
        $form->setMax("dia_mod_cess_echange", 1);
        $form->setMax("dia_mod_cess_design_bien_recus_ech", 1);
        $form->setMax("dia_mod_cess_mnt_soulte", 1);
        $form->setMax("dia_mod_cess_prop_contre_echan", 1);
        $form->setMax("dia_mod_cess_apport_societe", 1);
        $form->setMax("dia_mod_cess_bene", 1);
        $form->setMax("dia_mod_cess_esti_bien", 1);
        $form->setMax("dia_mod_cess_cess_terr_loc_co", 1);
        $form->setMax("dia_mod_cess_esti_terr", 1);
        $form->setMax("dia_mod_cess_esti_loc", 1);
        $form->setMax("dia_mod_cess_esti_imm_loca", 1);
        $form->setMax("dia_mod_cess_adju_vol", 1);
        $form->setMax("dia_mod_cess_adju_obl", 1);
        $form->setMax("dia_mod_cess_adju_fin_indivi", 1);
        $form->setMax("dia_mod_cess_adju_date_lieu", 1);
        $form->setMax("dia_mod_cess_mnt_mise_prix", 1);
        $form->setMax("dia_prop_titu_prix_indique", 1);
        $form->setMax("dia_prop_recherche_acqu_prix_indique", 1);
        $form->setMax("dia_acquereur_prof", 1);
        $form->setMax("dia_indic_compl_ope", 1);
        $form->setMax("dia_vente_adju", 1);
        $form->setMax("am_terr_res_demon", 1);
        $form->setMax("am_air_terr_res_mob", 1);
        $form->setMax("ctx_objet_recours", 1);
        $form->setMax("ctx_moyen_souleve", 1);
        $form->setMax("ctx_moyen_retenu_juge", 1);
        $form->setMax("ctx_reference_sagace", 1);
        $form->setMax("ctx_nature_travaux_infra_om_html", 1);
        $form->setMax("ctx_synthese_nti", 1);
        $form->setMax("ctx_article_non_resp_om_html", 1);
        $form->setMax("ctx_synthese_anr", 1);
        $form->setMax("ctx_reference_parquet", 1);
        $form->setMax("ctx_element_taxation", 1);
        $form->setMax("ctx_infraction", 1);
        $form->setMax("ctx_regularisable", 1);
        $form->setMax("ctx_reference_courrier", 1);
        $form->setMax("ctx_date_audience", 1);
        $form->setMax("ctx_date_ajournement", 1);
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
        $form->setMax("mtn_exo_ta_part_commu", 1);
        $form->setMax("mtn_exo_ta_part_depart", 1);
        $form->setMax("mtn_exo_ta_part_reg", 1);
        $form->setMax("mtn_exo_rap", 1);
        $form->setMax("dpc_type", 1);
        $form->setMax("dpc_desc_actv_ex", 1);
        $form->setMax("dpc_desc_ca", 1);
        $form->setMax("dpc_desc_aut_prec", 1);
        $form->setMax("dpc_desig_comm_arti", 1);
        $form->setMax("dpc_desig_loc_hab", 1);
        $form->setMax("dpc_desig_loc_ann", 1);
        $form->setMax("dpc_desig_loc_ann_prec", 1);
        $form->setMax("dpc_bail_comm_date", 1);
        $form->setMax("dpc_bail_comm_loyer", 1);
        $form->setMax("dpc_actv_acqu", 1);
        $form->setMax("dpc_nb_sala_di", 1);
        $form->setMax("dpc_nb_sala_dd", 1);
        $form->setMax("dpc_nb_sala_tc", 1);
        $form->setMax("dpc_nb_sala_tp", 1);
        $form->setMax("dpc_moda_cess_vente_am", 1);
        $form->setMax("dpc_moda_cess_adj", 1);
        $form->setMax("dpc_moda_cess_prix", 1);
        $form->setMax("dpc_moda_cess_adj_date", 1);
        $form->setMax("dpc_moda_cess_adj_prec", 1);
        $form->setMax("dpc_moda_cess_paie_comp", 1);
        $form->setMax("dpc_moda_cess_paie_terme", 1);
        $form->setMax("dpc_moda_cess_paie_terme_prec", 1);
        $form->setMax("dpc_moda_cess_paie_nat", 1);
        $form->setMax("dpc_moda_cess_paie_nat_desig_alien", 1);
        $form->setMax("dpc_moda_cess_paie_nat_desig_alien_prec", 1);
        $form->setMax("dpc_moda_cess_paie_nat_eval", 1);
        $form->setMax("dpc_moda_cess_paie_nat_eval_prec", 1);
        $form->setMax("dpc_moda_cess_paie_aut", 1);
        $form->setMax("dpc_moda_cess_paie_aut_prec", 1);
        $form->setMax("dpc_ss_signe_demande_acqu", 1);
        $form->setMax("dpc_ss_signe_recher_trouv_acqu", 1);
        $form->setMax("dpc_notif_adr_prop", 1);
        $form->setMax("dpc_notif_adr_manda", 1);
        $form->setMax("dpc_obs", 1);
        $form->setMax("co_peri_site_patri_remar", 1);
        $form->setMax("co_abo_monu_hist", 1);
        $form->setMax("co_inst_ouvr_trav_act_code_envir", 1);
        $form->setMax("co_trav_auto_env", 1);
        $form->setMax("co_derog_esp_prot", 1);
        $form->setMax("ctx_reference_dsj", 1);
        $form->setMax("co_piscine", 1);
        $form->setMax("co_fin_lls", 1);
        $form->setMax("co_fin_aa", 1);
        $form->setMax("co_fin_ptz", 1);
        $form->setMax("co_fin_autr", 1);
        $form->setMax("dia_ss_date", 1);
        $form->setMax("dia_ss_lieu", 1);
        $form->setMax("enga_decla_lieu", 1);
        $form->setMax("enga_decla_date", 1);
        $form->setMax("co_archi_attest_honneur", 1);
        $form->setMax("co_bat_niv_dessous_nb", 1);
        $form->setMax("co_install_classe", 1);
        $form->setMax("co_derog_innov", 1);
        $form->setMax("co_avis_abf", 1);
        $form->setMax("tax_surf_tot_demo", 1);
        $form->setMax("tax_surf_tax_demo", 1);
        $form->setMax("tax_terrassement_arch", 1);
        $form->setMax("tax_adresse_future_numero", 1);
        $form->setMax("tax_adresse_future_voie", 1);
        $form->setMax("tax_adresse_future_lieudit", 1);
        $form->setMax("tax_adresse_future_localite", 1);
        $form->setMax("tax_adresse_future_cp", 1);
        $form->setMax("tax_adresse_future_bp", 1);
        $form->setMax("tax_adresse_future_cedex", 1);
        $form->setMax("tax_adresse_future_pays", 1);
        $form->setMax("tax_adresse_future_division", 1);
        $form->setMax("co_bat_projete", 1);
        $form->setMax("co_bat_existant", 1);
        $form->setMax("co_bat_nature", 1);
        $form->setMax("terr_juri_titul_date", 1);
        $form->setMax("co_autre_desc", 1);
        $form->setMax("co_trx_autre", 1);
        $form->setMax("co_autre", 1);
        $form->setMax("erp_modif_facades", 1);
        $form->setMax("erp_trvx_adap", 1);
        $form->setMax("erp_trvx_adap_numero", 1);
        $form->setMax("erp_trvx_adap_valid", 1);
        $form->setMax("erp_prod_dangereux", 1);
        $form->setMax("co_trav_supp_dessus", 1);
        $form->setMax("co_trav_supp_dessous", 1);
        $form->setMax("tax_su_habit_abr_jard_pig_colom", 1);
        $form->setMax("enga_decla_donnees_nomi_comm", 1);
        $form->setMax("x1l_legislation", 1);
        $form->setMax("x1p_precisions", 1);
        $form->setMax("x1u_raccordement", 1);
        $form->setMax("x2m_inscritmh", 1);
        $form->setMax("s1na1_numero", 1);
        $form->setMax("s1va1_voie", 1);
        $form->setMax("s1wa1_lieudit", 1);
        $form->setMax("s1la1_localite", 1);
        $form->setMax("s1pa1_codepostal", 1);
        $form->setMax("s1na2_numero", 1);
        $form->setMax("s1va2_voie", 1);
        $form->setMax("s1wa2_lieudit", 1);
        $form->setMax("s1la2_localite", 1);
        $form->setMax("s1pa2_codepostal", 1);
        $form->setMax("e3c_certification", 1);
        $form->setMax("e3a_competence", 1);
        $form->setMax("a4d_description", 1);
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
        $form->setMax("u3t_observations", 1);
        $form->setMax("u1a_voirieoui", 1);
        $form->setMax("u1v_voirienon", 1);
        $form->setMax("u1q_voirieconcessionnaire", 1);
        $form->setMax("u1b_voirieavant", 1);
        $form->setMax("u1j_eauoui", 1);
        $form->setMax("u1t_eaunon", 1);
        $form->setMax("u1e_eauconcessionnaire", 1);
        $form->setMax("u1k_eauavant", 1);
        $form->setMax("u1s_assainissementoui", 1);
        $form->setMax("u1d_assainissementnon", 1);
        $form->setMax("u1l_assainissementconcessionnaire", 1);
        $form->setMax("u1r_assainissementavant", 1);
        $form->setMax("u1c_electriciteoui", 1);
        $form->setMax("u1u_electricitenon", 1);
        $form->setMax("u1m_electriciteconcessionnaire", 1);
        $form->setMax("u1f_electriciteavant", 1);
        $form->setMax("u2a_observations", 1);
        $form->setMax("f1ts4_surftaxestation", 1);
        $form->setMax("f1ut1_surfcree", 1);
        $form->setMax("f9d_date", 1);
        $form->setMax("f9n_nom", 1);
        $form->setMax("dia_droit_reel_perso_grevant_bien_desc", 1);
        $form->setMax("dia_mod_cess_paie_nat_desc", 1);
        $form->setMax("dia_mod_cess_rente_viag_desc", 1);
        $form->setMax("dia_mod_cess_echange_desc", 1);
        $form->setMax("dia_mod_cess_apport_societe_desc", 1);
        $form->setMax("dia_mod_cess_cess_terr_loc_co_desc", 1);
        $form->setMax("dia_mod_cess_esti_imm_loca_desc", 1);
        $form->setMax("dia_mod_cess_adju_obl_desc", 1);
        $form->setMax("dia_mod_cess_adju_fin_indivi_desc", 1);
        $form->setMax("dia_cadre_titul_droit_prempt", 1);
        $form->setMax("dia_mairie_prix_moyen", 1);
        $form->setMax("dia_propri_indivi", 1);
        $form->setMax("dia_situa_bien_plan_cadas_oui", 1);
        $form->setMax("dia_situa_bien_plan_cadas_non", 1);
        $form->setMax("dia_notif_dec_titul_adr_prop", 1);
        $form->setMax("dia_notif_dec_titul_adr_prop_desc", 1);
        $form->setMax("dia_notif_dec_titul_adr_manda", 1);
        $form->setMax("dia_notif_dec_titul_adr_manda_desc", 1);
        $form->setMax("dia_dia_dpu", 1);
        $form->setMax("dia_dia_zad", 1);
        $form->setMax("dia_dia_zone_preempt_esp_natu_sensi", 1);
        $form->setMax("dia_dab_dpu", 1);
        $form->setMax("dia_dab_zad", 1);
        $form->setMax("dia_mod_cess_commi_mnt", 1);
        $form->setMax("dia_mod_cess_commi_mnt_ttc", 1);
        $form->setMax("dia_mod_cess_commi_mnt_ht", 1);
        $form->setMax("dia_mod_cess_prix_vente_num", 1);
        $form->setMax("dia_mod_cess_prix_vente_mob_num", 1);
        $form->setMax("dia_mod_cess_prix_vente_cheptel_num", 1);
        $form->setMax("dia_mod_cess_prix_vente_recol_num", 1);
        $form->setMax("dia_mod_cess_prix_vente_autre_num", 1);
        $form->setMax("dia_su_co_sol_num", 1);
        $form->setMax("dia_su_util_hab_num", 1);
        $form->setMax("dia_mod_cess_mnt_an_num", 1);
        $form->setMax("dia_mod_cess_mnt_compt_num", 1);
        $form->setMax("dia_mod_cess_mnt_soulte_num", 1);
        $form->setMax("dia_comp_prix_vente", 1);
        $form->setMax("dia_comp_surface", 1);
        $form->setMax("dia_comp_total_frais", 1);
        $form->setMax("dia_comp_mtn_total", 1);
        $form->setMax("dia_comp_valeur_m2", 1);
        $form->setMax("dia_esti_prix_france_dom", 1);
        $form->setMax("dia_prop_collectivite", 1);
        $form->setMax("dia_delegataire_denomination", 1);
        $form->setMax("dia_delegataire_raison_sociale", 1);
        $form->setMax("dia_delegataire_siret", 1);
        $form->setMax("dia_delegataire_categorie_juridique", 1);
        $form->setMax("dia_delegataire_representant_nom", 1);
        $form->setMax("dia_delegataire_representant_prenom", 1);
        $form->setMax("dia_delegataire_adresse_numero", 1);
        $form->setMax("dia_delegataire_adresse_voie", 1);
        $form->setMax("dia_delegataire_adresse_complement", 1);
        $form->setMax("dia_delegataire_adresse_lieu_dit", 1);
        $form->setMax("dia_delegataire_adresse_localite", 1);
        $form->setMax("dia_delegataire_adresse_code_postal", 1);
        $form->setMax("dia_delegataire_adresse_bp", 1);
        $form->setMax("dia_delegataire_adresse_cedex", 1);
        $form->setMax("dia_delegataire_adresse_pays", 1);
        $form->setMax("dia_delegataire_telephone_fixe", 1);
        $form->setMax("dia_delegataire_telephone_mobile", 1);
        $form->setMax("dia_delegataire_telephone_mobile_indicatif", 1);
        $form->setMax("dia_delegataire_courriel", 1);
        $form->setMax("dia_delegataire_fax", 1);
        $form->setMax("dia_entree_jouissance_type", 1);
        $form->setMax("dia_entree_jouissance_date", 1);
        $form->setMax("dia_entree_jouissance_date_effet", 1);
        $form->setMax("dia_entree_jouissance_com", 1);
        $form->setMax("dia_remise_bien_date_effet", 1);
        $form->setMax("dia_remise_bien_com", 1);
        $form->setMax("c2zp1_crete", 1);
        $form->setMax("c2zr1_destination", 1);
        $form->setMax("mh_design_appel_denom", 1);
        $form->setMax("mh_design_type_protect", 1);
        $form->setMax("mh_design_elem_prot", 1);
        $form->setMax("mh_design_ref_merimee_palissy", 1);
        $form->setMax("mh_design_nature_prop", 1);
        $form->setMax("mh_loc_denom", 1);
        $form->setMax("mh_pres_intitule", 1);
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
        $form->setMax("mh_trav_cat_12_prec", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('cerfa', __('cerfa'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('code', __('code'));
        $form->setLib('om_validite_debut', __('om_validite_debut'));
        $form->setLib('om_validite_fin', __('om_validite_fin'));
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
        $form->setLib('tab_surface', __('tab_surface'));
        $form->setLib('dm_constr_dates', __('dm_constr_dates'));
        $form->setLib('dm_total', __('dm_total'));
        $form->setLib('dm_partiel', __('dm_partiel'));
        $form->setLib('dm_projet_desc', __('dm_projet_desc'));
        $form->setLib('dm_tot_log_nb', __('dm_tot_log_nb'));
        $form->setLib('tax_surf_tot', __('tax_surf_tot'));
        $form->setLib('tax_surf', __('tax_surf'));
        $form->setLib('tax_surf_suppr_mod', __('tax_surf_suppr_mod'));
        $form->setLib('tab_tax_su_princ', __('tab_tax_su_princ'));
        $form->setLib('tab_tax_su_heber', __('tab_tax_su_heber'));
        $form->setLib('tab_tax_su_secon', __('tab_tax_su_secon'));
        $form->setLib('tab_tax_su_tot', __('tab_tax_su_tot'));
        $form->setLib('tax_ext_pret', __('tax_ext_pret'));
        $form->setLib('tax_ext_desc', __('tax_ext_desc'));
        $form->setLib('tax_surf_tax_exist_cons', __('tax_surf_tax_exist_cons'));
        $form->setLib('tax_log_exist_nb', __('tax_log_exist_nb'));
        $form->setLib('tax_trx_presc_ppr', __('tax_trx_presc_ppr'));
        $form->setLib('tax_monu_hist', __('tax_monu_hist'));
        $form->setLib('tax_comm_nb', __('tax_comm_nb'));
        $form->setLib('tab_tax_su_non_habit_surf', __('tab_tax_su_non_habit_surf'));
        $form->setLib('tab_tax_am', __('tab_tax_am'));
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
        $form->setLib('tax_surf_loc_stat', __('tax_surf_loc_stat'));
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
        $form->setLib('tab_tax_su_parc_statio_expl_comm', __('tab_tax_su_parc_statio_expl_comm'));
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
        $form->setLib('tab_erp_eff', __('tab_erp_eff'));
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
        $form->setLib('tab_surface2', __('tab_surface2'));
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
        $form->setLib('ctx_moyen_souleve', __('ctx_moyen_souleve'));
        $form->setLib('ctx_moyen_retenu_juge', __('ctx_moyen_retenu_juge'));
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

    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
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
        // Verification de la cle secondaire : dossier_autorisation_type_detaille
        $this->rechercheTable($this->f->db, "dossier_autorisation_type_detaille", "cerfa", $id);
        // Verification de la cle secondaire : dossier_autorisation_type_detaille
        $this->rechercheTable($this->f->db, "dossier_autorisation_type_detaille", "cerfa_lot", $id);
    }


}
