<?php
/**
 * Widget - 
 *
 * @package openfoncier
 * @version SVN : $Id: widget_dossier_qualifier.php 4570 2015-04-10 16:12:43Z nmeucci $
 */

require_once "../obj/utils.class.php";
if (!isset($f)) {
    $f = new utils(NULL, "dossier_qualifier", 
    _("Widget - Mes Dossiers A Qualifier"));
}

// Filtre du nombre de dossiers à qualifier en fonction du rôle de
// l'utilisateur : si l'utilisateur n'est pas un qualificateur alors on
// n'affiche que ses dossiers à qualifier sinon si la collectivité de
// l'utilisateur niveau mono alors filtre sur celle-ci
$filter = "";
if (!$f->isUserQualificateur()) {
    $filter = sprintf(
        ' om_utilisateur.login = \'%s\' AND ',
        $f->db->escapeSimple($_SESSION['login'])
    );
} elseif ($f->isCollectiviteMono($_SESSION['collectivite']) === true) {
    $filter = sprintf(
        ' dossier.om_collectivite = %d AND ',
        intval($_SESSION['collectivite'])
    );
}

// Création de la requête de récupération du nombre de dossiers à qualifier ERP ou non
$query_template = sprintf(
    'SELECT 
        count(dossier)
    FROM
        %1$sdossier
        LEFT JOIN %1$sdossier_instruction_type
            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
        JOIN %1$sinstructeur
            ON dossier.instructeur = instructeur.instructeur
        JOIN %1$som_utilisateur
            ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
    WHERE
        %2$s dossier.a_qualifier IS TRUE
        AND dossier.erp IS <erp_boolean>
        AND dossier_instruction_type.sous_dossier IS NOT TRUE',
    DB_PREFIXE,
    $filter
);
$qres = $f->get_one_result_from_db_query(
    str_replace("<erp_boolean>", "TRUE", $query_template),
    array(
        "origin" => "app/widget_dossier_qualifier.php",
    )
);
$erp = $qres["result"];
$qres = $f->get_one_result_from_db_query(
    str_replace("<erp_boolean>", "FALSE", $query_template),
    array(
        "origin" => "app/widget_dossier_qualifier.php",
    )
);
$ads = $qres["result"];
// Affiche des données résultats
if ( $erp + $ads > 0 ){
    
    //Nombre de dossiers à qualifier
    $message = _("Vous avez ").( $erp + $ads )._(" dossier(s) a qualifier :<br/>");
    $message .= (isset($erp) && $erp > 0 ) ? " - ".$erp._(" ERP")."<br/>" : "" ;
    $message .= ((isset($ads) && $ads > 0 ) ? " - ".$ads._(" ADS")."<br/>" : "")."<br/>" ;
    echo $message;

    $footer = OM_ROUTE_TAB."&obj=dossier_qualifier";

    // Si l'utilisateur est un qualificateur
    // alors on affiche tous les dossiers à qualifier
    if($f->isUserQualificateur()) {
        $footer = OM_ROUTE_TAB."&obj=dossier_qualifier_qualificateur";
    }
    $footer_title = _("Voir tous mes dossiers a qualifier");
}
else{
    
    echo _("Vous n'avez pas de dossiers a qualifier.");
}
