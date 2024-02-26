-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.3.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.3.0') WHERE exists(SELECT 1 FROM om_version) = false;

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
-- BEGIN / [#9651] Gestion des prescriptions archéologiques
--

-- Ajout du champ *prescription* dans la table *avis_decision*
ALTER TABLE ONLY avis_decision
    ADD COLUMN prescription boolean DEFAULT FALSE;
COMMENT ON COLUMN avis_decision.prescription IS 'Identifie si l''avis de décision concerne une prescription archéologique';

--
-- END / [#9651] Gestion des prescriptions archéologiques
--

--
-- BEGIN / [#9649] Notification des pétitionnaires du dossier depuis les instructions (seconde partie)
--

-- Ajout du champ *courriel* dans la table *instruction_notification*
ALTER TABLE ONLY instruction_notification
    ADD COLUMN courriel character varying(60);
COMMENT ON COLUMN instruction_notification.courriel IS 'Courriel du destinataire utilisé pour lui transmettre les informations';

-- Par défaut on ajoute les paramètres courriel type pour la notification des pétitionnaire
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite)
SELECT nextval('om_parametre_seq'), 'parametre_courriel_type_titre', '[openADS] Notification concernant votre dossier [DOSSIER]', (SELECT om_collectivite FROM om_collectivite WHERE niveau = '2' OR (niveau = '1' AND om_collectivite = 1))
WHERE NOT EXISTS (
    SELECT om_parametre FROM om_parametre WHERE libelle = 'parametre_courriel_type_titre' AND om_collectivite = (SELECT om_collectivite FROM om_collectivite WHERE niveau = '2' OR (niveau = '1' AND om_collectivite = 1))
);
--
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite)
SELECT nextval('om_parametre_seq'), 'parametre_courriel_type_message', 'Bonjour, veuillez prendre connaissance du(des) document(s) suivant(s) :\n [LIEN_TELECHARGEMENT_DOCUMENT]\n[LIEN_TELECHARGEMENT_ANNEXE]', (SELECT om_collectivite FROM om_collectivite WHERE niveau = '2' OR (niveau = '1' AND om_collectivite = 1))
WHERE NOT EXISTS (
    SELECT om_parametre FROM om_parametre WHERE libelle = 'parametre_courriel_type_message' AND om_collectivite = (SELECT om_collectivite FROM om_collectivite WHERE niveau = '2' OR (niveau = '1' AND om_collectivite = 1))
);

--
-- END / [#9649] Notification des pétitionnaires du dossier depuis les instructions (seconde partie)
--