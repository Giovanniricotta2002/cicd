<?php
// Filtre des requêtes de group pour les reqmo
include ('../sql/pgsql/filter_group_reqmo.inc.php');

// Libellé de la requête
$reqmo['libelle']=_("Liste des dossiers DIA");

// Choix des champs à afficher
$reqmo['reference_dossier']='checked';
$reqmo['date_depot']='checked';
$reqmo['demandeur']='checked';
$reqmo['terrain_references_cadastrales']='checked';
$reqmo['terrain_adresse_voie_numero']='checked';
$reqmo['terrain_adresse_voie']='checked';
$reqmo['terrain_adresse_lieu_dit']='checked';
$reqmo['terrain_adresse_localite']='checked';
$reqmo['terrain_adresse_code_postal']='checked';
$reqmo['terrain_adresse_bp']='checked';
$reqmo['terrain_adresse_cedex']='checked';
$reqmo['dia_mod_cess_prix_vente']='checked';
$reqmo['dia_acquereur_nom_prenom']='checked';
$reqmo['commune_res_acquereur']='checked';
$reqmo['etat']='checked';
$reqmo['description_du_bien']='checked';
$reqmo['dia_su_co_sol']='checked';
$reqmo['dia_su_util_hab']='checked';
$reqmo['usage']='checked';
$reqmo['nb_niv']='checked';
$reqmo['nb_appart']='checked';
$reqmo['nb_autre_loc']='checked';
$reqmo['dia_vente_lot_volume']='checked';
$reqmo['vente_lot_volume_prec']='checked';
$reqmo['dia_bat_copro']='checked';
$reqmo['bat_copro_prec']='checked';
$reqmo['dia_indivi_quote_part']='checked';
$reqmo['dia_mod_cess_prix_vente_num']='checked';
$reqmo['dia_mod_cess_prix_vente_mob']='checked';
$reqmo['dia_mod_cess_prix_vente_cheptel']='checked';
$reqmo['dia_mod_cess_prix_vente_recol']='checked';
$reqmo['dia_mod_cess_prix_vente_autre']='checked';
$reqmo['dia_mod_cess_commi_mnt']='checked';
$reqmo['dia_esti_prix_france_dom']='checked';
$reqmo['dia_prop_collectivite']='checked';

//Choix des critères de tri
$reqmo['date_decision_debut'] = "../../....";
$reqmo['date_decision_fin'] = "../../....";

//Type attendu pour les données
$reqmo['type']['date_decision_debut'] = 'date';
$reqmo['type']['date_decision_fin'] = 'date';
$reqmo['type']['tri'] = 'string';

// Critères obligatoires
$reqmo['required'] = array(
    'date_decision_debut' => false,
    'date_decision_fin' => false,
    );

// Critères par défaut
$date_defaut_debut = '01/01/1900';
$date_defaut_fin = '01/01/2100';
$reqmo['default'] = array(
    'date_decision_debut' => $date_defaut_debut,
    'date_decision_fin' => $date_defaut_fin,
);

// Conditions à supprimer
$reqmo['conditions_to_delete'] = array(
    "AND dossier.date_decision >= '".$date_defaut_debut."' AND dossier.date_decision <= '".$date_defaut_fin."'",
);

// Affiche le champs de la collectivité si l'utilisateur connecté est lié à la
// collectivité de niveau 2
$reqmo_select_om_collective = '';
if ($_SESSION['niveau'] == '2') {
    //
    $reqmo['om_collectivite']='checked';
    $reqmo_select_om_collective = ",[om_collectivite.libelle as om_collectivite]";
}

// Traductions des champs
_("reference_dossier");
_("date_depot");
_("demandeur");
_("terrain_references_cadastrales");
_("terrain_adresse_voie_numero");
_("terrain_adresse_voie");
_("terrain_adresse_lieu_dit");
_("terrain_adresse_localite");
_("terrain_adresse_code_postal");
_("terrain_adresse_bp");
_("terrain_adresse_cedex");
_("dia_mod_cess_prix_vente");
_("dia_acquereur_nom_prenom");
_("commune_res_acquereur");
_("etat");
_("description_du_bien");
_("om_collectivite");
_("usage");
_("nb_niv");
_("nb_appart");
_("nb_autre_loc");
_("dia_vente_lot_volume");
_("vente_lot_volume_prec");
_("dia_bat_copro");
_("bat_copro_prec");
_("dia_indivi_quote_part");

// Requête à effectuer
$reqmo['sql'] = "
SELECT 
[dossier.dossier_libelle as reference_dossier], 
[to_char(dossier.date_depot, 'DD/MM/YYYY') as date_depot],
[CASE WHEN petitionnaire_principal.qualite='particulier' THEN
TRIM(CONCAT(petitionnaire_principal.particulier_nom, ' ', petitionnaire_principal.particulier_prenom))
ELSE
TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, ' ', petitionnaire_principal.personne_morale_denomination))
END as demandeur],
[CONCAT_WS(
    ' / ',
    CASE WHEN donnees_techniques.dia_imm_non_bati IS TRUE
        THEN TRIM('"._("dia_imm_non_bati")."')
        ELSE NULL
    END,
    CASE WHEN donnees_techniques.dia_imm_bati_terr_propr IS TRUE
        THEN TRIM('"._("dia_imm_bati_terr_propr")."')
        ELSE NULL
    END,
    CASE WHEN donnees_techniques.dia_imm_bati_terr_autr IS TRUE
        THEN TRIM('"._("dia_imm_bati_terr_autr")."')
        ELSE NULL
    END,
    CASE WHEN donnees_techniques.dia_bati_vend_tot IS TRUE
        THEN TRIM('"._("dia_bati_vend_tot")."')
        ELSE NULL
    END
) as description_du_bien],
[CASE WHEN donnees_techniques.dia_su_co_sol_num IS NOT NULL
    THEN donnees_techniques.dia_su_co_sol_num::text
    ELSE donnees_techniques.dia_su_co_sol
END as dia_su_co_sol],
[CASE WHEN donnees_techniques.dia_su_util_hab_num IS NOT NULL
    THEN donnees_techniques.dia_su_util_hab_num::text
    ELSE donnees_techniques.dia_su_util_hab
END as dia_su_co_sol],
[CONCAT_WS(
    ' / ',
    CASE WHEN donnees_techniques.dia_us_hab IS TRUE
        THEN TRIM('"._("dia_us_hab")."')
        ELSE NULL
    END,
    CASE WHEN donnees_techniques.dia_us_pro IS TRUE
        THEN TRIM('"._("dia_us_pro")."')
        ELSE NULL
    END,
    CASE WHEN donnees_techniques.dia_us_mixte IS TRUE
        THEN TRIM('"._("dia_us_mixte")."')
        ELSE NULL
    END,
    CASE WHEN donnees_techniques.dia_us_comm IS TRUE
        THEN TRIM('"._("dia_us_comm")."')
        ELSE NULL
    END,
    CASE WHEN donnees_techniques.dia_us_agr IS TRUE
        THEN TRIM('"._("dia_us_agr")."')
        ELSE NULL
    END,
    CASE WHEN donnees_techniques.dia_us_autre IS TRUE
        THEN TRIM('"._("dia_us_autre")."')
        ELSE NULL
    END
) as usage],
[donnees_techniques.dia_nb_niv as nb_niv],
[donnees_techniques.dia_nb_appart as nb_appart],
[donnees_techniques.dia_nb_autre_loc as nb_autre_loc],
[CASE WHEN donnees_techniques.dia_vente_lot_volume IS TRUE
    THEN 'Oui'
    ELSE 'Non'
END as dia_vente_lot_volume],
[donnees_techniques.dia_vente_lot_volume_txt as vente_lot_volume_prec],
[CASE WHEN donnees_techniques.dia_bat_copro IS TRUE
    THEN 'Oui'
    ELSE 'Non'
END as dia_bat_copro],
[donnees_techniques.dia_bat_copro_desc as bat_copro_prec],
[donnees_techniques.dia_indivi_quote_part as dia_indivi_quote_part],
[dossier.terrain_references_cadastrales as terrain_references_cadastrales],
[dossier.terrain_adresse_voie_numero as terrain_adresse_voie_numero], 
[dossier.terrain_adresse_voie as terrain_adresse_voie], 
[dossier.terrain_adresse_lieu_dit as terrain_adresse_lieu_dit], 
[dossier.terrain_adresse_localite as terrain_adresse_localite], 
[dossier.terrain_adresse_code_postal as terrain_adresse_code_postal],
[CASE WHEN dossier.terrain_adresse_bp IS NULL THEN '' ELSE CONCAT('BP ', dossier.terrain_adresse_bp) END as terrain_adresse_bp], 
[CASE WHEN dossier.terrain_adresse_cedex IS NULL THEN '' ELSE CONCAT('CEDEX ', dossier.terrain_adresse_cedex) END as terrain_adresse_cedex], 
[donnees_techniques.dia_mod_cess_prix_vente as dia_mod_cess_prix_vente],
[donnees_techniques.dia_mod_cess_prix_vente_num as dia_mod_cess_prix_vente_num],
[CASE WHEN donnees_techniques.dia_mod_cess_prix_vente_mob_num IS NOT NULL
    THEN donnees_techniques.dia_mod_cess_prix_vente_mob_num::text
    ELSE donnees_techniques.dia_mod_cess_prix_vente_mob
END as dia_mod_cess_prix_vente_mob],
[CASE WHEN donnees_techniques.dia_mod_cess_prix_vente_cheptel_num IS NOT NULL
    THEN donnees_techniques.dia_mod_cess_prix_vente_cheptel_num::text
    ELSE donnees_techniques.dia_mod_cess_prix_vente_cheptel
END as dia_mod_cess_prix_vente_cheptel],
[CASE WHEN donnees_techniques.dia_mod_cess_prix_vente_recol_num IS NOT NULL
    THEN donnees_techniques.dia_mod_cess_prix_vente_recol_num::text
    ELSE donnees_techniques.dia_mod_cess_prix_vente_recol
END as dia_mod_cess_prix_vente_recol],
[CASE WHEN donnees_techniques.dia_mod_cess_prix_vente_autre_num IS NOT NULL
    THEN donnees_techniques.dia_mod_cess_prix_vente_autre_num::text
    ELSE donnees_techniques.dia_mod_cess_prix_vente_autre
END as dia_mod_cess_prix_vente_autre],
[donnees_techniques.dia_mod_cess_commi_mnt as dia_mod_cess_commi_mnt],
[donnees_techniques.dia_esti_prix_france_dom as dia_esti_prix_france_dom],
[donnees_techniques.dia_prop_collectivite as dia_prop_collectivite],
[donnees_techniques.dia_acquereur_nom_prenom as dia_acquereur_nom_prenom],
[donnees_techniques.dia_acquereur_adr_localite as commune_res_acquereur],
[dossier.etat as etat]
".$reqmo_select_om_collective."
FROM ".DB_PREFIXE."dossier
INNER JOIN ".DB_PREFIXE."dossier_instruction_type
    ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
INNER JOIN ".DB_PREFIXE."donnees_techniques ON donnees_techniques.dossier_instruction = dossier.dossier
INNER JOIN ".DB_PREFIXE."avis_decision ON dossier.avis_decision = avis_decision.avis_decision
INNER JOIN ".DB_PREFIXE."dossier_autorisation
    ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
INNER JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
    ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
INNER JOIN ".DB_PREFIXE."om_collectivite
    ON om_collectivite.om_collectivite = dossier.om_collectivite
LEFT JOIN (
    SELECT *
    FROM ".DB_PREFIXE."lien_dossier_demandeur
    INNER JOIN ".DB_PREFIXE."demandeur
        ON demandeur.demandeur = lien_dossier_demandeur.demandeur
    WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = 'petitionnaire'
) as petitionnaire_principal
    ON petitionnaire_principal.dossier = dossier.dossier
INNER JOIN ".DB_PREFIXE."dossier_autorisation_type
    ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
    AND LOWER(dossier_autorisation_type.affichage_form) = 'ads'
INNER JOIN ".DB_PREFIXE."groupe
    ON dossier_autorisation_type.groupe = groupe.groupe
    ".$selection."
WHERE dossier.om_collectivite IN (<idx_collectivite>)
    AND dossier_autorisation_type_detaille.dossier_autorisation_type_detaille IN (<id_datd_filtre_reqmo_dossier_dia>)
    AND dossier.date_decision >=  '[date_decision_debut]'
    AND dossier.date_decision <=  '[date_decision_fin]'".
    $sqlFiltreSD.
"ORDER BY dossier.dossier ASC";
?>