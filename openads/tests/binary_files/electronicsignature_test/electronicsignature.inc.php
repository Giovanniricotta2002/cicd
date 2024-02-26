<?php
/**
 * 
 */

//
$conf = array();

//
$conf["electronicsignature-default"] = array (
    "unexpected_collectivite" => array(),
    "1" => array(
        'connector' => 'test',
        'path' => '../tests/binary_files/electronicsignature_test/',
        'api_key' => 'test',
        'url_base' => 'https://localhost/',
        'id_document_type' => 1,
        'id_signature_page' => 2,
        'debug' => false,
        'insecure' => false,
        "is_forced_view_files" => null,
        "cancel_send" => false
    ),
);

?>
