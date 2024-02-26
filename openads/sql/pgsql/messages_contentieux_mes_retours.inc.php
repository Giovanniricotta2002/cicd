<?php
/**
 * LISTING - Messages 'Mes retours'
 *
 * Le listing Messages 'Mes retours' permet d'afficher la même liste des
 * dossiers que le widget 'Retours de messages' avec le filtre=instructeur.
 * Une entrée de menu permet d'accéder à ce listing ainsi qu'un lien depuis le
 * widget.
 *
 * Ce script permet de spécifier les paramètres génériques du listing qui se
 * trouvent dans la définition du widget obj/om_widget.class.php et dans le
 * script ../sql/pgsql/messages_retours.php.
 *
 * @package openads
 * @version SVN : $Id: messages_contentieux_mes_retours.inc.php 6565 2017-04-21 16:14:15Z softime $
 */

//
include "../sql/pgsql/messages_retours.php";

//
$ent = _("contentieux")." -> "._("messages")." -> "._("mes messages");

//
$champAffiche = array_merge(
    $displayed_fields_begin
);

//
$champRecherche = array_merge(
    array('dossier.dossier as "'._("dossier").'"',)
);

//
$tab_actions['left']['consulter'] = array(
    'lien' => ''.OM_ROUTE_FORM.'&obj=dossier_message&amp;action=777&amp;filtre='.$filtre.'&amp;idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
    'rights' => array('list' => array(
        'dossier_contentieux',
        'dossier_contentieux_mes_recours',
        'dossier_contentieux_mes_recours_consulter',
        'dossier_contentieux_tous_recours',
        'dossier_contentieux_tous_recours_consulter',
        'dossier_contentieux_mes_infractions',
        'dossier_contentieux_mes_infractions_consulter',
        'dossier_contentieux_toutes_infractions',
        'dossier_contentieux_toutes_infractions_consulter',
        'dossier_message_contexte_ctx',
        'dossier_message_contexte_ctx_consulter'
    ), 'operator' => 'OR'),
    'ordre' => 10
);
$tab_actions['content'] = $tab_actions['left']['consulter'];

/**
 * OPTIONS - ADVSEARCH
 */
//
$advsearch_fields = array_merge(
    $advsearch_fields_begin
);
// advsearch -> options
$options[] = array(
    'type' => 'search',
    'display' => true,
    'advanced' => $advsearch_fields,
    'absolute_object' => 'dossier_message',
);

?>
