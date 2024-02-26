<?php
//$Id: ads2007.import_specific.inc.php 4818 2015-06-09 11:06:14Z nhaye $
//gen openMairie le 10/02/2011 20:39
$import= "Import des dossiers ADS 2007 clôturés";
$treatment = "ads2007";
$table= DB_PREFIXE."dossier";
$id=''; // numerotation non automatique
$verrou=1;// =0 pas de mise a jour de la base / =1 mise a jour
$DEBUG=0; // =0 pas d affichage messages / =1 affichage detail enregistrement
$fic_erreur=1; // =0 pas de fichier d erreur / =1  fichier erreur
$fic_rejet=1; // =0 pas de fichier pour relance / =1 fichier relance traitement
$ligne1=1;// = 1 : 1ere ligne contient nom des champs / o sinon


$fields = array();

// Type
$fields["type"] = array(
    "header" => "Type",
    "type"=> "string",
    "require" => true,
    "link" => array(
        "PC MI" => "PI",
        "PCMI"  => "PI",
        "PCI"   => "PI",
        "PA PC" => "PA",
        "PC PD" => "PC",
        "PA PD" => "PA",
        "IA"    => "DIA",
        ),
    "foreign_key" => array(
        "id"    => "dossier_autorisation_type_detaille",
        "table" => "dossier_autorisation_type_detaille",
        "field" => "code",
    ),
    );
// Numéro
$fields["numero"] = array(
    "header" => "Numéro",
    "type"=> "string",
    "require" => true,
    );
// Initial
$fields["initial"] = array(
    "header" => "Initial",
    "type"=> "string",
    "require" => false,

    );
// INSEE
$fields["insee"] = array(
    "header" => "INSEE",
    "type"=> "string",
    "require" => true,
    );
// Commune
$fields["commune"] = array(
    "header" => "Commune",
    "type"=> "string",
    "require" => false,
    );
// Autonome
$fields["autonome"] = array(
    "header" => "Autonome",
    "type"=> "boolean",
    "require" => false,
    );
// Projet
$fields["projet"] = array(
    "header" => "Projet",
    "type"=> "string",
    "require" => false,
    );
// Destination
$fields["destination"] = array(
    "header" => "Destination",
    "type"=> "string",
    "require" => false,
    );
// Nb logements
$fields["nb_logements"] = array(
    "header" => "Nb logements",
    "type"=> "integer",
    "require" => false,
    );
// Surface terrain
$fields["surface_terrain"] = array(
    "header" => "Surface terrain",
    "type"=> "float",
    "require" => false,
    );
// SHON existante
$fields["shon_existante"] = array(
    "header" => "SHON existante",
    "type"=> "float",
    "require" => false,
    );
// SHON construite
$fields["shon_construite"] = array(
    "header" => "SHON construite",
    "type"=> "float",
    "require" => false,
    );
// SHON transformation SHOB
$fields["shon_transformation_shob"] = array(
    "header" => "SHON transformation SHOB",
    "type"=> "float",
    "require" => false,
    );
// SHON changement destination
$fields["shon_changement_destination"] = array(
    "header" => "SHON changement destination",
    "type"=> "float",
    "require" => false,
    );
// SHON démolie
$fields["shon_demolie"] = array(
    "header" => "SHON démolie",
    "type"=> "float",
    "require" => false,
    );
// SHON supprimée
$fields["shon_supprimee"] = array(
    "header" => "SHON supprimée",
    "type"=> "float",
    "require" => false,
    );
// Architecte
$fields["architecte"] = array(
    "header" => "Architecte",
    "type"=> "boolean",
    "require" => false,
    );
// Demandeur
$fields["demandeur"] = array(
    "header" => "Demandeur",
    "type"=> "string",
    "require" => true,
    );
// Opposition CNIL
$fields["opposition_cnil"] = array(
    "header" => "Opposition CNIL",
    "type"=> "boolean",
    "require" => false,
    );
// Adresse demandeur
$fields["adresse_demandeur"] = array(
    "header" => "Adresse demandeur",
    "type"=> "string",
    "require" => false,
    );
// Terrain
$fields["terrain"] = array(
    "header" => "Terrain",
    "type"=> "string",
    "require" => false,
    );
// Références cadastrales
$fields["references_cadastrales"] = array(
    "header" => "Références cadastrales",
    "type"=> "string",
    "require" => false,
    );
// Lotissement
$fields["lotissement"] = array(
    "header" => "Lotissement",
    "type"=> "boolean",
    "require" => false,
    );
// AFU
$fields["afu"] = array(
    "header" => "AFU",
    "type"=> "boolean",
    "require" => false,
    );
// Détail ZAC AFU
$fields["detail_zac_afu"] = array(
    "header" => "Détail ZAC AFU",
    "type"=> "string",
    "require" => false,
    );
// Autorité
$fields["autorite"] = array(
    "header" => "Autorité",
    "type"=> "string",
    "require" => true,
    "link" => array(
        "Le préfet Au nom de l'État" => "ETAT",
        "Le maire Au nom de l'État" => "ETATMAIRE",
        "Le maire Au nom de la commune" => "COM",
        ),

    "foreign_key" => array(
        "id"    => "autorite_competente",
        "table" => "autorite_competente",
        "field" => "code",
    )
    );
// Etat
$fields["etat"] = array(
    "header" => "Etat",
    "type"=> "string",
    "require" => true,
    "link" => array(
        "Abandon de projet"                     => "retire",
        "Accord Tacite"                         => "accepte_tacite",
        "Accord avec adaption mineur"           => "accepter",
        "Accord avec prescriptions"             => "accepter",
        "Accord avec réserve"                   => "accepter",
        "Accord sous condition"                 => "accepter",
        "Accord tacite présumé"                 => "accepte_tacite",
        "Accord"                                => "accepter",
        "Accordé sous réserve"                  => "accepter",
        "Accordé tacite"                        => "accepte_tacite",
        "Accorde"                               => "accepter",
        "Accordé"                               => "accepter",
        "Achèvement de travaux"                 => "accepter",
        "Annulation par tribunal"               => "annule",
        "Annulation"                            => "annule",
        "Caducité"                              => "accepter",
        "Classement sans suite"                 => "sans_suite",
        "Defavorable"                           => "refuse",
        "Dossier classé sans suite"             => "sans_suite",
        "Dossier irrecevable"                   => "sans_suite",
        "Décision notifiée au demandeur"        => "terminer",
        "Défavorable"                           => "refuse",
        "Favorable avec Reserves"               => "accepter",
        "Favorable avec prescriptions"          => "accepter",
        "Favorable"                             => "accepter",
        "Informatif"                            => "accepter",
        "Irrecevable"                           => "dossier_irrecevable",
        "Non instruit"                          => "sans_suite",
        "Octroi tacite"                         => "accepte_tacite",
        "Octroi"                                => "accepter",
        "Op. Négatif"                           => "refuse",
        "Op. Positif"                           => "accepter",
        "Ouverture de chantier"                 => "accepter",
        "PC non instruit nécessite modificatif" => "dossier_irrecevable",
        "Pièce manquante en attente"            => "refuse",
        "Rectificatif"                          => "accepter",
        "Refus tacite présumé"                  => "refuse_tacite",
        "Refus tacite presume"                  => "refuse_tacite",
        "Refus"                                 => "refuse",
        "Refusé tacite"                         => "refuse_tacite",
        "Rejet tacite"                          => "rejeter",
        "Sans Objet"                            => "sans_suite",
        "Sans Suite"                            => "sans_suite",
        "Sursis a statuer"                      => "Sursis_a_statuer",
        "Sursis à statuer"                      => "Sursis a statuer",
        "Tacite"                                => "accepte_tacite",
        "Transfert accordé"                     => "accepter",
        "Transfert"                             => "accepter",
        "Transféré"                             => "accepter",
        "[reprise] demande enregistree"         => "accepter",
        "[reprise] demande enregistrée"         => "accepter",
        "[reprise]Classé sans suite"            => "sans_suite",
        "[reprise]Dossier irrecevable"          => "dossier_irrecevable",
        "[reprise]Non instruit"                 => "non_instruit",
        "[reprise]demande enregistree"          => "accepter",
        "[reprise]demande enregistrée"          => "accepter",
        "rejet"                                 => "rejeter",
        "rejet_tacite"                          => "rejeter",
        "retiré"                                => "retire",
        "sursis_a_statuer"                      => "Sursis_a_statuer",
        ),
    "foreign_key" => array(
        "id"    => "etat",
        "table" => "etat",
        "field" => "etat",
    )
    );
// Centre instructeur
$fields["centre_instructeur"] = array(
    "header" => "Centre instructeur",
    "type"=> "string",
    "require" => false,
    );
// Instructeur
$fields["instructeur"] = array(
    "header" => "Instructeur",
    "type"=> "string",
    "require" => false,
    );
// Liquidateur
$fields["liquidateur"] = array(
    "header" => "Liquidateur",
    "type"=> "string",
    "require" => false,
    );
// Complexité
$fields["complexite"] = array(
    "header" => "Complexité",
    "type"=> "string",
    "require" => false,
    );
// Dépôt en mairie
$fields["depot_en_mairie"] = array(
    "header" => "Dépôt en mairie",
    "type"=> "date",
    "require" => true,
    );
// Réception DDE
$fields["reception_dde"] = array(
    "header" => "Réception DDE",
    "type"=> "date",
    "require" => false,
    );
// Complétude
$fields["completude"] = array(
    "header" => "Complétude",
    "type"=> "date",
    "require" => false,
    );
// Notification majoration
$fields["notification_majoration"] = array(
    "header" => "Notification majoration",
    "type"=> "date",
    "require" => false,
    );
// DLI
$fields["dli"] = array(
    "header" => "DLI",
    "type"=> "date",
    "require" => false,
    );
// Date envoi demande de pièces
$fields["date_envoi_demande_de_pieces"] = array(
    "header" => "Date envoi demande de pièces",
    "type"=> "date",
    "require" => false,
    );
// Date notification demande de pièces
$fields["date_notification_demande_de_pieces"] = array(
    "header" => "Date notification demande de pièces",
    "type"=> "date",
    "require" => false,
    );
// Date envoi délai majoration
$fields["date_envoi_delai_majoration"] = array(
    "header" => "Date envoi délai majoration",
    "type"=> "date",
    "require" => false,
    );
// Date notification délai majoration
$fields["date_notification_delai_majoration"] = array(
    "header" => "Date notification délai majoration",
    "type"=> "date",
    "require" => false,
    );
// Service consulté
$fields["service_consulte"] = array(
    "header" => "Service consulté",
    "type"=> "string",
    "require" => false,
    );
// Proposition service
$fields["proposition_service"] = array(
    "header" => "Proposition service",
    "type"=> "string",
    "require" => false,
    );
// Date proposition service
$fields["date_proposition_service"] = array(
    "header" => "Date proposition service",
    "type"=> "date",
    "require" => false,
    );
// Date transmission proposition
$fields["date_transmission_proposition"] = array(
    "header" => "Date transmission proposition",
    "type"=> "date",
    "require" => false,
    );
// Date instruction terminée
$fields["date_instruction_terminee"] = array(
    "header" => "Date instruction terminée",
    "type"=> "date",
    "require" => false,
    );
// Date accord tacite
$fields["date_accord_tacite"] = array(
    "header" => "Date accord tacite",
    "type"=> "date",
    "require" => false,
    );
// Date de rejet tacite
$fields["date_de_rejet_tacite"] = array(
    "header" => "Date de rejet tacite",
    "type"=> "date",
    "require" => false,
    );
// Date de refus tacite
$fields["date_de_refus_tacite"] = array(
    "header" => "Date de refus tacite",
    "type"=> "date",
    "require" => false,
    );
// Date de décision
$fields["date_de_decision"] = array(
    "header" => "Date de décision",
    "type"=> "date",
    "require" => false,
    );
// Date notification décision
$fields["date_notification_decision"] = array(
    "header" => "Date notification décision",
    "type"=> "date",
    "require" => false,
    );
// Nature décision
$fields["nature_decision"] = array(
    "header" => "Nature décision",
    "type"=> "string",
    "require" => false,
    "link" => array(
        "Abandon de projet"                     => "retiré",
        "Accord avec adaption mineur"           => "Favorable avec Reserves",
        "Accord avec prescriptions"             => "Favorable avec Reserves",
        "Accord avec réserve"                   => "Favorable avec Reserves",
        "Accord sous condition"                 => "Favorable avec Reserves",
        "Accord"                                => "Favorable",
        "Accordé"                               => "Favorable",
        "Caducité"                              => "Defavorable",
        "Classement sans suite"                 => "[reprise]Classé sans suite",
        "Défavorable"                           => "Defavorable",
        "Favorable avec prescriptions"          => "Favorable avec Reserves",
        "Informatif"                            => "Favorable",
        "Irrecevable"                           => "[reprise]Dossier irrecevable",
        "Irrecevable"                           => "[reprise]Dossier irrecevable",
        "Non instruit"                          => "[reprise]Non instruit",
        "Octroi tacite"                         => "Accord Tacite",
        "Octroi"                                => "Favorable",
        "Op. Négatif"                           => "Defavorable",
        "Op. Positif"                           => "Favorable",
        "PC non instruit nécessite modificatif" => "[reprise]Dossier irrecevable",
        "Rectificatif"                          => "",
        "Refus"                                 => "Defavorable",
        "Sans Objet"                            => "[reprise]Non instruit",
        "Sans Suite"                            => "[reprise]Classé sans suite",
        "Sursis à statuer"                      => "Sursis a statuer",
        "Tacite"                                => "Accord Tacite",
        "Transfert accordé"                     => "Favorable",
        "Transfert"                             => "Favorable",
        "[reprise] demande enregistree"         => "[reprise]demande enregistrée",
        "[reprise]demande enregistree"          => "[reprise]demande enregistrée",
        ),
    "foreign_key" => array(
        "id"    => "avis_decision",
        "table" => "avis_decision",
        "field" => "libelle",
    )
    );
// Récolement
$fields["recolement"] = array(
    "header" => "Récolement",
    "type"=> "string",
    "require" => false,
    );
// DOC
$fields["doc"] = array(
    "header" => "DOC",
    "type"=> "date",
    "require" => false,
    );
// DAACT
$fields["daact"] = array(
    "header" => "DAACT",
    "type"=> "date",
    "require" => false,
    );
// Type Evolution
$fields["type_evolution"] = array(
    "header" => "Type Evolution",
    "type"=> "string",
    "require" => false,
    );
// Statut Evolution
$fields["statut_evolution"] = array(
    "header" => "Statut Evolution",
    "type"=> "string",
    "require" => false,
    );
// Type dernières taxes
$fields["type_dernieres_taxes"] = array(
    "header" => "Type dernières taxes",
    "type"=> "string",
    "require" => false,
    );
// Statut dernières taxes
$fields["statut_dernieres_taxes"] = array(
    "header" => "Statut dernières taxes",
    "type"=> "string",
    "require" => false,
    );
// Type dernière RAP
$fields["type_derniere_rap"] = array(
    "header" => "Type dernière RAP",
    "type"=> "string",
    "require" => false,
    );
// Statut dernière RAP
$fields["statut_derniere_rap"] = array(
    "header" => "Statut dernière RAP",
    "type"=> "string",
    "require" => false,
    );
// EPCI
$fields["epci"] = array(
    "header" => "EPCI",
    "type"=> "string",
    "require" => false,
    );

?>
