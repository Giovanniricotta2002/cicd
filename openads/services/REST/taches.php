<?php
/**
 * Ce fichier permet de déclarer la classe taches, ressource exposée à
 * travers l'interface REST qui hérite de la classe de base Services.
 *
 * @package openads
 * @version SVN : $Id: taches.php
 */

// définition du chemin absolu vers la racine du projet
if (! defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(dirname(__DIR__)));
}

// dépendance à la classe de base Services
require_once PROJECT_ROOT.'/services/REST/services.php';

// Dépendence à la classe TaskManager qui effectue le traitement métier
require_once PROJECT_ROOT.'/services/metier/taskmanager.php';

/**
 * Classe à laquelle est mappé l'API 'taches' et qui va traiter les appels de cette API
 * via les méthodes du même nom que les endpoints. Cf doc micro-framework Restler.
 */
class taches extends Services {

    /**
     * Cette méthode permet de définir une API pour les requêtes HTTP POST.
     * Elle vérifie la validité du format des données reçues, effectue le
     * traitement et retourne le résultat.
     *
     * @param  mixed   $request_data   Les données JSON reçues
     *
     * @return 
     */
    public function post($request_data) {

        // Log - services.log
        $this->log(__METHOD__." - ".print_r($request_data, true));

        // Instanciation de la classe qui s'occupe du traitement métier
        $this->metier_manager = new TaskManager();

        // Exécution du traitement
        $ret = $this->metier_manager->traitement($request_data);

        // Gestion du retour en fonction du résultat
        return $this->sendReply($ret, $this->metier_manager->getMessage());
    }
}
