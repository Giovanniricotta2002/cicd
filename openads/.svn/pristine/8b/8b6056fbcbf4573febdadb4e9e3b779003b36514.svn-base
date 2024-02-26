<?php
/**
 * DBFORM - 'consultation' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id: consultation.class.php 6046 2016-02-26 15:27:06Z fmichon $
 */

require_once ("../gen/obj/consultation.class.php");

class consultation extends consultation_gen {
    
    // Champs contenant les UID des fichiers
    var $abstract_type = array(
        "fichier" => "file",
        "om_fichier_consultation" => "file",
    );

    var $metadata = array(
        "om_fichier_consultation" => array(
            "dossier" => "getDossier",
            "dossier_version" => "getDossierVersion",
            "numDemandeAutor" => "getNumDemandeAutor",
            "anneemoisDemandeAutor" => "getAnneemoisDemandeAutor",
            "typeInstruction" => "getTypeInstruction",
            "statutAutorisation" => "getStatutAutorisation",
            "typeAutorisation" => "getTypeAutorisation",
            "dateEvenementDocument" => "getDateEvenementDocument",
            "groupeInstruction" => 'getGroupeInstruction',
            "title" => 'getTitle',
            'concerneERP' => 'get_concerne_erp',

            'type' => 'getDocumentType',
            'dossier_autorisation_type_detaille' => 'getDossierAutorisationTypeDetaille',
            'dossier_instruction_type' => 'getDossierInstructionTypeLibelle',
            'region' => 'getDossierRegion',
            'departement' => 'getDossierDepartement',
            'commune' => 'getDossierCommune',
            'annee' => 'getDossierAnnee',
            'division' => 'getDossierDivision',
            'collectivite' => 'getDossierServiceOrCollectivite'
        ),
        "fichier" => array(
            "filename" => "getFichierFilename",
            "dossier" => "getDossier",
            "dossier_version" => "getDossierVersion",
            "numDemandeAutor" => "getNumDemandeAutor",
            "anneemoisDemandeAutor" => "getAnneemoisDemandeAutor",
            "typeInstruction" => "getTypeInstruction",
            "statutAutorisation" => "getStatutAutorisation",
            "typeAutorisation" => "getTypeAutorisation",
            "dateEvenementDocument" => "getDateEvenementDocument",
            "groupeInstruction" => 'getGroupeInstruction',
            "title" => 'getTitle',
            'concerneERP' => 'get_concerne_erp',

            'type' => 'getDocumentType',
            'dossier_autorisation_type_detaille' => 'getDossierAutorisationTypeDetaille',
            'dossier_instruction_type' => 'getDossierInstructionTypeLibelle',
            'region' => 'getDossierRegion',
            'departement' => 'getDossierDepartement',
            'commune' => 'getDossierCommune',
            'annee' => 'getDossierAnnee',
            'division' => 'getDossierDivision',
            'collectivite' => 'getDossierServiceOrCollectivite'
        ),
        "fichier_pec" => array(
            "filename" => "getFichierFilename",
            "dossier" => "getDossier",
            "dossier_version" => "getDossierVersion",
            "numDemandeAutor" => "getNumDemandeAutor",
            "anneemoisDemandeAutor" => "getAnneemoisDemandeAutor",
            "typeInstruction" => "getTypeInstruction",
            "statutAutorisation" => "getStatutAutorisation",
            "typeAutorisation" => "getTypeAutorisation",
            "dateEvenementDocument" => "getDateEvenementDocument",
            "groupeInstruction" => 'getGroupeInstruction',
            "title" => 'getTitle',
            'concerneERP' => 'get_concerne_erp',

            'type' => 'getDocumentType',
            'dossier_autorisation_type_detaille' => 'getDossierAutorisationTypeDetaille',
            'dossier_instruction_type' => 'getDossierInstructionTypeLibelle',
            'region' => 'getDossierRegion',
            'departement' => 'getDossierDepartement',
            'commune' => 'getDossierCommune',
            'annee' => 'getDossierAnnee',
            'division' => 'getDossierDivision',
            'collectivite' => 'getDossierServiceOrCollectivite'
        ),
    );

    /**
     * Cette variable permet de stocker le résultat de la méthode
     * getDivisionFromDossier() afin de ne pas effectuer le recalcul à chacun de
     * ces appels.
     * @var string Code de la division du dossier en cours
     */
    var $_division_from_dossier = NULL;

    /**
     * Instance de la classe dossier
     *
     * @var mixed
     */
    var $inst_dossier = null;

    /**
     * Instance de la classe dossier
     *
     * @var mixed
     */
    protected $typeConsultation = null;

    /**
     * Instance de la classe dossier
     *
     * @var mixed
     */
    protected $valElementConsulte = array();

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        
        parent::init_class_actions();

        // ACTION - 000 - ajouter
        // Modifie la condition d'affichage du bouton ajouter
        $this->class_actions[0]["condition"] = array("can_user_access_dossier_contexte_ajout");

        // ACTION - 001 - modifier
        // 
        $this->class_actions[1]["condition"] = array("is_editable", "can_user_access_dossier_contexte_modification");
        
        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["condition"] = array("is_deletable", "can_user_access_dossier_contexte_modification");

        // ACTION - 040 - ajout_multiple
        // Ajout de consultations multiples
        $this->class_actions[40] = array(
            "identifier" => "ajout_multiple",
            "view" => "view_ajout_multiple",
            "method" => "ajouter_multiple",
            "button" => "valider",
            "permission_suffix" => "ajouter",
            "condition" => array("is_multiaddable", "can_user_access_dossier_contexte_ajout"),
        );
        // ACTION - 041 - ajouter_consultation_tiers
        // Ajout de consultations de tiers
        $this->class_actions[41] = array(
            "identifier" => "ajouter_consultation_tiers",
            "permission_suffix" => "ajouter_consultation_tiers",
            "crud" => "create",
            "method" => "ajouter"
        );
        // ACTION - 050 - marquer_comme_lu
        $this->class_actions[50] = array(
            "identifier" => "marquer_comme_lu",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Marquer comme lu"),
                "order" => 50,
                "class" => "lu-16",
            ),
            "view" => "formulaire",
            "method" => "marquer_comme_lu",
            "permission_suffix" => "modifier_lu",
            "condition" => array(
                "is_markable",
                "show_marquer_comme_lu_portlet_action",
                "can_user_access_dossier_contexte_modification",
            ),
        );
        // ACTION - 051 - marquer_comme_non_lu
        $this->class_actions[51] = array(
            "identifier" => "marquer_comme_non_lu",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => __("Marquer comme non lu"),
                "order" => 50,
                "class" => "nonlu-16",
            ),
            "view" => "formulaire",
            "method" => "marquer_comme_non_lu",
            "permission_suffix" => "modifier_lu",
            "condition" => array(
                "is_markable",
                "show_marquer_comme_non_lu_portlet_action",
                "can_user_access_dossier_contexte_modification",
            ),
        );
        // ACTION - 060 - finaliser
        $this->class_actions[60] = array(
            "identifier" => "finalise",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Finaliser le document"),
                "order" => 60,
                "class" => "finalise",
            ),
            "view" => "formulaire",
            "method" => "finalize",
            "permission_suffix" => "finaliser",
            "condition" => array(
                "show_consultation_finaliser_portlet_action",
                "is_finalizable",
                "can_user_access_dossier_contexte_modification",
            ),
        );

        // ACTION - 070 - unfinaliser
        $this->class_actions[70] = array(
            "identifier" => "unfinalise",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Reprendre la redaction du document"),
                "order" => 70,
                "class" => "definalise",
            ),
            "view" => "formulaire",
            "method" => "unfinalize",
            "permission_suffix" => "definaliser",
            "condition" => array(
                "show_unfinalize_portlet_action",
                "is_unfinalizable",
                "can_user_access_dossier_contexte_modification",
            ),
        );

        // ACTION - 080 - consulter_pdf
        $this->class_actions[80] = array(
            "identifier" => "consulter_pdf",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("Editer la consultation PDF"),
                "order" => 45,
                "class" => "pdf-16",
            ),
            "view" => "view_consulter_pdf",
            "permission_suffix" => "edition",
            "condition" => array(
                "can_user_access_dossier_contexte_modification",
                "is_viewable",
            ),
        );

        // ACTION - 090 - Générer l'édition PDF d'une consultation multiple
        // 
        $this->class_actions[90] = array(
            "identifier" => "generate_pdf_consultation_multiple",
            "view" => "generate_pdf_consultation_multiple",
            "permission_suffix" => "ajouter",
        );

        // ACTION - 100 - retour_consultation
        // Lors de la saisie de retour d'avis par le profil suivi des dates
        $this->class_actions[100] = array(
            "identifier" => "retour_consultation",
            "view" => "formulaire",
            "method" => "modifier",
            "button" => _("Modifier"),
            "permission_suffix" => "modifier",
            "condition" => array("is_suivi_retours_de_consultation, can_user_access_dossier_contexte_modification"),
            
        );

        $this->class_actions[110] = array(
            "identifier" => "suivi_mise_a_jour_des_dates",
            "view" => "view_suivi_mise_a_jour_des_dates",
            "permission_suffix" => "suivi_mise_a_jour_des_dates",
        );

        $this->class_actions[120] = array(
            "identifier" => "suivi_retours_de_consultation",
            "view" => "view_suivi_retours_de_consultation",
            "permission_suffix" => "suivi_retours_de_consultation",
        );

        // ACTION - 130 - Afficher la consultation dans les éditions
        $this->class_actions[130] = array(
            "identifier" => "afficher_dans_edition",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Afficher dans les éditions"),
                "order" => 80,
                "class" => "watch-16"
            ),
            "method" => "manage_visibilite_consultation",
            "permission_suffix" => "visibilite_dans_edition",
            "condition" => array(
                "is_not_visible",
                "can_show_or_hide_in_edition"),
        );

        // ACTION - 140 - Masquer la consultation dans les éditions
        $this->class_actions[140] = array(
            "identifier" => "masquer_dans_edition",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Masquer dans les éditions"),
                "order" => 80,
                "class" => "unwatch-16"
            ),
            "method" => "manage_visibilite_consultation",
            "permission_suffix" => "visibilite_dans_edition",
            "condition" => array(
                "is_visible",
                "can_show_or_hide_in_edition"),
        );

        // ACTION 400 - preview_edition
        // /!\ ne pas changer le numéro d'action sinon la prévisualisation
        // depuis l'onglet document ne sera plus dirigé vers la bonne action
        $this->class_actions[400] = array(
            "identifier" => "preview_edition",
            "view" => "formulaire",
            "permission_suffix" => "tab",
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "consultation",
            "dossier.dossier",
            "dossier_libelle",
            "service",
            "categorie_tiers_consulte",
            "tiers_consulte",
            "motif_consultation",
            "commentaire",
            "to_char(consultation.date_envoi ,'DD/MM/YYYY') as \"date_envoi\"",
            "to_char(consultation.date_reception ,'DD/MM/YYYY') as \"date_reception\"",
            "to_char(consultation.date_limite ,'DD/MM/YYYY') as \"date_limite\"",
            "visible",
            "motif_pec",
            "fichier_pec",
            "to_char(consultation.date_retour ,'DD/MM/YYYY') as \"date_retour\"",
            "avis_consultation",
            "motivation",
            "fichier",
            "lu",
            "code_barres",
            "om_fichier_consultation",
            "om_final_consultation",
            "marque",
            "om_fichier_consultation_dossier_final",
            "fichier_dossier_final",
            // Fieldset sépcifique au service Plat'AU
            "texte_fondement_avis",
            "texte_avis",
            "texte_hypotheses",
            "nom_auteur",
            "prenom_auteur",
            "qualite_auteur",
            "'' as live_preview",
        );
    }

    /**
     * Clause from pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__tableSelect() {
        return sprintf(
            '%1$s%2$s
                LEFT JOIN %1$sdossier
                    ON consultation.dossier = dossier.dossier',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_service_by_collectivite_from_di() {
        $inst_dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_instruction",
            "idx" => $this->getParameter('idxformulaire'),
        ));
        // Vérification du Status Plat'AU du dossier
        $condition_transmission_platau = false;
        if($inst_dossier->getVal('etat_transmission_platau') !== 'jamais_transmissible'){
            $condition_transmission_platau = true;
        }
        $where_transmission_platau = $condition_transmission_platau === false ? "AND service.service_type = 'openads'" : '';

        return "SELECT service.service, CONCAT(service.abrege, ' - ', service.libelle) FROM ".DB_PREFIXE."service LEFT JOIN ".DB_PREFIXE."om_collectivite ON service.om_collectivite = om_collectivite.om_collectivite WHERE ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE))) AND (om_collectivite.niveau = '2' OR service.om_collectivite = <collectivite_di>) ".$where_transmission_platau." ORDER BY service.abrege, service.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_service_by_id() {
        return "SELECT service.service, CONCAT(service.abrege, ' - ', service.libelle) FROM ".DB_PREFIXE."service WHERE service = '<idx>' ";
    }

    /**
     * Requête SQL servant à récupérer la liste des motifs de consultation en fonction de la
     * collectivité de l'utilisateur :
     *  - Si l'utilisateur appartiens à la collectivité de niveau 2 alors il a accès à tous les motifs.
     *  - Sinon, il a uniquement accès aux motifs liés à sa collectivité ou à la collectivité de niveau 2.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_motif_consultation() {
        // Vérifie si l'utilisateur est connecté sur la collectivité de niveau 2 et gère le filtre en fonction.
        $user_filter = '';
        if ($_SESSION['niveau'] != '2') {
            if (empty($this->f->om_utilisateur['om_collectivite'])) {
                $this->f->getUserInfos();
            }
            $user_filter = sprintf(
                '-- Garde les motifs liés à la collectivité de niveau 2 ou à la collectivité de l utilisateur
                INNER JOIN %1$slien_motif_consultation_om_collectivite
                    ON lien_motif_consultation_om_collectivite.motif_consultation = motif_consultation.motif_consultation
                INNER JOIN %1$som_collectivite
                    ON om_collectivite.om_collectivite = lien_motif_consultation_om_collectivite.om_collectivite
                        AND (om_collectivite.niveau = \'2\'
                            OR om_collectivite.om_collectivite = %2$d)',
                DB_PREFIXE,
                intval($this->f->om_utilisateur['om_collectivite'])
            );
        }

        return sprintf(
            'SELECT DISTINCT
                motif_consultation.motif_consultation,
                motif_consultation.libelle
            FROM
                %1$smotif_consultation
                %2$s
            WHERE
                ((motif_consultation.om_validite_debut IS NULL
                    AND (motif_consultation.om_validite_fin IS NULL
                        OR motif_consultation.om_validite_fin > CURRENT_DATE))
                OR (motif_consultation.om_validite_debut <= CURRENT_DATE
                    AND (motif_consultation.om_validite_fin IS NULL
                        OR motif_consultation.om_validite_fin > CURRENT_DATE)))
            ORDER BY
                motif_consultation.libelle ASC',
            DB_PREFIXE,
            $user_filter
        );
    }

    /**
     * Permet de modifier le fil d'Ariane depuis l'objet pour un formulaire
     * @param string    $ent    Fil d'Ariane récupéréré 
     * @return                  Fil d'Ariane
     */
    function getFormTitle($ent) {
        //
        if ($this->getParameter('maj') == 120) {
            //
            return _("suivi")." -> "._("demandes d'avis")." -> "._("retours de consultation");
        }
        //
        if ($this->getParameter('maj') == 110) {
            //
            return _("suivi")." -> "._("demandes d'avis")." -> "._("mise a jour des dates");
        }
        //
        if ($this->getParameter('maj') == 100) {
            //
            return _("suivi")." -> "._("demandes d'avis")." -> "._("retours de consultation")." -> ".$this->getVal($this->clePrimaire);
        }
        //
        return $ent;
    }


    /**
     * Ce script permet de gérer l'interface de saisie rapide des retours de
     * consultation par la cellule suivi l'aide d'un code barre.
     */
    function view_suivi_retours_de_consultation() {
        //
        $this->checkAccessibility();
        /**
         * Validation du formulaire
         */
        // Si le formulaire a été validé
        if ($this->f->get_submitted_post_value('code_barres') !== null) {
            // Si la valeur transmise est correcte
            if ($this->f->get_submitted_post_value('code_barres') != ""
                && is_numeric($this->f->get_submitted_post_value('code_barres'))) {
                // Vérification de l'existence de la consultation
                $qres = $this->f->get_all_results_from_db_query(
                    sprintf(
                        'SELECT
                            consultation
                        FROM
                            %sconsultation
                        WHERE
                            code_barres = \'%s\'',
                        DB_PREFIXE,
                        $this->f->db->escapesimple($this->f->get_submitted_post_value('code_barres'))
                    ),
                    array(
                        "origin" => __METHOD__,
                    )
                );
                // En fonction du nombre de consultations correspondantes
                // on affiche un message d"erreur ou on redirige vers le formulaire de
                // saisie du retour
                if ($qres['row_count'] == 0) {
                    // Si
                    $message_class = "error";
                    $message = _("Ce code barres de consultation n'existe pas.");
                } elseif ($qres['row_count'] > 1) {
                    // Si
                    $message_class = "error";
                    $message = _("Plusieurs consultations avec ce code barres.");
                } else {
                    $row = array_shift($qres['result']);
                    header("Location: ".OM_ROUTE_FORM."&obj=consultation&action=100&retour=suivi_retours_de_consultation&idx=".$row['consultation']);
                }
            } elseif ($this->f->get_submitted_post_value('code_barres')!==null && $this->f->get_submitted_post_value('code_barres') == "") {
                // Si aucune valeur n'a été saisie dans le champs consultation
                $message_class = "error";
                $message = _("Veuiller saisir un code barres de consultation.");
            } else {
                // Si
                $message_class = "error";
                $message = _("Cette consultation n'existe pas.");
            }
        }

        /**
         * Affichage des messages et du formulaire
         */
        // Affichage du message de validation ou d'erreur
        if (isset($message) && isset($message_class) && $message != "") {
            $this->f->displayMessage($message_class, $message);
        }
        //
        $datasubmit = $this->getDataSubmit();
        // Ouverture du formulaire
        echo "\t<form";
        echo " method=\"post\"";
        echo " id=\"suivi_retours_de_consultation_form\"";
        echo " action=\"".$datasubmit."\"";
        echo ">\n";
        // Paramétrage des champs du formulaire
        $champs = array("code_barres");
        // Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        // Paramétrage des champs du formulaire
        $form->setLib("code_barres", _("No de code barres de consultation"));
        $form->setType("code_barres", "text");
        $form->setTaille("code_barres", 25);
        $form->setMax("code_barres", 25);
        // Affichage du formulaire
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        // Affichage du bouton
        echo "\t<div class=\"formControls\">\n";
        $this->f->layout->display_form_button(array("value" => _("Valider")));
        echo "\t</div>\n";
        // Fermeture du formulaire
        echo "\t</form>\n";
    }

    /**
     * Ce script permet de mettre à jour les dates de suivi du traitement
     * des consultations.
     */
    function view_suivi_mise_a_jour_des_dates() {
        //
        $this->checkAccessibility();

        // Récupération des valeur passées en POST ou GET
        $date = "";
        if($this->f->get_submitted_post_value('date') !== null) {
            $date = $this->f->get_submitted_post_value('date');
        } elseif($this->f->get_submitted_get_value('date') !== null) {
            $date = $this->f->get_submitted_get_value('date');
        }
        $code_barres = "";
        if($this->f->get_submitted_post_value('code_barres') !== null) {
            $code_barres = $this->f->get_submitted_post_value('code_barres');
        } elseif($this->f->get_submitted_get_value('code_barres')!==null) {
            $code_barres = $this->f->get_submitted_get_value('code_barres');
        }

        // Booléen permettant de définir si un enregistrement à eu lieu
        $correct = false;
        // Booléen permettant de définir si les dates peuvent êtres enregistrées
        $date_error = false;

        // Si le formulaire a été validé
        if ($this->f->get_submitted_post_value('validation') !== null) {
            //Tous les champs doivent obligatoirement être remplis
            if ( !empty($date) && !empty($code_barres) ){
                
                //Vérification de l'existence de la consultation
                $qres = $this->f->get_all_results_from_db_query(
                    sprintf(
                        'SELECT
                            consultation,
                            type_consultation
                        FROM
                            %1$sconsultation
                            LEFT JOIN %1$sservice
                                ON service.service = consultation.service
                        WHERE
                            code_barres = \'%2$s\'',
                        DB_PREFIXE,
                        $this->f->db->escapesimple($code_barres)
                    ),
                    array(
                        "origin" => __METHOD__,
                    )
                );
                
                //Si le code barres est correct
                if($qres['row_count'] == 1) {
                    
                    //Un retour de demande d'avis ne peut être saisie que si le type de 
                    //consultation est "avec_avis_attendu"
                    $row = array_shift($qres['result']);
                    if ( strcasecmp($row['type_consultation'], "avec_avis_attendu") === 0 ){
                        
                        //On met à jour la date après l'écran de vérification
                        if($this->f->get_submitted_post_value("is_valid") != null and $this->f->get_submitted_post_value("is_valid") == "true") {
                            $consultation = $this->f->get_inst__om_dbform(array(
                                "obj" => "consultation",
                                "idx" => $row['consultation'],
                            ));
                            $consultation->setParameter("maj", 1);
                            $valF = array();
                            foreach($consultation->champs as $id => $champ) {
                                $valF[$champ] = $consultation->val[$id];
                            }
                            
                            $valF['date_reception']=$date;

                            $consultation->modifier($valF);
                            // Vérification de la finalisation du document
                            // correspondant au code barres
                            if($consultation->valF["om_final_consultation"] === true) {
                                $message_class = "valid";
                                $message = _("Saisie enregistree");
                                $code_barres = "";
                            } else {
                                //
                                $message_class = "error";
                                $message = sprintf(_("Le document correspondant au 
                                    code barres %s n'est pas finalise, 
                                    la date ne sera pas mise a jour."),
                                    $code_barres);
                            }
                            
                        }
                        //Sinon on récupère les infos du dossier pour les afficher
                        else {
                            // Récupération des infos du dossier
                            $qres = $this->f->get_all_results_from_db_query(
                                sprintf(
                                    'SELECT
                                        dossier_libelle,
                                        libelle, 
                                        date_reception,
                                        TO_CHAR(date_envoi, \'DD/MM/YYYY\') AS date_envoi
                                    FROM
                                        %1$sconsultation
                                        LEFT JOIN %1$sdossier 
                                            ON dossier.dossier = consultation.dossier
                                        LEFT JOIN %1$sservice
                                            ON service.service = consultation.service
                                    WHERE
                                        code_barres = \'%2$s\'',
                                    DB_PREFIXE,
                                    $this->f->db->escapesimple($code_barres)
                                ),
                                array(
                                    "origin" => __METHOD__,
                                )
                            );
                            $infos = array_shift($qres['result']);
                        }
                    }
                    //C'est un autre type de consultation
                    else{
                        $message_class = "error";
                        $message = _("Cette consultation n'a pas d'avis attendu.");
                    }
                }
                else {
                    $message_class = "error";
                    $message = _("Le numero saisi ne correspond a aucun code barres de consultation.");
                }
            } else {
                $message_class = "error";
                $message = _("Tous les champs doivent etre remplis.");
            }
        }

        /**
         * Affichage des messages et du formulaire
         */
        // Affichage du message de validation ou d'erreur
        if (isset($message) && isset($message_class) && $message != "") {
            $this->f->displayMessage($message_class, $message);
        }
        //
        $datasubmit = $this->getDataSubmit();
        // Ouverture du formulaire
        printf("\t<form");
        printf(" method=\"post\"");
        printf(" id=\"demandes_avis_mise_a_jour_des_dates_form\"");
        printf(" action=\"".$datasubmit."\"");
        printf(">\n");
        // Paramétrage des champs du formulaire
        $champs = array("date", "code_barres");
        if (isset($infos)) {
            array_push(
                $champs,
                "dossier_libelle",
                "service",
                "date_envoi",
                "date_reception",
                "is_valid"
            );
        }
        // Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        // Paramétrage des champs du formulaire
        // Parametrage du champ date
        $form->setLib("date", _("Date")."* :");
        if (isset($infos)) {
            $form->setType("date", "hiddenstaticdate");
        } else {
            $form->setType("date", "date");
        }
        $form->setVal("date", $date);
        $form->setTaille("date", 10);
        $form->setMax("date", 10);

        // Parametrage du champ code_barres
        $form->setLib("code_barres", _("Code barres de consultation")."* :");
        if (isset($infos)) {
            $form->setType("code_barres", "hiddenstatic");
        } else {
            $form->setType("code_barres", "text");
        }
        $form->setVal("code_barres", $code_barres);
        $form->setTaille("code_barres", 20);
        $form->setMax("code_barres", 20);

        // Ajout des infos du dossier correspondantes à la consultation séléctionnée
        if (isset($infos)) {

            // Tous les champs sont défini par defaut à static
            foreach ($infos as $key => $value) {
                $form->setType($key, "static");
                $form->setVal($key, $value);
            }

            // Les champs dont on vient de définir la valeur sont en gras
            $form->setBloc("date_reception", 'DF', "", 'bold');

            // Parametrage du champ dossier
            $form->setLib("dossier_libelle", _("dossier_libelle")." :");
            $form->setType("dossier_libelle", "static");
            $form->setVal("dossier_libelle", $infos['dossier_libelle']);

            // Parametrage du champ service
            $form->setLib("service", _("service")." :");
            $form->setType("service", "static");
            $form->setVal("service", $infos['libelle']);

            // Parametrage des libellés d'envoi avec RAR
            $form->setLib("date_envoi", _("Envoi demande d'avis")." :");
            $form->setLib("date_reception", _("Retour demande d'avis")." :");
            $form->setVal("date_reception", $date);

            // Ajout d'un champ hidden permettant de savoir que le formulaire précédant est celui de vérification
            $form->setLib("is_valid", _("Valide")." :");
            $form->setType("is_valid", "hidden");
            $form->setVal("is_valid", 'true');

            $form->setFieldset('dossier_libelle', 'D', _('Synthese'));
            $form->setFieldset('is_valid', 'F');
        }


        // Création du fieldset regroupant les champs permettant la mise à jour des date
        $form->setFieldset('date', 'D', _('Mise a jour'));
        $form->setFieldset('code_barres', 'F');
        // Affichage du formulaire
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        // Affichage du bouton
        printf("\t<div class=\"formControls\">\n");
        //
        if (!$date_error) {
            $this->f->layout->display_form_button(
                array("value" => _("Valider"), "name" => "validation")
            );
        }
        // Si pas sur l'écran de validation
        if (isset($infos)) {
            printf(
                '<a class="retour" href="%s&amp;date=%s&amp;code_barres=%s">Retour</a>',
                $datasubmit,
                $date,
                $code_barres
            );
        }
        printf("\t</div>\n");
        // Fermeture du formulaire
        printf("\t</form>\n");

    }


    /**
     * Défini si l'utilisateur est de la cellule suivi.
     *
     * @return boolean true si correspond false sinon
     */
    function is_suivi_retours_de_consultation() {
        
        if($this->f->can_bypass("consultation", "modifier")){
            return true;
        }
        
        return $this->f->isAccredited("consultation_suivi_retours_de_consultation");
    }

    /**
     * Si le champ lu est à true l'action "Marquer comme lu" n'est pas affichée
     *
     * @return boolean true sinon lu false sinon
     */
    function show_marquer_comme_lu_portlet_action() {
        if (isset($this->val[array_search("lu", $this->champs)])
            && $this->val[array_search("lu", $this->champs)]== "t") {
            return false;
        }
        return true;
    }

    /**
     * Si le champ lu est à false l'action "Marquer comme non lu" n'est pas affichée
     *
     * @return boolean true sinon lu false sinon
     */
    function show_marquer_comme_non_lu_portlet_action() {
        if (isset($this->val[array_search("lu", $this->champs)])
            && $this->val[array_search("lu", $this->champs)]== "f") {
            return false;
        }
        return true;
    }

    /**
     * Si le document est finalisé l'action "finaliser" n'est pas affichée
     *
     * @return boolean true sinon lu false sinon
     */
    function show_consultation_finaliser_portlet_action() {
        if ($this->is_document_finalized("om_final_consultation")) {
            return false;
        }
        return true;
    }

    /**
     * Retourne is_document_finalized("om_final_consultation")
     *
     * @return boolean true si finalisé false sinon
     */
    function show_unfinalize_portlet_action() {
        return $this->is_document_finalized("om_final_consultation");
    }

    /**
     * Permet de savoir si le document passé en paramètre est finalisé
     *
     * @param string $field flag finalisé
     *
     * @return boolean true si finalisé false sinon
     */
    function is_document_finalized($field) {
        if($this->getVal($field) == 't') {
            return true;
        }
        return false;
    }


    /**
     *
     */
    var $inst_service = null;

    /**
     *
     */
    var $inst_tiers_consulte = null;

    /**
     *
     */
    function get_inst_service($service = null) {
        //
        if ($service !== null) {
            return $this->f->get_inst__om_dbform(array(
                "obj" => "service",
                "idx" => $service,
            ));
        }
        //
        if (isset($this->inst_service) === false or
            $this->inst_service === null) {
            $this->inst_service = $this->f->get_inst__om_dbform(array(
                "obj" => "service",
                "idx" => $this->getVal('service'),
            ));
        }
        return $this->inst_service;
    }

    /**
     *
     */
    protected function get_instance_objet_liee($cible, $idCible = null) {
        // Récupère l'instance de l'élement cible
        if ($idCible !== null) {
            return $this->f->get_inst__om_dbform(array(
                "obj" => $cible,
                "idx" => $idCible
            ));
        }
        //
        $nomVarInstance = "inst_".$cible;
        if (isset($this->$nomVarInstance) === false or
            $this->$nomVarInstance === null) {
            $this->$nomVarInstance = $this->f->get_inst__om_dbform(array(
                "obj" => $cible,
                "idx" => $this->getVal($cible)
            ));
        }

        return $this->$nomVarInstance;
    }

    /**
     * TREATMENT - marquer_comme_lu.
     * 
     * Cette methode permet de passer la consultation en "lu"
     *
     * @return boolean true si maj effectué false sinon
     */
    function marquer_comme_lu() {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        if($this->getVal("lu") == 'f') {
            $this->correct = true;
            $valF = array();
            $valF["lu"] = true;

            $res = $this->f->db->autoExecute(
                DB_PREFIXE.$this->table, 
                $valF, 
                DB_AUTOQUERY_UPDATE,
                $this->clePrimaire."=".$this->getVal($this->clePrimaire)
            );
            if ($this->f->isDatabaseError($res, true)) {
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
                $this->correct = false;
                // Termine le traitement
                return $this->end_treatment(__METHOD__, false);
            } else {
                $this->addToMessage(__("La consultation a été marquée comme lu."));
                return $this->end_treatment(__METHOD__, true);
            }

        } else {
            $this->addToMessage(__("La consultation est déjà marquée comme lu."));
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, false);
    }

    /**
     * TREATMENT - marquer_comme_non_lu.
     * 
     * Cette methode permet de passer la message en "non lu"
     *
     * @return boolean true si maj effectué false sinon
     */
    public function marquer_comme_non_lu() {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        if($this->getVal("lu") == 't') {
            $this->correct = true;
            $valF = array();
            $valF["lu"] = false;

            $res = $this->f->db->autoExecute(
                DB_PREFIXE.$this->table, 
                $valF, 
                DB_AUTOQUERY_UPDATE,
                $this->clePrimaire."=".$this->getVal($this->clePrimaire)
            );
            if ($this->f->isDatabaseError($res, true)) {
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
                $this->correct = false;
                // Termine le traitement
                return $this->end_treatment(__METHOD__, false);
            } else {
                $this->addToMessage(__("La consultation a été marquée comme non lu."));
                return $this->end_treatment(__METHOD__, true);
            }

        } else {
            $this->addToMessage(__("La consultation est déjà marquée comme non lu."));
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, false);
    }

    // }}}

    /**
     * TREATMENT - ajouter_multiple.
     * 
     * Cette methode permet d'ajouter plusieurs consultations.
     *
     * @return boolean true si ajouts effectués false sinon
     */
    function ajouter_multiple() {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        // Identifiant de l'objet metier a copier
        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $idx = $this->f->get_submitted_get_value('idxformulaire') : $idx = "");
        // Nom de l'objet metier
        ($this->f->get_submitted_get_value('obj') !== null ? $obj = $this->f->get_submitted_get_value('obj') : $obj = "");
        //formulaire retour
        ($this->f->get_submitted_get_value('ret') !== null ? $retourformulaire = $this->f->get_submitted_get_value('ret') : $retourformulaire = "");
        ($this->f->get_submitted_get_value('date_envoi') !== null ? $date_envoi = $this->f->get_submitted_get_value('date_envoi') : $date_envoi = "");
        /*Récupération des données et formatage.*/
        $donnees_temp = explode(';', $this->f->get_submitted_get_value('data'));
        for ( $i = 1 ; $i < count($donnees_temp) ; $i++ )
            $donnees[] = explode('_', $donnees_temp[$i]);
        /* Nombre de consultations papier à générer */
        $nbConsPap = 0;
        
        /* Ajout des données en base de données 
         * 0 : l'ID du service
         * 1 : consultation papier {0,1}
         * */
        if ( isset($donnees) && count($donnees) > 0 ) {
            
            foreach ($donnees as $value) {
                
                $qres = $this->f->get_all_results_from_db_query(
                    sprintf(
                        'SELECT
                            delai,
                            id,
                            delai_type
                        FROM
                            %1$sservice 
                            LEFT JOIN %1$som_etat
                                ON service.edition = om_etat.om_etat
                        WHERE
                            service = %2$s',
                        DB_PREFIXE,
                        $this->f->db->escapesimple($value[0])
                    ),
                    array(
                        "origin" => __METHOD__,
                        "force_return" => true,
                        "mode" => DB_FETCHMODE_ORDERED
                    )
                );
                // Si la récupération de la description de l'avis échoue
                if ($qres['result'] !== "OK") {
                    // Appel de la methode de recuperation des erreurs
                    $this->erreur_db($qres['message'], $qres['message'], '');
                    $this->correct = false;
                    // Termine le traitement
                    $this->end_treatment(__METHOD__, false);
                }
                $row = array_shift($qres['result']);
                $delai = $row[0];
                $type_edition = $row[1];
                $delai_type = $row[2];

                /*Calcul du delai de retour*/
                $date_envoi_temp = $this->datePHP($date_envoi);
                $delai = $this->dateDB($this->f->mois_date($date_envoi_temp, $delai, "+", $delai_type));

                /*Les données à ajouter*/
                // Initialisation de tous les champs a null
                foreach ($this->champs as $champs) {
                    $arrayVal[$champs] = null;
                }
                // Set les valeurs des champs
                $arrayVal = array_replace($arrayVal, array(
                    'consultation' => "]",
                    'dossier' => $idx,
                    'date_envoi' => $date_envoi,
                    'date_limite' => $delai,
                    'service' => $value[0],
                    'motivation' => "",
                    'om_final_consultation' => false,
                    'om_fichier_consultation' => '',
                    'om_fichier_consultation_dossier_final' => false,
                    'fichier_dossier_final' => false,
                    'marque' => false,
                    'visible' => true,
                ));
                $res_ajout = $this->ajouter($arrayVal);
                if($res_ajout != true) {
                    // Termine le traitement
                    $this->end_treatment(__METHOD__, false);
                }

                /*Comptage du nombre de consultations papier demandées et récupération des ids des PDFs à éditer*/
                if ($value[1]==1){
                    $idxConsultations[] = $this->valF['consultation'];
                    $objConsultations[] = $type_edition;
                    $nbConsPap++;
                }
            }

            /*Génération du PDF*/
            if (isset($idxConsultations) && count($idxConsultations) > 0 ){

                // Stockage de l'identifiant de chaque consultation dont on veut éditer la
                // version papier, séparés par un point-virgule
                $textIdsConsultations = "";
                foreach ($idxConsultations as $value) {
                    if ($textIdsConsultations != "") {
                            $textIdsConsultations .= ";"; 
                    }
                    $textIdsConsultations .= $value; 
                }
                // Stockage de l'objet de chaque consultation dont on veut éditer la
                // version papier, séparés par un point-virgule
                $textObjConsultations = "";
                foreach ($objConsultations as $value) {
                    if ($textObjConsultations != "") {
                        $textObjConsultations .= ";";
                    }
                    $textObjConsultations .= $value;
                }

                // Ouverture du PDF dans une nouvelle fenêtre
                printf("
                    <script language='javascript' type='text/javascript'>
                        window.open('%s','_blank')
                    </script>
                    ",
                    OM_ROUTE_FORM."&obj=consultation&action=90&idx=0&dossier_instruction=".$this->getVal('dossier')."&textobj=".$textObjConsultations."&"."textids=".$textIdsConsultations
                );
            }
            $return_url = OM_ROUTE_SOUSTAB;
            $return_url .= "&obj=consultation";
            $return_url .= "&retourformulaire=".$this->getParameter("retourformulaire");
            $return_url .= "&idxformulaire=".$this->getParameter("idxformulaire");
            $return_url .= "&premier=".$this->getParameter("premiersf");
            $return_url .= "&tricol=".$this->getParameter("tricolsf");

            /*Affichage du message d'information*/
            $this->f->displayMessage("valid", count($donnees)._(' service(s) selectionne(s) dont ').$nbConsPap._(' consultation(s) papier.'));


            // Termine le traitement
            return $this->end_treatment(__METHOD__, true);
        }
    }


    /**
     * VIEW - view_ajout_multiple.
     *
     * Formulaire specifique
     * 
     * @return void
     */
    function view_ajout_multiple() {
        
        if (count($this->f->get_submitted_get_value()) > 0 
        && $this->f->get_submitted_get_value('data') !== null
        && $this->f->get_submitted_get_value('data') != "" ) {
            $this->f->disableLog();
            $this->ajouter_multiple();

        } else {

            // Vérification de l'accessibilité sur l'élément
            $this->checkAccessibility();
            //
            $datasubmit = $this->getDataSubmitSousForm();
            $return_url = OM_ROUTE_SOUSTAB;
            $return_url .= "&obj=consultation";
            $return_url .= "&retourformulaire=".$this->getParameter("retourformulaire");
            $return_url .= "&idxformulaire=".$this->getParameter("idxformulaire");
            $return_url .= "&premier=".$this->getParameter("premiersf");
            $return_url .= "&tricol=".$this->getParameter("tricolsf");
            // Légende du fieldset
            $title = _("Objet");
            /*Requête qui récupère les services qui sont dans des thématiques*/
            // Si c'est un sous-formulaire de dossier d'instruction ou une de ses surcharges
            // mes encours, mes clôtures...
            $is_in_context_of_foreign_key = $this->is_in_context_of_foreign_key("dossier", $this->getParameter('retourformulaire'));
            $sql_foreign_key = '';
            if ($is_in_context_of_foreign_key == true) {

                // on recupère les services des multicollectivités et de celle
                // du DI
                $di = $this->f->get_inst__om_dbform(array(
                    "obj" => "dossier_instruction",
                    "idx" => $this->getParameter('idxformulaire'),
                ));

                //
                $sql_foreign_key .= sprintf(" AND (om_collectivite.niveau = '2' OR ser.om_collectivite = %s) ", $di->getVal('om_collectivite'));
            }

            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        ser_cat.service_categorie,
                        ser_cat.libelle AS them_lib,
                        ser.service,
                        CONCAT(ser.abrege, \' - \', ser.libelle) AS ser_lib,
                        ser.consultation_papier
                    FROM
                        %1$slien_service_service_categorie lie,
                        %1$sservice_categorie ser_cat,
                        %1$sservice ser
                        LEFT JOIN %1$som_collectivite
                            ON ser.om_collectivite = om_collectivite.om_collectivite
                    WHERE
                        ser_cat.service_categorie = lie.service_categorie
                        AND ser.service = lie.service
                        AND ((ser.om_validite_debut IS NULL
                            AND (ser.om_validite_fin IS NULL
                                OR ser.om_validite_fin > CURRENT_DATE))
                        OR (ser.om_validite_debut <= CURRENT_DATE
                            AND (ser.om_validite_fin IS NULL
                                OR ser.om_validite_fin > CURRENT_DATE)))
                    %2$s
                    %3$s
                    ORDER BY
                        them_lib,
                        ser.abrege,
                        ser.libelle',
                    DB_PREFIXE,
                    $sql_foreign_key,
                    $di->getVal("etat_transmission_platau") == "jamais_transmissible" ?
                        " AND ser.service_type = 'openads'" :
                        ''
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            
            $temp_ser_cat = 0;
            $liste_gauche = "";

            foreach ($qres['result'] as $row) {
                $name = $row['service_categorie'].'_'.
                        $row['service'].'_'.
                        (($row['consultation_papier'] == '' || $row['consultation_papier'] == 'f' ) ? '0' : '1' ).'_';
                // On change de thématique, donc rajoute le nom de la thématique
                if ( $temp_ser_cat != $row['service_categorie'] ){
                    
                    $temp_ser_cat = $row['service_categorie'];
                    $liste_gauche .= '
                    <div id="them_'.$row['service_categorie'].'" class="liste_gauche_them" >'.
                        $row['them_lib'].
                    '</div>
                        <div 
                            class="liste_gauche_service t'.$name.'" 
                            id="t'.$name.'" >
                            '.$row['ser_lib'].'
                            <input class="t'.$name.'" type="checkbox" '.(($row['consultation_papier'] == '' || $row['consultation_papier'] == 'f' ) ? '' : 'checked="checked"' ).'/>
                        </div>
                    ';
                }
                
                /*On est dans la même thématique*/
                else {
                    
                    $liste_gauche .= '
                        <div 
                            class="liste_gauche_service t'.$name.'" 
                            id="t'.$name.'" >
                            '.$row['ser_lib'].'
                            <input class="t'.$name.'" type="checkbox" '.(($row['consultation_papier'] == '' || $row['consultation_papier'] == 'f' ) ? '' : 'checked="checked"' ).'/>
                        </div>
                    ';
                }
                
            }
            
            /*Requête qui récupère les services qui ne sont pas dans une thématique*/
            // Si c'est un sous-formulaire de dossier d'instruction ou une de ses surcharges
            // mes encours, mes clôtures...
            $is_in_context_of_foreign_key = $this->is_in_context_of_foreign_key("dossier", $this->getParameter('retourformulaire'));
            $sql_foreign_key = '';
            if ($is_in_context_of_foreign_key == true) {

                // on recupère les services des multicollectivités et de celle
                // du DI
                $di = $this->f->get_inst__om_dbform(array(
                    "obj" => "dossier_instruction",
                    "idx" => $this->getParameter('idxformulaire'),
                ));

                //
                $sql_foreign_key = sprintf(
                    " AND (om_collectivite.niveau = '2' OR service.om_collectivite = %s) ",
                    $this->f->db->escapeSimple($di->getVal('om_collectivite'))
                );
            }

            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        service.service,
                        CONCAT(service.abrege, \' - \', service.libelle) AS ser_lib,
                        service.consultation_papier
                    FROM
                        %1$sservice
                        LEFT JOIN %1$som_collectivite
                            ON service.om_collectivite = om_collectivite.om_collectivite
                    WHERE
                        service NOT IN ( 
                            SELECT service
                            FROM %1$slien_service_service_categorie
                        ) AND ( 
                            om_validite_fin <= CURRENT_DATE OR 
                            om_validite_fin IS NULL 
                        )
                    %2$s
                    -- Tri des services qui ne sont pas dans une thématique par ordre alphabétique
                    ORDER BY
                        service.abrege,
                        service.libelle',
                    DB_PREFIXE,
                    $sql_foreign_key
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            
            if ($qres['row_count'] > 0) {
                $liste_gauche .= '
                    <div id="them_0" class="liste_gauche_them">Autres</div>';
            }
            
            foreach ($qres['result'] as $row) {
                /*Ajout de tous les services qui n'ont pas de thématique*/
                $name = '0_'. 
                        $row['service'].'_'.
                        (($row['consultation_papier'] == '' || $row['consultation_papier'] == 'f'  ) ? '0' : '1' ).'_';
                $liste_gauche .= '
                    <div 
                        class="liste_gauche_service t'.$name.'" 
                        id="t'.$name.'" >
                        '.$row['ser_lib'].'&nbsp;
                        <input class="t'.$name.'" type="checkbox" '.(($row['consultation_papier'] == '' || $row['consultation_papier'] == 'f' ) ? '' : 'checked="checked"' ).'/>
                    </div>
                ';
            }
            
            /*Affichage du formulaire*/
            echo "\n<!-- ########## START DBFORM ########## -->\n";
            echo "<form";
            echo " method=\"post\"";
            echo " name=\"f2\"";
            echo " action=\"\"";
            echo " id=\"form_val\"";
            //echo " onsubmit=\"ajaxIt('consultation', '');return false;\"";

            //echo " onsubmit=\"affichersform('".$this->getParameter("objsf")."', '".$datasubmit."', this);\"";
            echo ">\n";
                echo '<div class="formEntete ui-corner-all">';
                    echo "<div>";
                        echo '<div class="bloc">';
                            echo "<fieldset class='cadre ui-corner-all ui-widget-content'>\n";
                                echo "\t<legend class='ui-corner-all ui-widget-content ui-state-active'>".
                                    _("Consultation par thematique ")."</legend>";
                                echo "<div class='fieldsetContent' style='width:100%'>";
                                    echo '<div class="field-ser-them field-type-hiddenstatic">';
                                        echo '<div class="form-libelle">';
                                            echo '<label class="libelle-dossier" for="dossier">';
                                                echo _('dossier');
                                            echo '<span class="not-null-tag">*</span>';
                                            echo '</label>';
                                        echo '</div>';
                                        echo '<div class="form-content">';
                                            echo '<input class="champFormulaire" type="hidden" value="'.$this->getParameter("idxformulaire").'" name="dossier"/>';
                                            echo $this->getParameter("idxformulaire");
                                        echo '</div>';
                                    echo '</div>';
                                    /*Code du nouveau champ*/
                                    echo '<div class="field-ser-them ser-them">';
                                        echo '<div class="list-ser-them">';
                                            echo $liste_gauche;
                                        echo '</div>';
                                        echo '<div class="button-ser-them">';
                                            echo '<ul>';
                                                echo '<li>';
                                                    echo '<input type="button" value="'._("Ajouter").' >>" id="add-ser-them"/>';
                                                echo '</li>';
                                                echo '<li>';
                                                    echo '<input type="button" value="<< '._("Supprimer").'" id="del-ser-them"/>';
                                                echo '</li>';
                                            echo '</ul>';
                                        echo '</div>';
                                        echo '<div class="list-sel-ser-them">';
                                            echo '<div class=\'row row_title\'>';
                                                echo '<div class=\'cell1 liste_droite_title list-sel-ser-them-title\'>'._('Service a consulter').'</div>';
                                                echo '<div class=\'cell2 liste_droite_title list-sel-ser-them-title\'>'._('Version papier').'</div>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                    /* -- FIN --*/
                                    // Le champ de date d'envoi est visible seulement aux ayant-droits
                                    if($this->f->isAccredited('consultation_saisir_date_envoi')) {
                                        echo '<div class="field-ser-them field-type-date2">';
                                    }
                                    else {
                                        echo '<div class="field field-type-hiddendate">';
                                    }
                                        echo '<div  class="form-libelle">';
                                            echo '<label class="libelle-date_envoi" for="date_envoi">';
                                                echo _('date_envoi');
                                                echo '<span class="not-null-tag">*</span>';
                                            echo '</label>';
                                        echo '</div>';
                                        echo '<div class="form-content">';
                                            echo '<input id="date_envoi" class="champFormulaire datepicker" 
                                                  type="text"  onkeyup="" onchange="fdate(this);" 
                                                  maxlength="10" size="12" value="'.date("d/m/Y").'" 
                                                   name="date_envoi">';
                                        echo '</div>';
                                    echo '</div>';
                                echo "</div>";
                            echo "</fieldset>";
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
                echo '<div class="formControls">';

                echo '<div class="formControls">';
                        echo "<input class=\"om-button ui-button ui-widget ui-state-default ui-corner-all\" 
                              type=\"button\" 
                              
                              value=\"Ajouter le(s) enregistrement(s) de la table : 'Consultation'\" 
                              id=\"button_val\">";
                $this->retoursousformulaire(
                    $this->getParameter("idxformulaire"),
                    $this->getParameter("retourformulaire"),
                    null,
                    $this->getParameter("objsf"),
                    $this->getParameter("premiersf"),
                    $this->getParameter("tricolsf"),
                    $this->getParameter("validation"),
                    $this->getParameter("idx"),
                    $this->getParameter("maj"),
                    $this->getParameter("retour")
                );
                    echo '</div>';
                echo '</div>';
            echo '</form>';
            
            echo "
            <script language='javascript' type='text/javascript'>
                $(function(){
                    changeActionVal('');
                    /*
                        Sélectionne tous les services d'un thème au clique sur celui ci.
                    */
                    $('.liste_gauche_them').click(
                        function(){
                            
                            var id = $(this).attr('id').split('_')[1];
                            var numSer = 0;
                            var numSerWithClass = 0;
                            
                            $('.list-ser-them div').each(
                                function() {
                                            
                                    if ( $(this).attr('id').indexOf('them') == -1 &&
                                         $(this).attr('id').indexOf(id) == 1  &&
                                         $(this).hasClass('liste_gauche_service_selected') )
                                         
                                         numSerWithClass++;
                                    
                                    if ( $(this).attr('id').indexOf('them') == -1 &&
                                         $(this).attr('id').indexOf(id) == 1  )
                                         
                                        numSer++;
                                }
                            );
                            
                            if ( numSerWithClass < numSer && numSerWithClass >= 0 ){
                            
                                 $('.list-ser-them div').each(
                                    function() {
                                        
                                        if ( $(this).attr('id').indexOf('them') == -1 &&
                                         $(this).attr('id').indexOf(id) == 1 &&
                                         !$(this).hasClass('liste_gauche_service_selected') )
                                         
                                            $(this).addClass('liste_gauche_service_selected');
                                    }
                                );
                            }
                            
                            else {
                                
                                $('.list-ser-them div').each(
                                    function() {
                                        
                                       if ( $(this).attr('id').indexOf('them') == -1 &&
                                        $(this).attr('id').indexOf(id) == 1  &&
                                        $(this).hasClass('liste_gauche_service_selected') )
                                         
                                           $(this).removeClass('liste_gauche_service_selected');
                                    }
                               );
                            }
                        }
                    );
                    
                    /*
                        Change la class CSS d'un service sur lequel on clique dans la liste de gauche.
                    */
                    $('.liste_gauche_service').click(
                        function(){
                            $(this).toggleClass('liste_gauche_service_selected');
                        }
                    );
                    
                    /*
                        Change la class CSS d'un service sur lequel on clique dans la liste de droite.
                    */
                    $('.field-ser-them').on( 
                        'click',
                        '.cell1',
                        function(){
                            if ( !$(this).hasClass('liste_droite_title') )
                                $(this).parent().toggleClass('liste_droite_service_selected');
                        }
                    );
                    
                    $('.liste_droite_service input[type=checkbox]').live( 
                        'click',
                        'input[type=checkbox]',
                        function(){

                            old_id = $(this).attr('class');
                            
                            tab_don = old_id.split('_');
                            
                            new_id = tab_don[0] + '_' + tab_don[1] + '_' + ((tab_don[2] == 0 ) ? 1 : 0 ) + '_';

                            changeOneData( ';' + tab_don[1] + '_' + tab_don[2], ';' + tab_don[1] + '_' + ((tab_don[2] == 0) ? 1 : 0) );
                            $('div[class=\"' + old_id + '\"]').attr('class', new_id);
                            $(this).attr('class', new_id);

                        }
                    );
                    
                    $('#date_envoi').change(
                        function (){
                            
                            var listServ = new Array();
                            var data = '';
                    
                            $('.liste_gauche_service_selected').each(
                                function(i) {
                                    
                                    var id = $(this).attr('id');
                                    
                                    if ( listServ.length > 0 && listServ.indexOf(id.split('_')[1]) != -1 )
                                        return;
                                    listServ[i] = id.split('_')[1];
                                    data += ';' + id.split('_')[1] + '_' + id.split('_')[2] ;
                                    
                                }
                            );
                            
                            changeActionVal(data);
                        }
                    );
                    
                    /*
                        Passe les services sélectionnés dans la liste de gauche dans celle de droite.
                    */
                    $('#add-ser-them').click(
                        function() {
                            
                            changeDataLeftColumn();
                        }
                    );    
                    
                    /*
                        Passe les services sélectionnés dans la liste de droite dans celle de gauche.
                    */
                    $('#del-ser-them').click(
                        function() {
                            
                            var data = '';
                            
                            //Supprime les éléments de la liste de droite
                            $('.liste_droite_service_selected').each(
                                function() {

                                    var name = $('#'+ $(this).attr('id') + ' .cell1 div').attr('name');
                                    
                                    manageListServ('.list-ser-them div', name, 1);
                                    
                                    $(this).remove();
                                }
                            );
                            
                            //Change les valeurs qui vont être renvoyées à la validation du formulaire
                            $('.liste_droite_service').each(
                                function(){
                                    
                                    var name = $('#'+ $(this).attr('id') + ' .cell1 div').attr('name');
                                    data += ';' + name.split('_')[1] + '_' + name.split('_')[2] ;
                                }
                            );
                            
                            changeActionVal(data);
                        }
                    );
                });
                
                /*
                    Vérifie que l'objet n'est pas une thématique et que son identifiant correspond.
                */
                function isNotthemIsOneServ( objet, id ){
                    return ( $(objet).attr('id').indexOf('them') == -1 && 
                             $(objet).attr('id').indexOf('_' + id.split('_')[1] + '_') != -1 );
                }
                
                /*
                    Affiche ou cache un élément qui n'est pas une thématique et dont son identifiant correspond.
                */
                function manageListServ( objet , name, type){
        
                    $(objet).each(
                        function() {
                            
                            if ( isNotthemIsOneServ(this, name) ){
                                if ( type == 0 ) 
                                
                                    $(this).hide() ;
                                
                                else {
                                    
                                    if ( $(this).hasClass('liste_gauche_service_selected') )
                                    
                                        $(this).toggleClass('liste_gauche_service_selected');
                                    
                                    $(this).show() ;
                                    
                                }
                            }
                        }
                    );
                }
                
                /*
                    Change les actions qui sont réalisées lors de la soumission du formulaire
                */
                function changeActionVal(data){
                    date = $('#date_envoi').val();
                    


                    $('#button_val').attr(
                        'onclick',
                        'if ( $(\'.liste_gauche_service_selected\').length > 0 && $(\'#date_envoi\').val() != \'\' ) { messageIt(\'consultation\', \'".html_entity_decode($datasubmit)."&data='+data+'&date_envoi='+date+'\',true);' +
                        'messageIt(\'consultation\', \'".html_entity_decode($return_url)."\',false);} else alert(\'Veuillez choisir au moins un service et une date d envoi\');'
                        
                    );
                    
                }
                
                /*
                    Change les actions qui sont réalisées lors de la soumission du formulaire
                */
                function changeOneData( oldData, newData) {
                    
                    date = $('#date_envoi').val();

                    $('#button_val').attr(
                        'onclick',
                        $('#button_val').attr('onclick').replace(oldData,newData)
                    );

                }
                
                function changeDataLeftColumn(){
                    
                    $('.list-sel-ser-them').empty();
                    $('.list-sel-ser-them').html(
                        '<div class=\"row row_title\">' +
                            '<div class=\"cell1 liste_droite_title list-sel-ser-them-title\">"._("Service a consulter")."</div>' +
                            '<div class=\"cell2 liste_droite_title list-sel-ser-them-title\">"._("Version papier")."</div>' +
                        '</div>'
                    );
                    
                    var listServ = new Array();
                    var data = '';
                                    
                    $('.liste_gauche_service_selected').each(
                        function(i) {
                            
                            var id = $(this).attr('id');
                            
                            if ( $.inArray(id.split('_')[1], listServ) != -1 )                            
                                return;
                            
                            data += ';' + id.split('_')[1] + '_' + id.split('_')[2] ;
                            listServ[i] = id.split('_')[1];
                            
                            $('.list-sel-ser-them').append(
                                '<div id=\'s' + i + '\' class=\'row liste_droite_service\'>'+
                                    '<div class=\'cell1\'>'+
                                        '<div class=\'' + $(this).attr('id') + '\' name=\'' + $(this).attr('id') + '\'>'+
                                            $(this).html().split('<')[0]+
                                        '</div>'+
                                    '</div>' + 
                                    '<div class=\'cell2\'>'+
                                        '<div>'+
                                            '<input class=\'' + $(this).attr('id') + '\''+$(this).html().split('<input')[1]+
                                        '</div>'+
                                    '</div>'+
                                '</div>'
                            );
                            
                            $(this).hide();
                            
                            manageListServ('.list-ser-them div', id, 0);
                            
                        }
                    );
                    changeActionVal(data);
                }
            </script>";
        }
    }


    /**
     * TREATMENT - view_bordereau_envoi_maire.
     * 
     * Génère et affiche l'édition PDF contenant une ou plusieurs consultations.
     * 
     * @return [void]
     */
    function generate_pdf_consultation_multiple() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Récupération de la collectivité du dossier d'instruction
        $collectivite = $this->f->getCollectivite($this->get_dossier_collectivite());
        // Identifiants des consultations à afficher
        $idsConsultations = $this->f->get_submitted_get_value('textids');
        // Type de chaque consultations (avec_avis_attendu, ...)
        $objConsultations = $this->f->get_submitted_get_value('textobj');
        // Génération du PDF
        $result = $this->compute_pdf_output('etat', $objConsultations, $collectivite, $idsConsultations);
        // Affichage du PDF
        $this->expose_pdf_output(
            $result['pdf_output'], 
            $result['filename']
        );
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $this->retourformulaire = $retourformulaire;
        //
        if ($validation == 0) {
            if ($maj == 0 or $maj == 40 or $maj == 41) {
                $form->setVal("dossier", $this->getParameter("idxformulaire"));
                $form->setVal("date_envoi", date("d/m/Y"));
            }
            if (($maj == 1 || $maj == 91 || $maj == 100) && $this->getVal("date_retour") == "") {
                if ($this->f->isAccredited("consultation_retour_avis_suivi")
                    || $this->f->isAccredited("consultation_retour_avis_service")) {
                    //
                    $form->setVal("date_retour", date("d/m/Y"));
                }
            }
        }
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        if (($maj == 1 || $maj == 91 || $maj == 100) && $this->getVal("date_retour") == "") {
            $form->setVal("date_retour", date('d/m/Y'));
        }
    }

    function setvalF($val = array()) {
        //
        parent::setValF($val);
        //Si on crée une consultation on la met a visible
        if ($this->getParameter('maj') == 0 || $this->getParameter('maj') == 41) {
            $this->valF["visible"] = true;
        }

        if ($this->getParameter('maj') == 0
            or $this->getParameter('maj') == 40
            or $this->getParameter('maj') == 41) {
            //
            if (isset($this->valF["date_envoi"])) {
                $this->valF["date_reception"] = $this->valF["date_envoi"];
            }
            //
            $this->valF["lu"] = true;
        }

        // Si un retour d'avis est modifie on passe "lu" a false
        if(($this->getParameter('maj')==100 ) and (
            $this->val[array_search("avis_consultation",$this->champs)] != $val["avis_consultation"] OR
            $this->val[array_search("date_retour",$this->champs)] != $val["date_retour"] OR
            $this->val[array_search("motivation",$this->champs)] != $val["motivation"] OR
            $this->val[array_search("fichier",$this->champs)] != $val["fichier"])
        ) {
            $this->valF["lu"]=false;
        }
    }

    /**
     * SETTER FORM - set_form_default_values
     * 
     * @param formulaire $form Instance formulaire.
     * @param integer $maj Identifant numérique de l'action.
     * @param integer $validation Marqueur de validation du formulaire.
     * 
     * @return void
     */
    function set_form_default_values(&$form, $maj, $validation) {
        if ($validation == 0 && $maj == 41) {
            foreach ($this->champs as $champ) {
                $form->setVal($champ, null, $validation);
            }
        }
    }

    function setLib(&$form, $maj) {
        //
        parent::setLib($form, $maj);
        //
        $form->setLib($this->clePrimaire, _("id"));
        $form->setLib('visible', _("visible dans les éditions"));
        $form->setLib("live_preview", "");

        $form->setLib('categorie_tiers_consulte', _('catégorie du tiers consulté'));
        $form->setLib('tiers_consulte', __('tiers consulté'));
        $form->setLib('motif_consultation', _('motif de la consultation'));
        $form->setLib('fichier_pec', __('Fichier'));
        $form->setLib('motif_pec', __('Motif'));
    }

    function setType(&$form,$maj) {
        // Appel du parent
        parent::setType($form,$maj);
        $form->setType('consultation', 'hidden');
        $form->setType('dossier', 'hidden');
        $form->setType('marque', 'hidden');
        $form->setType('om_fichier_consultation_dossier_final', 'hidden');
        $form->setType('fichier_dossier_final', 'hidden');
        $form->setType('live_preview', 'hidden');
        //
        $form->setType('texte_fondement_avis', 'hidden');
        $form->setType('texte_avis', 'hidden');
        $form->setType('texte_hypotheses', 'hidden');
        $form->setType('nom_auteur', 'hidden');
        $form->setType('prenom_auteur', 'hidden');
        $form->setType('qualite_auteur', 'hidden');
        $form->setType('qualite_auteur', 'hidden');
        $form->setType('motif_pec', 'hidden');
        $form->setType('fichier_pec', 'hidden');
        // MODE - AJOUTER et MODE - AJOUTER CONSULTATION TIERS
        if ($maj == 0 || $maj == 41) {
            // On cache alors tous les champs que nous ne voulons pas voir
            // apparaître dans le formulaire d'ajout (principalement les
            // informations sur le retour d'avis)
            $form->setType('date_retour', 'hiddendate');
            $form->setType('date_reception', 'hiddendate');
            $form->setType('date_limite', 'hiddendate');
            $form->setType('avis_consultation', 'hidden');
            $form->setType('visible', 'hidden');
            $form->setType('motivation', 'hidden');
            $form->setType('fichier', 'hidden');
            $form->setType('lu', 'hidden');
            $form->setType('categorie_tiers_consulte', 'hidden');
            $form->setType('tiers_consulte', 'hidden');
            $form->setType('service', 'hidden');
            $form->setType('motif_consultation', 'hidden');
            // On permet la modification de certains champs
            $form->setType('dossier_libelle', 'hiddenstatic');
            $form->setType('commentaire', 'textarea');
            // Affichage des champs selon le type de consultation
            if ($maj == 0) { // consultation service
                $champsRecquis = array('service');
                $form->setType('service', 'select');
            } elseif ($maj == 41) { // consultation tiers
                $champsRecquis = array('categorie_tiers_consulte', 'tiers_consulte', 'motif_consultation');
                $form->setType('categorie_tiers_consulte', 'select');
                $form->setType('tiers_consulte', 'select');
                $form->setType('motif_consultation', 'select');
            }
            // Gestion de l'affichage des champs obligatoire selon le type de consultation
            // TODO : A voir si il existe une meilleur manière de gérer l'affichage des champs obligatoire
            foreach ($champsRecquis as $champs) {
                $this->required_field[] = $champs;
            }
            // Le champ "date d'envoi" est affiché seulement si l'utilisateur a la 
            // permission
            if($this->f->isAccredited('consultation_saisir_date_envoi')) {
                $form->setType('date_envoi', 'date2');
            }
            else {
                $form->setType('date_envoi', 'hiddendate');
            }
        }
        // MODE - MODIFIER
        if ($maj == 1) {
            // On affiche en statique les informations qui ne sont plus
            // modifiables
            $form->setType('dossier_libelle', 'hiddenstatic');
            $form->setType('date_envoi', 'hiddenstaticdate');
            $form->setType('date_limite', 'hiddenstaticdate');
            $form->setType('visible', 'checkboxhiddenstatic');
            // Gestion de l'affichage des champs selon les consultations service et tiers
            if ($this->getVal('service') != null && $this->getVal('service') != '') {
                $form->setType('service', 'selecthiddenstatic');
                $form->setType('categorie_tiers_consulte', 'hidden');
                $form->setType('tiers_consulte', 'hidden');
                $form->setType('motif_consultation', 'hidden');
            } else {
                $form->setType('service', 'hidden');
                $form->setType('categorie_tiers_consulte', 'selecthiddenstatic');
                $form->setType('tiers_consulte', 'selecthiddenstatic');
                $form->setType('motif_consultation', 'selecthiddenstatic');
            }
            
            // La date de réception ne peut être modifiée que par un
            // utilisateur en ayant spécifiquement la permission
            if($this->f->isAccredited(array('consultation','consultation_modifier_date_reception'), 'OR')) {
                $form->setType('date_reception', 'date2');
            } else {
                $form->setType('date_reception', 'hiddenstaticdate');
            }

            // Le marqueur lu/non lu ne peut être modifié que par un
            // utilisateur en ayant spécifiquement la permission
            if ($this->f->isAccredited(array('consultation','consultation_modifier_lu'), 'OR')) {
                $form->setType('lu', 'checkbox');
            } else {
                $form->setType('lu', 'hidden');
            }

            // Gestion du type du widget sur le champ fichier
            if($this->getVal("fichier") == "" OR
               $this->f->isAccredited(array('consultation', 'consultation_modifier_fichier'), 'OR')) {
                // Si il n'y a jamais eu de fichier enregistré ou que
                // l'utilisateur a spécifiquement les droits pour modifier
                // un fichier déjà enregistré alors on positionne un type
                // de widget modifiable
                $contexts = array(
                    "demande_avis_encours",
                    "dossier",
                    "dossier_contentieux_mes_infractions",
                    "dossier_contentieux_mes_recours",
                    "dossier_contentieux_tous_recours",
                    "dossier_contentieux_toutes_infractions",
                    "dossier_instruction",
                    "dossier_instruction_mes_clotures",
                    "dossier_instruction_mes_encours",
                    "dossier_instruction_tous_clotures",
                    "dossier_instruction_tous_encours",
                    "dossier_qualifier",
                );
                if (in_array($this->getParameter("retourformulaire"), $contexts) === true) {
                    $form->setType('fichier', 'upload2');
                } else {
                    $form->setType('fichier', 'upload');
                }
            } else {
                // Si non on affiche uniquement le nom du fichier 
                $form->setType('fichier', 'filestaticedit');
            }

        }
        // Mode supprimer
        if ($maj == 2) {
            $form->setType('fichier', 'filestatic');
            // L'affichage des champs différe pour les consultations de service et celle de tiers
            if ($this->getVal('service') != null && $this->getVal('service') != '') {
                $form->setType('categorie_tiers_consulte', 'hidden');
                $form->setType('tiers_consulte', 'hidden');
                $form->setType('motif_consultation', 'hidden');
            } else {
                $form->setType('service', 'hidden');
            }
        }
        // MODE - CONSULTER
        if ($maj == 3) {
            $form->setType('fichier', 'file');
            // Affichage d'une consultation vers un service
            if ($this->getVal('service') !== null && $this->getVal('service') != '') {
                $form->setType('categorie_tiers_consulte', 'hidden');
                $form->setType('tiers_consulte', 'hidden');
                $form->setType('motif_consultation', 'hidden');
                $inst_service = $this->get_inst_service($this->getVal('service'));
                if ($inst_service->getVal('service_type') === PLATAU) {
                    $form->setType("texte_fondement_avis", "textareastatic");
                    $form->setType("texte_avis", "textareastatic");
                    $form->setType("texte_hypotheses", "textareastatic");
                    $form->setType("nom_auteur", "static");
                    $form->setType("prenom_auteur", "static");
                    $form->setType("qualite_auteur", "static");
                    $form->setType("motif_pec", "textareastatic");
                    $form->setType("fichier_pec", "file");
                }
            } else { // Affichage d'un consultation d'un tiers
                $form->setType('service', 'hidden');
                $inst_motif = $this->f->get_inst__om_dbform(array(
                    'idx' => $this->getVal('motif_consultation'),
                    'obj' => 'motif_consultation'
                ));
                if ($inst_motif->getVal('service_type') === PLATAU) {
                    $form->setType("texte_fondement_avis", "textareastatic");
                    $form->setType("texte_avis", "textareastatic");
                    $form->setType("texte_hypotheses", "textareastatic");
                    $form->setType("nom_auteur", "static");
                    $form->setType("prenom_auteur", "static");
                    $form->setType("qualite_auteur", "static");
                }
            }
        }

        // MODE - AJOUT MULTIPLE
        if ($maj == 40) {
            $form->setType('visible', 'hidden');
        }

        // MODE - retour de consultation par suivi des date
        if ($maj == 100) {
            $form->setType("consultation", "hiddenstatic");
            $form->setType('dossier_libelle', 'hiddenstatic');
            $form->setType('date_envoi', 'hiddenstaticdate');
            $form->setType('date_limite', 'hiddenstaticdate');
            $form->setType('date_reception', 'hiddenstaticdate');
            $form->setType('service', 'selecthiddenstatic');
            $form->setType('categorie_tiers_consulte', 'selecthiddenstatic');
            $form->setType('tiers_consulte', 'selecthiddenstatic');
            $form->setType('motif_consultation', 'selecthiddenstatic');
            $form->setType('commentaire', 'hiddenstatic');
            $form->setType('date_retour', 'date');
            $form->setType('lu', 'hidden');
            $form->setType('visible', 'hidden');
            $form->setType("avis_consultation", "select");
            $form->setType("motivation", "textarea");
            $form->setType('fichier', 'upload');
            // Gestion du type du widget sur le champ fichier
            if($this->getVal("fichier") == "" OR
               $this->f->isAccredited(array('consultation', 'consultation_modifier_fichier'), 'OR')) {
                // Si il n'y a jamais eu de fichier enregistré ou que
                // l'utilisateur a spécifiquement les droits pour modifier
                // un fichier déjà enregistré alors on positionne un type
                // de widget modifiable
                $contexts = array(
                    "demande_avis_encours",
                    "dossier",
                    "dossier_contentieux_mes_infractions",
                    "dossier_contentieux_mes_recours",
                    "dossier_contentieux_tous_recours",
                    "dossier_contentieux_toutes_infractions",
                    "dossier_instruction",
                    "dossier_instruction_mes_clotures",
                    "dossier_instruction_mes_encours",
                    "dossier_instruction_tous_clotures",
                    "dossier_instruction_tous_encours",
                    "dossier_qualifier",
                );
                if (in_array($this->getParameter("retourformulaire"), $contexts) === true) {
                    $form->setType('fichier', 'upload2');
                } else {
                    $form->setType('fichier', 'upload');
                }
            } else {
                // Si non on affiche uniquement le nom du fichier 
                $form->setType('fichier', 'filestaticedit');
            }
        }
        //// On cache la clé primaire
        //$form->setType('consultation', 'hidden');
        //
        if ($this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
            $form->setType('dossier_libelle', 'hidden');
        }
            
        $form->setType('code_barres', 'hidden');
        
        //Cache les champs pour la finalisation
        $form->setType('om_fichier_consultation', 'hidden');
        $form->setType('om_final_consultation', 'hidden');

        if($maj == 50 OR $maj == 51 OR $maj == 60 OR $maj == 70 OR $maj == 120 OR $maj == 130 OR $maj == 140) {
            foreach ($this->champs as $value) {
                $form->setType($value, 'hidden');
            }
        }

        if ($maj == 400) {
            foreach ($this->champs as $champ) {
                $form->setType($champ, 'hidden');
            }
            $form->setType('live_preview', 'previsualiser');
        }
    }

    /**
     * Permet de définir l’attribut “onchange” sur chaque champ.
     *
     * @param object  &$form Formumaire
     * @param integer $maj   Mode d'insertion
     */
    function setOnchange(&$form, $maj) {
        parent::setOnchange($form, $maj);

        // En cas de changement du champ categorie_tiers_consulte, appel
        // la méthode javascript filterSelect qui utilise (via l'URL) le
        // snippet_filterselect. Le snippet renvoie ensuite un json contenant la valeur du champ.
        // Cette valeur est ensuite utilisé pour récupèrer la liste des
        // tiers_consulte ayant la categorie sélectionné
        // Uniquement dans le formulaire d'ajout d'une consultation a un tiers
        if ($maj == '41') {
            $form->setOnchange(
                'categorie_tiers_consulte',
                "filterSelect(
                    this.value,
                    'tiers_consulte',
                    'categorie_tiers_consulte',
                    'consultation'
                )"
            );
        }
    }

    /**
     * Cette méthode permet de calculer la date limite en fonction de la date
     * de réception et du délai de consultation.
     *
     * Met a jour les valeurs du formulaire en mettant a jour l'attribut valF.
     *
     * @param
     * @return void
     */
    function calculDateLimite() {
        // Vérifie si la variable contenant les informations nécessaire au calcul
        // de la date limite a bien été setter et si ce n'est pas le cas fait
        // appel au setter.
        if ($this->valElementConsulte == array()) {
            $this->set_val_element_consulte();
        }

        // mise a jour instruction avec evenement [return delay]
        if (array_key_exists("date_reception", $this->valF)
            && $this->valF["date_reception"] != "") {
            // Calcul de la date limite a partir du délai et du type de délai
            $this->valF["date_limite"] = $this->f->mois_date(
                $this->valF["date_reception"],
                $this->valElementConsulte['delai'],
                "+",
                $this->valElementConsulte['delai_type']
            );
            //
            if ($this->valElementConsulte['delai_type'] == "mois") {
                $delai_type_trad = _("mois");
            } else {
                $delai_type_trad = _("jour(s)");
            }
            //
            $this->addToMessage(_("delai")." ".
               _("retour")." ".$this->valElementConsulte['delai']." ".$delai_type_trad." -> ".
               _("retour")." ".date("d/m/Y", strtotime($this->valF["date_limite"])));
        }
    }

    /**
     * Identifie si la consultation est une consultation de tiers ou de service
     * a partir des valeurs envoyées dans le formulaire ou alors des valeurs
     * issue de la consultation.
     * Si il existe une valeur pour le champ service, le type de consultation sera setter
     * a "service".
     * Si il existe une valeur pour le champ tiers_consulte, le type de consultation sera setter
     * a "tiers_consulte"
     * Si aucun type de consultation n'a pu être défini renvoie false.
     *
     * Une fois le type de consultation récupéré effectue une requête pour récupérer
     * toutes les infos nécessaires pour créer / mettre à jour la consultation.
     * Set la variable valElementConsulte avec les valeurs ainsi récupérées.
     *
     * @return boolean indique si les informations ont été correctement récupérées
     */
    protected function set_val_element_consulte() {
        $typesConsultationPossible = array('service', 'tiers_consulte');
        $typeConsultation = null;
        // Pour tous les types de consultation possible vérifie si l'élément
        // consulté a bien une valeur enregistrée pour la consultation.
        // Si c'est le cas la consultation est de ce type
        // UNe fois le type de consultation récupéré il n'y a plus besoin de tester
        // les autres types car une consultation n'a qu'un seul type (tier ou service)
        foreach ($typesConsultationPossible as $typePossible) {
            if (isset($this->valF[$typePossible]) &&
                $this->valF[$typePossible] != null &&
                $this->valF[$typePossible] != '') {
                $typeConsultation = $typePossible;
                $idElement = $this->valF[$typePossible];
                break;
            } elseif ($this->getVal($typePossible) != null && $this->getVal($typePossible) != '') {
                $typeConsultation = $typePossible;
                $idElement = $this->getVal($typePossible);
                break;
            }
        }

        // Renvoie une erreur si le type de consultation n'a pas pu être récupéré
        if ($typeConsultation == null) {
            $this->addToMessage(__('Erreur : le type de consultation n\'a pas pu être défini'));
            return false;
        }
        $this->typeConsultation = $typeConsultation;
        // Récuperation les infos lié à l'élement consulté de la consultation.
        $instance = $this->f->get_inst__om_dbform(array(
            'obj' => $typeConsultation,
            'idx' => $idElement
        ));
        $champARecupere = array(
            $typeConsultation,
            'libelle',
            'abrege',
            'generate_edition',
            'service_type',
            'delai',
            'delai_type',
            'notification_email',
            'email'
        );
        if ($typeConsultation == 'tiers_consulte') {
            // POur les tiers consulte, il faut récupérer le motif de consultation
            $idMotif = isset($this->valF['motif_consultation']) &&
                $this->valF['motif_consultation'] != null &&
                $this->valF['motif_consultation'] != '' ?
                $this->valF['motif_consultation'] :
                $this->getVal('motif_consultation');
            if ($idMotif == null || $idMotif == '') {
                $this->addToMessage(__('Erreur : le motif de consultation n\'a pas pu être récupéré'));
                return false;
            }
            $instanceMotif = $this->f->get_inst__om_dbform(array(
                'obj' => 'motif_consultation',
                'idx' => $idMotif
            ));
            foreach($champARecupere as $champ) {
                // On cherche les informations voulus dans la table tiers consulte et
                // si il n'existe pas c'est qu'ils sont dans la table motif_consultatio,
                if ($instance->getVal($champ) != null) {
                    $valElementConsulte[$champ] = $instance->getVal($champ);
                } else {
                    $valElementConsulte[$champ] = $instanceMotif->getVal($champ);
                }
            }
            // Le champ contenant les adresses mails n'a pas le même nom pour les
            // tiers et les services. Pour les tiers il faut donc récupèrer les mails
            // dans 'liste_diffusion'
            $valElementConsulte['email'] = $instance->getVal('liste_diffusion');
        } else {
            foreach($champARecupere as $champ) {
                $valElementConsulte[$champ] = $instance->getVal($champ);
            }
        }
        $this->valElementConsulte = $valElementConsulte;
        return true;
    }

    /**
     * TRIGGER - triggerajouter.
     * Réalise le calcul de la date limite de consultation et
     *
     * @return boolean
     */
    function triggerajouter($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Set le type de consultation (var typeConsultation) et les valeurs
        // issues de l'élement consulte (var valElementConsulte)
        if ($this->set_val_element_consulte() == false) {
            $this->addToMessage(__('Erreur : les informations de l\'élement consulté n\'ont pas pu être récupéré.'));
            return false;
        }
        $this->calculDateLimite();

        if ($this->valElementConsulte['generate_edition'] === 't') {
            // Identifiant du type de courrier
            $idTypeCourrier = '12';
            $idCourrier = str_pad($this->valF["consultation"], 10, "0", STR_PAD_LEFT);
            // Code barres
            $this->valF["code_barres"] = $idTypeCourrier . $idCourrier;
        }
    }

    /**
     * TRIGGER - triggermodifier.
     *
     * @return boolean
     */
    function triggermodifier($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Set le type de consultation (var typeConsultation) et les valeurs
        // issues de l'élement consulte (var valElementConsulte)
        if ($this->set_val_element_consulte() == false) {
            $this->addToMessage(__('Erreur : les informations de l\'élement consulté n\'ont pas pu être récupéré.'));
            return false;
        }

        // Si la date de réception a été modifiée on recalcul les délais à partir de la nouvelle date
        if (array_key_exists("date_reception", $this->valF) === true
            && $this->getVal('date_reception') !== $this->valF['date_reception']) {
            $this->calculDateLimite();
        }
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * - Notification par courrier du service consulté
     * - Interface avec le référentiel ERP [104]
     * - Interface avec le référentiel ERP [106]
     * - Finalisation du document PDF de consultation
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Set le type de consultation (var typeConsultation) et les valeurs
        // issues de l'élement consulte (var valElementConsulte)
        if ($this->set_val_element_consulte() == false) {
            $this->addToMessage(__('Erreur : les informations de l\'élement consulté n\'ont pas pu être récupéré.'));
            return false;
        }
        // On a besoin de l'instance du dossier lié à la consultation
        $inst_di = $this->get_inst_dossier($this->valF['dossier']);

        /**
         * Notification par courriel du service consulté.
         * 
         * Si il y a un problème lors de l'envoi du courriel, on prévient l'utilisateur
         * mais on ne bloque pas le traitement. Le courriel de notification n'a pas de 
         * de caractère critique.
         */
        // On a besoin du nom de l'élement consulté pour l'affichage des messages
        $tradTypeConsultation = str_replace('_', ' ', $this->typeConsultation);
        if ($this->valElementConsulte['notification_email'] == 't') {
            // vérifie si il y a bien des adresses mail enregistrées dans la liste de diffusion
            // et si ce n'est pas le cas préviens l'utilisateur que l'envoi du mail n'est pas possible
            if ($this->valElementConsulte['email'] == '') {
                $this->addToMessage(sprintf(
                    __("Erreur, il n'y a aucune adresse mail dans la liste de diffusion du %s (%s) %s. Envoi du mail non effectué."),
                    $tradTypeConsultation,
                    $this->valElementConsulte['abrege'],
                    $this->valElementConsulte["libelle"]
                ));
            } else {
                // Composition du titre du courriel
                $title = sprintf(
                    '%s %s',
                    _("Consultation de ".$tradTypeConsultation." : dossier no"),
                    $inst_di->getVal($inst_di->clePrimaire)
                );
                $title = iconv("UTF-8", "CP1252", $title);
                // Composition du corps du courriel
                $corps = sprintf(
                    '%s %s<br/>%s %s %s %s %s<br/>%s <a href=\'%s\'>%s</a> %s <a href=\'%s\'>%s</a>',
                    _("Votre ".$tradTypeConsultation." est consulte concernant le dossier no"),
                    $inst_di->getVal($inst_di->clePrimaire),
                    _("Il concerne le terrain situe a l'adresse :"),
                    $inst_di->getVal('terrain_adresse_voie_numero'),
                    $inst_di->getVal('terrain_adresse_voie'),
                    $inst_di->getVal('terrain_adresse_code_postal'),
                    $inst_di->getVal('terrain_adresse_localite'),
                    _("Vous pouvez y acceder et rendre votre avis a l'adresse"),
                    // Adresse interne, si l'adresse termine par &idx= alors on ajoute l'identifiant de la consultation
                    $this->f->getParameter('services_consultes_lien_interne').((substr($this->f->getParameter('services_consultes_lien_interne'), -5) == "&idx=") ? $this->valF['consultation'] : ""),
                    _("Lien interne"),
                    _("ou"),
                    // Adresse externe, si l'adresse termine par &idx= alors on ajoute l'identifiant de la consultation
                    $this->f->getParameter('services_consultes_lien_externe').((substr($this->f->getParameter('services_consultes_lien_externe'), -5) == "&idx=") ? $this->valF['consultation'] : ""),
                    _("Lien externe")
                );
                // Récupération des destinataire
                $email_list = explode("\r\n", $this->valElementConsulte['email']);
                $nb_destinataire = count($email_list);
                $nb_success = 0;
                $nb_error = 0;
                foreach ($email_list as $email) {
                    // Envoi du mail avec message de retour
                    if ($this->f->sendMail($title, $corps, $email)) {
                        $this->f->addToLog(__METHOD__."() : senMail envoi de la notification au ".$tradTypeConsultation." effectué", VERBOSE_MODE);
                        $nb_success++;
                    } else {
                        $this->f->addToLog(__METHOD__."() : ERROR - sendMail envoi de la notification au ".$tradTypeConsultation." n'a pas pu aboutir", DEBUG_MODE);
                        $nb_error++;
                    }
                }
                if ($nb_success != 0) {
                    $this->addToMessage(
                        sprintf(
                        __("Envoi d'un mail de notification au %s (%s) %s."),
                        $tradTypeConsultation,
                        $this->valElementConsulte['abrege'],
                        $this->valElementConsulte["libelle"]
                    ));
                }
                if ($nb_error > 0 && $nb_error != $nb_destinataire) {
                    $this->addToMessage(sprintf(
                        __("Erreur lors de l'envoi du mail de notification à au moins un destinataire du %s (%s) %s."),
                        $tradTypeConsultation,
                        $this->valElementConsulte['abrege'],
                        $this->valElementConsulte["libelle"]
                    ));
                }
                if ($nb_error == $nb_destinataire) {
                    $this->addToMessage(sprintf(
                        __("Erreur lors de l'envoi du mail de notification aux destinataires du %s (%s) %s."),
                        $tradTypeConsultation,
                        $this->valElementConsulte['abrege'],
                        $this->valElementConsulte["libelle"]
                    ));
                }
            }
        }

        // Récupère la collectivité du dossier d'instruction lié à la
        // consultation
        $om_collectivite = $this->get_dossier_collectivite();

        // /!\ pour l'instant l'interface avec le référentiel erp concerne
        // uniquement les consultations faite à des service
        if ($this->typeConsultation === 'service') {
            // Récupération de l'instance du service en utilisant l'id du service stocké
            // dans valElementConsulte.
            $inst_service = $this->get_inst_service($this->valElementConsulte['service']);
            /**
             * Interface avec le référentiel ERP.
             *
             * (WS->ERP)[104] Demande d'instruction de dossier PC pour un ERP -> PC
             * Déclencheur :
             *  - L'option ERP est activée
             *  - Le dossier est de type PC
             *  - Le formulaire d'ajout de consultation est validé avec un service
             *    correspondant à un des services ERP pour avis
             */
            if ($this->f->is_option_referentiel_erp_enabled($om_collectivite) === true
                && $this->f->getDATCode($inst_di->getVal($inst_di->clePrimaire)) == $this->f->getParameter('erp__dossier__nature__pc')
                && in_array($inst_service->getVal($inst_service->clePrimaire), explode(";", $this->f->getParameter('erp__services__avis__pc')))) {
                //
                $infos = array(
                    "dossier_instruction" => $inst_di->getVal($inst_di->clePrimaire),
                    "consultation" => $this->valF['consultation'],
                "date_envoi" => $this->valF['date_envoi'],
                "service_abrege" => $inst_service->getVal('abrege'),
                "service_libelle" => $inst_service->getVal('libelle'),
                "date_limite" => $this->valF['date_limite'],
                );
                //
                $ret = $this->f->send_message_to_referentiel_erp(104, $infos);
                if ($ret !== true) {
                    $this->cleanMessage();
                    $this->addToMessage(_("Une erreur s'est produite lors de la notification (104) du référentiel ERP. Contactez votre administrateur."));
                    return false;
                }
                $this->addToMessage(_("Notification (104) du référentiel ERP OK."));
            }
            
            /**
             * Interface avec le référentiel ERP.
             *
             * (WS->ERP)[106] Consultation ERP pour conformité -> PC
             * Déclencheur :
             *  - L'option ERP est activée
             *  - Le dossier est de type PC
             *  - Le formulaire d'ajout de consultation est validé avec un service
             *    correspondant à un des services ERP pour conformité
             */
            //
            if ($this->f->is_option_referentiel_erp_enabled($om_collectivite) === true
                && $this->f->getDATCode($inst_di->getVal($inst_di->clePrimaire)) == $this->f->getParameter('erp__dossier__nature__pc')
                && in_array($inst_service->getVal($inst_service->clePrimaire), explode(";", $this->f->getParameter('erp__services__conformite__pc')))) {
                //
                $infos = array(
                    "dossier_instruction" => $inst_di->getVal($inst_di->clePrimaire),
                    "consultation" => $this->valF['consultation'],
                    "date_envoi" => $this->valF['date_envoi'],
                    "service_abrege" => $inst_service->getVal('abrege'),
                    "service_libelle" => $inst_service->getVal('libelle'),
                    "date_limite" => $this->valF['date_limite'],
                );
                //
                $ret = $this->f->send_message_to_referentiel_erp(106, $infos);
                if ($ret !== true) {
                    $this->cleanMessage();
                    $this->addToMessage(_("Une erreur s'est produite lors de la notification (106) du référentiel ERP. Contactez votre administrateur."));
                    return false;
                }
                $this->addToMessage(_("Notification (106) du référentiel ERP OK."));
            }
        }

        /**
         * Finalisation du document PDF de consultation.
         */
        if ($this->valElementConsulte['generate_edition'] === 't') {
            $finaliserAjouter = $this->finaliserAjouter($id);
            if ($finaliserAjouter === false) {
                return false;
            }
        }

        /**
         * Gestion des tâches pour la dématérialisation
         */
        // Le service consulté fera sa réponse depuis Plat'AU
        if ($this->valElementConsulte['service_type'] === PLATAU
            && $this->f->is_type_dossier_platau($inst_di->getVal('dossier_autorisation')) === true
            && $inst_di->getVal('etat_transmission_platau') !== 'jamais_transmissible') {
            //
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => 'creation_consultation',
                'object_id' => $id,
                'dossier' => $val['dossier'],
            );
            // Change l'état de la tâche de notification en fonction de l'état de
            // transmission du dossier d'instruction
            if ($this->f->is_option_mode_service_consulte_enabled() === false
                && ($inst_di->getVal('etat_transmission_platau') == 'non_transmissible' 
                || $inst_di->getVal('etat_transmission_platau') == 'transmis_mais_non_transmissible')) {
                //
                $task_val['state'] = $inst_task::STATUS_DRAFT;
            }
            $add_task = $inst_task->add_task(array('val' => $task_val));
            if ($add_task === false) {
                $this->addToMessage(sprintf('%s %s',
                    __("Une erreur s'est produite lors de la création tâche."),
                    __("Veuillez contacter votre administrateur.")
                ));
                $this->correct = false;
                return false;
            }
        }

        //
        return true;
    }

    /**
     * TRIGGER - triggersupprimerapres.
     *
     * @return boolean
     */
    function triggersupprimerapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        parent::triggersupprimerapres($id, $dnu1, $val, $dnu2);

        /**
         * Gestion des tâches pour la dématérialisation
         */
        $inst_task_empty = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));
        $task_exists = $inst_task_empty->task_exists('creation_consultation', $id);
        if ($task_exists !== false) {
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => $task_exists,
            ));
            // Si il existe une tâche non traitée associé à la consultation elle est annulée.
            if ($inst_task->getVal('state') !== $inst_task::STATUS_DONE) {
                $task_val = array(
                    'state' => $inst_task::STATUS_CANCELED,
                );
                $update_task = $inst_task->update_task(array('val' => $task_val));
                if ($update_task === false) {
                    $this->addToMessage(sprintf('%s %s',
                        sprintf(__("Une erreur s'est produite lors de la modification de la tâche %."), $inst_task->getVal($inst_task->clePrimaire)),
                        __("Veuillez contacter votre administrateur.")
                    ));
                    $this->correct = false;
                    return false;
                }
            }
        }

        //
        return true;
    }

    // =============================================
    // Ajout du fielset
    // Add fieldset
    // =============================================
    function setLayout(&$form, $maj){

        //Champs sur lequel s'ouvre le fieldset
        $form->setBloc('dossier','D',"");
        $form->setFieldset('dossier','D',_('Consultation'));

        //Champs sur lequel se ferme le fieldset
        $form->setFieldset('visible','F','');
        $form->setBloc('visible','F');

        $form->setBloc('motif_pec','D',"");
        $form->setFieldset('motif_pec','D',_('Prise en compte'));
        $form->setFieldset('fichier_pec','F','');
        $form->setBloc('fichier_pec','F');

            
            // MODE - autre que AJOUTER alors on affiche un fieldset retour
            // d'avis
            if ($maj != 0 && $maj != 41) {
                
                //Champs sur lequel s'ouvre le fieldset
                $form->setBloc('date_retour','D',"");
                $form->setFieldset('date_retour','D',_('Retour d\'avis'));
    
                //Champs sur lequel se ferme le fieldset
                $form->setFieldset('lu','F','');
                $form->setBloc('lu','F');
                
            }

        $form->setBloc('texte_fondement_avis','D',"");
        $form->setFieldset('texte_fondement_avis','D',_("Informations Plat'AU"));
        $form->setFieldset('qualite_auteur','F','');
        $form->setBloc('qualite_auteur','F');
    }

    /** Surcharge de la methode retour afin de retourner sur la page de saisie de
    * code barre si besoin
    **/
    function retour($premier = 0, $recherche = "", $tricol = "") {
        $params ="obj=".$this->get_absolute_class_name();
        if($this->getParameter("retour")=="form") {
            $params .= "&amp;idx=".$this->getParameter("idx");
            $params .= "&amp;action=3";
        }
        $params .= "&amp;premier=".$this->getParameter("premier");
        $params .= "&amp;tricol=".$this->getParameter("tricol");
        $params .= "&amp;advs_id=".$this->getParameter("advs_id");
        $params .= "&amp;valide=".$this->getParameter("valide");
        echo "\n<a class=\"retour\" ";
        echo "href=\"";
        //

        if($this->getParameter("retour")=="form" AND !($this->getParameter("validation")>0 AND $this->getParameter("maj")==2 AND $this->correct)) {
            echo OM_ROUTE_FORM."&".$params;
        } elseif($this->getParameter("retour")=="suivi_retours_de_consultation") {
            echo OM_ROUTE_FORM."&obj=consultation&idx=0&action=120";
        } else {
            echo OM_ROUTE_TAB."&".$params;
        }
        //
        echo "\"";
        echo ">";
        //
        echo _("Retour");
        //
        echo "</a>\n";
    }

    /**
     * Surcharge du bouton retour pour popup
     */
    function retoursousformulaire($idxformulaire = NULL, $retourformulaire = NULL, $val = NULL,
                                  $objsf = NULL, $premiersf = NULL, $tricolsf = NULL, $validation = NULL,
                                  $idx = NULL, $maj = NULL, $retour = NULL) {
        if ($this->getParameter("retourformulaire") === "demande_avis_encours") {
            echo "\n<a class=\"retour\" ";
            echo "href=\"";
            echo "#";
            echo  "\" ";
            echo ">";
            //
            echo _("Retour");
            //
            echo "</a>\n";
        } else {
            parent::retoursousformulaire($idxformulaire, $retourformulaire, $val,
                                  $objsf, $premiersf, $tricolsf, $validation,
                                  $idx, $maj, $retour);
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        // TODO : ajouter un commentaire expliquant pourquoi l'appel a la méthode parent
        // est commenté et voir si on peut quand même appeler le parents pour réduire
        // le code de cette méthode
        //parent::setSelect($form, $maj);
        // avis_consultation
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "avis_consultation",
            $this->get_var_sql_forminc__sql("avis_consultation"),
            $this->get_var_sql_forminc__sql("avis_consultation_by_id"),
            true
        );
        // service
        $sql_service = $this->get_var_sql_forminc__sql("service");
        // si contexte DI, ou surcharge (mes_encours, mes_clotures...)
        $is_in_context_of_foreign_key = $this->is_in_context_of_foreign_key("dossier", $this->getParameter('retourformulaire'));
        if ($is_in_context_of_foreign_key == true) {
            // on recupÃšre les services des multicollectivitÃ©s et de celle du DI
            $di = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $this->getParameter('idxformulaire'),
            ));
            $sql_service = str_replace(
                '<collectivite_di>',
                $di->getVal("om_collectivite"),
                $this->get_var_sql_forminc__sql("service_by_collectivite_from_di")
            );

            // Si l'option référentiel ERP est activée, et que le type du
            // dossier d'instruction en contexte n'est pas autorisé à être
            // interfacé avec le référentiel ERP, alors les services à consulter
            // représentant les services ERP ne doivent pas être proposés dans
            // la liste à choix
            if ($this->f->is_option_referentiel_erp_enabled($di->getVal("om_collectivite")) === true
                && $this->f->getDATCode($di->getVal('dossier')) == $this->f-> getParameter ('erp__dossier__nature__pc')
                &&($this->f->getParameter('erp__dossier__type_di__pc')) !== null) {
                //
                $query_where_service_pc = "";
                $erp_di_pc = $this->f->getParameter('erp__dossier__type_di__pc');
                $erp_di_pc = explode(";", $erp_di_pc);
                $type_di = $di->getVal('dossier_instruction_type') ;

                if (in_array($type_di, $erp_di_pc) === false) {
                    // Dans le cas d'une consultation pour avis
                    // Si les identifiant des services à consulter sont définis
                    // dans le paramètre erp__services__avis__pc
                    if ($this->f->getParameter('erp__services__avis__pc') !== null) {
                        $erp_service_pc = $this->f->getParameter('erp__services__avis__pc');
                        $erp_service_pc = explode(";", $erp_service_pc);

                        if (is_array($erp_service_pc) === true
                            && empty($erp_service_pc) !== true) {
                            //
                            $query_where_service_pc .= sprintf(
                                ' AND service.service NOT IN (%s) ',
                                implode(", ", $erp_service_pc)
                            );
                        }
                    }

                    // Dans le cas d'une consultation pour conformité
                    // Si les identifiant des services à consulter sont définis
                    // dans le paramètre erp__services__avis__pc
                    if ($this->f->getParameter('erp__services__conformite__pc') !== null) {
                        $erp_service_pc = $this->f->getParameter('erp__services__conformite__pc');
                        $erp_service_pc = explode(";", $erp_service_pc);

                        if (is_array($erp_service_pc) === true
                            && empty($erp_service_pc) !== true) {
                            //
                            $query_where_service_pc .= sprintf(
                                ' AND service.service NOT IN (%s) ',
                                implode(", ", $erp_service_pc)
                            );
                        }
                    }
                }

                $sql_service = str_replace('ORDER BY', $query_where_service_pc."ORDER BY", $sql_service);
            }
            //
            $sql_categorie_tiers_consulte = str_replace(
                '<om_collectivite_idx>',
                $di->getVal("om_collectivite"),
                $this->get_var_sql_forminc__sql("categorie_tiers_consulte")
            );
            // categorie_tiers_consulte
            // (Initialisation du Select dans le contexte d'apparition de clefs étrangères, 
            // afin d'inclure à la requête l'identifiant om_collectivité du DI)
            $this->init_select(
                $form, 
                $this->f->db,
                $maj,
                null,
                "categorie_tiers_consulte",
                $sql_categorie_tiers_consulte,
                $this->get_var_sql_forminc__sql("categorie_tiers_consulte_by_id"),
                true
            );
        }
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "service",
            $sql_service,
            $this->get_var_sql_forminc__sql("service_by_id"),
            true
        );
        //Seulement dans le cas d'un retour d'avis
        // Ajout des contraintes spécifiques pour l'ajout d'un fichier en retour de
        // consultation
        if ($this->getParameter("retourformulaire") == "demande_avis_encours"
            || $this->getParameter("maj") == 100
            || $this->getParameter("maj") == 91) {
            // avis_consultation
            $this->init_select(
                $form,
                $this->f->db,
                1,
                null,
                "avis_consultation",
                $this->get_var_sql_forminc__sql("avis_consultation"),
                $this->get_var_sql_forminc__sql("avis_consultation_by_id"),
                true
            );
            //Tableau des contraintes spécifiques
            $params = array(
                "constraint" => array(
                    "size_max" => 2,
                    "extension" => ".pdf"
                ),
            );
            
            $form->setSelect("fichier", $params);
        }

        //
        if ($maj == 400) {
            $champ_uid = 'om_fichier_consultation';
            if (! empty($this->f->get_submitted_get_value('champ_uid'))) {
                $champ_uid = $this->f->get_submitted_get_value('champ_uid');
            }
            $file = $this->f->storage->get($this->getVal($champ_uid));
            $form->setSelect('live_preview', array(
                'base64' => base64_encode($file['file_content']),
                'mimetype' => $file['metadata']['mimetype'],
                'label' => 'document de consultation',
                'href' => sprintf(
                    '../app/index.php?module=form&snippet=file&obj=consultation&champ=%2$s&id=%1$s',
                    $this->getVal($this->clePrimaire),
                    $champ_uid
                )
            ));
        }
        // tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "motif_consultation",
            $this->get_var_sql_forminc__sql("tiers_consulte"),
            $this->get_var_sql_forminc__sql("tiers_consulte"),
            true
        );
        // Initialise le select en fonction de la valeur du champs categorie_tiers_consulte
        $form->setSelect(
            'tiers_consulte',
            $this->loadSelect_tiers_consulte($form, $maj, "categorie_tiers_consulte")
        );
        // motif_consultation
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "motif_consultation",
            $this->get_var_sql_forminc__sql("motif_consultation"),
            $this->get_var_sql_forminc__sql("motif_consultation_by_id"),
            true
        );
    }

    /**
     * Renvoie les valeurs possible des options du select "tiers_consulte".
     *
     * Ce select liste toutes les unités qui ont le type recherché
     * par l'unité parente.
     *
     * @param  object  $form  Formulaire.
     * @param  integer $maj   Mode d'insertion.
     * @param  string  $champ Champ activant le filtre.
     *
     * @return array Tableau des valeurs possible du select.
     */
    protected function loadSelect_tiers_consulte($form, $maj, $champ) {
        // Initialisation du tableau de paramétrage du select :
        // - la clé 0 contient le tableau des valeurs,
        // - la clé 1 contient le tableau des labels,
        // - les clés des tableaux doivent faire correspondre le couple valeur/label.
        $contenu = array(
            0 => array('', ),
            1 => array(__('choisir')." ".__("tiers_consulte"), ),
        );

        // Récupération de l'identifiant de la catégorie du tiers consulté :
        // (par ordre de priorité)
        // - si une valeur est postée : c'est le cas lors du rechargement d'un
        //   formulaire et que le select doit être peuplé par rapport aux
        //   données saisies dans le formulaire,
        // - si la valeur est passée en paramètre : c'est le cas lors d'un
        //   appel via le snippet filterselect qui effectue un
        //   $object->setParameter($linkedField, $idx); lors d'un appel ajax
        //   depuis le formulaire,
        // - si la valeur est dans l'enregistrement de la consultation sur laquelle on se
        //   trouve : c'est le cas lors de la première ouverture du formulaire
        //   en modification par exemple.
        $idCategorieTiers = "";
        if ($this->f->get_submitted_post_value($champ) !== null) {
            $idCategorieTiers = $this->f->get_submitted_post_value($champ);
        } elseif ($this->getParameter($champ) != "") {
            $idCategorieTiers = $this->getParameter($champ);
        } elseif (isset($form->val[$champ])) {
            $idCategorieTiers = $form->val[$champ];
        }

        // Si on ne récupère pas la categorie de tiers alors on ne peut pas savoir
        // le type attendu, on renvoi donc un select vide
        if ($idCategorieTiers == "" || ! is_numeric($idCategorieTiers)) {
            return $contenu;
        }

        // on récupère la liste de tous les tiers ayant la catégorie voulue
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    tiers_consulte,
                    CONCAT(abrege, \' - \', libelle) AS libelle
                FROM 
                    %1$stiers_consulte
                WHERE 
                    categorie_tiers_consulte = %2$d
                ORDER BY
                    tiers_consulte.libelle ASC',
                DB_PREFIXE,
                intval($idCategorieTiers)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        // Préparation du tableau de paramétrage du select avec les résultats récupérés
        foreach ($qres['result'] as $row) {
            $contenu[0][] = $row['tiers_consulte'];
            $contenu[1][] = $row['libelle'];
        }

        // on renvoie le tableau de paramètrage du select contenant la liste des unités
        // respectant la contrainte de type
        return $contenu;
    }

    /**
     * Finalisation du document lors de l'ajout d'une consultation.
     *
     * @param integer $id_consult indentifiant de l'objet
     */
    function finaliserAjouter($id_consult){
        //
        $this->begin_treatment(__METHOD__);

        //
        $admin_msg_error = _("Veuillez contacter votre administrateur.");
        $file_msg_error = _("La finalisation du document a échoué.")
            ." ".$admin_msg_error;
        $bdd_msg_error = _("Erreur de base de données.")
            ." ".$admin_msg_error;
        $log_msg_error = "Finalisation non enregistrée - id consultation = %s - uid fichier = %s";

        $uid = $this->file_finalizing($id_consult);
        // Comme pour le fonctionnement de l'envoi de mail,
        // Si échec cela ne stoppe pas la création de la consultation.
        // L'utilisateur en est tout de même informé dans l'IHM
        // et l'erreur est loguée.
        if ($uid == '' || $uid == 'OP_FAILURE' ) {
            $this->addToMessage($file_msg_error);
            $this->addToLog(sprintf($log_msg_error, $id_consult, $uid), VERBOSE_MODE);
            return $this->end_treatment(__METHOD__, true);
        }

        // Si succès mise à jour de la consultation
        $valF = array(
            "om_final_consultation" => true,
            "om_fichier_consultation" => $uid
        );
        //
        $res = $this->f->db->autoExecute(DB_PREFIXE.$this->table, $valF, 
            DB_AUTOQUERY_UPDATE, $this->getCle($id_consult));
        //
        $this->addToLog(
            "finaliserAjouter() : db->autoExecute(\"".DB_PREFIXE.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getCle($id_consult)."\")",
            VERBOSE_MODE
        );
        //
        if ($this->f->isDatabaseError($res, true) === true) {
            $this->correct = false;
            // Remplacement du message de validation
            $this->msg = '';
            $this->addToMessage($bdd_msg_error);
            return $this->end_treatment(__METHOD__, false);
        }
        //
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Finalisation du fichier.
     *
     * @param integer $id indentifiant de l'objet
     *
     * @return  string uid du fichier finalisé
     */
    function file_finalizing($id){
        if ( ! ($pdf = $this->generate_pdf_consultation())) {
            $this->addToMessage(__('Erreur lors de la génération du document'));
            return '';
        }

        if(isset($this->valF["om_final_consultation"])) {
            $finalized = $this->valF["om_final_consultation"];
        } else {
            $finalized = $this->getVal("om_final_consultation");
        }

        // Métadonnées du document
        $metadata = array(
            'filename' => $pdf["filename"],
            'mimetype' => 'application/pdf',
            'size' => strlen($pdf["pdf_output"])
        );

        // Récupération des métadonnées calculées après validation
        $spe_metadata = $this->getMetadata("om_fichier_consultation");

        $metadata = array_merge($metadata, $spe_metadata);

        // Si le document a déjà été finalisé (vaudra 'f', ou false sinon)
        if ( $finalized != '' ){

            // Met à jour le document mais pas son uid
            $uid = $this->f->storage->update(
                $this->getVal("om_fichier_consultation"), $pdf["pdf_output"], $metadata);
        }
        // Sinon, ajoute le document et récupère son uid
        else {

            // Stockage du PDF
            $uid = $this->f->storage->create($pdf["pdf_output"], $metadata, "from_content", $this->table.".om_fichier_consultation");
        }

        return $uid;

    }


    /**
     * TREATMENT - finalize.
     * 
     * Permet de finaliser un enregistrement
     *
     * @param array $val  valeurs soumises par le formulaire
     * @param null  $dnu1 @deprecated Ancienne ressource de base de données.
     * @param null  $dnu2 @deprecated Ancien marqueur de débogage.
     *
     * @return boolean
     */
    function finalize($val = array(), &$dnu1 = null, $dnu2 = null) {

        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        // Traitement de la finalisation
        $ret = $this->manage_finalizing("finalize", $val);

        // Si le traitement retourne une erreur
        if ($ret !== true) {

            // Termine le traitement
            $this->end_treatment(__METHOD__, false);
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * TREATMENT - unfinalize.
     * 
     * Permet de definaliser un enregistrement
     *
     * @param array $val  valeurs soumises par le formulaire
     * @param null  $dnu1 @deprecated Ancienne ressource de base de données.
     * @param null  $dnu2 @deprecated Ancien marqueur de débogage.
     *
     * @return boolean
     */
    function unfinalize($val = array(), &$dnu1 = null, $dnu2 = null) {

        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        // Traitement de la finalisation
        $ret = $this->manage_finalizing("unfinalize", $val);

        // Si le traitement retourne une erreur
        if ($ret !== true) {

            // Termine le traitement
            $this->end_treatment(__METHOD__, false);
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * TREATMENT - manage_visibilite_consultation.
     * 
     * Permet de masquer la consultation dans les éditions si elle est actuellement
     * affichée, ou de l'afficher si elle est actuellement masquée.
     * 
     *
     * @param array $val  valeurs soumises par le formulaire
     * @param null  $dnu1 @deprecated Ancienne ressource de base de données.
     * @param null  $dnu2 @deprecated Ancien marqueur de débogage.
     *
     * @return boolean
     */
    function manage_visibilite_consultation($val = array(), &$dnu1 = null, $dnu2 = null) {

        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        // Recuperation de la valeur de la cle primaire de l'objet
        $id = $this->getVal($this->clePrimaire);

        if($this->getVal("visible") == 'f') {
            $valF["visible"] = true;
        }
        else {
            $valF["visible"] = false;
        }

        // Execution de la requête de modification des donnees de l'attribut
        $res = $this->f->db->autoExecute(DB_PREFIXE.$this->table, $valF, 
            DB_AUTOQUERY_UPDATE, $this->getCle($id));
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getCle($id)."\")",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res, true) !== false) {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            $this->addToMessage(_("Erreur de base de donnees. Contactez votre administrateur."));
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }

        if ($valF["visible"] === false) {
            $this->addToMessage(_("La consultation est masquée dans les éditions."));
        }
        else {
            $this->addToMessage(_("La consultation est affichée dans les éditions."));
        }
        // Termine le traitement
        return $this->end_treatment(__METHOD__, true);
    }


    /**
     * Finalisation des documents.
     * 
     * @param string $mode finalize/unfinalize
     * @param array  $val  valeurs soumises par le formulaire
     */
    function manage_finalizing($mode = null, $val = array()) {
        //
        $this->begin_treatment(__METHOD__);

        // Recuperation de la valeur de la cle primaire de l'objet
        $id_consult = $this->getVal($this->clePrimaire);

        //
        $admin_msg_error = _("Veuillez contacter votre administrateur.");
        $file_msg_error = _("Erreur de traitement de fichier.")
            ." ".$admin_msg_error;
        $bdd_msg_error = _("Erreur de base de données.")
            ." ".$admin_msg_error;
        $log_msg_error = "Finalisation non enregistrée - id consultation = %s - uid fichier = %s";

        // Si on finalise le document
        if ($mode == "finalize") {
            //
            $etat = _('finalisation');
            // Finalisation du fichier
            $uid = $this->file_finalizing($id_consult);
        }
        //
        else {
            //
            $etat = _('définalisation');
            //Récupération de l'uid du document finalisé
            $uid = $this->getVal("om_fichier_consultation");
        }

        // Si on définalise l'UID doit être défini
        // Si on finalise la création/modification du fichier doit avoir réussi
        if ($uid == '' || $uid == 'OP_FAILURE' ) {
            $this->correct = false;
            $this->addToMessage($file_msg_error);
            $this->addToLog(sprintf($log_msg_error, $id_consult, $uid), VERBOSE_MODE);
            return $this->end_treatment(__METHOD__, false);
        }

        foreach ($this->champs as $key => $value) {
            //
            $val[$value] = $this->val[$key];
        }
        $this->setvalF($val);

        // Verification de la validite des donnees
        $this->verifier($this->val);
        // Si les verifications precedentes sont correctes, on procede a
        // la modification, sinon on ne fait rien et on retourne une erreur
        if ($this->correct === true) {

            // Execution du trigger 'before' specifique au MODE 'update'
            $this->triggermodifier($id_consult, $this->f->db, $this->val, DEBUG);
            // Suppression de son message de validation
            $this->msg = '';

            //
            $valF = array();
            if ($mode == "finalize") {
                $valF["om_final_consultation"] = true;
            } else {
                $valF["om_final_consultation"] = false;
            }
            $valF["om_fichier_consultation"] = $uid;
                
            // Execution de la requête de modification des donnees de l'attribut
            // valF de l'objet dans l'attribut table de l'objet
            $res = $this->f->db->autoExecute(DB_PREFIXE.$this->table, $valF, 
                DB_AUTOQUERY_UPDATE, $this->getCle($id_consult));
            $this->addToLog(
                "finaliser() : db->autoExecute(\"".DB_PREFIXE.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getCle($id_consult)."\")",
                VERBOSE_MODE
            );
            //
            if ($this->f->isDatabaseError($res, true) === true) {
                $this->correct = false;
                $this->addToMessage($bdd_msg_error);
                return $this->end_treatment(__METHOD__, false);
            }
            //
            $this->addToMessage(sprintf(_("La %s du document s'est effectuee avec succes."), $etat));
            return $this->end_treatment(__METHOD__, true);
        }
        // L'appel de verifier() a déjà positionné correct à false
        // et défini un message d'erreur.
        $this->addToLog(sprintf($log_msg_error, $id_consult, $uid), DEBUG_MODE);
        return $this->end_treatment(__METHOD__, false);
    }

    /**
     * Permet de récupérer l'édition de la consultation.
     *
     * @param string $output type de sortie
     *
     * @return string si le type de sortie est string, le contenu du pdf est retourné.
     */
    function generate_pdf_consultation() {
        if(isset($this->valF[$this->clePrimaire])) {
            $id = $this->valF[$this->clePrimaire];
        } else {
            $id = $this->getVal($this->clePrimaire);
        }
        // Requête qui récupère le type de consultation
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                '(SELECT
                    id
                FROM
                    %1$sservice
                    LEFT JOIN %1$som_etat ON service.edition = om_etat.om_etat
                WHERE
                    service = (
                        SELECT
                            service
                        FROM
                            %1$sconsultation
                        WHERE
                            consultation = %2$d
                    )
                )
                UNION
                (SELECT
                    id
                FROM
                    %1$smotif_consultation
                    LEFT JOIN %1$som_etat ON motif_consultation.om_etat = om_etat.om_etat
                WHERE
                    motif_consultation = (
                        SELECT
                            motif_consultation
                        FROM
                            %1$sconsultation
                        WHERE
                            consultation = %2$d
                    )
                )',
                DB_PREFIXE,
                intval($id)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            $this->addToMessage(_("Aucun document genere."));
            $this->addToMessage(_("Finalisation non enregistree"));
            return false;
        }
        return $this->compute_pdf_output(
            "etat",
            $qres["result"],
            $this->f->getCollectivite($this->get_dossier_collectivite()),
            $id
        );
    }

    function get_dossier_collectivite() {
        if(isset($this->valF["dossier"])) {
            $dossier = $this->valF["dossier"];
        } elseif (! empty($this->f->get_submitted_get_value('dossier_instruction')) ) {
            $dossier = $this->f->get_submitted_get_value('dossier_instruction');
        } else {
            $dossier = $this->getVal("dossier");
        }
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    om_collectivite
                FROM
                    %1$sdossier
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            $this->addToMessage(_("Aucun document genere."));
            $this->addToMessage(_("Finalisation non enregistree"));
            return false;
        }
        return $qres["result"];
    }

    function view_consulter_pdf(){
        if ($this->getVal("om_final_consultation") == 't') {
            $lien = '../app/index.php?module=form&snippet=file&obj=consultation&'.
                    'champ=om_fichier_consultation&id='.$this->getVal($this->clePrimaire);
            header("Location: ".$lien);
        } else {
            
            $output = $this->generate_pdf_consultation();
            $this->expose_pdf_output($output["pdf_output"], $output["filename"]);
        }
        exit();
    }


    /**
     * Création du nom de fichier
     * @return string Nom du fichier
     */
    protected function getFichierFilename() {
        return $this->generate_filename();
    }

    /**
     * Génère le nom du fichier (retour d'avis).
     *
     * @param  string  $p_fichier         Identifiant du fichier dans le filestorage
     * @param  integer $p_consultation_id Identifiant de la consultation
     * @param  string  $p_extension       Extension du fichier
     * @param  boolean  $is_pec           Si c'est une pec
     *
     * @return string                     Nom du fichier
     */
    public function generate_filename($p_fichier = null, $p_consultation_id = null, $p_extension = null, $is_pec = false) {
        // Le fichier est soit passé en paramètre, soit récupéré des valeurs validées
        // du formulaire en cours, soit récupéré des valeurs enregistrées de l'objet courant
        // Le fichier est soit passé en paramètre, soit récupéré des valeurs validées
        // du formulaire en cours, soit récupéré des valeurs enregistrées de l'objet courant
        $fichier = $p_fichier;
        if ($p_fichier === null) {
            $fichier = isset($this->valF['fichier']) === true && $this->valF['fichier'] !== null ? $this->valF['fichier'] : $this->getVal('fichier');
        }
        // L'identifiant de la consultation est soit passé en paramètre, soit récupéré
        // des valeurs validées du formulaire en cours, soit récupéré des valeurs
        // enregistrées de l'objet courant
        $consultation_id = $p_consultation_id;
        if ($p_consultation_id === null) {
            $consultation_id = isset($this->valF[$this->clePrimaire]) === true && $this->valF[$this->clePrimaire] !== null ? $this->valF[$this->clePrimaire] : $this->getVal($this->clePrimaire);
        }
        $extension = $p_extension;
        if ($p_extension === null) {
            $extension = '';
            if ($fichier !== null && $fichier !== '') {
                // Si le fichier déjà existant est stocké de façon temporaire
                $temporary_test = explode("|", $fichier);
                if (isset($temporary_test[0]) === true && $temporary_test[0] == "tmp") {
                    if (isset($temporary_test[1]) === true) {
                        $tmp_filename = $this->f->storage->getFilename_temporary($temporary_test[1]);
                        $posExtension = strpos($tmp_filename, ".");
                        if ($posExtension !== false) {
                            $extension = strtolower(substr($tmp_filename, $posExtension));
                        }
                    }
                // Sinon récupération depuis le stockage principal ou alternatif
                } else {
                    $filename = $this->f->storage->getFilename($fichier);
                    $posExtension = strpos($filename, ".");
                    if ($posExtension !== false) {
                        $extension = strtolower(substr($filename, $posExtension));
                    }
                }
            }
        }
        // Retourne le nom du fichier
        if ($is_pec == true) {
           return "consultation_pec_".$consultation_id.$extension; 
        }
        return "consultation_avis_".$consultation_id.$extension;
    }

    /**
     * Récupération du numéro de dossier d'instruction à ajouter aux métadonnées
     * @return string numéro de dossier d'instruction
     */
    protected function getDossier($champ = null) {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier;
    }
    /**
     * Récupération la version du dossier d'instruction à ajouter aux métadonnées
     * @return int Version
     */
    protected function getDossierVersion() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->version;
    }
    /**
     * Récupération du numéro de dossier d'autorisation à ajouter aux métadonnées
     * @return string numéro de dossier d'autorisation
     */
    protected function getNumDemandeAutor() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier_autorisation;
    }
    /**
     * Récupération de la date de demande initiale du dossier à ajouter aux métadonnées
     * @return date demande initiale
     */
    protected function getAnneemoisDemandeAutor() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->date_demande_initiale;
    }
    /**
     * Récupération du type de dossier d'instruction à ajouter aux métadonnées
     * @return string type de dossier d'instruction
     */
    protected function getTypeInstruction() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier_instruction_type;
    }
    /**
     * Récupération du statut du dossier d'autorisation à ajouter aux métadonnées
     * @return string avis
     */
    protected function getStatutAutorisation() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->statut;
    }
    /**
     * Récupération du type de dossier d'autorisation à ajouter aux métadonnées
     * @return string type d'autorisation
     */
    protected function getTypeAutorisation() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier_autorisation_type;
    }
    /**
     * Récupération de la date d'ajout de document à ajouter aux métadonnées
     * @return date de l'évènement
     */
    protected function getDateEvenementDocument() {
        return date("Y-m-d");
    }
    /**
     * Récupération du groupe d'instruction à ajouter aux métadonnées
     * @return string Groupe d'instruction
     */
    protected function getGroupeInstruction() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->groupe_instruction;
    }
    /**
     * Récupération du type de document à ajouter aux métadonnées
     * @return string Type de document
     */
    protected function getTitle() {
        if ($this->getParameter("retourformulaire") == "demande_avis_encours") {
            return 'Retour de consultation';
        } else {
            return 'Demande de consultation';
        }
    }


    /**
     * Récupération du champ ERP du dossier d'instruction.
     *
     * @return boolean
     */
    public function get_concerne_erp() {
        //
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        //
        return $this->specificMetadata->erp;
    }


    /**
     * Cette méthode permet de stocker en attribut toutes les métadonnées
     * nécessaire à l'ajout d'un document.
     */
    public function getSpecificMetadata() {
        if (isset($this->valF["dossier"]) AND $this->valF["dossier"] != "") {
            $dossier = $this->valF["dossier"];
        } else {
            $dossier = $this->getVal("dossier");
        }
        //Requête pour récupérer les informations essentiels sur le dossier d'instruction
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier.dossier AS dossier,
                    dossier_autorisation.dossier_autorisation AS dossier_autorisation, 
                    to_char(dossier.date_demande, \'YYYY/MM\') AS date_demande_initiale,
                    dossier_instruction_type.code AS dossier_instruction_type, 
                    etat_dossier_autorisation.libelle AS statut,
                    dossier_autorisation_type.code AS dossier_autorisation_type,
                    groupe.code AS groupe_instruction,
                    CASE WHEN dossier.erp IS TRUE
                        THEN \'true\'
                        ELSE \'false\'
                    END AS erp
                FROM
                    %1$sdossier 
                    LEFT JOIN %1$sdossier_instruction_type  
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    LEFT JOIN %1$sdossier_autorisation 
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation 
                    LEFT JOIN %1$setat_dossier_autorisation
                        ON  dossier_autorisation.etat_dossier_autorisation = etat_dossier_autorisation.etat_dossier_autorisation
                    LEFT JOIN %1$sdossier_autorisation_type_detaille
                        ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    LEFT JOIN %1$sdossier_autorisation_type
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                    LEFT JOIN %1$sgroupe
                        ON dossier_autorisation_type.groupe = groupe.groupe
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
                "mode" => DB_FETCHMODE_OBJECT
            )
        );
        
        //Le résultat est récupéré dans un objet
        $row = array_shift($qres['result']);

        //Si il y a un résultat
        if ($row !== null) {

            // Instrance de la classe dossier
            $inst_dossier = $this->get_inst_dossier($dossier);

            // Insère l'attribut version à l'objet
            $row->version = $inst_dossier->get_di_numero_suffixe();

            //Alors on créé l'objet dossier_instruction
            $this->specificMetadata = $row;

        }
    }
    
    /**
     * 
     * @return boolean
     */
    function is_instructeur(){
        
        //Si l'utilisateur est un instructeur
        if ($this->f->isUserInstructeur()){
            return true;
        }
        return false;
    }
    
    function is_editable(){
        // Impossible de modifier si la consultation est liée à un service Plat'AU
        $inst_service = $this->get_inst_service($this->getVal('service'));
        if ($inst_service->getVal('service_type') !== null
            && $inst_service->getVal('service_type') === PLATAU) {
            //
            return false;
        }

        // Si bypass
        if ($this->f->can_bypass("consultation", "modifier")){
            return true;
        }
        
        // Tester si le dossier est cloturé ,
        // et si l'instructeur est de la même division
        if ($this->is_instructeur_from_division_dossier() === true and
            $this->is_dossier_instruction_not_closed() === true) {
            return true;
        }
        return false;
    }
    
    function is_deletable(){
        // Impossible de supprimer si la tâche Plat'AU de la consultation a été consommée
        $inst_task_empty = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));
        $task_exists = $inst_task_empty->task_exists('creation_consultation', $this->getVal($this->clePrimaire));
        if ($task_exists !== false) {
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => $task_exists,
            ));
            // Si une tâche est lié à la consultation et qu'elle n'est pas à l'état
            // "new" la suppression de la consultation n'est pas possible.
            if ($inst_task->getVal('state') !== $inst_task::STATUS_NEW) {
                return false;
            }
        }

        // Suppression possible pour l'instructeur de la division si pas d'avis
        if ($this->is_dossier_instruction_not_closed() === true &&
            $this->is_instructeur_from_division_dossier() === true &&
            $this->getVal("avis_consultation") == "" &&
            $this->getVal('fichier') == ""
            ){
            return true;
        }
        
        // Si un avis a été rendu il faut que l'utilisateur ai le droit
        // specifique de suppression avec avis rendu et le bypass de division
        if ($this->getVal("avis_consultation") != "" or $this->getVal('fichier') != "") {
            
            if ($this->f->can_bypass("consultation", "supprimer") and
                $this->f->isAccredited("consultation_supprimer_avec_avis_rendu") == true){
                return true;
            }
        } else {
            // Si pas d'avis rendu, le bypass suffit
            if ($this->f->can_bypass("consultation", "supprimer")){
                return true;
            }
        }
        
        return false;
    }
    
    function is_multiaddable(){
        
        if ($this->f->can_bypass("consultation", "ajouter")){
            return true;
        }
        
        if ($this->is_instructeur_from_division_dossier() === true){
            return true;
        }
        return false;
    }
    
    function is_markable(){
        
        if($this->f->can_bypass("consultation", "modifier_lu")){
            return true;
        }
        
        if ($this->is_instructeur_from_division_dossier() === true){
            return true;
        }
        return false;
    }
    
    // Si la consultation est visible alors on peut afficher le lien pour la masquer
    function is_visible() {
        if($this->getVal("visible") == 't') {
            return true;
        }
        return false;
    }
    
    // Si la consultation n'est pas visible alors on peut afficher le lien pour l'afficher
    function is_not_visible() {
        if($this->getVal("visible") == 'f') {
            return true;
        }
        return false;
    }
    
    function is_finalizable(){
        // Vérifie si la variable contenant les informations nécessaire pour la
        // vérification est initialisé et si ce n'est pas le cas elle est initialisée
        if ($this->valElementConsulte == array()) {
            if (! $this->set_val_element_consulte()) {
                return false;
            }
        }

        // Vérifie si la génération d'édition est disponible pour le service / motif
        if ($this->valElementConsulte['generate_edition'] !== 't') {
            return false;
        }

        if($this->f->can_bypass("consultation", "finaliser")){
            return true;
        }
        
        if ($this->is_instructeur_from_division_dossier() === true &&
            $this->is_dossier_instruction_not_closed() === true){
            return true;
        }
        
        return false;
    }
    
    function is_unfinalizable(){
        // Vérifie si la variable contenant les informations nécessaire pour la
        // vérification est initialisé et si ce n'est pas le cas elle est initalisée
        if ($this->valElementConsulte == array()) {
            if (! $this->set_val_element_consulte()) {
                return false;
            }
        }

        if ($this->valElementConsulte['generate_edition'] !== 't') {
            return false;
        }

        if ($this->valElementConsulte['service_type'] === PLATAU) {
            return false;
        }

        if($this->f->can_bypass("consultation", "definaliser")){
            return true;
        }
        
        if ($this->is_instructeur_from_division_dossier() === true &&
            $this->is_dossier_instruction_not_closed() === true){
            return true;
        }
        
        return false;
    }

    /**
     * Cette méthode vérifie à l'aide d'une requête sql si des tiers ont été paramétrés.
     * Si c'est le cas on renvoie true sinon renvoie false.
     *
     * Si la requête échoue la méthode renverra false.
     * 
     * @return boolean
     */
    public function is_tiers_parametre() {
        // Récupère la requête de remplissage de la liste de sélection des tiers
        // consulté 
        $qres = $this->f->get_all_results_from_db_query(
            $this->get_var_sql_forminc__sql_tiers_consulte(),
            array(
                "origin" => __METHOD__
            )
        );
        // Récupère les résultats de la requête. Si on ne récupère pas de résultats ou
        // que la requête est en erreur renvoie false.
        // PP : vérification du retour de isDatabaseError sans activer le retour
        if ($qres['code'] !== 'OK') {
            return false;
        }
        if ($qres['row_count'] == 0) {
            return false;
        }
        // Si on a des résultats alors des tiers ont été paramétrés
        return true;
    }

    /*
     * CONDITION - can_show_or_hide_in_edition
     *
     * Vérifie que l'utilisateur possède la permission bypass.
     * Vérifie que l'utilisateur est un instructeur, qu'il fait partie de la
     * division du dossier et que le dossier n'est pas clôturé.
     *
     * Cette méthode est identique aux conditions dans consultation.inc.php
     * permettant l'affichage des actions depuis le listing des consultations.
     * Il est nécessaire que cette méthode ainsi que la condition if restent
     * concordants en tout point afin que le comportement des actions soit
     * identique depuis le formulaire et depuis le listing.
     *
     * @return boolean
     *
     */
    function can_show_or_hide_in_edition() {

        //
        if ($this->f->can_bypass("consultation", "visibilite_dans_edition") === true){
            return true;
        }
        
        // 
        if ($this->is_instructeur_from_division_dossier() === true and
            $this->is_dossier_instruction_not_closed() === true) {
            return true;
        }
        return false;
    }

    /*
     * CONDITION - can_user_access_dossier_contexte_ajout
     *
     * Vérifie que l'utilisateur a bien accès au dossier d'instruction passé dans le
     * formulaire d'ajout.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_ajout() {

        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $id_dossier = 
            $this->f->get_submitted_get_value('idxformulaire') : $id_dossier = "");
        //
        if ($id_dossier !== "") {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
    }

    /*
     * CONDITION - can_user_access_dossier_contexte_modification
     *
     * Vérifie que l'utilisateur a bien accès au dossier lié à la consultation.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_modification() {

        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $id_dossier = 
            $this->f->get_submitted_get_value('idxformulaire') : $id_dossier = "");

        if ($id_dossier != "") {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
    }

    /**
     * [is_viewable description]
     * @return boolean [description]
     */
    function is_viewable() {
        // Vérifie si la variable contenant les informations nécessaire pour la
        // vérification est initialisé et si ce n'est pas le cas elle est initalisée
        if ($this->valElementConsulte == array()) {
            if (! $this->set_val_element_consulte()) {
                return false;
            }
        }
        if ($this->valElementConsulte['generate_edition'] !== 't') {
            return false;
        }

        return true;
    }

    /**
     * Indique si la redirection vers le lien de retour est activée ou non.
     *
     * L'objectif de cette méthode est de permettre d'activer ou de désactiver
     * la redirection dans certains contextes.
     *
     * @return boolean
     */
    function is_back_link_redirect_activated() {
        //
        if ($this->getParameter("maj") == 100) {
            //
            return false;
        }
        //
        return true;
    }

    // XXX WIP
    public function get_json_data() {
        $val = array_combine($this->champs, $this->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        return $val;
    }

    protected function getDocumentType($champ = null) {
        $serviceId = $this->getVal('service');
        if (empty($serviceId) && isset($this->valF['service'])) {
            $serviceId = $this->valF['service'];
        }
        if (! empty($serviceId)) {
            $service = $this->f->findObjectById('service', $serviceId);
            if (! empty($service)) {
                return __("Consultation").':'.$service->getVal('libelle');
            }
        }
        return parent::getDocumentType();
    }

    /**
     * Affiche la page de téléchargement du document de la notification.
     *
     * @param boolean $content_only Affiche le contenu seulement.
     *
     * @return void
     */
    public function view_telecharger_document_anonym() {
        // Par défaut on considère qu'on va afficher le formulaire
        $idx = 0;
        // Flag d'erreur
        $error = false;
        // Message d'erreur
        $message = '';

        // Paramètres GET : récupération de la clé d'accès
        $cle_acces_document = $this->f->get_submitted_get_value('key');
        $cle_acces_document = $this->f->db->escapeSimple($cle_acces_document);
        // Vérification de l'existence de la clé et récupération de l'uid du fichier
        $uidFichier = $this->getUidDocumentConsultationWithKey($cle_acces_document);
        if ($uidFichier != null) {
            // Récupération du document
            $file = $this->f->storage->get($uidFichier);

            // Headers
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date dans le passé
            header("Content-Type: ".$file['metadata']['mimetype']);
            header("Accept-Ranges: bytes");
            header("Content-Disposition: inline; filename=\"".$file['metadata']['filename']."\";" );
            // Affichage du document
            echo $file['file_content'];

            // Récupération de la date de premier accès et maj du suivi uniquement
            // si la date de 1er accès n'a pas encore été remplis
            $inst_notif = $this->getInstanceNotificationWithKey($cle_acces_document);
            if ($inst_notif->getVal('date_premier_acces') == null ||
                $inst_notif->getVal('date_premier_acces') == '') {
                $notif_val = array();
                foreach ($inst_notif->champs as $champ) {
                    $notif_val[$champ] = $inst_notif->getVal($champ);
                }
                $notif_val['date_premier_acces'] = date("d/m/Y H:i:s");
                $notif_val['statut'] = 'vu';
                $notif_val['commentaire'] = 'Le document a été vu';
                $suivi_notif = $inst_notif->modifier($notif_val);
            }

        } else {
            // Page vide 404
            printf('Ressource inexistante');
            header('HTTP/1.0 404 Not Found');
        }
    }
    /**
     * Récupère une clé et renvoie l'uid du document liée à cette
     * clé. Si la clé n'existe pas renvoie null.
     * 
     * @param string $cleGen clé dont on cherche l'instruction
     * @return integer|null 
     */
    protected function getUidDocumentConsultationWithKey($cleGen) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    consultation.fichier
                FROM
                    %1$sinstruction_notification_document
                    LEFT JOIN %1$sconsultation
                        ON instruction_notification_document.document_id = consultation.consultation
                WHERE
                    instruction_notification_document.cle = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($cleGen)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

    /**
     * Récupère une clé, fait une requête pour récupérer l'id de la notification liée a cette clé.
     * Récupère l'instance de instruction_notification dont l'id a été récupéré et la renvoie.
     * 
     * @param string $cleGen
     * @return instruction_notification
     */
    protected function getInstanceNotificationWithKey($key) {
        // TODO : refactoriser pour éviter d'avoir a réecrire cette méthode dans chaque classe
        // a laquelle la consultation anonyme des documents est associée
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    instruction_notification
                FROM
                    %1$sinstruction_notification_document
                WHERE
                    cle = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($key)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Récupération de l'instance de notification
        $instNotif = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction_notification",
            "idx" => $qres["result"],
        ));
        return $instNotif;
    }


    /**
     * Vérifie la validité des valeurs en mode CREATE & UPDATE.
     * (Surcharge)
     *
     * Les consultations pouvant être des consultations
     * de tiers ou de service selon le type de consultations
     * certain champs ne doivent pas être null.
     * Consultation tiers :
     *  - categorie tiers consulte
     *  - tiers consulte
     *  - motif consultation
     * Consultation service :
     *  - service
     * Cette surcharge permet de vérifier que selon le contexte
     * les valeurs voulues sont bien renseigné.
     *
     * @param array $val Tableau des valeurs brutes.
     * @param null &$dnu1 @deprecated  Ne pas utiliser.
     * @param null $dnu2 @deprecated  Ne pas utiliser.
     *
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        // Ajout des champs concerné à la liste des champs requis
        // pour que la vérification de présence des champs requis se fasse aussi
        // sur ces champs
        $maj = $this->getParameter("maj");
        $champsNonNull = array();
        // Action liées à l'ajout et la modification de consultation d'un service
        if ($maj == '0' || ($maj == '1' && ($this->getVal('service') != null && $this->getVal('service') != ''))) {
            $champsNonNull = array('service');
        } elseif ($maj == '41'|| ($maj == '1' && ($this->getVal('tiers_consulte') != null && $this->getVal('tiers_consulte') != ''))) {
            // Actions liées à l'ajout et la modification de consultation d'un tiers
            $champsNonNull = array('categorie_tiers_consulte', 'tiers_consulte', 'motif_consultation');
        }
        foreach($champsNonNull as $champs) {
            $this->required_field[] = $champs;
        }
        parent::verifier($val, $dnu1, $dnu2);
    }

    /** 
     * Vérifie lors de l'ajout de consultation d'un tiers,
     * que la liste des catégories de tiers
     * correspond aux services (collectivités)
     * du dossier d'instruction en cours.
     * (Surcharge)
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers_consulte() {
        return sprintf(
            'SELECT DISTINCT 
                categorie_tiers_consulte.categorie_tiers_consulte, 
                categorie_tiers_consulte.libelle 
            FROM 
                %1$scategorie_tiers_consulte 
                INNER JOIN %1$slien_categorie_tiers_consulte_om_collectivite 
                    ON lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte = categorie_tiers_consulte.categorie_tiers_consulte
                INNER JOIN %1$som_collectivite
                    ON om_collectivite.om_collectivite = lien_categorie_tiers_consulte_om_collectivite.om_collectivite AND 
                    om_collectivite.om_collectivite = <om_collectivite_idx>
            WHERE 
                ((categorie_tiers_consulte.om_validite_debut IS NULL AND 
                (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)) OR (categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE AND 
                (categorie_tiers_consulte.om_validite_fin IS NULL OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE))) 
            ORDER BY categorie_tiers_consulte.libelle ASC',
            DB_PREFIXE
        );
    }

}// fin classe
