<?php
/**
 * DBFORM - 'instruction' - Surcharge gen.
 *
 * specific :
 * - cle secondaire
 *   destruction autorisée que pour le dernier evenement
 *     [delete the last event ]
 * - variable globale [global variables]
 *     var $retourformulaire;
 *     var $idxformulaire;
 * - modification des données dans dossier trigger avant
 * [modify dossier data with trigger function]
 * - function mois_date : pour ajouter des mois a une date
 *   [add months (delay) and calculation final date]
 * - voir script_lang.js : bible ...
 *
 * @package openfoncier
 * @version SVN : $Id$
 */

//
require_once "../gen/obj/instruction.class.php";

//
class instruction extends instruction_gen {
    
    // Champs contenant les UID des fichiers
    var $abstract_type = array(
        "om_fichier_instruction" => "file",
    );

    var $valEvenement;
    var $restriction_valid = null;
    // Tableau contenant une partie des métadonnées arrêtés
    var $metadonneesArrete;

    /**
     * Instance de la classe dossier
     *
     * @var mixed
     */
    var $inst_dossier = null;

    /**
     * Instance de la classe instructeur
     *
     * @var mixed
     */
    var $inst_instructeur = null;

    /**
     * Instance de la classe om_utilisateur
     *
     * @var mixed
     */
    var $inst_om_utilisateur = null;

    var $metadata = array(
        "om_fichier_instruction" => array(
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

            'date_cloture_metier' => 'getDossierDateDecision',
            'type' => 'getDocumentType',
            'dossier_autorisation_type_detaille' => 'getDossierAutorisationTypeDetaille',
            'dossier_instruction_type' => 'getDossierInstructionTypeLibelle',
            'region' => 'getDossierRegion',
            'departement' => 'getDossierDepartement',
            'commune' => 'getDossierCommune',
            'annee' => 'getDossierAnnee',
            'division' => 'getDossierDivision',
            'collectivite' => 'getDossierServiceOrCollectivite',
        ),
        "arrete" => array(
            "numArrete" => "getNumArrete",
            "ReglementaireArrete" => "getReglementaireArrete",
            "NotificationArrete" => "getNotificationArrete",
            "dateNotificationArrete" => "getDateNotificationArrete",
            "controleLegalite" => "getControleLegalite",
            "dateSignature" => "getDateSignature",
            "nomSignataire" => "getNomSignataire",
            "qualiteSignataire" => "getQualiteSignataire",
            "ap_numRue" => "getAp_numRue",
            "ap_nomDeLaVoie" => "getAp_nomDeLaVoie",
            "ap_codePostal" => "getAp_codePostal",
            "ap_ville" => "getAp_ville",
            "activite" => "getActivite",
            "dateControleLegalite" => "getDateControleLegalite",
        )
    );

    /**
     * Flag pour identifier la reprise de l'instruction d'un dossier.
     * Le statut de l'état passe de "cloture" à "encours".
     *
     * @var boolean
     */
    var $di_reopened = null;

    // {{{ Gestion de la confidentialité des données spécifiques
    
    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        parent::init_class_actions();

        // ACTION - 000 - ajouter
        // Modifie la condition d'affichage du bouton ajouter
        $this->class_actions[0]["condition"] = array("is_addable", "can_user_access_dossier_contexte_ajout");

        // ACTION - 001 - modifier
        // Modifie la condition et le libellé du bouton modifier
        $this->class_actions[1]["condition"] = array(
            "is_editable",
            "is_finalizable_without_bypass",
            "can_user_access_dossier_contexte_modification",
            "is_evenement_modifiable",
        );
        $this->class_actions[1]["portlet"]["libelle"] = _("Modifier");
        
        // ACTION - 002 - supprimer
        // Modifie la condition et le libellé du bouton supprimer
        $this->class_actions[2]["condition"] = array(
            "is_deletable",
            "is_finalizable_without_bypass",
            "can_user_access_dossier_contexte_modification",
            "is_evenement_supprimable",
        );
        $this->class_actions[2]["portlet"]["libelle"] = _("Supprimer");

        // ACTION - 003 - consulter
        // 
        $this->class_actions[3]["condition"] = "can_user_access_dossier_contexte_modification";

        // ACTION - 100 - finaliser
        // Finalise l'enregistrement
        $this->class_actions[100] = array(
            "identifier" => "finaliser",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Finaliser le document"),
                "order" => 110,
                "class" => "finalise",
            ),
            "view" => "formulaire",
            "method" => "finalize",
            "button" => "finaliser",
            "permission_suffix" => "finaliser",
            "condition" => array(
                "is_finalizable",
                "is_finalizable_without_bypass",
                "has_an_edition",
                "can_user_access_dossier_contexte_modification",
            ),
        );

        // ACTION - 110 - definaliser
        // Finalise l'enregistrement
        $this->class_actions[110] = array(
            "identifier" => "definaliser",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Reprendre la redaction du document"),
                "order" => 110,
                "class" => "definalise",
            ),
            "view" => "formulaire",
            "method" => "unfinalize",
            "button" => "definaliser",
            "permission_suffix" => "definaliser",
            "condition" => array(
                "is_unfinalizable",
                "is_unfinalizable_without_bypass",
                "can_user_access_dossier_contexte_modification",
                "is_not_sent_for_signature",
                "is_not_signed",
            ),
        );

        // ACTION - 115 - Modification d'un document généré par une instruction
        // Permet à un instructeur de modifier un document généré par une instruction
        $this->class_actions[115] = array(
            "identifier" => "modale_selection_document_signe",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => _("Remplacer par le document signé"),
                "order" => 115,
                "class" => "selection-document-signé",
            ),
            "view" => "view_modale_selection_document_signe",
            "permission_suffix" => "selection_document_signe",
            "condition" => array(
                "is_finalized",
                "is_not_date_retour_signature_set",
            ),
        );

        // ACTION - 120 - edition
        // Affiche l'édition
        $this->class_actions[120] = array(
            "identifier" => "edition",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("Edition"),
                "order" => 100,
                "class" => "pdf-16",
            ),
            "view" => "view_edition",
            "condition" => array("has_an_edition", "can_user_access_dossier_contexte_modification"),
            "permission_suffix" => "om_fichier_instruction_telecharger",
        );

        // ACTION - 125 - modifier_suivi
        // Suivi des dates
        $this->class_actions[125] = array(
            "identifier" => "modifier_suivi",
            "portlet" => array(
                "type" => "action-self",
                "libelle" => _("Suivi des dates"),
                "order" => 125,
                "class" => "suivi-dates-16",
            ),
            "crud" => "update",
            "condition" => array("can_monitoring_dates", "can_user_access_dossier_contexte_modification"),
            "permission_suffix" => "modification_dates",
        );

        // ACTION - 130 - bible
        // Affiche la bible
        $this->class_actions[130] = array(
            "identifier" => "bible",
            "view" => "view_bible",
            "permission_suffix" => "modifier",
        );

        // ACTION - 140 - bible_auto
        // Active la bible automatique
        $this->class_actions[140] = array(
            "identifier" => "bible_auto",
            "view" => "view_bible_auto",
            "permission_suffix" => "modifier",
        );

        // ACTION - 150 - suivi_bordereaux
        // Imprimer un bordereau d'envoi
        $this->class_actions[150] = array(
            "identifier" => "suivi_bordereaux",
            "view" => "view_suivi_bordereaux",
            "permission_suffix" => "consulter",
        );

        // ACTION - 160 - suivi_envoi_lettre_rar
        // Imprimer un bordereau d'envoi
        $this->class_actions[160] = array(
            "identifier" => "suivi_envoi_lettre_rar",
            "view" => "view_suivi_envoi_lettre_rar",
            "permission_suffix" => "consulter",
        );

        // ACTION - 170 - suivi_mise_a_jour_des_dates
        // Mettre à jour les dates de l'instruction
        $this->class_actions[170] = array(
            "identifier" => "suivi_mise_a_jour_des_dates",
            "view" => "view_suivi_mise_a_jour_des_dates",
            "permission_suffix" => "consulter",
        );

        // ACTION - 175 - edit_by_notification_task
        // Action à utiliser lors de la mise à jour des instructions par notification
        $this->class_actions[175] = array(
            "identifier" => "edit_by_notification_task",
            "view" => "formulaire",
            "permission_suffix" => "modifier",
            "crud" => "update",
        );

        // ACTION - 176 - add_by_evenement_retour_after_notification_task
        // Action à utiliser lors de l'ajout des instructions par événement suivant
        // suite à une notification par tâche (donc notification dématerialisée)
        $this->class_actions[176] = array(
            "identifier" => "add_by_evenement_retour_after_notification_task",
            "view" => "formulaire",
            "permission_suffix" => "ajouter",
            "crud" => "create",
        );

        // ACTION - 180 - pdf_lettre_rar
        // Génère PDF sur bordereaux de lettres AR
        $this->class_actions[180] = array(
            "identifier" => "pdf_lettre_rar",
            "view" => "view_pdf_lettre_rar",
            "permission_suffix" => "consulter",
        );

        // ACTION - 190 - bordereau_envoi_maire
        // Formulaire pour générer le bordereau d'envoi au maire
        // Met à jour la date d'envoi à signature du maire
        $this->class_actions[190] = array(
            "identifier" => "bordereau_envoi_maire",
            "view" => "view_bordereau_envoi_maire",
            "permission_suffix" => "bordereau_envoi_maire",
        );

        // ACTION - 200 - generate_bordereau_envoi_maire
        // Génère PDF bordereau d'envoi au maire
        $this->class_actions[200] = array(
            "identifier" => "generate_bordereau_envoi_maire",
            "view" => "view_generate_bordereau_envoi_maire",
            "permission_suffix" => "bordereau_envoi_maire",
        );

        // ACTION - 210 - notifier_commune
        // Notifie la commune par mail d'un évément d'instruction finalisé
        $this->class_actions[210] = array(
            "identifier" => "notifier_commune",
            "portlet" => array(
                "type" => "action-direct-with-confirmation",
                "libelle" => _("Notifier la commune par courriel"),
                "order" => 210,
                "class" => "notifier_commune-16",
            ),
            "view" => "formulaire",
            "method" => "notifier_commune",
            "permission_suffix" => "notifier_commune",
            "condition" => array("is_notifiable", "can_user_access_dossier_contexte_modification"),
        );

        // ACTION - 220 - generate_suivi_bordereaux 
        // GÃ©nÃšre PDF bordereaux  
        $this->class_actions[220] = array( 
            "identifier" => "generate_suivi_bordereaux", 
            "view" => "view_generate_suivi_bordereaux", 
            "permission_suffix" => "consulter",
        );

        // ACTION - 777 - pdf_temp
        // Crée un PDF temporaire et affiche son contenu en base64
        $this->class_actions[777] = array(
            "identifier" => "pdf_temp",
            "view" => "view_pdf_temp",
            "permission_suffix" => "modifier",
            "condition" => array("can_user_access_dossier_contexte_modification"),
        );

        // ACTION - 701
        $this->class_actions[701] = array(
            "identifier" => "enable-edition-integrale",
            "portlet" => array(
                "type" => "action-direct-with-confirmation",
                "libelle" => _("Rédaction libre"),
                "order" => 50,
                "class" => "redac-libre-16",
            ),
            "view" => "formulaire",
            "method" => "enable_edition_integrale",
            "permission_suffix" => "modifier",
            "condition" => array(
                "is_editable",
                "is_finalizable_without_bypass",
                "can_user_access_dossier_contexte_modification",
                "is_edition_integrale_not_enabled",
                "is_option_redaction_libre_enabled",
                "has_an_edition",
            ),
        );
        // ACTION - 702
        $this->class_actions[702] = array(
            "identifier" => "disable-edition-integrale",
            "portlet" => array(
                "type" => "action-direct-with-confirmation",
                "libelle" => _("Rédaction par compléments"),
                "order" => 50,
                "class" => "redac-complement-16",
            ),
            "view" => "formulaire",
            "method" => "disable_edition_integrale",
            "permission_suffix" => "modifier",
            "condition" => array(
                "is_editable",
                "is_finalizable_without_bypass",
                "can_user_access_dossier_contexte_modification",
                "is_edition_integrale_enabled",
                "is_option_redaction_libre_enabled",
                "has_an_edition",
            ),
        );
        // ACTION - 300 - evenement_has_an_edition_json
        //
        $this->class_actions[300] = array(
            "identifier" => "evenement_has_an_edition_json",
            "view" => "view_evenement_has_an_edition_json",
            "permission_suffix" => "consulter",
        );

        // ACTION - 301 - evenement_has_a_commentaire
        //
        $this->class_actions[301] = array(
            "identifier" => "evenement_has_a_commentaire_json",
            "view" => "view_evenement_has_a_commentaire_json",
            "permission_suffix" => "consulter",
        );

        // ACTION - 400 - Envoyer en signature
        // Cet évenement permet d'envoyer le document au parapheur pour signature 
        $this->class_actions[400] = array(
            "identifier" => "envoyer_a_signature",
            "portlet" => array(
                "libelle" => _("Envoyer à signature"),
                "type" => "action-direct-with-confirmation",
                "class" => "envoyer_a_signature-16",
            ),
            "view" => "formulaire",
            "method" => "envoyer_a_signature_sans_relecture",
            "condition" => array(
                "can_be_signed",
            ),
            "permission_suffix" => "envoyer_a_signature",
        );

        // ACTION - 402 - Envoyer en signature avec relecture
        // Cet évenement permet d'envoyer le document au parapheur pour signature
        $this->class_actions[402] = array(
            "identifier" => "envoyer_a_signature_relecture",
            "portlet" => array(
                "libelle" => __("Envoyer à signature avec relecture"),
                "type" => "action-direct-with-confirmation",
                "class" => "envoyer_a_signature-16",
            ),
            "view" => "formulaire",
            "method" => "envoyer_a_signature_avec_relecture",
            "condition" => array(
                "can_be_signed",
                "is_parapheur_relecture_parameter_enabled"
            ),
            "permission_suffix" => "envoyer_a_signature",
        );

        // ACTION - 404 - Annuler l'envoi en signature
        // Cet évenement permet d'annuler l'envoi en signature du document au parapheur
        $this->class_actions[404] = array(
            "identifier" => "annuler_envoi_signature",
            "portlet" => array(
                "libelle" => __("Annuler l'envoi en signature"),
                "type" => "action-direct-with-confirmation",
                "class" => "annuler_envoi_signature-16",
            ),
            "view" => "formulaire",
            "method" => "annuler_envoi_en_signature",
            "condition" => array(
                "is_sent_for_signature",
                "is_parapheur_annulation_parameter_enabled"
            ),
            "permission_suffix" => "envoyer_a_signature",
        );

        //
        $this->class_actions[401] = array(
            "identifier" => "preview_edition",
            "view" => "formulaire",
            "permission_suffix" => "tab",
        );

        // ACTION - 410 - Notifier les pétitionnaires (mail ou autre)
        $this->class_actions[410] = array(
            "identifier" => "overlay_notification_manuelle",
            "portlet" => array(
                "libelle" => __("Notifier les pétitionnaires"),
                "type" => "action-self",
                "class" => "notifier_commune-16",
            ),
            "condition" => array(
                "is_notifiable_by_task_manual",
                "is_not_portail_notification_sans_annexe"
            ),
            "view" => "view_overlay_notification_manuelle",
            "permission_suffix" => "modifier",
        );

        // ACTION - 411 - Notifier les pétitionnaires (portail citoyen)
        $this->class_actions[411] = array(
            "identifier" => "notification_manuelle_portal",
            "portlet" => array(
                "libelle" => __("Notifier les pétitionnaires"),
                "type" => "action-direct-with-confirmation",
                "class" => "notifier_commune-16",
            ),
            "condition" => array(
                "is_notifiable_by_task_manual",
                "is_portail_notification_sans_annexe"
            ),
            "method" => "notifier_demandeur_principal_via_portal",
            "permission_suffix" => "modifier",
        );

        // ACTION - 420 - Notifier les services consultés (mail)
        $this->class_actions[420] = array(
            "identifier" => "overlay_notification_service_consulte",
            "portlet" => array(
                "libelle" => __("Notifier les services consultés"),
                "type" => "action-self",
                "class" => "notifier_commune-16",
            ),
            "condition" => array(
                "is_service_notifiable"
            ),
            "view" => "view_overlay_notification_service_consulte",
            "permission_suffix" => "tab",
        );

        // ACTION - 430 - Notifier les tiers consultés (mail)
        $this->class_actions[430] = array(
            "identifier" => "overlay_notification_tiers_consulte",
            "portlet" => array(
                "libelle" => __("Notifier les tiers consultés"),
                "type" => "action-self",
                "class" => "notifier_commune-16",
            ),
            "condition" => array(
                "is_tiers_notifiable"
            ),
            "view" => "view_overlay_notification_tiers_consulte",
            "permission_suffix" => "tab",
        );

        //
        $this->class_actions[403] = array(
            "identifier" => "envoyer_au_controle_de_legalite",
            "portlet" => array(
                "libelle" => __("Envoyer au contrôle de légalité"),
                "type" => "action-direct-with-confirmation",
                "class" => "envoyer_au_controle_de_legalite-16",
            ),
            "view" => "formulaire",
            "method" => "envoyer_au_controle_de_legalite",
            "condition" => array(
                "can_be_sended_to_cl"
            ),
            "permission_suffix" => "envoyer_au_controle_de_legalite",
        );

        //
        $this->class_actions[998] = array(
            "identifier" => "json_data",
            "view" => "view_json_data",
            "permission_suffix" => "consulter",
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "instruction",
            "destinataire",
            "instruction.evenement",
            "instruction.commentaire",
            "date_evenement",
            "instruction.lettretype",
            "signataire_arrete",
            "flag_edition_integrale",
            "om_final_instruction_utilisateur",
            "date_finalisation_courrier",
            "date_envoi_signature",
            "date_retour_signature",
            "date_envoi_rar",

            "date_retour_rar",
            "date_envoi_controle_legalite",
            "date_retour_controle_legalite",

            "numero_arrete",

            "complement_om_html",
            "'' as bible_auto",
            "'' as bible",
            "complement2_om_html",
            "'' as bible2",
            "complement3_om_html",
            "'' as bible3",
            "complement4_om_html",
            "'' as bible4",

            "titre_om_htmletat",
            "corps_om_htmletatex",

            "'' as btn_preview",
            "'' as btn_redaction",

            "'' as btn_refresh",
            "'' as live_preview",

            "dossier",
            "instruction.action",
            "instruction.delai",
            "instruction.etat",
            "instruction.autorite_competente",
            "instruction.accord_tacite",
            "instruction.delai_notification",
            "instruction.avis_decision",
            "archive_delai",
            "archive_accord_tacite",
            "archive_etat",
            "archive_avis",
            "archive_date_complet",
            "archive_date_rejet",
            "archive_date_limite",
            "archive_date_notification_delai",
            "archive_date_decision",
            "archive_date_validite",
            "archive_date_achevement",
            "archive_date_conformite",
            "archive_date_chantier",
            "archive_date_dernier_depot",
            "date_depot",
            "date_depot_mairie",
            "complement5_om_html",
            "'' as bible5",
            "complement6_om_html",
            "'' as bible6",
            "complement7_om_html",
            "'' as bible7",
            "complement8_om_html",
            "'' as bible8",
            "complement9_om_html",
            "'' as bible9",
            "complement10_om_html",
            "'' as bible10",
            "complement11_om_html",
            "'' as bible11",
            "complement12_om_html",
            "complement13_om_html",
            "complement14_om_html",
            "complement15_om_html",
            "archive_incompletude",
            "archive_incomplet_notifie",
            "archive_evenement_suivant_tacite",
            "archive_evenement_suivant_tacite_incompletude",
            "archive_etat_pendant_incompletude",
            "archive_date_limite_incompletude",
            "archive_delai_incompletude",
            "archive_autorite_competente",
            "code_barres",
            "om_fichier_instruction",
            "om_final_instruction",
            "om_fichier_instruction_dossier_final",
            "document_numerise",
            "duree_validite_parametrage",
            "duree_validite",
            "created_by_commune",
            "archive_date_cloture_instruction",
            "archive_date_premiere_visite",
            "archive_date_derniere_visite",
            "archive_date_contradictoire",
            "archive_date_retour_contradictoire",
            "archive_date_ait",
            "archive_date_transmission_parquet",
            "archive_dossier_instruction_type",
            "archive_date_affichage",
            "pec_metier",
            "archive_pec_metier",
            "archive_a_qualifier",
            "id_parapheur_signature",
            "statut_signature",
            "commentaire_signature",
            "historique_signature",
            "'' as suivi_notification",
            "'' as suivi_notification_service",
            "'' as suivi_notification_tiers",
            "'' as suivi_notification_commune",

            "'' as preview_edition",
            "envoye_cl_platau",
            "'' as log_instruction",
            "parapheur_lien_page_signature"
        );
    }

    /**
     * CONDITION - is_edition_integrale_enabled
     *
     * Vérifie que la rédaction libre est activée sur l'instruction en cours.
     *
     * @return boolean
     */
    function is_edition_integrale_enabled() {
        if ($this->getVal("flag_edition_integrale") == 't') {
            return true;
        }
        return false;
    }

    /**
     * CONDITION - is_edition_integrale_not_enabled
     *
     * Vérifie que la rédaction libre est désactivée sur l'instruction en cours.
     *
     * @return boolean
     */
    function is_edition_integrale_not_enabled() {
        return !$this->is_edition_integrale_enabled();
    }

    /**
     * CONDITION - is_option_redaction_libre_enabled
     *
     * Vérifie que l'option de rédaction libre est activée.
     *
     * @return boolean
     */
    function is_option_redaction_libre_enabled() {
        $collectivite_di = $this->get_dossier_instruction_om_collectivite();
        return $this->f->is_option_redaction_libre_enabled($collectivite_di);
    }

    /**
     * CONDITION - is_option_parapheur_relecture_enabled
     *
     * Vérifie que l'option de relecture lors de l'envoi en signature est activée.
     *
     * @return boolean
     */
    function is_parapheur_relecture_parameter_enabled() {
        //Instanciation de la classe electronicsignature
        $inst_es = $this->get_electronicsignature_instance();
        if ($inst_es === false) {
            return false;
        }

        if ($inst_es->get_conf('is_forced_view_files') !== 'true' && $inst_es->get_conf('is_forced_view_files') !== true) {
            return false;
        }

        return true;
    }

    /**
     * CONDITION - is_parapheur_annulation_parameter_enabled
     *
     * Vérifie que l'option d'annulation de l'envoi en signature est activée.
     *
     * @return boolean
     */
    function is_parapheur_annulation_parameter_enabled() {
        //Instanciation de la classe electronicsignature
        $inst_es = $this->get_electronicsignature_instance();
        if ($inst_es === false) {
            return false;
        }

        if ($inst_es->get_conf('cancel_send') !== 'true' && $inst_es->get_conf('cancel_send') !== true) {
            return false;
        }

        return true;
    }


    /**
     * CONDITION - is_sent_for_signature
     *
     * Vérifie que l'instruction a été envoyé à signature
     *
     * @return boolean
     */
    function is_sent_for_signature() {
        // Si un parapheur a été configuré
        // et que le champ id_parapheur_signature n'est pas vide
        // que le status est différent de "canceled" ou "expired"
        // alors l'évènement a été envoyé en signature
        if ($this->has_connector_electronicsignature() === true 
            && empty($this->getVal("id_parapheur_signature")) === false
            && ($this->getVal("statut_signature") != "canceled" 
            && $this->getVal("statut_signature") != "expired"
            && $this->getVal("statut_signature") != "finished")) {
            //
            return true;
        }

        return false;
    }

    /**
     * CONDITION - is_not_sent_for_signature
     *
     * Vérifie que l'instruction n'a pas été envoyé à signature
     *
     * @return boolean
     */
    function is_not_sent_for_signature() {
        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_definaliser_bypass");
        if ($bypass == true) {
            return true;
        }

        return !$this->is_sent_for_signature();
    }


    /**
     * CONDITION - is_signed
     *
     * Vérifie que l'instruction a été signé
     *
     * @return boolean
     */
    function is_signed() {
        // Si un parapheur a été configuré
        // et que le champ id_parapheur_signature n'est pas vide
        //  et que le statut est égal à "finished"
        // alors le document de l'instruciton à été signé
        if ($this->has_connector_electronicsignature() === true 
            && empty($this->getVal("id_parapheur_signature")) === false
            && $this->getVal("statut_signature") == "finished") {
            //
            return true;
        }

        return false;
    }

    /**
     * CONDITION - is_signed
     *
     * Vérifie que l'instruction n'a pas été signée
     *
     * @return boolean
     */
    function is_not_signed() {
        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_definaliser_apres_signature");
        if ($bypass == true) {
            return true;
        }

        return !$this->is_signed();
    }


    /**
     * is_sent_to_cl
     *
     * Vérifie que l'instruction a été envoyé au contrôle de légalité
     *
     * @return boolean
     */
    function is_sent_to_cl() {
        // Si la case à cocher de l'instruction envoye_cl_platau est à "t"
        if ($this->getVal('envoye_cl_platau') === 't') {
            //
            return true;
        }
        //
        return false;
    }

    /**
     * CONDITION - is_portail_notification
     *
     * Vérifie si la notification est une notification de catégorie portail
     *
     * @return boolean
     */
    function is_portail_notification_sans_annexe() {
        $collectiviteDi = $this->get_dossier_instruction_om_collectivite();
        $ev = $this->get_inst_evenement($this->getVal('evenement'));
        if ($this->f->get_param_option_notification($collectiviteDi) === PORTAL
            && $ev->getVal('notification') != 'notification_manuelle_annexe'
            && $ev->getVal('notification') != 'notification_manuelle_annexe_signature_requise'
        ) {
            return true;
        }
        return false;
    }

    /**
     * CONDITION - is_not_portail_notification
     *
     * Vérifie si la notification n'est pas une notification de catégorie portail
     *
     * @return boolean
     */
    function is_not_portail_notification_sans_annexe() {
        return (! $this->is_portail_notification_sans_annexe());
    }

    /**
     * CONDITION - can_be_signed
     *
     * Vérifie que le document de l'instruction peut être envoyé au parapheur pour signature
     *
     * @return boolean
     */
    function can_be_signed() {
        // Instanciation de l'objet signataire_arrete
        $inst_signataire_arrete = $this->f->get_inst__om_dbform(array(
            "obj" => "signataire_arrete",
            "idx" => $this->getVal("signataire_arrete"),
        ));
        // Si un parapheur a été configuré, que le document est finalisé, que le signataire 
        // possède une adresse email, on vérifie le champ id_parapheur_signature
        // S'il est vide l'évènement peut être envoyé en signature
        // S'il ne l'est pas, alors on vérifie le champ statut_signature 
        // Si la valeur de ce champ est égal à "canceled" ou "expired"
        // alors l'évènement peut être envoyé en signature
        if ($this->has_connector_electronicsignature() === true
            && $this->getVal("om_final_instruction") == 't'
            && empty($inst_signataire_arrete->getVal('email')) === false) {
            //
            if (empty($this->getVal("id_parapheur_signature")) === true
                || $this->getVal("statut_signature") == "canceled" 
                || $this->getVal("statut_signature") == "expired") {
                //
                return true;
            }
        }

        $this->addToLog(__METHOD__."() has_connector_electronicsignature: ".var_export($this->has_connector_electronicsignature(), true), EXTRA_VERBOSE_MODE);
        $this->addToLog(__METHOD__."() om_final_instruction: ".var_export($this->getVal("om_final_instruction"), true), EXTRA_VERBOSE_MODE);
        $this->addToLog(__METHOD__."() email: ".var_export($inst_signataire_arrete->getVal('email'), true), EXTRA_VERBOSE_MODE);
        $this->addToLog(__METHOD__."() id_parapheur_signature: ".var_export($this->getVal("id_parapheur_signature"), true), EXTRA_VERBOSE_MODE);
        $this->addToLog(__METHOD__."() statut_signature: ".var_export($this->getVal("statut_signature"), true), EXTRA_VERBOSE_MODE);

        return false;
    }

    /**
     * CONDITION - has_connector_electronicsignature
     *
     * Vérifie qu'un parapheur est paramétré
     *
     * @return boolean
     */
    function has_connector_electronicsignature() {
        $inst_es = $this->get_electronicsignature_instance(false);
        if ($inst_es === false) {
            return false;
        }
        return true;
    }

    /**
     * CONDITION - can_display_parapheur
     *
     * Vérifie que le fieldset "Suivi Parapheur" soit affichable 
     *
     * @return boolean
     */
    function can_display_parapheur() {
        $evenement_id = $this->getVal("evenement");
        $inst_evenement = $this->get_inst_evenement($evenement_id);
        if ($this->has_connector_electronicsignature() === true
            && $inst_evenement->getVal('lettretype') !== ''
            && $inst_evenement->getVal('lettretype') !== null
            && (empty($this->getVal("id_parapheur_signature")) === false
                || empty($this->getVal("historique_signature")) === false)) {
            //
            return true;
        }

        return false;
    }

    /**
     * CONDITION - can_display_notification
     *
     * Vérifie que le champs "Suivi notification" est affichable
     *
     * @return boolean
     */
    function can_display_notification_demandeur() {
        // Le suivi des notification est affiché si l'événement est notifiable
        // et si des notifications ont été envoyées
        $evenement_id = $this->getVal("evenement");
        $inst_evenement = $this->get_inst_evenement($evenement_id);
        if ($inst_evenement->getVal('notification') != null &&
            $inst_evenement->getVal('notification') != '') {
            // Des notifications ont été envoyé si il existe au moins une notification
            // liées à l'instruction
            $idsNotifs = $this->get_instruction_notification(
                $this->getVal($this->clePrimaire),
                array(
                    'notification_recepisse',
                    'notification_instruction',
                    'notification_decision',
                ),
                true
            );
            if (isset($idsNotifs) && $idsNotifs !== array()) {
                return true;
            }
        }
        return false;
    }

    /**
     * CONDITION - can_display_notification
     *
     * Vérifie que le champs "suivi_notification_service" est affichable
     *
     * @return boolean
     */
    function can_display_notification_service() {
        // Le suivi des notification est affiché si l'événement est notifiable
        // et si des notifications ont été envoyées
        $evenement_id = $this->getVal("evenement");
        $inst_evenement = $this->get_inst_evenement($evenement_id);
        if ($this->get_boolean_from_pgsql_value($inst_evenement->getVal('notification_service')) == true) {
            // Des notifications ont été envoyé si il existe au moins une notification
            // de type notification_service_consulte liées à l'instruction
            $idsNotifs = $this->get_instruction_notification(
                $this->getVal($this->clePrimaire),
                'notification_service_consulte'
            );
            if (isset($idsNotifs) && $idsNotifs !== array()) {
                return true;
            }
        }
        return false;
    }


    /**
     * CONDITION - can_display_notification_tiers
     *
     * Vérifie que le champs "suivi_notification_tiers" est affichable
     *
     * @return boolean
     */
    function can_display_notification_tiers() {
        // Le suivi des notification est affiché si l'événement est notifiable
        // et si des notifications ont été envoyées
        $evenement_id = $this->getVal("evenement");
        $inst_evenement = $this->get_inst_evenement($evenement_id);
        if (! empty($inst_evenement->getVal('notification_tiers'))) {
            // Des notifications ont été envoyé si il existe au moins une notification
            // de type notification_tiers_consulte liées à l'instruction
            $idsNotifs = $this->get_instruction_notification(
                $this->getVal($this->clePrimaire),
                'notification_tiers_consulte'
            );
            if (isset($idsNotifs) && $idsNotifs !== array()) {
                return true;
            }
        }
        return false;
    }

    /**
     * CONDITION - can_display_notification_commune
     *
     * Vérifie que le champs "suivi_notification_commune" est affichable
     *
     * @return boolean
     */
    function can_display_notification_commune() {
        // Le suivi des notification si il existe au moins une notification
        // de type notification_depot_demat liées à l'instruction
        $idsNotifs = $this->get_instruction_notification(
            $this->getVal($this->clePrimaire),
            array('notification_depot_demat', 'notification_commune')
        );
        if (isset($idsNotifs) && $idsNotifs !== array()) {
            return true;
        }
        return false;
    }

    /**
     * TREATMENT - disable_edition_integrale.
     * 
     * Cette methode permet de passer la consultation en "lu"
     *
     * @return boolean true si maj effectué false sinon
     */
    function disable_edition_integrale() {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);
        $this->correct = true;
        $valF = array(
            "flag_edition_integrale" => false,
            "titre_om_htmletat" => null,
            "corps_om_htmletatex" => null,
        );
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
            $this->addToMessage(_("Rédaction par compléments activé."));
            return $this->end_treatment(__METHOD__, true);
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, false);
    }

    /**
     * TREATMENT - enable_edition_integrale.
     * 
     * Cette methode permet de passer la consultation en "lu"
     *
     * @return boolean true si maj effectué false sinon
     */
    function enable_edition_integrale() {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);
        $this->correct = true;

        // Récupère la collectivite du dossier d'instruction
        $dossier_instruction_om_collectivite = $this->get_dossier_instruction_om_collectivite();
        $collectivite = $this->f->getCollectivite($dossier_instruction_om_collectivite);
        //
        $params = array(
            "specific" => array(
                "corps" => array(
                    "mode" => "get",
                )
            ),
        );
        $result = $this->compute_pdf_output('lettretype', $this->getVal('lettretype'), $collectivite, null, $params);
        $corps = $result['pdf_output'];
        //
        $params = array(
            "specific" => array(
                "titre" => array(
                    "mode" => "get",
                )
            ),
        );
        $result = $this->compute_pdf_output('lettretype', $this->getVal('lettretype'), $collectivite, null, $params);
        $titre = $result['pdf_output'];
        //
        $valF = array(
            "flag_edition_integrale" => true,
            "titre_om_htmletat" => $titre,
            "corps_om_htmletatex" => $corps,
        );
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
            $this->addToMessage(_("Rédaction libre activé."));
            return $this->end_treatment(__METHOD__, true);
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, false);
    }

    /**
     * Cette méthode instancie le dossier à partir de l'identifiant passé
     * en paramètre et renvoie l'identifiant du dossier d'autorisation (DA)
     * associé au dossier.
     * Si l'identifiant du dossier n'est pas fourni alors cette méthode
     * renverra NULL
     *
     * @param string identifiant du dossier
     * @return null|string null ou identifiant du DA
     */
    function getNumDemandeAutorFromDossier($id) {
        if (!isset($id)) {
            return NULL;
        }

        $dossier = $this->f->get_inst__om_dbform(array(
            'obj' => 'dossier',
            'idx' => $id,
        ));

        return $dossier->getVal('dossier_autorisation');
    }

    
    function setType(&$form, $maj) {
        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);
        // Récupère la collectivité du dossier d'instruction
        $collectivite_di = $this->get_dossier_instruction_om_collectivite();

        // Cache tous les champs
        foreach ($this->champs as $value) {
            $form->setType($value, 'hidden');
        }

        // Les champs historique_signature et statut_signature ne sont pas saisissable dans tous les cas
        if ($this->can_display_parapheur() === true && $maj == 3) {
            $form->setType('statut_signature', 'selectstatic');
            $form->setType('historique_signature', 'jsontotab');
            if ($this->getVal('commentaire_signature') == null) {
                $form->setType('commentaire_signature', 'hidden');
            } else {
                $form->setType('commentaire_signature', 'hiddenstatic');
            }
        }

        // Le champ de suivi des notifications des demandeurs n'est pas affichable dans tous les cas
        if ($maj == 3 && $this->can_display_notification_demandeur() === true) {
            $form->setType('suivi_notification', 'jsontotab');
        }
        // Le champ de suivi des notifications des services n'est pas affichable dans tous les cas
        if ($maj == 3 && $this->can_display_notification_service() === true) {
            $form->setType('suivi_notification_service', 'jsontotab');
        }
        // Le champ de suivi des notifications des tiers n'est pas affichable dans tous les cas
        if ($maj == 3 && $this->can_display_notification_tiers() === true) {
            $form->setType('suivi_notification_tiers', 'jsontotab');
        }
        // Le champ de suivi des notifications des communes n'est pas affichable dans tous les cas
        if ($maj == 3 && $this->can_display_notification_commune() === true) {
            $form->setType('suivi_notification_commune', 'jsontotab');
        }

        // MODE AJOUTER
        if ($this->getParameter('maj') == 0) {
            $form->setType('commentaire', 'textareahidden');
            // Si l'option est active passage du champ date en lecture seule
            if ($this->f->is_option_date_evenement_instruction_lecture_seule($collectivite_di) === true) {
                $form->setType("date_evenement", "hiddenstaticdate");
            } else {
                $form->setType("date_evenement", "date");
            }
            if ($this->is_in_context_of_foreign_key("evenement", $this->getParameter("retourformulaire"))) {
                $form->setType("evenement", "selecthiddenstatic");
            } else {
                $form->setType("evenement", "select");
            }
            if ($this->is_in_context_of_foreign_key("signataire_arrete", $this->getParameter("retourformulaire"))) {
                $form->setType("signataire_arrete", "selecthiddenstatic");
            } else {
                $form->setType("signataire_arrete", "select");
            }
            if ($this->is_option_redaction_libre_enabled() === true) {
                $form->setType("flag_edition_integrale", "select");
            }
        }

        // MODE MODIFIER
        if ($this->getParameter('maj') == 1) {
            // Si l'option est active passage du champ date en lecture seule
            if ($this->f->is_option_date_evenement_instruction_lecture_seule($collectivite_di) === true) {
                $form->setType("date_evenement", "hiddenstaticdate");
            } else {
                $form->setType("date_evenement", "date");
            }
            $form->setType("evenement", "selecthiddenstatic");
            if ($this->has_an_edition() === true) {
                $form->setType('lettretype', 'hiddenstatic');
                if ($this->is_in_context_of_foreign_key("signataire_arrete", $this->getParameter("retourformulaire"))) {
                    $form->setType("signataire_arrete", "selecthiddenstatic");
                } else {
                    $form->setType("signataire_arrete", "select");
                }
                if ($this->getVal("flag_edition_integrale") == "t") {
                    $form->setType("titre_om_htmletat", "htmlEtat");
                    $form->setType("corps_om_htmletatex", "htmlEtatEx");
                } else {
                    $form->setType("complement_om_html", "html");
                    $form->setType("complement2_om_html", "html");
                    $form->setType("complement3_om_html", "html");
                    $form->setType("complement4_om_html", "html");
                    $form->setType('bible_auto', 'httpclick');
                    $form->setType('bible', 'httpclick');
                    $form->setType('bible2', 'httpclick');
                    $form->setType('bible3', 'httpclick');
                    $form->setType('bible4', 'httpclick');
                }
                if ($this->f->is_option_preview_pdf_enabled($collectivite_di) === true) {
                    //
                    $form->setType('btn_refresh', 'httpclickbutton');
                    $form->setType('btn_preview', 'httpclickbutton');
                    $form->setType('btn_redaction', 'httpclickbutton');
                    // /!\ le type du champs est utilisé dans un selecteur dans le jscript.js
                    // pour identifiant le champ de prévisualisation et régler sa taille à
                    // l'affichage du champ. En cas de modification, le selecteur doit également
                    // être mis à jour
                    $form->setType('live_preview', 'previsualiser_pdf');
                }

                // necessaire pour calcul de date en modification
                //$form->setType('delai', 'hiddenstatic');
                // les administrateurs technique et fonctionnel peuvent
                // modifier tous les champs de date
                // si l'instruction a déjà été finalisée au moins une fois
                if (($this->f->isAccredited(array($this->get_absolute_class_name(), $this->get_absolute_class_name()."modification_dates"), "OR")
                        || $this->f->isAccredited(array('instruction', 'instruction_modification_dates'), "OR"))
                    && $this->getVal("date_finalisation_courrier") != '') {
                    //
                    $form->setType('date_envoi_signature', 'date');
                    $form->setType('date_retour_signature', 'date');
                    if ($this->is_sent_for_signature() === true
                        && $this->is_signed() === true) {
                        //
                        $form->setType("date_envoi_signature", "datereadonly");
                        $form->setType("date_retour_signature", "datereadonly");
                    }
                    $form->setType('date_envoi_rar', 'date');
                    $form->setType('date_retour_rar', 'date');
                    $form->setType('date_envoi_controle_legalite', 'date');
                    if ($this->is_sent_to_cl() === true) {
                        $form->setType("date_envoi_controle_legalite", "datedisabled");
                    }
                    $form->setType('date_retour_controle_legalite', 'date');
                    $form->setType('date_finalisation_courrier', 'date');
                }
            }
        }

        // MODE CONSULTER + SUPPRIMER + SUIVI DES DATES 125 + NOTIFICATION MANUELLE
        if ($this->getParameter('maj') == 3
            || $this->getParameter('maj') == 2
            || $this->getParameter('maj') == 125
            || $this->getParameter('maj') == 410) {
            //
            $form->setType("date_evenement", "datestatic");
            $form->setType("evenement", "selecthiddenstatic");
            if ($this->has_an_edition() === true) {
                $form->setType('lettretype', 'hiddenstatic');
                $form->setType("signataire_arrete", "selecthiddenstatic");
                if ($this->getVal("om_final_instruction") == 't') {
                    $form->setType('om_final_instruction_utilisateur', 'textareastatic');
                } else {
                    $form->setType('om_final_instruction_utilisateur', 'hidden');
                }
            }
            if ($this->evenement_has_a_commentaire($this->getVal('evenement')) === true ) {
                $form->setType('commentaire', 'textareastatic');
            }
        }

        // MODE CONSULTER + SUPPRIMER + NOTIFICATION MANUELLE
        if ($this->getParameter('maj') == 3
            || $this->getParameter('maj') == 2
            || $this->getParameter('maj') == 410) {
            // Si il n'y a pas de lettre type (edition) associé à l'événement
            // les dates de suivi ne sont pas affichée
            if ($this->has_an_edition() === true) {
                $form->setType('date_envoi_signature', 'datestatic');
                $form->setType('date_retour_signature', 'datestatic');
                $form->setType('date_envoi_rar', 'datestatic');
                $form->setType('date_retour_rar', 'datestatic');
                $form->setType('date_envoi_controle_legalite', 'datestatic');
                $form->setType('date_retour_controle_legalite', 'datestatic');
                $form->setType('date_finalisation_courrier', 'datestatic');
                if ($this->getVal("flag_edition_integrale") == "t") {
                    $form->setType("titre_om_htmletat", "htmlstatic");
                    $form->setType("corps_om_htmletatex", "htmlstatic");
                } else {
                    $form->setType("complement_om_html", "htmlstatic");
                    $form->setType("complement2_om_html", "htmlstatic");
                    $form->setType("complement3_om_html", "htmlstatic");
                    $form->setType("complement4_om_html", "htmlstatic");
                }
            }
        }

        // MODE SUIVI DES DATES 125
        if ($this->getParameter('maj') == 125) {
            $form->setType("date_evenement", "hiddenstaticdate");
            $form->setType('om_final_instruction_utilisateur', 'hiddenstatic');
            $form->setType('date_envoi_signature', 'date');
            $form->setType('date_retour_signature', 'date');
            if ($this->is_sent_for_signature() === true
                || $this->is_signed() === true) {
                //
                $form->setType("date_envoi_signature", "datereadonly");
                $form->setType("date_retour_signature", "datereadonly");
            }
            $form->setType('date_envoi_rar', 'date');
            $form->setType('date_retour_rar', 'date');
            $form->setType('date_envoi_controle_legalite', 'date');
            if ($this->is_sent_to_cl() === true) {
                $form->setType("date_envoi_controle_legalite", "datedisabled");
            }
            $form->setType('date_retour_controle_legalite', 'date');
            $form->setType('date_finalisation_courrier', 'date');
        }

        if ($maj == 401) {
            foreach ($this->champs as $champ) {
                $form->setType($champ, 'hidden');
            }
            $form->setType('preview_edition', 'previsualiser');
        }

        // Si l'instruction a été envoyé au contrôle de légalité et que la 
        // tâche envoi_cl lié n'a pas encore été traité il faut indiquer à 
        // l'utilisateur que l'envoi au cl est en cours de traitement.
        if ($this->is_sent_to_cl() === true 
            && empty($this->getVal('date_envoi_controle_legalite'))
            && $maj == 3) {
            $form->setType("date_envoi_controle_legalite", "hiddenstatic");
        }
    }

    function setOnchange(&$form,$maj){
        parent::setOnchange($form,$maj);

        // MODE AJOUTER
        if ($this->getParameter('maj') == 0) {
            $form->setOnchange(
                "evenement",
                "manage_instruction_evenement_lettretype(this.value, '".addslashes($this->getParameter('idxformulaire'))."');
                manage_instruction_evenement_commentaire(this.value, '".addslashes($this->getParameter('idxformulaire'))."');"
            );
        }
    }

    function evenement_has_an_edition($evenement_id) {
        $evenement = $this->get_inst_evenement($evenement_id);
        $lettretype = $evenement->getVal('lettretype');
        if ($lettretype !== '' && $lettretype !== null) {
            return true;
        }
        return false;
    }

    function view_evenement_has_an_edition_json() {
        $json_return = array(
            "lettretype" => $this->evenement_has_an_edition($this->f->get_submitted_get_value('evenement_id')),
            "option_redaction_libre_enabled" => $this->is_option_redaction_libre_enabled(),
        );
        echo json_encode($json_return);
    }

    function evenement_has_a_commentaire($evenement_id) {
        $evenement = $this->get_inst_evenement($evenement_id);
        return $this->get_boolean_from_pgsql_value($evenement->getVal('commentaire'));
    }

    function view_evenement_has_a_commentaire_json() {
        $json_return = array(
            "commentaire" => $this->evenement_has_a_commentaire($this->f->get_submitted_get_value('evenement_id'))
        );
        echo json_encode($json_return);
    }


    /**
     * CONDITION - can_be_sended_to_cl
     *
     * Vérifie que le contrôle de légalité est disponible
     *
     * @return boolean
     */
    function can_be_sended_to_cl() {
        // Si l'instruction a une édition
        // et que l'événement est paramétré pour envoyer le contrôle de légalité
        // par Plat'AU
        // et que la date de retour signature est renseignée
        // et que la date d'envoi au contrôle légalité n'est pas renseignée
        // et qu'il n'existe pas de task envoi_CL en cours (!= done ou canceled)
        if ($this->has_an_edition() === true) {
            $inst_di = $this->get_inst_dossier($this->getVal('dossier'));
            $inst_evenement = $this->get_inst_evenement($this->getVal('evenement'));
            if ($inst_evenement->getVal('envoi_cl_platau') === 't'
                && empty($this->getVal('date_retour_signature')) === false
                && empty($this->getVal('date_envoi_controle_legalite')) === true
                && $this->getVal('envoye_cl_platau') === 'f'
                && $this->f->is_type_dossier_platau($inst_di->getVal('dossier_autorisation')) === true
                && $inst_di->getVal('etat_transmission_platau') !== 'jamais_transmissible') {
                //
                return true;
            }
        }
        //
        return false;
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_signataire_arrete() {
        return sprintf(
            "SELECT
                signataire_arrete.signataire_arrete,
                CONCAT_WS(
                    ' - ',
                    CONCAT_WS(' ', signataire_arrete.prenom, signataire_arrete.nom),
                    signataire_habilitation.libelle,
                    signataire_arrete.description
                )
            FROM
                %1\$ssignataire_arrete
                LEFT JOIN %1\$ssignataire_habilitation
                    ON signataire_arrete.signataire_habilitation = signataire_habilitation.signataire_habilitation
            WHERE
                ((signataire_arrete.om_validite_debut IS NULL
                    AND (signataire_arrete.om_validite_fin IS NULL
                        OR signataire_arrete.om_validite_fin > CURRENT_DATE))
                    OR (signataire_arrete.om_validite_debut <= CURRENT_DATE
                        AND (signataire_arrete.om_validite_fin IS NULL
                            OR signataire_arrete.om_validite_fin > CURRENT_DATE)))
            ORDER BY
                signataire_arrete.prenom,
                signataire_arrete.nom",
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_signataire_arrete_by_id() {
        return sprintf(
            "SELECT
                signataire_arrete.signataire_arrete,
                CONCAT_WS(
                    ' - ',
                    CONCAT_WS(' ', signataire_arrete.prenom, signataire_arrete.nom),
                    signataire_habilitation.libelle,
                    signataire_arrete.description
                )
            FROM
                %1\$ssignataire_arrete
                LEFT JOIN %1\$ssignataire_habilitation
                    ON signataire_arrete.signataire_habilitation = signataire_habilitation.signataire_habilitation
            WHERE
                signataire_arrete.signataire_arrete = <idx>",
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_signataire_arrete_by_di() {
        return sprintf(
            "SELECT
                signataire_arrete.signataire_arrete,
                CONCAT_WS(
                    ' - ',
                    CONCAT_WS(' ', signataire_arrete.prenom, signataire_arrete.nom),
                    signataire_habilitation.libelle,
                    signataire_arrete.description
                )
            FROM
                %1\$ssignataire_arrete
                LEFT JOIN %1\$som_collectivite
                    ON signataire_arrete.om_collectivite = om_collectivite.om_collectivite
                LEFT JOIN %1\$ssignataire_habilitation
                    ON signataire_arrete.signataire_habilitation = signataire_habilitation.signataire_habilitation
            WHERE
                ((signataire_arrete.om_validite_debut IS NULL
                    AND (signataire_arrete.om_validite_fin IS NULL
                        OR signataire_arrete.om_validite_fin > CURRENT_DATE))
                    OR (signataire_arrete.om_validite_debut <= CURRENT_DATE
                        AND (signataire_arrete.om_validite_fin IS NULL
                            OR signataire_arrete.om_validite_fin > CURRENT_DATE)))
                AND (om_collectivite.niveau = '2'
                    OR signataire_arrete.om_collectivite = <collectivite_di>)
            ORDER BY
                signataire_arrete.prenom, signataire_arrete.nom",
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_signataire_arrete_defaut() {
        return sprintf(
            "SELECT
                signataire_arrete.signataire_arrete,
                CONCAT_WS(
                    ' - ',
                    CONCAT_WS(' ', signataire_arrete.prenom, signataire_arrete.nom),
                    signataire_habilitation.libelle,
                    signataire_arrete.description
                )
            FROM
                %1\$ssignataire_arrete
                LEFT JOIN %1\$ssignataire_habilitation
                    ON signataire_arrete.signataire_habilitation = signataire_habilitation.signataire_habilitation
            WHERE
                ((signataire_arrete.om_validite_debut IS NULL
                    AND (signataire_arrete.om_validite_fin IS NULL
                        OR signataire_arrete.om_validite_fin > CURRENT_DATE))
                    OR (signataire_arrete.om_validite_debut <= CURRENT_DATE
                        AND (signataire_arrete.om_validite_fin IS NULL
                            OR signataire_arrete.om_validite_fin > CURRENT_DATE)))
                AND signataire_arrete.defaut IS TRUE
            ORDER BY
                signataire_arrete.prenom, signataire_arrete.nom",
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_signataire_arrete_defaut_by_di() {
        return sprintf(
            "SELECT
                signataire_arrete.signataire_arrete,
                    CONCAT_WS(
                        ' - ',
                        CONCAT_WS(' ', signataire_arrete.prenom, signataire_arrete.nom),
                        signataire_habilitation.libelle,
                        signataire_arrete.description
                    )
            FROM
                %1\$ssignataire_arrete
                LEFT JOIN %1\$ssignataire_habilitation
                    ON signataire_arrete.signataire_habilitation = signataire_habilitation.signataire_habilitation
                LEFT JOIN %1\$som_collectivite
                    ON signataire_arrete.om_collectivite = om_collectivite.om_collectivite
            WHERE
                ((signataire_arrete.om_validite_debut IS NULL
                    AND (signataire_arrete.om_validite_fin IS NULL
                        OR signataire_arrete.om_validite_fin > CURRENT_DATE))
                    OR (signataire_arrete.om_validite_debut <= CURRENT_DATE
                        AND (signataire_arrete.om_validite_fin IS NULL
                            OR signataire_arrete.om_validite_fin > CURRENT_DATE)))
                AND signataire_arrete.defaut IS TRUE
                AND (om_collectivite.niveau = '2'
                    OR signataire_arrete.om_collectivite = <collectivite_di>)
            ORDER BY
                signataire_arrete.prenom,
                signataire_arrete.nom",
            DB_PREFIXE
        );
    }

    /**
     * Renvoie sous la forme d'un tableau la liste des événements pouvant être ajoutés au dossier
     * dont l'identifiant a été passé en paramètre dans l'url.
     *
     * @return array
     */
    function get_var_sql_forminc__sql_evenement() {
        // Récupération du numéro de dossier
        $dossier = $this->getParameter("idxformulaire");
        // Si changement de décision par instructeur commune
        $filter = '';
        if ($this->f->isUserInstructeur() === true
            && $this->getDivisionFromDossier($dossier) != $_SESSION["division"]
            && $this->isInstrCanChangeDecision($dossier) === true) {
            $filter = "AND evenement.type IN ('arrete', 'changement_decision')";
        }
        // Récupération du libellé, de l'identifiant des évènement et d'un booléen permettant
        // de déterminer si il s'agit d'évènements suggérés.
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    DISTINCT(evenement.evenement),
                    evenement.libelle,
                    -- Si l evenement est suggérés alors il sera lié à la table des événements suggérés du dossier
                    CASE WHEN evenement_suggere_dossier.evenement IS NULL
                        THEN FALSE
                        ELSE TRUE
                    END AS is_suggested
                FROM
                    -- Jointures permettant de récupérer la liste des évènements compatibles avec le dossier
                    -- selon le type de dossier et l état du dossier.
                    %1$sevenement
                    JOIN %1$slien_dossier_instruction_type_evenement
                        ON evenement.evenement = lien_dossier_instruction_type_evenement.evenement
                    JOIN %1$stransition
                        ON evenement.evenement = transition.evenement
                    JOIN %1$sdossier
                        ON lien_dossier_instruction_type_evenement.dossier_instruction_type = dossier.dossier_instruction_type
                            AND transition.etat = dossier.etat
                    -- Jointures avec une sous requêtes servant à récupérer la liste des évènements suggérés du dossier.
                    LEFT JOIN (
                        SELECT
                            lien_sig_contrainte_evenement.evenement,
                            dossier.dossier
                        FROM
                            %1$slien_sig_contrainte_evenement
                            JOIN %1$ssig_contrainte
                                ON lien_sig_contrainte_evenement.sig_contrainte = sig_contrainte.sig_contrainte
                            JOIN %1$slien_sig_contrainte_dossier_instruction_type
                                ON sig_contrainte.sig_contrainte = lien_sig_contrainte_dossier_instruction_type.sig_contrainte
                            JOIN %1$slien_sig_contrainte_om_collectivite
                                ON sig_contrainte.sig_contrainte = lien_sig_contrainte_om_collectivite.sig_contrainte
                            JOIN %1$scontrainte
                                ON sig_contrainte.libelle = contrainte.libelle
                            JOIN %1$sdossier_contrainte
                                ON contrainte.contrainte = dossier_contrainte.contrainte
                            JOIN %1$sdossier
                                ON dossier_contrainte.dossier = dossier.dossier
                                    AND lien_sig_contrainte_dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type
                            JOIN %1$som_collectivite
                                ON lien_sig_contrainte_om_collectivite.om_collectivite = om_collectivite.om_collectivite
                                    AND (dossier.om_collectivite = om_collectivite.om_collectivite
                                        OR om_collectivite.niveau = \'2\')
                    ) AS evenement_suggere_dossier
                        ON evenement.evenement = evenement_suggere_dossier.evenement
                            AND dossier.dossier = evenement_suggere_dossier.dossier
                WHERE
                    dossier.dossier = \'%2$s\'
                    %3$s
                ORDER BY
                    is_suggested DESC,
                    evenement.libelle',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier),
                $filter
            ),
            array(
                "origin" => __METHOD__
            )
        );
        return $qres['result'];
    }

    /**
     * Récupère un tableau contenant des évènements de la forme :
     * $events = array(
     *      1 => array(
     *         'libelle' => 'evenement_libelle',
     *         'evenement' => 'identifiant_evenement',
     *         'is_suggested' => true/false   -> booleen indiquant si c'est un événement suggéré
     *         ))
     * Et le transforme pour pouvoir l'utiliser pour le remplissage d'un select de formulaire.
     *
     * Le format de sorti est le suivant :
     * $select = array(
     *      0 => array( -> liste des id des événements
     *          '0' => '',
     *          '1' => array(
     *              '0' => array(), -> liste des id des événements suggérés
     *              '1' => array(), -> liste des libelles des événements suggérés
     *          ),
     *          ...,
     *          n => 'id_evenement_n'
     *      ),
     *      1 => array(
     *          '0' => '__('choisir')." ".__('evenement')',
     *          '1' => '💡 Suggestions',
     *          ...,
     *          'n' => 'libelle_evenement_n',
     *      )
     * )
     *
     * @param array tableau des événements
     * @return array
     */
    protected function convert_events_array_to_select_format($events) {
        // Remplissage du tableau du select en incluant le groupe des instructions suggérées.
        $contenu = array(
            0 => array("",),
            1 => array(__('choisir')." ".__('evenement'),)
        );

        if (! empty($events)) {
            // S'il y a des évènements suggérés extraction de ces événements et mise en place du groupe
            $suggested_event_group = array_filter($events, function($a) {
                    return $a['is_suggested'] === 't';
            });
            if (! empty($suggested_event_group)) {
                // Prépare les données qui permettront d'afficher le groupe des événements
                // suggérés.
                $values = array();
                $labels = array();
                foreach ($suggested_event_group as $index => $suggested_event) {
                    $values[] = $suggested_event['evenement'];
                    $labels[] = $suggested_event['libelle'];
                    // Supprime les évènements suggérés de la liste des évènements
                    unset($events[$index]);
                }
                // Remplissage du select pour le groupe
                $contenu[0][] = array($values, $labels);
                $contenu[1][] = __('💡 Suggestions');
            }
    
            // Remplissage du select
            foreach ($events as $event) {
                $contenu[0][] = $event['evenement'];
                $contenu[1][] = $event['libelle'];
            }
        }
        return $contenu;
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        //parent::setSelect($form, $maj);
        /**
         * On ne surcharge pas la méthode parent car une requête sur la table
         * dossier est mauvaise pour les performances, car la requête qui
         * concerne evenement est plus complexe que celle générée et car les
         * champs action, avis_decision et etat ne sont pas utilisés comme des
         * select
         */
        //// action
        //$this->init_select($form, $this->f->db, $maj, null, "action",
        //                   $sql_action, $sql_action_by_id, false);

        //// avis_decision
        //$this->init_select($form, $this->f->db, $maj, null, "avis_decision",
        //                   $sql_avis_decision, $sql_avis_decision_by_id, false);

        //// dossier
        //$this->init_select($form, $this->f->db, $maj, null, "dossier",
        //                   $sql_dossier, $sql_dossier_by_id, false);

        //// etat
        //$this->init_select($form, $this->f->db, $maj, null, "etat",
        //                   $sql_etat, $sql_etat_by_id, false);

        //// evenement
        //$this->init_select($form, $this->f->db, $maj, null, "evenement",
        //                   $sql_evenement, $sql_evenement_by_id, false);

        // signataire_arrete
        // si contexte DI
        if ($this->getParameter("retourformulaire") == "dossier"
                || $this->f->contexte_dossier_instruction()) {
            // on recupère les signataires de la multicollectivité et de celle du DI
            $di = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $this->getParameter('idxformulaire'),
            ));
            $sql_signataire_arrete_by_di = str_replace(
                '<collectivite_di>',
                $di->getVal("om_collectivite"),
                $this->get_var_sql_forminc__sql("signataire_arrete_by_di")
            );
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "signataire_arrete",
                $sql_signataire_arrete_by_di,
                $this->get_var_sql_forminc__sql("signataire_arrete_by_id"),
                true
            );
        } else {
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "signataire_arrete",
                $this->get_var_sql_forminc__sql("signataire_arrete"),
                $this->get_var_sql_forminc__sql("signataire_arrete_by_id"),
                true
            );
        }

        /**
         * Gestion du filtre sur les événements de workflow disponibles
         * On récupère ici en fonction de l'état du dossier d'instruction en
         * cours et du type du dossier d'instruction en cours la liste
         * événements disponibles.
         */
        if ($maj == 0) {
            $evenements = $this->get_var_sql_forminc__sql_evenement();
            $form->setSelect("evenement", $this->convert_events_array_to_select_format($evenements));
        } else {
            // Instanciation de l'événement pour récupérer son libellé
            $evenement = $this->f->get_inst__om_dbform(array(
                "obj" => "evenement",
                "idx" => $this->getVal("evenement"),
            ));

            $contenu = array(
                0 => array($this->getVal("evenement"),),
                1 => array($evenement->getVal('libelle'),)
            );
            $form->setSelect("evenement", $contenu);
        }

        /**
         * Gesion des liens vers la bible
         */
        // lien bible_auto
        $contenu = array(_("automatique"));
        $form->setSelect("bible_auto",$contenu);
        // lien bible1
        $contenu = array(_("bible"));
        $form->setSelect("bible",$contenu);
        // lien bible2
        $contenu = array(_("bible"));
        $form->setSelect("bible2",$contenu);
        // lien bible3
        $contenu = array(_("bible"));
        $form->setSelect("bible3",$contenu);
        // lien bible4
        $contenu = array(_("bible"));
        $form->setSelect("bible4",$contenu);

        if ($maj == 1) {
            $base64 = $this->init_pdf_temp();
            $form->setSelect('live_preview', array('base64'=>$base64));
            $form->setSelect("btn_refresh", array(_('Prévisualiser')));
            $form->setSelect("btn_preview", array(_('Prévisualiser >>')));
            $form->setSelect("btn_redaction", array(_('<< Rédiger')));
        }

        // Selection du type de rédaction à l'ajout
        $content = array(
            0 => array('f', 't', ),
            1 => array(_('Rédaction par compléments'), _('Rédaction libre'), ),
        );
        $form->setSelect('flag_edition_integrale', $content);

        $contenu = array();
        foreach(array('waiting', 'in_progress', 'canceled', 'expired', 'finished') as $value) {
            $contenu[0][] = $value;
            $contenu[1][] = $this->get_trad_for_statut($value);
        }
        $form->setSelect('statut_signature', $contenu);


        if ($maj == 401) {
            $file = $this->f->storage->get($this->getVal('om_fichier_instruction'));
            $form->setSelect('preview_edition', array(
                'base64' => base64_encode($file['file_content']),
                'mimetype' => $file['metadata']['mimetype'],
                'label' => 'instruction_'.$this->getVal($this->clePrimaire),
                'href' => sprintf(
                    '../app/index.php?module=form&snippet=file&obj=instruction&champ=om_fichier_instruction&id=%1$s',
                    $this->getVal($this->clePrimaire)
                )
            ));
        }
    }

    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        //
        // Vérifie uniquementla cle secondaire : demande
        $this->rechercheTable($this->f->db, "demande", "instruction_recepisse", $id);
        
        $id = $this->getVal($this->clePrimaire);

        //Requête de vérification que cet événement d'instruction n'est pas lié 
        //à la création d'un dossier d'instruction
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    demande_type.dossier_instruction_type
                FROM
                    %1$sdemande_type
                    LEFT JOIN %1$sdemande
                        ON demande.demande_type = demande_type.demande_type
                WHERE
                    demande.instruction_recepisse = \'%2$d\'',
                DB_PREFIXE,
                intval($id)
            ), 
            array(
                "origin" => __METHOD__,
            )
        );

        // Aucune clé secondaire n'a été trouvée ou c'est un événement sans 
        //création de dossier d'instruction, l'événement d'instruction peut être 
        //supprimé
        if ( $this->correct !== false || $qres['result'] == null || $qres['result'] == ""){
            // Requête de vérification que cet événement d'instruction est lié
            // à une demande
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        demande
                    FROM
                        %1$sdemande
                    WHERE
                        instruction_recepisse = \'%2$d\'',
                    DB_PREFIXE,
                    intval($id)
                ), 
                array(
                    "origin" => __METHOD__,
                )
            );

            //Si c'est un événement d'instruction lié à une demande
            if ($qres['result'] != null || $qres['result'] != ""){
                $demande = $this->f->get_inst__om_dbform(array(
                    "obj" => "demande",
                    "idx" => $qres['result'],
                ));

                //On met à jour la demande en supprimant la liaison vers
                //l'événement d'instruction
                $demande->setParameter("maj", 1);
                $valF = array();
                foreach($demande->champs as $identifiant => $champ) {
                    $valF[$champ] = $demande->val[$identifiant];
                }
                $valF['date_demande']=$demande->dateDBToForm($valF['date_demande']);
                $valF['instruction_recepisse']=NULL;
                $ret = $demande->modifier($valF);
            }
                 
            /**
             * Vérification que l'élément supprimé est le dernier pour pouvoir
             * remodifier les données de manière itérative.
             */
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        max(instruction)
                    FROM
                        %1$sinstruction
                    WHERE
                        dossier = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($this->getParameter("idxformulaire"))
                ),
                array(
                    "origin" => __METHOD__,
                )
            );

            // Si on se trouve effectivement sur le dernier evenement d'instruction
            // alors on valide la suppression sinon on l'annule
            $this->correct = false;
            $message = __("Seul le dernier evenement d'instruction peut etre supprime.");
            if ($qres['result'] == $id) {
                // Alors on valide la suppression
                $this->correct = true;
                $message = __('Destruction_chronologique');
            }
            $this->addToMessage($message);
        }
    }

    /**
     * Vérification de la possibilité ou non de modifier des dates de suivi
     * @param  string $champ champ date à vérifier
     */
    function updateDate($champ) {
        
        //Si le retourformulaire est "dossier_instruction"
        if ($this->getParameter("retourformulaire") == "dossier"
                || $this->f->contexte_dossier_instruction()) {

            // Vérification de la possibilité de modifier les dates si déjà éditées
            if($this->valF[$champ] != "" AND !$this->f->user_is_admin) {
                // si l'utilisateur n'est pas un admin
                if($this->getVal($champ) != "" AND $this->getVal($champ) != $this->valF[$champ]) {

                    // si le champ concerné est 'date_envoi_signature'
                    // et que le statut du parapheur est 'expired'
                    // alors on autorise le changement de la date
                    // pour tous les autres cas, on ne peut modifier la date
                    if ($champ !== 'date_envoi_signature' || $this->getVal('statut_signature') !== 'expired') {
                        $this->correct = false;
                        $this->addToMessage(_("Les dates de suivis ne peuvent etre modifiees"));
                    }
                }
            }
        }
        
        //
        return true;
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        // parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        $this->retourformulaire = $retourformulaire;
        //
        if ($maj == 0) {
            $form->setVal("destinataire", $this->getParameter("idxformulaire"));
            $form->setVal("dossier", $this->getParameter("idxformulaire"));
        }

        // Si l'instruction a été envoyé au contrôle de légalité et que la 
        // tâche envoi_cl lié n'a pas encore été traité il faut indiquer à 
        // l'utilisateur que l'envoi au cl est en cours de traitement.
        if ($this->is_sent_to_cl() === true 
            && empty($this->getVal('date_envoi_controle_legalite'))
            && $maj == 3) {
            $form->setVal("date_envoi_controle_legalite", __("En cours de traitement."));
        }
        //
        $this->set_form_default_values($form, $maj, $validation);
    }

    /**
     * SETTER_FORM - set_form_default_values (setVal).
     *
     * @return void
     */
    function set_form_default_values(&$form, $maj, $validation) {
        //
        if ($maj == 0) {
            // si contexte DI
            if ($this->getParameter("retourformulaire") == "dossier"
                || $this->f->contexte_dossier_instruction()) {
                // on recupère les signataires de la multicollectivité et de celle du DI
                $di = $this->f->get_inst__om_dbform(array(
                    "obj" => "dossier_instruction",
                    "idx" => $this->getParameter("idxformulaire"),
                ));
                $sql = str_replace(
                    "<collectivite_di>",
                    $di->getVal("om_collectivite"),
                    $this->get_var_sql_forminc__sql("signataire_arrete_defaut_by_di")
                );
            } else {
                $sql = $this->get_var_sql_forminc__sql("signataire_arrete_defaut");
            }
            
            $qres = $this->f->get_all_results_from_db_query($sql, array(
                    "origin" => __METHOD__));
            $row = array_shift($qres['result']);
            if (isset($row["signataire_arrete"])
                && is_numeric($row["signataire_arrete"])) {
                //
                $form->setVal("signataire_arrete", $row["signataire_arrete"]);
            }
            // Date du jour
            $form->setVal("date_evenement", date("Y-m-d"));
        }
        //
        if ($maj == 0 || $maj == 1 || $maj == 125) {
            $form->setVal("bible_auto", "bible_auto()");
            $form->setVal("bible", "bible(1)");
            $form->setVal("bible2", "bible(2)");
            $form->setVal("bible3", "bible(3)");
            $form->setVal("bible4", "bible(4)");
        }
        //
        $collectivite_di = $this->get_dossier_instruction_om_collectivite();
        if ($maj == 1
            && $this->f->is_option_preview_pdf_enabled($collectivite_di) === true
            && $this->has_an_edition() === true) {
            //
            $form->setVal("live_preview", $this->getVal($this->clePrimaire));
            $form->setVal("btn_refresh", "reload_pdf_viewer()");
            $form->setVal("btn_preview", "show_instr_preview()");
            $form->setVal("btn_redaction", "show_instr_redaction()");
        }

        // Gestion de l'affichage des suivis de notification des demandeurs, des services, des tiers et
        // des communes
        if ($maj == 3) {
            if ($this->can_display_notification_demandeur()) {
                $typeNotification = array(
                    'notification_recepisse',
                    'notification_instruction',
                    'notification_decision',
                );
                $form->setVal("suivi_notification", $this->get_json_suivi_notification($typeNotification, true));
            }
            if ($this->can_display_notification_service()) {
                $form->setVal("suivi_notification_service", $this->get_json_suivi_notification(array('notification_service_consulte')));
            }
            if ($this->can_display_notification_tiers()) {
                $form->setVal("suivi_notification_tiers", $this->get_json_suivi_notification(array('notification_tiers_consulte')));
            }
            if ($this->can_display_notification_commune()) {
                $form->setVal("suivi_notification_commune", $this->get_json_suivi_notification(array('notification_depot_demat', 'notification_commune')));
            }
            if ($this->getVal('flag_edition_integrale') == 't') {
                $message = __("Aucun contenu à afficher.");
                if (empty($this->getVal('titre_om_htmletat'))) {
                    $form->setVal("titre_om_htmletat", $message);
                }
                if (empty($this->getVal('corps_om_htmletatex'))) {
                    $form->setVal("corps_om_htmletatex", $message);
                }
            }
        }
    }

    function setLayout(&$form, $maj){
        $form->setBloc('evenement','D',"","sousform-instruction-action-".$maj);

        $form->setFieldset('evenement','D',_('Evenement'));
        $form->setFieldset('om_final_instruction_utilisateur','F','');
        
        $form->setBloc('om_final_instruction_utilisateur','F');
        // Idem que pour le layout de la synthèse des DI, on est obligé de "casser" le setBloc en utilisant que la fin 
        // afin de bypasser le fait de ne pas avoir le form-content et le portlet dans le meme container
        $form->setBloc('om_final_instruction_utilisateur','F');
        $form->setBloc('parapheur_lien_page_signature','D');

        $form->setBloc('date_finalisation_courrier','D',"","");

        $form->setFieldset('date_finalisation_courrier','D',_('Dates'),"instruction--suivi-dates");
        $form->setBloc('date_finalisation_courrier','D');
        $form->setBloc('date_envoi_rar','F');

        $form->setBloc('date_retour_rar','D');
        $form->setBloc('date_retour_controle_legalite','F');
        $form->setFieldset('date_retour_controle_legalite','F','');
        
        $form->setBloc('date_retour_controle_legalite','F');

        $form->setBloc('statut_signature','D');
        $form->setFieldset('statut_signature','D','Suivi Parapheur');
        $form->setBloc('commentaire_signature','F');
        $form->setBloc('historique_signature','D');
        $form->setFieldset('historique_signature', 'DF', __("Historique"), "collapsible, startClosed");
        $form->setBloc('historique_signature','F');
        $form->setFieldset('historique_signature','F');

        $form->setFieldset('suivi_notification', 'D', __("Suivi notification"), "collapsible");
        $form->setFieldset('suivi_notification','F');
        $form->setFieldset('suivi_notification_service', 'D', __("Suivi notification service"), "collapsible");
        $form->setFieldset('suivi_notification_service','F');
        $form->setFieldset('suivi_notification_tiers', 'D', __("Suivi notification tiers"), "collapsible");
        $form->setFieldset('suivi_notification_tiers','F');
        $form->setFieldset('suivi_notification_commune', 'D', __("Suivi notification commune"), "collapsible");
        $form->setFieldset('suivi_notification_commune','F');

        if ($maj == 1) {
            // Récupère la collectivité du dossier d'instruction
            $collectivite_di = $this->get_dossier_instruction_om_collectivite();

            //
            if ($this->f->is_option_preview_pdf_enabled($collectivite_di) === true
                && $this->has_an_edition() === true) {
                //
                $form->setBloc('complement_om_html','D',"","container_instr_edition");
                $form->setBloc('complement_om_html','D',"","hidelabel box_instr_edition redaction_instr_edition");
                $form->setBloc('complement_om_html','D',"","box_instr_edition_main");
                $form->setFieldset('complement_om_html','D',_('Complement'));
                $form->setFieldset('bible','F','');
                $form->setFieldset('complement2_om_html','D',_('Complement 2'));
                $form->setFieldset('bible2','F','');
                $form->setFieldset('complement3_om_html','D',_('Complement 3'));
                $form->setFieldset('bible3','F','');
                $form->setFieldset('complement4_om_html','D',_('Complement 4'));
                $form->setFieldset('bible4','F','');
                $form->setFieldset('titre_om_htmletat','DF',_('Titre'), 'startClosed');
                $form->setFieldset('corps_om_htmletatex','DF',_('Corps'));
                $form->setBloc('corps_om_htmletatex','F');
                $form->setBloc('btn_preview','DF',"","box_instr_edition_btn");
                $form->setBloc('btn_preview','F');
                $form->setBloc('btn_redaction','D', '',"hidelabel box_instr_edition preview_instr_edition");
                $form->setBloc('btn_redaction','DF',"","box_instr_edition_btn");
                $form->setFieldset('btn_refresh','D',_('Prévisualisation'), "box_instr_edition_main");
                $form->setFieldset('live_preview','F');
                $form->setBloc('live_preview','F');
                $form->setBloc('live_preview','F');
            } else {
                $form->setBloc('complement_om_html','D',"","hidelabel");
                $form->setFieldset('complement_om_html','D',_('Complement'));
                $form->setFieldset('bible','F','');
                $form->setFieldset('complement2_om_html','D',_('Complement 2'));
                $form->setFieldset('bible2','F','');
                $form->setFieldset('complement3_om_html','D',_('Complement 3'));
                $form->setFieldset('bible3','F','');
                $form->setFieldset('complement4_om_html','D',_('Complement 4'));
                $form->setFieldset('bible4','F','');
                $form->setFieldset('titre_om_htmletat','DF',_('Titre'), 'startClosed');
                $form->setFieldset('corps_om_htmletatex','DF',_('Corps'));
                $form->setBloc('corps_om_htmletatex','F');
            }
        } else {
            $form->setBloc('complement_om_html','D',"","hidelabel");
            $form->setFieldset('complement_om_html','D',_('Complement'));
            $form->setFieldset('bible','F','');
            $form->setFieldset('complement2_om_html','D',_('Complement 2'));
            $form->setFieldset('bible2','F','');
            $form->setFieldset('complement3_om_html','D',_('Complement 3'));
            $form->setFieldset('bible3','F','');
            $form->setFieldset('complement4_om_html','D',_('Complement 4'));
            $form->setFieldset('bible4','F','');
            $form->setFieldset('titre_om_htmletat','DF',_('Titre'), 'startClosed');
            $form->setFieldset('corps_om_htmletatex','DF',_('Corps'));
            $form->setBloc('corps_om_htmletatex','F');
        }
    }
    
    function setLib(&$form, $maj) {
        //
        parent::setLib($form, $maj);
        //
        $form->setLib('bible_auto', "");
        $form->setLib('bible', "");
        $form->setLib('bible2', "");
        $form->setLib('bible3', "");
        $form->setLib('bible4', "");
        $form->setLib('btn_refresh', "");
        $form->setLib('btn_preview', "");
        $form->setLib('btn_redaction', "");
        $form->setLib('live_preview', "");
        $form->setLib('om_final_instruction_utilisateur', _("finalise par"));
        $form->setLib('date_envoi_rar', __("date_envoi_ar"));
        $form->setLib('date_retour_rar', __("date_notification"));
        $form->setLib('statut_signature', __("statut"));
        $form->setLib('commentaire_signature', __("commentaire"));
        $form->setLib('historique_signature', '');
        $form->setLib('suivi_notification', '');
        $form->setLib('suivi_notification_service', '');
        $form->setLib('suivi_notification_tiers', '');
        $form->setLib('suivi_notification_commune', '');
        $form->setLib('preview_edition', "");

        // Ajout d'une infobulle d'aide lorsque le formulaire est en mode
        // ajout et que l'option de rédaction libre est activée sur la
        // collectivité du dossier
        if ($maj === '0' && $this->is_option_redaction_libre_enabled() === true) {
            //
            $help_text_template = '%s <span class="info-16" title="%s"></span>';
            $help_text = _("Attention: le passage du mode 'Rédaction libre' à celui de 'Rédaction par compléments' fait perdre toute la rédaction manuelle effectuée.");
            $form->setLib('flag_edition_integrale', sprintf($help_text_template, _("Type de rédaction"), $help_text));
        }
        else {
            $form->setLib('flag_edition_integrale', _("Type de rédaction"));
        }

        // Ajout d'une infobulle d'aide lorsque le formulaire est en mode
        // modification et que l'option de prévisualisation de l'édition est
        // activée sur la collectivité du dossier
        if ($maj === '1'
            && $this->f->is_option_preview_pdf_enabled($this->get_dossier_instruction_om_collectivite()) === true) {
            //
            $help_text_template = '%s <span class="info-16" title="%s"></span>';
            $help_text = _("Attention la modification de la valeur de ce champ n'est pas prise en compte dans la prévisualisation. Pour que cette valeur soit mise à jour, il suffit de valider le formulaire.");
            $form->setLib('date_evenement', sprintf($help_text_template, _('date_evenement'), $help_text));
            $form->setLib('signataire_arrete', sprintf($help_text_template, _('signataire_arrete'), $help_text));
        }
    }

    /**
     * Surcharge om_dbform::set_form_specificity()
     *
     * Traitements spécifiques lié à l'affichage des formulaires.
     * Les traitements gérés ici sont les suivants :
     *   - Affichage d'un message d'erreur si la lettretype de l'évènement n'a pas
     *     pu être récupérée.
     *   - Affichage d'un message d'information à l'attention de l'utilisateur si
     *     la notification est activée mais qu'elle n'est pas possible à cause du
     *     paramètrage.
     *
     * @param formulaire $form Instance formulaire.
     * @param string $maj
     *
     * @return void
     */
    function set_form_specificity(&$form, $maj) {
        parent::set_form_specificity($form, $maj);
        
        // En consultation, vérifie si une lettretype est associée à l'instruction et a pu être récupérée.
        // Si ce n'est pas le cas affiche un message d'erreur.
        if ((! empty($maj) && $maj == 3)) {
            if (! empty($this->getVal('lettretype'))) {

                $om_edition = $this->f->get_inst__om_edition();
                $dossier_instruction_om_collectivite = $this->get_dossier_instruction_om_collectivite();
                $collectivite = $this->f->getCollectivite($dossier_instruction_om_collectivite);
                $edition = $om_edition->get_edition_from_collectivite('om_lettretype', $this->getVal("lettretype"), $collectivite['om_collectivite_idx']);

                if (empty($edition)) {
                    $this->display_error_message(__("Erreur de paramétrage, le modèle de document n'a pas pu être récupéré. Contactez votre administrateur."));
                }
            }
        }

        $this->display_notification_info($maj);
    }

    /**
     * En consultation, pour les dossiers qui n'ont pas été transmis par le portail
     * citoyen, si la notification des demandeurs est activée sur l'évenement
     * d'instruction et que le paramétrage du demandeur principal n'est pas
     * correct alors un message a destination de l'instructeur est affiché.
     *
     * @param string $maj
     *
     * @return void
     */
    public function display_notification_info($maj) {
        if ((! empty($maj) && $maj == 3)) {
            // Si le dossier n'a pas été déposé sur le portail citoyen (ou si
            // la requête permettant de savoir le type de demande à échouée) et si
            // la notification se fait par mail vérifie si il y a des erreurs de
            // paramétrage et si c'est le cas on affiche un message d'information
            if ($this->dossier_depose_sur_portail() == null || ! $this->dossier_depose_sur_portail()) {
                $erreurParam = $this->get_info_notification_fail();
                // Récupération de l'évenement d'instruction
                $instEV = $this->get_inst_evenement();
                if (! empty($instEV->getVal('notification')) && $erreurParam != array()) {
                    $class = 'text-info ui-state-highlight ui-state-info';
                    $message = __("La notification n'est pas possible.");
                    $this->f->display_panel_information(
                        $class,
                        $message,
                        $erreurParam,
                        __('Les données suivantes doivent être modifiées'),
                        'erreur_param_notif'
                    );
                }
            }
        }
    }

    /**
     * Méthode permettant d'afficher des messages d'erreur sur les formulaires.
     */
    public function display_error_message($msg) {
        $this->correct = false;
        $this->msg = $msg;
    }

    /**
     * TRIGGER - triggerajouter.
     *
     * @return boolean
     */
    function triggerajouter($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        /**
         * Le code suivant permet de récupérer des valeurs des tables evenement
         * et dossier pour les stocker dans l'instruction :
         * DEPUIS L'EVENEMENT
         * - action
         * - delai
         * - accord_tacite
         * - etat
         * - avis_decision
         * - delai_notification
         * - lettretype
         * - autorite_competente
         * - pec_metier
         * - complement_om_html
         * - complement2_om_html
         * - complement3_om_html
         * - complement4_om_html
         * - complement5_om_html
         * DEPUIS LE DOSSIER D'INSTRUCTION
         * - archive_delai
         * - archive_accord_tacite
         * - archive_etat
         * - archive_avis
         * - date_complet
         * - date_rejet
         * - date_limite
         * - date_notification_delai
         * - date_decision
         * - date_validite
         * - date_achevement
         * - date_chantier
         * - date_conformite
         * - avis_decision
         */
        // Récupération de tous les paramètres de l'événement sélectionné
        // TODO : remplacer cette requête par l'instanciation de l'événement
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$sevenement
                WHERE
                    evenement = %2$d',
                DB_PREFIXE,
                intval($this->valF['evenement'])
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        foreach ($qres['result'] as $row) {
            // Récupération de l'identifiant de l'action
            // si une action est paramétrée dans l'événement
            $this->valF['action'] = NULL;
            if (isset($row['action']) and !empty($row['action'])) {
                $this->valF['action']=$row['action'];
            }
            // Récupération de la valeur du délai
            $this->valF['delai'] = $row['delai'];
            // Récupération de l'identifiant de l'état
            // si un état est paramétré dans l'événement 
            $this->valF['etat']=NULL;
            if (isset($row['etat']) and !empty($row['etat'])) {
                $this->valF['etat']=$row['etat'];
            }
            // Récupération de la valeur d'accord tacite
            $this->valF['accord_tacite']=$row['accord_tacite'];
            // Récupération de la valeur du délai de notification
            $this->valF['delai_notification']=$row['delai_notification'];
            // Récupération de l'identifiant de l'avis
            // si un avis est paramétré dans l'événement 
            $this->valF['avis_decision'] = NULL;
            if(isset($row['avis_decision']) and !empty($row['avis_decision'])) {
                $this->valF['avis_decision']=$row['avis_decision'];
            }
            // Récupération de la valeur de l'autorité compétente
            // si l'autorité compétente est paramétré dans l'événement 
            $this->valF['autorite_competente'] = NULL;
            if(isset($row['autorite_competente']) and !empty($row['autorite_competente'])) {
                $this->valF['autorite_competente']=$row['autorite_competente'];
            }
            // Récupération de la valeur de la lettre type
            $this->valF['lettretype']=$row['lettretype'];
            // Récupération de la valeur de la prise en compte métier
            // si la prise en compte métier est paramétrée dans l'événement
            $this->valF['pec_metier'] = NULL;
            if(isset($row['pec_metier']) === true and empty($row['pec_metier']) === false) {
                $this->valF['pec_metier'] = $row['pec_metier'];
            }
        }
        // Récupération de toutes les valeurs du dossier d'instruction en cours
        // TODO : remplacer cette requête par l'instanciation de l'objet
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$sdossier
                WHERE
                dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->valF['dossier'])
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $row = array_shift($qres['result']);
        $this->updateArchiveData($row);
                
        // Récupération de la duree de validite du dossier d'autorisation
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    duree_validite_parametrage
                FROM 
                    %1$sdossier_autorisation_type_detaille
                    LEFT JOIN %1$sdossier_autorisation
                        ON  dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    LEFT JOIN %1$sdossier
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                WHERE 
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->valF['dossier'])
            ), 
            array(
                "origin" => __METHOD__,
            )
        );

        if ($qres['result'] != '') {
            $this->valF['duree_validite_parametrage'] = $qres['result'];
        }

        // Identifiant du type de courrier
        $idTypeCourrier = '11';
        $idCourrier = str_pad($this->valF["instruction"], 10, "0", STR_PAD_LEFT);
        // Code barres
        $this->valF["code_barres"] = $idTypeCourrier . $idCourrier;
    }
    
    /**
     * Test si une restriction est valide.
     *
     * @return boolean
     */
    function restrictionIsValid($restriction){
        if($this->restriction_valid != null) {
            return $this->restriction_valid;
        }
        if(empty($restriction)) {
            $this->restriction_valid = true;
            return $this->restriction_valid;
        }
        // Liste des opérateurs possibles sans espace
        $operateurs = array(">=", "<=", "+", "-", "&&", "||", "==", "!=");
        // Liste identique mais avec le marqueur §
        $mark = "§";
        $operateurs_marked = array();
        foreach ($operateurs as $operateur) {
            $operateurs_marked[] = $mark.$operateur.$mark;
        }

        // Supprime tous les espaces de la chaîne de caractère
        $restriction = preg_replace('/\s+/', '', $restriction);
        
        // Met un marqueur avant et après les opérateurs
        // puis transforme la chaine en un tableau
        $restriction = str_replace($operateurs, $operateurs_marked, 
            $restriction);

        // Pour chaque opérateur logique
        foreach (array('&&', '||') as $operator) {

            // S'il est absent on ne fait aucun traitement
            if (strpos($restriction, $mark.$operator.$mark) === false) {
                continue;
            }
            // Sinon on vérifie les deux conditions avec le OU/ET logique
            $restrictions = explode($mark.$operator.$mark, $restriction);
            $restrictions[0] = explode($mark, $restrictions[0]);
            $restrictions[1] = explode($mark, $restrictions[1]);
            $res_bool = false;
            if ($operator == '&&') {
                if ($this->is_restriction_satisfied($restrictions[0], $operateurs)
                    && $this->is_restriction_satisfied($restrictions[1], $operateurs)) {
                    $res_bool = true;
                }
            }
            if ($operator == '||') {
                if ($this->is_restriction_satisfied($restrictions[0], $operateurs)
                    || $this->is_restriction_satisfied($restrictions[1], $operateurs)) {
                    $res_bool = true;
                }
            }
            return $res_bool;
        }
        $tabRestriction = explode($mark, $restriction);
        return $this->is_restriction_satisfied($tabRestriction, $operateurs);

    }

    function is_restriction_satisfied($restriction, $operateurs) {
        // Tableau comprenant les résultat
        $res = array();
        // Compteur pour les résultat
        // commence à 1 car le 0 doit rester inchangé tout au long du traitement
        $j = 1;
        // Comparateur du calcul
        $comparateur = '';
        // Booléen retourné
        $res_bool = true;

        // S'il y a un comparateur
        if (in_array(">=", $restriction)
            || in_array("<=", $restriction)
            || in_array("==", $restriction)
            || in_array("!=", $restriction)) {

            // Si le tableau n'est pas vide
            if (count($restriction) > 0) {

                // Boucle dans le tableau pour récupérer seulement les valeurs
                foreach ($restriction as $key => $value) {
                    //
                    if (!in_array($value, $operateurs)) {
                        if ($this->getRestrictionValue($value) != false) {
                            $res[] = $this->getRestrictionValue($value);
                        } else {
                            // Message d'erreur
                            $error_message = sprintf(_("Le champ %s de l'instruction %s est vide"), "<span class='bold'>".$value."</span>", "<span class='bold'>".$this->valF["instruction"]."</span>");
                            $this->addToMessage($error_message);
                            // Arrête le traitement
                            return false;
                        }
                    }
                }

                // Boucle dans le tableau
                // commence à 1 car le 0 doit rester inchangé tout au long du 
                // traitement
                for ($i = 1; $i<count($restriction); $i++) {
                    
                    // Récupère le comparateur
                    if ($restriction[$i] === ">=" 
                        || $restriction[$i] === "<="
                        || $restriction[$i] === "=="
                        || $restriction[$i] === "!=") {
                        $comparateur = $restriction[$i];
                    }

                    // Si l'opérateur qui suit est un "+"
                    if ($restriction[$i] === "+") {
                        $dateDep = $res[$j];
                        unset($res[$j]);$j++;
                        $duree = $res[$j];
                        unset($res[$j]);
                        $res[$j] = $this->f->mois_date($dateDep, $duree, "+");
                    }

                    // Si l'opérateur qui suit est un "-"
                    if ($restriction[$i] === "-") {
                        $dateDep = $res[$j];
                        unset($res[$j]);$j++;
                        $duree = $res[$j];
                        unset($res[$j]);
                        $res[$j] = $this->f->mois_date($dateDep, $duree, "-");
                    }
                }
                
            }

            // Si les tableau des résultats n'est pas vide
            if (count($res) > 0) {
                //
                $res_bool = false;
                // Effectue le test
                if ($comparateur === ">=") {
                    //
                    if (strtotime($res[0]) >= strtotime($res[$j])) {
                        $res_bool = true;
                    }
                }
                if ($comparateur === "<=") {
                    //
                    if (strtotime($res[0]) <= strtotime($res[$j])) {
                        $res_bool = true;
                    }
                }
                if ($comparateur === "==") {
                    //
                    if (strtotime($res[0]) == strtotime($res[$j])) {
                        $res_bool = true;
                    }
                }
                if ($comparateur === "!=") {
                    //
                    if (strtotime($res[0]) != strtotime($res[$j])) {
                        $res_bool = true;
                    }
                }
            }
        // Sinon une erreur s'affiche
        } else {

            // Message d'erreur
            $error_message = _("Mauvais parametrage de la restriction.")." ".
                _("Contactez votre administrateur");
            $this->addToMessage($error_message);
            // Arrête le traitement
            return false;
        }
        
        return $res_bool;

    }

    /**
     * Permet de définir si l'événement passé en paramètre est un événement retour.
     * @param integer $evenement événement à tester
     * 
     * @return boolean retourne true si événement retour sinon false
     */
    function is_evenement_retour($evenement) {
        if(empty($evenement) || !is_numeric($evenement)) {
            return "";
        }

        $evenement = $this->f->get_inst__om_dbform(array(
            "obj" => "evenement",
            "idx" => $evenement,
        ));
        
        return $evenement->getVal('retour') == 't';
    }

    /**
     * Retourne le champ restriction de l'événement passé en paramètre.
     * 
     * @param integer $evenement id de l'événement sur lequel récupérer la restriction
     * 
     * @return string             contenu du champ restriction
     */
    function get_restriction($evenement) {
        if(empty($evenement) || !is_numeric($evenement)) {
            return "";
        }
        //Récupère la restriction
        $evenement = $this->f->get_inst__om_dbform(array(
            "obj" => "evenement",
            "idx" => $evenement,
        ));
        
        return $evenement->getVal('restriction');
    }

    /**
     * Récupère la valeur du champ dans la restriction
     * @param  string   $restrictionValue   Nom du champ
     * @return mixed                        Valeur du champ
     */
    function getRestrictionValue($restrictionValue){

        // Initialisation de la valeur de retour
        $return = false;

        // Récupére les valeurs du dossier
        $value_dossier = $this->get_dossier_actual();

        // 
        if (is_numeric($restrictionValue)) {
            $return = $restrictionValue;
        }elseif (isset($value_dossier[$restrictionValue])) {
            $return = $value_dossier[$restrictionValue];
        }elseif (isset($this->valF[$restrictionValue])) {
            $return = $this->valF[$restrictionValue];
        }

        // Retourne la valeur du champ
        return $return;
    }


    /**
     * Calcul des règle d'action selon leur type.
     *
     * Types de règle :
     * - date
     * - numeric
     * - text
     * - bool
     * - specific
     * - technical_data
     * 
     * @param string $rule      Règle d'action.
     * @param string $rule_name Nom de la règle.
     * @param string $type      Type de la règle.
     * 
     * @return mixed            Résultat de la règle
     */
    public function regle($rule, $rule_name, $type = null) {

        // Supprime tous les espaces de la chaîne de caractère
        $rule = str_replace(' ', '', $rule);
        // Coupe la chaîne au niveau de l'opérateur
        $operands = explode ("+", $rule);
        // Nombre d'opérande
        $nb_operands = count($operands);

        // Règle à null
        if ($rule == "null") {
            return null;
        }

        // Tableau des champs de type date
        $rule_type_date = array(
            "regle_date_limite",
            "regle_date_notification_delai",
            "regle_date_complet",
            "regle_date_validite",
            "regle_date_decision",
            "regle_date_chantier",
            "regle_date_achevement",
            "regle_date_conformite",
            "regle_date_rejet",
            "regle_date_dernier_depot",
            "regle_date_limite_incompletude",
            "regle_date_cloture_instruction",
            "regle_date_premiere_visite",
            "regle_date_derniere_visite",
            "regle_date_contradictoire",
            "regle_date_retour_contradictoire",
            "regle_date_ait",
            "regle_date_transmission_parquet",
            "regle_date_affichage",
        );
        // Tableau des champs de type numérique
        $rule_type_numeric = array(
            "regle_delai",
            "regle_delai_incompletude",
        );
        // Tableau des champs de type text
        $rule_type_text = array(
        );
        // Tableau des champs de type booléen
        $rule_type_bool = array(
            "regle_a_qualifier",
            "regle_incompletude",
            "regle_incomplet_notifie",
            "regle_evenement_suivant_tacite_incompletude",
        );
        // Tableau des champs spécifiques
        $rule_type_specific = array(
            "regle_autorite_competente",
            "regle_etat",
            "regle_accord_tacite",
            "regle_avis",
            "regle_pec_metier",
            "regle_etat_pendant_incompletude",
        );
        // Tableau des champs de données techniques
        $rule_type_technical_data = array(
            'regle_donnees_techniques1',
            'regle_donnees_techniques2',
            'regle_donnees_techniques3',
            'regle_donnees_techniques4',
            'regle_donnees_techniques5',
        );
        // Tableau des champs simple
        $rule_type_simple = array(
            "regle_dossier_instruction_type",
        );

        // Définit le type du champ
        if (in_array($rule_name, $rule_type_date) == true) {
            $type = "date";
        }
        if (in_array($rule_name, $rule_type_numeric) == true) {
            $type = "numeric";
        }
        if (in_array($rule_name, $rule_type_text) === true) {
            $type = "text";
        }
        if (in_array($rule_name, $rule_type_bool) === true) {
            $type = "bool";
        }
        if (in_array($rule_name, $rule_type_specific) === true) {
            $type = "specific";
        }
        if (in_array($rule_name, $rule_type_technical_data) === true) {
            $type = 'text';
        }
        if (in_array($rule_name, $rule_type_simple) === true) {
            $type = 'simple';
        }

        // Si c'est un type spécifique ou booléen alors il n'a qu'un opérande
        // Récupère directement la valeur de l'opérande
        if ($type === 'specific') {
            //
            return $this->get_value_for_rule($rule);
        }

        // Initialisation des variables
        $key_date = 0;
        $total_numeric = 0;
        $res_text = '';

        // Pour chaque opérande
        foreach ($operands as $key => $operand) {

            // Si c'est une règle de type date
            if ($type == 'date') {
                // Vérifie si au moins une des opérandes est une date
                if (is_numeric($operand) === false
                    && $this->get_value_for_rule($operand) !== null
                    && $this->f->check_date($this->get_value_for_rule($operand)) == true) {
                    // Récupère la position de la date
                    $key_date = $key;
                }
                // Les autres opérandes doivent être que des numériques
                if (is_numeric($operand) == true) {
                    // Ajoute l'opérande au total
                    $total_numeric += $operand;
                }
                if (is_numeric($operand) === false
                    && $this->get_value_for_rule($operand) !== null
                    && is_numeric($this->get_value_for_rule($operand)) == true) {
                    // Ajoute l'opérande au total
                    $total_numeric += $this->get_value_for_rule($operand);
                }
            }

            // Si c'est une règle de type numérique
            if ($type == 'numeric') {
                // Les opérandes doivent être que des numériques
                if (is_numeric($operand) == true) {
                    // Ajoute l'opérande au total
                    $total_numeric += $operand;
                }
                if (is_numeric($operand) === false
                    && $this->get_value_for_rule($operand) !== null
                    && is_numeric($this->get_value_for_rule($operand)) == true) {
                    // Ajoute l'opérande au total
                    $total_numeric += $this->get_value_for_rule($operand);
                }
            }

            // Si c'est une règle de type text
            if ($type === 'text') {
                // Concatène toutes les chaînes de caractère
                $res_text .= $this->get_value_for_rule($operand);
            }
        }

        // Résultat pour une règle de type date
        if ($type == 'date') {
            // Retourne le calcul de la date
            return $this->f->mois_date($this->valF[$operands[$key_date]], 
                $total_numeric, "+");
        }

        // Résultat pour une règle de type numérique
        if ($type == 'numeric') {
            // Retourne le calcul 
            return $total_numeric;
        }

        // Résultat pour une règle de type text
        if ($type === 'text') {
            // Retourne la chaîne de caractère
            return $res_text;
        }
        if ($type === 'simple' || $type === 'bool') {
            // Retourne la valeur du champs rule
            return $rule;
        }
    }


    /**
     * Récupère la valeur du champs dans l'instruction ou dans les données
     * techniques.
     * Spécifique au calcul des règles.
     *
     * @param string $field Champ
     *
     * @return mixed Valeur du champ
     */
    private function get_value_for_rule($field) {
        // Si le champ n'existe pas dans la table instruction
        if (array_key_exists($field, $this->valF) === false) {
            // Récupère l'instance de la classe donnees_techniques
            $inst_donnees_techniques = $this->get_inst_donnees_techniques();
            // Retourne la valeur de la donnée technique
            return $inst_donnees_techniques->getVal($field);
        }

        //
        return $this->valF[$field];
    }


    /**
     * [get_inst_donnees_techniques description]
     *
     * @param [type] $donnees_techniques [description]
     *
     * @return [type] [description]
     */
    function get_inst_donnees_techniques($donnees_techniques = null) {
        //
        if (isset($this->inst_donnees_techniques) === false or
            $this->inst_donnees_techniques === null) {
            //
            if (is_null($donnees_techniques)) {
                $donnees_techniques = $this->getDonneesTechniques();
            }
            //
            $this->inst_donnees_techniques = $this->f->get_inst__om_dbform(array(
                "obj" => "donnees_techniques",
                "idx" => $donnees_techniques,
            ));
        }
        //
        return $this->inst_donnees_techniques;
    }


    /**
     * Retourne l'identifiant des données techniques liées du dossier
     * @return string L'identifiant des données techniques liées du dossier
     */
    function getDonneesTechniques() {
    
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    donnees_techniques
                FROM 
                    %1$sdonnees_techniques
                WHERE 
                    dossier_instruction = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->valF["dossier"])
            ), 
            array(
                "origin" => __METHOD__,
            )
        );
        
        return $qres['result'];
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * - Mise à jour des informations liées au workflow sur le dossier
     * - Interface avec le référentiel ERP [105][111]
     * - Mise à jour du DA
     * - Historisation de la vie du DI
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // On a besoin de l'instance du dossier lié à l'événement d'instruction
        $inst_di = $this->get_inst_dossier($this->valF['dossier']);
        // Instance de la classe evenement
        $inst_evenement = $this->get_inst_evenement($this->valF['evenement']);
        // Instance de l'état courant du dossier d'instruction
        $inst_current_etat = $this->f->get_inst__om_dbform(array(
            "obj" => "etat",
            "idx" => $inst_di->get_id_etat(),
        ));

        /**
         * Mise à jour des valeurs du dossier en fonction des valeurs calculées
         * par l'action
         */
        // état de complétude actuel du dossier
        $incompletude = ($inst_di->getVal('incompletude') == 't' ? true : false);
        // L'événement suivant tacite paramétré est destiné à la gestion de l'incomplétude
        $ev_suiv_tacite_incompletude = false;
        // Initialisation
        $valF = array();
        $valF_dt = array();
        //
        // Récupération des paramètres de l'action
        // TODO : remplacer cette requête par l'instanciation de l'action
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$saction
                WHERE
                    action = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->valF['action'])
            ),
            array(
                "origin" => __METHOD__
            )
        );
        foreach ($qres['result'] as $row) {

            // pour chacune des regles, on applique la regle
            if ($row['regle_delai'] != '') {
                $valF['delai'] = $this->regle($row['regle_delai'], 'regle_delai');
            }
            if ($row['regle_accord_tacite'] != '') {
                $valF['accord_tacite'] = $this->regle($row['regle_accord_tacite'], 'regle_accord_tacite');
            }
            if ($row['regle_avis'] != '') {
                $valF['avis_decision'] = $this->regle($row['regle_avis'], 'regle_avis');
            }
            if ($row['regle_date_limite'] != '') {
                $valF['date_limite'] = $this->regle($row['regle_date_limite'], 'regle_date_limite');
            }
            if ($row['regle_date_complet'] != '') {
                $valF['date_complet'] = $this->regle($row['regle_date_complet'], 'regle_date_complet');
            }
            if ($row['regle_date_dernier_depot'] != '') {
                $valF['date_dernier_depot'] = $this->regle($row['regle_date_dernier_depot'], 'regle_date_dernier_depot');
            }
            if ($row['regle_date_notification_delai'] != '') {
                $valF['date_notification_delai'] = $this->regle($row['regle_date_notification_delai'], 'regle_date_notification_delai');
            }
            if ($row['regle_date_decision'] != '') {
                $valF['date_decision'] = $this->regle($row['regle_date_decision'], 'regle_date_decision');
            }
            if ($row['regle_date_rejet'] != '') {
                $valF['date_rejet'] = $this->regle($row['regle_date_rejet'], 'regle_date_rejet');
            }
            if ($row['regle_date_validite'] != '') {
                $valF['date_validite'] = $this->regle($row['regle_date_validite'], 'regle_date_validite');
            }
            if ($row['regle_date_chantier'] != '') {
                $valF['date_chantier'] = $this->regle($row['regle_date_chantier'], 'regle_date_chantier');
            }
            if ($row['regle_date_achevement'] != '') {
                $valF['date_achevement'] = $this->regle($row['regle_date_achevement'], 'regle_date_achevement');
            }
            if ($row['regle_date_conformite'] != '') {
                $valF['date_conformite'] = $this->regle($row['regle_date_conformite'], 'regle_date_conformite');
            }
            if ($row['regle_date_limite_incompletude'] != '') {
                $valF['date_limite_incompletude'] = $this->regle($row['regle_date_limite_incompletude'], 'regle_date_limite_incompletude');
            }
            if ($row['regle_delai_incompletude'] != '') {
                $valF['delai_incompletude'] = $this->regle($row['regle_delai_incompletude'], 'regle_delai_incompletude');
            }
            if ($row['regle_autorite_competente'] != '') {
                $valF['autorite_competente'] = $this->regle($row['regle_autorite_competente'], 'regle_autorite_competente');
            }
            if ($row['regle_etat'] != '') {
                $valF['etat'] = $this->regle($row['regle_etat'], 'regle_etat');
            }
            if ($row['regle_date_cloture_instruction'] !== '') {
                $valF['date_cloture_instruction'] = $this->regle($row['regle_date_cloture_instruction'], 'regle_date_cloture_instruction');
            }
            if ($row['regle_date_premiere_visite'] !== '') {
                $valF['date_premiere_visite'] = $this->regle($row['regle_date_premiere_visite'], 'regle_date_premiere_visite');
            }
            if ($row['regle_date_derniere_visite'] !== '') {
                $valF['date_derniere_visite'] = $this->regle($row['regle_date_derniere_visite'], 'regle_date_derniere_visite');
            }
            if ($row['regle_date_contradictoire'] !== '') {
                $valF['date_contradictoire'] = $this->regle($row['regle_date_contradictoire'], 'regle_date_contradictoire');
            }
            if ($row['regle_date_retour_contradictoire'] !== '') {
                $valF['date_retour_contradictoire'] = $this->regle($row['regle_date_retour_contradictoire'], 'regle_date_retour_contradictoire');
            }
            if ($row['regle_date_ait'] !== '') {
                $valF['date_ait'] = $this->regle($row['regle_date_ait'], 'regle_date_ait');
            }
            if ($row['regle_donnees_techniques1'] !== '') {
                $valF_dt[$row['cible_regle_donnees_techniques1']] = $this->regle($row['regle_donnees_techniques1'], 'regle_donnees_techniques1');
            }
            if ($row['regle_donnees_techniques2'] !== '') {
                $valF_dt[$row['cible_regle_donnees_techniques2']] = $this->regle($row['regle_donnees_techniques2'], 'regle_donnees_techniques2');
            }
            if ($row['regle_donnees_techniques3'] !== '') {
                $valF_dt[$row['cible_regle_donnees_techniques3']] = $this->regle($row['regle_donnees_techniques3'], 'regle_donnees_techniques3');
            }
            if ($row['regle_donnees_techniques4'] !== '') {
                $valF_dt[$row['cible_regle_donnees_techniques4']] = $this->regle($row['regle_donnees_techniques4'], 'regle_donnees_techniques4');
            }
            if ($row['regle_donnees_techniques5'] !== '') {
                $valF_dt[$row['cible_regle_donnees_techniques5']] = $this->regle($row['regle_donnees_techniques5'], 'regle_donnees_techniques5');
            }
            if ($row['regle_date_transmission_parquet'] !== '') {
                $valF['date_transmission_parquet'] = $this->regle($row['regle_date_transmission_parquet'], 'regle_date_transmission_parquet');
            }
            if ($row['regle_dossier_instruction_type'] !== '') {
                $valF['dossier_instruction_type'] = $this->regle($row['regle_dossier_instruction_type'], 'regle_dossier_instruction_type');
            }
            // La date d'affichage est modifiée seulement si le champ n'est pas
            // renseigné
            if ($row['regle_date_affichage'] !== ''
                && ($inst_di->getVal('date_affichage') === ''
                    || $inst_di->getVal('date_affichage') === null)) {
                //
                $valF['date_affichage'] = $this->regle($row['regle_date_affichage'], 'regle_date_affichage');
            }
            //
            if ($row['regle_pec_metier'] != '') {
                $valF['pec_metier'] = $this->regle($row['regle_pec_metier'], 'regle_pec_metier');
            }
            if ($row['regle_a_qualifier'] != '') {
                $valF['a_qualifier'] = $this->regle($row['regle_a_qualifier'], 'regle_a_qualifier');
            }
            //
            if ($row['regle_incompletude'] != '') {
                $valF['incompletude'] = $this->regle($row['regle_incompletude'], 'regle_incompletude');
            }
            if ($row['regle_incomplet_notifie'] != '') {
                $valF['incomplet_notifie'] = $this->regle($row['regle_incomplet_notifie'], 'regle_incomplet_notifie');
            }
            if ($row['regle_etat_pendant_incompletude'] != '') {
                $valF['etat_pendant_incompletude'] = $this->regle($row['regle_etat_pendant_incompletude'], 'regle_etat_pendant_incompletude');
            }
            if ($row['regle_evenement_suivant_tacite_incompletude'] != '') {
                $resti = $this->regle($row['regle_evenement_suivant_tacite_incompletude'], 'regle_evenement_suivant_tacite_incompletude');
                if (strtolower($resti) === 't' || strtolower($resti) === 'true') {
                    $ev_suiv_tacite_incompletude = true;
                }
            }
        }

        // Si l'événement a un événement suivant tacite
        if($inst_evenement->getVal('evenement_suivant_tacite') != '') {
            // En fonction de l'action de l'événement, l'événement suivant tacite ne sera
            // pas associé de le même façon au dossier d'instruction
            if ($ev_suiv_tacite_incompletude === false) {
                $valF['evenement_suivant_tacite'] = $inst_evenement->getVal('evenement_suivant_tacite');
            }
            if ($ev_suiv_tacite_incompletude === true) {
                $valF['evenement_suivant_tacite_incompletude'] = $inst_evenement->getVal('evenement_suivant_tacite');
            }
        }
        // Si des valeurs de données techniques ont été calculées alors on met à jour l'enregistrement
        if (count($valF_dt) > 0) {
            $dt_id = $this->getDonneesTechniques();
            // On met à jour le dossier
            $cle = " donnees_techniques='".$dt_id."'";
            $res1 = $this->f->db->autoexecute(DB_PREFIXE.'donnees_techniques', $valF_dt, DB_AUTOQUERY_UPDATE, $cle);
            $this->addToLog(
                __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."donnees_techniques\", ".print_r($valF_dt, true).", DB_AUTOQUERY_UPDATE, \"".$cle."\");",
                VERBOSE_MODE
            );
            $this->f->isDatabaseError($res1);
            // Affichage d'informations à l'utilisateur
            $this->addToMessage(_('enregistrement')." ".$this->valF['dossier']." "._('table')." dossier [".$this->f->db->affectedRows()." "._('enregistrement')." "._('mis_a_jour')."]");
        }
        // Si des valeurs ont été calculées alors on met à jour l'enregistrement
        if (count($valF) > 0) {
            //
            $inst_dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $this->valF['dossier'],
            ));
            $valF['instruction'] = $id;
            $valF['crud'] = 'create';
            $update_by_instruction = $inst_dossier->update_by_instruction($valF);
            if ($update_by_instruction === false) {
                $this->cleanMessage();
                $this->addToMessage(sprintf('%s %s', __("Une erreur s'est produite lors de la mise à jour du dossier d'instruction."), __("Veuillez contacter votre administrateur.")));
                return false;
            }
            // Affichage d'informations à l'utilisateur
            $this->addToMessage(_('enregistrement')." ".$this->valF['dossier']." "._('table')." dossier [".$this->f->db->affectedRows()." "._('enregistrement')." "._('mis_a_jour')."]");
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[105] Arrêté d'un dossier PC effectué -> PC qui concerne un ERP
         * (WS->ERP)[111] Décision de conformité effectuée -> PC qui concerne un ERP
         * Déclencheur :
         *  - L'option ERP est activée
         *  - Le dossier est marqué comme "connecté au référentiel ERP"
         *  - Le dossier est de type PC
         *  - Le formulaire d'ajout d'un événement d'instruction est validé
         *    avec un événement pour lequel les services ERP doivent être
         *    informé
         */
        //
        if ($this->f->is_option_referentiel_erp_enabled() === true
            && $inst_di->is_connected_to_referentiel_erp() === true
            && $this->f->getDATCode($this->valF['dossier']) == $this->f->getParameter('erp__dossier__nature__pc')
            && in_array($inst_evenement->getVal($inst_evenement->clePrimaire), explode(";", $this->f->getParameter('erp__evenements__decision__pc')))) {
            //
            $infos = array(
                "dossier_instruction" => $this->valF['dossier'],
                "decision" => $inst_evenement->getVal("libelle"),
            );
            //
            $ret = $this->f->send_message_to_referentiel_erp(105, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (105) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (105) du référentiel ERP OK."));
        }

        // Si le mode en rédaction intégrale est activé
        if (isset($this->valF['flag_edition_integrale']) === true
            && $this->valF['flag_edition_integrale'] === true) {
            $redactionIntegraleValF = array();

            // Récupère la collectivite du dossier d'instruction
            $dossier_instruction_om_collectivite = $this->get_dossier_instruction_om_collectivite();
            $collectivite = $this->f->getCollectivite($dossier_instruction_om_collectivite);
            // Récupère le corps de la lettre type
            $params = array(
                "specific" => array(
                    "corps" => array(
                        "mode" => "get",
                    )
                ),
            );
            $result = $this->compute_pdf_output('lettretype', $this->valF['lettretype'], $collectivite, $id, $params);
            $redactionIntegraleValF['corps_om_htmletatex'] = $result['pdf_output'];
            // Récupère le titre de la lettre type
            $params = array(
                "specific" => array(
                    "titre" => array(
                        "mode" => "get",
                    )
                ),
            );
            $result = $this->compute_pdf_output('lettretype', $this->valF['lettretype'], $collectivite, $id, $params);
            $redactionIntegraleValF['titre_om_htmletat'] = $result['pdf_output'];

            // mise à jour en base de données
            $res = $this->f->db->autoExecute(
                DB_PREFIXE.$this->table,
                $redactionIntegraleValF,
                DB_AUTOQUERY_UPDATE,
                $this->clePrimaire."=".$id
            );
            $this->addToLog(__METHOD__."(): db->autoexecute(\"".DB_PREFIXE.'.'.$this->table."\", ".print_r($redactionIntegraleValF, true).", DB_AUTOQUERY_UPDATE, \"".$this->clePrimaire."=".$id."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                return false;
            }
        }

        /**
         * Finalisation automatique de l'instruction si le paramétrage de l'événement l'autorise
         */
        // Si la finalisation automatique de l'événement est activée
        // ET si l'instruction n'a pas déjà été finalisée
        // ET s'il existe une lettre type associée
        if ($inst_evenement->getVal('finaliser_automatiquement') === 't'
            && $inst_evenement->getVal('om_final_instruction') !== 't'
            && $inst_evenement->getVal('lettretype') !== ''
            && $inst_evenement->getVal('lettretype') !== null) {

             // On instancie l'instruction
            $inst_instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => $this->valF[$this->clePrimaire],
            ));

            // On finalise l'instruction dans le contexte de finalisation : action 100
            $inst_instruction->setParameter('maj', 100);
            $finalize = $inst_instruction->finalize($inst_instruction->valF);

            // Une erreur de finalisation renvoie 'false' : ajout dans les logs
            // et dans le message d'erreur
            if ($finalize === false) {
                $this->f->addToLog(__METHOD__."() : ERROR - Impossible de finaliser l'instruction.", DEBUG_MODE);
                $this->addToMessage(_("Erreur lors de la finalisation de l'instruction. Contactez votre administrateur."));
                return false;
            }
        }

        /**
         * Finalisation automatique des instructions tacites ou retours.
         */
        // Si l'option de finalisation automatique des instructions tacites ou
        // retours est activée et l'événement d'instruction a une lettre type
        // associée
        $collectivite_di = $this->get_dossier_instruction_om_collectivite($val['dossier']);
        if ($this->f->is_option_finalisation_auto_enabled($collectivite_di) === true
            && $inst_evenement->getVal('lettretype') !== ''
            && $inst_evenement->getVal('lettretype') !== null) {

            // Rècupère l'identifiant de l'événement
            $evenement_id = $inst_evenement->getVal($inst_evenement->clePrimaire);

            // Si l'événement d'instruction est identifié comme un événement
            // retour
            // OU l'événement d'instruction est l'événement suivant tacite du
            // dossier d'instruction (incomplétude prise en compte)
            // ET l'événement d'instruction n'a pas déjà été finalisé 
            if (($inst_evenement->getVal("retour") === 't'
                || ($inst_di->getVal('evenement_suivant_tacite_incompletude') === $evenement_id
                    || $inst_di->getVal('evenement_suivant_tacite') === $evenement_id))
                    && ($inst_evenement->getVal('om_final_instruction') !== 't')) {

                // Finalise l'instruction
                $inst_instruction = $this->f->get_inst__om_dbform(array(
                    "obj" => "instruction",
                    "idx" => $this->valF[$this->clePrimaire],
                ));
                $inst_instruction->setParameter('maj', 100);
                $finalize = $inst_instruction->finalize($inst_instruction->valF);
                if ($finalize === false) {
                    //
                    return false;
                }
            }
        }

        /**
         * Mise à jour de la version de clôture *version_clos* du dossier si et
         * seulement si l'instruction met à jour l'état du dossier.
         */
        if (isset($valF['etat']) === true
            && $valF['etat'] !== null
            && $valF['etat'] !== '') {
            // Instanciation de l'état appliqué sur le dossier par l'instruction
            $inst_etat = $this->f->get_inst__om_dbform(array(
                "obj" => "etat",
                "idx" => $valF['etat'],
            ));
            //
            $update_version_clos = null;
            // En cas d'instruction qui clôture le dossier
            if ($inst_etat->getVal('statut') === 'cloture') {
                $update_version_clos = $inst_di->update_version_clos('up');
            }
            // En cas d'instruction qui rouvre le dossier
            if ($inst_current_etat->getVal('statut') === 'cloture'
                && $inst_etat->getVal('statut') !== 'cloture') {
                //
                $update_version_clos = $inst_di->update_version_clos('down');
                //
                $params = array(
                    'di_reopened' => true,
                );
            }
            //
            if ($update_version_clos === false) {
                $this->f->addToLog(sprintf(
                    "%s() : ERREUR - %s %s",
                    __METHOD__,
                    sprintf(
                        __("Impossible de mettre à jour la version de clôture du dossier d'instruction %s."),
                        $inst_di->getVal($inst_di->clePrimaire)
                    ),
                    sprintf(
                        __("L'instruction tente d'appliquer l'état %s."),
                        $inst_etat->getVal($inst_etat->clePrimaire)
                    )
                ));
                $this->addToMessage(sprintf(
                    "%s %s",
                    __("Erreur lors de la mise à jour de la version de clôture du dossier d'instruction."),
                    __("Veuillez contacter votre administrateur.")
                ));
                return false;
            }
        }

        /**
         * Notification automatique
         */
        // Notification automatique à l'ajout de l'instruction si la notification
        // automatique est choisie et qu'il n'y a pas de lettretype associée à l'événement
        if ($inst_evenement->getVal('notification') === 'notification_automatique' &&
            ($inst_evenement->getVal('lettretype') === null ||
            $inst_evenement->getVal('lettretype') === '')) {
            // Message à afficher dans les logs pour indiquer quelle notification a échouée
            $msgLog = sprintf(
                '%s %s : %d',
                __('Erreur lors de la notification automatique du(des) pétitionnaire(s).'),
                __('Instruction notifiée'),
                $id
            );

            // Récupération de la liste des demandeurs à notifier et de la catégorie
            $categorie = $this->f->get_param_option_notification($collectivite_di);
            $isPortal = $categorie === PORTAL;
            $demandeursANotifie = $this->get_demandeurs_notifiable(
                $this->valF['dossier'],
                $isPortal
            );

            // Création d'une notification et d'une tâche pour chaque demandeur à notifier
            $demandeurPrincipalNotifie = false;
            foreach ($demandeursANotifie as $demandeur) {
                // Identifie si le demandeur principal a été notifié ou pas
                // et récupère ses informations
                if ($demandeur['petitionnaire_principal'] == 't') {
                    $demandeurPrincipalNotifie = true;
                    // Si le demandeur principal est notifiable mais qu'il y a des erreurs dans
                    // son paramétrage, on effectue pas le traitement et on passe à l'itération
                    // suivante. On le considère également comme non notifié pour gérer l'envoie
                    // des messages d'erreurs
                    // Si la demande a été déposée via le portail alors le paramétrage n'a pas
                    // d'impact sur la notification
                    $erreursParam = $this->get_info_notification_fail($val['dossier']);
                    if (! $this->dossier_depose_sur_portail($val['dossier']) && $erreursParam != array()) {
                        $demandeurPrincipalNotifie = false;
                        continue;
                    }
                }
                // Ajout de la notif et récupération de son id
                $idNotif = $this->ajouter_notification(
                    $this->valF[$this->clePrimaire],
                    $this->f->get_connected_user_login_name(),
                    $demandeur,
                    $collectivite_di,
                    array(),
                    true
                );
                if ($idNotif === false) {
                    $this->addToLog(
                        sprintf('%s() : %s', __METHOD__, $msgLog),
                        DEBUG_MODE
                    );
                    return false;
                }
                // Création de la tache en lui donnant l'id de la notification
                $notification_by_task = $this->notification_by_task(
                    $idNotif,
                    $this->valF['dossier'],
                    $categorie
                );
                if ($notification_by_task === false) {
                    $this->addToLog(
                        sprintf('%s() : %s', __METHOD__, $msgLog),
                        DEBUG_MODE
                    );
                    $this->addToMessage(
                        __("Erreur lors de la génération de la notification au(x) pétitionnaire(s).")
                    );
                    return false;
                }
            }
            // Pour la notification par mail ou la notification via portal si le dossier a
            // été déposés via portal, si le demandeur principal n'est pas notifiable,
            // on créé une nouvelle notification en erreur avec en commentaire la raison pour
            // laquelle le demandeur principal n'a pas pu être notifié
            $depotPortal = $this->dossier_depose_sur_portail();
            if (! $demandeurPrincipalNotifie && ($isPortal === false || $depotPortal === true)) {
                // Précision dans les logs que le pétitionnaire principal n'est pas notifiable.
                // ' ' permet de mettre un espace entre les 2 msg de log.
                $msgLog .= sprintf(' %s', __('Le pétitionnaire principale n\'est pas notifiable.'));
                // Analyse pour savoir pourquoi le demandeur principal n'est pas notifiable
                $erreursParam = $this->get_info_notification_fail($val['dossier']);
                $demandeurPrincipal = $this->get_info_petitionnaire_principal_dossier($val['dossier']);
                // Ajout de la notif et récupération de son id
                $idNotif = $this->ajouter_notification(
                    $this->valF[$this->clePrimaire],
                    $this->f->get_connected_user_login_name(),
                    $demandeurPrincipal,
                    $collectivite_di,
                    array(),
                    true,
                    'Echec',
                    implode(' ', $erreursParam)
                );
                if ($idNotif === false) {
                    $this->addToLog(
                        sprintf('%s() : %s', __METHOD__, $msgLog),
                        DEBUG_MODE
                    );
                    $this->addToMessage(
                        __('Erreur : la création de la notification a échouée.').
                        __("Veuillez contacter votre administrateur.")
                    );
                    return false;
                }
                // Prépare un message d'alerte à destination de l'instructeur pour l'informer
                // de l'échec de la notification
                $dossier_message = $this->get_inst_dossier_message(0);
                $dossier_message_val = array(
                    'dossier' => $val['dossier'],
                    'type' => _('erreur expedition'),
                    'emetteur' => $this->f->get_connected_user_login_name().' (automatique)',
                    'login' => $_SESSION['login'],
                    'date_emission' => date('Y-m-d H:i:s'),
                    'contenu' => _('Échec lors de la notification de l\'instruction ').
                        $inst_evenement->getVal('libelle').
                        '.<br>'.
                        implode("\n", $erreursParam).
                        '<br>'.
                        _('Veuillez corriger ces informations avant de renvoyer la notification.')
                );
                $add = $dossier_message->add_notification_message($dossier_message_val, true);
                // Si une erreur se produit pendant l'ajout
                if ($add !== true) {
                    $this->addToLog(__METHOD__."(): Le message d'alerte concernant l'echec de l'envoi de la notification n'a pas pu être envoyé.", DEBUG_MODE);
                    return false;
                }
            }
            $this->addToMessage($message = sprintf('%s<br/>%s', __("La notification a été générée."), __("Le suivi de la notification est disponible depuis l'instruction.")));
        }

        // Notification automatique en cas de dépôt de dossier dématérialisé
        // Vérifie si l'option de notification est active et si il s'agit bien d'une
        // instruction de récépissé
        if (
            $this->f->is_option_notification_depot_demat_enabled($collectivite_di)
            && $this->is_instruction_recepisse()
        ) {
            // Message à afficher dans les logs pour indiquer quelle notification a échouée
            $msgLog = sprintf(
                __('Erreur lors de la notification de dépôt du dossier dématérialisé : %s.'),
                $val['dossier']
            );
            // Récupère l'instance de la demande
            $demande = $inst_di->get_inst_demande();
            // Vérifie que le dossier a été déposé via platau ou portal
            if (
                ($demande->getVal('source_depot') == PLATAU ||
                $demande->getVal('source_depot') == PORTAL)
            ) {
                // Récupère la liste des mails fournis en paramètre. Si aucun adresse n'a été récupéré
                // l'envoi de la notification n'est pas effectué et un message d'erreur est affiché.
                $listeEmails = $this->f->get_param_courriel_de_notification_commune($collectivite_di);
                if (empty($listeEmails)) {
                    $this->addToLog(
                        sprintf(
                            '%s(): %s %s',
                            __METHOD__,
                            $msgLog,
                            __('Aucun courriel paramétré.')
                        ),
                        DEBUG_MODE
                    );
                } else {
                    foreach ($listeEmails as $email) {
                        // Ajout de la notif et récupération de son id
                        $destinataire = array(
                            'destinataire' => $email,
                            'courriel' => $email
                        );
                        $idNotif = $this->ajouter_notification(
                            $this->valF[$this->clePrimaire],
                            $this->f->get_connected_user_login_name(),
                            $destinataire,
                            $collectivite_di,
                            array(),
                            true
                        );
                        if ($idNotif === false) {
                            $this->addToLog(
                                sprintf('%s(): %s', __METHOD__, $msgLog),
                                DEBUG_MODE
                            );
                            return false;
                        }
                        // Création de la tache en lui donnant l'id de la notification
                        $notification_by_task = $this->notification_by_task(
                            $idNotif,
                            $this->valF['dossier'],
                            'mail',
                            'notification_depot_demat'
                        );
                        if ($notification_by_task === false) {
                            $this->addToMessage(
                                __("Erreur lors de la génération de la notification de dépot de dossier par voie dématérialisée.")
                            );
                            $this->addToLog(
                                sprintf('%s(): %s', __METHOD__, $msgLog),
                                DEBUG_MODE
                            );
                            return false;
                        }
                    }
                }
            }
        }

        /**
         * Mise à jour de la date de dernière modification du dossier
         */
        $inst_di->update_last_modification_date();

        /**
         * Mise à jour des données du DA.
         */
        $inst_da = $inst_di->get_inst_dossier_autorisation();
        $params['di_id'] = $this->valF['dossier'];
        if ($inst_da->majDossierAutorisation($params) === false) {
            $this->addToMessage(_("Erreur lors de la mise a jour des donnees du dossier d'autorisation. Contactez votre administrateur."));
            $this->correct = false;
            return false;
        }

        /**
         * Historisation de la vie du DI.
         */
        //
        return $this->add_log_to_dossier($id, array_merge($val, $this->valF));
    }

    /**
     * Cette méthode vérifie si toutes les conditions de l'envoi de la notification
     * sont remplies.
     * Les conditions vérifiées sont les suivantes :
     *  - L'option de notification *option_notification* doit être définie
     *  - Le petitionnaire principal doit accepter les notifications
     *  - Le pétitionnaire principal doit avoir une adresse mail renseignée
     *  - Le pétitionnaire principal doit avoir une adresse mail correcte
     * Pour chaque vérification effectué un message d'erreur est ajouté si la
     * condition n'est pas remplie.
     * Renvoie le message d'erreur en sortie.
     *
     * @param string identifiant du dossier sur lequel les notifications ont échouée
     * @return string 
     */
    protected function get_info_notification_fail($dossier = null) {
        // Utilise l'identifiant du dossier passé en paramètre et si aucun dossier n'a été récupéré
        // utilise celui associé à l'instruction
        if ($dossier == null) {
            $dossier = $this->getVal('dossier');
        }
        // Tableau contenant la liste des messages d'erreur
        $errorMessage = array();
        // Récupère l'option de notification
        $collectivite_di = $this->get_dossier_instruction_om_collectivite($dossier);
        $option_notification = $this->f->get_param_option_notification($collectivite_di);
        if ($option_notification !== PORTAL && $option_notification !== 'mail') {
            $errorMessage[] = __("L'option de notification option_notification doit obligatoirement être définie.");
        }
        // Récupère les informations du demandeurs principal
        $infoPetitionnaire = $this->get_info_petitionnaire_principal_dossier($dossier);
        // Vérifie si le pétitionnaire principal à bien la case "accepte les notification" cochée
        if (isset($infoPetitionnaire['notification']) && $infoPetitionnaire['notification'] != 't') {
            $errorMessage[] = __('Le pétitionnaire principal n\'accepte pas les notifications.');
        }
        // Vérifie si l'adresse mail du pétitionnaire principale est renseignée
        if (isset($infoPetitionnaire['courriel']) && ! empty($infoPetitionnaire['courriel'])) {
            // Vérifie si le format de l'adresse mail est pas correct et, si ce n'est pas le cas, informe l'utilisateur
            // qu'il doit le corriger avant de pouvoir ajouter l'nstruction
            if (! $this->f->checkValidEmailAddress($infoPetitionnaire['courriel'])) {
                $errorMessage[] = __('Le courriel du pétitionnaire principal n\'est pas correct : ').
                    $infoPetitionnaire['courriel'].
                    '.'; 
            }
        } else {
            // Si le courriel du pétitionnaire principal
            $errorMessage[] = __('Le courriel du pétitionnaire principal n\'est pas renseigné.');
        }

        return $errorMessage;
    }

    /**
     * Méthode servant à vérifier si un dossier a été déposé sur
     * le portail citoyen ou pas.
     * La verification se fait via une requête sql dans laquelle
     * on va chercher un dossier ayant pour id l'identifiant de
     * dossier associé à l'instruction et pour lequel la demande
     * associée la plus ancienne est une demande de création de
     * dossier via portail
     *
     * @param string identifiant du dossier. Si non renseigné c'est le dossier
     * associé à l'instruction qui est utilisé
     * @return boolean|void true : dossier déposé via portail, false : dossier
     * non déposé via portail et null : erreur de base de données.
     */
    protected function dossier_depose_sur_portail($dossier = null) {
        if (empty($dossier)) {
            $dossier = $this->getVal('dossier');
        }
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier
                FROM
                    %1$sdossier
                    -- Récuperation de la première demande associée au dossier
                    LEFT JOIN (
                        SELECT
                            demande,
                            dossier_instruction,
                            source_depot
                        FROM
                            %1$sdemande
                        WHERE
                           dossier_instruction = \'%2$s\'
                        ORDER BY
                           demande ASC
                        LIMIT 1
                    ) AS demande
                        ON dossier.dossier = demande.dossier_instruction
                WHERE
                    dossier.dossier = \'%2$s\'
                    AND demande.source_depot = \'portal\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            $this->addToMessage(__('Erreur : La vérification du mode de dépôt du dossier à échoué'));
            return;
        }
        // Si on a un résultat c'est que le dossier a été déposé via le portail
        return ! empty($qres["result"]);
    }

    public function is_service_notifiable() {
        $evenement = $this->get_inst_evenement($this->getVal('evenement'));

        // Si l'instruction a une édition non finalisé quel que soit
        // le type de notification, il n'est pas notifiable
        if ($this->has_an_edition() === true) {
            if ($this->is_unfinalizable_without_bypass() === false) {
                return false;
            }
        }
        // Vérifie si la notification des tiers est active pour l'évènement
        return $this->get_boolean_from_pgsql_value($evenement->getVal('notification_service'));
    }

    public function is_tiers_notifiable() {
        $evenement = $this->get_inst_evenement($this->getVal('evenement'));

        // Si l'instruction a une édition non finalisé quel que soit
        // le type de notification, il n'est pas notifiable
        if ($this->has_an_edition() === true) {
            if ($this->is_unfinalizable_without_bypass() === false) {
                return false;
            }
        }
        // Vérifie si la notification des tiers est active pour l'évènement
        return ! empty($evenement->getVal('notification_tiers'));
    }

    /**
     * Méthode permettant de savoir si une instruction peut
     * être notifiée manuellement selon les différents types
     * de notification.
     *
     * Si l'instruction a une édition non finalisée alors elle n'est pas
     * manuellement notifiable.
     * Si l'instruction est associé à un événement de notification pour
     * lequel un retour signature est recquis, elle n'est notifiable que
     * si la date de retour de signature est remplie.
     * Par défaut si le type de notification n'est pas connu alors l'instruction
     * n'est pas notifiable.
     * Pour tous les autres cas l'instruction est manuellement notifiable.
     *
     * @return boolean true : notifiable | false : non notifiable
     */
    public function is_notifiable_by_task_manual() {
        $ev = $this->get_inst_evenement($this->getVal('evenement'));

        // Si l'instruction a une édition non finalisé quel que soit
        // le type de notification, il n'est pas notifiable
        if ($this->has_an_edition() === true) {
            if ($this->is_unfinalizable_without_bypass() === false) {
                return false;
            }
        }

        // Gestion des différents cas selon la valeur du champs notification
        if ($ev->getVal('notification') == 'notification_manuelle' ||
            $ev->getVal('notification') == 'notification_manuelle_annexe' ||
            $ev->getVal('notification') == 'notification_automatique'
        ) {
            return true;
        } elseif (($ev->getVal('notification') == 'notification_auto_signature_requise' ||
            $ev->getVal('notification') == 'notification_manuelle_signature_requise' ||
            $ev->getVal('notification') == 'notification_manuelle_annexe_signature_requise') &&
            $this->getVal('date_retour_signature') != null &&
            $this->getVal('date_retour_signature') != ''
        ) {
            return true ;
        }
        return false;
    }

    /**
     * Crée une instance de notification et une tache notification_instruction de catégorie portal
     * pour le demandeur principal.
     *
     * @return boolean true si le traitement à réussi
     */
    protected function notifier_demandeur_principal_via_portal() {
        $this->begin_treatment(__METHOD__);
        $message = '';
        // Récupération des informations concernant le demandeur
        $dossier = $this->getVal('dossier');
        $collectivite_di = $this->get_dossier_instruction_om_collectivite($dossier);
        $demandeur = $this->get_demandeurs_notifiable(
            $dossier,
            true
        );
        if ($demandeur !== array()) {
            $destinataire = array_values($demandeur);
            // Ajout de la notif et récupération de son id
            $idNotification = $this->ajouter_notification(
                $this->getVal($this->clePrimaire),
                $this->f->get_connected_user_login_name(),
                $destinataire[0],
                $collectivite_di,
                array(),
                true
            );
            if ($idNotification === false) {
                return $this->end_treatment(__METHOD__, false);
            }
            // Création de la tâche en lui donnant l'id de la notification
            $notification_by_task = $this->notification_by_task($idNotification, $dossier, PORTAL);
            if ($notification_by_task === false) {
                $this->addToMessage(
                    __("Erreur lors de la génération de la notification au(x) pétitionnaire(s).")
                );
                return $this->end_treatment(__METHOD__, false);
            }
            $this->addToMessage($message .= sprintf('%s<br/>%s', __("La notification a été générée."), __("Le suivi de la notification est disponible depuis l'instruction.")));
            return $this->end_treatment(__METHOD__, true);
        }
        $this->addToMessage( __("Le demandeur principal n'est pas notifiable."));
        return $this->end_treatment(__METHOD__, false);
    }

    public function notification_by_task($object_id, $dossier, $category = null, $type = null) {
        // Si le type n'est pas correctement spécifié, alors il est calculé
        if ($type !== 'notification_recepisse'
            && $type !== 'notification_instruction'
            && $type !== 'notification_decision'
            && $type !== 'notification_service_consulte'
            && $type !== 'notification_tiers_consulte'
            && $type !== 'notification_depot_demat'
            && $type !== 'notification_commune'
            && $type !== 'notification_signataire') {
            //
            $type = 'notification_instruction';
            // Vérifie si l'instruction est un récépissé
            if ($this->is_instruction_recepisse()) {
                $type = 'notification_recepisse';

            }
            // Vérifie si l'instruction est une décision
            if ($type !== 'notification_recepisse') {
                $avis_decision = $this->getVal('avis_decision') !== null ? $this->getVal('avis_decision') : $this->valF['avis_decision'];
                if ($avis_decision !== null && $avis_decision !== '') {
                    $type = 'notification_decision';
                }
            }
        }
        // Préparation des valeurs de la tâche
        $task_val = array(
            'type' => $type,
            'object_id' => $object_id,
            'dossier' => $dossier,
            'category' => $category,
        );
        // Préparation de la tache de notification
        $inst_task = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));

        $add_task = $inst_task->add_task(array('val' => $task_val));
        if ($add_task === false) {
            $this->addToLog(
                sprintf(
                    '%s(): %s %s : %s',
                    __METHOD__,
                    __('Echec de l\'ajout de la tâche de notification.'),
                    __('Paramétrage de la tâche'),
                    var_export($task_val, true)
                ),
                DEBUG_MODE
            );
            return false;
        }

        return true;
    }

    /**
     * Cette méthode permet de savoir si l'instruction est une instruction
     * de recepisse (instruction lié à l'ajout du dossier).
     *
     * Pour cela, on récupère la liste des actions qui ont menées à la création
     * de l'instruction. Si une de ces actions est lié à un objet "demande" on
     * en deduis que c'est l'ajout d'une demande qui a déclenché la création de
     * l'instruction et donc qu'il s'agit d'un recepisse.
     *
     * @return boolean
     */
    protected function is_instruction_recepisse() {
        // Récupère la liste des actions qui ont mené à la création de
        // l'instruction
        $trace = debug_backtrace();
        // Parcours la liste des actions et si une de ces actions est lié
        // à la classe demande on cosidère que l'instruction est un recepisse
        foreach ($trace as $key => $value) {
            if (isset($trace[$key]['class']) === true
                && empty($trace[$key]['class']) === false) {
                if (strtolower($trace[$key]['class']) === 'demande') {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * A partir des informations passée en argument ajoute un nouvel élément
     * dans la table instruction_notification.
     * Avant l'ajout vérifie en utilisant l'id de la collectivité passée en
     * paramètre si le paramétrage attendus est ok.
     * Ajoute également un nouvel élement dans instruction_notification_document
     * si l'instruction possède une lettretype.
     * Si un identifiant d'une instruction annexe est donnée ajoute un deuxième
     * élement dans la table instruction_notification_document qui correspondra
     * à l'annexe de la notification.
     * 
     * @param integer identifiant de l'instruction notifiée
     * @param string information concernant l'emetteur
     * @param array tableau contenant 2 entrées
     *  - destinatire : nom, prenom ou raison sociale, dénomination et courriel 
     *  - courriel : adresse mail de la personne à notifier
     * @param integer identifiant de la collectivité permettant de récupèrer les
     * paramètres à valider
     * @param boolean indique si la notification est automatique ou manuelle
     * @param integer identifiant d'une instruction dont l'édition sera annexé
     * à la notification
     * 
     * @return integer|boolean identifiant de la notification créée si le traitement
     * a réussie, false sinon.
     */
    protected function ajouter_notification(
        $idInstruction,
        $emetteur,
        $destinataire,
        $collectiviteId,
        $annexes = array(),
        $demandeAuto = false,
        $statut = 'en cours d\'envoi',
        $commentaire = 'Notification en cours de traitement'
    ) {
        // Vérification que les paramètres nécessaires à l'envoi de la notification existe avant
        // de créer la notification
        if (! $this->is_parametrage_notification_correct($collectiviteId)) {
            $msgErreur = __("Erreur de paramétrage. L'url d'accès au(x) document(s) notifié(s) n'est pas paramétrée.");
            $this->addToMessage($msgErreur);
            $this->addToLog(
                sprintf('%s() : %s', __METHOD__, $msgErreur),
                DEBUG_MODE
            );
            return false;
        }
        // Préparation de la notification
        $inst_notif = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction_notification",
            "idx" => "]",
        ));
        $notif_val = array(
            'instruction_notification' => null,
            'instruction' => $idInstruction,
            'automatique' => $demandeAuto,
            'emetteur' => $emetteur,
            'date_envoi' => null,
            'destinataire' => $destinataire['destinataire'],
            'courriel' => $destinataire['courriel'],
            'date_premier_acces' => null,
            'statut' => $statut,
            'commentaire' => $commentaire
        );

        // Création de la notification
        $add_notif = $inst_notif->ajouter($notif_val);
        if ($add_notif === false) {
            $this->addToMessage(__("Erreur lors de la génération de la notification au(x) pétitionnaire(s)."));
            $this->addToLog(
                sprintf(
                    '%s() : %s %s : %s',
                    __METHOD__,
                    __("Echec de l'ajout de la notification en base de données."),
                    __('Paramétrage de la notification'),
                    var_export($notif_val, true)
                ),
                DEBUG_MODE
            );
            return false;
        }

        // Si il y a une lettretype finalisé stockage de la clé d'accès au documents
        if ($this->evenement_has_an_edition($this->getVal('evenement')) === true) {
            $add_notif_doc = $this->ajouter_notification_document(
                $inst_notif->getVal($inst_notif->clePrimaire),
                $this->getVal($this->clePrimaire),
                'instruction'
            );
            if ($add_notif_doc === false) {
                $this->addToMessage(__("Erreur lors de la génération de la notification du document."));
                return false;
            }
        }
        // Si une annexe a été choisie stockage de la clé d'accès à l'annexe
        if (! empty($annexes) && is_array($annexes)) {
            $add_notif_annexe = $this->ajouter_notification_document_multiple(
                $inst_notif->getVal($inst_notif->clePrimaire),
                $annexes
            );
            if ($add_notif_annexe === false) {
                $this->addToMessage(__("Erreur lors de la génération de la notification de l'annexe."));
                return false;
            }
        }

        // Renvoie l'id de la nouvelle instance de instruction_notification
        return $inst_notif->getVal($inst_notif->clePrimaire);
    }

    /**
     * Pour chaque élément du tableau passé en paramètre ajoute une nouvelle
     * instance dans la table instruction_notification_document lié a la
     * notification dont l'id est passé en paramètre.
     * 
     * @param array tableau contenant les informations nécessaires pour créer les annexes
     * 
     * @return integer|boolean identifiant de la notification créée si le traitement
     * a réussie, false sinon.
     */
    protected function ajouter_notification_document_multiple($idNotification, $listeDocument) {
        foreach ($listeDocument as $paramDoc) {
            if (! $this->ajouter_notification_document($idNotification, $paramDoc['id'], $paramDoc['tableDocument'], $paramDoc['isAnnexe'])) {
                $this->addToMessage(__("Erreur lors de la génération des documents à notifier."));
                return false;
            }
        }
        return true;
    }

    /**
     * Ajoute un élément dans la table instruction_notification_document en utilisant
     * les éléments fourni en paramètre
     *
     * @param integer $idNotification : id de la notification à laquelle on associe le document
     * @param integer $idDocument : id de l'objet auquel est rattaché le document
     * @param string $tableDocument : nom de la table a laquelle est rattaché le document
     * @param boolean $isAnnexe : indique si le document est une annexe ou pas
     * 
     * @return boolean indique si le traitement a réussi
     */
    protected function ajouter_notification_document($idNotification, $idDocument, $tableDocument, $isAnnexe = false) {
        $inst_notif_doc = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction_notification_document",
            "idx" => "]",
        ));
        // l'attribut instruction doit obligatoirement être renseigné
        // pour éviter toutes confusion avec d'autres instruction l'id
        // 0 est donné au document n'appartenant pas aux instructions
        $notif_doc_val = array(
            'instruction_notification_document' => null,
            'instruction_notification' => $idNotification,
            'instruction' => $tableDocument == 'instruction' ? $idDocument : 0,
            'document_type' => $tableDocument,
            'document_id' => $idDocument,
            'cle' => $this->getCleAccesDocument(),
            'annexe' => $isAnnexe
        );

        $add_notif_doc = $inst_notif_doc->ajouter($notif_doc_val);
        if ($add_notif_doc === false) {
            $this->addToLog(
                sprintf(
                    '%s() : %s %s : %s',
                    __METHOD__,
                    __('Echec de l\'ajout du paramétrage du document notifié en base de données.'),
                    __('Paramétrage du document'),
                    var_export($notif_doc_val, true)
                ),
                DEBUG_MODE
            );
            return false;
        }
        return true;
    }
    
    /**
     * Vérifie si le paramétrage de la notification des demandeurs est correct.
     * 
     * @param integer identifiant de la collectivité
     * @return boolean
     */
    protected function is_parametrage_notification_correct($collectiviteId) {
        $categorie = $this->f->get_param_option_notification($collectiviteId);
        $urlAccesNotif = $this->f->get_parametre_notification_url_acces($collectiviteId);
        if ($categorie === 'mail' && $urlAccesNotif === null) {
            return false;
        }
        return true;
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        $collectivite_di = $this->get_dossier_instruction_om_collectivite($val['dossier']);
        $message = '';

        // Définit si le dossier d'instruction doit être mis à jour
        $update_dossier = true;
        // Les actions de mise à jour des dates ne doivent pas appliquer
        // l'action de l'événement et donc ne pas mettre à jour le dossier
        if ($this->getParameter("maj") == 125
            || $this->getParameter("maj") == 170
            || $this->getParameter("maj") == 175) {
            $update_dossier = false;
        }

        // Traitement en cas de mise à jour du dossier
        if ($update_dossier === true) {
            /**
             * L'objectif ici est d'effectuer les recalculs de date dans le dossier
             * si la date de l'evenement est modifiee
             */ 
            // Initialisation
            $valF = array();
            $valF_dt = array();
            // Initialisation du type d'événement
            $type_evmt = "";
            // Récupération de l'action correspondante à l'événement
            $evenement = $this->f->get_inst__om_dbform(array(
                "obj" => "evenement",
                "idx" => $this->valF['evenement']
            ));

            // Récupération des paramètres de l'action
            // TODO : remplacer cette requête par l'instanciation de l'action
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        *
                    FROM
                        %1$saction
                    WHERE
                        action = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($evenement->getVal('action'))
                ),
                array(
                    "origin" => __METHOD__
                )
            );
            foreach ($qres['result'] as $row) {
                // application des regles sur le courrier + delai
                if(preg_match("/date_evenement/",$row['regle_date_limite'])){
                    $valF['date_limite']= $this->regle($row['regle_date_limite'], 'regle_date_limite');
                }
                if(preg_match("/date_evenement/",$row['regle_date_complet'])){
                    $valF['date_complet']= $this->regle($row['regle_date_complet'], 'regle_date_complet');
                }
                if(preg_match("/date_evenement/",$row['regle_date_dernier_depot'])){
                    $valF['date_dernier_depot']= $this->regle($row['regle_date_dernier_depot'], 'regle_date_dernier_depot');
                }
                if(preg_match("/date_evenement/",$row['regle_date_notification_delai'])){
                    $valF['date_notification_delai']= $this->regle($row['regle_date_notification_delai'], 'regle_date_notification_delai');
                }
                if(preg_match("/date_evenement/",$row['regle_date_decision'])){
                    $valF['date_decision']= $this->regle($row['regle_date_decision'], 'regle_date_decision');
                }
                if(preg_match("/date_evenement/",$row['regle_date_rejet'])){
                    $valF['date_rejet']= $this->regle($row['regle_date_rejet'], 'regle_date_rejet');
                }
                if(preg_match("/date_evenement/",$row['regle_date_validite'])){
                    $valF['date_validite']= $this->regle($row['regle_date_validite'], 'regle_date_validite');
                }
                if(preg_match("/date_evenement/",$row['regle_date_chantier'])){
                    $valF['date_chantier']= $this->regle($row['regle_date_chantier'], 'regle_date_chantier');
                }
                if(preg_match("/date_evenement/",$row['regle_date_achevement'])){
                    $valF['date_achevement']= $this->regle($row['regle_date_achevement'], 'regle_date_achevement');
                }
                if(preg_match("/date_evenement/",$row['regle_date_conformite'])){
                    $valF['date_conformite']= $this->regle($row['regle_date_conformite'], 'regle_date_conformite');
                }
                if(preg_match("/date_evenement/",$row['regle_date_cloture_instruction'])){
                    $valF['date_cloture_instruction']= $this->regle($row['regle_date_cloture_instruction'], 'regle_date_cloture_instruction');
                }
                if(preg_match("/date_evenement/",$row['regle_date_premiere_visite'])){
                    $valF['date_premiere_visite']= $this->regle($row['regle_date_premiere_visite'], 'regle_date_premiere_visite');
                }
                if(preg_match("/date_evenement/",$row['regle_date_derniere_visite'])){
                    $valF['date_derniere_visite']= $this->regle($row['regle_date_derniere_visite'], 'regle_date_derniere_visite');
                }
                if(preg_match("/date_evenement/",$row['regle_date_contradictoire'])){
                    $valF['date_contradictoire']= $this->regle($row['regle_date_contradictoire'], 'regle_date_contradictoire');
                }
                if(preg_match("/date_evenement/",$row['regle_date_retour_contradictoire'])){
                    $valF['date_retour_contradictoire']= $this->regle($row['regle_date_retour_contradictoire'], 'regle_date_retour_contradictoire');
                }
                if(preg_match("/date_evenement/",$row['regle_date_ait'])){
                    $valF['date_ait']= $this->regle($row['regle_date_ait'], 'regle_date_ait');
                }
                if(preg_match("/date_evenement/",$row['regle_date_transmission_parquet'])){
                    $valF['date_transmission_parquet']= $this->regle($row['regle_date_transmission_parquet'], 'regle_date_transmission_parquet');
                }
                if ($row['regle_donnees_techniques1'] !== '') {
                    $valF_dt[$row['cible_regle_donnees_techniques1']] = $this->regle($row['regle_donnees_techniques1'], 'regle_donnees_techniques1');
                }
                if ($row['regle_donnees_techniques2'] !== '') {
                    $valF_dt[$row['cible_regle_donnees_techniques2']] = $this->regle($row['regle_donnees_techniques2'], 'regle_donnees_techniques2');
                }
                if ($row['regle_donnees_techniques3'] !== '') {
                    $valF_dt[$row['cible_regle_donnees_techniques3']] = $this->regle($row['regle_donnees_techniques3'], 'regle_donnees_techniques3');
                }
                if ($row['regle_donnees_techniques4'] !== '') {
                    $valF_dt[$row['cible_regle_donnees_techniques4']] = $this->regle($row['regle_donnees_techniques4'], 'regle_donnees_techniques4');
                }
                if ($row['regle_donnees_techniques5'] !== '') {
                    $valF_dt[$row['cible_regle_donnees_techniques5']] = $this->regle($row['regle_donnees_techniques5'], 'regle_donnees_techniques5');
                }
                if ($row['regle_dossier_instruction_type'] !== '') {
                    $valF['dossier_instruction_type'] = $this->regle($row['regle_dossier_instruction_type'], 'regle_dossier_instruction_type');
                }
            }
            // Si des valeurs de données techniques ont été calculées alors on met à jour l'enregistrement
            if (count($valF_dt) > 0) {
                $dt_id = $this->getDonneesTechniques();
                // On met à jour le dossier
                $cle = " donnees_techniques='".$dt_id."'";
                $res1 = $this->f->db->autoExecute(DB_PREFIXE.'donnees_techniques', $valF_dt, DB_AUTOQUERY_UPDATE, $cle);
                $this->addToLog(
                    __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."donnees_techniques\", ".print_r($valF_dt, true).", DB_AUTOQUERY_UPDATE, \"".$cle."\");",
                    VERBOSE_MODE
                );
                $this->f->isDatabaseError($res1);
                // Affichage d'informations à l'utilisateur
                $this->addToMessage(_('enregistrement')." ".$this->valF['dossier']." "._('table')." dossier [".$this->f->db->affectedRows()." "._('enregistrement')." "._('mis_a_jour')."]");
            }
            // Si des valeurs ont été calculées alors on met à jour l'enregistrement
            if (count($valF) > 0) {
                $inst_dossier = $this->f->get_inst__om_dbform(array(
                    "obj" => "dossier",
                    "idx" => $this->valF['dossier'],
                ));
                $valF['instruction'] = $id;
                $valF['crud'] = 'update';
                $update_by_instruction = $inst_dossier->update_by_instruction($valF);
                if ($update_by_instruction === false) {
                    $this->cleanMessage();
                    $this->addToMessage(sprintf('%s %s', __("Une erreur s'est produite lors de la mise à jour du dossier d'instruction."), __("Veuillez contacter votre administrateur.")));
                    return false;
                }
                // Affichage d'informations à l'utilisateur
                $this->addToMessage(_('enregistrement')." ".$this->valF['dossier']." "._('table')." dossier [".$this->f->db->affectedRows()." "._('enregistrement')." "._('mis_a_jour')."]");
            }
        }

        // Par défaut les instructions à ajouter suite à la saisie d'une date
        // de retour signature ou de notification, utilisent l'action 0
        // Si la création d'événement d'instruction suivant est déclenchée par
        // une notification suite au traitement d'une tâche (démat') alors l'ajout
        // de la nouvelle instruction se fait avec l'action 176
        // Cela permet de ne pas contrôler la restriction lors de l'ajout de la
        // nouvelle instruction, depuis la méthode verifier()
        $code_action_add = 0;
        if ($this->getParameter("maj") == 175) {
            $code_action_add = 176;
        }
        $restriction = $this->get_restriction($val['evenement']);
        $this->restriction_valid = $this->restrictionIsValid($restriction);

        if($restriction == "" || $this->restriction_valid ){
            // Récupération de tous les paramètres de l'événement sélectionné
            // TODO : remplacer cette requête par l'instanciation de l'evenement
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        *
                    FROM
                        %1$sevenement
                    WHERE
                        evenement = %2$d',
                    DB_PREFIXE,
                    intval($this->valF['evenement'])
                ),
                array(
                    "origin" => __METHOD__
                )
            );
            $current_id = $this->getVal($this->clePrimaire);
            foreach ($qres['result'] as $row) {
                // Si la date de retour signature est éditée on vérifie si il existe un événement automatique
                if ($this->getVal('date_retour_signature') == "" AND 
                    $this->valF['date_retour_signature'] != "" AND
                    $row['evenement_retour_signature'] != "") {
                    $new_instruction = $this->f->get_inst__om_dbform(array(
                        "obj" => "instruction",
                        "idx" => "]",
                    ));
                    // Création d'un tableau avec la liste des champs de l'instruction
                    foreach($new_instruction->champs as $champ) {
                        $valNewInstr[$champ] = ""; 
                    }
                    // Définition des valeurs de la nouvelle instruction
                    $valNewInstr["evenement"] = $row['evenement_retour_signature'];
                    $valNewInstr["destinataire"] = $this->valF['destinataire'];
                    $valNewInstr["dossier"] = $this->valF['dossier'];
                    $valNewInstr["date_evenement"] = $this->f->formatDate($this->valF['date_retour_signature']);
                    $valNewInstr["date_envoi_signature"] = $this->f->formatDate($this->valF['date_envoi_signature']);
                    $valNewInstr["date_retour_signature"] = $this->f->formatDate($this->valF['date_retour_signature']);
                    $valNewInstr["date_envoi_rar"] = $this->f->formatDate($this->valF['date_envoi_rar']);
                    $valNewInstr["date_retour_rar"] = $this->f->formatDate($this->valF['date_retour_rar']);
                    $valNewInstr["date_envoi_controle_legalite"] = $this->f->formatDate($this->valF['date_envoi_controle_legalite']);
                    $valNewInstr["date_retour_controle_legalite"] = $this->f->formatDate($this->valF['date_retour_controle_legalite']);
                    $new_instruction->setParameter("maj", $code_action_add);
                    $new_instruction->class_actions[$code_action_add]["identifier"] = 
                        sprintf(
                            __("Ajout suite au retour signature de l'instruction %s"),
                            $current_id
                        );
                    $retour = $new_instruction->ajouter($valNewInstr);
                    
                    //Si une erreur s'est produite et qu'il s'agit d'un problème
                    //de restriction
                    if ($retour == false && !$new_instruction->restriction_valid){
                        $error_message = $this->get_restriction_error_message($restriction);
                        $this->f->displayMessage("error", $error_message);
                        $this->addToLog(__METHOD__."(): evenement retour ".
                            "instruction ".$this->valF[$this->clePrimaire]." : ".
                            $new_instruction->msg);
                    }
                    //Si une erreur s'est produite après le test de la restriction
                    elseif ($retour == false && $new_instruction->restriction_valid){
                        $this->correct = false ;
                        $this->msg .= $new_instruction->msg;
                        return false;
                    }
                }
                // Si la date de retour AR est éditée on vérifie si il existe un événement automatique
                if ($this->getVal('date_retour_rar') == "" AND 
                    $this->valF['date_retour_rar'] != "") {
                    
                    if($row['evenement_retour_ar'] != "") {
                        $new_instruction = $this->f->get_inst__om_dbform(array(
                            "obj" => "instruction",
                            "idx" => "]",
                        ));
                        // Création d'un tableau avec la liste des champs de l'instruction
                        foreach($new_instruction->champs as $champ) {
                            $valNewInstr[$champ] = ""; 
                        }
                        // Définition des valeurs de la nouvelle instruction
                        $valNewInstr["evenement"] = $row['evenement_retour_ar'];
                        $valNewInstr["destinataire"] = $this->valF['destinataire'];
                        $valNewInstr["dossier"] = $this->valF['dossier'];
                        $valNewInstr["date_evenement"] = $this->f->formatDate($this->valF['date_retour_rar']);
                        $valNewInstr["date_envoi_signature"] = $this->f->formatDate($this->valF['date_envoi_signature']);
                        $valNewInstr["date_retour_signature"] = $this->f->formatDate($this->valF['date_retour_signature']);
                        $valNewInstr["date_envoi_rar"] = $this->f->formatDate($this->valF['date_envoi_rar']);
                        $valNewInstr["date_retour_rar"] = $this->f->formatDate($this->valF['date_retour_rar']);
                        $valNewInstr["date_envoi_controle_legalite"] = $this->f->formatDate($this->valF['date_envoi_controle_legalite']);
                        $valNewInstr["date_retour_controle_legalite"] = $this->f->formatDate($this->valF['date_retour_controle_legalite']);
                        $new_instruction->setParameter("maj", $code_action_add);
                        $new_instruction->class_actions[$code_action_add]["identifier"] = 
                            sprintf(__("Ajout suite à la notification de l'instruction %s"), $current_id);
                        $retour = $new_instruction->ajouter($valNewInstr);

                        //Si une erreur s'est produite et qu'il s'agit d'un problème
                        //de restriction
                        if ($retour == false && !$new_instruction->restriction_valid) {
                            $error_message = $this->get_restriction_error_message($restriction);
                            $this->f->displayMessage("error", $error_message);
                            $this->addToLog(
                                __METHOD__."(): evenement retour instruction ".
                                $this->valF[$this->clePrimaire]." : ".
                                $new_instruction->msg
                            );
                        }
                        //Si une erreur s'est produite après le test de la restriction
                        elseif ($retour == false && $new_instruction->restriction_valid){
                            $this->correct = false ;
                            $this->msg .= $new_instruction->msg;
                            return false;
                        }
                    }
                }
            }
        }

        // Traitement en cas de mise à jour du dossier
        if ($update_dossier === true) {
            /**
             * Mise à jour de la date de dernière modification du dossier
             * d'instruction
             */
            $inst_di = $this->get_inst_dossier($this->getVal('dossier'));
            $inst_di->update_last_modification_date();

            // Mise à jour des données du dossier d'autorisation
            $da = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_autorisation",
                "idx" => $this->getNumDemandeAutorFromDossier($this->valF['dossier']),
            ));
            $params = array(
                'di_id' => $this->getVal('dossier'),
            );
            if($da->majDossierAutorisation($params) === false) {
                $this->addToMessage(_("Erreur lors de la mise a jour des donnees du dossier d'autorisation. Contactez votre administrateur."));
                $this->correct = false;
                return false;
            }
        }

        // mise à jour des métadonnées issues des dates de suivi
        $dateRetourSignatureModified = ($this->valF['date_retour_signature'] != $this->getVal('date_retour_signature'));
        $dateRetourRARModified = ($this->valF['date_retour_rar'] != $this->getVal('date_retour_rar'));
        if ($dateRetourSignatureModified || $dateRetourRARModified) {

            // Calculs des nouvelles métadonnées
            $metadata = $this->getMetadata("om_fichier_instruction");

            // On vérifie si l'instruction à finaliser a un événement de type arrete
            // TODO : A voir pour remplacer par une instanciation de l'événement.
            //        Voir également si l'événement ne dois pas être instancié en début de
            //        méthode pour pouvoir être réutilisé.
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        type
                    FROM 
                        %1$sevenement
                    WHERE 
                        evenement = \'%2$d\'',
                    DB_PREFIXE,
                    intval($this->getVal("evenement"))
                ), 
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );

            if ($qres["code"] !== "OK") {
                $this->correct = false;
                $this->addToMessage(__("Erreur de traitement de fichier."));
                $this->addToLog(__METHOD__."() erreur BDD: ".var_export($qres['message'], true), DEBUG_MODE);
                return false;
            }

            // Si l'événement est de type arrete, on ajoute les métadonnées spécifiques
            if ($qres['result'] == 'arrete'){
                $metadata = array_merge($metadata, $this->getMetadata("arrete"));
            }

            // Filtre pour conserver uniquement les métadonnées liées aux dates
            $metadataToKeep = array(
                "statutAutorisation",
                "dateEvenementDocument",
                'date_cloture_metier',
                "NotificationArrete",
                "dateNotificationArrete",
                "controleLegalite",
                "dateSignature",
                "nomSignataire",
                "qualiteSignataire",
                "dateControleLegalite",
            );
            $metadata = array_filter(
                $metadata,
                function($key) use ($metadataToKeep) { return in_array($key, $metadataToKeep); },
                ARRAY_FILTER_USE_KEY
            );

            // Mise à jour des métadonnées du document en GED
            $docUid = $this->getVal("om_fichier_instruction");
            $operationOrUID = $this->f->storage->update_metadata($docUid, $metadata);
            if ($operationOrUID == 'OP_FAILURE') {
                $this->correct = false;
                $this->addToMessage(__("Erreur de traitement de fichier."));
                $this->addToLog(__METHOD__."() failed to update metadata: ".var_export($operationOrUID, true), DEBUG_MODE);
                return false;
            }

            // mise à jour de l'UID du document en BDD
            else {
                $valF = array('om_fichier_instruction' => $operationOrUID);
                $res = $this->f->db->autoExecute(DB_PREFIXE.$this->table, $valF, DB_AUTOQUERY_UPDATE, $this->getCle($id));
                $this->addToLog(__METHOD__.'() : db->autoExecute("'.DB_PREFIXE.$this->table.'", '.print_r($valF, true).', DB_AUTOQUERY_UPDATE, "'.$this->getCle($id).'")', VERBOSE_MODE);
                if ($this->f->isDatabaseError($res, true) === true) {
                    $this->correct = false;
                    $this->addToMessage(__("Erreur de traitement de fichier."));
                    $this->addToLog(__METHOD__."() erreur BDD: ".var_export($res->getMessage(), true), DEBUG_MODE);
                    return false;
                }
                $this->addToMessage(__("La mise a jour du document s'est effectuee avec succes."));
            }
        }

        // Déclenchement des notifications automatique après finalisation et
        // retour de signature
        if ($dateRetourSignatureModified === true
            && $this->valF['date_retour_signature'] !== ''
            && $this->valF['date_retour_signature'] !== null) {

            // Message à afficher dans les logs pour indiquer quelle notification a échouée
            $msgLog = sprintf(
                '%s %s : %d',
                __('Erreur lors de la notification automatique du(des) pétitionnaire(s) après retour signature.'),
                __('Instruction notifiée'),
                $id
            );

            // Récupération de l'instance de l'événement pour accéder au paramètrage
            // des notifications
            $ev = $this->get_inst_evenement($this->valF['evenement']);
            // Si la notification automatique des tiers consulté est active
            // déclenche le traitement de notification.
            // Ce traitement va envoyer des courriels de notification à tous les tiers concernés
            $typeNotifTiers = $ev->getVal('notification_tiers');
            $inst_di = $this->get_inst_dossier($this->getVal('dossier'));
            if ($typeNotifTiers === 'notification_automatique') {
                if ($this->traitement_notification_automatique_tiers_consulte($ev, $inst_di) === false) {
                    $this->addToMessage(__('Le traitement de la notification automatique de tiers à échoué.'));
                    $this->correct = false;
                }
            }

            if ($ev->getVal('notification') === 'notification_auto_signature_requise') {
                // Récupération de la liste des demandeurs à notifier et de la catégorie
                $categorie = $this->f->get_param_option_notification($collectivite_di);
                $isPortal = $categorie === PORTAL;
                $demandeursANotifie = $this->get_demandeurs_notifiable(
                    $this->valF['dossier'],
                    $isPortal
                );

                // Création d'une notification et d'une tâche pour chaque demandeur à notifier
                $demandeurPrincipalNotifie = false;
                foreach ($demandeursANotifie as $demandeur) {
                    // Identifie si le demandeur principal a été notifié ou pas
                    // et récupère ses informations
                    if ($demandeur['petitionnaire_principal'] == 't') {
                        $demandeurPrincipalNotifie = true;
                        // Si le demandeur principal est notifiable mais qu'il y a des erreurs dans
                        // son paramétrage, on effectue pas le traitement et on passe à l'itération
                        // suivante. On le considère également comme non notifié pour gérer l'envoie
                        // des messages d'erreurs
                        // Si la demande a été déposée via le portail alors le paramétrage n'a pas
                        // d'impact sur la notification
                        $erreursParam = $this->get_info_notification_fail();
                        if (! $this->dossier_depose_sur_portail() && $erreursParam != array()) {
                            $demandeurPrincipalNotifie = false;
                            continue;
                        }
                    }
                    // Ajout de la notif et récupération de son id
                    $idNotif = $this->ajouter_notification(
                        $this->valF[$this->clePrimaire],
                        $this->f->get_connected_user_login_name(),
                        $demandeur,
                        $collectivite_di,
                        array(),
                        true
                    );
                    if ($idNotif === false) {
                        $this->addToLog(
                            sprintf('%s() : %s',__METHOD__, $msgLog),
                            DEBUG_MODE
                        );
                        return false;
                    }
                    // Création de la tache en lui donnant l'id de la notification
                    $notification_by_task = $this->notification_by_task(
                        $idNotif,
                        $this->valF['dossier'],
                        $categorie
                    );
                    if ($notification_by_task === false) {
                        $this->addToLog(
                            sprintf('%s() : %s',__METHOD__, $msgLog),
                            DEBUG_MODE
                        );
                        $this->addToMessage(
                            __("Erreur lors de la génération de la notification au(x) pétitionnaire(s).")
                        );
                        return false;
                    }
                }
                // Pour la notification par mail ou la notification via portal si le dossier a
                // été déposés via portal, si le demandeur principal n'est pas notifiable,
                // on créé une nouvelle notification en erreur avec en commentaire la raison pour
                // laquelle le demandeur principal n'a pas pu être notifié
                $depotPortal = $this->dossier_depose_sur_portail();
                if (! $demandeurPrincipalNotifie && ($isPortal === false || $depotPortal === true)) {
                    // Précise dans les logs que le pétitionnaire principal n'a pas été notifié
                    $msgLog .= sprintf(' %s', __('Le pétitionnaire principale n\'est pas notifiable.'));
                    // Analyse pour savoir pourquoi le demandeur principal n'est pas notifiable
                    $erreursParam = $this->get_info_notification_fail();
                    $demandeurPrincipal = $this->get_info_petitionnaire_principal_dossier($this->getVal('dossier'));
                    // Ajout de la notif et récupération de son id
                    $idNotif = $this->ajouter_notification(
                        $this->valF[$this->clePrimaire],
                        $this->f->get_connected_user_login_name(),
                        $demandeurPrincipal,
                        $collectivite_di,
                        array(),
                        true,
                        'Echec',
                        implode(' ', $erreursParam)
                    );
                    if ($idNotif === false) {
                        $this->addToLog(
                            sprintf('%s() : %s', __METHOD__, $msgLog),
                            DEBUG_MODE
                        );
                        $this->addToMessage(
                            __('Erreur : la création de la notification a échouée.').
                            __("Veuillez contacter votre administrateur.")
                        );
                        return false;
                    }
                    // Prépare un message d'alerte à destination de l'instructeur pour l'informer
                    // de l'échec de la notification
                    $dossier_message = $this->get_inst_dossier_message(0);
                    $dossier_message_val = array(
                        'dossier' => $this->getVal('dossier'),
                        'type' => _('erreur expedition'),
                        'emetteur' => $this->f->get_connected_user_login_name(),
                        'login' => $_SESSION['login'],
                        'date_emission' => date('Y-m-d H:i:s'),
                        'contenu' => _('Échec lors de la notification de l\'instruction ').
                            $ev->getVal('libelle').
                            '.<br>'.
                            implode("\n", $erreursParam).
                            '<br>'.
                            _('Veuillez corriger ces informations avant de renvoyer la notification.')
                    );
                    $add = $dossier_message->add_notification_message($dossier_message_val, true);
                    // Si une erreur se produit pendant l'ajout
                    if ($add !== true) {
                        $this->addToLog(
                            sprintf(
                                '%s() : %s',
                                __METHOD__,
                                __("Le message d'alerte concernant l'echec de l'envoi de la notification n'a pas pu être envoyé.")
                            ),
                            DEBUG_MODE
                        );
                        return false;
                    }
                }
                $this->addToMessage($message .= sprintf('%s<br/>%s', __("La notification a été générée."), __("Le suivi de la notification est disponible depuis l'instruction.")));
            }
        }

        return $this->add_log_to_dossier($id, $val);
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        /**
         * L'objectif ici est de repositionner les valeurs récupérées en
         * archive dans le dossier d'instruction avant de supprimer l'événement
         * d'instruction si les valeurs du dossier sont différentes
         */
        $valF = array();
        $inst_di = $this->get_inst_dossier($this->getVal('dossier'));
        foreach ($inst_di->champs as $key => $champ) {
            // Si le champ du DI à une archive dans l'instruction
            if (isset($val[sprintf('archive_%s', $champ)]) === true) {
                // Si la valeur entre le champ du DI et son archive dans instruction
                // est différente
                if ($inst_di->getVal($champ) !== $val[sprintf('archive_%s', $champ)]) {
                    $val[sprintf('archive_%s', $champ)] === '' ? $valF[$champ] = null : $valF[$champ] = $val[sprintf('archive_%s', $champ)];
                    // Gestion du cas particulier 'accord_tacite' pour renvoyer la valeur '   ' (3 espaces vides) au lieu de null
                    // Car les valeurs possibles du champ accord_tacite sont : 'Oui', 'Non' ou '   '
                    if ($champ === "accord_tacite" && $valF[$champ] === null) {
                        $valF[$champ] = '   ';
                    }
                }
            }
        }
        // Spécificité du champ avis_decision dont le champ archive est nommé
        // différemment
        if ($inst_di->getVal('avis_decision') !== $val['archive_avis']) {
            $val['archive_avis'] === '' ? $valF['avis_decision'] = null : $valF['avis_decision'] = $val['archive_avis'];
        }
        // Spécificité de la date d'affichage dont la valeur n'ai jamais modifiée
        // par l'archive
        unset($valF['date_affichage']);

        /**
         * Mise à jour de la version de clôture *version_clos* du dossier si et
         * seulement si l'instruction met à jour l'état du dossier.
         */
        if (isset($valF['etat']) === true
            && $valF['etat'] !== null
            && $valF['etat'] !== '') {
            // Récupère l'état actuel du dossier d'instruction
            $inst_current_etat = $this->f->get_inst__om_dbform(array(
                "obj" => "etat",
                "idx" => $inst_di->get_id_etat(),
            ));
            // Instanciation de l'état archivé appliqué sur le dossier
            $inst_etat = $this->f->get_inst__om_dbform(array(
                "obj" => "etat",
                "idx" => $valF['etat'],
            ));
            //
            $update_version_clos = null;
            // En cas de clôture du dossier par l'état archivé
            if ($inst_etat->getVal('statut') === 'cloture') {
                $update_version_clos = $inst_di->update_version_clos('up');
            }
            // En cas de réouverture du dossier par l'état archivé
            if ($inst_current_etat->getVal('statut') === 'cloture'
                && $inst_etat->getVal('statut') !== 'cloture') {
                //
                $update_version_clos = $inst_di->update_version_clos('down');
                //
                $this->set_att_di_reopened(true);
            }
            //
            if ($update_version_clos === false) {
                $this->f->addToLog(sprintf(
                    "%s() : ERREUR - %s %s",
                    __METHOD__,
                    sprintf(
                        __("Impossible de mettre à jour la version de clôture du dossier d'instruction %s."),
                        $inst_di->getVal($inst_di->clePrimaire)
                    ),
                    sprintf(
                        __("L'instruction tente d'appliquer l'état %s."),
                        $inst_etat->getVal($inst_etat->clePrimaire)
                    )
                ));
                $this->addToMessage(sprintf(
                    "%s %s",
                    __("Erreur lors de la mise à jour de la version de clôture du dossier d'instruction."),
                    __("Veuillez contacter votre administrateur.")
                ));
                return false;
            }
        }
        // On supprime toutes les notications liées à l'instruction
        $notifASupprimer = $this->get_instruction_notification(
            $this->getVal($this->clePrimaire),
            array(
                'notification_recepisse',
                'notification_instruction',
                'notification_decision',
                'notification_service_consulte',
                'notification_tiers_consulte',
                'notification_depot_demat',
                'notification_commune',
                'notification_signataire'
            ),
            true
        );
            
        foreach ($notifASupprimer as $idNotif) {
            $inst_notif = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction_notification",
                "idx" => $idNotif,
            ));
            $val_notif = array();
            foreach ($inst_notif->champs as $champ) {
                $val_notif[$champ] = $inst_notif->getVal($champ);
            }
            // La suppression des notifications entrainera la suppression des tâches qui y sont
            // liées
            $supprNotif = $inst_notif->supprimer($val_notif);
            if ($supprNotif == false) {
                $this->addToMessage(sprintf(
                    "%s %s",
                    __("Erreur lors de la suppression des notifications de l'instruction."),
                    __("Veuillez contacter votre administrateur.")
                ));
                return false;
            }
        }

        // On met à jour le dossier
        $valF['instruction'] = $id;
        $valF['crud'] = 'delete';
        $update_by_instruction = $inst_di->update_by_instruction($valF);
        if ($update_by_instruction === false) {
            $this->cleanMessage();
            $this->addToMessage(sprintf('%s %s', __("Une erreur s'est produite lors de la mise à jour du dossier d'instruction."), __("Veuillez contacter votre administrateur.")));
            return false;
        }

        // Affichage d'informations à l'utilisateur
        $this->addToMessage(_("Suppression de l'instruction")." [".$this->f->db->affectedRows()." "._('enregistrement')." "._('mis_a_jour')."]");

        // Mise à jour de la demande si un récépissé d'instruction correspond à l'instruction à supprimer
    }

    /**
     * TRIGGER - triggersupprimerapres.
     *
     * @return boolean
     */
    function triggersupprimerapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        /**
         * Mise à jour de la date de dernière modification du dossier
         * d'instruction
         */
        $inst_di = $this->get_inst_dossier($this->getVal('dossier'));
        $inst_di->update_last_modification_date();

        /**
         * Mise à jour des données du dossier d'autorisation
         */
        $da = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => $this->getNumDemandeAutorFromDossier($val["dossier"]),
        ));
        $params = array(
            'di_id' => $this->getVal('dossier'),
            'di_reopened' => $this->get_att_di_reopened(),
        );
        if($da->majDossierAutorisation($params) === false) {
            $this->addToMessage(_("Erreur lors de la mise a jour des donnees du dossier d'autorisation. Contactez votre administrateur."));
            $this->correct = false;
            return false;
        }

        /**
         * Gestion des tâches pour la dématérialisation
         */
        $inst_task_empty = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));
        foreach ($inst_di->task_types as $task_type) {
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
                        $this->correct = false;
                        return false;
                    }
                }
            }
        }

        //
        $val['evenement'] = $this->getVal('evenement');
        return $this->add_log_to_dossier($id, $val);
    }

    /**
     * Permet de mettre la valeur passée en paramètre dans l'attribut de classe
     * "di_reopened".
     *
     * @param boolean $val
     */
    function set_att_di_reopened($val) {
        $this->di_reopened = $val;
    }

    /**
     * Permet de récupérer la valeur de l'attribut de classe "di_reopened".
     *
     * @return boolean
     */
    function get_att_di_reopened() {
        return $this->di_reopened;
    }

    /**
     * Permet de composer un message d'erreur sur restriction non valide en 
     * fonction du contexte.
     *
     * @param string $restriction formule de la restriction
     *
     * @return string message d'erreur
     */
    function get_restriction_error_message($restriction) {
        // Affichage du message si la restriction s'applique
        // Contexte du suivi des dates (message simple)
        $message_restrict = _("Probleme de dates :");
        // Split restriction
        $champs_restrict = preg_split(
                '/(\W+)/',
                $restriction,
                null,
                PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE
            );
        $formated_restrict = "";
        // Ajout des chaînes à traduire
        foreach ($champs_restrict as $value) {
            $formated_restrict .= _($value)." ";
        }
        $formated_restrict = substr($formated_restrict, 0, -1);
        // Message d'erreur dans le contexte du suivi des dates
        if($this->getParameter("maj") == 170) {
            $message_restrict .= " "._("contactez l'instructeur du dossier");
            $message_restrict .= "<br/>(".$formated_restrict.")";
        } else {
            // Affichage du message si la restriction s'applique
            // Contexte instruction
            $message_restrict .= "<br/>".$formated_restrict;
        }

        return $message_restrict;
    }

    /**
     * Surcharge de la méthode verifier() de la classe om_dbform pour y ajouter
     * les vérifications suivantes :
     *   - Si l'instruction à un événement associé et que cet événement à des restrictions :
     *       1. vérifie si la restriction est valide, si ce n'est pas le cas récupère et affiche
     *          le message d'erreur associé à la restriction
     *       2. vérifie si les restrictions sont respectées. Si ce n'est pas le cas bloque l'ajout
     *          et / ou la modification et affiche un message d'erreur
     *   - 
     *   - 
     *   - 
     *   - 
     *   - 
     *   -
     * 
     * @param array val : tableau contenant les valeurs issues du formulaire.
     * @param - dnu1 : Paramètre déprécié et non utilisé.
     * @param - dnu2 : Paramètre déprécié et non utilisé.
     *
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);
        //
        if ( isset($val['evenement']) && is_numeric($val['evenement'])){
            $restriction = $this->get_restriction($val['evenement']);
    
            //Test qu'une restriction est présente
            if ($restriction != "" ){
                
                // Vérifie le contexte de la modification et test si la restriction est valide.
                // Si l'instruction est modifiée par une tache le dossier n'est pas impacté.
                // Il n'est donc pas nécessaire de vérifier les restrictions.
                $this->restriction_valid = $this->restrictionIsValid($restriction);
                if ($this->getParameter("maj") != 176
                    && !$this->restriction_valid) {

                    // Affichage du message si la restriction s'applique
                    $this->addToMessage(
                        $this->get_restriction_error_message($restriction)
                    );
                    $this->correct=false;
                    return false;
                }

                // Liste des opérateurs possible
                $operateurs = array(">=", "<=", "+", "-", "&&", "||", "==", "!=");
                // Supprime tous les espaces de la chaîne de caractère
                $restriction = str_replace(' ', '', $restriction);
                
                // Met des espace avant et après les opérateurs puis transforme la 
                // chaine en un tableau 
                $tabRestriction = str_replace($operateurs, " ", $restriction);
                // Tableau des champ
                $tabRestriction = explode(" ", $tabRestriction);
                // Supprime les numériques du tableau
                foreach ($tabRestriction as $key => $value) {
                    if (is_numeric($value)) {
                        unset($tabRestriction[$key]);
                    }
                }

                // Vérifie les champs utilisés pour la restriction
                $check_field_exist = $this->f->check_field_exist($tabRestriction, 'instruction');
                if ($check_field_exist !== true) {

                    // Liste des champs en erreur
                    $string_error_fields = implode(", ", $check_field_exist);

                    // Message d'erreur
                    $error_message = _("Le champ %s n'est pas utilisable pour le champ %s");
                    if (count($check_field_exist) > 1) {
                        $error_message = _("Les champs %s ne sont pas utilisable pour le champ %s");
                    }

                    // Affiche l'erreur
                    $this->correct=false;
                    $this->addToMessage(sprintf($error_message, $string_error_fields, _("restriction")));
                    $this->addToMessage(_("Veuillez contacter votre administrateur."));
                }
            }

        }
        if(!$this->updateDate("date_envoi_signature")) {
            return false;
        }
        if(!$this->updateDate("date_retour_signature")) {
            return false;
        }
        if(!$this->updateDate("date_envoi_rar")) {
            return false;
        }
        if(!$this->updateDate("date_retour_rar")) {
            return false;
        }
        if(!$this->updateDate("date_envoi_controle_legalite")) {
            return false;
        }
        if(!$this->updateDate("date_retour_controle_legalite")) {
            return false;
        }

    }

    /**
     * Récupère et stocket dans un tableau toutes les infos du pétitionnaire
     * principal du dossier auquel appartiens l'instruction.
     * Renvoie un tableau contenant les informations du pétitionnaire principal.
     *
     * Si l'identifiant de l'instruction n'a pas pu etre récupéré renvoie false
     * et affiche un message dans les logs.
     * En cas d'erreur de base de donnée renvoie false et affiche un message d'erreur.
     *
     * @param string identifiant du dossier
     * @return array|boolean
     */
    protected function get_info_petitionnaire_principal_dossier($dossier = null) {
        // Si l'identifiant de l'instruction n'a pas été fournit on récupère celui de
        // l'objet courant
        if (empty($dossier)) {
            $dossier = $this->getVal('dossier');
            // Si la récupération de l'identifiant de l'instruction a échoué la méthode renvoie
            // false et on affiche un message d'erreur dans les logs
            if (empty($dossier)) {
                $this->addToLog(__METHOD__.' : L\'identifiant du dossier n\'a pas pu être récupéré');
                return false;
            }
        }

        // Requête sql servant à récupérer toutes les informations relatives au demandeurs
        // principal
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    -- Récupère toutes les informations du demandeur principal
                    demandeur.*,
                    CASE
                        WHEN demandeur.qualite=\'particulier\' 
                        THEN TRIM(CONCAT(demandeur.particulier_nom, \' \', demandeur.particulier_prenom, \' \', demandeur.courriel)) 
                    ELSE
                        TRIM(CONCAT(demandeur.personne_morale_raison_sociale, \' \', demandeur.personne_morale_denomination, \' \', demandeur.courriel)) 
                    END AS destinataire
                FROM
                    %1$sdossier
                    LEFT JOIN %1$slien_dossier_demandeur
                        ON lien_dossier_demandeur.dossier = dossier.dossier 
                    LEFT JOIN %1$sdemandeur
                        ON demandeur.demandeur = lien_dossier_demandeur.demandeur 
                WHERE
                    dossier.dossier = \'%2$s\'
                    AND lien_dossier_demandeur.petitionnaire_principal IS TRUE',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if (is_array($qres["result"]) === true
            && array_key_exists(0, $qres["result"]) === true) {
            //
            return $qres["result"][0];
        }
        return null;
    }


    
    /**
     * Finalisation des documents.
     * @param  string $champ    champ du fichier à finaliser
     * @param  booleen $status  permet de définir si on finalise ou définalise
     * @param  string $sousform permet de savoir si se trouve dans un sousformulaire (passé au javascript)
     */
    function manage_finalizing($mode = null, $val = array()) {
        //
        $this->begin_treatment(__METHOD__);

        //
        $id_inst = $this->getVal($this->clePrimaire);

        //
        $admin_msg_error = _("Veuillez contacter votre administrateur.");
        $file_msg_error = _("Erreur de traitement de fichier.")
            ." ".$admin_msg_error;
        $bdd_msg_error = _("Erreur de base de données.")
            ." ".$admin_msg_error;
        $log_msg_error = "Finalisation non enregistrée - id instruction = %s - uid fichier = %s";

        // Si on finalise le document
        if ($mode == "finalize"){
            //
            $etat = _('finalisation');

            // Récupère la collectivite du dossier d'instruction
            $dossier_instruction_om_collectivite = $this->get_dossier_instruction_om_collectivite();

            //
            $collectivite = $this->f->getCollectivite($dossier_instruction_om_collectivite);

            //
            $params = array(
                "specific" => array(),
            );
            // Si la rédaction libre est activée sur l'instruction
            if ($this->getVal("flag_edition_integrale") == 't') {
                $params["specific"]["corps"] = array(
                    "mode" => "set",
                    "value" => $this->getVal("corps_om_htmletatex"),
                );
                $params["specific"]["titre"] = array(
                    "mode" => "set",
                    "value" => $this->getVal("titre_om_htmletat"),
                );
            }
            // Génération du PDF
            $result = $this->compute_pdf_output('lettretype', $this->getVal('lettretype'), $collectivite, null, $params);
            $pdf_output = $result['pdf_output'];

            //Métadonnées du document
            $metadata = array(
                'filename' => 'instruction_'.$id_inst.'.pdf',
                'mimetype' => 'application/pdf',
                'size' => strlen($pdf_output)
            );

            // Récupération des métadonnées calculées après validation
            $spe_metadata = $this->getMetadata("om_fichier_instruction");

            //On vérifie si l'instruction à finaliser a un événement de type arrete
            // TODO : A voir pour remplacer par une instanciation de l'événement.
            //        Voir également si l'événement ne dois pas être instancié en début de
            //        méthode pour pouvoir être réutilisé.
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        type
                    FROM 
                        %1$sevenement
                    WHERE 
                        evenement = \'%2$d\'',
                    DB_PREFIXE,
                    intval($this->getVal("evenement"))
                ), 
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );

            if ($qres["code"] !== "OK") {
                $this->correct = false;
                $this->addToMessage($bdd_msg_error);
                return $this->end_treatment(__METHOD__, false);
            }

            //Initialisation de la variable
            $arrete_metadata = array();
            // Si l'événement est de type arrete, on ajoute les métadonnées spécifiques
            if ($qres['result'] === 'arrete'){
                $arrete_metadata = $this->getMetadata("arrete");
            }

            $metadata = array_merge($metadata, $spe_metadata, $arrete_metadata);

            /*
            // transforme le tableau de métadonnées en objet
            $mdf = new MetadataFactory();
            $md = $mdf->build('Instruction', $metadata);
            */

            // Si le document a déjà été finalisé on le met à jour
            // en conservant son UID
            if ($this->getVal("om_fichier_instruction") != ''){
                $uid = $this->f->storage->update(
                    $this->getVal("om_fichier_instruction"), $pdf_output, $metadata);
            }
            // Sinon on crée un nouveau document et dont on récupère l'UID
            else {
                $uid = $this->f->storage->create($pdf_output, $metadata, "from_content", $this->table.".om_fichier_instruction");
            }
        }

        // Si on définalise le document
        if ($mode == "unfinalize") {
            //
            $etat = _('définalisation');
            // Récupération de l'uid du document finalisé
            $uid = $this->getVal("om_fichier_instruction");
        }
        
        // Si on définalise l'UID doit être défini
        // Si on finalise la création/modification du fichier doit avoir réussi
        if ($uid == '' || $uid == 'OP_FAILURE' ) {
            $this->correct = false;
            $this->addToMessage($file_msg_error);
            $this->addToLog(sprintf($log_msg_error, $id_inst, $uid), DEBUG_MODE);
            return $this->end_treatment(__METHOD__, false);
        }

        //
        foreach ($this->champs as $key => $champ) {
            //
            $val[$champ] = $this->val[$key];
        }

        //
        $val['date_evenement'] = $this->dateDBToForm($val['date_evenement']);
        $val['archive_date_complet'] = $this->dateDBToForm($val['archive_date_complet']);
        $val['archive_date_rejet'] = $this->dateDBToForm($val['archive_date_rejet']);
        $val['archive_date_limite'] = $this->dateDBToForm($val['archive_date_limite']);
        $val['archive_date_notification_delai'] = $this->dateDBToForm($val['archive_date_notification_delai']);
        $val['archive_date_decision'] = $this->dateDBToForm($val['archive_date_decision']);
        $val['archive_date_validite'] = $this->dateDBToForm($val['archive_date_validite']);
        $val['archive_date_achevement'] = $this->dateDBToForm($val['archive_date_achevement']);
        $val['archive_date_chantier'] = $this->dateDBToForm($val['archive_date_chantier']);
        $val['archive_date_conformite'] = $this->dateDBToForm($val['archive_date_conformite']);
        $val['archive_date_dernier_depot'] = $this->dateDBToForm($val['archive_date_dernier_depot']);
        $val['archive_date_limite_incompletude'] = $this->dateDBToForm($val['archive_date_limite_incompletude']);
        $val['date_finalisation_courrier'] = $this->dateDBToForm($val['date_finalisation_courrier']);
        $val['date_envoi_signature'] = $this->dateDBToForm($val['date_envoi_signature']);
        $val['date_retour_signature'] = $this->dateDBToForm($val['date_retour_signature']);
        $val['date_envoi_rar'] = $this->dateDBToForm($val['date_envoi_rar']);
        $val['date_retour_rar'] = $this->dateDBToForm($val['date_retour_rar']);
        $val['date_envoi_controle_legalite'] = $this->dateDBToForm($val['date_envoi_controle_legalite']);
        $val['date_retour_controle_legalite'] = $this->dateDBToForm($val['date_retour_controle_legalite']);
        $val['archive_date_cloture_instruction'] = $this->dateDBToForm($val['archive_date_cloture_instruction']);
        $val['archive_date_premiere_visite'] = $this->dateDBToForm($val['archive_date_premiere_visite']);
        $val['archive_date_derniere_visite'] = $this->dateDBToForm($val['archive_date_derniere_visite']);
        $val['archive_date_contradictoire'] = $this->dateDBToForm($val['archive_date_contradictoire']);
        $val['archive_date_retour_contradictoire'] = $this->dateDBToForm($val['archive_date_retour_contradictoire']);
        $val['archive_date_ait'] = $this->dateDBToForm($val['archive_date_ait']);
        $val['archive_date_transmission_parquet'] = $this->dateDBToForm($val['archive_date_transmission_parquet']);
        $val['archive_date_affichage'] = $this->dateDBToForm($val['archive_date_affichage']);
        $this->setvalF($val);

        // Verification de la validite des donnees
        $this->verifier($this->val);
        // Si les verifications precedentes sont correctes, on procede a
        // la modification, sinon on ne fait rien et on retourne une erreur
        if ($this->correct === true) {
            //
            $valF = array(
                "om_fichier_instruction" => $uid,
                "date_finalisation_courrier" => date('Y-m-d')
            );
            //
            if($mode=="finalize") {
                // état finalisé vrai
                $valF["om_final_instruction"] = true;
                // ajout log utilisateur
                $login = $_SESSION['login'];
                $nom = "";
                $this->f->getUserInfos();
                if (isset($this->f->om_utilisateur["nom"])
                    && !empty($this->f->om_utilisateur["nom"])) {
                    $nom = $this->f->om_utilisateur["nom"];
                }
                $valF["om_final_instruction_utilisateur"] = $_SESSION['login'];
                if ($nom != "") {
                    $valF["om_final_instruction_utilisateur"] .= " (".$nom.")";
                }
            } else {
                // état finalisé faux
                $valF["om_final_instruction"] = false;
                // suppression log utilisateur
                $valF["om_final_instruction_utilisateur"] = '';
            }

            // Execution de la requête de modification des donnees de l'attribut
            // valF de l'objet dans l'attribut table de l'objet
            $res = $this->f->db->autoExecute(DB_PREFIXE.$this->table, $valF, 
                DB_AUTOQUERY_UPDATE, $this->getCle($id_inst));
             $this->addToLog(__METHOD__."() : db->autoExecute(\"".DB_PREFIXE.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getCle($id_inst)."\")", VERBOSE_MODE);
            //
            if ($this->f->isDatabaseError($res, true) === true) {
                $this->correct = false;
                $this->addToMessage($bdd_msg_error);
                return $this->end_treatment(__METHOD__, false);
            }

            //
            $this->addToMessage(sprintf(_("La %s du document s'est effectuee avec succes."), $etat));
            //
            if ($this->add_log_to_dossier($id_inst, $val) === false) {
                return $this->end_treatment(__METHOD__, false);
            }
            //
            return $this->end_treatment(__METHOD__, true);
        }
        // L'appel de verifier() a déjà positionné correct à false
        // et défini un message d'erreur.
        $this->addToLog(sprintf($log_msg_error, $id_inst, $uid), DEBUG_MODE);
        return $this->end_treatment(__METHOD__, false);
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
     * @return date de la demande initiale
     */
    protected function getAnneemoisDemandeAutor() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->date_demande_initiale;
    }
    /**
     * Récupération du type de dossier d'instruction à ajouter aux métadonnées
     * @return string type du dossier d'instruction
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
     * @return string type du dossier d'autorisation
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
     * Récupération du libellé du type du document à ajouter aux métadonnées
     * @return string Groupe d'instruction
     */
    protected function getTitle() {

        // Récupère le champ événement
        if (isset($this->valF["evenement"]) AND $this->valF["evenement"] != "") {
            $evenement = $this->valF["evenement"];
        } else {
            $evenement = $this->getVal("evenement");
        }

        // Requête sql
        $evenement = $this->f->get_inst__om_dbform(array(
            "obj" => "evenement",
            "idx" => $evenement
        ));

        // Retourne le libelle de l'événement
        return $evenement->getVal('libelle');
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
            )
        );
        $row = array_shift($qres['result']);

        //Si il y a un résultat
        if (! empty($row)) {

            // Instrance de la classe dossier
            $inst_dossier = $this->get_inst_dossier($dossier);
            // TODO : améliorer ce code
            // 
            // Avant l e résultat été récupéré dans un objet à partir de la requête mais en modifiant pour
            // utiliser la méthode get_all_results_from_db_query() c'est maintenant un tableau
            // qu'on obtiens. Pour garder le même fonctionnement on transforme le tableau des
            // valeurs issues de la requête en objet.
            $metadata = (object)$row;
            // Insère l'attribut version à l'objet
            $metadata->version = $inst_dossier->get_di_numero_suffixe();

            //Alors on créé l'objet dossier_instruction
            $this->specificMetadata = $metadata;

        }
    }
    
    /**
     * Retourne le statut du dossier d'instruction
     * @param string $idx Identifiant du dossier d'instruction
     * @return string Le statut du dossier d'instruction
     */
    function getStatutAutorisationDossier($idx){
        
        $statut = '';
        
        //Si l'identifiant du dossier d'instruction fourni est correct
        if ( $idx != '' ){
            
            //On récupère le statut de l'état du dossier à partir de l'identifiant du
            //dossier
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        etat.statut
                    FROM 
                        %1$sdossier
                        LEFT JOIN
                            %1$setat
                            ON
                                dossier.etat = etat.etat
                    WHERE 
                        dossier = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($idx)
                ), 
                array(
                    "origin" => __METHOD__,
                )
            );
        }

        return $qres['result'];
    }

    /**
     * Récupère les données du dossier
     * @return array
     */
    function get_dossier_actual() {

        // Initialisation de la valeur de retour
        $return = array();

        // Récupération de toutes les valeurs du dossier d'instruction en cours
        // TODO : remplacer cette requête par une instanciation de l'objet
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$sdossier
                WHERE
                    dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->valF['dossier'])
            ),
            array(
                'origin' => __METHOD__
            )
        );

        foreach ($qres['result'] as $row) {

            // Récupération de la valeur actuelle du délai, de l'accord tacite,
            // de l'état et de l'avis du dossier d'instruction
            $return['archive_delai'] = $row['delai'];
            $return['archive_accord_tacite'] = $row['accord_tacite'];
            $return['archive_etat'] = $row['etat'];
            $return['archive_avis'] = $row['avis_decision'];
            // Récupération de la valeur actuelle des dates du dossier
            // d'instruction
            $return['archive_date_complet'] = $row['date_complet'];
            $return['archive_date_dernier_depot'] = $row['date_dernier_depot'];
            $return['archive_date_rejet'] = $row['date_rejet'];
            $return['archive_date_limite'] = $row['date_limite'];
            $return['archive_date_notification_delai'] = $row['date_notification_delai'];
            $return['archive_date_decision'] = $row['date_decision'];
            $return['archive_date_validite'] = $row['date_validite'];
            $return['archive_date_achevement'] = $row['date_achevement'];
            $return['archive_date_chantier'] = $row['date_chantier'];
            $return['archive_date_conformite'] = $row['date_conformite'];
            $return['archive_incompletude'] = $row['incompletude'];
            $return['archive_incomplet_notifie'] = $row['incomplet_notifie'];
            $return['archive_evenement_suivant_tacite'] = $row['evenement_suivant_tacite'];
            $return['archive_evenement_suivant_tacite_incompletude'] = $row['evenement_suivant_tacite_incompletude'];
            $return['archive_etat_pendant_incompletude'] = $row['etat_pendant_incompletude'];
            $return['archive_date_limite_incompletude'] = $row['date_limite_incompletude'];
            $return['archive_delai_incompletude'] = $row['delai_incompletude'];
            $return['archive_autorite_competente'] = $row['autorite_competente'];
            $return['archive_dossier_instruction_type'] = $row['dossier_instruction_type'];
            $return['duree_validite'] = $row['duree_validite'];
            $return['date_depot'] = $row['date_depot'];
            $return['date_depot_mairie'] = $row['date_depot_mairie'];
            $return['archive_date_cloture_instruction'] = $row['date_cloture_instruction'];
            $return['archive_date_premiere_visite'] = $row['date_premiere_visite'];
            $return['archive_date_derniere_visite'] = $row['date_derniere_visite'];
            $return['archive_date_contradictoire'] = $row['date_contradictoire'];
            $return['archive_date_retour_contradictoire'] = $row['date_retour_contradictoire'];
            $return['archive_date_ait'] = $row['date_ait'];
            $return['archive_date_transmission_parquet'] = $row['date_transmission_parquet'];
            $return['archive_date_affichage'] = $row['date_affichage'];
            $return['archive_pec_metier'] = $row['pec_metier'];
            $return['archive_a_qualifier'] = $row['a_qualifier'];
        }

        // Retour de la fonction
        return $return;

    }

    /**
     * Permet de vérifier qu'un événement est verrouillable
     * @param  integer $idx     Identifiant de l'instruction
     * @return boolean          
     */
    function checkEvenementNonVerrouillable($idx) {
        // Si la condition n'est pas vide
        if ($idx != "") {

            // Requête SQL
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        evenement.non_verrouillable
                    FROM 
                        %1$sevenement
                        LEFT JOIN %1$sinstruction
                            ON instruction.evenement = evenement.evenement
                    WHERE 
                        instruction.instruction = \'%2$s\'',
                    DB_PREFIXE,
                    intval($idx)
                ), 
                array(
                    "origin" => __METHOD__,
                )
            );
        }

        // Si on a un résultat et que ce résultat indique que l'événement n'est
        // pas vérrouillable renvoie true, sinon renvoie false
        return isset($qres) && isset($qres['result']) && $qres['result'] == 't';
    }
    
    /**
     * Mise à jour des champs archive_*
     * @param mixed $row La ligne de données
     */
    public function updateArchiveData($row){
        
        // Récupération de la valeur actuelle du délai, de l'accord tacite,
        // de l'état et de l'avis du dossier d'instruction
        $this->valF['archive_delai']=$row['delai'];
        $this->valF['archive_accord_tacite']=$row['accord_tacite'];
        $this->valF['archive_etat']=$row['etat'];
        $this->valF['archive_avis']=$row['avis_decision'];
        // Récupération de la valeur actuelle des 9 dates du dossier
        // d'instruction
        if ($row['date_complet'] != '') {
            $this->valF['archive_date_complet']=$row['date_complet'];
        }
        if ($row['date_dernier_depot'] != '') {
            $this->valF['archive_date_dernier_depot']=$row['date_dernier_depot'];
        }
        if ($row['date_rejet'] != '') {
            $this->valF['archive_date_rejet']= $row['date_rejet'];
        }
        if ($row['date_limite'] != '') {
            $this->valF['archive_date_limite']= $row['date_limite'];
        }
        if ($row['date_notification_delai'] != '') {
            $this->valF['archive_date_notification_delai']= $row['date_notification_delai'];
        }
        if ($row['date_decision'] != '') {
            $this->valF['archive_date_decision']= $row['date_decision'];
        }
        if ($row['date_validite'] != '') {
            $this->valF['archive_date_validite']= $row['date_validite'];
        }
        if ($row['date_achevement'] != '') {
            $this->valF['archive_date_achevement']= $row['date_achevement'];
        }
        if ($row['date_chantier'] != '') {
            $this->valF['archive_date_chantier']= $row['date_chantier'];
        }
        if ($row['date_conformite'] != '') {
            $this->valF['archive_date_conformite']= $row['date_conformite'];  
        }
        if ($row['incompletude'] != '') {
            $this->valF['archive_incompletude']= $row['incompletude'];  
        }
        if ($row['incomplet_notifie'] != '') {
            $this->valF['archive_incomplet_notifie']= $row['incomplet_notifie'];  
        }
        if ($row['evenement_suivant_tacite'] != '') {
            $this->valF['archive_evenement_suivant_tacite']= $row['evenement_suivant_tacite'];  
        }
        if ($row['evenement_suivant_tacite_incompletude'] != '') {
            $this->valF['archive_evenement_suivant_tacite_incompletude']= $row['evenement_suivant_tacite_incompletude'];  
        }
        if ($row['etat_pendant_incompletude'] != '') {
            $this->valF['archive_etat_pendant_incompletude']= $row['etat_pendant_incompletude'];  
        }
        if ($row['date_limite_incompletude'] != '') {
            $this->valF['archive_date_limite_incompletude']= $row['date_limite_incompletude'];  
        }
        if ($row['delai_incompletude'] != '') {
            $this->valF['archive_delai_incompletude']= $row['delai_incompletude'];  
        }
        if ($row['autorite_competente'] != '') {
            $this->valF['archive_autorite_competente']= $row['autorite_competente'];  
        }
        if ($row['duree_validite'] != '') {
            $this->valF['duree_validite']= $row['duree_validite'];  
        }
        if ($row['date_depot'] != '') {
            $this->valF['date_depot']= $row['date_depot'];  
        }
        if ($row['date_depot_mairie'] != '') {
            $this->valF['date_depot_mairie']= $row['date_depot_mairie'];  
        }
        // Dates concernant les dossiers contentieux
        if ($row['date_cloture_instruction'] != '') {
            $this->valF['archive_date_cloture_instruction']= $row['date_cloture_instruction'];  
        }
        if ($row['date_premiere_visite'] != '') {
            $this->valF['archive_date_premiere_visite']= $row['date_premiere_visite'];  
        }
        if ($row['date_derniere_visite'] != '') {
            $this->valF['archive_date_derniere_visite']= $row['date_derniere_visite'];  
        }
        if ($row['date_contradictoire'] != '') {
            $this->valF['archive_date_contradictoire']= $row['date_contradictoire'];  
        }
        if ($row['date_retour_contradictoire'] != '') {
            $this->valF['archive_date_retour_contradictoire']= $row['date_retour_contradictoire'];  
        }
        if ($row['date_ait'] != '') {
            $this->valF['archive_date_ait']= $row['date_ait'];  
        }
        if ($row['date_transmission_parquet'] != '') {
            $this->valF['archive_date_transmission_parquet']= $row['date_transmission_parquet'];  
        }
        //
        if ($row['dossier_instruction_type'] != '') {
            $this->valF['archive_dossier_instruction_type']= $row['dossier_instruction_type'];  
        }
        if ($row['date_affichage'] != '') {
            $this->valF['archive_date_affichage']= $row['date_affichage'];  
        }
        if (isset($row['pec_metier']) === true && $row['pec_metier'] != '') {
            $this->valF['archive_pec_metier']= $row['pec_metier'];  
        }
        if (isset($row['a_qualifier']) === true && $row['a_qualifier'] != '') {
            $this->valF['archive_a_qualifier']= $row['a_qualifier'];  
        }
    }

    // {{{
    // Méthodes de récupération des métadonnées arrêté
    /**
     * @return string Retourne le numéro d'arrêté
     */
    function getNumArrete() {
        return $this->getVal("numero_arrete");
    }
    /**
     * @return chaîne vide
     */
    function getReglementaireArrete() {
        return 'true';
    }
    /**
     * @return boolean de notification au pétitionnaire
     */
    function getNotificationArrete() {
        return 'true';
    }
    /**
     * @return date de notification au pétitionnaire
     */
    function getDateNotificationArrete() {
        if (empty($this->metadonneesArrete)) {
            $this->getArreteMetadata();
        }
        return $this->metadonneesArrete["datenotification"];
    }
    /**
     * @return boolean check si le document est passé au contrôle de légalité
     */
    function getControleLegalite() {
        return 'true';
    }
    /**
     * @return date de signature de l'arrêté
     */
    function getDateSignature() {
        if (empty($this->metadonneesArrete)) {
            $this->getArreteMetadata();
        }
        return $this->metadonneesArrete["datesignaturearrete"];
    }
    /**
     * @return string nom du signataire
     */
    function getNomSignataire() {
        if (empty($this->metadonneesArrete)) {
            $this->getArreteMetadata();
        }
        return $this->metadonneesArrete["nomsignataire"];
    }
    /**
     * @return string qualité du signataire
     */
    function getQualiteSignataire() {
        if (empty($this->metadonneesArrete)) {
            $this->getArreteMetadata();
        }
        return $this->metadonneesArrete["qualitesignataire"];
    }
    /**
     * @return string numéro du terrain
     */
    function getAp_numRue() {
        if (empty($this->metadonneesArrete)) {
            $this->getArreteMetadata();
        }
        return $this->metadonneesArrete["ap_numrue"];
    }
    /**
     * @return string nom de la rue du terrain
     */
    function getAp_nomDeLaVoie() {
        if (empty($this->metadonneesArrete)) {
            $this->getArreteMetadata();
        }
        return $this->metadonneesArrete["ap_nomdelavoie"];
    }
    /**
     * @return string code postal du terrain
     */
    function getAp_codePostal() {
        if (empty($this->metadonneesArrete)) {
            $this->getArreteMetadata();
        }
        return $this->metadonneesArrete["ap_codepostal"];
    }
    /**
     * @return string ville du terrain
     */
    function getAp_ville() {
        if (empty($this->metadonneesArrete)) {
            $this->getArreteMetadata();
        }
        return $this->metadonneesArrete["ap_ville"];
    }
    /**
     * @return string activité
     */
    function getActivite() {
        return "Droit du sol";
    }
    /**
     * @return string date du retour de controle légalité
     */
    function getDateControleLegalite() {
        if (empty($this->metadonneesArrete)) {
            $this->getArreteMetadata();
        }
        return $this->metadonneesArrete["datecontrolelegalite"];
    }

    // Fin des méthodes de récupération des métadonnées
    // }}}

    /**
     * Méthode de récupération des métadonnées arrêtés dans la base de données,
     * les données sont stockés dans l'attribut $this->metadonneesArrete
     */
    function getArreteMetadata() {

        //Récupération de la dernière instruction dont l'événement est de type 'arrete'
        $this->metadonneesArrete = array("nomsignataire"=>"", "qualitesignataire"=>"",
            "decisionarrete"=>"", "datenotification"=>"", "datesignaturearrete"=>"",
            "datecontrolelegalite"=>"", "ap_numrue"=>"", "ap_nomdelavoie"=>"",
            "ap_codepostal"=>"", "ap_ville"=>"");

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    signataire_arrete.prenom || \' \' ||signataire_arrete.nom as nomsignataire,
                    signataire_arrete.qualite as qualitesignataire,
                    instruction.etat as decisionarrete,
                    instruction.date_retour_rar as datenotification,
                    instruction.date_retour_signature as datesignaturearrete,
                    instruction.date_retour_controle_legalite as datecontrolelegalite,
                    dossier.terrain_adresse_voie_numero as ap_numrue,
                    dossier.terrain_adresse_voie as ap_nomdelavoie,
                    dossier.terrain_adresse_code_postal as ap_codepostal,
                    dossier.terrain_adresse_localite as ap_ville
                FROM
                    %1$sinstruction
                    LEFT JOIN %1$ssignataire_arrete
                        ON instruction.signataire_arrete = signataire_arrete.signataire_arrete
                    LEFT JOIN %1$sdossier
                        ON instruction.dossier = dossier.dossier
                    LEFT JOIN %1$sdonnees_techniques
                        ON donnees_techniques.dossier_instruction = dossier.dossier
                WHERE
                    instruction.instruction = %2$d',
                DB_PREFIXE,
                intval($this->getVal('instruction'))
            ),
            array(
                'origin' => __METHOD__
            )
        );
        $this->metadonneesArrete = array_shift($qres['result']);
    }

    /**
     * CONDITION - has_an_edition.
     *
     * Condition pour afficher le bouton de visualisation de l'édition.
     *
     * @return boolean
     */
    function has_an_edition() {
        // Récupère la valeur du champ lettretype
        $lettretype = $this->getVal("lettretype");
        // Si le champ est vide
        if ($lettretype !== '' && $lettretype !== null) {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * CONDITION - is_modifiable.
     *
     * Controle si l'évenement est modifiable.
     *
     * @return boolean
     */
    function is_evenement_modifiable() {
        $evenement = $this->get_inst_evenement($this->getVal('evenement'));
        return ! $this->get_boolean_from_pgsql_value($evenement->getVal('non_modifiable'));
    }

    /**
     * CONDITION - is_editable.
     *
     * Condition pour la modification.
     *
     * @return boolean
     */
    function is_editable() {

        // XXX
        // Identifier si l'instruction est lié à une tâche depuis le champ object_id (mais aussi voir le log car object_id peut être modifié)
        // Si cette tâche identifiée est DONE alors la suppression/modification de cette intruction est impossible

        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_modifier_bypass");
        //
        if ($bypass == true) {
            //
            return true;
        }
        
        // Si l'utilisateur est un instructeur, que le dossier est cloturé et
        // que l'événement n'est pas identifié comme non verrouillable
        if ($this->f->isUserInstructeur()
            && $this->getStatutAutorisationDossier($this->getParameter("idxformulaire")) == "cloture"
            && $this->checkEvenementNonVerrouillable($this->getVal("instruction")) === false) {
            //
            return false;
        }

        // Si l'utilisateur est un intructeur qui correspond à la division du
        // dossier
        if ($this->is_instructeur_from_division_dossier() === true) {
            //
            return true;
        }

        // Si l'utilisateur est instructeur de la commune du dossier et que
        // l'instruction est créée par un instructeur de la commune
        if ($this->is_instructeur_from_collectivite_dossier() === true and
            $this->getVal('created_by_commune') === 't') {
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie si l'événement est supprimable ou pas.
     *
     * @return boolean
     */
    function is_evenement_supprimable() {
        // Controle si l'évenement est supprimable
        $evenement = $this->get_inst_evenement($this->getVal('evenement'));
        return ! $this->get_boolean_from_pgsql_value($evenement->getVal('non_supprimable'));
    }

    /**
     * CONDITION - is_deletable.
     *
     * Condition pour la suppression.
     *
     * @return boolean
     */
    function is_deletable() {

        // XXX
        // Identifier si l'instruction est lié à une tâche depuis le champ object_id (mais aussi voir le log car object_id peut être modifié)
        // Si cette tâche identifiée est DONE alors la suppression/modification de cette intruction est impossible

        // Contrôle si l'utilisateur possède un bypass intégral
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_supprimer_bypass");
        //
        if ($bypass == true) {

            //
            return true;
        }

        // Si l'utilisateur est un intructeur qui ne correspond pas à la
        // division du dossier et si l'utilisateur n'a pas la permission bypass
        // de la division
        if ($this->is_instructeur_from_division_dossier() === false
            && $this->f->isAccredited($this->get_absolute_class_name()."_supprimer_bypass_division") === false) {

            //
            return false;
        }
        
        // l'événement est-il le dernier ?
        $dernier_evenement = false;
        // instanciation dossier
        $dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $this->getVal('dossier'),
        ));
        // récupération dernier événement
        $id_dernier_evenement = $dossier->get_dernier_evenement();
        if ($id_dernier_evenement == $this->getVal($this->clePrimaire)) {
            $dernier_evenement = true;
        }

        // Si dossier cloturé ou si pas dernier événement
        // ou de type retour ou si une date est renseignée
        // ET utilisateur non administrateur
        if ($this->getStatutAutorisationDossier($this->getVal('dossier')) == 'cloture'
            || $dernier_evenement == false
            || $this->is_evenement_retour($this->getVal("evenement")) == true
            || $this->getVal('date_envoi_signature') != ''
            || $this->getVal('date_retour_signature') != ''
            || $this->getVal('date_envoi_rar') != ''
            || $this->getVal('date_retour_rar') != ''
            || $this->getVal('date_envoi_controle_legalite') != ''
            || $this->getVal('date_retour_controle_legalite') != '') {
            // pas le droit de supprimer
            return false;;
        }

        //
        return true;
    }
    
    
    /**
     * Vérifie que l'utilisateur est instructeur et qu'il est de la division du
     * dossier.
     *
     * @return,  boolean true/false
     */
    function is_instructeur_from_collectivite_dossier() {
        if ($this->f->isUserInstructeur() === true and
            $this->f->om_utilisateur["om_collectivite"] == $this->get_dossier_instruction_om_collectivite()) {
            return true;
        }
        return false;
    }
    
    /**
     * CONDITION - is_addable.
     * 
     * Condition pour afficher les boutons modifier et supprimer.
     *
     * @return boolean
     */
    function is_addable() {
        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_ajouter_bypass");
        //
        if ($bypass == true) {

            //
            return true;
        }
        // Si l'utilisateur est un intructeur qui correspond à la
        // division du dossier ou qu'il peut changer la décision
        if ($this->is_instructeur_from_division_dossier() === true or
            $this->isInstrCanChangeDecision($this->getParameter('idxformulaire')) === true) {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * CONDITION - is_finalizable.
     *
     * Condition pour afficher le bouton.
     *
     * @return boolean
     */
    function is_finalizable() {
        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_finaliser_bypass");
        //
        if ($bypass == true) {
            //
            return true;
        }
        
        // Si l'utilisateur est un instructeur, que le dossier est cloturé et
        // que l'événement n'est pas identifié comme non verrouillable
        if ($this->f->isUserInstructeur()
            && $this->getStatutAutorisationDossier($this->getParameter("idxformulaire")) == "cloture"
            && $this->checkEvenementNonVerrouillable($this->getVal("instruction")) === false) {
            //
            return false;
        }
        
        // Si l'utilisateur est un intructeur qui correspond à la division du
        // dossier
        if ($this->is_instructeur_from_division_dossier() === true) {
            //
            return true;
        }

        // Si l'utilisateur est instructeur de la commune du dossier et que
        // l'instruction est créée par un instructeur de la commune
        if ($this->is_instructeur_from_collectivite_dossier() === true and
            $this->getVal('created_by_commune') === 't') {
            return true;
        }

        //
        return false;
    }

    /**
     * CONDITION - is_finalize_without_bypass.
     *
     * Condition pour afficher le bouton sans le bypass.
     *
     * @return boolean [description]
     */
    function is_finalizable_without_bypass() {
        // Récupère la valeur du champ finalisé
        $om_final_instruction = $this->getVal('om_final_instruction');

        // Si le rapport n'est pas finalisé
        if (empty($om_final_instruction)
            || $om_final_instruction == 'f') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * CONDITION - is_unfinalizable.
     *
     * Condition pour afficher le bouton.
     *
     * @return boolean
     */
    function is_unfinalizable(){
        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_definaliser_bypass");
        //
        if ($bypass == true) {
            //
            return true;
        }
        
        // Si l'utilisateur est un instructeur, que le dossier est cloturé et
        // que l'événement n'est pas identifié comme non verrouillable
        if ($this->f->isUserInstructeur()
            && $this->getStatutAutorisationDossier($this->getParameter("idxformulaire")) == "cloture"
            && $this->checkEvenementNonVerrouillable($this->getVal("instruction")) === false) {
            //
            return false;
        }

        // Si l'utilisateur est un intructeur qui correspond à la division du
        // dossier
        if ($this->is_instructeur_from_division_dossier() === true) {
            //
            return true;
        }

        // Si l'utilisateur est instructeur de la commune du dossier et que
        // l'instruction est créée par un instructeur de la commune
        if ($this->is_instructeur_from_collectivite_dossier() === true and
            $this->getVal('created_by_commune') === 't') {
            return true;
        }

        //
        return false;
    }

    /**
     * CONDITION - is_unfinalizable_without_bypass.
     *
     * Condition pour afficher le bouton sans le bypass.
     *
     * @return boolean
     */
    function is_unfinalizable_without_bypass() {
        // Récupère la valeur du champ finalisé
        $om_final_instruction = $this->getVal('om_final_instruction');

        // Si l'instruction est finalisée
        if ($om_final_instruction == 't') {
            //
            return true;
        }

        //
        return false;
    }


    /**
     * Permet de définir si un instructeur commune peut editer une instruction
     *
     * @return boolean true si il peut
     */
    function isInstrCanChangeDecision($idx) {
        
        if ($this->f->isAccredited(array("instruction", "instruction_changer_decision"), "OR") !== true or
            $this->f->isUserInstructeur() !== true) {
            return false;
        }
        
        

        // Sinon on vérifie l'éligibilité du dossier au changement de décision
        // /!\ Requête lié à celles du widget indiquant les dossiers éligible au changement
        // de décision :
        //   * dossier_instruction.class.php : view_widget_dossiers_evenement_retour_finalise()
        //   * dossier_instruction.inc.php : si le paramètre filtre_decision = true
        $sql = sprintf(
            'SELECT
                dossier.dossier
            FROM
                %1$sdossier
                JOIN %1$setat
                    ON dossier.etat = etat.etat AND etat.statut = \'encours\'
                JOIN %1$slien_dossier_demandeur
                    ON dossier.dossier = lien_dossier_demandeur.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
                JOIN %1$sdossier_instruction_type
                    ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type
                JOIN %1$sinstruction
                    -- Recherche de la dernière instruction qui ne soit pas liée à un événement retour
                    ON instruction.instruction = (
                            SELECT instruction
                            FROM %1$sinstruction
                            JOIN %1$sevenement ON instruction.evenement=evenement.evenement
                            AND evenement.retour IS FALSE
                            WHERE instruction.dossier = dossier.dossier
                            ORDER BY date_evenement DESC, instruction DESC
                            LIMIT 1
                        )
                        -- On ne garde que les dossiers pour lesquels la dernière instruction est finalisée
                        -- ou alors pour laquelle l instruction a été ajouté par la commune et est
                        -- non signée, non notifié, etc.
                        AND (instruction.om_final_instruction IS TRUE
                            OR instruction.created_by_commune IS TRUE)
                        AND instruction.date_retour_signature IS NULL
                        AND instruction.date_envoi_rar IS NULL
                        AND instruction.date_retour_rar IS NULL
                        AND instruction.date_envoi_controle_legalite IS NULL
                        AND instruction.date_retour_controle_legalite IS NULL
                -- On vérifie que l instruction soit un arrêté ou un changement de décision
                JOIN %1$sevenement
                    ON instruction.evenement=evenement.evenement
                        AND (evenement.type = \'arrete\'
                            OR evenement.type = \'changement_decision\')
                -- Recherche les informations du pétitionnaire principal pour l affichage
                JOIN %1$sdemandeur
                    ON lien_dossier_demandeur.demandeur = demandeur.demandeur
                -- Recherche la collectivité rattachée à l instructeur
                JOIN %1$sinstructeur
                    ON dossier.instructeur=instructeur.instructeur
                JOIN %1$sdivision
                    ON instructeur.division=division.division
                JOIN %1$sdirection
                    ON division.direction=direction.direction
                JOIN %1$som_collectivite
                    ON direction.om_collectivite=om_collectivite.om_collectivite
            WHERE
                -- Vérification que la décision a été prise par l agglo
                om_collectivite.niveau = \'2\'
                AND dossier.dossier = \'%2$s\'
            ',
            DB_PREFIXE,
            $this->f->db->escapeSimple($idx)
        );


        // Si collectivité de l'utilisateur niveau mono alors filtre sur celle-ci
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $sql .= sprintf(
                ' AND dossier.om_collectivite = %1$d',
                intval($_SESSION['collectivite'])
            );
        }
        $qres = $this->f->get_one_result_from_db_query(
            $sql, 
            array(
                "origin" => __METHOD__,
            )
        );

        return $qres['result'] !== null;
    }


    /**
     * CONDITION - can_monitoring_dates.
     *
     * Condition pour afficher le bouton de suivi des dates.
     *
     * @return boolean
     */
    public function can_monitoring_dates() {
        // Récupère la valeur du champ finalisé
        $om_final_instruction = $this->getVal('om_final_instruction');

        // Si l'instruction n'est pas finalisée
        if ($om_final_instruction !== 't') {
            //
            return false;
        }

        // Contrôle si l'utilisateur possède un bypass
        $bypass = $this->f->isAccredited($this->get_absolute_class_name()."_modification_dates_bypass");
        if ($bypass === true) {
            return true;
        }

        // Permission de modifier le suivi des dates sur un dossier cloturé pour
        // un utilisateur lié à un instructeur
        $perm_moni_dates_d_closed = $this->f->isAccredited($this->get_absolute_class_name()."_modification_dates_cloture");

        // On vérifie en premier lieu que le DI n'est pas clôturé et que
        // l'utilisateur ne possède pas la permission de modifier le suivi des
        // dates sur un dossier clôturé
        $inst_dossier = $this->get_inst_dossier();
        if ($inst_dossier->getStatut() === 'cloture'
            && $perm_moni_dates_d_closed === false) {
            //
            return false;
        }
        // On récupère ses infos
        $coll_di = $inst_dossier->getVal('om_collectivite');
        $div_di = $this->getDivisionFromDossier();
        // et celles de son éventuel instructeur
        $instr_di = $inst_dossier->getVal('instructeur');

        // Il faut disposer d'une entrée instructeur
        if ($this->f->isUserInstructeur() === false) {
            return false;
        }

        // Par défaut on prétend que l'instructeur n'est pas multi
        $instr_di_coll_multi = false;
        // Si un instructeur est affecté au dossier
        if ($instr_di !== '' && $instr_di !== null) {
            // Vérifie si l'instructeur est de la collectivité de niveau 2
            $instr_di_coll = $this->get_instructeur_om_collectivite($instr_di);
            if ($this->f->isCollectiviteMono($instr_di_coll) === false) {
                //
                $instr_di_coll_multi = true;
            }
        }

        // Il faut qu'il instruise le dossier ou soit de la même division
        if ($this->f->om_utilisateur['instructeur'] === $instr_di
                || $this->f->om_utilisateur['division'] === $div_di) {
            //
            return true;
        }

        // On donne également le droit s'il est de la même collectivité que
        // le dossier ET si l'instruction est déléguée à la communauté
        if ($this->f->isCollectiviteMono($this->f->om_utilisateur['om_collectivite']) === true
            && $this->f->om_utilisateur['om_collectivite'] === $coll_di
            && $instr_di_coll_multi === true) {
            //
            return true;
        }

        // Si l'instructeur ne rentre pas dans les deux cas précédents
        return false;
    }


    /**
     * CONDITION - is_finalized.
     *
     * Condition pour vérifier si une instruction est finalisée.
     *
     * @return boolean
     */
    public function is_finalized() {

        return $this->getVal('om_final_instruction') === "t";
    }

    /**
     * CONDITION - is_not_date_retour_signature_set.
     *
     * Condition pour vérifier si une date de retour signature n'est pas définie.
     *
     * @return boolean
     */
    public function is_not_date_retour_signature_set() {

        return $this->getVal('date_retour_signature') == null;

    }


    /**
     * TREATMENT - finalize.
     *
     * Permet de finaliser un enregistrement.
     *
     * @param array $val valeurs soumises par le formulaire
     *
     * @return boolean
     */
    function finalize($val = array()) {

        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);
        $message = '';
        $ev = $this->get_inst_evenement($this->getVal('evenement'));

        // Controle du signataire
        if (! $this->controle_signataire($ev)) {
            $this->addToMessage(__("Le document ne peut pas être finalisé car aucun signataire n'a été sélectionné."));
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }

        // Traitement de la finalisation
        $ret = $this->manage_finalizing("finalize", $val);

        // Si le traitement retourne une erreur
        if ($ret !== true) {

            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }

        // Envoi des notifications aux demandeurs si la notification est automatique
        // et que la signature n'est pas requise
        if ($ev->getVal('notification') === 'notification_automatique') {
            // Préparation du message de log en cas d'erreur de notification
            $msgLog = sprintf(
                '%s %s : %d',
                __('Erreur lors de la notification automatique du(des) pétitionnaire(s) suite à la finalisation de l\'instruction.'),
                __('Instruction notifiée'),
                $this->getVal($this->clePrimaire)
            );
            // Récupération de la catégorie et envoie des notifications au(x) demandeur(s)
            $collectivite_di = $this->get_dossier_instruction_om_collectivite($this->getVal('dossier'));
            // Récupération de la liste des demandeurs à notifier et de la catégorie
            $categorie = $this->f->get_param_option_notification($collectivite_di);
            $isPortal = $categorie === PORTAL;
            $demandeursANotifie = $this->get_demandeurs_notifiable(
                $this->getVal('dossier'),
                $isPortal
            );

            // Création d'une notification et d'une tâche pour chaque demandeur à notifier
            $demandeurPrincipalNotifie = false;
            if (count($demandeursANotifie) > 0) {
                foreach ($demandeursANotifie as $demandeur) {
                    // Identifie si le demandeur principal a été notifié ou pas
                    // et récupère ses informations
                    if ($demandeur['petitionnaire_principal'] == 't') {
                        $demandeurPrincipalNotifie = true;
                        // Si le demandeur principal est notifiable mais qu'il y a des erreurs dans
                        // son paramétrage, on effectue pas le traitement et on passe à l'itération
                        // suivante. On le considère également comme non notifié pour gérer l'envoie
                        // des messages d'erreurs
                        // Si la demande a été déposée via le portail alors le paramétrage n'a pas
                        // d'impact sur la notification
                        $erreursParam = $this->get_info_notification_fail();
                        if (! $this->dossier_depose_sur_portail() && $erreursParam != array()) {
                            $demandeurPrincipalNotifie = false;
                            continue;
                        }
                    }
                    // Ajout de la notif et récupération de son id
                    $idNotif = $this->ajouter_notification(
                        $this->getVal($this->clePrimaire),
                        $this->f->get_connected_user_login_name(),
                        $demandeur,
                        $collectivite_di,
                        array(),
                        true
                    );
                    if ($idNotif === false) {
                        // Termine le traitement
                        $this->addToLog(
                            sprintf('%s() : %s', __METHOD__, $msgLog),
                            DEBUG_MODE
                        );
                        return $this->end_treatment(__METHOD__, false);
                    }
                    $notification_by_task = $this->notification_by_task(
                        $idNotif,
                        $this->getVal('dossier'),
                        $categorie
                    );
                    if ($notification_by_task === false) {
                        $this->addToLog(
                            sprintf('%s() : %s', __METHOD__, $msgLog),
                            DEBUG_MODE
                        );
                        $this->addToMessage(
                            __("Erreur lors de la génération de la notification au(x) pétitionnaire(s).")
                        );
                        // Termine le traitement
                        return $this->end_treatment(__METHOD__, false);
                    }
                    $this->addToMessage($message .= sprintf('%s<br/>%s', __("La notification a été générée."), __("Le suivi de la notification est disponible depuis l'instruction.")));
                }
            }
            // Pour la notification par mail ou la notification via portal si le dossier a
            // été déposés via portal, si le demandeur principal n'est pas notifiable,
            // on créé une nouvelle notification en erreur avec en commentaire la raison pour
            // laquelle le demandeur principal n'a pas pu être notifié
            $depotPortal = $this->dossier_depose_sur_portail();
            if (! $demandeurPrincipalNotifie && ($isPortal === false || $depotPortal === true)) {
                // Préparation des logs pour indiquer que le pétitionnaire principale n'est pas notifiable
                $msgLog .= sprintf(' %s', __('Le pétitionnaire principale n\'est pas notifiable.'));
                // Analyse pour savoir pourquoi le demandeur principal n'est pas notifiable
                $erreursParam = $this->get_info_notification_fail();
                $demandeurPrincipal = $this->get_info_petitionnaire_principal_dossier($this->getVal('dossier'));
                // Ajout de la notif et récupération de son id
                $idNotif = $this->ajouter_notification(
                    $this->valF[$this->clePrimaire],
                    $this->f->get_connected_user_login_name(),
                    $demandeurPrincipal,
                    $collectivite_di,
                    array(),
                    true,
                    'Echec',
                    implode(' ', $erreursParam)
                );
                if ($idNotif === false) {
                    $this->addToMessage(
                        __('Erreur : la création de la notification a échouée.').
                        __("Veuillez contacter votre administrateur.")
                    );
                    $this->addToLog(
                        sprintf('%s() : %s', __METHOD__, $msgLog),
                        DEBUG_MODE
                    );
                    return false;
                }
                // Prépare un message d'alerte à destination de l'instructeur pour l'informer
                // de l'échec de la notification
                $dossier_message = $this->get_inst_dossier_message(0);
                $dossier_message_val = array(
                    'dossier' => $this->getVal('dossier'),
                    'type' => _('erreur expedition'),
                    'emetteur' => $this->f->get_connected_user_login_name(),
                    'login' => $_SESSION['login'],
                    'date_emission' => date('Y-m-d H:i:s'),
                    'contenu' => _('Échec lors de la notification de l\'instruction ').
                        $ev->getVal('libelle').
                        '.<br>'.
                        implode("\n", $erreursParam).
                        '<br>'.
                        _('Veuillez corriger ces informations avant de renvoyer la notification.')
                );
                $add = $dossier_message->add_notification_message($dossier_message_val, true);
                // Si une erreur se produit pendant l'ajout
                if ($add !== true) {
                    $this->addToLog(__METHOD__."(): Le message d'alerte concernant l'echec de l'envoi de la notification n'a pas pu être envoyé.", DEBUG_MODE);
                    return false;
                }
            }
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Récupère l'instance de dossier message.
     *
     * @param string $dossier_message Identifiant du message.
     *
     * @return object
     */
    private function get_inst_dossier_message($dossier_message = null) {
        //
        return $this->get_inst_common("dossier_message", $dossier_message);
    }

    /**
     * Vérifie si le signataire est obligatoire pour finaliser
     * le document apartir du paramétrage de l'événement.
     * Si c'est le cas, vérifie si il y a bien un signataire
     * renseigné.
     * Si c'est le cas renvoie true, sinon renvoie false.
     *
     * @param evenement évenement de l'instruction permettant de
     * récupérer le paramétrage
     * @return boolean
     */
    protected function controle_signataire($evenement) {
        // Vérifie si le signataire est obligatoire et si c'est le cas
        // vérifie si il y a bien un signataire pour le document
        if ($evenement->is_signataire_obligatoire() &&
            ($this->getVal('signataire_arrete') === null ||
            $this->getVal('signataire_arrete') === '')) {
            return false;
        }
        return true;
    }

    /**
     * TREATMENT - unfinalize.
     *
     * Permet de définaliser un enregistrement.
     *
     * @param array $val valeurs soumises par le formulaire
     *
     * @return boolean
     */
    function unfinalize($val = array()) {

        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        // Traitement de la finalisation
        $ret = $this->manage_finalizing("unfinalize", $val);

        // Si le traitement retourne une erreur
        if ($ret !== true) {

            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * VIEW - view_edition
     * 
     * Edite l'édition de l'instruction ou affiche celle contenue dans le stockage.
     *
     * @return null Si l'action est incorrecte
     */
    function view_edition() {

        // Si l'instruction est finalisée
        if($this->getVal("om_final_instruction") == 't'
            && $this->getVal("om_final_instruction") != null) {

            // Ouvre le document
            $lien = '../app/index.php?module=form&snippet=file&obj='.$this->table.'&'.
                    'champ=om_fichier_instruction&id='.$this->getVal($this->clePrimaire);
            //
            header("Location: ".$lien);
        } else {

            // Récupère la collectivite du dossier d'instruction
            $dossier_instruction_om_collectivite = $this->get_dossier_instruction_om_collectivite();

            //
            $collectivite = $this->f->getCollectivite($dossier_instruction_om_collectivite);

            // Paramètre du PDF
            $params = array(
                "watermark" => true, 
                "specific" => array(
                    "mode" => "previsualisation",
                ),
            );
            // Si la rédaction libre est activée sur l'instruction
            if ($this->getVal("flag_edition_integrale") == 't') {
                $params["specific"]["corps"] = array(
                    "mode" => "set",
                    "value" => $this->getVal("corps_om_htmletatex"),
                );
                $params["specific"]["titre"] = array(
                    "mode" => "set",
                    "value" => $this->getVal("titre_om_htmletat"),
                );
            }

            // Génération du PDF
            $result = $this->compute_pdf_output('lettretype', $this->getVal("lettretype"), $collectivite, null, $params);
            // Affichage du PDF
            $this->expose_pdf_output(
                $result['pdf_output'], 
                $result['filename']
            );
        }
    }

    /**
     * Récupère la collectivité du dossier d'instruction.
     *
     * @param string $dossier_instruction_id Identifiant du DI.
     *
     * @return integer
     */
    function get_dossier_instruction_om_collectivite($dossier_instruction_id = null) {

        // Si l'identifiant n'est pas renseigné
        if ($dossier_instruction_id === null) {
            // Récupère la valeur
            if ($this->getVal('dossier') !== null && $this->getVal('dossier') !== '') {
                $dossier_instruction_id = $this->getVal('dossier');
            } elseif ($this->getParameter('idxformulaire') !== null
                && $this->getParameter('idxformulaire') !== '') {
                //
                $dossier_instruction_id = $this->getParameter('idxformulaire');
            } elseif ($this->f->get_submitted_get_value('idxformulaire') !== null
                && $this->f->get_submitted_get_value('idxformulaire') !== '') {
                //
                $dossier_instruction_id = $this->f->get_submitted_get_value('idxformulaire');
            }
        }

        //
        $dossier_instruction = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_instruction",
            "idx" => $dossier_instruction_id,
        ));

        //
        return $dossier_instruction->getVal('om_collectivite');
    }

    /**
     * VIEW - view_bible
     *
     * Affiche la bible manuelle.
     *
     * @return void
     */
    function view_bible() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        /**
         * Affichage de la structure HTML
         */
        //
        if ($this->f->isAjaxRequest()) {
            //
            header("Content-type: text/html; charset=".HTTPCHARSET."");
        } else {
            //
            $this->f->setFlag("htmlonly");
            $this->f->display();
        }
        //
        $this->f->displayStartContent();
        //
        $this->f->setTitle(_("Liste des éléments de la bible en lien avec un evenement"));
        $this->f->displayTitle();

        /**
         *
         */
        //
        ($this->f->get_submitted_get_value("ev") ? $evenement = $this->f->get_submitted_get_value("ev") : $evenement = "");
        $evenement = intval($evenement);
        //
        ($this->f->get_submitted_get_value("idx") ? $idx = $this->f->get_submitted_get_value("idx") : $idx = "");
        // Récupération du code du type de DA 
        $code_da_type = '';
        if (preg_match('/[A-Za-z]{2,3}/', $idx, $matches) !== false) { 
            $code_da_type = $matches[0]; 
        }
        //
        ($this->f->get_submitted_get_value("complement") ? $complement = $this->f->get_submitted_get_value("complement") : $complement = "1");

        // Récupération de la collectivité du dossier
        $dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $idx,
        ));

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *,
                    bible.libelle as bible_lib
                FROM
                    %1$sbible
                    LEFT OUTER JOIN %1$sdossier_autorisation_type 
                        ON bible.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                    LEFT JOIN %1$som_collectivite
                        ON bible.om_collectivite = om_collectivite.om_collectivite
                WHERE
                    (evenement = %2$d
                        OR evenement IS NULL)
                    AND (complement = %3$d
                        OR complement IS NULL)
                    AND (bible.dossier_autorisation_type IS NULL
                        OR dossier_autorisation_type.code = \'%4$s\')
                    AND (om_collectivite.niveau = \'2\'
                        OR bible.om_collectivite = %5$d)
                ORDER BY
                    bible_lib ASC',
                DB_PREFIXE,
                intval($evenement),
                intval($complement),
                $this->f->db->escapeSimple($code_da_type),
                intval($dossier->getVal("om_collectivite"))
            ),
            array(
                'origin' => __METHOD__
            )
        );
        //
        echo "<form method=\"post\" name=\"f3\" action=\"#\">\n";
        //
        if ($qres['row_count'] > 0) {
            //
            echo "\t<table id='tab-bible' width='100%'>\n";
            //
            echo "\t\t<tr class=\"ui-tabs-nav ui-accordion ui-state-default tab-title\">";
            echo "<th>"._("Choisir")."</th>";
            echo "<th>"._("Libelle")."</th>";
            echo "</tr>\n";
            //
            $i = 0;
            //
            foreach ($qres['result'] as $row) {
                //
                echo "\t\t<tr";
                echo " class=\"".($i % 2 == 0 ? "odd" : "even")."\"";
                echo ">";
                //
                echo "<td class=\"center\"><input type=\"checkbox\" name=\"choix[]\" value=\"".$i."\" id=\"checkbox".$i."\" /></td>";
                // XXX utilisation de l'attribut titre pour afficher une infobulle
                echo "<td><span class=\"content\" title=\"".htmlentities($row['contenu'])."\" id=\"content".$i."\">".$row['bible_lib']."</span></td>";
                //
                echo "</tr>\n";
                //
                $i++;
            }
            echo "\t</table>\n";
            //
            echo "<div class=\"formControls\">\n";
            $this->f->layout->display_form_button(array(
                "value" => _("Valider"),
                "onclick" => "bible_return('f2', 'complement".($complement == "1" ? "" : $complement)."_om_html'); return false;",
            ));
            $this->f->displayLinkJsCloseWindow();
            echo "</div>\n";

        } else {
            //
            $message_class = "error";
            $message = _("Aucun element dans la bible pour l'evenement")." : ".$evenement;
            $this->f->displayMessage($message_class, $message);
            //
            echo "<div class=\"formControls\">\n";
            $this->f->displayLinkJsCloseWindow();
            echo "</div>\n";
        }
        //
        echo "</form>\n";

        /**
         * Affichage de la structure HTML
         */
        //
        $this->f->displayEndContent();
    }

    /**
     * VIEW - view_bible_auto
     *
     * Renvoie les valeurs de la bible à placer dans les compléments de l'instruction.
     *
     * @return void
     */
    function view_bible_auto() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        //
        $this->f->disableLog();

        $formatDate="AAAA-MM-JJ";

        // Récupération des paramètres
        $idx = $this->f->get_submitted_get_value('idx');
        $evenement = $this->f->get_submitted_get_value('ev');

        // Initialisation de la variable de retour
        $retour['complement_om_html'] = '';
        $retour['complement2_om_html'] = '';
        $retour['complement3_om_html'] = '';
        $retour['complement4_om_html'] = '';

        // Vérification d'une consultation liée à l'événement
        $instEvenement = $this->f->get_inst__om_dbform(array(
            "obj" => "evenement",
            "idx" => $evenement,
        ));

        // Si consultation liée, récupération du retour d'avis
        if($instEvenement->getVal('consultation') == 'Oui'){

            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        date_retour,
                        avis_consultation.libelle as avis_consultation,
                        COALESCE(service.libelle, tiers_consulte.libelle) as service
                    FROM
                        %1$sconsultation
                        LEFT JOIN %1$stiers_consulte
                            ON consultation.tiers_consulte = tiers_consulte.tiers_consulte
                        LEFT JOIN %1$sservice
                            ON consultation.service = service.service
                        LEFT JOIN %1$savis_consultation
                            ON consultation.avis_consultation = avis_consultation.avis_consultation
                    WHERE
                        dossier = \'%2$s\'
                        AND consultation.visible',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($idx)
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            // Récupération des consultations
            foreach ($qres['result'] as $row) {
                $correct=false;
                // date retour
                if ($row['date_retour']<>""){
                    if ($formatDate=="AAAA-MM-JJ"){
                        $date = explode("-", $row['date_retour']);
                        // controle de date
                        if (count($date) == 3 and
                                checkdate($date[1], $date[2], $date[0])) {
                            $date_retour_f= $date[2]."/".$date[1]."/".$date[0];
                            $correct=true;
                        }else{
                            $msg= $msg."<br>La date ".$row['date_retour']." n'est pas une date.";
                            $correct=false;
                        }
                    }
                }
                // 
                $temp="Vu l'avis ".$row['avis_consultation']." du service ".$row['service'];
                if($correct == true){
                    $temp=$temp." du ".$date_retour_f;
                }
                // Concaténation des retours d'avis de consultation 
                $retour['complement_om_html'] .= $temp . "<br/><br/>";
            } // while
            
        } // consultation
        // Récupération des bibles automatiques pour le champ complement_om_html
        $retour['complement_om_html'] .= $this->getBible($evenement, $idx, '1');
        // Récupération des bibles automatiques pour le champ complement2_om_html
        $retour['complement2_om_html'] .= $this->getBible($evenement, $idx, '2');
        // Récupération des bibles automatiques pour le champ complement3_om_html
        $retour['complement3_om_html'] .= $this->getBible($evenement, $idx, '3');
        // Récupération des bibles automatiques pour le champ complement4_om_html
        $retour['complement4_om_html'] .= $this->getBible($evenement, $idx, '4');



        echo json_encode($retour);
    }

    /**
     * VIEW - view_pdf_temp
     *
     * @return void
     */
    function view_pdf_temp() {
        $this->checkAccessibility();
        // Utilisation de $_POST pour ne pas que les textes soient altérés.
        $this->f->set_submitted_value();
        $merge_fields = array();
        //
        if (array_key_exists('c1', $_POST) === true) {
            $merge_fields['[complement_instruction]'] = $_POST['c1'];
            $merge_fields['[complement1_instruction]'] = $_POST['c1'];
        }
        if (array_key_exists('c2', $_POST) === true) {
            $merge_fields['[complement2_instruction]'] = $_POST['c2'];
        }
        if (array_key_exists('c3', $_POST) === true) {
            $merge_fields['[complement3_instruction]'] = $_POST['c3'];
        }
        if (array_key_exists('c4', $_POST) === true) {
            $merge_fields['[complement4_instruction]'] = $_POST['c4'];
        }
        $params = array(
            "watermark" => true,
            "specific" => array(
                "merge_fields" => $merge_fields,
            ),
        );
        //
        if (array_key_exists('corps', $_POST) === true) {
            $params["specific"]["corps"] = array(
                "mode" => "set",
                "value" => $_POST['corps'],
            );
        }
        if (array_key_exists('titre', $_POST) === true) {
            $params["specific"]["titre"] = array(
                "mode" => "set",
                "value" => $_POST['titre'],
            );
        }
        $dossier_instruction_om_collectivite = $this->get_dossier_instruction_om_collectivite();
        $collectivite = $this->f->getCollectivite($dossier_instruction_om_collectivite);
        $result = $this->compute_pdf_output('lettretype', $this->getVal('lettretype'), $collectivite, null, $params);
        $retour = array(
            'base' => base64_encode($result['pdf_output']),
        );
        echo json_encode($retour);
    }

    /**
     * Dans le contexte de prévisualisation des éditions, génère le rendu du
     * PDF sans prise en compte de la valeur des compléments et le retourne en
     * base 64.
     *
     * @return string Rendu PDF converti en base 64.
     */
    function init_pdf_temp() {
        $params = array(
            "watermark" => true,
        );
        // Si la rédaction libre est activée sur l'instruction
        if ($this->getVal("flag_edition_integrale") == 't') {
            $params["specific"]["corps"] = array(
                "mode" => "set",
                "value" => $this->getVal("corps_om_htmletatex"),
            );
            $params["specific"]["titre"] = array(
                "mode" => "set",
                "value" => $this->getVal("titre_om_htmletat"),
            );
        }
        $dossier_instruction_om_collectivite = $this->get_dossier_instruction_om_collectivite();
        $collectivite = $this->f->getCollectivite($dossier_instruction_om_collectivite);
        $result = $this->compute_pdf_output('lettretype', $this->getVal('lettretype'), $collectivite, null, $params);

        return base64_encode($result['pdf_output']);
    }

    /**
     * Récupération des éléments de bible.
     *
     * @param integer $event  id de l'événement
     * @param string  $idx    id du dossier
     * @param integer $compnb numéro du champ complement
     *
     * @return string   Chaîne de texte à insérer dans le champ complement
     */
    function getBible($event, $idx, $compnb) {
        // Récupération de la collectivité du dossier
        $dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $idx,
        ));
        // Récupération du code du type de DA 
        $code_da_type = '';
        if (preg_match('/[A-Za-z]{2,3}/', $idx, $matches) !== false) { 
            $code_da_type = $matches[0]; 
        }

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$sbible
                    LEFT OUTER JOIN %1$sdossier_autorisation_type 
                        ON bible.dossier_autorisation_type =
                            dossier_autorisation_type.dossier_autorisation_type
                    LEFT JOIN %1$som_collectivite
                        ON bible.om_collectivite = om_collectivite.om_collectivite
                WHERE
                    (evenement = %2$d
                        OR evenement IS NULL)
                    AND (complement = %3$d
                        OR complement IS NULL)
                    AND automatique = \'Oui\'
                    AND (dossier_autorisation_type.code = \'%4$s\'
                        OR bible.dossier_autorisation_type IS NULL)
                    AND (om_collectivite.niveau = \'2\'
                        OR bible.om_collectivite = %5$d)',
                DB_PREFIXE,
                intval($event),
                intval($compnb),
                $this->f->db->escapeSimple($code_da_type),
                intval($dossier->getVal("om_collectivite"))
            ),
            array(
                "origin" => __METHOD__
            )
        );
        $temp = "";
        foreach ($qres['result'] as $row) {
            // Remplacement des retours à la ligne par des br
            $temp .= preg_replace(
                '#(\\\r|\\\r\\\n|\\\n)#', '<br/>', $row['contenu']
            );
            // Ajout d'un saut de ligne entre chaque bible.
            $temp .= '<br/>';
        } // fin while
        return $temp;
    }

    /**
     * VIEW - view_suivi_bordereaux.
     *
     * Formulaire de choix du bordereau de suivi, permettant de générer les 4 bordereaux.
     * Si l'utilisateur est d'une collectivité de niveau 2 il a le choix de la
     * collectivité des dossiers affichés.
     *
     * @return void
     */
    function view_suivi_bordereaux() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        /**
         * Validation du formulaire
         */
        // Si le formulaire a été validé
        if ($this->f->get_submitted_post_value("validation") !== null) {
            // Si un bordereau à été sélectionné
            if ($this->f->get_submitted_post_value("bordereau") !== null && $this->f->get_submitted_post_value("bordereau") == "" ) {
                // Si aucun bordereau n'a été sélectionné
                $message_class = "error";
                $message = _("Veuillez selectionner un bordereau.");
            }
            // Sinon si les dates ne sont pas valide 
            elseif (($this->f->get_submitted_post_value("date_bordereau_debut") !== null
                && $this->f->get_submitted_post_value("date_bordereau_debut") == "")
                || ($this->f->get_submitted_post_value("date_bordereau_fin") !== null 
                && $this->f->get_submitted_post_value("date_bordereau_fin") == "")) {
                // Si aucune date n'a été saisie
                $message_class = "error";
                $message = _("Veuillez saisir une date valide.");
            } 
            // Sinon si les dates ne sont pas valides
            elseif ($this->f->get_submitted_post_value("bordereau") === "bordereau_avis_maire_prefet"
                && $this->f->getParameter("id_evenement_bordereau_avis_maire_prefet") == null) {
                // Si aucune date n'a été saisie
                $message_class = "error";
                $message = _("Erreur de parametrage. Contactez votre administrateur.");
            }
            // Affiche le message de validation
            else {
                // On récupère le libellé du bordereau pour l'afficher à l'utilisateur
                $etat = $this->f->get_inst__om_dbform(array(
                    "obj" => "om_etat",
                    "idx" => $this->f->get_submitted_post_value("bordereau")
                ));
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            om_etat.libelle
                        FROM
                            %som_etat
                        WHERE
                            om_etat.id = \'%s\'',
                        DB_PREFIXE,
                        $this->f->db->escapeSimple($this->f->get_submitted_post_value("bordereau"))
                    ), 
                    array(
                        "origin" => __METHOD__,
                    )
                );
 
                //
                $message_class = "valid";
                $message = _("Cliquez sur le lien ci-dessous pour telecharger votre bordereau");
                $message .= " : <br/><br/>";
                $message .= "<a class='om-prev-icon pdf-16'";
                $message .= " title=\""._("Bordereau")."\"";
                $message .= "href='".OM_ROUTE_FORM."&obj=instruction";
                $message .= "&action=220";
                $message .= "&idx=0";
                $message .= "&type_bordereau=".$this->f->get_submitted_post_value("bordereau");
                $message .= "&date_bordereau_debut=".$this->f->get_submitted_post_value("date_bordereau_debut");
                $message .= "&date_bordereau_fin=".$this->f->get_submitted_post_value("date_bordereau_fin");
                // Si l'utilisateur est MULTI alors on ajoute le paramètre collectivite
                if ($this->f->get_submitted_post_value("om_collectivite") !== null) {
                    $message .= "&collectivite=".$this->f->get_submitted_post_value("om_collectivite");
                }
                $message .= "'"." target='_blank'>";
                $message .= $qres['result']." "._("du")." ".$this->f->get_submitted_post_value("date_bordereau_debut")
                    ." "._("au")." ".$this->f->get_submitted_post_value("date_bordereau_fin");
                $message .= "</a>";
            }
        }

        /**
         * Affichage des messages et du formulaire
         */
        // Affichage du message de validation ou d'erreur
        if (isset($message) && isset($message_class) && $message != "") {
            $this->f->displayMessage($message_class, $message);
        }
        // Ouverture du formulaire
        printf("\t<form");
        printf(" method=\"post\"");
        printf(" id=\"suivi_bordereaux_form\"");
        printf(" action=\"\"");
        printf(">\n");
        // Paramétrage des champs du formulaire
        $champs = array("date_bordereau_debut", "date_bordereau_fin", "bordereau");
        // Si l'utilisateur est d'une collectivité de niveau 2 on affiche un select
        // collectivité dans le formulaire
        if ($_SESSION["niveau"] == 2) {
            array_push($champs, "om_collectivite");
        }
        // Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        // Paramétrage du champ date_bordereau_debut
        $form->setLib("date_bordereau_debut", _("date_bordereau_debut"));
        $form->setType("date_bordereau_debut", "date");
        $form->setTaille("date_bordereau_debut", 12);
        $form->setMax("date_bordereau_debut", 12);
        $form->setRequired("date_bordereau_debut");
        $form->setOnchange("date_bordereau_debut", "fdate(this)");
        $form->setVal("date_bordereau_debut", date("d/m/Y"));
        // Paramétrage du champ date_bordereau_fin
        $form->setLib("date_bordereau_fin", _("date_bordereau_fin"));
        $form->setType("date_bordereau_fin", "date");
        $form->setTaille("date_bordereau_fin", 12);
        $form->setMax("date_bordereau_fin", 12);
        $form->setRequired("date_bordereau_fin");
        $form->setOnchange("date_bordereau_fin", "fdate(this)");
        $form->setVal("date_bordereau_fin", date("d/m/Y"));
        // Paramétrage du champ bordereau
        $form->setLib("bordereau", _("bordereau"));
        $form->setType("bordereau", "select");
        $form->setRequired("bordereau");
        // Valeurs des champs
        if ($this->f->get_submitted_post_value("validation") !== null) {
            $form->setVal("date_bordereau_debut", $this->f->get_submitted_post_value("date_bordereau_debut"));
            $form->setVal("date_bordereau_fin", $this->f->get_submitted_post_value("date_bordereau_fin"));
            $form->setVal("bordereau", $this->f->get_submitted_post_value("bordereau"));
            $form->setVal("om_collectivite", $this->f->get_submitted_post_value("om_collectivite"));
        }
        // Données du select - On récupère ici la liste de tous les états disponibles
        // dans la table om_etat qui ont un id qui commence par la cahine de caractères
        // 'bordereau_'
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    om_etat.id,
                    om_etat.libelle
                FROM
                    %1$som_etat
                WHERE
                    om_etat.id LIKE \'bordereau_%%\'
                ORDER BY
                    om_etat.id',
                DB_PREFIXE
            ),
            array(
                "origin" => __METHOD__
            )
        );
        // Données du select
        $contenu = array(
            0 => array("", ),
            1 => array(_("choisir bordereau")),
        );
        foreach ($qres['result'] as $row) {
            $contenu[0][] = $row['id'];
            $contenu[1][] = $row['libelle'];
        }
        $form->setSelect("bordereau", $contenu);
        //
        if ($_SESSION["niveau"] == 2) {
            $form->setLib("om_collectivite", _("collectivite"));
            $form->setType("om_collectivite", "select");

            // Données du select - On récupère ici la liste de tous toutes les collectivités
            // de niveau 1
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        om_collectivite,
                        libelle
                    FROM
                        %1$som_collectivite
                    WHERE
                        niveau = \'1\'
                    ORDER BY
                        libelle',
                    DB_PREFIXE
                ),
                array(
                    "origin" => __METHOD__
                )
            );
            // La valeur par défaut du select est Toutes
            $list_collectivites = array(
                0 => array("", ),
                1 => array(_("toutes"))
            );

            $id_colls = "";
            // On stocke dans $id_colls l'id de toutes les collectivités de niveau 1 séparées
            // par des virgules, pour un traitement plus facile dans la requête de sous-état
            foreach ($qres['result'] as $row) {
                if ($id_colls != "") {
                    $id_colls .= ",";
                }
                $id_colls .= $row['om_collectivite'];
                $list_collectivites[0][] = $row['om_collectivite'];
                $list_collectivites[1][] = $row['libelle'];
            }
            // On affecte la liste d'identifiants à l'option Toutes
            $list_collectivites[0][0] = $id_colls ;
            $form->setSelect("om_collectivite", $list_collectivites);
        }
        // Affichage du formulaire
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        // Affichage du bouton
        printf("\t<div class=\"formControls\">\n");
        $this->f->layout->display_form_button(array("value" => _("Valider"), "name" => "validation"));
        printf("\t</div>\n");
        // Fermeture du formulaire
        printf("\t</form>\n");
    }


    /** 
     * VIEW - view_generate_suivi_bordereaux.
     * 
     * Génère et affiche les bordereaux de suivi.
     *   
     * @return [void] 
     */ 
    function view_generate_suivi_bordereaux() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Récupération du type de bordereau
        $bordereau = $this->f->get_submitted_get_value('type_bordereau');
        // Génération du PDF
        $result = $this->compute_pdf_output('etat', $bordereau, null, $this->getVal($this->clePrimaire));
        // Affichage du PDF
        $this->expose_pdf_output(
            $result['pdf_output'],
            $result['filename']
        );
    }


    /**
     * VIEW - view_suivi_envoi_lettre_rar.
     *
     * Vue pour imprimer les AR.
     *
     * @return void
     */
    function view_suivi_envoi_lettre_rar() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        //
        if ($this->f->get_submitted_post_value("date") !== null) {
            $date = $this->f->get_submitted_post_value("date");
        } else {
            $date = "";
        }
        //
        if ($this->f->get_submitted_post_value("liste_code_barres_instruction") !== null) {
            $liste_code_barres_instruction = $this->f->get_submitted_post_value("liste_code_barres_instruction");
        } else {
            $liste_code_barres_instruction = "";
        }

        // Compteur du nombre de page générées
        $nbLettres = 0;
        // Liste d'id des instructions
        $id4Gen = array();
        //
        $error = "";

        // Initialisation du tableau qui va contenir les DI pour lister les liens
        $dossierTab = array();
        // On vérifie que l'utilisateur ait les droits pour afficher des consultations
        $isAccredited = $this->f->isAccredited(array("dossier_instruction","dossier_instruction_consulter"), "OR");
        $hasHidden = true;
        // S'il ne peut pas les consulter il aura des dossiers caché
        if ($isAccredited === true) {
            $hasHidden = false;
        }

        /**
         * Validation du formulaire
         */
        // Si le formulaire a été validé
        if ($this->f->get_submitted_post_value('validation') !== null) {
            //
            if (empty($date) || empty($liste_code_barres_instruction)) {
                //
                $message_class = "error";
                $message = _("Tous les champs doivent etre remplis.");
            } else {
                // Création d'un tableau d'instruction
                $liste = explode("\r\n", $this->f->get_submitted_post_value("liste_code_barres_instruction"));
                //
                foreach ($liste as $code_barres) {
                    // On enlève les éventuels espaces saisis
                    $code_barres = trim($code_barres);
                    // Vérification de l'existence de l'instruction
                    if ($code_barres != "") {
                        // Si la valeur transmise est numérique
                        if (is_numeric($code_barres)) {
                            // 
                            $sql = "SELECT count(*)
                                    FROM ".DB_PREFIXE."instruction
                                        INNER JOIN ".DB_PREFIXE."dossier
                                            ON dossier.dossier=instruction.dossier
                                        INNER JOIN ".DB_PREFIXE."dossier_instruction_type
                                            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                                        INNER JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
                                            ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                                        INNER JOIN ".DB_PREFIXE."dossier_autorisation_type
                                            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                                        INNER JOIN ".DB_PREFIXE."groupe
                                            ON dossier_autorisation_type.groupe = groupe.groupe
                                        WHERE code_barres='".$this->f->db->escapesimple($code_barres)."'";
                                        
                            // Ajout d'un filtre sur les groupes auxquels l'utilisateur a accès
                            $group_clause = array();
                            foreach ($_SESSION["groupe"] as $key => $value) {
                                $group_clause[$key] = "(groupe.code = '".$key."'";
                                if($value["confidentiel"] !== true) {
                                    $group_clause[$key] .= " AND dossier_autorisation_type.confidentiel IS NOT TRUE";
                                }
                                $group_clause[$key] .= ")";
                            }
                            $conditions = implode(" OR ", $group_clause);
                            $sql .= " AND (" . $conditions . ")";

                            $qres = $this->f->get_one_result_from_db_query(
                                $sql, 
                                array(
                                    "origin" => __METHOD__,
                                )
                            );

                            if ($qres['result'] == "1") {
                                // Récupération de la date d'envoi de l'instruction bippé
                                $qres = $this->f->get_all_results_from_db_query(
                                    sprintf(
                                        'SELECT
                                            to_char(date_envoi_rar, \'DD/MM/YYYY\') as date_envoi_rar,
                                            instruction
                                        FROM
                                            %1$sinstruction
                                        WHERE
                                            code_barres = \'%2$s\'',
                                        DB_PREFIXE,
                                        $this->f->db->escapeSimple($code_barres)
                                    ),
                                    array(
                                        'origin' => __METHOD__
                                    )
                                );
                                $row = array_shift($qres['result']);
                                // Si pas de date ou correspond à la date du formulaire on 
                                // effectue le traitement
                                if ($row["date_envoi_rar"] == "" || $row["date_envoi_rar"] == $date) {
                                    $instr = $this->f->get_inst__om_dbform(array(
                                        "obj" => "instruction",
                                        "idx" => $row['instruction'],
                                    ));
                                    $valF = array();
                                    foreach($instr->champs as $id => $champ) {
                                        $valF[$champ] = $instr->val[$id];
                                    }

                                    # Si on peut consulter les dossiers et que le dossier n'existe pas déjà dans la liste
                                    if ($isAccredited === true
                                        && array_key_exists($instr->getVal("dossier"), $dossierTab) === false) {
                                        $dossier = $this->f->get_inst__om_dbform(array(
                                            "obj" => "dossier",
                                            "idx" => $instr->getVal("dossier"),
                                        ));
                                        if ($dossier->is_user_from_allowed_collectivite()){
                                            $dossierTab[$instr->getVal("dossier")] = $dossier;
                                        } else {
                                            $hasHidden = true;
                                        }
                                    }

                                    $valF['date_evenement']=
                                        $instr->dateDBToForm($valF['date_evenement']);
                                    $valF['archive_date_complet']=
                                        $instr->dateDBToForm($valF['archive_date_complet']);
                                    $valF['archive_date_rejet']=
                                        $instr->dateDBToForm($valF['archive_date_rejet']);
                                    $valF['archive_date_limite']=
                                        $instr->dateDBToForm($valF['archive_date_limite']);
                                    $valF['archive_date_notification_delai']=
                                        $instr->dateDBToForm($valF['archive_date_notification_delai']);
                                    $valF['archive_date_decision']=
                                        $instr->dateDBToForm($valF['archive_date_decision']);
                                    $valF['archive_date_validite']=
                                        $instr->dateDBToForm($valF['archive_date_validite']);
                                    $valF['archive_date_achevement']=
                                        $instr->dateDBToForm($valF['archive_date_achevement']);
                                    $valF['archive_date_chantier']=
                                        $instr->dateDBToForm($valF['archive_date_chantier']);
                                    $valF['archive_date_conformite']=
                                        $instr->dateDBToForm($valF['archive_date_conformite']);
                                    $valF['archive_date_dernier_depot']=
                                        $instr->dateDBToForm($valF['archive_date_dernier_depot']);
                                    $valF['archive_date_limite_incompletude']=
                                        $instr->dateDBToForm($valF['archive_date_limite_incompletude']);
                                    $valF['date_finalisation_courrier']=
                                        $instr->dateDBToForm($valF['date_finalisation_courrier']);
                                    $valF['date_envoi_signature']=
                                        $instr->dateDBToForm($valF['date_envoi_signature']);
                                    $valF['date_retour_signature']=
                                        $instr->dateDBToForm($valF['date_retour_signature']);
                                    $valF['date_envoi_rar']=
                                        $instr->dateDBToForm($valF['date_envoi_rar']);
                                    $valF['date_retour_rar']=
                                        $instr->dateDBToForm($valF['date_retour_rar']);
                                    $valF['date_envoi_controle_legalite']=
                                        $instr->dateDBToForm($valF['date_envoi_controle_legalite']);
                                    $valF['date_retour_controle_legalite']=
                                        $instr->dateDBToForm($valF['date_retour_controle_legalite']);
                                    $valF['date_envoi_rar'] = $date;

                                    // Vérification de la finalisation du document
                                    // correspondant au code barres
                                    if($instr->getVal("om_final_instruction") === 't') {
                                        $instr->setParameter('maj', 1);
                                        $instr->class_actions[1]["identifier"] = 
                                            "envoi lettre RAR (depuis le menu suivi des pièces)";
                                        if ($instr->modifier($valF) == true) {
                                            $id4Gen[] = $code_barres;
                                            $nbLettres ++;
                                        } else {
                                            //
                                            if ($error != "") {
                                                $error .= "<br/>";
                                            }
                                            $error .= sprintf(_("Une erreur s'est produite lors de la modification de l'instruction %s."),
                                                $code_barres);
                                            $error .= " ";
                                            $error .= _("Veuillez contacter votre administrateur.");
                                        }
                                    } else {
                                        //
                                        if ($error != "") {
                                            $error .= "<br/>";
                                        }
                                        $error .= sprintf(_("Le document correspondant au 
                                            code barres %s n'est pas finalise, 
                                            le bordereau ne sera pas genere."),
                                            $code_barres);
                                    }
                                    
                                } else {
                                    //
                                    if ($error != "") {
                                        $error .= "<br/>";
                                    }
                                    $error .= _("Une lettre correspondante a l'instruction ayant pour code barres")." ".$code_barres." "._("a deja ete envoyee, le bordereau ne sera pas genere.");
                                }
                            } else {
                                //
                                if ($error != "") {
                                    $error .= "<br/>";
                                }
                                $error .= _("Le numero")." ".$code_barres." "._("ne correspond a aucun code barres d'instruction.");
                            }
                        } else {
                            //
                            if ($error != "") {
                                $error .= "<br/>";
                            }
                            $error .= _("Le code barres d'instruction")." ".$code_barres." "._("n'est pas valide.");
                        }
                    }
                }
            }
        }

        /**
         * Affichage des messages et du formulaire
         */
        // Affichage du message de validation ou d'erreur
        if (isset($message) && isset($message_class) && $message != "") {
            $this->f->displayMessage($message_class, $message);
        }
        // Affichage du message d'erreur
        if(!empty($error)) {
            $this->f->displayMessage("error", $error);
        }
        // Affichage du message de validation de la saisie
        if ($nbLettres > 0) {
            //
            echo "\n<div class=\"message ui-widget ui-corner-all ui-state-highlight ui-state-valid\" >";
            echo "\n<p>";
            echo "\n<span class=\"ui-icon ui-icon-info\"></span>";
            echo "\n<span class=\"text\">";
            echo _("Cliquez sur le lien ci-dessous pour telecharger votre document");
            echo " : \n<br/><br/>";
            echo "\n<a class='om-prev-icon pdf-16'";
            echo "\n title=\""._("imprimer les AR")."\"";
            echo "\n href=\"".OM_ROUTE_FORM."&obj=instruction&action=180&idx=0&liste=".implode(",",$id4Gen)."\"";
            echo "\n target='_blank'>";
            echo _("Telecharger le document pour")." ".$nbLettres." "._("AR");
            echo "\n</a>";
            echo "\n</span>";
            echo "\n</p>";
            echo "\n<br/>\n";
            if ($isAccredited === true) {
                echo '<fieldset id="fieldset-form-rar-lien_di" class="cadre ui-corner-all startClosed" style="background-color: inherite;">';
                echo "\n<legend class=\"ui-corner-all ui-widget-content ui-state-active\" style=\"background-color: transparent; color: inherit;\">\n";
                echo _('Dossiers concernés par ce traitement');
                echo "\n</legend>";
                echo "\n<div class=\"fieldsetContent\" style=\"display: none;background-color: inherite\">";
                
                if ($hasHidden === true) {
                    echo "\n<br/>";
                    echo "\n<p>";
                    echo "\n<span class='text'>";
                    echo _("Certains dossiers ont été omis de la liste ci-dessous car vous ne possédez pas les permissions nécessaires pour y accéder.");
                    echo "</span>";
                    echo "\n</p>";
                    echo "\n<br/>";
                }
                foreach ($dossierTab as $dossier) {
                  
                    $inst_da = $this->get_inst_common("dossier_autorisation", $dossier->getVal('dossier_autorisation'));
                    $inst_datd = $this->get_inst_common("dossier_autorisation_type_detaille", $inst_da->getVal('dossier_autorisation_type_detaille'));
                    $code_datd = $inst_datd->getVal('code');

                    $obj = "dossier_instruction";
                    if ($code_datd === 'REC' OR $code_datd === 'REG') {
                        $obj = "dossier_contentieux_tous_recours";
                    }
                    if ($code_datd === 'IN') {
                        $obj = "dossier_contentieux_toutes_infractions";
                    }

                    echo "\n<div class=\"bloc group\">";
                    echo "\n<div class=\"field field-type-text\">";

                    echo "\n<p>";
                    echo "\n<span class='text'>";
                    echo "\n<a class=\"om-icon om-icon-16 consult-16\" title=\"" . _('Consulter') . "\"";
                    echo "\n href=\"".OM_ROUTE_FORM."&obj=dossier_instruction&action=3&idx=";
                    echo $dossier->getVal("dossier");
                    echo "\">";
                    echo "\n</a>";

                    echo "\n<a title=\""._("Consulter")."\" style=\"vertical-align:middle;\"";
                    echo " href=\"".OM_ROUTE_FORM."&obj=";
                    echo $obj;
                    echo "&action=3&idx=";
                    echo $dossier->getVal("dossier");
                    echo "\">";
                    echo $dossier->getVal("dossier_libelle");
                    echo "\n</a>";
                    echo "\n</span>";
                    echo "\n</p>";

                    echo "\n</div>";
                    echo "\n</div>";
                }
                echo "\n</div>";
                echo "\n</fieldset>";
            }
            echo "\n</div>";
            echo "\n</div>";
        }
        // Ouverture du formulaire
        echo "\t<form";
        echo " method=\"post\"";
        echo " id=\"suivi_envoi_lettre_rar_form\"";
        echo " action=\"\"";
        echo ">\n";
        // Paramétrage des champs du formulaire
        $champs = array("date", "liste_code_barres_instruction");
        // Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        // Paramétrage du champ date du formulaire
        $form->setLib("date", _("Date")."* :");
        $form->setType("date", "date");
        $form->setOnchange("date", "fdate(this)");
        $form->setVal("date", ($date == "" ? date("d/m/Y") : $date));
        $form->setTaille("date", 10);
        $form->setMax("date", 10);
        // Paramétrage du champ liste_code_barres_instruction du formulaire
        $form->setLib("liste_code_barres_instruction", _("Liste des codes barres d'instructions scannes")."* :");
        $form->setType("liste_code_barres_instruction", "textarea");
        $form->setVal("liste_code_barres_instruction", $liste_code_barres_instruction);
        $form->setTaille("liste_code_barres_instruction", 20);
        $form->setMax("liste_code_barres_instruction", 20);
        // Affichage du formulaire
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        // Affichage du bouton
        echo "\t<div class=\"formControls\">\n";
        $this->f->layout->display_form_button(array("value" => _("Valider"), "name" => "validation"));
        echo "\t</div>\n";
        // Fermeture du formulaire
        echo "\t</form>\n";
    }

    /**
     * VIEW - view_suivi_mise_a_jour_des_dates.
     *
     * Vu pour mettre à jour les dates de suivi de l'instruction.
     *
     * @return void
     */
    function view_suivi_mise_a_jour_des_dates() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Récupération des valeur passées en POST ou GET
        if($this->f->get_submitted_post_value("type_mise_a_jour") !== null) {
            $type_mise_a_jour = $this->f->get_submitted_post_value("type_mise_a_jour");
        } elseif($this->f->get_submitted_get_value('type_mise_a_jour') !== null) {
            $type_mise_a_jour = $this->f->get_submitted_get_value('type_mise_a_jour');
        } else {
            $type_mise_a_jour = "";
        }
        if($this->f->get_submitted_post_value('date') !== null) {
            $date = $this->f->get_submitted_post_value('date');
        } elseif($this->f->get_submitted_get_value('date') !== null) {
            $date = $this->f->get_submitted_get_value('date');
        } else {
            $date = "";
        }
        if($this->f->get_submitted_post_value('code_barres') !== null) {
            $code_barres = $this->f->get_submitted_post_value('code_barres');
        } elseif($this->f->get_submitted_get_value('code_barres') !== null) {
            $code_barres = $this->f->get_submitted_get_value('code_barres');
        } else {
            $code_barres = "";
        }
        // Booléen permettant de définir si un enregistrement à eu lieu
        $correct = false;
        // Booléen permettant de définir si les dates peuvent êtres enregistrées
        $date_error = false;
        // Champs date à mettre à jour
        $liste_champs=array();

        // Si le formulaire a été validé
        if ($this->f->get_submitted_post_value('validation') !== null) {
            if(!empty($type_mise_a_jour) and !empty($date) and !empty($code_barres)) {

                // Ajout d'un filtre sur les groupes auxquels l'utilisateur a accès
                $group_clause = array();
                foreach ($_SESSION["groupe"] as $key => $value) {
                    $group_clause[$key] = "(groupe.code = '".$key."'";
                    if($value["confidentiel"] !== true) {
                        $group_clause[$key] .= " AND dossier_autorisation_type.confidentiel IS NOT TRUE";
                    }
                    $group_clause[$key] .= ")";
                }
                $conditions = implode(" OR ", $group_clause);
                $groupFilter = " AND (" . $conditions . ")";

                $qres = $this->f->get_all_results_from_db_query(
                    sprintf(
                        'SELECT
                            instruction
                        FROM
                            %1$sinstruction
                            INNER JOIN %1$sdossier
                                ON dossier.dossier = instruction.dossier
                            INNER JOIN %1$sdossier_instruction_type
                                ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                            INNER JOIN %1$sdossier_autorisation_type_detaille
                                ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                            INNER JOIN %1$sdossier_autorisation_type
                                ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                            INNER JOIN %1$sgroupe
                                ON dossier_autorisation_type.groupe = groupe.groupe
                            WHERE
                                code_barres = \'%2$s\'
                                %3$s',
                        DB_PREFIXE,
                        $this->f->db->escapeSimple($code_barres),
                        $groupFilter
                    ),
                    array(
                        'origin' => __METHOD__
                    )
                );
                if($qres['row_count'] === 1) {
                    $liste_champs = explode(";", $type_mise_a_jour);
                    $row = array_shift($qres['result']);
                    $instr = $this->f->get_inst__om_dbform(array(
                        "obj" => "instruction",
                        "idx" => $row['instruction'],
                    ));
                    // Mise à jour des dates après l'écran de verification
                    if($this->f->get_submitted_post_value('is_valid') !== null and $this->f->get_submitted_post_value('is_valid') == "true") {
                        $valF = array();
                        foreach($instr->champs as $id => $champ) {
                            $valF[$champ] = $instr->val[$id];
                        }
                        $valF['date_evenement'] = $instr->dateDBToForm($valF['date_evenement']);
                        $valF['archive_date_complet'] = $instr->dateDBToForm($valF['archive_date_complet']);
                        $valF['archive_date_rejet'] = $instr->dateDBToForm($valF['archive_date_rejet']);
                        $valF['archive_date_limite'] = $instr->dateDBToForm($valF['archive_date_limite']);
                        $valF['archive_date_notification_delai'] = $instr->dateDBToForm($valF['archive_date_notification_delai']);
                        $valF['archive_date_decision'] = $instr->dateDBToForm($valF['archive_date_decision']);
                        $valF['archive_date_validite'] = $instr->dateDBToForm($valF['archive_date_validite']);
                        $valF['archive_date_achevement'] = $instr->dateDBToForm($valF['archive_date_achevement']);
                        $valF['archive_date_chantier'] = $instr->dateDBToForm($valF['archive_date_chantier']);
                        $valF['archive_date_conformite'] = $instr->dateDBToForm($valF['archive_date_conformite']);
                        $valF['archive_date_dernier_depot'] = $instr->dateDBToForm($valF['archive_date_dernier_depot']);
                        $valF['archive_date_limite_incompletude'] = $instr->dateDBToForm($valF['archive_date_limite_incompletude']);
                        $valF['date_finalisation_courrier'] = $instr->dateDBToForm($valF['date_finalisation_courrier']);
                        $valF['date_envoi_signature'] = $instr->dateDBToForm($valF['date_envoi_signature']);
                        $valF['date_retour_signature'] = $instr->dateDBToForm($valF['date_retour_signature']);
                        $valF['date_envoi_rar'] = $instr->dateDBToForm($valF['date_envoi_rar']);
                        $valF['date_retour_rar'] = $instr->dateDBToForm($valF['date_retour_rar']);
                        $valF['date_envoi_controle_legalite'] = $instr->dateDBToForm($valF['date_envoi_controle_legalite']);
                        $valF['date_retour_controle_legalite'] = $instr->dateDBToForm($valF['date_retour_controle_legalite']);
                        $valF['archive_date_cloture_instruction'] = $instr->dateDBToForm($valF['archive_date_cloture_instruction']);
                        $valF['archive_date_premiere_visite'] = $instr->dateDBToForm($valF['archive_date_premiere_visite']);
                        $valF['archive_date_derniere_visite'] = $instr->dateDBToForm($valF['archive_date_derniere_visite']);
                        $valF['archive_date_contradictoire'] = $instr->dateDBToForm($valF['archive_date_contradictoire']);
                        $valF['archive_date_retour_contradictoire'] = $instr->dateDBToForm($valF['archive_date_retour_contradictoire']);
                        $valF['archive_date_ait'] = $instr->dateDBToForm($valF['archive_date_ait']);
                        $valF['archive_date_transmission_parquet'] = $instr->dateDBToForm($valF['archive_date_transmission_parquet']);

                        foreach(explode(";", $type_mise_a_jour) as $maj_date) {
                            $valF[$maj_date]=$date;
                        }

                        // Vérification de la finalisation du document
                        // correspondant au code barres
                        if($valF["om_final_instruction"] === 't' or
                            $valF["lettretype"] == '') {
                            $code_barres = "";
                            
                            //Désactivation de l'autocommit
                            $this->f->db->autoCommit(false);
                            
                            //On modifie les valeurs de l'instruction
                            $instr->setParameter('maj', 170);
                            $instr->class_actions[170]["identifier"] = 
                            "mise à jour des dates (depuis le menu suivi des pièces)";
                            $retour = $instr->modifier($valF);
                            
                            //Si une erreur s'est produite, on défait les modifications 
                            //qui ont été faites
                            if (!$retour){
                                $instr->undoValidation();
                            }
                            //Sinon, on valide en base de données les modifications
                            else {
                                $this->f->db->commit();
                            }
                            
                            // Variable correct retourné depuis la classe instruction
                            $correct = $instr->correct;
                            
                            // Si la modification sur l'instruction a échoué
                            if ($correct === false) {
                                
                                // Message d'erreur de la classe instruction
                                $error = $instr->msg;
                            }
                            
                        } else {
                            // Indique que le traitement est en erreur
                            $correct = false;
                            // Message d'erreur
                            $error = sprintf(_("Le document n'est pas finalise."),
                            "<span class='bold'>".$code_barres."</span>");
                        }
                    } else {
                        // Récupération des infos du dossier
                        $qres = $this->f->get_all_results_from_db_query(
                            sprintf(
                                'SELECT
                                    dossier.dossier_libelle,
                                    evenement.libelle as evenement,
                                    autorite_competente.code as autorite_competente_code,
                                    autorite_competente.libelle as autorite_competente,
                                    evenement.type as evenement_type,
                                    to_char(date_envoi_signature,\'DD/MM/YYYY\') as date_envoi_signature,
                                    to_char(date_retour_signature,\'DD/MM/YYYY\') as date_retour_signature,
                                    to_char(date_envoi_controle_legalite,\'DD/MM/YYYY\') as date_envoi_controle_legalite,
                                    to_char(date_retour_controle_legalite,\'DD/MM/YYYY\') as date_retour_controle_legalite,
                                    to_char(date_envoi_rar,\'DD/MM/YYYY\') as date_envoi_rar,
                                    to_char(date_retour_rar,\'DD/MM/YYYY\') as date_retour_rar
                                FROM
                                    %1$sinstruction
                                    INNER JOIN %1$sdossier
                                        ON dossier.dossier=instruction.dossier
                                    LEFT JOIN %1$sautorite_competente
                                        ON dossier.autorite_competente=autorite_competente.autorite_competente
                                    INNER JOIN %1$sevenement
                                        ON instruction.evenement=evenement.evenement
                                WHERE
                                    code_barres = \'%2$s\'',
                                DB_PREFIXE,
                                $this->f->db->escapeSimple($code_barres)
                            ),
                            array(
                                "origin" => __METHOD__
                            )
                        );
                        $infos = array_shift($qres['result']);

                        // Vérification de la non modification des dates de suivi
                        foreach(explode(";", $type_mise_a_jour) as $champ) {
                            if ($champ === 'date_envoi_controle_legalite') {
                                if ($instr->is_sent_to_cl() === true) {
                                    $error = __("Les dates de suivis ne peuvent etre modifiees");
                                    $date_error = true;
                                    break;
                                }
                            }
                            if($infos[$champ] != "" AND $infos[$champ] != $date) {
                                $error = _("Les dates de suivis ne peuvent etre modifiees");
                                $date_error = true;
                                break;
                            }
                        }
                    }
                } else {
                    $error = _("Le numero saisi ne correspond a aucun code barres d'instruction.");
                }

            } else {
                $error = _("Tous les champs doivent etre remplis.");
            }
        }

        /**
         * Affichage des messages et du formulaire
         */
        // Affichage du message de validation ou d'erreur
        if (isset($message) && isset($message_class) && $message != "") {
            $this->f->displayMessage($message_class, $message);
        }
        // Affichage du message d'erreur
        if(!empty($error)) {
            $this->f->displayMessage("error", $error);
        }

        // Affichage du message de validation de la saisie
        if($correct === true) {
            $this->f->displayMessage("ok", _("Saisie enregistree"));
        }
        // Ouverture du formulaire
        echo "\t<form";
        echo " method=\"post\"";
        echo " id=\"suivi_mise_a_jour_des_dates_form\"";
        echo " action=\"\"";
        echo ">\n";
        // Paramétrage des champs du formulaire
        if(isset($infos)) {
            $champs = array("type_mise_a_jour", "date", "code_barres", "dossier_libelle", "evenement"
                            , "autorite_competente", "date_envoi_signature",
                            "date_retour_signature", "date_envoi_controle_legalite",
                            "date_retour_controle_legalite", "date_envoi_rar",
                            "date_retour_rar", "is_valid");
        } else {
            $champs = array("type_mise_a_jour", "date", "code_barres");
        }
        // Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        // Paramétrage des champs du formulaire
        // Parametrage du champ type_mise_a_jour
        $form->setLib("type_mise_a_jour", _("Date a mettre a jour")."* :");
        if(isset($infos)) {
            $form->setType("type_mise_a_jour", "selecthiddenstatic");

        } else {
            $form->setType("type_mise_a_jour", "select");

        }
        $form->setVal("type_mise_a_jour", $type_mise_a_jour);
        $contenu = array();

        $contenu[0][0] = "date_envoi_signature";
        $contenu[1][0] = _("date d'envoi pour signature Mairie/Prefet");

        $contenu[0][1] = "date_retour_signature";
        $contenu[1][1] = _("date de retour de signature Mairie/Prefet");

        $contenu[0][2] = "date_retour_signature;date_envoi_controle_legalite";
        $contenu[1][2] = _("date de retour de signature + Envoi controle legalite");

        $contenu[0][3] = "date_envoi_controle_legalite";
        $contenu[1][3] = _("date d'envoi au controle de legalite");

        $contenu[0][4] = "date_retour_controle_legalite";
        $contenu[1][4] = _("date de retour de controle de legalite");

        $contenu[0][5] = "date_retour_rar";
        $contenu[1][5] = __("date de notification du correspondant");

        $form->setSelect("type_mise_a_jour", $contenu);

        // Parametrage du champ date
        $form->setLib("date", _("Date")."* :");
        if(isset($infos)) {
            $form->setType("date", "hiddenstaticdate");

        } else {
            $form->setType("date", "date");
        }
        $form->setVal("date", $date);
        $form->setTaille("date", 10);
        $form->setMax("date", 10);

        // Parametrage du champ code_barres
        $form->setLib("code_barres", _("Code barres d'instruction")."* :");
        if(isset($infos)) {
            $form->setType("code_barres", "hiddenstatic");
        } else {
            $form->setType("code_barres", "text");
        }
        $form->setVal("code_barres", $code_barres);
        $form->setTaille("code_barres", 20);
        $form->setMax("code_barres", 20);

        // Ajout des infos du dossier correspondantes à l'instruction séléctionnée
        if(isset($infos)) {

            // Tous les champs sont défini par defaut à static
            foreach ($infos as $key => $value) {
                $form->setType($key, "static");
                if(in_array($key, $liste_champs)) {
                    $form->setVal($key, $date);
                } else {
                    $form->setVal($key, $value);
                }
            }

            // Les champs dont on viens de définir la valeur sont en gras
            foreach ($liste_champs as $value) {
                $form->setBloc($value,'DF',"",'bold');
            }

            // Parametrage du champ dossier
            $form->setLib("dossier_libelle", _("dossier_libelle")." :");
            $form->setType("dossier_libelle", "static");
            $form->setVal("dossier_libelle", $infos['dossier_libelle']);

            // Parametrage du champ evenement
            $form->setLib("evenement", _("evenement")." :");
            $form->setType("evenement", "static");
            $form->setVal("evenement", $infos['evenement']);

            // Parametrage du champ autorite_competente
            $form->setLib("autorite_competente", _("Autorite competente")." :");
            $form->setType("autorite_competente", "static");
            $form->setVal("autorite_competente", $infos['autorite_competente']);

            // Parametrage des libellés d'envoi avec AR
            $form->setLib("date_envoi_rar", __("date_envoi_ar")." :");
            $form->setLib("date_retour_rar", __("date_notification")." :");

            $form->setLib("date_envoi_signature", _("date_envoi_signature")." :");
            $form->setLib("date_retour_signature", _("date_retour_signature")." :");
            $form->setLib("date_envoi_controle_legalite", _("date_envoi_controle_legalite")." :");
            $form->setLib("date_retour_controle_legalite", _("date_retour_controle_legalite")." :");
            // Configuration des libellé en fonction de l'autorité compétente
            if($infos['autorite_competente_code'] == 'ETAT') {
                $form->setType("date_envoi_controle_legalite", "hiddendate");
                $form->setType("date_retour_controle_legalite", "hiddendate");
            }

            // Ajout d'un champ hidden permettant de savoir que le formulaire précédant est celui de vérification
            $form->setLib("is_valid", _("Valide")." :");
            $form->setType("is_valid", "hidden");
            $form->setVal("is_valid", 'true');

            $form->setFieldset('dossier_libelle','D',_('Synthese'));
            $form->setFieldset('is_valid','F');
            
        }


        // Création du fieldset regroupant les champs permettant la mise à jour des date
        $form->setFieldset('type_mise_a_jour','D',_('Mise a jour'));
        $form->setFieldset('code_barres','F');
        // Affichage du formulaire
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        // Affichage du bouton
        echo "\t<div class=\"formControls\">\n";
        //
        if(!$date_error) {
            $this->f->layout->display_form_button(array("value" => _("Valider"), "name" => "validation"));
        }
        // Si pas sur l'écran de validation
        if(isset($infos)) {
            echo "<a class=\"retour\" href=\"".OM_ROUTE_FORM."&obj=instruction_suivi_mise_a_jour_des_dates&action=170&idx=0";
                echo "&amp;type_mise_a_jour=".$type_mise_a_jour."&amp;date=".$date."&amp;code_barres=".$code_barres;
            echo "\">Retour</a>";
        }
        echo "\t</div>\n";
        // Fermeture du formulaire
        echo "\t</form>\n";
    }

    /**
     * [view_pdf_lettre_rar description]
     *
     * @return [type] [description]
     */
    function view_pdf_lettre_rar() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        //
        $this->f->disableLog();

        if($this->f->get_submitted_get_value('liste') != null) {
            $listeCodeBarres = explode(',',$this->f->get_submitted_get_value('liste'));

            // Classe permettant la mise en page de l'édition pdf
            require_once "../obj/pdf_lettre_rar.class.php";
            $pdf_lettre_rar = new pdf_lettre_rar('P', 'mm', 'A4');
            // Initialisation de la mise en page
            $pdf_lettre_rar->init($this->f);

            foreach ($listeCodeBarres as $code_barres) {

                // On récupère le dossier
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            dossier
                        FROM 
                            %1$sinstruction
                        WHERE 
                            code_barres = \'%2$s\'',
                        DB_PREFIXE,
                        $this->f->db->escapeSimple($code_barres)
                    ), 
                    array(
                        "origin" => __METHOD__,
                    )
                );
                
                $inst_dossier = $this->f->get_inst__om_dbform(array(
                    "obj" => "dossier",
                    "idx" => $qres['result'],
                ));

                // En fonction du type de dossier, on récupère un demandeur différent dans les requêtes
                $groupe = $inst_dossier->get_type_affichage_formulaire();
                switch ($groupe) {
                    case 'CTX IN':
                        $sql_demandeur = "(lien_dossier_demandeur.petitionnaire_principal IS TRUE AND demandeur.type_demandeur='plaignant')";
                        break;
                    case 'CTX RE':
                        $sql_demandeur = "(lien_dossier_demandeur.petitionnaire_principal IS TRUE AND demandeur.type_demandeur='requerant')";
                        break;
                    case 'ADS':
                    case 'DPC':
                    case 'CONSULTATION ENTRANTE':
                    default:
                        $sql_demandeur = "((lien_dossier_demandeur.petitionnaire_principal IS TRUE AND demandeur.type_demandeur='petitionnaire') OR demandeur.type_demandeur='delegataire')";
                        break;
                }

                // Test si l'evenement est de type arrete et si un délégataire a été nommé
                $qres = $this->f->get_all_results_from_db_query(
                    sprintf(
                        'SELECT 
                            dossier.dossier_libelle,
                            evenement.type,
                            count(lien_dossier_demandeur) as nbdemandeur,
                            CASE
                                WHEN division.libelle IS NOT NULL AND phase.code IS NOT NULL
                                    THEN CONCAT(phase.code, \' - \', division.libelle)
                                ELSE
                                    phase.code
                            END AS code_phase
                        FROM
                            %1$sinstruction
                            LEFT JOIN %1$sdossier
                                ON instruction.dossier = dossier.dossier
                            LEFT JOIN %1$sdivision
                                ON dossier.division = division.division
                            INNER JOIN %1$sevenement
                                ON instruction.evenement=evenement.evenement
                            LEFT JOIN %1$sphase
                                ON evenement.phase = phase.phase
                            inner JOIN %1$slien_dossier_demandeur
                                ON instruction.dossier=lien_dossier_demandeur.dossier
                            inner join %1$sdemandeur
                                ON demandeur.demandeur=lien_dossier_demandeur.demandeur
                        WHERE
                            code_barres = \'%2$s\'
                            AND %3$s
                        GROUP BY
                            dossier.dossier_libelle,
                            evenement.type,
                            phase.code,
                            division.libelle',
                        DB_PREFIXE,
                        $this->f->db->escapeSimple($code_barres),
                        $sql_demandeur
                    ),
                    array(
                        "origin" => __METHOD__
                    )
                );
                $testDemandeur = array_shift($qres['result']);
                

                // Recuperation de l'adresse de destination
                // Envoi pour delegataire ou petitionnaire principal selon le type d'evenement
                $sqlAdresse = " AND demandeur.type_demandeur='petitionnaire' AND lien_dossier_demandeur.petitionnaire_principal IS TRUE";
                if($testDemandeur['type'] != 'arrete' AND $testDemandeur['nbdemandeur'] > 1) {
                    $sqlAdresse = " AND demandeur.type_demandeur='delegataire'";
                }

                $qres = $this->f->get_all_results_from_db_query(
                    sprintf(
                        'SELECT 
                            CASE WHEN demandeur.qualite = \'particulier\'
                                THEN TRIM(CONCAT_WS(\' \', pc.libelle, demandeur.particulier_nom, demandeur.particulier_prenom))
                                ELSE TRIM(demandeur.personne_morale_denomination)
                            END  as ligne1,
                            CASE WHEN demandeur.qualite = \'personne_morale\'
                                THEN TRIM(demandeur.personne_morale_raison_sociale)
                                ELSE \'\'
                            END as ligne1_1,
                            CASE WHEN demandeur.qualite = \'personne_morale\' AND (demandeur.personne_morale_nom IS NOT NULL OR demandeur.personne_morale_prenom IS NOT NULL)
                                THEN TRIM(CONCAT_WS(\' \', \'rep. par\', demandeur.personne_morale_nom, demandeur.personne_morale_prenom))
                                ELSE \'\'
                            END as ligne1_2,
                            trim(concat(demandeur.numero,\' \',demandeur.voie)) as ligne2,
                            CASE demandeur.complement
                            WHEN null THEN \'\'
                            ELSE trim(demandeur.complement)
                            END as ligne3,
                            CASE demandeur.lieu_dit
                            WHEN null THEN \'\'
                            ELSE trim(demandeur.lieu_dit)
                            END as ligne4,
                            CONCAT_WS(\' \', demandeur.code_postal, demandeur.localite, 
                                (CASE WHEN demandeur.bp IS NOT NULL 
                                    THEN CONCAT_WS(\' \', \'BP\', demandeur.bp)
                                    ELSE \'\'
                                END), 
                                (CASE WHEN demandeur.cedex IS NOT NULL 
                                    THEN CONCAT_WS(\' \', \'CEDEX\', demandeur.cedex)
                                    ELSE \'\'
                                END))
                            as ligne5,
                            code_barres as code_barres
                        FROM
                            %1$sinstruction
                            INNER JOIN %1$sdossier
                                ON dossier.dossier = instruction.dossier
                            INNER JOIN %1$slien_dossier_demandeur
                                ON dossier.dossier = lien_dossier_demandeur.dossier
                            INNER JOIN %1$sdemandeur
                                ON lien_dossier_demandeur.demandeur = demandeur.demandeur
                            LEFT OUTER JOIN %1$scivilite AS pc
                                ON demandeur.particulier_civilite = pc.civilite
                                    OR demandeur.personne_morale_civilite = pc.civilite
                        WHERE
                            instruction.code_barres = \'%2$s\'
                            %3$s',
                        DB_PREFIXE,
                        $this->f->db->escapeSimple($code_barres),
                        $sqlAdresse
                    ),
                    array(
                        "origin" => __METHOD__
                    )
                );
                $adresse_dest = array_shift($qres['result']);

                // Création adresse destinataire sans ligne vide
                $adresse_destinataire = array();
                if (!empty($adresse_dest['ligne1'])) {
                    $adresse_destinataire[] = $adresse_dest['ligne1'];
                }
                if (!empty($adresse_dest['ligne1_1'])) {
                    $adresse_destinataire[] = $adresse_dest['ligne1_1'];
                }
                if (!empty($adresse_dest['ligne1_2'])) {
                    $adresse_destinataire[] = $adresse_dest['ligne1_2'];
                }
                $adresse_destinataire[] = $adresse_dest['ligne2'];
                if (!empty($adresse_dest['ligne3'])) {
                    $adresse_destinataire[] = $adresse_dest['ligne3'];
                }
                if (!empty($adresse_dest['ligne4'])) {
                    $adresse_destinataire[] = $adresse_dest['ligne4'];
                }        
                $adresse_destinataire[] = $adresse_dest['ligne5'];

                // Création du champ specifique
                $specifique_content = array();
                $specifique_content[] = $adresse_dest['ligne1'];
                $specifique_content[] = $adresse_dest['ligne1_1'];
                $specifique_content[] = $adresse_dest['ligne1_2'];
                $specifique_content[] = $testDemandeur['dossier_libelle'];
                $specifique_content[] = "|||||".$adresse_dest['code_barres']."|||||";
                unset($adresse_dest['code_barres']);
                // Ajout d'une page aux pdf
                $pdf_lettre_rar->addLetter($adresse_destinataire, $specifique_content, $testDemandeur['code_phase']);

            }
            $pdf_output = $pdf_lettre_rar->output("lettre_rar".date("dmYHis").".pdf","S");
            $om_edition = $this->f->get_inst__om_edition();
            $om_edition->expose_pdf_output($pdf_output, "lettre_rar".date("dmYHis").".pdf");
        }
    }

    /**
     * VIEW - view_bordereau_envoi_maire.
     *
     * Formulaire demandant :
     * - le code-barres de l'événement d'instruction
     * - la date d'envoi du courrier pour signature par le maire
     * 
     * Lors de la validation :
     *   => met à jour cette date dans l'événement d'instruction
     *   => crée un lien permettant de générer en PDF le bordereau
     *
     * @return void
     */
    function view_bordereau_envoi_maire() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Récupération des valeur passées en POST ou GET
        $code_barres = "";
        if($this->f->get_submitted_post_value('code_barres') !== null) {
            $code_barres = $this->f->get_submitted_post_value('code_barres');
        } elseif($this->f->get_submitted_get_value('code_barres')!==null) {
            $code_barres = $this->f->get_submitted_get_value('code_barres');
        }
        $date = "";
        if($this->f->get_submitted_post_value('date') !== null) {
            $date = $this->f->get_submitted_post_value('date');
        } elseif($this->f->get_submitted_get_value('date') !== null) {
            $date = $this->f->get_submitted_get_value('date');
        }
        $validation = 0;
        if($this->f->get_submitted_post_value('validation') !== null) {
            $validation = $this->f->get_submitted_post_value('validation');
        } elseif($this->f->get_submitted_get_value('validation') !== null) {
            $validation = $this->f->get_submitted_get_value('validation');
        }

        // Si le formulaire a été validé
        if ($this->f->get_submitted_post_value('validation') !== null) {
            // Tous les champs doivent obligatoirement être remplis
            if (!empty($date) && !empty($code_barres)) {
                $date_en = $this->dateDB($date);
                // Si date valide
                if ($date_en != "") {
                    $id_instruction = $this->get_instruction_by_barcode($code_barres);
                    // Si un événement d'instruction a été trouvé pour ce code-barres
                    if ($id_instruction !== null) {
                        $ret = $this->update_date_envoi_signature($id_instruction, $date_en);
                        // Si mise à jour réussie de la date d'envoi du courrier
                        // pour signature par l'autorité compétente 
                        if($ret === true) {
                            // Message de validation avec lien PDF
                            $message_class = "valid";
                            $message = '&bullet; '._("Veuillez cliquer sur le lien ci-dessous pour telecharger votre bordereau");
                            $message .= " : <br/><br/>";
                            $message .= "<a class='om-prev-icon pdf-16'";
                            $message .= " id=\"generer_bordereau_envoi_maire\"";
                            $message .= " title=\""._("Bordereau")."\"";
                            $message .= " href='".OM_ROUTE_FORM."&obj=instruction";
                            $message .= "&action=200";
                            $message .= "&idx=".$id_instruction."'";
                            $message .= " target='_blank'>";
                            $message .= _("Bordereau d'envoi au maire");
                            $message .= "</a><br/><br/>";
                            $message .= '&bullet; '._("Rappel des informations saisies")." :<br/><br/>";
                            $message .= _("Code du courrier")." : ".$code_barres."<br/>";
                            $message .= _("Date d'envoi du courrier pour signature par le maire")." : ".$date;
                            
                        } else {
                            // Message d'erreur
                            $message_class = "error";
                            $message = sprintf(_("Erreur lors de la mise a jour de l'evenement d'instruction correspondant au code barres %s."),
                                $code_barres);
                        }
                    }
                    else {
                        $message_class = "error";
                        $message = _("Le numero saisi ne correspond a aucun code-barres d'evenement d'instruction.");
                    }
                }
                else {
                    $message_class = "error";
                    $message = _("La date est invalide.");
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

        // Ouverture du formulaire
        $datasubmit = $this->getDataSubmit();
        echo "\n<!-- ########## START DBFORM ########## -->\n";
        echo "<form";
        echo " id=\"bordereau_envoi_maire\"";
        echo " method=\"post\"";
        echo " name=\"f1\"";
        echo " action=\"";
        echo $datasubmit;
        echo "\"";
        echo ">\n";

        // Paramétrage des champs du formulaire
        $champs = array("code_barres","date");

        // Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));

        $template_required_label = '%s *';
        // Parametrage du champ code_barres
        $form->setLib("code_barres", sprintf($template_required_label,_("Code du courrier")));
        $form->setType("code_barres", "text");
        $form->setVal("code_barres", $code_barres);
        $form->setTaille("code_barres", 20);
        $form->setMax("code_barres", 20);
        // Parametrage du champ date
        $form->setLib("date", sprintf($template_required_label,_("Date d'envoi du courrier pour signature par le maire")));
        $form->setType("date", "date") ;
        if (empty($date)) {
            $date = date('d/m/Y');
        }
        $form->setVal("date", $date);
        $form->setTaille("date", 10);
        $form->setMax("date", 10);

        // Création du bloc regroupant les champs
        $form->setBloc('code_barres','D');
        $form->setBloc('date','F');
        // Affichage du formulaire
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        // Affichage du bouton
        printf("\t<div class=\"formControls\">\n");
        //
        $this->f->layout->display_form_button(array("value" => _("Valider"), "name" => "validation"));
        printf("\t</div>\n");
        // Fermeture du formulaire
        printf("\t</form>\n");
    }

    /**
     * VIEW - view_bordereau_envoi_maire.
     * 
     * PDF de bordereau d'envoi au maire pour l'événement d'instruction instancié
     * 
     * @return [void]
     */
    function view_generate_bordereau_envoi_maire() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Récupération de la collectivité du dossier d'instruction
        $collectivite_di = $this->get_dossier_instruction_om_collectivite();
        // Récupération de ses paramètres
        $collectivite = $this->f->getCollectivite($collectivite_di);
        // Génération du PDF
        $result = $this->compute_pdf_output('etat', 'communaute_bordereau_envoi_maire', $collectivite, $this->getVal(($this->clePrimaire)));
        // Affichage du PDF
        $this->expose_pdf_output(
            $result['pdf_output'], 
            $result['filename']
        );
    }

    /**
     * VIEW - view_rapport_instruction.
     *
     * Ouvre le sous-formulaire en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_overlay_notification_manuelle() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        printf(
            '<script type="text/javascript" >
                overlayIt(\'%1$s\',\'%2$s&objsf=%1$s&idxformulaire=%4$s&retourformulaire=dossier_instruction&obj=%1$s&action=411&idx=%3$s\', 1);
            </script>',
            'instruction_notification_manuelle',
            OM_ROUTE_SOUSFORM,
            $this->getVal($this->clePrimaire),
            $this->getVal('dossier')
        );
    }

    /**
     * VIEW - view_overlay_notification_service_consulte.
     *
     * Ouvre le sous-formulaire de notification des services consulte
     * en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_overlay_notification_service_consulte() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        printf(
            '<script type="text/javascript" >
                overlayIt(\'%1$s\',\'%2$s&objsf=%1$s&idxformulaire=%4$s&retourformulaire=dossier_instruction&obj=%1$s&action=420&idx=%3$s\', 1);
            </script>',
            'instruction_notification_manuelle',
            OM_ROUTE_SOUSFORM,
            $this->getVal($this->clePrimaire),
            $this->getVal('dossier')
        );
    }
    
    /**
     * VIEW - overlay_notification_tiers_consulte.
     *
     * Ouvre le sous-formulaire de notification des tiers consulte
     * en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_overlay_notification_tiers_consulte() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        printf(
            '<script type="text/javascript" >
                overlayIt(\'%1$s\',\'%2$s&objsf=%1$s&idxformulaire=%4$s&retourformulaire=dossier_instruction&obj=%1$s&action=430&idx=%3$s\', 1);
            </script>',
            'instruction_notification_manuelle',
            OM_ROUTE_SOUSFORM,
            $this->getVal($this->clePrimaire),
            $this->getVal('dossier')
        );
    }

    /**
     * VIEW - view_modale_selection_document_signe
     *
     * Ouvre le sous-formulaire de notification des services consulte
     * en ajaxIt dans un overlay.
     * Cette action est bindée pour utiliser la fonction popUpIt.
     *
     * @return void
     */
    function view_modale_selection_document_signe() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        printf(
            '<script type="text/javascript" >
                overlayIt(\'%1$s\',\'%2$s&objsf=%1$s&idxformulaire=%4$s&retourformulaire=dossier_instruction&obj=%1$s&action=115&idx=%3$s\', 1);
            </script>',
            'instruction_modale',
            OM_ROUTE_SOUSFORM,
            $this->getVal($this->clePrimaire),
            $this->getVal('dossier')
        );
    }
    
    /**
     * Retourne l'événement d'instruction dont on donne le code-barres, avec un filtre
     * pour exclure les dossiers du groupe contentieux.
     * 
     * @param   [string]  $barcode  numéro du code-barres
     * @return  [mixed]             ID de son instruction ou null si aucun code
     */
    function get_instruction_by_barcode($barcode) {
        // Begin
        $this->begin_treatment(__METHOD__);

        // Vérification de l'existence de l'événement d'instruction
        // pour le code-barres donné, en excluant les dossiers liés au groupe CTX
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    instruction
                FROM 
                    %1$sinstruction
                    INNER JOIN %1$sdossier
                        ON dossier.dossier=instruction.dossier
                    INNER JOIN %1$sdossier_instruction_type
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    INNER JOIN %1$sdossier_autorisation_type_detaille
                        ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    INNER JOIN %1$sdossier_autorisation_type
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                    INNER JOIN %1$sgroupe
                        ON dossier_autorisation_type.groupe = groupe.groupe
                            AND groupe.code != \'CTX\'
                WHERE 
                    code_barres = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($barcode)
            ), 
            array(
                "origin" => __METHOD__,
            )
        );
        
        // Retourne résultat
        return $this->end_treatment(__METHOD__, $qres['result']);
    }

    /**
     * Met à jour le champ date d'envoi signature
     * avec la date fournie et pour l'instruction donnée
     * 
     * @param   [string]   $id    ID de l'événement d'instruction
     * @param   [string]   $date  date au format EN
     * @return  [boolean]         true si mise à jour avec succès
     */
    function update_date_envoi_signature($id, $date) {
        // Préparation du tableau
        $valF = array();
        $valF['date_envoi_signature'] = $date;
        // Begin
        $this->begin_treatment(__METHOD__);
        // Requête
        $res = $this->f->db->autoexecute(
            DB_PREFIXE.$this->table,
            $valF,
            DB_AUTOQUERY_UPDATE,
            $this->getCle($id)
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE.'.'.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getCle($id)."\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res, true) !== false) {
            $this->end_treatment(__METHOD__, false);
        }
        //
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Méthode permettant de définir des valeurs à envoyer en base après
     * validation du formulaire d'ajout.
     * @param array $val tableau des valeurs retournées par le formulaire
     */
    function setValFAjout($val = array()) {
        // Mise à jour du flag created_by_commune lors d'un changement de décision
        // par un utilisateur de commune sur un dossier instruit par la comcom
        if ($this->isInstrCanChangeDecision($this->valF["dossier"])) {
            $this->valF['created_by_commune'] = true;
        }

        //
        if ($this->evenement_has_an_edition($this->valF['evenement']) === false) {
            if (isset($this->valF['flag_edition_integrale']) === true) {
                unset($this->valF['flag_edition_integrale']);
            }
            if (isset($this->valF['signataire_arrete']) === true) {
                unset($this->valF['signataire_arrete']);
            }
        }
    }


    /**
     * Récupère l'instance d'un événement de workflow.
     *
     * @param mixed $evenement Identifiant de l'événement.
     *
     * @return object
     */
    function get_inst_evenement($evenement = null) {
        //
        return $this->get_inst_common("evenement", $evenement);
    }

    /**
     * Logue l'action de l'instruction dans son DI.
     *
     * @param string $id  Clé primaire de l'instruction.
     * @param array  $val Valeurs de l'instruction.
     *
     * @return bool Vrai si traitement effectué avec succès
     */
    private function add_log_to_dossier($id, array $val) {
        $maj = $this->getParameter("maj");
        // Action = Trace par défaut
        $action = $this->get_backtrace();
        // Action = Identifant de l'action si contexte connu
        if (empty($maj) === false
            || (empty($maj) === true && $maj === 0)) {
            $action = $this->get_action_param($maj, 'identifier');
            if ($action === 'modifier_suivi') {
                $action = "modifier (via l'action suivi des dates)";
            }
            if ($action === 'notifier_commune'
                && isset($val['mails_destinataires']) === true) {
                $action = "notification de la commune (courriels : ";
                $action .= $val['mails_destinataires'].")";
            }
        }
        // Création du log
        $log = array(
            'date' => date('Y-m-d H:i:s'),
            'user' => $_SESSION['login'],
            'action' => $action,
            'values' => array(
                'date_evenement' => $this->dateDB($val['date_evenement']),
                'date_retour_rar' => $this->dateDB($val['date_retour_rar']),
                'date_retour_signature' => $this->dateDB($val['date_retour_signature']),
                'evenement' => $val['evenement'],
                'action' => $val['action'],
                'instruction' => $id,
                'etat' => $val['etat'],
                ),
        );
        // Ajout du log
        $di = $this->get_inst_dossier($val['dossier']);
        $ret = $di->add_log_instructions($log);
        if ($ret === false) {
            $this->correct = false;
            $this->msg = '';
            $this->addToMessage($di->msg);
        }
        return $ret;
    }


    /**
     * Retourne le contexte de déboguage formaté en HTML.
     * 
     * @return string Une ligne par trace
     */
    private function get_backtrace() {
        $trace = debug_backtrace();
        $backtrace = '';
        $i = 1;
        foreach ($trace as $key => $value) {
            $func = $trace[$key]['function'];
            // On ne s'autolog pas
            if ($func === 'get_backtrace'
                || $func === 'add_log_to_dossier') {
                continue;
            }
            $backtrace .= $i.') ';
            // Si dans une classe
            if (isset($trace[$key]['class']) === true
                && empty($trace[$key]['class']) === false) {
                $backtrace .= $trace[$key]['class'].'->'.$func;
            }
            // Si procédural
            else {
                $file = $trace[$key]['file'];
                $line = $trace[$key]['line'];
                $truncated_file = $this->f->get_relative_path($file);
                if ($truncated_file !== false) {
                    $file = $truncated_file;
                }
                $backtrace .= $func.' IN<br/>&nbsp;&nbsp;&nbsp;&nbsp; '.$file.':'.$line;
            }
            $backtrace .= '<br/>';
            $i++;
        }
        return $backtrace;
    }

    /**
     * CONDITION - is_notifiable.
     *
     * Condition pour afficher l'action notifier_commune.
     *
     * @return boolean
     */
    public function is_notifiable() {
        // L'instruction doit être finalisée, ce qui revient à dire
        // définalisable sans bypass
        if ($this->is_unfinalizable_without_bypass() === false) {
            return false;
        }
        // La collectivité de l'utilisateur doit être de niveau multi
        if ($this->f->has_collectivite_multi() === false) {
            return false;
        }
        // Le paramètre multi de l'objet du courriel doit exister
        if ($this->f->getParameter('param_courriel_de_notification_commune_objet_depuis_instruction') === NULL) {
            return false;
        }
        // Le paramètre multi du modèle du courriel doit exister
        if ($this->f->getParameter('param_courriel_de_notification_commune_modele_depuis_instruction') === NULL) {
            return false;
        }
        // A ce stade toutes les conditions sont satisfaites
        return true;
    }

    /**
     * TREATMENT - notifier_commune.
     *
     * Notifie aux communes et par courriel la finalisation d'une instruction.
     *
     * @return boolean
     */
    public function notifier_commune() {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);
        $message = __('Erreur de paramétrage :');
        $erreurParametrage = false;
        // Récupération du paramétrage de la collectivité du dossier
        $id_di = $this->getVal('dossier');
        $di = $this->get_inst_dossier($id_di);
        $collectivite_di = $di->getVal('om_collectivite');
        // Récupération de l'url permettant d'accèder à l'instruction et au dossier
        $urlAcces = $this->f->get_parametre_notification_url_acces($collectivite_di);
        if (empty($urlAcces) && empty(PATH_BASE_URL)) {
            $erreurParametrage = true;
            $message .= '<br>'.__("* l'url de notification n'est pas correctement paramétré");
        }

        // Récupération de la liste des mails
        $adresses = $this->f->get_param_courriel_de_notification_commune($collectivite_di);
        if (empty($adresses)) {
            $erreurParametrage = true;
            $message .= '<br>'.__("* aucun courriel valide de destinataire de la commune");
        }

        // Vérification du paramétrage des mails
        $paramMail = $this->f->get_notification_commune_parametre_courriel_type($collectivite_di);
        if (empty($paramMail) || empty($paramMail['parametre_courriel_type_message'])) {
            $erreurParametrage = true;
            $message .= '<br>'.__("* le modèle du courriel envoyé aux communes est vide");
        }
        if (empty($paramMail) || empty($paramMail['parametre_courriel_type_titre'])) {
            $erreurParametrage = true;
            $message .= '<br>'.__("* l'objet du courriel envoyé aux communes est vide");
        }

        // Si il y a des erreurs de paramétrage on ne déclenche pas la notification et
        // un message a destination de l'utilisateur est affiché
        if ($erreurParametrage) {
            $message .= '<br>'.__("Veuillez contacter votre administrateur.");
            $this->addToMessage($message);
            return $this->end_treatment(__METHOD__, false);
        }

        // Création d'un notification et de sa tâche associé pour chaque mail
        foreach ($adresses as $adresse) {
            // Ajout de la notif et récupération de son id
            $destinataire = array(
                'destinataire' => $adresse,
                'courriel' => $adresse
            );
            $idNotif = $this->ajouter_notification(
                $this->getVal($this->clePrimaire),
                $this->f->get_connected_user_login_name(),
                $destinataire,
                $collectivite_di
            );
            if ($idNotif === false) {
                $this->addToMessage(__("Veuillez contacter votre administrateur."));
                return $this->end_treatment(__METHOD__, false);
            }
            // Création de la tache en lui donnant l'id de la notification
            $notification_by_task = $this->notification_by_task(
                $idNotif,
                $this->getVal('dossier'),
                'mail',
                'notification_commune'
            );
            if ($notification_by_task === false) {
                $this->addToMessage(__("Erreur lors de la préparation de la notification des communes."));
                $this->addToMessage(__("Veuillez contacter votre administrateur."));
                return $this->end_treatment(__METHOD__, false);
            }
        }
        $this->addToMessage(__('La commune a été notifiée.'));
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Récupère l'instance de l'instructeur
     *
     * @param integer $instructeur Identifiant de l'instructeur.
     *
     * @return object
     */
    protected function get_inst_instructeur($instructeur) {
        //
        return $this->get_inst_common("instructeur", $instructeur);
    }


    /**
     * Récupère l'instance de l'utilisateur
     *
     * @param integer $om_utilisateur Identifiant de l'utilisateur.
     *
     * @return object
     */
    protected function get_inst_om_utilisateur($om_utilisateur) {
        //
        return $this->get_inst_common("om_utilisateur", $om_utilisateur);
    }


    /**
     * Récupère l'instance de la division.
     *
     * @param integer $division Identifiant de la division.
     *
     * @return object
     */
    protected function get_inst_division($division) {
        //
        return $this->get_inst_common("division", $division);
    }


     /**
     * Récupère l'instance de la direction.
     *
     * @param integer $direction Identifiant de la direction.
     *
     * @return object
     */
    protected function get_inst_direction($direction) {
        //
        return $this->get_inst_common("direction", $direction);
    }


    /**
     * Récupère la collectivité d'un instructeur en passant par sa division puis
     * par sa direction.
     *
     * @param integer $instructeur Identifiant de l'instructeur.
     *
     * @return integer
     */
    protected function get_instructeur_om_collectivite($instructeur) {
        // Chemin vers la collectivité d'un instructeur
        $inst_instr = $this->get_inst_instructeur($instructeur);
        $inst_division = $this->get_inst_division($inst_instr->getVal('division'));
        $inst_direction = $this->get_inst_direction($inst_division->getVal('direction'));

        // Collectivité
        $om_collectivite = $inst_direction->getVal('om_collectivite');

        //
        return $om_collectivite;
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
     * CONDITION - can_user_access_dossier
     *
     * Vérifie que l'utilisateur a bien accès au dossier lié à l'instruction instanciée.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_modification() {

        $id_dossier = $this->getVal('dossier');
        //
        if ($id_dossier !== "" && $id_dossier !== null) {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
    }

    /**
     * TREATMENT - envoyer_a_signature_sans_relecture
     *
     * Permet d'envoyer le document de l'instruction au parapheur pour signature sans relecture
     *
     * @return boolean true si l'envoi a été effectué avec succès false sinon
     */
    function envoyer_a_signature_sans_relecture() {
        return $this->envoyer_a_signature();
    }

    /**
     * TREATMENT - envoyer_a_signature_avec_relecture
     *
     * Permet d'envoyer le document de l'instruction au parapheur pour signature avec relecture
     *
     * @return boolean true si l'envoi a été effectué avec succès false sinon
     */
    function envoyer_a_signature_avec_relecture() {
        $is_forced_view_files = true;
        return $this->envoyer_a_signature($is_forced_view_files);
    }

    /**
     * TREATMENT - envoyer_a_signature
     *
     * Permet d'envoyer le document de l'instruction au parapheur pour signature
     * 
     * @param  boolean  $is_forced_view_files  Indique si il y a une relecture (true) ou non (false)
     *
     * @return boolean true si l'envoi a été effectué avec succès false sinon
     */
    function envoyer_a_signature($is_forced_view_files = false) {
        $this->begin_treatment(__METHOD__);
        $this->correct = true;

        // Instanciation de l'objet signataire_arrete
        $inst_signataire_arrete = $this->f->get_inst__om_dbform(array(
            'obj' => 'signataire_arrete',
            'idx' => $this->getVal('signataire_arrete'),
        ));

        // Instanciation de l'objet dossier
        $inst_dossier = $this->f->get_inst__om_dbform(array(
            'obj' => 'dossier',
            'idx' => $this->getVal('dossier'),
        ));

        //Instanciation de la classe electronicsignature
        $inst_es = $this->get_electronicsignature_instance();
        if ($inst_es === false) {
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }

        // Vérifie si la notification se fait via l'application ou via le parapheur
        try {
            $notification_required = $inst_es->signer_notification_is_delegated();
        } catch(electronicsignature_connector_method_not_implemented_exception $_) {
            // Si la méthode n'existe pas, on considère que la notification est faite par le parapheur
            $notification_required = false;
        }

        // Si la notification est faite par l'application vérifie que l'adresse mail du
        // signataire est correcte. Si ce n'est pas le cas le document n'est pas envoyé
        // au parapheur car il ne sera pas accessible sans le lien transmis dans la
        // notification
        if ($notification_required === true) {
            $signer_mail = $inst_signataire_arrete->getVal('email');
            $signer_name = trim($inst_signataire_arrete->getVal('prenom').' '.$inst_signataire_arrete->getVal('nom'));
    
            $err_msg = __('Le document n\'a pas pu être envoyé en signature car ');

            if (empty($signer_mail)) {
                $this->correct = false;
                $err_detail = sprintf(__("l'email du signataire '%s' est vide."), $signer_name);
                $this->addToMessage($err_msg.$err_detail);
                $this->addToLog(__METHOD__.$err_msg.$err_detail.' Instruction : '.$this->getVal($this->clePrimaire), DEBUG_MODE);
                return $this->end_treatment(__METHOD__, false);
            }
            if (! $this->f->checkValidEmailAddress($signer_mail)) {
                $this->correct = false;
                $err_detail = sprintf(__("l'email du signataire '%s' est invalide (%s)."), $signer_name, $signer_mail);
                $this->addToMessage($err_msg.$err_detail);
                $this->addToLog(__METHOD__.$err_msg.$err_detail.' Instruction : '.$this->getVal($this->clePrimaire), DEBUG_MODE);
                return $this->end_treatment(__METHOD__, false);
            }
        }

        // Récupération du document à signer
        $file = $this->f->storage->get($this->getVal('om_fichier_instruction'));
        if ($file === OP_FAILURE) {
            $this->correct = false;
            $this->addToMessage(__("Une erreur est survenue lors de la récupération du contenu du document de l'instruction."));
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }

        // Initialisation des paramètre à passer pour l'envoi en signature
        $data = array(
            "om_utilisateur_email" => $this->f->om_utilisateur['email'],
            "om_utilisateur_nom" => $this->f->om_utilisateur['nom'],
            "signataire_arrete_email" => $inst_signataire_arrete->getVal('email'),
            "signataire_arrete_nom" => $inst_signataire_arrete->getVal('nom'),
            "signataire_arrete_prenom" => $inst_signataire_arrete->getVal('prenom'),
            // Permet d'envoyer en signature l'instruction le jour de la date limite
            "date_limite_instruction" => $this->compute_date_limite(1) != null ? $this->compute_date_limite(1) : null,
            "dossier" => $this->getVal('dossier'),
            "is_forced_view_files" => $is_forced_view_files,
            'commentaire_signature' => $is_forced_view_files === true ? __('relecture demandee.') : null
        );

        // Initialisation des métadonnées
        $metadonnee_dossier = $file['metadata'];
        // récupération de l'extension du fichier
        $extension = substr($metadonnee_dossier['filename'], strrpos($metadonnee_dossier['filename'], '.'));
        // Modification du libellé du document transmis au parapheur
        // pour le mettre sous la forme : instruction_xxx_libelle_lettretype.extension
        $metadonnee_dossier['filename'] = $this->getDocumentLibelle().$extension;
        $metadonnee_dossier['titre_document'] = $this->getDocumentTitre();

        $metadonnee_dossier['url_di'] = sprintf(
            '%1$sapp/index.php?module=form&direct_link=true&obj=dossier_instruction&action=3&idx=%2$s&direct_field=dossier&direct_form=document_numerise&direct_action=4&direct_idx=%2$s',
            $this->f->get_param_base_path_metadata_url_di() !== null ? $this->f->get_param_base_path_metadata_url_di() : PATH_BASE_URL,
            $this->getVal('dossier')
        );

        $optional_data = null;
        // Si il y a des paramètres supplémentaire spécifié dans le signataire alors on les récupère
        if ($inst_signataire_arrete->getVal('parametre_parapheur') !== null && $inst_signataire_arrete->getVal('parametre_parapheur') !== '') {
            $optional_data = json_decode($inst_signataire_arrete->getVal('parametre_parapheur'), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->correct = false;
                $this->addToMessage(__("Les paramètres supplémentaires envoyés au parapheur ne sont pas au bon format."));
                $this->addToLog(__METHOD__."(): ".
                    __("Erreur lors du décodage du format json des paramètres supplémentaires envoyé au parapheur. 
                        Tableau : ").var_export($inst_signataire_arrete->getVal('parametre_parapheur'), true)
                );
                // Termine le traitement
                return $this->end_treatment(__METHOD__, false);
            }
        }

        // Appel de la méthode de l'abstracteur send_for_signature()
        // Cette méthode doit retourner un tableau de valeur
        try {
            $result = $inst_es->send_for_signature($data, $file['file_content'], $metadonnee_dossier, $optional_data);
        }  catch (electronicsignature_exception $e) {
            $this->handle_electronicsignature_exception($e);
            return $this->end_treatment(__METHOD__, false);
        }

        // Après avoir reçu le résultat du parapheur, il faut mettre à jour les champs
        $valF = array();

        // Pour appeler la fonction modifier il faut traiter tous les champs de l'objet
        foreach($this->champs as $identifiant => $champ) {
            $valF[$champ] = $this->val[$identifiant];
        }
        // On fait ensuite nos modifications spécifiques
        $valF['id_parapheur_signature'] = $result['id_parapheur_signature'];
        $valF['statut_signature'] = $result['statut'];
        $valF['commentaire_signature'] = isset($result['commentaire_signature']) == true ? $result['commentaire_signature'] : null;
        $valF['date_envoi_signature'] = date("Y-m-d", strtotime($result['date_envoi_signature']));
        $valF['historique_signature'] = $this->get_updated_historique_signature($result);
        $valF['parapheur_lien_page_signature'] = isset($result['signature_page_url']) ? $result['signature_page_url'] : null;
        $ret = $this->modifier($valF);

        if ($ret === false) {
            $this->correct = false;
            $this->addToMessage(__("Une erreur est survenue lors de la mise à jour des champs."));
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }

        // Notification du signataire
        if ($notification_required === true) {
            if ($this->notify_signer($signer_name, $signer_mail, $data['om_utilisateur_nom']) === false) {
                $msg = __("Une erreur s'est produite lors de la notification du signataire \"%s (%s)\". Annulation de l'envoi pour signature du document%s.");
                $this->addToMessage(sprintf($msg, $signer_name, $signer_mail, ''));
                $this->addToLog(sprintf($msg, $signer_name, $signer_mail, ' : '.$this->getVal($this->clePrimaire)), DEBUG_MODE);
                // Met à jour les valeurs de l'objet courant pour prendre en compte les modifications faites
                // precedemment
                $this->init_record_data($this->getVal($this->clePrimaire));
                $this->annuler_envoi_en_signature();
                $this->correct = false;
                return $this->end_treatment(__METHOD__, true);
            }
        }

        // Message
        $this->addToMessage(__("Le document a été envoyé pour signature dans le parapheur."));
        if ($this->f->is_option_enabled('option_afficher_lien_parapheur') === true
            && array_key_exists('signature_page_url', $result) === true) {
            $this->addToMessage(sprintf(
                '<br> > <a href="%1$s" title="%2$s" target="_blank">%2$s</a>',
                $result['signature_page_url'],
                __("Signez directement le document")
            ));
        }
        if ($notification_required !== true) {
            $this->addToMessage(__("L'envoi de la notification au signataire est effectué par la plateforme."));
        }

        // Tout s'est bien passé, on termine le traitement
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Notifie le signataire d'un document à signer.
     * Gère l'affichage des messages à destination de l'utilisateur selon l'état du traitement.
     * En cas d'erreur ajoute une ligne dans les logs de l'application.
     *
     * @param  string  $signer_name         Nom du signataire
     * @param  string  $signer_mail         Mail du signataire
     * @param  string  $user_name           Nom de l'utilisateur openADS courant
     *
     * @return boolean  true si succés, false si erreur
     */
    protected function notify_signer($signer_name, $signer_mail, $user_name) {
        // message d'erreur
        $err_msg_log = sprintf(
            __("Échec de la notification du signataire \"%s (%s)\" lors de l'envoi au parapaheur du document de l'instruction : %s"),
            $signer_name,
            $signer_mail,
            $this->getVal($this->clePrimaire)
        );
        $err_msg = sprintf(
            '%s %s (%s)"',
            __("Échec de la notification du signataire"),
            $signer_name,
            $signer_mail
        );

        // vérification des informations requises
        if (empty($signer_name)) {
            $err_detail = __("le nom du signataire est vide");
            $this->addToLog(__METHOD__.', '.$err_msg_log.', '.$err_detail, DEBUG_MODE);
            $this->addToMessage($err_msg.', '.$err_detail);
            return false;
        }
        if (empty($signer_mail)) {
            $err_detail = __("le courriel du signataire est vide");
            $this->addToLog(__METHOD__.', '.$err_msg_log.', '.$err_detail, DEBUG_MODE);
            $this->addToMessage($err_msg.', '.$err_detail);
            return false;
        }
        if (empty($this->getVal('dossier'))) {
            $err_detail = __("l'identifiant du dossier est vide");
            $this->addToLog(__METHOD__.', '.$err_msg_log.', '.$err_detail, DEBUG_MODE);
            $this->addToMessage($err_msg.', '.$err_detail);
            return false;
        }

        // ajout de la notification à la liste des notifications de l'instruction
        $instruction_id = $this->getVal($this->clePrimaire);
        $inst_notif = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction_notification",
            "idx" => "]",
        ));
        $notif_val = array(
            'instruction_notification' => null,
            'instruction' => $instruction_id,
            'automatique' => true,
            'emetteur' => $user_name,
            'date_envoi' => null,
            'destinataire' => "$signer_name <$signer_mail>",
            'courriel' => $signer_mail,
            'date_premier_acces' => null,
            'statut' => '',
            'commentaire' => ''
        );
        $add_notif = $inst_notif->ajouter($notif_val);
        if ($add_notif === false) {
            $err_detail = __("Échec de l'ajout de la notification.");
            $this->addToLog(__METHOD__.' '.$err_msg_log.'. '.$err_detail.' Notification : '.var_export($notif_val, true), DEBUG_MODE);
            $this->addToMessage($err_msg);
            return false;
        }
        $notification_id = $inst_notif->getVal($inst_notif->clePrimaire);

        // ajout d'une tâche de notification (envoi du mail)
        $notification_task = $this->notification_by_task(
            $notification_id,
            $this->getVal('dossier'),
            'mail',
            'notification_signataire'
        );
        if ($notification_task === false) {
            $err_detail = sprintf(
                __("Échec de l'ajout de la tâche de notification (notification %s)."),
                $notification_id);
            $this->addToLog(__METHOD__.' '.$err_msg_log.'. '.$err_detail, DEBUG_MODE);
            $this->addToMessage($err_msg);
            return false;
        }

        // Vérification de la réussite de l'envoi du mail
        // Fais une requête pour récupérer la liste des notifications de signataire faites par mail
        // et associées à l'instruction en cours. Récupère uniquement la dernière qui doit être celle
        // qui viens d'être créée.
        // Si la tâche d'envoi du mail est en erreur alors on considère que l'envoi du mail a échoué.
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    state
                FROM
                    %1$stask
                WHERE
                    type = \'notification_signataire\'
                    AND category = \'mail\'
                    AND dossier = \'%2$s\'
                ORDER BY
                    task DESC
                LIMIT 1',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal('dossier'))
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['result'] === 'error') {
            $err_detail = sprintf(
                __("Échec de l'envoi du mail de notification (notification %s)."),
                $notification_id);
            $this->addToLog(__METHOD__.' '.$err_msg_log.'. '.$err_detail, DEBUG_MODE);
            $this->addToMessage($err_msg);
            return false;
        }

        // succès de la planification de la notification
        $this->addToMessage(sprintf(
            __('Le signataire "%s (%s)" sera notifié prochainement'),
            $signer_name,
            $signer_mail));
        return true;
    }

    /**
     * Permet de récupérer la bonne date limite en fonction de si l'instruction
     * est en incomplet notifié ou non.
     * On peut ajouter des jours à cette date grâce au paramètre "delay".
     * Cette fonction est utilisée dans un cas spécifique où on veut envoyer
     * l'instruction en signature le jour de la date limite.
     * 
     * @param int $delay Le nombre de jour à ajouter à la date limite.
     *
     * @return string $date_limite la date limite calculé ou false
     */
    private function compute_date_limite($delay) {
        // Instanciation de l'objet dossier
        $inst_dossier = $this->f->get_inst__om_dbform(array(
            'obj' => 'dossier',
            'idx' => $this->getVal('dossier'),
        ));

        $date_to_compute = null;
        if ($inst_dossier->getVal('incomplet_notifie') === 't') {
          $date_to_compute = $inst_dossier->getVal('date_limite_incompletude');
        } else {
          $date_to_compute = $inst_dossier->getVal('date_limite');
        }
        if ($date_to_compute != null) {
            return date("Y-m-d", strtotime($date_to_compute."+ $delay days"));
        }

        return null;
    }

    /**
     * Permet de récupérer la traduction de la valeur de statut_signature
     *
     * @return string la valeur de statut_signature traduite | false
     */
    function get_trad_for_statut($value_to_trad){
        $statut_signature_tab = array(
            'waiting' => __('en préparation'),
            'in_progress' => __('en cours de signature'),
            'canceled' => __('signature annulée'),
            'expired' => __('délai de signature expiré'), 
            'finished' => __('signé')
        );
        if (array_key_exists($value_to_trad, $statut_signature_tab) === true) {
            return $statut_signature_tab[$value_to_trad];
        }

        return false;
    }

    /**
     * Permet de mettre à jour le tableau json sotcké dans le champ historique_signature
     *
     * @return string (json) la valeur de historique_signature mis à jour | false
     */
    function get_updated_historique_signature($historique_signature_values) {
        
        $historique_signature_value_tab = $this->get_historique_signature_decoded();

        if ($historique_signature_value_tab === false) {
            $this->addToLog(__METHOD__."(): erreur historique signature", DEBUG_MODE);
            return false;
        }

        $last_val_historique_signature = array();

        // Si la tableau récupéré n'est pas vide alors
        // on récupère la dernière ligne du tableau
        if (empty($historique_signature_value_tab) === false) {
            $last_val_historique_signature = end($historique_signature_value_tab);
        }

        $format_date = '';
        $format_date_hour = '';
        $date_converted=array();

        $date_to_convert = array(
            'date_envoi_signature' => $historique_signature_values['date_envoi_signature'], 
            'date_limite_instruction' => $this->compute_date_limite(0), 
            'date_retour_signature' => $historique_signature_values['date_retour_signature']
        );

        // Conversion des dates en fonction de leur format
        foreach ($date_to_convert as $key => $value) {
            $date_converted[$key] = null;
            if ($value != null) {
                $format_date = 'd/m/Y';
                $format_date_hour = 'd/m/Y H:i:s';
                $date_converted[$key] = empty(date_parse($value)['hour']) === false ? date($format_date_hour, strtotime($value)) : date($format_date, strtotime($value));
            }
        }

        // Ce tableau permet de lister les colonnes de historique_signature et de les rendre traduisibles.
        // Il faut en effet mettre les gettext avec l'intitulé explicite au moins
        // une fois afin qu'il puisse être reconnu par le logiciel de traduction.
        $tab_for_columns_trad = array(
            __('entry_date'),
            __('id_parapheur_signature'),
            __('emetteur'),
            __('signataire'),
            __('date_envoi'),
            __('date_limite'),
            __('date_retour'),
            __('statut_signature'),
            __('commentaire_signature')
        );

        array_push($historique_signature_value_tab, array(
            'entry_date' => date('d/m/Y H:i:s'),
            'id_parapheur_signature' => $historique_signature_values['id_parapheur_signature'] == null ? (isset($last_val_historique_signature['id_parapheur_signature']) === true ? $last_val_historique_signature['id_parapheur_signature'] : null) : $historique_signature_values['id_parapheur_signature'],
            'emetteur' => $historique_signature_values['om_utilisateur_email'] == null ? (isset($last_val_historique_signature['emetteur']) === true ? $last_val_historique_signature['emetteur'] : null) : $historique_signature_values['om_utilisateur_email'], 
            'signataire' => $historique_signature_values['signataire_arrete_email'] == null ? (isset($last_val_historique_signature['signataire']) === true ? $last_val_historique_signature['signataire'] : null) : $historique_signature_values['signataire_arrete_email'],
            'date_envoi' => $historique_signature_values['date_envoi_signature'] == null ? (isset($last_val_historique_signature['date_envoi']) === true ? $last_val_historique_signature['date_envoi'] : null) : $date_converted['date_envoi_signature'],
            'date_limite' => $historique_signature_values['date_limite_instruction'] == null ? (isset($last_val_historique_signature['date_limite']) === true ? $last_val_historique_signature['date_limite'] : null) : $date_converted['date_limite_instruction'],
            'date_retour' => $historique_signature_values['date_retour_signature'] == null ? (isset($last_val_historique_signature['date_retour']) === true ? $last_val_historique_signature['date_retour'] : null) : $date_converted['date_retour_signature'],
            'statut_signature' => $historique_signature_values['statut'] == null ? (isset($last_val_historique_signature['statut_signature']) === true ? $last_val_historique_signature['statut_signature'] : null) : $this->get_trad_for_statut($historique_signature_values['statut']),
            'commentaire_signature' => isset($historique_signature_values['commentaire_signature']) === false || $historique_signature_values['commentaire_signature'] == null ? null : $historique_signature_values['commentaire_signature'],
        ));
        
        return json_encode($historique_signature_value_tab, JSON_HEX_APOS);
    }
    
    /**
     * TREATMENT - annuler_envoi_en_signature
     *
     * Permet d'annuler l'envoi du document de l'instruction au parapheur pour signature
     *
     * @return boolean true si l'annulation a été effectué avec succès false sinon
     */
    function annuler_envoi_en_signature() {
        $this->begin_treatment(__METHOD__);
        $this->correct = true;

        //Instanciation de la classe electronicsignature
        $inst_es = $this->get_electronicsignature_instance();
        if ($inst_es === false) {
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }

        $data = array();
        if (! empty($this->getVal('id_parapheur_signature'))) {
            $data['id_parapheur_signature'] = $this->getVal('id_parapheur_signature');
        } else {
            $this->correct = false;
            $this->addToMessage(__("Il n'y a pas d'identifiant de parapheur."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Appel de la méthode de l'abstracteur cancel_send_for_signature()
        // Cette méthode doit retourner un tableau de valeur
        try {
            $result = $inst_es->cancel_send_for_signature($data);
        }  catch (electronicsignature_exception $e) {
            $this->handle_electronicsignature_exception($e);
            return $this->end_treatment(__METHOD__, false);
        }

        // Après avoir reçu le résultat du parapheur, il faut mettre à jour les champs
        $valF = array();

        // Pour appeler la fonction modifier il faut traiter tous les champs de l'objet
        foreach($this->champs as $identifiant => $champ) {
            $valF[$champ] = $this->val[$identifiant];
        }
        // On fait ensuite nos modifications spécifiques
        $valF['id_parapheur_signature'] = null;
        $valF['statut_signature'] = $result['statut'];
        $valF['commentaire_signature'] = isset($result['commentaire_signature']) == true ? $result['commentaire_signature'] : null;
        $valF['date_envoi_signature'] = null;
        $valF['historique_signature'] = $this->get_updated_historique_signature($result);

        $ret = $this->modifier($valF);

        if ($ret === false) {
            $this->correct = false;
            $this->addToMessage(__("Une erreur est survenue lors de la mise à jour des champs."));
            // Termine le traitement
            return $this->end_treatment(__METHOD__, false);
        }

        // Message
        $this->addToMessage(__("L'annulation a été effectuée avec succès."));

        // Tout s'est bien passé, on termine le traitement
        return $this->end_treatment(__METHOD__, true);
    }


    /**
     * Récupère le contenu du champ historique_signature et le converti en tableau
     *
     * @return array sinon false en cas d'erreur
     */
    protected function get_historique_signature_decoded() {
        $val = str_replace("'", '"', $this->getVal('historique_signature'));
        if ($val === '' || $val == 'false') {
            $val = json_encode(array());
        }
        if($this->isJson($val) === false) {
            return false;
        }
        return json_decode($val, true);
    }

    /**
     * Récupère les informations à afficher dans le tableau de suivi à l'aide
     * d'une requête sql. Stocke ces informations dans un tableau.
     * Converti le tableau au format json et renvoi le json obtenu.
     *
     * Pour identifier quel suivi est affiché (notification des demandeurs, des services ou
     * de tiers) ce sont les tâches liées aux notifications qui sont utilisés.
     * La clause where de la requête est construite à partir du tableau contenant les types
     * de tâches fourni en paramètre.
     * Il est également possible d'afficher les notifications n'étant pas lié à des tâches.
     *
     * Si le suivi concerne la notification des demandeurs via le portail citoyen,
     * la date de premier accès ne sera pas affichée.
     *
     * @param array liste des tâches permettant d'identifier quelles notification afficher
     * @param boolean permet d'afficher les notifications non liées à des tâches
     * @return json
     */
    public function get_json_suivi_notification($typeTache, $nonLieTache = false) {
        $whereTypeTache = '';
        $sqlTaskNull = 'INNER';

        // Liste des champs à afficher. Permet également la traduction des noms de colonnes.
        $listeChampsTrad = array(
            __('emetteur'),
            __('date_envoi'),
            __('destinataire'),
            __('date_premier_acces'),
            __('instruction'),
            __('annexes'),
            __('statut'),
            __('commentaire')
        );
        $listeChamps = array(
            'emetteur',
            'date_envoi',
            'destinataire',
            'date_premier_acces',
            'instruction',
            'annexes',
            'statut',
            'commentaire'
        );

        // Défini si on veux que la requête récupère également les notifications qui n'ont pas
        // de tâches associées. C'est le cas pour les notifications de demandeurs lorsque la
        // notification du demandeur principal n'a pas pu être envoyée à cause d'un mauvais
        // paramétrage
        if(is_bool($nonLieTache) && $nonLieTache === true) {
            $sqlTaskNull = 'LEFT';
        }
        // Prépare la clause where pour ne récupérer que les notifications liées à certain type de tâches
        // Permet de différencier les notifications des demandeurs de celle des services et de celles des
        // tiers consulté
        if (is_array($typeTache) && $typeTache != array()) {
            if (is_array($typeTache)) {
                $whereTypeTache = sprintf(
                    'AND (task.task IS NULL OR (task.task IS NOT NULL AND task.type IN (%1$s)))',
                    "'".implode("', '", $typeTache)."'"
                );
            }
            // La date de premier accès n'a pas besoin d'être renseigné pour
            // les notifications des demandeurs via le portail citoyen.
            // Les notifications des demandeurs sont liés à 3 types de tâches
            // notification_recepisse, notification_instruction, notification_decision
            // Si le suivi de la notification concerne un de ces types de tâches on
            // considère que c'est une notification de demandeurs.
            // Dans ce cas on vérifie si cette notification est paramétrée pour passer
            // via le portail. Par défaut si rien n'est paramétré on considère que la
            // notification est faite via le portail
            if ((in_array('notification_recepisse', $typeTache) ||
            in_array('notification_instruction', $typeTache) ||
            in_array('notification_decision', $typeTache))) {
                $dossier = $this->getVal('dossier');
                $collectivite_di = $this->get_dossier_instruction_om_collectivite($dossier);
                $modeNotification = $this->f->get_param_option_notification($collectivite_di);
                if ($modeNotification === PORTAL) {
                    $listeChamps = array(
                        'emetteur',
                        'date_envoi',
                        'destinataire',
                        'instruction',
                        'annexes',
                        'statut',
                        'commentaire'
                    );
                }
            }
            // Il n'y a pas d'annexe pour la notification des communes donc pas besoin
            // de les afficher dans le suivi
            if (in_array('notification_depot_demat', $typeTache)) {
                $listeChamps = array(
                    'emetteur',
                    'date_envoi',
                    'destinataire',
                    'instruction',
                    'statut',
                    'commentaire'
                );
            }
        }

        $valSuivi = array();
        // Récupération des infos nécessaires à l'affichage du tableau
        $sql = sprintf(
            'SELECT DISTINCT
                instruction_notification.instruction_notification,
                -- Affiche la mention automatique avec le nom de l emetteur si la notification a été envoyé automatiquement
                CASE WHEN instruction_notification.automatique = TRUE 
                    THEN TRIM(CONCAT(instruction_notification.emetteur, \' \', \'(automatique)\')) 
                    ELSE instruction_notification.emetteur
                END as emetteur,
                date_envoi,
                instruction_notification.destinataire,
                instruction_notification.date_premier_acces,
                evenement.libelle as instruction,
                instruction_notification.statut,
                instruction_notification.commentaire,
                annexes.instruction_annexe as annexes
            FROM
                %1$sinstruction_notification
                LEFT JOIN %1$sinstruction
                    ON instruction.instruction = instruction_notification.instruction
                LEFT JOIN %1$sevenement
                    ON instruction.evenement = evenement.evenement
                LEFT JOIN %1$sinstruction_notification_document
                    ON instruction_notification.instruction_notification = instruction_notification_document.instruction_notification
                    AND instruction_notification_document.annexe = true
                -- Récupère les tâches liées au notification pour pouvoir par la suite identifier le type de notification
                %4$s JOIN %1$stask
                    ON instruction_notification.instruction_notification::CHARACTER VARYING = task.object_id
                    AND task.type LIKE \'notification%%\'
                -- Récupération de la liste des annexes sous la forme d une liste
                LEFT JOIN (
                    SELECT
                        instruction_notification,
                        -- Récupère la liste des annexes de la notification
                        -- sous la forme d un json pour récupérer toutes les informatiosn nécessaire
                        -- à l affichage du lien vers les annexes
                        CONCAT(
                            \'[\',
                            STRING_AGG(
                                -- Affiche le nom du fichier selon le type de document/pièce
                                CASE
                                    WHEN instruction_notification_document.document_type = \'instruction\'
                                        THEN CONCAT(
                                                \'{
                                                    "obj" : "instruction",
                                                    "champs" : "om_fichier_instruction",
                                                    "label" : "\', evenement.libelle, \'",
                                                    "id" : "\', instruction.instruction,\'"
                                                }\'
                                            )
                                    WHEN instruction_notification_document.document_type = \'consultation\'
                                        THEN CONCAT(
                                                \'{
                                                    "obj" : "consultation",
                                                    "champs" : "fichier",
                                                    "label" : "\', CONCAT_WS( \' - \', \'Avis\', service.libelle, to_char(consultation.date_retour,\'DD/MM/YYYY\')), \'", 
                                                    "id" : "\', consultation.consultation, \'"
                                                }\' 
                                            )
                                ELSE
                                    CONCAT(
                                        \'{
                                            "obj" : "document_numerise",
                                            "champs" : "uid",
                                            "label" : "\', document_numerise.nom_fichier, \' - \', document_numerise_type.libelle, \'",
                                            "id" : "\', document_numerise.document_numerise,\'"
                                        }\'
                                    )
                                END,
                                \', \'),
                            \']\'
                        ) AS instruction_annexe
                    FROM
                        %1$sinstruction_notification_document
                        LEFT JOIN %1$sinstruction
                            ON instruction_notification_document.instruction = instruction.instruction
                        LEFT JOIN %1$sevenement
                            ON instruction.evenement = evenement.evenement
                        LEFT JOIN %1$sconsultation
                            ON instruction_notification_document.document_id = consultation.consultation
                        LEFT JOIN %1$sservice
                            ON consultation.service = service.service
                        LEFT JOIN %1$sdocument_numerise
                            ON instruction_notification_document.document_id = document_numerise.document_numerise
                        LEFT JOIN %1$sdocument_numerise_type
                            ON document_numerise.document_numerise_type = document_numerise_type.document_numerise_type
                    WHERE
                        instruction_notification_document.annexe = \'t\'
                    GROUP BY
                        instruction_notification
                ) AS annexes
                    ON
                        annexes.instruction_notification = instruction_notification.instruction_notification
            WHERE
                instruction.instruction = %2$s
                %3$s
            ORDER BY
                date_envoi ASC, instruction_notification.destinataire ASC',
            DB_PREFIXE,
            intval($this->getVal('instruction')),
            $whereTypeTache,
            $sqlTaskNull
        );
        $qres = $this->f->get_all_results_from_db_query($sql, array(
                "origin" => __METHOD__
            )
        );
        // Préparation du lien de téléchargement des annexes
        $htmlList =
            '<style>
                #content .gridjs-td a.lien_annexe {
                    text-decoration : underline dotted 1px;
                }
                #content a.lien_annexe:hover {
                    text-decoration : underline solid 1px;
                    color : #46aede;
                }
                ol {padding-left : 10px;}
            </style>
            <ol>%1$s</ol>';
        $lienTelechargement =
        '<a class="lien_annexe" href="../app/index.php?module=form&amp;snippet=file&amp;obj=%1$s&amp;champ=%2$s&amp;id=%3$s" target="blank" title="%4$s">
            Annexe
        </a>';
        // Stockage des infos de chaque notification dans un tableau
        foreach ($qres['result'] as $row) {
            $valNotif = array();
            foreach($listeChamps as $champ) {
                $valNotif[$champ] = $row[$champ];
                if (($champ === 'date_envoi'
                    || $champ === 'date_premier_acces')
                    && $row[$champ] !== null
                    && $row[$champ] !== '') {
                    //
                    $valNotif[$champ] = date('d/m/Y H:i:s', strtotime($row[$champ]));
                } else if ($champ === 'annexes') {
                    $listeAnnexe = '';
                    $infoAnnexes = json_decode($row[$champ], true);
                    if (! empty($infoAnnexes) && json_last_error() === JSON_ERROR_NONE) {
                        // A partir des infos récupérées prépare le code html du lien vers chacune
                        // des annexes et ajoute un élément de liste par annexe
                        foreach($infoAnnexes as $annexe) {
                            $listeAnnexe .= sprintf(
                                '<li>%s</li>',
                                sprintf($lienTelechargement,
                                    $annexe['obj'],
                                    $annexe['champs'],
                                    $annexe['id'],
                                    $annexe['label']
                                )
                            );
                        }
                        // Construction de la liste des annexes
                        $valNotif[$champ] = sprintf(
                            $htmlList,
                            $listeAnnexe
                        );
                    }
                }
            }
            array_push($valSuivi, $valNotif);
        }

        // Passage du tableau au format json
        return json_encode($valSuivi, JSON_HEX_APOS);
    }

    /**
     * Traitement des erreurs retournées par l'abstracteur electronicsignature.
     *
     * @param electronicsignature_exception $exception Exception retournée par l'abstracteur.
     *
     * @return void
     */
    public function handle_electronicsignature_exception(electronicsignature_exception $exception) {
        $this->f->displayMessage('error', $exception->getMessage());
    }


    /**
     * Retourne une instance du connecteur electronicsignature, et la créer si elle n'existe pas.
     *
     * @param  boolean $with_handle_error Flag pour afficher ou non le message d'erreur à l'utilisateur.
     * @return electronicsignature        Instance de l'abstracteur.
     */
    public function get_electronicsignature_instance($with_handle_error = true) {
        if(isset($this->electronicsignature_instance)) {
            return $this->electronicsignature_instance;
        }
        // Instanciation du connecteur electronicsignature
        try {
            require_once "electronicsignature.class.php";
            $collectivites = array("collectivite_idx" => $this->get_dossier_instruction_om_collectivite(), "collectivite_multi_idx" => $this->f->get_idx_collectivite_multi());
            $this->electronicsignature_instance = new electronicsignature($collectivites);
        } catch (electronicsignature_exception $e) {
            if ($with_handle_error === true) {
                $this->handle_electronicsignature_exception($e);
            }
            return false;
        }
        return $this->electronicsignature_instance;
    }

    /**
     * TREATMENT - envoyer_au_controle_de_legalite
     *
     * Ajoute la tâche envoi_CL.
     * C'est le traitement de la tâche qui mettra à jour la date d'envoi au contrôle de légalité.
     *
     * @return [type] [description]
     */
    function envoyer_au_controle_de_legalite() {
        $this->begin_treatment(__METHOD__);
        $this->correct = true;

        //
        if ($this->can_be_sended_to_cl() === true) {
            // Création de la task 'envoi_CL'
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => 'envoi_CL',
                'object_id' => $this->getVal('instruction'),
                'dossier' => $this->getVal('dossier'),
            );
            // Change l'état de la tâche de notification en fonction de l'état de
            // transmission du dossier d'instruction
            $inst_di = $this->get_inst_dossier($this->getVal('dossier'));
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
                return $this->end_treatment(__METHOD__, false);
            }
            // Mise à jour du champs 'envoye_cl_platau'
            $instr_val = array(
                'envoye_cl_platau' => 't',
            );
            $res = $this->f->db->autoExecute(
                DB_PREFIXE.$this->table,
                $instr_val,
                DB_AUTOQUERY_UPDATE,
                $this->getCle($this->getVal($this->clePrimaire))
            );
            $this->addToLog(__METHOD__."(): db->autoexecute(\"".DB_PREFIXE.'.'.$this->table."\", ".print_r($instr_val, true).", DB_AUTOQUERY_UPDATE, \"".$this->getCle($this->clePrimaire)."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                $this->addToMessage(sprintf('%s %s',
                    __("Une erreur s'est produite lors de la mise à jour de l'instruction."),
                    __("Veuillez contacter votre administrateur.")
                ));
                $this->correct = false;
                return $this->end_treatment(__METHOD__, false);
            }
            // Message de validation à l'utilisateur
            $this->addToMessage(__('Votre demande de transfert au contrôle de légalité à bien été prise en compte.'));
            $this->addToMessage(__("La date d'envoi au contrôle de légalité sera mise à jour ultérieurement."));
        }
        //
        return $this->end_treatment(__METHOD__, true);
    }


    /**
     * Retourne le lien de retour (VIEW formulaire et VIEW sousformulaire).
     *
     * @param string $view Appel dans le contexte de la vue 'formulaire' ou de
     *                     la vue 'sousformulaire'.
     *
     * @return string
     */
    function get_back_link($view = "formulaire") {
        //
        $href = parent::get_back_link($view);
        //
        $crud = $this->get_action_crud();

        // Redirection vers le formulaire de modification à la validation du
        // formulaire d'ajout si l'événement associé possède une lettre type
        if (($crud === 'create'
                || ($crud === null
                    && $this->getParameter('maj') == 0))
                && $this->correct == true
                && $this->evenement_has_an_edition($this->valF['evenement']) === true) {

            // On instancie l'instruction
            $inst_instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => $this->valF[$this->clePrimaire],
            ));

            // Si l'instruction n'est pas finalisée automatiquement
            if ($inst_instruction->getVal('om_final_instruction') !== 't') {
                $href = str_replace("&action=3", "&action=1", $href);
                //
                if (strpos($href, "&retour=tab") !== false) {
                    $href = str_replace("&retour=tab", "&retour= form", $href);
                } else {
                    $href .= "&retour=form";
                }
            }
        }

        //
        return $href;
    }

    public function view_json_data() {
        $this->checkAccessibility();
        $this->f->disableLog();
        $view = $this->get_json_data();
        printf(json_encode($view));
    }

    public function get_json_data() {
        $val = array_combine($this->champs, $this->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        $val['tacite'] = 'f';
        $inst_ad = $this->f->get_inst__om_dbform(array(
            "obj" => "avis_decision",
            "idx" => $val['avis_decision'],
        ));
        if (preg_match('/[tT]acite/', $inst_ad->getVal('libelle')) === 1) {
            $val['tacite'] = 't';
        }
        return $val;
    }

    /**
     * Permet de récupérer l'identifiant de l'instruction sur le dossier, ayant
     * comme événement lié le suivant définit dans l'événement de l'instruction
     * instanciée.
     *
     * @param  string  $next_type   Correspond aux trois déclenchement automatique
     *                              de création d'instruction paramétré sur un événement.
     * @param  integer $instruction Identifiant de l'instruction à instancier.
     * @return mixed                Identifiant de l'instruction recherchée ou false.
     */
    public function get_related_instructions_next($next_type = 'retour_signature', $instruction = null) {
        if (in_array($next_type, array('retour_signature', 'retour_ar', 'suivant_tacite', )) === false) {
            return false;
        }
        $result = array();
        $evenements = array();
        if ($instruction === null) {
            $instruction = $this->getVal($this->clePrimaire);
            $evenement = $this->getVal('evenement');
            $dossier = $this->getVal('dossier');
        } else {
            $inst = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => $instruction,
            ));
            $evenement = $inst->getVal('evenement');
            $dossier = $inst->getVal('dossier');
        }
        // Récupération de l'identifiant de l'événement paramétré comme suivant
        // sur l'instruction instanciée
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    evenement_%3$s
                FROM
                    %1$sevenement
                WHERE
                    evenement = %2$s',
                DB_PREFIXE,
                intval($evenement),
                $next_type
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $ev_next = $qres["result"];
        // Récupération de l'instruction dans le dossier utilisant l'événement
        // suivant identifié dans la requête précédente
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    MAX(instruction.instruction) as instruction
                FROM
                    %1$sinstruction
                WHERE
                    dossier = \'%3$s\'
                    AND evenement = %2$s',
                DB_PREFIXE,
                intval($ev_next),
                $this->f->db->escapeSimple($dossier)
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

    public function get_related_instructions($instruction = null) {
        $result = array();
        $evenements = array();
        if ($instruction === null) {
            $instruction = $this->getVal($this->clePrimaire);
            $evenement = $this->getVal('evenement');
            $dossier = $this->getVal('dossier');
        } else {
            $inst = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => $instruction,
            ));
            $evenement = $inst->getVal('evenement');
            $dossier = $inst->getVal('dossier');
        }
        //
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    evenement
                FROM
                    %1$sevenement
                WHERE
                    evenement_retour_ar = %2$s
                    OR evenement_retour_signature = %2$s',
                DB_PREFIXE,
                intval($evenement)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $ev_parent = $qres["result"];
        //
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    MAX(instruction.instruction) as instruction
                FROM
                    %1$sinstruction
                WHERE
                    dossier = \'%3$s\'
                    AND evenement = %2$s',
                DB_PREFIXE,
                intval($ev_parent),
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $result[] = $qres["result"];
        //
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    evenement_retour_ar
                FROM
                    %1$sevenement
                WHERE
                    evenement = %2$d
                    AND evenement_retour_ar != %3$d',
                DB_PREFIXE,
                intval($ev_parent),
                intval($evenement)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $evenements[] = $qres["result"];
        //
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    evenement_retour_signature
                FROM
                    %1$sevenement
                WHERE
                    evenement = %2$s
                    AND evenement_retour_signature != %3$s
                ',
                DB_PREFIXE,
                intval($ev_parent),
                intval($evenement)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $evenements[] = $qres["result"];
        foreach ($evenements as $value) {
            if ($value !== null) {
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            MAX(instruction.instruction) as instruction
                        FROM
                            %1$sinstruction
                        WHERE
                            dossier = \'%3$s\'
                            AND evenement = %2$s',
                        DB_PREFIXE,
                        intval($value),
                        $this->f->db->escapeSimple($dossier)
                    ),
                    array(
                        "origin" => __METHOD__,
                        "force_return" => true,
                    )
                );
                if ($qres["code"] !== "OK") {
                    return false;
                }
                $result[] = $qres["result"];
            }
        }
        return $result;
    }

    protected function getDocumentType($champ = null) {
        $evenementId = $this->getVal('evenement');
        if (! empty($evenementId)) {
            $evenement = $this->f->findObjectById('evenement', $evenementId);
            if (! empty($evenement)) {
                return __("Instruction").':'.$evenement->getVal('libelle');
            }
        }
        return parent::getDocumentType();
    }

    /**
     * Récupère à l'aide d'une requête sql la liste des demandeurs
     * pouvant être notifié. C'est à dire les demandeurs acceptant
     * les notifications et pour lesquels une adresse mail existe.
     *
     * Dans le cas, d'une notification pour le portail citoyen, seul
     * le pétitionnaire principal doit être notifier et uniquement si
     * il a une adress mail et qu'il accepte les notifications.
     * 
     * @param string identifiant du dossier
     * @param boolean true si il faut récupérer la liste des demandeurs notifiable
     * pour une notification de categorie portail
     * @return array liste des demandeurs pouvant être notifié
    */
    protected function get_demandeurs_notifiable($idDossier = null, $portail = false) {
        if ($idDossier === null) {
            $idDossier = $this->getVal('dossier');
        }
        // Ajoute une condition sur le where pour ne récupérer que le pétitionnaire principal
        // pour une notification depuis le portail citoyen
        $sqlPetitionnairePrincipal = '';
        // Gestion des champs nécessaires pour la notification d'un demandeur
        $condition_demandeur = "AND demandeur.notification = 't'
            AND demandeur.courriel IS NOT NULL";
        if ($portail === true) {
            $sqlPetitionnairePrincipal = 'AND lien_dossier_demandeur.petitionnaire_principal = true';
            $condition_demandeur = "AND (
                    (notification = 't' AND courriel IS NOT NULL)
                    OR demande.source_depot = 'portal'
                )";
        }

        $listeDemandeursNotifiable = array();

        // Requête de récupération des demandeurs
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    demandeur.demandeur,
                    CASE
                        WHEN demandeur.qualite=\'particulier\' 
                        THEN TRIM(CONCAT(demandeur.particulier_nom, \' \', demandeur.particulier_prenom, \' \', demandeur.courriel)) 
                    ELSE
                        TRIM(CONCAT(demandeur.personne_morale_raison_sociale, \' \', demandeur.personne_morale_denomination, \' \', demandeur.courriel)) 
                    END AS destinataire,
                    demandeur.courriel,
                    petitionnaire_principal
                FROM
                    %1$sdossier
                    INNER JOIN %1$slien_dossier_demandeur
                        ON dossier.dossier = lien_dossier_demandeur.dossier
                    INNER JOIN %1$sdemandeur
                        ON lien_dossier_demandeur.demandeur = demandeur.demandeur
                    -- Récupération de la plus ancienne demande associée au dossier (la demande
                    -- de création du dossier)
                    INNER JOIN (
                        SELECT
                            demande,
                            dossier_instruction,
                            source_depot
                        FROM
                            %1$sdemande
                        WHERE
                            dossier_instruction = \'%2$s\'
                        ORDER BY
                            demande ASC
                        LIMIT 1
                    ) as demande
                        ON dossier.dossier = demande.dossier_instruction
                WHERE
                    dossier.dossier = \'%2$s\'
                    %3$s
                    %4$s',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idDossier),
                $condition_demandeur,
                $sqlPetitionnairePrincipal
            ),
            array(
                "origin" => __METHOD__
            )
        );
        // Récupération des infos des demandeurs et stockage dans un tableau
        // ayant pour clé les id des demandeurs
        foreach ($qres['result'] as $row) {
            $listeDemandeursNotifiable[$row['demandeur']] = $row;
        }

        return $listeDemandeursNotifiable;
    }

    /**
     * Renvoie la liste des notifications liées à l'instruction
     *
     * @param integer id de l'instruction dont on cherche les notifications
     * @return array liste des instruction_notification liés à l'instruction
     */
    public function get_instruction_notification($id_instruction, $typeNotification = null, $nonLieTache = false) {
        $whereTypeTache = '';
        $sqlTaskNull = 'INNER';
        // Défini si on veux que la requête récupère également les notifications qui n'ont pas
        // de tâches associées. C'est le cas pour les notifications de demandeurs lorsque la
        // notification du demandeur principal n'a pas pu être envoyée à cause d'un mauvais
        // paramétrage
        if(is_bool($nonLieTache) && $nonLieTache === true) {
            $sqlTaskNull = 'LEFT';
        }
        if ($typeNotification != null) {
            if (is_array($typeNotification)) {
                $whereTypeTache = sprintf(
                    'AND (task.type IN (%1$s))',
                    "'".implode("', '", $typeNotification)."'"
                );
            } else {
                $whereTypeTache = sprintf(
                    'AND (task.type = \'%1$s\')',
                    $typeNotification
                );
            }
        }
        $listeInstrNotif = array();
        $qres = $this->f->get_all_results_from_db_query(
            sprintf('
                SELECT
                    instruction_notification.instruction_notification
                FROM
                    %1$sinstruction_notification
                    %4$s JOIN %1$stask
                        ON instruction_notification.instruction_notification::CHARACTER VARYING = task.object_id
                        %3$s
                WHERE
                    instruction = %2$s',
                DB_PREFIXE,
                intval($id_instruction),
                $whereTypeTache,
                $sqlTaskNull
            ),
            array(
                "origin" => __METHOD__
            )
        );
        foreach ($qres['result'] as $row) {
            $listeInstrNotif[] = $row['instruction_notification'];
        }
        return $listeInstrNotif;
    }

    /**
     * Crée une clé d'accès unique permettant à un utilisateur
     * anonyme de récupérer le document.
     *
     * @return string clé d'accès du document
     */
    protected function getCleAccesDocument() {
        // Initialisation d'un tableau
        $number_list = array();

        // Génération aléatoire d'un nombre sur 4 caractères, 4 fois
        for ($i = 0; $i < 4; $i++) { 
            $number_list[] = str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT);
        }

        // Transformation en chaîne tout en séparant les nombres par un "-"
        $result = implode('-', $number_list);

        // Vérifie si la clé existe déjà et si c'est le cas génére une nouvelle clé
        if ($this->getUidDocumentInstructionWithKey($result) != null) {
            return $this->getCleAccesDocument();
        }

        //
        return $result;
    }

    /**
     * Récupère une clé et renvoie l'uid du document liée à cette
     * clé. Si la clé n'existe pas renvoie null.
     * 
     * @param string $cleGen clé dont on cherche l'instruction
     * @return integer|null 
     */
    protected function getUidDocumentInstructionWithKey($cleGen) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    instruction.om_fichier_instruction
                FROM 
                    %1$sinstruction_notification_document
                    LEFT JOIN %1$sinstruction
                        ON instruction_notification_document.instruction = instruction.instruction
                WHERE 
                    instruction_notification_document.cle = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($cleGen)
            ), 
            array(
                "origin" => __METHOD__,
            )
        );
        
        return $qres['result'];
    }

    /**
     * Récupère une clé, fait une requête pour récupérer l'id de la notification liée a cette clé.
     * Récupère l'instance de instruction_notification dont l'id a été récupéré et la renvoie.
     * 
     * @param string $cleGen
     * @return instruction_notification
     */
    protected function getInstanceNotificationWithKey($key) {
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
            "idx" => $qres['result'],
        ));
        return $instNotif;
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
        $uidFichier = $this->getUidDocumentInstructionWithKey($cle_acces_document);
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
     * Récupère le titre du document envoyé au parapheur
     */
    protected function getDocumentTitre($champ = null) {
        $title = $this->getTitle();
        $dossier = $this->getDossier();
        return $dossier.' '.$title;
    }

    /**
     * Compose le nom du document à transmettre au parapheur.
     * Le nom ets composé de cette manière :
     * instruction_xxx_libelle_de_la_lettre_type_associee
     * ou xxx correspond au numéro de l'instruction
     */
    protected function getDocumentLibelle() {
        // Récupère le champ instruction
        $instruction = $this->getVal("instruction");

        // Requête sql servant à récupérer le titre du document
        // TO_CHAR() introduit un espace avant l'affichage du nombre
        // comme les espaces sont remplacé par des '_' dans le retour de la fonction
        // il n'est pas nécessaire de mettre un '_' après le mot instruction.
        $documentLibelle = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    CONCAT(
                        \'instruction\',
                        TO_CHAR(instruction.instruction, \'000\'),
                        \'_\',
                        LOWER(om_lettretype.libelle)
                    ) AS nom_fichier
                FROM
                    %1$sinstruction
                    LEFT JOIN %1$som_lettretype 
                        ON om_lettretype.id = instruction.lettretype
                WHERE
                    instruction = %2$d',
                DB_PREFIXE,
                intval($instruction)
            ), 
            array(
                "origin" => __METHOD__,
            )
        );

        $documentLibelle = $documentLibelle['result'];

        // Transforamtion des ' ' en '_', des accents en lettres sans accents et des
        // caractères spéciaux en '_'
        // La méthode normalize_string est utilisé pour gérer les accents
        $documentLibelle = $this->f->normalize_string($documentLibelle);
        // TODO : comparer cette liste et celle de la méthode normalize_string
        // pour éviter les doublons + vérifier qu'il n'y a pas de doublons dans cette
        // liste
        $invalid = array('Œ'=>'oe', 'œ'=>'oe', 'Ÿ'=>'y', 'ü'=>'u',
            '¢' => '_', 'ß' => '_', '¥' => '_', '£' => '_', '™' => '_', '©' => '_',
            '®' => '_', 'ª' => '_', '×' => '_', '÷' => '_', '±' => '_', '²' => '_',
            '³' => '_', '¼' => '_', '½' => '_', '¾' => '_', 'µ' => '_', '¿' => '_',
            '¶' => '_', '·' => '_', '¸' => '_', 'º' => '_', '°' => '_', '¯' => '_',
            '§' => '_', '…' => '_', '¤' => '_', '¦' => '_', '≠' => '_', '¬' => '_',
            'ˆ' => '_', '¨' => '_', '‰' => '_', '¤' => '_', '€' => '_', '$' => '_',
            '«' => '_', '»' => '_', '‹' => '_', '›' => '_', 'ƒ' => '_', '¥' => '_',
            '‘‘' => '_', '‚' => '_', '!' => '_', '¡' => '_', '¢' => '_', '£' => '_',
            '?' => '_', '[' => '_', ']' => '_', '´' => '_', '`' => '_', '^' => '_',
            '~' => '_', '˜' => '_', '#' => '_', '*' => '_', '.' => '_', ':' => '_',
            ';' => '_', '•' => '_', '¯' => '_', '‾' => '_', '–' => '_', '–' => '_',
            '—' => '_', '_' => '_', '|' => '_', '¦‌' => '_', '‡' => '_', '§' => '_', 
            '¶' => '_', '©' => '_', '®' => '_', '™' => '_', '&' => '_', '@' => '_', 
            '/' => '_', '\\' => '_', '◊' => '_', '♠' => '_', '♣' => '_', '♥' => '_',
            '♦' => '_', '←' => '_', '↑' => '_', '→' => '_', '↓' => '_', '↔' => '_',
            '°' => '_', 'µ' => '_', '<' => '_', '>' => '_', '≤' => '_', '≥' => '_',
            '=' => '_', '≈' => '_', '≠' => '_', '≡' => '_', '±' => '_', '−' => '_',
            '+' => '_', '×' => '_', '÷' => '_', '⁄' => '_', '%' => '_', '‰' => '_',
            '¼' => '_', '½' => '_', '¾' => '_', '¹' => '_', '²' => '_', '³' => '_',
            '' => '_', 'º' => '_', 'ª' => '_', 'ƒ' => '_', '′' => '_', '″' => '_',
            '∂' => '_', '∏' => '_', '∑' => '_', '√' => '_', '∞' => '_', '¬' => '_',
            '∩' => '_', '∫' => '_', 'α' => '_', 'Α' => '_', 'β' => '_', 'Β' => '_',
            'γ' => '_', 'Γ' => '_', 'δ' => '_', 'Δ' => '_', 'ε' => '_', 'Ε' => '_',
            'ζ' => '_', 'Ζ' => '_', 'η' => '_', 'Η' => '_', 'θ' => '_', 'Θ' => '_',
            'ι' => '_', 'Ι' => '_', 'κ' => '_', 'Κ' => '_', 'λ' => '_', 'Λ' => '_',
            'μ' => '_', 'Μ' => '_', 'ν' => '_', 'Ν' => '_', 'ξ' => '_', 'Ξ' => '_',
            'ο' => '_', 'Ο' => '_', 'π' => '_', 'Π' => '_', 'ρ' => '_', 'Ρ' => '_',
            'σ' => '_', 'ς' => '_', 'Σ' => '_', 'τ' => '_', 'Τ' => '_', 'υ' => '_',
            'Υ' => '_', 'φ' => '_', 'Φ' => '_', 'χ' => '_', 'Χ' => '_', 'ψ' => '_',
            'Ψ' => '_', 'ω' => '_', 'Ω' => '_', ',' => '_', ' ' => '_'
        );

        return str_replace(array_keys($invalid), array_values($invalid), $documentLibelle);
    }

    /**
     * Surcharge permettant de ne pas afficher le fil d'Ariane dans
     * l'overlay de notification des demandeurs.
     */
    function getSubFormTitle($ent) {
        $actionSansPath = array('411', '420', '430');
        if (in_array($this->getParameter('maj'), $actionSansPath)) {
            return '';
        }
        return parent::getSubFormTitle($ent);
    }
    
    /**
     * Traitement de la notification automatique des tiers consulté.
     *
     * Récupère la liste des adresses mails des tiers notifiables. Pour chaque adresses
     * récupérées ajoute une notification et une tâche de notification par mail.
     * La création de la tâche de notification par mail déclenchera l'envoi du mail
     * et la mise à jour du suivi.
     *
     * Les tiers notifiables sont ceux :
     *   - n’ayant pas un ID PLAT’AU correspondant à l’ID PLAT’AU du service consultant
     *   - ayant une habilitation dont le type est listé dans les paramètres de
     *     notification de l’événement,
     *   - intervenant sur la commune ou le département du dossier
     *   - ayant au moins une adresse mail valide
     *
     * @param evenement instance de l'événement associée à l'instruction
     * @param dossier instance du dossier de l'instruction
     * @return boolean indique si le traitement à réussi
     */
    protected function traitement_notification_automatique_tiers_consulte($evenement, $dossier) {
        // Récupération de l'identifiant plat'au du service consultant
        $consultationEntrante = $dossier->get_inst_consultation_entrante();
        // Récupération de la liste des types d'habilitations autorisées pour
        // cette notification
        $typesHabilitationsNotifiable = $evenement->get_types_habilitation_notifiable();
        // Récupération du département et de la commune du dossier
        $commune = $dossier->getVal('commune');
        // Le département est récupéré à partir de la commune du dossier donc si la
        // commune n'a pas pu être récupéré on ne récupère pas non plus le département.
        $idDepartement = null;
        if (! empty($commune)) {
            $departement = $dossier->get_inst_departement_dossier();
            $idDepartement = $departement->getVal($departement->clePrimaire);
        }
        // Récupération des courriels des tiers notifiables
        $tiersANotifier = $this->get_courriels_tiers_notifiable(
            $typesHabilitationsNotifiable,
            $consultationEntrante->getVal('service_consultant_id'),
            $commune,
            $idDepartement
        );
        // Traitement de chacune des listes de diffusion pour extraire les
        // courriels, vérifier la validité des courriels et envoyer la
        // notification
        $notificationSend = false;
        if (empty($tiersANotifier)) {
            $this->addToLog(
                sprintf(
                    '%s() : %s %s : %s',
                    __METHOD__,
                    __("La récupération des tiers à échoué."),
                    __('Paramétrage'),
                    var_export(
                        array(
                            'types_habilitations_notifiable' => $typesHabilitationsNotifiable,
                            'service_consultant' => $consultationEntrante->getVal('service_consultant_id'),
                            'id_commune' => $commune,
                            'id_departement' => $idDepartement
                        ),
                        true
                    )
                ),
                DEBUG_MODE
            );
            return false;
        }
        foreach($tiersANotifier as $tierANotifier) {
            // Découpe la liste de diffusion pour stocker les adresses mails
            // des tiers dans un tableau
            $courriels =
                array_filter(
                    array_map(
                        'trim',
                        preg_split("/\r\n|\n|\r/", $tierANotifier['liste_diffusion'])));
                
            foreach ($courriels as $courriel) {
                // Pour chaque adresse mail vérifie si l'adresse est valide
                if (! $this->f->checkValidEmailAddress($courriel)) {
                    continue;
                }
                $destinataire = array(
                    'destinataire' => $tierANotifier['libelle'].' : '.$courriel,
                    'courriel' => $courriel
                );
                // Si l'adresse est valide ajoute une nouvelle notification
                // et une tâche d'envoi de mails
                $idNotif = $this->ajouter_notification(
                    $this->getVal($this->clePrimaire),
                    $this->f->get_connected_user_login_name(),
                    $destinataire,
                    $this->get_dossier_instruction_om_collectivite(),
                    array(),
                    true
                );
                if ($idNotif === false) {
                    $this->addToLog(
                        __METHOD__.
                        __("L'ajout de la notification a échoué."),
                        DEBUG_MODE
                    );
                    return false;
                }
                // Création de la tache en lui donnant l'id de la notification
                $notification_by_task = $this->notification_by_task(
                    $idNotif,
                    $dossier->getVal('dossier'),
                    'mail',
                    'notification_tiers_consulte'
                );
                if ($notification_by_task === false) {
                    $this->addToLog(
                        __METHOD__.
                        __("L'ajout de la tâche de notification a échoué."),
                        DEBUG_MODE
                    );
                    $this->addToMessage(
                        __("Erreur lors de la génération de la notification au(x) pétitionnaire(s).")
                    );
                    return false;
                }
                $notificationSend = true;
            }
        }
        // Si aucune notification n'a été envoyé car il n'y a pas de courriels
        // valide, affiche un message dans les logs pour avoir un suivi.
        if (! $notificationSend) {
            $this->addToLog(
                sprintf(
                    '%s %s : %s %s : %s',
                    __METHOD__,
                    __("Il n'y a pas de tiers notifiable pour l'instruction"),
                    $evenement->getVal('libelle'),
                    __("du dossier"),
                    $this->getVal('dossier')
                ),
                DEBUG_MODE
            );
        }
        return true;
    }

    /**
     * Récupère, à l'aide d'une requête, la liste de diffusion des tiers
     * respectant les conditions suvantes :
     *   - le tiers consulté dois accepté les notifications
     *   - la liste de diffusion ne dois pas être vide
     *   - l'uid du tiers consulté ne dois pas être celui passé en paramètre
     *     si pas d'uid passé en paramètre alors on ne filtre pas selon l'uid
     *     du tiers
     *   - le type d'habilitation des tiers dois appartenir à la liste
     *     fournie en paramètre
     *   - le tiers dois être associé à la commune ou au département passé
     *     en paramètre
     *
     * @param array $typesHabilitations tableau contenant la liste des types d'habilitation
     *              pouvant être notifiée
     * @param integer $idPlautau uid de l'acteur plat'au du dossier qui ne dois pas être notifié
     * @param integer $commune identifiant de la commune du dossier
     * @param integer $departement identifiant du département du dossier
     *
     * @return array listes de diffusion des tiers notifiable
     */
    protected function get_courriels_tiers_notifiable(array $typesHabilitations, $idPlatau, $commune, $departement) {
        // Si paramètre non renseigné alors ne renvoie rien
        if (empty($typesHabilitations) || empty($commune) || empty($departement)) {
            return false;
        }
        // Si il n'y a pas d'acteur associé au dossier alors on ne filtre pas sur l'uid de l'acteur
        $filtreServiceConsulteDI = '';
        if (! empty($idPlatau)) {
            $filtreServiceConsulteDI = sprintf(
                "-- Filtre les tiers ayant une ligne correspondante a l uid platau du service
                -- en charge du dossier
                AND (tiers_consulte.uid_platau_acteur !~ ('\y' || '%s' || '\y')
                    OR tiers_consulte.uid_platau_acteur IS NULL)",
                $this->f->db->escapeSimple($idPlatau)
            );
        }
        $rst = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    -- Tiers notifiables lié à la commune du dossier
                    tiers_consulte.liste_diffusion,
                    tiers_consulte.libelle
                FROM
                    %1$shabilitation_tiers_consulte
                    LEFT JOIN %1$stiers_consulte
                        ON habilitation_tiers_consulte.tiers_consulte = tiers_consulte.tiers_consulte
                    LEFT JOIN %1$slien_habilitation_tiers_consulte_commune
                        ON habilitation_tiers_consulte.habilitation_tiers_consulte = lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte
                    -- Conservation uniquement des tiers acteur de dossiers
                    JOIN %1$slien_dossier_tiers
                        ON tiers_consulte.tiers_consulte = lien_dossier_tiers.tiers
                WHERE
                    tiers_consulte.accepte_notification_email IS TRUE
                    AND tiers_consulte.liste_diffusion IS NOT NULL
                    %3$s
                    AND habilitation_tiers_consulte.type_habilitation_tiers_consulte IN (%2$s)
                    AND lien_habilitation_tiers_consulte_commune.commune = %4$d
                    -- Filtre sur les tiers acteur du dossier
                    AND lien_dossier_tiers.dossier = \'%6$s\'
                UNION
                SELECT
                    -- Tiers notifiables lié au département du dossier
                    tiers_consulte.liste_diffusion,
                    tiers_consulte.libelle
                FROM
                    %1$shabilitation_tiers_consulte
                    LEFT JOIN %1$stiers_consulte
                        ON habilitation_tiers_consulte.tiers_consulte = tiers_consulte.tiers_consulte
                    LEFT JOIN %1$slien_habilitation_tiers_consulte_departement
                        ON habilitation_tiers_consulte.habilitation_tiers_consulte = lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte
                    -- Conservation uniquement des tiers acteur de dossiers
                    JOIN %1$slien_dossier_tiers
                        ON tiers_consulte.tiers_consulte = lien_dossier_tiers.tiers
                WHERE
                    tiers_consulte.accepte_notification_email IS TRUE
                    AND tiers_consulte.liste_diffusion IS NOT NULL
                    %3$s
                    AND habilitation_tiers_consulte.type_habilitation_tiers_consulte IN (%2$s)
                    AND lien_habilitation_tiers_consulte_departement.departement = %5$d
                    -- Filtre sur les tiers acteur du dossier
                    AND lien_dossier_tiers.dossier = \'%6$s\'',
                DB_PREFIXE,
                implode(', ', $typesHabilitations),
                $filtreServiceConsulteDI,
                intval($commune),
                intval($departement),
                $this->f->db->escapeSimple($this->getVal('dossier'))
            ),
            array(
                "origin" => __METHOD__
            )
        );
        // Faire un order by sur un union ne fonctionne pas. A la place
        // c'est le tableau des résultats qui est ordonné.
        usort($rst['result'], function($a, $b) {
            return strcmp($a['libelle'], $b['libelle']);
        });
        return $rst['result'];
    }
}
