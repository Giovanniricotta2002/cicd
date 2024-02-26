<?php
//$Id$ 
//gen openMairie le 01/06/2022 12:32

require_once "../gen/obj/dossier_operateur.class.php";

class dossier_operateur extends dossier_operateur_gen {

    // Permet de stocker le tableau du om_parametre param_operateur.
    private $param_operateur;

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 001 - modifier
        // Modification de la condition d'affichage de l'action "modifier"
        $this->class_actions[1]["condition"] = array("is_editable");

        // ACTION - 002 - supprimer
        // Modification de la condition d'affichage de l'action "supprimer"
        // Ne doit pas être affichée.
        $this->class_actions[2] = null;

        // ACTION - 005 - reinitialiser
        // Action permettant de remettre à 0 la procédure de désignation d'un opérateur.
        $this->class_actions[5] = array(
            "identifier" => "reinitialiser",
            "portlet" => array(
                "type" => "action-direct-with-confirmation",
                "libelle" => __("Réinitialiser"),
                "class" => "reinitialiser-16"
            ),
            "method" => "reinitialiser",
            "permission_suffix" => "reinitialiser",
            "view" => "formulaire",
            "condition" => array('is_reinitialisable', 'is_param_operateur_etat_setted'),
        );

        // ACTION - 006 - valider
        // Action permettant de valider l'opérateur désigné.
        $this->class_actions[6] = array(
            "identifier" => "valider",
            "portlet" => array(
                "type" => "action-direct-with-confirmation",
                "libelle" => __("Valider l'opérateur"),
                "class" => "valider-16"
            ),
            "method" => "valider",
            "permission_suffix" => "valider",
            "view" => "formulaire",
            "condition" => array('is_validable'),
        );

        // ACTION - 10 - Recherche operateur
        // Action permettant d'initier la procédure de désignation d'un opérateur.
        // Ce bouton est affiché seulement si le DA lié a déjà une clé d'accès
        $this->class_actions[10] = array(
            "identifier" => "recherche_operateur",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => __("Rechercher l'opérateur"),
                "class" => "recherche_operateur-16"
            ),
            "method" => "recherche_operateur",
            "permission_suffix" => "recherche_operateur",
            "view" => "formulaire",
            "condition" => array('is_recherche_operateur_available', 'is_param_operateur_etat_setted'),
        );
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        $champs = array(
            "dossier_operateur",
            "operateur_designation_initialisee",
            "operateur_detecte_inrap",
            "operateur_detecte_collterr",
            "operateur_collterr_type_agrement",
            "'' as operateur_message_kpark",
            "operateur_amenagement_pers_publique",
            "operateur_pers_publique_amenageur",
            "operateur_collterr_kpark_avis",
            "'' as message_consultation_amenageur",
            "operateur_personne_publique",
            "'' as message_consultation_tiers",
            "operateur_personne_publique_avis",
            "operateur_kpark_type_operateur",
            "operateur_kpark_evenement",
            "operateur_selectionne",
            "operateur_designe",
            "operateur_kpark_libelle",
            "operateur_valide",
            "operateur_designe_historique",
            "dossier_instruction",
            "'' as tab_avis",
            "'' as tab_avis_maj",
        );

        // Récupération du paramétrage stocké dans operateur_detecte_collterr à l'aide
        // de l'identifiant du dossier_operateur.
        // Ensuite, ce tableau est utilisé pour définir combien d'opérateur ont des
        // avis et combien de champs tab_avis doivent être affiché.
        if (! empty($this->f->get_submitted_get_value('idx'))
            && $this->f->get_submitted_get_value('obj') == 'dossier_operateur') {
            //
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT 
                        operateur_detecte_collterr
                    FROM
                        %1$sdossier_operateur
                    WHERE
                        dossier_operateur = %2$s',
                    DB_PREFIXE,
                    intval($this->f->get_submitted_get_value('idx'))
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $tab_collterr = json_decode(html_entity_decode($qres["result"]));
            if (! empty($tab_collterr)) {
                for ($i=0; $i < count($tab_collterr); $i++) {
                    $champs[] = "'' as tab_avis_".$i;
                }
            }
        }
        return $champs;
    }

    /**
     * Surcharge permettant de ne pas afficher le fil d'Ariane dans
     * l'overlay de notification des demandeurs.
     *
     * @param todo non utilisé
     */
    function getSubFormTitle($ent) {
        return __("Désignation de l'opérateur");
    }

    /**
     * Permet de savoir si l'état du dossier correspond a un des états paramétrés
     * dans le paramètre param_operateur.
     *
     * @return bool true|false
     */
    protected function is_param_operateur_etat_setted() {
        // Récupère le paramètre et le dossier d'instruction (DI). Vérifie si des états ont été
        // paramétrés dans param_operateur et si c'est le cas vérifie si l'état du DI
        // correspond
        $param_operateur = $this->f->get_option_param_operateur();
        $inst_dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $this->getVal('dossier_instruction'),
        ));
        if (is_object($param_operateur) === true && property_exists($param_operateur, 'etat') === true) {
            if (in_array($inst_dossier->getVal('etat'), $param_operateur->etat) === true) {
                return true;
            }
        }
        return false;
    }


    /**
     * Permet de retourner le paramètre param_operateur.
     *
     * @return array
     */
    protected function get_param_operateur() {
        // Fait appel à la méthode utils->get_option_param_operateur() et renvoie
        // le résultat si le paralétrage n'a pas déjà été récupéré.
        if (is_null($this->param_operateur)) {
            $inst_dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $this->getVal('dossier_instruction'),
            ));
            $this->param_operateur = $this->f->get_option_param_operateur($inst_dossier->getVal('om_collectivite'));
        }
        return $this->param_operateur;
    }

    /**
     * Renvoie sous la forme d'une chaîne de caractère le sql
     * permettant de récupérer la liste des tiers consulté avec
     * leur id et leur libellé
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_designe() {
        return "SELECT
                tiers_consulte.tiers_consulte,
                CONCAT_WS(
                    ' - ',
                    tiers_consulte.abrege,
                    tiers_consulte.libelle
                ) as libelle
            FROM
                ".DB_PREFIXE."tiers_consulte
            ORDER BY
                tiers_consulte.libelle ASC";
    }

    /**
     * Renvoie sous la forme d'une chaîne de caractère le sql
     * permettant de récupérer l'id et le libellé d'un tiers consulté
     * à l'aide de son id
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_designe_by_id() {
        return "SELECT
                tiers_consulte.tiers_consulte,
                CONCAT_WS(
                    ' - ',
                    tiers_consulte.abrege,
                    tiers_consulte.libelle
                ) as libelle
            FROM
                ".DB_PREFIXE."tiers_consulte
            WHERE
                tiers_consulte = <idx>";
    }

    /**
     * Renvoie sous la forme d'une chaîne de caractère le sql
     * permettant de récupérer la liste des tiers consulté avec
     * leur id et leur libellé
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_selectionne() {
        return "SELECT
                tiers_consulte.tiers_consulte,
                CONCAT_WS(
                    ' - ',
                    tiers_consulte.abrege,
                    tiers_consulte.libelle
                ) as libelle
            FROM
                ".DB_PREFIXE."tiers_consulte
            ORDER BY
                tiers_consulte.libelle ASC";
    }

    /**
     * Renvoie sous la forme d'une chaîne de caractère le sql
     * permettant de récupérer l'id et le libellé d'un tiers consulté
     * a l'aide de son id 
     * 
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_selectionne_by_id() {
        return "SELECT
                tiers_consulte.tiers_consulte,
                CONCAT_WS(
                    ' - ',
                    tiers_consulte.abrege,
                    tiers_consulte.libelle
                ) as libelle
            FROM
                ".DB_PREFIXE."tiers_consulte
            WHERE
                tiers_consulte = <idx>";
    }

    /**
     * Renvoie sous forme d'une chaine de caractére la requête sql
     * permettant de récupérer la liste de tous les tiers appartenant
     * aux catégories renseigné dans la partie categorie_tiers_amenageur_public
     * du paramètre param_operateur.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_personne_publique() {
        $param_operateur = $this->get_param_operateur();
        
        $conditions_categorie_tiers_amenageur_public = "= 0";

        if (! empty($param_operateur->categorie_tiers_amenageur_public)) {
            if (is_array($param_operateur->categorie_tiers_amenageur_public)) {
                $conditions_categorie_tiers_amenageur_public = "IN ("
                        .$this->f->db->escapeSimple(implode(',', $param_operateur->categorie_tiers_amenageur_public))
                    .")";
            } else {
                $conditions_categorie_tiers_amenageur_public = "= ".$this->f->db->escapeSimple($param_operateur->categorie_tiers_amenageur_public);
            }

        }
        return "SELECT
                    tiers_consulte.tiers_consulte,
                    tiers_consulte.libelle
                FROM
                    ".DB_PREFIXE."tiers_consulte
                WHERE
                    categorie_tiers_consulte ".$conditions_categorie_tiers_amenageur_public."
                ORDER BY
                    tiers_consulte.libelle ASC";
    }

    /**
     * Renvoie sous forme d'une chaine de caractére la requête sql
     * permettant de récupérer un tiers consulté et son libellé à partir
     * de son id.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_operateur_personne_publique_by_id() {
        return "SELECT
                tiers_consulte.tiers_consulte,
                tiers_consulte.libelle
            FROM
                ".DB_PREFIXE."tiers_consulte
            WHERE
                tiers_consulte = <idx>";
    }

    /**
     * Permet d'initialiser la recherche d'un opérateur.
     * Si un cas remplit toutes les conditions alors on affiche l'opérateur trouvé.
     *
     * @return bool true|false
     */
    protected function recherche_operateur() {
        $this->begin_treatment(__METHOD__);
        // Vérifie si le paramétrage des opérateurs est correct, c'est à dire
        // si les attributs libellé et type_operateur sont bien présents
        // pour chaque cas.
        // Si le paramétrage n'est pas bon on arrête la recherche de l'opérateur
        if ($this->verif_param_operateur() == false) {
            return $this->end_treatment(__METHOD__, false);
        }
        // Récupération du paramétrage de la désignation des opérateurs
        $param_operateur = $this->get_param_operateur();
        // Vérifie que le format du paramétrage des opérateurs est correct
        if (! is_object($param_operateur)) {
            return $this->end_treatment(__METHOD__, false);
        }

        // Initialisation des tableaux contenant le paramétrage nécessaire pour gérer
        // la recherche de l'opérateur
        $tiers_consulte_irap = array();
        $tiers_consulte_collterr = array();
        $tiers_consulte_collterr_toutdiag = array();
        $tiers_consulte_collterr_kpark = array();

        // Récupération des tiers consulté inrap. Pour cela, il fait que la catégorie des tiers inrap
        // et le type d'habilitaion des opérateurs inrap soient renseigné.
        if (property_exists($param_operateur, 'categorie_tiers_inrap') &&
            property_exists($param_operateur, 'type_habilitations_operateurs_inrap') &&
            ! empty($param_operateur->categorie_tiers_inrap) &&
            ! empty($param_operateur->type_habilitations_operateurs_inrap)) {
            // Récupération de la catégorie des tiers inrap et du type d'habilitation des opérateurs
            // inrap
            $categorie_tiers_irap = $param_operateur->categorie_tiers_inrap;
            $type_habilitations_operateurs_inrap = $param_operateur->type_habilitations_operateurs_inrap;
    
            // Construction de la requête permettant de sélectionner le tiers consulté INRAP
            // Tableau comportant la clé 'result' qui contient l'identifiant du tiers consulté INRAP
            $tiers_consulte_irap = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT 
                        tiers_consulte.tiers_consulte
                    FROM
                        %1$stiers_consulte
                            INNER JOIN %1$scategorie_tiers_consulte 
                                ON
                                    tiers_consulte.categorie_tiers_consulte = categorie_tiers_consulte.categorie_tiers_consulte
                                    AND (
                                        categorie_tiers_consulte.om_validite_debut IS NULL
                                        OR categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE
                                    )
                                    AND (
                                        categorie_tiers_consulte.om_validite_fin IS NULL
                                        OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE
                                    )
                            INNER JOIN %1$shabilitation_tiers_consulte 
                                ON
                                    habilitation_tiers_consulte.tiers_consulte = tiers_consulte.tiers_consulte
                                    AND (
                                        habilitation_tiers_consulte.om_validite_debut IS NULL
                                        OR habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE
                                    )
                                    AND (
                                        habilitation_tiers_consulte.om_validite_fin IS NULL
                                        OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE
                                    )
                            INNER JOIN %1$stype_habilitation_tiers_consulte 
                                ON
                                    habilitation_tiers_consulte.type_habilitation_tiers_consulte = type_habilitation_tiers_consulte.type_habilitation_tiers_consulte
                                    AND (
                                        type_habilitation_tiers_consulte.om_validite_debut IS NULL
                                        OR type_habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE
                                    )
                                    AND (
                                        type_habilitation_tiers_consulte.om_validite_fin IS NULL
                                        OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE
                                    )
                            INNER JOIN %1$sdossier
                                ON dossier.dossier = \'%4$s\'
                            LEFT JOIN %1$scommune
                                ON commune.commune = dossier.commune
                            LEFT JOIN %1$slien_habilitation_tiers_consulte_commune
                                ON
                                    lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
                                    AND lien_habilitation_tiers_consulte_commune.commune = commune.commune 
                            LEFT JOIN %1$slien_habilitation_tiers_consulte_departement
                                ON lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
                            LEFT JOIN %1$sdepartement
                                ON departement.departement = lien_habilitation_tiers_consulte_departement.departement
                    WHERE
                        tiers_consulte.categorie_tiers_consulte IN (%2$s) 
                        AND habilitation_tiers_consulte.type_habilitation_tiers_consulte IN (%3$s)
                        AND (
                            departement.dep = commune.dep
                            OR lien_habilitation_tiers_consulte_commune.commune = dossier.commune
                        )',
                    DB_PREFIXE,
                    implode(',', $categorie_tiers_irap),
                    implode(',', $type_habilitations_operateurs_inrap),
                    $this->f->db->escapeSimple($this->getVal("dossier_instruction"))
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
        }

        if (empty($tiers_consulte_irap['result'])) {
            $this->correct = false;
            $this->addToMessage(__("Aucun opérateur INRAP détecté."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Pour pouvoir récupérer les opérateur kpark et toutdiag, il faut s'assurer
        // que les propriétés utilisées dans les requêtes ont bien été paramétrées et
        // qu'elles ne sont pas paramétrées à vide. Sinon on risque d'avoir des erreurs
        // de base de données.
        if (property_exists($param_operateur, 'categorie_tiers_collterr') &&
            property_exists($param_operateur, 'type_habilitations_operateurs_diag_kpark') &&
            property_exists($param_operateur, 'type_habilitations_operateurs_diag_toutdiag') &&
            ! empty($param_operateur->categorie_tiers_collterr)) {

            $categorie_tiers_collterr = $param_operateur->categorie_tiers_collterr;
            $type_habilitations_operateurs_diag_kpark = $param_operateur->type_habilitations_operateurs_diag_kpark;
            $type_habilitations_operateurs_diag_toutdiag = $param_operateur->type_habilitations_operateurs_diag_toutdiag;
    
            // Récupération des opérateurs cas par cas
            // Si le type d'habilitation des opérateurs diag kpark est paramétré mais vide
            // cela risque d'entrainer des erreurs de base de données. On vérifie donc
            // que ce paramètre n'est pas vide
            if (! empty($type_habilitations_operateurs_diag_kpark)) {
                $query_tiers_consulte_collterr_kpark = sprintf(
                    'SELECT
                        tiers_consulte.tiers_consulte as identifiant,
                        tiers_consulte.libelle,
                        %1$s as habilitation,
                        CASE 
                            WHEN lien_habilitation_tiers_consulte_commune.commune IS NOT NULL
                            THEN commune.com
                            
                            WHEN lien_habilitation_tiers_consulte_departement.departement IS NOT NULL
                            THEN departement.dep
                        ELSE NULL
                        END as localisation,
                        %2$s as consultation,
                        NULL as tab_avis
                    FROM
                        %3$stiers_consulte
                        INNER JOIN openads.categorie_tiers_consulte 
                            ON  tiers_consulte.categorie_tiers_consulte = categorie_tiers_consulte.categorie_tiers_consulte
                            AND (categorie_tiers_consulte.om_validite_debut IS NULL
                                    OR categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE)
                            AND (categorie_tiers_consulte.om_validite_fin IS NULL
                                    OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)
                        INNER JOIN openads.habilitation_tiers_consulte 
                            ON habilitation_tiers_consulte.tiers_consulte = tiers_consulte.tiers_consulte
                            AND (habilitation_tiers_consulte.om_validite_debut IS NULL
                                    OR habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE)
                            AND (habilitation_tiers_consulte.om_validite_fin IS NULL
                                    OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)
                        INNER JOIN openads.type_habilitation_tiers_consulte 
                            ON habilitation_tiers_consulte.type_habilitation_tiers_consulte = type_habilitation_tiers_consulte.type_habilitation_tiers_consulte
                            AND (type_habilitation_tiers_consulte.om_validite_debut IS NULL
                                    OR type_habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE)
                            AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL
                                    OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)
                        INNER JOIN openads.dossier
                            ON dossier.dossier =\'%6$s\'
                        LEFT JOIN %3$scommune
                            ON  commune.commune = dossier.commune
        
                        LEFT JOIN %3$slien_habilitation_tiers_consulte_commune
                            ON lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
                        
                        LEFT JOIN %3$slien_habilitation_tiers_consulte_departement
                            ON lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
                        
                            LEFT JOIN %3$sdepartement
                            ON  departement.departement = lien_habilitation_tiers_consulte_departement.departement
                    WHERE
                        tiers_consulte.categorie_tiers_consulte IN (%4$s) 
                        AND habilitation_tiers_consulte.type_habilitation_tiers_consulte IN (%5$s)
                        AND (departement.dep = commune.dep OR lien_habilitation_tiers_consulte_commune.commune = dossier.commune)
                    ORDER BY
                        localisation;',
                    "'".__("Au cas par cas")."'",
                    "'".__("Consultation obligatoire")."'",
                    DB_PREFIXE,
                    implode(',', $categorie_tiers_collterr),
                    implode(',', $type_habilitations_operateurs_diag_kpark),
                    $this->getVal('dossier_instruction')
                );
        
                $tiers_consulte_collterr_kpark = $this->f->get_all_results_from_db_query(
                    $query_tiers_consulte_collterr_kpark,
                    array(
                        "origin" => __METHOD__,
                    )
                );
            }

            // Récupération des opérateurs tout diag
            // Si le type d'habilitation des opérateurs diag toutdiag est paramétré mais vide
            // cela risque d'entrainer des erreurs de base de données. On vérifie donc
            // que ce paramètre n'est pas vide
            if (! empty($type_habilitations_operateurs_diag_toutdiag)) {
                $query_tiers_consulte_collterr_toutdiag = sprintf(
                    'SELECT
                        tiers_consulte.tiers_consulte as identifiant,
                        tiers_consulte.libelle,
                        %1$s as habilitation,
                        CASE 
                            WHEN lien_habilitation_tiers_consulte_commune.commune IS NOT NULL
                            THEN commune.com
                         
                            WHEN lien_habilitation_tiers_consulte_departement.departement IS NOT NULL
                            THEN departement.dep
                        ELSE NULL
                        END as localisation,
                        NULL as consultation,
                        \'no_select\' as tab_avis
                    FROM
                        %2$stiers_consulte
                        INNER JOIN %2$scategorie_tiers_consulte 
                            ON  tiers_consulte.categorie_tiers_consulte = categorie_tiers_consulte.categorie_tiers_consulte
                            AND (categorie_tiers_consulte.om_validite_debut IS NULL
                                    OR categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE)
                            AND (categorie_tiers_consulte.om_validite_fin IS NULL
                                    OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)
                        INNER JOIN %2$shabilitation_tiers_consulte 
                            ON habilitation_tiers_consulte.tiers_consulte = tiers_consulte.tiers_consulte
                            AND (habilitation_tiers_consulte.om_validite_debut IS NULL
                                    OR habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE)
                            AND (habilitation_tiers_consulte.om_validite_fin IS NULL
                                    OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)
                        INNER JOIN %2$stype_habilitation_tiers_consulte 
                            ON habilitation_tiers_consulte.type_habilitation_tiers_consulte = type_habilitation_tiers_consulte.type_habilitation_tiers_consulte
                            AND (type_habilitation_tiers_consulte.om_validite_debut IS NULL
                                    OR type_habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE)
                            AND (type_habilitation_tiers_consulte.om_validite_fin IS NULL
                                    OR type_habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)
                        INNER JOIN openads.dossier
                            ON dossier.dossier =\'%5$s\'
                        LEFT JOIN %2$scommune
                            ON  commune.commune = dossier.commune
        
                        LEFT JOIN %2$slien_habilitation_tiers_consulte_commune
                            ON lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
                            AND lien_habilitation_tiers_consulte_commune.commune = commune.commune 
                        
                        LEFT JOIN %2$slien_habilitation_tiers_consulte_departement
                            ON lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
                        
                         LEFT JOIN %2$sdepartement
                            ON  departement.departement = lien_habilitation_tiers_consulte_departement.departement
                    WHERE
                        tiers_consulte.categorie_tiers_consulte IN (%3$s) 
                        AND habilitation_tiers_consulte.type_habilitation_tiers_consulte IN (%4$s)
                        AND (departement.dep = commune.dep OR lien_habilitation_tiers_consulte_commune.commune = dossier.commune);',
                    "'".__("Tous diag")."'",
                    DB_PREFIXE,
                    implode(',', $categorie_tiers_collterr),
                    implode(',', $type_habilitations_operateurs_diag_toutdiag),
                    $this->getVal('dossier_instruction')
                );
        
                // Tableau tout diag
                $tiers_consulte_collterr_toutdiag = $this->f->get_all_results_from_db_query(
                    $query_tiers_consulte_collterr_toutdiag,
                    array(
                        "origin" => __METHOD__,
                    )
                );
            }
        }


        $this->addToLog('query collterr tout diag: '.var_export($query_tiers_consulte_collterr_toutdiag,true), VERBOSE_MODE);
        $this->addToLog('collterr tout diag: '.var_export($tiers_consulte_collterr_toutdiag, true), VERBOSE_MODE);
        
        // Si il n'y a pas de kpark alors le champ operateur_collterr_type_agrement a pour valeur 'toutdiag'
        if (! empty($tiers_consulte_collterr_toutdiag['result'])) {
            $valF['operateur_collterr_type_agrement'] = 'tout_diag';
        }
        if (! empty($tiers_consulte_collterr_kpark['result'])) {
            $valF['operateur_collterr_type_agrement'] = 'kpark';
        }

        // On fusionne les deux tableaux
        $tiers_consulte_collterr = array_merge_recursive($tiers_consulte_collterr_toutdiag['result'], $tiers_consulte_collterr_kpark['result']);
        $this->addToLog('collterr all: '.var_export($tiers_consulte_collterr, true), VERBOSE_MODE);

        // On convertit en json
        if (empty($tiers_consulte_collterr) === false) {
            $tiers_consulte_collterr = json_encode($tiers_consulte_collterr);
        }

        $this->addToLog('json collterr: '.var_export($tiers_consulte_collterr, true), VERBOSE_MODE);

        //Mise à jour des champs suite à la recherche d'opérateurs
        $valF['operateur_detecte_inrap'] = $tiers_consulte_irap['result'];
        $valF['operateur_detecte_collterr'] = empty($tiers_consulte_collterr) ? NULL : $tiers_consulte_collterr;
        $valF['operateur_designation_initialisee'] = 't';

        $this->addToLog('modifier : '.var_export($valF, true), VERBOSE_MODE);
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.$this->table,
            $valF, 
            DB_AUTOQUERY_UPDATE,
            $this->clePrimaire."=".$this->getVal($this->clePrimaire)
        );
        //
        $this->addToLog(
            __METHOD__." : db->autoExecute(\"".DB_PREFIXE.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getVal('dossier_operateur')."\")",
            VERBOSE_MODE
        );

        if ($this->f->isDatabaseError($res, true)) {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }

        $this->check_all_cases();

        // On enlève les messages en trop
        $this->msg = '';
        $this->addToMessage(__("Recherche effectuée."));
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Vérifie que les attributs libelle et type_operateur sont bien présents
     * pour chaque cas.
     * Si ce n'est pas le cas retourne un message d'erreur.
     *
     * @return bool true|false
     */
    protected function verif_param_operateur() {
        $param_operateur = $this->get_param_operateur();
        foreach ($param_operateur->cas as $cas) {
            if (! is_object($cas) || ! isset($cas->libelle) || ! isset($cas->type_operateur)) {
                $this->correct = false;
                $this->addToMessage(__("Le paramétrage est incorrect. Contactez votre administrateur"));
                return false;
            }
        }
        return true;
    }

    /**
     * Permet de boucler sur tous les cas présent dans le paramètre
     * param_operateur afin de trouver un cas ou les conditions sont toutes remplis
     *
     * @return bool true|false
     */
    function check_all_cases() {
        $param_operateur = $this->get_param_operateur();

        // Pour récupérer les informations mises à jours dans la recherche
        // il faut récupérer les valeurs depuis une nouvelle instance de l'objet
        $inst_dossier_operateur = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_operateur",
            "idx" => $this->getVal('dossier_operateur'),
        ));

        // Permet de déterminer si un opérateur collterr peut être désigné
        $tab_collterr = $this->get_operateur_selectionne(json_decode(html_entity_decode($inst_dossier_operateur->getVal('operateur_detecte_collterr'))));

        // Initialisation des paramètres du dossier
        $param_dossier = array(
            'P1' => $inst_dossier_operateur->getVal('operateur_detecte_inrap'),
            'P2' => $inst_dossier_operateur->getVal('operateur_detecte_collterr') == NULL ? NULL : 'collterr',
            'P3' => $inst_dossier_operateur->getVal('operateur_collterr_type_agrement'),
            'P4' => NULL,
            'P5' => NULL,
            'P6' => ! empty($tab_collterr) ? $tab_collterr['avis'] : NULL,
            'P7' => $inst_dossier_operateur->getVal('operateur_personne_publique_avis'),
        );

        if ($inst_dossier_operateur->getVal('operateur_amenagement_pers_publique') == 't') {
            $param_dossier['P4'] = true; 
        } else if ($inst_dossier_operateur->getVal('operateur_amenagement_pers_publique') == 'f') {
            $param_dossier['P4'] = false;
        }

        if ($inst_dossier_operateur->getVal('operateur_pers_publique_amenageur') == 't') {
            $param_dossier['P5'] = true; 
        } else if ($inst_dossier_operateur->getVal('operateur_pers_publique_amenageur') == 'f') {
            $param_dossier['P5'] = false;
        }

        foreach ($param_operateur->cas as $cas) {
            
            $parametres_param_operateur = $cas->parametre;

            $tab_result_cas = array(
                'libelle' => $cas->libelle,
                'type_operateur' => $cas->type_operateur,
                'evenement' => property_exists($cas, 'evenement') === true ?
                    $cas->evenement :
                    null
            );
            foreach ($parametres_param_operateur as $key => $parametre) {
                $tab_result_cas[$key] = false;
                if (array_key_exists($key, $param_dossier)
                    && $parametre === $param_dossier[$key]) {
                    $tab_result_cas[$key] = true;
                }
            }

            if (in_array(false, $tab_result_cas)) {
                $tab_result_cas = array(
                    'libelle' => null,
                    'type_operateur' => null,
                    'evenement' => null
                );
                continue;
            } else {
                break;
            }
        }

        $this->addToLog('array : '.var_export($tab_result_cas, true), VERBOSE_MODE);
        $valF = array(
            'operateur_kpark_libelle' => $tab_result_cas['libelle'],
            'operateur_kpark_type_operateur' => $tab_result_cas['type_operateur'],
            'operateur_kpark_evenement' => $tab_result_cas['evenement'],
            'operateur_collterr_kpark_avis' => $param_dossier['P6'],
            'operateur_selectionne' => null
        );

        if (is_null($tab_result_cas['libelle']) === false
            && is_null($tab_result_cas['type_operateur']) === false) {
            if ($tab_result_cas['type_operateur'] === 'inrap') {
                $valF['operateur_selectionne'] = $inst_dossier_operateur->getVal('operateur_detecte_inrap');
            }

            if ($tab_result_cas['type_operateur'] === 'collterr') {
                $valF['operateur_selectionne'] = $tab_collterr['identifiant'];
            }
        }
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.$this->table,
            $valF,
            DB_AUTOQUERY_UPDATE,
            $this->clePrimaire."=".$this->getVal($this->clePrimaire)
        );
        //
        $this->addToLog(
            __METHOD__." : db->autoExecute(\"".DB_PREFIXE.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getVal('dossier_operateur')."\")",
            VERBOSE_MODE
        );

        if ($this->f->isDatabaseError($res, true)) {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            // Termine le traitement
            return false;
        }

        return true;
    }

    /**
     * Permet de déterminer quel opérateur doit être sélectionné.
     * 
     * @param obj $tab_collterr  Tableau qui contient tous les opérateurs collterr
     * 
     * @return array Tableau contenant l'identifiant de l'acteur et l'avis
     */
    function get_operateur_selectionne($tab_collterr) {
        $is_all_avis = true;
        # On sépare les opérateurs par avis
        $tab_fav_operateur = array();
        $tab_defav_operateur = array();
        $tab_tacite_operateur = array();
        $tab_tout_diag_operateur = array();
        if (! empty($tab_collterr)) {
            foreach ($tab_collterr as $key => $value) {
                if ($value->tab_avis == "F") {
                    $tab_fav_operateur[] = array(
                        'identifiant' => $value->identifiant,
                        // Si la longeur de la localisation est <= 3 alors c'est un département, sinon c'est une commune
                        'com_ou_dep' => strlen($value->localisation) <=3 ? 'dep' : 'com',
                        'avis' => $value->tab_avis,
                    );
                }

                if ($value->tab_avis == "D") {
                    $tab_defav_operateur[] = array(
                        'identifiant' => $value->identifiant,
                        'com_ou_dep' => strlen($value->localisation) <=3 ? 'dep' : 'com',
                        'avis' => $value->tab_avis,
                    );
                }

                if ($value->tab_avis == "T") {
                    $tab_tacite_operateur[] = array(
                        'identifiant' => $value->identifiant,
                        'com_ou_dep' => strlen($value->localisation) <=3 ? 'dep' : 'com',
                        'avis' => $value->tab_avis,
                    );
                }

                if ($value->tab_avis == "no_select") {
                    $tab_tout_diag_operateur[] = array(
                        'identifiant' => $value->identifiant,
                        'com_ou_dep' => strlen($value->localisation) <=3 ? 'dep' : 'com',
                        'avis' => $value->tab_avis,
                    );
                }

                if (empty($value->tab_avis)) {
                    $is_all_avis = false;
                }

                $this->addToLog('get operateur collterr: '.var_export($key, true).' '.var_export($value, true), VERBOSE_MODE);
                $this->addToLog('obj tab_avis: '.var_export($value->tab_avis, true), VERBOSE_MODE);
                $this->addToLog('obj tab_fav: '.var_export($tab_fav_operateur, true), VERBOSE_MODE);
                $this->addToLog('obj is_all_avis: '.var_export($is_all_avis, true), VERBOSE_MODE);
            }
        }

        // Stock dans un array les tableaux des infos sur le retour de l'opérateur
        $tab_retour_reponse_operateur = array(
            $tab_fav_operateur, 
            $tab_defav_operateur, 
            $tab_tacite_operateur
        );

        foreach ($tab_retour_reponse_operateur as $tab_resp_operateur) {

            if(!empty($tab_resp_operateur)){
                if (array_search('com', array_column($tab_resp_operateur, 'com_ou_dep')) !== false) {
                    return $tab_resp_operateur[array_search('com', array_column($tab_resp_operateur, 'com_ou_dep'))];
                }
                return $tab_resp_operateur[0];
            }
        }

        if ($this->getVal('operateur_collterr_type_agrement') == 'tout_diag') {
            if (! empty($tab_tout_diag_operateur)) {
                if (array_search('com', array_column($tab_tout_diag_operateur, 'com_ou_dep')) !== false) {
                    return $tab_tout_diag_operateur[array_search('com', array_column($tab_tout_diag_operateur, 'com_ou_dep'))];
                }
            }
            return $tab_tout_diag_operateur[0];
        }
        return array();
    }

    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        parent::setTaille($form, $maj);
        $form->setTaille("tab_avis_maj", 20);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        parent::setMax($form, $maj);
        $form->setMax("tab_avis_maj", 20);
    }

    /**
     * Permet de vérifier si l'action de modification doit être affichée.
     * La modification est possible si il la designation de l'operateur
     * a été initialisé, si l'opérateur n'a pas encore été validé et si la
     * liste des tiers consultés Collectivités Territoriales n'est pas vide.
     *
     * @return bool true|false
     */
    protected function is_editable() {
        if ($this->getVal('operateur_designation_initialisee') == 't'
            && $this->getVal('operateur_valide') == 'f'
            && ! empty($this->getVal('operateur_detecte_collterr'))) {

            return true;
        }
        return false;
    }

    /**
     * Permet de vérifier si l'action de réinitialisation doit être affichée
     * C'est le cas a partir du moment ou on initialise la designation de
     * l'operateur.
     *
     * @return bool true|false
     */
    protected function is_reinitialisable() {
        return ($this->getVal('operateur_designation_initialisee') == 't');
    }

    /**
     * Permet de vérifier si l'action de validation de l'opérateur doit être affichée
     * L'operateur peut être validé si un opérateur est designé mais qu'il n'est pas
     * encore validé.
     *
     * @return bool true|false
     */
    protected function is_validable() {
        if (! empty($this->getVal('operateur_selectionne'))
            && $this->getVal('operateur_valide') == 'f') {
            return true;
        }
        return false;
    }

    /**
     * Permet de vérifier que l'action de recherche d'un opérateur est affichable.
     * C'est le cas lorsque la designation de l'opérateur n'a pas été initialisée.
     *
     * @return bool true|false
     */
    protected function is_recherche_operateur_available() {
        return ($this->getVal('operateur_designation_initialisee') == 'f');
    }

    /**
     * Permet de remettre tous les champs à leur valeur par défaut,
     * excepté pour le dossier d'instruction lié, l'historique des opérateurs 
     * désignés et l'identifiant de la table dossier_operateur
     *
     * @return bool true|false
     */
    protected function reinitialiser() {
        $this->begin_treatment(__METHOD__);
        // mise à jour des champs
        $valF = array();

        // Il faut traiter tous les champs de l'objet
        foreach($this->champs as $identifiant => $champ) {
            $valF[$champ] = NULL;
        }

        // Récupère la liste des tiers consulté des collectivités territoriales et remet
        // leur avis à 0
        $tab_collterr = json_decode(html_entity_decode($this->getVal('operateur_detecte_collterr')));
        if (! empty($tab_collterr)) {
            for ($i=0; $i<count($tab_collterr); $i++) {
                unset($valF["tab_avis_".$i]);
            }
        }
        // Supprime du tableau des valeurs du formulaire tous les champs ayant été ajouté
        // mais qui n'existe pas dans la base de données. Evite des erreurs lors de la mise
        // a jour des données.
        unset($valF['tab_avis']);
        unset($valF['tab_avis_maj']);
        unset($valF['operateur_message_kpark']);
        unset($valF['message_consultation_amenageur']);
        unset($valF['message_consultation_tiers']);
        // Prépare les valeurs devant être conservé ou mise à jour
        $valF['operateur_designation_initialisee'] = false;
        $valF['operateur_valide'] = 'f';
        $valF['dossier_instruction'] = $this->getVal('dossier_instruction');
        $valF['dossier_operateur'] = $this->getVal('dossier_operateur');
        $valF['operateur_designe_historique'] = $this->getVal('operateur_designe_historique');
        // Met a jour les valeurs dans la Base de Données. En cas d'erreur
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
            return false;
        }

        $this->addToMessage(__("Réinitialisation effectuée."));
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Permet de valider l'opérateur désigné et de mettre à jour l'historique
     * des opérateurs désignés.
     *
     * @return bool true|false
     */
    protected function valider() {
        $this->begin_treatment(__METHOD__);

        // On vérifie que l'évènement existe avant de modifier l'opérateur
        // On gère l'ajout de l'evènement paramétré si il y en a un
        $operateur_kpark_evenement = $this->getVal('operateur_kpark_evenement');
        if (! empty($operateur_kpark_evenement)) {
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        *
                    FROM
                        %1$sevenement
                    WHERE
                        evenement=%2$s',
                    DB_PREFIXE,
                    intval($operateur_kpark_evenement)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            // Si l'événement paramétré n'existe pas informe l'utilisateur que son paramétrage
            // n'est pas correct
            if (empty($qres["result"])) {
                $this->correct = false ;
                $this->addToMessage(__("L'événement paramétré n'existe pas. Vérifiez le paramétrage"));
                return $this->end_treatment(__METHOD__, false);
            }

            // La validation de l'opérateur déclenche l'ajout de l'événement d'instruction paramétré
            // Pour cela on ajoute une nouvelle instruction ayant pour évenement l'évenement
            // paramétré, qui sera associée au dossier d'instruction sur lequel on valide l'opérateur
            // et dont la date d'événement sera la date de validation.
            $new_instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => "]",
            ));

            // Création d'un tableau avec la liste des champs de l'instruction
            $valNewInstr = array();
            foreach ($new_instruction->champs as $champ) {
                $valNewInstr[$champ] = "";
            }
            // Définition des valeurs de la nouvelle instruction
            $valNewInstr["evenement"] = $this->getVal('operateur_kpark_evenement');
            $valNewInstr["dossier"] = $this->getVal('dossier_instruction');
            $valNewInstr["date_evenement"] = $this->f->formatDate(date('Y-m-d'));
            // Ajout de l'instruction liée à la validation de l'opérateur
            $new_instruction->setParameter("maj", 0);
            $retour = $new_instruction->ajouter($valNewInstr);

            //Si une erreur s'est produite et qu'il s'agit d'un problème
            //de restriction
            if ($retour == false && $new_instruction->restriction_valid) {
                $this->correct = false ;
                $this->msg .= $new_instruction->msg;
                return $this->end_treatment(__METHOD__, false);
            }
        }

        // Récupération du libellé de l'opérateur designé
        $operateur_designe_libelle_query = str_replace(
            '<idx>',
            $this->getVal('operateur_selectionne'),
            $this->get_var_sql_forminc__sql_operateur_designe_by_id()
        );
        $res = $this->f->get_all_results_from_db_query(
            $operateur_designe_libelle_query,
            array(
                "origin" => __METHOD__,
            )
        );

        // Préparation de l'ajout de l'opérateur désigné
        $valF = array();

        // Pour appeler la fonction modifier il faut traiter tous les champs de l'objet
        foreach ($this->champs as $identifiant => $champ) {
            $valF[$champ] = $this->val[$identifiant];
        }
        // On fait ensuite nos modifications spécifiques
        $valF['operateur_valide'] = 't';
        $valF['operateur_designe'] = $this->getVal('operateur_selectionne');

        // Si il y a déjà un historique on le récupère
        $dossier_operateur_historique_json = $this->getVal('operateur_designe_historique');
        $dossier_operateur_historique = array();
        if (! empty($dossier_operateur_historique_json)) {
            $dossier_operateur_historique = json_decode(str_replace("'", '"', $dossier_operateur_historique_json), true);
        }
        // Ajoute une nouvelle ligne à l'historique de désignation de l'opérateur
        $dossier_operateur_historique[] = array(
            'entry_date' => date('d/m/Y H:i:s'),
            'operateur' => $res['result'][0]['libelle'],
            'login' => $_SESSION['login'],
        );
        // Ajoute l'historique au tableau des valeurs qui vont servir à mettre à jour le dossier_operateur
        $valF['operateur_designe_historique'] = json_encode($dossier_operateur_historique, JSON_HEX_APOS);

        $ret = $this->modifier($valF);

        if ($ret === false) {
            $this->correct = false;
            $this->addToMessage(__("Une erreur est survenue lors de la mise à jour des champs."));
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }

        $this->addToMessage(__("Validation effectuée."));
        return $this->end_treatment(__METHOD__, true);
    }

    function setType(&$form,$maj) {
        parent::setType($form,$maj);

        foreach ($this->champs as $champ) {
            $form->setType($champ,'hidden');
        }
        $form->setType('operateur_detecte_inrap', 'selecthiddenstatic');
        $form->setType('operateur_detecte_collterr', 'hiddenstatic');

        // Ces champs sont cachés en javascript
        if ($this->getVal('operateur_amenagement_pers_publique') == 't') {
            $form->setType('operateur_pers_publique_amenageur', 'selecthiddenstatic');
            $form->setType('operateur_personne_publique_avis', 'selecthiddenstatic');

            if ($this->getVal('operateur_pers_publique_amenageur') == 'f') {
                $form->setType('message_consultation_amenageur', 'hiddenstatic');
                $form->setType('message_consultation_tiers', 'hiddenstatic');
                $form->setType('operateur_personne_publique', 'selecthiddenstatic');
            }
        }
        
        if ($maj<=2) {
            $form->setType('operateur_personne_publique', 'select');
            $form->setType('operateur_pers_publique_amenageur', 'select');
            $form->setType('operateur_personne_publique_avis', 'select');
        }
        $form->setType('message_consultation_amenageur', 'hiddenstatic');
        $form->setType('message_consultation_tiers', 'hiddenstatic');

        if ($this->getVal('operateur_collterr_type_agrement') == 'kpark') {
            $form->setType('operateur_message_kpark', 'hiddenstatic');
        }

        if (empty($this->getVal('operateur_selectionne')) === false) {
            $form->setType('operateur_selectionne', 'selecthiddenstatic');
            $form->setType('operateur_kpark_libelle', 'hiddenstatic');

            if (empty($this->getVal('operateur_designe')) === false) {
                $form->setType('operateur_selectionne', 'hidden');
                $form->setType('operateur_designe', 'selecthiddenstatic');
            }
        }

        if (empty($this->getVal('operateur_designe_historique')) === false) {
            $form->setType('operateur_designe_historique', 'jsontotab');
        }

        if ($this->getVal('operateur_designation_initialisee') == 't') {
            if (empty($this->getVal('operateur_detecte_collterr')) === false) {
                $form->setType('operateur_detecte_collterr', 'tab_custom');

                $tab_collterr = json_decode(html_entity_decode($this->getVal('operateur_detecte_collterr')));
                if (! empty($tab_collterr)) {
                    for ($i=0; $i<count($tab_collterr); $i++) {
                        if ($tab_collterr[$i]->tab_avis !== 'no_select') {
                            $form->setType("tab_avis_".$i, 'selecthiddenstatic');
                        }
                    }
                }
                $form->setType('tab_avis', 'selecthiddenstatic');
                if ($maj < 2) {
                    $form->setType('tab_avis', 'select');
                    if (! empty($tab_collterr)) {
                        for ($i=0; $i<count($tab_collterr); $i++) {
                            if ($tab_collterr[$i]->tab_avis !== 'no_select') {
                                $form->setType("tab_avis_".$i, 'select');
                            }
                        }
                    }
                }
            }
            
            if (!empty($this->getVal('operateur_detecte_inrap'))
                && !empty($this->getVal('operateur_detecte_collterr'))) {
                $form->setType('operateur_amenagement_pers_publique', 'selecthiddenstatic');
                if ($maj < 2) {
                    $form->setType('operateur_amenagement_pers_publique', 'select');
                    $form->setType('operateur_designe_historique', 'hidden');
                }
            }
        }
    }

    function setOnchange(&$form, $maj) {
        parent::setOnchange($form, $maj);

        if ($maj <= 2) {
            // Ajout la fonction permettant d'afficher/cacher les champs 
            // dans le formulaire de modification
            $form->setOnchange('operateur_amenagement_pers_publique', "switch_operateur_amenagement_pers_public($(this).val())");
        }
    }

    function setLayout(&$form, $maj) {
        //Champs sur lequel s'ouvre le fieldset
        $form->setBloc('operateur_detecte_inrap', 'D', "", 'col_10');
        $form->setFieldset('operateur_detecte_inrap', 'D', __('Opérateurs'));

        //Champs sur lequel se ferme le fieldset
        $form->setFieldset('operateur_message_kpark', 'F', '');
        $form->setBloc('operateur_message_kpark', 'F');


        if (!empty($this->getVal('operateur_detecte_inrap'))
            && !empty($this->getVal('operateur_detecte_collterr'))) {
            $form->setBloc('operateur_amenagement_pers_publique', 'DF', "", "col_10");
            $form->setFieldset('operateur_amenagement_pers_publique', 'DF', __('Aménagement'));
        }

        //Champs sur lequel s'ouvre le fieldset
        $form->setBloc('operateur_pers_publique_amenageur', 'D', "", "col_10");
        $form->setFieldset('operateur_pers_publique_amenageur', 'D', __("Consultation de l'aménageur"));
        //Champs sur lequel se ferme le fieldset
        $form->setFieldset('operateur_personne_publique_avis', 'F');
        $form->setBloc('operateur_personne_publique_avis', 'F', "");

        // Si le champ operateur_selectionne n'est pas vide
        if (! empty($this->getVal('operateur_selectionne'))) {
            //Champs sur lequel s'ouvre le fieldset
            $form->setBloc('operateur_selectionne', 'D', "", "col_10");
            $form->setFieldset('operateur_selectionne', 'D', __('Opérateur désigné'));
            //Champs sur lequel se ferme le fieldset
            $form->setFieldset('operateur_kpark_libelle', 'F');
            $form->setBloc('operateur_kpark_libelle', 'F', "");
        }
        $form->setBloc('operateur_designe_historique', 'DF', "", "col_10");
        $form->setFieldset('operateur_designe_historique', 'DF', __('Historique'));
    }

    function setLib(&$form, $maj) {
        $form->setLib('operateur_detecte_inrap', __('INRAP'));
        $form->setLib('operateur_detecte_collterr', __('Opérateur'));
        $form->setLib('operateur_designe', '');
        $form->setLib('operateur_selectionne', '');
        $form->setLib('operateur_kpark_libelle', '');
        $form->setLib('operateur_message_kpark', '');
        $form->setLib(
            'operateur_amenagement_pers_publique',
            __("L'aménagement est-il réalisé par ou pour une personne publique (R523-28) ?")
        );
        $form->setLib(
            'operateur_pers_publique_amenageur',
            __("La personne publique \"article R523-28\" est-elle l'aménageur du projet ?")
        );
        $form->setLib('message_consultation_amenageur', '');
        $form->setLib('message_consultation_tiers', '');
        $form->setLib('operateur_personne_publique', __("Tiers aménageur"));
        $form->setLib('operateur_personne_publique_avis', __("Avis rendu"));
        // valeur utilisé seulement pour traduire la colonne tab_avis avec poedit
        $tab_avis = __('tab_avis');
    }


        /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        // parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $this->retourformulaire = $retourformulaire;
        //
        if ($validation == 0) {
            // Si on est dans le dossier
            if ($this->getParameter("retourformulaire") == "dossier"
                || $this->getParameter("retourformulaire") == "dossier_instruction") {
                //
                $form->setVal("dossier_instruction", $this->getParameter("idxformulaire"));
            }
        }

        if ($this->getVal('operateur_detecte_collterr') == NULL
            && $this->getVal('operateur_designation_initialisee') == 't') {
            $form->setVal('operateur_detecte_collterr', __("Aucun opérateur détecté."));
        }

        if ($this->getVal('operateur_detecte_collterr') != NULL) {
            $form->setVal('operateur_detecte_collterr', htmlentities($this->getVal('operateur_detecte_collterr')));
        }

        if ($this->getVal('operateur_collterr_type_agrement') == 'kpark') {
            $form->setVal('operateur_message_kpark', __("Vous devez consulter les opérateurs au cas par cas depuis l'onglet Consultation"));
        }

        // Affiché ou caché en JS
        $form->setVal('message_consultation_amenageur', __("Vous devez consulter l'aménageur depuis l'onglet Consultation."));
        $form->setVal('message_consultation_tiers', __("Vous devez consulter le tiers sélectionné."));
    }

    function setvalF($val = array()) {
        parent::setvalF($val);
        // En fonction de la valeur sélectionné il faut vider certains champs
        if ($val['operateur_amenagement_pers_publique'] == 'f') {
            $this->valF['operateur_pers_publique_amenageur'] = NULL;
            $this->valF['operateur_personne_publique_avis'] = NULL;
            $this->valF['operateur_personne_publique'] = NULL;
        }

        if ($val['operateur_pers_publique_amenageur'] == 't') {
            $this->valF['operateur_personne_publique'] = NULL;
        }
    }

    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);

        // Contient l'option '' qui est masquée en JS
        $contenu_operateur_pers_publique_amenageur = array();
        $contenu_operateur_pers_publique_amenageur[0][0]='';
        $contenu_operateur_pers_publique_amenageur[1][0]='';
        $contenu_operateur_pers_publique_amenageur[0][1]="f";
        $contenu_operateur_pers_publique_amenageur[1][1]=__('Non');
        $contenu_operateur_pers_publique_amenageur[0][2]="t";
        $contenu_operateur_pers_publique_amenageur[1][2]=__('Oui');
        $form->setSelect("operateur_pers_publique_amenageur", $contenu_operateur_pers_publique_amenageur);
        
        $contenu_operateur_amenagement_pers_publique = array();
        $contenu_operateur_amenagement_pers_publique[0][0]="f";
        $contenu_operateur_amenagement_pers_publique[1][0]=__('Non');
        $contenu_operateur_amenagement_pers_publique[0][1]="t";
        $contenu_operateur_amenagement_pers_publique[1][1]=__('Oui');
        $form->setSelect("operateur_amenagement_pers_publique", $contenu_operateur_amenagement_pers_publique);

        $contenu_tab_avis =array();
        $contenu_tab_avis[0][0]="";
        $contenu_tab_avis[1][0]=__('Sélectionner un avis');
        $contenu_tab_avis[0][1]="F";
        $contenu_tab_avis[1][1]=__('Favorable');
        $contenu_tab_avis[0][2]="D";
        $contenu_tab_avis[1][2]=__('Défavorable');
        $contenu_tab_avis[0][3]="T";
        $contenu_tab_avis[1][3]=__('Tacite');
        $form->setSelect("tab_avis", $contenu_tab_avis);
        
        $tab_collterr = json_decode(html_entity_decode($this->getVal('operateur_detecte_collterr')));
        if (! empty($tab_collterr)) {
            for ($i=0; $i<count($tab_collterr); $i++) {
                if ($tab_collterr[$i]->tab_avis !== 'no_select') {
                    $form->setSelect("tab_avis_".$i, $contenu_tab_avis);
                }
            }
        }

        $form->setSelect("operateur_personne_publique_avis", $contenu_tab_avis);
    }



    /**
     * Surcharge du bouton retour afin de retourner sur le dossier d'instruction selon le cas.
     * En ajout et en modification si le formualire n'a pas été validé et qu'on est dans le contexte
     * d'un dossier d'instruction alors la redirection renvoie vers le dossier d'instruction.
     *
     * @param string idxformulaire : identifiant de l'objet du formulaire
     * @param string retourformulaire : nom de l'objet du formulaire
     * @param string val : valeur issue du formulaire
     * @param string objsf : nom de l'objet du sous-formulaire
     * @param string premiersf :
     * @param string tricolsf :
     * @param string validation : indique si le formulaire a été validé ou pas
     * @param string idx : identifiant de l'objet du sous-formulaire
     * @param string maj : identifiant de l'action utilisée
     * @param string retour : indique si on renvoie vers le listing ou vers un formulaire
     *
     * @return void
     */
    function retoursousformulaire($idxformulaire = NULL, $retourformulaire = NULL, $val = NULL,
                                  $objsf = NULL, $premiersf = NULL, $tricolsf = NULL, $validation = NULL,
                                  $idx = NULL, $maj = NULL, $retour = NULL) {

        // Ajout et consultation, retour dossier
        if (( $maj == 0 && $validation == 0 ) ||
            ( $maj == 3 && $validation == 0 ) ||
            ( $maj == 0 && $validation == 1 ) &&
            $retourformulaire == "dossier_instruction"
        ) {
            echo '<a class="retour" href="#" onclick="redirectPortletAction(1,\'main\');">'.
                __("Retour").
            '</a>';

            return;
        }

        //Sinon affiche un retour normal
        parent::retoursousformulaire($idxformulaire, $retourformulaire, $val,
                                $objsf, $premiersf, $tricolsf, $validation,
                                $idx, $maj, $retour);
    }

    function update_tab_collterr() {
        if (empty($this->getVal('operateur_detecte_collterr'))) {
            return true;
        }

        $operateurs_collterr = json_decode(html_entity_decode($this->getVal('operateur_detecte_collterr')));
        if (isset($_POST['tab_avis_maj'])) {
            $tab_avis = json_decode($_POST['tab_avis_maj']);
        }

        foreach ($operateurs_collterr as $key => $value) {
            if (isset($tab_avis[$key]) && $tab_avis[$key] !== NULL) {
                $operateurs_collterr[$key]->tab_avis = $tab_avis[$key];
                $valF['tab_avis_'.$key] = $tab_avis[$key];
            }
        }

        $valF = array();
        $valF['operateur_detecte_collterr'] = json_encode($operateurs_collterr);

        $this->addToLog("maj operateur collterr : ".var_export($operateurs_collterr, true), VERBOSE_MODE);
        // Cette méthode est appellée dans la méthode triggermodifierapres(). On utilise donc
        // un autoexecute pour mettre les valeurs à jour et pas la méthode modifier pour éviter
        // de faire boucler le code
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.$this->table,
            $valF,
            DB_AUTOQUERY_UPDATE,
            $this->clePrimaire."=".$this->getVal($this->clePrimaire)
        );
        //
        $this->addToLog(
            __METHOD__." : db->autoExecute(\"".DB_PREFIXE.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getVal('dossier_operateur')."\")",
            VERBOSE_MODE
        );

        if ($this->f->isDatabaseError($res, true)) {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            // Termine le traitement
            return false;
        }

        return true;
    }


    /**
     * Permet de modifier l'affichage des boutons dans le sousformulaire.
     * @param string  $datasubmit Données a transmettre
     * @param integer $maj        Mode du formulaire
     * @param array   $val        Valeur du formulaire
     */
    function boutonsousformulaire($datasubmit, $maj, $val = null) {

        (isset($_GET['obj']) ? $obj = $this->f->get_submitted_get_value('obj') : $obj = "");
        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $id_dossier_operateur = 
            $this->f->get_submitted_get_value('idxformulaire') : $id_dossier_operateur = "");

        $tab_detecte_collterr = json_decode(html_entity_decode($this->getVal('operateur_detecte_collterr')));

        $count_result_tab = count($tab_detecte_collterr);
        //
        if (!$this->correct) {
            // Action par défaut
            $onclick =  "affichersform('".$this->get_absolute_class_name()."', 
                '$datasubmit', this.form);return false;";
            //
            switch ($maj) {
                case 0:
                    $bouton = __("Ajouter");
                    break;
                case 1:
                    $bouton = __("Modifier");
                    // Action en mode ajouter
                    $onclick = "get_avis_from_operateur_kpark(".$count_result_tab.");return";
                    break;
                case 2:
                    $bouton = __("Supprimer");
                    break;
            }
            //
            $params = array(
                "value" => $bouton,
                "onclick" => $onclick,
            );
            //
            $this->f->layout->display_form_button($params);
        }
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->update_tab_collterr();
        $this->check_all_cases();
    }
}
