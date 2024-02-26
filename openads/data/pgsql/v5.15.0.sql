-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.15.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.15.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9991] Amélioration de la fonction SQL pour l'affichage d'une adresse
--

CREATE OR REPLACE FUNCTION adresse(
    numero text,
    voie text,
    complement text,
    lieu_dit text,
    bp text,
    code_postal text,
    localite text,
    cedex text,
    separateur text DEFAULT '<br>') RETURNS text AS $$

    SELECT CONCAT(
        CASE WHEN COALESCE(numero, '') != '' THEN CONCAT(numero, ' ') END,
        CASE WHEN COALESCE(voie, '') != '' THEN CONCAT(voie, ' ') END,
        CASE WHEN COALESCE(complement, '') != '' THEN CONCAT(complement, separateur) END,
        CASE WHEN COALESCE(lieu_dit, '') != '' THEN CONCAT(lieu_dit, ' ') END, 
        CASE WHEN COALESCE(bp, '') != '' THEN CONCAT('BP ', bp, separateur) END, 
        CASE WHEN COALESCE(code_postal, '') != '' THEN CONCAT(code_postal, ' ') END,
        CASE WHEN COALESCE(localite, '') != '' THEN CONCAT(localite, ' ') END,
        CASE WHEN COALESCE(cedex, '') != '' THEN CONCAT('CEDEX ', cedex, ' ') END
    )
$$ LANGUAGE SQL;

--
-- END / [#9991] Amélioration de la fonction SQL pour l'affichage d'une adresse
--

--
-- BEGIN / Mise à jour de la requête 'instruction'
--

\i v5.15.0-om_requete.sql

--
-- END / Mise à jour de la requête 'instruction'
--

--
-- BEGIN / [#10024] Table et fonction qui permettent de compter des éléments
--

CREATE TABLE IF NOT EXISTS compteur (
compteur integer NOT NULL,
code varchar(150) NOT NULL,
description varchar(300) NOT NULL,
unite varchar(10) NULL,
quantite double precision NOT NULL,
quota double precision NOT NULL,
alerte double precision NULL,
om_collectivite integer NOT NULL,
date_modification timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
om_validite_debut date NOT NULL,
om_validite_fin date
);

CREATE SEQUENCE IF NOT EXISTS compteur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE compteur DROP CONSTRAINT IF EXISTS compteur_compteur;
ALTER TABLE compteur ADD CONSTRAINT compteur_compteur PRIMARY KEY (compteur);
ALTER TABLE compteur DROP CONSTRAINT IF EXISTS compteur_code_om_collectivite_om_validite_debut_om_validite_fin;
ALTER TABLE compteur
ADD CONSTRAINT compteur_code_om_collectivite_om_validite_debut_om_validite_fin UNIQUE (code, om_collectivite, om_validite_debut, om_validite_fin);
CREATE INDEX IF NOT EXISTS compteur_code ON compteur (code);
CREATE INDEX IF NOT EXISTS compteur_om_collectivite ON compteur (om_collectivite);
CREATE INDEX IF NOT EXISTS compteur_om_validite_debut ON compteur (om_validite_debut);
CREATE INDEX IF NOT EXISTS compteur_om_validite_fin ON compteur (om_validite_fin);

ALTER TABLE compteur DROP CONSTRAINT IF EXISTS compteur_om_collectivite_fkey;
ALTER TABLE compteur
ADD CONSTRAINT compteur_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite (om_collectivite);

-- Permissions
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'compteur', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'compteur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#10024] Table et fonction qui permettent de compter des éléments
--

--
-- BEGIN / [#10002] - Passage en tacite de consultations à l'état clôturé 
--
-- Création d'un index pour accélérer la récupération des dossiers sur lesquels
-- appliquer un tacite
CREATE INDEX IF NOT EXISTS avis_decision_null_dli_in_idx ON dossier(
    (avis_decision IS NULL),
    date_limite,
    incomplet_notifie
)
WHERE
    (avis_decision IS NULL)
    AND (date_limite IS NOT NULL);

-- Création d'un index pour accélérer la récupération des dossiers sur lesquels
-- appliquer un tacite d'incompletude
CREATE INDEX IF NOT EXISTS avis_decision_null_dliin_in_idx ON dossier(
    (avis_decision IS NULL),
    date_limite_incompletude,
    incomplet_notifie
)
WHERE
    (avis_decision IS NULL)
    AND (date_limite_incompletude IS NOT NULL);

--
-- END / [#10002] - Passage en tacite de consultations à l'état clôturé 
--

--
-- BEGIN / [#10008] - Mise à jour du numéro d’archive
--

DELETE FROM om_droit WHERE libelle = 'gestion_numero_versement_archive';

--
-- END / [#10008] - Mise à jour du numéro d’archive
--

--
-- BEGIN / [#10036] Évolutions du connecteur SIG - phase 3 - récupération d’attributs lors du calcul de centroïde
--

ALTER TABLE dossier
    ADD COLUMN IF NOT EXISTS terrain_superficie_calculee double precision NULL;
COMMENT ON COLUMN dossier.terrain_superficie_calculee IS 'Superficie calculée du terrain concerné par le dossier d''instruction';

--
-- END / [#10036] Évolutions du connecteur SIG - phase 3 - récupération d’attributs lors du calcul de centroïde
--
