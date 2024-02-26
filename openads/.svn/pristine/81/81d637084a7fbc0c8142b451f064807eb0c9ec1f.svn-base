<?php

include PATH_OPENMAIRIE."../gen/sql/pgsql/num_dossier.inc.php";

// Modification du fil d'Ariane :
$ent = __("numerisation") . " -> " . __( "suivi dossier" ) . " -> " . __( "num_dossier_a_attribuer" );
if (isset ( $idz ) && trim ( $idz ) != '') {
    $ent .= "&nbsp;" . strtoupper ( $idz ) . "&nbsp;";
}

// Titre de l'onglet
$tab_title =  sprintf('%s %s', __("suivi des"), __("num_dossier_a_attribuer"));

// Restriction aux num_dossiers à attribuer
if ( $selection == "" ) {
    $selection = " WHERE";
} else {
    $selection .= " AND";
}
$selection .= " num_dossier.num_bordereau IS NULL AND datenum IS NULL ";

// TRI 
$tri="ORDER BY num_dossier.date_depot ASC, num_dossier.num_commande ASC";

//  ACTIONS DES LIGNES
if ( isset($tab_actions) ) {
    unset($tab_actions['corner']['ajouter']);

    // Modification directement depuis la liste
    //
    // action latérale
    $tab_actions['left']['consulter'] = array();
    $tab_actions['left']['modifier'] = array(
        'lien' => OM_ROUTE_FORM.'&obj='.$obj.'&amp;action=1'.'&amp;idx=',
        'id' => '&amp;premier='.$premier.'&amp;advs_id='.$advs_id.'&amp;tricol='.$tricol.'&amp;valide='.$valide.'&amp;retour=tab',
        'lib' => '<span class="om-icon om-icon-16 om-icon-fix edit-16" title="'.__('modifier').'">'.__('modifier').'</span>',
        'rights' => array('list' => array($obj, $obj.'_modifier'), 'operator' => 'OR'),
        'ordre' => 11,
    );
    
    // action hyper-lien
    $tab_actions['content']['lien'] =  str_replace("action=3","action=1",$tab_actions['content']['lien']);        
    $tab_actions['content']['rights'] = array('list' => array($obj, $obj.'_modifier'), 'operator' => 'OR');     

}

// Aucun résultat affiché si l'option n'est pas activé
if ($f->is_option_suivi_numerisation_enabled() === false) {
    $selection = " WHERE 1 = 2 ";
}
