<?php
/**
 * OM_COLLECTIVITE - Surcharge du core
 *
 * @package openads
 * @version SVN : $Id$
 */

//
include PATH_OPENMAIRIE."sql/pgsql/om_collectivite.inc.php";
// Renomme "collectivité" en "service" si l'option est activée
$om_collectivite_libelle = __("om_collectivite");
if ($f->is_option_renommer_collectivite_enabled() === true) {
    $om_collectivite_libelle = __("service");
}
$ent = __("administration")." -> ".$om_collectivite_libelle;


?>
