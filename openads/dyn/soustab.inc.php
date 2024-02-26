<?php
/**
 * Ce fichier permet de definir des variables specifiques a passer dans la
 * methode sous-tableau des objets metier
 *
 * @package openmairie_exemple
 * @version SVN : $Id: soustab.inc.php 5208 2015-09-23 21:32:51Z fmichon $
 */

/**
 * Exemple : un ecran specifique me permet de passer la date de naissance de
 * l'utilisateur au sous-tableau uniquement lorsque l'objet est "agenda".
 *
 * if ($obj == "agenda") {
 *     $datenaissance = "";
 *     if (isset($_GET['datenaissance'])) {
 *         $datenaissance = $_GET['datenaissance'];
 *     }
 *     $extra_parameters["datenaissance"] = $datenaissance;
 * }
 *
 * Ainsi dans la methode sous-tableau de l'objet en question la valeur de la date
 * de naissance sera accessible
 */

// WIDGET DASHBOARD - widget_dossiers_limites.
// Permet de passer les paramètres du widget dossiers limites
if ($obj == "dossiers_limites") {
    //
    $nombre_de_jours = "";
    if (isset($_GET['nombre_de_jours'])) {
        $nombre_de_jours = $_GET['nombre_de_jours'];
    }
    $extra_parameters["nombre_de_jours"] = $nombre_de_jours;
    //
    $codes_datd = "";
    if (isset($_GET['codes_datd'])) {
        $codes_datd = $_GET['codes_datd'];
    }
    $extra_parameters["codes_datd"] = $codes_datd;
    //
    $filtre = "";
    if (isset($_GET['filtre'])) {
        $filtre = $_GET['filtre'];
    }
    $extra_parameters["filtre"] = $filtre;
}

?>
