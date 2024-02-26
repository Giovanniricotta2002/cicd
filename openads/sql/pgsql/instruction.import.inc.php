<?php
//$Id: instruction.import.inc.php 4418 2015-02-24 17:30:28Z tbenita $ 
//gen openMairie le 10/02/2011 20:34 
$import= "Insertion dans la table instruction voir rec/import_utilisateur.inc";
$table= DB_PREFIXE."instruction";
$id='instruction'; // numerotation automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$DEBUG=0; // =0 pas d affichage messages / =1 affichage detail enregistrement
$fic_erreur=1; // =0 pas de fichier d erreur / =1  fichier erreur
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon
$obligatoire['instruction']=1;// obligatoire = 1
//* cle secondaire=evenement
$exist['evenement']=1;//  0=non / 1=oui
$sql_exist['evenement']= "select * from ".DB_PREFIXE."evenement where evenement = '";
//* cle secondaire=dossier
$exist['dossier']=1;//  0=non / 1=oui
$sql_exist['dossier']= "select * from ".DB_PREFIXE."dossier where dossier = '";
//* cle secondaire=action
$exist['action']=1;//  0=non / 1=oui
$sql_exist['action']= "select * from ".DB_PREFIXE."action where action = '";
//* cle secondaire=etat
$exist['etat']=1;//  0=non / 1=oui
$sql_exist['etat']= "select * from ".DB_PREFIXE."etat where etat = '";
//* cle secondaire=avis_decision
$exist['avis_decision']=1;//  0=non / 1=oui
$sql_exist['avis_decision']= "select * from ".DB_PREFIXE."avis_decision where avis_decision = '";
// * champ = instruction
$zone['instruction']='0';
// $defaut['instruction']='***'; // *** par defaut si non renseigne
// * champ = destinataire
$zone['destinataire']='1';
// $defaut['destinataire']='***'; // *** par defaut si non renseigne
// * champ = date_evenement
$zone['date_evenement']='2';
// $defaut['date_evenement']='***'; // *** par defaut si non renseigne
// * champ = evenement
$zone['evenement']='3';
// $defaut['evenement']='***'; // *** par defaut si non renseigne
// * champ = lettretype
$zone['lettretype']='4';
// $defaut['lettretype']='***'; // *** par defaut si non renseigne
// * champ = complement_om_html
$zone['complement_om_html']='5';
// $defaut['complement_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement2_om_html
$zone['complement2_om_html']='6';
// $defaut['complement2_om_html']='***'; // *** par defaut si non renseigne
// * champ = dossier
$zone['dossier']='7';
// $defaut['dossier']='***'; // *** par defaut si non renseigne
// * champ = action
$zone['action']='8';
// $defaut['action']='***'; // *** par defaut si non renseigne
// * champ = delai
$zone['delai']='9';
// $defaut['delai']='***'; // *** par defaut si non renseigne
// * champ = etat
$zone['etat']='10';
// $defaut['etat']='***'; // *** par defaut si non renseigne
// * champ = accord_tacite
$zone['accord_tacite']='11';
// $defaut['accord_tacite']='***'; // *** par defaut si non renseigne
// * champ = delai_notification
$zone['delai_notification']='12';
// $defaut['delai_notification']='***'; // *** par defaut si non renseigne
// * champ = avis_decision
$zone['avis_decision']='13';
// $defaut['avis_decision']='***'; // *** par defaut si non renseigne
// * champ = archive_delai
$zone['archive_delai']='14';
// $defaut['archive_delai']='***'; // *** par defaut si non renseigne
// * champ = archive_date_complet
$zone['archive_date_complet']='15';
// $defaut['archive_date_complet']='***'; // *** par defaut si non renseigne
// * champ = archive_date_complet
$zone['archive_date_dernier_depot']='16';
// $defaut['archive_date_complet']='***'; // *** par defaut si non renseigne
// * champ = archive_date_rejet
$zone['archive_date_rejet']='17';
// $defaut['archive_date_rejet']='***'; // *** par defaut si non renseigne
// * champ = archive_date_limite
$zone['archive_date_limite']='18';
// $defaut['archive_date_limite']='***'; // *** par defaut si non renseigne
// * champ = archive_date_notification_delai
$zone['archive_date_notification_delai']='19';
// $defaut['archive_date_notification_delai']='***'; // *** par defaut si non renseigne
// * champ = archive_accord_tacite
$zone['archive_accord_tacite']='20';
// $defaut['archive_accord_tacite']='***'; // *** par defaut si non renseigne
// * champ = archive_etat
$zone['archive_etat']='21';
// $defaut['archive_etat']='***'; // *** par defaut si non renseigne
// * champ = archive_date_decision
$zone['archive_date_decision']='22';
// $defaut['archive_date_decision']='***'; // *** par defaut si non renseigne
// * champ = archive_avis
$zone['archive_avis']='23';
// $defaut['archive_avis']='***'; // *** par defaut si non renseigne
// * champ = archive_date_validite
$zone['archive_date_validite']='24';
// $defaut['archive_date_validite']='***'; // *** par defaut si non renseigne
// * champ = archive_date_achevement
$zone['archive_date_achevement']='25';
// $defaut['archive_date_achevement']='***'; // *** par defaut si non renseigne
// * champ = archive_date_chantier
$zone['archive_date_chantier']='26';
// $defaut['archive_date_chantier']='***'; // *** par defaut si non renseigne
// * champ = archive_date_conformite
$zone['archive_date_conformite']='27';
// $defaut['archive_date_conformite']='***'; // *** par defaut si non renseigne
// * champ = complement3_om_html
$zone['complement3_om_html']='28';
// $defaut['complement3_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement4_om_html
$zone['complement4_om_html']='29';
// $defaut['complement4_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement5_om_html
$zone['complement5_om_html']='30';
// $defaut['complement5_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement6_om_html
$zone['complement6_om_html']='31';
// $defaut['complement6_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement7_om_html
$zone['complement7_om_html']='32';
// $defaut['complement7_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement8_om_html
$zone['complement8_om_html']='33';
// $defaut['complement8_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement9_om_html
$zone['complement9_om_html']='34';
// $defaut['complement9_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement10_om_html
$zone['complement10_om_html']='35';
// $defaut['complement10_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement11_om_html
$zone['complement11_om_html']='36';
// $defaut['complement11_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement12_om_html
$zone['complement12_om_html']='37';
// $defaut['complement12_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement13_om_html
$zone['complement13_om_html']='38';
// $defaut['complement13_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement14_om_html
$zone['complement14_om_html']='39';
// $defaut['complement14_om_html']='***'; // *** par defaut si non renseigne
// * champ = complement15_om_html
$zone['complement15_om_html']='40';
// $defaut['complement15_om_html']='***'; // *** par defaut si non renseigne
?>