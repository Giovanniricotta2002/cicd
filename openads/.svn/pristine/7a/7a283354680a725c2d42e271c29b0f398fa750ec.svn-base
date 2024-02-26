-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.9.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.9.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9094] Filtre des alertes de visite et de parquet sur les infractions en cours d'instruction
--

-- Ajout des permissions du listing des alertes visite pour le profil
-- 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL'
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contentieux_alerte_visite', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_visite' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Ajout des permissions du listing des alertes parquet pour le profil
-- 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL'
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contentieux_alerte_parquet', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_parquet' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Suppression des widgets d'alertes de visite et de parquet existants sur le
-- tableau de bord du profil 'TECHNICIEN' quelques soit leurs noms
DELETE FROM om_dashboard
WHERE om_widget = (SELECT om_widget FROM om_widget WHERE script = 'dossier_contentieux_alerte_visite')
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN');
DELETE FROM om_dashboard
WHERE om_widget = (SELECT om_widget FROM om_widget WHERE script = 'dossier_contentieux_alerte_parquet')
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN');

-- Ajout du widget 'Mes alertes visites'
INSERT INTO om_widget (om_widget, libelle, lien, texte, script, type)
SELECT nextval('om_widget_seq'), 'Mes alertes visites', '', '', 'dossier_contentieux_alerte_visite', 'file'
WHERE NOT EXISTS (
    SELECT libelle FROM om_widget WHERE libelle = 'Mes alertes visites' AND script = 'dossier_contentieux_alerte_visite'
);

-- Ajout du widget 'Mes alertes parquets'
INSERT INTO om_widget (om_widget, libelle, lien, texte, script, type)
SELECT nextval('om_widget_seq'), 'Mes alertes parquets', '', '', 'dossier_contentieux_alerte_parquet', 'file'
WHERE NOT EXISTS (
    SELECT libelle FROM om_widget WHERE libelle = 'Mes alertes parquets' AND script = 'dossier_contentieux_alerte_parquet'
);

-- Ajout du widget 'Mes alertes visites' sur le tableau de bord du profil
-- 'TECHNICIEN'
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), 'C3', 1, (SELECT om_widget FROM om_widget WHERE libelle = 'Mes alertes visites')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes alertes visites') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

-- Ajout du widget 'Mes alertes parquets' sur le tableau de bord du profil
-- 'TECHNICIEN'
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), 'C3', 2, (SELECT om_widget FROM om_widget WHERE libelle = 'Mes alertes parquets')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes alertes parquets') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

--
-- END / [#9094] Filtre des alertes de visite et de parquet sur les infractions en cours d'instruction
--

--
-- BEGIN / [#9095] Ajout d’un champ de référence DSJ pour les contentieux
--

--Référence DSJ
ALTER TABLE donnees_techniques ADD COLUMN ctx_reference_dsj varchar(30);
COMMENT ON COLUMN donnees_techniques.ctx_reference_dsj IS 'Référence DSJ';

ALTER TABLE cerfa ADD COLUMN ctx_reference_dsj boolean NOT NULL DEFAULT false;
COMMENT ON COLUMN cerfa.ctx_reference_dsj IS 'Référence DSJ';

--
-- END / [#9095] Ajout d’un champ de référence DSJ pour les contentieux
--

--
-- BEGIN / [#9098] Filtre du menu *Mes infractions* et du widget lié sur les infractions
-- en cours d'instruction
--

-- Mes infractions
UPDATE om_widget SET libelle = 'Mes Infractions' WHERE libelle = 'Mes Infraction';

--
-- END / [#9098] Filtre du menu *Mes infractions* et du widget lié sur les infractions
-- en cours d'instruction
--

--
-- BEGIN / [#9096] Suppression d'un dossier d'instruction sous condition
--

--
-- Ajout des permissions de suppression aux profils
--

-- GUICHET ET SUIVI
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);

-- INSTRUCTEUR POLYVALENT
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

-- INSTRUCTEUR POLYVALENT COMMUNE
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier__instruction_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

-- ADMINISTRATEUR GENERAL
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

-- ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contentieux_mes_recours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contentieux_mes_infractions_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#9096] Suppression d'un dossier d'instruction sous condition
--
