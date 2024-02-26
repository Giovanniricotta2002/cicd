-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.0.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.0.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN /  [#9606] - Contrôle de données et déclencheurs 
--
ALTER TABLE dossier
    ADD COLUMN etat_transmission_platau text NOT NULL DEFAULT 'non_transmissible';

COMMENT ON COLUMN dossier.etat_transmission_platau IS 'Permet de déterminer si les données d''un dossier ont été transmises à Plat''AU lors de l''ajout. Valeurs possibles : non_transmissible, transmis_mais_non_transmissible et transmissible';

ALTER TABLE dossier_autorisation_type_detaille
    ADD COLUMN dossier_platau BOOLEAN NULL DEFAULT FALSE;

COMMENT ON COLUMN dossier_autorisation_type_detaille.dossier_platau IS 'Permet de déterminer si le type de dossier d''instruction est transmissible à Plat''AU';

--
COMMENT ON COLUMN task.state IS 'Statut (draft, new, pending, done, archived, error, debug, canceled)';

-- Gestion des permissions pour accéder au listing des dossiers non transmisible Plat'AU
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_non_transmis', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_non_transmis' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Ajout du widget Dossiers non transmis à Plat''AU'
INSERT INTO om_widget (om_widget, libelle, lien, texte, script, type)
SELECT nextval('om_widget_seq'), 'Dossiers non transmis à Plat''AU', '', '', 'controle_donnee', 'file'
WHERE NOT EXISTS (
    SELECT libelle FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU' AND script = 'controle_donnee'
);

-- Ajout du widget Dossiers non transmis à Plat''AU' sur le tableau de bord des profils
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'), 'C3', 4, (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
--
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'), 'C3', 2, (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);
--
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI'), 'C2', 1, (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);
--
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'), 'C3', 2, (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);
--
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'), 'C3', 2, (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);
--
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'), 'C3', 4, (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);
--
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'), 'C3', 3, (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'), 'C3', 4, (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
--
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'), 'C3', 4, (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU')
WHERE NOT EXISTS (
    SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers non transmis à Plat''AU') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

--
-- END /  [#9606] - Contrôle de données et déclencheurs 
--

--
-- BEGIN / Gestion des nomenclature
--

-- nouvelle table 'lien_document_n_type_d_i_t'
CREATE TABLE lien_document_n_type_d_i_t (
    lien_document_n_type_d_i_t integer NOT NULL,
    document_numerise_type integer NOT NULL,
    dossier_instruction_type integer NOT NULL,
    code character varying(10) NOT NULL
);

ALTER TABLE ONLY lien_document_n_type_d_i_t
    ADD CONSTRAINT lien_document_n_type_d_i_t_pkey PRIMARY KEY (lien_document_n_type_d_i_t);

CREATE SEQUENCE lien_document_n_type_d_i_t_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY lien_document_n_type_d_i_t
    ADD CONSTRAINT lien_document_n_type_d_i_t_document_numerise_type
        FOREIGN KEY (document_numerise_type)
        REFERENCES document_numerise_type(document_numerise_type);

ALTER TABLE ONLY lien_document_n_type_d_i_t
    ADD CONSTRAINT lien_document_n_type_d_i_t_d_i_t
        FOREIGN KEY (dossier_instruction_type)
        REFERENCES dossier_instruction_type(dossier_instruction_type);

COMMENT ON COLUMN lien_document_n_type_d_i_t.lien_document_n_type_d_i_t IS 'Identifiant de la reference du document numerise pour le type de dossier d''instruction';
COMMENT ON COLUMN lien_document_n_type_d_i_t.document_numerise_type IS 'Identifiant du type de document numerisé';
COMMENT ON COLUMN lien_document_n_type_d_i_t.dossier_instruction_type IS 'Identifiant du type de dossier d''instruction';
COMMENT ON COLUMN lien_document_n_type_d_i_t.code IS 'Code de la pièce';

-- permission permettant d'accéder à la table dans l'application
INSERT INTO om_droit (om_droit, libelle, om_profil) VALUES (nextval('om_droit_seq'), 'lien_document_n_type_d_i_t', 19);

-- augmentation de la taille du libellé des types de documents numérisés
ALTER TABLE ONLY document_numerise_type ALTER COLUMN libelle TYPE character varying(2000);

-- Suppression de la contrainte d'unicité du champ code de la table document_numerise_type
-- pour le remplacer par une contrainte d'unicité liée à sa validité

ALTER TABLE ONLY document_numerise_type
    DROP CONSTRAINT IF EXISTS document_numerise_type_code_key;

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

CREATE TRIGGER before_insert_or_update_document_numerise_type
    BEFORE INSERT OR UPDATE ON document_numerise_type
    FOR EACH ROW EXECUTE PROCEDURE check_validite_unique();

-- Gestion du type de pièce "autre à préciser" : ajout d'un champ description_type

ALTER TABLE document_numerise
    ADD COLUMN description_type character varying(2000);

COMMENT ON COLUMN document_numerise.description_type IS 'Description du type de pièce destiné aux pièces "Autre à préciser"';

-- supression du champ default de la table document_numerise_nature

ALTER TABLE document_numerise_nature
    DROP COLUMN IF EXISTS default_value;

--
COMMENT ON COLUMN document_numerise.document_numerise_nature IS 'Nature du document';

--
-- END / Gestion des nomenclature
--

--
-- BEGIN / Évolution de l'onglet pièces
--

-- Différenciation des documents de travail des autres documents numérisé

ALTER TABLE document_numerise
    ADD COLUMN document_travail BOOLEAN NOT NULL DEFAULT FALSE;

--
COMMENT ON COLUMN document_numerise.document_travail IS 'Indique si le document est un document de travail';

-- Ajout des permissions
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_previsualiser', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_previsualiser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_previsualiser', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_previsualiser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_previsualiser', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_previsualiser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_previsualiser', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_previsualiser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_previsualiser', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_previsualiser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_previsualiser', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_previsualiser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_previsualiser', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_previsualiser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_previsualiser', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_previsualiser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_modifier_fichier', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_modifier_fichier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_modifier_fichier', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_modifier_fichier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_modifier_fichier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_modifier_fichier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_modifier_fichier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_modifier_fichier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_modifier_fichier', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_modifier_fichier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / Évolution de l'onglet pièces
--

--
-- BEGIN / [#9605] - Historisation des rapports d'instruction
--

-- Ajout d'un champ permettant de savoir si un élément du storage fait partie
-- du dossier final ou pas

ALTER TABLE storage
    ADD COLUMN uid_dossier_final BOOLEAN DEFAULT FALSE;

COMMENT ON COLUMN storage.uid_dossier_final IS 'Identifie que le document constitue dossier final';

-- Ajout des permissions
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'storage_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'storage_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'storage_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'storage_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'storage_uid_telecharger', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'storage_uid_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'storage_uid_telecharger', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'storage_uid_telecharger' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

--
-- END / [#9605] - Historisation des rapports d'instruction
--

--
-- BEGIN / [#9601] Ajouter un lien Google Maps Street View despuis les dossiers d'instruction
--

-- Ajout des permissions nécessaires
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);
 INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ DI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ DI')
);

--
-- END / [#9601] Ajouter un lien Google Maps Street View despuis les dossiers d'instruction
--

