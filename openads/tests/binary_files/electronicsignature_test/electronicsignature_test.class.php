<?php
/**
 * Connecteur parapheur de test
 */

require_once '../obj/electronicsignature.class.php';

class electronicsignature_test extends electronicsignature_base {

    public function send_for_signature(array $data, string $file_content, array $dossier_metadata, array $optional_data = null) {
        // Produit une exception
        if ($data['signataire_arrete_email'] === 'caseerror1@test.test') {
            throw new electronicsignature_connector_exception(
                "Produit une exception sur la méthode send_for_signature."
            );
        }

        // Initialisation du tableau de retour pour ne pas avoir d'erreur si l'adresse mail
        // utilisée n'est pas renseigné dans cette méthode
        $ret = array(
            "id_parapheur_signature" => "plop",
            "om_utilisateur_email" => $data['om_utilisateur_email'],
            "signataire_arrete_email" => $data['signataire_arrete_email'],
            "date_envoi_signature" => date("c"),
            "date_limite_instruction" => $data['date_limite_instruction'],
            "date_retour_signature" => null,
            "statut" => "in_progress",
            'commentaire_signature' => 'Cas par défaut'
        );

        // Cas d'erreur pour la méthode get_signature_status
        if ($data['signataire_arrete_email'] === 'caseerror2@test.test') {

            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => "8b7430f6dbb7452f80e5246c4c4e5fc4",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => ''
            );
        }

        // Cas d'erreur pour la méthode get_signed_document
        if ($data['signataire_arrete_email'] === 'caseerror3@test.test') {

            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => "9f6711b627a44d32993dfc01ee6f53a4",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => ''
            );
        }

        // Premier cas de test
        if ($data['signataire_arrete_email'] === 'case1@test.test'
            || $data['signataire_arrete_email'] === 'case1-1@test.test') {

            if ($data['signataire_arrete_email'] === 'case1-1@test.test'
                && substr($dossier_metadata['url_di'], 0, 20) !== 'test_metadata_url_di') {
                //
                throw new electronicsignature_connector_exception(
                    "Produit une exception sur la méthode send_for_signature : url_di n'a pas *test_metadata_url_di*."
                );
            }

            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => "271da22cbc074aecba263f01d70360b4",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => ''
            );
        }

        // Deuxième cas de test
        if ($data['signataire_arrete_email'] === 'case2@test.test'
            || $data['signataire_arrete_email'] === 'case2-1@test.test') {

            if ($data['signataire_arrete_email'] === 'case2-1@test.test'
                && substr($dossier_metadata['url_di'], 0, 20) === 'test_metadata_url_di') {
                //
                throw new electronicsignature_connector_exception(
                    "Produit une exception sur la méthode send_for_signature : url a *test_metadata_url_di*."
                );
            }

            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => "91497e7939d443588eeeef62edeadb17",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => $dossier_metadata['url_di'],
            );
        }

        // Troisième cas de test
        if ($data['signataire_arrete_email'] === 'case3@test.test') {

            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => "ff1dfc3ccc094829afe8f44a0e14fa75",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => '',
            );
        }

        // Quatrième cas de test
        if ($data['signataire_arrete_email'] === 'case4@test.test') {

            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => "ff1dcc3ccc094829afe8f44a0e14fa75",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                "commentaire_signature" => $data['commentaire_signature'],
            );
        }

        // Cinquième cas de test
        if ($data['signataire_arrete_email'] === 'case5@test.test') {

            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => "dd1dfc3ccc094829afe8f44a0e14fa75",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                "commentaire_signature" => "Test date limite : ".$data['date_limite_instruction'],
            );
        }

        // Sixiième cas de test
        if ($data['signataire_arrete_email'] === 'case6@test.test') {

            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => "ff1dcc3ccc094829afe8f44a0e14fa88",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                // On fait en sorte que la date soit différente de la date du jour 
                // lorsqu'on renvoie en signature
                "date_envoi_signature" => date("c", strtotime('-1 days')),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                "commentaire_signature" => $data['commentaire_signature'],
            );
        }

        // Cas de test pour compteur de signatures
        if ($data['signataire_arrete_email'] == 'signataire-cptsign-1@test.test') {
            $ret = array(
                "id_parapheur_signature" => "34482553b97248a7924683207b507c2b",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => ''
            );
        }
        if ($data['signataire_arrete_email'] == 'signataire-cptsign-2@test.test') {
            $ret = array(
                "id_parapheur_signature" => "ce619fae70504b5b8d4388a9f5de498b",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => ''
            );
        }
        if ($data['signataire_arrete_email'] == 'signataire-cptsign-3@test.test') {
            $ret = array(
                "id_parapheur_signature" => "a7a9c6831c0243ca993ab64dbcb3fe38",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => '',
            );
        }
        if ($data['signataire_arrete_email'] == 'signataire-marseille-cptsign@test.test') {
            $ret = array(
                "id_parapheur_signature" => "d5aec52717f64675a302c1c2322c0348",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => '',
            );
        }

        // Cas de test pour notification au signataire
        if ($data['signataire_arrete_email'] == 'signataire-notifsign-1@test.test') {
            $ret = array(
                "id_parapheur_signature" => "afc93a19d66a49f4a0ef9b8b6146f32f",
                "om_utilisateur_email" => $data['om_utilisateur_email'],
                "signataire_arrete_email" => $data['signataire_arrete_email'],
                "date_envoi_signature" => date("c"),
                "date_limite_instruction" => $data['date_limite_instruction'],
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => '',
                'signature_page_url' => 'http://localhost/test-notif-signataire'
            );
        }

        return $ret;
    }

    public function get_signature_status(array $data) {
        // Produit une exception
        if ($data['id_parapheur_signature'] === "8b7430f6dbb7452f80e5246c4c4e5fc4") {
            throw new electronicsignature_connector_exception(
                "Produit une exception sur la méthode get_signature_status."
            );
        }

        $ret = array();

        // Cas d'erreur pour la méthode get_signed_document
        if ($data['id_parapheur_signature'] === "9f6711b627a44d32993dfc01ee6f53a4") {
            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "finished",
                'commentaire_signature' => ! empty($data['commentaire_signature']) ? $data['commentaire_signature'] : '',
            );
        }

        // Premier cas de test
        if ($data['id_parapheur_signature'] === "271da22cbc074aecba263f01d70360b4") {
            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => isset($data['commentaire_signature']) ? '' : null,
            );
            # On ajoute le commentaire la première fois qu'on fait un get_signature_status
            if ($ret['commentaire_signature'] == null) {
                $ret['commentaire_signature'] = "Test de commentaire lorsque le statut est en cours, l'apostrophe est aussi testé ;)";
            }
        }

        // Deuxième cas de test
        if ($data['id_parapheur_signature'] === "91497e7939d443588eeeef62edeadb17") {
            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "finished",
                'commentaire_signature' => ! empty($data['commentaire_signature']) ? $data['commentaire_signature'] : '',
            );
        }

        // Troisième cas de test
        if ($data['id_parapheur_signature'] === "ff1dfc3ccc094829afe8f44a0e14fa75") {
            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "canceled",
                "commentaire_signature" => "Test d'un commentaire refus.",
            );
        }

        // Quatrième cas de test
        if ($data['id_parapheur_signature'] === "ff1dcc3ccc094829afe8f44a0e14fa75") {
            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "canceled",
                "commentaire_signature" => "Test d'un commentaire refus.",
            );
        }

        // Cinquième cas de test
        if ($data['id_parapheur_signature'] === "dd1dfc3ccc094829afe8f44a0e14fa75") {
            $date_jour = date("Y-m-d");
            $date_limite = strtotime($date_jour."+1 days");
            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => "Test date limite : ".date("Y-m-d", $date_limite),
            );
        }

        // Sixième cas de test
        if ($data['id_parapheur_signature'] === "ff1dcc3ccc094829afe8f44a0e14fa88") {
            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "expired",
                "commentaire_signature" => null,
            );
        }

        // Cas de test pour compteur de signatures
        if ($data['id_parapheur_signature'] == '34482553b97248a7924683207b507c2b') {
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "finished",
                'commentaire_signature' => ! empty($data['commentaire_signature']) ? $data['commentaire_signature'] : '',
            );
        }
        if ($data['id_parapheur_signature'] == 'ce619fae70504b5b8d4388a9f5de498b') {
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "in_progress",
                'commentaire_signature' => ! empty($data['commentaire_signature']) ? $data['commentaire_signature'] : '',
            );
        }
        if ($data['id_parapheur_signature'] == 'a7a9c6831c0243ca993ab64dbcb3fe38') {
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "finished",
                'commentaire_signature' => ! empty($data['commentaire_signature']) ? $data['commentaire_signature'] : '',
            );
        }
        if ($data['id_parapheur_signature'] == 'd5aec52717f64675a302c1c2322c0348') {
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => null,
                "statut" => "finished",
                'commentaire_signature' => ! empty($data['commentaire_signature']) ? $data['commentaire_signature'] : '',
            );
        }

        return $ret;
    }

    public function cancel_send_for_signature(array $data) {
        // Retour de la méthode
        $ret = array(
            "id_parapheur_signature" => $data['id_parapheur_signature'],
            "om_utilisateur_email" => null,
            "signataire_arrete_email" => null,
            "date_envoi_signature" => null,
            "date_limite_instruction" => null,
            "date_retour_signature" => null,
            "statut" => "canceled",
            "commentaire_signature" => "Annulé par l'émetteur le ".date("d/m/Y")
        );

        return $ret;
    }

    public function get_signed_document(array $data) {
        // Produit une exception
        if ($data['id_parapheur_signature'] === "9f6711b627a44d32993dfc01ee6f53a4") {
            throw new electronicsignature_connector_exception(
                "Produit une exception sur la méthode get_signed_document."
            );
        }

        $ret = array();

        // Deuxième cas de test
        if ($data['id_parapheur_signature'] === "91497e7939d443588eeeef62edeadb17") {
            // Document signé
            $filename = __DIR__."/signed_file.pdf";
            $file_handle = fopen($filename, "r");
            $file_content = fread($file_handle, filesize($filename));
            fclose($file_handle);
            // Retour de la méthode
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => date("c"),
                "statut" => "finished",
                "commentaire_signature" => "Test commentaire document signé.",
                "signed_file" => $file_content,
            );
        }

        // Cas de test pour compteur de signatures
        if (in_array($data['id_parapheur_signature'],
            array('34482553b97248a7924683207b507c2b', 'a7a9c6831c0243ca993ab64dbcb3fe38',
                  'd5aec52717f64675a302c1c2322c0348'))) {
            $filename = __DIR__."/signed_file.pdf";
            $file_handle = fopen($filename, "r");
            $file_content = fread($file_handle, filesize($filename));
            fclose($file_handle);
            $ret = array(
                "id_parapheur_signature" => $data['id_parapheur_signature'],
                "om_utilisateur_email" => null,
                "signataire_arrete_email" => null,
                "date_envoi_signature" => null,
                "date_limite_instruction" => null,
                "date_retour_signature" => date("c"),
                "statut" => "finished",
                "commentaire_signature" => "Test commentaire document signé.",
                "signed_file" => $file_content,
            );
        }

        return $ret;
    }

    public function signer_notification_is_delegated(array $data = []) {
        // le connecteur indique à openADS qu'il lui délègue l'envoi de la notification mail
        return true;
    }
}
