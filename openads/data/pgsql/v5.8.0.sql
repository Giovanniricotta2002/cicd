-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.8.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.8.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9778] Optimisation des requêtes pour l'affichage des champs de fusion dans les éditions
--

--
\i v5.8.0-om_requete.sql

--
-- END / [#9778] Optimisation des requêtes pour l'affichage des champs de fusion dans les éditions
--

--
-- BEGIN / [#9622] - Erreur au niveau du dump de la fonction check_validite_unique
--

CREATE OR REPLACE FUNCTION check_validite_unique() RETURNS trigger AS
$check_validite_unique$
DECLARE
mypieces RECORD;
BEGIN
IF (NEW.om_validite_fin > CURRENT_DATE
    OR NEW.om_validite_fin IS NULL
) THEN
    FOR mypieces IN
        SELECT
            *
        FROM
            openads.document_numerise_type
        WHERE
            document_numerise_type.code LIKE NEW.code
            AND document_numerise_type.document_numerise_type != NEW.document_numerise_type
        LOOP
        IF (mypieces.om_validite_fin > CURRENT_DATE
            OR mypieces.om_validite_fin IS NULL
        ) THEN
            RAISE EXCEPTION 'Il ne peut pas y avoir deux codes valide pour un type de pièce';
        END IF;
    END LOOP;
END IF;
RETURN NEW;
END;
$check_validite_unique$
LANGUAGE 'plpgsql' VOLATILE;

--
-- END / [#9622] - Erreur au niveau du dump de la fonction check_validite_unique
--

--
-- BEGIN / [#9769] - Gestion des délégations de signature
--

--
-- Name: signataire_habilitation; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE signataire_habilitation (
    signataire_habilitation integer NOT NULL,
    libelle CHARACTER VARYING(255) NOT NULL,
    code CHARACTER VARYING(20) UNIQUE,
    description CHARACTER VARYING(255),
    om_validite_debut date,
    om_validite_fin date
);

ALTER TABLE signataire_habilitation
    ADD CONSTRAINT signataire_habilitation_pkey PRIMARY KEY (signataire_habilitation);

--
-- Name: signataire_habilitation_seq; Type: SEQUENCE; Schema: openads; Owner: -
--
CREATE SEQUENCE signataire_habilitation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE signataire_arrete
    ADD COLUMN signataire_habilitation integer,
    ADD COLUMN agrement TEXT,
    ADD COLUMN visa TEXT;

ALTER TABLE signataire_arrete
    ADD CONSTRAINT signataire_arrete_signataire_habilitation_fkey
        FOREIGN KEY (signataire_habilitation)
        REFERENCES signataire_habilitation(signataire_habilitation);

--
-- Ajout des permissions a tous les profils type administrateur
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'signataire_habilitation', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'signataire_habilitation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'signataire_habilitation', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'signataire_habilitation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'signataire_habilitation', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'signataire_habilitation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'signataire_habilitation', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'signataire_habilitation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

--
-- Évolution de la requête permettant de récupérer les champs de fusion de l'instruction pour
-- récupérer également l'agrement et le visa du signataire
--

UPDATE om_requete AS omr SET
    requete = regexp_replace(
        regexp_replace(
            omr.requete,
            '(-- *Données générales de l''événement d''instruction)',
            E'\\1\nsignataire_arrete.agrement AS agrement_signataire,\nsignataire_arrete.visa AS visa_signataire,'
        ),
        '(ON instruction.signataire_arrete = signataire_arrete.signataire_arrete)',
        E'\\1\nLEFT JOIN\n&DB_PREFIXEsignataire_habilitation\nON signataire_arrete.signataire_habilitation = signataire_habilitation.signataire_habilitation\n'
    ),
    merge_fields = regexp_replace(
        omr.merge_fields,
        '(-- *Noms des signataires)',
        E'\\1\n[agrement_signataire],\n[visa_signataire],'
    )
WHERE
    omr.code = 'instruction';



--
-- END / [#9769] - Gestion des délégations de signature
--

--
-- BEGIN / [#9767] - Absence de signataire sur un document finalisé 
--

ALTER TABLE
    ONLY evenement
ADD COLUMN
    signataire_obligatoire boolean DEFAULT false;

COMMENT ON COLUMN evenement.signataire_obligatoire IS 'Option servant a indiquer si un signataire doit obligatoirement être renseigné avant finalisation.';

--
-- END / [#9767] - Absence de signataire sur un document finalisé 
--

--
-- BEGIN / [#9773] - Les dossiers importés ne sont pas visible dans les listings des dossiers d'instruction
--

CREATE INDEX IF NOT EXISTS demande_dossier_instruction ON demande (dossier_instruction);

--
-- END / [#9773] - Les dossiers importés ne sont pas visible dans les listings des dossiers d'instruction
--


--
-- BEGIN / [#9780] - Gestion des consultations pour l’archéologie & acteurs consultés
--


--
-- Name: categorie_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE categorie_tiers_consulte (
    categorie_tiers_consulte integer NOT NULL,
    code CHARACTER VARYING(50) NULL,
    description text NULL,
    libelle CHARACTER VARYING(255) NOT NULL,
    om_validite_debut date NULL,
    om_validite_fin date NULL
);

ALTER TABLE categorie_tiers_consulte
    ADD CONSTRAINT categorie_tiers_consulte_pkey PRIMARY KEY (categorie_tiers_consulte);

CREATE SEQUENCE categorie_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN categorie_tiers_consulte.categorie_tiers_consulte IS 'Identifiant unique';
COMMENT ON COLUMN categorie_tiers_consulte.code IS 'Code de la catégorie du tiers consulté';
COMMENT ON COLUMN categorie_tiers_consulte.description IS 'Description de la catégorie du tiers consulté';
COMMENT ON COLUMN categorie_tiers_consulte.libelle IS 'Libellé de la catégorie du tiers consulté';
COMMENT ON COLUMN categorie_tiers_consulte.om_validite_debut IS 'Date de début de validité de catégorie du tiers consulté';
COMMENT ON COLUMN categorie_tiers_consulte.om_validite_fin IS 'Date de fin de validité de catégorie du tiers consulté';


--
-- Name: tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE tiers_consulte (
    tiers_consulte integer NOT NULL,
    categorie_tiers_consulte integer NOT NULL,
    abrege CHARACTER VARYING(30) NOT NULL,
    libelle CHARACTER VARYING(255) NOT NULL,
    adresse CHARACTER VARYING(300) NULL,
    complement CHARACTER VARYING(300) NULL,
    cp CHARACTER VARYING(5) NULL,
    ville CHARACTER VARYING(255) NULL,
    liste_diffusion text NULL,
    accepte_notification_email BOOLEAN DEFAULT false,
    uid_platau_acteur CHARACTER VARYING(255) NULL
);

ALTER TABLE tiers_consulte
    ADD CONSTRAINT tiers_consulte_pkey PRIMARY KEY (tiers_consulte),
    ADD CONSTRAINT categorie_tiers_consulte_categorie_consulte_fkey FOREIGN KEY (categorie_tiers_consulte) REFERENCES categorie_tiers_consulte(categorie_tiers_consulte);

CREATE SEQUENCE tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN tiers_consulte.tiers_consulte IS 'Identifiant unique';
COMMENT ON COLUMN tiers_consulte.categorie_tiers_consulte IS 'Catégorie du tiers consulté';
COMMENT ON COLUMN tiers_consulte.abrege IS 'Abréviation du tiers consulté';
COMMENT ON COLUMN tiers_consulte.libelle IS 'Libellé du tiers consulté';
COMMENT ON COLUMN tiers_consulte.adresse IS 'Adresse du tiers consulté';
COMMENT ON COLUMN tiers_consulte.complement IS 'Complément d''adresse';
COMMENT ON COLUMN tiers_consulte.cp IS 'Code postal de l''adresse du tiers consulté';
COMMENT ON COLUMN tiers_consulte.ville IS 'Ville de l''adresse du tiers consulté';
COMMENT ON COLUMN tiers_consulte.liste_diffusion IS 'Liste de diffusion du tiers consulté';
COMMENT ON COLUMN tiers_consulte.accepte_notification_email IS 'Le tiers consulté accepte la notification par mail';
COMMENT ON COLUMN tiers_consulte.uid_platau_acteur IS 'Identifant acteur du service consulté dans Plat''AU';

--
-- Name: lien_categorie_tiers_consulte_om_collectivite; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE lien_categorie_tiers_consulte_om_collectivite (
    lien_categorie_tiers_consulte_om_collectivite integer NOT NULL,
    categorie_tiers_consulte integer NOT NULL,
    om_collectivite integer NOT NULL
);

ALTER TABLE lien_categorie_tiers_consulte_om_collectivite
    ADD CONSTRAINT lien_categorie_tiers_consulte_om_collectivite_pkey PRIMARY KEY (lien_categorie_tiers_consulte_om_collectivite),
    ADD CONSTRAINT lien_categorie_tiers_consulte_om_collectivite_oc_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite),
    ADD CONSTRAINT lien_categorie_tiers_consulte_om_collectivite_ctc_fkey FOREIGN KEY (categorie_tiers_consulte) REFERENCES categorie_tiers_consulte(categorie_tiers_consulte);

CREATE SEQUENCE lien_categorie_tiers_consulte_om_collectivite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN lien_categorie_tiers_consulte_om_collectivite.lien_categorie_tiers_consulte_om_collectivite IS 'Identifiant unique';
COMMENT ON COLUMN lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte IS 'Identifiant de la catégorie du tiers consulté';
COMMENT ON COLUMN lien_categorie_tiers_consulte_om_collectivite.om_collectivite IS 'Identifiant de la collectivité';


--
-- Name: lien_om_utilisateur_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE lien_om_utilisateur_tiers_consulte (
    lien_om_utilisateur_tiers_consulte integer NOT NULL,
    om_utilisateur integer NOT NULL,
    tiers_consulte integer NOT NULL
);

ALTER TABLE lien_om_utilisateur_tiers_consulte
    ADD CONSTRAINT lien_om_utilisateur_tiers_consulte_pkey PRIMARY KEY (lien_om_utilisateur_tiers_consulte),
    ADD CONSTRAINT lien_om_utilisateur_tiers_consulte_om_utilisateur_fkey FOREIGN KEY (om_utilisateur) REFERENCES om_utilisateur(om_utilisateur),
    ADD CONSTRAINT lien_om_utilisateur_tiers_consulte_tiers_consulte_fkey FOREIGN KEY (tiers_consulte) REFERENCES tiers_consulte(tiers_consulte);

CREATE SEQUENCE lien_om_utilisateur_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN lien_om_utilisateur_tiers_consulte.lien_om_utilisateur_tiers_consulte IS 'Identifiant unique';
COMMENT ON COLUMN lien_om_utilisateur_tiers_consulte.om_utilisateur IS 'Identifiant de l''utilisateur';
COMMENT ON COLUMN lien_om_utilisateur_tiers_consulte.tiers_consulte IS 'Identifiant du tiers consulté';


--
-- Name: type_habilitation_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE type_habilitation_tiers_consulte (
    type_habilitation_tiers_consulte integer NOT NULL,
    code CHARACTER VARYING(50) NULL,
    description text NULL,
    libelle CHARACTER VARYING(255) NULL,
    om_validite_debut date NULL,
    om_validite_fin date NULL
);

ALTER TABLE type_habilitation_tiers_consulte
    ADD CONSTRAINT type_habilitation_tiers_consulte_pkey PRIMARY KEY (type_habilitation_tiers_consulte);

CREATE SEQUENCE type_habilitation_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN type_habilitation_tiers_consulte.type_habilitation_tiers_consulte IS 'Identifiant unique';
COMMENT ON COLUMN type_habilitation_tiers_consulte.code IS 'Code du type d''habilitation';
COMMENT ON COLUMN type_habilitation_tiers_consulte.description IS 'Description du type d''habilitation';
COMMENT ON COLUMN type_habilitation_tiers_consulte.libelle IS 'Libellé du type d''habilitation';
COMMENT ON COLUMN type_habilitation_tiers_consulte.om_validite_debut IS 'Date de début de validité du type d''habilitation';
COMMENT ON COLUMN type_habilitation_tiers_consulte.om_validite_fin IS 'Date de fin de validité du type d''habilitation';


--
-- Name: specialite_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE specialite_tiers_consulte (
    specialite_tiers_consulte integer NOT NULL,
    code CHARACTER VARYING(50) NULL,
    description text NULL,
    libelle CHARACTER VARYING(255) NULL,
    om_validite_debut date NULL,
    om_validite_fin date NULL
);

ALTER TABLE specialite_tiers_consulte
    ADD CONSTRAINT specialite_tiers_consulte_pkey PRIMARY KEY (specialite_tiers_consulte);

CREATE SEQUENCE specialite_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN specialite_tiers_consulte.specialite_tiers_consulte IS 'Identifiant unique';
COMMENT ON COLUMN specialite_tiers_consulte.code IS 'Code de la spécialité';
COMMENT ON COLUMN specialite_tiers_consulte.description IS 'Description de la spécialité';
COMMENT ON COLUMN specialite_tiers_consulte.libelle IS 'Libellé de la spécialité';
COMMENT ON COLUMN specialite_tiers_consulte.om_validite_debut IS 'Date de début de validité de la spécialité du tiers consulté';
COMMENT ON COLUMN specialite_tiers_consulte.om_validite_fin IS 'Date de fin de validité de la spécialité du tiers consulté';



--
-- Name: habilitation_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE habilitation_tiers_consulte (
    habilitation_tiers_consulte integer NOT NULL,
    type_habilitation_tiers_consulte integer NOT NULL,
    division_territoire_intervention text NULL,
    texte_agrement text NULL,
    division_territoriales text NULL,
    om_validite_debut date NULL,
    om_validite_fin date NULL
);

ALTER TABLE habilitation_tiers_consulte
    ADD CONSTRAINT habilitation_tiers_consulte_pkey PRIMARY KEY (habilitation_tiers_consulte),
    ADD CONSTRAINT habilitation_tiers_consulte_thtc_fkey FOREIGN KEY (type_habilitation_tiers_consulte) REFERENCES type_habilitation_tiers_consulte(type_habilitation_tiers_consulte);

CREATE SEQUENCE habilitation_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN habilitation_tiers_consulte.habilitation_tiers_consulte IS 'Identifiant unique';
COMMENT ON COLUMN habilitation_tiers_consulte.type_habilitation_tiers_consulte IS 'Identifiant unique du type d''habilitation';
COMMENT ON COLUMN habilitation_tiers_consulte.division_territoire_intervention IS 'Division territoriale d’intervention';
COMMENT ON COLUMN habilitation_tiers_consulte.texte_agrement IS 'Texte d’agrément';
COMMENT ON COLUMN habilitation_tiers_consulte.division_territoriales IS 'Divisions territoriales';
COMMENT ON COLUMN habilitation_tiers_consulte.om_validite_debut IS 'Date de début de validité de l''habilitation du tiers consulté';
COMMENT ON COLUMN habilitation_tiers_consulte.om_validite_fin IS 'Date de fin de validité de l''habilitation du tiers consulté';


--
-- Name: lien_habilitation_tiers_consulte_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE lien_habilitation_tiers_consulte_tiers_consulte (
    lien_habilitation_tiers_consulte_tiers_consulte integer NOT NULL,
    habilitation_tiers_consulte integer NOT NULL,
    tiers_consulte integer NOT NULL
);

ALTER TABLE lien_habilitation_tiers_consulte_tiers_consulte
    ADD CONSTRAINT lien_habilitation_tiers_consulte_tiers_consulte_pkey PRIMARY KEY (lien_habilitation_tiers_consulte_tiers_consulte),
    ADD CONSTRAINT lien_habilitation_tiers_consulte_tiers_consulte_htc_fkey FOREIGN KEY (habilitation_tiers_consulte) REFERENCES habilitation_tiers_consulte(habilitation_tiers_consulte),
    ADD CONSTRAINT lien_habilitation_tiers_consulte_tiers_consulte_tc_fkey FOREIGN KEY (tiers_consulte) REFERENCES tiers_consulte(tiers_consulte);

CREATE SEQUENCE lien_habilitation_tiers_consulte_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN lien_habilitation_tiers_consulte_tiers_consulte.lien_habilitation_tiers_consulte_tiers_consulte IS 'Identifiant unique';
COMMENT ON COLUMN lien_habilitation_tiers_consulte_tiers_consulte.tiers_consulte IS 'Identifiant de l''utilisateur';
COMMENT ON COLUMN lien_habilitation_tiers_consulte_tiers_consulte.habilitation_tiers_consulte IS 'Identifiant du tiers consulté';



--
-- Name: lien_habilitation_tiers_consulte_specialite_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE lien_habilitation_tiers_consulte_specialite_tiers_consulte (
    lien_habilitation_tiers_consulte_specialite_tiers_consulte integer NOT NULL,
    habilitation_tiers_consulte integer NOT NULL,
    specialite_tiers_consulte integer NOT NULL
);

ALTER TABLE lien_habilitation_tiers_consulte_specialite_tiers_consulte
    ADD CONSTRAINT lien_habilitation_tiers_consulte_specialite_tiers_consulte_pkey PRIMARY KEY (lien_habilitation_tiers_consulte_specialite_tiers_consulte),
    ADD CONSTRAINT lien_habilitation_tiers_consulte_stc_htc_fkey FOREIGN KEY (habilitation_tiers_consulte) REFERENCES habilitation_tiers_consulte(habilitation_tiers_consulte),
    ADD CONSTRAINT lien_habilitation_tiers_consulte_stc_stc_fkey FOREIGN KEY (specialite_tiers_consulte) REFERENCES specialite_tiers_consulte(specialite_tiers_consulte);

CREATE SEQUENCE lien_habilitation_tiers_consulte_specialite_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
--
COMMENT ON COLUMN lien_habilitation_tiers_consulte_specialite_tiers_consulte.lien_habilitation_tiers_consulte_specialite_tiers_consulte IS 'Identifiant unique';
COMMENT ON COLUMN lien_habilitation_tiers_consulte_specialite_tiers_consulte.habilitation_tiers_consulte IS 'Identifiant de l''utilisateur';
COMMENT ON COLUMN lien_habilitation_tiers_consulte_specialite_tiers_consulte.specialite_tiers_consulte IS 'Identifiant du tiers consulté';


--
-- Name: motif_consultation; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE motif_consultation (
    motif_consultation integer NOT NULL,
    code CHARACTER VARYING(50) NULL,
    description text NULL,
    libelle CHARACTER VARYING(255) NULL,
    notification_email boolean default false,
    delai_type CHARACTER VARYING(100) NULL default 'mois',
    delai integer NULL,
    consultation_papier boolean default false,
    om_validite_debut date,
    om_validite_fin date,
    type_consultation CHARACTER VARYING(70) NULL default 'avec_avis_attendu',
    om_etat integer NULL,
    service_type CHARACTER VARYING(255) NOT NULL,
    generer_edition boolean default false
);

ALTER TABLE motif_consultation
    ADD CONSTRAINT motif_consultation_pkey PRIMARY KEY (motif_consultation),
    ADD CONSTRAINT motif_consultation_om_etat_fkey FOREIGN KEY (om_etat) REFERENCES om_etat(om_etat);

CREATE SEQUENCE motif_consultation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN motif_consultation.motif_consultation IS 'Identifiant unique';
COMMENT ON COLUMN motif_consultation.code IS 'Code du motif de consultation';
COMMENT ON COLUMN motif_consultation.description IS 'Description du motif consulté';
COMMENT ON COLUMN motif_consultation.libelle IS 'Libellé du motif de consultation';
COMMENT ON COLUMN motif_consultation.notification_email IS 'La consultation nécessite l''envoi d''un email';
COMMENT ON COLUMN motif_consultation.delai_type IS 'Type de délai (mois ou jour)';
COMMENT ON COLUMN motif_consultation.delai IS 'Delai de consultation au service';
COMMENT ON COLUMN motif_consultation.consultation_papier IS 'La consultation nécessite l''envoi d''un courrier';
COMMENT ON COLUMN motif_consultation.om_validite_debut IS 'Date de début de validité du motif de consultation';
COMMENT ON COLUMN motif_consultation.om_validite_fin IS 'Date de fin de validité du motif de consultation';
COMMENT ON COLUMN motif_consultation.type_consultation IS 'Type de consultation (pour conformité, avis attendu, pour information)';
COMMENT ON COLUMN motif_consultation.om_etat IS 'Edition du motif de consultation';
COMMENT ON COLUMN motif_consultation.service_type IS 'Type du service';
COMMENT ON COLUMN motif_consultation.generer_edition IS 'Générer l''édition liée au service consulté (true) ou non (false)';

--
-- Name: lien_motif_consultation_om_collectivite; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE lien_motif_consultation_om_collectivite (
    lien_motif_consultation_om_collectivite integer NOT NULL,
    motif_consultation integer NOT NULL,
    om_collectivite integer NOT NULL
);

ALTER TABLE lien_motif_consultation_om_collectivite
    ADD CONSTRAINT lien_motif_consultation_om_collectivite_pkey PRIMARY KEY (lien_motif_consultation_om_collectivite),
    ADD CONSTRAINT lien_motif_consultation_om_collectivite_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite),
    ADD CONSTRAINT lien_motif_consultation_om_collectivite_motif_consultation_fkey FOREIGN KEY (motif_consultation) REFERENCES motif_consultation(motif_consultation);

CREATE SEQUENCE lien_motif_consultation_om_collectivite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN lien_motif_consultation_om_collectivite.lien_motif_consultation_om_collectivite IS 'Identifiant unique';
COMMENT ON COLUMN lien_motif_consultation_om_collectivite.motif_consultation IS 'Identifiant du motif de consultation';
COMMENT ON COLUMN lien_motif_consultation_om_collectivite.om_collectivite IS 'Identifiant de la collectivité';

-- Ajout de la case a cocher permet de savoir si les tiers consulte peuvent être notifié
ALTER TABLE evenement
    ADD COLUMN notification_tiers BOOLEAN DEFAULT false;

COMMENT ON COLUMN evenement.notification_tiers IS 'Indique si la notification des tiers consultés est possible';

-- Administrateur Technique et Fonctionnel
INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'categorie_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'categorie_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'lien_om_utilisateur_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_om_utilisateur_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'type_habilitation_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'type_habilitation_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'specialite_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'specialite_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'habilitation_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'habilitation_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'motif_consultation', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'motif_consultation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

-- Administrateur Général
INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'categorie_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'categorie_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'lien_om_utilisateur_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_om_utilisateur_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'type_habilitation_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'type_habilitation_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'specialite_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'specialite_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'habilitation_tiers_consulte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'habilitation_tiers_consulte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'motif_consultation', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'motif_consultation' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

--
-- END / [#9780] - Gestion des consultations pour l’archéologie & acteurs consultés
--

--
-- BEGIN / [#9776] - Notification d'un service consulté par mail depuis une instruction
--

ALTER TABLE instruction_notification_document
    ADD COLUMN document_id INTEGER;

ALTER TABLE instruction_notification_document
    ADD COLUMN document_type CHARACTER VARYING (100);

ALTER TABLE service
    ADD COLUMN accepte_notification_email BOOLEAN DEFAULT false;

ALTER TABLE evenement
    ADD COLUMN notification_service BOOLEAN DEFAULT false;

COMMENT ON COLUMN instruction_notification_document.document_id IS 'Identifiant de l''élément auquel appartiens le document.';
COMMENT ON COLUMN instruction_notification_document.document_type IS 'Nom de la table à laquelle est rattaché le document';
COMMENT ON COLUMN service.accepte_notification_email IS 'Indique si le service accepte les notifications par mail';
COMMENT ON COLUMN service.accepte_notification_email IS 'Indique si la notification des services consultés est possible';

-- Mise à jour des notifications existantes
UPDATE instruction_notification_document SET
document_type = 'instruction',
document_id = instruction
WHERE document_type IS NULL;

--
-- END / [#9776] - Notification d'un service consulté par mail depuis une instruction 
--


--
-- BEGIN /  [#9777] - Augmenter la longueur du champ "Voie" 
--

ALTER TABLE 
    ONLY demande
ALTER COLUMN
    terrain_adresse_voie TYPE character varying(300);

ALTER TABLE 
    ONLY dossier_autorisation
ALTER COLUMN
    terrain_adresse_voie TYPE character varying(300);

ALTER TABLE 
    ONLY dossier
ALTER COLUMN
    terrain_adresse_voie TYPE character varying(300);

--
-- END /  [#9777] - Augmenter la longueur du champ "Voie" 
--
