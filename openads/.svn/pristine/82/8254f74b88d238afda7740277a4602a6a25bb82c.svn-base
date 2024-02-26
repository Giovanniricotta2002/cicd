<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: blocnote.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

//
include "../gen/sql/pgsql/blocnote.inc.php";

//
$ent = " -> "._("blocnote");

// SELECT 
$champAffiche = array(
    'blocnote.blocnote as "'._("id").'"',
    'blocnote.categorie as "'._("categorie").'"',
    'blocnote.note as "'._("note").'"',
    );
//
$champRecherche = array(
    'blocnote.blocnote as "'._("id").'"',
    'blocnote.categorie as "'._("categorie").'"',
    'dossier.annee as "'._("dossier").'"',
    );

$tri= " order by blocnote";

/**
 * Gestion particulière de l'affichage du listing dans le contexte d'un dossier
 * d'instruction
 */
include "../sql/pgsql/dossier_instruction_droit_specifique_par_division.inc.php";
// Gestion des groupes et confidentialité
include('../sql/pgsql/filter_group.inc.php');