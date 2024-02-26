<?php
//$Id: dossier_autorisation.inc.php 6197 2016-03-17 13:26:06Z jymadier $ 
//gen openMairie le 14/11/2012 12:54

include('../gen/sql/pgsql/dossier_autorisation.inc.php');

$ent = _("autorisation")." -> "._("dossiers d'autorisation");

/*Tables sur lesquels la requête va s'effectuer*/
$table = DB_PREFIXE."dossier_autorisation
    LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_dossier_autorisation_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_dossier_autorisation_demandeur.demandeur
        WHERE lien_dossier_autorisation_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
    ) as demandeur
         ON dossier_autorisation.dossier_autorisation=demandeur.dossier_autorisation
    LEFT OUTER JOIN ".DB_PREFIXE."om_collectivite
        ON om_collectivite.om_collectivite = dossier_autorisation.om_collectivite
    LEFT OUTER JOIN ".DB_PREFIXE."avis_decision
        ON dossier_autorisation.avis_decision=avis_decision.avis_decision 
    LEFT OUTER JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille 
        ON dossier_autorisation.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
    INNER JOIN ".DB_PREFIXE."dossier_autorisation_type 
        ON dossier_autorisation_type_detaille.dossier_autorisation_type=dossier_autorisation_type.dossier_autorisation_type
            AND dossier_autorisation_type.cacher_da IS FALSE
    LEFT OUTER JOIN ".DB_PREFIXE."etat_dossier_autorisation as etat_dossier_autorisation4
        ON dossier_autorisation.etat_dernier_dossier_instruction_accepte=etat_dossier_autorisation4.etat_dossier_autorisation 
    LEFT OUTER JOIN ".DB_PREFIXE."etat_dossier_autorisation as etat_dossier_autorisation5
        ON dossier_autorisation.etat_dossier_autorisation=etat_dossier_autorisation5.etat_dossier_autorisation
    LEFT OUTER JOIN ".DB_PREFIXE."arrondissement
        ON arrondissement.arrondissement=dossier_autorisation.arrondissement
    LEFT OUTER JOIN ".DB_PREFIXE."etat_dossier_autorisation as eda
        ON dossier_autorisation.etat_dossier_autorisation = eda.etat_dossier_autorisation
    LEFT OUTER JOIN ".DB_PREFIXE."etat_dossier_autorisation as edda
        ON dossier_autorisation.etat_dernier_dossier_instruction_accepte = edda.etat_dossier_autorisation
    LEFT OUTER JOIN ".DB_PREFIXE."etat_dossier_autorisation
        ON CASE WHEN etat_dernier_dossier_instruction_accepte IS NULL
            THEN dossier_autorisation.etat_dossier_autorisation = etat_dossier_autorisation.etat_dossier_autorisation
            ELSE dossier_autorisation.etat_dernier_dossier_instruction_accepte = etat_dossier_autorisation.etat_dossier_autorisation
        END";

if ($f->is_option_dossier_commune_enabled()) {
    $table .= "
        LEFT OUTER JOIN ".DB_PREFIXE."commune
            ON commune.commune = dossier_autorisation.commune";
} else {
    // Suppression du champ commune de la requête lorsque l'option dossier commune est désactivé
    unset($champRecherche[array_search('commune.libelle as "'.__("commune").'"', $champRecherche)]);
}

//
$case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
END";

$case_etat = "CASE WHEN etat_dernier_dossier_instruction_accepte IS NULL
    THEN eda.libelle
    ELSE edda.libelle
END";
        
/*Liste des champs affichés dans le tableau de résultat*/
$champAffiche = array(
    'dossier_autorisation.dossier_autorisation as "'._("dossier").'"',
    'dossier_autorisation.dossier_autorisation_libelle as "'._("dossier").'"'
);
if ($f->is_option_dossier_commune_enabled()) {
    $champAffiche[] = 'commune.libelle as "'._("commune").'"';
}
array_push($champAffiche,
    $case_demandeur.' as "'._("nom du demandeur").'"',
    'TRIM(
        CASE
            WHEN dossier_autorisation.adresse_normalisee IS NULL
                OR TRIM(dossier_autorisation.adresse_normalisee) = \'\'
            THEN
                '.DB_PREFIXE.'adresse(
                    dossier_autorisation.terrain_adresse_voie_numero::text,
                    dossier_autorisation.terrain_adresse_voie::text,
                    \'\'::text,
                    dossier_autorisation.terrain_adresse_lieu_dit::text,
                    dossier_autorisation.terrain_adresse_bp::text,
                    dossier_autorisation.terrain_adresse_code_postal::text,
                    dossier_autorisation.terrain_adresse_localite::text,
                    dossier_autorisation.terrain_adresse_cedex::text,
                    \'\'::text,
                    \' \'::text
                )
            ELSE
                dossier_autorisation.adresse_normalisee
        END
    ) as "'._("localisation").'"',
    'dossier_autorisation_type_detaille.libelle as "'._("type").'"',
    'to_char(dossier_autorisation.depot_initial ,\'DD/MM/YYYY\') as "'._("date de premier depot").'"',
    'to_char(dossier_autorisation.date_decision ,\'DD/MM/YYYY\') as "'._("date de decision").'"',
    $case_etat.' as "'._("etat").'"'
    );

// /*Tri*/
// $tri=" GROUP BY dossier_autorisation.dossier_autorisation, demandeur.qualite, 
//           demandeur.particulier_nom, demandeur.particulier_prenom, 
//           demandeur.personne_morale_raison_sociale, 
//           demandeur.personne_morale_denomination, 
//           dossier_autorisation_type_detaille.code, dossier.date_decision,
//           eda.libelle, edda.libelle
//        ORDER BY dossier_autorisation.dossier_autorisation ASC NULLS LAST ";
$tri=" ORDER BY dossier_autorisation.dossier_autorisation ASC NULLS LAST ";

//$selection = "WHERE dossier.date_decision = (SELECT MIN(dossier.date_decision) FROM ".DB_PREFIXE."dossier WHERE dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation)";

/*Ordre*/
$edition="dossier_autorisation";

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
$champs = array();
//
$champs['dossier'] = array(
    'libelle' => _('dossier'),
    'type' => 'text',
    'table' => 'dossier_autorisation',
    'colonne' => array(
        'dossier_autorisation_libelle', 
        'dossier_autorisation',
    ),
    'taille' => 30,
    'max' => '',
);
//
$champs['dossier_autorisation_type_detaille'] = array(
    'colonne' => 'dossier_autorisation_type_detaille',
    'table' => 'dossier_autorisation_type_detaille',
    'libelle' => _('Type'),
    'type' => 'select',
    'subtype' => 'sqlselect',
    'sql' => "
        SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille,
            dossier_autorisation_type_detaille.libelle
        FROM " . DB_PREFIXE ."dossier_autorisation_type_detaille 
        INNER JOIN " . DB_PREFIXE ."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type
            = dossier_autorisation_type.dossier_autorisation_type
        WHERE dossier_autorisation_type.cacher_da IS FALSE
        ORDER BY dossier_autorisation_type_detaille.libelle"
);
if ($f->is_option_dossier_commune_enabled()) {
    $champs['commune'] = array(
        'type' => 'text',
        'table' => 'commune',
        'colonne' => array(
            'libelle',
            'com',
            'dep',
            'reg'
        ),
        'taille' => 30,
        'max' => '',
        'libelle' => __('commune'),
    );
}
//
$champs['petitionnaire'] = array(
    'libelle' => _('nom du demandeur'),
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
$champs['parcelle'] = array(
    'table' => 'dossier_autorisation_parcelle',
    'help' => __("Attention, il est possible que la section soit sur 1 ou 2 caractères, dans le cas où la parcelle saisie contient la section sur un seul caractère, il est conseillé d'ajouter une '*' avant la section.
        Exemple : '000*A0126'"),
    'where' => 'injoin',
    'tablejoin' => 'INNER JOIN (
            SELECT DISTINCT dossier_autorisation 
            FROM '.DB_PREFIXE.'dossier_autorisation_parcelle 
            WHERE lower(dossier_autorisation_parcelle.libelle) like %s ) 
        AS A1 
      ON A1.dossier_autorisation = dossier_autorisation.dossier_autorisation' ,
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
    'table' => 'dossier_autorisation',
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
$champs['arrondissement'] = array(
    'colonne' => 'arrondissement',
    'table' => 'dossier_autorisation',
    'libelle' => _('arrondissement'),
    'type' => 'select',
);
//
$champs['etat_dossier_autorisation'] = array(
    'colonne' => 'etat_dossier_autorisation',
    'table' => 'etat_dossier_autorisation',
    'libelle' => _('etat'),
    'type' => 'select',
);
//
$champs['depot_initial'] = array(
    'colonne' => 'date_depot',
    'table' => 'dossier_autorisation',
    'libelle' => _('date de premier depot'),
    'type' => 'date',
    'taille' => 8,
    'where' => 'intervaldate',
);
//
$champs['date_decision'] = array(
    'colonne' => 'date_decision',
    'table' => 'dossier_autorisation',
    'libelle' => _('date de decision'),
    'type' => 'date',
    'taille' => 8,
    'where' => 'intervaldate',
);
// advsearch -> options
$options[] = array(
    'type' => 'search',
    'display' => true,
    'advanced' => $champs,
    'default_form'  => 'advanced',
    'absolute_object' => 'dossier_autorisation',
);

/**
 * OPTIONS
 */
//
$options[] = array(
    'type' => 'pagination_select',
    'display' => '');

//Lien vers le script spécifique de visualisation
if(!isset($advs_id)) {
    $advs_id = "";
}
// Action ajouter
$tab_actions['corner']["ajouter"] = 
    array('lien' => ''.OM_ROUTE_FORM.'&obj=demande_nouveau_dossier&amp;action=0&amp;idx=',
          'id' => '&amp;premier='.$premier.'&amp;tricol='.$tricol.'&amp;advs_id='.$advs_id,
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix add-16" title="'._('Ajouter').'">'._('Ajouter').'</span>',
          'rights' => array('list' => array('demande_nouveau_dossier', 'demande_nouveau_dossier_ajouter'), 'operator' => 'OR'),
          'ordre' => 10,
          'ajax' => false
        );

$tab_actions['content'] = 
    array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_autorisation&action=3&idx=',
          'id' => '&amp;premier='.$premier.'&amp;tricol='.$tricol.'&amp;advs_id='.$advs_id,
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
          'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
          'ordre' => 10,);

// Actions a gauche : consulter 
$tab_actions['left']['consulter'] =$tab_actions['content'];

//Cas du dossier d'autorisation en sous-formulaire du dossier d'instruction
if ( $this->contexte_dossier_instruction() OR
     $retourformulaire == "dossier_qualifier_qualificateur" OR
     $retourformulaire == "dossier_autorisation"){

    $champAffiche = array(
      'dossier_autorisation.dossier_autorisation as "'._("dossier_autorisation").'"',
      'dossier_autorisation.dossier_autorisation_libelle as "'._("dossier_autorisation").'"',
      'to_char(dossier_autorisation.depot_initial ,\'DD/MM/YYYY\') as "'._("date_depot_initial").'"',
      $case_etat.' as "'._("etat").'"',
    );
    
    $table = DB_PREFIXE.'dossier_autorisation
            LEFT JOIN '.DB_PREFIXE.'dossier
              ON dossier.dossier_autorisation=dossier_autorisation.dossier_autorisation
            LEFT JOIN '.DB_PREFIXE.'etat_dossier_autorisation as eda
              ON dossier_autorisation.etat_dossier_autorisation = eda.etat_dossier_autorisation
            LEFT JOIN '.DB_PREFIXE.'etat_dossier_autorisation as edda
              ON dossier_autorisation.etat_dernier_dossier_instruction_accepte = edda.etat_dossier_autorisation
            LEFT JOIN '.DB_PREFIXE.'dossier_autorisation_type_detaille 
                ON dossier_autorisation.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            LEFT JOIN '.DB_PREFIXE.'dossier_autorisation_type 
                ON dossier_autorisation_type_detaille.dossier_autorisation_type=dossier_autorisation_type.dossier_autorisation_type
                    AND dossier_autorisation_type.cacher_da IS FALSE
            ';
            
    $selection = 'WHERE dossier.dossier=\''.$f->db->escapeSimple($idxformulaire).'\'';
        
    $tri = "";
    
    // On met la ligne en couleur selon le type de condition
    $options[] = array(
        "type" => "condition",
        "field" => "'Autorisation'",
        "case" => array(
           array(
                "values" => array(_("Autorisation"), ),
                "style" => "tabDADI",
                
            ),
        ),
    );
    
    // Suppression du bouton d'ajout
    $tab_actions['corner']['ajouter'] = NULL;

    // Suppression de l'ouverture en AJAX de la vue consulter
    $tab_actions['left']["consulter"] = 
        array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_autorisation&action=3&idx=',
              'id' => '&amp;premier='.$premier.'&amp;tricol='.$tricol.'&retour='.$idxformulaire.'&retourformulaire='.$retourformulaire,
              'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
              'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
              'ordre' => 10,
              'ajax' => false
            );

    $tab_actions['content'] = $tab_actions['left']["consulter"];
    //Suppression de l'affichage
    $options[] = array(
        'type' => 'pagination_select',
        'display' => '');
}

/* Gestion des onglets */

$sousformulaire = array();
$sousformulaire_parameters = array();

// Vérification du droit de lister les documents numérisés pour l'utilisateur connecté
if ($f->isAccredited("document_numerise") || $f->isAccredited(array("dossier_autorisation", "dossier_autorisation_document_numerise"), "OR")) {
    $sousformulaire[] = "document_numerise";
    // On modifie le lien du paramètre
    $sousformulaire_parameters["document_numerise"] = array(
        "title" => _("Pièces & documents"),
        "href" => "".OM_ROUTE_FORM."&obj=dossier_autorisation&action=4&idx=".((isset($idx))?$idx:"")."&retourformulaire=".((isset($_GET['obj']))?$_GET['obj']:"")."&",
    );
}

// Vérification du droit de lister les DI pour l'utilisateur connecté
if ($f->isAccredited(array("dossier_instruction", "dossier_instruction_tab"), "OR")) {
    // On modifie le lien du paramètre
    if ($retourformulaire == "dossier_autorisation_avis") {
        $sousformulaire[] = "dossier_autorisation_avis";
        $sousformulaire_parameters["dossier_autorisation_avis"] = array(
            "title" => _("Dossiers d'instruction"),
        );
    } else {
        $sousformulaire[] = "dossier_instruction";
        $sousformulaire_parameters["dossier_instruction"] = array(
            "title" => _("Dossiers d'instruction"),
        );
    }
}

// Gestion des groupes et confidentialité
include('../sql/pgsql/filter_group.inc.php');

?>
