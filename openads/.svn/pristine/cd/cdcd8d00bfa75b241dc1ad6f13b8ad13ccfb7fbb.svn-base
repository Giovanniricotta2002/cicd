<?php
/**
 * @package openfoncier
 * @version SVN : $id$
 **/

//
include('../sql/pgsql/dossier_instruction.inc.php');

//
$ent = _("guichet unique")." -> ". _("nouvelle demande")." -> "._("autre dossier");
$tab_title = _("demande");

//Suppression de l'action ajouter
$tab_actions['corner']['ajouter'] = NULL;
// Actions a gauche : consulter 
$tab_actions['left']['consulter'] =
    array('lien' => ''.OM_ROUTE_FORM.'&obj=demande_autre_dossier&amp;action=0&amp;idx_dossier=',
          'id' => '&amp;premier='.$premier.'&amp;advs_id='.$advs_id.'&amp;tricol='.$tricol.'&amp;valide='.$valide,
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix add-16" title="'._('Ajouter une demande').'">'.
                    _('Ajouter une demande').'</span>',
          'ordre' => 20,);

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

/*Fin rechercher avancée*/

$sousformulaire = array();
?>