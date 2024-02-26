<?php
/**
 * Ce script a pour objet de recuperer la liste des pétionnaires correspondant aux critères de recherche
 *
 * @package openfoncier
 * @version SVN : $Id: findPetitionnaire.php 5710 2016-01-05 17:41:54Z jymadier $
 */

require_once "../obj/utils.class.php";
$f = new utils("nohtml");
$f->isAccredited(array("demande","demande_modifier","demande_ajouter"), "OR");
//Récupération des valeurs envoyées
$f->set_submitted_value();
$f->disableLog();

// Donnees
$par_nom = ($f->get_submitted_post_value("particulier_nom") != null) ? $f->get_submitted_post_value("particulier_nom") : "";
$par_nom = str_replace('*', '', $par_nom);
$par_nom = html_entity_decode($par_nom, ENT_QUOTES);
$par_nom = $f->db->escapeSimple($par_nom);

$par_prenom = ($f->get_submitted_post_value("particulier_prenom") != null) ? $f->get_submitted_post_value("particulier_prenom") : "";
$par_prenom = str_replace('*', '', $par_prenom);
$par_prenom = html_entity_decode($par_prenom, ENT_QUOTES);
$par_prenom = $f->db->escapeSimple($par_prenom);

$mor_raison_sociale = ($f->get_submitted_post_value("personne_morale_raison_sociale") != null) ? $f->get_submitted_post_value("personne_morale_raison_sociale") : "";
$mor_raison_sociale = str_replace('*', '', $mor_raison_sociale);
$mor_raison_sociale = html_entity_decode($mor_raison_sociale, ENT_QUOTES);
$mor_raison_sociale = $f->db->escapeSimple($mor_raison_sociale);

$mor_denomination = ($f->get_submitted_post_value("personne_morale_denomination") != null) ? $f->get_submitted_post_value("personne_morale_denomination") : "";
$mor_denomination = str_replace('*', '', $mor_denomination);
$mor_denomination = html_entity_decode($mor_denomination, ENT_QUOTES);
$mor_denomination = $f->db->escapeSimple($mor_denomination);

$mor_siret = ($f->get_submitted_post_value("personne_morale_siret") != null) ? $f->get_submitted_post_value("personne_morale_siret") : "";
$mor_siret = str_replace('*', '', $mor_siret);
$mor_siret = html_entity_decode($mor_siret, ENT_QUOTES);
$mor_siret = $f->db->escapeSimple($mor_siret);

$mor_cat_juridique = ($f->get_submitted_post_value("personne_morale_categorie_juridique") != null) ? $f->get_submitted_post_value("personne_morale_categorie_juridique") : "";
$mor_cat_juridique = str_replace('*', '', $mor_cat_juridique);
$mor_cat_juridique = html_entity_decode($mor_cat_juridique, ENT_QUOTES);
$mor_cat_juridique = $f->db->escapeSimple($mor_cat_juridique);

$mor_nom = ($f->get_submitted_post_value("personne_morale_nom") != null) ? $f->get_submitted_post_value("personne_morale_nom") : "";
$mor_nom = str_replace('*', '', $mor_nom);
$mor_nom = html_entity_decode($mor_nom, ENT_QUOTES);
$mor_nom = $f->db->escapeSimple($mor_nom);

$mor_prenom = ($f->get_submitted_post_value("personne_morale_prenom") != null) ? $f->get_submitted_post_value("personne_morale_prenom") : "";
$mor_prenom = str_replace('*', '', $mor_prenom);
$mor_prenom = html_entity_decode($mor_prenom, ENT_QUOTES);
$mor_prenom = $f->db->escapeSimple($mor_prenom);

$om_collectivite = ($f->get_submitted_post_value("om_collectivite") != null) ? $f->get_submitted_post_value("om_collectivite") : $_SESSION['collectivite'];
$listData = "";

$qres = $f->get_all_results_from_db_query(
    sprintf(
        'SELECT
            demandeur AS value,
            TRIM(CONCAT_WS(
                \' \',
                particulier_nom,
                particulier_prenom,
                personne_morale_raison_sociale,
                personne_morale_denomination,
                personne_morale_categorie_juridique,
                personne_morale_siret,
                personne_morale_nom,
                personne_morale_prenom,
                code_postal,
                localite
            )) AS content
        FROM
            %sdemandeur
        WHERE
            frequent IS TRUE
            AND type_demandeur = \'petitionnaire\'
            %2$s
            %3$s
            %4$s
            %5$s
            %6$s
            %7$s
            %8$s
            %9$s
            AND (om_collectivite = %10$d
                OR om_collectivite = (
                    SELECT om_collectivite
                    FROM %1$som_collectivite
                    WHERE niveau = \'2\'))',
        DB_PREFIXE,
        $par_nom != "" ? "AND particulier_nom ILIKE '%$par_nom%'" : '',
        $par_prenom != "" ? "AND particulier_prenom ILIKE '%$par_prenom%'" : '',
        $mor_raison_sociale != "" ? "AND personne_morale_raison_sociale ILIKE '%$mor_raison_sociale%'" : '',
        $mor_denomination != "" ? "AND personne_morale_denomination ILIKE '%$mor_denomination%'" : '',
        $mor_siret != "" ? "AND personne_morale_siret ILIKE '%$mor_siret%'" : '',
        $mor_cat_juridique != "" ? "AND personne_morale_categorie_juridique ILIKE '%$mor_cat_juridique%'" : '',
        $mor_nom != "" ? "AND personne_morale_nom ILIKE '%$mor_nom%'" : '',
        $mor_prenom != "" ? "AND personne_morale_prenom ILIKE '%$mor_prenom%'" : '',
        $om_collectivite
    ),
    array(
        'origin' => 'app/findPetitionnaire.php'
    )
);

$listData = array();
foreach ($qres['result'] as $row) {
    $listData[] = $row;
}

echo json_encode($listData);

?>