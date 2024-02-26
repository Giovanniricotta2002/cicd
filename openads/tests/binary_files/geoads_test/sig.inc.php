<?php
/**
 * Ce fichier permet de paramétrer la connexion au SIG pour les tests du connecteur
 * générique.
 * Il définit donc une connexion par le biais du connecteur générique en utilisant le 
 * web service de test.
 */

/**
 *
 */
$conf = array();

$conf["sig-default"] = array (
    "sig_treatment_mod" => "multi", // "mono|multi"
    "1" => array(
        'connector' => 'test',
        'path' => '../tests/binary_files/geoads_test/',
        'login' => 'sig',
        'password' => 'sig',
        'url_ws' => 'https://localhost/',
        'url_web' => 'http://localhost/',
        'sig_referentiel' => 2154,
    ),
);

?>