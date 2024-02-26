<?php
//$Id: dossierlimite.inc.php 4418 2015-02-24 17:30:28Z tbenita $
$DEBUG=0;
$serie=20;
$ent = _("dossier_limite");
$edition="";
$tri="";
$table=DB_PREFIXE."dossier left join ".DB_PREFIXE."om_utilisateur on om_utilisateur.om_utilisateur = dossier.instructeur";
$champAffiche=array("dossier","to_char(date_limite,'DD/MM/YYYY') as limite, etat, om_utilisateur.login");
$champRecherche=array("dossier");
$selection = "where (date_limite  <= current_date + 10)";
$selection.= " and om_utilisateur.login = '".$_SESSION['login']."'";
$selection.= " and  etat ='notifier' ";



// pas d ajout
//$href[0]['lien']= "";
//$href[0]['id']= "";
//$href[0]['lib']= "";
//$href[1]['lien']= "";
//$href[1]['id']= "";
//$href[1]['lib']= "";
// vu courrier
//$href[2]['lien'] = "dossier.php?idx=";
//$href[2]['id']=  "";
//$href[2]['lib']= "<img src='../img/dossier.png' border='0'>";
?>