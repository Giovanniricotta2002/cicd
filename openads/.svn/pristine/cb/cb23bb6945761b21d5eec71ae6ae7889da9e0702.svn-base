<?php
//$Id$ 
//gen openMairie le 05/06/2023 16:57

$DEBUG=0;
$serie=15;
$ent = __("application")." -> ".__("instruction");
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
$table = DB_PREFIXE."instruction
    LEFT JOIN ".DB_PREFIXE."action 
        ON instruction.action=action.action 
    LEFT JOIN ".DB_PREFIXE."etat as etat1 
        ON instruction.archive_etat_pendant_incompletude=etat1.etat 
    LEFT JOIN ".DB_PREFIXE."evenement as evenement2 
        ON instruction.archive_evenement_suivant_tacite=evenement2.evenement 
    LEFT JOIN ".DB_PREFIXE."evenement as evenement3 
        ON instruction.archive_evenement_suivant_tacite_incompletude=evenement3.evenement 
    LEFT JOIN ".DB_PREFIXE."autorite_competente 
        ON instruction.autorite_competente=autorite_competente.autorite_competente 
    LEFT JOIN ".DB_PREFIXE."avis_decision 
        ON instruction.avis_decision=avis_decision.avis_decision 
    LEFT JOIN ".DB_PREFIXE."document_numerise 
        ON instruction.document_numerise=document_numerise.document_numerise 
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON instruction.dossier=dossier.dossier 
    LEFT JOIN ".DB_PREFIXE."etat as etat8 
        ON instruction.etat=etat8.etat 
    LEFT JOIN ".DB_PREFIXE."evenement as evenement9 
        ON instruction.evenement=evenement9.evenement 
    LEFT JOIN ".DB_PREFIXE."pec_metier 
        ON instruction.pec_metier=pec_metier.pec_metier 
    LEFT JOIN ".DB_PREFIXE."signataire_arrete 
        ON instruction.signataire_arrete=signataire_arrete.signataire_arrete ";
// SELECT 
$champAffiche = array(
    'instruction.instruction as "'.__("instruction").'"',
    'instruction.destinataire as "'.__("destinataire").'"',
    'to_char(instruction.date_evenement ,\'DD/MM/YYYY\') as "'.__("date_evenement").'"',
    'evenement9.libelle as "'.__("evenement").'"',
    'instruction.lettretype as "'.__("lettretype").'"',
    'dossier.annee as "'.__("dossier").'"',
    'action.libelle as "'.__("action").'"',
    'instruction.delai as "'.__("delai").'"',
    'etat8.libelle as "'.__("etat").'"',
    'instruction.accord_tacite as "'.__("accord_tacite").'"',
    'instruction.delai_notification as "'.__("delai_notification").'"',
    'instruction.archive_delai as "'.__("archive_delai").'"',
    'to_char(instruction.archive_date_complet ,\'DD/MM/YYYY\') as "'.__("archive_date_complet").'"',
    'to_char(instruction.archive_date_rejet ,\'DD/MM/YYYY\') as "'.__("archive_date_rejet").'"',
    'to_char(instruction.archive_date_limite ,\'DD/MM/YYYY\') as "'.__("archive_date_limite").'"',
    'to_char(instruction.archive_date_notification_delai ,\'DD/MM/YYYY\') as "'.__("archive_date_notification_delai").'"',
    'instruction.archive_accord_tacite as "'.__("archive_accord_tacite").'"',
    'instruction.archive_etat as "'.__("archive_etat").'"',
    'to_char(instruction.archive_date_decision ,\'DD/MM/YYYY\') as "'.__("archive_date_decision").'"',
    'instruction.archive_avis as "'.__("archive_avis").'"',
    'to_char(instruction.archive_date_validite ,\'DD/MM/YYYY\') as "'.__("archive_date_validite").'"',
    'to_char(instruction.archive_date_achevement ,\'DD/MM/YYYY\') as "'.__("archive_date_achevement").'"',
    'to_char(instruction.archive_date_chantier ,\'DD/MM/YYYY\') as "'.__("archive_date_chantier").'"',
    'to_char(instruction.archive_date_conformite ,\'DD/MM/YYYY\') as "'.__("archive_date_conformite").'"',
    'avis_decision.libelle as "'.__("avis_decision").'"',
    'to_char(instruction.date_finalisation_courrier ,\'DD/MM/YYYY\') as "'.__("date_finalisation_courrier").'"',
    'to_char(instruction.date_envoi_signature ,\'DD/MM/YYYY\') as "'.__("date_envoi_signature").'"',
    'to_char(instruction.date_retour_signature ,\'DD/MM/YYYY\') as "'.__("date_retour_signature").'"',
    'to_char(instruction.date_envoi_rar ,\'DD/MM/YYYY\') as "'.__("date_envoi_rar").'"',
    'to_char(instruction.date_retour_rar ,\'DD/MM/YYYY\') as "'.__("date_retour_rar").'"',
    'to_char(instruction.date_envoi_controle_legalite ,\'DD/MM/YYYY\') as "'.__("date_envoi_controle_legalite").'"',
    'to_char(instruction.date_retour_controle_legalite ,\'DD/MM/YYYY\') as "'.__("date_retour_controle_legalite").'"',
    'signataire_arrete.civilite as "'.__("signataire_arrete").'"',
    'instruction.numero_arrete as "'.__("numero_arrete").'"',
    'to_char(instruction.archive_date_dernier_depot ,\'DD/MM/YYYY\') as "'.__("archive_date_dernier_depot").'"',
    "case instruction.archive_incompletude when 't' then 'Oui' else 'Non' end as \"".__("archive_incompletude")."\"",
    'evenement2.libelle as "'.__("archive_evenement_suivant_tacite").'"',
    'evenement3.libelle as "'.__("archive_evenement_suivant_tacite_incompletude").'"',
    'etat1.libelle as "'.__("archive_etat_pendant_incompletude").'"',
    'to_char(instruction.archive_date_limite_incompletude ,\'DD/MM/YYYY\') as "'.__("archive_date_limite_incompletude").'"',
    'instruction.archive_delai_incompletude as "'.__("archive_delai_incompletude").'"',
    'instruction.code_barres as "'.__("code_barres").'"',
    'instruction.om_fichier_instruction as "'.__("om_fichier_instruction").'"',
    "case instruction.om_final_instruction when 't' then 'Oui' else 'Non' end as \"".__("om_final_instruction")."\"",
    'document_numerise.uid as "'.__("document_numerise").'"',
    'instruction.archive_autorite_competente as "'.__("archive_autorite_competente").'"',
    'autorite_competente.libelle as "'.__("autorite_competente").'"',
    'instruction.duree_validite_parametrage as "'.__("duree_validite_parametrage").'"',
    'instruction.duree_validite as "'.__("duree_validite").'"',
    "case instruction.archive_incomplet_notifie when 't' then 'Oui' else 'Non' end as \"".__("archive_incomplet_notifie")."\"",
    "case instruction.created_by_commune when 't' then 'Oui' else 'Non' end as \"".__("created_by_commune")."\"",
    'to_char(instruction.date_depot ,\'DD/MM/YYYY\') as "'.__("date_depot").'"',
    'to_char(instruction.archive_date_cloture_instruction ,\'DD/MM/YYYY\') as "'.__("archive_date_cloture_instruction").'"',
    'to_char(instruction.archive_date_premiere_visite ,\'DD/MM/YYYY\') as "'.__("archive_date_premiere_visite").'"',
    'to_char(instruction.archive_date_derniere_visite ,\'DD/MM/YYYY\') as "'.__("archive_date_derniere_visite").'"',
    'to_char(instruction.archive_date_contradictoire ,\'DD/MM/YYYY\') as "'.__("archive_date_contradictoire").'"',
    'to_char(instruction.archive_date_retour_contradictoire ,\'DD/MM/YYYY\') as "'.__("archive_date_retour_contradictoire").'"',
    'to_char(instruction.archive_date_ait ,\'DD/MM/YYYY\') as "'.__("archive_date_ait").'"',
    'to_char(instruction.archive_date_transmission_parquet ,\'DD/MM/YYYY\') as "'.__("archive_date_transmission_parquet").'"',
    "case instruction.om_fichier_instruction_dossier_final when 't' then 'Oui' else 'Non' end as \"".__("om_fichier_instruction_dossier_final")."\"",
    "case instruction.flag_edition_integrale when 't' then 'Oui' else 'Non' end as \"".__("flag_edition_integrale")."\"",
    'instruction.archive_dossier_instruction_type as "'.__("archive_dossier_instruction_type").'"',
    'to_char(instruction.archive_date_affichage ,\'DD/MM/YYYY\') as "'.__("archive_date_affichage").'"',
    'to_char(instruction.date_depot_mairie ,\'DD/MM/YYYY\') as "'.__("date_depot_mairie").'"',
    'pec_metier.libelle as "'.__("pec_metier").'"',
    'instruction.archive_pec_metier as "'.__("archive_pec_metier").'"',
    "case instruction.archive_a_qualifier when 't' then 'Oui' else 'Non' end as \"".__("archive_a_qualifier")."\"",
    'instruction.id_parapheur_signature as "'.__("id_parapheur_signature").'"',
    'instruction.statut_signature as "'.__("statut_signature").'"',
    "case instruction.envoye_cl_platau when 't' then 'Oui' else 'Non' end as \"".__("envoye_cl_platau")."\"",
    'instruction.parapheur_lien_page_signature as "'.__("parapheur_lien_page_signature").'"',
    );
//
$champNonAffiche = array(
    'instruction.complement_om_html as "'.__("complement_om_html").'"',
    'instruction.complement2_om_html as "'.__("complement2_om_html").'"',
    'instruction.complement3_om_html as "'.__("complement3_om_html").'"',
    'instruction.complement4_om_html as "'.__("complement4_om_html").'"',
    'instruction.complement5_om_html as "'.__("complement5_om_html").'"',
    'instruction.complement6_om_html as "'.__("complement6_om_html").'"',
    'instruction.complement7_om_html as "'.__("complement7_om_html").'"',
    'instruction.complement8_om_html as "'.__("complement8_om_html").'"',
    'instruction.complement9_om_html as "'.__("complement9_om_html").'"',
    'instruction.complement10_om_html as "'.__("complement10_om_html").'"',
    'instruction.complement11_om_html as "'.__("complement11_om_html").'"',
    'instruction.complement12_om_html as "'.__("complement12_om_html").'"',
    'instruction.complement13_om_html as "'.__("complement13_om_html").'"',
    'instruction.complement14_om_html as "'.__("complement14_om_html").'"',
    'instruction.complement15_om_html as "'.__("complement15_om_html").'"',
    'instruction.om_final_instruction_utilisateur as "'.__("om_final_instruction_utilisateur").'"',
    'instruction.titre_om_htmletat as "'.__("titre_om_htmletat").'"',
    'instruction.corps_om_htmletatex as "'.__("corps_om_htmletatex").'"',
    'instruction.historique_signature as "'.__("historique_signature").'"',
    'instruction.commentaire_signature as "'.__("commentaire_signature").'"',
    'instruction.commentaire as "'.__("commentaire").'"',
    );
//
$champRecherche = array(
    'instruction.instruction as "'.__("instruction").'"',
    'instruction.destinataire as "'.__("destinataire").'"',
    'evenement9.libelle as "'.__("evenement").'"',
    'instruction.lettretype as "'.__("lettretype").'"',
    'dossier.annee as "'.__("dossier").'"',
    'action.libelle as "'.__("action").'"',
    'instruction.delai as "'.__("delai").'"',
    'etat8.libelle as "'.__("etat").'"',
    'instruction.accord_tacite as "'.__("accord_tacite").'"',
    'instruction.delai_notification as "'.__("delai_notification").'"',
    'instruction.archive_delai as "'.__("archive_delai").'"',
    'instruction.archive_accord_tacite as "'.__("archive_accord_tacite").'"',
    'instruction.archive_etat as "'.__("archive_etat").'"',
    'instruction.archive_avis as "'.__("archive_avis").'"',
    'avis_decision.libelle as "'.__("avis_decision").'"',
    'signataire_arrete.civilite as "'.__("signataire_arrete").'"',
    'instruction.numero_arrete as "'.__("numero_arrete").'"',
    'evenement2.libelle as "'.__("archive_evenement_suivant_tacite").'"',
    'evenement3.libelle as "'.__("archive_evenement_suivant_tacite_incompletude").'"',
    'etat1.libelle as "'.__("archive_etat_pendant_incompletude").'"',
    'instruction.archive_delai_incompletude as "'.__("archive_delai_incompletude").'"',
    'instruction.code_barres as "'.__("code_barres").'"',
    'instruction.om_fichier_instruction as "'.__("om_fichier_instruction").'"',
    'document_numerise.uid as "'.__("document_numerise").'"',
    'instruction.archive_autorite_competente as "'.__("archive_autorite_competente").'"',
    'autorite_competente.libelle as "'.__("autorite_competente").'"',
    'instruction.duree_validite_parametrage as "'.__("duree_validite_parametrage").'"',
    'instruction.duree_validite as "'.__("duree_validite").'"',
    'instruction.archive_dossier_instruction_type as "'.__("archive_dossier_instruction_type").'"',
    'pec_metier.libelle as "'.__("pec_metier").'"',
    'instruction.archive_pec_metier as "'.__("archive_pec_metier").'"',
    'instruction.id_parapheur_signature as "'.__("id_parapheur_signature").'"',
    'instruction.statut_signature as "'.__("statut_signature").'"',
    'instruction.parapheur_lien_page_signature as "'.__("parapheur_lien_page_signature").'"',
    );
$tri="ORDER BY instruction.destinataire ASC NULLS LAST";
$edition="instruction";
/**
 * Gestion de la clause WHERE => $selection
 */
// Filtre listing standard
$selection = "";
// Liste des clés étrangères avec leurs éventuelles surcharges
$foreign_keys_extended = array(
    "action" => array("action", ),
    "etat" => array("etat", ),
    "evenement" => array("evenement", ),
    "autorite_competente" => array("autorite_competente", ),
    "avis_decision" => array("avis_decision", ),
    "document_numerise" => array("document_numerise", ),
    "dossier" => array("dossier", "dossier_instruction", "dossier_instruction_mes_encours", "dossier_instruction_tous_encours", "dossier_instruction_mes_clotures", "dossier_instruction_tous_clotures", "dossier_contentieux", "dossier_contentieux_mes_infractions", "dossier_contentieux_toutes_infractions", "dossier_contentieux_mes_recours", "dossier_contentieux_tous_recours", "sous_dossier", ),
    "pec_metier" => array("pec_metier", ),
    "signataire_arrete" => array("signataire_arrete", ),
);
// Filtre listing sous formulaire - action
if (in_array($retourformulaire, $foreign_keys_extended["action"])) {
    $selection = " WHERE (instruction.action = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - etat
if (in_array($retourformulaire, $foreign_keys_extended["etat"])) {
    $selection = " WHERE (instruction.archive_etat_pendant_incompletude = '".$f->db->escapeSimple($idxformulaire)."' OR instruction.etat = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - evenement
if (in_array($retourformulaire, $foreign_keys_extended["evenement"])) {
    $selection = " WHERE (instruction.archive_evenement_suivant_tacite = ".intval($idxformulaire)." OR instruction.archive_evenement_suivant_tacite_incompletude = ".intval($idxformulaire)." OR instruction.evenement = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - autorite_competente
if (in_array($retourformulaire, $foreign_keys_extended["autorite_competente"])) {
    $selection = " WHERE (instruction.autorite_competente = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - avis_decision
if (in_array($retourformulaire, $foreign_keys_extended["avis_decision"])) {
    $selection = " WHERE (instruction.avis_decision = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - document_numerise
if (in_array($retourformulaire, $foreign_keys_extended["document_numerise"])) {
    $selection = " WHERE (instruction.document_numerise = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - dossier
if (in_array($retourformulaire, $foreign_keys_extended["dossier"])) {
    $selection = " WHERE (instruction.dossier = '".$f->db->escapeSimple($idxformulaire)."') ";
}
// Filtre listing sous formulaire - pec_metier
if (in_array($retourformulaire, $foreign_keys_extended["pec_metier"])) {
    $selection = " WHERE (instruction.pec_metier = ".intval($idxformulaire).") ";
}
// Filtre listing sous formulaire - signataire_arrete
if (in_array($retourformulaire, $foreign_keys_extended["signataire_arrete"])) {
    $selection = " WHERE (instruction.signataire_arrete = ".intval($idxformulaire).") ";
}

/**
 * Gestion SOUSFORMULAIRE => $sousformulaire
 */
$sousformulaire = array(
    'demande',
    'instruction_notification',
);

