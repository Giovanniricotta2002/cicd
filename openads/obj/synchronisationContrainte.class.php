<?php
/**
 * Ce script permet de définir la classe 'SynchronisationContrainte'.
 *
 * @package openads
 * @version SVN : $Id: synchronisationContrainte.class.php 6066 2016-03-01 11:11:26Z nhaye $
 */

require_once "../obj/geoads.class.php";

/**
 * Cette classe permet la synchronisation des contraintes 
 * du SIG et de l'application
 */
class SynchronisationContrainte {

    /**
     * Instance de la classe Utils
     * @var object
     */
    var $f = null;
    /**
     * Définition des cas d'utilisation
     * cas 1 : utilisateur mono / synchro mono
     * cas 2 : utilisateur mono / synchro multi
     * cas 3 : utilisateur multi / synchro mono
     * cas 4 : utilisateur multi / synchro multi
     * @var String
     */
    var $usecase;
    /**
     * Liste des contraintes récupérées du SIG
     * @var array
     */
    var $listContraintesSIG = array();
    /**
     * Liste des contraintes de la base de données
     * @var array
     */
    var $listContraintesBDD = array();
    /**
     * Liste des contraintes "à archiver"
     * @var array
     */
    var $listContraintesArchive = array();
    /**
     * Liste des contraintes "à ajouter"
     * @var array
     */
    var $listContraintesAdd = array();
    /**
     * Liste des contraintes "à modifier"
     * @var array
     */
    var $listContraintesEdit = array();
    /**
     * Liste des contraintes récupérées du SIG (seulement l'identifiant)
     * @var array
     */
    var $listContraintesSIGIdContrainte = array();
    /**
     * Code HTTP de la réponse SOAP
     * @var string
     */
    var $responseHTTP = null;
    /**
     * Message d'erreur de la réponse SOAP
     * @var string
     */
    var $errorMessage = null;
    /**
     * Message à afficher à la fin du traitement
     * @var array
     */
    var $outputMessage = array();

    /**
     * Constructeur
     * @param object $f Instance de la classe Utils
     */
    public function __construct($f) {
        // Initialise $this->f
        $this->f = $f;
        // Permet lors de l'instantiation d'objets métiers d'avoir accès à f
        $GLOBALS['f'] = $this->f;

        // Vérifie qu'il y ait un paramétrage du SIG
        if(isset($this->f->collectivite["sig"]) !== true) {
            //
            $this->correct = false;
            // Si pas défini on retourn une erreur
            $this->f->displayMessage('error', _("Erreur de paramétrage.")." "._("Veuillez contacter votre administrateur."));
            return false;
        }

        // Vérification du paramètre obligatoire du mode de traitement des contraintes
        if($this->f->collectivite["sig"]["sig_treatment_mod"] != "mono"
            && $this->f->collectivite["sig"]["sig_treatment_mod"] != "multi") {
            //
            $this->correct = false;
            // Si pas défini on retourn une erreur
            $this->f->displayMessage('error', _("Erreur de paramétrage.")." "._("Veuillez contacter votre administrateur."));
            return false;
        }

         // Récupération de l'id de la collectivité de l'utilisateur
        $user_idx_collectivite = $_SESSION['collectivite'];
        // Récupération de l'id de la collectivité multi
        $idx_multi = $this->f->get_idx_collectivite_multi();
        // Définition des cas d'utilisation
        // cas 1 : utilisateur mono / synchro mono -> user_mono_sync_mono
        // cas 2 : utilisateur mono / synchro multi -> user_mono_sync_multi
        // cas 3 : utilisateur multi / synchro mono -> user_multi_sync_mono
        // cas 4 : utilisateur multi / synchro multi -> user_multi_sync_multi
        if($user_idx_collectivite != $idx_multi) {
            $this->usecase = "user_mono";
        } else {
            $this->usecase = "user_multi";
        }
        $this->usecase .= "_sync_".$this->f->collectivite["sig"]["sig_treatment_mod"];

        // Si le formulaire est validé
        if ($this->f->get_submitted_post_value('valider') !== null) {
            // On lance le traitement de synchro
            $this->constraint_sync_treatment();
            $this->display_output_message();
        }

    }

    /**
     * Destructeur
     */
    public function __destruct() {
        // Détruit l'instance de la classe Utils
        // unset($this->f);
        // // Détruis l'accès à la classe Utils
        // unset($GLOBALS['f']);
    }

    public function view_form_sync() {

        // Vérification du cas impossible : Administrateur mono / synchro multi
        if($this->usecase === "user_mono_sync_multi") {
            $this->f->displayMessage('error', _("Vous n'avez pas les droits nécessaires pour effectuer cette action."));
            return false;
        }

        // Ouverture du formulaire
        printf("<form method=\"POST\" action=\"\" name=f2>");

        printf('<input type="hidden" name="valider" id="valider" value="1" />');

        // Bouton "Synchroniser"
        printf("<div class=\"formControls\">");
            printf("<input id=\"button-contrainte-synchronisation-synchroniser\" type=\"submit\" "
                ."class=\"om-button ui-button ui-widget ui-state-default ui-corner-all\" value=\""
                ._("synchroniser").
                "\" role=\"button\" aria-disabled=\"false\">");
        printf("</div>");

        // Fermeture du formulaire
        printf("</form>");
    }

    public function constraint_sync_treatment() {

        $correct = true;

        switch ($this->usecase) {

            case 'user_multi_sync_multi':
            case 'user_mono_sync_mono':

                $collectivite = $this->f->getCollectivite($_SESSION['collectivite']);
                $this->collectivite_constraint_sync($collectivite);
                break;

            case 'user_multi_sync_mono':
                $qres = $this->f->get_all_results_from_db_query(
                    sprintf(
                        "SELECT
                            om_collectivite
                        FROM
                            %som_collectivite
                        WHERE
                            niveau = '1'
                        ORDER BY
                            libelle",
                        DB_PREFIXE
                    ),
                    array(
                        "origin" => __METHOD__,
                    )
                );
                foreach ($qres['result'] as $row) {
                    $collectivite = $this->f->getCollectivite($row['om_collectivite']);
                    if(isset($collectivite['sig'])) {
                        if($this->collectivite_constraint_sync($collectivite) === false){
                            $correct = false;
                        }
                    }
                }
                break;
            default:
                $correct = false;
                break;
        }
        return $correct;
    }

    private function collectivite_constraint_sync($collectivite) {

        $message = "";
        $correct = true;
        // Instance geoads
        $extra_params = array(
            "inst_framework" => $this->f,
        );
        // Intérogation du web service du SIG
        try {
            $geoads = new geoads($collectivite, $extra_params);
            $this->listContraintesSIG = $geoads->recup_toutes_contraintes($collectivite['insee']);
        }
        catch(Exception $e) {
            $correct = false;
            $message .= 'Caught exception: '.$e->getMessage()."<br />";
        }
       
        //
        // Met à jour toutes les listes des contraintes
        $this->setAllListContraintes($collectivite["om_collectivite_idx"]);
        // Initilisation des variables


        // Nombre de contrainte "à ajouter"
        $nb_contrainte_add = count(
            $this->getListContraintesAdd());
        // S'il y a des contraintes "à ajouter"
        if ($nb_contrainte_add > 0) {
            // Ajoute les contraintes "à ajouter"
            $ajouter = $this->addContraintes($collectivite["om_collectivite_idx"]);
            // Si une erreur s'est produite
            if ($ajouter == false) {
                //
                $correct = false;
                $message .= _("une erreur s'est produite lors de l'ajout des nouvelles contraintes.")." "._("Contactez votre administrateur")."<br />";
            }
            // S'il n'y a pas d'erreur
            if ($ajouter == true) {
                //
                $message .= "<span class='bold'>".$nb_contrainte_add."</span>"." "
                    ._("contrainte(s) ajoutee(s).")."<br />";
            }
        } else {
            //
            $message .= _("Aucune contraintes a ajouter.")."<br />";
        }

        // Nombre de contraintes "à modifier"
        $nb_contrainte_edit = count(
            $this->getListContraintesEdit());
        // S'il y a des contraintes "à modifier"
        if ($nb_contrainte_edit > 0) {
            // Modifie les contraintes "à modifier"
            $modifier = $this->editContraintes($collectivite["om_collectivite_idx"]);
            // Si une erreur s'est produite
            if ($modifier == false) {
                //
                $correct = false;
                $message .= _("une erreur s'est produite lors de la modification des contraintes.")." "._("Contactez votre administrateur")."<br />";
            }
            // S'il n'y a pas d'erreur
            if ($modifier == true) {
                //
                $message .= "<span class='bold'>".$nb_contrainte_edit."</span>"." "
                    ._("contrainte(s) modifiee(s).")."<br />";
            }
        } else {
            //
            $message .= _("Aucune contraintes a modifier.")."<br />";
        }

        // Nombre de contraintes "à archiver"
        $nb_contrainte_archive = count(
            $this->getListContraintesArchive());
        // S'il y a des contraintes "à archiver"
        if ($nb_contrainte_archive > 0) {
            // Archive les contraintes "à archiver"
            $archiver = $this->archiveContraintes($collectivite["om_collectivite_idx"]);
            // Si une erreur s'est produite
            if ($archiver == false) {
                //
                $correct = false;
                $message .= _("une erreur s'est produite lors de l'archivage des contraintes.")
                    ." "._("Contactez votre administrateur")."<br />";
            }
            // S'il n'y a pas d'erreur
            if ($archiver == true) {
                //
                $message .= "<span class='bold'>".$nb_contrainte_archive."</span>"." "
                    ._("contrainte(s) archivee(s).")."<br />";
            }
        } else {
            //
            $message .= _("Aucune contraintes a archiver.")."<br />";
        }

        $type = 'valid';
        if ($correct == false) {
            //
            $type = 'error';
        }

        if(isset($collectivite['ville']) !== false){
            $this->add_output_message($type, $message, $collectivite['ville']);
        } else {
            $this->add_output_message($type, $message);
        }
        
        // S'il y a une erreur
        if ($correct == false) {
            //
            $this->f->addToLog("synchronisationContraintes(): ".$message, DEBUG_MODE);
        }
        return $correct;
    }

    /**
     * Remplit toutes les listes de contrainte
     */
    public function setAllListContraintes($collectivite_idx) {
        //
        $this->setListContraintesBDD($collectivite_idx);
        //
        $this->setListContraintesAdd();
        //
        $this->setListContraintesEdit();
        //
        $this->setListContraintesSIGIdContrainte();
        //
        $this->setListContraintesArchive();
    }

    /**
     * Retourne la list des contraintes récupérées du SIG
     * @return array Liste des contraintes
     */
    public function getListContraintesSIG() {
        //
        return $this->listContraintesSIG;
    }

    /**
     * Remplit la valeur de la réponse HTTP
     * @param string $responseHTTP Réponse HTTP de la classe MessageSenderSOAP
     */
    private function setResponseHTTP($responseHTTP) {
        //
        $this->responseHTTP = $responseHTTP;
    }

    /**
     * Retourne le code réponse HTTP
     * @return string Code réponse HTTP
     */
    public function getResponseHTTP() {
        //
        return $this->responseHTTP;
    }

    /**
     * Remplit la valeur du message d'erreur
     * @param string $errorMessage Message d'erreur renvoyé par la classe MessageSenderSOAP
     */
    public function setErrorMessage($errorMessage){
        $this->errorMessage = $errorMessage;
    }

    /**
     * Retourne le message d'erreur
     * @return string Message d'erreur
     */
    public function getErrorMessage(){
        return $this->errorMessage;
    }

    /**
     * Remplit la liste des contraintes récupérées de la base de données.
     *
     * @param integer $collectivite_idx identifiant de la collectivité
     */
    public function setListContraintesBDD($collectivite_idx) {

        // Initialisation résultat
        $resultArray = array();

        // Requête SQL
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                "SELECT
                    numero
                FROM
                    %scontrainte
                WHERE
                    reference = 't'
                    AND (om_validite_fin IS NULL 
                        OR om_validite_fin > CURRENT_DATE)
                    AND om_collectivite = %d",
                DB_PREFIXE,
                intVal($collectivite_idx)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        // Tableau des résultats
        foreach ($qres['result'] as $row) {
            $resultArray[] = $row['numero'];
        }

        //
        $this->listContraintesBDD = $resultArray;
    }

    /**
     * Retourne la liste des contraintes récupérées de la base données
     * @return array 
     */
    public function getListContraintesBDD() {
        //
        return $this->listContraintesBDD;
    }

    /**
     * Remplit la liste des contraintes récupérées du SIG 
     * (seulement les identifiants)
     */
    public function setListContraintesSIGIdContrainte() {
        $this->listContraintesSIGIdContrainte = array();
        // Pour chaque contraintes récupérées
        foreach ($this->getListContraintesSIG() as $key => $contrainte) {
            // Met l'identifiant de la contrainte dans la liste
            $this->listContraintesSIGIdContrainte[] = $contrainte['contrainte'];
        }
    }

    /**
     * Retourne la liste des contraintes récupérées du SIG 
     * (seulement les identifiants)
     * @return array 
     */
    public function getListContraintesSIGIdContrainte() {
        //
        return $this->listContraintesSIGIdContrainte;
    }

    /**
     * Remplit la liste des contraintes "à ajouter"
     */
    public function setListContraintesAdd() {
        $this->listContraintesAdd = array();
        // Pour chaque contraintes récupérées
        foreach ($this->listContraintesSIG as $key => $contrainte) {
            // Si la contrainte possède un identifiant et qu'elle n'est pas dans
            // la liste des contraintes de la base de données
            if ($contrainte['contrainte'] !== ''
                && $contrainte['contrainte'] !== null
                && in_array($contrainte['contrainte'], $this->listContraintesBDD) === false) {
                // Met la contrainte dans la liste des "à ajouter"
                $this->listContraintesAdd[] = $contrainte;
            }
        }
    }

    /**
     * Retourne la liste des contraintes "à ajouter"
     * @return array
     */
    public function getListContraintesAdd() {
        //
        return $this->listContraintesAdd;
    }

    /**
     * Ajoute les contraintes de la liste listContraintesAdd
     * @return boolean
     */
    public function addContraintes($collectivite_idx) {
        //
        $return = true;
        // Pour chaque contrainte "à ajouter"
        foreach ($this->listContraintesAdd as $key => $contrainte) {
            // Instancie la classe contrainte
            $contrainteAdd = $this->f->get_inst__om_dbform(array(
                "obj" => "contrainte",
                "idx" => "]",
            ));
            
            // Il est possible que le champ texte ne soit pas présent dans le
            // retour du connecteur SIG
            if (array_key_exists("texte", $contrainte) === false) {
                $contrainte['texte'] = null;
            }

            // Définit les valeurs
            $val = array(
                'contrainte' => ']',
                'numero' => $contrainte['contrainte'],
                'nature' => 'PLU',
                'groupe' => $contrainte['groupe_contrainte'],
                'sousgroupe' => (isset($contrainte['sous_groupe_contrainte']))?$contrainte['sous_groupe_contrainte']:"",
                'libelle' => $contrainte['libelle'],
                'reference' => true,
                'texte' => $contrainte['texte'],
                'no_ordre' => null,
                'service_consulte' => false,
                'om_collectivite' => $collectivite_idx,
                'om_validite_debut' => null,
                'om_validite_fin' => null,
            );
            // Ajout de la contrainte
            $ajouter = $contrainteAdd->ajouter($val);
            // Si la contrainte n'a pas été ajoutée
            if ($ajouter == false) {
                //
                $return = false;
            }
        }

        //
        return $return;
    }

    /**
     * Remplit la liste des contraintes "à modifier"
     */
    public function setListContraintesEdit() {
        $this->listContraintesEdit = array();
        // Pour chaque contraintes récupérées
        foreach ($this->listContraintesSIG as $key => $contrainte) {
            // Si la contrainte est dans la liste des contraintes de 
            // la base de données
            if (in_array($contrainte['contrainte'], $this->listContraintesBDD)) {
                // Met la contrainte dans la liste des "à modifier"
                $this->listContraintesEdit[] = $contrainte;
            }
        }
    }

    /**
     * Retourne la liste des contraintes "à modifier"
     * @return array
     */
    public function getListContraintesEdit() {
        //
        return $this->listContraintesEdit;
    }

    /**
     * Modifie les contraintes la liste listContraintesEdit
     * @return boolean
     */
    public function editContraintes($collectivite_idx) {
        //
        $return = true;
        // Si la liste des contraintes "à modifier" n'est pas vide
        if (!empty($this->listContraintesEdit)) {
            // Pour chaque contrainte "à modifier"
            foreach ($this->listContraintesEdit as $key => $contrainte) {
                // Récupère l'identifiant de la contrainte de l'application
                $contrainte['contrainte_bdd'] = $this->getContrainte($contrainte['contrainte'], $collectivite_idx);
                // Instancie la classe contrainte
                $contrainteEdit = $this->f->get_inst__om_dbform(array(
                    "obj" => "contrainte",
                    "idx" => $contrainte['contrainte_bdd'],
                ));
                // Déclare le tableau des valeurs
                $val = array();
                foreach ($contrainteEdit->champs as $key => $champ) {
                    $val[$champ] = $contrainteEdit->val[$key];
                }
                // Si le champ "texte" existe dans le retour du SIG
                if (array_key_exists("texte", $contrainte) === true) {
                    $val['texte'] = $contrainte['texte'];
                }

                // Modifie les valeurs qui peuvent avoir subit une modification
                $val['groupe'] = $contrainte['groupe_contrainte'];
                $val['sousgroupe'] = (isset($contrainte['sous_groupe_contrainte']))?$contrainte['sous_groupe_contrainte']:"";
                $val['libelle'] = $contrainte['libelle'];
                // Modifie la contrainte
                $modifier = $contrainteEdit->modifier($val);
                // Si la contrainte à été modifiée
                if ($modifier == false) {
                    //
                    $return = false;
                }
            }
        }
        //
        return $return;
    }

    /**
     * Remplit la liste des contraintes "à archiver"
     */
    public function setListContraintesArchive() {
        $this->listContraintesArchive = array();
        // Pour chaque contraintes de la base de données
        foreach ($this->getListContraintesBDD() as $key => $contrainte) {
            // Si la contrainte n'est pas dans la liste des contraintes récupérées
            if (!in_array($contrainte, $this->getListContraintesSIGIdContrainte())) {
                // Met la contrainte dans la liste des "à archiver"
                $this->listContraintesArchive[] = $contrainte;
            }
        }
    }

    /**
     * Retourne la liste des contraintes "à archiver"
     * @return array 
     */
    public function getListContraintesArchive() {
        //
        return $this->listContraintesArchive;
    }

    /**
     * Archive les contraintes de la liste listContraintesArchive
     * @return boolean 
     */
    public function archiveContraintes($collectivite_idx) {
        //
        $return = true;
        // Pour chaque contrainte "à archiver"
        foreach ($this->getListContraintesArchive() as $key => $contrainte) {
            // Récupère l'identifiant de la contrainte de l'application
            $contrainteId = $this->getContrainte($contrainte, $collectivite_idx);
            // Instancie la classe contrainte
            $contrainteArchive = $this->f->get_inst__om_dbform(array(
                "obj" => "contrainte",
                "idx" => $contrainteId,
            ));
            // Déclare le tableau des valeurs
            $val = array();
            // Récupération des valeurs
            foreach($contrainteArchive->champs as $id => $champ) {
                $val[$champ] = $contrainteArchive->val[$id];
            }
            // Met la date de fin de validité au jour pour archiver 
            $val['om_validite_fin'] = date('d/m/Y');
            // Modifie la contrainte
            $archiver = $contrainteArchive->modifier($val);
            // Si la contrainte n'a pas été modifiée
            if ($archiver == false) {
                //
                $return = false;
            }
        }
        //
        return $return;
    }

    /**
     * Récupère l'identifiant d'une contrainte active (non archivée) par son
     * couple numéro et collectivité.
     * 
     * @param   integer  $numero            numéro (unique côté SIG)
     * @param   integer  $collectivite_idx  clé primaire collectivité
     * @return  integer                     clé primaire contrainte
     */
    private function getContrainte($numero, $collectivite_idx) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    contrainte
                FROM
                    %1$scontrainte
                WHERE
                    numero = \'%2$s\'
                    AND om_collectivite = %3$d
                    AND (
                        om_validite_fin > now()
                        OR om_validite_fin IS NULL
                    )
                ORDER BY
                    contrainte ASC',
                DB_PREFIXE,
                $this->f->db->escapeSimple($numero),
                intval($collectivite_idx)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

    /**
     * Méthode permettant d'ajouter à la pile des messages le resultat de la
     * synchronisation des contraintes pour chaque commune.
     *
     * @param string $type    valid/error
     * @param string $message Message
     * @param string $commune Nom de la commune à afficher.
     */
    private function add_output_message($type, $message, $commune = null) {
        $tab_message = array("type" => $type, "message" => $message);
        if($commune != null) {
            $tab_message["commune"] = $commune;
        }

        $this->outputMessage[] = $tab_message;
    }

    /**
     * Affiche les message de sortie de la synchronisation.
     *
     * @return [type] [description]
     */
    private function display_output_message() {
        
        foreach ($this->outputMessage as $key => $tab_message) {
            $message = "";
            if(isset($tab_message["commune"]) === true and $tab_message["commune"] != "") {
                $message .= "<span class='bold'>".$tab_message["commune"]."</span><br />";
            }
            $message .= $tab_message['message'];
            $this->f->displayMessage($tab_message["type"], $message);

        }
    }

    /**
     * Accesseur de la pile de message de sortie du traitement.
     *
     * @return array Liste des messages et leurs status
     */
    public function get_output_message() {
        return $this->outputMessage;
    }

}


