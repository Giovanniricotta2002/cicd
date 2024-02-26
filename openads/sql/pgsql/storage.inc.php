<?php
/**
 *
 * @package openfoncier
 * @version SVN : $Id: storage.inc.php 10573 2021-10-14 12:43:35Z softime $
 */
//
require_once "../gen/sql/pgsql/storage.inc.php";

//
$tab_actions['corner']['ajouter'] = null;

//
if ($retourformulaire === 'sitadel') {

    $champAffiche = array(
        'storage.storage as "'.__("storage").'"',
        'storage.filename as "'.__("fichier").'"',
        'to_char(storage.creation_date, \'DD/MM/YYYY\') as "'.__("date de création").'"',
        'storage.creation_time as "'.__("heure de création").'"',
        'to_char(to_date(storage.info::json->>\'date_debut\', \'YYYY-MM-DD\'), \'DD/MM/YYYY\') as "'.__("date de début de la période").'"',
        'to_char(to_date(storage.info::json->>\'date_fin\', \'YYYY-MM-DD\'), \'DD/MM/YYYY\') as "'.__("date de fin de la période").'"',
    );
    if ($_SESSION['niveau'] === '2') {
        array_push($champAffiche, "om_collectivite.libelle as \""._("collectivite")."\"");
    }

    $selection = sprintf(
        " WHERE storage.type = '%s' %s ",
        $retourformulaire,
        $_SESSION['niveau'] !== '2' ? sprintf(" AND storage.om_collectivite = '%s' ", $_SESSION["collectivite"]) : ''
    );

    $tri = ' ORDER BY to_date(storage.info::json->>\'date_fin\', \'YYYY-MM-DD\') DESC NULLS LAST, storage.storage DESC ';

    $tab_actions['left']["telecharger"] = array(
        'lien' => OM_ROUTE_FORM.'&snippet=file&obj='.$obj.'&champ=uid&id=',
        'id' => '',
        'lib' => '<span class="om-icon om-icon-16 om-icon-fix reqmo-16" title="'.__('Télécharger').'">'.__('Télécharger').'</span>',
        'rights' => array('list' => array($obj, $obj.'_uid_telecharger'), 'operator' => 'OR'),
        'ordre' => 20,
        "target" => "_blank",
    );
}

//
if ($retourformulaire === 'rapport_instruction') {

    $table .= "LEFT JOIN ".DB_PREFIXE."rapport_instruction 
        ON storage.uid=rapport_instruction.om_fichier_rapport_instruction ";

    $champAffiche = array(
        'storage.storage as "'.__("storage").'"',
        'to_char(storage.creation_date, \'DD/MM/YYYY\') as "'.__("date de création").'"',
        'storage.creation_time as "'.__("heure de création").'"',
        'storage.info::json->>\'createur\' as "'.__("créateur").'"',
        '(storage.info::json->>\'version\')::int as "'.__("version").'"',
    );

    // Sélectionne toutes les versions du rapport d'instruction du dossier sauf la dernière
    // si le dossier est finalisé. Sinon c'est qu'il existe une version en cours d'édition
    // et donc que la dernière stocké n'est pas la dernière version du document.
    // La dernière version du rapport stocké dans storage est identifié par le fait que son uid
    // est identique a celui du rapport (dans la jointure). C'est la seule qui a une correspondance
    // dans la table rapport_instruction.
    $selection = sprintf(
        " WHERE storage.type = '%1\$s' AND storage.info::json->>'dossier' = '%2\$s'
        AND (rapport_instruction.om_final_rapport_instruction IS FALSE
            OR rapport_instruction.rapport_instruction IS NULL)",
        $retourformulaire,
        $idxformulaire,
        DB_PREFIXE
    );

    $tri = ' ORDER BY storage.info::json->>\'version\' DESC NULLS LAST, storage.storage DESC ';

    $tab_actions['left']["telecharger"] = array(
        'lien' => OM_ROUTE_FORM.'&snippet=file&obj='.$obj.'&champ=uid&id=',
        'id' => '',
        'lib' => '<span class="om-icon om-icon-16 om-icon-fix reqmo-16" title="'.__('Télécharger').'">'.__('Télécharger').'</span>',
        'rights' => array('list' => array($obj, $obj.'_uid_telecharger'), 'operator' => 'OR'),
        'ordre' => 20,
        "target" => "_blank",
    );
}
