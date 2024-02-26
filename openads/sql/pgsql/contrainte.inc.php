<?php
//$Id: contrainte.inc.php 5213 2015-09-24 14:31:59Z stimezouaght $ 
//gen openMairie le 03/01/2014 16:53

include('../gen/sql/pgsql/contrainte.inc.php');

// Fil d'Ariane
$ent = _("parametrage dossiers")." -> "._("dossiers")." -> "._("contrainte");

// SELECT
$champAffiche = array(
    'contrainte.contrainte as "'._("contrainte").'"',
    'contrainte.libelle as "'._("libelle").'"',
    'contrainte.nature as "'._("nature").'"',
    'contrainte.groupe as "'._("groupe").'"',
    'contrainte.sousgroupe as "'._("sousgroupe").'"',
    "case contrainte.reference when 't' then 'Oui' else 'Non' end as \""._("reference")."\"",
    'to_char(contrainte.om_validite_debut ,\'DD/MM/YYYY\') as "'._("om_validite_debut").'"',
    'to_char(contrainte.om_validite_fin ,\'DD/MM/YYYY\') as "'._("om_validite_fin").'"',
);

//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \""._("collectivite")."\"");
}

// Supprime les sous-formulaires
$sousformulaire = array();

?>