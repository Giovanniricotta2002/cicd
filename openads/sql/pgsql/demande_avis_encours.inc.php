<?php
//$Id: demande_avis_encours.inc.php 4418 2015-02-24 17:30:28Z tbenita $ 
//gen openMairie le 18/10/2012 16:21
include('demande_avis.inc.php');
$ent = _("Demandes d'avis")." -> "._("en cours");
$tab_title = _("Demandes d'avis en cours");

//
$case_marque = "
CASE
    consultation.marque
WHEN
    't'
THEN
    '<span class=\"om-prev-icon om-icon-16 om-icon-fix marque-16\" title=\""._('Oui')."\"> </span>'
END";
array_push($champAffiche, $case_marque." as \""._("marqué")."\"");

// Supprime la colonne de l'avis rendu sur le listing ainsi que dans la
// recherche simple
unset($champAffiche[array_search($avis_rendu, $champAffiche)]);
unset($champRecherche[array_search($avis_rendu, $champRecherche)]);

$selection=' WHERE consultation.date_limite >= current_date
AND consultation.avis_consultation IS NULL
AND om_utilisateur.login=\''.$_SESSION['login'].'\'';
$tri="ORDER BY consultation.marque DESC, consultation.date_limite::date ASC, consultation.consultation";

// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];
?>