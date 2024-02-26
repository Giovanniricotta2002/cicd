--------------------------------------------------------------------------------
-- Instructions pour l'utilisation d'une vue pour la table rivoli
--
-- @package openfoncier
-- @version SVN : $Id: init_metier_vue.sql 1804 2013-04-30 14:45:17Z fmichon $
--------------------------------------------------------------------------------

-- -------------------------------------------
-- les vues proposées ici sont celles qui sont
-- specifiques à la ville d arles
-- avec la base postgresql - postgis DYNMAP
-- elles sont présentées ici à titre indicatif
-- d'exemple de croisement avec les données SIG
-- --------------------------------------------

-- -----------------------------------------------------------------------------
-- dans openFoncier faire des vues dans dynmap pour pos, parcelle et rivoli/var
-- creation de vue et destruction des tables coorespondantes
-- dans var.inc :  vue_rivoli = 1 pour empecher la maj
-- -----------------------------------------------------------------------------

-- exemple de vue sur openadresse table rivoli dans le schema openfoncier
CREATE OR REPLACE VIEW openfoncier.rivoli AS 
 SELECT rivoli AS rivoli,
	(type_voie||' ' ||nom_complet) as libelle        
   FROM openadresse.rivoli; 

