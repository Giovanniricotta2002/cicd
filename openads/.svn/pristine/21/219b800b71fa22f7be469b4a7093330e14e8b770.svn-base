-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.0.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.0.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- START / TI#645 — Dossiers liés : bootstrap
--
-- Existant
COMMENT ON COLUMN demandeur.type_demandeur IS 'Type de demandeur : avocat / contrevenant / delegataire / petitionnaire / plaignant / requerant';

-- Ensemble statique des valeurs possibles pour la colonne lien_dossier_dossier.type_lien
CREATE TYPE lien_dossier_dossier_type_lien AS ENUM ('manuel', 'auto_recours');

-- Table
CREATE TABLE lien_dossier_dossier (
    lien_dossier_dossier integer NOT NULL,
    dossier_src character varying(30) NOT NULL,
    dossier_cible character varying(30) NOT NULL,
    type_lien lien_dossier_dossier_type_lien NOT NULL
);
-- Séquence
CREATE SEQUENCE lien_dossier_dossier_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER SEQUENCE lien_dossier_dossier_seq
  OWNED BY lien_dossier_dossier.lien_dossier_dossier;
-- Contraintes
ALTER TABLE ONLY lien_dossier_dossier
    ADD CONSTRAINT lien_dossier_dossier_pkey PRIMARY KEY (lien_dossier_dossier);
ALTER TABLE ONLY lien_dossier_dossier
    ADD CONSTRAINT lien_dossier_dossier_dossier_autorisation_dossier_src_fk FOREIGN KEY (dossier_src) REFERENCES dossier(dossier);
ALTER TABLE ONLY lien_dossier_dossier
    ADD CONSTRAINT lien_dossier_dossier_dossier_cible_fk FOREIGN KEY (dossier_cible) REFERENCES dossier(dossier);
ALTER TABLE ONLY lien_dossier_dossier
    ADD CONSTRAINT lien_dossier_dossier_dossier_src_dossier_cible_key UNIQUE (dossier_src, dossier_cible);
-- Commentaires
COMMENT ON TABLE lien_dossier_dossier IS 'Table de liaison entre les dossiers d''instruction';
COMMENT ON COLUMN lien_dossier_dossier.lien_dossier_dossier IS 'Identifiant unique';
COMMENT ON COLUMN lien_dossier_dossier.dossier_src IS 'Dossier d''instruction source de la liaison, c''est sur celui-ci que les dossiers d''instruction cibles seront affichés';
COMMENT ON COLUMN lien_dossier_dossier.dossier_cible IS 'Dossier d''instruction cible de la liaison, les dossiers d''instruction cibles n''ont pas les DI source sur leur tableau de laison';
COMMENT ON COLUMN lien_dossier_dossier.type_lien IS 'Statique : manuel / auto_recours';

--
-- END / TI#645 — Dossiers liés : bootstrap
--

--
-- START / #647 — Dossiers liés : interfaces 
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
    );

-- Ajouts des droits de consultation de l'onglet des dossiers liés
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

UPDATE om_droit
SET libelle = 'dossier_lies_tab'
WHERE libelle = 'dossier_instruction_display_da_di_tab';

UPDATE om_droit
SET libelle = 'dossier_lies'
WHERE libelle = 'dossier_instruction_display_da_di';

UPDATE om_droit
SET libelle = 'dossier_lies_geographiquement'
WHERE libelle = 'dossier_autorisation_display_da_di';

UPDATE om_droit
SET libelle = 'dossier_lies_geographiquement_tab'
WHERE libelle = 'dossier_autorisation_display_da_di_tab';


--
-- END / #647 — Dossiers liés : interfaces 
--

--
-- START - Modifications de la structure
--

-- Ajout des champs pour RE
ALTER TABLE dossier
ADD autorisation_contestee character varying(30) NULL,
ADD date_cloture_instruction date NULL;
COMMENT ON COLUMN dossier.autorisation_contestee IS 'Le numéro de l''autorisation contestée (DI)';
COMMENT ON COLUMN dossier.date_cloture_instruction IS 'Date de fin d''instruction du dossier recours';

ALTER TABLE dossier ADD CONSTRAINT dossier_autorisation_contestee_fkey
FOREIGN KEY ("autorisation_contestee") REFERENCES dossier (dossier);

ALTER TABLE demande
ADD autorisation_contestee character varying(30) NULL;
COMMENT ON COLUMN demande.autorisation_contestee IS 'Le numéro de l''autorisation contestée (DI)';

ALTER TABLE demande ADD CONSTRAINT demande_autorisation_contestee_fkey
FOREIGN KEY (autorisation_contestee) REFERENCES dossier (dossier);

-- Ajout des champs pour IN
ALTER TABLE dossier
ADD date_premiere_visite date NULL,
ADD date_derniere_visite date NULL,
ADD date_contradictoire date NULL,
ADD date_retour_contradictoire date NULL,
ADD date_ait date NULL,
ADD date_transmission_parquet date NULL,
ADD instructeur_2 integer NULL;

COMMENT ON COLUMN dossier.date_premiere_visite IS 'Date du premier PV, mise à jour par l''instruction';
COMMENT ON COLUMN dossier.date_derniere_visite IS 'Date du dernier PV, mise à jour par l''instruction';
COMMENT ON COLUMN dossier.date_contradictoire IS 'Date alimentée par l''instruction';
COMMENT ON COLUMN dossier.date_retour_contradictoire IS 'Date alimentée par l''instruction';
COMMENT ON COLUMN dossier.date_ait IS 'Date alimentée par l''instruction';
COMMENT ON COLUMN dossier.date_transmission_parquet IS 'Date alimentée par l''instruction';
COMMENT ON COLUMN dossier.instructeur IS 'Premier instructeur en charge du dossier d''instruction';
COMMENT ON COLUMN dossier.instructeur_2 IS 'Second instructeur en charge du dossier d''instruction';

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_instructeur_2_fkey FOREIGN KEY (instructeur_2) REFERENCES instructeur(instructeur);

-- Ajout de la table objet_recours
CREATE TABLE objet_recours (
  "objet_recours" integer NOT NULL,
  "code" character varying(10) NOT NULL,
  "libelle" character varying(255) NOT NULL,
  "description" text NULL,
  "om_validite_debut" date NULL,
  "om_validite_fin" date NULL
);

CREATE SEQUENCE objet_recours_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY objet_recours ADD CONSTRAINT objet_recours_pkey PRIMARY KEY (objet_recours);
COMMENT ON TABLE objet_recours IS 'Objet du recours';
COMMENT ON COLUMN "objet_recours"."objet_recours" IS 'Identifiant unique';
COMMENT ON COLUMN "objet_recours"."code" IS 'Code';
COMMENT ON COLUMN "objet_recours"."libelle" IS 'Libelle';
COMMENT ON COLUMN "objet_recours"."description" IS 'Description';
COMMENT ON COLUMN "objet_recours"."om_validite_debut" IS 'Date de début de validité';
COMMENT ON COLUMN "objet_recours"."om_validite_fin" IS 'Date de fin de validité';

-- Ajout de la table moyen_souleve
CREATE TABLE moyen_souleve (
  "moyen_souleve" integer NOT NULL,
  "code" character varying(10) NOT NULL,
  "libelle" character varying(255) NOT NULL,
  "description" text NULL,
  "om_validite_debut" date NULL,
  "om_validite_fin" date NULL
);

CREATE SEQUENCE moyen_souleve_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY moyen_souleve ADD CONSTRAINT moyen_souleve_pkey PRIMARY KEY (moyen_souleve);
COMMENT ON TABLE moyen_souleve IS 'Moyens soulevés';
COMMENT ON COLUMN "moyen_souleve"."moyen_souleve" IS 'Identifiant unique';
COMMENT ON COLUMN "moyen_souleve"."code" IS 'Code';
COMMENT ON COLUMN "moyen_souleve"."libelle" IS 'Libelle';
COMMENT ON COLUMN "moyen_souleve"."description" IS 'Description';
COMMENT ON COLUMN "moyen_souleve"."om_validite_debut" IS 'Date de début de validité';
COMMENT ON COLUMN "moyen_souleve"."om_validite_fin" IS 'Date de fin de validité';

-- Ajout de la table moyen_retenu_juge
CREATE TABLE moyen_retenu_juge (
  "moyen_retenu_juge" integer NOT NULL,
  "code" character varying(10) NOT NULL,
  "libelle" character varying(255) NOT NULL,
  "description" text NULL,
  "om_validite_debut" date NULL,
  "om_validite_fin" date NULL
);

CREATE SEQUENCE moyen_retenu_juge_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY moyen_retenu_juge ADD CONSTRAINT moyen_retenu_juge_pkey PRIMARY KEY (moyen_retenu_juge);
COMMENT ON TABLE moyen_retenu_juge IS 'Moyens retenus par le juge';
COMMENT ON COLUMN "moyen_retenu_juge"."moyen_retenu_juge" IS 'Identifiant unique';
COMMENT ON COLUMN "moyen_retenu_juge"."code" IS 'Code';
COMMENT ON COLUMN "moyen_retenu_juge"."libelle" IS 'Libelle';
COMMENT ON COLUMN "moyen_retenu_juge"."description" IS 'Description';
COMMENT ON COLUMN "moyen_retenu_juge"."om_validite_debut" IS 'Date de début de validité';
COMMENT ON COLUMN "moyen_retenu_juge"."om_validite_fin" IS 'Date de fin de validité';

-- Ajout de la table instructeur_qualite
CREATE TABLE instructeur_qualite (
  "instructeur_qualite" integer NOT NULL,
  "code" character varying(10) NOT NULL,
  "libelle" character varying(255) NOT NULL,
  "description" text NULL
);

CREATE SEQUENCE instructeur_qualite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY instructeur_qualite ADD CONSTRAINT instructeur_qualite_pkey PRIMARY KEY (instructeur_qualite);
COMMENT ON TABLE instructeur_qualite IS 'Qualités de l''instructeur';
COMMENT ON COLUMN "instructeur_qualite"."instructeur_qualite" IS 'Identifiant unique';
COMMENT ON COLUMN "instructeur_qualite"."code" IS 'Code';
COMMENT ON COLUMN "instructeur_qualite"."libelle" IS 'Libelle';
COMMENT ON COLUMN "instructeur_qualite"."description" IS 'Description';

INSERT INTO instructeur_qualite (instructeur_qualite, code, libelle) VALUES (nextval('instructeur_qualite_seq'), 'instr', 'instructeur');
INSERT INTO instructeur_qualite (instructeur_qualite, code, libelle) VALUES (nextval('instructeur_qualite_seq'), 'juri', 'juriste');
INSERT INTO instructeur_qualite (instructeur_qualite, code, libelle) VALUES (nextval('instructeur_qualite_seq'), 'tech', 'technicien');

-- Ajout du champs instructeur_qualite table instructeur
ALTER TABLE instructeur
ADD instructeur_qualite integer;
COMMENT ON COLUMN instructeur.instructeur_qualite IS 'Qualité de l''instructeur';

UPDATE instructeur
SET instructeur_qualite = (SELECT instructeur_qualite FROM instructeur_qualite WHERE code='instr');

ALTER TABLE ONLY instructeur
    ADD CONSTRAINT instructeur_instructeur_qualite_fkey FOREIGN KEY (instructeur_qualite) REFERENCES instructeur_qualite(instructeur_qualite);

ALTER TABLE instructeur ALTER COLUMN instructeur_qualite SET NOT NULL;

-- Ajout des champs pour les cerfa
ALTER TABLE donnees_techniques
ADD ctx_objet_recours integer NULL,
-- ADD ctx_moyen_souleve integer NULL,
-- ADD ctx_moyen_retenu_juge integer NULL,
ADD ctx_reference_sagace character varying(255) NULL,
ADD ctx_nature_travaux_infra_om_html text NULL,
ADD ctx_synthese_nti text NULL,
ADD ctx_article_non_resp_om_html text NULL,
ADD ctx_synthese_anr text NULL,
ADD ctx_reference_parquet character varying(255) NULL,
ADD ctx_element_taxation character varying(255) NULL,
ADD ctx_infraction boolean NULL,
ADD ctx_regularisable boolean NULL,
ADD ctx_reference_courrier character varying(255) NULL,
ADD ctx_date_audience date NULL,
ADD ctx_date_ajournement date NULL;
-- Commentaires
COMMENT ON COLUMN donnees_techniques.ctx_objet_recours IS 'Objet du recours';
-- COMMENT ON COLUMN donnees_techniques.ctx_moyen_souleve IS 'Moyens soulevés';
-- COMMENT ON COLUMN donnees_techniques.ctx_moyen_retenu_juge IS 'Moyens retenus par le juge';
COMMENT ON COLUMN donnees_techniques.ctx_reference_sagace IS 'Références sagaces';
COMMENT ON COLUMN donnees_techniques.ctx_nature_travaux_infra_om_html IS 'Nature des travaux en infraction (NTI)';
COMMENT ON COLUMN donnees_techniques.ctx_synthese_nti IS 'Synthèse des NTI';
COMMENT ON COLUMN donnees_techniques.ctx_article_non_resp_om_html IS 'Article(s) non respecté(s) (ANR)';
COMMENT ON COLUMN donnees_techniques.ctx_synthese_anr IS 'Synthèse (ANR)';
COMMENT ON COLUMN donnees_techniques.ctx_reference_parquet IS 'Références Parquet';
COMMENT ON COLUMN donnees_techniques.ctx_element_taxation IS 'Éléments de taxation';
COMMENT ON COLUMN donnees_techniques.ctx_infraction IS 'Infraction';
COMMENT ON COLUMN donnees_techniques.ctx_regularisable IS 'Régularisable';
COMMENT ON COLUMN donnees_techniques.ctx_reference_courrier IS 'Référence(s) courrier';
COMMENT ON COLUMN donnees_techniques.ctx_date_audience IS 'Date d''audience';
COMMENT ON COLUMN donnees_techniques.ctx_date_ajournement IS 'Date d''ajournement';

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT donnees_techniques_ctx_objet_recours_fkey FOREIGN KEY (ctx_objet_recours) REFERENCES objet_recours(objet_recours);

ALTER TABLE cerfa
ADD ctx_objet_recours boolean NULL,
ADD ctx_moyen_souleve boolean NULL,
ADD ctx_moyen_retenu_juge boolean NULL,
ADD ctx_reference_sagace boolean NULL,
ADD ctx_nature_travaux_infra_om_html boolean NULL,
ADD ctx_synthese_nti boolean NULL,
ADD ctx_article_non_resp_om_html boolean NULL,
ADD ctx_synthese_anr boolean NULL,
ADD ctx_reference_parquet boolean NULL,
ADD ctx_element_taxation boolean NULL,
ADD ctx_infraction boolean NULL,
ADD ctx_regularisable boolean NULL,
ADD ctx_reference_courrier boolean NULL,
ADD ctx_date_audience boolean NULL,
ADD ctx_date_ajournement boolean NULL;
-- Commentaires
COMMENT ON COLUMN cerfa.ctx_objet_recours IS 'Objet du recours';
COMMENT ON COLUMN cerfa.ctx_moyen_souleve IS 'Moyens soulevés';
COMMENT ON COLUMN cerfa.ctx_moyen_retenu_juge IS 'Moyens retenus par le juge';
COMMENT ON COLUMN cerfa.ctx_reference_sagace IS 'Références sagaces';
COMMENT ON COLUMN cerfa.ctx_nature_travaux_infra_om_html IS 'Nature des travaux en infraction (NTI)';
COMMENT ON COLUMN cerfa.ctx_synthese_nti IS 'Synthèse des NTI';
COMMENT ON COLUMN cerfa.ctx_article_non_resp_om_html IS 'Article(s) non respecté(s) (ANR)';
COMMENT ON COLUMN cerfa.ctx_synthese_anr IS 'Synthèse (ANR)';
COMMENT ON COLUMN cerfa.ctx_reference_parquet IS 'Références Parquet';
COMMENT ON COLUMN cerfa.ctx_element_taxation IS 'Éléments de taxation';
COMMENT ON COLUMN cerfa.ctx_infraction IS 'Infraction';
COMMENT ON COLUMN cerfa.ctx_regularisable IS 'Régularisable';
COMMENT ON COLUMN cerfa.ctx_reference_courrier IS 'Référence(s) courrier';
COMMENT ON COLUMN cerfa.ctx_date_audience IS 'Date d''audience';
COMMENT ON COLUMN cerfa.ctx_date_ajournement IS 'Date d''ajournement';

-- Ajout de la table de liaison pour les moyens soulevés
-- Table
CREATE TABLE lien_donnees_techniques_moyen_souleve (
    lien_donnees_techniques_moyen_souleve integer NOT NULL,
    donnees_techniques integer NOT NULL,
    moyen_souleve integer NOT NULL
);
-- Commentaires
COMMENT ON TABLE lien_donnees_techniques_moyen_souleve IS 'Table de liaison entre les données techniques et les moyens soulevés';
COMMENT ON COLUMN lien_donnees_techniques_moyen_souleve.lien_donnees_techniques_moyen_souleve IS 'Identifiant unique';
COMMENT ON COLUMN lien_donnees_techniques_moyen_souleve.donnees_techniques IS 'Identifiant des données techniques';
COMMENT ON COLUMN lien_donnees_techniques_moyen_souleve.moyen_souleve IS 'Indentifiant du moyen soulevé';
-- Séquence
CREATE SEQUENCE lien_donnees_techniques_moyen_souleve_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
-- Contraintes
ALTER TABLE ONLY lien_donnees_techniques_moyen_souleve ADD CONSTRAINT
    lien_donnees_techniques_moyen_souleve_pkey PRIMARY KEY (lien_donnees_techniques_moyen_souleve);
ALTER TABLE ONLY lien_donnees_techniques_moyen_souleve
    ADD CONSTRAINT lien_donnees_techniques_moyen_souleve_donnees_techniques_fkey FOREIGN KEY (donnees_techniques) REFERENCES donnees_techniques(donnees_techniques);
ALTER TABLE ONLY lien_donnees_techniques_moyen_souleve
    ADD CONSTRAINT lien_donnees_techniques_moyen_souleve_moyen_souleve_fkey FOREIGN KEY (moyen_souleve) REFERENCES moyen_souleve(moyen_souleve);

-- Ajout de la table de liaison pour les moyens retenus par le juge
-- Table
CREATE TABLE lien_donnees_techniques_moyen_retenu_juge (
    lien_donnees_techniques_moyen_retenu_juge integer NOT NULL,
    donnees_techniques integer NOT NULL,
    moyen_retenu_juge integer NOT NULL
);
-- Commentaires
COMMENT ON TABLE lien_donnees_techniques_moyen_retenu_juge IS 'Table de liaison entre les données techniques et les moyens retenus par le juge';
COMMENT ON COLUMN lien_donnees_techniques_moyen_retenu_juge.lien_donnees_techniques_moyen_retenu_juge IS 'Identifiant unique';
COMMENT ON COLUMN lien_donnees_techniques_moyen_retenu_juge.donnees_techniques IS 'Identifiant des données techniques';
COMMENT ON COLUMN lien_donnees_techniques_moyen_retenu_juge.moyen_retenu_juge IS 'Indentifiant du moyen retenu par le juge';
-- Séquence
CREATE SEQUENCE lien_donnees_techniques_moyen_retenu_juge_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
-- Contraintes
ALTER TABLE ONLY lien_donnees_techniques_moyen_retenu_juge ADD CONSTRAINT lien_donnees_techniques_moyen_retenu_juge_pkey PRIMARY KEY (lien_donnees_techniques_moyen_retenu_juge);
ALTER TABLE ONLY lien_donnees_techniques_moyen_retenu_juge
    ADD CONSTRAINT lien_donnees_techniques_moyen_retenu_juge_donnees_techniques_fkey FOREIGN KEY (donnees_techniques) REFERENCES donnees_techniques(donnees_techniques);
ALTER TABLE ONLY lien_donnees_techniques_moyen_retenu_juge
    ADD CONSTRAINT lien_donnees_techniques_moyen_retenu_juge_moyen_retenu_juge_fkey FOREIGN KEY (moyen_retenu_juge) REFERENCES moyen_retenu_juge(moyen_retenu_juge);

-- Lien entre les profils/utilisateurs et les groupes
CREATE TABLE lien_om_profil_groupe (
lien_om_profil_groupe integer NOT NULL,
om_profil integer NOT NULL,
groupe integer NOT NULL,
confidentiel boolean DEFAULT FALSE,
enregistrement_demande boolean DEFAULT FALSE
);
CREATE SEQUENCE lien_om_profil_groupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY lien_om_profil_groupe
    ADD CONSTRAINT lien_om_profil_groupe_pkey PRIMARY KEY (lien_om_profil_groupe);

ALTER TABLE ONLY lien_om_profil_groupe
    ADD CONSTRAINT om_profil_groupe_key UNIQUE (om_profil, groupe);
COMMENT ON TABLE lien_om_profil_groupe IS 'Table de liaison entre les profils et les groupes';
COMMENT ON COLUMN "lien_om_profil_groupe"."lien_om_profil_groupe" IS 'Identifiant unique';
COMMENT ON COLUMN "lien_om_profil_groupe"."om_profil" IS 'Identifiant du profil';
COMMENT ON COLUMN "lien_om_profil_groupe"."groupe" IS 'Indentifiant du groupe';
COMMENT ON COLUMN "lien_om_profil_groupe"."confidentiel" IS 'Visualisation des dossiers du groupe';
COMMENT ON COLUMN "lien_om_profil_groupe"."enregistrement_demande" IS 'Ajout ou non de dossier pour ce groupe';

ALTER TABLE ONLY lien_om_profil_groupe
    ADD CONSTRAINT lien_om_profil_groupe_om_profil_fkey FOREIGN KEY (om_profil) REFERENCES om_profil(om_profil);
ALTER TABLE ONLY lien_om_profil_groupe
    ADD CONSTRAINT lien_om_profil_groupe_groupe_fkey FOREIGN KEY (groupe) REFERENCES groupe(groupe);

CREATE TABLE lien_om_utilisateur_groupe (
lien_om_utilisateur_groupe integer NOT NULL,
login character varying(30) NOT NULL,
groupe integer NOT NULL,
confidentiel boolean DEFAULT FALSE,
enregistrement_demande boolean DEFAULT FALSE
);
CREATE SEQUENCE lien_om_utilisateur_groupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY lien_om_utilisateur_groupe ADD CONSTRAINT lien_om_utilisateur_groupe_pkey PRIMARY KEY (lien_om_utilisateur_groupe);
COMMENT ON TABLE lien_om_utilisateur_groupe IS 'Table de liaison entre les utilisateurs et les groupes';
COMMENT ON COLUMN "lien_om_utilisateur_groupe"."lien_om_utilisateur_groupe" IS 'Identifiant unique';
COMMENT ON COLUMN "lien_om_utilisateur_groupe"."login" IS 'Identifiant de l''utilisateur';
COMMENT ON COLUMN "lien_om_utilisateur_groupe"."groupe" IS 'Indentifiant du groupe';
COMMENT ON COLUMN "lien_om_utilisateur_groupe"."confidentiel" IS 'Visualisation des dossiers du groupe';
COMMENT ON COLUMN "lien_om_utilisateur_groupe"."enregistrement_demande" IS 'Ajout ou non de dossier pour ce groupe';

ALTER TABLE ONLY lien_om_utilisateur_groupe
    ADD CONSTRAINT lien_om_utilisateur_groupe_groupe_fkey FOREIGN KEY (groupe) REFERENCES groupe(groupe);

-- Ajout des champs archive dans la table *instruction*
ALTER TABLE instruction ADD COLUMN archive_date_cloture_instruction date NULL;
ALTER TABLE instruction ADD COLUMN archive_date_premiere_visite date NULL;
ALTER TABLE instruction ADD COLUMN archive_date_derniere_visite date NULL;
ALTER TABLE instruction ADD COLUMN archive_date_contradictoire date NULL;
ALTER TABLE instruction ADD COLUMN archive_date_retour_contradictoire date NULL;
ALTER TABLE instruction ADD COLUMN archive_date_ait date NULL;
ALTER TABLE instruction ADD COLUMN archive_date_transmission_parquet date NULL;
--
COMMENT ON COLUMN instruction.archive_date_cloture_instruction IS 'Valeur du champ date_cloture_instruction du dossier d''instruction avant ajout de l''événement d''instruction';
COMMENT ON COLUMN instruction.archive_date_premiere_visite IS 'Valeur du champ date_premiere_visite du dossier d''instruction avant ajout de l''événement d''instruction';
COMMENT ON COLUMN instruction.archive_date_derniere_visite IS 'Valeur du champ date_derniere_visite du dossier d''instruction avant ajout de l''événement d''instruction';
COMMENT ON COLUMN instruction.archive_date_contradictoire IS 'Valeur du champ date_contradictoire du dossier d''instruction avant ajout de l''événement d''instruction';
COMMENT ON COLUMN instruction.archive_date_retour_contradictoire IS 'Valeur du champ date_retour_contradictoire du dossier d''instruction avant ajout de l''événement d''instruction';
COMMENT ON COLUMN instruction.archive_date_ait IS 'Valeur du champ date_ait du dossier d''instruction avant ajout de l''événement d''instruction';
COMMENT ON COLUMN instruction.archive_date_transmission_parquet IS 'Valeur du champ date_transmission_parquet du dossier d''instruction avant ajout de l''événement d''instruction';

-- Ajout des champs règle dans la table *action*
ALTER TABLE action ADD COLUMN regle_date_cloture_instruction character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_date_premiere_visite character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_date_derniere_visite character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_date_contradictoire character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_date_retour_contradictoire character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_date_ait character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_date_transmission_parquet character varying(60) NULL;
--
COMMENT ON COLUMN action.regle_date_cloture_instruction IS 'Règle de calcul de la date de cloture de l''instruction des dossiers d''instruction';
COMMENT ON COLUMN action.regle_date_premiere_visite IS 'Règle de calcul de la date de première visite des dossiers d''instruction';
COMMENT ON COLUMN action.regle_date_derniere_visite IS 'Règle de calcul de la date de dernière visite des dossiers d''instruction';
COMMENT ON COLUMN action.regle_date_contradictoire IS 'Règle de calcul de la date de contradictoire des dossiers d''instruction';
COMMENT ON COLUMN action.regle_date_retour_contradictoire IS 'Règle de calcul de la date de retour de contradictoire des dossiers d''instruction';
COMMENT ON COLUMN action.regle_date_ait IS 'Règle de calcul de la date d''AIT des dossiers d''instruction';
COMMENT ON COLUMN action.regle_date_transmission_parquet IS 'Règle de calcul de la date de transmission au parquet des dossiers d''instruction';

-- Ajout des champs règle dans la table *action*
ALTER TABLE action ADD COLUMN regle_donnees_techniques1 character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_donnees_techniques2 character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_donnees_techniques3 character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_donnees_techniques4 character varying(60) NULL;
ALTER TABLE action ADD COLUMN regle_donnees_techniques5 character varying(60) NULL;
--
COMMENT ON COLUMN action.regle_donnees_techniques1 IS 'Règle de calcul d''un champ des données techniques';
COMMENT ON COLUMN action.regle_donnees_techniques2 IS 'Règle de calcul d''un champ des données techniques';
COMMENT ON COLUMN action.regle_donnees_techniques3 IS 'Règle de calcul d''un champ des données techniques';
COMMENT ON COLUMN action.regle_donnees_techniques4 IS 'Règle de calcul d''un champ des données techniques';
COMMENT ON COLUMN action.regle_donnees_techniques5 IS 'Règle de calcul d''un champ des données techniques';

-- XXX Ajouter les champs select vers données techniques
ALTER TABLE action ADD COLUMN cible_regle_donnees_techniques1 character varying(250) NULL;
ALTER TABLE action ADD COLUMN cible_regle_donnees_techniques2 character varying(250) NULL;
ALTER TABLE action ADD COLUMN cible_regle_donnees_techniques3 character varying(250) NULL;
ALTER TABLE action ADD COLUMN cible_regle_donnees_techniques4 character varying(250) NULL;
ALTER TABLE action ADD COLUMN cible_regle_donnees_techniques5 character varying(250) NULL;
--
COMMENT ON COLUMN action.cible_regle_donnees_techniques1 IS 'Champ des données techniques ciblé par la règle 1';
COMMENT ON COLUMN action.cible_regle_donnees_techniques2 IS 'Champ des données techniques ciblé par la règle 2';
COMMENT ON COLUMN action.cible_regle_donnees_techniques3 IS 'Champ des données techniques ciblé par la règle 3';
COMMENT ON COLUMN action.cible_regle_donnees_techniques4 IS 'Champ des données techniques ciblé par la règle 4';
COMMENT ON COLUMN action.cible_regle_donnees_techniques5 IS 'Champ des données techniques ciblé par la règle 5';

-- Ajout du groupe sur le type de DA
ALTER TABLE dossier_autorisation_type
ADD affichage_form character varying(250);
UPDATE dossier_autorisation_type SET affichage_form = 'ADS';
ALTER TABLE dossier_autorisation_type ALTER COLUMN affichage_form SET NOT NULL;
COMMENT ON COLUMN "dossier_autorisation_type"."affichage_form" IS 'Type d''affichage du formulaire du dossier (DI et/ou DA)';

-- Ajout du champ permettant de ne pas afficher un DA dans l'application
ALTER TABLE dossier_autorisation_type ADD COLUMN cacher_da boolean DEFAULT FALSE;
COMMENT ON COLUMN dossier_autorisation_type.cacher_da IS 'Si positionné à oui, alors les DA de ce type ne seront pas visibles';

-- Ajout de la table de liaison d'ajout de pièce par qualité d'instructeur
-- Table
CREATE TABLE lien_document_numerise_type_instructeur_qualite (
    lien_document_numerise_type_instructeur_qualite integer NOT NULL,
    document_numerise_type integer NOT NULL,
    instructeur_qualite integer NOT NULL
);
-- Commentaires
COMMENT ON TABLE lien_document_numerise_type_instructeur_qualite IS 'Table de liaison entre les types de pièce et les qualités d''instructeur';
COMMENT ON COLUMN lien_document_numerise_type_instructeur_qualite.lien_document_numerise_type_instructeur_qualite IS 'Identifiant unique';
COMMENT ON COLUMN lien_document_numerise_type_instructeur_qualite.document_numerise_type IS 'Identifiant des types de pièce';
COMMENT ON COLUMN lien_document_numerise_type_instructeur_qualite.instructeur_qualite IS 'Indentifiant de la qualité des instructeurs';
-- Séquence
CREATE SEQUENCE lien_document_numerise_type_instructeur_qualite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
-- Contraintes
ALTER TABLE ONLY lien_document_numerise_type_instructeur_qualite ADD CONSTRAINT lien_document_numerise_type_instructeur_qualite_pkey PRIMARY KEY (lien_document_numerise_type_instructeur_qualite);
ALTER TABLE ONLY lien_document_numerise_type_instructeur_qualite
    ADD CONSTRAINT lien_document_numerise_type_instructeur_qualite_document_numerise_type_fkey FOREIGN KEY (document_numerise_type) REFERENCES document_numerise_type(document_numerise_type);
ALTER TABLE ONLY lien_document_numerise_type_instructeur_qualite
    ADD CONSTRAINT lien_document_numerise_type_instructeur_qualite_instructeur_qualite_fkey FOREIGN KEY (instructeur_qualite) REFERENCES instructeur_qualite(instructeur_qualite);

--
-- END - Modifications de la structure
--

--
-- START - Ajout des nouveaux profils
--

-- Assistante
INSERT INTO om_profil VALUES (nextval('om_profil_seq'), 'ASSISTANTE', 0, NULL, NULL);
INSERT INTO om_droit 
SELECT
    nextval('om_droit_seq'),
    om_droit.libelle,
    (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
FROM om_droit
JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
WHERE om_profil.libelle = 'INSTRUCTEUR SERVICE';

-- Chef de service Contentieux
INSERT INTO om_profil VALUES (nextval('om_profil_seq'), 'CHEF DE SERVICE CONTENTIEUX', 0, NULL, NULL);
INSERT INTO om_droit 
SELECT
    nextval('om_droit_seq'),
    om_droit.libelle,
    (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
FROM om_droit
JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
WHERE om_profil.libelle = 'INSTRUCTEUR SERVICE';

-- Juriste
INSERT INTO om_profil VALUES (nextval('om_profil_seq'), 'JURISTE', 0, NULL, NULL);
INSERT INTO om_droit 
SELECT
    nextval('om_droit_seq'),
    om_droit.libelle,
    (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
FROM om_droit
JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
WHERE om_profil.libelle = 'INSTRUCTEUR SERVICE';

-- Technicien
INSERT INTO om_profil VALUES (nextval('om_profil_seq'), 'TECHNICIEN', 0, NULL, NULL);
INSERT INTO om_droit 
SELECT
    nextval('om_droit_seq'),
    om_droit.libelle,
    (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
FROM om_droit
JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
WHERE om_profil.libelle = 'INSTRUCTEUR SERVICE';

-- Responsable division infraction
INSERT INTO om_profil VALUES (nextval('om_profil_seq'), 'RESPONSABLE DIVISION INFRACTION', 0, NULL, NULL);
INSERT INTO om_droit 
SELECT
    nextval('om_droit_seq'),
    om_droit.libelle,
    (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
FROM om_droit
JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
WHERE om_profil.libelle = 'INSTRUCTEUR SERVICE';

-- Direction consultation
INSERT INTO om_profil VALUES (nextval('om_profil_seq'), 'DIRECTION CONSULTATION', 0, NULL, NULL);
INSERT INTO om_droit 
SELECT
    nextval('om_droit_seq'),
    om_droit.libelle,
    (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
FROM om_droit
JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
WHERE om_profil.libelle = 'VISUALISATION DA et DI';

-- Direction recours
INSERT INTO om_profil VALUES (nextval('om_profil_seq'), 'DIRECTION RECOURS', 0, NULL, NULL);
INSERT INTO om_droit 
SELECT
    nextval('om_droit_seq'),
    om_droit.libelle,
    (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
FROM om_droit
JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
WHERE om_profil.libelle = 'VISUALISATION DA et DI';

-- Direction infraction
INSERT INTO om_profil VALUES (nextval('om_profil_seq'), 'DIRECTION INFRACTION', 0, NULL, NULL);
INSERT INTO om_droit 
SELECT
    nextval('om_droit_seq'),
    om_droit.libelle,
    (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
FROM om_droit
JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
WHERE om_profil.libelle = 'VISUALISATION DA et DI';

--
-- END - Ajout des nouveaux profils
--

--
-- START - Ajout des liaisons
--

-- Ajout des groupes ADS, ERP et CTX aux profils ADS
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'), (SELECT groupe FROM groupe WHERE code = 'CTX'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE'), (SELECT groupe FROM groupe WHERE code = 'CTX'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);

-- Ajout de tous les groupes au profils contentieux
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, false
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);

-- Ajout des groupes aux profils administrateur
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL'), (SELECT groupe FROM groupe WHERE code = 'ADS'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL'), (SELECT groupe FROM groupe WHERE code = 'CTX'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CTX'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL'), (SELECT groupe FROM groupe WHERE code = 'CU'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL'), (SELECT groupe FROM groupe WHERE code = 'RU'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL'), (SELECT groupe FROM groupe WHERE code = 'ERP'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL'), (SELECT groupe FROM groupe WHERE code = 'ADS'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL'), (SELECT groupe FROM groupe WHERE code = 'CU'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL'), (SELECT groupe FROM groupe WHERE code = 'RU'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL'), (SELECT groupe FROM groupe WHERE code = 'ERP'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'), (SELECT groupe FROM groupe WHERE code = 'ADS'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'), (SELECT groupe FROM groupe WHERE code = 'CU'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'), (SELECT groupe FROM groupe WHERE code = 'RU'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'), (SELECT groupe FROM groupe WHERE code = 'ERP'), true, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);

--
-- END - Ajout des liaisons
--

-- Population de la table
INSERT INTO lien_document_numerise_type_instructeur_qualite
SELECT 
    nextval('lien_document_numerise_type_instructeur_qualite_seq'),
    document_numerise_type,
    (SELECT instructeur_qualite FROM instructeur_qualite WHERE code = 'instr')
FROM document_numerise_type
WHERE ajout_instructeur = true;

-- Suppression du champ ajout_instructeur de la table document_numerise_type
ALTER TABLE document_numerise_type DROP COLUMN ajout_instructeur;

--
-- START - Ajout des droits
--

-- Ajout des droits sur la catégorie Contentieux
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'dossier_contentieux_mes_infractions',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'dossier_contentieux_mes_recours',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');

-- Ajout des droits sur les tables de référence Contentieux
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'objet_recours',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'moyen_souleve',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'moyen_retenu_juge',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');

-- Ajout du droit sur la table de qualité des instructeurs
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'instructeur_qualite',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');

-- Ajout des droits pour les demandeurs
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'plaignant',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'contrevenant',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'requerant',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'avocat',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'lien_om_profil_groupe',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');
INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'lien_om_utilisateur_groupe',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');

INSERT INTO om_droit SELECT nextval('om_droit_seq'), 'lien_om_utilisateur_groupe',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL');

-- Modification des données techniques des lots
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lot_donnees_techniques_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_donnees_techniques_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lot_donnees_techniques_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lot_donnees_techniques_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lot_donnees_techniques_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_donnees_techniques_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lot_donnees_techniques_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lot_donnees_techniques_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

-- Retour d'avis de commission
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_commission_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_commission_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);
-- Modification du suivi des dates
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_modification_dates_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modification_dates_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);
-- Ajout de contrainte qualificateur
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);

-- Récupération de l'affichage formulaire depuis la demande
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_type_detaille_aff_form',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_type_detaille_aff_form' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

-- Ajout des droits de création de dossiers contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_nouveau_dossier_contentieux_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_nouveau_dossier_contentieux_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_nouveau_dossier_contentieux_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_nouveau_dossier_contentieux_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_nouveau_dossier_contentieux_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_nouveau_dossier_contentieux_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_nouveau_dossier_contentieux_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_nouveau_dossier_contentieux_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_nouveau_dossier_contentieux_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_nouveau_dossier_contentieux_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

-- Ajout du droit de récupération de l'adresse à partir des références cadastrales
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_recuperer_adresse',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_recuperer_adresse' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_recuperer_adresse',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_recuperer_adresse' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_recuperer_adresse',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_recuperer_adresse' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_recuperer_adresse',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_recuperer_adresse' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_recuperer_adresse',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_recuperer_adresse' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'plaignant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'plaignant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'plaignant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'plaignant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'plaignant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'plaignant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'plaignant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'plaignant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'avocat_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avocat_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'contrevenant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'contrevenant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'requerant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'requerant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'plaignant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'plaignant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'plaignant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'plaignant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'plaignant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'plaignant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'plaignant_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'plaignant_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

-- Ajout des droits d'accès au menu Contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);


-- Ajout des droits d'accès au dashboard Contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux_dashboard',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux_dashboard' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux_dashboard',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux_dashboard' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux_dashboard',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux_dashboard' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux_dashboard',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux_dashboard' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_contentieux_dashboard',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_contentieux_dashboard' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

-- Droits d'accès au listing "Mes recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

-- Droit de modification de l'instructeur de tout type de dossier
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_modifier_instructeur',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_modifier_instructeur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_modifier_instructeur',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_modifier_instructeur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_modifier_instructeur',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_modifier_instructeur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_modifier_instructeur',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_modifier_instructeur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_modifier_instructeur',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_modifier_instructeur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

-- Droits d'accès au listing "Tous les recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);

-- Droit d'accès au listing "Mes infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

-- Droit d'accès au listing "Toutes les infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

-- Droits de consultation des dossiers "Mes recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

-- Droits de consultation des dossiers "Tous les recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);

-- Droits de consultation des dossiers "Mes infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

-- Droits de consultation des dossiers "Toutes les infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);


-- Ajout du droit de consultation des données techniques pour les dossiers "Mes Recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

-- Ajout du droit de consultation des données techniques pour les dossiers "Tous les Recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

-- Ajout du droit de consultation des données techniques pour les dossiers "Mes Infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

-- Ajout du droit de consultation des données techniques pour les dossiers "Toutes les infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

-- Ajout du droit de modification du DI pour les dossiers "Mes Recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

-- Ajout du droit de modification du DI pour les dossiers "Tous les Recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);


INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Ajout du droit de modification du DI pour les dossiers "Mes Infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

-- Ajout du droit de modification du DI pour les dossiers "Toutes les infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Ajout du droit de géolocalisation des dossiers "Mes Recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

-- Ajout du droit de géolocalisation des dossiers "Tous les Recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

-- Ajout du droit de géolocalisation des dossiers "Mes Infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

-- Ajout du droit de géolocalisation des dossiers "Toutes les infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

-- Ajout du droit de redirection vers le SIG pour les dossiers "Mes Recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentilocaliser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

-- Ajout du droit de redirection vers le SIG pour les dossiers "Tous les Recours"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

-- Ajout du droit de redirection vers le SIG pour les dossiers "Mes Infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

-- Ajout du droit de redirection vers le SIG pour les dossiers "Toutes les infractions"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_localiser-sig-externe',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

-- Ajout du droit de consultation des demandeurs pour les dossiers contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_recours_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_recours_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_infractions_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_infractions_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_recours_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_recours_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_infractions_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_infractions_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_recours_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_recours_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_infractions_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_infractions_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_recours_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_recours_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_infractions_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_infractions_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_recours_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_recours_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_infractions_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_infractions_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_recours_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_recours_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_infractions_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_infractions_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_recours_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_recours_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_infractions_afficher_demandeurs',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_infractions_afficher_demandeurs' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);


-- Ajout des droits d'accès à l'onglet Contraintes contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contrainte_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

-- Ajout des droits d'accès à l'onglet Instruction contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_definaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_finaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_modification_dates_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_modification_dates_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_definaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_finaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_modification_dates_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_modification_dates_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_definaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_finaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_modification_dates_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_modification_dates_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_definaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_finaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_modification_dates_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_modification_dates_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_definaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_finaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_modification_dates_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_modification_dates_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_definaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_finaliser_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_modification_dates_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_modification_dates_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_inf_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_inf_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'instruction_contexte_ctx_re_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_contexte_ctx_re_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

-- Ajout de l'accès à l'onglet Messages dans le contexte d'un dossier contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_modifier_lu',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_modifier_lu' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_modifier_lu_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_modifier_lu_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_modifier_lu',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_modifier_lu' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_modifier_lu',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_modifier_lu' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_modifier_lu',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_modifier_lu' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_modifier_lu',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_modifier_lu' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_modifier_lu',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_modifier_lu' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_message_contexte_ctx_modifier_lu_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_modifier_lu_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Ajout des droits d'accès au listing des bloc-notes dans le contexte des dossiers contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'blocnote_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Ajout des droits d'accès à l'onglet Pièces dans le contexte d'un dossier contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_uid_telecharger',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_uid_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_uid_telecharger',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_uid_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_contexte_ctx_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_contexte_ctx_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

-- Ajout des droits d'accès à l'onglet Dossiers liés dans le contexte d'un dossier contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_gestion_defaut',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_gestion_defaut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);

--
-- BEGIN — Widget Recherche par type
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Recherche accès direct par type','recherche_dossier_par_type','','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Recherche accès direct par type'
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), 'C2',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C2',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), 'C2',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), 'C2',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), 'C2',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION'), 'C2',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS'), 'C2',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION'), 'C2',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Recherche accès direct par type') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
    );

--
-- END / #654 — Widget Recherche par type
--

--
-- START / #690 — Widget "Infos profil" 
-- 

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), 'C1',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C1',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), 'C1',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), 'C1',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), 'C1',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION'), 'C1',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS'), 'C1',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION'), 'C1',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Infos profil') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
    );

--
-- END / #690 — Widget "Infos profil" 
-- 

--
-- END - Ajout des droits
--

--
-- START / #721 — Erreur de permission sur les profils
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_fichier_telecharger',(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

--
-- END / #721 — Erreur de permission sur les profils
--

--
-- START / #720 — Modification de l'affectation automatique : instructeur_2
--

ALTER TABLE affectation_automatique
    ALTER instructeur DROP NOT NULL,
    ADD instructeur_2 integer NULL;
COMMENT ON COLUMN affectation_automatique.instructeur IS 'Identifiant du premier instructeur ';
COMMENT ON COLUMN affectation_automatique.instructeur_2 IS 'Identifiant du second instructeur';
ALTER TABLE ONLY affectation_automatique
    ADD CONSTRAINT affectation_automatique_instructeur_2_fkey FOREIGN KEY (instructeur_2) REFERENCES instructeur(instructeur);

--
-- END / #720 — Modification de l'affectation automatique : instructeur_2
--

DELETE FROM om_droit
WHERE libelle = 'dossier_contrainte_consulter_bypass'
    OR libelle = 'dossier_message_ajouter_bypass';

--
-- START / #660 — Widgets les/mes contradictoires
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Les contradictoires','dossier_contentieux_contradictoire','filtre=aucun','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Les contradictoires'
    );
INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Mes contradictoires','dossier_contentieux_contradictoire','filtre=instructeur','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Mes contradictoires'
    );

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), 'C3',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les contradictoires')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les contradictoires') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), 'C2',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Mes contradictoires')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes contradictoires') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_contradictoire_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_contradictoire_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_contradictoire_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_contradictoire_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_contradictoire_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_contradictoire_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_contradictoire_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_contradictoire_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

--
-- END / #660 — Widgets les/mes contradictoires
--

--
-- START / #661 — Widget les/mes AIT
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Les AIT','dossier_contentieux_ait','filtre=aucun','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Les AIT'
    );
INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Mes AIT','dossier_contentieux_ait','filtre=instructeur','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Mes AIT'
    );

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), 'C3',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Mes AIT')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes AIT') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), 'C3',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les AIT')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les AIT') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C3',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les AIT')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les AIT') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), 'C2',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les AIT')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les AIT') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_ait_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_ait_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_ait_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_ait_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_ait_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_ait_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_ait_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_ait_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_ait_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_ait_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_ait_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_ait_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_ait_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_ait_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_ait_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_ait_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

--
-- END / #661 — Widget les/mes AIT
--

--
-- START / #662 — Widget les audiences
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Les audiences','dossier_contentieux_audience','filtre=aucun','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Les audiences'
    );

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), 'C3',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les audiences')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les audiences') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), 'C3',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les audiences')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les audiences') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C3',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les audiences')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les audiences') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_audience_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_audience_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_audience_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_audience_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_audience_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_audience_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_audience_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_audience_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_audience_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_audience_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_audience_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_audience_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

--
-- END / #662 — Widget les audiences
--

--
-- START / #663 — Widget mes clôtures
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Mes clôtures','dossier_contentieux_clotures','filtre=instructeur','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Mes clôtures'
    );

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), 'C3',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Mes clôtures')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes clôtures') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C2',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Mes clôtures')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes clôtures') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_clotures_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_clotures_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_clotures_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_clotures_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_clotures_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_clotures_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_clotures_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_clotures_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

--
-- END / #663 — Widget mes clôtures
--

--
-- START / #664 — Widget "Les infractions non affectées"
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Les infractions non affectées','dossier_contentieux_inaffectes','filtre=aucun','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Les infractions non affectées'
    );

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), 'C2',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les infractions non affectées')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les infractions non affectées') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), 'C2',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les infractions non affectées')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les infractions non affectées') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_inaffectes_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_inaffectes_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_inaffectes_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_inaffectes_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_inaffectes_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_inaffectes_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_inaffectes_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_inaffectes_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

--
-- END / #664 — Widget "Les infractions non affectées"
--

--
-- START / #665 — Widgets "Alerte Visite" et "Alerte Parquet"
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Alerte Visite','dossier_contentieux_alerte_visite','filtre=aucun','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Alerte Visite'
    );
INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Alerte Parquet','dossier_contentieux_alerte_parquet','filtre=aucun','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Alerte Parquet'
    );

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), 'C3',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Visite')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Visite') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), 'C3',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Parquet')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Parquet') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), 'C3',   1,  (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Visite')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Visite') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), 'C3',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Parquet')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Parquet') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C3',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Visite')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Visite') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C3',   4,  (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Parquet')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Alerte Parquet') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_visite_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_visite_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_visite_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_visite_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_parquet_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_parquet_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_parquet_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_parquet_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_visite_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_visite_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_visite_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_visite_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_parquet_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_parquet_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_parquet_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_parquet_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_visite_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_visite_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_visite_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_visite_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_parquet_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_parquet_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_alerte_parquet_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_alerte_parquet_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

--
-- END / #665 — Widgets "Alerte Visite" et "Alerte Parquet"
--

--
-- START / #732 — [#8675] Ajout de l'onglet des consultations d'un DI sur une demande d'avis
--

-- Suite à la modification du suffixe de la pemrission de l'action de l'édition,
-- on ajoute la permission "consultation_edition" à tous les profils ayant déjà
-- la permission "consultation_consulter"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_edition',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_edition' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

-- Suite à la modification des permissions requises pour afficher l'onglet des
-- consultation dans le contexte d'un DI, on ajoute la permission
-- "consultation_tab_di" à tous les profils ayant déjà la permission
-- "consultation_tab"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab_di',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab_di' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

--
-- END / #732 — [#8675] Ajout de l'onglet des consultations d'un DI sur une demande d'avis
--

--
-- START / [#8676] Nouveau profil "SERVICE CONSULTÉ ÉTENDU"
--

-- Ajout du nouveau profil
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (nextval('om_profil_seq'), 'SERVICE CONSULTÉ ÉTENDU', 0, NULL, NULL);

-- Ajout du widget sur le dashboard du nouveau profil
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget) VALUES (nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU'), 'C1', 1, (SELECT om_widget FROM om_widget WHERE lien = 'redirection'));

-- Ajout des droits identique au profil "SERVICE CONSULTÉ"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_fichier_telecharger',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_fichier_voir',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_voir' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_modifier',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_om_fichier_consultation_telecharger',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_om_fichier_consultation_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_retour_avis_service',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_retour_avis_service' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_document_numerise',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_document_numerise' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_encours',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_encours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_encours_demarquer',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_encours_demarquer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_encours_exporter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_encours_exporter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_encours_marquer',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_encours_marquer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_exporter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_exporter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_fichier_telecharger',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_fichier_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_passee',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_passee' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_passee_exporter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_passee_exporter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_uid_telecharger',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_uid_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_avis_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_avis_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_avis_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_avis_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_autorisation_document_numerise',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_autorisation_document_numerise' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_document',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_document' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_localiser',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_localiser-sig-externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_autorisation',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_autorisation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_demande_avis',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_demande_avis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'widget_redirection',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'widget_redirection' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);

-- Ajout des droits concernant l'onglet des consultations dans le contexte d'une
-- demande d'avis
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_consultation',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_consultation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_encours_consultation',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_encours_consultation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_passee_consultation',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_passee_consultation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);

-- Ajout d'un droit pour que la redirection du widget fonctionne sans utiliser
-- les méthodes dépréciées qui consisite à vérifier le profil
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'widget_redirection',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'widget_redirection' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'widget_redirection',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'widget_redirection' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'widget_redirection',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'widget_redirection' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);

-- Ajout des droits concernant l'onglet des consultations dans le contexte d'une
-- demande d'avis pour l'administrateur technique et fonctionnel
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_consultation',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_consultation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_encours_consultation',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_encours_consultation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_avis_passee_consultation',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_avis_passee_consultation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#8676] Nouveau profil "SERVICE CONSULTÉ ÉTENDU"
--

--
-- START / [#8679] Notification de la commune lors de l'ajout de nouvelles pièces numérisées
--

--
ALTER TABLE dossier_message ADD COLUMN destinataire character varying(60) NULL;
COMMENT ON COLUMN dossier_message.destinataire IS 'Destinataire du message ("instructeur" par défaut, ou "commune")';
UPDATE dossier_message SET destinataire = 'instructeur';
ALTER TABLE dossier_message ALTER COLUMN destinataire SET NOT NULL;

--
-- END / [#8679] Notification de la commune lors de l'ajout de nouvelles pièces numérisées
--


--
-- BEGIN - MISE À JOUR REQUÊTES POUR CHAMPS DE FUSION RELEVANT DU CONTENTIEUX
--

-- 1/2 - Récapitulatif du dossier d'instruction / dossier

UPDATE om_requete SET
requete = 'SELECT

    -- Données générales du dossier d''instruction
    dossier.dossier_libelle as libelle_dossier,
    dossier.dossier as code_barres_dossier,
    etat.libelle as etat_dossier,
    dossier_autorisation.dossier_autorisation_libelle as libelle_da,

    dossier_autorisation_type_detaille.code as code_datd,
    dossier_autorisation_type_detaille.libelle as libelle_datd,
    dossier_autorisation_type.code as code_dat,
    dossier_autorisation_type.libelle as libelle_dat,
    dossier_instruction_type.code as code_dit,
    dossier_instruction_type.libelle as libelle_dit,
    dossier.delai as delai_dossier,
    replace(dossier.terrain_references_cadastrales, '';'', '' '') as terrain_references_cadastrales_dossier,

    avis_decision.libelle as libelle_avis_decision,

    -- Données contentieux du dossier d''instruction
    dossier.autorisation_contestee as autorisation_contestee,
    to_char(dossier.date_cloture_instruction, ''DD/MM/YYYY'') as date_cloture_instruction_dossier,
    to_char(dossier.date_premiere_visite, ''DD/MM/YYYY'') as date_premiere_visite_dossier,
    to_char(dossier.date_derniere_visite, ''DD/MM/YYYY'') as date_derniere_visite_dossier,
    to_char(dossier.date_contradictoire, ''DD/MM/YYYY'') as date_contradictoire_dossier,
    to_char(dossier.date_retour_contradictoire, ''DD/MM/YYYY'') as date_retour_contradictoire_dossier,
    to_char(dossier.date_ait, ''DD/MM/YYYY'') as date_ait_dossier,
    to_char(dossier.date_transmission_parquet, ''DD/MM/YYYY'') as date_transmission_parquet_dossier,

    -- Coordonnées de l''instructeur
    instructeur.nom as nom_instructeur,
    instructeur.telephone as telephone_instructeur,
    division.code as division_instructeur,
    om_utilisateur.email as email_instructeur,

    -- Coordonnées de l''instructeur 2
    instructeur_2.nom as nom_instructeur_2,
    instructeur_2.telephone as telephone_instructeur_2,
    division_2.code as division_instructeur_2,
    om_utilisateur_2.email as email_instructeur_2,

    -- Noms des signataires
    division.chef as division_chef,
    direction.chef as direction_chef,
    direction.libelle as libelle_direction,
    direction.description as description_direction,

    -- Adresse du terrain du dossier d''instruction
    dossier.terrain_adresse_voie_numero as terrain_adresse_voie_numero_dossier,
    dossier.terrain_adresse_voie as terrain_adresse_voie_dossier,
    dossier.terrain_adresse_lieu_dit as terrain_adresse_lieu_dit_dossier,
    CASE 
        WHEN dossier.terrain_adresse_bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', dossier.terrain_adresse_bp)
    END as terrain_adresse_bp_dossier,
    dossier.terrain_adresse_code_postal as terrain_adresse_code_postal_dossier,
    dossier.terrain_adresse_localite as terrain_adresse_localite_dossier,
    CASE 
        WHEN dossier.terrain_adresse_cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', dossier.terrain_adresse_cedex)
    END as terrain_adresse_cedex_dossier,
    arrondissement.libelle as libelle_arrondissement,

    -- Nom et prénom de l''architecte
    CONCAT(architecte.prenom||'' '', architecte.nom) as architecte,

    --Taxe d''aménagement du dossier d''instruction
    CASE
        WHEN tax_secteur = 1 THEN taxe_amenagement.tx_comm_secteur_1
        WHEN tax_secteur = 2 THEN taxe_amenagement.tx_comm_secteur_2
        WHEN tax_secteur = 3 THEN taxe_amenagement.tx_comm_secteur_3
        WHEN tax_secteur = 4 THEN taxe_amenagement.tx_comm_secteur_4
        WHEN tax_secteur = 5 THEN taxe_amenagement.tx_comm_secteur_5
        WHEN tax_secteur = 6 THEN taxe_amenagement.tx_comm_secteur_6
        WHEN tax_secteur = 7 THEN taxe_amenagement.tx_comm_secteur_7
        WHEN tax_secteur = 8 THEN taxe_amenagement.tx_comm_secteur_8
        WHEN tax_secteur = 9 THEN taxe_amenagement.tx_comm_secteur_9
        WHEN tax_secteur = 10 THEN taxe_amenagement.tx_comm_secteur_10
        WHEN tax_secteur = 11 THEN taxe_amenagement.tx_comm_secteur_11
        WHEN tax_secteur = 12 THEN taxe_amenagement.tx_comm_secteur_12
        WHEN tax_secteur = 13 THEN taxe_amenagement.tx_comm_secteur_13
        WHEN tax_secteur = 14 THEN taxe_amenagement.tx_comm_secteur_14
        WHEN tax_secteur = 15 THEN taxe_amenagement.tx_comm_secteur_15
        WHEN tax_secteur = 16 THEN taxe_amenagement.tx_comm_secteur_16
        WHEN tax_secteur = 17 THEN taxe_amenagement.tx_comm_secteur_17
        WHEN tax_secteur = 18 THEN taxe_amenagement.tx_comm_secteur_18
        WHEN tax_secteur = 19 THEN taxe_amenagement.tx_comm_secteur_19
        WHEN tax_secteur = 20 THEN taxe_amenagement.tx_comm_secteur_20
    END as tax_taux_secteur,
    dossier.tax_secteur as tax_numero_secteur,
    dossier.tax_mtn_part_commu as tax_montant_part_communale,
    dossier.tax_mtn_part_depart as tax_montant_part_departementale,
    dossier.tax_mtn_part_reg as tax_montant_part_regionale,
    dossier.tax_mtn_total as tax_montant_total,

    --Coordonnées du pétitionnaire principal

    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
            END
    END as nom_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier'' OR petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_nom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_denomination
    END as denomination_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_siret
    END as siret_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_principal,
    petitionnaire_principal.numero as numero_petitionnaire_principal,
    petitionnaire_principal.voie as voie_petitionnaire_principal,
    petitionnaire_principal.complement as complement_petitionnaire_principal,
    petitionnaire_principal.lieu_dit as lieu_dit_petitionnaire_principal,
    CASE 
        WHEN petitionnaire_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_principal.bp)
    END as bp_petitionnaire_principal,
    petitionnaire_principal.code_postal as code_postal_petitionnaire_principal,
    petitionnaire_principal.localite as localite_petitionnaire_principal,
    CASE 
        WHEN petitionnaire_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_principal.cedex)
    END as cedex_petitionnaire_principal,
    petitionnaire_principal.pays as pays_petitionnaire_principal,
    petitionnaire_principal.division_territoriale as division_territoriale_petitionnaire_principal,

    --Coordonnées du pétitionnaire 1

    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_1_civilite.libelle, petitionnaire_1.particulier_nom, petitionnaire_1.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_1.personne_morale_raison_sociale, petitionnaire_1.personne_morale_denomination, ''représenté(e) par'', petitionnaire_1_civilite.libelle, petitionnaire_1.personne_morale_nom, petitionnaire_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_1.personne_morale_raison_sociale, '' '', petitionnaire_1.personne_morale_denomination))
            END
    END as nom_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier'' OR petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_1_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_nom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL
                THEN petitionnaire_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_denomination
    END as denomination_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_siret
    END as siret_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_1,
    petitionnaire_1.numero as numero_petitionnaire_1,
    petitionnaire_1.voie as voie_petitionnaire_1,
    petitionnaire_1.complement as complement_petitionnaire_1,
    petitionnaire_1.lieu_dit as lieu_dit_petitionnaire_1,
    CASE 
        WHEN petitionnaire_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_1.bp)
    END as bp_petitionnaire_1,
    petitionnaire_1.code_postal as code_postal_petitionnaire_1,
    petitionnaire_1.localite as localite_petitionnaire_1,
    CASE 
        WHEN petitionnaire_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_1.cedex)
    END as cedex_petitionnaire_1,
    petitionnaire_1.pays as pays_petitionnaire_1,
    petitionnaire_1.division_territoriale as division_territoriale_petitionnaire_1,

    --Coordonnées du pétitionnaire 2

    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_2_civilite.libelle, petitionnaire_2.particulier_nom, petitionnaire_2.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_2.personne_morale_raison_sociale, petitionnaire_2.personne_morale_denomination, ''représenté(e) par'', petitionnaire_2_civilite.libelle, petitionnaire_2.personne_morale_nom, petitionnaire_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_2.personne_morale_raison_sociale, '' '', petitionnaire_2.personne_morale_denomination))
            END
    END as nom_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier'' OR petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_2_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_nom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL
                THEN petitionnaire_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_denomination
    END as denomination_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_siret
    END as siret_petitionnaire_2,
    petitionnaire_2.numero as numero_petitionnaire_2,
    petitionnaire_2.voie as voie_petitionnaire_2,
    petitionnaire_2.complement as complement_petitionnaire_2,
    petitionnaire_2.lieu_dit as lieu_dit_petitionnaire_2,
    CASE 
        WHEN petitionnaire_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_2.bp)
    END as bp_petitionnaire_2,
    petitionnaire_2.code_postal as code_postal_petitionnaire_2,
    petitionnaire_2.localite as localite_petitionnaire_2,
    CASE 
        WHEN petitionnaire_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_2.cedex)
    END as cedex_petitionnaire_2,
    petitionnaire_2.pays as pays_petitionnaire_2,
    petitionnaire_2.division_territoriale as division_territoriale_petitionnaire_2,

    --Coordonnées du pétitionnaire 3

    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_3_civilite.libelle, petitionnaire_3.particulier_nom, petitionnaire_3.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_3.personne_morale_raison_sociale, petitionnaire_3.personne_morale_denomination, ''représenté(e) par'', petitionnaire_3_civilite.libelle, petitionnaire_3.personne_morale_nom, petitionnaire_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_3.personne_morale_raison_sociale, '' '', petitionnaire_3.personne_morale_denomination))
            END
    END as nom_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier'' OR petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_3_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_nom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL
                THEN petitionnaire_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_denomination
    END as denomination_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_siret
    END as siret_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_3,
    petitionnaire_3.numero as numero_petitionnaire_3,
    petitionnaire_3.voie as voie_petitionnaire_3,
    petitionnaire_3.complement as complement_petitionnaire_3,
    petitionnaire_3.lieu_dit as lieu_dit_petitionnaire_3,
    CASE 
        WHEN petitionnaire_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_3.bp)
    END as bp_petitionnaire_3,
    petitionnaire_3.code_postal as code_postal_petitionnaire_3,
    petitionnaire_3.localite as localite_petitionnaire_3,
    CASE 
        WHEN petitionnaire_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_3.cedex)
    END as cedex_petitionnaire_3,
    petitionnaire_3.pays as pays_petitionnaire_3,
    petitionnaire_3.division_territoriale as division_territoriale_petitionnaire_3,

    --Coordonnées du pétitionnaire 4

    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_4_civilite.libelle, petitionnaire_4.particulier_nom, petitionnaire_4.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_4.personne_morale_raison_sociale, petitionnaire_4.personne_morale_denomination, ''représenté(e) par'', petitionnaire_4_civilite.libelle, petitionnaire_4.personne_morale_nom, petitionnaire_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_4.personne_morale_raison_sociale, '' '', petitionnaire_4.personne_morale_denomination))
            END
    END as nom_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier'' OR petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_4_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_nom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL
                THEN petitionnaire_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_denomination
    END as denomination_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_siret
    END as siret_petitionnaire_4,
    petitionnaire_4.numero as numero_petitionnaire_4,
    petitionnaire_4.voie as voie_petitionnaire_4,
    petitionnaire_4.complement as complement_petitionnaire_4,
    petitionnaire_4.lieu_dit as lieu_dit_petitionnaire_4,
    CASE 
        WHEN petitionnaire_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_4.bp)
    END as bp_petitionnaire_4,
    petitionnaire_4.code_postal as code_postal_petitionnaire_4,
    petitionnaire_4.localite as localite_petitionnaire_4,
    CASE 
        WHEN petitionnaire_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_4.cedex)
    END as cedex_petitionnaire_4,
    petitionnaire_4.pays as pays_petitionnaire_4,
    petitionnaire_4.division_territoriale as division_territoriale_petitionnaire_4,

    --Coordonnées du pétitionnaire 5

    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_5_civilite.libelle, petitionnaire_5.particulier_nom, petitionnaire_5.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_5.personne_morale_raison_sociale, petitionnaire_5.personne_morale_denomination, ''représenté(e) par'', petitionnaire_5_civilite.libelle, petitionnaire_5.personne_morale_nom, petitionnaire_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_5.personne_morale_raison_sociale, '' '', petitionnaire_5.personne_morale_denomination))
            END
    END as nom_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier'' OR petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_5_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_nom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL
                THEN petitionnaire_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_denomination
    END as denomination_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_siret
    END as siret_petitionnaire_5,
    petitionnaire_5.numero as numero_petitionnaire_5,
    petitionnaire_5.voie as voie_petitionnaire_5,
    petitionnaire_5.complement as complement_petitionnaire_5,
    petitionnaire_5.lieu_dit as lieu_dit_petitionnaire_5,
    CASE 
        WHEN petitionnaire_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_5.bp)
    END as bp_petitionnaire_5,
    petitionnaire_5.code_postal as code_postal_petitionnaire_5,
    petitionnaire_5.localite as localite_petitionnaire_5,
    CASE 
        WHEN petitionnaire_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_5.cedex)
    END as cedex_petitionnaire_5,
    petitionnaire_5.pays as pays_petitionnaire_5,
    petitionnaire_5.division_territoriale as division_territoriale_petitionnaire_5,

    --Coordonnées du contrevenant principal

    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_principal_civilite.libelle, contrevenant_principal.particulier_nom, contrevenant_principal.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_principal.personne_morale_raison_sociale, contrevenant_principal.personne_morale_denomination, ''représenté(e) par'', contrevenant_principal_civilite.libelle, contrevenant_principal.personne_morale_nom, contrevenant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_principal.personne_morale_raison_sociale, '' '', contrevenant_principal.personne_morale_denomination))
            END
    END as nom_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier'' OR contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
        THEN contrevenant_principal_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_nom
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL
                THEN contrevenant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_prenom
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_prenom IS NOT NULL
                THEN contrevenant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_denomination
    END as denomination_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_siret
    END as siret_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_principal,
    contrevenant_principal.numero as numero_contrevenant_principal,
    contrevenant_principal.voie as voie_contrevenant_principal,
    contrevenant_principal.complement as complement_contrevenant_principal,
    contrevenant_principal.lieu_dit as lieu_dit_contrevenant_principal,
    CASE 
        WHEN contrevenant_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_principal.bp)
    END as bp_contrevenant_principal,
    contrevenant_principal.code_postal as code_postal_contrevenant_principal,
    contrevenant_principal.localite as localite_contrevenant_principal,
    CASE 
        WHEN contrevenant_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_principal.cedex)
    END as cedex_contrevenant_principal,
    contrevenant_principal.pays as pays_contrevenant_principal,
    contrevenant_principal.division_territoriale as division_territoriale_contrevenant_principal,

    --Coordonnées du contrevenant 1

    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_1_civilite.libelle, contrevenant_1.particulier_nom, contrevenant_1.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_1.personne_morale_raison_sociale, contrevenant_1.personne_morale_denomination, ''représenté(e) par'', contrevenant_1_civilite.libelle, contrevenant_1.personne_morale_nom, contrevenant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_1.personne_morale_raison_sociale, '' '', contrevenant_1.personne_morale_denomination))
            END
    END as nom_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier'' OR contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
        THEN contrevenant_1_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_nom
        ELSE
            CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL
                THEN contrevenant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_prenom
        ELSE
            CASE WHEN contrevenant_1.personne_morale_prenom IS NOT NULL
                THEN contrevenant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_denomination
    END as denomination_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_siret
    END as siret_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_1,
    contrevenant_1.numero as numero_contrevenant_1,
    contrevenant_1.voie as voie_contrevenant_1,
    contrevenant_1.complement as complement_contrevenant_1,
    contrevenant_1.lieu_dit as lieu_dit_contrevenant_1,
    CASE 
        WHEN contrevenant_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_1.bp)
    END as bp_contrevenant_1,
    contrevenant_1.code_postal as code_postal_contrevenant_1,
    contrevenant_1.localite as localite_contrevenant_1,
    CASE 
        WHEN contrevenant_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_1.cedex)
    END as cedex_contrevenant_1,
    contrevenant_1.pays as pays_contrevenant_1,
    contrevenant_1.division_territoriale as division_territoriale_contrevenant_1,

    --Coordonnées du contrevenant 2

    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_2_civilite.libelle, contrevenant_2.particulier_nom, contrevenant_2.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_2.personne_morale_raison_sociale, contrevenant_2.personne_morale_denomination, ''représenté(e) par'', contrevenant_2_civilite.libelle, contrevenant_2.personne_morale_nom, contrevenant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_2.personne_morale_raison_sociale, '' '', contrevenant_2.personne_morale_denomination))
            END
    END as nom_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier'' OR contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
        THEN contrevenant_2_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_nom
        ELSE
            CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL
                THEN contrevenant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_prenom
        ELSE
            CASE WHEN contrevenant_2.personne_morale_prenom IS NOT NULL
                THEN contrevenant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_denomination
    END as denomination_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_siret
    END as siret_contrevenant_2,
    contrevenant_2.numero as numero_contrevenant_2,
    contrevenant_2.voie as voie_contrevenant_2,
    contrevenant_2.complement as complement_contrevenant_2,
    contrevenant_2.lieu_dit as lieu_dit_contrevenant_2,
    CASE 
        WHEN contrevenant_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_2.bp)
    END as bp_contrevenant_2,
    contrevenant_2.code_postal as code_postal_contrevenant_2,
    contrevenant_2.localite as localite_contrevenant_2,
    CASE 
        WHEN contrevenant_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_2.cedex)
    END as cedex_contrevenant_2,
    contrevenant_2.pays as pays_contrevenant_2,
    contrevenant_2.division_territoriale as division_territoriale_contrevenant_2,

    --Coordonnées du contrevenant 3

    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_3_civilite.libelle, contrevenant_3.particulier_nom, contrevenant_3.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_3.personne_morale_raison_sociale, contrevenant_3.personne_morale_denomination, ''représenté(e) par'', contrevenant_3_civilite.libelle, contrevenant_3.personne_morale_nom, contrevenant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_3.personne_morale_raison_sociale, '' '', contrevenant_3.personne_morale_denomination))
            END
    END as nom_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier'' OR contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN contrevenant_3_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_nom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL
                THEN contrevenant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_prenom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN contrevenant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_denomination
    END as denomination_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_siret
    END as siret_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_3,
    contrevenant_3.numero as numero_contrevenant_3,
    contrevenant_3.voie as voie_contrevenant_3,
    contrevenant_3.complement as complement_contrevenant_3,
    contrevenant_3.lieu_dit as lieu_dit_contrevenant_3,
    CASE 
        WHEN contrevenant_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_3.bp)
    END as bp_contrevenant_3,
    contrevenant_3.code_postal as code_postal_contrevenant_3,
    contrevenant_3.localite as localite_contrevenant_3,
    CASE 
        WHEN contrevenant_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_3.cedex)
    END as cedex_contrevenant_3,
    contrevenant_3.pays as pays_contrevenant_3,
    contrevenant_3.division_territoriale as division_territoriale_contrevenant_3,

    --Coordonnées du contrevenant 4

    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_4_civilite.libelle, contrevenant_4.particulier_nom, contrevenant_4.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_4.personne_morale_raison_sociale, contrevenant_4.personne_morale_denomination, ''représenté(e) par'', contrevenant_4_civilite.libelle, contrevenant_4.personne_morale_nom, contrevenant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_4.personne_morale_raison_sociale, '' '', contrevenant_4.personne_morale_denomination))
            END
    END as nom_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier'' OR contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
        THEN contrevenant_4_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_nom
        ELSE
            CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL
                THEN contrevenant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_prenom
        ELSE
            CASE WHEN contrevenant_4.personne_morale_prenom IS NOT NULL
                THEN contrevenant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_denomination
    END as denomination_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_siret
    END as siret_contrevenant_4,
    contrevenant_4.numero as numero_contrevenant_4,
    contrevenant_4.voie as voie_contrevenant_4,
    contrevenant_4.complement as complement_contrevenant_4,
    contrevenant_4.lieu_dit as lieu_dit_contrevenant_4,
    CASE 
        WHEN contrevenant_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_4.bp)
    END as bp_contrevenant_4,
    contrevenant_4.code_postal as code_postal_contrevenant_4,
    contrevenant_4.localite as localite_contrevenant_4,
    CASE 
        WHEN contrevenant_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_4.cedex)
    END as cedex_contrevenant_4,
    contrevenant_4.pays as pays_contrevenant_4,
    contrevenant_4.division_territoriale as division_territoriale_contrevenant_4,

    --Coordonnées du contrevenant 5

    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_5_civilite.libelle, contrevenant_5.particulier_nom, contrevenant_5.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_5.personne_morale_nom IS NOT NULL OR contrevenant_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_5.personne_morale_raison_sociale, contrevenant_5.personne_morale_denomination, ''représenté(e) par'', contrevenant_5_civilite.libelle, contrevenant_5.personne_morale_nom, contrevenant_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_5.personne_morale_raison_sociale, '' '', contrevenant_5.personne_morale_denomination))
            END
    END as nom_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier'' OR contrevenant_5.personne_morale_nom IS NOT NULL OR contrevenant_5.personne_morale_prenom IS NOT NULL
        THEN contrevenant_5_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN contrevenant_5.particulier_nom
        ELSE
            CASE WHEN contrevenant_5.personne_morale_nom IS NOT NULL
                THEN contrevenant_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN contrevenant_5.particulier_prenom
        ELSE
            CASE WHEN contrevenant_5.personne_morale_prenom IS NOT NULL
                THEN contrevenant_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_denomination
    END as denomination_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_siret
    END as siret_contrevenant_5,
    contrevenant_5.numero as numero_contrevenant_5,
    contrevenant_5.voie as voie_contrevenant_5,
    contrevenant_5.complement as complement_contrevenant_5,
    contrevenant_5.lieu_dit as lieu_dit_contrevenant_5,
    CASE 
        WHEN contrevenant_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_5.bp)
    END as bp_contrevenant_5,
    contrevenant_5.code_postal as code_postal_contrevenant_5,
    contrevenant_5.localite as localite_contrevenant_5,
    CASE 
        WHEN contrevenant_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_5.cedex)
    END as cedex_contrevenant_5,
    contrevenant_5.pays as pays_contrevenant_5,
    contrevenant_5.division_territoriale as division_territoriale_contrevenant_5,

    --Coordonnées du requérant principal

    CASE WHEN requerant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_principal_civilite.libelle, requerant_principal.particulier_nom, requerant_principal.particulier_prenom))
        ELSE
            CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_principal.personne_morale_raison_sociale, requerant_principal.personne_morale_denomination, ''représenté(e) par'', requerant_principal_civilite.libelle, requerant_principal.personne_morale_nom, requerant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_principal.personne_morale_raison_sociale, '' '', requerant_principal.personne_morale_denomination))
            END
    END as nom_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier'' OR requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
        THEN requerant_principal_civilite.libelle
        ELSE ''''
    END as civilite_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_nom
        ELSE
            CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL
                THEN requerant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_prenom
        ELSE
            CASE WHEN requerant_principal.personne_morale_prenom IS NOT NULL
                THEN requerant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_raison_sociale
    END as raison_sociale_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_denomination
    END as denomination_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_siret
    END as siret_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_principal,
    requerant_principal.numero as numero_requerant_principal,
    requerant_principal.voie as voie_requerant_principal,
    requerant_principal.complement as complement_requerant_principal,
    requerant_principal.lieu_dit as lieu_dit_requerant_principal,
    CASE 
        WHEN requerant_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_principal.bp)
    END as bp_requerant_principal,
    requerant_principal.code_postal as code_postal_requerant_principal,
    requerant_principal.localite as localite_requerant_principal,
    CASE 
        WHEN requerant_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_principal.cedex)
    END as cedex_requerant_principal,
    requerant_principal.pays as pays_requerant_principal,
    requerant_principal.division_territoriale as division_territoriale_requerant_principal,

    --Coordonnées du requérant 1

    CASE WHEN requerant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_1_civilite.libelle, requerant_1.particulier_nom, requerant_1.particulier_prenom))
        ELSE
            CASE WHEN requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_1.personne_morale_raison_sociale, requerant_1.personne_morale_denomination, ''représenté(e) par'', requerant_1_civilite.libelle, requerant_1.personne_morale_nom, requerant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_1.personne_morale_raison_sociale, '' '', requerant_1.personne_morale_denomination))
            END
    END as nom_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier'' OR requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
        THEN requerant_1_civilite.libelle
        ELSE ''''
    END as civilite_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_nom
        ELSE
            CASE WHEN requerant_1.personne_morale_nom IS NOT NULL
                THEN requerant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_prenom
        ELSE
            CASE WHEN requerant_1.personne_morale_prenom IS NOT NULL
                THEN requerant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_raison_sociale
    END as raison_sociale_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_denomination
    END as denomination_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_siret
    END as siret_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_1,
    requerant_1.numero as numero_requerant_1,
    requerant_1.voie as voie_requerant_1,
    requerant_1.complement as complement_requerant_1,
    requerant_1.lieu_dit as lieu_dit_requerant_1,
    CASE 
        WHEN requerant_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_1.bp)
    END as bp_requerant_1,
    requerant_1.code_postal as code_postal_requerant_1,
    requerant_1.localite as localite_requerant_1,
    CASE 
        WHEN requerant_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_1.cedex)
    END as cedex_requerant_1,
    requerant_1.pays as pays_requerant_1,
    requerant_1.division_territoriale as division_territoriale_requerant_1,

    --Coordonnées du requérant 2

    CASE WHEN requerant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_2_civilite.libelle, requerant_2.particulier_nom, requerant_2.particulier_prenom))
        ELSE
            CASE WHEN requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_2.personne_morale_raison_sociale, requerant_2.personne_morale_denomination, ''représenté(e) par'', requerant_2_civilite.libelle, requerant_2.personne_morale_nom, requerant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_2.personne_morale_raison_sociale, '' '', requerant_2.personne_morale_denomination))
            END
    END as nom_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier'' OR requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
        THEN requerant_2_civilite.libelle
        ELSE ''''
    END as civilite_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_nom
        ELSE
            CASE WHEN requerant_2.personne_morale_nom IS NOT NULL
                THEN requerant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_prenom
        ELSE
            CASE WHEN requerant_2.personne_morale_prenom IS NOT NULL
                THEN requerant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_raison_sociale
    END as raison_sociale_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_denomination
    END as denomination_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_siret
    END as siret_requerant_2,
    requerant_2.numero as numero_requerant_2,
    requerant_2.voie as voie_requerant_2,
    requerant_2.complement as complement_requerant_2,
    requerant_2.lieu_dit as lieu_dit_requerant_2,
    CASE 
        WHEN requerant_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_2.bp)
    END as bp_requerant_2,
    requerant_2.code_postal as code_postal_requerant_2,
    requerant_2.localite as localite_requerant_2,
    CASE 
        WHEN requerant_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_2.cedex)
    END as cedex_requerant_2,
    requerant_2.pays as pays_requerant_2,
    requerant_2.division_territoriale as division_territoriale_requerant_2,

    --Coordonnées du requérant 3

    CASE WHEN requerant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_3_civilite.libelle, requerant_3.particulier_nom, requerant_3.particulier_prenom))
        ELSE
            CASE WHEN requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_3.personne_morale_raison_sociale, requerant_3.personne_morale_denomination, ''représenté(e) par'', requerant_3_civilite.libelle, requerant_3.personne_morale_nom, requerant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_3.personne_morale_raison_sociale, '' '', requerant_3.personne_morale_denomination))
            END
    END as nom_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier'' OR requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
        THEN requerant_3_civilite.libelle
        ELSE ''''
    END as civilite_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_nom
        ELSE
            CASE WHEN requerant_3.personne_morale_nom IS NOT NULL
                THEN requerant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_prenom
        ELSE
            CASE WHEN requerant_3.personne_morale_prenom IS NOT NULL
                THEN requerant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_raison_sociale
    END as raison_sociale_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_denomination
    END as denomination_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_siret
    END as siret_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_3,
    requerant_3.numero as numero_requerant_3,
    requerant_3.voie as voie_requerant_3,
    requerant_3.complement as complement_requerant_3,
    requerant_3.lieu_dit as lieu_dit_requerant_3,
    CASE 
        WHEN requerant_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_3.bp)
    END as bp_requerant_3,
    requerant_3.code_postal as code_postal_requerant_3,
    requerant_3.localite as localite_requerant_3,
    CASE 
        WHEN requerant_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_3.cedex)
    END as cedex_requerant_3,
    requerant_3.pays as pays_requerant_3,
    requerant_3.division_territoriale as division_territoriale_requerant_3,

    --Coordonnées du requérant 4

    CASE WHEN requerant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_4_civilite.libelle, requerant_4.particulier_nom, requerant_4.particulier_prenom))
        ELSE
            CASE WHEN requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_4.personne_morale_raison_sociale, requerant_4.personne_morale_denomination, ''représenté(e) par'', requerant_4_civilite.libelle, requerant_4.personne_morale_nom, requerant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_4.personne_morale_raison_sociale, '' '', requerant_4.personne_morale_denomination))
            END
    END as nom_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier'' OR requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
        THEN requerant_4_civilite.libelle
        ELSE ''''
    END as civilite_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_nom
        ELSE
            CASE WHEN requerant_4.personne_morale_nom IS NOT NULL
                THEN requerant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_prenom
        ELSE
            CASE WHEN requerant_4.personne_morale_prenom IS NOT NULL
                THEN requerant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_raison_sociale
    END as raison_sociale_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_denomination
    END as denomination_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_siret
    END as siret_requerant_4,
    requerant_4.numero as numero_requerant_4,
    requerant_4.voie as voie_requerant_4,
    requerant_4.complement as complement_requerant_4,
    requerant_4.lieu_dit as lieu_dit_requerant_4,
    CASE 
        WHEN requerant_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_4.bp)
    END as bp_requerant_4,
    requerant_4.code_postal as code_postal_requerant_4,
    requerant_4.localite as localite_requerant_4,
    CASE 
        WHEN requerant_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_4.cedex)
    END as cedex_requerant_4,
    requerant_4.pays as pays_requerant_4,
    requerant_4.division_territoriale as division_territoriale_requerant_4,

    --Coordonnées du requérant 5

    CASE WHEN requerant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_5_civilite.libelle, requerant_5.particulier_nom, requerant_5.particulier_prenom))
        ELSE
            CASE WHEN requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_5.personne_morale_raison_sociale, requerant_5.personne_morale_denomination, ''représenté(e) par'', requerant_5_civilite.libelle, requerant_5.personne_morale_nom, requerant_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_5.personne_morale_raison_sociale, '' '', requerant_5.personne_morale_denomination))
            END
    END as nom_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier'' OR requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
        THEN requerant_5_civilite.libelle
        ELSE ''''
    END as civilite_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_nom
        ELSE
            CASE WHEN requerant_5.personne_morale_nom IS NOT NULL
                THEN requerant_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_prenom
        ELSE
            CASE WHEN requerant_5.personne_morale_prenom IS NOT NULL
                THEN requerant_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_raison_sociale
    END as raison_sociale_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_denomination
    END as denomination_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_siret
    END as siret_requerant_5,
    requerant_5.numero as numero_requerant_5,
    requerant_5.voie as voie_requerant_5,
    requerant_5.complement as complement_requerant_5,
    requerant_5.lieu_dit as lieu_dit_requerant_5,
    CASE 
        WHEN requerant_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_5.bp)
    END as bp_requerant_5,
    requerant_5.code_postal as code_postal_requerant_5,
    requerant_5.localite as localite_requerant_5,
    CASE 
        WHEN requerant_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_5.cedex)
    END as cedex_requerant_5,
    requerant_5.pays as pays_requerant_5,
    requerant_5.division_territoriale as division_territoriale_requerant_5,

    --Coordonnées de l''avocat principal

    CASE WHEN avocat_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_principal_civilite.libelle, avocat_principal.particulier_nom, avocat_principal.particulier_prenom))
        ELSE
            CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_principal.personne_morale_raison_sociale, avocat_principal.personne_morale_denomination, ''représenté(e) par'', avocat_principal_civilite.libelle, avocat_principal.personne_morale_nom, avocat_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_principal.personne_morale_raison_sociale, '' '', avocat_principal.personne_morale_denomination))
            END
    END as nom_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier'' OR avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
        THEN avocat_principal_civilite.libelle
        ELSE ''''
    END as civilite_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_nom
        ELSE
            CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL
                THEN avocat_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_prenom
        ELSE
            CASE WHEN avocat_principal.personne_morale_prenom IS NOT NULL
                THEN avocat_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_raison_sociale
    END as raison_sociale_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_denomination
    END as denomination_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_siret
    END as siret_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_principal,
    avocat_principal.numero as numero_avocat_principal,
    avocat_principal.voie as voie_avocat_principal,
    avocat_principal.complement as complement_avocat_principal,
    avocat_principal.lieu_dit as lieu_dit_avocat_principal,
    CASE 
        WHEN avocat_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_principal.bp)
    END as bp_avocat_principal,
    avocat_principal.code_postal as code_postal_avocat_principal,
    avocat_principal.localite as localite_avocat_principal,
    CASE 
        WHEN avocat_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_principal.cedex)
    END as cedex_avocat_principal,
    avocat_principal.pays as pays_avocat_principal,
    avocat_principal.division_territoriale as division_territoriale_avocat_principal,

    --Coordonnées de l''avocat 1

    CASE WHEN avocat_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_1_civilite.libelle, avocat_1.particulier_nom, avocat_1.particulier_prenom))
        ELSE
            CASE WHEN avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_1.personne_morale_raison_sociale, avocat_1.personne_morale_denomination, ''représenté(e) par'', avocat_1_civilite.libelle, avocat_1.personne_morale_nom, avocat_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_1.personne_morale_raison_sociale, '' '', avocat_1.personne_morale_denomination))
            END
    END as nom_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier'' OR avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
        THEN avocat_1_civilite.libelle
        ELSE ''''
    END as civilite_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_nom
        ELSE
            CASE WHEN avocat_1.personne_morale_nom IS NOT NULL
                THEN avocat_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_prenom
        ELSE
            CASE WHEN avocat_1.personne_morale_prenom IS NOT NULL
                THEN avocat_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_raison_sociale
    END as raison_sociale_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_denomination
    END as denomination_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_siret
    END as siret_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_1,
    avocat_1.numero as numero_avocat_1,
    avocat_1.voie as voie_avocat_1,
    avocat_1.complement as complement_avocat_1,
    avocat_1.lieu_dit as lieu_dit_avocat_1,
    CASE 
        WHEN avocat_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_1.bp)
    END as bp_avocat_1,
    avocat_1.code_postal as code_postal_avocat_1,
    avocat_1.localite as localite_avocat_1,
    CASE 
        WHEN avocat_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_1.cedex)
    END as cedex_avocat_1,
    avocat_1.pays as pays_avocat_1,
    avocat_1.division_territoriale as division_territoriale_avocat_1,

    --Coordonnées de l''avocat 2

    CASE WHEN avocat_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_2_civilite.libelle, avocat_2.particulier_nom, avocat_2.particulier_prenom))
        ELSE
            CASE WHEN avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_2.personne_morale_raison_sociale, avocat_2.personne_morale_denomination, ''représenté(e) par'', avocat_2_civilite.libelle, avocat_2.personne_morale_nom, avocat_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_2.personne_morale_raison_sociale, '' '', avocat_2.personne_morale_denomination))
            END
    END as nom_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier'' OR avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
        THEN avocat_2_civilite.libelle
        ELSE ''''
    END as civilite_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_nom
        ELSE
            CASE WHEN avocat_2.personne_morale_nom IS NOT NULL
                THEN avocat_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_prenom
        ELSE
            CASE WHEN avocat_2.personne_morale_prenom IS NOT NULL
                THEN avocat_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_raison_sociale
    END as raison_sociale_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_denomination
    END as denomination_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_siret
    END as siret_avocat_2,
    avocat_2.numero as numero_avocat_2,
    avocat_2.voie as voie_avocat_2,
    avocat_2.complement as complement_avocat_2,
    avocat_2.lieu_dit as lieu_dit_avocat_2,
    CASE 
        WHEN avocat_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_2.bp)
    END as bp_avocat_2,
    avocat_2.code_postal as code_postal_avocat_2,
    avocat_2.localite as localite_avocat_2,
    CASE 
        WHEN avocat_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_2.cedex)
    END as cedex_avocat_2,
    avocat_2.pays as pays_avocat_2,
    avocat_2.division_territoriale as division_territoriale_avocat_2,

    --Coordonnées de l''avocat 3

    CASE WHEN avocat_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_3_civilite.libelle, avocat_3.particulier_nom, avocat_3.particulier_prenom))
        ELSE
            CASE WHEN avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_3.personne_morale_raison_sociale, avocat_3.personne_morale_denomination, ''représenté(e) par'', avocat_3_civilite.libelle, avocat_3.personne_morale_nom, avocat_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_3.personne_morale_raison_sociale, '' '', avocat_3.personne_morale_denomination))
            END
    END as nom_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier'' OR avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
        THEN avocat_3_civilite.libelle
        ELSE ''''
    END as civilite_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_nom
        ELSE
            CASE WHEN avocat_3.personne_morale_nom IS NOT NULL
                THEN avocat_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_prenom
        ELSE
            CASE WHEN avocat_3.personne_morale_prenom IS NOT NULL
                THEN avocat_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_raison_sociale
    END as raison_sociale_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_denomination
    END as denomination_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_siret
    END as siret_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_3,
    avocat_3.numero as numero_avocat_3,
    avocat_3.voie as voie_avocat_3,
    avocat_3.complement as complement_avocat_3,
    avocat_3.lieu_dit as lieu_dit_avocat_3,
    CASE 
        WHEN avocat_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_3.bp)
    END as bp_avocat_3,
    avocat_3.code_postal as code_postal_avocat_3,
    avocat_3.localite as localite_avocat_3,
    CASE 
        WHEN avocat_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_3.cedex)
    END as cedex_avocat_3,
    avocat_3.pays as pays_avocat_3,
    avocat_3.division_territoriale as division_territoriale_avocat_3,

    --Coordonnées de l''avocat 4

    CASE WHEN avocat_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_4_civilite.libelle, avocat_4.particulier_nom, avocat_4.particulier_prenom))
        ELSE
            CASE WHEN avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_4.personne_morale_raison_sociale, avocat_4.personne_morale_denomination, ''représenté(e) par'', avocat_4_civilite.libelle, avocat_4.personne_morale_nom, avocat_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_4.personne_morale_raison_sociale, '' '', avocat_4.personne_morale_denomination))
            END
    END as nom_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier'' OR avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
        THEN avocat_4_civilite.libelle
        ELSE ''''
    END as civilite_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_nom
        ELSE
            CASE WHEN avocat_4.personne_morale_nom IS NOT NULL
                THEN avocat_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_prenom
        ELSE
            CASE WHEN avocat_4.personne_morale_prenom IS NOT NULL
                THEN avocat_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_raison_sociale
    END as raison_sociale_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_denomination
    END as denomination_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_siret
    END as siret_avocat_4,
    avocat_4.numero as numero_avocat_4,
    avocat_4.voie as voie_avocat_4,
    avocat_4.complement as complement_avocat_4,
    avocat_4.lieu_dit as lieu_dit_avocat_4,
    CASE 
        WHEN avocat_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_4.bp)
    END as bp_avocat_4,
    avocat_4.code_postal as code_postal_avocat_4,
    avocat_4.localite as localite_avocat_4,
    CASE 
        WHEN avocat_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_4.cedex)
    END as cedex_avocat_4,
    avocat_4.pays as pays_avocat_4,
    avocat_4.division_territoriale as division_territoriale_avocat_4,

    --Coordonnées de l''avocat 5

    CASE WHEN avocat_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_5_civilite.libelle, avocat_5.particulier_nom, avocat_5.particulier_prenom))
        ELSE
            CASE WHEN avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_5.personne_morale_raison_sociale, avocat_5.personne_morale_denomination, ''représenté(e) par'', avocat_5_civilite.libelle, avocat_5.personne_morale_nom, avocat_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_5.personne_morale_raison_sociale, '' '', avocat_5.personne_morale_denomination))
            END
    END as nom_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier'' OR avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
        THEN avocat_5_civilite.libelle
        ELSE ''''
    END as civilite_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_nom
        ELSE
            CASE WHEN avocat_5.personne_morale_nom IS NOT NULL
                THEN avocat_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_prenom
        ELSE
            CASE WHEN avocat_5.personne_morale_prenom IS NOT NULL
                THEN avocat_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_raison_sociale
    END as raison_sociale_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_denomination
    END as denomination_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_siret
    END as siret_avocat_5,
    avocat_5.numero as numero_avocat_5,
    avocat_5.voie as voie_avocat_5,
    avocat_5.complement as complement_avocat_5,
    avocat_5.lieu_dit as lieu_dit_avocat_5,
    CASE 
        WHEN avocat_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_5.bp)
    END as bp_avocat_5,
    avocat_5.code_postal as code_postal_avocat_5,
    avocat_5.localite as localite_avocat_5,
    CASE 
        WHEN avocat_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_5.cedex)
    END as cedex_avocat_5,
    avocat_5.pays as pays_avocat_5,
    avocat_5.division_territoriale as division_territoriale_avocat_5,

    -- Coordonnées du délégataire
    CASE
        WHEN delegataire.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '',delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
                ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
            END
    END as nom_delegataire,
    CASE WHEN delegataire.qualite=''particulier'' OR delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
        THEN delegataire_civilite.libelle
        ELSE ''''
    END as civilite_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_nom
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL
                THEN delegataire.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_prenom
        ELSE
            CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_raison_sociale
    END as raison_sociale_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_denomination
    END as denomination_delegataire,
    delegataire.numero as numero_delegataire,
    delegataire.voie as voie_delegataire,
    delegataire.complement as complement_delegataire,
    delegataire.lieu_dit as lieu_dit_delegataire,
    CASE 
        WHEN delegataire.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', delegataire.bp)
    END as bp_delegataire,
    delegataire.code_postal as code_postal_delegataire,
    delegataire.localite as ville_delegataire,
    CASE 
        WHEN delegataire.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', delegataire.cedex)
    END as cedex_delegataire,
    delegataire.pays as pays_delegataire,

    -- CORRESPONDANT : destinataire du courrier. Il est le délégataire ou le pétitionnaire principal
    CASE
        WHEN delegataire.qualite IS NULL
        THEN
                CASE WHEN petitionnaire_principal.qualite=''particulier''
                    THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
                    ELSE
                        CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                            THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                            ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
                        END
                END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
                ELSE
                    CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                        THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
                        ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
                    END
            END
    END as nom_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier'' OR petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal_civilite.libelle
                ELSE ''''
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier'' OR delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire_civilite.libelle
                ELSE ''''
            END
    END as civilite_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN petitionnaire_principal.particulier_nom
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                        THEN petitionnaire_principal.personne_morale_nom
                        ELSE ''''
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN delegataire.particulier_nom
                ELSE
                    CASE WHEN delegataire.personne_morale_nom IS NOT NULL
                        THEN delegataire.personne_morale_nom
                        ELSE ''''
                    END
            END
    END as nom_particulier_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN petitionnaire_principal.particulier_prenom
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                        THEN petitionnaire_principal.personne_morale_prenom
                        ELSE ''''
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN delegataire.particulier_prenom
                ELSE
                    CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
                        THEN delegataire.personne_morale_prenom
                        ELSE ''''
                    END
            END
    END as prenom_particulier_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_raison_sociale
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_raison_sociale
            END
    END as raison_sociale_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_denomination
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_denomination
            END
    END as denomination_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.numero
        ELSE delegataire.numero
    END as numero_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.voie
        ELSE delegataire.voie
    END as voie_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.complement
        ELSE delegataire.complement
    END as complement_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.lieu_dit
        ELSE delegataire.lieu_dit
    END as lieu_dit_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN 
            CASE 
                WHEN petitionnaire_principal.bp IS NULL
                THEN ''''
                ELSE CONCAT(''BP '', petitionnaire_principal.bp)
            END
        ELSE 
            CASE 
                WHEN delegataire.bp IS NULL
                THEN ''''
                ELSE CONCAT(''BP '', delegataire.bp)
            END
    END as bp_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.code_postal
        ELSE delegataire.code_postal
    END as code_postal_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.localite
        ELSE delegataire.localite
    END as ville_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN 
            CASE 
                WHEN petitionnaire_principal.cedex IS NULL
                THEN ''''
                ELSE CONCAT(''CEDEX '', petitionnaire_principal.cedex)
            END
        ELSE 
            CASE 
                WHEN delegataire.cedex IS NULL
                THEN ''''
                ELSE CONCAT(''CEDEX '', delegataire.cedex)
            END
    END as cedex_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.pays
        ELSE delegataire.pays
    END as pays_correspondant,

    -- Dates importantes du dossier d''instruction
    to_char(dossier.date_depot, ''DD/MM/YYYY'') as date_depot_dossier,
    to_char(dossier.date_complet, ''DD/MM/YYYY'') as date_completude,
    to_char(dossier.date_dernier_depot, ''DD/MM/YYYY'') as date_dernier_depot,
    to_char(dossier.date_decision, ''DD/MM/YYYY'') as date_decision_dossier,
    CASE WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE 
        THEN to_char(dossier.date_limite_incompletude ,''DD/MM/YYYY'') 
        ELSE to_char(dossier.date_limite ,''DD/MM/YYYY'')
    END as date_limite_dossier,
    to_char(dossier.date_achevement,''DD/MM/YYYY'') as date_achevement_dossier,
    to_char(dossier.date_conformite,''DD/MM/YYYY'') as date_conformite_dossier,
    
    -- Données générales des données techniques
    donnees_techniques.co_projet_desc as co_projet_desc_donnees_techniques,
    donnees_techniques.am_projet_desc as am_projet_desc_donnees_techniques,
    donnees_techniques.dm_projet_desc as dm_projet_desc_donnees_techniques,
    donnees_techniques.ope_proj_desc as ope_proj_desc_donnees_techniques,
    TRIM(CONCAT(
        donnees_techniques.co_projet_desc, '' '',
        donnees_techniques.am_projet_desc, '' '',
        donnees_techniques.dm_projet_desc, '' '',
        donnees_techniques.ope_proj_desc
        )) as projet_desc_donnees_techniques,
    donnees_techniques.am_lot_max_nb as am_lot_max_nb_donnees_techniques,
    donnees_techniques.am_lot_max_shon as am_lot_max_shon_donnees_techniques,
        -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN donnees_techniques.su2_cstr_shon_tot
        ELSE donnees_techniques.su_cstr_shon_tot
    END as su_cstr_shon_tot_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN donnees_techniques.su2_demo_shon_tot
        ELSE donnees_techniques.su_demo_shon_tot
    END as su_demo_shon_tot_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN
            REGEXP_REPLACE(CONCAT(
                CASE WHEN donnees_techniques.su2_cstr_shon1 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Exploitation agricole - '', donnees_techniques.su2_cstr_shon1, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon2 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Exploitation forestière - '', donnees_techniques.su2_cstr_shon2, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon3 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Logement - '', donnees_techniques.su2_cstr_shon3, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon4 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Hébergement - '', donnees_techniques.su2_cstr_shon4, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon5 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Artisanat et commerce de détail - '', donnees_techniques.su2_cstr_shon5, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon6 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Restauration - '', donnees_techniques.su2_cstr_shon6, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon7 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Commerce de gros - '', donnees_techniques.su2_cstr_shon7, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon8 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Activités de services où s''''effectue l''''accueil d''''une clientèle - '', donnees_techniques.su2_cstr_shon8, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon9 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Hébergement hôtelier et touristique - '', donnees_techniques.su2_cstr_shon9, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon10 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Cinéma - '', donnees_techniques.su2_cstr_shon10, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon11 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Locaux et bureaux accueillant du public des administrations publiques et assimilés - '', donnees_techniques.su2_cstr_shon11, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon12 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Locaux techniques et industriels des administrations publiques et assimilés - '', donnees_techniques.su2_cstr_shon12, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon13 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Établissements d''''enseignement, de santé et d''''action sociale - '', donnees_techniques.su2_cstr_shon13, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon14 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Salles d''''art et de spectacles - '', donnees_techniques.su2_cstr_shon14, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon15 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Équipements sportifs - '', donnees_techniques.su2_cstr_shon15, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon16 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Autres équipements recevant du public - '', donnees_techniques.su2_cstr_shon16, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon17 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Industrie - '', donnees_techniques.su2_cstr_shon17, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon18 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Entrepôt - '', donnees_techniques.su2_cstr_shon18, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon19 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Bureau - '', donnees_techniques.su2_cstr_shon19, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon20 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Centre de congrès et d''''exposition - '', donnees_techniques.su2_cstr_shon20, '' m²'')
                END
            ), '' / $'', '''')
        ELSE
            REGEXP_REPLACE(CONCAT(
                CASE
                    WHEN donnees_techniques.su_cstr_shon1 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Habitation - '', donnees_techniques.su_cstr_shon1, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon2 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Hébergement hôtelier - '', donnees_techniques.su_cstr_shon2, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon3 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Bureaux - '', donnees_techniques.su_cstr_shon3, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon4 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Commerce - '', donnees_techniques.su_cstr_shon4, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon5 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Artisanat - '', donnees_techniques.su_cstr_shon5, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon6 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Industrie - '', donnees_techniques.su_cstr_shon6, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon7 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Exploitation agricole ou forestière - '', donnees_techniques.su_cstr_shon7, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon8 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Entrepôt - '', donnees_techniques.su_cstr_shon8, '' m² / '')
                END, 
                CASE
                    WHEN donnees_techniques.su_cstr_shon9 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Service public ou d''''intérêt collectif - '', donnees_techniques.su_cstr_shon9, '' m²'')
                END
            ), '' / $'', '''')
    END as tab_surface_donnees_techniques,
    donnees_techniques.co_tot_log_nb as co_tot_log_nb_donnees_techniques,
    donnees_techniques.co_statio_place_nb as co_statio_place_nb_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN donnees_techniques.su2_tot_shon_tot
        ELSE donnees_techniques.su_tot_shon_tot
    END as su_tot_shon_tot_donnees_techniques,

    -- Données techniques pour les AT
    CONCAT_WS('', '',
        CASE WHEN donnees_techniques.erp_cstr_neuve IS TRUE THEN ''construction neuve'' END,
        CASE WHEN donnees_techniques.erp_trvx_acc IS TRUE THEN ''travaux de mise en conformité totale aux règles d’accessibilité'' END,
        CASE WHEN donnees_techniques.erp_extension IS TRUE THEN ''extension'' END,
        CASE WHEN donnees_techniques.erp_rehab IS TRUE THEN ''réhabilitation'' END,
        CASE WHEN donnees_techniques.erp_trvx_am IS TRUE THEN ''travaux d’aménagement (remplacement de revêtements, rénovation électrique, création d’une rampe, par exemple)'' END,
        CASE WHEN donnees_techniques.erp_vol_nouv_exist IS TRUE THEN ''création de volumes nouveaux dans des volumes existants (modification du cloisonnement, par exemple)'' END
    ) as at_type_travaux,
    donnees_techniques.erp_public_eff_tot as at_effectif_public_total,
    CONCAT_WS('' - '', erp_categorie.libelle, erp_categorie.description) as at_categorie_etablissement,
    CONCAT_WS('' - '', erp_type.libelle, erp_type.description) as at_type_etablissement,

    -- Données techniques pour le contentieux
    objet_recours.libelle as ctx_objet_recours_libelle,
    donnees_techniques.ctx_reference_sagace as ctx_reference_sagace,
    donnees_techniques.ctx_nature_travaux_infra_om_html as ctx_nature_travaux_infra_om_html,
    donnees_techniques.ctx_synthese_nti as ctx_synthese_nti,
    donnees_techniques.ctx_article_non_resp_om_html as ctx_article_non_resp_om_html,
    donnees_techniques.ctx_synthese_anr as ctx_synthese_anr,
    donnees_techniques.ctx_reference_parquet as ctx_reference_parquet,
    donnees_techniques.ctx_element_taxation as ctx_element_taxation,
    CASE donnees_techniques.ctx_infraction WHEN ''t'' THEN ''Oui'' else ''Non'' end as ctx_infraction,
    CASE donnees_techniques.ctx_regularisable WHEN ''t'' THEN ''Oui'' else ''Non'' end as ctx_regularisable,
    donnees_techniques.ctx_reference_courrier as ctx_reference_courrier,
    to_char(donnees_techniques.ctx_date_audience, ''DD/MM/YYYY'') as date_audience_ctx,
    to_char(donnees_techniques.ctx_date_ajournement, ''DD/MM/YYYY'') as date_ajournement_ctx

FROM
    &DB_PREFIXEdossier
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''petitionnaire''
    ) as petitionnaire_principal
    ON petitionnaire_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as petitionnaire_principal_civilite
    ON
        petitionnaire_principal.particulier_civilite = petitionnaire_principal_civilite.civilite OR petitionnaire_principal.personne_morale_civilite = petitionnaire_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''contrevenant''
    ) as contrevenant_principal
    ON contrevenant_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as contrevenant_principal_civilite
    ON
        contrevenant_principal.particulier_civilite = contrevenant_principal_civilite.civilite OR contrevenant_principal.personne_morale_civilite = contrevenant_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''requerant''
    ) as requerant_principal
    ON requerant_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as requerant_principal_civilite
    ON
        requerant_principal.particulier_civilite = requerant_principal_civilite.civilite OR requerant_principal.personne_morale_civilite = requerant_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''avocat''
    ) as avocat_principal
    ON avocat_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as avocat_principal_civilite
    ON
        avocat_principal.particulier_civilite = avocat_principal_civilite.civilite OR avocat_principal.personne_morale_civilite = avocat_principal_civilite.civilite
LEFT JOIN
    (
    &DB_PREFIXElien_dossier_demandeur AS lien_dossier_delegataire
        JOIN &DB_PREFIXEdemandeur as delegataire
        ON
            lien_dossier_delegataire.demandeur = delegataire.demandeur AND delegataire.type_demandeur = ''delegataire''
    )
    ON
        dossier.dossier = lien_dossier_delegataire.dossier AND lien_dossier_delegataire.petitionnaire_principal IS FALSE
LEFT JOIN
    &DB_PREFIXEcivilite as delegataire_civilite
    ON
        delegataire.particulier_civilite = delegataire_civilite.civilite OR delegataire.personne_morale_civilite = delegataire_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS petitionnaire_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''petitionnaire''
    WHERE dossier.dossier = ''&idx''
    GROUP BY lien_dossier_demandeur.dossier
) as sub_petitionnaire_autre
ON dossier.dossier = sub_petitionnaire_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_1
    ON
        petitionnaire_1.demandeur = petitionnaire_autre[1] AND petitionnaire_1.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_1_civilite
    ON
        petitionnaire_1.particulier_civilite = petitionnaire_1_civilite.civilite OR petitionnaire_1.personne_morale_civilite = petitionnaire_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_2
    ON
        petitionnaire_2.demandeur = petitionnaire_autre[2] AND petitionnaire_2.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_2_civilite
    ON
        petitionnaire_2.particulier_civilite = petitionnaire_2_civilite.civilite OR petitionnaire_2.personne_morale_civilite = petitionnaire_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_3
    ON
        petitionnaire_3.demandeur = petitionnaire_autre[3] AND petitionnaire_3.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_3_civilite
    ON
        petitionnaire_3.particulier_civilite = petitionnaire_3_civilite.civilite OR petitionnaire_3.personne_morale_civilite = petitionnaire_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_4
    ON
        petitionnaire_4.demandeur = petitionnaire_autre[4] AND petitionnaire_4.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_4_civilite
    ON
        petitionnaire_4.particulier_civilite = petitionnaire_4_civilite.civilite OR petitionnaire_4.personne_morale_civilite = petitionnaire_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_5
    ON
        petitionnaire_5.demandeur = petitionnaire_autre[5] AND petitionnaire_5.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_5_civilite
    ON
        petitionnaire_5.particulier_civilite = petitionnaire_5_civilite.civilite OR petitionnaire_5.personne_morale_civilite = petitionnaire_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS contrevenant_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''contrevenant''
    WHERE dossier.dossier = ''&idx''
    GROUP BY lien_dossier_demandeur.dossier
) as sub_contrevenant_autre
ON dossier.dossier = sub_contrevenant_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_1
    ON
        contrevenant_1.demandeur = contrevenant_autre[1] AND contrevenant_1.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_1_civilite
    ON
        contrevenant_1.particulier_civilite = contrevenant_1_civilite.civilite OR contrevenant_1.personne_morale_civilite = contrevenant_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_2
    ON
        contrevenant_2.demandeur = contrevenant_autre[2] AND contrevenant_2.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_2_civilite
    ON
        contrevenant_2.particulier_civilite = contrevenant_2_civilite.civilite OR contrevenant_2.personne_morale_civilite = contrevenant_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_3
    ON
        contrevenant_3.demandeur = contrevenant_autre[3] AND contrevenant_3.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_3_civilite
    ON
        contrevenant_3.particulier_civilite = contrevenant_3_civilite.civilite OR contrevenant_3.personne_morale_civilite = contrevenant_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_4
    ON
        contrevenant_4.demandeur = contrevenant_autre[4] AND contrevenant_4.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_4_civilite
    ON
        contrevenant_4.particulier_civilite = contrevenant_4_civilite.civilite OR contrevenant_4.personne_morale_civilite = contrevenant_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_5
    ON
        contrevenant_5.demandeur = contrevenant_autre[5] AND contrevenant_5.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_5_civilite
    ON
        contrevenant_5.particulier_civilite = contrevenant_5_civilite.civilite OR contrevenant_5.personne_morale_civilite = contrevenant_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS requerant_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''requerant''
    WHERE dossier.dossier = ''&idx''
    GROUP BY lien_dossier_demandeur.dossier
) as sub_requerant_autre
ON dossier.dossier = sub_requerant_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_1
    ON
        requerant_1.demandeur = requerant_autre[1] AND requerant_1.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_1_civilite
    ON
        requerant_1.particulier_civilite = requerant_1_civilite.civilite OR requerant_1.personne_morale_civilite = requerant_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_2
    ON
        requerant_2.demandeur = requerant_autre[2] AND requerant_2.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_2_civilite
    ON
        requerant_2.particulier_civilite = requerant_2_civilite.civilite OR requerant_2.personne_morale_civilite = requerant_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_3
    ON
        requerant_3.demandeur = requerant_autre[3] AND requerant_3.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_3_civilite
    ON
        requerant_3.particulier_civilite = requerant_3_civilite.civilite OR requerant_3.personne_morale_civilite = requerant_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_4
    ON
        requerant_4.demandeur = requerant_autre[4] AND requerant_4.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_4_civilite
    ON
        requerant_4.particulier_civilite = requerant_4_civilite.civilite OR requerant_4.personne_morale_civilite = requerant_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_5
    ON
        requerant_5.demandeur = requerant_autre[5] AND requerant_5.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_5_civilite
    ON
        requerant_5.particulier_civilite = requerant_5_civilite.civilite OR requerant_5.personne_morale_civilite = requerant_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS avocat_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''avocat''
    WHERE dossier.dossier = ''&idx''
    GROUP BY lien_dossier_demandeur.dossier
) as sub_avocat_autre
ON dossier.dossier = sub_avocat_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_1
    ON
        avocat_1.demandeur = avocat_autre[1] AND avocat_1.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_1_civilite
    ON
        avocat_1.particulier_civilite = avocat_1_civilite.civilite OR avocat_1.personne_morale_civilite = avocat_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_2
    ON
        avocat_2.demandeur = avocat_autre[2] AND avocat_2.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_2_civilite
    ON
        avocat_2.particulier_civilite = avocat_2_civilite.civilite OR avocat_2.personne_morale_civilite = avocat_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_3
    ON
        avocat_3.demandeur = avocat_autre[3] AND avocat_3.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_3_civilite
    ON
        avocat_3.particulier_civilite = avocat_3_civilite.civilite OR avocat_3.personne_morale_civilite = avocat_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_4
    ON
        avocat_4.demandeur = avocat_autre[4] AND avocat_4.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_4_civilite
    ON
        avocat_4.particulier_civilite = avocat_4_civilite.civilite OR avocat_4.personne_morale_civilite = avocat_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_5
    ON
        avocat_5.demandeur = avocat_autre[5] AND avocat_5.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_5_civilite
    ON
        avocat_5.particulier_civilite = avocat_5_civilite.civilite OR avocat_5.personne_morale_civilite = avocat_5_civilite.civilite
LEFT JOIN
    &DB_PREFIXEdossier_instruction_type
    ON
        dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
LEFT JOIN
    &DB_PREFIXEdossier_autorisation
    ON
        dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
LEFT JOIN
    &DB_PREFIXEdossier_autorisation_type_detaille
    ON
        dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
LEFT JOIN
    &DB_PREFIXEdossier_autorisation_type
    ON
        dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
LEFT JOIN
    &DB_PREFIXEinstructeur
    ON
        dossier.instructeur = instructeur.instructeur
LEFT JOIN
    &DB_PREFIXEinstructeur as instructeur_2
    ON
        dossier.instructeur_2 = instructeur_2.instructeur
LEFT JOIN
    &DB_PREFIXEom_utilisateur
    ON
        om_utilisateur.om_utilisateur = instructeur.om_utilisateur
LEFT JOIN
    &DB_PREFIXEom_utilisateur as om_utilisateur_2
    ON
        om_utilisateur_2.om_utilisateur = instructeur_2.om_utilisateur
LEFT JOIN
    &DB_PREFIXEdivision
    ON
        instructeur.division = division.division
LEFT JOIN
    &DB_PREFIXEdivision as division_2
    ON
        instructeur_2.division = division_2.division
LEFT JOIN
    &DB_PREFIXEdirection
    ON
        division.direction = direction.direction
LEFT JOIN
    &DB_PREFIXEarrondissement
    ON
        dossier.terrain_adresse_code_postal = arrondissement.code_postal
LEFT JOIN
    &DB_PREFIXEavis_decision
    ON
        dossier.avis_decision = avis_decision.avis_decision
LEFT JOIN
    &DB_PREFIXEetat
    ON
        dossier.etat = etat.etat
LEFT JOIN
    &DB_PREFIXEdonnees_techniques
    ON
    dossier.dossier = donnees_techniques.dossier_instruction
LEFT JOIN
    &DB_PREFIXEarchitecte
    ON
    donnees_techniques.architecte = architecte.architecte
LEFT JOIN
    &DB_PREFIXEtaxe_amenagement
    ON
        dossier.om_collectivite = taxe_amenagement.om_collectivite
LEFT JOIN
    &DB_PREFIXEerp_categorie
    ON
        donnees_techniques.erp_class_cat = erp_categorie.erp_categorie
LEFT JOIN
    &DB_PREFIXEerp_type
    ON
        donnees_techniques.erp_class_type = erp_type.erp_type
LEFT JOIN
    &DB_PREFIXEobjet_recours
    ON
        donnees_techniques.ctx_objet_recours = objet_recours.objet_recours
WHERE dossier.dossier = ''&idx''',
merge_fields = '-- Données générales du dossier d''instruction
[libelle_dossier]    [code_barres_dossier]
[etat_dossier]    [libelle_da]
[code_datd]    [libelle_datd]
[code_dat]    [libelle_dat]
[code_dit]    [libelle_dit]
[delai_dossier]
[terrain_references_cadastrales_dossier]
[libelle_avis_decision]

-- Données contentieux du dossier d''instruction
[autorisation_contestee]
[date_cloture_instruction_dossier]
[date_premiere_visite_dossier]
[date_derniere_visite_dossier]
[date_contradictoire_dossier]
[date_retour_contradictoire_dossier]
[date_ait_dossier]
[date_transmission_parquet_dossier]

-- Coordonnées de l''instructeur
[nom_instructeur]
[telephone_instructeur]
[division_instructeur]
[email_instructeur]

-- Coordonnées de l''instructeur 2
[nom_instructeur_2]
[telephone_instructeur_2]
[division_instructeur_2]
[email_instructeur_2]

-- Noms des signataires
[division_chef]
[direction_chef]
[libelle_direction]
[description_direction]

-- Adresse du terrain du dossier d''instruction
[terrain_adresse_voie_numero_dossier]    [terrain_adresse_voie_dossier]
[terrain_adresse_lieu_dit_dossier]    [terrain_adresse_bp_dossier]
[terrain_adresse_code_postal_dossier]    [terrain_adresse_localite_dossier]    [terrain_adresse_cedex_dossier]
[libelle_arrondissement]

-- Nom et prénom de l''architecte
[architecte]

--Taxe d''aménagement du dossier d''instruction
[tax_taux_secteur]
[tax_numero_secteur]
[tax_montant_part_communale]
[tax_montant_part_departementale]
[tax_montant_part_regionale]
[tax_montant_total]

--Coordonnées du pétitionnaire principal
[nom_petitionnaire_principal]
[civilite_petitionnaire_principal]
[nom_particulier_petitionnaire_principal]
[prenom_particulier_petitionnaire_principal]
[raison_sociale_petitionnaire_principal]
[denomination_petitionnaire_principal]
[siret_petitionnaire_principal]
[categorie_juridique_petitionnaire_principal]
[numero_petitionnaire_principal]    [voie_petitionnaire_principal]    [complement_petitionnaire_principal]
[lieu_dit_petitionnaire_principal]    [bp_petitionnaire_principal]
[code_postal_petitionnaire_principal]    [localite_petitionnaire_principal]    [cedex_petitionnaire_principal]
[pays_petitionnaire_principal] [division_territoriale_petitionnaire_principal]

--Coordonnées des autres pétitionnaires
[nom_petitionnaire_1](jusqu''à 5)
[civilite_petitionnaire_1](jusqu''à 5)
[nom_particulier_petitionnaire_1](jusqu''à 5)
[prenom_particulier_petitionnaire_1](jusqu''à 5)
[raison_sociale_petitionnaire_1](jusqu''à 5)
[denomination_petitionnaire_1](jusqu''à 5)
[siret_petitionnaire_1](jusqu''à 5)
[categorie_juridique_petitionnaire_1](jusqu''à 5)
[numero_petitionnaire_1](jusqu''à 5)    [voie_petitionnaire_1](jusqu''à 5)
[complement_petitionnaire_1](jusqu''à 5)
[lieu_dit_petitionnaire_1](jusqu''à 5)    [bp_petitionnaire_1](jusqu''à 5)
[code_postal_petitionnaire_1](jusqu''à 5)    [localite_petitionnaire_1](jusqu''à 5)
[cedex_petitionnaire_1](jusqu''à 5)
[pays_petitionnaire_1](jusqu''à 5) [division_territoriale_petitionnaire_1](jusqu''à 5)

--Coordonnées du contrevenant principal
[nom_contrevenant_principal]
[civilite_contrevenant_principal]
[nom_particulier_contrevenant_principal]
[prenom_particulier_contrevenant_principal]
[raison_sociale_contrevenant_principal]
[denomination_contrevenant_principal]
[siret_contrevenant_principal]
[categorie_juridique_contrevenant_principal]
[numero_contrevenant_principal]    [voie_contrevenant_principal]    [complement_contrevenant_principal]
[lieu_dit_contrevenant_principal]    [bp_contrevenant_principal]
[code_postal_contrevenant_principal]    [localite_contrevenant_principal]    [cedex_contrevenant_principal]
[pays_contrevenant_principal] [division_territoriale_contrevenant_principal]

--Coordonnées des autres contrevenants
[nom_contrevenant_1](jusqu''à 5)
[civilite_contrevenant_1](jusqu''à 5)
[nom_particulier_contrevenant_1](jusqu''à 5)
[prenom_particulier_contrevenant_1](jusqu''à 5)
[raison_sociale_contrevenant_1](jusqu''à 5)
[denomination_contrevenant_1](jusqu''à 5)
[siret_contrevenant_1](jusqu''à 5)
[categorie_juridique_contrevenant_1](jusqu''à 5)
[numero_contrevenant_1](jusqu''à 5)    [voie_contrevenant_1](jusqu''à 5)
[complement_contrevenant_1](jusqu''à 5)
[lieu_dit_contrevenant_1](jusqu''à 5)    [bp_contrevenant_1](jusqu''à 5)
[code_postal_contrevenant_1](jusqu''à 5)    [localite_contrevenant_1](jusqu''à 5)
[cedex_contrevenant_1](jusqu''à 5)
[pays_contrevenant_1](jusqu''à 5) [division_territoriale_contrevenant_1](jusqu''à 5)

--Coordonnées du requérant principal
[nom_requerant_principal]
[civilite_requerant_principal]
[nom_particulier_requerant_principal]
[prenom_particulier_requerant_principal]
[raison_sociale_requerant_principal]
[denomination_requerant_principal]
[siret_requerant_principal]
[categorie_juridique_requerant_principal]
[numero_requerant_principal]    [voie_requerant_principal]    [complement_requerant_principal]
[lieu_dit_requerant_principal]    [bp_requerant_principal]
[code_postal_requerant_principal]    [localite_requerant_principal]    [cedex_requerant_principal]
[pays_requerant_principal] [division_territoriale_requerant_principal]

--Coordonnées des autres requérants
[nom_requerant_1](jusqu''à 5)
[civilite_requerant_1](jusqu''à 5)
[nom_particulier_requerant_1](jusqu''à 5)
[prenom_particulier_requerant_1](jusqu''à 5)
[raison_sociale_requerant_1](jusqu''à 5)
[denomination_requerant_1](jusqu''à 5)
[siret_requerant_1](jusqu''à 5)
[categorie_juridique_requerant_1](jusqu''à 5)
[numero_requerant_1](jusqu''à 5)    [voie_requerant_1](jusqu''à 5)
[complement_requerant_1](jusqu''à 5)
[lieu_dit_requerant_1](jusqu''à 5)    [bp_requerant_1](jusqu''à 5)
[code_postal_requerant_1](jusqu''à 5)    [localite_requerant_1](jusqu''à 5)
[cedex_requerant_1](jusqu''à 5)
[pays_requerant_1](jusqu''à 5) [division_territoriale_requerant_1](jusqu''à 5)

--Coordonnées de l''avocat principal
[nom_avocat_principal]
[civilite_avocat_principal]
[nom_particulier_avocat_principal]
[prenom_particulier_avocat_principal]
[raison_sociale_avocat_principal]
[denomination_avocat_principal]
[siret_avocat_principal]
[categorie_juridique_avocat_principal]
[numero_avocat_principal]    [voie_avocat_principal]    [complement_avocat_principal]
[lieu_dit_avocat_principal]    [bp_avocat_principal]
[code_postal_avocat_principal]    [localite_avocat_principal]    [cedex_avocat_principal]
[pays_avocat_principal] [division_territoriale_avocat_principal]

--Coordonnées des autres avocats
[nom_avocat_1](jusqu''à 5)
[civilite_avocat_1](jusqu''à 5)
[nom_particulier_avocat_1](jusqu''à 5)
[prenom_particulier_avocat_1](jusqu''à 5)
[raison_sociale_avocat_1](jusqu''à 5)
[denomination_avocat_1](jusqu''à 5)
[siret_avocat_1](jusqu''à 5)
[categorie_juridique_avocat_1](jusqu''à 5)
[numero_avocat_1](jusqu''à 5)    [voie_avocat_1](jusqu''à 5)
[complement_avocat_1](jusqu''à 5)
[lieu_dit_avocat_1](jusqu''à 5)    [bp_avocat_1](jusqu''à 5)
[code_postal_avocat_1](jusqu''à 5)    [localite_avocat_1](jusqu''à 5)
[cedex_avocat_1](jusqu''à 5)
[pays_avocat_1](jusqu''à 5) [division_territoriale_avocat_1](jusqu''à 5)

-- Coordonnées du délégataire
[nom_delegataire]
[civilite_delegataire]
[nom_particulier_delegataire]
[prenom_particulier_delegataire]
[raison_sociale_delegataire]
[denomination_delegataire]
[numero_delegataire]    [voie_delegataire]    [complement_delegataire]
[lieu_dit_delegataire]    [bp_delegataire]
[code_postal_delegataire]    [ville_delegataire]    [cedex_delegataire]
[pays_delegataire]

-- CORRESPONDANT : destinataire du courrier. Il est le délégataire ou le pétitionnaire principal
[nom_correspondant]
[civilite_correspondant]
[nom_particulier_correspondant]
[prenom_particulier_correspondant]
[raison_sociale_correspondant]
[denomination_correspondant]
[numero_correspondant]    [voie_correspondant]    [complement_correspondant]
[lieu_dit_correspondant]    [bp_correspondant]
[code_postal_correspondant]    [ville_correspondant]    [cedex_correspondant]
[pays_correspondant]

-- Dates importantes du dossier d''instruction
[date_depot_dossier]
[date_completude]
[date_dernier_depot]
[date_decision_dossier]
[date_limite_dossier]
[date_achevement_dossier]
[date_conformite_dossier]

-- Données générales des données techniques
[co_projet_desc_donnees_techniques]    [am_projet_desc_donnees_techniques]
[dm_projet_desc_donnees_techniques]    [ope_proj_desc_donnees_techniques]
[projet_desc_donnees_techniques]
[co_tot_log_nb_donnees_techniques]    [co_statio_place_nb_donnees_techniques]
[am_lot_max_nb_donnees_techniques]    [am_lot_max_shon_donnees_techniques]
-- Les données techniques suivantes concernent le tableau des surfaces
-- Elles récupèrent les valeurs du tableau composé des sous-destinations si au
-- moins une valeur de celui-ci est saisie
[su_cstr_shon_tot_donnees_techniques]    [su_demo_shon_tot_donnees_techniques]
[tab_surface_donnees_techniques]
[su_tot_shon_tot_donnees_techniques]

--Données techniques des AT
[at_type_travaux]
[at_effectif_public_total]
[at_categorie_etablissement]
[at_type_etablissement]

--Données techniques du contentieux
[ctx_objet_recours_libelle]
[ctx_reference_sagace]
[ctx_nature_travaux_infra_om_html]
[ctx_synthese_nti]
[ctx_article_non_resp_om_html]
[ctx_synthese_anr]
[ctx_reference_parquet]
[ctx_element_taxation]
[ctx_infraction]
[ctx_regularisable]
[ctx_reference_courrier]
[date_audience_ctx]
[date_ajournement_ctx]
'
WHERE code = 'dossier';


-- 2/2 - Récapitulatif du dossier d'instruction / instruction

UPDATE om_requete SET
requete = 'SELECT

    --Données générales de l''événement d''instruction
    
    instruction.complement_om_html as complement_instruction,
    instruction.complement_om_html as complement1_instruction,
    instruction.complement2_om_html as complement2_instruction,
    instruction.complement3_om_html as complement3_instruction,
    instruction.complement4_om_html as complement4_instruction,
    instruction.code_barres as code_barres_instruction,
    to_char(instruction.date_evenement,''DD/MM/YYYY'') as date_evenement_instruction, 
    om_lettretype.libelle as libelle_om_lettretype,
    instruction.archive_delai as archive_delai_instruction,

    --Données générales du dossier d''instruction

    dossier.dossier_libelle as libelle_dossier,
    dossier.dossier as code_barres_dossier,
    dossier_autorisation.dossier_autorisation_libelle as libelle_da,

    dossier_autorisation_type_detaille.code as code_datd,
    dossier_autorisation_type_detaille.libelle as libelle_datd,
    dossier_autorisation_type.code as code_dat,
    dossier_autorisation_type.libelle as libelle_dat,
    dossier_instruction_type.code as code_dit,
    dossier_instruction_type.libelle as libelle_dit,
    dossier.delai as delai_dossier,
    to_char(dossier_autorisation.date_decision, ''DD/MM/YYYY'') as date_decision_da,
    replace(dossier.terrain_references_cadastrales, '';'', '' '') as terrain_references_cadastrales_dossier,
    dossier.terrain_superficie as terrain_superficie_dossier,
    quartier.libelle as libelle_quartier,

    avis_decision.libelle as libelle_avis_decision,

    dossier_autorisation.cle_acces_citoyen,

    -- Données contentieux du dossier d''instruction
    dossier.autorisation_contestee as autorisation_contestee,
    to_char(dossier.date_cloture_instruction, ''DD/MM/YYYY'') as date_cloture_instruction_dossier,
    to_char(dossier.date_premiere_visite, ''DD/MM/YYYY'') as date_premiere_visite_dossier,
    to_char(dossier.date_derniere_visite, ''DD/MM/YYYY'') as date_derniere_visite_dossier,
    to_char(dossier.date_contradictoire, ''DD/MM/YYYY'') as date_contradictoire_dossier,
    to_char(dossier.date_retour_contradictoire, ''DD/MM/YYYY'') as date_retour_contradictoire_dossier,
    to_char(dossier.date_ait, ''DD/MM/YYYY'') as date_ait_dossier,
    to_char(dossier.date_transmission_parquet, ''DD/MM/YYYY'') as date_transmission_parquet_dossier,

    --Données générales du paramétrage de l''événement

    evenement.libelle as libelle_evenement,
    evenement.etat as etat_evenement,
    evenement.delai as delai_evenement,
    evenement.accord_tacite as accord_tacite_evenement,
    evenement.delai_notification as delai_notification_evenement,
    evenement.avis_decision as avis_decision_evenement,
    evenement.autorite_competente as autorite_competente_evenement,

    --Coordonnées de l''instructeur

    instructeur.nom as nom_instructeur,
    instructeur.telephone as telephone_instructeur,
    division.code as division_instructeur,
    om_utilisateur.email as email_instructeur,

    -- Coordonnées de l''instructeur 2
    instructeur_2.nom as nom_instructeur_2,
    instructeur_2.telephone as telephone_instructeur_2,
    division_2.code as division_instructeur_2,
    om_utilisateur_2.email as email_instructeur_2,

    --Adresse du terrain du dossier d''instruction

    dossier.terrain_adresse_voie_numero as terrain_adresse_voie_numero_dossier,
    dossier.terrain_adresse_voie as terrain_adresse_voie_dossier,
    dossier.terrain_adresse_lieu_dit as terrain_adresse_lieu_dit_dossier,
    CASE 
        WHEN dossier.terrain_adresse_bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', dossier.terrain_adresse_bp)
    END as terrain_adresse_bp_dossier,
    dossier.terrain_adresse_code_postal as terrain_adresse_code_postal_dossier,
    dossier.terrain_adresse_localite as terrain_adresse_localite_dossier,
    CASE 
        WHEN dossier.terrain_adresse_cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', dossier.terrain_adresse_cedex)
    END as terrain_adresse_cedex_dossier,

    arrondissement.libelle as libelle_arrondissement,

    --Taxe d''aménagement du dossier d''instruction

    CASE
        WHEN tax_secteur = 1 THEN taxe_amenagement.tx_comm_secteur_1
        WHEN tax_secteur = 2 THEN taxe_amenagement.tx_comm_secteur_2
        WHEN tax_secteur = 3 THEN taxe_amenagement.tx_comm_secteur_3
        WHEN tax_secteur = 4 THEN taxe_amenagement.tx_comm_secteur_4
        WHEN tax_secteur = 5 THEN taxe_amenagement.tx_comm_secteur_5
        WHEN tax_secteur = 6 THEN taxe_amenagement.tx_comm_secteur_6
        WHEN tax_secteur = 7 THEN taxe_amenagement.tx_comm_secteur_7
        WHEN tax_secteur = 8 THEN taxe_amenagement.tx_comm_secteur_8
        WHEN tax_secteur = 9 THEN taxe_amenagement.tx_comm_secteur_9
        WHEN tax_secteur = 10 THEN taxe_amenagement.tx_comm_secteur_10
        WHEN tax_secteur = 11 THEN taxe_amenagement.tx_comm_secteur_11
        WHEN tax_secteur = 12 THEN taxe_amenagement.tx_comm_secteur_12
        WHEN tax_secteur = 13 THEN taxe_amenagement.tx_comm_secteur_13
        WHEN tax_secteur = 14 THEN taxe_amenagement.tx_comm_secteur_14
        WHEN tax_secteur = 15 THEN taxe_amenagement.tx_comm_secteur_15
        WHEN tax_secteur = 16 THEN taxe_amenagement.tx_comm_secteur_16
        WHEN tax_secteur = 17 THEN taxe_amenagement.tx_comm_secteur_17
        WHEN tax_secteur = 18 THEN taxe_amenagement.tx_comm_secteur_18
        WHEN tax_secteur = 19 THEN taxe_amenagement.tx_comm_secteur_19
        WHEN tax_secteur = 20 THEN taxe_amenagement.tx_comm_secteur_20
    END as tax_taux_secteur,
    dossier.tax_secteur as tax_numero_secteur,
    dossier.tax_mtn_part_commu as tax_montant_part_communale,
    dossier.tax_mtn_part_depart as tax_montant_part_departementale,
    dossier.tax_mtn_part_reg as tax_montant_part_regionale,
    dossier.tax_mtn_total as tax_montant_total,

    --Coordonnées du pétitionnaire principal

    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
            END
    END as nom_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier'' OR petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_nom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_denomination
    END as denomination_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_siret
    END as siret_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_principal,
    petitionnaire_principal.numero as numero_petitionnaire_principal,
    petitionnaire_principal.voie as voie_petitionnaire_principal,
    petitionnaire_principal.complement as complement_petitionnaire_principal,
    petitionnaire_principal.lieu_dit as lieu_dit_petitionnaire_principal,
    CASE 
        WHEN petitionnaire_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_principal.bp)
    END as bp_petitionnaire_principal,
    petitionnaire_principal.code_postal as code_postal_petitionnaire_principal,
    petitionnaire_principal.localite as localite_petitionnaire_principal,
    CASE 
        WHEN petitionnaire_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_principal.cedex)
    END as cedex_petitionnaire_principal,
    petitionnaire_principal.pays as pays_petitionnaire_principal,
    petitionnaire_principal.division_territoriale as division_territoriale_petitionnaire_principal,

    --Coordonnées du pétitionnaire principal initial

    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_initial_civilite.libelle, petitionnaire_principal_initial.particulier_nom, petitionnaire_principal_initial.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_principal_initial.personne_morale_nom IS NOT NULL OR petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_initial.personne_morale_raison_sociale, petitionnaire_principal_initial.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_initial_civilite.libelle, petitionnaire_principal_initial.personne_morale_nom, petitionnaire_principal_initial.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_principal_initial.personne_morale_raison_sociale, '' '', petitionnaire_principal_initial.personne_morale_denomination))
            END
    END as nom_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier'' OR petitionnaire_principal_initial.personne_morale_nom IS NOT NULL OR petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_initial_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN petitionnaire_principal_initial.particulier_nom
        ELSE
            CASE WHEN petitionnaire_principal_initial.personne_morale_nom IS NOT NULL
                THEN petitionnaire_principal_initial.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN petitionnaire_principal_initial.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal_initial.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal_initial.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal_initial.personne_morale_denomination
    END as denomination_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal_initial.personne_morale_siret
    END as siret_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal_initial.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_principal_initial,

    petitionnaire_principal_initial.numero as numero_petitionnaire_principal_initial,
    petitionnaire_principal_initial.voie as voie_petitionnaire_principal_initial,
    petitionnaire_principal_initial.complement as complement_petitionnaire_principal_initial,
    petitionnaire_principal_initial.lieu_dit as lieu_dit_petitionnaire_principal_initial,
    CASE 
        WHEN petitionnaire_principal_initial.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_principal_initial.bp)
    END as bp_petitionnaire_principal_initial,
    petitionnaire_principal_initial.code_postal as code_postal_petitionnaire_principal_initial,
    petitionnaire_principal_initial.localite as localite_petitionnaire_principal_initial,
    CASE 
        WHEN petitionnaire_principal_initial.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_principal_initial.cedex)
    END as cedex_petitionnaire_principal_initial,
    petitionnaire_principal_initial.pays as pays_petitionnaire_principal,
    petitionnaire_principal_initial.division_territoriale as division_territoriale_petitionnaire_principal,

    --Coordonnées du pétitionnaire 1

    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_1_civilite.libelle, petitionnaire_1.particulier_nom, petitionnaire_1.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_1.personne_morale_raison_sociale, petitionnaire_1.personne_morale_denomination, ''représenté(e) par'', petitionnaire_1_civilite.libelle, petitionnaire_1.personne_morale_nom, petitionnaire_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_1.personne_morale_raison_sociale, '' '', petitionnaire_1.personne_morale_denomination))
            END
    END as nom_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier'' OR petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_1_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_nom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL
                THEN petitionnaire_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_denomination
    END as denomination_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_siret
    END as siret_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_1,
    petitionnaire_1.numero as numero_petitionnaire_1,
    petitionnaire_1.voie as voie_petitionnaire_1,
    petitionnaire_1.complement as complement_petitionnaire_1,
    petitionnaire_1.lieu_dit as lieu_dit_petitionnaire_1,
    CASE 
        WHEN petitionnaire_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_1.bp)
    END as bp_petitionnaire_1,
    petitionnaire_1.code_postal as code_postal_petitionnaire_1,
    petitionnaire_1.localite as localite_petitionnaire_1,
    CASE 
        WHEN petitionnaire_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_1.cedex)
    END as cedex_petitionnaire_1,
    petitionnaire_1.pays as pays_petitionnaire_1,
    petitionnaire_1.division_territoriale as division_territoriale_petitionnaire_1,

    --Coordonnées du pétitionnaire 2

    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_2_civilite.libelle, petitionnaire_2.particulier_nom, petitionnaire_2.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_2.personne_morale_raison_sociale, petitionnaire_2.personne_morale_denomination, ''représenté(e) par'', petitionnaire_2_civilite.libelle, petitionnaire_2.personne_morale_nom, petitionnaire_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_2.personne_morale_raison_sociale, '' '', petitionnaire_2.personne_morale_denomination))
            END
    END as nom_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier'' OR petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_2_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_nom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL
                THEN petitionnaire_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_denomination
    END as denomination_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_siret
    END as siret_petitionnaire_2,
    petitionnaire_2.numero as numero_petitionnaire_2,
    petitionnaire_2.voie as voie_petitionnaire_2,
    petitionnaire_2.complement as complement_petitionnaire_2,
    petitionnaire_2.lieu_dit as lieu_dit_petitionnaire_2,
    CASE 
        WHEN petitionnaire_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_2.bp)
    END as bp_petitionnaire_2,
    petitionnaire_2.code_postal as code_postal_petitionnaire_2,
    petitionnaire_2.localite as localite_petitionnaire_2,
    CASE 
        WHEN petitionnaire_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_2.cedex)
    END as cedex_petitionnaire_2,
    petitionnaire_2.pays as pays_petitionnaire_2,
    petitionnaire_2.division_territoriale as division_territoriale_petitionnaire_2,

    --Coordonnées du pétitionnaire 3

    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_3_civilite.libelle, petitionnaire_3.particulier_nom, petitionnaire_3.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_3.personne_morale_raison_sociale, petitionnaire_3.personne_morale_denomination, ''représenté(e) par'', petitionnaire_3_civilite.libelle, petitionnaire_3.personne_morale_nom, petitionnaire_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_3.personne_morale_raison_sociale, '' '', petitionnaire_3.personne_morale_denomination))
            END
    END as nom_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier'' OR petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_3_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_nom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL
                THEN petitionnaire_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_denomination
    END as denomination_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_siret
    END as siret_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_3,
    petitionnaire_3.numero as numero_petitionnaire_3,
    petitionnaire_3.voie as voie_petitionnaire_3,
    petitionnaire_3.complement as complement_petitionnaire_3,
    petitionnaire_3.lieu_dit as lieu_dit_petitionnaire_3,
    CASE 
        WHEN petitionnaire_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_3.bp)
    END as bp_petitionnaire_3,
    petitionnaire_3.code_postal as code_postal_petitionnaire_3,
    petitionnaire_3.localite as localite_petitionnaire_3,
    CASE 
        WHEN petitionnaire_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_3.cedex)
    END as cedex_petitionnaire_3,
    petitionnaire_3.pays as pays_petitionnaire_3,
    petitionnaire_3.division_territoriale as division_territoriale_petitionnaire_3,

    --Coordonnées du pétitionnaire 4

    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_4_civilite.libelle, petitionnaire_4.particulier_nom, petitionnaire_4.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_4.personne_morale_raison_sociale, petitionnaire_4.personne_morale_denomination, ''représenté(e) par'', petitionnaire_4_civilite.libelle, petitionnaire_4.personne_morale_nom, petitionnaire_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_4.personne_morale_raison_sociale, '' '', petitionnaire_4.personne_morale_denomination))
            END
    END as nom_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier'' OR petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_4_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_nom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL
                THEN petitionnaire_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_denomination
    END as denomination_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_siret
    END as siret_petitionnaire_4,
    petitionnaire_4.numero as numero_petitionnaire_4,
    petitionnaire_4.voie as voie_petitionnaire_4,
    petitionnaire_4.complement as complement_petitionnaire_4,
    petitionnaire_4.lieu_dit as lieu_dit_petitionnaire_4,
    CASE 
        WHEN petitionnaire_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_4.bp)
    END as bp_petitionnaire_4,
    petitionnaire_4.code_postal as code_postal_petitionnaire_4,
    petitionnaire_4.localite as localite_petitionnaire_4,
    CASE 
        WHEN petitionnaire_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_4.cedex)
    END as cedex_petitionnaire_4,
    petitionnaire_4.pays as pays_petitionnaire_4,
    petitionnaire_4.division_territoriale as division_territoriale_petitionnaire_4,

    --Coordonnées du pétitionnaire 5

    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_5_civilite.libelle, petitionnaire_5.particulier_nom, petitionnaire_5.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_5.personne_morale_raison_sociale, petitionnaire_5.personne_morale_denomination, ''représenté(e) par'', petitionnaire_5_civilite.libelle, petitionnaire_5.personne_morale_nom, petitionnaire_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_5.personne_morale_raison_sociale, '' '', petitionnaire_5.personne_morale_denomination))
            END
    END as nom_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier'' OR petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_5_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_nom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL
                THEN petitionnaire_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_denomination
    END as denomination_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_siret
    END as siret_petitionnaire_5,
    petitionnaire_5.numero as numero_petitionnaire_5,
    petitionnaire_5.voie as voie_petitionnaire_5,
    petitionnaire_5.complement as complement_petitionnaire_5,
    petitionnaire_5.lieu_dit as lieu_dit_petitionnaire_5,
    CASE 
        WHEN petitionnaire_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_5.bp)
    END as bp_petitionnaire_5,
    petitionnaire_5.code_postal as code_postal_petitionnaire_5,
    petitionnaire_5.localite as localite_petitionnaire_5,
    CASE 
        WHEN petitionnaire_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_5.cedex)
    END as cedex_petitionnaire_5,
    petitionnaire_5.pays as pays_petitionnaire_5,
    petitionnaire_5.division_territoriale as division_territoriale_petitionnaire_5,

    --Coordonnées du contrevenant principal

    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_principal_civilite.libelle, contrevenant_principal.particulier_nom, contrevenant_principal.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_principal.personne_morale_raison_sociale, contrevenant_principal.personne_morale_denomination, ''représenté(e) par'', contrevenant_principal_civilite.libelle, contrevenant_principal.personne_morale_nom, contrevenant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_principal.personne_morale_raison_sociale, '' '', contrevenant_principal.personne_morale_denomination))
            END
    END as nom_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier'' OR contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
        THEN contrevenant_principal_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_nom
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL
                THEN contrevenant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_prenom
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_prenom IS NOT NULL
                THEN contrevenant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_denomination
    END as denomination_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_siret
    END as siret_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_principal,
    contrevenant_principal.numero as numero_contrevenant_principal,
    contrevenant_principal.voie as voie_contrevenant_principal,
    contrevenant_principal.complement as complement_contrevenant_principal,
    contrevenant_principal.lieu_dit as lieu_dit_contrevenant_principal,
    CASE 
        WHEN contrevenant_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_principal.bp)
    END as bp_contrevenant_principal,
    contrevenant_principal.code_postal as code_postal_contrevenant_principal,
    contrevenant_principal.localite as localite_contrevenant_principal,
    CASE 
        WHEN contrevenant_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_principal.cedex)
    END as cedex_contrevenant_principal,
    contrevenant_principal.pays as pays_contrevenant_principal,
    contrevenant_principal.division_territoriale as division_territoriale_contrevenant_principal,

    --Coordonnées du contrevenant 1

    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_1_civilite.libelle, contrevenant_1.particulier_nom, contrevenant_1.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_1.personne_morale_raison_sociale, contrevenant_1.personne_morale_denomination, ''représenté(e) par'', contrevenant_1_civilite.libelle, contrevenant_1.personne_morale_nom, contrevenant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_1.personne_morale_raison_sociale, '' '', contrevenant_1.personne_morale_denomination))
            END
    END as nom_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier'' OR contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
        THEN contrevenant_1_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_nom
        ELSE
            CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL
                THEN contrevenant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_prenom
        ELSE
            CASE WHEN contrevenant_1.personne_morale_prenom IS NOT NULL
                THEN contrevenant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_denomination
    END as denomination_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_siret
    END as siret_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_1,
    contrevenant_1.numero as numero_contrevenant_1,
    contrevenant_1.voie as voie_contrevenant_1,
    contrevenant_1.complement as complement_contrevenant_1,
    contrevenant_1.lieu_dit as lieu_dit_contrevenant_1,
    CASE 
        WHEN contrevenant_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_1.bp)
    END as bp_contrevenant_1,
    contrevenant_1.code_postal as code_postal_contrevenant_1,
    contrevenant_1.localite as localite_contrevenant_1,
    CASE 
        WHEN contrevenant_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_1.cedex)
    END as cedex_contrevenant_1,
    contrevenant_1.pays as pays_contrevenant_1,
    contrevenant_1.division_territoriale as division_territoriale_contrevenant_1,

    --Coordonnées du contrevenant 2

    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_2_civilite.libelle, contrevenant_2.particulier_nom, contrevenant_2.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_2.personne_morale_raison_sociale, contrevenant_2.personne_morale_denomination, ''représenté(e) par'', contrevenant_2_civilite.libelle, contrevenant_2.personne_morale_nom, contrevenant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_2.personne_morale_raison_sociale, '' '', contrevenant_2.personne_morale_denomination))
            END
    END as nom_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier'' OR contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
        THEN contrevenant_2_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_nom
        ELSE
            CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL
                THEN contrevenant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_prenom
        ELSE
            CASE WHEN contrevenant_2.personne_morale_prenom IS NOT NULL
                THEN contrevenant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_denomination
    END as denomination_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_siret
    END as siret_contrevenant_2,
    contrevenant_2.numero as numero_contrevenant_2,
    contrevenant_2.voie as voie_contrevenant_2,
    contrevenant_2.complement as complement_contrevenant_2,
    contrevenant_2.lieu_dit as lieu_dit_contrevenant_2,
    CASE 
        WHEN contrevenant_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_2.bp)
    END as bp_contrevenant_2,
    contrevenant_2.code_postal as code_postal_contrevenant_2,
    contrevenant_2.localite as localite_contrevenant_2,
    CASE 
        WHEN contrevenant_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_2.cedex)
    END as cedex_contrevenant_2,
    contrevenant_2.pays as pays_contrevenant_2,
    contrevenant_2.division_territoriale as division_territoriale_contrevenant_2,

    --Coordonnées du contrevenant 3

    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_3_civilite.libelle, contrevenant_3.particulier_nom, contrevenant_3.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_3.personne_morale_raison_sociale, contrevenant_3.personne_morale_denomination, ''représenté(e) par'', contrevenant_3_civilite.libelle, contrevenant_3.personne_morale_nom, contrevenant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_3.personne_morale_raison_sociale, '' '', contrevenant_3.personne_morale_denomination))
            END
    END as nom_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier'' OR contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN contrevenant_3_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_nom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL
                THEN contrevenant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_prenom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN contrevenant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_denomination
    END as denomination_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_siret
    END as siret_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_3,
    contrevenant_3.numero as numero_contrevenant_3,
    contrevenant_3.voie as voie_contrevenant_3,
    contrevenant_3.complement as complement_contrevenant_3,
    contrevenant_3.lieu_dit as lieu_dit_contrevenant_3,
    CASE 
        WHEN contrevenant_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_3.bp)
    END as bp_contrevenant_3,
    contrevenant_3.code_postal as code_postal_contrevenant_3,
    contrevenant_3.localite as localite_contrevenant_3,
    CASE 
        WHEN contrevenant_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_3.cedex)
    END as cedex_contrevenant_3,
    contrevenant_3.pays as pays_contrevenant_3,
    contrevenant_3.division_territoriale as division_territoriale_contrevenant_3,

    --Coordonnées du contrevenant 4

    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_4_civilite.libelle, contrevenant_4.particulier_nom, contrevenant_4.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_4.personne_morale_raison_sociale, contrevenant_4.personne_morale_denomination, ''représenté(e) par'', contrevenant_4_civilite.libelle, contrevenant_4.personne_morale_nom, contrevenant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_4.personne_morale_raison_sociale, '' '', contrevenant_4.personne_morale_denomination))
            END
    END as nom_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier'' OR contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
        THEN contrevenant_4_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_nom
        ELSE
            CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL
                THEN contrevenant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_prenom
        ELSE
            CASE WHEN contrevenant_4.personne_morale_prenom IS NOT NULL
                THEN contrevenant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_denomination
    END as denomination_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_siret
    END as siret_contrevenant_4,
    contrevenant_4.numero as numero_contrevenant_4,
    contrevenant_4.voie as voie_contrevenant_4,
    contrevenant_4.complement as complement_contrevenant_4,
    contrevenant_4.lieu_dit as lieu_dit_contrevenant_4,
    CASE 
        WHEN contrevenant_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_4.bp)
    END as bp_contrevenant_4,
    contrevenant_4.code_postal as code_postal_contrevenant_4,
    contrevenant_4.localite as localite_contrevenant_4,
    CASE 
        WHEN contrevenant_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_4.cedex)
    END as cedex_contrevenant_4,
    contrevenant_4.pays as pays_contrevenant_4,
    contrevenant_4.division_territoriale as division_territoriale_contrevenant_4,

    --Coordonnées du contrevenant 5

    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_5_civilite.libelle, contrevenant_5.particulier_nom, contrevenant_5.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_5.personne_morale_nom IS NOT NULL OR contrevenant_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_5.personne_morale_raison_sociale, contrevenant_5.personne_morale_denomination, ''représenté(e) par'', contrevenant_5_civilite.libelle, contrevenant_5.personne_morale_nom, contrevenant_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_5.personne_morale_raison_sociale, '' '', contrevenant_5.personne_morale_denomination))
            END
    END as nom_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier'' OR contrevenant_5.personne_morale_nom IS NOT NULL OR contrevenant_5.personne_morale_prenom IS NOT NULL
        THEN contrevenant_5_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN contrevenant_5.particulier_nom
        ELSE
            CASE WHEN contrevenant_5.personne_morale_nom IS NOT NULL
                THEN contrevenant_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN contrevenant_5.particulier_prenom
        ELSE
            CASE WHEN contrevenant_5.personne_morale_prenom IS NOT NULL
                THEN contrevenant_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_denomination
    END as denomination_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_siret
    END as siret_contrevenant_5,
    contrevenant_5.numero as numero_contrevenant_5,
    contrevenant_5.voie as voie_contrevenant_5,
    contrevenant_5.complement as complement_contrevenant_5,
    contrevenant_5.lieu_dit as lieu_dit_contrevenant_5,
    CASE 
        WHEN contrevenant_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_5.bp)
    END as bp_contrevenant_5,
    contrevenant_5.code_postal as code_postal_contrevenant_5,
    contrevenant_5.localite as localite_contrevenant_5,
    CASE 
        WHEN contrevenant_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_5.cedex)
    END as cedex_contrevenant_5,
    contrevenant_5.pays as pays_contrevenant_5,
    contrevenant_5.division_territoriale as division_territoriale_contrevenant_5,

    --Coordonnées du requérant principal

    CASE WHEN requerant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_principal_civilite.libelle, requerant_principal.particulier_nom, requerant_principal.particulier_prenom))
        ELSE
            CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_principal.personne_morale_raison_sociale, requerant_principal.personne_morale_denomination, ''représenté(e) par'', requerant_principal_civilite.libelle, requerant_principal.personne_morale_nom, requerant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_principal.personne_morale_raison_sociale, '' '', requerant_principal.personne_morale_denomination))
            END
    END as nom_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier'' OR requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
        THEN requerant_principal_civilite.libelle
        ELSE ''''
    END as civilite_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_nom
        ELSE
            CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL
                THEN requerant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_prenom
        ELSE
            CASE WHEN requerant_principal.personne_morale_prenom IS NOT NULL
                THEN requerant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_raison_sociale
    END as raison_sociale_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_denomination
    END as denomination_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_siret
    END as siret_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_principal,
    requerant_principal.numero as numero_requerant_principal,
    requerant_principal.voie as voie_requerant_principal,
    requerant_principal.complement as complement_requerant_principal,
    requerant_principal.lieu_dit as lieu_dit_requerant_principal,
    CASE 
        WHEN requerant_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_principal.bp)
    END as bp_requerant_principal,
    requerant_principal.code_postal as code_postal_requerant_principal,
    requerant_principal.localite as localite_requerant_principal,
    CASE 
        WHEN requerant_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_principal.cedex)
    END as cedex_requerant_principal,
    requerant_principal.pays as pays_requerant_principal,
    requerant_principal.division_territoriale as division_territoriale_requerant_principal,

    --Coordonnées du requérant 1

    CASE WHEN requerant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_1_civilite.libelle, requerant_1.particulier_nom, requerant_1.particulier_prenom))
        ELSE
            CASE WHEN requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_1.personne_morale_raison_sociale, requerant_1.personne_morale_denomination, ''représenté(e) par'', requerant_1_civilite.libelle, requerant_1.personne_morale_nom, requerant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_1.personne_morale_raison_sociale, '' '', requerant_1.personne_morale_denomination))
            END
    END as nom_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier'' OR requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
        THEN requerant_1_civilite.libelle
        ELSE ''''
    END as civilite_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_nom
        ELSE
            CASE WHEN requerant_1.personne_morale_nom IS NOT NULL
                THEN requerant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_prenom
        ELSE
            CASE WHEN requerant_1.personne_morale_prenom IS NOT NULL
                THEN requerant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_raison_sociale
    END as raison_sociale_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_denomination
    END as denomination_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_siret
    END as siret_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_1,
    requerant_1.numero as numero_requerant_1,
    requerant_1.voie as voie_requerant_1,
    requerant_1.complement as complement_requerant_1,
    requerant_1.lieu_dit as lieu_dit_requerant_1,
    CASE 
        WHEN requerant_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_1.bp)
    END as bp_requerant_1,
    requerant_1.code_postal as code_postal_requerant_1,
    requerant_1.localite as localite_requerant_1,
    CASE 
        WHEN requerant_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_1.cedex)
    END as cedex_requerant_1,
    requerant_1.pays as pays_requerant_1,
    requerant_1.division_territoriale as division_territoriale_requerant_1,

    --Coordonnées du requérant 2

    CASE WHEN requerant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_2_civilite.libelle, requerant_2.particulier_nom, requerant_2.particulier_prenom))
        ELSE
            CASE WHEN requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_2.personne_morale_raison_sociale, requerant_2.personne_morale_denomination, ''représenté(e) par'', requerant_2_civilite.libelle, requerant_2.personne_morale_nom, requerant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_2.personne_morale_raison_sociale, '' '', requerant_2.personne_morale_denomination))
            END
    END as nom_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier'' OR requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
        THEN requerant_2_civilite.libelle
        ELSE ''''
    END as civilite_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_nom
        ELSE
            CASE WHEN requerant_2.personne_morale_nom IS NOT NULL
                THEN requerant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_prenom
        ELSE
            CASE WHEN requerant_2.personne_morale_prenom IS NOT NULL
                THEN requerant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_raison_sociale
    END as raison_sociale_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_denomination
    END as denomination_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_siret
    END as siret_requerant_2,
    requerant_2.numero as numero_requerant_2,
    requerant_2.voie as voie_requerant_2,
    requerant_2.complement as complement_requerant_2,
    requerant_2.lieu_dit as lieu_dit_requerant_2,
    CASE 
        WHEN requerant_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_2.bp)
    END as bp_requerant_2,
    requerant_2.code_postal as code_postal_requerant_2,
    requerant_2.localite as localite_requerant_2,
    CASE 
        WHEN requerant_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_2.cedex)
    END as cedex_requerant_2,
    requerant_2.pays as pays_requerant_2,
    requerant_2.division_territoriale as division_territoriale_requerant_2,

    --Coordonnées du requérant 3

    CASE WHEN requerant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_3_civilite.libelle, requerant_3.particulier_nom, requerant_3.particulier_prenom))
        ELSE
            CASE WHEN requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_3.personne_morale_raison_sociale, requerant_3.personne_morale_denomination, ''représenté(e) par'', requerant_3_civilite.libelle, requerant_3.personne_morale_nom, requerant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_3.personne_morale_raison_sociale, '' '', requerant_3.personne_morale_denomination))
            END
    END as nom_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier'' OR requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
        THEN requerant_3_civilite.libelle
        ELSE ''''
    END as civilite_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_nom
        ELSE
            CASE WHEN requerant_3.personne_morale_nom IS NOT NULL
                THEN requerant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_prenom
        ELSE
            CASE WHEN requerant_3.personne_morale_prenom IS NOT NULL
                THEN requerant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_raison_sociale
    END as raison_sociale_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_denomination
    END as denomination_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_siret
    END as siret_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_3,
    requerant_3.numero as numero_requerant_3,
    requerant_3.voie as voie_requerant_3,
    requerant_3.complement as complement_requerant_3,
    requerant_3.lieu_dit as lieu_dit_requerant_3,
    CASE 
        WHEN requerant_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_3.bp)
    END as bp_requerant_3,
    requerant_3.code_postal as code_postal_requerant_3,
    requerant_3.localite as localite_requerant_3,
    CASE 
        WHEN requerant_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_3.cedex)
    END as cedex_requerant_3,
    requerant_3.pays as pays_requerant_3,
    requerant_3.division_territoriale as division_territoriale_requerant_3,

    --Coordonnées du requérant 4

    CASE WHEN requerant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_4_civilite.libelle, requerant_4.particulier_nom, requerant_4.particulier_prenom))
        ELSE
            CASE WHEN requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_4.personne_morale_raison_sociale, requerant_4.personne_morale_denomination, ''représenté(e) par'', requerant_4_civilite.libelle, requerant_4.personne_morale_nom, requerant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_4.personne_morale_raison_sociale, '' '', requerant_4.personne_morale_denomination))
            END
    END as nom_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier'' OR requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
        THEN requerant_4_civilite.libelle
        ELSE ''''
    END as civilite_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_nom
        ELSE
            CASE WHEN requerant_4.personne_morale_nom IS NOT NULL
                THEN requerant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_prenom
        ELSE
            CASE WHEN requerant_4.personne_morale_prenom IS NOT NULL
                THEN requerant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_raison_sociale
    END as raison_sociale_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_denomination
    END as denomination_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_siret
    END as siret_requerant_4,
    requerant_4.numero as numero_requerant_4,
    requerant_4.voie as voie_requerant_4,
    requerant_4.complement as complement_requerant_4,
    requerant_4.lieu_dit as lieu_dit_requerant_4,
    CASE 
        WHEN requerant_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_4.bp)
    END as bp_requerant_4,
    requerant_4.code_postal as code_postal_requerant_4,
    requerant_4.localite as localite_requerant_4,
    CASE 
        WHEN requerant_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_4.cedex)
    END as cedex_requerant_4,
    requerant_4.pays as pays_requerant_4,
    requerant_4.division_territoriale as division_territoriale_requerant_4,

    --Coordonnées du requérant 5

    CASE WHEN requerant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_5_civilite.libelle, requerant_5.particulier_nom, requerant_5.particulier_prenom))
        ELSE
            CASE WHEN requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_5.personne_morale_raison_sociale, requerant_5.personne_morale_denomination, ''représenté(e) par'', requerant_5_civilite.libelle, requerant_5.personne_morale_nom, requerant_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_5.personne_morale_raison_sociale, '' '', requerant_5.personne_morale_denomination))
            END
    END as nom_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier'' OR requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
        THEN requerant_5_civilite.libelle
        ELSE ''''
    END as civilite_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_nom
        ELSE
            CASE WHEN requerant_5.personne_morale_nom IS NOT NULL
                THEN requerant_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_prenom
        ELSE
            CASE WHEN requerant_5.personne_morale_prenom IS NOT NULL
                THEN requerant_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_raison_sociale
    END as raison_sociale_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_denomination
    END as denomination_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_siret
    END as siret_requerant_5,
    requerant_5.numero as numero_requerant_5,
    requerant_5.voie as voie_requerant_5,
    requerant_5.complement as complement_requerant_5,
    requerant_5.lieu_dit as lieu_dit_requerant_5,
    CASE 
        WHEN requerant_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_5.bp)
    END as bp_requerant_5,
    requerant_5.code_postal as code_postal_requerant_5,
    requerant_5.localite as localite_requerant_5,
    CASE 
        WHEN requerant_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_5.cedex)
    END as cedex_requerant_5,
    requerant_5.pays as pays_requerant_5,
    requerant_5.division_territoriale as division_territoriale_requerant_5,

    --Coordonnées de l''avocat principal

    CASE WHEN avocat_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_principal_civilite.libelle, avocat_principal.particulier_nom, avocat_principal.particulier_prenom))
        ELSE
            CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_principal.personne_morale_raison_sociale, avocat_principal.personne_morale_denomination, ''représenté(e) par'', avocat_principal_civilite.libelle, avocat_principal.personne_morale_nom, avocat_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_principal.personne_morale_raison_sociale, '' '', avocat_principal.personne_morale_denomination))
            END
    END as nom_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier'' OR avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
        THEN avocat_principal_civilite.libelle
        ELSE ''''
    END as civilite_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_nom
        ELSE
            CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL
                THEN avocat_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_prenom
        ELSE
            CASE WHEN avocat_principal.personne_morale_prenom IS NOT NULL
                THEN avocat_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_raison_sociale
    END as raison_sociale_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_denomination
    END as denomination_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_siret
    END as siret_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_principal,
    avocat_principal.numero as numero_avocat_principal,
    avocat_principal.voie as voie_avocat_principal,
    avocat_principal.complement as complement_avocat_principal,
    avocat_principal.lieu_dit as lieu_dit_avocat_principal,
    CASE 
        WHEN avocat_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_principal.bp)
    END as bp_avocat_principal,
    avocat_principal.code_postal as code_postal_avocat_principal,
    avocat_principal.localite as localite_avocat_principal,
    CASE 
        WHEN avocat_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_principal.cedex)
    END as cedex_avocat_principal,
    avocat_principal.pays as pays_avocat_principal,
    avocat_principal.division_territoriale as division_territoriale_avocat_principal,

    --Coordonnées de l''avocat 1

    CASE WHEN avocat_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_1_civilite.libelle, avocat_1.particulier_nom, avocat_1.particulier_prenom))
        ELSE
            CASE WHEN avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_1.personne_morale_raison_sociale, avocat_1.personne_morale_denomination, ''représenté(e) par'', avocat_1_civilite.libelle, avocat_1.personne_morale_nom, avocat_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_1.personne_morale_raison_sociale, '' '', avocat_1.personne_morale_denomination))
            END
    END as nom_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier'' OR avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
        THEN avocat_1_civilite.libelle
        ELSE ''''
    END as civilite_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_nom
        ELSE
            CASE WHEN avocat_1.personne_morale_nom IS NOT NULL
                THEN avocat_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_prenom
        ELSE
            CASE WHEN avocat_1.personne_morale_prenom IS NOT NULL
                THEN avocat_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_raison_sociale
    END as raison_sociale_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_denomination
    END as denomination_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_siret
    END as siret_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_1,
    avocat_1.numero as numero_avocat_1,
    avocat_1.voie as voie_avocat_1,
    avocat_1.complement as complement_avocat_1,
    avocat_1.lieu_dit as lieu_dit_avocat_1,
    CASE 
        WHEN avocat_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_1.bp)
    END as bp_avocat_1,
    avocat_1.code_postal as code_postal_avocat_1,
    avocat_1.localite as localite_avocat_1,
    CASE 
        WHEN avocat_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_1.cedex)
    END as cedex_avocat_1,
    avocat_1.pays as pays_avocat_1,
    avocat_1.division_territoriale as division_territoriale_avocat_1,

    --Coordonnées de l''avocat 2

    CASE WHEN avocat_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_2_civilite.libelle, avocat_2.particulier_nom, avocat_2.particulier_prenom))
        ELSE
            CASE WHEN avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_2.personne_morale_raison_sociale, avocat_2.personne_morale_denomination, ''représenté(e) par'', avocat_2_civilite.libelle, avocat_2.personne_morale_nom, avocat_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_2.personne_morale_raison_sociale, '' '', avocat_2.personne_morale_denomination))
            END
    END as nom_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier'' OR avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
        THEN avocat_2_civilite.libelle
        ELSE ''''
    END as civilite_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_nom
        ELSE
            CASE WHEN avocat_2.personne_morale_nom IS NOT NULL
                THEN avocat_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_prenom
        ELSE
            CASE WHEN avocat_2.personne_morale_prenom IS NOT NULL
                THEN avocat_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_raison_sociale
    END as raison_sociale_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_denomination
    END as denomination_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_siret
    END as siret_avocat_2,
    avocat_2.numero as numero_avocat_2,
    avocat_2.voie as voie_avocat_2,
    avocat_2.complement as complement_avocat_2,
    avocat_2.lieu_dit as lieu_dit_avocat_2,
    CASE 
        WHEN avocat_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_2.bp)
    END as bp_avocat_2,
    avocat_2.code_postal as code_postal_avocat_2,
    avocat_2.localite as localite_avocat_2,
    CASE 
        WHEN avocat_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_2.cedex)
    END as cedex_avocat_2,
    avocat_2.pays as pays_avocat_2,
    avocat_2.division_territoriale as division_territoriale_avocat_2,

    --Coordonnées de l''avocat 3

    CASE WHEN avocat_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_3_civilite.libelle, avocat_3.particulier_nom, avocat_3.particulier_prenom))
        ELSE
            CASE WHEN avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_3.personne_morale_raison_sociale, avocat_3.personne_morale_denomination, ''représenté(e) par'', avocat_3_civilite.libelle, avocat_3.personne_morale_nom, avocat_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_3.personne_morale_raison_sociale, '' '', avocat_3.personne_morale_denomination))
            END
    END as nom_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier'' OR avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
        THEN avocat_3_civilite.libelle
        ELSE ''''
    END as civilite_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_nom
        ELSE
            CASE WHEN avocat_3.personne_morale_nom IS NOT NULL
                THEN avocat_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_prenom
        ELSE
            CASE WHEN avocat_3.personne_morale_prenom IS NOT NULL
                THEN avocat_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_raison_sociale
    END as raison_sociale_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_denomination
    END as denomination_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_siret
    END as siret_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_3,
    avocat_3.numero as numero_avocat_3,
    avocat_3.voie as voie_avocat_3,
    avocat_3.complement as complement_avocat_3,
    avocat_3.lieu_dit as lieu_dit_avocat_3,
    CASE 
        WHEN avocat_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_3.bp)
    END as bp_avocat_3,
    avocat_3.code_postal as code_postal_avocat_3,
    avocat_3.localite as localite_avocat_3,
    CASE 
        WHEN avocat_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_3.cedex)
    END as cedex_avocat_3,
    avocat_3.pays as pays_avocat_3,
    avocat_3.division_territoriale as division_territoriale_avocat_3,

    --Coordonnées de l''avocat 4

    CASE WHEN avocat_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_4_civilite.libelle, avocat_4.particulier_nom, avocat_4.particulier_prenom))
        ELSE
            CASE WHEN avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_4.personne_morale_raison_sociale, avocat_4.personne_morale_denomination, ''représenté(e) par'', avocat_4_civilite.libelle, avocat_4.personne_morale_nom, avocat_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_4.personne_morale_raison_sociale, '' '', avocat_4.personne_morale_denomination))
            END
    END as nom_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier'' OR avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
        THEN avocat_4_civilite.libelle
        ELSE ''''
    END as civilite_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_nom
        ELSE
            CASE WHEN avocat_4.personne_morale_nom IS NOT NULL
                THEN avocat_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_prenom
        ELSE
            CASE WHEN avocat_4.personne_morale_prenom IS NOT NULL
                THEN avocat_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_raison_sociale
    END as raison_sociale_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_denomination
    END as denomination_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_siret
    END as siret_avocat_4,
    avocat_4.numero as numero_avocat_4,
    avocat_4.voie as voie_avocat_4,
    avocat_4.complement as complement_avocat_4,
    avocat_4.lieu_dit as lieu_dit_avocat_4,
    CASE 
        WHEN avocat_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_4.bp)
    END as bp_avocat_4,
    avocat_4.code_postal as code_postal_avocat_4,
    avocat_4.localite as localite_avocat_4,
    CASE 
        WHEN avocat_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_4.cedex)
    END as cedex_avocat_4,
    avocat_4.pays as pays_avocat_4,
    avocat_4.division_territoriale as division_territoriale_avocat_4,

    --Coordonnées de l''avocat 5

    CASE WHEN avocat_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_5_civilite.libelle, avocat_5.particulier_nom, avocat_5.particulier_prenom))
        ELSE
            CASE WHEN avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_5.personne_morale_raison_sociale, avocat_5.personne_morale_denomination, ''représenté(e) par'', avocat_5_civilite.libelle, avocat_5.personne_morale_nom, avocat_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_5.personne_morale_raison_sociale, '' '', avocat_5.personne_morale_denomination))
            END
    END as nom_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier'' OR avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
        THEN avocat_5_civilite.libelle
        ELSE ''''
    END as civilite_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_nom
        ELSE
            CASE WHEN avocat_5.personne_morale_nom IS NOT NULL
                THEN avocat_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_prenom
        ELSE
            CASE WHEN avocat_5.personne_morale_prenom IS NOT NULL
                THEN avocat_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_raison_sociale
    END as raison_sociale_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_denomination
    END as denomination_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_siret
    END as siret_avocat_5,
    avocat_5.numero as numero_avocat_5,
    avocat_5.voie as voie_avocat_5,
    avocat_5.complement as complement_avocat_5,
    avocat_5.lieu_dit as lieu_dit_avocat_5,
    CASE 
        WHEN avocat_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_5.bp)
    END as bp_avocat_5,
    avocat_5.code_postal as code_postal_avocat_5,
    avocat_5.localite as localite_avocat_5,
    CASE 
        WHEN avocat_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_5.cedex)
    END as cedex_avocat_5,
    avocat_5.pays as pays_avocat_5,
    avocat_5.division_territoriale as division_territoriale_avocat_5,

    --Coordonnées du délégataire

    CASE
        WHEN delegataire.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
                ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
            END
    END as nom_delegataire,
    CASE WHEN delegataire.qualite=''particulier'' OR delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
        THEN delegataire_civilite.libelle
        ELSE ''''
    END as civilite_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_nom
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL
                THEN delegataire.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_prenom
        ELSE
            CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_raison_sociale
    END as raison_sociale_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_denomination
    END as denomination_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_siret
    END as siret_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_categorie_juridique
    END as categorie_juridique_delegataire,
    delegataire.numero as numero_delegataire,
    delegataire.voie as voie_delegataire,
    delegataire.complement as complement_delegataire,
    delegataire.lieu_dit as lieu_dit_delegataire,
    CASE 
        WHEN delegataire.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', delegataire.bp)
    END as bp_delegataire,
    delegataire.code_postal as code_postal_delegataire,
    delegataire.localite as ville_delegataire,
    CASE 
        WHEN delegataire.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', delegataire.cedex)
    END as cedex_delegataire,
    delegataire.pays as pays_delegataire,
    delegataire.division_territoriale as division_territoriale_delegataire,

    -- CORRESPONDANT : destinataire du courrier. Il est le délégataire ou le pétitionnaire principal

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                        ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
                ELSE
                    CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                        THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
                        ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
                    END
            END
    END as nom_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier'' OR petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal_civilite.libelle
                ELSE ''''
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier'' OR delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire_civilite.libelle
                ELSE ''''
            END
    END as civilite_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN petitionnaire_principal.particulier_nom
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                        THEN petitionnaire_principal.personne_morale_nom
                        ELSE ''''
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN delegataire.particulier_nom
                ELSE
                    CASE WHEN delegataire.personne_morale_nom IS NOT NULL
                        THEN delegataire.personne_morale_nom
                        ELSE ''''
                    END
            END
    END as nom_particulier_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN petitionnaire_principal.particulier_prenom
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                        THEN petitionnaire_principal.personne_morale_prenom
                        ELSE ''''
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN delegataire.particulier_prenom
                ELSE
                    CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
                        THEN delegataire.personne_morale_prenom
                        ELSE ''''
                    END
            END
    END as prenom_particulier_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_raison_sociale
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_raison_sociale
            END
    END as raison_sociale_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_denomination
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_denomination
            END
    END as denomination_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_siret
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_siret
            END
    END as siret_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_categorie_juridique
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_categorie_juridique
            END
    END as categorie_juridique_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.numero
        ELSE delegataire.numero
    END as numero_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.voie
        ELSE delegataire.voie
    END as voie_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.complement
        ELSE delegataire.complement
    END as complement_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.lieu_dit
        ELSE delegataire.lieu_dit
    END as lieu_dit_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN 
            CASE 
                WHEN petitionnaire_principal.bp IS NULL
                THEN ''''
                ELSE CONCAT(''BP '', petitionnaire_principal.bp)
            END
        ELSE 
            CASE 
                WHEN delegataire.bp IS NULL
                THEN ''''
                ELSE CONCAT(''BP '', delegataire.bp)
            END
    END as bp_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.code_postal
        ELSE delegataire.code_postal
    END as code_postal_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.localite
        ELSE delegataire.localite
    END as ville_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN 
            CASE 
                WHEN petitionnaire_principal.cedex IS NULL
                THEN ''''
                ELSE CONCAT(''CEDEX '', petitionnaire_principal.cedex)
            END 
        ELSE 
            CASE 
                WHEN delegataire.cedex IS NULL
                THEN ''''
                ELSE CONCAT(''CEDEX '', delegataire.cedex)
            END 
    END as cedex_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.pays
        ELSE delegataire.pays
    END as pays_correspondant,
    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.division_territoriale
        ELSE delegataire.division_territoriale
    END as division_territoriale_correspondant,

    --Dates importantes du dossier d''instruction
    to_char(dossier.date_depot, ''DD/MM/YYYY'') as date_depot_dossier,
    to_char(dossier.date_complet, ''DD/MM/YYYY'') as date_completude,
    to_char(dossier.date_dernier_depot, ''DD/MM/YYYY'') as date_dernier_depot,
    to_char(dossier.date_decision, ''DD/MM/YYYY'') as date_decision_dossier,
    CASE WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE 
        THEN to_char(dossier.date_limite_incompletude ,''DD/MM/YYYY'') 
        ELSE to_char(dossier.date_limite ,''DD/MM/YYYY'')
    END as date_limite_dossier,
    to_char(dossier.date_achevement,''DD/MM/YYYY'') as date_achevement_dossier,
    to_char(dossier.date_conformite,''DD/MM/YYYY'') as date_conformite_dossier,
    to_char(dossier.date_notification_delai,''DD/MM/YYYY'') as date_notification_delai_dossier,
    
    --Noms des signataires
    TRIM(CONCAT(signataire_civilite.libelle, '' '',signataire_arrete.prenom, '' '', signataire_arrete.nom)) as arrete_signataire,
    TRIM(CONCAT(signataire_arrete.qualite, '' '', signataire_arrete.signature)) as signature_signataire,
    division.chef as chef_division,
    direction.chef as chef_direction,
    direction.libelle as libelle_direction,
    direction.description as description_direction,
    
    --Données générales des données techniques
    donnees_techniques.co_projet_desc as co_projet_desc_donnees_techniques,
    donnees_techniques.am_projet_desc as am_projet_desc_donnees_techniques,
    donnees_techniques.dm_projet_desc as dm_projet_desc_donnees_techniques,
    donnees_techniques.ope_proj_desc as ope_proj_desc_donnees_techniques,
    TRIM(CONCAT(
        donnees_techniques.co_projet_desc, '' '',
        donnees_techniques.am_projet_desc, '' '',
        donnees_techniques.dm_projet_desc, '' '',
        donnees_techniques.ope_proj_desc
        )) as projet_desc_donnees_techniques,
    donnees_techniques.am_lot_max_nb as am_lot_max_nb_donnees_techniques,
    donnees_techniques.am_lot_max_shon as am_lot_max_shon_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN donnees_techniques.su2_cstr_shon_tot
        ELSE donnees_techniques.su_cstr_shon_tot
    END as su_cstr_shon_tot_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN donnees_techniques.su2_demo_shon_tot
        ELSE donnees_techniques.su_demo_shon_tot
    END as su_demo_shon_tot_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN
            REGEXP_REPLACE(CONCAT(
                CASE WHEN donnees_techniques.su2_cstr_shon1 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Exploitation agricole - '', donnees_techniques.su2_cstr_shon1, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon2 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Exploitation forestière - '', donnees_techniques.su2_cstr_shon2, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon3 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Logement - '', donnees_techniques.su2_cstr_shon3, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon4 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Hébergement - '', donnees_techniques.su2_cstr_shon4, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon5 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Artisanat et commerce de détail - '', donnees_techniques.su2_cstr_shon5, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon6 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Restauration - '', donnees_techniques.su2_cstr_shon6, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon7 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Commerce de gros - '', donnees_techniques.su2_cstr_shon7, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon8 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Activités de services où s''''effectue l''''accueil d''''une clientèle - '', donnees_techniques.su2_cstr_shon8, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon9 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Hébergement hôtelier et touristique - '', donnees_techniques.su2_cstr_shon9, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon10 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Cinéma - '', donnees_techniques.su2_cstr_shon10, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon11 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Locaux et bureaux accueillant du public des administrations publiques et assimilés - '', donnees_techniques.su2_cstr_shon11, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon12 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Locaux techniques et industriels des administrations publiques et assimilés - '', donnees_techniques.su2_cstr_shon12, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon13 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Établissements d''''enseignement, de santé et d''''action sociale - '', donnees_techniques.su2_cstr_shon13, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon14 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Salles d''''art et de spectacles - '', donnees_techniques.su2_cstr_shon14, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon15 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Équipements sportifs - '', donnees_techniques.su2_cstr_shon15, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon16 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Autres équipements recevant du public - '', donnees_techniques.su2_cstr_shon16, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon17 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Industrie - '', donnees_techniques.su2_cstr_shon17, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon18 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Entrepôt - '', donnees_techniques.su2_cstr_shon18, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon19 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Bureau - '', donnees_techniques.su2_cstr_shon19, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon20 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Centre de congrès et d''''exposition - '', donnees_techniques.su2_cstr_shon20, '' m²'')
                END
            ), '' / $'', '''')
        ELSE
            REGEXP_REPLACE(CONCAT(
                CASE
                    WHEN donnees_techniques.su_cstr_shon1 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Habitation - '', donnees_techniques.su_cstr_shon1, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon2 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Hébergement hôtelier - '', donnees_techniques.su_cstr_shon2, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon3 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Bureaux - '', donnees_techniques.su_cstr_shon3, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon4 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Commerce - '', donnees_techniques.su_cstr_shon4, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon5 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Artisanat - '', donnees_techniques.su_cstr_shon5, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon6 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Industrie - '', donnees_techniques.su_cstr_shon6, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon7 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Exploitation agricole ou forestière - '', donnees_techniques.su_cstr_shon7, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon8 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Entrepôt - '', donnees_techniques.su_cstr_shon8, '' m² / '')
                END, 
                CASE
                    WHEN donnees_techniques.su_cstr_shon9 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Service public ou d''''intérêt collectif - '', donnees_techniques.su_cstr_shon9, '' m²'')
                END
            ), '' / $'', '''')
    END as tab_surface_donnees_techniques,
    donnees_techniques.co_tot_log_nb as co_tot_log_nb_donnees_techniques,
    donnees_techniques.co_statio_place_nb as co_statio_place_nb_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN donnees_techniques.su2_tot_shon_tot
        ELSE donnees_techniques.su_tot_shon_tot
    END as su_tot_shon_tot_donnees_techniques,

    -- Données techniques pour les AT
    CONCAT_WS('', '',
        CASE WHEN donnees_techniques.erp_cstr_neuve IS TRUE THEN ''construction neuve'' END,
        CASE WHEN donnees_techniques.erp_trvx_acc IS TRUE THEN ''travaux de mise en conformité totale aux règles d’accessibilité'' END,
        CASE WHEN donnees_techniques.erp_extension IS TRUE THEN ''extension'' END,
        CASE WHEN donnees_techniques.erp_rehab IS TRUE THEN ''réhabilitation'' END,
        CASE WHEN donnees_techniques.erp_trvx_am IS TRUE THEN ''travaux d’aménagement (remplacement de revêtements, rénovation électrique, création d’une rampe, par exemple)'' END,
        CASE WHEN donnees_techniques.erp_vol_nouv_exist IS TRUE THEN ''création de volumes nouveaux dans des volumes existants (modification du cloisonnement, par exemple)'' END
    ) as at_type_travaux,
    donnees_techniques.erp_public_eff_tot as at_effectif_public_total,
    CONCAT_WS('' - '', erp_categorie.libelle, erp_categorie.description) as at_categorie_etablissement,
    CONCAT_WS('' - '', erp_type.libelle, erp_type.description) as at_type_etablissement,

    -- Données techniques pour une DIA
    COALESCE (donnees_techniques.dia_mod_cess_prix_vente,'''') AS dia_mod_cess_prix_vente,
    COALESCE (donnees_techniques.dia_acquereur_nom_prenom,'''') AS dia_acquereur_nom_prenom,
    CONCAT(
        COALESCE(donnees_techniques.dia_acquereur_adr_num_voie || '' '',''''),
        COALESCE(donnees_techniques.dia_acquereur_adr_ext || '' '',''''),
        COALESCE(donnees_techniques.dia_acquereur_adr_type_voie || '' '',''''),
        COALESCE(donnees_techniques.dia_acquereur_adr_nom_voie || '' '',''''),
        COALESCE(donnees_techniques.dia_acquereur_adr_lieu_dit_bp || '' '',''''),
        COALESCE(donnees_techniques.dia_acquereur_adr_cp || '' '',''''),
        COALESCE(donnees_techniques.dia_acquereur_adr_localite || '' '','''')
        ) as dia_acquereur_adresse,

    -- Données techniques pour le contentieux
    objet_recours.libelle as ctx_objet_recours_libelle,
    donnees_techniques.ctx_reference_sagace as ctx_reference_sagace,
    donnees_techniques.ctx_nature_travaux_infra_om_html as ctx_nature_travaux_infra_om_html,
    donnees_techniques.ctx_synthese_nti as ctx_synthese_nti,
    donnees_techniques.ctx_article_non_resp_om_html as ctx_article_non_resp_om_html,
    donnees_techniques.ctx_synthese_anr as ctx_synthese_anr,
    donnees_techniques.ctx_reference_parquet as ctx_reference_parquet,
    donnees_techniques.ctx_element_taxation as ctx_element_taxation,
    CASE donnees_techniques.ctx_infraction WHEN ''t'' THEN ''Oui'' else ''Non'' end as ctx_infraction,
    CASE donnees_techniques.ctx_regularisable WHEN ''t'' THEN ''Oui'' else ''Non'' end as ctx_regularisable,
    donnees_techniques.ctx_reference_courrier as ctx_reference_courrier,
    to_char(donnees_techniques.ctx_date_audience, ''DD/MM/YYYY'') as date_audience_ctx,
    to_char(donnees_techniques.ctx_date_ajournement, ''DD/MM/YYYY'') as date_ajournement_ctx,

    --Bordereau d''envoi au maire
    CASE
        WHEN evenement.type = ''arrete''
        THEN CONCAT(''transmission d''''une proposition de décision sur '', evenement.libelle)
        ELSE CONCAT(''transmission d''''un courrier d''''instruction sur '', evenement.libelle)
    END as objet_bordereau_envoi_maire
    
FROM
    &DB_PREFIXEinstruction
LEFT JOIN
    &DB_PREFIXEsignataire_arrete
    ON instruction.signataire_arrete = signataire_arrete.signataire_arrete
LEFT JOIN
    &DB_PREFIXEcivilite as signataire_civilite
    ON signataire_arrete.civilite = signataire_civilite.civilite
LEFT JOIN
    &DB_PREFIXEom_lettretype
    ON instruction.lettretype = om_lettretype.id and om_lettretype.actif IS TRUE
LEFT JOIN
    &DB_PREFIXEdossier
    ON
        instruction.dossier=dossier.dossier
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''petitionnaire''
    ) as petitionnaire_principal
    ON petitionnaire_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as petitionnaire_principal_civilite
    ON
        petitionnaire_principal.particulier_civilite = petitionnaire_principal_civilite.civilite OR petitionnaire_principal.personne_morale_civilite = petitionnaire_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''contrevenant''
    ) as contrevenant_principal
    ON contrevenant_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as contrevenant_principal_civilite
    ON
        contrevenant_principal.particulier_civilite = contrevenant_principal_civilite.civilite OR contrevenant_principal.personne_morale_civilite = contrevenant_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''requerant''
    ) as requerant_principal
    ON requerant_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as requerant_principal_civilite
    ON
        requerant_principal.particulier_civilite = requerant_principal_civilite.civilite OR requerant_principal.personne_morale_civilite = requerant_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''avocat''
    ) as avocat_principal
    ON avocat_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as avocat_principal_civilite
    ON
        avocat_principal.particulier_civilite = avocat_principal_civilite.civilite OR avocat_principal.personne_morale_civilite = avocat_principal_civilite.civilite
LEFT JOIN
    &DB_PREFIXElien_dossier_autorisation_demandeur
    ON
        dossier.dossier_autorisation = lien_dossier_autorisation_demandeur.dossier_autorisation AND lien_dossier_autorisation_demandeur.petitionnaire_principal IS TRUE
LEFT JOIN
    &DB_PREFIXEdemandeur as petitionnaire_principal_initial
    ON
        lien_dossier_autorisation_demandeur.demandeur = petitionnaire_principal_initial.demandeur
LEFT JOIN
    &DB_PREFIXEcivilite as petitionnaire_principal_initial_civilite
    ON
        petitionnaire_principal_initial.particulier_civilite = petitionnaire_principal_initial_civilite.civilite OR petitionnaire_principal_initial.personne_morale_civilite = petitionnaire_principal_initial_civilite.civilite
LEFT JOIN
    (
    &DB_PREFIXElien_dossier_demandeur AS lien_dossier_delegataire
        JOIN &DB_PREFIXEdemandeur as delegataire
        ON
            lien_dossier_delegataire.demandeur = delegataire.demandeur AND delegataire.type_demandeur = ''delegataire''
    )
    ON
        instruction.dossier = lien_dossier_delegataire.dossier AND lien_dossier_delegataire.petitionnaire_principal IS FALSE
LEFT JOIN
    &DB_PREFIXEcivilite as delegataire_civilite
    ON
        delegataire.particulier_civilite = delegataire_civilite.civilite OR delegataire.personne_morale_civilite = delegataire_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS petitionnaire_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''petitionnaire''
    WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_petitionnaire_autre
ON instruction.dossier = sub_petitionnaire_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_1
    ON
        petitionnaire_1.demandeur = petitionnaire_autre[1] AND petitionnaire_1.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_1_civilite
    ON
        petitionnaire_1.particulier_civilite = petitionnaire_1_civilite.civilite OR petitionnaire_1.personne_morale_civilite = petitionnaire_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_2
    ON
        petitionnaire_2.demandeur = petitionnaire_autre[2] AND petitionnaire_2.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_2_civilite
    ON
        petitionnaire_2.particulier_civilite = petitionnaire_2_civilite.civilite OR petitionnaire_2.personne_morale_civilite = petitionnaire_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_3
    ON
        petitionnaire_3.demandeur = petitionnaire_autre[3] AND petitionnaire_3.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_3_civilite
    ON
        petitionnaire_3.particulier_civilite = petitionnaire_3_civilite.civilite OR petitionnaire_3.personne_morale_civilite = petitionnaire_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_4
    ON
        petitionnaire_4.demandeur = petitionnaire_autre[4] AND petitionnaire_4.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_4_civilite
    ON
        petitionnaire_4.particulier_civilite = petitionnaire_4_civilite.civilite OR petitionnaire_4.personne_morale_civilite = petitionnaire_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_5
    ON
        petitionnaire_5.demandeur = petitionnaire_autre[5] AND petitionnaire_5.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_5_civilite
    ON
        petitionnaire_5.particulier_civilite = petitionnaire_5_civilite.civilite OR petitionnaire_5.personne_morale_civilite = petitionnaire_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS contrevenant_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''contrevenant''
    WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_contrevenant_autre
ON instruction.dossier = sub_contrevenant_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_1
    ON
        contrevenant_1.demandeur = contrevenant_autre[1] AND contrevenant_1.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_1_civilite
    ON
        contrevenant_1.particulier_civilite = contrevenant_1_civilite.civilite OR contrevenant_1.personne_morale_civilite = contrevenant_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_2
    ON
        contrevenant_2.demandeur = contrevenant_autre[2] AND contrevenant_2.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_2_civilite
    ON
        contrevenant_2.particulier_civilite = contrevenant_2_civilite.civilite OR contrevenant_2.personne_morale_civilite = contrevenant_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_3
    ON
        contrevenant_3.demandeur = contrevenant_autre[3] AND contrevenant_3.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_3_civilite
    ON
        contrevenant_3.particulier_civilite = contrevenant_3_civilite.civilite OR contrevenant_3.personne_morale_civilite = contrevenant_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_4
    ON
        contrevenant_4.demandeur = contrevenant_autre[4] AND contrevenant_4.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_4_civilite
    ON
        contrevenant_4.particulier_civilite = contrevenant_4_civilite.civilite OR contrevenant_4.personne_morale_civilite = contrevenant_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_5
    ON
        contrevenant_5.demandeur = contrevenant_autre[5] AND contrevenant_5.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_5_civilite
    ON
        contrevenant_5.particulier_civilite = contrevenant_5_civilite.civilite OR contrevenant_5.personne_morale_civilite = contrevenant_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS requerant_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''requerant''
    WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_requerant_autre
ON instruction.dossier = sub_requerant_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_1
    ON
        requerant_1.demandeur = requerant_autre[1] AND requerant_1.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_1_civilite
    ON
        requerant_1.particulier_civilite = requerant_1_civilite.civilite OR requerant_1.personne_morale_civilite = requerant_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_2
    ON
        requerant_2.demandeur = requerant_autre[2] AND requerant_2.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_2_civilite
    ON
        requerant_2.particulier_civilite = requerant_2_civilite.civilite OR requerant_2.personne_morale_civilite = requerant_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_3
    ON
        requerant_3.demandeur = requerant_autre[3] AND requerant_3.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_3_civilite
    ON
        requerant_3.particulier_civilite = requerant_3_civilite.civilite OR requerant_3.personne_morale_civilite = requerant_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_4
    ON
        requerant_4.demandeur = requerant_autre[4] AND requerant_4.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_4_civilite
    ON
        requerant_4.particulier_civilite = requerant_4_civilite.civilite OR requerant_4.personne_morale_civilite = requerant_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_5
    ON
        requerant_5.demandeur = requerant_autre[5] AND requerant_5.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_5_civilite
    ON
        requerant_5.particulier_civilite = requerant_5_civilite.civilite OR requerant_5.personne_morale_civilite = requerant_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS avocat_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''avocat''
    WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_avocat_autre
ON instruction.dossier = sub_avocat_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_1
    ON
        avocat_1.demandeur = avocat_autre[1] AND avocat_1.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_1_civilite
    ON
        avocat_1.particulier_civilite = avocat_1_civilite.civilite OR avocat_1.personne_morale_civilite = avocat_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_2
    ON
        avocat_2.demandeur = avocat_autre[2] AND avocat_2.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_2_civilite
    ON
        avocat_2.particulier_civilite = avocat_2_civilite.civilite OR avocat_2.personne_morale_civilite = avocat_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_3
    ON
        avocat_3.demandeur = avocat_autre[3] AND avocat_3.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_3_civilite
    ON
        avocat_3.particulier_civilite = avocat_3_civilite.civilite OR avocat_3.personne_morale_civilite = avocat_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_4
    ON
        avocat_4.demandeur = avocat_autre[4] AND avocat_4.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_4_civilite
    ON
        avocat_4.particulier_civilite = avocat_4_civilite.civilite OR avocat_4.personne_morale_civilite = avocat_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_5
    ON
        avocat_5.demandeur = avocat_autre[5] AND avocat_5.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_5_civilite
    ON
        avocat_5.particulier_civilite = avocat_5_civilite.civilite OR avocat_5.personne_morale_civilite = avocat_5_civilite.civilite
LEFT JOIN
    &DB_PREFIXEdossier_instruction_type
    ON
        dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
LEFT JOIN
    &DB_PREFIXEdossier_autorisation
    ON
        dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
LEFT JOIN
    &DB_PREFIXEdossier_autorisation_type_detaille
    ON
        dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
LEFT JOIN
    &DB_PREFIXEdossier_autorisation_type
    ON
        dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
LEFT JOIN
    &DB_PREFIXEinstructeur
    ON
        dossier.instructeur = instructeur.instructeur
LEFT JOIN
    &DB_PREFIXEinstructeur as instructeur_2
    ON
        dossier.instructeur_2 = instructeur_2.instructeur
LEFT JOIN
    &DB_PREFIXEom_utilisateur
    ON
        om_utilisateur.om_utilisateur = instructeur.om_utilisateur
LEFT JOIN
    &DB_PREFIXEom_utilisateur as om_utilisateur_2
    ON
        om_utilisateur_2.om_utilisateur = instructeur_2.om_utilisateur
LEFT JOIN
    &DB_PREFIXEdivision
    ON
        instructeur.division = division.division
LEFT JOIN
    &DB_PREFIXEdivision as division_2
    ON
        instructeur_2.division = division_2.division
LEFT JOIN 
    &DB_PREFIXEdirection
    ON division.direction = direction.direction
LEFT JOIN
    &DB_PREFIXEarrondissement
    ON
        dossier.terrain_adresse_code_postal = arrondissement.code_postal
LEFT JOIN
    &DB_PREFIXEavis_decision
    ON
        dossier.avis_decision = avis_decision.avis_decision
LEFT JOIN
    &DB_PREFIXEetat
    ON
        dossier.etat = etat.etat
LEFT JOIN
    &DB_PREFIXEdonnees_techniques
    ON
    dossier.dossier = donnees_techniques.dossier_instruction
LEFT JOIN 
    &DB_PREFIXEevenement
    ON
        instruction.evenement = evenement.evenement
LEFT JOIN 
    &DB_PREFIXEquartier
    ON
        dossier.quartier = quartier.quartier
LEFT JOIN
    &DB_PREFIXEtaxe_amenagement
    ON
        dossier.om_collectivite = taxe_amenagement.om_collectivite
LEFT JOIN
    &DB_PREFIXEerp_categorie
    ON
        donnees_techniques.erp_class_cat = erp_categorie.erp_categorie
LEFT JOIN
    &DB_PREFIXEerp_type
    ON
        donnees_techniques.erp_class_type = erp_type.erp_type
LEFT JOIN
    &DB_PREFIXEobjet_recours
    ON
        donnees_techniques.ctx_objet_recours = objet_recours.objet_recours
WHERE instruction.instruction = &idx
',
merge_fields = '--Données générales de l''événement d''instruction
[complement1_instruction]
[complement2_instruction]
[complement3_instruction]
[complement4_instruction]
[code_barres_instruction]
[date_evenement_instruction]
[libelle_om_lettretype]
[archive_delai_instruction]

--Données générales du dossier d''instruction
[libelle_dossier]    [code_barres_dossier]    [delai_dossier]    [terrain_references_cadastrales_dossier]
[terrain_superficie_dossier]
[libelle_quartier]
[libelle_da]
[code_datd]    [libelle_datd]
[code_dat]    [libelle_dat]
[code_dit]    [libelle_dit]
[libelle_avis_decision]

-- Données contentieux du dossier d''instruction
[autorisation_contestee]
[date_cloture_instruction_dossier]
[date_premiere_visite_dossier]
[date_derniere_visite_dossier]
[date_contradictoire_dossier]
[date_retour_contradictoire_dossier]
[date_ait_dossier]
[date_transmission_parquet_dossier]

--Données générales du paramétrage de l''événement
[libelle_evenement]
[etat_evenement]
[delai_evenement]
[accord_tacite_evenement]
[delai_notification_evenement]
[avis_decision_evenement]
[autorite_competente_evenement]
[cle_acces_citoyen]

--Coordonnées de l''instructeur
[nom_instructeur]
[telephone_instructeur]
[division_instructeur]
[email_instructeur]

-- Coordonnées de l''instructeur 2
[nom_instructeur_2]
[telephone_instructeur_2]
[division_instructeur_2]
[email_instructeur_2]

--Adresse du terrain du dossier d''instruction 
[terrain_adresse_voie_numero_dossier]    [terrain_adresse_voie_dossier]
[terrain_adresse_lieu_dit_dossier]    [terrain_adresse_bp_dossier]
[terrain_adresse_code_postal_dossier]    [terrain_adresse_localite_dossier]    [terrain_adresse_cedex_dossier]

[libelle_arrondissement]

--Taxe d''aménagement du dossier d''instruction
[tax_taux_secteur]
[tax_numero_secteur]
[tax_montant_part_communale]
[tax_montant_part_departementale]
[tax_montant_part_regionale]
[tax_montant_total]

--Coordonnées du pétitionnaire principal
[nom_petitionnaire_principal]
[civilite_petitionnaire_principal]
[nom_particulier_petitionnaire_principal]
[prenom_particulier_petitionnaire_principal]
[raison_sociale_petitionnaire_principal]
[denomination_petitionnaire_principal]
[siret_petitionnaire_principal]
[categorie_juridique_petitionnaire_principal]
[numero_petitionnaire_principal]    [voie_petitionnaire_principal]    [complement_petitionnaire_principal]
[lieu_dit_petitionnaire_principal]    [bp_petitionnaire_principal]
[code_postal_petitionnaire_principal]    [localite_petitionnaire_principal]    [cedex_petitionnaire_principal]
[pays_petitionnaire_principal] [division_territoriale_petitionnaire_principal]

--Coordonnées du pétitionnaire principal initial
[nom_petitionnaire_principal_initial]
[civilite_petitionnaire_principal_initial]
[nom_particulier_petitionnaire_principal_initial]
[prenom_particulier_petitionnaire_principal_initial]
[raison_sociale_petitionnaire_principal_initial]
[denomination_petitionnaire_principal_initial]
[siret_petitionnaire_principal_initial]
[categorie_juridique_petitionnaire_principal_initial]
[numero_petitionnaire_principal_initial]    [voie_petitionnaire_principal_initial]    [complement_petitionnaire_principal_initial]
[lieu_dit_petitionnaire_principal_initial]    [bp_petitionnaire_principal_initial]
[code_postal_petitionnaire_principal_initial]    [localite_petitionnaire_principal_initial]    [cedex_petitionnaire_principal_initial]
[pays_petitionnaire_principal_initial] [division_territoriale__petitionnaire_principal_initial]

--Coordonnées des autres pétitionnaires
[nom_petitionnaire_1](jusqu''à 5)
[civilite_petitionnaire_1](jusqu''à 5)
[nom_particulier_petitionnaire_1](jusqu''à 5)
[prenom_particulier_petitionnaire_1](jusqu''à 5)
[raison_sociale_petitionnaire_1](jusqu''à 5)
[denomination_petitionnaire_1](jusqu''à 5)
[siret_petitionnaire_1](jusqu''à 5)
[categorie_juridique_petitionnaire_1](jusqu''à 5)
[numero_petitionnaire_1](jusqu''à 5)    [voie_petitionnaire_1](jusqu''à 5)
[complement_petitionnaire_1](jusqu''à 5)
[lieu_dit_petitionnaire_1](jusqu''à 5)    [bp_petitionnaire_1](jusqu''à 5)
[code_postal_petitionnaire_1](jusqu''à 5)    [localite_petitionnaire_1](jusqu''à 5)
[cedex_petitionnaire_1](jusqu''à 5)
[pays_petitionnaire_1](jusqu''à 5) [division_territoriale_petitionnaire_1](jusqu''à 5)

--Coordonnées du contrevenant principal
[nom_contrevenant_principal]
[civilite_contrevenant_principal]
[nom_particulier_contrevenant_principal]
[prenom_particulier_contrevenant_principal]
[raison_sociale_contrevenant_principal]
[denomination_contrevenant_principal]
[siret_contrevenant_principal]
[categorie_juridique_contrevenant_principal]
[numero_contrevenant_principal]    [voie_contrevenant_principal]    [complement_contrevenant_principal]
[lieu_dit_contrevenant_principal]    [bp_contrevenant_principal]
[code_postal_contrevenant_principal]    [localite_contrevenant_principal]    [cedex_contrevenant_principal]
[pays_contrevenant_principal] [division_territoriale_contrevenant_principal]

--Coordonnées des autres contrevenants
[nom_contrevenant_1](jusqu''à 5)
[civilite_contrevenant_1](jusqu''à 5)
[nom_particulier_contrevenant_1](jusqu''à 5)
[prenom_particulier_contrevenant_1](jusqu''à 5)
[raison_sociale_contrevenant_1](jusqu''à 5)
[denomination_contrevenant_1](jusqu''à 5)
[siret_contrevenant_1](jusqu''à 5)
[categorie_juridique_contrevenant_1](jusqu''à 5)
[numero_contrevenant_1](jusqu''à 5)    [voie_contrevenant_1](jusqu''à 5)
[complement_contrevenant_1](jusqu''à 5)
[lieu_dit_contrevenant_1](jusqu''à 5)    [bp_contrevenant_1](jusqu''à 5)
[code_postal_contrevenant_1](jusqu''à 5)    [localite_contrevenant_1](jusqu''à 5)
[cedex_contrevenant_1](jusqu''à 5)
[pays_contrevenant_1](jusqu''à 5) [division_territoriale_contrevenant_1](jusqu''à 5)

--Coordonnées du requérant principal
[nom_requerant_principal]
[civilite_requerant_principal]
[nom_particulier_requerant_principal]
[prenom_particulier_requerant_principal]
[raison_sociale_requerant_principal]
[denomination_requerant_principal]
[siret_requerant_principal]
[categorie_juridique_requerant_principal]
[numero_requerant_principal]    [voie_requerant_principal]    [complement_requerant_principal]
[lieu_dit_requerant_principal]    [bp_requerant_principal]
[code_postal_requerant_principal]    [localite_requerant_principal]    [cedex_requerant_principal]
[pays_requerant_principal] [division_territoriale_requerant_principal]

--Coordonnées des autres requérants
[nom_requerant_1](jusqu''à 5)
[civilite_requerant_1](jusqu''à 5)
[nom_particulier_requerant_1](jusqu''à 5)
[prenom_particulier_requerant_1](jusqu''à 5)
[raison_sociale_requerant_1](jusqu''à 5)
[denomination_requerant_1](jusqu''à 5)
[siret_requerant_1](jusqu''à 5)
[categorie_juridique_requerant_1](jusqu''à 5)
[numero_requerant_1](jusqu''à 5)    [voie_requerant_1](jusqu''à 5)
[complement_requerant_1](jusqu''à 5)
[lieu_dit_requerant_1](jusqu''à 5)    [bp_requerant_1](jusqu''à 5)
[code_postal_requerant_1](jusqu''à 5)    [localite_requerant_1](jusqu''à 5)
[cedex_requerant_1](jusqu''à 5)
[pays_requerant_1](jusqu''à 5) [division_territoriale_requerant_1](jusqu''à 5)

--Coordonnées de l''avocat principal
[nom_avocat_principal]
[civilite_avocat_principal]
[nom_particulier_avocat_principal]
[prenom_particulier_avocat_principal]
[raison_sociale_avocat_principal]
[denomination_avocat_principal]
[siret_avocat_principal]
[categorie_juridique_avocat_principal]
[numero_avocat_principal]    [voie_avocat_principal]    [complement_avocat_principal]
[lieu_dit_avocat_principal]    [bp_avocat_principal]
[code_postal_avocat_principal]    [localite_avocat_principal]    [cedex_avocat_principal]
[pays_avocat_principal] [division_territoriale_avocat_principal]

--Coordonnées des autres avocats
[nom_avocat_1](jusqu''à 5)
[civilite_avocat_1](jusqu''à 5)
[nom_particulier_avocat_1](jusqu''à 5)
[prenom_particulier_avocat_1](jusqu''à 5)
[raison_sociale_avocat_1](jusqu''à 5)
[denomination_avocat_1](jusqu''à 5)
[siret_avocat_1](jusqu''à 5)
[categorie_juridique_avocat_1](jusqu''à 5)
[numero_avocat_1](jusqu''à 5)    [voie_avocat_1](jusqu''à 5)
[complement_avocat_1](jusqu''à 5)
[lieu_dit_avocat_1](jusqu''à 5)    [bp_avocat_1](jusqu''à 5)
[code_postal_avocat_1](jusqu''à 5)    [localite_avocat_1](jusqu''à 5)
[cedex_avocat_1](jusqu''à 5)
[pays_avocat_1](jusqu''à 5) [division_territoriale_avocat_1](jusqu''à 5)

--Coordonnées du délégataire
[nom_delegataire]
[civilite_delegataire]
[nom_particulier_delegataire]Fsu_
[prenom_particulier_delegataire]
[raison_sociale_delegataire]
[denomination_delegataire]
[siret_delegataire]
[categorie_juridique_delegataire]
[numero_delegataire]    [voie_delegataire]    [complement_delegataire]
[lieu_dit_delegataire]    [bp_delegataire]
[code_postal_delegataire]    [ville_delegataire]    [cedex_delegataire]
[pays_delegataire] [division_territoriale_delegataire] 

-- CORRESPONDANT : destinataire du courrier. Il est le délégataire ou le pétitionnaire principal
[nom_correspondant]
[civilite_correspondant]
[nom_particulier_correspondant]
[prenom_particulier_correspondant]
[raison_sociale_correspondant]
[denomination_correspondant]
[siret_correspondant]
[categorie_juridique_correspondant]
[numero_correspondant]    [voie_correspondant]    [complement_correspondant]
[lieu_dit_correspondant]    [bp_correspondant]
[code_postal_correspondant]    [ville_correspondant]    [cedex_correspondant]
[pays_correspondant] [division_territoriale_correspondant] 

--Dates importantes du dossier d''instruction
[date_depot_dossier]
[date_completude]
[date_dernier_depot]
[date_decision_dossier]
[date_limite_dossier]
[date_achevement_dossier]
[date_conformite_dossier]
[date_notification_delai_dossier]
[date_decision_da]

--Noms des signataires
[arrete_signataire]
[signature_signataire]
[chef_division]
[chef_direction]
[libelle_direction]
[description_direction]

--Données générales des données techniques
[co_projet_desc_donnees_techniques]    [am_projet_desc_donnees_techniques]
[dm_projet_desc_donnees_techniques]    [ope_proj_desc_donnees_techniques]
[projet_desc_donnees_techniques]
[co_tot_log_nb_donnees_techniques]    [co_statio_place_nb_donnees_techniques]
[am_lot_max_nb_donnees_techniques]    [am_lot_max_shon_donnees_techniques]
-- Les données techniques suivantes concernent le tableau des surfaces
-- Elles récupèrent les valeurs du tableau composé des sous-destinations si au
-- moins une valeur de celui-ci est saisie
[su_cstr_shon_tot_donnees_techniques]    [su_demo_shon_tot_donnees_techniques]
[tab_surface_donnees_techniques]
[su_tot_shon_tot_donnees_techniques]

--Données techniques des AT
[at_type_travaux]
[at_effectif_public_total]
[at_categorie_etablissement]
[at_type_etablissement]

--Bordereau envoi au maire
[dia_mod_cess_prix_vente]
[dia_acquereur_nom_prenom]
[dia_acquereur_adresse]

--Bordereau envoi au maire
[objet_bordereau_envoi_maire]

--Données techniques du contentieux
[ctx_objet_recours_libelle]
[ctx_reference_sagace]
[ctx_nature_travaux_infra_om_html]
[ctx_synthese_nti]
[ctx_article_non_resp_om_html]
[ctx_synthese_anr]
[ctx_reference_parquet]
[ctx_element_taxation]
[ctx_infraction]
[ctx_regularisable]
[ctx_reference_courrier]
[date_audience_ctx]
[date_ajournement_ctx]
'
WHERE code = 'instruction';

--
-- END - MISE À JOUR REQUÊTES POUR CHAMPS DE FUSION RELEVANT DU CONTENTIEUX
--

--
-- /!\ NE PAS MODIFIER LE FICHIER AU-DESSUS DE CET AVERTISSEMENT /!\
--

--
-- START / #8708 Erreur de permission concernant le profil *VISUALISATION DA et DI*
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'rapport_instruction_om_fichier_rapport_instruction_telecharger',(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_om_fichier_rapport_instruction_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
    );

--
-- END / #8708 Erreur de permission concernant le profil *VISUALISATION DA et DI*
--

--
-- START - Dossier message avec la colonne à clef étrangere a null et probleme de comparaison
--

ALTER TABLE dossier_message ALTER dossier SET NOT NULL;

--
-- END - Dossier message avec la colonne à clef étrangere a null et probleme de comparaison
--

-- bypass ajout de dossier lié
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_gestion_defaut_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_gestion_defaut_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'document_numerise_supprimer_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

--
-- START - #8706 — Erreur de permission concernant les profils *SERVICE CONSULTE* et *SERVICE CONSULTE INTERNE* 
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_geolocalisation_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_geolocalisation_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
    );

--
-- END - #8706 — Erreur de permission concernant les profils *SERVICE CONSULTE* et *SERVICE CONSULTE INTERNE* 
--

--
-- START - [#659] — Widgets "Mes Recours" et "Mes Infractions" 
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
VALUES (nextval('om_widget_seq'), 'Mes Recours', 'dossier_contentieux_recours', '', 'file');

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
VALUES (nextval('om_widget_seq'), 'Mes Infraction', 'dossier_contentieux_infraction', '', 'file');


INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget) VALUES
(nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), 'C2', 2, (SELECT om_widget FROM om_widget WHERE lien = 'dossier_contentieux_infraction')),
(nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), 'C2', 2, (SELECT om_widget FROM om_widget WHERE lien = 'dossier_contentieux_infraction')),
(nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), 'C2', 1, (SELECT om_widget FROM om_widget WHERE lien = 'dossier_contentieux_recours')),
(nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C2', 1, (SELECT om_widget FROM om_widget WHERE lien = 'dossier_contentieux_recours'));

--
-- END - [#659] — Widgets "Mes Recours" et "Mes Infractions" 
--

--
-- START - Ajout du droit ajout plaignant au responsable division infraction
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'plaignant_ajouter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'plaignant_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

--
-- END - Ajout du droit ajout plaignant au responsable division infraction
--

--
-- START - Widget nouveau dossier contentieux
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Nouveau dossier contentieux','nouvelle_demande_nouveau_dossier','contexte=contentieux','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Nouveau dossier contentieux'
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'), 'C1',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Nouveau dossier contentieux')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Nouveau dossier contentieux') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), 'C1',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Nouveau dossier contentieux')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Nouveau dossier contentieux') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );

--
-- END - Widget nouveau dossier contentieux
--

--
-- /!\ NE PAS MODIFIER LE FICHIER AU-DESSUS DE CET AVERTISSEMENT /!\
--

--
-- START - Surcharge de la classe donnees_techniques
--

-- Ajout des droits liés aux données techniques des dossiers contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'donnees_techniques_contexte_ctx_modifier_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_contexte_ctx_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

--
-- END - Surcharge de la classe donnees_techniques
--


--
-- START - #639 — Visibilité des consultations de services dans les éditions 
--

-- Ajout de la colonne visible des consultation pour les masqué dans les condultation
ALTER TABLE consultation
ADD visible boolean NOT NULL DEFAULT 'true';
COMMENT ON COLUMN consultation.visible IS 'Si vrai, la consultation apparaît dans les éditions faisant appel au sous-état Liste des consultations par dossier.';

-- Mise à jour de la colonne visible à true en cas ça ne serai pas fait par la requete d'update
UPDATE consultation
SET visible = 'true';

-- Ajout de filtre sur le sous etat
UPDATE om_sousetat SET
om_sql = 'select
service.libelle||'' ''||to_char(date_envoi,''DD/MM/YYYY'')  as envoi,
avis_consultation.libelle||'' du ''||to_char(date_retour,''DD/MM/YYYY'')  as retour,
to_char(date_limite,''DD/MM/YYYY'')  as limite
from &DB_PREFIXEconsultation inner join &DB_PREFIXEservice on service.service = consultation.service
left join &DB_PREFIXEavis_consultation on avis_consultation.avis_consultation=consultation.avis_consultation
where consultation.dossier = ''&idx'' AND consultation.visible IS TRUE'
WHERE id = 'consultation';


-- Ajout de la permission a tout les profils qui ont le droit d'ajouter
-- une consultation

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_visibilite_dans_edition',
(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition'
        AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

--
-- END - #639 — Visibilité des consultations de services dans les éditions 
--

--
-- START - #640 — Modification du rapport d'instruction
--

-- Ajout de la colonne complement pour les rapports d'instruction
ALTER TABLE rapport_instruction
ADD complement_om_html text NULL;
COMMENT ON COLUMN rapport_instruction.complement_om_html IS 'Informations complementaire sur l''instruction';

-- Ajout des champs de fusion pour les éditions

UPDATE "om_requete" SET
"requete" = 'SELECT

    --Données générales du rapport d''instruction
    rapport_instruction.dossier_instruction as dossier_instruction_rapport_instruction, 
    analyse_reglementaire_om_html as analyse_reglementaire_rapport_instruction,
    description_projet_om_html as description_projet_rapport_instruction,
    proposition_decision as proposition_decision_rapport_instruction, 
    complement_om_html as complement_rapport_instruction,

    --Données générales du dossier d''instruction
    dossier.dossier_libelle as libelle_dossier, 
    dossier.dossier as code_barres_dossier,
    etat.libelle as etat_dossier,
    dossier.delai as delai_dossier,
    dossier_autorisation_type_detaille.libelle as libelle_datd, 
    avis_decision.libelle as libelle_avis_decision,

    --Adresse du terrain dossier d''instruction
    terrain_adresse_voie_numero as terrain_adresse_voie_numero_dossier,
    dossier.terrain_adresse_voie as terrain_adresse_voie_dossier,
    terrain_adresse_lieu_dit as terrain_adresse_lieu_dit_dossier,
    terrain_adresse_localite as terrain_adresse_localite_dossier,
    terrain_adresse_code_postal as terrain_adresse_code_postal_dossier,
    terrain_adresse_bp as terrain_adresse_bp_dossier,
    terrain_adresse_cedex as terrain_adresse_cedex_dossier,
    terrain_superficie as terrain_superficie_dossier,
    replace(dossier.terrain_references_cadastrales, '';'', '' '') as terrain_references_cadastrales_dossier,

    --Taxe d''aménagement du dossier d''instruction
    CASE
        WHEN tax_secteur = 1 THEN taxe_amenagement.tx_comm_secteur_1
        WHEN tax_secteur = 2 THEN taxe_amenagement.tx_comm_secteur_2
        WHEN tax_secteur = 3 THEN taxe_amenagement.tx_comm_secteur_3
        WHEN tax_secteur = 4 THEN taxe_amenagement.tx_comm_secteur_4
        WHEN tax_secteur = 5 THEN taxe_amenagement.tx_comm_secteur_5
        WHEN tax_secteur = 6 THEN taxe_amenagement.tx_comm_secteur_6
        WHEN tax_secteur = 7 THEN taxe_amenagement.tx_comm_secteur_7
        WHEN tax_secteur = 8 THEN taxe_amenagement.tx_comm_secteur_8
        WHEN tax_secteur = 9 THEN taxe_amenagement.tx_comm_secteur_9
        WHEN tax_secteur = 10 THEN taxe_amenagement.tx_comm_secteur_10
        WHEN tax_secteur = 11 THEN taxe_amenagement.tx_comm_secteur_11
        WHEN tax_secteur = 12 THEN taxe_amenagement.tx_comm_secteur_12
        WHEN tax_secteur = 13 THEN taxe_amenagement.tx_comm_secteur_13
        WHEN tax_secteur = 14 THEN taxe_amenagement.tx_comm_secteur_14
        WHEN tax_secteur = 15 THEN taxe_amenagement.tx_comm_secteur_15
        WHEN tax_secteur = 16 THEN taxe_amenagement.tx_comm_secteur_16
        WHEN tax_secteur = 17 THEN taxe_amenagement.tx_comm_secteur_17
        WHEN tax_secteur = 18 THEN taxe_amenagement.tx_comm_secteur_18
        WHEN tax_secteur = 19 THEN taxe_amenagement.tx_comm_secteur_19
        WHEN tax_secteur = 20 THEN taxe_amenagement.tx_comm_secteur_20
    END as tax_taux_secteur,
    dossier.tax_secteur as tax_numero_secteur,
    dossier.tax_mtn_part_commu as tax_montant_part_communale,
    dossier.tax_mtn_part_depart as tax_montant_part_departementale,
    dossier.tax_mtn_part_reg as tax_montant_part_regionale,
    dossier.tax_mtn_total as tax_montant_total,
    
    --Coordonnées du demandeur
    civilite.code as code_civilite,
    demandeur.particulier_nom as particulier_nom_demandeur,
    demandeur.particulier_prenom as particulier_prenom_demandeur,
    demandeur.personne_morale_denomination as personne_morale_denomination_demandeur,
    demandeur.personne_morale_raison_sociale as personne_morale_raison_sociale_demandeur,
    demandeur.personne_morale_siret as personne_morale_siret_demandeur,
    demandeur.personne_morale_nom as personne_morale_nom_demandeur,
    demandeur.personne_morale_prenom as personne_morale_prenom_demandeur,
    demandeur.numero as numero_demandeur,
    demandeur.voie as voie_demandeur,
    demandeur.complement as complement_demandeur,
    demandeur.lieu_dit as lieu_dit_demandeur,
    demandeur.localite as localite_demandeur,
    demandeur.code_postal as code_postal_demandeur,
    demandeur.bp as bp_demandeur,
    demandeur.cedex as cedex_demandeur,

    -- Coordonnées du pétitionnaire principal
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
            END
    END as nom_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier'' OR petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_nom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_denomination
    END as denomination_petitionnaire_principal,
    petitionnaire_principal.numero as numero_petitionnaire_principal,
    petitionnaire_principal.voie as voie_petitionnaire_principal,
    petitionnaire_principal.complement as complement_petitionnaire_principal,
    petitionnaire_principal.lieu_dit as lieu_dit_petitionnaire_principal,
    CASE 
        WHEN petitionnaire_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_principal.bp)
    END as bp_petitionnaire_principal,
    petitionnaire_principal.code_postal as code_postal_petitionnaire_principal,
    petitionnaire_principal.localite as localite_petitionnaire_principal,
    CASE 
        WHEN petitionnaire_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_principal.cedex)
    END as cedex_petitionnaire_principal,
    petitionnaire_principal.pays as pays_petitionnaire_principal,

    --Coordonnées du pétitionnaire 1
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_1_civilite.libelle, petitionnaire_1.particulier_nom, petitionnaire_1.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_1.personne_morale_raison_sociale, petitionnaire_1.personne_morale_denomination, ''représenté(e) par'', petitionnaire_1_civilite.libelle, petitionnaire_1.personne_morale_nom, petitionnaire_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_1.personne_morale_raison_sociale, '' '', petitionnaire_1.personne_morale_denomination))
            END
    END as nom_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier'' OR petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_1_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_nom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL
                THEN petitionnaire_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_denomination
    END as denomination_petitionnaire_1,
    petitionnaire_1.numero as numero_petitionnaire_1,
    petitionnaire_1.voie as voie_petitionnaire_1,
    petitionnaire_1.complement as complement_petitionnaire_1,
    petitionnaire_1.lieu_dit as lieu_dit_petitionnaire_1,
    CASE 
        WHEN petitionnaire_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_1.bp)
    END as bp_petitionnaire_1,
    petitionnaire_1.code_postal as code_postal_petitionnaire_1,
    petitionnaire_1.localite as localite_petitionnaire_1,
    CASE 
        WHEN petitionnaire_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_1.cedex)
    END as cedex_petitionnaire_1,
    petitionnaire_1.pays as pays_petitionnaire_1,

    --Coordonnées du pétitionnaire 2
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_2_civilite.libelle, petitionnaire_2.particulier_nom, petitionnaire_2.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_2.personne_morale_raison_sociale, petitionnaire_2.personne_morale_denomination, ''représenté(e) par'', petitionnaire_2_civilite.libelle, petitionnaire_2.personne_morale_nom, petitionnaire_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_2.personne_morale_raison_sociale, '' '', petitionnaire_2.personne_morale_denomination))
            END
    END as nom_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier'' OR petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_2_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_nom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL
                THEN petitionnaire_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_denomination
    END as denomination_petitionnaire_2,
    petitionnaire_2.numero as numero_petitionnaire_2,
    petitionnaire_2.voie as voie_petitionnaire_2,
    petitionnaire_2.complement as complement_petitionnaire_2,
    petitionnaire_2.lieu_dit as lieu_dit_petitionnaire_2,
    CASE 
        WHEN petitionnaire_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_2.bp)
    END as bp_petitionnaire_2,
    petitionnaire_2.code_postal as code_postal_petitionnaire_2,
    petitionnaire_2.localite as localite_petitionnaire_2,
    CASE 
        WHEN petitionnaire_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_2.cedex)
    END as cedex_petitionnaire_2,
    petitionnaire_2.pays as pays_petitionnaire_2,

    --Coordonnées du pétitionnaire 3
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_3_civilite.libelle, petitionnaire_3.particulier_nom, petitionnaire_3.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_3.personne_morale_raison_sociale, petitionnaire_3.personne_morale_denomination, ''représenté(e) par'', petitionnaire_3_civilite.libelle, petitionnaire_3.personne_morale_nom, petitionnaire_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_3.personne_morale_raison_sociale, '' '', petitionnaire_3.personne_morale_denomination))
            END
    END as nom_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier'' OR petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_3_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_nom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL
                THEN petitionnaire_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_denomination
    END as denomination_petitionnaire_3,
    petitionnaire_3.numero as numero_petitionnaire_3,
    petitionnaire_3.voie as voie_petitionnaire_3,
    petitionnaire_3.complement as complement_petitionnaire_3,
    petitionnaire_3.lieu_dit as lieu_dit_petitionnaire_3,
    CASE 
        WHEN petitionnaire_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_3.bp)
    END as bp_petitionnaire_3,
    petitionnaire_3.code_postal as code_postal_petitionnaire_3,
    petitionnaire_3.localite as localite_petitionnaire_3,
    CASE 
        WHEN petitionnaire_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_3.cedex)
    END as cedex_petitionnaire_3,
    petitionnaire_3.pays as pays_petitionnaire_3,

    --Coordonnées du pétitionnaire 4
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_4_civilite.libelle, petitionnaire_4.particulier_nom, petitionnaire_4.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_4.personne_morale_raison_sociale, petitionnaire_4.personne_morale_denomination, ''représenté(e) par'', petitionnaire_4_civilite.libelle, petitionnaire_4.personne_morale_nom, petitionnaire_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_4.personne_morale_raison_sociale, '' '', petitionnaire_4.personne_morale_denomination))
            END
    END as nom_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier'' OR petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_4_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_nom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL
                THEN petitionnaire_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_denomination
    END as denomination_petitionnaire_4,
    petitionnaire_4.numero as numero_petitionnaire_4,
    petitionnaire_4.voie as voie_petitionnaire_4,
    petitionnaire_4.complement as complement_petitionnaire_4,
    petitionnaire_4.lieu_dit as lieu_dit_petitionnaire_4,
    CASE 
        WHEN petitionnaire_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_4.bp)
    END as bp_petitionnaire_4,
    petitionnaire_4.code_postal as code_postal_petitionnaire_4,
    petitionnaire_4.localite as localite_petitionnaire_4,
    CASE 
        WHEN petitionnaire_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_4.cedex)
    END as cedex_petitionnaire_4,
    petitionnaire_4.pays as pays_petitionnaire_4,

    --Coordonnées du pétitionnaire 5
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_5_civilite.libelle, petitionnaire_5.particulier_nom, petitionnaire_5.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_5.personne_morale_raison_sociale, petitionnaire_5.personne_morale_denomination, ''représenté(e) par'', petitionnaire_5_civilite.libelle, petitionnaire_5.personne_morale_nom, petitionnaire_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_5.personne_morale_raison_sociale, '' '', petitionnaire_5.personne_morale_denomination))
            END
    END as nom_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier'' OR petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_5_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_nom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL
                THEN petitionnaire_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_denomination
    END as denomination_petitionnaire_5,
    petitionnaire_5.numero as numero_petitionnaire_5,
    petitionnaire_5.voie as voie_petitionnaire_5,
    petitionnaire_5.complement as complement_petitionnaire_5,
    petitionnaire_5.lieu_dit as lieu_dit_petitionnaire_5,
    CASE 
        WHEN petitionnaire_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_5.bp)
    END as bp_petitionnaire_5,
    petitionnaire_5.code_postal as code_postal_petitionnaire_5,
    petitionnaire_5.localite as localite_petitionnaire_5,
    CASE 
        WHEN petitionnaire_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_5.cedex)
    END as cedex_petitionnaire_5,
    petitionnaire_5.pays as pays_petitionnaire_5,
    
    --Nom de l''instructeur
    instructeur.nom as nom_instructeur, 

    --Noms des signataires
    division.chef as chef_division,
    direction.chef as chef_direction,
    direction.libelle as libelle_direction,
    direction.description as description_direction,

    --Données techniques
    donnees_techniques.co_projet_desc as co_projet_desc_donnees_techniques,
    donnees_techniques.am_projet_desc as am_projet_desc_donnees_techniques,
    donnees_techniques.dm_projet_desc as dm_projet_desc_donnees_techniques,
    donnees_techniques.ope_proj_desc as ope_proj_desc_donnees_techniques,
    TRIM(CONCAT(
        donnees_techniques.co_projet_desc, '' '',
        donnees_techniques.am_projet_desc, '' '',
        donnees_techniques.dm_projet_desc, '' '',
        donnees_techniques.ope_proj_desc
        )) as projet_desc_donnees_techniques,
    donnees_techniques.am_lot_max_nb as am_lot_max_nb_donnees_techniques,
    donnees_techniques.am_lot_max_shon as am_lot_max_shon_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN donnees_techniques.su2_cstr_shon_tot
        ELSE donnees_techniques.su_cstr_shon_tot
    END as su_cstr_shon_tot_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN donnees_techniques.su2_demo_shon_tot
        ELSE donnees_techniques.su_demo_shon_tot
    END as su_demo_shon_tot_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN
            REGEXP_REPLACE(CONCAT(
                CASE WHEN donnees_techniques.su2_cstr_shon1 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Exploitation agricole - '', donnees_techniques.su2_cstr_shon1, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon2 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Exploitation forestière - '', donnees_techniques.su2_cstr_shon2, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon3 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Logement - '', donnees_techniques.su2_cstr_shon3, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon4 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Hébergement - '', donnees_techniques.su2_cstr_shon4, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon5 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Artisanat et commerce de détail - '', donnees_techniques.su2_cstr_shon5, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon6 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Restauration - '', donnees_techniques.su2_cstr_shon6, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon7 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Commerce de gros - '', donnees_techniques.su2_cstr_shon7, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon8 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Activités de services où s''''effectue l''''accueil d''''une clientèle - '', donnees_techniques.su2_cstr_shon8, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon9 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Hébergement hôtelier et touristique - '', donnees_techniques.su2_cstr_shon9, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon10 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Cinéma - '', donnees_techniques.su2_cstr_shon10, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon11 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Locaux et bureaux accueillant du public des administrations publiques et assimilés - '', donnees_techniques.su2_cstr_shon11, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon12 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Locaux techniques et industriels des administrations publiques et assimilés - '', donnees_techniques.su2_cstr_shon12, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon13 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Établissements d''''enseignement, de santé et d''''action sociale - '', donnees_techniques.su2_cstr_shon13, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon14 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Salles d''''art et de spectacles - '', donnees_techniques.su2_cstr_shon14, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon15 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Équipements sportifs - '', donnees_techniques.su2_cstr_shon15, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon16 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Autres équipements recevant du public - '', donnees_techniques.su2_cstr_shon16, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon17 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Industrie - '', donnees_techniques.su2_cstr_shon17, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon18 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Entrepôt - '', donnees_techniques.su2_cstr_shon18, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon19 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Bureau - '', donnees_techniques.su2_cstr_shon19, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon20 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Centre de congrès et d''''exposition - '', donnees_techniques.su2_cstr_shon20, '' m²'')
                END
            ), '' / $'', '''')
        ELSE
            REGEXP_REPLACE(CONCAT(
                CASE
                    WHEN donnees_techniques.su_cstr_shon1 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Habitation - '', donnees_techniques.su_cstr_shon1, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon2 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Hébergement hôtelier - '', donnees_techniques.su_cstr_shon2, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon3 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Bureaux - '', donnees_techniques.su_cstr_shon3, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon4 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Commerce - '', donnees_techniques.su_cstr_shon4, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon5 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Artisanat - '', donnees_techniques.su_cstr_shon5, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon6 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Industrie - '', donnees_techniques.su_cstr_shon6, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon7 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Exploitation agricole ou forestière - '', donnees_techniques.su_cstr_shon7, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon8 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Entrepôt - '', donnees_techniques.su_cstr_shon8, '' m² / '')
                END, 
                CASE
                    WHEN donnees_techniques.su_cstr_shon9 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Service public ou d''''intérêt collectif - '', donnees_techniques.su_cstr_shon9, '' m²'')
                END
            ), '' / $'', '''')
    END as tab_surface_donnees_techniques,
    donnees_techniques.co_tot_log_nb as co_tot_log_nb_donnees_techniques,
    donnees_techniques.co_statio_place_nb as co_statio_place_nb_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        THEN donnees_techniques.su2_tot_shon_tot
        ELSE donnees_techniques.su_tot_shon_tot
    END as su_tot_shon_tot_donnees_techniques

FROM

    &DB_PREFIXErapport_instruction 
    LEFT JOIN &DB_PREFIXEdossier 
        ON dossier.dossier=rapport_instruction.dossier_instruction 
    LEFT JOIN &DB_PREFIXEavis_decision 
        ON dossier.avis_decision = avis_decision.avis_decision
    LEFT JOIN &DB_PREFIXEetat
        ON dossier.etat = etat.etat
    LEFT JOIN &DB_PREFIXEdonnees_techniques
        ON dossier.dossier = donnees_techniques.dossier_instruction
    LEFT JOIN &DB_PREFIXEdivision
        ON dossier.division = division.division
    LEFT JOIN &DB_PREFIXEdirection
        ON division.direction = direction.direction
    LEFT JOIN &DB_PREFIXEinstructeur 
        ON instructeur.instructeur=dossier.instructeur 
    LEFT JOIN &DB_PREFIXElien_dossier_demandeur 
        ON lien_dossier_demandeur.dossier=dossier.dossier 
    LEFT JOIN &DB_PREFIXEdemandeur 
        ON demandeur.demandeur=lien_dossier_demandeur.demandeur
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_principal
        ON lien_dossier_demandeur.demandeur = petitionnaire_principal.demandeur AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_principal_civilite
        ON petitionnaire_principal.personne_morale_civilite=petitionnaire_principal_civilite.civilite OR petitionnaire_principal.particulier_civilite=petitionnaire_principal_civilite.civilite
    LEFT JOIN (
        SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS petitionnaire_autre
        FROM &DB_PREFIXElien_dossier_demandeur
        LEFT JOIN &DB_PREFIXEdossier
            ON lien_dossier_demandeur.dossier=dossier.dossier 
            AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
        LEFT JOIN &DB_PREFIXErapport_instruction
            ON rapport_instruction.dossier_instruction = dossier.dossier
        WHERE rapport_instruction.rapport_instruction = &idx
        GROUP BY lien_dossier_demandeur.dossier
    ) as sub_petitionnaire_autre
    ON rapport_instruction.dossier_instruction = sub_petitionnaire_autre.dossier
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_1
    ON
        petitionnaire_1.demandeur = petitionnaire_autre[1] AND petitionnaire_1.type_demandeur != ''delegataire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_1_civilite
    ON
        petitionnaire_1.particulier_civilite = petitionnaire_1_civilite.civilite OR petitionnaire_1.personne_morale_civilite = petitionnaire_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_2
    ON
        petitionnaire_2.demandeur = petitionnaire_autre[2] AND petitionnaire_2.type_demandeur != ''delegataire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_2_civilite
    ON
        petitionnaire_2.particulier_civilite = petitionnaire_2_civilite.civilite OR petitionnaire_2.personne_morale_civilite = petitionnaire_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_3
    ON
        petitionnaire_3.demandeur = petitionnaire_autre[3] AND petitionnaire_3.type_demandeur != ''delegataire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_3_civilite
    ON
        petitionnaire_3.particulier_civilite = petitionnaire_3_civilite.civilite OR petitionnaire_3.personne_morale_civilite = petitionnaire_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_4
    ON
        petitionnaire_4.demandeur = petitionnaire_autre[4] AND petitionnaire_4.type_demandeur != ''delegataire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_4_civilite
    ON
        petitionnaire_4.particulier_civilite = petitionnaire_4_civilite.civilite OR petitionnaire_4.personne_morale_civilite = petitionnaire_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_5
    ON
        petitionnaire_5.demandeur = petitionnaire_autre[5] AND petitionnaire_5.type_demandeur != ''delegataire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_5_civilite
    ON
        petitionnaire_5.particulier_civilite = petitionnaire_5_civilite.civilite OR petitionnaire_5.personne_morale_civilite = petitionnaire_5_civilite.civilite
    LEFT JOIN &DB_PREFIXEcivilite 
        ON demandeur.personne_morale_civilite=civilite.civilite OR demandeur.particulier_civilite=civilite.civilite 
    LEFT JOIN &DB_PREFIXEdossier_instruction_type 
        ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type 
    LEFT JOIN &DB_PREFIXEdossier_autorisation_type_detaille 
        ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
    LEFT JOIN
        &DB_PREFIXEtaxe_amenagement
        ON
            dossier.om_collectivite = taxe_amenagement.om_collectivite
WHERE rapport_instruction = &idx AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
',
"merge_fields" = '--Données générales du rapport d''instruction
[dossier_instruction_rapport_instruction]    [analyse_reglementaire_rapport_instruction]
[description_projet_rapport_instruction]    [proposition_decision_rapport_instruction]
[complement_rapport_instruction]

--Données générales du dossier d''instruction
[libelle_dossier]    [code_barres_dossier]    [etat_dossier]
[delai_dossier]    [libelle_datd]
[libelle_avis_decision]

--Adresse du terrain dossier d''instruction
[terrain_adresse_voie_numero_dossier]     [terrain_adresse_voie_dossier]
[terrain_adresse_lieu_dit_dossier]
[terrain_adresse_code_postal_dossier]    [terrain_adresse_localite_dossier]    [terrain_adresse_bp_dossier]
[terrain_adresse_cedex_dossier]    [terrain_superficie_dossier]
[terrain_references_cadastrales_dossier]

--Taxe d''aménagement du dossier d''instruction
[tax_taux_secteur]
[tax_numero_secteur]
[tax_montant_part_communale]
[tax_montant_part_departementale]
[tax_montant_part_regionale]
[tax_montant_total]

--Coordonnées du demandeur
[code_civilite]
[particulier_nom_demandeur]    [particulier_prenom_demandeur]    
[personne_morale_denomination_demandeur]    [personne_morale_raison_sociale_demandeur]    [personne_morale_siret_demandeur]
[personne_morale_nom_demandeur]    [personne_morale_prenom_demandeur]
[numero_demandeur]    [voie_demandeur]
[complement_demandeur]    [lieu_dit_demandeur]
[code_postal_demandeur]    [localite_demandeur]   [bp_demandeur]    [cedex_demandeur]

--Coordonnées du pétitionnaire principal
[nom_petitionnaire_principal]
[civilite_petitionnaire_principal]
[nom_particulier_petitionnaire_principal]
[prenom_particulier_petitionnaire_principal]
[raison_sociale_petitionnaire_principal]
[denomination_petitionnaire_principal]
[numero_petitionnaire_principal]    [voie_petitionnaire_principal]    [complement_petitionnaire_principal]
[lieu_dit_petitionnaire_principal]    [bp_petitionnaire_principal]
[code_postal_petitionnaire_principal]    [localite_petitionnaire_principal]    [cedex_petitionnaire_principal]
[pays_petitionnaire_principal]

--Coordonnées des autres pétitionnaires
[nom_petitionnaire_1](jusqu''à 5)
[civilite_petitionnaire_1](jusqu''à 5)
[nom_particulier_petitionnaire_1](jusqu''à 5)
[prenom_particulier_petitionnaire_1](jusqu''à 5)
[raison_sociale_petitionnaire_1](jusqu''à 5)
[denomination_petitionnaire_1](jusqu''à 5)
[numero_petitionnaire_1](jusqu''à 5)    [voie_petitionnaire_1](jusqu''à 5)    
[complement_petitionnaire_1](jusqu''à 5)
[lieu_dit_petitionnaire_1](jusqu''à 5)    [bp_petitionnaire_1](jusqu''à 5)
[code_postal_petitionnaire_1](jusqu''à 5)    [localite_petitionnaire_1](jusqu''à 5)    
[cedex_petitionnaire_1](jusqu''à 5)
[pays_petitionnaire_1](jusqu''à 5)

--Nom de l''instructeur
[nom_instructeur]

--Noms des signataires
[chef_division]
[chef_direction]
[libelle_direction]
[description_direction]

--Données techniques
[co_projet_desc_donnees_techniques]    [am_projet_desc_donnees_techniques]
[dm_projet_desc_donnees_techniques]    [ope_proj_desc_donnees_techniques]
[projet_desc_donnees_techniques]
[am_lot_max_nb_donnees_techniques]    [am_lot_max_shon_donnees_techniques]    
[co_tot_log_nb_donnees_techniques]     [co_statio_place_nb_donnees_techniques]
-- Les données techniques suivantes concernent le tableau des surfaces
-- Elles récupèrent les valeurs du tableau composé des sous-destinations si au
-- moins une valeur de celui-ci est saisie
[su_cstr_shon_tot_donnees_techniques]    [su_demo_shon_tot_donnees_techniques]    
[tab_surface_donnees_techniques]
[su_tot_shon_tot_donnees_techniques]
'
WHERE ((code = 'rapport_instruction'));

--
-- END - #640 — Modification du rapport d'instruction
--

-- Ajout groupes au profil service consulté étendu

INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU'), (SELECT groupe FROM groupe WHERE code = 'ADS'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ADS'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU'), (SELECT groupe FROM groupe WHERE code = 'CU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'CU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU'), (SELECT groupe FROM groupe WHERE code = 'RU'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'RU'
);
INSERT INTO lien_om_profil_groupe SELECT nextval('lien_om_profil_groupe_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU'), (SELECT groupe FROM groupe WHERE code = 'ERP'), false, true
WHERE EXISTS (
    SELECT groupe FROM groupe WHERE code = 'ERP'
);

--
-- START - Suppression des droits liés au rapport d'instruction pour les profils contentieux
--

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND om_droit.libelle = 'rapport_instruction_ajouter'
    AND (om_profil.libelle = 'ASSISTANTE'
        OR om_profil.libelle = 'TECHNICIEN'
        OR om_profil.libelle = 'RESPONSABLE DIVISION INFRACTION'
        OR om_profil.libelle = 'CHEF DE SERVICE CONTENTIEUX'
        OR om_profil.libelle = 'JURISTE');

--
-- END - Suppression des droits liés au rapport d'instruction pour les profils contentieux
--


--
-- START - Différenciation des droits du tableau des dossiers liés selon le contexte
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_lies_contexte_ctx_tab',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_lies_contexte_ctx_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND om_droit.libelle LIKE 'lien_dossier_dossier_gestion_defaut%'
    AND (om_profil.libelle = 'ASSISTANTE'
        OR om_profil.libelle = 'TECHNICIEN'
        OR om_profil.libelle = 'RESPONSABLE DIVISION INFRACTION'
        OR om_profil.libelle = 'CHEF DE SERVICE CONTENTIEUX'
        OR om_profil.libelle = 'JURISTE');

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND om_droit.libelle LIKE 'dossier_instruction_supprimer_liaison'
    AND (om_profil.libelle = 'ASSISTANTE'
        OR om_profil.libelle = 'TECHNICIEN'
        OR om_profil.libelle = 'RESPONSABLE DIVISION INFRACTION'
        OR om_profil.libelle = 'CHEF DE SERVICE CONTENTIEUX'
        OR om_profil.libelle = 'JURISTE');

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND om_droit.libelle = 'lien_dossier_dossier_contexte_ctx_inf_gestion_defaut'
    AND (om_profil.libelle = 'INSTRUCTEUR'
        OR om_profil.libelle = 'CHEF DE SERVICE'
        OR om_profil.libelle = 'DIVISIONNAIRE');

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND om_droit.libelle = 'lien_dossier_dossier_contexte_ctx_re_gestion_defaut'
    AND (om_profil.libelle = 'INSTRUCTEUR'
        OR om_profil.libelle = 'CHEF DE SERVICE'
        OR om_profil.libelle = 'DIVISIONNAIRE'
        OR om_profil.libelle = 'INSTRUCTEUR SERVICE');

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND om_droit.libelle = 'lien_dossier_dossier_gestion_defaut_bypass'
    AND (om_profil.libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL'
        OR om_profil.libelle = 'ADMINISTRATEUR GENERAL'
        OR om_profil.libelle = 'DIVISIONNAIRE'
        OR om_profil.libelle = 'INSTRUCTEUR SERVICE');

UPDATE om_droit
SET libelle = 'lien_dossier_dossier_ajouter'
WHERE libelle = 'lien_dossier_dossier_gestion_defaut';

DELETE FROM om_droit
WHERE libelle = 'dossier_lies_contexte_ctx_tab';

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_re_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_re_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_contexte_ctx_inf_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_contexte_ctx_inf_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'lien_dossier_dossier_ajouter_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Ajout des droits de suppression des liaisons automatiques pour les contextes CTX

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_supprimer_liaison',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_supprimer_liaison' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_supprimer_liaison_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_supprimer_liaison_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
);


INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
);


INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_supprimer_liaison_auto',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_supprimer_liaison_auto' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

--
-- END - Différenciation des droits du tableau des dossiers liés selon le contexte
--

--
-- START / Ajouter 2 requêtes de statistiques à la demande des dossiers CTX 
--

-- Ajout des permissions aux profils contentieux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_export',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_export' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_export',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_export' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_export',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_export' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_export',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_export' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'menu_export',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'menu_export' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
--INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'reqmo_pilot',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'reqmo_pilot' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'reqmo_pilot',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'reqmo_pilot' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'reqmo_pilot',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'reqmo_pilot' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'reqmo_pilot',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'reqmo_pilot' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'reqmo_pilot',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'reqmo_pilot' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

--
-- END / Ajouter 2 requêtes de statistiques à la demande des dossiers CTX 
--

--
-- START / Widget "Mes messages" pour les profils CTX
--

-- ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_mes_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_mes_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_tous_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_tous_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_retours_ma_division',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_retours_ma_division' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

-- CHEF DE SERVICE CONTENTIEUX
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_mes_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_mes_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_tous_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_tous_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_retours_ma_division',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_retours_ma_division' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );

-- JURISTE
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_mes_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_mes_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_tous_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_tous_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_retours_ma_division',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_retours_ma_division' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );

-- TECHNICIEN
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_mes_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_mes_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_tous_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_tous_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_retours_ma_division',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_retours_ma_division' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );

-- RESPONSABLE DIVISION INFRACTION
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_mes_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_mes_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_tous_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_tous_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_contentieux_retours_ma_division',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_contentieux_retours_ma_division' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );

-- Ajout des widgets
INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Mes messages du contentieux','messages_retours','filtre=instructeur
contexte=contentieux','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Mes messages du contentieux'
    );
INSERT INTO om_widget (om_widget, libelle, lien, texte, type)
SELECT nextval('om_widget_seq'), 'Les messages du contentieux','messages_retours','filtre=division
contexte=contentieux','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Les messages du contentieux'
    );

-- Ajout dans le dashboard
-- CHEF DE SERVICE CONTENTIEUX
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C1',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les messages du contentieux')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les messages du contentieux') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'), 'C2',   4,  (SELECT om_widget FROM om_widget WHERE libelle = 'Mes messages du contentieux')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes messages du contentieux') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );
-- RESPONSABLE DIVISION INFRACTION
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), 'C3',   3,  (SELECT om_widget FROM om_widget WHERE libelle = 'Les messages du contentieux')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les messages du contentieux') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'), 'C3',   4,  (SELECT om_widget FROM om_widget WHERE libelle = 'Mes messages du contentieux')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes messages du contentieux') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );
-- JURISTE
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'), 'C3',   4,  (SELECT om_widget FROM om_widget WHERE libelle = 'Mes messages du contentieux')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes messages du contentieux') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );
-- TECHNICIEN
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'), 'C3',   4,  (SELECT om_widget FROM om_widget WHERE libelle = 'Mes messages du contentieux')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Mes messages du contentieux') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );

--
-- END / Widget "Mes messages" pour les profils CTX
--

--
-- START / Ajout de permissions manquantes 
--

-- Menu export / import
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'reqmo_pilot',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'reqmo_pilot' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );

-- Récépissé dans message de validation ajout demande
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'demande_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
    );  
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'demande_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
    );  
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'demande_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
    );  
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'demande_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
    );  
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'demande_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
    );  
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'demande_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
    );  
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'demande_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
    );  
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'demande_consulter',(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'demande_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
    );  

--
-- END / Ajout de permissions manquantes 
--

--
-- START / Suppression de la permission d'accès aux données techniques des INF
--

--
DELETE FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    AND EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    );
--
DELETE FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
    AND EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
    );
--
DELETE FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    AND EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    );
--
DELETE FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    AND EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_donnees_techniques_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );


INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_mes_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_mes_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );  

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'consultation_retours_ma_division',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_retours_ma_division' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );  

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_mes_retours',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_mes_retours' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );  

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'messages_retours_ma_division',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'messages_retours_ma_division' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    ); 

--
-- END / Suppression de la permission d'accès aux données techniques des INF
--
