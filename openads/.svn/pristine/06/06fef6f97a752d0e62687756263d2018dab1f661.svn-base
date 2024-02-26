<?php
/**
 * DBFORM - 'avocat' - Surcharge obj.
 *
 * @package openads
 * @version SVN : $Id: avocat.class.php 6565 2017-04-21 16:14:15Z softime $
 */
require_once("../obj/demandeur.class.php");


/**
 * Les avodats héritent des demandeurs.
 */
class avocat extends demandeur {

    /**
     *
     */
    protected $_absolute_class_name = "avocat";

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
     * Cache les champs de notification, fréquent et type_demandeur.
     *
     * @param formulaire $form Instance de la classe om_formulaire.
     * @param integer    $maj  Identifiant de l'action.
     */
    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        $form->setType('type_demandeur', 'hidden');
        $form->setType('notification', 'hidden');
        
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

        // Champs disabled pour la modif d'avocat frequents 
        if ($maj==110 or $maj==1) { //modifier
            if($this->getVal('frequent') == 't') {
                $form->setType('qualite','selecthiddenstatic');
                $form->setType('particulier_nom','static');
                $form->setType('particulier_prenom','static');
                $form->setType('particulier_date_naissance','datestatic');
                $form->setType('particulier_commune_naissance','static');
                $form->setType('particulier_departement_naissance','static');
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

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        // parent::setVal($form, $maj, $validation);
        //
        if ($maj == 0) {
             $form->setVal("type_demandeur", "avocat");
        }
    }

    function setLib(&$form,$maj) {
        //libelle des champs
        parent::setLib($form, $maj);
        $form->setLib('frequent',"<span class=\"om-form-button copy-16\"
                      title=\""._("Sauvegarder cet avocat")."\">"._("Sauvegarder (avocat fréquent)")."</span>");

    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $form->setVal("type_demandeur", "avocat");
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
            echo '<span class="om-form-button erase-avocat delete-16" '. 
                        'title="Supprimer le contenu">'._("Vider le formulaire").'</span>';
        }
    }

}
