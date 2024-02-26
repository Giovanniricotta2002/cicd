<?php
/**
 * DBFORM - 'dossier_commission' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id: dossier_commission.class.php 4701 2015-04-30 16:36:34Z vpihour $
 */

require_once ("../gen/obj/dossier_commission.class.php");

class dossier_commission extends dossier_commission_gen {

    // {{{ Gestion de la confidentialité des données spécifiques

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        
        parent::init_class_actions();

        // ACTION - 000 - ajouter
        // Modifie la condition d'affichage du bouton ajouter
        $this->class_actions[0]["condition"] = "can_user_access_dossier_contexte_ajout";

        // ACTION - 001 - modifier
        // 
        $this->class_actions[1]["condition"] = array("is_editable", "can_user_access_dossier_contexte_modification");
        
        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["condition"] = array("is_deletable", "can_user_access_dossier_contexte_modification");

        // ACTION - 050 - marquer_comme_lu
        // Pour qu'un cadre valide l'analyse
        $this->class_actions[50] = array(
            "identifier" => "marquer_comme_lu",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Marquer comme lu"),
                "order" => 50,
                "class" => "lu-16",
            ),
            "view" => "formulaire",
            "method" => "marquer_comme_lu",
            "permission_suffix" => "modifier_lu",
            "condition" => array("is_markable",
              "show_marquer_comme_lu_portlet_action",
              "can_user_access_dossier_contexte_modification",
            ),
        );
    }

    
    /**
     * TREATMENT - marquer_comme_lu.
     * 
     * Cette methode permet de passer la consultation en "lu"
     *
     * @return boolean true si maj effectué false sinon
     */
    function marquer_comme_lu() {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        if($this->getVal("lu") == 'f') {
            $this->correct = true;
            $valF = array();
            $valF["lu"] = true;

            $res = $this->f->db->autoExecute(
                DB_PREFIXE.$this->table, 
                $valF, 
                DB_AUTOQUERY_UPDATE,
                $this->clePrimaire."=".$this->getVal($this->clePrimaire)
            );
            if ($this->f->isDatabaseError($res, true)) {
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
                $this->correct = false;
                // Termine le traitement
                return $this->end_treatment(__METHOD__, false);
            } else {
                $this->addToMessage(_("Mise a jour effectue avec succes"));
                return $this->end_treatment(__METHOD__, true);
            }

        } else {
            $this->addToMessage(_("Element deja marque comme lu"));
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, false);
    }


    function setType(&$form,$maj) {
        parent::setType($form, $maj);

        //En ajout ou modification pour l'instructeur
        if ($maj < 2
            && $this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
            //
            $form->setType('dossier','hiddenstatic');
            $form->setType('commission','hidden');
            $form->setType('avis','hidden');
            $form->setType('lu', 'hidden');
        }

        //En modification pour l'instructeur
        if ($maj == 1
            && $this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
            //
            $form->setType('lu','checkboxstatic');
        }

        // En consultation et modification pour la cellule suivi
        if ($maj == 1
            && $this->getParameter("retourformulaire") == 'commission') {
            //
            $form->setType('dossier','hiddenstatic');
            $form->setType('commission_type','hiddenstatic');
            $form->setType('date_souhaitee','hiddenstaticdate');
            $form->setType('motivation','hiddenstatic');
            $form->setType('commission','hiddenstatic');
            $form->setType('lu','hidden');
        }

        if ($maj == 3
            && $this->getParameter("retourformulaire") == 'commission') {
            //
            $form->setType('lu','hidden');
        }
        // 
        if ($this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
            $form->setType('dossier', 'hidden');
        }
        if($maj == 50 ) {
            foreach ($this->champs as $value) {
                $form->setType($value, 'hidden');
            }
        }
    }


    function setLib(&$form, $maj) {
        //
        parent::setLib($form, $maj);
        //
        $form->setLib($this->clePrimaire, _("id"));
    }

    /**
     * TRIGGER - triggerajouter.
     *
     * @return boolean
     */
    function triggerajouter($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // XXX Cete portion de code devrait se trouver dans setValFAjout ?
        // la demande de commission est mis à lu par défaut
        $this->valF["lu"] = true;
    }

    /**
     * TRIGGER - triggermodifier.
     *
     * @return boolean
     */
    function triggermodifier($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Si la commission rend son avis, la demande de commission est non lu pour que
        // l'instructeur soit notifié
        if ($val["avis"] != "") {
            $this->valF["lu"] = false;
        }
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        // parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $this->retourformulaire = $retourformulaire;
        // En mode AJOUTER
        if ($maj == 0) {
            // On positionne la date du jour par défaut
            $form->setVal("date_souhaitee", date("d/m/Y"));
            // Afficher le numéro de dossier d'instruction
            if ($this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
                $form->setVal('dossier', $this->getParameter("idxformulaire"));
            }
        }
    }

    //Surcharge du bouton retour de la gestion des commissions afin de retourner directement vers le tableau
    function retoursousformulaire($idxformulaire = NULL, $retourformulaire = NULL, $val = NULL,
                                  $objsf = NULL, $premiersf = NULL, $tricolsf = NULL, $validation = NULL,
                                  $idx = NULL, $maj = NULL, $retour = NULL) {
                                      
        if( $maj = 1 && $retourformulaire === "commission") {

            // bouton retour HTML
            echo sprintf("\n".
                '<a class="retour" href="#" id="sousform-action-%s-back-%s" data-href="%s">%s</a>'."\n",
                $objsf, uniqid(),
                sprintf(
                    OM_ROUTE_SOUSTAB."&obj=%s&retourformulaire=%s&idxformulaire=%s",
                    'dossier_commission', 'commission', $val['commission']
                ),
                __('Retour')
            );

        } else {
            parent::retoursousformulaire($idxformulaire, $retourformulaire, $val,
                                  $objsf, $premiersf, $tricolsf, $validation,
                                  $idx, $maj, ($this->getParameter("maj")==2&&$validation==1)?"tab":$retour);
        }
    }

    /**
     * Si le dossier d'instruction auquel est rattachée la consultation est 
     * cloturé, on affiche pas les liens du portlet.
     *
     * @return boolean true si non cloturé false sinon
     */
    function is_dossier_instruction_not_closed() {
        $idxformulaire = $this->getParameter("idxformulaire");
        $retourformulaire = $this->getParameter("retourformulaire");
        //Si le dossier d'instruction auquel est rattachée la consultation est
        //cloturé, on affiche pas les liens du portlet
        if ($idxformulaire != '' &&
            ($retourformulaire == 'dossier' ||
                $this->f->contexte_dossier_instruction()
            )) {
                
            //On récuppère le statut du dossier d'instruction        
            $statut = $this->f->getStatutDossier($idxformulaire);
            if ( $this->f->isUserInstructeur() && $statut == "cloture" ){
                return false;
            }
        }
        return true;
    }
    
    
    function is_editable(){
        
        if ($this->f->can_bypass("dossier_commission", "modifier")){
            return true;
        }
        
        if ($this->is_dossier_instruction_not_closed() === true &&
            $this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        return false;
    }
    
    function is_deletable(){
        
        if ($this->f->can_bypass("dossier_commission", "supprimer")){
            return true;
        }
        
        if ($this->is_dossier_instruction_not_closed() === true
            && $this->getVal("avis") == ''
            && ($this->is_instructeur_from_division_dossier() === true
                || $this->f->can_bypass("dossier_commission", "supprimer_division"))) {
            //
            return true;
        }
        return false;
    }
    
    function is_markable(){
        
        if($this->f->can_bypass("dossier_commission", "modifier_lu")){
            return true;
        }
        
        if ($this->is_instructeur_from_division_dossier() === true){
            return true;
        }
        return false;
    }
    
    /**
     * Si le champ lu est à true l'action "Marquer comme lu" n'est pas affichée
     *
     * @return boolean true sinon lu false sinon
     */
    function show_marquer_comme_lu_portlet_action() {
        if (isset($this->val[array_search("lu", $this->champs)])
            && $this->val[array_search("lu", $this->champs)]== "t") {
            return false;
        }
        return true;
    }

    /*
     * CONDITION - can_user_access_dossier_contexte_ajout
     *
     * Vérifie que l'utilisateur a bien accès au dossier d'instruction passé dans le
     * formulaire d'ajout.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_ajout() {

        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $id_dossier = 
            $this->f->get_submitted_get_value('idxformulaire') : $id_dossier = "");
        //
        if ($id_dossier !== "") {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
    }

   /*
     * CONDITION - can_user_access_dossier_contexte_modification
     *
     * Vérifie que l'utilisateur a bien accès au dossier lié à la commission instanciée.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_modification() {

        $id_dossier = $this->getVal('dossier');
        //
        if ($id_dossier !== "" && $id_dossier !== null) {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commission_type_by_di() {
        return "SELECT commission_type.commission_type, commission_type.libelle FROM " . DB_PREFIXE . "commission_type WHERE commission_type.om_collectivite = <collectivite_di> AND ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE))) ORDER BY commission_type.libelle ASC";
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        //
        $crud = $this->get_action_crud($maj);
        // Le but ici est de brider les types aux types de la même commune que le dossier en cas d'ajout
        if (($this->getParameter("retourformulaire") == 'dossier_commission'
            || $this->getParameter("retourformulaire") == 'dossier_instruction')
            && ($crud == 'create' OR ($crud === null AND $maj == 0)
                || $crud === 'update' OR ($crud === null AND $maj == 1))) {
            $di = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $this->getParameter('idxformulaire'),
            ));
            $sql_commission_type_by_di = str_replace(
                '<collectivite_di>',
                $di->getVal("om_collectivite"),
                $this->get_var_sql_forminc__sql("commission_type_by_di")
            );
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "commission_type",
                $sql_commission_type_by_di,
                $this->get_var_sql_forminc__sql("commission_type_by_id"),
                true
            );
        }
    }


    /**
     * Indique si la redirection vers le lien de retour est activée ou non.
     *
     * L'objectif de cette méthode est de permettre d'activer ou de désactiver
     * la redirection dans certains contextes.
     *
     * @return boolean
     */
    function is_back_link_redirect_activated() {
        // Récupération du mode de l'action
        $crud = $this->get_action_crud();
        //
        if (($crud === 'create' || $crud === 'update')
            && $this->getParameter('retourformulaire') === 'commission') {
            //
            return false;
        }

        //
        return true;
    }


}// fin classe

