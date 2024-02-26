<?php
//$Id$ 
//gen openMairie le 07/03/2023 15:07

require_once "../obj/om_dbform.class.php";

class sig_contrainte_gen extends om_dbform {

    protected $_absolute_class_name = "sig_contrainte";

    var $table = "sig_contrainte";
    var $clePrimaire = "sig_contrainte";
    var $typeCle = "N";
    var $required_field = array(
        "groupe",
        "libelle",
        "nature",
        "sig_contrainte",
        "sig_couche"
    );
    
    var $foreign_keys_extended = array(
        "sig_groupe" => array("sig_groupe", ),
        "sig_couche" => array("sig_couche", ),
        "sig_sousgroupe" => array("sig_sousgroupe", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("libelle");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "sig_contrainte",
            "nature",
            "groupe",
            "sousgroupe",
            "libelle",
            "texte",
            "texte_genere",
            "no_ordre",
            "service_consulte",
            "sig_couche",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_groupe() {
        return "SELECT sig_groupe.sig_groupe, sig_groupe.libelle FROM ".DB_PREFIXE."sig_groupe ORDER BY sig_groupe.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_groupe_by_id() {
        return "SELECT sig_groupe.sig_groupe, sig_groupe.libelle FROM ".DB_PREFIXE."sig_groupe WHERE sig_groupe = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_couche() {
        return "SELECT sig_couche.sig_couche, sig_couche.libelle FROM ".DB_PREFIXE."sig_couche ORDER BY sig_couche.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_couche_by_id() {
        return "SELECT sig_couche.sig_couche, sig_couche.libelle FROM ".DB_PREFIXE."sig_couche WHERE sig_couche = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sousgroupe() {
        return "SELECT sig_sousgroupe.sig_sousgroupe, sig_sousgroupe.libelle FROM ".DB_PREFIXE."sig_sousgroupe ORDER BY sig_sousgroupe.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sousgroupe_by_id() {
        return "SELECT sig_sousgroupe.sig_sousgroupe, sig_sousgroupe.libelle FROM ".DB_PREFIXE."sig_sousgroupe WHERE sig_sousgroupe = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['sig_contrainte'])) {
            $this->valF['sig_contrainte'] = ""; // -> requis
        } else {
            $this->valF['sig_contrainte'] = $val['sig_contrainte'];
        }
        $this->valF['nature'] = $val['nature'];
        if (!is_numeric($val['groupe'])) {
            $this->valF['groupe'] = ""; // -> requis
        } else {
            $this->valF['groupe'] = $val['groupe'];
        }
        if (!is_numeric($val['sousgroupe'])) {
            $this->valF['sousgroupe'] = NULL;
        } else {
            $this->valF['sousgroupe'] = $val['sousgroupe'];
        }
        $this->valF['libelle'] = $val['libelle'];
            $this->valF['texte'] = $val['texte'];
            $this->valF['texte_genere'] = $val['texte_genere'];
        if (!is_numeric($val['no_ordre'])) {
            $this->valF['no_ordre'] = NULL;
        } else {
            $this->valF['no_ordre'] = $val['no_ordre'];
        }
        if ($val['service_consulte'] == 1 || $val['service_consulte'] == "t" || $val['service_consulte'] == "Oui") {
            $this->valF['service_consulte'] = true;
        } else {
            $this->valF['service_consulte'] = false;
        }
        if (!is_numeric($val['sig_couche'])) {
            $this->valF['sig_couche'] = ""; // -> requis
        } else {
            $this->valF['sig_couche'] = $val['sig_couche'];
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
            $form->setType("sig_contrainte", "hidden");
            $form->setType("nature", "text");
            if ($this->is_in_context_of_foreign_key("sig_groupe", $this->retourformulaire)) {
                $form->setType("groupe", "selecthiddenstatic");
            } else {
                $form->setType("groupe", "select");
            }
            if ($this->is_in_context_of_foreign_key("sig_sousgroupe", $this->retourformulaire)) {
                $form->setType("sousgroupe", "selecthiddenstatic");
            } else {
                $form->setType("sousgroupe", "select");
            }
            $form->setType("libelle", "text");
            $form->setType("texte", "textarea");
            $form->setType("texte_genere", "textarea");
            $form->setType("no_ordre", "text");
            $form->setType("service_consulte", "checkbox");
            if ($this->is_in_context_of_foreign_key("sig_couche", $this->retourformulaire)) {
                $form->setType("sig_couche", "selecthiddenstatic");
            } else {
                $form->setType("sig_couche", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("sig_contrainte", "hiddenstatic");
            $form->setType("nature", "text");
            if ($this->is_in_context_of_foreign_key("sig_groupe", $this->retourformulaire)) {
                $form->setType("groupe", "selecthiddenstatic");
            } else {
                $form->setType("groupe", "select");
            }
            if ($this->is_in_context_of_foreign_key("sig_sousgroupe", $this->retourformulaire)) {
                $form->setType("sousgroupe", "selecthiddenstatic");
            } else {
                $form->setType("sousgroupe", "select");
            }
            $form->setType("libelle", "text");
            $form->setType("texte", "textarea");
            $form->setType("texte_genere", "textarea");
            $form->setType("no_ordre", "text");
            $form->setType("service_consulte", "checkbox");
            if ($this->is_in_context_of_foreign_key("sig_couche", $this->retourformulaire)) {
                $form->setType("sig_couche", "selecthiddenstatic");
            } else {
                $form->setType("sig_couche", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("sig_contrainte", "hiddenstatic");
            $form->setType("nature", "hiddenstatic");
            $form->setType("groupe", "selectstatic");
            $form->setType("sousgroupe", "selectstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("texte", "hiddenstatic");
            $form->setType("texte_genere", "hiddenstatic");
            $form->setType("no_ordre", "hiddenstatic");
            $form->setType("service_consulte", "hiddenstatic");
            $form->setType("sig_couche", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("sig_contrainte", "static");
            $form->setType("nature", "static");
            $form->setType("groupe", "selectstatic");
            $form->setType("sousgroupe", "selectstatic");
            $form->setType("libelle", "static");
            $form->setType("texte", "textareastatic");
            $form->setType("texte_genere", "textareastatic");
            $form->setType("no_ordre", "static");
            $form->setType("service_consulte", "checkboxstatic");
            $form->setType("sig_couche", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('sig_contrainte','VerifNum(this)');
        $form->setOnchange('groupe','VerifNum(this)');
        $form->setOnchange('sousgroupe','VerifNum(this)');
        $form->setOnchange('no_ordre','VerifNum(this)');
        $form->setOnchange('sig_couche','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("sig_contrainte", 11);
        $form->setTaille("nature", 10);
        $form->setTaille("groupe", 11);
        $form->setTaille("sousgroupe", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("texte", 80);
        $form->setTaille("texte_genere", 80);
        $form->setTaille("no_ordre", 11);
        $form->setTaille("service_consulte", 1);
        $form->setTaille("sig_couche", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("sig_contrainte", 11);
        $form->setMax("nature", 10);
        $form->setMax("groupe", 11);
        $form->setMax("sousgroupe", 11);
        $form->setMax("libelle", 250);
        $form->setMax("texte", 6);
        $form->setMax("texte_genere", 6);
        $form->setMax("no_ordre", 11);
        $form->setMax("service_consulte", 1);
        $form->setMax("sig_couche", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('sig_contrainte', __('sig_contrainte'));
        $form->setLib('nature', __('nature'));
        $form->setLib('groupe', __('groupe'));
        $form->setLib('sousgroupe', __('sousgroupe'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('texte', __('texte'));
        $form->setLib('texte_genere', __('texte_genere'));
        $form->setLib('no_ordre', __('no_ordre'));
        $form->setLib('service_consulte', __('service_consulte'));
        $form->setLib('sig_couche', __('sig_couche'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // groupe
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "groupe",
            $this->get_var_sql_forminc__sql("groupe"),
            $this->get_var_sql_forminc__sql("groupe_by_id"),
            false
        );
        // sig_couche
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "sig_couche",
            $this->get_var_sql_forminc__sql("sig_couche"),
            $this->get_var_sql_forminc__sql("sig_couche_by_id"),
            false
        );
        // sousgroupe
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "sousgroupe",
            $this->get_var_sql_forminc__sql("sousgroupe"),
            $this->get_var_sql_forminc__sql("sousgroupe_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('sig_groupe', $this->retourformulaire))
                $form->setVal('groupe', $idxformulaire);
            if($this->is_in_context_of_foreign_key('sig_couche', $this->retourformulaire))
                $form->setVal('sig_couche', $idxformulaire);
            if($this->is_in_context_of_foreign_key('sig_sousgroupe', $this->retourformulaire))
                $form->setVal('sousgroupe', $idxformulaire);
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
        // Verification de la cle secondaire : lien_sig_contrainte_dossier_instruction_type
        $this->rechercheTable($this->f->db, "lien_sig_contrainte_dossier_instruction_type", "sig_contrainte", $id);
        // Verification de la cle secondaire : lien_sig_contrainte_evenement
        $this->rechercheTable($this->f->db, "lien_sig_contrainte_evenement", "sig_contrainte", $id);
        // Verification de la cle secondaire : lien_sig_contrainte_om_collectivite
        $this->rechercheTable($this->f->db, "lien_sig_contrainte_om_collectivite", "sig_contrainte", $id);
        // Verification de la cle secondaire : lien_sig_contrainte_sig_attribut
        $this->rechercheTable($this->f->db, "lien_sig_contrainte_sig_attribut", "sig_contrainte", $id);
    }


}
