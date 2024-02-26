<?php
//$Id$ 
//gen openMairie le 26/07/2023 15:51

require_once "../obj/om_dbform.class.php";

class dossier_autorisation_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_autorisation";

    var $table = "dossier_autorisation";
    var $clePrimaire = "dossier_autorisation";
    var $typeCle = "A";
    var $required_field = array(
        "dossier_autorisation",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
        "arrondissement" => array("arrondissement", ),
        "avis_decision" => array("avis_decision", ),
        "commune" => array("commune", ),
        "dossier_autorisation_type_detaille" => array("dossier_autorisation_type_detaille", ),
        "etat_dossier_autorisation" => array("etat_dossier_autorisation", ),
        "om_collectivite" => array("om_collectivite", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("dossier_autorisation_type_detaille");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "dossier_autorisation",
            "dossier_autorisation_type_detaille",
            "exercice",
            "insee",
            "terrain_references_cadastrales",
            "terrain_adresse_voie_numero",
            "terrain_adresse_voie",
            "terrain_adresse_lieu_dit",
            "terrain_adresse_localite",
            "terrain_adresse_code_postal",
            "terrain_adresse_bp",
            "terrain_adresse_cedex",
            "terrain_superficie",
            "arrondissement",
            "depot_initial",
            "erp_numero_batiment",
            "erp_ouvert",
            "erp_date_ouverture",
            "erp_arrete_decision",
            "erp_date_arrete_decision",
            "numero_version",
            "etat_dossier_autorisation",
            "date_depot",
            "date_decision",
            "date_validite",
            "date_chantier",
            "date_achevement",
            "avis_decision",
            "etat_dernier_dossier_instruction_accepte",
            "dossier_autorisation_libelle",
            "om_collectivite",
            "cle_acces_citoyen",
            "numero_version_clos",
            "commune",
            "adresse_normalisee",
            "adresse_normalisee_json",
            "numerotation_type",
            "numerotation_dep",
            "numerotation_com",
            "numerotation_division",
            "numerotation_num",
        );
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
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle FROM ".DB_PREFIXE."dossier_autorisation_type_detaille ORDER BY dossier_autorisation_type_detaille.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille_by_id() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle FROM ".DB_PREFIXE."dossier_autorisation_type_detaille WHERE dossier_autorisation_type_detaille = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat_dernier_dossier_instruction_accepte() {
        return "SELECT etat_dossier_autorisation.etat_dossier_autorisation, etat_dossier_autorisation.libelle FROM ".DB_PREFIXE."etat_dossier_autorisation ORDER BY etat_dossier_autorisation.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat_dernier_dossier_instruction_accepte_by_id() {
        return "SELECT etat_dossier_autorisation.etat_dossier_autorisation, etat_dossier_autorisation.libelle FROM ".DB_PREFIXE."etat_dossier_autorisation WHERE etat_dossier_autorisation = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat_dossier_autorisation() {
        return "SELECT etat_dossier_autorisation.etat_dossier_autorisation, etat_dossier_autorisation.libelle FROM ".DB_PREFIXE."etat_dossier_autorisation ORDER BY etat_dossier_autorisation.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etat_dossier_autorisation_by_id() {
        return "SELECT etat_dossier_autorisation.etat_dossier_autorisation, etat_dossier_autorisation.libelle FROM ".DB_PREFIXE."etat_dossier_autorisation WHERE etat_dossier_autorisation = <idx>";
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        $this->valF['dossier_autorisation'] = $val['dossier_autorisation'];
        if (!is_numeric($val['dossier_autorisation_type_detaille'])) {
            $this->valF['dossier_autorisation_type_detaille'] = NULL;
        } else {
            $this->valF['dossier_autorisation_type_detaille'] = $val['dossier_autorisation_type_detaille'];
        }
        if (!is_numeric($val['exercice'])) {
            $this->valF['exercice'] = NULL;
        } else {
            $this->valF['exercice'] = $val['exercice'];
        }
        if ($val['insee'] == "") {
            $this->valF['insee'] = NULL;
        } else {
            $this->valF['insee'] = $val['insee'];
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
        if (!is_numeric($val['arrondissement'])) {
            $this->valF['arrondissement'] = NULL;
        } else {
            $this->valF['arrondissement'] = $val['arrondissement'];
        }
        if ($val['depot_initial'] != "") {
            $this->valF['depot_initial'] = $this->dateDB($val['depot_initial']);
        } else {
            $this->valF['depot_initial'] = NULL;
        }
        if (!is_numeric($val['erp_numero_batiment'])) {
            $this->valF['erp_numero_batiment'] = NULL;
        } else {
            $this->valF['erp_numero_batiment'] = $val['erp_numero_batiment'];
        }
        if ($val['erp_ouvert'] == 1 || $val['erp_ouvert'] == "t" || $val['erp_ouvert'] == "Oui") {
            $this->valF['erp_ouvert'] = true;
        } else {
            $this->valF['erp_ouvert'] = false;
        }
        if ($val['erp_date_ouverture'] != "") {
            $this->valF['erp_date_ouverture'] = $this->dateDB($val['erp_date_ouverture']);
        } else {
            $this->valF['erp_date_ouverture'] = NULL;
        }
        if ($val['erp_arrete_decision'] == 1 || $val['erp_arrete_decision'] == "t" || $val['erp_arrete_decision'] == "Oui") {
            $this->valF['erp_arrete_decision'] = true;
        } else {
            $this->valF['erp_arrete_decision'] = false;
        }
        if ($val['erp_date_arrete_decision'] != "") {
            $this->valF['erp_date_arrete_decision'] = $this->dateDB($val['erp_date_arrete_decision']);
        } else {
            $this->valF['erp_date_arrete_decision'] = NULL;
        }
        if (!is_numeric($val['numero_version'])) {
            $this->valF['numero_version'] = NULL;
        } else {
            $this->valF['numero_version'] = $val['numero_version'];
        }
        if (!is_numeric($val['etat_dossier_autorisation'])) {
            $this->valF['etat_dossier_autorisation'] = NULL;
        } else {
            $this->valF['etat_dossier_autorisation'] = $val['etat_dossier_autorisation'];
        }
        if ($val['date_depot'] != "") {
            $this->valF['date_depot'] = $this->dateDB($val['date_depot']);
        } else {
            $this->valF['date_depot'] = NULL;
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
        if (!is_numeric($val['avis_decision'])) {
            $this->valF['avis_decision'] = NULL;
        } else {
            $this->valF['avis_decision'] = $val['avis_decision'];
        }
        if (!is_numeric($val['etat_dernier_dossier_instruction_accepte'])) {
            $this->valF['etat_dernier_dossier_instruction_accepte'] = NULL;
        } else {
            $this->valF['etat_dernier_dossier_instruction_accepte'] = $val['etat_dernier_dossier_instruction_accepte'];
        }
        if ($val['dossier_autorisation_libelle'] == "") {
            $this->valF['dossier_autorisation_libelle'] = NULL;
        } else {
            $this->valF['dossier_autorisation_libelle'] = $val['dossier_autorisation_libelle'];
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
        if ($val['cle_acces_citoyen'] == "") {
            $this->valF['cle_acces_citoyen'] = NULL;
        } else {
            $this->valF['cle_acces_citoyen'] = $val['cle_acces_citoyen'];
        }
        if (!is_numeric($val['numero_version_clos'])) {
            $this->valF['numero_version_clos'] = NULL;
        } else {
            $this->valF['numero_version_clos'] = $val['numero_version_clos'];
        }
        if (!is_numeric($val['commune'])) {
            $this->valF['commune'] = NULL;
        } else {
            $this->valF['commune'] = $val['commune'];
        }
            $this->valF['adresse_normalisee'] = $val['adresse_normalisee'];
            $this->valF['adresse_normalisee_json'] = $val['adresse_normalisee_json'];
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
            $form->setType("dossier_autorisation", "text");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
            }
            $form->setType("exercice", "text");
            $form->setType("insee", "text");
            $form->setType("terrain_references_cadastrales", "textarea");
            $form->setType("terrain_adresse_voie_numero", "text");
            $form->setType("terrain_adresse_voie", "text");
            $form->setType("terrain_adresse_lieu_dit", "text");
            $form->setType("terrain_adresse_localite", "text");
            $form->setType("terrain_adresse_code_postal", "text");
            $form->setType("terrain_adresse_bp", "text");
            $form->setType("terrain_adresse_cedex", "text");
            $form->setType("terrain_superficie", "text");
            if ($this->is_in_context_of_foreign_key("arrondissement", $this->retourformulaire)) {
                $form->setType("arrondissement", "selecthiddenstatic");
            } else {
                $form->setType("arrondissement", "select");
            }
            $form->setType("depot_initial", "date");
            $form->setType("erp_numero_batiment", "text");
            $form->setType("erp_ouvert", "checkbox");
            $form->setType("erp_date_ouverture", "date");
            $form->setType("erp_arrete_decision", "checkbox");
            $form->setType("erp_date_arrete_decision", "date");
            $form->setType("numero_version", "text");
            if ($this->is_in_context_of_foreign_key("etat_dossier_autorisation", $this->retourformulaire)) {
                $form->setType("etat_dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("etat_dossier_autorisation", "select");
            }
            $form->setType("date_depot", "date");
            $form->setType("date_decision", "date");
            $form->setType("date_validite", "date");
            $form->setType("date_chantier", "date");
            $form->setType("date_achevement", "date");
            if ($this->is_in_context_of_foreign_key("avis_decision", $this->retourformulaire)) {
                $form->setType("avis_decision", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat_dossier_autorisation", $this->retourformulaire)) {
                $form->setType("etat_dernier_dossier_instruction_accepte", "selecthiddenstatic");
            } else {
                $form->setType("etat_dernier_dossier_instruction_accepte", "select");
            }
            $form->setType("dossier_autorisation_libelle", "text");
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
            $form->setType("cle_acces_citoyen", "text");
            $form->setType("numero_version_clos", "text");
            if ($this->is_in_context_of_foreign_key("commune", $this->retourformulaire)) {
                $form->setType("commune", "selecthiddenstatic");
            } else {
                $form->setType("commune", "select");
            }
            $form->setType("adresse_normalisee", "textarea");
            $form->setType("adresse_normalisee_json", "textarea");
            $form->setType("numerotation_type", "text");
            $form->setType("numerotation_dep", "text");
            $form->setType("numerotation_com", "text");
            $form->setType("numerotation_division", "text");
            $form->setType("numerotation_num", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_autorisation", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $this->retourformulaire)) {
                $form->setType("dossier_autorisation_type_detaille", "selecthiddenstatic");
            } else {
                $form->setType("dossier_autorisation_type_detaille", "select");
            }
            $form->setType("exercice", "text");
            $form->setType("insee", "text");
            $form->setType("terrain_references_cadastrales", "textarea");
            $form->setType("terrain_adresse_voie_numero", "text");
            $form->setType("terrain_adresse_voie", "text");
            $form->setType("terrain_adresse_lieu_dit", "text");
            $form->setType("terrain_adresse_localite", "text");
            $form->setType("terrain_adresse_code_postal", "text");
            $form->setType("terrain_adresse_bp", "text");
            $form->setType("terrain_adresse_cedex", "text");
            $form->setType("terrain_superficie", "text");
            if ($this->is_in_context_of_foreign_key("arrondissement", $this->retourformulaire)) {
                $form->setType("arrondissement", "selecthiddenstatic");
            } else {
                $form->setType("arrondissement", "select");
            }
            $form->setType("depot_initial", "date");
            $form->setType("erp_numero_batiment", "text");
            $form->setType("erp_ouvert", "checkbox");
            $form->setType("erp_date_ouverture", "date");
            $form->setType("erp_arrete_decision", "checkbox");
            $form->setType("erp_date_arrete_decision", "date");
            $form->setType("numero_version", "text");
            if ($this->is_in_context_of_foreign_key("etat_dossier_autorisation", $this->retourformulaire)) {
                $form->setType("etat_dossier_autorisation", "selecthiddenstatic");
            } else {
                $form->setType("etat_dossier_autorisation", "select");
            }
            $form->setType("date_depot", "date");
            $form->setType("date_decision", "date");
            $form->setType("date_validite", "date");
            $form->setType("date_chantier", "date");
            $form->setType("date_achevement", "date");
            if ($this->is_in_context_of_foreign_key("avis_decision", $this->retourformulaire)) {
                $form->setType("avis_decision", "selecthiddenstatic");
            } else {
                $form->setType("avis_decision", "select");
            }
            if ($this->is_in_context_of_foreign_key("etat_dossier_autorisation", $this->retourformulaire)) {
                $form->setType("etat_dernier_dossier_instruction_accepte", "selecthiddenstatic");
            } else {
                $form->setType("etat_dernier_dossier_instruction_accepte", "select");
            }
            $form->setType("dossier_autorisation_libelle", "text");
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
            $form->setType("cle_acces_citoyen", "text");
            $form->setType("numero_version_clos", "text");
            if ($this->is_in_context_of_foreign_key("commune", $this->retourformulaire)) {
                $form->setType("commune", "selecthiddenstatic");
            } else {
                $form->setType("commune", "select");
            }
            $form->setType("adresse_normalisee", "textarea");
            $form->setType("adresse_normalisee_json", "textarea");
            $form->setType("numerotation_type", "text");
            $form->setType("numerotation_dep", "text");
            $form->setType("numerotation_com", "text");
            $form->setType("numerotation_division", "text");
            $form->setType("numerotation_num", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_autorisation", "hiddenstatic");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
            $form->setType("exercice", "hiddenstatic");
            $form->setType("insee", "hiddenstatic");
            $form->setType("terrain_references_cadastrales", "hiddenstatic");
            $form->setType("terrain_adresse_voie_numero", "hiddenstatic");
            $form->setType("terrain_adresse_voie", "hiddenstatic");
            $form->setType("terrain_adresse_lieu_dit", "hiddenstatic");
            $form->setType("terrain_adresse_localite", "hiddenstatic");
            $form->setType("terrain_adresse_code_postal", "hiddenstatic");
            $form->setType("terrain_adresse_bp", "hiddenstatic");
            $form->setType("terrain_adresse_cedex", "hiddenstatic");
            $form->setType("terrain_superficie", "hiddenstatic");
            $form->setType("arrondissement", "selectstatic");
            $form->setType("depot_initial", "hiddenstatic");
            $form->setType("erp_numero_batiment", "hiddenstatic");
            $form->setType("erp_ouvert", "hiddenstatic");
            $form->setType("erp_date_ouverture", "hiddenstatic");
            $form->setType("erp_arrete_decision", "hiddenstatic");
            $form->setType("erp_date_arrete_decision", "hiddenstatic");
            $form->setType("numero_version", "hiddenstatic");
            $form->setType("etat_dossier_autorisation", "selectstatic");
            $form->setType("date_depot", "hiddenstatic");
            $form->setType("date_decision", "hiddenstatic");
            $form->setType("date_validite", "hiddenstatic");
            $form->setType("date_chantier", "hiddenstatic");
            $form->setType("date_achevement", "hiddenstatic");
            $form->setType("avis_decision", "selectstatic");
            $form->setType("etat_dernier_dossier_instruction_accepte", "selectstatic");
            $form->setType("dossier_autorisation_libelle", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("cle_acces_citoyen", "hiddenstatic");
            $form->setType("numero_version_clos", "hiddenstatic");
            $form->setType("commune", "selectstatic");
            $form->setType("adresse_normalisee", "hiddenstatic");
            $form->setType("adresse_normalisee_json", "hiddenstatic");
            $form->setType("numerotation_type", "hiddenstatic");
            $form->setType("numerotation_dep", "hiddenstatic");
            $form->setType("numerotation_com", "hiddenstatic");
            $form->setType("numerotation_division", "hiddenstatic");
            $form->setType("numerotation_num", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_autorisation", "static");
            $form->setType("dossier_autorisation_type_detaille", "selectstatic");
            $form->setType("exercice", "static");
            $form->setType("insee", "static");
            $form->setType("terrain_references_cadastrales", "textareastatic");
            $form->setType("terrain_adresse_voie_numero", "static");
            $form->setType("terrain_adresse_voie", "static");
            $form->setType("terrain_adresse_lieu_dit", "static");
            $form->setType("terrain_adresse_localite", "static");
            $form->setType("terrain_adresse_code_postal", "static");
            $form->setType("terrain_adresse_bp", "static");
            $form->setType("terrain_adresse_cedex", "static");
            $form->setType("terrain_superficie", "static");
            $form->setType("arrondissement", "selectstatic");
            $form->setType("depot_initial", "datestatic");
            $form->setType("erp_numero_batiment", "static");
            $form->setType("erp_ouvert", "checkboxstatic");
            $form->setType("erp_date_ouverture", "datestatic");
            $form->setType("erp_arrete_decision", "checkboxstatic");
            $form->setType("erp_date_arrete_decision", "datestatic");
            $form->setType("numero_version", "static");
            $form->setType("etat_dossier_autorisation", "selectstatic");
            $form->setType("date_depot", "datestatic");
            $form->setType("date_decision", "datestatic");
            $form->setType("date_validite", "datestatic");
            $form->setType("date_chantier", "datestatic");
            $form->setType("date_achevement", "datestatic");
            $form->setType("avis_decision", "selectstatic");
            $form->setType("etat_dernier_dossier_instruction_accepte", "selectstatic");
            $form->setType("dossier_autorisation_libelle", "static");
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
            $form->setType("cle_acces_citoyen", "static");
            $form->setType("numero_version_clos", "static");
            $form->setType("commune", "selectstatic");
            $form->setType("adresse_normalisee", "textareastatic");
            $form->setType("adresse_normalisee_json", "textareastatic");
            $form->setType("numerotation_type", "static");
            $form->setType("numerotation_dep", "static");
            $form->setType("numerotation_com", "static");
            $form->setType("numerotation_division", "static");
            $form->setType("numerotation_num", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_autorisation_type_detaille','VerifNum(this)');
        $form->setOnchange('exercice','VerifNum(this)');
        $form->setOnchange('terrain_superficie','VerifFloat(this)');
        $form->setOnchange('arrondissement','VerifNum(this)');
        $form->setOnchange('depot_initial','fdate(this)');
        $form->setOnchange('erp_numero_batiment','VerifNum(this)');
        $form->setOnchange('erp_date_ouverture','fdate(this)');
        $form->setOnchange('erp_date_arrete_decision','fdate(this)');
        $form->setOnchange('numero_version','VerifNum(this)');
        $form->setOnchange('etat_dossier_autorisation','VerifNum(this)');
        $form->setOnchange('date_depot','fdate(this)');
        $form->setOnchange('date_decision','fdate(this)');
        $form->setOnchange('date_validite','fdate(this)');
        $form->setOnchange('date_chantier','fdate(this)');
        $form->setOnchange('date_achevement','fdate(this)');
        $form->setOnchange('avis_decision','VerifNum(this)');
        $form->setOnchange('etat_dernier_dossier_instruction_accepte','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
        $form->setOnchange('numero_version_clos','VerifNum(this)');
        $form->setOnchange('commune','VerifNum(this)');
        $form->setOnchange('numerotation_num','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_autorisation", 30);
        $form->setTaille("dossier_autorisation_type_detaille", 11);
        $form->setTaille("exercice", 11);
        $form->setTaille("insee", 10);
        $form->setTaille("terrain_references_cadastrales", 80);
        $form->setTaille("terrain_adresse_voie_numero", 20);
        $form->setTaille("terrain_adresse_voie", 30);
        $form->setTaille("terrain_adresse_lieu_dit", 30);
        $form->setTaille("terrain_adresse_localite", 30);
        $form->setTaille("terrain_adresse_code_postal", 10);
        $form->setTaille("terrain_adresse_bp", 15);
        $form->setTaille("terrain_adresse_cedex", 15);
        $form->setTaille("terrain_superficie", 20);
        $form->setTaille("arrondissement", 11);
        $form->setTaille("depot_initial", 12);
        $form->setTaille("erp_numero_batiment", 11);
        $form->setTaille("erp_ouvert", 1);
        $form->setTaille("erp_date_ouverture", 12);
        $form->setTaille("erp_arrete_decision", 1);
        $form->setTaille("erp_date_arrete_decision", 12);
        $form->setTaille("numero_version", 11);
        $form->setTaille("etat_dossier_autorisation", 11);
        $form->setTaille("date_depot", 12);
        $form->setTaille("date_decision", 12);
        $form->setTaille("date_validite", 12);
        $form->setTaille("date_chantier", 12);
        $form->setTaille("date_achevement", 12);
        $form->setTaille("avis_decision", 11);
        $form->setTaille("etat_dernier_dossier_instruction_accepte", 11);
        $form->setTaille("dossier_autorisation_libelle", 30);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("cle_acces_citoyen", 20);
        $form->setTaille("numero_version_clos", 11);
        $form->setTaille("commune", 11);
        $form->setTaille("adresse_normalisee", 80);
        $form->setTaille("adresse_normalisee_json", 80);
        $form->setTaille("numerotation_type", 10);
        $form->setTaille("numerotation_dep", 10);
        $form->setTaille("numerotation_com", 10);
        $form->setTaille("numerotation_division", 10);
        $form->setTaille("numerotation_num", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_autorisation", 255);
        $form->setMax("dossier_autorisation_type_detaille", 11);
        $form->setMax("exercice", 11);
        $form->setMax("insee", 5);
        $form->setMax("terrain_references_cadastrales", 6);
        $form->setMax("terrain_adresse_voie_numero", 20);
        $form->setMax("terrain_adresse_voie", 300);
        $form->setMax("terrain_adresse_lieu_dit", 30);
        $form->setMax("terrain_adresse_localite", 45);
        $form->setMax("terrain_adresse_code_postal", 5);
        $form->setMax("terrain_adresse_bp", 15);
        $form->setMax("terrain_adresse_cedex", 15);
        $form->setMax("terrain_superficie", 20);
        $form->setMax("arrondissement", 11);
        $form->setMax("depot_initial", 12);
        $form->setMax("erp_numero_batiment", 11);
        $form->setMax("erp_ouvert", 1);
        $form->setMax("erp_date_ouverture", 12);
        $form->setMax("erp_arrete_decision", 1);
        $form->setMax("erp_date_arrete_decision", 12);
        $form->setMax("numero_version", 11);
        $form->setMax("etat_dossier_autorisation", 11);
        $form->setMax("date_depot", 12);
        $form->setMax("date_decision", 12);
        $form->setMax("date_validite", 12);
        $form->setMax("date_chantier", 12);
        $form->setMax("date_achevement", 12);
        $form->setMax("avis_decision", 11);
        $form->setMax("etat_dernier_dossier_instruction_accepte", 11);
        $form->setMax("dossier_autorisation_libelle", 255);
        $form->setMax("om_collectivite", 11);
        $form->setMax("cle_acces_citoyen", 20);
        $form->setMax("numero_version_clos", 11);
        $form->setMax("commune", 11);
        $form->setMax("adresse_normalisee", 6);
        $form->setMax("adresse_normalisee_json", 6);
        $form->setMax("numerotation_type", 3);
        $form->setMax("numerotation_dep", 3);
        $form->setMax("numerotation_com", 3);
        $form->setMax("numerotation_division", 2);
        $form->setMax("numerotation_num", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_autorisation', __('dossier_autorisation'));
        $form->setLib('dossier_autorisation_type_detaille', __('dossier_autorisation_type_detaille'));
        $form->setLib('exercice', __('exercice'));
        $form->setLib('insee', __('insee'));
        $form->setLib('terrain_references_cadastrales', __('terrain_references_cadastrales'));
        $form->setLib('terrain_adresse_voie_numero', __('terrain_adresse_voie_numero'));
        $form->setLib('terrain_adresse_voie', __('terrain_adresse_voie'));
        $form->setLib('terrain_adresse_lieu_dit', __('terrain_adresse_lieu_dit'));
        $form->setLib('terrain_adresse_localite', __('terrain_adresse_localite'));
        $form->setLib('terrain_adresse_code_postal', __('terrain_adresse_code_postal'));
        $form->setLib('terrain_adresse_bp', __('terrain_adresse_bp'));
        $form->setLib('terrain_adresse_cedex', __('terrain_adresse_cedex'));
        $form->setLib('terrain_superficie', __('terrain_superficie'));
        $form->setLib('arrondissement', __('arrondissement'));
        $form->setLib('depot_initial', __('depot_initial'));
        $form->setLib('erp_numero_batiment', __('erp_numero_batiment'));
        $form->setLib('erp_ouvert', __('erp_ouvert'));
        $form->setLib('erp_date_ouverture', __('erp_date_ouverture'));
        $form->setLib('erp_arrete_decision', __('erp_arrete_decision'));
        $form->setLib('erp_date_arrete_decision', __('erp_date_arrete_decision'));
        $form->setLib('numero_version', __('numero_version'));
        $form->setLib('etat_dossier_autorisation', __('etat_dossier_autorisation'));
        $form->setLib('date_depot', __('date_depot'));
        $form->setLib('date_decision', __('date_decision'));
        $form->setLib('date_validite', __('date_validite'));
        $form->setLib('date_chantier', __('date_chantier'));
        $form->setLib('date_achevement', __('date_achevement'));
        $form->setLib('avis_decision', __('avis_decision'));
        $form->setLib('etat_dernier_dossier_instruction_accepte', __('etat_dernier_dossier_instruction_accepte'));
        $form->setLib('dossier_autorisation_libelle', __('dossier_autorisation_libelle'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('cle_acces_citoyen', __('cle_acces_citoyen'));
        $form->setLib('numero_version_clos', __('numero_version_clos'));
        $form->setLib('commune', __('commune'));
        $form->setLib('adresse_normalisee', __('adresse_normalisee'));
        $form->setLib('adresse_normalisee_json', __('adresse_normalisee_json'));
        $form->setLib('numerotation_type', __('numerotation_type'));
        $form->setLib('numerotation_dep', __('numerotation_dep'));
        $form->setLib('numerotation_com', __('numerotation_com'));
        $form->setLib('numerotation_division', __('numerotation_division'));
        $form->setLib('numerotation_num', __('numerotation_num'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // arrondissement
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
        // dossier_autorisation_type_detaille
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
        // etat_dernier_dossier_instruction_accepte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "etat_dernier_dossier_instruction_accepte",
            $this->get_var_sql_forminc__sql("etat_dernier_dossier_instruction_accepte"),
            $this->get_var_sql_forminc__sql("etat_dernier_dossier_instruction_accepte_by_id"),
            false
        );
        // etat_dossier_autorisation
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "etat_dossier_autorisation",
            $this->get_var_sql_forminc__sql("etat_dossier_autorisation"),
            $this->get_var_sql_forminc__sql("etat_dossier_autorisation_by_id"),
            false
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
            if($this->is_in_context_of_foreign_key('arrondissement', $this->retourformulaire))
                $form->setVal('arrondissement', $idxformulaire);
            if($this->is_in_context_of_foreign_key('avis_decision', $this->retourformulaire))
                $form->setVal('avis_decision', $idxformulaire);
            if($this->is_in_context_of_foreign_key('commune', $this->retourformulaire))
                $form->setVal('commune', $idxformulaire);
            if($this->is_in_context_of_foreign_key('dossier_autorisation_type_detaille', $this->retourformulaire))
                $form->setVal('dossier_autorisation_type_detaille', $idxformulaire);
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
        }// fin validation
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('etat_dossier_autorisation', $this->retourformulaire))
                $form->setVal('etat_dernier_dossier_instruction_accepte', $idxformulaire);
            if($this->is_in_context_of_foreign_key('etat_dossier_autorisation', $this->retourformulaire))
                $form->setVal('etat_dossier_autorisation', $idxformulaire);
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
        $this->rechercheTable($this->f->db, "demande", "dossier_autorisation", $id);
        // Verification de la cle secondaire : donnees_techniques
        $this->rechercheTable($this->f->db, "donnees_techniques", "dossier_autorisation", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "dossier_autorisation", $id);
        // Verification de la cle secondaire : dossier_autorisation_parcelle
        $this->rechercheTable($this->f->db, "dossier_autorisation_parcelle", "dossier_autorisation", $id);
        // Verification de la cle secondaire : lien_dossier_autorisation_demandeur
        $this->rechercheTable($this->f->db, "lien_dossier_autorisation_demandeur", "dossier_autorisation", $id);
        // Verification de la cle secondaire : lot
        $this->rechercheTable($this->f->db, "lot", "dossier_autorisation", $id);
    }


}
