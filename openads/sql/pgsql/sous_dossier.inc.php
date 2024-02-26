<?php
/**
 * Surcharge de dossier, identique à dossier_instruction mais est
 * seulement utilisé dans le script spécifique app/display_da_di.php
 *
 * @package openads
 * @version SVN : $Id: dossier_instruction_display_da_di.inc.php 6197 2016-03-17 13:26:06Z jymadier $
 */

/*Etend la classe dossier parent, par exemple pour un dossier contentieux on récupère
uniquement le paramétrage de ce type de dossier.
Par défaut récupère le paramétrage de base des dossiers*/
$objParent = ! empty($_SESSION['contexte_sous_dossier']['obj_parent']) ?
    $_SESSION['contexte_sous_dossier']['obj_parent'] :
    '';
if (! empty($objParent) && file_exists('../sql/pgsql/'.$objParent.'.inc.php')) {
    include('../sql/pgsql/'.$objParent.'.inc.php');
} else {
    include('../sql/pgsql/dossier.inc.php');
}

// Si aucun fichier n'est inclus alors le nombre d'élément à afficher ne sera
// pas défini. On le défini donc par défaut au cas où.
if (empty($serie)) {
    $serie=15;
}
// Réinitialiser du where pour éviter des erreurs lié au where des fichiers
// inclus
$selection = '';

/*Affichage des sous onglet pour les sous-dossiers*/

// Les onglets documents numérisé et contrainte(s) sont affiché en utilisant
// des vues et des conditions définie dans la classe dossiers. Notamment
// la condition permettant de vérifier le contexte d'affichage (check_contexte()).
// Cette méthode est surchargé pour les dossiers afin d'utiliser le contexte du
// dossier parent et pas celui du sous-dossier. Pour pouvoir utiliser cette
// surcharge, il faut faire appelle à la classe sous-dossier. On va donc modifier
// l'url d'affichage de ses onglets pour qu'ils utilisent la classe sous-dossier.

// Cas des sous onglets dans le contexte des contentieux
// Si l'objet a été défini dans le fichier relatif au contexte du parent alors on
// récupère sa valeur. Sinon on récupère l'objet du parent.
$parent = ! empty($f->get_submitted_get_value('retourformulaire')) ?
    $f->get_submitted_get_value('retourformulaire') :
    $f->get_submitted_get_value('?retourformulaire');
$getObj = ! empty($getObj) ? $getObj : $parent;
if (! empty($sousformulaire_parameters['dossier_contrainte_contexte_ctx']['href'])) {
    $sousformulaire_parameters['dossier_contrainte_contexte_ctx']['href'] =
        OM_ROUTE_FORM."&obj=sous_dossier&action=4&idx=".$idx."&retourformulaire=".$getObj."&";
}
if (! empty($sousformulaire_parameters['document_numerise_contexte_ctx']['href'])) {
    $sousformulaire_parameters['document_numerise_contexte_ctx']['href'] =
        OM_ROUTE_FORM."&obj=sous_dossier&action=5&idx=".$idx."&retourformulaire=".$getObj."&";
}
// Cas des sous onglets dans le contexte des dossiers d'instruction
if (! empty($sousformulaire_parameters['dossier_contrainte']['href'])) {
    $sousformulaire_parameters['dossier_contrainte']['href'] =
        OM_ROUTE_FORM."&obj=sous_dossier&action=4&idx=".$idx."&retourformulaire=".$getObj."&";
}
if (! empty($sousformulaire_parameters['document_numerise']['href'])) {
    $sousformulaire_parameters['document_numerise']['href'] =
        OM_ROUTE_FORM."&obj=sous_dossier&action=5&idx=".$idx."&retourformulaire=".$getObj."&";
}

// Non affichage de l'onglet sous-dossier pour les sous-dossiers
$posSousDossier = array_search('sous_dossier', $sousformulaire, true);
if ($posSousDossier != 'false') {
    unset($sousformulaire[$posSousDossier]);
    unset($sousformulaire_parameters['sous_dossier']);
}



/*Titre de la page*/
$ent = __("instruction")." -> ".__("sous-dossiers");

$champAffiche = array(
    'DISTINCT(dossier.dossier) as "'.__("sous-dossier").'"',
    'dossier.date_demande as "'.__('date de creation').'"',
    'dossier.etat as "'.__('etat').'"',
);
// Obligatoire pour que le distinct fonctionne
$tri="ORDER BY dossier.dossier";

$table = sprintf(
    '%1$sdossier
    LEFT JOIN %1$sdossier_instruction_type
        ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type
    -- Récupération des informations des demandeurs pour que la recherche simple
    -- sur les dossiers ne provoque pas d erreur à l affichage des listings
    -- des sous-dossiers
    -- Cela créé des doublons (notamment pour les dossier contentieux), il faut donc
    -- un DISTINCT sur la colonne dossier
    LEFT JOIN %1$slien_dossier_demandeur 
        ON lien_dossier_demandeur.dossier = dossier.dossier
            AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
    LEFT JOIN %1$sdemandeur
        ON lien_dossier_demandeur.demandeur = demandeur.demandeur',
    DB_PREFIXE
);

$obj = 'sous_dossier';

// Filtre les dossiers à afficher en fonction du type de sous-dossier passé en
// paramètre dans l'url.
// Gère également l'affichage du nom du listing
$typeSsDossier = $f->get_submitted_get_value('sous_dossier_type');

if ($typeSsDossier === 'sous_dossier_historique') {
    // Récupération des dossiers historique
    $tab_title = __('sous dossier historique');
    $table = sprintf(
        '%1$sdossier
        -- jointure permettant d accéder au type du dossier
        LEFT JOIN %1$sdossier_instruction_type
            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                AND dossier.dossier_instruction_type NOT IN (
                    SELECT
                        lien_type_DI_type_DI.dossier_instruction_type
                    FROM
                        %1$sdossier
                        LEFT JOIN %1$sdossier_instruction_type
                            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                        LEFT JOIN %1$slien_type_DI_type_DI
                            ON dossier_instruction_type.dossier_instruction_type = lien_type_DI_type_DI.type_di_parent
                    WHERE
                        dossier = \'%2$s\'
            )',
        DB_PREFIXE,
        $idxformulaire
    );
    $selection = sprintf(
        'WHERE
            -- Récupération uniquement des sous-dossier associé au dossier voulu
            dossier_instruction_type.sous_dossier IS TRUE
            AND dossier.dossier_parent = \'%1$s\'',
        $idxformulaire
    );
    // Il n'est pas possible d'ajouter des dossier historique
    $tab_actions['corner']['ajouter'] = null;
} elseif (is_numeric($typeSsDossier)) { // Vérifie si on a récupéré un identifiant de sous-dossier
    $tab_title = __($typeSsDossier);
    $selection = sprintf(
        'WHERE
            dossier_instruction_type.dossier_instruction_type = %1$s
            AND dossier.dossier_parent = \'%2$s\'',
        $typeSsDossier,
        $idxformulaire
    );

    // Bouton d'ajout d'un sous-dossier
    // Récupère une instance de sous-dossier pour vérifier si il existe un type de demande associée
    // au type de sous-dossier. 
    // Vérifie également si il existe plusieurs demande pour ce type de sous dossier.
    // Si l'un des deux cas est vrai alors on ne peut pas ajouter de sous-dossier et l'action
    // ne dois pas être affichée
    $tab_actions['corner']['ajouter'] = null;
    $instSsDossier = $this->get_inst__om_dbform(array(
        'obj' => 'sous_dossier',
        'idx' => 0
    ));
    $idTypeSsDossier = $this->get_submitted_get_value('sous_dossier_type');
    if ($instSsDossier->type_demande_existe_et_est_unique($idTypeSsDossier)) {
        // Action permettant d'ajouter la demande qui va déclencher la création du sous-dossier (SD)
        // et rediriger l'utilisateur vers le SD qu'il viens de créer.
        //
        // /!\ pour rediriger correctement l'utilisateur vers le formulaire de consultation
        //     du sous-dossier une surcharge de la méthode displayHeader() a été faite dans le
        //     fichier om_table.class.php.
        //     Suite à cette surcharge, les "corners" actions se feront toutes sans utiliser
        //     d'ajax a partir du moment ou l'url à pour paramètre :
        //         - obj = sous_dosssier
        //         - retourformulaire = dossier_instruction
        // Récupération du contexte du widget pour gérer la redirection vers le listing
        // du widget dans le contexte des sous-dossiers
        $cplmtUrlWidget = '';
        $retourWidget = $f->get_submitted_get_value('retour_widget');
        $widgetRechercheId = $f->get_submitted_get_value('widget_recherche_id');
        if (! empty($retourWidget) && !empty($widgetRechercheId)) {
            $cplmtUrlWidget = '&retour_widget='.$retourWidget.
                '&widget_recherche_id='.$widgetRechercheId;
        }
        $tab_actions['corner']['ajouter'] = array(
            'lien' => OM_ROUTE_FORM.'&obj='.$obj.'&amp;action=8',
            'id' =>
                '&amp;idxformulaire='.$idxformulaire.
                '&amp;retourformulaire='.$retourformulaire.
                '&amp;advs_id='.$advs_id.
                '&amp;premiersf='.$premier.
                '&amp;trisf='.$tricol.
                '&amp;valide='.$valide.
                '&amp;sous_dossier_type='.$typeSsDossier.
                $cplmtUrlWidget,
            'lib' => '<span class="om-icon om-icon-16 om-icon-fix add-16" title="'.__('Ajouter').'">'.__('Ajouter').'</span>',
            'ordre' => 10
        );
    }
}

// Si on a le nom du type de dossier on l'affiche dans la première colonne
$libTypeSsDossier = $f->get_submitted_get_value('sous_dossier_type_lib');

if (! empty($libTypeSsDossier)) {
    $champAffiche[0] = 'DISTINCT(dossier.dossier) as "'.$libTypeSsDossier.'"';
}

// Modification des actions de consultation pour accéder au sous_dossier en tant que formulaire
// et pas sous_formulaire

// Récupération du contexte d'accès au sous-dossier au moment ou il s'agit d'un sous
// formulaire. Une fois stocké on ne change plus les valeurs du contexte sauf si le
// contexte change
// /!\ Le contexte est récupéré via l'url qui est construite dans la fonction :
//        - sous_dossier->view_tab();
//     Pour les widgets le contexte est récupéré via l'url qui est paramétré pour
//     l'affichage du sous-onglet des sous-dossiers :
//        - dossier.inc.php
//     Il est ensuite récupéré de la même manière que le contexte.
//     Dans le cas de l'ouverture du sous-dossier suite à un ajout les paramètre de
//     widget et de retour sont envoyé dans l'url paramétré pour le bouton d'ajout :
//        - sous-dossier.inc.php
if (! empty($f->get_submitted_get_value('idxformulaire')) && $parent != 'sous_dossier') {
    $contexte = array(
        'obj_parent' => $parent,
        'idxformulaire_parent' => $f->get_submitted_get_value('idxformulaire'),
        'advs_id_parent' => $f->get_submitted_get_value('advs_id'),
        'widget_recherche_id' => $f->get_submitted_get_value('widget_recherche_id'),
        'retour_widget' => $f->get_submitted_get_value('retour_widget')
    );
    $_SESSION['contexte_sous_dossier'] = $contexte;
}

$tab_actions['content'] = array(
    'lien' => OM_ROUTE_FORM.'&obj=sous_dossier&action=3&idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
    'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
    'ordre' => 10,
    'ajax' => false
);

// Actions a gauche : consulter 
$tab_actions['left']['consulter'] = $tab_actions['content'];

$tab_title = __("DI");
?>
