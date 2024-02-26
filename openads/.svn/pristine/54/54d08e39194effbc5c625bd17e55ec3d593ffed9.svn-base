-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.4.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.4.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9658] Notification : adresse d'accès au fichers erronée
--

-- Modification du paramètre du corps du message pour utiliser des <br> à la place des \n
UPDATE
    om_parametre
SET
    valeur = 'Bonjour, veuillez prendre connaissance du(des) document(s) suivant(s) :<br> [LIEN_TELECHARGEMENT_DOCUMENT]<br>[LIEN_TELECHARGEMENT_ANNEXE]'
WHERE
    om_parametre.libelle = 'parametre_courriel_type_message'
    AND om_parametre.valeur = 'Bonjour, veuillez prendre connaissance du(des) document(s) suivant(s) :\n [LIEN_TELECHARGEMENT_DOCUMENT]\n[LIEN_TELECHARGEMENT_ANNEXE]';

--
-- END / [#9658] Notification : adresse d'accès au fichers erronée
--

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
-- BEGIN / [#9667] Gestion de la création des demandes par WS sur dossier d'instruction existant
--

--
UPDATE demande SET source_depot = 'app' WHERE source_depot IS NULL OR source_depot = '';

--
-- END /  [#9667] Gestion de la création des demandes par WS sur dossier d'instruction existant
--
