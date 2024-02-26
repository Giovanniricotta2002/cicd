<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: document_instruction.inc.php 4418 2021-07-30 15:40:00Z cgarcin $
 */

//
include "../sql/pgsql/instruction.inc.php";

$options[] = array(
    'type' => "pagination",
    'display' => false
);
$tab_actions['content']['lien'] = null;
$tab_actions['corner']['ajouter'] = null;
$tab_actions['left']['consulter'] = null;
$tab_actions['left']['previsualiser'] = array(
    'lien' => ''.OM_ROUTE_SOUSFORM.'&obj='.$obj.'&amp;action=401&amp;idxformulaire='.$idxformulaire.'&amp;idx=',
    'id' => '&amp;tri='.$tricolsf.'&amp;objsf='.$obj.'&amp;premiersf='.$premier.'&amp;retourformulaire='.$retourformulaire.'&amp;idxformulaire='.$idxformulaire.'&amp;trisf='.$tricolsf.'&amp;retour=tab',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix preview-16" title="Prévisualiser">
                Prévisualiser
            </span>',
    'rights' => array('list' => array($obj, $obj . '_previsualiser'), 'operator' => 'OR'),
    'ordre' => 100,
    'ajax' => false
);

// Action sur la deuxième colonne de contenu
$tab_actions['specific_content'][1] = array(
    'lien' => OM_ROUTE_FORM.'&amp;snippet=file&amp;obj=instruction&amp;champ=om_fichier_instruction&amp;id=',
    'id' => '" target="_blank',
    'rights' => array('list' => array($obj, $obj.'_tab'), 'operator' => 'OR'),
    'ordre' => 10,
    'ajax' => false,
    'condition' => array(
        "document_numerise",
        "document_numerise_uid_telecharger"
    )
);

$table .= sprintf('
    INNER JOIN %1$som_lettretype
        ON om_lettretype.id = instruction.lettretype
    INNER JOIN %1$som_collectivite
        ON om_lettretype.om_collectivite = om_collectivite.om_collectivite',
    DB_PREFIXE
);

$champAffiche=array(
    "instruction.instruction as \""._("id")."\"",
    "CONCAT(
        '<span class=\"om-prev-icon reqmo-16\" title=\"Télécharger\">',
        'instruction_',
        instruction.instruction,
        '</span>'
    ) as \""._("nom du fichier")."\"",
    "om_lettretype.libelle as type",
    "to_char(instruction.date_finalisation_courrier ,'DD/MM/YYYY') as \""._("date de finalisation")."\"",
    "to_char(instruction.date_retour_rar ,'DD/MM/YYYY') as \""._("date de notification")."\"",
);

$selection = "WHERE instruction.om_fichier_instruction is not null";
// Filtre listing sous formulaire - dossier_instruction
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (instruction.dossier = '".$f->db->escapeSimple($idxformulaire)."') 
        AND instruction.om_fichier_instruction is not null";
}
$selection .= sprintf(
    ' AND om_lettretype.actif IS TRUE
    -- Récupère les lettretypes lié à la collectivité du dossier ou à la collectivité
    -- de niveau 2 si il n existe pas de lettretype du même id lié à la collectivité
    -- du dossier
    AND (om_collectivite.om_collectivite = dossier.om_collectivite
            OR (om_collectivite.niveau = \'2\'
                AND NOT EXISTS (
                    SELECT
                        other_lettretype.om_lettretype
                    FROM
                        %1$som_lettretype AS other_lettretype
                        JOIN %1$som_collectivite
                            ON other_lettretype.om_collectivite = om_collectivite.om_collectivite
                    WHERE
                        om_lettretype.id = other_lettretype.id
                        AND om_collectivite.om_collectivite = dossier.om_collectivite
                )))',
    DB_PREFIXE
);

$champRecherche = array(
    "instruction.instruction as \""._("nom du fichier")."\"",
    "instruction.lettretype as type",
    "instruction.date_finalisation_courrier as \""._("date de finalisation")."\"",
    "instruction.date_retour_rar as \""._("date de notification")."\"",
);
