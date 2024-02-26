<?php
//$Id$ 
//gen openMairie le 30/08/2017 14:47

include PATH_OPENMAIRIE."../gen/sql/pgsql/num_dossier.inc.php";

// Modification du fil d'Ariane :
$ent = __("numerisation") . " -> " . __( "suivi dossier" ) . " -> " . __( "tous les dossiers" );
if (isset ( $idz ) && trim ( $idz ) != '') {
    $ent .= "&nbsp;" . strtoupper ( $idz ) . "&nbsp;";
}

// Titre de l'onglet
$tab_title =  __("suivi de tous les dossiers");

// ajout des dates à la recherche
$champRecherche = $champAffiche;



// TRI 
$tri="ORDER BY ref DESC, date_depot ASC";

if ( isset($tab_actions) ) {

    // INTERDICTION DE L'AJOUT
    // unset ($tab_actions['corner']['ajouter']);
    // On inactive l'ajout suivant le statut de l'autorisation
    unset ($tab_actions['corner']['ajouter']);
}

// Aucun résultat affiché si l'option n'est pas activé
if ($f->is_option_suivi_numerisation_enabled() === false) {
    $selection = " WHERE 1 = 2 ";
}
