<?php
//$Id: demande.inc.php 5133 2015-09-01 14:08:14Z fmichon $ 
//gen openMairie le 08/11/2012 14:00

include('../gen/sql/pgsql/demande.inc.php');
include "../sql/pgsql/app_om_tab_common_select.inc.php";

// Titre
//Menu : "Dossier Existant"
if (isset($idx_dossier) && $idx_dossier != ']' && trim($idx_dossier) != '') {
    //
    $ent = _("Demande sur dossier existant")."&nbsp;->&nbsp;".$idx_dossier;
} 
//Menu : "Nouveau Dossier"
elseif(isset($_GET['action'])&&$_GET['action']==0) {
    
    $ent = _("Demande pour nouveau dossier");

//Menu : "Récépissé"
} else{    
    //
    $ent = _("guichet unique")." -> ". _("nouvelle demande")." -> "._("recepisse");
}

//TABLE
// Champs du début de la requête
$table = DB_PREFIXE."demande
    LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_demande_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_demande_demandeur.demandeur
        WHERE lien_demande_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
    ) as demandeur
         ON demandeur.demande = demande.demande
    LEFT JOIN ".DB_PREFIXE."arrondissement 
        ON demande.arrondissement=arrondissement.arrondissement 
    LEFT JOIN ".DB_PREFIXE."demande_type 
        ON demande.demande_type=demande_type.demande_type 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
        ON demande.dossier_autorisation=dossier_autorisation.dossier_autorisation 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille 
        ON demande.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON demande.dossier_instruction=dossier.dossier 
    LEFT JOIN ".DB_PREFIXE."instruction 
        ON demande.instruction_recepisse=instruction.instruction
    LEFT JOIN ".DB_PREFIXE."om_collectivite
        ON demande.om_collectivite=om_collectivite.om_collectivite";

if ($f->is_option_dossier_commune_enabled()) {
    $table .= "
    LEFT JOIN ".DB_PREFIXE."commune
        ON demande.commune=commune.commune";
}

$selection = " WHERE groupe.code != 'CTX'";

// Filtre listing standard par collectivité
if ($f->isCollectiviteMono() === true) {
    // Filtre MONO
    $selection .= " AND (dossier.om_collectivite = '".$_SESSION["collectivite"]."') ";
}


/* Test SQL pour récupérer les bons champs selon la qualité du demandeur : 
 * particulier ou personne morale*/
$case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
END";

// Supression du bouton d'ajout de nouvelle demande à partir du formulaire
$tab_actions['corner']['ajouter'] = NULL;

// Liste des champs affichés dans le tableau de résultat
$champAffiche = array(
    'demande.demande as "'._("demande").'"',
    $select__dossier_libelle__column_as,
    'demande_type.libelle as "'._("demande_type").'"',
    $case_demandeur.' as "'._("nom").'"',
    'TRIM(CONCAT(demande.terrain_adresse_voie_numero,\' \',
        demande.terrain_adresse_voie,\' \',
        demande.terrain_adresse_lieu_dit,\' \',
        demande.terrain_adresse_code_postal,\' \',
        demande.terrain_adresse_localite,\' \',
        demande.terrain_adresse_bp,\' \',
        demande.terrain_adresse_cedex
    )) as "'._("localisation").'"',
    'dossier_autorisation_type_detaille.libelle as "'._("nature_dossier").'"',
    'to_char(demande.date_demande ,\'DD/MM/YYYY\') as "'._("date_demande").'"',
    );

// Ajoute la collectivité au listing
if ($f->isCollectiviteMono() === false) {
    //
    array_push($champAffiche, "om_collectivite.libelle as \""._("collectivite")."\"");
}

// Recherche simple

$champRecherche = array(
    'demande.demande as "'._("demande").'"',
    'dossier.dossier as "'._("dossier").'"',
    'demandeur.particulier_nom as "'._("petitionnaire particulier").'"',
    'demandeur.personne_morale_denomination as "'._("petitionnaire personne morale").'"',
    'demande.terrain_adresse_voie_numero',
    'demande.terrain_adresse_voie',
    'demande.terrain_adresse_lieu_dit',
    'demande.terrain_adresse_code_postal',
    'demande.terrain_adresse_localite',
    'demande.terrain_adresse_bp',
    'demande.terrain_adresse_cedex',
    'demande.arrondissement',
    'dossier_autorisation_type_detaille.libelle',
    );

// Ajoute la collectivité à la recherche simple
if ($f->isCollectiviteMono() === false) {
    //
    array_push($champRecherche, "om_collectivite.libelle as \""._("collectivite")."\"");
}

/**
 * OPTIONS - ADVSEARCH
 */
//
$champs = array();
//
$champs['dossier_instruction'] = array(
    'libelle' => _('dossier'),
    'type' => 'text',
    'table' => 'dossier',
    'colonne' => array(
        'dossier',
        'dossier_libelle',
    ),
    'taille' => '',
    'max' => '',
);
//
$champs['particulier_nom'] = array(
    'libelle' => _('petitionnaire'),
    'help' => _("Recherche dans les champs : nom, prénom, raison sociale, dénomination. 

La chaîne recherchée doit figurer dans l'un de ces champs.

Par exemple, dans le cas d'un demandeur avec le nom 'DUPONT' et le prénom 'JEAN' :
- la recherche de 'JEAN' donne des résultats car le champ prénom contient 'JEAN',
- la recherche de 'DUPONT' donne des résultats car le champ nom contient 'DUPONT',
- la recherche de 'DUPONT JEAN' ne donne aucun résultat car ni le nom ni le prénom ni la raison sociale ni la dénomination ne contient 'DUPONT JEAN'."),
    'type' => 'text',
    'table' => 'demandeur',
    'colonne' => array(
        'particulier_nom',
        'particulier_prenom',
        'personne_morale_raison_sociale',
        'personne_morale_denomination',
    ),
    'taille' => '',
    'max' => '',
);
//
$champs['adresse'] = array(
    'libelle' => _('localisation'),
    'help' => _("Recherche dans les champs : numéro, voie, lieu-dit, code postal, localité, boite postale, cedex. 

La chaîne recherchée doit figurer dans l'un de ces champs.

Par exemple, dans le cas d'une adresse avec la voie 'RUE DU ROUET' et la localité 'MARSEILLE' :
- la recherche de 'RUE DU ROUET' donne des résultats car le champ voie contient 'RUE DU ROUET',
- la recherche de 'MARSEILLE' donne des résultats car le champ localité contient 'MARSEILLE',
- la recherche de 'RUE DU ROUET MARSEILLE' ne donne aucun résultat car ni le numéro ni la voie ni le lieu-dit ni le code postal ni la localité ni la boite postale ni le cedex ne contient 'RUE DU ROUET MARSEILLE'."),
    'type' => 'text',
    'table' => 'demande',
    'colonne' => array(
        'terrain_adresse_voie_numero',
        'terrain_adresse_voie',
        'terrain_adresse_lieu_dit',
        'terrain_adresse_code_postal',
        'terrain_adresse_localite',
        'terrain_adresse_bp',
        'terrain_adresse_cedex',
    ),
    'taille' => '',
    'max' => '',
);
//
$champs['arrondissement'] = array(
    'colonne' => 'arrondissement',
    'table' => 'demande',
    'libelle' => _('arrondissement'),
    'type' => 'select',
);
//
$champs['dossier_autorisation_type_detaille'] = array(
    'table' => 'demande',
    'colonne' => 'dossier_autorisation_type_detaille',
    'type' => 'select',
    'libelle' => _('nature du dossier'),
);
//
$champs['date_demande'] = array(
    'colonne' => 'date_demande',
    'table' => 'demande',
    'libelle' => _('date_demande'),
    'type' => 'date',
    'where' => 'intervaldate',
    'taille' => '',
);
// Ajoute la collectivité à la recherche avancée
if ($f->isCollectiviteMono() === false) {
    //
    $champs['om_collectivite'] = array(
        'table' => 'dossier',
        'colonne' => 'om_collectivite',
        'type' => 'select',
        'libelle' => _('om_collectivite')
    );
}
// advsearch -> options
$options[] =  array(
    'type' => 'search',
    'display' => true,
    'advanced' => $champs,
    'absolute_object' => 'demande',
);

/**
 *
 */
//Sous-formulaire non affichés      
$sousformulaire = NULL;

// Tri sur le numéro de la demande
$tri = " ORDER BY demande.date_demande DESC, demande.demande DESC";

// Ajout de la gestion des groupes et confidentialité à la requête du listing
$sqlFiltreGroup = $this->get_sql_filtre_groupe($table.$selection);
$selection .= $sqlFiltreGroup['WHERE'];
$table .= $sqlFiltreGroup['FROM'];
// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];

?>
