<?php
/**
 * @package openads
 * @version SVN : $Id$
 */

//
include "../sql/pgsql/dossier_contentieux.inc.php";

/*Titre de la page*/
$ent = _("contentieux")." -> "._("recours");

// Recherche simple
// Ajoute la recherche sur les juristes
$champRecherche = array_merge(
    $champRecherche,
    array(
        'instructeur.nom as "'._("Juriste").'"',
    )
);

/**
 * OPTIONS
 */
//
if (!isset($options)) {
    $options = array();
}

/**
 * OPTIONS - ADVSEARCH
 */
//
$champs['dossier'] = array(
    'libelle' => _('dossier'),
    'type' => 'text',
    'table' => 'dossier',
    'colonne' => array(
        'dossier', 
        'dossier_libelle',
    ),
    'taille' => 30,
    'max' => '',
);

//
$champs['type'] = array(
    'table' => 'dossier_autorisation_type_detaille',
    'colonne' => 'dossier_autorisation_type_detaille',
    'type' => 'select',
    'libelle' => _('type'),
    'subtype' => 'sqlselect',
    'sql' => "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle
        FROM ".DB_PREFIXE."dossier_autorisation_type_detaille 
        WHERE (LOWER(dossier_autorisation_type_detaille.code) = LOWER('REC')
            OR LOWER(dossier_autorisation_type_detaille.code) = LOWER('REG'))
        ORDER BY libelle",
);

//
$champs['autorisation'] = array(
    'libelle' => _('autorisation'),
    'type' => 'text',
    'table' => 'dossier_autorisation_contestee',
    'colonne' => array(
        'dossier', 
        'dossier_libelle',
    ),
    'taille' => 30,
    'max' => '',
);

//
$champs['petitionnaire'] = array(
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
    'taille' => 30,
    'max' => '',
);

//
$champs['adresse'] = array(
    'libelle' => _('localisation'),
    'help' => _("Recherche dans les champs numéro, voie, lieu-dit, code postal, localité, boite postale, cedex et dans l'adresse normalisée.

La chaîne recherchée doit figurer dans l'un de ces champs.

Par exemple, dans le cas d'une adresse avec la voie 'RUE DU ROUET' et la localité 'MARSEILLE' :
- la recherche de 'RUE DU ROUET' donne des résultats car le champ voie contient 'RUE DU ROUET',
- la recherche de 'MARSEILLE' donne des résultats car le champ localité contient 'MARSEILLE',
- la recherche de 'RUE DU ROUET MARSEILLE' ne donne aucun résultat car ni le numéro ni la voie ni le lieu-dit ni le code postal ni la localité ni la boite postale ni le cedex ne contient 'RUE DU ROUET MARSEILLE'.

Dans le cas de l'adresse normalisée, la recherche se fait sur la chaîne complète telle que retournée par la BAN. Il est donc conseillé d'utiliser le signe de remplacement * en début de votre recherche."),
    'type' => 'text',
    'table' => 'dossier',
    'colonne' => array(
        'terrain_adresse_voie_numero',
        'terrain_adresse_voie',
        'terrain_adresse_lieu_dit',
        'terrain_adresse_code_postal',
        'terrain_adresse_localite',
        'terrain_adresse_bp',
        'terrain_adresse_cedex',
        'adresse_normalisee',
    ),
    'taille' => 30,
    'max' => '',
);

// Affiche le champ de recherche sur l'arrondissement seulement si l'option est
// activée
if ($f->getParameter('option_arrondissement') === 'true') {
    //
    $champs['arrondissement'] = array(
        'table' => 'arrondissement',
        'colonne' => 'libelle',
        'type' => 'select',
        'libelle' => _('arrondissement'),
    );
}

//
$champs['requerant'] = array(
    'libelle' => _('requerant'),
    'help' => _("Recherche dans les champs : nom, prénom, raison sociale, dénomination. 

La chaîne recherchée doit figurer dans l'un de ces champs.

Par exemple, dans le cas d'un demandeur avec le nom 'DUPONT' et le prénom 'JEAN' :
- la recherche de 'JEAN' donne des résultats car le champ prénom contient 'JEAN',
- la recherche de 'DUPONT' donne des résultats car le champ nom contient 'DUPONT',
- la recherche de 'DUPONT JEAN' ne donne aucun résultat car ni le nom ni le prénom ni la raison sociale ni la dénomination ne contient 'DUPONT JEAN'."),
    'type' => 'text',
    'table' => 'demandeur_requerant',
    'colonne' => array(
        'particulier_nom',
        'particulier_prenom',
        'personne_morale_raison_sociale',
        'personne_morale_denomination',
    ),
    'taille' => 30,
    'max' => '',
);

//
$champs['juriste'] = array(
    'table' => 'dossier',
    'colonne' => 'instructeur',
    'type' => 'select',
    'libelle' => _('Juriste'),
    'subtype' => 'sqlselect',
    'sql' => "SELECT instructeur.instructeur, instructeur.nom
        FROM ".DB_PREFIXE."instructeur 
        INNER JOIN ".DB_PREFIXE."instructeur_qualite ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
        WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))
            AND LOWER(instructeur_qualite.code) = LOWER('juri')
        ORDER BY nom",
);

//
$champs['etat'] = array(
    'table' => 'dossier',
    'colonne' => 'etat',
    'type' => 'select',
    'libelle' => _('etat'),
);

$champs['numero_versement_archive'] = array(
    'libelle' => __('numéro d\'archive'),
    'type' => 'text',
    'table' => 'dossier',
    'colonne' => 'numero_versement_archive',
    'taille' => 30,
    'max' => '',
);

$champs['ctx_reference_dsj'] = array(
    'libelle' => _('ctx_reference_dsj'),
    'type' => 'text',
    'table' => 'donnees_techniques',
    'colonne' => 'ctx_reference_dsj',
    'taille' => 30,
    'max' => '',
);

//
$champs['date_depot'] = array(
    'colonne' => 'date_depot',
    'table' => 'dossier',
    'libelle' => _('date de recours'),
    'lib1' => _("debut"),
    'lib2' => _("fin"),
    'type' => 'date',
    'taille' => 8,
    'where' => 'intervaldate',
);

//
$champs['date_cloture_instruction'] = array(
    'colonne' => 'date_cloture_instruction',
    'table' => 'dossier',
    'libelle' => _('date_cloture_instruction'),
    'lib1' => _("debut"),
    'lib2' => _("fin"),
    'type' => 'date',
    'taille' => 8,
    'where' => 'intervaldate',
);

//
$champs['decision'] = array(
    'colonne' => 'libelle',
    'table' => 'avis_decision',
    'libelle' => _('decision'),
    'type' => 'select',
    'subtype' => 'sqlselect',
    'sql' => "select avis_decision,libelle from ".DB_PREFIXE."avis_decision order by libelle",
);

//
$champs['date_decision'] = array(
    'colonne' => 'date_decision',
    'table' => 'dossier',
    'libelle' => _('date_decision'),
    'lib1'=> _("debut"),
    'lib2' => _("fin"),
    'type' => 'date',
    'taille' => 8,
    'where' => 'intervaldate',
);

//
if ($_SESSION['niveau'] == '2') {
    $champs['om_collectivite'] = array(
        'table' => 'dossier',
        'colonne' => 'om_collectivite',
        'type' => 'select',
        'libelle' => _('om_collectivite')
    );
}
// advsearch -> options
$options[] = array(
    'type' => 'search',
    'display' => true,
    'advanced'  => $champs,
    'default_form'  => 'advanced',
    'absolute_object' => 'dossier',
    'export' => array("csv"),
);

/**
 * OPTIONS
 */
//
$options[] = array(
    'type' => 'pagination_select',
    'display' => ''
);

?>
