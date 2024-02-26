-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.13.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.13.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9936] Gestion des opérations d’archéologie, mise en place des sous-dossiers
--

-- Champs permettant de stocker l'identifiant du dossier parent d'un sous dossier
ALTER TABLE dossier ADD COLUMN dossier_parent character varying(255);
COMMENT ON COLUMN dossier.dossier_parent IS 'Identifiant du dossier parent d''un sous-dossier.';

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_dossier_fkey FOREIGN KEY (dossier_parent) REFERENCES dossier(dossier);

-- Champs permettant de savoir si un type de dossier concerne des sous dossiers ou des DI
ALTER TABLE dossier_instruction_type ADD COLUMN sous_dossier BOOLEAN DEFAULT FALSE NOT NULL ;
COMMENT ON COLUMN dossier_instruction_type.sous_dossier IS 'Indique si un type de dossier d''instruction est un sous-dossier.';

-- Suppression de la contrainte NOT NULL du champs dossier_autorisation_type_detaille car
-- pour les sous-dossiers cette valeur est récupéré à partir du dossier parent
ALTER TABLE ONLY dossier_instruction_type
    ALTER COLUMN dossier_autorisation_type_detaille DROP NOT NULL;

--
-- Name: lien_type_di_type_di; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE lien_type_di_type_di (
    lien_type_di_type_di INTEGER,
    type_DI_parent INTEGER NOT NULL,
    dossier_instruction_type INTEGER NOT NULL,
    CONSTRAINT lien_type_di_type_di_pkey PRIMARY KEY (lien_type_di_type_di)
);

ALTER TABLE ONLY lien_type_di_type_di
    ADD CONSTRAINT lien_type_di_type_di_type_di_parent_fkey FOREIGN KEY (type_di_parent) REFERENCES dossier_instruction_type(dossier_instruction_type);

ALTER TABLE ONLY lien_type_di_type_di
    ADD CONSTRAINT lien_type_di_type_di_type_di_ss_di_fkey FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);

CREATE SEQUENCE IF NOT EXISTS lien_type_di_type_di_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN lien_type_di_type_di.lien_type_di_type_di IS 'Identifiant de la liaison entre un type de DI et un type de sous dossier';
COMMENT ON COLUMN lien_type_di_type_di.type_di_parent IS 'Identifiant du type de DI du dossier parent.';
COMMENT ON COLUMN lien_type_di_type_di.dossier_instruction_type IS 'Identifiant du type de DI du sous dossier.';

-- Permissions
INSERT INTO om_droit(om_droit, libelle, om_profil)
    SELECT
        *
    FROM
        -- sous requete permettant de récupérer l'id du droit à partir de la séquence
        -- le libelle du droit en remplaçant dossier_instruction par sous_dossier
        -- le profil associé au droit que l'on soouhaite copier pour les sous-dossier
        (SELECT
                nextval('om_droit_seq'),
                REPLACE(om_droit.libelle, 'dossier_instruction', 'sous_dossier'),
                om_profil.om_profil
            FROM
                om_droit
                LEFT JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
            WHERE
                om_droit.libelle LIKE 'dossier_instruction%')
        AS nvx_droits(om_droit, libelle, om_profil)
    -- Vérification que le droit que l'on souhaite ajouter n'existe pas déjà dans
    -- la base. Si il existe, il ne sera pas ajouté
    WHERE NOT EXISTS
        (SELECT
            *
        FROM
            om_droit
        WHERE
            om_droit.libelle = nvx_droits.libelle
            AND om_droit.om_profil = nvx_droits.om_profil);

-- Gestion particulière des permissions pour les documents numérisés et les
-- contraintes
INSERT INTO om_droit(om_droit, libelle, om_profil)
    SELECT
        *
    FROM
        -- sous requete permettant de récupérer l'id du droit à partir de la séquence
        -- le libelle du droit en remplaçant dossier_instruction par sous_dossier
        -- le profil associé au droit que l'on soouhaite copier pour les sous-dossier
        (SELECT
                nextval('om_droit_seq'),
                REPLACE(om_droit.libelle, 'dossier', 'sous_dossier'),
                om_profil.om_profil
            FROM
                om_droit
                LEFT JOIN om_profil ON om_droit.om_profil = om_profil.om_profil
            WHERE
                om_droit.libelle LIKE 'dossier_contrainte%' OR
                om_droit.libelle LIKE 'dossier_document%')
        AS nvx_droits(om_droit, libelle, om_profil)
    -- Vérification que le droit que l'on souhaite ajouter n'existe pas déjà dans
    -- la base. Si il existe, il ne sera pas ajouté
    WHERE NOT EXISTS
        (SELECT
            *
        FROM
            om_droit
        WHERE
            om_droit.libelle = nvx_droits.libelle
            AND om_droit.om_profil = nvx_droits.om_profil);

--
-- END / [#9936] Gestion des opérations d’archéologie, mise en place des sous-dossiers
--

--
-- BEGIN /  #1443 — [#9924] Ajout de la permission "instruction_modal_selection_document_signe" à un profil instructeur
--

-- Donne la permission à un instructeur de voir le lien du portlet "Remplacer par le document signé"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

-- Donne la permission à un instructeur de voir le contenu de la modale "Remplacer par le document signé"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modale_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modale_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

-- Donne la permission à un instructeur de voir le lien du portlet "Remplacer par le document signé"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

-- Donne la permission à un ADMINISTRATEUR GENERAL de voir le contenu de la modale "Remplacer par le document signé"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modale_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modale_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

-- Donne la permission à un administrateur technique et fonctionnel de voir le contenu de la modale "Remplacer par le document signé"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modale_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modale_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- --
-- END / #1443 — [#9924] Ajout de la permission "instruction_modal_selection_document_signe" à un profil instructeur
--

--
-- BEGIN / [#9939] Ajout d'un champ de fusion pour identifier un dossier déposé électroniquement
--

--
\i v5.13.0-om_requete.sql

--
-- END / [#9939] Ajout d'un champ de fusion pour identifier un dossier déposé électroniquement
