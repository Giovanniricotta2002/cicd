<?php
/**
 * Ce fichier permet de déclarer la classe dossier_instructions, ressource 
 * exposée à travers l'interface REST qui hérite de la classe de base Services.
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_instruction.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// Inclusion de la classe de base Services
include_once('./REST/services.php');

// Inclusion de la classe DossierInstructionManager qui effectue le traitement
// métier
include_once('./metier/dossierinstructionmanager.php');

/**
 * Cette classe définie la ressource 'dossier_instruction' qui permet
 * de mettre à jour des dossier d'instruction
 */
class dossier_instructions extends Services {

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

        // Initialisation de l'attribut contents avec les clés qui doivent être
        // récupérées dans les données JSON reçues
        $this->contents = array(
            "message" => "",
            "date" => "",
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
        $this->metier_manager = new DossierInstructionManager();
        if ($this->metier_manager->f->authenticated !== true) {
            return $this->sendHttpCode(500, __("Erreur lors de la connexion au serveur."));
        }

        // Exécution du traitement
        $ret = $this->metier_manager->updateDossierInstructionAT($request_data, $id);
      
        // Gestion du retour en fonction du résultat
        return $this->sendReply($ret, $this->metier_manager->getMessage());
    }

    /**
     * Cette méthode permet de définir le traitement du GET sur une requête
     * REST. Elle vérifie la validité du format des données reçues, effectue le
     * traitement et retourne le résultat.
     *
     * @param string $id L'identifiant de la ressource.
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
        $this->metier_manager = new DossierInstructionManager();
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
