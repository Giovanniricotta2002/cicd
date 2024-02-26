<?php

// définition du chemin absolu vers la racine du projet
if (! defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__));
}

require_once dirname(dirname(__DIR__))."/obj/task.class.php";

/**
 * Classe qui traite les tâches de type 'DI'
 */
class TaskManager extends metiermanager
{
    /**
     * @var un cache pour stocker les infos des collectivités
     */
    protected $cacheCollectivites;

    /**
     * Pas implementé
     */
    protected function ajouter(&$data, $msg_OK = null, $msg_KO = null) {
        $this->setMessage('Pas implémenté');
        return $this->KO;
    }
    protected function modifier($data, $msg_OK = null, $msg_KO = null) {
        $this->setMessage('Pas implémenté');
        return $this->KO;
    }
    protected function supprimer(&$data, $msg_OK, $msg_KO) {
        $this->setMessage('Pas implémenté');
        return $this->KO;
    }

    /**
     * Renvoie le nom de la classe du 'processeur' permettant de traiter la tâche spécifiée.
     *
     * @param  $tache  La tâche à traiter.
     *
     * @return  Array & Callable  Une fonction appelable, pour traiter la tâche
     *
     * @throw  InvalidArgumentException  Lorsque que le type de tâche n'est pas supporté/invalide
     */
    protected function _getProcessorFromTache($tache) {
        switch($tache->getVal('type')) {
            case 'create_DI_for_consultation': return array($this, 'create_DI_for_consultation');
            case 'create_DI': return array($this, 'create_DI');
            case 'add_piece': return array($this, 'add_piece');
            case 'pec_metier_consultation': return array($this, 'pec_metier_consultation');
            case 'avis_consultation': return array($this, 'avis_consultation');
            case 'create_message': return array($this, 'create_message');
        }
        throw new InvalidArgumentException(sprintf(
            __("Type de tâche '%s' non supporté"), $tache->getVal('type')));
    }

    /**
     * Traite toutes les tâches, éventuellement seulement celles spécifiées par un type.
     *
     * @param  string  $statut  Un statut de tâche à traiter
     * @param  string  $type    Un type de tâche à traiter
     *
     * @return  Array  Un tableau contenant le récapitulatif des traitements
     *
     * @throw  RuntimeException  Lorsqu'il y a un échec pendant le traitement d'une tâche
     */
    public function traitement(array $requestData) {
        try {
            $this->addToLog(__METHOD__.'(): request data = '.var_export($requestData, true), VERBOSE_MODE);

            $statut = isset($requestData['statut']) ? $requestData['statut'] : task::STATUS_NEW;
            $type = isset($requestData['type']) ? $requestData['type'] : '';
            $category = isset($requestData['category']) ? $requestData['category'] : '';

            $this->addToLog(__METHOD__.'(): statut = '.var_export($statut, true).', '.
                        'type = '.var_export($type, true), VERBOSE_MODE);

            // vérification de la disponibilité du stockage des documents (GED en général)
            if (! $this->f->storage->is_service_available()) {
                $err_msg = __("Service de stockage des documents indisponible");
                $this->addToLog(__METHOD__."(): $err_msg", DEBUG_MODE);
                throw new Exception($err_msg);
            }

            // construit le filtre SQL (clause WHERE)
            $filtreSQL = "stream = 'input' AND json_payload <> '{}'";
            $filtreSQL .= sprintf(" AND state = '%s'", $this->f->db->escapeSimple($statut));;
            if (! empty($type)) {
                $filtreSQL .= sprintf(" AND type = '%s'", $this->f->db->escapeSimple($type));
            }
            if (empty($category) === false) {
                $filtreSQL .= sprintf(" AND category = '%s'", $this->f->db->escapeSimple($category));
            }

            // stocke le résultat et les succès/échecs
            $success = array();
            $failures = array();

            // pour chaque tâche
            foreach($this->f->getAllObjects('task', $filtreSQL) as $tache) {
                $desc = $this->_getTacheDesc($tache);
                $type = $tache->getVal('type');

                // selon le type de la tâche invoquer un "processeur"
                // qui réalisera le traitement de cette tâche
                // stocker les succès et les échecs
                if (empty($type)) {
                    $this->_setTaskState($tache, 'invalide');
                    $failures[$desc] = "Attribut 'type' vide";
                }
                else {
                    $processorCallable = $this->_getProcessorFromTache($tache);
                    if (isset($processorCallable[0]) != $this) {
                        $processorClass = $processorCallable[0].'.class.php';
                        $processorClassPath = PROJECT_ROOT.'/obj/'.$processorClass;
                        if (file_exists($processorClassPath)) {
                            require_once $processorClassPath;
                            $processor = new $processorName($this->f, $this->APILogger);
                            $processorMethod = isset($processorCallable[1]) ? $processorCallable[1] : 'process';
                            $processorCallable = array($processor, $processorMethod);
                        }
                    }
                    if (is_callable($processorCallable)) {
                        $this->_setTaskState($tache, task::STATUS_PENDING);
                        $result = array();
                        try {
                            $result = call_user_func_array($processorCallable, array($tache));
                        }
                        catch(Exception $exception) {
                            $result['error'] = get_class($exception).' : '.$exception->getMessage();
                        }
                        if (isset($result['error']) && ! empty($result['error'])) {
                            $this->_setTaskState($tache, task::STATUS_ERROR);
                            $failures[$desc] = $result['error'];
                        }
                        elseif ($result === false) {
                            $this->_setTaskState($tache, task::STATUS_ERROR);
                            $failures[$desc] = 'erreur';
                        }
                        else {
                            if ($type == 'create_DI') {
                                $this->_setTaskStateAndObjId($tache, task::STATUS_DONE, $result['dossier']);
                            } else {
                                $this->_setTaskState($tache, task::STATUS_DONE);
                            }
                            $success_message = 'succès';
                            if (is_array($result) && isset($result['message'])) {
                                $success_message = $result['message'];
                            }
                            $success[$desc] = $success_message;
                        }
                    }
                    else {
                        $this->_setTaskState($tache, 'invalide');
                        $failures[$desc] = "Processeur '".var_export($processorCallable, true)."' invalide pour la tâche '$desc'";
                    }
                }
            }

            // s'il y a eu des échecs de traitements
            if (! empty($failures)) {
                $this->addToLog(__METHOD__."(): il y a eu des échecs de traitements", DEBUG_MODE);

                // renvoyer un code HTTP adapté ainsi que les erreurs rencontrées
                $errorMsg = "Les tâches suivantes ont rencontrées un échec pendant leur traitement :\n";
                foreach($failures as $tacheDesc => $error) {
                    $this->addToLog(__METHOD__."(): * $tacheDesc => $error", DEBUG_MODE);
                    $errorMsg .= " - $tacheDesc: $error\n";
                }
                if(! empty($success)) {
                    $errorMsg .= "\nLes tâches suivantes ont été traitées avec succès :\n";
                    foreach($success as $tacheDesc => $msg) {
                        $this->addToLog(__METHOD__."(): * $tacheDesc => $msg", DEBUG_MODE);
                        $errorMsg .= " - $tacheDesc: $msg\n";
                    }
                }
                throw new RuntimeException($errorMsg);
            }

            // si tout s'est bien passé :
            // renvoyer un code HTTP adapté et le résultat obtenu (un tableau)
            $this->addToLog(__METHOD__."(): succès des traitements", VERBOSE_MODE);
            if (! empty($success)) {
                $this->setMessage(implode('\n', array_map(
                    function($desc, $msg) { return $desc.' : '.$msg; },
                    array_keys($success), $success)));
            }
            return $this->OK;
        }
        catch(InvalidArgumentException $exc) {
            $this->setMessage($exc->getMessage());
            return $this->BAD_DATA;
        }
        catch(Exception $exc) {
            $this->setMessage($exc->getMessage());
            return $this->KO;
        }
    }

    /**
     * Renvoie une description textuelle d'une tâche (composée de son ID, son type et le dossier).
     *
     * @param  $tache  La tâche concernée
     *
     * @return  string  la description textuelle de la tâche
     */
    protected function _getTacheDesc($tache) {
        return '['.$tache->getVal('task').'] '.$tache->getVal('type').' '.$tache->getVal('dossier');
    }

    /**
     * Met à jours l'état d'une tâche.
     *
     * @param  $tache  La tâche concernée
     *
     * @return taskProcessorDemande
     */
    protected function _setTaskState($tache, string $statut) {
        $tache->update_task(array('val' => array('state' => $statut)));
        return $this;
    }

    /**
     * Met à jours l'état et le champ object_id d'une tâche.
     *
     * @param  $tache   La tâche concernée
     * @param  $statut  Le statut de la tâche
     * @param  $dossier Le numéro de dossier lié à la tâche
     *
     * @return taskProcessorDemande
     */
    protected function _setTaskStateAndObjId($tache, string $statut, $dossier) {
        $tache->update_task(array('val' => array('state' => $statut), 'object_id' => $dossier));
        return $this;
    }

    /**
     * Traite les tâches de type 'creation_DI'.
     *
     * @param  $tache  La tâche à traiter
     *
     * @return Array|false  Un tableau contenant le résultat du traitement, false en cas d'erreur
     *
     * @throw InvalidArgumentException  En cas de donnée utilisateur invalide ou manquante
     * @throw RuntimeException          En cas d'erreur BDD
     */
    protected function create_DI_for_consultation($tache) {
        // TODO code présent dans create_DI_for_consultation, voir si on peut factoriser
        $this->addToLog(__METHOD__."(): Décode le json", VERBOSE_MODE);
        $request_data = json_decode($tache->getVal('json_payload'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(sprintf(
                __("échec du décodage JSON (%s)"),
                json_last_error_msg()));
        }

        $request_data['source_depot'] = PLATAU;
        if ($tache->getVal('category') === PORTAL) {
            //
            $request_data['source_depot'] = PORTAL;
        }
        
        $dossier_info = $this->add_new_demande($tache, $request_data);
        $dossier_instruction_id = $dossier_info['dossier_instruction_id'];
        $dossier_libelle = $dossier_info['dossier_libelle'];

        //
        if (isset($request_data['consultation']) === true
            && is_array($request_data['consultation']) === true
            && count($request_data['consultation']) > 0) {
            //
            $valF = $request_data['consultation'];
            $inst_ce = $this->f->get_inst__om_dbform(array(
                "obj" => "consultation_entrante",
                "idx" => ']',
            ));
            $valF['consultation_entrante'] = '';
            $valF['dossier'] = $dossier_instruction_id;
            $add = $inst_ce->ajouter($this->adapt_payload_values($inst_ce->table, $valF));
            $message = $inst_ce->msg;
            if ($add === false) {
                throw new RuntimeException(__("Erreur lors de la création de la consultation entrante.").' '.
                    sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $message))));
            }
        }

        // Ajout des données techniques dans le dossier d'instruction
        $dt_values = $this->prepare_donnees_techniques_data($request_data);
        if (count($dt_values) > 0) {
            $inst_dt_empty = $this->f->get_inst__om_dbform(array(
                "obj" => "donnees_techniques",
                "idx" => 0,
            ));
            $id_dt = $inst_dt_empty->get_id_by_dossier($dossier_instruction_id);
            $inst_dt = $this->f->get_inst__om_dbform(array(
                "obj" => "donnees_techniques",
                "idx" => $id_dt,
            ));
            $valF = array_combine($inst_dt->champs, $inst_dt->val);
            $valF = array_merge($valF, $dt_values);
            $inst_dt->setParameter('maj', 1);
            $edit = $inst_dt->modifier($this->adapt_payload_values($inst_dt->table, $valF));
            $message = $inst_dt->msg;
            if ($edit === false) {
                throw new RuntimeException(sprintf(
                    "%s %s",
                    sprintf(__("Erreur lors de la modification des données techniques du dossier d'instruction %s."), $dossier_libelle),
                    sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $message)))
                ));
            }
        }

        return array(
            "message" => sprintf(
                __("dossier instruction '%s' créé"),
                $dossier_libelle
            ),
        );
    }

    /**
     * Traite les tâches de type 'create_DI'.
     *
     * @param  $tache  La tâche à traiter
     *
     * @return Array|false  Un tableau contenant le résultat du traitement, false en cas d'erreur
     *
     * @throw InvalidArgumentException  En cas de donnée utilisateur invalide ou manquante
     * @throw RuntimeException          En cas d'erreur BDD
     */
    protected function create_DI($tache) {
        // TODO code présent dans create_DI_for_consultation, voir si on peut factoriser
        $this->addToLog(__METHOD__."(): Décode le json", VERBOSE_MODE);
        $request_data = json_decode($tache->getVal('json_payload'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(sprintf(
                __("échec du décodage JSON (%s)"),
                json_last_error_msg()));
        }

        $request_data['type_task'] = 'create_DI';

        $request_data['source_depot'] = PLATAU;
        if ($tache->getVal('category') === PORTAL) {
            //
            $request_data['source_depot'] = PORTAL;
        }

        $dossier_info = $this->add_new_demande($tache, $request_data);
        $dossier_instruction_id = $dossier_info['dossier_instruction_id'];
        $dossier_libelle = $dossier_info['dossier_libelle'];

        // Ajout des données techniques dans le dossier d'instruction
        $dt_values = $this->prepare_donnees_techniques_data($request_data);
        if (count($dt_values) > 0) {
            $inst_dt_empty = $this->f->get_inst__om_dbform(array(
                "obj" => "donnees_techniques",
                "idx" => 0,
            ));
            $id_dt = $inst_dt_empty->get_id_by_dossier($dossier_instruction_id);
            $inst_dt = $this->f->get_inst__om_dbform(array(
                "obj" => "donnees_techniques",
                "idx" => $id_dt,
            ));
            $valF = array_combine($inst_dt->champs, $inst_dt->val);
            $valF = array_merge($valF, $dt_values);
            $inst_dt->setParameter('maj', 1);
            $edit = $inst_dt->modifier($this->adapt_payload_values($inst_dt->table, $valF));
            $message = $inst_dt->msg;
            if ($edit === false) {
                throw new RuntimeException(sprintf(
                    "%s %s",
                    sprintf(__("Erreur lors de la modification des données techniques du dossier d'instruction %s."), $dossier_libelle),
                    sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $message)))
                ));
            }
        }

        return array(
            "message" => sprintf(
                __("dossier instruction '%s' créé"),
                $dossier_libelle
            ),
            "dossier" => $dossier_instruction_id,
        );
    }

    /**
     * Permet d'ajouter la demande à partir d'une tâche entrante.
     * 
     * @param  $tache         La tâche à traiter.
     * @param  $request_data  Le payload de la tâche décodé.
     * 
     * @return Array  Un tableau contenant l'identifiant du dossier et sont libellé.
     * @throw InvalidArgumentException  En cas de donnée utilisateur invalide ou manquante
     */
    protected function add_new_demande($tache, $request_data) {

        global $_POST;

        // TODO gérer l'ajout de demande sur existant
        // (on ne connait pas le format des données arrivant)

        // ajout d'une nouvelle demande
        // retraitement spécifique des données de la nouvelle demande
        $this->addToLog(__METHOD__."(): Prépare les données de la nouvelle demande", VERBOSE_MODE);
        $demande_values = $this->prepare_new_demande_data($request_data);

        // retraitement commun des données de la demande
        $this->addToLog(__METHOD__."(): Prépare les données de la demande", VERBOSE_MODE);
        $demande_values = $this->prepare_demande_data($request_data, $demande_values);

        // vérification des externals UUIDs
        if (! isset($request_data['external_uids']) || empty($request_data['external_uids'])) {
            throw new InvalidArgumentException(sprintf(
                __("Aucune valeur pour le paramètre '%s'"),
                'external_uids'));
        }

        // utilisation d'un faux $_POST pour stocker les demandeurs de la demande
        $_POST = array();

        // Récupération du type de la demande
        $inst_demande_type = null;
        if (isset($demande_values['demande_type']) === true
            && empty($demande_values['demande_type']) === false) {
            //
            $inst_demande_type = $this->f->get_inst__om_dbform(array(
                "obj" => "demande_type",
                "idx" => $demande_values['demande_type'],
            ));
        }

        // Récupération du dossier d'autorisation s'il s'agit d'une demande sur existant
        $inst_da = null;
        if (isset($demande_values['dossier_autorisation']) === true
            && empty($demande_values['dossier_autorisation']) === false) {
            //
            $inst_da = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_autorisation",
                "idx" => $demande_values['dossier_autorisation'],
            ));
        }

        // Vérification du type de demande pour la gestion de l'adresse du terrain
        // et des demandeurs
        $create_all_demandeurs = true;
        $create_only_others_demandeurs = false;
        $get_exists_demandeurs = false;
        if ($inst_demande_type !== null) {
            // En cas de dépôt sur dossier existant
            if (intval($inst_demande_type->getVal('demande_nature')) === 2) {
                // L'adresse du terrain est récupérée depuis l'autorisation
                if ($inst_da !== null) {
                    foreach ($inst_da->champs as $field) {
                        if (strpos($field, "terrain_") === 0) {
                            $demande_values[$field] = $inst_da->getVal($field);
                        }
                    }
                }
                // Gestion des demandeurs
                if ($inst_demande_type->getVal('dossier_instruction_type') === null
                    || $inst_demande_type->getVal('dossier_instruction_type') === '') {
                    // Si la demande n'ajoute pas de dossier d'instruction, alors
                    // aucun demandeur n'est ajouté
                    $create_all_demandeurs = false;
                } else {
                    // Si la demande ajoute une nouveau dossier d'instruction, alors
                    // par défaut récupère les demandeurs du DA
                    $get_exists_demandeurs = true;
                    switch ($inst_demande_type->getVal('contraintes')) {
                        // Récupération des demandeurs sans modification avec ajout
                        case 'avec_r_sm_aa':
                            $create_all_demandeurs = false;
                            $create_only_others_demandeurs = true;
                            break;
                        // Récupération des demandeurs sans modification ni ajout
                        case 'avec_r_sma':
                            $create_all_demandeurs = false;
                            break;
                        // Sans récupération des demandeurs
                        case 'sans_recup':
                            $get_exists_demandeurs = false;
                            break;
                    }
                }
            }
        }

        // Ajout des demandeurs (même le principal)
        // ou ajout des demandeurs (excepté le principal)
        if ($create_all_demandeurs === true
            || $create_only_others_demandeurs === true) {
            //
            $this->addToLog(__METHOD__."(): Créé les demandeurs", VERBOSE_MODE);
            if (! isset($request_data['demandeur']) && ! empty($request_data['demandeur'])) {
                throw new InvalidArgumentException(sprintf(
                    __("Aucune valeur pour le paramètre '%s'"),
                    'demandeur'));
            }
            foreach ($request_data["demandeur"] as $d_index => $demandeur_valeurs) {
                if (! isset($demandeur_valeurs['type_demandeur']) ||
                        empty($demandeur_valeurs['type_demandeur'])) {
                    throw new InvalidArgumentException(sprintf(
                        __("Aucun type pour le demandeur '%s'"), $d_index));
                }
                $demandeur_type = $demandeur_valeurs['type_demandeur'];
                // La gestion du demandeur principal se fait seulement dans le cas
                // d'ajout de tout les demandeurs
                if ($create_all_demandeurs === true
                    && isset($demandeur_valeurs["${demandeur_type}_principal"])
                    && $demandeur_valeurs["${demandeur_type}_principal"] === 't') {
                    //
                    $demandeur_type = "${demandeur_type}_principal";
                    $demandeur_valeurs['type_demandeur'] = $demandeur_type;
                }
                $demandeur_id = $this->creation_demandeur(
                    $demandeur_type, $demandeur_valeurs, $demande_values['om_collectivite']);
                if (isset($_POST[$demandeur_type]) === false) {
                    $_POST[$demandeur_type] = array();
                }
                $_POST[$demandeur_type][] = $demandeur_id;
            }
        }

        // Récupération des demandeurs du dossier d'autorisation
        if ($get_exists_demandeurs === true) {
            // Récupère la liste des demandeurs
            $list_demandeur = $inst_da->get_list_demandeur('dossier_autorisation', $inst_da->getVal($inst_da->clePrimaire));
            foreach ($list_demandeur as $demandeur_valeurs) {
                $demandeur_type = $demandeur_valeurs['type_demandeur'];
                // Gestion du demandeur principal
                if ($demandeur_valeurs["petitionnaire_principal"] === 't') {
                    // Si dans la récupération des demandeur il y a un principal
                    // et que la nouvelle demande apporte un nouveau principal,
                    // alors le principal existant n'est pas récupéré
                    if (isset($_POST["${demandeur_type}_principal"]) === true) {
                        continue;
                    }
                    // Sinon le principal existant est récupéré
                    $demandeur_type = "${demandeur_type}_principal";
                }
                $_POST[$demandeur_type][] = $demandeur_valeurs['demandeur'];
            }
        }

        //
        $demande_values['source_depot'] = PLATAU;
        if (isset($request_data['source_depot']) === true
            && $request_data['source_depot'] !== ''
            && $request_data['source_depot'] !== null) {
            //
            $demande_values['source_depot'] = $request_data['source_depot'];
        }

        $demande_values['etat_transmission_platau'] = 'non_transmissible';
        if (isset($demande_values['source_depot']) === true
            && ($demande_values['source_depot'] == PLATAU
                || $demande_values['source_depot'] == PORTAL)) {
            //
            $demande_values['etat_transmission_platau'] = 'transmissible';
        }

        // création de l'objet demande
        $demande = $this->f->get_inst__om_dbform(array(
            "obj" => "demande",
            "idx" => "]",
        ));

        // Prise en compte des faux POST
        $this->f->submitted_post_value = array();
        $this->f->set_submitted_value();
        $demande->getPostedValues();

        $this->addToLog(__METHOD__."(): Ajoute la demande", VERBOSE_MODE);
        if ($demande->ajouter($this->adapt_payload_values($demande->table, $demande_values)) === false) {
            throw new RuntimeException(__("Erreur lors de la création de la demande."));
        }
        elseif ($demande->correct === false) {
            throw new RuntimeException(__("Erreur lors de la création de la demande.").' '.
                sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $demande->msg))));
        }
        $dossier_info = array();
        $dossier_instruction_id = $demande->getVal('dossier_instruction');
        $dossier_autorisation_id = $demande->getVal('dossier_autorisation');
        $instruction_recepisse_id = $demande->getVal('instruction_recepisse');
        $this->addToLog(__METHOD__."(): DI créé: '$dossier_instruction_id'", VERBOSE_MODE);

        if (empty($di_inst = $this->f->findObjectById('dossier', $dossier_instruction_id))) {
            throw new RuntimeException(
                "Erreur après la création du DI: dossier '$dossier_instruction_id' non-trouvé");
        }
        $dossier_libelle = $di_inst->getVal('dossier_libelle');
        $this->addToLog(__METHOD__."(): Libellé: '$dossier_libelle'", VERBOSE_MODE);

        $dossier_info['dossier_instruction_id'] = $dossier_instruction_id;
        $dossier_info['dossier_libelle'] = $dossier_libelle;
        $dossier_info['instruction_recepisse_id'] = $instruction_recepisse_id;
        //
        $objects = $tache->get_objects_by_task_type($tache->getVal('type'), $tache->getVal('stream'));
        if (is_array($request_data['external_uids']) === true) {
            //
            foreach ($request_data['external_uids'] as $object => $external_uid) {
                // Dans le cas d'un dossier sur existant, si le dossier d'autorisation est
                // présent dans les externals UID, alors on ne le traite pas
                if ($object === 'dossier_autorisation'
                    && isset($request_data['demande']["type_demande"]) === true
                    && $request_data['demande']["type_demande"] !== 'initial') {
                    //
                    continue;
                }
                // Gestion de l'identifiant de l'objet
                $object_id = $object == 'dossier_autorisation' ? $dossier_autorisation_id : $dossier_instruction_id;
                // Dans le cas où la demande ne créée pas de nouveau dossier d'instruction
                // l'identifiant est une instruction
                if ($instruction_recepisse_id !== null
                    && $instruction_recepisse_id !== '') {
                    //
                    $inst_demande_type = $this->f->get_inst__om_dbform(array(
                        "obj" => "demande_type",
                        "idx" => $demande->getVal('demande_type'),
                    ));
                    if ($inst_demande_type->getVal('dossier_instruction_type') === null
                        || $inst_demande_type->getVal('dossier_instruction_type') === '') {
                        //
                        $object_id = $instruction_recepisse_id;
                    }
                }
                //
                if (in_array($object, $objects) === true
                    || ($object === 'code-suivi')) {
                    //
                    $inst_lien = $this->f->get_inst__om_dbform(array(
                        "obj" => "lien_id_interne_uid_externe",
                        "idx" => ']',
                    ));
                    if ($inst_lien->is_exists($object, $dossier_instruction_id, $external_uid, $dossier_instruction_id) === false) {
                        //
                        $valF = array(
                            'lien_id_interne_uid_externe' => '',
                            'object' => $object,
                            'object_id' => $object_id,
                            'external_uid' => $external_uid,
                            'dossier' => $dossier_instruction_id,
                            'category' => $tache->getVal('category'),
                        );
                        $add = $inst_lien->ajouter($this->adapt_payload_values($inst_lien->table, $valF));
                        $message = $inst_lien->msg;
                        if ($add === false) {
                            throw new RuntimeException(__("Erreur lors de la création des liens de la demande.").' '.
                                sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $message))));
                        }
                    }
                }
            }
        }

        return $dossier_info;
    }

    /**
     * Traite les tâches de type 'add_piece'.
     *
     * @param  $tache  La tâche à traiter
     *
     * @return Array|false  Un tableau contenant le résultat du traitement, false en cas d'erreur
     *
     * @throw InvalidArgumentException  Si le DA existe déjà ou si le numéro dossier est invalide
     * @throw RuntimeException          En cas d'erreur BDD
     */
    protected function add_piece($tache) {

        $this->addToLog(__METHOD__."(): Décode le json", VERBOSE_MODE);
        $request_data = json_decode($tache->getVal('json_payload'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException("échec du décodage JSON (".json_last_error_msg().')');
        }

        // vérification de la présence des externals UUIDs
        if (! isset($request_data['external_uids']) || empty($request_data['external_uids'])) {
            throw new InvalidArgumentException(__(
                "Aucune valeur pour l'external_uids"));
        }

        //
        $collectiviteId = null;
        if ($tache->getVal('category') !== PORTAL) {
            // vérification de la présence du numéro de dossier
            if(! isset($request_data['external_uids']['dossier']) ||
                   empty($request_data['external_uids']['dossier'])) {
                throw new InvalidArgumentException(__("L'attribut external_uids.dossier n'est pas présent."));
            }

            // récupération de l'identifiant de collectivité
            $collectiviteId = $this->get_collectivite_id_from_acteur_or_collectivite($request_data);
        }

        // il faut que le dossier existe pour qu'on puis ajouter la pièce
        $this->addToLog(__METHOD__."(): Vérification de l'existance du dossier", VERBOSE_MODE);

        // Comme la numérotation du dossier peut être différente entre le numéro de dossier openads et le numéro
        // de dossier envoyé par Plat'AU on se base sur l'external uid pour vérifier si le dossier existe

        // On instancie l'objet lien_id_interne_uid_externe
        $inst_lien = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_id_interne_uid_externe",
            "idx" => 0,
        ));

        // instanciation d'un document numérisé "vide"
        $this->addToLog(__METHOD__."(): \tInitialise une instance de 'document_numerise'", VERBOSE_MODE);
        $document_numerise = $this->f->get_inst__om_dbform(array(
            "obj" => "document_numerise",
            "idx" => "]",
        ));

        // retraitement spécifique des données de la nouvelle pièce
        $this->addToLog(__METHOD__."(): Prépare les données de la nouvelle piece", VERBOSE_MODE);
        $attachment_values = $this->prepare_attachment_data(
            $request_data, $document_numerise, $inst_lien, $collectiviteId, $tache->getVal('category'));

        // Permet de spécifier que l'ajout de la pièce s'effectue à partir d'une tâche input
        $_POST['external_uid_piece'] = $request_data['external_uids']['piece'];

        $this->addToLog(__METHOD__."(): Ajoute la pièce", VERBOSE_MODE);
        $this->addToLog(__METHOD__."(): Valeurs:\n---\n".var_export($attachment_values, true)."\n---\n", VERBOSE_MODE);
        if ($document_numerise->ajouter($this->adapt_payload_values($document_numerise->table, $attachment_values)) === false) {
            throw new RuntimeException(
                __("Erreur lors de la création de la pièce.").' '.
                sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $document_numerise->msg))));
        }
        elseif ($document_numerise->correct === false) {
            throw new RuntimeException(__("Erreur lors de la création de la pièce.").' '.
                sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $document_numerise->msg))));
        }

        $document_numerise_id = $document_numerise->getVal('document_numerise');
        $this->addToLog(__METHOD__."(): pièce créée: '$document_numerise_id'", VERBOSE_MODE);

        //
        $objects = $tache->get_objects_by_task_type($tache->getVal('type'), $tache->getVal('stream'));
        if (is_array($request_data['external_uids']) === true) {
            //
            foreach ($request_data['external_uids'] as $object => $external_uid) {
                //
                if (in_array($object, $objects) === true) {
                    //
                    $inst_lien = $this->f->get_inst__om_dbform(array(
                        "obj" => "lien_id_interne_uid_externe",
                        "idx" => ']',
                    ));
                    if ($inst_lien->is_exists($object, $document_numerise_id, $external_uid, $attachment_values['dossier']) === false) {
                        //
                        $valF = array(
                            'lien_id_interne_uid_externe' => '',
                            'object' => $object,
                            'object_id' => $document_numerise_id,
                            'external_uid' => $external_uid,
                            'dossier' => $attachment_values['dossier'],
                            'category' => $tache->getVal('category'),
                        );
                        $add = $inst_lien->ajouter($this->adapt_payload_values($inst_lien->table, $valF));
                        $message = $inst_lien->msg;
                        if ($add === false) {
                            throw new RuntimeException(__("Erreur lors de la création de la pièce.").' '.
                                sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $message))));
                        }
                    }
                }
            }
        }

        return array(
            "message" => sprintf(
                __("pièce : '%s' créée sur le dossier d'instruction '%s'"),
                $document_numerise_id,
                $attachment_values['dossier']
            ),
        );
    }

    /**
     * Traite les tâches de type 'pec_metier_consultation'.
     *
     * @param  $tache  La tâche à traiter
     *
     * @return Array|false  Un tableau contenant le résultat du traitement, false en cas d'erreur
     *
     * @throw InvalidArgumentException  En cas de donnée utilisateur invalide ou manquante
     * @throw RuntimeException          En cas d'erreur BDD
     */
    protected function pec_metier_consultation($tache) {
        $this->addToLog(__METHOD__."(): Décode le json", VERBOSE_MODE);
        $request_data = json_decode($tache->getVal('json_payload'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(sprintf(__("échec du décodage JSON (%s)"), json_last_error_msg()));
        }

        // vérification de la présence des externals UUIDs
        if (! isset($request_data['external_uids']) || empty($request_data['external_uids'])) {
            throw new InvalidArgumentException(__("Aucune valeur pour l'external_uids"));
        }

        // On instancie l'objet lien_id_interne_uid_externe
        $inst_lien = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_id_interne_uid_externe",
            "idx" => 0,
        ));

        $dossier_id = $inst_lien->get_id_dossier_from_external_uid_without_collectivite(
            $request_data['external_uids']['dossier']
        );
        if (empty($dossier_id) === true) {
            throw new InvalidArgumentException(sprintf(
                __("Le dossier %s n'existe pas."),
                $request_data['external_uids']['dossier']
            ));
        }

        $consultation_id = $inst_lien->get_id_consultation_from_external_uid(
            $request_data['external_uids']['consultation'],
            $dossier_id
        );
        if (empty($consultation_id) === true) {
            throw new InvalidArgumentException(sprintf(
                __("La consultation %s n'existe pas."),
                $request_data['external_uids']['consultation']
            ));
        }

        //
        $inst_consultation = $this->f->get_inst__om_dbform(array(
            "obj" => "consultation",
            "idx" => $consultation_id,
        ));
        $valF = array();
        foreach($inst_consultation->champs as $id => $champ) {
            $valF[$champ] = $inst_consultation->val[$id];
        }

        if (isset($request_data['document_numerise']) === true
            && empty($request_data['document_numerise']) === false) {
            // Récupération du document
            $file = $this->f->storage->get($request_data['document_numerise']['uid']);
            if ($file === null || $file === OP_FAILURE) {
                throw new RuntimeException(sprintf(
                    __("Erreur lors de la récupération du document %s."),
                    $request_data['document_numerise']['uid']
                ));
            }
            // Préparation des métadonnées du document
            $new_metadata = $inst_consultation->getMetadata('fichier_pec');
            $metadata = array_merge($file['metadata'], $new_metadata);
            // On précise par le dernier paramètre qu'on est sur une pec
            $metadata['filename'] = $inst_consultation->generate_filename($request_data['document_numerise']['uid'], null, null, true);
            // Si le document est stocké dans le stockage alternatif
            if (strpos($request_data['document_numerise']['uid'], $this->f->storage::ALTFS_SEP) !== false) {
                // Création du document dans le stockage principal
                $uid = $this->f->storage->create($file['file_content'], $metadata, "from_content");
                if ($uid === null || $uid === OP_FAILURE) {
                    throw new RuntimeException(sprintf(
                        __("Erreur lors de la création du document %s depuis le stockage alternatif vers le stockage principal."),
                        $request_data['document_numerise']['uid']
                    ));
                }
                // Suppression du document dans le stockage alternatif
                $delete = $this->f->storage->delete($request_data['document_numerise']['uid']);
                if ($delete === null || $delete === OP_FAILURE) {
                    throw new RuntimeException(sprintf(
                        __("Erreur lors de la suppression du document %s du stockage alternatif."),
                        $request_data['document_numerise']['uid']
                    ));
                }
            } else {
                $uid = $this->f->storage->update_metadata($request_data['document_numerise']['uid'], $metadata);
                if ($uid === null || $uid === OP_FAILURE) {
                    throw new RuntimeException(sprintf(
                        __("Erreur lors de la mise à jour du document %s."),
                        $request_data['document_numerise']['uid']
                    ));
                }
            }
            // Modification de l'uid passé à document_numerise
            $valF['fichier_pec'] = $uid;
        }

        $valF['date_reception'] = $request_data['pec_metier']['date_reception'];
        if ($request_data['pec_metier']['statut_pec_metier'] === '2') {
            $inst_pec = $this->f->get_inst__om_dbform(array(
                "obj" => "pec_metier",
                "idx" => $request_data['pec_metier']['statut_pec_metier'],
            ));
            //
            $valF['date_retour'] = $request_data['pec_metier']['date_pec_metier'];
            //
            $types_pieces_manquantes = array();
            if (empty($request_data['pec_metier']['types_pieces_manquantes']) === false) {
                $inst_dn = $this->f->get_inst__om_dbform(array(
                    "obj" => "document_numerise",
                    "idx" => 0,
                ));
                foreach ($request_data['pec_metier']['types_pieces_manquantes'] as $dnt_code) {
                    $dnt_idx = $inst_dn->get_document_numerise_type_id_by_code($dnt_code);
                    $inst_dnt = $this->f->get_inst__om_dbform(array(
                        "obj" => "document_numerise_type",
                        "idx" => $dnt_idx,
                    ));
                    $inst_dossier = $this->f->get_inst__om_dbform(array(
                        "obj" => "dossier",
                        "idx" => $dossier_id,
                    ));
                    $dit_id = $inst_dossier->getVal('dossier_instruction_type');
                    $types_pieces_manquantes[] = $inst_dn->get_libelle_piece_avec_nomenclature($inst_dnt->getVal('libelle'), $dnt_idx, $dit_id);
                }
            }
            $valF['motif_pec'] = sprintf(
                "%s%s%s",
                $inst_pec->getVal('libelle'),
                $request_data['pec_metier']['texte_observations'] !== '' ? sprintf('<br><br>%s', $request_data['pec_metier']['texte_observations']) : '',
                $types_pieces_manquantes !== array() ? sprintf("<br><br>%s :<br/>* %s", __("Pièces manquantes"), implode('<br/>* ', $types_pieces_manquantes)) : ''
            );
            $valF['avis_consultation'] = 1; // Défavorable
        }
        if ($request_data['pec_metier']['statut_pec_metier'] === '3') {
            $inst_pec = $this->f->get_inst__om_dbform(array(
                "obj" => "pec_metier",
                "idx" => $request_data['pec_metier']['statut_pec_metier'],
            ));
            //
            $valF['date_retour'] = $request_data['pec_metier']['date_pec_metier'];
            $valF['motif_pec'] = sprintf(
                "%s<br/>%s",
                $inst_pec->getVal('libelle'),
                $request_data['pec_metier']['texte_observations']
            );
            $valF['avis_consultation'] = 5; // Autre
        }
        // On set la paramètre maj à 100 pour utiliser l'action 100 "retour_consultation"
        // qui permet de mettre à jour la consultation et quelle soit "non lu"
        $inst_consultation->setParameter("maj", 100);
        $edit = $inst_consultation->modifier($this->adapt_payload_values($inst_consultation->table, $valF));
        $message = $inst_consultation->msg;
        if ($edit === false) {
            throw new RuntimeException(sprintf(
                "%s %s",
                sprintf(__("Erreur lors de la mise à jour de la consultation %s."), $consultation_id),
                sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $message)))
            ));
        }

        //
        $objects = $tache->get_objects_by_task_type($tache->getVal('type'), $tache->getVal('stream'));
        if (is_array($request_data['external_uids']) === true) {
            //
            foreach ($request_data['external_uids'] as $object => $external_uid) {
                //
                if (in_array($object, $objects) === true) {
                    //
                    $inst_lien = $this->f->get_inst__om_dbform(array(
                        "obj" => "lien_id_interne_uid_externe",
                        "idx" => ']',
                    ));
                    if ($inst_lien->is_exists($object, $consultation_id, $external_uid, $dossier_id) === false) {
                        //
                        $valF = array(
                            'lien_id_interne_uid_externe' => '',
                            'object' => $object,
                            'object_id' => $consultation_id,
                            'external_uid' => $external_uid,
                            'dossier' => $dossier_id,
                            'category' => $tache->getVal('category'),
                        );
                        $add = $inst_lien->ajouter($this->adapt_payload_values($inst_lien->table, $valF));
                        $message = $inst_lien->msg;
                        if ($add === false) {
                            throw new RuntimeException(sprintf(
                                "%s %s",
                                sprintf(__("Erreur lors de la sauvegarde des uid externes pour la prise en compte métier de la consultation %s."), $consultation_id),
                                sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $message)))
                            ));
                        }
                    }
                }
            }
        }

        return array(
            "message" => sprintf(
                __("Consultation : '%s' mise à jour sur le dossier '%s'"),
                $consultation_id,
                $dossier_id
            ),
        );
    }

    /**
     * Traite les tâches de type 'avis_consultation'.
     *
     * @param  $tache  La tâche à traiter
     *
     * @return Array|false  Un tableau contenant le résultat du traitement, false en cas d'erreur
     *
     * @throw InvalidArgumentException  En cas de donnée utilisateur invalide ou manquante
     * @throw RuntimeException          En cas d'erreur BDD
     */
    protected function avis_consultation($tache) {
        $this->addToLog(__METHOD__."(): Décode le json", VERBOSE_MODE);
        $request_data = json_decode($tache->getVal('json_payload'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(sprintf(__("échec du décodage JSON (%s)"), json_last_error_msg()));
        }

        // vérification de la présence des externals UUIDs
        if (! isset($request_data['external_uids']) || empty($request_data['external_uids'])) {
            throw new InvalidArgumentException(__("Aucune valeur pour l'external_uids"));
        }

        // On instancie l'objet lien_id_interne_uid_externe
        $inst_lien = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_id_interne_uid_externe",
            "idx" => 0,
        ));

        $dossier_id = $inst_lien->get_id_dossier_from_external_uid_without_collectivite(
            $request_data['external_uids']['dossier']
        );
        if (empty($dossier_id) === true) {
            throw new InvalidArgumentException(sprintf(
                __("Le dossier %s n'existe pas."),
                $request_data['external_uids']['dossier']
            ));
        }

        $consultation_id = $inst_lien->get_id_consultation_from_external_uid(
            $request_data['external_uids']['consultation'],
            $dossier_id
        );
        if (empty($consultation_id) === true) {
            throw new InvalidArgumentException(sprintf(
                __("La consultation %s n'existe pas."),
                $request_data['external_uids']['consultation']
            ));
        }

        //
        $inst_consultation = $this->f->get_inst__om_dbform(array(
            "obj" => "consultation",
            "idx" => $consultation_id,
        ));
        $valF = array();
        foreach($inst_consultation->champs as $id => $champ) {
            $valF[$champ] = $inst_consultation->val[$id];
        }
        $valF['date_retour'] = $request_data['avis']['date_avis'];
        $valF['texte_fondement_avis'] = $request_data['avis']['texte_fondement_avis'];
        $valF['texte_avis'] = $request_data['avis']['texte_avis'];
        $valF['texte_hypotheses'] = $request_data['avis']['texte_hypotheses'];
        $valF['nom_auteur'] = $request_data['avis']['nom_auteur'];
        $valF['prenom_auteur'] = $request_data['avis']['prenom_auteur'];
        $valF['qualite_auteur'] = $request_data['avis']['qualite_auteur'];
        if (isset($request_data['document_numerise']) === true
            && empty($request_data['document_numerise']) === false) {
            // Récupération du document
            $file = $this->f->storage->get($request_data['document_numerise']['uid']);
            if ($file === null || $file === OP_FAILURE) {
                throw new RuntimeException(sprintf(
                    __("Erreur lors de la récupération du document %s."),
                    $request_data['document_numerise']['uid']
                ));
            }
            // Préparation des métadonnées du document
            $new_metadata = $inst_consultation->getMetadata('fichier');
            $metadata = array_merge($file['metadata'], $new_metadata);
            $metadata['filename'] = $inst_consultation->generate_filename($request_data['document_numerise']['uid']);
            // Si le document est stocké dans le stockage alternatif
            if (strpos($request_data['document_numerise']['uid'], $this->f->storage::ALTFS_SEP) !== false) {
                // Création du document dans le stockage principal
                $uid = $this->f->storage->create($file['file_content'], $metadata, "from_content");
                if ($uid === null || $uid === OP_FAILURE) {
                    throw new RuntimeException(sprintf(
                        __("Erreur lors de la création du document %s depuis le stockage alternatif vers le stockage principal."),
                        $request_data['document_numerise']['uid']
                    ));
                }
                // Suppression du document dans le stockage alternatif
                $delete = $this->f->storage->delete($request_data['document_numerise']['uid']);
                if ($delete === null || $delete === OP_FAILURE) {
                    throw new RuntimeException(sprintf(
                        __("Erreur lors de la suppression du document %s du stockage alternatif."),
                        $request_data['document_numerise']['uid']
                    ));
                }
            } else {
                $uid = $this->f->storage->update_metadata($request_data['document_numerise']['uid'], $metadata);
                if ($uid === null || $uid === OP_FAILURE) {
                    throw new RuntimeException(sprintf(
                        __("Erreur lors de la mise à jour du document %s."),
                        $request_data['document_numerise']['uid']
                    ));
                }
            }
            // Modification de l'uid passé à document_numerise
            $valF['fichier'] = $uid;
        }
        $valF['avis_consultation'] = $this->get_avis_consultation_id_by_code($request_data['avis']['avis_consultation']);
        if ($valF['avis_consultation'] === false) {
            throw new InvalidArgumentException(sprintf(
                __("échec de la récupération de l'identifiant de l'avis de consultation depuis le code '%s'."),
                $request_data['avis']['avis_consultation']
            ));
        }
        $this->addToLog(__METHOD__."(): Valeurs:\n---\n".var_export($valF, true)."\n---\n", VERBOSE_MODE);
        // On set la paramètre maj à 100 pour utiliser l'action 100 "retour_consultation"
        // qui permet de mettre à jour la consultation et quelle soit "non lu"
        $inst_consultation->setParameter("maj", 100);
        $edit = $inst_consultation->modifier($this->adapt_payload_values($inst_consultation->table, $valF));
        $message = $inst_consultation->msg;
        if ($edit === false) {
            throw new RuntimeException(sprintf(
                "%s %s",
                sprintf(__("Erreur lors de la mise à jour de la consultation %s."), $consultation_id),
                sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $message)))
            ));
        }

        //
        $objects = $tache->get_objects_by_task_type($tache->getVal('type'), $tache->getVal('stream'));
        if (is_array($request_data['external_uids']) === true) {
            //
            foreach ($request_data['external_uids'] as $object => $external_uid) {
                //
                if (in_array($object, $objects) === true) {
                    //
                    $inst_lien = $this->f->get_inst__om_dbform(array(
                        "obj" => "lien_id_interne_uid_externe",
                        "idx" => ']',
                    ));
                    if ($inst_lien->is_exists($object, $consultation_id, $external_uid, $dossier_id) === false) {
                        //
                        $valF = array(
                            'lien_id_interne_uid_externe' => '',
                            'object' => $object,
                            'object_id' => $consultation_id,
                            'external_uid' => $external_uid,
                            'dossier' => $dossier_id,
                            'category' => $tache->getVal('category'),
                        );
                        $add = $inst_lien->ajouter($this->adapt_payload_values($inst_lien->table, $valF));
                        $message = $inst_lien->msg;
                        if ($add === false) {
                            throw new RuntimeException(sprintf(
                                "%s %s",
                                sprintf(__("Erreur lors de la sauvegarde des uid externes pour l'avis de la consultation %s."), $consultation_id),
                                sprintf(__("Détail: %s"), strip_tags(str_replace('<br />', '. ', $message)))
                            ));
                        }
                    }
                }
            }
        }

        return array(
            "message" => sprintf(
                __("Consultation : '%s' mise à jour sur le dossier '%s'"),
                $consultation_id,
                $dossier_id
            ),
        );
    }

    /**
     * 
     */
    protected function create_message($tache) {
        // Récupère et decode le json
        // TODO code présent dans creéate_DI et create_DI_for_consultation, voir si on peut factoriser
        $this->addToLog(__METHOD__."(): Décode le json", VERBOSE_MODE);
        $request_data = json_decode($tache->getVal('json_payload'), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(sprintf(
                __("échec du décodage JSON (%s)"),
                json_last_error_msg()));
        }
        // Vérification de la présence des externals UIDS
        if (! isset($request_data['external_uids']) || empty($request_data['external_uids'])) {
            throw new InvalidArgumentException(sprintf(
                __("Aucune valeur pour le paramètre '%s'"),
                'external_uids'));
        }
        // Vérification de la présence de l'uid du dossier
        if (! isset($request_data['external_uids']['dossier']) || empty($request_data['external_uids']['dossier'])) {
            throw new InvalidArgumentException(__("L'attribut external_uids.dossier n'est pas présent."));
        }
        // Récupération de l'id du dossier
        $inst_lien = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_id_interne_uid_externe",
            "idx" => ']',
        ));
        $external_uid = $request_data['external_uids']['dossier'];
        $idDossier = $inst_lien->get_id_dossier_from_external_uid_without_collectivite($external_uid);
        if (empty($idDossier)) {
            throw new InvalidArgumentException(
                sprintf(
                    __("Échec de l'obtention du dossier %s"),
                    $external_uid
                )
            );
        }
        // Vérifie qu'il y a bien un message a ajouter
        if (! isset($request_data['message']) || empty($request_data['message'])) {
            throw new InvalidArgumentException(__("L'attribut external_uids.message n'est pas présent."));
        }
        // Récupération du paramétrage du message
        $parametres = array('type', 'contenu', 'categorie');
        foreach ($parametres as $parametre) {
            ${$parametre} = isset($request_data['message'][$parametre]) ?
                $request_data['message'][$parametre] :
                null;
        }
        // Ajout du message au dossier
        $inst_dossier_message = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_message",
            "idx" => ']',
        ));
        $dossier_message_val = array(
            'dossier' => $idDossier,
            'type' => $type,
            'emetteur' => $this->f->get_connected_user_login_name(),
            'login' => $_SESSION['login'],
            'date_emission' => date('Y-m-d H:i:s'),
            'contenu' => $contenu,
            'categorie' => $categorie
        );
        $add = $inst_dossier_message->add_notification_message($dossier_message_val);
        // Si une erreur se produit pendant l'ajout
        if ($add !== true) {
            throw new RuntimeException(__("Le message de notification n'a pas pu être ajouté."));
        }
    }

     /**
     * Ré-organise les données reçues pour qu'elles puissent être utilisées en tant que 
     * paramètre de la méthode document_numerise::ajouter().
     *
     * @param   array   $request_data   données reçues
     * @param   object  $inst_doc_num   instance de document_numerise
     * @param   object  $inst_lien      instance de lien_id_interne_uid_externe
     * @param   int     $collectiviteId identifiant de la collectivité du dossier de la pièce
     * @param   string  $category       catégorie de la tâche
     *
     * @return array  données ré-organisées
     *
     * @throw  InvalidArgumentException  Lorsque une donnée utilisateur est invalide ou manquante
     * @throw  RuntimeException          En cas d'échec lors du traitement du document
     */
    protected function prepare_attachment_data(array $request_data, $inst_doc_num, $inst_lien, $collectiviteId, $category = PLATAU) {

        $this->addToLog(__METHOD__."(): \tRempli une instance de 'document_numerise'", VERBOSE_MODE);
        $attachment_values = array();

        $this->addToLog(__METHOD__."(): \tRempli un tableau qui contiendra les données ".
            "de la piece", VERBOSE_MODE);
        foreach ($inst_doc_num->champs as $value) {
            $attachment_values[$value] = null;
            if (isset($request_data['document_numerise'][$value])) {
                $attachment_values[$value] = $request_data['document_numerise'][$value];
            }
            if($value == 'document_numerise_type'
                && isset($request_data['document_numerise']['document_numerise_type_code'])) {
                //
                $attachment_values["document_numerise_type"] = $inst_doc_num->get_document_numerise_type_id_by_code($request_data['document_numerise']['document_numerise_type_code']);
                if($attachment_values['document_numerise_type'] === false
                    || empty($attachment_values['document_numerise_type']) === true) {
                    //
                    throw new InvalidArgumentException(sprintf(
                            __("Le type de pièce avec le code %s n'existe pas"),
                            $request_data['document_numerise']['document_numerise_type_code']
                    ));
                }
            }
        }

        // sélectionne la référence externe la plus pertinente
        // - dossier_consultation: si spécifiée
        // - dossier: sinon
        if ($category === PLATAU) {
            $ref_external_uid = $request_data['external_uids']['dossier'];
            $type_external_uid = 'dossier';
            $err_external_uid = __("Le dossier %s n'existe pas.");
            if(isset($request_data['external_uids']['dossier_consultation']) &&
                ! empty($request_data['external_uids']['dossier_consultation'])) {
                //
                $ref_external_uid = $request_data['external_uids']['dossier_consultation'];
                $type_external_uid = 'dossier_consultation';
                $err_external_uid = __("La consultation %s n'existe pas.");
            }
        } elseif ($category === PORTAL) {
            $ref_external_uid = $request_data['external_uids']['demande'];
            $type_external_uid = 'demande';
            $err_external_uid = __("Le dossier %s n'existe pas.");
        }

        // récupération de l'id dossier openADS à partir de l'uid externe
        if ($collectiviteId !== null) {
            $attachment_values['dossier'] = $inst_lien->get_id_dossier_from_external_uid($ref_external_uid, $collectiviteId, $type_external_uid);
        } else {
            $attachment_values['dossier'] = $inst_lien->get_id_dossier_from_external_uid_without_collectivite($ref_external_uid, $type_external_uid);
        }
        //
        if (empty($attachment_values['dossier']) === true) {
            if ($collectiviteId !== null) {
                $attachment_values['dossier'] = $inst_lien->get_id_dossier_from_external_uid($ref_external_uid, $collectiviteId, $type_external_uid, 'dossier');
            } else {
                $attachment_values['dossier'] = $inst_lien->get_id_dossier_from_external_uid_without_collectivite($ref_external_uid, $type_external_uid, 'dossier');
            }
        }
        //
        if (empty($attachment_values['dossier']) === true) {
            throw new InvalidArgumentException(sprintf($err_external_uid, $ref_external_uid));
        }

        // Renomme le fichier si l'option est activée
        if ($this->f->is_option_renommage_document_numerise_tache_enabled() === true) {
            //
            $extension = '';
            $pos_extension = strpos($attachment_values['nom_fichier'], ".");
            if ($pos_extension !== false) {
                $extension = strtolower(substr($attachment_values['nom_fichier'], $pos_extension));
            }
            $attachment_values['nom_fichier'] = $inst_doc_num->generate_filename($attachment_values['date_creation'], $attachment_values["document_numerise_type"], $extension, $attachment_values['dossier']);
        }

        // Si le document est enregistré dans un alternate filestorage
        if (isset($attachment_values['uid']) === true
            && empty($attachment_values['uid']) !== true) {
            // Récupération du document
            $file = $this->f->storage->get($attachment_values['uid']);
            if ($file === null || $file === OP_FAILURE) {
                throw new RuntimeException(sprintf(
                    __("Erreur lors de la récupération du document %s."),
                    $attachment_values['uid']
                ));
            }
            // Préparation des métadonnées du document
            $inst_doc_num->valF["dossier"] = $attachment_values['dossier'];
            $inst_doc_num->valF["date_creation"] = $file['metadata']['date_creation'];
            $inst_doc_num->valF["document_numerise_type"] = $attachment_values["document_numerise_type"];
            $inst_doc_num->valF["nom_fichier"] = $file['metadata']['filename'];
            // Renomme le fichier si l'option est activée
            if ($this->f->is_option_renommage_document_numerise_tache_enabled() === true) {
                $extension = '';
                $pos_extension = strpos($file['metadata']['filename'], ".");
                if ($pos_extension !== false) {
                    $extension = strtolower(substr($file['metadata']['filename'], $pos_extension));
                }
                $inst_doc_num->valF["nom_fichier"] = $inst_doc_num->generate_filename($file['metadata']['date_creation'], $attachment_values["document_numerise_type"], $extension, $attachment_values['dossier']);
            }
            $new_metadata = $inst_doc_num->getMetadata('uid');
            $metadata = array_merge($file['metadata'], $new_metadata);
            // Si le document est stocké dans le stockage alternatif
            if (strpos($attachment_values['uid'], $this->f->storage::ALTFS_SEP) !== false) {
                // Création du document dans le stockage principal
                $uid = $this->f->storage->create($file['file_content'], $metadata, "from_content");
                if ($uid === null || $uid === OP_FAILURE) {
                    throw new RuntimeException(sprintf(
                        __("Erreur lors de la création du document %s depuis le stockage alternatif vers le stockage principal."),
                        $attachment_values['uid']
                    ));
                }
                // Suppression du document dans le stockage alternatif
                $delete = $this->f->storage->delete($attachment_values['uid']);
                if ($delete === null || $delete === OP_FAILURE) {
                    throw new RuntimeException(sprintf(
                        __("Erreur lors de la suppression du document %s du stockage alternatif."),
                        $attachment_values['uid']
                    ));
                }
            } else {
                $uid = $this->f->storage->update_metadata($attachment_values['uid'], $metadata);
                if ($uid === null || $uid === OP_FAILURE) {
                    throw new RuntimeException(sprintf(
                        __("Erreur lors de la mise à jour du document %s."),
                        $attachment_values['uid']
                    ));
                }
            }
            // Modification de l'uid passé à document_numerise
            $attachment_values['uid'] = $uid;
        }

        return $attachment_values;
    }

    /**
     * Ré-organise les données reçues pour qu'elles puissent être utilisées en tant que 
     * paramètre de la méthode demander::ajouter().
     * Les données traitées dans cette méthode ne concernent que les données spécifiques
     * lors d'une nouvelle demande.
     * Celle-ci est complétée par la méthode 'prepare_demande_data()'.
     *
     * @param   Array   $request_data   données reçues
     *
     * @return Array  données ré-organisées
     */
    protected function prepare_new_demande_data(array $request_data) {

        $this->addToLog(__METHOD__."(): \tInitialise une instance de 'demande'", VERBOSE_MODE);
        $demande_values = array();
        $demande = $this->f->get_inst__om_dbform(array(
            "obj" => "demande",
            "idx" => "]",
        ));

        $this->addToLog(__METHOD__."(): \tRempli un tableau qui contiendra les données ".
            "de la demande", VERBOSE_MODE);
        foreach ($demande->champs as $value) {
            $demande_values[$value] = null;
            if (isset($request_data['dossier'][$value])) {
                $demande_values[$value] = $request_data['dossier'][$value];
            }
        }

        // si le DA est spécifié, mais que la version est 0, alors on supprime le DA
        // sinon cela va faire boguer la création du dossier (recherchant le DA inexistant)
        //if(! $this->f->is_option_dossier_saisie_numero_complet_enabled()) {
            if (isset($demande_values['dossier_autorisation']) && (
                    ! isset($demande_values['version']) || $demande_values['version'] == '0')) {
                $demande_values['dossier_autorisation'] = null;
            }
        //}

        // Le code du type détaillé de dossier d'autorisation est renseigné donc
        // l'identifiant est récupéré depuis celui-ci
        if (isset($request_data['dossier']["dossier_autorisation_type_detaille_code"]) === true
            && $request_data['dossier']["dossier_autorisation_type_detaille_code"] !== ''
            && $request_data['dossier']["dossier_autorisation_type_detaille_code"] !== true) {
            //
            $this->addToLog(__METHOD__."(): \tObtient le DAtd à partir de la valeur fournie "."'".$request_data['dossier']["dossier_autorisation_type_detaille_code"]."'", VERBOSE_MODE);
            $demande_values['dossier_autorisation_type_detaille'] = ($this->get_dossier_autorisation_type_detaille($request_data['dossier']["dossier_autorisation_type_detaille_code"]));
        }

        // Dans le cas où un dossier initial est renseigné
        if (isset($request_data['demande']['dossier_initial']) === true
            && $request_data['demande']['dossier_initial'] !== ''
            && $request_data['demande']['dossier_initial'] !== null) {
            //
            $this->addToLog(
                sprintf(__("Récupère l'identifiant type détaillé du dossier d'autorisation à partir du dossier d'instruction initial '%s'"), $request_data['demande']['dossier_initial']),
                VERBOSE_MODE
            );
            // Récupération du type détaillé de dossier d'autorisation depuis le dossier initial
            $demande_values['dossier_autorisation_type_detaille'] = $this->get_dossier_autorisation_type_detaille(null, $request_data['demande']['dossier_initial']);
            // Indique le numéro du dossier d'instruction dans les valeurs de la demande
            $demande_values['dossier_instruction'] = $request_data['demande']['dossier_initial'];
        }

        // si l'option de saisie du numéro complet est activée
        if($this->f->is_option_dossier_saisie_numero_complet_enabled() &&
                isset($request_data['dossier']['dossier'])) {
            $demande_values['num_doss_complet'] = $request_data['dossier']['dossier'];
            $demande_values['num_doss_manuel'] = 'Oui';
            $this->f->addToLog(__METHOD__."(): num_doss_complet = '".$demande_values['num_doss_complet']."'", VERBOSE_MODE);
        }

        return $demande_values;
    }

    /**
     * Ré-organise les données reçues pour qu'elles puissent être utilisées en tant que
     * paramètre de la méthode demander::ajouter().
     * Les données traitées dans cette méthode ne concernent que les données "communes"
     * lors d'une nouvelle demande ou d'une demande sur existant.
     * Celle-ci est complétée par la méthode 'prepare_new_demande_data()'.
     *
     * @param   Array   $request_data   données reçues
     *
     * @return Array  données ré-organisées
     *
     * @throw InvalidArgumentException  En cas de donnée utilisateur invalide ou manquante
     */
    protected function prepare_demande_data(array $request_data, array $demande_values) {

        // numéro de dossier
        $this->ensure_numero_dossier($request_data);

        // références cadastrales
        if (isset($request_data["dossier"]['terrain_references_cadastrales']) &&
                ! empty($request_data["dossier"]['terrain_references_cadastrales'])) {
            // TODO vérifier le format
            $demande_values['terrain_references_cadastrales'] = strtoupper(
                $request_data["dossier"]['terrain_references_cadastrales']);
        }

        // date demande
        $demande_values['date_demande'] = (new DateTime())->format('d/m/Y');
        if (isset($request_data['dossier']['date_demande']) &&
                ! empty($request_data['dossier']['date_demande'])) {
            // TODO vérifier le format
            $demande_values['date_demande'] = $request_data['dossier']['date_demande'];
        }

        // collectivité
        $collectiviteId = $this->get_collectivite_id_from_acteur_or_collectivite($request_data);
        $demande_values['om_collectivite'] = $collectiviteId;

        // commune
        if ($this->f->is_option_dossier_commune_enabled()) {

            // si le code insee n'est pas fourni
            if (! isset($request_data['dossier']['insee']) ||
                    empty($request_data['dossier']['insee'])) {
                throw new InvalidArgumentException(sprintf(__(
                    "Le paramètre '%s' est obligatoire"), 'dossier/insee'));
            }
            $insee = $request_data['dossier']['insee'];
            $this->addToLog(__METHOD__."(): code INSEE '$insee'", VERBOSE_MODE);

            // récupère la commune à partir du code insee
            $commune = $this->get_commune_from_insee($insee);
            if (empty($commune)) {
                throw new InvalidArgumentException(sprintf(__(
                    "Impossible de trouver la commune pour le code INSEE '%s'"), $insee));
            }
            $this->addToLog(__METHOD__."(): commune '$commune'", VERBOSE_MODE);
            $demande_values['commune'] = $commune;
        }

        // Valeurs par défaut
        $type_demande = 'initial';
        if (isset($request_data['demande']["type_demande"]) === true
            && empty($request_data['demande']["type_demande"]) !== true) {
            //
            $type_demande = $request_data['demande']["type_demande"];
        }
        $etat_dossier_initial = null;

        // Dans le cas d'une demande sur dossier existant, le dossier initial doit être
        // renseigné
        if ($type_demande !== 'initial') {
            if (isset($request_data['demande']['dossier_initial']) === false
                || empty($request_data['demande']['dossier_initial']) === true) {
                //
                throw new InvalidArgumentException(sprintf(
                    __("Le dossier d'instruction initial doit être renseigné dans les informations du dossier.")
                ));
            }
            $inst_dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $request_data['demande']['dossier_initial'],
            ));
            // Récupération du dossier d'autorisation
            $id_da = $inst_dossier->getVal('dossier_autorisation');
            if (is_null($id_da) === true) {
                throw new InvalidArgumentException(sprintf(
                    __("Le dossier d'autorisation du dossier d'instruction initial %s n'existe pas."),
                    $request_data['demande']['dossier_initial']
                ));
            }
            $demande_values['dossier_autorisation'] = $id_da;
            // Récupération de l'état du dossier initial
            $etat_dossier_initial = $inst_dossier->getVal('etat');
        }

        // demande type
        $demande_values['demande_type'] = $this->get_demande_type(
            $demande_values,
            intval($demande_values['dossier_autorisation_type_detaille']),
            $collectiviteId,
            $type_demande,
            $etat_dossier_initial
        );

        // version
        if ($type_demande === 'initial') {
            //
            $demande_values['version'] = '0';
            if (isset($request_data['dossier']['version']) === true
                && empty($request_data['dossier']['version']) === false) {
                //
                $demande_values['version'] = $request_data['dossier']['version'];
            }
        }

        // suffixe
        if (isset($demande_values['dossier_suffixe'])) {
            $matches = array();
            if(preg_match('/^(?P<suffixe>[A-Z]\+(?P<numero>[0-9]\+)$/', $demande_values['dossier_suffixe'], $matches)) {
                $demande_values['numerotation_suffixe'] = $matches['suffixe'];
                $demande_values['numerotation_num_suffixe'] = $matches['numero'];
            }
        }
        elseif (! isset($demande_values['numerotation_suffixe'])
                || ! isset($demande_values['numerotation_num_suffixe'])) {

            if (! isset($request_data['dossier']['dossier'])
                    || empty($request_data['dossier']['dossier'])) {
                $this->f->addToLog(__METHOD__."() : ".
                    "Dossier suffixe vide et aucun numéro de dossier fourni. ".
                    "Détail: ".var_export($request_data, true), DEBUG_MODE);
            }

            // un numéro de dossier est défini
            else {

                // numéro de dossier
                $ref_num_dossier = $request_data['dossier']['dossier'];

                // si l'option 'code_entité' est activée pour la collectivité
                if ($this->f->is_option_om_collectivite_entity_enabled($collectiviteId)) {

                    // si le code entité n'est pas défini ou vide
                    if ($this->f->get_collectivite_code_entite($collectiviteId) === null) {

                        // affiche un message d'alerte
                        $err_msg = sprintf(__("Paramètre '%s' manquant ou vide pour la collectivité '%s'"),
                                            'code_entite',
                                            $collectiviteId);
                        $this->f->addToLog(__METHOD__."() : $err_msg", DEBUG_MODE);
                    }
                    // si le code entité est défini et non-vide
                    else {

                        // supprime le code entité du numéro de dossier
                        $ref_num_dossier = preg_replace('/'.$this->f->get_collectivite_code_entite($collectiviteId).'$/', '', $ref_num_dossier);
                    }
                }

                // utilisation du parsing du numéro de dossier
                $num_urba = $this->f->numerotation_urbanisme($ref_num_dossier);

                // si le suffixe est défini
                if (isset($num_urba['di']['suffixe']) && isset($num_urba['di']['num_suffixe'])) {
                    $demande_values['numerotation_suffixe'] = $num_urba['di']['suffixe'];
                    $demande_values['numerotation_num_suffixe'] = $num_urba['di']['num_suffixe'];
                }
            }
        }

        // dépôt électronique
        $demande_values['depot_electronique'] = (
            isset($request_data['dossier']['depot_electronique']) &&
            $request_data['dossier']['depot_electronique'] === 't');

        // parcelle temporaire
        $demande_values['parcelle_temporaire'] = (
            isset($request_data['dossier']['parcelle_temporaire']) &&
            $request_data['dossier']['parcelle_temporaire'] === 't');

        return $demande_values;
    }

    /**
     * Prépare les données techniques réceptionnées pour qu'elle puissent être
     * utilisées avec la méthode modifier.
     *
     * @param  array  $request_data Données réceptionnées
     * @return array                Données préparées
     */
    protected function prepare_donnees_techniques_data(array $request_data) {
        $dt_values = array();

        if (isset($request_data['donnees_techniques']) === true
            && is_array($request_data['donnees_techniques']) === true
            && count($request_data['donnees_techniques']) > 0) {
            //
            foreach ($request_data['donnees_techniques'] as $key => $value) {
                if ($key !== "donnees_techniques"
                    && $key !== "cerfa") {
                    //
                    $dt_values[$key] = $value;
                }
            }
        }

        return $dt_values;
    }

    /**
     * Récupère l'identifiant d'une collectivité à partir d'un acteur ou d'un libellé.
     *
     * @param  array  $request_data       donnée utilisateurs reçues
     *
     * @return  int  L'identifiant de la collectivité
     *
     * @throw InvalidArgumentException lorsqu'aucune collectivité ne correspond à un acteur
     * @throw InvalidArgumentException lorsque ni l'acteur ni la collectivité n'ont été spécifiés
     */
    protected function get_collectivite_id_from_acteur_or_collectivite(array $request_data) {
        $collectiviteId = null;
        if (isset($request_data['external_uids']['acteur']) &&
                ! empty($request_data['external_uids']['acteur'])) {
            $acteurId = $request_data['external_uids']['acteur'];
            $collectiviteId = $this->get_collectivite_id_from_acteur($acteurId);
            if (empty($collectiviteId)) {
                throw new InvalidArgumentException(sprintf(__(
                    "Impossible de trouver le service correspondant à l'acteur '%s'"), $acteurId));
            }
            $this->addToLog(__METHOD__."(): acteur: '$acteurId' => collectivite '$collectiviteId'",
                            VERBOSE_MODE);
        }
        elseif (isset($request_data['dossier']['om_collectivite']) &&
                ! empty($request_data['dossier']['om_collectivite'])) {
            $collectiviteId = $this->get_collectivite_id(intval($request_data['dossier']["om_collectivite"]));
            $this->addToLog(__METHOD__."(): collectivite '$collectiviteId'", VERBOSE_MODE);
        }
        elseif (isset($request_data['dossier']['insee']) &&
                ! empty($request_data['dossier']['insee'])) {
            $collectiviteId = $this->get_collectivite_id_from_insee($request_data['dossier']["insee"]);
            $this->addToLog(__METHOD__."(): collectivite '$collectiviteId'", VERBOSE_MODE);
        }
        if (empty($collectiviteId)) {
            throw new InvalidArgumentException(sprintf(__(
                "Le paramètre %s est obligatoire."), "'acteur' (ou 'om_collectivite')"));
        }
        return $collectiviteId;
    }

    /**
     * Cette methode prend le type de demandeur et ces valeurs pour le créer
     * et renvoie l'identifiant du demandeur créé ou false en cas d'erreur
     *
     * @param  string  $demandeur_type    Le type de demandeur
     * @param  array   $demandeur_valeur  Les valeurs renseignés du demandeur
     * @param  int     $collectiviteId    L'identifiant de la collectivité
     *
     * @return  int  L'identifiant du demandeur
     *
     * @throw  InvalidArgumentException  Lorsque 'om_collectivite' est manquant
     * @throw  RuntimeException          En cas d'échec lors de l'ajout du demandeur
     */
    protected function creation_demandeur(string $demandeur_type, array $demandeur_valeur,
                                          int $collectiviteId) {

        // récupère une instance "vide"
        $demandeur = $this->f->get_inst__om_dbform(array(
            "obj" => "demandeur",
            "idx" => "]",
        ));

        // stocke les valeurs du demandeur, ré-organisées pour qu'elles puissent être fournies
        // en tant qu'argument à la méthode demandeur::ajouter().
        $valAuto = array();

        // initialisation des valeurs à null
        foreach($demandeur->champs as $value) {
            $valAuto[$value] = null;
        }

        // récupération des valeurs
        foreach ($demandeur_valeur as $colonne => $valeur) {
            $valAuto[$colonne] = $valeur;
        }

        // traitement spécifique pour la civilité
        if (isset($demandeur_valeur['particulier_civilite']) &&
                ! empty($demandeur_valeur['particulier_civilite'])) {
            $valAuto['particulier_civilite'] = $this->get_civilite($demandeur_valeur['particulier_civilite']);
        }
        if (isset($demandeur_valeur['personne_morale_civilite']) &&
                ! empty($demandeur_valeur['personne_morale_civilite'])) {
            $valAuto['personne_morale_civilite'] = $this->get_civilite($demandeur_valeur['personne_morale_civilite']);
        }

        // collectivité
        if (empty($collectiviteId)) {
            throw new InvalidArgumentException(sprintf(
                __("Le paramètre %s est obligatoire pour les données du demandeur."),
                "'acteur' (ou 'om_collectivite')"));
        }
        $valAuto['om_collectivite'] = $collectiviteId;

        // traitement spécifique pour la fréquence
        if (isset($demandeur_valeur['frequent']) && ! empty($demandeur_valeur['frequent'])) {
            $valAuto['frequent'] = $demandeur_valeur["frequent"] == 'f';
        }

        // traitement spécifique pour la qualité
        $valAuto['qualite'] = 'particulier';
        if (isset($demandeur_valeur['qualite']) && ! empty($demandeur_valeur['qualite'])) {
            $valAuto['qualite'] = str_replace(' ', '_', $demandeur_valeur['qualite']);
        }

        // traitement spécifique pour le type ==> TODO WHY ???
        $valAuto['type_demandeur'] = str_replace("_principal", "", $demandeur_type);

        // ajout du demandeur en BDD
        if ($demandeur->ajouter($this->adapt_payload_values($demandeur->table, $valAuto)) === false) {
            throw new RuntimeException(__("Échec lors de l'ajout du demandeur"));
        }

        // renvoie l'identifiant technique en BDD du demandeur créé
        return $demandeur->valF['demandeur'];
    }

    /**
     * Renvoie l'identifiant en BDD d'une collectivité à partir de son libellé ou de son ID.
     * Stocke l'info en cache et l'utilise ensuite si elle existe.
     *
     * @param  string|int  $collectivite  Libellé ou ID de la collectivité
     *
     * @return  int  L'identifiant de la collectivité en BDD
     */
    protected function get_collectivite_id(string $collectivite) {
        if (! isset($this->cacheCollectivites[$collectivite])) {
            $om_collectivite = $this->f->getSingleSqlValue(
                'om_collectivite', 'om_collectivite', 'om_collectivite.libelle', $collectivite);
            $this->cacheCollectivites[$collectivite] = $om_collectivite;
        }
        return $this->cacheCollectivites[$collectivite];
    }

    /**
     * Renvoi l'identifiant d'une collectivité à partir de la valeur de l'acteur (om_parametre).
     *
     * @param  $acteurId  string  L'identifiant de l'acteur (valeur de om_parametre)
     *
     * @return int|null  L'identifiant de la collectivité correspondante, ou null si non trouvée
     *
     * @throw  RuntimeException   En cas d'erreur BDD
     */
    protected function get_collectivite_id_from_acteur(string $acteurId) {
        $om_collectivite = null;
        foreach(array(
            'acteur_service_consulte',
            'acteur_guichet_unique',
            'acteur_service_instructeur',
            'acteur_autorite_competente'
        ) as $acteur_key) {
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        om_collectivite
                    FROM
                        %1$som_parametre
                    WHERE
                        libelle = \'platau_%2$s\'
                        AND valeur = \'%3$s\'',
                    DB_PREFIXE,
                    $acteur_key,
                    $this->f->db->escapeSimple($acteurId)
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($qres["code"] !== "OK") {
                throw new RuntimeException(sprintf(
                    __("Échec à l'exécution de la requête SQL de sélection d'un service ".
                       "pour l'acteur '%s'"), $acteurId));
            }
            $om_collectivite = $qres["result"];
            if (! empty($om_collectivite)) {
                break;
            }
        }
        return $om_collectivite;
    }

    protected function get_collectivite_id_from_insee(string $insee) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    om_collectivite.om_collectivite
                FROM
                    %1$som_parametre
                        INNER JOIN %1$som_collectivite
                            ON om_parametre.om_collectivite = om_collectivite.om_collectivite
                WHERE
                    om_parametre.libelle = \'insee\'
                    AND om_parametre.valeur = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($insee)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            throw new RuntimeException(sprintf(
                __("Échec à l'exécution de la requête SQL de sélection d'une collectivité/d'un service depuis le code INSEE '%s'"),
                $insee
            ));
        }
        return $qres["result"];
    }

    /**
     * Renvoi le code INSEE d'une collectivité.
     *
     * @param  $collectiviteId  int  L'identifiant de la collectivite
     *
     * @return int|null  Le code INSEE de la collectivité, ou null si non trouvé
     *
     * @throw  RuntimeException   En cas d'erreur BDD
     */
    protected function get_code_insee_for_collectivite(int $collectiviteId) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    valeur
                FROM
                    %1$som_parametre
                WHERE
                    libelle = \'insee\'
                    AND om_collectivie = %2$d',
                DB_PREFIXE,
                intval($collectiviteId)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            throw new RuntimeException(sprintf(
                __("Échec à l'exécution de la requête SQL de sélection du code INSEE ".
                   "de la collectivité '%s'"), $collectiviteId));
        }
        return $qres["result"];
    }

    /**
     * Renvoi le code commune à partir d'un code INSEE
     *
     * @param  $insee  int  Le code INSEE
     *
     * @return string|null  Le code de la commune, ou null si non trouvé
     *
     * @throw  RuntimeException   En cas d'erreur BDD
     */
    protected function get_commune_from_insee(string $insee) {
        $today = (new Datetime())->format('Y-m-d');
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    commune
                FROM
                    %1$scommune
                WHERE
                    com = \'%2$s\'
                    AND (
                        om_validite_debut IS NULL
                        OR om_validite_debut <= TO_DATE(\'%3$s\', \'YYYY-MM-DD\')
                    )
                    AND (
                        commune.om_validite_fin IS NULL
                        OR om_validite_fin > TO_DATE(\'%3$s\', \'YYYY-MM-DD\')
                    )
                ORDER BY
                    om_validite_fin DESC NULLS FIRST,
                    om_validite_debut DESC NULLS FIRST
                LIMIT 1',
                DB_PREFIXE,
                $this->f->db->escapeSimple($insee),
                $this->f->db->escapeSimple($today)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            throw new RuntimeException(sprintf(
                __("Échec à l'exécution de la requête SQL de sélection d'idenfiant commune ".
                   "à partir du code INSEE '%s'"), $insee));
        }
        return $qres["result"];
    }

    /**
     * Renvoie l'identifiant en BDD d'une civilité à partir de son libellé ou de son ID.
     *
     * @param  string|int  $civilite  Libellé ou ID de la civilité
     *
     * @return  int  L'identifiant de la civilité en BDD
     */
    protected function get_civilite(string $civilite) {
        return $this->f->getSingleSqlValue(
            'civilite', 'civilite', 'civilite.libelle', $civilite);
    }

    /**
     * Vérifie que le numéro de dossier est défini et conforme à la réglementation
     *
     * @param  array  Tableau des valeurs courantes de la demande
     *
     * @return array  Tableau contenant les clés 'di' et 'da' avec le numéro de dossier correspondant
     *
     * @throw  InvalidArgumentException  Lorsque une donnée utilisateur est invalide ou manquante
     */
    protected function ensure_numero_dossier(array $demande_values) {
        $num_matches = array('di' => null, 'da' => null);

        // s'il manque la clé 'dossier' alors que l'option
        // 'saisie complète numéro dossier' est activée
        if($this->f->is_option_dossier_saisie_numero_complet_enabled() &&
                (! isset($demande_values['dossier']['dossier']) ||
                    empty($demande_values['dossier']['dossier']))) {
            throw new InvalidArgumentException(sprintf(
                __("Le paramètre '%s' est obligatoire"), 'dossier/dossier'));
        }

        // sinon, si on a la clé 'dossier' qui est bien définie
        elseif(isset($demande_values['dossier']['dossier']) &&
            ! empty($demande_values['dossier']['dossier'])) {

            /*
             * On relache cette contrainte pour le cas ou les DA/DI sont non-règlementaires
             *
            // si le numéro de dossier n'est pas conforme à la numérotation
            $num_matches = $this->f->numerotation_urbanisme($demande_values['dossier']['dossier']);
            if (empty($num_matches['da']) || empty($num_matches['di'])) {
                throw new InvalidArgumentException(sprintf(
                    __("La valeur '%s' du paramètre '%s' n'est pas valide"),
                   $demande_values['dossier']['dossier'], 'dossier/dossier'));
            }*/
        }
        return $num_matches;
    }

    /**
     * [get_datd_values_by_id description]
     * @param  int    $datd_id [description]
     * @return [type]          [description]
     */
    protected function get_datd_values_by_id(int $datd_id) {
        //
        $inst_datd = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation_type_detaille",
            "idx" => $datd_id,
        ));
        $val = array();
        $val = array_combine($inst_datd->champs, $inst_datd->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        return $val;
    }

    /**
     * Renvoie l'identifiant en BDD d'une demande type à partir de plusieurs paramètres.
     *
     * @param  array       $demande_values       Tableau des valeurs courantes de la demande
     * @param  int         $datd_id              Identifiant du type de dossier d'autorisation détaillé.
     * @param  int         $collectiviteId       Identifiant de la collectivité courante
     * @param  string      $type_demande         Type de la demande, par défaut "initial"
     * @param  string|null $etat_dossier_initial Identifiant de l'état du dossier initial, s'il s'agit d'une demande sur dossier existant
     *
     * @return int                               L'identifiant de la demande type en BDD
     *
     * @throw  InvalidArgumentException  Lorsque le paramètrage des types de demande n'est pas défini
     */
    protected function get_demande_type(array $demande_values, int $datd_id, int $collectiviteId, string $type_demande = 'initial', string $etat_dossier_initial = null) {

        // Récupère le code du datd
        $get_datd_values_by_id = array();
        $get_datd_values_by_id = $this->get_datd_values_by_id($datd_id);
        $datd_code = $get_datd_values_by_id['code'];

        // Compose le nom du paramètre
        $type_demande_param = sprintf('%s_%s_%s', 'platau_type_demande', $type_demande, $datd_code);
        // Récupère les paramètres de la collectivité
        $param_collectivite = $this->f->getCollectivite($collectiviteId);
        // Récupère le paramètre dans la collectivité du dossier
        $type_demande_code = null;
        if (is_array($param_collectivite) === true
            && isset($param_collectivite[$type_demande_param]) === true) {
            //
            $type_demande_code = $param_collectivite[$type_demande_param];
        }
        if (empty($type_demande_code) === true) {
            throw new InvalidArgumentException(sprintf(
                __("Le paramètre '%s' n'est pas défini pour la collectivité/le service dont l'identifiant est %d"),
                $type_demande_param, $param_collectivite['om_collectivite_idx']));
        }
        // Récupère l'identifiant du type de la demande
        $condition_etat = "";
        if ($etat_dossier_initial !== null
            && $etat_dossier_initial !== "") {
            // Dans le cas où il s'agit d'une demande sur dossier existant, on récupère
            // l'état du dossier initial
            $condition_etat = sprintf('
                AND demande_type.demande_type IN (
                    SELECT DISTINCT
                        demande_type
                    FROM
                        %1$slien_demande_type_etat
                    WHERE
                        etat = \'%2$s\'
                )',
                DB_PREFIXE,
                $etat_dossier_initial
            );
        }
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    demande_type.demande_type
                FROM
                    %1$sdemande_type
                WHERE
                    demande_type.code = \'%2$s\'
                    AND demande_type.dossier_autorisation_type_detaille = %3$s
                    %4$s
                ',
                DB_PREFIXE,
                $this->f->db->escapeSimple($type_demande_code),
                intval($datd_id),
                $condition_etat
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            throw new InvalidArgumentException($qres["message"]);
        }
        $demande_type_id = $qres["result"];
        if (empty($demande_type_id) === true) {
            throw new InvalidArgumentException(sprintf(
                __("Le type de demande avec le code '%s' et le type de dossier d'autorisation détaillé '%s' n'existe pas."),
                $type_demande_code,
                $datd_id
            ));
        }

        return $demande_type_id;
    }

    /**
     * Renvoie l'identifiant en BDD du DAtd à partir de son code.
     *
     * @param  string  $datd_code  Code du type de dossier d'autorisation detaillé
     *
     * @return  int  L'identifiant du DAtd en BDD
     */
    protected function get_dossier_autorisation_type_detaille(string $datd_code = null, string $dossier = null) {
        if ($datd_code !== null) {
            return $this->f->getSingleSqlValue(
                'dossier_autorisation_type_detaille', 'dossier_autorisation_type_detaille',
                'dossier_autorisation_type_detaille.code', $datd_code);
        }
        if ($dossier !== null) {
            $dossier_autorisation = $this->f->getSingleSqlValue(
                'dossier', 'dossier_autorisation',
                'dossier.dossier', $dossier);
            return $this->f->getSingleSqlValue(
                'dossier_autorisation', 'dossier_autorisation_type_detaille',
                'dossier_autorisation.dossier_autorisation', $dossier_autorisation);
        }
    }

    /**
     * Récupère l'identifiant de l'avis de consultation depuis son code.
     *
     * @param  string $ac_code Code de l'avis de consultation
     * @return mixed           Identifant de l'avis de consultation |false
     */
    protected function get_avis_consultation_id_by_code($ac_code) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    avis_consultation
                FROM
                    %1$savis_consultation
                WHERE
                    code = \'%2$s\'
                ',
                DB_PREFIXE,
                $this->f->db->escapeSimple($ac_code)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        return $qres["result"];
    }

    /**
     * Effectue différent traitement sur les valeurs de la payload pour les adapter
     * au valeur attendue dans openADS.
     *
     * Les méthodes de traitements utilisées sont :
     *  - truncate_value_from_field_max_size()
     *  - correct_date_format()
     *
     * @param  string $table     Table en base de données où seront stockées les valeurs.
     * @param  array  $field_tab Tableau des valeurs.
     * @return array             Tableau des valeurs, dont certaines tronquées.
     */
    protected function adapt_payload_values(string $table, array $field_tab) {
        // Récupère le type de chacun des champs pour déterminer le-s traitement-s à appliquer
        $fields_type = $this->get_table_fields_type($table, $field_tab);
        if ($fields_type['code'] === 'KO') {
            $this->setMessage(__("Erreur lors de la récupération des informations sur les colonnes en base de données"));
            return $this->KO;
        }

        // Filtre les éléments par type
        $fields_by_type = array();
        foreach ($fields_type['result'] as $field) {
            $fields_by_type[$field['data_type']][$field['column_name']] = $field;
            $fields_by_type[$field['data_type']][$field['column_name']]['value'] = $field_tab[$field['column_name']];
        }
        // Tri des champs particulier
        // Le champs date_depot_mairie est renseigné dans la payload dans la partie utilisé pour
        // l'ajout de demande. Ce champs n'appartiens pas à la table demande. Il correspond au
        // champs depot_initial de la table dossier_autorisation. Pour éviter des erreurs liées
        // à ce champs, on l'ajoute à la main dans le tableau en tant que date.
        if (isset($field_tab['date_depot_mairie'])) {
            $fields_by_type['date']['date_depot_mairie'] = array('value' => $field_tab['date_depot_mairie']);
        }

        // Effectue les traitements selon le type de champs et met à jour les valeur du tableau
        if (isset($fields_by_type['character varying'])) {
            $field_tab = array_merge($field_tab, $this->truncate_value_from_field_max_size($fields_by_type['character varying']));
        }
        if (isset($fields_by_type['date'])) {
            $field_tab = array_merge($field_tab, $this->correct_date_format($fields_by_type['date']));
        }

        return $field_tab;
    }

    /**
     * Récupère en base de données les informations de chaque champ et renvoie le résultat.
     *
     * @param string $table       Table en base de données où seront stockées les valeurs.
     * @param array  $field_tab   Tableau des valeurs.
     * @return array              Résultat de la requête
     */
    protected function get_table_fields_type(string $table, array $field_tab) {
        // Récupère les informations de chaque champ, en base de données
        $res = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    column_name,
                    character_maximum_length,
                    data_type
                FROM
                    INFORMATION_SCHEMA.COLUMNS
                WHERE
                    column_name IN (\'%1$s\')
                    AND (table_name = \'%2$s\');',
                implode('\', \'', array_keys($field_tab)),
                $table
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        return $res;
    }

    /**
     * Découpe les valeurs du tableau passé en paramètre à la taille max du champ
     * en base de données.
     *
     * @param  array  $field_tab Tableau des valeurs.
     * @return array             Tableau des valeurs, dont certaines tronquées.
     */
    protected function truncate_value_from_field_max_size(array $field_tab) {
        $corrected_fields = array();
        // Tronque les valeurs
        foreach ($field_tab as $field_name => $field_info) {
            $corrected_fields[$field_name] = mb_substr($field_info['value'], 0, $field_info["character_maximum_length"]);
        }
        // Retourne le nouveau tableau avec les valeurs tronquées
        return $corrected_fields;
    }

    /**
     * Formate les valeurs du tableau passé en paramètre pour que l'année de chacune des dates
     * non vide possède 4 caractères.
     * Les dates attendues doivent être au format : AAAA-MM-JJ avec entre 1 et 4 A.
     *
     * @param  array  $field_tab Tableau des valeurs.
     * @return array             Tableau des valeurs, avec des dates ayant des années sur 4 caractères.
     */
    protected function correct_date_format(array $field_tab) {
        $corrected_fields = array();
        // Ajoute des 0 en début de date pour que l'année soit toujours sur 4 caractères
        foreach ($field_tab as $field_name => $field_info) {
            // Ne corrige que les dates ayant été remplie et n'étant pas au format DD/MM/YYYY.
            // Les dates au format DD/MM/YYYY ne sont pas issues de la payload mais sont calculées
            // par l'application (normalement). Elles n'ont donc pas besoin de correction.
            if (! empty($field_info['value']) && preg_match('/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/', $field_info['value']) !== 1) {
                // Découpe la valeur en YYYY, MM et DD
                $truncated_date = explode('-', $field_info['value']);
                // Si la date n'a pas le format voulu utilise une date par défaut.
                // Sinon complète l'année, le mois et le jour avec des 0 pour s'assurer que
                // le format attendu est correct.
                // Si malgré l'ajout des 0 la date n'est toujours pas correcte, utilise la
                // date par défaut
                $default_date = "0001-01-01";
                $is_date_ok = false;
                if (is_array($truncated_date) && count($truncated_date) === 3) {
                    $is_date_ok = true;
                    for ($i = 0; $i < 3; $i++) {
                        // pour l'annèe on compléte sur 4 caractère et pour le mois/jour sur 2
                        $pad_length = $i === 0 ? 4 : 2;
                        $truncated_date[$i] = str_pad($truncated_date[$i], $pad_length, "0", STR_PAD_LEFT);
                        // Vérifie si le résultat obtenu ne contiens que des 0. Si c'est le cas, la
                        // date est marqué comme invalide et la date par défaut sera utilisée.
                        if (preg_match('/^0{0,4}$/', $truncated_date[$i]) === 1) {
                            $is_date_ok = false;
                            break;
                        }
                    }
                }
                $corrected_fields[$field_name] = $is_date_ok ?
                    implode("-", $truncated_date)
                    : $default_date;
            }
        }

        // Retourne le nouveau tableau avec les dates corrigées
        return $corrected_fields;
    }
}
