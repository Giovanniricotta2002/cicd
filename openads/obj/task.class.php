<?php
//$Id$
//gen openMairie le 14/04/2020 14:11

require_once "../gen/obj/task.class.php";

class task extends task_gen {

    const STATUS_DRAFT = 'draft';
    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_DONE = 'done';
    const STATUS_ERROR = 'error';
    const STATUS_DEBUG = 'debug';
    const STATUS_ARCHIVED = 'archived';
    const STATUS_CANCELED = 'canceled';

    /**
     * Liste des types de tâche concernant les services instructeurs
     */
    const TASK_TYPE_SI = array(
        'creation_DA',
        'creation_DI',
        'depot_DI',
        'modification_DI',
        'qualification_DI',
        'decision_DI',
        'incompletude_DI',
        'completude_DI',
        'ajout_piece',
        'add_piece',
        'creation_consultation',
        'modification_DA',
        'create_DI',
        'envoi_CL',
        'notification_recepisse',
        'notification_instruction',
        'notification_decision',
        'notification_service_consulte',
        'notification_tiers_consulte',
        'notification_depot_demat',
        'notification_commune',
        'notification_signataire',
        'lettre_incompletude',
        'lettre_majoration'
    );

    /**
     * Liste des types de tâche concernant les services consultés
     */
    const TASK_TYPE_SC = array(
        'create_DI_for_consultation',
        'avis_consultation',
        'pec_metier_consultation',
        'create_message',
        'notification_recepisse',
        'notification_instruction',
        'notification_decision',
        'notification_service_consulte',
        'notification_tiers_consulte',
        'notification_depot_demat',
        'prescription',
    );

    /**
     * Liste des types de tâche pouvant avoir des documents associés
     */
    const TASK_WITH_DOCUMENT = array(
        'add_piece',
        'avis_consultation',
        'pec_metier_consultation'
    );

    /**
     * Préfixe pour identifier les codes de suivi
     * @var string
     */
    const CS_PREFIX = 'code-suivi://';

    /**
     * Catégorie de la tâche
     */
    var $category = PLATAU;

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    public function init_class_actions() {
        parent::init_class_actions();
        //
        $this->class_actions[998] = array(
            "identifier" => "json_data",
            "view" => "view_json_data",
            "permission_suffix" => "consulter",
        );
        $this->class_actions[997] = array(
            "identifier" => "json_data",
            "view" => "post_update_task",
            "permission_suffix" => "modifier",
        );
        $this->class_actions[996] = array(
            "identifier" => "json_data",
            "view" => "post_add_task",
            "permission_suffix" => "ajouter",
        );
    }

    public function setvalF($val = array()) {

        // // les guillets doubles sont remplacés automatiquement par des simples
        // // dans core/om_formulaire.clasS.php::recupererPostvar()
        // // voir le ticket https://dev.atreal.fr/projets/openmairie/tracker/209
        // // ceci est un hack sale temporaire en attendant résolution du ticket
        // foreach(array('json_payload', 'timestamp_log') as $key) {
        //     if (isset($val[$key]) && ! empty($val[$key]) &&
        //             isset($_POST[$key]) && ! empty($_POST[$key])) {
        //         $submited_payload = $_POST[$key];
        //         if (! empty($submited_payload)) {
        //             $new_payload = str_replace("'", '"', $val[$key]);
        //             if ($new_payload == $submited_payload ||
        //                     strpos($submited_payload, '"') === false) {
        //                 $val[$key] = $new_payload;
        //             }
        //             else {
        //                 $error_msg = sprintf(
        //                     __("La convertion des guillemets de la payload JSON '%s' ".
        //                         "n'est pas idempotente (courante: %s, postée: %s, convertie: %s)"),
        //                     $key, var_export($val[$key], true), var_export($submited_payload, true),
        //                     var_export($new_payload, true));
        //                 $this->correct = false;
        //                 $this->addToMessage($error_msg);
        //                 $this->addToLog(__METHOD__."() erreur : $error_msg", DEBUG_MODE);
        //                 return false;
        //             }
        //         }
        //     }
        // }

        parent::setvalF($val);

        // XXX Ancien code : permet de ne pas avoir d'erreru lors de la modification d'une task
        if (array_key_exists('timestamp_log', $val) === true) {
            $this->valF['timestamp_log'] = str_replace("'", '"', $val['timestamp_log']);
        }

        // récupération de l'ID de l'objet existant
        $id = property_exists($this, 'id') ? $this->id : null;
        if(isset($val[$this->clePrimaire])) {
            $id = $val[$this->clePrimaire];
        } elseif(isset($this->valF[$this->clePrimaire])) {
            $id = $this->valF[$this->clePrimaire];
        }

        // MODE MODIFIER
        if (! empty($id)) {

            // si aucune payload n'est fourni (devrait toujours être le cas)
            if (! isset($val['json_payload']) || empty($val['json_payload'])) {

                // récupère l'objet existant
                $existing = $this->f->findObjectById('task', $id);
                if (! empty($existing)) {

                    // récupère la payload de l'objet
                    $val['json_payload'] = $existing->getVal('json_payload');
                    $this->valF['json_payload'] = $existing->getVal('json_payload');
                    $this->f->addToLog(__METHOD__."() récupère la payload de la tâche existante ".
                        "'$id': ".$existing->getVal('json_payload'), EXTRA_VERBOSE_MODE);
                }
            }
        }

        if (array_key_exists('category', $val) === false
            || $this->valF['category'] === ''
            || $this->valF['category'] === null) {
            //
            $this->valF['category'] = $this->category;
        }

        // Si last_modification_time est vide, la valeur est remplacée par NULL
        // pour eviter d'avoir une erreur de base de données car le champ est au format time.
        if ($val['last_modification_time'] == "") {
            $this->valF['last_modification_time'] = NULL;
        } else {
            $this->valF['last_modification_time'] = $val['last_modification_time'];
        }

        // Si creation_time est vide, la valeur est remplacée par NULL
        // pour eviter d'avoir une erreur de base de données car le champ est au format time.
        if ($val['creation_time'] == "") {
            $this->valF['creation_time'] = NULL;
        } else {
            $this->valF['creation_time'] = $val['creation_time'];
        }
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "task",
            "type",
            "state",
            "object_id",
            "dossier",
            "stream",
            "creation_date",
            "creation_time",
            "CONCAT_WS(' ', to_char(task.creation_date, 'DD/MM/YYYY'), task.creation_time) AS date_creation",
            'last_modification_date',
            'last_modification_time',
            "CONCAT_WS(' ', to_char(task.last_modification_date, 'DD/MM/YYYY'), task.last_modification_time) AS date_modification",
            "comment",
            "json_payload",
            "timestamp_log",
            "timestamp_log AS timestamp_log_hidden",
            "category",
        );
    }

    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        // ALL
        $form->setType("category", "hidden");
        $form->setType("timestamp_log_hidden", "hidden");

        // MODE CREER
        if ($maj == 0 || $crud == 'create') {
            $form->setType("type", "select");
            $form->setType("state", "select");
            $form->setType("stream", "select");
            $form->setType("json_payload", "textarea");
        }
        // MODE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("task", "hiddenstatic");
            $form->setType("state", "select");
            $form->setType("stream", "hiddenstatic");
            $form->setType("json_payload", "jsonprettyprint");
            $form->setType("timestamp_log", "jsontotab");
            $form->setType("type", "hiddenstatic");
            $form->setType("creation_date", "hidden");
            $form->setType("creation_time", "hidden");
            $form->setType("object_id", "hiddenstatic");
            $form->setType("dossier", "hiddenstatic");
            $form->setType("date_creation", "hiddenstatic");
            $form->setType("last_modification_date", "hidden");
            $form->setType("last_modification_time", "hidden");
            $form->setType("date_modification", "static");
        }
        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("state", "selecthiddenstatic");
            $form->setType("stream", "selecthiddenstatic");
            $form->setType('dossier', 'link');
            $form->setType('json_payload', 'jsonprettyprint');
            $form->setType("type", "selecthiddenstatic");
            $form->setType("creation_date", "hidden");
            $form->setType("creation_time", "hidden");
            $form->setType("date_creation", "static");
            $form->setType("last_modification_date", "hidden");
            $form->setType("last_modification_time", "hidden");
            $form->setType("date_modification", "static");
            $form->setType("timestamp_log", "jsontotab");
        }
    }

    function stateTranslation ($currentState) {
        switch ($currentState){
            case "draft":
                return __('brouillon');
                break;
            case "new":
                return __('à traiter');
                break;
            case "pending":
                return __('en cours');
                break;
            case "done":
                return __('terminé');
                break;
            case "archived":
                return __('archivé');
                break;
            case "error":
                return __('erreur');
                break;
            case "debug":
                return __('debug');
                break;
            case "canceled":
                return __('annulé');
                break;
        }
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        if($maj <= 3) {
            $contenu = array();
            foreach(array('DRAFT', 'NEW', 'PENDING', 'DONE', 'ERROR', 'DEBUG', 'ARCHIVED', 'CANCELED') as $key) {
                $const_name = 'STATUS_'.$key;
                $const_value = constant("self::$const_name");
                $contenu[0][] = $const_value;


                $contenu[1][] = $this->stateTranslation($const_value);

            }

            $form->setSelect("state", $contenu);

            $contenu_stream =array();
            $contenu_stream[0][0]="input";
            $contenu_stream[1][0]=__('input');
            $contenu_stream[0][1]="output";
            $contenu_stream[1][1]=__('output');
            $form->setSelect("stream", $contenu_stream);

            $tab_type = array_unique(array_merge(self::TASK_TYPE_SI, self::TASK_TYPE_SC));

            foreach ($tab_type as $type) {

                $contenu_type[0][] = $type;

                switch ($type) {
                    case "creation_DA":
                        $value_type = __('Création DA');
                        break;
                    case "create_DI":
                        $value_type = __('Création demande');
                        break;
                    case "creation_DI":
                        $value_type = __('Création DI');
                        break;
                    case "modification_DA":
                        $value_type = __('Modification DA');
                        break;
                    case "modification_DI":
                        $value_type = __('Modification DI');
                        break;
                    case "ajout_piece":
                        $value_type = __('Ajout pièce (sortant)');
                        break;
                    case "add_piece":
                        $value_type = __('Ajout pièce (entrant)');
                        break;
                    case "depot_DI":
                        $value_type = __('Dépôt DI');
                        break;
                    case "qualification_DI":
                        $value_type = __('Qualification DI');
                        break;
                    case "creation_consultation":
                        $value_type = __('Création consultation');
                        break;
                    case "decision_DI":
                        $value_type = __('Décision DI');
                        break;
                    case "envoi_CL":
                        $value_type = __('Envoi contrôle de légalité');
                        break;
                    case "pec_metier_consultation":
                        $value_type = __('PeC consultation');
                        break;
                    case "avis_consultation":
                        $value_type = __('Avis');
                        break;
                    case "prescription":
                        $value_type = __('Prescription');
                        break;
                    case "create_DI_for_consultation":
                        $value_type = __('Création DI pour consultation');
                        break;
                    case "create_message":
                        $value_type = __('Message');
                        break;
                    case "notification_recepisse":
                        $value_type = __('Notification récépissé');
                        break;
                    case "notification_instruction":
                        $value_type = __('Notification instruction');
                        break;
                    case "notification_decision":
                        $value_type = __('Notification décision');
                        break;
                    case "notification_service_consulte":
                        $value_type = __('Notification service consulté');
                        break;
                    case "notification_tiers_consulte":
                        $value_type = __('Notification tiers consulté');
                        break;
                    case "notification_signataire":
                        $value_type = __('Notification signataire');
                        break;
                    case "completude_DI":
                        $value_type = __('complétude DI');
                        break;
                    case "incompletude_DI":
                        $value_type = __('incomplétude DI');
                        break;
                    case "lettre_incompletude":
                        $value_type = __('Lettre au pétitionnaire d\'incompletude');
                        break;
                    case "lettre_majoration":
                        $value_type = __('Lettre au pétitionnaire de majoration');
                        break;
                }

                $contenu_type[1][] = $value_type;
            }

            $form->setselect('type', $contenu_type);
        }

        if ($maj == 3) {
            // Récupération du numéro du dossier si il n'est pas renseigné dans la tâche
            if ($form->val['dossier'] == '' || $form->val['dossier'] == null) {
                // Récupération de la payload de la taĉhe.
                // Si la tâche est une tâche input la payload est associée à la tâche.
                // Si la tâche est une tâche en output la payload est "calculé" à l'ouverture
                // du formulaire.
                if ($this->getVal('stream') == 'input') {
                    $json_payload = json_decode($this->getVal('json_payload'), true);
                } else {
                    $json_payload = json_decode($form->val['json_payload'], true);
                }
                // A partir de la payload de la tâche ont récupère les externals uid
                // Si un external uid de DI (dossier) existe ont le récupère et on stocke le numéro
                // pour l'afficher sur le formulaire.
                // Si l'external UID du DI n'existe pas on récupère celui du DA
                $external_uid = '';
                if (array_key_exists('external_uids', $json_payload)
                    && array_key_exists('dossier', $json_payload['external_uids'])
                ) {
                    $external_uid = $json_payload['external_uids']['dossier'];
                } elseif (array_key_exists('external_uids', $json_payload)
                    && array_key_exists('demande', $json_payload['external_uids'])) {
                    $external_uid = $json_payload['external_uids']['demande'];
                }
                // Recherche l'external uid dans la base de données pour récupèrer le numéro de
                // DI / DA correspondant. On stocke le numéro de dossier dans la propriété val
                // du formulaire pour pouvoir l'afficher
                if ($external_uid != '') {
                    $qres = $this->f->get_one_result_from_db_query(
                        sprintf(
                            'SELECT
                                lien_id_interne_uid_externe.dossier
                            FROM
                                %1$slien_id_interne_uid_externe
                            WHERE
                                lien_id_interne_uid_externe.external_uid = \'%2$s\'',
                            DB_PREFIXE,
                            $this->f->db->escapeSimple($external_uid)
                        ),
                        array(
                            "origin" => __METHOD__,
                        )
                    );
                    if (! empty($qres["result"])) {
                        $form->val['dossier'] = $qres["result"];
                    }
                }
            }

            // Vérifie si le numéro de dossier associé à la tâche existe dans la base.
            // Si c'est le cas ce numéro sera lié au dossier (DI ou DA) correspondant
            // TODO : vérifier la liste des tâches lié à des DA
            $obj_link = '';
            if ($form->val['type'] == "creation_DA" || $form->val['type'] == "modification_DA") {
                // Vérification que le numéro de DA affiché dans le formulaire existe
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            dossier_autorisation.dossier_autorisation
                        FROM
                            %1$sdossier_autorisation
                        WHERE
                            dossier_autorisation.dossier_autorisation = \'%2$s\'',
                        DB_PREFIXE,
                        $this->f->db->escapeSimple($form->val['dossier'])
                    ),
                    array(
                        "origin" => __METHOD__,
                    )
                );
                // Si on a un résultat c'est que le dossier existe, il faut afficher le lien
                if (! empty($qres["result"])) {
                    $obj_link = 'dossier_autorisation';
                }
            } else {
                // Vérification que le numéro de DI affiché dans le formulaire existe
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            dossier.dossier
                        FROM
                            %1$sdossier
                        WHERE
                            dossier.dossier = \'%2$s\'',
                        DB_PREFIXE,
                        $this->f->db->escapeSimple($form->val['dossier'])
                    ),
                    array(
                        "origin" => __METHOD__,
                    )
                );
                // Si on a un résultat c'est que le dossier existe, il faut afficher le lien
                if (! empty($qres["result"])) {
                    $obj_link = 'dossier_instruction';
                }
            }
            // Pour afficher le lien vers un dossier ont utilise un champ de type "link".
            // Pour paramétrer ce champs on a besoin de savoir :
            //  - quel objet est visé par le lien
            //  - le label (libellé) du lien
            //  - l'identifiant de l'objet qui sera utilisé dans le lien
            //  - le titre associé au lien
            // Pour cela on remplit le champs comme un select et les valeurs du select
            // contiennent les informations nécessaire à l'affichage du champs.
            $params = array(
                'obj' => $obj_link,
                'libelle' => $form->val['dossier'],
                'title' => "Consulter le dossier",
                'idx' => $form->val['dossier']
            );
            $form->setSelect("dossier", $params);
        }
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        // parent::setVal($form, $maj, $validation);
        //
        if ($this->getVal('stream') == "output"
            && ($this->getVal('state') !== self::STATUS_DONE
                || $this->getVal('json_payload') === "{}")) {
            //
            $form->setVal('json_payload', $this->view_form_json(true));
        } else {
            $form->setVal('json_payload', json_encode(json_decode($this->getVal('json_payload'), true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)); 
        }
        // Gestion du contenu de l'historique
        if ($this->getVal('timestamp_log') !== ''
            && $this->getVal('timestamp_log') !== null) {
            //
            $form->setVal('timestamp_log', $this->getVal('timestamp_log'));
        }
    }

    function setLib(&$form, $maj) {
        parent::setLib($form, $maj);

        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        $form->setLib('date_creation', __("Date de création"));
        $form->setLib('date_modification', __("Date de dernière modification"));
        $form->setLib('comment', __("commentaire"));

        // MODE different de CREER
        if ($maj != 0 || $crud != 'create') {
            $form->setLib('json_payload', '');
            $form->setLib("task", __("identifiant"));
            $form->setLib("Task_portal", __("task_portal"));
            $form->setLib("type", __("type"));
            $form->setLib("object_id", __("Réf. interne"));
            $form->setLib("stream", __("flux"));
            $form->setLib("timestamp_log", __("Historique"));
        }
    }

    public function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        $ret = parent::verifier($val, $dnu1, $dnu2);

        // une tâche entrante doit avoir un type et une payload non-vide
        if (isset($this->valF['stream']) === false || $this->valF['stream'] == 'input') {
            if (isset($this->valF['type']) === false) {
                $this->correct = false;
                $this->addToMessage(sprintf(
                    __("Le champ %s est obligatoire pour une tâche entrante."),
                    sprintf('<span class="bold">%s</span>', $this->getLibFromField('type'))
                ));
                $this->addToLog(__METHOD__.'(): erreur: '.$this->msg, DEBUG_MODE);
            }
            if (isset($this->valF['json_payload']) === false) {
                $this->correct = false;
                $this->addToMessage(sprintf(
                    __("Le champ %s est obligatoire pour une tâche entrante."),
                    sprintf('<span class="bold">%s</span>', $this->getLibFromField('json_payload'))
                ));
                $this->addToLog(__METHOD__.'(): erreur: '.$this->msg, DEBUG_MODE);
            }
        }

        // les JSONs doivent être décodables
        foreach(array('json_payload', 'timestamp_log') as $key) {
            if (isset($this->valF[$key]) && ! empty($this->valF[$key]) && (
                    is_array(json_decode($this->valF[$key], true)) === false
                    || json_last_error() !== JSON_ERROR_NONE)) {
                $this->correct = false;
                $champ_text = sprintf('<span class="bold">%s</span>', $this->getLibFromField($key));
                $this->addToMessage(sprintf(
                    __("Le champ %s doit être dans un format JSON valide (erreur: %s).".
                    "<p>%s valF:</br><pre>%s</pre></p>".
                    "<p>%s val:</br><pre>%s</pre></p>".
                    "<p>%s POST:</br><pre>%s</pre></p>".
                    "<p>%s submitted POST value:</br><pre>%s</pre></p>"),
                    $champ_text,
                    json_last_error() !== JSON_ERROR_NONE ? json_last_error_msg() : __('invalide'),
                    $champ_text,
                    $this->valF[$key],
                    $champ_text,
                    $val[$key],
                    $champ_text,
                    isset($_POST[$key]) ? $_POST[$key] : '',
                    $champ_text,
                    $this->f->get_submitted_post_value($key)
                ));
                $this->addToLog(__METHOD__.'(): erreur JSON: '.$this->msg, DEBUG_MODE);
            }
        }

        // une tâche entrante doit avoir une payload avec les clés requises
        if ($this->correct && (isset($this->valF['stream']) === false ||
                               $this->valF['stream'] == 'input')) {

            // décode la payload JSON
            // TODO : COMMENTER
            $json_payload = json_decode($this->valF['json_payload'], true);

            // défini une liste de chemin de clés requises
            $paths = array();
            if ($this->valF['category'] === PLATAU) {
                $paths = array(
                    'external_uids/dossier'
                );
            }

            // tâche de type création de DI/DA
            if (isset($this->valF['type']) !== false && $this->valF['type'] == 'create_DI_for_consultation') {

                $paths = array_merge($paths, array(
                    'dossier/dossier',
                    'dossier/dossier_autorisation_type_detaille_code',
                    'dossier/date_demande',
                    'dossier/depot_electronique',
                ));

                // si l'option commune est activée (mode MC)
                if ($this->f->is_option_dossier_commune_enabled()) {
                    $paths[] = 'dossier/insee';
                }

                // présence d'un moyen d'identifier la collectivité/le service
                if (! isset($json_payload['external_uids']['acteur']) &&
                        ! isset($json_payload['dossier']['om_collectivite'])) {
                    $this->correct = false;
                    $this->addToMessage(sprintf(
                        __("L'une des clés %s ou %s est obligatoire dans le contenu du champ %s pour une tâche entrante."),
                        sprintf('<span class="bold">%s</span>', 'external_uids/acteur'),
                        sprintf('<span class="bold">%s</span>', 'dossier/om_collectivite'),
                        sprintf('<span class="bold">%s</span>', $this->getLibFromField('json_payload'))
                    ));
                    $this->addToLog(__METHOD__.'(): erreur: '.$this->msg, DEBUG_MODE);
                }
            }

            // pas d'erreur déjà trouvée
            if($this->correct) {

                // pour chaque chemin
                foreach($paths as $path) {

                    // décompose le chemin
                    $tokens = explode('/', $path);
                    $cur_depth = $json_payload;

                    // descend au et à mesure dans l'arborescence du chemin
                    foreach($tokens as $token) {

                        // en vérifiant que chaque élément du chemin est défini et non-nul
                        if (isset($cur_depth[$token]) === false) {

                            // sinon on produit une erreur
                            $this->correct = false;
                            $this->addToMessage(sprintf(
                                __("La clé %s est obligatoire dans le contenu du champ %s pour une tâche entrante."),
                                sprintf('<span class="bold">%s</span>', $path),
                                sprintf('<span class="bold">%s</span>', $this->getLibFromField('json_payload'))
                            ));
                            $this->addToLog(__METHOD__.'(): erreur: '.$this->msg, DEBUG_MODE);
                            break 2;
                        }
                        $cur_depth = $cur_depth[$token];
                    }
                }
            }
        }

        return $ret && $this->correct;
    }

    /**
     * [task_exists description]
     * @param  string $type      [description]
     * @param  string $object_id [description]
     * @param  bool   $is_not_done   [description]
     * @return [type]            [description]
     */
    public function task_exists(string $type, string $object_id, string $dossier = null, bool $is_not_done = true) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    task
                FROM
                    %1$stask
                WHERE
                    %2$s
                    type = \'%3$s\'
                    AND (
                        object_id = \'%4$s\'
                        %5$s
                    )
                    AND state != \'%6$s\'',
                DB_PREFIXE,
                $is_not_done == true ? 'state != \''.self::STATUS_DONE.'\' AND' : '',
                $type,
                $object_id,
                $dossier !== null ? sprintf('OR dossier = \'%s\'', $dossier) : '',
                self::STATUS_CANCELED
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if ($qres["result"] !== null && $qres["result"] !== "") {
            return $qres["result"];
        }
        return false;
    }

    /**
     * Permet la recherche multi-critères des tasks.
     *
     * @param  array  $search_values Chaque entrée du tableau est une ligne dans le WHERE
     * @return mixed                 Retourne le résultat de la requête ou false
     */
    public function task_exists_multi_search(array $search_values) {
        $query = sprintf('
            SELECT *
            FROM %1$stask
            %2$s
            %3$s
            ORDER BY task ASC
            ',
            DB_PREFIXE,
            empty($search_values) === false ? ' WHERE ' : '',
            implode(' AND ', $search_values)
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
            )
        );
        if (count($res['result']) > 0) {
            return $res['result'];
        }
        return false;
    }

    /**
     * TRIGGER - triggerajouter.
     *
     * @param string $id
     * @param null &$dnu1 @deprecated  Ne pas utiliser.
     * @param array $val Tableau des valeurs brutes.
     * @param null $dnu2 @deprecated  Ne pas utiliser.
     *
     * @return boolean
     */
    function triggerajouter($id, &$dnu1 = null, $val = array(), $dnu2 = null) {

        // tâche entrante
        if (isset($this->valF['stream']) === false || $this->valF['stream'] == 'input') {

            // décode la paylod JSON pour extraire les données métiers à ajouter
            // en tant que métadonnées de la tâche
            $json_payload = json_decode($this->valF['json_payload'], true);

            // si la tâche possède déjà une clé dossier
            if (isset($json_payload['dossier']['dossier']) &&
                    ! empty($json_payload['dossier']['dossier'])) {
                $this->valF["dossier"] = $json_payload['dossier']['dossier'];
            }
        }

        // gestion d'une tache de type notification et de category mail
        if (isset($val['type'])
            && (($val['type'] === 'notification_instruction' || $val['type'] === 'notification_decision')
                && isset($val['category'])
                && $val['category'] === 'mail')
            || $val['type'] === 'notification_service_consulte'
            || $val['type'] === 'notification_tiers_consulte'
            || $val['type'] === 'notification_depot_demat'
            || $val['type'] === 'notification_commune'
            || $val['type'] === 'notification_signataire'
            ) {
            // Récupère la payload de la tache
            $data = array();
            $data['instruction_notification'] = $this->get_instruction_notification_data(
                $this->valF['category'],
                'with-id',
                array('with-id' => $this->valF['object_id'])
            );
            $data['dossier'] = $this->get_dossier_data($this->valF['dossier']);

            // Récupère l'instance de la notification
            $inst_notif = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction_notification",
                "idx" => $val['object_id'],
            ));
            // Envoi le mail et met à jour le suivi
            $envoiMail = $inst_notif->send_mail_notification($data, $val['type']);
            // Passage de la tache à done si elle a réussi et à error
            // si l'envoi a échoué
            $this->valF['state'] = 'done';
            if ($envoiMail === false) {
                $this->valF['state'] = 'error';
            }
        }
    }

    /**
     * TRIGGER - triggermodifier.
     *
     * @param string $id
     * @param null &$dnu1 @deprecated  Ne pas utiliser.
     * @param array $val Tableau des valeurs brutes.
     * @param null $dnu2 @deprecated  Ne pas utiliser.
     *
     * @return boolean
     */
    function triggermodifier($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        parent::triggermodifier($id, $dnu1, $val, $dnu2);
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // Mise à jour des valeurs, notamment du timestamp_log en fonction de plusieurs critères
        $values = array(
            'state' => $this->valF['state'],
            'object_id' => $this->valF['object_id'],
            'comment' => $this->valF['comment'],
        );
        $new_values = $this->set_values_for_update($values);
        if ($new_values === false) {
            $this->addToLog(__METHOD__."(): erreur timestamp log", DEBUG_MODE);
            return false;
        }

        // Mise à jour des valeurs
        $this->valF['timestamp_log'] = $new_values['timestamp_log'];
        $this->valF['state'] = $new_values['state'];
        $this->valF['object_id'] = $new_values['object_id'];
        $this->valF['last_modification_date'] = date('Y-m-d');
        $this->valF['last_modification_time'] = date('H:i:s');
        if ($val['stream'] === 'output') {
            // Lorsque la task passe d'un état qui n'est pas "done" à l'état "done"
            if ($this->getVal("state") !== self::STATUS_DONE
                && $this->valF['state'] === self::STATUS_DONE) {
                //
                $this->valF['json_payload'] = $this->view_form_json(true);
            }
            // Lorsque la task passe d'un état "done" à un état qui n'est pas "done"
            if ($this->getVal("state") === self::STATUS_DONE
                && $this->valF['state'] !== self::STATUS_DONE) {
                //
                $this->valF['json_payload'] = "{}";
            }
        }

        return true;
    }


    /**
     * Applique nouvelle valeur après traitement.
     *
     * @param array $params Tableau des valeurs en entrées
     * @return array        Tableau des valeurs en sorties
     */
    public function set_values_for_update($params = array()) {

        // Récupération du timestamp_log existant
        $timestamp_log = $this->get_timestamp_log();
        if ($timestamp_log === false) {
            return false;
        }

        // Vérification des object_id précédent en cas de tentative d'appliquer
        // l'état CANCELED sur la tâche
        if (isset($params['state']) === true
            && $params['state'] === self::STATUS_CANCELED) {
            // Récupération du journal d'activité de la tâche sous forme de tableau
            // trié par ordre décroissant
            $log = $timestamp_log;
            krsort($log);
            // Pour chaque entrée dans le journal d'activité de la tâche :
            // - vérification de la présence de l'object_id précédent
            // - vérification que l'object_id précédent existe toujours dans la base de données
            // - l'object_id est mise à jour avec la valeur de l'object_id précédent
            // - le state n'est pas modifié
            // - sortie du traitement dès que le premier object_id précédent existant est trouvé
            // - si aucun object_id précédent existant n'est trouvé alors ni le state, ni l'object_id n'est modifiés
            foreach ($log as $key => $value) {
                //
                if (isset($value['prev_object_id']) === true
                    && $this->getVal('object_id') !== $value['prev_object_id']) {
                    // Récupère la liste des tables potentielles pour un type de tâche
                    $tables = $this->get_tables_by_task_type($this->getVal('type'), $this->getVal('stream'));
                    foreach ($tables as $table) {
                        // Vérifie s'il y a un ou aucun résultat
                        $qres = $this->f->get_one_result_from_db_query(
                            sprintf(
                                'SELECT
                                    COUNT(%2$s)
                                FROM
                                    %1$s%2$s
                                WHERE
                                    %2$s::CHARACTER VARYING = \'%3$s\'',
                                DB_PREFIXE,
                                $table,
                                $value['prev_object_id']
                            ),
                            array(
                                "origin" => __METHOD__,
                                "force_return" => true,
                            )
                        );
                        if ($qres["code"] !== "OK") {
                            return $this->end_treatment(__METHOD__, false);
                        }
                        // Affectation des valeurs et sortie de la boucle
                        if ($qres["result"] == '1') {
                            $params['object_id'] = $value['prev_object_id'];
                            $params['state'] = $this->getVal('state');
                            break;
                        }
                    }
                    // Sortie de la boucle si les valeurs sont affectées
                    if ($params['object_id'] !== null
                        && $params['object_id'] === $value['prev_object_id']) {
                        //
                        break;
                    }
                }
            }
        }

        // Mise à jour du journal d'activité de la tâche
        array_push($timestamp_log, array(
            'modification_date' => date('Y-m-d H:i:s'),
            'object_id' => $params['object_id'] !== null ? $params['object_id'] : $this->getVal('object_id'),
            'prev_object_id' => $this->getVal('object_id'),
            'state' =>  $params['state'],
            'prev_state' => $this->getVal('state'),
            'comment' => isset($params['comment']) ? $params['comment'] : $this->getVal('comment'),
        ));
        //
        $timestamp_log = json_encode($timestamp_log);
        

        // Les nouvelles valeurs après vérification des critères
        $result = array(
            'timestamp_log' => $timestamp_log,
            'object_id' => $params['object_id'],
            'state' => $params['state'],
            'comment' => $params['comment'],
        );
        return $result;
    }

    
    /**
     * TRIGGER - triggermodifierapres.
     *
     * @param string $id
     * @param null &$dnu1 @deprecated  Ne pas utiliser.
     * @param array $val Tableau des valeurs brutes.
     * @param null $dnu2 @deprecated  Ne pas utiliser.
     *
     * @return boolean
     */
    public function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        parent::triggermodifierapres($id, $dnu1, $val, $dnu2);

        // Suivi des notificiations
        // En cas de changement de l'état de la tâche de notification, alors
        // le suivi des dates de la notification et de l'instruction, est effectué
        if (isset($val['category']) === true
            && $val['category'] === PORTAL
            && isset($val['type']) === true
            && ($val['type'] === 'notification_recepisse'
                || $val['type'] === 'notification_instruction'
                || $val['type'] === 'notification_decision'
                || $val['type'] === 'notification_service_consulte'
                || $val['type'] === 'notification_tiers_consulte')) {
            //
            if (isset($this->valF['state']) === true
                && $this->valF['state'] !== $this->getVal('state')
                && $this->valF['state'] !== self::STATUS_CANCELED) {
                //
                $inst_in = $this->f->get_inst__om_dbform(array(
                    "obj" => "instruction_notification",
                    "idx" => $val['object_id'],
                ));
                $valF_in = array();
                foreach ($inst_in->champs as $champ) {
                    $valF_in[$champ] = $inst_in->getVal($champ);
                }
                // Par défaut la date d'envoi et la date de premier accès sur
                // la notification ne sont pas renseignées
                $valF_in['date_envoi'] = null;
                $valF_in['date_premier_acces'] = null;
                // Lorsque la tâche est correctement traitée
                if ($this->valF['state'] === self::STATUS_DONE) {
                    //
                    $valF_in['statut'] = __("envoyé");
                    $valF_in['commentaire'] = __("Notification traitée");
                    $valF_in['date_envoi'] = date('d/m/Y H:i:s');
                    // Si l'instruction possède un document lié, alors ses dates
                    // de suivi sont mises à jour
                    $inst_instruction = $this->f->get_inst__om_dbform(array(
                        "obj" => "instruction",
                        "idx" => $inst_in->getVal('instruction'),
                    ));
                    if ($inst_instruction->has_an_edition() === true) {
                        $valF_instruction = array();
                        foreach ($inst_instruction->champs as $champ) {
                            $valF_instruction[$champ] = $inst_instruction->getVal($champ);
                        }
                        $valF_instruction['date_envoi_rar'] = date('d/m/Y');
                        $valF_instruction['date_retour_rar'] = date('d/m/Y', strtotime('now + 1 day'));
                        // Action spécifique pour identifier que la modification
                        // est une notification de demandeur
                        $inst_instruction->setParameter('maj', 175);
                        $update_instruction = $inst_instruction->modifier($valF_instruction);
                        if ($update_instruction === false) {
                            $this->addToLog(__METHOD__."(): ".$inst_instruction->msg, DEBUG_MODE);
                            return false;
                        }
                    }
                }
                // En cas d'erreur lors du traitement de la task
                if ($this->valF['state'] === self::STATUS_ERROR) {
                    $valF_in['statut'] = __("échec");
                    $valF_in['commentaire'] = __("Le traitement de la notification a échoué");
                }
                // Met à jour la notification
                $inst_in->setParameter('maj', 1);
                $update_in = $inst_in->modifier($valF_in);
                if ($update_in === false) {
                    $this->addToLog(__METHOD__."(): ".$inst_in->msg, DEBUG_MODE);
                    return false;
                }
            }
        }

        // Envoi au contrôle de légalité
        // En cas de changement de l'état de la tâche envoi_CL, alors le suivi
        // des dates de l'instruction est effectué
        if ($val['type'] === 'envoi_CL'
            && isset($this->valF['state']) === true
            && $this->valF['state'] === self::STATUS_DONE) {
            //
            $inst_instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => $this->getVal('object_id'),
            ));
            if ($inst_instruction->has_an_edition() === true) {
                $valF_instruction = array();
                foreach ($inst_instruction->champs as $champ) {
                    $valF_instruction[$champ] = $inst_instruction->getVal($champ);
                }
            }
            $valF_instruction['date_envoi_controle_legalite'] = date("Y-m-d");
            $inst_instruction->setParameter('maj', 1);
            $update_instruction = $inst_instruction->modifier($valF_instruction);
            if ($update_instruction === false) {
                $this->addToLog(__METHOD__."(): ".$inst_instruction->msg, DEBUG_MODE);
                return false;
            }
        }

        //
        return true;
    }

    /**
     * TREATMENT - add_task
     * Ajoute un enregistrement.
     *
     * @param  array $params Tableau des paramètres
     * @return boolean
     */
    public function add_task($params = array()) {
        $this->begin_treatment(__METHOD__);

        // Vérifie si la task doit être ajoutée en fonction du mode de l'application,
        // seulement pour les tasks output
        $task_types_si = self::TASK_TYPE_SI;
        $task_types_sc = self::TASK_TYPE_SC;
        $stream = isset($params['val']['stream']) === true ? $params['val']['stream'] : 'output';
        if ($stream === 'output'
            && isset($params['val']['type']) === true
            && $this->f->is_option_mode_service_consulte_enabled() === true
            && in_array($params['val']['type'], $task_types_sc) === false) {
            //
            return $this->end_treatment(__METHOD__, true);
        }
        if ($stream === 'output'
            && isset($params['val']['type']) === true
            && $this->f->is_option_mode_service_consulte_enabled() === false
            && in_array($params['val']['type'], $task_types_si) === false) {
            //
            return $this->end_treatment(__METHOD__, true);
        }

        //
        $timestamp_log = json_encode(array());

        //
        $category = isset($params['val']['category']) === true ? $params['val']['category'] : $this->category;

        // Si la tâche est de type ajout_piece et de stream input alors on ajoute le fichier
        // et on ajoute l'uid dans le champ json_payload avant l'ajout de la tâche
        if (isset($params['val']['type'])
            && in_array($params['val']['type'], self::TASK_WITH_DOCUMENT)
            && isset($params['val']['stream'])
            && $params['val']['stream'] == "input" ) {
            //
            $json_payload = json_decode($params['val']['json_payload'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addToMessage(__("Le contenu JSON de la tâche n'est pas valide."));
                return $this->end_treatment(__METHOD__, false);
            }
            if (isset($json_payload['document_numerise']["file_content"]) === true
                && empty($json_payload['document_numerise']["file_content"]) === false) {
                //
                $document_numerise = $json_payload['document_numerise'];
                $file_content = base64_decode($document_numerise["file_content"]);
                if ($file_content === false){
                    $this->addToMessage(__("Le contenu du fichier lié à la tâche n'a pas pu etre recupere."));
                    return $this->end_treatment(__METHOD__, false);
                }
                $metadata = array(
                    "filename" => $document_numerise['nom_fichier'],
                    "size" => strlen($file_content),
                    "mimetype" => $document_numerise['file_content_type'],
                    "date_creation" => isset($document_numerise['date_creation']) === true ? $document_numerise['date_creation'] : date("Y-m-d"),
                );
                $uid_fichier = $this->f->storage->create($file_content, $metadata, "from_content", "task.uid_fichier");
                if ($uid_fichier === OP_FAILURE) {
                    $this->addToMessage(__("Erreur lors de la creation du fichier lié à la tâche."));
                    return $this->end_treatment(__METHOD__, false);
                }
                $json_payload["document_numerise"]["uid"] = $uid_fichier;
                // Le fichier a été ajouté nous n'avons plus besoin du champ file_content dans la payload
                unset($json_payload["document_numerise"]["file_content"]);
                $params['val']['json_payload'] = json_encode($json_payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            }
        }

        // Valeurs de la tâche
        $valF = array(
            'task' => '',
            'type' => $params['val']['type'],
            'timestamp_log' => $timestamp_log,
            'state' => isset($params['val']['state']) === true ? $params['val']['state'] : self::STATUS_NEW,
            'object_id' => isset($params['val']['object_id']) ? $params['val']['object_id'] : '',
            'dossier' => isset($params['val']['dossier']) ? $params['val']['dossier'] : '',
            'stream' => $stream,
            'json_payload' => isset($params['val']['json_payload']) === true ? $params['val']['json_payload'] : '{}',
            'category' => $category,
            'creation_date' => date('Y-m-d'),
            'creation_time' => date('H:i:s'),
            'last_modification_date' => null,
            'last_modification_time' => null,
            'comment' => null,
        );

        // Gestion de la mise à jour des tâches sortantes
        $typeNonConcerne = array(
            'notification_recepisse',
            'notification_instruction',
            'notification_decision',
            'notification_service_consulte',
            'notification_tiers_consulte',
            'notification_depot_demat',
            'notification_commune',
            'notification_signataire',
        );
        if ($valF["stream"] == "output"
            && ! in_array($valF['type'], $typeNonConcerne)) {
            // Vérification de l'existance d'une tâche pour l'objet concerné
            // La vérification diffère en fonction de certains types de tâche
            $search_values_common = array(
                sprintf('state != \'%s\'', self::STATUS_CANCELED),
                sprintf('state != \'%s\'', self::STATUS_DONE),
            );
            $search_values_others = array(
                sprintf('type = \'%s\'', $valF['type']),
                sprintf('(object_id = \'%s\' OR dossier = \'%s\')', $valF['object_id'], $valF['dossier']),
            );
            $search_values_specifics = array(
                sprintf('object_id = \'%s\'', $valF['object_id']),
            );

            // Recherche multi-critères sur les tâches
            // Si l'object id/dossier à des tâches de type $valF['type'] qui lui est associé
            // Et que ces tâches ont des statut différents de canceled et done
            // Alors on récupère ces tâches
            // Sinon return false
            $task_exists = $this->task_exists_multi_search(array_merge($search_values_common, $search_values_others));

            // S'il n'existe pas de tâche de type 'modification DI' pour l'object id/dossier
            if ($valF['type'] === 'modification_DI' && $task_exists === false) {
                // On se réfère à la tâche de type 'creation DI' de l'object id
                $task_exists = $this->task_exists_multi_search(array_merge($search_values_common, $search_values_specifics, array("type = 'creation_DI'")));
            }
            // S'il n'existe pas de tâche de type 'modification DA' pour l'object id/dossier
            if ($valF['type'] === 'modification_DA' && $task_exists === false) {
                // On se réfère à la tâche de type 'creation DA' de l'object id
                $task_exists = $this->task_exists_multi_search(array_merge($search_values_common, $search_values_specifics, array("type = 'creation_DA'")));
            }
            if ($valF['type'] === 'ajout_piece') {
                // On se réfère à la tâche de type 'ajout piece' de l'object id
                $task_exists = $this->task_exists_multi_search(array_merge($search_values_common, $search_values_specifics, array("type = 'ajout_piece'")));
            }
            if ($valF['type'] === 'creation_consultation') {
                // On se réfère à la tâche de type 'creation consultation' de l'object id
                $task_exists = $this->task_exists_multi_search(array_merge($search_values_common, $search_values_specifics, array("type = 'creation_consultation'")));
            }
            // S'il existe une tâche pour l'objet concerné, pas d'ajout de nouvelle
            // tâche mais mise à jour de l'existante
            if ($task_exists !== false) {
                // Plusieurs tâches pourraient exister, elles sont contôler par ordre croissant
                foreach ($task_exists as $task) {
                    $inst_task = $this->f->get_inst__om_dbform(array(
                        "obj" => "task",
                        "idx" => $task['task'],
                    ));
                    $update_state = $inst_task->getVal('state');
                    if (isset($params['update_val']['state']) === true) {
                        $update_state = $params['update_val']['state'];
                    }
                    $object_id = $inst_task->getVal('object_id');
                    if (!empty($valF['object_id'])) {
                        $object_id = $valF['object_id'];
                    }
                    // Pour être mise à jour, la tâche existante ne doit pas être en cours de traitement
                    $task_pending = $inst_task->getVal('state') === self::STATUS_PENDING
                        && $update_state === self::STATUS_PENDING
                        && $inst_task->getVal('object_id') !== $object_id;
                    if ($task_pending === false) {
                        $update_params = array(
                            'val' => array(
                                'state' => $update_state,
                            ),
                            'object_id' => $object_id,
                        );
                        return $inst_task->update_task($update_params);
                    }
                }
            }
        }
        $add = $this->ajouter($valF);
        $this->addToLog(__METHOD__."(): retour de l'ajout de tâche: ".var_export($add, true), VERBOSE_MODE);
        if ($add === false) {
            $this->addToLog(__METHOD__."(): ".$this->msg, DEBUG_MODE);
            return $this->end_treatment(__METHOD__, false);
        }
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * TREATMENT - update_task
     * Met à jour l'enregistrement instancié.
     *
     * @param  array  $params Tableau des paramètres
     * @return boolean
     */
    public function update_task($params = array()) {
        $this->begin_treatment(__METHOD__);

        // Mise à jour de la tâche
        $valF = array(
            'task' => $this->getVal($this->clePrimaire),
            'type' => $this->getVal('type'),
            'timestamp_log' => '[]',
            'state' => $params['val']['state'],
            'object_id' => isset($params['object_id']) == true ? $params['object_id'] : $this->getVal('object_id'),
            'stream' => $this->getVal('stream'),
            'dossier' => $this->getVal('dossier'),
            'json_payload' => $this->getVal('json_payload'),
            'category' => $this->getVal('category'),
            'creation_date' => $this->getVal('creation_date'),
            'creation_time' => $this->getVal('creation_time'),
            'last_modification_date' => date('Y-m-d'),
            'last_modification_time' => date('H:i:s'),
            'comment' => isset($params['comment']) == true ? $params['comment'] : $this->getVal('comment'),
        );
        $update = $this->modifier($valF);
        if ($update === false) {
            $this->addToLog($this->msg, DEBUG_MODE);
            return $this->end_treatment(__METHOD__, false);
        }
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Récupère le journal d'horodatage dans le champ timestamp_log de
     * l'enregistrement instancié.
     *
     * @param  array  $params Tableau des paramètres
     * @return array sinon false en cas d'erreur
     */
    protected function get_timestamp_log($params = array()) {
        $val = $this->getVal('timestamp_log');
        if ($val === '') {
            $val = json_encode(array());
        }
        if($this->isJson($val) === false) {
            return false;
        }
        return json_decode($val, true);
    }

    /**
     * VIEW - view_json_data
     * Affiche l'enregistrement dans le format JSON.
     *
     * @return void
     */
    public function view_json_data() {
        $this->checkAccessibility();
        $this->f->disableLog();
        if ($this->getParameter('idx') !== ']'
            && $this->getParameter('idx') !== '0') {
            //
            $this->view_form_json();
        }
        else {
            $this->view_tab_json();
        }
    }

    protected function view_tab_json() {
        $where = '';
        $category = null;
        // Liste des paramètres possibles pour la recherche des tâches
        $params = array(
            'task',
            'type',
            'state',
            'object_id',
            'dossier',
            'stream',
            'category',
            'lien_id_interne_uid_externe',
            'object',
            'external_uid',
        );
        // Pour chaque paramètre possible, vérification de son existance et de sa
        // valeur pour compléter la requête de recherche
        foreach ($params as $param) {
            //
            if ($this->f->get_submitted_get_value($param) !== null
                && $this->f->get_submitted_get_value($param) !== '') {
                // Condition spécifique au champ 'category'
                if ($param === 'category') {
                    $category = $this->f->get_submitted_get_value('category');
                }
                //
                $where_or_and = 'WHERE';
                if ($where !== '') {
                    $where_or_and = 'AND';
                }
                $table = 'task';
                if ($param === 'lien_id_interne_uid_externe'
                    || $param === 'object'
                    || $param === 'external_uid') {
                    //
                    $table = 'lien_id_interne_uid_externe';
                }
                $where .= sprintf(' %s %s.%s = \'%s\' ', $where_or_and, $table, $param, $this->f->get_submitted_get_value($param));
            }
        }
        //
        $query = sprintf('
            SELECT
                DISTINCT (task.task),
                task.type,
                task.object_id,
                task.dossier,
                task.stream,
                task.category,
                task.creation_date,
                task.creation_time,
                task.last_modification_date,
                task.last_modification_time,
                task.comment
            FROM %1$stask
            LEFT JOIN %1$slien_id_interne_uid_externe
                ON task.object_id = lien_id_interne_uid_externe.object_id
                AND task.category = lien_id_interne_uid_externe.category
            %2$s
            ORDER BY task ASC
            ',
            DB_PREFIXE,
            $where
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            return false;
        }
        $list_tasks = array();
        foreach ($res['result'] as $task) {
            if ($task['stream'] === 'output') {
                $task['external_uids'] = array_merge(
                    $this->get_all_external_uids($task['dossier'], array(), $category !== null ? $category : $task['category']),
                    $this->get_all_external_uids($task['object_id'], array(), $category !== null ? $category : $task['category'])
                );
            }
            $list_tasks[$task['task']] = $task;
        }
        echo(json_encode($list_tasks));
    }

    protected function get_dossier_data(string $dossier) {
        $val_di = array();
        $inst_di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $dossier,
        ));
        if (empty($inst_di->val) === true) {
            return $val_di;
        }
        $val_di = $inst_di->get_json_data();
        if ($val_di['dossier_instruction_type_code'] === 'T') {
            $val_di['date_decision_transfert'] = $val_di['date_decision'];
        }
        unset($val_di['initial_dt']);
        unset($val_di['log_instructions']);
        return $val_di;
    }

    protected function get_dossier_autorisation_data(string $da) {
        $val_da = array();
        $inst_da = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => $da,
        ));
        $val_da = $inst_da->get_json_data();
        return $val_da;
    }

    protected function get_donnees_techniques_data(string $fk_idx, string $fk_field) {
        $val_dt = array();
        $inst_dt = $this->f->get_inst__by_other_idx(array(
            "obj" => "donnees_techniques",
            "fk_field" => $fk_field,
            "fk_idx" => $fk_idx,
        ));
        $val_dt = array(
            'donnees_techniques' => $inst_dt->getVal($inst_dt->clePrimaire),
            'cerfa' => $inst_dt->getVal('cerfa'),
        );
        $val_dt = array_merge($val_dt, $inst_dt->get_donnees_techniques_applicables());
        if (isset($val_dt['am_exist_date']) === true) {
            $val_dt['am_exist_date_num'] = '';
            if (is_numeric($val_dt['am_exist_date']) === true) {
                $val_dt['am_exist_date_num'] = $val_dt['am_exist_date'];
            }
        }
        // Correspond à la nomenclature de Plat'AU STATUT_INFO
        $val_dt['tax_statut_info'] = 'Déclaré';
        //
        if ($inst_dt->is_tab_surf_ssdest_enabled() === true) {
            $fields_tab_surf_dest = $inst_dt->get_fields_tab_surf_dest();
            foreach ($fields_tab_surf_dest as $field) {
                if (isset($val_dt[$field]) === true) {
                    unset($val_dt[$field]);
                }
            }
        } else {
            $fields_tab_surf_ssdest = $inst_dt->get_fields_tab_surf_ssdest();
            foreach ($fields_tab_surf_ssdest as $field) {
                if (isset($val_dt[$field]) === true) {
                    unset($val_dt[$field]);
                }
            }
        }
        // Correspond à la nouvelle ligne CERFA v7 dans le DENSI imposition 1.2.3
        if (isset($val_dt['tax_su_non_habit_surf2']) === true
            && isset($val_dt['tax_su_non_habit_surf3']) === true
            && (($val_dt['tax_su_non_habit_surf2'] !== null
                    && $val_dt['tax_su_non_habit_surf2'] !== '')
                || ($val_dt['tax_su_non_habit_surf3'] !== null
                    && $val_dt['tax_su_non_habit_surf3'] !== ''))) {
            //
            $val_dt['tax_su_non_habit_surf8'] = intval($val_dt['tax_su_non_habit_surf2']) + intval($val_dt['tax_su_non_habit_surf3']);
        }
        if (isset($val_dt['tax_su_non_habit_surf_stat2']) === true
            && isset($val_dt['tax_su_non_habit_surf_stat3']) === true
            && (($val_dt['tax_su_non_habit_surf_stat2'] !== null
                    && $val_dt['tax_su_non_habit_surf_stat2'] !== '')
                || ($val_dt['tax_su_non_habit_surf_stat3'] !== null
                    && $val_dt['tax_su_non_habit_surf_stat3'] !== ''))) {
            //
            $val_dt['tax_su_non_habit_surf_stat8'] = intval($val_dt['tax_su_non_habit_surf_stat2']) + intval($val_dt['tax_su_non_habit_surf_stat3']);
        }
        // Cas particulier d'un projet réduit à l'extension d'une habitation existante
        $particular_case = false;
        $fields_tab_crea_loc_hab = $inst_dt->get_fields_tab_crea_loc_hab();
        foreach ($fields_tab_crea_loc_hab as $field) {
            if (isset($val_dt[$field]) === false
                || (isset($val_dt[$field]) === true
                    && ($val_dt[$field] === null
                        || $val_dt[$field] === ''))) {
                //
                $particular_case = true;
            }
        }
        if ($particular_case === true) {
            if (isset($val_dt['tax_ext_pret']) === true
                && $val_dt['tax_ext_pret'] === 'f') {
                //
                $val_dt['tax_su_princ_surf1'] = isset($val_dt['tax_surf_tot_cstr']) === true ? $val_dt['tax_surf_tot_cstr'] : '';
                $val_dt['tax_su_princ_surf_stat1'] = isset($val_dt['tax_surf_loc_stat']) === true ? $val_dt['tax_surf_loc_stat'] : '';
            }
            if (isset($val_dt['tax_ext_pret']) === true
                && $val_dt['tax_ext_pret'] === 't') {
                //
                if (isset($val_dt['tax_ext_desc']) === true) {
                    if (preg_match('/[pP].*[lL].*[aA].*[iI]/', $val_dt['tax_ext_desc']) === 1
                        || preg_match('/[lL].*[lL].*[tT].*[sS]/', $val_dt['tax_ext_desc']) === 1) {
                        //
                        $val_dt['tax_su_princ_surf2'] = isset($val_dt['tax_surf_tot_cstr']) === true ? $val_dt['tax_surf_tot_cstr'] : '';
                        $val_dt['tax_su_princ_surf_stat2'] = isset($val_dt['tax_surf_loc_stat']) === true ? $val_dt['tax_surf_loc_stat'] : '';
                    }
                    // if (preg_match('/[pP].*[tT].*[zZ]/', $val_dt['tax_ext_desc']) === 1) {
                    //     $val_dt['tax_su_princ_surf4'] = $val_dt['tax_surf_tot_cstr'];
                    //     $val_dt['tax_su_princ_surf_stat4'] = $val_dt['tax_surf_loc_stat'];
                    // }
                    // if (preg_match('/[pP].*[lL].*[uU].*[sS]/', $val_dt['tax_ext_desc']) === 1
                    //     || preg_match('/[lL].*[eE].*[sS]/', $val_dt['tax_ext_desc']) === 1
                    //     || preg_match('/[pP].*[sS].*[lL].*[aA]/', $val_dt['tax_ext_desc']) === 1
                    //     || preg_match('/[pP].*[lL].*[sS]/', $val_dt['tax_ext_desc']) === 1
                    //     || preg_match('/[lL].*[lL].*[sS]/', $val_dt['tax_ext_desc']) === 1) {
                    //     //
                    //     $val_dt['tax_su_princ_surf3'] = $val_dt['tax_surf_tot_cstr'];
                    //     $val_dt['tax_su_princ_surf_stat3'] = $val_dt['tax_surf_loc_stat'];
                    // }
                }
            }
        }
        // Cas particulier de la surface taxable démolie
        if (isset($val_dt['tax_surf_tot_demo']) === true
            && isset($val_dt['tax_surf_tax_demo']) === true
            && ($val_dt['tax_surf_tot_demo'] === null
                || $val_dt['tax_surf_tot_demo'] === '')) {
            //
            $val_dt['tax_surf_tot_demo'] = $val_dt['tax_surf_tax_demo'];
        }
        return $val_dt;
    }

    /**
     * Récupère la liste des objets distincts existants dans la table des liens
     * entre identifiants internes et identifiants externes.
     *
     * @return array
     */
    protected function get_list_distinct_objects_external_link() {
        $query = sprintf('
            SELECT
                DISTINCT(object)
            FROM %1$slien_id_interne_uid_externe
            ORDER BY object ASC
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
            return array();
        }
        $result = array();
        foreach ($res['result'] as $object) {
            $result[] = $object['object'];
        }
        return $result;
    }

    protected function get_external_uid($fk_idx, string $fk_idx_2, $fk_idx_3 = PLATAU, $order_asc_desc = 'DESC') {
        $inst_external_uid = $this->f->get_inst__by_other_idx(array(
            "obj" => "lien_id_interne_uid_externe",
            "fk_field" => 'object_id',
            "fk_idx" => $fk_idx,
            "fk_field_2" => 'object',
            "fk_idx_2" => $fk_idx_2,
            "fk_field_3" => 'category',
            "fk_idx_3" => $fk_idx_3,
            "order_field" => 'lien_id_interne_uid_externe',
            "order_asc_desc" => $order_asc_desc,
        ));
        return $inst_external_uid->getVal('external_uid');
    }

    protected function get_all_external_uids($fk_idx, $link_objects = array(), $category=PLATAU) {
        if (count($link_objects) == 0) {
            $link_objects = $this->get_list_distinct_objects_external_link();
        }
        $val_external_uid = array();
        foreach ($link_objects as $link_object) {
            $external_uid = $this->get_external_uid($fk_idx, $link_object, $category);
            if ($external_uid !== '' && $external_uid !== null) {
                $val_external_uid[$link_object] = $external_uid;
            }
        }
        return $val_external_uid;
    }

    protected function get_demandeurs_data($dossier) {
        $val_demandeur = array();
        if ($dossier === null) {
            return $val_demandeur;
        }
        $inst_di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $dossier,
        ));
        $list_demandeurs = $inst_di->get_demandeurs();
        foreach ($list_demandeurs as $demandeur) {
            $inst_demandeur = $this->f->get_inst__om_dbform(array(
                "obj" => "demandeur",
                "idx" => $demandeur['demandeur'],
            ));
            $val_demandeur[$demandeur['demandeur']] = $inst_demandeur->get_json_data();
            $val_demandeur[$demandeur['demandeur']]['petitionnaire_principal'] = $demandeur['petitionnaire_principal'];
        }
        return $val_demandeur;
    }

    protected function get_architecte_data($architecte = null) {
        $val_architecte = null;
        if ($architecte !== null
            && $architecte !== '') {
            //
            $inst_architecte = $this->f->get_inst__om_dbform(array(
                "obj" => "architecte",
                "idx" => $architecte,
            ));
            $val_architecte = $inst_architecte->get_json_data();
        }
        return $val_architecte;
    }

    protected function get_instruction_data($dossier, $type = 'decision', $extra_params = array()) {
        $val_instruction = null;
        if ($dossier === null) {
            return $val_instruction;
        }
        $instruction_with_doc = null;
        $inst_di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $dossier,
        ));
        $idx = null;
        if ($type === 'decision') {
            $idx = $inst_di->get_last_instruction_decision();
        }
        if ($type === 'incompletude') {
            $idx = $inst_di->get_last_instruction_incompletude();
        }
        // XXX Permet de récupérer l'instruction par son identifiant
        if ($type === 'with-id') {
            $idx = $extra_params['with-id'];
        }
        $inst_instruction = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction",
            "idx" => $idx,
        ));
        if (count($inst_instruction->val) > 0) {
            $val_instruction = array();
            $instruction_data = $inst_instruction->get_json_data();
            $val_instruction = $this->sort_instruction_data($instruction_data, $val_instruction);
            if ($instruction_data['om_fichier_instruction'] !== null
                && $instruction_data['om_fichier_instruction'] !== '') {
                //
                $instruction_with_doc = $inst_instruction->getVal($inst_instruction->clePrimaire);
            }
            $inst_ev = $this->f->get_inst__om_dbform(array(
                "obj" => "evenement",
                "idx" => $inst_instruction->getVal('evenement'),
            ));
            if ($inst_ev->getVal('retour') === 't') {
                $instructions_related = $inst_instruction->get_related_instructions();
                foreach ($instructions_related as $instruction) {
                    if ($instruction !== null && $instruction !== '') {
                        $inst_related_instruction = $this->f->get_inst__om_dbform(array(
                            "obj" => "instruction",
                            "idx" => $instruction,
                        ));
                        $instruction_data = $inst_related_instruction->get_json_data();
                        $val_instruction = $this->sort_instruction_data($instruction_data, $val_instruction);
                        if ($instruction_data['om_fichier_instruction'] !== null
                            && $instruction_data['om_fichier_instruction'] !== '') {
                            //
                            $instruction_with_doc = $inst_related_instruction->getVal($inst_related_instruction->clePrimaire);
                        }
                    }
                }
            }
            if ($instruction_with_doc !== null) {
                //
                $val_instruction['path'] = sprintf('%s&snippet=%s&obj=%s&champ=%s&id=%s', 'app/index.php?module=form', 'file', 'instruction', 'om_fichier_instruction', $instruction_with_doc);
            }
        }
        return $val_instruction;
    }


    /**
     * Récupère les informations pour les notifications ayant plusieurs annexe
    */
    protected function get_instruction_notification_data($category, $type = '', $extra_params = array()) {
        $val_in = null;

        $idx = null;
        if ($type === 'with-id') {
            $idx = $extra_params['with-id'];
        }

        // Récupération du type de notification. Le type est nécessaire pour récupérer
        // le message et le titre de notification.
        $typeNotification = $this->getVal('type');
        if (isset($this->valF['type'])) {
            $typeNotification = $this->valF['type'];
        }

        // récupére les données à intégrer à la payload
        $inst_in = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction_notification",
            "idx" => $idx,
        ));
        if (count($inst_in->val) > 0) {
            $val_in = $inst_in->get_json_data();

            $val_in['parametre_courriel_type_titre'] = '';
            $val_in['parametre_courriel_type_message'] = '';
            // Récupération du message et du titre
            if ($category === 'mail') {
                $inst_instruction = $this->f->get_inst__om_dbform(array(
                    "obj" => "instruction",
                    "idx" => $inst_in->getVal('instruction'),
                ));
                $collectivite_id = $inst_instruction->get_dossier_instruction_om_collectivite($inst_instruction->getVal('dossier'));
                $phrase_type_notification = $this->f->get_notification_parametre_courriel_type($collectivite_id, $typeNotification);
                $val_in['parametre_courriel_type_titre'] = $phrase_type_notification['parametre_courriel_type_titre'];
                $val_in['parametre_courriel_type_message'] = $phrase_type_notification['parametre_courriel_type_message'];
            }

            if ($typeNotification == 'notification_signataire') {
                $val_in['lien_page_signature'] = $inst_in->getLienPageSignature($inst_instruction);
            }
            else {
                // Récupération des liens vers les documents et des id et type des annexes
                $infoDocNotif = $inst_in->getInfosDocumentsNotif($inst_in->getVal($inst_in->clePrimaire), $category);
                $cle = $category == PORTAL ? 'path' : 'lien_telechargement_document';
                $val_in[$cle] = $infoDocNotif['document']['path'];
                $val_in['annexes'] = $infoDocNotif['annexes'];
            }
        }
        return $val_in;
    }

    /**
     * Récupère les informations concernant la lettre au pétitionnaire.
     *
     * @param string identifiant du dossier
     * @param string type de tâche
     * @param array paramètre supplémentaire permettant de récupérer les informations
     *
     * @return array information concernant la lettre au pétitionnaire
     */
    protected function get_lettre_petitionnaire_data($dossier, $type, $extra_params = array()) {
        // Si la date limite de notification n'a pas été dépassé le type de lettre est 1
        // Si la date a été dépassé et qu'il s'agit d'une demande de pièce le type est 3
        // Si la date a été dépassé et qu'il s'agit d'une prolongation le type est 4
        // Le type de document dépend du type de pièce
        $nomTypeLettre = '';
        $nomTypeDocument = '';
        if ($type === 'lettre_incompletude') {
            $nomTypeLettre = '3';
            $nomTypeDocument = '4';
        } elseif ($type === 'lettre_majoration') {
            $nomTypeLettre = '4';
            $nomTypeDocument = '6';
        }

        $inst_di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $dossier,
        ));
        $date_limite_notification = DateTime::createFromFormat('Y-m-d', $inst_di->getVal('date_notification_delai'));
        $aujourdhui = new DateTime();
        if (! $date_limite_notification instanceof DateTime) {
            $nomTypeLettre = '';
            $nomTypeDocument = '';
        } elseif ($aujourdhui < $date_limite_notification) {
            $nomTypeLettre = '1';
            $nomTypeDocument = '3';
        }

        return array(
            'nomEtatLettre' => '3',
            'nomModaliteNotifMetier' => '4',
            'nomTypeLettre' => $nomTypeLettre,
            'nomTypeDocument' => $nomTypeDocument
        );
    }

    protected function sort_instruction_data(array $values, array $res) {
        $fields = array(
            "date_evenement",
            "date_envoi_signature",
            "date_retour_signature",
            "date_envoi_rar",
            "date_retour_rar",
            "date_envoi_controle_legalite",
            "date_retour_controle_legalite",
            "signataire_arrete",
            "om_fichier_instruction",
            "tacite",
            "lettretype",
            "commentaire",
            "complement_om_html",
        );
        foreach ($values as $key => $value) {
            if (in_array($key, $fields) === true) {
                if (array_key_exists($key, $res) === false
                    && $value !== null
                    && $value !== '') {
                    //
                    $res[$key] = $value;
                } elseif ($key === 'tacite'
                    && $value === 't') {
                    //
                    $res[$key] = $value;
                }
            }
        }
        return $res;
    }

    /**
     * Permet de définir si l'instruction passée en paramètre est une instruction
     * récépissé d'une demande et si la demande en question a générée un dossier d'instruction.
     *
     * @param  integer  $instruction Identifiant de l'instruction
     * @return boolean
     */
    protected function is_demande_instruction_recepisse_without_dossier($instruction) {
        if ($instruction === null) {
            return false;
        }
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    demande_type.dossier_instruction_type
                FROM
                    %1$sdemande
                        INNER JOIN %1$sdemande_type
                            ON demande.demande_type = demande_type.demande_type
                WHERE
                    demande.instruction_recepisse = %2$s',
                DB_PREFIXE,
                intval($instruction)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return null;
        }
        if ($qres["result"] === "") {
            return true;
        }
        return false;
    }

    protected function get_document_numerise_data(string $dn) {
        $val_dn = array();
        $inst_dn = $this->f->get_inst__om_dbform(array(
            "obj" => "document_numerise",
            "idx" => $dn,
        ));
        $val_dn = $inst_dn->get_json_data();
        $val_dn['path'] = sprintf('%s&snippet=%s&obj=%s&champ=%s&id=%s', 'app/index.php?module=form', 'file', 'document_numerise', 'uid', $this->getVal('object_id'));
        // Correspond à la nomenclature Plat'AU NATURE_PIECE
        $val_dn['nature'] = $val_dn['document_numerise_nature_libelle'];
        return $val_dn;
    }

    protected function get_parcelles_data(string $object, string $idx) {
        $val_dp = array();
        $inst_di = $this->f->get_inst__om_dbform(array(
            "obj" => $object,
            "idx" => $idx,
        ));
        $list_parcelles = $inst_di->get_parcelles();
        $no_ordre = 1;
        foreach ($list_parcelles as $parcelle) {
            $val_dp[$parcelle[$object.'_parcelle']] = array(
                $object.'_parcelle' => $parcelle[$object.'_parcelle'],
                'libelle' => $parcelle['libelle'],
                'no_ordre' => $no_ordre,
            );
            $no_ordre++;
        }
        return $val_dp;
    }

    protected function get_avis_decision_data(string $dossier) {
        $inst_di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $dossier,
        ));
        $ad = $inst_di->getVal('avis_decision');
        $val_ad = array();
        if ($ad !== null && trim($ad) !== '') {
            $inst_ad = $this->f->get_inst__om_dbform(array(
                "obj" => "avis_decision",
                "idx" => $ad,
            ));
            $val_ad = $inst_ad->get_json_data();
            $val_ad['txAvis'] = "Voir document joint";
            if (isset($val_ad['tacite']) ===  true
                && $val_ad['tacite'] === 't') {
                //
                $val_ad['txAvis'] = "Sans objet";
            }
        }
        return $val_ad;
    }

    protected function get_signataire_arrete_data(string $sa) {
        $inst_sa = $this->f->get_inst__om_dbform(array(
            "obj" => "signataire_arrete",
            "idx" => $sa,
        ));
        $val_sa = array_combine($inst_sa->champs, $inst_sa->val);
        foreach ($val_sa as $key => $value) {
            $val_sa[$key] = strip_tags($value);
        }
        return $val_sa;
    }

    // XXX WIP
    protected function get_consultation_data(string $consultation) {
        $val_consultation = array();
        $inst_consultation = $this->f->get_inst__om_dbform(array(
            "obj" => "consultation",
            "idx" => $consultation,
        ));
        $val_consultation = $inst_consultation->get_json_data();
        if (isset($val_consultation['fichier']) === true
            && $val_consultation['fichier'] !== '') {
            //
            $val_consultation['path_fichier'] = sprintf('%s&snippet=%s&obj=%s&champ=%s&id=%s', 'app/index.php?module=form', 'file', 'consultation', 'fichier', $this->getVal('object_id'));
        }
        if (isset($val_consultation['om_fichier_consultation']) === true
            && $val_consultation['om_fichier_consultation'] !== '') {
            //
            $val_consultation['path_om_fichier_consultation'] = sprintf('%s&snippet=%s&obj=%s&champ=%s&id=%s', 'app/index.php?module=form', 'file', 'consultation', 'om_fichier_consultation', $this->getVal('object_id'));
        }
        return $val_consultation;
    }

    // XXX WIP
    protected function get_service_data(string $service) {
        $val_service = array();
        $inst_service = $this->f->get_inst__om_dbform(array(
            "obj" => "service",
            "idx" => $service,
        ));
        $val_service = $inst_service->get_json_data();
        return $val_service;
    }

    protected function view_form_json($in_field = false) {
        //
        $check_state = isset($this->valF['state']) === true ? $this->valF['state'] : $this->getVal('state');
        if ($check_state !== self::STATUS_CANCELED) {
            // Liste des valeurs à afficher
            $val = array();
            //
            $val_task = array_combine($this->champs, $this->val);
            foreach ($val_task as $key => $value) {
                $val_task[$key] = strip_tags($value);
            }

            // Vérifie pour les tâches dont l'affichage de la payload est calculée si l'objet
            // de référence de la tâche existe.
            $objectRefExist = true;
            if ($val_task['stream'] === 'output'
                && (empty($val_task['json_payload']) || $val_task['json_payload'] === '{}')) {
                $objectRefExist = $this->does_referenced_object_exist(
                    $val_task['object_id'],
                    $val_task['type']
                );
            }

            // Si l'objet de référence n'existe pas log le numéro de la tâche concerné et
            // renvoie une payload contenant le message d'erreur.
            // Sinon constitue la payload du json.
            if (! $objectRefExist) {
                $this->f->addToLog(
                    sprintf(
                        __('Impossible de récupérer la payload car l\'objet de réference n\'existe pas pour la tâche : %s'),
                        $val_task['task']
                    ),
                    DEBUG_MODE
                );
                $val = __('Impossible de recuperer la payload car l\'objet de reference n\'existe pas.');
            } else {

                // L'historique n'est pas nécessaire dans l'affichage en JSON
                if ($in_field === true) {
                    $val_task['timestamp_log'] = json_decode($val_task['timestamp_log'], true);
                } else {
                    unset($val_task['timestamp_log']);
                }
                unset($val_task['timestamp_log_hidden']);
                $val['task'] = $val_task;
                //
                if ($this->getVal('type') === 'creation_DA'
                    || $this->getVal('type') === 'modification_DA') {
                    //
                    $val['dossier_autorisation'] = $this->get_dossier_autorisation_data($this->getVal('object_id'));
                    $val['donnees_techniques'] = $this->get_donnees_techniques_data($this->getVal('object_id'), 'dossier_autorisation');
                    $val['dossier_autorisation_parcelle'] = $this->get_parcelles_data('dossier_autorisation', $val['dossier_autorisation']['dossier_autorisation']);
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier_autorisation']['dossier_autorisation'], 'dossier_autorisation');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'creation_DI'
                    || $this->getVal('type') === 'modification_DI'
                    || $this->getVal('type') === 'depot_DI') {
                    //
                    $val['dossier'] = $this->get_dossier_data($this->getVal('object_id'));
                    $val['donnees_techniques'] = $this->get_donnees_techniques_data($this->getVal('object_id'), 'dossier_instruction');
                    $val['demandeur'] = $this->get_demandeurs_data($val['dossier']['dossier']);
                    $architecte = isset($val['donnees_techniques']['architecte']) === true ? $val['donnees_techniques']['architecte'] : null;
                    $val['architecte'] = $this->get_architecte_data($architecte);
                    $val['dossier_parcelle'] = $this->get_parcelles_data('dossier', $val['dossier']['dossier']);
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'qualification_DI') {
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'ajout_piece') {
                    $val['document_numerise'] = $this->get_document_numerise_data($this->getVal('object_id'));
                    $val['dossier'] = $this->get_dossier_data($val['document_numerise']['dossier']);
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val_external_uid['piece'] = $this->get_external_uid($val['document_numerise']['document_numerise'], 'piece');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'decision_DI') {
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val['instruction'] = $this->get_instruction_data($val['dossier']['dossier'], 'with-id', array('with-id' => $this->getVal('object_id')));
                    $val['instruction']['final'] = 't';
                    if (isset($val['instruction']['signataire_arrete']) === true) {
                        $val['signataire_arrete'] = $this->get_signataire_arrete_data($val['instruction']['signataire_arrete']);
                    }
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'incompletude_DI') {
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val['instruction'] = $this->get_instruction_data($val['dossier']['dossier'], 'with-id', array('with-id' => $this->getVal('object_id')));
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'completude_DI') {
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val['instruction'] = $this->get_instruction_data($val['dossier']['dossier'], 'with-id', array('with-id' => $this->getVal('object_id')));
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'lettre_incompletude'
                    || $this->getVal('type') === 'lettre_majoration') {
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val['instruction'] = $this->get_instruction_data($val['dossier']['dossier'], 'with-id', array('with-id' => $this->getVal('object_id')));
                    $val['lettre_petitionnaire'] = $this->get_lettre_petitionnaire_data($val['dossier']['dossier'], $this->getVal('type'));
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'pec_metier_consultation') {
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val['instruction'] = $this->get_instruction_data($this->getVal('dossier'), 'with-id', array('with-id' => $this->getVal('object_id')));
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val_external_uid['dossier_consultation'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier_consultation');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'avis_consultation') {
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val['instruction'] = $this->get_instruction_data($this->getVal('dossier'), 'with-id', array('with-id' => $this->getVal('object_id')));
                    $val['avis_decision'] = $this->get_avis_decision_data($this->getVal('dossier'));
                    if (isset($val['instruction']['signataire_arrete']) === true) {
                        $val['signataire_arrete'] = $this->get_signataire_arrete_data($val['instruction']['signataire_arrete']);
                    }
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val_external_uid['dossier_consultation'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier_consultation');
                    $val_external_uid['avis_dossier_consultation'] = $this->get_external_uid($this->getVal('object_id'), 'avis_dossier_consultation');
                    $val['external_uids'] = $val_external_uid;
                }
                // XXX WIP
                if ($this->getVal('type') === 'creation_consultation') {
                    //
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val['consultation'] = $this->get_consultation_data($this->getVal('object_id'));
                    $val['service'] = $this->get_service_data($val['consultation']['service']);
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'envoi_CL') {
                    //
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val['instruction'] = $this->get_instruction_data($this->getVal('dossier'), 'with-id', array('with-id' => $this->getVal('object_id')));
                    $val['dossier_autorisation'] = $this->get_dossier_autorisation_data($val['dossier']['dossier_autorisation']);
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($this->getVal('dossier'), 'dossier');
                    $val_external_uid['decision'] = $this->get_external_uid($this->getVal('object_id'), 'instruction');
                    if ($val_external_uid['decision'] === '') {
                        $inst_instruction = $this->f->get_inst__om_dbform(array(
                            "obj" => "instruction",
                            "idx" => $this->getVal('object_id'),
                        ));
                        $val_external_uid['decision'] = $this->get_external_uid($inst_instruction->get_related_instructions_next('retour_signature'), 'instruction');
                    }
                    $val['external_uids'] = $val_external_uid;
                }
                if ($this->getVal('type') === 'notification_instruction'
                    || $this->getVal('type') === 'notification_recepisse'
                    || $this->getVal('type') === 'notification_decision'
                    || $this->getVal('type') === 'notification_service_consulte'
                    || $this->getVal('type') === 'notification_tiers_consulte'
                    || $this->getVal('type') === 'notification_signataire') {
                    //
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $dossier_id = isset($val['dossier']['dossier']) === true ? $val['dossier']['dossier'] : null;
                    $val['demandeur'] = $this->get_demandeurs_data($dossier_id);
                    $val['instruction_notification'] = $this->get_instruction_notification_data($this->getVal('category'), 'with-id', array('with-id' => $this->getVal('object_id')));
                    $instruction_id = isset($val['instruction_notification']['instruction']) === true ? $val['instruction_notification']['instruction'] : null;
                    $instruction_annexes = isset($val['instruction_notification']['annexes']) === true ? $val['instruction_notification']['annexes'] : null;
                    $val['instruction'] = $this->get_instruction_data($dossier_id, 'with-id', array('with-id' => $instruction_id));
                    // Précise qu'il s'agit d'une instruction final si l'instruction est liée à une
                    // demande dont le type ne génère pas de dossier
                    if ($this->is_demande_instruction_recepisse_without_dossier($instruction_id) === true) {
                        $val['instruction']['final'] = 't';
                    }
                    $val_external_uid = array();
                    // Affiche l'identifiant externe lié à l'instruction si cette combinaison existe, sinon celui lié au dossier
                    $val_external_uid['demande'] = $this->get_external_uid($instruction_id, 'demande') !== '' ? $this->get_external_uid($instruction_id, 'demande') : $this->get_external_uid($dossier_id, 'demande');
                    $val_external_uid['demande (instruction)'] = $this->get_external_uid($instruction_id, 'demande', PORTAL, 'ASC');
                    $val_external_uid['instruction_notification'] = $this->get_external_uid($this->getVal('object_id'), 'instruction_notification', PORTAL);
                    $val['external_uids'] = $val_external_uid;
                }
                //
                if ($this->getVal('type') === 'prescription') {
                    $val['dossier'] = $this->get_dossier_data($this->getVal('dossier'));
                    $val['instruction'] = $this->get_instruction_data($this->getVal('dossier'), 'with-id', array('with-id' => $this->getVal('object_id')));
                    $val['avis_decision'] = $this->get_avis_decision_data($this->getVal('dossier'));
                    if (isset($val['instruction']['signataire_arrete']) === true) {
                        $val['signataire_arrete'] = $this->get_signataire_arrete_data($val['instruction']['signataire_arrete']);
                    }
                    $val_external_uid = array();
                    $val_external_uid['dossier_autorisation'] = $this->get_external_uid($val['dossier']['dossier_autorisation'], 'dossier_autorisation');
                    $val_external_uid['dossier'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier');
                    $val_external_uid['dossier_consultation'] = $this->get_external_uid($val['dossier']['dossier'], 'dossier_consultation');
                    $val_external_uid['prescription'] = $this->get_external_uid($this->getVal('object_id'), 'prescription');
                    $val['external_uids'] = $val_external_uid;
                }
            }

            if ($in_field === true) {
                return json_encode($val, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            } else {
                // Liste des valeurs affichée en JSON
                var_export(json_encode($val, JSON_UNESCAPED_SLASHES));
            }
        }
    }

    function post_update_task() {
        // Mise à jour des valeurs

        // Modification de l'état de la tâche
        if ($this->f->get_submitted_post_value('state') !== null) {
            $params = array(
                'val' => array(
                    'state' => $this->f->get_submitted_post_value('state')
                ),
            );
            if ($this->f->get_submitted_post_value('comment') !== null) {
                $params['comment'] = $this->f->get_submitted_post_value('comment');
            }
            $update = $this->update_task($params);
            $message_class = "valid";
            $message = $this->msg;
            if ($update === false) {
                $this->addToLog($this->msg, DEBUG_MODE);
                $message_class = "error";
                $message = sprintf(
                    '%s %s',
                    __('Impossible de mettre à jour la tâche.'),
                    __('Veuillez contacter votre administrateur.')
                );
            }
            $this->f->displayMessage($message_class, $message);
        }

        // Sauvegarde de l'uid externe retourné
        $external_uid = $this->f->get_submitted_post_value('external_uid');
        if ($external_uid !== null) {
            //
            $objects = $this->get_objects_by_task_type($this->getVal('type'), $this->getVal('stream'));
            // Si l'identifiant externe contient le préfixe pour identifier les codes de suivi,
            // le seul objet concerné sera celui du code de suivi
            if (strpos($external_uid, self::CS_PREFIX) !== false) {
                $objects = array('code-suivi', );
                $external_uid = str_replace(self::CS_PREFIX, '', $external_uid);
            }
            foreach ($objects as $object) {
                $inst_lien = $this->f->get_inst__om_dbform(array(
                    "obj" => "lien_id_interne_uid_externe",
                    "idx" => ']',
                ));
                $object_id = $this->getVal('object_id');
                $is_exists = $inst_lien->is_exists($object, $object_id, $external_uid, $this->getVal('dossier'));
                // Dans le cas spécifique de la mise à jour d'une notification
                // et de la création d'une liaison d'identifiant pour l'objet demande,
                // l'identifiant de l'objet n'est plus celui de la notification
                // d'instruction mais celui du dossier d'instruction
                if ($object === 'demande'
                    && ($this->getVal('type') === 'notification_recepisse'
                        || $this->getVal('type') === 'notification_instruction'
                        || $this->getVal('type') === 'notification_decision'
                        || $this->getVal('type') === 'notification_service_consulte'
                        || $this->getVal('type') === 'notification_tiers_consulte'
                        || $this->getVal('type') === 'notification_signataire')) {
                    //
                    $object_id = $this->getVal('dossier');
                    // Il ne doit y avoir qu'une liaison entre le numéro du dossier interne et un uid externe de "demande"
                    $is_exists = $inst_lien->is_exists($object, $object_id, null, $this->getVal('dossier'));
                }
                if ($is_exists === false) {
                    $valF = array(
                        'lien_id_interne_uid_externe' => '',
                        'object' => $object,
                        'object_id' => $object_id,
                        'external_uid' => $external_uid,
                        'dossier' => $this->getVal('dossier'),
                        'category' => $this->getVal('category'),
                    );
                    $add = $inst_lien->ajouter($valF);
                    $message_class = "valid";
                    $message = $inst_lien->msg;
                    if ($add === false) {
                        $this->addToLog($inst_lien->msg, DEBUG_MODE);
                        $message_class = "error";
                        $message = sprintf(
                            '%s %s',
                            __("Impossible de mettre à jour le lien entre l'identifiant interne et l'identifiant de l'application externe."),
                            __('Veuillez contacter votre administrateur.')
                        );
                    }
                    $this->f->displayMessage($message_class, $message);
                }
            }
        }
    }

    function post_add_task() {
        // TODO Tester de remplacer la ligne de json_payload par un $_POST
        $result = $this->add_task(array(
            'val' => array(
                'stream' => 'input',
                'json_payload' => html_entity_decode($this->f->get_submitted_post_value('json_payload'), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401),
                'type' => $this->f->get_submitted_post_value('type'),
                'category' => $this->f->get_submitted_post_value('category'),
            )
        ));
        $message = sprintf(
            __("Tâche %s ajoutée avec succès"),
            $this->getVal($this->clePrimaire)).
            '<br/><br/>'.
            $this->msg;
        $message_class = "valid";
        if ($result === false){
            $this->addToLog($this->msg, DEBUG_MODE);
            $message_class = "error";
            $message = sprintf(
                '%s %s',
                __('Impossible d\'ajouter la tâche.'),
                __('Veuillez contacter votre administrateur.')
            );
        }
        $this->f->displayMessage($message_class, $message);
    }

    function setLayout(&$form, $maj) {
        //
        $form->setBloc('json_payload', 'D', '', 'col_6');
        $fieldset_title_payload = __("json_payload (calculée)");
        if ($this->getVal('json_payload') !== "{}") {
            $fieldset_title_payload = __("json_payload");
        }
        $form->setFieldset('json_payload', 'DF', $fieldset_title_payload, "collapsible, startClosed");
        $form->setBloc('json_payload', 'F');
        $form->setBloc('timestamp_log', 'DF', __("historique"), 'col_9 timestamp_log_jsontotab');
    }

    /**
     * Récupère le nom de l'objet à mentionner dans la table lien_id_interne_uid_externe
     * en fonction du type et du stream de la tâche.
     *
     * @param  string $type   Type de la tâche
     * @param  string $stream Stream de la tâche
     *
     * @return array
     */
    function get_objects_by_task_type($type, $stream = 'all') {
        $objects = array();
        if (in_array($type, array('creation_DA', 'modification_DA', )) === true) {
            $objects = array('dossier_autorisation', );
        }
        if (in_array($type, array('creation_DI', 'depot_DI', 'notification_DI', 'qualification_DI', )) === true) {
            $objects = array('dossier', );
        }
        if (in_array($type, array('create_DI_for_consultation', )) === true) {
            $objects = array('dossier', 'dossier_consultation', );
        }
        if (in_array($type, array('create_DI', )) === true
            && $stream === 'input') {
            $objects = array('dossier', 'dossier_autorisation', 'demande', );
        }
        if (in_array($type, array(
            'decision_DI',
            'incompletude_DI',
            'completude_DI',
            'lettre_incompletude',
            'lettre_majoration'
            )) === true) {
            $objects = array('instruction', );
        }
        if (in_array($type, array('envoi_CL', )) === true) {
            $objects = array('instruction_action_cl', );
        }
        if (in_array($type, array('pec_metier_consultation', )) === true
            && $stream === 'output') {
            $objects = array('pec_dossier_consultation', );
        }
        if (in_array($type, array('avis_consultation', )) === true
            && $stream === 'output') {
            $objects = array('avis_dossier_consultation', );
        }
        if (in_array($type, array('prescription', )) === true
            && $stream === 'output') {
            $objects = array('prescription', );
        }
        if (in_array($type, array('ajout_piece', 'add_piece', )) === true) {
            $objects = array('piece', );
        }
        if (in_array($type, array('creation_consultation', )) === true) {
            $objects = array('consultation', );
        }
        if (in_array($type, array('pec_metier_consultation', )) === true
            && $stream === 'input') {
            $objects = array('pec_metier_consultation', );
        }
        if (in_array($type, array('avis_consultation', )) === true
            && $stream === 'input') {
            $objects = array('avis_consultation', );
        }
        if (in_array($type, array('create_message', )) === true
            && $stream === 'input') {
            $objects = array('dossier_message', );
        }
        if (in_array(
            $type,
            array(
                'notification_recepisse',
                'notification_instruction',
                'notification_decision',
                'notification_service_consulte',
                'notification_tiers_consulte',
                'notification_signataire',
            )
        ) === true) {
            $objects = array('instruction_notification', 'demande', );
        }
        return $objects;
    }

    /**
     * Récupère les tables auxquelles pourrait être rattaché l'objet lié à la tâche,
     * par rapport à son type.
     *
     * @param  string $type   Type de la tâche
     * @param  string $stream input ou output
     * @return array
     */
    function get_tables_by_task_type($type, $stream = 'all') {
        $tables = array();
        if (in_array($type, array('creation_DA', 'modification_DA', )) === true) {
            $tables = array('dossier_autorisation', );
        }
        if (in_array($type, array('creation_DI', 'depot_DI', )) === true) {
            $tables = array('dossier', );
        }
        if (in_array($type, array('qualification_DI', )) === true) {
            $tables = array('instruction', 'dossier', );
        }
        if (in_array($type, array('create_DI_for_consultation', )) === true) {
            $tables = array('dossier', );
        }
        if (in_array($type, array('create_DI', )) === true
            && $stream === 'input') {
            $tables = array('dossier', 'dossier_autorisation', 'demande', );
        }
        if (in_array($type, array(
            'decision_DI',
            'incompletude_DI',
            'completude_DI',
            'lettre_incompletude',
            'lettre_majoration'
        )) === true) {
            $tables = array('instruction', );
        }
        if (in_array($type, array('envoi_CL', )) === true) {
            $objects = array('instruction', );
        }
        if (in_array($type, array('pec_metier_consultation', )) === true
            && $stream === 'output') {
            $tables = array('instruction', );
        }
        if (in_array($type, array('avis_consultation', )) === true
            && $stream === 'output') {
            $tables = array('instruction', );
        }
        if (in_array($type, array('prescription', )) === true
            && $stream === 'output') {
            $tables = array('instruction', );
        }
        if (in_array($type, array('ajout_piece', 'add_piece', )) === true) {
            $tables = array('document_numerise', );
        }
        if (in_array($type, array('creation_consultation', )) === true) {
            $tables = array('consultation', );
        }
        if (in_array($type, array('pec_metier_consultation', )) === true
            && $stream === 'input') {
            $tables = array('consultation', );
        }
        if (in_array($type, array('avis_consultation', )) === true
            && $stream === 'input') {
            $tables = array('consultation', );
        }
        if (in_array($type, array('create_message', )) === true
            && $stream === 'input') {
            $tables = array('dossier_message', );
        }
        if (in_array(
            $type,
            array(
                'notification_recepisse',
                'notification_instruction',
                'notification_decision',
                'notification_service_consulte',
                'notification_tiers_consulte',
                'notification_signataire'
            )
        ) === true) {
            $tables = array('instruction_notification', );
        }
        return $tables;
    }

    /**
     * Vérifie si l'objet référencé par la tâche existe en base de données.
     *
     * Récupère la liste des tables de référence associé à la tâche à partir
     * du type de tâche et de son flux (input ou output).
     * Pour chaque table potentiellement référencé par la tâche on essaye d'instancier
     * l'objet correspondant à partir de l'identifiant de l'objet de référence de la tâche.
     * Si l'élément instancié existe renvoie true sinon renvoie false.
     *
     * @param string|integer $taskObjectId : identifiant de l'objet de référence de la tâche
     * @param string $taskType : type de la tâche
     * @param string $taskStream : flux entrant (output - valeur par défaut) ou sortant (input)
     * @return boolean
     */
    protected function does_referenced_object_exist($taskObjectId, string $taskType, string $taskStream = 'output') {
        $refTables = $this->get_tables_by_task_type($taskType, $taskStream);
        if (empty($refTables) === true) {
            $this->f->addToLog(
                sprintf(
                    __("Impossible de vérifier si l'objet de référence existe, car le type de task '%s' n'a pas de correspondance avec une table dans la méthode %s."),
                    $taskType,
                    "get_tables_by_task_type()"
                ),
                DEBUG_MODE
            );
            return true;
        }
        foreach ($refTables as $table) {
            $inst = $this->f->get_inst__om_dbform(array(
                'obj' => $table,
                'idx' => $taskObjectId
            ));
            if ($inst->exists() === true) {
                return true;
            }
        }
        return false;
    }

}
