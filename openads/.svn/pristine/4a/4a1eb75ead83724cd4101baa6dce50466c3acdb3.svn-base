<?php
/**
 * Ce fichier permet de déclarer la classe consultations, ressource exposée à
 * travers l'interface REST qui hérite de la classe de base Services.
 *
 * @package openfoncier
 * @version SVN : $Id: consultations.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// Inclusion de la classe de base Services
include_once('./REST/services.php');

// Inclusion de la classe consultationManager qui effectue le traitement métier
include_once('./metier/consultationmanager.php');

/**
 * Cette classe définie la ressource 'consultations' qui permet d'exposer : la
 * saisie d'un retour d'avis sur une consultation par un service interne à la
 * mairie qui souhaite interfacer cette action dans son propre logiciel (ERP).
 */
class consultations extends Services {

    /**
     * Cette méthode permet de définir le traitement du PUT sur une requête
     * REST. Elle vérifie la validité du format des données reçues, effectue le
     * traitement et retourne le résultat.
     *
     * @param mixed $request_data Les données JSON reçues (voir @uses)
     * @param string $id L'identifiant de la ressource
     */
    public function put($id, $request_data) {

        // Données de la requête dont certaines chaînes de caractères ont été
        // réduites
        $request_data_log = $this->short_request_data_for_log($request_data);

        // Log - services.log
        $this->log(__METHOD__." - id:".$id." - ".print_r($request_data_log, true));

        // Vérification de l'existence de l'ID de la requête REST
        // Si l'id d'est pas présent, on retourne un code 400
        if (!$id || empty($id)) {
            return $this->sendHttpCode(400, "Aucun identifiant fourni pour la ressource.");
        }

        // Initialisation de l'attribut contents avec les clés qui doivent être
        // récupérées dans les données JSON reçues
        $this->contents['date_retour'] = '';
        $this->contents['avis'] = '';

        // Vérification de la validité du format des données de la requête REST
        // Si le format n'est pas correct, on retourne un code 400
        $optional = array('motivation', 'nom_fichier', 'fichier_base64');
        if (!$this->requestValid($request_data, $optional)) {
            return $this->sendHttpCode(400, "La structure des données reçues n'est pas correcte.");
        }

        // Instanciation de la classe qui s'occupe du traitement métier
        $this->metier_manager = new ConsultationManager();
        if ($this->metier_manager->f->authenticated !== true) {
            return $this->sendHttpCode(500, __("Erreur lors de la connexion au serveur."));
        }

        // Exécution du traitement
        $ret = $this->metier_manager->consultationDecision($request_data, $id);

        // Gestion du retour en fonction du résultat
        return $this->sendReply($ret, $this->metier_manager->getMessage());

    }

}

?>
