--------------------------------------------------------------------------------
-- Script d'installation
--
-- ATTENTION ce script peut supprimer des données de votre base de données
-- il n'est à utiliser qu'en connaissance de cause
--
-- @package openfoncier
-- @version SVN : $Id: install.sql 3314 2015-02-23 11:31:05Z vpihour $
--------------------------------------------------------------------------------

-- Début du bloc transactionnel
START TRANSACTION;

-- Usage :
-- cd data/pgsql/
-- dropdb openads && createdb openads && psql openads -f install.sql

-- Initialisation de postgis : A CHANGER selon les configurations
-- A commenter/décommenter pour initialiser postgis
-- --> postgis 1.5 / postgresql 9.1
-- \i /usr/share/postgresql/9.1/contrib/postgis-1.5/postgis.sql
-- \i /usr/share/postgresql/9.1/contrib/postgis-1.5/spatial_ref_sys.sql
-- --> postgis 2
CREATE EXTENSION IF NOT EXISTS postgis;

-- Suppression, Création et Utilisation du schéma
DROP SCHEMA IF EXISTS openads CASCADE;
CREATE SCHEMA openads;
SET search_path = openads, public, pg_catalog;

-- Instructions de base du framework openmairie
\i init.sql

-- Instructions de base de l'applicatif 
\i init_metier.sql

-- Instructions pour l'utilisation de postgis
\i init_metier_sig.sql

-- Vérification de l'unicité des codes valide des types de document
\i check_document_numerise_type_valide_unique.sql

-- Initialisation du paramétrage
\i init_parametrage.sql
\i init_parametrage_permissions.sql
\i init_parametrage_editions.sql
\i init_parametrage_dossiers.sql
\i init_parametrage_workflows.sql
\i init_parametrage_demandes.sql
\i init_parametrage_bible.sql
\i init_parametrage_numerisation.sql


-- Initialisation d'un jeu de données
-- A commenter/décommenter pour installer un jeu de données
\i init_data.sql
\i init_data_complement.sql

-- Mise à jour des séquences
\set schema '\'openads\''
\i update_sequences.sql

-- Mise à jour depuis la dernière version (en cours de développement)
\i v6.2.0.dev0.sql
\i v6.2.0.dev0.init_data.sql

\set schema '\'openads\''
\i update_sequences.sql

-- Fin du bloc transactionnel
COMMIT;
