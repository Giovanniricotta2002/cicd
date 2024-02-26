<?php
//$Id: bible.reqmo.inc.php 9245 2020-04-03 09:21:03Z softime $ 
//gen openMairie le 16/12/2019 16:21

$reqmo['libelle'] = __('reqmo-libelle-bible');
$reqmo['reqmo_libelle'] = __('reqmo-libelle-bible');
$ent = __('bible');
$reqmo['sql'] = sprintf('
    SELECT DISTINCT
        libelle,
        contenu,
        array_agg(ARRAY|stab|
            evenement::text,
            complement::text,
            automatique::text,
            dossier_autorisation_type::text,
            om_collectivite::text
        |etab|) as "codes {{evenement, complement, automatique, dossier_autorisation,_type, om_collectivite), ...}"
    FROM %1$sbible
    GROUP BY libelle, contenu
    ORDER BY %2$s
    ',
    DB_PREFIXE,
    '[tri]'
);
$reqmo['tri'] = array('libelle ASC', 'libelle DESC', 'contenu ASC', 'contenu DESC');
