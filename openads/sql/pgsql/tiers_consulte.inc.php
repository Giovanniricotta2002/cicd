<?php
//$Id$ 
//gen openMairie le 28/02/2022 15:38

include "../gen/sql/pgsql/tiers_consulte.inc.php";

$ent = __("parametrage")." -> ".__("gestion des consultations")." -> ".__("tiers");


// SELECT 
$champAffiche = array(
    'tiers_consulte.tiers_consulte as "'.__("tiers_consulte").'"',
    'categorie_tiers_consulte.libelle as "'.__("categorie_tiers_consulte").'"',
    'tiers_consulte.abrege as "'.__("abrege").'"',
    'tiers_consulte.libelle as "'.__("libelle").'"'
);
// FROM
$table = DB_PREFIXE."tiers_consulte
            LEFT JOIN ".DB_PREFIXE."categorie_tiers_consulte
                ON categorie_tiers_consulte.categorie_tiers_consulte=tiers_consulte.categorie_tiers_consulte
            LEFT JOIN ".DB_PREFIXE."lien_categorie_tiers_consulte_om_collectivite
                ON categorie_tiers_consulte.categorie_tiers_consulte=lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte
            LEFT JOIN ".DB_PREFIXE."om_collectivite
                ON om_collectivite.om_collectivite=lien_categorie_tiers_consulte_om_collectivite.om_collectivite";

// WHERE
// Affichage uniquement des tiers lié à la collectivité de l'utilisateur pour les
// utilisateur associé à des collectivités de niveau 1.
if ($_SESSION["niveau"] != "2") {
    $and_or_where = " WHERE";
    // Si on est dans le contexte de la catégorie tiers consulté
    if (in_array($retourformulaire, $foreign_keys_extended["categorie_tiers_consulte"])) {
        $and_or_where = " AND";
    }

    $selection .= $and_or_where." (lien_categorie_tiers_consulte_om_collectivite.om_collectivite = '".$_SESSION["collectivite"]."') ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 * dossier_operateur ne doit pas apparaître dans les onglets de tiers_consulte
 */
$sousformulaire = array(
    'consultation',
    'habilitation_tiers_consulte',
    'lien_om_utilisateur_tiers_consulte',
);

// Options pour les select de faux booléens
$args_bool = array(
    //
    0 => array("", "t", "f", ),
    1 => array(__("choisir")." ".__("valeur"), __("Oui"), __("Non"), ),
);

// Recherche avancée
$advsearch_fields= array(
    //
    'tiers_consulte' => array(
        'colonne' => 'tiers_consulte',
        'table' => 'tiers_consulte',
        'libelle' => __("tiers_consulte"),
        'type' => 'text',
        'taille' => '',
        'max' => ''
    )
    ,
    "categorie_tiers_consulte" => array(
        'sql' => sprintf(
            'SELECT
                DISTINCT (categorie_tiers_consulte.categorie_tiers_consulte),
                categorie_tiers_consulte.libelle
            FROM
                %1$stiers_consulte
                LEFT JOIN %1$scategorie_tiers_consulte
                    ON categorie_tiers_consulte.categorie_tiers_consulte=tiers_consulte.categorie_tiers_consulte
                LEFT JOIN %1$slien_categorie_tiers_consulte_om_collectivite
                    ON categorie_tiers_consulte.categorie_tiers_consulte=lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte
                %2$s     
            ORDER BY 
                categorie_tiers_consulte.libelle ASC',
           DB_PREFIXE,
           $selection // Même filtre que pour l'affichage du listing
        ),
        'subtype' => 'sqlselect',
        'colonne' => 'categorie_tiers_consulte',
        'table' => 'tiers_consulte',
        'libelle' => __('categorie_tiers_consulte'),
        'type' => 'select' 
    )
    ,
    "abrege" => array(
        'colonne' => "abrege",
        'table' => 'tiers_consulte',
        'libelle' => __("abrege"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'libelle' => array(
        'colonne' => 'libelle',
        'table' => 'tiers_consulte',
        'libelle' => __("libelle"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'adresse' => array(
        'colonne' => 'adresse',
        'table' => 'tiers_consulte',
        'libelle' => __("adresse"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'complement' => array(
        'colonne' => 'complement',
        'table' => 'tiers_consulte',
        'libelle' => __("complement"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'cp' => array(
        'colonne' => 'cp',
        'table' => 'tiers_consulte',
        'libelle' => __("cp"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'ville' => array(
        'colonne' => 'ville',
        'table' => 'tiers_consulte',
        'libelle' => __("ville"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'liste_diffusion' => array(
        'colonne' => 'liste_diffusion',
        'table' => 'tiers_consulte',
        'libelle' => __("liste_diffusion"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'accepte_notification_email' => array(
        'colonne' => 'accepte_notification_email',
        'table' => 'tiers_consulte',
        'libelle' => __("accepte_notification_email"),
        'type' => 'select',
        'subtype' => 'manualselect',
        'args' => $args_bool,
    )
    ,
    'uid_platau_acteur' => array(
        'colonne' => 'uid_platau_acteur',
        'table' => 'tiers_consulte',
        'libelle' => __("uid_platau_acteur"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
);

// Affiche le service (collectivité) uniquement pour les utilisateur de la collectivité de niveau 2
if ($_SESSION['niveau'] == '2') {
    // Permet d'afficher comme nom de colonne et de champs de recherche "service"
    // en mode service consulté et "collectivité" sinon
    $label = __('collectivite');
    if ($f->is_option_mode_service_consulte_enabled() === true) {
        $label = __('service');
    }
    // Affichage de la recherche par service
    $advsearch_fields['om_collectivite'] = array(
        'sql' =>
            "SELECT
                DISTINCT (om_collectivite.om_collectivite),
                om_collectivite.libelle
            FROM
                ".DB_PREFIXE."tiers_consulte
                LEFT JOIN ".DB_PREFIXE."categorie_tiers_consulte
                    ON categorie_tiers_consulte.categorie_tiers_consulte=tiers_consulte.categorie_tiers_consulte
                LEFT JOIN ".DB_PREFIXE."lien_categorie_tiers_consulte_om_collectivite
                    ON categorie_tiers_consulte.categorie_tiers_consulte=lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte
                LEFT JOIN ".DB_PREFIXE."om_collectivite
                    ON om_collectivite.om_collectivite=lien_categorie_tiers_consulte_om_collectivite.om_collectivite
            ORDER BY
                om_collectivite.libelle",
        'subtype' => 'sqlselect',
        'table' => 'om_collectivite',
        'colonne' => 'om_collectivite',
        'type' => 'select',
        'libelle' => $label
    );
    // Affichage de la colonne service
    $champAffiche[] = 'om_collectivite.libelle as "'.$label.'"';
}

// advsearch -> options
$options[] =  array(
    'type' => 'search',
    'display' => true,
    'advanced' => $advsearch_fields,
    'absolute_object' => 'tiers_consulte',
    'export' => array("csv"),
);

if ($f->get_submitted_get_value('mode') === 'export_csv') {

    $table .= sprintf(
        '-- Récupération des informations concernant les habilitations de tiers et leur type
        LEFT JOIN %1$shabilitation_tiers_consulte
            ON habilitation_tiers_consulte.tiers_consulte = tiers_consulte.tiers_consulte
        LEFT JOIN %1$stype_habilitation_tiers_consulte
            ON type_habilitation_tiers_consulte.type_habilitation_tiers_consulte = habilitation_tiers_consulte.type_habilitation_tiers_consulte
        -- communes liées aux habilitations de tiers
        LEFT JOIN %1$slien_habilitation_tiers_consulte_commune
            ON lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
        LEFT JOIN %1$scommune
            ON lien_habilitation_tiers_consulte_commune.commune = commune.commune
        -- département liés aux habilitation de tiers
        LEFT JOIN %1$slien_habilitation_tiers_consulte_departement
            ON lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
        LEFT JOIN %1$sdepartement
            ON lien_habilitation_tiers_consulte_departement.departement = departement.departement
        -- Récupération de la spécialité de l habilitation de tiers
        LEFT JOIN (
            SELECT
                habilitation_tiers_consulte,
                ARRAY_TO_STRING(
                    ARRAY_AGG(
                        CONCAT_WS(
                            \' - \',
                            specialite_tiers_consulte.specialite_tiers_consulte,
                            specialite_tiers_consulte.code,
                            specialite_tiers_consulte.libelle)
                        ORDER BY specialite_tiers_consulte.specialite_tiers_consulte ASC),
                    \', \')
                AS specialite_tiers_consulte
            FROM
                %1$slien_habilitation_tiers_consulte_specialite_tiers_consulte
                INNER JOIN %1$sspecialite_tiers_consulte
                    ON lien_habilitation_tiers_consulte_specialite_tiers_consulte.specialite_tiers_consulte = specialite_tiers_consulte.specialite_tiers_consulte
            GROUP BY
                habilitation_tiers_consulte) AS specialite_tiers_consulte_liste
                ON specialite_tiers_consulte_liste.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
        -- liste des om_utilisateur
        LEFT JOIN (
            SELECT
                tiers_consulte,
                ARRAY_TO_STRING(
                    ARRAY_AGG(
                        om_utilisateur.login
                        ORDER BY lien_om_utilisateur_tiers_consulte.om_utilisateur ASC), 
                    \', \')
                AS om_utilisateur
            FROM
                %1$slien_om_utilisateur_tiers_consulte
                INNER JOIN %1$som_utilisateur
                    ON lien_om_utilisateur_tiers_consulte.om_utilisateur = om_utilisateur.om_utilisateur
            GROUP BY
                tiers_consulte) AS om_utilisateur_liste
                ON om_utilisateur_liste.tiers_consulte = tiers_consulte.tiers_consulte',
        DB_PREFIXE
    );

    $champAffiche = array(
        // Champs de la table tiers consulté avec traduction
        'tiers_consulte.tiers_consulte as "'.__("tiers_consulte").'"',
        'tiers_consulte.abrege as "'.__("abrege").'"',
        'tiers_consulte.libelle as "'.__("libelle").' '.__("tiers_consulte").'"',
        'tiers_consulte.adresse as "'.__("adresse").'"',
        'tiers_consulte.complement as "'.__("complement").'"',
        'tiers_consulte.cp as "'.__("cp").'"',
        'tiers_consulte.ville as "'.__("ville").'"',
        'tiers_consulte.liste_diffusion as "'.__("liste_diffusion").'"',
        'CASE tiers_consulte.accepte_notification_email WHEN \'t\'
            THEN \'Oui\'
            ELSE \'Non\'
        END AS "'.__("accepte_notification_email").'"',
        'tiers_consulte.uid_platau_acteur as "'.__("uid_platau_acteur").'"',
        'om_utilisateur_liste.om_utilisateur as "'.__("om_utilisateur").'"',
        'tiers_consulte.categorie_tiers_consulte as "'.__("categorie_tiers_consulte").'"',
        // Champs de la table categorie_tiers_consulte avec traduction
        'categorie_tiers_consulte.libelle as "'.__("libelle").' '.__("categorie_tiers_consulte").'"',
        'categorie_tiers_consulte.code as "'.__("code").'"',
        'categorie_tiers_consulte.description as "'.__("description").'"',
        'to_char(categorie_tiers_consulte.om_validite_debut, \'DD/MM/YYYY\') as "'
            .__("om_validite_debut").' '.__("categorie_tiers_consulte").'"',
        'to_char(categorie_tiers_consulte.om_validite_fin, \'DD/MM/YYYY\') as "'
            .__("om_validite_fin").' '.__("categorie_tiers_consulte").'"',
        'om_collectivite.libelle as "'.__("om_collectivite").'"',
        // Champs de la table habilitation_tiers_consulte avec traduction
        'habilitation_tiers_consulte.type_habilitation_tiers_consulte as "'.__("type_habilitation_tiers_consulte").'"',
        'type_habilitation_tiers_consulte.libelle as "'
            .__("libelle").' '.__("type_habilitation_tiers_consulte").'"',
        'habilitation_tiers_consulte.texte_agrement as "'.__("texte_agrement").'"',
        'commune.commune as "'.__("identifiant de la commune").'"',
        'commune.libelle as "'.__("commune").'"',
        'departement.departement as "'.__("identifiant du département").'"',
        'departement.libelle as "'.__("département").'"',
        'habilitation_tiers_consulte.division_territoriales as "'.__("division_territoriales").'"',
        'to_char(habilitation_tiers_consulte.om_validite_debut, \'DD/MM/YYYY\') as "'
            .__("om_validite_debut").' '.__("habilitation_tiers_consulte").'"',
        'to_char(habilitation_tiers_consulte.om_validite_fin, \'DD/MM/YYYY\') as "'
            .__("om_validite_fin").' '.__("habilitation_tiers_consulte").'"',
        'specialite_tiers_consulte_liste.specialite_tiers_consulte as "'.__("specialite_tiers_consulte").'"'
    );
}
