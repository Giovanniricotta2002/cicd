<?php
/**
 *
 *
 * @package openads
 * @version SVN : $Id: varlettretypepdf.inc 6057 2016-02-29 14:52:43Z stimezouaght $
 */

/**
 *
 */
// IDX
$titre = str_ireplace("&idx", ((isset($_GET['idx'])) ? $_GET['idx'] : $idx ), $titre);
$corps = str_ireplace("&idx", ((isset($_GET['idx'])) ? $_GET['idx'] : $idx ), $corps);

/**
 * CONTRAINTES
 */
// Vérifie l'édition encours
if (isset($_GET['obj'])
    && $_GET['obj'] != 'om_lettretype'
    && file_exists("../app/dossier_contrainte_edition.php")) {

    // Variable de remplacement pour les états
    $var_remplacement_pdf = "lettretype";

    // Cherche la variable de remplacement avec paramètres
    preg_match_all("/&contraintes\((.*)\)/", $titre, $matches_contraintes_titre);
    // Pour chaque résultat
    foreach ($matches_contraintes_titre[0] as $key => $value) {
        // Instancie les valeurs
        $contraintes_titre[0] = $value;
        $contraintes_titre[1] = $matches_contraintes_titre[1][$key];
        // Inclus le fichier pour le remplacement
        include("../app/dossier_contrainte_edition.php");
        // Remplace la variable
        $titre=str_ireplace($contraintes_titre[0], $contraintes, $titre);
    }
    // Cherche la variable de remplacement sans paramètres
    preg_match_all("/&contraintes(?!\(.*\))/", $titre, $matches_contraintes_titre);
    // Pour chaque résultat
    foreach ($matches_contraintes_titre[0] as $key => $value) {
        // Instancie les valeurs
        $contraintes_titre[0] = $value;
        $contraintes_titre[1] = '';
        // Inclus le fichier pour le remplacement
        include("../app/dossier_contrainte_edition.php");
        // Remplace la variable
        $titre=str_ireplace($contraintes_titre[0], $contraintes, $titre);
    }
    //On supprime cette variable afin qu'elle ne soit plus utilisée dans le 
    //script inclus
    unset($contraintes_titre);
    
    // Cherche la variable de remplacement avec paramètres
    preg_match_all("/&contraintes\((.*)\)/", $corps, $matches_contraintes_corps);
    // Pour chaque résultat
    foreach ($matches_contraintes_corps[0] as $key => $value) {
        // Instancie les valeurs
        $contraintes_corps[0] = $value;
        $contraintes_corps[1] = $matches_contraintes_corps[1][$key];
        // Inclus le fichier pour le remplacement
        include("../app/dossier_contrainte_edition.php");
        // Remplace la variable
        $corps=str_ireplace($contraintes_corps[0], $contraintes, $corps);
    }
    // Cherche la variable de remplacement sans paramètres
    preg_match_all("/&contraintes(?!\(.*\))/", $corps, $matches_contraintes_corps);
    // Pour chaque résultat
    foreach ($matches_contraintes_corps[0] as $key => $value) {
        // Instancie les valeurs
        $contraintes_corps[0] = $value;
        $contraintes_corps[1] = '';
        // Inclus le fichier pour le remplacement
        include("../app/dossier_contrainte_edition.php");
        // Remplace la variable
        $corps=str_ireplace($contraintes_corps[0], $contraintes, $corps);
    }
    //On supprime cette variable afin qu'elle ne soit plus utilisée dans le 
    //script inclus
    unset($contraintes_corps);
}

?>
