-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.6.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.6.0') WHERE exists(SELECT 1 FROM om_version) = false;

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
-- BEGIN / [#9730] -  Empêcher la création de tâche ajout_piece si la catégorie est différente de Plat'AU 
--

ALTER TABLE document_numerise_type_categorie
ADD COLUMN code CHARACTER VARYING(50) UNIQUE;

COMMENT ON COLUMN document_numerise_type_categorie.code IS 'Code de la catégorie de document numérisé';

--
-- END / [#9730] -  Empêcher la création de tâche ajout_piece si la catégorie est différente de Plat'AU 
--

--
-- BEGIN / [#9723] - Nouveau widget de suivi d'instruction paramétrable
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

--
-- END / [#9723] - Nouveau widget de suivi d'instruction paramétrable
--
