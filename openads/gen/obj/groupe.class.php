<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class groupe_gen extends om_dbform {

    protected $_absolute_class_name = "groupe";

    var $table = "groupe";
    var $clePrimaire = "groupe";
    var $typeCle = "N";
    var $required_field = array(
        "genre",
        "groupe"
    );
    
    var $foreign_keys_extended = array(
        "genre" => array("genre", ),
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
            "groupe",
            "code",
            "libelle",
            "description",
            "genre",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_genre() {
        return "SELECT genre.genre, genre.libelle FROM ".DB_PREFIXE."genre ORDER BY genre.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_genre_by_id() {
        return "SELECT genre.genre, genre.libelle FROM ".DB_PREFIXE."genre WHERE genre = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['groupe'])) {
            $this->valF['groupe'] = ""; // -> requis
        } else {
            $this->valF['groupe'] = $val['groupe'];
        }
        if ($val['code'] == "") {
            $this->valF['code'] = NULL;
        } else {
            $this->valF['code'] = $val['code'];
        }
        if ($val['libelle'] == "") {
            $this->valF['libelle'] = NULL;
        } else {
            $this->valF['libelle'] = $val['libelle'];
        }
            $this->valF['description'] = $val['description'];
        if (!is_numeric($val['genre'])) {
            $this->valF['genre'] = ""; // -> requis
        } else {
            $this->valF['genre'] = $val['genre'];
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
            $form->setType("groupe", "hidden");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            if ($this->is_in_context_of_foreign_key("genre", $this->retourformulaire)) {
                $form->setType("genre", "selecthiddenstatic");
            } else {
                $form->setType("genre", "select");
            }
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("groupe", "hiddenstatic");
            $form->setType("code", "text");
            $form->setType("libelle", "text");
            $form->setType("description", "textarea");
            if ($this->is_in_context_of_foreign_key("genre", $this->retourformulaire)) {
                $form->setType("genre", "selecthiddenstatic");
            } else {
                $form->setType("genre", "select");
            }
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("groupe", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("description", "hiddenstatic");
            $form->setType("genre", "selectstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("groupe", "static");
            $form->setType("code", "static");
            $form->setType("libelle", "static");
            $form->setType("description", "textareastatic");
            $form->setType("genre", "selectstatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('groupe','VerifNum(this)');
        $form->setOnchange('genre','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("groupe", 11);
        $form->setTaille("code", 20);
        $form->setTaille("libelle", 30);
        $form->setTaille("description", 80);
        $form->setTaille("genre", 11);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("groupe", 11);
        $form->setMax("code", 20);
        $form->setMax("libelle", 100);
        $form->setMax("description", 6);
        $form->setMax("genre", 11);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('groupe', __('groupe'));
        $form->setLib('code', __('code'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('description', __('description'));
        $form->setLib('genre', __('genre'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // genre
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "genre",
            $this->get_var_sql_forminc__sql("genre"),
            $this->get_var_sql_forminc__sql("genre_by_id"),
            false
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('genre', $this->retourformulaire))
                $form->setVal('genre', $idxformulaire);
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
        // Verification de la cle secondaire : demande_type
        $this->rechercheTable($this->f->db, "demande_type", "groupe", $id);
        // Verification de la cle secondaire : dossier_autorisation_type
        $this->rechercheTable($this->f->db, "dossier_autorisation_type", "groupe", $id);
        // Verification de la cle secondaire : lien_om_profil_groupe
        $this->rechercheTable($this->f->db, "lien_om_profil_groupe", "groupe", $id);
        // Verification de la cle secondaire : lien_om_utilisateur_groupe
        $this->rechercheTable($this->f->db, "lien_om_utilisateur_groupe", "groupe", $id);
    }


}
