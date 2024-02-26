<?php
//$Id$ 
//gen openMairie le 05/08/2022 15:17

require_once "../obj/om_dbform.class.php";

class blocnote_gen extends om_dbform {

    protected $_absolute_class_name = "blocnote";

    var $table = "blocnote";
    var $clePrimaire = "blocnote";
    var $typeCle = "N";
    var $required_field = array(
        "blocnote",
        "categorie",
        "note"
    );
    
    var $foreign_keys_extended = array(
        "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("categorie");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "blocnote",
            "categorie",
            "note",
            "dossier",
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
        if (!is_numeric($val['blocnote'])) {
            $this->valF['blocnote'] = ""; // -> requis
        } else {
            $this->valF['blocnote'] = $val['blocnote'];
        }
        $this->valF['categorie'] = $val['categorie'];
            $this->valF['note'] = $val['note'];
        if ($val['dossier'] == "") {
            $this->valF['dossier'] = NULL;
        } else {
            $this->valF['dossier'] = $val['dossier'];
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
            $form->setType("blocnote", "hidden");
            $form->setType("categorie", "text");
            $form->setType("note", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("blocnote", "hiddenstatic");
            $form->setType("categorie", "text");
            $form->setType("note", "textarea");
            if ($this->is_in_context_of_foreign_key("dossier", $this->retourformulaire)) {
                $form->setType("dossier", "selecthiddenstatic");
            } else {
                $form->setType("dossier", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("blocnote", "hiddenstatic");
            $form->setType("categorie", "hiddenstatic");
            $form->setType("note", "hiddenstatic");
            $form->setType("dossier", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("blocnote", "static");
            $form->setType("categorie", "static");
            $form->setType("note", "textareastatic");
            $form->setType("dossier", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('blocnote','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("blocnote", 11);
        $form->setTaille("categorie", 20);
        $form->setTaille("note", 80);
        $form->setTaille("dossier", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("blocnote", 11);
        $form->setMax("categorie", 20);
        $form->setMax("note", 6);
        $form->setMax("dossier", 30);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('blocnote', __('blocnote'));
        $form->setLib('categorie', __('categorie'));
        $form->setLib('note', __('note'));
        $form->setLib('dossier', __('dossier'));
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
