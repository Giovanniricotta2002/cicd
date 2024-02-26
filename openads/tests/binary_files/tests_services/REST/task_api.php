<?php
/**
 * Ce fichier permet de déclarer la classe demande_api, qui expose la ressource demande
 * exposée à travers l'interface REST qui hérite de la classe de base Services.
 *
 * @package openfoncier
 * @version SVN : $Id: demande_api.php 6956 2017-06-22 14:58:57Z jymadier $
 */

// Inclusion de la classe de base Services
include_once('../services/REST/services.php');

// Inclusion de la classe taskaddManager qui effectue le traitement métier
include_once('./metier/taskaddmanager.php');

/**
 * Cette classe définit la ressource 'task'.
 */
class task_api extends Services {

    /**
     * Cette méthode permet de définir le traitement du POST sur une requête
     * REST. Elle vérifie la validité du format des données reçues, effectue le
     * traitement et retourne le résultat.
     * 
     * @param mixed $request_data Les données JSON reçues (voir @uses)
     */
    public function post($request_data) {

        // Log - services.log
        $this->log(__METHOD__." - ".print_r($request_data, true));

        // Initialisation de l'attribut contents avec les clés qui doivent être
        // récupérées dans les données JSON reçues
        $this->contents['data'] = '';

        // Instanciation de la classe qui s'occupe du traitement métier
        $this->metier_manager = new TaskAddManager();

        // Exécution du traitement
        $ret = $this->metier_manager->create($request_data);

        // Gestion du retour en fonction du résultat
        return $this->sendReply($ret, $this->metier_manager->getMessage());
    }
}
