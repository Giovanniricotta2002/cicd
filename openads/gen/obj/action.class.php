<?php
//$Id$ 
//gen openMairie le 15/04/2021 16:25

require_once "../obj/om_dbform.class.php";

class action_gen extends om_dbform {

    protected $_absolute_class_name = "action";

    var $table = "action";
    var $clePrimaire = "action";
    var $typeCle = "A";
    var $required_field = array(
        "action",
        "libelle"
    );
    
    var $foreign_keys_extended = array(
    );
    
    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("libelle");
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "action",
            "libelle",
            "regle_etat",
            "regle_delai",
            "regle_accord_tacite",
            "regle_avis",
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
            "regle_delai_incompletude",
            "regle_autorite_competente",
            "regle_date_cloture_instruction",
            "regle_date_premiere_visite",
            "regle_date_derniere_visite",
            "regle_date_contradictoire",
            "regle_date_retour_contradictoire",
            "regle_date_ait",
            "regle_date_transmission_parquet",
            "regle_donnees_techniques1",
            "regle_donnees_techniques2",
            "regle_donnees_techniques3",
            "regle_donnees_techniques4",
            "regle_donnees_techniques5",
            "cible_regle_donnees_techniques1",
            "cible_regle_donnees_techniques2",
            "cible_regle_donnees_techniques3",
            "cible_regle_donnees_techniques4",
            "cible_regle_donnees_techniques5",
            "regle_dossier_instruction_type",
            "regle_date_affichage",
            "regle_pec_metier",
            "regle_a_qualifier",
            "regle_incompletude",
            "regle_incomplet_notifie",
            "regle_etat_pendant_incompletude",
            "regle_evenement_suivant_tacite_incompletude",
        );
    }




    function setvalF($val = array()) {
        //affectation valeur formulaire
        $this->valF['action'] = $val['action'];
        $this->valF['libelle'] = $val['libelle'];
        if ($val['regle_etat'] == "") {
            $this->valF['regle_etat'] = NULL;
        } else {
            $this->valF['regle_etat'] = $val['regle_etat'];
        }
        if ($val['regle_delai'] == "") {
            $this->valF['regle_delai'] = NULL;
        } else {
            $this->valF['regle_delai'] = $val['regle_delai'];
        }
        if ($val['regle_accord_tacite'] == "") {
            $this->valF['regle_accord_tacite'] = NULL;
        } else {
            $this->valF['regle_accord_tacite'] = $val['regle_accord_tacite'];
        }
        if ($val['regle_avis'] == "") {
            $this->valF['regle_avis'] = NULL;
        } else {
            $this->valF['regle_avis'] = $val['regle_avis'];
        }
        if ($val['regle_date_limite'] == "") {
            $this->valF['regle_date_limite'] = NULL;
        } else {
            $this->valF['regle_date_limite'] = $val['regle_date_limite'];
        }
        if ($val['regle_date_notification_delai'] == "") {
            $this->valF['regle_date_notification_delai'] = NULL;
        } else {
            $this->valF['regle_date_notification_delai'] = $val['regle_date_notification_delai'];
        }
        if ($val['regle_date_complet'] == "") {
            $this->valF['regle_date_complet'] = NULL;
        } else {
            $this->valF['regle_date_complet'] = $val['regle_date_complet'];
        }
        if ($val['regle_date_validite'] == "") {
            $this->valF['regle_date_validite'] = NULL;
        } else {
            $this->valF['regle_date_validite'] = $val['regle_date_validite'];
        }
        if ($val['regle_date_decision'] == "") {
            $this->valF['regle_date_decision'] = NULL;
        } else {
            $this->valF['regle_date_decision'] = $val['regle_date_decision'];
        }
        if ($val['regle_date_chantier'] == "") {
            $this->valF['regle_date_chantier'] = NULL;
        } else {
            $this->valF['regle_date_chantier'] = $val['regle_date_chantier'];
        }
        if ($val['regle_date_achevement'] == "") {
            $this->valF['regle_date_achevement'] = NULL;
        } else {
            $this->valF['regle_date_achevement'] = $val['regle_date_achevement'];
        }
        if ($val['regle_date_conformite'] == "") {
            $this->valF['regle_date_conformite'] = NULL;
        } else {
            $this->valF['regle_date_conformite'] = $val['regle_date_conformite'];
        }
        if ($val['regle_date_rejet'] == "") {
            $this->valF['regle_date_rejet'] = NULL;
        } else {
            $this->valF['regle_date_rejet'] = $val['regle_date_rejet'];
        }
        if ($val['regle_date_dernier_depot'] == "") {
            $this->valF['regle_date_dernier_depot'] = NULL;
        } else {
            $this->valF['regle_date_dernier_depot'] = $val['regle_date_dernier_depot'];
        }
        if ($val['regle_date_limite_incompletude'] == "") {
            $this->valF['regle_date_limite_incompletude'] = NULL;
        } else {
            $this->valF['regle_date_limite_incompletude'] = $val['regle_date_limite_incompletude'];
        }
        if ($val['regle_delai_incompletude'] == "") {
            $this->valF['regle_delai_incompletude'] = NULL;
        } else {
            $this->valF['regle_delai_incompletude'] = $val['regle_delai_incompletude'];
        }
        if ($val['regle_autorite_competente'] == "") {
            $this->valF['regle_autorite_competente'] = NULL;
        } else {
            $this->valF['regle_autorite_competente'] = $val['regle_autorite_competente'];
        }
        if ($val['regle_date_cloture_instruction'] == "") {
            $this->valF['regle_date_cloture_instruction'] = NULL;
        } else {
            $this->valF['regle_date_cloture_instruction'] = $val['regle_date_cloture_instruction'];
        }
        if ($val['regle_date_premiere_visite'] == "") {
            $this->valF['regle_date_premiere_visite'] = NULL;
        } else {
            $this->valF['regle_date_premiere_visite'] = $val['regle_date_premiere_visite'];
        }
        if ($val['regle_date_derniere_visite'] == "") {
            $this->valF['regle_date_derniere_visite'] = NULL;
        } else {
            $this->valF['regle_date_derniere_visite'] = $val['regle_date_derniere_visite'];
        }
        if ($val['regle_date_contradictoire'] == "") {
            $this->valF['regle_date_contradictoire'] = NULL;
        } else {
            $this->valF['regle_date_contradictoire'] = $val['regle_date_contradictoire'];
        }
        if ($val['regle_date_retour_contradictoire'] == "") {
            $this->valF['regle_date_retour_contradictoire'] = NULL;
        } else {
            $this->valF['regle_date_retour_contradictoire'] = $val['regle_date_retour_contradictoire'];
        }
        if ($val['regle_date_ait'] == "") {
            $this->valF['regle_date_ait'] = NULL;
        } else {
            $this->valF['regle_date_ait'] = $val['regle_date_ait'];
        }
        if ($val['regle_date_transmission_parquet'] == "") {
            $this->valF['regle_date_transmission_parquet'] = NULL;
        } else {
            $this->valF['regle_date_transmission_parquet'] = $val['regle_date_transmission_parquet'];
        }
        if ($val['regle_donnees_techniques1'] == "") {
            $this->valF['regle_donnees_techniques1'] = NULL;
        } else {
            $this->valF['regle_donnees_techniques1'] = $val['regle_donnees_techniques1'];
        }
        if ($val['regle_donnees_techniques2'] == "") {
            $this->valF['regle_donnees_techniques2'] = NULL;
        } else {
            $this->valF['regle_donnees_techniques2'] = $val['regle_donnees_techniques2'];
        }
        if ($val['regle_donnees_techniques3'] == "") {
            $this->valF['regle_donnees_techniques3'] = NULL;
        } else {
            $this->valF['regle_donnees_techniques3'] = $val['regle_donnees_techniques3'];
        }
        if ($val['regle_donnees_techniques4'] == "") {
            $this->valF['regle_donnees_techniques4'] = NULL;
        } else {
            $this->valF['regle_donnees_techniques4'] = $val['regle_donnees_techniques4'];
        }
        if ($val['regle_donnees_techniques5'] == "") {
            $this->valF['regle_donnees_techniques5'] = NULL;
        } else {
            $this->valF['regle_donnees_techniques5'] = $val['regle_donnees_techniques5'];
        }
        if ($val['cible_regle_donnees_techniques1'] == "") {
            $this->valF['cible_regle_donnees_techniques1'] = NULL;
        } else {
            $this->valF['cible_regle_donnees_techniques1'] = $val['cible_regle_donnees_techniques1'];
        }
        if ($val['cible_regle_donnees_techniques2'] == "") {
            $this->valF['cible_regle_donnees_techniques2'] = NULL;
        } else {
            $this->valF['cible_regle_donnees_techniques2'] = $val['cible_regle_donnees_techniques2'];
        }
        if ($val['cible_regle_donnees_techniques3'] == "") {
            $this->valF['cible_regle_donnees_techniques3'] = NULL;
        } else {
            $this->valF['cible_regle_donnees_techniques3'] = $val['cible_regle_donnees_techniques3'];
        }
        if ($val['cible_regle_donnees_techniques4'] == "") {
            $this->valF['cible_regle_donnees_techniques4'] = NULL;
        } else {
            $this->valF['cible_regle_donnees_techniques4'] = $val['cible_regle_donnees_techniques4'];
        }
        if ($val['cible_regle_donnees_techniques5'] == "") {
            $this->valF['cible_regle_donnees_techniques5'] = NULL;
        } else {
            $this->valF['cible_regle_donnees_techniques5'] = $val['cible_regle_donnees_techniques5'];
        }
        if ($val['regle_dossier_instruction_type'] == "") {
            $this->valF['regle_dossier_instruction_type'] = NULL;
        } else {
            $this->valF['regle_dossier_instruction_type'] = $val['regle_dossier_instruction_type'];
        }
        if ($val['regle_date_affichage'] == "") {
            $this->valF['regle_date_affichage'] = NULL;
        } else {
            $this->valF['regle_date_affichage'] = $val['regle_date_affichage'];
        }
        if ($val['regle_pec_metier'] == "") {
            $this->valF['regle_pec_metier'] = NULL;
        } else {
            $this->valF['regle_pec_metier'] = $val['regle_pec_metier'];
        }
        if ($val['regle_a_qualifier'] == "") {
            $this->valF['regle_a_qualifier'] = NULL;
        } else {
            $this->valF['regle_a_qualifier'] = $val['regle_a_qualifier'];
        }
        if ($val['regle_incompletude'] == "") {
            $this->valF['regle_incompletude'] = NULL;
        } else {
            $this->valF['regle_incompletude'] = $val['regle_incompletude'];
        }
        if ($val['regle_incomplet_notifie'] == "") {
            $this->valF['regle_incomplet_notifie'] = NULL;
        } else {
            $this->valF['regle_incomplet_notifie'] = $val['regle_incomplet_notifie'];
        }
        if ($val['regle_etat_pendant_incompletude'] == "") {
            $this->valF['regle_etat_pendant_incompletude'] = NULL;
        } else {
            $this->valF['regle_etat_pendant_incompletude'] = $val['regle_etat_pendant_incompletude'];
        }
        if ($val['regle_evenement_suivant_tacite_incompletude'] == "") {
            $this->valF['regle_evenement_suivant_tacite_incompletude'] = NULL;
        } else {
            $this->valF['regle_evenement_suivant_tacite_incompletude'] = $val['regle_evenement_suivant_tacite_incompletude'];
        }
    }

    //==========================
    // Formulaire  [form]
    //==========================
    /**
     *
     */
    function setType(&$form, $maj) {
        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        // MODE AJOUTER
        if ($maj == 0 || $crud == 'create') {
            $form->setType("action", "text");
            $form->setType("libelle", "text");
            $form->setType("regle_etat", "text");
            $form->setType("regle_delai", "text");
            $form->setType("regle_accord_tacite", "text");
            $form->setType("regle_avis", "text");
            $form->setType("regle_date_limite", "text");
            $form->setType("regle_date_notification_delai", "text");
            $form->setType("regle_date_complet", "text");
            $form->setType("regle_date_validite", "text");
            $form->setType("regle_date_decision", "text");
            $form->setType("regle_date_chantier", "text");
            $form->setType("regle_date_achevement", "text");
            $form->setType("regle_date_conformite", "text");
            $form->setType("regle_date_rejet", "text");
            $form->setType("regle_date_dernier_depot", "text");
            $form->setType("regle_date_limite_incompletude", "text");
            $form->setType("regle_delai_incompletude", "text");
            $form->setType("regle_autorite_competente", "text");
            $form->setType("regle_date_cloture_instruction", "text");
            $form->setType("regle_date_premiere_visite", "text");
            $form->setType("regle_date_derniere_visite", "text");
            $form->setType("regle_date_contradictoire", "text");
            $form->setType("regle_date_retour_contradictoire", "text");
            $form->setType("regle_date_ait", "text");
            $form->setType("regle_date_transmission_parquet", "text");
            $form->setType("regle_donnees_techniques1", "text");
            $form->setType("regle_donnees_techniques2", "text");
            $form->setType("regle_donnees_techniques3", "text");
            $form->setType("regle_donnees_techniques4", "text");
            $form->setType("regle_donnees_techniques5", "text");
            $form->setType("cible_regle_donnees_techniques1", "text");
            $form->setType("cible_regle_donnees_techniques2", "text");
            $form->setType("cible_regle_donnees_techniques3", "text");
            $form->setType("cible_regle_donnees_techniques4", "text");
            $form->setType("cible_regle_donnees_techniques5", "text");
            $form->setType("regle_dossier_instruction_type", "text");
            $form->setType("regle_date_affichage", "text");
            $form->setType("regle_pec_metier", "text");
            $form->setType("regle_a_qualifier", "text");
            $form->setType("regle_incompletude", "text");
            $form->setType("regle_incomplet_notifie", "text");
            $form->setType("regle_etat_pendant_incompletude", "text");
            $form->setType("regle_evenement_suivant_tacite_incompletude", "text");
        }

        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("action", "hiddenstatic");
            $form->setType("libelle", "text");
            $form->setType("regle_etat", "text");
            $form->setType("regle_delai", "text");
            $form->setType("regle_accord_tacite", "text");
            $form->setType("regle_avis", "text");
            $form->setType("regle_date_limite", "text");
            $form->setType("regle_date_notification_delai", "text");
            $form->setType("regle_date_complet", "text");
            $form->setType("regle_date_validite", "text");
            $form->setType("regle_date_decision", "text");
            $form->setType("regle_date_chantier", "text");
            $form->setType("regle_date_achevement", "text");
            $form->setType("regle_date_conformite", "text");
            $form->setType("regle_date_rejet", "text");
            $form->setType("regle_date_dernier_depot", "text");
            $form->setType("regle_date_limite_incompletude", "text");
            $form->setType("regle_delai_incompletude", "text");
            $form->setType("regle_autorite_competente", "text");
            $form->setType("regle_date_cloture_instruction", "text");
            $form->setType("regle_date_premiere_visite", "text");
            $form->setType("regle_date_derniere_visite", "text");
            $form->setType("regle_date_contradictoire", "text");
            $form->setType("regle_date_retour_contradictoire", "text");
            $form->setType("regle_date_ait", "text");
            $form->setType("regle_date_transmission_parquet", "text");
            $form->setType("regle_donnees_techniques1", "text");
            $form->setType("regle_donnees_techniques2", "text");
            $form->setType("regle_donnees_techniques3", "text");
            $form->setType("regle_donnees_techniques4", "text");
            $form->setType("regle_donnees_techniques5", "text");
            $form->setType("cible_regle_donnees_techniques1", "text");
            $form->setType("cible_regle_donnees_techniques2", "text");
            $form->setType("cible_regle_donnees_techniques3", "text");
            $form->setType("cible_regle_donnees_techniques4", "text");
            $form->setType("cible_regle_donnees_techniques5", "text");
            $form->setType("regle_dossier_instruction_type", "text");
            $form->setType("regle_date_affichage", "text");
            $form->setType("regle_pec_metier", "text");
            $form->setType("regle_a_qualifier", "text");
            $form->setType("regle_incompletude", "text");
            $form->setType("regle_incomplet_notifie", "text");
            $form->setType("regle_etat_pendant_incompletude", "text");
            $form->setType("regle_evenement_suivant_tacite_incompletude", "text");
        }

        // MODE SUPPRIMER
        if ($maj == 2 || $crud == 'delete') {
            $form->setType("action", "hiddenstatic");
            $form->setType("libelle", "hiddenstatic");
            $form->setType("regle_etat", "hiddenstatic");
            $form->setType("regle_delai", "hiddenstatic");
            $form->setType("regle_accord_tacite", "hiddenstatic");
            $form->setType("regle_avis", "hiddenstatic");
            $form->setType("regle_date_limite", "hiddenstatic");
            $form->setType("regle_date_notification_delai", "hiddenstatic");
            $form->setType("regle_date_complet", "hiddenstatic");
            $form->setType("regle_date_validite", "hiddenstatic");
            $form->setType("regle_date_decision", "hiddenstatic");
            $form->setType("regle_date_chantier", "hiddenstatic");
            $form->setType("regle_date_achevement", "hiddenstatic");
            $form->setType("regle_date_conformite", "hiddenstatic");
            $form->setType("regle_date_rejet", "hiddenstatic");
            $form->setType("regle_date_dernier_depot", "hiddenstatic");
            $form->setType("regle_date_limite_incompletude", "hiddenstatic");
            $form->setType("regle_delai_incompletude", "hiddenstatic");
            $form->setType("regle_autorite_competente", "hiddenstatic");
            $form->setType("regle_date_cloture_instruction", "hiddenstatic");
            $form->setType("regle_date_premiere_visite", "hiddenstatic");
            $form->setType("regle_date_derniere_visite", "hiddenstatic");
            $form->setType("regle_date_contradictoire", "hiddenstatic");
            $form->setType("regle_date_retour_contradictoire", "hiddenstatic");
            $form->setType("regle_date_ait", "hiddenstatic");
            $form->setType("regle_date_transmission_parquet", "hiddenstatic");
            $form->setType("regle_donnees_techniques1", "hiddenstatic");
            $form->setType("regle_donnees_techniques2", "hiddenstatic");
            $form->setType("regle_donnees_techniques3", "hiddenstatic");
            $form->setType("regle_donnees_techniques4", "hiddenstatic");
            $form->setType("regle_donnees_techniques5", "hiddenstatic");
            $form->setType("cible_regle_donnees_techniques1", "hiddenstatic");
            $form->setType("cible_regle_donnees_techniques2", "hiddenstatic");
            $form->setType("cible_regle_donnees_techniques3", "hiddenstatic");
            $form->setType("cible_regle_donnees_techniques4", "hiddenstatic");
            $form->setType("cible_regle_donnees_techniques5", "hiddenstatic");
            $form->setType("regle_dossier_instruction_type", "hiddenstatic");
            $form->setType("regle_date_affichage", "hiddenstatic");
            $form->setType("regle_pec_metier", "hiddenstatic");
            $form->setType("regle_a_qualifier", "hiddenstatic");
            $form->setType("regle_incompletude", "hiddenstatic");
            $form->setType("regle_incomplet_notifie", "hiddenstatic");
            $form->setType("regle_etat_pendant_incompletude", "hiddenstatic");
            $form->setType("regle_evenement_suivant_tacite_incompletude", "hiddenstatic");
        }

        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType("action", "static");
            $form->setType("libelle", "static");
            $form->setType("regle_etat", "static");
            $form->setType("regle_delai", "static");
            $form->setType("regle_accord_tacite", "static");
            $form->setType("regle_avis", "static");
            $form->setType("regle_date_limite", "static");
            $form->setType("regle_date_notification_delai", "static");
            $form->setType("regle_date_complet", "static");
            $form->setType("regle_date_validite", "static");
            $form->setType("regle_date_decision", "static");
            $form->setType("regle_date_chantier", "static");
            $form->setType("regle_date_achevement", "static");
            $form->setType("regle_date_conformite", "static");
            $form->setType("regle_date_rejet", "static");
            $form->setType("regle_date_dernier_depot", "static");
            $form->setType("regle_date_limite_incompletude", "static");
            $form->setType("regle_delai_incompletude", "static");
            $form->setType("regle_autorite_competente", "static");
            $form->setType("regle_date_cloture_instruction", "static");
            $form->setType("regle_date_premiere_visite", "static");
            $form->setType("regle_date_derniere_visite", "static");
            $form->setType("regle_date_contradictoire", "static");
            $form->setType("regle_date_retour_contradictoire", "static");
            $form->setType("regle_date_ait", "static");
            $form->setType("regle_date_transmission_parquet", "static");
            $form->setType("regle_donnees_techniques1", "static");
            $form->setType("regle_donnees_techniques2", "static");
            $form->setType("regle_donnees_techniques3", "static");
            $form->setType("regle_donnees_techniques4", "static");
            $form->setType("regle_donnees_techniques5", "static");
            $form->setType("cible_regle_donnees_techniques1", "static");
            $form->setType("cible_regle_donnees_techniques2", "static");
            $form->setType("cible_regle_donnees_techniques3", "static");
            $form->setType("cible_regle_donnees_techniques4", "static");
            $form->setType("cible_regle_donnees_techniques5", "static");
            $form->setType("regle_dossier_instruction_type", "static");
            $form->setType("regle_date_affichage", "static");
            $form->setType("regle_pec_metier", "static");
            $form->setType("regle_a_qualifier", "static");
            $form->setType("regle_incompletude", "static");
            $form->setType("regle_incomplet_notifie", "static");
            $form->setType("regle_etat_pendant_incompletude", "static");
            $form->setType("regle_evenement_suivant_tacite_incompletude", "static");
        }

    }

    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        $form->setTaille("action", 30);
        $form->setTaille("libelle", 30);
        $form->setTaille("regle_etat", 30);
        $form->setTaille("regle_delai", 30);
        $form->setTaille("regle_accord_tacite", 30);
        $form->setTaille("regle_avis", 30);
        $form->setTaille("regle_date_limite", 30);
        $form->setTaille("regle_date_notification_delai", 30);
        $form->setTaille("regle_date_complet", 30);
        $form->setTaille("regle_date_validite", 30);
        $form->setTaille("regle_date_decision", 30);
        $form->setTaille("regle_date_chantier", 30);
        $form->setTaille("regle_date_achevement", 30);
        $form->setTaille("regle_date_conformite", 30);
        $form->setTaille("regle_date_rejet", 30);
        $form->setTaille("regle_date_dernier_depot", 30);
        $form->setTaille("regle_date_limite_incompletude", 30);
        $form->setTaille("regle_delai_incompletude", 30);
        $form->setTaille("regle_autorite_competente", 30);
        $form->setTaille("regle_date_cloture_instruction", 30);
        $form->setTaille("regle_date_premiere_visite", 30);
        $form->setTaille("regle_date_derniere_visite", 30);
        $form->setTaille("regle_date_contradictoire", 30);
        $form->setTaille("regle_date_retour_contradictoire", 30);
        $form->setTaille("regle_date_ait", 30);
        $form->setTaille("regle_date_transmission_parquet", 30);
        $form->setTaille("regle_donnees_techniques1", 30);
        $form->setTaille("regle_donnees_techniques2", 30);
        $form->setTaille("regle_donnees_techniques3", 30);
        $form->setTaille("regle_donnees_techniques4", 30);
        $form->setTaille("regle_donnees_techniques5", 30);
        $form->setTaille("cible_regle_donnees_techniques1", 30);
        $form->setTaille("cible_regle_donnees_techniques2", 30);
        $form->setTaille("cible_regle_donnees_techniques3", 30);
        $form->setTaille("cible_regle_donnees_techniques4", 30);
        $form->setTaille("cible_regle_donnees_techniques5", 30);
        $form->setTaille("regle_dossier_instruction_type", 30);
        $form->setTaille("regle_date_affichage", 30);
        $form->setTaille("regle_pec_metier", 30);
        $form->setTaille("regle_a_qualifier", 30);
        $form->setTaille("regle_incompletude", 30);
        $form->setTaille("regle_incomplet_notifie", 30);
        $form->setTaille("regle_etat_pendant_incompletude", 30);
        $form->setTaille("regle_evenement_suivant_tacite_incompletude", 30);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        $form->setMax("action", 150);
        $form->setMax("libelle", 60);
        $form->setMax("regle_etat", 60);
        $form->setMax("regle_delai", 60);
        $form->setMax("regle_accord_tacite", 60);
        $form->setMax("regle_avis", 60);
        $form->setMax("regle_date_limite", 60);
        $form->setMax("regle_date_notification_delai", 60);
        $form->setMax("regle_date_complet", 60);
        $form->setMax("regle_date_validite", 60);
        $form->setMax("regle_date_decision", 60);
        $form->setMax("regle_date_chantier", 60);
        $form->setMax("regle_date_achevement", 60);
        $form->setMax("regle_date_conformite", 60);
        $form->setMax("regle_date_rejet", 60);
        $form->setMax("regle_date_dernier_depot", 60);
        $form->setMax("regle_date_limite_incompletude", 60);
        $form->setMax("regle_delai_incompletude", 60);
        $form->setMax("regle_autorite_competente", 60);
        $form->setMax("regle_date_cloture_instruction", 60);
        $form->setMax("regle_date_premiere_visite", 60);
        $form->setMax("regle_date_derniere_visite", 60);
        $form->setMax("regle_date_contradictoire", 60);
        $form->setMax("regle_date_retour_contradictoire", 60);
        $form->setMax("regle_date_ait", 60);
        $form->setMax("regle_date_transmission_parquet", 60);
        $form->setMax("regle_donnees_techniques1", 60);
        $form->setMax("regle_donnees_techniques2", 60);
        $form->setMax("regle_donnees_techniques3", 60);
        $form->setMax("regle_donnees_techniques4", 60);
        $form->setMax("regle_donnees_techniques5", 60);
        $form->setMax("cible_regle_donnees_techniques1", 250);
        $form->setMax("cible_regle_donnees_techniques2", 250);
        $form->setMax("cible_regle_donnees_techniques3", 250);
        $form->setMax("cible_regle_donnees_techniques4", 250);
        $form->setMax("cible_regle_donnees_techniques5", 250);
        $form->setMax("regle_dossier_instruction_type", 60);
        $form->setMax("regle_date_affichage", 30);
        $form->setMax("regle_pec_metier", 60);
        $form->setMax("regle_a_qualifier", 60);
        $form->setMax("regle_incompletude", 60);
        $form->setMax("regle_incomplet_notifie", 60);
        $form->setMax("regle_etat_pendant_incompletude", 60);
        $form->setMax("regle_evenement_suivant_tacite_incompletude", 60);
    }


    function setLib(&$form, $maj) {
    //libelle des champs
        $form->setLib('action', __('action'));
        $form->setLib('libelle', __('libelle'));
        $form->setLib('regle_etat', __('regle_etat'));
        $form->setLib('regle_delai', __('regle_delai'));
        $form->setLib('regle_accord_tacite', __('regle_accord_tacite'));
        $form->setLib('regle_avis', __('regle_avis'));
        $form->setLib('regle_date_limite', __('regle_date_limite'));
        $form->setLib('regle_date_notification_delai', __('regle_date_notification_delai'));
        $form->setLib('regle_date_complet', __('regle_date_complet'));
        $form->setLib('regle_date_validite', __('regle_date_validite'));
        $form->setLib('regle_date_decision', __('regle_date_decision'));
        $form->setLib('regle_date_chantier', __('regle_date_chantier'));
        $form->setLib('regle_date_achevement', __('regle_date_achevement'));
        $form->setLib('regle_date_conformite', __('regle_date_conformite'));
        $form->setLib('regle_date_rejet', __('regle_date_rejet'));
        $form->setLib('regle_date_dernier_depot', __('regle_date_dernier_depot'));
        $form->setLib('regle_date_limite_incompletude', __('regle_date_limite_incompletude'));
        $form->setLib('regle_delai_incompletude', __('regle_delai_incompletude'));
        $form->setLib('regle_autorite_competente', __('regle_autorite_competente'));
        $form->setLib('regle_date_cloture_instruction', __('regle_date_cloture_instruction'));
        $form->setLib('regle_date_premiere_visite', __('regle_date_premiere_visite'));
        $form->setLib('regle_date_derniere_visite', __('regle_date_derniere_visite'));
        $form->setLib('regle_date_contradictoire', __('regle_date_contradictoire'));
        $form->setLib('regle_date_retour_contradictoire', __('regle_date_retour_contradictoire'));
        $form->setLib('regle_date_ait', __('regle_date_ait'));
        $form->setLib('regle_date_transmission_parquet', __('regle_date_transmission_parquet'));
        $form->setLib('regle_donnees_techniques1', __('regle_donnees_techniques1'));
        $form->setLib('regle_donnees_techniques2', __('regle_donnees_techniques2'));
        $form->setLib('regle_donnees_techniques3', __('regle_donnees_techniques3'));
        $form->setLib('regle_donnees_techniques4', __('regle_donnees_techniques4'));
        $form->setLib('regle_donnees_techniques5', __('regle_donnees_techniques5'));
        $form->setLib('cible_regle_donnees_techniques1', __('cible_regle_donnees_techniques1'));
        $form->setLib('cible_regle_donnees_techniques2', __('cible_regle_donnees_techniques2'));
        $form->setLib('cible_regle_donnees_techniques3', __('cible_regle_donnees_techniques3'));
        $form->setLib('cible_regle_donnees_techniques4', __('cible_regle_donnees_techniques4'));
        $form->setLib('cible_regle_donnees_techniques5', __('cible_regle_donnees_techniques5'));
        $form->setLib('regle_dossier_instruction_type', __('regle_dossier_instruction_type'));
        $form->setLib('regle_date_affichage', __('regle_date_affichage'));
        $form->setLib('regle_pec_metier', __('regle_pec_metier'));
        $form->setLib('regle_a_qualifier', __('regle_a_qualifier'));
        $form->setLib('regle_incompletude', __('regle_incompletude'));
        $form->setLib('regle_incomplet_notifie', __('regle_incomplet_notifie'));
        $form->setLib('regle_etat_pendant_incompletude', __('regle_etat_pendant_incompletude'));
        $form->setLib('regle_evenement_suivant_tacite_incompletude', __('regle_evenement_suivant_tacite_incompletude'));
    }
    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {

    }


    //==================================
    // sous Formulaire
    //==================================
    

    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        $this->retourformulaire = $retourformulaire;
        $this->set_form_default_values($form, $maj, $validation);
    }// fin setValsousformulaire

    //==================================
    // cle secondaire
    //==================================
    
    /**
     * Methode clesecondaire
     */
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // On appelle la methode de la classe parent
        parent::cleSecondaire($id);
        // Verification de la cle secondaire : evenement
        $this->rechercheTable($this->f->db, "evenement", "action", $id);
        // Verification de la cle secondaire : instruction
        $this->rechercheTable($this->f->db, "instruction", "action", $id);
    }


}
