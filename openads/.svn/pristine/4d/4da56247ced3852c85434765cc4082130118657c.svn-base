#! /bin/sh
##
# Ce script permet de générer les fichiers sql d'initialisation de la base de
# données pour permettre de publier une nouvelle version facilement
#
# @package openexemple
# @version SVN : $Id: make_init.sh 3255 2015-01-23 10:12:46Z vpihour $
##

schema="openads"
database="openads"

# Génération du fichier init.sql
# ce fichier doit être récupéré tel quel d'openmairie_exemple sauf dans le cas 
# d'une version non finalisée d'OM exemple
sudo su postgres -c "pg_dump --column-inserts -U postgres -s -O -n $schema -t $schema.om_* $database" > init.sql

# Génération du fichier init_metier.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -s -O -n $schema -T $schema.om_* $database" > init_metier.sql

# Génération de la version de l'application
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.om_version $database" > init_version.sql

# Génération des fichiers de paramétrage
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.bible $database" > init_parametrage_bible.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.demande_nature -t $schema.demande_type openads -t $schema.lien_demande_type_etat" > init_parametrage_demandes.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.genre -t $schema.groupe -t $schema.autorite_competente -t $schema.dossier_autorisation_type -t $schema.dossier_autorisation_type_detaille -t $schema.cerfa -t $schema.dossier_instruction_type -t $schema.lien_om_profil_groupe -t $schema.lien_om_utilisateur_groupe -t $schema.lien_type_di_type_di $database" > init_parametrage_dossiers.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.om_requete -t $schema.om_etat -t $schema.om_lettretype -t $schema.om_logo -t $schema.om_sousetat $database" > init_parametrage_editions.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.om_droit $database" > init_parametrage_permissions.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.document_numerise_type -t $schema.document_numerise_type_categorie -t $schema.document_numerise_nature -t $schema.lien_document_n_type_d_i_t $database" > init_parametrage_numerisation.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.om_collectivite -t $schema.om_parametre -t $schema.om_profil -t $schema.om_widget -t $schema.om_dashboard -t $schema.civilite -t $schema.avis_consultation $database" > init_parametrage.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.etat_dossier_autorisation -t $schema.etat -t $schema.action -t $schema.evenement -t $schema.lien_dossier_instruction_type_evenement -t $schema.avis_decision -t $schema.avis_decision_type -t $schema.avis_decision_nature -t $schema.pec_metier -t $schema.transition $database" > init_parametrage_workflows.sql

# Génération du fichier init_data.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.om_utilisateur -t $schema.direction -t $schema.division -t $schema.instructeur_qualite -t $schema.instructeur -t $schema.architecte $database" > init_data.sql

# Génération du fichier init_data_complement.sql
sudo su postgres -c "pg_dump --column-inserts -U postgres -a -t $schema.service -t $schema.donnees_techniques -t $schema.document_numerise -t $schema.consultation -t $schema.service_categorie -t $schema.lien_service_om_utilisateur -t $schema.lien_service_service_categorie -t $schema.arrondissement -t $schema.quartier -t $schema.affectation_automatique -t $schema.dossier_autorisation -t $schema.dossier_autorisation_parcelle -t $schema.dossier -t $schema.dossier_parcelle -t $schema.signataire_arrete -t $schema.instruction -t $schema.demande -t $schema.demandeur -t $schema.lien_demande_demandeur -t $schema.lien_dossier_autorisation_demandeur -t $schema.lien_dossier_demandeur -t $schema.lot -t $schema.lien_dossier_lot -t $schema.lien_lot_demandeur -t $schema.commission -t $schema.commission_type -t $schema.dossier_commission -t $schema.contrainte -t $schema.moyen_retenu_juge -t $schema.lien_donnees_techniques_moyen_retenu_juge -t $schema.moyen_souleve -t $schema.lien_donnees_techniques_moyen_souleve -t $schema.objet_recours -t $schema.lien_dossier_dossier -t $schema.lien_document_numerise_type_instructeur_qualite -t $schema.categorie_tiers_consulte -t $schema.tiers_consulte -t $schema.motif_consultation -t $schema.lien_om_utilisateur_tiers_consulte -t $schema.lien_categorie_tiers_consulte_om_collectivite -t $schema.evenement_type_habilitation_tiers_consulte -t $schema.compteur -t $schema.lien_dossier_instruction_type_categorie_tiers -t $schema.lien_dossier_tiers -t $schema.famille_travaux -t $schema.nature_travaux -t $schema.lien_dit_nature_travaux -t $schema.lien_dossier_nature_travaux -t $schema.lien_sig_contrainte_evenement $database" > init_data_complement.sql

# Suppression du schéma
sed -i "s/CREATE SCHEMA $schema;/-- CREATE SCHEMA $schema;/g" init*.sql
sed -i "s/^SET/-- SET/g" init*.sql
sed -i "s/^SELECT pg_catalog.set_config/-- SELECT pg_catalog.set_config/g" init*.sql
sed -i "s/$schema\.//g" init*.sql
