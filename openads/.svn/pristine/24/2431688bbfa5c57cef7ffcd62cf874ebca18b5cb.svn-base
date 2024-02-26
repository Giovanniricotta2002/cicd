<?php
/**
 * Ce fichier permet de déclarer la classe DossierInstructionManager, qui 
 * effectue les traitements pour la ressource 'dossier_instruction'.
 *
 * @package openfoncier
 * @version SVN : $Id: dossierinstructionmanager.php 5212 2015-09-24 13:47:11Z nhaye $
 */

// Inclusion de la classe de base MetierManager
require_once("./metier/metiermanager.php");
require_once("../obj/dossier.class.php");
require_once("../obj/instruction.class.php");

/**
 * Cette classe hérite de la classe MetierManager. Elle permet d'effectuer des
 * traitements pour la ressource 'dossier_instruction'.
 *
 */
class DossierInstructionManager extends MetierManager {

    /**
     * Extraire le contenu d'un dossier d'instruction.
     *
     * @param string $id L'identifiant du dossier d'instruction.
     *
     * @return En cas de succès on retourne 'OK'. Si les données en entrée
     * sont erronées, on retourne 'BAD_DATA'. En cas d'échec au niveau de la
     * base de données 'KO' est retourné.
     */
    private function generic($id) {
        
        // verifie que l'ID passe existe et a le bon format
        if ($id == null || empty($id)) {
            $this->setMessage(_('L\'identifiant du dossier d\'instruction '.
                                'manque ou n\'est pas dans le bon format'));
            return $this->BAD_DATA;
        }

        $this->metier_instance = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $this->f->clean_break($id),
        ));
        $this->metier_instance->setValFFromVal();

        // verifie que on n'a pas eu une bogue de BD
        if (isset($this->metier_instance->errors['db_debuginfo'])
            && !empty($this->metier_instance->errors['db_debuginfo'])) {
            $this->setMessage(_('Probleme pendent la recuperation du dossier '.
                              'd\'instruction.'));
            return $this->KO;
        }
        
        // verifie que le dossier etait bien trouve
        if (empty($this->metier_instance->valF['dossier'])) {
            $this->setMessage(_('Le dossier d\'instruction '. $id
                                .' n\'etait pas trouve'));
            return $this->BAD_DATA;
        }
        
        return $this->OK;
    }

    /**
     * Mise à jour d'un dossier d'instruction de type AT
     *
     * @param mixed $data Le tableau contenant les donnees arrivees par
     * le service web
     * @param string $id L'identifiant du dossier d'instruction
     * @return string $header l'header à retourner
     */
    public function updateDossierInstructionAT($data, $id) {

        $id = $this->f->clean_break($id);
        //{{{Vérification des données fournies
        //Récupération de données liées au dossier d'instruction passé en paramètre
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier.dossier,
                    etat.etat,
                    etat.statut
                FROM
                    %1$sdossier
                    LEFT JOIN %1$setat
                        ON dossier.etat = etat.etat
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($id)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { // PP
            die($res->getMessage());
        }
        
        //Vérifie que le dossier d'instruction existe
        if ($qres['row_count'] == 0) {
            $this->setMessage(_("Ce dossier n'existe pas"));
            return $this->BAD_DATA;
        }
        
        //Vérifie que le dossier est bien de type AT
        $qres_tmp = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                FROM
                    %1$sdossier_autorisation_type_detaille
                    LEFT JOIN %1$sdossier_instruction_type
                        ON dossier_instruction_type.dossier_autorisation_type_detaille =
                            dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    LEFT JOIN %1$sdossier
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type  
                WHERE
                    dossier.dossier = \'%2$s\'
                    AND dossier_autorisation_type_detaille.code = \'AT\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($id)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres_tmp['code'] !== 'OK') { // PP
            die($qres_tmp['message']);
            return $this->BAD_DATA;
        }

        if ($qres_tmp['row_count'] == 0 ){
            $this->setMessage(_("Ce dossier n'est pas un dossier de type AT"));
            return $this->BAD_DATA;
        }
        
        //Vérifie qu'un message a été fourni
        if (!isset($data["message"]) || is_null($data["message"]) ||
            $data["message"] == '' ){
            $this->setMessage(_("Aucun message fourni"));
            return $this->BAD_DATA;
        }
        
        //Vérifie que le message fourni est correct
        if ( $data["message"] !== "complet" && $data["message"] !== "clos" ){
            $this->setMessage(_("Message fourni incorrect"));
            return $this->BAD_DATA;
        }
        
        //Vérifie qu'une date a été fournie
        if ( !isset($data["date"]) || is_null($data["date"] || 
            $data["date"] == '' ) ){
            $this->setMessage(_("Aucune date fournie"));
            return $this->BAD_DATA;
        }
        
        //Vérifie le format de la date
        if ( !preg_match( '`^\d{1,2}/\d{1,2}/\d{4}$`' , $data["date"]) ){
            $this->setMessage(_("Date fournie au mauvais format"));
            return $this->BAD_DATA;
        }
        
        $row = array_shift($qres['result']);
        //}}}
        
        //Mise à jour du dossier d'instruction
        $ret = $this->updateDossierAT($id, $data["message"], $data["date"]);
        
        //Si la mise à jour du dossier d'instruction s'est bien passée
        if ($ret === true) {
            $this->setMessage(_("Mise a jour des donnees realisees avec succes"));
            return $this->OK;
        } else {
            $this->setMessage(_("Une erreur s'est produite"));
            return $this->KO;
        }
    }

    /**
     * Mise à jour d'un dossier d'instruction de type AT
     *
     * @param string $id L'identifiant du dossier d'instruction
     * @return boolean Si la mise à jour s'est correctement effectuée
     */
    private function updateDossierAT($id, $message, $date){
            
        $ret = false;

        //L'identifiant de l'événement à rajouter au dossier d'instruction
        $evenement = ( $message == "clos" ) ? 
            $this->f->getParameter("id_evenement_cloture_at")  : 
            $this->f->getParameter("id_evenement_completude_at");
            
        //Données                        
        //Récupération de la lettre type de l'événement
        $lettretype = $this->f->getLettreType($evenement);

        $value['instruction']=NULL;

        $value['destinataire']=$id;
        $value['dossier']=$id;

        $value['date_evenement']=$date;
        $value['evenement']=$evenement;
        $value['lettretype']=$lettretype;
        $value['complement_om_html']="";
        $value['complement2_om_html']="";

        //Ces données seront mises à jour dans l'instruction
        $value['action']="initialisation";
        $value['delai']="2";
        $value['etat']="notifier";
        $value['accord_tacite']="Oui";
        $value['delai_notification']="1";
        $value['archive_delai']="0";

        $value['archive_date_complet']=NULL;
        $value['archive_date_dernier_depot']=NULL;
        $value['archive_date_rejet']=NULL;
        $value['archive_date_limite']=NULL;
        $value['archive_date_notification_delai']=NULL;
        $value['archive_accord_tacite']="Non";
        $value['archive_etat']="initialiser";
        $value['archive_date_decision']=NULL;
        $value['archive_avis']="";
        $value['archive_date_validite']=NULL;
        $value['archive_date_achevement']=NULL;
        $value['archive_date_chantier']=NULL;
        $value['archive_date_conformite']=NULL;
        $value['archive_incompletude']=NULL;
        $value['archive_incomplet_notifie']=NULL;
        $value['archive_evenement_suivant_tacite']="";
        $value['archive_evenement_suivant_tacite_incompletude']=NULL;
        $value['archive_etat_pendant_incompletude']=NULL;
        $value['archive_date_limite_incompletude']=NULL;
        $value['archive_delai_incompletude']=NULL;
        $value['archive_autorite_competente']=NULL;
        $value['complement3_om_html']="";
        $value['complement4_om_html']="";
        $value['complement5_om_html']="";
        $value['complement6_om_html']="";
        $value['complement7_om_html']="";
        $value['complement8_om_html']="";
        $value['complement9_om_html']="";
        $value['complement10_om_html']="";
        $value['complement11_om_html']="";
        $value['complement12_om_html']="";
        $value['complement13_om_html']="";
        $value['complement14_om_html']="";
        $value['complement15_om_html']="";
        $value['avis_decision']=NULL;
        $value['date_finalisation_courrier']=NULL;
        $value['date_envoi_signature']=NULL;
        $value['date_retour_signature']=NULL;
        $value['date_envoi_rar']=NULL;
        $value['date_retour_rar']=NULL;
        $value['date_envoi_controle_legalite']=NULL;
        $value['date_retour_controle_legalite']=NULL;
        $value['signataire_arrete']=NULL;
        $value['numero_arrete']=NULL;
        $value['code_barres']=NULL;
        $value['om_fichier_instruction']=NULL;
        $value['om_final_instruction']=NULL;
        $value['om_final_instruction_utilisateur']=NULL;
        $value['om_fichier_instruction_dossier_final']=NULL;
        $value['document_numerise']=NULL;
        $value['autorite_competente']=NULL;
        $value['duree_validite_parametrage']="0";
        $value['duree_validite']="0";
        $value['created_by_commune']=NULL;
        $value['date_depot']=NULL;
        $value['archive_date_cloture_instruction'] = null;
        $value['archive_date_premiere_visite'] = null;
        $value['archive_date_derniere_visite'] = null;
        $value['archive_date_contradictoire'] = null;
        $value['archive_date_retour_contradictoire'] = null;
        $value['archive_date_ait'] = null;
        $value['archive_date_transmission_parquet'] = null;
        $value['flag_edition_integrale'] = null;
        $value['titre_om_htmletat'] = null;
        $value['corps_om_htmletatex'] = null;
        $value['archive_dossier_instruction_type'] = null;
        $value['archive_date_affichage'] = null;
        $value['date_depot_mairie'] = null;
        $value['pec_metier'] = null;
        $value['archive_pec_metier'] = null;
        $value['archive_a_qualifier'] = null;
        $value['id_parapheur_signature'] = null;
        $value['statut_signature'] = null;
        $value['commentaire_signature'] = null;
        $value['historique_signature'] = null;
        $value['commentaire'] = null;
        $value['etat_transmission_platau'] = "non_transmissible";
        $value['envoye_cl_platau'] = null;
        $value['parapheur_lien_page_signature'] = NULL;

        //Création de l'instruction
        $instruction = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction",
            "idx" => "]",
        ));
        $instruction->valF = array();
        $ret = $instruction->ajouter($value);

        return $ret;
    }

    /**
     * Called when the ERP services would like to obtain information
     * on a dossier.
     *
     * @todo Pour l'instant on envoi seulement le contenu de la table
     * dossier_autorisation, et apres on doit ajouter les evenements,
     * les contraintes, ...
     *
     * @param string $id The ID of the dossier.
     * @return bool 'OK'
     */        
    public function consultDossier($id) {

        // recupere le dossier depuis de la base
        $ret = $this->generic($id);
        if ($ret != $this->OK) {
            return $ret;
        }
        
        // les donnees du dossier sont recuperation avec success
        return $this->OK;
    }

    /**
     * Retourne la representation de dossier d'instruction
     * comme un tableau.
     *
     * Cette methode est utilisee pour recuperer le contenu
     * d'un dossier d'instruction apres l'appel de la methode
     * $this->consultDossier
     *
     * @return mixed Le contenu du tableau valF d'une instance
     * de la classe dossier_autorisation
     */         
    public function getDossierArrayRepresentation() {
        return $this->metier_instance->get_datas();
    }

}

?>
