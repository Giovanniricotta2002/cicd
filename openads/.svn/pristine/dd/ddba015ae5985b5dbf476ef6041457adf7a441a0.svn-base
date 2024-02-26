-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.12.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.12.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / #1437 — [#9918] Ajout de la recherche de dossier sur le tableau de bord pour le profil d'administrateur technique et fonctionnel
--

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL'), 'C1',   1,  (SELECT om_widget FROM om_widget WHERE script = 'recherche_dossier')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE script = 'recherche_dossier') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

--
-- END / #1437 — [#9918] Ajout de la recherche de dossier sur le tableau de bord pour le profil d'administrateur technique et fonctionnel
--


--
-- BEGIN / [#9922] - Évolution du moniteur plat'au / ide'au
--

CREATE INDEX IF NOT EXISTS task_dossier ON task (dossier);

--
-- END / [#9922] - Évolution du moniteur plat'au / ide'au
--

--
-- BEGIN / Ajout des permissions manquantes pour l'envoi au contrôle de légalité
--

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'instruction_envoyer_au_controle_de_legalite', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_au_controle_de_legalite' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'instruction_envoyer_au_controle_de_legalite', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_au_controle_de_legalite' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    );

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'instruction_envoyer_au_controle_de_legalite', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_au_controle_de_legalite' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    );

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'instruction_envoyer_au_controle_de_legalite', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_au_controle_de_legalite' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
    );

--
-- END / Ajout des permissions manquantes pour l'envoi au contrôle de légalité
--
