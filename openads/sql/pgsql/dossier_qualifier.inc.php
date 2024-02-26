<?php

//
include('../sql/pgsql/dossier_instruction.inc.php');
include "../sql/pgsql/app_om_tab_common_select.inc.php";

// Titre de la page
$ent = _("instruction")." -> "._("qualification")." -> "._("dossiers a qualifier");

//Actions du tableau
$tab_actions['left']['consulter'] =
    array('lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3'.'&amp;idx=',
          'id' => '&amp;premier='.$premier.'&amp;advs_id='.$advs_id.'&amp;tricol='.$tricol.'&amp;valide='.$valide.'&amp;retour=tab',
          'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
          'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
          'ordre' => 10,);
$tab_actions['content'] = $tab_actions['left']['consulter'];

$tab_actions['corner']['ajouter'] = "";
//
$champRecherche = array(
    'dossier.dossier as "'._("dossier").'"',
    $select__dossier_libelle__column_as,
    'demandeur.particulier_nom as "'._("petitionnaire particulier").'"',
    'demandeur.personne_morale_denomination as "'._("petitionnaire personne morale").'"',
    'instructeur.nom as "'.__("instructeur").'"',
    'instructeur_secondaire.nom as "'.__("instructeur secondaire").'"'
);
//
$selection .= "
        AND dossier.a_qualifier IS TRUE AND
        om_utilisateur.login = '".$_SESSION['login']."'";
        
$tri="ORDER BY dossier.date_depot, dossier.dossier";

?>
