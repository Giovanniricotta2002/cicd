<?php
//$Id$ 
//gen openMairie le 17/08/2023 19:55

require_once "../obj/om_dbform.class.php";

class architecte_gen extends om_dbform {

    protected $_absolute_class_name = "architecte";

    var $table = "architecte";
    var $clePrimaire = "architecte";
    var $typeCle = "N";
    var $required_field = array(
        "architecte",
        "nom"
    );
    
    var $foreign_keys_extended = array(
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("nom");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "architecte",
            "nom",
            "prenom",
            "adresse1",
            "adresse2",
            "cp",
            "ville",
            "pays",
            "inscription",
            "telephone",
            "fax",
            "email",
            "note",
            "frequent",
            "nom_cabinet",
            "conseil_regional",
            "lieu_dit",
            "boite_postale",
            "cedex",
            "titre_obt_diplo_spec",
            "date_obt_diplo_spec",
            "lieu_obt_diplo_spec",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['architecte'])) {
            $this->valF['architecte'] = ""; // -> requis
        } else {
            $this->valF['architecte'] = $val['architecte'];
        }
        $this->valF['nom'] = $val['nom'];
        if ($val['prenom'] == "") {
            $this->valF['prenom'] = ""; // -> default
        } else {
            $this->valF['prenom'] = $val['prenom'];
        }
        if ($val['adresse1'] == "") {
            $this->valF['adresse1'] = ""; // -> default
        } else {
            $this->valF['adresse1'] = $val['adresse1'];
        }
        if ($val['adresse2'] == "") {
            $this->valF['adresse2'] = ""; // -> default
        } else {
            $this->valF['adresse2'] = $val['adresse2'];
        }
        if ($val['cp'] == "") {
            $this->valF['cp'] = ""; // -> default
        } else {
            $this->valF['cp'] = $val['cp'];
        }
        if ($val['ville'] == "") {
            $this->valF['ville'] = ""; // -> default
        } else {
            $this->valF['ville'] = $val['ville'];
        }
        if ($val['pays'] == "") {
            $this->valF['pays'] = ""; // -> default
        } else {
            $this->valF['pays'] = $val['pays'];
        }
        if ($val['inscription'] == "") {
            $this->valF['inscription'] = ""; // -> default
        } else {
            $this->valF['inscription'] = $val['inscription'];
        }
        if ($val['telephone'] == "") {
            $this->valF['telephone'] = ""; // -> default
        } else {
            $this->valF['telephone'] = $val['telephone'];
        }
        if ($val['fax'] == "") {
            $this->valF['fax'] = ""; // -> default
        } else {
            $this->valF['fax'] = $val['fax'];
        }
        if ($val['email'] == "") {
            $this->valF['email'] = ""; // -> default
        } else {
            $this->valF['email'] = $val['email'];
        }
            $this->valF['note'] = $val['note'];
        if ($val['frequent'] == 1 || $val['frequent'] == "t" || $val['frequent'] == "Oui") {
            $this->valF['frequent'] = true;
        } else {
            $this->valF['frequent'] = false;
        }
        if ($val['nom_cabinet'] == "") {
            $this->valF['nom_cabinet'] = NULL;
        } else {
            $this->valF['nom_cabinet'] = $val['nom_cabinet'];
        }
        if ($val['conseil_regional'] == "") {
            $this->valF['conseil_regional'] = NULL;
        } else {
            $this->valF['conseil_regional'] = $val['conseil_regional'];
        }
        if ($val['lieu_dit'] == "") {
            $this->valF['lieu_dit'] = NULL;
        } else {
            $this->valF['lieu_dit'] = $val['lieu_dit'];
        }
        if ($val['boite_postale'] == "") {
            $this->valF['boite_postale'] = NULL;
        } else {
            $this->valF['boite_postale'] = $val['boite_postale'];
        }
        if ($val['cedex'] == "") {
            $this->valF['cedex'] = NULL;
        } else {
            $this->valF['cedex'] = $val['cedex'];
        }
            $this->valF['titre_obt_diplo_spec'] = $val['titre_obt_diplo_spec'];
        if ($val['date_obt_diplo_spec'] != "") {
            $this->valF['date_obt_diplo_spec'] = $this->dateDB($val['date_obt_diplo_spec']);
        } else {
            $this->valF['date_obt_diplo_spec'] = NULL;
        }
            $this->valF['lieu_obt_diplo_spec'] = $val['lieu_obt_diplo_spec'];
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
            $form->setType("architecte", "hidden");
            $form->setType("nom", "text");
            $form->setType("prenom", "text");
            $form->setType("adresse1", "text");
            $form->setType("adresse2", "text");
            $form->setType("cp", "text");
            $form->setType("ville", "text");
            $form->setType("pays", "text");
            $form->setType("inscription", "text");
            $form->setType("telephone", "text");
            $form->setType("fax", "text");
            $form->setType("email", "text");
            $form->setType("note", "textarea");
            $form->setType("frequent", "checkbox");
            $form->setType("nom_cabinet", "text");
            $form->setType("conseil_regional", "text");
            $form->setType("lieu_dit", "text");
            $form->setType("boite_postale", "text");
            $form->setType("cedex", "text");
            $form->setType("titre_obt_diplo_spec", "textarea");
            $form->setType("date_obt_diplo_spec", "date");
            $form->setType("lieu_obt_diplo_spec", "textarea");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("architecte", "hiddenstatic");
            $form->setType("nom", "text");
            $form->setType("prenom", "text");
            $form->setType("adresse1", "text");
            $form->setType("adresse2", "text");
            $form->setType("cp", "text");
            $form->setType("ville", "text");
            $form->setType("pays", "text");
            $form->setType("inscription", "text");
            $form->setType("telephone", "text");
            $form->setType("fax", "text");
            $form->setType("email", "text");
            $form->setType("note", "textarea");
            $form->setType("frequent", "checkbox");
            $form->setType("nom_cabinet", "text");
            $form->setType("conseil_regional", "text");
            $form->setType("lieu_dit", "text");
            $form->setType("boite_postale", "text");
            $form->setType("cedex", "text");
            $form->setType("titre_obt_diplo_spec", "textarea");
            $form->setType("date_obt_diplo_spec", "date");
            $form->setType("lieu_obt_diplo_spec", "textarea");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("architecte", "hiddenstatic");
            $form->setType("nom", "hiddenstatic");
            $form->setType("prenom", "hiddenstatic");
            $form->setType("adresse1", "hiddenstatic");
            $form->setType("adresse2", "hiddenstatic");
            $form->setType("cp", "hiddenstatic");
            $form->setType("ville", "hiddenstatic");
            $form->setType("pays", "hiddenstatic");
            $form->setType("inscription", "hiddenstatic");
            $form->setType("telephone", "hiddenstatic");
            $form->setType("fax", "hiddenstatic");
            $form->setType("email", "hiddenstatic");
            $form->setType("note", "hiddenstatic");
            $form->setType("frequent", "hiddenstatic");
            $form->setType("nom_cabinet", "hiddenstatic");
            $form->setType("conseil_regional", "hiddenstatic");
            $form->setType("lieu_dit", "hiddenstatic");
            $form->setType("boite_postale", "hiddenstatic");
            $form->setType("cedex", "hiddenstatic");
            $form->setType("titre_obt_diplo_spec", "hiddenstatic");
            $form->setType("date_obt_diplo_spec", "hiddenstatic");
            $form->setType("lieu_obt_diplo_spec", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("architecte", "static");
            $form->setType("nom", "static");
            $form->setType("prenom", "static");
            $form->setType("adresse1", "static");
            $form->setType("adresse2", "static");
            $form->setType("cp", "static");
            $form->setType("ville", "static");
            $form->setType("pays", "static");
            $form->setType("inscription", "static");
            $form->setType("telephone", "static");
            $form->setType("fax", "static");
            $form->setType("email", "static");
            $form->setType("note", "textareastatic");
            $form->setType("frequent", "checkboxstatic");
            $form->setType("nom_cabinet", "static");
            $form->setType("conseil_regional", "static");
            $form->setType("lieu_dit", "static");
            $form->setType("boite_postale", "static");
            $form->setType("cedex", "static");
            $form->setType("titre_obt_diplo_spec", "textareastatic");
            $form->setType("date_obt_diplo_spec", "datestatic");
            $form->setType("lieu_obt_diplo_spec", "textareastatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('architecte','VerifNum(this)');
        $form->setOnchange('date_obt_diplo_spec','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("architecte", 11);
        $form->setTaille("nom", 30);
        $form->setTaille("prenom", 30);
        $form->setTaille("adresse1", 30);
        $form->setTaille("adresse2", 30);
        $form->setTaille("cp", 10);
        $form->setTaille("ville", 30);
        $form->setTaille("pays", 30);
        $form->setTaille("inscription", 20);
        $form->setTaille("telephone", 20);
        $form->setTaille("fax", 14);
        $form->setTaille("email", 30);
        $form->setTaille("note", 80);
        $form->setTaille("frequent", 1);
        $form->setTaille("nom_cabinet", 30);
        $form->setTaille("conseil_regional", 30);
        $form->setTaille("lieu_dit", 30);
        $form->setTaille("boite_postale", 10);
        $form->setTaille("cedex", 10);
        $form->setTaille("titre_obt_diplo_spec", 80);
        $form->setTaille("date_obt_diplo_spec", 12);
        $form->setTaille("lieu_obt_diplo_spec", 80);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("architecte", 11);
        $form->setMax("nom", 50);
        $form->setMax("prenom", 50);
        $form->setMax("adresse1", 50);
        $form->setMax("adresse2", 50);
        $form->setMax("cp", 5);
        $form->setMax("ville", 50);
        $form->setMax("pays", 40);
        $form->setMax("inscription", 20);
        $form->setMax("telephone", 20);
        $form->setMax("fax", 14);
        $form->setMax("email", 60);
        $form->setMax("note", 6);
        $form->setMax("frequent", 1);
        $form->setMax("nom_cabinet", 100);
        $form->setMax("conseil_regional", 100);
        $form->setMax("lieu_dit", 39);
        $form->setMax("boite_postale", 5);
        $form->setMax("cedex", 5);
        $form->setMax("titre_obt_diplo_spec", 6);
        $form->setMax("date_obt_diplo_spec", 12);
        $form->setMax("lieu_obt_diplo_spec", 6);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('architecte', __('architecte'));
        $form->setLib('nom', __('nom'));
        $form->setLib('prenom', __('prenom'));
        $form->setLib('adresse1', __('adresse1'));
        $form->setLib('adresse2', __('adresse2'));
        $form->setLib('cp', __('cp'));
        $form->setLib('ville', __('ville'));
        $form->setLib('pays', __('pays'));
        $form->setLib('inscription', __('inscription'));
        $form->setLib('telephone', __('telephone'));
        $form->setLib('fax', __('fax'));
        $form->setLib('email', __('email'));
        $form->setLib('note', __('note'));
        $form->setLib('frequent', __('frequent'));
        $form->setLib('nom_cabinet', __('nom_cabinet'));
        $form->setLib('conseil_regional', __('conseil_regional'));
        $form->setLib('lieu_dit', __('lieu_dit'));
        $form->setLib('boite_postale', __('boite_postale'));
        $form->setLib('cedex', __('cedex'));
        $form->setLib('titre_obt_diplo_spec', __('titre_obt_diplo_spec'));
        $form->setLib('date_obt_diplo_spec', __('date_obt_diplo_spec'));
        $form->setLib('lieu_obt_diplo_spec', __('lieu_obt_diplo_spec'));
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
        // Verification de la cle secondaire : donnees_techniques
        $this->rechercheTable($this->f->db, "donnees_techniques", "architecte", $id);
    }


}
