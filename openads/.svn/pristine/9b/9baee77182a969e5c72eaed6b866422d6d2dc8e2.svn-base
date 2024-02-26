<?php
//$Id$ 
//gen openMairie le 03/11/2016 12:44

include "../gen/sql/pgsql/lien_om_profil_groupe.inc.php";

if ($retourformulaire == "om_profil") {
    $champAffiche = array(
        'lien_om_profil_groupe.lien_om_profil_groupe as "'._("lien_om_profil_groupe").'"',
        'groupe.libelle as "'._("groupe").'"',
        "case lien_om_profil_groupe.confidentiel when 't' then 'Oui' else 'Non' end as \""._("confidentiel")."\"",
        "case lien_om_profil_groupe.enregistrement_demande when 't' then 'Oui' else 'Non' end as \""._("enregistrement_demande")."\"",
    );
}


?>
