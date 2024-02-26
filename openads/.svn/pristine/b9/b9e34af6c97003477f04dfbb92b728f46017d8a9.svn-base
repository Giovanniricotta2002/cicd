<?php
//$Id: document_numerise.inc.php 4418 2015-02-24 17:30:28Z tbenita $ 
//gen openMairie le 02/05/2013 15:03

include('../gen/sql/pgsql/document_numerise.inc.php');

$ent = _("dossiers d'instruction")." -> "._("Pièces & Documents");

$options[] = array(
    'type' => "pagination",
    'display' => false
);

$tab_actions['left']['previsualiser'] = array(
    'lien' => ''.OM_ROUTE_SOUSFORM.'&obj='.$obj.'&amp;action=400&amp;idx=',
    'id' => '&amp;tri='.$tricolsf.'&amp;objsf='.$obj.'&amp;premiersf='.$premier.'&amp;retourformulaire='.$retourformulaire.'&amp;idxformulaire='.$idxformulaire.'&amp;trisf='.$tricolsf.'&amp;retour=tab',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix preview-16" title="Prévisualiser">
                Prévisualiser
            </span>',
    'rights' => array('list' => array($obj, $obj . '_previsualiser'), 'operator' => 'OR'),
    'ordre' => 100,
    'ajax' => false
);

// Action sur la deuxième colonne de contenu
$tab_actions['specific_content'][1] = array(
    'lien' => OM_ROUTE_FORM.'&amp;snippet=file&amp;obj=document_numerise&amp;champ=uid&amp;id=',
    'id' => '" target="_blank',
    'rights' => array('list' => array($obj, $obj.'_tab'), 'operator' => 'OR'),
    'ordre' => 10,
    'ajax' => false,
    'condition' => array(
        "document_numerise",
        "document_numerise_uid_telecharger"
    )
);
$champAffiche=array(
    'document_numerise.document_numerise as "'.__("id").'"',
    'CONCAT(
        \'<span class="om-prev-icon reqmo-16" title="Télécharger">\',
        document_numerise.nom_fichier,
        \'</span>\'
    ) as "'.__("nom_fichier").'"',
    'document_numerise.description_type as "'.__("description").'"',
    );

$selection = "WHERE document_numerise.document_travail is true";
// Filtre listing sous formulaire - dossier_instruction
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (document_numerise.dossier = '".$f->db->escapeSimple($idxformulaire)."') 
        AND document_numerise.document_travail is true";
}

$champRecherche = array(
    'document_numerise.nom_fichier as "'.__("nom_fichier").'"',
    'document_numerise.description_type as "'.__("description").'"',
);

//remplace le bouton d'ajout par le bouton d'ajout spécifique aux documents de travail
$tab_actions['corner']['ajouter'] = array(
    'lien' => OM_ROUTE_SOUSFORM.'&obj='.$obj.'&amp;action=5',
    'id' => '&amp;advs_id='.$advs_id.'&amp;premiersf='.$premier.'&amp;trisf='.$tricol.'&amp;valide='.$valide.'&amp;retourformulaire='.$retourformulaire.'&amp;idxformulaire='.$idxformulaire.'&amp;retour=form',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix add-16" title="'.__('Ajouter').'">'.__('Ajouter').'</span>',
    'rights' => array('list' => array($obj, $obj.'_ajouter_document_travail'), 'operator' => 'OR'),
    'ordre' => 10,
);
?>