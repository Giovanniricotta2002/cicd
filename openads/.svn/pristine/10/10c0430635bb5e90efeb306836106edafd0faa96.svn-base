<?php
/**
 * Ce fichier permet de definir des variables specifiques a passer dans la
 * methode tableau des objets metier
 *
 * @package openmairie_exemple
 * @version SVN : $Id: tab.inc.php 5208 2015-09-23 21:32:51Z fmichon $
 */

/**
 * Exemple : un ecran specifique me permet de passer la date de naissance de
 * l'utilisateur au tableau uniquement lorsque l'objet est "agenda".
 *
 * if ($obj == "agenda") {
 *     $datenaissance = "";
 *     if (isset($_GET['datenaissance'])) {
 *         $datenaissance = $_GET['datenaissance'];
 *     }
 *     $extra_parameters["datenaissance"] = $datenaissance;
 * }
 *
 * Ainsi dans la methode tableau de l'objet en question la valeur de la date
 * de naissance sera accessible
 */

// WIDGET DASHBOARD - widget_dossiers_limites.
// Permet de passer les paramètres du widget dossiers limites
if ($obj == "dossiers_limites") {
    //
    $nombre_de_jours = "";
    if (isset($_GET['nombre_de_jours'])) {
        $nombre_de_jours = $_GET['nombre_de_jours'];
    }
    $extra_parameters["nombre_de_jours"] = $nombre_de_jours;
    //
    $codes_datd = "";
    if (isset($_GET['codes_datd'])) {
        $codes_datd = $_GET['codes_datd'];
    }
    $extra_parameters["codes_datd"] = $codes_datd;
    //
    $filtre = "";
    if (isset($_GET['filtre'])) {
        $filtre = $_GET['filtre'];
    }
    $extra_parameters["filtre"] = $filtre;
}

// WIDGET DASHBOARD - widget_derniers_dossiers.
// Permet de passer les paramètres du widget dossiers limites
if ($obj == "derniers_dossiers_deposes") {
    //
    $nombre_de_jours = "";
    if (isset($_GET['nombre_de_jours'])) {
        $nombre_de_jours = $_GET['nombre_de_jours'];
    }
    $extra_parameters["nombre_de_jours"] = $nombre_de_jours;
    //
    $codes_datd = "";
    if (isset($_GET['codes_datd'])) {
        $codes_datd = $_GET['codes_datd'];
    }
    $extra_parameters["codes_datd"] = $codes_datd;
    //
    $filtre = "";
    if (isset($_GET['filtre'])) {
        $filtre = $_GET['filtre'];
    }
    $extra_parameters["filtre"] = $filtre;
    //
    $restreindre_aux_tacites = "";
    if (isset($_GET['restreindre_aux_tacites'])) {
        $restreindre_aux_tacites = $_GET['restreindre_aux_tacites'];
    }
    $extra_parameters["restreindre_aux_tacites"] = $restreindre_aux_tacites;
}

// Permet de filtrer les dossiers dont on peut modifier la décision
if ($obj == "dossier_instruction") {
    $filtre_decision = false;
    if (isset($_GET['decision']) && $_GET['decision'] == 'true') {
        $filtre_decision = true;
    }
    $extra_parameters["filtre_decision"] = $filtre_decision;
}
// Permet de filtrer les dossiers dont on peut modifier la décision
if ($obj == "dossier_non_transmis") {
    $date_depot_debut = null;
    if (isset($_GET['date_depot_debut'])) {
        $date_depot_debut = $_GET['date_depot_debut'];
    }
    $extra_parameters["date_depot_debut"] = $date_depot_debut;
}

if ($obj == "suivi_instruction_parametrable") {
    //
    $statut_signature = "";
    if (isset($_GET['statut_signature'])) {
        $statut_signature = $_GET['statut_signature'];
    }
    $extra_parameters["statut_signature"] = $statut_signature;
    //
    $message_help = "";
    if (isset($_GET['message_help'])) {
        $message_help = $_GET['message_help'];
    }
    $extra_parameters["message_help"] = $message_help;
    //
    $tri = "";
    if (isset($_GET['tri'])) {
        $tri = $_GET['tri'];
    }
    $extra_parameters["tri"] = $tri;
    //
    $filtre = "";
    if (isset($_GET['filtre'])) {
        $filtre = $_GET['filtre'];
    }
    $extra_parameters["filtre"] = $filtre;

    $widget_recherche_id = "";
    if (isset($_GET['widget_recherche_id'])) {
        $widget_recherche_id = $_GET['widget_recherche_id'];
    }
    $extra_parameters["widget_recherche_id"] = $widget_recherche_id;
}


if ($obj == "suivi_tache") {
    $widget_recherche_id = "";
    if (isset($_GET['widget_recherche_id'])) {
        $widget_recherche_id = $_GET['widget_recherche_id'];
    }
    $extra_parameters["widget_recherche_id"] = $widget_recherche_id;
}


// Pour tous les listings des objets suivants, on passe les paramètres des widgets
// correspondants
if ($obj == "dossier_contentieux_contradictoires"
    || $obj == "dossier_contentieux_ait"
    || $obj == "dossier_contentieux_alerte_parquet"
    || $obj == "dossier_contentieux_alerte_visite"
    || $obj == "dossier_contentieux_audience"
    || $obj == "dossier_contentieux_clotures"
    || $obj == "dossier_contentieux_inaffectes"
    || $obj == "dossiers_evenement_incomplet_majoration"
    || $obj == "dossiers_pre_instruction"
    || $obj == "dossier_non_transmis") {
    //
    $filtre = "";
    if (isset($_GET['filtre'])) {
        $filtre = $_GET['filtre'];
    }
    $extra_parameters["filtre"] = $filtre;
}

// WIDGET DASHBOARD - widget_messages_retours.
// Permet de passer les paramètres du widget des messages retours
if ($obj === "messages_retours"
    || $obj === 'messages_mes_retours'
    || $obj === 'messages_tous_retours'
    || $obj === 'messages_contentieux_mes_retours'
    || $obj === 'messages_contentieux_retours_ma_division'
    || $obj === 'messages_contentieux_tous_retours') {
    //
    $dossier_cloture = "";
    if (isset($_GET['dossier_cloture'])) {
        $dossier_cloture = $_GET['dossier_cloture'];
    }
    $extra_parameters["dossier_cloture"] = $dossier_cloture;
}

// Recherche avancée : complétion uniquement à droite
$options[] = array('type' => 'wildcard', 'left' => '', 'right' => '%');
?>
