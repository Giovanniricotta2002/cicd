<?php
/**
 * Ce script permet de ...
 *
 * @package openfoncier
 * @version SVN : $Id: commission_demandes_passage.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

// inclusion du fichier de base d'affichage des retours de commissions
include "../sql/pgsql/dossier_commission.inc.php";
include "../sql/pgsql/app_om_tab_common_select.inc.php";

//
$ent = _("suivi")." -> "._("commissions")." -> "._("demandes");

//
$tab_description = _("Toutes les demandes de passages en commissions en ".
                     "attente.");

//
$tab_title = _("demandes de passage en commission");

// on surchage le listing et la recherche pour ne pas afficher les infos de la
// commission (inutiles car il y a un filtre qui restreint aux demandes en
// attente)
$displayed_fields_begin = array(
    'dossier_commission.dossier_commission as "'._("id").'"',
    $select__dossier_libelle__column_as,
    'to_char(dossier_commission.date_souhaitee ,\'DD/MM/YYYY\') as "'._("date_souhaitee").'"',
);
$champRecherche = array(
    'dossier_commission.dossier_commission as "'._("dossier_commission").'"',
    'dossier.dossier as "'._("dossier").'"',
    'dossier.dossier_libelle as "'._("libelle dossier").'"',
    'commission_type.libelle as "'._("commission_type").'"',
);

//
$champAffiche = array_merge(
    $displayed_fields_begin,
    $displayed_field_commission_type,
    $displayed_field_instructeur,
    $displayed_fields_end
);

// FROM
$table .= "
    LEFT JOIN ".DB_PREFIXE."instructeur
        ON instructeur.instructeur=dossier.instructeur
    LEFT JOIN ".DB_PREFIXE."om_utilisateur
        ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
    LEFT JOIN ".DB_PREFIXE."instructeur AS instructeur_secondaire
        ON instructeur_secondaire.instructeur = dossier.instructeur_2
    LEFT JOIN ".DB_PREFIXE."om_utilisateur AS utilisateur_2
        ON instructeur_secondaire.om_utilisateur = utilisateur_2.om_utilisateur
    LEFT JOIN ".DB_PREFIXE."division
            ON  instructeur.division = division.division
    LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON  dossier.om_collectivite = om_collectivite.om_collectivite
";


//
$tab_actions['corner']['ajouter']=NULL;
$tab_actions['left']['consulter']=NULL;
$tab_actions['content'] = $tab_actions['left']['consulter'];

// Affiche seulement les demandes de passage en commission en attente et de notre collectivité
$selection = " WHERE dossier_commission.commission IS NULL";

// Si user mono
if ($f->isCollectiviteMono($_SESSION['collectivite']) === true) {
    $selection .= " AND dossier.om_collectivite = ".$_SESSION['collectivite'];
} else {
    //
    $champAffiche = array_merge(
        $displayed_fields_begin,
        $displayed_field_commission_type,
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

// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];
?>
