<?php
//$Id$ 
//gen openMairie le 19/08/2021 15:39

include PATH_OPENMAIRIE."sql/pgsql/om_parametre.inc.php";

if (isset($_GET['tab_serie']) && is_numeric($_GET['tab_serie']) && $_GET['tab_serie'] >= 1) {
    $serie = intval($_GET['tab_serie']);
}
