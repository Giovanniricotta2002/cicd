<?php
/**
 * DBFORM - 'action' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'action'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/action.class.php";

class action extends action_gen {

    // Handler d'un objet de classe dossier
    var $dossier;

    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        
        if ($maj == 0 or $maj == 1) {
            $form->setType("regle_donnees_techniques1", "regle_donnees_techniques");
            $form->setType("regle_donnees_techniques2", "regle_donnees_techniques");
            $form->setType("regle_donnees_techniques3", "regle_donnees_techniques");
            $form->setType("regle_donnees_techniques4", "regle_donnees_techniques");
            $form->setType("regle_donnees_techniques5", "regle_donnees_techniques");
            $form->setType("cible_regle_donnees_techniques1", "nodisplay");
            $form->setType("cible_regle_donnees_techniques2", "nodisplay");
            $form->setType("cible_regle_donnees_techniques3", "nodisplay");
            $form->setType("cible_regle_donnees_techniques4", "nodisplay");
            $form->setType("cible_regle_donnees_techniques5", "nodisplay");
        }
        if ($maj == 2 or $maj == 3) {
            $form->setType("regle_donnees_techniques1", "regle_donnees_techniques_static");
            $form->setType("regle_donnees_techniques2", "regle_donnees_techniques_static");
            $form->setType("regle_donnees_techniques3", "regle_donnees_techniques_static");
            $form->setType("regle_donnees_techniques4", "regle_donnees_techniques_static");
            $form->setType("regle_donnees_techniques5", "regle_donnees_techniques_static");
            $form->setType("cible_regle_donnees_techniques1", "nodisplay");
            $form->setType("cible_regle_donnees_techniques2", "nodisplay");
            $form->setType("cible_regle_donnees_techniques3", "nodisplay");
            $form->setType("cible_regle_donnees_techniques4", "nodisplay");
            $form->setType("cible_regle_donnees_techniques5", "nodisplay");
        }
    }
    
    function setLib(&$form, $maj) {
        parent::setLib($form, $maj);
        $form->setLib('regle_donnees_techniques1',_('regle_donnees_technique_cerfa1'));
        $form->setLib('regle_donnees_techniques2',_('regle_donnees_technique_cerfa2'));
        $form->setLib('regle_donnees_techniques3',_('regle_donnees_technique_cerfa3'));
        $form->setLib('regle_donnees_techniques4',_('regle_donnees_technique_cerfa4'));
        $form->setLib('regle_donnees_techniques5',_('regle_donnees_technique_cerfa5'));
    }

    /**
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);
        //
        $list_column = array();
        // Mot-clés à rechercher
        $search_field = "regle_";
        // Pour chaque champs du formulaire
        foreach ($this->champs as $champ) {
            // Si le mot-clés est présent dans l'identifiant du champ
            if (strpos($champ, $search_field) !== false) {
                // Ajoute le champ à la liste
                $list_column[] = $champ;
            }
        }

        // 
        $list_fields = array();
        // Pour chaque colonne
        foreach ($list_column as $value) {
            
            // Vérifie que le champs existe dans le formulaire et qu'il n'est 
            // pas vide
            if (isset($this->valF[$value]) 
                && $this->valF[$value] != ''
                && $this->valF[$value] != NULL) {
                //
                $list_fields[$value] = $this->valF[$value];
            }
        }

        // Si le tableau contenant les champs à tester n'est pas vide
        if (count($list_fields) > 0) {

            //
            foreach ($list_fields as $key => $value) {

                // Vérification de la possibilité des champs de la table dossier
                // correspondants aux règles d'être mis à null
                if($this->valF[$key] == "NULL" OR $this->valF[$key] == "null") {
                    //
                    if($this->fieldCanBeNull(substr($key, 6)) === false) {
                        // Affiche l'erreur
                        $this->correct=false;
                        $error_message = _("Le champ %s des dossiers ne peut etre mis a NULL.");
                        $this->addToMessage(sprintf($error_message, "<b>"._(substr($key, 6))."</b>"));

                    }
                }

                // Vérifie que la règle est valide
                $this->rule_is_valid($value, $key);
            }
        }
        
        // Vérification de la présence du couple cible règle pour les DT
        for ($i = 1; $i < 6; $i++) { 
            if ($this->valF["regle_donnees_techniques".$i] === null XOR
                $this->valF["cible_regle_donnees_techniques".$i] === null) {
                
                $this->correct=false;
                $this->addToMessage(
                    sprintf(
                        _("Le champ <b>Règle données techniques / CERFA</b> %s ne peut comporter un champ rempli et un champ vide"),
                        $i
                    )
                );
            }
        }

        
    }

    /**
     * Vérification que les champs ciblés par les règles contenant NULL peuvent
     * l'être.
     * @param  string $field champ impacté par la règle
     * @return boolean       peut être null = true else false
     */
    function fieldCanBeNull($field) {
        // Instantiation de la classe dossier si pas déjà fait
        if(!isset($this->dossier) OR empty($this->dossier)) {
            $this->dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => "]",
            ));
        }
        // Si le champ passé en param est dans la liste des champs obligatoires
        // de la table dossier return false
        if(array_search($field, $this->dossier->required_field) !== false) {
            return false;
        }
        return true;
    }

    /**
     * Vérifie la validité d'une règle d'action.
     * 
     * @param string $rule      Règle d'action.
     * @param string $rule_name Nom de la règle.
     */
    function rule_is_valid($rule, $rule_name) {

        // Supprime tous les espaces de la chaîne de caractère
        $rule = str_replace(' ', '', $rule);
        // Coupe la chaîne au niveau de l'opérateur
        $operands = explode("+", $rule);
        // Nombre d'opérande
        $nb_operands = count($operands);

        // Si la règle à vérifier concerne les données techniques, il faut
        // récupérer le type du champ des données techniques sélectionné.
        if ($rule_name === 'cible_regle_donnees_techniques1'
            || $rule_name === 'cible_regle_donnees_techniques2'
            || $rule_name === 'cible_regle_donnees_techniques3'
            || $rule_name === 'cible_regle_donnees_techniques4'
            || $rule_name === 'cible_regle_donnees_techniques5') {


            // Récupération du type de champ de la cible de la règle
            $type = $this->f->get_type_from_db(
                'donnees_techniques',
                $this->valF[$rule_name]
            );
            if (isset($type[$this->valF[$rule_name]]) === false
                || $type[$this->valF[$rule_name]] !== 'text') {
                $this->correct=false;
                $this->addToMessage(
                    sprintf(
                        _("Le champ %s ne peut être que de type texte."),
                        '<b>'._($rule_name).'</b>'
                    )
                );
            }
            
        }

        // Si c'est une règle spécifique
        if ($rule_name == "regle_autorite_competente"
            || $rule_name == "regle_etat"
            || $rule_name == "regle_accord_tacite"
            || $rule_name == "regle_pec_metier"
            || $rule_name == "regle_etat_pendant_incompletude") {
            // S'il y a plus d'une opérande
            if ($nb_operands > 1) {
                // Message d'erreur
                $this->correct=false;
                $this->addToMessage(
                    sprintf(_("Le champ %s ne peut pas avoir plus d'un opérande."),
                        '<b>'._($rule_name).'</b>')
                );
            }
        }

        // Pour chaque opérande
        foreach ($operands as $key => $operand) {

            // Supprime les numériques et null du tableau
            if (is_numeric($operand)) {
                // Supprime l'opérande
                unset($operands[$key]);
            }
            if ($operand == "NULL" || $operand == "null") {
                // Supprime l'opérande
                unset($operands[$key]);
            }
            // Supprime également les booléens
            if ($operand == "f" || $operand == "t"
                || $operand == "false" || $operand == "true") {
                // Supprime l'opérande
                unset($operands[$key]);
            }
        }
        
        $rules = array(
            'regle_donnees_techniques1',
            'regle_donnees_techniques2',
            'regle_donnees_techniques3',
            'regle_donnees_techniques4',
            'regle_donnees_techniques5',
            'cible_regle_donnees_techniques1',
            'cible_regle_donnees_techniques2',
            'cible_regle_donnees_techniques3',
            'cible_regle_donnees_techniques4',
            'cible_regle_donnees_techniques5',
        );

        if (in_array($rule_name, $rules, true) === true) {

            // Vérification de l'existance des champs de règle dans les données
            // technique
            $check_field_dt_exist = $this->f->check_field_exist(
                $operands,
                'donnees_techniques'
            );
            
            $check_field_instr_exist = $this->f->check_field_exist(
                $operands,
                'instruction'
            );

            if ($check_field_dt_exist !== true and
                $check_field_instr_exist !== true) {
                    
                $check_field_exist = array_intersect(
                    $check_field_dt_exist,
                    $check_field_instr_exist
                );
                if (count($check_field_exist) === 0) {
                    $check_field_exist = true;
                }
            } else {
                $check_field_exist = true;
            }
            
        } else {
            // Vérifie les champs utilisés pour la règle
            $check_field_exist = $this->f->check_field_exist($operands, 'instruction');
        }

        if ($check_field_exist !== true) {

            // Liste des champs en erreur
            $string_error_fields = implode(", ", $check_field_exist);

            // Message d'erreur
            $error_msg = _("Le champ %s n'est pas utilisable pour le champ %s.");
            // Si plusieurs champs sont en erreur
            if (count($check_field_exist) > 1) {
                $error_msg = _("Les champs %s ne sont pas utilisables pour le champ %s.");
            }

            // Affiche l'erreur
            $this->correct=false;
            $this->addToMessage(
                sprintf(
                    $error_msg,
                    '<b>'.$string_error_fields.'</b>',
                    '<b>'._($rule_name).'</b>'
                )
            );
        }
    }

    /**
     *
     */
    function formSpecificContent($maj) {
        /**
         * Affichage des champs qu'il est possible d'utiliser dans les règles
         */
        // Archives du dossier
        echo "<h4>"._("Valeurs du dossier avant l'evenement")."</h4>";
        echo "[archive_etat] [archive_delai] [archive_accord_tacite] 
        [archive_avis]";
        echo "<br/>";
        echo "[archive_date_dernier_depot] [archive_date_complet] 
        [archive_date_rejet] [archive_date_limite] 
        [archive_date_notification_delai] [archive_date_decision] 
        [archive_date_validite] [archive_date_achevement] 
        [archive_date_conformite] [archive_date_chantier] 
        [archive_etat_pendant_incompletude] [archive_date_limite_incompletude]
        [archive_delai_incompletude] [archive_autorite_competente] 
        [archive_date_cloture_instruction] [archive_date_premiere_visite]
        [archive_date_derniere_visite] [archive_date_contradictoire]
        [archive_date_retour_contradictoire] [archive_date_ait]
        [archive_date_transmission_parquet]
        [archive_incompletude] [archive_incomplet_notifie]
        [duree_validite][date_depot][date_depot_mairie]";
        // Champs de l'événement
        echo "<h4>"._("Parametres de l'evenement")."</h4>";
        echo "[etat] [delai] [accord_tacite] [avis_decision] 
        [delai_notification] [date_evenement] [autorite_competente] [pec_metier]
        [complement_om_html] [complement2_om_html] [complement3_om_html]
        [complement4_om_html]";
        // Champs récupérés depuis l'événement d'instruction principal
        echo "<h4>"._("Valeurs de l'evenement d'instruction principal")."</h4>";
        echo "[date_envoi_signature] [date_retour_signature] [date_envoi_rar] [date_retour_rar] [date_envoi_rar] [date_retour_rar] [date_envoi_controle_legalite] [date_retour_controle_legalite]";
        // Champs du type détaillé du dossier d'autorisation
        echo "<h4>"._("Parametres du type detaille du dossier d'autorisation")
            ."</h4>";
        echo "[duree_validite_parametrage]";
        // Champs du type détaillé du dossier d'autorisation
        echo "<h4>"._("Valeurs des données techniques")
            ."</h4>";
        echo "[ctx_nature_travaux_infra_om_html] [ctx_article_non_resp_om_html]";
        echo "<h4>"._("Suppression de la valeur")."</h4>";
        echo "[null]";
        echo "<h4>".__("Valeurs pour les booléens")."</h4>";
        echo "[f] ou [false] [t] ou [true]";
    }

}


