<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_commission.inc.php 5074 2015-08-21 14:23:09Z nhaye $
 */

//
include "../gen/sql/pgsql/dossier_commission.inc.php";
include "../sql/pgsql/app_om_tab_common_select.inc.php";

// Affiche les bons champs dans le tableau

$champAffiche = array(
    'dossier_commission.dossier_commission as "'._("id").'"',
    $select__dossier_libelle__column_as,
    'to_char(date_souhaitee ,\'DD/MM/YYYY\') as "'._("date_souhaitee").'"',
    "avis"
);

$champRecherche = array(
    'dossier.dossier as "'._("dossier").'"',
    'dossier.dossier_libelle as "'._("libelle dossier").'"',
    'commission_type.libelle as "'._("commission_type").'"',
    'commission.libelle as "'._("commission").'"',
);

$tri="ORDER BY dossier.annee ASC NULLS LAST, dossier_commission.dossier_commission";

//
$displayed_fields_begin = array(
    'dossier_commission.dossier_commission as "'._("id").'"',
    'dossier.dossier_libelle as "'._("dossier").'"',
    'to_char(dossier_commission.date_souhaitee ,\'DD/MM/YYYY\') as "'._("date_souhaitee").'"',
    'to_char(commission.date_commission ,\'DD/MM/YYYY\') as "'._("date_commission").'"',
    'commission.libelle as "'._("commission").'"',
    'dossier_commission.avis as "'._("avis").'"',
);
$displayed_field_commission_type = array(
    'commission_type.libelle as "'._("commission_type").'"',
);
$displayed_field_instructeur = array(
    'instructeur.nom as "'.__("instructeur").'"',
    'instructeur_secondaire.nom as "'.__("instructeur secondaire").'"'
);
$displayed_field_division = array(
    'division.code as "'._("division").'"',
);
$displayed_field_collectivite = array(
    'om_collectivite.libelle as "'._("collectivite").'"',
);
$displayed_fields_end = array(
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

/**
 * Gestion particulière de l'affichage du listing des consultations dans le
 * contexte d'un dossier d'instruction (pour l'instructeur)
 */
if ($retourformulaire == 'dossier' || $this->contexte_dossier_instruction()) {
    //
    $ent = " -> "._("commission");
    //
    $case_consultation_lu = "case when dossier_commission.avis = '' then ''
              else case dossier_commission.lu
                       when 't' then 'Oui'
                       else 'Non'
                   end
         end";
    //
    $champAffiche = array(
        'dossier_commission.dossier_commission as "'._("id").'"',
        'commission_type.libelle as "'._("commission_type").'"',
        'to_char(date_souhaitee ,\'DD/MM/YYYY\') as "'._("date_souhaitee").'"',
        'commission.code as "'._("commission").'"',
        'to_char(commission.date_commission ,\'DD/MM/YYYY\')  as "'._("date_commission").'"',
        "avis",
        $case_consultation_lu." as \""._("lu")."\"",
    );

    /**
     * Options
     */
    // On affiche le champ lu en gras
    $options[] = array(
        "type" => "condition",
        "field" => $case_consultation_lu,
        "case" => array(
                "0" => array(
                    "values" => array("Non", ),
                    "style" => "non_lu",
                    ),
                ),
        );

    // Surcharge bouton ajouter
    $tab_actions['corner']['ajouter'] =
    array('lien' => "".OM_ROUTE_SOUSFORM."&obj=$obj&amp;action=0&tri=&amp;objsf=$obj&premiersf=0&amp;retour=form&retourformulaire=$retourformulaire&amp;idxformulaire=$idxformulaire",
          'id' => "",
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix add-16" title="'._('Ajouter').'">'._('Ajouter').'</span>',
          'rights' => array('list' => array($obj, $obj.'_ajouter_instruction'), 'operator' => 'OR'),
    );
}

// Change le lien du contenu si on est dans une commission
if ($retourformulaire=='commission') {
    
    $tab_actions['left']['consulter'] =
    array('lien' => ''.OM_ROUTE_SOUSFORM.'&obj='.$obj.'&amp;action=1'.'&amp;idx=',
          'id' => '&amp;premier='.$premier.'&amp;retour=form&retourformulaire=commission',
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
          'rights' => array('list' => array($obj, $obj.'_modifier'), 'operator' => 'OR'),
          'ordre' => 10,);

    $tab_actions['content'] = $tab_actions['left']['consulter'];
    
    $tab_actions['corner']['ajouter'] = NULL;
}


// Gestion particulière de l'affichage du listing dans le contexte d'un dossier
// d'instruction
include "../sql/pgsql/dossier_instruction_droit_specifique_par_division.inc.php";

// Ajout de la gestion des groupes et confidentialité à la requête du listing
$sqlFiltreGroup = $this->get_sql_filtre_groupe($table.$selection);
$selection .= $sqlFiltreGroup['WHERE'];
$table .= $sqlFiltreGroup['FROM'];
// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];
