<?php
//$Id: signataire_arrete.inc.php 4651 2015-04-26 09:15:48Z tbenita $ 
//gen openMairie le 16/01/2013 10:15

include('../gen/sql/pgsql/signataire_arrete.inc.php');
$ent = _("parametrage")." -> "._("organisation")." -> "._("signataire_arrete");

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
);

// Modification de l'ordre des champs pour respecter celui du formulaire
$champAffiche = array(
    'signataire_arrete.signataire_arrete as "'.__("signataire_arrete").'"',
    'civilite.libelle as "'.__("civilite").'"',
    'signataire_arrete.nom as "'.__("nom").'"',
    'signataire_arrete.prenom as "'.__("prenom").'"',
    'signataire_arrete.qualite as "'.__("qualite").'"',
    'signataire_habilitation.libelle as "'.__("Type d'habilitation").'"',
    "case signataire_arrete.defaut when 't' then 'Oui' else 'Non' end as \"".__("defaut")."\"",
    'to_char(signataire_arrete.om_validite_debut ,\'DD/MM/YYYY\') as "'.__("om_validite_debut").'"',
    'to_char(signataire_arrete.om_validite_fin ,\'DD/MM/YYYY\') as "'.__("om_validite_fin").'"',
    'signataire_arrete.email as "'.__("email").'"',
    'signataire_arrete.description as "'.__("description").'"',
    );


if ($_SESSION['niveau'] == '2') {
    array_push($champAffiche, "om_collectivite.libelle as \"".__("om_collectivite")."\"");
}


// Mise en place de la recherche avancé et de l'export csv des signataire
$champs['signataire_arrete'] = array(
    'libelle' => _('signataire_arrete'),
    'help' => _("Recherche dans les champs : nom, prénom. 

La chaîne recherchée doit figurer dans l'un de ces champs.

Par exemple, dans le cas d'un demandeur avec le nom 'DUPONT' et le prénom 'JEAN' :
- la recherche de 'JEAN' donne des résultats car le champ prénom contient 'JEAN',
- la recherche de 'DUPONT' donne des résultats car le champ nom contient 'DUPONT',
- la recherche de 'DUPONT JEAN' ne donne aucun résultat car ni le nom ni le prénom ni la civilité ne contient 'DUPONT JEAN'."),
    'type' => 'text',
    'table' => 'signataire_arrete',
    'colonne' => array(
        'nom',
        'prenom'
    ),
    'taille' => 30,
    'max' => '',
);

$champs['qualite'] = array(
    'libelle' => _('qualité'),
    'type' => 'text',
    'table' => 'signataire_arrete',
    'colonne' => 'qualite',
    'taille' => 30,
    'max' => '',
);

$champs['signataire_habilitation'] = array(
    'libelle' => _('type d\'habilitation'),
    'type' => 'text',
    'table' => 'signataire_habilitation',
    'colonne' => 'libelle',
    'taille' => 30,
    'max' => '',
);

$champs['defaut'] = array(
    'libelle' => _('signataire par defaut'),
    'type' => 'select',
    'table' => 'signataire_arrete',
    'colonne' => 'defaut',
    'subtype' => 'manualselect',
    'args' => array(
        0 => array("", "t", "f", ),
        1 => array(_("choisir"), _("Oui"), _("Non"), ),
    ),
);

$champs['email'] = array(
    'libelle' => _('email'),
    'type' => 'text',
    'colonne' => 'email',
    'table' => 'signataire_arrete',
    'taille' => 30,
    'max' => '',
);

$champs['description'] = array(
    'libelle' => _('description'),
    'type' => 'text',
    'colonne' => 'description',
    'table' => 'signataire_arrete',
    'taille' => 30,
    'max' => '',
);

if ($_SESSION['niveau'] == '2') {
    $champs['om_collectivite'] = array(
        'table' => 'signataire_arrete',
        'colonne' => 'om_collectivite',
        'type' => 'select',
        'libelle' => __('om_collectivite')
    );
}

$champs['date_validite_debut'] = array(
    'libelle'=> _("debut de validite"),
    'type' => 'date',
    'table' => 'signataire_arrete',
    'lib1'=> _("apres"),
    'lib2' => _("avant"),
    'colonne' => 'om_validite_debut',
    'taille' => 8,
    'where' => 'intervaldate',
);

$champs['date_validite_fin'] = array(
    'libelle'=> _("fin de validite"),
    'type' => 'date',
    'table' => 'signataire_arrete',
    'lib1'=> _("apres"),
    'lib2' => _("avant"),
    'colonne' => 'om_validite_fin',
    'taille' => 8,
    'where' => 'intervaldate',
);

if ($f->get_submitted_get_value('mode') === 'export_csv') {
    // ajouter les select signature, parametre parapheur, agrement et visa
    $champExport = array(
        'signataire_arrete.signature as "'.__("signature").'"',
        'signataire_arrete.parametre_parapheur as "'.__("parametre_parapheur").'"',
        'signataire_arrete.agrement as "'.__("agrement").'"',
        'signataire_arrete.visa as "'.__("visa").'"',
        'signataire_habilitation.code as "'.__("code").'"',
        'signataire_habilitation.description as "'.__("description").'"',
        'signataire_habilitation.om_validite_debut as "'.__("om_validite_debut").'"',
        'signataire_habilitation.om_validite_fin as "'.__("om_validite_fin").'"'
    );
    $champAffiche = array_merge($champAffiche, $champExport);
}

// advsearch -> options
$options[] = array(
    'type' => 'search',
    'display' => true,
    'advanced'  => $champs,
    'default_form'  => 'advanced',
    'absolute_object' => 'signataire_arrete',
    'export' => array("csv"),
);
?>
