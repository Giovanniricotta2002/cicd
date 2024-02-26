<?php
//$Id$ 
//gen openMairie le 01/03/2022 16:34

include "../gen/sql/pgsql/habilitation_tiers_consulte.inc.php";

$ent = __("parametrage")." -> ".__("gestion des consultations")." -> ".__("habilitation des tiers consultés");

// SELECT 
$champAffiche = array(
    'habilitation_tiers_consulte.habilitation_tiers_consulte as "'.__("habilitation_tiers_consulte").'"',
    'type_habilitation_tiers_consulte.libelle as "'.__("type_habilitation_tiers_consulte").'"',
    'to_char(habilitation_tiers_consulte.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(habilitation_tiers_consulte.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    'tiers_consulte.libelle as "'.__("tiers_consulte").'"',
    'habilitation_tiers_consulte.division_territoriales as "'.__("division_territoriales").'"',
    );

$champNonAffiche = array(
    'habilitation_tiers_consulte.texte_agrement as "'.__("texte_agrement").'"',
    );
    
 // Recherche avancée
$advsearch_fields = array(
    //
    'habilitation_tiers_consulte' => array(
        'colonne' => 'habilitation_tiers_consulte',
        'table' => 'habilitation_tiers_consulte',
        'libelle' => __("habilitation_tiers_consulte"),
        'type' => 'text',
        'taille' => 30,
        'max' => ''
    ),
    "type_habilitation_tiers_consulte" => array(
        'colonne' => "type_habilitation_tiers_consulte",
        'table' => 'type_habilitation_tiers_consulte',
        'libelle' => __("type d'habilitation"),
        'type' => 'select',
        'taille' => 30
    ),
    "om_validite_debut" => array(
        'colonne' => "om_validite_debut",
        'table' => 'habilitation_tiers_consulte',
        'libelle' => __("om_validite_debut"),
        'lib1'=> _("debut"),
        'lib2' => _("fin"),
        'type' => 'date',
        'taille' => 8,
        'where' => 'intervaldate',
    ),
    'om_validite_fin' => array(
        'colonne' => 'om_validite_fin',
        'table' => 'habilitation_tiers_consulte',
        'libelle' => __("om_validite_fin"),
        'lib1'=> _("debut"),
        'lib2' => _("fin"),
        'type' => 'date',
        'taille' => 8,
        'where' => 'intervaldate',
    ),
    'division_territoriales' => array(
        'colonne' => 'division_territoriales',
        'table' => 'habilitation_tiers_consulte',
        'libelle' => __("division_territoriales"),
        'type' => 'text',
        'taille' => 30,
        'max' => '',
    )
    
);

// advsearch -> options
$options[] =  array(
    'type' => 'search',
    'display' => true,
    'advanced' => $advsearch_fields,
    'absolute_object' => 'habilitation_tiers_consulte',
    'export' => array("csv"),
);

if ($f->get_submitted_get_value('mode') === 'export_csv') {

    $table .= sprintf(
        'LEFT JOIN
            %1$scategorie_tiers_consulte
            ON 
            categorie_tiers_consulte.categorie_tiers_consulte = tiers_consulte.categorie_tiers_consulte
        -- liste les specialite_tiers_consulte par habilitation sous la forme :
        --   code specialite - libelle specialite
        LEFT JOIN
            (SELECT
                habilitation_tiers_consulte,
                ARRAY_TO_STRING(ARRAY_AGG(CONCAT_WS(\' - \', specialite_tiers_consulte.code, specialite_tiers_consulte.libelle) ORDER BY specialite_tiers_consulte.specialite_tiers_consulte ASC), \', \') AS specialite_tiers_consulte
            FROM
                %1$slien_habilitation_tiers_consulte_specialite_tiers_consulte
                INNER JOIN %1$sspecialite_tiers_consulte
                    ON lien_habilitation_tiers_consulte_specialite_tiers_consulte.specialite_tiers_consulte = specialite_tiers_consulte.specialite_tiers_consulte
            GROUP BY
                habilitation_tiers_consulte) AS specialite_tiers_consulte_liste
            ON
                specialite_tiers_consulte_liste.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
        -- liste des utilisateurs par tiers consulté
        LEFT JOIN
            (SELECT
                tiers_consulte,
                ARRAY_TO_STRING(ARRAY_AGG(om_utilisateur.login ORDER BY lien_om_utilisateur_tiers_consulte.om_utilisateur ASC), \', \') AS om_utilisateur
            FROM
                %1$slien_om_utilisateur_tiers_consulte
                INNER JOIN %1$som_utilisateur
                    ON lien_om_utilisateur_tiers_consulte.om_utilisateur = om_utilisateur.om_utilisateur
            GROUP BY
                tiers_consulte) AS om_utilisateur_liste
            ON
                om_utilisateur_liste.tiers_consulte = tiers_consulte.tiers_consulte
        -- liste les communes de la Division territoire d\'\'intervention
        LEFT JOIN %1$slien_habilitation_tiers_consulte_commune
            ON lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
        LEFT JOIN %1$scommune
            ON commune.commune = lien_habilitation_tiers_consulte_commune.commune
        -- liste les départements de la Division territoire d\'\'intervention
        LEFT JOIN %1$slien_habilitation_tiers_consulte_departement
            ON lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte
        LEFT JOIN %1$sdepartement
            ON lien_habilitation_tiers_consulte_departement.departement = departement.departement
        ',
        DB_PREFIXE
    );

    // POur faciliter la lecture du code, on redéfinit tous les champs à afficher dans l'export
    // independemment de ceux qui ont servi à afficher les colonne du listing
    $champAffiche = array(
        'habilitation_tiers_consulte.habilitation_tiers_consulte as "'.__("habilitation_tiers_consulte").'"',
        'type_habilitation_tiers_consulte.libelle as "'.__("type_habilitation_tiers_consulte").'"',
        'habilitation_tiers_consulte.division_territoriales as "'.__("division_territoriales").'"',
        'CONCAT_WS(\' - \', commune.com, commune.libelle)
            AS "'.__("division territoriale d'intervention commune").'"',
        'CONCAT_WS(\' - \', departement.dep, departement.libelle)
            AS "'.__("division territoriale d'intervention departement").'"',
        'habilitation_tiers_consulte.texte_agrement as "'.__("texte d'agrement").'"',
        'specialite_tiers_consulte_liste.specialite_tiers_consulte as "'.__("specialite_tiers_consulte").'"',
        'to_char(habilitation_tiers_consulte.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
        'to_char(habilitation_tiers_consulte.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
        'tiers_consulte.libelle as "'.__("tiers_consulte").'"',
        'categorie_tiers_consulte.libelle as "'.__("categorie_tiers_consulte").'"',
        'tiers_consulte.abrege as "'.__("abrege").'"',
        'tiers_consulte.libelle as "'.__("libelle").'"',
        'tiers_consulte.adresse as "'.__("adresse").'"',
        'tiers_consulte.complement as "'.__("complément").'"',
        'tiers_consulte.cp as "'.__("code postal").'"',
        'tiers_consulte.ville as "'.__("ville").'"',
        'tiers_consulte.liste_diffusion as "'.__("liste de diffusion").'"',
        'CASE tiers_consulte.accepte_notification_email
            WHEN \'t\'
            THEN \'Oui\'
            ELSE \'NON\'
        END as "'.__("notification par email accepte").'"',
        'tiers_consulte.uid_platau_acteur as "'.__("UID acteur PLAT'AU").'"',
        'om_utilisateur_liste.om_utilisateur as '.__("om_utilisateur")
    );
}
