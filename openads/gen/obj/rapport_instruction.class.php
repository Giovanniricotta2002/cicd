<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class rapport_instruction_gen extends om_dbform {

    protected $_absolute_class_name = "rapport_instruction";

    var $table = "rapport_instruction";
    var $clePrimaire = "rapport_instruction";
    var $typeCle = "N";
    var $required_field = array(
        "rapport_instruction"
    );
    
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
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
            "rapport_instruction",
            "dossier_instruction",
            "analyse_reglementaire_om_html",
            "description_projet_om_html",
            "proposition_decision",
            "om_fichier_rapport_instruction",
            "om_final_rapport_instruction",
            "complement_om_html",
            "om_fichier_rapport_instruction_dossier_final",
        );
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




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['rapport_instruction'])) {
            $this->valF['rapport_instruction'] = ""; // -> requis
        } else {
            $this->valF['rapport_instruction'] = $val['rapport_instruction'];
        }
        if ($val['dossier_instruction'] == "") {
            $this->valF['dossier_instruction'] = NULL;
        } else {
            $this->valF['dossier_instruction'] = $val['dossier_instruction'];
        }
            $this->valF['analyse_reglementaire_om_html'] = $val['analyse_reglementaire_om_html'];
            $this->valF['description_projet_om_html'] = $val['description_projet_om_html'];
            $this->valF['proposition_decision'] = $val['proposition_decision'];
        if ($val['om_fichier_rapport_instruction'] == "") {
            $this->valF['om_fichier_rapport_instruction'] = NULL;
        } else {
            $this->valF['om_fichier_rapport_instruction'] = $val['om_fichier_rapport_instruction'];
        }
        if ($val['om_final_rapport_instruction'] == 1 || $val['om_final_rapport_instruction'] == "t" || $val['om_final_rapport_instruction'] == "Oui") {
            $this->valF['om_final_rapport_instruction'] = true;
        } else {
            $this->valF['om_final_rapport_instruction'] = false;
        }
            $this->valF['complement_om_html'] = $val['complement_om_html'];
        if ($val['om_fichier_rapport_instruction_dossier_final'] == 1 || $val['om_fichier_rapport_instruction_dossier_final'] == "t" || $val['om_fichier_rapport_instruction_dossier_final'] == "Oui") {
            $this->valF['om_fichier_rapport_instruction_dossier_final'] = true;
        } else {
            $this->valF['om_fichier_rapport_instruction_dossier_final'] = false;
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
            $form->setType("rapport_instruction", "hidden");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_instruction", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction", "select");
            }
            $form->setType("analyse_reglementaire_om_html", "html");
            $form->setType("description_projet_om_html", "html");
            $form->setType("proposition_decision", "textarea");
            $form->setType("om_fichier_rapport_instruction", "text");
            $form->setType("om_final_rapport_instruction", "checkbox");
            $form->setType("complement_om_html", "html");
            $form->setType("om_fichier_rapport_instruction_dossier_final", "checkbox");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("rapport_instruction", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier_instruction", "selecthiddenstatic");
            } else {
                $form->setType("dossier_instruction", "select");
            }
            $form->setType("analyse_reglementaire_om_html", "html");
            $form->setType("description_projet_om_html", "html");
            $form->setType("proposition_decision", "textarea");
            $form->setType("om_fichier_rapport_instruction", "text");
            $form->setType("om_final_rapport_instruction", "checkbox");
            $form->setType("complement_om_html", "html");
            $form->setType("om_fichier_rapport_instruction_dossier_final", "checkbox");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("rapport_instruction", "hiddenstatic");
            $form->setType("dossier_instruction", "selectstatic");
            $form->setType("analyse_reglementaire_om_html", "hiddenstatic");
            $form->setType("description_projet_om_html", "hiddenstatic");
            $form->setType("proposition_decision", "hiddenstatic");
            $form->setType("om_fichier_rapport_instruction", "hiddenstatic");
            $form->setType("om_final_rapport_instruction", "hiddenstatic");
            $form->setType("complement_om_html", "hiddenstatic");
            $form->setType("om_fichier_rapport_instruction_dossier_final", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("rapport_instruction", "static");
            $form->setType("dossier_instruction", "selectstatic");
            $form->setType("analyse_reglementaire_om_html", "htmlstatic");
            $form->setType("description_projet_om_html", "htmlstatic");
            $form->setType("proposition_decision", "textareastatic");
            $form->setType("om_fichier_rapport_instruction", "static");
            $form->setType("om_final_rapport_instruction", "checkboxstatic");
            $form->setType("complement_om_html", "htmlstatic");
            $form->setType("om_fichier_rapport_instruction_dossier_final", "checkboxstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('rapport_instruction','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("rapport_instruction", 11);
        $form->setTaille("dossier_instruction", 30);
        $form->setTaille("analyse_reglementaire_om_html", 80);
        $form->setTaille("description_projet_om_html", 80);
        $form->setTaille("proposition_decision", 80);
        $form->setTaille("om_fichier_rapport_instruction", 30);
        $form->setTaille("om_final_rapport_instruction", 1);
        $form->setTaille("complement_om_html", 80);
        $form->setTaille("om_fichier_rapport_instruction_dossier_final", 1);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("rapport_instruction", 11);
        $form->setMax("dossier_instruction", 255);
        $form->setMax("analyse_reglementaire_om_html", 6);
        $form->setMax("description_projet_om_html", 6);
        $form->setMax("proposition_decision", 6);
        $form->setMax("om_fichier_rapport_instruction", 255);
        $form->setMax("om_final_rapport_instruction", 1);
        $form->setMax("complement_om_html", 6);
        $form->setMax("om_fichier_rapport_instruction_dossier_final", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('rapport_instruction', __('rapport_instruction'));
        $form->setLib('dossier_instruction', __('dossier_instruction'));
        $form->setLib('analyse_reglementaire_om_html', __('analyse_reglementaire_om_html'));
        $form->setLib('description_projet_om_html', __('description_projet_om_html'));
        $form->setLib('proposition_decision', __('proposition_decision'));
        $form->setLib('om_fichier_rapport_instruction', __('om_fichier_rapport_instruction'));
        $form->setLib('om_final_rapport_instruction', __('om_final_rapport_instruction'));
        $form->setLib('complement_om_html', __('complement_om_html'));
        $form->setLib('om_fichier_rapport_instruction_dossier_final', __('om_fichier_rapport_instruction_dossier_final'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('dossier', $this->retourformulaire))
                $form->setVal('dossier_instruction', $idxformulaire);
        }// fin validation
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    

}
