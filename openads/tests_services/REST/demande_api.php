<?php
/**
 * Ce fichier permet de déclarer la classe demande_api, qui expose la ressource demande
 * exposée à travers l'interface REST qui hérite de la classe de base Services.
 *
 * @package openfoncier
 * @version SVN : $Id: demande_api.php 9923 2021-02-11 22:10:22Z fmichon $
 */

// Inclusion de la classe de base Services
include_once('../services/REST/services.php');

// Inclusion de la classe demandeManager qui effectue le traitement métier
include_once('./metier/demandemanager.php');

/**
 * Cette classe définit la ressource 'demande'.
 */
class demande_api extends Services {

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
        $this->demande_manager = new DemandeManager();
        if ($this->demande_manager->f->authenticated !== true) {
            return $this->sendHttpCode(500, __("Erreur lors de la connexion au serveur."));
        }

        // Exécution du traitement
        $ret = $this->demande_manager->create($request_data);

        // Gestion du retour en fonction du résultat
        return $this->sendReply($ret, $this->demande_manager->getMessage());

    }

}

?>
