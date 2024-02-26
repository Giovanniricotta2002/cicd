<?php
/**
 * Ce fichier permet de déclarer la classe MaintenanceManager, qui effectue les
 * traitements pour la ressource 'maintenance'.
 *
 * @package openfoncier
 * @version SVN : $Id: maintenancemanager.php 6129 2016-03-08 15:51:07Z stimezouaght $
 */

// Inclusion de la classe de base MetierManager
require_once("./metier/metiermanager.php");

/**
 * Cette classe hérite de la classe MetierManager. Elle permet d'effectuer des
 * traitements pour la ressource 'maintenance' qui ont vocation à être
 * déclenché de manière automatique ou par une application externe. Par
 * exemple, un cron permet chaque soir d'exécuter la synchronisation des
 * utilisateurs de l'application avec l'annuaire LDAP.
 */

// Constante utilisée pour le nb max de dossier traité pour l'import des documents numerisé
define("NB_DOS_MAX", 0);
// Constante utilisée pour la suppression ou non des repertoires dans Todo aprés import
define("DELETE_FOLDER_TODO", false);

class MaintenanceManager extends MetierManager {

    /**
     * @var mixed Ce tableau permet d'associer un module a une méthode,
     * le module (key) est celui reçu dans la requête REST, la méthode (value)
     * est la méthode de cette classe qui va exécuter le traitement
     */
    var $fptrs = array(
        'user' => 'synchronizeUsers',
        'consultation' => 'updateConsultationsStates',
        'instruction' => 'updateDossierTacite',
        'import' => 'importDigitalizedDocuments',
        'purge' => 'purgeDigitalizedDocuments',
        'update_dossier_autorisation' => 'updateDAState',
        'contrainte' => 'synchronisationContraintes',
        'update_missing_geolocation' => 'update_missing_geolocation',
        'maj_metadonnees_documents_numerises' => 'updateDigitalizedDocumentsMetadata',
        'add_suivi_numerisation' => 'add_suivi_numerisation',
        'update_parapheur_datas' => 'update_parapheur_datas',
        'purge_orphans_files_filesystem' => 'purge_orphans_files_filesystem',
        'get_uids_without_files' => 'get_uids_without_files',
    );

    /**
     * Cette méthode permet de gérer l'appel aux différentes méthodes
     * correspondantes au module appelé.
     *
     * @param string $module Le module à exécuter reçu dans la requête
     * @param mixed $data Les données reçues dans la requête
     * @return string Le résultat du traitement
     */
    public function performMaintenance($module, $data) {

        // Si le module n'existe pas dans la liste des modules disponibles
        // alors on ajoute un message d'informations et on retourne un
        // un résultat d'erreur
        if (!in_array($module, array_keys($this->fptrs))) {
            $this->setMessage("Le module demandé n'existe pas");
            return $this->BAD_DATA;
        }

        // Si le module existe dans la liste des modules disponibles
        // alors on appelle la méthode en question et on retourne son résultat
        return call_user_func(array($this, $this->fptrs[$module]), $data);

    }

    /**
     * Cette méthode permet d'effectuer la synchronisation des utilisateurs
     * de l'application avec l'annuaire LDAP paramétré dans l'application.
     * 
     * @param mixed $data Les données reçues dans la requête
     * @return string Le résultat du traitement
     *
     * @todo XXX Faire une getsion des erreurs dans om_application pour
     * permettre d'avoir un retour sur le nombre d'utilisateurs synchronisés
     */    
    public function synchronizeUsers($data) {

        // Si aucune configuration d'annuaire n'est présente, on retourne que
        // tout est OK et que la configuration 'annuaire n'est pas activée.
        if ($this->f->is_option_directory_enabled() !== true) {
            $this->setMessage("L'option 'annuaire' n'est pas configurée.");
            return $this->OK;
        }

        // Initialisation de la synchronisation des utilisateurs LDAP
        $results = $this->f->initSynchronization();

        // Si l'initialisation ne se déroule pas correctement alors on retourne
        // un résultat d'erreur
        if (is_null($results) || $results == false) {
            $this->setMessage("Erreur interne");
            return $this->KO;
        }

        // Application du traitement de synchronisation
        $ret = $this->f->synchronizeUsers($results);

        // Si l'a synchronisation ne se déroule pas correctement alors on
        // retourne un résultat d'erreur
        if ($ret == false) {
            $this->setMessage("Erreur interne");
            return $this->KO;
        }

        // Si l'a synchronisation ne se déroule correctement alors on
        // retourne un résultat OK
        $this->setMessage("Synchronisation terminée.");
        return $this->OK;

    }

    /**
     * Cette méthode permet d'effectuer le traitement de gestion des avis
     * tacites sur les consultations qui ont atteint leur date limite de
     * retour.
     * 
     * @param mixed $data Les données reçues dans la requête
     * @return string Le résultat du traitement
     *
     * @todo Vérifier si il est possible de déplacer la méthode dans
     * l'application
     */
    public function updateConsultationsStates($data) {

        // Nom de la table
        $table_name = 'consultation';

        // Récupération de la référence vers un avis_consultation correspondant
        // au libellé 'Tacite'
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                "SELECT 
                    avis_consultation 
                FROM 
                    %savis_consultation 
                WHERE 
                    libelle = 'Tacite'
                    AND ((
                            avis_consultation.om_validite_debut IS NULL
                            AND (
                                avis_consultation.om_validite_fin IS NULL 
                                OR avis_consultation.om_validite_fin > CURRENT_DATE))
                        OR (
                            avis_consultation.om_validite_debut <= CURRENT_DATE
                            AND (
                                avis_consultation.om_validite_fin IS NULL
                                OR avis_consultation.om_validite_fin > CURRENT_DATE)))",
                DB_PREFIXE
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        // Si une erreur de base de données se produit sur cette requête
        // alors on retourne un résultat d'erreur
        if ($qres['code'] !== 'OK') {
            $this->setMessage("Erreur de base de données.");
            return $this->KO;
        }

        // Récupération de la référence vers un avis_consultation correspondant
        // au libellé 'Tacite'
        $tacite = NULL;
        foreach ($qres['result'] as $row) {
            $tacite = $row["avis_consultation"];
        }

        // Si la décision n'existe pas dans la base de données alors on ajoute
        // un message d'informations et on retourne un résultat d'erreur
        if (is_null($tacite)) {
            $this->setMessage("L'avis n'existe pas.");
            return $this->KO;
        }

        // Récupération de la liste des consultations correspondantes aux
        // critères du traitement
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    consultation,
                    date_limite
                FROM
                    %1$s%2$s
                    INNER JOIN %1$sservice
                        ON consultation.service = service.service
                WHERE
                    date_limite < CURRENT_DATE
                    AND date_retour IS NULL
                    AND avis_consultation IS NULL
                    AND service_type != \'%3$s\'
                UNION
                (SELECT
                    consultation,
                    date_limite
                FROM
                    %1$s%2$s
                INNER JOIN 
                    %1$smotif_consultation
                ON 
                    consultation.motif_consultation = motif_consultation.motif_consultation
                WHERE
                    date_limite < CURRENT_DATE
                    AND date_retour IS NULL
                    AND avis_consultation IS NULL
                    AND service_type != \'%3$s\')',
                DB_PREFIXE,
                $this->f->db->escapeSimple($table_name),
                PLATAU
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        // Si une erreur de base de données se produit sur cette requête
        // alors on retourne un résultat d'erreur
        if ($qres['code'] !== 'OK') {
            $this->setMessage("Erreur de base de données.");
            return $this->KO;
        }
        
        // Si aucune consultation n'est concernée par le traitement alors on
        // ajoute un message d'informations et on retourne un résultat 'OK'
        if ($qres['row_count'] == 0) {
            $this->setMessage("Aucune mise a jour.");
            return $this->OK;
        }
        
        $nb_consultations_maj = 0;
        //Pour chaque consultation correspondantes aux critères
        foreach ($qres['result'] as $row) {
            //
            $fields = array(
                'avis_consultation' => $tacite,
                'date_retour' => $row["date_limite"],
                'lu' => false,
            );
            //
            $res_update = $this->f->db->autoExecute(DB_PREFIXE.$table_name,
                                          $fields,
                                          DB_AUTOQUERY_UPDATE,
                                          'consultation = \''.$row["consultation"].'\'');
            // Logger
            $this->addToLog("updateConsultationsStates(): db->autoExecute(\"".DB_PREFIXE.$table_name."\", ".print_r($fields, true).", DB_AUTOQUERY_UPDATE, \"consultation = \"".$row["consultation"]."\"", VERBOSE_MODE);
            // Si une erreur de base de données se produit sur cette requête
            // alors on retourne un résultat d'erreur
            if ($this->f->isDatabaseError($res_update, true)) {
                $this->setMessage("Erreur de base de données.");
                return $this->KO;
            }
            //
            $nb_consultations_maj++;
        }
        // Tout s'est déroulé correctement alors on ajoute un message
        // d'informations et on retourne le résultat 'OK'
        $this->setMessage($nb_consultations_maj." consultations mise(s) à jour.");
        return $this->OK;

    }

    /**
     * Cette méthode permet d'ajouter une instruction sur les dossiers tacites : 
     * - soit les tacites normaux
     * - soit les incomplets ayant un événement tacites
     */
    public function updateDossierTacite() {

        // vérification de la disponibilité du stockage des documents (GED en général)
        if (! $this->f->storage->is_service_available()) {
            $err_msg = __("Service de stockage des documents indisponible");
            $this->setMessage($err_msg);
            return $this->KO;
        }

        // Cas particulier du mode service consulté : Si 2 demandes de consultation
        // pour un même DI sont reçues alors 2 dossiers seront créés dans l'application.
        // Problème : ces demandes sont soumis à des tacites. En rendant un avis sur la plus
        // récente mais pas la plus ancienne lorsque le tacite s'applique sur la plus
        // ancienne on peut avoir deux avis différents pour un même DI.
        // Solution : Si plusieurs demandes de consultation sont faite sur un DI le
        // tacite ne dois pas être appliqué sur les plus anciennes.
        if ($this->f->is_option_mode_service_consulte_enabled() === true) {
            if ($this->taciteSpecificTreatment() !== true) {
                $this->setMessage("Le traitement spécifique des tacites en mode service consulté à échoué.");
            }
        }

        // Liste les dossiers tacites
        // UNION
        // liste des dossiers incomplets tacites
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    dossier.dossier,
                    dossier.evenement_suivant_tacite,
                    dossier.date_limite,
                    TO_CHAR(dossier.date_limite + interval \'1 day\', \'YYYY-MM-DD\') AS new_date_limite
                FROM 
                     %1$sdossier
                    LEFT JOIN  %1$sinstruction 
                        ON instruction.dossier = dossier.dossier 
                            AND instruction.evenement = dossier.evenement_suivant_tacite
                WHERE
                    dossier.date_limite < CURRENT_DATE
                    AND dossier.accord_tacite = \'Oui\'
                    AND dossier.evenement_suivant_tacite IS NOT NULL
                    AND dossier.incomplet_notifie = FALSE
                    AND instruction.instruction IS NULL
                    AND dossier.avis_decision IS NULL
                UNION
                (SELECT
                    dossier.dossier,
                    dossier.evenement_suivant_tacite_incompletude AS evenement_suivant_tacite,
                    dossier.date_limite_incompletude AS date_limite,
                    TO_CHAR(dossier.date_limite_incompletude + interval \'1 day\', \'YYYY-MM-DD\') AS new_date_limite
                FROM
                     %1$sdossier
                    LEFT JOIN  %1$sinstruction
                        ON instruction.dossier=dossier.dossier
                            AND instruction.evenement = dossier.evenement_suivant_tacite
                WHERE
                    dossier.date_limite_incompletude < CURRENT_DATE
                    AND dossier.accord_tacite = \'Oui\'
                    AND dossier.evenement_suivant_tacite_incompletude IS NOT NULL
                    AND dossier.incomplet_notifie = TRUE
                    AND dossier.incompletude = TRUE
                    AND instruction.instruction IS NULL
                    AND dossier.avis_decision IS NULL)',
                DB_PREFIXE
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            $this->setMessage("Erreur de base de données.");
            return $this->KO;
        }// Inclusion de la classe de base MetierManager
        $nb_maj = 0;
        foreach ($qres['result'] as $row_dossier_tacite) {
            // essai d'ajout des donnees dans la base de donnees
            $this->f->db->autoCommit(false);
            // Si un evenement est configuré suivant tacite
            $valNewInstr = array();
            $instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => "]",
            ));
            // Création d'un tableau avec la liste des champs de l'instruction
            foreach($instruction->champs as $champ) {
                if($champ != "bible_auto") {
                    $valNewInstr[$champ] = ""; 
                }
            }

            // Définition des valeurs de la nouvelle instruction
            $valNewInstr["evenement"] = $row_dossier_tacite["evenement_suivant_tacite"];
            $valNewInstr["dossier"] = $row_dossier_tacite['dossier'];
            $valNewInstr["date_evenement"] = $row_dossier_tacite['new_date_limite'];
            $instruction->valF = array();
            $res_ajout = $instruction->ajouter($valNewInstr);
            if ($res_ajout === false) {
                $instruction->undoValidation();
                $this->setMessage("Erreur de base de données.");
                return $this->KO;
            } else {
                $this->f->db->commit();
                $nb_maj++;
            }
        }

        // Si aucune instruction n'est concernée par le traitement alors on
        // ajoute un message d'informations et on retourne un résultat 'OK'
        if ($nb_maj == 0) {
            $this->setMessage("Aucune mise a jour.");
            return $this->OK;
        }

        // Tout s'est déroulé correctement alors on ajoute un message
        // d'informations et on retourne le résultat 'OK'
        $this->setMessage($nb_maj." dossier(s) mis à jour.");
        return $this->OK;
    }

    /**
     * Méthode permettant de réaliser des traitements spécifique sur les tacites.
     *
     * Traitements :
     *  - Identifie et met à jour à l'aide d'une requête sql les dossiers supposé passer en tacite
     * pour lesquels il existe un dossier plus récent rattaché au même dossier d'autorisation et
     * à la même collectivité. Passe leur champs 'accord_tacite' à Non pour que le tacite ne
     * soit pas traité.
     *
     * @return boolean indique si le traitement a réussi
     */
    protected function taciteSpecificTreatment() {
        // Préparation et execution de la requête de mise à jour des dossiers.
        // Les dossiers ayant un tacite à traiter et pour lesquels il existe
        // un dossier plus récent enregistré sur le même dossier d'autorisation
        // et pour la même collectivité seront mis à jour pour que leur tacite ne
        // soit pas traité
        $valToUpdate = array('accord_tacite' => 'Non');
        $sqlGetTaciteToUpdate = sprintf(
            'dossier IN (
                SELECT
                    dossier.dossier
                FROM
                    %1$sdossier
                    -- Récupération du numéro de version max pour un DA et une collectivité
                    -- donnée et jointure avec la table dossier
                    LEFT JOIN (
                       SELECT
                           dossier.dossier_autorisation,
                           dossier.om_collectivite,
                           MAX(dossier.version) as version_max
                        FROM
                            %1$sdossier
                        GROUP BY
                            dossier.dossier_autorisation,
                            dossier.om_collectivite
                     ) AS max_versions_di
                         ON max_versions_di.dossier_autorisation = dossier.dossier_autorisation
                            AND max_versions_di.om_collectivite = dossier.om_collectivite
                WHERE
                    -- Récupération uniquement des dossiers n ayant pas le dernier
                    -- numéro de version du DA de la collectivite
                    dossier.version < version_max
                    -- Avis decision IS NULL et date_limite IS NOT NULL sont indexés
                    -- pour optimiser la requête
                    AND dossier.avis_decision IS NULL
                    AND dossier.date_limite < CURRENT_DATE
                    AND dossier.incomplet_notifie = FALSE
                    AND dossier.accord_tacite = \'Oui\'
                    AND dossier.evenement_suivant_tacite IS NOT NULL
                UNION
                SELECT
                    dossier.dossier
                FROM
                    %1$sdossier
                    -- Récupération du numéro de version max pour un DA et une collectivité
                    -- donnée et jointure avec la table dossier
                    LEFT JOIN (
                       SELECT
                           dossier.dossier_autorisation,
                           dossier.om_collectivite,
                           MAX(dossier.version) as version_max
                        FROM
                            %1$sdossier
                        GROUP BY
                            dossier.dossier_autorisation,
                            dossier.om_collectivite
                     ) AS max_versions_di
                         ON max_versions_di.dossier_autorisation = dossier.dossier_autorisation
                            AND max_versions_di.om_collectivite = dossier.om_collectivite
                WHERE
                    -- Récupération uniquement des dossiers n ayant pas le dernier
                    -- numéro de version du DA de la collectivite
                    dossier.version < version_max
                    -- Avis decision IS NULL, date_limite IS NOT NULL et incompletude
                    -- sont indexés pour optimiser la requête
                    AND dossier.avis_decision IS NULL
                    AND dossier.incomplet_notifie = TRUE
                    AND dossier.date_limite_incompletude < CURRENT_DATE
                    AND dossier.accord_tacite = \'Oui\'
                    AND dossier.evenement_suivant_tacite_incompletude IS NOT NULL

            )',
            DB_PREFIXE
        );
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.'dossier',
            $valToUpdate,
            DB_AUTOQUERY_UPDATE,
            $sqlGetTaciteToUpdate
        );
        // Affichage de la méthode d'éxecution de la requête dans les logs
        $this->addToLog(
            sprintf(
                '%s(): db->autoexecute("%sdossier", "%s", "%s", "%s");',
                __METHOD__,
                DB_PREFIXE,
                var_export($valToUpdate, true),
                DB_AUTOQUERY_UPDATE,
                $sqlGetTaciteToUpdate
            ),
            VERBOSE_MODE
        );
        // Gestion des erreurs de base de données
        if ($this->f->isDatabaseError($res, true) === true) {
            $this->setMessage(
                __("La suppression du caractère tacite des dossiers ayant un dossier plus récent lié au même dossier d'autorisation et à la même collectivité a échoué.").
                __("Veuillez contacter votre administrateur")
            );
            return false;
        }
        return true;
    }

    /**
     * Cette méthode permet de faire l'importation des documents scannés
     * @param  string $data données envoyé en paramètre
     */
    public function importDigitalizedDocuments($data) {

        // Si l'option de numérisation est désactivée
        if ($this->f->is_option_digitalization_folder_enabled() !== true) {
            //
            $this->setMessage(_("L'option de numerisation des dossiers n'est pas activee"));
            return $this->OK;
        }

        // vérification de la disponibilité du stockage des documents (GED en général)
        if (! $this->f->storage->is_service_available()) {
            $err_msg = __("Service de stockage des documents indisponible");
            $this->setMessage($err_msg);
            return $this->KO;
        }

        //Instance classe DigitalizedDocument
        require_once("../obj/digitalizedDocument.class.php");
        $digitalizedDocument = new DigitalizedDocument($this->f);

        //Chemin des dossiers source et destination
        $path = $data;

        //Si deux données sont présentes dans $data
        if (!empty($path)) {

            //Dossier source
            $pathSrc = isset($path["Todo"])?$path["Todo"]:"";
            //Aucun chemin n'est fourni pour le dossier source, on utilise la
            //configuration
            if($pathSrc===""){
                //Si le répertoire de numérisation n'est pas configuré
                if ($this->f->getParameter("digitalization_folder_path") === null) {
                    //Message erreur
                    $this->setMessage(_("Le repertoire de numerisation n'est pas configure"));
                    return $this->KO;
                }
    
                $pathSrc = $this->f->getParameter("digitalization_folder_path").'Todo/';
            }
            //Si le dossier n'existe pas, on retourne une erreur
            elseif (!is_dir($pathSrc)) {
                //Message erreur
                $this->setMessage(_("Le repertoire de numerisation fourni n'existe pas"));
                return $this->KO;
            }
            
            //Dossier de destination
            $pathDes = isset($path["Done"])?$path["Done"]:"";
            //Aucun chemin n'est fourni pour le dossier de destination, on utilise la
            //configuration
            if($pathDes===""){
                //Si le répertoire de numérisation n'est pas configuré
                if ($this->f->getParameter("digitalization_folder_path") === null) {
                    //Message erreur
                    $this->setMessage(_("Le repertoire de numerisation n'est pas configure"));
                    return $this->KO;
                }
    
                $pathDes = $this->f->getParameter("digitalization_folder_path").'Done/';
            }
            //Si le dossier n'existe pas, on retourne une erreur
            elseif (!is_dir($pathDes)) {
                //Message erreur
                $this->setMessage(_("Le repertoire de numerisation fourni n'existe pas"));
                return $this->KO;
            }

            //Dossier ERREUR
            $pathErr = isset($path["Error"])?$path["Error"]:"";
            //Aucun chemin n'est fourni pour le dossier erreur, on utilise la
            //configuration
            if($pathErr===""){
                //Si le répertoire de numérisation n'est pas configuré
                if ($this->f->getParameter("digitalization_folder_path") === null) {
                    //Message erreur
                    $this->setMessage(_("Le repertoire de numerisation n'est pas configure"));
                    return $this->KO;
                }
    
                $pathErr = $this->f->getParameter("digitalization_folder_path").'Error/';
            }
            //Si le dossier n'existe pas, on retourne une erreur
            elseif (!is_dir($pathErr)) {
                //Message erreur
                $this->setMessage(_("Le repertoire de numerisation fourni n'existe pas"));
                return $this->KO;
            }
        } else {

            //Si le répertoire de numérisation n'est pas configuré
            if ($this->f->getParameter("digitalization_folder_path") === null) {
                //Message erreur
                $this->setMessage(_("Le repertoire de numerisation n'est pas configure"));
                return $this->KO;
            }

            $pathSrc = $this->f->getParameter("digitalization_folder_path").'Todo/';
            $pathDes = $this->f->getParameter("digitalization_folder_path").'Done/';
            $pathErr = $this->f->getParameter("digitalization_folder_path").'Error/';
        }

        //
        $repo = scandir($pathSrc);
        $importDone = false;
        $importErrorFilename = array();
        $nb_doss_max = isset($data["nb_doss_max"]) === true ? intval($data["nb_doss_max"]) : NB_DOS_MAX;
        $delete_folder_todo = isset($data["delete_folder_todo"]) === true ? $data["delete_folder_todo"] : DELETE_FOLDER_TODO;

        //Si le dossier est ouvert
        if ($repo) {
            // Compteur du nombre de dossier traité
            $cpt = 0;
            // Verifie si le nombre de dossiers a traiter est passé en parametre
            foreach ($repo as $key => $folder) {
                if ($nb_doss_max !== 0 && $cpt >= $nb_doss_max){
                    break;
                }
                //Vérifie qu'il s'agit de dossier correct
                if ($folder != '.' && $folder != '..') {
                    
                    //Importation des documents
                    $import = $digitalizedDocument->run_import($pathSrc.'/'.$folder, $pathDes.'/'.$folder, $pathErr.'/'.$folder);
                    //Si  une importation a été faite
                    if ($import) {
                        $cpt++;
                        $importDone = true;
                        // Si l'option de suppression est activée, la suppression du repertoire est effectuée
                        if ($delete_folder_todo === true) {
                            $is_rm = rmdir($pathSrc.'/'.$folder);
                            if ($is_rm === false) {
                                $this->addToLog(sprintf(
                                __("Impossible de supprimer le répertoire %s car il possède encore des fichiers."),
                                $folder
                            ));
                            }
                        }
                    }
                    //Si certain des fichiers ne se sont pas importés
                    if (count($digitalizedDocument->filenameError) > 0){
                        //
                        $importErrorFilename = array_merge($importErrorFilename, $digitalizedDocument->filenameError);
                        unset($digitalizedDocument->filenameError);
                        $digitalizedDocument->filenameError = array();
                    }
                }
            }
        }
        
        //Si des fichiers ne se sont pas importés à cause d'une erreur
        if (count($importErrorFilename)>0){
            $importErrorFilename = sprintf(_("Liste des fichiers en erreur : %s"),implode(',',$importErrorFilename));
        }

        $msg = $nb_doss_max !== 0 ? __("Limite de dossier atteinte") : __("Tous les documents ont ete traites");
        //Message de retour
        ($importDone) ?
            //Il y avait des documents à traiter 
            $this->setMessage($msg.
                ((!is_array($importErrorFilename) && $importErrorFilename!= '')?
                    "\n".$importErrorFilename:
                    "")) :
            //Il n'y avait aucun document à traiter
            $this->setMessage(_("Aucun document a traiter")) ;
        return $this->OK;
    }

    /**
     * Cette méthode permet de faire la purge des documents scannés
     * @param  string $data données envoyé en paramètre
     */
    public function purgeDigitalizedDocuments($data) {

        // Si l'option de numérisation est désactivée
        if ($this->f->is_option_digitalization_folder_enabled() !== true) {
            //
            $this->setMessage(_("L'option de numerisation des dossiers n'est pas activee"));
            return $this->OK;
        }

        // vérification de la disponibilité du stockage des documents (GED en général)
        if (! $this->f->storage->is_service_available()) {
            $err_msg = __("Service de stockage des documents indisponible");
            $this->setMessage($err_msg);
            return $this->KO;
        }

        //Instance classe DigitalizedDocument
        require_once("../obj/digitalizedDocument.class.php");
        $digitalizedDocument = new DigitalizedDocument($this->f);

        //Récupération des données
        $path = $data;
        //Dossier à purger
        $path = isset($data["dossier"])?$data["dossier"]:"";
        
        //Si aucun dossier n'est fourni, on utilise le dossier de configuration
        if($path==""){
            
            //Si le répertoire de numérisation n'est pas configuré
            if ($this->f->getParameter("digitalization_folder_path") === NULL) {
                //Message erreur
                $this->setMessage(_("Le repertoire de numerisation n'est pas configure"));
                return $this->KO;
            }

            $path = $this->f->getParameter("digitalization_folder_path").'Done/';
        }
        //Si le dossier n'existe pas, on retourne une erreur
        elseif (!is_dir($path)) {
            //Message erreur
            $this->setMessage(_("Le repertoire de numerisation fourni n'existe pas"));
            return $this->KO;
        }
        
        //Nombre de jour à soustraite à la date du jour
        $nbDay = isset($data["nombre_de_jour"])?$data["nombre_de_jour"]:"";
        //Vérifie que $nbDay soit un entier
        if (!is_numeric($nbDay)) {
            $nbDay = null;
        }

        //
        $repo = scandir($path);

        //Si le dossier est ouvert
        if ($repo) {
            $count_purged_folder = 0;
            $count_purged_files = 0;
            //
            foreach ($repo as $key => $folder) {

                //Vérifie qu'il s'agit de dossier correct
                if ($folder != '.' && $folder != '..') {
                    
                    //Importation des documents
                    $purge = $digitalizedDocument->run_purge($path."/".$folder, $nbDay);

                    //Si la purge n'a pas était faite
                    if ($purge != false) {
                        $count_purged_files += $purge;
                    }
                    $count_purged_folder++;

                }

            }
            //Retourne erreur
            $this->setMessage($count_purged_files." fichier(s) purgé(s) sur ".$count_purged_folder." dossier(s) traité(s)");
            return $this->OK;
        }

        //Retourne erreur
        $this->setMessage("Aucun document a traiter");
        return $this->OK;
    }

    /**
     * Cette fonction permet de mettre à jour l'état des dossiers d'autorisation
     */
    public function updateDAState() {

        // Récupération des DA dont l'état doit passer à "Périmé"
        $qres_da = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    dossier_autorisation.dossier_autorisation
                FROM 
                    %1$sdossier_autorisation
                    LEFT OUTER JOIN (
                        SELECT 
                            dossier_autorisation
                        FROM 
                            %1$sdossier
                            LEFT JOIN %1$sdossier_instruction_type
                                ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type
                            LEFT JOIN %1$savis_decision
                                ON avis_decision.avis_decision = dossier.avis_decision
                        WHERE 
                            code IN (\'DOC\', \'DAACT\') 
                            AND avis_decision.typeavis = \'F\'
                    ) AS dossier_2
                        ON dossier_2.dossier_autorisation = dossier_autorisation.dossier_autorisation
                    LEFT JOIN %1$sdossier
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                    LEFT JOIN %1$sdossier_instruction_type
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    LEFT JOIN %1$setat_dossier_autorisation
                        ON dossier_autorisation.etat_dossier_autorisation = etat_dossier_autorisation.etat_dossier_autorisation
                    LEFT JOIN %1$sdossier_autorisation_type_detaille
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_autorisation.dossier_autorisation_type_detaille
                WHERE
                    etat_dossier_autorisation.libelle = \'Accordé\'
                    AND dossier_autorisation.date_decision IS NOT NULL
                    AND dossier_autorisation.date_validite < current_date
                    AND dossier_2.dossier_autorisation IS NULL
                GROUP BY
                    dossier_autorisation.dossier_autorisation',
                DB_PREFIXE
            ),
            array(
                'origin' => __METHOD__,
                'force_result' => true
            )
        );
        if ($qres_da['code'] !== 'OK') {
            $this->setMessage(_("Erreur de base de donnees."));
            return $this->KO;
        }

        // Récupération de l'identifiant de l'état "Périmé"
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    etat_dossier_autorisation
                FROM
                    %1$setat_dossier_autorisation 
                WHERE
                    libelle = \'Périmé\'',
                DB_PREFIXE
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            $this->setMessage(_("Erreur de base de donnees."));
            return $this->KO;
        }
        $res_etat_perime = $qres["result"];

        // Liste des dossiers d'autorisation
        $ids = array();
        foreach ($qres_da['result'] as $row_da) {
            $ids[] = "'".$row_da['dossier_autorisation']."'";
        }

        // Si aucun dossier d'autorisation n'est concerné par le traitement alors on
        // ajoute un message d'informations et on retourne un résultat 'OK'
        if (count($ids) == 0) {
            $this->setMessage(_("Aucune mise a jour."));
            return $this->OK;
        }

        // Exécution du traitement
        // On met à jour tous les dossiers d'autorisations
        $fields = array(
            'etat_dossier_autorisation' => $res_etat_perime,
            'etat_dernier_dossier_instruction_accepte' => $res_etat_perime,
        );
        $res = $this->f->db->autoExecute(DB_PREFIXE."dossier_autorisation",
                                      $fields,
                                      DB_AUTOQUERY_UPDATE,
                                      'dossier_autorisation IN ('.implode(',', $ids).')');
        // Logger
        $this->addToLog("updateDAState(): db->autoExecute(\"".DB_PREFIXE."dossier_autorisation"."\", ".print_r($fields, true).", DB_AUTOQUERY_UPDATE, \"dossier_autorisation IN (\"".implode(',', $ids)."\")", VERBOSE_MODE);
        // Si une erreur de base de données se produit sur cette requête
        // alors on retourne un résultat d'erreur
        if ($this->f->isDatabaseError($res, true)) {
            $this->setMessage("Erreur de base de données.");
            return $this->KO;
        }

        // Tout s'est déroulé correctement alors on ajoute un message
        // d'informations et on retourne le résultat 'OK'
        $this->setMessage(count($ids)." "._("dossier(s) d'autorisation(s) mis a jour."));
        return $this->OK;

    }

    /**
     * Synchronisation des contraintes depuis le SIG
     * Permet d'ajouter de nouvelle contrainte, de modifier les contraintes
     * existantes et d'archiver les contraintes qui ne sont plus utilisées.
     */
    public function synchronisationContraintes() {

        // Si l'option du SIG est désactivée
        if ($this->f->is_option_sig_enabled() !== true) {
            //
            $this->setMessage(_("L'option du SIG n'est pas activée"));
            return $this->OK;
        }

        // Si l'option de synchronisation automatique des contraintes est
        // désactivée
        if ($this->f->is_option_ws_synchro_contrainte_enabled() !== true) {
            //
            $this->setMessage(_("L'option de synchronisation automatique des contraintes n'est pas activée"));
            return $this->OK;
        }

        // Instancie la classe SynchronisationContrainte
        require_once("../obj/synchronisationContrainte.class.php");

        //
        try {
            $synchronisationContrainte = new SynchronisationContrainte($this->f);
        } catch (geoads_exception $e) {
            //
            $this->addToLog("synchronisationContraintes(): Traitement webservice SIG: ".$e->getMessage(), DEBUG_MODE);
            //
            $this->setMessage("une erreur s'est produite.")." "._("Contactez votre administrateur")."<br />";
            //
            return $this->KO;
        }

        $correct = $synchronisationContrainte->constraint_sync_treatment();
        $output_message = $synchronisationContrainte->get_output_message();

        $display_message = array();
        foreach ($output_message as $key => $value) {
            $temp = "";
            if(isset($value["commune"]) === true) {
                $temp .= $value["commune"]." : ";
            }
            if($value["type"] == 'error') {
                $temp .= " (erreur) ";
            }
            $temp .= strip_tags($value["message"]);
            $display_message[] = $temp;
        }

        $message = $this->setMessage(implode(' - ', $display_message));
        //
        if ($correct == true) {
            //
            return $this->OK;
        }

        // S'il y a une erreur
        if ($correct == false) {
            //
            $this->addToLog("synchronisationContraintes(): ".$message, DEBUG_MODE);
            return $this->KO;
        }
    }

    /**
     * Géolocalisation automatique des dossiers en webservice
     *
     * Permet d'effectuer une vérification des parcelles, un calcul d'emprise
     * puis un calcul du centroide sur les dossiers qui n'en ont pas. 
     * Cela permettra de répertorier les dossiers en question dans le SIG. 
     */
    public function update_missing_geolocation() {
        // Si l'option du SIG est désactivée
        if ($this->f->is_option_sig_enabled() !== true) {
            //
            $this->setMessage(_("L'option du SIG n'est pas activée"));
            return $this->OK;
        }

        try {
            $dossier_instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => 0
            ));
        } catch (geoads_exception $e) {
            $this->addToLog("update_missing_geolocation(): Traitement webservice SIG: ".$e->getMessage(), DEBUG_MODE);
            $this->setMessage("une erreur s'est produite.")." "._("Contactez votre administrateur")."<br />";
            return $this->KO;
        }

        // On lance le traitement de géocodage
        $geocodage = $dossier_instruction->treat_dossiers_without_geom();

        // Pour chaque collectivité, on compte le nombre d'occurence par
        // valeur de retour
        $count_value = array();
        foreach ($geocodage as $key => $value) {
            //$count_value[id de la collectivité][valeur de retour de géocodage][occurence de la valeur de retour]
            $count_value[$key] = array_count_values($value);
        }

        // Initialisation du message de validation
        $message = '';

        // Pour chaque collectivité on affiche le message présentant les
        // résultats
        foreach ($count_value as $key => $value) {
            //
            $om_collectivite = $this->f->get_inst__om_dbform(array(
                "obj" => "om_collectivite",
                "idx" => $key
            ));

            // Compteur des DI pour chaque résultats
            $nb_true = 0;
            $nb_verif_parcelle_error = 0;
            $nb_calcul_emprise_error = 0;
            $nb_calcul_centroide_error = 0;

            if (isset($value['true']) === true) {
                $nb_true = $value['true'];
            }
            if (isset($value['verif_parcelle_error']) === true) {
                $nb_verif_parcelle_error = $value['verif_parcelle_error'];
            }
            if (isset($value['calcul_emprise_error']) === true) {
                $nb_calcul_emprise_error = $value['calcul_emprise_error'];
            }
            if (isset($value['calcul_centroide_error']) === true) {
                $nb_calcul_centroide_error = $value['calcul_centroide_error'];
            }
            if ($nb_true + $nb_verif_parcelle_error + $nb_calcul_emprise_error + $nb_calcul_centroide_error > 0) {
                $message .= sprintf("%s ::", $om_collectivite->getVal('libelle'));
            }
            if ($nb_true > 0) {
                $message .= sprintf("%s %s,",$nb_true,_("dossier(s) d'instruction a(ont) été géolocalisé(s)"));
            }
            if ($nb_verif_parcelle_error + $nb_calcul_emprise_error + $nb_calcul_centroide_error > 0) {
                $message .= sprintf("%s %s,",$nb_verif_parcelle_error+ $nb_calcul_emprise_error+$nb_calcul_centroide_error,_("dossier(s) d'instruction n'a(ont) pas pu être géolocalisé(s)"));
            }
            if ($nb_verif_parcelle_error > 0) {
                $message .= sprintf("%s %s,",$nb_verif_parcelle_error,_("dossier(s) d'instruction en erreur à la vérification des parcelles"));
            }
            if ($nb_calcul_emprise_error > 0) {
                $message .= sprintf("%s %s,",$nb_calcul_emprise_error,_("dossier(s) d'instruction en erreur au calcul de l'emprise"));
            }
            if ($nb_calcul_centroide_error > 0) {
                $message .= sprintf("%s %s",$nb_calcul_centroide_error,_("dossier(s) d'instruction en erreur au calcul du centroïde"));
            }

            // Séparateur des messages
            $message .= ';';
            //
            if ($message !== '') {
                $this->setMessage($message);
            }
        }
        return $this->OK; 
    }

    /**
     * Permet de mettre à jour les métadonnées suivantes de tous les documents numérisés, en
     * fonction du paramétrage des types de documents numérisés dans la BDD :
     * - "affichage DA"
     * - "affichage service consulté"
     */
    public function updateDigitalizedDocumentsMetadata() {

        // vérification de la disponibilité du stockage des documents (GED en général)
        if (! $this->f->storage->is_service_available()) {
            $err_msg = __("Service de stockage des documents indisponible");
            $this->setMessage($err_msg);
            return $this->KO;
        }

        // Initialisation du retour du traitement
        $documents_en_erreur = false;
        //
        $inst_document_numerise_traitement_metadonnees = $this->f->get_inst__om_dbform(array(
            "obj" => "document_numerise_traitement_metadonnees",
            "idx" => 0,
        ));
        $documents_en_erreur = $inst_document_numerise_traitement_metadonnees->metadata_treatment();
        // Si toutes les métadonnées ont été correctement mises à jour
        if (is_array($documents_en_erreur) AND count($documents_en_erreur) === 0) {
            //Tous les documents ont ete traites
            $this->setMessage(_("Tous les documents ont été traités."));
            return $this->OK;
        }

        // Si certaines métadonnées n'ont pas pû être mises à jour
        if (is_array($documents_en_erreur) AND count($documents_en_erreur) !== 0) {

            $display_message = array();
            foreach ($documents_en_erreur as $key => $value) {
                if(isset($value["dossier"]) === true AND isset($value["nom_fichier"]) === true ) {
                    $display_message[] = sprintf(
                        _("Dossier d'instruction n°%s - le document %s n'a pas pu être mis à jour"),
                        $value['dossier'],
                        $value['nom_fichier']
                    );
                }
            }
            $this->setMessage("Liste des fichiers en erreur : ".implode(', ', $display_message));
            return $this->OK;
        }

        // S'il y a une erreur
        if ($documents_en_erreur == false) {
            //
            $this->setMessage("Une erreur s'est produite lors de la mise à jour des métadonnées.", DEBUG_MODE);
            return $this->KO;
        }

    }

    /**
     * [add_suivi_numerisation description]
     * @param [type] $data [description]
     */
    public function add_suivi_numerisation($data) {
        // Si l'option de numérisation est désactivée
        if ($this->f->is_option_suivi_numerisation_enabled() !== true) {
            //
            $this->setMessage(__("L'option de suivi de numérisation n'est pas activée."));
            return $this->OK;
        }

        // vérification de la disponibilité du stockage des documents (GED en général)
        if (! $this->f->storage->is_service_available()) {
            $err_msg = __("Service de stockage des documents indisponible");
            $this->setMessage($err_msg);
            return $this->KO;
        }

        //
        if (isset($data[0]['om_collectivite']) === false
            || $data[0]['om_collectivite'] === ''
            || $data[0]['om_collectivite'] === null) {
            //
            $this->setMessage(__("Veuillez renseigner l'identifiant de la collectivité."));
            return $this->KO;
        }

        // Exécute le traitement de récupération des dossiers
        $inst_num_dossier_recuperation = $this->f->get_inst__om_dbform(array(
            "obj" => "num_dossier_recuperation",
            "idx" => 0,
        ));
        $recuperation = $inst_num_dossier_recuperation->recuperation($data[0]);
        $this->setMessage($inst_num_dossier_recuperation->msg);
        if ($recuperation !== true) {
            return $this->KO;
        }
        return $this->OK;
    }


    /**
     * Permet de récupérer et de mettre à jour les informations sur les instructions 
     * qui ont un document en cours de signature.
     */
    public function update_parapheur_datas() {

        // vérification de la disponibilité du stockage des documents (GED en général)
        if (! $this->f->storage->is_service_available()) {
            $err_msg = __("Service de stockage des documents indisponible");
            $this->setMessage($err_msg);
            return $this->KO;
        }

        $query = sprintf('
            SELECT instruction
            FROM %1$sinstruction
            WHERE id_parapheur_signature is NOT NULL 
                AND statut_signature NOT IN (\'finished\', \'expired\', \'canceled\')
            ',
            DB_PREFIXE
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            $this->setMessage(__("Une erreur est survenue lors de la récupération des instructions ayant un parapheur."));
            return $this->KO;
        }

        if (is_array($res['result']) === true && count($res['result']) <= 0) {
            $this->setMessage(__("Aucune instruction avec un document à signer par parapheur, n'est à traiter."));
            return $this->OK;
        }

        // On initialise les tableaux qui vont contenir les messages
        // ajoutés lors du traitement
        $display_error_tab = array();
        $display_ok_tab = array();

        // Pour chaque instruction listée
        foreach ($res['result'] as $instr) {

            // On instancie l'instruction
            $inst_instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => $instr['instruction'],
            ));

            // On instancie le parapheur de l'instruction
            $inst_abstracteur = $inst_instruction->get_electronicsignature_instance(false);
            if ($inst_abstracteur === false) {
                $display_error_tab[] = sprintf(
                    __("Erreur lors de l'instanciation de l'abstracteur sur l'instruction %s."),
                    $inst_instruction->getVal("instruction")
                );
            }

            // On appelle la méthode get_signature_status de l'abstracteur.
            // Toutes les méthodes de l'abstracteur retourneront un tableau avec les informations du parapheur
            // Le statut est donc dans l'attribut "statut" du tableau retourné ($signature_status_from_abstracteur["statut"])
            try {
                $signature_status_from_abstracteur = $inst_abstracteur->get_signature_status(array("id_parapheur_signature" => $inst_instruction->getVal("id_parapheur_signature")));
            } catch(electronicsignature_exception $e) {
                $inst_instruction->handle_electronicsignature_exception($e);
                $display_error_tab[] = sprintf(
                    '%s - %s',
                    sprintf(
                        __("Erreur sur l'instruction : %s"),
                        $inst_instruction->getVal("instruction")
                    ),
                    sprintf(
                        __("Traitement webservice Parapheur : %s"),
                        $e->getMessage()
                    )
                );
                continue;
            }

            // Si le statut récupéré est égal au statut actuel de l'instruction
            // et que le commentaire n'a pas changé ou qu'il est vide alors on ne fait rien
            if ($signature_status_from_abstracteur["statut"] == $inst_instruction->getVal("statut_signature")
                && ($signature_status_from_abstracteur["commentaire_signature"] == $inst_instruction->getVal("commentaire_signature")
                    || $signature_status_from_abstracteur["commentaire_signature"] != $inst_instruction->getVal("commentaire_signature")
                    && ($signature_status_from_abstracteur["commentaire_signature"] == null
                        || $signature_status_from_abstracteur["commentaire_signature"] == ""))) {
                $display_ok_tab[] = sprintf(
                    __("Rien à faire sur l'instruction %s."),
                    $inst_instruction->getVal("instruction")
                );
            }

            // Si le statut est différent de "finished" et s'il est différent du statut actuel de l'instruction
            // ou que le commentaire a changé et qu'il est différent de vide alors on met à jour l'instruction
            if ($signature_status_from_abstracteur["statut"] != "finished" 
                && ($signature_status_from_abstracteur["statut"] != $inst_instruction->getVal("statut_signature")
                    || ($signature_status_from_abstracteur["commentaire_signature"] != $inst_instruction->getVal("commentaire_signature")
                        && ($signature_status_from_abstracteur["commentaire_signature"] != null
                        || $signature_status_from_abstracteur["commentaire_signature"] != "")))) {
                //
                foreach($inst_instruction->champs as $identifiant => $champ) {
                    $valF[$champ] = $inst_instruction->val[$identifiant];
                }
                // On fait ensuite nos modifications spécifiques
                if ($signature_status_from_abstracteur["statut"] == "canceled") {
                    $valF['date_envoi_signature'] = null;
                    $valF['id_parapheur_signature'] = null;
                }

                $valF['statut_signature'] = $signature_status_from_abstracteur['statut'];
                $valF['commentaire_signature'] = $signature_status_from_abstracteur['commentaire_signature'];
                $valF['historique_signature'] = $inst_instruction->get_updated_historique_signature($signature_status_from_abstracteur);

                $inst_instruction->setParameter("maj", 1);
                $ret = $inst_instruction->modifier($valF);

                if ($ret === false) {
                    $display_error_tab[] = sprintf(
                        '%s Details : %s',
                        sprintf(
                            __("L'instruction %s n'a pas pu être mise à jour."),
                            $inst_instruction->getVal("instruction")
                        ),
                        $inst_instruction->msg
                    );
                    continue;
                } else {
                    $display_ok_tab[] = sprintf(
                        __("L'instruction %s a bien été mise à jour."),
                        $inst_instruction->getVal("instruction")
                    );
                }
            }

            // Si le nouveau statut est "finished" alors on récupère le document signé
            // on met à jour le document existant avec celui signé
            // et on met ensuite à jour l'instruction avec les nouvelles données
            if ($signature_status_from_abstracteur["statut"] == "finished") {
                try {
                    $signed_document = $inst_abstracteur->get_signed_document(array("id_parapheur_signature" => $inst_instruction->getVal("id_parapheur_signature")));
                } catch(electronicsignature_exception $e) {
                    $inst_instruction->handle_electronicsignature_exception($e);
                    $display_error_tab[] = sprintf(
                        '%s - %s',
                        sprintf(
                            __("Erreur sur l'instruction : %s"),
                            $inst_instruction->getVal("instruction")
                        ),
                        sprintf(
                            __("Traitement webservice Parapheur : %s"),
                            $e->getMessage()
                        )
                    );
                    continue;
                }

                // Il faut modifier l'attribut size des métadonnées avec
                // la taille du contenu du nouveau document, mais pour cela
                // il faut re-générer la totalité des métadonnées (car update écrase tout)
                $newMetadata = $inst_instruction->getMetadata('om_fichier_instruction');

                // On vérifie si l'instruction à finaliser a un événement de type arrete
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            type
                        FROM
                            %1$sevenement
                        WHERE
                            evenement = %2$s',
                        DB_PREFIXE,
                        intval($inst_instruction->getVal("evenement"))
                    ),
                    array(
                        "origin" => __METHOD__,
                        "force_return" => true,
                    )
                );
                if ($qres["code"] !== "OK") {
                    $display_error_tab[] = sprintf(
                        '%s Details : %s',
                        sprintf(
                            __("L'instruction %s n'a pas pu être mise à jour."),
                            $instr['instruction']
                        ),
                        __("Erreur rencontrée lors de la détection du type d'instruction")
                    );
                    continue;
                }
                $typeEvenement = $qres["result"];

                // Si l'événement est de type arrete, on ajoute les métadonnées spécifiques
                if ($typeEvenement == 'arrete'){
                    $newMetadata = array_merge($newMetadata, $inst_instruction->getMetadata("arrete"));
                }

                // Met à jour la taille du document (et conserve les autres métadonnées)
                $newMetadata = array_merge($newMetadata, array(
                    'filename' => 'instruction_'.$instr['instruction'].'.pdf',
                    'mimetype' => 'application/pdf',
                    'size' => strlen($signed_document['signed_file'])));


                // On met à jour le document lié à l'instruction
                $update_document_instruction = $this->f->storage->update(
                    $inst_instruction->getVal('om_fichier_instruction'),
                    $signed_document['signed_file'],
                    $newMetadata
                );

                // Si le document n'a pas pu être mis à jour alors on ne met pas à jour l'instruction
                if ($update_document_instruction === OP_FAILURE) {
                    $display_error_tab[] = sprintf(
                        __("Le document de l'instruction %s n'a pas pu être mise à jour."),
                        $inst_instruction->getVal("instruction")
                    );
                } else {

                    // si l'UID du document a changé après l'update
                    if ($update_document_instruction != $inst_instruction->getVal('om_fichier_instruction')) {
                        $this->addToLog(__METHOD__."Document UID has changed after update ($update_document_instruction != ".
                            $inst_instruction->getVal('om_fichier_instruction').")", VERBOSE_MODE);

                        // Mise à jour de la valeur de l'instance objet (ici uniquement obj->val,
                        // et plus bas obj->valF via la fonction obj->modifier)
                        // Note: utilisation de l'accès public à la variable obj->val, car il n'y a
                        //       aucun moyen de la mettre à jour autrement
                        $this->addToLog(__METHOD__."Updating instruction object value of 'om_fichier_instruction' to ".var_export($update_document_instruction, true), VERBOSE_MODE);
                        foreach($inst_instruction->champs as $f_index => $f_name) {
                            if ($f_name == 'om_fichier_instruction') {
                                $inst_instruction->val[$f_index] = $update_document_instruction;
                                $this->addToLog(__METHOD__."Now instruction object value of 'om_fichier_instruction' is ".var_export($inst_instruction->getVal('om_fichier_instruction'), true), VERBOSE_MODE);
                                break;
                            }
                        }
                    }

                    // Pour appeler la fonction modifier il faut traiter tous les champs de l'objet
                    foreach($inst_instruction->champs as $identifiant => $champ) {
                        $valF[$champ] = $inst_instruction->val[$identifiant];
                    }
                    // On fait ensuite nos modifications spécifiques
                    $valF['om_fichier_instruction'] = $update_document_instruction;
                    $valF['statut_signature'] = $signed_document['statut'];
                    $valF['date_retour_signature'] = date("Y-m-d", strtotime($signed_document['date_retour_signature']));
                    $valF['historique_signature'] = $inst_instruction->get_updated_historique_signature($signed_document);
                    $valF['commentaire_signature'] = $signed_document['commentaire_signature'];

                    $inst_instruction->setParameter("maj", 1);
                    $ret = $inst_instruction->modifier($valF);

                    if ($ret === false) {
                        $display_error_tab[] = sprintf(
                            '%s Details : %s',
                            sprintf(
                                __("L'instruction %s n'a pas pu être mise à jour."),
                                $inst_instruction->getVal("instruction")
                            ),
                            $inst_instruction->msg
                        );
                        continue;
                    } else {
                        $display_ok_tab[] = sprintf(
                            __("L'instruction %s et son document ont bien été mis à jour."),
                            $inst_instruction->getVal("instruction")
                        );

                        $inst_dossier = $this->f->findObjectById(
                            'dossier',
                            $inst_instruction->getVal('dossier'));
                        if (empty($inst_dossier)) {
                            $display_error_tab[] = sprintf(
                                __("Dossier %s non-trouvé pour l'instruction %s (instruction mise à jour mais pas le compteur de signatures"),
                                $inst_instruction->getVal('dossier'),
                                $inst_instruction->getVal('instruction'));
                        }
                        else {
                            $sql_cond_ct_alter = '';
                            $ct_unique_ou_niveau_2 = $this->f->get_idx_collectivite_multi();
                            if (! empty($ct_unique_ou_niveau_2)) {
                                $sql_cond_ct_alter = 'OR om_collectivite = '.
                                                     $ct_unique_ou_niveau_2;
                            }
                            $compteur_signature = $this->f->findObjectByCondition(
                                'compteur',
                                "code = 'signatures'
                                 AND (
                                     om_collectivite = ".$inst_dossier->getVal('om_collectivite')."
                                     $sql_cond_ct_alter
                                 )
                                 AND (
                                     om_validite_debut IS NULL
                                     OR om_validite_debut <= CURRENT_DATE
                                 )
                                 AND (
                                     om_validite_fin IS NULL
                                     OR om_validite_fin > CURRENT_DATE
                                 )",
                                'compteur DESC');
                            if (! empty($compteur_signature)) {
                                $res = null; // increment result
                                $exc = null; // exception
                                try {
                                    $res = $compteur_signature->increment();
                                }
                                catch(Exception $e) {
                                    $exc = $e;
                                }
                                // in case of an error or an exception
                                if (! $res || $exc) {
                                    $err_msg = sprintf(
                                        __("Le compteur '%s' n'a pas pu être incrémenté."),
                                        $compteur_signature->getVal("code"));
                                    if ($exc) {
                                        $err_msg .= ' ('.get_class($exc).': '.$exc->getMessage().')';
                                    }
                                    $display_error_tab[] = $err_msg;
                                }
                            }
                        }
                    }
                }
            }
        }

        // On affiche les messages ajoutés lors du traitement
        $display_msg_tab = array();
        if (empty($display_error_tab) === false) {
            $display_msg_tab = array_merge($display_msg_tab, $display_error_tab);
        }
        if (empty($display_ok_tab) === false) {
            $display_msg_tab = array_merge($display_msg_tab, $display_ok_tab);
        }
        if (empty($display_msg_tab) === false) {
            $this->setMessage(implode('\n', $display_msg_tab));
        }

        return $this->OK;
    }

    /**
     * Module de purge des fichiers orphelins.
     * Supprime les fichiers du filestorage dont l'identifiant n'est plus stocké en base
     * de données.
     *
     * ATTENTION : ce module n'est fonctionnel que pour le connecteur filesystem.
     *
     * @return void
     */
    public function purge_orphans_files_filesystem(){

        // vérification que le stockage des documents est bien effectué sur le filesystem
        require_once dirname(dirname(__DIR__)).'/core/om_filestorage_filesystem.class.php';
        if (! $this->f->storage->storage instanceof filestorage_filesystem) {
            $err_msg = "Stockage des documents effectué sur un support différent du filesystem";
            $this->setMessage($err_msg);
            return $this->KO;
        }

        $list_files_filesystem = $this->get_list_files_filesystem($this->f->storage->storage->path);
        $list_files_db = $this->get_list_files_db();
        $list_files_filesystem_to_delete = $this->compare_list_files($list_files_filesystem, $list_files_db);
        $delete_files_filesystem = $this->delete_files_filesystem($list_files_filesystem_to_delete);
        if ($delete_files_filesystem !== false) {
            $this->setMessage(sprintf(
                __("Suppression de %s fichiers orphelins."),
                $delete_files_filesystem
            ));
            return $this->OK;
        } else {
            $this->setMessage(__("Une erreur est survenue lors de la suppression des fichiers orphelins."));
            return $this->KO;
        }
    }

    /**
     * Compare les fichiers du filestorage avec les fichiers stockés en base de données.
     *
     * @param array $list_files_filesystem  Liste des fichiers du filestorage
     * @param array $list_files_db          Liste des fichiers en base de données
     *
     * @return array $list_files_filesystem_to_delete Liste des fichiers à supprimer
     *                                                dans le filestorage.
     */
    public function compare_list_files($list_files_filesystem ,$list_files_db){
        return array_unique(array_diff($list_files_filesystem, $list_files_db));
    }

    /**
     * Supprime les fichiers du filestorage n'étant pas présent dans la base de données.
     *
     * @param array $list_files_filesystem_to_delete  Liste des fichiers à supprimer dans
     *                                                le filestorage.
     *
     * @return integer $cpt  Nombre de fichier supprimés.
     */
    public function delete_files_filesystem($list_files_filesystem_to_delete){
        $cpt = 0;
        foreach ($list_files_filesystem_to_delete as $value) {
            // Supprime le fichier
            $delete_simple = $this->f->storage->storage->delete($value);
            if ($delete_simple === OP_FAILURE) {
                return false;
            }
            $cpt++;
        }
        return $cpt;
    }


    /**
     * Liste les fichiers présents dans le filestorage.
     *
     * @param string $path  Chemin du répertoire de stockage.
     *
     * @return array $files  Liste des fichiers du filestorage.
     */
    public function get_list_files_filesystem($path){
        $list = glob($path."*/*/*");
        $list_files_filesystem = array();
        foreach ($list as $l) {
            $filename = basename($l); 
            if(strlen($filename) == 32) {
                $list_files_filesystem[] = $filename;
            }
        }
        return array_unique($list_files_filesystem);
    }


    /**
     * Liste les fichiers présents dans la base de données.
     *
     * @return array tabFiles  Liste des fichiers de la base de données.
     */
    public function get_list_files_db($only_file = true){
        $list_files_db = array();
        //Réquête permettant de liste les fichiers
        $query = sprintf('
            SELECT
                instruction.om_fichier_instruction AS file,
                \'instruction\' AS object,
                instruction.instruction AS object_id,
                \'om_fichier_instruction\' AS field,
                instruction.dossier AS dossier
            FROM %1$sinstruction
            WHERE instruction.om_fichier_instruction IS NOT NULL
                AND instruction.om_fichier_instruction != \'OP_FAILURE\'
                AND instruction.om_fichier_instruction != \'\'
            UNION
            SELECT
                document_numerise.uid AS file,
                \'document_numerise\' AS object,
                document_numerise.document_numerise AS object_id,
                \'uid\' AS field,
                document_numerise.dossier AS dossier
            FROM %1$sdocument_numerise
            WHERE document_numerise.uid IS NOT NULL
                AND document_numerise.uid != \'OP_FAILURE\' 
                AND document_numerise.uid != \'\'
            UNION 
            SELECT
                consultation.fichier AS file,
                \'consultation\' AS object,
                consultation.consultation AS object_id,
                \'fichier\' AS field,
                consultation.dossier AS dossier
            FROM %1$sconsultation
            WHERE consultation.fichier IS NOT NULL
                AND consultation.fichier != \'OP_FAILURE\'
                AND consultation.fichier != \'\'
            UNION
            SELECT
                consultation.om_fichier_consultation AS file,
                \'consultation\' AS object,
                consultation.consultation AS object_id,
                \'om_fichier_consultation\' AS field,
                consultation.dossier AS dossier
            FROM %1$sconsultation
            WHERE consultation.om_fichier_consultation IS NOT NULL
                AND consultation.om_fichier_consultation != \'OP_FAILURE\'
                AND consultation.om_fichier_consultation != \'\'
            UNION
            SELECT
                commission.om_fichier_commission_ordre_jour AS file,
                \'commission\' AS object,
                commission.commission AS object_id,
                \'om_fichier_commission_ordre_jour\' AS field,
                \'\' AS dossier
            FROM %1$scommission
            WHERE commission.om_fichier_commission_ordre_jour IS NOT NULL
                AND commission.om_fichier_commission_ordre_jour != \'OP_FAILURE\'
                AND commission.om_fichier_commission_ordre_jour != \'\'
            UNION
            SELECT
                commission.om_fichier_commission_compte_rendu AS file,
                \'commission\' AS object,
                commission.commission AS object_id,
                \'om_fichier_commission_compte_rendu\' AS field,
                \'\' AS dossier
            FROM %1$scommission
            WHERE commission.om_fichier_commission_compte_rendu IS NOT NULL
                AND commission.om_fichier_commission_compte_rendu != \'OP_FAILURE\'
                AND commission.om_fichier_commission_compte_rendu != \'\'
            UNION
            SELECT
                storage.uid AS file,
                \'storage\' AS object,
                storage.storage AS object_id,
                \'uid\' AS field,
                \'\' AS dossier
            FROM %1$sstorage
            WHERE storage.uid IS NOT NULL
                AND storage.uid != \'OP_FAILURE\'
                AND storage.uid != \'\'
            UNION
            SELECT
                om_logo.fichier AS file,
                \'om_logo\' AS object,
                om_logo.om_logo AS object_id,
                \'fichier\' AS field,
                \'\' AS dossier
            FROM %1$som_logo
            WHERE om_logo.fichier IS NOT NULL
                AND om_logo.fichier != \'OP_FAILURE\'
                AND om_logo.fichier != \'\'
            UNION
            SELECT
                rapport_instruction.om_fichier_rapport_instruction AS file,
                \'rapport_instruction\' AS object,
                rapport_instruction.rapport_instruction AS object_id,
                \'om_fichier_rapport_instruction\' AS field,
                rapport_instruction.dossier_instruction AS dossier
            FROM %1$srapport_instruction
            WHERE rapport_instruction.om_fichier_rapport_instruction IS NOT NULL
                AND rapport_instruction.om_fichier_rapport_instruction != \'OP_FAILURE\'
                AND rapport_instruction.om_fichier_rapport_instruction != \'\'
            ',
            DB_PREFIXE
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            $this->setMessage(sprintf('%s %s', __("Erreur de base de donnees."), __("Contactez votre administrateur.")));
            return $this->KO;
        }
        foreach ($res['result'] as $value) {
            if ($only_file === false) {
                $list_files_db[$value['file']] = array(
                    'file' => $value['file'],
                    'object' => $value['object'],
                    'object_id' => $value['object_id'],
                    'field' => $value['field'],
                    'dossier' => $value['dossier']
                );
            } else {
                $list_files_db[] = $value['file'];
            }
        }
        if ($only_file === false) {
            return $list_files_db;
        } else {
            return array_unique($list_files_db);
        }
    }


    /**
     * Module d'identification des uids orphelins.
     * Identifie les références à des fichiers qui ne sont pas dans le stockage.
     *
     * ATTENTION : ce module n'est fonctionnel que pour le connecteur filesystem.
     *
     * @return void
     */
    public function get_uids_without_files() {

        // vérification que le stockage des documents est bien effectué sur le filesystem
        require_once dirname(dirname(__DIR__)).'/core/om_filestorage_filesystem.class.php';
        if (! $this->f->storage->storage instanceof filestorage_filesystem) {
            $err_msg = "Stockage des documents effectué sur un support différent du filesystem";
            $this->setMessage($err_msg);
            return $this->KO;
        }

        $list_files_filesystem = $this->get_list_files_filesystem($this->f->storage->storage->path);
        $list_files_db = $this->get_list_files_db(false);
        $list_files_db_to_compare = array();
        foreach ($list_files_db as $value) {
            $list_files_db_to_compare[] = $value['file'];
        }
        $list_files_db_without_filesystem = $this->compare_list_files($list_files_db_to_compare, $list_files_filesystem);
        if ($list_files_db_without_filesystem === array()) {
            $this->setMessage(__("Il n'y a aucune référence à des fichiers non existants."));
        } else {
            $list_files_db_without_filesystem_to_display = array();
            foreach ($list_files_db_without_filesystem as $value) {
                $list_files_db_without_filesystem_to_display[] = $list_files_db[$value];
            }
            $this->setMessage(sprintf(
                __("Liste des %s références à des fichiers non existants : %s"),
                count($list_files_db_without_filesystem),
                var_export($list_files_db_without_filesystem_to_display, true)
            ));
            $this->addToLog(var_export($list_files_db_without_filesystem_to_display, true), DEBUG_MODE);
        }
        return $this->OK;
    }
}

?>
