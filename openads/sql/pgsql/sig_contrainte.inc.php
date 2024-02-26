<?php
//$Id$ 
//gen openMairie le 11/06/2021 16:14

include "../gen/sql/pgsql/sig_contrainte.inc.php";
$ent = _("parametrage")." -> "._("géolocalisation")." -> "._("sig_contrainte");
$champAffiche = array(
    'sig_contrainte as "'._("sig_contrainte").'"',
    'sig_groupe as "'._("sig_groupe").'"',
    'sig_sousgroupe as "'._("sig_sousgroupe").'"',
    'sig_contrainte.libelle as "'._("libelle").'"'
);
$champRecherche = array(
    'sig_contrainte.sig_contrainte as "'.__("sig_contrainte").'"',
    'sig_contrainte.nature as "'.__("nature").'"',
    'sig_groupe.libelle as "'.__("groupe").'"',
    'sig_sousgroupe.libelle as "'.__("sousgroupe").'"',
    'sig_contrainte.libelle as "'.__("libelle").'"',
    'sig_contrainte.no_ordre as "'.__("no_ordre").'"',
    'CONCAT(sig_couche.libelle, \' \', \'(\', sig_couche.id_couche, \')\') as "'.__("sig_couche").'"',
);

//
$sousformulaire = array(
    'lien_sig_contrainte_sig_attribut',
    'lien_sig_contrainte_evenement'
);
