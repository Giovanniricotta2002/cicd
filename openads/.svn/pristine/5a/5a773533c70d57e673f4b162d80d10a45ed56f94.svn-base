<?php
/**
 * Script permettant d'afficher la liste des requêtes mémorisées contenu dans les
 * fichiers sql/pgsql/*.reqmo.inc.php
 *
 * @package openfoncier
 * @version SVN : $Id: reqmo_pilot.php 4651 2015-04-26 09:15:48Z tbenita $
 */

require_once "../obj/utils.class.php";
$f = new utils(null, "reqmo_pilot", _("export / import")." -> "._("statistiques a la demande"));

// Nom de l'objet metier
(($f->get_submitted_get_value('obj') !== null) ? $obj = $f->get_submitted_get_value('obj') : $obj = "");

require_once "../obj/reqmo.class.php";
$reqmo_pilot = new reqmo($f, $obj, "reqmo_pilot");

if($obj == "") {
    $description = _("Les requetes memorisees permettent d'exporter des donnees ".
             "de la base de donnees pour une utilisation externe a ".
             "l'application. Veuillez cliquer sur l'objet a exporter ".
             "pour atteindre un formulaire vous permettant de choisir les ".
             "parametres de l'export.");
    $f->displayDescription($description);

    // Affichage du contenu
    $reqmo_pilot->displayReqmoList("../app/reqmo_pilot.php");
} else {

    /**
     * Fichiers requis
     */
    if (file_exists ("../dyn/var.inc")) {
        include ("../dyn/var.inc");
    }

    /**
     * Paramètres
     */
    set_time_limit(180);
    $DEBUG=0;
    $aff = "requeteur";
    $validation = 0;
    if ($f->get_submitted_get_value('validation') !== null) {
        $validation = $f->get_submitted_get_value('validation');
    }
    $idx = "";
    if ($f->get_submitted_get_value('idx') !== null) {
        $idx = $f->get_submitted_get_value('idx');
    }

    if ($f->get_submitted_post_value('sortie') != null) {
        $sortie= $f->get_submitted_post_value('sortie');
    } else {
        $sortie ='tableau';
    }
    $ent = _("Pilotage")."->".$obj;
    //
    $f->setTitle(_("Requetes memorisees")." -> "._($obj));
    $f->setFlag(null);
    $f->display();

    if (file_exists ("../sql/".OM_DB_PHPTYPE."/".$obj.".reqmo_pilot.inc.php")) {
       include ("../sql/".OM_DB_PHPTYPE."/".$obj.".reqmo_pilot.inc.php");
    }
    elseif (file_exists ("../sql/".OM_DB_PHPTYPE."/".$obj.".reqmo_pilot.inc")) {
       include ("../sql/".OM_DB_PHPTYPE."/".$obj.".reqmo_pilot.inc");
    }
    if ($f->get_submitted_get_value('step') !== null) {
        $step = $f->get_submitted_get_value('step');
    }
    else {
        $step = 0;
    }
    // post  separateur de champ (csv)
    if ($f->get_submitted_post_value('separateur') !== null) {
        $separateur= $f->get_submitted_post_value('separateur');
    } else {
        $separateur =';';
    }
    /**
    *
    */
    if ($step == 0) {
        $reqmo_pilot->displayForm($validation, "../app/reqmo_pilot.php", "../app/reqmo_pilot.php", false);
    } else { // On affiche le csv ou le tableau
        $retour = $reqmo_pilot->prepareRequest($reqmo);
        // Un des champs n'est pas rempli
        if ($retour !== true ){
            $reqmo_pilot->displayForm($validation, "../app/reqmo_pilot.php", "../app/reqmo_pilot.php", $retour);
        }
        else {
            if ($sortie =='tableau') {
                $reqmo_pilot->displayTable("../app/reqmo_pilot.php");
            } elseif ($sortie =='csv') {
                $reqmo_pilot->displayCSV($separateur, "../app/reqmo_pilot.php");
            } else {
                $reqmo_pilot->displayPDF("../app/reqmo_pilot.php");
            }
        }
    }
}



?>
