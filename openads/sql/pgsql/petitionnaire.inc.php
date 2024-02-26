<?php
/**
 *
 * @package openfoncier
 * @version SVN : $Id: petitionnaire.inc.php 4418 2015-02-24 17:30:28Z tbenita $
 */

//
include "../sql/pgsql/demandeur.inc.php";

// SELECT 
$champAffiche = array(
    'demandeur.demandeur as "'._("id").'"',
    $case_demandeur.' as "'._("nom").'"',
    $case_adresse.' as "'._("adresse").'"',
    'demandeur.qualite as "'._("qualite").'"',
    "case demandeur.frequent when 't' then 'Oui' else 'Non' end as \""._("frequent")."\"",
    );

//
$champRecherche = array(
    'demandeur.demandeur as "'._("demandeur").'"',
    'demandeur.type_demandeur as "'._("type_demandeur").'"',
    'demandeur.qualite as "'._("qualite").'"',
    'demandeur.particulier_nom as "'._("particulier_nom").'"',
    'demandeur.particulier_prenom as "'._("particulier_prenom").'"',
    'demandeur.particulier_commune_naissance as "'._("particulier_commune_naissance").'"',
    'demandeur.particulier_departement_naissance as "'._("particulier_departement_naissance").'"',
    'demandeur.particulier_pays_naissance as "'._("particulier_pays_naissance").'"',
    'demandeur.personne_morale_denomination as "'._("personne_morale_denomination").'"',
    'demandeur.personne_morale_raison_sociale as "'._("personne_morale_raison_sociale").'"',
    'demandeur.personne_morale_siret as "'._("personne_morale_siret").'"',
    'demandeur.personne_morale_categorie_juridique as "'._("personne_morale_categorie_juridique").'"',
    'demandeur.personne_morale_nom as "'._("personne_morale_nom").'"',
    'demandeur.personne_morale_prenom as "'._("personne_morale_prenom").'"',
    'demandeur.numero as "'._("numero").'"',
    'demandeur.voie as "'._("voie").'"',
    'demandeur.complement as "'._("complement").'"',
    'demandeur.lieu_dit as "'._("lieu_dit").'"',
    'demandeur.localite as "'._("localite").'"',
    'demandeur.code_postal as "'._("code_postal").'"',
    'demandeur.bp as "'._("bp").'"',
    'demandeur.cedex as "'._("cedex").'"',
    'demandeur.pays as "'._("pays").'"',
    'demandeur.division_territoriale as "'._("division_territoriale").'"',
    'demandeur.telephone_fixe as "'._("telephone_fixe").'"',
    'demandeur.telephone_mobile as "'._("telephone_mobile").'"',
    'demandeur.indicatif as "'._("indicatif").'"',
    'demandeur.courriel as "'._("courriel").'"',
    'civilite0.libelle as "'._("particulier_civilite").'"',
    'civilite1.libelle as "'._("personne_morale_civilite").'"',
    );

$tri="ORDER BY demandeur.type_demandeur ASC NULLS LAST";

//
$selection = " WHERE demandeur.type_demandeur='petitionnaire' ";

?>
