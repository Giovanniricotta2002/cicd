<?php
//$Id$ 
//gen openMairie le 23/01/2023 14:57

require_once "../obj/om_dbform.class.php";

class tiers_consulte_gen extends om_dbform {

    protected $_absolute_class_name = "tiers_consulte";

    var $table = "tiers_consulte";
    var $clePrimaire = "tiers_consulte";
    var $typeCle = "N";
    var $required_field = array(
        "abrege",
        "categorie_tiers_consulte",
        "libelle",
        "tiers_consulte"
    );
    
    var $foreign_keys_extended = array(
        "categorie_tiers_consulte" => array("categorie_tiers_consulte", ),
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
            "tiers_consulte",
            "categorie_tiers_consulte",
            "abrege",
            "libelle",
            "adresse",
            "complement",
            "cp",
            "ville",
            "liste_diffusion",
            "accepte_notification_email",
            "uid_platau_acteur",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers_consulte() {
        return "SELECT categorie_tiers_consulte.categorie_tiers_consulte, categorie_tiers_consulte.libelle FROM ".DB_PREFIXE."categorie_tiers_consulte WHERE ((categorie_tiers_consulte.om_validite_debut IS NULL AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE AND (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE))) ORDER BY categorie_tiers_consulte.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers_consulte_by_id() {
        return "SELECT categorie_tiers_consulte.categorie_tiers_consulte, categorie_tiers_consulte.libelle FROM ".DB_PREFIXE."categorie_tiers_consulte WHERE categorie_tiers_consulte = <idx>";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['tiers_consulte'])) {
            $this->valF['tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['tiers_consulte'] = $val['tiers_consulte'];
        }
        if (!is_numeric($val['categorie_tiers_consulte'])) {
            $this->valF['categorie_tiers_consulte'] = ""; // -> requis
        } else {
            $this->valF['categorie_tiers_consulte'] = $val['categorie_tiers_consulte'];
        }
        $this->valF['abrege'] = $val['abrege'];
        $this->valF['libelle'] = $val['libelle'];
        if ($val['adresse'] == "") {
            $this->valF['adresse'] = NULL;
        } else {
            $this->valF['adresse'] = $val['adresse'];
        }
        if ($val['complement'] == "") {
            $this->valF['complement'] = NULL;
        } else {
            $this->valF['complement'] = $val['complement'];
        }
        if ($val['cp'] == "") {
            $this->valF['cp'] = NULL;
        } else {
            $this->valF['cp'] = $val['cp'];
        }
        if ($val['ville'] == "") {
            $this->valF['ville'] = NULL;
        } else {
            $this->valF['ville'] = $val['ville'];
        }
            $this->valF['liste_diffusion'] = $val['liste_diffusion'];
        if ($val['accepte_notification_email'] == 1 || $val['accepte_notification_email'] == "t" || $val['accepte_notification_email'] == "Oui") {
            $this->valF['accepte_notification_email'] = true;
        } else {
            $this->valF['accepte_notification_email'] = false;
        }
        if ($val['uid_platau_acteur'] == "") {
            $this->valF['uid_platau_acteur'] = NULL;
        } else {
            $this->valF['uid_platau_acteur'] = $val['uid_platau_acteur'];
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
            $form->setType("tiers_consulte", "hidden");
            if ($this->is_in_context_of_foreign_key("categorie_tiers_consulte", $this->retourformulaire)) {
                $form->setType("categorie_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("categorie_tiers_consulte", "select");
            }
            $form->setType("abrege", "text");
            $form->setType("libelle", "text");
            $form->setType("adresse", "text");
            $form->setType("complement", "text");
            $form->setType("cp", "text");
            $form->setType("ville", "text");
            $form->setType("liste_diffusion", "textarea");
            $form->setType("accepte_notification_email", "checkbox");
            $form->setType("uid_platau_acteur", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("tiers_consulte", "hiddenstatic");
            if ($this->is_in_context_of_foreign_key("categorie_tiers_consulte", $this->retourformulaire)) {
                $form->setType("categorie_tiers_consulte", "selecthiddenstatic");
            } else {
                $form->setType("categorie_tiers_consulte", "select");
            }
            $form->setType("abrege", "text");
            $form->setType("libelle", "text");
            $form->setType("adresse", "text");
            $form->setType("complement", "text");
            $form->setType("cp", "text");
            $form->setType("ville", "text");
            $form->setType("liste_diffusion", "textarea");
            $form->setType("accepte_notification_email", "checkbox");
            $form->setType("uid_platau_acteur", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("tiers_consulte", "hiddenstatic");
            $form->setType("categorie_tiers_consulte", "selectstatic");
            $form->setType("abrege", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("adresse", "hiddenstatic");
            $form->setType("complement", "hiddenstatic");
            $form->setType("cp", "hiddenstatic");
            $form->setType("ville", "hiddenstatic");
            $form->setType("liste_diffusion", "hiddenstatic");
            $form->setType("accepte_notification_email", "hiddenstatic");
            $form->setType("uid_platau_acteur", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("tiers_consulte", "static");
            $form->setType("categorie_tiers_consulte", "selectstatic");
            $form->setType("abrege", "static");
            $form->setType("libelle", "static");
            $form->setType("adresse", "static");
            $form->setType("complement", "static");
            $form->setType("cp", "static");
            $form->setType("ville", "static");
            $form->setType("liste_diffusion", "textareastatic");
            $form->setType("accepte_notification_email", "checkboxstatic");
            $form->setType("uid_platau_acteur", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('tiers_consulte','VerifNum(this)');
        $form->setOnchange('categorie_tiers_consulte','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("tiers_consulte", 11);
        $form->setTaille("categorie_tiers_consulte", 11);
        $form->setTaille("abrege", 30);
        $form->setTaille("libelle", 30);
        $form->setTaille("adresse", 30);
        $form->setTaille("complement", 30);
        $form->setTaille("cp", 10);
        $form->setTaille("ville", 30);
        $form->setTaille("liste_diffusion", 80);
        $form->setTaille("accepte_notification_email", 1);
        $form->setTaille("uid_platau_acteur", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("tiers_consulte", 11);
        $form->setMax("categorie_tiers_consulte", 11);
        $form->setMax("abrege", 30);
        $form->setMax("libelle", 255);
        $form->setMax("adresse", 300);
        $form->setMax("complement", 300);
        $form->setMax("cp", 5);
        $form->setMax("ville", 255);
        $form->setMax("liste_diffusion", 6);
        $form->setMax("accepte_notification_email", 1);
        $form->setMax("uid_platau_acteur", 255);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('tiers_consulte', __('tiers_consulte'));
        $form->setLib('categorie_tiers_consulte', __('categorie_tiers_consulte'));
        $form->setLib('abrege', __('abrege'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('adresse', __('adresse'));
        $form->setLib('complement', __('complement'));
        $form->setLib('cp', __('cp'));
        $form->setLib('ville', __('ville'));
        $form->setLib('liste_diffusion', __('liste_diffusion'));
        $form->setLib('accepte_notification_email', __('accepte_notification_email'));
        $form->setLib('uid_platau_acteur', __('uid_platau_acteur'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // categorie_tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "categorie_tiers_consulte",
            $this->get_var_sql_forminc__sql("categorie_tiers_consulte"),
            $this->get_var_sql_forminc__sql("categorie_tiers_consulte_by_id"),
            true
        );
    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('categorie_tiers_consulte', $this->retourformulaire))
                $form->setVal('categorie_tiers_consulte', $idxformulaire);
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
        // Verification de la cle secondaire : consultation
        $this->rechercheTable($this->f->db, "consultation", "tiers_consulte", $id);
        // Verification de la cle secondaire : dossier_operateur
        $this->rechercheTable($this->f->db, "dossier_operateur", "operateur_designe", $id);
        // Verification de la cle secondaire : dossier_operateur
        $this->rechercheTable($this->f->db, "dossier_operateur", "operateur_detecte_inrap", $id);
        // Verification de la cle secondaire : dossier_operateur
        $this->rechercheTable($this->f->db, "dossier_operateur", "operateur_personne_publique", $id);
        // Verification de la cle secondaire : dossier_operateur
        $this->rechercheTable($this->f->db, "dossier_operateur", "operateur_selectionne", $id);
        // Verification de la cle secondaire : habilitation_tiers_consulte
        $this->rechercheTable($this->f->db, "habilitation_tiers_consulte", "tiers_consulte", $id);
        // Verification de la cle secondaire : lien_dossier_tiers
        $this->rechercheTable($this->f->db, "lien_dossier_tiers", "tiers", $id);
        // Verification de la cle secondaire : lien_om_utilisateur_tiers_consulte
        $this->rechercheTable($this->f->db, "lien_om_utilisateur_tiers_consulte", "tiers_consulte", $id);
    }


}
