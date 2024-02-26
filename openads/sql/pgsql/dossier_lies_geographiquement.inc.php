<?php
/**
 * Surcharge de dossier_autorisation, identique à dossier_iautorisation mais est
 * seulement utilisé dans le script spécifique app/display_da_di.php
 *
 * @package openads
 * @version SVN : $Id: dossier_instruction_display_da_di.inc.php 3104 2014-07-24 14:11:57Z nhaye $
 */

/*Etend la classe d'autorisation*/
include ('../gen/sql/pgsql/dossier_autorisation.inc.php');
include "../sql/pgsql/app_om_tab_common_select.inc.php";

/*Titre de la page*/
$ent = _("autorisation")." -> "._("dossiers d'autorisation");

/* Test SQL pour récupérer les bons champs selon la qualité du demandeur : 
 * particulier ou personne morale*/
$case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
END";

$case_etat = "CASE WHEN etat_dernier_dossier_instruction_accepte IS NULL
    THEN eda.libelle
    ELSE edda.libelle
END";


/*Formatage de l'adresse du terrain, concatenantion de plusieurs champs pour les 
 * mettrent dans une seule colonne*/
$trim_concat_terrain = '
TRIM(
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
) as "'.__("localisation").'"';

/*Tables sur lesquels la requête va s'effectuer*/
$table = DB_PREFIXE."dossier
LEFT JOIN ".DB_PREFIXE."lien_dossier_demandeur 
        ON lien_dossier_demandeur.dossier=dossier.dossier
            AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
LEFT JOIN ".DB_PREFIXE."demandeur
    ON lien_dossier_demandeur.demandeur=demandeur.demandeur
LEFT JOIN ".DB_PREFIXE."dossier_autorisation
    ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
    ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_autorisation.dossier_autorisation_type_detaille
LEFT JOIN ".DB_PREFIXE."instructeur
    ON dossier.instructeur = instructeur.instructeur
LEFT JOIN ".DB_PREFIXE."om_utilisateur
    ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
LEFT JOIN ".DB_PREFIXE."etat
    ON dossier.etat = etat.etat
LEFT JOIN ".DB_PREFIXE."division
    ON dossier.division = division.division
LEFT JOIN ".DB_PREFIXE."avis_decision   
   ON avis_decision.avis_decision=dossier.avis_decision
-- Récupère la demande qui a créé le type dossier du dossier
LEFT JOIN (".DB_PREFIXE."demande
    JOIN ".DB_PREFIXE."demande_type
        ON demande.demande_type = demande_type.demande_type)
    ON demande.dossier_instruction = dossier.dossier
        AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
    ";


/*Champs du début de la requête*/
$champAffiche_debut_commun = array(
    'dossier.dossier as "'._("dossier").'"',
    'dossier.geom as "geom_picto"',
    'demande.source_depot as "demat_picto"',
    $select__dossier_libelle__column_as,
    $case_demandeur.' as "'._("petitionnaire").'"',
    $trim_concat_terrain,
    'dossier_autorisation_type_detaille.libelle as "'._("nature_dossier").'"',
    'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("date_depot").'"',
    'to_char(dossier.date_complet ,\'DD/MM/YYYY\') as "'._("date_complet").'"',
    'to_char(dossier.date_limite ,\'DD/MM/YYYY\') as "'._("date_limite").'"',
);

/*Champs de la fin de la requête*/
$champAffiche_fin_commun = array(
    $case_etat.' as "'._("etat").'"',
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

/*Liste des champs affichés dans le tableau de résultat*/
$champAffiche = array_merge($champAffiche_debut_commun,
                            array('instructeur.nom as "'._("instructeur").'"',
                                  'division.code as "'._("division").'"',
                                  ),
                            $champAffiche_fin_commun);

// Copie des surcharges de la classe dossier à partir de gen/sql/pgsql/dossier.inc.php
$foreign_keys_di = array(
    "dossier" => array(
        "dossier",
        "dossier_instruction",
        "dossier_instruction_mes_encours",
        "dossier_instruction_tous_encours",
        "dossier_instruction_mes_clotures",
        "dossier_instruction_tous_clotures",
        "dossier_contentieux",
        "dossier_contentieux_mes_infractions",
        "dossier_contentieux_toutes_infractions",
        "dossier_contentieux_mes_recours",
        "dossier_contentieux_tous_recours",
        "sous-dossier"
    )
);

// Liste des autres dossiers d'instructions
if (in_array($retourformulaire, $foreign_keys_di['dossier']) === true
    || $retourformulaire == 'dossier_qualifier_qualificateur'
    || $retourformulaire== 'dossier_autorisation'){
    $champAffiche=array(
        'dossier_autorisation.dossier_autorisation',
        'dossier_autorisation.dossier_autorisation_libelle as "'._("dossier d'autorisation lié géographiquement").'"',
        'to_char(dossier_autorisation.depot_initial ,\'DD/MM/YYYY\') as "'._("date_depot_initial").'"',
        $case_etat.' as "'._("etat").'"',
    );

    // option commune = filtrage sur la commune
    $filtrage_commune = '';
    if ($f->is_option_dossier_commune_enabled()) {
        $filtrage_commune = 'AND dossier.commune = dossier_autorisation.commune';
    }

    // Récupère les dossiers d'autorisation qui ont au moins une parcelle en commun avec
    // le DI courant, en comparant les tables dossier_parcelle et dossier_autorisation_parcelle.
    $table = DB_PREFIXE.'dossier
            JOIN '.DB_PREFIXE.'dossier_parcelle
                ON dossier_parcelle.dossier = dossier.dossier
            JOIN '.DB_PREFIXE.'dossier_autorisation_parcelle
                ON CASE WHEN char_length(dossier_autorisation_parcelle.libelle) = 8
                    THEN
                        CONCAT(substring(dossier_autorisation_parcelle.libelle for 3), \'0\', substring(dossier_autorisation_parcelle.libelle from 4))
                    ELSE
                        dossier_autorisation_parcelle.libelle
                END
                =
                CASE WHEN char_length(dossier_parcelle.libelle) = 8
                    THEN
                        CONCAT(substring(dossier_parcelle.libelle for 3), \'0\', substring(dossier_parcelle.libelle from 4))
                    ELSE
                        dossier_parcelle.libelle
                END
                AND dossier_autorisation_parcelle.dossier_autorisation <> dossier.dossier_autorisation
            JOIN '.DB_PREFIXE.'dossier_autorisation ON dossier_autorisation_parcelle.dossier_autorisation = dossier_autorisation.dossier_autorisation
                AND dossier.om_collectivite = dossier_autorisation.om_collectivite
                '.$filtrage_commune.'
            LEFT JOIN '.DB_PREFIXE.'etat_dossier_autorisation as eda
                ON dossier_autorisation.etat_dossier_autorisation = eda.etat_dossier_autorisation
            LEFT JOIN '.DB_PREFIXE.'etat_dossier_autorisation as edda
                ON dossier_autorisation.etat_dernier_dossier_instruction_accepte = edda.etat_dossier_autorisation
            -- Récupère la demande qui a créé le type dossier du dossier
            LEFT JOIN ('.DB_PREFIXE.'demande
                JOIN '.DB_PREFIXE.'demande_type
                    ON demande.demande_type = demande_type.demande_type)
                ON demande.dossier_instruction = dossier.dossier
                    AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type';

    // On souhaite afficher les DA liés au DI courant
    $selection = 'WHERE dossier.dossier=\''.$f->db->escapeSimple($idxformulaire).'\'';

    $selection .= "GROUP BY dossier_autorisation.dossier_autorisation, edda.libelle, eda.libelle ";


    $tri= "ORDER BY dossier_autorisation.depot_initial DESC";

    // Lien vers le script spécifique de visualisation
    if (isset($advs_id) === false) {
        $advs_id = "";
    }

    //Suppression du bouton d'ajout
    $tab_actions['corner']['ajouter'] = NULL;

    //Suppression du bouton d'ajout
    $tab_actions['left']["consulter"] = 
        array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_autorisation&action=777&amp;retourformulaire='.$retourformulaire.'&amp;idxformulaire='.$idxformulaire.'&amp;retour='.$idxformulaire.'&amp;idx=',
              'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
              'rights' => array('list' => array('dossier_autorisation', 'dossier_autorisation_consulter'), 'operator' => 'OR'),
              'ordre' => 10,
              'ajax' => false
            );

    $tab_actions['content'] = $tab_actions['left']["consulter"];

    $options[] = array(
        "type"=>"pagination_select",
        "display"=>false,
    );
}

?>
