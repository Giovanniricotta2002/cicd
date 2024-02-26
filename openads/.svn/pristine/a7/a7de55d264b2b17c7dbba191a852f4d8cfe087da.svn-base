<?php
//$Id: commission.inc.php 4418 2015-02-24 17:30:28Z tbenita $ 
//gen openMairie le 07/12/2012 17:33

include('../gen/sql/pgsql/commission.inc.php');

$ent = _("suivi")." -> "._("commissions")." -> "._("gestion");


//Suppression de l'onglet inutile
$sousformulaire = array();

$tri="ORDER BY commission.date_commission DESC NULLS LAST";

$champAffiche = array(
    'commission.commission as "'._("commission").'"',
    'commission.code as "'._("code").'"',
    'commission_type.libelle as "'._("commission_type").'"',
    'commission.libelle as "'._("libelle").'"',
    'to_char(commission.date_commission ,\'DD/MM/YYYY\') as "'._("date_commission").'"',
    'commission.heure_commission as "'._("heure_commission").'"',
    'commission.lieu_adresse_ligne1 as "'._("lieu_adresse_ligne1").'"',
    'commission.lieu_adresse_ligne2 as "'._("lieu_adresse_ligne2").'"',
    'commission.lieu_salle as "'._("lieu_salle").'"',
);

// Si la collectivité de l'utilisateur est de niveau multi
// alors on ajoute pas la colonne collectivité
if ($f->isCollectiviteMono($_SESSION['collectivite']) === false) {
    $champAffiche[] = 'om_collectivite.libelle as "'._("collectivite").'"';
}

?>
