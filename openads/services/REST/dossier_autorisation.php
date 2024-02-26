<?php
/**
 * Ce fichier permet de déclarer la classe messages, ressource exposée à
 * travers l'interface REST qui hérite de la classe de base Services.
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_autorisation.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// Inclusion de la classe de base Services
include_once('./REST/services.php');

// Inclusion de la classe DossierAutorisationManager qui effectue le traitement
// métier
include_once('./metier/dossierautorisationmanager.php');

/**
 * Cette classe définie la ressource 'dossier_autorisation' qui permet
 * d'exposer : ...
 */
class dossier_autorisations extends Services {

    /**
     * Cette méthode permet de définir le traitement du PUT sur une requête
     * REST. Elle vérifie la validité du format des données reçues, effectue le
     * traitement et retourne le résultat.
     *
     * @param mixed $request_data Les données JSON reçues (voir @uses)
     * @param string $id L'identifiant de la ressource
     */
    public function put($id, $request_data) {

        // Log - services.log
        $this->log(__METHOD__." - id:".$id." - ".print_r($request_data, true));

        // Vérification de l'existence de l'ID de la requête REST
        // Si l'id d'est pas présent, on retourne un code 400
        if (!$id || empty($id)) {
            return $this->sendHttpCode(400, "Aucun identifiant fourni pour la ressource.");
        }

        // Initialisation de l'attibut mdtry_grps avec les groupes de clés qui
        // doivent être présents dans le tableau JSON reçu
        $this->mdtry_grps = array(
            "setERPBuildingNumber" => array(
                'numero_erp',
            ),
            "orderERPOpenedIsSigned" => array(
                'erp_ouvert', 'date_arrete'
            ),
            "orderERPDecisionIsSigned" => array(
                'arrete_effectue', 'date_arrete'
            ),
        );

        // Vérification de la validité du format des données de la requête REST
        // Si le format n'est pas correct, on retourne un code 400
        $method = $this->requestMdtrGroup($request_data);
        if (is_null($method)) {
            return $this->sendHttpCode(400,
                            _("La structure des données reçues n'est pas correcte."));
        }

        // Instanciation de la classe qui s'occupe du traitement métier
        $this->metier_manager = new DossierAutorisationManager();
        if ($this->metier_manager->f->authenticated !== true) {
            return $this->sendHttpCode(500, __("Erreur lors de la connexion au serveur."));
        }

        // Exécution du traitement
        $ret = $this->metier_manager->$method($request_data, $id);
        
        // Gestion du retour en fonction du résultat
        return $this->sendReply($ret, $this->metier_manager->getMessage());

    }

    /**
     * Cette méthode permet de définir le traitement du GET sur une requête
     * REST. Elle vérifie la validité du format des données reçues, effectue le
     * traitement et retourne le résultat.
     *
     * @param string $id L'identifiant de la ressource
     * 
     * @todo XXX Commenter le fonctionnement
     */
    public function get($id) {

        // Log - services.log
        $this->log(__METHOD__." - id:".$id);

        // Vérification de l'existence de l'ID de la requête REST
        // Si l'id d'est pas présent, on retourne un code 400
        if (!$id || empty($id)) {
            return $this->sendHttpCode(400, "Aucun identifiant fourni pour la ressource.");
        }

        // Instanciation de la classe qui s'occupe du traitement métier
        $this->metier_manager = new DossierAutorisationManager();
        if ($this->metier_manager->f->authenticated !== true) {
            return $this->sendHttpCode(500, __("Erreur lors de la connexion au serveur."));
        }

        // Exécution du traitement
        $ret = $this->metier_manager->consultDossier($id);

        // Gestion du retour en fonction du résultat
        if ($ret != 'OK') {
            // send the reply
            return $this->sendReply($ret, $this->metier_manager->getMessage());
        }

        //
        return $this->metier_manager->getDossierArrayRepresentation();

    }

}

?>
