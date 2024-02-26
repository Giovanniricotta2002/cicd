<?php
//$Id$ 
//gen openMairie le 04/09/2017 13:41

include PATH_OPENMAIRIE."../gen/sql/pgsql/num_bordereau.inc.php";

// Modification du fil d'Ariane :
$ent = __("numerisation") . " -> " . __( "traitement d'un lot" ) . " -> " . __( "tous les bordereaux" );
if (isset ( $idz ) && trim ( $idz ) != '') {
    $ent .= "&nbsp;" . strtoupper ( $idz ) . "&nbsp;";
}

// titre onglet
$tab_title= __( "Bordereau de suivi" );

//
$sousformulaire_parameters["num_dossier"] = array(
    "title" => __("Suivi des dossiers du bordereau"),
);

//
$tri = "ORDER BY num_bordereau.libelle DESC";

if ( isset($tab_actions) ) {
    $tab_actions['left']['imprimer'] = array(
        'lien' => OM_ROUTE_FORM.'&obj='.$obj.'&amp;action=4'.'&amp;idx=',
        'id' => '&amp;premier='.$premier.'&amp;advs_id='.$advs_id.'&amp;tricol='.$tricol.'&amp;valide='.$valide.'&amp;retour=tab" target="_blank',
        'lib' => '<span class="om-icon om-icon-16 om-icon-fix pdf-16" title="'.__('Édition du bordereau de suivi de numérisation.').'">'.__('Édition du bordereau de suivi de numérisation.').'</span>',
        'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
        'ordre' => 11,
    );
}

// Aucun résultat affiché si l'option n'est pas activé
if ($f->is_option_suivi_numerisation_enabled() === false) {
    $selection = " WHERE 1 = 2 ";
    $tab_actions['corner'] = array();
}
