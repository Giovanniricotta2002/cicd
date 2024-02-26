<?php
//$Id$ 
//gen openMairie le 14/03/2022 16:02

require_once "../gen/obj/habilitation_tiers_consulte.class.php";

class habilitation_tiers_consulte extends habilitation_tiers_consulte_gen {

    /**
     * Liaison NaN
     * 
     * Tableau contenant les objets qui représente les liaisons.
     */
    var $liaisons_nan = array(
        //
        "lien_habilitation_tiers_consulte_specialite_tiers_consulte" => array(
            "table_l" => "lien_habilitation_tiers_consulte_specialite_tiers_consulte",
            "table_f" => "specialite_tiers_consulte",
            "field" => "specialite_tiers_consulte",
        ),
        "lien_habilitation_tiers_consulte_commune" => array(
            "table_l" => "lien_habilitation_tiers_consulte_commune",
            "table_f" => "commune",
            "field" => "division_territoire_intervention_commune",
        ),
        "lien_habilitation_tiers_consulte_departement" => array(
            "table_l" => "lien_habilitation_tiers_consulte_departement",
            "table_f" => "departement",
            "field" => "division_territoire_intervention_departement",
        )
    );

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "habilitation_tiers_consulte.habilitation_tiers_consulte",
            "type_habilitation_tiers_consulte",
            "array_to_string(array_agg(distinct(lien_habilitation_tiers_consulte_commune.commune) ORDER BY lien_habilitation_tiers_consulte_commune.commune), ';') as division_territoire_intervention_commune",
            "array_to_string(array_agg(distinct(lien_habilitation_tiers_consulte_departement.departement) ORDER BY lien_habilitation_tiers_consulte_departement.departement), ';') as division_territoire_intervention_departement",
            "texte_agrement",
            "division_territoriales",
            "array_to_string(array_agg(distinct(specialite_tiers_consulte) ORDER BY specialite_tiers_consulte), ';') as specialite_tiers_consulte",
            "habilitation_tiers_consulte.om_validite_debut",
            "habilitation_tiers_consulte.om_validite_fin",
            "tiers_consulte",
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
                LEFT JOIN %1$slien_habilitation_tiers_consulte_specialite_tiers_consulte
                    ON lien_habilitation_tiers_consulte_specialite_tiers_consulte.habilitation_tiers_consulte=habilitation_tiers_consulte.habilitation_tiers_consulte
                LEFT JOIN %1$slien_habilitation_tiers_consulte_commune
                    ON lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte=habilitation_tiers_consulte.habilitation_tiers_consulte
                LEFT JOIN %1$slien_habilitation_tiers_consulte_departement
                    ON lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte=habilitation_tiers_consulte.habilitation_tiers_consulte',
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
        return " GROUP BY habilitation_tiers_consulte.habilitation_tiers_consulte ";
    }

    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        if ($maj == 0 || $maj == 1) {
            $form->setType('specialite_tiers_consulte','select_multiple');
            $form->setType('division_territoire_intervention_commune', 'select_multiple');
            $form->setType('division_territoire_intervention_departement', 'select_multiple');
        }

        // MODE SUPPRIMER et MODE CONSULTER
        if ($maj == 2 || $maj == 3) {
            //
            $form->setType('specialite_tiers_consulte','select_multiple_static');
            $form->setType('division_territoire_intervention_commune', 'select_multiple_static');
            $form->setType('division_territoire_intervention_departement', 'select_multiple_static');
        }
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_specialite_tiers_consulte() {
        return "SELECT 
          specialite_tiers_consulte.specialite_tiers_consulte, 
          CONCAT_WS(' - ', specialite_tiers_consulte.code, specialite_tiers_consulte.libelle) as lib
        FROM ".DB_PREFIXE."specialite_tiers_consulte 
        ORDER BY specialite_tiers_consulte.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_specialite_tiers_consulte_by_id() {
        return "SELECT 
          specialite_tiers_consulte.specialite_tiers_consulte, 
          CONCAT_WS(' - ', specialite_tiers_consulte.code, specialite_tiers_consulte.libelle) as lib
        FROM ".DB_PREFIXE."specialite_tiers_consulte 
        WHERE specialite_tiers_consulte IN (<idx>) 
        ORDER BY specialite_tiers_consulte.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division_territoire_intervention_commune() {
        return "SELECT
          commune.commune,
          CONCAT(commune.com, ' - ', commune.libelle) as lib
        FROM ".DB_PREFIXE."commune
        WHERE
            (
                commune.om_validite_debut IS NULL
                OR commune.om_validite_debut <= CURRENT_DATE
            )
            AND (
                commune.om_validite_fin IS NULL
                OR commune.om_validite_fin > CURRENT_DATE
            )
        ORDER BY commune.com";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division_territoire_intervention_commune_by_id() {
        return "SELECT
          commune.commune,
          CONCAT(commune.com, ' - ', commune.libelle) as lib
        FROM ".DB_PREFIXE."commune
        WHERE commune IN (<idx>)
        ORDER BY commune.com";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division_territoire_intervention_departement() {
        return "SELECT
          departement.departement,
          CONCAT(departement.dep, ' - ', departement.libelle) as lib
        FROM ".DB_PREFIXE."departement
        WHERE
            (
                departement.om_validite_debut IS NULL
                OR departement.om_validite_debut <= CURRENT_DATE
            )
            AND (
                departement.om_validite_fin IS NULL
                OR departement.om_validite_fin > CURRENT_DATE
            )
        ORDER BY departement.dep";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division_territoire_intervention_departement_by_id() {
        return "SELECT
          departement.departement,
          CONCAT(departement.dep, ' - ', departement.libelle) as lib
        FROM ".DB_PREFIXE."departement
        WHERE departement IN (<idx>)
        ORDER BY departement.dep";
    }


    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);

        // Initialisation du selecteur multiple specialite_tiers_consulte
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "specialite_tiers_consulte",
            $this->get_var_sql_forminc__sql("specialite_tiers_consulte"),
            $this->get_var_sql_forminc__sql("specialite_tiers_consulte_by_id"),
            false,
            true
        );

        // Initialisation du selecteur multiple division_territoire_intervention_commune
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "division_territoire_intervention_commune",
            $this->get_var_sql_forminc__sql("division_territoire_intervention_commune"),
            $this->get_var_sql_forminc__sql("division_territoire_intervention_commune_by_id"),
            false,
            true
        );

        // Initialisation du selecteur multiple division_territoire_intervention_departement
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "division_territoire_intervention_departement",
            $this->get_var_sql_forminc__sql("division_territoire_intervention_departement"),
            $this->get_var_sql_forminc__sql("division_territoire_intervention_departement_by_id"),
            false,
            true
        );
    }

    function setLib(&$form,$maj) {
        //
        parent::setLib($form, $maj);
        $form->setLib("specialite_tiers_consulte", __("specialite_tiers_consulte"));
        $form->setLib('division_territoire_intervention_commune', __("Division territoriale d’intervention commune"));
        $form->setLib('division_territoire_intervention_departement', __("Division territoriale d’intervention departement"));
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * - ...
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
                        $this->addToMessage(sprintf(__("Création d'une nouvelle liaison réalisee avec succès.")));
                    } else {
                        $this->addToMessage(sprintf(__("Création de %s nouvelles liaisons réalisée avec succès."), $nb_liens));
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
                $this->addToMessage(__("Mise a jour des liaisons realisee avec succes."));
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
