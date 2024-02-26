<?php
//$Id$ 
//gen openMairie le 15/04/2021 16:25

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("action");
if(!isset($premier)) $premier='';
if(!isset($tricolsf)) $tricolsf='';
if(!isset($premiersf)) $premiersf='';
if(!isset($selection)) $selection='';
if(!isset($retourformulaire)) $retourformulaire='';
if (!isset($idxformulaire)) {
    $idxformulaire = '';
}
if (!isset($tricol)) {
    $tricol = '';
}
if (!isset($valide)) {
    $valide = '';
}
// FROM 
$table = DB_PREFIXE."action";
// SELECT 
$champAffiche = array(
    'action.action as "'.__("action").'"',
    'action.libelle as "'.__("libelle").'"',
    'action.regle_etat as "'.__("regle_etat").'"',
    'action.regle_delai as "'.__("regle_delai").'"',
    'action.regle_accord_tacite as "'.__("regle_accord_tacite").'"',
    'action.regle_avis as "'.__("regle_avis").'"',
    'action.regle_date_limite as "'.__("regle_date_limite").'"',
    'action.regle_date_notification_delai as "'.__("regle_date_notification_delai").'"',
    'action.regle_date_complet as "'.__("regle_date_complet").'"',
    'action.regle_date_validite as "'.__("regle_date_validite").'"',
    'action.regle_date_decision as "'.__("regle_date_decision").'"',
    'action.regle_date_chantier as "'.__("regle_date_chantier").'"',
    'action.regle_date_achevement as "'.__("regle_date_achevement").'"',
    'action.regle_date_conformite as "'.__("regle_date_conformite").'"',
    'action.regle_date_rejet as "'.__("regle_date_rejet").'"',
    'action.regle_date_dernier_depot as "'.__("regle_date_dernier_depot").'"',
    'action.regle_date_limite_incompletude as "'.__("regle_date_limite_incompletude").'"',
    'action.regle_delai_incompletude as "'.__("regle_delai_incompletude").'"',
    'action.regle_autorite_competente as "'.__("regle_autorite_competente").'"',
    'action.regle_date_cloture_instruction as "'.__("regle_date_cloture_instruction").'"',
    'action.regle_date_premiere_visite as "'.__("regle_date_premiere_visite").'"',
    'action.regle_date_derniere_visite as "'.__("regle_date_derniere_visite").'"',
    'action.regle_date_contradictoire as "'.__("regle_date_contradictoire").'"',
    'action.regle_date_retour_contradictoire as "'.__("regle_date_retour_contradictoire").'"',
    'action.regle_date_ait as "'.__("regle_date_ait").'"',
    'action.regle_date_transmission_parquet as "'.__("regle_date_transmission_parquet").'"',
    'action.regle_donnees_techniques1 as "'.__("regle_donnees_techniques1").'"',
    'action.regle_donnees_techniques2 as "'.__("regle_donnees_techniques2").'"',
    'action.regle_donnees_techniques3 as "'.__("regle_donnees_techniques3").'"',
    'action.regle_donnees_techniques4 as "'.__("regle_donnees_techniques4").'"',
    'action.regle_donnees_techniques5 as "'.__("regle_donnees_techniques5").'"',
    'action.cible_regle_donnees_techniques1 as "'.__("cible_regle_donnees_techniques1").'"',
    'action.cible_regle_donnees_techniques2 as "'.__("cible_regle_donnees_techniques2").'"',
    'action.cible_regle_donnees_techniques3 as "'.__("cible_regle_donnees_techniques3").'"',
    'action.cible_regle_donnees_techniques4 as "'.__("cible_regle_donnees_techniques4").'"',
    'action.cible_regle_donnees_techniques5 as "'.__("cible_regle_donnees_techniques5").'"',
    'action.regle_dossier_instruction_type as "'.__("regle_dossier_instruction_type").'"',
    'action.regle_date_affichage as "'.__("regle_date_affichage").'"',
    'action.regle_pec_metier as "'.__("regle_pec_metier").'"',
    'action.regle_a_qualifier as "'.__("regle_a_qualifier").'"',
    'action.regle_incompletude as "'.__("regle_incompletude").'"',
    'action.regle_incomplet_notifie as "'.__("regle_incomplet_notifie").'"',
    'action.regle_etat_pendant_incompletude as "'.__("regle_etat_pendant_incompletude").'"',
    'action.regle_evenement_suivant_tacite_incompletude as "'.__("regle_evenement_suivant_tacite_incompletude").'"',
    );
//
$champNonAffiche = array(
    );
//
$champRecherche = array(
    'action.action as "'.__("action").'"',
    'action.libelle as "'.__("libelle").'"',
    'action.regle_etat as "'.__("regle_etat").'"',
    'action.regle_delai as "'.__("regle_delai").'"',
    'action.regle_accord_tacite as "'.__("regle_accord_tacite").'"',
    'action.regle_avis as "'.__("regle_avis").'"',
    'action.regle_date_limite as "'.__("regle_date_limite").'"',
    'action.regle_date_notification_delai as "'.__("regle_date_notification_delai").'"',
    'action.regle_date_complet as "'.__("regle_date_complet").'"',
    'action.regle_date_validite as "'.__("regle_date_validite").'"',
    'action.regle_date_decision as "'.__("regle_date_decision").'"',
    'action.regle_date_chantier as "'.__("regle_date_chantier").'"',
    'action.regle_date_achevement as "'.__("regle_date_achevement").'"',
    'action.regle_date_conformite as "'.__("regle_date_conformite").'"',
    'action.regle_date_rejet as "'.__("regle_date_rejet").'"',
    'action.regle_date_dernier_depot as "'.__("regle_date_dernier_depot").'"',
    'action.regle_date_limite_incompletude as "'.__("regle_date_limite_incompletude").'"',
    'action.regle_delai_incompletude as "'.__("regle_delai_incompletude").'"',
    'action.regle_autorite_competente as "'.__("regle_autorite_competente").'"',
    'action.regle_date_cloture_instruction as "'.__("regle_date_cloture_instruction").'"',
    'action.regle_date_premiere_visite as "'.__("regle_date_premiere_visite").'"',
    'action.regle_date_derniere_visite as "'.__("regle_date_derniere_visite").'"',
    'action.regle_date_contradictoire as "'.__("regle_date_contradictoire").'"',
    'action.regle_date_retour_contradictoire as "'.__("regle_date_retour_contradictoire").'"',
    'action.regle_date_ait as "'.__("regle_date_ait").'"',
    'action.regle_date_transmission_parquet as "'.__("regle_date_transmission_parquet").'"',
    'action.regle_donnees_techniques1 as "'.__("regle_donnees_techniques1").'"',
    'action.regle_donnees_techniques2 as "'.__("regle_donnees_techniques2").'"',
    'action.regle_donnees_techniques3 as "'.__("regle_donnees_techniques3").'"',
    'action.regle_donnees_techniques4 as "'.__("regle_donnees_techniques4").'"',
    'action.regle_donnees_techniques5 as "'.__("regle_donnees_techniques5").'"',
    'action.cible_regle_donnees_techniques1 as "'.__("cible_regle_donnees_techniques1").'"',
    'action.cible_regle_donnees_techniques2 as "'.__("cible_regle_donnees_techniques2").'"',
    'action.cible_regle_donnees_techniques3 as "'.__("cible_regle_donnees_techniques3").'"',
    'action.cible_regle_donnees_techniques4 as "'.__("cible_regle_donnees_techniques4").'"',
    'action.cible_regle_donnees_techniques5 as "'.__("cible_regle_donnees_techniques5").'"',
    'action.regle_dossier_instruction_type as "'.__("regle_dossier_instruction_type").'"',
    'action.regle_date_affichage as "'.__("regle_date_affichage").'"',
    'action.regle_pec_metier as "'.__("regle_pec_metier").'"',
    'action.regle_a_qualifier as "'.__("regle_a_qualifier").'"',
    'action.regle_incompletude as "'.__("regle_incompletude").'"',
    'action.regle_incomplet_notifie as "'.__("regle_incomplet_notifie").'"',
    'action.regle_etat_pendant_incompletude as "'.__("regle_etat_pendant_incompletude").'"',
    'action.regle_evenement_suivant_tacite_incompletude as "'.__("regle_evenement_suivant_tacite_incompletude").'"',
    );
$tri="ORDER BY action.libelle ASC NULLS LAST";
$edition="action";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'evenement',
    'instruction',
);

