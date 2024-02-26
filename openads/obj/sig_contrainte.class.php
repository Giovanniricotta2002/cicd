<?php
//$Id$ 
//gen openMairie le 24/06/2021 17:50

require_once "../gen/obj/sig_contrainte.class.php";

class sig_contrainte extends sig_contrainte_gen {

    /**
     * Liaison NaN
     * 
     * Tableau contenant les objets qui représente les liaisons.
     */
    var $liaisons_nan = array(
        //
        "lien_sig_contrainte_om_collectivite" => array(
            "table_l" => "lien_sig_contrainte_om_collectivite",
            "table_f" => "om_collectivite",
            "field" => "om_collectivite",
        ),
        //
        "lien_sig_contrainte_dossier_instruction_type" => array(
            "table_l" => "lien_sig_contrainte_dossier_instruction_type",
            "table_f" => "dossier_instruction_type",
            "field" => "dossier_instruction_type",
        ),
    );

    /**
     * Liste des champs à afficher dans le formulaire.
     * 
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "sig_contrainte.sig_contrainte",
            "nature",
            "groupe",
            "sousgroupe",
            "libelle",
            "texte",
            "texte_genere",
            "no_ordre",
            "service_consulte",
            "sig_couche",
            "array_to_string(array_agg(distinct(dossier_instruction_type) ORDER BY dossier_instruction_type), ';') as dossier_instruction_type",
            "array_to_string(array_agg(distinct(om_collectivite) ORDER BY om_collectivite), ';') as om_collectivite",
        );
    }

    /**
     * Clause from pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__tableSelect() {
        return sprintf(
            '%1$s%2$s
                LEFT JOIN %1$slien_sig_contrainte_om_collectivite
                    ON lien_sig_contrainte_om_collectivite.sig_contrainte=sig_contrainte.sig_contrainte
                LEFT JOIN %1$slien_sig_contrainte_dossier_instruction_type
                    ON lien_sig_contrainte_dossier_instruction_type.sig_contrainte=sig_contrainte.sig_contrainte',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     * Clause where pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__selection() {
        return " GROUP BY sig_contrainte.sig_contrainte ";
    }

    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        if ($maj == 0 || $maj == 1) {
            $form->setType('dossier_instruction_type','select_multiple');
            $form->setType('om_collectivite','select_multiple');
        }

        // MODE SUPPRIMER et MODE CONSULTER
        if ($maj == 2 || $maj == 3) {
            //
            $form->setType('dossier_instruction_type','select_multiple_static');
            $form->setType('om_collectivite','select_multiple_static');            
        }
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type() {
        return "SELECT 
          dossier_instruction_type.dossier_instruction_type, 
          CONCAT(dossier_autorisation_type_detaille.code,' - ',dossier_instruction_type.code,' - ',dossier_instruction_type.libelle) as lib
        FROM ".DB_PREFIXE."dossier_instruction_type 
          LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        ORDER BY dossier_autorisation_type_detaille.code";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return "SELECT 
          dossier_instruction_type.dossier_instruction_type, 
          CONCAT(dossier_autorisation_type_detaille.code,' - ',dossier_instruction_type.code,' - ',dossier_instruction_type.libelle) as lib
        FROM ".DB_PREFIXE."dossier_instruction_type 
          LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        WHERE dossier_instruction_type IN (<idx>) 
        ORDER BY dossier_autorisation_type_detaille.code";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite() {
        return "SELECT 
          om_collectivite.om_collectivite, 
          CONCAT(om_collectivite.libelle) as lib
        FROM ".DB_PREFIXE."om_collectivite 
        ORDER BY om_collectivite.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite_by_id() {
        return "SELECT 
          om_collectivite.om_collectivite, 
          CONCAT(om_collectivite.libelle) as lib
        FROM ".DB_PREFIXE."om_collectivite 
        WHERE om_collectivite IN (<idx>) 
        ORDER BY om_collectivite.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_couche() {
        return "SELECT sig_couche.sig_couche, CONCAT(sig_couche.libelle, ' ', '(', sig_couche.id_couche, ')') FROM ".DB_PREFIXE."sig_couche ORDER BY sig_couche.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_couche_by_id() {
        return "SELECT sig_couche.sig_couche, CONCAT(sig_couche.libelle, ' ', '(', sig_couche.id_couche, ')') FROM ".DB_PREFIXE."sig_couche WHERE sig_couche = <idx>";
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);

        // Initialisation du selecteur multiple dossier_instruction_type
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "dossier_instruction_type",
            $this->get_var_sql_forminc__sql("dossier_instruction_type"),
            $this->get_var_sql_forminc__sql("dossier_instruction_type_by_id"),
            false,
            true
        );

        // Initialisation du selecteur multiple om_collectivite
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "om_collectivite",
            $this->get_var_sql_forminc__sql("om_collectivite"),
            $this->get_var_sql_forminc__sql("om_collectivite_by_id"),
            false,
            true
        );
    }

    function setTaille(&$form, $maj) {
        //
        parent::setTaille($form, $maj);
        //
        $form->setTaille("dossier_instruction_type", 10);
        $form->setTaille("om_collectivite", 10);
    }

    function setMax(&$form, $maj) {
        //
        parent::setMax($form, $maj);
        //
        $form->setMax("dossier_instruction_type", 5);
        $form->setMax("om_collectivite", 5);
    }

    function setLib(&$form, $maj) {
        //
        parent::setLib($form, $maj);
        //
        $form->setLib("dossier_instruction_type", _("type(s) de DI concerne(s)"));
        $form->setLib("om_collectivite", _("collectivite(s) concernee(s)"));
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * - ...
     * - Ajoute autant de lien_dossier_instruction_type_evenement que de dossier_instruction_type
     * - ...
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggerajouterapres($id, $dnu1, $val);

        // Liaison NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Si le champ possède une valeur
            if (isset($val[$liaison_nan["field"]]) === true) {
                // Ajout des liaisons table Nan
                $nb_liens = $this->ajouter_liaisons_table_nan(
                    $liaison_nan["table_l"],
                    $liaison_nan["table_f"],
                    $liaison_nan["field"],
                    $val[$liaison_nan["field"]]
                );
                // Message de confirmation
                if ($nb_liens > 0) {
                    if ($nb_liens == 1) {
                        $this->addToMessage(sprintf(_("Création d'une nouvelle liaison réalisee avec succès.")));
                    } else {
                        $this->addToMessage(sprintf(_("Création de %s nouvelles liaisons réalisée avec succès."), $nb_liens));
                    }
                }
            }
        }

        return true;
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggermodifierapres($id, $dnu1, $val);
        
        // Liaisons NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Suppression des liaisons table NaN
            $this->supprimer_liaisons_table_nan($liaison_nan["table_l"]);
            // Ajout des liaisons table Nan
            $nb_liens = $this->ajouter_liaisons_table_nan(
                $liaison_nan["table_l"],
                $liaison_nan["table_f"],
                $liaison_nan["field"],
                $val[$liaison_nan["field"]]
            );
            // Message de confirmation
            if ($nb_liens > 0) {
                $this->addToMessage(_("Mise a jour des liaisons realisee avec succes."));
            }
        }

        return true;
    }

    /**
     * Surcharge de la méthode rechercheTable pour éviter de court-circuiter le 
     * générateur en devant surcharger la méthode cleSecondaire afin de supprimer
     * les éléments liés dans les tables NaN.
     *
     * @param [type] $dnu1      Instance BDD - À ne pas utiliser
     * @param [type] $table     Table
     * @param [type] $field     Champ
     * @param [type] $id        Identifiant
     * @param [type] $dnu2      Marqueur de débogage - À ne pas utiliser
     * @param string $selection Condition de la requête
     *
     * @return [type] [description]
     */
    function rechercheTable(&$dnu1 = null, $table = "", $field = "", $id = null, $dnu2 = null, $selection = "") {
        //
        if (in_array($table, array_keys($this->liaisons_nan))) {
            //
            $this->addToLog(__METHOD__."(): On ne vérifie pas la table ".$table." car liaison nan.", EXTRA_VERBOSE_MODE);
            return;
        }
        //
        parent::rechercheTable($this->f->db, $table, $field, $id, null, $selection);
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggersupprimer($id, $dnu1, $val);
        // Liaisons NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Suppression des liaisons table NaN
            $this->supprimer_liaisons_table_nan($liaison_nan["table_l"]);
        }
        
        return true;
    }
}
