<?php
/**
 * Ce fichier permet d'afficher le portail d'accès citoyen aux utilisateurs
 * anonymes.
 *
 * @package openfoncier
 * @version SVN : $Id$
 */

require_once "web.class.php";
// Utilisation du flag "anonym" pour permettre à l'utilisateur d'être authentifié
$f = new openads_web("anonym");
// La surcharge d'openads_web faite dans web.class.php gère l'affichage du header et
// du footer directement dans le constructeur et le destructeur de l'objet. Par défaut si le flag est
// anonym le header et le footer ne sont pas affiché.
// Pour permettre d'être authentifié mais aussi d'avoir le contenu de la page le
// flag est passé à null et on fait appel à display() qui va réalisé l'affichage voulu.
$f->setFlag(null);
$f->display();
$inst = $f->get_inst__om_dbform(array(
    "obj" => "dossier_autorisation",
    "idx" => 0,
));
$inst->view_consulter_anonym($f->get_content_only_param());
