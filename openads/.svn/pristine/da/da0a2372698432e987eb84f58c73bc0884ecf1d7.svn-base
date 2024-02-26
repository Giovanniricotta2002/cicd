<?php
/**
 * Ce fichier permet de paramétrer le générateur.
 *
 * @package openmairie_exemple
 * @version SVN : $Id: gen.inc.php 5848 2016-02-02 11:04:06Z nmeucci $
 */

/**
 * Surcharge applicative de la classe 'om_dbform'.
 */
$om_dbform_path_override = "../obj/om_dbform.class.php";
$om_dbform_class_override = "om_dbform";

/**
 * Ce tableau permet de lister les tables qui ne doivent pas être prises en
 * compte dans le générateur. Elles n'apparaîtront donc pas dans l'interface
 * et ne seront pas automatiquement générées par le 'genfull'.
 */
$tables_to_avoid = array(
    "geometry_columns",
    "om_version",
    "spatial_ref_sys",
    //
    "erp_categorie",
    "erp_type",
);

/**
 * Ce tableau de configuration permet de donner des informations de surcharges
 * sur certains objets pour qu'elles soient prises en compte par le générateur.
 * $tables_to_overload = array(
 *    "<table>" => array(
 *        // définition de la liste des classes qui surchargent la classe
 *        // <table> pour que le générateur puisse générer ces surcharges 
 *        // et les inclure dans les tests de sous formulaire
 *        "extended_class" => array("<classe_surcharge_1_de_table>", ),
 *        // définition de la liste des champs à afficher dans l'affichage du
 *        // tableau champAffiche dans <table>.inc.php
 *        "displayed_fields_in_tableinc" => array("<champ_1>", ),
 *    ),
 * );
 */
$tables_to_overload = array(

    //
    "taxe_amenagement" => array(
        //
        "displayed_fields_in_tableinc" => array(
            "om_collectivite", "en_ile_de_france", "val_forf_surf_cstr", "val_forf_empl_tente_carav_rml", "val_forf_empl_hll", "val_forf_surf_piscine", "val_forf_nb_eolienne", "val_forf_surf_pann_photo", "val_forf_nb_parking_ext", 
        ),
    ),


    //
    "om_utilisateur" => array(
        //
        "displayed_fields_in_tableinc" => array(
            "nom", "email", "login", "type", "om_type", "om_profil",
        ),
    ),

    // <!> Attention : toute modification dans ce tableau doit obligatoirement être
    // répercutée manuellement dans les tableaux $foreign_keys_di des surcharges
    // suivantes :
    // - dossier_lies_geographiquement.inc.php
    "dossier" => array(
        //
        "extended_class" => array(
            "dossier_instruction",
            "dossier_instruction_mes_encours",
            "dossier_instruction_tous_encours",
            "dossier_instruction_mes_clotures",
            "dossier_instruction_tous_clotures",
            "dossier_contentieux",
            "dossier_contentieux_mes_infractions",
            "dossier_contentieux_toutes_infractions",
            "dossier_contentieux_mes_recours",
            "dossier_contentieux_tous_recours",
            "sous_dossier",
        ),
    ),

    //
    "demande_avis" => array(
        //
        "extended_class" => array(
            "demande_avis_encours",
            "demande_avis_passee",
        ),
    ),

    //
    "document_numerise_type" => array(
        //
        "displayed_fields_in_tableinc" => array(
            "code", "libelle", "document_numerise_type_categorie", "om_validite_debut", "om_validite_fin", 
        ),
    ),

    //
    "om_widget" => array(
        //
        "displayed_fields_in_tableinc" => array(
            "om_widget", "libelle", "lien", "type", "script",
        ),
    ),
    "instruction" => array(
        "extended_class" => array("instruction_modale", ),
    ),
    "lien_sig_contrainte_evenement" => array(
        "tablename_in_page_title" => __("lien_sig_contrainte_evenement"),
        "breadcrumb_in_page_title" => array(__("parametrage"), __("geolocalisation"), __("sig_contrainte"), ),
    ),
);

?>
