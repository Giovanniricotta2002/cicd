<?php
/**
 * Ce fichier permet de configurer le stockage des fichiers sur le filesystem
 *
 * @package openmairie_exemple
 * @version SVN : $Id: filestorage.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

/**
 *
 */
$filestorage = array();


$filestorage["filestorage-default"] = array (
    "storage" => "filesystem", // l'attribut storage est obligatoire
    "path" => "../var/filestorage/", // le repertoire de stockage
    "temporary" => array(
        "storage" => "filesystem", // l'attribut storage est obligatoire
        "path" => "../var/tmp/", // le repertoire de stockage
    ),
    "override_storage_matrix" => array (
        "task.uid_fichier" => "fs"
    ),
    "alternate_storage" => array(
        "fs" => array (
            "storage" => "filesystem",
            "path" => "../var/filestorage_plop",
        )
    )
);

?>