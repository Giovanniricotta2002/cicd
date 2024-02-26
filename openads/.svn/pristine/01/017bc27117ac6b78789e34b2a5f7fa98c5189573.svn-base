<?php
/**
 * Ce script permet d'interfacer le traitement d'import de données dans la base
 * de données à partir de fichiers CSV.
 *
 * @package openmairie_exemple
 * @version SVN : $Id: import_specific.php 4806 2015-06-04 09:57:44Z nhaye $
 */

//
require_once "../obj/utils.class.php";
$f = new utils(
    "nohtml",
    "import",
    __("administration")." -> ".__("Import spécifique")
);

/**
 * 
 */
//
require_once "../obj/import_specific.class.php";
$i = new import_specific();
//
$i->view_import();

?>
