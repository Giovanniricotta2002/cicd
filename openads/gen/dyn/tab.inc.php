<?php
/**
 * Ce fichier permet de paramétrer le générateur.
 *
 * @package openmairie_exemple
 * @version SVN : $Id: tab.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

/**
 * Si une variable définie ici porte le nom d'une table, alors le générateur va
 * générer le fichier tab.inc.php avec la liste des champs précisés dans le
 * tableau défini par cette variable comme champs affichés dans l'affichage du
 * tableau.
 */
// Table om_utilisateur
$om_utilisateur = array("nom", "email", "login", "om_profil", );
// Table om_widget
$om_widget = array("libelle", "om_profil", "type", );

/**
 * Tables spécifiques
 */
//
$action=array("action","libelle");

//
$dossier=array("dossier",
				"demandeur_nom",
				"instructeur",
				"date_demande",
				"date_depot",
				"date_complet",
				"date_notification_delai",
                "date_limite",
                "etat",
                "avis");

?>
