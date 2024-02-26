<?php
/**
 * Ce fichier permet de déclarer la classe maintenance, ressource exposée à
 * travers l'interface REST qui hérite de la classe de base Services.
 *
 * @package openfoncier
 * @version SVN : $Id: maintenance.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// Inclusion de la classe de base Services
include_once('./REST/services.php');

// Inclusion de la classe maintenanceManager qui effectue le traitement métier
include_once('./metier/maintenancemanager.php');

/**
 * Cette classe définie la ressource 'maintenance' qui permet d'exposer des
 * traitements qui ont vocation à être déclenché de manière automatique ou par
 * une application externe. Par exemple, un cron permet chaque soir d'exécuter
 * la synchronisation des utilisateurs de l'application avec l'annuaire LDAP.
 */
class maintenance extends Services {

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
        $this->contents['module'] = '';
        $this->contents['data'] = '';

        // Vérification de la validité du format des données de la requête REST
        // Si le format n'est pas correct, on retourne un code 400
        if (!$this->requestValid($request_data, array('data'))) {
            return $this->sendHttpCode(400, "Le format des données reçues".
                                       " n'est pas correct.");
        }

        // Instanciation de la classe qui s'occupe du traitement métier
        $this->metier_manager = new MaintenanceManager();
        if ($this->metier_manager->f->authenticated !== true) {
            return $this->sendHttpCode(500, __("Erreur lors de la connexion au serveur."));
        }

        //On initialise la variable à vide si elle n'a pas été renseignée dans la 
        //requête
        $request_data['data'] = (isset($request_data['data'])) ? $request_data['data'] : "";

        // Exécution du traitement
        $ret = $this->metier_manager->performMaintenance($request_data['module'],
                                                         $request_data['data']);

        // Gestion du retour en fonction du résultat
        return $this->sendReply($ret, $this->metier_manager->getMessage());

    }

}

?>
