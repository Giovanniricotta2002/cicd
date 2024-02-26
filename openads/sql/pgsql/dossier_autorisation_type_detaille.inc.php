<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_autorisation_type_detaille.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include "../gen/sql/pgsql/dossier_autorisation_type_detaille.inc.php";

//
$ent = _("parametrage dossiers")." -> "._("dossiers")." -> "._("type DA detaille");

// SELECT 
$champAffiche = array(
    'dossier_autorisation_type_detaille.dossier_autorisation_type_detaille as "'._("id").'"',
    'dossier_autorisation_type_detaille.code as "'._("code").'"',
    'dossier_autorisation_type_detaille.libelle as "'._("libelle").'"',
    "(dossier_autorisation_type.code||' ('||dossier_autorisation_type.libelle||')') as \""._("dossier_autorisation_type")."\"",
    'cerfa0.libelle as "'._("cerfa").'"',
    );
//
$champRecherche = array(
    'dossier_autorisation_type_detaille.dossier_autorisation_type_detaille as "'._("id").'"',
    'dossier_autorisation_type_detaille.code as "'._("code").'"',
    'dossier_autorisation_type_detaille.libelle as "'._("libelle").'"',
    "(dossier_autorisation_type.code||' ('||dossier_autorisation_type.libelle||')') as \""._("dossier_autorisation_type")."\"",
    'cerfa0.libelle as "'._("cerfa").'"',
    );
$tri="ORDER BY dossier_autorisation_type_detaille.libelle ASC NULLS LAST";

$sousformulaire = array(
    'dossier_instruction_type',);


// si en sous-formulaire cerfa alors on cache le bouton ajouter
if (isset($retourformulaire) && $retourformulaire === 'cerfa') {
    // Actions en coin : ajouter
    $tab_actions['corner']['ajouter'] = NULL;
}


?>
