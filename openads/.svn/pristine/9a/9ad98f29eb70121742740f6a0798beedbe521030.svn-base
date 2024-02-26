--------------------------------------------------------------------------------
-- Instructions pour l'utilisation du SIG via postgis
--
-- @package openfoncier
-- @version SVN : $Id: init_metier_sig.sql 1804 2013-04-30 14:45:17Z fmichon $
--------------------------------------------------------------------------------

--
ALTER TABLE dossier DROP COLUMN geom;
ALTER TABLE dossier DROP COLUMN geom1;

--
SELECT AddGeometryColumn ( 'dossier', 'geom', 2154 , 'POINT', 2 );
SELECT AddGeometryColumn ( 'dossier', 'geom1', 2154 , 'MULTIPOLYGON', 2 );
