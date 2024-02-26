-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.18.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.18.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#10171] - La création d'un DI ayant un type dont le code a plus de 10 caractères échoue
--

-- Adapatation du nombre de caractères de dossier.numerotation_suffixe
ALTER TABLE dossier ALTER COLUMN numerotation_suffixe TYPE character varying(20);

--
-- END / [#10171] - La création d'un DI ayant un type dont le code a plus de 10 caractères échoue
--

--
-- BEGIN / [#10167] - Ajout d'un nouveau type de sous-dossier DI permettant de déclencher la création d’un DA
--

UPDATE
    dossier_instruction_type
SET
    dossier_autorisation_type_detaille = NULL
WHERE
    sous_dossier IS TRUE;

--
-- END / [#10167] - Ajout d'un nouveau type de sous-dossier DI permettant de déclencher la création d’un DA
--

--
-- BEGIN / [VDM0026227][#10173] - Ajouter la permission pour consulter le document PeC sur les consultations
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ DI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ DI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_fichier_pec_telecharger',
(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'consultation_fichier_pec_telecharger'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
);

--
-- END / [VDM0026227][#10173] - Ajouter la permission pour consulter le document PeC sur les consultations
--

--
-- BEGIN / [#10196] - Restreindre l’accès aux pièces sur le DA si le DI n’est pas clôturé (secret de l’instruction)
--

ALTER TABLE ONLY dossier_autorisation_type_detaille
    ADD COLUMN IF NOT EXISTS secret_instruction BOOLEAN DEFAULT false;

COMMENT ON COLUMN dossier_autorisation_type_detaille.secret_instruction IS
    'Restreint l''accès aux pièces du DA si le DI est toujours en cours d''instruction.';

--
-- END / [#10196] - Restreindre l’accès aux pièces sur le DA si le DI n’est pas clôturé (secret de l’instruction)
--

--
-- BEGIN / [#10195] Optimisation de l'ajout automatique des acteurs lors de la création d'un dossier
--

--
CREATE INDEX IF NOT EXISTS lien_categorie_tiers_consulte_om_collectivite_categorie_tiers_consulte ON lien_categorie_tiers_consulte_om_collectivite (categorie_tiers_consulte);
--
CREATE INDEX IF NOT EXISTS lien_dossier_instruction_type_categorie_tiers_dossier_instruction_type ON lien_dossier_instruction_type_categorie_tiers (dossier_instruction_type);
CREATE INDEX IF NOT EXISTS lien_dossier_instruction_type_categorie_tiers_categorie_tiers ON lien_dossier_instruction_type_categorie_tiers (categorie_tiers);
--
CREATE INDEX IF NOT EXISTS lien_habilitation_tiers_consulte_departement_habilitation_tiers_consulte ON lien_habilitation_tiers_consulte_departement (habilitation_tiers_consulte);
CREATE INDEX IF NOT EXISTS lien_habilitation_tiers_consulte_departement_departement ON lien_habilitation_tiers_consulte_departement (departement);

CREATE INDEX IF NOT EXISTS lien_habilitation_tiers_consulte_commune_habilitation_tiers_consulte ON lien_habilitation_tiers_consulte_commune (habilitation_tiers_consulte);
CREATE INDEX IF NOT EXISTS lien_habilitation_tiers_consulte_commune_commune ON lien_habilitation_tiers_consulte_commune (commune);
--
CREATE INDEX IF NOT EXISTS habilitation_tiers_consulte_type_habilitation_tiers_consulte ON habilitation_tiers_consulte (type_habilitation_tiers_consulte);
CREATE INDEX IF NOT EXISTS habilitation_tiers_consulte_tiers_consulte ON habilitation_tiers_consulte (tiers_consulte);
--
CREATE INDEX IF NOT EXISTS lien_dossier_tiers_dossier ON lien_dossier_tiers (dossier);
CREATE INDEX IF NOT EXISTS lien_dossier_tiers_tiers ON lien_dossier_tiers (tiers);
--
CREATE INDEX IF NOT EXISTS lien_habilitation_tiers_consulte_specialite_tiers_consulte_habilitation_tiers_consulte ON lien_habilitation_tiers_consulte_specialite_tiers_consulte (habilitation_tiers_consulte);
CREATE INDEX IF NOT EXISTS lien_habilitation_tiers_consulte_specialite_tiers_consulte_specialite_tiers_consulte ON lien_habilitation_tiers_consulte_specialite_tiers_consulte (specialite_tiers_consulte);
--
CREATE INDEX IF NOT EXISTS lien_motif_consultation_om_collectivite_motif_consultation ON lien_motif_consultation_om_collectivite (motif_consultation);
CREATE INDEX IF NOT EXISTS lien_motif_consultation_om_collectivite_om_collectivite ON lien_motif_consultation_om_collectivite (om_collectivite);
--
CREATE INDEX IF NOT EXISTS lien_om_utilisateur_tiers_consulte_om_utilisateur ON lien_om_utilisateur_tiers_consulte (om_utilisateur);
CREATE INDEX IF NOT EXISTS lien_om_utilisateur_tiers_consulte_tiers_consulte ON lien_om_utilisateur_tiers_consulte (tiers_consulte);
--
CREATE INDEX IF NOT EXISTS motif_consultation_om_etat ON motif_consultation (om_etat);
--
CREATE INDEX IF NOT EXISTS tiers_consulte_categorie ON tiers_consulte (categorie_tiers_consulte);
--
CREATE INDEX IF NOT EXISTS lien_dossier_instruction_type_categorie_tiers_categorie_auto ON lien_dossier_instruction_type_categorie_tiers (categorie_tiers,ajout_automatique);

--
-- END / [#10195] Optimisation de l'ajout automatique des acteurs lors de la création d'un dossier
--

--
-- BEGIN / [#10206] Permettre la notification par mail des signataires d'un document envoyé en signature 
--

ALTER TABLE ONLY instruction
    ADD COLUMN IF NOT EXISTS parapheur_lien_page_signature VARCHAR(1000) DEFAULT NULL;
COMMENT ON COLUMN instruction.parapheur_lien_page_signature IS
    'Lien vers la page de signature du document lié à l''instruction';

--
-- END / [#10206] Permettre la notification par mail des signataires d'un document envoyé en signature 
--

--
-- BEGIN / [#10200] Restreindre la gestion des profils aux administrateurs technique et fonctionnel
--

-- Profil ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL plus haut niveau de hiérarchie
UPDATE
    om_profil
SET
    hierarchie = 99
WHERE
    om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL');

-- Profil ADMINISTRATEUR GENERAL juste en dessous du profil ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
UPDATE
    om_profil
SET
    hierarchie = 98
WHERE
    om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL');

--
-- END / [#10200] Restreindre la gestion des profils aux administrateurs technique et fonctionnel
--
