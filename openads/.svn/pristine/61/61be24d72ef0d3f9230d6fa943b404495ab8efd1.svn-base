<?php
//$Id$ 
//gen openMairie le 21/02/2022 17:35

require_once "../gen/obj/instruction_notification_document.class.php";

class instruction_notification_document extends instruction_notification_document_gen {

    /**
     * Redirige vers la vue permettant de télécharger le document
     * selon le type de document a télécharger.
     *
     * Pour cela, cette méthode utilise la clé fournie dans l'url d'accès au document
     * pour récupérer l'instance de l'élément auquel est rattaché le document.
     * Si pour cette instance, il existe une méthode permettant d'accèder
     * à la vue de téléchargement du document, cette méthode est appelée.
     * Sinon renvoie une erreur 404.
     */
    public function view_telecharger_document_anonym($paramNotif) {
        $cle_acces_document = $this->f->get_submitted_get_value('key');
        $instanceDoc = $this->get_inst_document_type_by_key($cle_acces_document);
        // Fait appel a la vue de prévisualisation des documents de l'instance
        if (method_exists($instanceDoc, 'view_telecharger_document_anonym')) {
            $instanceDoc->view_telecharger_document_anonym();
            return;
        }
        // Page vide 404
        printf('Ressource non trouvée.');
        header('HTTP/1.0 404 Not Found');
    }

    /**
     * A partir de la clé passé en paramètre effectue une requête sql
     * pour récupérer le nom de la table a laquel est rattaché le document
     * notifié et l'identifiant de l'élément auquel il appartient.
     *
     * Instancie l'objet voulu à partir de ces informations et renvoie
     * cette instance.
     *
     * @param string clé unique d'accès à la pièce
     * @return objet instance de l'objet auquel est rattaché le document
     */
    protected function get_inst_document_type_by_key($key) {
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    instruction_notification_document.document_type as table,
                    instruction_notification_document.document_id as idx
                FROM
                    %1$sinstruction_notification_document
                WHERE
                    instruction_notification_document.cle = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($key)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if (is_array($qres["result"]) === true
            && array_key_exists(0, $qres["result"]) === true) {
            //
            return $this->f->get_inst__om_dbform(array(
                "obj" => $qres["result"][0]["table"],
                "idx" => $qres["result"][0]["idx"],
            ));
        }
        return null;
    }
}
