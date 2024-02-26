<?php
/**
 * Ce script permet de définir la classe referentiel_erp_test, ressource
 * exposée à travers l'interface REST qui hérite de la classe de base Services.
 * Cette classe servira pour les tests afin de simuler l'échange avec le
 * référentiel ERP.
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
class referentiel_erp_test extends Services {

    public function post($request_data) {
        //
        $content = array(
            'type' => '',
            'date' => '',
            'emetteur' => '',
            'dossier_instruction' => '',
            'contenu' => '',
        );
        //
        if (!isset($request_data["type"]) || !in_array($request_data["type"],
            array(
                "ADS_ERP__AT__INFORMATION_DE_QUALIFICATION_ADS",
                "ADS_ERP__PC__PRE_DEMANDE_DE_COMPLETUDE_ERP",
                "ADS_ERP__PC__PRE_DEMANDE_DE_QUALIFICATION_ERP",
                "ADS_ERP__PC__CONSULTATION_OFFICIELLE_POUR_AVIS",
                "ADS_ERP__PC__INFORMATION_DE_DECISION_ADS",
                "ADS_ERP__PC__CONSULTATION_OFFICIELLE_POUR_CONFORMITE",
                "ADS_ERP__PC__DEMANDE_DE_VISITE_D_OUVERTURE_ERP",
                "ADS_ERP__AT__DEPOT_INITIAL",
                "ADS_ERP__AT__RETRAIT_DU_PETITIONNAIRE",
                "ADS_ERP__AT__DEMANDE_DE_VISITE_D_OUVERTURE_ERP",
                "ADS_ERP__AT__DEPOT_DE_PIECE_PAR_LE_PETITIONNAIRE",
                "ADS_ERP__AJOUT_D_UNE_NOUVELLE_PIECE_NUMERISEE",
                "ADS_ERP__PC__ENJEU_ADS",
            ))) {
            //
            return $this->sendHttpCode(
                400,
                "Problème de type !"
            );
        }
        //
        if (!isset($request_data["date"]) || $request_data["date"] === '') {
            //
            return $this->sendHttpCode(
                400,
                "Problème de date !"
            );
        }
        //
        if (!isset($request_data["emetteur"]) || $request_data["emetteur"] === '') {
            //
            return $this->sendHttpCode(
                400,
                "Problème d'emetteur !"
            );
        }
        //
        if (!isset($request_data["dossier_instruction"]) || $request_data["dossier_instruction"] === '') {
            //
            return $this->sendHttpCode(
                400,
                "Problème de dossier d'instruction !"
            );
        }
        //
        if ($request_data["type"] == "ADS_ERP__PC__ENJEU_ADS"
            && (!array_key_exists("Dossier à enjeu ADS", $request_data["contenu"])
            || ($request_data["contenu"]["Dossier à enjeu ADS"] != 'oui'
                && $request_data["contenu"]["Dossier à enjeu ADS"] != 'non'))) {

            return $this->sendHttpCode(
                400,
                "Problème de contenu !"
            );
        }
        //
        return $this->sendHttpCode(
            200,
            "Cool !"
        );
    }

    /**
     * Aucun log sur la ressource de test.
     */
    function log($message = "") {
        return;
    }
}
    
?>
