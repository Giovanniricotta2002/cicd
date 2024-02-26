<?php
//$Id$ 
//gen openMairie le 23/01/2023 15:06

include "../gen/sql/pgsql/lien_dossier_tiers.inc.php";

// Récupération des paramètres de l'url
$idCategorie = ! empty($f->get_submitted_get_value('category')) ?
    $f->get_submitted_get_value('category') :
    0;
$libCategory = ! empty($f->get_submitted_get_value('libcategory')) ?
    $f->get_submitted_get_value('libcategory') :
    0;
// Fil d'Ariane. Si la catégorie est définie on l'affiche dans le fil sinon
// on affiche le fil simple.
$ent = ! empty($libCategory) ?
    __("instruction")." -> ".__("Acteur(s)")." -> ".$libCategory :
    __("instruction")." -> ".__("Acteur(s)");

// Nom de la table
$tab_title = __("Acteur(s)");

// Suppression de l'affichage du nombre de résultat
$options[] = array(
    'type' => "pagination",
    'display' => false
);

// Clauses de la requête permettant d'afficher le listing :

// SELECT
// Le premier champs est nécessaire pour récupéré l'identifiant du tiers dans
// le lien et les actions d'une ligne du listing.
// Il est masqué par du css.
$champAffiche = array(
    'lien_dossier_tiers as "'.__("lien_dossier_tiers").'"',
    'tiers_consulte.libelle as "'.__("tiers").'"',
);

// FROM
// Jointure avec les tiers pour pouvoir filtrer par catégorie
$table = sprintf(
    '%1$slien_dossier_tiers
    LEFT JOIN %1$stiers_consulte 
        ON lien_dossier_tiers.tiers = tiers_consulte.tiers_consulte
    ',
    DB_PREFIXE
);

// WHERE
// Filtre par catégorie
if (! empty($idCategorie)) {
    $selection .= sprintf(
        ' %1$s tiers_consulte.categorie_tiers_consulte = %2$d',
        (! empty($selection) ? 'AND' : 'WHERE'),
        intval($idCategorie)
    );
}
// ORDER BY
$tri="ORDER BY tiers_consulte.libelle";


// Définitions des actions du listing :

// Paramétrage du bouton d'ajout pour renvoyer vers le formulaire d'ajout
// des acteurs de la catégorie voulu
$tab_actions['corner']['ajouter'] = array(
    'lien' => OM_ROUTE_SOUSFORM.'&obj=lien_dossier_tiers&amp;action=6',
    'id' =>
        '&amp;idxformulaire='.$idxformulaire.
        '&amp;retour=specific'. // permet de renvoyer vers l'onglet acteur à la validation de l'ajout
        '&amp;category='.$idCategorie.
        '&amp;libcategory='.urlencode($libCategory).
        '&amp;retourformulaire='.$retourformulaire,
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix add-16" title="'.__('Ajouter').'">'.__('Ajouter').'</span>',
    'rights' => array('list' => array('lien_dossier_tiers', 'lien_dossier_tiers_ajouter'), 'operator' => 'OR'),
    'ajax' => false,
    'ordre' => 1
);

// Paramétrage du bouton de suppression pour permettre la suppression d'un acteur
// en cliquant sur l'action de suppression dans le listing.
// /!\ La mise à jour du listing et l'affichage du message de suppression sont géré par un script
$tab_actions['left']['supprimer'] = array(
    'lien' => OM_ROUTE_FORM.'&obj=lien_dossier_tiers&amp;action=2&amp;idxformulaire='.$idxformulaire.'&amp;idx=',
    'lib' => sprintf(
        '<span class="om-icon om-icon-16 om-icon-fix delete-16" title="%1$s">%1$s</span>',
        __("Supprimer")
    ),
    'type' => 'action-direct',
    'rights' => array('list' => array('lien_dossier_tiers', 'lien_dossier_tiers_supprimer'), 'operator' => 'OR'),
    'ordre' => 20
);
