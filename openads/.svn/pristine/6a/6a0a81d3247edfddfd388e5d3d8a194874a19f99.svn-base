<?php
/**
 * Surcharge de dossier, identique à dossier_instruction mais est
 * seulement utilisé dans le script spécifique app/display_da_di.php
 *
 * @package openads
 * @version SVN : $Id: dossier_instruction_display_da_di.inc.php 6197 2016-03-17 13:26:06Z jymadier $
 */

/*Etend la classe dossier*/
include('../sql/pgsql/dossier.inc.php');
include "../sql/pgsql/app_om_tab_common_select.inc.php";

/*Titre de la page*/
$ent = _("instruction")." -> "._("dossiers d'instruction");

$tab_title = _("DI");

/* Test SQL pour récupérer les bons champs selon la qualité du demandeur : 
 * particulier ou personne morale*/
$case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
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

/*Liste des champs affichés dans le tableau de résultat*/
$champAffiche = array_merge($champAffiche_debut_commun,
                            array('instructeur.nom as "'._("instructeur").'"',
                                  'division.code as "'._("division").'"',
                                  ),
                            $champAffiche_fin_commun);
// Liste des autres dossiers d'instructions
if (in_array($retourformulaire, $foreign_keys_extended["dossier"]) === true
    || $retourformulaire == 'dossier_qualifier_qualificateur'
    || $retourformulaire== 'dossier_autorisation'){

    // Table principale : dossier cible (résultats du tableau)
    $table = DB_PREFIXE.'dossier as dossier';
    // Jointure avec le DI source
    $table .= '
      INNER JOIN '.DB_PREFIXE.'dossier as di_source
        ON di_source.dossier = \''.$f->db->escapeSimple($idxformulaire).'\'';
    // Éventuelle jointure avec la table de liaison des DI liés
    $table .= '
      LEFT JOIN '.DB_PREFIXE.'lien_dossier_dossier
        ON lien_dossier_dossier.dossier_cible = dossier.dossier
        AND lien_dossier_dossier.dossier_src = \''.$f->db->escapeSimple($idxformulaire).'\'';
    // Jointure avec les clés étrangères du DI cible pour récupérer leurs libellés
    $table .= '
      INNER JOIN '.DB_PREFIXE.'dossier_instruction_type as di_type_cible
        ON di_type_cible.dossier_instruction_type = dossier.dossier_instruction_type
      INNER JOIN '.DB_PREFIXE.'etat as etat_cible
        ON dossier.etat = etat_cible.etat';
    // Jointure avec la table groupe
    $table .= "
    INNER JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
        ON di_type_cible.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille";

    $table .= "
    INNER JOIN ".DB_PREFIXE."dossier_autorisation_type
        ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type";

    $table .= "
    INNER JOIN ".DB_PREFIXE."groupe
        ON dossier_autorisation_type.groupe = groupe.groupe";

    $table .= "-- Récupère la demande qui a créé le type dossier du dossier
LEFT JOIN (".DB_PREFIXE."demande
    JOIN ".DB_PREFIXE."demande_type
        ON demande.demande_type = demande_type.demande_type)
    ON demande.dossier_instruction = dossier.dossier
        AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type";

    /*
      Condition SQL pour masquer l'icone de suppression de dossier lié.
      - Seul l'utilisateur disposant d'une permission spécifique peut
        supprimer les liens automatiques.
      - Un lien non typé n'est jamais supprimable (ce cas ne doit pas se produire).
      - Si l'utilisateur a une division alors celle-ci doit correspondre à celle du dossier
        à moins qu'il ne dispose d'un bypass.
     */
    $clause_auto = '' ;
    if ($this->isAccredited("dossier_instruction_supprimer_liaison_auto") === false) {
        $clause_auto = '
        OR lien_dossier_dossier.type_lien != \'manuel\' ';
    }
    if ($this->isAccredited("lien_dossier_dossier_gestion_defaut_bypass") === false
        && $_SESSION['division'] != '0') {
        $clause_auto .= '
        OR di_source.division != '.$_SESSION['division'].' ';
    }
    $case_cannot_delete_link = 'CASE WHEN
      lien_dossier_dossier.type_lien IS NULL'.$clause_auto.'
          THEN \'f\'
          ELSE \'t\'
    END';
    $options[] = array(
      'type' => 'condition',
      'field' => $case_cannot_delete_link,
      'case' => array(
          array(
              'values' => array('f', ),
              'style' => 'case_cannot_delete_link',
          ),
          array(
              'values' => array('t', ),
              'style' => 'case_can_delete_link',
          ),
      ),
    );

    /*
      Condition SQL pour mettre en forme le lien automatique.
     */
    $case_lien_auto = 'CASE
      WHEN lien_dossier_dossier.type_lien = \'auto_recours\'
          THEN \'t\'
          ELSE \'f\'
      END';
      $options[] = array(
        'type' => 'condition',
        'field' => $case_lien_auto,
        'case' => array(
            array(
                'values' => array('f', ),
                'style' => 'case_lien_manuel',
            ),
            array(
                'values' => array('t', ),
                'style' => 'case_lien_auto',
            ),
        ),
    );

    $champAffiche=array(
        'dossier.dossier as "'._("dossier d'instruction").'"',
        'dossier.geom as "geom_picto"',
        'demande.source_depot as "demat_picto"',
        $select__dossier_libelle__column. ' as "'._("dossier d'instruction").'"',
        'di_type_cible.libelle as "'._("demande_type").'"',
        'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("date_depot").'"',
        'etat_cible.libelle as "'._("etat").'"',
    );
    $champAffiche[] = $case_cannot_delete_link.' as "case_cannot_delete_link"';
    $champAffiche[] = $case_lien_auto.' as "case_lien_auto"';

    // Exclusion du DI source des DI cibles récupérés par le DA
    // et filtre du DI source
    $selection = '
    WHERE
        dossier.dossier != \''.$f->db->escapeSimple($idxformulaire).'\'
        AND (di_source.dossier_autorisation = dossier.dossier_autorisation
        OR lien_dossier_dossier.dossier_cible IS NOT NULL)';
    // Éventuel filtre mono sur les dossiers cibles
    if ($f->isCollectiviteMono($_SESSION['collectivite']) === true) {
        $selection .= " AND dossier.om_collectivite = ".$_SESSION['collectivite'];
    }

    // Tri chronologique par la date de dépôt du dossier cible
    $tri= "ORDER BY dossier.date_depot ASC";

    // Récupération de la classe qui contient le soustab
    $class = ((isset($_GET['context']))?$_GET['context']: '');

    // Gestion action ajouter
    $tab_actions['corner']['ajouter'] = NULL;

    require_once "../obj/dossier.class.php";
    $inst = new dossier($idxformulaire);

    //
    if (isset($f) === true
        && $class !== ''
        && ($f->isAccredited($class . "_ajouter_bypass") === true
            || ($f->isUserInstructeur()
                && $inst->getDivisionFromDossier($idxformulaire) === $_SESSION["division"]
                && $f->getStatutDossier($idxformulaire) !== "cloture"))) {

        // Bouton d'ajout
        $tab_actions['corner']["ajouter"] = array(
          'lien' => ''.OM_ROUTE_SOUSFORM.'&obj=' . $class .'&amp;action=5&amp;idx=0&amp;idxformulaire='.$idxformulaire,
          'id' => '&retourformulaire='.$retourformulaire.'&retour=tab',
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix add-16" title="'._('Ajouter').'">'._('Ajouter').'</span>',
          'rights' => array('list' => array($class, $class . '_ajouter'), 'operator' => 'OR'),
          'ordre' => 10,
          'ajax' => false,
        );
    }

    //
    if (isset($f) === true
        && ($f->getStatutDossier($idxformulaire) !== "cloture"
        || $f->isAccredited("dossier_instruction_supprimer_liaison_bypass") === true)) {

        // Action direct supprimer
        // On appelle la classe de dossier contenue dans $retourformulaire
        $tab_actions['left']['supprimer'] = array(
            'lien' => ''.OM_ROUTE_FORM.'&obj=' . $retourformulaire . '&amp;action=210&amp;idx='.$idxformulaire.'&amp;idx_cible=',
            'lib' => '<span class="om-icon om-icon-16 om-icon-fix delete-16" title="'._('Supprimer').'">'._('Supprimer').'</span>',
            'rights' => array('list' => array($retourformulaire, $retourformulaire . '_supprimer_liaison'), 'operator' => 'OR'),
            'ordre' => 30,
            'type' => 'action-direct',
        );
    }

    // Action consulter sans AJAX
    $tab_actions['left']["consulter"] = array(
        'lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=777&amp;retourformulaire='.$retourformulaire.'&amp;idxformulaire='.$idxformulaire.'&amp;idx=',
        'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
        'rights' =>
        array(
        'list' => array(
            'dossier_instruction',
            'dossier_instruction_consulter',
            'dossier_contentieux_tous_recours',
            'dossier_contentieux_tous_recours_consulter',
            'dossier_contentieux_toutes_infractions',
            'dossier_contentieux_toutes_infractions_consulter',
        ),
        'operator' => 'OR'),
        'ordre' => 10,
        'ajax' => false,
    );


    $tab_actions['content'] = $tab_actions['left']["consulter"];
    $options[] = array(
        "type"=>"pagination_select",
        "display"=>false,
    );

}
if ( $retourformulaire == "dossier_autorisation"){
    
    //Suppression du bouton d'ajout
    $tab_actions['corner']['ajouter'] = NULL;
    
    //
    $tab_actions['left']["consulter"] = 
    array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3'.'&amp;idx=',
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

// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];
?>
