<?php
/**
 * DBFORM - 'contrainte' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'contrainte'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/contrainte.class.php";

class contrainte extends contrainte_gen {

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 100 - synchronisation_contrainte
        // Permet de synchroniser les contraintes de l'application
        $this->class_actions[100] = array(
            "identifier" => "synchronisation_contrainte",
            "view" => "view_synchronisation_contrainte",
            "permission_suffix" => "contrainte_synchronisation",
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "contrainte",
            // Contrainte
            "libelle",
            "nature",
            "reference",
            "numero",
            "no_ordre",
            // Catégorie
            "groupe",
            "sousgroupe",
            // Détail
            "texte",
            "service_consulte",
            "om_collectivite",
            "om_validite_debut",
            "om_validite_fin",
        );
    }

    /**
     * Permet de définir le type des champs.
     * @param object  &$form Objet du formulaire
     * @param integer $maj   Mode du formulaire
     */
    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        // Champs cachés
        $form->setType('contrainte', 'hidden');
        $form->setType('numero', 'hidden');

        // En mode ajouter et modifier
        if ($maj < 2) {
            $form->setType('nature', 'select');
            $form->setType('reference', 'hidden');
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // nature
        $nature = array(
            array("PLU", "POS", "CC", "RNU"),
            array(_("PLU"), _("POS"), _("CC"), _("RNU")),
        );
        $form->setSelect("nature", $nature);
    }

    /**
     * Méthode de mise en page.
     * @param object  &$form Objet du formulaire
     * @param integer $maj   Mode du formulaire
     */
    function setLayout(&$form, $maj) {

        //
        $form->setFieldset("libelle", "D", _("Contrainte"));
        $form->setFieldset("no_ordre", "F");
        //
        $form->setFieldset("groupe", "D", _("Categorie"));
        $form->setFieldset("sousgroupe", "F");
        //
        $form->setFieldset("texte", "D", _("Detail"));
        $form->setFieldset("om_validite_fin", "F");
        
    }

    /**
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);
        // S'il y a une erreur
        if ($this->correct == false) {
            // Ajoute l'erreur au log
            $this->addToLog("verifier() : ".$this->msg, DEBUG_MODE);
        }
    }

    /**
     * Permet de synchroniser les contraintes du SIG depuis une interface.
     */
    function view_synchronisation_contrainte() {
        // Description de la page
        $description = _("Cette page permet de synchroniser les contraintes de l'application avec celles du SIG.");
        // Affichage de la description
        $this->f->displayDescription($description);
        require_once "../obj/synchronisationContrainte.class.php";

        $sync = new SynchronisationContrainte($this->f);
        // Affichage du formulaire (bouton de validation)
        $sync->view_form_sync();
    }

}


