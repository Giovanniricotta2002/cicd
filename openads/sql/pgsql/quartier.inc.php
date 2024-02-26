<?php
//$Id: quartier.inc.php 4939 2015-07-22 16:38:06Z nmeucci $ 
//gen openMairie le 30/10/2012 12:32

include('../gen/sql/pgsql/quartier.inc.php');
$ent = _("parametrage")." -> "._("quartier");

// Supprime le sous-formulaire dossier
$sousformulaire = array(
    'affectation_automatique',
);

?>
