<?php
// Filtre des requêtes de group pour les reqmo
include ('../sql/pgsql/filter_group_reqmo.inc.php');

//Libellé de la requête
$reqmo['libelle']=_("Repertoire des premiers depots de dossiers pour la DTTM");
$reqmo['om_sousetat']='dossier_premier_depot_dttm';
$reqmo['om_sousetat_orientation'] = 'L';
$reqmo['om_sousetat_format'] = 'A4';

//Choix des critères de tri
$reqmo['dossier_instruction_type']= "select dossier_instruction_type.dossier_instruction_type,
concat(dossier_autorisation_type_detaille.code,' - ',dossier_instruction_type.code,' - ',dossier_instruction_type.libelle) 
from ".DB_PREFIXE."dossier_instruction_type 
left join ".DB_PREFIXE."dossier_autorisation_type_detaille
on dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
INNER JOIN ".DB_PREFIXE."dossier_autorisation_type
    ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
    AND LOWER(dossier_autorisation_type.affichage_form) = 'ads'
INNER JOIN ".DB_PREFIXE."groupe
    ON dossier_autorisation_type.groupe = groupe.groupe
    ".$selection.$sqlFiltreSD."
order by dossier_autorisation_type_detaille.code, dossier_instruction_type.code";
$reqmo['date_depot_debut'] = "../../....";
$reqmo['date_depot_fin'] = "../../....";
//Type attendu pour les données
$reqmo['type']['dossier_instruction_type'] = 'integer';
$reqmo['type']['date_depot_debut'] = 'date';
$reqmo['type']['date_depot_fin'] = 'date';
$reqmo['type']['tri'] = 'string';
//
$reqmo['tri']= array('date_depot');

_("numero de dossier");
_("date de depot");
//Requête à effectuer
$reqmo['sql']="SELECT
dossier.dossier_libelle as \""._("numero de dossier")."\",
to_char(dossier.date_depot ,'DD/MM/YYYY') as \""._("date de depot")."\",
CONCAT(
CASE 
    WHEN demandeur.qualite='particulier' THEN 
        TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
    ELSE 
        TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
END, ' ',demandeur.numero, ' ', demandeur.voie, ' ',
demandeur.complement, ' ', demandeur.lieu_dit, ' ', 
demandeur.code_postal, ' ', demandeur.localite, ' ', CASE 
    WHEN demandeur.bp IS NULL THEN 
        '' 
    ELSE 
        CONCAT('BP ', demandeur.bp) 
END, ' ', CASE 
    WHEN demandeur.cedex IS NULL THEN 
        '' 
    ELSE 
        CONCAT('CEDEX ', demandeur.cedex) 
END, '
', demandeur.pays) as \""._("petitionnaire_principal")."\",
CONCAT(
dossier.terrain_adresse_voie_numero, ' ', dossier.terrain_adresse_voie, ' ', 
dossier.terrain_adresse_lieu_dit, ' ', 
dossier.terrain_adresse_code_postal, ' ', dossier.terrain_adresse_localite, ' ', CASE 
    WHEN dossier.terrain_adresse_bp IS NULL THEN 
        ''
    ELSE 
        CONCAT('BP ', dossier.terrain_adresse_bp)
END, ' ',CASE 
    WHEN dossier.terrain_adresse_cedex IS NULL THEN 
        ''
    ELSE 
        CONCAT('CEDEX ', dossier.terrain_adresse_cedex)
END, ' ',
arrondissement.libelle) as \""._("localisation")."\"
FROM ".DB_PREFIXE."dossier
LEFT JOIN ".DB_PREFIXE."lien_dossier_demandeur
ON lien_dossier_demandeur.dossier = dossier.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
LEFT JOIN ".DB_PREFIXE."demandeur
ON demandeur.demandeur = lien_dossier_demandeur.demandeur
LEFT JOIN ".DB_PREFIXE."arrondissement
ON arrondissement.code_postal = dossier.terrain_adresse_code_postal
LEFT JOIN ".DB_PREFIXE."dossier_instruction_type
ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type
WHERE dossier.om_collectivite IN (<idx_collectivite>)
    AND dossier_instruction_type.dossier_instruction_type = '[dossier_instruction_type]' AND 
    dossier.date_depot >=  '[date_depot_debut]' AND
    dossier.date_depot <=  '[date_depot_fin]'".
    $sqlFiltreSD.
"ORDER BY [tri], dossier.dossier";
?>