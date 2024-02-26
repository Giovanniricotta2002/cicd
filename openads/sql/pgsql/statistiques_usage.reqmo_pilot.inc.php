<?php
// Filtre des requêtes de group pour les reqmo
include ('../sql/pgsql/filter_group_reqmo.inc.php');

// Libellé de la requête
$reqmo['libelle']=_("Statistiques évoluées destinées à permettre la refacturation du service mutualisé d'instruction aux communes concernées");

// Choix des critères de tri
$reqmo['date_depot_debut'] = "../../....";
$reqmo['date_depot_fin'] = "../../....";
$reqmo['date_decision_debut'] = "../../....";
$reqmo['date_decision_fin'] = "../../....";

// Type attendu pour les données
$reqmo['type']['date_depot_debut'] = 'date';
$reqmo['type']['date_depot_fin'] = 'date';
$reqmo['type']['date_decision_debut'] = 'date';
$reqmo['type']['date_decision_fin'] = 'date';
$reqmo['type']['tri'] = 'string';

// Critères obligatoires
$reqmo['required'] = array(
    'date_depot_debut' => false,
    'date_depot_fin' => false,
    'date_decision_debut' => false,
    'date_decision_fin' => false,
);

// Critères par défaut
$date_defaut_debut = '01/01/1900';
$date_defaut_fin = '01/01/2100';
$reqmo['default'] = array(
    'date_depot_debut' => $date_defaut_debut,
    'date_depot_fin' => $date_defaut_fin,
    'date_decision_debut' => $date_defaut_debut,
    'date_decision_fin' => $date_defaut_fin,
);

// Conditions à supprimer
$reqmo['conditions_to_delete'] = array(
    "AND dossier.date_depot >= '".$date_defaut_debut."' AND dossier.date_depot <= '".$date_defaut_fin."'",
    "AND dossier.date_decision >= '".$date_defaut_debut."' AND dossier.date_decision <= '".$date_defaut_fin."'",
);

// Tri
$reqmo['tri']= array('dossier.dossier');

// Requête
$reqmo['sql']="
SELECT
    dossier.dossier as \"référence dossier instruction\",
    dossier_autorisation.dossier_autorisation as \"référence dossier autorisation\",
    om_collectivite.libelle as \"commune\",
    division_dossier.libelle as \"division dossier\",
    dossier_autorisation_type_detaille.code as \"code type DA détaillé\",
    dossier_autorisation_type_detaille.libelle as \"libellé type DA détaillé\",
    dossier_instruction_type.code as \"code type DI\",
    dossier_instruction_type.libelle as \"libellé type DI\",
    instructeur.instructeur as \"identifiant instructeur\",
    instructeur.nom as \"nom instructeur\",
    division_instructeur.libelle as \"division instructeur\",
    direction_instructeur.libelle as \"direction instructeur\",
    to_char(dossier.date_depot ,'DD/MM/YYYY') as \"date dépôt initial\",
    to_char(dossier.date_limite ,'DD/MM/YYYY') as \"date limite instruction\",
    to_char(dossier.date_decision ,'DD/MM/YYYY') as \"date décision\",
    etat.libelle as \"état DI\",
    count_instruction.nb_instruction as \"total instructions\",
    count_consultation.nb_consultation as \"total consultations\",
    dossier.tax_mtn_part_commu as \"simulation taxes part communale\",
    dossier.tax_mtn_part_depart as \"simulation taxes part départementale\",
    dossier.tax_mtn_total as \"simulation taxes total\",
    TRIM(CONCAT(
        donnees_techniques.co_projet_desc, ' ',
        donnees_techniques.am_projet_desc, ' ',
        donnees_techniques.dm_projet_desc, ' ',
        donnees_techniques.ope_proj_desc
        )) as \"description du projet\"

FROM ".DB_PREFIXE."dossier
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation
        ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
        ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
    INNER JOIN ".DB_PREFIXE."dossier_autorisation_type
        ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        AND LOWER(dossier_autorisation_type.affichage_form) = 'ads'
    INNER JOIN ".DB_PREFIXE."groupe
        ON dossier_autorisation_type.groupe = groupe.groupe
        ".$selection."
    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type
        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
    LEFT JOIN ".DB_PREFIXE."instructeur
        ON instructeur.instructeur = dossier.instructeur
    LEFT JOIN ".DB_PREFIXE."division as division_instructeur
        ON division_instructeur.division = instructeur.division
    LEFT JOIN ".DB_PREFIXE."division as division_dossier
        ON division_dossier.division = dossier.division
    LEFT JOIN ".DB_PREFIXE."direction as direction_instructeur
        ON direction_instructeur.direction = division_instructeur.direction
    LEFT JOIN ".DB_PREFIXE."direction as direction_dossier
        ON direction_dossier.direction = division_dossier.direction
    LEFT JOIN ".DB_PREFIXE."etat
        ON dossier.etat = etat.etat
    LEFT JOIN ".DB_PREFIXE."om_collectivite
        ON dossier.om_collectivite = om_collectivite.om_collectivite
    LEFT JOIN (
        SELECT dossier, count(*) AS nb_instruction
        FROM ".DB_PREFIXE."instruction
        GROUP BY dossier
    ) count_instruction ON count_instruction.dossier = dossier.dossier
    LEFT JOIN (
        SELECT dossier, count(*) AS nb_consultation
        FROM ".DB_PREFIXE."consultation
        GROUP BY dossier
    ) count_consultation ON count_consultation.dossier = dossier.dossier

    LEFT JOIN " . DB_PREFIXE . "donnees_techniques
        ON dossier.dossier = donnees_techniques.dossier_instruction
WHERE
    dossier.om_collectivite IN (<idx_collectivite>)
    AND dossier.date_depot >= '[date_depot_debut]' AND dossier.date_depot <= '[date_depot_fin]'
    AND dossier.date_decision >= '[date_decision_debut]' AND dossier.date_decision <= '[date_decision_fin]'".
    $sqlFiltreSD.
"ORDER BY dossier.dossier ASC";

?>
