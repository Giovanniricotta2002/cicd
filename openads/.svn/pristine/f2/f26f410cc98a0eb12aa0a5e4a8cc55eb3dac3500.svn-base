-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.4.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.4.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#8907] Dysfonctionnements sur les profils existants
--

-- Commission - Marquer comme lu
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_modifier_lu_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_modifier_lu_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_modifier_lu_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_modifier_lu_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

-- Commission - Supprimer
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_supprimer_division_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_supprimer_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_commission_supprimer_division_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_commission_supprimer_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

DELETE FROM om_droit
    USING om_profil
WHERE om_droit.om_profil = om_profil.om_profil
    AND om_droit.libelle = 'dossier_commission_supprimer_bypass'
    AND (om_profil.libelle = 'QUALIFICATEUR'
        OR om_profil.libelle = 'CELLULE SUIVI');

-- Consultation - Afficher / masquer dans les éditions
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_visibilite_dans_edition_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CELLULE SUIVI')
    );

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_visibilite_dans_edition_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR')
    );
    
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_visibilite_dans_edition_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );
    
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_visibilite_dans_edition_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
    );
    
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_visibilite_dans_edition_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_visibilite_dans_edition_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'consultation_visibilite_dans_edition_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'consultation_visibilite_dans_edition_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
    );

--
-- END / [#8907] Dysfonctionnements sur les profils existants
--

--
-- BEGIN / [#8810] Changer la date de dépot d'un dossier non instruit pour un utilisateur avec les droits de correction 
--

-- Suppression d'un droit inutile
DELETE FROM om_droit
WHERE libelle LIKE '%_donnees_techniques_consulter_bypass';

-- Ajoute au chef de service la possibilité d'ajouter le rapport d'instruction
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_rapport_instruction_rediger_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_rapport_instruction_rediger_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_rapport_instruction_rediger_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_rapport_instruction_rediger_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_rapport_instruction_rediger_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_rapport_instruction_rediger_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_rapport_instruction_rediger_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_rapport_instruction_rediger_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_rapport_instruction_rediger_bypass', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
WHERE
    NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_rapport_instruction_rediger_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE')
    );

--
-- END / [#8810] Changer la date de dépot d'un dossier non instruit pour un utilisateur avec les droits de correction 
--
