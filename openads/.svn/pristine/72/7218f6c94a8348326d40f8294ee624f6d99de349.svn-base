<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_message.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

//
include "../gen/sql/pgsql/dossier_message.inc.php";

// FROM
$table .= "
LEFT JOIN ".DB_PREFIXE."instructeur 
    ON instructeur.instructeur=dossier.instructeur
LEFT JOIN ".DB_PREFIXE."om_utilisateur
    ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
LEFT JOIN ".DB_PREFIXE."division 
    ON dossier.division=division.division";

// Tri par date
$tri = "order by date_emission desc, lu";

// SELECT
$champAffiche = array(
    'dossier_message.dossier_message as "'._("dossier_message").'"',
    'dossier_message.dossier as "'._("dossier").'"',
    'to_char(dossier_message.date_emission ,\'DD/MM/YYYY HH24:MI:SS\') as "'._("date_emission").'"',
    'dossier_message.type as "'._("type").'"',
    'dossier_message.emetteur as "'._("emetteur").'"',
    'dossier_message.destinataire as "'._("destinataire").'"',
    'instructeur.nom as "'._("instructeur").'"',
    'division.code as "'._("division").'"',
    "case dossier_message.lu when 't' then 'Oui' else 'Non' end as \""._("lu")."\"",
    );

/**
 * Gestion de l'affichage dans le contexte du dossier
 */
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    // SELECT
    $champAffiche = array(
        'dossier_message.dossier_message as "'._("id").'"',
        'to_char(dossier_message.date_emission ,\'DD/MM/YYYY\') as "'._("date_emission").'"',
        'to_char(dossier_message.date_emission ,\'HH24:MI:SS\') as "'._("heure_emission").'"',
        'dossier_message.type as "'._("type").'"',
        'dossier_message.emetteur as "'._("emetteur").'"',
        'dossier_message.destinataire as "'._("destinataire").'"',
        "case dossier_message.lu when 't' then 'Oui' else 'Non' end as \""._("lu")."\"",
        );
}

/**
 * Options
 */
// On affiche le champ lu en gras
$options[] = array(
    "type" => "condition",
    "field" => "case dossier_message.lu when 't' then 'Oui' else 'Non' end",
    "case" => array(
            "0" => array(
                "values" => array("Non", ),
                "style" => "non_lu",
                ),
            ),
);


// Gestion particulière de l'affichage du listing dans le contexte d'un dossier
// d'instruction
include "../sql/pgsql/dossier_instruction_droit_specifique_par_division.inc.php";
// Gestion des groupes et confidentialité
include('../sql/pgsql/filter_group.inc.php');
