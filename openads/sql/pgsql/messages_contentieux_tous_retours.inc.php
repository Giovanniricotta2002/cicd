<?php
/**
 * LISTING - Messages 'Tous les retours'
 *
 * Le listing Messages 'Tous les retours' permet d'afficher la même liste
 * de dossiers que le widget 'Retours de messages' avec le filtre=aucun.
 * Une entrée de menu permet d'accéder à ce listing ainsi qu'un lien depuis le
 * widget.
 *
 * Ce script permet de spécifier les paramètres génériques du listing qui se
 * trouvent dans la définition du widget obj/om_widget.class.php et dans le
 * script ../sql/pgsql/messages_retours.php.
 *
 * @package openads
 * @version SVN : $Id: messages_contentieux_tous_retours.inc.php 6565 2017-04-21 16:14:15Z softime $
 */

//
include "../sql/pgsql/messages_retours.php";

//
$ent = _("contentieux")." -> "._("messages")." -> "._("tous les messages");

// Si la collectivité de l'utilisateur est de niveau mono
// alors on n'affiche pas la colonne collectivité
if ($f->isCollectiviteMono($_SESSION['collectivite']) === true) {
    //
    $champAffiche = array_merge(
        $displayed_fields_begin,
        $displayed_field_instructeur,
        $displayed_field_division
    );
    //
    $champRecherche = array_merge(
        array('dossier.dossier as "'._("dossier").'"',),
        $displayed_field_instructeur,
        $displayed_field_division
    );
} else {
    //
    $champAffiche = array_merge(
        $displayed_fields_begin,
        $displayed_field_instructeur,
        $displayed_field_division,
        $displayed_field_collectivite
    );
    //
    $champRecherche = array_merge(
        array('dossier.dossier as "'._("dossier").'"',),
        $displayed_field_instructeur,
        $displayed_field_division,
        $displayed_field_collectivite
    );
}

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
// Si la collectivité de l'utilisateur est de niveau mono
// alors on n'affiche pas la colonne collectivité
if ($f->isCollectiviteMono($_SESSION['collectivite']) === true) {
    $advsearch_fields = array_merge(
        $advsearch_fields_begin,
        $advsearch_field_instructeur,
        $advsearch_field_division
    );
} else {
    $advsearch_fields = array_merge(
        $advsearch_fields_begin,
        $advsearch_field_instructeur,
        $advsearch_field_division,
        $advsearch_field_collectivite
    );
}
// advsearch -> options
$options[] = array(
    'type' => 'search',
    'display' => true,
    'advanced' => $advsearch_fields,
    'absolute_object' => 'dossier_message',
);

?>
