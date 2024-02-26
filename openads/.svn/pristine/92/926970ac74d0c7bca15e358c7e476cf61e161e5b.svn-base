<?php
/**
 * DBFORM - 'etat' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'etat'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/etat.class.php";

class etat extends etat_gen {

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "etat.etat",
            "etat.libelle",
            "etat.statut",
            "array_to_string(array_agg(transition.evenement ORDER BY transition.evenement), ';') as evenement",
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
                LEFT JOIN %1$stransition
                    ON transition.etat=etat.etat',
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
        return " GROUP BY etat.etat, libelle ";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement ORDER BY evenement.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement IN (<idx>) ORDER BY evenement.libelle";
    }

    function setType(&$form, $maj) {
        //
        parent::setType($form, $maj);
        //type
        if ($maj==0){ //ajout
            $form->setType('statut', 'select');
            $form->setType('evenement','select_multiple');
        }// fin ajout
        if ($maj==1){ //modifier
            $form->setType('statut', 'select');
            $form->setType('evenement','select_multiple');
        }// fin modifier
        if ($maj==2){ //supprimer
            $form->setType('statut', 'selectstatic');
            $form->setType('evenement','select_multiple_static');
        }//fin supprimer
        if ($maj==3){ //consulter
            $form->setType('statut', 'selectstatic');
            $form->setType('evenement','select_multiple_static');
        }//fin consulter
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // evenement
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "evenement",
            $this->get_var_sql_forminc__sql("evenement"),
            $this->get_var_sql_forminc__sql("evenement_by_id"),
            false,
            true
        );
        // Statut
        $contenu = array(
            0 => array('cloture', 'encours',),
            1 => array(_('Cloture'), _('En cours'),)
        );
        $form->setSelect("statut",$contenu);
    }
    
    //Nombre de evenement affiché
    function setTaille(&$form, $maj) {
        
        parent::setTaille($form, $maj);
        $form->setTaille("evenement", 5);
    }
    
    //Nombre de evenement maximum
    function setMax(&$form, $maj) {
        
        parent::setMax($form, $maj);
        $form->setMax("evenement", 5);
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggerajouterapres($id, $dnu1, $val);
        // Ajoute autant de transitions que d'événements
        // Récupère les données du select multiple
        $evenements = $this->getPostedValues('evenement');
        // Ne traite les données que s'il y en a et qu'elles sont correctes
        if (is_array($evenements) && count($evenements) > 0) {
            $nb_tr = 0;
            // Va créer autant de transition que d'événements choisis
            foreach ($evenements as $value) {
                // Test si la valeur par défaut est sélectionnée
                if ($value != "") {
                    //Données
                    $donnees = array(
                        'etat' => $this->valF['etat'],
                        'evenement' => $value
                    );
                    //Ajoute une nouvelle transition
                    $this->addTransition($donnees);
                    $nb_tr++;
                }
            }
            // Message de confirmation de création de(s) transition(s).
            if ($nb_tr > 0) {
                if ($nb_tr == 1) {
                    $this->addToMessage(_("Creation de ").$nb_tr._(" nouvelle transition 
                        realisee avec succes."));
                } else {
                    $this->addToMessage(_("Creation de ").$nb_tr._(" nouvelles transitions 
                        realisee avec succes."));
                }
            }
        }
    }
    
    //Fonction générique permettant de récupérer les données d'un champ postées
    function getPostedValues($champ) {
        
        // Récupération des demandeurs dans POST
        if ($this->f->get_submitted_post_value($champ) !== null) {
            
            return $this->f->get_submitted_post_value($champ);
        }
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggermodifierapres($id, $dnu1, $val);
        // Supprime toutes les transitions liées à l'état
        $this->deleteAllTransitionEtat($this->valF['etat']);
        // Récupère les données du select multiple
        $evenements = $this->getPostedValues('evenement');
        // Ne traite les données que s'il y en a et qu'elles sont correctes
        if (is_array($evenements) && count($evenements) > 0) {
            $nb_tr = 0;
            // Va créer autant de transition que d'événements choisis
            foreach ($evenements as $value) {
                // Test si la valeur par défaut est sélectionnée
                if ($value != "") {
                    //Données
                    $donnees = array(
                        'etat' => $this->valF['etat'],
                        'evenement' => $value
                    );
                    //Ajoute une nouvelle transition
                    $this->addTransition($donnees);
                    $nb_tr++;
                }
            }
            //Message de confirmation de création de(s) transition(s).
            if ($nb_tr > 0) {
                $this->addToMessage(_("Mise a jour des liaisons avec transition realisee avec succes."));
            }
        }
    }

    //Ajoute une nouvelle transition
    // $data array de données
    function addTransition($data) {
        $transition = $this->f->get_inst__om_dbform(array(
            "obj" => "transition",
            "idx" => "]",
        ));
        $transition->valF = array();
    
        //Données
        $valTransi['transition']=NULL;
    
        if ( is_array($data) ){
            
            foreach ($data as $key => $value) {
                
                $valTransi[$key]=$value;
            }            
        }
    
        $transition->ajouter($valTransi);
    }

    //Supprime toutes les transitions liées à un état
    function deleteAllTransitionEtat($id) {
            
        //Création de la requête
        $sql = "DELETE FROM ".DB_PREFIXE."transition WHERE etat like '$id'";
        
        //Exécution de la requête
        $res = $this->f->db->query($sql);
        $this->addToLog(
            __METHOD__."(): db->query(\"".$sql."\");",
            VERBOSE_MODE
        );
        $this->f->isDatabaseError($res);
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Supprime toutes les transitions liées à l'état
        $this->deleteAllTransitionEtat($id);
    }

    /* Surcharge de la fonction cleSecondaire pour qu'elle ne vérifie pas le lien avec 
     * transition qui sera supprimé juste après*/ 
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {

        // Verification de la cle secondaire : dossier
        $this->rechercheTable($dnu1, "dossier", "etat", $id);
        // Verification de la cle secondaire : evenement
        $this->rechercheTable($dnu1, "evenement", "etat", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($dnu1, "instruction", "etat", $id);
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        if ($maj == 2 && $validation == 1) {
            // Affichage des evenement anciennement liés
            $form->setVal("evenement", $this->val[3]);
        }
    }
}


