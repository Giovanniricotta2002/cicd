<?php
/**
 * Ce script permet de ...
 *
 * @package openfoncier
 * @version SVN : $Id: commission_tous_retours.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// inclusion du fichier de base d'affichage des retours de commissions
include "../sql/pgsql/commission_retours.inc.php";

//
$ent .= _("tous les retours");


// Si la collectivité de l'utilisateur est de niveau mono
// alors on n'affiche pas la colonne collectivité
if ($f->isCollectiviteMono($_SESSION['collectivite']) === true) {
    //
    $champAffiche = array_merge(
        $displayed_fields_begin,
        $displayed_field_instructeur,
        $displayed_field_division,
        $displayed_fields_end
    );
    //
    $champRecherche = array_merge(
        $champRecherche,
        $displayed_field_instructeur,
        $displayed_field_division
    );
} else {
    //
    $champAffiche = array_merge(
        $displayed_fields_begin,
        $displayed_field_instructeur,
        $displayed_field_division,
        $displayed_field_collectivite,
        $displayed_fields_end
    );
    //
    $champRecherche = array_merge(
        $champRecherche,
        $displayed_field_instructeur,
        $displayed_field_division,
        $displayed_field_collectivite
    );
}

$tab_actions['left']['consulter']=array(
    'lien' => ''.OM_ROUTE_FORM.'&direct_link=true&obj=dossier_instruction&amp;action=3'.
    '&amp;direct_field=dossier&direct_form=dossier_commission&direct_action=3&direct_idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
    'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
    'ordre' => 10,);
$tab_actions['content'] = $tab_actions['left']['consulter'];

?>
