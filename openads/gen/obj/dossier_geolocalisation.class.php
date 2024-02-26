<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class dossier_geolocalisation_gen extends om_dbform {

    protected $_absolute_class_name = "dossier_geolocalisation";

    var $table = "dossier_geolocalisation";
    var $clePrimaire = "dossier_geolocalisation";
    var $typeCle = "N";
    var $required_field = array(
        "dossier",
        "dossier_geolocalisation"
    );
    
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("dossier");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "dossier_geolocalisation",
            "dossier",
            "date_verif_parcelle",
            "etat_verif_parcelle",
            "message_verif_parcelle",
            "date_calcul_emprise",
            "etat_calcul_emprise",
            "message_calcul_emprise",
            "date_dessin_emprise",
            "etat_dessin_emprise",
            "message_dessin_emprise",
            "date_calcul_centroide",
            "etat_calcul_centroide",
            "message_calcul_centroide",
            "date_recup_contrainte",
            "etat_recup_contrainte",
            "message_recup_contrainte",
            "terrain_references_cadastrales_archive",
        );
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['dossier_geolocalisation'])) {
            $this->valF['dossier_geolocalisation'] = ""; // -> requis
        } else {
            $this->valF['dossier_geolocalisation'] = $val['dossier_geolocalisation'];
        }
        $this->valF['dossier'] = $val['dossier'];
            $this->valF['date_verif_parcelle'] = $val['date_verif_parcelle'];
        if ($val['etat_verif_parcelle'] == 1 || $val['etat_verif_parcelle'] == "t" || $val['etat_verif_parcelle'] == "Oui") {
            $this->valF['etat_verif_parcelle'] = true;
        } else {
            $this->valF['etat_verif_parcelle'] = false;
        }
            $this->valF['message_verif_parcelle'] = $val['message_verif_parcelle'];
            $this->valF['date_calcul_emprise'] = $val['date_calcul_emprise'];
        if ($val['etat_calcul_emprise'] == 1 || $val['etat_calcul_emprise'] == "t" || $val['etat_calcul_emprise'] == "Oui") {
            $this->valF['etat_calcul_emprise'] = true;
        } else {
            $this->valF['etat_calcul_emprise'] = false;
        }
            $this->valF['message_calcul_emprise'] = $val['message_calcul_emprise'];
            $this->valF['date_dessin_emprise'] = $val['date_dessin_emprise'];
        if ($val['etat_dessin_emprise'] == 1 || $val['etat_dessin_emprise'] == "t" || $val['etat_dessin_emprise'] == "Oui") {
            $this->valF['etat_dessin_emprise'] = true;
        } else {
            $this->valF['etat_dessin_emprise'] = false;
        }
            $this->valF['message_dessin_emprise'] = $val['message_dessin_emprise'];
            $this->valF['date_calcul_centroide'] = $val['date_calcul_centroide'];
        if ($val['etat_calcul_centroide'] == 1 || $val['etat_calcul_centroide'] == "t" || $val['etat_calcul_centroide'] == "Oui") {
            $this->valF['etat_calcul_centroide'] = true;
        } else {
            $this->valF['etat_calcul_centroide'] = false;
        }
            $this->valF['message_calcul_centroide'] = $val['message_calcul_centroide'];
            $this->valF['date_recup_contrainte'] = $val['date_recup_contrainte'];
        if ($val['etat_recup_contrainte'] == 1 || $val['etat_recup_contrainte'] == "t" || $val['etat_recup_contrainte'] == "Oui") {
            $this->valF['etat_recup_contrainte'] = true;
        } else {
            $this->valF['etat_recup_contrainte'] = false;
        }
            $this->valF['message_recup_contrainte'] = $val['message_recup_contrainte'];
            $this->valF['terrain_references_cadastrales_archive'] = $val['terrain_references_cadastrales_archive'];
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
            $form->setType("dossier_geolocalisation", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("date_verif_parcelle", "text");
            $form->setType("etat_verif_parcelle", "checkbox");
            $form->setType("message_verif_parcelle", "textarea");
            $form->setType("date_calcul_emprise", "text");
            $form->setType("etat_calcul_emprise", "checkbox");
            $form->setType("message_calcul_emprise", "textarea");
            $form->setType("date_dessin_emprise", "text");
            $form->setType("etat_dessin_emprise", "checkbox");
            $form->setType("message_dessin_emprise", "textarea");
            $form->setType("date_calcul_centroide", "text");
            $form->setType("etat_calcul_centroide", "checkbox");
            $form->setType("message_calcul_centroide", "textarea");
            $form->setType("date_recup_contrainte", "text");
            $form->setType("etat_recup_contrainte", "checkbox");
            $form->setType("message_recup_contrainte", "textarea");
            $form->setType("terrain_references_cadastrales_archive", "textarea");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("dossier_geolocalisation", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
            $form->setType("date_verif_parcelle", "text");
            $form->setType("etat_verif_parcelle", "checkbox");
            $form->setType("message_verif_parcelle", "textarea");
            $form->setType("date_calcul_emprise", "text");
            $form->setType("etat_calcul_emprise", "checkbox");
            $form->setType("message_calcul_emprise", "textarea");
            $form->setType("date_dessin_emprise", "text");
            $form->setType("etat_dessin_emprise", "checkbox");
            $form->setType("message_dessin_emprise", "textarea");
            $form->setType("date_calcul_centroide", "text");
            $form->setType("etat_calcul_centroide", "checkbox");
            $form->setType("message_calcul_centroide", "textarea");
            $form->setType("date_recup_contrainte", "text");
            $form->setType("etat_recup_contrainte", "checkbox");
            $form->setType("message_recup_contrainte", "textarea");
            $form->setType("terrain_references_cadastrales_archive", "textarea");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("dossier_geolocalisation", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
            $form->setType("date_verif_parcelle", "hiddenstatic");
            $form->setType("etat_verif_parcelle", "hiddenstatic");
            $form->setType("message_verif_parcelle", "hiddenstatic");
            $form->setType("date_calcul_emprise", "hiddenstatic");
            $form->setType("etat_calcul_emprise", "hiddenstatic");
            $form->setType("message_calcul_emprise", "hiddenstatic");
            $form->setType("date_dessin_emprise", "hiddenstatic");
            $form->setType("etat_dessin_emprise", "hiddenstatic");
            $form->setType("message_dessin_emprise", "hiddenstatic");
            $form->setType("date_calcul_centroide", "hiddenstatic");
            $form->setType("etat_calcul_centroide", "hiddenstatic");
            $form->setType("message_calcul_centroide", "hiddenstatic");
            $form->setType("date_recup_contrainte", "hiddenstatic");
            $form->setType("etat_recup_contrainte", "hiddenstatic");
            $form->setType("message_recup_contrainte", "hiddenstatic");
            $form->setType("terrain_references_cadastrales_archive", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("dossier_geolocalisation", "static");
            $form->setType("dossier", "selectstatic");
            $form->setType("date_verif_parcelle", "static");
            $form->setType("etat_verif_parcelle", "checkboxstatic");
            $form->setType("message_verif_parcelle", "textareastatic");
            $form->setType("date_calcul_emprise", "static");
            $form->setType("etat_calcul_emprise", "checkboxstatic");
            $form->setType("message_calcul_emprise", "textareastatic");
            $form->setType("date_dessin_emprise", "static");
            $form->setType("etat_dessin_emprise", "checkboxstatic");
            $form->setType("message_dessin_emprise", "textareastatic");
            $form->setType("date_calcul_centroide", "static");
            $form->setType("etat_calcul_centroide", "checkboxstatic");
            $form->setType("message_calcul_centroide", "textareastatic");
            $form->setType("date_recup_contrainte", "static");
            $form->setType("etat_recup_contrainte", "checkboxstatic");
            $form->setType("message_recup_contrainte", "textareastatic");
            $form->setType("terrain_references_cadastrales_archive", "textareastatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('dossier_geolocalisation','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("dossier_geolocalisation", 11);
        $form->setTaille("dossier", 30);
        $form->setTaille("date_verif_parcelle", 8);
        $form->setTaille("etat_verif_parcelle", 1);
        $form->setTaille("message_verif_parcelle", 80);
        $form->setTaille("date_calcul_emprise", 8);
        $form->setTaille("etat_calcul_emprise", 1);
        $form->setTaille("message_calcul_emprise", 80);
        $form->setTaille("date_dessin_emprise", 8);
        $form->setTaille("etat_dessin_emprise", 1);
        $form->setTaille("message_dessin_emprise", 80);
        $form->setTaille("date_calcul_centroide", 8);
        $form->setTaille("etat_calcul_centroide", 1);
        $form->setTaille("message_calcul_centroide", 80);
        $form->setTaille("date_recup_contrainte", 8);
        $form->setTaille("etat_recup_contrainte", 1);
        $form->setTaille("message_recup_contrainte", 80);
        $form->setTaille("terrain_references_cadastrales_archive", 80);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("dossier_geolocalisation", 11);
        $form->setMax("dossier", 255);
        $form->setMax("date_verif_parcelle", 8);
        $form->setMax("etat_verif_parcelle", 1);
        $form->setMax("message_verif_parcelle", 6);
        $form->setMax("date_calcul_emprise", 8);
        $form->setMax("etat_calcul_emprise", 1);
        $form->setMax("message_calcul_emprise", 6);
        $form->setMax("date_dessin_emprise", 8);
        $form->setMax("etat_dessin_emprise", 1);
        $form->setMax("message_dessin_emprise", 6);
        $form->setMax("date_calcul_centroide", 8);
        $form->setMax("etat_calcul_centroide", 1);
        $form->setMax("message_calcul_centroide", 6);
        $form->setMax("date_recup_contrainte", 8);
        $form->setMax("etat_recup_contrainte", 1);
        $form->setMax("message_recup_contrainte", 6);
        $form->setMax("terrain_references_cadastrales_archive", 6);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('dossier_geolocalisation', __('dossier_geolocalisation'));
        $form->setLib('dossier', __('dossier'));
        $form->setLib('date_verif_parcelle', __('date_verif_parcelle'));
        $form->setLib('etat_verif_parcelle', __('etat_verif_parcelle'));
        $form->setLib('message_verif_parcelle', __('message_verif_parcelle'));
        $form->setLib('date_calcul_emprise', __('date_calcul_emprise'));
        $form->setLib('etat_calcul_emprise', __('etat_calcul_emprise'));
        $form->setLib('message_calcul_emprise', __('message_calcul_emprise'));
        $form->setLib('date_dessin_emprise', __('date_dessin_emprise'));
        $form->setLib('etat_dessin_emprise', __('etat_dessin_emprise'));
        $form->setLib('message_dessin_emprise', __('message_dessin_emprise'));
        $form->setLib('date_calcul_centroide', __('date_calcul_centroide'));
        $form->setLib('etat_calcul_centroide', __('etat_calcul_centroide'));
        $form->setLib('message_calcul_centroide', __('message_calcul_centroide'));
        $form->setLib('date_recup_contrainte', __('date_recup_contrainte'));
        $form->setLib('etat_recup_contrainte', __('etat_recup_contrainte'));
        $form->setLib('message_recup_contrainte', __('message_recup_contrainte'));
        $form->setLib('terrain_references_cadastrales_archive', __('terrain_references_cadastrales_archive'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}
