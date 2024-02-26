<?php
/**
 * Ce script est utilisé comme variable de remplacement dans les éditions PDF.
 * 
 * Il est inclus/requis par les scripts dyn/varetatpdf.inc et 
 * dyn/varlettretypepdf.inc et permet de populer la variable $consultations
 * avec la liste des consultations d'un dossier pour l'édition du rapport 
 * d'instruction.
 *
 * @package openfoncier
 * @version SVN : $Id: rapport_instruction_consultation.php 5456 2015-11-18 07:55:55Z fmichon $
 */

/**
 * Fichiers requis
 */
// XXX Corriger l'appel de ce script.
require_once "../obj/utils.class.php";
if (!isset($f) && !isset($this->f)) {
    $f = new utils();
} elseif (isset($this->f)) {
    $f = $this->f;
}

// Récupère le numéro de rapport d'instruction
$idx = ($f->get_submitted_get_value('idx') !== null) ? $f->get_submitted_get_value('idx') : "";
$consultations = "<table style='width:100%;'>";

// Si l'identifiant n'est pas vide
if ( !is_null($idx) && $idx != "" && is_numeric($idx) ){
    
    // Récupère les consultations dont un avis a été rendu
    $qres = $f->get_all_results_from_db_query(
        sprintf(
            'SELECT
                service.libelle AS sl,
                avis_consultation.libelle AS al,
                consultation.date_retour AS cd
            FROM
                %1$sconsultation
                LEFT JOIN %1$sdossier
                    ON dossier.dossier = consultation.dossier
                LEFT JOIN %1$srapport_instruction
                    ON dossier.dossier = rapport_instruction.dossier_instruction
                LEFT JOIN %1$savis_consultation
                    ON avis_consultation.avis_consultation = consultation.avis_consultation
                LEFT JOIN %1$sservice
                    ON service.service = consultation.service
            WHERE
                consultation.avis_consultation IS NOT NULL
                AND rapport_instruction.rapport_instruction = %2$d
                AND consultation.visible IS TRUE',
            DB_PREFIXE,
            intval($idx)
        ),
        array(
            'origin' => 'app/rapport_instruction_consultation.php'
        )
    );

    // Ajout des données récupérées dans la variable de résultat
    foreach ($qres['result'] as $row) {
        $consultations = $consultations . "<tr>".
            "<td style='width:60%;'>" . $row['sl'] ."</td>" .
            "<td style='width:20%;'>" . $row['al'] . "</td>" .
            "<td style='width:20%;'>" . $f->formatDate($row['cd']) . "</td>".
            "</tr>";
    }

    // Récupère les consultations dont aucun avis n'a été rendu
    $qres = $f->get_all_results_from_db_query(
        sprintf(
            'SELECT
                service.libelle AS sl,
                avis_consultation.libelle AS al,
                consultation.date_retour AS cd
            FROM
                %1$sconsultation
                LEFT JOIN %1$sdossier
                    ON dossier.dossier = consultation.dossier
                LEFT JOIN %1$srapport_instruction
                    ON dossier.dossier = rapport_instruction.dossier_instruction
                LEFT JOIN %1$savis_consultation
                    ON avis_consultation.avis_consultation = consultation.avis_consultation
                LEFT JOIN %1$sservice
                    ON service.service = consultation.service
            WHERE
                consultation.avis_consultation IS NULL
                AND rapport_instruction.rapport_instruction = %2$d
                AND consultation.visible IS TRUE',
            DB_PREFIXE,
            intval($idx)
        ),
        array(
            'origin' => 'app/rapport_instruction_consultation.php'
        )
    );

    // Ajout des données récupérées dans la variable de résultat
    foreach ($qres['result'] as $row) {
        $consultations = $consultations . "<tr>" .
            "<td style='width:60%;'>" . $row['sl'] ."</td>" .
            "<td style='width:20%;'>encours</td>" .
            "<td style='width:20%;'>" . $f->formatDate($row['cd']) . "</td>".
            "</tr>";
    }
}
$consultations .= "</table>";
// Retour des résultats
if ( $consultations != "" ){
        
    $consultations = $consultations;
}
?>