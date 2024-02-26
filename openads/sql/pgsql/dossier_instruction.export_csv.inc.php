<?php

/**
 * Afin de ne pas afficher le code HTML utilisé pour le champ "nature des
 * travaux", il est nécessaire de redéclarer pour l'export csv, les champs à
 * afficher.
 */

// Récupère toutes les variables du script *.inc
include('../sql/pgsql/dossier_instruction.inc.php');



// Récupération du bon champs selon la qualité du demandeur
// On récupère le délégataire s'il est renseigné, sinon le pétitionnaire principal
$case_correspondant = "
CASE WHEN demandeur_delegataire.qualite IS NULL
    THEN CASE WHEN demandeur.qualite='particulier' 
            THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
        END
    ELSE CASE WHEN demandeur_delegataire.qualite='particulier' 
            THEN TRIM(CONCAT(demandeur_delegataire.particulier_nom, ' ', demandeur_delegataire.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_delegataire.personne_morale_raison_sociale, ' ', demandeur_delegataire.personne_morale_denomination)) 
        END
END
";

$surface_cree = "
CASE 
    WHEN donnees_techniques.su2_avt_shon1 IS NOT NULL
    OR donnees_techniques.su2_avt_shon2 IS NOT NULL
    OR donnees_techniques.su2_avt_shon3 IS NOT NULL
    OR donnees_techniques.su2_avt_shon4 IS NOT NULL
    OR donnees_techniques.su2_avt_shon5 IS NOT NULL
    OR donnees_techniques.su2_avt_shon6 IS NOT NULL
    OR donnees_techniques.su2_avt_shon7 IS NOT NULL
    OR donnees_techniques.su2_avt_shon8 IS NOT NULL
    OR donnees_techniques.su2_avt_shon9 IS NOT NULL
    OR donnees_techniques.su2_avt_shon10 IS NOT NULL
    OR donnees_techniques.su2_avt_shon11 IS NOT NULL
    OR donnees_techniques.su2_avt_shon12 IS NOT NULL
    OR donnees_techniques.su2_avt_shon13 IS NOT NULL
    OR donnees_techniques.su2_avt_shon14 IS NOT NULL
    OR donnees_techniques.su2_avt_shon15 IS NOT NULL
    OR donnees_techniques.su2_avt_shon16 IS NOT NULL
    OR donnees_techniques.su2_avt_shon17 IS NOT NULL
    OR donnees_techniques.su2_avt_shon18 IS NOT NULL
    OR donnees_techniques.su2_avt_shon19 IS NOT NULL
    OR donnees_techniques.su2_avt_shon20 IS NOT NULL
    OR donnees_techniques.su2_avt_shon21 IS NOT NULL
    OR donnees_techniques.su2_avt_shon22 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon1 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon2 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon3 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon4 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon5 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon6 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon7 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon8 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon9 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon10 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon11 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon12 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon13 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon14 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon15 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon16 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon17 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon18 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon19 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon20 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon21 IS NOT NULL
    OR donnees_techniques.su2_cstr_shon22 IS NOT NULL
    OR donnees_techniques.su2_chge_shon1 IS NOT NULL
    OR donnees_techniques.su2_chge_shon2 IS NOT NULL
    OR donnees_techniques.su2_chge_shon3 IS NOT NULL
    OR donnees_techniques.su2_chge_shon4 IS NOT NULL
    OR donnees_techniques.su2_chge_shon5 IS NOT NULL
    OR donnees_techniques.su2_chge_shon6 IS NOT NULL
    OR donnees_techniques.su2_chge_shon7 IS NOT NULL
    OR donnees_techniques.su2_chge_shon8 IS NOT NULL
    OR donnees_techniques.su2_chge_shon9 IS NOT NULL
    OR donnees_techniques.su2_chge_shon10 IS NOT NULL
    OR donnees_techniques.su2_chge_shon11 IS NOT NULL
    OR donnees_techniques.su2_chge_shon12 IS NOT NULL
    OR donnees_techniques.su2_chge_shon13 IS NOT NULL
    OR donnees_techniques.su2_chge_shon14 IS NOT NULL
    OR donnees_techniques.su2_chge_shon15 IS NOT NULL
    OR donnees_techniques.su2_chge_shon16 IS NOT NULL
    OR donnees_techniques.su2_chge_shon17 IS NOT NULL
    OR donnees_techniques.su2_chge_shon18 IS NOT NULL
    OR donnees_techniques.su2_chge_shon19 IS NOT NULL
    OR donnees_techniques.su2_chge_shon20 IS NOT NULL
    OR donnees_techniques.su2_chge_shon21 IS NOT NULL
    OR donnees_techniques.su2_chge_shon22 IS NOT NULL
    OR donnees_techniques.su2_demo_shon1 IS NOT NULL
    OR donnees_techniques.su2_demo_shon2 IS NOT NULL
    OR donnees_techniques.su2_demo_shon3 IS NOT NULL
    OR donnees_techniques.su2_demo_shon4 IS NOT NULL
    OR donnees_techniques.su2_demo_shon5 IS NOT NULL
    OR donnees_techniques.su2_demo_shon6 IS NOT NULL
    OR donnees_techniques.su2_demo_shon7 IS NOT NULL
    OR donnees_techniques.su2_demo_shon8 IS NOT NULL
    OR donnees_techniques.su2_demo_shon9 IS NOT NULL
    OR donnees_techniques.su2_demo_shon10 IS NOT NULL
    OR donnees_techniques.su2_demo_shon11 IS NOT NULL
    OR donnees_techniques.su2_demo_shon12 IS NOT NULL
    OR donnees_techniques.su2_demo_shon13 IS NOT NULL
    OR donnees_techniques.su2_demo_shon14 IS NOT NULL
    OR donnees_techniques.su2_demo_shon15 IS NOT NULL
    OR donnees_techniques.su2_demo_shon16 IS NOT NULL
    OR donnees_techniques.su2_demo_shon17 IS NOT NULL
    OR donnees_techniques.su2_demo_shon18 IS NOT NULL
    OR donnees_techniques.su2_demo_shon19 IS NOT NULL
    OR donnees_techniques.su2_demo_shon20 IS NOT NULL
    OR donnees_techniques.su2_demo_shon21 IS NOT NULL
    OR donnees_techniques.su2_demo_shon22 IS NOT NULL
    OR donnees_techniques.su2_sup_shon1 IS NOT NULL
    OR donnees_techniques.su2_sup_shon2 IS NOT NULL
    OR donnees_techniques.su2_sup_shon3 IS NOT NULL
    OR donnees_techniques.su2_sup_shon4 IS NOT NULL
    OR donnees_techniques.su2_sup_shon5 IS NOT NULL
    OR donnees_techniques.su2_sup_shon6 IS NOT NULL
    OR donnees_techniques.su2_sup_shon7 IS NOT NULL
    OR donnees_techniques.su2_sup_shon8 IS NOT NULL
    OR donnees_techniques.su2_sup_shon9 IS NOT NULL
    OR donnees_techniques.su2_sup_shon10 IS NOT NULL
    OR donnees_techniques.su2_sup_shon11 IS NOT NULL
    OR donnees_techniques.su2_sup_shon12 IS NOT NULL
    OR donnees_techniques.su2_sup_shon13 IS NOT NULL
    OR donnees_techniques.su2_sup_shon14 IS NOT NULL
    OR donnees_techniques.su2_sup_shon15 IS NOT NULL
    OR donnees_techniques.su2_sup_shon16 IS NOT NULL
    OR donnees_techniques.su2_sup_shon17 IS NOT NULL
    OR donnees_techniques.su2_sup_shon18 IS NOT NULL
    OR donnees_techniques.su2_sup_shon19 IS NOT NULL
    OR donnees_techniques.su2_sup_shon20 IS NOT NULL
    OR donnees_techniques.su2_sup_shon21 IS NOT NULL
    OR donnees_techniques.su2_sup_shon22 IS NOT NULL
    OR donnees_techniques.su2_tot_shon_tot IS NOT NULL
        THEN donnees_techniques.su2_tot_shon_tot
    ELSE donnees_techniques.su_tot_shon_tot
END";

$table .= sprintf('
LEFT JOIN (
    %1$slien_dossier_demandeur AS lien_dossier_demandeur_delegataire
    JOIN %1$sdemandeur as demandeur_delegataire
        ON lien_dossier_demandeur_delegataire.demandeur = demandeur_delegataire.demandeur AND demandeur_delegataire.type_demandeur = \'delegataire\'
    )
        ON dossier.dossier = lien_dossier_demandeur_delegataire.dossier AND lien_dossier_demandeur_delegataire.petitionnaire_principal IS FALSE
LEFT JOIN %1$sdonnees_techniques
    ON donnees_techniques.dossier_instruction = dossier.dossier
LEFT JOIN %1$sarchitecte
    ON architecte.architecte = donnees_techniques.architecte',
DB_PREFIXE) ;

// Permet l'ajout de la commune si l'option est activé
$champAffiche_debut_num_dossier = array(
    'dossier.dossier as "'._("dossier").'"',
    'dossier.dossier_libelle as "'._("dossier").'"',
);

if ($f->is_option_dossier_commune_enabled() === true) {
    $champAffiche_debut_num_dossier[] = "commune.libelle as \""._("commune")."\"";    
}

// Modifie la méthode de récupération de la nature des travaux
$champAffiche_debut_commun = array(
    $case_demandeur.' as "'._("petitionnaire").'"',
    $case_correspondant.' as "'.__("correspondant").'"',
    'TRIM(CONCAT(architecte.nom, \' \', architecte.prenom)) as "'.__("architecte (nom)").'"',
    'architecte.nom_cabinet as "'.__("architecte (cabinet)").'"',
    $trim_concat_terrain,
    'dossier_autorisation_type_detaille.libelle as "'._("nature_dossier").'"',
    'donnees_techniques.co_tot_log_nb as "'.__("nombre de logements créés").'"',
    $surface_cree.' as "'.__("surface créée").'"',
    'famille_travaux.famille_travaux_libelle as "'.__("Famille de travaux").'"',
    'nature_travaux.nature_travaux_libelle as "'.__("Nature de travaux").'"',
    'description_projet as "'.__("Description du projet").'"',
    'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("date_depot").'"',
    'to_char(dossier.date_complet ,\'DD/MM/YYYY\') as "'._("date_complet").'"',
    'CASE WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE 
        THEN to_char(dossier.date_limite_incompletude ,\'DD/MM/YYYY\') 
        ELSE to_char(dossier.date_limite ,\'DD/MM/YYYY\')
    END as "'._("date_limite").'"',
);

$champAffiche_demat = array(
    'dossier_platau.external_uid as "dossier Plat\'AU"',
    'consultation_platau.external_uid as "consultation Plat\'AU"',
    'pieces_platau.external_uid as "pièce(s) Plat\'AU"',
    'autres_platau.external_uid as "autres objets Plat\'AU"',
);
$champAffiche_demat_sc = array();
if ($f->is_option_mode_service_consulte_enabled() === true) {
    $champAffiche_demat_sc = array(
        'consultation_entrante.service_consultant_id as "'.__('Service consultant : identifiant').'"',
        'consultation_entrante.service_consultant_libelle as "'.__('Service consultant : libellé').'"',
    );
}

// Redéfinit la liste des champs à afficher
$champAffiche = array_merge(
    $champAffiche_debut_num_dossier,
    $champAffiche_debut_commun,
    array('instructeur.nom as "'.__("instructeur").'"',
          'division.code as "'.__("division").'"',
        ),
    $champAffiche_fin_commun,
    $champAffiche_demat,
    $champAffiche_demat_sc
);

?>
