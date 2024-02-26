<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: instruction.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

//
include "../gen/sql/pgsql/instruction.inc.php";

// =======================================================
// href special edition instruction
// =======================================================
$table=DB_PREFIXE."instruction inner join ".DB_PREFIXE."evenement on instruction.evenement=evenement.evenement 
    LEFT JOIN ".DB_PREFIXE."signataire_arrete 
        ON instruction.signataire_arrete=signataire_arrete.signataire_arrete
    LEFT JOIN ".DB_PREFIXE."dossier
        ON instruction.dossier = dossier.dossier
    LEFT JOIN ".DB_PREFIXE."etat
        ON instruction.etat = etat.etat";

$champAffiche = array(
    "instruction as no",
    "evenement.libelle",
    "to_char(date_evenement ,'DD/MM/YYYY') as \""._("date_evenement")."\"",
    "etat.libelle as \""._("etat")."\"",
    "instruction.lettretype",
    "(CASE WHEN (instruction.om_final_instruction_utilisateur IS NULL
                OR length(trim(instruction.om_final_instruction_utilisateur)) = 0)
            AND (dossier.log_instructions IS NULL
                OR length(trim(dossier.log_instructions)) > 0)
        THEN
            (SELECT DISTINCT
                U.login || ' (' || U.nom || ')'
            FROM
                (SELECT
                    J.value::json->>'user' AS login
                FROM
                    json_array_elements(dossier.log_instructions::json) AS J
                WHERE
                    (J.value::json->'values'->>'instruction')::int = instruction.instruction
                LIMIT 1) AS L
            INNER JOIN ".DB_PREFIXE."om_utilisateur AS U
                ON U.login = L.login)
        ELSE
            instruction.om_final_instruction_utilisateur
    END) AS \"".__("finalise par").'/'.__("cree par")."\"",
    "signataire_arrete.nom as \"".__("signataire_arrete")."\"",
);

$champRecherche=array(
    "evenement.libelle",
    );
$tri= " order by date_evenement asc, instruction asc ";

// Gestion particulière de l'affichage du listing dans le contexte d'un dossier
// d'instruction.
include "../sql/pgsql/dossier_instruction_droit_specifique_par_division.inc.php";
// Gestion des groupes et confidentialité
include('../sql/pgsql/filter_group.inc.php');
