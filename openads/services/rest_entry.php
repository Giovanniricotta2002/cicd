<?php
/**
 * Ce fichier est le point d'entrée pour les requêtes REST dans l'application.
 *
 * @package openads
 * @version SVN : $Id: rest_entry.php 5782 2016-01-20 13:45:14Z jymadier $
 */

// Log - services.log
require_once "../obj/utils.class.php";
$log_services = logger::instance();
$log_services->log_to_file("services.log", "IN - ---");
$log_services->log_to_file("services.log", "IN - rest_entry.php - ".$_SERVER["REQUEST_URI"]."");

// Instanciation de restler
require_once "./php/restler/restler/restler.php";
$r = new Restler();

// Déclaration de la ressource 'consultations'
require_once "./REST/consultations.php";
$r->addAPIClass('consultations');

// Déclaration de la ressource 'dossier_autorisation'
require_once "./REST/dossier_autorisation.php";
$r->addAPIClass('dossier_autorisations');

// Déclaration de la ressource 'dossier_instructions'
require_once "./REST/dossier_instruction.php";
$r->addAPIClass('dossier_instructions');

// Déclaration de la ressource 'messages'
require_once "./REST/messages.php";
$r->addAPIClass('messages');

// Déclaration de la ressource 'maintenance'
require_once "./REST/maintenance.php";
$r->addAPIClass('maintenance');

// Déclaration de la ressource 'taches'
require_once "./REST/taches.php";
$r->addAPIClass('taches');

// Exécution de l'API
$r->handle();

?>
