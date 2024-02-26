<?php
/**
 * Ce script est utilisé comme variable de remplacement dans les éditions PDF.
 *
 * Il est inclus/requis par les scripts dyn/varetatpdf.inc et 
 * dyn/varlettretypepdf.inc et permet de populer la variable $contraintes
 * avec la liste des contraintes d'un dossier pour une édition.
 *
 * @package openfoncier
 * @version SVN : $Id: dossier_contrainte_edition.php 5737 2016-01-11 10:10:19Z jymadier $
 */

// Fichiers requis
require_once "../obj/utils.class.php";
$this->f->set_submitted_value();
// Par déaut $idx est utilisé comme identifiant de la table dossier
$idx = ($this->f->get_submitted_get_value('idx') !== null) ? $this->f->get_submitted_get_value('idx') : "";

// Variable à afficher à la place de "&contraintes"
$contraintes = "";
// Tableau associatif à 2 dimensions, qui contient l'ensemble des paramètres fournis à 
// &contraintes explosés, une ligne du tableau contient un nom de groupe, sous-groupe
// ou une valeur. 
$conditions = array();

// SELECT
$selectContraintes = "SELECT 
    dossier_contrainte.texte_complete as dossier_contrainte_texte,
    lower(contrainte.groupe) as contrainte_groupe,
    lower(contrainte.sousgroupe) as contrainte_sousgroupe ";

// FROM
$fromContraintes = " FROM ".DB_PREFIXE."contrainte 
    LEFT JOIN ".DB_PREFIXE."dossier_contrainte
        ON  dossier_contrainte.contrainte = contrainte.contrainte ";

// WHERE
$whereContraintes = " WHERE dossier_contrainte.dossier = '$idx' ";

// Si la variable de remplacement est utilisée dans une lettre type
if (isset($var_remplacement_pdf) && $var_remplacement_pdf == "lettretype") {
    //
    $fromContraintes .= " LEFT JOIN ".DB_PREFIXE."dossier
            ON dossier_contrainte.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."instruction
            ON instruction.dossier = dossier.dossier";

    //
    $whereContraintes = " WHERE instruction.instruction = ".$idx;
}

// Si la variable de remplacement est utilisée dans un etat
if (isset($var_remplacement_pdf) && $var_remplacement_pdf == "etat") {
    // Si c'est une consultation
    if (strstr($this->f->get_submitted_get_value('obj'), 'consultation_') !== false) {
        // Ajoute au FROM
        $fromContraintes .= " LEFT JOIN ".DB_PREFIXE."dossier
                ON dossier_contrainte.dossier = dossier.dossier
            LEFT JOIN ".DB_PREFIXE."consultation
                ON consultation.dossier = dossier.dossier";

        // Modifie la condition
        $whereContraintes = " WHERE consultation.consultation = ".$idx;
    }

    // Si c'est un rapport d'instruction
    if ($this->f->get_submitted_get_value('obj') == 'rapport_instruction') {
        // Ajoute au FROM
        $fromContraintes .= " LEFT JOIN ".DB_PREFIXE."dossier
                ON dossier_contrainte.dossier = dossier.dossier
            LEFT JOIN ".DB_PREFIXE."rapport_instruction
                ON rapport_instruction.dossier_instruction = dossier.dossier";

        // Modifie la condition
        $whereContraintes = " WHERE rapport_instruction.rapport_instruction = ".$idx;
    }
}

// S'il y a des paramètres &contraintes dans la requête SQL
if (isset($contraintes_sql) && $contraintes_sql[0] !== "&contraintes") {
    // Explose les paramètres et valeurs récupérées dans un tableau
    $conditions = $this->f->explodeConditionContrainte($contraintes_sql[1]);
    // Récupération des conditions à ajouter au WHERE de la requête SQL
    $whereContraintes .= $this->f->traitement_condition_contrainte(NULL, $conditions);
}

// S'il y a des paramètres &contraintes dans le titre
if (isset($contraintes_titre) && $contraintes_titre[0] !== "&contraintes") {
    // Explose les paramètres et valeurs récupérées dans un tableau
    $conditions = $this->f->explodeConditionContrainte($contraintes_titre[1]);
    // Récupération des conditions à ajouter au WHERE de la requête SQL
    $whereContraintes .= $this->f->traitement_condition_contrainte(NULL, $conditions);
}

// S'il y a des paramètres &contraintes dans le corps
if (isset($contraintes_corps) && $contraintes_corps[0] !== "&contraintes") {
    // Explose les paramètres et valeurs récupérées dans un tableau
    $conditions = $this->f->explodeConditionContrainte($contraintes_corps[1]);
    // Récupération des conditions à ajouter au WHERE de la requête SQL
    $whereContraintes .= $this->f->traitement_condition_contrainte(NULL, $conditions);
}

// Tri différent sur les contraintes si l'affichage est sans arborescence
if (isset($conditions['affichage_sans_arborescence']) && $conditions['affichage_sans_arborescence'] == 't') {
    $triContraintes = " ORDER BY contrainte.no_ordre, contrainte.libelle ";
}
else {
    $triContraintes = " ORDER BY contrainte_groupe DESC, 
    contrainte_sousgroupe, 
    contrainte.no_ordre, 
    contrainte.libelle ";
}

// Requête
$sqlContraintes = $selectContraintes.$fromContraintes.$whereContraintes.$triContraintes;
$resContraintes = $this->f->db->query($sqlContraintes);
$this->f->addToLog("app/dossier_contrainte_edition.php: db->query(\"".$sqlContraintes."\");", 
    VERBOSE_MODE);
$this->f->isDatabaseError($resContraintes);

// S'il y a un résultat
if ($resContraintes->numRows() != 0) {
    
    // Sauvegarde des données pour les comparer
    $lastRowContrainte = array();
    $lastRowContrainte['contrainte_groupe'] = 'empty';
    $lastRowContrainte['contrainte_sousgroupe'] = 'empty';
    $contraintes .= "<table width=\"auto\" >";
    // Tant qu'il y a un résultat
    while ($rowContrainte =& $resContraintes->fetchRow(DB_FETCHMODE_ASSOC)) {
        // Si l'identifiant du groupe de la contrainte présente et celui d'avant sont
        // différents, et si l'option affichage_sans_arborescence est désactivée
        if ($rowContrainte['contrainte_groupe'] != $lastRowContrainte['contrainte_groupe']
            && (!isset($conditions['affichage_sans_arborescence'])
            || $conditions['affichage_sans_arborescence'] != 't')) {
            $contraintes .= 
                "<tr><td style=\"width:10px; text-align:right;\"> - </td>
                <td style=\"width:5px;\"></td><td>".
                mb_strtoupper($rowContrainte['contrainte_groupe'], 'UTF-8')."</td></tr>";
            
        }

        // Si l'identifiant du sousgroupe de la contrainte présente et celui d'avant sont
        // différents, ou s'ils sont identiques mais n'appartiennent pas au même groupe
        // Et si l'option affichage_sans_arborescence est désactivée
        if (($rowContrainte['contrainte_sousgroupe'] != $lastRowContrainte['contrainte_sousgroupe']
            || $rowContrainte['contrainte_groupe'] != $lastRowContrainte['contrainte_groupe'])
            &&  $rowContrainte['contrainte_sousgroupe'] != "" && (!isset($conditions['affichage_sans_arborescence'])
            || $conditions['affichage_sans_arborescence'] != 't')) {
                $contraintes .=
                "<tr><td style=\"width:30px; text-align:right;\"> - </td>
                <td style=\"width:5px;\"></td><td>".
                mb_strtoupper($rowContrainte['contrainte_sousgroupe'], 'UTF-8')."</td></tr>";

        }
        // Si l'option d'affichage sans arborescence n'est pas activée, on ajoute les
        // contraintes avec alinéas avec tirets.
        // Sinon on affiche les contraintes sans tirets et alinéas.
        if (!isset($conditions['affichage_sans_arborescence']) || $conditions['affichage_sans_arborescence'] != 't') {
            $contraintes .= 
            "<tr><td style=\"width:50px; text-align:right;\"> - </td>
            <td style=\"width:5px;\"></td><td>".
            ucfirst($rowContrainte['dossier_contrainte_texte'])."</td></tr>";
        }
        else {
            $contraintes .= 
            "<tr><td>".ucfirst($rowContrainte['dossier_contrainte_texte'])."</td></tr>";
        }
        // sauvegarde des valeurs avant nouvelle itération
        $lastRowContrainte=$rowContrainte;
    }
    $contraintes .= "</table>";
}


?>
