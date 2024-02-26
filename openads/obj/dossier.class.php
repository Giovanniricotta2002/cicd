<?php
/**
 * DBFORM - 'dossier' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $$Id: dossier.class.php 6912 2017-06-15 08:20:09Z tuxayo $
 */

require_once "../gen/obj/dossier.class.php";

require_once "../obj/geoads.class.php";
require_once "../obj/task.class.php";

class dossier extends dossier_gen {

    const LAT_LON_REGEX = "/^(?P<deg>\d+)(°|d) *(?P<min>\d+)[.,](?P<dec>\d+)('|`|′)? *(?P<dir>[NSEOW])\$/";

    var $maj;
    var $dossier_instruction_type;
    var $is_incomplet_notifie = null;
    var $valIdDemandeur = array("petitionnaire_principal" => array(),
                                "delegataire" => array(),
                                "petitionnaire" => array(),
                                "plaignant_principal" => array(),
                                "plaignant" => array(),
                                "contrevenant_principal" => array(),
                                "contrevenant" => array(),
                                "requerant_principal" => array(),
                                "requerant" => array(),
                                "avocat_principal" => array(),
                                "avocat" => array(),
                                "bailleur_principal" => array(),
                                "bailleur" => array(),
                                "proprietaire" => array(),
                                "architecte_lc" => array(),
                                "paysagiste" => array(),
                            );
    var $postedIdDemandeur = array("petitionnaire_principal" => array(),
                                "delegataire" => array(),
                                "petitionnaire" => array(),
                                "plaignant_principal" => array(),
                                "plaignant" => array(),
                                "contrevenant_principal" => array(),
                                "contrevenant" => array(),
                                "requerant_principal" => array(),
                                "requerant" => array(),
                                "avocat_principal" => array(),
                                "avocat" => array(),
                                "bailleur_principal" => array(),
                                "bailleur" => array(),
                                "proprietaire" => array(),
                                "architecte_lc" => array(),
                                "paysagiste" => array(),
                            );
    /**
     * Instance de la classe taxe_amenagement.
     *
     * @var null
     */
    var $inst_taxe_amenagement = null;

    /**
     * Instance de la classe donnees_techniques.
     *
     * @var null
     */
    var $inst_donnees_techniques = null;

    /**
     * Instance de la classe dossier_autorisation.
     *
     * @var mixed (resource | null)
     */
    var $inst_dossier_autorisation = null;

    /**
     * Instance de la classe dossier_autorisation_type_detaille.
     *
     * @var null
     */
    var $inst_dossier_autorisation_type_detaille = null;

    /**
     * Instance de la classe cerfa.
     *
     * @var null
     */
    var $inst_cerfa = null;

    /**
     * Groupe du dossier d'instruction.
     *
     * @var null
     */
    var $groupe = null;

    /**
     * Instance de la classe groupe.
     */
    var $inst_groupe = null;

    /**
     * Instance de la classe dossier_autorisation_type.
     *
     * @var null
     */
    var $inst_dossier_autorisation_type = null;

    /**
     * Instance de la classe demande.
     *
     * @var mixed (resource | null)
     */
    var $inst_demande = null;

    /**
     * Liste des types de tâches.
     *
     * @var array
     */
    var $task_types = array(
        'incompletude_DI',
        'qualification_DI',
        'decision_DI',
        'completude_DI',
        'pec_metier_consultation',
        'avis_consultation',
        'modification_DI',
        'prescription',
        'lettre_incompletude',
        'lettre_majoration'
    );

    /**
     * Liste des champs requis dans Plat'AU.
     *
     * @var array
     */
    var $list_platau_required_fields_dossier = array(
        'donnees_techniques.enga_decla_date',
        'donnees_techniques.enga_decla_lieu',
        'dossier.terrain_adresse_localite',
        'demandeur.localite',
        'architecte.ville',
        'donnees_techniques.doc_tot_trav',
        'donnees_techniques.doc_date',
        'donnees_techniques.doc_surf',
        'donnees_techniques.daact_date',
        'donnees_techniques.daact_tot_trav',
    );


    /**
     * Liste des champs requis dans Plat'AU seulement pour des types de dossier
     * d'instruction spécifiques.
     *
     * @var array
     */
    var $list_platau_required_fields_dossier_exception = array(
        'donnees_techniques.doc_tot_trav' => array('doc', ),
        'donnees_techniques.doc_date' => array('doc', ),
        'donnees_techniques.doc_surf' => array('doc', ),
        'donnees_techniques.daact_date' => array('daact', ),
        'donnees_techniques.daact_tot_trav' => array('daact', ),
    );

    /**
     * Liaison NaN
     * 
     * Tableau contenant les objets qui représente les liaisons.
     */
    var $liaisons_nan = array(
        "lien_dossier_nature_travaux" => array(
            "table_l" => "lien_dossier_nature_travaux",
            "table_f" => "nature_travaux",
            "field" => "nature_travaux",
        )
    );

    /**
     * [$portal_code_suivi description]
     * @var boolean
     */
    var $is_portal_code_suivi = false;

    /**
     * Set un tableau pour la conception des requêtes de suppression des éléments
     * dans les tables de liaisons.
     * Le tableau est constitué de la manière suivante :
     *      'nom_de_la_table' => array(
     *          'table' => "nom de la table à supprimer si il
     *                      n'a pas pu être renseigné comme clé du tableau",
     *          'condition_field' => 'nom du champs utilisée pour identifier
     *                                les éléments liés',
     *          'condition_value' => 'valeur utilisée pour identifier les
     *                                éléments liés'
     *       ),
     *
     * @var array
     */
    public function set_related_tables() {
        $this->related_tables = array(
            'lien_demande_demandeur' => array(
                'condition_field' => 'demande',
                'condition_value' => $this->get_idx_by_args(
                    'demande',
                    'demande',
                    'dossier_instruction',
                    $this->getVal($this->clePrimaire)),
            ),
            'demande' => array(
                'condition_field' => 'dossier_instruction',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'lien_dossier_demandeur' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'instruction_notification_document' => array(
                'condition_field' => 'instruction_notification',
                'condition_value' => sprintf(
                    'SELECT
                        %2$s
                    FROM
                        %1$s%2$s
                    WHERE
                        %3$s IN (%4$s)',
                    DB_PREFIXE,
                    'instruction_notification',
                    'instruction',
                    sprintf(
                        'SELECT
                            %2$s
                        FROM
                            %1$s%2$s
                        WHERE
                            %3$s = \'%4$s\'',
                        DB_PREFIXE,
                        'instruction',
                        'dossier',
                        $this->getVal($this->clePrimaire)
                    )
                ),
            ),
            'instruction_notification' => array(
                'condition_field' => 'instruction',
                'condition_value' => sprintf(
                    'SELECT
                        %2$s
                    FROM
                        %1$s%2$s
                    WHERE
                        %3$s = \'%4$s\'',
                    DB_PREFIXE,
                    'instruction',
                    'dossier',
                    $this->getVal($this->clePrimaire)
                ),
            ),
            'instruction' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'dossier_parcelle' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'dossier_contrainte' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'lien_donnees_techniques_moyen_retenu_juge' => array(
                'condition_field' => 'donnees_techniques',
                'condition_value' => $this->get_idx_by_args(
                    'donnees_techniques',
                    'donnees_techniques',
                    'dossier_instruction',
                    $this->getVal($this->clePrimaire)),
            ),
            'lien_donnees_techniques_moyen_souleve' => array(
                'condition_field' => 'donnees_techniques',
                'condition_value' => $this->get_idx_by_args(
                    'donnees_techniques',
                    'donnees_techniques',
                    'dossier_instruction',
                    $this->getVal($this->clePrimaire)),
            ),
            'donnees_techniques_di' => array(
                'table' => 'donnees_techniques',
                'condition_field' => 'dossier_instruction',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'blocnote' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'consultation_entrante' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'consultation' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'document_numerise' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'rapport_instruction' => array(
                'condition_field' => 'dossier_instruction',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'dossier_commission' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'dossier_message' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'lien_dossier_dossier_1' => array(
                'table' => 'lien_dossier_dossier',
                'condition_field' => 'dossier_src',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'lien_dossier_dossier_2' => array(
                'table' => 'lien_dossier_dossier',
                'condition_field' => 'dossier_cible',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'dossier_geolocalisation' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'donnees_techniques_lot' => array(
                'table' => 'donnees_techniques',
                'condition_field' => 'lot',
                'condition_value' => $this->get_idx_by_args(
                    "string_agg(lot::text, ', ')",
                    'lot',
                    'dossier',
                    $this->getVal($this->clePrimaire)),
            ),
            'lien_lot_demandeur' => array(
                'condition_field' => 'lot',
                'condition_value' => $this->get_idx_by_args(
                    "string_agg(lot::text, ', ')",
                    'lot',
                    'dossier',
                    $this->getVal($this->clePrimaire)),
            ),
            'lot' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'dossier_operateur' => array(
                'condition_field' => 'dossier_instruction',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            ),
            'lien_dossier_nature_travaux' => array(
                'condition_field' => 'dossier',
                'condition_value' => sprintf("'%s'", $this->getVal($this->clePrimaire)),
            )
        );
    }


    /*Mutateur pour ma variable dossier_instruction_type*/
    public function getDossierInstructionType(){
        return $this->dossier_instruction_type;
    }
    public function setDossierInstructionType($dossier_instruction_type){
        $this->dossier_instruction_type = $dossier_instruction_type;
    }

    /**
     * Récupère l'attribut is_portal_code_suivi.
     * @return boolean
     */
    public function get_is_portal_code_suivi(){
        return $this->is_portal_code_suivi;
    }

    /**
     * Change la valeur de l'attribut is_portal_code_suivi.
     * @param boolean $value
     */
    public function set_is_portal_code_suivi($value){
        $this->is_portal_code_suivi = is_bool($value) === true ? $value : false;
    }

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        
        parent::init_class_actions();

        // ACTION - 003 - consulter
        //
        $this->class_actions[3]["condition"] = array(
            "is_user_from_allowed_collectivite",
            "check_context",
        );

        // ACTION - 004 - contrainte
        //
        $this->class_actions[4] = array(
            "identifier" => "contrainte",
            "view" => "view_contrainte",
            "permission_suffix" => "contrainte_tab",
            "condition" => array(
                "is_user_from_allowed_collectivite",
            ),
        );

        // ACTION - 005 - view_document_numerise
        // Interface spécifique du tableau des pièces
        $this->class_actions[5] = array(
            "identifier" => "view_document_numerise",
            "view" => "view_document_numerise",
            "permission_suffix" => "document_numerise",
            "condition" => array(
                "is_user_from_allowed_collectivite",
            ),
        );
        
        // ACTION - 006 - view_sitadel
        //
        $this->class_actions[6] = array(
            "identifier" => "sitadel",
            "view" => "view_sitadel",
            "permission_suffix" => "export_sitadel",
        );

        // ACTION - 777 - Redirection vers la classe fille adéquate
        // 
        $this->class_actions[777] = array(
            "identifier" => "redirect",
            "view" => "redirect",
            "permission_suffix" => "consulter",
        );

        //
        //
        $this->class_actions[998] = array(
            "identifier" => "json_data",
            "view" => "view_json_data",
            "permission_suffix" => "consulter",
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        $champs = array(
            "dossier.dossier",
            "dossier.om_collectivite AS om_collectivite"
        );
        if ($this->f->is_option_dossier_commune_enabled()) {
            $champs[] = "dossier.commune AS commune";
        }

        $fieldset_dossier_instruction = array(
            "dossier.dossier_libelle",
            "dossier.dossier_instruction_type",
            "dossier_autorisation_type_detaille.libelle as dossier_autorisation_type_detaille",
            "autorisation_contestee",
            "donnees_techniques.ctx_reference_dsj as ctx_reference_dsj",
            "donnees_techniques.ctx_reference_sagace as ctx_reference_sagace",
            "dossier.depot_electronique",
            "CASE WHEN requerant_principal.qualite='particulier' THEN
                TRIM(CONCAT(requerant_principal.particulier_nom, ' ', requerant_principal.particulier_prenom))
            ELSE
                TRIM(CONCAT(requerant_principal.personne_morale_raison_sociale, ' ', requerant_principal.personne_morale_denomination))
            END as requerants",
            "CASE WHEN petitionnaire_principal.qualite='particulier' THEN
                TRIM(CONCAT(petitionnaire_principal.particulier_nom, ' ', petitionnaire_principal.particulier_prenom))
            ELSE
                TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, ' ', petitionnaire_principal.personne_morale_denomination))
            END as dossier_petitionnaire",
            "'' as dossier_petitionnaires",
            "CASE WHEN contrevenant_principal.qualite='particulier' THEN
                TRIM(CONCAT(contrevenant_principal.particulier_nom, ' ', contrevenant_principal.particulier_prenom))
            ELSE
                TRIM(CONCAT(contrevenant_principal.personne_morale_raison_sociale, ' ', contrevenant_principal.personne_morale_denomination))
            END as contrevenants",
            "TRIM(
                CONCAT_WS(
                    ' ',
                    replace(dossier.terrain_references_cadastrales,';',' '),
                    '<br/>',
                    CASE
                        WHEN dossier.adresse_normalisee IS NULL
                            OR TRIM(dossier.adresse_normalisee) = ''
                        THEN
                        ".DB_PREFIXE."adresse(
                            dossier.terrain_adresse_voie_numero::text,
                            dossier.terrain_adresse_voie::text,
                            ''::text,
                            dossier.terrain_adresse_lieu_dit::text,
                            dossier.terrain_adresse_bp::text,
                            dossier.terrain_adresse_code_postal::text,
                            dossier.terrain_adresse_localite::text,
                            dossier.terrain_adresse_cedex::text,
                            ''::text,
                            ', '::text
                        )
                        ELSE
                            dossier.adresse_normalisee
                    END
                )
            ) as terrain",
            "arrondissement.libelle as dossier_arrondissement",
            'dossier.adresse_normalisee',
            'dossier.adresse_normalisee_json',
            'dossier.dossier_parent',
            sprintf("(SELECT string_agg(nature_travaux::text, ';') FROM %slien_dossier_nature_travaux WHERE dossier = dossier.dossier) as nature_travaux",
             DB_PREFIXE),
            // description/nature des travaux. En cas de modif, bloc de code aussi
            // présent dans 'dossier_instruction.inc.php','om_requete'
            // et 'stats à la demande'.
            "CONCAT_WS(
                '<br/>',
                CASE WHEN co_projet_desc = '' THEN
                    NULL
                ELSE
                    TRIM(co_projet_desc)
                END,
                CASE WHEN ope_proj_desc = '' THEN
                    NULL
                ELSE
                    TRIM(ope_proj_desc)
                END,
                CASE WHEN am_projet_desc = '' THEN
                    NULL
                ELSE
                    TRIM(am_projet_desc)
                END,
                CASE WHEN dm_projet_desc = '' THEN
                    NULL
                ELSE
                    TRIM(dm_projet_desc)
                END,
                CASE WHEN donnees_techniques.erp_cstr_neuve IS TRUE
                    THEN '".str_replace("'", "''", _('erp_cstr_neuve'))."' END,
                CASE WHEN donnees_techniques.erp_trvx_acc IS TRUE
                    THEN '".str_replace("'", "''", _('erp_trvx_acc'))."' END,
                CASE WHEN donnees_techniques.erp_extension IS TRUE
                    THEN '".str_replace("'", "''", _('erp_extension'))."' END,
                CASE WHEN donnees_techniques.erp_rehab IS TRUE
                    THEN '".str_replace("'", "''", _('erp_rehab'))."' END,
                CASE WHEN donnees_techniques.erp_trvx_am IS TRUE
                    THEN '".str_replace("'", "''", _('erp_trvx_am'))."' END,
                CASE WHEN donnees_techniques.erp_vol_nouv_exist IS TRUE
                    THEN '".str_replace("'", "''", _('erp_vol_nouv_exist'))."' END,
                CASE WHEN mh_design_appel_denom = '' THEN
                    NULL
                ELSE
                    TRIM(mh_design_appel_denom)
                END,
                CASE WHEN mh_loc_denom = '' THEN
                    NULL
                ELSE
                    TRIM(mh_loc_denom)
                END
            ) as \"description_projet\"",
            //
            "donnees_techniques.ctx_synthese_nti as dt_ctx_synthese_nti",
            "donnees_techniques.ctx_synthese_anr as dt_ctx_synthese_anr ",
            "donnees_techniques.ctx_infraction as dt_ctx_infraction ",
            "donnees_techniques.ctx_regularisable as dt_ctx_regularisable ",
            "dossier_autorisation.dossier_autorisation",
            "dossier_autorisation.dossier_autorisation_libelle",
            "annee",
            "autorite_competente"
        );

        $fieldset_instruction = array(
            "dossier.instructeur",
            "instructeur_2",
            "dossier.division",
            "public.ST_AsText(dossier.geom::geometry) as geom",
            "'' as streetview",
            "tax_secteur"
        );

        $fieldset_enjeu = array(
            "enjeu_urba",
            "enjeu_erp",
            "'' as enjeu_ctx"
        );

        $fieldset_qualification = array(
            "erp",
            "a_qualifier",
            "pec_metier",
            "etat_transmission_platau"
        );

        $fieldset_archive = array(
            "numero_versement_archive",
            "date_demande",
        );

        $fieldset_suivi = array(
            // Col 1
            "dossier.date_depot",
            "dossier.date_depot_mairie",
            "dossier.date_affichage",
            "date_premiere_visite",
            "date_derniere_visite",
            "date_contradictoire",
            "date_retour_contradictoire",
            "date_ait",
            "date_transmission_parquet",
            "donnees_techniques.ctx_date_audience as date_audience",
            "delai",
            "delai_incompletude",
            "date_dernier_depot",
            "date_limite",
            "date_complet",
            "date_limite_incompletude",
            "date_cloture_instruction",
            // Col 2
            "dossier.etat",
            "evenement_suivant_tacite",
            "evenement_suivant_tacite_incompletude"
        );

        $fieldset_decision = array(
            "dossier.date_decision",
            "dossier.avis_decision"
        );

        $fieldset_validite_autorisation = array(
            "dossier.date_validite",
        );

        $fieldset_autre = array(
            // Col 1
            "accord_tacite",
            // Col 2
            "date_rejet",
            "date_notification_delai",
            "dossier.date_chantier",
            "dossier.date_achevement",
            // Col 3
            "date_conformite",
        );

        $fieldset_taxe = array(
            "tax_mtn_part_commu",
            "tax_mtn_part_commu_sans_exo",
            "tax_mtn_part_depart",
            "tax_mtn_part_depart_sans_exo",
            "tax_mtn_part_reg",
            "tax_mtn_part_reg_sans_exo",
            "tax_mtn_total",
            "tax_mtn_total_sans_exo",
            "tax_mtn_rap",
            "tax_mtn_rap_sans_exo",
        );

        $fieldset_localisation = array(
            // Col 1
            "dossier.terrain_adresse_voie_numero",
            "dossier.terrain_adresse_lieu_dit",
            "dossier.terrain_adresse_code_postal",
            "dossier.terrain_adresse_cedex",
            "dossier.parcelle_temporaire",
            "dossier.terrain_references_cadastrales",
            "dossier.geoloc_latitude",
            "dossier.geoloc_longitude",
            "dossier.geoloc_rayon",
            // Col 2
            "dossier.terrain_adresse_voie",
            "dossier.terrain_adresse_bp",
            "dossier.terrain_adresse_localite",
            "dossier.terrain_superficie",
            "dossier.terrain_superficie_calculee"
        );

        $fieldset_indetermine = array(
            "geom1",
            "dossier.description",
            "version",
            "incompletude",
            "incomplet_notifie",
            "etat_pendant_incompletude",
            "dossier.duree_validite",
            "quartier",
            "dossier.log_instructions",
            "interface_referentiel_erp",
            "date_modification",
            "hash_sitadel",
            "version_clos",
            "initial_dt"
        );

        $fieldset_poc = array(
            "dossier.numerotation_type",
            "dossier.numerotation_dep",
            "dossier.numerotation_com",
            "dossier.numerotation_division",
            "dossier.numerotation_suffixe",
            "dossier.numerotation_entite",
            "dossier.numerotation_num",
            "dossier.numerotation_num_suffixe",
            "dossier.numerotation_num_entite",
        );

        $fieldset_consultation_entrante = array(
            "consultation_entrante.consultation_entrante",
            "consultation_entrante.delai_reponse",
            "consultation_entrante.type_delai",
            "consultation_entrante.date_consultation",
            "consultation_entrante.date_emission",
            "consultation_entrante.date_production_notification",
            "consultation_entrante.date_premiere_consultation",
            "consultation_entrante.objet_consultation",
            "consultation_entrante.etat_consultation",
            "consultation_entrante.type_consultation",
            "consultation_entrante.texte_fondement_reglementaire",
            "consultation_entrante.texte_objet_consultation",
            "consultation_entrante.service_consultant_id",
            "consultation_entrante.service_consultant_libelle",
            "consultation_entrante.service_consultant_insee",
            "consultation_entrante.service_consultant_mail",
            "consultation_entrante.service_consultant_type",
            "consultation_entrante.service_consultant__siren",
            "consultation_entrante.dossier as dossier_consultation",
            "'' as lien_iiue_portal",
            "'' as lien_iiue"
        );

        $fieldsets_order = array(
            'dossier_instruction',
            'instruction',
            'enjeu',
            'qualification',
            'archive',
            'suivi',
            'decision',
            'validite_autorisation',
            'autre',
            'taxe',
            'localisation',
            'indetermine',
            'poc',
            'consultation_entrante'
        );

        $obj = $this->f->get_submitted_get_value("obj");
        if (strpos($obj, 'dossier_instruction') !== false
            || $obj == "sous_dossier") {

            $fieldset_dossier_instruction = array(
		        "autorite_competente",
                "dossier.dossier_libelle",
                "dossier.dossier_instruction_type",
                "dossier_autorisation_type_detaille.libelle as dossier_autorisation_type_detaille",
                "autorisation_contestee",
                "donnees_techniques.ctx_reference_dsj as ctx_reference_dsj",
                "donnees_techniques.ctx_reference_sagace as ctx_reference_sagace",
                "dossier.depot_electronique",
                "CASE WHEN requerant_principal.qualite='particulier' THEN
                    TRIM(CONCAT(requerant_principal.particulier_nom, ' ', requerant_principal.particulier_prenom))
                ELSE
                    TRIM(CONCAT(requerant_principal.personne_morale_raison_sociale, ' ', requerant_principal.personne_morale_denomination))
                END as requerants",
                "CASE WHEN petitionnaire_principal.qualite='particulier' THEN
                    TRIM(CONCAT(petitionnaire_principal.particulier_nom, ' ', petitionnaire_principal.particulier_prenom))
                ELSE
                    TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, ' ', petitionnaire_principal.personne_morale_denomination))
                END as dossier_petitionnaire",
                "'' as dossier_petitionnaires",
                "CASE WHEN contrevenant_principal.qualite='particulier' THEN
                    TRIM(CONCAT(contrevenant_principal.particulier_nom, ' ', contrevenant_principal.particulier_prenom))
                ELSE
                    TRIM(CONCAT(contrevenant_principal.personne_morale_raison_sociale, ' ', contrevenant_principal.personne_morale_denomination))
                END as contrevenants",
                "arrondissement.libelle as dossier_arrondissement",
                'dossier.adresse_normalisee',
                'dossier.adresse_normalisee_json',
                'dossier.dossier_parent',
                sprintf("(SELECT string_agg(nature_travaux::text, ';') FROM %slien_dossier_nature_travaux WHERE dossier = dossier.dossier) as nature_travaux",
                DB_PREFIXE),
                // description/nature des travaux. En cas de modif, bloc de code aussi
                // présent dans 'dossier_instruction.inc.php','om_requete'
                // et 'stats à la demande'.
                "CONCAT_WS(
                    '<br/>',
                    CASE WHEN co_projet_desc = '' THEN
                        NULL
                    ELSE
                        TRIM(co_projet_desc)
                    END,
                    CASE WHEN ope_proj_desc = '' THEN
                        NULL
                    ELSE
                        TRIM(ope_proj_desc)
                    END,
                    CASE WHEN am_projet_desc = '' THEN
                        NULL
                    ELSE
                        TRIM(am_projet_desc)
                    END,
                    CASE WHEN dm_projet_desc = '' THEN
                        NULL
                    ELSE
                        TRIM(dm_projet_desc)
                    END,
                    CASE WHEN donnees_techniques.erp_cstr_neuve IS TRUE
                        THEN '".str_replace("'", "''", _('erp_cstr_neuve'))."' END,
                    CASE WHEN donnees_techniques.erp_trvx_acc IS TRUE
                        THEN '".str_replace("'", "''", _('erp_trvx_acc'))."' END,
                    CASE WHEN donnees_techniques.erp_extension IS TRUE
                        THEN '".str_replace("'", "''", _('erp_extension'))."' END,
                    CASE WHEN donnees_techniques.erp_rehab IS TRUE
                        THEN '".str_replace("'", "''", _('erp_rehab'))."' END,
                    CASE WHEN donnees_techniques.erp_trvx_am IS TRUE
                        THEN '".str_replace("'", "''", _('erp_trvx_am'))."' END,
                    CASE WHEN donnees_techniques.erp_vol_nouv_exist IS TRUE
                        THEN '".str_replace("'", "''", _('erp_vol_nouv_exist'))."' END,
                    CASE WHEN mh_design_appel_denom = '' THEN
                        NULL
                    ELSE
                        TRIM(mh_design_appel_denom)
                    END,
                    CASE WHEN mh_loc_denom = '' THEN
                        NULL
                    ELSE
                        TRIM(mh_loc_denom)
                    END
                ) as \"description_projet\"",
                //
                "donnees_techniques.ctx_synthese_nti as dt_ctx_synthese_nti",
                "donnees_techniques.ctx_synthese_anr as dt_ctx_synthese_anr ",
                "donnees_techniques.ctx_infraction as dt_ctx_infraction ",
                "donnees_techniques.ctx_regularisable as dt_ctx_regularisable ",
                "dossier_autorisation.dossier_autorisation",
                "dossier_autorisation.dossier_autorisation_libelle",
                "annee",
                
            );

            $fieldset_localisation = array(
                // Fieldset "Localisation du terrain"
                // Col 1
                "dossier.terrain_adresse_voie_numero",
                "dossier.terrain_adresse_voie",
                "dossier.terrain_adresse_lieu_dit",
                "dossier.terrain_adresse_bp",
                "dossier.terrain_adresse_code_postal",
                "dossier.terrain_adresse_localite",
                "dossier.terrain_adresse_cedex",
                "TRIM(
                    CONCAT_WS(
                        ' ',
                        replace(dossier.terrain_references_cadastrales,';',' '),
                        '<br/>',
                        CASE
                            WHEN dossier.adresse_normalisee IS NULL
                                OR TRIM(dossier.adresse_normalisee) = ''
                            THEN
                            ".DB_PREFIXE."adresse(
                                dossier.terrain_adresse_voie_numero::text,
                                dossier.terrain_adresse_voie::text,
                                ''::text,
                                dossier.terrain_adresse_lieu_dit::text,
                                dossier.terrain_adresse_bp::text,
                                dossier.terrain_adresse_code_postal::text,
                                dossier.terrain_adresse_localite::text,
                                dossier.terrain_adresse_cedex::text,
                                ''::text,
                                ', '::text
                            )
                            ELSE
                                dossier.adresse_normalisee
                        END
                    )
                ) as terrain",
                "dossier.parcelle_temporaire",
                "dossier.terrain_references_cadastrales",
                "dossier.geoloc_latitude",
                "dossier.geoloc_longitude",
                "dossier.terrain_superficie",
                "dossier.terrain_superficie_calculee",
                "dossier.geoloc_rayon",
                // Col 2
                "public.ST_AsText(dossier.geom::geometry) as geom",
                "'' as streetview",
                "tax_secteur",
            );

            $fieldset_instruction = array(
                "date_demande",
                "dossier.instructeur",
                "instructeur_2",
                "dossier.division",
            );

            $fieldset_suivi = array(
                "dossier.date_depot",
                "dossier.etat",
                "delai",
                "date_dernier_depot",
                "dossier.date_depot_mairie",
                "dossier.date_affichage",
                "date_premiere_visite",
                "date_derniere_visite",
                "date_contradictoire",
                "date_retour_contradictoire",
                "date_ait",
                "date_transmission_parquet",
                "donnees_techniques.ctx_date_audience as date_audience",
                "delai_incompletude",
                "date_limite",
                "evenement_suivant_tacite",
                "evenement_suivant_tacite_incompletude",
                "date_complet",
                "date_limite_incompletude",
                "date_cloture_instruction",
            );

            $fieldset_archive = array(
                "numero_versement_archive"
            );

            $fieldsets_order = array(
                'dossier_instruction',
                'localisation',
                'instruction',
                'suivi',
                'decision',
                'validite_autorisation',
                'enjeu',
                'qualification',
                'archive',
                'autre',
                'taxe',
                'indetermine',
                'poc',
                'consultation_entrante'
            );
        }

        foreach ($fieldsets_order as $fieldset) {
            $name = 'fieldset_'.$fieldset;
            $champs = array_merge($champs, ${$name});
        }

        return $champs;
    }

    /**
     * Clause from pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__tableSelect() {
        return sprintf(
            '%1$s%2$s
                LEFT JOIN %1$savis_decision
                    ON avis_decision.avis_decision=dossier.avis_decision
                LEFT JOIN %1$sdossier_autorisation
                    ON dossier.dossier_autorisation=dossier_autorisation.dossier_autorisation
                LEFT JOIN %1$sdossier_autorisation_type_detaille
                    ON dossier_autorisation.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                LEFT JOIN (
                        SELECT * 
                        FROM %1$slien_dossier_demandeur
                        INNER JOIN %1$sdemandeur
                            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
                        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
                        AND LOWER(demandeur.type_demandeur) = LOWER(\'petitionnaire\')
                    ) as petitionnaire_principal
                    ON petitionnaire_principal.dossier = dossier.dossier
                LEFT JOIN (
                        SELECT * 
                        FROM %1$slien_dossier_demandeur
                        INNER JOIN %1$sdemandeur
                            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
                        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
                        AND LOWER(demandeur.type_demandeur) = LOWER(\'requerant\')
                    ) as requerant_principal
                    ON requerant_principal.dossier = dossier.dossier
                LEFT JOIN (
                        SELECT * 
                        FROM %1$slien_dossier_demandeur
                        INNER JOIN %1$sdemandeur
                            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
                        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
                        AND LOWER(demandeur.type_demandeur) = LOWER(\'contrevenant\')
                    ) as contrevenant_principal
                    ON contrevenant_principal.dossier = dossier.dossier
                LEFT JOIN %1$sdonnees_techniques
                    ON donnees_techniques.dossier_instruction = dossier.dossier
                LEFT JOIN %1$setat
                    ON dossier.etat = etat.etat
                LEFT JOIN %1$sarrondissement
                    ON dossier.terrain_adresse_code_postal = arrondissement.code_postal
                LEFT JOIN %1$sconsultation_entrante
                    ON dossier.dossier = consultation_entrante.dossier',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision() {
        return "SELECT avis_decision,libelle from ".DB_PREFIXE."avis_decision order by libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision_by_id() {
        return "SELECT avis_decision.avis_decision, libelle FROM ".DB_PREFIXE."avis_decision WHERE avis_decision = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation() {
        return "SELECT dossier_autorisation.dossier_autorisation, dossier_autorisation.dossier_autorisation FROM ".DB_PREFIXE."dossier_autorisation ORDER BY dossier_autorisation.dossier_autorisation ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_by_id() {
        return "SELECT dossier_autorisation.dossier_autorisation, dossier_autorisation.dossier_autorisation FROM ".DB_PREFIXE."dossier_autorisation WHERE dossier_autorisation = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement ORDER BY arrondissement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement_by_id() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement WHERE arrondissement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorisation_contestee() {
        return "SELECT dossier.dossier, dossier.dossier_libelle FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorisation_contestee_by_id() {
        return "SELECT dossier.dossier, dossier.dossier_libelle FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.code 
            FROM ".DB_PREFIXE."dossier_autorisation_type_detaille
            ORDER BY dossier_autorisation_type_detaille.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille_by_id() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.code FROM ".DB_PREFIXE."dossier_autorisation_type_detaille WHERE dossier_autorisation_type_detaille = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demandeur() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle 
            FROM ".DB_PREFIXE."dossier_autorisation_type_detaille
            ORDER BY dossier_autorisation_type_detaille.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demandeur_by_id() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle FROM ".DB_PREFIXE."dossier_autorisation_type_detaille WHERE dossier_autorisation_type_detaille = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_div() {
        return "SELECT instructeur.instructeur, instructeur.nom||' ('||division.code||')' 
            FROM ".DB_PREFIXE."instructeur 
            INNER JOIN ".DB_PREFIXE."division ON division.division=instructeur.division
            INNER JOIN ".DB_PREFIXE."instructeur_qualite ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
            WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))
            <instructeur_qualite>
            ORDER BY nom";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_nature_travaux_by_dit() {
        return sprintf('SELECT 
          nature_travaux.nature_travaux, 
          CONCAT_WS(\' / \', famille_travaux.libelle, nature_travaux.libelle) as lib
        FROM %1$snature_travaux LEFT JOIN %1$sfamille_travaux ON nature_travaux.famille_travaux = famille_travaux.famille_travaux
            LEFT JOIN %1$slien_dit_nature_travaux ON lien_dit_nature_travaux.nature_travaux = nature_travaux.nature_travaux 
            WHERE
                lien_dit_nature_travaux.dossier_instruction_type = <dossier_instruction_type>
            AND 
            (
                nature_travaux.om_validite_debut IS NULL
                OR nature_travaux.om_validite_debut <= CURRENT_DATE
            )
            AND (
                nature_travaux.om_validite_fin IS NULL
                OR nature_travaux.om_validite_fin > CURRENT_DATE
            )
            AND
            (
                famille_travaux.om_validite_debut IS NULL
                OR famille_travaux.om_validite_debut <= CURRENT_DATE
            )
            AND (
                famille_travaux.om_validite_fin IS NULL
                OR famille_travaux.om_validite_fin > CURRENT_DATE
            )
        ORDER BY famille_travaux.libelle, nature_travaux.libelle',
        DB_PREFIXE);
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_nature_travaux_by_id() {
        return sprintf('SELECT 
          nature_travaux.nature_travaux, 
          CONCAT_WS(\' / \', famille_travaux.libelle, nature_travaux.libelle) as lib
        FROM 
            %1$snature_travaux
        INNER JOIN
            %1$sfamille_travaux ON nature_travaux.famille_travaux = famille_travaux.famille_travaux
        WHERE
            nature_travaux.nature_travaux IN (<idx>)
        ORDER BY 
            nature_travaux.libelle',
        DB_PREFIXE);
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_div_by_id() {
        return "SELECT instructeur.instructeur, instructeur.nom||' ('||division.code||')' 
            FROM ".DB_PREFIXE."instructeur 
            INNER JOIN ".DB_PREFIXE."division ON division.division=instructeur.division 
            INNER JOIN ".DB_PREFIXE."instructeur_qualite ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
            WHERE instructeur = <idx>";
    }

    /**
     * Requête de récupération de la liste des instructeurs avec le nom de leur division et leur identifiant.
     *
     * Selon le cas d'usage cette requête est adapté. Il y a 3 cas possible :
     * Cas 1 : l'option de filtre par division n'est pas active ou l'utilisateur n'a pas de division.
     *         => tous les instructeur de la collectivité de l'utilisateur ou de la collectivité de niveau
     *            2 sont récupérés par la requête
     * Cas 2 : l'option de filtre par division est active, l'utilisateur a une division et il n'appartiens
     *         pas à la collectivité de niveau 2
     *         => seuls les instructeur de la division de l'utilisateur sont récupérés par la requête.
     * Cas 3 : l'option de filtre par division est active, l'utilisateur a une division et il appartiens
     *         à la collectivité de niveau 2
     *         => les instructeur de la division de l'utilisateur ou étant associés à une collectivité de
     *             niveau sont récupérés.
     *            
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_div_by_di() {
        // Cas 1
        $filter ="AND (om_collectivite.niveau = '2' OR direction.om_collectivite = '<collectivite_di>')";
        $division = $_SESSION['division'];
        if ($this->f->is_option_enabled('option_filtre_instructeur_DI_par_division') && $division != '0') {
            // Cas 2
            $filter = sprintf(
                'AND division.division = %d',
                intval($division)
            );
            // Cas 3
            if ($_SESSION['niveau'] == '2') {
                $filter = sprintf(
                    "AND (om_collectivite.niveau = '1'
                        OR division.division = %d)",
                    intval($division)
                );
            }
        }

        return sprintf(
            "SELECT
                instructeur.instructeur,
                instructeur.nom||' ('||division.code||')' 
            FROM
                %1\$sinstructeur 
                INNER JOIN %1\$sdivision
                    ON division.division=instructeur.division
                INNER JOIN %1\$sinstructeur_qualite
                    ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
                LEFT JOIN %1\$sdirection
                    ON division.direction = direction.direction
                LEFT JOIN %1\$som_collectivite
                    ON direction.om_collectivite = om_collectivite.om_collectivite
            WHERE
                ((instructeur.om_validite_debut IS NULL
                        AND (instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE))
                    OR (instructeur.om_validite_debut <= CURRENT_DATE
                        AND (instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE)))
                %2\$s
                <instructeur_qualite>
            ORDER BY
                nom",
            DB_PREFIXE,
            $filter
        );
    }

    /**
     * Requête de récupération de la liste des instructeurs avec leur nom et leur identifiant.
     *
     * Selon le cas d'usage cette requête est adapté. Il y a 3 cas possible :
     * Cas 1 : l'option de filtre par division n'est pas active ou l'utilisateur n'a pas de division.
     *         => tous les instructeur de la collectivité de l'utilisateur ou de la collectivité de niveau
     *            2 sont récupérés par la requête
     * Cas 2 : l'option de filtre par division est active, l'utilisateur a une division et il n'appartiens
     *         pas à la collectivité de niveau 2
     *         => seuls les instructeur de la division de l'utilisateur sont récupérés par la requête.
     * Cas 3 : l'option de filtre par division est active, l'utilisateur a une division et il appartiens
     *         à la collectivité de niveau 2
     *         => les instructeur de la division de l'utilisateur ou étant associés à une collectivité de
     *             niveau sont récupérés.
     *            
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_by_di() {
        // Cas 1
        $filter ="AND (om_collectivite.niveau = '2' OR direction.om_collectivite = '<collectivite_di>')";
        $division = $_SESSION['division'];
        if ($this->f->is_option_enabled('option_filtre_instructeur_DI_par_division') && $division != '0') {
            // Cas 2
            $filter = sprintf(
                'AND division.division = %d',
                intval($division)
            );
            // Cas 3
            if ($_SESSION['niveau'] == '2') {
                $filter = sprintf(
                    "AND (om_collectivite.niveau = '1'
                        OR division.division = %d)",
                    intval($division)
                );
            }
        }

        return sprintf(
            "SELECT
                instructeur.instructeur,
                instructeur.nom
            FROM
                %1\$sinstructeur
                INNER JOIN %1\$sdivision
                    ON division.division = instructeur.division
                INNER JOIN %1\$sinstructeur_qualite
                    ON instructeur_qualite.instructeur_qualite = instructeur.instructeur_qualite
                LEFT JOIN %1\$sdirection
                    ON division.direction = direction.direction
                LEFT JOIN %1\$som_collectivite
                    ON direction.om_collectivite = om_collectivite.om_collectivite
            WHERE
                ((instructeur.om_validite_debut IS NULL
                        AND (instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE))
                    OR (instructeur.om_validite_debut <= CURRENT_DATE
                        AND (instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE)))
                %2\$s
                <instructeur_qualite>
            ORDER BY
                nom ASC",
            DB_PREFIXE,
            $filter
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2_div() {
        return "SELECT instructeur.instructeur, instructeur.nom||' ('||division.code||')' 
            FROM ".DB_PREFIXE."instructeur 
            INNER JOIN ".DB_PREFIXE."division ON division.division=instructeur.division
            INNER JOIN ".DB_PREFIXE."instructeur_qualite ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
            WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))
            AND instructeur_qualite.code = <instructeur_qualite>
            ORDER BY nom";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2_div_by_id() {
        return $this->get_var_sql_forminc__sql("instructeur_div_by_id");
    }

    /**
     * Requête de récupération de la liste des instructeurs avec leur nom et leur identifiant.
     *
     * Selon le cas d'usage cette requête est adapté. Il y a 3 cas possible :
     * Cas 1 : l'option de filtre par division n'est pas active ou l'utilisateur n'a pas de division.
     *         => tous les instructeur de la collectivité de l'utilisateur ou de la collectivité de niveau
     *            2 sont récupérés par la requête
     * Cas 2 : l'option de filtre par division est active, l'utilisateur a une division et il n'appartiens
     *         pas à la collectivité de niveau 2
     *         => seuls les instructeur de la division de l'utilisateur sont récupérés par la requête.
     * Cas 3 : l'option de filtre par division est active, l'utilisateur a une division et il appartiens
     *         à la collectivité de niveau 2
     *         => les instructeur de la division de l'utilisateur ou étant associés à une collectivité de
     *             niveau sont récupérés.
     *            
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2_div_by_di() {
        // Cas 1
        $filter ="AND (om_collectivite.niveau = '2' OR direction.om_collectivite = '<collectivite_di>')";
        $division = $_SESSION['division'];
        if ($this->f->is_option_enabled('option_filtre_instructeur_DI_par_division') && $division != '0') {
            // Cas 2
            $filter = sprintf(
                'AND division.division = %d',
                intval($division)
            );
            // Cas 3
            if ($_SESSION['niveau'] == '2') {
                $filter = sprintf(
                    "AND (om_collectivite.niveau = '1'
                        OR division.division = %d)",
                    intval($division)
                );
            }
        }

        return sprintf(
            "SELECT
                instructeur.instructeur,
                instructeur.nom||' ('||division.code||')'
            FROM
                %1\$sinstructeur
                INNER JOIN %1\$sdivision
                    ON division.division = instructeur.division
                INNER JOIN %1\$sinstructeur_qualite
                    ON instructeur_qualite.instructeur_qualite = instructeur.instructeur_qualite
                LEFT JOIN %1\$sdirection
                    ON division.direction = direction.direction
                LEFT JOIN %1\$som_collectivite
                    ON direction.om_collectivite = om_collectivite.om_collectivite
            WHERE
                ((instructeur.om_validite_debut IS NULL
                        AND (instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE))
                    OR (instructeur.om_validite_debut <= CURRENT_DATE
                        AND (instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE)))
                %2\$s
                AND instructeur_qualite.code = '<instructeur_qualite>'
            ORDER BY
                nom",
            DB_PREFIXE,
            $filter
        );
    }

    /**
     * Requête de récupération de la liste des instructeurs avec leur nom et leur identifiant.
     *
     * Selon le cas d'usage cette requête est adapté. Il y a 3 cas possible :
     * Cas 1 : l'option de filtre par division n'est pas active ou l'utilisateur n'a pas de division.
     *         => tous les instructeur de la collectivité de l'utilisateur ou de la collectivité de niveau
     *            2 sont récupérés par la requête
     * Cas 2 : l'option de filtre par division est active, l'utilisateur a une division et il n'appartiens
     *         pas à la collectivité de niveau 2
     *         => seuls les instructeur de la division de l'utilisateur sont récupérés par la requête.
     * Cas 3 : l'option de filtre par division est active, l'utilisateur a une division et il appartiens
     *         à la collectivité de niveau 2
     *         => les instructeur de la division de l'utilisateur ou étant associés à une collectivité de
     *             niveau sont récupérés.
     *            
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2_by_di() {
        // Cas 1
        $filter ="AND (om_collectivite.niveau = '2' OR direction.om_collectivite = '<collectivite_di>')";
        $division = $_SESSION['division'];
        if ($this->f->is_option_enabled('option_filtre_instructeur_DI_par_division') && $division != '0') {
            // Cas 2
            $filter = sprintf(
                'AND division.division = %d',
                intval($division)
            );
            // Cas 3
            if ($_SESSION['niveau'] == '2') {
                $filter = sprintf(
                    "AND (om_collectivite.niveau = '1'
                        OR division.division = %d)",
                    intval($division)
                );
            }
        }

        return sprintf(
            "SELECT
                instructeur.instructeur,
                instructeur.nom
            FROM
                %1\$sinstructeur
                INNER JOIN %1\$sdivision
                    ON division.division = instructeur.division
                INNER JOIN %1\$sinstructeur_qualite
                    ON instructeur_qualite.instructeur_qualite = instructeur.instructeur_qualite
                LEFT JOIN %1\$sdirection
                    ON division.direction = direction.direction
                LEFT JOIN %1\$som_collectivite
                    ON direction.om_collectivite = om_collectivite.om_collectivite
            WHERE
                ((instructeur.om_validite_debut IS NULL
                        AND (instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE))
                    OR (instructeur.om_validite_debut <= CURRENT_DATE
                        AND (instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE)))
                %2\$s
                AND instructeur_qualite.code = '<instructeur_qualite>'
            ORDER BY
                instructeur.nom ASC",
            DB_PREFIXE,
            $filter
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division_by_di() {
        return "SELECT division.division, division.libelle
            FROM ".DB_PREFIXE."division 
            LEFT JOIN ".DB_PREFIXE."direction
                ON division.direction = direction.direction
            LEFT JOIN ".DB_PREFIXE."om_collectivite
                ON direction.om_collectivite = om_collectivite.om_collectivite
            WHERE ((division.om_validite_debut IS NULL AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)) OR (division.om_validite_debut <= CURRENT_DATE AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE))) 
            AND (om_collectivite.niveau = '2' OR direction.om_collectivite = '<collectivite_di>')
            ORDER BY division.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commune() {
        return "
            SELECT
                commune.commune, commune.libelle AS libelle
            FROM
                ".DB_PREFIXE."commune
            WHERE (commune.om_validite_debut IS NULL OR commune.om_validite_debut <= CURRENT_DATE)
            AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE)
            ORDER BY commune.libelle ASC
        ";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return sprintf('
            SELECT dossier_instruction_type.dossier_instruction_type,
                CONCAT_WS(\' - \', dossier_autorisation_type_detaille.libelle, dossier_instruction_type.libelle)
                FROM %1$sdossier_instruction_type
                LEFT JOIN %1$sdossier_autorisation_type_detaille ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                WHERE dossier_instruction_type = <idx>
            ',
            DB_PREFIXE
        );
    }

    /**
     * VIEW - view_sitadel.
     * 
     * @return void
     */
    function view_sitadel() {
        // Affichage du formulaire permettant le choix d'un interval de date
        // ainsi que le numéro de d'ordre qui est le numéro de la version de 
        // l'export
        if (empty($this->f->get_submitted_post_value())) {
            // Affichage du formulaire
            $this->affichageFormulaire();
        }
        else {
            // Initialisation des variables pour les messages de fin de traitement
            $correct=true;
            // Initialisation de la chaîne contenant le message d'erreur
            $erreur = "";
            //
            $message_valid = '';
            $message_info = '';

            // Initialisation des dates de début et de fin
            $datedebut ='';
            $datefin='';

            // Traitement des erreurs
            if ($this->f->get_submitted_post_value("datedebut") == "") {
                $correct=false;
            } else {
                $datedebut = substr($this->f->get_submitted_post_value("datedebut"),6,4).
                            "-".substr($this->f->get_submitted_post_value("datedebut"),3,2)."-".
                            substr($this->f->get_submitted_post_value("datedebut"),0,2);
            }
            if ($this->f->get_submitted_post_value("datefin") == "") {
                $correct=false;
            } else {
                $datefin = substr($this->f->get_submitted_post_value("datefin"),6,4).
                            "-".substr($this->f->get_submitted_post_value("datefin"),3,2)."-".
                            substr($this->f->get_submitted_post_value("datefin"),0,2);
            }
            $numero = $this->f->get_submitted_post_value("numero");
            
            if ($correct === true){
                // Vérifie la collectivité de l'utilisateur et si c'est un utilisateur
                // mono les résultats de l'exports concerneront uniquement sa collectivité
                $filtreCollectivite = '';
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $filtreCollectivite = sprintf(
                        'AND dossier_autorisation.om_collectivite = %d',
                        intval($_SESSION['collectivite'])
                    );
                }
                // Requête permettant de lister tous les dossiers de l'export
                $sql = sprintf(
                    "SELECT
                        dossier.dossier,
                        dossier.om_collectivite as collectivite,
                        dossier.dossier_autorisation,
                        dossier_instruction_type.mouvement_sitadel,
                        dossier_instruction_type.code as dossier_instruction_type_code,
                        dossier.date_depot,
                        dossier.date_decision,
                        dossier.date_chantier,
                        dossier.date_achevement,
                        dossier.terrain_references_cadastrales as dossier_terrain_references_cadastrales,
                        dossier.geoloc_latitude as dossier_geoloc_latitude,
                        dossier.geoloc_longitude as dossier_geoloc_longitude,
                        dossier.geoloc_rayon as dossier_geoloc_rayon,
                        dossier.terrain_adresse_voie_numero as dossier_terrain_adresse_voie_numero,
                        dossier.terrain_adresse_voie as dossier_terrain_adresse_voie,
                        dossier.terrain_adresse_lieu_dit as dossier_terrain_adresse_lieu_dit,
                        dossier.terrain_adresse_localite as dossier_terrain_adresse_localite,
                        dossier.terrain_adresse_code_postal as dossier_terrain_adresse_code_postal,
                        dossier.terrain_adresse_bp as dossier_terrain_adresse_bp,
                        dossier.terrain_adresse_cedex as dossier_terrain_adresse_cedex,
                        dossier_autorisation_type.code,
                        dossier.date_limite,
                        dossier.date_limite_incompletude,
                        dossier.date_notification_delai,
                        dossier.terrain_superficie as dossier_terrain_superficie,
                        dossier.terrain_superficie_calculee as dossier_terrain_superficie_calculee,
                        dossier.date_modification,
                        dossier.hash_sitadel,

                        arrondissement.code_impots as code_impots,

                        autorite_competente.autorite_competente_sitadel,
                        pp.type_demandeur,
                        pp.qualite,
                        civilite_pp.libelle as civilite_pp,
                        pp.particulier_nom as pp_particulier_nom,
                        pp.particulier_prenom as pp_particulier_prenom,
                        pp.personne_morale_denomination as pp_personne_morale_denomination,
                        pp.personne_morale_raison_sociale as pp_personne_morale_raison_sociale,
                        pp.personne_morale_siret as pp_personne_morale_siret,
                        pp.personne_morale_categorie_juridique as pp_personne_morale_categorie_juridique,
                        civilite_pm.libelle as civilite_pm_libelle,
                        pp.personne_morale_nom as pp_personne_morale_nom,
                        pp.personne_morale_prenom as pp_personne_morale_prenom,

                        pp.numero as pp_numero,
                        pp.voie as pp_voie,
                        pp.complement as pp_complement,
                        pp.lieu_dit as pp_lieu_dit,
                        pp.localite as pp_localite,
                        pp.code_postal as pp_code_postal,
                        pp.bp as pp_bp,
                        pp.cedex as pp_cedex,
                        pp.pays as pp_pays,
                        pp.division_territoriale as pp_division_territoriale,

                        pp.telephone_fixe as pp_telephone_fixe,
                        pp.courriel as pp_courriel,

                        donnees_techniques.co_archi_recours,
                        donnees_techniques.am_terr_surf,
                        donnees_techniques.am_lotiss,
                        donnees_techniques.terr_juri_zac,
                        donnees_techniques.terr_juri_afu,
                        donnees_techniques.co_projet_desc,
                        donnees_techniques.am_projet_desc,
                        donnees_techniques.dm_projet_desc,
                        donnees_techniques.co_cstr_nouv,
                        donnees_techniques.co_cstr_exist,
                        donnees_techniques.co_modif_aspect,
                        donnees_techniques.co_modif_struct,
                        donnees_techniques.co_cloture,
                        donnees_techniques.co_trx_exten,
                        donnees_techniques.co_trx_surelev,
                        donnees_techniques.co_trx_nivsup,
                        donnees_techniques.co_trx_amgt,
                        donnees_techniques.co_anx_pisc,
                        donnees_techniques.co_anx_gara,
                        donnees_techniques.co_anx_veran,
                        donnees_techniques.co_anx_abri,
                        donnees_techniques.co_anx_autr,
                        donnees_techniques.co_bat_niv_nb,

                        -- Tableau des destinations
                        donnees_techniques.su_avt_shon1,
                        donnees_techniques.su_avt_shon2,
                        donnees_techniques.su_avt_shon3,
                        donnees_techniques.su_avt_shon4,
                        donnees_techniques.su_avt_shon5,
                        donnees_techniques.su_avt_shon6,
                        donnees_techniques.su_avt_shon7,
                        donnees_techniques.su_avt_shon8,
                        donnees_techniques.su_avt_shon9,
                        donnees_techniques.su_demo_shon1,
                        donnees_techniques.su_demo_shon2,
                        donnees_techniques.su_demo_shon3,
                        donnees_techniques.su_demo_shon4,
                        donnees_techniques.su_demo_shon5,
                        donnees_techniques.su_demo_shon6,
                        donnees_techniques.su_demo_shon7,
                        donnees_techniques.su_demo_shon8,
                        donnees_techniques.su_demo_shon9,
                        donnees_techniques.su_chge_shon1,
                        donnees_techniques.su_chge_shon2,
                        donnees_techniques.su_chge_shon3,
                        donnees_techniques.su_chge_shon4,
                        donnees_techniques.su_chge_shon5,
                        donnees_techniques.su_chge_shon6,
                        donnees_techniques.su_chge_shon7,
                        donnees_techniques.su_chge_shon8,
                        donnees_techniques.su_chge_shon9,
                        donnees_techniques.su_sup_shon1,
                        donnees_techniques.su_sup_shon2,
                        donnees_techniques.su_sup_shon3,
                        donnees_techniques.su_sup_shon4,
                        donnees_techniques.su_sup_shon5,
                        donnees_techniques.su_sup_shon6,
                        donnees_techniques.su_sup_shon7,
                        donnees_techniques.su_sup_shon8,
                        donnees_techniques.su_sup_shon9,
                        donnees_techniques.su_cstr_shon1,
                        donnees_techniques.su_cstr_shon2,
                        donnees_techniques.su_cstr_shon3,
                        donnees_techniques.su_cstr_shon4,
                        donnees_techniques.su_cstr_shon5,
                        donnees_techniques.su_cstr_shon6,
                        donnees_techniques.su_cstr_shon7,
                        donnees_techniques.su_cstr_shon8,
                        donnees_techniques.su_cstr_shon9,
                        donnees_techniques.su_tot_shon1,
                        donnees_techniques.su_tot_shon2,
                        donnees_techniques.su_tot_shon3,
                        donnees_techniques.su_tot_shon4,
                        donnees_techniques.su_tot_shon5,
                        donnees_techniques.su_tot_shon6,
                        donnees_techniques.su_tot_shon7,
                        donnees_techniques.su_tot_shon8,
                        donnees_techniques.su_tot_shon9,
                        -- XXX valeurs obsolètes mais utilisées dans les conditions
                        -- pour afficher les messages d'incohérence
                        donnees_techniques.su_trsf_shon1,
                        donnees_techniques.su_trsf_shon2,
                        donnees_techniques.su_trsf_shon3,
                        donnees_techniques.su_trsf_shon4,
                        donnees_techniques.su_trsf_shon5,
                        donnees_techniques.su_trsf_shon6,
                        donnees_techniques.su_trsf_shon7,
                        donnees_techniques.su_trsf_shon8,
                        donnees_techniques.su_trsf_shon9,

                        -- Tableau des sous-destinations
                        donnees_techniques.su2_avt_shon1,
                        donnees_techniques.su2_avt_shon2,
                        donnees_techniques.su2_avt_shon3,
                        donnees_techniques.su2_avt_shon4,
                        donnees_techniques.su2_avt_shon5,
                        donnees_techniques.su2_avt_shon6,
                        donnees_techniques.su2_avt_shon7,
                        donnees_techniques.su2_avt_shon8,
                        donnees_techniques.su2_avt_shon9,
                        donnees_techniques.su2_avt_shon10,
                        donnees_techniques.su2_avt_shon11,
                        donnees_techniques.su2_avt_shon12,
                        donnees_techniques.su2_avt_shon13,
                        donnees_techniques.su2_avt_shon14,
                        donnees_techniques.su2_avt_shon15,
                        donnees_techniques.su2_avt_shon16,
                        donnees_techniques.su2_avt_shon17,
                        donnees_techniques.su2_avt_shon18,
                        donnees_techniques.su2_avt_shon19,
                        donnees_techniques.su2_avt_shon20,
                        donnees_techniques.su2_avt_shon21,
                        donnees_techniques.su2_avt_shon22,
                        donnees_techniques.su2_demo_shon1,
                        donnees_techniques.su2_demo_shon2,
                        donnees_techniques.su2_demo_shon3,
                        donnees_techniques.su2_demo_shon4,
                        donnees_techniques.su2_demo_shon5,
                        donnees_techniques.su2_demo_shon6,
                        donnees_techniques.su2_demo_shon7,
                        donnees_techniques.su2_demo_shon8,
                        donnees_techniques.su2_demo_shon9,
                        donnees_techniques.su2_demo_shon10,
                        donnees_techniques.su2_demo_shon11,
                        donnees_techniques.su2_demo_shon12,
                        donnees_techniques.su2_demo_shon13,
                        donnees_techniques.su2_demo_shon14,
                        donnees_techniques.su2_demo_shon15,
                        donnees_techniques.su2_demo_shon16,
                        donnees_techniques.su2_demo_shon17,
                        donnees_techniques.su2_demo_shon18,
                        donnees_techniques.su2_demo_shon19,
                        donnees_techniques.su2_demo_shon20,
                        donnees_techniques.su2_demo_shon21,
                        donnees_techniques.su2_demo_shon22,
                        donnees_techniques.su2_chge_shon1,
                        donnees_techniques.su2_chge_shon2,
                        donnees_techniques.su2_chge_shon3,
                        donnees_techniques.su2_chge_shon4,
                        donnees_techniques.su2_chge_shon5,
                        donnees_techniques.su2_chge_shon6,
                        donnees_techniques.su2_chge_shon7,
                        donnees_techniques.su2_chge_shon8,
                        donnees_techniques.su2_chge_shon9,
                        donnees_techniques.su2_chge_shon10,
                        donnees_techniques.su2_chge_shon11,
                        donnees_techniques.su2_chge_shon12,
                        donnees_techniques.su2_chge_shon13,
                        donnees_techniques.su2_chge_shon14,
                        donnees_techniques.su2_chge_shon15,
                        donnees_techniques.su2_chge_shon16,
                        donnees_techniques.su2_chge_shon17,
                        donnees_techniques.su2_chge_shon18,
                        donnees_techniques.su2_chge_shon19,
                        donnees_techniques.su2_chge_shon20,
                        donnees_techniques.su2_chge_shon21,
                        donnees_techniques.su2_chge_shon22,
                        donnees_techniques.su2_sup_shon1,
                        donnees_techniques.su2_sup_shon2,
                        donnees_techniques.su2_sup_shon3,
                        donnees_techniques.su2_sup_shon4,
                        donnees_techniques.su2_sup_shon5,
                        donnees_techniques.su2_sup_shon6,
                        donnees_techniques.su2_sup_shon7,
                        donnees_techniques.su2_sup_shon8,
                        donnees_techniques.su2_sup_shon9,
                        donnees_techniques.su2_sup_shon10,
                        donnees_techniques.su2_sup_shon11,
                        donnees_techniques.su2_sup_shon12,
                        donnees_techniques.su2_sup_shon13,
                        donnees_techniques.su2_sup_shon14,
                        donnees_techniques.su2_sup_shon15,
                        donnees_techniques.su2_sup_shon16,
                        donnees_techniques.su2_sup_shon17,
                        donnees_techniques.su2_sup_shon18,
                        donnees_techniques.su2_sup_shon19,
                        donnees_techniques.su2_sup_shon20,
                        donnees_techniques.su2_sup_shon21,
                        donnees_techniques.su2_sup_shon22,
                        donnees_techniques.su2_cstr_shon1,
                        donnees_techniques.su2_cstr_shon2,
                        donnees_techniques.su2_cstr_shon3,
                        donnees_techniques.su2_cstr_shon4,
                        donnees_techniques.su2_cstr_shon5,
                        donnees_techniques.su2_cstr_shon6,
                        donnees_techniques.su2_cstr_shon7,
                        donnees_techniques.su2_cstr_shon8,
                        donnees_techniques.su2_cstr_shon9,
                        donnees_techniques.su2_cstr_shon10,
                        donnees_techniques.su2_cstr_shon11,
                        donnees_techniques.su2_cstr_shon12,
                        donnees_techniques.su2_cstr_shon13,
                        donnees_techniques.su2_cstr_shon14,
                        donnees_techniques.su2_cstr_shon15,
                        donnees_techniques.su2_cstr_shon16,
                        donnees_techniques.su2_cstr_shon17,
                        donnees_techniques.su2_cstr_shon18,
                        donnees_techniques.su2_cstr_shon19,
                        donnees_techniques.su2_cstr_shon20,
                        donnees_techniques.su2_cstr_shon21,
                        donnees_techniques.su2_cstr_shon22,
                        donnees_techniques.su2_tot_shon1,
                        donnees_techniques.su2_tot_shon2,
                        donnees_techniques.su2_tot_shon3,
                        donnees_techniques.su2_tot_shon4,
                        donnees_techniques.su2_tot_shon5,
                        donnees_techniques.su2_tot_shon6,
                        donnees_techniques.su2_tot_shon7,
                        donnees_techniques.su2_tot_shon8,
                        donnees_techniques.su2_tot_shon9,
                        donnees_techniques.su2_tot_shon10,
                        donnees_techniques.su2_tot_shon11,
                        donnees_techniques.su2_tot_shon12,
                        donnees_techniques.su2_tot_shon13,
                        donnees_techniques.su2_tot_shon14,
                        donnees_techniques.su2_tot_shon15,
                        donnees_techniques.su2_tot_shon16,
                        donnees_techniques.su2_tot_shon17,
                        donnees_techniques.su2_tot_shon18,
                        donnees_techniques.su2_tot_shon19,
                        donnees_techniques.su2_tot_shon20,
                        donnees_techniques.su2_tot_shon21,
                        donnees_techniques.su2_tot_shon22,

                        donnees_techniques.co_sp_transport,
                        donnees_techniques.co_sp_enseign,
                        donnees_techniques.co_sp_sante,
                        donnees_techniques.co_sp_act_soc,
                        donnees_techniques.co_sp_ouvr_spe,
                        donnees_techniques.co_sp_culture,
                        donnees_techniques.dm_tot_log_nb,
                        donnees_techniques.co_tot_ind_nb,
                        donnees_techniques.co_tot_coll_nb,
                        donnees_techniques.co_tot_log_nb,
                        donnees_techniques.co_resid_agees,
                        donnees_techniques.co_resid_etud,
                        donnees_techniques.co_resid_tourism,
                        donnees_techniques.co_resid_hot_soc,
                        donnees_techniques.co_resid_hand,
                        donnees_techniques.co_resid_autr,
                        donnees_techniques.co_resid_autr_desc,
                        donnees_techniques.co_uti_pers,
                        donnees_techniques.co_uti_princ,
                        donnees_techniques.co_uti_secon,
                        donnees_techniques.co_uti_vente,
                        donnees_techniques.co_uti_loc,
                        donnees_techniques.co_foyer_chamb_nb,
                        donnees_techniques.co_fin_lls_nb,
                        donnees_techniques.co_fin_aa_nb,
                        donnees_techniques.co_fin_ptz_nb,
                        donnees_techniques.co_fin_autr_nb,
                        donnees_techniques.co_mais_piece_nb,
                        donnees_techniques.co_log_1p_nb,
                        donnees_techniques.co_log_2p_nb,
                        donnees_techniques.co_log_3p_nb,
                        donnees_techniques.co_log_4p_nb,
                        donnees_techniques.co_log_5p_nb,
                        donnees_techniques.co_log_6p_nb,
                        donnees_techniques.mod_desc,

                        donnees_techniques.doc_date,
                        donnees_techniques.terr_div_surf_av_div,
                        donnees_techniques.doc_tot_trav,
                        donnees_techniques.doc_tranche_trav,
                        donnees_techniques.doc_tranche_trav_desc,
                        donnees_techniques.doc_surf,
                        donnees_techniques.doc_nb_log,
                        donnees_techniques.doc_nb_log_indiv,
                        donnees_techniques.doc_nb_log_coll,
                        donnees_techniques.doc_nb_log_lls,
                        donnees_techniques.doc_nb_log_aa,
                        donnees_techniques.doc_nb_log_ptz,
                        donnees_techniques.doc_nb_log_autre,
                        donnees_techniques.daact_date,
                        donnees_techniques.daact_date_chgmt_dest,
                        donnees_techniques.daact_tot_trav,
                        donnees_techniques.daact_tranche_trav,
                        donnees_techniques.daact_tranche_trav_desc,
                        donnees_techniques.daact_surf,
                        donnees_techniques.daact_nb_log,
                        donnees_techniques.daact_nb_log_indiv,
                        donnees_techniques.daact_nb_log_coll,
                        donnees_techniques.daact_nb_log_lls,
                        donnees_techniques.daact_nb_log_aa,
                        donnees_techniques.daact_nb_log_ptz,
                        donnees_techniques.daact_nb_log_autre,

                        dossier_autorisation.date_depot as date_depot_da,
                        dossier_autorisation.date_decision as date_decision_da,
                        dossier_autorisation.date_validite as date_validite_da,
                        dossier_autorisation.date_chantier as date_chantier_da,
                        dossier_autorisation.date_achevement as date_achevement_da,
                        avis_decision.typeavis as typeavis_da,
                        avis_decision.sitadel,
                        avis_decision.sitadel_motif,
                        avis_decision.typeavis,
                        etat.statut as statut_di

                    FROM
                        %1\$sdossier
                        INNER JOIN %1\$sdossier_instruction_type 
                            ON dossier.dossier_instruction_type =
                            dossier_instruction_type.dossier_instruction_type
                        INNER JOIN %1\$sdossier_autorisation_type_detaille
                            ON dossier_instruction_type.dossier_autorisation_type_detaille
                            =dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                        INNER JOIN %1\$sdossier_autorisation_type
                            ON dossier_autorisation_type.dossier_autorisation_type
                            =dossier_autorisation_type_detaille.dossier_autorisation_type
                        INNER JOIN %1\$sgroupe
                            ON dossier_autorisation_type.groupe = groupe.groupe
                            AND groupe.code != 'CTX'
                        INNER JOIN %1\$sdossier_autorisation
                            ON dossier_autorisation.dossier_autorisation
                            =dossier.dossier_autorisation
                        INNER JOIN %1\$sautorite_competente
                            ON autorite_competente.autorite_competente
                            =dossier.autorite_competente

                        LEFT JOIN %1\$sdonnees_techniques
                            ON donnees_techniques.dossier_instruction = dossier.dossier
                        LEFT JOIN %1\$savis_decision
                            ON avis_decision.avis_decision = dossier.avis_decision
                        LEFT JOIN %1\$slien_dossier_demandeur as ldd_pp 
                            ON ldd_pp.dossier = dossier.dossier
                        LEFT JOIN %1\$sdemandeur as pp 
                            ON ldd_pp.demandeur = pp.demandeur
                        LEFT JOIN %1\$scivilite as civilite_pp
                            ON civilite_pp.civilite = pp.particulier_civilite
                        LEFT JOIN %1\$scivilite as civilite_pm
                            ON civilite_pm.civilite = pp.personne_morale_civilite
                        LEFT JOIN %1\$setat
                            ON etat.etat = dossier.etat
                        LEFT JOIN %1\$sarrondissement 
                            ON dossier_autorisation.arrondissement=arrondissement.arrondissement
                        
                    WHERE
                        dossier_instruction_type.mouvement_sitadel IS NOT NULL
                        AND ldd_pp.petitionnaire_principal is TRUE
                        AND (dossier.date_modification >= '%2\$s'
                            AND dossier.date_modification <= '%3\$s')
                        %4\$s
                    ORDER
                        by dossier_instruction_type.mouvement_sitadel,
                        dossier.dossier",
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($datedebut),
                    $this->f->db->escapeSimple($datefin),
                    $filtreCollectivite
                );
                //Exécution de la requête
                $query = $this->f->get_all_results_from_db_query(
                    $sql,
                    array(
                        'origin' => __METHOD__
                ));
                $export="";
                foreach ($query['result'] as $row) {
                    // initialisation de la classe permettant la mise en forme de chaque ligne de l'export
                    require_once "../obj/export_sitadel.class.php";
                    $export_sitadel = new export_sitadel($row['dossier'], $this->f);
                    $export_sitadel->setRow($row);
                    //Ajout du fichier de variable
                    if(file_exists ("../sql/".OM_DB_PHPTYPE."/export_sitadel.inc.php")) {
                        include ("../sql/".OM_DB_PHPTYPE."/export_sitadel.inc.php");
                    }
                    //
                    $export_sitadel->setVal($val);
                    $departement = $export_sitadel->getDepartement($row["collectivite"]);
                    $commune = $export_sitadel->getCommune($row["collectivite"]);
                    $region = $this->f->getParameter("region");

                    // Initialisation des variables pour le tableau des
                    // surfaces en version 1
                    $prefix_su = 'su';
                    $count_su = 9;
                    // S'il faut utiliser le tableau des surfaces en
                    // version 2
                    if ($export_sitadel->get_tab_su_version() === 2) {
                        //
                        $prefix_su = 'su2';
                        $count_su = 20;
                    }

                    // Récupère la version du dossier d'instruction depuis son
                    // numéro
                    $version = 0;
                    $version = intval($this->get_di_numero_suffixe($row['dossier']));

                    // Mouvement de dépôt
                    $depot="";

                    // Tous les mouvements autres que transfert ont comme mouvement le code DEPOT
                    // les décisions devant êtres précédées par le dépôt correspondant,
                    // les dossiers avec date de décision comprise dans l'interval fourni sont
                    // réaffichés en tant que dépôts (mouvement DEPOT)
                    if (($row['mouvement_sitadel'] == 'DEPOT'||($row['mouvement_sitadel'] == 'MODIFICATIF' 
                        AND $row['statut_di']=='cloture' AND $row['typeavis']=='F'))) {
                        $depot.=$export_sitadel->entete("DEPOT",$departement,$commune, $version);
                        $depot.=$export_sitadel->etatcivil();
                        $depot.=$export_sitadel->adresse();
                        $depot.=$export_sitadel->delegataire();
                        $depot.=$export_sitadel->meltel($row['mouvement_sitadel']);
                        $depot.=$export_sitadel->adresse_terrain();
                        $depot.=$export_sitadel->parcelle();
                        // ===========================
                        // contrat maison individuelle
                        // ===========================
                        // sitadel : contrat|
                        // openads : non renseigne
                        $depot.= $export_sitadel->defaultValue('contrat')."|";
                        // ==========
                        // architecte
                        // ==========
                        // sitadel : architecte|
                        // openads : données techniques.co_archi_recours    
                        $depot.= ($row['co_archi_recours'] == "t")?"1|":"0|";
                        // =====================
                        // utilisation data cnil
                        // ======================
                        // sitadel : cnil
                        // openads : non renseigne
                        $depot.= $export_sitadel->defaultValue('cnil');
                        // fin d enregistrement depot
                        $depot.="\n";
                    }

                    // Seuls les dossier de type transfert ont comme mouvement le code TRANSFERT
                    $transfert ="";
                    if ($row['mouvement_sitadel']=='TRANSFERT') {
                        $transfert.=$export_sitadel->entete("TRANSFERT",$departement,$commune, $version);
                        $transfert.=$export_sitadel->etatcivil();
                        $transfert.=$export_sitadel->adresse();
                        $transfert.=$export_sitadel->meltel($row['mouvement_sitadel']);
                        $transfert.="\n";
                    }


                    // Une ligne de mouvement DECISION est insérée après chaque ligne
                    // de mouvement DEPOT
                    $decision="";
                    if ($row['mouvement_sitadel'] != 'TRANSFERT'
                        and $row['mouvement_sitadel'] != 'SUPPRESSION'
                        and $row['mouvement_sitadel'] == 'DEPOT') {

                        //Ajout de l'entête
                        $decision.=$export_sitadel->entete("DECISION",$departement,$commune, $version);

                        //Ajout du groupe 1
                        $decision.= $export_sitadel->decision_groupe1();
                        // Si la décision est favorable, on remplit le groupe 2
                        if ( $row['sitadel'] == 2 || $row['sitadel'] == 4 || $row['sitadel'] == 5
                            || $row['sitadel'] === '' || $row['sitadel'] === 0){
                            //
                            $decision.= $export_sitadel->amenagement_terrain();
                            //Nature du projet
                            $natproj = 2;
                            $natprojlib= array(
                                1=>_("Nouvelle construction"),
                                2=>_("Travaux sur construction existante"),
                                3=>_("Nouvelle construction et travaux sur construction"),
                            );
                            if ( isset($row['co_cstr_nouv']) && isset($row['co_cstr_exist']) &&
                                $row['co_cstr_nouv'] == 't' && 
                                $row['co_cstr_exist'] == 't' ){
                                $natproj = 3;
                            } 
                            //Nouvelle construction
                            elseif ( isset($row['co_cstr_nouv']) && $row['co_cstr_nouv'] == 't' ) {
                                $natproj = 1;
                            }
                            //
                            $su_avt_shon = $export_sitadel->shon("avt");
                            //Si la SHON existante avant travaux est supérieur à la SHON 
                            //démolie alors la variable natproj est égale à 2
                            $shonExistante = 0;
                            $shonDemolie = 0;
                            // Pour chaque ligne du tableau
                            for ($i = 1; $i <= $count_su; $i++) {
                                //
                                $shonExistante += floor(floatval($row[$prefix_su.'_avt_shon'.$i]));
                                $shonDemolie += floor(floatval($row[$prefix_su.'_demo_shon'.$i]));
                            }
                            //Si la SHON existante avant travaux et la SHON démolie sont 
                            //égales alors la variable natproj est égale à 1
                            if ( $shonExistante == 0 && $shonDemolie == 0 && $natproj != 1 && 
                                    $row['code'] != 'DP' && $row['code'] != 'PA') {
                                $erreur .= _("Dossier ").$row['dossier']." \"".$natprojlib[$natproj]."\" "._("La SHON existante avant travaux et la SHON demolie sont nulles alors cela devrait être une nouvelle construction.")."\n";
                            } elseif ( $shonExistante > $shonDemolie && $natproj != 2 ){
                                $erreur .= _("Dossier ").$row['dossier']." \"".$natprojlib[$natproj]."\" "._("La SHON existante avant travaux ne doit pas être supérieure à la SHON démolie.")."\n";
                            }
                            $decision .= $su_avt_shon;

                            $su_demo_shon = $export_sitadel->shon("demo");
                            //La SHON démolie s'accompagne obligatoirement de la shon 
                            //existante avant travaux
                            if ( $shonDemolie != 0 && $shonExistante == 0 ){
                                $erreur .= _("Dossier ").$row['dossier']." "._("La SHON demolie s'accompagne obligatoirement de la SHON existante avant travaux.")."\n";
                            }
                            $decision .= $su_demo_shon;
                            //
                            $su_sup_shon = $export_sitadel->shon("sup");
                            $su_chge_shon = $export_sitadel->shon("chge");
                            if ( strcasecmp($su_sup_shon, $su_chge_shon) != 0){
                                //
                                $erreur .= _("Dossier ").$row['dossier']." "._("Les SHON globales supprimées par changement de destination ou de sous-destination et créées par le même changement doivent être égales.")."\n";
                            }
                            $decision .= $su_sup_shon;
                            $decision .= $su_chge_shon;
                            $decision .= $export_sitadel->shon("cstr");
                            $decision .= "0|0|0|0|0|0|0|0|0|";
                            // Les SHON créées par changement de destination ou
                            // de sous-destination s'accompagnent obligatoirement
                            // de SHON existante avant travaux non nulle
                            if (preg_match("/[0|]{7}/", $su_chge_shon) &&
                                preg_match("/[0|]{7}/", $su_avt_shon)){

                                $erreur .= _("Dossier ").$row['dossier']." "._("Les SHON créées par changement de destination ou de sous-destination s'accompagnent obligatoirement de SHON existante avant travaux non nulle.")."\n";
                            }
                            // Un nombre de logements démolis strictement positif doit
                            // s'accompagner obligatoirement de SHON démolie.
                            if($row['dm_tot_log_nb'] > 0) {
                                if($export_sitadel->get_shon_val('demo', 1) <= 0) {
                                    //
                                    $erreur .= _("Dossier ").$row['dossier']." "._("Un nombre de logements demolis strictement positif doit s'accompagner obligatoirement de SHON demolie.")."\n";
                                }
                            }
                            // Un nombre de logements créés strictement positif doit
                            // s'accompagner obligatoirement de SHON créée ou de SHON
                            // créée par changement de destination ou de sous-destination 
                            // ayant pour destination l'habitation.
                            if($row['co_tot_log_nb'] > 0 AND ($export_sitadel->get_shon_val('cstr', 1) <= 0 OR $export_sitadel->get_shon_val('chge', 1) <=0)) {
                                //
                                $erreur .= _("Dossier ").$row['dossier']." "._("Un nombre de logements créés strictement positif doit s'accompagner obligatoirement de SHON créée ou de SHON créée par changement de destination ou de sous-destination ayant pour destination l'habitation.")."\n";
                            }

                            // La SHON créée ou issue de la transformation 
                            // suffixée par 9 (intérêt collectif ou service public) doit
                            // obligatoirement s'accompagner de la décomposition
                            // en sous modalité renseignée par la variable cpublic et réciproquement.

                            // Test si une valeur est true
                            $cpublic = FALSE;
                            if (isset($row['co_sp_transport']) && $row['co_sp_transport'] == 't') {
                                $cpublic = TRUE;
                            }                    
                            if (isset($row['co_sp_enseign']) && $row['co_sp_enseign'] == 't') {
                                $cpublic = TRUE;
                            }
                            if (isset($row['co_sp_sante']) && $row['co_sp_sante'] == 't') {
                                $cpublic = TRUE;
                            }
                            if (isset($row['co_sp_act_soc']) && $row['co_sp_act_soc'] == 't') {
                                $cpublic = TRUE;
                            }
                            if (isset($row['co_sp_ouvr_spe']) && $row['co_sp_ouvr_spe'] == 't') {
                                $cpublic = TRUE;
                            }
                            if (isset($row['co_sp_culture']) && $row['co_sp_culture'] == 't') {
                                $cpublic = TRUE;
                            }
                            //
                            if($cpublic !== TRUE AND ($export_sitadel->get_shon_val('cstr', 9) > 0 OR $export_sitadel->get_shon_val('chge', 9) > 0)) {
                                $erreur .= _("Dossier ").$row['dossier']." "._("La SHON créée ou créée par changement de destination ou de sous-destination concernant le service public ou l'interet collectif doit obligatoirement s'accompagner du choix de destination des constructions.")."\n";
                            }

                            // La destination principale du logement mise à résidence
                            // principale ou résidence secondaire doit obligatoirement
                            // s'accompagner d'un mode d'utilisation à occupation personnelle
                            if($row['co_uti_princ'] == 't' OR $row['co_uti_secon'] == 't') {
                                if($row['co_uti_pers'] != 't') {

                                    $erreur .= _("Dossier ").$row['dossier']." "._("La destination principale du logement mise a residence principale ou residence secondaire doit obligatoirement s'accompagner d'un mode d'utilisation a occupation personnelle.")."\n";
                                }
                            }

                            $decision.= $export_sitadel->destination($row['mouvement_sitadel']);

                            // Le nombre total de logements créés (variable nbtotlog)
                            // doit être égal à la somme des nombres de logements créés
                            // ventilés par type de financement
                            if(intval($row['co_tot_log_nb']) != (intval($row['co_fin_lls_nb']) + intval($row['co_fin_aa_nb']) +
                               intval($row['co_fin_ptz_nb']) + intval($row['co_fin_autr_nb']))) {

                                $erreur .= _("Dossier ").$row['dossier']." "._("Le nombre total de logements crees doit etre egal a la somme des nombres de logements crees ventiles par type de financement.")."\n";
                            }

                            $decision.= $export_sitadel->repartitionFinan();

                            // Le nombre total de logements créés (variable nbtotlog)
                            // doit être égal à la totalisation de la répartition des
                            // logements par nombre de pièces
                            if(intval($row['co_tot_log_nb']) != (intval($row['co_log_1p_nb']) + intval($row['co_log_2p_nb']) +
                               intval($row['co_log_3p_nb']) + intval($row['co_log_4p_nb']) + intval($row['co_log_5p_nb']) +
                               intval($row['co_log_6p_nb']))) {

                                $erreur .= _("Dossier ").$row['dossier']." "._("Le nombre total de logements crees doit etre egal a la totalisation de la repartition des logements par nombre de pieces.")."\n";
                            }

                            $decision.= $export_sitadel->repartitionNbPiece($row['mouvement_sitadel']);
                        }
                        else {
                            //
                            $decision.= str_repeat("|", 6);
                            if($row['code']=='DP'){
                                $decision .= "00000|";
                            }else{
                                $decision .= "|";
                            }
                            $decision .= "0000|00000|";
                            $decision.= str_repeat("|", 74);
                        }
                        $decision.="\n";
                    }

                    // modificatif
                    $modificatif='';
                    if($row['mouvement_sitadel'] == 'MODIFICATIF' AND $row['statut_di']=='cloture' AND
                        $row['typeavis']=='F') {
                        $modificatif.=$export_sitadel->entete("MODIFICATIF",$departement,$commune, $version);

                        $modificatif.= $export_sitadel->decision_groupe1();

                        if(isset($row['date_decision']) or $row['date_decision']==""){
                            // avis_sitadel et avis_sitadel_motif
                            // si la decision est favorable, envoi des informations statistiques
                            if($row["sitadel"] == 2  or $row["sitadel"] == 4
                                   or $row["sitadel"] == 5){
                                // si accordé : ajout du 2nd groupe d'informations
                                $modificatif .= $export_sitadel->adresse_terrain();    // adresse du terrain
                                $modificatif .= $export_sitadel->parcelle();    // 3 premières parcelles
                                $modificatif .= $export_sitadel->modificatif_terrain();    // Informations complémentaires

                                $modificatif.= $export_sitadel->shon("avt");
                                $modificatif.= $export_sitadel->shon("demo");
                                $modificatif.= $export_sitadel->shon("chge");
                                $modificatif.= $export_sitadel->shon("trsf");
                                $modificatif.= $export_sitadel->shon("cstr");

                                $modificatif.= "|||||||||";
                                $modificatif.= $export_sitadel->destination($row['mouvement_sitadel']);
                                $modificatif.= $export_sitadel->repartitionFinan();
                                $modificatif.= $export_sitadel->repartitionNbPiece($row['mouvement_sitadel']);
                           }
                           else {
                                $modificatif .= str_repeat("|", 90);
                            }
                        }
                        else {
                            $modificatif .= str_repeat("|", 90);
                        }

                        $modificatif.="\n";
                    }

                    // Mouvement suppression
                    $suppression = '';
                    if($row['mouvement_sitadel'] == 'SUPPRESSION') {
                        $suppression .= $export_sitadel->entete("SUPPRESSION",$departement,$commune, $version);
                        $suppression .= "\n";
                    }

                    // Règles sur le mouvement suivi
                    $suivi="";
                    if($row['mouvement_sitadel'] == 'SUIVI' and
                        ($row['date_chantier'] >= $datedebut and $row['date_chantier']<=$datefin) ||
                        ($row['date_achevement'] >= $datedebut and $row['date_achevement']<=$datefin)){
                        // Si le dossier est une DOC
                        if($row['dossier_instruction_type_code']=='DOC'){
                            // Une ouverture de chantier ne peut concerner qu'un permis autorisé
                            if($row['typeavis_da'] != 'F'&&$row['typeavis_da'] != '') {
                                $erreur .= _("Dossier ").$row['dossier']." "._("Une ouverture de chantier ne peut concerner qu'un permis autorise.")."\n";
                            }
                            // La date d'ouverture de chantier doit être supérieur à la date d'autorisation
                            if($row['doc_date'] > $row['date_decision_da']) {
                                $erreur .= _("Dossier ").$row['dossier']." "._("La date d'ouverture de chantier doit être superieur a la date d'autorisation.")."\n";
                            }
                            // Un achèvement de chantier ne peut concerner qu'un permis autorisé
                            if($row['typeavis_da'] != 'F'&&$row['typeavis_da'] != '') {
                                $erreur .= _("Dossier ").$row['dossier']." "._("Un achevement de chantier ne peut concerner qu'un permis autorise.")."\n";
                            }
                            if( $row['date_chantier_da'] == "" && $row['date_achevement']!="") {
                                $erreur .= _("Dossier ").$row['dossier']." "._("Un achevement de chantier ne peut concerner qu'un permis sur lequel un chantier a ete ouvert.")."\n";
                            }
                            // La date d'achevement de travaux doit être supérieur à la date d'ouverture des travaux
                            if($row['daact_date'] > $row['date_chantier_da']) {
                                $erreur .= _("Dossier ").$row['dossier']." "._("La date d'achevement de travaux doit etre superieur a la date d'ouverture des travaux.")."\n";
                            }
                            $suivi.=$export_sitadel->entete("SUIVI",$departement,$commune, $version);//8|
                            $suivi.=$export_sitadel->chantier($row);
                            //On récupère la DAACT si elle existe
                            $qres = $this->f->get_all_results_from_db_query(
                                sprintf(
                                    'SELECT
                                        donnees_techniques.daact_date,
                                        donnees_techniques.daact_date_chgmt_dest,
                                        donnees_techniques.daact_tot_trav,
                                        donnees_techniques.daact_tranche_trav,
                                        donnees_techniques.daact_tranche_trav_desc,
                                        donnees_techniques.daact_surf,
                                        donnees_techniques.daact_nb_log,
                                        donnees_techniques.daact_nb_log_indiv,
                                        donnees_techniques.daact_nb_log_coll,
                                        donnees_techniques.daact_nb_log_lls,
                                        donnees_techniques.daact_nb_log_aa,
                                        donnees_techniques.daact_nb_log_ptz,
                                        donnees_techniques.daact_nb_log_autre,
                                        etat.statut as statut_di
                                    FROM
                                        %1$sdossier 
                                        LEFT JOIN %1$sdonnees_techniques 
                                            ON dossier.dossier=donnees_techniques.dossier_instruction
                                        LEFT JOIN %1$setat
                                            ON dossier.etat = etat.etat
                                        LEFT JOIN %1$sdossier_instruction_type
                                            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                                    WHERE
                                        dossier.dossier_autorisation = \'%2$s\'
                                        AND dossier_instruction_type.code = \'DAACT\'
                                        AND mouvement_sitadel = \'SUIVI\'',
                                    DB_PREFIXE,
                                    $this->f->db->escapeSimple($row['dossier_autorisation'])
                                ),
                                array(
                                    'origin' => __METHOD__
                                )
                            );
                            $rowDAACT = array_shift($qres['result']);
                            $suivi .= $export_sitadel->achevement($rowDAACT);
                            $suivi .= "\n";
                        }
                        elseif($row['dossier_instruction_type_code']=='DAACT'){
                            //On vérifie qu'une DOC existe
                            $qres = $this->f->get_all_results_from_db_query(
                                sprintf(
                                    'SELECT
                                        dossier.dossier,
                                        dossier.date_chantier,
                                        donnees_techniques.doc_date,
                                        donnees_techniques.terr_div_surf_av_div,
                                        donnees_techniques.doc_tot_trav,
                                        donnees_techniques.doc_tranche_trav,
                                        donnees_techniques.doc_tranche_trav_desc,
                                        donnees_techniques.doc_surf,
                                        donnees_techniques.doc_nb_log,
                                        donnees_techniques.doc_nb_log_indiv,
                                        donnees_techniques.doc_nb_log_coll,
                                        donnees_techniques.doc_nb_log_lls,
                                        donnees_techniques.doc_nb_log_aa,
                                        donnees_techniques.doc_nb_log_ptz,
                                        donnees_techniques.doc_nb_log_autre
                                    FROM
                                        %1$sdossier
                                        LEFT JOIN %1$sdonnees_techniques
                                            ON dossier.dossier = donnees_techniques.dossier_instruction
                                        LEFT JOIN %1$sdossier_instruction_type
                                            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                                    WHERE
                                        dossier.dossier_autorisation = \'%2$s\'
                                        AND dossier_instruction_type.code = \'DOC\'
                                        AND mouvement_sitadel = \'SUIVI\'',
                                    DB_PREFIXE,
                                    $this->f->db->escapeSimple($row['dossier_autorisation'])
                                ),
                                array(
                                    'origin' => __METHOD__
                                )
                            );
                            $rowDOC = array_shift($qres['result']);
                            if ((isset($rowDOC['dossier'])
                                && ($rowDOC['date_chantier'] < $datedebut
                                    || $rowDOC['date_chantier'] > $datefin))
                                || ! isset($rowDOC['dossier'])) {
                                //
                                $suivi.=$export_sitadel->entete("SUIVI",$departement,$commune, $version);//8|
                                $suivi.=$export_sitadel->chantier($rowDOC);
                                $suivi.=$export_sitadel->achevement($row);
                                $suivi.="\n";
                            }
                        }
                    }
                    // Ligne SITADEL généré
                    $line_sitadel = $depot.$decision.$transfert.$modificatif.$suivi.$suppression;
                    if ($line_sitadel !== '') {
                        // Hash la ligne SITADEL
                        $hash_sitadel = md5($line_sitadel);
                        // Si le hash de la ligne générée est différent du hash
                        // sauvegardé sur le dossier
                        if ($row['hash_sitadel'] !== $hash_sitadel) {
                            // Met la ligne dans l'export
                            $export .= $line_sitadel;
                            // Met à jour le hash SITADEL du dossier
                            $inst_di = $this->get_inst_dossier($row['dossier']);
                            $inst_di->update_hash_sitadel($hash_sitadel);
                        } else {
                            // Supprime les erreurs liées à la ligne qui ne sera
                            // pas exportée
                            $erreur = '';
                        }
                    }
                } // fin while  

                /**
                 *
                 */
                //
                if (DBCHARSET == 'UTF8') {
                    $export = utf8_decode($export);
                }

                /**
                 * En-tête de fichier.
                 *
                 * C'est la première ligne du fichier.
                 */
                // on éclate la chaîne export par ligne pour calculer le nombre 
                // d'enregistrements et la longueur maximale des enregistrements
                $export_by_line = explode("\n", $export);
                // longueur maximale des enregistrements
                // (Num)(6) longueur de l’enregistrement le plus long contenu dans le 
                // fichier (sans compter la fin d’enregistrement ou la fin de fichier)
                $longueur_maximale_des_enregistrements = 0;
                foreach ($export_by_line as $export_line) {
                    if ($longueur_maximale_des_enregistrements > strlen($export_line)) {
                        continue;
                    }
                    $longueur_maximale_des_enregistrements = strlen($export_line);
                }
                // nombre d'enregistrements
                // (Num)(6) nombre d’enregistrements présents dans le fichier en 
                // comptant l’en-tête du fichier
                // XXX Ne faut-il pas ajouter +1 pour la ligne d'en-tête ?
                $nombre_d_enregistrements = count($export_by_line);
                // code application 
                // (Alphanum)(7) = SITADEL
                $code_application = "SITADEL";
                // code département
                // (Alphanum)(3) département dans lequel se trouve le service instructeur
                // nomenclature : 001 à 095, 02A, 02B, 971...974
                $code_departement = $this->f->getParameter("departement");
                // service expéditeur
                // (Alphanum)(3) DDE ou commune (la plus grosse en cas d'EPCI) ou DGI
                // nomenclature : 'ADS', ‘DGI ou code commune INSEE
                $service_expediteur = $this->f->getParameter("commune");
                // service destinataire
                // (Alphanum)(2) DRE
                // nomenclature : code région INSEE (exemple : Ile-de-France=11)
                $service_destinataire = $this->f->getParameter("region");
                // code du fichier transmis
                // (AlphaNum)(12) AAMMjjdddccc
                // ddd = département du service instructeur
                // ccc = code du service expéditeur
                // AAMMjj = date
                // par exemple : 090531093ADS dans le cas de la transmission mensuelle 
                // des événements intervenus au mois de mai communiqués par la DDE de 
                // Seine-Saint-Denis.
                // XXX La date du jour correspond bien à la date demandée ?
                $code_du_fichier_transmis = sprintf(
                    "%s%s%s",
                    date('ymd'),
                    $code_departement,
                    $service_expediteur
                );
                // numéro d'ordre
                // (AlphaNum)(1) numéro d’ordre du fichier en cas de rectificatif
                // XXX Le formulaire propose jusqu'à la valeur 10 alors que la taille
                //     de la châine doit être (1) ?
                $numero_d_ordre = $this->f->get_submitted_post_value("numero");
                // date de création
                // (Alphanum)(6) AAMMjj date de création du fichier transmis
                $date_de_creation = date('ymd');
                // nom de l'applicatif expéditeur
                // (Alphanum)(20) Exemple : GESTIO
                $nom_de_l_applicatif_expediteur = "openADS";
                // version de l'applicatif expéditeur
                // (Alphanum)(8) Exemple : 2.05
                $version_de_l_applicatif_expediteur = substr($this->f->get_application_version(), 0, 8);
                // Consititution de la ligne d'en-tête.
                $entete = sprintf(
                    "%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s\n",
                    $code_application,
                    $code_departement,
                    $service_expediteur,
                    $service_destinataire,
                    $code_du_fichier_transmis,
                    $numero_d_ordre,
                    $longueur_maximale_des_enregistrements,
                    $date_de_creation,
                    $nombre_d_enregistrements,
                    $nom_de_l_applicatif_expediteur,
                    $version_de_l_applicatif_expediteur
                );

                /**
                 *
                 */
                //
                $export = $entete.$export;

                /**
                 * Écriture de l'export dans un fichier sur le disque et affichage du 
                 * lien de téléchargement.
                 */
                // Composition du nom du fichier
                $nom_fichier = "SITADEL".substr($this->f->get_submitted_post_value("datedebut"),3,2)."".substr($this->f->get_submitted_post_value("datedebut"),8,4).".txt";
                // Composition des métadonnées du fichier
                $metadata_fichier = array(
                    "filename" => $nom_fichier,
                    "size" => strlen($export),
                    "mimetype" => "text/csv",
                );
                // Écriture du fichier
                $id_fichier = $this->f->store_file(
                    $export,
                    $metadata_fichier,
                    "sitadel",
                    json_encode(array(
                        'date_debut' => $datedebut,
                        'date_fin' => $datefin,
                    ))
                );
                if ($id_fichier === false) {
                    $msg_error = __("Erreur lors du stockage/enregistrement du fichier SITADEL.").' '.__("Veuillez contacter votre administrateur.");
                    $this->f->displayMessage("error", $msg_error);
                    $this->f->addToLog(__METHOD__."(): ".$msg_error, DEBUG_MODE);
                    return;
                }
                //
                $message_valid = sprintf(
                    "%s<br/>%s",
                    sprintf(__("Le fichier %s a été généré."), $nom_fichier),
                    sprintf(
                        '<a href="%1$s&snippet=file&obj=storage&champ=uid&id=%2$s" id="%2$s" target="_blank"><span class="om-icon om-icon-16 om-icon-fix reqmo-16" title="%3$s"></span> %3$s</a>',
                        OM_ROUTE_FORM,
                        $id_fichier,
                        __("Télécharger le fichier SITADEL")
                    )
                );

                /**
                 * Écriture d'une éventuelle erreur durant l'export dans un fichier sur
                 * le disque et affichage du lien de téléchargement.
                 */
                //
                if ($erreur != "") {
                    // Composition du nom du fichier
                    $nom_fichier_erreur = "probleme_".$nom_fichier;
                    // Composition des métadonnées du fichier
                    $metadata_fichier_erreur = array(
                        "filename" => $nom_fichier_erreur,
                        "size" => strlen($erreur),
                        "mimetype" => "application/octet-stream",
                    );
                    // Écriture du fichier
                    $id_fichier_erreur = $this->f->store_file(
                        $erreur,
                        $metadata_fichier_erreur,
                        "sitadel",
                        json_encode(array(
                            'date_debut' => $datedebut,
                            'date_fin' => $datefin,
                        ))
                    );
                    if ($id_fichier_erreur === false) {
                        $msg_error = __("Erreur lors du stockage/enregistrement du fichier des incohérences SITADEL.").' '.__("Veuillez contacter votre administrateur.");
                        $this->f->displayMessage("error", $msg_error);
                        $this->f->addToLog(__METHOD__."(): ".$msg_error, DEBUG_MODE);
                        return;
                    }
                    //
                    $message_info .= sprintf(
                        "%s<br/>%s",
                        sprintf(__("Un ou plusieurs problèmes de cohérence ont été détectés durant l'export, celles-ci sont listées dans le fichiers %s."), $nom_fichier_erreur),
                        sprintf(
                            '<a href="%1$s&snippet=file&obj=storage&champ=uid&id=%2$s" id="%2$s" target="_blank"><span class="om-icon om-icon-16 om-icon-fix reqmo-16" title="%3$s"></span> %3$s</a>',
                            OM_ROUTE_FORM,
                            $id_fichier_erreur,
                            __("Télécharger le fichier d'incohérence SITADEL")
                        )
                    );
                }

                //
                $this->f->displayMessage("valid",
                    sprintf(
                        '%s%s%s',
                        $message_valid,
                        $message_info !== '' ? '<br/><br/>' : '',
                        $message_info
                    )
                );

                //
                if (DEBUG > 0) {
                    printf($export);
                }

            } else {// correct = false
                $this->f->displayMessage("error", __("Les champs dates sont obligatoires."));
            }
        }
    }


    function affichageFormulaire() {
        printf("<form method=\"POST\" name=f1>");
        //
        printf(
            "<div id=\"sitadel-form-fonctionnement\" class=\"sitadel-form-bloc\"><h3>%s</h3><p>%s</p></div>",
            __("Fonctionnement"),
            __("Les dossiers déjà exportés pour SITADEL n'apparaîtront plus dans les prochains exports. Ils seront à nouveau affichés lorsqu’au moins une des données utilisées par SITADEL sera différente du dernier export.")
        );
        //
        printf(
            "<div id=\"sitadel-form-export\" class=\"sitadel-form-bloc\"><h3>%s</h3>",
            __("Export")
        );
        //Description de la page
        $description = __("Saisissez la période pour laquelle vous souhaitez exporter les mouvements des dossiers au format SITADEL.");
        $this->f->displayDescription($description);
        //
        $input = "<input type=\"text\" name=\"%s\" id=\"%s\" value=\"%s\" size=\"15\" class=\"champFormulaire datepicker\" onchange=\"fdate(this)\" />";
        // champ date debut
        printf(" <section id=\"form-export-sitadel\">");
        printf(" <div class=\"field field-type-date\">
                    <div class=\"form-libelle\">
                    <label for=\"datedebut\" class=\"libelle-datedebut\" id=\"lib-datedebut\">
                    " ._("Date de début") . "
                    </label>
                    </div> 
        <div class=\"form-content\">");
        printf($input, "datedebut", "datedebut", '');
        printf(" </div></div>");
        // champ date fintex
        printf(" <div class=\"field field-type-date\">
        <div class=\"form-libelle\">
        <label for=\"datefin\" class=\"libelle-datefin\" id=\"lib-datefin\">
        " ._("Date de fin") . "
        </label>
        </div> 
        <div class=\"form-content\">");
        printf($input, "datefin", "datefin", '');
        printf(" </div></div>");
        // numero d'ordre d'envoi
        printf(" <div class=\"field field-type-select\">
        <div class=\"form-libelle\">
        <label for=\"numero\" class=\"libelle-numero\" id=\"lib-numero\">
        " ._("Numero d'ordre d'envoi") . "
        </label>
        </div> 
        <div class=\"form-content\">");
        printf("<select name=\"numero\">");
        for ($i = 1; $i < 11; $i++) {
            printf("<option value =\"%d\" ", $i);
            printf(">%d</option>", $i);
        }
        printf("</select>");
        printf(" </div></div>");
        printf("</section>");
        printf(
            "<br/><input id=\"sitadel-form-export-submit\" class=\"sitadel-form-bloc-button\" type=\"button\" value=\"%s\" onClick=\"sitadel_form_confirmation_action('form', this, '%s')\" data-href=\"%s&obj=sitadel&action=6&idx=0\" />",
            __("Exporter le fichier SITADEL"),
            addslashes(sprintf(
                "<b>%s</b><br/><br/>%s",
                __("Important à lire avant de confirmer le message de validation."),
                __("Les mouvements concernés par la période vont être marqués comme <i>exportés</i>. Ils ne figureront pas dans un nouvel export sur la même période.")
            )),
            OM_ROUTE_FORM
        );
        printf("</div>");

        // Affiche le tableau des fichiers sitadel stocké
        $link_tab_storage = OM_ROUTE_SOUSTAB.'&obj=storage&idxformulaire=0&retour=tab&retourformulaire=sitadel';
        $tab_storage = sprintf(
            '<div id="sousform-storage-sitadel" class="sitadel-form-bloc-tab"></div>
            <script type="text/javascript" >
                ajaxIt(\'storage-sitadel\', \'%1$s\');
            </script>',
            $link_tab_storage
        );
        printf(
            "<div id=\"sitadel-form-histo\" class=\"sitadel-form-bloc-end\"><h3>%s</h3>%s</div>",
            __("Historique des exports"),
            $tab_storage
        );

        printf("</form>");
     }
    
    /**
     * VIEW - view_document_numerise.
     *
     * Vue du tableau des pièces du dossier d'autorisation.
     *
     * Cette vue permet de gérer le contenu de l'onglet "Pièce(s)" sur un 
     * dossier d'autorisation. Cette vue spécifique est nécessaire car
     * l'ergonomie standard du framework ne prend pas en charge ce cas.
     * C'est ici la vue spécifique des pièces liées au dossier qui est
     * affichée directement au clic de l'onglet au lieu du soustab.
     * 
     * L'idée est donc de simuler l'ergonomie standard en créant un container 
     * et d'appeler la méthode javascript 'ajaxit' pour charger le contenu 
     * de la vue visualisation de l'objet lié.
     * 
     * @return void
     */
    function view_document_numerise() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Récupération des variables GET
        ($this->f->get_submitted_get_value('idxformulaire')!==null ? $idxformulaire = 
            $this->f->get_submitted_get_value('idxformulaire') : $idxformulaire = "");
        ($this->f->get_submitted_get_value('retourformulaire')!==null ? $retourformulaire = 
            $this->f->get_submitted_get_value('retourformulaire') : $retourformulaire = "");
        // Objet à charger
        $obj = "document_numerise";
        $type_aff_form = $this->get_type_affichage_formulaire();
        if ($type_aff_form === 'CTX RE' OR $type_aff_form === 'CTX IN') {
            $obj = "document_numerise_contexte_ctx";
        }
        // Construction de l'url de sousformulaire à appeler
        $url = OM_ROUTE_SOUSFORM."&obj=".$obj;
        $url .= "&idx=".$idxformulaire;
        $url .= "&action=4";
        $url .= "&retourformulaire=".$retourformulaire;
        $url .= "&idxformulaire=".$idxformulaire;
        $url .= "&retour=form";
        // Affichage du container permettant le reffraichissement du contenu
        // dans le cas des action-direct.
        printf('
            <div id="sousform-href" data-href="%s">
            </div>',
            $url
        );
        // Affichage du container permettant de charger le retour de la requête
        // ajax récupérant le sous formulaire.
        printf('
            <div id="sousform-%s">
            </div>
            <script>
            ajaxIt(\'%s\', \'%s\');
            </script>',
            $obj,
            $obj,
            $url
        );
    }


    /**
     * Traitement du numéro de version d'un dossier.
     * Renvoie le numéro de version.
     * 
     * Récupère le numéro de version du dossier d'instruction (DI) à l'aide du
     * numéro de dossier d'autorisation (DA).
     * Si un numéro de version a été récupéré incremente également le numéro
     * de version du DA dans la base de données.
     *
     * @param array tableau contenant les valeurs du formulaire
     * @return integer|null numero de version du dossier si il a pu être récupéré
     */
    protected function traitementNumeroVersion($val = array()) {
        // Récupération du numéro de version du dossier d'instruction
        $numeroVersion = $this->getNumeroVersion($val['dossier_autorisation']);
        // Mise à jour du numéro de version du DA
        // La numérotation du DI est unique et basée sur celle du DA qui débute à -1.
        // Ainsi la version du DI initial est à 0.
        if (is_numeric($numeroVersion) or $numeroVersion == -1){
            $this->incrementNumeroVersion($val['dossier_autorisation'], ++$numeroVersion);
        }
        return $numeroVersion;
    }

    /**
     * Traitement de la numérotation du dossier lors de la saisie manuelle du
     * numéro de dossier.
     * Renvoie un tableau contenant les valeurs nécessaires à la numérotation du
     * dossier.
     *
     * Récupère le numéro de dossier issus du formulaire. Construis le libellé et
     * l'identifiant du dossier à partir du numéro saisie.
     * 
     *
     * @param array tableau contenant les valeurs du formulaire.
     * @return array informations liées à la numérotation du dossier.
     */
    protected function traitementNumerotationDossierManuelle($val = array()) {
        // INitialisation des valeurs de la numérotation à partir des informations issues
        // du formulaire
        $num_doss_comp = $val['numero_dossier_complet'];
        $numerotation = array(
            $this->clePrimaire => $num_doss_comp,
            'dossier_libelle' => $num_doss_comp
        );
        // TODO : à commenter
        $num_urba = $this->f->numerotation_urbanisme($num_doss_comp);
        // TODO : à commenter
        if (empty($num_urba['di']) === false) {
            $dossier = sprintf("%s%s%s%s%s%s%s%s",
                $num_urba['di']['type'],
                $num_urba['di']['departement'],
                $num_urba['di']['commune'],
                $num_urba['di']['annee'],
                $num_urba['di']['division'],
                $num_urba['di']['numero'],
                isset($num_urba['di']['suffixe']) === true ? $num_urba['di']['suffixe'] : '',
                isset($num_urba['di']['num_suffixe']) === true ? str_pad($num_urba['di']['num_suffixe'], 2, '0', STR_PAD_LEFT) : ''
            );
            $dossierLibelle = sprintf("%s %s%s %s %s%s%s%s",
                $num_urba['di']['type'],
                $num_urba['di']['departement'],
                $num_urba['di']['commune'],
                $num_urba['di']['annee'],
                $num_urba['di']['division'],
                $num_urba['di']['numero'],
                isset($num_urba['di']['suffixe']) === true ? $num_urba['di']['suffixe'] : '',
                isset($num_urba['di']['num_suffixe']) === true ? str_pad($num_urba['di']['num_suffixe'], 2, '0', STR_PAD_LEFT) : ''
            );
            $numerotation = array(
                $this->clePrimaire => $dossier,
                'dossier_libelle' => $dossierLibelle,
                'numerotation_type' => $num_urba['di']['type'],
                'numerotation_dep' => $num_urba['di']['departement'],
                'numerotation_com' => $num_urba['di']['commune'],
                'numerotation_division' => $num_urba['di']['division'],
                'numerotation_num' => $num_urba['di']['numero'],
                'numerotation_suffixe' => isset($num_urba['di']['suffixe']) === true ? $num_urba['di']['suffixe'] : null,
                'numerotation_num_suffixe' => isset($num_urba['di']['num_suffixe']) === true ? $num_urba['di']['num_suffixe'] : null
            );
        }
        return $numerotation;
    }

    /**
     * Traitement automatique de la numérotation du dossier.
     * Renvoie un tableau contenant les valeurs nécessaires à la numérotation du
     * dossier.
     *
     * @param array tableau contenant les valeurs du formulaire.
     * @return array informations liées à la numérotation du dossier.
     */
    protected function traitementNumerotationDossierAuto($val = array()) {
        // GESTION DU SUFFIXE :
        // La version du suffixe est celle du type de DI : à ne pas confondre avec celle du DI lui même.
        // Exemple chronologique :
        // DI n° PC0130551600004 -> version 0
        // DI n° PC0130551600004M01 -> version 1
        // DI n° PC0130551600004PRO01 -> version 2 !!
        $code = null;
        $numeroVersionDossierInstructionType = null;
        $suffixe = "";
        // Si l'option suffixe de ce type de DI est activée
        if ( $this->getSuffixe($this->getDossierInstructionType()) === 't' ){
            // Récupération de la lettre associée au type de dossier d'instruction
            $code = $this->getCode($this->getDossierInstructionType());
            // Récupération du numéro de version en fonction du type de dossier d'instruction
            $numeroVersion = $this->getNumeroVersion($val['dossier_autorisation']);
            $numeroVersionDossierInstructionType = $this->getNumeroVersionDossierInstructionType(
                $val['dossier_autorisation'],
                $val['dossier_instruction_type'],
                $val['demande_type'],
                $numeroVersion
            );
            // Suffixe
            $suffixe = $code.$numeroVersionDossierInstructionType;
        }

        // Récupération du DA pour aller chercher le type, le département, la commune, la division et le numéro
        // nécessaire à la numérotation du dossier.
        $da = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => $val['dossier_autorisation'],
        ));

        return array(
            'dossier' => $val['dossier_autorisation'].$suffixe,
            'dossier_libelle' => $da->getVal('dossier_autorisation_libelle').$suffixe,
            'numerotation_type' => ! empty($da->getVal("numerotation_type")) ? $da->getVal("numerotation_type") : null,
            'numerotation_dep' => ! empty($da->getVal("numerotation_dep")) ? $da->getVal("numerotation_dep") : null,
            'numerotation_com' => ! empty($da->getVal("numerotation_com")) ? $da->getVal("numerotation_com") : null,
            'numerotation_division' => ! empty($da->getVal("numerotation_division")) ? $da->getVal("numerotation_division") : null,
            'numerotation_num' => ! empty($da->getVal("numerotation_num")) ? $da->getVal("numerotation_num") : null,
            'numerotation_suffixe' => $code,
            'numerotation_num_suffixe' => $numeroVersionDossierInstructionType
        );
    }

    /**
     * Traitement spécifique pour la numérotation du dossier.
     * Renvoie un tableau contenant les valeurs à mettre à jour pour la numérotation.
     * 
     * Le(s) traitement(s) effectué(s) dans cette méthode est(sont) :
     *  - Si l'option om_collectivite_entite est active gère la numérotation de l'entité
     *    du dossier.
     *
     * @param array tableau contenant les valeurs du formulaire.
     * @return array informations liées à la numérotation du dossier.
     */
    function traitementSpécifique($val = array()) {
        // TODO : commenter
        $numerotation = array();
        // Gestion du numéro entité du dossier (specifique au MC)
        $numerotation_entite = $this->f->get_collectivite_code_entite($val['om_collectivite']);
        if ($this->f->is_option_om_collectivite_entity_enabled($val['om_collectivite']) === true
            && $numerotation_entite !== null) {
            $numerotation_num_entite = $this->increment_num_entite($val['dossier_autorisation']);
            $numerotation_num_entite = str_pad($numerotation_num_entite, 2, "0", STR_PAD_LEFT);
            $numerotation = array(
                $this->clePrimaire => $val[$this->clePrimaire].$numerotation_entite.$numerotation_num_entite,
                'dossier_libelle' => $val['dossier_libelle']." ".$numerotation_entite.$numerotation_num_entite,
                'numerotation_entite' => $numerotation_entite,
                'numerotation_num_entite' => $numerotation_num_entite
            );
        }
        return $numerotation;
    }

    /**
     * Définition de la version et du suffixe du DI lors de sa création.
     *
     * @param array tableau contenant les valeurs du formulaire
     */
    function setValFAjout($val = array()) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // traitement lié à la récupération du numéro de version du dossier et stockage
        // de ce numéro de version
        $numeroVersion = $this->traitementNumeroVersion($val);
        $this->valF['version'] = $numeroVersion;

        // Il y a deux possibilité de numérotation :
        //  - la numérotation manuelle : le numéro de dossier est complétement saisis par l'utilisateur
        //  - la numérotation automatique : le numéro de dossier est construis à partir du paramétrage
        // Selon les cas on va donc gérer la numérotation différemment.
        // Dans tous les cas on va récupérer les valeurs lié à la numérotation sous le forme d'un tableau.
        $isSaisieManuelle = ! empty($val['numero_dossier_complet']);
        if ($isSaisieManuelle) {
            $valNumerotationDossier = $this->traitementNumerotationDossierManuelle($val);
        } else {
            $valNumerotationDossier = $this->traitementNumerotationDossierAuto($val);
        }
        // Traitements spécifiques nécessaires à la numérotation du dossier.
        // Pour pouvoir réaliser les traitements spécifique on a besoin des infos de
        // numérotation. On l'ajoute donc au tableau des valeur pour pouvoir y accéder.
        $val = array_merge($val, $valNumerotationDossier);
        $valNumerotationSpecifique = $this->traitementSpécifique($val);



        // Affectation automatique du dossier
        // Pour pouvoir réaliser l'affectation automatique on a besoin de la localisation.
        // On l'ajoute donc au tableau des valeur pour pouvoir y accéder
        // Récupération des références de localisation du dossier
        $valLocalisation = $this->localisation_dossier($val);
        $val = array_merge(
            $val,
            $valLocalisation
        );
        $valAffectation = $this->affectation_dossier($val);

        // Construis le tableau des valeurs mise à jour à partir des valeurs issues de
        // tous les traitements précédents
        $this->valF = array_merge(
            $this->valF,
            $valNumerotationDossier,
            $valNumerotationSpecifique,
            $valAffectation
        );
        
        $this->addToLog(__METHOD__."(): end", EXTRA_VERBOSE_MODE);
    }

    /**
     * Traitement permettant de récupérer la localisation du dossier à partir de
     * ses références cadastrales.
     *
     * Récupère un tableau contenant les informations suivantes :
     * array(
     *      'quartier' => quartier,
     *      'arrondissement' => arrondissement
     *      'section' => section
     * )
     *
     * @param array tableau des valeurs du dossier
     * @param array tableau contenant la localisation du dossier
     */
    protected function localisation_dossier($val) {
        $quartier = 0;
        $arrondissement = 0;
        $section = '';

        // Si la référence cadastrale n'est pas vide alors on récupère la
        // section, le quartier et l'arrondissement
        if ($val['terrain_references_cadastrales'] != '') {

            // Récupère toutes les parcelles du dossier et sélectionne la première
            $list_parcelles = $this->f->parseParcelles($this->valF['terrain_references_cadastrales'], $this->valF['om_collectivite']);
            if (count($list_parcelles) > 0) {
                $parcelle = $list_parcelles[0];

                // Récupère l'identifiant du quartier et de l'arrondissement
                $quartier_arrondissement = $this->get_quartier_arrondissement_by_code_impot($parcelle['quartier']);
                if ($quartier_arrondissement !== null
                    && is_array($quartier_arrondissement) === true
                    && isset($quartier_arrondissement['quartier']) === true
                    && isset($quartier_arrondissement['arrondissement']) === true) {
                    //
                    $quartier = $quartier_arrondissement['quartier'];
                    $arrondissement = $quartier_arrondissement['arrondissement'];
                }

                // On récupère la section
                $section = $parcelle['section'];
            }
        }

        return array(
            'quartier' => $quartier,
            'arrondissement' => $arrondissement,
            'section' => $section
        );
    }

    // Permet d'incrémenter le numéro de version de l'entité
    public function increment_num_entite($da) {
        if ($da === null || $da === '') {
            return false;
        }
        $last_entity_num = 0;
        //
        $inst_da = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => $da,
        ));
        $list_di = $inst_da->get_list_dossier_instruction();
        foreach ($list_di as $di) {
            $inst_di = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $di['dossier'],
            ));
            if (intval($inst_di->getVal('numerotation_num_entite')) > $last_entity_num) {
                $last_entity_num = intval($inst_di->getVal('numerotation_num_entite'));
            }
        }
        return ++$last_entity_num;
    }

    /*Récupère la valeur du suffixe d'un dossier_instruction_type*/
    function getSuffixe($idDIType){
        $dossierInstructionType = $this->f->get_inst__om_dbform(array(
            'obj' => 'dossier_instruction_type',
            'idx' => $idDIType
        ));
        return $dossierInstructionType->getVal('suffixe');
    }
    
    /*Récupère dans la table de paramètrage la lettre correspondant 
     * au dossier_instruction_type
     */
    function getCode($idDIType){
        $dossierInstructionType = $this->f->get_inst__om_dbform(array(
            'obj' => 'dossier_instruction_type',
            'idx' => $idDIType
        ));
        return $dossierInstructionType->getVal('code');
    }
    
    /**
     * Récupère le numéro de version d'un dossier_autorisation à l'aide d'une
     * requête sql.
     * 
     * En cas d'erreur sur la requête arrête l'execution et affiche un message
     * d'erreur.
     * 
     * @param string identifiant du dossier d'autorisation (DA)
     * @return integer numéro de version du DA
     */
    function getNumeroVersion($idDA){
        $dossierAutorisation = $this->f->get_inst__om_dbform(array(
            'obj' => 'dossier_autorisation',
            'idx' => $idDA
        ));
        return $dossierAutorisation->getVal('numero_version');
    }


    /**
     * Récupère le numéro de suffixe du dossier d'instruction.
     *
     * @return string
     */
    function get_di_numero_suffixe($dossier_instruction = null) {

        $ref_dossier = $this;
        if (! empty($dossier_instruction)) {
            if(empty($ref_dossier = $this->f->findObjectById('dossier', $dossier_instruction))) {
                $this->f->addToLog(__METHOD__."(): Dossier '$dossier_instruction' non trouvé", DEBUG_MODE);
                return false;
            }
        }
        else {
            $dossier_instruction = $ref_dossier->getVal($this->clePrimaire);
        }

        $dossier_suffixe = intval($ref_dossier->getVal('numerotation_num_suffixe'));

        // TODO si les tests se déroulent bien:
        //        - supprimer le code ci-dessous et la fonction 'numerotation_urbanisme' 
        //        - retourner le résultat de la ligne ci-dessus en tant que valeur de retour de la fonction

        $dossier_ref_id = $dossier_instruction;
        $collectivite_id = $ref_dossier->getVal('om_collectivite');

        // si l'option 'code_entité' est activée pour la collectivité
        if ($this->f->is_option_om_collectivite_entity_enabled($collectivite_id)) {

            // si le code entité n'est pas défini ou vide
            if ($this->f->get_collectivite_code_entite($collectivite_id) === null) {

                // affiche un message d'alerte
                $err_msg = sprintf(__("Paramètre '%s' manquant ou vide pour la collectivité '%s'"),
                                    'code_entite',
                                    $collectivite_id);
                $this->f->addToLog(__METHOD__."() : $err_msg", DEBUG_MODE);
            }
            // si le code entité est défini et non-vide
            else {

                // supprime le code entité du numéro de dossier
                $code_entite = $this->f->get_collectivite_code_entite($collectivite_id);
                $dossier_ref_id = preg_replace('/'.$code_entite.'[0-9]+$/', '', $dossier_ref_id);
            }
        }

        $num_urba = $this->f->numerotation_urbanisme($dossier_ref_id);

        // Si l'expression régulière retourne une erreur
        if ($num_urba == false) {
            // Message dans le log
            $this->f->addToLog(__METHOD__."(): ".__("Erreur lors de la récupération du numéro de suffixe du dossier d'instruction"), DEBUG_MODE);
            return false;
        }

        $suffixe = 0;

        // Retourne seulement la suffixe du dossier d'instruction.
        // Elle vaut 0 si le numéro du DI n'a pas de suffixe.
        if (isset($num_urba['di']['num_suffixe'])) {
            $suffixe = $num_urba['di']['num_suffixe'];
        }

        if ($dossier_suffixe != intval($suffixe)) {
            //throw new RuntimeException("Dossier '".$ref_dossier->getVal('dossier')."' suffixes differs ($dossier_suffixe != $suffixe)");
            $this->f->addToLog(__METHOD__."(): Dossier '".$ref_dossier->getVal('dossier')."' suffixes differs (new:$dossier_suffixe != old:$suffixe)", DEBUG_MODE);
        }

        return $suffixe;
    }
    
    /*Incrémente le numéro de version du dossier*/
    function incrementNumeroVersion($dossierAutorisation, $nouveauNumeroVersion) {
        
        $valF = array (
                    "numero_version" => $nouveauNumeroVersion
                );
        
        $res = $this->f->db->autoexecute(
            DB_PREFIXE."dossier_autorisation",
            $valF,
            DB_AUTOQUERY_UPDATE,
            "dossier_autorisation = '$dossierAutorisation'"
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."dossier_autorisation\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"dossier_autorisation = '".$dossierAutorisation."'\");",
            VERBOSE_MODE
        );
        $this->f->isDatabaseError($res);
    }

    /**
     * Retourne un numéro de version en fonction du type de dossier d'instruction
     * @param string $dossier_autorisation
     * @param integer $dossier_instruction_type
     * @return int
     */
    public function getNumeroVersionDossierInstructionType($dossier_autorisation, $dossier_instruction_type, $demande_type, $numero_version, $increment = true){

        $numeroVersionDossierInstructionType = $numero_version;

        // Récupère la nature de la demande
        $inst_demande_type = $this->f->get_inst__om_dbform(array(
            "obj" => "demande_type",
            "idx" => $demande_type
        ));
        $inst_demande_nature = $this->f->get_inst__om_dbform(array(
            "obj" => "demande_nature",
            "idx" => $inst_demande_type->getVal('demande_nature')
        ));

        // Si c'est un dossier d'instruction de type "Initial"
        if (strtolower($inst_demande_nature->getVal('code')) === 'nouv') {
            return 0;
        }
        //Si c'est un modificatif ou transfert on retourne un nombre correspondant au
        //nombre de dossier d'instruction de ce type, rattaché au dossier 
        //d'autorisation complété par des 0 à gauche si besoin. Format du retour 
        //attendu : 01 ou 02, etc. 
        else {
            //On récupère le nombre de dossier d'instruction de ce type rattaché au 
            //dossier d'autorisation
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT 
                        count(dossier) 
                    FROM 
                        %1$sdossier
                        LEFT JOIN %1$sdossier_autorisation
                            ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
                    WHERE
                        dossier_autorisation.dossier_autorisation = \'%2$s\'
                        AND dossier.dossier_instruction_type = \'%3$d\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($dossier_autorisation),
                    intval($dossier_instruction_type)
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true
                )
            );
            $numeroVersionDossierInstructionType =  $qres['result'];

            if ($qres["code"] !== "OK") { // PP
                $this->f->addToError("", $numeroVersionDossierInstructionType, $numeroVersionDossierInstructionType);
                return false;
            }
            
            // Requête SQL
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        substring(dossier, \'\d*$\')::int as last_num_dossier
                    FROM
                        %1$sdossier
                    WHERE
                        dossier_instruction_type = %2$s
                        AND dossier_autorisation = \'%3$s\'
                        AND version = (
                            SELECT
                                max(version) 
                            FROM
                                %1$sdossier 
                            WHERE
                                dossier_instruction_type = %2$s
                                AND dossier_autorisation = \'%3$s\' 
                            GROUP BY
                                dossier_instruction_type,
                                dossier_autorisation
                        )',
                    DB_PREFIXE,
                    intval($dossier_instruction_type),
                    $this->f->db->escapeSimple($dossier_autorisation)
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            $num_version_last_dossier = null;
            if ($qres['row_count'] > 0) {
                $row = array_shift($qres['result']);
                $num_version_last_dossier = $row['last_num_dossier'];
            }

            if (!empty($num_version_last_dossier)
                && $num_version_last_dossier >= $numeroVersionDossierInstructionType) {
                // Modifie le numéro suivant
                $numeroVersionDossierInstructionType = $num_version_last_dossier;
            }
            //
            if ($increment === true) {
                $numeroVersionDossierInstructionType = ++$numeroVersionDossierInstructionType;
            }
            //On compléte par des 0 à gauche
            $numeroVersionDossierInstructionType = str_pad($numeroVersionDossierInstructionType, 2, "0", STR_PAD_LEFT);
            
            return $numeroVersionDossierInstructionType;
        }
    }

    function setvalF($val = array()){

        if (! $this->f->is_option_dossier_commune_enabled()) {
            // ajoute une "fausse" clé 'commune' dans le tableau des données envoyées
            // car la fonction 'setValF()' dans 'gen/obj/demande.class.php'
            // déclenche une erreur 'Undefined index: commune' sinon
            $val['commune'] = null;
            // idem pour cette valeur qui est passée au dossier d'instruction
            $this->valF['commune'] = null;
        }

        // normalise les coordonnées géographiques
        foreach(array('latitude', 'longitude') as $key) {
            if (isset($val["geoloc_$key"]) && ! empty($val["geoloc_$key"])) {
                $m = array();
                if (preg_match(self::LAT_LON_REGEX, $val["geoloc_$key"], $m)) {
                    $val["geoloc_$key"] = sprintf('%d° %d.%d %1s', $m['deg'], $m['min'], $m['dec'], $m['dir']);
                }
            }
        }

        parent::setvalF($val);

        // Récupération des id demandeurs postés
        $this->getPostedValues();

        // enlever les valeurs a ne pas saisir -> recherche en trigger ajouter et modifier
        unset ($this->valF['geom']);
        unset ($this->valF['geom1']);
        // valeurs hiddenstatic (calcule)
        if($this->maj==1){
            // par defaut
            unset ($this->valF['etat']);
            unset ($this->valF['delai']);
            unset ($this->valF['accord_tacite']);
        }
        unset ($this->valF['avis_decision']); // avis + libelle avis
        unset ($this->valF['terrain_surface_calcul']);
        unset ($this->valF['shon_calcul']);
        unset ($this->valF['date_notification_delai']);
        unset ($this->valF['date_decision']);
        unset ($this->valF['date_limite']);
        unset ($this->valF['date_validite']);
        unset ($this->valF['date_chantier']);
        unset ($this->valF['date_achevement']);
        unset ($this->valF['date_conformite']);
        // Ce champ est mis à jour uniquement par la gestion spécifique du log
        // et donc jamais par les actions ajouter/modifier
        unset ($this->valF['log_instructions']);
        // Ce champ n'est jamais mis à jour, seulement initialisé à la création
        // du dossier d'instruction
        unset($this->valF['initial_dt']);

        // Vérification de la saisie manuelle du numéro complet
        $force_param_duree_val = false;
        $num_doss_comp = isset($val['numero_dossier_complet']) === true ? $val['numero_dossier_complet'] : null;
        if ($num_doss_comp !== null) {

            // si l'option 'code_entité' est activée pour la collectivité
            if ($this->f->is_option_om_collectivite_entity_enabled($this->valF['om_collectivite'])) {

                // si le code entité n'est pas défini ou vide
                if ($this->f->get_collectivite_code_entite($this->valF['om_collectivite']) === null) {

                    // affiche un message d'alerte
                    $err_msg = sprintf(__("Paramètre '%s' manquant ou vide pour la collectivité '%s'"),
                                        'code_entite',
                                        $this->valF['om_collectivite']);
                    $this->f->addToLog(__METHOD__."() : $err_msg", DEBUG_MODE);
                }
                // si le code entité est défini et non-vide
                else {

                    // supprime le code entité du numéro de dossier
                    $code_entite = $this->f->get_collectivite_code_entite($this->valF['om_collectivite']);
                    $num_doss_comp = preg_replace('/'.$code_entite.'[0-9]+$/', '', $num_doss_comp);
                    $this->f->addToLog(
                        __METHOD__."(): suppression (temporaire) du code entité '$code_entite' ".
                        "du dossier $num_doss_comp (complet: ".$val['numero_dossier_complet'].")", DEBUG_MODE);
                }
            }

            $num_urba = $this->f->numerotation_urbanisme($num_doss_comp);
            if (empty($num_urba['di']) === false) {
                $force_param_duree_val = true;
            }
        }
        // Durée de validité lors de la création du dossier d'instruction
        $this->valF['duree_validite'] = $this->get_duree_validite($this->valF['dossier_autorisation'], $force_param_duree_val);
    }


    /**
     * Retourne le type de formulaire : ADS, CTX RE, CTX IN ou DPC.
     *
     * @return mixed $type_aff_form Type de formulaire (string) ou false (bool) si erreur BDD.
     */
    function get_type_affichage_formulaire() {
        if (isset($this->type_aff_form) === true) {
            return $this->type_aff_form;
        }

        $id_dossier_instruction_type = $this->getVal("dossier_instruction_type");
        if($this->getParameter('maj') == '0' OR $this->get_action_crud() === 'create') {
            $id_dossier_instruction_type = $this->valF["dossier_instruction_type"];
        } 

        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation_type.affichage_form
                FROM
                    %1$sdossier_instruction_type
                    INNER JOIN %1$sdossier_autorisation_type_detaille
                        ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    INNER JOIN %1$sdossier_autorisation_type
                        ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type
                WHERE
                    dossier_instruction_type.dossier_instruction_type = \'%2$d\'',
                DB_PREFIXE,
                intval($id_dossier_instruction_type) 
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true
            )
        );

        if ($qres["code"] !== "OK") {
            return false;
        }

        $this->type_aff_form = $qres["result"];

        return $this->type_aff_form;
    }


    /**
     * Retourne le code du groupe du dossier d'instruction.
     *
     * @return string
     */
    public function get_groupe() {
        //
        if (isset($this->groupe) === true && $this->groupe !== null) {
            return $this->groupe;
        }

        // Récupère le code du groupe
        $inst_dossier_autorisation_type_detaille = $this->get_inst_dossier_autorisation_type_detaille();
        $inst_dossier_autorisation_type = $this->get_inst_dossier_autorisation_type($inst_dossier_autorisation_type_detaille->getVal('dossier_autorisation_type'));
        $inst_groupe = $this->get_inst_groupe($inst_dossier_autorisation_type->getVal('groupe'));
        $groupe = $inst_groupe->getVal('code');

        //
        $this->groupe = $groupe;
        //
        return $this->groupe;
    }

    /**
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);
        // La date de dépôt est obligatoire
        if (isset($val['date_depot']) && ($val['date_depot'] === '' || $val['date_depot'] === null)) {
            //
            $this->correct = false;
            $this->addToMessage( _('Le champ').' <span class="bold">'.$this->getLibFromField('date_depot').'</span> '._('est obligatoire'));
        } else {
            //
            $date_depot = $val["date_depot"];
            if (preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', $val["date_depot"], $d_match)) {
                $date_depot = $d_match[3].'-'.$d_match[2].'-'.$d_match[1];
            }
            // Il faut avoir une date de dépôt pour pouvoir vérifier si elle est supérieure à la date du jour
            $date_depot = DateTime::createFromFormat('Y-m-d', $date_depot);
            $aujourdhui = new DateTime();
            try {
                if (! $date_depot instanceof DateTime) {
                    throw new RuntimeException("Not a DateTime");
                }
                // Si la date issus du formulaire n'a pas pu être converti, date_demande vaudra
                // false. Avant de comparer on vérifie donc que la date a bien été récupérée
                if($date_depot > $aujourdhui) {
                    $this->correct = false;
                    $this->addToMessage(_("La date de depot ne peut pas être superieure à la date du jour."));
                }
            } catch (RuntimeException $e) {
                $this->correct = false;
                $this->addToLog($e.' : '._("Le format de la date de depot n'est pas valide."));
                $this->addToMessage(_("Erreur : le format de la date de depot n'est pas correct. Contactez votre administrateur."));
            }
        }

        $type_aff_form = $this->get_type_affichage_formulaire();
        if ($type_aff_form ===false) {
            $this->correct = false;
            $this->addToMessage(_("Une erreur s'est produite lors de l'ajout de ce dossier. Veuillez contacter votre administrateur."));
        }

        switch ($type_aff_form) {
            case 'ADS':
            case 'CTX RE':
            case 'CONSULTATION ENTRANTE':
                if (!isset($this->postedIdDemandeur["petitionnaire_principal"]) OR
                   empty($this->postedIdDemandeur["petitionnaire_principal"]) AND
                   !is_null($this->form)) {
                    $this->correct = false;
                    $this->addToMessage(_("La saisie d'un petitionnaire principal est obligatoire."));
                }
                break;
            case 'CTX IN':
                if (!isset($this->postedIdDemandeur["contrevenant_principal"]) OR
                   empty($this->postedIdDemandeur["contrevenant_principal"]) AND
                   !is_null($this->form)) {
                    $this->correct = false;
                    $this->addToMessage(_("La saisie d'un contrevenant principal est obligatoire."));
                }
                break;
            case 'DPC':
                if(!isset($this->postedIdDemandeur["petitionnaire_principal"]) OR
                   empty($this->postedIdDemandeur["petitionnaire_principal"]) AND
                   !is_null($this->form)) {
                    $this->correct = false;
                    $this->addToMessage(_("La saisie d'un petitionnaire principal est obligatoire."));
                }
                if(!isset($this->postedIdDemandeur["bailleur_principal"]) OR
                   empty($this->postedIdDemandeur["bailleur_principal"]) AND
                   !is_null($this->form)) {
                    $this->correct = false;
                    $this->addToMessage(_("La saisie d'un bailleur principal est obligatoire."));
                }
                break;
        }

        // Récupération du crud par rapport au mode du formulaire
        $crud = $this->get_action_crud($this->getParameter("maj"));

        // L'année de la date de dépot ne peut pas être modifiée
        if ($crud === 'update' && array_key_exists("date_depot", $val) === true && ($val["date_depot"] !== "" && $val["date_depot"] !== null)) {
            //
            $new_date = DateTime::createFromFormat('d/m/Y', $val["date_depot"]);
            $old_date = DateTime::createFromFormat('Y-m-d', $this->getVal("date_depot"));
            if ($new_date->format("Y") != $old_date->format("Y")) {
                $this->addToMessage(_("L'année de la date de dépôt n'est pas modifiable."));
                $this->correct = false;
            }
        }

        // L'année de la date de dépot en mairie ne peut pas être modifiée
        if ($crud === 'update' && array_key_exists("date_depot_mairie", $val) === true && (isset($val["date_depot_mairie"]) === true && $val["date_depot_mairie"] !== "" && $val["date_depot_mairie"] !== null)) {
            //
            $new_date = DateTime::createFromFormat('d/m/Y', $val["date_depot_mairie"]);
            // Dans le cas où une date de dépôt en mairie est saisie et que l'option pour afficher
            // ce champ est désactivée, le champ sera mis en hidden et donc le format de la date
            // dans la valeur ne sera plus "d/m/Y" mais "Y-m-d".
            $new_date = $new_date !== false ? $new_date : DateTime::createFromFormat('Y-m-d', $val["date_depot_mairie"]);
            $old_date = DateTime::createFromFormat('Y-m-d', $this->getVal("date_depot_mairie"));
            if ($old_date !== false && $new_date->format("Y") != $old_date->format("Y")) {
                $this->addToMessage(_("L'année de la date de dépôt en mairie n'est pas modifiable."));
                $this->correct = false;
            }
        }

        // option dossier_commune activée
        if ($this->f->is_option_dossier_commune_enabled()) {

            // La commune doit être définie
            if ($crud !== 'delete') {
                if (! array_key_exists("commune", $val) || empty($val["commune"])) {
                    $this->addToMessage(__("La commune doit être définie."));
                    $this->correct = false;
                }
                else {
                    // récupération de la date de demande
                    $date_demande = 'NOW';
                    $d_match = array();
                    if (isset($val["date_demande"])
                            && preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/',
                                        $val["date_demande"], $d_match)) {
                        $date_demande = $d_match[3].'-'.$d_match[2].'-'.$d_match[1];
                    }
                    $date_demande = new DateTime($date_demande);

                    // La commune doit exister
                    $commune = $this->f->findObjectById("commune", $val["commune"]);
                    if (empty($commune)) {
                        $this->addToMessage(__("La commune doit exister."));
                        $this->correct = false;
                    }
                    // La commune ne peut pas être modifiée
                    elseif ($crud === 'update') {
                        if ($val["commune"] != $this->getVal('commune')) {
                            $this->addToMessage(__("La commune n'est pas modifiable."));
                            $this->correct = false;
                        }
                    }
                    // La commune doit être valide
                    elseif (! $commune->valid($date_demande)) {
                        $this->addToMessage(__(
                            "La commune doit être valide ".
                            "à la date du '".$date_demande->format('d/m/Y')."'."));
                        $this->correct = false;
                    }
                }
            }
        }

        // coordonnées géographiques
        if (isset($val['geoloc_rayon']) && ! empty($val['geoloc_rayon'])) {
            if (! ctype_digit(strval($val['geoloc_rayon']))) {
                $this->addToMessage(__("Le rayon (coordonnées géographiques) est invalide: doit être un nombre"));
                $this->correct = false;
            }
        }
        foreach(array('latitude', 'longitude') as $key) {
            if (isset($val["geoloc_$key"]) && ! empty($val["geoloc_$key"])) {
                $coord = $val["geoloc_$key"];
                if (! preg_match(self::LAT_LON_REGEX, $coord)) {
                    $this->addToMessage(sprintf(
                        __("%s '%s' invalide: le format à respecter est 'd° min.dec N/S/E/O'"), ucfirst($key), $coord));
                    $this->correct = false;
                }
            }
        }
    }

    /**
     * Récupère la liste des champs requis pour la transmission à Plat'AU.
     *
     * @return array
     */
    function get_list_platau_required_fields_dossier() {
        // Liste de tous les champs requis pour la transmission à Plat'AU
        $fields_list = $this->list_platau_required_fields_dossier;
        // Filtre les exception par rapport au type du dossier d'instruction
        $result = array_filter($fields_list, function($value) {
            $fields_list_exception = $this->list_platau_required_fields_dossier_exception;
            $dit_code = $this->getCode($this->getVal('dossier_instruction_type'));
            return array_key_exists($value, $fields_list_exception) === false
                || in_array(mb_strtolower($dit_code), $fields_list_exception[$value]) === true;
        });
        return array_values($result);
    }


    /**
     * Permet de vérifier si les champs requis Plat'AU ont été remplis
     * 
     * @param $dossier l'identifiant du dossier
     * 
     * @return array  un tableau contenant une clé is_ok qui indique 
     *                si tous les champs sont saisis ou non et une clé
     *                required_fields_empty qui contient les champs qui n'ont pas été saisis
     *                | false si une erreur survient
     *  
     */
    function check_platau_required_fields($dossier) {

        // On récupère les champs Plat'AU requis
        $fields_list = $this->get_list_platau_required_fields_dossier();

        // On fait un tableau qui contiendra les tables et un tableau 
        // qui contient les champs au format 'table.champ'
        $tables = array();
        $champs = array();

        foreach ($fields_list as $value) {
            $expl_tab = explode('.', $value);
            if (! in_array($expl_tab[0], $tables)) {
                $tables[] = $expl_tab[0];
            }
            $champs[] = $value;
        }

        // Il y aura toujours la table dossier dans la requête
        if (in_array('dossier', $tables)) {
            $key = array_keys($tables, 'dossier');
            unset($tables[$key[0]]);
        }

        $from_tables = array();
        // On construit le 'FROM' de la requête sql avec les jointures
        foreach($tables as $table) {
            // Cas particulier pour la table demandeur et architecte
            if ($table == "demandeur") {
                $from_tables[] = sprintf(
                    ' LEFT JOIN %1$slien_dossier_demandeur ON lien_dossier_demandeur.dossier = dossier.dossier LEFT JOIN %1$sdemandeur ON lien_dossier_demandeur.demandeur = demandeur.demandeur', 
                    DB_PREFIXE
                );
            } elseif ($table == "architecte") {
                $from_tables[] = sprintf(
                    ' LEFT JOIN %sarchitecte ON architecte.architecte = donnees_techniques.architecte', 
                    DB_PREFIXE
                );
            } else {
                $from_tables[] = sprintf(" LEFT JOIN %s$table ON dossier.dossier = $table.%s ", DB_PREFIXE, $table == 'donnees_techniques' ? 'dossier_instruction' : 'dossier');
            }
        }

        // Construction de la requête sql
        $sql = sprintf(
            '
            SELECT
                %s, 
                CASE WHEN demandeur.qualite=\'particulier\'
                    THEN 
                        TRIM(CONCAT_WS(\' \', demandeur.particulier_nom, demandeur.particulier_prenom))
                    ELSE
                        CASE WHEN demandeur.personne_morale_nom IS NOT NULL OR demandeur.personne_morale_prenom IS NOT NULL
                            THEN 
                                TRIM(CONCAT_WS(\' \', demandeur.personne_morale_raison_sociale, demandeur.personne_morale_denomination, \'%s\', demandeur.personne_morale_nom, demandeur.personne_morale_prenom))
                            ELSE 
                                TRIM(CONCAT(demandeur.personne_morale_raison_sociale, \' \', demandeur.personne_morale_denomination))
                        END
                END as petitionnaire,
                demandeur.demandeur
            FROM
                %sdossier 
                %s
            WHERE dossier.dossier = \'%s\'
            ',
            implode(', ', $champs),
            __("représenté(e) par"),
            DB_PREFIXE,
            implode(' ', $from_tables),
            $dossier
        );

        // On récupère les champs
        $result_fields = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        
        // Si il y a une erreur
        if ($result_fields['code'] == 'KO'
            || $result_fields['result'] == '' 
            || $result_fields['result'] == null) {
            
            $this->addToLog(__METHOD__."() query : ".var_export($sql, true)." error: ".var_export($result_fields['message'], true), DEBUG_MODE);
            return false;
        }

        // On récupère le résultat de la requête
        $required_fields = $result_fields['result'];

        $required_fields_with_tab = array();
        
        // Pour chaque champ on récupère la table
        $demandeur_num = 1;
        foreach ($required_fields as $required_field) {
            foreach ($champs as $champ) {
                if ($champ == "demandeur.localite") {
                    $required_fields_with_tab[$champ.','.$required_field['petitionnaire'].' '.$required_field['demandeur']] = $required_field[explode('.', $champ)[1]];
                } else {
                    $required_fields_with_tab[$champ] = $required_field[explode('.', $champ)[1]];
                }
            }
        }

        // On vérifie si un architecte est lié
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    architecte.*
                FROM
                    %1$sdossier
                    LEFT JOIN %1$sdonnees_techniques
                        ON dossier.dossier = donnees_techniques.dossier_instruction 
                    LEFT JOIN %1$sarchitecte
                        ON donnees_techniques.architecte = architecte.architecte
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true
            )
        );

        if ($qres["code"] !== "OK") {
            $this->addToLog(__METHOD__."() plop error: ".var_export($qres["message"], true), DEBUG_MODE);
            return false;
        }

        // Si il n'est pas lié on enlève le champs architecte
        if ($qres["result"] == '' || $qres["result"] == null) {
            unset($required_fields_with_tab['architecte.ville']);
        }

        $result_tab = array(
            'is_ok' => false,
            'required_fields_empty' => array()
        );

        // Construction du message avec les tables et les champs
        foreach ($required_fields_with_tab as $required_field => $value) {
            if ($value == null || $value == '') {
                $required_fields_splited = explode('.', $required_field);
                if (isset(explode(',', $required_fields_splited[1])[1])) {
                    $required_fields_splited = explode('.', $required_field);
                    // On enlève l'identifiant du demandeur dans le message
                    $required_fields_splited[1] = preg_replace('/[0-9]*$/', '', $required_fields_splited[1]);
                    $result_tab['required_fields_empty'][] = sprintf("%s %s <i>%s</i>",
                        sprintf(__("Dans le formulaire %s"), "<i>".__($required_fields_splited[0])."</i>"),
                        __(" le champ : "),
                        __(explode(',', $required_fields_splited[1])[0]).' pour '.explode(',', $required_fields_splited[1])[1]
                    );
                } else {
                    $result_tab['required_fields_empty'][] = sprintf("%s %s <i>%s</i>",
                        sprintf(__("Dans le formulaire %s"), "<i>".__($required_fields_splited[0])."</i>"),
                        __(" le champ : "),
                        __($required_fields_splited[1])
                    );
                }
            }
        }

        if (empty($result_tab['required_fields_empty'])) {
            $result_tab['is_ok'] = true;
        }

        return $result_tab;

    }


    /**
     * Permet de mettre à jour le state d'une task selon certains paramètre
     * Si le paramètre $dossier_autorisation est spécifié cela signifie que 
     * le dossier a été transmis et qu'on doit modifier les state seulement 
     * des tache de modification du di et d da
     * 
     * @param dossier l'identifiant du dossier
     * @param state_prev le state de la tâche
     * @param state_wanted le state que doit avoir la tâche
     * @param dossier_autorisation l'identifiant du dossier d'autorisation
     * 
     * @return  void
     * 
     */
    function update_task_state($dossier, $state_prev, $state_wanted, $dossier_autorisation=null) {

        $already_transmitted_updated = '';
        $type_task_to_update = '';
        
        $already_transmitted_updated = sprintf('OR task.dossier=\'%s\'', $dossier_autorisation !== null ? $dossier_autorisation : $this->valF['dossier_autorisation']);

        $sql = sprintf(
            'SELECT task FROM %stask WHERE task.state = \'%s\' AND (task.dossier=\'%s\' %s) %s %s',
            DB_PREFIXE, 
            $state_prev,
            $dossier,
            $already_transmitted_updated,
            $type_task_to_update,
            " AND type NOT IN ('notification_recepisse', 'notification_instruction', 'notification_decision') "
        );
        $tasks_id = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        $params = array('val' => array('state' => $state_wanted));
        foreach ($tasks_id['result'] as $task_id) {
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => intval($task_id['task'])
            ));
            $inst_task->update_task($params);
        }
    }


    function setType(&$form,$maj) {
        // Par défaut le type des champs est géré nativement par le framework
        parent::setType($form,$maj);

        // Récupération du contexte : groupe, CRUD et paramètres
        $groupe = $this->get_type_affichage_formulaire();
        $crud = $this->get_action_crud($maj);
        $parameters = $this->f->getCollectivite($this->getVal('om_collectivite'));

        //
        // Gestion du groupe
        //

        // CONSULTATION ENTRANTE
        $ce_fields = array(
            'autorisation_contestee' => 'hidden',
            'cle_acces_citoyen' => 'static',
            'contrevenants' => 'hidden',
            'date_ait' => 'hidden',
            'date_audience' => 'hidden',
            'date_affichage' => 'datestatic',
            'date_cloture_instruction' => 'hidden',
            'date_contradictoire' => 'hidden',
            'date_derniere_visite' => 'hidden',
            'date_premiere_visite' => 'hidden',
            'date_transmission_parquet' => 'hidden',
            'dossier_autorisation_type_detaille' => 'hidden',
            'dossier_instruction_type' => 'selecthiddenstatic',
            'dossier_petitionnaires' => 'hidden',
            'dt_ctx_infraction' => 'hidden',
            'dt_ctx_regularisable' => 'hidden',
            'dt_ctx_synthese_anr' => 'hidden',
            'dt_ctx_synthese_nti' => 'hidden',
            'ctx_reference_dsj' => 'hidden',
            'enjeu_ctx' => 'static',
            'instructeur_2' => 'selecthiddenstatic',
            'requerants' => 'hidden',
            'bailleur' => 'hidden',
            'ctx_reference_sagace' => 'hidden',
            'pec_metier' => 'selecthiddenstatic',
            "consultation_entrante" => 'hidden',
            "delai_reponse" => 'hidden',
            "type_delai" => 'hidden',
            "objet_consultation" => 'hidden',
            "date_production_notification" => 'hidden',
            "date_premiere_consultation" => 'hidden',
            "date_consultation" => 'hidden',
            "date_emission" => 'hidden',
            "service_consultant_id" => 'hidden',
            "service_consultant_libelle" => 'hidden',
            "service_consultant_insee" => 'hidden',
            "service_consultant_mail" => 'hidden',
            "service_consultant_type" => 'hidden',
            "service_consultant__siren" => 'hidden',
            "etat_consultation" => 'hidden',
            "type_consultation" => 'hidden',
            "texte_fondement_reglementaire" => 'hidden',
            "texte_objet_consultation" => 'hidden',
            "dossier_consultation" => 'hidden',
        );
        // INFRACTION
        $inf_fields = array(
            'a_qualifier' => 'hidden',
            'autorisation_contestee' => 'hidden',
            'autorite_competente' => 'hidden',
            'cle_acces_citoyen' => 'hidden',
            'contrevenants' => 'static',
            'date_ait' => 'hiddenstaticdate',
            'date_audience' => 'hiddenstaticdate',
            'date_cloture_instruction' => 'hidden',
            'date_complet' => 'hidden',
            'date_contradictoire' => 'hiddenstaticdate',
            'date_decision' => 'hiddenstaticdate',
            'date_depot' => 'hiddenstaticdate',
            'date_depot_mairie' => 'hiddenstaticdate',
            'date_dernier_depot' => 'hidden',
            'date_derniere_visite' => 'hiddenstaticdate',
            'date_limite' => 'hidden',
            'date_limite_incompletude' => 'hidden',
            'date_premiere_visite' => 'hiddenstaticdate',
            'date_transmission_parquet' => 'hiddenstaticdate',
            'date_validite' => 'hidden',
            'delai' => 'hidden',
            'description_projet' => 'hidden',
            'dossier_autorisation_type_detaille' => 'hidden',
            'dossier_instruction_type' => 'hidden',
            'dossier_petitionnaire' => 'hidden',
            'dossier_petitionnaires' => 'hidden',
            'dt_ctx_infraction' => 'checkboxhiddenstatic',
            'dt_ctx_regularisable' => 'checkboxhiddenstatic',
            'dt_ctx_synthese_anr' => 'static',
            'dt_ctx_synthese_nti' => 'static',
            'ctx_reference_dsj' => 'static',
            'enjeu_ctx' => 'hidden',
            'enjeu_erp' => 'hidden',
            'enjeu_urba' => 'hidden',
            'erp' => 'hidden',
            'evenement_suivant_tacite' => 'hidden',
            'evenement_suivant_tacite_incompletude' => 'hidden',
            'numero_versement_archive' => 'hidden',
            'requerants' => 'hidden',
            'tax_mtn_part_commu' => 'hidden',
            'tax_mtn_part_depart' => 'hidden',
            'tax_mtn_part_reg' => 'hidden',
            'tax_mtn_total' => 'hidden',
            'tax_mtn_rap' => 'hidden',
            'tax_secteur' => 'hidden',
            'tax_mtn_part_commu_sans_exo' => 'hidden',
            'tax_mtn_part_depart_sans_exo' => 'hidden',
            'tax_mtn_part_reg_sans_exo' => 'hidden',
            'tax_mtn_total_sans_exo' => 'hidden',
            'tax_mtn_rap_sans_exo' => 'hidden',
            'bailleur' => 'hidden',
            'ctx_reference_sagace' => 'static',
            'pec_metier' => 'hidden',
            "consultation_entrante" => 'hidden',
            "delai_reponse" => 'hidden',
            "type_delai" => 'hidden',
            "objet_consultation" => 'hidden',
            "date_production_notification" => 'hidden',
            "date_premiere_consultation" => 'hidden',
            "date_consultation" => 'hidden',
            "date_emission" => 'hidden',
            "service_consultant_id" => 'hidden',
            "service_consultant_libelle" => 'hidden',
            "service_consultant_insee" => 'hidden',
            "service_consultant_mail" => 'hidden',
            "service_consultant_type" => 'hidden',
            "service_consultant__siren" => 'hidden',
            "etat_consultation" => 'hidden',
            "type_consultation" => 'hidden',
            "texte_fondement_reglementaire" => 'hidden',
            "texte_objet_consultation" => 'hidden',
            "dossier_consultation" => 'hidden',
        );
        // RECOURS
        $re_fields = array(
            'a_qualifier' => 'hidden',
            'autorite_competente' => 'hidden',
            'cle_acces_citoyen' => 'hidden',
            'contrevenants' => 'hidden',
            'date_ait' => 'hidden',
            'date_audience' => 'hidden',
            'date_cloture_instruction' => 'hiddenstaticdate',
            'date_complet' => 'hidden',
            'date_contradictoire' => 'hidden',
            'date_decision' => 'hiddenstaticdate',
            'date_depot' => 'hiddenstaticdate',
            'date_depot_mairie' => 'hiddenstaticdate',
            'date_dernier_depot' => 'hidden',
            'date_derniere_visite' => 'hidden',
            'date_limite' => 'hiddenstaticdate',
            'date_limite_incompletude' => 'hidden',
            'date_premiere_visite' => 'hidden',
            'date_transmission_parquet' => 'hidden',
            'date_validite' => 'hidden',
            'delai' => 'hidden',
            'description_projet' => 'hidden',
            'dossier_autorisation_type_detaille' => 'static',
            'dossier_instruction_type' => 'hidden',
            'dossier_petitionnaire' => 'hidden',
            'dossier_petitionnaires' => 'static',
            'dt_ctx_infraction' => 'hidden',
            'dt_ctx_regularisable' => 'hidden',
            'dt_ctx_synthese_anr' => 'hidden',
            'dt_ctx_synthese_nti' => 'hidden',
            'enjeu_ctx' => 'hidden',
            'enjeu_erp' => 'hidden',
            'enjeu_urba' => 'hidden',
            'erp' => 'hidden',
            'evenement_suivant_tacite' =>'selecthiddenstatic',
            'evenement_suivant_tacite_incompletude' => 'hidden',
            'instructeur_2' => 'hidden',
            'numero_versement_archive' => 'hidden',
            'requerants' => 'static',
            'tax_mtn_part_commu' => 'hidden',
            'tax_mtn_part_depart' => 'hidden',
            'tax_mtn_part_reg' => 'hidden',
            'tax_mtn_total' => 'hidden',
            'tax_mtn_rap' => 'hidden',
            'tax_secteur' => 'hidden',
            'tax_mtn_part_commu_sans_exo' => 'hidden',
            'tax_mtn_part_depart_sans_exo' => 'hidden',
            'tax_mtn_part_reg_sans_exo' => 'hidden',
            'tax_mtn_total_sans_exo' => 'hidden',
            'tax_mtn_rap_sans_exo' => 'hidden',
            'bailleur' => 'hidden',
            'ctx_reference_dsj' => 'static',
            'ctx_reference_sagace' => 'static',
            'pec_metier' => 'hidden',
            "consultation_entrante" => 'hidden',
            "delai_reponse" => 'hidden',
            "type_delai" => 'hidden',
            "objet_consultation" => 'hidden',
            "date_production_notification" => 'hidden',
            "date_premiere_consultation" => 'hidden',
            "date_consultation" => 'hidden',
            "date_emission" => 'hidden',
            "service_consultant_id" => 'hidden',
            "service_consultant_libelle" => 'hidden',
            "service_consultant_insee" => 'hidden',
            "service_consultant_mail" => 'hidden',
            "service_consultant_type" => 'hidden',
            "service_consultant__siren" => 'hidden',
            "etat_consultation" => 'hidden',
            "type_consultation" => 'hidden',
            "texte_fondement_reglementaire" => 'hidden',
            "texte_objet_consultation" => 'hidden',
            "dossier_consultation" => 'hidden',
        );
        // ADS
        $ads_fields = array(
            'autorisation_contestee' => 'hidden',
            'cle_acces_citoyen' => 'static',
            'contrevenants' => 'hidden',
            'date_ait' => 'hidden',
            'date_audience' => 'hidden',
            'date_affichage' => 'datestatic',
            'date_cloture_instruction' => 'hidden',
            'date_contradictoire' => 'hidden',
            'date_derniere_visite' => 'hidden',
            'date_premiere_visite' => 'hidden',
            'date_transmission_parquet' => 'hidden',
            'dossier_autorisation_type_detaille' => 'hidden',
            'dossier_instruction_type' => 'selecthiddenstatic',
            'dossier_petitionnaires' => 'hidden',
            'dt_ctx_infraction' => 'hidden',
            'dt_ctx_regularisable' => 'hidden',
            'dt_ctx_synthese_anr' => 'hidden',
            'dt_ctx_synthese_nti' => 'hidden',
            'ctx_reference_dsj' => 'hidden',
            'enjeu_ctx' => 'static',
            'instructeur_2' => 'selecthiddenstatic',
            'requerants' => 'hidden',
            'bailleur' => 'hidden',
            'ctx_reference_sagace' => 'hidden',
            'pec_metier' => 'selecthiddenstatic',
            "consultation_entrante" => 'hidden',
            "delai_reponse" => 'hidden',
            "type_delai" => 'hidden',
            "objet_consultation" => 'hidden',
            "date_production_notification" => 'hidden',
            "date_premiere_consultation" => 'hidden',
            "date_consultation" => 'hidden',
            "date_emission" => 'hidden',
            "service_consultant_id" => 'hidden',
            "service_consultant_libelle" => 'hidden',
            "service_consultant_insee" => 'hidden',
            "service_consultant_mail" => 'hidden',
            "service_consultant_type" => 'hidden',
            "service_consultant__siren" => 'hidden',
            "etat_consultation" => 'hidden',
            "type_consultation" => 'hidden',
            "texte_fondement_reglementaire" => 'hidden',
            "texte_objet_consultation" => 'hidden',
            "dossier_consultation" => 'hidden',
        );
        // DPC
        $dpc_fields = array(
            'autorisation_contestee' => 'hidden',
            'cle_acces_citoyen' => 'static',
            'contrevenants' => 'hidden',
            'date_ait' => 'hidden',
            'date_audience' => 'hidden',
            'date_cloture_instruction' => 'hidden',
            'date_contradictoire' => 'hidden',
            'date_derniere_visite' => 'hidden',
            'date_premiere_visite' => 'hidden',
            'date_transmission_parquet' => 'hidden',
            'dossier_autorisation_type_detaille' => 'hidden',
            'dossier_instruction_type' => 'selecthiddenstatic',
            'dossier_petitionnaires' => 'hidden',
            'dt_ctx_infraction' => 'hidden',
            'dt_ctx_regularisable' => 'hidden',
            'dt_ctx_synthese_anr' => 'hidden',
            'dt_ctx_synthese_nti' => 'hidden',
            'ctx_reference_dsj' => 'hidden',
            'enjeu_ctx' => 'static',
            'instructeur_2' => 'selecthiddenstatic',
            'requerants' => 'hidden',
            'bailleur' => 'static',
            'ctx_reference_sagace' => 'hidden',
            'pec_metier' => 'hidden',
            "consultation_entrante" => 'hidden',
            "delai_reponse" => 'hidden',
            "type_delai" => 'hidden',
            "objet_consultation" => 'hidden',
            "date_production_notification" => 'hidden',
            "date_premiere_consultation" => 'hidden',
            "date_consultation" => 'hidden',
            "date_emission" => 'hidden',
            "service_consultant_id" => 'hidden',
            "service_consultant_libelle" => 'hidden',
            "service_consultant_insee" => 'hidden',
            "service_consultant_mail" => 'hidden',
            "service_consultant_type" => 'hidden',
            "service_consultant__siren" => 'hidden',
            "etat_consultation" => 'hidden',
            "type_consultation" => 'hidden',
            "texte_fondement_reglementaire" => 'hidden',
            "texte_objet_consultation" => 'hidden',
            "dossier_consultation" => 'hidden',
        );
        // COMMUN
        $all_fields = array(
            'accord_tacite' => 'hidden',
            'annee' => 'hidden',
            'autres_demandeurs' => 'hidden',
            'date_achevement' => 'hidden',
            'date_chantier' => 'hidden',
            'date_conformite' => 'hidden',
            'date_notification_delai' => 'hidden',
            'date_rejet' => 'hidden',
            'date_retour_contradictoire' => 'hidden',
            'delai_incompletude' => 'hidden',
            'description' => 'hidden',
            'dossier' => 'hidden',
            'dossier_arrondissement' => 'hidden',
            'dossier_autorisation' => 'hidden',
            'dossier_autorisation_libelle' => 'hidden',
            'duree_validite' => 'hidden',
            'etat_pendant_incompletude' => 'hidden',
            'geom' => 'hiddenstatic',
            'geom1' => 'hidden',
            'incomplet_notifie' => 'hidden',
            'incompletude' => 'hidden',
            'interface_referentiel_erp' => 'hidden',
            'log_instructions' => 'nodisplay',
            'om_collectivite' => 'hidden',
            'quartier' => 'hidden',
            'version' => 'hidden',
            'date_modification' => 'hidden',
            'hash_sitadel' => 'hidden',
            'depot_electronique' => 'hidden',
            'version_clos' => 'hidden',
            'initial_dt' => 'hidden',
            'adresse_normalisee' => 'hidden',
            'adresse_normalisee_json' => 'hidden',
            'streetview' => 'hidden',
            'numerotation_type' => 'hidden',
            'numerotation_dep' => 'hidden',
            'numerotation_com' => 'hidden',
            'numerotation_division' => 'hidden',
            'numerotation_suffixe' => 'hidden',
            'numerotation_entite' => 'hidden',
            'numerotation_num' => 'hidden',
            'numerotation_num_suffixe' => 'hidden',
            'numerotation_num_entite' => 'hidden',
            'lien_iiue_portal' => 'hidden',
            'lien_iiue' => 'hidden',
            'dossier_parent' => 'hidden',
            'terrain_superficie_calculee' => 'static',
            'nature_travaux' => 'static',
        );
        if (isset($parameters['option_afficher_division'])
            && $parameters['option_afficher_division'] !== 'true') {
            $all_fields['division'] = 'hidden';
        }
        if (isset($parameters['option_sig'])
            && $parameters['option_sig'] !== 'sig_interne'
            && $parameters['option_sig'] !== 'sig_externe'){
            $all_fields['geom'] = 'hidden';
        }

        if ($this->f->is_option_date_depot_mairie_enabled() === true) {
            $all_fields['date_depot_mairie'] = 'hiddenstaticdate';
        } else {
            $all_fields['date_depot_mairie'] = 'hidden';
        }

        // Affichage des identifiants techniques Plat'AU
        if ($crud === 'read'
            && $this->f->is_type_dossier_platau($this->getVal('dossier_autorisation')) === true
            && ($this->f->is_option_mode_service_consulte_enabled() !== true
                || ($this->f->is_option_mode_service_consulte_enabled() === true
                    && ($this->get_source_depot_from_demande() === PLATAU
                        || $this->get_source_depot_from_demande() === PORTAL)))) {
            //
            $all_fields['lien_iiue'] = 'jsontotab';
        }

        if ($crud === 'read'
            && $this->get_is_portal_code_suivi() === true) {
            // Utilisation d'un type non existant pour que le label du champ
            // ne soit pas généré
            $all_fields['lien_iiue_portal'] = 'staticnolabel';
        }

        
        // Dans tous les cas si le champ accord_tacite est à non on veut que le champ soit caché
        if ($this->is_incomplet_notifie() === false) {
            if ($this->getVal('accord_tacite') === 'Non' || trim($this->getVal('accord_tacite')) === '') {
                $form->setType('evenement_suivant_tacite',"hidden");
            }
        } else {
            // Si le champ accord_tacite est à false alors on n'affiche pas le champ evenement_suivant_tacite_incompletude
            if ($this->getVal('accord_tacite') === 'Non' || trim($this->getVal('accord_tacite')) === '') {
                $form->setType('evenement_suivant_tacite_incompletude',"hidden");
            }
        }

        //
        // Gestion du contexte
        //

        // AJOUTER, MODIFIER
        if ($crud === 'create' OR $crud === 'update') {

            $all_fields['avis_decision'] = 'selecthiddenstatic';
            $all_fields['etat'] = 'hiddenstatic';
            $all_fields['terrain'] = 'hiddenstatic';
            $all_fields['terrain_superficie_calculee'] = 'hiddenstatic';
            //
            $ads_fields['a_qualifier'] = 'checkbox';
            $ads_fields['accord_tacite'] = 'hiddenstatic';
            $ads_fields['autorite_competente'] = 'selecthiddenstatic';
            $ads_fields['date_achevement'] = 'hiddenstaticdate';
            $ads_fields['date_chantier'] = 'hiddenstaticdate';
            $ads_fields['date_conformite'] = 'hiddenstaticdate';
            $ads_fields['date_decision'] = 'hiddenstaticdate';
            $ads_fields['date_affichage'] = 'hiddenstaticdate';
            $ads_fields['date_depot'] = 'hiddenstaticdate';
            //
            $ce_fields['a_qualifier'] = 'checkbox';
            $ce_fields['accord_tacite'] = 'hiddenstatic';
            $ce_fields['autorite_competente'] = 'selecthiddenstatic';
            $ce_fields['date_achevement'] = 'hiddenstaticdate';
            $ce_fields['date_chantier'] = 'hiddenstaticdate';
            $ce_fields['date_conformite'] = 'hiddenstaticdate';
            $ce_fields['date_decision'] = 'hiddenstaticdate';
            $ce_fields['date_affichage'] = 'hiddenstaticdate';
            $ce_fields['date_depot'] = 'hiddenstaticdate';
            if ($this->f->is_option_date_depot_mairie_enabled() === true) {
                $ads_fields['date_depot_mairie'] = 'date';
                $ce_fields['date_depot_mairie'] = 'date';
            } else {
                $ads_fields['date_depot_mairie'] = 'hidden';
                $ce_fields['date_depot_mairie'] = 'hidden';
            }
            $ads_fields['date_dernier_depot'] = 'hiddenstaticdate';
            $ads_fields['date_notification_delai'] = 'hiddenstaticdate';
            $ads_fields['date_rejet'] = 'hiddenstaticdate';
            $ads_fields['date_validite'] = 'hiddenstaticdate';
            $ads_fields['delai'] = 'hiddenstatic';
            $ads_fields['description_projet'] = 'hiddenstatic';
            $ads_fields['dossier_autorisation_type_detaille'] = 'hiddenstatic';
            $ads_fields['shon_calcul'] = 'hiddenstatic';
            $ads_fields['tax_mtn_part_commu'] = 'hidden';
            $ads_fields['tax_mtn_part_depart'] = 'hidden';
            $ads_fields['tax_mtn_part_reg'] = 'hidden';
            $ads_fields['tax_mtn_total'] = 'hidden';
            $ads_fields['tax_mtn_rap'] = 'hidden';
            $ads_fields['tax_mtn_part_commu_sans_exo'] = 'hidden';
            $ads_fields['tax_mtn_part_depart_sans_exo'] = 'hidden';
            $ads_fields['tax_mtn_part_reg_sans_exo'] = 'hidden';
            $ads_fields['tax_mtn_total_sans_exo'] = 'hidden';
            $ads_fields['tax_mtn_rap_sans_exo'] = 'hidden';
            $ads_fields['terrain_surface_calcul'] = 'hiddenstatic';
            //
            $ce_fields['date_dernier_depot'] = 'hiddenstaticdate';
            $ce_fields['date_notification_delai'] = 'hiddenstaticdate';
            $ce_fields['date_rejet'] = 'hiddenstaticdate';
            $ce_fields['date_validite'] = 'hiddenstaticdate';
            $ce_fields['delai'] = 'hiddenstatic';
            $ce_fields['description_projet'] = 'hiddenstatic';
            $ce_fields['dossier_autorisation_type_detaille'] = 'hiddenstatic';
            $ce_fields['shon_calcul'] = 'hiddenstatic';
            $ce_fields['tax_mtn_part_commu'] = 'hidden';
            $ce_fields['tax_mtn_part_depart'] = 'hidden';
            $ce_fields['tax_mtn_part_reg'] = 'hidden';
            $ce_fields['tax_mtn_total'] = 'hidden';
            $ce_fields['tax_mtn_rap'] = 'hidden';
            $ce_fields['tax_mtn_part_commu_sans_exo'] = 'hidden';
            $ce_fields['tax_mtn_part_depart_sans_exo'] = 'hidden';
            $ce_fields['tax_mtn_part_reg_sans_exo'] = 'hidden';
            $ce_fields['tax_mtn_total_sans_exo'] = 'hidden';
            $ce_fields['tax_mtn_rap_sans_exo'] = 'hidden';
            $ce_fields['terrain_surface_calcul'] = 'hiddenstatic';
            //
            $dpc_fields['a_qualifier'] = 'checkbox';
            $dpc_fields['accord_tacite'] = 'hiddenstatic';
            $dpc_fields['autorite_competente'] = 'selecthiddenstatic';
            $dpc_fields['date_achevement'] = 'hiddenstaticdate';
            $dpc_fields['date_chantier'] = 'hiddenstaticdate';
            $dpc_fields['date_conformite'] = 'hiddenstaticdate';
            $dpc_fields['date_decision'] = 'hiddenstaticdate';
            $dpc_fields['date_depot'] = 'hiddenstaticdate';
            $dpc_fields['date_depot_mairie'] = 'hiddenstaticdate';
            $dpc_fields['date_dernier_depot'] = 'hiddenstaticdate';
            $dpc_fields['date_notification_delai'] = 'hiddenstaticdate';
            $dpc_fields['date_rejet'] = 'hiddenstaticdate';
            $dpc_fields['date_validite'] = 'hiddenstaticdate';
            $dpc_fields['delai'] = 'hiddenstatic';
            $dpc_fields['description_projet'] = 'hiddenstatic';
            $dpc_fields['dossier_autorisation_type_detaille'] = 'hiddenstatic';
            $dpc_fields['shon_calcul'] = 'hiddenstatic';
            $dpc_fields['tax_mtn_part_commu'] = 'hidden';
            $dpc_fields['tax_mtn_part_depart'] = 'hidden';
            $dpc_fields['tax_mtn_part_reg'] = 'hidden';
            $dpc_fields['tax_mtn_total'] = 'hidden';
            $dpc_fields['tax_mtn_rap'] = 'hidden';
            $dpc_fields['tax_mtn_part_commu_sans_exo'] = 'hidden';
            $dpc_fields['tax_mtn_part_depart_sans_exo'] = 'hidden';
            $dpc_fields['tax_mtn_part_reg_sans_exo'] = 'hidden';
            $dpc_fields['tax_mtn_total_sans_exo'] = 'hidden';
            $dpc_fields['tax_mtn_rap_sans_exo'] = 'hidden';
            $dpc_fields['terrain_surface_calcul'] = 'hiddenstatic';
            //
            $re_fields['dossier_autorisation_type_detaille'] = 'hiddenstatic';
            $re_fields['dossier_petitionnaires'] = 'static';
            $re_fields['requerants'] = 'hiddenstatic';
            $inf_fields['contrevenants'] = 'hiddenstatic';
            $inf_fields['dt_ctx_synthese_anr'] = 'hiddenstatic';
            $inf_fields['dt_ctx_synthese_nti'] = 'hiddenstatic';
            //
            // Vérifie que le dossier a été déposé depuis Plat'AU ou le portail citoyen
            if ($this->get_source_depot_from_demande() === PLATAU
                || $this->get_source_depot_from_demande() === PORTAL) {
                //
                $ce_fields["consultation_entrante"] = 'hidden';
                $ce_fields["delai_reponse"] = 'static';
                $ce_fields["type_delai"] = 'static';
                $ce_fields["objet_consultation"] = 'static';
                $ce_fields["date_production_notification"] = 'datestatic';
                $ce_fields["date_premiere_consultation"] = 'datestatic';
                $ce_fields["date_consultation"] = 'datestatic';
                $ce_fields["date_emission"] = 'datestatic';
                $ce_fields["service_consultant_id"] = 'static';
                $ce_fields["service_consultant_libelle"] = 'static';
                $ce_fields["service_consultant_insee"] = 'static';
                $ce_fields["service_consultant_mail"] = 'static';
                $ce_fields["service_consultant_type"] = 'static';
                $ce_fields["service_consultant__siren"] = 'static';
                $ce_fields["etat_consultation"] = 'static';
                $ce_fields["type_consultation"] = 'static';
                $ce_fields["texte_fondement_reglementaire"] = 'static';
                $ce_fields["texte_objet_consultation"] = 'static';
                $ce_fields["dossier_consultation"] = 'hidden';
            }
            // Si l'état du dossier est incomplet
            if ($this->is_incomplet_notifie()) {
                // On cache les dates de complétude et de limite d'instruction
                $ads_fields['date_complet'] = 'hidden';
                $ads_fields['date_limite'] = 'hidden';
                $ads_fields['evenement_suivant_tacite_incompletude'] ='selecthiddenstatic';
                $ads_fields['evenement_suivant_tacite'] ='hidden';
                $ads_fields['date_limite_incompletude'] = 'hiddenstaticdate';
                //
                $dpc_fields['date_complet'] = 'hidden';
                $dpc_fields['date_limite'] = 'hidden';
                $dpc_fields['evenement_suivant_tacite_incompletude'] ='selecthiddenstatic';
                $dpc_fields['evenement_suivant_tacite'] ='hidden';
                $dpc_fields['date_limite_incompletude'] = 'hiddenstaticdate';
                //
                $ce_fields['date_complet'] = 'hidden';
                $ce_fields['date_limite'] = 'hidden';
                $ce_fields['evenement_suivant_tacite_incompletude'] ='selecthiddenstatic';
                $ce_fields['evenement_suivant_tacite'] ='hidden';
                $ce_fields['date_limite_incompletude'] = 'hiddenstaticdate';
            } else {
                // Sinon on cache la date de limite d'incomplétude
                $ads_fields['date_limite_incompletude'] = 'hidden';
                $ads_fields['evenement_suivant_tacite_incompletude'] ='hidden';
                $ads_fields['evenement_suivant_tacite'] ='selecthiddenstatic';
                $ads_fields['date_complet'] = 'hiddenstaticdate';
                $ads_fields['date_limite'] = 'hiddenstaticdate';
                //
                $dpc_fields['date_limite_incompletude'] = 'hidden';
                $dpc_fields['evenement_suivant_tacite_incompletude'] ='hidden';
                $dpc_fields['evenement_suivant_tacite'] ='selecthiddenstatic';
                $dpc_fields['date_complet'] = 'hiddenstaticdate';
                $dpc_fields['date_limite'] = 'hiddenstaticdate';
                //
                $ce_fields['date_limite_incompletude'] = 'hidden';
                $ce_fields['evenement_suivant_tacite_incompletude'] ='hidden';
                $ce_fields['evenement_suivant_tacite'] ='selecthiddenstatic';
                $ce_fields['date_complet'] = 'hiddenstaticdate';
                $ce_fields['date_limite'] = 'hiddenstaticdate';
            }

            // MODIFIER
            if ($crud ==='update') {
                $all_fields['dossier_libelle'] = 'hiddenstatic';
                $ads_fields['dossier_petitionnaire'] = 'static';
                $dpc_fields['dossier_petitionnaire'] = 'static';
                $ce_fields['dossier_petitionnaire'] = 'static';
                $inf_fields['numero_versement_archive'] =  'text';
                $re_fields['numero_versement_archive'] =  'text';
                $all_fields['nature_travaux'] = 'select_multiple';
                //
                if ($this->f->isAccredited("dossier_modifier_instructeur")) {
                    $all_fields['instructeur'] =  'select';
                    $inf_fields['instructeur_2'] =  'select';
                    $ads_fields['instructeur_2'] =  'select';
                    $dpc_fields['instructeur_2'] =  'select';
                    $ce_fields['instructeur_2'] =  'select';
                } else {
                    $all_fields['instructeur'] =  'selecthiddenstatic';
                    $inf_fields['instructeur_2'] =  'selecthiddenstatic';
                    $ads_fields['instructeur_2'] =  'selecthiddenstatic';
                    $dpc_fields['instructeur_2'] =  'selecthiddenstatic';
                    $ce_fields['instructeur_2'] =  'selecthiddenstatic';
                }
                //
                if (isset($parameters['option_afficher_division'])
                    && $parameters['option_afficher_division'] === 'true') {
                    $all_fields['division'] =  'selecthiddenstatic';
                    if ($this->f->isAccredited("dossier_modifier_division")) {
                        $all_fields['division'] =  'select';
                    }
                }
                // Si l'utilisateur ne peut pas qualifier un DI (guichet unique & guichet et suivi)
                if (!$this->f->isAccredited(array("dossier_instruction","dossier_instruction_qualifier"), "OR")) {
                    // Il ne peut pas modifier les champs suivants
                    $ads_fields['numero_versement_archive'] =  'hiddenstatic';
                    $ads_fields['enjeu_urba'] =  'checkboxhiddenstatic';
                    $ads_fields['enjeu_erp'] =  'checkboxhiddenstatic';
                    $ads_fields['erp'] =  'checkboxhiddenstatic';
                    $ads_fields['a_qualifier'] =  'checkboxhiddenstatic';
                    //
                    $dpc_fields['numero_versement_archive'] =  'hiddenstatic';
                    $dpc_fields['enjeu_urba'] =  'checkboxhiddenstatic';
                    $dpc_fields['enjeu_erp'] =  'checkboxhiddenstatic';
                    $dpc_fields['erp'] =  'checkboxhiddenstatic';
                    $dpc_fields['a_qualifier'] =  'checkboxhiddenstatic';
                    //
                    $ce_fields['numero_versement_archive'] =  'hiddenstatic';
                    $ce_fields['enjeu_urba'] =  'checkboxhiddenstatic';
                    $ce_fields['enjeu_erp'] =  'checkboxhiddenstatic';
                    $ce_fields['erp'] =  'checkboxhiddenstatic';
                    $ce_fields['a_qualifier'] =  'checkboxhiddenstatic';
                }
                // Le profil Qualificateur peut modifier seulement les champs
                // autorite_competente, a_qualifier et erp
                if ($this->f->isUserQualificateur()) {
                    $ads_fields['numero_versement_archive'] =  'static';
                    $ads_fields['enjeu_urba'] =  'checkboxstatic';
                    $ads_fields['enjeu_erp'] =  'checkboxstatic';
                    //
                    $dpc_fields['numero_versement_archive'] =  'static';
                    $dpc_fields['enjeu_urba'] =  'checkboxstatic';
                    $dpc_fields['enjeu_erp'] =  'checkboxstatic';
                    //
                    $ce_fields['numero_versement_archive'] =  'static';
                    $ce_fields['enjeu_urba'] =  'checkboxstatic';
                    $ce_fields['enjeu_erp'] =  'checkboxstatic';
                }
                // Le dossier ne doit pas être instruit
                if ($this->has_only_recepisse() === true
                    && $this->getStatut() !== 'cloture') {
                    //
                    $all_fields['date_depot'] = 'date';
                    if ($this->f->is_option_date_depot_mairie_enabled() === true) {
                        $all_fields['date_depot_mairie'] = 'date';
                    } else {
                        $all_fields['date_depot_mairie'] = 'hidden';
                    }
                }
                // Gestion de la case à cocher ERP en cas d'interfaçage avec le
                // référentiel ERP
                if ($this->f->is_option_referentiel_erp_enabled($this->getVal('om_collectivite')) === true) {
                    // Par défaut la case à cocher ERP est non modifiable
                    $all_fields['erp'] = 'checkboxhiddenstatic';
                    // Si le type du dossier d'instruction en cours est présent
                    // dans les paramètres autorisant l'interfaçage avec le référentiel ERP
                    if (isset($parameters['erp__dossier__nature__at']) === true
                        && $this->f->getDATCode($this->getVal($this->clePrimaire)) == $parameters['erp__dossier__nature__at']) {
                        //
                        $all_fields['erp'] = 'checkbox';
                    }
                    if (isset($parameters['erp__dossier__nature__pc']) === true
                        && $this->f->getDATCode($this->getVal($this->clePrimaire)) == $parameters['erp__dossier__nature__pc']
                        && isset($parameters['erp__dossier__type_di__pc']) === true) {
                        //
                        $erp_di_pc = explode(";", $parameters['erp__dossier__type_di__pc']);
                        if (is_array($erp_di_pc) === true
                            && in_array($this->getVal("dossier_instruction_type"), $erp_di_pc) === true) {
                            //
                            $all_fields['erp'] = 'checkbox';
                        }
                    }
                }
                // modification de la date d'affichage pour les ADS
                if ($this->f->isAccredited($this->get_absolute_class_name()."_modifier_date_affichage")) {
                    $ads_fields['date_affichage'] = 'date';
                    $ce_fields['date_affichage'] = 'date';
                }

                // pas de modificiation de la commune associée au dossier (si l'option est activée)
                if ($this->f->is_option_dossier_commune_enabled($this->getVal('om_collectivite'))) {
                    $ads_fields['commune'] =  'selecthiddenstatic';
                    $ce_fields['commune'] =  'selecthiddenstatic';
                }
            }
        }
        // MODIFIER, SUPPRIMER, CONSULTER
        if ($crud !== 'create') {
            $re_fields['autorisation_contestee'] = 'selecthiddenstatic';
            $all_fields['date_demande'] = 'hidden';
            // La collectivité n'est jamais modifiable
            if ($_SESSION['niveau'] == 2) {
                $all_fields['om_collectivite'] = 'selecthiddenstatic';
            }
            // Instance du paramétrage des taxes
            $inst_taxe_amenagement = $this->get_inst_taxe_amenagement();
            // Instance de cerfa
            $inst_cerfa = $this->get_inst_cerfa();

            // Gestion du secteur pour la taxe d'aménagement
            // MODIFIER
            if ($crud === 'update') {
                //
                if ($this->is_in_context_of_foreign_key("tax_secteur", $this->getParameter("retourformulaire"))) {
                    $ads_fields['tax_secteur'] = 'selecthiddenstatic';
                    $dpc_fields['tax_secteur'] = 'selecthiddenstatic';
                    $ce_fields['tax_secteur'] = 'selecthiddenstatic';
                } else {
                    $ads_fields['tax_secteur'] = 'select';
                    $dpc_fields['tax_secteur'] = 'select';
                    $ce_fields['tax_secteur'] = 'select';
                }
            }
            // SUPPRIMER
            if ($crud === 'delete') {
                //
                $ads_fields['tax_secteur'] = 'selectstatic';
                $dpc_fields['tax_secteur'] = 'selectstatic';
                $ce_fields['tax_secteur'] = 'selectstatic';
            }
            // CONSULTER
            if ($crud === 'read') {
                //
                $ads_fields['tax_secteur'] = 'selectstatic';
                $dpc_fields['tax_secteur'] = 'selectstatic';
                $ce_fields['tax_secteur'] = 'selectstatic';
                $inf_fields['numero_versement_archive'] =  'hiddenstatic';
                $re_fields['numero_versement_archive'] =  'hiddenstatic';
            }

            // Si l'option de simulation est activée pour la collectivité du
            // dossier, l'utilisateur connecté a la permissions de voir
            // la simulation des taxes, la collectivité à un paramétrage pour
            // les taxes et que le cerfa du dossier à les champs requis
            if ($this->f->is_option_simulation_taxes_enabled($this->getVal('om_collectivite')) === true
                && $this->f->isAccredited("dossier_instruction_simulation_taxes") === true
                && $inst_taxe_amenagement !== null
                && $inst_cerfa->can_simulate_taxe_amenagement() === true) {

                // Si ce n'est pas une commune d'Île-de-France
                if ($inst_taxe_amenagement->getVal('en_ile_de_france') == 'f') {
                    //
                    $ads_fields['tax_mtn_part_reg'] = 'hidden';
                    $ads_fields['tax_mtn_part_reg_sans_exo'] = 'hidden';
                    $dpc_fields['tax_mtn_part_reg'] = 'hidden';
                    $dpc_fields['tax_mtn_part_reg_sans_exo'] = 'hidden';
                    $ce_fields['tax_mtn_part_reg'] = 'hidden';
                    $ce_fields['tax_mtn_part_reg_sans_exo'] = 'hidden';
                }
            } else {
                // SUPPRIMER, CONSULTER
                if ($crud === 'delete' OR $crud ==='read') {
                    $ads_fields['tax_mtn_part_commu'] = 'hidden';
                    $ads_fields['tax_mtn_part_depart'] = 'hidden';
                    $ads_fields['tax_mtn_part_reg'] = 'hidden';
                    $ads_fields['tax_mtn_total'] = 'hidden';
                    $ads_fields['tax_mtn_rap'] = 'hidden';
                    $ads_fields['tax_mtn_part_commu_sans_exo'] = 'hidden';
                    $ads_fields['tax_mtn_part_depart_sans_exo'] = 'hidden';
                    $ads_fields['tax_mtn_part_reg_sans_exo'] = 'hidden';
                    $ads_fields['tax_mtn_total_sans_exo'] = 'hidden';
                    $ads_fields['tax_mtn_rap_sans_exo'] = 'hidden';
                    //
                    $dpc_fields['tax_mtn_part_commu'] = 'hidden';
                    $dpc_fields['tax_mtn_part_depart'] = 'hidden';
                    $dpc_fields['tax_mtn_part_reg'] = 'hidden';
                    $dpc_fields['tax_mtn_total'] = 'hidden';
                    $dpc_fields['tax_mtn_rap'] = 'hidden';
                    $dpc_fields['tax_mtn_part_commu_sans_exo'] = 'hidden';
                    $dpc_fields['tax_mtn_part_depart_sans_exo'] = 'hidden';
                    $dpc_fields['tax_mtn_part_reg_sans_exo'] = 'hidden';
                    $dpc_fields['tax_mtn_total_sans_exo'] = 'hidden';
                    $dpc_fields['tax_mtn_rap_sans_exo'] = 'hidden';
                    //
                    $ce_fields['tax_mtn_part_commu'] = 'hidden';
                    $ce_fields['tax_mtn_part_depart'] = 'hidden';
                    $ce_fields['tax_mtn_part_reg'] = 'hidden';
                    $ce_fields['tax_mtn_total'] = 'hidden';
                    $ce_fields['tax_mtn_rap'] = 'hidden';
                    $ce_fields['tax_mtn_part_commu_sans_exo'] = 'hidden';
                    $ce_fields['tax_mtn_part_depart_sans_exo'] = 'hidden';
                    $ce_fields['tax_mtn_part_reg_sans_exo'] = 'hidden';
                    $ce_fields['tax_mtn_total_sans_exo'] = 'hidden';
                    $ce_fields['tax_mtn_rap_sans_exo'] = 'hidden';
                }
            }
        }
        // CONSULTER
        if ($crud ==='read') {

            $ads_fields['geom'] = 'static';
            $ads_fields['a_qualifier'] =  'checkboxstatic';
            $ads_fields['terrain_references_cadastrales'] = 'referencescadastralesstatic';
            //
            $dpc_fields['geom'] = 'static';
            $dpc_fields['a_qualifier'] =  'checkboxstatic';
            $dpc_fields['terrain_references_cadastrales'] = 'referencescadastralesstatic';
            //
            $ce_fields['geom'] = 'static';
            $ce_fields['a_qualifier'] =  'checkboxstatic';
            $ce_fields['terrain_references_cadastrales'] = 'referencescadastralesstatic';

            $all_fields['nature_travaux'] = 'select_multiple_static';

            // Affiche le champ streetview si l'option est active
            if ($this->f->is_option_streetview_enabled($this->getVal("om_collectivite")) === true) {
                $all_fields['streetview'] = 'static';
            }

            // Si l'état du dossier est incomplet
            if ($this->is_incomplet_notifie()) {
                // on cache les dates de complétude et de limite d'instruction
                $ads_fields['date_complet'] =  'hidden';
                $ads_fields['date_limite'] =  'hidden';
                $ads_fields['evenement_suivant_tacite_incompletude'] = 'selecthiddenstatic';
                $ads_fields['evenement_suivant_tacite'] = 'hidden';
                //
                $dpc_fields['date_complet'] =  'hidden';
                $dpc_fields['date_limite'] =  'hidden';
                $dpc_fields['evenement_suivant_tacite_incompletude'] = 'selecthiddenstatic';
                $dpc_fields['evenement_suivant_tacite'] = 'hidden';
                //
                $ce_fields['date_complet'] =  'hidden';
                $ce_fields['date_limite'] =  'hidden';
                $ce_fields['evenement_suivant_tacite_incompletude'] = 'selecthiddenstatic';
                $ce_fields['evenement_suivant_tacite'] = 'hidden';
            } else {
                // sinon on cache la date de limite d'incomplétude
                $ads_fields['date_limite_incompletude'] =  'hidden';
                $ads_fields['evenement_suivant_tacite_incompletude'] = 'hidden';
                $ads_fields['evenement_suivant_tacite'] = 'selecthiddenstatic';
                //
                $dpc_fields['date_limite_incompletude'] =  'hidden';
                $dpc_fields['evenement_suivant_tacite_incompletude'] = 'hidden';
                $dpc_fields['evenement_suivant_tacite'] = 'selecthiddenstatic';
                //
                $ce_fields['date_limite_incompletude'] =  'hidden';
                $ce_fields['evenement_suivant_tacite_incompletude'] = 'hidden';
                $ce_fields['evenement_suivant_tacite'] = 'selecthiddenstatic';
            }
            if (isset($parameters['option_arrondissement'])
                && $parameters['option_arrondissement'] === 'true') {
                $all_fields['dossier_arrondissement'] = 'static';
            }
            //
            // Vérifie que le dossier a été déposé depuis Plat'AU ou le portail citoyen
            if ($this->get_source_depot_from_demande() === PLATAU
                || $this->get_source_depot_from_demande() === PORTAL) {
                //
                $ce_fields["consultation_entrante"] = 'hidden';
                $ce_fields["delai_reponse"] = 'static';
                $ce_fields["type_delai"] = 'static';
                $ce_fields["objet_consultation"] = 'static';
                $ce_fields["date_production_notification"] = 'datestatic';
                $ce_fields["date_premiere_consultation"] = 'datestatic';
                $ce_fields["date_consultation"] = 'datestatic';
                $ce_fields["date_emission"] = 'datestatic';
                $ce_fields["service_consultant_id"] = 'static';
                $ce_fields["service_consultant_libelle"] = 'static';
                $ce_fields["service_consultant_insee"] = 'static';
                $ce_fields["service_consultant_mail"] = 'static';
                $ce_fields["service_consultant_type"] = 'static';
                $ce_fields["service_consultant__siren"] = 'static';
                $ce_fields["etat_consultation"] = 'static';
                $ce_fields["type_consultation"] = 'static';
                $ce_fields["texte_fondement_reglementaire"] = 'static';
                $ce_fields["texte_objet_consultation"] = 'static';
                $ce_fields["dossier_consultation"] = 'hidden';
            }
        }
        // SUPPRIMER
        if($crud === 'delete') {
            // Cache tous les champs execepté le libellé du dossier
            foreach ($this->champs as $champ) {
                $all_fields[$champ] = 'hidden';
            }
            $all_fields['dossier_libelle'] = 'hiddenstatic';
        }

        $all_fields['etat_transmission_platau'] = 'hidden';
        if ($crud !== 'create') {
            //
            $inst_datd = $this->get_inst_dossier_autorisation_type_detaille();
            if ($inst_datd->getVal('dossier_platau') === 't') {
                //
                $all_fields['etat_transmission_platau'] = 'selecthiddenstatic';
            }
        }


        if ($crud == 'create' || $crud == 'update') {
            $required_fields_platau = $this->get_list_platau_required_fields_dossier();
            if ($this->f->is_option_mode_service_consulte_enabled() === false) {
                if ($this->f->is_type_dossier_platau($this->getVal('dossier_autorisation')) === true
                    && $this->getVal('etat_transmission_platau') !== 'jamais_transmissible') {
                    //
                    foreach ($required_fields_platau as $required_field_platau) {
                        $champ = explode('.', $required_field_platau)[1];
                        if (in_array($champ, $this->champs)) {
                            $form->setType($champ ,$form->type[$champ].'_demat_color');
                        }
                    }
                }
            }
        }

        // Dans tous les cas si le champ accord_tacite est à non on veut insérer
        // du texte dans le champ "au terme du délai" et donc ce n'est plus un
        // selecthiddenstatic
        if ($this->getVal('accord_tacite') === 'Non' || trim($this->getVal('accord_tacite')) === '') {
            if ($this->is_incomplet_notifie() === false) {
                $all_fields['evenement_suivant_tacite'] = 'hiddenstatic';
                $ads_fields['evenement_suivant_tacite'] = 'hiddenstatic';
                $ce_fields['evenement_suivant_tacite'] = 'hiddenstatic';
                $dpc_fields['evenement_suivant_tacite'] = 'hiddenstatic';
            } else {
                $all_fields['evenement_suivant_tacite_incompletude'] = 'hiddenstatic';
                $ads_fields['evenement_suivant_tacite_incompletude'] = 'hiddenstatic';
                $dpc_fields['evenement_suivant_tacite_incompletude'] = 'hiddenstatic';
                $ce_fields['evenement_suivant_tacite_incompletude'] = 'hiddenstatic';
            }
        }

        // Lorsque le statut de dossier est "cloture" on cache le champ "au terme du délai"
        if ($this->getStatut() === 'cloture') {
            $all_fields['evenement_suivant_tacite'] = 'hidden';
            $ads_fields['evenement_suivant_tacite'] = 'hidden';
            $dpc_fields['evenement_suivant_tacite'] = 'hidden';
            $ce_fields['evenement_suivant_tacite'] = 'hidden';
        }

        //
        // Typage
        //

        switch ($groupe) {
            case 'CTX IN':
                $this->manage_type($form, $inf_fields);
                break;
            case 'CTX RE':
                $this->manage_type($form, $re_fields);
                break;
            case 'ADS':
                $this->manage_type($form, $ads_fields);
                break;
            case 'DPC':
                $this->manage_type($form, $dpc_fields);
                break;
            case 'CONSULTATION ENTRANTE':
                $this->manage_type($form, $ce_fields);
                break;
        }
        $this->manage_type($form, $all_fields);

        // Gestion des champs pour lesquels le label ne dois pas être affiché.
        // Pour chacun des champs de la liste, leur type est récupéré à partir du formulaire
        // $form. Le suffixe nolabel est ensuite ajouté à la fin pour que le label ne soit pas
        // pris en compte.
        // Si le type n'est pas renseigné dans le formulaire alors le type par défaut est
        // hiddenstatic

        $fields_with_placeholder = array();
        $no_label_fields = array();
        if($maj == 3 && $groupe != 'CTX IN' && $groupe != 'CTX RE') {

            // Pour certains champs, on souhaite indiquer visuellement grâce à un placeholder
            // qu'une information n'est pas renseigné et que le champ existe bel et bien

            $fields_with_placeholder = array(
                "numero_versement_archive" => "Non renseigné",
                "terrain_references_cadastrales" => "Non renseigné",
                "geom" => "<div class='no-geoloc_label'><span class='om-icon om-icon-16 om-icon-fix sig-16 no-geoloc' title='Localiser'></span><span>"._("Aucune geolocalisation")."</span></div>",
                "date_affichage" => "Néant",
                "date_decision" => "Néant",
                "date_validite" => "Néant",
                "description_projet" => "Pas de description",
            );

            $no_label_fields = array(
                'om_collectivite',
                'dossier_libelle',
                'dossier_instruction_type',
                'dossier_petitionnaire',
                'nature_travaux',
                'terrain_adresse_voie_numero',
                'terrain_adresse_voie',
                'terrain_adresse_lieu_dit',
                'terrain_adresse_code_postal',
                'terrain_adresse_localite',
                'terrain'
            );
        }

        // Vérifie que chaque champs sans label à un type pour éviter des erreurs lors
        // de la mise en place du Layout
        // /!\ L'affichage des labels est géré via la méthode setLayout() dans laquelle
        //     on applique la classe no-label aux champs voulus
        foreach ($no_label_fields as $no_label_field) {
            if (! isset($form->type[$no_label_field])) {
                $form->setType($no_label_field, 'hiddenstatic');
            }
        }

        // Si un champ non caché n'est pas renseigné, on lui
        // affecte un placeholder avec setValue
        foreach (array_keys($fields_with_placeholder) as $field_with_placeholder) {
            if (empty($this->getVal($field_with_placeholder))) {
                $form->setVal($field_with_placeholder, $fields_with_placeholder[$field_with_placeholder]);
                $form->classes_specifiques[$field_with_placeholder] = "placeholder";
            }
        }

        // Les champs sans label n'ont pas à être affiché si ils sont vide.
        $hide_when_empty_fields =array();
        if($maj == 3 && $groupe != 'CTX IN' && $groupe != 'CTX RE') {
            $hide_when_empty_fields = array(
                "tax_secteur",
                "instructeur_2",
                "date_dernier_depot",
                "evenement_suivant_tacite",
                "evenement_suivant_tacite_incompletude",
                "date_complet",
                "autorite_competente",
                "avis_decision",
                "om_collectivite",
                "dossier_libelle",
                "dossier_instruction_type",
                "dossier_petitionnaire",
                "nature_travaux",
                "terrain",
                "terrain_adresse_voie_numero",
                "terrain_adresse_voie",
                "terrain_adresse_code_postal",
                "terrain_adresse_localite",
                "terrain_adresse_lieu_dit",
                "terrain_adresse_bp",
                "terrain_adresse_cedex",
                "geoloc_latitude",
                "geoloc_longitude",
                "terrain_superficie",
                "terrain_superficie_calculee",
                "geoloc_rayon",
                "pec_metier"
            );
        }
        foreach ($hide_when_empty_fields as $field) {
            if (empty($this->getVal($field)) 
                || $this->getVal($field) == "choisir autorité compétente"
                || (($field == "evenement_suivant_tacite" || $field == "evenement_suivant_tacite_incompletude") && $this->getVal("accord_tacite") === 'Non' )
            ) {
                $form->setType($field, 'hidden');
            }
        }
    }


    /**
     * Gestion du typage des champs
     *
     * @param  object  $form    formulaire instancié
     * @param  array   $fields  tableau associatif des champs avec leur widget de formulaire en valeur
     * @return void
     */
    protected function manage_type($form, $fields) {
        foreach ($this->champs as $key => $field) {
            if (array_key_exists($field, $fields) === true) {
                $form->setType($field, $fields[$field]);
            }
        }
    }


    /**
     * Retourne le nombre de parcelles qu'à en commun le dossier passé en
     * paramètre avec les dossiers contentieux en cours. Le nombre de parcelles
     * est groupé par type de dossier d'autorisation : RE ou IN.
     * Permet également de vérifier si au moins un des dossiers contentieux liés,
     * est clôturé ou non, ce résultat est regroupé par type RE ou IN.
     *
     * @param string $di identifiant du DI
     *
     * @return array
     */
    function get_data_dossier_ctx_lie($di) {
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation_type.code,
                    dossier_ctx.dossier,
                    etat.statut
                FROM %1$sdossier
                    LEFT JOIN %1$sdossier_parcelle
                        ON dossier.dossier = dossier_parcelle.dossier
                    LEFT JOIN %1$sdossier_parcelle as parcelle_ctx
                        ON dossier_parcelle.libelle = parcelle_ctx.libelle
                        AND dossier_parcelle.dossier != parcelle_ctx.dossier
                    LEFT JOIN %1$sdossier as dossier_ctx
                        ON dossier_ctx.dossier = parcelle_ctx.dossier
                    INNER JOIN %1$setat
                        ON dossier_ctx.etat = etat.etat
                    LEFT JOIN %1$sdossier_autorisation
                        ON dossier_ctx.dossier_autorisation = dossier_autorisation.dossier_autorisation
                    LEFT JOIN %1$sdossier_autorisation_type_detaille
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                            = dossier_autorisation.dossier_autorisation_type_detaille
                    LEFT JOIN %1$sdossier_autorisation_type
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type
                            = dossier_autorisation_type.dossier_autorisation_type
                WHERE
                    dossier.dossier = \'%2$s\'
                    AND (dossier_autorisation_type.code = \'RE\'
                        OR dossier_autorisation_type.code = \'IN\')',
                DB_PREFIXE,
                $this->f->db->escapeSimple($di)
            ),
            array(
                'origin' => __METHOD__
            )
        );

        // Nombre de dossier de chaque type
        $nb_re_inf = array('re' => 0, 'inf' => 0);
        // Au moins un dossier est clôturé, par type
        $cloture_re_inf = array('re' => true, 'inf' => true);
        foreach ($qres['result'] as $row) {
            // Compte le nombre de RE et vérifie si au moins l'un d'entre eux
            // n'est pas clôturé
            if ($row["code"] == "RE"){
                $nb_re_inf['re']++;
                if ($row['statut'] != "cloture") {
                    $cloture_re_inf['re'] = false;
                }
            }
            // Compte le nombre de IN et vérifie si au moins l'un d'entre eux
            // n'est pas clôturé
            if ($row["code"] == "IN"){
                $nb_re_inf['inf']++;
                if ($row['statut'] != "cloture") {
                    $cloture_re_inf['inf'] = false;
                }
            }
        }

        // Tableau de résultat
        $result = array(
            'nb_re_inf' => $nb_re_inf,
            'cloture_re_inf' => $cloture_re_inf,
        );
        return $result;
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        // parent::setVal($form, $maj, $validation);
        //
        $this->maj=$maj;

        if ($this->f->is_option_sig_enabled($this->getVal("om_collectivite")) === true
            && $this->f->issetSIGParameter($this->getVal("dossier")) === true) {

            // lien vers le SIG
            $geoLinksHtml = $this->getGeolocalisationLink();
            $form->setVal("geom", $geoLinksHtml);
        }
        // si l'option 'streetview' est activée ajoute un lien vers Google Maps Street View
        if ($this->f->is_option_streetview_enabled($this->getVal("om_collectivite")) === true
            && $maj == 3) {
            //
            $gStreetViewLinkHtml = $this->getGoogleMapsStreetViewLink();
            $form->setVal("streetview", $gStreetViewLinkHtml);
        }
        //
        $affichage_form = $this->get_type_affichage_formulaire();
        if ($affichage_form === "ADS" || $affichage_form === "CONSULTATION ENTRANTE") {
            // Dans le cas d'un dépôt électronique un pictogramme apparait devant le demandeur
            if ($maj == 1 || $maj == 2 || $maj == 3) {
                if ($this->getVal("depot_electronique") === "t"
                    || $this->getVal("depot_electronique") === true
                    || $this->getVal("depot_electronique") === 1) {
                    //
                    $form->setVal(
                        "dossier_petitionnaire",
                        sprintf(
                            "<span class='om-icon om-icon-16 om-icon-fix depot-electronique-16' title='%s'> </span>%s",
                            "Dépôt électronique",
                            $this->getVal("dossier_petitionnaire")
                        )
                    );
                }
            }
            if ($maj == 3) {
                // Attribution d'une classe CSS aux éventuelles pastilles indiquant les recours et infractions
                $re_inf = $this->get_data_dossier_ctx_lie($this->getVal("dossier"));
                $message = "";
                if ($re_inf['nb_re_inf']["re"] > 0) {
                    // On teste si le dossier recours est clôturé (vert) ou non (orange) pour lui attribuer une couleur via la classe CSS 
                    $message = sprintf(
                        '<span class=\'label %1$s\' name= \'%2$s\' title=\'%3$s\'> %2$s </span>',
                        $re_inf['cloture_re_inf']['re'] ? "label-success" : "label-warning",
                        __("RE"),
                        __("Au moins un dossier de recours contentieux ou gracieux en cours concerne les références cadastrales du dossier courant.")
                    );
                    if ($re_inf['nb_re_inf']["inf"] > 0) {
                        $message .= " ";
                    }
                }
                if ($re_inf['nb_re_inf']["inf"] > 0) {
                    // On teste si le dossier infraction est clôturé (vert) ou non (rouge) pour lui attribuer une couleur via la classe CSS
                    $message .= sprintf(
                        '<span class=\'label %1$s\' name= \'%2$s\' title=\'%3$s\'> %2$s </span>',
                        $re_inf['cloture_re_inf']['inf'] ? "label-success" : "label-important",
                        __("IN"),
                        __("Au moins un dossier d'infraction en cours concerne les références cadastrales du dossier courant.")
                    );
                }   
                $form->setVal("enjeu_ctx", $message);
            }
        } elseif ($affichage_form === "CTX RE") {
            // Récupération des demandeurs liés au dossier
            $this->listeDemandeur("dossier", $this->getVal("dossier"));
            //
            $requerants = "";
            if ($this->getVal("requerants") != "") {
                $requerants = $this->getVal("requerants");
                if (isset($this->valIdDemandeur["requerant"]) === true
                    && count($this->valIdDemandeur["requerant"]) > 0) {
                    //
                    $requerants .= " "._("et autres");
                }
            }
            $form->setVal("requerants", $requerants);
            //
            $dossier_petitionnaires = "";
            if ($this->getVal("dossier_petitionnaire") != "") {
                $dossier_petitionnaires = $this->getVal("dossier_petitionnaire");
            }
            if (isset($this->valIdDemandeur["petitionnaire"]) === true
                && count($this->valIdDemandeur["petitionnaire"]) > 0) {
                //
                $dossier_petitionnaires .= " "._("et autres");
            }
            $form->setVal("dossier_petitionnaires", $dossier_petitionnaires);
        } elseif ($affichage_form === "CTX IN") {
            // Récupération des demandeurs liés au dossier
            $this->listeDemandeur("dossier", $this->getVal("dossier"));
            //
            $contrevenants = "";
            if ($this->getVal("contrevenants") != "") {
                $contrevenants = $this->getVal("contrevenants");
                if (isset($this->valIdDemandeur["contrevenant"]) === true
                    && count($this->valIdDemandeur["contrevenant"]) > 0) {
                    //
                    $contrevenants .= " "._("et autres");
                }
            }
            $form->setVal("contrevenants", $contrevenants);
        } elseif ($affichage_form === "DPC") {
            // Récupération des demandeurs liés au dossier
            $this->listeDemandeur("dossier", $this->getVal("dossier"));
            //
            $bailleurs = "";
            if ($this->getVal("bailleurs") != "") {
                $bailleurs = $this->getVal("bailleurs");
                if (isset($this->valIdDemandeur["bailleur"]) === true
                    && count($this->valIdDemandeur["bailleur"]) > 0) {
                    //
                    $bailleurs .= " "._("et autres");
                }
            }
            $form->setVal("bailleurs", $bailleurs);
        }
        //
        if ($validation == 0) {
            if ($maj == 0) {
                $form->setVal("annee", date("y"));
                $form->setVal("date_demande", date("Y-m-d"));
                $form->setVal("date_depot", date("Y-m-d"));
                $form->setVal("accord_tacite", "Non");
                $form->setVal("etat", "initialiser");
            }
        }
        //
        if ($maj == 3) {
            $form->setVal("lien_iiue_portal", $this->get_json_lien_iiue_portal());
            $form->setVal("lien_iiue", $this->get_json_lien_iiue_platau());
        }
    }

    /**
     * getGeolocalisationLink retourne le code HTML affichant l'icone du globe, ainsi que
     * les coordonnées du centroide du dossier, le tout étant un lien vers le SIG.
     *
     * @return string Lien vers le SIG
     */
    function getGeolocalisationLink() {
        //
        $link = "<a id='action-form-localiser'".
                " target='_SIG' href='".OM_ROUTE_FORM."&obj=dossier_instruction&action=140&idx=".$this->getVal("dossier")."'>".
                "<span class='om-icon om-icon-16 om-icon-fix sig-16' title='Localiser'>Localiser</span> ".
                $this->getVal('geom').
                " </a>";
        $nogeoloc = "<div class='no-geoloc_label'><span class='om-icon om-icon-16 om-icon-fix sig-16 no-geoloc' title='Localiser'></span><span>"._("Aucune geolocalisation")."</span></div>";
        return $this->getVal('geom') ? $link : $nogeoloc;
    }


    /**
     * converti un geom au format Lat,Lon
     *
     * @param  string  $geom         Le Geom
     * @param  string  $fromRefId    Le référentiel dans lequel le geom est défini
     * @param  string  $toLongLatId  Le référentiel dans lequel le geom doit être converti
     *
     * @return array[2]  Long,Lat ou bien false,"message" en cas d'erreur
     */
    protected function convertGeomToLongLat(string $geom, string $fromRefId = '2154',
                                            string $toLongLatId = '4326') {

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    ST_X(ST_Transform(ST_GeomFromText(\'%1$s\', %2$s), %3$s)) AS longitude,
                    ST_Y(ST_Transform(ST_GeomFromText(\'%1$s\', %2$s), %3$s)) AS latitude',
                $this->f->db->escapeSimple($geom),
                $this->f->db->escapeSimple($fromRefId),
                $this->f->db->escapeSimple($toLongLatId)
            ),
            array(
                'origin' => __METHOD__
            )
        );

        if ($qres['code'] !== 'OK') { // PP
            $this->addToLog(__METHOD__."() error: ".var_export($qres['message'], true), DEBUG_MODE);
            return array(false, $qres['message'],);
        }
        if ($qres['row_count'] != 1) {
            $this->addToLog(__METHOD__."() error: ".var_export($qres['row_count'], true), DEBUG_MODE);
            return array(false, __("Erreur: Plus d'un enregistrement retourné").
                                '('.$qres['row_count'].')');
        }
        $coord = array_shift($qres['result']);
        $this->addToLog(__METHOD__."() coord: ".var_export($coord, true), EXTRA_VERBOSE_MODE);
        return array_values($coord);
    }

    /**
     * getGoogleMapsStreetViewLink retourne le code HTML affichant un lien vers une vue
     * Google Maps Street View à partir des coordonnées du geom.
     *
     * @return string Lien vers Google Maps Street View
     */
    protected function getGoogleMapsStreetViewLink() {
        // Récupération coordonnées du terrain

        // Passage du numéro de dossier comme id pour pouvoir le récupérer dans le
        // jscript lors du clic
        $html = sprintf(
            "<a id='action-form-gstreetview' class='simple-btn' title='%s' onclick='get_adresse_terrain(this.id, \"%s\")'>
                <span class='om-icon om-icon-16 om-icon-fix consult-16'></span>%s
            </a>",
            __("Ouvrir dans Google Maps Street View"),
            $this->getVal($this->clePrimaire),
            __("Street View")
        );
        return $html;
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        $crud = $this->get_action_crud($this->getParameter("maj"));

        // XXX Commenté pour patcher le problème de montée en charge de la base
        // de données en cas de reprise de données d'un gros volume de dossier
        // d'instruction
        // parent::setSelect($form, $maj);
        // om_collectivite
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "om_collectivite",
            $this->get_var_sql_forminc__sql("om_collectivite"),
            $this->get_var_sql_forminc__sql("om_collectivite_by_id"),
            false
        );

        if ($maj == 1 || $maj == 3) {
            $sql_nature_travaux_by_dit = str_replace(
                '<dossier_instruction_type>',
                $this->getVal('dossier_instruction_type'),
                $this->get_var_sql_forminc__sql("nature_travaux_by_dit")
            );
            // Initialisation du selecteur multiple nature_travaux
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "nature_travaux",
                $sql_nature_travaux_by_dit,
                $this->get_var_sql_forminc__sql("nature_travaux_by_id"),
                false,
                true
            );
        }

        /* 
         *  Pour chaque init_select d'un select non modifiable on teste
         *  si l'on est en mode modifier : si c'est le cas alors on initialise le
         *  select en mode consulter (qui n'affiche rien s'il n'y a aucune valeur).
         */

        $collectivite_idx = $this->getVal("om_collectivite");
        $affichage_form_dat = "";
        // Si recherche avancée om_collectivite = collectivité utilisateur
        if ($maj == 999) {
            $collectivite_idx = $this->f->getParameter("om_collectivite_idx");
        } else {
            $affichage_form_dat = $this->get_type_affichage_formulaire();
        }
        // Définition de la qualité et de la traduction de l'instructeur
        $lib_instructeur = __("l'instructeur");
        $lib_instructeur_2 = __("l'instructeur secondaire");
        $affichage_instr_2 = 'instr';
        $affichage_instr = '';
        switch ($affichage_form_dat) {
            case 'DPC':
            case 'ADS':
            case 'CONSULTATION ENTRANTE':
                $affichage_instr = "AND instructeur_qualite.code = 'instr'";
                break;
            case 'CTX RE':
                $lib_instructeur_2 = __("le technicien");
                $affichage_instr_2 = 'tech';
                break;
            case 'CTX IN':
                $affichage_instr = "AND instructeur_qualite.code = 'juri'";
                $lib_instructeur = __('le juriste');
                $lib_instructeur_2 = __("le technicien");
                $affichage_instr_2 = 'tech';
                break;
            default:
                $affichage_instr = "";
                break;
        }

        // instructeur
        // on recupère les services des multicollectivités et de celle du DI
        if ($this->f->getParameter('option_afficher_division')==='true') {
            // instructeur
            $sql_instructeur_div_by_di = str_replace(
                '<collectivite_di>',
                $collectivite_idx,
                $this->get_var_sql_forminc__sql("instructeur_div_by_di")
            );
            $sql_instructeur_div_by_di = str_replace(
                '<instructeur_qualite>',
                $affichage_instr,
                $sql_instructeur_div_by_di
            );
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "instructeur",
                $sql_instructeur_div_by_di,
                $this->get_var_sql_forminc__sql("instructeur_div_by_id"),
                true,
                false,
                $lib_instructeur
            );
            // instructeur_2
            $sql_instructeur_2_div_by_di = str_replace(
                '<collectivite_di>',
                $collectivite_idx,
                $this->get_var_sql_forminc__sql("instructeur_2_div_by_di")
            );
            $sql_instructeur_2_div_by_di = str_replace(
                '<instructeur_qualite>',
                $affichage_instr_2,
                $sql_instructeur_2_div_by_di
            );
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "instructeur_2",
                $sql_instructeur_2_div_by_di,
                $this->get_var_sql_forminc__sql("instructeur_2_div_by_id"),
                true,
                false,
                $lib_instructeur_2
            );
        } else {
            $sql_instructeur_by_di = str_replace(
                '<collectivite_di>',
                $collectivite_idx,
                $this->get_var_sql_forminc__sql("instructeur_by_di")
            );
            $sql_instructeur_by_di = str_replace(
                '<instructeur_qualite>',
                $affichage_instr,
                $sql_instructeur_by_di
            );
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "instructeur",
                $sql_instructeur_by_di,
                $this->get_var_sql_forminc__sql("instructeur_by_id"),
                true,
                false,
                $lib_instructeur
            );
            $sql_instructeur_2_by_di = str_replace(
                '<collectivite_di>',
                $collectivite_idx,
                $this->get_var_sql_forminc__sql("instructeur_2_by_di")
            );
            $sql_instructeur_2_by_di = str_replace(
                '<instructeur_qualite>',
                $affichage_instr_2,
                $sql_instructeur_2_by_di
            );
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "instructeur_2",
                $sql_instructeur_2_by_di,
                $this->get_var_sql_forminc__sql("instructeur_2_by_id"),
                true,
                false,
                $lib_instructeur_2
            );
        }

        // etat
        if ($maj == 1) {
            $this->init_select(
                $form,
                $this->f->db,
                3,
                null,
                "etat",
                $this->get_var_sql_forminc__sql("etat"),
                $this->get_var_sql_forminc__sql("etat_by_id"),
                false
            );
        } else {
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "etat",
                $this->get_var_sql_forminc__sql("etat"),
                $this->get_var_sql_forminc__sql("etat_by_id"),
                false
            );
        }

        // dossier_instruction_type
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "dossier_instruction_type",
            $this->get_var_sql_forminc__sql("dossier_instruction_type"),
            $this->get_var_sql_forminc__sql("dossier_instruction_type_by_id"),
            false
        );

        // division
        $sql_division_by_di = str_replace(
            '<collectivite_di>',
            $collectivite_idx,
            $this->get_var_sql_forminc__sql("division_by_di")
        );
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "division",
            $sql_division_by_di,
            $this->get_var_sql_forminc__sql("division_by_id"),
            true
        );

        // autorite_competente
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "autorite_competente",
            $this->get_var_sql_forminc__sql("autorite_competente"),
            $this->get_var_sql_forminc__sql("autorite_competente_by_id"),
            false
        );

        // avis_decision
        if ($maj == 1) {
            $this->init_select(
                $form,
                $this->f->db,
                3,
                null,
                "avis_decision",
                $this->get_var_sql_forminc__sql("avis_decision"),
                $this->get_var_sql_forminc__sql("avis_decision_by_id"),
                false
            );
        } else {
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "avis_decision",
                $this->get_var_sql_forminc__sql("avis_decision"),
                $this->get_var_sql_forminc__sql("avis_decision_by_id"),
                false
            );
        }

        // autorisation_contestee
        if ($affichage_form_dat === 'CTX RE'
            && ($maj == 1 || $maj == 3)) {
            // À exécuter seulement en mode modifier ou consulter des recours
            // pour éviter le ralentissement de l'affichage des listings des DI
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "autorisation_contestee",
                $this->get_var_sql_forminc__sql("autorisation_contestee"),
                $this->get_var_sql_forminc__sql("autorisation_contestee_by_id"),
                false
            );
        }

        // Si l'accord tacite est activé, on récupère la liste des évènements
        if ($this->getVal('accord_tacite') === 'Oui') {

            // evenement_suivant_tacite
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "evenement_suivant_tacite",
                $this->get_var_sql_forminc__sql("evenement_suivant_tacite"),
                $this->get_var_sql_forminc__sql("evenement_suivant_tacite_by_id"),
                false
            );

            // evenement_suivant_tacite_incompletude
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "evenement_suivant_tacite_incompletude",
                $this->get_var_sql_forminc__sql("evenement_suivant_tacite_incompletude"),
                $this->get_var_sql_forminc__sql("evenement_suivant_tacite_incompletude_by_id"),
                false
            );
        }

        // Ajout, modification et recherche avancée
        if ($maj == 0 || $maj == 1 || $maj == 999) {
            // accord tacite
            $contenu=array();
            $contenu[0]=array('Non','Oui');
            $contenu[1]=array('Non','Oui');
            $form->setSelect("accord_tacite", $contenu);
            // geom *** a voir
            if ($maj == 1) { //modification
                $contenu=array();
                $contenu[0]=array("dossier", $this->getParameter("idx"));
                $form->setSelect('geom', $contenu);
            }
            // arrondissement recherche avancée
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "arrondissement",
                $this->get_var_sql_forminc__sql("arrondissement"),
                $this->get_var_sql_forminc__sql("arrondissement_by_id"),
                false
            );
            // dossier_autorisation_type_detaille recherche avancée
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "dossier_autorisation_type_detaille",
                $this->get_var_sql_forminc__sql("dossier_autorisation_type_detaille"),
                $this->get_var_sql_forminc__sql("dossier_autorisation_type_detaille_by_id"),
                false
            );
        }

        // Ce formulaire n'est pas accessible en ajout ni en recherche avancée
        // mais dans le cas où il le serait, rien ne doit être fait concernant
        // les taxes
        if ($maj != 0 && $maj != 999) {
            // Choix du secteur pour part communale
            $contenu = array();
            $contenu[0][0] = "";
            $contenu[1][0] = __('choisir')."&nbsp;".__("le")."&nbsp;".__("tax_secteur");
            if ($crud === 'read') {
                $contenu[1][0] = "";
            }
            // Instance du parmétrage des taxes
            $inst_taxe_amenagement = $this->get_inst_taxe_amenagement();
            // Si la colletivité à un paramétrage pour la taxe d'aménagement
            if ($inst_taxe_amenagement !== null) {
                // Il y a 20 secteurs maximum dans une commune de France
                for ($i=1; $i < 21; $i++) {
                    // Valeur du secteur
                    $value = $inst_taxe_amenagement->getVal('tx_comm_secteur_'.$i);
                    //
                    if ($value !== null && $value !== '') {
                        //
                        $contenu[0][$i] = $i;
                        $contenu[1][$i] = sprintf(__('Secteur %s'), $i);
                    }
                }
            }
            //
            $form->setSelect("tax_secteur", $contenu);
        }
        // commune
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "commune",
            $this->get_var_sql_forminc__sql("commune"),
            $this->get_var_sql_forminc__sql("commune_by_id"),
            false
        );
        // pec_metier
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "pec_metier",
            $this->get_var_sql_forminc__sql("pec_metier"),
            $this->get_var_sql_forminc__sql("pec_metier_by_id"),
            false
        );
        // etat_transmission_platau
        $contenu = array();
        $contenu[0] = array(
            'jamais_transmissible',
            'non_transmissible',
            'transmis_mais_non_transmissible',
            'transmissible',
        );
        $contenu[1] = array(
            __('Ne sera jamais transmis'),
            __('Non transmissible'),
            __('Déjà transmis mais non transmissible'),
            __('Transmissible'),
        );
        $form->setSelect("etat_transmission_platau", $contenu);
    }

    /**
     * SETTER_FORM - setLib.
     *
     * @return void
     */
    function setLib(&$form, $maj) {
        parent::setLib($form, $maj);
        // Les libellés généraux sont mis avant la modification des libellés
        // selon le contexte pour permettre de ne surcharger que les libellés
        // voulu et d'avoir les mêmes dans tous les autres cas.
        $form->setLib('accord_tacite',_("decision tacite"));
        $form->setLib('autorite_competente',_('competence'));
        $form->setLib('cle_acces_citoyen', _("cle_acces_citoyen"));
        $form->setLib('date_ait', _("Date d'AIT"));
        $form->setLib('date_audience', _("Date d'audience"));
        $form->setLib('date_complet', _("completude"));
        $form->setLib('date_contradictoire', _("Date de contradictoire"));
        $form->setLib('date_dernier_depot', _("dernier depot"));
        $form->setLib('date_derniere_visite', _("Date de dernière visite"));
        $form->setLib('date_limite_incompletude', _("limite d'instruction"));
        $form->setLib('date_premiere_visite', _("Date de 1ère visite"));
        $form->setLib('date_transmission_parquet', _('Date de transmission au Parquet'));
        $form->setLib('date_validite', _("fin de validite le"));
        $form->setLib('delai', _("delai (mois)"));
        $form->setLib('delai',_("delai d'instruction"));
        $form->setLib('nature_travaux',__('Nature des travaux'));
        $form->setLib('description_projet',_('description du projet'));
        $form->setLib('dossier_arrondissement', _("Arrondissement"));
        $form->setLib('dossier_autorisation_libelle',_('dossier_autorisation_libelle'));
        $form->setLib('dossier_autorisation_type_detaille', _("Type"));
        $form->setLib('contrevenants', _("Contrevenant(s)"));
        $form->setLib('dossier_instruction_type',_('type de dossier'));
        $form->setLib('dossier_petitionnaire',_('demandeur'));
        $form->setLib('dossier_petitionnaires', _("Pétitionnaire(s)"));
        $form->setLib('requerants', _("Requérant(s)"));
        $form->setLib('dt_ctx_infraction', _("Infraction"));
        $form->setLib('dt_ctx_regularisable', _("Régularisable"));
        $form->setLib('dt_ctx_synthese_anr', _("Synthèse des ANR"));
        $form->setLib('dt_ctx_synthese_nti', _("Synthèse des NTI"));
        $form->setLib('ctx_reference_dsj', _("ctx_reference_dsj"));
        $form->setLib('ctx_reference_sagace', _("ctx_reference_sagace"));
        $form->setLib('enjeu_ctx', _("contentieux"));
        $form->setLib('enjeu_erp', _("ERP"));
        $form->setLib('enjeu_urba', _("urbanisme"));
        $form->setLib('erp', _("ERP"));
        $form->setLib('geom',_('geolocalisaion'));
        $form->setLib('instructeur_2', _('Technicien'));
        $form->setLib('numero_versement_archive', _("numero"));
        $form->setLib('bailleur', _("Bailleur(s)"));
        $form->setLib('terrain', _("Localisation"));
        $form->setLib('etat_transmission_platau', __("Statut Plat'AU"));
        $form->setLib('lien_iiue_portal', '');
        $form->setLib('lien_iiue', '');
        $form->setLib('geoloc_latitude', __('Latitude (d° min.dec N/S)'));
        $form->setLib('geoloc_longitude', __('Longitude (d° min.dec E/O)'));
        $form->setLib('geoloc_rayon', __("Rayon d'emprise (m)"));
        $form->setLib('terrain_superficie_calculee', __("Superficie calculée (m²)"));

        $affichage_form = $this->get_type_affichage_formulaire();
        if ($affichage_form === 'ADS') {
            $form->setLib('date_decision', _("date de la decision"));
            $form->setLib('date_limite', _("limite d'instruction"));
            $form->setLib('instructeur_2', __("instructeur secondaire"));
        }
        if ($affichage_form === 'CTX IN') {
            $form->setLib('avis_decision', _("Décision"));
            $form->setLib('date_cloture_instruction', _("Date de clôture d'instruction"));
            $form->setLib('date_decision', _("Date de décision"));
            $form->setLib('date_depot', _("Date de réception"));
            $form->setLib('date_limite', _("Tacicité"));
            $form->setLib('instructeur',_('Juriste'));
        }
        if ($affichage_form === 'CTX RE') {
            $form->setLib('autorisation_contestee', _("Autorisation contestée"));
            $form->setLib('avis_decision', _("Décision"));
            $form->setLib('date_cloture_instruction', _("Date de clôture d'instruction"));
            $form->setLib('date_decision', _("Date de décision"));
            $form->setLib('date_depot', _("Date de recours"));
            $form->setLib('date_limite', _("Tacicité"));
            $form->setLib('instructeur',_('Juriste'));
        }
        if ($affichage_form === 'DPC') {
            $form->setLib('instructeur_2', __("instructeur secondaire"));
        }
        if ($affichage_form === 'CONSULTATION ENTRANTE') {
            $form->setLib('date_decision', _("date de la decision"));
            $form->setLib('date_limite', _("limite d'instruction"));
            //
            $form->setLib('delai_reponse', __('Délai de réponse'));
            $form->setLib('date_consultation', __('Date de la consultation'));
            $form->setLib('date_emission', __("Date d'émission"));
            $form->setLib('etat_consultation', __('État de la consultation'));
            $form->setLib('type_consultation', __('Type de la consultation'));
            $form->setLib('texte_fondement_reglementaire', __('Article(s) réglementaire sur le(s)quel(s) se fonde la consultation'));
            $form->setLib('texte_objet_consultation', __("Texte de l'objet de la consultation"));
            $form->setLib('service_consultant_id', __('Service consultant : identifiant'));
            $form->setLib('service_consultant_libelle', __('Service consultant : libellé'));
            $form->setLib('service_consultant_insee', __('Service consultant : INSEE'));
            $form->setLib('service_consultant_mail', __('Service consultant : mail'));
            $form->setLib('service_consultant_type', __('Service consultant : type'));
            $form->setLib('service_consultant__siren', __('Service consultant : SIREN'));

            $form->setLib('type_delai', __('Type de délai'));
            $form->setLib('objet_consultation', __('Objet de la consultation'));
            $form->setLib('date_production_notification', __('Date de production de la notification'));
            $form->setLib('date_premiere_consultation', __('Date de la première consultation'));
            $form->setLib('instructeur_2', __("instructeur secondaire"));
        }
    }

    function setOnchange(&$form,$maj){
        parent::setOnchange($form,$maj);
        // mise en majuscule
        $form->setOnchange("demandeur_nom","this.value=this.value.toUpperCase()");
        $form->setOnchange("demandeur_societe","this.value=this.value.toUpperCase()");
        $form->setOnchange("delegataire_nom","this.value=this.value.toUpperCase()");
        $form->setOnchange("delegataire_societe","this.value=this.value.toUpperCase()");
        $form->setOnchange("architecte_nom","this.value=this.value.toUpperCase()");
        $form->setOnchange("terrain_adresse","this.value=this.value.toUpperCase()");
        $form->setOnchange('terrain_surface','VerifNumdec(this)');
        $form->setOnchange('tax_mtn_part_commu', 'VerifFloat(this, 0)');
        $form->setOnchange('tax_mtn_part_depart', 'VerifFloat(this, 0)');
        $form->setOnchange('tax_mtn_part_reg', 'VerifFloat(this, 0)');
        $form->setOnchange('tax_mtn_total', 'VerifFloat(this, 0)');
        $form->setOnchange('tax_mtn_rap', 'VerifFloat(this, 0)');
        $form->setOnchange('tax_mtn_part_commu_sans_exo', 'VerifFloat(this, 0)');
        $form->setOnchange('tax_mtn_part_depart_sans_exo', 'VerifFloat(this, 0)');
        $form->setOnchange('tax_mtn_part_reg_sans_exo', 'VerifFloat(this, 0)');
        $form->setOnchange('tax_mtn_total_sans_exo', 'VerifFloat(this, 0)');
        $form->setOnchange('tax_mtn_rap_sans_exo', 'VerifFloat(this, 0)');
    }

    function setLayout(&$form, $maj) {

        // Récupère le CRUD
        $crud = $this->get_action_crud($this->getParameter("maj"));

        // Il n'y a pas d'affichage spécifique dans le cas d'une suppression
        if ($crud === 'delete') {
            return;
        }

        $affichage_form = $this->get_type_affichage_formulaire();
        if ($affichage_form === 'ADS' || $affichage_form === 'DPC' || $affichage_form === 'CONSULTATION ENTRANTE') {
            // Le contrôle de données est seulement possible si on est pas en mode service consulté.
            // et si le champ dossier_platau du dossier d'autorisation type detaillé est à true
            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && $this->f->is_type_dossier_platau($this->getVal('dossier_autorisation')) === true
                && $this->getVal('etat_transmission_platau') !== 'jamais_transmissible') {
                //
                $required_fields_platau = $this->check_platau_required_fields($this->getVal('dossier'));

                if (isset($required_fields_platau['is_ok']) && $required_fields_platau['is_ok'] === false) {
                    $class = 'demat-color demat-color-text';
                    $message = __("La transmission à Plat'AU n'est pas possible car certains champs requis ne sont pas saisis.");
                    if ($this->getVal('etat_transmission_platau') == "transmis_mais_non_transmissible") {
                        $message = __("La transmission des modifications à Plat'AU n'est pas possible car certains champs requis ne sont pas saisis.");
                    }
                    $this->f->display_panel_information($class, $message, $required_fields_platau['required_fields_empty'], __('Champs requis'), 'demat-color');
                }
            }
            // Hack : ferme la div form-content et ouvre une div en fin de formulaire
            //        pour ne pas casser le dom.
            //        Cela permet d'avoir des blocs au même niveau que le portlet et
            //        donc de pouvoir placer un bloc sous le portlet.
            $form->setBloc('lien_iiue', 'D');
            $form->setBloc('dossier', 'F');

            // Situé à gauche du portlet
            if($maj == 3) {
                $form->setBloc('om_collectivite', 'D', '', 'di-main');
            } else {
                $form->setBloc('om_collectivite', 'D', '', 'di-main-modification');

            }
                // Fieldset 1 : Dossier d'instruction
                $form->setFieldset('om_collectivite', 'D', __("Dossier d'instruction"));
                    // Bloc 1 : Collectivité + Autorité compétente - Début
                    $form->setBloc('om_collectivite', 'D', "", "localite-competence ");
                        $form->setBloc('om_collectivite', 'DF', "", "om_collectivite no-label");
                    $form->setBloc('autorite_competente', 'F');
                    // Fin Bloc 1
                    // Bloc 2: Dossier complet                     
                    $form->setBloc('dossier_libelle', 'D', "", "nom-complet-dossier block");
                        $form->setBloc('dossier_libelle', 'DF', "", "dossier_libelle no-label");
                        $form->setBloc('dossier_instruction_type', 'DF', "", "dossier_instruction_type no-label");
                    $form->setBloc('dossier_instruction_type', 'F');
                    // Fin Bloc 2
                    $form->setBloc('dossier_petitionnaire', 'DF', "", "dossier_petitionnaire no-label");
                    $form->setBloc('nature_travaux', 'DF', "", "nature_travaux no-label");
                $form->setFieldset('annee', 'F');
                // Fin Fieldset 1
                    
                // Fieldset 2 : Localisation
                $form->setFieldset('terrain_adresse_voie_numero', 'D', __("Localisation"), 'localisation');
                    // Bloc 1 : terrain
                    $form->setBloc('terrain_adresse_voie_numero', 'D', '', 'adresse-complete localisation-terrain');
                        // Bloc 1-1 : Adresse
                        $adresseHidden = '';
                        if ($maj == 3 && empty($this->getVal("terrain_adresse_voie_numero")) 
                            && empty($this->getVal("terrain_adresse_voie"))
                            && empty($this->getVal("terrain_adresse_lieu_dit"))
                            && empty($this->getVal("terrain_adresse_bp"))
                            && empty($this->getVal("terrain_adresse_code_postal"))
                            && empty($this->getVal("terrain_adresse_localite"))
                            && empty($this->getVal("terrain_adresse_cedex"))
                        ) {
                            $adresseHidden = "display-none";
                        }
                        $form->setBloc('terrain_adresse_voie_numero', 'D', __('Adresse'), "localisation-terrain-adresse " . $adresseHidden);
                            // N⁰ + voie - Début
                            $form->setBloc('terrain_adresse_voie_numero', 'D', '', "localisation-terrain--num-voie block");
                                $form->setBloc('terrain_adresse_voie_numero', 'DF', "", "terrain_adresse_voie_numero no-label");
                                $form->setBloc('terrain_adresse_voie', 'DF', "", "terrain_adresse_voie no-label");
                            $form->setBloc('terrain_adresse_voie', 'F');
                            // N⁰ + voie - Fin
                            $form->setBloc('terrain_adresse_lieu_dit', 'D', "", "terrain_adresse_lieu_dit_BP");
                                $form->setBloc('terrain_adresse_lieu_dit', 'DF', "", "terrain_adresse_lieu_dit no-label");
                            $form->setBloc('terrain_adresse_bp', 'F');
                            // CP + Localité - Début
                            $form->setBloc('terrain_adresse_code_postal', 'D', '', "localisation-terrain--cp-localite block");
                                $form->setBloc('terrain_adresse_code_postal', 'DF', "", "terrain_adresse_code_postal no-label");
                                $form->setBloc('terrain_adresse_localite', 'DF', "", "terrain_adresse_localite no-label");
                            $form->setBloc('terrain_adresse_localite', 'F');
                            // CP + Localité - Fin
                            $adresseNormaliseeHidden = $this->getVal("terrain") === '<br/>' ?  'display-none' : '';
                            $form->setBloc('terrain', 'DF', __("Adresse normalisée / Localisation"), 'localisation-terrain--adresse-normalisee no-label '.$adresseNormaliseeHidden);
                        $form->setBloc('terrain', 'F');
                        // Fin Bloc 1-1

                        // Bloc 1-2 :
                        $form->setBloc('parcelle_temporaire', 'D', __('Parcelle(s)'), "localisation-parcelle ");
                            $form->setBloc('parcelle_temporaire', 'D', '', "localisation-terrain-parcelle");
                            $form->setBloc('geoloc_longitude', 'F');
                            $form->setBloc('terrain_superficie', 'D', '', "localisation-terrain-parcelle");
                            $form->setBloc('geoloc_rayon', 'F');
                        $form->setBloc('geoloc_rayon', 'F');
                        // Fin Bloc 1-2
                    $form->setBloc('geoloc_rayon', 'F');
                    // Fin Bloc 1
                    // Bloc 2 : secteur
                    $form->setBloc('geom', 'D', "", "localisation-secteur");
                    $form->setBloc('tax_secteur', 'F');
                    // Fin Bloc 2 :
                $form->setFieldset('tax_secteur', 'F');
                // Fin Fieldset 2
                
                // Fieldset 3 : Instruction
                $form->setFieldset('instructeur', 'D', _('Instruction'), 'col_12');
                    // Bloc 1 : instructeur
                    $form->setBloc('instructeur', 'D', '', 'instructeur instruction-instructeur');
                        $form->setBloc('instructeur_2', 'DF', '', 'instructeur-secondaire');
                    $form->setBloc('division', 'F');
                    // Bloc 2 : suivi
                    $form->setBloc('date_depot', 'D', _('Suivi'), 'suivi instruction-suivi');
                        // Bloc 2-1 : suivi col 1
                        $form->setBloc('date_depot', 'D', '', 'col-1-suivi');
                        $form->setBloc('date_dernier_depot', 'F');
                        // Bloc 2-2 : suivi col 1
                        $form->setBloc('date_affichage', 'D', '', 'col-2-suivi');
                        $form->setBloc('date_complet', 'F');
                    $form->setBloc('date_complet', 'F');
                    // Bloc 3 : decision
                    $form->setBloc('date_decision', 'D', '', 'decision instruction-decision');
                        // Bloc 3-1 : decision col 1
                        $form->setBloc('date_decision', 'D', __('Décision'), 'instruction-decision-col_1');
                        $form->setBloc('avis_decision', 'F');
                        // Bloc 3-2 : validite-autorisation
                        $form->setBloc('date_validite', 'DF', __('Validité de l\'autorisation'), 'instruction-decision-validite-autorisation');
                    $form->setBloc('date_validite', 'F');
                $form->setFieldset('date_validite', 'F', '');
                // Fin Fieldset 3
            $form->setBloc('date_validite', 'F');

            // Situé sous le portlet
            
            if($maj == 3) {
                $form->setBloc('enjeu_urba', 'D', "", "di-aside");
            } else {
                $form->setBloc('enjeu_urba', 'D', "", "di-aside-modification");
            }
                // Fieldset 4 : Enjeu
                $form->setFieldset('enjeu_urba', 'D', __("Enjeu"));
                $form->setFieldset('enjeu_ctx', 'F');
                // Fieldset 5 : Qualification
                $form->setFieldset('erp', 'D', __("Qualification"));
                $form->setFieldset('etat_transmission_platau', 'F');
                // Fieldset 6 : Archive
                $form->setFieldset('numero_versement_archive', 'D', __("Archive"));
                $form->setFieldset('numero_versement_archive', 'F');
            $form->setBloc('numero_versement_archive', 'F');
            // TODO : ancien fieldset, vérifier si ils sont toujours d'actualité et si leur
            //        affichage est ok
            $form->setBloc('tax_mtn_part_commu', 'D', '', 'di-under');
                // Fieldset 7 : Simulation des taxes
                $form->setBloc('tax_mtn_part_commu', 'D', '', 'col_12');
                    $form->setFieldset('tax_mtn_part_commu', 'D', _("Simulation des taxes"), 'startClosed');
                    //
                    $form->setBloc('tax_mtn_part_commu', 'D', '', 'col_12');
                        $form->setFieldset('tax_mtn_part_commu', 'D', _("Taxe d'aménagement"), 'collapsible');
                        $form->setFieldset('tax_mtn_total_sans_exo', 'F', '');
                    $form->setBloc('tax_mtn_total_sans_exo', 'F');
                    //
                    $form->setBloc('tax_mtn_rap', 'D', '', 'col_12');
                        $form->setFieldset('tax_mtn_rap', 'D', _("Redevance d'archéologie préventive"), 'collapsible');
                        $form->setFieldset('tax_mtn_rap_sans_exo', 'F', '');
                    $form->setBloc('tax_mtn_rap_sans_exo', 'F');
                    //
                    $form->setFieldset('tax_mtn_rap_sans_exo', 'F', '');
                $form->setBloc('tax_mtn_rap_sans_exo', 'F');
                // Fieldset 8 : iDE’AU / codes de suivi
                $form->setBloc('lien_iiue_portal', 'D', '', 'col_12');
                $form->setFieldset('lien_iiue_portal', 'D', __("iDE'AU - Codes de suivi"), 'startClosed');
                $form->setFieldset('lien_iiue_portal', 'F', '');
                $form->setBloc('lien_iiue_portal', 'F');
                // Fieldset 9 : Plat'AU : identifiants techniques
                $form->setBloc('lien_iiue', 'D', '', 'col_12');
                $form->setFieldset('lien_iiue', 'D', __("Plat'AU - Identifiants techniques"), 'demat-color-fieldset startClosed');
                $form->setFieldset('lien_iiue', 'F', '');
                $form->setBloc('lien_iiue', 'F');
            $form->setBloc('lien_iiue', 'F');
        }
        // CONSULTATION ENTRANTE
        // Vérifie que le dossier a été déposé électroniquement
        if ($affichage_form === 'CONSULTATION ENTRANTE'
            && ($this->get_source_depot_from_demande() === PLATAU
                || $this->get_source_depot_from_demande() === PORTAL)) {
            // Fieldset "Consultation"
            $form->setBloc('consultation_entrante', 'D', '', 'col_12');
            $form->setFieldset('consultation_entrante', 'D', __('Consultation'), 'collapsible');
            $form->setBloc('consultation_entrante', 'D', "", "col_6");
            $form->setBloc('type_consultation', 'F');
            $form->setBloc('texte_fondement_reglementaire', 'D', "", "col_6");
            $form->setBloc('dossier_consultation', 'F');
            $form->setFieldset('dossier_consultation', 'F', '');
            $form->setBloc('dossier_consultation', 'F');
        }
        // RECOURS
        if ($affichage_form === 'CTX RE') {
            // Fieldset "Dossier d'Instruction"
            $form->setBloc('om_collectivite', 'D', '', ($maj == 3 ? 'col_9':'col_12'));
                $form->setFieldset('om_collectivite', 'D', _("Dossier d'instruction"));
                $form->setFieldset('etat_transmission_platau', 'F');
            $form->setBloc('etat_transmission_platau', 'F');

            // Fieldset "Archive"
            $form->setBloc('numero_versement_archive', 'D', '', 'col_12');
                $form->setFieldset('numero_versement_archive', 'DF', __("Archive"));
            $form->setBloc('numero_versement_archive', 'F', '');

            // Fieldset "Instruction"
            $form->setBloc('date_depot', 'D', '', 'col_12');
            $form->setFieldset('date_depot', 'D', _('Instruction'), 'col_12');

            // Fieldset "Suivi"
            $form->setBloc('date_depot', 'D', '', 'col_12');
            
                $form->setFieldset('date_depot', 'D', _('Suivi'), 'col_12');
                // Col 1
                $form->setBloc('date_depot', 'D', '', 'col_6');
                    // $form->setBloc('date_depot', 'D');
                    // $form->setBloc('date_dernier_depot', 'F');
                    // $form->setBloc('date_limite', 'D', '');
                    // $form->setBloc('date_limite_incompletude', 'F');
                $form->setBloc('date_cloture_instruction', 'F');
                // Col 2
                $form->setBloc('etat', 'D', '', 'col_6');
                    $form->setBloc('etat', 'D');
                    $form->setBloc('evenement_suivant_tacite_incompletude', 'F');
                    // $form->setBloc('evenement_suivant_tacite', 'D', '', 'evmt_suivant_tacite_di');
                    // $form->setBloc('evenement_suivant_tacite_incompletude', 'F');
                $form->setBloc('evenement_suivant_tacite_incompletude', 'F');
                $form->setFieldset('evenement_suivant_tacite_incompletude','F','');
            
            $form->setBloc('evenement_suivant_tacite_incompletude', 'F'); // Fin Suivi

            // Bloc 2 fieldsets
            $form->setBloc('date_decision', 'D', '', 'col_12');

            // Col 1 Fieldset "Décision"
            $form->setFieldset('date_decision', 'D', _('Decision'), 'col_12');
            $form->setFieldset('avis_decision','F',''); 
            // Col 2 Fieldset "Validité de l'autorisation"

            $form->setBloc('date_validite', 'F'); // Fin bloc 2 fieldsets

            $form->setFieldset('date_conformite','F','');
            $form->setBloc('date_conformite', 'F'); // Fin Instruction

            // Fieldset "Localisation"
            $form->setBloc('terrain_adresse_voie_numero', 'D', '', 'col_12');

                $form->setFieldset('terrain_adresse_voie_numero', 'D', _('Localisation'), 'startClosed');
                    // Col 1
                    $form->setBloc('terrain_adresse_voie_numero', 'D', "", "col_6");
                    $form->setBloc('geoloc_rayon', 'F');
                    // Col 2
                    $form->setBloc('terrain_adresse_voie', 'D', "", "col_6");
                    $form->setBloc('terrain_superficie_calculee', 'F');

                $form->setFieldset('terrain_superficie_calculee', 'F', '');

            $form->setBloc('terrain_superficie_calculee', 'F');
        }

        // INFRACTION
        if ($affichage_form === 'CTX IN') {

            // Fieldset "Dossier d'Instruction"
            $form->setBloc('om_collectivite', 'D', '', ($maj == 3 ? 'col_9':'col_12'));
                $form->setFieldset('om_collectivite', 'D', _("Dossier d'instruction"));
                $form->setFieldset('etat_transmission_platau', 'F');
            $form->setBloc('etat_transmission_platau', 'F');

            // Fieldset "Archive"
            $form->setBloc('numero_versement_archive', 'D', '', 'col_12');
            $form->setFieldset('numero_versement_archive', 'DF', __("Archive"));
            $form->setBloc('numero_versement_archive', 'F', '');

            // Fieldset "Instruction"
            $form->setBloc('date_depot', 'D', '', 'col_12');
            $form->setFieldset('date_depot', 'D', _('Instruction'));
                // Fieldset "Suivi"
                $form->setBloc('date_depot', 'D', '', '');
                    $form->setFieldset('date_depot', 'D', _('Suivi'), 'col_12');
                    // Col 1
                    $form->setBloc('date_depot', 'D', '', 'col_6');
                        $form->setBloc('date_depot', 'D');
                        $form->setBloc('date_dernier_depot', 'F');
                        $form->setBloc('date_limite', 'D', '', 'interligne');
                        $form->setBloc('date_limite_incompletude', 'F');
                    $form->setBloc('date_limite_incompletude', 'F');
                    // Col 2
                    $form->setBloc('etat', 'D', '', 'col_6');
                        $form->setBloc('etat', 'D');
                        $form->setBloc('etat', 'F');
                        $form->setBloc('evenement_suivant_tacite', 'D', '', 'evmt_suivant_tacite_di');
                        $form->setBloc('evenement_suivant_tacite_incompletude', 'F');
                    $form->setBloc('evenement_suivant_tacite_incompletude', 'F');
                    $form->setFieldset('evenement_suivant_tacite_incompletude','F','');
                $form->setBloc('evenement_suivant_tacite_incompletude', 'F'); // Fin Suivi
                // Fieldset "Décision"
                $form->setFieldset('date_decision', 'D', _('Decision'), 'col_12');
                $form->setFieldset('date_conformite','F',''); // Fin Décision
            $form->setFieldset('date_conformite','F','');
            $form->setBloc('date_conformite', 'F'); // Fin Instruction

            // Fieldset "Localisation"
            $form->setBloc('terrain_adresse_voie_numero', 'D', '', 'col_12');
                $form->setFieldset('terrain_adresse_voie_numero', 'D', _('Localisation'), 'startClosed');
                    // Col 1
                    $form->setBloc('terrain_adresse_voie_numero', 'D', "", "col_6");
                    $form->setBloc('geoloc_rayon', 'F');
                    // Col 2
                    $form->setBloc('terrain_adresse_voie', 'D', "", "col_6");
                    $form->setBloc('terrain_superficie_calculee', 'F');
                $form->setFieldset('terrain_superficie_calculee', 'F', '');
            $form->setBloc('terrain_superficie_calculee', 'F');

            // Fieldset "Demandeurs"
            // → cf. formSpecificContent()
        }
    }

    /**
     * Permet de retourner si le dossier est incomplet notifié
     *
     * @return boolean true si incomplet notifié
     */
    function is_incomplet_notifie() {
        // Si le dossier est défini en tant qu'incomplet notifie
        if($this->getVal('incomplet_notifie') == 't' AND
            $this->getVal('incompletude') == 't') {
            return true;
        }
        return false;
    }


    /**
     * Vérifie que le dossier d'instruction en cours ne soit pas instruit.
     * Ne sont pas compté comme instruit les dossiers n'ayant que des événements
     * d'instruction de type 'affichage'.
     *
     * @return boolean
     */
    function has_only_recepisse() {

        // Récupère la liste des instructions du dossier
        $list_instructions = $this->get_list_instructions(true);

        // Si le dossier a pour seule instruction le récépissé de la demande
        if (count($list_instructions) === 1
            && $list_instructions[0] === $this->get_demande_instruction_recepisse()) {
            //
            return true;
        }

        //
        return false;
    }


    /**
     * TRIGGER - triggerajouterapres.
     *
     * - Interface avec le référentiel ERP [108]
     * - Gestion des données techniques liées
     * - Mise à jour du DA
     * - Gestion des références cadastrales / parcelles liées
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // si la version du DI n'est pas zéro
        $version = $this->valF['version'];
        if (intval($version) > 0) {

            // récupération du DI qui vient d'être créé
            $di = $this->valF['dossier'];
            if (empty($di_inst = $this->f->findObjectById('dossier', $di))) {
                $this->addToMessage(sprintf(
                    __("Erreur lors de la récupération du DI %s (dossier non-trouvé)"),
                    $di));
                $this->correct = false;
                return false;
            }

            $collectivite = $this->valF['om_collectivite'];
            $da = $this->valF['dossier_autorisation'];
            $commune = $this->f->get_submitted_post_value("commune");

            $ret = $di_inst->replicate_geolocalisation($di, $da, $collectivite, $commune);
            if (is_string($ret)) {
                $this->addToMessage($ret);
            }
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[108] Dépôt de dossier DAT -> AT
         * Déclencheur :
         *  - L'option ERP est activée
         *  - Validation du formulaire d'ajout d'une demande de nouveau dossier
         *    de type AT
         */
        //
        if ($this->f->is_option_referentiel_erp_enabled($this->valF['om_collectivite']) === true
            && $this->f->getDATCode($this->valF['dossier']) == $this->f->getParameter('erp__dossier__nature__at')) {
            //
            $infos = array(
                "dossier_instruction" => $this->valF['dossier'],
            );
            //
            $ret = $this->f->send_message_to_referentiel_erp(108, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (108) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (108) du référentiel ERP OK."));
        }

        /**
         * Gestion des données techniques liées.
         */
        // On ajoute les données techniques
        if ($this->ajoutDonneesTechniquesDI($id, $val) === false) {
            //
            $this->addToMessage(_("Erreur lors de l'enregistrement du dossier.")." "._("Contactez votre  administrateur."));
            $this->correct = false;
            return false;
        }

        /**
         * Mise à jour des données du DA.
         */
        //
        $inst_da = $this->get_inst_dossier_autorisation($this->valF["dossier_autorisation"]);
        //
        $params = array(
            'di_id' => $this->valF[$this->clePrimaire],
        );
        if ($inst_da->majDossierAutorisation($params) === false) {
            //
            $this->addToMessage(_("Erreur lors de la mise a jour des donnees du dossier d'autorisation. Contactez votre administrateur."));
            $this->correct = false;
            return false;
        }

        /**
         * Gestion des références cadastrales / parcelles liées.
         */
        // Si le champ des références cadastrales n'est pas vide
        if ($this->valF['terrain_references_cadastrales'] != '') {
            // Ajout des parcelles dans la table dossier_parcelle
            $this->ajouter_dossier_parcelle(
                $this->valF['dossier'],
                $this->valF['terrain_references_cadastrales']
            );
        }

        /**
         * Notification de l'éventuelle autorisation contestée
         */
        if ($this->valF['autorisation_contestee'] !== null) {
            // Instancie la classe dossier_message
            $dossier_message = $this->get_inst_dossier_message(']');
            // Ajoute le message de notification
            $dossier_message_val = array(
                'dossier' => $this->valF['autorisation_contestee'],
                'type' => __('Autorisation contestée'),
                'emetteur' => $this->f->get_connected_user_login_name(),
                'login' => $_SESSION['login'],
                'date_emission' => date('Y-m-d H:i:s'),
                'contenu' => sprintf(
                    __('Cette autorisation a été contestée par le recours %s.'),
                    $this->valF['dossier']
                )
            );
            // Si une erreur se produit lors de l'ajout
            if ($dossier_message->add_notification_message($dossier_message_val, false, true) !== true) {
                // Message d'erreur affiché à l'utilisateur
                $this->addToMessage(_("L'autorisation contestée n'a pas pu être notifiée du recours."));
                $this->correct = false;
                return false;
            }
        }
        // Gestion dossier operateur liées.
        //
        // En mode service consulté, on ajoute suite à la création du dossier un
        // élément dans la table dossier_operateur qui permettra par la suite d'effectuer
        // la désignation de l'opérateur
        if ($this->f->is_option_mode_service_consulte_enabled() === true) {
            // On ajoute le dossier opérateur
            if ($this->ajoutDossierOperateurDI($id, $val) === false) {

                $this->addToMessage(_("Erreur lors de l'enregistrement du dossier.")." "._("Contactez votre  administrateur."));
                $this->correct = false;
                return false;
            }
        }

        /**
         * Gestion des tâches pour la dématérialisation
         */
        //
        if ($this->f->is_type_dossier_platau($this->valF['dossier_autorisation'])
            && $this->valF['etat_transmission_platau'] !== 'jamais_transmissible') {
            // Pour les dossiers d'instruction dont la source de dépôt est différent de PLAT'AU
            if (isset($val['source_depot']) === false || $val['source_depot'] !== PLATAU) {
                // Gérer l'ajout du DA si pas lié à un objet PLAT'AU
                // Nécessaire pour les dossiers d'instruction sur existant dont l'initial n'est pas
                // transmis à PLAT'AU
                $inst_lien = $this->f->get_inst__om_dbform(array(
                    "obj" => "lien_id_interne_uid_externe",
                    "idx" => ']',
                ));
                $is_exists = $inst_lien->is_exists('dossier_autorisation', $inst_da->getVal('dossier_autorisation'));
                if (! $is_exists) {
                    $inst_task = $this->f->get_inst__om_dbform(array(
                        "obj" => "task",
                        "idx" => 0,
                    ));
                    $task_val = array(
                        'type' => 'creation_DA',
                        'object_id' => $inst_da->getVal('dossier_autorisation'),
                        'dossier' => $inst_da->getVal('dossier_autorisation'),
                    );
                    // Si le mode service consulté n'est pas activé
                    // et que le dossier est dans l'état 'non_transmissible'
                    if ($this->f->is_option_mode_service_consulte_enabled() === false
                        && $this->valF['etat_transmission_platau'] === 'non_transmissible') {
                        // Passage du statut de la task en draft
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
                }

                // Ajout de la task creation_DI
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => 0,
                ));
                $task_val = array(
                    'type' => 'creation_DI',
                    'object_id' => $id,
                    'dossier' => $id,
                );
                // Si le mode service consulté n'est pas activé
                // et que le dossier est dans l'état 'non_transmissible'
                if ($this->f->is_option_mode_service_consulte_enabled() === false
                    && $this->valF['etat_transmission_platau'] === 'non_transmissible') {
                    // Passage du statut de la task en draft
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
            }
            // Pour les dossier d'instruction dont la source de dépôt est PLAT'AU
            if (isset($val['source_depot']) === true && $val['source_depot'] == PLATAU) {
                //
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => 0,
                ));
                $task_val = array(
                    'type' => 'modification_DI',
                    'object_id' => $id,
                    'dossier' => $id,
                );
                $add_task = $inst_task->add_task(array('val' => $task_val));
                if ($add_task === false) {
                    $this->addToMessage(sprintf('%s %s',
                        __("Une erreur s'est produite lors de la création tâche."),
                        __("Veuillez contacter votre administrateur.")
                    ));
                    $this->correct = false;
                    return false;
                }
            }
            // Dans tous les cas
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => 'depot_DI',
                'object_id' => $id,
                'dossier' => $id,
            );
            // Change l'état de la tâche de notification en fonction de l'état de
            // transmission du dossier d'instruction
            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && $this->valF['etat_transmission_platau'] === 'non_transmissible') {
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
        }
        // Ajout automatique des acteurs au dossier si l'option est activée
        if ($this->f->is_option_enabled('option_module_acteur') === true) {
            if ($this->add_dossier_actors($id) === false) {
                $this->addToMessage(__('ATTENTION : Les acteurs n\'ont pas été rattachés au dossier.'));
            }
        }

        // On duplique les nature du travaux du dossier initial ou du dernier dossier clôturé

        // Récupération du numéro de dossier initial ou dernier dossier clôturé
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier.dossier
                FROM
                    %1$sdossier
                WHERE
                    dossier.dossier_autorisation = \'%2$s\'
                    AND dossier.dossier != \'%3$s\'
                ORDER BY
                    dossier.version DESC,
                    dossier.date_depot DESC
                LIMIT 1',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->valF['dossier_autorisation']),
                $id
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            return false;
        }
        $di_id = $qres['result'];
        // Duplication des lien de nature de travaux pour le nouveau dossier
        if ($this->lienNatureTravauxDossierInstruction($di_id, $id) === false) {
                $this->addToMessage(sprintf('%s %s',
                    __("Une erreur s'est produite lors de l'ajout des nature de travaux sur le nouveau dossier."),
                    __("Veuillez contacter votre administrateur.")
                ));
                $this->correct = false;
                return false;
        }
        return true;
    }

    /**
     * Gestion des liens entre les natures de travaux et le nouveau dossier
     **/
    function lienNatureTravauxDossierInstruction($di_orig, $di_id) {
        $inst_ldnt = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_dossier_nature_travaux",
            "idx" => "]",
        ));

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$slien_dossier_nature_travaux INNER JOIN %1$snature_travaux ON nature_travaux.nature_travaux = lien_dossier_nature_travaux.nature_travaux INNER JOIN %1$slien_dit_nature_travaux ON lien_dossier_nature_travaux.nature_travaux = lien_dit_nature_travaux.nature_travaux
                WHERE
                    dossier = \'%2$s\' AND lien_dit_nature_travaux.dossier_instruction_type = %3$d',
                DB_PREFIXE,
                $di_orig,
                $this->valF['dossier_instruction_type']
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $liens_dossier_nature_travaux = $qres["result"];
        $valnaturetravaux = array();
        
        foreach ($liens_dossier_nature_travaux as $lien) {
            $valnaturetravaux['lien_dossier_nature_travaux'] = '';
            $valnaturetravaux['dossier'] = $di_id;
            $valnaturetravaux['nature_travaux'] = $lien['nature_travaux'];

            if ($inst_ldnt->ajouter($valnaturetravaux) === false) {
                $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter le lien entre la nature de travaux et le dossier d'instruction.", DEBUG_MODE);
                return false;
            }
        }

        return true;
    }


    /**
     * Ajoute à l'aide d'une requête sql tous les acteurs (lien dossier - tiers) paramétrés pour
     * être ajoutés automatiquement.
     *
     * Pour être ajoutés automatiquement un acteur doit :
     *  - avoir une catégorie paramétré en tant qu'ajout automatique pour le type de DI du dossier
     *  - avoir une catégorie liée à la même collectivité que celle du dossier
     *  - accepter les notifications par mail
     *  - ne pas avoir d'uid platau ou sa liste d'uid ne doit pas contenir celui de la consultation
     *  entrante (acteur != du service en charge du dossier)
     *  - ne pas avoir d'habilitation en cours de validité
     *    OU avoir une (ou +) habilitation sans division territoriale (commune ou département)
     *    OU avoir une (ou +) habilitation avec division territoriale commune lié à la commune du dossier
     *    OU avoir une (ou +) habilitation avec division territoriale département lié au département du dossier
     *
     * @param string $idDossier : identifiant du dossier
     * @return boolean résultat de l'ajout. true : ok, false : l'ajout a échoué
     */
    protected function add_dossier_actors($idDossier) {
        // Sql de récupération de tous les acteurs qui doivent automatiquement être associé au dossier.
        $actor_auto_dossier_sql = sprintf(
            'SELECT DISTINCT
                nextval(\'%1$slien_dossier_tiers_seq\') AS lien_dossier_tiers_seq,
                dossier.dossier,
                tiers_consulte.tiers_consulte
            FROM
                %1$stiers_consulte
                INNER JOIN %1$scategorie_tiers_consulte
                    ON tiers_consulte.categorie_tiers_consulte = categorie_tiers_consulte.categorie_tiers_consulte
                -- Filtre les tiers a ajouter automatiquement au dossier
                INNER JOIN %1$slien_dossier_instruction_type_categorie_tiers
                    ON lien_dossier_instruction_type_categorie_tiers.ajout_automatique IS TRUE
                        AND categorie_tiers_consulte.categorie_tiers_consulte = lien_dossier_instruction_type_categorie_tiers.categorie_tiers
                INNER JOIN %1$slien_categorie_tiers_consulte_om_collectivite
                    ON categorie_tiers_consulte.categorie_tiers_consulte = lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte
                -- Filtre les tiers dont la collectivité et le type correspondent à celle du dossier
                INNER JOIN %1$sdossier
                    ON lien_dossier_instruction_type_categorie_tiers.dossier_instruction_type = dossier.dossier_instruction_type
                        AND lien_categorie_tiers_consulte_om_collectivite.om_collectivite = dossier.om_collectivite
                        AND dossier.dossier = \'%2$s\'
                -- Filtre pour garder uniquement les habilitations en cours de validité
                LEFT JOIN %1$shabilitation_tiers_consulte
                    ON tiers_consulte.tiers_consulte = habilitation_tiers_consulte.tiers_consulte
                        AND (habilitation_tiers_consulte.om_validite_debut IS NULL
                                OR habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE)
                            AND (habilitation_tiers_consulte.om_validite_fin IS NULL
                                OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)
                -- Récupère uniquement les habilitations liées à la commune du dossier
                LEFT JOIN %1$slien_habilitation_tiers_consulte_commune
                    ON dossier.commune = lien_habilitation_tiers_consulte_commune.commune
                        AND habilitation_tiers_consulte.habilitation_tiers_consulte = lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte
                -- Récupère uniquement les habilitations liées au département du dossier
                LEFT JOIN %1$scommune
                    ON dossier.commune = commune.commune
                LEFT JOIN %1$sdepartement
                    ON commune.dep = departement.dep
                LEFT JOIN %1$slien_habilitation_tiers_consulte_departement
                    ON departement.departement = lien_habilitation_tiers_consulte_departement.departement
                        AND habilitation_tiers_consulte.habilitation_tiers_consulte = lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte
            WHERE
                -- Garde les tiers notifiable ayant un id platau différent de celui du service consultant du dossier
                tiers_consulte.accepte_notification_email IS TRUE
                AND tiers_consulte.liste_diffusion IS NOT NULL
                AND TRIM(tiers_consulte.liste_diffusion) != \'\'
                -- Garde les tiers n ayant pas d habilitation en cours de validite
                -- OU ayant une habilitation liée à la commune du dossier
                -- OU ayant une habilitation liée au département d appartenance de la commune du dossier
                -- OU n étant lié à aucune commune ou département
                AND (
                    -- Pas d habilitation en cours de validité
                    habilitation_tiers_consulte.habilitation_tiers_consulte IS NULL
                    OR (-- Habilitation associée à la commune du dossier
                        lien_habilitation_tiers_consulte_commune.lien_habilitation_tiers_consulte_commune IS NOT NULL
                        -- Habilitation associée au département du dossier
                        OR lien_habilitation_tiers_consulte_departement.lien_habilitation_tiers_consulte_departement IS NOT NULL
                        -- Habilitation non liée à une commune ou à un département
                        OR (NOT EXISTS(
                                SELECT lien_habilitation_tiers_consulte_departement
                                FROM %1$slien_habilitation_tiers_consulte_departement AS lhtcd
                                WHERE lhtcd.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte)
                            AND NOT EXISTS(
                                SELECT lien_habilitation_tiers_consulte_commune
                                FROM %1$slien_habilitation_tiers_consulte_commune AS lhtcc
                                WHERE lhtcc.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte))))',
            DB_PREFIXE,
            $this->f->db->escapeSimple($idDossier)
        );
        // Création d'un lien entre le dossier et les tiers pour chaque tiers en ajout auto
        $qres = $this->f->execute_db_query(
            sprintf(
                'INSERT INTO %1$slien_dossier_tiers (lien_dossier_tiers, dossier, tiers)
                (%2$s)
                ON CONFLICT (dossier,tiers) DO NOTHING',
                DB_PREFIXE,
                $actor_auto_dossier_sql
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        return $qres['code'] === 'OK';
    }

    /**
     * Permet de vérifier que les champs requis pour platau ont été saisis
     * et si oui mettre à jour le statut des taches à new
     * 
     * @param  string  $dossier        L'identifiant du dossier.
     * @param  string  $add_or_update  Permet de déterminer si on est en ajout ou en modification
     * 
     * @return  bool  true|false
     */
    function trigger_platau_required_fields($dossier) {
        // Vérification des champs Plat'AU requis pour transmission 
        $is_required_fields_fulfilled = $this->check_platau_required_fields($dossier);

        // On récupère l'identifiant du dossier d'autorisation en fonction 
        // de si on est en ajout ou en modification
        $dossier_autorisation = $this->getVal('dossier_autorisation') != "" ? $this->getVal('dossier_autorisation') : $this->valF['dossier_autorisation'];
        
        $inst_task = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));

        // Si les champs requis sont saisis on met à jour le flag
        // etat_transmission_platau à transmissible pour indiquer 
        // que le dossier peut être transmis à Plat'AU et on met
        // l'état des tâches draft en new
        if ($is_required_fields_fulfilled['is_ok']) {
            // Valeurs à mettre à jour
            $valF = array();
            $valF['etat_transmission_platau'] = 'transmissible';

            // Met à jour le quartier du dossier
            $cle = " dossier='".$dossier."'";
            $res = $this->f->db->autoExecute(
                DB_PREFIXE.'dossier', $valF, DB_AUTOQUERY_UPDATE, $cle);
            $this->addToLog(__METHOD__."(): db->autoexecute(\""
                .DB_PREFIXE."dossier\", ".print_r($valF, true)
                .", DB_AUTOQUERY_UPDATE, \"".$cle."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true)) {
                return false;
            }
            $this->update_task_state($dossier, 'draft', 'new', $dossier_autorisation);
        }
        // Si les champs requis ne sont pas saisis on marque 
        // le dossier comme non transmissible ou transmis mais non transmissible
        // et on met l'état des tâches new en draft
        if (! $is_required_fields_fulfilled['is_ok']) {
            $valF = array();
            if ($inst_task->task_exists('creation_DI', $dossier)) {
                $valF['etat_transmission_platau'] = 'non_transmissible';
            } else {
                $valF['etat_transmission_platau'] = 'transmis_mais_non_transmissible';
            }

            // Met à jour le quartier du dossier
            $cle = " dossier='".$dossier."'";
            $res = $this->f->db->autoExecute(
                DB_PREFIXE.'dossier', $valF, DB_AUTOQUERY_UPDATE, $cle);
            $this->addToLog(__METHOD__."(): db->autoexecute(\""
                .DB_PREFIXE."dossier\", ".print_r($valF, true)
                .", DB_AUTOQUERY_UPDATE, \"".$cle."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true)) {
                return false;
            }
            $this->update_task_state($dossier, 'new', 'draft', $dossier_autorisation);
        }

        return true;
    }

    /**
     * TODO: replace with '$this->f->findObjectById' ?
     *
     * Récupère l'instance de dossier message.
     *
     * @param string $dossier_message Identifiant du message.
     *
     * @return object
     */
    private function get_inst_dossier_message($dossier_message = null) {
        //
        return $this->get_inst_common("dossier_message", $dossier_message);
    }

    /**
     * Récupère l'identifiant du quartier et de l'arrondissement depuis le code
     * impôt.
     *
     * @param string $code_impots Code impôt du quartier
     * 
     * @return array
     */
    public function get_quartier_arrondissement_by_code_impot($code_impot) {
        if (empty($code_impot) === true) {
            return null;
        }
        $query = sprintf('
            SELECT
                quartier,
                arrondissement
            FROM
                %1$squartier
            WHERE
                code_impots = \'%2$s\'',
            DB_PREFIXE,
            $code_impot
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] !== 'KO' &&
            count($res['result']) > 0) {
            //
            return $res['result'][0];
        }
        return null;
    }

    /**
     * Retourne l'intructeur correspondant le mieux à la parcelle.
     *
     * @param int    $quartier           le numéro de quartier
     * @param int    $arrondissement     le numéro d'arrondissement
     * @param string $section            la section
     * @param int    $dadt               le type détaillé de dossier d'autorisation
     * @param int    $collectivite       l'identifiant de la collectivité
     * @param int    $commune_id         l'identifiant de la commune (optionel)
     * @param int    $demande_type       l'identifiant du type de demande (optionel)
     *
     * @return array contenant l'instructeur, et éventuellement sa division
     */
    public function getInstructeurDivision (
            int $quartier, int $arrondissement, $section,
            int $dadt, int $collectivite, int $commune_id = 0, int $demande_type = 0) : array {

        // requête de récupération de l'instructeur à affecter
        // (exclu les affectations manuelles supposées avoir été utilisées avant)
        $sql = sprintf('
            SELECT
                instructeur, instructeur_2, section, quartier, arrondissement, dossier_autorisation_type_detaille, dossier_instruction_type
            FROM
                %1$saffectation_automatique AS AA
            WHERE
                (AA.affectation_manuelle IS NULL OR AA.affectation_manuelle = \'\')
                AND AA.instructeur IS NOT NULL
            ',
            DB_PREFIXE
        );

        // si l'identifiant de la demande_type est spécifié, récupère
        // le type de dossier d'instruction
        $dit = null;
        if (empty($demande_type) === false && $demande_type !== 0) {
            $demande_type_inst = $this->f->get_inst__om_dbform(array(
                "obj" => "demande_type",
                "idx" => $demande_type,
            ));
            $dit = $demande_type_inst->getVal('dossier_instruction_type');
        }

        // ajoute les conditions SQL correspondantes aux paramètres de filtrage
        foreach(array(
                'om_collectivite ' => $collectivite,
                'dossier_autorisation_type_detaille' => $dadt,
                'dossier_instruction_type' => $dit,
                'quartier' => $quartier,
                'arrondissement' => $arrondissement,
                'section' => $section
                ) as $column => $value) {
            if (empty($value) === false) {
                if ($column == 'section') {
                    $valType = 's'; // string
                    $value = $this->f->db->escapeSimple($value);
                } else {
                    $valType = 'd'; // int
                    $value = intval($value);
                }
                $sql .= sprintf(" AND (AA.$column IS NULL OR AA.$column = '%$valType') ",
                                $value);
            }
            else {
                $sql .= " AND AA.$column IS NULL ";
            }
        }
        if (!empty($commune_id) && $this->f->is_option_dossier_commune_enabled()) {
            $commune = $this->f->findObjectById('commune', $commune_id);
            if (!empty($commune)) {
                $code_departement = $commune->getVal('dep');
                $code_commune = preg_replace('/^'.$code_departement.'/', '', $commune->getVal('com'));
                $sql .= sprintf(
                    " AND (AA.communes IS NULL OR AA.communes ~ '%s') ",
                    "(^|,)$code_departement($code_commune)?(,|$)");
            }
            else {
                $this->addToLog(__METHOD__."(): commune '$commune_id' non trouvée", DEBUG_MODE);
            }
        }

        // ordonnancement et limite à un seul résultat
        $sql .= sprintf("
            ORDER BY
                communes %s,
                dossier_instruction_type %s,
                dossier_autorisation_type_detaille %s,
                quartier %s,
                section %s,
                arrondissement %s
            LIMIT 1
            ",
            // on positionne les valeurs NULL en premier si le filtre sur ce champ n'a pas été saisi
            $commune_id === 0 ? 'NULLS FIRST' : '',
            $dit === 0 ? 'NULLS FIRST' : '',
            $dadt === 0 ? 'NULLS FIRST' : '',
            $quartier === 0 ? 'NULLS FIRST' : '',
            empty($section) === true ? 'NULLS FIRST' : '',
            $arrondissement === 0 ? 'NULLS FIRST' : ''
        );

        // exécution de la requête
        $res = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        $result = $res['result'];

        // si on a récupéré un instructeur correspondant aux critères
        if (is_array($result) && count($result) > 0) {

            $instructeur = $this->f->get_inst__om_dbform(array(
                'obj' => 'instructeur',
                'idx' => $result[0]['instructeur'],
            ));
            $divisionId = $instructeur->getVal('division');

            // s'il a une division, retourne l'instructeur et sa division
            if (empty($divisionId) === false) {
                return array(
                    'instructeur' => $result[0]['instructeur'],
                    'instructeur_2' => $result[0]['instructeur_2'],
                    'division' => $divisionId,
                );
            }

            // aucune division trouvée, retour uniquement l'instructeur
            return array(
                'instructeur' => $result[0]['instructeur'],
                'instructeur_2' => $result[0]['instructeur_2'],
            );
        }

        return array();
     }

     /**
      * Récupère le type détaillé d'une dossier d'autorisation.
      *
      * @param string $dossier_autorisation DA
      *
      * @return string identifiant du type détaillé de dossier d'autorisation
      */
     function get_dossier_autorisation_da_type_detaille($dossier_autorisation) {
        //Récupération du dossier_autorisation_type_detaille concerné par le 
        //$dossier_autorisation
        $dossierAutorisation = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => $dossier_autorisation
        ));
        return $dossierAutorisation->getVal('dossier_autorisation_type_detaille');
    }

    /**
     * Cette méthode permet de gérer l'affectation du dossier.
     * Deux cas sont gérées :
     *  - l'affectation a été sélectionnée par l'utilisateur
     *  - l'affectation est réalisé automatiquement
     * 
     * Renvoie un tableau associatif contenant l'instructeur, la division et
     * l'instructeur secondaire du dossier.
     * 
     * Ex : array(
     *          'instructeur' => id_instructeur,
     *          'instructeur_2' => id_instructeur_2,
     *          'division' => id_division
     *      )
     *
     * @param array valeurs récupérées à l'ajout du dossier
     * @return array tableau contenant l'affectation du dossier
     */
    protected function affectation_dossier($val) {
        $affectation = array(
            'instructeur' => null,
            'instructeur_2' => null,
            'division' => null,
        );
        // Cas 1 : Vérifie si une valeur d'affectation automatique
        // existe. Si c'est le cas c'est que l'affectation a été choisie
        // par l'utilisateur.
        // Il s'agit donc d'une affectation manuelle
        if (empty($val['affectation_automatique']) === false) {
            // Récupération de l'affectation automatique correspondante
            $idAffectationAuto = intval($val['affectation_automatique']);
            // Préparation des logs
            $logMsg = __METHOD__."(): affectation automatique '$idAffectationAuto' ".
                "non trouvée";
            $logMsgMode = DEBUG_MODE;

            $affectationAuto = $this->f->get_inst__om_dbform(array(
                "obj" => "affectation_automatique",
                "idx" => $idAffectationAuto
            ));
            // Vérifie que l'affectation automatique a été correctement récupérée en regardant
            // si l'objet instancié a un identifiant non null
            if (empty($affectationAuto->getVal($affectationAuto->clePrimaire)) === false) {
                // log si l'instructeur n'est pas défini
                $logMsg = __METHOD__."(): affectation automatique '$idAffectationAuto' ".
                          "pas d'instructeur défini";
                // On cherche maintenant à récupérer l'instructeur principal visé par cette affectation
                // et sa division
                $instructeurId = $affectationAuto->getVal('instructeur');
                if (! empty($instructeurId)) {
                    // log si l'instructeur n'existe pas
                    $logMsg = __METHOD__."(): affectation automatique '$idAffectationAuto' ".
                              "instructeur '$instructeurId' non trouvé";
                    // De la même manière que pour l'affectation automatique on instancie
                    // l'instructeur avec l'identifiant issus de l'affectation et on vérifie
                    // si l'instructeur a bien été récupéré.
                    $instructeur = $this->f->get_inst__om_dbform(array(
                        "obj" => "instructeur",
                        "idx" => intval($instructeurId)
                    ));
                    if (empty($instructeur->getVal($instructeur->clePrimaire)) === false) {
                        // Récupération de l'identifiant et de la division de l'instructeur principal
                        $affectation['instructeur'] = $instructeurId;
                        $affectation['division'] = $instructeur->getVal('division');

                        // log le succès
                        $logMsg = __METHOD__."(): affectation automatique '$idAffectationAuto' ".
                                  "instructeur [".$affectation['instructeur']."] ".
                                  "'".$instructeur->getVal('nom')."' affecté, avec sa division ".
                                  "'".$affectation['division']."'";
                        $logMsgMode = EXTRA_VERBOSE_MODE;
                    }
                }
                // Affichage des log de la récupération de l'instructeur principal et de sa division
                $this->addToLog($logMsg, $logMsgMode);

                // Si l'affectation donne aussi un instructeur secondaire on le récupère
                $instructeur2Id = $affectationAuto->getVal('instructeur_2');
                // log si aucun instructeur secondaire est défini
                $logMsg = __METHOD__."(): affectation automatique '$idAffectationAuto' ".
                          "pas de second instructeur défini";
                $logMsgMode = EXTRA_VERBOSE_MODE;
                if (empty($instructeur2Id) === false) {
                    // log si l'instructeur n'existe pas
                    $logMsg = __METHOD__."(): affectation automatique '$idAffectationAuto' ".
                             "second instructeur '$instructeur2Id' non trouvé";
                    $logMsgMode = DEBUG_MODE;
                    // Instancie l'instructeur secondaire et vérifie si il a bien été récupéré
                    $instructeur2 = $this->f->get_inst__om_dbform(array(
                        "obj" => "instructeur",
                        "idx" => intval($instructeur2Id)
                    ));
                    if (empty($instructeur2) === false) {
                        // Récupération de l'identifiant l'instructeur secondaire
                        $affectation['instructeur_2'] = $instructeur2Id;

                        // log le succès
                        $logMsg = __METHOD__."(): affectation automatique '$idAffectationAuto' ".
                                  "second instructeur [".$affectation['instructeur_2']."] ".
                                  "'".$instructeur2->getVal('nom')."' affecté";
                        $logMsgMode = EXTRA_VERBOSE_MODE;
                    }
                }
                // Affichage des log de la récupération de l'instructeur secondaire
                $this->addToLog($logMsg, $logMsgMode);

                // succès : plus rien à logger
                $logMsg = null;
                $logMsgMode = null;
            }

            // affectation automatique inexistante
            if (empty($logMsg) === false && empty($logMsgMode) === false) {
                $this->addToLog($logMsg, $logMsgMode);
            }
        }


        // Cas 2 : Si aucune affectation automatique n'a été choisi alors on cherche la plus adaptée

        // si l'instructeur n'a pas déjà été récupéré et si on a pas de numéro de dossier d'autorisation
        // alors l'affectation ne pourra pas être effectué sur ce dossier
        if (empty($affectation['instructeur']) === true
            && empty($val['dossier_autorisation']) === false) {

            // Sinon on récupère le type détaillé du DA
            $dadt = $this->get_dossier_autorisation_da_type_detaille($val['dossier_autorisation']);

            // si la commune est spécifiée
            $commune_id = 0;
            if (isset($val['commune']) && $this->f->is_option_dossier_commune_enabled()) {
                $commune_id = $val['commune'];
            }

            // récupération de l'instructeur ainsi que de sa division
            $instructeurDivision = $this->getInstructeurDivision(
                intval($val['quartier']),
                intval($val['arrondissement']),
                $val['section'],
                intval($dadt),
                intval($val['om_collectivite']),
                intval($commune_id),
                intval($val['demande_type'])
            );

            if (! empty($instructeurDivision['instructeur']) === true &&
                    ! empty($instructeurDivision['division']) === true) {
                $affectation['instructeur'] = $instructeurDivision['instructeur'];
                $affectation['division'] = $instructeurDivision['division'];
            }

            if (isset($instructeurDivision['instructeur_2']) === true
                && empty($instructeurDivision['instructeur_2']) === false) {
                //
                $affectation['instructeur_2'] = $instructeurDivision['instructeur_2'];
            }
        }
        
        // Préviens l'utilisateur si l'affectation du dossier n'a pas pu être réalisée.
        if (empty($affectation['instructeur']) === true) {
            $affMsg = "<br/> "._("Aucun instructeur compatible avec ce dossier trouve, ".
            "contactez votre administrateur afin d'en assigner un ".
            "a ce dossier.")." <br/>";

            if ($this->f->isAccredited("dossier_modifier_instructeur") === true) {
                $affMsg = "<br/> "._("Pensez a assigner un instructeur a ce dossier.")." <br/>";
            }
            $this->addToMessage($affMsg);
        }

        return $affectation;
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * - Interface avec le référentiel ERP [101]
     * - Interface avec le référentiel ERP [102][103]
     * - Interface avec le référentiel ERP [114]
     * - Gestion des demandeurs liés
     * - Gestion des références cadastrales / parcelles liées
     * - Gestion des taxes
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

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
                $this->addToMessage(__("Mise à jour des liaisons realisée avec succès."));
            }
        }

        // Mise à jour DA si miroir du DI
        $inst_da = $this->get_inst_dossier_autorisation($this->getVal('dossier_autorisation'));
        if ($inst_da->is_dossier_autorisation_visible() === false) {
            $params = array(
                'di_id' => $this->getVal($this->clePrimaire),
            );
            if ($inst_da->majDossierAutorisation($params) === false) {
                $this->addToMessage(_("Erreur lors de la mise a jour des donnees du dossier d'autorisation. Contactez votre administrateur."));
                return false;
            }
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[101] ERP Qualifié -> AT
         * Déclencheur :
         *  - L'option ERP est activée
         *  - Le dossier est de type AT
         *  - Le dossier est marqué comme "connecté au référentiel ERP"
         *  - Le formulaire de modification du dossier est validé avec le
         *    marqueur "à qualifier" à "NON" alors qu'il était précédemment à
         *    "OUI"
         */
        //
        if ($this->f->is_option_referentiel_erp_enabled($this->getVal('om_collectivite')) === true
            && $this->is_connected_to_referentiel_erp() === true
            && $this->f->getDATCode($this->valF['dossier']) == $this->f->getParameter('erp__dossier__nature__at')
            && $this->getVal('a_qualifier') == 't' && $this->valF['a_qualifier'] === false) {
            // Récupère la liste des contraintes
            $contraintes_plu_list = $this->getListContrainte($this->valF['dossier'], false);
            // Extrait les libellés de chaque contraintes
            $contraintes_plu = array();
            $contraintes_plu_string = "";
            foreach ($contraintes_plu_list as $row) {
                //
                $contraintes_plu[] = $row['contrainte_libelle'];
            }
            // Chaîne de caractère listant toutes les contraintes du dossier
            $contraintes_plu_string = implode(' ; ', $contraintes_plu);
            $competence = "";
            if ($this->valF['autorite_competente'] !== null) {
                $inst_ac = $this->get_inst_autorite_competente($this->valF['autorite_competente']);
                $competence = $inst_ac->getVal("libelle");
            }
            //
            $infos = array(
                "dossier_instruction" => $this->valF['dossier'],
                "competence" => $competence,
                "contraintes_plu" => $contraintes_plu_string,
                "references_cadastrales" => $this->getReferenceCadastrale($this->valF['dossier']),
            );
            //
            $ret = $this->f->send_message_to_referentiel_erp(101, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (101) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (101) du référentiel ERP OK."));
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[102] Demande de complétude de dossier PC pour un ERP -> PC qui concerne un ERP
         * (WS->ERP)[103] Demande de qualification de dossier PC pour un ERP -> PC qui concerne un ERP
         * Déclencheur :
         *  - L'option ERP est activée
         *  - Le dossier est de type PC
         *  - Le formulaire de modification du dossier est validé avec le
         *    marqueur "à qualifier" à "NON" alors qu'il était précédemment à
         *    "OUI"
         *  - Le formulaire de modification du dossier est validé avec le
         *    marqueur "ERP" à "OUI"
         */
        //
        if ($this->f->is_option_referentiel_erp_enabled($this->getVal('om_collectivite')) === true
            && $this->f->getDATCode($this->valF['dossier']) == $this->f->getParameter('erp__dossier__nature__pc')
            && $this->getVal('a_qualifier') == 't' && $this->valF['a_qualifier'] === false
            && $this->valF['erp'] == true) {
            //
            $infos = array(
                "dossier_instruction" => $this->valF['dossier'],
            );
            // [102] Demande de complétude de dossier PC pour un ERP
            $ret = $this->f->send_message_to_referentiel_erp(102, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (102) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (102) du référentiel ERP OK."));
            // [103] Demande de qualification de dossier PC pour un ERP
            $ret = $this->f->send_message_to_referentiel_erp(103, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (103) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (103) du référentiel ERP OK."));
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[114] ERP Qualifié -> PC
         * Déclencheur :
         *  - l'option ERP est activée
         *  - ET le dossier est marqué comme "connecté au référentiel ERP"
         *  - ET le dossier est de type PC
         *  - ET
         *    - soit le formulaire de modification du dossier est validé avec le
         *    marqueur "enjeu_urba" qui change de statut
         *    - soit ce marqueur est vrai et le dossier passe à qualifié
         */
        // Étant donné que l'objet a été modifié en base après sa création,
        // il faut le ré-instancier pour récupérer ses informations.
        $dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $this->valF['dossier'],
        ));
        if ($dossier->f->is_option_referentiel_erp_enabled($this->getVal('om_collectivite')) === true
            && $dossier->is_connected_to_referentiel_erp() === true
            && $this->f->getDATCode($this->valF['dossier']) == $this->f->getParameter('erp__dossier__nature__pc')
            && (($this->getVal('enjeu_urba') == 't') != $this->valF['enjeu_urba'] 
                || ($this->getVal('a_qualifier') == 't' && $this->valF['a_qualifier'] === false
                    && $this->getVal('enjeu_urba') == 't'))) {

            $enjeu = "non";
            if ($this->valF['enjeu_urba']) {
                $enjeu = "oui";
            }

            $infos = array(
                "dossier_instruction" => $this->valF['dossier'],
                "Dossier à enjeu ADS" => $enjeu
            );
            //
            $ret = $this->f->send_message_to_referentiel_erp(114, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (114) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (114) du référentiel ERP OK."));
        }

        /**
         * Gestion des demandeurs liés.
         */
        // Ajout ou modification des demandeurs
        $this->insertLinkDossierDemandeur();

        /**
         * Gestion des références cadastrales / parcelles liées.
         */
        // Si le champ des références cadastrales n'est pas vide
        if ($this->getVal('terrain_references_cadastrales') 
            != $this->valF['terrain_references_cadastrales']) {

            // On supprime toutes les lignes de la table dossier_parcelle qui 
            // font référence le dossier en cours de modification
            $this->supprimer_dossier_parcelle($val['dossier']);

            // Ajout des parcelles dans la table dossier_parcelle
            $this->ajouter_dossier_parcelle($val['dossier'], 
                $val['terrain_references_cadastrales']);

        }

        /**
         * Gestion des taxes.
         */
        // Si le champ tax_secteur est modifié et que l'option de simulation des
        // taxes est activée
        if ($this->getVal('tax_secteur') != $this->valF['tax_secteur']
            && $this->f->is_option_simulation_taxes_enabled($this->getVal('om_collectivite')) === true) {

            // Valeurs pour le calcul de la taxe d'aménagement
            $values = array();
            // Instance de la classe donnees_techniques
            $donnees_techniques = $this->get_inst_donnees_techniques();
            // Récupère les valeurs des données techniques
            $values = $donnees_techniques->get_form_val();

            // Met à jour les montants du dossier
            $update_dossier_tax_mtn = $this->update_dossier_tax_mtn($this->valF['tax_secteur'], $values);
            if ($update_dossier_tax_mtn === false) {
                //
                $this->addToMessage(_("La mise a jour des montants de la simulation de la taxe d'amenagement a echouee."));
                //
                return false;
            }
        }

        /**
         * Gestion des métadonées des pièces liés.
         * Vérifie les méthodes à exécuter configurées dans le connecteur du
         * filestorage.
         */
        //
        $ret = $this->post_update_metadata($val);
        // 
        if ($ret === false) {
            //
            $this->cleanMessage();
            $this->addToMessage(_("La mise à jour des métadonnées des pièces liées à ce dossier a échouée."));
            return false;
        }

        /**
         * Gestion des du changement de date de dépôt.
         * Vérification préalable de la présence de la date et de sa
         * modification.
         */
        //
        if (array_key_exists("date_depot", $val) === true) {
            //
            $inst_new_date = DateTime::createFromFormat('d/m/Y', $val["date_depot"]);
            $inst_old_date = DateTime::createFromFormat('Y-m-d', $this->getVal("date_depot"));
            $new_date = $inst_new_date->format('d/m/Y');
            $old_date = $inst_old_date->format('d/m/Y');

            //
            if ($new_date !== $old_date) {
                //
                $status = $this->update_date_depot($val["date_depot"]);
                //
                if ($status === false) {
                    //
                    $this->addToMessage(_("Erreur de base de donnees. Contactez votre administrateur."));
                    return false;
                }

            }
        }

        /**
         * Gestion de la normalisation de l'adresse.
         * En cas de modification de l'adresse du terrain, l'adresse normalisée
         * est supprimée.
         */
        $list_address_keys = array(
            'terrain_adresse_voie_numero',
            'terrain_adresse_voie',
            'terrain_adresse_lieu_dit',
            'terrain_adresse_localite',
            'terrain_adresse_code_postal',
            'terrain_adresse_bp',
            'terrain_adresse_cedex',
        );
        $change = false;
        foreach ($list_address_keys as $key) {
            if (array_key_exists($key, $val) === true
                && $val[$key] !== $this->getVal($key)) {
                //
                $change = true;
                break;
            }
        }
        if ($change === true) {
            $this->normalize_address();
        }

        if ($this->f->is_option_mode_service_consulte_enabled() === false
            && $this->f->is_type_dossier_platau($this->valF['dossier_autorisation']) === true
            && $this->getVal('etat_transmission_platau') !== 'jamais_transmissible') {

            $trigger_platau_required_fields = $this->trigger_platau_required_fields($this->valF['dossier']);
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
        // Qualification du dossier d'instruction
        if ($this->getVal('instructeur') != $this->valF['instructeur']
            || $this->getVal('division') != $this->valF['division']) {
            //
            if ($this->f->is_type_dossier_platau($this->valF['dossier_autorisation'])
                && $this->valF['etat_transmission_platau'] !== 'jamais_transmissible'
                && ($this->f->is_option_mode_service_consulte_enabled() !== true
                    || ($this->f->is_option_mode_service_consulte_enabled() === true
                    && ($this->get_source_depot_from_demande() === PLATAU
                        || $this->get_source_depot_from_demande() === PORTAL)))) {
                //
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => 0,
                ));
                $task_val = array(
                    'type' => 'qualification_DI',
                    'object_id' => $id,
                    'dossier' => $id,
                );
                if ($this->f->is_option_mode_service_consulte_enabled() === false
                    && $this->valF['etat_transmission_platau'] === 'non_transmissible' 
                    || $this->valF['etat_transmission_platau'] === 'transmis_mais_non_transmissible') {
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
            }
        }
        // Modification du dossier d'instruction
        if ($this->f->is_type_dossier_platau($this->valF['dossier_autorisation'])
            && $this->valF['etat_transmission_platau'] !== 'jamais_transmissible'
            && ($this->f->is_option_mode_service_consulte_enabled() !== true
                || ($this->f->is_option_mode_service_consulte_enabled() === true
                && ($this->get_source_depot_from_demande() === PLATAU
                    || $this->get_source_depot_from_demande() === PORTAL)))) {
            //
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => 'modification_DI',
                'object_id' => $id,
                'dossier' => $id,
            );
            // Change l'état de la tâche de notification en fonction de l'état de
            // transmission du dossier d'instruction
            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && $this->valF['etat_transmission_platau'] === 'non_transmissible' 
                || $this->valF['etat_transmission_platau'] === 'transmis_mais_non_transmissible') {
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
            //     'object_id' => $this->getVal('dossier_autorisation'),
            //     'dossier' => $this->getVal('dossier_autorisation'),
            // );
            // // Change l'état de la tâche de notification en fonction de l'état de
            // // transmission du dossier d'instruction
            // if ($this->f->is_option_mode_service_consulte_enabled() === false
            //     && $this->valF['etat_transmission_platau'] === 'non_transmissible' 
            //     || $this->valF['etat_transmission_platau'] === 'transmis_mais_non_transmissible') {
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

        //
        return true;
    }

    /**
     * TRIGGER - triggermodifier.
     *
     * @return boolean
     */
    function triggermodifier($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Si la date de dépôt a changé et si elle valait celle du dernier dépôt
        // alors cette dernière prend également sa valeur
        if ($this->f->formatDate($this->getVal('date_depot')) !== $val['date_depot']
            && $this->f->formatDate($this->getVal('date_depot')) === $this->f->formatDate($this->getVal('date_dernier_depot'))) {
            $this->valF['date_dernier_depot'] = $this->valF['date_depot'];
        }
        //
        return true;
    }

    /**
     * Methode de traitement suite à la modification de la date de dépot.
     *
     * @param string $new_date_str Nouvelle date de dépot.
     *
     * @return boolean
     */
    function update_date_depot($new_date_str) {
        $demande = $this->get_inst_demande();
        // TODO: should return null instead of false
        if ($demande === false) {
            return false;
        }

        $retour = $this->majDateInstruction($demande->getVal("instruction_recepisse"), $new_date_str);
        if ($retour === false) {
            return false;
        }
       
        $valF = array();
        foreach ($demande->champs as $id => $champ) {
            $valF[$champ] = $demande->val[$id];
        }
        $valF['date_demande'] = $new_date_str;
        $modification = $demande->modifier($valF);
        if ($modification === false) {
            return false;
        }

        $row_date = array("date_demande" => $new_date_str);
        $res = $this->f->db->autoExecute(
            DB_PREFIXE."dossier",
            $row_date,
            DB_AUTOQUERY_UPDATE,
            "dossier = '".$this->getVal("dossier")."'"
        );
        $this->f->addToLog(__METHOD__ . "() : db->autoExecute(" . $res . ")", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true)) {
            return false;
        }

        // Si c'est un dossier d'instruction initial
        $di_version = $this->get_di_numero_suffixe();
        if ($di_version === 0 || $di_version === '0') {
            //
            $row_date = array("depot_initial" => $new_date_str);
            $res = $this->f->db->autoExecute(
                DB_PREFIXE."dossier_autorisation",
                $row_date,
                DB_AUTOQUERY_UPDATE,
                "dossier_autorisation = '" . $this->getVal("dossier_autorisation") . "'"
            );
            $this->f->addToLog(__METHOD__ . "() : db->autoExecute(" . $res . ")", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true)) {
                return false;
            }
        }
    }


    /**
     * Met à jour l'instruction en fonction de la nouvelle date 
     * ou retourne false si il ya une erreur.
     *
     * @param integer $instruction_id Identifiant de l'instruction.
     * @param string  $date_depot     Nouvelle date de dépôt.
     * 
     * @return boolean
     */
    public function majDateInstruction($instruction_id, $date_depot) {

        // Definalise l'instruction de récépissé si nécessaire
        $instruction = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction",
            "idx" => $instruction_id,
        ));
        $instruction->setParameter('maj', 110);
        //
        if ($instruction->is_unfinalizable_without_bypass() === true
            && $instruction->unfinalize($instruction->valF) === false) {
            return false;
        }

        // Modifie la date d'événement
        $instruction->setParameter('maj', 1);
        //
        $valF = array();
        foreach ($instruction->champs as $id => $champ) {
            $valF[$champ] = $instruction->getVal($champ);
        }
        //
        $valF['date_evenement'] = $date_depot;
        $valF['date_finalisation_courrier'] = null;
        //
        $modification = $instruction->modifier($valF);
        //
        if ($modification === false) {
            return false;
        }

        // Finalise l'instruction
        $instruction->setParameter('maj', 100);
        if ($instruction->finalize($instruction->valF) === false) {
            return false;
        }

        //
        return true;
    }

    /**
     * TODO: replace with '$this->f->findObjectById' ?
     *
     * Récupère l'instance de l'autorité compétente.
     *
     * @param string $autorite_competente Identifiant de l'autorité compétente.
     *
     * @return object
     */
    function get_inst_autorite_competente($autorite_competente = null) {
        //
        return $this->get_inst_common("autorite_competente", $autorite_competente);
    }


    /**
     * Met à jour les montants des taxes du dossier d'instruction.
     *
     * @param integer $tax_secteur Secteur communal.
     * @param array   $val         Valeurs des données techniques.
     *
     * @return boolean
     */
    public function update_dossier_tax_mtn($tax_secteur, $val = array()) {
        // Instance du paramétrage de la taxe d'aménagement
        $taxe_amenagement = $this->get_inst_taxe_amenagement();

        // Liste des montants à mettre à jour
        $valF = array();
        $valF['tax_mtn_part_commu'] = null;
        $valF['tax_mtn_part_depart'] = null;
        $valF['tax_mtn_part_reg'] = null;
        $valF['tax_mtn_total'] = null;
        $valF['tax_mtn_rap'] = null;
        $valF['tax_mtn_part_commu_sans_exo'] = null;
        $valF['tax_mtn_part_depart_sans_exo'] = null;
        $valF['tax_mtn_part_reg_sans_exo'] = null;
        $valF['tax_mtn_total_sans_exo'] = null;
        $valF['tax_mtn_rap_sans_exo'] = null;

        // Si le tableau des valeurs n'est pas vide
        if ($val !== array()) {

            // Si le taux communal est renseigné
            if ($taxe_amenagement->getVal('tx_comm_secteur_'.$tax_secteur) !== null
                && $taxe_amenagement->getVal('tx_comm_secteur_'.$tax_secteur) !== '') {

                // Calcul de la TA
                $calcul_ta = $taxe_amenagement->compute_ta($tax_secteur, $val);

                // Si chaque résultat est calculable
                if ($calcul_ta !== null && is_array($calcul_ta) === true) {

                    // Total des parts de la TA avec exonération
                    $total_ta = $calcul_ta['commu'] + $calcul_ta['depart'] + $calcul_ta['reg'];
                    $total_ta_ss_exo = $calcul_ta['commu_ss_exo'] + $calcul_ta['depart_ss_exo'] + $calcul_ta['reg_ss_exo'];

                    // Valeurs à mettre à jour, les montants doivent être à l'entier
                    // inférieur
                    $valF['tax_mtn_part_commu'] = floor(floatval($calcul_ta['commu']));
                    $valF['tax_mtn_part_depart'] = floor(floatval($calcul_ta['depart']));
                    $valF['tax_mtn_part_reg'] = floor(floatval($calcul_ta['reg']));
                    $valF['tax_mtn_total'] = floor(floatval($total_ta));
                    $valF['tax_mtn_part_commu_sans_exo'] = floor(floatval($calcul_ta['commu_ss_exo']));
                    $valF['tax_mtn_part_depart_sans_exo'] = floor(floatval($calcul_ta['depart_ss_exo']));
                    $valF['tax_mtn_part_reg_sans_exo'] = floor(floatval($calcul_ta['reg_ss_exo']));
                    $valF['tax_mtn_total_sans_exo'] = floor(floatval($total_ta_ss_exo));
                }
            }

            // Calcul de la RAP
            $calcul_rap = $taxe_amenagement->compute_rap($val);

            // Si chaque résultat est calculable
            if ($calcul_rap !== null && is_array($calcul_rap) === true) {

                // RAP avec exonération
                $mtn_rap = $calcul_rap['rap'];
                // RAP sans exonération
                $mtn_rap_ss_exo = $calcul_rap['rap_ss_exo'];

                // Valeurs à mettre à jour, les montants doivent être à l'entier
                // inférieur
                $valF['tax_mtn_rap'] = floor(floatval($mtn_rap));
                $valF['tax_mtn_rap_sans_exo'] = floor(floatval($mtn_rap_ss_exo));
            }
        }

        // Met à jour l'enregistrement de dossier
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.$this->table,
            $valF,
            DB_AUTOQUERY_UPDATE,
            $this->clePrimaire ."='".$this->getVal($this->clePrimaire)."'"
        );
        // Log
        $this->f->addToLog(__METHOD__."() : db->autoExecute(".$res.")", VERBOSE_MODE);
        //
        if ($this->f->isDatabaseError($res, true)) {
            //
            $this->correct = false;
            return false;
        }

        //
        return true;
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // Permet de récupérer la le type de demande pour la gestion du numéro de dossier.
        $inst_demande = $this->get_inst_demande();
        $this->val['demande_type'] = $inst_demande->getVal('demande_type');

        /**
         * Gestion de la suppression des tables liées au dossier d'instruction.
         * Les fichiers potentiellement liés aux tables ne sont pas supprimés.
         */
        if (! isset($this->related_tables)) {
            $this->set_related_tables();
        }
        // Supprime les enregistrements des tables
        $delete = $this->delete_related_tables($this->related_tables);
        if ($delete === false) {
            return false;
        }

        //
        return true;
    }

    /**
     * TRIGGER - triggersupprimerapres.
     *
     * @return boolean
     */
    function triggersupprimerapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        /**
         * Gestion de la suppression des tables liées au dossier d'instruction.
         * Dans le cas d'un dossier d'instruction initial le dossier
         * d'autorisation est également supprimé pour libérer la numéroration.
         * S'il s'agit d'un dossier d'instruction sur exsitant alors le dossier
         * d'autorisation est mise à jour.
         * Les fichiers potentiellement liés aux tables ne sont pas supprimés.
         */
        // S'il s'agit d'une suppression de dossier d'instruction sur existant
        if ($this->has_only_initial_di(true) === false) {
            // Mise à jour des données du dossier d'autorisation
            $da = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_autorisation",
                "idx" => $this->getVal("dossier_autorisation"),
            ));
            $da->majDossierAutorisation();

        } else {
            // S'il s'agit d'une suppression de dossier d'instruction initial
            // Tableau pour la conception des requêtes de suppression
            $related_tables = array(
                'lien_dossier_autorisation_demandeur' => array(
                    'condition_field' => 'dossier_autorisation',
                    'condition_value' => sprintf("'%s'", $val['dossier_autorisation']),
                ),
                'dossier_autorisation_parcelle' => array(
                    'condition_field' => 'dossier_autorisation',
                    'condition_value' => sprintf("'%s'", $val['dossier_autorisation']),
                ),
                'donnees_techniques' => array(
                    'condition_field' => 'dossier_autorisation',
                    'condition_value' => sprintf("'%s'", $val['dossier_autorisation']),
                ),
                'dossier_autorisation' => array(
                    'condition_field' => 'dossier_autorisation',
                    'condition_value' => sprintf("'%s'", $val['dossier_autorisation']),
                ),
            );
            // Supprime les tables
            $delete = $this->delete_related_tables($related_tables);
            if ($delete === false) {
                return false;
            }

            // Compose le nom de la séquence
            $seq_name = null;
            $datc = $this->getVal('numerotation_type');
            $annee = $this->getVal('annee');
            $dep = $this->getVal('numerotation_dep');
            $com = $this->getVal('numerotation_com');
            // TODO si les tests se déroulent bien;
            //        - supprimer la création manuelle de la séquence avec 'sprintf(...)'
            //        - conserver uniquement l'usage de 'compose_sequence_name(...)'
            if (! empty($datc) && ! empty($annee) && ! empty($dep) && ! empty($com)) {
                $seq_name = strtolower(sprintf(
                    '%sdossier_%s_%s_%s_%s_seq',
                    DB_PREFIXE,
                    $datc,
                    $annee,
                    $dep,
                    $com
                ));
                $alt_seq_name = $this->compose_sequence_name($datc, $annee, $dep, $com);
                if ($seq_name != $alt_seq_name) {
                    throw new RuntimeException("Sequence names differs ($seq_name != $alt_seq_name) for $id");
                }
            }

            // si il manque l'une des données, c'est que le dossier a un numéro qui ne respecte pas
            // la norme urbanisme et donc on a pas su le décomposer lors de la création du dossier
            // (moment où ces données sont renseignées) et la séquence (qui utilise ces données) n'a
            // pas pu être constituée et donc pas incrémentée lors de la création du dossier.
            // C'est pourquoi il ne faut pas modifier la séquence non-plus lors de la suppression.
            else {
                foreach(array('numerotation_type', 'annee', 'numerotation_dep', 'numerotation_com') as $key) {
                    if (empty($this->getVal($key) )) {
                        $this->f->addToLog("Valeur vide pour le champ '$key' du dossier $id", VERBOSE_MODE);
                    }
                }
            }
            // Instancie le dossier d'autorisation sans identifiant
            $da = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_autorisation",
                "idx" => 0,
            ));

            // Si la séquence a pu être composée et que celle-ci existe
            if (! empty($seq_name ) && $da->doesNumeroDossierSequenceExists($seq_name) === true){
                /**
                 * Mise à jour de la séquence.
                 */
                $curr_da_num = $da->getMaxDANumeroDossier($datc, $annee, $dep, $com);
                if (is_integer($curr_da_num) !== true) {
                    $this->addToMessage(__('Erreur lors du calcul du numéro de dossier.'));
                    return false;
                }

                // Dans le cas de la suppression du dernier dossier d'instruction de
                // sa numérotation alors la séquence est supprimée
                if ($curr_da_num === 0) {
                    $table_name = substr($seq_name, 0, -4);
                    $res = $this->f->db->dropSequence($table_name);
                    $this->f->addToLog(__METHOD__."(): db->dropSequence(\"".$table_name."\");", VERBOSE_MODE);
                    $this->f->isDatabaseError($res);
                } else {
                    // La méthode setval avec la valeur true en troisième argument
                    // signifie que le prochain nextval avancera la séquence avant
                    // de renvoyer une valeur.
                    // TODO : cette requête ne sert pas à récupérer des résultats mais
                    // juste à mettre à un numéro de séquence. Voir si il n'est pas judicieux
                    // d'avoir une autre méthode plutôt qu'un get_result pour ce genre de cas
                    $this->f->get_all_results_from_db_query(
                        sprintf(
                            'SELECT
                                setval(\'%s\', %s, true)',
                            $this->f->db->escapeSimple($seq_name),
                            $this->f->db->escapeSimple($curr_da_num)
                        ),
                        array(
                            'origin' => __METHOD__
                        )
                    );
                }
            }
            // Si le dossier n'est pas décomposable et donc que la séquence du dossier n'a pas
            // été mise à jour
            else {
                $id_di = $this->getVal($this->clePrimaire);

                // si l'option de saisie complète du numéro de dossier n'est pas activée, c'est un
                // bug (ou défaut de paramétrage)
                if (! $this->f->is_option_dossier_saisie_numero_complet_enabled($this->getVal('om_collectivite'))) {
                    throw new RuntimeException(
                        "Le dossier supprimé '$id_di' n'a pas de séquence correspondante, ".
                        "alors que l'option 'dossier_saisie_numero_complet' n'est pas activée: BUG ?!");
                }

                // ajoute un message de log pour avoir un suivi
                $this->f->addToLog(
                    __METHOD__."(): INFO: le dossier '$id_di' n'étant pas à la norme urba, ".
                    "la séquence correspondante n'a pas besoin d'être mise à jour.",
                    DEBUG_MODE
                );
            }
        }

        /**
         * Supprime le dossier d'instruction des derniers dossiers consultés,
         * sauvegardé en session
         */
        if (isset($_SESSION['dossiers_consulte']) !== false) {
            $id_di = $this->getVal($this->clePrimaire);
            if (in_array($id_di, $_SESSION['dossiers_consulte']) === true) {
                unset($_SESSION['dossiers_consulte'][$id_di]);
            }
            // Supprime le tableau s'il n'y a plus de dossier consulté
            if (count($_SESSION['dossiers_consulte']) === 0) {
                unset($_SESSION['dossiers_consulte']);
            }
        }

        /**
         * Gestion des tâches pour la dématérialisation
         */
        $inst_task_empty = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));
        $task_types = array(
            "creation_DI",
            "depot_DI",
        );
        foreach ($task_types as $task_type) {
            $task_exists = $inst_task_empty->task_exists($task_type, $id);
            if ($task_exists !== false) {
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => $task_exists,
                ));
                if ($inst_task->getVal('state') === $inst_task::STATUS_NEW || $inst_task->getVal('state') === $inst_task::STATUS_DRAFT) {
                    $task_val = array(
                        'state' => $inst_task::STATUS_CANCELED,
                    );
                    $update_task = $inst_task->update_task(array('val' => $task_val));
                    if ($update_task === false) {
                        $this->addToMessage(sprintf('%s %s',
                            sprintf(__("Une erreur s'est produite lors de la modification de la tâche %."), $inst_task->getVal($inst_task->clePrimaire)),
                            __("Veuillez contacter votre administrateur.")
                        ));
                        $this->correct = false;
                        return false;
                    }
                }
            }
        }

        return true;
    }

    /**
     * TREATMENT - delete_related_tables.
     *
     * Suppression par requête SQL les enregistrements des tables passées en
     * paramètre.
     *
     * @param array $related_tables Liste des enregistrements à supprimer
     *
     * @return boolean
     */
    function delete_related_tables(array $related_tables) {
        $this->begin_treatment(__METHOD__);

        // Supprime chaque enregistrement liés au dossier d'instruction
        $template_delete_sql = 'DELETE FROM %s%s WHERE %s IN (%s)';
        foreach ($related_tables as $table => $value) {
            if (isset($value['table']) === true) {
                $table = $value['table'];
            }
            if ($value['condition_value'] !== '' && $value['condition_value'] !== null) {
                $sql = sprintf(
                    $template_delete_sql,
                    DB_PREFIXE,
                    $table,
                    $value['condition_field'],
                    $value['condition_value']
                );
                $res = $this->f->db->query($sql);
                $this->f->addToLog(__METHOD__."(): db->query(\"".$sql."\");", VERBOSE_MODE);
                $this->f->isDatabaseError($res);
            }
        }

        /**
         * Gestion des tâches pour la dématérialisation
         */

        // Annule toutes les tâches liées au dossier
        $inst_task_empty = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));
        $all_task_type = array_merge(task::TASK_TYPE_SI, task::TASK_TYPE_SC);
        $search_values = array(
            sprintf('(state = \'%s\' OR state = \'%s\')', task::STATUS_NEW, task::STATUS_DRAFT),
            isset($related_tables['dossier_autorisation']) === false
                ? sprintf(
                    'type IN (%s) AND (object_id = \'%s\' OR dossier = \'%s\')',
                    implode( // liste (string) des type de tâches concernés
                        ',',
                        array_map(
                            function ($t) { return "'$t'"; },
                            array_merge(
                                task::TASK_TYPE_SI,
                                task::TASK_TYPE_SC)
                        )
                    ),
                    $this->getVal($this->clePrimaire),
                    $this->getVal($this->clePrimaire)
                )
                : sprintf(
                    '((type IN (%s) AND (object_id = \'%s\' OR dossier = \'%s\'))
                        OR (type IN (%s) AND object_id = \'%s\'))',
                    implode( // liste (string) des type de tâches concernés
                        ',',
                        array_map(
                            function ($t) { return "'$t'"; },
                            array_merge(
                                task::TASK_TYPE_SI,
                                task::TASK_TYPE_SC)
                        )
                    ),
                    $this->getVal($this->clePrimaire),
                    $this->getVal($this->clePrimaire),
                    "'creation_DA', 'modification_DA'",
                    $this->getVal('dossier_autorisation')
                ),
        );
        $task_exists = $inst_task_empty->task_exists_multi_search($search_values);
        if ($task_exists !== false) {
            foreach ($task_exists as $task) {
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => $task['task'],
                ));
                $task_val = array(
                    'state' => task::STATUS_CANCELED,
                );
                $update_task = $inst_task->update_task(array('val' => $task_val));
                if ($update_task === false) {
                    $this->addToMessage(sprintf('%s %s',
                        sprintf(__("Une erreur s'est produite lors de la modification de la tâche %."), $inst_task->getVal($inst_task->clePrimaire)),
                        __("Veuillez contacter votre administrateur.")
                    ));
                    $this->correct = false;
                    return $this->end_treatment(__METHOD__, false);
                }
            }
        }

        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * CONDITION - has_only_initial_di.
     *
     * Permet de vérifier qu'il s'agit du dossier d'instruction initial de
     * l'autorisation.
     *
     * @param boolean $after_delete À activer si la méthode est utilisée lors de
     *                              la suppression.
     *
     * @return boolean
     */
    function has_only_initial_di($after_delete=false) {

        // Compte le nombre de dossier lié au dossier d'autorisation
        $res = $this->get_idx_by_args('COUNT(dossier)', 'dossier', 'dossier_autorisation', $this->getVal('dossier_autorisation'));

        // Si la méthode est utilisé dans le triggersupprimerapres alors le
        // dossier d'instruction est déjà supprimé dans la base de données, le
        // retour doit donc être 0 pour prouver la suppression du DI initial
        if ($after_delete === true) {
            if ($res === '0') {
                return true;
            }
            //
            return false;
        }

        // S'il y a qu'un seul dossier d'instruction alors le DI courant est
        // forcément l'initial
        if ($res === '1') {
            return true;
        }
        //
        return false;
    }

    /**
     * Retourne la reference cadastrale de la demande attache a un dossier ERP
     * specifique
     * @param string $dossier L'identifiant du dossier
     * @return string|null La reference cadastrale si elle est trouve,
     * sinon NULL. En cas d'erreur de la BD, l'execution s'arrete.
     */
    function getReferenceCadastrale($dossier) {
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    terrain_references_cadastrales
                FROM
                    %1$sdemande
                WHERE
                    dossier_instruction = \'%2$s\'
                LIMIT 1',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            // Appel de la methode de recuperation des erreurs
            // TODO : pas de correspondance pour la méthode getDebugInfo() voir si
            // il faut faire évoluer ce code ou si la modif est ok
            // Ancien code : $this->erreur_db($res->getDebugInfo(), $res->getMessage(), 'demande');
            $this->erreur_db($qres['message'], $qres['message'], 'demande');
        }
        // retourne la nature du dossier
        foreach ($qres['result'] as $row) {
            return $row['terrain_references_cadastrales'];
        }
        // la nature n'etait pas trouve, ce qui ne devrait pas se passer
        return NULL;
    }

    /**
     * Supprime puis recrée tous les liens entre dossier et demandeurs
     **/
    function insertLinkDossierDemandeur() {
        // Suppression des anciens demandeurs
        $this->deleteLinkDossierDemandeur();
        $types_demandeur = array(
            "petitionnaire_principal",
            "delegataire",
            "petitionnaire",
            "plaignant_principal",
            "plaignant",
            "contrevenant_principal",
            "contrevenant",
            "requerant_principal",
            "requerant",
            "avocat_principal",
            "avocat",
            "bailleur_principal",
            "bailleur",
            "proprietaire",
            "architecte_lc",
            "paysagiste",
        );
        foreach ($types_demandeur as $type) {
            // Comparaison des autres demandeurs
            if(isset($this->postedIdDemandeur[$type]) === true) {
                // Ajout des nouveaux liens
                foreach ($this->postedIdDemandeur[$type] as $demandeur) {
                    //
                    $principal = false;
                    if (strpos($type, '_principal') !== false) {
                        $principal = true;
                    }
                    if ($this->addLinkDossierDemandeur($demandeur, $principal) === false) {
                        //
                        return false;
                    }
                }
            }
        }
    }


    /**
     * Fonction permettant d'ajouter un lien
     * entre la table dossier et demandeur
     **/
    function addLinkDossierDemandeur($id, $principal) {
        $lienAjout = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_dossier_demandeur",
            "idx" => "]",
        ));
        $lien = array('lien_dossier_demandeur' => "",
                           'petitionnaire_principal' => (($principal)?"t":"f"),
                           'dossier' => $this->valF['dossier'],
                           'demandeur' => $id);
        $lienAjout->ajouter($lien);
        $lienAjout->__destruct();
    }

    /**
     * Fonction permettant de supprimer un lien
     * entre la table demande et demandeur
     **/
    function deleteLinkDossierDemandeur() {
        // Suppression
        $sql = "DELETE FROM ".DB_PREFIXE."lien_dossier_demandeur ".
                "WHERE dossier='".$this->valF['dossier']."'";
        $res = $this->f->db->query($sql);
        $this->f->addToLog(
            __METHOD__."(): db->query(\"".$sql."\");",
            VERBOSE_MODE
        );
        $this->f->isDatabaseError($res);
    }

    /**
     * Methode de recupération des valeurs postées
     **/
    function getPostedValues() {
        // Récupération des demandeurs dans POST
        $types_demandeur = array(
            "petitionnaire_principal",
            "delegataire",
            "petitionnaire",
            "plaignant_principal",
            "plaignant",
            "contrevenant_principal",
            "contrevenant",
            "requerant_principal",
            "requerant",
            "avocat_principal",
            "avocat",
            "bailleur_principal",
            "bailleur",
            "proprietaire",
            "architecte_lc",
            "paysagiste",
        );
        foreach ($types_demandeur as $type) {
            if($this->f->get_submitted_post_value($type) !== null AND
                    $this->f->get_submitted_post_value($type) != '') {
                $this->postedIdDemandeur[$type] = $this->f->get_submitted_post_value($type);
            }
        }
    }

    /**
     * Méthode permettant de récupérer les id des demandeurs liés à la table
     * liée passée en paramètre
     *
     * @param string $from Table liée : "demande", "dossier", dossier_autorisation"
     * @param string $id Identifiant (clé primaire de la table liée en question)
     */
    function listeDemandeur($from, $id) {
        
        // Si la donnée membre a déjà été remplie par un précédent appel à cette méthode,
        // on sort.
        if ($this->valIdDemandeur["petitionnaire_principal"] !== array() or
            $this->valIdDemandeur["delegataire"] !== array() or
            $this->valIdDemandeur["petitionnaire"] !== array() or
            $this->valIdDemandeur["plaignant_principal"] !== array() or
            $this->valIdDemandeur["plaignant"] !== array() or
            $this->valIdDemandeur["contrevenant_principal"] !== array() or
            $this->valIdDemandeur["contrevenant"] !== array() or
            $this->valIdDemandeur["requerant_principal"] !== array() or
            $this->valIdDemandeur["requerant"] !== array() or
            $this->valIdDemandeur["avocat_principal"] !== array() or
            $this->valIdDemandeur["avocat"] !== array() or 
            $this->valIdDemandeur["bailleur_principal"] !== array() or
            $this->valIdDemandeur["bailleur"] !== array() or
            $this->valIdDemandeur["proprietaire"] !== array() or
            $this->valIdDemandeur["architecte_lc"] !== array() or
            $this->valIdDemandeur["paysagiste"] !== array()) {
            return;
        }

        // Récupération des demandeurs de la base
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    demandeur.demandeur,
                    demandeur.type_demandeur,
                    lien_%2$s_demandeur.petitionnaire_principal
                FROM
                    %1$slien_%2$s_demandeur
                    INNER JOIN %1$sdemandeur 
                        ON demandeur.demandeur=lien_%2$s_demandeur.demandeur 
                WHERE
                    %2$s = \'%3$s\'',
                DB_PREFIXE,
                $from,
                $this->f->db->escapeSimple($id)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        
        // Stockage du résultat dans un tableau
        foreach ($qres['result'] as $row) {
            
            $demandeur_type = $row['type_demandeur'];
            if ($row['petitionnaire_principal'] == 't'){
                $demandeur_type .= "_principal";
            }
            $this->valIdDemandeur[$demandeur_type][] = $row['demandeur'];
        }
    }

    /**
     * Récupère la liste des contraintes d'un dossier.
     * 
     * @param string  $dossier     Identifiant du dossier.
     * @param boolean $for_di_view Liste avec condition affichage DI.
     *
     * @return object          Résultat de la requête
     */
    function getListContrainte($dossier, $for_di_view = true) {

        // Select
        $select = "SELECT dossier_contrainte.dossier_contrainte as dossier_contrainte_id,
                    dossier_contrainte.texte_complete as dossier_contrainte_texte,
                    dossier_contrainte.reference as dossier_contrainte_reference,
                    contrainte.libelle as contrainte_libelle,
                    contrainte.nature as contrainte_nature,
                    contrainte.texte as contrainte_texte,
                    contrainte.reference as contrainte_reference,
                    lower(contrainte.groupe) as contrainte_groupe,
                    lower(contrainte.sousgroupe) as contrainte_sousgroupe ";

        // From
        $from = " FROM ".DB_PREFIXE."contrainte 
                    LEFT JOIN ".DB_PREFIXE."dossier_contrainte
                        ON  dossier_contrainte.contrainte = contrainte.contrainte ";

        // Where
        $where = " WHERE dossier_contrainte.dossier = '".$dossier."' ";

        // Si les contraintes sont listées pour être affichées dans le DI
        if ($for_di_view === true) {
            // Si le paramètre "option_contrainte_di" est défini
            if ($this->f->getParameter('option_contrainte_di') != 'aucun') {
                // Ajoute la condition
                $where .= $this->f->traitement_condition_contrainte(
                    $this->f->getParameter('option_contrainte_di'));
            }
        }

        // Tri
        $tri = " ORDER BY contrainte_groupe DESC, contrainte_sousgroupe, 
                    contrainte.no_ordre, contrainte.libelle ";

        // Requête SQL
        $qres = $this->f->get_all_results_from_db_query($select.$from.$where.$tri, array(
                'origin' => __METHOD__
            )
        );

        // Retourne le résultat
        return $qres['result'];
    }

    /**
     * Récupère les informations à afficher dans le tableau des identifiants
     * tehniques Plat'AU. Stocke ces informations dans un tableau.
     * Converti le tableau au format json et renvoi le json obtenu
     *
     * @return json
     */
    protected function get_json_lien_iiue_platau() {
        // Tableau de retour
        $val_suivi = array();

        // Liste des champs à afficher. Permet également la traduction des noms de colonnes.
        $liste_champs = array(
            'object' => __('type'),
            'object_id' => __('identifiant openADS'),
            'external_uid' => __("identifiant Plat'AU"),
            'state' => __('état du versement'),
        );
        // Mapping entre la valeur 'object' de la table de liaison des identifiants
        // et la valeur de 'object' dans la tables des tâches
        $mapping_one_to_one_object_liiue_task = array(
            'dossier_autorisation' => 'creation_DA',
            'dossier' => 'creation_DI',
            'piece' => 'ajout_piece',
            'consultation' => 'creation_consultation',
            'instruction_action_cl' => 'envoi_CL',
        );
        // Traduction des états de versement
        $trad_state = array(
            'done' => sprintf('%s %s', __('terminé'), '[V]'),
            'pending' => __('en cours'),
            'error' => __('en erreur'),
            'new' => __('à réaliser'),
        );
        // Traduction des objets
        $trad_object = array(
            'dossier_autorisation' => __('dossier_autorisation'),
            'dossier' => __('dossier'),
            'piece' => __('pièce'),
            'dossier_consultation' => __('consultation'),
            'pec_dossier_consultation' => __('prise en compte'),
            'avis_dossier_consultation' => __('avis'),
            'instruction_action_cl' => __('instruction transmise au CL'),
        );
        // Instance de la table de liaison des identifiants
        $inst_liiue = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_id_interne_uid_externe",
            "idx" => 0,
        ));
        // Instance de la table des tâches
        $inst_task = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));
        // Récupération de toutes les occurences du dossier en cours dans la table des
        // liaisons des identifiants
        $external_uids = $inst_liiue->get_all_lien_id_interne_uid_externe_by_dossier($this->getVal('dossier'), PLATAU);
        if (is_array($external_uids) === true && count($external_uids) > 0) {
            //
            foreach ($external_uids as $external_uid) {

                /**
                 * Gestion de l'état du versement dans Plat'AU
                 */
                // État par défaut
                $external_uid['state'] = __('N/A');
                // Tente d'identifier le type, dans certains cas il n'est pas
                // possible de le définir avec certitude
                $type = isset($mapping_one_to_one_object_liiue_task[$external_uid['object']]) === true ? $mapping_one_to_one_object_liiue_task[$external_uid['object']] : null;
                $search_values = array(
                    sprintf('type = \'%s\'', $type),
                    sprintf('object_id = \'%s\'', $external_uid['object_id']),
                    sprintf('state != \'%s\'', $inst_task::STATUS_CANCELED),
                );
                // Si le type ne peut pas être défini avec certitude, alors on ne
                // l'inclut pas dans la recherche de la tâche
                if ($type === null) {
                    unset($search_values[0]);
                }
                $task_exists = $inst_task->task_exists_multi_search($search_values);
                // Pour récupérer un état, il ne faut qu'un résultat
                if ($task_exists !== false) {
                    //
                    foreach ($task_exists as $task_value) {
                        $external_uid['state'] = $task_value['state'];
                        if ($task_value['state'] === 'pending') {
                            break;
                        }
                    }
                }
                // Remplace les valeurs des états de versement par les traductions
                foreach ($trad_state as $key => $value) {
                    if ($external_uid['state'] === $key) {
                        $external_uid['state'] = $value;
                    }
                }

                // Remplace les valeurs des états de versement par les traductions
                foreach ($trad_object as $key => $value) {
                    if ($external_uid['object'] === $key) {
                        $external_uid['object'] = __($value);
                    }
                }

                //
                $val_notif = array();
                foreach($liste_champs as $key => $champ) {
                    $val_notif[$champ] = $external_uid[$key];
                }
                array_push($val_suivi, $val_notif);
            }
        }

        // Passage du tableau au format json
        return json_encode($val_suivi, JSON_HEX_APOS);
    }

    /**
     * Récupère les codes de suivi du dossier et construit les liens pour afficher
     * le suivi de la demande dans le portail SVE.
     * 
     * @return string
     */
    protected function get_json_lien_iiue_portal() {
        $portal_link_list = array();
        $display = __("Aucun enregistrement.");
        $this->set_is_portal_code_suivi(false);
        //
        $portal_link = $this->f->get_portal_code_suivi_base_url($this->getVal('om_collectivite'));
        if ($portal_link === null) {
            return __("Veuillez contacter votre administrateur pour configurer le lien vers iDE'AU avec le paramètre <i>portal_code_suivi_base_url</i>.");
        }
        // Instance de la table de liaison des identifiants
        $inst_liiue = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_id_interne_uid_externe",
            "idx" => 0,
        ));
        $external_uids = $inst_liiue->get_all_lien_id_interne_uid_externe_by_dossier($this->getVal('dossier'), PORTAL, 'code-suivi');
        if (is_array($external_uids) === true && count($external_uids) > 0) {
            foreach ($external_uids as $external_uid) {
                $portal_link_list[] = sprintf(
                    '<a id="action-form-portal-suivi-demande-%s" class="simple-btn" title="%s" target="_blank" href="%s"><span class="om-icon om-icon-16 om-icon-fix consult-demat consult-16"></span>%s</a>',
                    $external_uid['lien_id_interne_uid_externe'],
                    __("Ouvrir le suivi de demande dans iDE'AU"),
                    str_replace("[PORTAL_CODE_SUIVI]", $external_uid['external_uid'], $portal_link),
                    $external_uid['external_uid']
                );
            }
            $display = implode('<br/>', $portal_link_list);
            $this->set_is_portal_code_suivi(true);
        }
        return $display;
    }

    /**
     * Ajout de la liste des contraintes et des demandeurs
     */
    function formSpecificContent($maj) {

        // Récupère le CRUD
        $crud = $this->get_action_crud($this->getParameter("maj"));

        // Les contenus spécifiques ne sont pas affichés en cas de suppression
        if ($crud === 'delete') {
            return;
        }

        /**
         * Liste des contraintes
         */
        //
        $listContrainte = $this->getListContrainte($this->getVal('dossier'));

        // Si le dossier possède des contraintes et qu'on n'est pas dans la vue "Journal d'instruction"
        if (count($listContrainte) != 0 && $maj !== "200") {

            // Affiche du fieldset
            printf("<div id=\"liste_contrainte\" class=\"demande_hidden_bloc\">");
            printf("<fieldset class=\"cadre ui-corner-all ui-widget-content col_12 startClosed\">");
            printf("  <legend class=\"ui-corner-all ui-widget-content ui-state-active\"
                    id =\"fieldset_contraintes_liees\">"
                    ._("dossier_contrainte")."</legend>");
            printf("<div class=\"fieldsetContent\" style=\"display: none;\">");

            // Entête pour le groupe
            $groupeHeader = "
            <div class='dossier_contrainte_groupe'>
                <div class='dossier_contrainte_groupe_header'>
                    <span class='name'>
                        %s
                    </span>
                </div>
            ";

            // Entête pour le sous-groupe
            $sousgroupeHeader = "
            <div class='dossier_contrainte_sousgroupe'>
                <div class='dossier_contrainte_sousgroupe_header'>
                    <span class='name'>
                        %s
                    </span>
                </div>
            ";

            // Titres des colonnes
            $tableHeader = "
            <thead>
                <tr class='ui-tabs-nav ui-accordion ui-state-default tab-title'>
                    <th class='title col-0 firstcol contrainte_th_texte_complete'>
                        <span class='name'>
                            "._('texte_complete')."
                        </span>
                    </th>
                    <th class='title col-1 contrainte_th_reference'>
                        <span class='name'>
                            "._('reference')."
                        </span>
                    </th>
                    <th class='title col-2 contrainte_th_nature'>
                        <span class='name'>
                            "._('nature')."
                        </span>
                    </th>
                </tr>
            </thead>
            ";

            // Ligne de données
            $line = "
            <tr class='tab-data %s'>
                <td class='col-0 firstcol contrainte_th_texte_complete'>
                    %s
                </td>
                <td class='col-1 contrainte_th_reference'>
                    %s
                </td>
                <td class='col-2 contrainte_th_nature'>
                    %s
                </td>
            ";

            // Sauvegarde des données pour les comparer
            $lastRow = array();
            $lastRow['contrainte_groupe'] = 'empty';
            $lastRow['contrainte_sousgroupe'] = 'empty';

            // Tant qu'il y a des résultats
            foreach ($listContrainte as $row) {
                // Si l'identifiant du groupe de la contrainte présente et 
                // celle d'avant est différent
                if ($row['contrainte_groupe'] != $lastRow['contrainte_groupe']) {

                    // Si l'identifiant du groupe d'avant est vide
                    if ($lastRow['contrainte_groupe'] != 'empty') {
                        // Ferme le tableau
                        printf("</table>");
                        // Ferme le div
                        printf("</div>");
                        // Ferme le div
                        printf("</div>");
                    }

                    // Affiche le header du groupe
                    printf($groupeHeader, $row['contrainte_groupe']);
                }

                // Si l'identifiant du sous-groupe de la contrainte présente et 
                // celle d'avant est différent
                // Ou qu'ils soient identique mais n'appartiennent pas au même groupe
                if ($row['contrainte_sousgroupe'] != $lastRow['contrainte_sousgroupe']
                    || ($row['contrainte_sousgroupe'] == $lastRow['contrainte_sousgroupe']
                        && $row['contrainte_groupe'] != $lastRow['contrainte_groupe'])) {

                    //
                    if($row['contrainte_groupe'] == $lastRow['contrainte_groupe']) {
                        // Si l'identifiant de la sous-groupe d'avant est vide
                        if ($lastRow['contrainte_sousgroupe'] != 'empty') {
                            // Ferme le tableau
                            printf("</table>");
                            // Ferme le div
                            printf("</div>");
                        }
                    }

                    // Affiche le header du sous-groupe
                    printf($sousgroupeHeader, $row['contrainte_sousgroupe']);

                    // Ouvre le tableau
                    printf("<table id='sousgroupe_".$row['contrainte_sousgroupe']."' class='tab-tab dossier_contrainte_view'>");

                    // Affiche le header des données
                    printf($tableHeader);

                    // Définis le style des lignes
                    $style = 'odd';
                }

                // Si toujours dans la même groupe et même sous-groupe, 
                // on change le style de la ligne
                if ($row['contrainte_groupe'] == $lastRow['contrainte_groupe']
                    && $row['contrainte_sousgroupe'] == $lastRow['contrainte_sousgroupe']) {
                    // Définis le style
                    $style = ($style=='even')?'odd':'even';
                }
                
                // Affiche "Oui" ou "Non" pour le bouléen
                if ($row['dossier_contrainte_reference'] == 1 
                    || $row['dossier_contrainte_reference'] == "t"
                    || $row['dossier_contrainte_reference'] == "Oui") {
                    //
                    $contrainte_reference = "Oui";
                } else {
                    //
                    $contrainte_reference = "Non";
                }

                // Affiche les données
                printf($line, $style, 
                    $row['dossier_contrainte_texte'], 
                    $contrainte_reference,
                    $row['contrainte_nature']
                );

                // Sauvegarde les données
                $lastRow['contrainte_groupe'] = $row['contrainte_groupe'];
                $lastRow['contrainte_sousgroupe'] = $row['contrainte_sousgroupe'];
                
            }
            // Ferme le tableau
            printf("</table>");
            // Ferme le sous-groupe
            printf("</div>");
            // Ferme le groupe
            printf("</div>");

            printf("</div>");

            printf("<div class=\"visualClear\"></div>");            
            // Ferme le fieldset content
            printf("</div>");
            printf("</fieldset>");
        } 
        /**
         * Fin Liste des contraintes
         */

        /**
         * Liste des demandeurs
         */
        // Tableau des demandeurs selon le contexte
        $listeDemandeur = $this->valIdDemandeur;
        /**
         * Gestion du bloc des demandeurs
         */
        // Si le mode est (modification ou suppression ou consultation) ET que
        // le formulaire n'est pas correct (c'est-à-dire que le formulaire est
        // actif) 
        if ($this->correct !== true AND
            $this->getParameter('validation') == 0 AND
            $this->getParameter("maj") != 0) {
            // Alors on récupère les demandeurs dans la table lien pour
            // affectation des résultats dans $this->valIdDemandeur
            $this->listeDemandeur("dossier", $this->getval($this->clePrimaire));
            $listeDemandeur = $this->valIdDemandeur;
        }

        // Récupération des valeurs postées
        if ($this->getParameter('validation') != 0) {
            $listeDemandeur = $this->postedIdDemandeur;
        }

        // Si le mode est (ajout ou modification) 
        // ET que le mode n'est pas (journal d'instruction)
        // ET que le formulaire n'est pas correct
        // (c'est-à-dire que le formulaire est actif)
        if (($this->getParameter("maj") < 2 AND $this->correct !== true)) {
            // Alors on positionne le marqueur linkable a true qui permet
            // d'afficher ou non les actions de gestion des demandeurs
            $linkable = true;
        } else {
            // Sinon on positionne le marqueur linkable a false qui permet
            // d'afficher ou non les actions de gestion des demandeurs
            $linkable = false;
        }
        $affichage_form = $this->get_type_affichage_formulaire();
        // Pour les dossiers contentieux, il faut un droit spécifique pour visualiser le
        // fieldset "Demandeurs"
        if ($this->getParameter("maj") != 200  &&
            ($affichage_form === 'ADS' || $affichage_form === 'DPC' || $affichage_form === 'CONSULTATION ENTRANTE')
            OR ($affichage_form === 'CTX RE' AND $this->f->isAccredited('dossier_contentieux_recours_afficher_demandeurs') === true)
            OR ($affichage_form === 'CTX IN' AND $this->f->isAccredited('dossier_contentieux_infractions_afficher_demandeurs') === true)
            ) {

            // Conteneur de la listes des demandeurs
            echo "<div id=\"liste_demandeur\" class=\"demande_hidden_bloc col_12\">";
            echo "<fieldset id=\"fieldset-form-dossier_instruction-demandeur\" class=\"cadre ui-corner-all ui-widget-content startClosed\">";
            echo "  <legend class=\"ui-corner-all ui-widget-content ui-state-active\">"
                    ._("Demandeurs")."</legend>";
            echo "<div class=\"fieldsetContent\" style=\"display: none;\">";


            // Pour les DI avec DA visible, dans tous les modes excepté en ajout et si l'option d'accès au
            // portail citoyen est activée
            $inst_da = $this->get_inst_dossier_autorisation();
            if ($this->getParameter("maj") != 0
                && $this->f->is_option_citizen_access_portal_enabled() === true
                && $inst_da->is_dossier_autorisation_visible() === true) {
                // Instance du dossier d'autorisation
                //
                printf('<div class="field field-type-static"><div class="form-libelle"><label id="lib-cle_acces_citoyen" class="libelle-cle_acces_citoyen" for="cle_acces_citoyen">%s</label></div><div class="form-content"><span id="cle_acces_citoyen" class="field_value">%s</span></div></div><br/>', _("cle_acces_citoyen"), $inst_da->getVal('cle_acces_citoyen'));
            }
            // Sélection des demandeur à afficher en fonction du paramétrage du type
            // du dossier d'autorisation.
            switch ($affichage_form) {
                case 'ADS':
                case 'CONSULTATION ENTRANTE':
                    $this->display_demandeur_petitionnaire_delegataire($listeDemandeur);
                    break;
                case 'CTX RE':
                    $this->display_demandeur_petitionnaire_delegataire($listeDemandeur);
                    $this->display_demandeur_requerant_avocat($listeDemandeur);
                    break;
                case 'CTX IN':
                    $this->display_demandeur_plaignant_contrevenant($listeDemandeur);
                    break;
                case 'DPC':
                    $this->display_demandeur_petitionnaire_delegataire($listeDemandeur);
                    $this->display_demandeur_petitionnaire_delegataire_bailleur($listeDemandeur);
                    break;
            }

        }

        echo "</fieldset>";
        echo "</div>";
        /**
         * Fin liste des demandeurs
         */

        /**
         * Interface avec le référentiel ERP.
         *
         * On affiche le message uniquement si le dossier est connecté.
         */
        if ($this->getParameter('maj') == 3 && $this->is_connected_to_referentiel_erp() === true) {
            //
            printf(
                '<div class="col_12">
                    Ce dossier est connecté au référentiel ERP.
                </div>'
            );
        }

    }
    
    /**
     * Affiche le bloc d'affichage des demandeurs pour dossiers ADS avec actions.
     *
     * @param array $listeDemandeur Liste des demandeurs.
     */
    function display_demandeur_petitionnaire_delegataire($listeDemandeur) {
        
        // Affichage du bloc pétitionnaire principal / délégataire
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div class=\"bloc demandeur-container\">";
        echo "<section id=\"petitionnaires\">";
        echo "<div id=\"petitionnaire_principal_delegataire\">";
        // Affichage de la synthèse du pétitionnaire principal
        $this->displaySyntheseDemandeur($listeDemandeur, "petitionnaire_principal");
        echo "</div>";
        // Bloc des pétitionnaires secondaires
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listePetitionnaires\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "petitionnaire");
        echo "</div>";
        echo "</section>";
        
        
        echo "<section id=\"autres-demandeurs\">";
        // L'ID DU DIV ET DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"delegataire\">";
        // Affichage de la synthèse du délégataire
        $this->displaySyntheseDemandeur($listeDemandeur, "delegataire");
        echo "</div>";
        // L'ID DU DIV ET DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"proprietaire\">";
        // Affichage de la synthèse du délégataire
        $this->displaySyntheseDemandeur($listeDemandeur, "proprietaire");
        echo "</div>";
        // L'ID DU DIV ET DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"architecte_lc\">";
        // Affichage de la synthèse du délégataire
        $this->displaySyntheseDemandeur($listeDemandeur, "architecte_lc");
        echo "</div>";
        // L'ID DU DIV ET DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"paysagiste\">";
        // Affichage de la synthèse du délégataire
        $this->displaySyntheseDemandeur($listeDemandeur, "paysagiste");
        echo "</div>";
        echo "</section>";
        echo "</div>";
        
    }

    /**
     * Affiche le bloc d'affichage des demandeurs pour dossiers CTX recours
     * avec actions.
     *
     * @param array $listeDemandeur Liste des demandeurs.
     */
    function display_demandeur_plaignant_contrevenant($listeDemandeur) {
        
        echo "<div id=\"plaignant_contrevenant\">";
        // Affichage du bloc contrevenant
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listeContrevenants\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"contrevenant_principal\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "contrevenant_principal");
        echo "</div>";
        echo "<div id=\"listeAutresContrevenants\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "contrevenant");
        echo "</div>";
        echo "</div>";
        // Affichage du bloc plaignant
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listePlaignants\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"plaignant_principal\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "plaignant_principal");
        echo "</div>";
        echo "<div id=\"listeAutresPlaignants\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "plaignant");
        echo "</div>";
        echo "</div>";
        echo "</div>";
        
    }

    /**
     * Affiche le bloc d'affichage des demandeurs pour dossiers CTX infraction
     * avec actions.
     *
     * @param array $listeDemandeur Liste des demandeurs.
     */
    function display_demandeur_requerant_avocat($listeDemandeur) {
        echo "<div id=\"requerant_avocat\">";
        // Affichage du bloc requérant
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listeRequerants\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"requerant_principal\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "requerant_principal");
        echo "</div>";
        echo "<div id=\"listeAutresRequerants\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "requerant");
        echo "</div>";
        echo "</div>";
        // Affichage du bloc avocat
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listeAvocat\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"avocat_principal\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "avocat_principal");
        echo "</div>";
        echo "<div id=\"listeAutresAvocats\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "avocat");
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</fieldset>";
        // Champ flag permettant de récupérer la valeur de l'option sig pour
        // l'utiliser en javascript, notamment lors du chargement de l'interface
        // pour les références cadastrales
        // XXX Si un widget pour les références cadastrales existait, il n'y
        // aurait pas besoin de faire cela
        echo "<input id='option_sig' type='hidden' value='".$this->f->getParameter("option_sig")."' name='option_sig'>";
        echo "</div>";
    }


    /**
     * Affiche le bloc d'affichage des demandeurs pour dossiers DPC avec actions.
     *
     * @param array $listeDemandeur Liste des demandeurs.
     */
    function display_demandeur_petitionnaire_delegataire_bailleur($listeDemandeur) {
        
        // Affichage du bloc pétitionnaire principal / délégataire / bailleur
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"petitionnaire_principal_delegataire_bailleur\">";
        // Doit être utilisé avec la div petitionnaire_principal_delegataire
        echo "<div id=\"listeBailleurs\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"bailleur_principal\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "bailleur_principal");
        echo "</div>";
        echo "<div id=\"listeAutresBailleurs\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "bailleur");
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }


    function displaySyntheseDemandeur($listeDemandeur, $type) {
        // Si le mode est (ajout ou modification) ET que le formulaire n'est pas
        // correct (c'est-à-dire que le formulaire est actif)
        if ($this->getParameter("maj") < 2 AND $this->correct !== true) {
            // Alors on positionne le marqueur linkable a true qui permet
            // d'afficher ou non les actions de gestion des demandeurs
            $linkable = true;
        } else {
            // Sinon on positionne le marqueur linkable a false qui permet
            // d'afficher ou non les actions de gestion des demandeurs
            $linkable = false;
        }
        // Récupération du type de demandeur pour l'affichage
        switch ($type) {
            case 'petitionnaire_principal':
                $legend = _("Petitionnaire principal");
                break;

            case 'delegataire':
                $legend = _("Autre correspondant");
                break;
            
            case 'petitionnaire':
                $legend = _("Petitionnaire");
                break;
                
            case 'contrevenant_principal':
                $legend = _("Contrevenant principal");
                break;
                
            case 'contrevenant':
                $legend = _("Autre contrevenant");
                break;
                
            case 'plaignant_principal':
                $legend = _("Plaignant principal");
                break;
            
            case 'plaignant':
                $legend = _("Autre plaignant");
                break;
            
            case 'requerant_principal':
                $legend = _("Requérant principal");
                break;
            
            case 'requerant':
                $legend = _("Autre requérant");
                break;
            
            case 'avocat_principal':
                $legend = _("Avocat principal");
                break;
            
            case 'avocat':
                $legend = _("Autre avocat");
                break;

            case 'bailleur_principal':
                $legend = _("Bailleur principal");
                break;
            
            case 'bailleur':
                $legend = _("Bailleur");
                break;

            case 'proprietaire':
                $legend = __("Propriétaire");
                break;

            case 'architecte_lc':
                $legend = __("Architecte législation connexe");
                break;

            case 'paysagiste':
                $legend = __("Concepteur-Paysagiste");
                break;
        }
        foreach ($listeDemandeur[$type] as $demandeur_id) {
            $obj = str_replace('_principal', '', $type);
            $demandeur = $this->f->get_inst__om_dbform(array(
                "obj" => $obj,
                "idx" => $demandeur_id,
            ));
            $demandeur -> afficherSynthese($type, $linkable);
            $demandeur -> __destruct();
        }
        // Si en édition de formulaire
        if ($this->getParameter("maj") < 2 AND $this->correct !== true) {
            // Bouton d'ajout du avocat
            // L'ID DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
            echo "<a id=\"add_".$type."\"
                class=\"om-form-button add-16\">".
                $legend.
            "</a>";
        }
    }

    /**
     * Retourne le statut du dossier
     * @return string Le statut du dossier d'instruction
     */
    function getStatut(){
        $etat = $this->f->get_inst__om_dbform(array(
            "obj" => 'etat',
            "idx" => $this->getVal("etat"),
        ));
        return $etat->getVal('statut');
    }

    /**
     * Retourne le dernier événement lié au dossier instancié
     * 
     * @return [string] ID du dernier événement
     */
    function get_dernier_evenement() {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    MAX(instruction)
                FROM
                    %1$sinstruction
                WHERE
                    dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        return $qres["result"];
    }

    /**
     * Retourne l'identifiant du rapport d'instruction lié du dossier
     * @return string L'identifiant du rapport d'instruction lié du dossier
     */
    function getRapportInstruction() {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    rapport_instruction
                FROM
                    %1$srapport_instruction
                WHERE
                    dossier_instruction = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
            ),
            array(
                "origin" => __METHOD__
            )
        );

        return $qres["result"];
    }
    
    /**
     * Retourne l'identifiant des données techniques liées du dossier
     * @return string L'identifiant des données techniques liées du dossier
     */
    function getDonneesTechniques() {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    donnees_techniques
                FROM
                    %1$sdonnees_techniques
                WHERE
                    dossier_instruction = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        return $qres["result"];
    }

    /**
     * Retourne le lien de retour (VIEW formulaire et VIEW sousformulaire).
     *
     * @param string $view Appel dans le contexte de la vue 'formulaire' ou de
     *                     la vue 'sousformulaire'.
     *
     * @return string
     */
    function get_back_link($view = "formulaire") {
        $baseURL = OM_ROUTE_TAB;
        $paramsHref = array(
            'premier' => $this->getParameter("premier"),
            'tricol' => $this->getParameter("tricol"),
            'advs_id' => $this->getParameter("advs_id"),
            'valide' => $this->getParameter("valide")
        );

        // Si on vient d'un widget de recherche paramétrable avec un message d'aide paramétré
        if (empty($this->f->get_submitted_get_value("message_help")) === false) {
           // On ajoute le message d'aide dans l'url de retour
           $paramsHref['message_help'] = urlencode($this->f->get_submitted_get_value("message_help"));
        }

        if($this->getParameter("idx_dossier") != "") {
            $paramsHref['obj'] = "recherche_dossier";
        } else {
            if($this->getParameter("retour") == "form") {
                $paramsHref['idx'] = $this->getParameter("idx");
                $paramsHref['action'] = '3';
                if (!($this->getParameter("validation") > 0 && $this->getParameter("maj") == 2 && $this->correct)) {
                    $baseURL = OM_ROUTE_FORM;

                }
            }
            $paramsHref['obj'] = $this->f->get_submitted_get_value('retour_widget') !== null ?
                $this->f->get_submitted_get_value('retour_widget') :
                $this->get_absolute_class_name();
        
            if ($this->f->get_submitted_get_value('widget_recherche_id') !== null) {
                $paramsHref['widget_recherche_id'] = $this->f->get_submitted_get_value('widget_recherche_id');
            }
            if (empty($this->f->get_submitted_get_value('retourformulaire2')) === false) {
                $paramsHref['retourformulaire'] = $this->f->get_submitted_get_value('retourformulaire2');
            }
        }

        // Construction du lien à partir des valeurs stockées dans le tableau
        $href = array_map(function ($key, $value) {
                return '&'.$key.'='.$value;
            }, array_keys($paramsHref), $paramsHref);
        $href = $baseURL.implode('', $href);

        return $href;
    }

    /**
     * Surcharge du bouton retour afin de retourner sur la recherche de dossiers
     * d'instruction existant.
     */
    function retour($premier = 0, $recherche = "", $tricol = "") {
        $css_class = "retour";
        // Récupération du lien de redirection
        $href = str_replace(
            "&",
            "&amp;",
            $this->get_back_link("formulaire")
        );
        // Affichage du bouton retour avec le lien et la classe voulues
        $this->f->layout->display_form_retour(array(
            "id" => "form-action-".$this->get_absolute_class_name()."-back-".uniqid(),
            "href" => $href,
            "class" => $css_class,
        ));
    }

    /**
     * Permet de modifier le fil d'Ariane
     * @param string $ent Fil d'Ariane
     * @param array  $val Valeurs de l'objet
     * @param intger $maj Mode du formulaire
     */
    function getFormTitle($ent) {

        // Fil d'Ariane
        $type_aff_form = $this->get_type_affichage_formulaire();
        switch ($type_aff_form) {
            case 'DPC':
            case 'ADS':
                $ent = _("instruction")." -> "._("dossiers d'instruction");
                break;
            case 'CTX IN':
                $ent = _("contentieux")." -> "._("infraction");
                break;
            case 'CTX RE':
                $ent = _("contentieux")." -> "._("recours");
                break;
            case 'CONSULTATION ENTRANTE':
                $ent = __("instruction")." -> ".__("dossiers de consultation");
        }

        // Si différent de l'ajout
        if($this->getParameter("maj") != 0) {
            // Si le champ dossier_libelle existe
            if (trim($this->getVal("dossier_libelle")) != '') {
                $ent .= " -> ".strtoupper($this->getVal("dossier_libelle"));
            }
            // Si contexte ADS
            if ($type_aff_form ==='ADS'
                && trim($this->getVal("dossier")) != '') {
                $demandeur = $this->get_demandeur($this->getVal("dossier"));
                // Si le demandeur existe
                if (isset($demandeur) && trim($demandeur) != '') {
                    $ent .= " ".mb_strtoupper($demandeur, "UTF-8");
                }
            }

            // Dans le cas d'un dossier d'instruction issu d'un dépôt électronique
            // applique un style spécifique sur le fil d'Arianne
            if ($this->getVal('depot_electronique') === 't') {
                $this->f->addStyleForTitle("demat-color-breadcrumb");
            }
        }

        // Change le fil d'Ariane pour l'interface de géolocalisation automatique des DI
        if ($this->getParameter("maj") == 126) {
            $ent = _("administration")." -> "._("options avancées")." -> "._("Géolocalisation des dossiers");
        }

        // Change le fil d'Ariane
        return $ent;
    }

    /**
     * Récupère le demandeur du dossier
     * @return string Identifiant du dossier
     */
    private function get_demandeur($dossier) {
        // Requête SQL  
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    CASE
                        WHEN demandeur.qualite = \'particulier\' THEN TRIM(
                            CONCAT(
                                demandeur.particulier_nom,
                                \' \',
                                demandeur.particulier_prenom
                            )
                        )
                        ELSE TRIM(
                            CONCAT(
                                demandeur.personne_morale_raison_sociale,
                                \' \',
                                demandeur.personne_morale_denomination
                            )
                        )
                    END as demandeur
                FROM
                    %1$sdossier
                    LEFT JOIN %1$slien_dossier_demandeur 
                        ON lien_dossier_demandeur.dossier=dossier.dossier
                            AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
                    LEFT JOIN %1$sdemandeur
                        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        return $qres["result"];
    }

    /**
     * Récupère la durée de validité
     * @param  string $dossier_autorisation Identifiant dossier d'autorisation
     * @return intger                       Durée de validité
     */
    function get_duree_validite($dossier_autorisation, $force_param = false) {

        // Récupère le numéro de version
        $numeroVersion = $this->getNumeroVersion($dossier_autorisation);

        // Si c'est l'ajout du dossier initial
        if ($numeroVersion < 0 || $force_param === true) {

            // Récupération de la duree de validite depuis la table 
            // "dossier_autorisation_type_detaille"
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        duree_validite_parametrage
                    FROM
                        %1$sdossier_autorisation_type_detaille
                        LEFT JOIN %1$sdossier_autorisation
                            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    WHERE
                        dossier_autorisation.dossier_autorisation = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($dossier_autorisation)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $duree_validite = $qres["result"];

        } else {

            // Récupération de la duree de validite depuis le P0
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        duree_validite
                    FROM
                        %1$sdossier
                        LEFT JOIN %1$sdossier_autorisation
                            ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
                    WHERE
                        dossier_autorisation.dossier_autorisation = \'%2$s\'
                        AND dossier.version = 0',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($dossier_autorisation)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $duree_validite = $qres["result"];
        }
        // Vérifie si la duree de validité a bien été récupérée. Si ce n'est pas le cas
        // la duree de validite est mise à 0 par défaut pour ne pas bloquer le traitement
        // (notamment en modification du dossier) et on affiche le problème dans les logs.
        try {
            if (! isset($duree_validite) || $duree_validite == null || $duree_validite == '') {
                $duree_validite = '0';
                throw new UnexpectedValueException('Unexpected NULL value');
            }
        } catch (UnexpectedValueException $e) {
            $this->addToLog(
                $e.
                ' : '.
                _("Erreur : la récupération de la durée de validité à échouée pour le dossier : ").
                $dossier_autorisation
            );
        }

        // retourne le résultat
        return $duree_validite;

    }

    /**
     * Ajoute les parcelles du dossier passé en paramètre et met à jour le 
     * quartier du dossier.
     * @param string $dossier                        Identifiant du dossier
     * @param string $terrain_references_cadastrales Références cadastrales du 
     *                                                dossier
     */
    function ajouter_dossier_parcelle($dossier, $terrain_references_cadastrales) {

        // Parse les parcelles
        $list_parcelles = $this->f->parseParcelles($terrain_references_cadastrales, $this->getVal('om_collectivite'));

        // A chaque parcelle une nouvelle ligne est créée dans la table
        // dossier_parcelle
        foreach ($list_parcelles as $parcelle) {

            // Instance de la classe dossier_parcelle
            $dossier_parcelle = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_parcelle",
                "idx" => "]",
            ));

            // Valeurs à sauvegarder
            $value = array(
                'dossier_parcelle' => '',
                'dossier' => $dossier,
                'parcelle' => '',
                'libelle' => $parcelle['quartier']
                                .$parcelle['section']
                                .$parcelle['parcelle']
            );

            // Ajout de la ligne
            $dossier_parcelle->ajouter($value);
        }

        // Si la liste des parcelles n'est pas vide
        if (count($list_parcelles) > 0) {

            // Récupère le code impôt de la première référence cadastrale
            $quartier_code_impots = $list_parcelles[0]['quartier'];
            // Récupère l'identifiant du quartier
            $quartier = $this->get_quartier_by_code_impot($quartier_code_impots);

            // Ajoute le quartier au dossier
            $this->modifier_quartier_dossier($dossier, $quartier);
        }
    }

    /**
     * Supprime les parcelles du dossier passé en paramètre et met à jour le 
     * quartier du dossier.
     * @param string $dossier Identifiant du dossier
     */
    function supprimer_dossier_parcelle($dossier) {

        // Suppression des parcelles du dossier
        $sql = "DELETE FROM ".DB_PREFIXE."dossier_parcelle
                WHERE dossier='".$dossier."'";
        $res = $this->f->db->query($sql);
        $this->addToLog(
            __METHOD__."(): db->query(\"".$sql."\");",
            VERBOSE_MODE
        );
        $this->f->isDatabaseError($res);

        // Supprime le quartier dans dossier
        $this->modifier_quartier_dossier($dossier);
    }

    /**
     * Modifie le quartier au dossier.
     * @param string  $dossier  Numéro du dossier
     * @param integer $quartier Identifiant du quartier
     */
    function modifier_quartier_dossier($dossier, $quartier = null) {

        // Valeurs à mettre à jour
        $valF = array();
        $valF['quartier'] = $quartier;

        // Met à jour le quartier du dossier
        $cle = " dossier='".$dossier."'";
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.'dossier', $valF, DB_AUTOQUERY_UPDATE, $cle);
        $this->addToLog("ajouter_quartier_dossier(): db->autoexecute(\""
            .DB_PREFIXE."dossier\", ".print_r($valF, true)
            .", DB_AUTOQUERY_UPDATE, \"".$cle."\");", VERBOSE_MODE);
        $this->f->isDatabaseError($res);
    }

    /**
     * Récupère le quartier par rapport au code impôts.
     * @param string $code_impots Code impôts du quartier
     * 
     * @return integer            Identifiant du quartier
     */
    function get_quartier_by_code_impot($code_impots) {

        // Initialisation résultat
        $quartier = null;

        // Si la condition n'est pas vide
        if ($code_impots != "" 
            && $code_impots != null) {

            // Requête SQL
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        quartier
                    FROM
                        %1$squartier
                    WHERE
                        code_impots = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($code_impots)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $quartier = $qres["result"];
        }

        // Retourne résultat
        return $quartier;
    }

    /**
     * TREATMENT - update_initial_dt.
     * 
     * Cette méthode ajoute les données techniques initiales d'un DI au format JSON.
     *
     * @return boolean
     */
    public function update_initial_dt($dt_json) {
        //
        $this->begin_treatment(__METHOD__);
        //
        if ($dt_json === null || $dt_json === '') {
            return $this->end_treatment(__METHOD__, false);
        }
        //
        $this->correct = true;
        $data = array();
        $data["initial_dt"] = $dt_json;
        //
        $res = $this->f->db->autoExecute(
            sprintf('%s%s', DB_PREFIXE, $this->table),
            $data,
            DB_AUTOQUERY_UPDATE,
            sprintf("%s = '%s'", $this->clePrimaire, $this->valF[$this->clePrimaire])
        );
        $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($data, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->valF[$this->clePrimaire])."\");", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true) === true) {
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }
        return $this->end_treatment(__METHOD__, true);
    }


    
    /**
     * Méthode permettant d'ajouter les données techniques d'un DI.
     *
     * @param integer  $id    identifiant du dossier d'instruction
     * @param array    $val   tableau de valeurs postées via le formulaire
     *
     * @return boolean false si erreur
     */
    function ajoutDonneesTechniquesDI($id, $val) {

        //On vérifie que le dossier d'autorisation a des données techniques
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$sdonnees_techniques
                WHERE
                    dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->valF["dossier_autorisation"])
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres['code'] === 'KO') {
            $this->f->addToLog(__METHOD__."() : ERROR - Erreur de base de données. Impossible d'ajouter les données techniques du dossier d'instruction.", DEBUG_MODE);
            return false;
        }
        $valF = $qres['result'][0];

        //Si le dossier d'autorisation a des données techniques
        if (count($valF) > 0) {
            //
            $dtdi = $this->f->get_inst__om_dbform(array(
                "obj" => "donnees_techniques",
                "idx" => "]",
            ));
            // Récupération de la dernière version du CERFA
            $inst_da = $this->get_inst_dossier_autorisation($valF['dossier_autorisation']);
            $inst_datd = $this->get_inst_dossier_autorisation_type_detaille($inst_da->getVal('dossier_autorisation_type_detaille'));
            $inst_cerfa = $this->get_inst_cerfa($inst_datd->getVal('cerfa'));
            // Conserve seulement les données affichées par la nouvelle version du CERFA
            foreach ($valF as $champ => $value) {
                if (array_search($champ, $inst_cerfa->champs) !== false) {
                    if ($inst_cerfa->getVal($champ) == 'f') {
                        $valF[$champ] = null;
                    }
                }
            }

            //Sauvegarde des données techniques initiales 
            //Conversion en JSON
            $dt_json = json_encode($valF);

            //Enregistrement en BDD 
            $sauvegarde_bdd = $this->update_initial_dt($dt_json);

            //Gestion des erreurs
            if ($sauvegarde_bdd === false){
                $msg_error = __("Erreur de base de données. Impossible de sauvegarder les données techniques du dossier d'instruction au format JSON.");
                $this->f->addToLog(sprintf(
                        "%s() : ERREUR - %s",
                        __METHOD__,
                        $msg_error
                    ));
                $this->addToMessage(sprintf(
                    "%s %s",
                    $msg_error,
                     __("Veuillez contacter votre administrateur.")
                ));

                return false; 
            }

            // Modification pour avoir la dernière version du CERFA
            $valF["cerfa"] = $inst_cerfa->getVal($inst_cerfa->clePrimaire);
            //Suppression de l'identifiant
            $valF["donnees_techniques"] = null;
            // Ajout du numéro de dossier d'instruction
            $valF['dossier_instruction'] = $this->valF['dossier'];
            // Suppression du numéro de dossier d'autorisation
            $valF['dossier_autorisation'] = null;
            // Ajout des données techniques
            if($dtdi->ajouter($valF) === false) {
                $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter les données techniques du dossier d'instruction.", DEBUG_MODE);
                $this->f->addToLog(__METHOD__."() : ".$dtdi->msg, DEBUG_MODE);
                return false;
            }
        }
        else {
            //Le dossier d'autorisation n'a pas de données techniques
            $this->f->addToLog(__METHOD__."() : ERROR - le DA n'a pas de données techniques.", DEBUG_MODE);
            return -1;
        }

        //
        return true;
    }

    /**
     * Méthode permettant d'ajouter le dossier operateur d'un DI.
     *
     * @param integer  $id    identifiant de la demande
     * @param array    $val   tableau de valeurs postées via le formulaire
     *
     * @return boolean false si erreur
     */
    function ajoutDossierOperateurDI($id, $val) {
        //
        $dodi = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_operateur",
            "idx" => "]",
        ));

        $valF = array();
        foreach ($dodi->champs as $champ) {
            $valF[$champ] = null;
        }
        // Ajout du numéro de dossier d'instruction
        $valF['dossier_instruction'] = $this->valF['dossier'];
        // Ajout du dossier operateur
        if($dodi->ajouter($valF) === false) {
            $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter les dossier opérateur du dossier d'instruction.", DEBUG_MODE);
            return false;
        }

        //
        return true;
    }

    /**
     * VIEW - contrainte.
     *
     * Vue des contraintes du dossier
     *
     * Cette vue permet de gérer le contenu de l'onglet "Contrainte(s)" sur un 
     * dossier. Cette vue spécifique est nécessaire car l'ergonomie standard du
     * framework ne prend pas en charge ce cas.
     * C'est ici la vue spécifique des contraintes liées au dossier qui est
     * affichée directement au clic de l'onglet au lieu du soustab.
     * 
     * L'idée est donc de simuler l'ergonomie standard en créant un container 
     * et d'appeler la méthode javascript 'ajaxit' pour charger le contenu 
     * de la vue visualisation de l'objet lié.
     * 
     * @return void
     */
    function view_contrainte() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Récupération des variables GET
        ($this->f->get_submitted_get_value('idxformulaire')!==null ? $idxformulaire = 
            $this->f->get_submitted_get_value('idxformulaire') : $idxformulaire = "");
        ($this->f->get_submitted_get_value('retourformulaire')!==null ? $retourformulaire = 
            $this->f->get_submitted_get_value('retourformulaire') : $retourformulaire = "");
        $obj = "dossier_contrainte";
        $type_aff_form = $this->get_type_affichage_formulaire();
        if ($type_aff_form === 'CTX RE' OR $type_aff_form === 'CTX IN') {
            $obj = "dossier_contrainte_contexte_ctx";
        }
        // Objet à charger
        // Construction de l'url de sousformulaire à appeler
        $url = OM_ROUTE_SOUSFORM."&obj=".$obj;
        $url .= "&action=4";
        $url .= "&idx=".$idxformulaire;
        $url .= "&retourformulaire=".$retourformulaire;
        $url .= "&idxformulaire=".$idxformulaire;
        $url .= "&retour=form";
        // Affichage du container permettant le reffraichissement du contenu
        // dans le cas des action-direct.
        printf('
            <div id="sousform-href" data-href="%s">
            </div>',
            $url
        );
        // Affichage du container permettant de charger le retour de la requête
        // ajax récupérant le sous formulaire.
        printf('
            <div id="sousform-%s">
            </div>
            <script>
            ajaxIt(\'%s\', \'%s\');
            </script>',
            $obj,
            $obj,
            $url
        );
    }

    /**
     * Cette methode permet d'afficher le bouton de validation du formulaire
     *
     * @param integer $maj Mode de mise a jour
     * @return void
     */
    function bouton($maj) {
        
        if (!$this->correct
            && $this->checkActionAvailability() == true) {
            //
            switch($maj) {
                case 0 :
                    $bouton = _("Ajouter");
                    break;
                case 1 :
                    $bouton = _("Modifier");
                    break;
                case 2 :
                    $bouton = _("Supprimer");
                    break;
                case 200 :
                    return;
                default :
                    // Actions specifiques
                    if ($this->get_action_param($maj, "button") != null) {
                        //
                        $bouton = $this->get_action_param($maj, "button");
                    } else {
                        //
                        $bouton = _("Valider");
                    }
                    break;
            }
            //
            $params = array(
                "value" => $bouton,
                "name" => "submit",
                "onclick"=>"return getDataFieldReferenceCadastrale();",
            );
            //
            $this->f->layout->display_form_button($params);
        }

    }

    /**
     * Récupère l'instance de paramétrage des taxes.
     *
     * @param integer $taxe_amenagement Identifiant
     *
     * @return object
     */
    function get_inst_taxe_amenagement($taxe_amenagement = null) {
        //
        if ($this->inst_taxe_amenagement === null) {
            //
            if ($taxe_amenagement === null) {
                //
                $taxe_amenagement = $this->get_taxe_amenagement_by_om_collectivite($this->getVal('om_collectivite'));

                // Si aucun paramétrage de taxe trouvé et que la collectivité
                // est mono
                if ($taxe_amenagement === null
                    && $this->f->isCollectiviteMono($this->getVal('om_collectivite')) === true) {
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
    function get_taxe_amenagement_by_om_collectivite($om_collectivite) {
        //
        $taxe_amenagement = null;

        // Si la collectivité n'est pas renseigné
        if ($om_collectivite !== '' && $om_collectivite !== null) {

            // SQL
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

        //
        return $taxe_amenagement;
    }

    /**
     * [get_inst_donnees_techniques description]
     *
     * @param [type] $donnees_techniques [description]
     *
     * @return [type] [description]
     */
    function get_inst_donnees_techniques($donnees_techniques = null) {
        //
        if (is_null($this->inst_donnees_techniques)) {
            //
            if (is_null($donnees_techniques)) {
                $donnees_techniques = $this->getDonneesTechniques();
            }
            //
            $this->inst_donnees_techniques = $this->f->get_inst__om_dbform(array(
                "obj" => "donnees_techniques",
                "idx" => $donnees_techniques,
            ));
        }
        //
        return $this->inst_donnees_techniques;
    }


    /**
     * TODO: replace with '$this->f->findObjectById' ?
     *
     * Récupère l'instance du dossier d'autorisation.
     *
     * @param string $dossier_autorisation Identifiant du dossier d'autorisation.
     *
     * @return object
     */
    function get_inst_dossier_autorisation($dossier_autorisation = null) {
        //
        return $this->get_inst_common("dossier_autorisation", $dossier_autorisation);
    }


    /**
     * Récupère l'instance du dossier d'autorisation, puis la clé d'accès au portail 
     * citoyen associée à ce DA.
     *
     * @param string $dossier_autorisation Identifiant du dossier d'autorisation.
     *
     * @return string $cle_acces_citoyen si la clé d'accès existe
     *         boolean false             si la clé n'existe pas
     */
    protected function get_citizen_access_key($dossier_autorisation = null) {
        //
        $inst_da = $this->get_inst_dossier_autorisation($dossier_autorisation);
        // Récupération de la valeur de la clé d'accès
        $cle_acces_citoyen = $inst_da->getVal('cle_acces_citoyen');
        if ($cle_acces_citoyen === '' OR $cle_acces_citoyen === null) {
            return false;
        }
        return $cle_acces_citoyen;
    }


    /**
     * Récupère l'instance du type détaillé du dossier d'autorisation.
     *
     * @param integer $dossier_autorisation_type_detaille Identifiant
     *
     * @return object
     */
    function get_inst_dossier_autorisation_type_detaille($dossier_autorisation_type_detaille = null) {
        //
        if (is_null($this->inst_dossier_autorisation_type_detaille)) {
            //
            if (is_null($dossier_autorisation_type_detaille)) {
                //
                $dossier_autorisation = $this->get_inst_dossier_autorisation();
                //
                $dossier_autorisation_type_detaille = $dossier_autorisation->getVal('dossier_autorisation_type_detaille');
            }
            //
            $this->inst_dossier_autorisation_type_detaille = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_autorisation_type_detaille",
                "idx" => $dossier_autorisation_type_detaille,
            ));
        }
        //
        return $this->inst_dossier_autorisation_type_detaille;
    }

    /**
     * Récupère l'instance du cerfa
     *
     * @param integer $cerfa Identifiant du cerfa
     *
     * @return object
     */
    function get_inst_cerfa($cerfa = null) {
        //
        if (is_null($this->inst_cerfa)) {
            //
            if (is_null($cerfa)) {
                //
                $dossier_autorisation_type_detaille = $this->get_inst_dossier_autorisation_type_detaille();
                //
                $cerfa = $dossier_autorisation_type_detaille->getVal('cerfa');
            }
            //
            $this->inst_cerfa = $this->f->get_inst__om_dbform(array(
                "obj" => "cerfa",
                "idx" => $cerfa,
            ));
        }
        //
        return $this->inst_cerfa;
    }

    /**
     * CONDITION - is_user_from_allowed_collectivite.
     *
     * Cette condition permet de vérifier si l'utilisateur connecté appartient
     * à une collectivité autorisée : c'est-à-dire de niveau 2 ou identique à
     * la collectivité de l'enregistrement sur lequel on se trouve.
     *
     * @return boolean
     */
    function is_user_from_allowed_collectivite() {

        // Si l'utilisateur est de niveau 2
        if ($_SESSION["niveau"] == "2") {
            // Alors l'utilisateur fait partie d'une collectivité autorisée
            return true;
        }

        // L'utilisateur est donc de niveau 1
        // On vérifie donc si la collectivité de l'utilisateur est la même
        // que la collectivité de l'élément sur lequel on se trouve
        if ($_SESSION["collectivite"] === $this->getVal("om_collectivite")) {
            // Alors l'utilisateur fait partie d'une collectivité autorisée
            return true;
        }

        // L'utilisateur ne fait pas partie d'une collectivité autorisée
        return false;
    }

    /**
     * Création ou mise à jour du répertoire de numérisation.
     *
     * L'objet de cette méthode est la création ou la mise à jour de la date de
     * modification du répertoire de numérisation destiné à recevoir les pièces
     * numérisées pour un import automatique.
     * À chaque saisie d'une nouvelle demande dans openADS, le répertoire est
     * soit créé soit mis à jour pour être disponible en dehors d'openADS
     * (point de montage sur le serveur) pour permettre de déposer les pièces
     * numérisées directement depuis le copieur. À intervalle régulier, un
     * service vérifie le contenu de ces répertoire pour importer
     * automatiquement ces fichiers dans l'onglet 'Pièce(s)' du dossier
     * concerné.
     * La mise à jour de la date de modification est importante pour réaliser
     * la purge des répertoires vides sur la base de la date de la dernière
     * demande qui concerne le dossier.
     *
     * @return boolean
     */
    function create_or_touch_digitalization_folder() {

        // Nom du répertoire
        // Le répertoire créé possède comme nom le libellé du dossier avec
        // le suffixe séparé par un '.'. Exemple : PC0130551601234.P0
        $separateur = '';
        if ($this->getSuffixe($this->getVal('dossier_instruction_type')) === 't') {
            $separateur = '.';
        }

        $digitalization_folder_name = str_replace(
            $this->getVal("dossier_autorisation"),
            $this->getVal("dossier_autorisation").$separateur,
            $this->getVal($this->clePrimaire)
        );

        // Vérifie que l'option de numérisation des dossiers est désactivée
        if ($this->f->is_option_digitalization_folder_enabled() !== true) {
            //
            $this->addToLog(
                _("L'option de numerisation des dossiers n'est pas activee").".",
                DEBUG_MODE
            );
            return false;
        }

        // Vérifie le paramétrage du répertoire de numérisation
        if ($this->f->getParameter("digitalization_folder_path") === null) {
            //
            $this->addToLog(
                "Configuration du répertoire de numérisation incorrecte.",
                DEBUG_MODE
            );
            return false;
        }

        // Répertoire cible
        $root_folder_path = $this->f->getParameter("digitalization_folder_path");

        // Vérifie que le répertoire existe
        if (is_dir($root_folder_path) !== true) {
            //
            $this->addToLog(
                sprintf(
                    "Le répertoire '%s' n'existe pas.",
                    $root_folder_path
                ),
                DEBUG_MODE
            );
            return false;
        }

        // Répertoire des "à traiter"
        $todo_folder_path = $root_folder_path."Todo/";

        // Vérifie que le répertoire existe
        if (is_dir($todo_folder_path) !== true) {
            //
            $this->addToLog(
                sprintf(
                    "Le répertoire '%s' n'existe pas.",
                    $todo_folder_path
                ),
                DEBUG_MODE
            );
            return false;
        }

        // Répertoire de numérisation.
        $digitalization_folder_path = $todo_folder_path.$digitalization_folder_name;
 
        // Si le répertore existe déjà le répertoire n'est pas créé
        if (file_exists($digitalization_folder_path) == true) {
            // Mise à jour du répertoire
            if (touch($digitalization_folder_path) !== true) {
                // Si une erreur survient
                $this->addToLog(
                    sprintf(
                        "Erreur lors de la mise à jour du répertoire '%s'.",
                        $digitalization_folder_path
                    ),
                    DEBUG_MODE
                );
                return false;
            }
            //
            return true;
        } else {
            // Création du répertoire
            if (mkdir($digitalization_folder_path) !== true) {
                //
                $this->addToLog(
                    sprintf(
                        "Erreur lors de la création du répertoire '%s'.",
                        $digitalization_folder_path
                    ),
                    DEBUG_MODE
                );
                return false;
            }
            //
            return true;
        }
    }

    /**
     * Récupère, convertit et retourne les logs de toutes les instructions
     * 
     * @return array tableau indexé de logs
     */
    public function get_log_instructions() {
        $log_instructions = $this->getVal('log_instructions');
        // Gestion du premier log
        if ($log_instructions === '') {
            $log_instructions = json_encode(array());
        }
        // Gestion du log invalide
        if(!$this->isJson($log_instructions)) {
            return false;
        }
        return json_decode($log_instructions, true);
    }

    /**
     * Ajoute un log d'instruction aux logs existants
     * 
     * @param  array $log valeurs de l'instruction
     * @return bool       vrai si traitement effectué avec succès
     */
    public function add_log_instructions($log) {
        // Begin
        $this->begin_treatment(__METHOD__);
        // Ajout du log
        $log_instructions = $this->get_log_instructions();
        if ($log_instructions === false) {
            $this->addToMessage(_("Erreur de base de donnees. Contactez votre administrateur."));
            return $this->end_treatment(__METHOD__, false);
        }
        array_push($log_instructions, $log);
        $log_instructions = json_encode($log_instructions);
        // Mise à jour du DI
        $val = array("log_instructions"=>$log_instructions);
        $ret = $this->f->db->autoexecute(
            DB_PREFIXE."dossier",
            $val,
            DB_AUTOQUERY_UPDATE,
            "dossier = '".$this->getVal('dossier')."'"
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."dossier\", ".print_r($val, true).", DB_AUTOQUERY_UPDATE, \"dossier = '".$this->getVal('dossier')."'\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($ret, true) !== false) {
            $this->erreur_db($ret->getDebugInfo(), $ret->getMessage(), 'dossier');
            $this->addToMessage(_("Erreur de base de donnees. Contactez votre administrateur."));
            return $this->end_treatment(__METHOD__, false);
        }
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * TREATMENT - mark_as_connected_to_referentiel_erp.
     * 
     * Cette méthode permet de positionner le marqueur 
     * 'interface_referentiel_erp' à 'true'. Cela signifie que le dossier est
     * connecté au référentiel ERP.
     *
     * @return boolean
     */
    function mark_as_connected_to_referentiel_erp() {
        //
        $this->begin_treatment(__METHOD__);
        //
        $data = array("interface_referentiel_erp" => true, );
        // Exécution de la requête
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.$this->table,
            $data,
            DB_AUTOQUERY_UPDATE,
            $this->getCle($this->getVal($this->clePrimaire))
        );
        // Logger
        $this->addToLog(
            __METHOD__."(): db->autoExecute(\"".DB_PREFIXE.$this->table."\", ".print_r($data, true).", DB_AUTOQUERY_UPDATE, \"".$this->getCle($this->getVal($this->clePrimaire))."\");",
            VERBOSE_MODE
        );
        //
        if ($this->f->isDatabaseError($res, true)) {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            $this->addToLog(
                __METHOD__."(): Problème erreur lors de la mise à jour du dossier",
                DEBUG_MODE
            );
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }
        //
        $this->addToMessage(_("Le dossier est désormais 'connecté avec le référentiel ERP'."));
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * CONDITION - is_connected_to_referentiel_erp.
     *
     * @return boolean
     */
    function is_connected_to_referentiel_erp() {
        //
        if ($this->getVal("interface_referentiel_erp") !== "t") {
            return false;
        }
        //
        return true;
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

        // Récupération de l'identifiant des données techniques liées au dossier
        $donnees_techniques = $this->getDonneesTechniques();

        $inst_donnees_techniques = $this->get_inst_common('donnees_techniques', $donnees_techniques);
        $donnees_techniques_applicables = $inst_donnees_techniques->get_donnees_techniques_applicables();
        //
        return $donnees_techniques_applicables;

    }


    /**
     * Retourne un tableau avec les données du dossier d'instruction.
     *
     * L'objectif est de mettre à disposition via un WS REST un ensemble
     * de données exploitable par une autre application.
     */
    function get_datas() {

        /**
         *
         */

        // TODO: replace '$this->get_inst_common' with '$this->f->findObjectById' ?
        $om_collectivite = $this->get_inst_common('om_collectivite', $this->getVal('om_collectivite'));
        $instructeur = $this->get_inst_common('instructeur', $this->getVal('instructeur'));
        $division = $this->get_inst_common('division', $this->getVal('division'));
        $etat = $this->get_inst_common('etat', $this->getVal('etat'));
        $dossier_autorisation_type_detaille = $this->get_inst_dossier_autorisation_type_detaille();
        $dossier_autorisation_type = $this->get_inst_common('dossier_autorisation_type', $dossier_autorisation_type_detaille->getVal('dossier_autorisation_type'));
        $donnees_techniques = $this->get_donnees_techniques_applicables();

        //
        $datas = array(
            //
            "dossier_instruction" => $this->getVal($this->clePrimaire),
            //
            "dossier_autorisation" => $this->getVal("dossier_autorisation"),
            //
            "terrain_adresse_voie_numero" => $this->getVal("terrain_adresse_voie_numero"),
            "terrain_adresse_lieu_dit" => $this->getVal("terrain_adresse_lieu_dit"),
            "terrain_adresse_code_postal" => $this->getVal("terrain_adresse_code_postal"),
            "terrain_adresse_cedex" => $this->getVal("terrain_adresse_cedex"),
            "terrain_adresse_voie" => $this->getVal("terrain_adresse_voie"),
            "terrain_adresse_bp" => $this->getVal("terrain_adresse_bp"),
            "terrain_adresse_localite" => $this->getVal("terrain_adresse_localite"),
            "terrain_superficie" => $this->getVal("terrain_superficie"),
            "terrain_superficie_calculee" => $this->getVal("terrain_superficie_calculee"),
            //
            "references_cadastrales" => $this->f->parseParcelles($this->getVal("terrain_references_cadastrales"), $this->getVal('om_collectivite')),
            "geoloc_latitude" => $this->getVal("geoloc_latitude"),
            "geoloc_longitude" => $this->getVal("geoloc_longitude"),
            "geoloc_rayon" => $this->getVal("geoloc_rayon"),
            "dossier_autorisation_type" => $dossier_autorisation_type->getVal("libelle"),
            "dossier_autorisation_type_detaille" => $dossier_autorisation_type_detaille->getVal("libelle"),
            "collectivite" => $om_collectivite->getVal("libelle"),
            "instructeur" => $instructeur->getVal("nom"),
            "division" => $division->getVal("libelle"),
            "etat_dossier" => $etat->getVal("libelle"),
            "statut_dossier" => $this->getStatut(),
            "date_depot_initial" => $this->getVal("date_depot"),
            "date_limite_instruction" => $this->getVal("date_limite"),
            "date_decision" => $this->getVal("date_decision"),
            "enjeu_urbanisme" => $this->getVal("enjeu_urba") == 't' ? 'true' : 'false',
            "enjeu_erp" => $this->getVal("enjeu_erp") == 't' ? 'true' : 'false',
        );

        // Gestion des demandeurs.
        $this->listeDemandeur('dossier', $this->getVal($this->clePrimaire));
        //
        if (isset($this->valIdDemandeur["petitionnaire_principal"]) AND !empty($this->valIdDemandeur["petitionnaire_principal"])) {
            $demandeur = $this->f->get_inst__om_dbform(array(
                "obj" => "petitionnaire",
                "idx" => $this->valIdDemandeur["petitionnaire_principal"][0],
            ));
            $datas["petitionnaire_principal"] = $demandeur->get_datas();
            $demandeur->__destruct();
        }
        //
        if (isset($this->valIdDemandeur["delegataire"]) && !empty($this->valIdDemandeur["delegataire"])) {
            $demandeur = $this->f->get_inst__om_dbform(array(
                "obj" => "delegataire",
                "idx" => $this->valIdDemandeur["delegataire"][0],
            ));
            $datas["delegataire"] = $demandeur->get_datas();
            $demandeur->__destruct();
        }
        //
        if (isset($this->valIdDemandeur["petitionnaire"]) AND !empty($this->valIdDemandeur["petitionnaire"])) {
            $datas["autres_petitionnaires"] = array();
            foreach ($this->valIdDemandeur["petitionnaire"] as $petitionnaire) {
                $demandeur = $this->f->get_inst__om_dbform(array(
                    "obj" => "petitionnaire",
                    "idx" => $petitionnaire,
                ));
                $datas["autres_petitionnaires"][] = $demandeur->get_datas();
                $demandeur->__destruct();
            }
        }

        // Tableau contenant le nom de chaque champ de données techniques à retourner
        $dt_a_afficher = array(
              "co_tot_log_nb",
              "co_cstr_exist",
              "co_uti_pers",
              "co_uti_vente",
              "co_uti_loc",
              "su_tot_shon_tot",
              "su_avt_shon_tot",
              "am_lot_max_nb",
              "am_empl_nb",
        );

        // Tableau associatif contenant les données techniques voulues
        $tab_donnees_techniques = array();
        foreach ($dt_a_afficher as $key) {
            // On ajoute le champ de données techniques dans le retour seulement s'il
            // existe dans $donnees_techniques (s'il est applicable au dossier)
            if (array_key_exists($key, $donnees_techniques) === true) {
                if ($donnees_techniques[$key] === 't') {
                    $donnees_techniques[$key] = 'true';
                };
                if ($donnees_techniques[$key] === 'f') {
                    $donnees_techniques[$key] = 'false';
                };
                $tab_donnees_techniques[$key] = $donnees_techniques[$key];
            };
        };

        $datas['donnees_techniques'] = $tab_donnees_techniques;

        // Affiche le code INSEE de la collectivité du dossier d'instruction
        /*$collectivite = $this->f->getCollectivite($this->getVal('om_collectivite'));
        $datas['collectivite_insee'] = $collectivite["insee"];*/
        $datas['collectivite_insee'] = $this->get_da_insee();
        //
        return $datas;
    }

    /**
     * Renvoi le code INSEE du DA associé
     */
    protected function get_da_insee() {
        $inst_da = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => $this->getVal('dossier_autorisation')
        ));
        return $inst_da->getVal('insee');
    }

    /**
     * CONDITION - is_class_dossier_corresponding_to_his_groupe
     * 
     * Vérifie la correspondance groupe/classe du dossier instancié.
     *
     * @param  string  $classe
     * @return boolean
     */
    protected function is_class_dossier_corresponding_to_type_form($classe) {
        $type_form = $this->get_type_affichage_formulaire();
        switch ($type_form) {
            case 'DPC';
            case 'ADS':
            case 'CONSULTATION ENTRANTE':
                if ($this->f->starts_with($classe, 'dossier_instruction') === true) {
                    return true;
                }
                return false;
            case 'CTX RE':
                if ($this->f->ends_with($classe, '_recours') === true) {
                    return true;
                }
                return false;
            case 'CTX IN':
                if ($this->f->ends_with($classe, '_infractions') === true) {
                    return true;
                }
                return false;
            default:
                return false;
        }
    }


    /**
     * CONDITION - check_context
     *
     * Vérifie la correspondance groupes dossier/utilisateur.
     * Vérifie l'accès aux dossiers confidentiels.
     * Vérifie la correspondance groupe/classe.
     *
     * @return boolean
     */
    public function check_context() {
        // Le dossier doit être un objet valide
        $id = $this->getVal($this->clePrimaire);
        if ($id === 0 OR $id === '0' OR $id === '' OR $id === ']') {
            return false;
        }

        // Vérification que l'utilisateur a accès au dossier
        if ($this->can_user_access_dossier() === false) {
            return false;
        }
        // Vérification que la classe métier instanciée est adéquate.
        return $this->is_class_dossier_corresponding_to_type_form($this->get_absolute_class_name());
    }

    /**
     * VIEW - redirect.
     *
     * Cette vue est appelée lorsque l'on souhaite consulter un dossier dont on ne connaît pas le groupe.
     * Ce fonctionnement est nécessaire car les classes métier filles de 'dossier' sont relatives à ce groupe.
     *
     * Par exemple, depuis l'onglet "Dossiers Liés" du DI, le listing ne permet pas d'instancier chaque résultat
     * et par conséquent on n'a pas accès au groupe du dossier. L'action tableau consulter y est surchargée afin
     * d'amener à cette vue qui se charge de faire la redirection adéquate.
     *
     * @return void
     */
    public function redirect() {
        // Redirection vers la classe métier adéquate
        $context = $this->get_type_affichage_formulaire();
        switch ($context) {
            case 'ADS':
            case 'CONSULTATION ENTRANTE':
                $obj = 'dossier_instruction';
                break;
            case 'CTX RE':
                $obj = 'dossier_contentieux_tous_recours';
                break;
            case 'CTX IN':
                $obj = 'dossier_contentieux_toutes_infractions';
                break;
            default:
                return;
        }
        $idx = $this->getVal($this->clePrimaire);
        $link = OM_ROUTE_FORM.'&obj='.$obj.'&action=3&idx='.$idx;
        if ($this->f->get_submitted_get_value('retourformulaire') !== null
            && $this->f->get_submitted_get_value('idxformulaire') !== null) {
            $link .= '&premier=0&tricol=&retourformulaire='.$this->f->get_submitted_get_value('retourformulaire');
            $link .= '&idxformulaire='.$this->f->get_submitted_get_value('idxformulaire');
        }
        
        header('Location: '.$link);
        exit();
    }


    /**
     * CONDITION - is_confidentiel
     *
     * Permet de savoir si le type de dossier d'autorisation du dossier courant est
     * confidentiel.
     *
     * @return boolean true si le dossier est confidentiel, sinon false.
     * 
     */
    public function is_confidentiel() {
        //
        $inst_dossier_autorisation_type_detaille = $this->get_inst_dossier_autorisation_type_detaille();
        $inst_dossier_autorisation_type = $this->get_inst_dossier_autorisation_type($inst_dossier_autorisation_type_detaille->getVal('dossier_autorisation_type'));
        $confidentiel = $inst_dossier_autorisation_type->getVal('confidentiel');
        //
        if ($confidentiel === 't') {
            return true;
        }
        return false;
    }


    /**
     * CONDITION - can_user_access_dossier
     *
     * Effectue les vérifications suivantes :
     * - L'utilisateur doit avoir accès au groupe du dossier
     * - Si le dossier est confidentiel, l'utilisateur doit avoir accès aux dossiers
     * confidentiels de ce groupe
     *
     * @return boolean true si les conditions ci-dessus sont réunies, sinon false
     * 
     */
    public function can_user_access_dossier() {
        // Récupère le code du groupe
        $groupe_dossier = $this->get_groupe();

        // Le groupe doit être accessible par l'utilisateur ;
        if ($this->f->is_user_in_group($groupe_dossier) === false) {
            return false;
        }
        if ($this->is_confidentiel() === true) {
            //
            if ($this->f->can_user_access_dossiers_confidentiels_from_groupe($groupe_dossier) === false) {
                return false;
            }
        }
        return true;
    }


    /**
     * Met à jour une métadonnée sur tous les fichiers liés au dossier.
     *
     * @param string $metadata       Nom de la métadonnée.
     * @param string $metadata_value Nouvelle valeur de la métadonnée.
     *
     * @return boolean
     */
    public function update_metadata_by_dossier($metadata, $metadata_value) {
        // Rècupère la liste des fichiers stockés liés au dossier
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    uid AS uid
                FROM
                    %1$sdocument_numerise
                WHERE
                    dossier = \'%2$s\'
                    AND document_numerise IS NOT NULL
                UNION
                SELECT
                    fichier AS uid
                FROM
                    %1$sconsultation
                WHERE
                    dossier = \'%2$s\'
                    AND fichier IS NOT NULL
                UNION
                SELECT
                    om_fichier_consultation AS uid
                FROM
                    %1$sconsultation
                WHERE
                    dossier = \'%2$s\'
                    AND om_fichier_consultation IS NOT NULL
                UNION
                SELECT
                    om_fichier_instruction AS uid
                FROM
                    %1$sinstruction
                WHERE
                    dossier = \'%2$s\'
                    AND om_fichier_instruction IS NOT NULL
                UNION
                SELECT
                    om_fichier_rapport_instruction AS uid
                FROM
                    %1$srapport_instruction
                WHERE
                    dossier_instruction = \'%2$s\'
                    AND om_fichier_rapport_instruction IS NOT NULL;',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
            ),
            array(
                'origin' => __METHOD__
            )
        );

        // Définit la métadonnée à mettre à jour
        $metadata_update = array();
        $metadata_update[$metadata] = $metadata_value;

        // Pour chaque résultat
        foreach ($qres['result'] as $row) {
            // Met à jour les métadonnées du fichier
            $uid_update = $this->f->storage->storage->update_metadata($row['uid'], $metadata_update);

            // Si la méthode ne retourne pas l'uid du fichier alors la mise
            // à jour ne s'est pas réalisée
            if ($uid_update !== $row['uid']) {
                //
                return false;
            }
        }

        //
        return true;
    }


    /**
     * Traitement pour les ERP.
     * Si la valeur du champ 'erp' a été modifié, modifie la valeur de la
     * métadonnée concernceERP sur tous les fichiers liés au dossier.
     *
     * @param array $values Liste des nouvelles valeurs.
     *
     * @return boolean
     */
    public function update_concerneERP(array $values) {
        // Définit le champ et la métadonnée
        $champ = 'erp';
        $metadata = 'concerneERP';

        // Définit les valeurs à comparer
        $value_after = $this->get_boolean_from_view_value($values[$champ]);
        $value_before = $this->get_boolean_from_pgsql_value($this->getVal($champ));

        // Vérifie si la valeur du champ a été modifié
        if ($value_after !== $value_before) {
            // Transforme la valeur booléenne en string
            $metadata_value = 'false';
            if ($value_after === true) {
                $metadata_value = 'true';
            }

            // Met à jour les métadonnées des fichiers liés au dossier
            $update = $this->update_metadata_by_dossier($metadata, $metadata_value);
            //
            if ($update !== true) {
                //
                return false;
            }
        }

        //
        return true;
    }


    /**
     * TODO: replace with '$this->f->findObjectById' ?
     *
     * Récupère l'instance du groupe.
     *
     * @param string $groupe Identifiant du groupe.
     *
     * @return object
     */
    private function get_inst_groupe($groupe) {
        //
        return $this->get_inst_common("groupe", $groupe);
    }


    /**
     * TODO: replace with '$this->f->findObjectById' ?
     *
     * Récupère l'instance du type de dossier d'autorisation.
     *
     * @param string $dossier_autorisation_type Identifiant du type de dossier
     * d'autorisation.
     *
     * @return object
     */
    private function get_inst_dossier_autorisation_type($dossier_autorisation_type) {
        //
        return $this->get_inst_common("dossier_autorisation_type", $dossier_autorisation_type);
    }


    /**
     * Récupère l'instance de la demande du dossier
     *
     * @param mixed Identifiant de la demande
     *
     * @return object
     */
    function get_inst_demande($demande = null) {
        //
        if (is_null($this->inst_demande)) {
            //
            if (is_null($demande)) {
                $demande = $this->get_demande_by_dossier_instruction();
            }
            //
            return $this->get_inst_common("demande", $demande);
        }
        //
        return $this->inst_demande;
    }


    /**
     * Récupère l'identifiant de la demande initiale par le dossier d'instruction.
     *
     * @return integer|null renvoie l'identifiant de la demande ou null si
     * rien n'a été récupéré
     */
    function get_demande_by_dossier_instruction() {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    demande
                FROM
                    %1$sdemande
                WHERE
                    dossier_instruction = \'%2$s\'
                ORDER BY
                    instruction_recepisse ASC
                LIMIT 1',
                DB_PREFIXE,
                $this->getVal($this->clePrimaire)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        return $qres["result"];
    }

    /**
     * TREATMENT - update_last_modification_date.
     * 
     * Cette methode met à jour la date de dernière modification du dossier.
     *
     * @return boolean
     */
    public function update_last_modification_date() {
        //
        $this->begin_treatment(__METHOD__);
        //
        $this->correct = true;
        $valF = array();
        $valF["date_modification"] = 'NOW';
        //
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.$this->table, 
            $valF, 
            DB_AUTOQUERY_UPDATE,
                $this->clePrimaire." = '".$this->getVal($this->clePrimaire)."'"
        );
        if ($this->f->isDatabaseError($res, true)) {
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        } else {
            return $this->end_treatment(__METHOD__, true);
        }
        //
        return $this->end_treatment(__METHOD__, false);
    }

    /**
     * TREATMENT - update_hash_sitadel.
     * 
     * Cette methode met à jour le hash SITADEL du dossier.
     *
     * @return boolean
     */
    public function update_hash_sitadel($hash_sitadel = null) {
        //
        $this->begin_treatment(__METHOD__);
        //
        if ($hash_sitadel !== null && $hash_sitadel !== '') {
            //
            $this->correct = true;
            $valF = array();
            $valF["hash_sitadel"] = $hash_sitadel;
            //
            $res = $this->f->db->autoExecute(
                DB_PREFIXE.$this->table, 
                $valF, 
                DB_AUTOQUERY_UPDATE,
                $this->clePrimaire." = '".$this->getVal($this->clePrimaire)."'"
            );
            if ($this->f->isDatabaseError($res, true)) {
                $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
                $this->correct = false;
                return $this->end_treatment(__METHOD__, false);
            } else {
                return $this->end_treatment(__METHOD__, true);
            }
        }
        //
        return $this->end_treatment(__METHOD__, false);
    }

    /**
     * TREATMENT - update_version_clos
     *
     * @param string $mode Mode de mise à jour ("up" ou "down")
     *
     * @return boolean
     */
    public function update_version_clos($mode) {
        //
        $this->begin_treatment(__METHOD__);
        //
        if ($mode !== 'up' && $mode !== 'down') {
            return $this->end_treatment(__METHOD__, false);
        }
        //
        $inst_da = $this->get_inst_dossier_autorisation($this->getVal("dossier_autorisation"));
        $da_version_clos = $inst_da->getval('numero_version_clos');
        //
        $this->correct = true;
        $data = array();
        $data["version_clos"] = 0;
        if ($da_version_clos !== null
            && $da_version_clos !== '') {
            //
            if ($mode === 'up') {
                $data["version_clos"] = intval($da_version_clos)+1;
                $inst_da->update_numero_version_clos($data["version_clos"]);
            }
            if ($mode === 'down') {
                $data["version_clos"] = null;
            }
        } else {
            $inst_da->update_numero_version_clos($data["version_clos"]);
        }
        //
        $res = $this->f->db->autoExecute(
            sprintf('%s%s', DB_PREFIXE, $this->table),
            $data,
            DB_AUTOQUERY_UPDATE,
            sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
        );
        $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($data, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true) === true) {
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Récupère l'identifiant de l'état car le getVal() récupère le libellé.
     *
     * @return mixed Soit un string, soit "false"
     */
    function get_id_etat() {
        $dossier = $this->f->get_inst__om_dbform(array(
            'obj' => 'dossier',
            'idx' => $this->getVal($this->clePrimaire)
        ));
        return $dossier->getVal('etat');
    }

    /**
     * Methode clesecondaire
     * 
     * Vérifications Effectuées :
     *   - Vérifie si le dossier est lié à un contentieux. Si c'est le cas
     *     affiche un message d'erreur personnalisé et ne lance pas la
     *     la vérification des clé étrangère.
     */
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // Le dossier d'instruction n'est pas supprimé si celui-ci est lié à un contentieux
        $autorisation_contestee = $this->get_idx_by_args(
            'autorisation_contestee',
            'dossier',
            'autorisation_contestee',
            $this->getVal($this->clePrimaire)
        );
        if (! empty($autorisation_contestee)) {
            $this->addToMessage(__("Le dossier d'instruction ne peut pas être supprimé car celui-ci est lié à un contentieux."));
            $this->correct = false;
            return;
        }
        parent::cleSecondaire($id, $dnu1, $val, $dnu2);
    }

    /**
     * Surcharge de la méthode rechercheTable pour éviter de court-circuiter le 
     * générateur en devant surcharger la méthode cleSecondaire afin de supprimer
     * les éléments liés dans les tables NaN.
     *
     * Vérifications Effectuées :
     *   - Vérifie si la table à chercher fait partie des tables que l'on va
     *     supprimer si c'est le cas la vérification de la présence d'élement
     *     n'est pas faite
     *
     * @param mixed  $dnu1      Instance BDD - À ne pas utiliser
     * @param string $table     Table
     * @param string $field     Champ
     * @param mixed  $id        Identifiant
     * @param mixed  $dnu2      Marqueur de débogage - À ne pas utiliser
     * @param string $selection Condition de la requête
     *
     * @return void
     */
    function rechercheTable(&$dnu1 = null, $table = "", $field = "", $id = null, $dnu2 = null, $selection = "") {    
        // Dans le cas d'une suppression du dossier d'instruction, les tables
        // liées ne sont pas vérifiées
        if (! isset($this->related_tables)) {
            $this->set_related_tables();
        }
        // Récupère le nom des tables de liaison à partir de la liste des tables liées.
        // Vérifie pour chaque élément du tableau des liaisons si il existe une clé "table".
        // Si c'est le cas on récupère le nom de la table dans cette entrée si ce n'est pas
        // le cas on récupère la clé de l'élement car il dois contenir le nom de la table.
        // Ensuite supprime les doublons et renvoie un tableau contenant le nom des tables
        // liées pour lesquels la suppression va être effectuée.
        $liaison_suppr = array_unique( // supprime les doublons
            array_map(function($value, $key) { // Récupère le nom des tables de liaison
                    return ! empty($value['table']) ? $value['table'] : $key;
                },
                $this->related_tables,
                array_keys($this->related_tables)
            ),
            SORT_STRING
        );

        if ($this->get_action_crud() === 'delete'
            && in_array($table, $liaison_suppr) === true) {
            // Annule la vérif
            $this->addToLog(__METHOD__."(): ".__("Dans le cas spécifique de la suppression du dossier d'instruction, les tables liées ne sont pas vérifiées."), EXTRA_VERBOSE_MODE);
            return;
        }

        parent::rechercheTable($this->f->db, $table, $field, $id, null, $selection);
    }

    /**
     * Effectue une requête sql pour récupérer la liste des id des demandeurs
     * associé au dossier et l'indicateur permettant de savoir si c'est un
     * demandeur principal ou pas.
     * Renvoi les résultats sous la forme d'un tableau.
     *
     * @return array|boolean tableau contenant les infos des demandeurs et false
     * en cas d'erreur de base de données.
     */
    public function get_demandeurs() {
        $query = sprintf('
            SELECT
                demandeur.demandeur,
                lien_dossier_demandeur.petitionnaire_principal,
                demandeur.type_demandeur
            FROM
                %1$sdemandeur
                INNER JOIN %1$slien_dossier_demandeur
                    ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE
                lien_dossier_demandeur.dossier = \'%2$s\'',
            DB_PREFIXE,
            $this->getVal($this->clePrimaire)
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            return false;
        }
        return $res['result'];
    }

    /**
     * TREATMENT - normalize_address
     *
     * Enregistre en base de données les valeurs concernant l'adresse normalisée.
     *
     * @param  string $address      Valeur de l'adresse normalisée.
     * @param  string $address_json JSON de toutes les données de l'adresse normalisée.
     * @return boolean
     */
    public function normalize_address(string $address = null, string $address_json = '{}') {
        //
        $this->begin_treatment(__METHOD__);
        // Valeurs par défaut si l'adresse normalisée est vide
        if ($address === '') {
            $address = null;
            $address_json = '{}';
        }
        // Valeur par défaut pour le JSON de l'adresse si l'adresse saisie ne
        // correspond au label du JSON, donc adresse non sélectionnée parmis les
        // résultats retourner par l'API adresse
        if ($address !== null) {
            $address_json_decode = json_decode($address_json, true);
            if (isset($address_json_decode['label']) === true
                && $address !== $address_json_decode['label']) {
                //
                $address_json = '{}';
            }
        }
        //
        $this->correct = true;
        $data = array();
        $data["adresse_normalisee"] = $address;
        $data["adresse_normalisee_json"] = $address_json;
        //
        $res = $this->f->db->autoExecute(
            sprintf('%s%s', DB_PREFIXE, $this->table),
            $data,
            DB_AUTOQUERY_UPDATE,
            sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
        );
        $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($data, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true) === true) {
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }
        return $this->end_treatment(__METHOD__, true);
    }

    public function get_last_instruction_decision() {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    instruction.instruction
                FROM
                    %1$sinstruction
                    INNER JOIN %1$sdossier
                        ON dossier.dossier = instruction.dossier
                    INNER JOIN %1$setat
                        ON dossier.etat = etat.etat
                WHERE
                    instruction.etat = dossier.etat
                    AND instruction.dossier = \'%2$s\'
                    AND etat.statut = \'cloture\'
                ORDER BY
                    instruction.instruction DESC
                LIMIT 1',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal('dossier'))
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        return $qres["result"];
    }

    /**
     * VIEW - view_normalize_address.
     *
     * Formulaire de recherche de l'adresse normalisée.
     *
     * @return void
     */
    public function view_normalize_address() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Par défaut l'adresse saisie est celle renseignée sur le dossier
        $address_val = trim(preg_replace('/\s\s+/', ' ', sprintf('%s %s %s %s %s %s %s',
            $this->getVal('terrain_adresse_voie_numero'),
            $this->getVal('terrain_adresse_voie'),
            $this->getVal('terrain_adresse_lieu_dit'),
            $this->getVal('terrain_adresse_localite'),
            $this->getVal('terrain_adresse_code_postal'),
            $this->getVal('terrain_adresse_bp'),
            $this->getVal('terrain_adresse_cedex')
        )));
        $address_val_json = '{}';
        if ($this->getVal('adresse_normalisee') !== null
            && $this->getVal('adresse_normalisee') !== '') {
            //
            $address_val = $this->getVal('adresse_normalisee');
            $address_val_json = htmlentities($this->getVal('adresse_normalisee_json'));
            if ($this->f->get_submitted_post_value("submit-normalize") === null) {
                $this->f->displayMessage("error", __("L'adresse de ce terrain a déjà été normalisée."));
            }
        }

        /**
         * TREATMENT
         */
        // Traitement si validation du formulaire
        if ($this->f->get_submitted_post_value("submit-normalize") !== null) {
            //
            $this->normalize_address($_POST["address"], $_POST["address_json"]);
            return;
        }

        // Formulaire de validation
        $this->f->layout->display__form_container__begin(array(
            "action" => "",
            "name" => "f2_normalize_address",
            "onsubmit" => "normalize_address(this);return false;",
        ));
        //
        printf('
            <div id="sousform-href" data-href="%s"></div>',
            $this->compose_form_url("form", array(
                "validation" => null,
                "maj" => 160,
                "retour" => "form",
            ))
        );
        $champs = array('address', 'address_json', );
        // Instanciation de l'objet formulaire
        $this->form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => $this->getParameter("maj"),
            "champs" => $champs,
        ));
        // Paramétrage des champs du formulaire
        // address
        $this->form->setLib("address", __("adresse à normaliser"));
        $this->form->setTaille("address", 60);
        $this->form->setMax("address", 255);
        $this->form->setType("address", "text");
        $this->form->setVal('address', $address_val);
        // address_json
        $this->form->setType("address_json", "hidden");
        $this->form->setVal('address_json', $address_val_json);
        $this->f->displayDescription(__("Veuillez sélectionner l'adresse normalisée qui se rapproche le plus de l'adresse du terrain."));
        // Ouverture du conteneur de formulaire
        $this->form->entete();
        $this->form->afficher($champs, 0, false, false);
        $this->form->enpied();
        $this->f->layout->display__form_controls_container__begin(array(
            "controls" => "bottom",
        ));
        $this->f->layout->display__form_input_submit(array(
            "name" => "submit-normalize",
            "value" => __("Normaliser l'adresse"),
            "class" => "boutonFormulaire",
        ));
        $this->f->layout->display__form_controls_container__end();
        //
        $this->f->layout->display__form_container__end();
    }


    public function get_last_instruction_incompletude() {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    instruction.instruction
                FROM
                    %1$sinstruction
                    INNER JOIN %1$sevenement
                        ON evenement.evenement = instruction.evenement
                WHERE
                    instruction.dossier = \'%2$s\'
                    AND evenement.type = \'incompletude\'
                ORDER BY
                    instruction.instruction DESC
                LIMIT 1',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal('dossier'))
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        return $qres["result"];
    }

    function get_max_num_suffixe($dat_c, $annee, $dep_c, $com_c, $num) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    MAX(numerotation_num_suffixe) AS max_num_suffixe
                FROM
                    %1$sdossier
                WHERE
                    numerotation_type = \'%2$s\'
                    AND annee = \'%3$s\'
                    AND numerotation_dep = \'%4$s\'
                    AND numerotation_com = \'%5$s\'
                    AND numerotation_num = \'%6$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dat_c),
                $this->f->db->escapeSimple($annee),
                $this->f->db->escapeSimple($dep_c),
                $this->f->db->escapeSimple($com_c),
                $this->f->db->escapeSimple($num)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return null;
        }
        return $qres["result"];
    }

    public function view_json_data() {
        $this->checkAccessibility();
        $this->f->disableLog();
        $view = $this->get_json_data();
        printf(json_encode($view));
    }

    public function get_json_data() {
        $val = array_combine($this->champs, $this->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        $inst_datd = $this->get_inst_dossier_autorisation_type_detaille();
        $inst_dat = $this->get_inst_dossier_autorisation_type($inst_datd->getVal('dossier_autorisation_type'));
        $val['dossier_autorisation_type_detaille_code'] = $inst_datd->getVal('code');
        $val['dossier_autorisation_type_code'] = $inst_dat->getVal('code');
        $val['dossier_instruction_type_code'] = $this->getCode($this->getVal('dossier_instruction_type'));
        $val['dossier_suffixe'] = '';
        if ($this->getSuffixe($this->getVal('dossier_instruction_type')) === 't') {
            $val['dossier_suffixe'] = sprintf('%s%s',
                $this->getCode($this->getVal('dossier_instruction_type')),
                $this->get_di_numero_suffixe()
            );
        }
        /*$parameters = $this->f->getCollectivite($this->getVal('om_collectivite'));
        $val['insee'] = $parameters['insee'];*/
        $val['insee'] = $this->get_da_insee();
        $inst_ac = $this->get_inst_autorite_competente($val['autorite_competente']);
        $val['autorite_competente_code'] = $inst_ac->getVal('code');
        $val['source_depot'] = $this->get_source_depot_from_demande();
        return $val;
    }

    public function update_by_instruction(array $val, array $extra_params = array()) {
        $this->begin_treatment(__METHOD__);
        // XXX Supprime les champs qui n'existent pas dans dossier
        $valF = $val;
        unset($valF['instruction']);
        unset($valF['crud']);
        if (empty($valF) === false) {
            $res = $this->f->db->autoExecute(
                sprintf('%s%s', DB_PREFIXE, $this->table),
                $valF,
                DB_AUTOQUERY_UPDATE,
                sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
            );
            $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
                $this->correct = false;
                return $this->end_treatment(__METHOD__, false);
            }
        }
        $trigger = $this->trigger_update_by_instruction($val);
        if ($trigger === false) {
            $this->addToLog(__METHOD__."(): ".__("Erreur lors de la mise à jour par instruction."), DEBUG_MODE);
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }
        return $this->end_treatment(__METHOD__, true);
    }

    protected function trigger_update_by_instruction(array $val, array $extra_params = array()) {
        foreach ($this->task_types as $task_type) {
            $method = sprintf('add_task_%s', $task_type);
            if (method_exists($this, $method) === true) {
                //
                if ($this->f->is_type_dossier_platau($this->getVal('dossier_autorisation')) === true
                    && $this->getVal('etat_transmission_platau') !== 'jamais_transmissible'
                    && ($this->f->is_option_mode_service_consulte_enabled() !== true
                        || ($this->f->is_option_mode_service_consulte_enabled() === true
                        && ($this->get_source_depot_from_demande() === PLATAU
                            || $this->get_source_depot_from_demande() === PORTAL)))) {
                    //
                    $res = $this->$method($val, $extra_params);
                    if ($res !== true) {
                        return $res;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche pec_metier_consultation, sortante si le tableau des valeurs
     * contiens :
     *  - une entrée "pec_metier" n'ont vide
     *
     * Si le mode service consulte n'est pas activé et que le dossier est "non transmissible"
     * la tâche sera à l'état "draft". Sinon son état est "New".
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    protected function add_task_pec_metier_consultation(array $val, array $extra_params = array()) {
        if (array_key_exists("pec_metier", $val) === true
            && $val['pec_metier'] !== null
            && $val['pec_metier'] !== '') {
            //
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => 'pec_metier_consultation',
                'object_id' => $val['instruction'],
                'dossier' => $this->getVal($this->clePrimaire),
            );
            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && $this->getVal('etat_transmission_platau') === 'non_transmissible') {
                $task_val['state'] = $inst_task::STATUS_DRAFT;
            }
            $add_task = $inst_task->add_task(array('val' => $task_val));
            if ($add_task === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche qualification_DI, sortante si le tableau des valeurs
     * contiens :
     *  - une entrée "autorite_competente" ayant une valeur différente de celle du dossier
     *
     * Si le mode service consulte n'est pas activé et que le dossier est "non transmissible"
     * la tâche sera à l'état "draft". Sinon son état est "New".
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    protected function add_task_qualification_DI(array $val, array $extra_params = array()) {
        if (array_key_exists("autorite_competente", $val) === true
            && $val["autorite_competente"] !== $this->getVal('autorite_competente')) {
            //
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => 'qualification_DI',
                'object_id' => $val['instruction'],
                'dossier' => $this->getVal($this->clePrimaire),
            );
            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && $this->getVal('etat_transmission_platau') === 'non_transmissible') {
                $task_val['state'] = $inst_task::STATUS_DRAFT;
            }
            $add_task = $inst_task->add_task(array('val' => $task_val));
            if ($add_task === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche decision_DI, sortante si le tableau des valeurs
     * contiens :
     *  - une entrée "date_decision" non vide
     *  - une entrée "avis_decision" non vide
     *  - une entrée "crud" qui n'a pas pour valeur 'delete'
     * et si l'avis de décision n'a pas de prescription.
     *
     * Si le mode service consulte n'est pas activé et que le dossier est "non transmissible"
     * la tâche sera à l'état "draft". Sinon son état est "New".
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    protected function add_task_decision_DI(array $val, array $extra_params = array()) {
        if (array_key_exists("date_decision", $val) === true
            && array_key_exists("avis_decision", $val) === true
            && !empty($val['date_decision'])
            && !empty($val['avis_decision'])
            && array_key_exists("crud", $val) === true
            && $val['crud'] !== 'delete') {
            //
            $inst_ad = $this->f->get_inst__om_dbform(array(
                "obj" => "avis_decision",
                "idx" => $val['avis_decision'],
            ));
            if ($inst_ad->getVal('prescription') === 'f') {
                //
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => 0,
                ));
                $task_val = array(
                    'type' => 'decision_DI',
                    'object_id' => $val['instruction'],
                    'dossier' => $this->getVal($this->clePrimaire),
                );
                if ($this->f->is_option_mode_service_consulte_enabled() === false
                    && $this->getVal('etat_transmission_platau') === 'non_transmissible') {
                    $task_val['state'] = $inst_task::STATUS_DRAFT;
                }
                $add_task = $inst_task->add_task(array('val' => $task_val));
                if ($add_task === false) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche avis_consultation, sortante si le tableau des valeurs
     * contiens :
     *  - une entrée "date_decision" non vide
     *  - une entrée "avis_decision" non vide
     *  - une entrée "crud" qui n'a pas pour valeur 'delete'
     * et si l'avis de décision n'a pas de prescription.
     *
     * Si le mode service consulte n'est pas activé et que le dossier est "non transmissible"
     * la tâche sera à l'état "draft". Sinon son état est "New".
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    protected function add_task_avis_consultation(array $val, array $extra_params = array()) {
        if (array_key_exists("date_decision", $val) === true
            && array_key_exists("avis_decision", $val) === true
            && !empty($val['date_decision'])
            && !empty($val['avis_decision'])
            && array_key_exists("crud", $val) === true
            && $val['crud'] !== 'delete') {
            //
            $inst_ad = $this->f->get_inst__om_dbform(array(
                "obj" => "avis_decision",
                "idx" => $val['avis_decision'],
            ));
            if ($inst_ad->getVal('prescription') === 'f') {
                //
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => 0,
                ));
                $task_val = array(
                    'type' => 'avis_consultation',
                    'object_id' => $val['instruction'],
                    'dossier' => $this->getVal($this->clePrimaire),
                );
                if ($this->f->is_option_mode_service_consulte_enabled() === false
                    && $this->getVal('etat_transmission_platau') === 'non_transmissible') {
                    $task_val['state'] = $inst_task::STATUS_DRAFT;
                }
                $add_task = $inst_task->add_task(array('val' => $task_val));
                if ($add_task === false) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche prescription, sortante si le tableau des valeurs
     * contiens :
     *  - une entrée "date_decision" non vide
     *  - une entrée "avis_decision" non vide
     *  - une entrée "crud" qui n'a pas pour valeur 'delete'
     * et si l'avis de décision à une prescription.
     *
     * Si le mode service consulte n'est pas activé et que le dossier est "non transmissible"
     * la tâche sera à l'état "draft". Sinon son état est "New".
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    protected function add_task_prescription(array $val, array $extra_params = array()) {
        if (array_key_exists("date_decision", $val) === true
            && array_key_exists("avis_decision", $val) === true
            && !empty($val['date_decision'])
            && !empty($val['avis_decision'])
            && array_key_exists("crud", $val) === true
            && $val['crud'] !== 'delete') {
            //
            $inst_ad = $this->f->get_inst__om_dbform(array(
                "obj" => "avis_decision",
                "idx" => $val['avis_decision'],
            ));
            if ($inst_ad->getVal('prescription') === 't') {
                //
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => 0,
                ));
                $task_val = array(
                    'type' => 'prescription',
                    'object_id' => $val['instruction'],
                    'dossier' => $this->getVal($this->clePrimaire),
                );
                if ($this->f->is_option_mode_service_consulte_enabled() === false
                    && $this->getVal('etat_transmission_platau') === 'non_transmissible') {
                    $task_val['state'] = $inst_task::STATUS_DRAFT;
                }
                $add_task = $inst_task->add_task(array('val' => $task_val));
                if ($add_task === false) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche completude_DI, sortante à l'état "draft" si le tableau des valeurs
     * contiens :
     *  - une entrée "incomplet_notifie" qui a pour valeur 'f'
     *  - une entrée "crud" qui n'a pas pour valeur 'delete'
     *  - pas d'entrée "avis_decision"
     *  - pas d'entrée "date_decision"
     *
     * Si le mode service consulte n'est pas activé et que le dossier est "non transmissible"
     * la tâche sera à l'état "draft". Sinon son état est "New".
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    protected function add_task_completude_DI(array $val, array $extra_params = array()) {
        if (array_key_exists("incomplet_notifie", $val) === true
            && $val['incomplet_notifie'] === 'f'
            && $this->getVal('incomplet_notifie') === 't'
            && array_key_exists("crud", $val) === true
            && $val['crud'] !== 'delete'
            && empty($val['date_decision'])
            && empty($val['avis_decision'])) {
            //
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => 'completude_DI',
                'object_id' => $val['instruction'],
                'dossier' => $this->getVal($this->clePrimaire),
            );
            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && $this->getVal('etat_transmission_platau') === 'non_transmissible') {
                $task_val['state'] = $inst_task::STATUS_DRAFT;
            }
            $add_task = $inst_task->add_task(array('val' => $task_val));
            if ($add_task === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche incompletude_DI, sortante à l'état "draft" si le tableau des valeurs
     * contiens une entrée "incomplet_notifie" qui a pour valeur 't' et une entrée "crud"
     * qui n'a pas pour valeur 'delete'.
     * Si la tâche d'incompletude est bien ajoute une tâche lettre_incompletude est également
     * ajoutée.
     *
     * Si le mode service consulte n'est pas activé et que le dossier est "non transmissible"
     * la tâche incompletude_DI sera à l'état "draft". Sinon son état est "New".
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    public function add_task_incompletude_DI(array $val, array $extra_params = array()) {
        if (array_key_exists("incomplet_notifie", $val) === true
            && $val['incomplet_notifie'] === 't'
            && $this->getVal('incomplet_notifie') !== 't'
            && array_key_exists("crud", $val) === true
            && $val['crud'] !== 'delete') {
            //
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => 'incompletude_DI',
                'object_id' => $val['instruction'],
                'dossier' => $this->getVal($this->clePrimaire),
            );
            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && $this->getVal('etat_transmission_platau') === 'non_transmissible') {
                $task_val['state'] = $inst_task::STATUS_DRAFT;
            }
            $add_task = $inst_task->add_task(array('val' => $task_val));
            if ($add_task === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche lettre_incompletude, sortante si le tableau des valeurs contiens une
     * entrée "incomplet_notifie" qui a pour valeur 't', que le dossier visé n'est pas déjà en
     * incomplet notifié, et une entrée "crud" qui n'a pas pour valeur
     * 'delete'.
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    public function add_task_lettre_incompletude(array $val, array $extra_params = array()) {
        if (array_key_exists("incomplet_notifie", $val) === true
            && $val['incomplet_notifie'] === 't'
            && $this->getVal('incomplet_notifie') !== 't'
            && array_key_exists("crud", $val) === true
            && $val['crud'] !== 'delete') {
            // Ajout de la tâche de lettre du premier mois
            $extra_params['type'] = 'incompletude';
            if ($this->add_task_lettre_petitionnaire($val, $extra_params) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche lettre_majoration, sortante si le tableau des valeurs contiens une
     * entrée "delai" qui a une valeur différente du "delai" du dossier d'instruction
     * et une entrée "crud" qui n'a pas pour valeur 'delete'.
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    public function add_task_lettre_majoration(array $val, array $extra_params = array()) {
        if (array_key_exists("delai", $val) === true
            && $val['delai'] !== null
            && $val['delai'] !== ''
            && intval($this->getVal('delai')) !== 0
            && array_key_exists("crud", $val) === true
            && $val['crud'] !== 'delete') {
            // Ajout de la tâche de lettre du premier mois
            $extra_params['type'] = 'majoration';
            if ($this->add_task_lettre_petitionnaire($val, $extra_params) === false) {
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute une tâche de lettre au pétitionnaire en fonction du type fournis dans les
     * extra_params.
     *  - si extra_params n'a pas d'entrée type ou que cette entrée est vide, ajoute une
     *  tâche lettre_petitionnaire
     *  - si l'entrée type existe et n'est pas vide ajoute une tâche lettre_[type fourni]
     * /!\ Seule les tâches lettre_majoration et lettre_incompletude existent pour le moment
     *     et peuvent être ajoutée.
     *
     * L'instruction doit être liée directement ou indirectement à un courrier.
     *
     * @param array $val : tableau de valeur servant à l'ajout de la tâche
     * @param array $extra_params : tableau contenant des paramètres supplémentaire servant
     * à l'ajout de la tâche
     * 
     * @return boolean true : traitement ok, false : erreur de traitement
     */
    public function add_task_lettre_petitionnaire(array $val, array $extra_params = array()) {
        // Vérification de l'existance d'un courrier
        $with_doc = false;
        if (array_key_exists("instruction", $val) === true
            && $val['instruction'] !== ''
            && $val['instruction'] !== null) {
            //
            $inst_instruction = $this->f->get_inst__om_dbform(array(
                'obj' => 'instruction',
                'idx' => $val['instruction']
            ));
            // L'instruction executant ce code n'est pas porteur du document
            if ($inst_instruction->getVal('lettretype') !== null
                && $inst_instruction->getVal('lettretype') !== '') {
                //
                $with_doc = true;
            } else {
                // Recherche dans les instructions liés s'il y a un document
                $inst_ev = $this->f->get_inst__om_dbform(array(
                    "obj" => "evenement",
                    "idx" => $inst_instruction->getVal('evenement'),
                ));
                if ($inst_ev->getVal('retour') === 't') {
                    $instructions_related = $inst_instruction->get_related_instructions();
                    foreach ($instructions_related as $instruction) {
                        if ($instruction !== null && $instruction !== '') {
                            $inst_related_instruction = $this->f->get_inst__om_dbform(array(
                                "obj" => "instruction",
                                "idx" => $instruction,
                            ));
                            if ($inst_related_instruction->getVal('om_fichier_instruction') !== null
                                && $inst_related_instruction->getVal('om_fichier_instruction') !== '') {
                                //
                                $with_doc = true;
                            }
                        }
                    }
                }
            }
        }
        //
        if ($with_doc === true) {
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => (! empty($extra_params['type']) ? 'lettre_'.$extra_params['type'] : 'lettre_petitionnaire'),
                'object_id' => $val['instruction'],
                'dossier' => $this->getVal($this->clePrimaire),
            );
            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && $this->getVal('etat_transmission_platau') === 'non_transmissible') {
                $task_val['state'] = $inst_task::STATUS_DRAFT;
            }
            $add_task_lettre = $inst_task->add_task(array('val' => $task_val));
            return $add_task_lettre !== false;
        }
        return true;
    }

    public function get_parcelles($dossier = null) {
        if ($dossier === null) {
            $dossier = $this->getVal('dossier');
        }
        $query = sprintf('
            SELECT *
            FROM %1$sdossier_parcelle
            WHERE dossier = \'%2$s\'
            ORDER BY dossier_parcelle
            ',
            DB_PREFIXE,
            $dossier
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            return false;
        }
        return $res['result'];
    }

    protected function getDossier($champ = null) {
        return $this->getVal($this->clePrimaire);
    }

    protected function getDossierObject() {
        return $this;
    }

    /**
     * Recupère la source du dépôt
     *
     * @return string source du dépôt
     */
    public function get_source_depot_from_demande() {
        $demande = $this->get_inst_demande();
        return $demande->getVal('source_depot');
    }

    /**
     * Récupère l'instance de consultation entrante associé au dossier.
     *
     * @return consultation_entrante
     */
    public function get_inst_consultation_entrante() {
        $dossier = $this->getVal($this->clePrimaire);
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    consultation_entrante
                FROM
                    %1$sconsultation_entrante
                WHERE
                    dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__
            )
        );
        $consultationEntrante = $this->f->get_inst__om_dbform(array(
            'obj' => 'consultation_entrante',
            'idx' => $qres['result']
        ));
        return $consultationEntrante;
    }

    /**
     * Récupère l'instance du département lié à la commune du dossier.
     *
     * @return departement
     */
    public function get_inst_departement_dossier() {
        // Si le dossier n'a pas de commune associé alors il n'est pas non
        // plus associé à un département. On renvoie donc null.
        if (empty($this->getVal('commune'))) {
            return null;
        }
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    departement
                FROM
                    %1$scommune
                    LEFT JOIN %1$sdepartement
                        ON commune.dep = departement.dep
                WHERE
                    commune = %2$s',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal('commune'))
            ),
            array(
                "origin" => __METHOD__
            )
        );
        $departement = $this->f->get_inst__om_dbform(array(
            'obj' => 'departement',
            'idx' => $qres['result']
        ));
        return $departement;
    }


    /**
     * Met à jour les informations (log) d'actions de localisation sur un dossier.
     *
     * @param string  $action  Nom de l'action.
     * @param string  $date    Date de l'action.
     * @param boolean $etat    Etat de l'action.
     * @param string  $message Message de retour de l'action.
     *
     * @return boolean false si erreur de traitement, true sinon.
     */
    public function update_dossier_geolocalisation($action, $date, $etat, $message, $dossier = null) {
        if ($dossier == null) {
            $dossier = $this->getVal('dossier');
        }
        require_once "../obj/dossier_geolocalisation.class.php";
        $dossier_geolocalisation = new dossier_geolocalisation(
                                            null,
                                            null,
                                            null,
                                            $dossier
                                        );

        return $dossier_geolocalisation->set_geolocalisation_state(
                                            $action,
                                            $date,
                                            $etat,
                                            $message
                                        );
    }


    /**
     * Retourne une instance du connecteur geoads, et la créer si elle n'existe pas.
     *
     * @param array $collectivite Informations de la collectivité.
     *
     * @return geoads Instance du connecteur.
     */
    protected function get_geoads_instance(array $collectivite, string $dossierIdx) {
        $extra_params = array(
            "inst_framework" => $this->f,
            "dossier_idx" => $dossierIdx,
        );
        // Instanciation de l'abstracteur geoads
        try {
            $this->geoads_instance = new geoads($collectivite, $extra_params);
        } catch (geoads_exception $e) {
            $this->handle_geoads_exception($e, $dossierIdx);
            return false;
        }
        return $this->geoads_instance;
    }


    /**
     * Traitement des erreurs retournées par l'abstracteur geoads.
     *
     * @param geoads_exception $exception Exception retournée par l'abstracteur.
     *
     * @return void
     */
    protected function handle_geoads_exception(geoads_exception $exception, $dossierId = null) {
        if ($dossierId == null) {
            $dossierId = $this->getVal("dossier");
        }
        // log le message d'erreur retourné par le webservice
        $this->f->addToLog(
            "geolocalisation : Traitement webservice SIG: id dossier = ".
            $dossierId." : ".$exception->getMessage(), DEBUG_MODE
        );
        $return['log'] = array(
            "date" => date('d/m/Y H:i:s'),
            "etat" => false,
            "message" => $exception->getMessage(),
        );
        if ($this->f->isAjaxRequest()) {
            echo json_encode($return);
            die(); // TODO traiter correctement les erreurs !
        } else {
            $this->f->displayMessage('error', $return["log"]["message"]);
        }
    }


    /**
     * Réplication de la géolocalisation d'un dossier sur un autre.
     *
     * @param  string  $di            Identifiant du DI qui va être mis à jour
     * @param  string  $da            Identifiant du DA associé au DI
     * @param  string  $collectivite  Identifiant de la collectivité associée au DI
     * @param  string  $commune       (Optionel) Identifiant de la commune associée au DI
     * @param  string  $ref           (Optionel) Identifiant de DI contenant la géolocalisation à répliquer
     *
     * @return bool|string  'true' si tout s'est bien passé, sinon un message d'erreur
     */
    public function replicate_geolocalisation(string $di, string $da, string $collectivite,
                                              string $commune = null, string $ref = null) {
        $this->addToLog(__METHOD__."() BEGIN", EXTRA_VERBOSE_MODE);

        if (empty($di)) {
            $di = $this->getVal('dossier');
        }

        // si le sig est activé/configuré
        if ($this->f->is_option_sig_enabled($collectivite)) {

            // récupération du DI qui vient d'être créé
            if (empty($di_inst = $this->f->findObjectById('dossier', $di))) {
                return sprintf(
                    __("Erreur lors de la récupération du DI %s (dossier non-trouvé)"),
                    $di);
            }

            // si un dossier référence est spécifié
            if (! empty($ref)) {
                $prev_di_idx = $ref;
                $err_msg = sprintf(__("Erreur lors de la récupération du DI référence %s"), $ref);
            }

            // aucun dossier référence spécifié
            else {

                // si on est en mode service consulté, cela concerne des consultations
                // et il faut également rechercher un dossier de même type DI
                $sameTypeWhereCond = '';
                if ($this->f->is_option_mode_service_consulte_enabled($collectivite)) {
                    $sameTypeWhereCond = 'AND dossier_instruction_type = '.
                        intval($di_inst->getVal('dossier_instruction_type'));
                }

                // récupération du DI le plus récent sur le DA
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf("
                        SELECT
                            dossier
                        FROM
                            ".DB_PREFIXE."dossier
                        WHERE
                            om_collectivite = '%s'
                            AND dossier_autorisation = '%s'
                            AND version < %d
                            AND dossier != '%s'
                            $sameTypeWhereCond
                        ORDER BY
                            version DESC
                        LIMIT 1
                        ",
                        $this->f->db->escapeSimple($collectivite),
                        $this->f->db->escapeSimple($da),
                        intval($di_inst->getVal('version')),
                        $this->f->db->escapeSimple($di)),
                    array(
                        "origin" => __METHOD__,
                        "force_return" => true,
                    )
                );
                $err_msg = sprintf(
                    __("Erreur lors de la récupération du DI le plus récent pour le DA %s"),
                    $da);
                if ($qres["code"] !== "OK") {
                    $this->addToLog(__METHOD__.'() '.$err_msg);
                    return $err_msg;
                }
                if (empty($prev_di_idx = $qres["result"])) {
                    $this->addToLog(__METHOD__.'() '.$err_msg." (pas de DI trouvé)");
                    return $err_msg;
                }
            }

            $prev_di_inst = $this->f->findObjectById('dossier', $prev_di_idx);
            if (empty($prev_di_inst)) {
                $this->addToLog(__METHOD__.'() '.$err_msg);
                return $err_msg;
            }

            // si le DI le plus récent est géolocalisé
            if (! empty($prev_di_inst->getVal('geom'))) {

                // récupère une instance du connecteur SIG
                $collectivite_param = $this->f->getCollectivite($collectivite);
                $extra_params = array(
                    "inst_framework" => $this->f,
                );
                if ($this->f->is_option_dossier_commune_enabled() === true
                    && !empty($commune)) {
                    $extra_params['commune_idx'] = $commune;
                }
                try {
                    $geoads = new geoads($collectivite_param, $extra_params);
                } catch (Exception $e) {
                    return __("Erreur lors de l'instanciation du connecteur sig").
                        ' '.__("Détail: ").json_encode($e->getMessage());
                }

                // si le SIG implémente la fonctionnalité de réplication de la
                // géolocalisation d'un dossier à partir d'un autre
                if (method_exists($geoads, 'methodIsImplemented')
                        && $geoads->methodIsImplemented('replicate_geolocalisation')) {
                    try {

                        // réplication de sa géolocalisation sur le DI courant
                        if (! $geoads->replicate_geolocalisation($prev_di_idx, $di)) {
                            $err_msg = sprintf(
                                __("Erreur lors de la réplication de la géolocalisation du DI %s sur le DI %"),
                                $prev_di_idx,
                                $di);
                            $this->addToLog(__METHOD__.'() '.$err_msg);
                            return $err_msg;
                        }

                        // enregistrement du succès de la création du dossier/emprise
                        $msg = sprintf(
                            __("Emprise/dossier créé à partir du dossier %s"),
                            $prev_di_idx);
                        $this->addToLog(__METHOD__."() msg: $msg", VERBOSE_MODE);
                        $now_dt_text = (new Datetime())->format('Y-m-d H:i:s');
                        if (! $di_inst->update_dossier_geolocalisation('calcul_emprise', $now_dt_text, true, $msg)) {
                            $err_msg = sprintf(
                                __("Erreur lors de la réplication de la géolocalisation du DI %s à partir du %s (le dossier a bien été créé/géolocalisé dans le SIG mais le message d'information n'a pas pu être enregistré)"),
                                $di, $prev_di_idx);
                            $this->addToLog(__METHOD__.'() '.$err_msg);
                        }

                        // enregistrement du geom (centroide)
                        $sql = sprintf("
                            UPDATE
                                ".DB_PREFIXE."dossier
                            SET
                                geom = public.ST_GeomFromText('%s', %s)
                            WHERE
                                dossier = '%s'",
                            $prev_di_inst->getVal('geom'),
                            $collectivite_param['sig']['sig_referentiel'],
                            $this->f->db->escapeSimple($di)
                        );
                        $qres = $this->f->db->query($sql);
                        if ($this->f->isDatabaseError($qres, true)) {
                            $err_msg = sprintf(
                                __("Erreur lors de l'enregistrement du centroide dans le dossier %s (le dossier a bien été créé/géolocalisé dans le SIG)"),
                                $di);
                            $this->addToLog(__METHOD__.'() '.$err_msg);
                        }
                        else {

                            // enregistrement du message pour le centroide
                            $msg = sprintf(
                                __("Centroide récupéré à partir du dossier %s"),
                                $prev_di_idx);
                            $this->addToLog(__METHOD__."() msg: $msg", VERBOSE_MODE);
                            $now_dt_text = (new Datetime())->format('Y-m-d H:i:s');
                            if (! $di_inst->update_dossier_geolocalisation('calcul_centroide', $now_dt_text, true, $msg)) {
                                $err_msg = sprintf(
                                    __("Erreur lors de la réplication de la géolocalisation du DI %s à partir du %s (le dossier a bien été créé/géolocalisé dans le SIG mais le message d'information sur le centroide n'a pas pu être enregistré)"),
                                    $di, $prev_di_idx);
                                $this->addToLog(__METHOD__.'() '.$err_msg);
                            }

                            // réplication des contraintes
                            $res = $this->f->get_all_results_from_db_query(
                                sprintf('
                                    SELECT
                                        contrainte,
                                        texte_complete,
                                        reference
                                    FROM
                                        %1$sdossier_contrainte
                                    WHERE
                                        dossier = \'%2$s\'',
                                    DB_PREFIXE,
                                    $this->f->db->escapeSimple($prev_di_idx)
                                ),
                                array(
                                    "origin" => __METHOD__,
                                    "force_return" => true,
                                )
                            );
                            if ($res['code'] === 'KO') {
                                $err_msg = sprintf(
                                    __("Erreur lors de la récupération des contraintes sig du dossier %s."),
                                    $di);
                                $this->addToLog(__METHOD__.'() '.$err_msg);
                            } else {
                                $add_all_dc = true;
                                foreach ($res['result'] as $result) {
                                    $inst_dc = $this->f->get_inst__om_dbform(array(
                                        "obj" => "dossier_contrainte",
                                        "idx" => "]",
                                    ));
                                    $valF = array();
                                    foreach ($inst_dc->champs as $champ) {
                                        $valF[$champ] = null;
                                    }
                                    $valF['dossier'] = $di;
                                    $valF['contrainte'] = $result['contrainte'];
                                    $valF['texte_complete'] = $result['texte_complete'];
                                    $valF['reference'] = $result['reference'];
                                    $add_dc = $inst_dc->ajouter($valF);
                                    if ($add_dc === false) {
                                        $add_all_dc = false;
                                        $this->addToLog(__METHOD__."() ".sprintf(__("Erreur lors de l'enregistrement de la contrainte %s sur le dossier %s."), $valF['contrainte'], $valF['dossier'])." : ".$inst_dc->msg);
                                    }
                                }
                                if ($add_all_dc === false) {
                                    $err_msg = sprintf(
                                        __("Erreur lors de la réplication d'une ou des contraintes sig du dossier %s à partir du dossier %s (le dossier a bien été créé/géolocalisé dans le SIG)"),
                                        $di, $prev_di_idx);
                                    $this->addToLog(__METHOD__.'() '.$err_msg);
                                }

                                // TODO recopie-t-on les données de la géolocalisation par disque (latitude/longitude/rayon) ?

                                else {

                                    // enregistrement du message pour les contraintes
                                    $msg = sprintf(
                                        __("Contraintes récupérées à partir du dossier %s"),
                                        $prev_di_idx);
                                    $this->addToLog(__METHOD__."() msg: $msg", VERBOSE_MODE);
                                    $now_dt_text = (new Datetime())->format('Y-m-d H:i:s');
                                    if (! $di_inst->update_dossier_geolocalisation('recup_contrainte', $now_dt_text, true, $msg)) {
                                        $err_msg = sprintf(
                                            __("Erreur lors de la réplication de la géolocalisation du DI %s à partir du %s (le dossier a bien été créé/géolocalisé dans le SIG mais le message d'information sur les contraintes n'a pas pu être enregistré)"),
                                            $di, $prev_di_idx);
                                        $this->addToLog(__METHOD__.'() '.$err_msg);
                                    }
                                }
                            }
                        }
                    }
                    catch(geoads_connector_method_not_implemented_exception $e) {
                        $this->addToLog(__METHOD__."() Method not impletemented 'replicate_geolocalisation'");
                    }
                    catch(Exception $e) {
                        $this->addToLog(__METHOD__."() ".get_class($e)." ".$e->getMessage());
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
