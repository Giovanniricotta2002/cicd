<?php
//$Id$ 
//gen openMairie le 30/11/2020 15:48

require_once "../obj/om_dbform.class.php";

class etat_gen extends om_dbform {

    protected $_absolute_class_name = "etat";

    var $table = "etat";
    var $clePrimaire = "etat";
    var $typeCle = "A";
    var $required_field = array(
        "etat",
        "libelle"
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
            "etat",
            "libelle",
            "statut",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        $this->valF['etat'] = $val['etat'];
        $this->valF['libelle'] = $val['libelle'];
        if ($val['statut'] == "") {
            $this->valF['statut'] = NULL;
        } else {
            $this->valF['statut'] = $val['statut'];
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
            $form->setType("etat", "text");
            $form->setType("libelle", "text");
            $form->setType("statut", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("etat", "hiddenstatic");
            $form->setType("libelle", "text");
            $form->setType("statut", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("etat", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("statut", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("etat", "static");
            $form->setType("libelle", "static");
            $form->setType("statut", "static");
        }

    }

    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("etat", 30);
        $form->setTaille("libelle", 30);
        $form->setTaille("statut", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("etat", 150);
        $form->setMax("libelle", 50);
        $form->setMax("statut", 60);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('etat', __('etat'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('statut', __('statut'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

    }


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
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "etat", $id);
        // Verification de la cle secondaire : dossier
        $this->rechercheTable($this->f->db, "dossier", "etat_pendant_incompletude", $id);
        // Verification de la cle secondaire : evenement
        $this->rechercheTable($this->f->db, "evenement", "etat", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "archive_etat_pendant_incompletude", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "etat", $id);
        // Verification de la cle secondaire : lien_demande_type_etat
        $this->rechercheTable($this->f->db, "lien_demande_type_etat", "etat", $id);
        // Verification de la cle secondaire : transition
        $this->rechercheTable($this->f->db, "transition", "etat", $id);
    }


}
