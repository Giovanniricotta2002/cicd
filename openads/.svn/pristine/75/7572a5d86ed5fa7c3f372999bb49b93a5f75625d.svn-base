<?php
/**
 * DBFORM - 'dossier_geolocalisation' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'dossier_geolocalisation'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/dossier_geolocalisation.class.php";

class dossier_geolocalisation extends dossier_geolocalisation_gen {

    /**
     * Constructeur.
     */
    function __construct($id, $dnu1 = null, $dnu2 = null, $dossier = null) {
        //
        $this->init_om_application();
        // Si l'action et l'identifiant du dossier son passé
        if ($dossier != null && $dossier != "") {
            // Récupère l'identifiant de dossier_geolocalisation
            $id = $this->get_id_by_dossier($dossier);

            // Si aucun identifiant n'est trouvé
            if ($id == null || $id == "") {
                // Objet utilisé pour l'ajout
                $add_object = $this->f->get_inst__om_dbform(array(
                    "obj" => "dossier_geolocalisation",
                    "idx" => "]",
                ));

                // Valeurs
                $values = array();
                // Initialise chaque champ
                foreach($add_object->champs as $val) {
                    $values[$val] = null;
                }
                // Valeurs à ajouter
                $values['dossier'] = $dossier;

                // Ajout de l'enregistrement
                $add = $add_object->ajouter($values);

                // Si l'ajout a échoué
                if ($add == false) {
                    //
                    return false;
                }

                // Récupération de l'identifiant
                $id = $add_object->valF[$add_object->clePrimaire];
            }
        }

        //
        $this->constructeur($id);
    }

    /**
     * Liste des actions de géolocalisation.
     *
     * @var array
     */
    private $list_action = array(
            "verif_parcelle",
            "calcul_emprise",
            "dessin_emprise",
            "calcul_centroide",
            "recup_contrainte"
        );

    /**
     * Recupère l'identifiant de dossier_geolocalisation par rapport au dossier.
     *
     * @param string $dossier Identifiant du dossier.
     *
     * @return integer
     */
    private function get_id_by_dossier($dossier) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier_geolocalisation
                FROM
                    %1$sdossier_geolocalisation
                WHERE
                    dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }


    /**
     * Modifie les informations d'une action de géolocalisation.
     *
     * @param string  $action  Action de géolocalisation.
     * @param string  $date    Date de la dernière exécution de l'action.
     * @param boolean $etat    État de la dernière exécution de l'action.
     * @param string  $message Message de la dernière exécution de l'action.
     *
     * @return boolean
     */
    public function set_geolocalisation_state($action, $date, $etat, $message) {
        // Si c'est une action de géolocalisation
        if (in_array($action, $this->list_action) == false) {
            //
            return false;
        }

        // Valeurs
        $values = array();
        // Initialise chaque champ
        foreach($this->champs as $key => $val) {
            //
            $values[$val] = $this->val[$key];

            // Si la valeur est vide
            if ($values[$val] == "") {
                // La valeur est null pour éviter les erreurs avec les champs
                // timestamp
                $values[$val] = null;
            }
        }
        // Valeurs modifiées
        $values['date_'.$action] = $date;
        $values['etat_'.$action] = $etat;
        $values['message_'.$action] = $message;

        // Modifie l'enregistrement
        $edit = $this->modifier($values);

        // Si la modification a échouée
        if ($edit == false) {
            //
            return false;
        }

        //
        return true;
    }


    /**
     * Récupère les informations d'une action de géolocalisation.
     *
     * @param string $action Action de géolocalisation.
     *
     * @return mixed [description]
     */
    public function get_geolocalisation_state($action) {
        // Si c'est une action de géolocalisation
        if (in_array($action, $this->list_action) == false) {
            //
            return false;
        }

        // Tableau des résultats
        $result = array();
        $result["date"] = $this->getVal('date_'.$action);
        $result["etat"] = $this->getVal('etat_'.$action);
        $result["message"] = $this->getVal('message_'.$action);

        // Retourne le tableau des résultats
        return $result;
    }


    /**
     * Modifie le champ terrain_references_cadastrales_archive.
     *
     * @param string $value Valeur du champ.
     *
     * @return boolean
     */
    public function set_terrain_references_cadastrales_archive($value) {
        // Valeurs
        $values = array();
        // Initialise chaque champ
        foreach($this->champs as $key => $val) {
            //
            $values[$val] = $this->val[$key];

            // Si la valeur est vide
            if ($values[$val] == "") {
                // La valeur est null pour éviter les erreurs avec les champs
                // timestamp
                $values[$val] = null;
            }
        }
        // Valeurs modifiées
        $values['terrain_references_cadastrales_archive'] = $value;

        // Modifie l'enregistrement
        $edit = $this->modifier($values);

        // Si la modification a échouée
        if ($edit == false) {
            //
            return false;
        }

        //
        return true;
    }


    /**
     * Recupère la valeur du champ terrain_references_cadastrales_archive.
     *
     * @return string
     */
    public function get_terrain_references_cadastrales_archive() {
        //
        return $this->getVal('terrain_references_cadastrales_archive');
    }


}


