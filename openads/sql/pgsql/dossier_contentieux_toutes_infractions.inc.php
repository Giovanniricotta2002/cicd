<?php
/**
 * @package openads
 * @version SVN : $Id$
 */

//
include "../sql/pgsql/dossier_contentieux.inc.php";

/*Titre de la page*/
$ent = _("contentieux")." -> "._("infractions");

$retourformulaire = 'dossier_contentieux_toutes_infractions';

// Recherche simple
// Ajoute la recherche sur les juristes et les techniciens//
$champRecherche = array_merge(
    $champRecherche,
    array(
        'instructeur.nom as "'._("Juriste").'"',
        'instructeur_secondaire.nom as "'._("Technicien").'"',
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
$champs['contrevenant'] = array(
    'libelle' => _('contrevenant'),
    'help' => _("Recherche dans les champs : nom, prénom, raison sociale, dénomination. 

La chaîne recherchée doit figurer dans l'un de ces champs.

Par exemple, dans le cas d'un demandeur avec le nom 'DUPONT' et le prénom 'JEAN' :
- la recherche de 'JEAN' donne des résultats car le champ prénom contient 'JEAN',
- la recherche de 'DUPONT' donne des résultats car le champ nom contient 'DUPONT',
- la recherche de 'DUPONT JEAN' ne donne aucun résultat car ni le nom ni le prénom ni la raison sociale ni la dénomination ne contient 'DUPONT JEAN'."),
    'type' => 'text',
    'table' => 'demandeur_contrevenant',
    'colonne' => array(
        'particulier_nom',
        'particulier_prenom',
        'personne_morale_raison_sociale',
        'personne_morale_denomination',
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
$champs['parcelle'] = array(
    'table' => 'dossier_parcelle',
    'where' => 'injoin',
    'help' => __("Attention, il est possible que la section soit sur 1 ou 2 caractères, dans le cas où la parcelle saisie contient la section sur un seul caractère, il est conseillé d'ajouter une '*' avant la section.
        Exemple : '000*A0126'"),
    'tablejoin' => 'INNER JOIN (SELECT DISTINCT dossier FROM '.DB_PREFIXE.'dossier_parcelle WHERE lower(dossier_parcelle.libelle) like %s ) AS A1 ON A1.dossier = dossier.dossier' ,
    'colonne' => 'libelle',
    'type' => 'text',
    'taille' => 30,
    'max' => '',
    'libelle' => _('parcelle'),
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

//
$args = array(
    0 => array("", "t", "f", ),
    1 => array(_("choisir")." "._("ctx_infraction"), _("Oui"), _("Non"), ),
);
//
$champs['ctx_infraction'] = array(
    'table' => 'donnees_techniques',
    'colonne' => 'ctx_infraction',
    'type' => 'select',
    "subtype" => "manualselect",
    'libelle' => _('ctx_infraction'),
    "args" => $args,
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
$champs['technicien'] = array(
    'table' => 'dossier',
    'colonne' => 'instructeur_2',
    'type' => 'select',
    'libelle' => _('Technicien'),
    'subtype' => 'sqlselect',
    'sql' => "SELECT instructeur.instructeur, instructeur.nom
        FROM ".DB_PREFIXE."instructeur 
        INNER JOIN ".DB_PREFIXE."instructeur_qualite ON instructeur_qualite.instructeur_qualite=instructeur.instructeur_qualite
        WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))
            AND LOWER(instructeur_qualite.code) = LOWER('tech')
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
