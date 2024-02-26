<?php
/**
 *
 *
 * @package openmairie_exemple
 * @version SVN : $Id: om_utilisateur.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include PATH_OPENMAIRIE."sql/pgsql/om_utilisateur.inc.php";
$ent = _("administration")." -> "._("gestion des utilisateurs")." -> "._("om_utilisateur");

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'instructeur',
    'lien_om_utilisateur_tiers_consulte',
    'lien_service_om_utilisateur',
    'lien_om_utilisateur_groupe',
);

$sousformulaire_parameters['lien_om_utilisateur_groupe']['title'] = _('Groupe');


// Recherche avancée
$advsearch_fields= array(
    //
    'om_utilisateur' => array(
        'colonne' => 'om_utilisateur',
        'table' => 'om_utilisateur',
        'libelle' => __("utilisateur"),
        'type' => 'text',
        'taille' => '',
        'max' => ''
    ),
    'nom' => array(
        'colonne' => 'nom',
        'table' => 'om_utilisateur',
        'libelle' => __("nom"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'email' => array(
        'colonne' => 'email',
        'table' => 'om_utilisateur',
        'libelle' => __("email"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'login' => array(
        'colonne' => 'login',
        'table' => 'om_utilisateur',
        'libelle' => __("login"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'om_type' => array(
        'colonne' => 'om_type',
        'table' => 'om_utilisateur',
        'libelle' => __("type"),
        'type' => 'text',
        'taille' => '',
        'max' => '',
    )
    ,
    'om_profil' => array(
        'colonne' => 'om_profil',
        'table' => 'om_utilisateur',
        'libelle' => __("profil"),
        'type' => 'select',
        'taille' => '',
        'max' => '',
    )
);

if ($_SESSION['niveau'] == '2') {
    $advsearch_fields['om_collectivite'] = array(
        'table' => 'om_utilisateur',
        'colonne' => 'om_collectivite',
        'type' => 'select',
        'libelle' => _('om_collectivite')
    );
}

// advsearch -> options
$options[] =  array(
    'type' => 'search',
    'display' => true,
    'advanced' => $advsearch_fields,
    'absolute_object' => 'om_utilisateur',
    'export' => array("csv"),
);

