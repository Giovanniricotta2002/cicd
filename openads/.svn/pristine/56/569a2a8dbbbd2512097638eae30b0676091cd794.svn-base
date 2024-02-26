-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.2.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.2.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN /  [#9622] - Erreur au niveau du dump de la fonction check_validite_unique 
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
-- END /  [#9622] - Erreur au niveau du dump de la fonction check_validite_unique
--

--
-- BEGIN / [#9643] Notification des pétitionnaires du dossier depuis les instructions (première partie)
--

--
ALTER TABLE ONLY task
    ADD COLUMN category character varying(2000) NULL;

COMMENT ON COLUMN task.category IS 'Catégorie de la tâche';

-- Met à jour les tâches existantes
UPDATE task SET category = 'platau';

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'task_portal', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'task_portal' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_notification_manuelle', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_notification_manuelle' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_notification_manuelle', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_notification_manuelle' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_notification_manuelle', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_notification_manuelle' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_notification_manuelle', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_notification_manuelle' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_notification_manuelle', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_notification_manuelle' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_notification_manuelle', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_notification_manuelle' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_notification_manuelle', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_notification_manuelle' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_notification_manuelle', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_notification_manuelle' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_notification_manuelle', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_notification_manuelle' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
ALTER TABLE evenement
    ADD COLUMN notification VARCHAR(100);
COMMENT ON COLUMN evenement.notification IS 'Type de notification voulu sur l''évenement';

--
CREATE TABLE instruction_notification(
    instruction_notification INTEGER NOT NULL,
    instruction INTEGER NOT NULL,
    automatique boolean DEFAULT FALSE,
    emetteur VARCHAR(255),
    date_envoi timestamp,
    destinataire VARCHAR(255),
    date_premier_acces timestamp,
    statut VARCHAR(20),
    commentaire VARCHAR(255)
);

ALTER TABLE ONLY instruction_notification
    ADD CONSTRAINT instruction_notification_pkey PRIMARY KEY (instruction_notification);

ALTER TABLE ONLY instruction_notification
    ADD CONSTRAINT om_instruction_notification_instruction_fkey FOREIGN KEY (instruction) REFERENCES instruction(instruction);

CREATE SEQUENCE instruction_notification_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN instruction_notification.instruction_notification IS 'Identifiant unique de la notification.';
COMMENT ON COLUMN instruction_notification.instruction IS 'Identifiant de l''instruction de la notification.';
COMMENT ON COLUMN instruction_notification.automatique IS 'Indique si la notification est automatique ou manuelle.';
COMMENT ON COLUMN instruction_notification.emetteur IS 'Identifiant de l''utilisateur ayant déclenché l''envoi.';
COMMENT ON COLUMN instruction_notification.date_envoi IS 'Date et heure d''envoi de la notification.';
COMMENT ON COLUMN instruction_notification.destinataire IS 'Courriel du destinataire.';
COMMENT ON COLUMN instruction_notification.date_premier_acces IS 'Date et heure du premier accès au document';
COMMENT ON COLUMN instruction_notification.statut IS 'Statut de la notification (envoyé, échec, vu)';
COMMENT ON COLUMN instruction_notification.commentaire IS 'Détail du status';

--
CREATE TABLE instruction_notification_document(
    instruction_notification_document INTEGER NOT NULL,
    instruction_notification INTEGER NOT NULL,
    instruction INTEGER NOT NULL,
    cle TEXT UNIQUE,
    annexe boolean DEFAULT FALSE
);

ALTER TABLE ONLY instruction_notification_document
    ADD CONSTRAINT instruction_notification_document_pkey PRIMARY KEY (instruction_notification_document);

ALTER TABLE ONLY instruction_notification_document
    ADD CONSTRAINT om_instruction_notification_document_instruction_notification_fkey FOREIGN KEY (instruction_notification) REFERENCES instruction_notification(instruction_notification);

CREATE SEQUENCE instruction_notification_document_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN instruction_notification_document.instruction_notification_document IS 'Identifiant unique du document de la notification.';
COMMENT ON COLUMN instruction_notification_document.instruction_notification IS 'Identifiant de la notification.';
COMMENT ON COLUMN instruction_notification_document.instruction IS 'Identifiant de l''instruction.';
COMMENT ON COLUMN instruction_notification_document.cle IS 'Clé unique d''accès au document.';
COMMENT ON COLUMN instruction_notification_document.annexe IS 'Indique si il s''agit d''une annexe ou du dosument principal.';

-- Les dossiers existants ne doivent pas être transmis
UPDATE dossier SET etat_transmission_platau = 'jamais_transmissible';

--
ALTER TABLE ONLY lien_id_interne_uid_externe
    ADD COLUMN category character varying(2000) NULL;

COMMENT ON COLUMN lien_id_interne_uid_externe.category IS 'Catégorie de la liaison (récupérée de la task)';

-- Met à jour les liaisons existantes
UPDATE lien_id_interne_uid_externe SET category = 'platau';


ALTER TABLE ONLY lien_id_interne_uid_externe
    DROP CONSTRAINT IF EXISTS lien_id_interne_uid_externe_object_id_key;

ALTER TABLE ONLY lien_id_interne_uid_externe
    ADD CONSTRAINT lien_id_interne_uid_externe_object_id_key UNIQUE (external_uid, object, object_id, category);

-- Modification des valeurs possibles dans source_depot
COMMENT ON COLUMN demande.source_depot IS 'Permet d''indiquer la source de dépot, ce champ peut prendre en valeur : platau, app et portal';

-- Modification des publik en portal
UPDATE demande SET source_depot = 'portal' WHERE source_depot = 'publik';
--
-- END / [#9643] Notification des pétitionnaires du dossier depuis les instructions (première partie)
--

--
-- BEGIN / [#9642] - Mise en place des modifications pour permettre l'utilisation du connecteur iparapheur avec openADS 
--

-- Ajout de la colonne  de la table signataire_arrete
ALTER TABLE signataire_arrete
    ADD COLUMN parametre_parapheur text NULL;
COMMENT ON COLUMN signataire_arrete.parametre_parapheur IS 'Doit contenir du json, permet de spécifier des paramètres supplémentaires au parapheur.';

--
-- END / [#9642] - Mise en place des modifications pour permettre l'utilisation du connecteur iparapheur avec openADS
--

--
-- BEGIN / [#9644] Erreur lors de la création et lors de la suppression des séquences de numérotation des dossiers
--

--
UPDATE dossier_autorisation SET
    numerotation_num = CAST(TRIM(REGEXP_REPLACE(RIGHT(dossier_autorisation, 4), '[[:alpha:]]', '0', 'g')) AS INT)
WHERE numerotation_num IS NULL;

--
-- END / [#9644] Erreur lors de la création et lors de la suppression des séquences de numérotation des dossiers
--
