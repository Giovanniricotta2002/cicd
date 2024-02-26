-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.7.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.7.0') WHERE exists(SELECT 1 FROM om_version) = false;

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
-- BEGIN / [#9645] - Flux contrôle de légalité
--

--
ALTER TABLE evenement ADD COLUMN envoi_cl_platau BOOLEAN DEFAULT false;
COMMENT ON COLUMN evenement.envoi_cl_platau IS 'L''envoi au contrôle de légalité se fait par Plat''AU, le suivi de la date d''envoi n''est plus possible manuellement';

--
ALTER TABLE instruction ADD COLUMN envoye_cl_platau BOOLEAN DEFAULT false;
COMMENT ON COLUMN instruction.envoye_cl_platau IS 'L''envoi au contrôle de légalité a été fait par Plat''AU, une task ''envoi_CL'' existe déjà';

--
-- END / [#9645] - Flux contrôle de légalité
--

--
-- BEGIN / [#9749] - Ajouter une description pour les signataires arrêté
--

ALTER TABLE signataire_arrete
ADD COLUMN description CHARACTER VARYING(255) NULL;
COMMENT ON COLUMN signataire_arrete.description IS 'Description du signataire';

--
-- END / [#9749] - Ajouter une description pour les signataires arrêté
--

--
-- BEGIN / [#9753] - Ajout de nouveaux filtres pour le widget de suivi d'instruction paramétrable
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'suivi_instruction_parametrable_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'suivi_instruction_parametrable_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);

--
-- END / [#9753] - Ajout de nouveaux filtres pour le widget de suivi d'instruction paramétrable
--

--
-- BEGIN / [#9760] Identification des dossiers d'instruction par couleur
--

-- Ajout du champ *couleur* dans la table *dossier_autorisation_type_detaille*
ALTER TABLE dossier_autorisation_type_detaille ADD COLUMN couleur CHARACTER VARYING(6) NULL;
COMMENT ON COLUMN dossier_autorisation_type_detaille.couleur IS 'Code hexadécimal de la couleur du type de dossier d''autorisation détaillé';

--
-- END / [#9760] Identification des dossiers d'instruction par couleur
--

