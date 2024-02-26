<?php
//$Id$ 
//gen openMairie le 14/11/2022 17:45

require_once "../obj/om_dbform.class.php";

class om_collectivite_gen extends om_dbform {

    protected $_absolute_class_name = "om_collectivite";

    var $table = "om_collectivite";
    var $clePrimaire = "om_collectivite";
    var $typeCle = "N";
    var $required_field = array(
        "libelle",
        "niveau",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
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
            "om_collectivite",
            "libelle",
            "niveau",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['om_collectivite'])) {
            $this->valF['om_collectivite'] = ""; // -> requis
        } else {
            if($_SESSION['niveau']==1) {
                $this->valF['om_collectivite'] = $_SESSION['collectivite'];
            } else {
                $this->valF['om_collectivite'] = $val['om_collectivite'];
            }
        }
        $this->valF['libelle'] = $val['libelle'];
        $this->valF['niveau'] = $val['niveau'];
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
            $form->setType("om_collectivite", "hidden");
            $form->setType("libelle", "text");
            $form->setType("niveau", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("om_collectivite", "hiddenstatic");
            $form->setType("libelle", "text");
            $form->setType("niveau", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("om_collectivite", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("niveau", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("om_collectivite", "static");
            $form->setType("libelle", "static");
            $form->setType("niveau", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('om_collectivite','VerifNum(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("libelle", 30);
        $form->setTaille("niveau", 10);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("om_collectivite", 11);
        $form->setMax("libelle", 100);
        $form->setMax("niveau", 1);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('niveau', __('niveau'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

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
        // Verification de la cle secondaire : affectation_automatique
        $this->rechercheTable($this->f->db, "affectation_automatique", "om_collectivite", $id);
        // Verification de la cle secondaire : bible
        $this->rechercheTable($this->f->db, "bible", "om_collectivite", $id);
        // Verification de la cle secondaire : commission
        $this->rechercheTable($this->f->db, "commission", "om_collectivite", $id);
        // Verification de la cle secondaire : commission_type
        $this->rechercheTable($this->f->db, "commission_type", "om_collectivite", $id);
        // Verification de la cle secondaire : compteur
        $this->rechercheTable($this->f->db, "compteur", "om_collectivite", $id);
        // Verification de la cle secondaire : contrainte
        $this->rechercheTable($this->f->db, "contrainte", "om_collectivite", $id);
        // Verification de la cle secondaire : demande
        $this->rechercheTable($this->f->db, "demande", "om_collectivite", $id);
        // Verification de la cle secondaire : demandeur
        $this->rechercheTable($this->f->db, "demandeur", "om_collectivite", $id);
        // Verification de la cle secondaire : direction
        $this->rechercheTable($this->f->db, "direction", "om_collectivite", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "om_collectivite", $id);
        // Verification de la cle secondaire : dossier_autorisation
        $this->rechercheTable($this->f->db, "dossier_autorisation", "om_collectivite", $id);
        // Verification de la cle secondaire : lien_categorie_tiers_consulte_om_collectivite
        $this->rechercheTable($this->f->db, "lien_categorie_tiers_consulte_om_collectivite", "om_collectivite", $id);
        // Verification de la cle secondaire : lien_motif_consultation_om_collectivite
        $this->rechercheTable($this->f->db, "lien_motif_consultation_om_collectivite", "om_collectivite", $id);
        // Verification de la cle secondaire : lien_sig_contrainte_om_collectivite
        $this->rechercheTable($this->f->db, "lien_sig_contrainte_om_collectivite", "om_collectivite", $id);
        // Verification de la cle secondaire : num_bordereau
        $this->rechercheTable($this->f->db, "num_bordereau", "om_collectivite", $id);
        // Verification de la cle secondaire : num_dossier
        $this->rechercheTable($this->f->db, "num_dossier", "om_collectivite", $id);
        // Verification de la cle secondaire : om_etat
        $this->rechercheTable($this->f->db, "om_etat", "om_collectivite", $id);
        // Verification de la cle secondaire : om_lettretype
        $this->rechercheTable($this->f->db, "om_lettretype", "om_collectivite", $id);
        // Verification de la cle secondaire : om_logo
        $this->rechercheTable($this->f->db, "om_logo", "om_collectivite", $id);
        // Verification de la cle secondaire : om_parametre
        $this->rechercheTable($this->f->db, "om_parametre", "om_collectivite", $id);
        // Verification de la cle secondaire : om_sig_flux
        $this->rechercheTable($this->f->db, "om_sig_flux", "om_collectivite", $id);
        // Verification de la cle secondaire : om_sig_map
        $this->rechercheTable($this->f->db, "om_sig_map", "om_collectivite", $id);
        // Verification de la cle secondaire : om_sousetat
        $this->rechercheTable($this->f->db, "om_sousetat", "om_collectivite", $id);
        // Verification de la cle secondaire : om_utilisateur
        $this->rechercheTable($this->f->db, "om_utilisateur", "om_collectivite", $id);
        // Verification de la cle secondaire : service
        $this->rechercheTable($this->f->db, "service", "om_collectivite", $id);
        // Verification de la cle secondaire : signataire_arrete
        $this->rechercheTable($this->f->db, "signataire_arrete", "om_collectivite", $id);
        // Verification de la cle secondaire : storage
        $this->rechercheTable($this->f->db, "storage", "om_collectivite", $id);
        // Verification de la cle secondaire : taxe_amenagement
        $this->rechercheTable($this->f->db, "taxe_amenagement", "om_collectivite", $id);
    }


}
