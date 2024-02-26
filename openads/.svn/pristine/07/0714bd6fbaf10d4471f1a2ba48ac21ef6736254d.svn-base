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
 * @version SVN : $Id$
 */

//
include "../sql/pgsql/messages_retours.php";

//
$ent = _("instruction")." -> "._("messages")." -> "._("tous les messages");

// Si la collectivité de l'utilisateur est de niveau mono
// alors on n'affiche pas la colonne collectivité
$champRechercheCommun = array(
    'dossier.dossier as "'._("dossier").'"'
);
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
        $champRechercheCommun,
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
        $champRechercheCommun,
        $displayed_field_instructeur,
        $displayed_field_division,
        $displayed_field_collectivite
    );
}

//
$tab_actions['left']['consulter'] = array(
    'lien' => ''.OM_ROUTE_FORM.'&direct_link=true&obj=dossier_instruction&amp;action=3&amp;direct_field=dossier&direct_form=dossier_message&direct_action=3&direct_idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
    'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
    'ordre' => 10,
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
        $advsearch_field_division,
        $advsearch_fields_end
    );
} else {
    $advsearch_fields = array_merge(
        $advsearch_fields_begin,
        $advsearch_field_instructeur,
        $advsearch_field_division,
        $advsearch_field_collectivite,
        $advsearch_fields_end
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
