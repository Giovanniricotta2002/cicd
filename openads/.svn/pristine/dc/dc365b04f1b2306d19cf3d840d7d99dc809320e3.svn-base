-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.5.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.5.0') WHERE exists(SELECT 1 FROM om_version) = false;

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
-- BEGIN / [#9670] Amélioration du traitement de la recherche avancée sur les dossiers d'autorisation
--

CREATE INDEX IF NOT EXISTS dossier_autorisation_nl ON dossier_autorisation (dossier_autorisation NULLS LAST);
CREATE INDEX IF NOT EXISTS dossier_autorisation_etat_idx ON dossier_autorisation USING hash (etat_dossier_autorisation);
CREATE INDEX IF NOT EXISTS dossier_autorisation_dad_etat_idx ON dossier_autorisation (dossier_autorisation_type_detaille,etat_dossier_autorisation);
CREATE INDEX IF NOT EXISTS lien_dossier_autorisation_demandeur_demandeur_idx ON lien_dossier_autorisation_demandeur USING hash (demandeur);
CREATE INDEX IF NOT EXISTS lien_dossier_autorisation_demandeur_dossier_autorisation_idx ON lien_dossier_autorisation_demandeur USING hash (dossier_autorisation);
CREATE INDEX IF NOT EXISTS lien_dossier_autorisation_demandeur_petitionnaire_principal_idx ON lien_dossier_autorisation_demandeur (dossier_autorisation,demandeur) WHERE petitionnaire_principal IS TRUE;
CREATE INDEX IF NOT EXISTS demandeur_type_idx ON demandeur USING hash (LOWER(type_demandeur));

--
-- END / [#9670] Amélioration du traitement de la recherche avancée sur les dossiers d'autorisation
--

--
-- BEGIN / [#9680] Ajout de permission pour le widget des derniers dossiers déposés
--

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'derniers_dossiers_deposes_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'derniers_dossiers_deposes_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'derniers_dossiers_deposes_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'derniers_dossiers_deposes_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'derniers_dossiers_deposes_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'derniers_dossiers_deposes_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'derniers_dossiers_deposes_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'derniers_dossiers_deposes_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

--
-- END / [#9680] Ajout de permission pour le widget des derniers dossiers déposés
--

--
-- BEGIN /[#9717] Ajout des permissions manquantes
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
SELECT om_droit FROM om_droit WHERE libelle = 'document_travail' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossiers_pre_instruction_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
SELECT om_droit FROM om_droit WHERE libelle = 'document_pre_instruction' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossiers_pre_instruction_tab', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
SELECT om_droit FROM om_droit WHERE libelle = 'document_pre_instruction_tab' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

--
-- END /[#9717] Ajout des permissions manquantes
--

-- BEGIN / [#9715] Augmenter le libellé et le code du service consulté
--

ALTER TABLE service
    ALTER COLUMN abrege TYPE character varying(30),
    ALTER COLUMN libelle TYPE character varying(255);


-- END / [#9715] Augmenter le libellé et le code du service consulté
--

--
-- BEGIN / [#9718] Modifier la traduction d'une donnée technique
--

COMMENT ON COLUMN donnees_techniques.ope_proj_div_contr IS 'Division dans une commune qui a institué le contrôle des divisions dans le cadre de l’article L.115-3 du code de l’urbanisme.';
COMMENT ON COLUMN cerfa.ope_proj_div_contr IS 'Division dans une commune qui a institué le contrôle des divisions dans le cadre de l’article L.115-3 du code de l’urbanisme.';

--
-- END / [#9718] Modifier la traduction d'une donnée technique
--
