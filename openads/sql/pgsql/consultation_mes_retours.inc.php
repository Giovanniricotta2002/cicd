<?php
/**
 * LISTING - Consultations 'Mes retours'
 *
 * Le listing Consultations 'Mes retours' permet d'afficher la même liste des
 * dossiers que le widget 'Retours de consultation' avec le filtre=instructeur.
 * Une entrée de menu permet d'accéder à ce listing ainsi qu'un lien depuis le
 * widget.
 *
 * Ce script permet de spécifier les paramètres génériques du listing qui se
 * trouvent dans la définition du widget obj/om_widget.class.php et dans le
 * script ../sql/pgsql/consultation_retours.php.
 *
 * @package openads
 * @version SVN : $Id$
 */

//
include "../sql/pgsql/consultation_retours.php";

//
$ent = _("instruction")." -> "._("consultations")." -> "._("mes retours");

//
$champAffiche = array_merge(
    $displayed_fields_begin,
    $displayed_fields_end
);

//
$champRecherche = array_merge(
    array('dossier.dossier as "'._("dossier").'"',)
);

//
$tab_actions['left']['consulter'] = array(
    'lien' => ''.OM_ROUTE_FORM.'&direct_link=true&obj=dossier_instruction_mes_encours&amp;action=3&amp;direct_field=dossier&direct_form=consultation&direct_action=3&direct_idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
    'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
    'ordre' => 10,
);
$tab_actions['content'] = $tab_actions['left']['consulter'];

/**
 * OPTIONS - ADVSEARCH
 */
//
$advsearch_fields = array_merge(
    $advsearch_fields_begin,
    $advsearch_fields_end
);
// advsearch -> options
$options[] = array(
    'type' => 'search',
    'display' => true,
    'advanced' => $advsearch_fields,
    'absolute_object' => 'consultation',
);

?>