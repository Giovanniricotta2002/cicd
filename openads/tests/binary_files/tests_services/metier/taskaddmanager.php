<?php
/**
 * Ce fichier permet de déclarer la classe DemandeManager, qui effectue les
 * traitements pour la ressource 'task'.
 *
 * @package openfoncier
 * @version SVN : $Id: taskmanager.php 8989 2019-10-31 15:09:51Z softime $
 */

// Inclusion de la classe de base MetierManager
require_once("../services/metier/metiermanager.php");
require_once("../obj/task.class.php");


/**
 * Cette classe hérite de MetierManager. Elle permet de créer des tasks, de
 * la même manière qu'une task aurait été créée par l'interface : les dossiers
 * d'autorisation, dossiers d'instruction et taskurs liés sont aussi créés (si 
 * applicable).
 * La gestion des codes d'erreur est volontairement succinte : on renvoie une
 * erreur 400 dès qu'on rencontre une erreur à n'importe quel moment de la
 * création de la task. On procède de cette manière car il n'est pas possible
 * actuellement dans OM de savoir quelle est la raison de l'échec d'une méthode
 * comme ajouter(), erreur interne ou mauvaises données.
 */
class TaskAddManager extends MetierManager {

    /**
     * Méthode principale qui gère le processus entier de création de task :
     *  - création du ou des taskurs
     *  - création d'une nouvelle task ou task sur existant
     *
     * @param array $request_data Les données brutes de la task sous forme
     * de tableau associatif :
     * @return string Le résultat du traitement
     */
    public function create($request_data) {
        $this->f->disableLog();

        // ajoute une tâche en fonction des données reçues

        // vérifie que la clé 'task' existe
        if(!isset($request_data['task'])){
            $this->setMessage(__(
                    "Le paramètre 'task' n'est pas présent dans les données, ".
                    "mais est obligatoire"));
            return $this->BAD_DATA;
        }

        // prépartion et vérification des données reçues
        $return_code = $this->OK;
        $params = array();
        foreach(array('type', 'json_payload', 'stream', 'category', ) as $key) {

            //
            if ($key === 'category') {
                if (isset($request_data['task'][$key]) === true) {
                    $params['val'][$key] = $request_data['task'][$key];
                } else {
                    $params['val'][$key] = PLATAU;
                }
                break;
            }

            // si le paramètre requis n'est pas présent
            if (!isset($request_data['task'][$key])) {
                $this->setMessage(__(
                    "Le paramètre '$key' n'est pas présent dans les données, ".
                    "mais est obligatoire"));
                $return_code = $this->BAD_DATA;
                break;
            }

            // s'il est vide
            elseif (empty($request_data['task'][$key])) {
                $this->setMessage(__("Le paramètre '$key' ne peut être vide"));
                $return_code = $this->BAD_DATA;
                break;
            }

            // vérifie le type
            elseif(!is_string($request_data['task'][$key])) {
                $this->setMessage(__(
                    "Le paramètre '$key' doit être de type string ".
                    "(et non '".gettype($request_data['task'][$key])."')"));
                $return_code = $this->BAD_DATA;
                break;
            }

            else {

                // ajoute l'éléments aux données de la future tâche
                $params['val'][$key] = $request_data['task'][$key];
            }
        }

        // instanciation et ajout de la tâche
        if ($return_code === $this->OK) {
            $tache = new task(null);
            $result = $tache->add_task($params);
            if ($result === false) {
                $return_code = $this->BAD_DATA;
                $this->setMessage($this->filtreBalisesHtml($tache->msg));
            }
            else {
                $this->setMessage(sprintf(
                    __("Tâche '%s' ajoutée avec succès"),
                    $tache->getVal($tache->clePrimaire)));
            }
        }

        return $return_code;
    }
}

