<?php
//$Id: lot.inc.php 4418 2015-02-24 17:30:28Z tbenita $ 
//gen openMairie le 08/11/2012 14:59

include('../gen/sql/pgsql/lot.inc.php');

//Surcharge de $table pour afficher les noms des demandeurs liés
$table = DB_PREFIXE."lot
    LEFT JOIN ".DB_PREFIXE."dossier 
        ON lot.dossier=dossier.dossier 
    LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
        ON lot.dossier_autorisation=dossier_autorisation.dossier_autorisation
    LEFT JOIN (
        SELECT * 
        FROM ".DB_PREFIXE."lien_lot_demandeur
        INNER JOIN ".DB_PREFIXE."demandeur
            ON demandeur.demandeur = lien_lot_demandeur.demandeur
        WHERE lien_lot_demandeur.petitionnaire_principal IS TRUE
        AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
    ) as demandeur
         ON lot.lot = demandeur.lot";
        
/* Test SQL pour récupérer les bons champs selon la qualité du demandeur : 
 * particulier ou personne morale*/
$case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
END";
        
//Surcharge de $champAffiche pour afficher les noms des demandeurs liés
$champAffiche = array(
    'lot.lot as "'._("lot").'"',
    $case_demandeur.' "'._("demandeur_nom").'"',
    'lot.libelle as "'._("libelle").'"',
    );

/**
 * Gestion particulière de l'affichage du listing dans le contexte d'un dossier
 * d'instruction
 */
include "../sql/pgsql/dossier_instruction_droit_specifique_par_division.inc.php";
// Gestion des groupes et confidentialité
include('../sql/pgsql/filter_group.inc.php');