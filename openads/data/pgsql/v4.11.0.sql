-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.11.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.11.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9179] Instruction de plusieurs dossiers en parallèle
--

-- Ajout d'une table de liaison entre les types de demande et les types de
-- dossier d'instruction
CREATE TABLE lien_demande_type_dossier_instruction_type(
    lien_demande_type_dossier_instruction_type integer,
    demande_type integer,
    dossier_instruction_type integer
);
--
CREATE SEQUENCE lien_demande_type_dossier_instruction_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER SEQUENCE lien_demande_type_dossier_instruction_type_seq
  OWNED BY lien_demande_type_dossier_instruction_type.lien_demande_type_dossier_instruction_type;
--
ALTER TABLE ONLY lien_demande_type_dossier_instruction_type
    ADD CONSTRAINT lien_demande_type_dossier_instruction_type_pkey PRIMARY KEY (lien_demande_type_dossier_instruction_type);
ALTER TABLE ONLY lien_demande_type_dossier_instruction_type
    ADD CONSTRAINT lien_demande_type_dossier_instruction_type_demande_type_fk FOREIGN KEY (demande_type) REFERENCES demande_type(demande_type);
ALTER TABLE ONLY lien_demande_type_dossier_instruction_type
    ADD CONSTRAINT lien_demande_type_dossier_instruction_type_dossier_instruction_type_fk FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);
--
COMMENT ON TABLE lien_demande_type_dossier_instruction_type IS 'Table de liaison entre demande type et dossiers d''instruction type';
COMMENT ON COLUMN lien_demande_type_dossier_instruction_type.lien_demande_type_dossier_instruction_type IS 'Identifiant unique';
COMMENT ON COLUMN lien_demande_type_dossier_instruction_type.demande_type IS 'Fait le lien avec la demadne type';
COMMENT ON COLUMN lien_demande_type_dossier_instruction_type.dossier_instruction_type IS 'Fait le lien avec le type du dossier d''instruction';

-- Ajout des différentes actions de mise à jour du DA
ALTER TABLE dossier_instruction_type
    ADD maj_da_localisation boolean NOT NULL DEFAULT FALSE,
    ADD maj_da_lot boolean NOT NULL DEFAULT FALSE,
    ADD maj_da_demandeur boolean NOT NULL DEFAULT FALSE,
    ADD maj_da_etat boolean NOT NULL DEFAULT FALSE,
    ADD maj_da_date_init boolean NOT NULL DEFAULT FALSE,
    ADD maj_da_date_validite boolean NOT NULL DEFAULT FALSE,
    ADD maj_da_date_doc boolean NOT NULL DEFAULT FALSE,
    ADD maj_da_date_daact boolean NOT NULL DEFAULT FALSE,
    ADD maj_da_dt boolean NOT NULL DEFAULT FALSE;
--
COMMENT ON COLUMN dossier_instruction_type.maj_da_localisation IS 'Mise à jour de la localisation';
COMMENT ON COLUMN dossier_instruction_type.maj_da_lot IS 'Mise à jour des lots';
COMMENT ON COLUMN dossier_instruction_type.maj_da_demandeur IS 'Mise à jour des demandeurs';
COMMENT ON COLUMN dossier_instruction_type.maj_da_etat IS 'Mise à jour de l''état';
COMMENT ON COLUMN dossier_instruction_type.maj_da_date_init IS 'Mise à jour des dates initiales';
COMMENT ON COLUMN dossier_instruction_type.maj_da_date_validite IS 'Mise à jour de la date de validité';
COMMENT ON COLUMN dossier_instruction_type.maj_da_date_doc IS 'Mise à jour de la date d''ouverture du chantier';
COMMENT ON COLUMN dossier_instruction_type.maj_da_date_daact IS 'Mise à jour de la date d''achèvement des travaux';
COMMENT ON COLUMN dossier_instruction_type.maj_da_dt IS 'Mise à jour des données techniques';

--
-- END / [#9179] Instruction de plusieurs dossiers en parallèle
--
