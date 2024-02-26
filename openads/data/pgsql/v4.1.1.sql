-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.1.1' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.1.1') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- START — [#8840] Dysfonctionnement sur les profils existants et contentieux
--

--
-- Profil Qualificateur
--

-- Données techniques
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'donnees_techniques_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

-- Rapport d'instruction
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_finaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_definaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

-- Contraintes
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contrainte_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contrainte_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

-- Instructions
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_finaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_definaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

-- Consultations
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_modifier_lu_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_modifier_lu_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

-- Commissions
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

-- Lot
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lot_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lot_editer_donnees_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_editer_donnees_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lot_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lot_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

-- Messages
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_modifier_lu_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_modifier_lu_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

-- Bloc-note
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'blocnote_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'blocnote_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'blocnote_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

-- Dossiers liés
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lien_dossier_dossier_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

--
-- Profil chef de service
--

-- Rapport d'instruction
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_finaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_definaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'rapport_instruction_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'rapport_instruction_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

-- Contraintes
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contrainte_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contrainte_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_contrainte_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contrainte_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

-- Instructions
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );


INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_supprimer_bypass_division', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_supprimer_bypass_division' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_finaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_definaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'instruction_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

-- Consultations
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_supprimer', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_supprimer' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_finaliser', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_finaliser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_finaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_finaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_definaliser', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_definaliser' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_definaliser_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_definaliser_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_modifier_lu_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_modifier_lu_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

-- Commissions
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

-- Lot
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lot_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lot_editer_donnees_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_editer_donnees_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lot_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lot_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lot_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

-- Messages
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_message_modifier_lu_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_message_modifier_lu_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

-- Bloc-note
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'blocnote_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'blocnote_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'blocnote_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

-- Dossiers liés
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lien_dossier_dossier_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'lien_dossier_dossier_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );


--
-- Profil cellule suivi
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'donnees_techniques_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'donnees_techniques_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

-- Consultations
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_modifier_lu_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_modifier_lu_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

-- Commissions
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

-- Bloc-note
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'blocnote_ajouter_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_ajouter_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'blocnote_modifier_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_modifier_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'blocnote_supprimer_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'blocnote_supprimer_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

--
-- Profil service consulté interne
--

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND om_droit.libelle = 'dossier_instruction_geolocalisation_consulter'
    AND om_profil.libelle = 'SERVICE CONSULTÉ INTERNE';

--
-- Profils direction consultation, direction recours et direction infraction
--

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND (om_droit.libelle = 'dossier_contentieux_tous_recours_geolocalisation_consulter'
        OR om_droit.libelle = 'dossier_contentieux_toutes_infractions_geolocalisation_consulter')
    AND (om_profil.libelle = 'DIRECTION CONSULTATION'
        OR om_profil.libelle = 'DIRECTION RECOURS'
        OR om_profil.libelle = 'DIRECTION INFRACTION');

--
-- Profils assistante, chef de service, juriste, technicien, reponsable division
-- infraction
--

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND om_droit.libelle = 'dossier_instruction_geolocalisation_consulter'
    AND (om_profil.libelle = 'ASSISTANTE'
        OR om_profil.libelle = 'CHEF DE SERVICE CONTENTIEUX'
        OR om_profil.libelle = 'JURISTE'
        OR om_profil.libelle = 'TECHNICIEN'
        OR om_profil.libelle = 'RESPONSABLE DIVISION INFRACTION');

--
-- END — [#8840] Dysfonctionnement sur les profils existants et contentieux
--