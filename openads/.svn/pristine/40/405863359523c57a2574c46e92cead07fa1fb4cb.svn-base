-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.10.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.10.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9128] Permettre à l’utilisateur de choisir son type de rédaction
-- de l’édition d’instruction, soit “Rédaction par compléments”, soit
-- “Rédaction libre”
--

-- Ajout des champs dans la table instruction
ALTER TABLE instruction
ADD flag_edition_integrale boolean NULL,
ADD titre_om_htmletat text NULL,
ADD corps_om_htmletatex text NULL;
COMMENT ON COLUMN instruction.flag_edition_integrale IS 'Flag permettant d''identifier le type de rédaction ("true" la rédaction est libre et permet de modifier le titre et le corps du courrier, "false" la rédaction est par complément)';
COMMENT ON COLUMN instruction.titre_om_htmletat IS 'Contenu du titre du courrier récupéré depuis la lettre type associé';
COMMENT ON COLUMN instruction.corps_om_htmletatex IS 'Contenu du corps du courrier récupéré depuis la lettre type associé';

--
-- END / [#9128] Permettre à l’utilisateur de choisir son type de rédaction
-- de l’édition d’instruction, soit “Rédaction par compléments”, soit
-- “Rédaction libre”
--

--
-- BEGIN / [#9139] Ajout d’une régle d’action pour le changement du type du dossier
--
ALTER TABLE action ADD COLUMN regle_dossier_instruction_type varchar(60) DEFAULT NULL;
COMMENT ON COLUMN action.regle_dossier_instruction_type IS  'Règle de modification du type de dossier d''instruction';

ALTER TABLE instruction ADD COLUMN archive_dossier_instruction_type integer;
COMMENT ON COLUMN instruction.archive_dossier_instruction_type IS  'Type du dossier d''instruction';
--
-- END / [#9139] Ajout d’une régle d’action pour le changement du type du dossier
--

