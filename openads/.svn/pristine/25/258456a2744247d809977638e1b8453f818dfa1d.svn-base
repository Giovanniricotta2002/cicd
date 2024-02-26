<?php
//$Id$ 
//gen openMairie le 09/10/2020 15:34

include "../gen/sql/pgsql/task.inc.php";

// Supression du bouton d'ajout d'une nouvelle tâche à partir du formulaire
$tab_actions['corner']['ajouter'] = NULL;

if(!empty($obj) && $obj == "task" ){
    $ent = __("Administration")." -> ".__("Moniteur Plat'AU");
    $tab_title = sprintf("%s %s", __("Moniteur Plat'AU"), __("tâche"));
    $category = PLATAU;
    $args_type = array(
        //
        0 => array(
            "", 
            'ajout_piece',
            'add_piece',
            'avis_consultation',
            'creation_DA',
            'creation_DI',
            'create_DI',
            'creation_consultation',
            'completude_DI',
            'create_DI_for_consultation',
            'decision_DI',
            'depot_DI',
            'envoi_CL',
            'incompletude_DI',
            'modification_DI',
            'modification_DA',
            'notification_recepisse',
            'notification_instruction',
            'notification_decision',
            'notification_service_consulte',
            'notification_tiers_consulte',
            'pec_metier_consultation',
            'prescription',
            'qualification_DI',
            'lettre_incompletude',
            'lettre_majoration'),

            1 => array(
            __("choisir")." ".__("type"),
            __('Ajout pièce (sortant)'),
            __('Ajout pièce (entrant)'),
            __('Avis'),
            __('Création DA'),
            __('Création DI'),
            __('Création demande'),
            __('Création consultation'),
            __('Complétude DI'),
            __('Création DI pour consultation'),
            __('Décision DI'),
            __('Dépôt DI'),
            __('Envoi contrôle de légalité'),
            __('Incomplétude DI'),
            __('Modification DI'),
            __('Modification DA'),
            __('Notification récépissé'),
            __('Notification instruction'),
            __('Notification décision'),
            __('Notification service consulté'),
            __('Notification tiers consulté'),
            __('PeC consultation'),
            __('Prescription'),
            __('Qualification DI'),
            __('Lettre au pétitionnaire d\'incompletude'),
            __('Lettre au pétitionnaire de majoration')
        )
    );
}
else {
    $ent = __("Administration")." -> ".__("Moniteur iDE'AU");
    $tab_title = sprintf("%s %s", __("Moniteur iDE'AU"), __("tâche"));
    $category = PORTAL;

    $args_type = array(
        //
        0 => array(
            "",
            'avis_consultation',
            "creation_DA",
            "creation_DI",
            'create_DI_for_consultation',
            "depot_DI",
            'create_message',
            'notification_recepisse',
            'notification_instruction',
            'notification_decision',
            'notification_service_consulte',
            'notification_tiers_consulte',
            'pec_metier_consultation',
            'prescription',
            "qualification_DI"),

        1 => array(
            __("choisir")." ".__("type"),
            __('Avis'),
            __("Création DA"),
            __("Création DI"),
            __('Création DI pour consultation'),
            __("Dépôt DI"),
            __('Message'),
            __('Notification récépissé'),
            __('Notification instruction'),
            __('Notification décision'),
            __('Notification service consulté'),
            __('Notification tiers consulté'),
            __('PeC consultation'),
            __('Prescription'),
            __("Qualification DI")),
    );
}

$template_case_traduction_type =
    'CASE WHEN task.type=\'creation_DA\' 
            THEN \''.__("Création DA").'\'
            WHEN task.type=\'creation_DI\' 
            THEN \''.__("Création DI").'\'
            WHEN task.type=\'modification_DA\' 
            THEN \''.__("Modification DA").'\'
            WHEN task.type=\'modification_DI\' 
            THEN \''.__("Modification DI").'\'
            WHEN task.type=\'ajout_piece\' 
            THEN \''.__("Ajout pièce (sortant)").'\'
            WHEN task.type=\'add_piece\' 
            THEN \''.__("Ajout pièce (entrant)").'\'
            WHEN task.type=\'depot_DI\' 
            THEN \''.__("Dépôt DI").'\'
            WHEN task.type=\'qualification_DI\' 
            THEN \''.__("Qualification DI").'\'
            WHEN task.type=\'creation_consultation\' 
            THEN \''.__("Création consultation").'\'
            WHEN task.type=\'decision_DI\' 
            THEN \''.__("Décision DI").'\'
            WHEN task.type=\'envoi_CL\' 
            THEN \''.__("Envoi contrôle de légalité").'\'
            WHEN task.type=\'pec_metier_consultation\' 
            THEN \''.__("PeC consultation").'\'
            WHEN task.type=\'avis_consultation\' 
            THEN \''.__("Avis").'\'
            WHEN task.type=\'prescription\' 
            THEN \''.__("Prescription").'\'
            WHEN task.type=\'create_DI_for_consultation\' 
            THEN \''.__("Création DI pour consultation").'\'
            WHEN task.type=\'create_message\' 
            THEN \''.__("Message").'\'
            WHEN task.type=\'notification_recepisse\' 
            THEN \''.__("Notification récépissé").'\'
            WHEN task.type=\'notification_instruction\' 
            THEN \''.__("Notification instruction").'\'
            WHEN task.type=\'notification_decision\' 
            THEN \''.__("Notification décision").'\'
            WHEN task.type=\'notification_service_consulte\' 
            THEN \''.__("notification service consulté").'\'
            WHEN task.type=\'notification_tiers_consulte\' 
            THEN \''.__("notification tiers consulté").'\'
            WHEN task.type=\'notification_signataire\' 
            THEN \''.__("Notification signataire").'\'
            WHEN task.type=\'incompletude_DI\' 
            THEN \''.__("incomplétude DI").'\'
            WHEN task.type=\'completude_DI\' 
            THEN \''.__("completude DI").'\'
            WHEN task.type=\'create_DI\' 
            THEN \''.__("Création demande").'\'
            WHEN task.type=\'lettre_incompletude\' 
            THEN \''.__('Lettre au pétitionnaire d\'\'incompletude').'\'
            WHEN task.type=\'lettre_majoration\' 
            THEN \''.__('Lettre au pétitionnaire de majoration').'\'
    END';

$template_case_traduction_etat =
    'CASE WHEN task.state=\'draft\' 
            THEN \''.__("brouillon").'\'
            WHEN task.state=\'new\' 
            THEN \''.__("à traiter").'\'
            WHEN task.state=\'pending\' 
            THEN \''.__("en cours").'\'
            WHEN task.state=\'done\' 
            THEN \''.__("terminé").'\'
            WHEN task.state=\'archived\' 
            THEN \''.__("archivé").'\'
            WHEN task.state=\'error\' 
            THEN \''.__("erreur").'\'
            WHEN task.state=\'debug\' 
            THEN \''.__("debug").'\'
            WHEN task.state=\'canceled\' 
            THEN \''.__("annulé").'\'
    END';

$template_case_traduction_flux =
    'CASE WHEN task.stream=\'input\' 
            THEN \''.__("Entrant").'\'
            WHEN task.stream=\'output\' 
            THEN \''.__("Sortant").'\'
    END';


$champAffiche = array(
    'task.task as "'.__("tâche").'"',
    $template_case_traduction_type.' as "'.__("type").'"',
    'CONCAT(
        \'<span class="task_state task_\',
        task.state,
        \'">\',
        '.$template_case_traduction_etat.',
        \' </span>\') as "'.__("état").'"',
    'task.object_id as "'.__("réf. interne").'"',
    'task.dossier as "'.__("dossier").'"',
    $template_case_traduction_flux.' as "'._("flux").'"',
    "CONCAT_WS(' ', to_char(task.creation_date, 'DD/MM/YYYY'), task.creation_time)".' as "'.__("Date de création").'"',
    "CONCAT_WS(' ', to_char(task.last_modification_date, 'DD/MM/YYYY'), task.last_modification_time)".' as "'.__("Date de dernière modification").'"',
    'task.comment as "'.__("commentaire").'"',
    );

$args_state = array(
    //
    0 => array("", "draft", "new", "pending", "done", "archived", "error", "debug", "canceled", ),
    1 => array(__("choisir")." ".__("état"),__("brouillon"), __("à traiter"), __("en cours"), __("terminé"), __("archivé"), __("erreur"), __("debug"), __("annulé"), ),
);

$args_stream = array(
    //
    0 => array("", "input", "output"),
    1 => array(_("choisir")." ".__("flux"), __("Entrant"), __("Sortant")),
);

$advsearch_fields= array(
    //
    'task' => array(
        'colonne' => 'task',
        'table' => 'task',
        'libelle' => __("tâche"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    ),

    'contenu_json' => array(
        'colonne' => 'json_payload',
        'table' => 'task',
        'libelle' => __("json payload"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    ),

    'type' => array(
        'colonne' => 'type',
        'table' => 'task',
        'libelle' => __("type"),
        'type' => 'select',
        'subtype' => 'sqlselect',
        'sql' => 'SELECT 
                    DISTINCT(type),
                    '.$template_case_traduction_type.'
                  FROM 
                      '.DB_PREFIXE.'task
                  WHERE 
                      task.category = \''.$category.'\'
                  ORDER BY type ASC',
    ),

    'state' => array(
        'colonne' => 'state',
        'table' => 'task',
        'libelle' => __("état"),
        'type' => 'select',
        'subtype' => 'manualselect',
        'args' => $args_state
    ),

    'object_id' => array(
        'colonne' => 'object_id',
        'table' => 'task',
        'libelle' => __("réf. interne"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    ),

     'dossier' => array(
        'colonne' => 'dossier',
        'table' => 'task',
        'libelle' => __("dossier"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    ),

    'stream' => array(
        'colonne' => 'stream',
        'table' => 'task',
        'libelle' => __("flux"),
        'type' => 'select',
        'subtype' => 'manualselect',
        'args' => $args_stream
    ),

    'creation_date' => array(
        'colonne' => 'creation_date',
        'table' => 'task',
        'libelle' => __("Date de création"),
        'lib1'=> __("debut"),
        'lib2' => __("fin"),
        'type' => 'date',
        'taille' => 8,
        'where' => 'intervaldate',
    ),

    'last_modification_date' => array(
        'colonne' => 'last_modification_date',
        'table' => 'task',
        'libelle' => __("Date de dernière modification"),
        'lib1'=> __("debut"),
        'lib2' => __("fin"),
        'type' => 'date',
        'taille' => 8,
        'where' => 'intervaldate',
    ),

    'comment' => array(
        'colonne' => 'comment',
        'table' => 'task',
        'libelle' => __("commentaire"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    ),

);

// Nb d'enregistrements affichés dans le listing
$serie = 50;

// Désactivation de l'affichage du select pagination
$options[] = array (
    'type' => 'pagination_select', 
    'display' => false
);

// advsearch -> options
$options[] = array(
    'type' => 'search',
    'display' => true,
    'advanced' => $advsearch_fields,
    'absolute_object' => 'dossier',
    'default_form'  => 'advanced',
);

$champRecherche = array(
    'task.task as "'.__("task").'"',
    'task.type as "'.__("type").'"',
    'task.state as "'.__("state").'"',
    'task.object_id as "'.__("object_id").'"',
    'task.dossier as "'.__("dossier").'"',
    'task.stream as "'.__("stream").'"',
    'task.category as "'.__("category").'"',
    'task.creation_date as "'.__("creation_date").'"',
    'task.last_modification_date as "'.__("last_modification_date").'"',
    'task.comment as "'.__("commentaire").'"',
);

$selection = " WHERE LOWER(task.category) = '".PLATAU."'";

$tri="ORDER BY task.task ASC NULLS LAST";
