-- MàJ de la version en BDD
UPDATE om_version SET om_version = '6.1.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('6.1.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#10261]- Correction de l'accès au journal d'instruction depuis un DI via les menus 'Tous les encours', 'Mes clôturés', 'Tous les clôturés' 
--

-- Donne la permission aux utilisateurs ADMINISTRATEUR GENERAL, ADMINISTRATEUR FONCTIONNEL, ADMINISTRATEUR TECHNIQUE et ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL de voir le lien du portlet "Journal d'instruction" depuis le menu tous les encours

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Donne la permission aux utilisateurs ADMINISTRATEUR GENERAL, ADMINISTRATEUR FONCTIONNEL, ADMINISTRATEUR TECHNIQUE et ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL de voir le lien du portlet "Journal d'instruction" depuis le menu mes clotures

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Donne la permission aux utilisateurs ADMINISTRATEUR GENERAL, ADMINISTRATEUR FONCTIONNEL, ADMINISTRATEUR TECHNIQUE et ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL de voir le lien du portlet "Journal d'instruction" depuis le menu tous les clotures

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_log_instructions', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_log_instructions' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#10261]- Correction de l'accès au journal d'instruction depuis un DI via les menus 'Tous les encours', 'Mes clôturés', 'Tous les clôturés' 
--
