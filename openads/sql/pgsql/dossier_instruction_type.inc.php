<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_instruction_type.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include "../gen/sql/pgsql/dossier_instruction_type.inc.php";

//
$ent = _("parametrage dossiers")." -> "._("dossiers")." -> "._("type DI");

// SELECT 
$champAffiche = array(
    'dossier_instruction_type.dossier_instruction_type as "'._("id").'"',
    //"(dossier_autorisation_type_detaille.code||' - '||dossier_instruction_type.libelle) as \""._("dossier_instruction_type")."\"",

    'dossier_instruction_type.code as "'._("code").'"',
    'dossier_instruction_type.libelle as "'._("libelle").'"',
    "(dossier_autorisation_type_detaille.code||' ('||dossier_autorisation_type_detaille.libelle||')') as \""._("dossier_autorisation_type_detaille")."\"",
    );
//
$champNonAffiche = array(
    'dossier_instruction_type.description as "'._("description").'"',
    );
//
$champRecherche = array(
    "(dossier_autorisation_type_detaille.code||' - '||dossier_instruction_type.libelle) as \""._("dossier_instruction_type")."\"",
    'dossier_instruction_type.code as "'._("code").'"',
    'dossier_instruction_type.libelle as "'._("libelle").'"',
    "(dossier_autorisation_type_detaille.code||' ('||dossier_autorisation_type_detaille.libelle||')') as \""._("dossier_autorisation_type_detaille")."\"",
    );
$tri="ORDER BY dossier_autorisation_type_detaille.code, dossier_instruction_type.code ASC NULLS LAST";

$sousformulaire = array(
    'demande_type',
);

?>
