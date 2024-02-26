<?php
//$Id: service.inc.php 4651 2015-04-26 09:15:48Z tbenita $ 
//gen openMairie le 10/02/2011 20:36 
include('../gen/sql/pgsql/service.inc.php');
$ent = _("parametrage")." -> "._("gestion des consultations")." -> "._("service");
$champAffiche = array(
    'service.service as "'._("service").'"',
    'service.abrege as "'._("abrege").'"',
    'service.libelle as "'._("libelle").'"',
    'CONCAT_WS(\' \', service.adresse, service.adresse2, service.cp, service.ville)  as "'._("adresse").'"',
    'service.delai as "'._("delai").'"',
    "case service.consultation_papier when 't' then 'Oui' else 'Non' end as \""._("consultation_papier")."\"",
    "case service.notification_email when 't' then 'Oui' else 'Non' end as \""._("notification_email")."\"",
    'service.type_consultation as "'._("type_consultation").'"',
    'om_etat.libelle as "'._("edition").'"',
    'service_type as "'.__("service_type").'"',
    );

?>
