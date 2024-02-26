<?php
//$Id$ 
//gen openMairie le 15/11/2021 15:41

require_once "../gen/obj/instruction_notification.class.php";

class instruction_notification extends instruction_notification_gen {

    /**
     * Liste des types de tâches.
     *
     * @var array
     */
    var $task_types = array(
        'notification_recepisse',
        'notification_instruction',
        'notification_decision',
        'notification_service_consulte',
        'notification_tiers_consulte',
        'notification_depot_demat',
        'notification_commune',
        'notification_signataire'
    );

    /**
     * Prépare le corps (message) du mail de notification selon le type
     * de notification a partir du modele de message donné et des informations
     * contenu dans la payload.
     *
     * @param string modele de message
     * @param string type de notification
     * @param array payload contenant les informations nécessaires au remplissage
     * du message
     * @return string message de notification
     */
    public function get_message_notification($modele, $notificationType, $payload) {
        $msgNotif = "";
        $urlDossier = '';
        $lienInst = '';

        // Récupération du paramétrage de l'url d'accès au dossier, à l'instruction et au
        // document
        $inst_instruction = $this->f->get_inst__om_dbform(array(
            'obj' => 'instruction',
            'idx' => $payload['instruction_notification']['instruction']
        ));
        $collectivite_di = $inst_instruction->get_dossier_instruction_om_collectivite(
            $payload['dossier']['dossier']
        );
        // Récupération de l'url du dossier pour l'intégrer au mail de notification
        $urlAcces = $this->f->get_parametre_notification_url_acces($collectivite_di);

        // Construction de l'url vers le dossier
        if (! empty($urlAcces)) {
            $urlDossier = sprintf(
                '%1$sapp/index.php?module=form&obj=dossier_instruction&action=3&idx=%2$s&retour=tab',
                $urlAcces,
                $payload['dossier']['dossier']
            );
            $urlInst = sprintf(
                '%1$sapp/index.php?module=form&direct_link=true&obj=dossier_instruction&action=3'.
                '&direct_field=dossier&direct_form=instruction&direct_action=3&direct_idx=%2$s',
                $urlAcces,
                $inst_instruction->getVal($inst_instruction->clePrimaire)
            );
            // Pour ne pas casser l'ancien fonctionnement c'est directement un lien que l'on
            // va injecter dans le mail
            $lienInst = sprintf(
                '<a href="%1$s">%1$s</a>',
                $urlInst
            );
        } else if (! empty(PATH_BASE_URL)) {
            $urlDossier = sprintf(
                '%1$sapp/index.php?module=form&obj=dossier_instruction&action=3&idx=%2$s&retour=tab',
                PATH_BASE_URL,
                $payload['dossier']['dossier']
            );
            $urlInst = sprintf(
                '%1$sapp/index.php?module=form&direct_link=true&obj=dossier_instruction&action=3'.
                '&direct_field=dossier&direct_form=instruction&direct_action=3&direct_idx=%2$s',
                PATH_BASE_URL,
                $inst_instruction->getVal($inst_instruction->clePrimaire)
            );
            // Pour ne pas casser l'ancien fonctionnement c'est directement un lien que l'on
            // va injecter dans le mail
            $lienInst = sprintf(
                '<a href="%1$s">%1$s</a>',
                $urlInst
            );
        }

        // Intégration du lien vers le dossier dans le message de notification
        $msgNotif = str_replace(
            '<DOSSIER_INSTRUCTION>',
            $payload['dossier']['dossier'],
            $modele
        );

        // Intégration du lien vers l'instruction dans le message de notification
        $msgNotif = str_replace(
            '<URL_INSTRUCTION>',
            $lienInst,
            $msgNotif
        );
        
        // Intégration du lien vers le dossier dans le message de notification
        $msgNotif = str_replace(
            '<ID_INSTRUCTION>',
            $inst_instruction->getVal($inst_instruction->clePrimaire),
            $msgNotif
        );

        // Intégration du numéro de dossier dans le message de notification
        $msgNotif = str_replace(
            '[URL_DOSSIER]',
            $urlDossier,
            $msgNotif
        );

        // pour les notifications signataires
        if ($notificationType == 'notification_signataire') {

            // remplacement du lien vers la page de signature
            $msgNotif = str_replace(
                '[LIEN_PAGE_SIGNATURE]',
                $payload['instruction_notification']['lien_page_signature'],
                $msgNotif
            );
        }
        else {
            // Préparation du message de notification
            $msgNotif = str_replace(
                '[LIEN_TELECHARGEMENT_DOCUMENT]',
                $payload['instruction_notification']['lien_telechargement_document'],
                $msgNotif
            );
            // Récupération de la liste des liens des annexes et ajout
            // dans le message de notification (une par ligne)
            if (! empty($payload['instruction_notification']['annexes']) &&
                is_array($payload['instruction_notification']['annexes'])
            ) {
                $listeLien = array_map(function ($annexe) {
                    if (isset($annexe['lien'])) {
                        return $annexe['lien'];
                    }
                }, $payload['instruction_notification']['annexes']);

                $msgNotif = str_replace(
                    '[LIEN_TELECHARGEMENT_ANNEXE]',
                    implode("<br>", $listeLien),
                    $msgNotif
                );
            }
        }

        return $msgNotif;
    }

    /**
     * Prépare l'intitulé (titre) du mail de notification selon le type
     * de notification a partir du modele de titre donné et des informations
     * contenu dans la payload.
     *
     * @param string modele de titre
     * @param string type de notification
     * @param array payload contenant les informations nécessaires au remplissage
     * du titre
     * @return string titre de notification
     */
    protected function get_titre_notification($modele, $notificationType, $payload) {
        // Préparation du message de notification selon le type de notification
        $titreNotif = str_replace(
            '[DOSSIER]',
            $payload['dossier']['dossier'],
            $modele
        );

        return $titreNotif;
    }

    public function send_mail_notification($payload, $notificationType) {
        $this->begin_treatment(__METHOD__);

        // Récupération du titre et du message de notification
        $msgNotif = $this->get_message_notification(
            $payload['instruction_notification']['parametre_courriel_type_message'],
            $notificationType,
            $payload
        );
        // Si le corps du courriel est vide affiche un message de log indiquant qu'il n'a pas
        // été récupéré.
        if (empty($msgNotif)) {
            $this->addToLog(
                sprintf(
                    '%s() : %s',
                    __METHOD__,
                    __('Le message du courriel de notification n\'a pas été récupéré.')
                ),
                DEBUG_MODE
            );
        }
        $titreNotif = $this->get_titre_notification(
            $payload['instruction_notification']['parametre_courriel_type_titre'],
            $notificationType,
            $payload
        );
        // Si le sujet du courriel est vide affiche un message de log indiquant qu'il n'a pas
        // été récupéré.
        if (empty($titreNotif)) {
            $this->addToLog(
                sprintf(
                    '%s() : %s',
                    __METHOD__,
                    __('Le sujet du courriel de notification n\'a pas été récupéré.')
                ),
                DEBUG_MODE
            );
        }

        // Envoi du mail
        $ret = $this->f->sendMail(
            $titreNotif,
            $msgNotif,
            $payload['instruction_notification']['courriel']
        );

        // Récupération des anciennes valeurs de la notification
        $notif_val = array();
        foreach ($this->champs as $champ) {
            $notif_val[$champ] = $this->getVal($champ);
        }
        // Mise à jour de la date, du statut et du commentaire
        $notif_val['date_envoi'] = date("d/m/Y H:i:s");
        $notif_val['date_premier_acces'] = null;
        $notif_val['statut'] = 'envoyé';
        $notif_val['commentaire'] = 'Le mail de notification a été envoyé';
        // Si une erreur surviens lors de l'envoi du mail
        if ($ret !== true) {
            $message = sprintf(
                '%s %s. %s',
                __("Une erreur s'est produite lors de la notification de :"),
                $this->getVal('destinataire'),
                __("Veuillez contacter votre administrateur.")
            );
            $this->addToMessage($message);
            $this->addToLog(
                sprintf('%s() : %s', __METHOD__, $message),
                DEBUG_MODE
            );
            $notif_val['statut'] = "Echec";
            $notif_val['commentaire'] = "Mail non envoyé";
            $suivi_notif = $this->modifier($notif_val);
            $this->correct = false;
            if ($suivi_notif === false) {
                $this->addToLog(
                    sprintf(
                        '%s() : %s %s : %s',
                        __METHOD__,
                        __('Erreur lors de la mise à jour du suivi de notification.'),
                        __("Paramétrage de la notification"),
                        var_export($payload, true)
                    ),
                    DEBUG_MODE
                );
                return $this->end_treatment(__METHOD__, false);
            }
            return $this->end_treatment(__METHOD__, false);
        }

        // Si le traitement à reussi met à jour le suivi de la notification
        $suivi_notif = $this->modifier($notif_val);
        if ($suivi_notif === false) {
            $this->addToLog(
                sprintf(
                    '%s() : %s %s : %s',
                    __METHOD__,
                    __('Erreur lors de la mise à jour du suivi de notification.'),
                    __("Paramétrage de la notification"),
                    var_export($payload, true)
                ),
                DEBUG_MODE
            );
            return $this->end_treatment(__METHOD__, false);
        }
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * TRIGGER - triggersupprimer.
     * Supprime les instances de instruction_notification_document liées à
     * la notification
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // On supprime toutes les instruction_notification_document liées à la notification
        $notifsDocASupprimer = $this->get_instruction_notification_document($this->getVal($this->clePrimaire));
        foreach ($notifsDocASupprimer as $idNotifDoc) {
            $inst_notif_doc = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction_notification_document",
                "idx" => $idNotifDoc,
            ));
            $val_notif_doc = array();
            foreach ($inst_notif_doc->champs as $champ) {
                $val_notif_doc[$champ] = $inst_notif_doc->getVal($champ);
            }

            $supprNotifDoc = $inst_notif_doc->supprimer($val_notif_doc);
            if ($supprNotifDoc == false) {
                $this->addToMessage(sprintf(
                    "%s %s",
                    __("Erreur lors de la suppression des liens vers les documents de la notification."),
                    __("Veuillez contacter votre administrateur.")
                ));
                return false;
            }
        }
    }

    /**
     * TRIGGER - triggersupprimerapres.
     *
     * Suite à la suppression de la notification les tâches liées à cette notification
     * sont également supprimées.
     *
     * @return boolean
     */
    function triggersupprimerapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // Gestion des tâches pour la dématérialisation
        $inst_task_empty = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));
        foreach ($this->task_types as $task_type) {
            $task_exists = $inst_task_empty->task_exists($task_type, $id);
            if ($task_exists !== false) {
                $inst_task = $this->f->get_inst__om_dbform(array(
                    "obj" => "task",
                    "idx" => $task_exists,
                ));
                if ($inst_task->getVal('state') === $inst_task::STATUS_NEW || $inst_task->getVal('state') === $inst_task::STATUS_DRAFT) {
                    $task_val = array(
                        'state' => $inst_task::STATUS_CANCELED,
                    );
                    $update_task = $inst_task->update_task(array('val' => $task_val));
                    if ($update_task === false) {
                        $this->addToMessage(sprintf('%s %s',
                            sprintf(__("Une erreur s'est produite lors de la modification de la tâche %."), $inst_task->getVal($inst_task->clePrimaire)),
                            __("Veuillez contacter votre administrateur.")
                        ));
                        $this->addToMessage($inst_task->msg);
                        $this->correct = false;
                        return false;
                    }
                }
            }
        }
    }

    /**
     * Renvoie la liste des instruction_notification_document liés
     * à la notification.
     *
     * @param integer id de la notification dont on cherche les instruction_notification_document
     * @return array liste des instruction_notification_document liés à l'instruction
     */
    public function get_instruction_notification_document($id_notif) {
        $listeInstrNotifDoc = array();
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    instruction_notification_document.instruction_notification_document
                FROM
                    %1$sinstruction_notification_document
                WHERE
                    instruction_notification = %2$d',
                DB_PREFIXE,
                intVal($id_notif)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        foreach ($qres['result'] as $row) {
            $listeInstrNotifDoc[] = $row['instruction_notification_document'];
        }
        return $listeInstrNotifDoc;
    }

    public function get_json_data() {
        $val = array_combine($this->champs, $this->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        return $val;
    }

    /**
     * Récupère la liste des clés d'accès au document de la notification sous
     * la forme :
     *     array(
     *          'document' => array(
     *              'cle' => 'cle accès à la lettretype de l\'instruction',
     *              'lien' => 'lien permettant d'accéder à la pièce'
     *          ),
     *          'annexe' => array(
     *              'cle' => 'cle accès à l\'annexe choisie',
     *              'lien' => 'lien permettant d'accéder à l\'annexe'
     *          ),
     *     );
     * @param integer id de la notification
     * @return array liste des clés d'acès
     */
    public function getInfosDocumentsNotif($idNotification, $categorieNotif) {
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    instruction_notification_document.cle,
                    instruction_notification_document.annexe,
                    instruction_notification_document.document_type,
                    instruction_notification_document.document_id,
                    dossier.om_collectivite
                FROM
                    %1$sinstruction_notification_document
                    LEFT JOIN %1$sinstruction_notification
                        ON instruction_notification_document.instruction_notification = instruction_notification.instruction_notification
                    LEFT JOIN %1$sinstruction
                        ON instruction_notification.instruction = instruction.instruction
                    LEFT JOIN %1$sdossier
                        ON instruction.dossier = dossier.dossier
                WHERE
                    instruction_notification.instruction_notification = %2$d',
                DB_PREFIXE,
                intVal($idNotification)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Remplissage du résultat avec les valeurs récupérées
        $infoDoc = array(
            'document' => array(
                'path' => '',
                'id_instruction' => ''
            ),
            'annexes' => array()
        );

        foreach ($qres['result'] as $row) {
            $urlAcces = $this->f->get_parametre_notification_url_acces($row['om_collectivite']);
            // Pour les notifications via le portail ont construis  le path permettant d'accéder
            // aux documents via openads
            switch ($row['document_type']) {
                case 'instruction':
                    $path = sprintf(
                        '%s&snippet=%s&obj=%s&champ=%s&id=%s',
                        'app/index.php?module=form',
                        'file',
                        'instruction',
                        'om_fichier_instruction',
                        $row['document_id']
                    );
                    break;
                case 'consultation':
                    $path = sprintf(
                        '%s&snippet=%s&obj=%s&champ=%s&id=%s',
                        'app/index.php?module=form',
                        'file',
                        'consultation',
                        'fichier',
                        $row['document_id']
                    );
                    break;
                case 'document_numerise':
                    $path = sprintf(
                        '%s&snippet=%s&obj=%s&champ=%s&id=%s',
                        'app/index.php?module=form',
                        'file',
                        'document_numerise',
                        'uid',
                        $row['document_id']
                    );
                    break;
                default :
                    $path = __('Objet inconnu, impossible de créer le path.');
                    break;
            }
            // Pour les notifications par mail ont construis le lien permettant d'accéder aux documents
            // en anonyme
            $lien = sprintf(
                '%1$sweb/notification.php?key=%2$s',
                $urlAcces,
                $row['cle']
            );
            // Pour les notifications via le portail on a besoin du chemin vers le fichier
            // alors que pour les notifications par mail on a besoin du lien
            if ($row['annexe'] == 't') {
                if ($categorieNotif == PORTAL) {
                    $infoDoc['annexes'][] = array(
                        'path' => $path,
                        'document_type' => $row['document_type'],
                        'document_id' => $row['document_id']
                    );
                } else if ($categorieNotif == 'mail') {
                    $infoDoc['annexes'][] = array(
                        'cle' => $row['cle'],
                        'lien' => $lien,
                        'document_type' => $row['document_type'],
                        'document_id' => $row['document_id']
                    );
                }
            } else {
                $infoDoc['document']['path'] = $categorieNotif == PORTAL ? $path : $lien;
                $infoDoc['document']['id_instruction'] = $row['document_id'];
            }
        }
        return $infoDoc;
    }

    /**
     * Methode clesecondaire
     */
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // Suppression de la vérification de la clé secondaire car gestion dans
        // les triggers de suppression
    }

    /**
     * Renvoi le lien de la page de signature dans le cadre d'une notification signataire
     *
     * @param  object  $inst_instruction  (optionel) Instance de l'instruction
     *
     * @return string
     */
    public function getLienPageSignature($inst_instruction = null) {
        if (empty($inst_instruction)) {
            $inst_instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => $this->getVal('instruction'),
            ));
        }
        return $inst_instruction->getVal('parapheur_lien_page_signature');
    }
}
