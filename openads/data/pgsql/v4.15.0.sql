-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.15.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.15.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9529] - Envois de mails multiples aux services consultés
--

ALTER TABLE service ALTER COLUMN email TYPE text;

--
-- END / [#9529] - Envois de mails multiples aux services consultés
--
