<?php
/**
 *
 *
 * @package framework_openmairie
 * @version SVN : $Id: om_logo.inc.php 4348 2018-07-20 16:49:26Z softime $
 */

//
if (file_exists("../gen/sql/pgsql/om_logo.inc.php")) {
    include "../gen/sql/pgsql/om_logo.inc.php";
} else {
    include PATH_OPENMAIRIE."gen/sql/pgsql/om_logo.inc.php";
}

//
$champAffiche = array(
    'om_logo.om_logo as "'.__("om_logo").'"',
    'om_logo.id as "'.__("id").'"',
    'om_logo.libelle as "'.__("libelle").'"',
    'om_logo.description as "'.__("description").'"',
    'om_logo.fichier as "'.__("fichier").'"',
    'om_logo.resolution as "'.__("resolution").'"',
    "case om_logo.actif when 't' then 'Oui' else 'Non' end as \"".__("actif")."\"",
    'om_collectivite.niveau as "'.__("niveau").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
$champRecherche = array(
    'om_logo.om_logo as "'.__("om_logo").'"',
    'om_logo.id as "'.__("id").'"',
    'om_logo.libelle as "'.__("libelle").'"',
    'om_logo.description as "'.__("description").'"',
    'om_logo.resolution as "'.__("resolution").'"',
    'om_collectivite.niveau as "'.__("niveau").'"',
    );
//
if ($_SESSION['niveau'] == '2') {
    array_push($champRecherche, "om_collectivite.libelle as \"".__("collectivite")."\"");
}
//
if ($_SESSION['niveau'] == '2') {
    $selection = "";
} else {
    $selection = " where (".$obj.".om_collectivite='".$_SESSION['collectivite']."' or niveau='2')";
}
