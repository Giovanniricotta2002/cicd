<?php
/**
 *
 *
 * @package openfoncier
 * @version SVN : $Id: evenement.inc.php 4651 2015-04-26 09:15:48Z tbenita $
 */

//
include "../gen/sql/pgsql/evenement.inc.php";

//
$ent = _("parametrage dossiers")." -> "._("workflows")." -> "._("evenement");

// Récupère le paramètre "retourformulaire"
$retourformulaire = (isset($_GET['retourformulaire'])) ? $_GET['retourformulaire'] : "";

//
$sousformulaire = array('bible');

//
$trim_concat_parametres = "trim(concat(
case
  when etat.libelle<>'' 
    then concat('"._("etat")." : ',  etat.libelle, '<br/>')
  else ''
end,
case
  when evenement.delai<>0 
    then concat('"._("delai")." : ',  evenement.delai, '<br/>')
  else ''
end,
case
  when evenement.delai_notification<>0 
    then concat('"._("delai_notification")." : ',  evenement.delai_notification, '<br/>')
  else ''
end,
case
  when avis_decision.libelle<>'' 
    then concat('"._("avis_decision")." : ',  avis_decision.libelle, '<br/>')
  else ''
end,
concat('"._("accord_tacite")." : ',  evenement.accord_tacite, '<br/>'),
''))";

// SELECT 
$champAffiche = array(
    'evenement.evenement as "'._("id").'"',
    'evenement.libelle as "'._("libelle").'"',
    'action.libelle as "'._("action").'"',
    $trim_concat_parametres.' as "'._("parametres").'"',
    'evenement.lettretype as "'._("lettretype").'"',
);

//
$champRecherche = array(
    'evenement.evenement as "'._("id").'"',
    'evenement.libelle as "'._("libelle").'"',
    'action.libelle as "'._("action").'"',
    'etat.libelle as "'._("etat").'"',
    'evenement.delai as "'._("delai").'"',
    'evenement.accord_tacite as "'._("accord_tacite").'"',
    'evenement.delai_notification as "'._("delai_notification").'"',
    'evenement.lettretype as "'._("lettretype").'"',
    'evenement.consultation as "'._("consultation").'"',
    'avis_decision.libelle as "'._("avis_decision").'"',
    'evenement.restriction as "'._("restriction").'"',
    'evenement.type as "'._("type").'"',
    'evenement4.libelle as "'._("evenement_retour_ar").'"',
    'evenement6.libelle as "'._("evenement_suivant_tacite").'"',
    'phase.code as "'._("code_phase").'"',
);

// Bouton copier

if ($retourformulaire == '') {
    $tab_actions['left']['copier'] = array(
        "lien" => "../app/valid_copie.php?obj=".$obj."&amp;objsf=bible,lien_dossier_instruction_type_evenement,transition&amp;idx=",
        "id" => "&amp;premier=".$premier."&amp;tricol=".$tricol."&amp;advs_id=".$advs_id,
        "lib" => "<span class=\"om-icon om-icon-16 om-icon-fix copy-16\" title=\""._("Copier")."\">"._("Copier")."</span>",
        "rights" => array('list' => array($obj, $obj.'_copier'), 'operator' => 'OR'),
    );
}

// Suppression du bouton ajouter
if ($retourformulaire !== '') {
    $tab_actions['corner']['ajouter'] = null;
}

?>
