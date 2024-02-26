<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: consultation.inc.php 5851 2016-02-02 16:45:09Z nmeucci $
 */

//
include "../gen/sql/pgsql/consultation.inc.php";

/*Titre de la page*/
$ent = _("consultation");

// Traduction des termes technique du type de consultation.
// Pour les consultations des tiers et des service la traduction est la même
// sauf qu'on ne cherche pas les résultats dans la même table. Ce template
// existe donc pour pouvoir être utilisé dans les 2 cas sans réécrire ce code
$template_case_traduction_type_consultation =
    'CASE WHEN %1$s.type_consultation=\'avec_avis_attendu\' 
            THEN \''._("avec avis attendu").'\'
            WHEN %1$s.type_consultation=\'pour_conformite\' 
            THEN \''._("pour conformite").'\'
            WHEN %1$s.type_consultation=\'pour_information\' 
            THEN \''._("pour information").'\'
    END';
// Affichage du type de consultation traduit selon l'élément consulte (tiers ou service)
$case_type_consultation = sprintf(
    'CASE WHEN consultation.service IS NOT NULL
        THEN (%1$s)
        ELSE (%2$s)
    END',
    sprintf($template_case_traduction_type_consultation, 'service'),
    sprintf($template_case_traduction_type_consultation, 'motif_consultation')
);

// Affichage du nom du service ou du tiers consulte
$case_element_consulte =
"CASE WHEN consultation.service IS NOT NULL
    THEN concat(service.abrege, ' - ', service.libelle)
    ELSE concat(tiers_consulte.abrege, ' - ', tiers_consulte.libelle)
END";

$case_consultation_lu = "case consultation.lu when 't' then 'Oui' else 'Non' end";
$case_consultation_visible = "case consultation.visible when 't' then 'Oui' else 'Non' end";
// SELECT 
$champAffiche = array(
    'consultation.consultation as "'._("consultation").'"',
    'consultation.dossier as "'._("dossier").'"',
    'to_char(consultation.date_envoi ,\'DD/MM/YYYY\') as "'._("date_envoi").'"',
    'to_char(consultation.date_reception ,\'DD/MM/YYYY\') as "'._("date_reception").'"',
    'to_char(consultation.date_retour ,\'DD/MM/YYYY\') as "'._("date_retour").'"',
    'to_char(consultation.date_limite ,\'DD/MM/YYYY\') as "'._("date_limite").'"',
    $case_element_consulte.' as "'._("service / tiers").'"',
    $case_type_consultation.' as "'._("type_consultation").'"',
    'avis_consultation.libelle as "'._("avis_consultation").'"',
    'instructeur.nom as "'._("instructeur").'"',
    'division.code as "'._("division").'"',
    $case_consultation_lu." as \""._("lu")."\"",
    $case_consultation_visible." as \""._("visible")."\""
);

$table .= "
LEFT JOIN ".DB_PREFIXE."instructeur 
    ON instructeur.instructeur=dossier.instructeur
LEFT JOIN ".DB_PREFIXE."om_utilisateur
    ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
LEFT JOIN ".DB_PREFIXE."division 
    ON dossier.division=division.division";

$tri= "ORDER BY consultation.date_envoi ASC, consultation.consultation";

/**
 * Gestion particulière de l'affichage du listing des consultations dans le
 * contexte d'un dossier d'instruction (pour un service consulté)
 */
if ($retourformulaire == 'service') {
    // Actions en coin : ajouter
    $tab_actions['corner']['ajouter'] = NULL;
    // Actions a gauche : consulter
    $tab_actions['left']['consulter'] = NULL;
}

/**
 * Gestion particulière de l'affichage du listing des consultations dans le
 * contexte d'un dossier d'instruction (pour l'instructeur)
 */
if ($retourformulaire == 'dossier' || $this->contexte_dossier_instruction()) {
    //
    $case_consultation_lu = "case when consultation.avis_consultation is null then ''
              else case consultation.lu
                       when 't' then 'Oui'
                       else 'Non'
                   end
         end";

    // SELECT 
    $champAffiche = array(
        'consultation.consultation as "'._("id").'"',
        'to_char(consultation.date_envoi ,\'DD/MM/YYYY\') as "'._("date_envoi").'"',
        'to_char(consultation.date_reception ,\'DD/MM/YYYY\') as "'._("date_reception").'"',
        'to_char(consultation.date_retour ,\'DD/MM/YYYY\') as "'._("date_retour").'"',
        'to_char(consultation.date_limite ,\'DD/MM/YYYY\') as "'._("date_limite").'"',
        $case_element_consulte.' as "'._("service / tiers").'"',
        $case_type_consultation.' as "'._("type_consultation").'"',
        'avis_consultation.libelle as "'._("avis_consultation").'"',
        $case_consultation_lu." as \""._("lu")."\"",
        $case_consultation_visible." as \""._("visible")."\""
    );
    // Ajout d'une action supplémentaire - ajout de consultations multiples
    $tab_actions['corner']['ajouter_multiple'] =
    array('lien' => ''.OM_ROUTE_SOUSFORM.'&obj='.$obj.'&amp;action=40&amp;idx=0',
          'id' => '&amp;tri='.$tricolsf.'&amp;objsf='.$obj.'&amp;premiersf='.$premier.'&amp;retourformulaire='.$retourformulaire.'&amp;idxformulaire='.$idxformulaire.'&amp;trisf='.$tricolsf.'&amp;retour=tab',
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix omi-add-multiple-box-fill" title="'._('Ajouter plusieurs').'"></span>',
          'rights' => array('list' => array($obj, $obj.'_ajouter'), 'operator' => 'OR'),
          );
        
    // Ajout d'une action supplémentaire - ajout de consultations de tiers
    // Récupère une instance de consultation pour vérifier si des tiers sont paramétrés
    // et si c'est le cas l'action d'ajout de consultation vers des tiers peut être affiché
    $instConsultation = $this->get_inst__om_dbform(array(
        'obj' => 'consultation',
        'idx' => ']'
    ));
    if ($instConsultation->is_tiers_parametre()) {
        $tab_actions['corner']['ajouter_consultation_tiers'] = array(
            'lien' => ''.OM_ROUTE_SOUSFORM.'&obj='.$obj.'&amp;action=41&amp;idx=0',
            'id' => '&amp;tri='.$tricolsf.'&amp;objsf='.$obj.'&amp;premiersf='.$premier.'&amp;retourformulaire='.$retourformulaire.'&amp;idxformulaire='.$idxformulaire.'&amp;trisf='.$tricolsf.'&amp;retour=form',
            'lib' => '<span class="om-icon om-icon-16 om-icon-fix ri-add-box-fill ajout-tiers" title="'._('Ajouter consultation d\'un tiers').'"></span>',
            'rights' => array('list' => array($obj, $obj.'_ajouter_consultation_tiers'), 'operator' => 'OR')
        );
    }

    // Vérifie que l'utilisateur possède la permission bypass.
    // Vérifie que l'utilisateur est un instructeur, qu'il fait partie de la
    // division du dossier et que le dossier n'est pas clôturé.
    // Ces conditions sont identiques à la méthode can_show_or_hide_in_edition()
    // de la classe consultation permettant d'afficher ou cacher les actions
    // dans le portlet d'action du formulaire.
    // Il est nécessaire que ce if et cette méthode restent concordants en tout
    // point afin que le comportement des actions soit identique depuis le
    // formulaire et depuis le listing.
    if ($this->can_bypass("consultation", "visibilite_dans_edition") === true
        || ($this->getStatutDossier($idxformulaire) != "cloture")
            && ($this->isUserInstructeur() === true
                && $this->om_utilisateur["division"] == $this->get_division_from_dossier_without_inst($idxformulaire))) {

        // Ajout d'actions supplémentaires - Afficher et masquer un consultation dans les éditions
        $tab_actions['left']['masquer_dans_edition'] =
        array('lien' => ''.OM_ROUTE_SOUSFORM.'&obj='.$obj.'&amp;action=140&amp;idx=',
              'id' => '&amp;tri='.$tricolsf.'&amp;objsf='.$obj.'&amp;premiersf='.$premier.'&amp;retourformulaire='.$retourformulaire.'&amp;idxformulaire='.$idxformulaire.'&amp;trisf='.$tricolsf.'&amp;retour=tab',
              'lib' => "<span class=\"om-icon om-icon-16 om-icon-fix unwatch-16\" title=\""._("Masquer dans les éditions")."\">"._("Masquer dans les éditions")."</span>",
              'type' => 'action-direct',
              'rights' => array('list' => array('consultation', 'consultation_visibilite_dans_edition'), 'operator' => 'OR'),
              'ordre' => 100
              );

        $tab_actions['left']['afficher_dans_edition'] =
        array('lien' => ''.OM_ROUTE_SOUSFORM.'&obj='.$obj.'&amp;action=130&amp;idx=',
              'id' => '&amp;tri='.$tricolsf.'&amp;objsf='.$obj.'&amp;premiersf='.$premier.'&amp;retourformulaire='.$retourformulaire.'&amp;idxformulaire='.$idxformulaire.'&amp;trisf='.$tricolsf.'&amp;retour=tab',
              'lib' => "<span class=\"om-icon om-icon-16 om-icon-fix watch-16\" title=\""._("Afficher dans les éditions")."\">"._("Afficher dans les éditions")."</span>",
              'type' => 'action-direct',
              'rights' => array('list' => array('consultation', 'consultation_visibilite_dans_edition'), 'operator' => 'OR'),
              'ordre' => 110
              );



        // Création d'une option pour afficher l'affichage ou le masquage d'une
        // consultation dans les édition
        $options[] = array(
            'type' => 'condition',
            'field' => $case_consultation_visible,
            'case' => array(
                array(
                    'values' => array('Non', ),
                    'style' => 'afficher-consultation-edition',
                ),
                array(
                    'values' => array('Oui', ),
                    'style' => 'masquer-consultation-edition',
                ),
            ),
        );
    }
}
 
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

/**
 * Gestion particulière de l'affichage du listing dans le contexte d'un dossier
 * d'instruction
 */
include "../sql/pgsql/dossier_instruction_droit_specifique_par_division.inc.php";
// Ajout de la gestion des groupes et confidentialité à la requête du listing
$sqlFiltreGroup = $this->get_sql_filtre_groupe($table.$selection);
$selection .= $sqlFiltreGroup['WHERE'];
$table .= $sqlFiltreGroup['FROM'];
