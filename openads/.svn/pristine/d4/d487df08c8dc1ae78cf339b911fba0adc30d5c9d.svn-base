<?php
/**
 * DBFORM - 'instruction_notification_manuelle' - Surcharge instruction.
 *
 * @package openads
 * @version SVN : $Id$
 */

//
require_once "../obj/instruction.class.php";

//
class instruction_notification_manuelle extends instruction {

    /**
     *
     */
    protected $_absolute_class_name = "instruction_notification_manuelle";

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();

        // ACTION - 411 - view_notification_manuelle
        $this->class_actions[411] = array(
            "identifier" => "notification_manuelle",
            "view" => "view_notification_manuelle",
            "permission_suffix" => "modifier",
        );

        // ACTION - 420 - view_notification_service_consulte
        $this->class_actions[420] = array(
            "identifier" => "notification_service_consulte",
            "view" => "view_notification_service_consulte",
            "permission_suffix" => "modifier",
        );

        // ACTION - 430 - view_notification_tiers_consulte
        $this->class_actions[430] = array(
            "identifier" => "notification_tiers_consulte",
            "view" => "view_notification_tiers_consulte",
            "permission_suffix" => "modifier",
        );
    }

    /**
     * VIEW - view_notification_manuelle.
     *
     * Ouvre le sous-formulaire en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_notification_manuelle() {
        // TODO : refactoriser ce code en utilisant les méthodes créées pour le formualire de notif des services consultés
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Préparation du type de message de retour
        $message_class = "valid";
        // Non affichage du fil d'ariane /!\ la surcharge se fait
        // depuis la méthode getSubFormTitle en renseignant le numéro de l'action
        // dans la méthode puis en appellant la méthode
        $this->getSubFormTitle('');

        // Vérification que le paramétrage nécessaire pour l'envoi des notifications existe
        $dossier = $this->getVal('dossier');
        $collectivite_di = $this->get_dossier_instruction_om_collectivite($dossier);
    
        // Récupération dynamique de la valeur du nombre d'annexe maximale, paramétré manuellement (parametre_notification_max_annexes)
        $nb_annexe_max = $this->f->get_nb_max_annexe($collectivite_di);

        // Récupération de la catégorie et notification des demandeurs choisis
        $categorie = $this->f->get_param_option_notification($collectivite_di);
        // Récupération de la liste des demandeurs notifiables
        if ($categorie === PORTAL) {
            // Pour une notification par portail récupère uniquement le pétitionnaire principal
            $demandeurs = $this->get_demandeurs_notifiable($this->getVal('dossier'), true);
        } elseif ($categorie === 'mail') {
            $demandeurs = $this->get_demandeurs_notifiable();
        } else {
            $this->f->displayMessage('error', sprintf(
                '%s<br/>%s',
                __("Erreur lors de la génération de la notification."),
                __("L'option de notification option_notification doit obligatoirement être définie.")
            ));
            return false;
        }


        // TODO : a améliorer
        // Récupération de l'id du pétitionnaire principal
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    demandeur
                FROM
                    %1$slien_demande_demandeur
                    INNER JOIN %1$sdemande ON lien_demande_demandeur.demande = demande.demande
                WHERE
                    demande.dossier_instruction = \'%2$s\' AND
                    petitionnaire_principal = TRUE',
                DB_PREFIXE,
                $this->getVal('dossier')
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        $idPetitioPrinc = $qres["result"];
        if ($qres["code"] !== "OK") {
            $idPetitioPrinc = '';
        }

        //
        // Traitement des données du formulaire
        //
        // Si des données ont été envoyées par le formulaire
        $tooManyAnnexe = false;
        $postValues = $this->f->get_submitted_post_value();
        if ($postValues != null && is_array($postValues) && $postValues != array()) {
            // Récupération de la liste des demandeurs à notifier
            $nbDemChoisis = 0;
            // Dans le cas d'une notification via le portail web seul le pétitionnaire
            // principale est notifiable. Dans le formulaire la liste des pétitionnaire
            // notifiable ne sera pas affiché.
            // Pour pouvoir réutiliser le traitement des autres modes de notification
            // l'id du demandeur est récupéré et ajouté aux valeurs récupéré du POST
            // en faisant comme si il s'agissait d'une case cochée dans le formulaire.
            if ($categorie == null || $categorie == '' || $categorie === PORTAL) {
                $idPetiPrinc = array_keys($demandeurs);
                // Afficher un message d'erreur et arrêter le traitement 
                // si le formulaire de notification manuelle a été validé, 
                // alors que le demandeur principal ne peut pas être notifié 
                // et que la notification se fait via PORTAL
                if (array_key_exists(0, $idPetiPrinc) === false) {
                    $this->f->displayMessage('error', sprintf(
                        '%s<br/>
                        %s',
                        __("Erreur lors de la génération de la notification."),
                        __("Le pétitionnaire principal doit avoir une adresse mail valide renseignée et accepter les notifications par mail.")
                        )
                    );
                    return false;
                }
                $postValues[$idPetiPrinc[0]] = 'Oui';
            }

            // Récupération des id des documents annexes en fusionnant les annexes reçu
            $annexes = array_key_exists('annexes-pieces', $postValues) ?
                $postValues['annexes-pieces'] :
                array();
            $annexes = array_key_exists('annexes-documents', $postValues) ?
                array_merge($annexes, $postValues['annexes-documents']) :
                $annexes;
            // Supprime les éléments vide de la liste des annexes
            $annexes = array_filter($annexes, function ($var) {
                return ! empty($var);
            });

            if (count($annexes) <= $nb_annexe_max) {
                // Sépare le nom de la table de l'identifiant du document pour chaque annexe.
                // ex : consultation_1 => $paramAnnexe[0] = consultation et $paramAnnexe[0] = 1
                //     document-numerise_3 => $paramAnnexe[0] = document_numerise et $paramAnnexe[0] = 3
                // Ensuite pour chaque annexe on construit un tableau qui a pour chaque ligne :
                //   array('objet' => nom de la classe du document, 'id' => identifiant du document)
                $paramNotifAnnexe = array();
                $libellesAnnexe = array();
                foreach ($annexes as $annexe) {
                    if ($annexe == '') {
                        continue;
                    }
                    $paramAnnexe = explode('_', $annexe);
                    // Pour les documents numérisé afin d'éviter d'avoir des problèmes en utilisant
                    // explode les valeurs renvoyées par le select sont "document-numerise_id".
                    // Ce traitement sert à corriger le nom de l'objet en "document_numerise"
                    if ($paramAnnexe[0] == 'document-numerise') {
                        $paramAnnexe[0] = 'document_numerise';
                    }
                    // Paramètre la notification du document avec les valeurs récupérées
                    if (! (is_array($paramAnnexe) && $paramAnnexe[0] != null && $paramAnnexe[1] != null)) {
                        $message = __("Erreur, le format des données récupérées est invalide.");
                        $this->f->displayMessage('error', $message);
                        return false;
                    }
                    $paramNotifAnnexe[] = array(
                        'id' => $paramAnnexe[1],
                        'tableDocument' => $paramAnnexe[0],
                        'isAnnexe' => true
                    );
                }
    
                // Envoi des notifications à chaque demandeur
                foreach ($postValues as $idChamps => $valeur) {
                    if ($valeur == 'Oui' && is_numeric($idChamps)) {
                        $idDemandeur = $idChamps;
                        $nbDemChoisis++;
                        // Ajout de la notif et de ses documents annexes
                        $idNotif = $this->ajouter_notification(
                            $this->getVal($this->clePrimaire),
                            $this->f->get_connected_user_login_name(),
                            $demandeurs[$idDemandeur],
                            $collectivite_di,
                            $paramNotifAnnexe
                        );
                        if ($idNotif === false) {
                                $message_class = "error";
                                $message = __("Erreur lors de la génération de la notification au(x) pétitionnaire(s).");
                                $this->f->displayMessage($message_class, $message);
                                // quitte la boucle si l'ajout de la notification échoue
                                break;
                        }
                        // Création de la tache en lui donnant l'id de la notification
                        $notification_by_task = $this->notification_by_task(
                            $idNotif,
                            $this->getVal('dossier'),
                            $categorie
                        );
                        if ($notification_by_task === false) {
                            $message = __("Erreur lors de la génération de la notification au(x) pétitionnaire(s).").'<br/>';
                            $this->f->displayMessage('error', $message);
                            // quitte la boucle si l'ajout de la tache de notification échoue
                            break;
                        }
                    }
                }
                if ($nbDemChoisis === 0) {
                    $message = __("Aucun pétitionnaire n'a été sélectionné.").'<br/>';
                    $this->f->displayMessage($message_class, $message);
                } elseif ($message_class === 'valid') {
                    // Met en forme la liste des annexes qui sera affiché dans le message de notification
                    $listeLib = $this->get_libelle_annexe($idNotif);
                    $htmlListeAnnexe = '';
                    if ($listeLib != false && ! empty($listeLib)) {
                        $listeLib = array_map(function ($lib) {
                            return '<li>'.$lib['document'].'</li>';
                        }, $listeLib);

                        $htmlListeAnnexe = sprintf(
                            '%s
                            <ul>
                                %s
                            </ul>',
                            __('Les pièces et documents suivants seront envoyés :'),
                            implode("\n", $listeLib)
                        );
                    }

                    // Message de valisation si il n'y a pas eu d'erreur au cours du traitement
                    $message = sprintf(
                        '%s<br/>
                        %s
                        <br/>
                        %s',
                        __("La notification a été générée."),
                        $htmlListeAnnexe,
                        __("Le suivi de la notification est disponible depuis l'instruction.")
                    );
                    $this->f->displayMessage($message_class, $message);
                    return;
                }
            } else {
                // Si il y a plus de $nb_annexe_max annexes informe l'utilisateur que le nombre maximum
                // d'annexe a été dépassé
                $message = sprintf(
                    __('Plus de %1$d annexes ont été sélectionnées vous devez en supprimer %2$d pour que les pétitionnaires soient notifiés.'),$nb_annexe_max,
                    (count($annexes) - intVal($nb_annexe_max))
                );
                $this->f->displayMessage('error', $message);
                $tooManyAnnexe = true;
            }
        }

        //
        // Affichage du formulaire
        //
        // Récupération du paramétrage d'affichage de la vue
        $evenement = $this->get_inst_evenement($this->getVal('evenement'));
        $moyenNotification = $this->f->get_param_option_notification($collectivite_di);
        $selectionPetitio = $moyenNotification !== PORTAL ?
            true : false;
        $typeNotif = $evenement->getVal('notification');
        $selectAnnexe = $typeNotif == 'notification_manuelle_annexe' || $typeNotif == 'notification_manuelle_annexe_signature_requise' ?
            true : false;

        $champs = array();
        // Préparation des champs de sélection des demandeurs
        if ($selectionPetitio === true) {
            if ($demandeurs === array()) {
                // Affiche un message d'erreur si aucun demandeur ne peut être notifié
                $message_class = "error";
                $message = _("Aucun demandeur notifiable");
                $this->f->displayMessage($message_class, $message);
                return;
            }
            // Préparation de l'instanciation de l'objet formulaire avec 1 champs par demandeur
            $champs = array_keys($demandeurs);
        }

        // Vérification du paramétrage de la notification
        if (! $this->is_parametrage_notification_correct($collectivite_di)) {
            $message_class = "error";
            $message = __("Attention l'url d'accès au(x) document(s) notifié(s) n'est pas paramétrée.");
            $this->f->displayMessage($message_class, $message);
        }

        // Préparation du champs de sélection de l'annexe
        if ($selectAnnexe === true) {
            // Le message n'est pas affiché si l'utilisateur a déjà sélectionner des documents
            // et qu'il en a trop sélectionné
            if ($tooManyAnnexe != true) {
                // Afficher un message d'information (bleu) sur le formulaire de notification manuelle,
                // si le demandeur principal ne peut pas être notifié 
                // et si la notification se fait via PORTAL
                if ($categorie == null || $categorie == '' || $categorie === PORTAL) {
                    $idPetiPrinc = array_keys($demandeurs);
                    if (array_key_exists(0, $idPetiPrinc) === false) {
                        $message = __("Le demandeur principal ne peut pas être notifié : la notification se fait via PORTAL");
                        $this->f->displayMessage('info', $message);
                    }
                }
                $message = sprintf(__("Si vous le souhaitez, vous pouvez ajouter jusqu'à %d annexes."), $nb_annexe_max).
                    "<br>".
                    __("Sinon cliquez directement sur \"Valider\" pour notifier le pétitionnaire.");
                $this->f->displayMessage('info', $message);
            }
            // Préparation du champs de select de l'annexe
            $champs[] = "annexes-documents";
            $champs[] = "annexes-pieces";

            // Récupération des méthodes permettant de remplir les selects
            $pieces_annexe = $this->get_pieces_annexe($dossier);
            $documents_annexe = $this->get_documents_annexe($dossier);

            // Paramétrages des selects
            $optionSelect = array(_('choisir'));
            $valueSelect = array('');
            $contenuSelectPieces = array(
                0 => array_merge($valueSelect, array_keys($pieces_annexe)),
                1 => array_merge($optionSelect, array_values($pieces_annexe))
            );
            $contenuSelectDocuments = array(
                0 => array_merge($valueSelect, array_keys($documents_annexe)),
                1 => array_merge($optionSelect, array_values($documents_annexe))
            );
        }

        // Affichage du formulaire, si il y a des élements à afficher
        if ($champs != array()) {
            // Instanciation du formulaire avec les champs voulus
            $form = $this->f->get_inst__om_formulaire(array(
                "validation" => 0,
                "maj" => $this->getParameter("maj"),
                "champs" => $champs
            ));
            $listIdDemandeurs = array_keys($demandeurs);
            $premierChamps = isset($listIdDemandeurs[0]) ? $listIdDemandeurs[0] : null;
            $dernierChamps = null;

            // Paramétrage des champs correspondant aux différents demandeurs
            if ($selectionPetitio === true) {
                foreach ($listIdDemandeurs as $idDemandeur) {
                    $dernierChamps = $idDemandeur;
                    // Paramétrage des champs du formulaire
                    $form->setType($idDemandeur, 'checkbox');
                    $form->setTaille($idDemandeur, 1);
                    $form->setMax($idDemandeur, 1);
                    $form->setVal($idDemandeur, 'f');
                    // Si le formulaire a déjà été envoyé, on récupère les valeurs et on les réaffiche.
                    // C'est notamment le cas si l'utilisateur sélectionne plus d'annexe que le nombre
                    // autorisé.
                    if (array_key_exists($idDemandeur, $postValues) && ! empty($postValues[$idDemandeur])) {
                        $form->setVal($idDemandeur, $postValues[$idDemandeur]);
                    }
    
                    // Récupération des informations du demandeur
                    $demandeur = $this->f->get_inst__om_dbform(array(
                        "obj" => 'demandeur',
                        "idx" => $idDemandeur,
                    ));
                    // TODO : optimiser la récuépration du nom du demandeur ou écrire une méthode servant
                    // à la récupérer
                    // Comme il ne peut y avoir de nom que pour une personne morale ou un particulier
                    // en utilisant tous les champs et en faisant un trim l'intitulé peut être récupéré
                    $intituleDem =
                        $demandeur->getVal('particulier_nom').
                        ' '.
                        $demandeur->getVal('particulier_prenom').
                        ' '.
                        $demandeur->getVal('personne_morale_denomination').
                        ' '.
                        $demandeur->getVal('personne_morale_raison_sociale');

                    if ($demandeur->getVal('personne_morale_nom') != '' &&
                        $demandeur->getVal('personne_morale_prenom') != '') {
                        $intituleDem .= sprintf(
                            ' représenté par %1$s %2$s',
                            $demandeur->getVal('personne_morale_nom'),
                            $demandeur->getVal('personne_morale_prenom')
                        );
                    }
                    // Récupération du type de pétitionnaire à partir des infos de la demande
                    $typeDemandeur = $idPetitioPrinc == $demandeur->getVal('demandeur') ?
                        __('pétitionnaire principal') :
                        __($demandeur->getVal('type_demandeur'));

                    $lib = sprintf(
                        '%1$s | %2$s | %3$s',
                        $intituleDem,
                        $demandeur->getVal('courriel'),
                        $typeDemandeur
                    );
                    $form->setLib($idDemandeur, trim($lib));
                }
            }

            // Parmétrage du champs annexe dans le formulaire
            if ($selectAnnexe === true) {
                // Paramétrage du champs annexes-documents
                $form->setType('annexes-documents', 'select_multiple');
                $form->setLib('annexes-documents', __('Documents d\'instruction ou retour d\'avis'));
                $form->setSelect("annexes-documents", $contenuSelectDocuments);
                $form->setVal("annexes-documents", '');
                // Si le formulaire a déjà été envoyé, on récupère les valeurs et on les réaffiche.
                if (array_key_exists('annexes-documents', $postValues) && ! empty($postValues['annexes-documents'])) {
                    $form->setVal("annexes-documents", implode(';', $postValues['annexes-documents']));
                }
                $form->setTaille("annexes-documents", 10);
                // Paramétrage du champs annexes-pieces
                $form->setType('annexes-pieces', 'select_multiple');
                $form->setLib('annexes-pieces', __('Pièce(s) (Fichiers déposés par le pétitionnaire)'));
                $form->setSelect("annexes-pieces", $contenuSelectPieces);
                $form->setVal("annexes-pieces", '');
                // Si le formulaire a déjà été envoyé, on récupère les valeurs et on les réaffiche.
                if (array_key_exists('annexes-pieces', $postValues) && ! empty($postValues['annexes-pieces'])) {
                    $form->setVal("annexes-pieces", implode(';', $postValues['annexes-pieces']));
                }
                $form->setTaille("annexes-pieces", 10);
            }

            if ($premierChamps != null) {
                $form->setBloc($premierChamps, 'D', _("Sélection des pétitionnaires à notifier"), "alignFormSpec bloc-overlay-notification");
                $form->setBloc($dernierChamps, 'F', "", "alignFormSpec bloc-overlay-notification");
            }
            $form->setBloc('annexes-documents', 'D', _("Documents"), "alignFormSpec bloc-overlay-notification");
            $form->setBloc('annexes-documents', 'F', "", "alignFormSpec bloc-overlay-notification");
            $form->setBloc('annexes-pieces', 'D', __("Pièces"), "alignFormSpec bloc-overlay-notification");
            $form->setBloc('annexes-pieces', 'F', "", "alignFormSpec bloc-overlay-notification");

            // Ouverture du formulaire de sélection des demandeurs
            $this->f->layout->display__form_container__begin(array(
                "action" => '',
                "onsubmit" => "affichersform('instruction_notification_manuelle', '".
                    $this->getDataSubmit().
                    "', this); validation_formulaire_notification_manuelle(); return false;",
                "name" => "f2",
            ));
            // Ouverture du conteneur de formulaire
            $form->entete();
            // affichage des champs
            $form->afficher($champs, 0, false, false);
            // Fermeture du conteneur de formulaire
            $form->enpied();
            $this->f->layout->display__form_controls_container__begin(array(
                "controls" => "bottom",
            ));
            // Affichage du bouton valider
            $this->f->layout->display__form_input_submit(array(
                "name" => "submit-directory",
                "value" => __("Valider"),
                "class" => "boutonFormulaire",
            ));
            $this->f->layout->display__form_controls_container__end();
            $this->f->layout->display__form_container__end();
        }
    }

    /**
     * VIEW - view_notification_service_consulte.
     *
     * Formulaire de paramétrage de la notification de l'instruction au
     * service consulte.
     * Ce formulaire est divisé en deux parties :
     *  1) Sélection des services consultés parmis la liste des services
     *     ayant une adresse mail (minimum) et pouvant être notifier par
     *     mail
     *  2) Sélection des pièces à transmettre dans la notification parmis
     *     la liste des documents d'instruction validé et signé et la
     *     liste des retours d'avis
     *
     * A la validation de ce formulaire le traitement d'envoi des mails est
     * déclenché et le suivi des notifications envoyées est réalisé.
     *
     * @return void
     */
    function view_notification_service_consulte() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Non affichage du fil d'ariane /!\ la surcharge se fait
        // depuis la méthode getSubFormTitle en renseignant le numéro de l'action
        // dans la méthode puis en appellant la méthode
        $this->getSubFormTitle('');
        $dossier = $this->getVal('dossier');
        $collectivite_di = $this->get_dossier_instruction_om_collectivite($dossier);


        //
        // Traitement des données du formulaire
        //
        // Si des données ont été envoyées par le formulaire
        $postValues = $this->f->get_submitted_post_value();
        $error = false;
        $message = __("La notification a été générée.");
        if ($postValues != null && is_array($postValues) && $postValues != array()) {
            // Récupèration de la liste des mails a envoyer
            $mails = array();
            foreach ($postValues as $idService => $isChecked) {
                if ($isChecked == 'Oui' && is_numeric($idService)) {
                    // Récupération de la liste des adresses mail du service
                    $mails = array_merge($mails, $this->get_liste_destinataires_service($idService));
                }
            }
            if ($mails === array()) {
                $error = true;
                $message = __("Erreur, il n'y a aucun destinataire pour la notification.");
            }

            // Préparation du paramétrage des annexes a envoyer
            $paramNotifAnnexe = array();
            if (! $error && is_array($postValues['annexes']) && $postValues['annexes'] != array()) {
                // Pour chaque annexe récupération du type de document et de son id
                foreach ($postValues['annexes'] as $annexe) {
                    // Gestion du cas ou la première ligne du select multiple est sélectionnée
                    if ($annexe == '') {
                        continue;
                    }
                    // Sépare le nom de la table de l'identifiant du document.
                    // ex : consultation_1 => $paramAnnexe[0] = consultation et $paramAnnexe[0] = 1
                    $paramAnnexe = explode('_', $annexe);
                    // Paramètre la notification du document avec les valeurs récupérées
                    if (! (is_array($paramAnnexe) && $paramAnnexe[0] != null && $paramAnnexe[1] != null)) {
                        $error = true;
                        $message = __("Erreur, le format des données récupérées est invalide.");
                        break;
                    }
                    $paramNotifAnnexe[] = array(
                        'id' => $paramAnnexe[1],
                        'tableDocument' => $paramAnnexe[0],
                        'isAnnexe' => true
                    );
                }
            }

            // Préparation des notifications pour chacune des adresses mails de la liste
            if (! $error) {
                foreach ($mails as $mail) {
                    // Ajout de la notif et de ses annexes
                    $idNotif = $this->ajouter_notification(
                        $this->getVal($this->clePrimaire),
                        $this->f->get_connected_user_login_name(),
                        $mail,
                        $collectivite_di,
                        $paramNotifAnnexe
                    );
                    if ($idNotif === false) {
                        $error = true;
                        $message = __("Erreur lors de la génération de la notification au(x) service(s).");
                        break;
                    }
    
                    // Création de la tache en lui donnant l'id de la notification
                    $notification_by_task = $this->notification_by_task(
                        $idNotif,
                        $this->getVal('dossier'),
                        'mail',
                        'notification_service_consulte'
                    );
                    if ($notification_by_task === false) {
                        $error = true;
                        $message = __("Erreur lors de la génération de la notification au(x) service(s).");
                        break;
                    }
                }
            }
            $typeMessage = $error ? 'error' : 'valid';
            $this->f->displayMessage(
                $typeMessage,
                $message
            );
        }

        //
        // Affichage du formulaire
        //

        // Vérification du paramétrage de la notification
        $urlAccesNotif = $this->f->get_parametre_notification_url_acces($collectivite_di);
        if ($urlAccesNotif == null) {
            $this->f->displayMessage(
                'error',
                __("Attention l'url d'accès au(x) document(s) notifié(s) n'est pas paramétrée.")
            );
            return;
        }
        // Récupération de la liste des champs du formulaire
        $champs = array();
        
        // Si il n'existe pas de service pouvant être notifié affiche
        // uniquement un message d'erreur pour prévenir l'utilisateur.
        $listeService = $this->get_liste_service_notifiable();
        if ($listeService === array()) {
            $this->f->displayMessage("error", _("Aucun service notifiable"));
            return;
        }
        // Sinon on ajoute un champs par service pouvant être notifié
        $champs = array_keys($listeService);
        // Ajout du champs de sélection des documents a annexé
        $champs[] = 'annexes';

        // Paramétrage du formulaire
        // Instanciation du formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => $this->getParameter("maj"),
            "champs" => $champs
        ));
        
        // Paramétrage des champs
        // Paramétrage des cases a cocher servant a choisir les services à notifier
        foreach ($listeService as $idService => $nomService) {
            $form->setType($idService, 'checkbox');
            $form->setLib($idService, $nomService);
            $form->setTaille($idService, 1);
            $form->setMax($idService, 1);
            $form->setVal($idService, 'f');
        }
        // Paramétrage du select multiple servant a choisir les annexes
        $form->setType('annexes', 'select_multiple');
        $form->setLib('annexes', __('pièce(s) à joindre'));
        $form->setTaille('annexes', 10);
        $form->setMax('annexes', 10);
        // Paramétrage du select du champs annexe avec la liste des documents
        // pouvant être transmis
        $listeDocumentInstruction = $this->get_liste_document_instruction();
        $listeAvisConsultation = $this->get_liste_avis_consultation();
        $listeDocument = array_merge($listeDocumentInstruction, $listeAvisConsultation);
        $contenu = array(
            array_merge(array(''), array_keys($listeDocument)),
            array_merge(array(_('sélectionner annexe(s)')), array_values($listeDocument))
        );
        $form->setSelect("annexes", $contenu);
        $form->setVal("annexes", '');

        // Mise en forme des blocs du formulaire
        reset($listeService);
        $form->setBloc(key($listeService), 'D', _("Sélection des services à notifier"), "alignFormSpec bloc-overlay-notification");
        end($listeService);
        $form->setBloc(key($listeService), 'F', "", "alignFormSpec bloc-overlay-notification");
        $form->setBloc('annexes', 'D', _("Sélection des annexes"), "alignFormSpec bloc-overlay-notification");
        $form->setBloc('annexes', 'F', "", "alignFormSpec bloc-overlay-notification");

        // Affichage du formulaire
        $onsubmit = sprintf(
            "affichersform('instruction_notification_manuelle', '%1\$s', this);
            validation_formulaire_notification_manuelle();
            return false;",
            $this->getDataSubmit()
        );
        $this->afficher_formulaire_notification($form, $champs, $onsubmit);
    }

    /**
     * VIEW - view_notification_tiers_consulte.
     *
     * Formulaire de paramétrage de la notification de l'instruction au
     * tiers consulte.
     * Ce formulaire est divisé en deux parties :
     *  1) Sélection des tiers consultés parmis la liste des tiers
     *     ayant une adresse mail (minimum) et pouvant être notifier par
     *     mail.
     *  2) Sélection des pièces à transmettre dans la notification parmis
     *     la liste des documents d'instruction validé et signé et la
     *     liste des retours d'avis
     *
     * A la validation de ce formulaire le traitement d'envoi des mails est
     * déclenché et le suivi des notifications envoyées est réalisé.
     *
     * @return void
     */
    function view_notification_tiers_consulte() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Non affichage du fil d'ariane. /!\ la surcharge se fait
        // depuis la méthode getSubFormTitle en renseignant le numéro de l'action
        // dans la méthode puis en appellant la méthode
        $this->getSubFormTitle('');
        $dossier = $this->getVal('dossier');
        $collectivite_di = $this->get_dossier_instruction_om_collectivite($dossier);

        //
        // Traitement des données du formulaire
        //
        // Si des données ont été envoyées par le formulaire
        $postValues = $this->f->get_submitted_post_value();
        $error = false;
        $message = __("La notification a été générée.");
        if ($postValues != null && is_array($postValues) && $postValues != array()) {
            // Récupèration de la liste des mails a envoyer
            $mails = array();
            foreach ($postValues['tiers_consulte'] as $idTiers) {
                if ($idTiers != '') {
                    // Récupération de la liste des adresses mail des tiers consulté
                    $mails = array_merge($mails, $this->get_liste_destinataires_tiers($idTiers));
                }
            }
            if ($mails === array()) {
                $error = true;
                $message = __("Erreur, il n'y a aucun destinataire pour la notification.");
            }

            // Préparation du paramétrage des annexes a envoyer
            $paramNotifAnnexe = array();
            // Pour chaque annexe récupération du type de document et de son id
            if (! $error) {
                foreach ($postValues['annexes'] as $annexe) {
                    // Gestion du cas ou la première ligne du select multiple est sélectionnée
                    if ($annexe == '') {
                        continue;
                    }
                    // Sépare le nom de la table de l'identifiant du document.
                    // ex : consultation_1 => $paramAnnexe[0] = consultation et $paramAnnexe[0] = 1
                    $paramAnnexe = explode('_', $annexe);
                    // Paramètre la notification du document avec les valeurs récupérées
                    if (! (is_array($paramAnnexe) && $paramAnnexe[0] != null && $paramAnnexe[1] != null)) {
                        $error = true;
                        $message = __("Erreur, le format des données récupérées est invalide.");
                        break;
                    }
                    $paramNotifAnnexe[] = array(
                        'id' => $paramAnnexe[1],
                        'tableDocument' => $paramAnnexe[0],
                        'isAnnexe' => true
                    );
                }
    
                // Préparation des notifications pour chacune des adresses mails de la liste
                if (! $error) {
                    foreach ($mails as $mail) {
                        // Ajout de la notification et de ses annexes
                        $idNotif = $this->ajouter_notification(
                            $this->getVal($this->clePrimaire),
                            $this->f->get_connected_user_login_name(),
                            $mail,
                            $collectivite_di,
                            $paramNotifAnnexe
                        );
                        if ($idNotif === false) {
                            $error = true;
                            $message = __("Erreur lors de la génération de la notification au(x) tier(s).");
                            break;
                        }
        
                        // Création de la tache en lui donnant l'id de la notification
                        $notification_by_task = $this->notification_by_task(
                            $idNotif,
                            $this->getVal('dossier'),
                            'mail',
                            'notification_tiers_consulte'
                        );
                        if ($notification_by_task === false) {
                            $error = true;
                            $message = __("Erreur lors de la génération de la notification au(x) tier(s).");
                            break;
                        }
                    }
                }
            }
            $typeMessage = $error ? 'error' : 'valid';
            $this->f->displayMessage(
                $typeMessage,
                $message
            );
        }

        //
        // Affichage du formulaire
        //

        // Vérification du paramétrage de la notification
        $urlAccesNotif = $this->f->get_parametre_notification_url_acces($collectivite_di);
        if ($urlAccesNotif == null) {
            $this->f->displayMessage(
                'error',
                __("Attention l'url d'accès au(x) document(s) notifié(s) n'est pas paramétrée.")
            );
            return;
        }
        
        // Si il n'existe pas de tiers pouvant être notifié affiche
        // uniquement un message d'erreur pour prévenir l'utilisateur.
        $listeService = $this->get_liste_tiers_notifiable();
        if ($listeService === array()) {
            $this->f->displayMessage("error", __("Aucun tiers notifiable"));
            return;
        }

        // Paramétrage du formulaire
        // Instanciation du formulaire
        $champs = array('tiers_consulte', 'annexes');
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => $this->getParameter("maj"),
            "champs" => $champs
        ));
        
        // Paramétrage du select multiple servant a choisir les tiers
        $contenu = array(
            array_merge(array(''), array_keys($listeService)),
            array_merge(array(_('sélectionner tier(s)')), array_values($listeService))
        );
        $form->setType('tiers_consulte', 'select_multiple');
        $form->setLib('tiers_consulte', __('Tiers à notifier'));
        $form->setTaille('tiers_consulte', 20);
        $form->setMax('tiers_consulte', 20);
        $form->setSelect("tiers_consulte", $contenu);
        $form->setVal('tiers_consulte', '');
        
        // Paramétrage du select multiple servant a choisir les annexes
        $form->setType('annexes', 'select_multiple');
        $form->setLib('annexes', __('pièce(s) à joindre'));
        $form->setTaille('annexes', 10);
        $form->setMax('annexes', 10);
        // Paramétrage du select du champs annexe avec la liste des documents
        // pouvant être transmis
        $listeDocumentInstruction = $this->get_liste_document_instruction();
        $listeAvisConsultation = $this->get_liste_avis_consultation();
        $listeDocument = array_merge($listeDocumentInstruction, $listeAvisConsultation);
        $contenu = array(
            array_merge(array(''), array_keys($listeDocument)),
            array_merge(array(_('sélectionner annexe(s)')), array_values($listeDocument))
        );
        $form->setSelect("annexes", $contenu);
        $form->setVal("annexes", '');

        // Mise en forme des blocs du formulaire
        $form->setBloc('tiers_consulte', 'D', __("Sélection des tiers à notifier"), "alignFormSpec bloc-overlay-notification");
        $form->setBloc('tiers_consulte', 'F', "", "alignFormSpec bloc-overlay-notification");
        $form->setBloc('annexes', 'D', __("Sélection des annexes"), "alignFormSpec bloc-overlay-notification");
        $form->setBloc('annexes', 'F', "", "alignFormSpec bloc-overlay-notification");

        // Affichage du formulaire
        $onsubmit = sprintf(
            "affichersform('instruction_notification_manuelle', '%1\$s', this);
            validation_formulaire_notification_manuelle();
            return false;",
            $this->getDataSubmit()
        );
        $this->afficher_formulaire_notification($form, $champs, $onsubmit);
    }

    protected function afficher_formulaire_notification(
        $form,
        $champs,
        $formOnsubmit = '',
        $valueBoutonValidation = 'Valider',
        $formAction = '',
        $formName = 'f2',
        $nameBoutonValidation = "submit-directory",
        $classBoutonValidation = "boutonFormulaire"
    ) {
        // Ouverture du formulaire
        $this->f->layout->display__form_container__begin(array(
            "action" => $formAction,
            "onsubmit" => $formOnsubmit,
            "name" => $formName,
        ));
        // Ouverture du conteneur de formulaire
        $form->entete();
        // affichage des champs
        $form->afficher($champs, 0, false, false);
        // Fermeture du conteneur de formulaire
        $form->enpied();
        // Ouverture de la zone contenant le bouton de validation
        $this->f->layout->display__form_controls_container__begin(array(
            "controls" => "bottom",
        ));
        // Affichage du bouton valider
        $this->f->layout->display__form_input_submit(array(
            "name" => $nameBoutonValidation,
            "value" => $valueBoutonValidation,
            "class" => $classBoutonValidation,
        ));
        // Fermeture de la zone contenant le bouton de validation
        $this->f->layout->display__form_controls_container__end();
        // Fermeture du formulaire
        $this->f->layout->display__form_container__end();
    }

    /**
     * TODO : faire en sorte que cette méthode permettent de récupérer les
     * doc pour la notif des demandeurs et celle des service
     */
    protected function get_liste_document_instruction() {
        $listeDocument = array();
        // Requête pour récupérer la liste des services consultés pouvant être notifiés
        $sql = sprintf(
            'SELECT
                evenement.libelle,
                instruction.instruction
            FROM
                %1$sevenement
                INNER JOIN %1$sinstruction ON instruction.evenement=evenement.evenement 
            WHERE
                instruction.date_retour_signature IS NOT NULL
                AND om_final_instruction = true
                AND instruction.instruction != %2$d
                AND instruction.dossier = \'%3$s\'
            ORDER BY
                evenement.libelle ASC',
            DB_PREFIXE,
            intVal($this->getVal($this->clePrimaire)),
            $this->f->db->escapeSimple($this->getVal("dossier"))
        );
        $qres = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        
        if ($qres['code'] !== 'OK') {
            $this->f->addToLog(__METHOD__."(): ERROR db->query(\"".$sql."\")", DEBUG_MODE);
            return $listeDocument;
        }
        // Rempli le tableau contenant la liste des services notifiables
        foreach($qres['result'] as $row) {    
            $listeDocument['instruction_'.$row['instruction']] = $row['libelle'];
        }
        return $listeDocument;
    }
    
    /**
     * TODO : faire en sorte que cette méthode permettent de récupérer les
     * doc pour la notif des demandeurs et celle des service
     */
    protected function get_liste_avis_consultation() {
        $listeDocument = array();
        // Requête pour récupérer la liste des services consultés pouvant être notifiés
        $sql = sprintf(
            'SELECT
                CONCAT(\'Avis - \', service.libelle, \' - \', to_char(consultation.date_retour, \'DD/MM/YYYY\')) AS libelle,
                consultation.consultation
            FROM
                %1$sconsultation
                JOIN %1$sservice
                    ON consultation.service = service.service
            WHERE
                consultation.fichier IS NOT NULL
                AND consultation.date_retour IS NOT NULL
                AND consultation.dossier = \'%2$s\'
            ORDER BY
                libelle ASC',
            DB_PREFIXE,
            $this->f->db->escapeSimple($this->getVal("dossier"))
        );
        $qres = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        // Gestion des erreurs de base de données
        if ($qres['code'] !== 'OK') {
            $this->f->addToLog(__METHOD__."(): ERROR db->query(\"".$sql."\")", DEBUG_MODE);
            return $listeDocument;
        }
        // Rempli le tableau contenant la liste des services notifiables
        foreach($qres['result'] as $row) {
            $listeDocument['consultation_'.$row['consultation']] = $row['libelle'];
        }
        return $listeDocument;
    }

    protected function get_liste_service_notifiable() {
        $listeService = array();
        // Requête pour récupérer la liste des services consultés pouvant être notifiés
        $sql = sprintf(
            'SELECT
                service.service,
                service.libelle
            FROM
                %1$sservice
            WHERE
                service.accepte_notification_email = TRUE
                AND email IS NOT NULL
            ORDER BY
                service.libelle ASC',
            DB_PREFIXE
        );
        $qres = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        // Gestion des erreurs de base de données
        if ($qres['code'] !== 'OK') {
            $this->f->addToLog(__METHOD__."(): ERROR db->query(\"".$sql."\")", DEBUG_MODE);
            return $listeService;
        }

        foreach($qres['result'] as $row) {
            $listeService[$row['service']] = $row['libelle'];
        }
        return $listeService;
    }

    /**
     * Récupère à l'aide d'une requête sql tous les tiers consulté
     * étant notifiable et ayant au moins une adresse mail enregistrée.
     *
     * Renvoie cette liset sous la forme d'un tableau dont les clés sont
     * les identifiants des tiers et les valeurs leur libellé.
     *
     * @return array
     */
    protected function get_liste_tiers_notifiable() {
        $listeTiers = array();
        // Requête pour récupérer la liste des tiers consultés pouvant être notifiés
        $sql = sprintf(
            'SELECT
                tiers_consulte.tiers_consulte,
                tiers_consulte.libelle
            FROM
                %1$stiers_consulte
                INNER JOIN %1$scategorie_tiers_consulte
                    ON tiers_consulte.categorie_tiers_consulte = categorie_tiers_consulte.categorie_tiers_consulte
                INNER JOIN %1$slien_categorie_tiers_consulte_om_collectivite
                    ON lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte = categorie_tiers_consulte.categorie_tiers_consulte
            WHERE
                tiers_consulte.accepte_notification_email = TRUE
                AND liste_diffusion IS NOT NULL
                AND lien_categorie_tiers_consulte_om_collectivite.om_collectivite = %2$d
            ORDER BY
                tiers_consulte.libelle ASC',
            DB_PREFIXE,
            intval($this->get_dossier_instruction_om_collectivite($this->getVal('dossier')))
        );
        $qres = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        // Gestion des erreurs de base de données
        if ($qres['code'] !== 'OK') {
            $this->f->addToLog(__METHOD__."(): ERROR db->query(\"".$sql."\")", DEBUG_MODE);
            return $listeTiers;
        }
        // Rempli le tableau contenant la liste des tiers notifiables
        foreach($qres['result'] as $row) {
            $listeTiers[$row['tiers_consulte']] = $row['libelle'];
        }
        return $listeTiers;
    }

    /**
     * Récupère sous la forme d'un tableau la liste de
     * tous les mails du service dont l'identifiant est
     * passé en paramètre.
     *
     * @param integer identifiant du service dont on souhaite récupérer
     * les adresses mails
     * @return array tableau contenant les adresses mails
     */
    protected function get_liste_destinataires_service($idService) {
        $listeDestinataires = array();
        // Instanciation du service avec l'adresse mail fournie
        $service = $this->f->get_inst__om_dbform(array(
            "obj" => "service",
            "idx" => $idService,
        ));
        $mails = explode("\n", $service->getVal('email'));
        foreach ($mails as $mail) {
            $listeDestinataires[] = array(
                "destinataire" => $service->getVal('libelle').' - '.$mail,
                "courriel" => $mail
            );
        }
        return $listeDestinataires;
    }

    /**
     * Récupère sous la forme d'un tableau la liste de
     * tous les mails du tiers dont l'identifiant est
     * passé en paramètre.
     *
     * @param integer dentifiants du tiers dont on souhaite obtenir les adresses mails
     * @return array tableau contenant les adresses mails
     */
    protected function get_liste_destinataires_tiers($idTiers) {
        $listeDestinataires = array();
        // Instanciation du service avec l'adresse mail fournie
        $tiers = $this->f->get_inst__om_dbform(array(
            "obj" => "tiers_consulte",
            "idx" => $idTiers,
        ));
        $mails = explode("\n", $tiers->getVal('liste_diffusion'));
        foreach ($mails as $mail) {
            $listeDestinataires[] = array(
                "destinataire" => $tiers->getVal('libelle').' - '.$mail,
                "courriel" => $mail
            );
        }
        return $listeDestinataires;
    }

    protected function get_documents_annexe($dossier = null) {
        $avis = $this->get_liste_avis_consultation();
        $documentInstruction = $this->get_liste_document_instruction();
        return array_merge($avis, $documentInstruction);
    }

    protected function get_pieces_annexe($dossier = null) {
        if (empty($dossier)) {
            $dossier = $this->getVal('dossier');
        }
        $listePiece = array();

        $sql = sprintf(
            'SELECT  
                document_numerise.document_numerise AS document_numerise,
                document_numerise_type.libelle AS document_numerise_type
            FROM 
                %1$sdocument_numerise 
                LEFT JOIN %1$sdocument_numerise_type
                    ON document_numerise.document_numerise_type = document_numerise_type.document_numerise_type
            WHERE
                document_numerise.document_travail IS FALSE
                AND document_numerise.dossier = \'%2$s\'',
            DB_PREFIXE,
            $this->f->db->escapeSimple($dossier)
        );

        $qres = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        // Gestion des erreurs de base de données
        if ($qres['code'] !== 'OK') {
            $this->f->addToLog(__METHOD__."(): ERROR db->query(\"".$sql."\")", DEBUG_MODE);
            return $listePiece;
        }
        // Rempli le tableau contenant la liste des services notifiables
        foreach($qres['result'] as $row) {
            $listePiece['document-numerise_'.$row['document_numerise']] = $row['document_numerise_type'];
        }
        return $listePiece;
    }

    protected function get_libelle_annexe($notification) {
        if (empty($notification)) {
            $this->addToLog(__('Erreur: l\'identifiant de la notification est nécessaire à la récupération des noms des document notifiés.'));
            return false;
        }

        $sql = sprintf(
            'SELECT
                -- Récupération du nom des annexes selon le type de document notifié
                CASE WHEN
                    instruction_notification_document.document_type = \'instruction\'
                    THEN evenement.libelle
                WHEN
                    instruction_notification_document.document_type = \'consultation\'
                    -- Récupération du libelle du service ou du tiers ayant rendu l\'\'avis
                    THEN (CASE WHEN
                            consultation.tiers_consulte IS NOT NULL
                            THEN CONCAT(\'Avis - \', tiers_consulte.libelle)
                        ELSE
                            CONCAT(\'Avis - \', service.libelle, \' - \', to_char(consultation.date_retour, \'DD/MM/YYYY\'))
                        END)
                ELSE
                    document_numerise_type.libelle
                END AS document
            FROM 
                %1$sinstruction_notification_document
                LEFT JOIN %1$sinstruction
                    ON instruction_notification_document.document_id = instruction.instruction
                LEFT JOIN %1$sevenement
                    ON instruction.evenement = evenement.evenement
                LEFT JOIN %1$sconsultation
                    ON instruction_notification_document.document_id = consultation.consultation
                LEFT JOIN %1$sservice
                    ON consultation.service = service.service
                LEFT JOIN %1$stiers_consulte
                    ON consultation.tiers_consulte = tiers_consulte.tiers_consulte
                LEFT JOIN %1$sdocument_numerise
                    ON instruction_notification_document.document_id = document_numerise.document_numerise
                LEFT JOIN %1$sdocument_numerise_type
                    ON document_numerise.document_numerise_type = document_numerise_type.document_numerise_type
            WHERE
                instruction_notification_document.instruction_notification = \'%2$s\'
            ORDER BY
                instruction_notification_document.instruction_notification_document',
            DB_PREFIXE,
            $notification
        );
        $res = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        return $res['result'];
    }
}// fin classe
