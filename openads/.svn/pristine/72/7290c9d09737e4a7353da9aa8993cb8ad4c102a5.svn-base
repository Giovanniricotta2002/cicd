<?php
//
include "../sql/pgsql/architecte.inc.php";

//
$ent = _("instruction")." -> "._("qualification")." -> "._("architecte_frequent");

// SELECT 
$champAffiche = array(
    'architecte.architecte as "'._("id").'"',
    $concat_nom_prenom.' as "'._("nom").'"',
    $concat_adresse.' as "'._("adresse").'"',
    'architecte.inscription as "'._("inscription").'"',
);

//
$selection = "WHERE architecte.frequent='t' ";

?>
