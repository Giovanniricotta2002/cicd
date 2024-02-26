<?php
//$Id: demande_avis.inc.php 5422 2015-11-10 17:50:51Z jymadier $ 
include('../sql/pgsql/consultation.inc.php');
include "../sql/pgsql/app_om_tab_common_select.inc.php";

$tab_title = _("Demandes d'avis");
// Titre de la page
$ent = _("Demandes d'avis");
// FROM 
$table = DB_PREFIXE."consultation
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON consultation.dossier=dossier.dossier
    INNER JOIN ".DB_PREFIXE."dossier_instruction_type
        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
    INNER JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
        ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
    -- Récupère le motif de la consultation (concerne uniquement les consultations des tiers)
    LEFT JOIN ".DB_PREFIXE."motif_consultation
        ON motif_consultation.motif_consultation=consultation.motif_consultation
    -- Récupère l utilisateur en charge de la consultation
    LEFT JOIN ".DB_PREFIXE."service
        ON service.service=consultation.service
    LEFT JOIN ".DB_PREFIXE."lien_service_om_utilisateur
        ON lien_service_om_utilisateur.service=service.service
    LEFT JOIN ".DB_PREFIXE."tiers_consulte
        ON tiers_consulte.tiers_consulte=consultation.tiers_consulte
    LEFT JOIN ".DB_PREFIXE."lien_om_utilisateur_tiers_consulte
        ON lien_om_utilisateur_tiers_consulte.tiers_consulte=tiers_consulte.tiers_consulte
    -- Jointure avec la table utilisateur en utilisant le lien entre l'utilisateur et le service
    -- pour les consultations faites à des services ou le lien entre l'utilisateur et le tiers
    -- pour les consultations faites à des tiers
    LEFT JOIN ".DB_PREFIXE."om_utilisateur
        ON om_utilisateur.om_utilisateur=lien_service_om_utilisateur.om_utilisateur
            OR om_utilisateur.om_utilisateur=lien_om_utilisateur_tiers_consulte.om_utilisateur
    LEFT OUTER JOIN ".DB_PREFIXE."avis_consultation 
        ON consultation.avis_consultation=avis_consultation.avis_consultation 
    LEFT JOIN ".DB_PREFIXE."donnees_techniques
        ON donnees_techniques.dossier_instruction = dossier.dossier
    LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_dossier_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
    ) as demandeur
        ON demandeur.dossier=consultation.dossier
    ";
    // XXX LEFT OUTER JOIN pieces_complementaire

// SELECT pour récupérer l'avis rendu de la consultation, à mettre dans une
// varibale pour gérer son unset dans les demandes d'avis en cours
$avis_rendu = 'avis_consultation.libelle as "'._("avis rendu").'"';

// SELECT 
$champAffiche = array(
    'consultation.consultation as "'._("consultation").'"',
    'to_char(consultation.date_limite ,\'DD/MM/YYYY\') as "'._("date_limite").'"',
    $select__dossier_libelle__column_as,
    // date de depots de piece complementaire
    'CONCAT_WS(
        \'<br/>\',
        CASE WHEN donnees_techniques.co_projet_desc = \'\' THEN
            NULL
        ELSE
            TRIM(donnees_techniques.co_projet_desc)
        END,
        CASE WHEN donnees_techniques.ope_proj_desc = \'\' THEN
            NULL
        ELSE
            TRIM(donnees_techniques.ope_proj_desc)
        END,
        CASE WHEN donnees_techniques.am_projet_desc = \'\' THEN
            NULL
        ELSE
            TRIM(donnees_techniques.am_projet_desc)
        END,
        CASE WHEN donnees_techniques.dm_projet_desc = \'\' THEN
            NULL
        ELSE
            TRIM(donnees_techniques.dm_projet_desc)
        END
        ) as "'._("Description du projet").'"',
    'TRIM(
        CASE
            WHEN dossier.adresse_normalisee IS NULL
                OR TRIM(dossier.adresse_normalisee) = \'\'
            THEN
                CONCAT_WS(
                    \' \',
                    dossier.terrain_adresse_voie_numero,
                    dossier.terrain_adresse_voie,
                    dossier.terrain_adresse_code_postal
                )
            ELSE
                dossier.adresse_normalisee
        END
    ) as "'._("Localisation").'"',
    'TRIM(CONCAT(personne_morale_denomination,\' \',personne_morale_nom,\' \',demandeur.particulier_nom)) as "'._("petitionaire").'"',
    '-- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_avt_shon21 IS NOT NULL
        OR su2_avt_shon22 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_cstr_shon21 IS NOT NULL
        OR su2_cstr_shon22 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_chge_shon21 IS NOT NULL
        OR su2_chge_shon22 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_demo_shon21 IS NOT NULL
        OR su2_demo_shon22 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        OR su2_sup_shon21 IS NOT NULL
        OR su2_sup_shon22 IS NOT NULL
        THEN donnees_techniques.su2_tot_shon_tot
        ELSE donnees_techniques.su_tot_shon_tot
    END as "'._("surface").'"',
    'COALESCE(service.abrege, tiers_consulte.abrege) as "'._("service / tiers").'"',
    $case_type_consultation.' as "'._("type_consultation").'"',
    $avis_rendu,
    );
//
$champRecherche = array(
    'consultation.consultation as "'._("consultation").'"',
    'to_char(consultation.date_limite ,\'DD/MM/YYYY\') as "'._("date_limite").'"',
    'consultation.dossier as "'._("dossier").'"',
    // date de depots de piece complementaire
    'dossier.terrain_adresse_voie as "'._("Localisation (voie)").'"',
    'dossier.terrain_adresse_code_postal as "'._("Localisation (code postal)").'"',
    'dossier.terrain_adresse_localite as "'._("Localisation (ville)").'"',
    'dossier.adresse_normalisee as "'.__("Adresse normalisée").'"',
    'demandeur.personne_morale_denomination as "'._("petitionnaire personne morale").'"',
    'demandeur.particulier_nom as "'._("petitionnaire particulier").'"',
    '-- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_avt_shon21 IS NOT NULL
        OR su2_avt_shon22 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_cstr_shon21 IS NOT NULL
        OR su2_cstr_shon22 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_chge_shon21 IS NOT NULL
        OR su2_chge_shon22 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_demo_shon21 IS NOT NULL
        OR su2_demo_shon22 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        OR su2_sup_shon21 IS NOT NULL
        OR su2_sup_shon22 IS NOT NULL
        THEN donnees_techniques.su2_tot_shon_tot
        ELSE donnees_techniques.su_tot_shon_tot
    END as "'._("surface").'"',
    'COALESCE(service.abrege, tiers_consulte.abrege) as "'._("service / tiers").'"',
    $avis_rendu,
    );
$tri="ORDER BY consultation.date_limite::date DESC NULLS LAST, consultation.consultation DESC";
$edition="";
$selection=' WHERE om_utilisateur.login=\''.$_SESSION['login'].'\'';

//Suppression des liens
$tab_actions['corner']['ajouter']=NULL;
$tab_actions['left']['consulter']=NULL;

/**
 * OPTIONS - ADVSEARCH
 */
//
$champs = array();
//
$champs['date_limite'] = array(
    'colonne' => 'date_limite',
    'table' => 'consultation',
    'libelle' => _('Date limite'),
    'type' => 'date',
    'where' => 'intervaldate',
    'taille' => '',
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
    'taille' => '',
    'max' => '',
);
//
$champs['nature'] = array(
    'libelle' => _('nature des travaux'),
    'type' => 'text',
    'table' => 'donnees_techniques',
    'colonne' => array(
        'am_projet_desc',
        'co_projet_desc',
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
    'taille' => '',
    'max' => '',
);
//
$champs['service_abrege'] = array(
    'table' => 'service',
    'colonne' => 'abrege',
    'type' => 'text',
    'libelle' => _('Service (abrege)'),
    'taille' => '',
    'max' => '',
);

// Le champ de recherche de l'avis rendu est affiché seulement sur le menu des
// demandes d'avis passées
if ($obj === "demande_avis_passee" || $obj === "demande_avis") {
    //
    $champs['avis_consultation'] = array(
        'libelle' => _('avis rendu'),
        'type' => 'select',
        'table' => 'avis_consultation',
        'colonne' => 'avis_consultation',
    );
}

// advsearch -> options
$options[] =  array(
    'type' => 'search',
    'display' => true,
    'advanced' => $champs,
    'absolute_object' => 'consultation',
    'export' => array("csv"),
);

/* Gestion des onglets */

$sousformulaire = array();
$sousformulaire_parameters = array();

// Vérification du droit de lister les documents numérisés pour l'utilisateur connecté
if ($f->isAccredited("document_numerise") || $f->isAccredited(array("demande_avis", "demande_avis_document_numerise"), "OR")) {
    $sousformulaire[] = "document_numerise";
    // On modifie le lien du paramètre
    $sousformulaire_parameters["document_numerise"] = array(
        "title" => _("Pièces & documents"),
        "href" => "".OM_ROUTE_FORM."&obj=demande_avis&action=4&idx=".((isset($idx))?$idx:"")."&retourformulaire=".((isset($_GET['obj']))?$_GET['obj']:"")."&",
    );
}

// Onglet listant les consultations du DI lié à la demande d'avis courante
$sousformulaire[] = "consultation";
$sousformulaire_parameters["consultation"] = array(
        "title" => _("consultation(s)"),
        "href" => "".OM_ROUTE_FORM."&obj=".(isset($obj) ? $obj : "demande_avis")."&action=10&idx=".((isset($idx))?$idx:"")."&",
    );

/**
 * Options
 */
// On met la ligne en couleur selon le type de condition
$options[] = array(
    "type" => "condition",
    "field" => $case_type_consultation,
    "case" => array(
                 array(
                    "values" => array(_("avec avis attendu"), ),
                    "style" => "consultation-avec-avis-attendu",
                ),
                array(
                    "values" => array(_("pour conformite"), ),
                    "style" => "consultation-pour-conformite",
                ),
                array(
                    "values" => array(_("pour information"), ),
                    "style" => "consultation-pour-information",
                ),
            ),
);


// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];
?>
