<?php
//$Id$ 
//gen openMairie le 23/08/2023 11:44

require_once "../obj/om_dbform.class.php";

class demandeur_gen extends om_dbform {

    protected $_absolute_class_name = "demandeur";

    var $table = "demandeur";
    var $clePrimaire = "demandeur";
    var $typeCle = "N";
    var $required_field = array(
        "demandeur",
        "om_collectivite"
    );
    
    var $foreign_keys_extended = array(
        "om_collectivite" => array("om_collectivite", ),
        "civilite" => array("civilite", ),
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("type_demandeur");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "demandeur",
            "type_demandeur",
            "qualite",
            "particulier_nom",
            "particulier_prenom",
            "particulier_date_naissance",
            "particulier_commune_naissance",
            "particulier_departement_naissance",
            "personne_morale_denomination",
            "personne_morale_raison_sociale",
            "personne_morale_siret",
            "personne_morale_categorie_juridique",
            "personne_morale_nom",
            "personne_morale_prenom",
            "numero",
            "voie",
            "complement",
            "lieu_dit",
            "localite",
            "code_postal",
            "bp",
            "cedex",
            "pays",
            "division_territoriale",
            "telephone_fixe",
            "telephone_mobile",
            "indicatif",
            "courriel",
            "notification",
            "frequent",
            "particulier_civilite",
            "personne_morale_civilite",
            "fax",
            "om_collectivite",
            "particulier_pays_naissance",
            "num_inscription",
            "nom_cabinet",
            "conseil_regional",
            "titre_obt_diplo_spec",
            "date_obt_diplo_spec",
            "lieu_obt_diplo_spec",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite ORDER BY om_collectivite.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite_by_id() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite WHERE om_collectivite = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_particulier_civilite() {
        return "SELECT civilite.civilite, civilite.libelle FROM ".DB_PREFIXE."civilite WHERE ((civilite.om_validite_debut IS NULL AND (civilite.om_validite_fin IS NULL OR civilite.om_validite_fin > CURRENT_DATE)) OR (civilite.om_validite_debut <= CURRENT_DATE AND (civilite.om_validite_fin IS NULL OR civilite.om_validite_fin > CURRENT_DATE))) ORDER BY civilite.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_particulier_civilite_by_id() {
        return "SELECT civilite.civilite, civilite.libelle FROM ".DB_PREFIXE."civilite WHERE civilite = '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_personne_morale_civilite() {
        return "SELECT civilite.civilite, civilite.libelle FROM ".DB_PREFIXE."civilite WHERE ((civilite.om_validite_debut IS NULL AND (civilite.om_validite_fin IS NULL OR civilite.om_validite_fin > CURRENT_DATE)) OR (civilite.om_validite_debut <= CURRENT_DATE AND (civilite.om_validite_fin IS NULL OR civilite.om_validite_fin > CURRENT_DATE))) ORDER BY civilite.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_personne_morale_civilite_by_id() {
        return "SELECT civilite.civilite, civilite.libelle FROM ".DB_PREFIXE."civilite WHERE civilite = '<idx>'";
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        if (!is_numeric($val['demandeur'])) {
            $this->valF['demandeur'] = ""; // -> requis
        } else {
            $this->valF['demandeur'] = $val['demandeur'];
        }
        if ($val['type_demandeur'] == "") {
            $this->valF['type_demandeur'] = NULL;
        } else {
            $this->valF['type_demandeur'] = $val['type_demandeur'];
        }
        if ($val['qualite'] == "") {
            $this->valF['qualite'] = NULL;
        } else {
            $this->valF['qualite'] = $val['qualite'];
        }
        if ($val['particulier_nom'] == "") {
            $this->valF['particulier_nom'] = NULL;
        } else {
            $this->valF['particulier_nom'] = $val['particulier_nom'];
        }
        if ($val['particulier_prenom'] == "") {
            $this->valF['particulier_prenom'] = NULL;
        } else {
            $this->valF['particulier_prenom'] = $val['particulier_prenom'];
        }
        if ($val['particulier_date_naissance'] != "") {
            $this->valF['particulier_date_naissance'] = $this->dateDB($val['particulier_date_naissance']);
        } else {
            $this->valF['particulier_date_naissance'] = NULL;
        }
        if ($val['particulier_commune_naissance'] == "") {
            $this->valF['particulier_commune_naissance'] = NULL;
        } else {
            $this->valF['particulier_commune_naissance'] = $val['particulier_commune_naissance'];
        }
        if ($val['particulier_departement_naissance'] == "") {
            $this->valF['particulier_departement_naissance'] = NULL;
        } else {
            $this->valF['particulier_departement_naissance'] = $val['particulier_departement_naissance'];
        }
        if ($val['personne_morale_denomination'] == "") {
            $this->valF['personne_morale_denomination'] = NULL;
        } else {
            $this->valF['personne_morale_denomination'] = $val['personne_morale_denomination'];
        }
        if ($val['personne_morale_raison_sociale'] == "") {
            $this->valF['personne_morale_raison_sociale'] = NULL;
        } else {
            $this->valF['personne_morale_raison_sociale'] = $val['personne_morale_raison_sociale'];
        }
        if ($val['personne_morale_siret'] == "") {
            $this->valF['personne_morale_siret'] = NULL;
        } else {
            $this->valF['personne_morale_siret'] = $val['personne_morale_siret'];
        }
        if ($val['personne_morale_categorie_juridique'] == "") {
            $this->valF['personne_morale_categorie_juridique'] = NULL;
        } else {
            $this->valF['personne_morale_categorie_juridique'] = $val['personne_morale_categorie_juridique'];
        }
        if ($val['personne_morale_nom'] == "") {
            $this->valF['personne_morale_nom'] = NULL;
        } else {
            $this->valF['personne_morale_nom'] = $val['personne_morale_nom'];
        }
        if ($val['personne_morale_prenom'] == "") {
            $this->valF['personne_morale_prenom'] = NULL;
        } else {
            $this->valF['personne_morale_prenom'] = $val['personne_morale_prenom'];
        }
        if ($val['numero'] == "") {
            $this->valF['numero'] = NULL;
        } else {
            $this->valF['numero'] = $val['numero'];
        }
        if ($val['voie'] == "") {
            $this->valF['voie'] = NULL;
        } else {
            $this->valF['voie'] = $val['voie'];
        }
        if ($val['complement'] == "") {
            $this->valF['complement'] = NULL;
        } else {
            $this->valF['complement'] = $val['complement'];
        }
        if ($val['lieu_dit'] == "") {
            $this->valF['lieu_dit'] = NULL;
        } else {
            $this->valF['lieu_dit'] = $val['lieu_dit'];
        }
        if ($val['localite'] == "") {
            $this->valF['localite'] = NULL;
        } else {
            $this->valF['localite'] = $val['localite'];
        }
        if ($val['code_postal'] == "") {
            $this->valF['code_postal'] = NULL;
        } else {
            $this->valF['code_postal'] = $val['code_postal'];
        }
        if ($val['bp'] == "") {
            $this->valF['bp'] = NULL;
        } else {
            $this->valF['bp'] = $val['bp'];
        }
        if ($val['cedex'] == "") {
            $this->valF['cedex'] = NULL;
        } else {
            $this->valF['cedex'] = $val['cedex'];
        }
        if ($val['pays'] == "") {
            $this->valF['pays'] = NULL;
        } else {
            $this->valF['pays'] = $val['pays'];
        }
        if ($val['division_territoriale'] == "") {
            $this->valF['division_territoriale'] = NULL;
        } else {
            $this->valF['division_territoriale'] = $val['division_territoriale'];
        }
        if ($val['telephone_fixe'] == "") {
            $this->valF['telephone_fixe'] = NULL;
        } else {
            $this->valF['telephone_fixe'] = $val['telephone_fixe'];
        }
        if ($val['telephone_mobile'] == "") {
            $this->valF['telephone_mobile'] = NULL;
        } else {
            $this->valF['telephone_mobile'] = $val['telephone_mobile'];
        }
        if ($val['indicatif'] == "") {
            $this->valF['indicatif'] = NULL;
        } else {
            $this->valF['indicatif'] = $val['indicatif'];
        }
        if ($val['courriel'] == "") {
            $this->valF['courriel'] = NULL;
        } else {
            $this->valF['courriel'] = $val['courriel'];
        }
        if ($val['notification'] == 1 || $val['notification'] == "t" || $val['notification'] == "Oui") {
            $this->valF['notification'] = true;
        } else {
            $this->valF['notification'] = false;
        }
        if ($val['frequent'] == 1 || $val['frequent'] == "t" || $val['frequent'] == "Oui") {
            $this->valF['frequent'] = true;
        } else {
            $this->valF['frequent'] = false;
        }
        if (!is_numeric($val['particulier_civilite'])) {
            $this->valF['particulier_civilite'] = NULL;
        } else {
            $this->valF['particulier_civilite'] = $val['particulier_civilite'];
        }
        if (!is_numeric($val['personne_morale_civilite'])) {
            $this->valF['personne_morale_civilite'] = NULL;
        } else {
            $this->valF['personne_morale_civilite'] = $val['personne_morale_civilite'];
        }
        if ($val['fax'] == "") {
            $this->valF['fax'] = NULL;
        } else {
            $this->valF['fax'] = $val['fax'];
        }
        if (!is_numeric($val['om_collectivite'])) {
            $this->valF['om_collectivite'] = ""; // -> requis
        } else {
            if($_SESSION['niveau']==1) {
                $this->valF['om_collectivite'] = $_SESSION['collectivite'];
            } else {
                $this->valF['om_collectivite'] = $val['om_collectivite'];
            }
        }
        if ($val['particulier_pays_naissance'] == "") {
            $this->valF['particulier_pays_naissance'] = NULL;
        } else {
            $this->valF['particulier_pays_naissance'] = $val['particulier_pays_naissance'];
        }
        if ($val['num_inscription'] == "") {
            $this->valF['num_inscription'] = NULL;
        } else {
            $this->valF['num_inscription'] = $val['num_inscription'];
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
            $form->setType("demandeur", "hidden");
            $form->setType("type_demandeur", "text");
            $form->setType("qualite", "text");
            $form->setType("particulier_nom", "text");
            $form->setType("particulier_prenom", "text");
            $form->setType("particulier_date_naissance", "date");
            $form->setType("particulier_commune_naissance", "text");
            $form->setType("particulier_departement_naissance", "text");
            $form->setType("personne_morale_denomination", "text");
            $form->setType("personne_morale_raison_sociale", "text");
            $form->setType("personne_morale_siret", "text");
            $form->setType("personne_morale_categorie_juridique", "text");
            $form->setType("personne_morale_nom", "text");
            $form->setType("personne_morale_prenom", "text");
            $form->setType("numero", "text");
            $form->setType("voie", "text");
            $form->setType("complement", "text");
            $form->setType("lieu_dit", "text");
            $form->setType("localite", "text");
            $form->setType("code_postal", "text");
            $form->setType("bp", "text");
            $form->setType("cedex", "text");
            $form->setType("pays", "text");
            $form->setType("division_territoriale", "text");
            $form->setType("telephone_fixe", "text");
            $form->setType("telephone_mobile", "text");
            $form->setType("indicatif", "text");
            $form->setType("courriel", "text");
            $form->setType("notification", "checkbox");
            $form->setType("frequent", "checkbox");
            if ($this->is_in_context_of_foreign_key("civilite", $this->retourformulaire)) {
                $form->setType("particulier_civilite", "selecthiddenstatic");
            } else {
                $form->setType("particulier_civilite", "select");
            }
            if ($this->is_in_context_of_foreign_key("civilite", $this->retourformulaire)) {
                $form->setType("personne_morale_civilite", "selecthiddenstatic");
            } else {
                $form->setType("personne_morale_civilite", "select");
            }
            $form->setType("fax", "text");
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selecthiddenstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "select");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("particulier_pays_naissance", "text");
            $form->setType("num_inscription", "text");
            $form->setType("nom_cabinet", "text");
            $form->setType("conseil_regional", "text");
            $form->setType("titre_obt_diplo_spec", "textarea");
            $form->setType("date_obt_diplo_spec", "date");
            $form->setType("lieu_obt_diplo_spec", "textarea");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("demandeur", "hiddenstatic");
            $form->setType("type_demandeur", "text");
            $form->setType("qualite", "text");
            $form->setType("particulier_nom", "text");
            $form->setType("particulier_prenom", "text");
            $form->setType("particulier_date_naissance", "date");
            $form->setType("particulier_commune_naissance", "text");
            $form->setType("particulier_departement_naissance", "text");
            $form->setType("personne_morale_denomination", "text");
            $form->setType("personne_morale_raison_sociale", "text");
            $form->setType("personne_morale_siret", "text");
            $form->setType("personne_morale_categorie_juridique", "text");
            $form->setType("personne_morale_nom", "text");
            $form->setType("personne_morale_prenom", "text");
            $form->setType("numero", "text");
            $form->setType("voie", "text");
            $form->setType("complement", "text");
            $form->setType("lieu_dit", "text");
            $form->setType("localite", "text");
            $form->setType("code_postal", "text");
            $form->setType("bp", "text");
            $form->setType("cedex", "text");
            $form->setType("pays", "text");
            $form->setType("division_territoriale", "text");
            $form->setType("telephone_fixe", "text");
            $form->setType("telephone_mobile", "text");
            $form->setType("indicatif", "text");
            $form->setType("courriel", "text");
            $form->setType("notification", "checkbox");
            $form->setType("frequent", "checkbox");
            if ($this->is_in_context_of_foreign_key("civilite", $this->retourformulaire)) {
                $form->setType("particulier_civilite", "selecthiddenstatic");
            } else {
                $form->setType("particulier_civilite", "select");
            }
            if ($this->is_in_context_of_foreign_key("civilite", $this->retourformulaire)) {
                $form->setType("personne_morale_civilite", "selecthiddenstatic");
            } else {
                $form->setType("personne_morale_civilite", "select");
            }
            $form->setType("fax", "text");
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selecthiddenstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "select");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("particulier_pays_naissance", "text");
            $form->setType("num_inscription", "text");
            $form->setType("nom_cabinet", "text");
            $form->setType("conseil_regional", "text");
            $form->setType("titre_obt_diplo_spec", "textarea");
            $form->setType("date_obt_diplo_spec", "date");
            $form->setType("lieu_obt_diplo_spec", "textarea");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("demandeur", "hiddenstatic");
            $form->setType("type_demandeur", "hiddenstatic");
            $form->setType("qualite", "hiddenstatic");
            $form->setType("particulier_nom", "hiddenstatic");
            $form->setType("particulier_prenom", "hiddenstatic");
            $form->setType("particulier_date_naissance", "hiddenstatic");
            $form->setType("particulier_commune_naissance", "hiddenstatic");
            $form->setType("particulier_departement_naissance", "hiddenstatic");
            $form->setType("personne_morale_denomination", "hiddenstatic");
            $form->setType("personne_morale_raison_sociale", "hiddenstatic");
            $form->setType("personne_morale_siret", "hiddenstatic");
            $form->setType("personne_morale_categorie_juridique", "hiddenstatic");
            $form->setType("personne_morale_nom", "hiddenstatic");
            $form->setType("personne_morale_prenom", "hiddenstatic");
            $form->setType("numero", "hiddenstatic");
            $form->setType("voie", "hiddenstatic");
            $form->setType("complement", "hiddenstatic");
            $form->setType("lieu_dit", "hiddenstatic");
            $form->setType("localite", "hiddenstatic");
            $form->setType("code_postal", "hiddenstatic");
            $form->setType("bp", "hiddenstatic");
            $form->setType("cedex", "hiddenstatic");
            $form->setType("pays", "hiddenstatic");
            $form->setType("division_territoriale", "hiddenstatic");
            $form->setType("telephone_fixe", "hiddenstatic");
            $form->setType("telephone_mobile", "hiddenstatic");
            $form->setType("indicatif", "hiddenstatic");
            $form->setType("courriel", "hiddenstatic");
            $form->setType("notification", "hiddenstatic");
            $form->setType("frequent", "hiddenstatic");
            $form->setType("particulier_civilite", "selectstatic");
            $form->setType("personne_morale_civilite", "selectstatic");
            $form->setType("fax", "hiddenstatic");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selectstatic");
            } else {
                $form->setType("om_collectivite", "hidden");
            }
            $form->setType("particulier_pays_naissance", "hiddenstatic");
            $form->setType("num_inscription", "hiddenstatic");
            $form->setType("nom_cabinet", "hiddenstatic");
            $form->setType("conseil_regional", "hiddenstatic");
            $form->setType("titre_obt_diplo_spec", "hiddenstatic");
            $form->setType("date_obt_diplo_spec", "hiddenstatic");
            $form->setType("lieu_obt_diplo_spec", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("demandeur", "static");
            $form->setType("type_demandeur", "static");
            $form->setType("qualite", "static");
            $form->setType("particulier_nom", "static");
            $form->setType("particulier_prenom", "static");
            $form->setType("particulier_date_naissance", "datestatic");
            $form->setType("particulier_commune_naissance", "static");
            $form->setType("particulier_departement_naissance", "static");
            $form->setType("personne_morale_denomination", "static");
            $form->setType("personne_morale_raison_sociale", "static");
            $form->setType("personne_morale_siret", "static");
            $form->setType("personne_morale_categorie_juridique", "static");
            $form->setType("personne_morale_nom", "static");
            $form->setType("personne_morale_prenom", "static");
            $form->setType("numero", "static");
            $form->setType("voie", "static");
            $form->setType("complement", "static");
            $form->setType("lieu_dit", "static");
            $form->setType("localite", "static");
            $form->setType("code_postal", "static");
            $form->setType("bp", "static");
            $form->setType("cedex", "static");
            $form->setType("pays", "static");
            $form->setType("division_territoriale", "static");
            $form->setType("telephone_fixe", "static");
            $form->setType("telephone_mobile", "static");
            $form->setType("indicatif", "static");
            $form->setType("courriel", "static");
            $form->setType("notification", "checkboxstatic");
            $form->setType("frequent", "checkboxstatic");
            $form->setType("particulier_civilite", "selectstatic");
            $form->setType("personne_morale_civilite", "selectstatic");
            $form->setType("fax", "static");
            if ($this->is_in_context_of_foreign_key("om_collectivite", $this->retourformulaire)) {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selectstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            } else {
                if($_SESSION["niveau"] == 2) {
                    $form->setType("om_collectivite", "selectstatic");
                } else {
                    $form->setType("om_collectivite", "hidden");
                }
            }
            $form->setType("particulier_pays_naissance", "static");
            $form->setType("num_inscription", "static");
            $form->setType("nom_cabinet", "static");
            $form->setType("conseil_regional", "static");
            $form->setType("titre_obt_diplo_spec", "textareastatic");
            $form->setType("date_obt_diplo_spec", "datestatic");
            $form->setType("lieu_obt_diplo_spec", "textareastatic");
        }

    }


    function setOnchange(&$form, $maj) {
    //javascript controle client
        $form->setOnchange('demandeur','VerifNum(this)');
        $form->setOnchange('particulier_date_naissance','fdate(this)');
        $form->setOnchange('particulier_civilite','VerifNum(this)');
        $form->setOnchange('personne_morale_civilite','VerifNum(this)');
        $form->setOnchange('om_collectivite','VerifNum(this)');
        $form->setOnchange('date_obt_diplo_spec','fdate(this)');
    }
    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("demandeur", 11);
        $form->setTaille("type_demandeur", 30);
        $form->setTaille("qualite", 30);
        $form->setTaille("particulier_nom", 30);
        $form->setTaille("particulier_prenom", 30);
        $form->setTaille("particulier_date_naissance", 12);
        $form->setTaille("particulier_commune_naissance", 30);
        $form->setTaille("particulier_departement_naissance", 30);
        $form->setTaille("personne_morale_denomination", 30);
        $form->setTaille("personne_morale_raison_sociale", 30);
        $form->setTaille("personne_morale_siret", 15);
        $form->setTaille("personne_morale_categorie_juridique", 15);
        $form->setTaille("personne_morale_nom", 30);
        $form->setTaille("personne_morale_prenom", 30);
        $form->setTaille("numero", 10);
        $form->setTaille("voie", 30);
        $form->setTaille("complement", 30);
        $form->setTaille("lieu_dit", 30);
        $form->setTaille("localite", 30);
        $form->setTaille("code_postal", 10);
        $form->setTaille("bp", 10);
        $form->setTaille("cedex", 10);
        $form->setTaille("pays", 30);
        $form->setTaille("division_territoriale", 30);
        $form->setTaille("telephone_fixe", 20);
        $form->setTaille("telephone_mobile", 20);
        $form->setTaille("indicatif", 10);
        $form->setTaille("courriel", 30);
        $form->setTaille("notification", 1);
        $form->setTaille("frequent", 1);
        $form->setTaille("particulier_civilite", 11);
        $form->setTaille("personne_morale_civilite", 11);
        $form->setTaille("fax", 20);
        $form->setTaille("om_collectivite", 11);
        $form->setTaille("particulier_pays_naissance", 30);
        $form->setTaille("num_inscription", 20);
        $form->setTaille("nom_cabinet", 30);
        $form->setTaille("conseil_regional", 30);
        $form->setTaille("titre_obt_diplo_spec", 80);
        $form->setTaille("date_obt_diplo_spec", 12);
        $form->setTaille("lieu_obt_diplo_spec", 80);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("demandeur", 11);
        $form->setMax("type_demandeur", 40);
        $form->setMax("qualite", 40);
        $form->setMax("particulier_nom", 100);
        $form->setMax("particulier_prenom", 50);
        $form->setMax("particulier_date_naissance", 12);
        $form->setMax("particulier_commune_naissance", 30);
        $form->setMax("particulier_departement_naissance", 80);
        $form->setMax("personne_morale_denomination", 40);
        $form->setMax("personne_morale_raison_sociale", 50);
        $form->setMax("personne_morale_siret", 15);
        $form->setMax("personne_morale_categorie_juridique", 15);
        $form->setMax("personne_morale_nom", 50);
        $form->setMax("personne_morale_prenom", 50);
        $form->setMax("numero", 10);
        $form->setMax("voie", 55);
        $form->setMax("complement", 50);
        $form->setMax("lieu_dit", 39);
        $form->setMax("localite", 250);
        $form->setMax("code_postal", 5);
        $form->setMax("bp", 5);
        $form->setMax("cedex", 5);
        $form->setMax("pays", 40);
        $form->setMax("division_territoriale", 40);
        $form->setMax("telephone_fixe", 20);
        $form->setMax("telephone_mobile", 20);
        $form->setMax("indicatif", 5);
        $form->setMax("courriel", 60);
        $form->setMax("notification", 1);
        $form->setMax("frequent", 1);
        $form->setMax("particulier_civilite", 11);
        $form->setMax("personne_morale_civilite", 11);
        $form->setMax("fax", 20);
        $form->setMax("om_collectivite", 11);
        $form->setMax("particulier_pays_naissance", 250);
        $form->setMax("num_inscription", 20);
        $form->setMax("nom_cabinet", 100);
        $form->setMax("conseil_regional", 100);
        $form->setMax("titre_obt_diplo_spec", 6);
        $form->setMax("date_obt_diplo_spec", 12);
        $form->setMax("lieu_obt_diplo_spec", 6);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('demandeur', __('demandeur'));
        $form->setLib('type_demandeur', __('type_demandeur'));
        $form->setLib('qualite', __('qualite'));
        $form->setLib('particulier_nom', __('particulier_nom'));
        $form->setLib('particulier_prenom', __('particulier_prenom'));
        $form->setLib('particulier_date_naissance', __('particulier_date_naissance'));
        $form->setLib('particulier_commune_naissance', __('particulier_commune_naissance'));
        $form->setLib('particulier_departement_naissance', __('particulier_departement_naissance'));
        $form->setLib('personne_morale_denomination', __('personne_morale_denomination'));
        $form->setLib('personne_morale_raison_sociale', __('personne_morale_raison_sociale'));
        $form->setLib('personne_morale_siret', __('personne_morale_siret'));
        $form->setLib('personne_morale_categorie_juridique', __('personne_morale_categorie_juridique'));
        $form->setLib('personne_morale_nom', __('personne_morale_nom'));
        $form->setLib('personne_morale_prenom', __('personne_morale_prenom'));
        $form->setLib('numero', __('numero'));
        $form->setLib('voie', __('voie'));
        $form->setLib('complement', __('complement'));
        $form->setLib('lieu_dit', __('lieu_dit'));
        $form->setLib('localite', __('localite'));
        $form->setLib('code_postal', __('code_postal'));
        $form->setLib('bp', __('bp'));
        $form->setLib('cedex', __('cedex'));
        $form->setLib('pays', __('pays'));
        $form->setLib('division_territoriale', __('division_territoriale'));
        $form->setLib('telephone_fixe', __('telephone_fixe'));
        $form->setLib('telephone_mobile', __('telephone_mobile'));
        $form->setLib('indicatif', __('indicatif'));
        $form->setLib('courriel', __('courriel'));
        $form->setLib('notification', __('notification'));
        $form->setLib('frequent', __('frequent'));
        $form->setLib('particulier_civilite', __('particulier_civilite'));
        $form->setLib('personne_morale_civilite', __('personne_morale_civilite'));
        $form->setLib('fax', __('fax'));
        $form->setLib('om_collectivite', __('om_collectivite'));
        $form->setLib('particulier_pays_naissance', __('particulier_pays_naissance'));
        $form->setLib('num_inscription', __('num_inscription'));
        $form->setLib('nom_cabinet', __('nom_cabinet'));
        $form->setLib('conseil_regional', __('conseil_regional'));
        $form->setLib('titre_obt_diplo_spec', __('titre_obt_diplo_spec'));
        $form->setLib('date_obt_diplo_spec', __('date_obt_diplo_spec'));
        $form->setLib('lieu_obt_diplo_spec', __('lieu_obt_diplo_spec'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

        // om_collectivite
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "om_collectivite",
            $this->get_var_sql_forminc__sql("om_collectivite"),
            $this->get_var_sql_forminc__sql("om_collectivite_by_id"),
            false
        );
        // particulier_civilite
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "particulier_civilite",
            $this->get_var_sql_forminc__sql("particulier_civilite"),
            $this->get_var_sql_forminc__sql("particulier_civilite_by_id"),
            true
        );
        // personne_morale_civilite
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "personne_morale_civilite",
            $this->get_var_sql_forminc__sql("personne_morale_civilite"),
            $this->get_var_sql_forminc__sql("personne_morale_civilite_by_id"),
            true
        );
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
        if($validation==0 and $maj==0 and $_SESSION['niveau']==1) {
            $form->setVal('om_collectivite', $_SESSION['collectivite']);
        }// fin validation
        if($validation == 0) {
            if($this->is_in_context_of_foreign_key('om_collectivite', $this->retourformulaire))
                $form->setVal('om_collectivite', $idxformulaire);
        }// fin validation
        if ($validation == 0 and $maj == 0) {
            if($this->is_in_context_of_foreign_key('civilite', $this->retourformulaire))
                $form->setVal('particulier_civilite', $idxformulaire);
            if($this->is_in_context_of_foreign_key('civilite', $this->retourformulaire))
                $form->setVal('personne_morale_civilite', $idxformulaire);
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
        // Verification de la cle secondaire : lien_demande_demandeur
        $this->rechercheTable($this->f->db, "lien_demande_demandeur", "demandeur", $id);
        // Verification de la cle secondaire : lien_dossier_autorisation_demandeur
        $this->rechercheTable($this->f->db, "lien_dossier_autorisation_demandeur", "demandeur", $id);
        // Verification de la cle secondaire : lien_dossier_demandeur
        $this->rechercheTable($this->f->db, "lien_dossier_demandeur", "demandeur", $id);
        // Verification de la cle secondaire : lien_lot_demandeur
        $this->rechercheTable($this->f->db, "lien_lot_demandeur", "demandeur", $id);
    }


}
