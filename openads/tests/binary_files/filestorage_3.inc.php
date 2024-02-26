<?php
$filestorage = array();


$filestorage["filestorage-default"] = array (
    "storage" => "filesystem", // l'attribut storage est obligatoire
    "path" => "../var/filestorage_test/", // le repertoire de stockage
    "temporary" => array(
        "storage" => "filesystem", // l'attribut storage est obligatoire
        "path" => "../var/tmp/", // le repertoire de stockage
    ),
);

?>
