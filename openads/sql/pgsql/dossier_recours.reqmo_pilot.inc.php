<?php
// Filtre des requêtes de group pour les reqmo
include ('../sql/pgsql/filter_group_reqmo.inc.php');

// Libellé de la requête
$reqmo['libelle']=_("Liste des dossiers de recours");

// Choix des champs à afficher
$reqmo['reference_dossier']='checked';
$reqmo['type_de_procedure']='checked';
$reqmo['date_de_recours']='checked';
$reqmo['petitionnaire']='checked';
$reqmo['requerant']='checked';
$reqmo['juriste']='checked';
$reqmo['nb_logements']='checked';
$reqmo['nb_logements_sociaux']='checked';

// Filtres
$reqmo['type_procedure']= "select dossier_autorisation_type_detaille, libelle from ".DB_PREFIXE."dossier_autorisation_type_detaille where code in ('REG', 'REC') order by libelle";
$reqmo['date_recours_debut'] = "../../....";
$reqmo['date_recours_fin'] = "../../....";
$reqmo['type']['type_procedure'] = 'integer';
$reqmo['type']['date_recours_debut'] = 'date';
$reqmo['type']['date_recours_fin'] = 'date';

// Traduction des libellés de colonne / filtre
_("reference_dossier"); // Numéro de dossier
_("type_procedure"); // Gracieux, Contentieux
_("type_de_procedure"); // Gracieux, Contentieux
_("date_de_recours"); // La date saisie lors de l'enregistrement du dossier
_("petitionnaire");
_("requerant");
_("nb_logements"); //  Le nombre de logements concernés par l'autorisation contestée
_("nb_logements_sociaux"); // Le nombre de logements sociaux concernés par l'autorisation contestée

// Dans le cas où l'option de l'arrondissement est activée
$reqmo_sql_select_arrondissement = "";
if ($f->getParameter('option_arrondissement') === 'true') {
    // Champ à afficher
    $reqmo['arrondissement']='checked';
    // Complétion de la requête
    $reqmo_sql_select_arrondissement = " [arr.libelle as arrondissement], ";
}

//Requête à effectuer
$reqmo['sql'] = sprintf("SELECT
[dossier.dossier_libelle as reference_dossier],
[CASE dossier_autorisation_type_detaille.code
    WHEN 'REG' THEN 'Gracieux'
    WHEN 'REC' THEN 'Contentieux'
    ELSE ''
END as type_de_procedure],
[to_char(dossier.date_depot ,'DD/MM/YYYY') as date_de_recours],
[CASE WHEN petitionnaire_principal.qualite='particulier' THEN
        TRIM(CONCAT(petitionnaire_principal.particulier_nom, ' ', petitionnaire_principal.particulier_prenom))
    ELSE
        TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, ' ', petitionnaire_principal.personne_morale_denomination))
    END as petitionnaire],
[CASE WHEN requerant_principal.qualite='particulier' THEN
        TRIM(CONCAT(requerant_principal.particulier_nom, ' ', requerant_principal.particulier_prenom))
    ELSE
        TRIM(CONCAT(requerant_principal.personne_morale_raison_sociale, ' ', requerant_principal.personne_morale_denomination))
    END as requerant],
[j.nom as juriste],
%s
[dtac.co_tot_log_nb as nb_logements],
[dtac.co_fin_lls_nb as nb_logements_sociaux]
FROM ".DB_PREFIXE."dossier
LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_dossier_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
    ) as petitionnaire_principal
    ON petitionnaire_principal.dossier = dossier.dossier
LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_dossier_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('requerant')
    ) as requerant_principal
    ON requerant_principal.dossier = dossier.dossier
LEFT JOIN ".DB_PREFIXE."instructeur j
ON j.instructeur = dossier.instructeur
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
AND LOWER(dossier_autorisation_type.affichage_form) = 'ctx re'
INNER JOIN ".DB_PREFIXE."groupe
ON dossier_autorisation_type.groupe = groupe.groupe
".$selection."
LEFT JOIN ".DB_PREFIXE."dossier ac
ON dossier.autorisation_contestee = ac.dossier
LEFT JOIN ".DB_PREFIXE."donnees_techniques dtac
ON dtac.dossier_instruction = ac.dossier
WHERE dossier.om_collectivite IN (<idx_collectivite>)
    AND dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = '[type_procedure]' AND 
    dossier.date_depot >=  '[date_recours_debut]' AND
    dossier.date_depot <=  '[date_recours_fin]'".
    $sqlFiltreSD.
"ORDER BY dossier.date_depot, dossier.dossier",
$reqmo_sql_select_arrondissement
);

?>
