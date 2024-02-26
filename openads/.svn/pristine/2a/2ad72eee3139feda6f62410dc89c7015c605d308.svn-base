<?php

require_once "../obj/task.class.php";

class suivi_tache extends task {

     /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    public function init_class_actions() {

        //
        $this->class_actions[998] = array(
            "identifier" => "desc_type",
            "view" => "view_desc_type"
        );
    }


    /**
     * VIEW - view_desc_type
     * Retourne la description des types de tâche.
     *
     * @return string
     */
    public function view_desc_type() {
        $this->checkAccessibility();
        $this->f->disableLog();

        $tab_descriptions_col_type = array(
            __("Création DA") => __("Création du projet"),
            __("Création demande") => __("Création du dossier d'instruction"),
            __("Dépôt DI") => __("Dépôt du dossier d'instruction"),
            __("Modification DI") => __("Modification du dossier d'instruction"),
            __("Qualification DI") => __("Permet le changement de compétence en état ou commune pour état"),
            __("Décision DI") => __("Décision sur le dossier d'instruction"),
            __("Incomplétude DI") => __("Incomplétude sur le dossier"),
            __("Completude DI") => __("Complétude sur le dossier"),
            __("Ajout pièce (sortant)") => __("Ajout d'une pièce au dossier"),
            __("Ajout pièce (entrant)") => __("Ajout d'une pièce au dossier"),
            __("Création consultation") => __("Création d'une consultation sur le dossier"),
            __("Modification DA") => __("Modification du projet"),
            __("Envoi contrôle de légalité") => __("Envoi contrôle de légalité"),
            __("Création DI pour consultation") => __("Ajour d'un dossier à partir d'une consultation entrante"),
            __("Avis") => __("Avis sur une consultation"),
            __("PeC consultation") => __("Prise en compte métier sur une consultation"),
            __("Message") => __("Ajout d'un message au dossier d'instruction "),
            __("Prescription") => __("Création d'une préscription"),
            __("Notification récépissé") => __("Notification du récépissé"),
            __("Notification instruction") => __("Notification de l'instruction"),
            __("Notification décision") => __("Notification de la décision"),
            __("Notification service consulté") => __("Notification du service consulté"),
            __("Notification tiers consulté") => __("Notification du tiers consulté"),
        );

        $description_col_type = "";

        foreach ($tab_descriptions_col_type as $type => $description) {
            $description_col_type .= sprintf(
                "%s : %s\n",
                $type,
                $description
            );
        }
        echo $description_col_type;
    }

}