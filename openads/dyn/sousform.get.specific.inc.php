<?php
/**
 * Ce fichier permet de definir des variables specifiques a passer dans la
 * methode sousformulaire des objets metier
 *
 * @package openmairie_exemple
 * @version SVN : $Id: sousform.get.specific.inc.php 4418 2015-02-24 17:30:28Z tbenita $
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
 * Ainsi dans la methode sousformulaire de l'objet en question la valeur de la date
 * de naissance sera accessible
 */

// Permet de savoir si le petitionnaire à créer est le principal
if ($obj == "petitionnaire") {
    $principal = "";
    if (isset($_GET['principal'])) {
        $principal = $_GET['principal'];
    }
    $extra_parameters["principal"] = $principal;
}

// Permet de passer le type de la demande au formulaire des demandeurs
if ($obj == "demandeur"
    OR $obj == "petitionnaire"
    OR $obj == "delegataire") {
    $idx_demandeur = "";
    if (isset($_GET['idx_demandeur'])) {
        $idx_demandeur = $_GET['idx_demandeur'];
    }
    $extra_parameters["idx_demandeur"] = $idx_demandeur;
}
    
// Permet de savoir si le petitionnaire à créer est le principal
if ($obj == "donnees_techniques") {
    $visualisation = "";
    if (isset($_GET['visualisation'])) {
        $visualisation = $_GET['visualisation'];
    }
    $extra_parameters["visualisation"] = $visualisation;
}
?>
