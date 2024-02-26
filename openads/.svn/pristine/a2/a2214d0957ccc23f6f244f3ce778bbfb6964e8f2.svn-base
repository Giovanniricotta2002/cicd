<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: cerfa.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include "../gen/sql/pgsql/cerfa.inc.php";

//
$ent = _("parametrage dossiers")." -> "._("dossiers")." -> "._("cerfa");

// SELECT 
$champAffiche = array(
    'cerfa.cerfa as "'._("cerfa").'"',
    'cerfa.code as "'._("code").'"',
    'cerfa.libelle as "'._("libelle").'"',
    'to_char(cerfa.om_validite_debut ,\'DD/MM/YYYY\') as "'._("om_validite_debut").'"',
    'to_char(cerfa.om_validite_fin ,\'DD/MM/YYYY\') as "'._("om_validite_fin").'"',
    );

?>
