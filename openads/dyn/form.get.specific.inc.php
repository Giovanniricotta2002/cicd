<?php
/**
 * Ce fichier permet de définir des variables spécifiques à passer dans la
 * méthode formulaire des objets métier
 *
 * @package openmairie_exemple
 * @version SVN : $Id: form.get.specific.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

/**
 * Exemple : un ecran specifique me permet de passer la date de naissance de
 * l'utilisateur au formulaire uniquement lorsque l'objet est "agenda".
 *
 * if ($obj == "agenda") {
 *     $datenaissance = "";
 *     if (isset($_GET['datenaissance'])) {
 *         $datenaissance = $_GET['datenaissance'];
 *     }
 *     $extra_parameters["datenaissance"] = $datenaissance;
 * }
 *
 * Ainsi dans la methode formulaire de l'objet en question la valeur de la date
 * de naissance sera accessible
 */

// Permet de passer le numéro du dossier d'instruction au formulaire de demande
if ($obj == "demande" || $obj == "demande_dossier_encours" || $obj == "demande_autre_dossier") {
    $idx_dossier = "";
    if (isset($_GET['idx_dossier'])) {
        $idx_dossier = $_GET['idx_dossier'];
    }
    $extra_parameters["idx_dossier"] = $idx_dossier;
}
?>
