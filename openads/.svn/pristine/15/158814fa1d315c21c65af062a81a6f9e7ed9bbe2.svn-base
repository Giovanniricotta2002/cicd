-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.8.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.8.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9062] Constitution d'un dossier final
--

--Droits pour : ADMINISTRATEURS, INSTRUCTEURS
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    );

--FLAG *dossier_final* pour les fichiers
ALTER TABLE instruction ADD COLUMN om_fichier_instruction_dossier_final boolean DEFAULT false;
COMMENT ON COLUMN instruction.om_fichier_instruction_dossier_final IS 'Identifie que le document constitue dossier final';
ALTER TABLE consultation ADD COLUMN om_fichier_consultation_dossier_final boolean DEFAULT false;
COMMENT ON COLUMN consultation.om_fichier_consultation_dossier_final IS 'Identifie que le document généré constitue dossier final';
ALTER TABLE consultation ADD COLUMN fichier_dossier_final boolean DEFAULT false;
COMMENT ON COLUMN consultation.fichier_dossier_final IS 'Identifie que le document en pièce jointe constitue dossier final';
ALTER TABLE rapport_instruction ADD COLUMN om_fichier_rapport_instruction_dossier_final boolean DEFAULT false;
COMMENT ON COLUMN rapport_instruction.om_fichier_rapport_instruction_dossier_final IS 'Identifie que le document constitue dossier final';
ALTER TABLE document_numerise ADD COLUMN uid_dossier_final boolean DEFAULT false;
COMMENT ON COLUMN document_numerise.uid_dossier_final IS 'Identifie que le document constitue dossier final';

-- Ajoute le pramètre "id_avis_consultation_tacite" à "-1" par défaut
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite)
SELECT nextval('om_parametre_seq'), 'id_avis_consultation_tacite', '-1', (SELECT om_collectivite FROM om_collectivite WHERE niveau = '2' OR om_collectivite = 1)
WHERE NOT EXISTS (
    SELECT om_parametre FROM om_parametre WHERE libelle = 'id_avis_consultation_tacite'
);

--
-- END / [#9062] Constitution d'un dossier final
--

--
-- BEGIN / [#9059] Droit d'ajouter un message manuel
--

--ADMINISTRATEURS ET DIVISIONNAIRE
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_contexte_ctx_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_contexte_ctx_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_contexte_ctx_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    );

--
-- END / [#9059] Droit d'ajouter un message manuel
--

--
-- BEGIN / [#9058] Widget des derniers dossiers déposés et listing associé
--

--DROIT: ADMINISTRATEURS ET DIVISIONNAIRE
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'derniers_dossiers_deposes', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'derniers_dossiers_deposes' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'derniers_dossiers_deposes', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'derniers_dossiers_deposes' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'derniers_dossiers_deposes', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'derniers_dossiers_deposes' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    );

--CREATION DU WIDGET
INSERT INTO om_widget (om_widget, libelle, lien, texte, script, type)
SELECT nextval('om_widget_seq'), 'Les derniers dossiers déposés', '', '', 'derniers_dossiers_deposes','file'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Les derniers dossiers déposés'
    );

--AJOUT SUR TABLEAU DE BORD DIVISIONNAIRE
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'), (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'), 'C2', 2, (SELECT om_widget FROM om_widget WHERE libelle = 'Les derniers dossiers déposés')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Les derniers dossiers déposés') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
    );
--
-- END / [#9058] Widget des derniers dossiers déposés et listing associé
--

--
-- BEGIN / [#9057] Indicateur d’un dépôt électronique et de la présence d’une parcelle temporaire
--

--Depot electronique
ALTER TABLE demande ADD COLUMN depot_electronique boolean NOT NULL DEFAULT false;
COMMENT ON COLUMN demande.depot_electronique IS 'Identifie le dépôt électronique de la demande';

ALTER TABLE dossier ADD COLUMN depot_electronique boolean NOT NULL DEFAULT false;
COMMENT ON COLUMN dossier.depot_electronique IS 'Identifie le dépôt électronique du dossier d''instruction';

--Parcelle temporaire
ALTER TABLE demande ADD COLUMN parcelle_temporaire boolean NOT NULL DEFAULT false;
COMMENT ON COLUMN demande.parcelle_temporaire IS 'Existence d''au moins une parcelle temporaire sur la demande';

ALTER TABLE dossier ADD COLUMN parcelle_temporaire boolean NOT NULL DEFAULT false;
COMMENT ON COLUMN dossier.parcelle_temporaire IS 'Existence d''au moins une parcelle temporaire sur le dossier d''instruction';

--
-- END / [#9057] Indicateur d’un dépôt électronique et de la présence d’une parcelle temporaire
--

--
-- BEGIN / [#9056] Ajouter le paramètre de régénération automatique de la clé citoyen pour un type de demande
--

ALTER TABLE demande_type ADD COLUMN regeneration_cle_citoyen boolean DEFAULT false;
COMMENT ON COLUMN demande_type.regeneration_cle_citoyen IS 'La clé d''accès au portail citoyen du dossier d''autorisation doit être regénérée lors de la création du dossier d''instruction';

--
-- END / [#9056] Ajouter le paramètre de régénération automatique de la clé citoyen pour un type de demande
--
