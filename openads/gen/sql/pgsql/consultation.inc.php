<?php
//$Id$ 
//gen openMairie le 22/02/2023 11:40

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("consultation");
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
$table = DB_PREFIXE."consultation
    LEFT JOIN ".DB_PREFIXE."avis_consultation 
        ON consultation.avis_consultation=avis_consultation.avis_consultation 
    LEFT JOIN ".DB_PREFIXE."categorie_tiers_consulte 
        ON consultation.categorie_tiers_consulte=categorie_tiers_consulte.categorie_tiers_consulte 
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON consultation.dossier=dossier.dossier 
    LEFT JOIN ".DB_PREFIXE."motif_consultation 
        ON consultation.motif_consultation=motif_consultation.motif_consultation 
    LEFT JOIN ".DB_PREFIXE."service 
        ON consultation.service=service.service 
    LEFT JOIN ".DB_PREFIXE."tiers_consulte 
        ON consultation.tiers_consulte=tiers_consulte.tiers_consulte ";
// SELECT 
$champAffiche = array(
    'consultation.consultation as "'.__("consultation").'"',
    'dossier.annee as "'.__("dossier").'"',
    'to_char(consultation.date_envoi ,\'DD/MM/YYYY\') as "'.__("date_envoi").'"',
    'to_char(consultation.date_retour ,\'DD/MM/YYYY\') as "'.__("date_retour").'"',
    'to_char(consultation.date_limite ,\'DD/MM/YYYY\') as "'.__("date_limite").'"',
    'service.libelle as "'.__("service").'"',
    'avis_consultation.libelle as "'.__("avis_consultation").'"',
    'to_char(consultation.date_reception ,\'DD/MM/YYYY\') as "'.__("date_reception").'"',
    'consultation.fichier as "'.__("fichier").'"',
    "case consultation.lu when 't' then 'Oui' else 'Non' end as \"".__("lu")."\"",
    'consultation.code_barres as "'.__("code_barres").'"',
    'consultation.om_fichier_consultation as "'.__("om_fichier_consultation").'"',
    "case consultation.om_final_consultation when 't' then 'Oui' else 'Non' end as \"".__("om_final_consultation")."\"",
    "case consultation.marque when 't' then 'Oui' else 'Non' end as \"".__("marque")."\"",
    "case consultation.visible when 't' then 'Oui' else 'Non' end as \"".__("visible")."\"",
    "case consultation.om_fichier_consultation_dossier_final when 't' then 'Oui' else 'Non' end as \"".__("om_fichier_consultation_dossier_final")."\"",
    "case consultation.fichier_dossier_final when 't' then 'Oui' else 'Non' end as \"".__("fichier_dossier_final")."\"",
    'consultation.nom_auteur as "'.__("nom_auteur").'"',
    'consultation.prenom_auteur as "'.__("prenom_auteur").'"',
    'consultation.qualite_auteur as "'.__("qualite_auteur").'"',
    'categorie_tiers_consulte.libelle as "'.__("categorie_tiers_consulte").'"',
    'tiers_consulte.libelle as "'.__("tiers_consulte").'"',
    'motif_consultation.libelle as "'.__("motif_consultation").'"',
    'consultation.fichier_pec as "'.__("fichier_pec").'"',
    );
//
$champNonAffiche = array(
    'consultation.motivation as "'.__("motivation").'"',
    'consultation.texte_fondement_avis as "'.__("texte_fondement_avis").'"',
    'consultation.texte_avis as "'.__("texte_avis").'"',
    'consultation.texte_hypotheses as "'.__("texte_hypotheses").'"',
    'consultation.commentaire as "'.__("commentaire").'"',
    'consultation.motif_pec as "'.__("motif_pec").'"',
    );
//
$champRecherche = array(
    'consultation.consultation as "'.__("consultation").'"',
    'dossier.annee as "'.__("dossier").'"',
    'service.libelle as "'.__("service").'"',
    'avis_consultation.libelle as "'.__("avis_consultation").'"',
    'consultation.fichier as "'.__("fichier").'"',
    'consultation.code_barres as "'.__("code_barres").'"',
    'consultation.om_fichier_consultation as "'.__("om_fichier_consultation").'"',
    'consultation.nom_auteur as "'.__("nom_auteur").'"',
    'consultation.prenom_auteur as "'.__("prenom_auteur").'"',
    'consultation.qualite_auteur as "'.__("qualite_auteur").'"',
    'categorie_tiers_consulte.libelle as "'.__("categorie_tiers_consulte").'"',
    'tiers_consulte.libelle as "'.__("tiers_consulte").'"',
    'motif_consultation.libelle as "'.__("motif_consultation").'"',
    'consultation.fichier_pec as "'.__("fichier_pec").'"',
    );
$tri="ORDER BY dossier.annee ASC NULLS LAST";
$edition="consultation";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "avis_consultation" => array("avis_consultation", ),
    "categorie_tiers_consulte" => array("categorie_tiers_consulte", ),
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    "motif_consultation" => array("motif_consultation", ),
    "service" => array("service", ),
    "tiers_consulte" => array("tiers_consulte", ),
);
// Filtre listing sous formulaire - avis_consultation
if (in_array($retourformulaire, $foreign_keys_extended["avis_consultation"])) {
    $selection = " WHERE (consultation.avis_consultation = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - categorie_tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["categorie_tiers_consulte"])) {
    $selection = " WHERE (consultation.categorie_tiers_consulte = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (consultation.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - motif_consultation
if (in_array($retourformulaire, $foreign_keys_extended["motif_consultation"])) {
    $selection = " WHERE (consultation.motif_consultation = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - service
if (in_array($retourformulaire, $foreign_keys_extended["service"])) {
    $selection = " WHERE (consultation.service = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - tiers_consulte
if (in_array($retourformulaire, $foreign_keys_extended["tiers_consulte"])) {
    $selection = " WHERE (consultation.tiers_consulte = ".intval($idxformulaire).") ";
}

