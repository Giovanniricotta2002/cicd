<?php
//$Id: evenement.reqmo.inc.php 9245 2020-04-03 09:21:03Z softime $ 
//gen openMairie le 16/12/2019 16:21

$reqmo['libelle'] = __('reqmo-libelle-evenement');
$reqmo['reqmo_libelle'] = __('reqmo-libelle-evenement');
$ent = __('evenement');
$reqmo['sql'] = sprintf('
    SELECT
        evenement.evenement,
        evenement.libelle,
        evenement.type, evenement.lettretype,
        array_agg(ARRAY|stab|
            lien_dossier_instruction_type_evenement.dossier_instruction_type::text,
            CONCAT_WS(
                \' \',
                dossier_autorisation_type_detaille.code::text,
                dossier_instruction_type.libelle::text
            )
        |etab|) as dossier
    FROM %1$sevenement
    INNER JOIN %1$slien_dossier_instruction_type_evenement
        ON lien_dossier_instruction_type_evenement.evenement = evenement.evenement
    INNER JOIN %1$sdossier_instruction_type
        ON dossier_instruction_type.dossier_instruction_type = lien_dossier_instruction_type_evenement.dossier_instruction_type
    INNER JOIN %1$sdossier_autorisation_type_detaille
        ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille
    WHERE evenement.lettretype IS NOT NULL
        AND evenement.lettretype != \'\'
    GROUP BY evenement.evenement
    ORDER BY [tri]
    ',
    DB_PREFIXE,
    '[tri]'
);
$reqmo['tri'] = array('evenement.evenement ASC', 'evenement.evenement DESC', 'evenement.libelle ASC', 'evenement.libelle DESC', 'evenement.lettretype ASC', 'evenement.lettretype DESC');
