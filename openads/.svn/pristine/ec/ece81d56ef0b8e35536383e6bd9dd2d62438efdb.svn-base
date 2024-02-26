-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.0.0-rc4' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.0.0-rc4') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / #1099 — [#9403] Ajout d'un champ "Commune" en tant qu'attribut d'un dossier
--

-- nouvelle table 'commune'
CREATE TABLE commune (
    commune integer NOT NULL,
    typecom character varying(4) NULL,
    com character varying(5) NOT NULL,
    reg character varying(2) NOT NULL,
    dep character varying(3) NOT NULL,
    arr character varying(4) NULL,
    tncc character varying(1) NULL,
    ncc character varying(200) NULL,
    nccenr character varying(200) NULL,
    libelle character varying(45) NULL,
    can character varying(5) NULL,
    comparent character varying(5) NULL,
    om_validite_debut date,
    om_validite_fin date
);

ALTER TABLE ONLY commune
    ADD CONSTRAINT commune_pkey PRIMARY KEY (commune);

CREATE SEQUENCE commune_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN commune.commune IS 'Identifiant technique de la commune';
COMMENT ON COLUMN commune.typecom IS 'Type de commune';
COMMENT ON COLUMN commune.com IS 'Code INSEE de la commune';
COMMENT ON COLUMN commune.reg IS 'Code INSEE de la région';
COMMENT ON COLUMN commune.dep IS 'Code INSEE du département';
COMMENT ON COLUMN commune.arr IS 'Code d’arrondissement sur 3 caractères (métropole) ou 4';
COMMENT ON COLUMN commune.tncc IS 'Type de nom en clair';
COMMENT ON COLUMN commune.ncc IS 'Nom en clair (majuscules)';
COMMENT ON COLUMN commune.nccenr IS 'Nom en typographie riche';
COMMENT ON COLUMN commune.libelle IS 'Nom en typographie riche avec article';
COMMENT ON COLUMN commune.can IS 'Code canton. Pour les communes « multi-cantonales » code décliné de 99 à 90 (pseudo-canton) ou de 89 à 80 (communes nouvelles)';
COMMENT ON COLUMN commune.comparent IS 'Code de la commune parente pour les arrondissements municipaux et les communes associées ou déléguées.';
COMMENT ON COLUMN commune.om_validite_debut IS 'Date de validité (début)';
COMMENT ON COLUMN commune.om_validite_fin IS 'Date de validité (fin)';

ALTER TABLE dossier_autorisation ADD commune integer NULL;
ALTER TABLE ONLY dossier_autorisation
    ADD CONSTRAINT dossier_autorisation_commune FOREIGN KEY (commune) REFERENCES commune(commune);

COMMENT ON COLUMN dossier_autorisation.commune IS 'Commune associée au dossier';

ALTER TABLE dossier ADD commune integer NULL;
ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_commune FOREIGN KEY (commune) REFERENCES commune(commune);

COMMENT ON COLUMN dossier.commune IS 'Commune associée au dossier';

ALTER TABLE demande ADD commune integer NULL;
ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_commune FOREIGN KEY (commune) REFERENCES commune(commune);


COMMENT ON COLUMN demande.commune IS 'Commune associée à la demande';


-- nouvelle table 'region'
CREATE TABLE region (
    region integer NOT NULL,
    reg character varying(2) NOT NULL,
    cheflieu character varying(5) NOT NULL,
    tncc character varying(1) NULL,
    ncc character varying(200) NULL,
    nccenr character varying(200) NULL,
    libelle character varying(45) NULL,
    om_validite_debut date NOT NULL,
    om_validite_fin date
);

ALTER TABLE ONLY region
    ADD CONSTRAINT region_pkey PRIMARY KEY (region);

CREATE SEQUENCE region_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN region.region IS 'Identifiant technique de la region';
COMMENT ON COLUMN region.reg IS 'Code INSEE de la région';
COMMENT ON COLUMN region.cheflieu IS 'Code INSEE du chef lieu';
COMMENT ON COLUMN region.tncc IS 'Type de nom en clair';
COMMENT ON COLUMN region.ncc IS 'Nom en clair (majuscules)';
COMMENT ON COLUMN region.nccenr IS 'Nom en typographie riche';
COMMENT ON COLUMN region.libelle IS 'Nom en typographie riche avec article';
COMMENT ON COLUMN region.om_validite_debut IS 'Date de validité (début)';
COMMENT ON COLUMN region.om_validite_fin IS 'Date de validité (fin)';


-- nouvelle table 'departement'
CREATE TABLE departement (
    departement integer NOT NULL,
    dep character varying(3) NOT NULL,
    reg character varying(2) NOT NULL,
    cheflieu character varying(5) NOT NULL,
    tncc character varying(1) NULL,
    ncc character varying(200) NULL,
    nccenr character varying(200) NULL,
    libelle character varying(45) NULL,
    om_validite_debut date NOT NULL,
    om_validite_fin date
);

ALTER TABLE ONLY departement
    ADD CONSTRAINT departement_pkey PRIMARY KEY (departement);

CREATE SEQUENCE departement_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN departement.departement IS 'Identifiant technique de la departement';
COMMENT ON COLUMN departement.dep IS 'Code INSEE du département';
COMMENT ON COLUMN departement.reg IS 'Code INSEE de la région';
COMMENT ON COLUMN departement.cheflieu IS 'Code INSEE du chef lieu';
COMMENT ON COLUMN departement.tncc IS 'Type de nom en clair';
COMMENT ON COLUMN departement.ncc IS 'Nom en clair (majuscules)';
COMMENT ON COLUMN departement.nccenr IS 'Nom en typographie riche';
COMMENT ON COLUMN departement.libelle IS 'Nom en typographie riche avec article';
COMMENT ON COLUMN departement.om_validite_debut IS 'Date de validité (début)';
COMMENT ON COLUMN departement.om_validite_fin IS 'Date de validité (fin)';

ALTER TABLE affectation_automatique ADD communes character varying(2000) NULL;
COMMENT ON COLUMN affectation_automatique.communes IS 'Communes associées';

CREATE INDEX affectation_automatique_communes_idx ON affectation_automatique USING btree (communes);
CREATE INDEX affectation_automatique_communes_collectivite_idx ON affectation_automatique USING btree (communes, om_collectivite);

-- Ajout de la permission de manipuler les communes pour les profils
-- ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL et ADMINISTRATEUR GENERAL
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'commune', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'commune' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'commune', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'commune' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

-- Ajout de la permission de manipuler les départements pour les profils
-- ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL et ADMINISTRATEUR GENERAL
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'departement', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'departement' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'departement', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'departement' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

-- Ajout de la permission de manipuler les régions pour les profils
-- ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL et ADMINISTRATEUR GENERAL
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'region', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'region' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'region', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'region' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

-- Mise à jour de la requête instruction
UPDATE
    om_requete
SET
    requete = REPLACE(REPLACE(requete,'-- Données contentieux du dossier d''instruction','
    -- Localisation du dossier

    commune.com as commune_code,
    commune.libelle as commune_libelle,
    commune.dep as departement_code,
    departement.libelle as departement_libelle,
    commune.reg as region_code,
    region.libelle as region_libelle,

    -- Données contentieux du dossier d''instruction'
    ), 'WHERE instruction.instruction = &idx', '
LEFT JOIN
    &DB_PREFIXEcommune
    ON
        dossier.commune = commune.commune
LEFT JOIN LATERAL (
        SELECT
            dep, libelle
        FROM
            &DB_PREFIXEdepartement
        WHERE
            dep = commune.dep
            AND (
                om_validite_debut IS NULL
                OR om_validite_debut <= CURRENT_DATE
            )
        ORDER BY
            om_validite_fin DESC NULLS FIRST,
            om_validite_debut DESC NULLS FIRST
        LIMIT 1
    ) AS departement
    ON departement.dep = commune.dep
LEFT JOIN LATERAL (
        SELECT
            reg, libelle
        FROM
            &DB_PREFIXEregion
        WHERE
            reg = commune.reg
            AND (
                om_validite_debut IS NULL
                OR om_validite_debut <= CURRENT_DATE
            )
        ORDER BY
            om_validite_fin DESC NULLS FIRST,
            om_validite_debut DESC NULLS FIRST
        LIMIT 1
    ) AS region
    ON region.reg = region.reg

WHERE instruction.instruction = &idx'),

    merge_fields = REPLACE(merge_fields, '-- Données contentieux du dossier d''instruction',
'-- Localisation du dossier
[commune_code]
[commune_libelle]
[departement_code]
[departement_libelle]
[region_code]
[region_libelle]

-- Données contentieux du dossier d''instruction')

WHERE
    code = 'instruction'
    AND libelle = 'Récapitulatif du dossier d''instruction / instruction';

--
-- END / #1099 — [#9403] Ajout d'un champ "Commune" en tant qu'attribut d'un dossier
--

--
-- BEGIN / Dématérialisation
--

--
CREATE TABLE task (
    task integer NOT NULL,
    type character varying(30) NOT NULL,
    timestamp_log text NOT NULL DEFAULT '{}',
    state character varying(20) NOT NULL DEFAULT 'draft',
    object_id character varying(30) NOT NULL
);
--
COMMENT ON TABLE task IS 'Liste des tâches à traiter pour la dématérialisation';
COMMENT ON COLUMN task.task IS 'Identifiant numérique unique de la tâche';
COMMENT ON COLUMN task.type IS 'Type de la tâche (XXX)';
COMMENT ON COLUMN task.timestamp_log IS 'Journal d''horodatage ';
COMMENT ON COLUMN task.state IS 'Statut (draft new pending done archived error debug)';
COMMENT ON COLUMN task.object_id IS 'Identifiant de l''objet métier';
--
CREATE SEQUENCE task_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER SEQUENCE task_seq OWNED BY task.task;
--
ALTER TABLE ONLY task
    ADD CONSTRAINT task_pkey PRIMARY KEY (task);

--
CREATE TABLE lien_id_interne_uid_externe (
    lien_id_interne_uid_externe integer NOT NULL,
    object character varying(30) NOT NULL,
    object_id character varying(30) NOT NULL,
    external_uid character varying(255) NOT NULL
);
--
COMMENT ON TABLE lien_id_interne_uid_externe IS 'Table de liaison entre un objet interne et un objet externe à l''aplication';
COMMENT ON COLUMN lien_id_interne_uid_externe.lien_id_interne_uid_externe IS 'Identifiant numérique unique de la liaison';
COMMENT ON COLUMN lien_id_interne_uid_externe.object IS 'Objet interne visé par la liaison';
COMMENT ON COLUMN lien_id_interne_uid_externe.object_id IS 'Identifiant unique de l''objet métier interne';
COMMENT ON COLUMN lien_id_interne_uid_externe.external_uid IS 'Identifiant unique de l''objet externe';
--
CREATE SEQUENCE lien_id_interne_uid_externe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER SEQUENCE lien_id_interne_uid_externe_seq
  OWNED BY lien_id_interne_uid_externe.lien_id_interne_uid_externe;
--
ALTER TABLE ONLY lien_id_interne_uid_externe
    ADD CONSTRAINT lien_id_interne_uid_externe_pkey PRIMARY KEY (lien_id_interne_uid_externe);
--
ALTER TABLE ONLY lien_id_interne_uid_externe
    ADD CONSTRAINT lien_id_interne_uid_externe_object_id_key UNIQUE (external_uid, object, object_id);

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'task', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'task' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lien_id_interne_uid_externe', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_id_interne_uid_externe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Type document numérisé

--
ALTER TABLE document_numerise_type ALTER COLUMN code TYPE character varying(10);
--
ALTER TABLE document_numerise_type ADD COLUMN description text NULL;
ALTER TABLE document_numerise_type ADD COLUMN om_validite_debut date NULL;
ALTER TABLE document_numerise_type ADD COLUMN om_validite_fin date NULL;
COMMENT ON COLUMN document_numerise_type.description IS 'Description';
COMMENT ON COLUMN document_numerise_type.om_validite_debut IS 'Date de début de validité';
COMMENT ON COLUMN document_numerise_type.om_validite_fin IS 'Date de fin de validité';
--
ALTER TABLE ONLY document_numerise_type_categorie
    ADD CONSTRAINT document_numerise_type_categorie_libelle_key UNIQUE (libelle);

-- Ajout des champs pour l'architecte

ALTER TABLE architecte ADD COLUMN lieu_dit character varying(39) NULL;
ALTER TABLE architecte ADD COLUMN boite_postale character varying(5) NULL;
ALTER TABLE architecte ADD COLUMN cedex character varying(5) NULL;
COMMENT ON COLUMN architecte.lieu_dit IS 'Lieu-dit de l''adresse';
COMMENT ON COLUMN architecte.boite_postale IS 'Boîte postale de l''adresse';
COMMENT ON COLUMN architecte.cedex IS 'Cedex de l''adresse';

-- Ajout des champs pour l'architecte dans la table demandeur

ALTER TABLE demandeur ADD COLUMN num_inscription character varying(20) NULL;
ALTER TABLE demandeur ADD COLUMN nom_cabinet character varying(100) NULL;
ALTER TABLE demandeur ADD COLUMN conseil_regional character varying(100) NULL;
COMMENT ON COLUMN demandeur.num_inscription IS 'Numéro d''inscription au conseil national de l''ordre des architectes';
COMMENT ON COLUMN demandeur.nom_cabinet IS 'Nom du cabinet dans lequel travail l''architecte';
COMMENT ON COLUMN demandeur.conseil_regional IS 'Conseil régional de l''architecte';

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'architecte_lc', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'paysagiste', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

-- Nature document numérisé

--
CREATE TABLE document_numerise_nature (
    document_numerise_nature integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(255) NOT NULL,
    description text NULL,
    om_validite_debut date NULL,
    om_validite_fin date NULL
);
--
COMMENT ON TABLE document_numerise_nature IS 'Nature de document numérisé';
COMMENT ON COLUMN document_numerise_nature.document_numerise_nature IS 'Identifiant numérique unique de la nature de document numérisé';
COMMENT ON COLUMN document_numerise_nature.code IS 'Code aplhanumérique unique de la nature de document numérisé';
COMMENT ON COLUMN document_numerise_nature.libelle IS 'Libellé de la nature de document numérisé';
COMMENT ON COLUMN document_numerise_nature.description IS 'Description de la nature de document numérisé';
COMMENT ON COLUMN document_numerise_nature.om_validite_debut IS 'Date de début de validité de la nature de document numérisé';
COMMENT ON COLUMN document_numerise_nature.om_validite_fin IS 'Date de fin de validité de la nature de document numérisé';
--
CREATE SEQUENCE document_numerise_nature_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER SEQUENCE document_numerise_nature_seq
  OWNED BY document_numerise_nature.document_numerise_nature;
--
ALTER TABLE ONLY document_numerise_nature
    ADD CONSTRAINT document_numerise_nature_pkey PRIMARY KEY (document_numerise_nature);
--
ALTER TABLE ONLY document_numerise_nature
    ADD CONSTRAINT document_numerise_nature_code_key UNIQUE (code);
--
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'document_numerise_nature', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'document_numerise_nature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
ALTER TABLE document_numerise ADD COLUMN document_numerise_nature integer NULL;
ALTER TABLE ONLY document_numerise
    ADD CONSTRAINT document_numerise_document_numerise_nature_fkey FOREIGN KEY (document_numerise_nature) REFERENCES document_numerise_nature(document_numerise_nature);

--
ALTER TABLE document_numerise_nature ADD COLUMN default_value boolean DEFAULT false;
COMMENT ON COLUMN document_numerise_nature.default_value IS 'Valeur à sélectionner par défaut lors de la présentation de la table en liste à choix';
-- Rendre unique le champ default_value seulement pour la valeur 't'
-- CREATE UNIQUE INDEX document_numerise_nature_default_value_t_unique_index ON document_numerise_nature ((default_value IS TRUE)) WHERE default_value IS TRUE;

--
-- END / Dématérialisation
--

--
-- BEGIN / #1085 — Mise à jour des CERFA
--

-- Ajout du champ co_piscine manquant dans les données techniques et CERFA

--
ALTER TABLE donnees_techniques ADD COLUMN co_piscine boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.co_piscine IS 'Piscine';
--
ALTER TABLE cerfa ADD COLUMN co_piscine boolean DEFAULT false;
COMMENT ON COLUMN cerfa.co_piscine IS 'Piscine';

-- Modification du champ am_exist_date dans les données techniques

--
ALTER TABLE donnees_techniques ALTER COLUMN am_exist_date TYPE character varying(100);

-- Ajout des champs dans cerfa/données techniques pour le mode de financement du projet

--
ALTER TABLE donnees_techniques ADD COLUMN co_fin_lls boolean DEFAULT false;
ALTER TABLE donnees_techniques ADD COLUMN co_fin_aa boolean DEFAULT false;
ALTER TABLE donnees_techniques ADD COLUMN co_fin_ptz boolean DEFAULT false;
ALTER TABLE donnees_techniques ADD COLUMN co_fin_autr text NULL;
COMMENT ON COLUMN donnees_techniques.co_fin_lls IS 'Mode de financement du projet : Logement Locatif Social';
COMMENT ON COLUMN donnees_techniques.co_fin_aa IS 'Mode de financement du projet : Accession Sociale (hors prêt à taux zéro)';
COMMENT ON COLUMN donnees_techniques.co_fin_ptz IS 'Mode de financement du projet : Prêt à taux zéro';
COMMENT ON COLUMN donnees_techniques.co_fin_autr IS 'Mode de financement du projet : Autres financements';
--
ALTER TABLE cerfa ADD COLUMN co_fin_lls boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_fin_aa boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_fin_ptz boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_fin_autr boolean DEFAULT false;
COMMENT ON COLUMN cerfa.co_fin_lls IS 'Mode de financement du projet : Logement Locatif Social';
COMMENT ON COLUMN cerfa.co_fin_aa IS 'Mode de financement du projet : Accession Sociale (hors prêt à taux zéro)';
COMMENT ON COLUMN cerfa.co_fin_ptz IS 'Mode de financement du projet : Prêt à taux zéro';
COMMENT ON COLUMN cerfa.co_fin_autr IS 'Mode de financement du projet : Autres financements';

--

--
ALTER TABLE donnees_techniques ADD COLUMN dia_ss_date date NULL;
ALTER TABLE donnees_techniques ADD COLUMN dia_ss_lieu character varying(255) NULL;
COMMENT ON COLUMN donnees_techniques.dia_ss_date IS 'Document signé le';
COMMENT ON COLUMN donnees_techniques.dia_ss_lieu IS 'Document signé à';
--
ALTER TABLE cerfa ADD COLUMN dia_ss_date boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN dia_ss_lieu boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_ss_date IS 'Document signé le';
COMMENT ON COLUMN cerfa.dia_ss_lieu IS 'Document signé à';

--

--
ALTER TABLE donnees_techniques ADD COLUMN enga_decla_lieu character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN enga_decla_date date NULL;
COMMENT ON COLUMN donnees_techniques.enga_decla_lieu IS 'Engagement du déclarant : lieu de signature';
COMMENT ON COLUMN donnees_techniques.enga_decla_date IS 'Engagement du déclarant : date de signature';
--
ALTER TABLE cerfa ADD COLUMN enga_decla_lieu boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN enga_decla_date boolean DEFAULT false;
COMMENT ON COLUMN cerfa.enga_decla_lieu IS 'Engagement du déclarant : lieu de signature';
COMMENT ON COLUMN cerfa.enga_decla_date IS 'Engagement du déclarant : date de signature';

--

--
ALTER TABLE donnees_techniques ADD COLUMN co_archi_attest_honneur boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.co_archi_attest_honneur IS 'Je déclare sur l''honneur que mon projet entre dans l''une des situations pour lesquelles le recours à l''architecte n''est pas obligatoire';
--
ALTER TABLE cerfa ADD COLUMN co_archi_attest_honneur boolean DEFAULT false;
COMMENT ON COLUMN cerfa.co_archi_attest_honneur IS 'Je déclare sur l''honneur que mon projet entre dans l''une des situations pour lesquelles le recours à l''architecte n''est pas obligatoire';

--

--
ALTER TABLE donnees_techniques ADD COLUMN co_bat_niv_dessous_nb integer NULL;
COMMENT ON COLUMN donnees_techniques.co_bat_niv_dessous_nb IS 'Le nombre de niveaux du bâtiment le plus élevé : au-dessous du sol';
--
ALTER TABLE cerfa ADD COLUMN co_bat_niv_dessous_nb boolean DEFAULT false;
COMMENT ON COLUMN cerfa.co_bat_niv_dessous_nb IS 'Le nombre de niveaux du bâtiment le plus élevé : au-dessous du sol';
--
COMMENT ON COLUMN cerfa.co_bat_niv_nb IS 'Le nombre de niveaux du bâtiment le plus élevé : au-dessus du sol';

--

--
ALTER TABLE donnees_techniques ADD COLUMN co_install_classe boolean DEFAULT false;
ALTER TABLE donnees_techniques ADD COLUMN co_derog_innov boolean DEFAULT false;
ALTER TABLE donnees_techniques ADD COLUMN co_avis_abf boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.co_install_classe IS 'porte sur une installation classée soumise à enregistrement en application de l''article L. 512-7 du code de l''environnement';
COMMENT ON COLUMN donnees_techniques.co_derog_innov IS 'déroge à certaines règles de construction et met en œuvre une solution d''effet équivalent au titre de l''ordonnance n° 2018-937 du 30 octobre 2018 visant à faciliter la réalisation de projets de construction et à favoriser l''innovation';
COMMENT ON COLUMN donnees_techniques.co_avis_abf IS 'relève de l''article L.632-2-1 du code du patrimoine (avis simple de l''architecte des Bâtiments de France pour les antennes-relais et les opérations liées au traitement de l''habitat indigne)';
--
ALTER TABLE cerfa ADD COLUMN co_install_classe boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_derog_innov boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_avis_abf boolean DEFAULT false;
COMMENT ON COLUMN cerfa.co_install_classe IS 'porte sur une installation classée soumise à enregistrement en application de l''article L. 512-7 du code de l''environnement';
COMMENT ON COLUMN cerfa.co_derog_innov IS 'déroge à certaines règles de construction et met en œuvre une solution d''effet équivalent au titre de l''ordonnance n° 2018-937 du 30 octobre 2018 visant à faciliter la réalisation de projets de construction et à favoriser l''innovation';
COMMENT ON COLUMN cerfa.co_avis_abf IS 'relève de l''article L.632-2-1 du code du patrimoine (avis simple de l''architecte des Bâtiments de France pour les antennes-relais et les opérations liées au traitement de l''habitat indigne)';

--

--
ALTER TABLE donnees_techniques ADD COLUMN tax_surf_tot_demo numeric NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_surf_tax_demo numeric NULL;
COMMENT ON COLUMN donnees_techniques.tax_surf_tot_demo IS 'Surface taxable démolie de la (ou des) construction(s)';
COMMENT ON COLUMN donnees_techniques.tax_surf_tax_demo IS 'Quelle est la surface taxable démolie ?';
--
ALTER TABLE cerfa ADD COLUMN tax_surf_tot_demo boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN tax_surf_tax_demo boolean DEFAULT false;
COMMENT ON COLUMN cerfa.tax_surf_tot_demo IS 'Surface taxable démolie de la (ou des) construction(s)';
COMMENT ON COLUMN cerfa.tax_surf_tax_demo IS 'Quelle est la surface taxable démolie ?';

--

--
ALTER TABLE donnees_techniques ADD COLUMN tax_su_non_habit_surf8 numeric NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_su_non_habit_surf_stat8 numeric NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_su_non_habit_surf9 numeric NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_su_non_habit_surf_stat9  numeric NULL;
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf8 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et artisanaux ainsi que leurs annexes" Colonne "Surfaces créées (1) hormis les surfaces de stationnement closes et couvertes"';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat8 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et artisanaux ainsi que leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert"';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf9 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique" Colonne "Surfaces créées (1) hormis les surfaces de stationnement closes et couvertes"';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat9 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique" Colonne "Surfaces créées pour le stationnement clos et couvert"';

--

--
ALTER TABLE donnees_techniques ADD COLUMN tax_terrassement_arch boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.tax_terrassement_arch IS 'Votre projet fait-il l''objet d''un (ou de) terrassement(s) ?';
--
ALTER TABLE cerfa ADD COLUMN tax_terrassement_arch boolean DEFAULT false;
COMMENT ON COLUMN cerfa.tax_terrassement_arch IS 'Votre projet fait-il l''objet d''un (ou de) terrassement(s) ?';

--

--
ALTER TABLE donnees_techniques ADD COLUMN tax_adresse_future_numero character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_adresse_future_voie character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_adresse_future_lieudit character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_adresse_future_localite character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_adresse_future_cp character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_adresse_future_bp character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_adresse_future_cedex character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_adresse_future_pays character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN tax_adresse_future_division character varying(255) NULL;
COMMENT ON COLUMN donnees_techniques.tax_adresse_future_numero IS 'Adresse à échéance des taxes : Numéro';
COMMENT ON COLUMN donnees_techniques.tax_adresse_future_voie IS 'Adresse à échéance des taxes : Voie';
COMMENT ON COLUMN donnees_techniques.tax_adresse_future_lieudit IS 'Adresse à échéance des taxes : Lieu-dit';
COMMENT ON COLUMN donnees_techniques.tax_adresse_future_localite IS 'Adresse à échéance des taxes : Localité';
COMMENT ON COLUMN donnees_techniques.tax_adresse_future_cp IS 'Adresse à échéance des taxes : Code postal';
COMMENT ON COLUMN donnees_techniques.tax_adresse_future_bp IS 'Adresse à échéance des taxes : BP';
COMMENT ON COLUMN donnees_techniques.tax_adresse_future_cedex IS 'Adresse à échéance des taxes : Cedex';
COMMENT ON COLUMN donnees_techniques.tax_adresse_future_pays IS 'Adresse à échéance des taxes : Pays';
COMMENT ON COLUMN donnees_techniques.tax_adresse_future_division IS 'Adresse à échéance des taxes : Division territoriale';
--
ALTER TABLE cerfa ADD COLUMN tax_adresse_future_numero boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN tax_adresse_future_voie boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN tax_adresse_future_lieudit boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN tax_adresse_future_localite boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN tax_adresse_future_cp boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN tax_adresse_future_bp boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN tax_adresse_future_cedex boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN tax_adresse_future_pays boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN tax_adresse_future_division boolean DEFAULT false;
COMMENT ON COLUMN cerfa.tax_adresse_future_numero IS 'Adresse à échéance des taxes : Numéro';
COMMENT ON COLUMN cerfa.tax_adresse_future_voie IS 'Adresse à échéance des taxes : Voie';
COMMENT ON COLUMN cerfa.tax_adresse_future_lieudit IS 'Adresse à échéance des taxes : Lieu-dit';
COMMENT ON COLUMN cerfa.tax_adresse_future_localite IS 'Adresse à échéance des taxes : Localité';
COMMENT ON COLUMN cerfa.tax_adresse_future_cp IS 'Adresse à échéance des taxes : Code postal';
COMMENT ON COLUMN cerfa.tax_adresse_future_bp IS 'Adresse à échéance des taxes : BP';
COMMENT ON COLUMN cerfa.tax_adresse_future_cedex IS 'Adresse à échéance des taxes : Cedex';
COMMENT ON COLUMN cerfa.tax_adresse_future_pays IS 'Adresse à échéance des taxes : Pays';
COMMENT ON COLUMN cerfa.tax_adresse_future_division IS 'Adresse à échéance des taxes : Division territoriale';

--

--
ALTER TABLE donnees_techniques ADD COLUMN co_bat_projete text NULL;
ALTER TABLE donnees_techniques ADD COLUMN co_bat_existant text NULL;
ALTER TABLE donnees_techniques ADD COLUMN co_bat_nature text NULL;
COMMENT ON COLUMN donnees_techniques.co_bat_projete IS 'Indiquez la destination, la sous-destination et la localisation approximative des bâtiments projetés dans l''unité foncière';
COMMENT ON COLUMN donnees_techniques.co_bat_existant IS 'Indiquez la destination et la sous-destination des bâtiments à conserver ou à démolir';
COMMENT ON COLUMN donnees_techniques.co_bat_nature IS 'Vous pouvez compléter cette note par des feuilles supplémentaires, des plans, des croquis, des photos. Dans ce cas, précisez ci-dessous la nature et le nombre des pièces fournies';
--
ALTER TABLE cerfa ADD COLUMN co_bat_projete boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_bat_existant boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_bat_nature boolean DEFAULT false;
COMMENT ON COLUMN cerfa.co_bat_projete IS 'Indiquez la destination, la sous-destination et la localisation approximative des bâtiments projetés dans l''unité foncière';
COMMENT ON COLUMN cerfa.co_bat_existant IS 'Indiquez la destination et la sous-destination des bâtiments à conserver ou à démolir';
COMMENT ON COLUMN cerfa.co_bat_nature IS 'Vous pouvez compléter cette note par des feuilles supplémentaires, des plans, des croquis, des photos. Dans ce cas, précisez ci-dessous la nature et le nombre des pièces fournies';

--

--
ALTER TABLE donnees_techniques ADD COLUMN terr_juri_titul_date date NULL;
COMMENT ON COLUMN donnees_techniques.terr_juri_titul_date IS 'Si oui, à quelle date a t-il été délivré ?';
--
ALTER TABLE cerfa ADD COLUMN terr_juri_titul_date boolean DEFAULT false;
COMMENT ON COLUMN cerfa.terr_juri_titul_date IS 'Si oui, à quelle date a t-il été délivré ?';

--

--
ALTER TABLE donnees_techniques ADD COLUMN co_autre_desc text NULL;
ALTER TABLE donnees_techniques ADD COLUMN co_trx_autre text NULL;
ALTER TABLE donnees_techniques ADD COLUMN co_autre boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.co_autre_desc IS 'Autres travaux envisagés (précisez)';
COMMENT ON COLUMN donnees_techniques.co_trx_autre IS 'Travaux comprennent notamment : Autre (précisez)';
COMMENT ON COLUMN donnees_techniques.co_autre IS 'Autres travaux envisagés';
--
ALTER TABLE cerfa ADD COLUMN co_autre_desc boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_trx_autre boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_autre boolean DEFAULT false;
COMMENT ON COLUMN cerfa.co_autre_desc IS 'Autres travaux envisagés (précisez)';
COMMENT ON COLUMN cerfa.co_trx_autre IS 'Travaux comprennent notamment : Autre (précisez)';
COMMENT ON COLUMN cerfa.co_autre IS 'Autres travaux envisagés';

--

--
ALTER TABLE donnees_techniques ADD COLUMN erp_modif_facades boolean DEFAULT false;
ALTER TABLE donnees_techniques ADD COLUMN erp_trvx_adap boolean DEFAULT false;
ALTER TABLE donnees_techniques ADD COLUMN erp_trvx_adap_numero character varying(255) NULL;
ALTER TABLE donnees_techniques ADD COLUMN erp_trvx_adap_valid date NULL;
ALTER TABLE donnees_techniques ADD COLUMN erp_prod_dangereux boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.erp_modif_facades IS 'Modification des accès en façades';
COMMENT ON COLUMN donnees_techniques.erp_trvx_adap IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement';
COMMENT ON COLUMN donnees_techniques.erp_trvx_adap_numero IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement : Ad''AP n°';
COMMENT ON COLUMN donnees_techniques.erp_trvx_adap_valid IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement : validé le';
COMMENT ON COLUMN donnees_techniques.erp_prod_dangereux IS 'Cette demande fait l''objet d''une déclaration ou autorisation au titre du code de l''environnement (produits dangereux stockés ou utilisés)';
--
ALTER TABLE cerfa ADD COLUMN erp_modif_facades boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN erp_trvx_adap boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN erp_trvx_adap_numero boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN erp_trvx_adap_valid boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN erp_prod_dangereux boolean DEFAULT false;
COMMENT ON COLUMN cerfa.erp_modif_facades IS 'Modification des accès en façades';
COMMENT ON COLUMN cerfa.erp_trvx_adap IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement';
COMMENT ON COLUMN cerfa.erp_trvx_adap_numero IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement : Ad''AP n°';
COMMENT ON COLUMN cerfa.erp_trvx_adap_valid IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement : validé le';
COMMENT ON COLUMN cerfa.erp_prod_dangereux IS 'Cette demande fait l''objet d''une déclaration ou autorisation au titre du code de l''environnement (produits dangereux stockés ou utilisés)';

--

--
ALTER TABLE donnees_techniques ADD COLUMN co_trav_supp_dessus numeric NULL;
ALTER TABLE donnees_techniques ADD COLUMN co_trav_supp_dessous numeric NULL;
COMMENT ON COLUMN donnees_techniques.co_trav_supp_dessus IS 'Création de niveaux supplémentaires : au-dessus du sol';
COMMENT ON COLUMN donnees_techniques.co_trav_supp_dessous IS 'Création de niveaux supplémentaires : au-dessous du sol';
--
ALTER TABLE cerfa ADD COLUMN co_trav_supp_dessus boolean DEFAULT false;
ALTER TABLE cerfa ADD COLUMN co_trav_supp_dessous boolean DEFAULT false;
COMMENT ON COLUMN cerfa.co_trav_supp_dessus IS 'Création de niveaux supplémentaires : au-dessus du sol';
COMMENT ON COLUMN cerfa.co_trav_supp_dessous IS 'Création de niveaux supplémentaires : au-dessous du sol';

--

--
ALTER TABLE donnees_techniques ADD COLUMN tax_su_habit_abr_jard_pig_colom numeric NULL;
COMMENT ON COLUMN donnees_techniques.tax_su_habit_abr_jard_pig_colom IS 'Création de locaux destinés à l''habitation : Parmi les surfaces déclarées ci-dessus, quelle est la surface affectée à la catégorie des abris de jardin, pigeonniers et colombiers (en m²) ?';
--
ALTER TABLE cerfa ADD COLUMN tax_su_habit_abr_jard_pig_colom boolean DEFAULT false;
COMMENT ON COLUMN cerfa.tax_su_habit_abr_jard_pig_colom IS 'Création de locaux destinés à l''habitation : Parmi les surfaces déclarées ci-dessus, quelle est la surface affectée à la catégorie des abris de jardin, pigeonniers et colombiers (en m²) ?';

--

--
ALTER TABLE donnees_techniques ADD COLUMN enga_decla_donnees_nomi_comm boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.enga_decla_donnees_nomi_comm IS 'Pour permettre l''utilisation des informations nominatives comprises dans ce formulaire à des fins commerciales, cochez la case ci-contre';
--
ALTER TABLE cerfa ADD COLUMN enga_decla_donnees_nomi_comm boolean DEFAULT false;
COMMENT ON COLUMN cerfa.enga_decla_donnees_nomi_comm IS 'Pour permettre l''utilisation des informations nominatives comprises dans ce formulaire à des fins commerciales, cochez la case ci-contre';


--
-- END / #1085 — Mise à jour des CERFA
--

--
-- BEGIN / [#9398] Création d’une adresse normalisée
--

-- table dossier
ALTER TABLE dossier ADD COLUMN adresse_normalisee text;
ALTER TABLE dossier ADD COLUMN adresse_normalisee_json text DEFAULT '{}';
COMMENT ON COLUMN dossier.adresse_normalisee IS 'Adresse normalisée du terrain';
COMMENT ON COLUMN dossier.adresse_normalisee_json IS 'JSON transmis par l''api adresse lors de la récupération de l''adresse normalisée';

-- table dossier_autorisation
ALTER TABLE dossier_autorisation ADD COLUMN adresse_normalisee text;
ALTER TABLE dossier_autorisation ADD COLUMN adresse_normalisee_json text DEFAULT '{}';
COMMENT ON COLUMN dossier_autorisation.adresse_normalisee IS 'Adresse normalisée du terrain';
COMMENT ON COLUMN dossier_autorisation.adresse_normalisee_json IS 'JSON transmis par l''api adresse lors de la récupération de l''adresse normalisée';

-- ADMINISTRATEUR GENERAL
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

-- INSTRUCTEUR POLYVALENT
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

-- INSTRUCTEUR POLYVALENT COMMUNE
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_encours_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_encours_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_mes_clotures_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_mes_clotures_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_encours_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_encours_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'dossier_instruction_tous_clotures_normalize_address', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'dossier_instruction_tous_clotures_normalize_address' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

--
-- END / [#9398] Création d’une adresse normalisée
--

--
-- BEGIN / [#9397] Amélioration de l'affectation automatique
--
ALTER TABLE affectation_automatique ADD affectation_manuelle VARCHAR(100) NULL;
ALTER TABLE affectation_automatique ADD dossier_instruction_type INTEGER NULL;

ALTER TABLE affectation_automatique ADD FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type (dossier_instruction_type);

COMMENT ON COLUMN affectation_automatique.affectation_manuelle IS 'Affectation manuelle';
COMMENT ON COLUMN affectation_automatique.dossier_instruction_type IS 'Type de dossier d''instruction affecté à l''instructeur';

CREATE INDEX affectation_automatique_om_collectivite_idx ON affectation_automatique USING btree (om_collectivite);

--
-- END / [#9397] Amélioration de l'affectation automatique
--

--
-- BEGIN / [#9410] Ajout du champ "Date de dépôt en mairie"
--

ALTER TABLE dossier ADD date_depot_mairie DATE NULL;
COMMENT ON COLUMN dossier.date_depot_mairie IS 'Date de dépôt en mairie';

ALTER TABLE instruction ADD date_depot_mairie DATE NULL;
COMMENT ON COLUMN instruction.date_depot_mairie IS 'Date de dépôt en mairie du dossier d''instruction';

-- mise à jour des champs de fusions (om_requete)
UPDATE om_requete AS omr SET requete = (
   SELECT regexp_replace(r.requete, '(-- *Dates importantes du dossier d''instruction)', E'\\1\rto_char(dossier.date_depot_mairie, ''DD/MM/YYYY'') as date_depot_mairie,')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('dossier.date_depot_mairie' IN omr.requete) = 0
  AND substring(omr.requete FROM '-- *Dates importantes du dossier d''instruction') IS NOT NULL;

UPDATE om_requete AS omr SET merge_fields = (
   SELECT regexp_replace(r.merge_fields, '(-- *Dates importantes du dossier d''instruction)', E'\\1\r[date_depot_mairie]')
   FROM om_requete AS r
   WHERE r.om_requete = omr.om_requete
)
WHERE position('[date_depot_mairie]' IN omr.merge_fields) = 0
  AND substring(omr.merge_fields FROM '-- *Dates importantes du dossier d''instruction') IS NOT NULL;

--
-- END / [#9410] Ajout du champ "Date de dépôt en mairie"
--

--
-- BEGIN / #1117 — Augmentation de la taille des identifiants
--

--action 20 -> 150
ALTER TABLE action ALTER COLUMN action TYPE character varying(150);
ALTER TABLE evenement ALTER COLUMN action TYPE character varying(150);
ALTER TABLE instruction ALTER COLUMN action TYPE character varying(150);

-- etat 20 -> 150
ALTER TABLE etat ALTER COLUMN etat TYPE character varying(150);
ALTER TABLE dossier ALTER COLUMN etat TYPE character varying(150);
ALTER TABLE dossier ALTER COLUMN etat_pendant_incompletude TYPE character varying(150);
ALTER TABLE evenement ALTER COLUMN etat TYPE character varying(150);
ALTER TABLE instruction ALTER COLUMN archive_etat_pendant_incompletude TYPE character varying(150);
ALTER TABLE instruction ALTER COLUMN archive_etat TYPE character varying(150);
ALTER TABLE instruction ALTER COLUMN etat TYPE character varying(150);
ALTER TABLE lien_demande_type_etat ALTER COLUMN etat TYPE character varying(150);
ALTER TABLE transition ALTER COLUMN etat TYPE character varying(150);

-- om_lettretype (correction) 60 -> 50
ALTER TABLE evenement ALTER COLUMN lettretype TYPE character varying(50);
ALTER TABLE instruction ALTER COLUMN lettretype TYPE character varying(50);

-- document_numerise_type 10 -> 50
ALTER TABLE document_numerise_type ALTER COLUMN code TYPE character varying(50);

--
-- END / #1117 — Augmentation de la taille des identifiants
--

--
-- BEGIN / Augmente le nombre de caractère pour la numérotation des dossiers
--

ALTER TABLE dossier ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE dossier ALTER COLUMN dossier_libelle TYPE character varying(255);
ALTER TABLE dossier ALTER COLUMN dossier_autorisation TYPE character varying(255);
ALTER TABLE dossier ALTER COLUMN autorisation_contestee TYPE character varying(255);
ALTER TABLE dossier_autorisation ALTER COLUMN dossier_autorisation TYPE character varying(255);
ALTER TABLE dossier_autorisation ALTER COLUMN dossier_autorisation_libelle TYPE character varying(255);
ALTER TABLE demande ALTER COLUMN dossier_instruction TYPE character varying(255);
ALTER TABLE demande ALTER COLUMN dossier_autorisation TYPE character varying(255);
ALTER TABLE document_numerise ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE donnees_techniques ALTER COLUMN dossier_instruction TYPE character varying(255);
ALTER TABLE donnees_techniques ALTER COLUMN dossier_autorisation TYPE character varying(255);
ALTER TABLE dossier_autorisation_parcelle ALTER COLUMN dossier_autorisation TYPE character varying(255);
ALTER TABLE dossier_commission ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE dossier_contrainte ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE dossier_geolocalisation ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE dossier_message ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE dossier_parcelle ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE instruction ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE instruction ALTER COLUMN destinataire TYPE character varying(255);
ALTER TABLE lien_dossier_autorisation_demandeur ALTER COLUMN dossier_autorisation TYPE character varying(255);
ALTER TABLE lien_dossier_demandeur ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE lien_dossier_dossier ALTER COLUMN dossier_src TYPE character varying(255);
ALTER TABLE lien_dossier_dossier ALTER COLUMN dossier_cible TYPE character varying(255);
ALTER TABLE lot ALTER COLUMN dossier TYPE character varying(255);
ALTER TABLE lot ALTER COLUMN dossier_autorisation TYPE character varying(255);
ALTER TABLE rapport_instruction ALTER COLUMN dossier_instruction TYPE character varying(255);

--
-- END / Augmente le nombre de caractère pour la numérotation des dossiers
--

--
-- BEGIN / Ajout des champs pour stocker la numérotation du dossier
--

ALTER TABLE dossier ADD COLUMN numerotation_type character varying(3) NULL;
ALTER TABLE dossier ADD COLUMN numerotation_dep character varying(3) NULL;
ALTER TABLE dossier ADD COLUMN numerotation_com character varying(3) NULL;
ALTER TABLE dossier ADD COLUMN numerotation_division character varying(2) NULL;
ALTER TABLE dossier ADD COLUMN numerotation_num integer NULL;
ALTER TABLE dossier ADD COLUMN numerotation_suffixe character varying(10) NULL;
ALTER TABLE dossier ADD COLUMN numerotation_num_suffixe integer NULL;
ALTER TABLE dossier ADD COLUMN numerotation_entite character varying(10) NULL;
ALTER TABLE dossier ADD COLUMN numerotation_num_entite integer NULL;

ALTER TABLE dossier_autorisation ADD COLUMN numerotation_type character varying(3) NULL;
ALTER TABLE dossier_autorisation ADD COLUMN numerotation_dep character varying(3) NULL;
ALTER TABLE dossier_autorisation ADD COLUMN numerotation_com character varying(3) NULL;
ALTER TABLE dossier_autorisation ADD COLUMN numerotation_division character varying(2) NULL;
ALTER TABLE dossier_autorisation ADD COLUMN numerotation_num integer NULL;

--
-- END / Ajout des champs pour stocker la numérotation du dossier
--

--
-- BEGIN / Ajout de la colonne dossier dans la table task
--

ALTER TABLE task ADD COLUMN dossier varchar(30);
COMMENT ON COLUMN task.dossier IS 'Numéro du dossier lié à la tâche';

ALTER TABLE task ADD COLUMN json_payload text NOT NULL DEFAULT '{}';
COMMENT ON COLUMN task.json_payload IS 'Champ permettant de stocker la view json de la tache';

--
-- END / Ajout de la colonne dossier dans la table task
--

--
-- BEGIN / Ajout de la colonne tacite dans la table avis_decision
--

ALTER TABLE avis_decision ADD COLUMN tacite boolean DEFAULT false;
COMMENT ON COLUMN avis_decision.tacite IS 'Indique si l''avis de décision est appliqué par tacicité';

--
-- END / Ajout de la colonne tacite dans la table avis_decision
--

--
-- BEGIN / Ajout de la colonne stream dans le table task
--

ALTER TABLE task ADD COLUMN stream varchar;
COMMENT ON COLUMN task.stream IS 'Indique si la tache est de type input ou output';

--
-- END / Ajout de la colonne stream dans le table task
--

--
-- BEGIN / Modification de la colonne object_id dans la table task
--

ALTER TABLE task ALTER COLUMN object_id DROP NOT NULL;

--
-- END / Modification de la colonne object_id dans la table task
--

--
-- BEGIN / #1119 — Analyse PeC et Avis de consulation
--

-- Nouvelle table de référence *pec_metier*
CREATE TABLE pec_metier (
    pec_metier integer NOT NULL,
    code character varying(10) NULL,
    libelle character varying(255) NOT NULL,
    description text NULL,
    om_validite_debut date NULL,
    om_validite_fin date NULL
);
ALTER TABLE ONLY pec_metier
    ADD CONSTRAINT pec_metier_pkey PRIMARY KEY (pec_metier);
CREATE SEQUENCE pec_metier_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
COMMENT ON COLUMN pec_metier.pec_metier IS 'Identifiant technique de la prise en compte métier';
COMMENT ON COLUMN pec_metier.code IS 'Code de la prise en compte métier';
COMMENT ON COLUMN pec_metier.libelle IS 'Libellé de la prise en compte métier';
COMMENT ON COLUMN pec_metier.description IS 'Description de la prise en compte métier';
COMMENT ON COLUMN pec_metier.om_validite_debut IS 'Date de validité (début) de la prise en compte métier';
COMMENT ON COLUMN pec_metier.om_validite_fin IS 'Date de validité (fin) de la prise en compte métier';

--
ALTER TABLE dossier ADD pec_metier integer NULL;
ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_pec_metier FOREIGN KEY (pec_metier) REFERENCES pec_metier(pec_metier);
COMMENT ON COLUMN dossier.pec_metier IS 'Statut de la prise en compte métier du dossier d''instruction';

--
ALTER TABLE evenement ADD pec_metier integer NULL;
ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_pec_metier FOREIGN KEY (pec_metier) REFERENCES pec_metier(pec_metier);
COMMENT ON COLUMN evenement.pec_metier IS 'Statut de la prise en compte métier de l''événement destiné au dossier d''instruction';

--
ALTER TABLE instruction ADD pec_metier integer NULL;
ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_pec_metier FOREIGN KEY (pec_metier) REFERENCES pec_metier(pec_metier);
COMMENT ON COLUMN instruction.pec_metier IS 'Statut de la prise en compte métier de l''instruction, venant de l''événement et destiné au dossier d''instruction';

--
ALTER TABLE action ADD COLUMN regle_pec_metier character varying(60) NULL;
COMMENT ON COLUMN action.regle_pec_metier IS 'Règle de calcul de la prise en compte métier d''un dossier d''instruction';

--
ALTER TABLE instruction ADD COLUMN archive_pec_metier integer NULL;
COMMENT ON COLUMN instruction.archive_pec_metier IS 'Valeur du champ prise_en_compte du dossier d''instruction avant ajout de l''événement d''instruction';

--
ALTER TABLE action ADD COLUMN regle_a_qualifier character varying(60) NULL;
COMMENT ON COLUMN action.regle_a_qualifier IS 'Règle de calcul de la qualification d''un dossier d''instruction';

--
ALTER TABLE instruction ADD COLUMN archive_a_qualifier boolean NOT NULL DEFAULT FALSE;
COMMENT ON COLUMN instruction.archive_a_qualifier IS 'Valeur du champ a_qualifier du dossier d''instruction avant ajout de l''événement d''instruction';

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'pec_metier', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'pec_metier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'pec_metier', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'pec_metier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

--
-- END / #1119 — Analyse PeC et Avis de consulation
--

--
-- BEGIN / #1119 — Analyse PeC et Avis de consulation
--

-- Nouvelle table de référence *avis_decision_type*
CREATE TABLE IF NOT EXISTS avis_decision_type (
    avis_decision_type integer NOT NULL,
    code character varying(10) NULL,
    libelle character varying(255) NOT NULL,
    description text NULL,
    om_validite_debut date NULL,
    om_validite_fin date NULL,
    CONSTRAINT avis_decision_type_pkey PRIMARY KEY (avis_decision_type)
);
CREATE SEQUENCE IF NOT EXISTS avis_decision_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
COMMENT ON TABLE avis_decision_type IS 'Type d''avis décision';
COMMENT ON COLUMN avis_decision_type.avis_decision_type IS 'Identifiant technique du type d''avis décision';
COMMENT ON COLUMN avis_decision_type.code IS 'Code du type d''avis décision';
COMMENT ON COLUMN avis_decision_type.libelle IS 'Libellé du type d''avis décision';
COMMENT ON COLUMN avis_decision_type.description IS 'Description du type d''avis décision';
COMMENT ON COLUMN avis_decision_type.om_validite_debut IS 'Date de validité (début) du type d''avis décision';
COMMENT ON COLUMN avis_decision_type.om_validite_fin IS 'Date de validité (fin) du type d''avis décision';

--
ALTER TABLE avis_decision ADD IF NOT EXISTS avis_decision_type integer NULL;
ALTER TABLE ONLY avis_decision
    DROP CONSTRAINT IF EXISTS avis_decision_avis_decision_type;
ALTER TABLE ONLY avis_decision
    ADD CONSTRAINT avis_decision_avis_decision_type FOREIGN KEY (avis_decision_type) REFERENCES avis_decision_type(avis_decision_type);
COMMENT ON COLUMN avis_decision.avis_decision_type IS 'Type de l''avis de décision';

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'avis_decision_type', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avis_decision_type' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'avis_decision_type', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avis_decision_type' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

-- Nouvelle table de référence *avis_decision_type*
CREATE TABLE IF NOT EXISTS avis_decision_nature (
    avis_decision_nature integer NOT NULL,
    code character varying(10) NULL,
    libelle character varying(255) NOT NULL,
    description text NULL,
    om_validite_debut date NULL,
    om_validite_fin date NULL,
    CONSTRAINT avis_decision_nature_pkey PRIMARY KEY (avis_decision_nature)
);
CREATE SEQUENCE IF NOT EXISTS avis_decision_nature_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
COMMENT ON TABLE avis_decision_nature IS 'Nature d''avis décision';
COMMENT ON COLUMN avis_decision_nature.avis_decision_nature IS 'Identifiant technique de la nature d''avis décision';
COMMENT ON COLUMN avis_decision_nature.code IS 'Code de la nature d''avis décision';
COMMENT ON COLUMN avis_decision_nature.libelle IS 'Libellé de la nature d''avis décision';
COMMENT ON COLUMN avis_decision_nature.description IS 'Description de la nature d''avis décision';
COMMENT ON COLUMN avis_decision_nature.om_validite_debut IS 'Date de validité (début) de la nature d''avis décision';
COMMENT ON COLUMN avis_decision_nature.om_validite_fin IS 'Date de validité (fin) de la nature d''avis décision';

--
ALTER TABLE avis_decision ADD IF NOT EXISTS avis_decision_nature integer NULL;
ALTER TABLE ONLY avis_decision
    DROP CONSTRAINT IF EXISTS avis_decision_avis_decision_nature;
ALTER TABLE ONLY avis_decision
    ADD CONSTRAINT avis_decision_avis_decision_nature FOREIGN KEY (avis_decision_nature) REFERENCES avis_decision_nature(avis_decision_nature);
COMMENT ON COLUMN avis_decision.avis_decision_nature IS 'Nature de l''avis de décision';

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'avis_decision_nature', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avis_decision_nature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'avis_decision_nature', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'avis_decision_nature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

--
-- END / #1119 — Analyse PeC et Avis de consulation
--

--
-- BEGIN / Sauvegarde de tous les UID d'objets platau créés
--

--
ALTER TABLE lien_id_interne_uid_externe ADD COLUMN dossier character varying(255);
COMMENT ON COLUMN lien_id_interne_uid_externe.dossier IS 'Numéro de dossier lié à l''objet';

--
-- END / Sauvegarde de tous les UID d'objets platau créés
--

--
-- BEGIN / Récupération et présentation des infos des consultations
--

--
CREATE TABLE IF NOT EXISTS consultation_entrante (
    consultation_entrante integer NOT NULL,
    delai_de_reponse_en_mois character varying(255),
    date_consultation date,
    date_emission date,
    service_consultant_id character varying(255),
    service_consultant_libelle character varying(255),
    service_consultant_insee character varying(255),
    service_consultant_mail character varying(255),
    service_consultant_type character varying(255),
    service_consultant__siren character varying(255),
    etat_consultation character varying(255),
    type_consultation character varying(255),
    texte_fondement_reglementaire text,
    tx_objet_de_la_consultation text,
    dossier character varying(255),
    CONSTRAINT consultation_entrante_pkey PRIMARY KEY (consultation_entrante)
);
CREATE SEQUENCE IF NOT EXISTS consultation_entrante_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
COMMENT ON TABLE consultation_entrante IS 'Consultation entrante';
COMMENT ON COLUMN consultation_entrante.consultation_entrante IS 'Identifiant technique de la consultation entrante';
COMMENT ON COLUMN consultation_entrante.delai_de_reponse_en_mois IS 'Délais en nombre de mois ou la réponse est autorisée';
COMMENT ON COLUMN consultation_entrante.date_consultation IS 'Date à laquelle la consultation entrante a été décidée';
COMMENT ON COLUMN consultation_entrante.date_emission IS 'Date à laquelle la consultation entrante a été transmise au service consultable';
COMMENT ON COLUMN consultation_entrante.service_consultant_id IS 'Identifiant du service consultant';
COMMENT ON COLUMN consultation_entrante.service_consultant_libelle IS 'Libellé du service consultant';
COMMENT ON COLUMN consultation_entrante.service_consultant_insee IS 'Code INSEE du service consultant';
COMMENT ON COLUMN consultation_entrante.service_consultant_mail IS 'Adresse mail du service consultant';
COMMENT ON COLUMN consultation_entrante.service_consultant_type IS 'Type du service consultant';
COMMENT ON COLUMN consultation_entrante.service_consultant__siren IS 'Code SIREN du service consultant';
COMMENT ON COLUMN consultation_entrante.etat_consultation IS 'État de la consultation entrante';
COMMENT ON COLUMN consultation_entrante.type_consultation IS 'Type de la consultation entrante';
COMMENT ON COLUMN consultation_entrante.texte_fondement_reglementaire IS 'Texte indiquant le(s) article(s) réglémen-taire(s) sur le(s)quel(s) se fonde la consultation entrante';
COMMENT ON COLUMN consultation_entrante.tx_objet_de_la_consultation IS 'Texte descriptif de la consultation entrante';
COMMENT ON COLUMN consultation_entrante.dossier IS 'Numéro du dossier d''instruction portant la consultation entrante';
--
ALTER TABLE ONLY consultation_entrante
    DROP CONSTRAINT IF EXISTS consultation_entrante_dossier;
ALTER TABLE ONLY consultation_entrante
    ADD CONSTRAINT consultation_entrante_dossier FOREIGN KEY (dossier) REFERENCES dossier(dossier);
--
ALTER TABLE ONLY consultation_entrante
    DROP CONSTRAINT IF EXISTS consultation_entrante_dossier_unique;
ALTER TABLE ONLY consultation_entrante
    ADD CONSTRAINT consultation_entrante_dossier_unique UNIQUE (dossier);

--
-- END / Récupération et présentation des infos des consultations
--

--
-- BEGIN / [#9476] - Modification de la gestion de l'incomplétude pour utiliser les règles d'action 
--

--
ALTER TABLE action
    ADD COLUMN regle_incompletude character varying(60) NULL,
    ADD COLUMN regle_incomplet_notifie character varying(60) NULL,
    ADD COLUMN regle_etat_pendant_incompletude character varying(60) NULL,
    ADD COLUMN regle_evenement_suivant_tacite_incompletude character varying(60) NULL;
COMMENT ON COLUMN action.regle_incompletude IS 'Règle de calcul de l''incomplétude d''un dossier d''instruction';
COMMENT ON COLUMN action.regle_incomplet_notifie IS 'Règle de calcul de l''incomplétude notifiée d''un dossier d''instruction';
COMMENT ON COLUMN action.regle_etat_pendant_incompletude IS 'Règle de calcul de l''état d''un dossier d''instruction pendant son incomplétude';
COMMENT ON COLUMN action.regle_evenement_suivant_tacite_incompletude IS 'Règle de calcul pour définir si l''événement suivant tacite paramétré sur l''événement concerne l''incomplétude du dossier d''instruction';

--
-- END / [#9476] - Modification de la gestion de l'incomplétude pour utiliser les règles d'action 
--

--
-- BEGIN / Mettre à jour payload et BD suite évolution schéma Consultation
--

--
ALTER TABLE consultation_entrante
    RENAME COLUMN delai_de_reponse_en_mois TO delai_reponse;
ALTER TABLE consultation_entrante
    RENAME COLUMN tx_objet_de_la_consultation TO texte_objet_consultation;
ALTER TABLE consultation_entrante
    ADD COLUMN type_delai character varying(255) NULL,
    ADD COLUMN objet_consultation character varying(255) NULL,
    ADD COLUMN date_production_notification date NULL,
    ADD COLUMN date_premiere_consultation date NULL;
COMMENT ON COLUMN consultation_entrante.delai_reponse IS 'Délais de la réponse autorisée';
COMMENT ON COLUMN consultation_entrante.type_delai IS 'Type de délai pour la réponse (jour/mois)';
COMMENT ON COLUMN consultation_entrante.objet_consultation IS 'Identifiant Plat''AU de l''objet de la consultation entrante';
COMMENT ON COLUMN consultation_entrante.date_production_notification IS 'Date à laquelle la notification de la consultation entrante a été produite';
COMMENT ON COLUMN consultation_entrante.date_premiere_consultation IS 'Date à laquelle la consultation entrainte a été consultée pour la première fois';

--
-- END / Mettre à jour payload et BD suite évolution schéma Consultation
--

--
-- BEGIN / #1112 — [J3] - Tâches concernant les consultations
--

--
ALTER TABLE service ADD COLUMN service_type character varying(255);
COMMENT ON COLUMN service.service_type IS 'Type du service';
UPDATE service SET service_type = 'openads';
ALTER TABLE service ALTER COLUMN service_type SET NOT NULL;

--
ALTER TABLE service ADD COLUMN generate_edition boolean DEFAULT false;
COMMENT ON COLUMN service.generate_edition IS 'Générer l''édition liée au service consulté (true) ou non (false)';
UPDATE service SET generate_edition = 't';

--
ALTER TABLE service ADD COLUMN uid_platau_acteur character varying(255) NULL;
COMMENT ON COLUMN service.uid_platau_acteur IS 'Identifant acteur du service consulté dans Plat''AU';

--
-- END / #1112 — [J3] - Tâches concernant les consultations
--

--
-- BEGIN / #1112 — [J3] - Tâches concernant les consultations
--

-- Modification de la table *consultation*
ALTER TABLE consultation
    ADD COLUMN texte_fondement_avis text NULL,
    ADD COLUMN texte_avis text NULL,
    ADD COLUMN texte_hypotheses text NULL,
    ADD COLUMN nom_auteur character varying(255) NULL,
    ADD COLUMN prenom_auteur character varying(255) NULL,
    ADD COLUMN qualite_auteur character varying(255) NULL;
COMMENT ON COLUMN consultation.texte_fondement_avis IS 'Texte indiquant le(s) article(s) réglementaire(s) sur le(s)quel(s) se fonde l''avis';
COMMENT ON COLUMN consultation.texte_avis IS 'Texte qui permet de préciser l''avis, à la manière du texte figurant aujourd''hui sur les avis papier. C''est un moyen de ne pas avoir à annexer de document indiquant ces éléments lorsqu''il n''y a pas besoin de les mettre en forme';
COMMENT ON COLUMN consultation.texte_hypotheses IS 'Texte descriptif des hypothèses sur lesquelles l''avis est rendu lorsque le dossier ne contient pas d''éléments suffisants';
COMMENT ON COLUMN consultation.nom_auteur IS 'Nom de l''auteur de l''avis';
COMMENT ON COLUMN consultation.prenom_auteur IS 'Prénom de l''auteur de l''avis';
COMMENT ON COLUMN consultation.qualite_auteur IS 'Qualité de l''auteur de l''avis';

-- Modification de la table *avis_consultation*
ALTER TABLE avis_consultation
    ADD COLUMN code character varying(10) NULL;
COMMENT ON COLUMN avis_consultation.code IS 'Code unique de l''avis de consultation';
ALTER TABLE ONLY avis_consultation
    ADD CONSTRAINT avis_consultation_code_unique UNIQUE (code);

--
-- END / #1112 — [J3] - Tâches concernant les consultations
--

--
-- BEGIN / #1130 — Gestion du connecteur Parapheur
--

-- Modification de la table instruction
ALTER TABLE instruction
    ADD COLUMN id_parapheur_signature character varying(255) NULL,
    ADD COLUMN statut_signature character varying(255) NULL,
    ADD COLUMN historique_signature text NULL;
COMMENT ON COLUMN instruction.id_parapheur_signature IS 'Identifiant du parapheur lié à l''instruction';
COMMENT ON COLUMN instruction.statut_signature IS 'Statut du parapheur';
COMMENT ON COLUMN instruction.historique_signature IS 'Historique de traitement du parapheur';

-- Modification de la table signataire_arrete
ALTER TABLE signataire_arrete
    ADD COLUMN email character varying(255) NULL;
COMMENT ON COLUMN signataire_arrete.email IS 'E-mail du signataire';

-- Ajout des permissions aux profils pour l'action d'envoi en signature
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'RESPONSABLE DIVISION INFRACTION'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR FONCTIONNEL'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'instruction_envoyer_a_signature', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'instruction_envoyer_a_signature' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'));

--
-- END / #1130 — Gestion du connecteur Parapheur
--

--
-- BEGIN / Permissions pour les types de demandeurs architecte_lc, paysagiste et propriétaire
--

INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'architecte_lc_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'architecte_lc_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'));

INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'paysagiste_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'paysagiste_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'));

INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET UNIQUE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'QUALIFICATEUR'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'DIVISIONNAIRE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR SERVICE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'GUICHET ET SUIVI'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'CHEF DE SERVICE CONTENTIEUX'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_ajouter', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_ajouter' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'));
INSERT INTO om_droit (om_droit, libelle, om_profil) SELECT nextval('om_droit_seq'), 'proprietaire_modifier', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE') WHERE NOT EXISTS (SELECT om_droit FROM om_droit WHERE libelle = 'proprietaire_modifier' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE'));

--
-- END / Permissions pour les types de demandeurs architecte_lc, paysagiste et propriétaire
--

--
-- BEGIN / #1135 — Gestion du connecteur SIG ESRI 
--

-- table sig_couche
CREATE TABLE IF NOT EXISTS sig_couche (
    sig_couche integer NOT NULL,
    libelle character varying(250) NOT NULL,
    id_couche character varying(250) NOT NULL,
    CONSTRAINT sig_couche_pkey PRIMARY KEY (sig_couche)
);
CREATE SEQUENCE IF NOT EXISTS sig_couche_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
COMMENT ON COLUMN sig_couche.sig_couche IS 'Identifiant unique interne.';
COMMENT ON COLUMN sig_couche.libelle IS 'Nom de la couche dans l''interface utilisateur.';
COMMENT ON COLUMN sig_couche.id_couche IS 'Identifiant de la couche dans le sig.';

-- table sig_attribut
CREATE TABLE IF NOT EXISTS sig_attribut (
    sig_attribut integer NOT NULL,
    sig_couche integer NOT NULL,
    libelle character varying(250) NOT NULL,
    identifiant character varying(250) NOT NULL,
    CONSTRAINT sig_attribut_pkey PRIMARY KEY (sig_attribut)
);
CREATE SEQUENCE IF NOT EXISTS sig_attribut_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
COMMENT ON COLUMN sig_attribut.sig_attribut IS 'Identifiant unique interne.';
COMMENT ON COLUMN sig_attribut.sig_couche IS 'Identifiant de la couche de rattachement.';
COMMENT ON COLUMN sig_attribut.libelle IS 'Nom de l''attribut dans l''interface utilisateur.';
COMMENT ON COLUMN sig_attribut.identifiant IS 'Identifiant de l''attribut des objets de la couche.';

ALTER TABLE ONLY sig_attribut
    DROP CONSTRAINT IF EXISTS sig_attribut_sig_couche;
ALTER TABLE ONLY sig_attribut
    ADD CONSTRAINT sig_attribut_sig_couche FOREIGN KEY (sig_couche) REFERENCES sig_couche(sig_couche);

-- table sig_groupe
CREATE TABLE IF NOT EXISTS sig_groupe (
    sig_groupe integer NOT NULL,
    libelle character varying(250) NOT NULL,
    CONSTRAINT sig_groupe_pkey PRIMARY KEY (sig_groupe)
);
CREATE SEQUENCE IF NOT EXISTS sig_groupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN sig_groupe.sig_groupe IS 'Identifiant unique interne.';
COMMENT ON COLUMN sig_groupe.libelle IS 'Libellé du groupe.';

-- table sig_sousgroupe
CREATE TABLE IF NOT EXISTS sig_sousgroupe (
    sig_sousgroupe integer NOT NULL,
    libelle character varying(250) NOT NULL,
    CONSTRAINT sig_sousgroupe_pkey PRIMARY KEY (sig_sousgroupe)
);
CREATE SEQUENCE IF NOT EXISTS sig_sousgroupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN sig_sousgroupe.sig_sousgroupe IS 'Identifiant unique interne.';
COMMENT ON COLUMN sig_sousgroupe.libelle IS 'Libellé du sous-groupe.';

-- table sig_contrainte
CREATE TABLE IF NOT EXISTS sig_contrainte (
    sig_contrainte integer NOT NULL,
    nature character varying(10) NOT NULL,
    groupe integer NOT NULL,
    sousgroupe integer NOT NULL,
    libelle character varying(250) NOT NULL,
    texte text NULL,
    texte_genere text NULL,
    no_ordre integer NULL,
    service_consulte boolean DEFAULT false,
    sig_couche integer NOT NULL,
    CONSTRAINT sig_contrainte_pkey PRIMARY KEY (sig_contrainte)
);
CREATE SEQUENCE IF NOT EXISTS sig_contrainte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN sig_contrainte.sig_contrainte IS 'Identifiant unique interne.';
COMMENT ON COLUMN sig_contrainte.nature IS 'Nature de la contrainte.';
COMMENT ON COLUMN sig_contrainte.groupe IS 'Groupe de la contrainte.';
COMMENT ON COLUMN sig_contrainte.sousgroupe IS 'Sous-groupe de la contrainte.';
COMMENT ON COLUMN sig_contrainte.libelle IS 'Libellé permettant de sélectionnerla contrainte dans l''interface d''ajout.';
COMMENT ON COLUMN sig_contrainte.texte IS 'Texte intégré en texte complété lorsque la contrainte est ajoutée manuellement.';
COMMENT ON COLUMN sig_contrainte.texte_genere IS 'Texte intégré lorsque le texte est renvoyé par une recherche dynamique de contrainte.';
COMMENT ON COLUMN sig_contrainte.no_ordre IS 'Numéro d''ordre d''affichage ou d''impression.';
COMMENT ON COLUMN sig_contrainte.service_consulte IS 'Contrainte affichée aux service consulté.';
COMMENT ON COLUMN sig_contrainte.sig_couche IS 'Sélection de la couche SIG qui porte la contrainte.';

ALTER TABLE ONLY sig_contrainte
    DROP CONSTRAINT IF EXISTS sig_contrainte_sig_groupe;
ALTER TABLE ONLY sig_contrainte
    ADD CONSTRAINT sig_contrainte_sig_groupe FOREIGN KEY (groupe) REFERENCES sig_groupe(sig_groupe);

ALTER TABLE ONLY sig_contrainte
    DROP CONSTRAINT IF EXISTS sig_contrainte_sig_sousgroupe;
ALTER TABLE ONLY sig_contrainte
    ADD CONSTRAINT sig_contrainte_sig_sousgroupe FOREIGN KEY (sousgroupe) REFERENCES sig_sousgroupe(sig_sousgroupe);

ALTER TABLE ONLY sig_contrainte
    DROP CONSTRAINT IF EXISTS sig_contrainte_sig_couche;
ALTER TABLE ONLY sig_contrainte
    ADD CONSTRAINT sig_contrainte_sig_couche FOREIGN KEY (sig_couche) REFERENCES sig_couche(sig_couche);

-- table lien_sig_contrainte_om_collectivite
CREATE TABLE IF NOT EXISTS lien_sig_contrainte_om_collectivite (
    lien_sig_contrainte_om_collectivite integer NOT NULL,
    sig_contrainte integer NOT NULL,
    om_collectivite integer NOT NULL,
    CONSTRAINT lien_sig_contrainte_om_collectivite_pkey PRIMARY KEY (lien_sig_contrainte_om_collectivite)
);
CREATE SEQUENCE IF NOT EXISTS lien_sig_contrainte_om_collectivite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN lien_sig_contrainte_om_collectivite.lien_sig_contrainte_om_collectivite IS 'Identifiant unique interne.';
COMMENT ON COLUMN lien_sig_contrainte_om_collectivite.sig_contrainte IS 'Lien vers la contrainte SIG.';
COMMENT ON COLUMN lien_sig_contrainte_om_collectivite.om_collectivite IS 'Lien vers la collectivité ou le service.';

ALTER TABLE ONLY lien_sig_contrainte_om_collectivite
    DROP CONSTRAINT IF EXISTS lien_sig_contrainte_om_collectivite_sig_contrainte;
ALTER TABLE ONLY lien_sig_contrainte_om_collectivite
    ADD CONSTRAINT lien_sig_contrainte_om_collectivite_sig_contrainte FOREIGN KEY (sig_contrainte) REFERENCES sig_contrainte(sig_contrainte);

ALTER TABLE ONLY lien_sig_contrainte_om_collectivite
    DROP CONSTRAINT IF EXISTS lien_sig_contrainte_om_collectivite_om_collectivite;
ALTER TABLE ONLY lien_sig_contrainte_om_collectivite
    ADD CONSTRAINT sig_contrainte_om_collectivite FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);

-- table lien_sig_contrainte_dossier_instruction_type
CREATE TABLE IF NOT EXISTS lien_sig_contrainte_dossier_instruction_type (
    lien_sig_contrainte_dossier_instruction_type integer NOT NULL,
    sig_contrainte integer NOT NULL,
    dossier_instruction_type integer NOT NULL,
    CONSTRAINT lien_sig_contrainte_dossier_instruction_type_pkey PRIMARY KEY (lien_sig_contrainte_dossier_instruction_type)
);
CREATE SEQUENCE IF NOT EXISTS lien_sig_contrainte_dossier_instruction_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN lien_sig_contrainte_dossier_instruction_type.lien_sig_contrainte_dossier_instruction_type IS 'Identifiant unique interne.';
COMMENT ON COLUMN lien_sig_contrainte_dossier_instruction_type.sig_contrainte IS 'Lien vers la contrainte SIG.';
COMMENT ON COLUMN lien_sig_contrainte_dossier_instruction_type.dossier_instruction_type IS 'Type de dossier d''instruction pour lequel la contrainte est applicable en détection cartographique.';

ALTER TABLE ONLY lien_sig_contrainte_dossier_instruction_type
    DROP CONSTRAINT IF EXISTS lien_sig_contrainte_dossier_instruction_type_sig_contrainte;
ALTER TABLE ONLY lien_sig_contrainte_dossier_instruction_type
    ADD CONSTRAINT lien_sig_contrainte_dossier_instruction_type_sig_contrainte FOREIGN KEY (sig_contrainte) REFERENCES sig_contrainte(sig_contrainte);

ALTER TABLE ONLY lien_sig_contrainte_dossier_instruction_type
    DROP CONSTRAINT IF EXISTS lien_sig_contrainte_dossier_instruction_type_di_type;
ALTER TABLE ONLY lien_sig_contrainte_dossier_instruction_type
    ADD CONSTRAINT sig_contrainte_dossier_instruction_type FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);

-- table lien_sig_contrainte_sig_attribut
CREATE TABLE IF NOT EXISTS lien_sig_contrainte_sig_attribut (
    lien_sig_contrainte_sig_attribut integer NOT NULL,
    sig_contrainte integer NOT NULL,
    sig_attribut integer NOT NULL,
    valeur character varying(250) NOT NULL,
    CONSTRAINT lien_sig_contrainte_sig_attribut_pkey PRIMARY KEY (lien_sig_contrainte_sig_attribut)
);
CREATE SEQUENCE IF NOT EXISTS lien_sig_contrainte_sig_attribut_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

COMMENT ON COLUMN lien_sig_contrainte_sig_attribut.lien_sig_contrainte_sig_attribut IS 'Identifiant unique interne.';
COMMENT ON COLUMN lien_sig_contrainte_sig_attribut.sig_contrainte IS 'Lien vers la contrainte SIG.';
COMMENT ON COLUMN lien_sig_contrainte_sig_attribut.sig_attribut IS 'Lien vers l''attribut SIG.';
COMMENT ON COLUMN lien_sig_contrainte_sig_attribut.valeur IS 'Valeur permettant l''application de la contrainte.';

ALTER TABLE ONLY lien_sig_contrainte_sig_attribut
    DROP CONSTRAINT IF EXISTS lien_sig_contrainte_sig_attribut_sig_contrainte;
ALTER TABLE ONLY lien_sig_contrainte_sig_attribut
    ADD CONSTRAINT lien_sig_contrainte_sig_attribut_sig_contrainte FOREIGN KEY (sig_contrainte) REFERENCES sig_contrainte(sig_contrainte);

ALTER TABLE ONLY lien_sig_contrainte_sig_attribut
    DROP CONSTRAINT IF EXISTS lien_sig_contrainte_sig_attribut_sig_attribut;
ALTER TABLE ONLY lien_sig_contrainte_sig_attribut
    ADD CONSTRAINT sig_contrainte_sig_attribut FOREIGN KEY (sig_attribut) REFERENCES sig_attribut(sig_attribut);


-- Ajout des droits pour pouvoir accéder aux interfaces

--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_groupe', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_groupe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_sousgroupe', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_sousgroupe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_contrainte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_contrainte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_attribut', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_attribut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_couche', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_couche' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lien_sig_contrainte_sig_attribut', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_sig_contrainte_sig_attribut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);


INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_groupe', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_groupe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_sousgroupe', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_sousgroupe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_contrainte', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_contrainte' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_attribut', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_attribut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'sig_couche', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'sig_couche' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'lien_sig_contrainte_sig_attribut', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'lien_sig_contrainte_sig_attribut' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR GENERAL')
);

--
ALTER TABLE sig_contrainte ALTER COLUMN sousgroupe DROP NOT NULL;

--
-- END / #1135 — Gestion du connecteur SIG ESRI 
--
