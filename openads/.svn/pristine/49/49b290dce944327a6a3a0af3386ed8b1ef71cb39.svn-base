<?php
/**
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_instruction.inc.php 6128 2016-03-08 15:43:42Z jymadier $
 */

/*Etend la classe dossier*/
include('../sql/pgsql/dossier.inc.php');
include "../sql/pgsql/app_om_tab_common_select.inc.php";

/*Titre de la page*/
$ent = _("instruction")." -> "._("dossiers d'instruction");

$tab_title = _("DI");

// Pour le formulaire de géocodage par lot
// Change le nom de l'onglet principal et cache les autres onglets
if ($f->get_submitted_get_value('action') === '126'){
    $tab_title = _("Géolocalisation des dossiers");
    $sousformulaire = array();
}

/* Test SQL pour récupérer les bons champs selon la qualité du demandeur : 
 * particulier ou personne morale*/
$case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
END";

/*Tables sur lesquels la requête va s'effectuer*/
$table = sprintf(
    '%1$sdossier
    -- Recherche le pétitionnaire principal du dossier (unique !)
    LEFT JOIN (
        SELECT
            * 
        FROM
            %1$slien_dossier_demandeur
            INNER JOIN %1$sdemandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE
            lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER(\'petitionnaire\')
    ) as demandeur
        ON demandeur.dossier = dossier.dossier
    -- Recherche le type de DATD
    LEFT JOIN %1$sdossier_instruction_type
        ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type
    LEFT JOIN %1$sdossier_autorisation_type_detaille
        ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille
    -- Recherche l instructeur du dossier
    LEFT JOIN %1$sinstructeur
        ON dossier.instructeur = instructeur.instructeur
    LEFT JOIN %1$som_utilisateur
        ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
    -- Recherche l instructeur 2 du dossier
    LEFT JOIN %1$sinstructeur as instructeur_secondaire
        ON dossier.instructeur_2 = instructeur_secondaire.instructeur
    LEFT JOIN %1$som_utilisateur as utilisateur_2
        ON instructeur_secondaire.om_utilisateur = utilisateur_2.om_utilisateur
    -- Recherche l etat du dossier
    LEFT JOIN %1$setat
        ON dossier.etat = etat.etat
    -- Recherche la division de rattachement du dossier (différente de celle de l instructeur)
    LEFT JOIN %1$sdivision
        ON dossier.division = division.division
    -- Recherche l avis de décision
    LEFT JOIN %1$savis_decision   
        ON avis_decision.avis_decision=dossier.avis_decision
    -- Recherche la collectivite de rattachement du dossier
    LEFT JOIN %1$som_collectivite 
        ON dossier.om_collectivite=om_collectivite.om_collectivite
    -- Recherche l arrondissement du dossier
    LEFT JOIN %1$sarrondissement
        ON arrondissement.code_postal = dossier.terrain_adresse_code_postal
    -- Récupère la demande qui a créé le type dossier du dossier
    LEFT JOIN (%1$sdemande
        JOIN %1$sdemande_type
            ON demande.demande_type = demande_type.demande_type
    )
        ON demande.dossier_instruction = dossier.dossier
            AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
    ',
    DB_PREFIXE
);
if ($f->is_option_dossier_commune_enabled()) {
    $table .= "
        LEFT OUTER JOIN ".DB_PREFIXE."commune
            ON commune.commune = dossier.commune
    ";
}

$nature_travaux_from = "LEFT JOIN (
    SELECT ntc.dossier, string_agg(ntc.libelle::text, '\n' order by ntc.libelle) as libelle
    FROM 
    (SELECT DISTINCT
        dossier,
        famille_travaux.libelle as famille_travaux,
        CONCAT(famille_travaux.libelle, ' / ', nature_travaux.libelle) as libelle
    FROM 
        ".DB_PREFIXE."lien_dossier_nature_travaux 
    INNER JOIN 
        ".DB_PREFIXE."nature_travaux 
            ON lien_dossier_nature_travaux.nature_travaux = nature_travaux.nature_travaux
    INNER JOIN
        ".DB_PREFIXE."famille_travaux
            ON nature_travaux.famille_travaux = famille_travaux.famille_travaux ORDER BY famille_travaux.libelle) as ntc
    GROUP BY dossier ORDER BY libelle) as nature_travaux ON nature_travaux.dossier = dossier.dossier
";
// Ajout des colonnes concernant la demat
if ($f->get_submitted_get_value('mode') === 'export_csv') {
    // Jointure permettant d'afficher l'id platau du service consultant et le
    // libellé du service consultant dans les exports si le mode service consulté est
    // actif
    $table .= $f->is_option_mode_service_consulte_enabled() === true ?
        'LEFT JOIN '.DB_PREFIXE.'consultation_entrante
            ON dossier.dossier = consultation_entrante.dossier
        ' :
        '';
    $table .=
        "LEFT JOIN 
            (SELECT
                dossier,
                external_uid
            FROM
                ".DB_PREFIXE."lien_id_interne_uid_externe
            WHERE object = 'dossier'
                AND category = 'platau'
            ) AS dossier_platau
            ON
                dossier_platau.dossier = dossier.dossier
        LEFT JOIN
            (SELECT
                dossier,
                external_uid
            FROM
                ".DB_PREFIXE."lien_id_interne_uid_externe
            WHERE object = 'dossier_consultation'
                AND category = 'platau'
            ) AS consultation_platau
            ON
                consultation_platau.dossier = dossier.dossier
        LEFT JOIN
            (SELECT
                dossier,
                ARRAY_TO_STRING(ARRAY_AGG(external_uid ORDER BY external_uid ASC), ', ') AS external_uid
            FROM
                ".DB_PREFIXE."lien_id_interne_uid_externe
            WHERE
                object = 'piece'
                AND category = 'platau'
            GROUP BY
                dossier) AS pieces_platau
            ON
                pieces_platau.dossier = dossier.dossier
        LEFT JOIN
            (SELECT
                dossier,
                ARRAY_TO_STRING(ARRAY_AGG(object || ' : ' || external_uid), ', ') AS external_uid
            FROM
                ".DB_PREFIXE."lien_id_interne_uid_externe
            WHERE
                object != 'piece'
                AND object != 'dossier'
                AND object != 'dossier_consultation'
                AND category = 'platau'
            GROUP BY
                dossier) AS autres_platau
            ON
                autres_platau.dossier = dossier.dossier
            ";
    $nature_travaux_from = "LEFT JOIN (
        SELECT ftc.dossier, string_agg(ftc.libelle::text, ', ') as famille_travaux_libelle
        FROM 
        (SELECT DISTINCT
            dossier,
            famille_travaux.libelle
        FROM 
            ".DB_PREFIXE."lien_dossier_nature_travaux 
        INNER JOIN 
            ".DB_PREFIXE."nature_travaux 
                ON lien_dossier_nature_travaux.nature_travaux = nature_travaux.nature_travaux
        INNER JOIN
            ".DB_PREFIXE."famille_travaux
                ON nature_travaux.famille_travaux = famille_travaux.famille_travaux
        ORDER BY famille_travaux.libelle) as ftc
        GROUP BY dossier) as famille_travaux ON famille_travaux.dossier = dossier.dossier
        LEFT JOIN (
                SELECT ntc.dossier, string_agg(ntc.libelle::text, ', ') as nature_travaux_libelle
                FROM 
                (SELECT DISTINCT
                    dossier,
                    nature_travaux.libelle
                FROM 
                    ".DB_PREFIXE."lien_dossier_nature_travaux 
                INNER JOIN 
                    ".DB_PREFIXE."nature_travaux 
                        ON lien_dossier_nature_travaux.nature_travaux = nature_travaux.nature_travaux
                ORDER BY nature_travaux.libelle) as ntc
                GROUP BY dossier) as nature_travaux ON nature_travaux.dossier = dossier.dossier
    ";
}

$champ_date_depot_mairie = 'to_char(dossier.date_depot_mairie ,\'DD/MM/YYYY\') as "'.__("dépôt mairie").'"';

/*Champs du début de la requête*/
$champAffiche_debut_commun = array(
    'dossier.dossier as "'._("dossier").'"',
    'dossier.geom as "geom_picto"',
    'demande.source_depot as "demat_picto"',
    $select__dossier_libelle__column_as,
);
if ($f->is_option_dossier_commune_enabled()) {
    $champAffiche_debut_commun[] = 'commune.libelle as "'.__("commune").'"';
}
array_push($champAffiche_debut_commun,
    $case_demandeur.' as "'._("petitionnaire").'"',
    $trim_concat_terrain,
    'dossier_autorisation_type_detaille.libelle as "'._("type").'"',
    'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'.__("dépôt").'"',
    'to_char(dossier.date_complet ,\'DD/MM/YYYY\') as "'.__("complétude").'"',
    'CASE WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE 
        THEN to_char(dossier.date_limite_incompletude ,\'DD/MM/YYYY\') 
        ELSE to_char(dossier.date_limite ,\'DD/MM/YYYY\')
    END as "'.__("limite").'"'
);

if ($f->is_option_date_depot_mairie_enabled() === true) {
    $champAffiche_debut_commun[] = $champ_date_depot_mairie;
}
/**
 * Colonne "Nature des travaux" (regroupe les descriptions des données
 * techniques).
 */
// Nombre max de caractères à afficher dans la colonne de la nature des travaux
// avant de tronquer la valeur et d'ajouter une ellipse "…"
$max_chars = 40;
//
$description_projet_select = "
CASE WHEN nature_travaux.libelle IS NULL AND char_length(description_projet) <= ".$max_chars." THEN
    CONCAT('<span class=\"nature_travaux_cursor\" title=\"',
            description_projet,
        '\">',
        replace(description_projet, '\n', '<br/>'),
    '</span>')
WHEN nature_travaux.libelle IS NULL AND char_length(description_projet) > ".$max_chars." THEN
    CONCAT('<span class=\"nature_travaux_cursor\" title=\"',
            description_projet,
        '\">',
        replace(left(description_projet, ".$max_chars."), '\n', '<br/>') || '…',
    '</span>')
WHEN nature_travaux.libelle IS NOT NULL AND ARRAY_LENGTH(STRING_TO_ARRAY(nature_travaux.libelle, '\n'), 1) = 1 THEN
    CONCAT('<span class=\"nature_travaux_cursor\" title=\"',
            nature_travaux.libelle,
            '\n',
            description_projet,
        '\">',
        replace(nature_travaux.libelle, '\n', '<br/>'),
    '</span>')
WHEN nature_travaux.libelle IS NOT NULL AND ARRAY_LENGTH(STRING_TO_ARRAY(nature_travaux.libelle, '\n'), 1) > 1 THEN
    CONCAT('<span class=\"nature_travaux_cursor\" title=\"',
            nature_travaux.libelle,
            '\n',
            description_projet,
        '\">',
        split_part(nature_travaux.libelle, '\n', 1), '<br/>', '[...]',
    '</span>')
END as \""._("nature des travaux").'"';
// description/nature des travaux. En cas de modif, bloc de code aussi présent dans
// dossier.form.inc.php (le formulaire du DI)', 'om_requete' et 'stats à la demande'
$description_projet_from = "
INNER JOIN (
    SELECT
        CONCAT_WS(
            '\n',
            CASE WHEN co_projet_desc = '' THEN
                NULL
            ELSE
                TRIM(co_projet_desc)
            END,
            CASE WHEN ope_proj_desc = '' THEN
                NULL
            ELSE
                TRIM(ope_proj_desc)
            END,
            CASE WHEN am_projet_desc = '' THEN
                NULL
            ELSE
                TRIM(am_projet_desc)
            END,
            CASE WHEN dm_projet_desc = '' THEN
                NULL
            ELSE
                TRIM(dm_projet_desc)
            END,
            CASE WHEN donnees_techniques.erp_cstr_neuve IS TRUE
                THEN '".str_replace("'", "''", _('erp_cstr_neuve'))."' END,
            CASE WHEN donnees_techniques.erp_trvx_acc IS TRUE
                THEN '".str_replace("'", "''", _('erp_trvx_acc'))."' END,
            CASE WHEN donnees_techniques.erp_extension IS TRUE
                THEN '".str_replace("'", "''", _('erp_extension'))."' END,
            CASE WHEN donnees_techniques.erp_rehab IS TRUE
                THEN '".str_replace("'", "''", _('erp_rehab'))."' END,
            CASE WHEN donnees_techniques.erp_trvx_am IS TRUE
                THEN '".str_replace("'", "''", _('erp_trvx_am'))."' END,
            CASE WHEN donnees_techniques.erp_vol_nouv_exist IS TRUE
                THEN '".str_replace("'", "''", _('erp_vol_nouv_exist'))."' END,
            CASE WHEN mh_design_appel_denom = '' THEN
                NULL
            ELSE
                TRIM(mh_design_appel_denom)
            END,
            CASE WHEN mh_loc_denom = '' THEN
                NULL
            ELSE
                TRIM(mh_loc_denom)
            END
        ) as description_projet,
        dossier_instruction
        FROM ".DB_PREFIXE."donnees_techniques
    ) as description_projet
    ON description_projet.dossier_instruction = dossier.dossier
";
// On ne veut cette colonne que dans les trois listings "Recherche",
// "Mes encours" et "Tous les encours"
$listings = array("dossier_instruction",
                  "dossier_instruction_mes_encours",
                  "dossier_instruction_tous_encours");
//
$is_in_obj_whitelist = in_array($obj, $listings);
// La variable $retourformulaire permet de s'assurer que l'on est pas dans un
// sous-tableau
if ($is_in_obj_whitelist === true && $retourformulaire === '') {
    // Modifie les colonnes à afficher en début du tableau
    $champAffiche_debut_commun = array(
        'dossier.dossier as "'._("dossier").'"',
        'dossier.geom as "geom_picto"',
        'demande.source_depot as "demat_picto"',
        $select__dossier_libelle__column_as,
    );
    if ($f->is_option_dossier_commune_enabled()) {
        $champAffiche_debut_commun[] = 'commune.libelle as "'.__("commune").'"';
    }
    array_push($champAffiche_debut_commun,
        $case_demandeur.' as "'._("petitionnaire").'"',
        $trim_concat_terrain,
        'dossier_autorisation_type_detaille.libelle as "'._("type").'"',
        $description_projet_select,
        'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'.__("dépôt").'"',
        'to_char(dossier.date_complet ,\'DD/MM/YYYY\') as "'.__("complétude").'"',
        'CASE WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE 
            THEN to_char(dossier.date_limite_incompletude ,\'DD/MM/YYYY\') 
            ELSE to_char(dossier.date_limite ,\'DD/MM/YYYY\')
        END as "'.__("limite").'"'
    );
    if ($f->is_option_date_depot_mairie_enabled() === true) {
        $champAffiche_debut_commun[] = $champ_date_depot_mairie;
    }
    // Modifie également le from
    $table .= $description_projet_from.' '.$nature_travaux_from;
}

/*Champs de la fin de la requête*/
$champAffiche_fin_commun = array(
    'etat.libelle as "'._("etat").'"',
    'CASE WHEN dossier.enjeu_urba is TRUE
          THEN \'<span class="om-icon om-icon-16 om-icon-fix enjeu_urba-16" title="'._("Enjeu URBA").'">URBA</span>\'
          ELSE \'\'
          END ||
     CASE WHEN dossier.enjeu_erp is TRUE
          THEN \'<span class="om-icon om-icon-16 om-icon-fix enjeu_erp-16" title="'._("Enjeu ERP").'">ERP</span>\'
          ELSE \'\'
          END
     as "'._("enjeu").'"',
);

//
if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche_fin_commun, "om_collectivite.libelle as \""._("collectivite")."\"");
}

// Identifie s'il y a déjà un WHERE dans la requête
if (stripos($selection, "WHERE") === false) {
    $selection .= " WHERE ";
} else {
    $selection .= " AND ";
}
// Les dossiers des contentieux sont gérés dans un autre listing, il ne doivent
// pas apparaître dans la liste des dossiers d'instruction de l'onglet instruction -> recherche
// /!\ l'opérateur != exclus les valeurs null. Il faut donc préciser que les groupe ayant un
// code NULL doivent bien être récupérés.
$selection .= " (groupe.code IS NULL OR groupe.code != 'CTX')";

$instructeur_nom = 'CASE WHEN instructeur.nom IS NOT NULL AND division.code IS NOT NULL THEN
            CONCAT(\'<span title="Instructeur: \', instructeur.nom, '."'\n'".', \'Division: \', division.code, \'"\', \'>\', instructeur.nom, \' (\', division.code, \')\', \'</span>\')
        WHEN instructeur.nom IS NOT NULL AND division.code IS NULL THEN
            instructeur.nom
        ELSE
            instructeur.nom
        END as "'.__("instructeur").'"';


/*Liste des champs affichés dans le tableau de résultat*/
$champAffiche = array_merge(
    $champAffiche_debut_commun,
    array(
        $instructeur_nom,
    ),
    $champAffiche_fin_commun
);

// Suppression du bouton d'ajout, qui n'est pas affiché par défaut dans les listings de
// dossiers d'instruction
$tab_actions['corner']['ajouter'] = NULL;

if (isset($_GET['message_help'])
    && ! is_null($_GET['message_help'])
    && $_GET['message_help'] != ""
    && $_GET['module'] == 'tab') {

    $tab_actions['left']["consulter"]['id'] .= '&amp;message_help='.urlencode($_GET['message_help']);
    $tab_actions['content'] = $tab_actions['left']["consulter"];
}

// Liste des autres dossiers d'instructions
if ($retourformulaire== 'dossier_instruction'){
    $champAffiche = array(
        'dossier.dossier as "'._("dossier_instruction").'"',
        'dossier.geom as "geom_picto"',
        'demande.source_depot as "demat_picto"',
        $select__dossier_libelle__column_as,
    );
    if ($f->is_option_dossier_commune_enabled()) {
        $champAffiche[] = 'c.libelle as "'._("commune").'"';
    }
    array_push($champAffiche,
        'dossier_instruction_type.libelle as "'._("demande_type").'"',
        'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("dépôt").'"',
        'dossier.etat as "'._("etat").'"'
    );

    $table =DB_PREFIXE.'dossier as a
            JOIN '.DB_PREFIXE.'dossier_autorisation
            ON a.dossier_autorisation=dossier_autorisation.dossier_autorisation
            JOIN '.DB_PREFIXE.'dossier as dossier
            ON dossier.dossier_autorisation=dossier_autorisation.dossier_autorisation
            JOIN '.DB_PREFIXE.'dossier_instruction_type
            ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type';
    if ($f->is_option_dossier_commune_enabled()) {
        $table .= '
            JOIN '.DB_PREFIXE.'commune as c
                ON c.commune = dossier.commune';
    }
    $selection = 'WHERE a.dossier=\''.$f->db->escapeSimple($idxformulaire).'\'';
    $tri= "order by dossier.date_depot ASC";

    //
    $tab_actions['left']["consulter"] = 
        array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3'.'&amp;idx=',
              'id' => '&retourformulaire='.$retourformulaire.'&retour=',
              'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
              'rights' => array('list' => array('dossier_instruction', 'dossier_instruction_consulter'), 'operator' => 'OR'),
              'ordre' => 10,
              'ajax' => false);

    $tab_actions['content'] = $tab_actions['left']["consulter"];
    $options[] = array(
        "type"=>"pagination_select",
        "display"=>false,
    );
}


if ( $retourformulaire == "dossier_autorisation") {

    //
    $tab_actions['left']["consulter"] = 
    array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx=',
              'id' => '&amp;retourformulaire='.$retourformulaire,
              'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
              'rights' => array('list' => array('dossier_instruction', 'dossier_instruction_consulter'), 'operator' => 'OR'),
              'ordre' => 10,
              'ajax' => false);
              
    $tab_actions['content'] = $tab_actions['left']["consulter"] ;
}


// Affichage du bouton de redirection vers le SIG externe si configuré
// XXX Ajouter filtre pour afficher l'icone géolocalisation en fonction de la conf SIG du dossier
if($f->getParameter('option_sig') == 'sig_externe') {
    $tab_actions['left']["localiser-sig-externe"] = array(
                'lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=140&amp;idx=',
                'id' => '',
                'lib' => '<span class="om-icon om-icon-16 om-icon-fix sig-16" title="'._('Localiser').'">'._('Localiser').'</span>',
                'rights' => array('list' => array('dossier_instruction', 'dossier_instruction_consulter'), 'operator' => 'OR'),
                'ordre' => 20,
                'target' => "_SIG",
                'ajax' => false);
}

// Si filtre DI auxquels on peut proposer une autre décision
// /!\ Requête lié à celles permettant de savoir si l'instructeur peut changer la
// décision et à l'affichage du widgets des dossiers éligibles au changement :
//   * instruction.class.php : isInstrCanChangeDecision()
//   * dossier_instruction.class.php : view_widget_dossiers_evenement_retour_finalise()
// TODO ; faire évoluer cette affichage pour reprendre celui des DI (avec la recherche avancée)
if (isset($extra_parameters["filtre_decision"])
    && $extra_parameters["filtre_decision"] == true) {

    // Augmentation de la limite
    $serie = 50;
    // Réinitialisation des options
    $options = array();
    // Suppression de la recherche avancée
    $options[] = array(
        'type' => 'search',
        'display' => false);
    // Suppression du sélecteur de pages
    $options[] = array(
        'type' => 'pagination_select',
        'display' => false);
    // Ajout jointure
    $table = sprintf(
        '%1$sdossier
        JOIN %1$setat
            ON dossier.etat = etat.etat AND etat.statut = \'encours\'
        JOIN %1$slien_dossier_demandeur
            ON dossier.dossier = lien_dossier_demandeur.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
        JOIN %1$sdossier_instruction_type
            ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type
        JOIN %1$sdossier_autorisation_type_detaille
            ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            -- Récupère la demande qui a créé le type dossier du dossier
        LEFT JOIN (%1$sdemande
            JOIN %1$sdemande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        JOIN %1$sinstruction
            -- Recherche de la dernière instruction qui ne soit pas liée à un événement retour
                ON instruction.instruction = (
                        SELECT instruction
                        FROM %1$sinstruction
                        JOIN %1$sevenement ON instruction.evenement=evenement.evenement
                        AND evenement.retour IS FALSE
                        WHERE instruction.dossier = dossier.dossier
                        ORDER BY date_evenement DESC, instruction DESC
                        LIMIT 1
                    )
                    -- On ne garde que les dossiers pour lesquels la dernière instruction est finalisée
                    -- ou alors pour laquelle l instruction a été ajouté par la commune et est
                    -- non signée, non notifié, etc.
                    AND (instruction.om_final_instruction IS TRUE
                        OR instruction.created_by_commune IS TRUE)
                    AND instruction.date_retour_signature IS NULL
                    AND instruction.date_envoi_rar IS NULL
                    AND instruction.date_retour_rar IS NULL
                    AND instruction.date_envoi_controle_legalite IS NULL
                    AND instruction.date_retour_controle_legalite IS NULL
            -- On vérifie que l instruction soit un arrêté ou un changement de décision
            JOIN %1$sevenement
                ON instruction.evenement=evenement.evenement
                    AND (evenement.type = \'arrete\'
                        OR evenement.type = \'changement_decision\')
            -- Recherche les informations du pétitionnaire principal pour l affichage
            JOIN %1$sdemandeur
                ON lien_dossier_demandeur.demandeur = demandeur.demandeur
            -- Recherche la collectivité rattachée à l instructeur
            JOIN %1$sinstructeur
                ON dossier.instructeur=instructeur.instructeur
            JOIN %1$sdivision
                ON instructeur.division=division.division
            JOIN %1$sdirection
                ON division.direction=direction.direction
            JOIN %1$som_collectivite
                ON direction.om_collectivite=om_collectivite.om_collectivite
            %2$s
        ',
        DB_PREFIXE,
        $description_projet_from.' '.$nature_travaux_from
    );
    // Modification sélection
    $selection = "WHERE dossier_instruction_type.sous_dossier IS NOT TRUE AND
        om_collectivite.niveau = '2'";
    // Si collectivité de l'utilisateur niveau mono alors filtre sur celle-ci
    if ($f->isCollectiviteMono($_SESSION['collectivite']) === true) {
        $selection .= " AND dossier.om_collectivite=".$_SESSION['collectivite'];
    }
    // Modification tri
    $tri = " ORDER BY dossier.dossier ";
}


// Ajout de la gestion des groupes et confidentialité à la requête du listing
$sqlFiltreGroup = $this->get_sql_filtre_groupe($table.$selection);
$selection .= $sqlFiltreGroup['WHERE'];
$table .= $sqlFiltreGroup['FROM'];
// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];

// Si l'option qui permet de masquer les colonnes comporte la localisation
// ou le champ date_complet alors on masque la colonne
$param_affichage_col = $f->get_affichage_di_listing_colonnes_masquees();
if (! empty($param_affichage_col)) {
    if (array_search('localisation', $param_affichage_col) !== false) {
        $key_champaff = array_search($trim_concat_terrain, $champAffiche);
        unset($champAffiche[$key_champaff]);
        $champAffiche = array_values($champAffiche);
        // Gestion pour les listings tous_encours et tous_cloture
        $key_champaff_commun = array_search($trim_concat_terrain, $champAffiche_debut_commun);
        unset($champAffiche_debut_commun[$key_champaff_commun]);
        $champAffiche_debut_commun = array_values($champAffiche_debut_commun);
    }
    if (array_search('date_complet', $param_affichage_col) !== false) {
        $key_champaff = array_search('to_char(dossier.date_complet ,\'DD/MM/YYYY\') as "'.__("complétude").'"', $champAffiche);
        unset($champAffiche[$key_champaff]);
        $champAffiche = array_values($champAffiche);
        // Gestion pour les listings tous_encours et tous_cloture
        $key_champaff_commun = array_search('to_char(dossier.date_complet ,\'DD/MM/YYYY\') as "'.__("complétude").'"', $champAffiche_debut_commun);
        unset($champAffiche_debut_commun[$key_champaff_commun]);
        $champAffiche_debut_commun = array_values($champAffiche_debut_commun);
    }
}

?>
