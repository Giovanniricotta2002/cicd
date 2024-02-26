<?php
/**
 * Ce script permet de creer un duplicata d'un enregistrement 
 * et des ses enregistrements liés
 *
 * @package openfoncier
 * @version SVN : $Id: valid_copie.php 4476 2015-04-01 13:40:14Z vpihour $
 *
 * @todo Il faut gerer ce script d'une maniere differente :
 *       il faudrait integrer la duplication d'enregistrement dans
 *       om_dbform.class.php pour le gerer grace a la meme interface que
 *       view_form()
 */

// Fichier requis
require_once "../obj/utils.class.php";

// Instance de la classe utils
$f = new utils(NULL, "copie", _("Copie"));

// Identifiant de l'objet metier a copier
($f->get_submitted_get_value('idx')!=null ? $idx = $f->get_submitted_get_value('idx') : $idx = "");
// Nom de l'objet metier
($f->get_submitted_get_value('obj')!=null ? $obj = $f->get_submitted_get_value('obj') : $obj = "");
// Nom de l'objet metier associe
($f->get_submitted_get_value('objsf')!=null ? $objsf = $f->get_submitted_get_value('objsf') : $objsf = "");
// Paramètres pour le bouton retour
($f->get_submitted_get_value('premier')!=null ? $premier = $f->get_submitted_get_value('premier') : $premier = 0);
($f->get_submitted_get_value('tricol')!=null ? $tricol = $f->get_submitted_get_value('tricol') : $tricol = "");
($f->get_submitted_get_value('advs_id')!=null ? $advs_id = $f->get_submitted_get_value('advs_id') : $advs_id = "");

// Description de la page
$description = _("Cette page permet de dupliquer un enregistrement et ses enregistrements associes.");
$f->displayDescription($description);

// Bouton retour
$bouton_retour = "<a class=\"retour\" href=".
    "\"".OM_ROUTE_TAB."&obj=%s&premier=%s&tricol=%s".
    "&advs_id=%s\">".
        _("Retour").
    "</a>";

// Si des données sont envoyées par le formulaire
if ($f->get_submitted_post_value('idx')!=null 
    && $f->get_submitted_post_value('obj')) {

    // Identifiant de l'objet metier a copier
    ($f->get_submitted_post_value('idx')!=null ? $idx = $f->get_submitted_post_value('idx') : $idx = "");
    // Nom de l'objet metier
    ($f->get_submitted_post_value('obj')!=null ? $obj = $f->get_submitted_post_value('obj') : $obj = "");
    // Nom des objets metier associés
    ($f->get_submitted_post_value('objsf')!=null ? $objsf = $f->get_submitted_post_value('objsf') : $objsf = "");
    // Liste des objets associés
    $listObjsf = explode(",", $objsf);
    foreach ($listObjsf as $key => $value) {
        // Si l'objet n'est pas checké
        if (!array_key_exists($value, $f->get_submitted_post_value())) {
            // Supprime l'objet de la liste
            unset($listObjsf[$key]);
        }
    }

    // Liste des objets associés choisis
    $objsf_checked = implode(",", $listObjsf);

    // Utilisation de la fonction copie
    $return = $f->copier($idx, $obj, $objsf_checked);

    // Message affiché à l'utilisateur
    $message = $return['message'];
    // Type du message
    $message_type = $return['message_type'];

    // Affiche le message
    $f->displayMessage($message_type, $message);

    // Affiche le bouton de retour
    printf("<div class=\"formControls\">");
        printf($bouton_retour, $obj, $premier, $tricol, $advs_id);
    printf("</div>");

// Sinon
} else {

    // Champs du formulaire = objet métier associés
    if ($objsf != '') {
        $champs = explode(",", $objsf);
    }
    $champs[] = "idx";
    $champs[] = "obj";
    $champs[] = "objsf";

    // Création d'un nouvel objet de type formulaire
    $form = $f->get_inst__om_formulaire(array(
        "validation" => 0,
        "maj" => 0,
        "champs" => $champs,
    ));

    // Type des champs
    foreach ($champs as $key) {
        $form->setType($key, 'checkbox');
        $form->setTaille($key, 1);
        $form->setMax($key, 1);
    }
    $form->setType("idx", 'hidden');
    $form->setType("obj", 'hidden');
    $form->setType("objsf", 'hidden');

    // Libellés des champs
    foreach ($champs as $key) {
        $form->setLib($key, _($key));
    }

    // Valeur des champs
    foreach ($champs as $key) {
        $form->setVal($key, 'f');
    }
    $form->setVal("idx", $idx);
    $form->setVal("obj", $obj);
    $form->setVal("objsf", $objsf);

    // Affichage des champs
    $i = 0;
    $lastKey = "";
    foreach ($champs as $key) {
        if ($i == 0) {
            $form->setFieldset($key, 'D', _("Liste des objets associes"), "");
        }
        $form->setBloc($key, 'DF', "", "");
        $lastKey = $key;
        $i++;
    }
    $form->setFieldset($lastKey, 'F');

    // Ouverture du formulaire
    printf("<form method=\"POST\" action=\"valid_copie.php?obj=".$obj."&amp;objsf=bible,lien_dossier_instruction_type_evenement,transition&amp;idx=".$idx."&amp;premier=".$premier."&amp;tricol=".$tricol."&amp;advs_id=".$advs_id."\" name=\"f2\">");

    // Champs du formulaire
    $form->entete();
    $form->afficher($champs, 0, false, false);
    if ($objsf == '') {
        printf(_("Aucun objet associe existant."));
    }
    $form->enpied();

    // Bouton "Copier" et "Retour"
    printf("<div class=\"formControls\">");
        printf('<input id="button-%1$s" type="submit" class="om-button ui-button ui-widget ui-state-default ui-corner-all" value="%1$s" role="button" aria-disabled="false">', _("Copier"));
        printf($bouton_retour, $obj, $premier, $tricol, $advs_id);
    printf("</div>");

    // Fermeture du formulaire
    printf("</form>");
}

?>
