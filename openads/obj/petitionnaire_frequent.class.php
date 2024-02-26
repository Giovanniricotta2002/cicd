<?php
/**
 * DBFORM - 'petitionnaire_frequent' - Surcharge obj.
 *
 * Ce script permet de définir la classe 'petitionnaire_frequent'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/petitionnaire.class.php";

class petitionnaire_frequent extends petitionnaire {

    /**
     *
     */
    protected $_absolute_class_name = "petitionnaire_frequent";

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();

        // ACTION - 001 - modifier
        // Si on est en non frequent
        $this->class_actions[1]["condition"] = array("is_not_frequent");
    }

    /*
     * Surcharge de la méthode setType de la classe petitionnaire
     */
    function setType(&$form,$maj) {
        parent::setType($form,$maj);

        $form->setType('frequent','hidden');
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        // Met le champ frequent à t par défaut
        $form->setVal("frequent", true);
    }

    /**
     * Mise en page.
     *
     * @param formulaire $form Instance de la classe om_formulaire.
     * @param integer    $maj  Identifiant de l'action.
     */
    function setLayout(&$form, $maj){
        // Affichage multi
        $col_coll = 'nolabel col_12';
        if ($_SESSION["niveau"] == 2) {
            $col_coll = 'nolabel col_6';
        }

        // Gestion recherche pétitionnaire fréquent
        $search_fields = '';
        if ($maj == 0 || $maj == 1) {
            if ($form->val['type_demandeur'] === 'petitionnaire' ||
                $form->val['type_demandeur'] === 'avocat' ||
                $form->val['type_demandeur'] === 'bailleur') {
                $search_fields = ' search_fields';
            }
        }

        // Qualité
        $form->setBloc(
            'qualite',
            'D',
            '',
            $col_coll
        );
        
            $form->setFieldset(
                'qualite',
                'D',
                _("Qualité")
            );
            $form->setFieldset(
                'qualite',
                'F'
            );
            
        $form->setBloc('qualite', 'F');

        // Collectivité
        $form->setBloc(
            'om_collectivite',
            'D',
            '',
            $search_fields.' nolabel'
        );
        
            $form->setFieldset(
                'om_collectivite',
                'DF',
                _("Collectivité")
        );

        $form->setBloc('om_collectivite', 'F');

        // Etat civil
        $form->setBloc(
            'particulier_civilite',
            'D',
            "",
            "particulier_fields"
        );
        
            $form->setFieldset(
                'particulier_civilite',
                'D',
                _("Etat civil"),
                "group"
            );
                $form->setBloc(
                    'particulier_nom',
                    'D',
                    "",
                    "group".$search_fields
                );
                $form->setBloc('particulier_prenom', 'F');
                $form->setBloc(
                    'particulier_date_naissance',
                    'D',
                    "",
                    "group"
                );
                $form->setBloc('particulier_commune_naissance', 'F');
            $form->setFieldset(
                'particulier_pays_naissance',
                'F'
            );
            
        $form->setBloc('particulier_pays_naissance', 'F');
        
        $form->setBloc(
            'personne_morale_denomination',
            'D',
            "",
            "personne_morale_fields"
        );

            $form->setFieldset(
                'personne_morale_denomination',
                'D',
                _("Personne morale"),
                $search_fields
            );

                $form->setBloc(
                    'personne_morale_denomination',
                    'D',
                    "",
                    "group"
                );
                $form->setBloc('personne_morale_raison_sociale', 'F');

                $form->setBloc(
                    'personne_morale_siret',
                    'D',
                    "",
                    "group"
                );
                $form->setBloc(
                    'personne_morale_categorie_juridique',
                    'F'
                );
                
                $form->setBloc('personne_morale_civilite', 'D', "");
                $form->setBloc('personne_morale_civilite', 'F');
                
                $form->setBloc('personne_morale_nom', 'D', "", "group");
                $form->setBloc('personne_morale_prenom', 'F');

            $form->setFieldset('personne_morale_prenom', 'F');
            
        $form->setBloc('personne_morale_prenom', 'F');
    
        // Adresse
        $form->setFieldset('numero', 'D', _("Adresse"), "");
        
            $form->setBloc('numero', 'D', "", "group");
            $form->setBloc('voie', 'F');
            
            $form->setBloc('complement', 'D', "");
            $form->setBloc('complement', 'F');
            
            $form->setBloc('lieu_dit', 'D', "", "group");
            $form->setBloc('localite', 'F');
            
            $form->setBloc('code_postal', 'D', "", "group");
            $form->setBloc('cedex', 'F');
            
            $form->setBloc('pays', 'D', "", "", "group");
            $form->setBloc('division_territoriale', 'F');
        $form->setFieldset('division_territoriale', 'F');

        // Coordonnées
        $form->setFieldset('telephone_fixe', 'D', _("Coordonnees"), "");
            $form->setBloc('telephone_fixe', 'D', "", "group");
            $form->setBloc('indicatif', 'F');

            $form->setBloc('courriel', 'D', "", "group");
            $form->setBloc('notification', 'F');

        $form->setFieldset('notification', 'F');
    }


}


