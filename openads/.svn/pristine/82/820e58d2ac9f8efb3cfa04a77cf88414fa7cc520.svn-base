<?php
/**
 * @package openads
 * @version SVN : $Id$
 */

//
include "../sql/pgsql/dossier_instruction.inc.php";

//
// COMMON
//

/**
 * Récupération des configurations des requêtes à partir des widgets.
 */
// Composition du tableau de paramètres nécessaire à la méthode qui permet
// de récupérer le configuration de la requête du widget
$params = array();
$params['filtre'] = 'instructeur_ou_instructeur_secondaire';

// Cas des sous_dossier
$objContext = ! empty($objParent) && $obj === 'sous_dossier' ? $objParent : $obj;
//
if ($objContext === 'dossier_contentieux_toutes_infractions'
    || $objContext === 'dossier_contentieux_tous_recours') {
    //
    $params['filtre'] = 'aucun';
}
// Récupère le contexte du contentieux (inf ou rec)
$contexte = '';
if ($objContext === 'dossier_contentieux_toutes_infractions'
    || $objContext === 'dossier_contentieux_mes_infractions') {
    $contexte = 'inf';
} elseif ($objContext === 'dossier_contentieux_tous_recours'
    || $objContext === 'dossier_contentieux_mes_recours') {
    $contexte = 're';
}
//
require_once "../obj/om_widget.class.php";
$om_widget = new om_widget(0);
//
$conf_inf = $om_widget->get_config_dossier_contentieux_infraction($params);
//
$conf_re = $om_widget->get_config_dossier_contentieux_recours($params);

$obj_redirection = "demande_nouveau_dossier_contentieux";
// Si l'utilisateur n'a pas accès au menu Contentieux > Nouvelle demande, on le redirige
// vers le guichet unique
if ($f->isAccredited("demande_nouveau_dossier_contentieux_ajouter") === false) {
    $obj_redirection = "demande_nouveau_dossier";
}

// Actions en coin : ajouter
$tab_actions['corner']['ajouter'] = array(
    'lien' => ''.OM_ROUTE_FORM.'&obj=' . $obj_redirection . '&amp;action=0&amp;advs_id=&amp;tricol=&amp;valide=&amp;retour=tab&amp;new=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix add-16" title="'._('Ajouter').'">'._('Ajouter').'</span>',
    'rights' => array('list' => array($obj_redirection, $obj_redirection . '_ajouter'), 'operator' => 'OR'),
    'ordre' => 10,
);


// Tri par défaut des tableaux contentieux
$tri = " ORDER BY dossier.date_depot DESC, dossier.dossier DESC ";

//
// INFRACTIONS
//

// Jointures necessaires aux infractions
$table_inf = $conf_inf["query_ct_from"];

// Affiche les contrevenants pour les infractions
$case_contrevenant = "
CASE WHEN demandeur_contrevenant.qualite = 'particulier' 
    THEN TRIM(CONCAT(demandeur_contrevenant.particulier_nom, ' ', demandeur_contrevenant.particulier_prenom)) 
    ELSE TRIM(CONCAT(demandeur_contrevenant.personne_morale_raison_sociale, ' ', demandeur_contrevenant.personne_morale_denomination)) 
END
";

// Colonnes affichées sur les tableaux des infractions
$champs_affiche_inf = $conf_inf["query_ct_select_champaffiche"];

// Recherche simple pour les infractions
$champs_recherche_inf = array(
    'dossier.dossier as "'._("Dossier").'"',
    'CONCAT(dossier.terrain_adresse_voie_numero, \' \', dossier.terrain_adresse_voie) as "'._("Localisation (numéro et voie)").'"',
    'dossier.terrain_adresse_code_postal as "'._("Localisation (code postal)").'"',
    'dossier.terrain_adresse_localite as "'._("Localisation (ville)").'"',
    'dossier.adresse_normalisee as "'.__("Adresse normalisée").'"',
);

// Affiche le champ de recherche sur l'arrondissement seulement si l'option est
// activée
if ($f->getParameter('option_arrondissement') === 'true') {
    //
    $champs_recherche_inf = array_merge($champs_recherche_inf, 
        array(
            'arrondissement.libelle as "'._("Arrondissement").'"',
        )
    );
}

// Suite de la recherche simple des infractions
$champs_recherche_inf = array_merge($champs_recherche_inf, 
    array(
        'demandeur_contrevenant.personne_morale_denomination as "'._("Contrevenant personne morale").'"',
        'demandeur_contrevenant.particulier_nom as "'._("Contrevenant particulier").'"',
        'etat.libelle as "'._("État").'"',
        'dossier.numero_versement_archive as "'.__('Numéro d\'archive').'"',
    )
);

// Conditions
$selection_inf = "
WHERE LOWER(dossier_autorisation_type.code) = LOWER('IN')
";

//
// RECOURS
//

// Jointures necessaires aux recours
$table_re = $conf_re["query_ct_from"];

// Affiche les contrevenants pour les recours
$case_requerant = "
CASE WHEN demandeur_requerant.qualite = 'particulier' 
    THEN TRIM(CONCAT(demandeur_requerant.particulier_nom, ' ', demandeur_requerant.particulier_prenom)) 
    ELSE TRIM(CONCAT(demandeur_requerant.personne_morale_raison_sociale, ' ', demandeur_requerant.personne_morale_denomination)) 
END
";

// Colonnes affichées sur les tableaux des recours
$champs_affiche_re = $conf_re["query_ct_select_champaffiche"];

// Recherche simple pour les recours
$champs_recherche_re = array(
    'dossier.dossier as "'._("Dossier").'"',
    'dossier_autorisation_type_detaille.libelle as "'._("Type").'"',
    'dossier_autorisation_contestee.dossier as "'._("Autorisation").'"',
    'demandeur.personne_morale_denomination as "'._("Pétitionnaire dénomination de la personne morale").'"',
    'demandeur.particulier_nom as "'._("Pétitionnaire nom du particulier").'"',
    'CONCAT(dossier.terrain_adresse_voie_numero, \' \', dossier.terrain_adresse_voie) as "'._("Localisation (numéro et voie)").'"',
    'dossier.terrain_adresse_code_postal as "'._("Localisation (code postal)").'"',
    'dossier.terrain_adresse_localite as "'._("Localisation (ville)").'"',
    'dossier.adresse_normalisee as "'.__("Adresse normalisée").'"',
);

// Affiche le champ de recherche sur l'arrondissement seulement si l'option est
// activée
if ($f->getParameter('option_arrondissement') === 'true') {
    //
    $champs_recherche_re = array_merge($champs_recherche_re, 
        array(
            'arrondissement.libelle as "'._("Arrondissement").'"',
        )
    );
}

// Suite de la recherche simple des recours
$champs_recherche_re = array_merge($champs_recherche_re, 
    array(
        'demandeur_requerant.personne_morale_denomination as "'._("Requérant dénomination de la personne morale").'"',
        'demandeur_requerant.particulier_nom as "'._("Requérant nom du particulier").'"',
        'etat.libelle as "'._("État").'"',
        'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("Date de recours").'"',
        'to_char(dossier.date_cloture_instruction ,\'DD/MM/YYYY\') as "'._("Date de clôture d'instruction").'"',
        'avis_decision.libelle as "'._("Décision").'"',
        'to_char(dossier.date_decision ,\'DD/MM/YYYY\') as "'._("Date de décision").'"',
        'donnees_techniques.ctx_reference_dsj as "'._("ctx_reference_dsj").'"',
        'dossier.numero_versement_archive as "'.__('Numéro d\'archive').'"',
    )
);

// Conditions
$selection_re = "
WHERE LOWER(dossier_autorisation_type.code) = LOWER('RE')
";

// Les onglets
$sousformulaire = array(
    "dossier_contrainte_contexte_ctx",
    "instruction_contexte_ctx_".$contexte,
    "dossier_message_contexte_ctx",
    "blocnote_contexte_ctx",
    "document_numerise_contexte_ctx"
);

// Vérifie si le mode service consulté et actif et si l'utilisateur à la permission
// d'accéder au sous-dossier
if ($f->is_option_mode_service_consulte_enabled() === true &&
    $f->isAccredited(array("sous_dossier", "sous_dossier_consulter", ""), "OR")) {
    $sousformulaire[] = "sous_dossier";
}

$sousformulaire[] = "lien_dossier_dossier_contexte_ctx_".$contexte;

/*Ajout de paramètre à certains sous-formulaire*/
$idx = isset($idx) ? $idx : '';
$getObj = isset($_GET['obj']) ? $_GET['obj'] : '';
$sousformulaire_parameters = array(
    "instruction_contexte_ctx_".$contexte => array(
        "title" => _("Instruction"),
    ),
    "dossier_message_contexte_ctx" => array(
        "title" => _("Message(s)"),
    ),
    "blocnote_contexte_ctx" => array(
        "title" => _("Bloc-note"),
    ),
    "lien_dossier_dossier_contexte_ctx_".$contexte => array(
        "title" => _("Dossiers liés"),
        "href" => OM_ROUTE_SOUSFORM.
            "&obj=lien_dossier_dossier_contexte_ctx_".
            $contexte.
            "&action=4&idx=0&idxformulaire=".
            $idx.
            "&retourformulaire=".
            $retourformulaire.
            "&contentonly=true&",
    ),
    "dossier_contrainte_contexte_ctx" => array(
        "title" => _("Contrainte(s)"),
        "href" => OM_ROUTE_FORM.
            "&obj=dossier&action=4&idx=".
            $idx.
            "&retourformulaire=".
            $getObj.
            "&",
    ),
    "document_numerise_contexte_ctx" => array(
        "title" => _("Pièces & documents"),
        "href" => OM_ROUTE_FORM.
            "&obj=dossier&action=5&idx=".
            $idx.
            "&retourformulaire=".
            $getObj.
            "&",
    )
);

// Vérifie si le mode service consulté et actif et si l'utilisateur à la permission
// d'accéder au sous-dossier
if ($f->is_option_mode_service_consulte_enabled() === true &&
    $f->isAccredited(array("sous_dossier", "sous_dossier_consulter", ""), "OR")) {
        $sousformulaire_parameters["sous_dossier"] = array(
            "title" => __("Sous-dossiers"),
            "href" => OM_ROUTE_FORM."&obj=sous_dossier&action=7&idx=0&idxformulaire=".
                '&advs_id_parent='.$f->get_submitted_get_value('advs_id').'&'.$idx.
                "&retourformulaire=".$retourformulaire."&contentonly=true&",
        );
}
// Récupération du sql du filtre
$sqlFiltre = $om_widget->get_query_filter(
    ${'table_'.$contexte}.${'selection_'.$contexte},
    $params['filtre']
);
// Jointures
$table =
    ${'table_'.$contexte}.
    ' '.
    $sqlFiltre['FROM'];

// Affiche seulement les recours où l'utilisateur connecté est affecté
$selection =
    ${'selection_'.$contexte}.
    $sqlFiltre['WHERE'];

// Colonne affichées sur le tableau
$champAffiche =  ${'champs_affiche_'.$contexte};

// Recherche simple
$champRecherche =  ${'champs_recherche_'.$contexte};

// Ajout de la gestion des groupes et confidentialité à la requête du listing
$sqlFiltreGroup = $this->get_sql_filtre_groupe($table.$selection);
$selection .= $sqlFiltreGroup['WHERE'];
$table .= $sqlFiltreGroup['FROM'];
// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];
?>
