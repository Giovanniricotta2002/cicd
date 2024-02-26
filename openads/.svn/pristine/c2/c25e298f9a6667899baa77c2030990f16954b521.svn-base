<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_autorisation_type.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include "../gen/sql/pgsql/dossier_autorisation_type.inc.php";

//
$ent = _("parametrage dossiers")." -> "._("dossiers")." -> "._("type DA");

// SELECT 
$champAffiche = array(
    'dossier_autorisation_type.dossier_autorisation_type as "'._("id").'"',
    'dossier_autorisation_type.code as "'._("code").'"',
    'dossier_autorisation_type.libelle as "'._("libelle").'"',
    "case dossier_autorisation_type.confidentiel when 't' then 'Oui' else 'Non' end as \""._("confidentiel")."\"",
    'groupe.code as "'._("groupe").'"',
    'dossier_autorisation_type.affichage_form as "'._("affichage_form").'"',
    );
//
$champRecherche = array(
    'dossier_autorisation_type.dossier_autorisation_type as "'._("id").'"',
    'dossier_autorisation_type.code as "'._("code").'"',
    'dossier_autorisation_type.libelle as "'._("libelle").'"',
    'groupe.code as "'._("groupe").'"',
    'dossier_autorisation_type.affichage_form as "'._("affichage_form").'"',
    );
//
$tri="ORDER BY dossier_autorisation_type.libelle ASC NULLS LAST";

//
$sousformulaire = array(
    'dossier_autorisation_type_detaille',
);

?>
