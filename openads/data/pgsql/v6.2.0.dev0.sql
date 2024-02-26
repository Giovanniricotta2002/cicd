-- MàJ de la version en BDD
UPDATE om_version SET om_version = '6.2.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('6.2.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#10283] La reprise de rédaction sur une instruction ne devrait plus être possible si le document est signé électroniquement
--

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_definaliser_apres_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_definaliser_apres_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
--

--
-- END / [#10283] La reprise de rédaction sur une instruction ne devrait plus être possible si le document est signé électroniquement
--
