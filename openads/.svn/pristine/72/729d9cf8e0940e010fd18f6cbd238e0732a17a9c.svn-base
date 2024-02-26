<?php
//$Id$ 
//gen openMairie le 03/05/2018 09:18

require_once "../obj/om_dbform.class.php";

class regle_gen extends om_dbform {

    protected $_absolute_class_name = "regle";

    var $table = "regle";
    var $clePrimaire = "regle";
    var $typeCle = "N";
    var $required_field = array(
        "champ",
        "message",
        "operateur",
        "ordre",
        "regle",
        "sens",
        "valeur"
    );
    
    var $foreign_keys_extended = array(
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("sens");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "regle",
            "sens",
            "ordre",
            "controle",
            "id",
            "champ",
            "operateur",
            "valeur",
            "message",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['regle'])) {
            $this->valF['regle'] = ""; // -> requis
        } else {
            $this->valF['regle'] = $val['regle'];
        }
        $this->valF['sens'] = $val['sens'];
        if (!is_numeric($val['ordre'])) {
            $this->valF['ordre'] = ""; // -> requis
        } else {
            $this->valF['ordre'] = $val['ordre'];
        }
        if ($val['controle'] == "") {
            $this->valF['controle'] = ""; // -> default
        } else {
            $this->valF['controle'] = $val['controle'];
        }
        if (!is_numeric($val['id'])) {
            $this->valF['id'] = 0; // -> default
        } else {
            $this->valF['id'] = $val['id'];
        }
        $this->valF['champ'] = $val['champ'];
        $this->valF['operateur'] = $val['operateur'];
        if (!is_numeric($val['valeur'])) {
            $this->valF['valeur'] = ""; // -> requis
        } else {
            $this->valF['valeur'] = $val['valeur'];
        }
        $this->valF['message'] = $val['message'];
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
            $form->setType("regle", "hidden");
            $form->setType("sens", "text");
            $form->setType("ordre", "text");
            $form->setType("controle", "text");
            $form->setType("id", "text");
            $form->setType("champ", "text");
            $form->setType("operateur", "text");
            $form->setType("valeur", "text");
            $form->setType("message", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("regle", "hiddenstatic");
            $form->setType("sens", "text");
            $form->setType("ordre", "text");
            $form->setType("controle", "text");
            $form->setType("id", "text");
            $form->setType("champ", "text");
            $form->setType("operateur", "text");
            $form->setType("valeur", "text");
            $form->setType("message", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("regle", "hiddenstatic");
            $form->setType("sens", "hiddenstatic");
            $form->setType("ordre", "hiddenstatic");
            $form->setType("controle", "hiddenstatic");
            $form->setType("id", "hiddenstatic");
            $form->setType("champ", "hiddenstatic");
            $form->setType("operateur", "hiddenstatic");
            $form->setType("valeur", "hiddenstatic");
            $form->setType("message", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("regle", "static");
            $form->setType("sens", "static");
            $form->setType("ordre", "static");
            $form->setType("controle", "static");
            $form->setType("id", "static");
            $form->setType("champ", "static");
            $form->setType("operateur", "static");
            $form->setType("valeur", "static");
            $form->setType("message", "static");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('regle','VerifNum(this)');
        $form->setOnchange('ordre','VerifNum(this)');
        $form->setOnchange('id','VerifNum(this)');
        $form->setOnchange('valeur','VerifFloat(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("regle", 11);
        $form->setTaille("sens", 10);
        $form->setTaille("ordre", 11);
        $form->setTaille("controle", 20);
        $form->setTaille("id", 11);
        $form->setTaille("champ", 30);
        $form->setTaille("operateur", 10);
        $form->setTaille("valeur", 20);
        $form->setTaille("message", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("regle", 11);
        $form->setMax("sens", 5);
        $form->setMax("ordre", 11);
        $form->setMax("controle", 20);
        $form->setMax("id", 11);
        $form->setMax("champ", 30);
        $form->setMax("operateur", 2);
        $form->setMax("valeur", 20);
        $form->setMax("message", 80);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('regle', __('regle'));
        $form->setLib('sens', __('sens'));
        $form->setLib('ordre', __('ordre'));
        $form->setLib('controle', __('controle'));
        $form->setLib('id', __('id'));
        $form->setLib('champ', __('champ'));
        $form->setLib('operateur', __('operateur'));
        $form->setLib('valeur', __('valeur'));
        $form->setLib('message', __('message'));
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
    

}
