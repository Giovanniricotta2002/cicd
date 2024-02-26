<?php
/**
 * DBFORM - 'demande_dossier_encours' - Surcharge obj.
 *
 * Ce script permet de définir la classe 'demande_dossier_encours'.
 *
 * @package openads
 * @version SVN : $Id: demande_dossier_encours.class.php 5984 2016-02-19 08:41:12Z fmichon $
 */

require_once "../obj/demande.class.php";

/**
 * Définition de la classe 'demande_dossier_encours'.
 *
 * Cette classe permet d'interfacer l'ajout de demande sur un dossier existant.
 */
class demande_dossier_encours extends demande {

    /**
     *
     */
    protected $_absolute_class_name = "demande_dossier_encours";

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions définies dans la méthode d'initialisation
        // de la classe parente
        parent::init_class_actions();

        // ACTION - 200 - get_possible_demande_type_on_dossier
        //
        $this->class_actions[200] = array(
            "identifier" => "get_possible_demande_type_on_dossier",
            "view" => "view_possible_demande_type_on_dossier",
            "permission_suffix" => "consulter",
        );
    }

    /**
     * [get_possible_demande_type_on_dossier description]
     * @param  [type] $dossier      [description]
     * @param  [type] $type_demande [description]
     * @return [type]               [description]
     */
    public function get_possible_demande_type_on_dossier($dossier, $type_demande = null) {

        // Récupère les informations nécessaires sur le dossier d'instruction par une requête SQL
        $query = sprintf('
            SELECT
                dossier.om_collectivite as om_collectivite,
                dossier_autorisation_type_detaille.dossier_autorisation_type_detaille as datd_id,
                dossier_autorisation_type_detaille.code as datd_code,
                dossier.etat as etat
            FROM %1$sdossier
            INNER JOIN %1$sdossier_instruction_type
                ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
            INNER JOIN %1$sdossier_autorisation_type_detaille
                ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            WHERE dossier.dossier = \'%2$s\'
            LIMIT 1
            ',
            DB_PREFIXE, 
            $dossier
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            return false;
        }
        if (empty($res['result']) === true) {
            return array('dossier_exists' => false,);
        }
        $dossier_data = $res['result'][0];

        // Contrôle le type de demande
        if ($type_demande === null) {
            return array('dossier_exists' => true,);
        }
        // Compose le nom du paramètre
        $type_demande_param = sprintf('%s_%s_%s', 'platau_type_demande', $type_demande, $dossier_data['datd_code']);
        // Récupère les paramètres de la collectivité
        $param_collectivite = $this->f->getCollectivite($dossier_data['om_collectivite']);
        // Récupère le paramètre dans la collectivité du dossier
        $type_demande_code = null;
        if (is_array($param_collectivite) === true
            && isset($param_collectivite[$type_demande_param]) === true) {
            //
            $type_demande_code = $param_collectivite[$type_demande_param];
        }
        if (empty($type_demande_code) === true) {
            $this->addToLog(sprintf(
                '%s(): %s',
                __METHOD__,
                sprintf(
                    __("Le paramètre '%s' n'est pas défini pour la collectivité/le service dont l'identifiant est %s"),
                    $type_demande_param,
                    $dossier_data['om_collectivite']
                )),
                DEBUG_MODE
            );
            return array('dossier_exists' => true, 'possible_demande_type' => false,);
        }
        // Récupère l'identifiant du type de la demande
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    demande_type.demande_type
                FROM
                    %1$sdemande_type
                WHERE
                    demande_type.code = \'%2$s\'
                    AND demande_type.dossier_autorisation_type_detaille = %3$s
                    AND demande_type.demande_type IN (
                        SELECT DISTINCT
                            demande_type
                        FROM
                            %1$slien_demande_type_etat
                        WHERE
                            etat = \'%4$s\'
                    )',
                DB_PREFIXE,
                $this->f->db->escapeSimple($type_demande_code),
                intval($dossier_data['datd_id']),
                $this->f->db->escapeSimple($dossier_data['etat'])
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $demande_type_id = $qres["result"];
        if (empty($demande_type_id) === true) {
            return array('dossier_exists' => true, 'possible_demande_type' => false,);
        }

        // Récupère la liste des types de demande possibles sur le dossier d'instruction
        $res = $this->f->get_all_results_from_db_query(
            $this->get_query_demande_type_by_dossier($dossier),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            return false;
        }
        $list_demande_type = $res['result'];

        // Contrôle la possibilité d'ajouter une demande du type souhaité
        foreach ($list_demande_type as $demande_type) {
            if ($demande_type['dt'] === $demande_type_id) {
                // Vérifie également qu'une task n'est pas déjà en cours
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => 0,
                ));
                $search_values = array(
                    sprintf('json_payload::json->\'demande\'->>\'dossier_initial\' = \'%s\'', $dossier),
                    sprintf('json_payload::json->\'demande\'->>\'type_demande\' = \'%s\'', $type_demande),
                    sprintf('state IN (\'%s\')', implode('\', \'', array($inst_task::STATUS_DRAFT, $inst_task::STATUS_NEW, $inst_task::STATUS_PENDING, $inst_task::STATUS_ERROR, $inst_task::STATUS_DEBUG))),
                );
                $task_exists = $inst_task->task_exists_multi_search($search_values);
                if ($task_exists === false) {
                    return array('dossier_exists' => true, 'possible_demande_type' => true,);
                }
            }
        }

        //
        return array('dossier_exists' => true, 'possible_demande_type' => false,);
    }

    /**
     * VIEW
     * [view_possible_demande_type_on_dossier description]
     * @return [type] [description]
     */
    public function view_possible_demande_type_on_dossier() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        //
        $dossier = $this->getParameter("idx_dossier");
        $type_demande = $this->f->get_submitted_get_value('type_demande');

        $result = $this->get_possible_demande_type_on_dossier($dossier, $type_demande);
        //
        if ($result !== false) {
            //
            printf(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }

    /**
     * Surcharge du bouton retour afin de retourner sur le dashboard
     */
    function retour($premier = 0, $recherche = "", $tricol = "") {

        echo "\n<a class=\"retour\" ";
        echo "href=\"".OM_ROUTE_DASHBOARD;
        //
        echo "\"";
        echo ">";
        //
        echo _("Retour");
        //
        echo "</a>\n";

    }

    /**
     * Permet de modifier le fil d'Ariane
     * @param string $ent Fil d'Ariane
     * @param array  $val Valeurs de l'objet
     * @param intger $maj Mode du formulaire
     */
    function getFormTitle($ent) {

        // Si l'identifiant du dossier est renseigné
        $dossier = $this->getParameter("idx_dossier");
        if (isset($dossier) && trim($dossier) != '') {
            $dossier = $this->f->get_inst__om_dbform(array(
                'obj' => 'dossier_instruction',
                'idx' => $dossier
            ));
            $dossier_libelle = $dossier->getVal('dossier_libelle');
            if (isset($dossier_libelle) && trim($dossier_libelle) != '') {
                $ent .= " -> "."<span class='color-num-di'>".mb_strtoupper($dossier_libelle, "UTF-8")."</span>";
            }
        }

        // Change le fil d'Ariane
        return $ent;
    }


    /**
     * Indique si la redirection vers le lien de retour est activée ou non.
     *
     * L'objectif de cette méthode est de permettre d'activer ou de désactiver
     * la redirection dans certains contextes.
     *
     * @return boolean
     */
    function is_back_link_redirect_activated() {
        //
        return false;
    }

    /**
     *
     */
    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        // Par défaut les champs sont tous cachés
        $form->setType('num_doss_type_da', 'hidden');
        $form->setType('num_doss_code_depcom', 'hidden');
        $form->setType('num_doss_annee', 'hidden');
        $form->setType('num_doss_division', 'hidden');
        $form->setType('num_doss_sequence', 'hidden');
        $form->setType('num_doss_manuel', 'hidden');
        $form->setType('affectation_automatique', 'hidden');
        $form->setType('num_doss_complet', 'hidden');
    }

    /**
     * Le formulaire pour les dépôts de demande sur dossier existant, est considéré comme
     * en ajout. Ce mode élimine les données expirées dans les différents select du formulaire.
     * Or dans ce cas spécifique, il est nécessaire que le type détaillé des dossiers d'autorisation
     * soient tous disponibles.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille() {
        return "SELECT
  dossier_autorisation_type_detaille.dossier_autorisation_type_detaille,
  dossier_autorisation_type_detaille.libelle
FROM ".DB_PREFIXE."dossier_autorisation_type_detaille
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
    ON dossier_autorisation_type_detaille.dossier_autorisation_type=dossier_autorisation_type.dossier_autorisation_type
LEFT JOIN ".DB_PREFIXE."groupe
    ON dossier_autorisation_type.groupe=groupe.groupe
LEFT JOIN ".DB_PREFIXE."cerfa ON dossier_autorisation_type_detaille.cerfa = cerfa.cerfa
ORDER BY dossier_autorisation_type_detaille.libelle ASC";
    }
}


