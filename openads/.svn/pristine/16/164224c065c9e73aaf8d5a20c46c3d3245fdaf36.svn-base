<?php
//$Id$ 
//gen openMairie le 28/02/2022 16:08

require_once "../gen/obj/motif_consultation.class.php";

class motif_consultation extends motif_consultation_gen {

    /**
     * Liaison NaN
     * 
     * Tableau contenant les objets qui représente les liaisons.
     */
    var $liaisons_nan = array(
        //
        "lien_motif_consultation_om_collectivite" => array(
            "table_l" => "lien_motif_consultation_om_collectivite",
            "table_f" => "om_collectivite",
            "field" => "om_collectivite",
        )
    );


    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "motif_consultation.motif_consultation",
            "code",
            "libelle",
            "description",
            "notification_email",
            "delai_type",
            "delai",
            "consultation_papier",
            "type_consultation",
            "om_etat",
            "service_type",
            "generate_edition",
            "array_to_string(array_agg(distinct(om_collectivite) ORDER BY om_collectivite), ';') as om_collectivite",
            "om_validite_debut",
            "om_validite_fin",
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
                LEFT JOIN %1$slien_motif_consultation_om_collectivite
                    ON lien_motif_consultation_om_collectivite.motif_consultation=motif_consultation.motif_consultation',
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
        return " GROUP BY motif_consultation.motif_consultation ";
    }


    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        // MODE AJOUTER et MODE MODIFIER
        if ($maj == 0 || $maj == 1) {
            //
            $form->setType('om_collectivite','select_multiple');
            $form->setType('type_consultation', 'select');
            $form->setType('om_etat', 'select');
            $form->setType('delai_type', 'select');
            $form->setType('service_type', 'select');
        }

        // MODE SUPPRIMER et MODE CONSULTER
        if ($maj == 2 || $maj == 3) {
            //
            $form->setType('om_collectivite','select_multiple_static');
            $form->setType('service_type', 'selectstatic');
        }
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
    function get_var_sql_forminc__sql_om_etat() {
        return "SELECT om_etat.om_etat, om_etat.libelle FROM ".DB_PREFIXE."om_etat WHERE id LIKE 'consultation_%' ORDER BY om_etat.libelle ASC";
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);

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

        $contenu=array();

        $contenu[0]=array(
          'avec_avis_attendu',
          'pour_conformite',
          'pour_information',
          );

        $contenu[1]=array(
          __('Avec avis attendu'),
          __('Pour conformite'),
          __('Pour information'),
          
          );
        $form->setSelect("type_consultation",$contenu);

        //
        $contenu = array();
        $contenu[0] = array('mois','jour');
        $contenu[1] = array(_('mois'), _('jour'));
        $form->setSelect("delai_type", $contenu);

        // service_type
        $contenu = array();
        $contenu[0] = array(PLATAU, 'openads', );
        $contenu[1] = array(__("Plat'AU"), __('openADS'), );
        $form->setSelect("service_type", $contenu);
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        if ($maj > 1) {
            //Traitement des données pour l'affichage du select
            $temp = $this->val[array_search('type_consultation', array_keys($form->val))];
            if (strcmp($temp, 'pour_information') == 0) {
                $temp = _('Pour information');
            } elseif (strcmp($temp, 'avec_avis_attendu') == 0) {
                $temp = _('Avec avis attendu');
            } elseif (strcmp($temp, 'pour_conformite') == 0) {
                $temp = _('Pour conformite');
            }
            $form->setVal('type_consultation', $temp);
        }
    }
    
    function setLib(&$form,$maj) {
        //
        parent::setLib($form, $maj);
        $form->setLib("om_etat", __("type d'edition de la consultation"));
        $form->setLib("om_collectivite", __("om_collectivite"));
        $form->setLib("generer_edition", __("generer_edition"));
    }


    function setTaille(&$form, $maj) {
        //
        parent::setTaille($form, $maj);
        //
        $form->setTaille("om_collectivite", 10);
    }

    function setMax(&$form, $maj) {
        //
        parent::setMax($form, $maj);
        //
        $form->setMax("om_collectivite", 5);
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
