<?php
//$Id$ 
//gen openMairie le 03/11/2016 12:44

include "../gen/sql/pgsql/lien_om_utilisateur_groupe.inc.php";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "groupe" => array("groupe", ),
);
// Filtre listing sous formulaire - groupe
if ($retourformulaire == "om_utilisateur") {
    $champAffiche = array(
        'lien_om_utilisateur_groupe.lien_om_utilisateur_groupe as "'._("lien_om_utilisateur_groupe").'"',
        'groupe.libelle as "'._("groupe").'"',
        "case lien_om_utilisateur_groupe.confidentiel when 't' then 'Oui' else 'Non' end as \""._("confidentiel")."\"",
        "case lien_om_utilisateur_groupe.enregistrement_demande when 't' then 'Oui' else 'Non' end as \""._("enregistrement_demande")."\"",
    );
    $table = DB_PREFIXE."lien_om_utilisateur_groupe
        JOIN ".DB_PREFIXE."om_utilisateur ON
            lien_om_utilisateur_groupe.login=om_utilisateur.login AND om_utilisateur.om_utilisateur=".intval($idxformulaire)."
        JOIN ".DB_PREFIXE."groupe 
            ON lien_om_utilisateur_groupe.groupe=groupe.groupe ";

}
