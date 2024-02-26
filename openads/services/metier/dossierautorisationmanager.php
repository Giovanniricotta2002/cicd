<?php
/**
 * Ce fichier permet de déclarer la classe MessagesManager, qui effectue les
 * traitements pour la ressource 'messages'.
 *
 * @package openfoncier
 * @version SVN : $Id: dossierautorisationmanager.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// Inclusion de la classe de base MetierManager
require_once("./metier/metiermanager.php");
require_once("../obj/dossier_autorisation.class.php");

/**
 * Cette classe hérite de la classe MetierManager. Elle permet d'effectuer des
 * traitements pour la ressource 'messages'.
 *
 * @todo XXX Traduire et commenter toutes les méthodes
 */
class DossierAutorisationManager extends MetierManager {

    /**
     * Extraire le contenu d'un dossier d'autorisation depuis de la BD.
     *
     * @param string $id L'identifiant du dossier d'autorisation
     * @return En cas de success on retourne 'OK'. Si les donnees sont
     * erronees, on retourne 'BAD_DATA'. En cas d'echec au niveau de BD,
     * 'KO' est retourne.
     */
    private function generic($id) {
        
        // verifie que l'ID passe existe et a le bon format
        if ($id == null || empty($id)) {
            $this->setMessage(_('L\'identifiant du dossier d\'autorisation '.
                                'manque ou n\'est pas dans le bon format'));
            return $this->BAD_DATA;
        }

        $this->metier_instance = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => $this->f->clean_break($id),
        ));
        $this->metier_instance->setValFFromVal();

        // verifie que on n'a pas eu une bogue de BD
        if (isset($this->metier_instance->errors['db_debuginfo'])
            && !empty($this->metier_instance->errors['db_debuginfo'])) {
            $this->setMessage(_('Probleme pendent la recuperation du dossier '.
                              'd\'autorisation.'));
            return $this->KO;
        }
        
        // verifie que le dossier etait bien trouve
        if (empty($this->metier_instance->valF['dossier_autorisation'])) {
            $this->setMessage(_('Le dossier d\'autorisation '. $id
                                .' n\'etait pas trouve'));
            return $this->BAD_DATA;
        }
        
        return $this->OK;
    }
    
    /**
     * Appelle quand ERP voudrait attribuer un numero du batiment
     * a un dossier d'autorisation.
     *
     * @param mixed $data Le tableau contenant les donnees arrivees par
     * le service web
     * @param string $id L'identifiant du dossier d'autorisation
     * @return bool En cas de success on retourne 'OK'. En cas de
     * mauvaises donnees on retourne 400. En cas de echec pendant la
     * modification du dossier on retourne 'KO'
     */
    public function setERPBuildingNumber($data, $id) {
                
        // verifie que le numero erp existe
        if (empty($data['numero_erp']) || !is_numeric($data['numero_erp'])) {
            $this->setMessage(_('Le numero ERP du batiment n\'existe pas ou '.
                                'est dans le mauvais format'));
            return $this->BAD_DATA;
        }
        
        // recupere le dossier depuis de la base
        $ret = $this->generic($id);
        if ($ret != $this->OK){
            return $ret;
        }
                
        // stocke la valeur de numero ERP dans l'objet
        $this->metier_instance->valF['erp_numero_batiment'] = $data['numero_erp'];
        
        return parent::modifier($this->metier_instance->valF,
                _('Numero ERP du batiment etait assigne au dossier '.
                  'd\'autorisation '. $id),
                _('L\'attribution de la numero ERP du batiment pour le dossier '.
                  'd\'autorisation '.$id.' a echoue'));
    }

    
    /**
     * Appelle quand ERP voudrait notifier qu'un arrete d'ouverture
     * d'un batiment ERP au publique est signe.
     *
     * @param mixed $data Le tableau contenant les donnees arrivees par
     * le service web
     * @param string $id L'identifiant du dossier d'autorisation
     * @return bool En cas de success on retourne 'OK'. En cas de
     * mauvaises donnees on retourne 400. En cas de echec pendant la
     * modification du dossier on retourne 'KO'
     */    
    public function orderERPOpenedIsSigned($data, $id) {
                
        // verifie que la date est correcte
        $date_db = null;
        if (!$this->timestampValide($data['date_arrete'], $date_db)) {
            $this->setMessage('Le date n\'est pas correct.');
            return $this->BAD_DATA;
        }
        
        // verifie que le champ erp_ouvert contient un des valeurs permises
        if (strtolower($data['erp_ouvert']) != 'oui'
            && strtolower($data['erp_ouvert']) != 'non') {
            $this->setMessage('La valeur du erp_ouvert n\'est pas valide');
            return $this->BAD_DATA;            
        }

        // recupere le dossier depuis de la base
        $ret = $this->generic($id);
        if ($ret != $this->OK) {
            return $ret;
        }
        
        // stocke les valeurs d'erp_ouvert et d'erp_date_ouverture
        $this->metier_instance->valF['erp_ouvert'] = $data['erp_ouvert'];
        $this->metier_instance->valF['erp_date_ouverture'] = $data['date_arrete'];
        
        return parent::modifier($this->metier_instance->valF,
                _('Signature de l\'ouverture ERP au publique etait enregistre '.
                  'pour le dossier d\'autorisation '. $id),
                _('Echec dans l\'enregistrement de la signature de l\'ouverture '.
                  'ERP au publique pour le dossier d\'autorisation '.$id.
                  ' a echoue'));
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
     * Appelle quand ERP voudrait notifier qu'un arrete d'ouverture
     * d'un batiment ERP est signe. Ca ne dit pas que le batiment
     * est ouvert encore.
     *
     * @param mixed $data Le tableau contenant les donnees arrivees par
     * le service web
     * @param string $id L'identifiant du dossier d'autorisation
     * @return bool En cas de success on retourne 'OK'. En cas de
     * mauvaises donnees on retourne 400. En cas de echec pendant la
     * modification du dossier on retourne 'KO'
     */     
    public function orderERPDecisionIsSigned($data, $id) {

        
        // verifie que la date est correcte
        $date_db = null;
        if (!$this->timestampValide($data['date_arrete'], $date_db)) {
            $this->setMessage('Le date n\'est pas correct.');
            return $this->BAD_DATA;
        }
        
        // verifie que le champ arrete_effectue contient un des valeurs permises
        if (strtolower($data['arrete_effectue']) != 'oui'
            && strtolower($data['arrete_effectue']) != 'non') {
            $this->setMessage('La valeur du arrete_effectue n\'est pas valide');
            return $this->BAD_DATA;            
        }
        
        // recupere le dossier depuis de la base
        $ret = $this->generic($id);
        if ($ret != $this->OK) {
            return $ret;
        }
        
        // stocke les valeurs d'erp_ouvert et d'erp_date_ouverture
        $this->metier_instance->valF['erp_arrete_decision'] = $data['arrete_effectue'];
        $this->metier_instance->valF['erp_date_arrete_decision'] = $data['date_arrete'];
        
        return parent::modifier($this->metier_instance->valF,
                _('Signature de l\'ouverture ERP etait enregistre '.
                  'pour le dossier d\'autorisation '. $id),
                _('Echec dans l\'enregistrement de la signature de l\'ouverture '.
                  'ERP pour le dossier d\'autorisation '.$id.' a echoue'));
    }

    /**
     * Retourne la representation de dossier d'autorisation
     * comme un tableau.
     *
     * Cette methode est utilisee pour recuperer le contenu
     * d'un dossier d'autorisation apres l'appel de la methode
     * $this->consultDossier
     * @return mixed Le contenu du tableau valF d'une instance
     * de la classe dossier_autorisation
     */         
    public function getDossierArrayRepresentation() {
        return $this->metier_instance->valF;
    }

}

?>
