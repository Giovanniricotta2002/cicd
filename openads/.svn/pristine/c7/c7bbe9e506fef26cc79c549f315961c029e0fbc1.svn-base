<?php
//$Id: donnees_techniques.inc.php 4418 2015-02-24 17:30:28Z tbenita $ 
//gen openMairie le 13/02/2013 14:41

include('../gen/sql/pgsql/donnees_techniques.inc.php');

$ent = __("Données techniques / CERFA");

$champAffiche = array(
    'donnees_techniques.donnees_techniques as "'._("donnees_techniques_cerfa").'"',
    'dossier.dossier as "'._("dossier_instruction").'"',
    'lot.libelle as "'._("lot").'"',
    "case donnees_techniques.am_lotiss when 't' then 'Oui' else 'Non' end as \""._("am_lotiss")."\"",
    "case donnees_techniques.am_autre_div when 't' then 'Oui' else 'Non' end as \""._("am_autre_div")."\"",
    );

?>
