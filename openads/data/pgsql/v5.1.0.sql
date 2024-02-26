-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.1.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.1.0') WHERE exists(SELECT 1 FROM om_version) = false;

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
-- BEGIN / [#9624] Suppression de la contrainte d'unicité sur le nom du fichier dans document_numerise
--

ALTER TABLE ONLY document_numerise
    DROP CONSTRAINT IF EXISTS document_numerise_dossier_nom_fichier_key;

--
-- END / [#9624] Suppression de la contrainte d'unicité sur le nom du fichier dans document_numerise
--
