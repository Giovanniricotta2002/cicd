<?php
/**
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_instruction.inc.php 6128 2016-03-08 15:43:42Z jymadier $
 */

/*Etend la classe dossier*/
include('../sql/pgsql/dossier_instruction.inc.php');


$params = array(
    "statut_signature" => (isset($_GET['statut_signature']) ? $_GET['statut_signature'] : ""),
    "filtre" => (isset($_GET['filtre']) ? $_GET['filtre'] : ""),
    "tri" => (isset($_GET['tri']) ? $_GET['tri'] : ""),
    "message_help" => (isset($_GET['message_help']) ? $_GET['message_help'] : "")
);

if (isset($_GET['widget_recherche_id'])) {
    $params = unserialize($_SESSION['widget_recherche_id'][$_GET['widget_recherche_id']]);
}

require_once "../obj/om_widget.class.php";
$om_widget = new om_widget(0);
//
$conf = $om_widget->get_config_suivi_instruction_parametrable($params);

// Titre de la page
$ent = _("instruction")." -> "._("Suivi d'instruction parametrable");
//
$tab_description = $conf["message_help"];
// Aucune action de corner
$tab_actions['corner'] = array();

$tab_actions['left']['consulter'] = array(
    'lien' => ''.OM_ROUTE_FORM.'&obj=dossier_instruction&retour_widget=suivi_instruction_parametrable&widget_recherche_id='.$_GET['widget_recherche_id'].'&amp;action=3&amp;idx=',
    'id' => '',
    'lib' => '<span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'._('Consulter').'</span>',
    'rights' => array('list' => array($obj, $obj.'_consulter'), 'operator' => 'OR'),
    'ordre' => 10,
);
$tab_actions['content'] = $tab_actions['left']['consulter'];
// Aucun champ pour la recherche simple
$champRecherche = array();
// On cache la recherche simple
$options[] = array(
    "type" => "search",
    "display" => false,
);

//
$add_to_table = '';
$add_to_table .= " INNER JOIN ".DB_PREFIXE."dossier_instruction_type
    ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type";
if ((isset($conf['arguments']["evenement_type"])
    && is_null($conf['arguments']["evenement_type"]) === false
    && $conf['arguments']["evenement_type"] !== "") 
    || (isset($conf['arguments']["evenement_id"])
    && is_null($conf['arguments']["evenement_id"]) === false
    && $conf['arguments']["evenement_id"] !== "")
    || (isset($conf['arguments']["exclure_evenement_id"])
    && is_null($conf['arguments']["exclure_evenement_id"]) === false
    && $conf['arguments']["exclure_evenement_id"] !== "")
    || (isset($conf['arguments']["type_cl"])
    && is_null($conf['arguments']["type_cl"]) === false
    && $conf['arguments']["type_cl"] !== "")
    || (is_array($conf['arguments']['affichage_colonne'])
        && in_array('instruction', $conf['arguments']['affichage_colonne'])
        || $conf['arguments']['affichage_colonne'] == 'instruction'))  {
    //
    $add_to_table .= " INNER JOIN ".DB_PREFIXE."evenement ON instruction.evenement=evenement.evenement ";
}
if ((isset($conf['arguments']["statut_dossier"])
    && is_null($conf['arguments']["statut_dossier"]) === false
    && $conf['arguments']["statut_dossier"] !== ""))  {
    //
    $add_to_table .= " LEFT JOIN ".DB_PREFIXE."etat ON dossier.etat = etat.etat ";
}
if ((isset($conf['arguments']["signataire_description"])
    && is_null($conf['arguments']["signataire_description"]) === false
    && $conf['arguments']["signataire_description"] !== ""))  {
    //
    $add_to_table .= " INNER JOIN ".DB_PREFIXE."signataire_arrete
            ON instruction.signataire_arrete=signataire_arrete.signataire_arrete ";
}
if ((isset($conf['arguments']["codes_datd"])
    && is_null($conf['arguments']["codes_datd"]) === false
    && $conf['arguments']["codes_datd"] !== ""))  {
    //
    $add_to_table .= " LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation 
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille ";
}

$table .= sprintf('
    LEFT JOIN 
        (SELECT 
            dossier.dossier, count(instruction.instruction) as "count_instruction"
        FROM 
            %1$sdossier
        INNER JOIN 
            %1$sinstruction ON instruction.dossier = dossier.dossier
            AND (instruction.date_envoi_signature is NULL
                AND instruction.instruction = (
                    SELECT
                        MAX(instruction.instruction)
                    FROM
                        %1$sinstruction
                    WHERE
                        instruction.dossier = dossier.dossier
                ) OR instruction.date_envoi_signature = (
                    SELECT
                        MAX(instruction.date_envoi_signature)
                    FROM
                        %1$sinstruction
                    WHERE
                        instruction.dossier = dossier.dossier
                )
            )
        %3$s
        %2$s
        GROUP BY dossier.dossier
            ) as nb_instr_by_dossier
        ON dossier.dossier = nb_instr_by_dossier.dossier',
    DB_PREFIXE,
    $conf['query_ct_where'] != '' ? 'WHERE '.$conf['query_ct_where'] : '',
    $add_to_table
);

$selection .= sprintf(
    " %s nb_instr_by_dossier.count_instruction > 0",
    $selection == '' ? 'WHERE' : 'AND '
);

// Ajout des filtres dans la requête
$sqlFiltre = $om_widget->get_query_filter(
    sprintf(
        "%s
        WHERE 
            %s
        ",
        $table,
        $selection
    ),
    $conf['arguments']['filtre']
);

$table.= $sqlFiltre['FROM'];
$selection.= $sqlFiltre['WHERE'];
