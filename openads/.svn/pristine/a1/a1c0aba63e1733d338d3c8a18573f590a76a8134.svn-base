<?php
// Filtre des requêtes de group pour les reqmo
include ('../sql/pgsql/filter_group_reqmo.inc.php');

// Libellé de la requête
$reqmo['libelle']=_("Liste des dossiers d'infraction");

// Choix des champs à afficher
$reqmo['reference_dossier']='checked';
$reqmo['date_de_reception']='checked';
$reqmo['contrevenant']='checked';
$reqmo['terrain']='checked';
$reqmo['technicien']='checked';
$reqmo['date_transmission_parquet']='checked';
$reqmo['date_premiere_visite']='checked';

// Filtres
$reqmo['technicien_dossier']= "select t.instructeur, t.nom from ".DB_PREFIXE."instructeur t where t.instructeur_qualite = (select instructeur_qualite from ".DB_PREFIXE."instructeur_qualite where LOWER(code) = 'tech')";

$reqmo['date_reception_debut'] = "../../....";
$reqmo['date_reception_fin'] = "../../....";
$reqmo['type']['technicien_dossier'] = 'integer';
$reqmo['type']['date_reception_debut'] = 'date';
$reqmo['type']['date_reception_fin'] = 'date';

// Traduction des libellés de colonne / filtre
_("reference_dossier"); // Numéro de dossier
_("date_de_reception"); // La date saisie lors de l'enregistrement du dossier
_("technicien_dossier");
_("arrondissement_dossier");

// Dans le cas où l'option de l'arrondissement est activée
$reqmo_sql_select_arrondissement = "";
$reqmo_sql_where_arrondissement = "";
if ($f->getParameter('option_arrondissement') === 'true') {
    // Champ à afficher
    $reqmo['arrondissement']='checked';
    // Filtre
    $reqmo['arrondissement_dossier']= "select arrondissement, CASE libelle WHEN '1' THEN concat(libelle, 'er') ELSE concat(libelle, 'ème') END as libelle from ".DB_PREFIXE."arrondissement";
    $reqmo['type']['arrondissement_dossier'] = 'integer';
    // Complétion de la requête
    $reqmo_sql_select_arrondissement = " [arr.libelle as arrondissement], ";
    $reqmo_sql_where_arrondissement = " AND arr.arrondissement =  [arrondissement_dossier] ";
}

//Requête à effectuer
$reqmo['sql'] = sprintf("SELECT
[dossier.dossier_libelle as reference_dossier],
[to_char(dossier.date_depot ,'DD/MM/YYYY') as date_de_reception],
[CASE WHEN contrevenant_principal.qualite='particulier' THEN
        TRIM(CONCAT(contrevenant_principal.particulier_nom, ' ', contrevenant_principal.particulier_prenom))
    ELSE
        TRIM(CONCAT(contrevenant_principal.personne_morale_raison_sociale, ' ', contrevenant_principal.personne_morale_denomination))
    END as contrevenant],
[concat(replace(dossier.terrain_references_cadastrales,';',' '),'<br/>',
     dossier.terrain_adresse_voie,' ',
     dossier.terrain_adresse_code_postal) as terrain],
%s
[t.nom as technicien],
[to_char(dossier.date_transmission_parquet ,'DD/MM/YYYY') as date_transmission_parquet],
[to_char(dossier.date_premiere_visite ,'DD/MM/YYYY') as date_premiere_visite]
FROM ".DB_PREFIXE."dossier
LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_dossier_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('contrevenant')
    ) as contrevenant_principal
    ON contrevenant_principal.dossier = dossier.dossier
LEFT JOIN ".DB_PREFIXE."instructeur t
ON t.instructeur = dossier.instructeur_2
LEFT JOIN ".DB_PREFIXE."dossier_instruction_type
ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type
LEFT JOIN ".DB_PREFIXE."donnees_techniques dt
ON dt.dossier_instruction = dossier.dossier
LEFT JOIN ".DB_PREFIXE."arrondissement arr
ON arr.code_postal = dossier.terrain_adresse_code_postal
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type
    AND LOWER(dossier_autorisation_type.affichage_form) = 'ctx in'
INNER JOIN ".DB_PREFIXE."groupe
    ON dossier_autorisation_type.groupe = groupe.groupe
    ".$selection."
WHERE dossier.om_collectivite IN (<idx_collectivite>)
    AND dossier.instructeur_2 = [technicien_dossier]
    %s
    AND dossier.date_depot >=  '[date_reception_debut]'
    AND dossier.date_depot <=  '[date_reception_fin]'".
    $sqlFiltreSD.
"ORDER BY dossier.date_depot, dossier.dossier",
$reqmo_sql_select_arrondissement,
$reqmo_sql_where_arrondissement
);

?>
