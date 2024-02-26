<?php
/**
 * OM_UTILISATEUR - Surcharge du core
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once PATH_OPENMAIRIE."obj/om_utilisateur.class.php";

class om_utilisateur extends om_utilisateur_core {

    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // Initialisation de l'attribut correct a true
        $this->correct = true;
        // Recherche si le login a supprimer est identique au login de
        // l'utilisateur connecte
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$som_utilisateur
                WHERE
                    om_utilisateur = %2$d',
                DB_PREFIXE,
                intval($id)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { // PP
            $this->erreur_db($qres['message'], $qres['message'], "");
        } else {
            //
            $row = array_shift($qres['result']);
            if ($row['login'] == $_SESSION ['login']) {
                $this->msg .= _("Vous ne pouvez pas supprimer votre utilisateur.")."<br/>";
                $this->correct = false;
            }
        }
        // Si la suppression n'est pas possible, on ajoute un message clair
        // pour l'utilisateur
        if ($this->correct == false) {
            $this->msg .= _("SUPPRESSION IMPOSSIBLE")."<br />";
        }
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // Si l'utilisateur est un instructeur
        $get_instructeur_by_om_utilisateur = $this->get_instructeur_by_om_utilisateur($id);
        if ($get_instructeur_by_om_utilisateur != '') {
            // Instanciation de la classe instructeur
            $instructeur = $this->f->get_inst__om_dbform(array(
                "obj" => "instructeur",
                "idx" => $get_instructeur_by_om_utilisateur,
            ));
            // Valeurs de l'enregistrement
            $value_instructeur = array();
            foreach ($instructeur->champs as $key => $champ) {
                //
                $value_instructeur[$champ] = $instructeur->val[$key];
            }
            // Valeur à modifier
            $value_instructeur['om_utilisateur'] = null;
            // Modifie l'enregistrement
            $instructeur->modifier($value_instructeur);
        }

        // Si l'utilisateur est associé à des services
        $get_lien_service_om_utilisateur_by_om_utilisateur = $this->get_lien_service_om_utilisateur_by_om_utilisateur($id);
        if ($get_lien_service_om_utilisateur_by_om_utilisateur != '') {
            foreach ($get_lien_service_om_utilisateur_by_om_utilisateur as $row) {
                $lien_service_om_utilisateur = $this->f->get_inst__om_dbform(array(
                    "obj" => "lien_service_om_utilisateur",
                    "idx" => $row['lien_service_om_utilisateur'],
                ));
                // Valeurs de l'enregistrement
                $value_lien_service_om_utilisateur = array();
                foreach ($lien_service_om_utilisateur->champs as $key => $champ) {
                    //
                    $value_lien_service_om_utilisateur[$champ] = $lien_service_om_utilisateur->val[$key];
                }
                // Valeur à modifier
                $value_lien_service_om_utilisateur['om_utilisateur'] = null;
                // Modifie l'enregistrement
                $lien_service_om_utilisateur->modifier($value_lien_service_om_utilisateur);
            }
        }
    }

    /**
     * Récupère l'identifiant de l'instructeur par rapport à l'utilisateur
     * @param  integer $om_utilisateur Identifiant de l'utilisateur
     * @return integer                 Identifiant de l'instructeur
     */
    function get_instructeur_by_om_utilisateur($om_utilisateur) {
        // Initialisation résultat
        $instructeur = '';
        // Si la condition n'est pas vide
        if ($om_utilisateur != "" 
            && $om_utilisateur != null
            && is_numeric($om_utilisateur)) {
            // Requête SQL
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        instructeur
                    FROM
                        %1$sinstructeur
                    WHERE
                        om_utilisateur = %2$d',
                    DB_PREFIXE,
                    intval($om_utilisateur)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $instructeur = $qres["result"];
        }
        // Retourne résultat
        return $instructeur;
    }


    /**
     * Récupère l'identifiant de l'instructeur par rapport au login de 
     * l'utilisateur.
     *
     * @param string $om_utilisateur_login Login de l'utilisateur.
     *
     * @return integer
     */
    function get_instructeur_by_om_utilisateur_login($om_utilisateur_login) {
        // Initialisation résultat
        $instructeur = '';
        // Si la condition n'est pas vide
        if ($om_utilisateur_login != "" 
            && $om_utilisateur_login != null) {
            // Requête SQL
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        instructeur
                    FROM
                        %1$sinstructeur
                        LEFT JOIN %1$som_utilisateur
                            ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
                    WHERE
                        om_utilisateur.login = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($om_utilisateur_login)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $instructeur = $qres["result"];
        }
        // Retourne résultat
        return $instructeur;
    }


    /**
     * Récupère l'identifiant de lien_service_om_utilisateur par rapport à 
     * l'utilisateur
     * @param  integer $om_utilisateur Identifiant de l'utilisateur
     * @return object                  Résultat de la requête
     */
    function get_lien_service_om_utilisateur_by_om_utilisateur($om_utilisateur) {

        // Initialisation résultat
        $res = '';

        // Si la condition n'est pas vide
        if ($om_utilisateur != "" 
            && $om_utilisateur != null
            && is_numeric($om_utilisateur)) {

            // Requête SQL
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        lien_service_om_utilisateur
                    FROM
                        %1$slien_service_om_utilisateur
                    WHERE
                        om_utilisateur = %2$d',
                    DB_PREFIXE,
                    intval($om_utilisateur)
                ),
                array(
                    'origin' => __METHOD__
                )
            );
        }

        // Retourne résultat
        return $qres['result'];
    }


    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    public function init_class_actions() {
        // On récupère les actions génériques définies dans la méthode
        // d'initialisation de la classe parente
        parent::init_class_actions();
        // ACTION - 001 - modifier
        if (isset($this->class_actions) === true
            && array_key_exists(1, $this->class_actions) === true
            && is_array($this->class_actions[1]) === true) {
            //
            if (array_key_exists("condition", $this->class_actions)
                && is_array($this->class_actions[1]["condition"])) {
                //
                $this->class_actions[1]["condition"][] = "has_a_higher_profil";
            } elseif (array_key_exists("condition", $this->class_actions)
                && is_string($this->class_actions[1]["condition"])) {
                //
                $this->class_actions[1]["condition"] = array(
                    $this->class_actions[1]["condition"],
                    "has_a_higher_profil"
                );
            } elseif (array_key_exists("condition", $this->class_actions) === false) {
                //
                $this->class_actions[1]["condition"] = array(
                    "has_a_higher_profil"
                );
            }
        }
        // ACTION - 002 - supprimer
        if (isset($this->class_actions) === true
            && array_key_exists(2, $this->class_actions) === true
            && is_array($this->class_actions[2]) === true) {
            //
            if (array_key_exists("condition", $this->class_actions)
                && is_array($this->class_actions[2]["condition"])) {
                //
                $this->class_actions[2]["condition"][] = "has_a_higher_profil";
            } elseif (array_key_exists("condition", $this->class_actions)
                && is_string($this->class_actions[2]["condition"])) {
                //
                $this->class_actions[2]["condition"] = array(
                    $this->class_actions[2]["condition"],
                    "has_a_higher_profil"
                );
            } elseif (array_key_exists("condition", $this->class_actions) === false) {
                //
                $this->class_actions[2]["condition"] = array(
                    "has_a_higher_profil"
                );
            }
        }
    }

    /**
     * CONDITION - has_a_higher_profil.
     * 
     * Sans paramètre, cette méthode vérifie que l'utilisateur courant
     * possède un indice hiérarchique supérieur au profil visité
     * 
     * @param Integer $om_profil_selected : permet de faire la même comparaison hiérarchique,
     *                sur la sélection d'un profil en création par sa valeur 'om_profil' :
     *                $this->valF['om_profil']
     *
     * @return boolean
     */
    public function has_a_higher_profil($om_profil_selected = NULL) {
        $hierarchie = 0;
        if (isset($this->f->user_infos) === true
            && is_array($this->f->user_infos) === true
            && array_key_exists("hierarchie", $this->f->user_infos) === true) {
            $hierarchie = intval($this->f->user_infos["hierarchie"]);
        }
        if (isset($om_profil_selected) === true){
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT hierarchie FROM %1$som_profil WHERE om_profil = %2$d',
                    DB_PREFIXE,
                    intVal($om_profil_selected)
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            if (!empty($qres['result'])) {
                $om_profil_selected_hierarchy = intVal($qres['result'][0]['hierarchie']);
                if ($hierarchie >= $om_profil_selected_hierarchy) {
                    return true;
                }
                return false;
            }
        }
        $inst__om_profil = $this->f->get_inst__om_dbform(array(
            "obj" => "om_profil",
            "idx" => $this->getVal("om_profil")
        ));
        if ($hierarchie >= intval($inst__om_profil->getVal("hierarchie"))) {
            return true;
        }
        return false;
    }

    /**
     * QUERY - sql_om_profil.
     *
     * Liste des profils dont la hiérarchie est inférieure ou égale à celle de
     * l'utilisateur connecté.
     *
     * @return string
     */
    public function get_var_sql_forminc__sql_om_profil() {
        $hierarchie = 0;
        if (isset($this->f->user_infos) === true
            && is_array($this->f->user_infos) === true
            && array_key_exists("hierarchie", $this->f->user_infos) === true) {
            $hierarchie = intval($this->f->user_infos["hierarchie"]);
        }
        return sprintf(
            'SELECT om_profil.om_profil, om_profil.libelle FROM %1$som_profil WHERE om_profil.hierarchie <= %2$s ORDER BY om_profil.libelle ASC',
            DB_PREFIXE,
            $hierarchie
        );
    }

    /**
     * Methode verifier
     * 
     */
    public function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        // Appel de methode de la classe parent
        parent::verifier($val, $this->f->db, null);

        // Gestion des restrictions hiérarchiques des utilisateurs
        if (! $this->has_a_higher_profil($this->valF['om_profil'])) {
                 $this->correct = false;
            $this->addToMessage(__('L\'utilisateur courant ne dispose pas des droits suffisants.'));
        }
    }

}
