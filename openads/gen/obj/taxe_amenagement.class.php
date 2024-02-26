<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class taxe_amenagement_gen extends om_dbform {

    protected $_absolute_class_name = "taxe_amenagement";

    var $table = "taxe_amenagement";
    var $clePrimaire = "taxe_amenagement";
    var $typeCle = "N";
    var $required_field = array(
        "om_collectivite",
        "taxe_amenagement",
        "tx_comm_secteur_1",
        "tx_depart",
        "tx_rap",
        "val_forf_empl_hll",
        "val_forf_empl_tente_carav_rml",
        "val_forf_nb_eolienne",
        "val_forf_nb_parking_ext",
        "val_forf_surf_cstr",
        "val_forf_surf_pann_photo",
        "val_forf_surf_piscine"
    );
    var $unique_key = array(
      "om_collectivite",
    );
    var $foreign_keys_extended = array(
        "om_collectivite" => array("om_collectivite", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("om_collectivite");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "taxe_amenagement",
            "om_collectivite",
            "en_ile_de_france",
            "val_forf_surf_cstr",
            "val_forf_empl_tente_carav_rml",
            "val_forf_empl_hll",
            "val_forf_surf_piscine",
            "val_forf_nb_eolienne",
            "val_forf_surf_pann_photo",
            "val_forf_nb_parking_ext",
            "tx_depart",
            "tx_reg",
            "tx_comm_secteur_1",
            "tx_comm_secteur_2",
            "tx_comm_secteur_3",
            "tx_comm_secteur_4",
            "tx_comm_secteur_5",
            "tx_comm_secteur_6",
            "tx_comm_secteur_7",
            "tx_comm_secteur_8",
            "tx_comm_secteur_9",
            "tx_comm_secteur_10",
            "tx_comm_secteur_11",
            "tx_comm_secteur_12",
            "tx_comm_secteur_13",
            "tx_comm_secteur_14",
            "tx_comm_secteur_15",
            "tx_comm_secteur_16",
            "tx_comm_secteur_17",
            "tx_comm_secteur_18",
            "tx_comm_secteur_19",
            "tx_comm_secteur_20",
            "tx_exo_facul_1_reg",
            "tx_exo_facul_2_reg",
            "tx_exo_facul_3_reg",
            "tx_exo_facul_4_reg",
            "tx_exo_facul_5_reg",
            "tx_exo_facul_6_reg",
            "tx_exo_facul_7_reg",
            "tx_exo_facul_8_reg",
            "tx_exo_facul_9_reg",
            "tx_exo_facul_1_depart",
            "tx_exo_facul_2_depart",
            "tx_exo_facul_3_depart",
            "tx_exo_facul_4_depart",
            "tx_exo_facul_5_depart",
            "tx_exo_facul_6_depart",
            "tx_exo_facul_7_depart",
            "tx_exo_facul_8_depart",
            "tx_exo_facul_9_depart",
            "tx_exo_facul_1_comm",
            "tx_exo_facul_2_comm",
            "tx_exo_facul_3_comm",
            "tx_exo_facul_4_comm",
            "tx_exo_facul_5_comm",
            "tx_exo_facul_6_comm",
            "tx_exo_facul_7_comm",
            "tx_exo_facul_8_comm",
            "tx_exo_facul_9_comm",
            "tx_rap",
        );
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
        if (!is_numeric($val['taxe_amenagement'])) {
            $this->valF['taxe_amenagement'] = ""; // -> requis
        } else {
            $this->valF['taxe_amenagement'] = $val['taxe_amenagement'];
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
        if ($val['en_ile_de_france'] == 1 || $val['en_ile_de_france'] == "t" || $val['en_ile_de_france'] == "Oui") {
            $this->valF['en_ile_de_france'] = true;
        } else {
            $this->valF['en_ile_de_france'] = false;
        }
        if (!is_numeric($val['val_forf_surf_cstr'])) {
            $this->valF['val_forf_surf_cstr'] = ""; // -> requis
        } else {
            $this->valF['val_forf_surf_cstr'] = $val['val_forf_surf_cstr'];
        }
        if (!is_numeric($val['val_forf_empl_tente_carav_rml'])) {
            $this->valF['val_forf_empl_tente_carav_rml'] = ""; // -> requis
        } else {
            $this->valF['val_forf_empl_tente_carav_rml'] = $val['val_forf_empl_tente_carav_rml'];
        }
        if (!is_numeric($val['val_forf_empl_hll'])) {
            $this->valF['val_forf_empl_hll'] = ""; // -> requis
        } else {
            $this->valF['val_forf_empl_hll'] = $val['val_forf_empl_hll'];
        }
        if (!is_numeric($val['val_forf_surf_piscine'])) {
            $this->valF['val_forf_surf_piscine'] = ""; // -> requis
        } else {
            $this->valF['val_forf_surf_piscine'] = $val['val_forf_surf_piscine'];
        }
        if (!is_numeric($val['val_forf_nb_eolienne'])) {
            $this->valF['val_forf_nb_eolienne'] = ""; // -> requis
        } else {
            $this->valF['val_forf_nb_eolienne'] = $val['val_forf_nb_eolienne'];
        }
        if (!is_numeric($val['val_forf_surf_pann_photo'])) {
            $this->valF['val_forf_surf_pann_photo'] = ""; // -> requis
        } else {
            $this->valF['val_forf_surf_pann_photo'] = $val['val_forf_surf_pann_photo'];
        }
        if (!is_numeric($val['val_forf_nb_parking_ext'])) {
            $this->valF['val_forf_nb_parking_ext'] = ""; // -> requis
        } else {
            $this->valF['val_forf_nb_parking_ext'] = $val['val_forf_nb_parking_ext'];
        }
        if (!is_numeric($val['tx_depart'])) {
            $this->valF['tx_depart'] = ""; // -> requis
        } else {
            $this->valF['tx_depart'] = $val['tx_depart'];
        }
        if (!is_numeric($val['tx_reg'])) {
            $this->valF['tx_reg'] = NULL;
        } else {
            $this->valF['tx_reg'] = $val['tx_reg'];
        }
        if (!is_numeric($val['tx_comm_secteur_1'])) {
            $this->valF['tx_comm_secteur_1'] = ""; // -> requis
        } else {
            $this->valF['tx_comm_secteur_1'] = $val['tx_comm_secteur_1'];
        }
        if (!is_numeric($val['tx_comm_secteur_2'])) {
            $this->valF['tx_comm_secteur_2'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_2'] = $val['tx_comm_secteur_2'];
        }
        if (!is_numeric($val['tx_comm_secteur_3'])) {
            $this->valF['tx_comm_secteur_3'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_3'] = $val['tx_comm_secteur_3'];
        }
        if (!is_numeric($val['tx_comm_secteur_4'])) {
            $this->valF['tx_comm_secteur_4'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_4'] = $val['tx_comm_secteur_4'];
        }
        if (!is_numeric($val['tx_comm_secteur_5'])) {
            $this->valF['tx_comm_secteur_5'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_5'] = $val['tx_comm_secteur_5'];
        }
        if (!is_numeric($val['tx_comm_secteur_6'])) {
            $this->valF['tx_comm_secteur_6'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_6'] = $val['tx_comm_secteur_6'];
        }
        if (!is_numeric($val['tx_comm_secteur_7'])) {
            $this->valF['tx_comm_secteur_7'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_7'] = $val['tx_comm_secteur_7'];
        }
        if (!is_numeric($val['tx_comm_secteur_8'])) {
            $this->valF['tx_comm_secteur_8'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_8'] = $val['tx_comm_secteur_8'];
        }
        if (!is_numeric($val['tx_comm_secteur_9'])) {
            $this->valF['tx_comm_secteur_9'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_9'] = $val['tx_comm_secteur_9'];
        }
        if (!is_numeric($val['tx_comm_secteur_10'])) {
            $this->valF['tx_comm_secteur_10'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_10'] = $val['tx_comm_secteur_10'];
        }
        if (!is_numeric($val['tx_comm_secteur_11'])) {
            $this->valF['tx_comm_secteur_11'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_11'] = $val['tx_comm_secteur_11'];
        }
        if (!is_numeric($val['tx_comm_secteur_12'])) {
            $this->valF['tx_comm_secteur_12'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_12'] = $val['tx_comm_secteur_12'];
        }
        if (!is_numeric($val['tx_comm_secteur_13'])) {
            $this->valF['tx_comm_secteur_13'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_13'] = $val['tx_comm_secteur_13'];
        }
        if (!is_numeric($val['tx_comm_secteur_14'])) {
            $this->valF['tx_comm_secteur_14'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_14'] = $val['tx_comm_secteur_14'];
        }
        if (!is_numeric($val['tx_comm_secteur_15'])) {
            $this->valF['tx_comm_secteur_15'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_15'] = $val['tx_comm_secteur_15'];
        }
        if (!is_numeric($val['tx_comm_secteur_16'])) {
            $this->valF['tx_comm_secteur_16'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_16'] = $val['tx_comm_secteur_16'];
        }
        if (!is_numeric($val['tx_comm_secteur_17'])) {
            $this->valF['tx_comm_secteur_17'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_17'] = $val['tx_comm_secteur_17'];
        }
        if (!is_numeric($val['tx_comm_secteur_18'])) {
            $this->valF['tx_comm_secteur_18'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_18'] = $val['tx_comm_secteur_18'];
        }
        if (!is_numeric($val['tx_comm_secteur_19'])) {
            $this->valF['tx_comm_secteur_19'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_19'] = $val['tx_comm_secteur_19'];
        }
        if (!is_numeric($val['tx_comm_secteur_20'])) {
            $this->valF['tx_comm_secteur_20'] = NULL;
        } else {
            $this->valF['tx_comm_secteur_20'] = $val['tx_comm_secteur_20'];
        }
        if (!is_numeric($val['tx_exo_facul_1_reg'])) {
            $this->valF['tx_exo_facul_1_reg'] = NULL;
        } else {
            $this->valF['tx_exo_facul_1_reg'] = $val['tx_exo_facul_1_reg'];
        }
        if (!is_numeric($val['tx_exo_facul_2_reg'])) {
            $this->valF['tx_exo_facul_2_reg'] = NULL;
        } else {
            $this->valF['tx_exo_facul_2_reg'] = $val['tx_exo_facul_2_reg'];
        }
        if (!is_numeric($val['tx_exo_facul_3_reg'])) {
            $this->valF['tx_exo_facul_3_reg'] = NULL;
        } else {
            $this->valF['tx_exo_facul_3_reg'] = $val['tx_exo_facul_3_reg'];
        }
        if (!is_numeric($val['tx_exo_facul_4_reg'])) {
            $this->valF['tx_exo_facul_4_reg'] = NULL;
        } else {
            $this->valF['tx_exo_facul_4_reg'] = $val['tx_exo_facul_4_reg'];
        }
        if (!is_numeric($val['tx_exo_facul_5_reg'])) {
            $this->valF['tx_exo_facul_5_reg'] = NULL;
        } else {
            $this->valF['tx_exo_facul_5_reg'] = $val['tx_exo_facul_5_reg'];
        }
        if (!is_numeric($val['tx_exo_facul_6_reg'])) {
            $this->valF['tx_exo_facul_6_reg'] = NULL;
        } else {
            $this->valF['tx_exo_facul_6_reg'] = $val['tx_exo_facul_6_reg'];
        }
        if (!is_numeric($val['tx_exo_facul_7_reg'])) {
            $this->valF['tx_exo_facul_7_reg'] = NULL;
        } else {
            $this->valF['tx_exo_facul_7_reg'] = $val['tx_exo_facul_7_reg'];
        }
        if (!is_numeric($val['tx_exo_facul_8_reg'])) {
            $this->valF['tx_exo_facul_8_reg'] = NULL;
        } else {
            $this->valF['tx_exo_facul_8_reg'] = $val['tx_exo_facul_8_reg'];
        }
        if (!is_numeric($val['tx_exo_facul_9_reg'])) {
            $this->valF['tx_exo_facul_9_reg'] = NULL;
        } else {
            $this->valF['tx_exo_facul_9_reg'] = $val['tx_exo_facul_9_reg'];
        }
        if (!is_numeric($val['tx_exo_facul_1_depart'])) {
            $this->valF['tx_exo_facul_1_depart'] = NULL;
        } else {
            $this->valF['tx_exo_facul_1_depart'] = $val['tx_exo_facul_1_depart'];
        }
        if (!is_numeric($val['tx_exo_facul_2_depart'])) {
            $this->valF['tx_exo_facul_2_depart'] = NULL;
        } else {
            $this->valF['tx_exo_facul_2_depart'] = $val['tx_exo_facul_2_depart'];
        }
        if (!is_numeric($val['tx_exo_facul_3_depart'])) {
            $this->valF['tx_exo_facul_3_depart'] = NULL;
        } else {
            $this->valF['tx_exo_facul_3_depart'] = $val['tx_exo_facul_3_depart'];
        }
        if (!is_numeric($val['tx_exo_facul_4_depart'])) {
            $this->valF['tx_exo_facul_4_depart'] = NULL;
        } else {
            $this->valF['tx_exo_facul_4_depart'] = $val['tx_exo_facul_4_depart'];
        }
        if (!is_numeric($val['tx_exo_facul_5_depart'])) {
            $this->valF['tx_exo_facul_5_depart'] = NULL;
        } else {
            $this->valF['tx_exo_facul_5_depart'] = $val['tx_exo_facul_5_depart'];
        }
        if (!is_numeric($val['tx_exo_facul_6_depart'])) {
            $this->valF['tx_exo_facul_6_depart'] = NULL;
        } else {
            $this->valF['tx_exo_facul_6_depart'] = $val['tx_exo_facul_6_depart'];
        }
        if (!is_numeric($val['tx_exo_facul_7_depart'])) {
            $this->valF['tx_exo_facul_7_depart'] = NULL;
        } else {
            $this->valF['tx_exo_facul_7_depart'] = $val['tx_exo_facul_7_depart'];
        }
        if (!is_numeric($val['tx_exo_facul_8_depart'])) {
            $this->valF['tx_exo_facul_8_depart'] = NULL;
        } else {
            $this->valF['tx_exo_facul_8_depart'] = $val['tx_exo_facul_8_depart'];
        }
        if (!is_numeric($val['tx_exo_facul_9_depart'])) {
            $this->valF['tx_exo_facul_9_depart'] = NULL;
        } else {
            $this->valF['tx_exo_facul_9_depart'] = $val['tx_exo_facul_9_depart'];
        }
        if (!is_numeric($val['tx_exo_facul_1_comm'])) {
            $this->valF['tx_exo_facul_1_comm'] = NULL;
        } else {
            $this->valF['tx_exo_facul_1_comm'] = $val['tx_exo_facul_1_comm'];
        }
        if (!is_numeric($val['tx_exo_facul_2_comm'])) {
            $this->valF['tx_exo_facul_2_comm'] = NULL;
        } else {
            $this->valF['tx_exo_facul_2_comm'] = $val['tx_exo_facul_2_comm'];
        }
        if (!is_numeric($val['tx_exo_facul_3_comm'])) {
            $this->valF['tx_exo_facul_3_comm'] = NULL;
        } else {
            $this->valF['tx_exo_facul_3_comm'] = $val['tx_exo_facul_3_comm'];
        }
        if (!is_numeric($val['tx_exo_facul_4_comm'])) {
            $this->valF['tx_exo_facul_4_comm'] = NULL;
        } else {
            $this->valF['tx_exo_facul_4_comm'] = $val['tx_exo_facul_4_comm'];
        }
        if (!is_numeric($val['tx_exo_facul_5_comm'])) {
            $this->valF['tx_exo_facul_5_comm'] = NULL;
        } else {
            $this->valF['tx_exo_facul_5_comm'] = $val['tx_exo_facul_5_comm'];
        }
        if (!is_numeric($val['tx_exo_facul_6_comm'])) {
            $this->valF['tx_exo_facul_6_comm'] = NULL;
        } else {
            $this->valF['tx_exo_facul_6_comm'] = $val['tx_exo_facul_6_comm'];
        }
        if (!is_numeric($val['tx_exo_facul_7_comm'])) {
            $this->valF['tx_exo_facul_7_comm'] = NULL;
        } else {
            $this->valF['tx_exo_facul_7_comm'] = $val['tx_exo_facul_7_comm'];
        }
        if (!is_numeric($val['tx_exo_facul_8_comm'])) {
            $this->valF['tx_exo_facul_8_comm'] = NULL;
        } else {
            $this->valF['tx_exo_facul_8_comm'] = $val['tx_exo_facul_8_comm'];
        }
        if (!is_numeric($val['tx_exo_facul_9_comm'])) {
            $this->valF['tx_exo_facul_9_comm'] = NULL;
        } else {
            $this->valF['tx_exo_facul_9_comm'] = $val['tx_exo_facul_9_comm'];
        }
        if (!is_numeric($val['tx_rap'])) {
            $this->valF['tx_rap'] = ""; // -> requis
        } else {
            $this->valF['tx_rap'] = $val['tx_rap'];
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
            $form->setType("taxe_amenagement", "hidden");
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
            $form->setType("en_ile_de_france", "checkbox");
            $form->setType("val_forf_surf_cstr", "text");
            $form->setType("val_forf_empl_tente_carav_rml", "text");
            $form->setType("val_forf_empl_hll", "text");
            $form->setType("val_forf_surf_piscine", "text");
            $form->setType("val_forf_nb_eolienne", "text");
            $form->setType("val_forf_surf_pann_photo", "text");
            $form->setType("val_forf_nb_parking_ext", "text");
            $form->setType("tx_depart", "text");
            $form->setType("tx_reg", "text");
            $form->setType("tx_comm_secteur_1", "text");
            $form->setType("tx_comm_secteur_2", "text");
            $form->setType("tx_comm_secteur_3", "text");
            $form->setType("tx_comm_secteur_4", "text");
            $form->setType("tx_comm_secteur_5", "text");
            $form->setType("tx_comm_secteur_6", "text");
            $form->setType("tx_comm_secteur_7", "text");
            $form->setType("tx_comm_secteur_8", "text");
            $form->setType("tx_comm_secteur_9", "text");
            $form->setType("tx_comm_secteur_10", "text");
            $form->setType("tx_comm_secteur_11", "text");
            $form->setType("tx_comm_secteur_12", "text");
            $form->setType("tx_comm_secteur_13", "text");
            $form->setType("tx_comm_secteur_14", "text");
            $form->setType("tx_comm_secteur_15", "text");
            $form->setType("tx_comm_secteur_16", "text");
            $form->setType("tx_comm_secteur_17", "text");
            $form->setType("tx_comm_secteur_18", "text");
            $form->setType("tx_comm_secteur_19", "text");
            $form->setType("tx_comm_secteur_20", "text");
            $form->setType("tx_exo_facul_1_reg", "text");
            $form->setType("tx_exo_facul_2_reg", "text");
            $form->setType("tx_exo_facul_3_reg", "text");
            $form->setType("tx_exo_facul_4_reg", "text");
            $form->setType("tx_exo_facul_5_reg", "text");
            $form->setType("tx_exo_facul_6_reg", "text");
            $form->setType("tx_exo_facul_7_reg", "text");
            $form->setType("tx_exo_facul_8_reg", "text");
            $form->setType("tx_exo_facul_9_reg", "text");
            $form->setType("tx_exo_facul_1_depart", "text");
            $form->setType("tx_exo_facul_2_depart", "text");
            $form->setType("tx_exo_facul_3_depart", "text");
            $form->setType("tx_exo_facul_4_depart", "text");
            $form->setType("tx_exo_facul_5_depart", "text");
            $form->setType("tx_exo_facul_6_depart", "text");
            $form->setType("tx_exo_facul_7_depart", "text");
            $form->setType("tx_exo_facul_8_depart", "text");
            $form->setType("tx_exo_facul_9_depart", "text");
            $form->setType("tx_exo_facul_1_comm", "text");
            $form->setType("tx_exo_facul_2_comm", "text");
            $form->setType("tx_exo_facul_3_comm", "text");
            $form->setType("tx_exo_facul_4_comm", "text");
            $form->setType("tx_exo_facul_5_comm", "text");
            $form->setType("tx_exo_facul_6_comm", "text");
            $form->setType("tx_exo_facul_7_comm", "text");
            $form->setType("tx_exo_facul_8_comm", "text");
            $form->setType("tx_exo_facul_9_comm", "text");
            $form->setType("tx_rap", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("taxe_amenagement", "hiddenstatic");
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
            $form->setType("en_ile_de_france", "checkbox");
            $form->setType("val_forf_surf_cstr", "text");
            $form->setType("val_forf_empl_tente_carav_rml", "text");
            $form->setType("val_forf_empl_hll", "text");
            $form->setType("val_forf_surf_piscine", "text");
            $form->setType("val_forf_nb_eolienne", "text");
            $form->setType("val_forf_surf_pann_photo", "text");
            $form->setType("val_forf_nb_parking_ext", "text");
            $form->setType("tx_depart", "text");
            $form->setType("tx_reg", "text");
            $form->setType("tx_comm_secteur_1", "text");
            $form->setType("tx_comm_secteur_2", "text");
            $form->setType("tx_comm_secteur_3", "text");
            $form->setType("tx_comm_secteur_4", "text");
            $form->setType("tx_comm_secteur_5", "text");
            $form->setType("tx_comm_secteur_6", "text");
            $form->setType("tx_comm_secteur_7", "text");
            $form->setType("tx_comm_secteur_8", "text");
            $form->setType("tx_comm_secteur_9", "text");
            $form->setType("tx_comm_secteur_10", "text");
            $form->setType("tx_comm_secteur_11", "text");
            $form->setType("tx_comm_secteur_12", "text");
            $form->setType("tx_comm_secteur_13", "text");
            $form->setType("tx_comm_secteur_14", "text");
            $form->setType("tx_comm_secteur_15", "text");
            $form->setType("tx_comm_secteur_16", "text");
            $form->setType("tx_comm_secteur_17", "text");
            $form->setType("tx_comm_secteur_18", "text");
            $form->setType("tx_comm_secteur_19", "text");
            $form->setType("tx_comm_secteur_20", "text");
            $form->setType("tx_exo_facul_1_reg", "text");
            $form->setType("tx_exo_facul_2_reg", "text");
            $form->setType("tx_exo_facul_3_reg", "text");
            $form->setType("tx_exo_facul_4_reg", "text");
            $form->setType("tx_exo_facul_5_reg", "text");
            $form->setType("tx_exo_facul_6_reg", "text");
            $form->setType("tx_exo_facul_7_reg", "text");
            $form->setType("tx_exo_facul_8_reg", "text");
            $form->setType("tx_exo_facul_9_reg", "text");
            $form->setType("tx_exo_facul_1_depart", "text");
            $form->setType("tx_exo_facul_2_depart", "text");
            $form->setType("tx_exo_facul_3_depart", "text");
            $form->setType("tx_exo_facul_4_depart", "text");
            $form->setType("tx_exo_facul_5_depart", "text");
            $form->setType("tx_exo_facul_6_depart", "text");
            $form->setType("tx_exo_facul_7_depart", "text");
            $form->setType("tx_exo_facul_8_depart", "text");
            $form->setType("tx_exo_facul_9_depart", "text");
            $form->setType("tx_exo_facul_1_comm", "text");
            $form->setType("tx_exo_facul_2_comm", "text");
            $form->setType("tx_exo_facul_3_comm", "text");
            $form->setType("tx_exo_facul_4_comm", "text");
            $form->setType("tx_exo_facul_5_comm", "text");
            $form->setType("tx_exo_facul_6_comm", "text");
            $form->setType("tx_exo_facul_7_comm", "text");
            $form->setType("tx_exo_facul_8_comm", "text");
            $form->setType("tx_exo_facul_9_comm", "text");
            $form->setType("tx_rap", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("taxe_amenagement", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("en_ile_de_france", "hiddenstatic");
            $form->setType("val_forf_surf_cstr", "hiddenstatic");
            $form->setType("val_forf_empl_tente_carav_rml", "hiddenstatic");
            $form->setType("val_forf_empl_hll", "hiddenstatic");
            $form->setType("val_forf_surf_piscine", "hiddenstatic");
            $form->setType("val_forf_nb_eolienne", "hiddenstatic");
            $form->setType("val_forf_surf_pann_photo", "hiddenstatic");
            $form->setType("val_forf_nb_parking_ext", "hiddenstatic");
            $form->setType("tx_depart", "hiddenstatic");
            $form->setType("tx_reg", "hiddenstatic");
            $form->setType("tx_comm_secteur_1", "hiddenstatic");
            $form->setType("tx_comm_secteur_2", "hiddenstatic");
            $form->setType("tx_comm_secteur_3", "hiddenstatic");
            $form->setType("tx_comm_secteur_4", "hiddenstatic");
            $form->setType("tx_comm_secteur_5", "hiddenstatic");
            $form->setType("tx_comm_secteur_6", "hiddenstatic");
            $form->setType("tx_comm_secteur_7", "hiddenstatic");
            $form->setType("tx_comm_secteur_8", "hiddenstatic");
            $form->setType("tx_comm_secteur_9", "hiddenstatic");
            $form->setType("tx_comm_secteur_10", "hiddenstatic");
            $form->setType("tx_comm_secteur_11", "hiddenstatic");
            $form->setType("tx_comm_secteur_12", "hiddenstatic");
            $form->setType("tx_comm_secteur_13", "hiddenstatic");
            $form->setType("tx_comm_secteur_14", "hiddenstatic");
            $form->setType("tx_comm_secteur_15", "hiddenstatic");
            $form->setType("tx_comm_secteur_16", "hiddenstatic");
            $form->setType("tx_comm_secteur_17", "hiddenstatic");
            $form->setType("tx_comm_secteur_18", "hiddenstatic");
            $form->setType("tx_comm_secteur_19", "hiddenstatic");
            $form->setType("tx_comm_secteur_20", "hiddenstatic");
            $form->setType("tx_exo_facul_1_reg", "hiddenstatic");
            $form->setType("tx_exo_facul_2_reg", "hiddenstatic");
            $form->setType("tx_exo_facul_3_reg", "hiddenstatic");
            $form->setType("tx_exo_facul_4_reg", "hiddenstatic");
            $form->setType("tx_exo_facul_5_reg", "hiddenstatic");
            $form->setType("tx_exo_facul_6_reg", "hiddenstatic");
            $form->setType("tx_exo_facul_7_reg", "hiddenstatic");
            $form->setType("tx_exo_facul_8_reg", "hiddenstatic");
            $form->setType("tx_exo_facul_9_reg", "hiddenstatic");
            $form->setType("tx_exo_facul_1_depart", "hiddenstatic");
            $form->setType("tx_exo_facul_2_depart", "hiddenstatic");
            $form->setType("tx_exo_facul_3_depart", "hiddenstatic");
            $form->setType("tx_exo_facul_4_depart", "hiddenstatic");
            $form->setType("tx_exo_facul_5_depart", "hiddenstatic");
            $form->setType("tx_exo_facul_6_depart", "hiddenstatic");
            $form->setType("tx_exo_facul_7_depart", "hiddenstatic");
            $form->setType("tx_exo_facul_8_depart", "hiddenstatic");
            $form->setType("tx_exo_facul_9_depart", "hiddenstatic");
            $form->setType("tx_exo_facul_1_comm", "hiddenstatic");
            $form->setType("tx_exo_facul_2_comm", "hiddenstatic");
            $form->setType("tx_exo_facul_3_comm", "hiddenstatic");
            $form->setType("tx_exo_facul_4_comm", "hiddenstatic");
            $form->setType("tx_exo_facul_5_comm", "hiddenstatic");
            $form->setType("tx_exo_facul_6_comm", "hiddenstatic");
            $form->setType("tx_exo_facul_7_comm", "hiddenstatic");
            $form->setType("tx_exo_facul_8_comm", "hiddenstatic");
            $form->setType("tx_exo_facul_9_comm", "hiddenstatic");
            $form->setType("tx_rap", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("taxe_amenagement", "static");
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
            $form->setType("en_ile_de_france", "checkboxstatic");
            $form->setType("val_forf_surf_cstr", "static");
            $form->setType("val_forf_empl_tente_carav_rml", "static");
            $form->setType("val_forf_empl_hll", "static");
            $form->setType("val_forf_surf_piscine", "static");
            $form->setType("val_forf_nb_eolienne", "static");
            $form->setType("val_forf_surf_pann_photo", "static");
            $form->setType("val_forf_nb_parking_ext", "static");
            $form->setType("tx_depart", "static");
            $form->setType("tx_reg", "static");
            $form->setType("tx_comm_secteur_1", "static");
            $form->setType("tx_comm_secteur_2", "static");
            $form->setType("tx_comm_secteur_3", "static");
            $form->setType("tx_comm_secteur_4", "static");
            $form->setType("tx_comm_secteur_5", "static");
            $form->setType("tx_comm_secteur_6", "static");
            $form->setType("tx_comm_secteur_7", "static");
            $form->setType("tx_comm_secteur_8", "static");
            $form->setType("tx_comm_secteur_9", "static");
            $form->setType("tx_comm_secteur_10", "static");
            $form->setType("tx_comm_secteur_11", "static");
            $form->setType("tx_comm_secteur_12", "static");
            $form->setType("tx_comm_secteur_13", "static");
            $form->setType("tx_comm_secteur_14", "static");
            $form->setType("tx_comm_secteur_15", "static");
            $form->setType("tx_comm_secteur_16", "static");
            $form->setType("tx_comm_secteur_17", "static");
            $form->setType("tx_comm_secteur_18", "static");
            $form->setType("tx_comm_secteur_19", "static");
            $form->setType("tx_comm_secteur_20", "static");
            $form->setType("tx_exo_facul_1_reg", "static");
            $form->setType("tx_exo_facul_2_reg", "static");
            $form->setType("tx_exo_facul_3_reg", "static");
            $form->setType("tx_exo_facul_4_reg", "static");
            $form->setType("tx_exo_facul_5_reg", "static");
            $form->setType("tx_exo_facul_6_reg", "static");
            $form->setType("tx_exo_facul_7_reg", "static");
            $form->setType("tx_exo_facul_8_reg", "static");
            $form->setType("tx_exo_facul_9_reg", "static");
            $form->setType("tx_exo_facul_1_depart", "static");
            $form->setType("tx_exo_facul_2_depart", "static");
            $form->setType("tx_exo_facul_3_depart", "static");
            $form->setType("tx_exo_facul_4_depart", "static");
            $form->setType("tx_exo_facul_5_depart", "static");
            $form->setType("tx_exo_facul_6_depart", "static");
            $form->setType("tx_exo_facul_7_depart", "static");
            $form->setType("tx_exo_facul_8_depart", "static");
            $form->setType("tx_exo_facul_9_depart", "static");
            $form->setType("tx_exo_facul_1_comm", "static");
            $form->setType("tx_exo_facul_2_comm", "static");
            $form->setType("tx_exo_facul_3_comm", "static");
            $form->setType("tx_exo_facul_4_comm", "static");
            $form->setType("tx_exo_facul_5_comm", "static");
            $form->setType("tx_exo_facul_6_comm", "static");
            $form->setType("tx_exo_facul_7_comm", "static");
            $form->setType("tx_exo_facul_8_comm", "static");
            $form->setType("tx_exo_facul_9_comm", "static");
            $form->setType("tx_rap", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('taxe_amenagement','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
        $form->setOnchange('val_forf_surf_cstr','VerifNum(this)');
        $form->setOnchange('val_forf_empl_tente_carav_rml','VerifNum(this)');
        $form->setOnchange('val_forf_empl_hll','VerifNum(this)');
        $form->setOnchange('val_forf_surf_piscine','VerifNum(this)');
        $form->setOnchange('val_forf_nb_eolienne','VerifNum(this)');
        $form->setOnchange('val_forf_surf_pann_photo','VerifNum(this)');
        $form->setOnchange('val_forf_nb_parking_ext','VerifNum(this)');
        $form->setOnchange('tx_depart','VerifFloat(this)');
        $form->setOnchange('tx_reg','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_1','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_2','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_3','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_4','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_5','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_6','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_7','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_8','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_9','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_10','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_11','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_12','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_13','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_14','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_15','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_16','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_17','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_18','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_19','VerifFloat(this)');
        $form->setOnchange('tx_comm_secteur_20','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_1_reg','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_2_reg','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_3_reg','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_4_reg','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_5_reg','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_6_reg','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_7_reg','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_8_reg','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_9_reg','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_1_depart','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_2_depart','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_3_depart','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_4_depart','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_5_depart','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_6_depart','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_7_depart','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_8_depart','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_9_depart','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_1_comm','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_2_comm','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_3_comm','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_4_comm','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_5_comm','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_6_comm','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_7_comm','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_8_comm','VerifFloat(this)');
        $form->setOnchange('tx_exo_facul_9_comm','VerifFloat(this)');
        $form->setOnchange('tx_rap','VerifFloat(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("taxe_amenagement", 11);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("en_ile_de_france", 1);
        $form->setTaille("val_forf_surf_cstr", 11);
        $form->setTaille("val_forf_empl_tente_carav_rml", 11);
        $form->setTaille("val_forf_empl_hll", 11);
        $form->setTaille("val_forf_surf_piscine", 11);
        $form->setTaille("val_forf_nb_eolienne", 11);
        $form->setTaille("val_forf_surf_pann_photo", 11);
        $form->setTaille("val_forf_nb_parking_ext", 11);
        $form->setTaille("tx_depart", 10);
        $form->setTaille("tx_reg", 10);
        $form->setTaille("tx_comm_secteur_1", 10);
        $form->setTaille("tx_comm_secteur_2", 10);
        $form->setTaille("tx_comm_secteur_3", 10);
        $form->setTaille("tx_comm_secteur_4", 10);
        $form->setTaille("tx_comm_secteur_5", 10);
        $form->setTaille("tx_comm_secteur_6", 10);
        $form->setTaille("tx_comm_secteur_7", 10);
        $form->setTaille("tx_comm_secteur_8", 10);
        $form->setTaille("tx_comm_secteur_9", 10);
        $form->setTaille("tx_comm_secteur_10", 10);
        $form->setTaille("tx_comm_secteur_11", 10);
        $form->setTaille("tx_comm_secteur_12", 10);
        $form->setTaille("tx_comm_secteur_13", 10);
        $form->setTaille("tx_comm_secteur_14", 10);
        $form->setTaille("tx_comm_secteur_15", 10);
        $form->setTaille("tx_comm_secteur_16", 10);
        $form->setTaille("tx_comm_secteur_17", 10);
        $form->setTaille("tx_comm_secteur_18", 10);
        $form->setTaille("tx_comm_secteur_19", 10);
        $form->setTaille("tx_comm_secteur_20", 10);
        $form->setTaille("tx_exo_facul_1_reg", 10);
        $form->setTaille("tx_exo_facul_2_reg", 10);
        $form->setTaille("tx_exo_facul_3_reg", 10);
        $form->setTaille("tx_exo_facul_4_reg", 10);
        $form->setTaille("tx_exo_facul_5_reg", 10);
        $form->setTaille("tx_exo_facul_6_reg", 10);
        $form->setTaille("tx_exo_facul_7_reg", 10);
        $form->setTaille("tx_exo_facul_8_reg", 10);
        $form->setTaille("tx_exo_facul_9_reg", 10);
        $form->setTaille("tx_exo_facul_1_depart", 10);
        $form->setTaille("tx_exo_facul_2_depart", 10);
        $form->setTaille("tx_exo_facul_3_depart", 10);
        $form->setTaille("tx_exo_facul_4_depart", 10);
        $form->setTaille("tx_exo_facul_5_depart", 10);
        $form->setTaille("tx_exo_facul_6_depart", 10);
        $form->setTaille("tx_exo_facul_7_depart", 10);
        $form->setTaille("tx_exo_facul_8_depart", 10);
        $form->setTaille("tx_exo_facul_9_depart", 10);
        $form->setTaille("tx_exo_facul_1_comm", 10);
        $form->setTaille("tx_exo_facul_2_comm", 10);
        $form->setTaille("tx_exo_facul_3_comm", 10);
        $form->setTaille("tx_exo_facul_4_comm", 10);
        $form->setTaille("tx_exo_facul_5_comm", 10);
        $form->setTaille("tx_exo_facul_6_comm", 10);
        $form->setTaille("tx_exo_facul_7_comm", 10);
        $form->setTaille("tx_exo_facul_8_comm", 10);
        $form->setTaille("tx_exo_facul_9_comm", 10);
        $form->setTaille("tx_rap", 10);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("taxe_amenagement", 11);
        $form->setMax("om_collectivite", 11);
        $form->setMax("en_ile_de_france", 1);
        $form->setMax("val_forf_surf_cstr", 11);
        $form->setMax("val_forf_empl_tente_carav_rml", 11);
        $form->setMax("val_forf_empl_hll", 11);
        $form->setMax("val_forf_surf_piscine", 11);
        $form->setMax("val_forf_nb_eolienne", 11);
        $form->setMax("val_forf_surf_pann_photo", 11);
        $form->setMax("val_forf_nb_parking_ext", 11);
        $form->setMax("tx_depart", -5);
        $form->setMax("tx_reg", -5);
        $form->setMax("tx_comm_secteur_1", -5);
        $form->setMax("tx_comm_secteur_2", -5);
        $form->setMax("tx_comm_secteur_3", -5);
        $form->setMax("tx_comm_secteur_4", -5);
        $form->setMax("tx_comm_secteur_5", -5);
        $form->setMax("tx_comm_secteur_6", -5);
        $form->setMax("tx_comm_secteur_7", -5);
        $form->setMax("tx_comm_secteur_8", -5);
        $form->setMax("tx_comm_secteur_9", -5);
        $form->setMax("tx_comm_secteur_10", -5);
        $form->setMax("tx_comm_secteur_11", -5);
        $form->setMax("tx_comm_secteur_12", -5);
        $form->setMax("tx_comm_secteur_13", -5);
        $form->setMax("tx_comm_secteur_14", -5);
        $form->setMax("tx_comm_secteur_15", -5);
        $form->setMax("tx_comm_secteur_16", -5);
        $form->setMax("tx_comm_secteur_17", -5);
        $form->setMax("tx_comm_secteur_18", -5);
        $form->setMax("tx_comm_secteur_19", -5);
        $form->setMax("tx_comm_secteur_20", -5);
        $form->setMax("tx_exo_facul_1_reg", -5);
        $form->setMax("tx_exo_facul_2_reg", -5);
        $form->setMax("tx_exo_facul_3_reg", -5);
        $form->setMax("tx_exo_facul_4_reg", -5);
        $form->setMax("tx_exo_facul_5_reg", -5);
        $form->setMax("tx_exo_facul_6_reg", -5);
        $form->setMax("tx_exo_facul_7_reg", -5);
        $form->setMax("tx_exo_facul_8_reg", -5);
        $form->setMax("tx_exo_facul_9_reg", -5);
        $form->setMax("tx_exo_facul_1_depart", -5);
        $form->setMax("tx_exo_facul_2_depart", -5);
        $form->setMax("tx_exo_facul_3_depart", -5);
        $form->setMax("tx_exo_facul_4_depart", -5);
        $form->setMax("tx_exo_facul_5_depart", -5);
        $form->setMax("tx_exo_facul_6_depart", -5);
        $form->setMax("tx_exo_facul_7_depart", -5);
        $form->setMax("tx_exo_facul_8_depart", -5);
        $form->setMax("tx_exo_facul_9_depart", -5);
        $form->setMax("tx_exo_facul_1_comm", -5);
        $form->setMax("tx_exo_facul_2_comm", -5);
        $form->setMax("tx_exo_facul_3_comm", -5);
        $form->setMax("tx_exo_facul_4_comm", -5);
        $form->setMax("tx_exo_facul_5_comm", -5);
        $form->setMax("tx_exo_facul_6_comm", -5);
        $form->setMax("tx_exo_facul_7_comm", -5);
        $form->setMax("tx_exo_facul_8_comm", -5);
        $form->setMax("tx_exo_facul_9_comm", -5);
        $form->setMax("tx_rap", -5);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('taxe_amenagement', __('taxe_amenagement'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('en_ile_de_france', __('en_ile_de_france'));
        $form->setLib('val_forf_surf_cstr', __('val_forf_surf_cstr'));
        $form->setLib('val_forf_empl_tente_carav_rml', __('val_forf_empl_tente_carav_rml'));
        $form->setLib('val_forf_empl_hll', __('val_forf_empl_hll'));
        $form->setLib('val_forf_surf_piscine', __('val_forf_surf_piscine'));
        $form->setLib('val_forf_nb_eolienne', __('val_forf_nb_eolienne'));
        $form->setLib('val_forf_surf_pann_photo', __('val_forf_surf_pann_photo'));
        $form->setLib('val_forf_nb_parking_ext', __('val_forf_nb_parking_ext'));
        $form->setLib('tx_depart', __('tx_depart'));
        $form->setLib('tx_reg', __('tx_reg'));
        $form->setLib('tx_comm_secteur_1', __('tx_comm_secteur_1'));
        $form->setLib('tx_comm_secteur_2', __('tx_comm_secteur_2'));
        $form->setLib('tx_comm_secteur_3', __('tx_comm_secteur_3'));
        $form->setLib('tx_comm_secteur_4', __('tx_comm_secteur_4'));
        $form->setLib('tx_comm_secteur_5', __('tx_comm_secteur_5'));
        $form->setLib('tx_comm_secteur_6', __('tx_comm_secteur_6'));
        $form->setLib('tx_comm_secteur_7', __('tx_comm_secteur_7'));
        $form->setLib('tx_comm_secteur_8', __('tx_comm_secteur_8'));
        $form->setLib('tx_comm_secteur_9', __('tx_comm_secteur_9'));
        $form->setLib('tx_comm_secteur_10', __('tx_comm_secteur_10'));
        $form->setLib('tx_comm_secteur_11', __('tx_comm_secteur_11'));
        $form->setLib('tx_comm_secteur_12', __('tx_comm_secteur_12'));
        $form->setLib('tx_comm_secteur_13', __('tx_comm_secteur_13'));
        $form->setLib('tx_comm_secteur_14', __('tx_comm_secteur_14'));
        $form->setLib('tx_comm_secteur_15', __('tx_comm_secteur_15'));
        $form->setLib('tx_comm_secteur_16', __('tx_comm_secteur_16'));
        $form->setLib('tx_comm_secteur_17', __('tx_comm_secteur_17'));
        $form->setLib('tx_comm_secteur_18', __('tx_comm_secteur_18'));
        $form->setLib('tx_comm_secteur_19', __('tx_comm_secteur_19'));
        $form->setLib('tx_comm_secteur_20', __('tx_comm_secteur_20'));
        $form->setLib('tx_exo_facul_1_reg', __('tx_exo_facul_1_reg'));
        $form->setLib('tx_exo_facul_2_reg', __('tx_exo_facul_2_reg'));
        $form->setLib('tx_exo_facul_3_reg', __('tx_exo_facul_3_reg'));
        $form->setLib('tx_exo_facul_4_reg', __('tx_exo_facul_4_reg'));
        $form->setLib('tx_exo_facul_5_reg', __('tx_exo_facul_5_reg'));
        $form->setLib('tx_exo_facul_6_reg', __('tx_exo_facul_6_reg'));
        $form->setLib('tx_exo_facul_7_reg', __('tx_exo_facul_7_reg'));
        $form->setLib('tx_exo_facul_8_reg', __('tx_exo_facul_8_reg'));
        $form->setLib('tx_exo_facul_9_reg', __('tx_exo_facul_9_reg'));
        $form->setLib('tx_exo_facul_1_depart', __('tx_exo_facul_1_depart'));
        $form->setLib('tx_exo_facul_2_depart', __('tx_exo_facul_2_depart'));
        $form->setLib('tx_exo_facul_3_depart', __('tx_exo_facul_3_depart'));
        $form->setLib('tx_exo_facul_4_depart', __('tx_exo_facul_4_depart'));
        $form->setLib('tx_exo_facul_5_depart', __('tx_exo_facul_5_depart'));
        $form->setLib('tx_exo_facul_6_depart', __('tx_exo_facul_6_depart'));
        $form->setLib('tx_exo_facul_7_depart', __('tx_exo_facul_7_depart'));
        $form->setLib('tx_exo_facul_8_depart', __('tx_exo_facul_8_depart'));
        $form->setLib('tx_exo_facul_9_depart', __('tx_exo_facul_9_depart'));
        $form->setLib('tx_exo_facul_1_comm', __('tx_exo_facul_1_comm'));
        $form->setLib('tx_exo_facul_2_comm', __('tx_exo_facul_2_comm'));
        $form->setLib('tx_exo_facul_3_comm', __('tx_exo_facul_3_comm'));
        $form->setLib('tx_exo_facul_4_comm', __('tx_exo_facul_4_comm'));
        $form->setLib('tx_exo_facul_5_comm', __('tx_exo_facul_5_comm'));
        $form->setLib('tx_exo_facul_6_comm', __('tx_exo_facul_6_comm'));
        $form->setLib('tx_exo_facul_7_comm', __('tx_exo_facul_7_comm'));
        $form->setLib('tx_exo_facul_8_comm', __('tx_exo_facul_8_comm'));
        $form->setLib('tx_exo_facul_9_comm', __('tx_exo_facul_9_comm'));
        $form->setLib('tx_rap', __('tx_rap'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}
