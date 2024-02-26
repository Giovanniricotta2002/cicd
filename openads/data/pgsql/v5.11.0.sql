-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.11.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.11.0') WHERE exists(SELECT 1 FROM om_version) = false;


--
-- BEGIN / [#9833] Ajout d'un champ commentaire dans la table task
--

ALTER TABLE ONLY task ADD COLUMN comment TEXT;

--
-- END / [#9833] Ajout d'un champ commentaire dans la table task
--

--
-- BEGIN / [#9893] Ajout d'une fonction SQL pour rechercher les tâches par identifiant externe
--

--
CREATE OR REPLACE FUNCTION task_by_external_uid(external_uid text, external_uid_type text)
    RETURNS TABLE(
        task integer,
        type text,
        timestamp_log text,
        state text,
        object_id text,
        dossier text,
        json_payload text,
        stream text,
        category text,
        external_uid text) AS $$
    SELECT task, type, timestamp_log, state, object_id, dossier, json_payload, stream, category, external_uid as external_uid
    FROM task
    WHERE json_payload::json->'external_uids'->>external_uid_type = external_uid
$$ LANGUAGE SQL;

--
-- END / [#9893] Ajout d'une fonction SQL pour rechercher les tâches par identifiant externe
--

--
-- BEGIN / #1414 — [#9890] [MC0039961] Gestion des opérateurs
--

CREATE TABLE IF NOT EXISTS dossier_operateur (
    dossier_operateur INTEGER NOT NULL,
    operateur_designation_initialisee BOOLEAN DEFAULT false NOT NULL,
    operateur_detecte_inrap INTEGER NULL,
    operateur_detecte_collterr TEXT DEFAULT '[]',
    operateur_collterr_type_agrement CHARACTER VARYING(30) NULL,
    operateur_amenagement_pers_publique CHARACTER VARYING(1) DEFAULT NULL,
    operateur_pers_publique_amenageur CHARACTER VARYING(1) DEFAULT NULL,
    operateur_collterr_kpark_avis CHARACTER VARYING(30) NULL,
    operateur_collterr_selectionne INTEGER NULL,
    operateur_personne_publique INTEGER NULL,
    operateur_personne_publique_avis CHARACTER VARYING(30) NULL,
    operateur_kpark_libelle CHARACTER VARYING(50) DEFAULT '',
    operateur_kpark_type_operateur CHARACTER VARYING(50) DEFAULT '',
    operateur_kpark_evenement CHARACTER VARYING(50) DEFAULT '',
    operateur_designe INTEGER NULL,
    operateur_valide BOOLEAN DEFAULT false NOT NULL,
    operateur_designe_historique TEXT DEFAULT '[]',
    dossier_instruction CHARACTER VARYING(255) NOT NULL,
    CONSTRAINT dossier_operateur_pkey PRIMARY KEY (dossier_operateur)
);

ALTER TABLE ONLY dossier_operateur
    DROP CONSTRAINT IF EXISTS ope_det_inrap_tiers_consulte_fkey,
    DROP CONSTRAINT IF EXISTS ope_collterr_select_tiers_consulte_fkey,
    DROP CONSTRAINT IF EXISTS ope_pers_pub_tiers_consulte_fkey,
    DROP CONSTRAINT IF EXISTS ope_designe_tiers_consulte_fkey,
    DROP CONSTRAINT IF EXISTS doss_ope_dossier_instruction_dossier_dossier_fkey;
ALTER TABLE ONLY dossier_operateur
    ADD CONSTRAINT ope_det_inrap_tiers_consulte_fkey FOREIGN KEY (operateur_detecte_inrap) REFERENCES tiers_consulte(tiers_consulte),
    ADD CONSTRAINT ope_collterr_select_tiers_consulte_fkey FOREIGN KEY (operateur_collterr_selectionne) REFERENCES tiers_consulte(tiers_consulte),
    ADD CONSTRAINT ope_pers_pub_tiers_consulte_fkey FOREIGN KEY (operateur_personne_publique) REFERENCES tiers_consulte(tiers_consulte),
    ADD CONSTRAINT ope_designe_tiers_consulte_fkey FOREIGN KEY (operateur_designe) REFERENCES tiers_consulte(tiers_consulte),
    ADD CONSTRAINT doss_ope_dossier_instruction_dossier_dossier_fkey FOREIGN KEY (dossier_instruction) REFERENCES dossier(dossier);

CREATE SEQUENCE IF NOT EXISTS dossier_operateur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN dossier_operateur.dossier_operateur IS 'Identifiant';
COMMENT ON COLUMN dossier_operateur.operateur_designation_initialisee IS 'Permet d''identifier si une recherche d''opérateur a été déclenchée';
COMMENT ON COLUMN dossier_operateur.operateur_detecte_inrap IS 'Identifiant du tiers consulté INRAP détecté par la recherche';
COMMENT ON COLUMN dossier_operateur.operateur_detecte_collterr IS 'Liste des tiers consultés Collectivités Territoriales';
COMMENT ON COLUMN dossier_operateur.operateur_collterr_type_agrement IS 'Peut contenir les valeurs "tout_diag" ou "kpark", permet d''identifier si au moins un opérateur détecté à l''habilitation "kpark" sinon qu''il n''y a que des opérateurs avec l''habilitation "tout_diag" [P3]';
COMMENT ON COLUMN dossier_operateur.operateur_amenagement_pers_publique IS 'L''aménagement est-il réalisé par ou pour une personne publique (R523-28) ? (Non par défaut) [P4] {Prend comme valeur NULL, t ou f}';
COMMENT ON COLUMN dossier_operateur.operateur_pers_publique_amenageur IS 'La personne publique "article R523-28" est-elle l''aménageur du projet ?  (Oui par défaut) [P5] {Prend comme valeur NULL, t ou f}';
COMMENT ON COLUMN dossier_operateur.operateur_collterr_kpark_avis IS 'Avis rendu par le tiers consulté Collectivité Territoriale avec l''habilitation au cas par cas ("Favorable", "Défavorable" ou "Tacite") [P6]';
COMMENT ON COLUMN dossier_operateur.operateur_collterr_selectionne IS 'Identifiant du tiers consulté Collectivités Territoriales sélectionné';
COMMENT ON COLUMN dossier_operateur.operateur_personne_publique IS 'Identifiant du tiers consulté Personne Publique sélectionné';
COMMENT ON COLUMN dossier_operateur.operateur_personne_publique_avis IS 'Avis rendu par le tiers consulté Personne Publique ("Favorable", "Défavorable" ou "Tacite") [P7]';
COMMENT ON COLUMN dossier_operateur.operateur_kpark_libelle IS 'Nom du cas détecté si un cas est applicable';
COMMENT ON COLUMN dossier_operateur.operateur_kpark_type_operateur IS 'Paramètre du choix issu du paramètre de cas "collterr" ou "inrap"';
COMMENT ON COLUMN dossier_operateur.operateur_kpark_evenement IS 'Identifiant de l''événement à ajouter comme instruction lors de la validation de l''opérateur';
COMMENT ON COLUMN dossier_operateur.operateur_designe IS 'Identifiant du tiers consulté désigné pour le dossier';
COMMENT ON COLUMN dossier_operateur.operateur_valide IS 'Permet d''identifier que l''opérateur désigné est bien validé';
COMMENT ON COLUMN dossier_operateur.operateur_designe_historique IS 'JSON contenant l''historique des opérateurs désigné sur le dossier';
COMMENT ON COLUMN dossier_operateur.dossier_instruction IS 'Dossier d''instruction sur lequel l''opérateur est désigné';

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'dossier_operateur', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_operateur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'dossier_operateur', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_operateur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'dossier_instruction_dossier_operateur', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_dossier_operateur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'dossier_instruction_dossier_operateur', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_dossier_operateur' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

--
-- Name: lien_habilitation_tiers_consulte_commune; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE IF NOT EXISTS lien_habilitation_tiers_consulte_commune (
    lien_habilitation_tiers_consulte_commune integer NOT NULL,
    habilitation_tiers_consulte integer NOT NULL,
    commune integer NOT NULL,
    CONSTRAINT lien_habilitation_tiers_consulte_commune_pkey PRIMARY KEY (lien_habilitation_tiers_consulte_commune)
);

--
-- Name: COLUMN lien_habilitation_tiers_consulte_commune.lien_habilitation_tiers_consulte_commune; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_commune.lien_habilitation_tiers_consulte_commune IS 'Identifiant unique';

--
-- Name: COLUMN lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte IS 'Identifiant de l''habilitation du tiers consulté';

--
-- Name: COLUMN lien_habilitation_tiers_consulte_commune.commune; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_commune.commune IS 'Identifiant de la commune';

--
-- Name: lien_habilitation_tiers_consulte_commune_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE IF NOT EXISTS lien_habilitation_tiers_consulte_commune_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--
-- Name: lien_habilitation_tiers_consulte_commune lien_habilitation_tiers_consulte_commune_htc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_commune
    DROP CONSTRAINT IF EXISTS lien_habilitation_tiers_consulte_commune_htc_fkey;
ALTER TABLE ONLY lien_habilitation_tiers_consulte_commune
    ADD CONSTRAINT lien_habilitation_tiers_consulte_commune_htc_fkey FOREIGN KEY (habilitation_tiers_consulte) REFERENCES habilitation_tiers_consulte(habilitation_tiers_consulte);

--
-- Name: lien_habilitation_tiers_consulte_commune lien_habilitation_tiers_consulte_commune_com_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_commune
    DROP CONSTRAINT IF EXISTS lien_habilitation_tiers_consulte_commune_com_fkey;
ALTER TABLE ONLY lien_habilitation_tiers_consulte_commune
    ADD CONSTRAINT lien_habilitation_tiers_consulte_commune_com_fkey FOREIGN KEY (commune) REFERENCES commune(commune);


--
-- Name: lien_habilitation_tiers_consulte_departement; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE IF NOT EXISTS lien_habilitation_tiers_consulte_departement (
    lien_habilitation_tiers_consulte_departement integer NOT NULL,
    habilitation_tiers_consulte integer NOT NULL,
    departement integer NOT NULL,
    CONSTRAINT lien_habilitation_tiers_consulte_departement_pkey PRIMARY KEY (lien_habilitation_tiers_consulte_departement)
);

--
-- Name: COLUMN lien_habilitation_tiers_consulte_departement.lien_habilitation_tiers_consulte_departement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_departement.lien_habilitation_tiers_consulte_departement IS 'Identifiant unique';

--
-- Name: COLUMN lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte IS 'Identifiant de l''habilitation du tiers consulté';

--
-- Name: COLUMN lien_habilitation_tiers_consulte_departement.departement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_departement.departement IS 'Identifiant de la departement';

--
-- Name: lien_habilitation_tiers_consulte_departement_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE IF NOT EXISTS lien_habilitation_tiers_consulte_departement_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

--
-- Name: lien_habilitation_tiers_consulte_departement lien_habilitation_tiers_consulte_departement_htc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_departement
    DROP CONSTRAINT IF EXISTS lien_habilitation_tiers_consulte_departement_htc_fkey;
ALTER TABLE ONLY lien_habilitation_tiers_consulte_departement
    ADD CONSTRAINT lien_habilitation_tiers_consulte_departement_htc_fkey FOREIGN KEY (habilitation_tiers_consulte) REFERENCES habilitation_tiers_consulte(habilitation_tiers_consulte);

--
-- Name: lien_habilitation_tiers_consulte_departement lien_habilitation_tiers_consulte_departement_dept_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_departement
    DROP CONSTRAINT IF EXISTS lien_habilitation_tiers_consulte_departement_dept_fkey;
ALTER TABLE ONLY lien_habilitation_tiers_consulte_departement
    ADD CONSTRAINT lien_habilitation_tiers_consulte_departement_dept_fkey FOREIGN KEY (departement) REFERENCES departement(departement);

--
-- Name: habilitation_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--

ALTER TABLE ONLY habilitation_tiers_consulte DROP IF EXISTS division_territoire_intervention;

ALTER TABLE ONLY dossier_operateur 
    RENAME COLUMN operateur_collterr_selectionne TO operateur_selectionne;

--
-- END / #1414 — [#9890] [MC0039961] Gestion des opérateurs
--
