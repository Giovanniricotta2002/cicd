<?php
/**
 * DBFORM - 'dossier_message' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'dossier_message'.
 *
 * @package openads
 * @version SVN : $Id: dossier_message.class.php 6565 2017-04-21 16:14:15Z softime $
 */

require_once "../gen/obj/dossier_message.class.php";

class dossier_message extends dossier_message_gen {

    /**
     * Instance de om_utilisateur
     *
     * @var null
     */
    var $inst_om_utilisateur = null;

    /**
     * Instance de dossier
     *
     * @var null
     */
    var $inst_dossier = null;

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();

        // ACTION - 000 - ajouter
        // 
        $this->class_actions[0]["condition"] = array("is_ajoutable", "can_user_access_dossier_contexte_ajout");
        
        // ACTION - 001 - modifier
        // 
        $this->class_actions[1]["condition"] = array("is_modifiable", "can_user_access_dossier_contexte_modification");
        
        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["condition"] = array("is_supprimable", "can_user_access_dossier_contexte_modification");

        // ACTION - 010 - marquer comme lu
        //
        $this->class_actions[10] = array(
            "identifier" => "marquer_comme_lu",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Marquer comme lu"),
                "order" => 30,
                "class" => "lu-16",
            ),
            "view" => "formulaire",
            "method" => "marquer_comme_lu",
            "permission_suffix" => "modifier_lu",
            "condition" => array("is_marquable_comme_lu", "can_user_access_dossier_contexte_modification"),
        );

        // ACTION - 020 - marquer comme non lu
        //
        $this->class_actions[20] = array(
            "identifier" => "marquer_comme_non_lu",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Marquer comme non lu"),
                "order" => 30,
                "class" => "nonlu-16",
            ),
            "view" => "formulaire",
            "method" => "marquer_comme_non_lu",
            "permission_suffix" => "modifier_lu",
            "condition" => array("is_marquable_comme_non_lu", "can_user_access_dossier_contexte_modification"),
        );

        // ACTION - 030 - accusé de reception
        //
        $this->class_actions[30] = array(
            "identifier" => "accuse_reception",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("Accusé de réception"),
                "order" => 40,
                "class" => "pdf-16",
            ),
            "view" => "view_accuse_reception",
            "permission_suffix" => "consulter",
            "condition" => array(
                "is_accuse_reception_consultation"
            ),
        );

        // ACTION - 777 - redirect vers onglet message d'un dossier
        //
        $this->class_actions[777] = array(
            "identifier" => "redirect_onglet_message_ctx",
            "view" => "redirect_onglet_message_ctx",
            "permission_suffix" => "consulter",
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "dossier_message",
            "dossier",
            "type",
            "categorie",
            "emetteur",
            "destinataire",
            'to_char(date_emission ,\'DD/MM/YYYY HH24:MI:SS\') as date_emission',
            "lu",
            "contenu",
        );
    }

    /**
     * CONDITION - is_marquable_comme_lu.
     *
     * Condition pour afficher le bouton marquer comme lu
     *
     * @return boolean
     */
    public function is_marquable_comme_lu() {
        // Si déjà lu
        if ($this->getVal("lu") == "t") {
            return false;
        }
        // Si bypass
        if ($this->f->can_bypass($this->get_absolute_class_name(), "modifier_lu")){
            return true;
        }
        // Si l'utilisateur est un intructeur de la division du dossier
        if ($this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        // Si le destinataire du message est "commune" et que la collectivité du
        // DI est la même que celle de l'utilisateur connecté
        if ($this->getVal('destinataire') === 'commune') {
            // Récupère les collectivités du dossier et de l'utilisateur
            $instr_om_collectivite = $this->f->collectivite['om_collectivite_idx'];
            $inst_dossier = $this->get_inst_dossier($this->getVal('dossier'));
            $dossier_om_collectivite = $inst_dossier->getVal('om_collectivite');
            //
            if ($instr_om_collectivite === $dossier_om_collectivite) {
                return true;
            }
        }
        //
        return false;
    }


    /**
     * CONDITION - is_marquable_comme_non_lu.
     *
     * Condition pour afficher le bouton marquer comme non lu
     *
     * @return boolean
     */
    public function is_marquable_comme_non_lu() {
        // Si déjà non lu
        if ($this->getVal("lu") == "f") {
            return false;
        }
        // Si bypass
        if ($this->f->can_bypass($this->get_absolute_class_name(), "modifier_lu")){
            return true;
        }
        // Si l'utilisateur est un intructeur de la division du dossier
        if ($this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        // Si le destinataire du message est "commune" et que la collectivité du
        // DI est la même que celle de l'utilisateur
        if ($this->getVal('destinataire') === 'commune') {
            // Récupère les collectivités du dossier et de l'utilisateur
            $instr_om_collectivite = $this->f->collectivite['om_collectivite_idx'];
            $inst_dossier = $this->get_inst_dossier($this->getVal('dossier'));
            $dossier_om_collectivite = $inst_dossier->getVal('om_collectivite');
            //
            if ($instr_om_collectivite === $dossier_om_collectivite) {
                return true;
            }
        }
        //
        return false;
    }

    /**
     * VIEW - view_accuse_reception.
     *
     * Affiche le récapitulatif du dossier d'instruction.
     *
     * @return void
     */
    function view_accuse_reception() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Identifiant du dossier
        $idx = $this->get_consultation_from_contenu($this->getVal('contenu'));
        $collectivite = $this->f->getCollectivite($this->getVal('om_collectivite'));

        // Génération du PDF
        $result = $this->compute_pdf_output('etat', "ERP_ADS__PC__AR_CONSULTATION_OFFICIELLE", $collectivite, $idx);
        // Affichage du PDF
        $this->expose_pdf_output(
            $result['pdf_output'], 
            $result['filename']
        );
    }


    /**
     * VIEW - redirect_onglet_message_ctx.
     *
     * Cette vue est appelée lorsque l'on souhaite consulter l'onglet message
     * d'un dossier contentieux.
     *
     * @return void
     */
    public function redirect_onglet_message_ctx() {

        // Récupère l'instance du dossier d'instruction du message
        $inst_dossier = $this->get_inst_dossier($this->getVal('dossier'));
        // Récupère le type d'affichage du formulaire du dossier d'instruction
        $context = $inst_dossier->get_type_affichage_formulaire();

        // Récupère le filtre
        $filtre = $this->f->get_submitted_get_value('filtre');

        // Vérifie le contexte pour définir l'objet ciblé
        switch ($context) {
            case 'CTX RE':
                $obj = 'dossier_contentieux_tous_recours';
                // Si le filtre est instructeur et que l'utilisateur connecté à
                // accès au menu "MES"
                if (($filtre === 'instructeur' || $filtre === 'instructeur_ou_instructeur_secondaire')
                    && $this->f->isAccredited(array("dossier_contentieux_mes_recours", "dossier_contentieux_mes_recours_consulter"), "OR")) {
                    //
                    $obj = 'dossier_contentieux_mes_recours';
                }
                break;
            case 'CTX IN':
                $obj = 'dossier_contentieux_toutes_infractions';
                // Si le filtre est instructeur et que l'utilisateur connecté à
                // accès au menu "MES"
                if (($filtre === 'instructeur' || $filtre === 'instructeur_ou_instructeur_secondaire')
                    && $this->f->isAccredited(array("dossier_contentieux_mes_infractions", "dossier_contentieux_mes_infractions_consulter"), "OR")) {
                    //
                    $obj = 'dossier_contentieux_mes_infractions';
                }
                break;
            default:
                return;
        }

        // Lien de redirection
        $template_link = '../app/index.php?module=form&direct_link=true&obj=%s&action=3&direct_field=dossier&direct_form=dossier_message_contexte_ctx&direct_action=3&direct_idx=%s';
        $link = sprintf($template_link, $obj, $this->getVal($this->clePrimaire));

        header('Location: '.$link);
        exit();
    }


    /**
     * CONDITION - is_consultation_requete.
     *
     * Condition si le message est du bon type.
     *
     * @return boolean
     */
    function is_accuse_reception_consultation() {

        if ($this->getVal('type') != 'ERP_ADS__PC__AR_CONSULTATION_OFFICIELLE') {
            return false;
        }
        return true;
    }

    /**
     * TREATMENT - marquer_comme_lu.
     * 
     * Cette methode permet de passer la message en "lu"
     *
     * @return boolean true si maj effectué false sinon
     */
    public function marquer_comme_lu() {
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
                $this->addToMessage(_("Le message a été marqué comme lu."));
                return $this->end_treatment(__METHOD__, true);
            }

        } else {
            $this->addToMessage(_("Le message est déjà marqué comme lu."));
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, false);
    }


    /**
     * TREATMENT - marquer_comme_non_lu.
     * 
     * Cette methode permet de passer la message en "non lu"
     *
     * @return boolean true si maj effectué false sinon
     */
    public function marquer_comme_non_lu() {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        if($this->getVal("lu") == 't') {
            $this->correct = true;
            $valF = array();
            $valF["lu"] = false;

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
                $this->addToMessage(_("Le message a été marqué comme non lu."));
                return $this->end_treatment(__METHOD__, true);
            }

        } else {
            $this->addToMessage(_("Le message est déjà marqué comme non lu."));
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, false);
    }


    /**
     * CONDITION - is_ajoutable.
     *
     * Condition pour pouvoir ajouter
     *
     * @return boolean
     */
    function is_ajoutable() {
        // Si bypass
        if ($this->f->can_bypass($this->get_absolute_class_name(), "ajouter")) {
            return true;
        }
        // Test des autres conditions
        return $this->is_ajoutable_or_modifiable_or_supprimable();
    }

    /**
     * CONDITION - is_modifiable.
     *
     * Condition pour afficher le bouton modifier
     *
     * @return boolean
     */
    function is_modifiable() {
        // Test du bypass
        if($this->f->can_bypass($this->get_absolute_class_name(), "modifier")){
            return true;
        }
        // Test des autres conditions
        return $this->is_ajoutable_or_modifiable_or_supprimable();
    }

    /**
     * CONDITION - is_supprimable.
     *
     * Condition pour afficher le bouton supprimer
     * @return boolean
     */
    function is_supprimable() {
        // Test du bypass
        if($this->f->can_bypass($this->get_absolute_class_name(), "supprimer")){
            return true;
        }
        // Test des autres conditions
        return $this->is_ajoutable_or_modifiable_or_supprimable();
    }

    /**
     * Conditions pour afficher les boutons modifier et supprimer
     *
     * @return boolean
     */
    function is_ajoutable_or_modifiable_or_supprimable() {
        // Tester si le dossier est cloturé ,
        // et si l'instructeur est de la même division
        if ($this->is_instructeur_from_division_dossier() === true and
            $this->is_dossier_instruction_not_closed() === true){
            return true;
        }

        return false;
    }

    /**
     * Requête nécessaire pour la recherche avancée des messages dans les listings
     * de messages non lus. Elle présente la liste des types de message.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_messages_type() {
        return "SELECT
            DISTINCT dossier_message.type,
            dossier_message.type
        FROM
            ".DB_PREFIXE."dossier_message
            LEFT JOIN ".DB_PREFIXE."dossier
                ON dossier_message.dossier = dossier.dossier
            LEFT JOIN ".DB_PREFIXE."instructeur
                ON dossier.instructeur = instructeur.instructeur
        WHERE
            instructeur.division IN (
                SELECT 
                    division
                FROM
                    ".DB_PREFIXE."instructeur
                WHERE 
                    instructeur.om_utilisateur IN (
                        SELECT
                            om_utilisateur
                        FROM
                            ".DB_PREFIXE."om_utilisateur
                        WHERE
                            login = '".$_SESSION['login']."'
                    )
            )    
        ORDER BY
            dossier_message.type ASC";
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // import depuis de la BD les types des messages disponibles pour
        // le dossier
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "type",
            $this->get_var_sql_forminc__sql("messages_type"),
            null,
            false
        );
    }

    public function setType(&$form,$maj) {
        //type
        parent::setType($form, $maj);

        // On cache le dossier
        $form->setType('dossier','hidden');

        if ($maj == 0) { //ajouter
            $form->setType('type','hiddenstatic');
            $form->setType('emetteur','hiddenstatic');
            $form->setType('destinataire','hidden');
            $form->setType('date_emission','hidden');
            $form->setType('lu','hidden');
            $form->setType('categorie','hidden');
        }// fin ajouter

        // seulement la modification du champ lu est possible en modification
        if ($maj==1){ //modifier
            $form->setType('type','hiddenstatic');
            $form->setType('emetteur','hiddenstatic');
            $form->setType('destinataire','hiddenstatic');
            $form->setType('date_emission','hiddenstatic');
            $form->setType('lu','checkbox');
            $form->setType('contenu','textareahiddenstatic');
            $form->setType('categorie','hiddenstatic');
        }// fin modifier

        // Pour les actions marquer_comme_lu, marquer_comme_non_lu
        if($maj == 10 || $maj == 20) {
            //
            foreach ($this->champs as $value) {
                // Cache tous les champs
                $form->setType($value, 'hidden');
            }
        }
    }


    public function setOnchange(&$form, $maj) {
        parent::setOnchange($form, $maj);

        // JS de contrôle de la date
        $form->setOnchange('date_emission','fdate(this)');
    }


    public function setLib(&$form, $maj) {
        parent::setLib($form, $maj);

        //
        $form->setLib('dossier_message',_('message'));
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        if ($maj == 0) {
            $form->setVal("type", _("message manuel"));
            $form->setVal("emetteur", $this->f->get_connected_user_login_name());
            $form->setVal("date_emission", date("Y-m-d H:i:s"));
            $form->setVal("destinataire", "instructeur");
            $form->setVal("categorie", "interne");
            /*
            * Si l'emetteur est l'instructeur du dossier, et que leurs collectivités
            * respectives sont différentes, le destinataire est 'commune'
            */
            // Récupère l'identifiant instructeur de l'emetteur
            $inst_all_om_utilisateur = $this->get_inst_om_utilisateur(0);
            $om_utilisateur = get_object_vars($this->f)["om_utilisateur"]["om_utilisateur"];
            $emetteur_instr_id = (isset($inst_all_om_utilisateur) === true && isset($om_utilisateur) === true) ? $inst_all_om_utilisateur->get_instructeur_by_om_utilisateur($om_utilisateur) : "";
            // Récupère l'identifiant instructeur du dossier
            $inst_dossier = $this->get_inst_dossier($idxformulaire);
            $di_instructeur = $inst_dossier->getVal("instructeur");
            // Si l'emetteur est l'instructeur du dossier
            if ($emetteur_instr_id === $di_instructeur) {
                $form->setVal("lu", true);
                $instr_om_collectivite = $this->f->collectivite["om_collectivite_idx"];
                $dossier_om_collectivite = $inst_dossier->getVal("om_collectivite");
                // Si l'instructeur affecté au dossier est d'une collectivité
                // différente
                if (intval($instr_om_collectivite) !== intval($dossier_om_collectivite)) {
                    $form->setVal("destinataire", "commune");
                    $form->setVal("lu", false);
                }
            }
        }
    }

    /**
     * Surcharge du fil d'ariane en contexte sous-formulaire.
     *
     * @param string $subent Chaîne initiale.
     *
     * @return string
     */
    public function getSubFormTitle($subent) {
        //
        $subent = _("dossiers d'instruction")." -> "._("message")." -> ".$this->getVal('dossier_message');
        //
        return $subent;
    }


    /**
     * Ajoute un message de notification.
     * Par défaut si le message est déclenché par une action de l'instructeur
     * il sera considéré comme lu. Si le paramètre $nonLu vaut true alors même
     * si le message est créé suite à une action de l'instructeur il sera marqué
     * comme non lu.
     *
     * Si le paramètre exists vaut true et que plusieurs actions déclenchent l'envoi
     * de message de même type (exemple : Ajout de pièce(s)), alors, tant que le
     * message est "non lu" seul le premier sera ajouté et pas les suivants.
     * Tant que le premier message ne passe pas en état lu, il n'y aura pas
     * d'ajout de message de même type le même jour.
     *
     * @param array $val Liste des valeurs.
     * @param boolean $nonLu permet de forcer un message comme étant non Lu.
     * @param boolean $exists
     *
     * @return boolean
     */
    public function add_notification_message(array $val, $nonLu = false, $exists = false) {

        // Liste des valeurs nécessaires à la création du message
        $dossier = $val['dossier'];
        $type = $val['type'];
        $emetteur = $val['emetteur'];
        $login = $val['login'];
        $date_emission = $val['date_emission'];
        $contenu = $val['contenu'];
        $categorie = isset($val['categorie']) ? $val['categorie'] : 'interne';
        $destinataire = 'instructeur';

        // Récupère l'identifiant instructeur de l'emetteur
        $inst_all_om_utilisateur = $this->get_inst_om_utilisateur(0);
        $instructeur = $inst_all_om_utilisateur->get_instructeur_by_om_utilisateur_login($login);

        // Récupère l'instructeur du dossier
        $inst_dossier = $this->get_inst_dossier($dossier);
        $di_instructeur = $inst_dossier->getVal('instructeur');

        // Vérifie si l'instructeur est affecté au dossier
        $transmitter_is_dossier_instructor = false;
        if ($instructeur !== ''
            && $instructeur !== null
            && $instructeur === $di_instructeur) {
            //
            $transmitter_is_dossier_instructor = true;
        }

        // Si l'émetteur est l'instructeur affecté au dossier
        if ($transmitter_is_dossier_instructor === true) {
            // Récupère la collectivité de l'instructeur et du dossier
            $instr_om_collectivite = $this->f->collectivite['om_collectivite_idx'];
            $dossier_om_collectivite = $inst_dossier->getVal('om_collectivite');

            // Si l'instructeur affecté au dossier est d'une collectivité
            // différente
            if (intval($instr_om_collectivite) !== intval($dossier_om_collectivite)) {
                //
                $destinataire = 'commune';
            }
        }

        // Gestion des message déjà existant
        if ($exists === true) {
            // Requête SQL de recherche des messages
            $sql = sprintf(
                'SELECT
                    count(dossier_message)
                FROM
                    %1$sdossier_message
                WHERE
                    dossier = \'%2$s\'
                    AND type = \'%3$s\'
                    -- Permet de récupérer seulement la date sans l\'\'heure, les minutes et les secondes
                    AND date_trunc(\'day\', date_emission) = date_trunc(\'day\', timestamp \'%4$s\')
                    AND emetteur = \'%5$s\'
                    AND destinataire = \'%6$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier),
                $this->f->db->escapeSimple($type),
                $this->f->db->escapeSimple($date_emission),
                $this->f->db->escapeSimple($emetteur),
                $this->f->db->escapeSimple($destinataire)
            );
            // Si l'emetteur n'est pas l'instructeur du dossier ou que le
            // destinataire du message est la commune
            if ($transmitter_is_dossier_instructor == false
                || $destinataire === 'commune') {
                // Vérifie que le message ne soit pas lu
                $sql .= 'AND lu IS FALSE';
            }
            
            $qres = $this->f->get_one_result_from_db_query(
                $sql,
                array(
                    "origin" => __METHOD__,
                )
            );
            // Si au moins un message identique existe
            if ($qres["result"] !== '0') {
                // Stop le traitement
                return true;
            }
        }

        // Valeur du champ lu
        $lu = $transmitter_is_dossier_instructor && (! $nonLu);
        //
        if ($destinataire === 'commune') {
            //
            $lu = false;
        }

        // Liste des valeurs
        $val = array();
        $val['dossier_message'] = '';
        $val['dossier'] = $dossier;
        $val['type'] = $type;
        $val['emetteur'] = $emetteur;
        $val['date_emission'] = $date_emission;
        $val['lu'] = $lu;
        $val['contenu'] = $contenu;
        $val['categorie'] = $categorie;
        $val['destinataire'] = $destinataire;
        // Ajoute un message
        $add = $this->ajouter($val);
        // Si une erreur se produit pendant l'ajout
        if ($add !== true) {
            //
            return false;
        }

        //
        return true;
    }


    /**
     * Récupère l'instance de om_utilisateur.
     *
     * @param string $om_utilisateur Identifiant de l'utilisateur.
     *
     * @return object
     */
    private function get_inst_om_utilisateur($om_utilisateur = null) {
        //
        return $this->get_inst_common("om_utilisateur", $om_utilisateur);
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
     * Vérifie que l'utilisateur a bien accès au dossier lié au message instancié.
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
     * A partir d'un dossier déjà traiter par l'application
     * retourne le numero de consultation
     * 
     * @param string le champs contenu du dossier message
     * 
     * @return string
    */
    function get_consultation_from_contenu($contenu) {
        $elems = explode("\n", $contenu);
        foreach ($elems as $key => $value) {
            if ($this->f->starts_with($value, "consultation :") === true) {
                $consultation = str_replace(
                    "consultation :",
                    "",
                    $value
                );
                return trim($consultation);
            }
        }
        return null;
    }


}


