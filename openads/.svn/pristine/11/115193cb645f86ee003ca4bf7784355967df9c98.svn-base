<?php
// Filtre des requêtes de group pour les reqmo
include ('../sql/pgsql/filter_group_reqmo.inc.php');

//Libellé de la requête
$reqmo['libelle']=_("Bordereau transmission DTTM pour signature prefet");
$reqmo['om_sousetat']='dossier_transmission_dttm_signature_prefet';
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
$reqmo['date_retour_signature_debut'] = "../../....";
$reqmo['date_retour_signature_fin'] = "../../....";
//Type attendu pour les données
$reqmo['type']['dossier_instruction_type'] = 'integer';
$reqmo['type']['date_retour_signature_debut'] = 'date';
$reqmo['type']['date_retour_signature_fin'] = 'date';
$reqmo['type']['tri'] = 'string';
//
$reqmo['tri']= array('dossier_autorisation_type.code', 'dossier.annee', 'dossier.version');

//Requête à effectuer
$reqmo['sql']="SELECT
dossier.dossier_libelle as \"numero de dossier\",
to_char(instruction.date_retour_signature, 'DD/MM/YYYY') as \"date de retour signature\",
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
', demandeur.pays) as \"petitionnaire principal\",
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
arrondissement.libelle) as \"localisation\"
FROM ".DB_PREFIXE."dossier
LEFT JOIN ".DB_PREFIXE."lien_dossier_demandeur
ON lien_dossier_demandeur.dossier = dossier.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
LEFT JOIN ".DB_PREFIXE."demandeur
ON demandeur.demandeur = lien_dossier_demandeur.demandeur
LEFT JOIN ".DB_PREFIXE."arrondissement
ON arrondissement.code_postal = dossier.terrain_adresse_code_postal
LEFT JOIN ".DB_PREFIXE."dossier_instruction_type
ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type
INNER JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
    ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
INNER JOIN ".DB_PREFIXE."dossier_autorisation_type
    ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
LEFT JOIN ".DB_PREFIXE."instruction
ON instruction.dossier = dossier.dossier
LEFT JOIN ".DB_PREFIXE."evenement
ON evenement.evenement = instruction.evenement
WHERE dossier.om_collectivite IN (<idx_collectivite>) AND
evenement.type = 'arrete' AND
instruction.date_retour_signature >=  '[date_retour_signature_debut]' AND
instruction.date_retour_signature <=  '[date_retour_signature_fin]' AND
dossier_instruction_type.dossier_instruction_type = '[dossier_instruction_type]'".
    $sqlFiltreSD.
"ORDER BY dossier.dossier, dossier.dossier";
?>