-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.6.1' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.6.1') WHERE exists(SELECT 1 FROM om_version) = false;
