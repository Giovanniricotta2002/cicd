-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.13.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.13.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN /  #1443 — [#9924] Ajout de la permission "instruction_modal_selection_document_signe" à un profil instructeur
--


INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modale_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modale_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modale_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modale_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
--
-- END / #1443 — [#9924] Ajout de la permission "instruction_modal_selection_document_signe" à un profil instructeur
--

--
-- BEGIN / [#9939] Ajout d'un champ de fusion pour identifier un dossier déposé électroniquement
--

--
\i v5.13.0-om_requete.sql

--
-- END / [#9939] Ajout d'un champ de fusion pour identifier un dossier déposé électroniquement
--