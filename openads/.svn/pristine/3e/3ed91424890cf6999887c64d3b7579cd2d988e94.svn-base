<?php
/**
 * Surcharge de dossier_instruction pour le profil qualificateur
 * et n'afficher que les dossiers qui ont une demande d'avis
 */

//
include('../sql/pgsql/dossier_instruction.inc.php');

//
$table .= " LEFT JOIN ".DB_PREFIXE."consultation 
        ON consultation.dossier = dossier.dossier ";

//
$selection .= " AND consultation.avis_consultation IS NULL ";

//
$tab_actions['left']["consulter"] = 
array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3'.'&amp;idx=',
          'id' => '&amp;retourformulaire=dossier_autorisation_avis',
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
          'rights' => array('list' => array('dossier_instruction', 'dossier_instruction_consulter'), 'operator' => 'OR'),
          'ordre' => 10,
          'ajax' => false);
          
$tab_actions['content'] = $tab_actions['left']["consulter"] ;

?>