-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.17.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.17.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#10131] - Notion de nature des travaux 
--

CREATE TABLE IF NOT EXISTS famille_travaux (
    famille_travaux INTEGER NOT NULL,
    libelle CHARACTER VARYING(255) NOT NULL,
    code CHARACTER VARYING(50),
    description TEXT,
    om_validite_debut DATE,
    om_validite_fin DATE,
    CONSTRAINT famille_travaux_pkey PRIMARY KEY (famille_travaux)
);

COMMENT ON COLUMN famille_travaux.famille_travaux IS 'Identifiant unique numérique';
COMMENT ON COLUMN famille_travaux.libelle IS 'Nom de la famille de travaux';
COMMENT ON COLUMN famille_travaux.code IS 'Code de la famille de travaux';
COMMENT ON COLUMN famille_travaux.description IS 'Description de la famille de travaux';
COMMENT ON COLUMN famille_travaux.om_validite_debut IS 'Date de début de validité';
COMMENT ON COLUMN famille_travaux.om_validite_fin IS 'Date de fin de validité';

-- Séquence de la table famille_travaux
CREATE SEQUENCE IF NOT EXISTS famille_travaux_seq
   START WITH 1
   INCREMENT BY 1
   NO MINVALUE
   NO MAXVALUE
   CACHE 1;


CREATE TABLE IF NOT EXISTS nature_travaux (
    nature_travaux INTEGER NOT NULL,
    libelle CHARACTER VARYING(255) NOT NULL,
    code CHARACTER VARYING(50),
    famille_travaux INTEGER NOT NULL,
    description TEXT,
    om_validite_debut DATE,
    om_validite_fin DATE,
    CONSTRAINT nature_travaux_pkey PRIMARY KEY (nature_travaux)
);

COMMENT ON COLUMN nature_travaux.nature_travaux IS 'Identifiant unique numérique';
COMMENT ON COLUMN nature_travaux.libelle IS 'Nom de la nature de travaux';
COMMENT ON COLUMN nature_travaux.code IS 'Code de la nature de travaux';
COMMENT ON COLUMN nature_travaux.description IS 'Description de la nature de travaux';
COMMENT ON COLUMN nature_travaux.famille_travaux IS 'Lien vers la famille de travaux associée';
COMMENT ON COLUMN nature_travaux.om_validite_debut IS 'Date de début de validité';
COMMENT ON COLUMN nature_travaux.om_validite_fin IS 'Date de fin de validité';

-- Séquence de la table nature_travaux
CREATE SEQUENCE IF NOT EXISTS nature_travaux_seq
   START WITH 1
   INCREMENT BY 1
   NO MINVALUE
   NO MAXVALUE
   CACHE 1;


-- Ajout des contraintes sur famille_travaux
ALTER TABLE nature_travaux
    DROP CONSTRAINT IF EXISTS nature_travaux_famille_travaux_fkey;
ALTER TABLE nature_travaux
    ADD CONSTRAINT nature_travaux_famille_travaux_fkey FOREIGN KEY (famille_travaux) REFERENCES famille_travaux (famille_travaux);

CREATE TABLE IF NOT EXISTS lien_dit_nature_travaux (
    lien_dit_nature_travaux INTEGER NOT NULL,
    dossier_instruction_type INTEGER NOT NULL,
    nature_travaux INTEGER NOT NULL,
    CONSTRAINT lien_dit_nature_travaux_pkey PRIMARY KEY (lien_dit_nature_travaux)
);

CREATE INDEX IF NOT EXISTS lien_dit_nature_travaux_dit ON lien_dit_nature_travaux (dossier_instruction_type);
CREATE INDEX IF NOT EXISTS lien_dit_nature_travaux_nt ON lien_dit_nature_travaux (nature_travaux);

COMMENT ON TABLE lien_dit_nature_travaux IS 'Nature de travaux associé à un type de dossier';
COMMENT ON COLUMN lien_dit_nature_travaux.lien_dit_nature_travaux IS 'Identifiant unique';
COMMENT ON COLUMN lien_dit_nature_travaux.dossier_instruction_type IS 'Identifiant du type de dossier d''instruction';
COMMENT ON COLUMN lien_dit_nature_travaux.nature_travaux IS 'Identifiant de la nature de travaux';

-- Séquence de la table lien_dit_nature_travaux
CREATE SEQUENCE IF NOT EXISTS lien_dit_nature_travaux_seq
   START WITH 1
   INCREMENT BY 1
   NO MINVALUE
   NO MAXVALUE
   CACHE 1;

-- Contraintes de la table lien_dit_nature_travaux
ALTER TABLE ONLY lien_dit_nature_travaux
   DROP CONSTRAINT IF EXISTS lien_dit_nature_travaux_dit_fkey,
   DROP CONSTRAINT IF EXISTS lien_dit_nature_travaux_nature_travaux_fkey,
   DROP CONSTRAINT IF EXISTS lien_dossier_instruction_type_nature_travaux_unique;
ALTER TABLE ONLY lien_dit_nature_travaux
   ADD CONSTRAINT lien_dit_nature_travaux_dit_fkey FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type),
   ADD CONSTRAINT lien_dit_nature_travaux_nature_travaux_fkey FOREIGN KEY (nature_travaux) REFERENCES nature_travaux(nature_travaux),
   ADD CONSTRAINT lien_dossier_instruction_type_nature_travaux_unique UNIQUE (dossier_instruction_type, nature_travaux);

-- Ajout de la table lien_dossier_nature_travaux
CREATE TABLE IF NOT EXISTS lien_dossier_nature_travaux (
    lien_dossier_nature_travaux INTEGER NOT NULL,
    dossier CHARACTER VARYING(255) NOT NULL,
    nature_travaux INTEGER NOT NULL,
    CONSTRAINT lien_dossier_nature_travaux_pkey PRIMARY KEY (lien_dossier_nature_travaux)
);

CREATE INDEX IF NOT EXISTS lien_dossier_nature_travaux_dossier ON lien_dossier_nature_travaux (dossier);
CREATE INDEX IF NOT EXISTS lien_dossier_nature_travaux_nt ON lien_dossier_nature_travaux (nature_travaux);

COMMENT ON TABLE lien_dossier_nature_travaux IS 'Nature de travaux associé à un dossier';
COMMENT ON COLUMN lien_dossier_nature_travaux.lien_dossier_nature_travaux IS 'Identifiant unique';
COMMENT ON COLUMN lien_dossier_nature_travaux.dossier IS 'Identifiant du dossier d''instruction';
COMMENT ON COLUMN lien_dossier_nature_travaux.nature_travaux IS 'Identifiant de la nature de travaux';

-- Séquence de la table lien_dossier_nature_travaux
CREATE SEQUENCE IF NOT EXISTS lien_dossier_nature_travaux_seq
   START WITH 1
   INCREMENT BY 1
   NO MINVALUE
   NO MAXVALUE
   CACHE 1;

-- Contraintes de la table lien_dossier_nature_travaux
ALTER TABLE ONLY lien_dossier_nature_travaux
   DROP CONSTRAINT IF EXISTS lien_dossier_nature_travaux_di_fkey,
   DROP CONSTRAINT IF EXISTS lien_dossier_nature_travaux_nature_travaux_fkey,
   DROP CONSTRAINT IF EXISTS lien_dossier_nature_travaux_unique;
ALTER TABLE ONLY lien_dossier_nature_travaux
   ADD CONSTRAINT lien_dossier_nature_travaux_di_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier),
   ADD CONSTRAINT lien_dossier_nature_travaux_nature_travaux_fkey FOREIGN KEY (nature_travaux) REFERENCES nature_travaux(nature_travaux),
   ADD CONSTRAINT lien_dossier_nature_travaux_unique UNIQUE (dossier, nature_travaux);

-- Permission pour nature et famille de travaux
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'nature_travaux', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'nature_travaux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'famille_travaux', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'famille_travaux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'nature_travaux', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'nature_travaux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'famille_travaux', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'famille_travaux' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

--
-- END / [#10131] - Notion de nature des travaux 
--

--
-- BEGIN / [#10115] - Ajouter le champ motif_pec sur les consultation
--

ALTER TABLE consultation ADD COLUMN IF NOT EXISTS motif_pec text;
COMMENT ON COLUMN consultation.motif_pec IS 'Permet de stocker le motif de la pec';

--
-- END / [#10115] - Ajouter le champ motif_pec sur les consultation
--

--
-- BEGIN /  #1629 — Ajout commentaire table compteur
--

-- Ajout commentaire table compteur
COMMENT ON COLUMN compteur.compteur IS 'Identifiant technique interne du compteur';
COMMENT ON COLUMN compteur.code IS 'Code métier du compteur';
COMMENT ON COLUMN compteur.description IS 'Description des données décomptées';
COMMENT ON COLUMN compteur.unite IS 'Unité de mesure du compteur';
COMMENT ON COLUMN compteur.quantite IS 'Valeur du compteur';
COMMENT ON COLUMN compteur.quota IS 'Seuil au delà duquel le client est hors contrat';
COMMENT ON COLUMN compteur.alerte IS 'Seuil au delà duquel l''utilisateur est averti qu''il se rapproche du quota';
COMMENT ON COLUMN compteur.om_collectivite IS 'Identifiant de la collectivité';
COMMENT ON COLUMN compteur.date_modification IS 'Date de dernière modification du compteur';
COMMENT ON COLUMN compteur.om_validite_debut IS 'Date de début de validité du compteur';
COMMENT ON COLUMN compteur.om_validite_fin IS 'Date de fin de validité du compteur';

--
-- END /  #1629 — Ajout commentaire table compteur
--

--
-- BEGIN / [#10121] Renommer les champs dans les CERFA et données techniques
--

--
COMMENT ON COLUMN donnees_techniques.daact_surf IS 'Surface de plancher créée (en m2)';
COMMENT ON COLUMN cerfa.daact_surf IS 'Surface de plancher créée (en m2)';

-- Oubli dans la version précédente (fait seulement sur la table donnees_techniques)
COMMENT ON COLUMN cerfa.co_fin_autr_nb IS 'Répartition du nombre total de logement créés par type de financement : Autres financements [SUPPRIMÉ]';

--
-- END / [#10121] Renommer les champs dans les CERFA et données techniques
--

--
-- BEGIN / [#10122] Ajout de champs de fusion
--

-- Mise à jour de la requête d'instruction
\i v5.17.0-om_requete.sql

--
-- END / [#10122] Ajout de champs de fusion
--

--
-- BEGIN / [#10128] - suggestion d'évènements en fonction des contraintes applicables au dossier 
--

-- Table de liaison lien_sig_contrainte_evenement entre les tables contrainte_sig et evenement
CREATE TABLE IF NOT EXISTS lien_sig_contrainte_evenement(
   lien_sig_contrainte_evenement INTEGER NOT NULL,
   sig_contrainte INTEGER NOT NULL,
   evenement INTEGER NOT NULL,
   CONSTRAINT lien_sig_contrainte_evenement_pkey PRIMARY KEY (lien_sig_contrainte_evenement)
);

-- Séquence de la table lien_sig_contrainte_evenement
CREATE SEQUENCE IF NOT EXISTS lien_sig_contrainte_evenement_seq
   START WITH 1
   INCREMENT BY 1
   NO MINVALUE
   NO MAXVALUE
   CACHE 1;

-- Contrainte de la table lien_sig_contrainte_evenement
ALTER TABLE ONLY lien_sig_contrainte_evenement
   DROP CONSTRAINT IF EXISTS lien_sig_contrainte_evenement_sig_contrainte_fkey,
   DROP CONSTRAINT IF EXISTS lien_sig_contrainte_evenement_evenement_fkey,
   DROP CONSTRAINT IF EXISTS lien_sig_contrainte_evenement_unique,
   ADD CONSTRAINT lien_sig_contrainte_evenement_sig_contrainte_fkey FOREIGN KEY (sig_contrainte) REFERENCES sig_contrainte(sig_contrainte),
   ADD CONSTRAINT lien_sig_contrainte_evenement_evenement_fkey FOREIGN KEY (evenement) REFERENCES evenement(evenement),
   ADD CONSTRAINT lien_sig_contrainte_evenement_unique UNIQUE (sig_contrainte, evenement);

-- Commentaire de la table lien_sig_contrainte_evenement
COMMENT ON TABLE lien_sig_contrainte_evenement IS 'Évènements suggérés associés aux contraintes.';
COMMENT ON COLUMN lien_sig_contrainte_evenement.lien_sig_contrainte_evenement IS 'Identifiant unique de l''évènement suggéré.';
COMMENT ON COLUMN lien_sig_contrainte_evenement.sig_contrainte IS 'Identifiant de la contrainte.';
COMMENT ON COLUMN lien_sig_contrainte_evenement.evenement IS 'Identifiant de l''évènement';

-- Permissions de la table lien_sig_contrainte_evenement
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lien_sig_contrainte_evenement', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_sig_contrainte_evenement' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Index
CREATE INDEX IF NOT EXISTS collectivite_niveau ON om_collectivite (niveau);
CREATE INDEX IF NOT EXISTS contrainte_libelle ON contrainte (libelle);
CREATE INDEX IF NOT EXISTS sig_contrainte_libelle ON sig_contrainte (libelle);
CREATE INDEX IF NOT EXISTS dossier_dossier_instruction_type ON dossier (dossier_instruction_type);
CREATE INDEX IF NOT EXISTS evenement_type ON evenement (type);

--
-- END / [#10128] - suggestion d'évènements en fonction des contraintes applicables au dossier 
--

--
-- BEGIN / [#10127] Corriger le tri de la liste des types de pièces
--

-- Dans le champ lien_document_n_type_d_i_t.code il ne doit pas y avoir plus de
-- deux fois le caractères "-" (tiret)
ALTER TABLE ONLY lien_document_n_type_d_i_t DROP CONSTRAINT IF EXISTS lien_document_n_type_d_i_t__code__check;
ALTER TABLE ONLY lien_document_n_type_d_i_t
    ADD CONSTRAINT lien_document_n_type_d_i_t__code__check CHECK ((CHAR_LENGTH(code) - CHAR_LENGTH(REPLACE(code, '-', ''))) < 3);

--
-- END / [#10127] Corriger le tri de la liste des types de pièces
--

--
-- BEGIN / [#10124] Amélioration de la fonction SQL pour l'affichage d'une adresse
--

--
DROP FUNCTION IF EXISTS adresse(text, text, text, text, text, text, text, text, text, text);
DROP FUNCTION IF EXISTS adresse(text, text, text, text, text, text, text, text, text);
CREATE OR REPLACE FUNCTION adresse(
    numero text,
    voie text,
    complement text,
    lieu_dit text,
    bp text,
    code_postal text,
    localite text,
    cedex text,
    pays text DEFAULT '',
    separateur text DEFAULT '<br>') RETURNS text AS $$

    SELECT TRIM(CONCAT(
        CASE WHEN COALESCE(numero, '') != '' THEN CONCAT(numero, ' ') END,
        CASE WHEN COALESCE(voie, '') != '' THEN CONCAT(voie, separateur) END,
        CASE WHEN COALESCE(complement, '') != '' THEN CONCAT(complement, separateur) END,
        CASE WHEN COALESCE(lieu_dit, '') != '' THEN CONCAT('Lieu-dit ', lieu_dit, separateur) END,
        CASE WHEN COALESCE(bp, '') != '' THEN CONCAT('BP ', bp, separateur) END, 
        CASE WHEN COALESCE(code_postal, '') != '' THEN CONCAT(code_postal, ' ') END,
        CASE WHEN COALESCE(localite, '') != '' THEN CONCAT(localite, ' ') END,
        CASE WHEN COALESCE(cedex, '') != '' THEN CONCAT('CEDEX ', cedex) END,
        CASE WHEN COALESCE(pays, '') != '' AND LOWER(TRIM(pays)) != 'france' THEN CONCAT(separateur, pays) END
    ))
$$ LANGUAGE SQL;

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'dossier.terrain_adresse_cedex::text,', E'\\1dossier.terrain_adresse_cedex::text, ''''::text,')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('dossier.terrain_adresse_cedex::text, ''''::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_principal.cedex::text\)', E'\\1petitionnaire_principal.cedex::text, petitionnaire_principal.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_principal.cedex::text, petitionnaire_principal.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_principal.cedex::text, '' ''::text', E'\\1petitionnaire_principal.cedex::text, petitionnaire_principal.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_principal.cedex::text, petitionnaire_principal.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_principal_initial.cedex::text\)', E'\\1petitionnaire_principal_initial.cedex::text, petitionnaire_principal_initial.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_principal_initial.cedex::text, petitionnaire_principal_initial.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_principal_initial.cedex::text, '' ''::text', E'\\1petitionnaire_principal_initial.cedex::text, petitionnaire_principal_initial.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_principal_initial.cedex::text, petitionnaire_principal_initial.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_1.cedex::text\)', E'\\1petitionnaire_1.cedex::text, petitionnaire_1.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_1.cedex::text, petitionnaire_1.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_1.cedex::text, '' ''::text', E'\\1petitionnaire_1.cedex::text, petitionnaire_1.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_1.cedex::text, petitionnaire_1.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_2.cedex::text\)', E'\\1petitionnaire_2.cedex::text, petitionnaire_2.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_2.cedex::text, petitionnaire_2.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_2.cedex::text, '' ''::text', E'\\1petitionnaire_2.cedex::text, petitionnaire_2.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_2.cedex::text, petitionnaire_2.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_3.cedex::text\)', E'\\1petitionnaire_3.cedex::text, petitionnaire_3.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_3.cedex::text, petitionnaire_3.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_3.cedex::text, '' ''::text', E'\\1petitionnaire_3.cedex::text, petitionnaire_3.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_3.cedex::text, petitionnaire_3.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_4.cedex::text\)', E'\\1petitionnaire_4.cedex::text, petitionnaire_4.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_4.cedex::text, petitionnaire_4.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_4.cedex::text, '' ''::text', E'\\1petitionnaire_4.cedex::text, petitionnaire_4.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_4.cedex::text, petitionnaire_4.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_5.cedex::text\)', E'\\1petitionnaire_5.cedex::text, petitionnaire_5.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_5.cedex::text, petitionnaire_5.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_5.cedex::text, '' ''::text', E'\\1petitionnaire_5.cedex::text, petitionnaire_5.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('petitionnaire_5.cedex::text, petitionnaire_5.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_principal.cedex::text\)', E'\\1contrevenant_principal.cedex::text, contrevenant_principal.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_principal.cedex::text, contrevenant_principal.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_principal.cedex::text, '' ''::text', E'\\1contrevenant_principal.cedex::text, contrevenant_principal.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_principal.cedex::text, contrevenant_principal.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_1.cedex::text\)', E'\\1contrevenant_1.cedex::text, contrevenant_1.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_1.cedex::text, contrevenant_1.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_1.cedex::text, '' ''::text', E'\\1contrevenant_1.cedex::text, contrevenant_1.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_1.cedex::text, contrevenant_1.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_2.cedex::text\)', E'\\1contrevenant_2.cedex::text, contrevenant_2.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_2.cedex::text, contrevenant_2.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_2.cedex::text, '' ''::text', E'\\1contrevenant_2.cedex::text, contrevenant_2.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_2.cedex::text, contrevenant_2.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_3.cedex::text\)', E'\\1contrevenant_3.cedex::text, contrevenant_3.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_3.cedex::text, contrevenant_3.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_3.cedex::text, '' ''::text', E'\\1contrevenant_3.cedex::text, contrevenant_3.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_3.cedex::text, contrevenant_3.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_4.cedex::text\)', E'\\1contrevenant_4.cedex::text, contrevenant_4.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_4.cedex::text, contrevenant_4.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_4.cedex::text, '' ''::text', E'\\1contrevenant_4.cedex::text, contrevenant_4.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_4.cedex::text, contrevenant_4.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_5.cedex::text\)', E'\\1contrevenant_5.cedex::text, contrevenant_5.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_5.cedex::text, contrevenant_5.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_5.cedex::text, '' ''::text', E'\\1contrevenant_5.cedex::text, contrevenant_5.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('contrevenant_5.cedex::text, contrevenant_5.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_principal.cedex::text\)', E'\\1requerant_principal.cedex::text, requerant_principal.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_principal.cedex::text, requerant_principal.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_principal.cedex::text, '' ''::text', E'\\1requerant_principal.cedex::text, requerant_principal.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_principal.cedex::text, requerant_principal.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_1.cedex::text\)', E'\\1requerant_1.cedex::text, requerant_1.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_1.cedex::text, requerant_1.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_1.cedex::text, '' ''::text', E'\\1requerant_1.cedex::text, requerant_1.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_1.cedex::text, requerant_1.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_2.cedex::text\)', E'\\1requerant_2.cedex::text, requerant_2.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_2.cedex::text, requerant_2.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_2.cedex::text, '' ''::text', E'\\1requerant_2.cedex::text, requerant_2.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_2.cedex::text, requerant_2.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_3.cedex::text\)', E'\\1requerant_3.cedex::text, requerant_3.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_3.cedex::text, requerant_3.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_3.cedex::text, '' ''::text', E'\\1requerant_3.cedex::text, requerant_3.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_3.cedex::text, requerant_3.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_4.cedex::text\)', E'\\1requerant_4.cedex::text, requerant_4.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_4.cedex::text, requerant_4.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_4.cedex::text, '' ''::text', E'\\1requerant_4.cedex::text, requerant_4.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_4.cedex::text, requerant_4.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_5.cedex::text\)', E'\\1requerant_5.cedex::text, requerant_5.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_5.cedex::text, requerant_5.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_5.cedex::text, '' ''::text', E'\\1requerant_5.cedex::text, requerant_5.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('requerant_5.cedex::text, requerant_5.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_principal.cedex::text\)', E'\\1avocat_principal.cedex::text, avocat_principal.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_principal.cedex::text, avocat_principal.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_principal.cedex::text, '' ''::text', E'\\1avocat_principal.cedex::text, avocat_principal.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_principal.cedex::text, avocat_principal.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_1.cedex::text\)', E'\\1avocat_1.cedex::text, avocat_1.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_1.cedex::text, avocat_1.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_1.cedex::text, '' ''::text', E'\\1avocat_1.cedex::text, avocat_1.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_1.cedex::text, avocat_1.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_2.cedex::text\)', E'\\1avocat_2.cedex::text, avocat_2.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_2.cedex::text, avocat_2.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_2.cedex::text, '' ''::text', E'\\1avocat_2.cedex::text, avocat_2.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_2.cedex::text, avocat_2.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_3.cedex::text\)', E'\\1avocat_3.cedex::text, avocat_3.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_3.cedex::text, avocat_3.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_3.cedex::text, '' ''::text', E'\\1avocat_3.cedex::text, avocat_3.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_3.cedex::text, avocat_3.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_4.cedex::text\)', E'\\1avocat_4.cedex::text, avocat_4.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_4.cedex::text, avocat_4.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_4.cedex::text, '' ''::text', E'\\1avocat_4.cedex::text, avocat_4.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_4.cedex::text, avocat_4.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_5.cedex::text\)', E'\\1avocat_5.cedex::text, avocat_5.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_5.cedex::text, avocat_5.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_5.cedex::text, '' ''::text', E'\\1avocat_5.cedex::text, avocat_5.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('avocat_5.cedex::text, avocat_5.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_principal.cedex::text\)', E'\\1plaignant_principal.cedex::text, plaignant_principal.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_principal.cedex::text, plaignant_principal.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_principal.cedex::text, '' ''::text', E'\\1plaignant_principal.cedex::text, plaignant_principal.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_principal.cedex::text, plaignant_principal.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_1.cedex::text\)', E'\\1plaignant_1.cedex::text, plaignant_1.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_1.cedex::text, plaignant_1.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_1.cedex::text, '' ''::text', E'\\1plaignant_1.cedex::text, plaignant_1.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_1.cedex::text, plaignant_1.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_2.cedex::text\)', E'\\1plaignant_2.cedex::text, plaignant_2.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_2.cedex::text, plaignant_2.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_2.cedex::text, '' ''::text', E'\\1plaignant_2.cedex::text, plaignant_2.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_2.cedex::text, plaignant_2.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_3.cedex::text\)', E'\\1plaignant_3.cedex::text, plaignant_3.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_3.cedex::text, plaignant_3.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_3.cedex::text, '' ''::text', E'\\1plaignant_3.cedex::text, plaignant_3.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_3.cedex::text, plaignant_3.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_4.cedex::text\)', E'\\1plaignant_4.cedex::text, plaignant_4.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_4.cedex::text, plaignant_4.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_4.cedex::text, '' ''::text', E'\\1plaignant_4.cedex::text, plaignant_4.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_4.cedex::text, plaignant_4.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_5.cedex::text\)', E'\\1plaignant_5.cedex::text, plaignant_5.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_5.cedex::text, plaignant_5.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_5.cedex::text, '' ''::text', E'\\1plaignant_5.cedex::text, plaignant_5.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('plaignant_5.cedex::text, plaignant_5.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'delegataire.cedex::text\)', E'\\1delegataire.cedex::text, delegataire.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('delegataire.cedex::text, delegataire.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'delegataire.cedex::text, '' ''::text', E'\\1delegataire.cedex::text, delegataire.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('delegataire.cedex::text, delegataire.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_principal.cedex::text\)', E'\\1bailleur_principal.cedex::text, bailleur_principal.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_principal.cedex::text, bailleur_principal.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_principal.cedex::text, '' ''::text', E'\\1bailleur_principal.cedex::text, bailleur_principal.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_principal.cedex::text, bailleur_principal.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_1.cedex::text\)', E'\\1bailleur_1.cedex::text, bailleur_1.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_1.cedex::text, bailleur_1.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_1.cedex::text, '' ''::text', E'\\1bailleur_1.cedex::text, bailleur_1.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_1.cedex::text, bailleur_1.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_2.cedex::text\)', E'\\1bailleur_2.cedex::text, bailleur_2.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_2.cedex::text, bailleur_2.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_2.cedex::text, '' ''::text', E'\\1bailleur_2.cedex::text, bailleur_2.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_2.cedex::text, bailleur_2.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_3.cedex::text\)', E'\\1bailleur_3.cedex::text, bailleur_3.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_3.cedex::text, bailleur_3.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_3.cedex::text, '' ''::text', E'\\1bailleur_3.cedex::text, bailleur_3.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_3.cedex::text, bailleur_3.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_4.cedex::text\)', E'\\1bailleur_4.cedex::text, bailleur_4.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_4.cedex::text, bailleur_4.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_4.cedex::text, '' ''::text', E'\\1bailleur_4.cedex::text, bailleur_4.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_4.cedex::text, bailleur_4.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_5.cedex::text\)', E'\\1bailleur_5.cedex::text, bailleur_5.pays::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_5.cedex::text, bailleur_5.pays::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_5.cedex::text, '' ''::text', E'\\1bailleur_5.cedex::text, bailleur_5.pays::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('bailleur_5.cedex::text, bailleur_5.pays::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text\)', E'\\1CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.pays ELSE delegataire.pays END::text\)')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.pays ELSE delegataire.pays END::text)' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');
--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text, '' ''::text', E'\\1CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.pays ELSE delegataire.pays END::text, '' ''::text')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.pays ELSE delegataire.pays END::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'donnees_techniques.dia_acquereur_adr_localite::text,
        ''''::text,', E'\\1donnees_techniques.dia_acquereur_adr_localite::text,
        ''''::text,
        ''''::text,')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE POSITION('donnees_techniques.dia_acquereur_adr_localite::text,
        ''''::text,
        ''''::text,' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction', 'commission');

--
UPDATE om_sousetat AS omr SET om_sql = (
   SELECT regexp_replace(r.om_sql, 'dossier.terrain_adresse_cedex::text,', E'\\1dossier.terrain_adresse_cedex::text, ''''::text,', 'g')
   FROM om_sousetat AS r
   WHERE r.om_sousetat = omr.om_sousetat
)
WHERE POSITION('dossier.terrain_adresse_cedex::text, ''''::text,' IN omr.om_sql) = 0;

--
UPDATE om_sousetat AS omr SET om_sql = (
   SELECT regexp_replace(r.om_sql, 'demandeur.cedex::text,', E'\\1demandeur.cedex::text, demandeur.pays::text,', 'g')
   FROM om_sousetat AS r
   WHERE r.om_sousetat = omr.om_sousetat
)
WHERE POSITION('demandeur.cedex::text, demandeur.pays::text,' IN omr.om_sql) = 0;

--
UPDATE om_sousetat AS omr SET om_sql = (
   SELECT regexp_replace(r.om_sql, 'petitionnaire_principal.cedex::text,', E'\\1petitionnaire_principal.cedex::text, petitionnaire_principal.pays::text,', 'g')
   FROM om_sousetat AS r
   WHERE r.om_sousetat = omr.om_sousetat
)
WHERE POSITION('petitionnaire_principal.cedex::text, petitionnaire_principal.pays::text,' IN omr.om_sql) = 0;

--
-- END / [#10124] Amélioration de la fonction SQL pour l'affichage d'une adresse
--

--
-- BEGIN / [#10138] Lenteur lors de la suppression d'un dossier
--

-- dossier
CREATE INDEX IF NOT EXISTS blocnote_dossier ON blocnote (dossier);
CREATE INDEX IF NOT EXISTS consultation_dossier ON consultation (dossier);
CREATE INDEX IF NOT EXISTS document_numerise_dossier ON document_numerise (dossier);
CREATE INDEX IF NOT EXISTS dossier_commission_dossier ON dossier_commission (dossier);
CREATE INDEX IF NOT EXISTS dossier_contrainte_dossier ON dossier_contrainte (dossier);
CREATE INDEX IF NOT EXISTS dossier_geolocalisation_dossier ON dossier_geolocalisation (dossier);
CREATE INDEX IF NOT EXISTS dossier_message_dossier ON dossier_message (dossier);
CREATE INDEX IF NOT EXISTS lien_dossier_demandeur_dossier ON lien_dossier_demandeur (dossier);
CREATE INDEX IF NOT EXISTS lien_dossier_dossier_dossier_src ON lien_dossier_dossier (dossier_src);
CREATE INDEX IF NOT EXISTS lien_id_interne_uid_externe_dossier ON lien_id_interne_uid_externe (dossier);
CREATE INDEX IF NOT EXISTS lot_dossier ON lot (dossier);

-- dossier_autorisation
CREATE INDEX IF NOT EXISTS demande_dossier_autorisation ON demande (dossier_autorisation);
CREATE INDEX IF NOT EXISTS dossier_autorisation_parcelle_dossier_autorisation ON dossier_autorisation_parcelle (dossier_autorisation);
CREATE INDEX IF NOT EXISTS lot_dossier_autorisation ON lot (dossier_autorisation);

-- dossier_autorisation_type
CREATE INDEX IF NOT EXISTS dossier_autorisation_type_detaille_dossier_autorisation_type ON dossier_autorisation_type_detaille (dossier_autorisation_type);

-- dossier_autorisation_type_detaille
CREATE INDEX IF NOT EXISTS dossier_instruction_type_dossier_autorisation_type_detaille ON dossier_instruction_type (dossier_autorisation_type_detaille);

-- dossier_instruction
CREATE INDEX IF NOT EXISTS dossier_operateur_dossier_instruction ON dossier_operateur (dossier_instruction);
CREATE INDEX IF NOT EXISTS rapport_instruction_dossier_instruction ON rapport_instruction (dossier_instruction);

-- dossier_parent
CREATE INDEX IF NOT EXISTS dossier_dossier_parent ON dossier (dossier_parent);

-- dossier_platau
CREATE INDEX IF NOT EXISTS dossier_autorisation_type_detaille_dossier_platau ON dossier_autorisation_type_detaille (dossier_platau);

--
-- END / [#10138] Lenteur lors de la suppression d'un dossier
--

--
-- BEGIN / [#10160]-Ajouter permissions sur les profils contentieux 
--

-- Ajout permission dossier_contentieux_tous_recours_exporter
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_tous_recours_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);


-- Ajout permission dossier_contentieux_toutes_infractions_exporter
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
   SELECT nextval('om_droit_seq'), 'dossier_contentieux_toutes_infractions_exporter', (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_exporter'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

--
-- END / [#10160]-Ajouter permissions sur les profils contentieux 
--

--
-- BEGIN / [#10162] Lenteurs à l'affichage des dossiers d'instruction dématérialisés de consultation entrante
--

--
CREATE INDEX IF NOT EXISTS consultation_entrante_dossier ON consultation_entrante (dossier);
CREATE INDEX IF NOT EXISTS lien_id_interne_uid_externe_external_uid_object_object_id_category ON lien_id_interne_uid_externe (external_uid, object, object_id, category);
CREATE INDEX IF NOT EXISTS task_object_id ON task (object_id);

--
-- END / [#10162] Lenteurs à l'affichage des dossiers d'instruction dématérialisés de consultation entrante
--

--
-- BEGIN / [#10157] - Notification automatique des tiers - ajout automatique des acteurs à la création des dossiers
--


ALTER TABLE
   lien_dossier_instruction_type_categorie_tiers
ADD
   COLUMN IF NOT EXISTS ajout_automatique BOOLEAN DEFAULT FALSE;

COMMENT ON COLUMN lien_dossier_instruction_type_categorie_tiers.ajout_automatique IS
   'Indique si les tiers de cette catégorie doivent automatiquement être liés au dossier de ce type lors de sa création.';

-- Mise à jour du paramétrage existant. Tous les liens déjà paramétrés sont des liens d'ajout automatique.

UPDATE
   lien_dossier_instruction_type_categorie_tiers
SET
   ajout_automatique = TRUE;

-- Suppression de la contrainte d'unicité du couple categorie_tiers, dossier_instruction_type pour pouvoir avoir
-- des doublons si une catégorie est choisie à la fois en ajout manuel et en ajout auto
ALTER TABLE lien_dossier_instruction_type_categorie_tiers DROP CONSTRAINT IF EXISTS lien_dossier_instruction_type_catégorie_tiers_unique;

-- Index relatif aux traitements des acteurs
CREATE INDEX IF NOT EXISTS lien_DIT_categorie_tiers_ajout_auto ON lien_dossier_instruction_type_categorie_tiers (ajout_automatique)
   WHERE ajout_automatique IS TRUE;
CREATE INDEX IF NOT EXISTS habilitation_tiers_consulte_debut_validite ON habilitation_tiers_consulte (om_validite_debut);
CREATE INDEX IF NOT EXISTS habilitation_tiers_consulte_fin_validite ON habilitation_tiers_consulte (om_validite_fin);
CREATE INDEX IF NOT EXISTS lien_cat_tiers_collectivite_collectivite ON lien_categorie_tiers_consulte_om_collectivite (om_collectivite);
CREATE INDEX IF NOT EXISTS dossier_collectivite ON dossier (om_collectivite);
CREATE INDEX IF NOT EXISTS dossier_commune ON dossier (commune);
CREATE INDEX IF NOT EXISTS commune_dep ON commune (dep);
CREATE INDEX IF NOT EXISTS departement_dep ON departement (dep);
CREATE INDEX IF NOT EXISTS tiers_accepte_notification ON tiers_consulte (accepte_notification_email)
   WHERE accepte_notification_email IS TRUE;
CREATE INDEX IF NOT EXISTS tiers_uid_platau_acteur ON tiers_consulte (uid_platau_acteur);
CREATE INDEX IF NOT EXISTS consultation_entrante_service_consultant_id ON consultation_entrante (service_consultant_id);

-- Renommage de l'option *option_parametrage_notif_tiers* en *option_module_acteur*
UPDATE om_parametre SET
    libelle = 'option_module_acteur'
WHERE libelle = 'option_parametrage_notif_tiers';

--
-- END / [#10157] - Notification automatique des tiers - ajout automatique des acteurs à la création des dossiers
--
