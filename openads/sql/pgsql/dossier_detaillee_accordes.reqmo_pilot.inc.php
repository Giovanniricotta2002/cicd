<?php
// Filtre des requêtes de group pour les reqmo
include ('../sql/pgsql/filter_group_reqmo.inc.php');

// Variables utilitaires pour les reqmo
include ('../sql/pgsql/utils_reqmo.inc.php');

//Libellé de la requête
$reqmo['libelle']=_("Liste detaillee des dossiers accordes");

//Choix des champs à afficher
$reqmo['reference_dossier']='checked';
$reqmo['date_depot']='checked';
$reqmo['date_ouverture_chantier']='checked';
$reqmo['date_demande']='checked';
$reqmo['date_achevement']='checked';
$reqmo['date_prevue_recevabilite']='checked';
$reqmo['destination_surfaces']='checked';
$reqmo['coordonnees_petitionnaire_principal']='checked';
$reqmo['localisation']='checked';
$reqmo['reference_cadastrale']='checked';
$reqmo['date_decision']='checked';
$reqmo['shon']='checked';
$reqmo['affectation_surface']='checked';
$reqmo['nature_financement']='checked';
$reqmo['nombre_logements']='checked';
$reqmo['autorite_competente']='checked';
$reqmo['decision']='checked';

//Choix des critères de tri
$reqmo['dossier_autorisation_type']= "select dossier_autorisation_type, dossier_autorisation_type.code from ".DB_PREFIXE."dossier_autorisation_type inner join ".DB_PREFIXE."groupe ON dossier_autorisation_type.groupe = groupe.groupe ".$selection." AND LOWER(dossier_autorisation_type.affichage_form) = 'ads' order by code";
$reqmo['date_decision_debut'] = "../../....";
$reqmo['date_decision_fin'] = "../../....";
//Type attendu pour les données
$reqmo['type']['dossier_autorisation_type'] = 'integer';
$reqmo['type']['date_decision_debut'] = 'date';
$reqmo['type']['date_decision_fin'] = 'date';
$reqmo['type']['tri'] = 'string';
//
$reqmo['tri']= array('dossier.date_decision', 'dossier.date_depot');

//Traduction des champs
_("reference_dossier");
_("date_depot");
_("date_ouverture_chantier");
_("date_demande");
_("date_achevement");
_("date_prevue_recevabilite");
_("destination_surfaces");
_("coordonnees_petitionnaire_principal");
_("localisation");
_("reference_cadastrale");
_("date_decision");
_("shon");
_("affectation_surface");
_("nature_financement");
_("nombre_logements");
_("autorite_competente");
_("decision");

//Requête à effectuer
$reqmo['sql'] = "SELECT 
[dossier.dossier_libelle as reference_dossier],
[to_char(dossier.date_depot ,'DD/MM/YYYY') as date_depot],
[to_char(doc.date_depot ,'DD/MM/YYYY') as date_ouverture_chantier],
[to_char(dossier.date_demande ,'DD/MM/YYYY') as date_demande],
[to_char(daact.date_achevement ,'DD/MM/YYYY') as date_achevement],
[to_char(daact.date_conformite ,'DD/MM/YYYY') as date_prevue_recevabilite],
".$destination_surfaces.",
[CONCAT(
CASE 
    WHEN demandeur.qualite='particulier' THEN 
        TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
    ELSE 
        TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
END, '
',demandeur.numero, ' ', demandeur.voie, ' ',
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
', demandeur.pays) as coordonnees_petitionnaire_principal],
[CONCAT(
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
arrondissement.libelle) as localisation],
[dossier.terrain_references_cadastrales as reference_cadastrale],
[to_char(dossier.date_decision ,'DD/MM/YYYY') as date_decision],
".$shon.",
[REGEXP_REPLACE(CONCAT(
CASE 
    WHEN donnees_techniques.co_sp_transport IS TRUE THEN
        CONCAT('Transport / ') 
    ELSE 
        ''
END,
CASE 
    WHEN donnees_techniques.co_sp_enseign IS TRUE THEN
        CONCAT('Enseignement et recherche / ') 
    ELSE 
        ''
END,
CASE 
    WHEN donnees_techniques.co_sp_act_soc IS TRUE THEN
        CONCAT('Action sociale / ') 
    ELSE 
        ''
END,
CASE 
    WHEN donnees_techniques.co_sp_transport IS TRUE THEN
        CONCAT('Ouvrage spécial / ') 
    ELSE 
        ''
END,
CASE 
    WHEN donnees_techniques.co_sp_sante IS TRUE THEN
        CONCAT('Santé / ') 
    ELSE 
        ''
END,
CASE 
    WHEN donnees_techniques.co_sp_culture IS TRUE THEN
        CONCAT('Culture et loisir / ') 
    ELSE 
        ''
END), ' / $', '') as affectation_surface],
[REGEXP_REPLACE(CONCAT(
CASE 
    WHEN donnees_techniques.co_fin_lls_nb IS NULL THEN
        '' 
    ELSE 
        CONCAT('Logement Locatif Social / ')
END,
CASE 
    WHEN donnees_techniques.co_fin_aa_nb IS NULL THEN
        ''
    ELSE 
        CONCAT('Accession Sociale (hors prêt à taux zéro) / ') 
END,
CASE 
    WHEN donnees_techniques.co_fin_ptz_nb IS NULL THEN
        ''
    ELSE 
        CONCAT('Prêt à taux zéro / ') 
END,
CASE 
    WHEN donnees_techniques.co_fin_autr_nb IS NULL THEN
        '' 
    ELSE 
        CONCAT('Autres financements')
END), ' / $', '') as nature_financement],
[donnees_techniques.co_tot_log_nb as nombre_logements],
[autorite_competente.libelle as autorite_competente],
[avis_decision.libelle as decision]
FROM ".DB_PREFIXE."dossier
LEFT JOIN ".DB_PREFIXE."avis_decision
ON avis_decision.avis_decision = dossier.avis_decision
LEFT JOIN ".DB_PREFIXE."dossier_instruction_type
ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type
LEFT JOIN ".DB_PREFIXE."dossier_autorisation
ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
LEFT JOIN ".DB_PREFIXE."dossier as doc
ON doc.dossier_autorisation = dossier_autorisation.dossier_autorisation AND doc.dossier_instruction_type = (SELECT dossier_instruction_type FROM ".DB_PREFIXE."dossier_instruction_type as dit WHERE dit.code = 'DOC' AND dit.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille) 
LEFT JOIN ".DB_PREFIXE."dossier as daact
ON daact.dossier_autorisation = dossier_autorisation.dossier_autorisation AND daact.dossier_instruction_type = (SELECT dossier_instruction_type FROM ".DB_PREFIXE."dossier_instruction_type as dit WHERE dit.code = 'DAACT' AND dit.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille) 
LEFT JOIN ".DB_PREFIXE."donnees_techniques
ON donnees_techniques.dossier_instruction = dossier.dossier
LEFT JOIN ".DB_PREFIXE."lien_dossier_demandeur
ON lien_dossier_demandeur.dossier = dossier.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
LEFT JOIN ".DB_PREFIXE."demandeur
ON demandeur.demandeur = lien_dossier_demandeur.demandeur
LEFT JOIN ".DB_PREFIXE."arrondissement
ON arrondissement.code_postal = dossier.terrain_adresse_code_postal
LEFT JOIN ".DB_PREFIXE."autorite_competente
ON autorite_competente.autorite_competente = dossier.autorite_competente
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type
WHERE dossier.om_collectivite IN (<idx_collectivite>)
    AND dossier_autorisation_type.dossier_autorisation_type = '[dossier_autorisation_type]' AND 
    dossier.date_decision >=  '[date_decision_debut]' AND
    dossier.date_decision <=  '[date_decision_fin]' AND
    avis_decision.typeavis = 'F'".
    $sqlFiltreSD.
"ORDER BY [tri], dossier.dossier";
?>
