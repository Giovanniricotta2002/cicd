<?php
/**
 * DBFORM - 'document_numerise_traitement_metadonnees' - Surcharge obj.
 *
 * @package openads
 * @version SVN : $Id$
 */

//
require_once ('../obj/document_numerise_type.class.php');

class document_numerise_traitement_metadonnees extends document_numerise_type {

    /**
     *
     */
    protected $_absolute_class_name = "document_numerise_traitement_metadonnees";

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    public function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 100 - traiter_metadonnees
        // Interface spécifique de traitement des métadonnées
        $this->class_actions[100] = array(
            "identifier" => "traitement_metadonnees",
            "view" => "view_traitement_metadonnees",
            "permission_suffix" => "executer",
        );
    }


    /**
     * VIEW - view_traitement_metadonnees.
     *
     * Permet de traiter les métadonnées 'aff_da' et 'aff_service_consulte' des
     * documents numérisés.
     *
     * @return void
     */
    public function view_traitement_metadonnees() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Traitement et affichage message si formulaire validé
        if ($this->f->get_submitted_post_value('valider_traitement_metadonnee') === 'oui') {

            // On considère que le traitement est toujours valide
            $this->metadata_treatment();
            $this->display_msg();
        }

        // Formulaire de validation
        printf("<form method=\"POST\" action=\"\" name=\"f1\">");
        printf('<div class="formEntete ui-corner-all">');
        // Description
        $desc = _("Cette page permet de mettre à jour certaines métadonnées des pièces numérisées.").'<br/>';
        $desc .= _("Lors de la modification d’un type de pièce, si les champs <b>affichés sur les demandes d’avis</b> et/ou <b>affichés sur les DA</b> sont modifiés, les métadonnées des pièces numérisées précédemment ont besoin d'être mises à jour pour refléter ce changement.").'<br/>';
        $desc .= _("Attention, en fonction de votre paramétrage ce traitement peut être long.").'<br/>';

        $this->f->displayDescription($desc);
        //
        printf('<input type="hidden" name="valider_traitement_metadonnee" id="valider_traitement_metadonnee" value="oui" />');
        //
        printf("</div><div class=\"formControls\">");
        $this->f->layout->display_form_button(array(
            "value" => _("Mettre à jour"),
            "name" => "btn_traiter_metadonnee"
        ));
        printf("</div></form>");
    }


    /**
     * TREATMENT - metadata_treatment description
     *
     * Traitement de mise à jour des métadonnées mrs:consultationPublique et
     * mrs:consultationTiers des documents numérisés.
     *
     * @return mixed Liste des fichiers en erreur ou false si problème dans le
     *               filestorage.
     */
    public function metadata_treatment() {
        //
        $this->begin_treatment(__METHOD__);

        // Récupère tous les types de pièces dont le champ 'synchro_metadonnee'
        // est à 'true'
        $liste_dnt_synchro = $this->get_ids_by_synchro_metadonnee(true);
        //
        if ($liste_dnt_synchro === false) {
            //
            $this->correct = false;
            $this->addToMessage(_("Erreur lors de la récupération des types de pièces.")." "._("Veuillez contacter votre administrateur."));
            //
            return $this->end_treatment(__METHOD__, false);
        }
        //
        if (count($liste_dnt_synchro) === 0) {
            //
            $this->addToMessage(_("Il n'y a aucun type de pièces modifié."));
            //
            return $this->end_treatment(__METHOD__, array());
        }

        // Récupère la liste des pièces à traiter
        $liste_dn_synchro = $this->get_dn_by_dnt_ids($liste_dnt_synchro);
        //
        if ($liste_dn_synchro === false) {
            //
            $this->correct = false;
            $this->addToMessage(_("Erreur lors de la récupération des fichiers.")." "._("Veuillez contacter votre administrateur."));
            //
            return $this->end_treatment(__METHOD__, false);
        }
        //
        if (count($liste_dn_synchro) === 0) {
            // Met à jour le champ 'synchro_metadonnee' des types de pièces
            $this->update_synchro_metadonnee_by_list($liste_dnt_synchro, false);
            //
            $this->addToMessage(_("Il n'y a aucun fichier dont les métadonnées doivent être mises à jour."));
            //
            return $this->end_treatment(__METHOD__, array());
        }

        // Liste des pièces dont les métadonnées n'ont pas pu être mises à jour
        $liste_dn_erreur = array();

        // Pour chaque fichier
        foreach ($liste_dn_synchro as $dn_synchro) {

            // Instance du document numérisé
            $inst_dn = $this->get_inst_document_numerise($dn_synchro);

            // Récupère l'uid du fichier sur le filestorage
            $uid = $inst_dn->getVal('uid');

            // Met à jour ses métadonnées
            $metadata = array();
            $metadata['consultationPublique'] = $inst_dn->getConsultationPublique();
            $metadata['consultationTiers'] = $inst_dn->getConsultationTiers();
            //
            $uid_update = $this->f->storage->storage->update_metadata($uid, $metadata);

            // Si la méthode ne retourne pas l'uid du fichier alors la mise
            // à jour ne s'est pas réalisée
            if ($uid_update !== $uid) {
                //
                $liste_dn_erreur[$dn_synchro] = $inst_dn->get_array_val();
            }
        }

        // Met à jour le champ 'synchro_metadonnee' des types de pièces
        $update_synchro_metadonnee_by_list = $this->update_synchro_metadonnee_by_list($liste_dnt_synchro, false);
        //
        if ($update_synchro_metadonnee_by_list === false) {
            //
            $this->correct = false;
            $this->addToMessage(_("Erreur lors de la mise à jour des types de pièces.")." "._("Veuillez contacter votre administrateur."));
            //
            return $this->end_treatment(__METHOD__, false);
        }

        //

        // Si certaines métadonnées n'ont pas pû être mises à jour
        if (count($liste_dn_erreur) !== 0) {

            // Initialisation du message à affiher
            $display_message = array();
            foreach ($liste_dn_erreur as $key => $value) {
                //
                if(isset($value["dossier"]) === true AND isset($value["nom_fichier"]) === true ) {
                    $display_message[] = sprintf(
                        _("Dossier d'instruction n°%s : le document %s n'a pas pu être mis à jour."),
                        $value['dossier'],
                        $value['nom_fichier']
                    );
                }
            }
            $this->addToMessage(_("Le traitement s'est correctement déroulé, sauf pour les pièces numérisées ci-dessous :"));
            // Liste des fichiers impossible de mettre à jour
            $this->addToMessage(implode('<br/>', $display_message));
        }
        else {
            $this->addToMessage(_("Le traitement s'est correctement déroulé."));
        }

        //
        return $this->end_treatment(__METHOD__, $liste_dn_erreur);
    }


    /**
     * Met à jour le champ 'synchro_metadonnée' des types passés en paramètre.
     *
     * @param array   $ids   Liste des identifiants de type de pièce.
     * @param boolean $value Valeur de mise à jour.
     *
     * @return boolean
     */
    public function update_synchro_metadonnee_by_list(array $ids, $value) {

        //
        if (isset($ids) === false || is_array($ids) === false || count($ids) === 0) {
            //
            return false;
        }

        //
        if ($value !== true && $value !== false) {
            //
            return false;
        }

        // Valeurs à mettre à jour
        $valF = array();
        $valF['synchro_metadonnee'] = $value;

        // Requête
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.$this->table,
            $valF,
            DB_AUTOQUERY_UPDATE,
            $this->clePrimaire ." IN (".implode(", ", $ids).")");
        // Log
        $this->f->addToLog(__METHOD__."() : db->autoExecute(".$res.")", VERBOSE_MODE);
        // Gestion erreur
        if ($this->f->isDatabaseError($res, true)) {
            //
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            return false;
        }

        //
        return true;
    }

    /**
     * Surcharge du fil d'ariane en contexte formulaire.
     *
     * @param string $ent Chaîne initiale
     *
     * @return chaîne de sortie
     */
    function getFormTitle($ent) {
        //
        $ent = _("parametrage")." -> "._("Gestion des pièces")." -> "._("traitement_metadonnees");
        //
        return $ent;
    }

}


