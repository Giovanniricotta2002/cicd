-- MàJ de la version en BDD
UPDATE om_version SET om_version = '4.12.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('4.12.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9239] Droit insuffisant lors de l'impression du registre d'affichage réglementaire
--

-- ajout des permission de:
--   * generer l'edition de l'affichage reglementaire
-- profils autorisés: admin, admingen, qualificateur, guichet et suivi, instrpoly, et instrpolycom

-- liste des profils à autoriser
CREATE TEMP TABLE tmp_profils (id INTEGER NOT NULL, libelle CHARACTER VARYING(100) NOT NULL);
INSERT INTO tmp_profils(id, libelle)
SELECT om_profil, libelle FROM om_profil WHERE libelle IN (
'ADMINISTRATEUR FONCTIONNEL',
'ADMINISTRATEUR GENERAL',
'QUALIFICATEUR',
'GUICHET UNIQUE',
'GUICHET ET SUIVI',
'INSTRUCTEUR POLYVALENT',
'INSTRUCTEUR POLYVALENT COMMUNE'
);

-- obligatoire pour pouvoir utiliser une boucle
DO
$do$

-- variables de boucles
DECLARE
    p tmp_profils%rowtype;
BEGIN
-- pour chaque profil
FOR p IN (SELECT * FROM tmp_profils)
LOOP
    -- on insère la permission pour ce profil (si elle n'existe pas déjà)
    INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'demande_generate_affichage_reglementaire_registre_consulter', p.id
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'demande_generate_affichage_reglementaire_registre_consulter' AND om_profil = p.id
    );
END LOOP;
END;
$do$
;

-- suppression des tables temporaires
DROP TABLE tmp_profils;

-- ajout des permission generales pour l'administrateur technique et fonctionnel
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'demande_generate_affichage_reglementaire_registre', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'demande_generate_affichage_reglementaire_registre' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#9239] Droit insuffisant lors de l'impression du registre d'affichage réglementaire
--

--
-- BEGIN / [#9238] Historisation des fichiers générés pour l'exort SITADEL
--

-- Création de la table storage
CREATE TABLE storage (
    storage integer NOT NULL,
    creation_date date NOT NULL,
    creation_time time without time zone NOT NULL,
    uid character varying(64) NOT NULL,
    filename character varying(256) NOT NULL,
    size integer NOT NULL,
    mimetype character varying(256) NOT NULL,
    type character varying(256) NOT NULL,
    info text,
    om_collectivite integer NOT NULL
);
COMMENT ON COLUMN storage.storage IS 'Identifiant numérique unique';
COMMENT ON COLUMN storage.creation_date IS 'Date de création du fichier';
COMMENT ON COLUMN storage.creation_time IS 'Heure de création du fichier';
COMMENT ON COLUMN storage.uid IS 'Identifiant dans le backend de storage du fichier';
COMMENT ON COLUMN storage.filename IS 'Nom du fichier';
COMMENT ON COLUMN storage.size IS 'Taille du fichier';
COMMENT ON COLUMN storage.mimetype IS 'Mimetype du fichier';
COMMENT ON COLUMN storage.type IS 'Type du fichier (sitadel, etc.)';
COMMENT ON COLUMN storage.info IS 'Informations complémentaires (JSON)';
COMMENT ON COLUMN storage.om_collectivite IS 'Collectivité du fichier';

-- Création de la séquence
CREATE SEQUENCE storage_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER SEQUENCE storage_seq OWNED BY storage.storage;

-- Création de la contrainte de clé primaire
ALTER TABLE ONLY storage
    ADD CONSTRAINT storage_pkey PRIMARY KEY (storage);
-- Création de la contrainte de liaison avec om_collectivite
ALTER TABLE ONLY storage
    ADD CONSTRAINT storage_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);

-- Ajout des permission de:
--   * afficher le tableau du storage
--   * télécharger les fichiers du storage
-- profils autorisés: admin tech et fonct, admingen, qualificateur, guichet,
-- guichet et suivi, instrpoly, instrpolycom et cellule suivi

-- liste des profils à autoriser
CREATE TEMP TABLE tmp_profils (id INTEGER NOT NULL, libelle CHARACTER VARYING(100) NOT NULL);
INSERT INTO tmp_profils(id, libelle)
SELECT om_profil, libelle FROM om_profil WHERE libelle IN (
    'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL',
    'ADMINISTRATEUR GENERAL',
    'QUALIFICATEUR',
    'GUICHET UNIQUE',
    'GUICHET ET SUIVI',
    'INSTRUCTEUR POLYVALENT',
    'INSTRUCTEUR POLYVALENT COMMUNE',
    'CELLULE SUIVI'
);

-- obligatoire pour pouvoir utiliser une boucle
DO
$do$

-- variables de boucles
DECLARE
    p tmp_profils%rowtype;
BEGIN
-- pour chaque profil
FOR p IN (SELECT * FROM tmp_profils)
LOOP
    -- on insère la permission pour ce profil (si elle n'existe pas déjà)
    INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'storage_tab', p.id
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'storage_tab' AND om_profil = p.id
    );
    -- on insère la permission pour ce profil (si elle n'existe pas déjà)
    INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), 'storage_uid_telecharger', p.id
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = 'storage_uid_telecharger' AND om_profil = p.id
    );
END LOOP;
END;
$do$
;

-- suppression des tables temporaires
DROP TABLE tmp_profils;

-- ajout de la permission de consultation du storage pour l'administrateur
-- technique et fonctionnel
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'storage_consulter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'storage_consulter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#9238] Historisation des fichiers générés pour l'exort SITADEL
--

--
-- BEGIN / [#9260] Ajout de la date d'affiche de l'avis de dépôt sur le dossier d'instruction
--

-- ajout champ 'dossier.date_affichage'
ALTER TABLE dossier ADD COLUMN date_affichage DATE NULL;
COMMENT ON COLUMN dossier.date_affichage IS 'Date d''affichage de l''avis de dépôt';

-- ajout champ 'action.regle_date_affichage'
ALTER TABLE action ADD COLUMN regle_date_affichage VARCHAR(30) NULL;
COMMENT ON COLUMN action.regle_date_affichage IS 'Règle de calcul de la date d''affichage de l''avis de dépôt du dossier d''instruction';

-- ajout champ 'instruction.archive_date_affichage'
ALTER TABLE instruction ADD COLUMN archive_date_affichage DATE NULL;
COMMENT ON COLUMN instruction.archive_date_affichage IS 'Valeur du champ date_affichage du dossier d''instruction avant ajout de l''événement d''instruction';

-- ajout des permission de:
--   * modifier la date d'affichage manuellement
--   * accéder à l'édition de l'instruction d'affichage obligatoire
-- profils autorisés: admin, admingen, qualificateur, guichet et suivi, instrpoly, et instrpolycom

-- liste des profils à autoriser
CREATE TEMP TABLE tmp_profils (id INTEGER NOT NULL, libelle CHARACTER VARYING(100) NOT NULL);
INSERT INTO tmp_profils(id, libelle)
SELECT om_profil, libelle FROM om_profil WHERE libelle IN (
'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL',
'ADMINISTRATEUR GENERAL',
'QUALIFICATEUR',
'GUICHET ET SUIVI',
'INSTRUCTEUR POLYVALENT',
'INSTRUCTEUR POLYVALENT COMMUNE'
);
-- liste des permissions à accorder
CREATE TEMP TABLE tmp_perms (perm CHARACTER VARYING(100) NOT NULL);
INSERT INTO tmp_perms(perm) VALUES ('dossier_instruction_modifier_date_affichage');
INSERT INTO tmp_perms(perm)
SELECT CONCAT('dossier_instruction_', surcharge_dossier, '_modifier_date_affichage')
FROM (VALUES ('tous_encours'),('mes_clotures'),('tous_clotures'),('mes_encours')) a(surcharge_dossier);
INSERT INTO tmp_perms(perm) VALUES ('dossier_instruction_acceder_attest_date_affi');
INSERT INTO tmp_perms(perm)
SELECT CONCAT('dossier_instruction_', surcharge_dossier, '_acceder_attest_date_affi')
FROM (VALUES ('tous_encours'),('mes_clotures'),('tous_clotures'),('mes_encours')) a(surcharge_dossier);

-- obligatoire pour pouvoir utiliser une boucle
DO
$do$

-- variables de boules
DECLARE
p tmp_profils%rowtype;
a tmp_perms%rowtype;
BEGIN
-- pour chaque profil
FOR p IN (SELECT * FROM tmp_profils)
LOOP
    -- pour chaque permissions à ajouter
    FOR a IN (SELECT * FROM tmp_perms)
    LOOP
    -- on insère la permission pour ce profil (si elle n'existe pas déjà)
    INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), a.perm, p.id
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = a.perm AND om_profil = p.id
    );
    END LOOP;
END LOOP;
END;
$do$
;

-- suppression des tables temporaires
DROP TABLE tmp_profils;
DROP TABLE tmp_perms;

-- mise à jour des champs de fusions (om_requete)
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, '(-- *Dates importantes du dossier d''instruction)', E'\\1\rto_char(dossier.date_affichage, ''DD/MM/YYYY'') as date_affichage,')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('dossier.date_affichage' IN omr.requete) = 0
  AND substring(omr.requete FROM '-- *Dates importantes du dossier d''instruction') IS NOT NULL;

UPDATE om_requete AS omr SET merge_fields = (
   SELECT regexp_replace(r.merge_fields, '(-- *Dates importantes du dossier d''instruction)', E'\\1\r[date_affichage]')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('[date_affichage]' IN omr.merge_fields) = 0
  AND substring(omr.merge_fields FROM '-- *Dates importantes du dossier d''instruction') IS NOT NULL;

--
-- END / [#9260] Ajout de la date d'affiche de l'avis de dépôt sur le dossier d'instruction
--


--
-- BEGIN /  [#9275] - Créer un nouveau widget "Alerte délai pré-instruction" 
--
CREATE TEMP TABLE tmp_profils (id INTEGER NOT NULL, libelle CHARACTER VARYING(100) NOT NULL);
INSERT INTO tmp_profils(id, libelle)
SELECT om_profil, libelle FROM om_profil WHERE libelle IN (
'ADMINISTRATEUR GÉNÉRAL',
'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL',
'CHEF DE SERVICE DIVISIONNAIRE',
'INSTRUCTEUR',
'INSTRUCTEUR POLYVALENT',
'INSTRUCTEUR POLYVALENT COMMUNE',
'INSTRUCTEUR SERVICE',
'QUALIFICATEUR',
'ASSISTANTE',
'CHEF DE SERVICE',
'RESPONSABLE DIVISION INFRACTION',
'JURISTE',
'TECHNICIEN',
'DIRECTION CONSULTATION',
'DIRECTION INFRACTION',
'DIRECTION RECOURS'
);

CREATE TEMP TABLE tmp_perms (perm CHARACTER VARYING(100) NOT NULL);
INSERT INTO tmp_perms(perm) VALUES ('dossiers_pre_instruction_consulter');
INSERT INTO tmp_perms(perm) VALUES ('dossiers_pre_instruction_tab');

-- obligatoire pour pouvoir utiliser une boucle
DO
$do$

-- variables de boules
DECLARE
p tmp_profils%rowtype;
a tmp_perms%rowtype;
BEGIN
-- pour chaque profil
FOR p IN (SELECT * FROM tmp_profils)
LOOP
    -- pour chaque permissions à ajouter
    FOR a IN (SELECT * FROM tmp_perms)
    LOOP
    -- on insère la permission pour ce profil (si elle n'existe pas déjà)
    INSERT INTO om_droit (om_droit, libelle, om_profil)
    SELECT nextval('om_droit_seq'), a.perm, p.id
    WHERE NOT EXISTS (
        SELECT om_droit FROM om_droit WHERE libelle = a.perm AND om_profil = p.id
    );
    END LOOP;
END LOOP;
END;
$do$
;

-- suppression des tables temporaires
DROP TABLE tmp_profils;
DROP TABLE tmp_perms;

-- Permission complète pour l'administrateur
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossiers_pre_instruction',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossiers_pre_instruction' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Suppression du widget "Dossiers à qualifier"
DELETE FROM om_dashboard WHERE om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT') AND om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers à qualifier');
DELETE FROM om_dashboard WHERE om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE') AND om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers à qualifier');

-- Ajout du widget sur les tableaux de bord des instr. polyvalent et des instr.
-- poly. commune
INSERT INTO om_widget (om_widget, libelle, texte, type, script)
SELECT nextval('om_widget_seq'), 'Dossiers à qualifier (limite de la notification du délai)','','file', 'dossiers_pre_instruction'
WHERE
    NOT EXISTS (
        SELECT libelle FROM om_widget WHERE libelle = 'Dossiers à qualifier (limite de la notification du délai)'
    );
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'), 'C2',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers à qualifier (limite de la notification du délai)')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers à qualifier (limite de la notification du délai)') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
    );

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, position, om_widget)
SELECT nextval('om_dashboard_seq'),(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'), 'C2',   2,  (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers à qualifier (limite de la notification du délai)')
WHERE
    NOT EXISTS (
        SELECT om_dashboard FROM om_dashboard WHERE om_widget = (SELECT om_widget FROM om_widget WHERE libelle = 'Dossiers à qualifier (limite de la notification du délai)') AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
    );

--
-- END /  [#9275] - Créer un nouveau widget "Alerte délai pré-instruction" 
--


--
-- BEGIN / [#9274] Problème de permission sur la de suppression d'un dossier avec un administrateur général ayant un instructeur lié 
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_mes_encours_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_tous_encours_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_mes_clotures_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_instruction_tous_clotures_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_infractions_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_infractions_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_toutes_infractions_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_toutes_infractions_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_mes_recours_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_mes_recours_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'),'dossier_contentieux_tous_recours_suppression_division_bypass',(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE
NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_contentieux_tous_recours_suppression_division_bypass' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

--
-- END / [#9274] Problème de permission sur la de suppression d'un dossier avec un administrateur général ayant un instructeur lié 
--

--
-- BEGIN / [#9276] Ajout d'une permission pour continuer le suivi des dates depuis l'instruction sur un dossier clôturé
--

-- Ajout de la permission à l'instructeur polyvalent
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modification_dates_cloture', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modification_dates_cloture' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

-- Ajout de la permission à l'instructeur polyvalenbt commune
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modification_dates_cloture', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modification_dates_cloture' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

--
-- END / [#9276] Ajout d'une permission pour continuer le suivi des dates depuis l'instruction sur un dossier clôturé
--

--
-- BEGIN / [#9248] Modification de libellés dans l'application
--

-- Modification du libellé du widget *dossiers_evenement_incomplet_majoration*
UPDATE om_widget SET libelle = 'Dossiers incomplets ou majorés sans date de notification' WHERE libelle = 'Dossiers événement incomplet ou majoration sans RAR';

--
-- END / [#9248] Modification de libellés dans l'application
--
