<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: demande_type.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include "../gen/sql/pgsql/demande_type.inc.php";

//
$ent = _("parametrage dossiers")." -> "._("demandes")." -> "._("type");

//
$retourformulaire = (isset($_GET['retourformulaire'])) ? $_GET['retourformulaire'] : "";

// SELECT 
$champAffiche = array(
    'demande_type.demande_type as "'._("id").'"',
    'demande_type.code as "'._("code").'"',
    'demande_type.libelle as "'._("libelle").'"',
    "demande_nature.code as \""._("demande_nature")."\"",
    "(dossier_autorisation_type_detaille.code||' - '||dossier_instruction_type.libelle) as \""._("dossier_instruction_type")."\"",
    'groupe.code as "'._("groupe").'"',

    );
//
$champRecherche = array(
    'demande_type.demande_type as "'._("id").'"',
    'demande_type.code as "'._("code").'"',
    'demande_type.libelle as "'._("libelle").'"',
    'demande_nature.libelle as "'._("demande_nature").'"',
    'groupe.libelle as "'._("groupe").'"',
    "(dossier_autorisation_type_detaille.code||' - '||dossier_instruction_type.libelle) as \""._("dossier_instruction_type")."\"",
    );

//
$tri = "ORDER BY (dossier_autorisation_type_detaille.code||' - '||dossier_instruction_type.libelle), demande_nature.libelle DESC, demande_type.code ASC NULLS LAST";

//
$sousformulaire = array(
);

// si en sous-formulaire alors on cache le bouton ajouter
// pour éviter un bug sur le multiselect
if (isset($retourformulaire) && $retourformulaire != '') {
    // Actions en coin : ajouter
    $tab_actions['corner']['ajouter'] = NULL;
}

?>
