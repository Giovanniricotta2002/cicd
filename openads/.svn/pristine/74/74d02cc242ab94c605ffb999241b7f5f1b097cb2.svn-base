<?php
/**
 * DBFORM - 'affectation_automatique' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'affectation_automatique'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/affectation_automatique.class.php";

class affectation_automatique extends affectation_automatique_gen {

    /**
     * Renvoie un tableau de couple (id, libelle) des affectations automatiques
     * correspondant aux paramètres spécifiés.
     *
     * @param integer $om_collectivite  l'identifiant de la collectivité (optionel)
     * @param integer $commune_id       l'identifiant de la commune (optionel)
     * @param integer $dadt             l'identifiant du type détaillé de dossier d'autorisation (optionel)
     * @param integer $demande_type     l'identifiant du type de demande (optionel)
     *
     * @return array                    tableau de couple (id, libelle) des affectations automatiques correspondnates
     */
    public function get_matching_affectations($om_collectivite = 0, $commune_id = 0, $datd = 0, $demande_type = 0) {

        $result = [];

        // si aucun des paramètre n'est fourni, on renvoie un résultat vide
        if ($om_collectivite === 0 && $commune_id === 0 && $datd === 0 && $demande === 0) {
            return array();
        }

        // création d'une requête SQL pour rechercher les affectations automatiques possibles.
        $sql = sprintf("
            SELECT
                AA.affectation_automatique AS id,
                AA.affectation_manuelle AS libelle
            FROM
                %saffectation_automatique as AA
            WHERE
                AA.affectation_manuelle IS NOT NULL
                AND AA.affectation_manuelle != ''
                AND AA.instructeur IS NOT NULL
            ",
            DB_PREFIXE
        );

        // si l'identifiant de la demande_type est spécifié
        $typeDI = null;
        if (empty($demande_type) === false && $demande_type !== 0) {
            $demande_type_inst = $this->f->get_inst__om_dbform(array(
                "obj" => "demande_type",
                "idx" => $demande_type,
            ));
            $typeDI = $demande_type_inst->getVal('dossier_instruction_type');
        }

        // ajoute les conditions SQL correspondantes aux paramètres de filtrage
        foreach(array(
                'om_collectivite ' => $om_collectivite,
                'dossier_autorisation_type_detaille' => $datd,
                'dossier_instruction_type' => $typeDI
                ) as $column => $value) {
            if (!empty($value) && $value) {
                $sql .= sprintf(" AND (AA.$column IS NULL OR AA.$column = '%d') ", $value);
            }
        }
        if ($this->f->is_option_dossier_commune_enabled()) {
            if (!empty($commune_id)) {
                $commune = $this->f->findObjectById('commune', $commune_id);
                if (!empty($commune)) {
                    $code_departement = strtoupper($commune->getVal('dep'));
                    $code_commune = preg_replace('/^'.$code_departement.'/', '', strtoupper($commune->getVal('com')));
                    $sql .= sprintf(
                        " AND (AA.communes IS NULL OR AA.communes ~ '%s') ",
                        "(^|,)$code_departement($code_commune)?(,|$)");
                }
                else {
                    $this->addToLog(__METHOD__."(): commune '$commune_id' non trouvée", DEBUG_MODE);
                }
            }
            else {
                    $sql .= " AND AA.communes IS NULL ";
            }
        }

        // exécute la requête
        $result = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );

        return $result['result'];
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        $champs = array(
            "affectation_automatique",
            "om_collectivite",
            "communes",
            "dossier_autorisation_type_detaille",
            "dossier_instruction_type",
            "instructeur",
            "instructeur_2",
            "arrondissement",
            "quartier",
            "section",
            "affectation_manuelle"
        );
        return $champs;
    }

    /**
     *
     * @return void
     */
    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        if ($this->f->is_option_dossier_commune_enabled() === false) {
            $form->setType('communes', 'hidden');
        }
    }

    /**
     * Surcharge de la requête permettant de récupérer la lsite des datd :
     * ne récupère pas les types dont le cerfa associé a la date de fin de validité dépassée.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille() {
        return sprintf('
            SELECT
                dossier_autorisation_type_detaille.dossier_autorisation_type_detaille,
                dossier_autorisation_type_detaille.libelle
            FROM
                %1$sdossier_autorisation_type_detaille
                LEFT JOIN %1$sdossier_autorisation_type
                    ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                LEFT JOIN %1$sgroupe
                    ON dossier_autorisation_type.groupe = groupe.groupe
                LEFT JOIN %1$scerfa
                    ON dossier_autorisation_type_detaille.cerfa = cerfa.cerfa
            WHERE
                ((now()<=om_validite_fin AND now()>=om_validite_debut) OR
                dossier_autorisation_type_detaille.cerfa IS NULL OR
                (om_validite_fin IS NULL and om_validite_debut IS NULL) OR
                (now()<=om_validite_fin and om_validite_debut IS NULL) OR
                (om_validite_fin IS NULL AND now()>=om_validite_debut))
                ORDER BY dossier_autorisation_type_detaille.libelle ASC
            ',
            DB_PREFIXE
        );
    }

    /**
     * Surcharge de la requête permettant de récupérer la lsite des types de DI :
     * ne récupère pas les types dont le cerfa associé a la date de fin de validité dépassée.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type() {
        return sprintf('
            SELECT
                dossier_instruction_type.dossier_instruction_type,
                CONCAT(dossier_autorisation_type_detaille.libelle, \' - \', dossier_instruction_type.libelle, \' (\', dossier_instruction_type.code, \')\')
            FROM
                %1$sdossier_instruction_type
                LEFT JOIN %1$sdossier_autorisation_type_detaille
                    ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                LEFT JOIN %1$sdossier_autorisation_type
                    ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                LEFT JOIN %1$sgroupe
                    ON dossier_autorisation_type.groupe = groupe.groupe
                LEFT JOIN %1$scerfa
                    ON dossier_autorisation_type_detaille.cerfa = cerfa.cerfa
            WHERE
                ((now()<=om_validite_fin AND now()>=om_validite_debut) OR
                dossier_autorisation_type_detaille.cerfa IS NULL OR
                (om_validite_fin IS NULL and om_validite_debut IS NULL) OR
                (now()<=om_validite_fin and om_validite_debut IS NULL) OR
                (om_validite_fin IS NULL AND now()>=om_validite_debut))
                ORDER BY dossier_autorisation_type_detaille.libelle ASC, dossier_instruction_type.libelle ASC
            ',
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return "
            SELECT
                dossier_instruction_type.dossier_instruction_type,
                CONCAT(dossier_autorisation_type_detaille.libelle, ' - ', dossier_instruction_type.libelle, ' (', dossier_instruction_type.code, ')')
            FROM
                ".DB_PREFIXE."dossier_instruction_type
                LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
                ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille
            WHERE dossier_instruction_type = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement ORDER BY NULLIF(arrondissement.libelle,'')::int ASC NULLS LAST";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur() {
        return sprintf(
            'SELECT 
                instructeur.instructeur,
                CONCAT(instructeur.nom, \' (\', division.code, \')\')
            FROM
                %1$sinstructeur
                    INNER JOIN %1$sdivision
                        ON division.division=instructeur.division
            WHERE
                (
                    (
                        instructeur.om_validite_debut IS NULL 
                        AND (
                            instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE
                        )
                    )
                    OR
                    (
                        instructeur.om_validite_debut <= CURRENT_DATE
                        AND (
                            instructeur.om_validite_fin IS NULL
                            OR instructeur.om_validite_fin > CURRENT_DATE
                        )
                    )
                )
            ORDER BY nom',
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_by_id() {
        return sprintf(
            'SELECT
                instructeur.instructeur,
                CONCAT(instructeur.nom, \' (\', division.code, \')\')
            FROM
                %1$sinstructeur
                    INNER JOIN %1$sdivision
                        ON division.division=instructeur.division
                    INNER JOIN %1$sinstructeur_qualite
                        ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
            WHERE
                instructeur = <idx>
            ',
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2() {
        return $this->get_var_sql_forminc__sql("instructeur");
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_2_by_id() {
        return $this->get_var_sql_forminc__sql("instructeur_by_id");
    }

    /**
     * Surcharge pour vérifier le champ 'communes'
     *
     * @param array $val Tableau des valeurs brutes.
     * @param null &$dnu1 @deprecated  Ne pas utiliser.
     * @param null $dnu2 @deprecated  Ne pas utiliser.
     *
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val, $dnu1, $dnu2);
        if ($this->f->is_option_dossier_commune_enabled()) {
            if (isset($this->valF['communes']) && !empty($this->valF['communes'])
                    && ! preg_match('/^[0-9A-z]+(,[0-9A-z]+)*$/', $this->valF['communes'])) {
                $this->correct = false;
                $this->addToMessage(
                    __("Valeur de <b>communes</b> invalide (autorisés: chiffres et virgules, ".
                       "1er et dernier caractères différent d'une virgule)."));
            }
        }
    }

    /**
     * Surcharge pour augmenter la taille du champ 'communes'
     */
    function setTaille(&$form, $maj) {
        parent::setTaille($form, $maj);
        $form->setTaille("communes", 100);
    }
}
