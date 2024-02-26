<?php
//$Id: demande_avis_passee.inc.php 4418 2015-02-24 17:30:28Z tbenita $ 
//gen openMairie le 18/10/2012 16:21
include('demande_avis.inc.php');
$ent = _("Demandes d'avis")." -> "._("passees");
$tab_title = _("Demandes d'avis passées");

$selection=' WHERE (consultation.avis_consultation IS NOT NULL
OR consultation.date_limite < current_date)
AND om_utilisateur.login=\''.$_SESSION['login'].'\'';

// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];
?>