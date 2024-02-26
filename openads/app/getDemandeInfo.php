<?php
/**
 * Ce script a pour objet de recuperer l'info passée en paramètre : soit la nature (nouveau dossier,
 * dossier existant), soit le code du type de la demande
 *
 * @package openfoncier
 * @version SVN : $Id: getDemandeInfo.php 4418 2015-02-24 17:30:28Z tbenita $
 */

require_once "../obj/utils.class.php";

$f = new utils("nohtml");
$f->isAccredited(array("demande","demande_modifier","demande_ajouter"), "OR");
$f->disableLog();

// Donnees
$id_demande_type = "";
if ($f->get_submitted_get_value("iddemandetype") != null) {
    $id_demande_type = $f->get_submitted_get_value("iddemandetype");
}
$info = "";
if ($f->get_submitted_get_value("info") != null) {
    $info = $f->get_submitted_get_value("info");
}

// Si les paramètre ne sont pas fournis on stop le traitement
if ($id_demande_type == "" OR $info == "") {
    die();
}
if ($info == "nature") {
    $qres = $f->get_one_result_from_db_query(
        sprintf(
            'SELECT
                demande_nature.code 
            FROM
                %1$sdemande_nature
                INNER JOIN %1$sdemande_type
                    ON demande_type.demande_nature = demande_nature.demande_nature
            WHERE
                demande_type.demande_type = %2$d',
            DB_PREFIXE,
            intval($id_demande_type)
        ),
        array(
            "origin" => "app/getDemandeInfo.php",
        )
    );
    echo $qres["result"];
}
if ($info == "contraintes") {
    $qres = $f->get_one_result_from_db_query(
        sprintf(
            'SELECT
                demande_type.contraintes
            FROM
                %1$sdemande_type
            WHERE
                demande_type.demande_type = %2$d',
            DB_PREFIXE,
            intval($id_demande_type)
        ),
        array(
            "origin" => "app/getDemandeInfo.php",
        )
    );
    echo $qres["result"];
}
if ($info == "type_aff_form") {
    $qres = $f->get_one_result_from_db_query(
        sprintf(
            'SELECT
                dossier_autorisation_type.affichage_form
            FROM
                %1$sdemande_type
                INNER JOIN %1$sdossier_autorisation_type_detaille
                    ON demande_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                INNER JOIN %1$sdossier_autorisation_type
                    ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type
            WHERE
                demande_type.demande_type = %2$d',
            DB_PREFIXE,
            intval($id_demande_type)
        ),
        array(
            "origin" => "app/getDemandeInfo.php",
        )
    );
    echo $qres["result"];
}
