<?php
/**
 *
 *
 * @package openads
 * @version SVN : $Id$
 */

/**
 * Récupération de utils dans la variable $f
 */
//
if (isset($this->f) && $this->f != null) {
    $f = $this->f;
} elseif (isset($GLOBALS["f"])) {
    $f = $GLOBALS["f"];
} else {
    die("Impossible");
}

/**
 * Variables de remplacement 'statiques'
 * - &aujourdhui
 * - &jourSemaine
 * => $titre
 */
// AUJOURDHUI
$titre = str_ireplace("&aujourdhui", date('d/m/Y'), $titre);

//Date au format jour_de_la_semaine jour_du_mois mois_de_l'année
//Ex. Lundi 12 Mars
$jourSemaine = array(_('Dimanche'),_('Lundi'),_('Mardi'),_('Mercredi'),_('Jeudi'),
    _('Vendredi'),_('Samedi'));
$moisAnnee = array(_('Janvier'),_('Fevrier'),_('Mars'),_('Avril'),_('Mai'),
    _('Juin'),_('Juillet'),_('Aout'),_('Septembre'),_('Octobre'),_('Novembre')
    ,_('Decembre'));
$titre = str_ireplace("&jourSemaine",$jourSemaine[date('w')]." ".date('d')." ".$moisAnnee[date('n')-1]." ".date('Y'),$titre);

          

/**
 * Paramètres de la collectivité
 * => $titre
 * => $sql
 */
//
foreach (array_keys($collectivite) as $elem) {
    // Spécificité SIG, un paramètre peut être de type tableau
    if (is_array($collectivite[$elem])) {
        continue;
    }
    //
    $temp = "&".$elem;
    $titre = str_ireplace($temp, $collectivite[$elem], $titre);
    $sql = str_replace($temp, $collectivite[$elem], $sql);
}

/**
 * REGISTRE
 */
if($_GET['obj']=='registre_dossiers_affichage_reglementaire'){
    $sql = str_replace("&collectivite", $collectivite['om_collectivite_idx'], $sql);
}

/**
 * BORDEREAU
 */
if (isset($_GET["obj"]) 
    && $f->starts_with($_GET["obj"], 'bordereau') === true) {

    //// &collectivite

    // Si la collectivité est fournie en paramètre GET et que l'utilisateur est multi, on
    // remplacera la variable &collectivite dans le sous-état par le paramètre GET

    if (isset($_GET['collectivite']) && ($_SESSION['niveau'] == '2')) {
        $collectivite_plop = $_GET["collectivite"];
    } else {
        $collectivite_plop = $collectivite['om_collectivite_idx'];
    }

    $sql = str_replace("&collectivite", $collectivite_plop, $sql);


    //// &date_bordereau_debut
    //// &date_bordereau_fin

    (isset($_GET['date_bordereau_debut']) ? $date_bordereau_debut = $_GET["date_bordereau_debut"] : $date_bordereau_debut = "");
    (isset($_GET['date_bordereau_fin']) ? $date_bordereau_fin = $_GET["date_bordereau_fin"] : $date_bordereau_fin = "");


    // formatage des dates de début et de fin de bordereau en EN/US
    $date_bordereau_debut_en = substr($date_bordereau_debut,6,4)."-".substr($date_bordereau_debut,3,2)."-".substr($date_bordereau_debut,0,2);
    $date_bordereau_fin_en = substr($date_bordereau_fin,6,4)."-".substr($date_bordereau_fin,3,2)."-".substr($date_bordereau_fin,0,2);
    // gestion de l'absence de dates (contexte prévisualisation de l'état)
    if ($date_bordereau_debut_en == '--' || $date_bordereau_fin_en == '--') {
        // Dates volontairement irréalistes pour n'obtenir aucun résultat
        $date_bordereau_debut_en = '1212-12-12';
        $date_bordereau_fin_en = '1212-12-12';
    }

    $titre=str_ireplace("&date_bordereau_debut",$date_bordereau_debut,$titre);
    $titre=str_ireplace("&date_bordereau_fin",$date_bordereau_fin,$titre);

    // remplacement des dates dans la requête
    $sql = str_replace("&date_bordereau_debut", $date_bordereau_debut_en, $sql);
    $sql = str_replace("&date_bordereau_fin", $date_bordereau_fin_en, $sql);

}

?>
