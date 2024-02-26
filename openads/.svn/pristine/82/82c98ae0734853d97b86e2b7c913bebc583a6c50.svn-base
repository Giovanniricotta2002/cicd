<?php
/**
 * DBFORM - 'donnees_techniques' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id: donnees_techniques.class.php 5856 2016-02-03 11:35:25Z stimezouaght $
 */

require_once ("../gen/obj/donnees_techniques.class.php");

class donnees_techniques extends donnees_techniques_gen {

    var $cerfa;     // Instance de la classe cerfa

    /**
     * Instance de la classe dossier.
     *
     * @var null
     */
    var $inst_dossier = null;

    /**
     * Instance de la classe dossier_autorisation
     *
     * @var null
     */
    var $inst_dossier_autorisation = null;

    /**
     * Instance de la classe lot
     *
     * @var null
     */
    var $inst_lot = null;

    /**
     * Instance de la classe cerfa.
     *
     * @var mixed (resource | null)
     */
    var $inst_cerfa = null;

    /**
     * Instance de la classe taxe_amenagement.
     *
     * @var mixed (resource | null)
     */
    var $inst_taxe_amenagement = null;

    /**
     * Liaison NaN
     */
    var $liaisons_nan = array(
        //
        "lien_donnees_techniques_moyen_souleve" => array(
            "table_l" => "lien_donnees_techniques_moyen_souleve",
            "table_f" => "moyen_souleve",
            "field" => "ctx_moyen_souleve",
        ),
        //
        "lien_donnees_techniques_moyen_retenu_juge" => array(
            "table_l" => "lien_donnees_techniques_moyen_retenu_juge",
            "table_f" => "moyen_retenu_juge",
            "field" => "ctx_moyen_retenu_juge",
        ),
    );

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 001 - modifier
        //
        $this->class_actions[1]["condition"] = "is_editable";

        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["condition"] = "is_deletable";
        
        // ACTION - 003 - consulter
        $this->class_actions[3]["condition"] = "can_user_access_dossier_contexte_modification";

        // ACTION - 004 - action consulter spécifique au contexte de dossier d'autorisation
        $this->class_actions[4] = array(
            "identifier" => "consulter_contexte_da",
            "permission_suffix" => "consulter",
            "crud" => "read",
            "condition" => "can_user_access_dossier_contexte_dossier_autorisation_modification"
        );

        // ACTION - 005 - action consulter spécifique au contexte de lot
        $this->class_actions[5] = array(
            "identifier" => "consulter_contexte_lot",
            "permission_suffix" => "consulter",
            "crud" => "read",
            "condition" => "can_user_access_dossier_contexte_lot_modification"
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "donnees_techniques.donnees_techniques",
            "dossier_instruction",
            "dossier_autorisation",
            "lot",
            "cerfa",

            // Cadre réservé à l’administration / Mairie
            // Dossier transmis
            "m2b_abf",
            "m2j_pn",
            "m2r_cdac",
            "m2r_cnac",
            // État des équipements publics existants
            "u3a_voirieoui",
            "u3f_voirienon",
            "u3c_eauoui",
            "u3h_eaunon",
            "u3g_assainissementoui",
            "u3n_assainissementnon",
            "u3m_electriciteoui",
            "u3b_electricitenon",
            "u3t_observations",
            // État des équipements publics prévu
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

            //Début fieldset 3
            "terr_juri_titul",
            "terr_juri_titul_date",
            "terr_juri_lot",
            "terr_juri_zac",
            "terr_juri_afu",
            "terr_juri_pup",
            "terr_juri_oin",
            "terr_juri_desc",
            "terr_div_surf_etab",
            "terr_div_surf_av_div",
            "ope_proj_desc",
            "ope_proj_div_co",
            "ope_proj_div_contr",

            // ERP
            "erp_class_cat",
            "erp_class_type",
            "erp_cstr_neuve",
            "erp_trvx_acc",
            "erp_extension",
            "erp_rehab",
            "erp_trvx_am",
            "erp_vol_nouv_exist",
            "erp_modif_facades",
            "erp_trvx_adap",
            "erp_trvx_adap_numero",
            "erp_trvx_adap_valid",
            "erp_prod_dangereux",
            "'' as tab_erp_eff",
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

            //Debut premier bloc 4.1
            "am_lotiss",
            "am_div_mun",
            "am_autre_div",
            "am_camping",
            "am_parc_resid_loi",
            "am_sport_moto",
            "am_sport_attrac",
            "am_sport_golf",
            "am_caravane",
            "am_carav_duree",
            "am_statio",
            "am_statio_cont",
            "am_affou_exhau",
            "am_affou_exhau_sup",
            "am_affou_prof",
            "am_exhau_haut",
            "am_terr_res_demon",
            "am_air_terr_res_mob",
            "am_chem_ouv_esp",
            "am_agri_peche",
            "am_crea_voie",
            "am_modif_voie_exist",
            "am_crea_esp_sauv",
            "am_crea_esp_class",
            "am_coupe_abat",
            "am_prot_plu",
            "am_prot_muni",
            "am_mobil_voyage",
            "am_aire_voyage",
            "am_rememb_afu",
            "co_ouvr_infra",
            "am_mob_art",
            "am_modif_voie_esp",
            "am_plant_voie_esp",
            "co_ouvr_elec",

            //Autre champ du premier bloc, ancien cerfa
            "am_projet_desc",
            "am_terr_surf",
            "am_tranche_desc",
            
            //Fin premier bloc

            //Début second bloc 4.2
            "am_lot_max_nb",
            "am_lot_max_shon",
            "am_lot_cstr_cos",
            "am_lot_cstr_plan",
            "am_lot_cstr_vente",
            "am_lot_fin_diff",
            "am_lot_consign",
            "am_lot_gar_achev",
            "am_lot_vente_ant",
            

            //Fin second bloc

            //Début troisième bloc 4.3
            "am_exist_agrand",
            "am_exist_date",
            "am_exist_num",
            "am_exist_nb_avant",
            "am_exist_nb_apres",
            "am_empl_nb",
            "am_tente_nb",
            "am_carav_nb",
            "am_mobil_nb",
            "am_pers_nb",
            "am_empl_hll_nb",
            "am_hll_shon",
            "am_periode_exploit",

            "a4d_description",
            "am_coupe_bois",
            "am_coupe_parc",
            "am_coupe_align",
            "am_coupe_ess",
            "am_coupe_age",
            "am_coupe_dens",
            "am_coupe_qual",
            "am_coupe_trait",
            "am_coupe_autr",


            //Fin troisième bloc
        //Fin premier fieldset
        //
        ////Début second fieldset
            //Début premier bloc 5.1
            "co_archi_recours",
            "architecte",
            "co_archi_attest_honneur",
            //Fin premier bloc

            //Début second bloc 5.2
            "co_cstr_nouv",
            "avap_co_elt_pro",
            "avap_nouv_haut_surf",
            "co_cstr_exist",
            "co_div_terr",
            "co_piscine",
            "co_cloture",
            "co_autre",
            "co_autre_desc",
            "co_projet_desc",
            "co_elec_tension",
            "c2zp1_crete",
            "c2zr1_destination",
            "co_bat_projete",
            "co_bat_existant",
            "co_bat_nature",

            //Fin autre champ du second fieldset, ancien cerfa
            
            //Fin second bloc

            //Début troisième bloc 5.3
            "co_tot_log_nb",
            "co_tot_ind_nb",
            "co_tot_coll_nb",
            "co_mais_piece_nb",
            "co_mais_niv_nb",
            "co_fin_lls",
            "co_fin_aa",
            "co_fin_ptz",
            "co_fin_autr",
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

            "co_anx_pisc",
            "co_anx_gara",
            "co_anx_veran",
            "co_anx_abri",
            "co_anx_autr",
            "co_anx_autr_desc",

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
            "co_bat_niv_dessous_nb",
            "co_trx_exten",
            "co_trx_surelev",
            "co_trx_nivsup",
            "co_trx_autre",
            "co_trav_supp_dessous",
            "co_trav_supp_dessus",

            "co_sp_transport",
            "co_sp_enseign",
            "co_sp_act_soc",
            "co_sp_ouvr_spe",
            "co_sp_sante",
            "co_sp_culture",

            "co_demont_periode",

            // Tableau de surface
            "'' as tab_surface",
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
            //Fin cinquième bloc

            //Début sixième bloc 5.6
            "'' as tab_surface2",
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
            "su2_avt_shon21",
            "su2_avt_shon22",
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
            "su2_cstr_shon21",
            "su2_cstr_shon22",
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
            "su2_chge_shon21",
            "su2_chge_shon22",
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
            "su2_demo_shon21",
            "su2_demo_shon22",
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
            "su2_sup_shon21",
            "su2_sup_shon22",
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
            "su2_tot_shon21",
            "su2_tot_shon22",
            "su2_avt_shon_tot",
            "su2_cstr_shon_tot",
            "su2_chge_shon_tot",
            "su2_demo_shon_tot",
            "su2_sup_shon_tot",
            "su2_tot_shon_tot",
            //Fin sixième bloc

            //Début septième bloc 5.7
            "co_statio_avt_nb",
            "co_statio_apr_nb",
            "co_statio_adr",
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
            "co_statio_place_nb",
            "co_statio_tot_surf",
            "co_statio_tot_shob",
            "co_statio_comm_cin_surf",
            "co_perf_energ",

            //Fin septième bloc
        //Fin second fieldset

            //Fin septième bloc
        //Fin second fieldset
            //Début troisième fieldset
            //Début premier bloc
            "dm_constr_dates",
            "dm_total",
            "dm_partiel",
            "dm_projet_desc",
            "dm_tot_log_nb",
            //Fin premier bloc

            "co_inst_ouvr_trav_act_code_envir",
            "co_trav_auto_env",
            "co_derog_esp_prot",
            "co_install_classe",
            "co_derog_innov",
            "co_avis_abf",
            "x1l_legislation",
            "x1p_precisions",
            "x1u_raccordement",
            "co_peri_site_patri_remar",
            "co_abo_monu_hist",
            "x2m_inscritmh",

            // Bloc engagement
            "enga_decla_lieu",
            "enga_decla_date",
            "enga_decla_donnees_nomi_comm",
            "e3c_certification",
            "e3a_competence",

        //Fin troisième fieldset
        // Doc/Daact
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

            // Début DIA
            // Cadre réservé à l’administration
            "dia_dia_dpu",
            "dia_dia_zad",
            "dia_dia_zone_preempt_esp_natu_sensi",
            "dia_dab_dpu",
            "dia_dab_zad",
            "dia_mairie_prix_moyen",
            // Propriétaire
            "dia_propri_indivi",
            // Situation du bien
            "dia_situa_bien_plan_cadas_oui",
            "dia_situa_bien_plan_cadas_non",
            // Désignation du bien
            "dia_imm_non_bati",
            "dia_imm_bati_terr_propr",
            "dia_imm_bati_terr_autr",
            "dia_imm_bati_terr_autr_desc",
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
            "dia_su_co_sol_num",
            "dia_su_util_hab",
            "dia_su_util_hab_num",
            "dia_nb_niv",
            "dia_nb_appart",
            "dia_nb_autre_loc",
            "dia_vente_lot_volume",
            "dia_vente_lot_volume_txt",
            "dia_bat_copro",
            "dia_bat_copro_desc",
            "dia_lot_numero",
            "dia_lot_bat",
            "dia_lot_etage",
            "dia_lot_quote_part",
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
            // Usage et occupation
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
            // Droits réels ou personnels
            "dia_droit_reel_perso_grevant_bien_oui",
            "dia_droit_reel_perso_grevant_bien_non",
            "dia_droit_reel_perso_grevant_bien_desc",
            "dia_droit_reel_perso_nat",
            "dia_droit_reel_perso_viag",
            // Modalités de la cession
            "dia_mod_cess_prix_vente",
            "dia_mod_cess_prix_vente_num",
            "dia_mod_cess_prix_vente_mob",
            "dia_mod_cess_prix_vente_mob_num",
            "dia_mod_cess_prix_vente_cheptel",
            "dia_mod_cess_prix_vente_cheptel_num",
            "dia_mod_cess_prix_vente_recol",
            "dia_mod_cess_prix_vente_recol_num",
            "dia_mod_cess_prix_vente_autre",
            "dia_mod_cess_prix_vente_autre_num",
            "dia_mod_cess_adr",
            "dia_mod_cess_sign_act_auth",
            "dia_mod_cess_terme",
            "dia_mod_cess_terme_prec",
            "dia_mod_cess_commi",
            "dia_mod_cess_commi_mnt",
            "dia_mod_cess_commi_mnt_ttc",
            "dia_mod_cess_commi_mnt_ht",
            "dia_mod_cess_commi_ttc",
            "dia_mod_cess_commi_ht",
            "dia_mod_cess_bene_acquereur",
            "dia_mod_cess_bene_vendeur",
            "dia_mod_cess_paie_nat",
            "dia_mod_cess_paie_nat_desc",
            "dia_mod_cess_design_contr_alien",
            "dia_mod_cess_eval_contr",
            "dia_mod_cess_rente_viag",
            "dia_mod_cess_rente_viag_desc",
            "dia_mod_cess_mnt_an",
            "dia_mod_cess_mnt_an_num",
            "dia_mod_cess_mnt_compt",
            "dia_mod_cess_mnt_compt_num",
            "dia_mod_cess_bene_rente",
            "dia_mod_cess_droit_usa_hab",
            "dia_mod_cess_droit_usa_hab_prec",
            "dia_mod_cess_eval_usa_usufruit",
            "dia_mod_cess_vente_nue_prop",
            "dia_mod_cess_vente_nue_prop_prec",
            "dia_mod_cess_echange",
            "dia_mod_cess_echange_desc",
            "dia_mod_cess_design_bien_recus_ech",
            "dia_mod_cess_mnt_soulte",
            "dia_mod_cess_mnt_soulte_num",
            "dia_mod_cess_prop_contre_echan",
            "dia_mod_cess_apport_societe",
            "dia_mod_cess_apport_societe_desc",
            "dia_mod_cess_bene",
            "dia_mod_cess_esti_bien",
            "dia_mod_cess_cess_terr_loc_co",
            "dia_mod_cess_cess_terr_loc_co_desc",
            "dia_mod_cess_esti_terr",
            "dia_mod_cess_esti_loc",
            "dia_mod_cess_esti_imm_loca",
            "dia_mod_cess_esti_imm_loca_desc",
            "dia_mod_cess_adju_vol",
            "dia_mod_cess_adju_obl",
            "dia_mod_cess_adju_obl_desc",
            "dia_mod_cess_adju_fin_indivi",
            "dia_mod_cess_adju_fin_indivi_desc",
            "dia_mod_cess_adju_date_lieu",
            "dia_mod_cess_mnt_mise_prix",
            // Les soussignés déclarent
            "dia_prop_titu_prix_indique",
            "dia_prop_recherche_acqu_prix_indique",
            "dia_acquereur_nom_prenom",
            "dia_acquereur_prof",
            "dia_acquereur_adr_num_voie",
            "dia_acquereur_adr_ext",
            "dia_acquereur_adr_type_voie",
            "dia_acquereur_adr_nom_voie",
            "dia_acquereur_adr_lieu_dit_bp",
            "dia_acquereur_adr_cp",
            "dia_acquereur_adr_localite",
            "dia_indic_compl_ope",
            "dia_vente_adju",
            "dia_ss_lieu",
            "dia_ss_date",
            // Notification des décisions du titulaire du droit de préemption
            "dia_notif_dec_titul_adr_prop",
            "dia_notif_dec_titul_adr_prop_desc",
            "dia_notif_dec_titul_adr_manda",
            "dia_notif_dec_titul_adr_manda_desc",
            // Observation
            "dia_observation",
            // Cadre réservé au titulaire du droit de préemption
            "dia_cadre_titul_droit_prempt",
            // Données complémentaires
            "dia_comp_prix_vente",
            "dia_comp_surface",
            "dia_comp_total_frais",
            "dia_comp_mtn_total",
            "dia_comp_valeur_m2",
            // Montants
            "dia_esti_prix_france_dom",
            "dia_prop_collectivite",
            // Délégataire à l'instruction
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
            // Entrée en jouissance
            "dia_entree_jouissance_type",
            "dia_entree_jouissance_date",
            "dia_entree_jouissance_date_effet",
            "dia_entree_jouissance_com",
            // Remise du bien
            "dia_remise_bien_date_effet",
            "dia_remise_bien_com",
            // Fin DIA
      
            "code_cnil",
        //Début fieldset 1 des taxes
            //Bloc 1.1
            "tax_surf_tot_cstr",
            "tax_surf_loc_stat",
            "f1ts4_surftaxestation",
            "f1ut1_surfcree",
            "tax_surf_tot",
            "tax_surf",
            "tax_surf_suppr_mod",
            "tax_surf_tot_demo",
            //Fin bloc 1.1
            //Bloc 1.2
            //Bloc 1.2.1
            "'' as tab_tax_su_princ",
            "tax_su_princ_log_nb1",
            "tax_su_princ_log_nb2",
            "tax_su_princ_log_nb4",
            "tax_su_princ_log_nb3",
            "tax_su_princ_log_nb_tot1",
            "tax_su_princ_log_nb_tot2",
            "tax_su_princ_log_nb_tot4",
            "tax_su_princ_log_nb_tot3",
            "tax_su_princ_surf1",
            "tax_su_princ_surf2",
            "tax_su_princ_surf4",
            "tax_su_princ_surf3",
            "tax_su_princ_surf_sup1",
            "tax_su_princ_surf_sup2",
            "tax_su_princ_surf_sup4",
            "tax_su_princ_surf_sup3",
            "tax_su_princ_surf_stat1",
            "tax_su_princ_surf_stat2",
            "tax_su_princ_surf_stat4",
            "tax_su_princ_surf_stat3",
            "f1gu1_f1gu2_f1gu3",
            "f1lu1_f1lu2_f1lu3",
            "f1zu1_f1zu2_f1zu3",
            "f1pu1_f1pu2_f1pu3",
            "f1gt4_f1gt5_f1gt6",
            "f1lt4_f1lt5_f1lt6",
            "f1zt4_f1zt5_f1zt6",
            "f1pt4_f1pt5_f1pt6",
            "'' as tab_tax_su_secon",
            "f1xu1_f1xu2_f1xu3",
            "f1xt4_f1xt5_f1xt6",
            "'' as tab_tax_su_heber",
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
            "tax_su_heber_surf_stat1",
            "tax_su_heber_surf_stat2",
            "tax_su_heber_surf_stat3",
            "f1hu1_f1hu2_f1hu3",
            "f1mu1_f1mu2_f1mu3",
            "f1qu1_f1qu2_f1qu3",
            "f1ht4_f1ht5_f1ht6",
            "f1mt4_f1mt5_f1mt6",
            "f1qt4_f1qt5_f1qt6",
            "'' as tab_tax_su_tot",
            "tax_su_secon_log_nb",
            "tax_su_tot_log_nb",
            "tax_su_secon_log_nb_tot",
            "tax_su_tot_log_nb_tot",
            "tax_su_secon_surf",
            "tax_su_tot_surf",
            "tax_su_secon_surf_sup",
            "tax_su_tot_surf_sup",
            "tax_su_tot_surf_stat",
            "tax_su_secon_surf_stat",
            "tax_su_habit_abr_jard_pig_colom",
            //Fin bloc 1.2.1
            //Bloc 1.2.2
            "tax_ext_pret",
            "tax_ext_desc",
            "tax_surf_tax_exist_cons",
            "tax_log_exist_nb",
            "tax_log_ap_trvx_nb",
            "tax_surf_tax_demo",
            "tax_surf_abr_jard_pig_colom",
            // Fin bloc 1.2.2
            //Bloc 1.2.3
            "tax_comm_nb",
            "'' as tab_tax_su_non_habit_surf",
            "tax_su_non_habit_surf1",
            "tax_su_non_habit_surf2",
            "tax_su_non_habit_surf3",
            "tax_su_non_habit_surf4",
            "tax_su_non_habit_surf5",
            "tax_su_non_habit_surf6",
            "tax_su_non_habit_surf7",
            "tax_su_non_habit_surf8",
            "tax_su_non_habit_surf9",
            "tax_su_non_habit_surf_sup1",
            "tax_su_non_habit_surf_sup2",
            "tax_su_non_habit_surf_sup3",
            "tax_su_non_habit_surf_sup4",
            "tax_su_non_habit_surf_sup5",
            "tax_su_non_habit_surf_sup6",
            "tax_su_non_habit_surf_sup7",
            "tax_su_non_habit_surf_stat1",
            "tax_su_non_habit_surf_stat2",
            "tax_su_non_habit_surf_stat3",
            "tax_su_non_habit_surf_stat4",
            "tax_su_non_habit_surf_stat5",
            "tax_su_non_habit_surf_stat6",
            "tax_su_non_habit_surf_stat7",
            "tax_su_non_habit_surf_stat8",
            "tax_su_non_habit_surf_stat9",
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
            "'' as tab_tax_su_parc_statio_expl_comm",
            "tax_su_parc_statio_expl_comm_surf",
            "tax_su_non_habit_abr_jard_pig_colom",
            //Fin bloc 1.2.3
            //Bloc 1.3
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
            "'' as tab_tax_am",
            "tax_am_statio_ext_cr",
            "tax_sup_bass_pisc_cr",
            "tax_empl_ten_carav_mobil_nb_cr",
            "tax_empl_hll_nb_cr",
            "tax_eol_haut_nb_cr",
            "tax_pann_volt_sup_cr",
            //Fin bloc 1.3
            //Bloc 1.4
            "tax_terrassement_arch",
            "tax_surf_loc_arch",
            "tax_surf_pisc_arch",
            "tax_am_statio_ext_arch",
            "tax_empl_ten_carav_mobil_nb_arch",
            "tax_empl_hll_nb_arch",
            "tax_eol_haut_nb_arch",
            //Fin bloc 1.4
            //Bloc 1.5
            "tax_trx_presc_ppr",
            "tax_monu_hist",
            //Fin bloc 1.5
        //Fieldset 2 taxes
            //Bloc 2.1
            "vsd_surf_planch_smd",
            "vsd_unit_fonc_sup",
            "vsd_unit_fonc_constr_sup",
            "vsd_val_terr",
            "vsd_const_sxist_non_dem_surf",
            "vsd_rescr_fisc",
            //Fin Bloc 2.1
            //Bloc 2.2
            "pld_val_terr",
            "pld_const_exist_dem",
            "pld_const_exist_dem_surf",
            // Autres renseignements
            "tax_desc",
            // Bloc adresse future
            "tax_adresse_future_numero",
            "tax_adresse_future_voie",
            "tax_adresse_future_lieudit",
            "tax_adresse_future_localite",
            "tax_adresse_future_cp",
            "tax_adresse_future_bp",
            "tax_adresse_future_cedex",
            "tax_adresse_future_pays",
            "tax_adresse_future_division",
            //
            "f9d_date",
            "f9n_nom",
            // Fieldset Exonération
            // Fieldset TA
            // Exonérations de plein droit TA
            "exo_ta_1",
            "exo_ta_2",
            "exo_ta_3",
            "exo_ta_4",
            "exo_ta_5",
            "exo_ta_6",
            "exo_ta_7",
            "exo_ta_8",
            "exo_ta_9",
            // Exonérations facultatives TA
            "exo_facul_1",
            "exo_facul_2",
            "exo_facul_3",
            "exo_facul_4",
            "exo_facul_5",
            "exo_facul_6",
            "exo_facul_7",
            "exo_facul_8",
            "exo_facul_9",
            // Montants exonération TA
            "mtn_exo_ta_part_commu",
            "mtn_exo_ta_part_depart",
            "mtn_exo_ta_part_reg",
            // Fin fieldset TA
            // Fieldset RAP
            // Exonération RAP
            "exo_rap_1",
            "exo_rap_2",
            "exo_rap_3",
            "exo_rap_4",
            "exo_rap_5",
            "exo_rap_6",
            "exo_rap_7",
            "exo_rap_8",
            // Montant exonération RAP
            "mtn_exo_rap",
            // Fin fieldset RAP
            // Fin fieldset Exonération

            // Champs pour les dossiers contentieux
            "ctx_objet_recours",
            // "ctx_moyen_souleve",
            // "ctx_moyen_retenu_juge",
            "array_to_string(
                array_agg(
                    distinct(lien_donnees_techniques_moyen_souleve.moyen_souleve)
                    ORDER BY lien_donnees_techniques_moyen_souleve.moyen_souleve
                ),
            ';') as ctx_moyen_souleve",
            "array_to_string(
                array_agg(
                    distinct(lien_donnees_techniques_moyen_retenu_juge.moyen_retenu_juge)
                    ORDER BY lien_donnees_techniques_moyen_retenu_juge.moyen_retenu_juge
                ),
            ';') as ctx_moyen_retenu_juge",
            "ctx_reference_sagace",
            "ctx_reference_dsj",
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

            // Droit de préemption commercial
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

            // DEMANDE D’AUTORISATION OU DÉCLARATION PRÉALABLE DE TRAVAUX SUR MONUMENTS HISTORIQUES
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

            // Champs non utilisés à garder pour ancien cerfa
            "co_statio_avt_shob",
            "co_statio_apr_shob",
            "co_statio_avt_surf",
            "co_statio_apr_surf",
            "co_trx_amgt",
            "co_modif_aspect",
            "co_modif_struct",
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
            "avap_co_clot",
            "avap_aut_coup_aba_arb",
            "avap_ouv_infra",
            "avap_aut_inst_mob",
            "avap_aut_plant",
            "avap_aut_auv_elec",
            "tax_dest_loc_tr",
        );
    }

    /**
     * Clause from pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__tableSelect() {
        return sprintf(
            '%1$s%2$s
                LEFT JOIN %1$slien_donnees_techniques_moyen_souleve
                    ON lien_donnees_techniques_moyen_souleve.donnees_techniques = donnees_techniques.donnees_techniques
                LEFT JOIN %1$smoyen_souleve
                    ON lien_donnees_techniques_moyen_souleve.moyen_souleve = moyen_souleve.moyen_souleve
                LEFT JOIN %1$slien_donnees_techniques_moyen_retenu_juge
                    ON lien_donnees_techniques_moyen_retenu_juge.donnees_techniques = donnees_techniques.donnees_techniques
                LEFT JOIN %1$smoyen_retenu_juge
                    ON lien_donnees_techniques_moyen_retenu_juge.moyen_retenu_juge = moyen_retenu_juge.moyen_retenu_juge',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     * Clause where pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__selection() {
        return " GROUP BY donnees_techniques.donnees_techniques ";
    }


    /**
     * Indique si la redirection vers le lien de retour est activée ou non.
     *
     * L'objectif de cette méthode est de permettre d'activer ou de désactiver
     * la redirection dans certains contextes.
     *
     * @return boolean
     */
    function is_back_link_redirect_activated() {
        //
        if ($this->getParameter("retourformulaire") === 'lot') {
            //
            return false;
        }

        //
        return true;
    }

    /**
     * CONDITION - is_deletable.
     *
     * Condition pour afficher le bouton de suppression. Cette action n'est pas utile donc
     * ne doit pas être disponible, même pour l'admin.
     *
     * @return boolean
     */
    function is_deletable() {
        //
        return false;
    }

    /**
     * CONDITION - is_editable.
     *
     * Condition pour afficher le bouton de modification.
     *
     * @return boolean
     */
    function is_editable() {

        // Si c'est un sous-formulaire du dossier d'autorisation
        if ($this->getParameter("retourformulaire") == 'dossier_autorisation'
            || $this->getParameter("retourformulaire") == 'dossier_autorisation_avis') {

            //
            return false;
        }

        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_modifier_bypass");
        //
        if ($bypass == true) {
            //
            return true;
        }

        // Si l'utilisateur est un intructeur qui correspond à la
        // division du dossier
        if ($this->is_instructeur_from_division_dossier() === true) {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Méthode permettant de récupérer l'id du cerfa lié au dossier.
     *
     * @return cerfa handler du cerfa
     */
    function getCerfa() {
        if($this->cerfa != null) {
            return $this->cerfa;
        }
        $this->cerfa = $this->f->get_inst__om_dbform(array(
            "obj" => "cerfa",
            "idx" => $this->getVal("cerfa"),
        ));
        return $this->cerfa;
    }

    /**
     * Méthode permettant de vérifier si le tableau passé en parametre est défini
     * dans la table des cerfa
     */

    function setTabSelect($tab, $idchamp) {
        // Test si un tableau de surface a été défini
        if ( $this->cerfa->getVal($idchamp) !=  "" ){
            
            // Configuration du tableau des surfaces
            $contenu['column_header']=$tab[$this->cerfa->getVal($idchamp)]['column_header'];
            $contenu['row_header']=$tab[$this->cerfa->getVal($idchamp)]['row_header'];
    
            foreach($tab[$this->cerfa->getVal($idchamp)]['values'] as $champ) {
                $contenu['values'][$champ] = $this->getVal($champ);
            }
    
            $this->form->setSelect($idchamp,$contenu);
        }
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_erp_class_cat() {
        return "SELECT erp_categorie.erp_categorie, CONCAT_WS(' - ', erp_categorie.libelle, erp_categorie.description) FROM ".DB_PREFIXE."erp_categorie ORDER BY erp_categorie.erp_categorie ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_erp_class_cat_by_id() {
        return "SELECT erp_categorie.erp_categorie, CONCAT_WS(' - ', erp_categorie.libelle, erp_categorie.description) FROM ".DB_PREFIXE."erp_categorie WHERE erp_categorie = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_erp_class_type() {
        return "SELECT erp_type.erp_type, CONCAT_WS(' - ', erp_type.libelle, erp_type.description) FROM ".DB_PREFIXE."erp_type ORDER BY erp_type.erp_type ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_erp_class_type_by_id() {
        return "SELECT erp_type.erp_type, CONCAT_WS(' - ', erp_type.libelle, erp_type.description) FROM ".DB_PREFIXE."erp_type WHERE erp_type = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_ctx_objet_recours() {
        return "SELECT objet_recours.objet_recours, CONCAT_WS(' - ', objet_recours.code, objet_recours.libelle) FROM ".DB_PREFIXE."objet_recours WHERE ((objet_recours.om_validite_debut IS NULL AND (objet_recours.om_validite_fin IS NULL OR objet_recours.om_validite_fin > CURRENT_DATE)) OR (objet_recours.om_validite_debut <= CURRENT_DATE AND (objet_recours.om_validite_fin IS NULL OR objet_recours.om_validite_fin > CURRENT_DATE))) ORDER BY objet_recours.code ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_ctx_objet_recours_by_id() {
        return "SELECT objet_recours.objet_recours, CONCAT_WS(' - ', objet_recours.code, objet_recours.libelle) FROM ".DB_PREFIXE."objet_recours WHERE objet_recours = <idx>";
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        //parent::setSelect($form, $maj);

        // CRUD
        $crud = $this->get_action_crud($this->getParameter("maj"));

        if(file_exists ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php"))
            include ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php");

        if(empty($this->cerfa)) {
            $this->getCerfa();
        }

        $this->setTabSelect($tab_surface, "tab_surface");
        $this->setTabSelect($tab_surface2, "tab_surface2");
        $this->setTabSelect($tab_tax_su_princ, "tab_tax_su_princ");
        $this->setTabSelect($tab_tax_su_heber, "tab_tax_su_heber");
        $this->setTabSelect($tab_tax_su_secon, "tab_tax_su_secon");
        $this->setTabSelect($tab_tax_su_tot, "tab_tax_su_tot");
        $this->setTabSelect($tab_tax_su_non_habit_surf, "tab_tax_su_non_habit_surf");
        $this->setTabSelect($tab_tax_su_parc_statio_expl_comm, "tab_tax_su_parc_statio_expl_comm");
        $this->setTabSelect($tab_tax_am, "tab_tax_am");
        $this->setTabSelect($tab_erp_eff, "tab_erp_eff");
        
        // Définition des champs Oui/Non/Je ne sais pas
        $value[] = array(
            "nesaispas",
            "non",
            "oui",
            );
        $value[] = array(
            _("Je ne sais pas"),
            _("Non"),
            _("Oui"),
            );
        
        $form->setSelect('terr_juri_titul',$value);
        $form->setSelect('terr_juri_lot',$value);
        $form->setSelect('terr_juri_zac',$value);
        $form->setSelect('terr_juri_afu',$value);
        $form->setSelect('terr_juri_pup',$value);
        $form->setSelect('terr_juri_oin',$value);
        $form->setSelect('terr_juri_desc',$value);
        $form->setSelect('terr_div_surf_etab',$value);
        $form->setSelect('terr_div_surf_av_div',$value);

        // Définition du champ type de dpc
        $dpc_type_values = array();
        $dpc_type_values[] = array(
            _("Fonds de commerce"),
            _("Fonds artisanal"),
            _("Bail commercial"),
            _("Terrain"),
        );
        $dpc_type_values[] = array(
            _("Fonds de commerce"),
            _("Fonds artisanal"),
            _("Bail commercial"),
            _("Terrain"),
        );
        $form->setSelect('dpc_type',$dpc_type_values);

        //
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "erp_class_cat",
            $this->get_var_sql_forminc__sql("erp_class_cat"),
            $this->get_var_sql_forminc__sql("erp_class_cat_by_id"),
            false
        );
        //
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "erp_class_type",
            $this->get_var_sql_forminc__sql("erp_class_type"),
            $this->get_var_sql_forminc__sql("erp_class_type_by_id"),
            false
        );
        //
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

        //Récupérer le nom et le prénom de l'architecte
        $coordonneesArchitecte = $this->getPrenomNomArchitecte($this->getVal('architecte'));
        if ($maj<2){
            $value = array(
                "data" => $coordonneesArchitecte,
                "obj" => "architecte", 
            );
        }
        else {
            $value = array(
                0 => array($this->getVal('architecte'), ),
                1 => array($coordonneesArchitecte, ),
            );
        }
        $form->setSelect('architecte', $value);

        // Champ select_multiple - ctx_moyen_souleve
        // Liaison NaN - donnees_techniques/moyen_souleve
        // SELECT
        $sql_ctx_moyen_souleve_select = "SELECT moyen_souleve.moyen_souleve, CONCAT_WS(' - ', moyen_souleve.code, moyen_souleve.libelle) as lib ";
        // FROM
        $sql_ctx_moyen_souleve_from = " FROM ".DB_PREFIXE."moyen_souleve ";
        // WHERE
        $sql_ctx_moyen_souleve_where = "
        WHERE ((moyen_souleve.om_validite_debut IS NULL AND (moyen_souleve.om_validite_fin IS NULL OR moyen_souleve.om_validite_fin > CURRENT_DATE)) OR (moyen_souleve.om_validite_debut <= CURRENT_DATE AND (moyen_souleve.om_validite_fin IS NULL OR moyen_souleve.om_validite_fin > CURRENT_DATE)))
        ORDER BY lib";
        // WHERE (by id)
        $sql_ctx_moyen_souleve_by_id_where = " 
        WHERE moyen_souleve.moyen_souleve IN (<idx>)
        ORDER BY lib";
        $sql_ctx_moyen_souleve = $sql_ctx_moyen_souleve_select.$sql_ctx_moyen_souleve_from.$sql_ctx_moyen_souleve_where;
        $sql_ctx_moyen_souleve_by_id = $sql_ctx_moyen_souleve_select.$sql_ctx_moyen_souleve_from.$sql_ctx_moyen_souleve_by_id_where;
        //
        $this->init_select($form, $this->f->db, $maj, null, "ctx_moyen_souleve", $sql_ctx_moyen_souleve, $sql_ctx_moyen_souleve_by_id, true, true);

        // Champ select_multiple - ctx_moyen_retenu_juge
        // Liaison NaN - donnees_techniques/moyen_retenu_juge
        // SELECT
        $sql_ctx_moyen_retenu_juge_select = "SELECT moyen_retenu_juge.moyen_retenu_juge, CONCAT_WS(' - ', moyen_retenu_juge.code, moyen_retenu_juge.libelle) as lib ";
        // FROM
        $sql_ctx_moyen_retenu_juge_from = " FROM ".DB_PREFIXE."moyen_retenu_juge ";
        // WHERE
        $sql_ctx_moyen_retenu_juge_where = "
        WHERE ((moyen_retenu_juge.om_validite_debut IS NULL AND (moyen_retenu_juge.om_validite_fin IS NULL OR moyen_retenu_juge.om_validite_fin > CURRENT_DATE)) OR (moyen_retenu_juge.om_validite_debut <= CURRENT_DATE AND (moyen_retenu_juge.om_validite_fin IS NULL OR moyen_retenu_juge.om_validite_fin > CURRENT_DATE)))
        ORDER BY lib";
        // WHERE (by id)
        $sql_ctx_moyen_retenu_juge_by_id_where = " 
        WHERE moyen_retenu_juge.moyen_retenu_juge IN (<idx>)
        ORDER BY lib";
        $sql_ctx_moyen_retenu_juge = $sql_ctx_moyen_retenu_juge_select.$sql_ctx_moyen_retenu_juge_from.$sql_ctx_moyen_retenu_juge_where;
        $sql_ctx_moyen_retenu_juge_by_id = $sql_ctx_moyen_retenu_juge_select.$sql_ctx_moyen_retenu_juge_from.$sql_ctx_moyen_retenu_juge_by_id_where;
        //
        $this->init_select($form, $this->f->db, $maj, null, "ctx_moyen_retenu_juge", $sql_ctx_moyen_retenu_juge, $sql_ctx_moyen_retenu_juge_by_id, true, true);

        //
        $mh_design_type_protect_values = array();
        $mh_design_type_protect_values[] = array(
            "",
            __("Classé"),
            __("Inscrit"),
            __("Classé et inscrit"),
        );
        $mh_design_type_protect_values[] = array(
            $crud === 'read' ? "" : __("Choisir un type de protection"),
            __("Classé"),
            __("Inscrit"),
            __("Classé et inscrit"),
        );
        $form->setSelect('mh_design_type_protect', $mh_design_type_protect_values);

        //
        $mh_design_nature_prop_values = array();
        $mh_design_nature_prop_values[] = array(
            "",
            __("Privée"),
            __("Publique"),
            __("Privée et publique"),
        );
        $mh_design_nature_prop_values[] = array(
            $crud === 'read' ? "" : __("Choisir une nature de la propriété"),
            __("Privée"),
            __("Publique"),
            __("Privée et publique"),
        );
        $form->setSelect('mh_design_nature_prop', $mh_design_nature_prop_values);
    }


    // XXX Créer une nouvelle méthode au même endroit que l'appel a checkAccessibility()
    function checkAccessibility() {

        parent::checkAccessibility();

        if(file_exists ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php"))
            include ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php");

        //
        if(empty($this->cerfa)) {
            $this->getCerfa();
        }

        $id_tab_surface = $this->cerfa->getVal("tab_surface");
        $id_tab_surface2 = $this->cerfa->getVal("tab_surface2");
        $id_tab_tax_su_princ = $this->cerfa->getVal("tab_tax_su_princ");
        $id_tab_tax_su_heber = $this->cerfa->getVal("tab_tax_su_heber");
        $id_tab_tax_su_secon = $this->cerfa->getVal("tab_tax_su_secon");
        $id_tab_tax_su_tot = $this->cerfa->getVal("tab_tax_su_tot");
        $id_tab_tax_su_non_habit_surf = $this->cerfa->getVal("tab_tax_su_non_habit_surf");
        $id_tab_tax_su_parc_statio_expl_comm = $this->cerfa->getVal("tab_tax_su_parc_statio_expl_comm");
        $id_tab_tax_am = $this->cerfa->getVal("tab_tax_am");
        $id_tab_erp_eff = $this->cerfa->getVal("tab_erp_eff");

        //Suppression des champs de tableaux
        if(!empty($id_tab_surface)) {
            foreach($tab_surface[$this->cerfa->getVal("tab_surface")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        if(!empty($id_tab_surface2)) {
            foreach($tab_surface2[$this->cerfa->getVal("tab_surface2")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        if(!empty($id_tab_tax_su_princ)) {
            foreach($tab_tax_su_princ[$this->cerfa->getVal("tab_tax_su_princ")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        if(!empty($id_tab_tax_su_heber)) {
            foreach($tab_tax_su_heber[$this->cerfa->getVal("tab_tax_su_heber")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        if(!empty($id_tab_tax_su_secon)) {
            foreach($tab_tax_su_secon[$this->cerfa->getVal("tab_tax_su_secon")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        if(!empty($id_tab_tax_su_tot)) {
            foreach($tab_tax_su_tot[$this->cerfa->getVal("tab_tax_su_tot")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        if(!empty($id_tab_tax_su_non_habit_surf)) {
            foreach($tab_tax_su_non_habit_surf[$this->cerfa->getVal("tab_tax_su_non_habit_surf")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        if(!empty($id_tab_tax_su_parc_statio_expl_comm)) {
            foreach($tab_tax_su_parc_statio_expl_comm[$this->cerfa->getVal("tab_tax_su_parc_statio_expl_comm")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        if(!empty($id_tab_tax_am)) {
            foreach($tab_tax_am[$this->cerfa->getVal("tab_tax_am")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        if(!empty($id_tab_erp_eff)) {
            foreach($tab_erp_eff[$this->cerfa->getVal("tab_erp_eff")]['values'] as $champ) {
                unset($this->champs[array_search($champ,$this->champs)]);
            }
        }
        // Renumérotation
        $this->champs = array_values($this->champs);
    }

    /**
     * Méthode permettant de définir le type des différents tableaux en fonction 
     * des valeurs du cerfa
     **/
    function setTabType($tab) {
        // Définition du type "tableau"
        if ( $this->cerfa->getVal($tab) !=  "" ){
            
            $this->form->setType($tab,'tableau');
        }
        //Le chache si non défini
        else {
            
            $this->form->setType($tab,'hidden');
        }
    }

    /**
     * Méthode permettant de définir le type des champs des tableaux en fonction 
     * des valeurs du cerfa
     **/
    function setTabChampType($tab) {
        if(file_exists ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php"))
            include ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php");
        // Pour chaque champ dans la liste des champs du cerfa 
        $tableau = $$tab;
        foreach ($this->champs as $champ) {
            
            if(array_search($champ, $this->cerfa->champs) !== false) {
                // On les cache si décoché dans le formulaire de cerfa
                if($this->cerfa->getVal($champ) == 'f') {
                    $this->form->setType($champ,'hidden');
                }
            } else {
                
                if(!in_array($champ, $tableau[$this->cerfa->getVal($tab)]['values'])) {

                    $this->form->setType($champ,'hidden');
                }
            }
        }
    }



    function setType(&$form,$maj) {
        parent::setType($form,$maj);

        if(file_exists ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php"))
            include ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php");

        if(empty($this->cerfa)) {
            $this->getCerfa();
        }

        $this->setTabType("tab_surface");
        $this->setTabType("tab_surface2");
        $this->setTabType("tab_tax_su_princ");
        $this->setTabType("tab_tax_su_heber");
        $this->setTabType("tab_tax_su_secon");
        $this->setTabType("tab_tax_su_tot");
        $this->setTabType("tab_tax_su_non_habit_surf");
        $this->setTabType("tab_tax_su_parc_statio_expl_comm");
        $this->setTabType("tab_tax_am");
        $this->setTabType("tab_erp_eff");

        //Champs select pour les liste a choix oui/non/je ne sais pas (terr_*)
        if($maj == 0) {
            $form->setType('terr_juri_titul','select');
            $form->setType('terr_juri_lot','select');
            $form->setType('terr_juri_zac','select');
            $form->setType('terr_juri_afu','select');
            $form->setType('terr_juri_pup','select');
            $form->setType('terr_juri_oin','select');
            $form->setType('architecte', 'manage_with_popup');
            $form->setType('erp_class_cat','select');
            $form->setType('erp_class_type','select');
            $form->setType('ctx_objet_recours','select');
            $form->setType('ctx_moyen_souleve','select_multiple');
            $form->setType('ctx_moyen_retenu_juge','select_multiple');
            $form->setType('dpc_type','select');
            $form->setType('mh_design_type_protect','select');
            $form->setType('mh_design_nature_prop','select');
        } elseif($maj == 1) {
            $form->setType('terr_juri_titul','select');
            $form->setType('terr_juri_lot','select');
            $form->setType('terr_juri_zac','select');
            $form->setType('terr_juri_afu','select');
            $form->setType('terr_juri_pup','select');
            $form->setType('terr_juri_oin','select');
            $form->setType('architecte', 'manage_with_popup');
            $form->setType('erp_class_cat','select');
            $form->setType('erp_class_type','select');
            $form->setType('ctx_objet_recours','select');
            $form->setType('ctx_moyen_souleve','select_multiple');
            $form->setType('ctx_moyen_retenu_juge','select_multiple');
            $form->setType('dpc_type','select');
            $form->setType('mh_design_type_protect','select');
            $form->setType('mh_design_nature_prop','select');
            if ($this->f->is_option_mode_service_consulte_enabled() === false) {
                $inst_dossier = $this->get_inst_dossier();
                if ($this->f->is_type_dossier_platau($inst_dossier->getVal('dossier_autorisation')) === true
                    && $inst_dossier->getVal('etat_transmission_platau') !== 'jamais_transmissible') {
                    //
                    $required_fields_platau = $inst_dossier->get_list_platau_required_fields_dossier();
                    foreach ($required_fields_platau as $required_field_platau) {
                        $champ = explode('.', $required_field_platau)[1];
                        if (in_array($champ, $this->champs)) {
                            $form->setType($champ ,$form->type[$champ].'_demat_color');
                        }
                    }
                }
            }
        } elseif($maj == 2) {
            $form->setType('terr_juri_titul','selectstatic');
            $form->setType('terr_juri_lot','selectstatic');
            $form->setType('terr_juri_zac','selectstatic');
            $form->setType('terr_juri_afu','selectstatic');
            $form->setType('terr_juri_pup','selectstatic');
            $form->setType('terr_juri_oin','selectstatic');
            $form->setType('architecte', 'selectstatic');
            $form->setType('erp_class_cat','selectstatic');
            $form->setType('erp_class_type','selectstatic');
            $form->setType('ctx_objet_recours','selectstatic');
            $form->setType('ctx_moyen_souleve','select_multiple_static');
            $form->setType('ctx_moyen_retenu_juge','select_multiple_static');
            $form->setType('dpc_type','selectstatic');
            $form->setType('mh_design_type_protect','selectstatic');
            $form->setType('mh_design_nature_prop','selectstatic');
        } elseif($maj == 3 || $maj == 4 || $maj == 5) {
            $form->setType('terr_juri_titul','selectstatic');
            $form->setType('terr_juri_lot','selectstatic');
            $form->setType('terr_juri_zac','selectstatic');
            $form->setType('terr_juri_afu','selectstatic');
            $form->setType('terr_juri_pup','selectstatic');
            $form->setType('terr_juri_oin','selectstatic');
            $form->setType('architecte', 'selectstatic');
            $form->setType('erp_class_cat','selectstatic');
            $form->setType('erp_class_type','selectstatic');
            $form->setType('ctx_objet_recours','selectstatic');
            $form->setType('ctx_moyen_souleve','select_multiple_static');
            $form->setType('ctx_moyen_retenu_juge','select_multiple_static');
            $form->setType('dpc_type','selectstatic');
            $form->setType('mh_design_type_protect','selectstatic');
            $form->setType('mh_design_nature_prop','selectstatic');
        }

        // Anciens champs à conserver pour les anciens cerfa
        $form->setType("co_statio_avt_shob", "hidden");
        $form->setType("co_statio_apr_shob", "hidden");
        $form->setType("co_statio_avt_surf", "hidden");
        $form->setType("co_statio_apr_surf", "hidden");
        $form->setType("co_trx_amgt", "hidden");
        $form->setType("co_modif_aspect", "hidden");
        $form->setType("co_modif_struct", "hidden");
        $form->setType("co_trx_imm", "hidden");
        $form->setType("co_cstr_shob", "hidden");
        $form->setType("am_voyage_deb", "hidden");
        $form->setType("am_voyage_fin", "hidden");
        $form->setType("am_modif_amgt", "hidden");
        $form->setType("am_lot_max_shob", "hidden");
        $form->setType("mod_desc", "hidden");
        $form->setType("tr_total", "hidden");
        $form->setType("tr_partiel", "hidden");
        $form->setType("tr_desc", "hidden");
        $form->setType("avap_co_clot", "hidden");
        $form->setType("avap_aut_coup_aba_arb", "hidden");
        $form->setType("avap_ouv_infra", "hidden");
        $form->setType("avap_aut_inst_mob", "hidden");
        $form->setType("avap_aut_plant", "hidden");
        $form->setType("avap_aut_auv_elec", "hidden");
        $form->setType("tax_dest_loc_tr", "hidden");


        //Cache les champs des clés étrangères, elles sont renseignées automatiquement
        $form->setType('dossier_instruction', 'hidden');
        $form->setType('lot', 'hidden');
        $form->setType('cerfa', 'hidden');
        
        // Boucler sur les champs des données techniques pour cacher les données qui ne
        // doivent pas être saisies

        foreach ($this->champs as $champ) {
            if(array_search($champ, $this->cerfa->champs) !== false) {
                if($this->cerfa->getVal($champ) == 'f') {
                    $form->setType($champ,'hidden');
                }
            } else {
                $id_tab_surface = $this->cerfa->getVal("tab_surface");
                $id_tab_surface2 = $this->cerfa->getVal("tab_surface2");
                $id_tab_tax_su_princ = $this->cerfa->getVal("tab_tax_su_princ");
                $id_tab_tax_su_heber = $this->cerfa->getVal("tab_tax_su_heber");
                $id_tab_tax_su_secon = $this->cerfa->getVal("tab_tax_su_secon");
                $id_tab_tax_su_tot = $this->cerfa->getVal("tab_tax_su_tot");
                $id_tab_tax_su_non_habit_surf = $this->cerfa->getVal("tab_tax_su_non_habit_surf");
                $id_tab_tax_su_parc_statio_expl_comm = $this->cerfa->getVal("tab_tax_su_parc_statio_expl_comm");
                $id_tab_tax_am = $this->cerfa->getVal("tab_tax_am");
                $id_tab_erp_eff = $this->cerfa->getVal("tab_erp_eff");
                $hidden = true;

                // On cache tous les champs
                $form->setType($champ,'hidden');

                // On défini l'affichage des champs des tableaux de configuration
                // Si les tableau sont définis dans le cerfa on test si les champs des données
                // techniques sont définis dans les tableaux de configuration des tableaux
                // pour chaque cerfa  alors on les affiche en type "text"
                if(!empty($id_tab_surface)) {
                    if(in_array($champ, $tab_surface[$this->cerfa->getVal("tab_surface")]['values'])) {
                        $hidden = false;
                    }
                }
                if(!empty($id_tab_surface2)) {
                    if(in_array($champ, $tab_surface2[$this->cerfa->getVal("tab_surface2")]['values'])) {
                        $hidden = false;
                    }
                }
                if(!empty($id_tab_tax_su_princ)) {
                    if(in_array($champ, $tab_tax_su_princ[$this->cerfa->getVal("tab_tax_su_princ")]['values'])) {
                        $hidden = false;
                    }
                }
                if(!empty($id_tab_tax_su_heber)) {
                    if(in_array($champ, $tab_tax_su_heber[$this->cerfa->getVal("tab_tax_su_heber")]['values'])) {
                        $hidden = false;
                    }
                }
                if(!empty($id_tab_tax_su_secon)) {
                    if(in_array($champ, $tab_tax_su_secon[$this->cerfa->getVal("tab_tax_su_secon")]['values'])) {
                        $hidden = false;
                    }
                }
                if(!empty($id_tab_tax_su_tot)) {
                    if(in_array($champ, $tab_tax_su_tot[$this->cerfa->getVal("tab_tax_su_tot")]['values'])) {
                        $hidden = false;
                    }
                }
                if(!empty($id_tab_tax_su_non_habit_surf)) {
                    if(in_array($champ, $tab_tax_su_non_habit_surf[$this->cerfa->getVal("tab_tax_su_non_habit_surf")]['values'])) {
                        $hidden = false;
                    }
                }
                if(!empty($id_tab_tax_su_parc_statio_expl_comm)) {
                    if(in_array($champ, $tab_tax_su_parc_statio_expl_comm[$this->cerfa->getVal("tab_tax_su_parc_statio_expl_comm")]['values'])) {
                        $hidden = false;
                    }
                }
                if(!empty($id_tab_tax_am)) {
                    if(in_array($champ, $tab_tax_am[$this->cerfa->getVal("tab_tax_am")]['values'])) {
                        $hidden = false;
                    }
                }
                if(!empty($id_tab_erp_eff)) {
                    if(in_array($champ, $tab_erp_eff[$this->cerfa->getVal("tab_erp_eff")]['values'])) {
                        $hidden = false;
                    }
                }

                if(!$hidden){
                    if($maj < 2) {
                        $form->setType($champ,'text');
                    } else {
                        $form->setType($champ,'static');
                    }
                    
                }
            }
        }
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        // parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $this->retourformulaire = $retourformulaire;
        //
        if ($validation == 0) {
            // Si on est dans le dossier
            if ($this->getParameter("retourformulaire") == "dossier"
                || $this->getParameter("retourformulaire") == "dossier_instruction") {
                //
                $form->setVal("dossier_instruction", $this->getParameter("idxformulaire"));
                $form->setVal("lot", "");
            }
            //Si on est dans le lot
            if ($this->getParameter("retourformulaire") == "lot") {
                $form->setVal("dossier_instruction", "");
                $form->setVal("lot", $this->getParameter("idxformulaire"));
            }
        }
        //
        $this->set_form_default_values($form, $maj, $validation);
    }

    /**
     * (SURCHARGE) om_dbform::setValF
     *
     * Traitements réalisés :
     *  1- Pour les champs 'co_projet_desc', 'ope_proj_desc', 'am_projet_desc', 'dm_projet_desc',
     *     'mh_design_appel_denom' et 'mh_loc_denom'
     *     remplace les espaces non sécables (&nbsp) par des espaces sécable
     *
     * @param array $val Tableau des valeurs brutes.
     *
     * @return void
     */
    function setvalF($val = array()){
        parent::setvalF($val);
        // Tableau contenant les champs pour
        // lesquels il faut des espaces sécables
        $champs_espace_secable = array(
            'co_projet_desc',
            'ope_proj_desc',
            'am_projet_desc',
            'dm_projet_desc',
            'mh_design_appel_denom',
            'mh_loc_denom',
        );
        // Traitement des champs
        foreach ($champs_espace_secable as $champ) {
            if (!empty($this->valF[$champ])) {
                $this->valF[$champ] = $this->f->replace_non_breaking_space($this->valF[$champ]);
            }
        }
    }

    function setLib(&$form,$maj) {
        parent::setLib($form,$maj);
        //libelle des champs
        $form->setLib('tab_surface', "");
        $form->setLib('tab_surface2', "");
        $form->setLib('tab_tax_su_princ', "");
        $form->setLib('tab_tax_su_heber', "");
        $form->setLib('tab_tax_su_secon', "");
        $form->setLib('tab_tax_su_tot', "");
        $form->setLib('tab_tax_su_non_habit_surf', "");
        $form->setLib('tab_tax_su_parc_statio_expl_comm', "");
        $form->setLib('tab_tax_am', "");
        $form->setLib('tab_erp_eff', "");

        // Champs select_multiple
        $form->setLib('ctx_moyen_souleve', _("ctx_moyen_souleve"));
        $form->setLib('ctx_moyen_retenu_juge', _("ctx_moyen_retenu_juge"));

        //
        $form->setLib("x1l_legislation", __("a déjà fait l'objet d'une demande d'autorisation ou d'une déclaration au titre d'une autre législation que celle du code de l'urbanisme"));
        $form->setLib("x1p_precisions", __("a déjà fait l'objet d'une demande d'autorisation ou d'une déclaration au titre d'une autre législation que celle du code de l'urbanisme (Précisez laquelle)"));
        $form->setLib("x1u_raccordement", __("est soumis à une obligation de raccordement à un réseau de chaleur et de froid prévue à l'article L.712-3 du code de l'énergie"));
        $form->setLib("x2m_inscritmh", __("porte sur un immeuble inscrit au titre des monuments historiques"));
        $form->setLib("s1na1_numero", __("numéro"));
        $form->setLib("s1va1_voie", __("voie"));
        $form->setLib("s1wa1_lieudit", __("lieu-dit"));
        $form->setLib("s1la1_localite", __("localité"));
        $form->setLib("s1pa1_codepostal", __("code postal"));
        $form->setLib("s1na2_numero", __("numéro"));
        $form->setLib("s1va2_voie", __("voie"));
        $form->setLib("s1wa2_lieudit", __("lieu-dit"));
        $form->setLib("s1la2_localite", __("localité"));
        $form->setLib("s1pa2_codepostal", __("code postal"));
        $form->setLib("e3c_certification", __("En application de l'article L.441-4 du code de l'urbanisme, je certifie avoir fait appel aux compétences nécessaires en matière d'architecture, d'urbanisme et de paysage pour l'établissement du projet architectural, paysager et environnemental."));
        $form->setLib("e3a_competence", __("Si la surface du terrain à aménager est supérieure à 2 500 m², je certifie qu'un architecte au sens de l'article 9 de la loi n° 77-2 du 3 janvier 1977 sur l'architecture, ou qu'un paysagiste-concepteur au sens de l'article 174 de la loi n° 2016-1087 du 8 août 2016 pour la reconquête de la biodiversité, de la nature et des paysages, a participé à l'établissement du projet architectural, paysager et environnemental."));
        $form->setLib("a4d_description", __("Courte description du lieu concerné"));
        $form->setLib("m2b_abf", __("à l'Architecte des Bâtiments de France"));
        $form->setLib("m2j_pn", __("au Directeur du Parc National"));
        $form->setLib("m2r_cdac", __("au Secrétaire de la Commission Départementale d'Aménagement Commercial "));
        $form->setLib("m2r_cnac", __("au Secrétaire de la Commission Nationale d'Aménagement Commercial"));
        $form->setLib("u3a_voirieoui", __("Oui"));
        $form->setLib("u3f_voirienon", __("Non"));
        $form->setLib("u3c_eauoui", __("Oui"));
        $form->setLib("u3h_eaunon", __("Non"));
        $form->setLib("u3g_assainissementoui", __("Oui"));
        $form->setLib("u3n_assainissementnon", __("Non"));
        $form->setLib("u3m_electriciteoui", __("Oui"));
        $form->setLib("u3b_electricitenon", __("Non"));
        $form->setLib("u3t_observations", "");
        $form->setLib("u1a_voirieoui", __("Oui"));
        $form->setLib("u1v_voirienon", __("Non"));
        $form->setLib("u1q_voirieconcessionnaire", __("Par quel service ou concessionnaire ?"));
        $form->setLib("u1b_voirieavant", __("Avant le"));
        $form->setLib("u1j_eauoui", __("Oui"));
        $form->setLib("u1t_eaunon", __("Non"));
        $form->setLib("u1e_eauconcessionnaire", __("Par quel service ou concessionnaire ?"));
        $form->setLib("u1k_eauavant", __("Avant le"));
        $form->setLib("u1s_assainissementoui", __("Oui"));
        $form->setLib("u1d_assainissementnon", __("Non"));
        $form->setLib("u1l_assainissementconcessionnaire", __("Par quel service ou concessionnaire ?"));
        $form->setLib("u1r_assainissementavant", __("Avant le"));
        $form->setLib("u1c_electriciteoui", __("Oui"));
        $form->setLib("u1u_electricitenon", __("Non"));
        $form->setLib("u1m_electriciteconcessionnaire", __("Par quel service ou concessionnaire ?"));
        $form->setLib("u1f_electriciteavant", __("Avant le"));
        $form->setLib("u2a_observations", "");
        $form->setLib("f1ts4_surftaxestation", __("Surface taxable créée des parcs de stationnement couverts faisant l'objet d'une exploitation commerciale, ainsi que des locaux clos et couverts à usage de stationnement non situés dans la verticalité du bâti (en m²)"));
        $form->setLib("f1ut1_surfcree", __("Surface taxable créée des locaux clos et couverts à usage de stationnement situés dans la verticalité du bâti (en m²)"));
        $form->setLib("f9d_date", __("Date de la déclaration"));
        $form->setLib("f9n_nom", __("Nom du déclarant"));
        $form->setLib("dia_droit_reel_perso_grevant_bien_desc", __("Précision"));
        $form->setLib("dia_mod_cess_paie_nat_desc", __("Précision"));
        $form->setLib("dia_mod_cess_rente_viag_desc", __("Précision"));
        $form->setLib("dia_mod_cess_echange_desc", __("Précision"));
        $form->setLib("dia_mod_cess_apport_societe_desc", __("Précision"));
        $form->setLib("dia_mod_cess_cess_terr_loc_co_desc", __("Précision"));
        $form->setLib("dia_mod_cess_esti_imm_loca_desc", __("Précision"));
        $form->setLib("dia_mod_cess_adju_obl_desc", __("Précision"));
        $form->setLib("dia_mod_cess_adju_fin_indivi_desc", __("Précision"));
        $form->setLib("dia_cadre_titul_droit_prempt", __("Cadre réservé au titulaire du droit de préemption"));
        $form->setLib("dia_mairie_prix_moyen", __("Prix moyen au m²"));
        $form->setLib("dia_propri_indivi", __("Si le bien est en indivision, indiquer le(s) nom(s)de l'(des) autres co-indivisaires et sa (leur) quote-part"));
        $form->setLib("dia_situa_bien_plan_cadas_oui", __("OUI"));
        $form->setLib("dia_situa_bien_plan_cadas_non", __("NON"));
        $form->setLib("dia_notif_dec_titul_adr_prop", __("A l'adresse du (des) propriétaire(s) mentionné(s) à la rubrique A"));
        $form->setLib("dia_notif_dec_titul_adr_prop_desc", __("Précision"));
        $form->setLib("dia_notif_dec_titul_adr_manda", __("A l'adresse du mandataire mentionnée à la rubrique H, adresse où le(s) propriétaire(s) a (ont) fait élection de domicile"));
        $form->setLib("dia_notif_dec_titul_adr_manda_desc", __("Précision"));
        $form->setLib("dia_dia_dpu", __("Soumis au droit de préemption urbain (D.P.U) (articles L. 211-1 et suivants du Code de l'urbanisme)"));
        $form->setLib("dia_dia_zad", __("Compris dans une zone d'aménagement différé (Z.A.D.) (articles L.212-1- et suivants du Code de l'urbanisme)"));
        $form->setLib("dia_dia_zone_preempt_esp_natu_sensi", __("Compris dans une zone de préemption délimitée au titre des espaces naturels sensibles de départements (articles L. 142-1- et suivants du Code de l'urbanisme"));
        $form->setLib("dia_dab_dpu", __("Soumis au droit de préemption urbain (D.P.U.)"));
        $form->setLib("dia_dab_zad", __("Compris dans une zone d'aménagement différé (Z.A.D.)"));
        $form->setLib("dia_mod_cess_commi_mnt", __("Montant de la commision"));
        $form->setLib("dia_mod_cess_commi_mnt_ttc", __("Le montant de la commission est TTC"));
        $form->setLib("dia_mod_cess_commi_mnt_ht", __("Le montant de la commission est HT"));
        $form->setLib("dia_mod_cess_prix_vente_num", __("Prix de vente ou évaluation (en chiffres)"));
        $form->setLib("dia_mod_cess_prix_vente_mob_num", __("Mobilier"));
        $form->setLib("dia_mod_cess_prix_vente_cheptel_num", __("Cheptel"));
        $form->setLib("dia_mod_cess_prix_vente_recol_num", __("Récoltes"));
        $form->setLib("dia_mod_cess_prix_vente_autre_num", __("Autres"));
        $form->setLib("dia_su_co_sol_num", __("Surface construite au sol (en m²)"));
        $form->setLib("dia_su_util_hab_num", __("Surface utile ou habitable (en m²)"));
        $form->setLib("dia_mod_cess_mnt_an_num", __("Montant annuel"));
        $form->setLib("dia_mod_cess_mnt_compt_num", __("Montant comptant"));
        $form->setLib("dia_mod_cess_mnt_soulte_num", __("Montant de la soulte le cas échéant"));
        $form->setLib("dia_comp_prix_vente", __("Prix de vente (en €)"));
        $form->setLib("dia_comp_surface", __("Surface (en m²)"));
        $form->setLib("dia_comp_total_frais", __("Total des frais (en €)"));
        $form->setLib("dia_comp_mtn_total", __("Total (en €)"));
        $form->setLib("dia_comp_valeur_m2", __("Valeur au m² (en €)"));
        $form->setLib("dia_esti_prix_france_dom", __("Estimation du prix de vente par France Domaine"));
        $form->setLib("dia_prop_collectivite", __("Proposition d'acquisition de la collectivité"));
        $form->setLib("dia_delegataire_denomination", __("Dénomination"));
        $form->setLib("dia_delegataire_raison_sociale", __("Raison sociale"));
        $form->setLib("dia_delegataire_siret", __("Siret"));
        $form->setLib("dia_delegataire_categorie_juridique", __("Catégorie juridique"));
        $form->setLib("dia_delegataire_representant_nom", __("Nom du représentant"));
        $form->setLib("dia_delegataire_representant_prenom", __("Prénom du représentant"));
        $form->setLib("dia_delegataire_adresse_numero", __("Numéro"));
        $form->setLib("dia_delegataire_adresse_voie", __("Voie"));
        $form->setLib("dia_delegataire_adresse_complement", __("Complément"));
        $form->setLib("dia_delegataire_adresse_lieu_dit", __("Lieu-dit"));
        $form->setLib("dia_delegataire_adresse_localite", __("Localité"));
        $form->setLib("dia_delegataire_adresse_code_postal", __("Code postal"));
        $form->setLib("dia_delegataire_adresse_bp", __("BP"));
        $form->setLib("dia_delegataire_adresse_cedex", __("Cedex"));
        $form->setLib("dia_delegataire_adresse_pays", __("Pays"));
        $form->setLib("dia_delegataire_telephone_fixe", __("Téléphone fixe"));
        $form->setLib("dia_delegataire_telephone_mobile", __("Téléphone mobile"));
        $form->setLib("dia_delegataire_telephone_mobile_indicatif", __("Indicatif"));
        $form->setLib("dia_delegataire_courriel", __("Courriel"));
        $form->setLib("dia_delegataire_fax", __("Fax"));
        $form->setLib("dia_entree_jouissance_type", __("Type"));
        $form->setLib("dia_entree_jouissance_date", __("Date"));
        $form->setLib("dia_entree_jouissance_date_effet", __("Date d'effet"));
        $form->setLib("dia_entree_jouissance_com", __("Commentaire"));
        $form->setLib("dia_remise_bien_date_effet", __("Date d'effet"));
        $form->setLib("dia_remise_bien_com", __("Commentaire"));

        //
        $form->setLib("co_bat_niv_nb", __("au-dessus du sol"));
        $form->setLib("c2zp1_crete", __("Indiquez sa puissance crête"));
        $form->setLib("c2zr1_destination", __("Indiquez la destination principale de lénergie solaire"));

        //
        $form->setLib("daact_surf", __("Surface de plancher créée (en m2)"));

        //
        $form->setLib("mh_design_appel_denom", __('Appellation / dénomination'));
        $form->setLib("mh_design_type_protect", __('Type de protection'));
        $form->setLib("mh_design_elem_prot", __('Élément(s) protégé(s)'));
        $form->setLib("mh_design_ref_merimee_palissy", __('Référence Mérimée ou Palissy'));
        $form->setLib("mh_design_nature_prop", __('Nature de la propriété'));
        $form->setLib("mh_loc_denom", __('Dénomination de l’immeuble'));
        $form->setLib("mh_pres_intitule", __('Intitulé de l’opération'));
        $form->setLib("mh_trav_cat_1", __('Fondations, sous-sol'));
        $form->setLib("mh_trav_cat_2", __('Structure, maçonnerie, gros-œuvre'));
        $form->setLib("mh_trav_cat_3", __('Parements, enduits, restauration de façades'));
        $form->setLib("mh_trav_cat_4", __('Charpente, couverture'));
        $form->setLib("mh_trav_cat_5", __('Menuiseries, métallerie, vitraux'));
        $form->setLib("mh_trav_cat_6", __('Cloisons, revêtements intérieurs, décors'));
        $form->setLib("mh_trav_cat_7", __('Équipements techniques, sécurité, sureté, accessibilité'));
        $form->setLib("mh_trav_cat_8", __('Voirie et réseaux divers'));
        $form->setLib("mh_trav_cat_9", __('Affouillements ou exhaussements'));
        $form->setLib("mh_trav_cat_10", __('Sculptures'));
        $form->setLib("mh_trav_cat_11", __('Parcs, jardins et bois'));
        $form->setLib("mh_trav_cat_12", __('Autres'));
        $form->setLib("mh_trav_cat_12_prec", __('Préciser'));
    }

    function setLayout(&$form, $maj) {

        // Cadre réservé à l’administration / Mairie
        $form->setBloc('m2b_abf', 'D', "", "col_12");
        $form->setFieldset('m2b_abf', 'D', __("Cadre réservé à l’administration / Mairie"), "startClosed");
        // Dossier transmis
        $form->setFieldset('m2b_abf', 'D', __("Dossier transmis"), "alignFormSpec");
        $form->setFieldset('m2r_cnac', 'F', "", "");
        // État des équipements publics existants
        $form->setFieldset('u3a_voirieoui', 'D', __("État des équipements publics existants"), "alignFormSpec");
        // Voirie
        $form->setBloc('u3a_voirieoui', 'D', __("Voirie"), "alignFormSpec group");
        $form->setBloc('u3f_voirienon', 'F', "", "");
        // Eau
        $form->setBloc('u3c_eauoui', 'D', __("Eau"), "alignFormSpec group");
        $form->setBloc('u3h_eaunon', 'F', "", "");
        // Assainissement
        $form->setBloc('u3g_assainissementoui', 'D', __("Assainissement"), "alignFormSpec group");
        $form->setBloc('u3n_assainissementnon', 'F', "", "");
        // Électricité
        $form->setBloc('u3m_electriciteoui', 'D', __("Électricité"), "alignFormSpec group");
        $form->setBloc('u3b_electricitenon', 'F', "", "");
        // Observation
        $form->setBloc('u3t_observations', 'DF', __("Observation"), "alignFormSpec");
        $form->setFieldset('u3t_observations', 'F', "", "");
        // État des équipements publics prévu
        $form->setFieldset('u1a_voirieoui', 'D', __("État des équipements publics prévu"), "alignFormSpec");
        // Voirie
        $form->setBloc('u1a_voirieoui', 'D', __("Voirie"), "alignFormSpec group");
        $form->setBloc('u1b_voirieavant', 'F', "", "");
        // Eau
        $form->setBloc('u1j_eauoui', 'D', __("Eau"), "alignFormSpec group");
        $form->setBloc('u1k_eauavant', 'F', "", "");
        // Assainissement
        $form->setBloc('u1s_assainissementoui', 'D', __("Assainissement"), "alignFormSpec group");
        $form->setBloc('u1r_assainissementavant', 'F', "", "");
        // Électricité
        $form->setBloc('u1c_electriciteoui', 'D', __("Électricité"), "alignFormSpec group");
        $form->setBloc('u1f_electriciteavant', 'F', "", "");
        // Observation
        $form->setBloc('u2a_observations', 'DF', __("Observation"), "alignFormSpec");
        $form->setFieldset('u2a_observations', 'F', "", "");
        $form->setFieldset('u2a_observations', 'F', '');
        $form->setBloc('u2a_observations', 'F', "", "");

        // Terrain
        $form->setBloc('terr_juri_titul','D',"","col_12");
            $form->setFieldset('terr_juri_titul','D'
                               ,_("Terrain"), "startClosed");

                $form->setBloc('terr_juri_titul','D',_("Situation juridique du terrain"), "col_12 alignFormSpec");
                $form->setBloc('terr_juri_desc','F');
                // $form->setBloc('terr_juri_desc','DF',"", "group");
                $form->setBloc('terr_div_surf_etab','D',_("Terrain issu d'une division de propriete"), "col_12 alignFormSpec");
                $form->setBloc('terr_div_surf_av_div', 'F');

            $form->setFieldset('terr_div_surf_av_div','F','');
            
        $form->setBloc('terr_div_surf_av_div','F');

        // Description de la demande / du projet
        $form->setFieldset('ope_proj_desc', 'D',
            _("Description de la demande / du projet"), "col_12 startClosed");
            $form->setBloc('ope_proj_desc', 'D', "", "col_12 alignFormSpec");
            $form->setBloc('ope_proj_div_contr', 'F');
        $form->setFieldset('ope_proj_div_contr', 'F');

        // Construire, aménager ou modifier un ERP
        $form->setBloc('erp_class_cat','D',"","col_12");
            $form->setFieldset('erp_class_cat','D'
                               ,_("Construire, amenager ou modifier un ERP"), "startClosed");

            $form->setBloc('erp_class_cat','DF', _("Activite"),"alignFormSpec");
            $form->setBloc('erp_class_type','DF', "","alignFormSpec");

            $form->setBloc('erp_cstr_neuve','D', _("Nature des travaux (plusieurs cases possibles)"),"col_12 alignFormSpec");
            $form->setBloc('erp_trvx_adap_numero','D', "","group");
            $form->setBloc('erp_trvx_adap_valid','F');
            $form->setBloc('erp_prod_dangereux','F');

            $form->setBloc('tab_erp_eff','D',_("Effectif"),"col_12");
                $form->setBloc('tab_erp_eff','DF', "", "col_12");
            $form->setBloc('tab_erp_eff','F', "","");

            $form->setFieldset('tab_erp_eff','F', '');
        $form->setBloc('tab_erp_eff','F');

        // Aménager
        $form->setBloc('am_lotiss','D',"","col_12");
            $form->setFieldset('am_lotiss','D'
                                       ,_("Amenager"), "startClosed");
                $form->setBloc('am_lotiss','D',"","col_12");
                    $form->setFieldset('am_lotiss','D'
                                       ,_("Projet d'amenagement"), "startClosed alignFormSpec");
                        // bloc 4.1
                        $form->setBloc('am_lotiss','DF',_("Nature des travaux, installations
                                       ou amenagements envisages"), "group");
                        $form->setBloc('am_div_mun','DF',"", "group");
                        $form->setBloc('am_autre_div','DF',"", "group");
                        $form->setBloc('am_camping','DF',"", "group");
                        $form->setBloc('am_parc_resid_loi','DF',"", "group");
                        $form->setBloc('am_sport_moto','DF',"", "group");
                        $form->setBloc('am_sport_attrac','DF',"", "group");
                        $form->setBloc('am_sport_golf','DF',"", "group");
                        $form->setBloc('am_caravane','DF',"", "group");
                        $form->setBloc('am_carav_duree','DF',"", "group");
                        $form->setBloc('am_statio','DF',"", "group");
                        $form->setBloc('am_statio_cont','DF',"", "group");
                        $form->setBloc('am_affou_exhau','DF',"", "group");
                        $form->setBloc('am_affou_exhau_sup','DF',"", "group");
                        $form->setBloc('am_affou_prof','DF',"", "group");
                        $form->setBloc('am_exhau_haut','DF',"", "group");
                        $form->setBloc('am_terr_res_demon','DF',"", "group");
                        $form->setBloc('am_air_terr_res_mob','DF',"", "group");
                        
                        $form->setBloc('am_chem_ouv_esp','D',_("Dans les secteurs proteges :"),"col_12");
                            $form->setBloc('am_chem_ouv_esp','DF',_("Amenagement situe dans un espace remarquable :"), "group");
                            $form->setBloc('am_agri_peche','DF',"", "group");
                            
                            $form->setBloc('am_crea_voie','DF',_("Aménagement situé dans le périmètre d’un site patrimonial remarquable ou dans les abords des monuments historiques"), "group");
                            $form->setBloc('am_modif_voie_exist','DF',"", "group");
                            $form->setBloc('am_crea_esp_sauv','DF',"", "group");
                            
                            $form->setBloc('am_crea_esp_class','DF',_("Amenagement situe dans un site classe ou une reserve naturelle 1 :"), "group");
                            $form->setBloc('am_coupe_abat','DF',"", "group");
                            $form->setBloc('am_prot_plu','DF',"", "group");
                            $form->setBloc('am_prot_muni','DF',"", "group");
                            $form->setBloc('am_mobil_voyage','DF',"", "group");
                            $form->setBloc('am_aire_voyage','DF',"", "group");
                            $form->setBloc('am_rememb_afu','DF',"", "group");
                            $form->setBloc('co_ouvr_infra','DF',"", "group");
                        $form->setBloc('co_ouvr_infra','F');

                        $form->setBloc('am_mob_art','DF',_("Dans un secteur sauvegarde, site classe ou reserve naturelle :"), "group");
                        $form->setBloc('am_modif_voie_esp','DF',"", "group");
                        $form->setBloc('am_plant_voie_esp','DF',"", "group");
                        $form->setBloc('co_ouvr_elec','DF',"", "group");
                    $form->setFieldset('co_ouvr_elec','F','');
                $form->setBloc('co_ouvr_elec','F');
                $form->setBloc('am_projet_desc','D',"","col_12 alignFormSpec");
                    $form->setFieldset('am_projet_desc','D'
                                       ,_("Description amenagement"), "startClosed");
                        // $form->setBloc('am_projet_desc','DF',"", "group");
                        // $form->setBloc('am_terr_surf','DF',"", "alignFormSpec");
                        // $form->setBloc('am_tranche_desc','DF',"", "group");
                    $form->setFieldset('am_tranche_desc','F','');
                $form->setBloc('am_tranche_desc','F');
                $form->setBloc('am_lot_max_nb','D',"","col_12");
                    $form->setFieldset('am_lot_max_nb','D'
                                       ,_("Complement d'amenagement"), "startClosed");
                        // bloc 4.2
                        $form->setBloc('am_lot_max_nb','D',_("Demande concernant un lotissement"),"col_12 alignFormSpec");
                        
                            $form->setBloc('am_lot_max_nb','DF',"", "group");
                            $form->setBloc('am_lot_max_shon','DF',"", "group");
                        
                            $form->setBloc('am_lot_cstr_cos','DF',_("Comment la constructibilite globale sera-t-elle repartie ?"), "group");
                            $form->setBloc('am_lot_cstr_plan','DF',"", "group");
                            $form->setBloc('am_lot_cstr_vente','DF',"", "group");
                            $form->setBloc('am_lot_fin_diff','DF',"", "group");
                            
                            $form->setBloc('am_lot_consign','DF',_("si oui, quelle garantie sera utilisee ?"), "group");
                            $form->setBloc('am_lot_gar_achev','DF',"", "group");
                            $form->setBloc('am_lot_vente_ant','DF',"", "group");
                        $form->setBloc('am_lot_vente_ant','F');

                        // bloc 4.3
                        $form->setBloc('am_exist_agrand','D',_("Amenagement d'un camping ou
                                       d'un terrain amenage en vue de l'hebergement
                                       touristique"),"col_12");
                                       
                            $form->setBloc('am_exist_agrand','DF',"", "alignFormSpec");
                                $form->setBloc('am_exist_date','DF',"", "alignFormSpec");
                                $form->setBloc('am_exist_num','D',"", "alignFormSpec");
                            $form->setBloc('am_empl_nb','F',"", "");
                            
                            $form->setBloc('am_tente_nb','D',_("Nombre maximum d’emplacements reserves aux :"), "col_12 alignForm");
                            $form->setBloc('am_mobil_nb','F',"", "");
                            
                            $form->setBloc('am_pers_nb','DF',"", "alignFormSpec group");
                            
                            $form->setBloc('am_empl_hll_nb','D',_("Implantation d’habitations legeres de loisirs (HLL) :"), "col_12 alignFormSpec");
                            //$form->setBloc('am_empl_hll_nb','DF',"", "group");
                            $form->setBloc('am_hll_shon','F');
                                
                            $form->setBloc('am_periode_exploit','DF',"", "group");
                            
                            $form->setBloc('a4d_description','D',_("Declaration de coupe et/ou abattage d’arbres :"),"col_12 cerfasubtitle alignFormSpec");
                                
                                $form->setBloc('a4d_description','D',_("Courte description du lieu :"), "cerfasubtitle");
                                    $form->setBloc('a4d_description','DF', "", "cerfasubtitle group");
                                    $form->setBloc('am_coupe_bois','D', "", "cerfasubtitle group");
                                    $form->setBloc('am_coupe_align','F',"", "");
                                $form->setBloc('am_coupe_align','F',"", "");
                                
                                $form->setBloc('am_coupe_ess','D',_("Nature du boisement :"),"col_12 cerfasubtitle");
                                $form->setBloc('am_coupe_autr','F');
                            $form->setBloc('am_coupe_autr','F');
                        $form->setBloc('am_coupe_autr','F');


                    $form->setFieldset('am_coupe_autr','F','');
                
                $form->setBloc('am_coupe_autr','F');
            $form->setFieldset('am_coupe_autr','F','');
        $form->setBloc('am_coupe_autr','F');
        // Fin amménager
        // Construire
        $form->setBloc('co_archi_recours','D',"","col_12");
            $form->setFieldset('co_archi_recours','D'
                               ,_("Construire"), "startClosed");
                $form->setBloc('co_archi_recours','D', "","col_12");
                    $form->setFieldset('co_archi_recours','D'
                               ,_("Projet construction"), "startClosed");
                
                        $form->setBloc('co_archi_recours','D',_("Architecte"), "col_12 alignFormSpec");
                        $form->setBloc('co_archi_attest_honneur','F');
                        
                        $form->setBloc('co_cstr_nouv','D',_("Nature du projet"), "col_12 alignFormSpec");
                        $form->setBloc('co_projet_desc','F');

                        $form->setBloc('co_elec_tension','DF', __("Si votre projet nécessite une puissance électrique supérieure à 12 kVA monophasé (ou 36 kVA triphasé)"), "col_12 alignFormSpec");
                        $form->setBloc('c2zp1_crete','D', __("Si votre projet est un ouvrage de production d'électricité à partir de l'énergie solaire installé sur le sol"), "col_12 alignFormSpec");
                        $form->setBloc('c2zr1_destination','F');

                        $form->setBloc('co_bat_projete','D',__("Note descriptive succincte du projet"), "col_12 alignFormSpec");
                        $form->setBloc('co_bat_nature','F');
                    $form->setFieldset('co_bat_nature','F','');

                    $form->setFieldset('co_tot_log_nb','D'
                               ,_("Complement construction"), "startClosed");
                        $form->setBloc('co_tot_log_nb','D',"", "alignForm");
                        $form->setBloc('co_tot_log_nb','D',"", "group");
                        $form->setBloc('co_tot_coll_nb','F',"", "");
                        $form->setBloc('co_mais_piece_nb','D',"", "group");
                        $form->setBloc('co_mais_niv_nb','F',"", "");
                        $form->setBloc('co_mais_niv_nb','F');

                        $form->setBloc('co_fin_lls','D', __("Mode de financement du projet :"),"col_12 alignFormSpec");
                            $form->setBloc('co_fin_lls','D',"", "group");
                            $form->setBloc('co_fin_ptz','F',"", "");
                            $form->setBloc('co_fin_autr','DF',"", "");
                        $form->setBloc('co_fin_autr','F');

                        $form->setBloc('co_fin_lls_nb','D', _("Repartition du nombre total de logement crees par type de financement :"),"col_12");
                            $form->setBloc('co_fin_lls_nb','D',"", "alignFormSpec");
                            $form->setBloc('co_fin_autr_nb','F',"", "");
                            
                            $form->setBloc('co_fin_autr_desc','DF',"", "alignFormSpec group");
                            $form->setBloc('co_mais_contrat_ind','DF',"", "alignFormSpec group");
                        $form->setBloc('co_mais_contrat_ind','F');
                        
                        $form->setBloc('co_uti_pers','D',_("Mode d'utilisation principale des logements :"), "col_12 alignFormSpec");
                            $form->setBloc('co_uti_pers','D', "", "group");
                            $form->setBloc('co_uti_loc','F',"", "");
                        $form->setBloc('co_uti_loc','F',"", "");
                        
                        $form->setBloc('co_uti_princ','D',_("S’il s’agit d’une occupation personnelle, veuillez preciser :"), "col_12 alignFormSpec");
                            $form->setBloc('co_uti_princ','D',"", "group");
                            $form->setBloc('co_uti_secon','F',"", "");
                        $form->setBloc('co_uti_secon','F',"", "");

                        $form->setBloc('co_anx_pisc','D',_("Si le projet porte sur une annexe a l’habitation, veuillez preciser :"), "col_12 alignFormSpec");
                            $form->setBloc('co_anx_pisc','D',"", "group");
                            $form->setBloc('co_anx_autr','F',"", "");
                            $form->setBloc('co_anx_autr_desc','DF',"", "");
                        $form->setBloc('co_anx_autr_desc','F',"", "group");
                        
                        $form->setBloc('co_resid_agees','D',_("Si le projet est un foyer ou une residence, a quel titre :"), "col_12 alignFormSpec");
                            $form->setBloc('co_resid_agees','D',"", "group");
                            $form->setBloc('co_resid_autr','F',"", "");
                            $form->setBloc('co_resid_autr_desc','DF',"", "");
                        $form->setBloc('co_resid_autr_desc','F',"", "group");

                        $form->setBloc('co_foyer_chamb_nb','DF',"", "alignFormSpec");
                        
                        $form->setBloc('co_log_1p_nb','D',_("Repartition du nombre de logements crees selon le nombre de pieces :"), "col_12 alignFormSpec");
                            $form->setBloc('co_bat_niv_nb','D',__("Nombre de niveaux du bâtiment le plus élevé :"), "cerfasubtitle group");
                            $form->setBloc('co_bat_niv_dessous_nb','F',"", "");
                        $form->setBloc('co_bat_niv_dessous_nb','F',"", "group");

                        $form->setBloc('co_trx_exten','D',_("Indiquez si vos travaux comprennent notamment :"), "col_12 alignFormSpec");
                            $form->setBloc('co_trx_exten','D',"", "group");
                            $form->setBloc('co_trx_nivsup','F',"", "");
                            $form->setBloc('co_trx_autre','DF',"", "");
                        $form->setBloc('co_trx_autre','F',"", "");

                        $form->setBloc('co_trav_supp_dessous','D',__("Création de niveaux supplémentaires :"), "col_12 alignFormSpec");
                            $form->setBloc('co_trav_supp_dessous','D', "", "group");
                            $form->setBloc('co_trav_supp_dessus','F',"", "");
                        $form->setBloc('co_trav_supp_dessus','F',"", "");

                        $form->setBloc('co_sp_transport','D',_("Destination des constructions futures en cas de realisation au benefice d'un service public ou d'interet collectif :"), "col_12 alignFormSpec");
                            $form->setBloc('co_sp_transport','D', "", "group");
                            $form->setBloc('co_sp_culture','F',"", "");
                        $form->setBloc('co_sp_culture','F',"", "");

                        $form->setBloc('co_demont_periode','DF', _("Construction periodiquement demontee et re-installee :"),"col_12 alignFormSpec");

                    $form->setFieldset('co_demont_periode','F','');
                    $form->setFieldset('tab_surface','D'
                               ,_("Destinations et surfaces des constructions"), "startClosed");
                        $form->setBloc('tab_surface','D', _("Destination des constructions et tableau des surfaces (uniquement à remplir si votre projet de construction est situé dans une commune couverte par un plan local d’urbanisme ou un document en tenant lieu appliquant l’article R.123-9 du code de l’urbanisme dans sa rédaction antérieure au 1er janvier 2016)."),"col_12 group");
                        $form->setBloc('tab_surface','F');

                        $form->setBloc('tab_surface2','DF', _("Destination, sous-destination des constructions et tableau des surfaces (uniquement à remplir si votre projet de construction est situé dans une commune couverte par le règlement national d’urbanisme, une carte communale ou dans une commune non visée à la rubrique précédente"),"col_12 group");

                    $form->setFieldset('tab_surface2','F','');
                    $form->setFieldset('co_statio_avt_nb','D'
                               ,_("Divers construction"), "startClosed");

                        $form->setBloc('co_statio_avt_nb','D', _("Nombre de places de stationnement"),"col_12");
                            $form->setBloc('co_statio_avt_nb','D', "","alignForm");
                            $form->setBloc('co_statio_apr_nb','F', "","");
                        $form->setBloc('co_statio_apr_nb','F', "","");
                        
                        $form->setBloc('co_statio_adr','D', _("Places de stationnement affectees au projet, amenagees ou reservees en dehors du terrain sur lequel est situe le projet"),"col_12");
                            $form->setBloc('co_statio_adr','DF', "","group");

                            $form->setBloc('s1na1_numero','D', __("Adresse 1 des aires de stationnement"), "alignFormSpec");
                            $form->setBloc('s1pa1_codepostal','F', "","");
                            $form->setBloc('s1na2_numero','D', __("Adresse 2 des aires de stationnement"), "alignFormSpec");
                            $form->setBloc('s1pa2_codepostal','F', "","");

                            $form->setBloc('co_statio_place_nb','D', "","col_12");
                                $form->setBloc('co_statio_place_nb','D', "","alignForm");
                                $form->setBloc('co_statio_tot_shob','F', "","");
                            $form->setBloc('co_statio_tot_shob','F', "","");
                        $form->setBloc('co_statio_tot_shob','F');
                        $form->setBloc('co_statio_comm_cin_surf','D', _("Pour les commerces et cinemas :"),"col_12 alignFormSpec");
                        $form->setBloc('co_perf_energ','F',"", "");
                
                    $form->setFieldset('co_perf_energ','F','');
                $form->setBloc('co_perf_energ','F');

            $form->setFieldset('co_perf_energ','F','');
        
        $form->setBloc('co_perf_energ','F');
        // Fin construire

        /*Fieldset n°6 Projet necessitant demolitions */
        $form->setBloc('dm_constr_dates','D',"","col_12");
            $form->setFieldset('dm_constr_dates','D'
                               ,_("Demolir"), "startClosed");
                $form->setBloc('dm_constr_dates','DF', "","group");
                $form->setBloc('dm_total','D', "","alignFormSpec");
                $form->setBloc('dm_partiel','F');
                $form->setBloc('dm_projet_desc','DF', "","group");
                $form->setBloc('dm_tot_log_nb','DF', "","alignFormSpec");
            $form->setFieldset('dm_tot_log_nb','F','');
        
        $form->setBloc('dm_tot_log_nb','F');

        // Fieldset "Informations pour l’application d’une législation connexe"
        $form->setFieldset('co_inst_ouvr_trav_act_code_envir', 'D', _("Informations pour l’application d’une législation connexe"), "startClosed alignFormSpec col_12");
        $form->setBloc('co_inst_ouvr_trav_act_code_envir', 'D', _('Indiquez si votre projet'), '');
        $form->setBloc('x1u_raccordement', 'F', '');
        $form->setBloc('co_peri_site_patri_remar', 'D', _('Indiquez si votre projet se situe dans les périmètres de protection suivants (informations complémentaires)'), '');
        $form->setBloc('x2m_inscritmh', 'F', '');
        $form->setFieldset('x2m_inscritmh', 'F', '');

        // Fieldset "Engagement du déclarant"
        $form->setBloc('enga_decla_lieu','D',"","col_12");
        $form->setFieldset('enga_decla_lieu','D' ,__("Engagement du déclarant"), "startClosed alignFormSpec");
        $form->setBloc('enga_decla_lieu','DF', "","group");
        $form->setBloc('enga_decla_date','DF', "","group");
        $form->setBloc('enga_decla_donnees_nomi_comm','DF', "","group");
        $form->setBloc('e3c_certification','DF', __("Pour un permis d’aménager un lotissement"), "group");
        $form->setBloc('e3a_competence','DF', "", "group");
        $form->setFieldset('e3a_competence','F','');
        $form->setBloc('e3a_competence','F');

        /*Fieldset n°4 Ouverture de chantier */
        $form->setBloc('doc_date','D',"","col_12");
            $form->setFieldset('doc_date','D'
                               ,_("Ouverture de chantier"), "startClosed alignFormSpec");
                $form->setBloc('doc_date','DF', "","group");
                $form->setBloc('doc_tot_trav','DF', "","group");
                $form->setBloc('doc_tranche_trav','DF', "","group");
                $form->setBloc('doc_tranche_trav_desc','DF', "","group");
                $form->setBloc('doc_surf','DF', "","group");
                $form->setBloc('doc_nb_log','DF', "","group");
                $form->setBloc('doc_nb_log_indiv','DF', "","group");
                $form->setBloc('doc_nb_log_coll','DF', "","group");
                //
                $form->setBloc('doc_nb_log_lls','DF', _("Repartition du nombre de logements commences par type de financement"), "group");
                $form->setBloc('doc_nb_log_aa','DF', "","group");
                $form->setBloc('doc_nb_log_ptz','DF', "","group");
                $form->setBloc('doc_nb_log_autre','DF', "","group");
            $form->setFieldset('doc_nb_log_autre','F','');
        $form->setBloc('doc_nb_log_autre','F');

        /*Fieldset n°4  Achèvement des travaux */
        $form->setBloc('daact_date','D',"","col_12");
            $form->setFieldset('daact_date','D'
                               ,_("Achevement des travaux") , "startClosed alignFormSpec");
                $form->setBloc('daact_date','DF', "","group");
                $form->setBloc('daact_date_chgmt_dest','DF', "","group");
                $form->setBloc('daact_tot_trav','DF', "","group");
                $form->setBloc('daact_tranche_trav','DF', "","group");
                $form->setBloc('daact_tranche_trav_desc','DF', "","group");
                $form->setBloc('daact_surf','DF', "","group");
                $form->setBloc('daact_nb_log','DF', "","group");
                $form->setBloc('daact_nb_log_indiv','DF', "","group");
                $form->setBloc('daact_nb_log_coll','DF', "","group");
                //
                $form->setBloc('daact_nb_log_lls','DF', _("Repartition du nombre de logements commences par type de financement"), "group");
                $form->setBloc('daact_nb_log_aa','DF', "","group");
                $form->setBloc('daact_nb_log_ptz','DF', "","group");
                $form->setBloc('daact_nb_log_autre','DF', "","group");
            $form->setFieldset('daact_nb_log_autre','F','');
        $form->setBloc('daact_nb_log_autre','F');

        // Début DIA
        $form->setBloc('dia_dia_dpu','D',"","col_12");
        $form->setFieldset('dia_dia_dpu','D',_("Déclaration d’intention d’aliéner un bien"), "startClosed alignFormSpec");

            // Cadre réservé à l’administration
            $form->setFieldset('dia_dia_dpu', 'D', __("Cadre réservé à l’administration"), "startClosed alignFormSpec");
            $form->setFieldset('dia_mairie_prix_moyen', 'F');

            // Propriétaire
            $form->setFieldset('dia_propri_indivi', 'DF', __("Propriétaire"), "startClosed alignFormSpec");

            // Situation du bien
            $form->setFieldset('dia_situa_bien_plan_cadas_oui', 'D', __("Situation du bien"), "startClosed");
            $form->setBloc('dia_situa_bien_plan_cadas_oui', 'D', __("Plan(s) cadastral(aux) joint(s)"), "alignForm group");
            $form->setBloc('dia_situa_bien_plan_cadas_non', 'F');
            $form->setFieldset('dia_situa_bien_plan_cadas_non', 'F');

            // Désignation du bien
            $form->setFieldset('dia_imm_non_bati','D',_("Désignation du bien"), "startClosed");

                // Immeuble
                $form->setBloc('dia_imm_non_bati','D', _("Immeuble"),"alignForm group");
                $form->setBloc('dia_imm_bati_terr_autr_desc','F', "","");

                // Occupation du sol en superficie
                $form->setBloc('dia_occ_sol_su_terre','D', _("Occupation du sol en superficie (m²)"),"alignForm group");
                $form->setBloc('dia_occ_sol_su_sol','F', "","");

                //
                $form->setBloc('dia_bati_vend_tot','D', " ","alignForm group");
                $form->setBloc('dia_bati_vend_tot_txt','F', "","");
                $form->setBloc('dia_su_co_sol','D', "","alignForm group");
                $form->setBloc('dia_su_util_hab','F', "","");
                $form->setBloc('dia_nb_niv','D', _("Nombre de"),"alignForm group");
                $form->setBloc('dia_nb_autre_loc','F', "","");
                $form->setBloc('dia_vente_lot_volume','D', " ","alignForm group");
                $form->setBloc('dia_vente_lot_volume_txt','F', "","");

                // Copropriété
                $form->setBloc('dia_bat_copro','D', " ","alignForm group");
                $form->setBloc('dia_bat_copro_desc','F', "","");
                // Tableau lot
                $form->setBloc('dia_lot_numero','D', "","alignForm group");
                $form->setBloc('dia_lot_nat_su','F', "","");
                $form->setBloc('dia_lot_bat_achv_plus_10','D', _("Le bâtiment est achevé depuis"),"alignForm group");
                $form->setBloc('dia_lot_bat_achv_moins_10','F', "","");
                $form->setBloc('dia_lot_regl_copro_publ_hypo_plus_10','D', _("Le réglement de copropriété a été publié aux hypothèques depuis"),"alignForm group");
                $form->setBloc('dia_lot_regl_copro_publ_hypo_moins_10','F', "","");

                //
                $form->setBloc('dia_indivi_quote_part','DF', " ","alignFormSpec");
                $form->setBloc('dia_design_societe','DF', _("Droits sociaux"),"alignFormSpec group");
                $form->setBloc('dia_design_droit','DF', "","alignFormSpec");
                $form->setBloc('dia_droit_soc_nat','D', "","alignForm group");
                $form->setBloc('dia_droit_soc_num_part','F', "","");

            $form->setFieldset('dia_droit_soc_num_part','F','');

            // Usage et occupation
            $form->setFieldset('dia_us_hab','D',_("Usage et occupation"), "startClosed");

                // Usage
                $form->setBloc('dia_us_hab','D', _("Usage"),"alignForm group");
                $form->setBloc('dia_us_autre_prec','F', "","");

                // Occupation
                $form->setBloc('dia_occ_prop','D', _("Occupation"),"alignForm group");
                $form->setBloc('dia_occ_autre_prec','F', "","");

            $form->setFieldset('dia_occ_autre_prec','F','');

            // Droits réels ou personnels
            $form->setFieldset('dia_droit_reel_perso_grevant_bien_oui','D',_("Droits réels ou personnels"), "startClosed");

                //
                $form->setBloc('dia_droit_reel_perso_grevant_bien_oui','D', _("Grevant les biens"),"alignForm group");
                $form->setBloc('dia_droit_reel_perso_grevant_bien_desc','F', "","");

                //
                $form->setBloc('dia_droit_reel_perso_nat','D', " ","alignForm group");
                $form->setBloc('dia_droit_reel_perso_viag','F', "","");

            $form->setFieldset('dia_droit_reel_perso_viag','F','');

            // Modalités de la cession
            $form->setFieldset('dia_mod_cess_prix_vente','D',_("Modalités de la cession"), "startClosed");

                // Vente amiable
                $form->setFieldset('dia_mod_cess_prix_vente','D', _("Vente amiable"), "startClosed");

                $form->setBloc('dia_mod_cess_prix_vente','D', "","alignFormSpec");
                $form->setBloc('dia_mod_cess_prix_vente_num','F');
                $form->setBloc('dia_mod_cess_prix_vente_mob','D', _("Dont éventuellement inclus"),"alignForm group");
                $form->setBloc('dia_mod_cess_prix_vente_autre','F', "","");

                //
                $form->setBloc('dia_mod_cess_adr','DF', _("Si vente indissociable d'autres biens"),"alignFormSpec");

                // Modalité de paiement
                $form->setBloc('dia_mod_cess_sign_act_auth','D', _("Modalités de paiement"),"alignForm group");
                $form->setBloc('dia_mod_cess_terme_prec','F', "","");
                $form->setBloc('dia_mod_cess_commi','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_commi_ht','F', "","");
                $form->setBloc('dia_mod_cess_bene_acquereur','D', _("Bénéficiaire"),"alignForm group");
                $form->setBloc('dia_mod_cess_bene_vendeur','F', "","");
                $form->setBloc('dia_mod_cess_paie_nat','D', " ","alignForm group");
                $form->setBloc('dia_mod_cess_paie_nat_desc','F');
                $form->setBloc('dia_mod_cess_design_contr_alien','DF', "","alignFormSpec group");
                $form->setBloc('dia_mod_cess_eval_contr','DF', "","alignFormSpec group");
                $form->setBloc('dia_mod_cess_rente_viag','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_rente_viag_desc','F');
                $form->setBloc('dia_mod_cess_mnt_an','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_mnt_compt','F', "","");
                $form->setBloc('dia_mod_cess_bene_rente','DF', "","alignFormSpec");
                $form->setBloc('dia_mod_cess_droit_usa_hab','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_droit_usa_hab_prec','F', "","");
                $form->setBloc('dia_mod_cess_eval_usa_usufruit','DF', "","alignFormSpec");
                $form->setBloc('dia_mod_cess_vente_nue_prop','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_vente_nue_prop_prec','F', "","");
                $form->setBloc('dia_mod_cess_echange','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_echange_desc','F');
                $form->setBloc('dia_mod_cess_design_bien_recus_ech','DF', "","alignFormSpec group");
                $form->setBloc('dia_mod_cess_mnt_soulte','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_prop_contre_echan','F', "","");
                $form->setBloc('dia_mod_cess_apport_societe','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_apport_societe_desc','F');
                $form->setBloc('dia_mod_cess_bene','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_esti_bien','F', "","");
                $form->setBloc('dia_mod_cess_cess_terr_loc_co','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_cess_terr_loc_co_desc','F');
                $form->setBloc('dia_mod_cess_esti_terr','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_esti_loc','F', "","");
                $form->setBloc('dia_mod_cess_esti_imm_loca','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_esti_imm_loca_desc','F');

                $form->setFieldset('dia_mod_cess_esti_imm_loca_desc','F','');

                // Adjudication
                $form->setFieldset('dia_mod_cess_adju_vol','D', _("Adjudication"), "startClosed");

                $form->setBloc('dia_mod_cess_adju_vol','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_adju_obl_desc','F', "","");
                $form->setBloc('dia_mod_cess_adju_fin_indivi','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_adju_fin_indivi_desc','F');
                $form->setBloc('dia_mod_cess_adju_date_lieu','D', "","alignForm group");
                $form->setBloc('dia_mod_cess_mnt_mise_prix','F', "","");

                $form->setFieldset('dia_mod_cess_mnt_mise_prix','F','');

            $form->setFieldset('dia_mod_cess_mnt_mise_prix','F','');

            // Les soussignés déclarent
            $form->setFieldset('dia_prop_titu_prix_indique','D',_("Les soussignés déclarent"), "startClosed");
            $form->setBloc('dia_prop_titu_prix_indique','D', "", "alignFormSpec");

                //
                $form->setBloc('dia_prop_titu_prix_indique','D', _("Que le(s) propriétaire(s) nommé(s) à la rubrique 1"),"");
                $form->setBloc('dia_acquereur_prof','F');

                // Adresse
                $form->setBloc('dia_acquereur_adr_num_voie','D', _("Adresse"),"group");
                $form->setBloc('dia_acquereur_adr_localite','F');

            $form->setBloc('dia_ss_date','F');
            $form->setFieldset('dia_ss_date','F');

            // Notification des décisions du titulaire du droit de préemption
            $form->setFieldset('dia_notif_dec_titul_adr_prop', 'D', __("Notification des décisions du titulaire du droit de préemption"), "startClosed");
            $form->setBloc('dia_notif_dec_titul_adr_prop', 'D', __("Toutes les décisions relatives à l’exercice du droit de préemption devront être notifiées"), "alignForm group");
            $form->setBloc('dia_notif_dec_titul_adr_prop_desc','F');
            $form->setBloc('dia_notif_dec_titul_adr_manda', 'D', "", "alignForm group");
            $form->setBloc('dia_notif_dec_titul_adr_manda_desc','F');
            $form->setFieldset('dia_notif_dec_titul_adr_manda_desc', 'F');

            // Observation
            $form->setFieldset('dia_observation','D',_("Observations"), "startClosed");

                //
                $form->setBloc('dia_observation','DF', "","alignFormSpec");

            $form->setFieldset('dia_observation','F','');

            // Cadre réservé au titulaire du droit de préemption
            $form->setFieldset('dia_cadre_titul_droit_prempt', 'DF', __("Cadre réservé au titulaire du droit de préemption"), "startClosed alignFormSpec");

            // Données complémentaires
            $form->setFieldset('dia_comp_prix_vente', 'D', __("Données complémentaires"), "startClosed alignFormSpec");
            $form->setBloc('dia_comp_prix_vente', 'DF', sprintf(__("Correspondant au prix détaillé par le vendeur, la valeur est remplis automatiquement lors de la saisie du champ \"%s\""), $this->getLibFromField('dia_mod_cess_prix_vente_num')), "");
            $form->setBloc('dia_comp_surface', 'DF', sprintf(__("Correspond à la surface total, la valeur est remplis automatiquement lors de la saisie des champs \"%s\" et \"%s\""), $this->getLibFromField('dia_su_co_sol_num'), $this->getLibFromField('dia_su_util_hab_num')), "");
            $form->setBloc('dia_comp_total_frais', 'DF', sprintf(__("Correspond au frais total, la valeur est remplis automatiquement lors de la saisie du champ \"%s\""), $this->getLibFromField('dia_mod_cess_commi_mnt')), "");
            $form->setBloc('dia_comp_mtn_total', 'DF', sprintf(__("Correspondant à l’addition des champs \"%s\" et \"%s\""), $this->getLibFromField('dia_comp_prix_vente'), $this->getLibFromField('dia_comp_total_frais')), "");
            $form->setBloc('dia_comp_valeur_m2', 'DF', sprintf(__("Prix au m² par division des champs \"%s\" et \"%s\""), $this->getLibFromField('dia_comp_mtn_total'), $this->getLibFromField('dia_comp_surface')), "");
            $form->setFieldset('dia_comp_valeur_m2', 'F');

            // Montants
            $form->setFieldset('dia_esti_prix_france_dom', 'D', __("Montants"), "startClosed alignFormSpec");
            $form->setFieldset('dia_prop_collectivite', 'F');

            // Délégataire à l'instruction
            $form->setFieldset('dia_delegataire_denomination', 'D', __("Délégataire à l'instruction"), "startClosed alignFormSpec");
            $form->setBloc('dia_delegataire_denomination', 'DF', __("État civil"), "");
            $form->setBloc('dia_delegataire_adresse_numero', 'DF', __("Adresse"), "");
            $form->setBloc('dia_delegataire_telephone_fixe', 'DF', __("Coordonnées"), "");
            $form->setFieldset('dia_delegataire_fax', 'F');

            // Entrée en jouissance
            $form->setFieldset('dia_entree_jouissance_type', 'D', __("Entrée en jouissance"), "startClosed alignFormSpec");
            $form->setFieldset('dia_entree_jouissance_com', 'F');

            // Remise du bien
            $form->setFieldset('dia_remise_bien_date_effet', 'D', __("Remise du bien"), "startClosed alignFormSpec");
            $form->setFieldset('dia_remise_bien_com', 'F');

        $form->setFieldset('dia_remise_bien_com','F','');
        $form->setBloc('dia_remise_bien_com','F',"","");
        // Fin DIA

        $form->setBloc('code_cnil','D',"","col_12");
            $form->setFieldset('code_cnil','D'
                               ,_("cnil (opposition à l’utilisation des informations du formulaire à des fins commerciales)") , "startClosed alignFormSpec");
                $form->setBloc('code_cnil','DF', "","group");
            $form->setFieldset('code_cnil','F','');
        $form->setBloc('code_cnil','F');

        $form->setBloc('tax_surf_tot_cstr','D',"","col_12");
            $form->setFieldset('tax_surf_tot_cstr','D'
                               ,_("Declaration des elements necessaires au calcul des impositions"), "startClosed");

                $form->setBloc('tax_surf_tot_cstr','D', _("Renseignement"),"col_12");
                    $form->setBloc('tax_surf_tot_cstr','D', "", "alignFormSpec");
                    $form->setBloc('tax_surf_tot_demo','F', "","");
                $form->setBloc('tax_surf_tot_demo','F', "","");

                $form->setBloc('tab_tax_su_princ','D',_("Creation de locaux destines a l’habitation :"),"col_12");
                    $form->setBloc('tab_tax_su_princ','DF',_("tab_tax_su_princ"), "col_12");
                    $form->setBloc('tab_tax_su_heber','DF',_("tab_tax_su_heber"), "col_12");
                    $form->setBloc('tab_tax_su_tot','DF', "", "col_12");
                $form->setBloc('tax_su_habit_abr_jard_pig_colom','F', "","");
                //
                $form->setBloc('tax_ext_pret','DF', _("Extension de l’habitation principale, creation d’un batiment annexe a cette habitation ou d’un garage clos et couvert."), "alignFormSpec");
                $form->setBloc('tax_ext_desc','DF', "","group");
                $form->setBloc('tax_surf_tax_exist_cons','D', "","alignFormSpec");
                $form->setBloc('tax_surf_tax_demo','F');

                //
                $form->setBloc('tax_surf_abr_jard_pig_colom','DF', _("Creation d’abris de jardin, de pigeonniers et colombiers"), "col_12");

                $form->setBloc('tax_comm_nb','D', _("Creation ou extension de locaux non destines a l'habitation :"),"col_12");
                    $form->setBloc('tax_comm_nb','DF', "","col_12 alignFormSpec");
                    $form->setBloc('tab_tax_su_parc_statio_expl_comm','DF');
                $form->setBloc('tax_su_non_habit_abr_jard_pig_colom','F');
                //
                $form->setBloc('tab_tax_am','DF',_("tab_tax_am"),"col_12");

                $form->setBloc('tax_am_statio_ext_cr','D', _("Autres elements crees soumis à la taxe d’amenagement :"),"col_12");
                $form->setBloc('tax_pann_volt_sup_cr','F');

                $form->setBloc('tax_terrassement_arch','D', _("Redevance d’archeologie preventive"),"col_12 alignFormSpec");
                    $form->setBloc('tax_terrassement_arch','D', _("Veuillez preciser la profondeur du(des) terrassement(s) necessaire(s) a la realisation de votre projet (en mètre)"),"");
                    $form->setBloc('tax_eol_haut_nb_arch','F');
                $form->setBloc('tax_eol_haut_nb_arch','F');

                $form->setBloc('tax_trx_presc_ppr','D', _("Cas particuliers"),"col_12 alignFormSpec");
                $form->setBloc('tax_monu_hist','F');

                $form->setBloc('vsd_surf_planch_smd','D', _("Versement pour sous-densite (VSD)"),"col_12");
                    $form->setBloc('vsd_surf_planch_smd','D', "","alignFormSpec");
                    $form->setBloc('vsd_const_sxist_non_dem_surf','F');
                    
                    $form->setBloc('vsd_rescr_fisc','DF',"", "alignFormSpec-type-date");
                $form->setBloc('vsd_rescr_fisc','F');
                
                $form->setBloc('pld_val_terr','D', _("Plafond legal de densite (PLD)"),"col_12 alignFormSpec");
                $form->setBloc('pld_const_exist_dem_surf','F');

                $form->setBloc('tax_desc','DF', _("Autres renseignements"),"col_12 alignFormSpec");

                $form->setBloc('tax_adresse_future_numero','D', __("Si à échéance de vos taxes vous n'habitez plus à l'adresse figurant sur la demande d'autorisation, merci de renseigner l'adresse d’envoi des titres de perception"),"col_12 alignFormSpec group");
                $form->setBloc('tax_adresse_future_division','F');

                $form->setBloc('f9d_date','D', __("Déclarant"),"col_12 alignFormSpec group");
                $form->setBloc('f9n_nom','F');

                $form->setBloc('exo_ta_1','D',"","col_12");
                    $form->setFieldset('exo_ta_1','D',_("Exonérations"), "startClosed alignFormSpec");

                    $form->setBloc('exo_ta_1','D',"","col_12");
                        $form->setFieldset('exo_ta_1','D',_("Taxe d'aménagement"), "collapsible alignFormSpec");

                        $form->setBloc('exo_ta_1','DF', _("Exonérations de plein droit"),"col_12 group");
                        $form->setBloc('exo_ta_2','DF', "","group");
                        $form->setBloc('exo_ta_3','DF', "","group");
                        $form->setBloc('exo_ta_4','DF', "","group");
                        $form->setBloc('exo_ta_5','DF', "","group");
                        $form->setBloc('exo_ta_6','DF', "","group");
                        $form->setBloc('exo_ta_7','DF', "","group");
                        $form->setBloc('exo_ta_8','DF', "","group");
                        $form->setBloc('exo_ta_9','DF', "","group");

                        $form->setBloc('exo_facul_1','DF', _("Exonérations facultatives"),"col_12 group");
                        $form->setBloc('exo_facul_2','DF', "","group");
                        $form->setBloc('exo_facul_3','DF', "","group");
                        $form->setBloc('exo_facul_4','DF', "","group");
                        $form->setBloc('exo_facul_5','DF', "","group");
                        $form->setBloc('exo_facul_6','DF', "","group");
                        $form->setBloc('exo_facul_7','DF', "","group");
                        $form->setBloc('exo_facul_8','DF', "","group");
                        $form->setBloc('exo_facul_9','DF', "","group");

                        $form->setBloc('mtn_exo_ta_part_commu','DF', _("Montants des exonérations"),"col_12 group");
                        $form->setBloc('mtn_exo_ta_part_depart','DF', "","group");
                        $form->setBloc('mtn_exo_ta_part_reg','DF', "","group");

                        $form->setFieldset('mtn_exo_ta_part_reg','F','');
                    $form->setBloc('mtn_exo_ta_part_reg','F');

                    $form->setBloc('exo_rap_1','D',"","col_12");
                        $form->setFieldset('exo_rap_1','D',_("Redevance d'archéologie préventive"), "collapsible alignFormSpec");

                        $form->setBloc('exo_rap_1','DF', _("Exonérations"),"col_12 group");
                        $form->setBloc('exo_rap_2','DF', "","group");
                        $form->setBloc('exo_rap_3','DF', "","group");
                        $form->setBloc('exo_rap_4','DF', "","group");
                        $form->setBloc('exo_rap_5','DF', "","group");
                        $form->setBloc('exo_rap_6','DF', "","group");
                        $form->setBloc('exo_rap_7','DF', "","group");
                        $form->setBloc('exo_rap_8','DF', "","group");

                        $form->setBloc('mtn_exo_rap','DF', _("Montant des exonérations"),"col_12 group");

                        $form->setFieldset('mtn_exo_rap','F','');
                    $form->setBloc('mtn_exo_rap','F');

                $form->setFieldset('mtn_exo_rap','F','');
            $form->setBloc('mtn_exo_rap','F');

            $form->setFieldset('mtn_exo_rap','F','');
        $form->setBloc('mtn_exo_rap','F');

        // Début contentieux
        $form->setBloc('ctx_objet_recours','D',"","col_12");
        $form->setFieldset('ctx_objet_recours','D',_("Contentieux"), "startClosed alignFormSpec");

                //
                $form->setBloc('ctx_objet_recours','DF', "","group");
                $form->setBloc('ctx_moyen_souleve','DF', "","group");
                $form->setBloc('ctx_moyen_retenu_juge','DF', "","group");
                $form->setBloc('ctx_reference_sagace','DF', "","group");
                $form->setBloc('ctx_nature_travaux_infra_om_html','DF', "","group");
                $form->setBloc('ctx_synthese_nti','DF', "","group");
                $form->setBloc('ctx_article_non_resp_om_html','DF', "","group");
                $form->setBloc('ctx_synthese_anr','DF', "","group");
                $form->setBloc('ctx_reference_parquet','DF', "","group");
                $form->setBloc('ctx_element_taxation','DF', "","group");
                $form->setBloc('ctx_infraction','DF', "","group");
                $form->setBloc('ctx_regularisable','DF', "","group");
                $form->setBloc('ctx_reference_courrier','DF', "","group");
                $form->setBloc('ctx_date_audience','DF', "","group");
                $form->setBloc('ctx_date_ajournement','DF', "","group");

        $form->setFieldset('ctx_date_ajournement','F','');
        $form->setBloc('ctx_date_ajournement','F');
        // Fin contentieux

        // Début droit de préemption commercial
        $form->setBloc('dpc_type','D',"","col_12");
        $form->setFieldset('dpc_type','D',_("Droit de préemption commercial"), "startClosed alignFormSpec");

            // Description du bien
            $form->setBloc('dpc_type','D',"","col_12");
            $form->setFieldset('dpc_type','D',_("Description du bien"), "startClosed alignFormSpec");
                //
                $form->setBloc('dpc_type','DF', "","group");
                //
                $form->setBloc('dpc_desc_actv_ex','D', _("Description du fonds artisanal, du fonds de commerce ou du bail commercial"),"col_12");
                $form->setBloc('dpc_desc_aut_prec','F');
                //
                $form->setBloc('dpc_desig_comm_arti','D', _("Désignation du fonds artisanal, du fonds de commerce, ou du bail commercial ou du terrain"),"col_12");
                $form->setBloc('dpc_desig_loc_ann_prec','F');
                //
                $form->setBloc('dpc_bail_comm_date','D', _("S'il s'agit d'un bail commercial"),"col_12 group");
                $form->setBloc('dpc_bail_comm_loyer','F');
                //
                $form->setBloc('dpc_actv_acqu','DF',  _("Activité de l'acquéreur pressenti"),"group");
                //
                $form->setBloc('dpc_nb_sala_di','D', _("Nombre de salariés et nature de leur contrat de travail"),"col_12 group");
                $form->setBloc('dpc_nb_sala_td','F');
                //
                $form->setBloc('dpc_nb_sala_tc','D', "","col_12 group");
                $form->setBloc('dpc_nb_sala_tp','F');

            $form->setFieldset('dpc_nb_sala_tp','F','');
            $form->setBloc('dpc_nb_sala_tp','F');

            // Modalité de la cession
            $form->setBloc('dpc_moda_cess_vente_am','D',"","col_12");
            $form->setFieldset('dpc_moda_cess_vente_am','D',_("Modalité de la cession"), "startClosed alignFormSpec");
                //
                $form->setBloc('dpc_moda_cess_vente_am','D', "","col_12 group");
                $form->setBloc('dpc_moda_cess_prix','F');
                //
                $form->setBloc('dpc_moda_cess_adj_date','D', "","col_12 group");
                $form->setBloc('dpc_moda_cess_adj_prec','F');
                //
                $form->setBloc('dpc_moda_cess_paie_comp','DF', _("Modalités de paiement"),"col_12");

            $form->setFieldset('dpc_moda_cess_paie_aut_prec','F','');
            $form->setBloc('dpc_moda_cess_paie_aut_prec','F');

            // Le(s) soussigné(s) déclare(nt) que le bailleur
            $form->setBloc('dpc_ss_signe_demande_acqu','D',"","col_12");
            $form->setFieldset('dpc_ss_signe_demande_acqu','D',_("Le(s) soussigné(s) déclare(nt) que le bailleur"), "startClosed alignFormSpec");

            $form->setFieldset('dpc_ss_signe_recher_trouv_acqu','F','');
            $form->setBloc('dpc_ss_signe_recher_trouv_acqu','F');

            // Notification des décisions du titulaire du droit de préemption
            $form->setBloc('dpc_notif_adr_prop','D',"","col_12");
            $form->setFieldset('dpc_notif_adr_prop','D',_("Notification des décisions du titulaire du droit de préemption"), "startClosed alignFormSpec");

            $form->setFieldset('dpc_notif_adr_manda','F','');
            $form->setBloc('dpc_notif_adr_manda','F');

            //
            $form->setBloc('dpc_obs','D',"","col_12");
            $form->setFieldset('dpc_obs','D',_("Observations éventuelles"), "startClosed alignFormSpec");

            $form->setFieldset('dpc_obs','F','');
            $form->setBloc('dpc_obs','F');

        $form->setFieldset('dpc_obs','F','');
        $form->setBloc('dpc_obs','F');
        // Fin droit de préemption commercial

        // DEMANDE D’AUTORISATION OU DÉCLARATION PRÉALABLE DE TRAVAUX
        // SUR MONUMENTS HISTORIQUES / DEMANDE DE SUBVENTION POUR ÉTUDE OU TRAVAUX
        $form->setBloc('mh_design_appel_denom','D',"","col_12");
        $form->setFieldset('mh_design_appel_denom','D',__("Demande d’autorisation ou déclaration préalable de travaux sur monuments historiques / Demande de subvention pour étude ou travaux"), "startClosed alignFormSpec");
        // Désignation du monument historique
        $form->setBloc('mh_design_appel_denom','D',"","col_12");
        $form->setFieldset('mh_design_appel_denom','D',__("Désignation du monument historique"), "startClosed alignFormSpec");
        $form->setFieldset('mh_design_nature_prop','F','');
        $form->setBloc('mh_design_nature_prop','F');
        // Localisation de l’immeuble protégé ou de l’immeuble abritant l’objet mobilier ou l’orgue protégé
        $form->setBloc('mh_loc_denom','D',"","col_12");
        $form->setFieldset('mh_loc_denom','D',__("Localisation de l’immeuble protégé ou de l’immeuble abritant l’objet mobilier ou l’orgue protégé"), "startClosed alignFormSpec");
        $form->setFieldset('mh_loc_denom','F','');
        $form->setBloc('mh_loc_denom','F');
        // Présentation synthétique du projet
        $form->setBloc('mh_pres_intitule','D',"","col_12");
        $form->setFieldset('mh_pres_intitule','D',__("Présentation synthétique du projet"), "startClosed alignFormSpec");
        $form->setFieldset('mh_pres_intitule','F','');
        $form->setBloc('mh_pres_intitule','F');
        // Travaux sur l’immeuble
        $form->setBloc('mh_trav_cat_1','D',"","col_12");
        $form->setFieldset('mh_trav_cat_1','D',__("Travaux sur l’immeuble"), "startClosed alignFormSpec");
        $form->setFieldset('mh_trav_cat_12_prec','F','');
        $form->setBloc('mh_trav_cat_12_prec','F');
    }

    /**
     * Surcharge de la méthode setOnChange
     */
    function setOnchange(&$form,$maj){
        parent::setOnchange($form,$maj);

        $form->setOnchange("co_tot_ind_nb","sommeChampsCerfa('co_tot_log_nb',['co_tot_ind_nb','co_tot_coll_nb']);");
        $form->setOnchange("co_tot_coll_nb","sommeChampsCerfa('co_tot_log_nb',['co_tot_ind_nb','co_tot_coll_nb']);");

        $form->setOnchange("doc_nb_log_indiv","sommeChampsCerfa('doc_nb_log',['doc_nb_log_indiv','doc_nb_log_coll']);");
        $form->setOnchange("doc_nb_log_coll","sommeChampsCerfa('doc_nb_log',['doc_nb_log_indiv','doc_nb_log_coll']);");
        
        $form->setOnchange("su_avt_shon1","calculSurfaceTotal(1);");
        $form->setOnchange("su_avt_shon2","calculSurfaceTotal(1);");
        $form->setOnchange("su_avt_shon3","calculSurfaceTotal(1);");
        $form->setOnchange("su_avt_shon4","calculSurfaceTotal(1);");
        $form->setOnchange("su_avt_shon5","calculSurfaceTotal(1);");
        $form->setOnchange("su_avt_shon6","calculSurfaceTotal(1);");
        $form->setOnchange("su_avt_shon7","calculSurfaceTotal(1);");
        $form->setOnchange("su_avt_shon8","calculSurfaceTotal(1);");
        $form->setOnchange("su_avt_shon9","calculSurfaceTotal(1);");
        $form->setOnchange("su_cstr_shon1","calculSurfaceTotal(1);");
        $form->setOnchange("su_cstr_shon2","calculSurfaceTotal(1);");
        $form->setOnchange("su_cstr_shon3","calculSurfaceTotal(1);");
        $form->setOnchange("su_cstr_shon4","calculSurfaceTotal(1);");
        $form->setOnchange("su_cstr_shon5","calculSurfaceTotal(1);");
        $form->setOnchange("su_cstr_shon6","calculSurfaceTotal(1);");
        $form->setOnchange("su_cstr_shon7","calculSurfaceTotal(1);");
        $form->setOnchange("su_cstr_shon8","calculSurfaceTotal(1);");
        $form->setOnchange("su_cstr_shon9","calculSurfaceTotal(1);");
        $form->setOnchange("su_chge_shon1","calculSurfaceTotal(1);");
        $form->setOnchange("su_chge_shon2","calculSurfaceTotal(1);");
        $form->setOnchange("su_chge_shon3","calculSurfaceTotal(1);");
        $form->setOnchange("su_chge_shon4","calculSurfaceTotal(1);");
        $form->setOnchange("su_chge_shon5","calculSurfaceTotal(1);");
        $form->setOnchange("su_chge_shon6","calculSurfaceTotal(1);");
        $form->setOnchange("su_chge_shon7","calculSurfaceTotal(1);");
        $form->setOnchange("su_chge_shon8","calculSurfaceTotal(1);");
        $form->setOnchange("su_chge_shon9","calculSurfaceTotal(1);");
        $form->setOnchange("su_demo_shon1","calculSurfaceTotal(1);");
        $form->setOnchange("su_demo_shon2","calculSurfaceTotal(1);");
        $form->setOnchange("su_demo_shon3","calculSurfaceTotal(1);");
        $form->setOnchange("su_demo_shon4","calculSurfaceTotal(1);");
        $form->setOnchange("su_demo_shon5","calculSurfaceTotal(1);");
        $form->setOnchange("su_demo_shon6","calculSurfaceTotal(1);");
        $form->setOnchange("su_demo_shon7","calculSurfaceTotal(1);");
        $form->setOnchange("su_demo_shon8","calculSurfaceTotal(1);");
        $form->setOnchange("su_demo_shon9","calculSurfaceTotal(1);");
        $form->setOnchange("su_sup_shon1","calculSurfaceTotal(1);");
        $form->setOnchange("su_sup_shon2","calculSurfaceTotal(1);");
        $form->setOnchange("su_sup_shon3","calculSurfaceTotal(1);");
        $form->setOnchange("su_sup_shon4","calculSurfaceTotal(1);");
        $form->setOnchange("su_sup_shon5","calculSurfaceTotal(1);");
        $form->setOnchange("su_sup_shon6","calculSurfaceTotal(1);");
        $form->setOnchange("su_sup_shon7","calculSurfaceTotal(1);");
        $form->setOnchange("su_sup_shon8","calculSurfaceTotal(1);");
        $form->setOnchange("su_sup_shon9","calculSurfaceTotal(1);");
        $form->setOnchange("su_tot_shon1","calculSurfaceTotal(1);");
        $form->setOnchange("su_tot_shon2","calculSurfaceTotal(1);");
        $form->setOnchange("su_tot_shon3","calculSurfaceTotal(1);");
        $form->setOnchange("su_tot_shon4","calculSurfaceTotal(1);");
        $form->setOnchange("su_tot_shon5","calculSurfaceTotal(1);");
        $form->setOnchange("su_tot_shon6","calculSurfaceTotal(1);");
        $form->setOnchange("su_tot_shon7","calculSurfaceTotal(1);");
        $form->setOnchange("su_tot_shon8","calculSurfaceTotal(1);");
        $form->setOnchange("su_tot_shon9","calculSurfaceTotal(1);");

        // Tableau des sous-destinations
        $form->setOnChange("su2_avt_shon1", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon2", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon3", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon4", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon5", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon6", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon7", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon8", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon9", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon10", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon11", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon12", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon13", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon14", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon15", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon16", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon17", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon18", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon19", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon20", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon21", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_avt_shon22", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon1", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon2", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon3", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon4", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon5", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon6", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon7", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon8", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon9", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon10", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon11", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon12", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon13", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon14", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon15", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon16", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon17", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon18", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon19", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon20", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon21", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_cstr_shon22", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon1", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon2", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon3", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon4", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon5", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon6", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon7", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon8", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon9", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon10", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon11", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon12", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon13", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon14", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon15", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon16", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon17", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon18", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon19", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon20", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon21", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_chge_shon22", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon1", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon2", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon3", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon4", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon5", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon6", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon7", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon8", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon9", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon10", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon11", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon12", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon13", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon14", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon15", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon16", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon17", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon18", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon19", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon20", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon21", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_demo_shon22", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon1", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon2", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon3", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon4", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon5", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon6", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon7", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon8", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon9", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon10", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon11", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon12", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon13", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon14", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon15", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon16", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon17", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon18", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon19", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon20", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon21", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_sup_shon22", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon1", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon2", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon3", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon4", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon5", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon6", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon7", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon8", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon9", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon10", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon11", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon12", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon13", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon14", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon15", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon16", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon17", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon18", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon19", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon20", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon21", "calculSurfaceTotal(2);");
        $form->setOnChange("su2_tot_shon22", "calculSurfaceTotal(2);");

        // Calcul des valeurs pour les données complémentaires des DIA
        $form->setOnChange("dia_mod_cess_prix_vente_num", "VerifFloat(this);set_field_value(dia_comp_prix_vente, this.value);");
        $form->setOnChange("dia_mod_cess_commi_mnt", "VerifFloat(this);set_field_value(dia_comp_total_frais, this.value);");
        $form->setOnChange("dia_comp_prix_vente", "VerifFloat(this);calculate_field_value(dia_comp_mtn_total, 'addition', [this.value, dia_comp_total_frais.value]);");
        $form->setOnChange("dia_comp_total_frais", "VerifFloat(this);calculate_field_value(dia_comp_mtn_total, 'addition', [this.value, dia_comp_prix_vente.value]);");
        $form->setOnChange("dia_comp_mtn_total", "VerifFloat(this);calculate_field_value(dia_comp_valeur_m2, 'division', [this.value, dia_comp_surface.value]);");
        $form->setOnChange("dia_comp_surface", "VerifFloat(this);calculate_field_value(dia_comp_valeur_m2, 'division', [dia_comp_mtn_total.value, this.value]);");
        $form->setOnChange("dia_su_co_sol_num", "VerifFloat(this);if (dia_su_util_hab_num.value !== '') {set_field_value(dia_comp_surface, dia_su_util_hab_num.value);} else {set_field_value(dia_comp_surface, this.value);};");
        $form->setOnChange("dia_su_util_hab_num", "VerifFloat(this);if (dia_su_util_hab_num.value !== '') {set_field_value(dia_comp_surface, this.value);} else {set_field_value(dia_comp_surface, dia_su_co_sol_num.value);};");
    }

    /**
     * SETTER_FORM - set_form_default_values (setVal).
     *
     * @return void
     */
    function set_form_default_values(&$form, $maj, $validation) {
        parent::set_form_default_values($form, $maj, $validation);

        // En modification, les valeurs des données complémentaires DIA et certains
        // des champs utilisés pour les calculs de ceux-ci, auront comme valeur par
        // défaut 0
        if ($maj == 1) {
            $dia_fields_calc = array(
                'dia_comp_prix_vente',
                'dia_comp_surface',
                'dia_comp_total_frais',
                'dia_comp_mtn_total',
                'dia_comp_valeur_m2',
            );
            foreach ($dia_fields_calc as $field) {
                if ($this->getVal($field) === '') {
                    $form->setVal($field, 0);
                }
            }
        }
    }

    
    /**
     * Surcharge du bouton retour afin de retourner sur le dossier d'instruction selon de cas
     */
    function retoursousformulaire($idxformulaire = NULL, $retourformulaire = NULL, $val = NULL,
                                  $objsf = NULL, $premiersf = NULL, $tricolsf = NULL, $validation = NULL,
                                  $idx = NULL, $maj = NULL, $retour = NULL) {

        $visualisation = $this->getParameter('visualisation');
        
        if ( $visualisation == "" ){
            
            // Ajout et consultation, retour dossier
            if ( ( $maj == 0 && $validation == 0 ) || 
                ( $maj == 3 && $validation == 0 ) ||
                ( $maj == 0 && $validation == 1 )  && $retourformulaire == "dossier_instruction" ){
             
                echo "\n<a class=\"retour\" ";
                    echo "href=\"#\" ";
                    echo "onclick=\"redirectPortletAction(1,'main');\" ";
                    echo ">";
                    echo _("Retour");
                echo "</a>\n";
            }
            //Sinon affiche un retour normal
            else{
                
                parent::retoursousformulaire($idxformulaire, $retourformulaire, $val,
                                      $objsf, $premiersf, $tricolsf, $validation,
                                      $idx, $maj, $retour);
            }
        }
    }


    /**
     * Retourne le nom et le prénom de l'architecte qui a l'identifiant $id
     * @param integer $id
     *
     * @return string
     */
    function getPrenomNomArchitecte($id){
        $inst_architecte = $this->f->get_inst__om_dbform(array(
            "obj" => "architecte",
            "idx" => $id,
        ));
        return $inst_architecte->getVal("prenom")." ".$inst_architecte->getVal("nom");
    }

    /**
     * Récupère l'instance de la classe dossier.
     *
     * @param string $dossier Identifiant
     *
     * @return object
     */
    function get_inst_dossier($dossier = null) {
        //
        if (is_null($this->inst_dossier)) {
            //
            if (is_null($dossier)) {
                $dossier = $this->getVal("dossier_instruction");
            }
            //
            $this->inst_dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $dossier,
            ));
        }
        //
        return $this->inst_dossier;
    }

    /**
     * Récupère l'instance de la classe dossier_autorisation.
     *
     * @param string $dossier_autorisation Identifiant
     *
     * @return object
     */
    function get_inst_dossier_autorisation($dossier_autorisation = null) {
        //
        if (is_null($this->inst_dossier_autorisation)) {
            //
            if (is_null($dossier_autorisation)) {
                $dossier_autorisation = $this->getVal("dossier_autorisation");
            }
            //
            $this->inst_dossier_autorisation = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_autorisation",
                "idx" => $dossier_autorisation,
            ));
        }
        //
        return $this->inst_dossier_autorisation;
    }

    /**
     * Récupère l'instance de la classe lot.
     *
     * @param string $lot Identifiant
     *
     * @return object
     */
    function get_inst_lot($lot = null) {
        //
        if (is_null($this->inst_lot)) {
            //
            if (is_null($lot)) {
                $lot = $this->getVal("lot");
            }
            //
            $this->inst_lot = $this->f->get_inst__om_dbform(array(
                "obj" => "lot",
                "idx" => $lot,
            ));
        }
        //
        return $this->inst_lot;
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggerajouterapres($id, $dnu1, $val);
        // Liaison NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Si le champ possède une valeur
            if (isset($val[$liaison_nan["field"]]) === true) {
                // Ajout des liaisons table Nan
                $nb_liens = $this->ajouter_liaisons_table_nan(
                    $liaison_nan["table_l"],
                    $liaison_nan["table_f"],
                    $liaison_nan["field"],
                    $val[$liaison_nan["field"]]
                );
                // Message de confirmation
                if ($nb_liens > 0) {
                    if ($nb_liens == 1) {
                        $this->addToMessage(sprintf(_("Création d'une nouvelle liaison réalisee avec succès.")));
                    } else {
                        $this->addToMessage(sprintf(_("Création de %s nouvelles liaisons réalisée avec succès."), $nb_liens));
                    }
                }
            }
        }
        // Si les données techniques concernent un dossier d'instruction
        if ($val['dossier_instruction'] !== null && $val['dossier_instruction'] !== '') {
            // Instance du dossier d'instruction
            $inst_dossier = $this->get_inst_dossier();
            /**
             * Mise à jour de la date de dernière modification du dossier
             * d'instruction
             */
            $inst_dossier->update_last_modification_date();
        }
        //
        return true;
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Instance du dossier d'instruction
        $inst_dossier = $this->get_inst_dossier();
        // Si les données techniques concernent un dossier d'instruction
        if ($val['dossier_instruction'] !== null && $val['dossier_instruction'] !== '') {
            /**
             * Gestion des taxes.
             */
            // Instance du paramétrage des taxes
            $inst_taxe_amenagement = $this->get_inst_taxe_amenagement_by_om_collectivite($inst_dossier->getVal('om_collectivite'));
            // Instance du cerfa lié au dossier
            $inst_cerfa = $this->get_inst_cerfa_by_dossier($inst_dossier->getVal($inst_dossier->clePrimaire));

            // Si l'option de simulation est activée pour la collectivité du
            // dossier, la collectivité à un paramétrage pour les taxes et que
            // le cerfa du dossier à les champs requis
            if ($this->f->is_option_simulation_taxes_enabled($inst_dossier->getVal('om_collectivite')) === true
                && $inst_taxe_amenagement !== null
                && $inst_cerfa->can_simulate_taxe_amenagement() === true) {
                // Récupération des champs nécessaires à la simulation
                $list_fields = $inst_taxe_amenagement->get_list_fields_simulation();
                // Valeurs pour le calcul
                $valF = array();
                // Pour chaque champ
                foreach ($list_fields as $field) {
                    // Si un seul des champs requis a une valeur
                    $getVal = $this->valF[$field];
                    if ($getVal !== '' && $getVal !== null) {
                        //
                        $valF = $val;
                    }
                }
                // Met à jour les montants du dossier
                $update_dossier_tax_mtn = $inst_dossier->update_dossier_tax_mtn($inst_dossier->getVal('tax_secteur'), $valF);
                if ($update_dossier_tax_mtn === false) {
                    //
                    $this->addToMessage(_("La mise a jour des montants de la simulation de la taxe d'amenagement a echouee."));
                    //
                    return false;
                }
            }

            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && $this->f->is_type_dossier_platau($inst_dossier->getVal('dossier_autorisation')) === true
                && $inst_dossier->getVal('etat_transmission_platau') !== 'jamais_transmissible') {

                $trigger_platau_required_fields = $inst_dossier->trigger_platau_required_fields($inst_dossier->getVal('dossier'));
                // Gestion de l'erreur
                if (! $trigger_platau_required_fields) {
                    $this->addToMessage(sprintf('%s %s',
                        __("Une erreur s'est produite lors de la mise à jour de l'état de transmission du dossier."),
                        __("Veuillez contacter votre administrateur.")
                    ));
                    $this->correct = false;
                    return false;
                }
            }

            /**
             * Gestion des tâches pour la dématérialisation
             */
            //
            if ($this->f->is_type_dossier_platau($inst_dossier->getVal('dossier_autorisation'))
                && $inst_dossier->getVal('etat_transmission_platau') !== 'jamais_transmissible'
                && ($this->f->is_option_mode_service_consulte_enabled() !== true
                    || ($this->f->is_option_mode_service_consulte_enabled() === true
                    && ($inst_dossier->get_source_depot_from_demande() === PLATAU
                        || $inst_dossier->get_source_depot_from_demande() === PORTAL)))) {
                //
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => 0,
                ));
                $task_val = array(
                    'type' => 'modification_DI',
                    'object_id' => $inst_dossier->getVal($inst_dossier->clePrimaire),
                    'dossier' => $inst_dossier->getVal($inst_dossier->clePrimaire),
                );
                // Change l'état de la tâche de notification en fonction de l'état de
                // transmission du dossier d'instruction
                if ($this->f->is_option_mode_service_consulte_enabled() === false
                    && ($inst_dossier->getVal('etat_transmission_platau') == 'non_transmissible' 
                    || $inst_dossier->getVal('etat_transmission_platau') == 'transmis_mais_non_transmissible')) {
                    //
                    $task_val['state'] = $inst_task::STATUS_DRAFT;
                }
                $add_task = $inst_task->add_task(array('val' => $task_val));
                if ($add_task === false) {
                    $this->addToMessage(sprintf('%s %s',
                        __("Une erreur s'est produite lors de la création tâche."),
                        __("Veuillez contacter votre administrateur.")
                    ));
                    $this->correct = false;
                    return false;
                }
                // XXX Les données du DA sont mises à jour seulement lors de l'ajout ou modification
                // d'une instruction du DI initial et lors de la décision sur le DI non initial.
                // Sachant ce comportement, voir si cette tâche modification_DA est bien située.
                // $inst_task = $this->f->get_inst__om_dbform(array(
                //     "obj" => "task",
                //     "idx" => 0,
                // ));
                // $task_val = array(
                //     'type' => 'modification_DA',
                //     'object_id' => $inst_dossier->getVal('dossier_autorisation'),
                //     'dossier' => $inst_dossier->getVal('dossier_autorisation'),
                // );
                // // Change l'état de la tâche de notification en fonction de l'état de
                // // transmission du dossier d'instruction
                // if ($this->f->is_option_mode_service_consulte_enabled() === false
                //     && ($inst_dossier->getVal('etat_transmission_platau') == 'non_transmissible' 
                //     || $inst_dossier->getVal('etat_transmission_platau') == 'transmis_mais_non_transmissible')) {
                //     //
                //     $task_val['state'] = $inst_task::STATUS_DRAFT;
                // }
                // $add_task = $inst_task->add_task(array('val' => $task_val));
                // if ($add_task === false) {
                //     $this->addToMessage(sprintf('%s %s',
                //         __("Une erreur s'est produite lors de la création tâche."),
                //         __("Veuillez contacter votre administrateur.")
                //     ));
                //     $this->correct = false;
                //     return false;
                // }
            }

            /**
             * Mise à jour de la date de dernière modification du dossier
             * d'instruction
             */
            $inst_dossier->update_last_modification_date();
        }
        // Liaisons NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Suppression des liaisons table NaN
            $this->supprimer_liaisons_table_nan($liaison_nan["table_l"]);
            // Ajout des liaisons table Nan
            $nb_liens = $this->ajouter_liaisons_table_nan(
                $liaison_nan["table_l"],
                $liaison_nan["table_f"],
                $liaison_nan["field"],
                $val[$liaison_nan["field"]]
            );
            // Message de confirmation
            if ($nb_liens > 0) {
                $this->addToMessage(_("Mise a jour des liaisons realisee avec succes."));
            }
        }
        return true;
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggersupprimer($id, $dnu1, $val);
        // Liaisons NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Suppression des liaisons table NaN
            $this->supprimer_liaisons_table_nan($liaison_nan["table_l"]);
        }
        //
        return true;
    }

    /**
     * Récupère toutes les valeurs de l'enregistrement.
     *
     * @return array
     */
    function get_form_val() {

        // Initialisation du tableau des résultats
        $result = array();

        // Pour chaque champs
        foreach ($this->champs as $champ) {
            // Récupère sa valeur
            $result[$champ] = $this->getVal($champ);
        }
        
        // Retourne le résultat
        return $result;
    }


    /**
     * Retourne les données techniques applicables au dossier courant, càd les données
     * techniques liées au dossier avec seulement les champs du CERFA associé au type de
     * dossier.
     *
     * @return array $donnees_techniques_applicables  Tableau associatif contenant
     *                                                seulement les données techniques
     *                                                applicables au dossier.
     */
    public function get_donnees_techniques_applicables() {

        // Récupération du tableau associatif contenant données techniques du dossier
        $donnees_techniques_dossier = $this->get_form_val();
        // Récupération du tableau associatif contenant les champs du CERFA lié au dossier
        $inst_cerfa = $this->getCerfa();
        $cerfa_dossier = $inst_cerfa->get_form_val();

        if(file_exists ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php"))
            include ("../sql/".OM_DB_PHPTYPE."/".$this->table.".forminc.inc.php");

        // Tableau associatif contenant la liste des champs de DT applicables au dossier
        $donnees_techniques_applicables = array();
        foreach ($cerfa_dossier as $key => $value) {
            // Si le champ du CERFA est préfixé par tab_ il s'agit d'un tableau qui
            // contient plusieurs champs, on récupère alors tous les champs du tableau.
            if (preg_match("/tab_/", $key)) {
                // Contient les champs de données techniques qui composent le tableau tab_
                $tableau_donnees_techniques = ${$key};
                // Pour chaque champ qui compose le tableau de données techniques
                if (isset($tableau_donnees_techniques[$inst_cerfa->getVal($key)]['values']) === true) {
                    foreach ($tableau_donnees_techniques[$inst_cerfa->getVal($key)]['values'] as $key) {
                        $donnees_techniques_applicables[$key] = $this->getVal($key);
                    }
                }
            }
            // Si le champ est activé dans le CERFA correspond a une donnée technique
            if ($value === 't' && array_key_exists($key, $donnees_techniques_dossier)) {
                $donnees_techniques_applicables[$key] = $this->getVal($key);
            }
        }
        return $donnees_techniques_applicables;

    }


    /**
     * Surcharge de la méthode rechercheTable pour éviter de court-circuiter le 
     * générateur en devant surcharger la méthode cleSecondaire afin de supprimer
     * les éléments liés dans les tables NaN.
     *
     * @param [type] $dnu1      Instance BDD - À ne pas utiliser
     * @param [type] $table     Table
     * @param [type] $field     Champ
     * @param [type] $id        Identifiant
     * @param [type] $dnu2      Marqueur de débogage - À ne pas utiliser
     * @param string $selection Condition de la requête
     *
     * @return [type] [description]
     */
    function rechercheTable(&$dnu1 = null, $table = "", $field = "", $id = null, $dnu2 = null, $selection = "") {
        //
        if (in_array($table, array_keys($this->liaisons_nan))) {
            //
            $this->addToLog(__METHOD__."(): On ne vérifie pas la table ".$table." car liaison nan.", EXTRA_VERBOSE_MODE);
            return;
        }
        //
        parent::rechercheTable($this->f->db, $table, $field, $id, null, $selection);
    }


    /**
     * Récupère l'identifiant des données techniques avec le numéro de dossier.
     *
     * @param string $dossier Identifiant du dossier.
     *
     * @return integer
     */
    public function get_id_by_dossier($dossier) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    donnees_techniques
                FROM
                    %1$sdonnees_techniques
                WHERE
                    dossier_instruction = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

   /*
     * CONDITION - can_user_access_dossier_contexte_modification
     *
     * Vérifie que l'utilisateur a bien accès au dossier lié aux données techniques
     * instanciées.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_modification() {
        //
        $inst_dossier = $this->get_inst_dossier();
        //
        if ($inst_dossier->getVal('dossier') !== '') {
            return $inst_dossier->can_user_access_dossier();
        }
        return false;
    }

   /*
     * CONDITION - can_user_access_dossier_contexte_dossier_autorisation_modification
     *
     * Vérifie que l'utilisateur a bien accès au dossier d'autorisation lié aux données
     * techniques instanciées.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_dossier_autorisation_modification() {
        //
        $inst_dossier_autorisation = $this->get_inst_dossier_autorisation();
        //
        if ($inst_dossier_autorisation->getVal('dossier_autorisation') !== '') {
            return $inst_dossier_autorisation->can_user_access_dossier();
        }
        return false;
    }

   /*
     * CONDITION - can_user_access_dossier_contexte_lot_modification
     *
     * Vérifie que l'utilisateur a bien accès au dossier lié aux données techniques
     * instanciées.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_lot_modification() {
        //
        $inst_lot = $this->get_inst_lot();
        $inst_dossier = $this->get_inst_dossier($inst_lot->getVal('dossier'));
        //
        if ($inst_dossier->getVal('dossier') !== '') {
            return $inst_dossier->can_user_access_dossier();
        }
        return false;
    }


    /**
     * Récupère l'instance de la classe taxe_amenagement.
     *
     * @param integer $om_collectivite La collectivité
     *
     * @return object
     */
    protected function get_inst_taxe_amenagement_by_om_collectivite($om_collectivite) {
        //
        if ($this->inst_taxe_amenagement === null) {
            //
            $taxe_amenagement = $this->get_taxe_amenagement_by_om_collectivite($om_collectivite);

            // Si aucun paramétrage de taxe trouvé et que la collectivité
            // est mono
            if ($taxe_amenagement === null
                && $this->f->isCollectiviteMono($om_collectivite) === true) {
                // Récupère la collectivité multi
                $om_collectivite_multi = $this->f->get_idx_collectivite_multi();
                //
                $taxe_amenagement = $this->get_taxe_amenagement_by_om_collectivite($om_collectivite_multi);
            }

            //
            if ($taxe_amenagement === null) {
                //
                return null;
            }

            //
            $this->inst_taxe_amenagement = $this->f->get_inst__om_dbform(array(
                "obj" => "taxe_amenagement",
                "idx" => $taxe_amenagement,
            ));
        }
        //
        return $this->inst_taxe_amenagement;
    }


    /**
     * Récupère l'identifiant de la taxe d'aménagement par rapport à la collectivité.
     *
     * @param integer $om_collectivite La collectivité
     *
     * @return integer
     */
    protected function get_taxe_amenagement_by_om_collectivite($om_collectivite) {
        $taxe_amenagement = null;
        // Si la collectivité n'est pas renseigné
        if ($om_collectivite !== '' && $om_collectivite !== null) {
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        taxe_amenagement
                    FROM
                        %1$staxe_amenagement
                    WHERE
                        om_collectivite = %2$d',
                    DB_PREFIXE,
                    intval($om_collectivite)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $taxe_amenagement = $qres["result"];
        }
        return $taxe_amenagement;
    }


    /**
     * Récupère l'instance du cerfa par le dossier d'instruction.
     *
     * @param integer $dossier Identifiant du dossier d'instruction.
     *
     * @return object
     */
    protected function get_inst_cerfa_by_dossier($dossier = null) {
        //
        if ($this->inst_cerfa === null) {
            //
            $inst_dossier = $this->get_inst_dossier($dossier);
            //
            $inst_da = $this->get_inst_dossier_autorisation($inst_dossier->getVal('dossier_autorisation'));
            //
            $inst_datd = $this->get_inst_common("dossier_autorisation_type_detaille", $inst_da->getVal('dossier_autorisation_type_detaille'));
            //
            $cerfa = $inst_datd->getVal('cerfa');
            //
            if ($cerfa !== '' && $cerfa !== null) {
                //
                $this->inst_cerfa = $this->f->get_inst__om_dbform(array(
                    "obj" => "cerfa",
                    "idx" => $cerfa,
                ));
            }
        }

        //
        return $this->inst_cerfa;
    }

    public function get_fields_tab_crea_loc_hab() {
        return array(
            "tax_su_princ_log_nb1",
            "tax_su_princ_log_nb2",
            "tax_su_princ_log_nb4",
            "tax_su_princ_log_nb3",
            "tax_su_princ_surf1",
            "tax_su_princ_surf2",
            "tax_su_princ_surf4",
            "tax_su_princ_surf3",
            "tax_su_princ_surf_stat1",
            "tax_su_princ_surf_stat2",
            "tax_su_princ_surf_stat4",
            "tax_su_princ_surf_stat3",
            "f1gu1_f1gu2_f1gu3",
            "f1lu1_f1lu2_f1lu3",
            "f1zu1_f1zu2_f1zu3",
            "f1pu1_f1pu2_f1pu3",
            "f1gt4_f1gt5_f1gt6",
            "f1lt4_f1lt5_f1lt6",
            "f1zt4_f1zt5_f1zt6",
            "f1pt4_f1pt5_f1pt6",
        );
    }

    public function get_fields_tab_surf_dest() {
        return array(
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
        );
    }

    public function get_fields_tab_surf_ssdest() {
        return array(
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
            "su2_avt_shon21",
            "su2_avt_shon22",
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
            "su2_cstr_shon21",
            "su2_cstr_shon22",
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
            "su2_chge_shon21",
            "su2_chge_shon22",
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
            "su2_demo_shon21",
            "su2_demo_shon22",
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
            "su2_sup_shon21",
            "su2_sup_shon22",
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
            "su2_tot_shon21",
            "su2_tot_shon22",
            "su2_avt_shon_tot",
            "su2_cstr_shon_tot",
            "su2_chge_shon_tot",
            "su2_demo_shon_tot",
            "su2_sup_shon_tot",
            "su2_tot_shon_tot",
        );
    }

    public function is_tab_surf_ssdest_enabled() {
        $fields_tab_surf_ssdest = $this->get_fields_tab_surf_ssdest();
        foreach ($fields_tab_surf_ssdest as $field) {
            if ($this->getVal($field) !== null
                && $this->getVal($field) !== '') {
                //
                return true;
            }
        }
        return false;
    }

}// fin classe

