<?php
/**
 * Ce fichier permet de déclarer la classe messages, ressource exposée à
 * travers l'interface REST qui hérite de la classe de base Services.
 *
 * @package openfoncier
 * @version SVN : $Id: messages.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// Inclusion de la classe de base Services
include_once('./REST/services.php');

// Inclusion de la classe messagesManager qui effectue le traitement métier
include_once('./metier/messagesmanager.php');

/**
 * Cette classe définie la ressource 'messages' qui permet d'exposer : l'envoi
 * de messages depuis l'application d'un autre service de la mairie qui
 * travaille en collaboration très étroite avec l'instructeur au sujet d'un
 * dossier.
 */
class messages extends Services {

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
        $this->contents = array(
            "type" => "",
            "date" => "",
            "emetteur" => "",
            "dossier_instruction" => "",
            "contenu" => "",
        );

        // On compare que les tableaux attendus et reçus ont exactement les
        // mêmes clés, si ce n'est pas le cas alors on lève une erreur 400
        if (array_keys($this->contents) != array_keys($request_data)) {
            return $this->sendHttpCode(
                400,
                "La structure des données reçues n'est pas correcte."
            );
        }

        // Instanciation de la classe qui s'occupe du traitement métier
        $this->metier_manager = new MessagesManager();
        if ($this->metier_manager->f->authenticated !== true) {
            return $this->sendHttpCode(500, __("Erreur lors de la connexion au serveur."));
        }

        // Exécution du traitement
        $ret = $this->metier_manager->run($request_data);

        // Gestion du retour en fonction du résultat
        return $this->sendReply($ret, $this->metier_manager->getMessage());

    }

}

?>
