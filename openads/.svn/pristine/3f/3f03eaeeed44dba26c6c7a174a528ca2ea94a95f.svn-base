<?php
/**
 * Ce script permet de ...
 *
 * @package openfoncier
 * @version SVN : $Id: commission_mes_retours.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// inclusion du fichier de base d'affichage des retours de commissions
include "../sql/pgsql/commission_retours.inc.php";

//
$ent .= _("mes retours");

//
$champAffiche = array_merge(
    $displayed_fields_begin,
    $displayed_fields_end
);

$tab_actions['left']['consulter']=array(
    'lien' => ''.OM_ROUTE_FORM.'&direct_link=true&obj=dossier_instruction_mes_encours&amp;action=3'.
    '&amp;direct_field=dossier&direct_form=dossier_commission&direct_action=3&direct_idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
    'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
    'ordre' => 10,);
$tab_actions['content'] = $tab_actions['left']['consulter'];

?>
