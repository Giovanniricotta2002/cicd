<?php
/**
 * Ce fichier permet d'afficher le lien de téléchargement des documents
 * notifiés
 *
 * @package openfoncier
 * @version SVN : $Id$
 */

require_once "web.class.php";
$f = new openads_web("anonym");
$inst = $f->get_inst__om_dbform(array(
    "obj" => "instruction_notification_document",
    "idx" => 0,
));
$inst->view_telecharger_document_anonym($f->get_content_only_param());
