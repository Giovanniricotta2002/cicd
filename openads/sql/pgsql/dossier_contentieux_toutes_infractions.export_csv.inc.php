<?php

/**
 * Afin de ne pas afficher le code HTML utilisé pour le champ "nature des
 * travaux", il est nécessaire de redéclarer pour l'export csv, les champs à
 * afficher.
 */

// Récupère toutes les variables du script *.inc
include('../sql/pgsql/dossier_contentieux.inc.php');

// /!\
// Attention en cas d'ajout d'une nouvelle colonne dans le $champAffiche, adapter l'index en consequence
// /!\

// Permet de remplacer le champ dossier avec l'html qui souligne le libelle afin d'empecher du html 
$champAffiche[3] = 'dossier.dossier_libelle as "'._("dossier").'"';

?>
