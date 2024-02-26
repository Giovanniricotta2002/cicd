-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.16.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.16.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#10046]-Bug d'affichage du journal d'instruction selon le point d'entrée
--

-- Donne la permission aux utilisateurs ADMINISTRATEUR GENERAL, ADMINISTRATEUR FONCTIONNEL, ADMINISTRATEUR TECHNIQUE et ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL de voir le lien du portlet "Journal d'instruction" depuis le menu mes encours

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#10046]-Bug d'affichage du journal d'instruction selon le point d'entrée
--

--
-- BEGIN / [#10060] Évolutions du connecteur SIG - phase 4 - géolocalisation par disque (latitude, longitude, rayon)
--

ALTER TABLE dossier
    ADD COLUMN IF NOT EXISTS geoloc_latitude varchar(50) NULL,
    ADD COLUMN IF NOT EXISTS geoloc_longitude varchar(50) NULL,
    ADD COLUMN IF NOT EXISTS geoloc_rayon double precision NULL;
COMMENT ON COLUMN dossier.geoloc_latitude IS 'Latitude du point permettant la géolocalisation en disque';
COMMENT ON COLUMN dossier.geoloc_longitude IS 'Longitude du point permettant la géolocalisation en disque';
COMMENT ON COLUMN dossier.geoloc_rayon IS 'Rayon de la géolocalisation en disque';

--
-- END / [#10060] Évolutions du connecteur SIG - phase 4 - géolocalisation par disque (latitude, longitude, rayon)
--

--
-- BEGIN /  [#10090] - Notification automatique des tiers - gestion des acteurs des dossiers d'instruction
--

-- Création de la table lien_dossier_instruction_type_categorie_tiers
CREATE TABLE IF NOT EXISTS lien_dossier_instruction_type_categorie_tiers (
    lien_dossier_instruction_type_categorie_tiers INTEGER NOT NULL,
    dossier_instruction_type INTEGER NOT NULL,
    categorie_tiers INTEGER NOT NULL,
    CONSTRAINT lien_dossier_instruction_type_categorie_tiers_pkey PRIMARY KEY (lien_dossier_instruction_type_categorie_tiers)
);

COMMENT ON TABLE lien_dossier_instruction_type_categorie_tiers IS 'Catégorie de tiers associé à un type de dossier';
COMMENT ON COLUMN lien_dossier_instruction_type_categorie_tiers.lien_dossier_instruction_type_categorie_tiers IS 'Identifiant unique';
COMMENT ON COLUMN lien_dossier_instruction_type_categorie_tiers.dossier_instruction_type IS 'Identifiant du type de dossier d''instruction';
COMMENT ON COLUMN lien_dossier_instruction_type_categorie_tiers.categorie_tiers IS 'Identifiant de la catégorie de tiers';

-- Séquence de la table lien_dossier_instruction_type_categorie_tiers
CREATE SEQUENCE IF NOT EXISTS lien_dossier_instruction_type_categorie_tiers_seq
   START WITH 1
   INCREMENT BY 1
   NO MINVALUE
   NO MAXVALUE
   CACHE 1;

-- Contraintes de la table lien_dossier_instruction_type_categorie_tiers
ALTER TABLE ONLY lien_dossier_instruction_type_categorie_tiers
   DROP CONSTRAINT IF EXISTS lien_dossier_instruction_type_categorie_tiers_dit_fkey,
   DROP CONSTRAINT IF EXISTS lien_dossier_instruction_type_categorie_tiers_ctc_fkey,
   DROP CONSTRAINT IF EXISTS lien_dossier_instruction_type_catégorie_tiers_unique;
ALTER TABLE ONLY lien_dossier_instruction_type_categorie_tiers
   ADD CONSTRAINT lien_dossier_instruction_type_categorie_tiers_dit_fkey FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type),
   ADD CONSTRAINT lien_dossier_instruction_type_categorie_tiers_ctc_fkey FOREIGN KEY (categorie_tiers) REFERENCES categorie_tiers_consulte(categorie_tiers_consulte),
   ADD CONSTRAINT lien_dossier_instruction_type_catégorie_tiers_unique UNIQUE (dossier_instruction_type, categorie_tiers);


-- Création de la table lien_dossier_tiers
CREATE TABLE IF NOT EXISTS lien_dossier_tiers (
    lien_dossier_tiers INTEGER NOT NULL,
    dossier CHARACTER VARYING(255) NOT NULL,
    tiers INTEGER NOT NULL,
    CONSTRAINT lien_dossier_tiers_pkey PRIMARY KEY (lien_dossier_tiers)
);

COMMENT ON TABLE lien_dossier_tiers IS 'Acteur du dossier.';
COMMENT ON COLUMN lien_dossier_tiers.lien_dossier_tiers IS 'Identifiant unique';
COMMENT ON COLUMN lien_dossier_tiers.dossier IS 'Identifiant du dossier';
COMMENT ON COLUMN lien_dossier_tiers.tiers IS 'Identifiant du tiers';

-- Séquence de la table lien_dossier_tiers
CREATE SEQUENCE IF NOT EXISTS lien_dossier_tiers_seq
   START WITH 1
   INCREMENT BY 1
   NO MINVALUE
   NO MAXVALUE
   CACHE 1;

-- Contraintes de la table lien_dossier_tiers
ALTER TABLE ONLY lien_dossier_tiers
   DROP CONSTRAINT IF EXISTS lien_dossier_tiers_dossier_fkey,
   DROP CONSTRAINT IF EXISTS lien_dossier_tiers_tiers_fkey,
   DROP CONSTRAINT IF EXISTS lien_dossier_tiers_unique;
ALTER TABLE ONLY lien_dossier_tiers
   ADD CONSTRAINT lien_dossier_tiers_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier),
   ADD CONSTRAINT lien_dossier_tiers_tiers_fkey FOREIGN KEY (tiers) REFERENCES tiers_consulte(tiers_consulte),
   ADD CONSTRAINT lien_dossier_tiers_unique UNIQUE (dossier, tiers);

-- Permission sur l'onglet acteur
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lien_dossier_tiers', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_tiers' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#10090] - Notification automatique des tiers - gestion des acteurs des dossiers d'instruction
--

--
-- BEGIN / [#10050] Mise à jour des données techniques et CERFA
--

-- Champs supprimés
COMMENT ON COLUMN donnees_techniques.co_fin_autr_nb IS 'Répartition du nombre total de logement créés par type de financement : Autres financements [SUPPRIMÉ]';

-- Ajout données techniques et cerfa
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS c2zp1_crete numeric;
COMMENT ON COLUMN donnees_techniques.c2zp1_crete IS '[Si votre projet est un ouvrage de production d''électricité à partir de l''énergie solaire installé sur le sol] Indiquez sa puissance crête';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS c2zr1_destination character varying(70);
COMMENT ON COLUMN donnees_techniques.c2zr1_destination IS '[Si votre projet est un ouvrage de production d''électricité à partir de l''énergie solaire installé sur le sol] Indiquez la destination principale de l''énergie solaire';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS c2zp1_crete boolean DEFAULT false;
COMMENT ON COLUMN cerfa.c2zp1_crete IS '[Si votre projet est un ouvrage de production d''électricité à partir de l''énergie solaire installé sur le sol] Indiquez sa puissance crête';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS c2zr1_destination boolean DEFAULT false;
COMMENT ON COLUMN cerfa.c2zr1_destination IS '[Si votre projet est un ouvrage de production d''électricité à partir de l''énergie solaire installé sur le sol] Indiquez la destination principale de l''énergie solaire';

-- Modification du typages des champs d'effectif
ALTER TABLE donnees_techniques ALTER COLUMN erp_loc_eff1 TYPE character varying(250) USING erp_loc_eff1::character varying(250);
ALTER TABLE donnees_techniques ALTER COLUMN erp_loc_eff2 TYPE character varying(250) USING erp_loc_eff2::character varying(250);
ALTER TABLE donnees_techniques ALTER COLUMN erp_loc_eff3 TYPE character varying(250) USING erp_loc_eff3::character varying(250);
ALTER TABLE donnees_techniques ALTER COLUMN erp_loc_eff4 TYPE character varying(250) USING erp_loc_eff4::character varying(250);
ALTER TABLE donnees_techniques ALTER COLUMN erp_loc_eff5 TYPE character varying(250) USING erp_loc_eff5::character varying(250);
ALTER TABLE donnees_techniques ALTER COLUMN erp_loc_eff_tot TYPE character varying(250) USING erp_loc_eff_tot::character varying(250);

-- Mise à jour de la requête d'instruction
\i v5.16.0-om_requete.sql

--
-- END / [#10050] Mise à jour des données techniques et CERFA
--

--
-- BEGIN / [#10109] - Support des PeCs avec document
--

ALTER TABLE consultation ADD COLUMN IF NOT EXISTS fichier_pec character varying(250);
COMMENT ON COLUMN consultation.fichier_pec IS 'Permet de stocker le fichier de la pec';

--
-- END / [#10109] - Support des PeCs avec document 
--
