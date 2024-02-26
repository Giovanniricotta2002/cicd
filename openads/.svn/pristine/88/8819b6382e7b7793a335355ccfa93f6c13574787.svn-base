<?php
/**
 * DBFORM - 'num_dossier_recuperation' - Surcharge num_dossier_gen.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once PATH_OPENMAIRIE.'../gen/obj/num_dossier.class.php';

class num_dossier_recuperation extends num_dossier_gen {

    protected $_absolute_class_name = "num_dossier_recuperation";
    
    
    //
    // OVERRIDE
    //
    
    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        
        parent::init_class_actions();
        
        // ACTION - 000 - ajouter
        // Désactivation de l'action ajouter
        $this->class_actions[0] = null;
        
        // ACTION - 001 - modifier
        // Désactivation de l'action modifier
        $this->class_actions[1] = null;
        
        // ACTION - 002 - supprimer
        // Désactivation de l'action supprimer
        $this->class_actions[2] = null;
        
        // ACTION - 003 - consulter
        // Désactivation de l'action consulter
        $this->class_actions[3] = null;
        
        // ACTION - 004 - synchroniser
        // Synchronisation des contraintes
        $this->class_actions[4] = array(
                "identifier" => "dossier_recuperation",
                "view" => "view_dossier_recuperation",
                "permission_suffix" => "consulter",
                "condition" => "is_option_suivi_numerisation_enabled",
        );
    }

    /*
     * Retour à la fonction générée
     */
    function getFormTitle($ent) {
        return $ent;
    }
    
    // FIN DE LA SURCHARGE
    
    //
    // VIEWS
    //
    
    /**
     * VIEW - view_mise_a_jour.
     *
     * Permet de mettre à jour les statuts des autorisations expirées
     * et leurs conséquences
     *
     * @return void
     */
    function view_dossier_recuperation() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Traitement et affichage message si formulaire validé
        if ($this->f->get_submitted_post_value('valider_mise_a_jour') === 'oui') {
            $this->recuperation(array(
                "om_collectivite" => $this->f->get_submitted_post_value('om_collectivite')
            ));
            //
            $this->display_msg();
        }

        // Formulaire de validation
        $this->f->layout->display__form_container__begin(array(
            "action" => "",
            "name" => "f1",
        ));
        $champs = array('om_collectivite', 'valider_mise_a_jour', );
        // Instanciation de l'objet formulaire
        $this->form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => $this->getParameter("maj"),
            "champs" => $champs,
        ));
        // Paramétrage des champs du formulaire
        // om_collectivite
        $this->form->setLib("om_collectivite", __("om_collectivite"));
        $this->form->setTaille("om_collectivite", 11);
        $this->form->setMax("om_collectivite", 11);
        if ($_SESSION['niveau'] == 1) {
            $this->form->setType("om_collectivite", "hidden");
            $this->form->setVal('om_collectivite', $_SESSION['collectivite']);
        } else {
            $this->form->setType("om_collectivite", "select");
            $this->init_select(
                $this->form, 
                $this->f->db,
                0,
                null,
                "om_collectivite",
                $this->get_var_sql_forminc__sql("om_collectivite"),
                $this->get_var_sql_forminc__sql("om_collectivite_by_id"),
                false
            );
            $this->form->setVal('om_collectivite', $this->f->get_submitted_post_value('om_collectivite'));
        }
        // valider_mise_a_jour
        $this->form->setLib("valider_mise_a_jour", "");
        $this->form->setTaille("valider_mise_a_jour", 3);
        $this->form->setMax("valider_mise_a_jour", 3);
        $this->form->setType("valider_mise_a_jour", "hidden");
        $this->form->setVal('valider_mise_a_jour', 'oui');
        // Ouverture du conteneur de formulaire
        $this->form->entete();
        $this->f->displayDescription(__("Permet de récupérer les dossiers d'instruction pour le suivi de numérisation des documents."));
        $this->form->afficher($champs, 0, false, false);
        $this->form->enpied();
        $this->f->layout->display__form_controls_container__begin(array(
            "controls" => "bottom",
        ));
        $this->f->layout->display__form_input_submit(array(
            "name" => "btn_mise_a_jour",
            "value" => __("Récupération"),
            "class" => "boutonFormulaire",
        ));
        $this->f->layout->display__form_controls_container__end();
        //
        $this->f->layout->display__form_container__end();
    }

    //
    // TREATMENTS
    //
    
    /**
     * TREATMENT - recuperation.
     *
     * Mettre à jour le statut des arrêtés expirés et par suite
     * éventuellement dé-suspendre des arrêtés suspendus
     *
     * @param  array $val Valeurs soumises par le formulaire
     * @return void
     */
    function recuperation($val = array()) {
        $this->begin_treatment(__METHOD__);

        // La sélection de la collectivité est obligatoire
        if ($val['om_collectivite'] === null || $val['om_collectivite'] === '') {
            $this->correct = false;
            $this->addToMessage(__("Veuillez sélectionner une collectivité."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Récupération des paramètres de la collectivité sélectionnée
        $collectivite_param = $this->f->getCollectivite($val['om_collectivite']);
        $numerisation_intervalle_date = isset($collectivite_param["numerisation_intervalle_date"]) === true ? $collectivite_param["numerisation_intervalle_date"] : null;
        $numerisation_intervalle_date = isset($val['numerisation_intervalle_date']) === true ? $val['numerisation_intervalle_date'] : $numerisation_intervalle_date;
        $numerisation_type_dossier_autorisation = isset($collectivite_param["numerisation_type_dossier_autorisation"]) === true ? $collectivite_param["numerisation_type_dossier_autorisation"] : null;
        $numerisation_type_dossier_autorisation = isset($val["numerisation_type_dossier_autorisation"]) === true ? $val["numerisation_type_dossier_autorisation"] : $numerisation_type_dossier_autorisation;

        // Vérification de l'initialisation des paramètres
        if ($this->f->is_option_suivi_numerisation_enabled($val['om_collectivite']) === false
            || $numerisation_intervalle_date === null
            || $numerisation_type_dossier_autorisation === null) {
            //
            $this->correct = false;
            $this->addToMessage(__("Les paramètres requis pour l'utilisation du suivi de numérisation ne sont pas renseignés."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Il est possible de récupérer tous les dossiers de toutes les collectivités en
        // sélectionnant la collectivité de niveau 2
        $where_collectivite = "";
        if ($this->f->isCollectiviteMono($val['om_collectivite']) === true) {
            $where_collectivite = sprintf(" AND demande.om_collectivite = %s ", intval($val['om_collectivite']));
        }

        $query = sprintf('
            SELECT
                demande.demande
                ,demande.dossier_instruction
                ,demande_type.code
                ,instruction.date_evenement
                ,TRANSLATE(
                    CONCAT(
                        CASE demandeur.qualite
                            WHEN \'particulier\'
                            THEN CONCAT_WS(\' \', demandeur.particulier_nom, demandeur.particulier_prenom)
                            ELSE CONCAT(demandeur.personne_morale_denomination,\' - \'||demandeur.personne_morale_raison_sociale, \' - \',demandeur.personne_morale_nom,\' \'||demandeur.personne_morale_prenom)
                        END
                        ,\' - \'||COALESCE(demandeur.numero,\'\')||\' \'||demandeur.voie
                        ,\' - \'||demandeur.complement
                        ,\' - \'||demandeur.lieu_dit
                        ,\' - BP \'||demandeur.bp
                        ,\' - \',COALESCE(demandeur.code_postal,\'\')||\' \'||demandeur.localite
                        ,\' - Cedex \'||demandeur.cedex
                    )
                    ,\'âãäåÁÂÃÄÅèééêëÈÉÉÊËìíîïìÌÍÎÏÌóôõöÒÓÔÕÖùúûüÙÚÛÜç\'
                    ,\'aaaaAAAAAeeeeeEEEEEiiiiiIIIIIooooOOOOOuuuuUUUUc\'
                ) as demandeur_principal
                ,demande.om_collectivite
            FROM %1$sdemande
            LEFT JOIN %1$sdossier_autorisation_type_detaille 
                ON demande.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            LEFT JOIN %1$sdemande_type  
                ON demande.demande_type = demande_type.demande_type
            LEFT JOIN %1$slien_demande_demandeur
                ON demande.demande = lien_demande_demandeur.demande
                    AND lien_demande_demandeur.petitionnaire_principal
            LEFT JOIN %1$sdemandeur 
                ON lien_demande_demandeur.demandeur = demandeur.demandeur
            LEFT JOIN %1$sinstruction
                ON demande.instruction_recepisse = instruction.instruction
            WHERE NOT EXISTS (SELECT 1 FROM %1$snum_dossier WHERE num_dossier.ref = demande.dossier_instruction
                    AND num_dossier.date_depot = instruction.date_evenement)
                AND demande.instruction_recepisse IS NOT NULL
                AND instruction.date_evenement >= (CURRENT_DATE - interval \'%2$s days\')
                AND dossier_autorisation_type_detaille.code IN (%3$s)
                %4$s
            ',
            DB_PREFIXE,
            $numerisation_intervalle_date,
            $numerisation_type_dossier_autorisation,
            $where_collectivite
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            $this->correct = false;
            $this->addToMessage(sprintf('%s %s', __("Erreur de base de donnees."), __("Contactez votre administrateur.")));
            return $this->end_treatment(__METHOD__, false);
        }

        // nombre
        $nb_dossiers = intval(count($res['result']));

        // Ajoute dans un dossier de suivi à chaque dossier d'instruction récupéré
        foreach ($res['result'] as $value) {
            $inst_num_dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "num_dossier",
                "idx" => '[',
            ));
            $valF = array();
            foreach ($inst_num_dossier->champs as $champ) {
                $valF[$champ] = '';
            }
            $valF['num_commande'] = $value['demande'];
            $valF['ref'] = $value['dossier_instruction'];
            $valF['code'] = $value['code'];
            $valF['date_depot'] = $value['date_evenement'];
            $valF['petition'] = $value['demandeur_principal'];
            $valF['om_collectivite'] = $value['om_collectivite'];
            $add = $inst_num_dossier->ajouter($valF);
            if ($add === false) {
                $this->correct = false;
                $this->addToMessage(sprintf(__("Erreur lors de l'ajout du dossier d'instruction %s dans un dossier de suivi."), $value['dossier_instruction']));
                return $this->end_treatment(__METHOD__, false);
            }
        }

        $this->addToMessage(sprintf('%s<br/>%s', __("Les dossiers ont été récupérés."), sprintf(__("Opération terminée : %s dossiers importés."), $nb_dossiers)));
        return $this->end_treatment(__METHOD__, true);
        }

} // fin classe

