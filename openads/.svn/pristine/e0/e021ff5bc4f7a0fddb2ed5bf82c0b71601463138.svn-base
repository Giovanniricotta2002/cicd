<?php
//$Id$ 
//gen openMairie le 26/07/2023 15:51

require_once "../obj/om_dbform.class.php";

class dossier_gen extends om_dbform {

    protected $_absolute_class_name = "dossier";

    var $table = "dossier";
    var $clePrimaire = "dossier";
    var $typeCle = "A";
    var $required_field = array(
        "date_depot",
        "date_dernier_depot",
        "dossier",
        "dossier_autorisation",
        "dossier_instruction_type",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
        "autorite_competente" => array("autorite_competente", ),
        "avis_decision" => array("avis_decision", ),
        "commune" => array("commune", ),
        "division" => array("division", ),
        "dossier_autorisation" => array("dossier_autorisation", ),
        "dossier_instruction_type" => array("dossier_instruction_type", ),
        "etat" => array("etat", ),
        "evenement" => array("evenement", ),
        "instructeur" => array("instructeur", ),
        "om_collectivite" => array("om_collectivite", ),
        "pec_metier" => array("pec_metier", ),
        "quartier" => array("quartier", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("annee");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "dossier",
            "annee",
            "etat",
            "instructeur",
            "date_demande",
            "date_depot",
            "date_complet",
            "date_rejet",
            "date_notification_delai",
            "delai",
            "date_limite",
            "accord_tacite",
            "date_decision",
            "date_validite",
            "date_chantier",
            "date_achevement",
            "date_conformite",
            "description",
            "erp",
            "avis_decision",
            "enjeu_erp",
            "enjeu_urba",
            "division",
            "autorite_competente",
            "a_qualifier",
            "terrain_references_cadastrales",
            "terrain_adresse_voie_numero",
            "terrain_adresse_voie",
            "terrain_adresse_lieu_dit",
            "terrain_adresse_localite",
            "terrain_adresse_code_postal",
            "terrain_adresse_bp",
            "terrain_adresse_cedex",
            "terrain_superficie",
            "dossier_autorisation",
            "dossier_instruction_type",
            "date_dernier_depot",
            "version",
            "incompletude",
            "evenement_suivant_tacite",
            "evenement_suivant_tacite_incompletude",
            "etat_pendant_incompletude",
            "date_limite_incompletude",
            "delai_incompletude",
            "dossier_libelle",
            "numero_versement_archive",
            "duree_validite",
            "quartier",
            "incomplet_notifie",
            "om_collectivite",
            "tax_secteur",
            "tax_mtn_part_commu",
            "tax_mtn_part_depart",
            "tax_mtn_part_reg",
            "tax_mtn_total",
            "log_instructions",
            "interface_referentiel_erp",
            "autorisation_contestee",
            "date_cloture_instruction",
            "date_premiere_visite",
            "date_derniere_visite",
            "date_contradictoire",
            "date_retour_contradictoire",
            "date_ait",
            "date_transmission_parquet",
            "instructeur_2",
            "tax_mtn_rap",
            "tax_mtn_part_commu_sans_exo",
            "tax_mtn_part_depart_sans_exo",
            "tax_mtn_part_reg_sans_exo",
            "tax_mtn_total_sans_exo",
            "tax_mtn_rap_sans_exo",
            "date_modification",
            "hash_sitadel",
            "depot_electronique",
            "parcelle_temporaire",
            "date_affichage",
            "version_clos",
            "initial_dt",
            "commune",
            "adresse_normalisee",
            "adresse_normalisee_json",
            "date_depot_mairie",
            "numerotation_type",
            "numerotation_dep",
            "numerotation_com",
            "numerotation_division",
            "numerotation_num",
            "numerotation_suffixe",
            "numerotation_num_suffixe",
            "numerotation_entite",
            "numerotation_num_entite",
            "pec_metier",
            "etat_transmission_platau",
            "dossier_parent",
            "terrain_superficie_calculee",
            "geoloc_latitude",
            "geoloc_longitude",
            "geoloc_rayon",
            "geom",
            "geom1",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorisation_contestee() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorisation_contestee_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorite_competente() {
        return "SELECT autorite_competente.autorite_competente, autorite_competente.libelle FROM ".DB_PREFIXE."autorite_competente ORDER BY autorite_competente.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorite_competente_by_id() {
        return "SELECT autorite_competente.autorite_competente, autorite_competente.libelle FROM ".DB_PREFIXE."autorite_competente WHERE autorite_competente = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision() {
        return "SELECT avis_decision.avis_decision, avis_decision.libelle FROM ".DB_PREFIXE."avis_decision ORDER BY avis_decision.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_avis_decision_by_id() {
        return "SELECT avis_decision.avis_decision, avis_decision.libelle FROM ".DB_PREFIXE."avis_decision WHERE avis_decision = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commune() {
        return "SELECT commune.commune, commune.libelle FROM ".DB_PREFIXE."commune WHERE ((commune.om_validite_debut IS NULL AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE)) OR (commune.om_validite_debut <= CURRENT_DATE AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > CURRENT_DATE))) ORDER BY commune.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commune_by_id() {
        return "SELECT commune.commune, commune.libelle FROM ".DB_PREFIXE."commune WHERE commune = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division() {
        return "SELECT division.division, division.libelle FROM ".DB_PREFIXE."division WHERE ((division.om_validite_debut IS NULL AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)) OR (division.om_validite_debut <= CURRENT_DATE AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE))) ORDER BY division.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division_by_id() {
        return "SELECT division.division, division.libelle FROM ".DB_PREFIXE."division WHERE division = <idx>";
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
    function get_var_sql_forminc__sql_dossier_instruction_type() {
        return "SELECT dossier_instruction_type.dossier_instruction_type, dossier_instruction_type.libelle FROM ".DB_PREFIXE."dossier_instruction_type ORDER BY dossier_instruction_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return "SELECT dossier_instruction_type.dossier_instruction_type, dossier_instruction_type.libelle FROM ".DB_PREFIXE."dossier_instruction_type WHERE dossier_instruction_type = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_parent() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_parent_by_id() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier WHERE dossier = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat ORDER BY etat.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat_by_id() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat WHERE etat = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat_pendant_incompletude() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat ORDER BY etat.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat_pendant_incompletude_by_id() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat WHERE etat = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_suivant_tacite() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_suivant_tacite_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_suivant_tacite_incompletude() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_suivant_tacite_incompletude_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur() {
        return "SELECT instructeur.instructeur, instructeur.nom FROM ".DB_PREFIXE."instructeur WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE))) ORDER BY instructeur.nom ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_by_id() {
        return "SELECT instructeur.instructeur, instructeur.nom FROM ".DB_PREFIXE."instructeur WHERE instructeur = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2() {
        return "SELECT instructeur.instructeur, instructeur.nom FROM ".DB_PREFIXE."instructeur WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE))) ORDER BY instructeur.nom ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2_by_id() {
        return "SELECT instructeur.instructeur, instructeur.nom FROM ".DB_PREFIXE."instructeur WHERE instructeur = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite ORDER BY om_collectivite.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite_by_id() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite WHERE om_collectivite = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_pec_metier() {
        return "SELECT pec_metier.pec_metier, pec_metier.libelle FROM ".DB_PREFIXE."pec_metier WHERE ((pec_metier.om_validite_debut IS NULL AND (pec_metier.om_validite_fin IS NULL OR pec_metier.om_validite_fin > CURRENT_DATE)) OR (pec_metier.om_validite_debut <= CURRENT_DATE AND (pec_metier.om_validite_fin IS NULL OR pec_metier.om_validite_fin > CURRENT_DATE))) ORDER BY pec_metier.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_pec_metier_by_id() {
        return "SELECT pec_metier.pec_metier, pec_metier.libelle FROM ".DB_PREFIXE."pec_metier WHERE pec_metier = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_quartier() {
        return "SELECT quartier.quartier, quartier.libelle FROM ".DB_PREFIXE."quartier ORDER BY quartier.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_quartier_by_id() {
        return "SELECT quartier.quartier, quartier.libelle FROM ".DB_PREFIXE."quartier WHERE quartier = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        $this->valF['dossier'] = $val['dossier'];
        if ($val['annee'] == "") {
            $this->valF['annee'] = ""; // -> default
        } else {
            $this->valF['annee'] = $val['annee'];
        }
        if ($val['etat'] == "") {
            $this->valF['etat'] = NULL;
        } else {
            $this->valF['etat'] = $val['etat'];
        }
        if (!is_numeric($val['instructeur'])) {
            $this->valF['instructeur'] = NULL;
        } else {
            $this->valF['instructeur'] = $val['instructeur'];
        }
        if ($val['date_demande'] != "") {
            $this->valF['date_demande'] = $this->dateDB($val['date_demande']);
        } else {
            $this->valF['date_demande'] = NULL;
        }
        if ($val['date_depot'] != "") {
            $this->valF['date_depot'] = $this->dateDB($val['date_depot']);
        }
        if ($val['date_complet'] != "") {
            $this->valF['date_complet'] = $this->dateDB($val['date_complet']);
        } else {
            $this->valF['date_complet'] = NULL;
        }
        if ($val['date_rejet'] != "") {
            $this->valF['date_rejet'] = $this->dateDB($val['date_rejet']);
        } else {
            $this->valF['date_rejet'] = NULL;
        }
        if ($val['date_notification_delai'] != "") {
            $this->valF['date_notification_delai'] = $this->dateDB($val['date_notification_delai']);
        } else {
            $this->valF['date_notification_delai'] = NULL;
        }
        if (!is_numeric($val['delai'])) {
            $this->valF['delai'] = 0; // -> default
        } else {
            $this->valF['delai'] = $val['delai'];
        }
        if ($val['date_limite'] != "") {
            $this->valF['date_limite'] = $this->dateDB($val['date_limite']);
        } else {
            $this->valF['date_limite'] = NULL;
        }
        if ($val['accord_tacite'] == "") {
            $this->valF['accord_tacite'] = ""; // -> default
        } else {
            $this->valF['accord_tacite'] = $val['accord_tacite'];
        }
        if ($val['date_decision'] != "") {
            $this->valF['date_decision'] = $this->dateDB($val['date_decision']);
        } else {
            $this->valF['date_decision'] = NULL;
        }
        if ($val['date_validite'] != "") {
            $this->valF['date_validite'] = $this->dateDB($val['date_validite']);
        } else {
            $this->valF['date_validite'] = NULL;
        }
        if ($val['date_chantier'] != "") {
            $this->valF['date_chantier'] = $this->dateDB($val['date_chantier']);
        } else {
            $this->valF['date_chantier'] = NULL;
        }
        if ($val['date_achevement'] != "") {
            $this->valF['date_achevement'] = $this->dateDB($val['date_achevement']);
        } else {
            $this->valF['date_achevement'] = NULL;
        }
        if ($val['date_conformite'] != "") {
            $this->valF['date_conformite'] = $this->dateDB($val['date_conformite']);
        } else {
            $this->valF['date_conformite'] = NULL;
        }
            $this->valF['description'] = $val['description'];
        if ($val['erp'] == 1 || $val['erp'] == "t" || $val['erp'] == "Oui") {
            $this->valF['erp'] = true;
        } else {
            $this->valF['erp'] = false;
        }
        if (!is_numeric($val['avis_decision'])) {
            $this->valF['avis_decision'] = NULL;
        } else {
            $this->valF['avis_decision'] = $val['avis_decision'];
        }
        if ($val['enjeu_erp'] == 1 || $val['enjeu_erp'] == "t" || $val['enjeu_erp'] == "Oui") {
            $this->valF['enjeu_erp'] = true;
        } else {
            $this->valF['enjeu_erp'] = false;
        }
        if ($val['enjeu_urba'] == 1 || $val['enjeu_urba'] == "t" || $val['enjeu_urba'] == "Oui") {
            $this->valF['enjeu_urba'] = true;
        } else {
            $this->valF['enjeu_urba'] = false;
        }
        if (!is_numeric($val['division'])) {
            $this->valF['division'] = NULL;
        } else {
            $this->valF['division'] = $val['division'];
        }
        if (!is_numeric($val['autorite_competente'])) {
            $this->valF['autorite_competente'] = NULL;
        } else {
            $this->valF['autorite_competente'] = $val['autorite_competente'];
        }
        if ($val['a_qualifier'] == 1 || $val['a_qualifier'] == "t" || $val['a_qualifier'] == "Oui") {
            $this->valF['a_qualifier'] = true;
        } else {
            $this->valF['a_qualifier'] = false;
        }
            $this->valF['terrain_references_cadastrales'] = $val['terrain_references_cadastrales'];
        if ($val['terrain_adresse_voie_numero'] == "") {
            $this->valF['terrain_adresse_voie_numero'] = NULL;
        } else {
            $this->valF['terrain_adresse_voie_numero'] = $val['terrain_adresse_voie_numero'];
        }
        if ($val['terrain_adresse_voie'] == "") {
            $this->valF['terrain_adresse_voie'] = NULL;
        } else {
            $this->valF['terrain_adresse_voie'] = $val['terrain_adresse_voie'];
        }
        if ($val['terrain_adresse_lieu_dit'] == "") {
            $this->valF['terrain_adresse_lieu_dit'] = NULL;
        } else {
            $this->valF['terrain_adresse_lieu_dit'] = $val['terrain_adresse_lieu_dit'];
        }
        if ($val['terrain_adresse_localite'] == "") {
            $this->valF['terrain_adresse_localite'] = NULL;
        } else {
            $this->valF['terrain_adresse_localite'] = $val['terrain_adresse_localite'];
        }
        if ($val['terrain_adresse_code_postal'] == "") {
            $this->valF['terrain_adresse_code_postal'] = NULL;
        } else {
            $this->valF['terrain_adresse_code_postal'] = $val['terrain_adresse_code_postal'];
        }
        if ($val['terrain_adresse_bp'] == "") {
            $this->valF['terrain_adresse_bp'] = NULL;
        } else {
            $this->valF['terrain_adresse_bp'] = $val['terrain_adresse_bp'];
        }
        if ($val['terrain_adresse_cedex'] == "") {
            $this->valF['terrain_adresse_cedex'] = NULL;
        } else {
            $this->valF['terrain_adresse_cedex'] = $val['terrain_adresse_cedex'];
        }
        if (!is_numeric($val['terrain_superficie'])) {
            $this->valF['terrain_superficie'] = NULL;
        } else {
            $this->valF['terrain_superficie'] = $val['terrain_superficie'];
        }
        $this->valF['dossier_autorisation'] = $val['dossier_autorisation'];
        if (!is_numeric($val['dossier_instruction_type'])) {
            $this->valF['dossier_instruction_type'] = ""; // -> requis
        } else {
            $this->valF['dossier_instruction_type'] = $val['dossier_instruction_type'];
        }
        if ($val['date_dernier_depot'] != "") {
            $this->valF['date_dernier_depot'] = $this->dateDB($val['date_dernier_depot']);
        }
        if (!is_numeric($val['version'])) {
            $this->valF['version'] = NULL;
        } else {
            $this->valF['version'] = $val['version'];
        }
        if ($val['incompletude'] == 1 || $val['incompletude'] == "t" || $val['incompletude'] == "Oui") {
            $this->valF['incompletude'] = true;
        } else {
            $this->valF['incompletude'] = false;
        }
        if (!is_numeric($val['evenement_suivant_tacite'])) {
            $this->valF['evenement_suivant_tacite'] = NULL;
        } else {
            $this->valF['evenement_suivant_tacite'] = $val['evenement_suivant_tacite'];
        }
        if (!is_numeric($val['evenement_suivant_tacite_incompletude'])) {
            $this->valF['evenement_suivant_tacite_incompletude'] = NULL;
        } else {
            $this->valF['evenement_suivant_tacite_incompletude'] = $val['evenement_suivant_tacite_incompletude'];
        }
        if ($val['etat_pendant_incompletude'] == "") {
            $this->valF['etat_pendant_incompletude'] = NULL;
        } else {
            $this->valF['etat_pendant_incompletude'] = $val['etat_pendant_incompletude'];
        }
        if ($val['date_limite_incompletude'] != "") {
            $this->valF['date_limite_incompletude'] = $this->dateDB($val['date_limite_incompletude']);
        } else {
            $this->valF['date_limite_incompletude'] = NULL;
        }
        if (!is_numeric($val['delai_incompletude'])) {
            $this->valF['delai_incompletude'] = NULL;
        } else {
            $this->valF['delai_incompletude'] = $val['delai_incompletude'];
        }
        if ($val['dossier_libelle'] == "") {
            $this->valF['dossier_libelle'] = NULL;
        } else {
            $this->valF['dossier_libelle'] = $val['dossier_libelle'];
        }
        if ($val['numero_versement_archive'] == "") {
            $this->valF['numero_versement_archive'] = NULL;
        } else {
            $this->valF['numero_versement_archive'] = $val['numero_versement_archive'];
        }
        if (!is_numeric($val['duree_validite'])) {
            $this->valF['duree_validite'] = 0; // -> default
        } else {
            $this->valF['duree_validite'] = $val['duree_validite'];
        }
        if (!is_numeric($val['quartier'])) {
            $this->valF['quartier'] = NULL;
        } else {
            $this->valF['quartier'] = $val['quartier'];
        }
        if ($val['incomplet_notifie'] == 1 || $val['incomplet_notifie'] == "t" || $val['incomplet_notifie'] == "Oui") {
            $this->valF['incomplet_notifie'] = true;
        } else {
            $this->valF['incomplet_notifie'] = false;
        }
        if (!is_numeric($val['om_collectivite'])) {
            $this->valF['om_collectivite'] = ""; // -> requis
        } else {
            if($_SESSION['niveau']==1) {
                $this->valF['om_collectivite'] = $_SESSION['collectivite'];
            } else {
                $this->valF['om_collectivite'] = $val['om_collectivite'];
            }
        }
        if (!is_numeric($val['tax_secteur'])) {
            $this->valF['tax_secteur'] = NULL;
        } else {
            $this->valF['tax_secteur'] = $val['tax_secteur'];
        }
        if (!is_numeric($val['tax_mtn_part_commu'])) {
            $this->valF['tax_mtn_part_commu'] = NULL;
        } else {
            $this->valF['tax_mtn_part_commu'] = $val['tax_mtn_part_commu'];
        }
        if (!is_numeric($val['tax_mtn_part_depart'])) {
            $this->valF['tax_mtn_part_depart'] = NULL;
        } else {
            $this->valF['tax_mtn_part_depart'] = $val['tax_mtn_part_depart'];
        }
        if (!is_numeric($val['tax_mtn_part_reg'])) {
            $this->valF['tax_mtn_part_reg'] = NULL;
        } else {
            $this->valF['tax_mtn_part_reg'] = $val['tax_mtn_part_reg'];
        }
        if (!is_numeric($val['tax_mtn_total'])) {
            $this->valF['tax_mtn_total'] = NULL;
        } else {
            $this->valF['tax_mtn_total'] = $val['tax_mtn_total'];
        }
            $this->valF['log_instructions'] = $val['log_instructions'];
        if ($val['interface_referentiel_erp'] == 1 || $val['interface_referentiel_erp'] == "t" || $val['interface_referentiel_erp'] == "Oui") {
            $this->valF['interface_referentiel_erp'] = true;
        } else {
            $this->valF['interface_referentiel_erp'] = false;
        }
        if ($val['autorisation_contestee'] == "") {
            $this->valF['autorisation_contestee'] = NULL;
        } else {
            $this->valF['autorisation_contestee'] = $val['autorisation_contestee'];
        }
        if ($val['date_cloture_instruction'] != "") {
            $this->valF['date_cloture_instruction'] = $this->dateDB($val['date_cloture_instruction']);
        } else {
            $this->valF['date_cloture_instruction'] = NULL;
        }
        if ($val['date_premiere_visite'] != "") {
            $this->valF['date_premiere_visite'] = $this->dateDB($val['date_premiere_visite']);
        } else {
            $this->valF['date_premiere_visite'] = NULL;
        }
        if ($val['date_derniere_visite'] != "") {
            $this->valF['date_derniere_visite'] = $this->dateDB($val['date_derniere_visite']);
        } else {
            $this->valF['date_derniere_visite'] = NULL;
        }
        if ($val['date_contradictoire'] != "") {
            $this->valF['date_contradictoire'] = $this->dateDB($val['date_contradictoire']);
        } else {
            $this->valF['date_contradictoire'] = NULL;
        }
        if ($val['date_retour_contradictoire'] != "") {
            $this->valF['date_retour_contradictoire'] = $this->dateDB($val['date_retour_contradictoire']);
        } else {
            $this->valF['date_retour_contradictoire'] = NULL;
        }
        if ($val['date_ait'] != "") {
            $this->valF['date_ait'] = $this->dateDB($val['date_ait']);
        } else {
            $this->valF['date_ait'] = NULL;
        }
        if ($val['date_transmission_parquet'] != "") {
            $this->valF['date_transmission_parquet'] = $this->dateDB($val['date_transmission_parquet']);
        } else {
            $this->valF['date_transmission_parquet'] = NULL;
        }
        if (!is_numeric($val['instructeur_2'])) {
            $this->valF['instructeur_2'] = NULL;
        } else {
            $this->valF['instructeur_2'] = $val['instructeur_2'];
        }
        if (!is_numeric($val['tax_mtn_rap'])) {
            $this->valF['tax_mtn_rap'] = NULL;
        } else {
            $this->valF['tax_mtn_rap'] = $val['tax_mtn_rap'];
        }
        if (!is_numeric($val['tax_mtn_part_commu_sans_exo'])) {
            $this->valF['tax_mtn_part_commu_sans_exo'] = NULL;
        } else {
            $this->valF['tax_mtn_part_commu_sans_exo'] = $val['tax_mtn_part_commu_sans_exo'];
        }
        if (!is_numeric($val['tax_mtn_part_depart_sans_exo'])) {
            $this->valF['tax_mtn_part_depart_sans_exo'] = NULL;
        } else {
            $this->valF['tax_mtn_part_depart_sans_exo'] = $val['tax_mtn_part_depart_sans_exo'];
        }
        if (!is_numeric($val['tax_mtn_part_reg_sans_exo'])) {
            $this->valF['tax_mtn_part_reg_sans_exo'] = NULL;
        } else {
            $this->valF['tax_mtn_part_reg_sans_exo'] = $val['tax_mtn_part_reg_sans_exo'];
        }
        if (!is_numeric($val['tax_mtn_total_sans_exo'])) {
            $this->valF['tax_mtn_total_sans_exo'] = NULL;
        } else {
            $this->valF['tax_mtn_total_sans_exo'] = $val['tax_mtn_total_sans_exo'];
        }
        if (!is_numeric($val['tax_mtn_rap_sans_exo'])) {
            $this->valF['tax_mtn_rap_sans_exo'] = NULL;
        } else {
            $this->valF['tax_mtn_rap_sans_exo'] = $val['tax_mtn_rap_sans_exo'];
        }
        if ($val['date_modification'] != "") {
            $this->valF['date_modification'] = $this->dateDB($val['date_modification']);
        } else {
            $this->valF['date_modification'] = NULL;
        }
        if ($val['hash_sitadel'] == "") {
            $this->valF['hash_sitadel'] = NULL;
        } else {
            $this->valF['hash_sitadel'] = $val['hash_sitadel'];
        }
        if ($val['depot_electronique'] == 1 || $val['depot_electronique'] == "t" || $val['depot_electronique'] == "Oui") {
            $this->valF['depot_electronique'] = true;
        } else {
            $this->valF['depot_electronique'] = false;
        }
        if ($val['parcelle_temporaire'] == 1 || $val['parcelle_temporaire'] == "t" || $val['parcelle_temporaire'] == "Oui") {
            $this->valF['parcelle_temporaire'] = true;
        } else {
            $this->valF['parcelle_temporaire'] = false;
        }
        if ($val['date_affichage'] != "") {
            $this->valF['date_affichage'] = $this->dateDB($val['date_affichage']);
        } else {
            $this->valF['date_affichage'] = NULL;
        }
        if (!is_numeric($val['version_clos'])) {
            $this->valF['version_clos'] = NULL;
        } else {
            $this->valF['version_clos'] = $val['version_clos'];
        }
            $this->valF['initial_dt'] = $val['initial_dt'];
        if (!is_numeric($val['commune'])) {
            $this->valF['commune'] = NULL;
        } else {
            $this->valF['commune'] = $val['commune'];
        }
            $this->valF['adresse_normalisee'] = $val['adresse_normalisee'];
            $this->valF['adresse_normalisee_json'] = $val['adresse_normalisee_json'];
        if ($val['date_depot_mairie'] != "") {
            $this->valF['date_depot_mairie'] = $this->dateDB($val['date_depot_mairie']);
        } else {
            $this->valF['date_depot_mairie'] = NULL;
        }
        if ($val['numerotation_type'] == "") {
            $this->valF['numerotation_type'] = NULL;
        } else {
            $this->valF['numerotation_type'] = $val['numerotation_type'];
        }
        if ($val['numerotation_dep'] == "") {
            $this->valF['numerotation_dep'] = NULL;
        } else {
            $this->valF['numerotation_dep'] = $val['numerotation_dep'];
        }
        if ($val['numerotation_com'] == "") {
            $this->valF['numerotation_com'] = NULL;
        } else {
            $this->valF['numerotation_com'] = $val['numerotation_com'];
        }
        if ($val['numerotation_division'] == "") {
            $this->valF['numerotation_division'] = NULL;
        } else {
            $this->valF['numerotation_division'] = $val['numerotation_division'];
        }
        if (!is_numeric($val['numerotation_num'])) {
            $this->valF['numerotation_num'] = NULL;
        } else {
            $this->valF['numerotation_num'] = $val['numerotation_num'];
        }
        if ($val['numerotation_suffixe'] == "") {
            $this->valF['numerotation_suffixe'] = NULL;
        } else {
            $this->valF['numerotation_suffixe'] = $val['numerotation_suffixe'];
        }
        if (!is_numeric($val['numerotation_num_suffixe'])) {
            $this->valF['numerotation_num_suffixe'] = NULL;
        } else {
            $this->valF['numerotation_num_suffixe'] = $val['numerotation_num_suffixe'];
        }
        if ($val['numerotation_entite'] == "") {
            $this->valF['numerotation_entite'] = NULL;
        } else {
            $this->valF['numerotation_entite'] = $val['numerotation_entite'];
        }
        if (!is_numeric($val['numerotation_num_entite'])) {
            $this->valF['numerotation_num_entite'] = NULL;
        } else {
            $this->valF['numerotation_num_entite'] = $val['numerotation_num_entite'];
        }
        if (!is_numeric($val['pec_metier'])) {
            $this->valF['pec_metier'] = NULL;
        } else {
            $this->valF['pec_metier'] = $val['pec_metier'];
        }
            $this->valF['etat_transmission_platau'] = $val['etat_transmission_platau'];
        if ($val['dossier_parent'] == "") {
            $this->valF['dossier_parent'] = NULL;
        } else {
            $this->valF['dossier_parent'] = $val['dossier_parent'];
        }
        if (!is_numeric($val['terrain_superficie_calculee'])) {
            $this->valF['terrain_superficie_calculee'] = NULL;
        } else {
            $this->valF['terrain_superficie_calculee'] = $val['terrain_superficie_calculee'];
        }
        if ($val['geoloc_latitude'] == "") {
            $this->valF['geoloc_latitude'] = NULL;
        } else {
            $this->valF['geoloc_latitude'] = $val['geoloc_latitude'];
        }
        if ($val['geoloc_longitude'] == "") {
            $this->valF['geoloc_longitude'] = NULL;
        } else {
            $this->valF['geoloc_longitude'] = $val['geoloc_longitude'];
        }
        if (!is_numeric($val['geoloc_rayon'])) {
            $this->valF['geoloc_rayon'] = NULL;
        } else {
            $this->valF['geoloc_rayon'] = $val['geoloc_rayon'];
        }
        if ($val['geom'] == "") {
            unset($this->valF['geom']);
        } else {
            $this->valF['geom'] = $val['geom'];
        }
        if ($val['geom1'] == "") {
            unset($this->valF['geom1']);
        } else {
            $this->valF['geom1'] = $val['geom1'];
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
            $form->setType("dossier", "text");
            $form->setType("annee", "text");
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
            if ($this->is_in_context_of_foreign_key("instructeur", $this->retourformulaire)) {
                $form->setType("instructeur", "selecthiddenstatic");
            } else {
                $form->setType("instructeur", "select");
            }
            $form->setType("date_demande", "date");
            $form->setType("date_depot", "date");
            $form->setType("date_complet", "date");
            $form->setType("date_rejet", "date");
            $form->setType("date_notification_delai", "date");
            $form->setType("delai", "text");
            $form->setType("date_limite", "date");
            $form->setType("accord_tacite", "text");
            $form->setType("date_decision", "date");
            $form->setType("date_validite", "date");
            $form->setType("date_chantier", "date");
            $form->setType("date_achevement", "date");
            $form->setType("date_conformite", "date");
            $form->setType("description", "textarea");
            $form->setType("erp", "checkbox");
            if ($this->is_in_context_of_foreign_key("avis_decision", $this->retourformulaire)) {
                $form->setType("avis_decision", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision", "select");
            }
            $form->setType("enjeu_erp", "checkbox");
            $form->setType("enjeu_urba", "checkbox");
            if ($this->is_in_context_of_foreign_key("division", $this->retourformulaire)) {
                $form->setType("division", "selecthiddenstatic");
            } else {
                $form->setType("division", "select");
            }
            if ($this->is_in_context_of_foreign_key("autorite_competente", $this->retourformulaire)) {
                $form->setType("autorite_competente", "selecthiddenstatic");
            } else {
                $form->setType("autorite_competente", "select");
            }
            $form->setType("a_qualifier", "checkbox");
            $form->setType("terrain_references_cadastrales", "textarea");
            $form->setType("terrain_adresse_voie_numero", "text");
            $form->setType("terrain_adresse_voie", "text");
            $form->setType("terrain_adresse_lieu_dit", "text");
            $form->setType("terrain_adresse_localite", "text");
            $form->setType("terrain_adresse_code_postal", "text");
            $form->setType("terrain_adresse_bp", "text");
            $form->setType("terrain_adresse_cedex", "text");
            $form->setType("terrain_superficie", "text");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            $form->setType("date_dernier_depot", "date");
            $form->setType("version", "text");
            $form->setType("incompletude", "checkbox");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_suivant_tacite", "selecthiddenstatic");
            } else {
                $form->setType("evenement_suivant_tacite", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_suivant_tacite_incompletude", "selecthiddenstatic");
            } else {
                $form->setType("evenement_suivant_tacite_incompletude", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat_pendant_incompletude", "selecthiddenstatic");
            } else {
                $form->setType("etat_pendant_incompletude", "select");
            }
            $form->setType("date_limite_incompletude", "date");
            $form->setType("delai_incompletude", "text");
            $form->setType("dossier_libelle", "text");
            $form->setType("numero_versement_archive", "text");
            $form->setType("duree_validite", "text");
            if ($this->is_in_context_of_foreign_key("quartier", $this->retourformulaire)) {
                $form->setType("quartier", "selecthiddenstatic");
            } else {
                $form->setType("quartier", "select");
            }
            $form->setType("incomplet_notifie", "checkbox");
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selecthiddenstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "select");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("tax_secteur", "text");
            $form->setType("tax_mtn_part_commu", "text");
            $form->setType("tax_mtn_part_depart", "text");
            $form->setType("tax_mtn_part_reg", "text");
            $form->setType("tax_mtn_total", "text");
            $form->setType("log_instructions", "textarea");
            $form->setType("interface_referentiel_erp", "checkbox");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("autorisation_contestee", "selecthiddenstatic");
            } else {
                $form->setType("autorisation_contestee", "select");
            }
            $form->setType("date_cloture_instruction", "date");
            $form->setType("date_premiere_visite", "date");
            $form->setType("date_derniere_visite", "date");
            $form->setType("date_contradictoire", "date");
            $form->setType("date_retour_contradictoire", "date");
            $form->setType("date_ait", "date");
            $form->setType("date_transmission_parquet", "date");
            if ($this->is_in_context_of_foreign_key("instructeur", $this->retourformulaire)) {
                $form->setType("instructeur_2", "selecthiddenstatic");
            } else {
                $form->setType("instructeur_2", "select");
            }
            $form->setType("tax_mtn_rap", "text");
            $form->setType("tax_mtn_part_commu_sans_exo", "text");
            $form->setType("tax_mtn_part_depart_sans_exo", "text");
            $form->setType("tax_mtn_part_reg_sans_exo", "text");
            $form->setType("tax_mtn_total_sans_exo", "text");
            $form->setType("tax_mtn_rap_sans_exo", "text");
            $form->setType("date_modification", "date");
            $form->setType("hash_sitadel", "text");
            $form->setType("depot_electronique", "checkbox");
            $form->setType("parcelle_temporaire", "checkbox");
            $form->setType("date_affichage", "date");
            $form->setType("version_clos", "text");
            $form->setType("initial_dt", "textarea");
            if ($this->is_in_context_of_foreign_key("commune", $this->retourformulaire)) {
                $form->setType("commune", "selecthiddenstatic");
            } else {
                $form->setType("commune", "select");
            }
            $form->setType("adresse_normalisee", "textarea");
            $form->setType("adresse_normalisee_json", "textarea");
            $form->setType("date_depot_mairie", "date");
            $form->setType("numerotation_type", "text");
            $form->setType("numerotation_dep", "text");
            $form->setType("numerotation_com", "text");
            $form->setType("numerotation_division", "text");
            $form->setType("numerotation_num", "text");
            $form->setType("numerotation_suffixe", "text");
            $form->setType("numerotation_num_suffixe", "text");
            $form->setType("numerotation_entite", "text");
            $form->setType("numerotation_num_entite", "text");
            if ($this->is_in_context_of_foreign_key("pec_metier", $this->retourformulaire)) {
                $form->setType("pec_metier", "selecthiddenstatic");
            } else {
                $form->setType("pec_metier", "select");
            }
            $form->setType("etat_transmission_platau", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_parent", "selecthiddenstatic");
            } else {
                $form->setType("dossier_parent", "select");
            }
            $form->setType("terrain_superficie_calculee", "text");
            $form->setType("geoloc_latitude", "text");
            $form->setType("geoloc_longitude", "text");
            $form->setType("geoloc_rayon", "text");
            $form->setType("geom", "geom");
            $form->setType("geom1", "geom");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier", "hiddenstatic");
            $form->setType("annee", "text");
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
            if ($this->is_in_context_of_foreign_key("instructeur", $this->retourformulaire)) {
                $form->setType("instructeur", "selecthiddenstatic");
            } else {
                $form->setType("instructeur", "select");
            }
            $form->setType("date_demande", "date");
            $form->setType("date_depot", "date");
            $form->setType("date_complet", "date");
            $form->setType("date_rejet", "date");
            $form->setType("date_notification_delai", "date");
            $form->setType("delai", "text");
            $form->setType("date_limite", "date");
            $form->setType("accord_tacite", "text");
            $form->setType("date_decision", "date");
            $form->setType("date_validite", "date");
            $form->setType("date_chantier", "date");
            $form->setType("date_achevement", "date");
            $form->setType("date_conformite", "date");
            $form->setType("description", "textarea");
            $form->setType("erp", "checkbox");
            if ($this->is_in_context_of_foreign_key("avis_decision", $this->retourformulaire)) {
                $form->setType("avis_decision", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision", "select");
            }
            $form->setType("enjeu_erp", "checkbox");
            $form->setType("enjeu_urba", "checkbox");
            if ($this->is_in_context_of_foreign_key("division", $this->retourformulaire)) {
                $form->setType("division", "selecthiddenstatic");
            } else {
                $form->setType("division", "select");
            }
            if ($this->is_in_context_of_foreign_key("autorite_competente", $this->retourformulaire)) {
                $form->setType("autorite_competente", "selecthiddenstatic");
            } else {
                $form->setType("autorite_competente", "select");
            }
            $form->setType("a_qualifier", "checkbox");
            $form->setType("terrain_references_cadastrales", "textarea");
            $form->setType("terrain_adresse_voie_numero", "text");
            $form->setType("terrain_adresse_voie", "text");
            $form->setType("terrain_adresse_lieu_dit", "text");
            $form->setType("terrain_adresse_localite", "text");
            $form->setType("terrain_adresse_code_postal", "text");
            $form->setType("terrain_adresse_bp", "text");
            $form->setType("terrain_adresse_cedex", "text");
            $form->setType("terrain_superficie", "text");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation", $this->retourformulaire)) {
                $form->setType("dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation", "select");
            }
            if ($this->is_in_context_of_foreign_key("dossier_instruction_type", $this->retourformulaire)) {
                $form->setType("dossier_instruction_type", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction_type", "select");
            }
            $form->setType("date_dernier_depot", "date");
            $form->setType("version", "text");
            $form->setType("incompletude", "checkbox");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_suivant_tacite", "selecthiddenstatic");
            } else {
                $form->setType("evenement_suivant_tacite", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement_suivant_tacite_incompletude", "selecthiddenstatic");
            } else {
                $form->setType("evenement_suivant_tacite_incompletude", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat_pendant_incompletude", "selecthiddenstatic");
            } else {
                $form->setType("etat_pendant_incompletude", "select");
            }
            $form->setType("date_limite_incompletude", "date");
            $form->setType("delai_incompletude", "text");
            $form->setType("dossier_libelle", "text");
            $form->setType("numero_versement_archive", "text");
            $form->setType("duree_validite", "text");
            if ($this->is_in_context_of_foreign_key("quartier", $this->retourformulaire)) {
                $form->setType("quartier", "selecthiddenstatic");
            } else {
                $form->setType("quartier", "select");
            }
            $form->setType("incomplet_notifie", "checkbox");
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selecthiddenstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "select");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("tax_secteur", "text");
            $form->setType("tax_mtn_part_commu", "text");
            $form->setType("tax_mtn_part_depart", "text");
            $form->setType("tax_mtn_part_reg", "text");
            $form->setType("tax_mtn_total", "text");
            $form->setType("log_instructions", "textarea");
            $form->setType("interface_referentiel_erp", "checkbox");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("autorisation_contestee", "selecthiddenstatic");
            } else {
                $form->setType("autorisation_contestee", "select");
            }
            $form->setType("date_cloture_instruction", "date");
            $form->setType("date_premiere_visite", "date");
            $form->setType("date_derniere_visite", "date");
            $form->setType("date_contradictoire", "date");
            $form->setType("date_retour_contradictoire", "date");
            $form->setType("date_ait", "date");
            $form->setType("date_transmission_parquet", "date");
            if ($this->is_in_context_of_foreign_key("instructeur", $this->retourformulaire)) {
                $form->setType("instructeur_2", "selecthiddenstatic");
            } else {
                $form->setType("instructeur_2", "select");
            }
            $form->setType("tax_mtn_rap", "text");
            $form->setType("tax_mtn_part_commu_sans_exo", "text");
            $form->setType("tax_mtn_part_depart_sans_exo", "text");
            $form->setType("tax_mtn_part_reg_sans_exo", "text");
            $form->setType("tax_mtn_total_sans_exo", "text");
            $form->setType("tax_mtn_rap_sans_exo", "text");
            $form->setType("date_modification", "date");
            $form->setType("hash_sitadel", "text");
            $form->setType("depot_electronique", "checkbox");
            $form->setType("parcelle_temporaire", "checkbox");
            $form->setType("date_affichage", "date");
            $form->setType("version_clos", "text");
            $form->setType("initial_dt", "textarea");
            if ($this->is_in_context_of_foreign_key("commune", $this->retourformulaire)) {
                $form->setType("commune", "selecthiddenstatic");
            } else {
                $form->setType("commune", "select");
            }
            $form->setType("adresse_normalisee", "textarea");
            $form->setType("adresse_normalisee_json", "textarea");
            $form->setType("date_depot_mairie", "date");
            $form->setType("numerotation_type", "text");
            $form->setType("numerotation_dep", "text");
            $form->setType("numerotation_com", "text");
            $form->setType("numerotation_division", "text");
            $form->setType("numerotation_num", "text");
            $form->setType("numerotation_suffixe", "text");
            $form->setType("numerotation_num_suffixe", "text");
            $form->setType("numerotation_entite", "text");
            $form->setType("numerotation_num_entite", "text");
            if ($this->is_in_context_of_foreign_key("pec_metier", $this->retourformulaire)) {
                $form->setType("pec_metier", "selecthiddenstatic");
            } else {
                $form->setType("pec_metier", "select");
            }
            $form->setType("etat_transmission_platau", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_parent", "selecthiddenstatic");
            } else {
                $form->setType("dossier_parent", "select");
            }
            $form->setType("terrain_superficie_calculee", "text");
            $form->setType("geoloc_latitude", "text");
            $form->setType("geoloc_longitude", "text");
            $form->setType("geoloc_rayon", "text");
            $form->setType("geom", "geom");
            $form->setType("geom1", "geom");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier", "hiddenstatic");
            $form->setType("annee", "hiddenstatic");
            $form->setType("etat", "selectstatic");
            $form->setType("instructeur", "selectstatic");
            $form->setType("date_demande", "hiddenstatic");
            $form->setType("date_depot", "hiddenstatic");
            $form->setType("date_complet", "hiddenstatic");
            $form->setType("date_rejet", "hiddenstatic");
            $form->setType("date_notification_delai", "hiddenstatic");
            $form->setType("delai", "hiddenstatic");
            $form->setType("date_limite", "hiddenstatic");
            $form->setType("accord_tacite", "hiddenstatic");
            $form->setType("date_decision", "hiddenstatic");
            $form->setType("date_validite", "hiddenstatic");
            $form->setType("date_chantier", "hiddenstatic");
            $form->setType("date_achevement", "hiddenstatic");
            $form->setType("date_conformite", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("erp", "hiddenstatic");
            $form->setType("avis_decision", "selectstatic");
            $form->setType("enjeu_erp", "hiddenstatic");
            $form->setType("enjeu_urba", "hiddenstatic");
            $form->setType("division", "selectstatic");
            $form->setType("autorite_competente", "selectstatic");
            $form->setType("a_qualifier", "hiddenstatic");
            $form->setType("terrain_references_cadastrales", "hiddenstatic");
            $form->setType("terrain_adresse_voie_numero", "hiddenstatic");
            $form->setType("terrain_adresse_voie", "hiddenstatic");
            $form->setType("terrain_adresse_lieu_dit", "hiddenstatic");
            $form->setType("terrain_adresse_localite", "hiddenstatic");
            $form->setType("terrain_adresse_code_postal", "hiddenstatic");
            $form->setType("terrain_adresse_bp", "hiddenstatic");
            $form->setType("terrain_adresse_cedex", "hiddenstatic");
            $form->setType("terrain_superficie", "hiddenstatic");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("date_dernier_depot", "hiddenstatic");
            $form->setType("version", "hiddenstatic");
            $form->setType("incompletude", "hiddenstatic");
            $form->setType("evenement_suivant_tacite", "selectstatic");
            $form->setType("evenement_suivant_tacite_incompletude", "selectstatic");
            $form->setType("etat_pendant_incompletude", "selectstatic");
            $form->setType("date_limite_incompletude", "hiddenstatic");
            $form->setType("delai_incompletude", "hiddenstatic");
            $form->setType("dossier_libelle", "hiddenstatic");
            $form->setType("numero_versement_archive", "hiddenstatic");
            $form->setType("duree_validite", "hiddenstatic");
            $form->setType("quartier", "selectstatic");
            $form->setType("incomplet_notifie", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("tax_secteur", "hiddenstatic");
            $form->setType("tax_mtn_part_commu", "hiddenstatic");
            $form->setType("tax_mtn_part_depart", "hiddenstatic");
            $form->setType("tax_mtn_part_reg", "hiddenstatic");
            $form->setType("tax_mtn_total", "hiddenstatic");
            $form->setType("log_instructions", "hiddenstatic");
            $form->setType("interface_referentiel_erp", "hiddenstatic");
            $form->setType("autorisation_contestee", "selectstatic");
            $form->setType("date_cloture_instruction", "hiddenstatic");
            $form->setType("date_premiere_visite", "hiddenstatic");
            $form->setType("date_derniere_visite", "hiddenstatic");
            $form->setType("date_contradictoire", "hiddenstatic");
            $form->setType("date_retour_contradictoire", "hiddenstatic");
            $form->setType("date_ait", "hiddenstatic");
            $form->setType("date_transmission_parquet", "hiddenstatic");
            $form->setType("instructeur_2", "selectstatic");
            $form->setType("tax_mtn_rap", "hiddenstatic");
            $form->setType("tax_mtn_part_commu_sans_exo", "hiddenstatic");
            $form->setType("tax_mtn_part_depart_sans_exo", "hiddenstatic");
            $form->setType("tax_mtn_part_reg_sans_exo", "hiddenstatic");
            $form->setType("tax_mtn_total_sans_exo", "hiddenstatic");
            $form->setType("tax_mtn_rap_sans_exo", "hiddenstatic");
            $form->setType("date_modification", "hiddenstatic");
            $form->setType("hash_sitadel", "hiddenstatic");
            $form->setType("depot_electronique", "hiddenstatic");
            $form->setType("parcelle_temporaire", "hiddenstatic");
            $form->setType("date_affichage", "hiddenstatic");
            $form->setType("version_clos", "hiddenstatic");
            $form->setType("initial_dt", "hiddenstatic");
            $form->setType("commune", "selectstatic");
            $form->setType("adresse_normalisee", "hiddenstatic");
            $form->setType("adresse_normalisee_json", "hiddenstatic");
            $form->setType("date_depot_mairie", "hiddenstatic");
            $form->setType("numerotation_type", "hiddenstatic");
            $form->setType("numerotation_dep", "hiddenstatic");
            $form->setType("numerotation_com", "hiddenstatic");
            $form->setType("numerotation_division", "hiddenstatic");
            $form->setType("numerotation_num", "hiddenstatic");
            $form->setType("numerotation_suffixe", "hiddenstatic");
            $form->setType("numerotation_num_suffixe", "hiddenstatic");
            $form->setType("numerotation_entite", "hiddenstatic");
            $form->setType("numerotation_num_entite", "hiddenstatic");
            $form->setType("pec_metier", "selectstatic");
            $form->setType("etat_transmission_platau", "hiddenstatic");
            $form->setType("dossier_parent", "selectstatic");
            $form->setType("terrain_superficie_calculee", "hiddenstatic");
            $form->setType("geoloc_latitude", "hiddenstatic");
            $form->setType("geoloc_longitude", "hiddenstatic");
            $form->setType("geoloc_rayon", "hiddenstatic");
            $form->setType("geom", "geom");
            $form->setType("geom1", "geom");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier", "static");
            $form->setType("annee", "static");
            $form->setType("etat", "selectstatic");
            $form->setType("instructeur", "selectstatic");
            $form->setType("date_demande", "datestatic");
            $form->setType("date_depot", "datestatic");
            $form->setType("date_complet", "datestatic");
            $form->setType("date_rejet", "datestatic");
            $form->setType("date_notification_delai", "datestatic");
            $form->setType("delai", "static");
            $form->setType("date_limite", "datestatic");
            $form->setType("accord_tacite", "static");
            $form->setType("date_decision", "datestatic");
            $form->setType("date_validite", "datestatic");
            $form->setType("date_chantier", "datestatic");
            $form->setType("date_achevement", "datestatic");
            $form->setType("date_conformite", "datestatic");
            $form->setType("description", "textareastatic");
            $form->setType("erp", "checkboxstatic");
            $form->setType("avis_decision", "selectstatic");
            $form->setType("enjeu_erp", "checkboxstatic");
            $form->setType("enjeu_urba", "checkboxstatic");
            $form->setType("division", "selectstatic");
            $form->setType("autorite_competente", "selectstatic");
            $form->setType("a_qualifier", "checkboxstatic");
            $form->setType("terrain_references_cadastrales", "textareastatic");
            $form->setType("terrain_adresse_voie_numero", "static");
            $form->setType("terrain_adresse_voie", "static");
            $form->setType("terrain_adresse_lieu_dit", "static");
            $form->setType("terrain_adresse_localite", "static");
            $form->setType("terrain_adresse_code_postal", "static");
            $form->setType("terrain_adresse_bp", "static");
            $form->setType("terrain_adresse_cedex", "static");
            $form->setType("terrain_superficie", "static");
            $form->setType("dossier_autorisation", "selectstatic");
            $form->setType("dossier_instruction_type", "selectstatic");
            $form->setType("date_dernier_depot", "datestatic");
            $form->setType("version", "static");
            $form->setType("incompletude", "checkboxstatic");
            $form->setType("evenement_suivant_tacite", "selectstatic");
            $form->setType("evenement_suivant_tacite_incompletude", "selectstatic");
            $form->setType("etat_pendant_incompletude", "selectstatic");
            $form->setType("date_limite_incompletude", "datestatic");
            $form->setType("delai_incompletude", "static");
            $form->setType("dossier_libelle", "static");
            $form->setType("numero_versement_archive", "static");
            $form->setType("duree_validite", "static");
            $form->setType("quartier", "selectstatic");
            $form->setType("incomplet_notifie", "checkboxstatic");
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selectstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selectstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("tax_secteur", "static");
            $form->setType("tax_mtn_part_commu", "static");
            $form->setType("tax_mtn_part_depart", "static");
            $form->setType("tax_mtn_part_reg", "static");
            $form->setType("tax_mtn_total", "static");
            $form->setType("log_instructions", "textareastatic");
            $form->setType("interface_referentiel_erp", "checkboxstatic");
            $form->setType("autorisation_contestee", "selectstatic");
            $form->setType("date_cloture_instruction", "datestatic");
            $form->setType("date_premiere_visite", "datestatic");
            $form->setType("date_derniere_visite", "datestatic");
            $form->setType("date_contradictoire", "datestatic");
            $form->setType("date_retour_contradictoire", "datestatic");
            $form->setType("date_ait", "datestatic");
            $form->setType("date_transmission_parquet", "datestatic");
            $form->setType("instructeur_2", "selectstatic");
            $form->setType("tax_mtn_rap", "static");
            $form->setType("tax_mtn_part_commu_sans_exo", "static");
            $form->setType("tax_mtn_part_depart_sans_exo", "static");
            $form->setType("tax_mtn_part_reg_sans_exo", "static");
            $form->setType("tax_mtn_total_sans_exo", "static");
            $form->setType("tax_mtn_rap_sans_exo", "static");
            $form->setType("date_modification", "datestatic");
            $form->setType("hash_sitadel", "static");
            $form->setType("depot_electronique", "checkboxstatic");
            $form->setType("parcelle_temporaire", "checkboxstatic");
            $form->setType("date_affichage", "datestatic");
            $form->setType("version_clos", "static");
            $form->setType("initial_dt", "textareastatic");
            $form->setType("commune", "selectstatic");
            $form->setType("adresse_normalisee", "textareastatic");
            $form->setType("adresse_normalisee_json", "textareastatic");
            $form->setType("date_depot_mairie", "datestatic");
            $form->setType("numerotation_type", "static");
            $form->setType("numerotation_dep", "static");
            $form->setType("numerotation_com", "static");
            $form->setType("numerotation_division", "static");
            $form->setType("numerotation_num", "static");
            $form->setType("numerotation_suffixe", "static");
            $form->setType("numerotation_num_suffixe", "static");
            $form->setType("numerotation_entite", "static");
            $form->setType("numerotation_num_entite", "static");
            $form->setType("pec_metier", "selectstatic");
            $form->setType("etat_transmission_platau", "textareastatic");
            $form->setType("dossier_parent", "selectstatic");
            $form->setType("terrain_superficie_calculee", "static");
            $form->setType("geoloc_latitude", "static");
            $form->setType("geoloc_longitude", "static");
            $form->setType("geoloc_rayon", "static");
            $form->setType("geom", "geom");
            $form->setType("geom1", "geom");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('instructeur','VerifNum(this)');
        $form->setOnchange('date_demande','fdate(this)');
        $form->setOnchange('date_depot','fdate(this)');
        $form->setOnchange('date_complet','fdate(this)');
        $form->setOnchange('date_rejet','fdate(this)');
        $form->setOnchange('date_notification_delai','fdate(this)');
        $form->setOnchange('delai','VerifNum(this)');
        $form->setOnchange('date_limite','fdate(this)');
        $form->setOnchange('date_decision','fdate(this)');
        $form->setOnchange('date_validite','fdate(this)');
        $form->setOnchange('date_chantier','fdate(this)');
        $form->setOnchange('date_achevement','fdate(this)');
        $form->setOnchange('date_conformite','fdate(this)');
        $form->setOnchange('avis_decision','VerifNum(this)');
        $form->setOnchange('division','VerifNum(this)');
        $form->setOnchange('autorite_competente','VerifNum(this)');
        $form->setOnchange('terrain_superficie','VerifFloat(this)');
        $form->setOnchange('dossier_instruction_type','VerifNum(this)');
        $form->setOnchange('date_dernier_depot','fdate(this)');
        $form->setOnchange('version','VerifNum(this)');
        $form->setOnchange('evenement_suivant_tacite','VerifNum(this)');
        $form->setOnchange('evenement_suivant_tacite_incompletude','VerifNum(this)');
        $form->setOnchange('date_limite_incompletude','fdate(this)');
        $form->setOnchange('delai_incompletude','VerifNum(this)');
        $form->setOnchange('duree_validite','VerifNum(this)');
        $form->setOnchange('quartier','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
        $form->setOnchange('tax_secteur','VerifNum(this)');
        $form->setOnchange('tax_mtn_part_commu','VerifFloat(this)');
        $form->setOnchange('tax_mtn_part_depart','VerifFloat(this)');
        $form->setOnchange('tax_mtn_part_reg','VerifFloat(this)');
        $form->setOnchange('tax_mtn_total','VerifFloat(this)');
        $form->setOnchange('date_cloture_instruction','fdate(this)');
        $form->setOnchange('date_premiere_visite','fdate(this)');
        $form->setOnchange('date_derniere_visite','fdate(this)');
        $form->setOnchange('date_contradictoire','fdate(this)');
        $form->setOnchange('date_retour_contradictoire','fdate(this)');
        $form->setOnchange('date_ait','fdate(this)');
        $form->setOnchange('date_transmission_parquet','fdate(this)');
        $form->setOnchange('instructeur_2','VerifNum(this)');
        $form->setOnchange('tax_mtn_rap','VerifFloat(this)');
        $form->setOnchange('tax_mtn_part_commu_sans_exo','VerifFloat(this)');
        $form->setOnchange('tax_mtn_part_depart_sans_exo','VerifFloat(this)');
        $form->setOnchange('tax_mtn_part_reg_sans_exo','VerifFloat(this)');
        $form->setOnchange('tax_mtn_total_sans_exo','VerifFloat(this)');
        $form->setOnchange('tax_mtn_rap_sans_exo','VerifFloat(this)');
        $form->setOnchange('date_modification','fdate(this)');
        $form->setOnchange('date_affichage','fdate(this)');
        $form->setOnchange('version_clos','VerifNum(this)');
        $form->setOnchange('commune','VerifNum(this)');
        $form->setOnchange('date_depot_mairie','fdate(this)');
        $form->setOnchange('numerotation_num','VerifNum(this)');
        $form->setOnchange('numerotation_num_suffixe','VerifNum(this)');
        $form->setOnchange('numerotation_num_entite','VerifNum(this)');
        $form->setOnchange('pec_metier','VerifNum(this)');
        $form->setOnchange('terrain_superficie_calculee','VerifFloat(this)');
        $form->setOnchange('geoloc_rayon','VerifFloat(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier", 30);
        $form->setTaille("annee", 10);
        $form->setTaille("etat", 30);
        $form->setTaille("instructeur", 11);
        $form->setTaille("date_demande", 12);
        $form->setTaille("date_depot", 12);
        $form->setTaille("date_complet", 12);
        $form->setTaille("date_rejet", 12);
        $form->setTaille("date_notification_delai", 12);
        $form->setTaille("delai", 11);
        $form->setTaille("date_limite", 12);
        $form->setTaille("accord_tacite", 10);
        $form->setTaille("date_decision", 12);
        $form->setTaille("date_validite", 12);
        $form->setTaille("date_chantier", 12);
        $form->setTaille("date_achevement", 12);
        $form->setTaille("date_conformite", 12);
        $form->setTaille("description", 80);
        $form->setTaille("erp", 1);
        $form->setTaille("avis_decision", 11);
        $form->setTaille("enjeu_erp", 1);
        $form->setTaille("enjeu_urba", 1);
        $form->setTaille("division", 11);
        $form->setTaille("autorite_competente", 11);
        $form->setTaille("a_qualifier", 1);
        $form->setTaille("terrain_references_cadastrales", 80);
        $form->setTaille("terrain_adresse_voie_numero", 20);
        $form->setTaille("terrain_adresse_voie", 30);
        $form->setTaille("terrain_adresse_lieu_dit", 30);
        $form->setTaille("terrain_adresse_localite", 30);
        $form->setTaille("terrain_adresse_code_postal", 10);
        $form->setTaille("terrain_adresse_bp", 15);
        $form->setTaille("terrain_adresse_cedex", 15);
        $form->setTaille("terrain_superficie", 20);
        $form->setTaille("dossier_autorisation", 30);
        $form->setTaille("dossier_instruction_type", 11);
        $form->setTaille("date_dernier_depot", 12);
        $form->setTaille("version", 11);
        $form->setTaille("incompletude", 1);
        $form->setTaille("evenement_suivant_tacite", 11);
        $form->setTaille("evenement_suivant_tacite_incompletude", 11);
        $form->setTaille("etat_pendant_incompletude", 30);
        $form->setTaille("date_limite_incompletude", 12);
        $form->setTaille("delai_incompletude", 11);
        $form->setTaille("dossier_libelle", 30);
        $form->setTaille("numero_versement_archive", 30);
        $form->setTaille("duree_validite", 11);
        $form->setTaille("quartier", 11);
        $form->setTaille("incomplet_notifie", 1);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("tax_secteur", 11);
        $form->setTaille("tax_mtn_part_commu", 10);
        $form->setTaille("tax_mtn_part_depart", 10);
        $form->setTaille("tax_mtn_part_reg", 10);
        $form->setTaille("tax_mtn_total", 10);
        $form->setTaille("log_instructions", 80);
        $form->setTaille("interface_referentiel_erp", 1);
        $form->setTaille("autorisation_contestee", 30);
        $form->setTaille("date_cloture_instruction", 12);
        $form->setTaille("date_premiere_visite", 12);
        $form->setTaille("date_derniere_visite", 12);
        $form->setTaille("date_contradictoire", 12);
        $form->setTaille("date_retour_contradictoire", 12);
        $form->setTaille("date_ait", 12);
        $form->setTaille("date_transmission_parquet", 12);
        $form->setTaille("instructeur_2", 11);
        $form->setTaille("tax_mtn_rap", 10);
        $form->setTaille("tax_mtn_part_commu_sans_exo", 10);
        $form->setTaille("tax_mtn_part_depart_sans_exo", 10);
        $form->setTaille("tax_mtn_part_reg_sans_exo", 10);
        $form->setTaille("tax_mtn_total_sans_exo", 10);
        $form->setTaille("tax_mtn_rap_sans_exo", 10);
        $form->setTaille("date_modification", 12);
        $form->setTaille("hash_sitadel", 30);
        $form->setTaille("depot_electronique", 1);
        $form->setTaille("parcelle_temporaire", 1);
        $form->setTaille("date_affichage", 12);
        $form->setTaille("version_clos", 11);
        $form->setTaille("initial_dt", 80);
        $form->setTaille("commune", 11);
        $form->setTaille("adresse_normalisee", 80);
        $form->setTaille("adresse_normalisee_json", 80);
        $form->setTaille("date_depot_mairie", 12);
        $form->setTaille("numerotation_type", 10);
        $form->setTaille("numerotation_dep", 10);
        $form->setTaille("numerotation_com", 10);
        $form->setTaille("numerotation_division", 10);
        $form->setTaille("numerotation_num", 11);
        $form->setTaille("numerotation_suffixe", 20);
        $form->setTaille("numerotation_num_suffixe", 11);
        $form->setTaille("numerotation_entite", 10);
        $form->setTaille("numerotation_num_entite", 11);
        $form->setTaille("pec_metier", 11);
        $form->setTaille("etat_transmission_platau", 80);
        $form->setTaille("dossier_parent", 30);
        $form->setTaille("terrain_superficie_calculee", 20);
        $form->setTaille("geoloc_latitude", 30);
        $form->setTaille("geoloc_longitude", 30);
        $form->setTaille("geoloc_rayon", 20);
        $form->setTaille("geom", 30);
        $form->setTaille("geom1", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier", 255);
        $form->setMax("annee", 2);
        $form->setMax("etat", 150);
        $form->setMax("instructeur", 11);
        $form->setMax("date_demande", 12);
        $form->setMax("date_depot", 12);
        $form->setMax("date_complet", 12);
        $form->setMax("date_rejet", 12);
        $form->setMax("date_notification_delai", 12);
        $form->setMax("delai", 11);
        $form->setMax("date_limite", 12);
        $form->setMax("accord_tacite", 3);
        $form->setMax("date_decision", 12);
        $form->setMax("date_validite", 12);
        $form->setMax("date_chantier", 12);
        $form->setMax("date_achevement", 12);
        $form->setMax("date_conformite", 12);
        $form->setMax("description", 6);
        $form->setMax("erp", 1);
        $form->setMax("avis_decision", 11);
        $form->setMax("enjeu_erp", 1);
        $form->setMax("enjeu_urba", 1);
        $form->setMax("division", 11);
        $form->setMax("autorite_competente", 11);
        $form->setMax("a_qualifier", 1);
        $form->setMax("terrain_references_cadastrales", 6);
        $form->setMax("terrain_adresse_voie_numero", 20);
        $form->setMax("terrain_adresse_voie", 300);
        $form->setMax("terrain_adresse_lieu_dit", 30);
        $form->setMax("terrain_adresse_localite", 45);
        $form->setMax("terrain_adresse_code_postal", 5);
        $form->setMax("terrain_adresse_bp", 15);
        $form->setMax("terrain_adresse_cedex", 15);
        $form->setMax("terrain_superficie", 20);
        $form->setMax("dossier_autorisation", 255);
        $form->setMax("dossier_instruction_type", 11);
        $form->setMax("date_dernier_depot", 12);
        $form->setMax("version", 11);
        $form->setMax("incompletude", 1);
        $form->setMax("evenement_suivant_tacite", 11);
        $form->setMax("evenement_suivant_tacite_incompletude", 11);
        $form->setMax("etat_pendant_incompletude", 150);
        $form->setMax("date_limite_incompletude", 12);
        $form->setMax("delai_incompletude", 11);
        $form->setMax("dossier_libelle", 255);
        $form->setMax("numero_versement_archive", 100);
        $form->setMax("duree_validite", 11);
        $form->setMax("quartier", 11);
        $form->setMax("incomplet_notifie", 1);
        $form->setMax("om_collectivite", 11);
        $form->setMax("tax_secteur", 11);
        $form->setMax("tax_mtn_part_commu", -5);
        $form->setMax("tax_mtn_part_depart", -5);
        $form->setMax("tax_mtn_part_reg", -5);
        $form->setMax("tax_mtn_total", -5);
        $form->setMax("log_instructions", 6);
        $form->setMax("interface_referentiel_erp", 1);
        $form->setMax("autorisation_contestee", 255);
        $form->setMax("date_cloture_instruction", 12);
        $form->setMax("date_premiere_visite", 12);
        $form->setMax("date_derniere_visite", 12);
        $form->setMax("date_contradictoire", 12);
        $form->setMax("date_retour_contradictoire", 12);
        $form->setMax("date_ait", 12);
        $form->setMax("date_transmission_parquet", 12);
        $form->setMax("instructeur_2", 11);
        $form->setMax("tax_mtn_rap", -5);
        $form->setMax("tax_mtn_part_commu_sans_exo", -5);
        $form->setMax("tax_mtn_part_depart_sans_exo", -5);
        $form->setMax("tax_mtn_part_reg_sans_exo", -5);
        $form->setMax("tax_mtn_total_sans_exo", -5);
        $form->setMax("tax_mtn_rap_sans_exo", -5);
        $form->setMax("date_modification", 12);
        $form->setMax("hash_sitadel", 32);
        $form->setMax("depot_electronique", 1);
        $form->setMax("parcelle_temporaire", 1);
        $form->setMax("date_affichage", 12);
        $form->setMax("version_clos", 11);
        $form->setMax("initial_dt", 6);
        $form->setMax("commune", 11);
        $form->setMax("adresse_normalisee", 6);
        $form->setMax("adresse_normalisee_json", 6);
        $form->setMax("date_depot_mairie", 12);
        $form->setMax("numerotation_type", 3);
        $form->setMax("numerotation_dep", 3);
        $form->setMax("numerotation_com", 3);
        $form->setMax("numerotation_division", 2);
        $form->setMax("numerotation_num", 11);
        $form->setMax("numerotation_suffixe", 20);
        $form->setMax("numerotation_num_suffixe", 11);
        $form->setMax("numerotation_entite", 10);
        $form->setMax("numerotation_num_entite", 11);
        $form->setMax("pec_metier", 11);
        $form->setMax("etat_transmission_platau", 6);
        $form->setMax("dossier_parent", 255);
        $form->setMax("terrain_superficie_calculee", 20);
        $form->setMax("geoloc_latitude", 50);
        $form->setMax("geoloc_longitude", 50);
        $form->setMax("geoloc_rayon", 20);
        $form->setMax("geom", 551424);
        $form->setMax("geom1", 551444);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier', __('dossier'));
        $form->setLib('annee', __('annee'));
        $form->setLib('etat', __('etat'));
        $form->setLib('instructeur', __('instructeur'));
        $form->setLib('date_demande', __('date_demande'));
        $form->setLib('date_depot', __('date_depot'));
        $form->setLib('date_complet', __('date_complet'));
        $form->setLib('date_rejet', __('date_rejet'));
        $form->setLib('date_notification_delai', __('date_notification_delai'));
        $form->setLib('delai', __('delai'));
        $form->setLib('date_limite', __('date_limite'));
        $form->setLib('accord_tacite', __('accord_tacite'));
        $form->setLib('date_decision', __('date_decision'));
        $form->setLib('date_validite', __('date_validite'));
        $form->setLib('date_chantier', __('date_chantier'));
        $form->setLib('date_achevement', __('date_achevement'));
        $form->setLib('date_conformite', __('date_conformite'));
        $form->setLib('description', __('description'));
        $form->setLib('erp', __('erp'));
        $form->setLib('avis_decision', __('avis_decision'));
        $form->setLib('enjeu_erp', __('enjeu_erp'));
        $form->setLib('enjeu_urba', __('enjeu_urba'));
        $form->setLib('division', __('division'));
        $form->setLib('autorite_competente', __('autorite_competente'));
        $form->setLib('a_qualifier', __('a_qualifier'));
        $form->setLib('terrain_references_cadastrales', __('terrain_references_cadastrales'));
        $form->setLib('terrain_adresse_voie_numero', __('terrain_adresse_voie_numero'));
        $form->setLib('terrain_adresse_voie', __('terrain_adresse_voie'));
        $form->setLib('terrain_adresse_lieu_dit', __('terrain_adresse_lieu_dit'));
        $form->setLib('terrain_adresse_localite', __('terrain_adresse_localite'));
        $form->setLib('terrain_adresse_code_postal', __('terrain_adresse_code_postal'));
        $form->setLib('terrain_adresse_bp', __('terrain_adresse_bp'));
        $form->setLib('terrain_adresse_cedex', __('terrain_adresse_cedex'));
        $form->setLib('terrain_superficie', __('terrain_superficie'));
        $form->setLib('dossier_autorisation', __('dossier_autorisation'));
        $form->setLib('dossier_instruction_type', __('dossier_instruction_type'));
        $form->setLib('date_dernier_depot', __('date_dernier_depot'));
        $form->setLib('version', __('version'));
        $form->setLib('incompletude', __('incompletude'));
        $form->setLib('evenement_suivant_tacite', __('evenement_suivant_tacite'));
        $form->setLib('evenement_suivant_tacite_incompletude', __('evenement_suivant_tacite_incompletude'));
        $form->setLib('etat_pendant_incompletude', __('etat_pendant_incompletude'));
        $form->setLib('date_limite_incompletude', __('date_limite_incompletude'));
        $form->setLib('delai_incompletude', __('delai_incompletude'));
        $form->setLib('dossier_libelle', __('dossier_libelle'));
        $form->setLib('numero_versement_archive', __('numero_versement_archive'));
        $form->setLib('duree_validite', __('duree_validite'));
        $form->setLib('quartier', __('quartier'));
        $form->setLib('incomplet_notifie', __('incomplet_notifie'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('tax_secteur', __('tax_secteur'));
        $form->setLib('tax_mtn_part_commu', __('tax_mtn_part_commu'));
        $form->setLib('tax_mtn_part_depart', __('tax_mtn_part_depart'));
        $form->setLib('tax_mtn_part_reg', __('tax_mtn_part_reg'));
        $form->setLib('tax_mtn_total', __('tax_mtn_total'));
        $form->setLib('log_instructions', __('log_instructions'));
        $form->setLib('interface_referentiel_erp', __('interface_referentiel_erp'));
        $form->setLib('autorisation_contestee', __('autorisation_contestee'));
        $form->setLib('date_cloture_instruction', __('date_cloture_instruction'));
        $form->setLib('date_premiere_visite', __('date_premiere_visite'));
        $form->setLib('date_derniere_visite', __('date_derniere_visite'));
        $form->setLib('date_contradictoire', __('date_contradictoire'));
        $form->setLib('date_retour_contradictoire', __('date_retour_contradictoire'));
        $form->setLib('date_ait', __('date_ait'));
        $form->setLib('date_transmission_parquet', __('date_transmission_parquet'));
        $form->setLib('instructeur_2', __('instructeur_2'));
        $form->setLib('tax_mtn_rap', __('tax_mtn_rap'));
        $form->setLib('tax_mtn_part_commu_sans_exo', __('tax_mtn_part_commu_sans_exo'));
        $form->setLib('tax_mtn_part_depart_sans_exo', __('tax_mtn_part_depart_sans_exo'));
        $form->setLib('tax_mtn_part_reg_sans_exo', __('tax_mtn_part_reg_sans_exo'));
        $form->setLib('tax_mtn_total_sans_exo', __('tax_mtn_total_sans_exo'));
        $form->setLib('tax_mtn_rap_sans_exo', __('tax_mtn_rap_sans_exo'));
        $form->setLib('date_modification', __('date_modification'));
        $form->setLib('hash_sitadel', __('hash_sitadel'));
        $form->setLib('depot_electronique', __('depot_electronique'));
        $form->setLib('parcelle_temporaire', __('parcelle_temporaire'));
        $form->setLib('date_affichage', __('date_affichage'));
        $form->setLib('version_clos', __('version_clos'));
        $form->setLib('initial_dt', __('initial_dt'));
        $form->setLib('commune', __('commune'));
        $form->setLib('adresse_normalisee', __('adresse_normalisee'));
        $form->setLib('adresse_normalisee_json', __('adresse_normalisee_json'));
        $form->setLib('date_depot_mairie', __('date_depot_mairie'));
        $form->setLib('numerotation_type', __('numerotation_type'));
        $form->setLib('numerotation_dep', __('numerotation_dep'));
        $form->setLib('numerotation_com', __('numerotation_com'));
        $form->setLib('numerotation_division', __('numerotation_division'));
        $form->setLib('numerotation_num', __('numerotation_num'));
        $form->setLib('numerotation_suffixe', __('numerotation_suffixe'));
        $form->setLib('numerotation_num_suffixe', __('numerotation_num_suffixe'));
        $form->setLib('numerotation_entite', __('numerotation_entite'));
        $form->setLib('numerotation_num_entite', __('numerotation_num_entite'));
        $form->setLib('pec_metier', __('pec_metier'));
        $form->setLib('etat_transmission_platau', __('etat_transmission_platau'));
        $form->setLib('dossier_parent', __('dossier_parent'));
        $form->setLib('terrain_superficie_calculee', __('terrain_superficie_calculee'));
        $form->setLib('geoloc_latitude', __('geoloc_latitude'));
        $form->setLib('geoloc_longitude', __('geoloc_longitude'));
        $form->setLib('geoloc_rayon', __('geoloc_rayon'));
        $form->setLib('geom', __('geom'));
        $form->setLib('geom1', __('geom1'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // autorisation_contestee
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
        // commune
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "commune",
            $this->get_var_sql_forminc__sql("commune"),
            $this->get_var_sql_forminc__sql("commune_by_id"),
            true
        );
        // division
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "division",
            $this->get_var_sql_forminc__sql("division"),
            $this->get_var_sql_forminc__sql("division_by_id"),
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
        // dossier_parent
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier_parent",
            $this->get_var_sql_forminc__sql("dossier_parent"),
            $this->get_var_sql_forminc__sql("dossier_parent_by_id"),
            false
        );
        // etat
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
        // etat_pendant_incompletude
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "etat_pendant_incompletude",
            $this->get_var_sql_forminc__sql("etat_pendant_incompletude"),
            $this->get_var_sql_forminc__sql("etat_pendant_incompletude_by_id"),
            false
        );
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
        // instructeur
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "instructeur",
            $this->get_var_sql_forminc__sql("instructeur"),
            $this->get_var_sql_forminc__sql("instructeur_by_id"),
            true
        );
        // instructeur_2
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "instructeur_2",
            $this->get_var_sql_forminc__sql("instructeur_2"),
            $this->get_var_sql_forminc__sql("instructeur_2_by_id"),
            true
        );
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
        // pec_metier
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "pec_metier",
            $this->get_var_sql_forminc__sql("pec_metier"),
            $this->get_var_sql_forminc__sql("pec_metier_by_id"),
            true
        );
        // quartier
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "quartier",
            $this->get_var_sql_forminc__sql("quartier"),
            $this->get_var_sql_forminc__sql("quartier_by_id"),
            false
        );
        // geom
        if ($maj == 1 || $maj == 3) {
            $contenu = array();
            $contenu[0] = array("dossier", $this->getParameter("idx"), "0");
            $form->setSelect("geom", $contenu);
        }
        // geom1
        if ($maj == 1 || $maj == 3) {
            $contenu = array();
            $contenu[0] = array("dossier", $this->getParameter("idx"), "1");
            $form->setSelect("geom1", $contenu);
        }
    }


    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        if($validation==0 and $maj==0 and $_SESSION['niveau']==1) {
            $form->setVal('om_collectivite', $_SESSION['collectivite']);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setVal

    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation==0 and $maj==0 and $_SESSION['niveau']==1) {
            $form->setVal('om_collectivite', $_SESSION['collectivite']);
        }// fin validation
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('autorite_competente', $this->retourformulaire))
                $form->setVal('autorite_competente', $idxformulaire);
            if($this->is_in_context_of_foreign_key('avis_decision', $this->retourformulaire))
                $form->setVal('avis_decision', $idxformulaire);
            if($this->is_in_context_of_foreign_key('commune', $this->retourformulaire))
                $form->setVal('commune', $idxformulaire);
            if($this->is_in_context_of_foreign_key('division', $this->retourformulaire))
                $form->setVal('division', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_autorisation', $this->retourformulaire))
                $form->setVal('dossier_autorisation', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_instruction_type', $this->retourformulaire))
                $form->setVal('dossier_instruction_type', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
            if($this->is_in_context_of_foreign_key('pec_metier', $this->retourformulaire))
                $form->setVal('pec_metier', $idxformulaire);
            if($this->is_in_context_of_foreign_key('quartier', $this->retourformulaire))
                $form->setVal('quartier', $idxformulaire);
        }// fin validation
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('autorisation_contestee', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier_parent', $idxformulaire);
            if($this->is_in_context_of_foreign_key('etat', $this->retourformulaire))
                $form->setVal('etat', $idxformulaire);
            if($this->is_in_context_of_foreign_key('etat', $this->retourformulaire))
                $form->setVal('etat_pendant_incompletude', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement_suivant_tacite', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement_suivant_tacite_incompletude', $idxformulaire);
            if($this->is_in_context_of_foreign_key('instructeur', $this->retourformulaire))
                $form->setVal('instructeur', $idxformulaire);
            if($this->is_in_context_of_foreign_key('instructeur', $this->retourformulaire))
                $form->setVal('instructeur_2', $idxformulaire);
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
        // Verification de la cle secondaire : blocnote
        $this->rechercheTable($this->f->db, "blocnote", "dossier", $id);
        // Verification de la cle secondaire : consultation
        $this->rechercheTable($this->f->db, "consultation", "dossier", $id);
        // Verification de la cle secondaire : consultation_entrante
        $this->rechercheTable($this->f->db, "consultation_entrante", "dossier", $id);
        // Verification de la cle secondaire : demande
        $this->rechercheTable($this->f->db, "demande", "autorisation_contestee", $id);
        // Verification de la cle secondaire : demande
        $this->rechercheTable($this->f->db, "demande", "dossier_instruction", $id);
        // Verification de la cle secondaire : document_numerise
        $this->rechercheTable($this->f->db, "document_numerise", "dossier", $id);
        // Verification de la cle secondaire : donnees_techniques
        $this->rechercheTable($this->f->db, "donnees_techniques", "dossier_instruction", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "autorisation_contestee", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "dossier_parent", $id);
        // Verification de la cle secondaire : dossier_commission
        $this->rechercheTable($this->f->db, "dossier_commission", "dossier", $id);
        // Verification de la cle secondaire : dossier_contrainte
        $this->rechercheTable($this->f->db, "dossier_contrainte", "dossier", $id);
        // Verification de la cle secondaire : dossier_geolocalisation
        $this->rechercheTable($this->f->db, "dossier_geolocalisation", "dossier", $id);
        // Verification de la cle secondaire : dossier_message
        $this->rechercheTable($this->f->db, "dossier_message", "dossier", $id);
        // Verification de la cle secondaire : dossier_operateur
        $this->rechercheTable($this->f->db, "dossier_operateur", "dossier_instruction", $id);
        // Verification de la cle secondaire : dossier_parcelle
        $this->rechercheTable($this->f->db, "dossier_parcelle", "dossier", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "dossier", $id);
        // Verification de la cle secondaire : lien_dossier_demandeur
        $this->rechercheTable($this->f->db, "lien_dossier_demandeur", "dossier", $id);
        // Verification de la cle secondaire : lien_dossier_dossier
        $this->rechercheTable($this->f->db, "lien_dossier_dossier", "dossier_cible", $id);
        // Verification de la cle secondaire : lien_dossier_dossier
        $this->rechercheTable($this->f->db, "lien_dossier_dossier", "dossier_src", $id);
        // Verification de la cle secondaire : lien_dossier_nature_travaux
        $this->rechercheTable($this->f->db, "lien_dossier_nature_travaux", "dossier", $id);
        // Verification de la cle secondaire : lien_dossier_tiers
        $this->rechercheTable($this->f->db, "lien_dossier_tiers", "dossier", $id);
        // Verification de la cle secondaire : lot
        $this->rechercheTable($this->f->db, "lot", "dossier", $id);
        // Verification de la cle secondaire : rapport_instruction
        $this->rechercheTable($this->f->db, "rapport_instruction", "dossier_instruction", $id);
    }


}
