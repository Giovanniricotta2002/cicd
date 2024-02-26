<?php
/**
 * Ce fichier est le point d'entrée pour les requêtes REST dans l'application.
 *
 * @package openads
 * @version SVN : $Id$
 */

// Inclusion de la librairie restler
require_once "../services/php/restler/restler/restler.php";

// Instanciation de restler
$r = new Restler();

//Déclaration de la ressource de test 'referentielpatrimoinetest'
require_once('./referentiel_erp_test.php');
$r->addAPIClass('referentiel_erp_test');

//Déclaration de la ressource de test 'trouillotage_service_test'
require_once('./trouillotage_service_test.php');
$r->addAPIClass('trouillotage_service_test');

//Déclaration de la classe 'demande_api' qui met à disposition la ressource de test 'demande'
require_once('./REST/demande_api.php');
// Le second paramètre permet de surcharger le nom de la ressource fourni dans l'URL, qui 
// aurait été par défaut "demande_api"
$r->addAPIClass('demande_api', 'demande');

// aurait été par défaut "demande_api"
require_once('./REST/task_api.php');
$r->addAPIClass('task_api', 'taskadd');

//
$r->setSupportedFormats('JsonFormat', 'XmlFormat');

// Exécution de l'API
$r->handle();

?>
