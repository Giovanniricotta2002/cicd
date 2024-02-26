<?php
/**
 * Ce script permet de définir la classe trouillotage_service_test, ressource
 * exposée à travers l'interface REST qui hérite de la classe de base Services.
 * Cette classe servira pour les tests afin de simuler l'échange avec le
 * service de trouillotage.
 *
 * @package openads
 * @version SVN : $Id$
 */
 
// Inclusion de la classe de base Services
require_once "../services/REST/services.php";

/**
 * Cette classe définie la ressource 'referentiel_erp_test' qui permet de
 * tester l'échange avec le référentiel ERP.
 */
class trouillotage_service_test extends Services {

    public function post($request_data) {
        //
        if (isset($request_data) === false) {
            //
            $response = $this->sendHttpCode(
                400,
                "Problème de contenu !"
            );
        } else {
            //
            $response = $this->sendHttpCode(
                200,
                json_encode($request_data)
            );
            $response["base64"] = chunk_split(base64_encode(file_get_contents("../tests/binary_files/test_trouillotage_pdf.pdf")));
        }
        //
        return $response;
    }

    /**
     * Aucun log sur la ressource de test.
     */
    function log($message = "") {
        return;
    }
}

?>
