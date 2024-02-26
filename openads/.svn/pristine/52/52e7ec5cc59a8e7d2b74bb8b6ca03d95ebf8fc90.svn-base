<?php
/**
 * Surcharge de dossier_qualifier pour le profil qualificateur
 * pour afficher tous les dossiers à qualifier
 */

//
include('../sql/pgsql/dossier_qualifier.inc.php');

// Titre de la page
$ent = _("qualification")." -> "._("dossiers a qualifier");

//
$selection = "  WHERE
        groupe.code != 'CTX'
        AND dossier.a_qualifier IS TRUE";

// Surcharge du bouton consulter pour que le bouton retour retourne à cette page
$tab_actions['left']["consulter"] = 
    array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3'.'&amp;idx=',
              'id' => '&amp;retourformulaire=dossier_qualifier_qualificateur',
              'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
              'rights' => array('list' => array('dossier_instruction', 'dossier_instruction_consulter'), 'operator' => 'OR'),
              'ordre' => 10,
              'ajax' => false);
              
$tab_actions['content'] = $tab_actions['left']["consulter"] ;

// Ajout de la gestion des groupes et confidentialité à la requête du listing
$sqlFiltreGroup = $this->get_sql_filtre_groupe($table.$selection);
$selection .= $sqlFiltreGroup['WHERE'];
$table .= $sqlFiltreGroup['FROM'];
// Ajout du filtrage des sous dossier à la requête d'affichage du listing
$sqlFiltreSD = $this->get_sql_filtre_sous_dossier($table.$selection);
$selection .= $sqlFiltreSD['WHERE'];
$table .= $sqlFiltreSD['FROM'];
?>
