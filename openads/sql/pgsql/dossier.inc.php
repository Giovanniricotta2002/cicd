<?php
//$Id: dossier.inc.php 5232 2015-09-30 10:41:34Z stimezouaght $ 
//gen openMairie le 10/02/2011 20:39 
include('../gen/sql/pgsql/dossier.inc.php');

if (isset($_GET['message_help'])
    && ! is_null($_GET['message_help'])
    && $_GET['message_help'] != "") {

    $tab_description = $_GET['message_help'];
}


/*Tables sur lesquels la requête va s'effectuer*/
$table = DB_PREFIXE."dossier
LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_dossier_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
    ) as demandeur
         ON demandeur.dossier = dossier.dossier
LEFT JOIN ".DB_PREFIXE."instructeur
    ON dossier.instructeur = instructeur.instructeur
LEFT JOIN ".DB_PREFIXE."om_utilisateur
    ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
LEFT JOIN ".DB_PREFIXE."avis_decision
    ON avis_decision.avis_decision=dossier.avis_decision
LEFT JOIN ".DB_PREFIXE."division
    ON dossier.division=division.division
LEFT JOIN ".DB_PREFIXE."etat
    ON dossier.etat=etat.etat";
if ($f->is_option_dossier_commune_enabled()) {
    $table .= "
        LEFT JOIN ".DB_PREFIXE."commune
            ON commune.commune = dossier.commune
    ";
}

/*Champs du début de la requête*/
$champAffiche = array(
    'dossier.dossier as "'._("dossier").'"'
);
if ($f->is_option_dossier_commune_enabled()) {
    $champAffiche[] = 'commune.libelle as "'.__("commune").'"';
}
array_push($champAffiche,
    'TRIM(CONCAT(personne_morale_denomination,\' \',personne_morale_nom,\' \',demandeur.particulier_nom)) as "'._("petitionaire").'"',
    'instructeur.nom as "'._("instructeur").'"',
    'to_char(dossier.date_demande ,\'DD/MM/YYYY\') as "'._("date_demande").'"',
    'dossier.date_dernier_depot as "'._("date_dernier_depot").'"',
    'to_char(dossier.date_complet ,\'DD/MM/YYYY\') as "'._("date_complet").'"',
    'to_char(dossier.date_notification_delai ,\'DD/MM/YYYY\') as "'._("date_notification_delai").'"',
    'to_char(dossier.date_limite ,\'DD/MM/YYYY\') as "'._("date_limite").'"',
    'etat as "'._("etat").'"',
    'avis_decision.libelle as "'._("avis_decision").'"',
    'CASE WHEN dossier.enjeu_erp is TRUE THEN \'<span class="om-icon om-icon-16 om-icon-fix enjeu_erp-16" title="'._('Enjeu ERP').'">ERP</span>\' ELSE \'\' END ||
     CASE WHEN dossier.enjeu_urba is TRUE THEN \'<span class="om-icon om-icon-16 om-icon-fix enjeu_urba-16" title="'._('Enjeu Urba').'">URBA</span>\' ELSE \'\' END
     as "'._("enjeu").'"'
);

/*Tri*/
$triOrder= "order by dossier.dossier";
$tri = $triOrder;

/*Recherche simple*/
$champRecherche = array(
    'dossier.dossier as "'.__("dossier").'"',
    'personne_morale_denomination as "'.__("personne_morale_denomination").'"',
    'particulier_nom as "'.__("particulier_nom").'"',
    'instructeur.nom as "'.__("instructeur").'"',
    'instructeur_secondaire.nom as "'.__("instructeur secondaire").'"',
);
if ($f->is_option_dossier_commune_enabled()) {
    $champRecherche[] = 'commune.libelle as "'.__("commune").'"';
}

$edition="";

/**
 * OPTIONS
 */
//
if (!isset($options)) {
    $options = array();
}

/*Si l'on se trouve dans le formulaire dossier_instruction*/
if (isset($_GET["obj"]) && $_GET["obj"] == "dossier_instruction") {
    /**
     * OPTIONS - ADVSEARCH
     */
    // Options pour les select de faux booléens
    $args = array(
        0 => array("", "Oui", "Non", ),
        1 => array(_("choisir")." "._("accord_tacite"), _("Oui"), _("Non"), ),
    );
    $contenu_statut = array(
        0 => array("", 'cloture', 'encours',),
        1 => array(_("choisir")." "._("statut"), _('Cloture'), _('En cours'),)
    );
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
    // On ignore les DATD contentieux
    $champs['dossier_autorisation_type_detaille'] = array(
        'table' => 'dossier_autorisation_type_detaille',
        'colonne' => 'dossier_autorisation_type_detaille',
        'type' => 'select',
        'taille' => 30,
        'max' => '',
        'libelle' => _('type'),
        'subtype' => 'sqlselect',
        'sql' => "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, dossier_autorisation_type_detaille.libelle
            FROM ".DB_PREFIXE."dossier_autorisation_type_detaille 
            WHERE (LOWER(dossier_autorisation_type_detaille.code) != LOWER('REC')
                AND LOWER(dossier_autorisation_type_detaille.code) != LOWER('REG')
                AND LOWER(dossier_autorisation_type_detaille.code) != LOWER('IN'))
            ORDER BY libelle",
    );
    //
    $champs['particulier'] = array(
        'libelle' => _('Demandeur'),
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
    $champs['famille_travaux'] = array(
        'table' => 'lien_dossier_nature_travaux',
        'type' => 'select',
        'libelle' => __('Famille de travaux'),
        'subtype' => 'sqlselect',
        'where' => 'injoin',
        'tablejoin' => 'INNER JOIN (SELECT DISTINCT dossier FROM '.DB_PREFIXE.'lien_dossier_nature_travaux INNER JOIN '.DB_PREFIXE.'nature_travaux ON  lien_dossier_nature_travaux.nature_travaux = nature_travaux.nature_travaux INNER JOIN '.DB_PREFIXE.'famille_travaux ON nature_travaux.famille_travaux = famille_travaux.famille_travaux WHERE nature_travaux.famille_travaux =  %d ) AS ldntft ON ldntft.dossier = dossier.dossier',
        'sql' => "SELECT DISTINCT famille_travaux.famille_travaux, famille_travaux.libelle FROM ".DB_PREFIXE."famille_travaux",
    );
    //
    $champs['nature_travaux'] = array(
        'table' => 'lien_dossier_nature_travaux',
        'type' => 'select',
        'libelle' => __('Nature de travaux'),
        'subtype' => 'sqlselect',
        'where' => 'injoin',
        'tablejoin' => 'INNER JOIN (SELECT DISTINCT dossier FROM '.DB_PREFIXE.'lien_dossier_nature_travaux WHERE lien_dossier_nature_travaux.nature_travaux = %d ) AS ldnt ON ldnt.dossier = dossier.dossier',
        'sql' => "SELECT DISTINCT nature_travaux.nature_travaux, nature_travaux.libelle FROM ".DB_PREFIXE."nature_travaux ORDER BY nature_travaux",
    );
    //
    $champs['etat'] = array(
        'table' => 'dossier',
        'colonne' => 'etat',
        'type' => 'select',
        'libelle' => _('etat'),
    );
    //
    $champs['statut'] = array(
        'table' => 'etat',
        'colonne' => 'statut',
        'type' => 'select',
        'libelle' => _('statut'),
        'subtype' => 'manualselect',
        'args' => $contenu_statut
    );
    //
    if ($f->is_option_mode_service_consulte_enabled() === false) {
        $champs['accord_tacite'] = array(
            'table' => 'dossier',
            'colonne' => 'accord_tacite',
            'type' => 'select',
            "subtype" => "manualselect",
            'libelle' => _('accord_tacite'),
            "args" => $args,
        );
    }


    //
    $champs['division'] = array(
        'table' => 'dossier',
        'colonne' => 'division',
        'type' => 'select',
        'libelle' => __('division'),
    );
    if ($_SESSION['niveau'] == '2') {
        $champs['division']['subtype'] = 'sqlselect';
        $champs['division']['sql'] = "SELECT division.division, CONCAT(division.libelle, ' (', om_collectivite.libelle, ')')
FROM ".DB_PREFIXE."division
INNER JOIN ".DB_PREFIXE."direction ON division.direction = direction.direction
INNER JOIN ".DB_PREFIXE."om_collectivite ON direction.om_collectivite = om_collectivite.om_collectivite
WHERE ((division.om_validite_debut IS NULL AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)) OR (division.om_validite_debut <= CURRENT_DATE AND (division.om_validite_fin IS NULL OR division.om_validite_fin > CURRENT_DATE)))
ORDER BY division.libelle";
    }

    $args_source_depot = array(
        //
        0 => array("", "app", PLATAU, PORTAL),
        1 => array(_("choisir")." ".__("source_depot"), __("app"), __("platau"), __("portal")),
    );

    //
    $champs['source_depot'] = array(
        'table' => 'demande',
        'colonne' => 'source_depot',
        'type' => 'select',
        'libelle' => __('source_depot'),
        'subtype' => 'manualselect',
        'args' => $args_source_depot
    );

    //
    $champs['instructeur'] = array(
        'table' => 'dossier',
        'colonne' => 'instructeur',
        'type' => 'select',
        'libelle' => _('instructeur'),
    );
    //
    if ($_SESSION['niveau'] == '2') {
        $champs['instructeur']['subtype'] = 'sqlselect';
        $champs['instructeur']['sql'] = "SELECT instructeur.instructeur, instructeur.nom||' ('||division.code||')' 
FROM ".DB_PREFIXE."instructeur 
INNER JOIN ".DB_PREFIXE."division ON division.division=instructeur.division
WHERE ((instructeur.om_validite_debut IS NULL AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)) OR (instructeur.om_validite_debut <= CURRENT_DATE AND (instructeur.om_validite_fin IS NULL OR instructeur.om_validite_fin > CURRENT_DATE)))
ORDER BY nom";
    }
    //
    $champs['instructeur_2'] = array(
        'table' => 'dossier',
        'colonne' => 'instructeur_2',
        'type' => 'select',
        'libelle' => __('instructeur secondaire'),
    );
    //
    if ($_SESSION['niveau'] == '2') {
        $champs['instructeur_2']['subtype'] = 'sqlselect';
        $champs['instructeur_2']['sql'] = sprintf(
            'SELECT
                instructeur.instructeur,
                instructeur.nom||\' (\'||division.code||\')\' 
            FROM
                %1$sdossier
                INNER JOIN %1$sinstructeur
                    ON dossier.instructeur_2 = instructeur.instructeur
                INNER JOIN %1$sdivision
                    ON division.division = instructeur.division
            GROUP BY
                instructeur.instructeur,
                division.code
            ORDER BY
                instructeur.nom',
            DB_PREFIXE
        );
    }
    $champs['date_depot'] = array(
        'colonne' => 'date_depot',
        'table' => 'dossier',
        'libelle' => _('date_depot'),
        'lib1'=> _("debut"),
        'lib2' => _("fin"),
        'type' => 'date',
        'taille' => 8,
        'where' => 'intervaldate',
    );
    //
    if ($f->is_option_date_depot_mairie_enabled() === true) {
        $champs['date_depot_mairie'] = array(
            'colonne' => 'date_depot_mairie',
            'table' => 'dossier',
            'libelle' => _('date_depot_mairie'),
            'lib1'=> _("debut"),
            'lib2' => _("fin"),
            'type' => 'date',
            'taille' => 8,
            'where' => 'intervaldate',
        );
    }
    //
    if ($f->is_option_mode_service_consulte_enabled() === false) {
        $champs['date_rejet'] = array(
            'colonne' => 'date_rejet',
            'table' => 'dossier',
            'libelle' => _('date_rejet'),
            'lib1'=> _("debut"),
            'lib2' => _("fin"),
            'type' => 'date',
            'taille' => 8,
            'where' => 'intervaldate',
        );

        $champs['date_validite'] = array(
            'colonne' => 'date_validite',
            'table' => 'dossier',
            'libelle' => _('date_validite'),
            'lib1'=> _("debut"),
            'lib2' => _("fin"),
            'type' => 'date',
            'taille' => 8,
            'where' => 'intervaldate',
            );
    }
    //
    $champs['date_complet'] = array(
        'colonne' => 'date_complet',
        'table' => 'dossier',
        'libelle' => _('date_complet'),
        'lib1'=> _("debut"),
        'lib2' => _("fin"),
        'type' => 'date',
        'taille' => 8,
        'where' => 'intervaldate',
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
    $champs['date_limite'] = array(
        'colonne' => 'date_limite',
        'table' => 'dossier',
        'libelle' => _('date_limite'),
        'lib1'=> _("debut"),
        'lib2' => _("fin"),
        'type' => 'date',
        'taille' => 8,
        'where' => 'intervaldate',
    );
    //
    if ($f->is_option_mode_service_consulte_enabled() === false) {
        $champs['date_chantier'] = array(
            'colonne' => 'date_chantier',
            'table' => 'dossier',
            'libelle' => _('date_chantier'),
            'lib1'=> _("debut"),
            'lib2' => _("fin"),
            'type' => 'date',
            'taille' => 8,
            'where' => 'intervaldate',
        );

        $champs['date_achevement'] = array(
            'colonne' => 'date_achevement',
            'table' => 'dossier',
            'libelle' => _('date_achevement'),
            'lib1'=> _("debut"),
            'lib2' => _("fin"),
            'type' => 'date',
            'taille' => 8,
            'where' => 'intervaldate',
        );

        $champs['date_conformite'] = array(
            'colonne' => 'date_conformite',
            'table' => 'dossier',
            'libelle' => _('date_conformite'),
            'lib1'=> _("debut"),
            'lib2' => _("fin"),
            'type' => 'date',
            'taille' => 8,
            'where' => 'intervaldate',
        );
    }
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
}

$retourformulaire = (isset($_GET['retourformulaire']) ? $_GET['retourformulaire'] : "");

// On change l'ordre d'affichage des onglets
$sousformulaire=array();
// Affichage de l'onglet acteur uniquement si l'utilisateur à les permissions nécessaire
// et si l'option de paramétrage de la notification automatique des tiers est active
if ($f->isAccredited(array("lien_dossier_tiers", "lien_dossier_tiers_tab"), "OR")
    && $f->is_option_enabled('option_module_acteur')) {
    $sousformulaire[] = "lien_dossier_tiers";
}
$sousformulaire[] = "dossier_contrainte";
$sousformulaire[] = "instruction";
// Ajout d'une permission en plus pour afficher cette onglet afin de faciliter
// l'utilisation de son contenu dans le contexte des demandes d'avis
if ($f->isAccredited(array("consultation", "consultation_tab_di"), "OR")) {
    //
    $sousformulaire[] = "consultation";
}
$sousformulaire[] = "dossier_commission";
$sousformulaire[] = "lot";
$sousformulaire[] = "dossier_message";
$sousformulaire[] = "blocnote";
//
if ($f->isAccredited("document_numerise") || $f->isAccredited(array("dossier", "dossier_document_numerise"), "OR")) {
    $sousformulaire[] = "document_numerise";
}
// Vérifie si le mode service consulté et actif et si l'utilisateur à la permission
// d'accéder au sous-dossier
if ($f->is_option_mode_service_consulte_enabled() === true &&
    $f->isAccredited(array("sous_dossier", "sous_dossier_consulter", ""), "OR")) {
    $sousformulaire[] = "sous_dossier";
}
$sousformulaire[] = "lien_dossier_dossier";
/*Ajout de paramètre à certains sous-formulaire*/
// Défini si on doit faire appel au dossier ou au sous-dossier selon le contexte.
// Par défaut, on fait appel au dossier sauf si l'obj issus de l'url est sous-dossier.
// Important car c'est cette classe qui va permettre de faire appel aux surcharges des
// sous-dossier, notamment pour l'affichage des onglets document numérisé et contrainte
$idx = isset($idx) ? $idx : '';
$getObj = isset($_GET['obj']) ? $_GET['obj'] : '';
// Récupération du contexte du widget pour gérer la redirection vers le listing
// du widget dans le contexte des sous-dossiers
$cplmtUrlWidget = '';
$retourWidget = $f->get_submitted_get_value('retour_widget');
$widgetRechercheId = $f->get_submitted_get_value('widget_recherche_id');
if (! empty($retourWidget) && !empty($widgetRechercheId)) {
    $cplmtUrlWidget = '&retour_widget='.$retourWidget.
        '&widget_recherche_id='.$widgetRechercheId;
}

$sousformulaire_parameters = array(
    "consultation" => array(
        "title" => __("consultation(s)"),
    ),
    "dossier_message" => array(
        "title" => __("message(s)"),
    ),
    "dossier_commission" => array(
        "title" => __("commission(s)"),
    ),
    "lot" => array(
        "title" => __("lot(s)"),
    ),
    "lien_dossier_dossier" => array(
        "title" => __("Dossiers liés"),
        "href" => OM_ROUTE_FORM."&obj=lien_dossier_dossier&action=4&idx=0&idxformulaire=".$idx.
            "&retourformulaire=".$retourformulaire."&contentonly=true&",
    ),
    "dossier_contrainte" => array(
        "title" => _("Contrainte(s)"),
        "href" => OM_ROUTE_FORM."&obj=dossier&action=4&idx=".$idx."&retourformulaire=".$getObj."&",
    ),
    "document_numerise" => null,
);

//
if ($f->isAccredited("document_numerise") || $f->isAccredited(array("dossier", "dossier_document_numerise"), "OR")) {
    //
    $sousformulaire_parameters["document_numerise"] = array(
        "title" => _("Pièces & documents"),
        "href" => OM_ROUTE_FORM."&obj=dossier&action=5&idx=".$idx."&retourformulaire=".$getObj."&",
    );
}

// Affichage de l'onglet acteur uniquement si l'utilisateur à les permissions nécessaire
if ($f->isAccredited(array("lien_dossier_tiers", "lien_dossier_tiers_tab"), "OR")
    && $f->is_option_enabled('option_module_acteur')) {
    $sousformulaire_parameters["lien_dossier_tiers"] = array(
        "title" => __("Acteur(s)"),
        "href" => OM_ROUTE_FORM."&obj=lien_dossier_tiers&action=4&idx=".$idx."&retourformulaire=".$getObj."&",
    );
}

// Vérifie si le mode service consulté et actif et si l'utilisateur à la permission
// d'accéder au sous-dossier
if ($f->is_option_mode_service_consulte_enabled() === true &&
    $f->isAccredited(array("sous_dossier", "sous_dossier_consulter", ""), "OR")) {
        $sousformulaire_parameters["sous_dossier"] = array(
            "title" => __("Sous-dossiers"),
            "href" => OM_ROUTE_FORM."&obj=sous_dossier&action=7&idx=0&idxformulaire=".
                '&advs_id_parent='.$f->get_submitted_get_value('advs_id').'&'.$idx.$cplmtUrlWidget.
                "&retourformulaire=".$retourformulaire."&contentonly=true&",
        );
}

/**
* Options
*/
// Marque la ligne si le dossier n'a pas été géolocalisé.
// Nécessite que la seconde colonne des tableaux soit le geom.
// Dans la variable $champAffiche en seconde position mettre 'dossier.geom as "geom_picto"',
$options[] = array(
    "type" => "condition",
    "field" => 'dossier.geom',
    "case" => array(
        1 => array( // column key for dossier.geom (geom_picto)
            "values" => array(''), // style only empty values
            "style" => "no-geoloc")));
// Marque la ligne si le dossier à comme source de dépôt portal ou platau.
// Nécessite que la troisième colonne des tableaux soit la source de dépôt de la demande.
// Dans la variable $champAffiche en seconde troisième mettre 'demande.source_depot as "demat_picto"',
$options[] = array(
    "type" => "condition",
    "field" => 'demande.source_depot',
    "case" => array(
        array(
            "values" => array(PORTAL, PLATAU),
            "style" => "consult-demat")));
?>
