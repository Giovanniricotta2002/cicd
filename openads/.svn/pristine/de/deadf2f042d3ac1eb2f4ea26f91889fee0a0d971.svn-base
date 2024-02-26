<?php
/**
 * Ce script redirige vers une recherche de dossiers passés en paramètre.
 *
 * @package openfoncier
 * @version SVN : $Id: web_entry.php 5647 2015-12-18 17:01:24Z nhaye $
 */
$separateur = ',';

require_once "../obj/utils.class.php";
$f = new utils("nohtml");
// Récupération de l'objet
$obj = $f->get_submitted_get_value("obj");
// Récupération du champ de recherche
$field = $f->get_submitted_get_value("field");
// Récupération des idx
$values = $f->get_submitted_get_value("value");
// Cas où un seul idx
// XXX si le paramètre field est fourni avec un autre champ que l'id de l'obj
// et la value correspondante au field de recherche la redirection se fera sur
// cette value
if(strpos($values,';') === false AND strpos($values,'*') === false AND $values !== null) {
    header('Location: '.OM_ROUTE_FORM.'&obj='.$obj.'&action=3&idx='.$values);
    die();
}
// Récupération des valeurs à rechercher
if($obj != null and $field != null and $values != null) {
    $search[$field] = str_replace(';', $separateur, $values);
} else {
    $search[$field] = "";
}
// Création d'une variable de session de recherche avancée telle que créée normalement
$advs_id = str_replace(array('.',','), '', microtime(true));
$search["advanced-search-submit"] = "";
$_SESSION["advs_ids"][$advs_id] = serialize($search);
// Redirection vers le tableau des DI
header('Location: '.OM_ROUTE_TAB.'&obj='.$obj.'&advs_id='.$advs_id);

?>