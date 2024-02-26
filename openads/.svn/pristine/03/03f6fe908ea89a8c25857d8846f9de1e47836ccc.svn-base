<?php
/**
 * @package openfoncier
 * @version SVN : $id$
 **/

//
include('../sql/pgsql/dossier_instruction.inc.php');

/*Recherche simple*/
$champRecherche = array(
    'dossier.dossier as "'.__("dossier").'"',
    'personne_morale_denomination as "'.__("personne_morale_denomination").'"',
    'particulier_nom as "'.__("particulier_nom").'"'
);
//
$serie = 50;

$ent = _("guichet unique")." -> ". _("nouvelle demande")." -> "._("dossier en cours");
$tab_title = _("demande");

$table = DB_PREFIXE."dossier
LEFT JOIN ".DB_PREFIXE."dossier as d2 
    ON (dossier.dossier_autorisation = d2.dossier_autorisation AND d2.version IS NULL AND dossier.version < d2.version)
LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_dossier_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
    ) as demandeur
         ON demandeur.dossier = dossier.dossier
LEFT JOIN ".DB_PREFIXE."dossier_autorisation
    ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
    ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_autorisation.dossier_autorisation_type_detaille
LEFT JOIN ".DB_PREFIXE."instructeur
    ON dossier.instructeur = instructeur.instructeur
LEFT JOIN ".DB_PREFIXE."om_utilisateur
    ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
LEFT JOIN ".DB_PREFIXE."avis_decision
    ON avis_decision.avis_decision=dossier.avis_decision
LEFT JOIN ".DB_PREFIXE."arrondissement
    ON dossier.terrain_adresse_code_postal=arrondissement.code_postal
LEFT JOIN ".DB_PREFIXE."etat
    ON dossier.etat = etat.etat
LEFT JOIN ".DB_PREFIXE."division
    ON dossier.division = division.division
LEFT JOIN ".DB_PREFIXE."om_collectivite
        ON dossier.om_collectivite=om_collectivite.om_collectivite
-- Récupère la demande qui a créé le type dossier du dossier
LEFT JOIN (".DB_PREFIXE."demande
    JOIN ".DB_PREFIXE."demande_type
        ON demande.demande_type = demande_type.demande_type)
    ON demande.dossier_instruction = dossier.dossier
        AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type";

if ($f->is_option_dossier_commune_enabled()) {
    $table .= "
    LEFT JOIN ".DB_PREFIXE."commune
        ON dossier.commune=commune.commune";
}

$selection = " WHERE groupe.code != 'CTX'"
        . " AND (etat.statut = 'encours' OR etat.etat = 'accepter' "
        . "OR etat.etat = 'accepte_tacite' )";
/**
 * Gestion de la clause WHERE => $selection om_collectivite
 */
// Filtre listing standard
if ($_SESSION["niveau"] == "2") {
    // Filtre MULTI
    $selection .= "";
} else {
    // Filtre MONO
    $selection .= " AND (dossier.om_collectivite = '".$_SESSION["collectivite"]."') ";
}

// tri
$tri= " ORDER BY dossier.dossier";

//Suppression de l'action ajouter
$tab_actions['corner']['ajouter'] = NULL;
// Actions a gauche : consulter 
$tab_actions['left']['consulter'] =
    array('lien' => ''.OM_ROUTE_FORM.'&obj=demande_dossier_encours&amp;action=0&amp;idx_dossier=',
          'id' => '&amp;premier='.$premier.'&amp;advs_id='.$advs_id.'&amp;tricol='.$tricol.'&amp;valide='.$valide,
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix add-16" title="'._('Ajouter une demande').'">'.
                    _('Ajouter une demande').'</span>',
          'ordre' => 20,
);

// Action du contenu : aucune
$tab_actions['content'] = null;

/**
 * OPTIONS - ADVSEARCH
 */
//
$champs = array();
//
$champs['dossier'] = array(
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
    'taille' => '',
    'max' => '',
);
//
$champs['arrondissement'] = array(
    'colonne' => 'arrondissement',
    'table' => 'dossier_autorisation',
    'libelle' => _('arrondissement'),
    'type' => 'select',
);
//
$champs['dossier_autorisation_type_detaille'] = array(
    'table' => 'dossier_autorisation',
    'colonne' => 'dossier_autorisation_type_detaille',
    'type' => 'select',
    'libelle' => _('nature_dossier'),
);
//
$champs['depot_initial'] = array(
    'colonne' => 'date_depot',
    'table' => 'dossier',
    'libelle' => _('date_depot'),
    'type' => 'date',
    'where' => 'intervaldate',
    'taille' => '',
);
//
$champs['etat'] = array(
    'table' => 'dossier',
    'colonne' => 'etat',
    'type' => 'select',
    'subtype' => 'sqlselect',
    'sql' => 'SELECT etat, libelle FROM '.DB_PREFIXE.'etat WHERE
                etat.statut = \'encours\' OR etat.etat = \'accepter\' OR 
                etat.etat = \'accepte_tacite\'
                ORDER BY etat.libelle, etat.etat',
    'libelle' => _('etat'),
);
// advsearch -> options
$options[] =  array(
    'type' => 'search',
    'display' => true,
    'advanced' => $champs,
    'absolute_object' => 'dossier',
);

/**
 * OPTIONS
 */
// Suppression de l'affichage du sélecteur de pages
$options[] = array(
    'type' => 'pagination_select',
    'display' => '');

$sousformulaire = array();


// Ajout de la gestion des groupes et confidentialité à la requête du listing
$sqlFiltreGroup = $this->get_sql_filtre_groupe($table.$selection);
$selection .= $sqlFiltreGroup['WHERE'];
$table .= $sqlFiltreGroup['FROM'];
// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];

?>
