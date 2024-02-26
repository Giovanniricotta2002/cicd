<?php
//$Id$ 
//gen openMairie le 05/06/2023 16:57

require_once "../obj/om_dbform.class.php";

class instruction_gen extends om_dbform {

    protected $_absolute_class_name = "instruction";

    var $table = "instruction";
    var $clePrimaire = "instruction";
    var $typeCle = "N";
    var $required_field = array(
        "date_evenement",
        "evenement",
        "instruction"
    );
    var $unique_key = array(
      "code_barres",
    );
    var $foreign_keys_extended = array(
        "action" => array("action", ),
        "etat" => array("etat", ),
        "evenement" => array("evenement", ),
        "autorite_competente" => array("autorite_competente", ),
        "avis_decision" => array("avis_decision", ),
        "document_numerise" => array("document_numerise", ),
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
        "pec_metier" => array("pec_metier", ),
        "signataire_arrete" => array("signataire_arrete", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("destinataire");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "instruction",
            "destinataire",
            "date_evenement",
            "evenement",
            "lettretype",
            "complement_om_html",
            "complement2_om_html",
            "dossier",
            "action",
            "delai",
            "etat",
            "accord_tacite",
            "delai_notification",
            "archive_delai",
            "archive_date_complet",
            "archive_date_rejet",
            "archive_date_limite",
            "archive_date_notification_delai",
            "archive_accord_tacite",
            "archive_etat",
            "archive_date_decision",
            "archive_avis",
            "archive_date_validite",
            "archive_date_achevement",
            "archive_date_chantier",
            "archive_date_conformite",
            "complement3_om_html",
            "complement4_om_html",
            "complement5_om_html",
            "complement6_om_html",
            "complement7_om_html",
            "complement8_om_html",
            "complement9_om_html",
            "complement10_om_html",
            "complement11_om_html",
            "complement12_om_html",
            "complement13_om_html",
            "complement14_om_html",
            "complement15_om_html",
            "avis_decision",
            "date_finalisation_courrier",
            "date_envoi_signature",
            "date_retour_signature",
            "date_envoi_rar",
            "date_retour_rar",
            "date_envoi_controle_legalite",
            "date_retour_controle_legalite",
            "signataire_arrete",
            "numero_arrete",
            "archive_date_dernier_depot",
            "archive_incompletude",
            "archive_evenement_suivant_tacite",
            "archive_evenement_suivant_tacite_incompletude",
            "archive_etat_pendant_incompletude",
            "archive_date_limite_incompletude",
            "archive_delai_incompletude",
            "code_barres",
            "om_fichier_instruction",
            "om_final_instruction",
            "document_numerise",
            "archive_autorite_competente",
            "autorite_competente",
            "duree_validite_parametrage",
            "duree_validite",
            "archive_incomplet_notifie",
            "om_final_instruction_utilisateur",
            "created_by_commune",
            "date_depot",
            "archive_date_cloture_instruction",
            "archive_date_premiere_visite",
            "archive_date_derniere_visite",
            "archive_date_contradictoire",
            "archive_date_retour_contradictoire",
            "archive_date_ait",
            "archive_date_transmission_parquet",
            "om_fichier_instruction_dossier_final",
            "flag_edition_integrale",
            "titre_om_htmletat",
            "corps_om_htmletatex",
            "archive_dossier_instruction_type",
            "archive_date_affichage",
            "date_depot_mairie",
            "pec_metier",
            "archive_pec_metier",
            "archive_a_qualifier",
            "id_parapheur_signature",
            "statut_signature",
            "historique_signature",
            "commentaire_signature",
            "commentaire",
            "envoye_cl_platau",
            "parapheur_lien_page_signature",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_action() {
        return "SELECT action.action, action.libelle FROM ".DB_PREFIXE."action ORDER BY action.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_action_by_id() {
        return "SELECT action.action, action.libelle FROM ".DB_PREFIXE."action WHERE action = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_archive_etat_pendant_incompletude() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat ORDER BY etat.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_archive_etat_pendant_incompletude_by_id() {
        return "SELECT etat.etat, etat.libelle FROM ".DB_PREFIXE."etat WHERE etat = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_archive_evenement_suivant_tacite() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_archive_evenement_suivant_tacite_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_archive_evenement_suivant_tacite_incompletude() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_archive_evenement_suivant_tacite_incompletude_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
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
    function get_var_sql_forminc__sql_document_numerise() {
        return "SELECT document_numerise.document_numerise, document_numerise.uid FROM ".DB_PREFIXE."document_numerise ORDER BY document_numerise.uid ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_by_id() {
        return "SELECT document_numerise.document_numerise, document_numerise.uid FROM ".DB_PREFIXE."document_numerise WHERE document_numerise = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier() {
        return "SELECT dossier.dossier, dossier.annee FROM ".DB_PREFIXE."dossier ORDER BY dossier.annee ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_by_id() {
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
    function get_var_sql_forminc__sql_evenement() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
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
    function get_var_sql_forminc__sql_signataire_arrete() {
        return "SELECT signataire_arrete.signataire_arrete, signataire_arrete.civilite FROM ".DB_PREFIXE."signataire_arrete WHERE ((signataire_arrete.om_validite_debut IS NULL AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE)) OR (signataire_arrete.om_validite_debut <= CURRENT_DATE AND (signataire_arrete.om_validite_fin IS NULL OR signataire_arrete.om_validite_fin > CURRENT_DATE))) ORDER BY signataire_arrete.civilite ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_signataire_arrete_by_id() {
        return "SELECT signataire_arrete.signataire_arrete, signataire_arrete.civilite FROM ".DB_PREFIXE."signataire_arrete WHERE signataire_arrete = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['instruction'])) {
            $this->valF['instruction'] = ""; // -> requis
        } else {
            $this->valF['instruction'] = $val['instruction'];
        }
        if ($val['destinataire'] == "") {
            $this->valF['destinataire'] = ""; // -> default
        } else {
            $this->valF['destinataire'] = $val['destinataire'];
        }
        if ($val['date_evenement'] != "") {
            $this->valF['date_evenement'] = $this->dateDB($val['date_evenement']);
        }
        if (!is_numeric($val['evenement'])) {
            $this->valF['evenement'] = ""; // -> requis
        } else {
            $this->valF['evenement'] = $val['evenement'];
        }
        if ($val['lettretype'] == "") {
            $this->valF['lettretype'] = ""; // -> default
        } else {
            $this->valF['lettretype'] = $val['lettretype'];
        }
            $this->valF['complement_om_html'] = $val['complement_om_html'];
            $this->valF['complement2_om_html'] = $val['complement2_om_html'];
        if ($val['dossier'] == "") {
            $this->valF['dossier'] = NULL;
        } else {
            $this->valF['dossier'] = $val['dossier'];
        }
        if ($val['action'] == "") {
            $this->valF['action'] = NULL;
        } else {
            $this->valF['action'] = $val['action'];
        }
        if (!is_numeric($val['delai'])) {
            $this->valF['delai'] = NULL;
        } else {
            $this->valF['delai'] = $val['delai'];
        }
        if ($val['etat'] == "") {
            $this->valF['etat'] = NULL;
        } else {
            $this->valF['etat'] = $val['etat'];
        }
        if ($val['accord_tacite'] == "") {
            $this->valF['accord_tacite'] = ""; // -> default
        } else {
            $this->valF['accord_tacite'] = $val['accord_tacite'];
        }
        if (!is_numeric($val['delai_notification'])) {
            $this->valF['delai_notification'] = 0; // -> default
        } else {
            $this->valF['delai_notification'] = $val['delai_notification'];
        }
        if (!is_numeric($val['archive_delai'])) {
            $this->valF['archive_delai'] = 0; // -> default
        } else {
            $this->valF['archive_delai'] = $val['archive_delai'];
        }
        if ($val['archive_date_complet'] != "") {
            $this->valF['archive_date_complet'] = $this->dateDB($val['archive_date_complet']);
        } else {
            $this->valF['archive_date_complet'] = NULL;
        }
        if ($val['archive_date_rejet'] != "") {
            $this->valF['archive_date_rejet'] = $this->dateDB($val['archive_date_rejet']);
        } else {
            $this->valF['archive_date_rejet'] = NULL;
        }
        if ($val['archive_date_limite'] != "") {
            $this->valF['archive_date_limite'] = $this->dateDB($val['archive_date_limite']);
        } else {
            $this->valF['archive_date_limite'] = NULL;
        }
        if ($val['archive_date_notification_delai'] != "") {
            $this->valF['archive_date_notification_delai'] = $this->dateDB($val['archive_date_notification_delai']);
        } else {
            $this->valF['archive_date_notification_delai'] = NULL;
        }
        if ($val['archive_accord_tacite'] == "") {
            $this->valF['archive_accord_tacite'] = ""; // -> default
        } else {
            $this->valF['archive_accord_tacite'] = $val['archive_accord_tacite'];
        }
        if ($val['archive_etat'] == "") {
            $this->valF['archive_etat'] = ""; // -> default
        } else {
            $this->valF['archive_etat'] = $val['archive_etat'];
        }
        if ($val['archive_date_decision'] != "") {
            $this->valF['archive_date_decision'] = $this->dateDB($val['archive_date_decision']);
        } else {
            $this->valF['archive_date_decision'] = NULL;
        }
        if ($val['archive_avis'] == "") {
            $this->valF['archive_avis'] = ""; // -> default
        } else {
            $this->valF['archive_avis'] = $val['archive_avis'];
        }
        if ($val['archive_date_validite'] != "") {
            $this->valF['archive_date_validite'] = $this->dateDB($val['archive_date_validite']);
        } else {
            $this->valF['archive_date_validite'] = NULL;
        }
        if ($val['archive_date_achevement'] != "") {
            $this->valF['archive_date_achevement'] = $this->dateDB($val['archive_date_achevement']);
        } else {
            $this->valF['archive_date_achevement'] = NULL;
        }
        if ($val['archive_date_chantier'] != "") {
            $this->valF['archive_date_chantier'] = $this->dateDB($val['archive_date_chantier']);
        } else {
            $this->valF['archive_date_chantier'] = NULL;
        }
        if ($val['archive_date_conformite'] != "") {
            $this->valF['archive_date_conformite'] = $this->dateDB($val['archive_date_conformite']);
        } else {
            $this->valF['archive_date_conformite'] = NULL;
        }
            $this->valF['complement3_om_html'] = $val['complement3_om_html'];
            $this->valF['complement4_om_html'] = $val['complement4_om_html'];
            $this->valF['complement5_om_html'] = $val['complement5_om_html'];
            $this->valF['complement6_om_html'] = $val['complement6_om_html'];
            $this->valF['complement7_om_html'] = $val['complement7_om_html'];
            $this->valF['complement8_om_html'] = $val['complement8_om_html'];
            $this->valF['complement9_om_html'] = $val['complement9_om_html'];
            $this->valF['complement10_om_html'] = $val['complement10_om_html'];
            $this->valF['complement11_om_html'] = $val['complement11_om_html'];
            $this->valF['complement12_om_html'] = $val['complement12_om_html'];
            $this->valF['complement13_om_html'] = $val['complement13_om_html'];
            $this->valF['complement14_om_html'] = $val['complement14_om_html'];
            $this->valF['complement15_om_html'] = $val['complement15_om_html'];
        if (!is_numeric($val['avis_decision'])) {
            $this->valF['avis_decision'] = NULL;
        } else {
            $this->valF['avis_decision'] = $val['avis_decision'];
        }
        if ($val['date_finalisation_courrier'] != "") {
            $this->valF['date_finalisation_courrier'] = $this->dateDB($val['date_finalisation_courrier']);
        } else {
            $this->valF['date_finalisation_courrier'] = NULL;
        }
        if ($val['date_envoi_signature'] != "") {
            $this->valF['date_envoi_signature'] = $this->dateDB($val['date_envoi_signature']);
        } else {
            $this->valF['date_envoi_signature'] = NULL;
        }
        if ($val['date_retour_signature'] != "") {
            $this->valF['date_retour_signature'] = $this->dateDB($val['date_retour_signature']);
        } else {
            $this->valF['date_retour_signature'] = NULL;
        }
        if ($val['date_envoi_rar'] != "") {
            $this->valF['date_envoi_rar'] = $this->dateDB($val['date_envoi_rar']);
        } else {
            $this->valF['date_envoi_rar'] = NULL;
        }
        if ($val['date_retour_rar'] != "") {
            $this->valF['date_retour_rar'] = $this->dateDB($val['date_retour_rar']);
        } else {
            $this->valF['date_retour_rar'] = NULL;
        }
        if ($val['date_envoi_controle_legalite'] != "") {
            $this->valF['date_envoi_controle_legalite'] = $this->dateDB($val['date_envoi_controle_legalite']);
        } else {
            $this->valF['date_envoi_controle_legalite'] = NULL;
        }
        if ($val['date_retour_controle_legalite'] != "") {
            $this->valF['date_retour_controle_legalite'] = $this->dateDB($val['date_retour_controle_legalite']);
        } else {
            $this->valF['date_retour_controle_legalite'] = NULL;
        }
        if (!is_numeric($val['signataire_arrete'])) {
            $this->valF['signataire_arrete'] = NULL;
        } else {
            $this->valF['signataire_arrete'] = $val['signataire_arrete'];
        }
        if ($val['numero_arrete'] == "") {
            $this->valF['numero_arrete'] = NULL;
        } else {
            $this->valF['numero_arrete'] = $val['numero_arrete'];
        }
        if ($val['archive_date_dernier_depot'] != "") {
            $this->valF['archive_date_dernier_depot'] = $this->dateDB($val['archive_date_dernier_depot']);
        } else {
            $this->valF['archive_date_dernier_depot'] = NULL;
        }
        if ($val['archive_incompletude'] == 1 || $val['archive_incompletude'] == "t" || $val['archive_incompletude'] == "Oui") {
            $this->valF['archive_incompletude'] = true;
        } else {
            $this->valF['archive_incompletude'] = false;
        }
        if (!is_numeric($val['archive_evenement_suivant_tacite'])) {
            $this->valF['archive_evenement_suivant_tacite'] = NULL;
        } else {
            $this->valF['archive_evenement_suivant_tacite'] = $val['archive_evenement_suivant_tacite'];
        }
        if (!is_numeric($val['archive_evenement_suivant_tacite_incompletude'])) {
            $this->valF['archive_evenement_suivant_tacite_incompletude'] = NULL;
        } else {
            $this->valF['archive_evenement_suivant_tacite_incompletude'] = $val['archive_evenement_suivant_tacite_incompletude'];
        }
        if ($val['archive_etat_pendant_incompletude'] == "") {
            $this->valF['archive_etat_pendant_incompletude'] = NULL;
        } else {
            $this->valF['archive_etat_pendant_incompletude'] = $val['archive_etat_pendant_incompletude'];
        }
        if ($val['archive_date_limite_incompletude'] != "") {
            $this->valF['archive_date_limite_incompletude'] = $this->dateDB($val['archive_date_limite_incompletude']);
        } else {
            $this->valF['archive_date_limite_incompletude'] = NULL;
        }
        if (!is_numeric($val['archive_delai_incompletude'])) {
            $this->valF['archive_delai_incompletude'] = NULL;
        } else {
            $this->valF['archive_delai_incompletude'] = $val['archive_delai_incompletude'];
        }
        if ($val['code_barres'] == "") {
            $this->valF['code_barres'] = NULL;
        } else {
            $this->valF['code_barres'] = $val['code_barres'];
        }
        if ($val['om_fichier_instruction'] == "") {
            $this->valF['om_fichier_instruction'] = NULL;
        } else {
            $this->valF['om_fichier_instruction'] = $val['om_fichier_instruction'];
        }
        if ($val['om_final_instruction'] == 1 || $val['om_final_instruction'] == "t" || $val['om_final_instruction'] == "Oui") {
            $this->valF['om_final_instruction'] = true;
        } else {
            $this->valF['om_final_instruction'] = false;
        }
        if (!is_numeric($val['document_numerise'])) {
            $this->valF['document_numerise'] = NULL;
        } else {
            $this->valF['document_numerise'] = $val['document_numerise'];
        }
        if (!is_numeric($val['archive_autorite_competente'])) {
            $this->valF['archive_autorite_competente'] = NULL;
        } else {
            $this->valF['archive_autorite_competente'] = $val['archive_autorite_competente'];
        }
        if (!is_numeric($val['autorite_competente'])) {
            $this->valF['autorite_competente'] = NULL;
        } else {
            $this->valF['autorite_competente'] = $val['autorite_competente'];
        }
        if (!is_numeric($val['duree_validite_parametrage'])) {
            $this->valF['duree_validite_parametrage'] = 0; // -> default
        } else {
            $this->valF['duree_validite_parametrage'] = $val['duree_validite_parametrage'];
        }
        if (!is_numeric($val['duree_validite'])) {
            $this->valF['duree_validite'] = 0; // -> default
        } else {
            $this->valF['duree_validite'] = $val['duree_validite'];
        }
        if ($val['archive_incomplet_notifie'] == 1 || $val['archive_incomplet_notifie'] == "t" || $val['archive_incomplet_notifie'] == "Oui") {
            $this->valF['archive_incomplet_notifie'] = true;
        } else {
            $this->valF['archive_incomplet_notifie'] = false;
        }
            $this->valF['om_final_instruction_utilisateur'] = $val['om_final_instruction_utilisateur'];
        if ($val['created_by_commune'] == 1 || $val['created_by_commune'] == "t" || $val['created_by_commune'] == "Oui") {
            $this->valF['created_by_commune'] = true;
        } else {
            $this->valF['created_by_commune'] = false;
        }
        if ($val['date_depot'] != "") {
            $this->valF['date_depot'] = $this->dateDB($val['date_depot']);
        } else {
            $this->valF['date_depot'] = NULL;
        }
        if ($val['archive_date_cloture_instruction'] != "") {
            $this->valF['archive_date_cloture_instruction'] = $this->dateDB($val['archive_date_cloture_instruction']);
        } else {
            $this->valF['archive_date_cloture_instruction'] = NULL;
        }
        if ($val['archive_date_premiere_visite'] != "") {
            $this->valF['archive_date_premiere_visite'] = $this->dateDB($val['archive_date_premiere_visite']);
        } else {
            $this->valF['archive_date_premiere_visite'] = NULL;
        }
        if ($val['archive_date_derniere_visite'] != "") {
            $this->valF['archive_date_derniere_visite'] = $this->dateDB($val['archive_date_derniere_visite']);
        } else {
            $this->valF['archive_date_derniere_visite'] = NULL;
        }
        if ($val['archive_date_contradictoire'] != "") {
            $this->valF['archive_date_contradictoire'] = $this->dateDB($val['archive_date_contradictoire']);
        } else {
            $this->valF['archive_date_contradictoire'] = NULL;
        }
        if ($val['archive_date_retour_contradictoire'] != "") {
            $this->valF['archive_date_retour_contradictoire'] = $this->dateDB($val['archive_date_retour_contradictoire']);
        } else {
            $this->valF['archive_date_retour_contradictoire'] = NULL;
        }
        if ($val['archive_date_ait'] != "") {
            $this->valF['archive_date_ait'] = $this->dateDB($val['archive_date_ait']);
        } else {
            $this->valF['archive_date_ait'] = NULL;
        }
        if ($val['archive_date_transmission_parquet'] != "") {
            $this->valF['archive_date_transmission_parquet'] = $this->dateDB($val['archive_date_transmission_parquet']);
        } else {
            $this->valF['archive_date_transmission_parquet'] = NULL;
        }
        if ($val['om_fichier_instruction_dossier_final'] == 1 || $val['om_fichier_instruction_dossier_final'] == "t" || $val['om_fichier_instruction_dossier_final'] == "Oui") {
            $this->valF['om_fichier_instruction_dossier_final'] = true;
        } else {
            $this->valF['om_fichier_instruction_dossier_final'] = false;
        }
        if ($val['flag_edition_integrale'] == 1 || $val['flag_edition_integrale'] == "t" || $val['flag_edition_integrale'] == "Oui") {
            $this->valF['flag_edition_integrale'] = true;
        } else {
            $this->valF['flag_edition_integrale'] = false;
        }
            $this->valF['titre_om_htmletat'] = $val['titre_om_htmletat'];
            $this->valF['corps_om_htmletatex'] = $val['corps_om_htmletatex'];
        if (!is_numeric($val['archive_dossier_instruction_type'])) {
            $this->valF['archive_dossier_instruction_type'] = NULL;
        } else {
            $this->valF['archive_dossier_instruction_type'] = $val['archive_dossier_instruction_type'];
        }
        if ($val['archive_date_affichage'] != "") {
            $this->valF['archive_date_affichage'] = $this->dateDB($val['archive_date_affichage']);
        } else {
            $this->valF['archive_date_affichage'] = NULL;
        }
        if ($val['date_depot_mairie'] != "") {
            $this->valF['date_depot_mairie'] = $this->dateDB($val['date_depot_mairie']);
        } else {
            $this->valF['date_depot_mairie'] = NULL;
        }
        if (!is_numeric($val['pec_metier'])) {
            $this->valF['pec_metier'] = NULL;
        } else {
            $this->valF['pec_metier'] = $val['pec_metier'];
        }
        if (!is_numeric($val['archive_pec_metier'])) {
            $this->valF['archive_pec_metier'] = NULL;
        } else {
            $this->valF['archive_pec_metier'] = $val['archive_pec_metier'];
        }
        if ($val['archive_a_qualifier'] == 1 || $val['archive_a_qualifier'] == "t" || $val['archive_a_qualifier'] == "Oui") {
            $this->valF['archive_a_qualifier'] = true;
        } else {
            $this->valF['archive_a_qualifier'] = false;
        }
        if ($val['id_parapheur_signature'] == "") {
            $this->valF['id_parapheur_signature'] = NULL;
        } else {
            $this->valF['id_parapheur_signature'] = $val['id_parapheur_signature'];
        }
        if ($val['statut_signature'] == "") {
            $this->valF['statut_signature'] = NULL;
        } else {
            $this->valF['statut_signature'] = $val['statut_signature'];
        }
            $this->valF['historique_signature'] = $val['historique_signature'];
            $this->valF['commentaire_signature'] = $val['commentaire_signature'];
            $this->valF['commentaire'] = $val['commentaire'];
        if ($val['envoye_cl_platau'] == 1 || $val['envoye_cl_platau'] == "t" || $val['envoye_cl_platau'] == "Oui") {
            $this->valF['envoye_cl_platau'] = true;
        } else {
            $this->valF['envoye_cl_platau'] = false;
        }
        if ($val['parapheur_lien_page_signature'] == "") {
            $this->valF['parapheur_lien_page_signature'] = NULL;
        } else {
            $this->valF['parapheur_lien_page_signature'] = $val['parapheur_lien_page_signature'];
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
            $form->setType("instruction", "hidden");
            $form->setType("destinataire", "text");
            $form->setType("date_evenement", "date");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
            $form->setType("lettretype", "text");
            $form->setType("complement_om_html", "html");
            $form->setType("complement2_om_html", "html");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("action", $this->retourformulaire)) {
                $form->setType("action", "selecthiddenstatic");
            } else {
                $form->setType("action", "select");
            }
            $form->setType("delai", "text");
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
            $form->setType("accord_tacite", "text");
            $form->setType("delai_notification", "text");
            $form->setType("archive_delai", "text");
            $form->setType("archive_date_complet", "date");
            $form->setType("archive_date_rejet", "date");
            $form->setType("archive_date_limite", "date");
            $form->setType("archive_date_notification_delai", "date");
            $form->setType("archive_accord_tacite", "text");
            $form->setType("archive_etat", "text");
            $form->setType("archive_date_decision", "date");
            $form->setType("archive_avis", "text");
            $form->setType("archive_date_validite", "date");
            $form->setType("archive_date_achevement", "date");
            $form->setType("archive_date_chantier", "date");
            $form->setType("archive_date_conformite", "date");
            $form->setType("complement3_om_html", "html");
            $form->setType("complement4_om_html", "html");
            $form->setType("complement5_om_html", "html");
            $form->setType("complement6_om_html", "html");
            $form->setType("complement7_om_html", "html");
            $form->setType("complement8_om_html", "html");
            $form->setType("complement9_om_html", "html");
            $form->setType("complement10_om_html", "html");
            $form->setType("complement11_om_html", "html");
            $form->setType("complement12_om_html", "html");
            $form->setType("complement13_om_html", "html");
            $form->setType("complement14_om_html", "html");
            $form->setType("complement15_om_html", "html");
            if ($this->is_in_context_of_foreign_key("avis_decision", $this->retourformulaire)) {
                $form->setType("avis_decision", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision", "select");
            }
            $form->setType("date_finalisation_courrier", "date");
            $form->setType("date_envoi_signature", "date");
            $form->setType("date_retour_signature", "date");
            $form->setType("date_envoi_rar", "date");
            $form->setType("date_retour_rar", "date");
            $form->setType("date_envoi_controle_legalite", "date");
            $form->setType("date_retour_controle_legalite", "date");
            if ($this->is_in_context_of_foreign_key("signataire_arrete", $this->retourformulaire)) {
                $form->setType("signataire_arrete", "selecthiddenstatic");
            } else {
                $form->setType("signataire_arrete", "select");
            }
            $form->setType("numero_arrete", "text");
            $form->setType("archive_date_dernier_depot", "date");
            $form->setType("archive_incompletude", "checkbox");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("archive_evenement_suivant_tacite", "selecthiddenstatic");
            } else {
                $form->setType("archive_evenement_suivant_tacite", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("archive_evenement_suivant_tacite_incompletude", "selecthiddenstatic");
            } else {
                $form->setType("archive_evenement_suivant_tacite_incompletude", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("archive_etat_pendant_incompletude", "selecthiddenstatic");
            } else {
                $form->setType("archive_etat_pendant_incompletude", "select");
            }
            $form->setType("archive_date_limite_incompletude", "date");
            $form->setType("archive_delai_incompletude", "text");
            $form->setType("code_barres", "text");
            $form->setType("om_fichier_instruction", "text");
            $form->setType("om_final_instruction", "checkbox");
            if ($this->is_in_context_of_foreign_key("document_numerise", $this->retourformulaire)) {
                $form->setType("document_numerise", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise", "select");
            }
            $form->setType("archive_autorite_competente", "text");
            if ($this->is_in_context_of_foreign_key("autorite_competente", $this->retourformulaire)) {
                $form->setType("autorite_competente", "selecthiddenstatic");
            } else {
                $form->setType("autorite_competente", "select");
            }
            $form->setType("duree_validite_parametrage", "text");
            $form->setType("duree_validite", "text");
            $form->setType("archive_incomplet_notifie", "checkbox");
            $form->setType("om_final_instruction_utilisateur", "textarea");
            $form->setType("created_by_commune", "checkbox");
            $form->setType("date_depot", "date");
            $form->setType("archive_date_cloture_instruction", "date");
            $form->setType("archive_date_premiere_visite", "date");
            $form->setType("archive_date_derniere_visite", "date");
            $form->setType("archive_date_contradictoire", "date");
            $form->setType("archive_date_retour_contradictoire", "date");
            $form->setType("archive_date_ait", "date");
            $form->setType("archive_date_transmission_parquet", "date");
            $form->setType("om_fichier_instruction_dossier_final", "checkbox");
            $form->setType("flag_edition_integrale", "checkbox");
            $form->setType("titre_om_htmletat", "htmlEtat");
            $form->setType("corps_om_htmletatex", "htmlEtatEx");
            $form->setType("archive_dossier_instruction_type", "text");
            $form->setType("archive_date_affichage", "date");
            $form->setType("date_depot_mairie", "date");
            if ($this->is_in_context_of_foreign_key("pec_metier", $this->retourformulaire)) {
                $form->setType("pec_metier", "selecthiddenstatic");
            } else {
                $form->setType("pec_metier", "select");
            }
            $form->setType("archive_pec_metier", "text");
            $form->setType("archive_a_qualifier", "checkbox");
            $form->setType("id_parapheur_signature", "text");
            $form->setType("statut_signature", "text");
            $form->setType("historique_signature", "textarea");
            $form->setType("commentaire_signature", "textarea");
            $form->setType("commentaire", "textarea");
            $form->setType("envoye_cl_platau", "checkbox");
            $form->setType("parapheur_lien_page_signature", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("instruction", "hiddenstatic");
            $form->setType("destinataire", "text");
            $form->setType("date_evenement", "date");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
            $form->setType("lettretype", "text");
            $form->setType("complement_om_html", "html");
            $form->setType("complement2_om_html", "html");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            if ($this->is_in_context_of_foreign_key("action", $this->retourformulaire)) {
                $form->setType("action", "selecthiddenstatic");
            } else {
                $form->setType("action", "select");
            }
            $form->setType("delai", "text");
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("etat", "selecthiddenstatic");
            } else {
                $form->setType("etat", "select");
            }
            $form->setType("accord_tacite", "text");
            $form->setType("delai_notification", "text");
            $form->setType("archive_delai", "text");
            $form->setType("archive_date_complet", "date");
            $form->setType("archive_date_rejet", "date");
            $form->setType("archive_date_limite", "date");
            $form->setType("archive_date_notification_delai", "date");
            $form->setType("archive_accord_tacite", "text");
            $form->setType("archive_etat", "text");
            $form->setType("archive_date_decision", "date");
            $form->setType("archive_avis", "text");
            $form->setType("archive_date_validite", "date");
            $form->setType("archive_date_achevement", "date");
            $form->setType("archive_date_chantier", "date");
            $form->setType("archive_date_conformite", "date");
            $form->setType("complement3_om_html", "html");
            $form->setType("complement4_om_html", "html");
            $form->setType("complement5_om_html", "html");
            $form->setType("complement6_om_html", "html");
            $form->setType("complement7_om_html", "html");
            $form->setType("complement8_om_html", "html");
            $form->setType("complement9_om_html", "html");
            $form->setType("complement10_om_html", "html");
            $form->setType("complement11_om_html", "html");
            $form->setType("complement12_om_html", "html");
            $form->setType("complement13_om_html", "html");
            $form->setType("complement14_om_html", "html");
            $form->setType("complement15_om_html", "html");
            if ($this->is_in_context_of_foreign_key("avis_decision", $this->retourformulaire)) {
                $form->setType("avis_decision", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision", "select");
            }
            $form->setType("date_finalisation_courrier", "date");
            $form->setType("date_envoi_signature", "date");
            $form->setType("date_retour_signature", "date");
            $form->setType("date_envoi_rar", "date");
            $form->setType("date_retour_rar", "date");
            $form->setType("date_envoi_controle_legalite", "date");
            $form->setType("date_retour_controle_legalite", "date");
            if ($this->is_in_context_of_foreign_key("signataire_arrete", $this->retourformulaire)) {
                $form->setType("signataire_arrete", "selecthiddenstatic");
            } else {
                $form->setType("signataire_arrete", "select");
            }
            $form->setType("numero_arrete", "text");
            $form->setType("archive_date_dernier_depot", "date");
            $form->setType("archive_incompletude", "checkbox");
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("archive_evenement_suivant_tacite", "selecthiddenstatic");
            } else {
                $form->setType("archive_evenement_suivant_tacite", "select");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->retourformulaire)) {
                $form->setType("archive_evenement_suivant_tacite_incompletude", "selecthiddenstatic");
            } else {
                $form->setType("archive_evenement_suivant_tacite_incompletude", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat", $this->retourformulaire)) {
                $form->setType("archive_etat_pendant_incompletude", "selecthiddenstatic");
            } else {
                $form->setType("archive_etat_pendant_incompletude", "select");
            }
            $form->setType("archive_date_limite_incompletude", "date");
            $form->setType("archive_delai_incompletude", "text");
            $form->setType("code_barres", "text");
            $form->setType("om_fichier_instruction", "text");
            $form->setType("om_final_instruction", "checkbox");
            if ($this->is_in_context_of_foreign_key("document_numerise", $this->retourformulaire)) {
                $form->setType("document_numerise", "selecthiddenstatic");
            } else {
                $form->setType("document_numerise", "select");
            }
            $form->setType("archive_autorite_competente", "text");
            if ($this->is_in_context_of_foreign_key("autorite_competente", $this->retourformulaire)) {
                $form->setType("autorite_competente", "selecthiddenstatic");
            } else {
                $form->setType("autorite_competente", "select");
            }
            $form->setType("duree_validite_parametrage", "text");
            $form->setType("duree_validite", "text");
            $form->setType("archive_incomplet_notifie", "checkbox");
            $form->setType("om_final_instruction_utilisateur", "textarea");
            $form->setType("created_by_commune", "checkbox");
            $form->setType("date_depot", "date");
            $form->setType("archive_date_cloture_instruction", "date");
            $form->setType("archive_date_premiere_visite", "date");
            $form->setType("archive_date_derniere_visite", "date");
            $form->setType("archive_date_contradictoire", "date");
            $form->setType("archive_date_retour_contradictoire", "date");
            $form->setType("archive_date_ait", "date");
            $form->setType("archive_date_transmission_parquet", "date");
            $form->setType("om_fichier_instruction_dossier_final", "checkbox");
            $form->setType("flag_edition_integrale", "checkbox");
            $form->setType("titre_om_htmletat", "htmlEtat");
            $form->setType("corps_om_htmletatex", "htmlEtatEx");
            $form->setType("archive_dossier_instruction_type", "text");
            $form->setType("archive_date_affichage", "date");
            $form->setType("date_depot_mairie", "date");
            if ($this->is_in_context_of_foreign_key("pec_metier", $this->retourformulaire)) {
                $form->setType("pec_metier", "selecthiddenstatic");
            } else {
                $form->setType("pec_metier", "select");
            }
            $form->setType("archive_pec_metier", "text");
            $form->setType("archive_a_qualifier", "checkbox");
            $form->setType("id_parapheur_signature", "text");
            $form->setType("statut_signature", "text");
            $form->setType("historique_signature", "textarea");
            $form->setType("commentaire_signature", "textarea");
            $form->setType("commentaire", "textarea");
            $form->setType("envoye_cl_platau", "checkbox");
            $form->setType("parapheur_lien_page_signature", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("instruction", "hiddenstatic");
            $form->setType("destinataire", "hiddenstatic");
            $form->setType("date_evenement", "hiddenstatic");
            $form->setType("evenement", "selectstatic");
            $form->setType("lettretype", "hiddenstatic");
            $form->setType("complement_om_html", "hiddenstatic");
            $form->setType("complement2_om_html", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("action", "selectstatic");
            $form->setType("delai", "hiddenstatic");
            $form->setType("etat", "selectstatic");
            $form->setType("accord_tacite", "hiddenstatic");
            $form->setType("delai_notification", "hiddenstatic");
            $form->setType("archive_delai", "hiddenstatic");
            $form->setType("archive_date_complet", "hiddenstatic");
            $form->setType("archive_date_rejet", "hiddenstatic");
            $form->setType("archive_date_limite", "hiddenstatic");
            $form->setType("archive_date_notification_delai", "hiddenstatic");
            $form->setType("archive_accord_tacite", "hiddenstatic");
            $form->setType("archive_etat", "hiddenstatic");
            $form->setType("archive_date_decision", "hiddenstatic");
            $form->setType("archive_avis", "hiddenstatic");
            $form->setType("archive_date_validite", "hiddenstatic");
            $form->setType("archive_date_achevement", "hiddenstatic");
            $form->setType("archive_date_chantier", "hiddenstatic");
            $form->setType("archive_date_conformite", "hiddenstatic");
            $form->setType("complement3_om_html", "hiddenstatic");
            $form->setType("complement4_om_html", "hiddenstatic");
            $form->setType("complement5_om_html", "hiddenstatic");
            $form->setType("complement6_om_html", "hiddenstatic");
            $form->setType("complement7_om_html", "hiddenstatic");
            $form->setType("complement8_om_html", "hiddenstatic");
            $form->setType("complement9_om_html", "hiddenstatic");
            $form->setType("complement10_om_html", "hiddenstatic");
            $form->setType("complement11_om_html", "hiddenstatic");
            $form->setType("complement12_om_html", "hiddenstatic");
            $form->setType("complement13_om_html", "hiddenstatic");
            $form->setType("complement14_om_html", "hiddenstatic");
            $form->setType("complement15_om_html", "hiddenstatic");
            $form->setType("avis_decision", "selectstatic");
            $form->setType("date_finalisation_courrier", "hiddenstatic");
            $form->setType("date_envoi_signature", "hiddenstatic");
            $form->setType("date_retour_signature", "hiddenstatic");
            $form->setType("date_envoi_rar", "hiddenstatic");
            $form->setType("date_retour_rar", "hiddenstatic");
            $form->setType("date_envoi_controle_legalite", "hiddenstatic");
            $form->setType("date_retour_controle_legalite", "hiddenstatic");
            $form->setType("signataire_arrete", "selectstatic");
            $form->setType("numero_arrete", "hiddenstatic");
            $form->setType("archive_date_dernier_depot", "hiddenstatic");
            $form->setType("archive_incompletude", "hiddenstatic");
            $form->setType("archive_evenement_suivant_tacite", "selectstatic");
            $form->setType("archive_evenement_suivant_tacite_incompletude", "selectstatic");
            $form->setType("archive_etat_pendant_incompletude", "selectstatic");
            $form->setType("archive_date_limite_incompletude", "hiddenstatic");
            $form->setType("archive_delai_incompletude", "hiddenstatic");
            $form->setType("code_barres", "hiddenstatic");
            $form->setType("om_fichier_instruction", "hiddenstatic");
            $form->setType("om_final_instruction", "hiddenstatic");
            $form->setType("document_numerise", "selectstatic");
            $form->setType("archive_autorite_competente", "hiddenstatic");
            $form->setType("autorite_competente", "selectstatic");
            $form->setType("duree_validite_parametrage", "hiddenstatic");
            $form->setType("duree_validite", "hiddenstatic");
            $form->setType("archive_incomplet_notifie", "hiddenstatic");
            $form->setType("om_final_instruction_utilisateur", "hiddenstatic");
            $form->setType("created_by_commune", "hiddenstatic");
            $form->setType("date_depot", "hiddenstatic");
            $form->setType("archive_date_cloture_instruction", "hiddenstatic");
            $form->setType("archive_date_premiere_visite", "hiddenstatic");
            $form->setType("archive_date_derniere_visite", "hiddenstatic");
            $form->setType("archive_date_contradictoire", "hiddenstatic");
            $form->setType("archive_date_retour_contradictoire", "hiddenstatic");
            $form->setType("archive_date_ait", "hiddenstatic");
            $form->setType("archive_date_transmission_parquet", "hiddenstatic");
            $form->setType("om_fichier_instruction_dossier_final", "hiddenstatic");
            $form->setType("flag_edition_integrale", "hiddenstatic");
            $form->setType("titre_om_htmletat", "hiddenstatic");
            $form->setType("corps_om_htmletatex", "hiddenstatic");
            $form->setType("archive_dossier_instruction_type", "hiddenstatic");
            $form->setType("archive_date_affichage", "hiddenstatic");
            $form->setType("date_depot_mairie", "hiddenstatic");
            $form->setType("pec_metier", "selectstatic");
            $form->setType("archive_pec_metier", "hiddenstatic");
            $form->setType("archive_a_qualifier", "hiddenstatic");
            $form->setType("id_parapheur_signature", "hiddenstatic");
            $form->setType("statut_signature", "hiddenstatic");
            $form->setType("historique_signature", "hiddenstatic");
            $form->setType("commentaire_signature", "hiddenstatic");
            $form->setType("commentaire", "hiddenstatic");
            $form->setType("envoye_cl_platau", "hiddenstatic");
            $form->setType("parapheur_lien_page_signature", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("instruction", "static");
            $form->setType("destinataire", "static");
            $form->setType("date_evenement", "datestatic");
            $form->setType("evenement", "selectstatic");
            $form->setType("lettretype", "static");
            $form->setType("complement_om_html", "htmlstatic");
            $form->setType("complement2_om_html", "htmlstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("action", "selectstatic");
            $form->setType("delai", "static");
            $form->setType("etat", "selectstatic");
            $form->setType("accord_tacite", "static");
            $form->setType("delai_notification", "static");
            $form->setType("archive_delai", "static");
            $form->setType("archive_date_complet", "datestatic");
            $form->setType("archive_date_rejet", "datestatic");
            $form->setType("archive_date_limite", "datestatic");
            $form->setType("archive_date_notification_delai", "datestatic");
            $form->setType("archive_accord_tacite", "static");
            $form->setType("archive_etat", "static");
            $form->setType("archive_date_decision", "datestatic");
            $form->setType("archive_avis", "static");
            $form->setType("archive_date_validite", "datestatic");
            $form->setType("archive_date_achevement", "datestatic");
            $form->setType("archive_date_chantier", "datestatic");
            $form->setType("archive_date_conformite", "datestatic");
            $form->setType("complement3_om_html", "htmlstatic");
            $form->setType("complement4_om_html", "htmlstatic");
            $form->setType("complement5_om_html", "htmlstatic");
            $form->setType("complement6_om_html", "htmlstatic");
            $form->setType("complement7_om_html", "htmlstatic");
            $form->setType("complement8_om_html", "htmlstatic");
            $form->setType("complement9_om_html", "htmlstatic");
            $form->setType("complement10_om_html", "htmlstatic");
            $form->setType("complement11_om_html", "htmlstatic");
            $form->setType("complement12_om_html", "htmlstatic");
            $form->setType("complement13_om_html", "htmlstatic");
            $form->setType("complement14_om_html", "htmlstatic");
            $form->setType("complement15_om_html", "htmlstatic");
            $form->setType("avis_decision", "selectstatic");
            $form->setType("date_finalisation_courrier", "datestatic");
            $form->setType("date_envoi_signature", "datestatic");
            $form->setType("date_retour_signature", "datestatic");
            $form->setType("date_envoi_rar", "datestatic");
            $form->setType("date_retour_rar", "datestatic");
            $form->setType("date_envoi_controle_legalite", "datestatic");
            $form->setType("date_retour_controle_legalite", "datestatic");
            $form->setType("signataire_arrete", "selectstatic");
            $form->setType("numero_arrete", "static");
            $form->setType("archive_date_dernier_depot", "datestatic");
            $form->setType("archive_incompletude", "checkboxstatic");
            $form->setType("archive_evenement_suivant_tacite", "selectstatic");
            $form->setType("archive_evenement_suivant_tacite_incompletude", "selectstatic");
            $form->setType("archive_etat_pendant_incompletude", "selectstatic");
            $form->setType("archive_date_limite_incompletude", "datestatic");
            $form->setType("archive_delai_incompletude", "static");
            $form->setType("code_barres", "static");
            $form->setType("om_fichier_instruction", "static");
            $form->setType("om_final_instruction", "checkboxstatic");
            $form->setType("document_numerise", "selectstatic");
            $form->setType("archive_autorite_competente", "static");
            $form->setType("autorite_competente", "selectstatic");
            $form->setType("duree_validite_parametrage", "static");
            $form->setType("duree_validite", "static");
            $form->setType("archive_incomplet_notifie", "checkboxstatic");
            $form->setType("om_final_instruction_utilisateur", "textareastatic");
            $form->setType("created_by_commune", "checkboxstatic");
            $form->setType("date_depot", "datestatic");
            $form->setType("archive_date_cloture_instruction", "datestatic");
            $form->setType("archive_date_premiere_visite", "datestatic");
            $form->setType("archive_date_derniere_visite", "datestatic");
            $form->setType("archive_date_contradictoire", "datestatic");
            $form->setType("archive_date_retour_contradictoire", "datestatic");
            $form->setType("archive_date_ait", "datestatic");
            $form->setType("archive_date_transmission_parquet", "datestatic");
            $form->setType("om_fichier_instruction_dossier_final", "checkboxstatic");
            $form->setType("flag_edition_integrale", "checkboxstatic");
            $form->setType("titre_om_htmletat", "htmlstatic");
            $form->setType("corps_om_htmletatex", "htmlstatic");
            $form->setType("archive_dossier_instruction_type", "static");
            $form->setType("archive_date_affichage", "datestatic");
            $form->setType("date_depot_mairie", "datestatic");
            $form->setType("pec_metier", "selectstatic");
            $form->setType("archive_pec_metier", "static");
            $form->setType("archive_a_qualifier", "checkboxstatic");
            $form->setType("id_parapheur_signature", "static");
            $form->setType("statut_signature", "static");
            $form->setType("historique_signature", "textareastatic");
            $form->setType("commentaire_signature", "textareastatic");
            $form->setType("commentaire", "textareastatic");
            $form->setType("envoye_cl_platau", "checkboxstatic");
            $form->setType("parapheur_lien_page_signature", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('instruction','VerifNum(this)');
        $form->setOnchange('date_evenement','fdate(this)');
        $form->setOnchange('evenement','VerifNum(this)');
        $form->setOnchange('delai','VerifNum(this)');
        $form->setOnchange('delai_notification','VerifNum(this)');
        $form->setOnchange('archive_delai','VerifNum(this)');
        $form->setOnchange('archive_date_complet','fdate(this)');
        $form->setOnchange('archive_date_rejet','fdate(this)');
        $form->setOnchange('archive_date_limite','fdate(this)');
        $form->setOnchange('archive_date_notification_delai','fdate(this)');
        $form->setOnchange('archive_date_decision','fdate(this)');
        $form->setOnchange('archive_date_validite','fdate(this)');
        $form->setOnchange('archive_date_achevement','fdate(this)');
        $form->setOnchange('archive_date_chantier','fdate(this)');
        $form->setOnchange('archive_date_conformite','fdate(this)');
        $form->setOnchange('avis_decision','VerifNum(this)');
        $form->setOnchange('date_finalisation_courrier','fdate(this)');
        $form->setOnchange('date_envoi_signature','fdate(this)');
        $form->setOnchange('date_retour_signature','fdate(this)');
        $form->setOnchange('date_envoi_rar','fdate(this)');
        $form->setOnchange('date_retour_rar','fdate(this)');
        $form->setOnchange('date_envoi_controle_legalite','fdate(this)');
        $form->setOnchange('date_retour_controle_legalite','fdate(this)');
        $form->setOnchange('signataire_arrete','VerifNum(this)');
        $form->setOnchange('archive_date_dernier_depot','fdate(this)');
        $form->setOnchange('archive_evenement_suivant_tacite','VerifNum(this)');
        $form->setOnchange('archive_evenement_suivant_tacite_incompletude','VerifNum(this)');
        $form->setOnchange('archive_date_limite_incompletude','fdate(this)');
        $form->setOnchange('archive_delai_incompletude','VerifNum(this)');
        $form->setOnchange('document_numerise','VerifNum(this)');
        $form->setOnchange('archive_autorite_competente','VerifNum(this)');
        $form->setOnchange('autorite_competente','VerifNum(this)');
        $form->setOnchange('duree_validite_parametrage','VerifNum(this)');
        $form->setOnchange('duree_validite','VerifNum(this)');
        $form->setOnchange('date_depot','fdate(this)');
        $form->setOnchange('archive_date_cloture_instruction','fdate(this)');
        $form->setOnchange('archive_date_premiere_visite','fdate(this)');
        $form->setOnchange('archive_date_derniere_visite','fdate(this)');
        $form->setOnchange('archive_date_contradictoire','fdate(this)');
        $form->setOnchange('archive_date_retour_contradictoire','fdate(this)');
        $form->setOnchange('archive_date_ait','fdate(this)');
        $form->setOnchange('archive_date_transmission_parquet','fdate(this)');
        $form->setOnchange('archive_dossier_instruction_type','VerifNum(this)');
        $form->setOnchange('archive_date_affichage','fdate(this)');
        $form->setOnchange('date_depot_mairie','fdate(this)');
        $form->setOnchange('pec_metier','VerifNum(this)');
        $form->setOnchange('archive_pec_metier','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("instruction", 11);
        $form->setTaille("destinataire", 30);
        $form->setTaille("date_evenement", 12);
        $form->setTaille("evenement", 11);
        $form->setTaille("lettretype", 30);
        $form->setTaille("complement_om_html", 80);
        $form->setTaille("complement2_om_html", 80);
        $form->setTaille("dossier", 30);
        $form->setTaille("action", 30);
        $form->setTaille("delai", 11);
        $form->setTaille("etat", 30);
        $form->setTaille("accord_tacite", 10);
        $form->setTaille("delai_notification", 11);
        $form->setTaille("archive_delai", 20);
        $form->setTaille("archive_date_complet", 12);
        $form->setTaille("archive_date_rejet", 12);
        $form->setTaille("archive_date_limite", 12);
        $form->setTaille("archive_date_notification_delai", 12);
        $form->setTaille("archive_accord_tacite", 10);
        $form->setTaille("archive_etat", 30);
        $form->setTaille("archive_date_decision", 12);
        $form->setTaille("archive_avis", 20);
        $form->setTaille("archive_date_validite", 12);
        $form->setTaille("archive_date_achevement", 12);
        $form->setTaille("archive_date_chantier", 12);
        $form->setTaille("archive_date_conformite", 12);
        $form->setTaille("complement3_om_html", 80);
        $form->setTaille("complement4_om_html", 80);
        $form->setTaille("complement5_om_html", 80);
        $form->setTaille("complement6_om_html", 80);
        $form->setTaille("complement7_om_html", 80);
        $form->setTaille("complement8_om_html", 80);
        $form->setTaille("complement9_om_html", 80);
        $form->setTaille("complement10_om_html", 80);
        $form->setTaille("complement11_om_html", 80);
        $form->setTaille("complement12_om_html", 80);
        $form->setTaille("complement13_om_html", 80);
        $form->setTaille("complement14_om_html", 80);
        $form->setTaille("complement15_om_html", 80);
        $form->setTaille("avis_decision", 11);
        $form->setTaille("date_finalisation_courrier", 12);
        $form->setTaille("date_envoi_signature", 12);
        $form->setTaille("date_retour_signature", 12);
        $form->setTaille("date_envoi_rar", 12);
        $form->setTaille("date_retour_rar", 12);
        $form->setTaille("date_envoi_controle_legalite", 12);
        $form->setTaille("date_retour_controle_legalite", 12);
        $form->setTaille("signataire_arrete", 11);
        $form->setTaille("numero_arrete", 30);
        $form->setTaille("archive_date_dernier_depot", 12);
        $form->setTaille("archive_incompletude", 1);
        $form->setTaille("archive_evenement_suivant_tacite", 11);
        $form->setTaille("archive_evenement_suivant_tacite_incompletude", 11);
        $form->setTaille("archive_etat_pendant_incompletude", 30);
        $form->setTaille("archive_date_limite_incompletude", 12);
        $form->setTaille("archive_delai_incompletude", 11);
        $form->setTaille("code_barres", 12);
        $form->setTaille("om_fichier_instruction", 30);
        $form->setTaille("om_final_instruction", 1);
        $form->setTaille("document_numerise", 11);
        $form->setTaille("archive_autorite_competente", 11);
        $form->setTaille("autorite_competente", 11);
        $form->setTaille("duree_validite_parametrage", 11);
        $form->setTaille("duree_validite", 11);
        $form->setTaille("archive_incomplet_notifie", 1);
        $form->setTaille("om_final_instruction_utilisateur", 80);
        $form->setTaille("created_by_commune", 1);
        $form->setTaille("date_depot", 12);
        $form->setTaille("archive_date_cloture_instruction", 12);
        $form->setTaille("archive_date_premiere_visite", 12);
        $form->setTaille("archive_date_derniere_visite", 12);
        $form->setTaille("archive_date_contradictoire", 12);
        $form->setTaille("archive_date_retour_contradictoire", 12);
        $form->setTaille("archive_date_ait", 12);
        $form->setTaille("archive_date_transmission_parquet", 12);
        $form->setTaille("om_fichier_instruction_dossier_final", 1);
        $form->setTaille("flag_edition_integrale", 1);
        $form->setTaille("titre_om_htmletat", 80);
        $form->setTaille("corps_om_htmletatex", 80);
        $form->setTaille("archive_dossier_instruction_type", 11);
        $form->setTaille("archive_date_affichage", 12);
        $form->setTaille("date_depot_mairie", 12);
        $form->setTaille("pec_metier", 11);
        $form->setTaille("archive_pec_metier", 11);
        $form->setTaille("archive_a_qualifier", 1);
        $form->setTaille("id_parapheur_signature", 30);
        $form->setTaille("statut_signature", 30);
        $form->setTaille("historique_signature", 80);
        $form->setTaille("commentaire_signature", 80);
        $form->setTaille("commentaire", 80);
        $form->setTaille("envoye_cl_platau", 1);
        $form->setTaille("parapheur_lien_page_signature", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("instruction", 11);
        $form->setMax("destinataire", 255);
        $form->setMax("date_evenement", 12);
        $form->setMax("evenement", 11);
        $form->setMax("lettretype", 50);
        $form->setMax("complement_om_html", 6);
        $form->setMax("complement2_om_html", 6);
        $form->setMax("dossier", 255);
        $form->setMax("action", 150);
        $form->setMax("delai", 11);
        $form->setMax("etat", 150);
        $form->setMax("accord_tacite", 3);
        $form->setMax("delai_notification", 11);
        $form->setMax("archive_delai", 20);
        $form->setMax("archive_date_complet", 12);
        $form->setMax("archive_date_rejet", 12);
        $form->setMax("archive_date_limite", 12);
        $form->setMax("archive_date_notification_delai", 12);
        $form->setMax("archive_accord_tacite", 3);
        $form->setMax("archive_etat", 150);
        $form->setMax("archive_date_decision", 12);
        $form->setMax("archive_avis", 20);
        $form->setMax("archive_date_validite", 12);
        $form->setMax("archive_date_achevement", 12);
        $form->setMax("archive_date_chantier", 12);
        $form->setMax("archive_date_conformite", 12);
        $form->setMax("complement3_om_html", 6);
        $form->setMax("complement4_om_html", 6);
        $form->setMax("complement5_om_html", 6);
        $form->setMax("complement6_om_html", 6);
        $form->setMax("complement7_om_html", 6);
        $form->setMax("complement8_om_html", 6);
        $form->setMax("complement9_om_html", 6);
        $form->setMax("complement10_om_html", 6);
        $form->setMax("complement11_om_html", 6);
        $form->setMax("complement12_om_html", 6);
        $form->setMax("complement13_om_html", 6);
        $form->setMax("complement14_om_html", 6);
        $form->setMax("complement15_om_html", 6);
        $form->setMax("avis_decision", 11);
        $form->setMax("date_finalisation_courrier", 12);
        $form->setMax("date_envoi_signature", 12);
        $form->setMax("date_retour_signature", 12);
        $form->setMax("date_envoi_rar", 12);
        $form->setMax("date_retour_rar", 12);
        $form->setMax("date_envoi_controle_legalite", 12);
        $form->setMax("date_retour_controle_legalite", 12);
        $form->setMax("signataire_arrete", 11);
        $form->setMax("numero_arrete", 100);
        $form->setMax("archive_date_dernier_depot", 12);
        $form->setMax("archive_incompletude", 1);
        $form->setMax("archive_evenement_suivant_tacite", 11);
        $form->setMax("archive_evenement_suivant_tacite_incompletude", 11);
        $form->setMax("archive_etat_pendant_incompletude", 150);
        $form->setMax("archive_date_limite_incompletude", 12);
        $form->setMax("archive_delai_incompletude", 11);
        $form->setMax("code_barres", 12);
        $form->setMax("om_fichier_instruction", 255);
        $form->setMax("om_final_instruction", 1);
        $form->setMax("document_numerise", 11);
        $form->setMax("archive_autorite_competente", 11);
        $form->setMax("autorite_competente", 11);
        $form->setMax("duree_validite_parametrage", 11);
        $form->setMax("duree_validite", 11);
        $form->setMax("archive_incomplet_notifie", 1);
        $form->setMax("om_final_instruction_utilisateur", 6);
        $form->setMax("created_by_commune", 1);
        $form->setMax("date_depot", 12);
        $form->setMax("archive_date_cloture_instruction", 12);
        $form->setMax("archive_date_premiere_visite", 12);
        $form->setMax("archive_date_derniere_visite", 12);
        $form->setMax("archive_date_contradictoire", 12);
        $form->setMax("archive_date_retour_contradictoire", 12);
        $form->setMax("archive_date_ait", 12);
        $form->setMax("archive_date_transmission_parquet", 12);
        $form->setMax("om_fichier_instruction_dossier_final", 1);
        $form->setMax("flag_edition_integrale", 1);
        $form->setMax("titre_om_htmletat", 6);
        $form->setMax("corps_om_htmletatex", 6);
        $form->setMax("archive_dossier_instruction_type", 11);
        $form->setMax("archive_date_affichage", 12);
        $form->setMax("date_depot_mairie", 12);
        $form->setMax("pec_metier", 11);
        $form->setMax("archive_pec_metier", 11);
        $form->setMax("archive_a_qualifier", 1);
        $form->setMax("id_parapheur_signature", 255);
        $form->setMax("statut_signature", 255);
        $form->setMax("historique_signature", 6);
        $form->setMax("commentaire_signature", 6);
        $form->setMax("commentaire", 6);
        $form->setMax("envoye_cl_platau", 1);
        $form->setMax("parapheur_lien_page_signature", 1000);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('instruction', __('instruction'));
        $form->setLib('destinataire', __('destinataire'));
        $form->setLib('date_evenement', __('date_evenement'));
        $form->setLib('evenement', __('evenement'));
        $form->setLib('lettretype', __('lettretype'));
        $form->setLib('complement_om_html', __('complement_om_html'));
        $form->setLib('complement2_om_html', __('complement2_om_html'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('action', __('action'));
        $form->setLib('delai', __('delai'));
        $form->setLib('etat', __('etat'));
        $form->setLib('accord_tacite', __('accord_tacite'));
        $form->setLib('delai_notification', __('delai_notification'));
        $form->setLib('archive_delai', __('archive_delai'));
        $form->setLib('archive_date_complet', __('archive_date_complet'));
        $form->setLib('archive_date_rejet', __('archive_date_rejet'));
        $form->setLib('archive_date_limite', __('archive_date_limite'));
        $form->setLib('archive_date_notification_delai', __('archive_date_notification_delai'));
        $form->setLib('archive_accord_tacite', __('archive_accord_tacite'));
        $form->setLib('archive_etat', __('archive_etat'));
        $form->setLib('archive_date_decision', __('archive_date_decision'));
        $form->setLib('archive_avis', __('archive_avis'));
        $form->setLib('archive_date_validite', __('archive_date_validite'));
        $form->setLib('archive_date_achevement', __('archive_date_achevement'));
        $form->setLib('archive_date_chantier', __('archive_date_chantier'));
        $form->setLib('archive_date_conformite', __('archive_date_conformite'));
        $form->setLib('complement3_om_html', __('complement3_om_html'));
        $form->setLib('complement4_om_html', __('complement4_om_html'));
        $form->setLib('complement5_om_html', __('complement5_om_html'));
        $form->setLib('complement6_om_html', __('complement6_om_html'));
        $form->setLib('complement7_om_html', __('complement7_om_html'));
        $form->setLib('complement8_om_html', __('complement8_om_html'));
        $form->setLib('complement9_om_html', __('complement9_om_html'));
        $form->setLib('complement10_om_html', __('complement10_om_html'));
        $form->setLib('complement11_om_html', __('complement11_om_html'));
        $form->setLib('complement12_om_html', __('complement12_om_html'));
        $form->setLib('complement13_om_html', __('complement13_om_html'));
        $form->setLib('complement14_om_html', __('complement14_om_html'));
        $form->setLib('complement15_om_html', __('complement15_om_html'));
        $form->setLib('avis_decision', __('avis_decision'));
        $form->setLib('date_finalisation_courrier', __('date_finalisation_courrier'));
        $form->setLib('date_envoi_signature', __('date_envoi_signature'));
        $form->setLib('date_retour_signature', __('date_retour_signature'));
        $form->setLib('date_envoi_rar', __('date_envoi_rar'));
        $form->setLib('date_retour_rar', __('date_retour_rar'));
        $form->setLib('date_envoi_controle_legalite', __('date_envoi_controle_legalite'));
        $form->setLib('date_retour_controle_legalite', __('date_retour_controle_legalite'));
        $form->setLib('signataire_arrete', __('signataire_arrete'));
        $form->setLib('numero_arrete', __('numero_arrete'));
        $form->setLib('archive_date_dernier_depot', __('archive_date_dernier_depot'));
        $form->setLib('archive_incompletude', __('archive_incompletude'));
        $form->setLib('archive_evenement_suivant_tacite', __('archive_evenement_suivant_tacite'));
        $form->setLib('archive_evenement_suivant_tacite_incompletude', __('archive_evenement_suivant_tacite_incompletude'));
        $form->setLib('archive_etat_pendant_incompletude', __('archive_etat_pendant_incompletude'));
        $form->setLib('archive_date_limite_incompletude', __('archive_date_limite_incompletude'));
        $form->setLib('archive_delai_incompletude', __('archive_delai_incompletude'));
        $form->setLib('code_barres', __('code_barres'));
        $form->setLib('om_fichier_instruction', __('om_fichier_instruction'));
        $form->setLib('om_final_instruction', __('om_final_instruction'));
        $form->setLib('document_numerise', __('document_numerise'));
        $form->setLib('archive_autorite_competente', __('archive_autorite_competente'));
        $form->setLib('autorite_competente', __('autorite_competente'));
        $form->setLib('duree_validite_parametrage', __('duree_validite_parametrage'));
        $form->setLib('duree_validite', __('duree_validite'));
        $form->setLib('archive_incomplet_notifie', __('archive_incomplet_notifie'));
        $form->setLib('om_final_instruction_utilisateur', __('om_final_instruction_utilisateur'));
        $form->setLib('created_by_commune', __('created_by_commune'));
        $form->setLib('date_depot', __('date_depot'));
        $form->setLib('archive_date_cloture_instruction', __('archive_date_cloture_instruction'));
        $form->setLib('archive_date_premiere_visite', __('archive_date_premiere_visite'));
        $form->setLib('archive_date_derniere_visite', __('archive_date_derniere_visite'));
        $form->setLib('archive_date_contradictoire', __('archive_date_contradictoire'));
        $form->setLib('archive_date_retour_contradictoire', __('archive_date_retour_contradictoire'));
        $form->setLib('archive_date_ait', __('archive_date_ait'));
        $form->setLib('archive_date_transmission_parquet', __('archive_date_transmission_parquet'));
        $form->setLib('om_fichier_instruction_dossier_final', __('om_fichier_instruction_dossier_final'));
        $form->setLib('flag_edition_integrale', __('flag_edition_integrale'));
        $form->setLib('titre_om_htmletat', __('titre_om_htmletat'));
        $form->setLib('corps_om_htmletatex', __('corps_om_htmletatex'));
        $form->setLib('archive_dossier_instruction_type', __('archive_dossier_instruction_type'));
        $form->setLib('archive_date_affichage', __('archive_date_affichage'));
        $form->setLib('date_depot_mairie', __('date_depot_mairie'));
        $form->setLib('pec_metier', __('pec_metier'));
        $form->setLib('archive_pec_metier', __('archive_pec_metier'));
        $form->setLib('archive_a_qualifier', __('archive_a_qualifier'));
        $form->setLib('id_parapheur_signature', __('id_parapheur_signature'));
        $form->setLib('statut_signature', __('statut_signature'));
        $form->setLib('historique_signature', __('historique_signature'));
        $form->setLib('commentaire_signature', __('commentaire_signature'));
        $form->setLib('commentaire', __('commentaire'));
        $form->setLib('envoye_cl_platau', __('envoye_cl_platau'));
        $form->setLib('parapheur_lien_page_signature', __('parapheur_lien_page_signature'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // action
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "action",
            $this->get_var_sql_forminc__sql("action"),
            $this->get_var_sql_forminc__sql("action_by_id"),
            false
        );
        // archive_etat_pendant_incompletude
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "archive_etat_pendant_incompletude",
            $this->get_var_sql_forminc__sql("archive_etat_pendant_incompletude"),
            $this->get_var_sql_forminc__sql("archive_etat_pendant_incompletude_by_id"),
            false
        );
        // archive_evenement_suivant_tacite
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "archive_evenement_suivant_tacite",
            $this->get_var_sql_forminc__sql("archive_evenement_suivant_tacite"),
            $this->get_var_sql_forminc__sql("archive_evenement_suivant_tacite_by_id"),
            false
        );
        // archive_evenement_suivant_tacite_incompletude
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "archive_evenement_suivant_tacite_incompletude",
            $this->get_var_sql_forminc__sql("archive_evenement_suivant_tacite_incompletude"),
            $this->get_var_sql_forminc__sql("archive_evenement_suivant_tacite_incompletude_by_id"),
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
        // document_numerise
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "document_numerise",
            $this->get_var_sql_forminc__sql("document_numerise"),
            $this->get_var_sql_forminc__sql("document_numerise_by_id"),
            false
        );
        // dossier
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "dossier",
            $this->get_var_sql_forminc__sql("dossier"),
            $this->get_var_sql_forminc__sql("dossier_by_id"),
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
        // evenement
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "evenement",
            $this->get_var_sql_forminc__sql("evenement"),
            $this->get_var_sql_forminc__sql("evenement_by_id"),
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
        // signataire_arrete
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "signataire_arrete",
            $this->get_var_sql_forminc__sql("signataire_arrete"),
            $this->get_var_sql_forminc__sql("signataire_arrete_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('action', $this->retourformulaire))
                $form->setVal('action', $idxformulaire);
            if($this->is_in_context_of_foreign_key('autorite_competente', $this->retourformulaire))
                $form->setVal('autorite_competente', $idxformulaire);
            if($this->is_in_context_of_foreign_key('avis_decision', $this->retourformulaire))
                $form->setVal('avis_decision', $idxformulaire);
            if($this->is_in_context_of_foreign_key('document_numerise', $this->retourformulaire))
                $form->setVal('document_numerise', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier', $idxformulaire);
            if($this->is_in_context_of_foreign_key('pec_metier', $this->retourformulaire))
                $form->setVal('pec_metier', $idxformulaire);
            if($this->is_in_context_of_foreign_key('signataire_arrete', $this->retourformulaire))
                $form->setVal('signataire_arrete', $idxformulaire);
        }// fin validation
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('etat', $this->retourformulaire))
                $form->setVal('archive_etat_pendant_incompletude', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('archive_evenement_suivant_tacite', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('archive_evenement_suivant_tacite_incompletude', $idxformulaire);
            if($this->is_in_context_of_foreign_key('etat', $this->retourformulaire))
                $form->setVal('etat', $idxformulaire);
            if($this->is_in_context_of_foreign_key('evenement', $this->retourformulaire))
                $form->setVal('evenement', $idxformulaire);
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
        // Verification de la cle secondaire : demande
        $this->rechercheTable($this->f->db, "demande", "instruction_recepisse", $id);
        // Verification de la cle secondaire : instruction_notification
        $this->rechercheTable($this->f->db, "instruction_notification", "instruction", $id);
    }


}
