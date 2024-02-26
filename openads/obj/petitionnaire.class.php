<?php
/**
 * DBFORM - 'petitionnaire' - Surcharge obj.
 *
 * Ce script permet de définir la classe 'petitionnaire'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/demandeur.class.php";

/*
 * Classe qui hérite de la classe demandeur
 */
class petitionnaire extends demandeur {

    /**
     *
     */
    protected $_absolute_class_name = "petitionnaire";

    // {{{ Gestion de la confidentialité des données spécifiques
    
    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        parent::init_class_actions();

        // ACTION - 003 - consulter
        //
        $this->class_actions[3]["condition"] = "is_user_from_allowed_collectivite";

        // ACTION - 100 - non_frequent
        // Finalise l'enregistrement
        $this->class_actions[100] = array(
            "identifier" => "non_frequent",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Marquer non frequent"),
                "order" => 100,
                "class" => "radiation-16",
            ),
            "view" => "formulaire",
            "method" => "set_non_frequent",
            "permission_suffix" => "modifier_frequent",
            "condition" => array("is_frequent"),
        );

        // ACTION - 110 - recuperer_frequent
        // Finalise l'enregistrement
        $this->class_actions[110] = array(
            "identifier" => "recuperer_frequent",
            "view" => "formulaire",
            "method" => "modifier",
            "button" => "valider",
            "permission_suffix" => "modifier",
        );
    }

    //}}}
    
    /**
     * Retourne true si pétitionnaire frequent false sinon.
     *
     * @return boolean retourne true si frequent false sinon.
     */
    function is_frequent() {
        if($this->getVal("frequent") == 't') {
            return true;
        }
        return false;
    }

    /**
     * Vérifie que le pétitionnaire n'est pas fréquent.
     *
     * @return boolean
     */
    function is_not_frequent() {
        //
        if ($this->is_frequent() === false) {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * TREATMENT - set_non_frequent.
     * 
     * Cette methode permet de passer le pétitionnaire en non fréquent.
     *
     * @return boolean true si maj effectué false sinon
     */
    function set_non_frequent($val) {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        if($this->getVal("frequent") == 't') {
            $this->correct = true;
            $valF = array();
            $valF["frequent"] = false;

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
                $this->addToMessage(_("Mise a jour effectuee avec succes"));
                return $this->end_treatment(__METHOD__, true);
            }

        } else {
            $this->addToMessage(_("Element deja frequent"));
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, false);
    }

    /*
     * Cache le champ type_demandeur.
     */
    function setType(&$form,$maj) {
        parent::setType($form,$maj);

        // On définit le type des champs pour les actions direct
        // utilisant la vue formulaire
        if ($maj == 100) {
            foreach ($this->champs as $key => $value) {
                $form->setType($value, 'hidden');
            }
        }

        if($maj == 3) {
            // En consultation le bouton "Sauvegarder" n'a pas lieu d'être
            $form->setType('frequent','hidden');
            // Gestion de la catégorie de personne
            if ($this->getVal('qualite') == 'particulier') {
                $form->setType('personne_morale_denomination','hidden');
                $form->setType('personne_morale_raison_sociale','hidden');
                $form->setType('personne_morale_siret','hidden');
                $form->setType('personne_morale_categorie_juridique','hidden');
                $form->setType('personne_morale_nom','hidden');
                $form->setType('personne_morale_prenom','hidden');
                $form->setType('personne_morale_civilite','hidden');
            } else {
                $form->setType('particulier_civilite','hidden');
                $form->setType('particulier_nom','hidden');
                $form->setType('particulier_prenom','hidden');
                $form->setType('particulier_date_naissance','hidden');
                $form->setType('particulier_commune_naissance','hidden');
                $form->setType('particulier_departement_naissance','hidden');
                $form->setType('particulier_pays_naissance','hidden');
            }
        }

        // Champs disabled pour la modif de petitionnaires frequents 
        if ($maj==110 or $maj==1) { //modifier
            if($this->getVal('frequent') == 't') {
                $form->setType('qualite','selecthiddenstatic');
                $form->setType('particulier_nom','static');
                $form->setType('particulier_prenom','static');
                $form->setType('particulier_date_naissance','datestatic');
                $form->setType('particulier_commune_naissance','static');
                $form->setType('particulier_departement_naissance','static');
                $form->setType('particulier_pays_naissance','static');
                $form->setType('personne_morale_denomination','static');
                $form->setType('personne_morale_raison_sociale','static');
                $form->setType('personne_morale_siret','static');
                $form->setType('personne_morale_categorie_juridique','static');
                $form->setType('personne_morale_nom','static');
                $form->setType('personne_morale_prenom','static');
                $form->setType('numero','static');
                $form->setType('voie','static');
                $form->setType('complement','static');
                $form->setType('lieu_dit','static');
                $form->setType('localite','static');
                $form->setType('code_postal','static');
                $form->setType('bp','static');
                $form->setType('cedex','static');
                $form->setType('pays','static');
                $form->setType('division_territoriale','static');
                $form->setType('telephone_fixe','static');
                $form->setType('telephone_mobile','static');
                $form->setType('fax','static');
                $form->setType('indicatif','static');
                $form->setType('courriel','static');
                $form->setType('notification','checkboxstatic');
                $form->setType('particulier_civilite','selecthiddenstatic');
                $form->setType('personne_morale_civilite','selecthiddenstatic');
                $form->setType('om_collectivite','selecthiddenstatic');
                // on masque le bouton "Sauvegarder"
                $form->setType('frequent','hidden');
            }
        }// fin modifier
        
        $form->setType('type_demandeur', 'hidden');
    }

    function setLib(&$form,$maj) {
        //libelle des champs
        parent::setLib($form, $maj);
        $form->setLib('frequent',"<span class=\"om-form-button copy-16\"
                      title=\""._("Sauvegarder ce petitionnaire")."\">"._("Sauvegarder (petitionnaire frequent)")."</span>");

    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        $form->setVal("type_demandeur", "petitionnaire");
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $form->setVal("type_demandeur", "petitionnaire");
    }

    /**
     * Surcharge du bouton pour empécher l'utilisateur de modifier un fréquent
     * Et ajout d'un bouton pour vider le formulaire
     */
    function boutonsousformulaire($datasubmit, $maj, $val=null) {
        if($maj == 0 OR $this->getVal('frequent') != 't') {
            if (!$this->correct) {
                //
                switch ($maj) {
                    case 0:
                        $bouton = _("Ajouter");
                        break;
                    case 1:
                        $bouton = _("Modifier");
                        break;
                    case 2:
                        $bouton = _("Supprimer");
                        break;
                }
                //
                echo "<input type=\"button\" value=\"".$bouton."\" ";
                echo "onclick=\"affichersform('".$this->get_absolute_class_name()."', '$datasubmit', this.form);\" ";
                echo "class=\"om-button\" />";
            }
        }
        if(!$this->correct) {
            echo '<span class="om-form-button erase-petitionnaire delete-16" '. 
                        'title="Supprimer le contenu">'._("Vider le formulaire").'</span>';
        }
    }

    /**
     * CONDITION - is_user_from_allowed_collectivite.
     *
     * Cette condition permet de vérifier si l'utilisateur connecté appartient
     * à une collectivité autorisée : c'est-à-dire de niveau 2 ou identique à
     * la collectivité de l'enregistrement sur lequel on se trouve.
     *
     * De plus les pétitionnaires liés à la collectivité de niveau 2 sont
     * visibles par les utilisateurs de collectivité de niveau 1.
     *
     * @return boolean
     */
    function is_user_from_allowed_collectivite() {

        // Si l'utilisateur est de niveau 2
        if ($_SESSION["niveau"] == "2") {
            // Alors l'utilisateur fait partie d'une collectivité autorisée
            return true;
        }

        // L'utilisateur est donc de niveau 1
        // On vérifie donc si la collectivité de l'utilisateur est la même
        // que la collectivité de l'élément sur lequel on se trouve ou si
        // l'élément est lié à la collectivité de niveau 2
        if ($_SESSION["collectivite"] === $this->getVal("om_collectivite")
            || $this->f->isCollectiviteMono($this->getVal("om_collectivite")) == false) {
            // Alors l'utilisateur fait partie d'une collectivité autorisée
            return true;
        }

        // L'utilisateur ne fait pas partie d'une collectivité autorisée
        return false;
    }

}


