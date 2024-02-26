<?php
/**
 * DBFORM - 'cerfa' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id: cerfa.class.php 5856 2016-02-03 11:35:25Z stimezouaght $
 */

require_once ("../gen/obj/cerfa.class.php");

class cerfa extends cerfa_gen {

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
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
            "tab_erp_eff",

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

            //Fin autre champ du troisième fieldset, ancien cerfa
            
            //Fin troisième bloc

            //Début quatrième bloc 5.4
            "co_demont_periode",
            //Fin quatrième bloc

            "tab_surface",

            //Début sixième bloc 5.6
            "tab_surface2",
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
            "tab_tax_su_princ",
            "tab_tax_su_secon",
            "tab_tax_su_heber",
            "tab_tax_su_tot",
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
            "tab_tax_su_non_habit_surf",
            "tab_tax_su_parc_statio_expl_comm",
            "tax_su_non_habit_abr_jard_pig_colom",
            //Fin bloc 1.2.3
            //Bloc 1.3
            "tab_tax_am",
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
            "ctx_moyen_souleve",
            "ctx_moyen_retenu_juge",
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

            // Anciens champs
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

    function setType(&$form,$maj) {
        parent::setType($form,$maj);


        //Ajout des select sur les tableaux
        if($maj == 0) {
            
            $form->setType('tab_surface', 'select');
            $form->setType('tab_surface2', 'select');
            $form->setType('tab_tax_su_princ', 'select');
            $form->setType('tab_tax_su_heber', 'select');
            $form->setType('tab_tax_su_secon', 'select');
            $form->setType('tab_tax_su_tot', 'select');
            $form->setType('tab_tax_su_non_habit_surf', 'select');
            $form->setType('tab_tax_su_parc_statio_expl_comm', 'select');
            $form->setType('tab_tax_am', 'select');
            $form->setType('tab_erp_eff', 'select');
        }elseif($maj == 1) {
                
            $form->setType('tab_surface', 'select');
            $form->setType('tab_surface2', 'select');
            $form->setType('tab_tax_su_princ', 'select');
            $form->setType('tab_tax_su_heber', 'select');
            $form->setType('tab_tax_su_secon', 'select');
            $form->setType('tab_tax_su_tot', 'select');
            $form->setType('tab_tax_su_non_habit_surf', 'select');
            $form->setType('tab_tax_su_parc_statio_expl_comm', 'select');
            $form->setType('tab_tax_am', 'select');
            $form->setType('tab_erp_eff', 'select');
        }elseif($maj == 2) {
                
            $form->setType('tab_surface', 'selecthiddenstatic');
            $form->setType('tab_surface2', 'selecthiddenstatic');
            $form->setType('tab_tax_su_princ', 'selecthiddenstatic');
            $form->setType('tab_tax_su_heber', 'selecthiddenstatic');
            $form->setType('tab_tax_su_secon', 'selecthiddenstatic');
            $form->setType('tab_tax_su_tot', 'selecthiddenstatic');
            $form->setType('tab_tax_su_non_habit_surf', 'selecthiddenstatic');
            $form->setType('tab_tax_su_parc_statio_expl_comm', 'selecthiddenstatic');
            $form->setType('tab_tax_am', 'selecthiddenstatic');
            $form->setType('tab_erp_eff', 'selecthiddenstatic');
        }elseif($maj == 3) {
                
            $form->setType('tab_surface', 'selecthiddenstatic');
            $form->setType('tab_surface2', 'selecthiddenstatic');
            $form->setType('tab_tax_su_princ', 'selecthiddenstatic');
            $form->setType('tab_tax_su_heber', 'selecthiddenstatic');
            $form->setType('tab_tax_su_secon', 'selecthiddenstatic');
            $form->setType('tab_tax_su_tot', 'selecthiddenstatic');
            $form->setType('tab_tax_su_non_habit_surf', 'selecthiddenstatic');
            $form->setType('tab_tax_su_parc_statio_expl_comm', 'selecthiddenstatic');
            $form->setType('tab_tax_am', 'selecthiddenstatic');
            $form->setType('tab_erp_eff', 'selecthiddenstatic');
        }
        $form->setType('co_statio_avt_shob', 'hidden');
        $form->setType('co_statio_apr_shob', 'hidden');
        $form->setType('co_statio_avt_surf', 'hidden');
        $form->setType('co_statio_apr_surf', 'hidden');
        $form->setType('co_trx_amgt', 'hidden');
        $form->setType('co_modif_aspect', 'hidden');
        $form->setType('co_modif_struct', 'hidden');
        $form->setType('co_trx_imm', 'hidden');
        $form->setType('co_cstr_shob', 'hidden');
        $form->setType('am_voyage_deb', 'hidden');
        $form->setType('am_voyage_fin', 'hidden');
        $form->setType('am_modif_amgt', 'hidden');
        $form->setType('am_lot_max_shob', 'hidden');
        $form->setType('mod_desc', 'hidden');
        $form->setType('tr_total', 'hidden');
        $form->setType('tr_partiel', 'hidden');
        $form->setType('tr_desc', 'hidden');
        $form->setType('avap_co_clot', 'hidden');
        $form->setType('avap_aut_coup_aba_arb', 'hidden');
        $form->setType('avap_ouv_infra', 'hidden');
        $form->setType('avap_aut_inst_mob', 'hidden');
        $form->setType('avap_aut_plant', 'hidden');
        $form->setType('avap_aut_auv_elec', 'hidden');
        $form->setType('tax_dest_loc_tr', 'hidden');
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // Destination des constructions et tableau des surfaces
        $tab_surface = array(
            "" => _("Ne pas afficher cet element"),
            13409 => _("Tableau du cerfa numero 13409*02"),
        );
        $contenu=array();
        $contenu[0]=array_keys($tab_surface);
        $contenu[1]=array_values($tab_surface);
        $form->setSelect("tab_surface", $contenu);
        // Destination, sous-destination des constructions et tableau des surfaces
        $tab_surface2 = array(
            "" => _("Ne pas afficher cet element"),
            1340905 => _("Tableau du cerfa numero 13409*05"),
            1340910 => _("Tableau du cerfa numero 13409*10"),
        );
        $contenu=array();
        $contenu[0]=array_keys($tab_surface2);
        $contenu[1]=array_values($tab_surface2);
        $form->setSelect("tab_surface2", $contenu);
        // Locaux à usage d’habitation principale et leurs annexes
        $tab_tax_su_princ = array(
            "" => _("Ne pas afficher cet element"),
            13409 => _("Tableau du cerfa numero 13409*02"),
            1340903 => _("Tableau du cerfa numero 13409*03"),
            1340909 => _("Tableau du cerfa numero 13409*09"),
        );
        $contenu[0]=array_keys($tab_tax_su_princ);
        $contenu[1]=array_values($tab_tax_su_princ);
        $form->setSelect("tab_tax_su_princ", $contenu);
        // Locaux à usage d’hébergement et leurs annexes
        $tab_tax_su_heber = array(
            "" => _("Ne pas afficher cet element"),
            13409 => _("Tableau du cerfa numero 13409*02"),
            1340903 => _("Tableau du cerfa numero 13409*03"),
            1340909 => _("Tableau du cerfa numero 13409*09"),
        );
        $contenu[0]=array_keys($tab_tax_su_heber);
        $contenu[1]=array_values($tab_tax_su_heber);
        $form->setSelect("tab_tax_su_heber", $contenu);
        // Locaux à usage d’habitation secondaire et leurs annexes
        $tab_tax_su_secon = array(
            "" => _("Ne pas afficher cet element"),
            13409 => _("Tableau du cerfa numero 13409*02"),
            1340903 => _("Tableau du cerfa numero 13409*03"),
            1340909 => _("Tableau du cerfa numero 13409*09"),
        );
        $contenu[0]=array_keys($tab_tax_su_secon);
        $contenu[1]=array_values($tab_tax_su_secon);
        $form->setSelect("tab_tax_su_secon", $contenu);
        // Nombre total de logements
        $tab_tax_su_tot = array(
            "" => _("Ne pas afficher cet element"),
            13409 => _("Tableau du cerfa numero 13409*02"),
            1340903 => _("Tableau du cerfa numero 13409*03"),
            1340909 => _("Tableau du cerfa numero 13409*09"),
        );
        $contenu[0]=array_keys($tab_tax_su_tot);
        $contenu[1]=array_values($tab_tax_su_tot);
        $form->setSelect("tab_tax_su_tot", $contenu);
        // Création ou extension de locaux non destinés à l’habitation
        $tab_tax_su_non_habit_surf = array(
            "" => _("Ne pas afficher cet element"),
            13409 => _("Tableau du cerfa numero 13409*02"),
            1340903 => _("Tableau du cerfa numero 13409*03"),
            1340907 => _("Tableau du cerfa numero 13409*07"),
            1340909 => _("Tableau du cerfa numero 13409*09"),
        );
        $contenu[0]=array_keys($tab_tax_su_non_habit_surf);
        $contenu[1]=array_values($tab_tax_su_non_habit_surf);
        $form->setSelect("tab_tax_su_non_habit_surf", $contenu);
        // Parcs de stationnement couverts faisant l’objet d’une exploitation commerciale
        $tab_tax_su_parc_statio_expl_comm = array(
            "" => _("Ne pas afficher cet element"),
            1340903 => _("Tableau du cerfa numero 13409*03"),
        );
        $contenu=array();
        $contenu[0]=array_keys($tab_tax_su_parc_statio_expl_comm);
        $contenu[1]=array_values($tab_tax_su_parc_statio_expl_comm);
        $form->setSelect("tab_tax_su_parc_statio_expl_comm", $contenu);
        // Autres éléments soumis à la taxe d’aménagement et modifiés
        $tab_tax_am = array(
            "" => _("Ne pas afficher cet element"),
            13409 => _("Tableau du cerfa numero 13409*02"),
        );
        $contenu[0]=array_keys($tab_tax_am);
        $contenu[1]=array_values($tab_tax_am);
        $form->setSelect("tab_tax_am", $contenu);
        // Effectif
        $tab_erp_eff = array(
            "" => _("Ne pas afficher cet element"),
            1382403 => _("Tableau du cerfa numero 13824*03"),
        );
        $contenu=array();
        $contenu[0]=array_keys($tab_erp_eff);
        $contenu[1]=array_values($tab_erp_eff);
        $form->setSelect("tab_erp_eff", $contenu);
    }

    function setLayout(&$form, $maj) {

        /*Fieldset Parametrage du cerfa */
        $form->setBloc('cerfa','D',"","col_12");
            $form->setFieldset('cerfa','D'
                               ,_("Parametrage du cerfa"), "col_12");

            $form->setFieldset('om_validite_fin','F','');
        $form->setBloc('om_validite_fin','F');

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
        $form->setBloc('terr_juri_titul','D',"","col_12 alignFormSpec");
            $form->setFieldset('terr_juri_titul','D'
                               ,_("Terrain"), "startClosed");

                $form->setBloc('terr_juri_titul','DF',_("Situation juridique du terrain"), "group");
                $form->setBloc('terr_juri_titul_date','DF',"", "group");
                $form->setBloc('terr_juri_lot','DF',"", "group");
                $form->setBloc('terr_juri_zac','DF',"", "group");
                $form->setBloc('terr_juri_afu','DF',"", "group");
                $form->setBloc('terr_juri_pup','DF',"", "group");
                $form->setBloc('terr_juri_oin','DF',"", "group");
                $form->setBloc('terr_juri_desc','DF',"", "group");
                $form->setBloc('terr_div_surf_etab','DF',_("Terrain issu d'une division de propriete"), "group");
                $form->setBloc('terr_div_surf_av_div','DF',"", "group");

            $form->setFieldset('terr_div_surf_av_div','F','');
            
        $form->setBloc('terr_div_surf_av_div','F');

        // Description de la demande / du projet
        $form->setFieldset('ope_proj_desc', 'D',
            _("Description de la demande / du projet"), "col_12 startClosed");
            $form->setBloc('ope_proj_desc', 'DF', "", "group");
            $form->setBloc('ope_proj_div_co', 'DF', "", "group");
            $form->setBloc('ope_proj_div_contr', 'DF', "", "group");
        $form->setFieldset('ope_proj_div_contr', 'F');

        // Construire, aménager ou modifier un ERP
        $form->setBloc('erp_class_cat','D',"","col_12");
            $form->setFieldset('erp_class_cat','D'
                               ,_("Construire, amenager ou modifier un ERP"), "startClosed alignFormSpec");

            $form->setBloc('erp_class_cat','DF', _("Activite"),"group");
            $form->setBloc('erp_class_type','DF', "","group");

            $form->setBloc('erp_cstr_neuve','DF', _("Nature des travaux (plusieurs cases possibles)"),"group");
            $form->setBloc('erp_trvx_acc','DF', "","group");
            $form->setBloc('erp_extension','DF', "","group");
            $form->setBloc('erp_rehab','DF', "","group");
            $form->setBloc('erp_trvx_am','DF', "","group");
            $form->setBloc('erp_vol_nouv_exist','DF', "","group");
            $form->setBloc('erp_modif_facades','DF', "","group");
            $form->setBloc('erp_trvx_adap','DF', "","group");
            $form->setBloc('erp_trvx_adap_numero','DF', "","group");
            $form->setBloc('erp_trvx_adap_valid','DF', "","group");
            $form->setBloc('erp_prod_dangereux','DF', "","group");

            $form->setBloc('tab_erp_eff','DF', _("Effectif"),"group");

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
                        $form->setBloc('am_lotiss','DF',_("Nature des travaux, instalations
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
                $form->setBloc('am_projet_desc','D',"","col_12");
                    $form->setFieldset('am_projet_desc','D'
                                       ,_("Description amenagement"), "startClosed alignFormSpec");
                                       
                        $form->setBloc('am_projet_desc','DF',"", "group");
                        $form->setBloc('am_terr_surf','DF',"", "group");
                        $form->setBloc('am_tranche_desc','DF',"", "group");
                        
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
                            $form->setBloc('am_exist_agrand','D',"", "alignFormSpec");
                                $form->setBloc('am_exist_agrand','DF',"", "group");
                                $form->setBloc('am_exist_date','DF',"", "group");
                                $form->setBloc('am_exist_num','DF',"", "group");
                                $form->setBloc('am_exist_nb_avant','DF',"", "group");
                                $form->setBloc('am_exist_nb_apres','DF',"", "group");
                                $form->setBloc('am_empl_nb','DF',"", "group");
                            $form->setBloc('am_empl_nb','F',"", "");

                            $form->setBloc('am_tente_nb','D',_("Nombre maximum d’emplacements reserves aux :"), "alignForm");
                            $form->setBloc('am_mobil_nb','F',"", "");
                            
                            $form->setBloc('am_pers_nb','DF',"", "alignFormSpec group");
                            
                            $form->setBloc('am_empl_hll_nb','D',_("Implantation d’habitations legeres de loisirs (HLL) :"), "alignFormSpec");
                                $form->setBloc('am_empl_hll_nb','DF',"", "group");
                                $form->setBloc('am_hll_shon','DF',"", "group");
                                $form->setBloc('am_periode_exploit','DF',"", "group");
                            $form->setBloc('am_periode_exploit','F',"", "");

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
                               ,_("Projet construction"), "startClosed alignFormSpec");
                         
                        $form->setBloc('co_archi_recours','DF',_("Architecte"), "group");
                        $form->setBloc('architecte','DF',"", "group");
                        $form->setBloc('co_archi_attest_honneur','DF',"", "group");
                        
                        $form->setBloc('co_cstr_nouv','DF',_("Nature du projet"), "group");
                        $form->setBloc('avap_co_elt_pro','DF',"", "group");
                        $form->setBloc('avap_nouv_haut_surf','DF',"", "group");
                        $form->setBloc('co_cstr_exist','DF',"", "group");
                        $form->setBloc('co_div_terr','DF',"", "group");
                        $form->setBloc('co_piscine','DF',"", "group");
                        $form->setBloc('co_cloture','DF',"", "group");
                        $form->setBloc('co_autre','DF',"", "group");
                        $form->setBloc('co_autre_desc','DF',"", "group");
                        $form->setBloc('co_projet_desc','DF',"", "group");
                        $form->setBloc('co_elec_tension','DF', __("Si votre projet nécessite une puissance électrique supérieure à 12 kVA monophasé (ou 36 kVA triphasé)"), "group");
                        $form->setBloc('c2zp1_crete','DF', __("Si votre projet est un ouvrage de production d'électricité à partir de l'énergie solaire installé sur le sol"), "group");
                        $form->setBloc('c2zr1_destination','DF',"", "group");

                        $form->setBloc('co_bat_projete','DF',__("Note descriptive succincte du projet"), "group");
                        $form->setBloc('co_bat_existant','DF',"", "group");
                        $form->setBloc('co_bat_nature','DF',"", "group");
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
                        $form->setBloc('tab_surface','DF', _("Destination des constructions et tableau des surfaces (uniquement à remplir si votre projet de construction est situé dans une commune couverte par un plan local d’urbanisme ou un document en tenant lieu appliquant l’article R.123-9 du code de l’urbanisme dans sa rédaction antérieure au 1er janvier 2016)."),"alignFormSpec group");

                        $form->setBloc('tab_surface2','DF', _("Destination, sous-destination des constructions et tableau des surfaces (uniquement à remplir si votre projet de construction est situé dans une commune couverte par le règlement national d’urbanisme, une carte communale ou dans une commune non visée à la rubrique précédente"),"alignFormSpec group");
                    $form->setFieldset('tab_surface2','F','');

                    $form->setFieldset('co_statio_avt_nb','D'
                               ,_("Divers construction"), "startClosed");
                        $form->setBloc('co_statio_avt_nb','D', _("Nombre de places de stationnement"),"col_12");
                            $form->setBloc('co_statio_avt_nb','D', "","alignForm");
                            $form->setBloc('co_statio_apr_nb','F', "","");
                        $form->setBloc('co_statio_apr_nb','F', "","");
                        
                        $form->setBloc('co_statio_adr','D', _("Places de stationnement affectees au projet, amenagees ou reservees en dehors du terrain sur lequel est situe le projet"),"col_12");
                            $form->setBloc('co_statio_adr','DF', "","alignFormSpec");

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
                               ,_("Demolir"), "startClosed alignFormSpec");
                
                $form->setBloc('dm_constr_dates','DF', "","group");
                $form->setBloc('dm_total','DF', "","group");
                $form->setBloc('dm_partiel','DF', "","group");
                $form->setBloc('dm_projet_desc','DF', "","group");
                $form->setBloc('dm_tot_log_nb','DF', "","group");
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
                $form->setBloc('dia_su_util_hab_num','F', "","");
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
                $form->setBloc('dia_mod_cess_prix_vente_autre_num','F', "","");

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
                $form->setBloc('dia_mod_cess_mnt_compt_num','F', "","");
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
                $form->setBloc('dia_observation','DF', "","alignFormSpec group");

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
                               ,_("Declaration des elements necessaires au calcul des impositions"), "startClosed alignFormSpec");
                
                $form->setBloc('tax_surf_tot_cstr','DF', _("Renseignement"),"group");
                $form->setBloc('tax_surf_tot','DF', "","group");
                $form->setBloc('tax_surf','DF', "","group");
                $form->setBloc('tax_surf_suppr_mod','DF', "","group");
                $form->setBloc('tax_surf_tot_demo','DF', "","group");
                
                $form->setBloc('tab_tax_su_princ','DF', _("Creation de locaux destines a l’habitation :"),"group");
                $form->setBloc('tab_tax_su_secon','DF', "","group");
                $form->setBloc('tab_tax_su_heber','DF', "","group");
                $form->setBloc('tab_tax_su_tot','DF', "","group");
                $form->setBloc('tax_su_habit_abr_jard_pig_colom','DF', "","group");
                //
                $form->setBloc('tax_ext_pret','DF', _("Extension de l’habitation principale, creation d’un batiment annexe a cette habitation ou d’un garage clos et couvert."), "group");
                $form->setBloc('tax_ext_desc','DF', "","group");
                $form->setBloc('tax_surf_tax_exist_cons','DF', "","group");
                $form->setBloc('tax_log_exist_nb','DF', "","group");
                $form->setBloc('tax_log_ap_trvx_nb','DF', "", "group");
                $form->setBloc('tax_surf_tax_demo','DF', "", "group");

                //
                $form->setBloc('tax_surf_abr_jard_pig_colom','DF', _("Creation d’abris de jardin, de pigeonniers et colombiers"), "group");

                $form->setBloc('tax_comm_nb','DF', _("Creation ou extension de locaux non destines a l'habitation :"),"group");
                $form->setBloc('tab_tax_su_non_habit_surf','DF', "","group");
                $form->setBloc('tab_tax_am','DF', "","group");
                $form->setBloc('tab_tax_su_parc_statio_expl_comm', 'DF', "", "group");
                $form->setBloc('tax_su_non_habit_abr_jard_pig_colom', 'DF', "", "group");

                $form->setBloc('tax_am_statio_ext_cr','D', _("Autres elements crees soumis à la taxe d’amenagement :"),"col_12");
                $form->setBloc('tax_pann_volt_sup_cr','F');

                $form->setBloc('tax_terrassement_arch','D', _("Redevance d’archeologie preventive"),"col_12 alignFormSpec");
                    $form->setBloc('tax_terrassement_arch','D', _("Veuillez preciser la profondeur du(des) terrassement(s) necessaire(s) a la realisation de votre projet (en mètre)"),"");
                    $form->setBloc('tax_eol_haut_nb_arch','F');
                $form->setBloc('tax_eol_haut_nb_arch','F');

                $form->setBloc('tax_trx_presc_ppr','DF', _("Cas particuliers"),"group");
                $form->setBloc('tax_monu_hist','DF', "","group");

                $form->setBloc('vsd_surf_planch_smd','DF', _("Versement pour sous-densite (VSD)"),"group");
                $form->setBloc('vsd_unit_fonc_sup','DF', "","group");
                $form->setBloc('vsd_unit_fonc_constr_sup','DF', "","group");
                $form->setBloc('vsd_val_terr','DF', "","group");
                $form->setBloc('vsd_const_sxist_non_dem_surf','DF', "","group");
                $form->setBloc('vsd_rescr_fisc','DF', "","group");
                
                $form->setBloc('pld_val_terr','DF', _("Plafond legal de densite (PLD)"),"group");
                $form->setBloc('pld_const_exist_dem','DF', "","group");
                $form->setBloc('pld_const_exist_dem_surf','DF', "","group");

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

                        $form->setBloc('mtn_exo_rap','DF', _("Montant de l'exonération"),"col_12 group");

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
    
    function setLib(&$form,$maj) {
        parent::setLib($form,$maj);
        //libelle des champs
        $form->setLib('architecte', _("coordonnees de l'architecte"));

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

    /**
     * Permet de savoir si le cerfa peut calculer la taxe d'aménagement.
     *
     * @return boolean
     */
    function can_simulate_taxe_amenagement() {
        // Liste des champs necessaires à la simulation de la taxe d'aménagement
        $inst_taxe_amenagement = $this->f->get_inst__om_dbform(array(
            "obj" => "taxe_amenagement",
            "idx" => 0,
        ));
        $list_fields = $inst_taxe_amenagement->get_list_fields_simulation();

        // Pour chaque champ
        foreach ($list_fields as $field) {
            // Si un seul des champs requis n'est pas dans le cerfa
            if ($this->getVal($field) == 'f') {
                // Retourne faux
                return false;
            }
        }

        // Retourne vrai
        return true;
    }


    /**
     * Récupère les champs du CERFA ainsi que leurs valeurs.
     *
     * @return array $result Tableau associatif
     */
    function get_form_val() {

        // Initialisation du tableau des résultats
        $result = array();

        // Pour chaque champ
        foreach ($this->champs as $champ) {
            // Récupère sa valeur
            $result[$champ] = $this->getVal($champ);
        }
        
        // Retourne le résultat
        return $result;
    }


}// fin classe

