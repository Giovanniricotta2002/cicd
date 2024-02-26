-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.9.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.9.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / Ajout d'une permission manquante
--

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

--
-- END / Ajout d'uen permission manquante
--

--
-- BEGIN / [#9800] Gestion des consultations pour l’archéologie & acteurs consultés (part 2) 
--

ALTER TABLE consultation
    ADD COLUMN categorie_tiers_consulte integer,
    ADD COLUMN tiers_consulte integer,
    ADD COLUMN motif_consultation integer,
    ADD COLUMN commentaire text;

-- Suppression de la contrainte not null sur le service puisque les consultations sont
-- maintenant possible sur les services ou sur les tiers
ALTER TABLE consultation ALTER COLUMN service DROP NOT NULL;

ALTER TABLE consultation
ADD CONSTRAINT consultation_categorie_tiers_consulte_fkey 
FOREIGN KEY (categorie_tiers_consulte)
REFERENCES categorie_tiers_consulte (categorie_tiers_consulte);

ALTER TABLE consultation
ADD CONSTRAINT consultation_tiers_consulte_fkey 
FOREIGN KEY (tiers_consulte)
REFERENCES tiers_consulte (tiers_consulte);

ALTER TABLE consultation
ADD CONSTRAINT consultation_motif_consultation_fkey 
FOREIGN KEY (motif_consultation)
REFERENCES motif_consultation (motif_consultation);

-- Modification du champ generer_edition de la table motif_consultation pour
-- lui donner le même nom que celui de la table service et simplifier les
-- traitement
ALTER TABLE motif_consultation
RENAME COLUMN generer_edition TO generate_edition;

-- Ajout des permissions pour l'ajout de consultation vers des tiers consultés pour les profils
-- administrateur, 
INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'consultation_ajouter_consultation_tiers', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_consultation_tiers' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'consultation_ajouter_consultation_tiers', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_consultation_tiers' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'consultation_ajouter_consultation_tiers', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_consultation_tiers' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'consultation_ajouter_consultation_tiers', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_consultation_tiers' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'consultation_ajouter_consultation_tiers', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_consultation_tiers' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'consultation_ajouter_consultation_tiers', (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_consultation_tiers' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'consultation_ajouter_consultation_tiers', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_consultation_tiers' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'consultation_ajouter_consultation_tiers', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_consultation_tiers' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
    );

--
-- END / [#9800] Gestion des consultations pour l’archéologie & acteurs consultés (part 2) 
--

--
-- BEGIN / [#9801] - Gestion des visas des signataires
--

--
-- Évolution de la requête permettant de récupérer les champs de fusion de l'instruction pour
-- ajouter plus de champ visa_signataire
--

ALTER TABLE signataire_arrete
    ADD COLUMN visa_2 TEXT,
    ADD COLUMN visa_3 TEXT,
    ADD COLUMN visa_4 TEXT;

COMMENT ON COLUMN signataire_arrete.visa IS 'Champs servant à saisir un visa.';
COMMENT ON COLUMN signataire_arrete.visa_2 IS 'Champs servant à saisir un deuxième visa (Compléments).';
COMMENT ON COLUMN signataire_arrete.visa_3 IS 'Champs servant à saisir un troisième visa (Compléments).';
COMMENT ON COLUMN signataire_arrete.visa_4 IS 'Champs servant à saisir un quatrième visa (Compléments).';


UPDATE om_requete AS omr SET
    requete = regexp_replace(
            omr.requete,
            '(signataire_arrete.visa AS visa_signataire,)',
            E'\\1\nsignataire_arrete.visa_2 AS visa_signataire_2,\nsignataire_arrete.visa_3 AS visa_signataire_3,\nsignataire_arrete.visa_4 AS visa_signataire_4,'
        ),
    merge_fields = regexp_replace(
        omr.merge_fields,
        '(\[visa_signataire\],)',
        E'\\1\n[visa_signataire_2]\n[visa_signataire_3]\n[visa_signataire_4]'
    )
WHERE
    omr.code = 'instruction';


--
-- END / [#9801] - Gestion des visas des signataires
--

--
-- BEGIN / [#9799] Ajout de la recherche avancée et de l'export csv sur la liste des habilitations des tiers consultés
--

ALTER TABLE habilitation_tiers_consulte
    ADD COLUMN tiers_consulte integer NOT NULL,
    ADD CONSTRAINT tiers_consulte_Fkey FOREIGN KEY (tiers_consulte) REFERENCES 
    tiers_consulte(tiers_consulte);

DROP TABLE lien_habilitation_tiers_consulte_tiers_consulte;

--
-- END / [#9799] Ajout de la recherche avancée et de l'export csv sur la liste des habilitations des tiers consultés
--

--
-- BEGIN / [#9838] Ajout d'une fonction SQL pour l'affichage d'une adresse
--

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
        CASE WHEN COALESCE(voie, '') != '' THEN CONCAT(voie, separateur) END,
        CASE WHEN COALESCE(complement, '') != '' THEN CONCAT(complement, separateur) END,
        CASE WHEN COALESCE(lieu_dit, '') != '' THEN CONCAT(lieu_dit, separateur) END, 
        CASE WHEN COALESCE(bp, '') != '' THEN CONCAT(bp, separateur) END, 
        CASE WHEN COALESCE(code_postal, '') != '' THEN CONCAT(code_postal, ' ') END,
        CASE WHEN COALESCE(localite, '') != '' THEN CONCAT(localite, ' ') END,
        CASE WHEN COALESCE(cedex, '') != '' THEN CONCAT(cedex, ' ') END
    )
$$ LANGUAGE SQL;

-- adresse du terrain sans saut de ligne
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'terrain_adresse_voie_numero as terrain_adresse_voie_numero_dossier,', E'\\1terrain_adresse_voie_numero as terrain_adresse_voie_numero_dossier,\r&DB_PREFIXEadresse(dossier.terrain_adresse_voie_numero::text, dossier.terrain_adresse_voie::text, ''''::text, dossier.terrain_adresse_lieu_dit::text, dossier.terrain_adresse_bp::text, dossier.terrain_adresse_code_postal::text, dossier.terrain_adresse_localite::text, dossier.terrain_adresse_cedex::text, '' ''::text) as adresse_terrain,')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_terrain' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
   SELECT regexp_replace(r.merge_fields, '\[terrain_adresse_voie_numero_dossier\]', E'\\1[terrain_adresse_voie_numero_dossier]\r[adresse_terrain]')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_terrain]' IN omr.merge_fields) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

-- adresse du terrain avec saut de ligne
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'terrain_adresse_voie_numero as terrain_adresse_voie_numero_dossier,', E'\\1terrain_adresse_voie_numero as terrain_adresse_voie_numero_dossier,\r&DB_PREFIXEadresse(dossier.terrain_adresse_voie_numero::text, dossier.terrain_adresse_voie::text, ''''::text, dossier.terrain_adresse_lieu_dit::text, dossier.terrain_adresse_bp::text, dossier.terrain_adresse_code_postal::text, dossier.terrain_adresse_localite::text, dossier.terrain_adresse_cedex::text) as adresse_terrain_sdl,')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_terrain_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
   SELECT regexp_replace(r.merge_fields, '\[terrain_adresse_voie_numero_dossier\]', E'\\1[terrain_adresse_voie_numero_dossier]\r[adresse_terrain_sdl]')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_terrain_sdl]' IN omr.merge_fields) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

-- adresse des demandeurs sans saut de ligne
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_principal.numero as numero_petitionnaire_principal,', E'\\1petitionnaire_principal.numero as numero_petitionnaire_principal,\r&DB_PREFIXEadresse(petitionnaire_principal.numero::text, petitionnaire_principal.voie::text, petitionnaire_principal.complement::text, petitionnaire_principal.lieu_dit::text, petitionnaire_principal.bp::text, petitionnaire_principal.code_postal::text, petitionnaire_principal.localite::text, petitionnaire_principal.cedex::text, '' ''::text) as adresse_petitionnaire_principal,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_principal' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_petitionnaire_principal\]', E'\\1[numero_petitionnaire_principal]\r[adresse_petitionnaire_principal]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_petitionnaire_principal]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_principal_initial.numero as numero_petitionnaire_principal_initial,', E'\\1petitionnaire_principal_initial.numero as numero_petitionnaire_principal_initial,\r&DB_PREFIXEadresse(petitionnaire_principal_initial.numero::text, petitionnaire_principal_initial.voie::text, petitionnaire_principal_initial.complement::text, petitionnaire_principal_initial.lieu_dit::text, petitionnaire_principal_initial.bp::text, petitionnaire_principal_initial.code_postal::text, petitionnaire_principal_initial.localite::text, petitionnaire_principal_initial.cedex::text, '' ''::text) as adresse_petitionnaire_principal_initial,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_principal_initial' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_petitionnaire_principal_initial\]', E'\\1[numero_petitionnaire_principal_initial]\r[adresse_petitionnaire_principal_initial]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_petitionnaire_principal_initial]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_1.numero as numero_petitionnaire_1,', E'\\1petitionnaire_1.numero as numero_petitionnaire_1,\r&DB_PREFIXEadresse(petitionnaire_1.numero::text, petitionnaire_1.voie::text, petitionnaire_1.complement::text, petitionnaire_1.lieu_dit::text, petitionnaire_1.bp::text, petitionnaire_1.code_postal::text, petitionnaire_1.localite::text, petitionnaire_1.cedex::text, '' ''::text) as adresse_petitionnaire_1,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_1' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_petitionnaire_1\]\(jusqu''à 5\)', E'\\1[numero_petitionnaire_1](jusqu''à 5)\r[adresse_petitionnaire_1](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_petitionnaire_1]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_2.numero as numero_petitionnaire_2,', E'\\1petitionnaire_2.numero as numero_petitionnaire_2,\r&DB_PREFIXEadresse(petitionnaire_2.numero::text, petitionnaire_2.voie::text, petitionnaire_2.complement::text, petitionnaire_2.lieu_dit::text, petitionnaire_2.bp::text, petitionnaire_2.code_postal::text, petitionnaire_2.localite::text, petitionnaire_2.cedex::text, '' ''::text) as adresse_petitionnaire_2,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_2' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_3.numero as numero_petitionnaire_3,', E'\\1petitionnaire_3.numero as numero_petitionnaire_3,\r&DB_PREFIXEadresse(petitionnaire_3.numero::text, petitionnaire_3.voie::text, petitionnaire_3.complement::text, petitionnaire_3.lieu_dit::text, petitionnaire_3.bp::text, petitionnaire_3.code_postal::text, petitionnaire_3.localite::text, petitionnaire_3.cedex::text, '' ''::text) as adresse_petitionnaire_3,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_3' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_4.numero as numero_petitionnaire_4,', E'\\1petitionnaire_4.numero as numero_petitionnaire_4,\r&DB_PREFIXEadresse(petitionnaire_4.numero::text, petitionnaire_4.voie::text, petitionnaire_4.complement::text, petitionnaire_4.lieu_dit::text, petitionnaire_4.bp::text, petitionnaire_4.code_postal::text, petitionnaire_4.localite::text, petitionnaire_4.cedex::text, '' ''::text) as adresse_petitionnaire_4,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_4' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_5.numero as numero_petitionnaire_5,', E'\\1petitionnaire_5.numero as numero_petitionnaire_5,\r&DB_PREFIXEadresse(petitionnaire_5.numero::text, petitionnaire_5.voie::text, petitionnaire_5.complement::text, petitionnaire_5.lieu_dit::text, petitionnaire_5.bp::text, petitionnaire_5.code_postal::text, petitionnaire_5.localite::text, petitionnaire_5.cedex::text, '' ''::text) as adresse_petitionnaire_5,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_5' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_principal.numero as numero_contrevenant_principal,', E'\\1contrevenant_principal.numero as numero_contrevenant_principal,\r&DB_PREFIXEadresse(contrevenant_principal.numero::text, contrevenant_principal.voie::text, contrevenant_principal.complement::text, contrevenant_principal.lieu_dit::text, contrevenant_principal.bp::text, contrevenant_principal.code_postal::text, contrevenant_principal.localite::text, contrevenant_principal.cedex::text, '' ''::text) as adresse_contrevenant_principal,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_principal' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_contrevenant_principal\]', E'\\1[numero_contrevenant_principal]\r[adresse_contrevenant_principal]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_contrevenant_principal]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_1.numero as numero_contrevenant_1,', E'\\1contrevenant_1.numero as numero_contrevenant_1,\r&DB_PREFIXEadresse(contrevenant_1.numero::text, contrevenant_1.voie::text, contrevenant_1.complement::text, contrevenant_1.lieu_dit::text, contrevenant_1.bp::text, contrevenant_1.code_postal::text, contrevenant_1.localite::text, contrevenant_1.cedex::text, '' ''::text) as adresse_contrevenant_1,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_1' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_contrevenant_1\]\(jusqu''à 5\)', E'\\1[numero_contrevenant_1](jusqu''à 5)\r[adresse_contrevenant_1](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_contrevenant_1]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_2.numero as numero_contrevenant_2,', E'\\1contrevenant_2.numero as numero_contrevenant_2,\r&DB_PREFIXEadresse(contrevenant_2.numero::text, contrevenant_2.voie::text, contrevenant_2.complement::text, contrevenant_2.lieu_dit::text, contrevenant_2.bp::text, contrevenant_2.code_postal::text, contrevenant_2.localite::text, contrevenant_2.cedex::text, '' ''::text) as adresse_contrevenant_2,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_2' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_3.numero as numero_contrevenant_3,', E'\\1contrevenant_3.numero as numero_contrevenant_3,\r&DB_PREFIXEadresse(contrevenant_3.numero::text, contrevenant_3.voie::text, contrevenant_3.complement::text, contrevenant_3.lieu_dit::text, contrevenant_3.bp::text, contrevenant_3.code_postal::text, contrevenant_3.localite::text, contrevenant_3.cedex::text, '' ''::text) as adresse_contrevenant_3,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_3' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_4.numero as numero_contrevenant_4,', E'\\1contrevenant_4.numero as numero_contrevenant_4,\r&DB_PREFIXEadresse(contrevenant_4.numero::text, contrevenant_4.voie::text, contrevenant_4.complement::text, contrevenant_4.lieu_dit::text, contrevenant_4.bp::text, contrevenant_4.code_postal::text, contrevenant_4.localite::text, contrevenant_4.cedex::text, '' ''::text) as adresse_contrevenant_4,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_4' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_5.numero as numero_contrevenant_5,', E'\\1contrevenant_5.numero as numero_contrevenant_5,\r&DB_PREFIXEadresse(contrevenant_5.numero::text, contrevenant_5.voie::text, contrevenant_5.complement::text, contrevenant_5.lieu_dit::text, contrevenant_5.bp::text, contrevenant_5.code_postal::text, contrevenant_5.localite::text, contrevenant_5.cedex::text, '' ''::text) as adresse_contrevenant_5,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_5' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_principal.numero as numero_requerant_principal,', E'\\1requerant_principal.numero as numero_requerant_principal,\r&DB_PREFIXEadresse(requerant_principal.numero::text, requerant_principal.voie::text, requerant_principal.complement::text, requerant_principal.lieu_dit::text, requerant_principal.bp::text, requerant_principal.code_postal::text, requerant_principal.localite::text, requerant_principal.cedex::text, '' ''::text) as adresse_requerant_principal,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_principal' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_requerant_principal\]', E'\\1[numero_requerant_principal]\r[adresse_requerant_principal]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_requerant_principal]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_1.numero as numero_requerant_1,', E'\\1requerant_1.numero as numero_requerant_1,\r&DB_PREFIXEadresse(requerant_1.numero::text, requerant_1.voie::text, requerant_1.complement::text, requerant_1.lieu_dit::text, requerant_1.bp::text, requerant_1.code_postal::text, requerant_1.localite::text, requerant_1.cedex::text, '' ''::text) as adresse_requerant_1,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_1' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_requerant_1\]\(jusqu''à 5\)', E'\\1[numero_requerant_1](jusqu''à 5)\r[adresse_requerant_1](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_requerant_1]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_2.numero as numero_requerant_2,', E'\\1requerant_2.numero as numero_requerant_2,\r&DB_PREFIXEadresse(requerant_2.numero::text, requerant_2.voie::text, requerant_2.complement::text, requerant_2.lieu_dit::text, requerant_2.bp::text, requerant_2.code_postal::text, requerant_2.localite::text, requerant_2.cedex::text, '' ''::text) as adresse_requerant_2,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_2' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_3.numero as numero_requerant_3,', E'\\1requerant_3.numero as numero_requerant_3,\r&DB_PREFIXEadresse(requerant_3.numero::text, requerant_3.voie::text, requerant_3.complement::text, requerant_3.lieu_dit::text, requerant_3.bp::text, requerant_3.code_postal::text, requerant_3.localite::text, requerant_3.cedex::text, '' ''::text) as adresse_requerant_3,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_3' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_4.numero as numero_requerant_4,', E'\\1requerant_4.numero as numero_requerant_4,\r&DB_PREFIXEadresse(requerant_4.numero::text, requerant_4.voie::text, requerant_4.complement::text, requerant_4.lieu_dit::text, requerant_4.bp::text, requerant_4.code_postal::text, requerant_4.localite::text, requerant_4.cedex::text, '' ''::text) as adresse_requerant_4,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_4' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_5.numero as numero_requerant_5,', E'\\1requerant_5.numero as numero_requerant_5,\r&DB_PREFIXEadresse(requerant_5.numero::text, requerant_5.voie::text, requerant_5.complement::text, requerant_5.lieu_dit::text, requerant_5.bp::text, requerant_5.code_postal::text, requerant_5.localite::text, requerant_5.cedex::text, '' ''::text) as adresse_requerant_5,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_5' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_principal.numero as numero_avocat_principal,', E'\\1avocat_principal.numero as numero_avocat_principal,\r&DB_PREFIXEadresse(avocat_principal.numero::text, avocat_principal.voie::text, avocat_principal.complement::text, avocat_principal.lieu_dit::text, avocat_principal.bp::text, avocat_principal.code_postal::text, avocat_principal.localite::text, avocat_principal.cedex::text, '' ''::text) as adresse_avocat_principal,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_principal' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_avocat_principal\]', E'\\1[numero_avocat_principal]\r[adresse_avocat_principal]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_avocat_principal]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_1.numero as numero_avocat_1,', E'\\1avocat_1.numero as numero_avocat_1,\r&DB_PREFIXEadresse(avocat_1.numero::text, avocat_1.voie::text, avocat_1.complement::text, avocat_1.lieu_dit::text, avocat_1.bp::text, avocat_1.code_postal::text, avocat_1.localite::text, avocat_1.cedex::text, '' ''::text) as adresse_avocat_1,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_1' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_avocat_1\]\(jusqu''à 5\)', E'\\1[numero_avocat_1](jusqu''à 5)\r[adresse_avocat_1](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_avocat_1]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_2.numero as numero_avocat_2,', E'\\1avocat_2.numero as numero_avocat_2,\r&DB_PREFIXEadresse(avocat_2.numero::text, avocat_2.voie::text, avocat_2.complement::text, avocat_2.lieu_dit::text, avocat_2.bp::text, avocat_2.code_postal::text, avocat_2.localite::text, avocat_2.cedex::text, '' ''::text) as adresse_avocat_2,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_2' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_3.numero as numero_avocat_3,', E'\\1avocat_3.numero as numero_avocat_3,\r&DB_PREFIXEadresse(avocat_3.numero::text, avocat_3.voie::text, avocat_3.complement::text, avocat_3.lieu_dit::text, avocat_3.bp::text, avocat_3.code_postal::text, avocat_3.localite::text, avocat_3.cedex::text, '' ''::text) as adresse_avocat_3,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_3' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_4.numero as numero_avocat_4,', E'\\1avocat_4.numero as numero_avocat_4,\r&DB_PREFIXEadresse(avocat_4.numero::text, avocat_4.voie::text, avocat_4.complement::text, avocat_4.lieu_dit::text, avocat_4.bp::text, avocat_4.code_postal::text, avocat_4.localite::text, avocat_4.cedex::text, '' ''::text) as adresse_avocat_4,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_4' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_5.numero as numero_avocat_5,', E'\\1avocat_5.numero as numero_avocat_5,\r&DB_PREFIXEadresse(avocat_5.numero::text, avocat_5.voie::text, avocat_5.complement::text, avocat_5.lieu_dit::text, avocat_5.bp::text, avocat_5.code_postal::text, avocat_5.localite::text, avocat_5.cedex::text, '' ''::text) as adresse_avocat_5,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_5' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_principal.numero as numero_plaignant_principal,', E'\\1plaignant_principal.numero as numero_plaignant_principal,\r&DB_PREFIXEadresse(plaignant_principal.numero::text, plaignant_principal.voie::text, plaignant_principal.complement::text, plaignant_principal.lieu_dit::text, plaignant_principal.bp::text, plaignant_principal.code_postal::text, plaignant_principal.localite::text, plaignant_principal.cedex::text, '' ''::text) as adresse_plaignant_principal,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_principal' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_plaignant_principal\]', E'\\1[numero_plaignant_principal]\r[adresse_plaignant_principal]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_plaignant_principal]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_1.numero as numero_plaignant_1,', E'\\1plaignant_1.numero as numero_plaignant_1,\r&DB_PREFIXEadresse(plaignant_1.numero::text, plaignant_1.voie::text, plaignant_1.complement::text, plaignant_1.lieu_dit::text, plaignant_1.bp::text, plaignant_1.code_postal::text, plaignant_1.localite::text, plaignant_1.cedex::text, '' ''::text) as adresse_plaignant_1,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_1' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_plaignant_1\]\(jusqu''à 5\)', E'\\1[numero_plaignant_1](jusqu''à 5)\r[adresse_plaignant_1](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_plaignant_1]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_2.numero as numero_plaignant_2,', E'\\1plaignant_2.numero as numero_plaignant_2,\r&DB_PREFIXEadresse(plaignant_2.numero::text, plaignant_2.voie::text, plaignant_2.complement::text, plaignant_2.lieu_dit::text, plaignant_2.bp::text, plaignant_2.code_postal::text, plaignant_2.localite::text, plaignant_2.cedex::text, '' ''::text) as adresse_plaignant_2,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_2' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_3.numero as numero_plaignant_3,', E'\\1plaignant_3.numero as numero_plaignant_3,\r&DB_PREFIXEadresse(plaignant_3.numero::text, plaignant_3.voie::text, plaignant_3.complement::text, plaignant_3.lieu_dit::text, plaignant_3.bp::text, plaignant_3.code_postal::text, plaignant_3.localite::text, plaignant_3.cedex::text, '' ''::text) as adresse_plaignant_3,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_3' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_4.numero as numero_plaignant_4,', E'\\1plaignant_4.numero as numero_plaignant_4,\r&DB_PREFIXEadresse(plaignant_4.numero::text, plaignant_4.voie::text, plaignant_4.complement::text, plaignant_4.lieu_dit::text, plaignant_4.bp::text, plaignant_4.code_postal::text, plaignant_4.localite::text, plaignant_4.cedex::text, '' ''::text) as adresse_plaignant_4,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_4' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_5.numero as numero_plaignant_5,', E'\\1plaignant_5.numero as numero_plaignant_5,\r&DB_PREFIXEadresse(plaignant_5.numero::text, plaignant_5.voie::text, plaignant_5.complement::text, plaignant_5.lieu_dit::text, plaignant_5.bp::text, plaignant_5.code_postal::text, plaignant_5.localite::text, plaignant_5.cedex::text, '' ''::text) as adresse_plaignant_5,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_5' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'delegataire.numero as numero_delegataire,', E'\\1delegataire.numero as numero_delegataire,\r&DB_PREFIXEadresse(delegataire.numero::text, delegataire.voie::text, delegataire.complement::text, delegataire.lieu_dit::text, delegataire.bp::text, delegataire.code_postal::text, delegataire.localite::text, delegataire.cedex::text, '' ''::text) as adresse_delegataire,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_delegataire' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_delegataire\]', E'\\1[numero_delegataire]\r[adresse_delegataire]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_delegataire]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_principal.numero as numero_bailleur_principal,', E'\\1bailleur_principal.numero as numero_bailleur_principal,\r&DB_PREFIXEadresse(bailleur_principal.numero::text, bailleur_principal.voie::text, bailleur_principal.complement::text, bailleur_principal.lieu_dit::text, bailleur_principal.bp::text, bailleur_principal.code_postal::text, bailleur_principal.localite::text, bailleur_principal.cedex::text, '' ''::text) as adresse_bailleur_principal,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_principal' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_bailleur_principal\]', E'\\1[numero_bailleur_principal]\r[adresse_bailleur_principal]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_bailleur_principal]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_1.numero as numero_bailleur_1,', E'\\1bailleur_1.numero as numero_bailleur_1,\r&DB_PREFIXEadresse(bailleur_1.numero::text, bailleur_1.voie::text, bailleur_1.complement::text, bailleur_1.lieu_dit::text, bailleur_1.bp::text, bailleur_1.code_postal::text, bailleur_1.localite::text, bailleur_1.cedex::text, '' ''::text) as adresse_bailleur_1,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_1' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_bailleur_1\]\(jusqu''à 5\)', E'\\1[numero_bailleur_1](jusqu''à 5)\r[adresse_bailleur_1](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_bailleur_1]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_2.numero as numero_bailleur_2,', E'\\1bailleur_2.numero as numero_bailleur_2,\r&DB_PREFIXEadresse(bailleur_2.numero::text, bailleur_2.voie::text, bailleur_2.complement::text, bailleur_2.lieu_dit::text, bailleur_2.bp::text, bailleur_2.code_postal::text, bailleur_2.localite::text, bailleur_2.cedex::text, '' ''::text) as adresse_bailleur_2,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_2' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_3.numero as numero_bailleur_3,', E'\\1bailleur_3.numero as numero_bailleur_3,\r&DB_PREFIXEadresse(bailleur_3.numero::text, bailleur_3.voie::text, bailleur_3.complement::text, bailleur_3.lieu_dit::text, bailleur_3.bp::text, bailleur_3.code_postal::text, bailleur_3.localite::text, bailleur_3.cedex::text, '' ''::text) as adresse_bailleur_3,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_3' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_4.numero as numero_bailleur_4,', E'\\1bailleur_4.numero as numero_bailleur_4,\r&DB_PREFIXEadresse(bailleur_4.numero::text, bailleur_4.voie::text, bailleur_4.complement::text, bailleur_4.lieu_dit::text, bailleur_4.bp::text, bailleur_4.code_postal::text, bailleur_4.localite::text, bailleur_4.cedex::text, '' ''::text) as adresse_bailleur_4,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_4' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_5.numero as numero_bailleur_5,', E'\\1bailleur_5.numero as numero_bailleur_5,\r&DB_PREFIXEadresse(bailleur_5.numero::text, bailleur_5.voie::text, bailleur_5.complement::text, bailleur_5.lieu_dit::text, bailleur_5.bp::text, bailleur_5.code_postal::text, bailleur_5.localite::text, bailleur_5.cedex::text, '' ''::text) as adresse_bailleur_5,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_5' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

-- adresse des demandeurs avec saut de ligne
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_principal.numero as numero_petitionnaire_principal,', E'\\1petitionnaire_principal.numero as numero_petitionnaire_principal,\r&DB_PREFIXEadresse(petitionnaire_principal.numero::text, petitionnaire_principal.voie::text, petitionnaire_principal.complement::text, petitionnaire_principal.lieu_dit::text, petitionnaire_principal.bp::text, petitionnaire_principal.code_postal::text, petitionnaire_principal.localite::text, petitionnaire_principal.cedex::text) as adresse_petitionnaire_principal_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_principal_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_petitionnaire_principal\]', E'\\1[numero_petitionnaire_principal]\r[adresse_petitionnaire_principal_sdl]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_petitionnaire_principal_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_principal_initial.numero as numero_petitionnaire_principal_initial,', E'\\1petitionnaire_principal_initial.numero as numero_petitionnaire_principal_initial,\r&DB_PREFIXEadresse(petitionnaire_principal_initial.numero::text, petitionnaire_principal_initial.voie::text, petitionnaire_principal_initial.complement::text, petitionnaire_principal_initial.lieu_dit::text, petitionnaire_principal_initial.bp::text, petitionnaire_principal_initial.code_postal::text, petitionnaire_principal_initial.localite::text, petitionnaire_principal_initial.cedex::text) as adresse_petitionnaire_principal_initial_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_principal_initial_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_petitionnaire_principal_initial\]', E'\\1[numero_petitionnaire_principal_initial]\r[adresse_petitionnaire_principal_initial_sdl]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_petitionnaire_principal_initial_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_1.numero as numero_petitionnaire_1,', E'\\1petitionnaire_1.numero as numero_petitionnaire_1,\r&DB_PREFIXEadresse(petitionnaire_1.numero::text, petitionnaire_1.voie::text, petitionnaire_1.complement::text, petitionnaire_1.lieu_dit::text, petitionnaire_1.bp::text, petitionnaire_1.code_postal::text, petitionnaire_1.localite::text, petitionnaire_1.cedex::text) as adresse_petitionnaire_1_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_1_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_petitionnaire_1\]\(jusqu''à 5\)', E'\\1[numero_petitionnaire_1](jusqu''à 5)\r[adresse_petitionnaire_1_sdl](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_petitionnaire_1_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_2.numero as numero_petitionnaire_2,', E'\\1petitionnaire_2.numero as numero_petitionnaire_2,\r&DB_PREFIXEadresse(petitionnaire_2.numero::text, petitionnaire_2.voie::text, petitionnaire_2.complement::text, petitionnaire_2.lieu_dit::text, petitionnaire_2.bp::text, petitionnaire_2.code_postal::text, petitionnaire_2.localite::text, petitionnaire_2.cedex::text) as adresse_petitionnaire_2_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_2_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_3.numero as numero_petitionnaire_3,', E'\\1petitionnaire_3.numero as numero_petitionnaire_3,\r&DB_PREFIXEadresse(petitionnaire_3.numero::text, petitionnaire_3.voie::text, petitionnaire_3.complement::text, petitionnaire_3.lieu_dit::text, petitionnaire_3.bp::text, petitionnaire_3.code_postal::text, petitionnaire_3.localite::text, petitionnaire_3.cedex::text) as adresse_petitionnaire_3_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_3_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_4.numero as numero_petitionnaire_4,', E'\\1petitionnaire_4.numero as numero_petitionnaire_4,\r&DB_PREFIXEadresse(petitionnaire_4.numero::text, petitionnaire_4.voie::text, petitionnaire_4.complement::text, petitionnaire_4.lieu_dit::text, petitionnaire_4.bp::text, petitionnaire_4.code_postal::text, petitionnaire_4.localite::text, petitionnaire_4.cedex::text) as adresse_petitionnaire_4_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_4_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'petitionnaire_5.numero as numero_petitionnaire_5,', E'\\1petitionnaire_5.numero as numero_petitionnaire_5,\r&DB_PREFIXEadresse(petitionnaire_5.numero::text, petitionnaire_5.voie::text, petitionnaire_5.complement::text, petitionnaire_5.lieu_dit::text, petitionnaire_5.bp::text, petitionnaire_5.code_postal::text, petitionnaire_5.localite::text, petitionnaire_5.cedex::text) as adresse_petitionnaire_5_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_petitionnaire_5_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_principal.numero as numero_contrevenant_principal,', E'\\1contrevenant_principal.numero as numero_contrevenant_principal,\r&DB_PREFIXEadresse(contrevenant_principal.numero::text, contrevenant_principal.voie::text, contrevenant_principal.complement::text, contrevenant_principal.lieu_dit::text, contrevenant_principal.bp::text, contrevenant_principal.code_postal::text, contrevenant_principal.localite::text, contrevenant_principal.cedex::text) as adresse_contrevenant_principal_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_principal_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_contrevenant_principal\]', E'\\1[numero_contrevenant_principal]\r[adresse_contrevenant_principal_sdl]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_contrevenant_principal_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_1.numero as numero_contrevenant_1,', E'\\1contrevenant_1.numero as numero_contrevenant_1,\r&DB_PREFIXEadresse(contrevenant_1.numero::text, contrevenant_1.voie::text, contrevenant_1.complement::text, contrevenant_1.lieu_dit::text, contrevenant_1.bp::text, contrevenant_1.code_postal::text, contrevenant_1.localite::text, contrevenant_1.cedex::text) as adresse_contrevenant_1_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_1_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_contrevenant_1\]\(jusqu''à 5\)', E'\\1[numero_contrevenant_1](jusqu''à 5)\r[adresse_contrevenant_1_sdl](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_contrevenant_1_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_2.numero as numero_contrevenant_2,', E'\\1contrevenant_2.numero as numero_contrevenant_2,\r&DB_PREFIXEadresse(contrevenant_2.numero::text, contrevenant_2.voie::text, contrevenant_2.complement::text, contrevenant_2.lieu_dit::text, contrevenant_2.bp::text, contrevenant_2.code_postal::text, contrevenant_2.localite::text, contrevenant_2.cedex::text) as adresse_contrevenant_2_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_2_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_3.numero as numero_contrevenant_3,', E'\\1contrevenant_3.numero as numero_contrevenant_3,\r&DB_PREFIXEadresse(contrevenant_3.numero::text, contrevenant_3.voie::text, contrevenant_3.complement::text, contrevenant_3.lieu_dit::text, contrevenant_3.bp::text, contrevenant_3.code_postal::text, contrevenant_3.localite::text, contrevenant_3.cedex::text) as adresse_contrevenant_3_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_3_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_4.numero as numero_contrevenant_4,', E'\\1contrevenant_4.numero as numero_contrevenant_4,\r&DB_PREFIXEadresse(contrevenant_4.numero::text, contrevenant_4.voie::text, contrevenant_4.complement::text, contrevenant_4.lieu_dit::text, contrevenant_4.bp::text, contrevenant_4.code_postal::text, contrevenant_4.localite::text, contrevenant_4.cedex::text) as adresse_contrevenant_4_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_4_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'contrevenant_5.numero as numero_contrevenant_5,', E'\\1contrevenant_5.numero as numero_contrevenant_5,\r&DB_PREFIXEadresse(contrevenant_5.numero::text, contrevenant_5.voie::text, contrevenant_5.complement::text, contrevenant_5.lieu_dit::text, contrevenant_5.bp::text, contrevenant_5.code_postal::text, contrevenant_5.localite::text, contrevenant_5.cedex::text) as adresse_contrevenant_5_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_contrevenant_5_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_principal.numero as numero_requerant_principal,', E'\\1requerant_principal.numero as numero_requerant_principal,\r&DB_PREFIXEadresse(requerant_principal.numero::text, requerant_principal.voie::text, requerant_principal.complement::text, requerant_principal.lieu_dit::text, requerant_principal.bp::text, requerant_principal.code_postal::text, requerant_principal.localite::text, requerant_principal.cedex::text) as adresse_requerant_principal_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_principal_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_requerant_principal\]', E'\\1[numero_requerant_principal]\r[adresse_requerant_principal_sdl]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_requerant_principal_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_1.numero as numero_requerant_1,', E'\\1requerant_1.numero as numero_requerant_1,\r&DB_PREFIXEadresse(requerant_1.numero::text, requerant_1.voie::text, requerant_1.complement::text, requerant_1.lieu_dit::text, requerant_1.bp::text, requerant_1.code_postal::text, requerant_1.localite::text, requerant_1.cedex::text) as adresse_requerant_1_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_1_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_requerant_1\]\(jusqu''à 5\)', E'\\1[numero_requerant_1](jusqu''à 5)\r[adresse_requerant_1_sdl](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_requerant_1_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_2.numero as numero_requerant_2,', E'\\1requerant_2.numero as numero_requerant_2,\r&DB_PREFIXEadresse(requerant_2.numero::text, requerant_2.voie::text, requerant_2.complement::text, requerant_2.lieu_dit::text, requerant_2.bp::text, requerant_2.code_postal::text, requerant_2.localite::text, requerant_2.cedex::text) as adresse_requerant_2_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_2_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_3.numero as numero_requerant_3,', E'\\1requerant_3.numero as numero_requerant_3,\r&DB_PREFIXEadresse(requerant_3.numero::text, requerant_3.voie::text, requerant_3.complement::text, requerant_3.lieu_dit::text, requerant_3.bp::text, requerant_3.code_postal::text, requerant_3.localite::text, requerant_3.cedex::text) as adresse_requerant_3_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_3_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_4.numero as numero_requerant_4,', E'\\1requerant_4.numero as numero_requerant_4,\r&DB_PREFIXEadresse(requerant_4.numero::text, requerant_4.voie::text, requerant_4.complement::text, requerant_4.lieu_dit::text, requerant_4.bp::text, requerant_4.code_postal::text, requerant_4.localite::text, requerant_4.cedex::text) as adresse_requerant_4_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_4_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'requerant_5.numero as numero_requerant_5,', E'\\1requerant_5.numero as numero_requerant_5,\r&DB_PREFIXEadresse(requerant_5.numero::text, requerant_5.voie::text, requerant_5.complement::text, requerant_5.lieu_dit::text, requerant_5.bp::text, requerant_5.code_postal::text, requerant_5.localite::text, requerant_5.cedex::text) as adresse_requerant_5_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_requerant_5_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_principal.numero as numero_avocat_principal,', E'\\1avocat_principal.numero as numero_avocat_principal,\r&DB_PREFIXEadresse(avocat_principal.numero::text, avocat_principal.voie::text, avocat_principal.complement::text, avocat_principal.lieu_dit::text, avocat_principal.bp::text, avocat_principal.code_postal::text, avocat_principal.localite::text, avocat_principal.cedex::text) as adresse_avocat_principal_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_principal_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_avocat_principal\]', E'\\1[numero_avocat_principal]\r[adresse_avocat_principal_sdl]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_avocat_principal_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_1.numero as numero_avocat_1,', E'\\1avocat_1.numero as numero_avocat_1,\r&DB_PREFIXEadresse(avocat_1.numero::text, avocat_1.voie::text, avocat_1.complement::text, avocat_1.lieu_dit::text, avocat_1.bp::text, avocat_1.code_postal::text, avocat_1.localite::text, avocat_1.cedex::text) as adresse_avocat_1_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_1_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_avocat_1\]\(jusqu''à 5\)', E'\\1[numero_avocat_1](jusqu''à 5)\r[adresse_avocat_1_sdl](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_avocat_1_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_2.numero as numero_avocat_2,', E'\\1avocat_2.numero as numero_avocat_2,\r&DB_PREFIXEadresse(avocat_2.numero::text, avocat_2.voie::text, avocat_2.complement::text, avocat_2.lieu_dit::text, avocat_2.bp::text, avocat_2.code_postal::text, avocat_2.localite::text, avocat_2.cedex::text) as adresse_avocat_2_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_2_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_3.numero as numero_avocat_3,', E'\\1avocat_3.numero as numero_avocat_3,\r&DB_PREFIXEadresse(avocat_3.numero::text, avocat_3.voie::text, avocat_3.complement::text, avocat_3.lieu_dit::text, avocat_3.bp::text, avocat_3.code_postal::text, avocat_3.localite::text, avocat_3.cedex::text) as adresse_avocat_3_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_3_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_4.numero as numero_avocat_4,', E'\\1avocat_4.numero as numero_avocat_4,\r&DB_PREFIXEadresse(avocat_4.numero::text, avocat_4.voie::text, avocat_4.complement::text, avocat_4.lieu_dit::text, avocat_4.bp::text, avocat_4.code_postal::text, avocat_4.localite::text, avocat_4.cedex::text) as adresse_avocat_4_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_4_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'avocat_5.numero as numero_avocat_5,', E'\\1avocat_5.numero as numero_avocat_5,\r&DB_PREFIXEadresse(avocat_5.numero::text, avocat_5.voie::text, avocat_5.complement::text, avocat_5.lieu_dit::text, avocat_5.bp::text, avocat_5.code_postal::text, avocat_5.localite::text, avocat_5.cedex::text) as adresse_avocat_5_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_avocat_5_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_principal.numero as numero_plaignant_principal,', E'\\1plaignant_principal.numero as numero_plaignant_principal,\r&DB_PREFIXEadresse(plaignant_principal.numero::text, plaignant_principal.voie::text, plaignant_principal.complement::text, plaignant_principal.lieu_dit::text, plaignant_principal.bp::text, plaignant_principal.code_postal::text, plaignant_principal.localite::text, plaignant_principal.cedex::text) as adresse_plaignant_principal_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_principal_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_plaignant_principal\]', E'\\1[numero_plaignant_principal]\r[adresse_plaignant_principal_sdl]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_plaignant_principal_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_1.numero as numero_plaignant_1,', E'\\1plaignant_1.numero as numero_plaignant_1,\r&DB_PREFIXEadresse(plaignant_1.numero::text, plaignant_1.voie::text, plaignant_1.complement::text, plaignant_1.lieu_dit::text, plaignant_1.bp::text, plaignant_1.code_postal::text, plaignant_1.localite::text, plaignant_1.cedex::text) as adresse_plaignant_1_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_1_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_plaignant_1\]\(jusqu''à 5\)', E'\\1[numero_plaignant_1](jusqu''à 5)\r[adresse_plaignant_1_sdl](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_plaignant_1_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_2.numero as numero_plaignant_2,', E'\\1plaignant_2.numero as numero_plaignant_2,\r&DB_PREFIXEadresse(plaignant_2.numero::text, plaignant_2.voie::text, plaignant_2.complement::text, plaignant_2.lieu_dit::text, plaignant_2.bp::text, plaignant_2.code_postal::text, plaignant_2.localite::text, plaignant_2.cedex::text) as adresse_plaignant_2_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_2_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_3.numero as numero_plaignant_3,', E'\\1plaignant_3.numero as numero_plaignant_3,\r&DB_PREFIXEadresse(plaignant_3.numero::text, plaignant_3.voie::text, plaignant_3.complement::text, plaignant_3.lieu_dit::text, plaignant_3.bp::text, plaignant_3.code_postal::text, plaignant_3.localite::text, plaignant_3.cedex::text) as adresse_plaignant_3_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_3_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_4.numero as numero_plaignant_4,', E'\\1plaignant_4.numero as numero_plaignant_4,\r&DB_PREFIXEadresse(plaignant_4.numero::text, plaignant_4.voie::text, plaignant_4.complement::text, plaignant_4.lieu_dit::text, plaignant_4.bp::text, plaignant_4.code_postal::text, plaignant_4.localite::text, plaignant_4.cedex::text) as adresse_plaignant_4_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_4_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'plaignant_5.numero as numero_plaignant_5,', E'\\1plaignant_5.numero as numero_plaignant_5,\r&DB_PREFIXEadresse(plaignant_5.numero::text, plaignant_5.voie::text, plaignant_5.complement::text, plaignant_5.lieu_dit::text, plaignant_5.bp::text, plaignant_5.code_postal::text, plaignant_5.localite::text, plaignant_5.cedex::text) as adresse_plaignant_5_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_plaignant_5_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'delegataire.numero as numero_delegataire,', E'\\1delegataire.numero as numero_delegataire,\r&DB_PREFIXEadresse(delegataire.numero::text, delegataire.voie::text, delegataire.complement::text, delegataire.lieu_dit::text, delegataire.bp::text, delegataire.code_postal::text, delegataire.localite::text, delegataire.cedex::text) as adresse_delegataire_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_delegataire_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_delegataire\]', E'\\1[numero_delegataire]\r[adresse_delegataire_sdl]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_delegataire_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_principal.numero as numero_bailleur_principal,', E'\\1bailleur_principal.numero as numero_bailleur_principal,\r&DB_PREFIXEadresse(bailleur_principal.numero::text, bailleur_principal.voie::text, bailleur_principal.complement::text, bailleur_principal.lieu_dit::text, bailleur_principal.bp::text, bailleur_principal.code_postal::text, bailleur_principal.localite::text, bailleur_principal.cedex::text) as adresse_bailleur_principal_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_principal_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_bailleur_principal\]', E'\\1[numero_bailleur_principal]\r[adresse_bailleur_principal_sdl]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_bailleur_principal_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_1.numero as numero_bailleur_1,', E'\\1bailleur_1.numero as numero_bailleur_1,\r&DB_PREFIXEadresse(bailleur_1.numero::text, bailleur_1.voie::text, bailleur_1.complement::text, bailleur_1.lieu_dit::text, bailleur_1.bp::text, bailleur_1.code_postal::text, bailleur_1.localite::text, bailleur_1.cedex::text) as adresse_bailleur_1_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_1_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_bailleur_1\]\(jusqu''à 5\)', E'\\1[numero_bailleur_1](jusqu''à 5)\r[adresse_bailleur_1_sdl](jusqu''à 5)')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_bailleur_1_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_2.numero as numero_bailleur_2,', E'\\1bailleur_2.numero as numero_bailleur_2,\r&DB_PREFIXEadresse(bailleur_2.numero::text, bailleur_2.voie::text, bailleur_2.complement::text, bailleur_2.lieu_dit::text, bailleur_2.bp::text, bailleur_2.code_postal::text, bailleur_2.localite::text, bailleur_2.cedex::text) as adresse_bailleur_2_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_2_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_3.numero as numero_bailleur_3,', E'\\1bailleur_3.numero as numero_bailleur_3,\r&DB_PREFIXEadresse(bailleur_3.numero::text, bailleur_3.voie::text, bailleur_3.complement::text, bailleur_3.lieu_dit::text, bailleur_3.bp::text, bailleur_3.code_postal::text, bailleur_3.localite::text, bailleur_3.cedex::text) as adresse_bailleur_3_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_3_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_4.numero as numero_bailleur_4,', E'\\1bailleur_4.numero as numero_bailleur_4,\r&DB_PREFIXEadresse(bailleur_4.numero::text, bailleur_4.voie::text, bailleur_4.complement::text, bailleur_4.lieu_dit::text, bailleur_4.bp::text, bailleur_4.code_postal::text, bailleur_4.localite::text, bailleur_4.cedex::text) as adresse_bailleur_4_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_4_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'bailleur_5.numero as numero_bailleur_5,', E'\\1bailleur_5.numero as numero_bailleur_5,\r&DB_PREFIXEadresse(bailleur_5.numero::text, bailleur_5.voie::text, bailleur_5.complement::text, bailleur_5.lieu_dit::text, bailleur_5.bp::text, bailleur_5.code_postal::text, bailleur_5.localite::text, bailleur_5.cedex::text) as adresse_bailleur_5_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_bailleur_5_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

-- adresse du correspondant sans saut de ligne
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'END as numero_correspondant,', E'\\1END as numero_correspondant,\r&DB_PREFIXEadresse(CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.numero ELSE delegataire.numero END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.voie ELSE delegataire.voie END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.complement ELSE delegataire.complement END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.lieu_dit ELSE delegataire.lieu_dit END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.bp ELSE delegataire.bp END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.code_postal ELSE delegataire.code_postal END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.localite ELSE delegataire.localite END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text, '' ''::text) as adresse_correspondant,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_correspondant' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_correspondant\]', E'\\1[numero_correspondant]\r[adresse_correspondant]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_correspondant]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

-- adresse du correspondant avec saut de ligne
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, 'END as numero_correspondant,', E'\\1END as numero_correspondant,\r&DB_PREFIXEadresse(CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.numero ELSE delegataire.numero END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.voie ELSE delegataire.voie END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.complement ELSE delegataire.complement END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.lieu_dit ELSE delegataire.lieu_dit END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.bp ELSE delegataire.bp END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.code_postal ELSE delegataire.code_postal END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.localite ELSE delegataire.localite END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text) as adresse_correspondant_sdl,')
   FROM om_requete as r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('as adresse_correspondant_sdl' IN omr.requete) = 0
  AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');
UPDATE om_requete AS omr SET merge_fields = (
    SELECT regexp_replace(r.merge_fields, '\[numero_correspondant\]', E'\\1[numero_correspondant]\r[adresse_correspondant_sdl]')
    FROM om_requete AS r
    WHERE r.om_requete = omr.om_requete
)
WHERE position('[adresse_correspondant_sdl]' IN omr.merge_fields) = 0
    AND omr.code IN ('instruction', 'dossier', 'accuse_reception_consultation', 'consultation', 'rapport_instruction');

-- Mise à jour des requêtes SQL des sous-états
UPDATE om_sousetat SET om_sql = REPLACE(om_sql, 'demandeur.numero, '' '', demandeur.voie, '' '', demandeur.complement, '' '', demandeur.lieu_dit, '' '', demandeur.localite, '' '', demandeur.code_postal, '' '', demandeur.cedex, '' '', demandeur.bp', '&DB_PREFIXEadresse(demandeur.numero::text, demandeur.voie::text, demandeur.complement::text, demandeur.lieu_dit::text, demandeur.bp::text, demandeur.code_postal::text, demandeur.localite::text, demandeur.cedex::text, ''
'')')
WHERE id IN ('bordereau_courriers_signature_maire', 'bordereau_avis_maire_prefet', 'bordereau_controle_legalite', 'bordereau_decisions');
--
UPDATE om_sousetat SET om_sql = REPLACE(om_sql, 'demandeur.numero, '' '', demandeur.voie, '' '', demandeur.complement, '' '', demandeur.lieu_dit, '' '', demandeur.code_postal, '' '', demandeur.localite, '' '', demandeur.cedex, '' '', demandeur.bp', '&DB_PREFIXEadresse(demandeur.numero::text, demandeur.voie::text, demandeur.complement::text, demandeur.lieu_dit::text, demandeur.bp::text, demandeur.code_postal::text, demandeur.localite::text, demandeur.cedex::text, ''
'')')
WHERE id IN ('bordereau_courriers_signature_maire', 'bordereau_avis_maire_prefet', 'bordereau_controle_legalite', 'bordereau_decisions');
--
UPDATE om_sousetat SET om_sql = REPLACE(om_sql, 'CONCAT ( dossier.terrain_adresse_voie_numero, '' '', dossier.terrain_adresse_voie, '' '', dossier.terrain_adresse_lieu_dit, '' '', dossier.terrain_adresse_code_postal, '' '', dossier.terrain_adresse_localite, '' '', dossier.terrain_adresse_cedex, '' '', dossier.terrain_adresse_bp)', '&DB_PREFIXEadresse(dossier.terrain_adresse_voie_numero::text, dossier.terrain_adresse_voie::text, ''''::text, dossier.terrain_adresse_lieu_dit::text, dossier.terrain_adresse_bp::text, dossier.terrain_adresse_code_postal::text, dossier.terrain_adresse_localite::text, dossier.terrain_adresse_cedex::text, ''
'')')
WHERE id IN ('bordereau_courriers_signature_maire', 'bordereau_avis_maire_prefet', 'bordereau_controle_legalite', 'bordereau_decisions');
--
UPDATE om_sousetat SET om_sql = REPLACE(om_sql, 'CONCAT(demandeur.numero, '' '', demandeur.voie, '' '', demandeur.complement, '' '', demandeur.lieu_dit, '' '', demandeur.code_postal, '' '', demandeur.localite)', '&DB_PREFIXEadresse(demandeur.numero::text, demandeur.voie::text, demandeur.complement::text, demandeur.lieu_dit::text, demandeur.bp::text, demandeur.code_postal::text, demandeur.localite::text, demandeur.cedex::text, ''
'')')
WHERE id IN ('commission_compte_rendu', 'commission_ordre_jour');
--
UPDATE om_sousetat SET om_sql = REPLACE(om_sql, 'TRIM(CONCAT(dossier.terrain_adresse_voie_numero,'' '',dossier.terrain_adresse_voie,'' '', dossier.terrain_adresse_lieu_dit,'' '', dossier.terrain_adresse_code_postal))', '&DB_PREFIXEadresse(dossier.terrain_adresse_voie_numero::text, dossier.terrain_adresse_voie::text, ''''::text, dossier.terrain_adresse_lieu_dit::text, dossier.terrain_adresse_bp::text, dossier.terrain_adresse_code_postal::text, dossier.terrain_adresse_localite::text, dossier.terrain_adresse_cedex::text, ''
'')')
WHERE id IN ('commission_compte_rendu', 'commission_ordre_jour');
--
UPDATE om_sousetat SET om_sql = 
'SELECT

    CONCAT(dossier_autorisation_type_detaille.libelle, '' ('',dossier_instruction_type.libelle, '')
     
'', dossier.dossier_libelle) as dossier,

    CONCAT(''Déposé le '', to_char(dossier.date_depot,''DD/MM/YYYY''), 
    CASE WHEN dossier.date_depot <> COALESCE(dossier.date_complet, dossier.date_depot) THEN CONCAT(''
Complété le '', to_char(dossier.date_complet, ''DD/MM/YYYY'')) ELSE '''' END 
    ) as dates,

    CASE
        WHEN petitionnaire_principal.qualite=''particulier''
            THEN CONCAT(
                CASE WHEN COALESCE(civilite.code,'''') != '''' THEN CONCAT(civilite.code, '' '') END,
                CASE WHEN COALESCE(petitionnaire_principal.particulier_nom, '''') != '''' THEN CONCAT(petitionnaire_principal.particulier_nom, '' '') END,
                CASE WHEN COALESCE(petitionnaire_principal.particulier_prenom, '''') != '''' THEN CONCAT(petitionnaire_principal.particulier_prenom, ''
'') END, 
                &DB_PREFIXEadresse(petitionnaire_principal.numero::text, petitionnaire_principal.voie::text, petitionnaire_principal.complement::text, petitionnaire_principal.lieu_dit::text, petitionnaire_principal.bp::text, petitionnaire_principal.code_postal::text, petitionnaire_principal.localite::text, petitionnaire_principal.cedex::text, ''
'')
                        )
            ELSE CONCAT(
                CASE WHEN COALESCE(petitionnaire_principal.personne_morale_raison_sociale,'''') != '''' THEN CONCAT(petitionnaire_principal.personne_morale_raison_sociale, ''
'') END, 
                CASE WHEN COALESCE(petitionnaire_principal.personne_morale_denomination,'''') != '''' THEN CONCAT(petitionnaire_principal.personne_morale_denomination, '' 
'') END, 
                &DB_PREFIXEadresse(petitionnaire_principal.numero::text, petitionnaire_principal.voie::text, petitionnaire_principal.complement::text, petitionnaire_principal.lieu_dit::text, petitionnaire_principal.bp::text, petitionnaire_principal.code_postal::text, petitionnaire_principal.localite::text, petitionnaire_principal.cedex::text, ''
'')
                )
            END
            as demandeur,

        CONCAT(
            &DB_PREFIXEadresse(dossier.terrain_adresse_voie_numero::text, dossier.terrain_adresse_voie::text, ''''::text, dossier.terrain_adresse_lieu_dit::text, dossier.terrain_adresse_bp::text, dossier.terrain_adresse_code_postal::text, dossier.terrain_adresse_localite::text, dossier.terrain_adresse_cedex::text, ''
''),
            CASE WHEN arrondissement.libelle != '''' THEN CONCAT(''
Arrondissement : '', arrondissement.libelle) END
        ) as Terrain,


    CONCAT(
        CASE WHEN COALESCE(dossier.terrain_superficie::text,'''') != '''' THEN CONCAT(''superficie : '', dossier.terrain_superficie::text,'' m²
'') END,
        CASE WHEN COALESCE(donnees_techniques.co_tot_log_nb::text, '''') != '''' THEN CONCAT(''nombre de logements : '', donnees_techniques.co_tot_log_nb::text) END
        ) as Informations,

    CONCAT(''Délai '', delai, '' mois
Date limite le '', COALESCE((CASE WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE 
        THEN to_char(dossier.date_limite_incompletude ,''DD/MM/YYYY'') 
        ELSE to_char(dossier.date_limite ,''DD/MM/YYYY'')
    END), ''inconu'')) as limite

FROM
    &DB_PREFIXEdossier
    LEFT JOIN &DB_PREFIXEdossier_autorisation
        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
    LEFT JOIN &DB_PREFIXEdossier_autorisation_type_detaille
        ON dossier_autorisation.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
    LEFT JOIN &DB_PREFIXEdossier_autorisation_type
        ON dossier_autorisation_type_detaille.dossier_autorisation_type=dossier_autorisation_type.dossier_autorisation_type
    LEFT JOIN &DB_PREFIXElien_dossier_demandeur
        ON dossier.dossier = lien_dossier_demandeur.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
    LEFT JOIN &DB_PREFIXEdemandeur as petitionnaire_principal
        ON lien_dossier_demandeur.demandeur = petitionnaire_principal.demandeur
    LEFT JOIN &DB_PREFIXEcivilite
    ON
        civilite.civilite = petitionnaire_principal.particulier_civilite
    LEFT JOIN &DB_PREFIXEavis_decision
        ON dossier.avis_decision=avis_decision.avis_decision
    LEFT JOIN &DB_PREFIXEarrondissement
        ON dossier.terrain_adresse_code_postal = arrondissement.code_postal
    LEFT JOIN &DB_PREFIXEdonnees_techniques
        ON donnees_techniques.dossier_instruction=dossier.dossier
    LEFT JOIN &DB_PREFIXEgroupe
        ON dossier_autorisation_type.groupe = groupe.groupe
    LEFT JOIN &DB_PREFIXEdossier_instruction_type
        ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type


WHERE
    (select e.statut from &DB_PREFIXEetat e where e.etat = dossier.etat ) = ''encours''
    AND LOWER(dossier_autorisation_type.code) IN (''pc'',''pa'',''pd'',''dp'')
    AND LOWER(dossier_instruction_type.code) IN (''t'',''m'',''p'')
    AND dossier.om_collectivite = &collectivite
ORDER BY
    dossier.terrain_adresse_code_postal, dossier_autorisation_type.libelle'
WHERE id = 'registre_dossiers_affichage_reglementaire' AND om_sousetat = 19;
--
UPDATE om_sousetat SET om_sql =
'SELECT

    CONCAT(dossier_autorisation_type_detaille.libelle, '' ('',dossier_instruction_type.libelle, '')
     
'', dossier.dossier_libelle) as dossier,

    CONCAT(''Déposé le '', to_char(dossier.date_depot,''DD/MM/YYYY''), 
    CASE WHEN dossier.date_depot <> COALESCE(dossier.date_complet, dossier.date_depot) THEN CONCAT(''
Complété le '', to_char(dossier.date_complet, ''DD/MM/YYYY'')) ELSE '''' END 
    ) as dates,

    CASE
        WHEN petitionnaire_principal.qualite=''particulier''
            THEN CONCAT(
                CASE WHEN COALESCE(civilite.code,'''') != '''' THEN CONCAT(civilite.code, '' '') END,
                CASE WHEN COALESCE(petitionnaire_principal.particulier_nom, '''') != '''' THEN CONCAT(petitionnaire_principal.particulier_nom, '' '') END,
                CASE WHEN COALESCE(petitionnaire_principal.particulier_prenom, '''') != '''' THEN CONCAT(petitionnaire_principal.particulier_prenom, ''
'') END, 
                &DB_PREFIXEadresse(petitionnaire_principal.numero::text, petitionnaire_principal.voie::text, petitionnaire_principal.complement::text, petitionnaire_principal.lieu_dit::text, petitionnaire_principal.bp::text, petitionnaire_principal.code_postal::text, petitionnaire_principal.localite::text, petitionnaire_principal.cedex::text, ''
'')
                        )
            ELSE CONCAT(
                CASE WHEN COALESCE(petitionnaire_principal.personne_morale_raison_sociale,'''') != '''' THEN CONCAT(petitionnaire_principal.personne_morale_raison_sociale, ''
'') END, 
                CASE WHEN COALESCE(petitionnaire_principal.personne_morale_denomination,'''') != '''' THEN CONCAT(petitionnaire_principal.personne_morale_denomination, '' 
'') END, 
                &DB_PREFIXEadresse(petitionnaire_principal.numero::text, petitionnaire_principal.voie::text, petitionnaire_principal.complement::text, petitionnaire_principal.lieu_dit::text, petitionnaire_principal.bp::text, petitionnaire_principal.code_postal::text, petitionnaire_principal.localite::text, petitionnaire_principal.cedex::text, ''
'')
                )
            END
            as demandeur,

        CONCAT(
            &DB_PREFIXEadresse(dossier.terrain_adresse_voie_numero::text, dossier.terrain_adresse_voie::text, ''''::text, dossier.terrain_adresse_lieu_dit::text, dossier.terrain_adresse_bp::text, dossier.terrain_adresse_code_postal::text, dossier.terrain_adresse_localite::text, dossier.terrain_adresse_cedex::text, ''
''),
            CASE WHEN arrondissement.libelle != '''' THEN CONCAT(''
Arrondissement : '', arrondissement.libelle) END
        ) as Terrain,


    CONCAT(
        CASE WHEN COALESCE(dossier.terrain_superficie::text,'''') != '''' THEN CONCAT(''superficie : '', dossier.terrain_superficie::text,'' m²
'') END,
        CASE WHEN COALESCE(donnees_techniques.co_tot_log_nb::text, '''') != '''' THEN CONCAT(''nombre de logements : '', donnees_techniques.co_tot_log_nb::text) END
        ) as Informations,

    CONCAT(avis_decision.libelle, '' le '' , to_char(dossier.date_decision,''DD/MM/YYYY'')) as Décision

FROM
    &DB_PREFIXEdossier
    LEFT JOIN &DB_PREFIXEdossier_autorisation
        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
    LEFT JOIN &DB_PREFIXEdossier_autorisation_type_detaille
        ON dossier_autorisation.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
    LEFT JOIN &DB_PREFIXEdossier_autorisation_type
        ON dossier_autorisation_type_detaille.dossier_autorisation_type=dossier_autorisation_type.dossier_autorisation_type
    LEFT JOIN &DB_PREFIXElien_dossier_demandeur
        ON dossier.dossier = lien_dossier_demandeur.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
    LEFT JOIN &DB_PREFIXEdemandeur as petitionnaire_principal
        ON lien_dossier_demandeur.demandeur = petitionnaire_principal.demandeur
    LEFT JOIN &DB_PREFIXEcivilite
    ON
        civilite.civilite = petitionnaire_principal.particulier_civilite
    LEFT JOIN &DB_PREFIXEavis_decision
        ON dossier.avis_decision=avis_decision.avis_decision
    LEFT JOIN &DB_PREFIXEarrondissement
        ON dossier.terrain_adresse_code_postal = arrondissement.code_postal
    LEFT JOIN &DB_PREFIXEdonnees_techniques
        ON donnees_techniques.dossier_instruction=dossier.dossier
    LEFT JOIN &DB_PREFIXEgroupe
        ON dossier_autorisation_type.groupe = groupe.groupe
    LEFT JOIN &DB_PREFIXEdossier_instruction_type
        ON dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type


WHERE
    (select e.statut from &DB_PREFIXEetat e where e.etat = dossier.etat ) = ''cloture''
    AND current_date <= dossier.date_decision + interval ''2 month''
    AND LOWER(dossier_instruction_type.code) IN (''t'',''m'',''p'')
    AND LOWER(dossier_autorisation_type.code) IN (''pc'',''pa'',''pd'',''dp'')
    AND dossier.om_collectivite = &collectivite
ORDER BY
    dossier.terrain_adresse_code_postal, dossier_autorisation_type.libelle'
WHERE id = 'registre_dossiers_affichage_decisions' AND om_sousetat = 24;

--
-- END / [#9838] Ajout d'une fonction SQL pour l'affichage d'une adresse
--

--
-- BEGIN / [#9819] Limiter le rajout des documents des instructeurs à l'onglet "documents" seulement
--


INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'document_numerise_ajouter_document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_ajouter_document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'document_numerise_ajouter_document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_ajouter_document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'document_numerise_ajouter_document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_ajouter_document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'document_numerise_ajouter_document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_ajouter_document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'document_numerise_ajouter_document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_ajouter_document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'document_numerise_ajouter_document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_ajouter_document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'document_numerise_ajouter_document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_ajouter_document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'document_numerise_ajouter_document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_ajouter_document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

-- Suppression du droit d'ajout de document numérisé pour les instructeur seulement
DELETE FROM om_droit WHERE libelle = 'document_numerise_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR');

   
--
-- END / [#9819] Limiter le rajout des documents des instructeurs à l'onglet "documents" seulement

