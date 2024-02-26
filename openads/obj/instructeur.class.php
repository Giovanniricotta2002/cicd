<?php
/**
 * DBFORM - 'instructeur' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'instructeur'.
 *
 * @package openads
 * @version SVN : $Id: instructeur.class.php 5839 2016-01-29 08:50:12Z fmichon $
 */

require_once "../gen/obj/instructeur.class.php";

class instructeur extends instructeur_gen {

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_utilisateur_by_division() {
        // Récupère la liste des utilisateurs appartement à la même collectivité que la
        // direction de la division sur laquelle la condition est faite
        return "SELECT
    om_utilisateur.om_utilisateur,
    om_utilisateur.nom as lib
FROM " . DB_PREFIXE . "division
    INNER JOIN " . DB_PREFIXE . "direction
        ON division.direction = direction.direction
    INNER JOIN " . DB_PREFIXE . "om_utilisateur
        ON om_utilisateur.om_collectivite = direction.om_collectivite
WHERE division.division = '<id_division>'
    AND ((division.om_validite_debut IS NULL AND (division.om_validite_fin IS NULL
        OR division.om_validite_fin > CURRENT_DATE)) OR (division.om_validite_debut
            <= CURRENT_DATE AND (division.om_validite_fin IS NULL
                OR division.om_validite_fin > CURRENT_DATE)))
ORDER BY om_utilisateur.nom";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division_by_utilisateur() {
        // Récuperation des division par l'utilisateur
        return "SELECT
    division.division,
    division.libelle as lib
FROM " . DB_PREFIXE . "division
INNER JOIN " . DB_PREFIXE . "direction
    ON division.direction = direction.direction
INNER JOIN " . DB_PREFIXE . "om_utilisateur
    ON om_utilisateur.om_collectivite = direction.om_collectivite
WHERE om_utilisateur.om_utilisateur = '<id_utilisateur>'
ORDER BY division.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_division_by_collectivite() {
        // Si on est en mono on doit voir que les divisions de sa collectivite
        return "SELECT
    division.division, division.libelle
FROM " . DB_PREFIXE . "division
INNER JOIN " . DB_PREFIXE . "direction
    ON division.direction = direction.direction
WHERE ((division.om_validite_debut IS NULL AND (division.om_validite_fin
            IS NULL OR division.om_validite_fin > CURRENT_DATE))
        OR (division.om_validite_debut <= CURRENT_DATE AND (division.om_validite_fin
            IS NULL OR division.om_validite_fin > CURRENT_DATE)))
    AND om_collectivite = <id_collectivite>
ORDER BY division.libelle ASC";
    }

    function setOnchange(&$form, $maj){
        parent::setOnchange($form, $maj);

        // Si on n'est pas dans le contexte d'un sous-formulaire
        if ($this->getParameter('retourformulaire') === null) {
            //
            $form->setOnchange("division", "filterSelect(this.value, 'om_utilisateur', 'division', 'instructeur');");
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        // parent::setSelect($form, $maj);
        // On recupere l'objet en cours et son identifiant
        $idx = $this->getParameter('idxformulaire');
        $retourformulaire = $this->f->get_submitted_get_value('retourformulaire');
        $obj = $this->f->get_submitted_get_value('obj');
        // Si on est dans le contexte d' "instructeur" en ajout ou en filter select
        if (($obj === "instructeur" && $retourformulaire === null)
            || $obj === null) {
            // Ne fait pas appel au parent car une requête SQL doit être modifiée
            // dans le cas d'un ajout afin de permettre le bon tri du champ
            // om_utilisateur

            // L'initialisation des select récupérée depuis la classe générée
            // instructeur_qualite
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "instructeur_qualite",
                $this->get_var_sql_forminc__sql("instructeur_qualite"),
                $this->get_var_sql_forminc__sql("instructeur_qualite_by_id"),
                false
            );
            // om_utilisateur
            // En mode ajout, on modifie la requête permettant de récupérer la liste
            // des utilisateurs afin qu'elle ne retourne raucun résultat
            $sql_om_utilisateur = $this->get_var_sql_forminc__sql("om_utilisateur");
            if ($maj == 0) {
                //
                $sql_om_utilisateur="SELECT om_utilisateur.om_utilisateur, om_utilisateur.nom FROM ".DB_PREFIXE."om_utilisateur WHERE om_utilisateur = 0";
            }
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "om_utilisateur",
                $sql_om_utilisateur,
                $this->get_var_sql_forminc__sql("om_utilisateur_by_id"),
                false
            );

            // Filtre des division en fonction des niveaux
            if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                // Bloque l'accès aux division autre que celles de sa collectivité
                $sql_division_by_collectivite = str_replace(
                    '<id_collectivite>',
                    $_SESSION['collectivite'],
                    $this->get_var_sql_forminc__sql("division_by_collectivite")
                );
                $this->init_select(
                    $form,
                    $this->f->db,
                    $maj,
                    null,
                    "division",
                    $sql_division_by_collectivite,
                    $this->get_var_sql_forminc__sql("division_by_id"),
                    true
                );
            } else {
                $this->init_select(
                    $form,
                    $this->f->db,
                    $maj,
                    null,
                    "division",
                    $this->get_var_sql_forminc__sql("division"),
                    $this->get_var_sql_forminc__sql("division_by_id"),
                    true
                );
            }

            /**
             * Gestion du filtre sur les utilisateurs en fonction de la division
             * sélectionnée.
             */
            if ($maj == 0 || $maj == 1) {
                // Récupère l'identifiant de la division
                $id_division = "";
                if ($this->f->get_submitted_post_value('division') !== null) {
                    $id_division = $this->f->get_submitted_post_value('division');
                } elseif ($this->getParameter('division') != "") {
                    $id_division = $this->getParameter('division');
                } elseif (isset($form->val['division'])) {
                    $id_division = $form->val['division'];
                }

                //
                if ($id_division !== "") {
                    // Tri les utilisateurs par la collectivité de la division
                    $sql_utilisateur_by_division = str_replace(
                        '<id_division>',
                        $id_division,
                        $this->get_var_sql_forminc__sql("utilisateur_by_division")
                    );
                    //
                    $this->init_select(
                        $form,
                        $this->f->db,
                        $this->getParameter("maj"),
                        null,
                        "om_utilisateur",
                        $sql_utilisateur_by_division,
                        $this->get_var_sql_forminc__sql("om_utilisateur_by_id"),
                        true
                    );
                }
            }
            return;
        }
        // Si on est dans un autre context que "instructeur" on appelle le parent
        parent::setSelect($form, $maj);
        // Si on est dans les utilisateurs
        if ($idx != null && $retourformulaire !== null && $retourformulaire === "om_utilisateur") {
            $sql_division_by_utilisateur = str_replace(
                '<id_utilisateur>',
                $idx,
                $this->get_var_sql_forminc__sql("division_by_utilisateur")
            );
            $this->init_select(
                $form,
                $this->f->db,
                $this->getParameter("maj"),
                null,
                "division",
                $sql_division_by_utilisateur,
                $this->get_var_sql_forminc__sql("division_by_id"),
                true
            );
            return;
        }
        // Si on est dans la division
        if ($idx != null && $retourformulaire !== null && $retourformulaire === "division") {
            $sql_utilisateur_by_division = str_replace(
                '<id_division>',
                $idx,
                $this->get_var_sql_forminc__sql("utilisateur_by_division")
            );
            $this->init_select(
                $form,
                $this->f->db,
                $this->getParameter("maj"),
                null,
                "om_utilisateur",
                $sql_utilisateur_by_division,
                $this->get_var_sql_forminc__sql("om_utilisateur_by_id"),
                true
            );
            return;
        }
    }
}
