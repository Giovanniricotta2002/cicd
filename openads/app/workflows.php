<?php
/**
 * Ce script permet d'afficher une vue gloable des workflows en fonction d'un
 * type de dossier d'instrcution.
 *
 * @package openfoncier
 * @version SVN : $Id: workflows.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
require_once "../obj/utils.class.php";
$f = new utils(NULL, "workflows",
               _("parametrage dossiers")." -> "._("workflows"));

               
/**
 * 
 */
// Ouverture de la balise - Conteneur d'onglets
echo "<div id=\"formulaire\">\n\n";
// Affichage de la liste des onglets
$f->layout->display_tab_lien_onglet_un(_("par type de dossier d'instruction"));
// Ouverture de la balise - Onglet 1
echo "\t<div id=\"tabs-1\">\n\n";
/**
 * Affichage du formulaire de sélection du type de dossier d'instruction
 */
// Ouverture du formulaire
echo "\t<form";
echo " method=\"post\"";
echo " id=\"workflows_form\"";
echo " action=\"../app/workflows.php\"";
echo ">\n";
// Paramétrage des champs du formulaire
$champs = array("di_type");
// Création d'un nouvel objet de type formulaire
$form = $f->get_inst__om_formulaire(array(
    "validation" => 0,
    "maj" => 0,
    "champs" => $champs,
));
// Paramétrage des champs du formulaire
$form->setLib("di_type", _("Type de dossier d'instruction"));
$form->setType("di_type", "select");
$form->setTaille("di_type", 25);
$form->setOnChange("di_type", "submit()");
$form->setMax("di_type", 25);
$form->setVal("di_type", ($f->get_submitted_post_value("di_type") != null) ? $f->get_submitted_post_value("di_type") : "");
//
$qres = $f->get_all_results_from_db_query(
    sprintf(
        'SELECT
            dossier_instruction_type.dossier_instruction_type,
            CONCAT_WS(
               \' - \',
                dossier_autorisation_type_detaille.code,
                dossier_instruction_type.code,
                dossier_instruction_type.libelle
            ) AS lib
        FROM 
            %1$sdossier_instruction_type    
            LEFT JOIN %1$sdossier_autorisation_type_detaille
                ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        ORDER BY lib',
        DB_PREFIXE
    ),
    array(
        'origin' => "app/workflows.php",
        'mode' => DB_FETCHMODE_ORDERED
    )
);

$contenu = array(array(""), array(_("choisir le type de dossier d'instruction")));
foreach ($qres['result'] as $row) {
    $contenu[0][] = $row[0];
    $contenu[1][] = $row[1];
}
$form->setSelect("di_type", $contenu);
// Affichage du formulaire
$form->entete();
$form->afficher($champs, 0, false, false);
$form->enpied();
//// Affichage du bouton
//echo "\t<div class=\"formControls\">\n";
//$f->layout->display_form_button(array("value" => _("Valider")));
//echo "\t</div>\n";
// Fermeture du fomulaire
echo "\t</form>\n";
/**
 *
 */
if ($f->get_submitted_post_value("di_type") == null || $f->get_submitted_post_value("di_type") == "") {
    // Fermeture de la balise - Onglet 1
    echo "\n\t</div>\n";
    // Fermeture de la balise - Conteneur d'onglets
    echo "</div>\n";
    //
    die();
}

/**
 *
 */
$qres = $f->get_one_result_from_db_query(
    sprintf(
        'SELECT
            concat(dossier_autorisation_type_detaille.code, \' - \', dossier_instruction_type.code, \' - \', dossier_instruction_type.libelle) as lib
        FROM
            %1$sdossier_instruction_type
            LEFT JOIN %1$sdossier_autorisation_type_detaille
                ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        WHERE
            dossier_instruction_type.dossier_instruction_type=%2$d',
        DB_PREFIXE,
        intval($f->get_submitted_post_value("di_type"))
    ),
    array(
        "origin" => "app/workflows.php",
    )
);
echo "<section class='workflow-cards'>";
echo "<h1>";
echo $qres["result"];
echo "</h1>";
//
$qres = $f->get_all_results_from_db_query(
    sprintf(
        'SELECT
            etat1.etat AS etat,
            etat1.statut AS etat_statut,
            etat1.libelle AS etat_libelle,
            evenement.evenement AS evenement,
            evenement.libelle AS evenement_libelle,
            evenement.retour AS evenement_retour,
            evenement.action AS evenement_action,
            evenement.etat AS evenement_action_parametrage_etat,
            evenement.restriction AS evenement_restriction,
            evenement.delai AS delai,
            evenement.accord_tacite AS accord_tacite,
            evenement.delai_notification AS delai_notification,
            evt_ret_rar.evenement AS evenement_evenement_retour_ar,
            evt_ret_rar.libelle AS evenement_evenement_retour_ar_lib,
            evt_suiv_tacite.evenement AS evenement_evenement_suivant_tacite,
            evt_suiv_tacite.libelle AS evenement_evenement_suivant_tacite_lib,
            evt_ret_sign.evenement AS evenement_evenement_retour_signature,
            evt_ret_sign.libelle AS evenement_evenement_retour_signature_lib,
            etat2.statut AS evenement_action_parametrage_etat_statut,
            action.regle_etat AS action_regle_etat,
            action.regle_delai AS action_regle_delai,
            action.regle_accord_tacite AS action_regle_accord_tacite, 
            action.regle_avis AS action_regle_avis,
            action.regle_date_limite AS action_regle_date_limite,
            action.regle_date_notification_delai AS action_regle_date_notification_delai,
            action.regle_date_complet AS action_regle_date_complet,
            action.regle_date_validite AS action_regle_date_validite,
            action.regle_date_decision AS action_regle_date_decision,
            action.regle_date_chantier AS action_regle_date_chantier,
            action.regle_date_achevement AS action_regle_date_achevement,
            action.regle_date_conformite AS action_regle_date_conformite,
            action.regle_date_rejet AS action_regle_date_rejet,
            action.regle_date_dernier_depot AS action_regle_date_dernier_depot,
            action.regle_date_limite_incompletude AS action_regle_date_limite_incompletude,
            action.regle_delai_incompletude AS action_regle_delai_incompletude
        FROM
            %1$stransition
            LEFT JOIN %1$setat AS etat1
                ON etat1.etat = transition.etat 
            LEFT JOIN %1$sevenement
                ON transition.evenement = evenement.evenement
            LEFT JOIN %1$slien_dossier_instruction_type_evenement
                ON lien_dossier_instruction_type_evenement.evenement = transition.evenement
            LEFT JOIN %1$saction
                ON evenement.action = action.action
            LEFT JOIN %1$setat AS etat2
                ON etat2.etat = evenement.etat
            LEFT JOIN %1$sevenement AS evt_ret_rar
                ON evenement.evenement_retour_ar = evt_ret_rar.evenement
            LEFT JOIN %1$sevenement AS evt_suiv_tacite
                ON evenement.evenement_suivant_tacite = evt_suiv_tacite.evenement
            LEFT JOIN %1$sevenement AS evt_ret_sign
                ON evenement.evenement_retour_signature = evt_ret_sign.evenement
        WHERE
            lien_dossier_instruction_type_evenement.dossier_instruction_type = %2$d
        ORDER BY
            etat1.statut DESC,
            etat1.etat,
            evenement_action,
            etat2.statut DESC,
            evenement.libelle',
        DB_PREFIXE,
        intval($f->get_submitted_post_value("di_type"))
    ),
    array(
        'origin' => "app/workflows.php"
    )
);
//
$transitions = array();
foreach ($qres['result'] as $row) {
    $transitions[] = $row;
}
//
$etat = "";
$champsRegle = array("action_regle_delai"=>_("delai"), 
    "action_regle_accord_tacite"=>_("accord_tacite"),
    "action_regle_avis"=>_("avis"),
    "action_regle_date_limite"=>_("date_limite"),
    "action_regle_date_notification_delai"=>_("date_notification_delai"),
    "action_regle_date_complet"=>_("date_complet"),
    "action_regle_date_validite"=>_("date_validite"),
    "action_regle_date_decision"=>_("date_decision"),
    "action_regle_date_chantier"=>_("date_chantier"),
    "action_regle_date_achevement"=>_("date_achevement"),
    "action_regle_date_conformite"=>_("date_conformite"),
    "action_regle_date_rejet"=>_("date_rejet"),
    "action_regle_date_dernier_depot"=>_("date_dernier_depot"),
    "action_regle_date_limite_incompletude"=>_("date_limite_incompletude"),
    "action_regle_delai_incompletude"=>_("delai_incompletude"));
    //compter le nombre d'actions
$i = 0;
foreach($transitions as $key => $transition) {
    //
    if ($transition["etat"] != $etat) {
        if ($etat != "") {
            echo "</ul>";
            echo "</article>";
        }
        //
        echo "<article class='workflow-card'>";
        echo "<header class=\"wf_etat_statut\">";
        echo "<h2 class=\"label";
        if ($transition["etat_statut"] == "encours") {
            echo " label-info";
        }
        echo "\">";
        echo $transition["etat"]." - ".$transition["etat_libelle"];
        echo "</h2>";
        echo "<a name=\"".$transition["etat"]."\" href=\"".OM_ROUTE_FORM."&obj=etat&amp;idx=".$transition["etat"]."&amp;action=3\">";
        echo "<span class=\"workflow-card-edit-label\"><i class=\"ri-edit-2-line\"></i> Modifier </span>";
        echo "</a>";
        echo "</header>";
        //
        echo "<ul>";
        //
        $etat = $transition["etat"];
        
        echo "<h3>";
        echo _("Evenements suivants possibles : ");
        echo "</h3>";
    }
    //
    
    echo "<li>";
    //Lien pour afficher les informations de l'événement
    echo "<span class=\"wf_evenement\">";
    echo "<a class=\"workflow-card-event\" href=\"".OM_ROUTE_FORM."&obj=evenement&amp;idx=".$transition["evenement"]."&amp;action=3\" title=\"Consulter l'événement\">";
    echo mb_strtoupper($transition["evenement_libelle"], 'UTF-8');
    // Si c'est un événement "retour"
    if ($transition["evenement_retour"] == 't') {
        //
        echo " <span class=\"backgroundEvenementRetour\">"._("[RETOUR]")."</span>";
    }
    echo "</a>";
    echo "</span> ";

    if ($transition["evenement_action_parametrage_etat"] != NULL
        && $transition["action_regle_etat"] != NULL) {
        echo "<br/> &rArr; ";
        echo _("etat du dossier : ");
        
        //Pas besoin de mettre d'ancre si l'état est l'état final
        if ($transition["evenement_action_parametrage_etat"]!="cloturer"){ 
            echo "<a href=\"#".$transition["evenement_action_parametrage_etat"]."\">";
        }
        echo "<span class=\"label";
        if ($transition["evenement_action_parametrage_etat_statut"] == "encours") {
            echo " label-info";
        }
        echo "\">";
        echo $transition["evenement_action_parametrage_etat"];
        echo "</span>";
        
        if ($transition["evenement_action_parametrage_etat"]!="cloturer"){
            echo "</a>";
        }
        
        echo "<br/>";
        echo "<span class=\"wf_evenement_action\" id=\"".$i."\"> &rArr; ";
        echo _("action sur le dossier : ");
        echo "<a href=\"".OM_ROUTE_FORM."&obj=action&amp;idx=".$transition["evenement_action"]."&amp;action=3\">";
        echo $transition["evenement_action"];
        echo "</a>";
        echo "</span>";
        echo "<br/>";
        
        //Liste des règles de calcul de l'action
        $action = false;
        foreach ($champsRegle as $key => $value) {
            
            
            
            //Si le champ n'est pas null
            if ( !empty($transition[$key]) && $transition[$key] != "null" ){
                
                //On ouvre la balise de la pop-up
                if ( $action === false){
                    echo "<div class=\"regle_action\" title=\""._("Regle(s) de calcul")."\" id=\"regle_action".$i."\">";
                    $action = true;
                }
                
                $temp = explode("+", $transition[$key]);
                $res = "";
                foreach ($temp as $val){
                    $res .= (( isset($transition[$val]) && 
                        !empty($transition[$val]) && 
                        $transition[$val] != "null" )?
                            $transition[$val].(is_numeric($transition[$val])?" mois":""):
                            $val.(is_numeric($val)?" mois":""))
                        ." + ";
                }
                $res = substr($res, 0, -3);
                
                echo "&nbsp;&nbsp;&rsaquo; ";
                printf (_('%s = %s'), ucfirst($value), $res);
                echo "</br>";
            }
        }
        //On ferme la balise de la pop-up
        if ( $action === true ){
            echo "</div>";
        }
        //Incrément du numéro d'identifiant du combo action/règles
        $i++;
        
        //Affichage des champs d'événements suivant s'ils sont non nuls
        if ( !empty($transition["evenement_evenement_retour_ar"]) && $transition["evenement_evenement_retour_ar"] != "null"){
            echo " &rArr; ";
            echo _("evenement_retour_ar")." : ";
            echo "<a href=\"".OM_ROUTE_FORM."&obj=evenement&amp;idx=".$transition["evenement_evenement_retour_ar"]."&amp;action=3\">";
            echo mb_strtoupper($transition["evenement_evenement_retour_ar_lib"], 'UTF-8');
            echo "</a>";
            echo "<br/>";
        }
        
        if ( !empty($transition["evenement_evenement_suivant_tacite"]) && $transition["evenement_evenement_suivant_tacite"] != "null"){
            echo " &rArr; ";
            echo _("evenement_suivant_tacite")." : ";
            echo "<a href=\"".OM_ROUTE_FORM."&obj=evenement&amp;idx=".$transition["evenement_evenement_suivant_tacite"]."&amp;action=3\">";
            echo mb_strtoupper($transition["evenement_evenement_suivant_tacite_lib"], 'UTF-8');
            echo "</a>";
            echo "<br/>";
        }
        
        if ( !empty($transition["evenement_evenement_retour_signature"]) && $transition["evenement_evenement_retour_signature"] != "null"){
            echo " &rArr; ";
            echo _("evenement_retour_signature")." : ";
            echo "<a href=\"".OM_ROUTE_FORM."&obj=evenement&amp;idx=".$transition["evenement_evenement_retour_signature"]."&amp;action=3\">";
            echo mb_strtoupper($transition["evenement_evenement_retour_signature_lib"], 'UTF-8');
            echo "</a>";
            echo "<br/>";
        }
        
        //Si une restriction existe, on l'affiche
        if ( !empty($transition["evenement_restriction"]) && $transition["evenement_restriction"] != "null"){
            echo " &rArr; ";
            echo _("restriction")." : ".$transition["evenement_restriction"];
            echo "<br/>";
        }
    }
    echo "</li>";
}


// Fermeture de la balise - section.workflow-cards
echo "\n\t\n\t</section>\n";

// Fermeture de la balise - Onglet 1
echo "\n\t</div>\n";
// Fermeture de la balise - Conteneur d'onglets
echo "</div>\n";

?>
