<?php
//$Id: demandeur.inc.php 4475 2015-03-31 17:24:25Z stimezouaght $ 
//gen openMairie le 08/11/2012 14:59

include('../gen/sql/pgsql/demandeur.inc.php');

//
$case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
THEN TRIM(CONCAT(civilite1.libelle, ' ', demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
END";

//
$case_adresse = "TRIM(CONCAT(demandeur.numero,' ',
demandeur.voie,' ',
demandeur.code_postal,' ',
demandeur.localite))";

//
$sousformulaire = array();

?>