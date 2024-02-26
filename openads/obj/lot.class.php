<?php
/**
 * DBFORM - 'lot' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once ("../gen/obj/lot.class.php");

class lot extends lot_gen {

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        //
        parent::init_class_actions();

        // ACTION - 001 - ajouter
        //        
        $this->class_actions[0]["condition"] = array("is_ajoutable", "can_user_access_dossier_contexte_ajout");
        
        // ACTION - 001 - modifier
        // 
        $this->class_actions[1]["condition"] = array("is_modifiable", "can_user_access_dossier_contexte_modification");
        
        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["condition"] = array("is_supprimable", "can_user_access_dossier_contexte_modification");

        // ACTION - 100 - donnees_techniques
        // Affiche dans un overlay les données techniques
        $this->class_actions[100] = array(
            "identifier" => "donnees_techniques",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => _("Données techniques"),
                "order" => 100,
                "class" => "rediger-16",
            ),
            "view" => "view_donnees_techniques",
            "permission_suffix" => "donnees_techniques_consulter",
            "condition" => "can_user_access_dossier_contexte_modification",
        );

        // ACTION - 100 - transferer_lot_nouveaux_demandeurs
        // Transfert les lots de demandeur
        $this->class_actions[110] = array(
            "identifier" => "transferer_lot_nouveaux_demandeurs",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Transferer ce lot aux nouveaux demandeurs"),
                "order" => 110,
                "class" => "transferer-16",
            ),
            "permission_suffix" => "transferer",
            "method" => "transferer_lot_demandeurs",
            "condition" => "can_user_access_dossier_contexte_modification",
        );
    }

    /**
     * TREATMENT - transferer_lot_demandeurs.
     * 
     * Permet de permet de transferer les lots aux nouveau demandeur.
     * 
     *
     * @param array $val  valeurs soumises par le formulaire
     * @param null  $dnu1 @deprecated Ancienne ressource de base de données.
     * @param null  $dnu2 @deprecated Ancien marqueur de débogage.
     *
     * @return boolean
     */
    function transferer_lot_demandeurs($val = array(), &$dnu1 = null, $dnu2 = null) {

        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);


        /*Donnees*/
        $idxDossier = $this->getVal("dossier");
        //Si les liaisons n'existent pas déjà
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    lot.lot,
                    lien_lot_demandeur.demandeur
                FROM
                    %1$slien_dossier_demandeur
                    INNER JOIN %1$slien_lot_demandeur
                        ON lien_lot_demandeur.demandeur = lien_dossier_demandeur.demandeur
                    INNER JOIN %1$slot
                        ON lot.lot = %2$d
                WHERE
                    lien_dossier_demandeur.dossier = \'%3$s\'',
                DB_PREFIXE,
                intval($this->getVal($this->clePrimaire)),
                $this->f->db->escapeSimple($idxDossier)
            ),
            array(
                'origin' => __METHOD__,
                'force_result' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($qres['messsage'], $qres['messsage'], '');
            $this->correct = false;
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }
        
        // Récupère la liste des demandeurs associés aux lot et dossier d'instruction
        $listDemandeurLie = array();
        if ($qres['row_count'] > 0) {

            $i = 0;
            foreach ($qres['result'] as $row) {
                $listDemandeurLie[$i++] = $row['demandeur'];
            }
        }
        echo (" nbDossierDemandeurIJ: " . $qres['row_count']);
        
        // Récupère les demandeurs du dossier d'instruction
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    lien_dossier_demandeur.demandeur as demandeur, 
                    lien_dossier_demandeur.petitionnaire_principal as pp
                FROM
                    %1$slien_dossier_demandeur
                WHERE
                    lien_dossier_demandeur.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idxDossier)
            ),
            array(
                'origin' => __METHOD__,
                'force_result' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($qres['message'], $qres['message'], '');
            $this->correct = false;
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }
        
        echo (" nbDossierDemandeurWD: " . $qres['row_count']);
        
        // Transfert des demandeurs entre le dossier et le lot
        if (count($listDemandeurLie) != $qres['row_count']) {
            
            //Supprime les anciens liens
            $sql = "DELETE FROM ".DB_PREFIXE."lien_lot_demandeur 
                    WHERE lien_lot_demandeur.lot = ".$this->getVal($this->clePrimaire);

            $res2 = $this->f->db->query($sql);

            echo (" delLotDemandeur: " . $res2);
            $this->addToLog(__METHOD__."(): db->query(\"".$sql."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res2, true) !== false) {
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db($res2->getDebugInfo(), $res2->getMessage(), '');
                $res2->free();
                $this->correct = false;
                // Termine le traitement
                return $this->end_treatment(__METHOD__, false);
            }
            
            $ret = "";


            // Créé autant de liaisons que de demandeurs liés au dossier d'instruction
            foreach ($qres['result'] as $row) {
                
                if (!in_array($row['demandeur'], $listDemandeurLie)){
                       
                    $valLLD = array();
                    $valLLD['lien_lot_demandeur'] = NULL;
                    $valLLD['lot'] = $this->getVal($this->clePrimaire);
                    $valLLD['demandeur'] = $row['demandeur'];
                    $valLLD['petitionnaire_principal'] = $row['pp'];
                        
                    $lld = $this->f->get_inst__om_dbform(array(
                        "obj" => "lien_lot_demandeur",
                        "idx" => "]",
                    ));
                    $lld->valF = array();
                                            
                    $lld->ajouter($valLLD) ;
                    
                    $qres2 = $this->f->get_all_results_from_db_query(
                        sprintf(
                            'SELECT
                                civilite.code as code, 
                                CASE WHEN demandeur.qualite = \'particulier\'
                                    THEN TRIM(CONCAT(demandeur.particulier_nom, \' \', demandeur.particulier_prenom)) 
                                    ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, \' \', demandeur.personne_morale_denomination)) 
                                END as nom
                            FROM
                                %1$sdemandeur
                                LEFT JOIN %1$scivilite
                                    ON demandeur.particulier_civilite = civilite.civilite
                                        OR demandeur.personne_morale_civilite = civilite.civilite
                            WHERE
                                demandeur.demandeur = %2$d',
                            DB_PREFIXE,
                            intval($row['demandeur'])
                        ),
                        array(
                            'origin' => __METHOD__,
                            'force_result' => true
                        )
                    );
                    if ($qres2['result'] !== 'OK') {
                        // Appel de la methode de recuperation des erreurs
                        $this->erreur_db($qres2['message'], $qres2['message'], '');
                        $this->correct = false;
                        // Termine le traitement
                        return $this->end_treatment(__METHOD__, false);
                    }

                    $row = array_shift($qres2['result']);
                    $ret .= $row['code']. " " . $row['nom'] . "<br/>" ;

                }
            }
            
            //Envoie du message de retour
            $this->addToMessage(_("Transfert effectue avec succès"));
        }
        //Sinon
        else {
            //Envoie du message de retour
            $this->addToMessage(_("Les demandeurs ont déjà été transférés"));
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Ouvre le sous-formulaire passé en paramètre en overlay
     * en mode ajout si aucun n'existe sinon en mode modifier.
     *
     * @return void
     */
    function display_overlay($idx = "", $obj = "") {
        // Seulement si le numéro de dossier est fourni
        if (isset($idx) && !empty($idx) 
            && isset($obj) && !empty($obj)){

            // Vérifie que l'objet n'existe pas
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        donnees_techniques
                    FROM
                        %1$sdonnees_techniques
                    WHERE
                        donnees_techniques.lot = %2$d',
                    DB_PREFIXE,
                    intval($idx)
                ),
                array(
                    'origin' => __METHOD__
                )
            );

            // S'il n'y en a pas, afficher le formulaire d'ajout
            if ($qres['row_count'] == 0) {
                //
                echo '
                    <script type="text/javascript" >
                        overlayIt(\''.$obj.'\',\''.OM_ROUTE_SOUSFORM.'&obj=donnees_techniques'. 
                            '&retourformulaire=lot&action=0&idxformulaire='. $idx. '\', 1);
                    </script>
                ';
            }
            // Sinon afficher l'objet en consultation
            else {
                //
                $row = array_shift($qres['result']);
                //
                echo '
                    <script type="text/javascript" >
                        overlayIt(\''.$obj.'\',\''.OM_ROUTE_SOUSFORM.'&obj=donnees_techniques'. 
                            '&retourformulaire=lot&action=5&idxformulaire='. $idx. '&idx=' . $row['donnees_techniques'] .'&objsf='.$obj.'\', 1);
                    </script>
                ';
            }
        }
    }

    /**
     * CONDITION - is_ajoutable.
     *
     * Condition pour pouvoir ajouter
     *
     * @return boolean
     */
    function is_ajoutable() {
        // Test du bypass
        if ($this->f->isAccredited("lot_ajouter_bypass")) {
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
        if ($this->f->isAccredited("lot_modifier_bypass")) {
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
        if ($this->f->isAccredited("lot_supprimer_bypass")) {
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
     * VIEW - view_donnees_techniques.
     *
     * Ouvre le sous-formulaire en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_donnees_techniques() {
        $dossier = $this->getVal("dossier");
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        //
        $this->display_overlay(
            $this->getVal($this->clePrimaire),
            "donnees_techniques"
        );
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        // Le parent n'est pas appelé délibérament pour cause de performance.
        // En effet, celui-ci charge toutes les données de la table dossier et
        // de la table dossier_autorisation.
        // parent::setSelect($form, $maj);
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggerajouterapres($id, $dnu1, $val);

        // Si en sous-formulaire
        if($this->getParameter("idxformulaire") != "") {

            // Insertion du lien demandeur/lot
            $lld = $this->f->get_inst__om_dbform(array(
                "obj" => "lien_lot_demandeur",
                "idx" => "]",
            ));

            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        *
                    FROM
                        %1$slien_dossier_demandeur
                    WHERE
                        dossier = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($this->getParameter("idxformulaire"))
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            foreach ($qres['result'] as $row) {
                unset($row['lien_dossier_demandeur']);
                unset($row['dossier']);
                $row['lien_lot_demandeur'] = "";
                $row['lot'] = $this->valF["lot"];
                $lld->ajouter($row);
            }

            // Ajoute une ligne dans les données techniques
            $add_dt = $this->add_donnees_techniques();
            //
            if ($add_dt === false) {
                //
                $this->addToMessage(_("Impossible d'associer des données techniques au lot.")." "._("Veuillez contacter votre administrateur."));
                return false;
            }
        }

        //
        return true;
    }

    /**
     * Cache le champ dossier_autorisation
     */
    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        
        $form->setType('dossier_autorisation', 'hidden');
        $form->setType('dossier','hidden');
        
        if($maj == "110") {
            $form->setType('lot', 'hidden');
            $form->setType('libelle', 'hidden');
            $form->setType('dossier_autorisation', 'hidden');
            $form->setType('dossie', 'hidden');
        }
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $this->retourformulaire = $retourformulaire;
        //
        if ($validation == 0) {
            $is_in_context_of_di = $this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire"));
            $is_in_context_of_da = $this->is_in_context_of_foreign_key("dossier_autorisation", $this->getParameter("retourformulaire"));
            //
            if ($is_in_context_of_di === true) {
                $form->setVal("dossier", $this->getParameter("idxformulaire"));
                $inst_di = $this->get_inst_dossier($this->getParameter("idxformulaire"));
                $form->setVal("dossier_autorisation", $inst_di->getVal("dossier_autorisation"));
            }
            //
            if ($is_in_context_of_da === true) {
                $form->setVal("dossier_autorisation", $this->getParameter("idxformulaire"));
            }
        }
    }

    /**
     * Ajout de la liste des demandeurs
     */
    function sousformSpecificContent($maj) {

        //En consultation
        if ( $maj == 3 ){
            
            //Récupère la liste des demandeurs
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        civilite.code as code, 
                        CASE WHEN demandeur.qualite = \'particulier\' 
                            THEN TRIM(CONCAT(demandeur.particulier_nom, \' \', demandeur.particulier_prenom)) 
                            ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, \' \', demandeur.personne_morale_denomination)) 
                        END as nom,
                        lien_lot_demandeur.petitionnaire_principal as petitionnaire_principal,
                        demandeur.type_demandeur as type_demandeur
                    FROM
                        %1$slien_lot_demandeur
                        LEFT JOIN %1$sdemandeur
                            ON lien_lot_demandeur.demandeur = demandeur.demandeur
                        LEFT JOIN %1$scivilite
                            ON demandeur.particulier_civilite = civilite.civilite OR
                            demandeur.personne_morale_civilite = civilite.civilite
                    WHERE
                        lien_lot_demandeur.lot = %2$d
                    ORDER BY
                        demandeur.type_demandeur DESC',
                    DB_PREFIXE,
                    intval($this->val[array_search('lot', $this->champs)])
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            //Affichage des données
            echo "<div class=\"field field-type-static\">";
                echo "<div class=\"form-libelle\">";
                    echo "<label id=\"lib-libelle\" class=\"libelle-demandeur\" for=\"demandeur\">";
                        echo _("demandeur");
                    echo "</label>";
                echo "</div>";
                echo "<div class=\"form-content\">";
                    echo "<span id=\"demandeur\" class=\"field_value\">";
            
                        $listDemandeur = "";
                        //La liste des demandeurs
                        foreach ($qres['result'] as $row) {
                     
                            //Ordonne l'affichage des demandeur
                            if ( $row['petitionnaire_principal'] == 't' ){
                                
                                $listDemandeur =  $row['code']. " " . $row['nom'] . ", " . _("petitionnaire principal") . "<br/>".$listDemandeur;
                            }
                            else {
                                
                                $listDemandeur .=  $row['code']. " " . $row['nom'] . ", " . $row['type_demandeur'] . "<br/>";
                            }
                        }
                        echo $listDemandeur;
                    echo "</span>";
                echo "</div>";
            echo "</div>";
        }
    }


    /**
     * Retourne true s'il y a des données techniques lié au dossier d'instruction
     * @param string $idx Identifiant du dossier d'instruction
     * @return boolean S'il y a des données techniques
     */
    function hasDonneesTechniquesDossier($idx){
        
        //Si l'identifiant du dossier d'instruction founi est correct
        if ( $idx != '' ){
            
            //On récupère le statut de l'état du dossier d'instruction à partir de 
            //l'identifiant du dossier
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        donnees_techniques.donnees_techniques
                    FROM
                        %1$sdonnees_techniques
                        LEFT JOIN %1$sdossier
                            ON donnees_techniques.dossier_instruction = dossier.dossier
                    WHERE
                        dossier.dossier = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($idx)
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            if ($qres['row_count'] > 0 ){
                return TRUE;
            }
        }
        return FALSE;
    }


    /**
     * Cette méthode est appelée lors de la suppression d’un objet, elle permet
     * de vérifier si l’objet supprimé n’est pas lié à une autre table pour en
     * empêcher la suppression.
     *
     * @param mixed $id Identifiant de l'objet.
     *
     * @return boolean
     */
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // Surcharge pour éviter les contrôles sur les tables liées en cas
        // de suppression
        return true;
    }


    /**
     * Supprime le lien entre le lot et les demandeurs.
     *
     * @param integer $lot Identifiant de l'objet.
     *
     * @return boolean
     */
    protected function delete_lien_lot_demandeur($lot) {

        // SQL
        $sql = "DELETE FROM ".DB_PREFIXE."lien_lot_demandeur
                WHERE lot = ".$lot;
        // Résultat
        $res = $this->f->db->query($sql);
        // Log
        $this->f->addToLog(__METHOD__."() : db->query(\"".$sql."\")", VERBOSE_MODE);
        //
        if ($this->f->isDatabaseError($res, true)) {
            return false;
        }

        //
        return true;
    }


    /**
     * Supprime les données techniques liées.
     *
     * @param integer $lot Identifiant de l'objet.
     *
     * @return boolean
     */
    protected function delete_donnees_techniques($lot) {

        // SQL
        $sql = "DELETE FROM ".DB_PREFIXE."donnees_techniques
                WHERE lot = ".$lot;
        // Résultat
        $res = $this->f->db->query($sql);
        // Log
        $this->f->addToLog(__METHOD__."() : db->query(\"".$sql."\")", VERBOSE_MODE);
        //
        if ($this->f->isDatabaseError($res, true)) {
            return false;
        }

        //
        return true;
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // Suppression du lien entre le lot et les demandeurs
        $delete_lien_lot_demandeur = $this->delete_lien_lot_demandeur($id);
        if ($delete_lien_lot_demandeur === false) {
            return false;
        }

        // Suppression des données techniques lié au lot
        $delete_donnees_techniques = $this->delete_donnees_techniques($id);
        if ($delete_donnees_techniques === false) {
            return false;
        }

        //
        return true;
    }

    /**
     * Ajout les données techniques au lot.
     *
     * @return boolean
     */
    protected function add_donnees_techniques() {

        // Instancie la classe donnees_techniques en ajout
        $inst_dt = $this->f->get_inst__om_dbform(array(
            "obj" => "donnees_techniques",
            "idx" => "]",
        ));

        // Toutes les valeurs sont mis à null
        foreach($inst_dt->champs as $value) {
            //
            $valF[$value] = null;
        }

        // Ajout de l'identifiant du lot
        $valF['lot'] = $this->valF[$this->clePrimaire];
        // Identifiant du CERFA
        $valF['cerfa'] = $this->get_cerfa_id_by_dossier_autorisation($this->valF['dossier_autorisation']);
        // Si aucun CERFA n'est identifié
        if ($valF['cerfa'] === '' || $valF['cerfa'] === null) {
            //
            $this->f->addToLog(__METHOD__."() : ERROR - "._("Aucun CERFA paramétré."), DEBUG_MODE);
            return false;
        }

        // Ajoute l'enregistrement dans la table donnees_techniques
        $add = $inst_dt->ajouter($valF);
        //
        if ($add === false) {
            //
            $this->f->addToLog(__METHOD__."() : ERROR - "._("Impossible d'ajouter les données techniques du lot."), DEBUG_MODE);
            return false;
        }

        //
        return true;
    }


    /**
     * Récupère l'instance du dossier.
     *
     * @param string $dossier_autorisation Identifiant de l'objet.
     *
     * @return object
     */
    public function get_inst_dossier_autorisation($dossier_autorisation = null) {
        //
        return $this->get_inst_common("dossier_autorisation", $dossier_autorisation);
    }


    /**
     * Récupère l'instance du dossier.
     *
     * @param integer $dossier_autorisation_type_detaille Identifiant de l'objet.
     *
     * @return object
     */
    public function get_inst_dossier_autorisation_type_detaille($dossier_autorisation_type_detaille) {
        //
        return $this->get_inst_common("dossier_autorisation_type_detaille", $dossier_autorisation_type_detaille);
    }


    /**
     * Récupère le cerfa des lots pour afficher les bonnes données techniques.
     *
     * @param string $da Identifiant de l'objet.
     *
     * @return integer
     */
    public function get_cerfa_id_by_dossier_autorisation($da) {

        // Instancie le dossier d'autorisation
        $inst_da = $this->get_inst_dossier_autorisation($da);

        // Instancie le type détaillé du dossier d'autorisation
        $inst_datd = $this->get_inst_dossier_autorisation_type_detaille($inst_da->getVal('dossier_autorisation_type_detaille'));

        //
        return $inst_datd->getVal('cerfa_lot');

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
     * Vérifie que l'utilisateur a bien accès au dossier lié au lot instanciée.
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


}// fin classe

