<?php
/**
 * DBFORM - 'bailleur' - Surcharge obj.
 *
 * @package openads
 * @version SVN : $Id: bailleur.class.php 8989 2019-10-31 15:09:51Z softime $
 */
require_once("../obj/demandeur.class.php");


/**
 * Les bailleurs héritent des demandeurs.
 */
class bailleur extends demandeur {

    /**
     *
     */
    protected $_absolute_class_name = "bailleur";

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
        // Récupère les bailleurs fréquents
        $this->class_actions[110] = array(
            "identifier" => "recuperer_frequent",
            "view" => "formulaire",
            "method" => "modifier",
            "button" => "valider",
            "permission_suffix" => "modifier",
        );
    }


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

        //
        if($maj == 3) {
            // En consultation le bouton "Sauvegarder" n'a pas lieu d'être
            $form->setType('frequent','hidden');
        }

        // Champs disabled pour la modif du bailleur frequent
        if ($maj==110 || $maj==1) { //modifier
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
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        // parent::setVal($form, $maj, $validation);
        if ($maj == 0) {
            $form->setVal("type_demandeur", "bailleur");
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
        $form->setVal("type_demandeur", "bailleur");
    }

    /**
     * Permet de définir le libellé des champs.
     *
     * @param object  $form Instance de la classe om_formulaire.
     * @param integer $maj  Identifiant de l'action.
     */
    public function setLib(&$form, $maj) {
        parent::setLib($form, $maj);

        // Libellé pour la sauvegarde du bailleur en fréquent
        $form->setLib('frequent',"<span class=\"om-form-button copy-16\"
                      title=\""._("Sauvegarder ce bailleur")."\">"._("Sauvegarder (bailleur fréquent)")."</span>");

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
            echo '<span class="om-form-button erase-bailleur delete-16" '. 
                        'title="Supprimer le contenu">'._("Vider le formulaire").'</span>';
        }
    }


}
