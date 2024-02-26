-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.19.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.19.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#10210] Téléchargement des pièces d'un DI
--

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'VISUALISATION DA et DI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_instruction',
(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_instruction'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_travail',
(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_travail'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_dossier_final',
(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ DI')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ DI')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_telechargement',
(SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_telechargement'
    AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION')
);

DELETE FROM om_droit WHERE om_droit = (SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION CONSULTATION'));
DELETE FROM om_droit WHERE om_droit = (SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION RECOURS'));
DELETE FROM om_droit WHERE om_droit = (SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIRECTION INFRACTION'));
DELETE FROM om_droit WHERE om_droit = (SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ DI'));
DELETE FROM om_droit WHERE om_droit = (SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ INTERNE'));
DELETE FROM om_droit WHERE om_droit = (SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ ÉTENDU'));
DELETE FROM om_droit WHERE om_droit = (SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_dossier_final' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'SERVICE CONSULTÉ'));

--
-- END / [#10210] Téléchargement des pièces d'un DI
--
